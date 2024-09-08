<?php
// Connexion à la base de données
include("db.php");

// Récupérer la date actuelle
$today = date('Y-m-d');
$current_month_start = date('Y-m-01'); // Premier jour du mois en cours

// Filtre pour les commandes (premier tableau) - Par défaut, c'est le jour actuel
$start_date_orders = isset($_GET['start_date_orders']) ? $_GET['start_date_orders'] : $today;
$end_date_orders = isset($_GET['end_date_orders']) ? $_GET['end_date_orders'] : $today;

// Filtre pour les statistiques générales (deuxième tableau) - Par défaut, c'est le mois actuel
$start_date_stats = isset($_GET['start_date_stats']) ? $_GET['start_date_stats'] : $current_month_start;
$end_date_stats = isset($_GET['end_date_stats']) ? $_GET['end_date_stats'] : $today;

// Filtre pour le graphique (chiffre d'affaires) - Par défaut, c'est aussi le mois actuel
$start_date_graph = isset($_GET['start_date_graph']) ? $_GET['start_date_graph'] : $current_month_start;
$end_date_graph = isset($_GET['end_date_graph']) ? $_GET['end_date_graph'] : $today;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord - Ventes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        form label, form input, form button {
            margin: 0 10px;
        }
        form input {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            padding: 6px 12px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        form button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Tableau de bord - Ventes</h1>

    <!-- Formulaire de filtre pour les commandes -->
    <h2>Filtre pour les commandes</h2>
    <form method="GET">
        <label for="start_date_orders">Date de début :</label>
        <input type="date" id="start_date_orders" name="start_date_orders" value="<?php echo $start_date_orders; ?>">
        <label for="end_date_orders">Date de fin :</label>
        <input type="date" id="end_date_orders" name="end_date_orders" value="<?php echo $end_date_orders; ?>">
        <button type="submit">Filtrer les commandes</button>
    </form>

    <!-- Premier tableau : Statistiques des commandes (du jour actuel par défaut) -->
   
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Nombre de produits vendus</th>
                <th>Nombre de commandes</th>
                <th>Chiffre d'affaires (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Requête pour récupérer les commandes sur la plage de dates
            if ($start_date_orders == $end_date_orders) {
                // Afficher les commandes du jour actuel
                $query_orders = $pdo->prepare("
                    SELECT 
                        DATE(created_at) as date,
                        COUNT(DISTINCT id) as total_orders,
                        SUM(total_price) as total_sales,
                        SUM(
                            (SELECT SUM(quantity) FROM order_items WHERE order_id = orders.id)
                        ) as total_products_sold
                    FROM orders
                    WHERE DATE(created_at) = :start_date_orders
                    GROUP BY DATE(created_at)
                ");
                $query_orders->execute(['start_date_orders' => $start_date_orders]);
            } else {
                // Afficher les totaux sur la période
                $query_orders = $pdo->prepare("
                    SELECT 
                        COUNT(DISTINCT id) as total_orders,
                        SUM(total_price) as total_sales,
                        SUM(
                            (SELECT SUM(quantity) FROM order_items WHERE order_id = orders.id)
                        ) as total_products_sold
                    FROM orders
                    WHERE DATE(created_at) BETWEEN :start_date_orders AND :end_date_orders
                ");
                $query_orders->execute([
                    'start_date_orders' => $start_date_orders,
                    'end_date_orders' => $end_date_orders
                ]);
            }

            // Affichage des résultats
            while ($row = $query_orders->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>" . ($start_date_orders == $end_date_orders ? date('d/m/Y', strtotime($start_date_orders)) : "Total du ". date('d/m/Y', strtotime($start_date_orders)) ." au ". date('d/m/Y', strtotime($end_date_orders))) . "</td>
                    <td class='center'>{$row['total_products_sold']}</td>
                    <td class='center'>{$row['total_orders']}</td>
                    <td class='center'>{$row['total_sales']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Formulaire de filtre pour les statistiques générales -->
    <h2>Filtre pour les statistiques générales</h2>
    <form method="GET">
        <label for="start_date_stats">Date de début :</label>
        <input type="date" id="start_date_stats" name="start_date_stats" value="<?php echo $start_date_stats; ?>">
        <label for="end_date_stats">Date de fin :</label>
        <input type="date" id="end_date_stats" name="end_date_stats" value="<?php echo $end_date_stats; ?>">
        <button type="submit">Filtrer les statistiques</button>
    </form>

    <!-- Deuxième tableau : Statistiques générales (du mois actuel par défaut) -->
    
    <table>
        <thead>
            <tr>
                <th>Nombre d'utilisateurs</th>
                <th>Produit le plus vendu</th>
                <th>Produit le moins vendu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Requête pour compter les utilisateurs
            $user_count_query = $pdo->query("SELECT COUNT(*) as total_users FROM users");
            $user_count = $user_count_query->fetch(PDO::FETCH_ASSOC)['total_users'];

            // Requête pour le produit le plus vendu et le moins vendu sur la période sélectionnée
            $products_query = $pdo->prepare("
                SELECT p.name, SUM(oi.quantity) as total_sold
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE DATE(o.created_at) BETWEEN :start_date_stats AND :end_date_stats
                GROUP BY oi.product_id
                ORDER BY total_sold DESC
            ");
            $products_query->execute([
                'start_date_stats' => $start_date_stats,
                'end_date_stats' => $end_date_stats
            ]);

            $most_sold_product = $products_query->fetch(PDO::FETCH_ASSOC);
            $products_query->execute(); // Re-execute to get the least sold product
            $least_sold_product = array_reverse($products_query->fetchAll(PDO::FETCH_ASSOC))[0];

            echo "<tr>
                <td class='center'>{$user_count}</td>
                <td class='center'>{$most_sold_product['name']} ({$most_sold_product['total_sold']} vendus)</td>
                <td class='center'>{$least_sold_product['name']} ({$least_sold_product['total_sold']} vendus)</td>
            </tr>";
            ?>
        </tbody>
    </table>


    <h1>Filtrer les ventes par mois</h1>


<!-- Formulaire de filtre par date -->
<form action="graph.php" method="GET">
    <label for="start_date">Date de début :</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-01', strtotime('-3 months')); ?>">

    <label for="end_date">Date de fin :</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">

    <button type="submit">Filtrer</button>
</form>

<h2>Graphique des commandes</h2>
<!-- Graphique généré -->
<img src="graph.php?start_date=<?php echo date('Y-m-01', strtotime('-3 months')); ?>&end_date=<?php echo date('Y-m-d'); ?>" alt="Graphique du nombre de commandes par mois">

</body>
</html>
