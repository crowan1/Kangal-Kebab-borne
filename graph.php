<?php
// Connexion à la base de données
include("db.php");

// Récupérer les dates de filtre depuis le formulaire ou utiliser une plage par défaut (3 derniers mois)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01', strtotime('-3 months'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Récupérer le nombre de commandes par mois pour la période sélectionnée
$query = $pdo->prepare("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month, 
        COUNT(DISTINCT id) as total_orders
    FROM orders
    WHERE DATE(created_at) BETWEEN :start_date AND :end_date
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month ASC
");
$query->execute([
    'start_date' => $start_date,
    'end_date' => $end_date
]);
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des tableaux pour stocker les données
$months = [];
$total_orders = [];

foreach ($data as $row) {
    $months[] = $row['month'];
    $total_orders[] = $row['total_orders'];
}

// Créer le graphique
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_bar.php');

// Création du graphique
$graph = new Graph(800,400);
$graph->SetScale("textlin");
$graph->SetMargin(60,20,46,80);

$theme_class = new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTitle("Nombre de commandes");
$graph->xaxis->SetTickLabels($months);
$graph->xaxis->SetLabelAngle(45); // Rotation des étiquettes des mois

// Création des barres pour le nombre de commandes
$b1plot = new BarPlot($total_orders);
$b1plot->SetLegend("Nombre de commandes");
$b1plot->SetFillColor("#007bff");

// Ajouter la barre au graphique
$graph->Add($b1plot);

// Légendes
$graph->legend->SetPos(0.5,0.97,'center','bottom');
$graph->legend->SetColumns(1);

// Titre
$graph->title->Set("Nombre de commandes par mois");

// Afficher le graphique
$graph->Stroke();
?>
