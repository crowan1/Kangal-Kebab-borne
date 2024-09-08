<?php
session_start();
include("db.php");

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté.']);
    exit();
}

// Vérifier que l'utilisateur a suffisamment de points
$stmt = $pdo->prepare("SELECT points FROM user_points WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$userPoints = $stmt->fetch(PDO::FETCH_ASSOC);

$points = $userPoints ? $userPoints['points'] : 0;
$tempPoints = isset($_SESSION['temp_points_deduction']) ? $_SESSION['temp_points_deduction'] : 0;

if ($points - $tempPoints < 150) {
    echo json_encode(['status' => 'error', 'message' => 'Vous n\'avez pas assez de points.']);
    exit();
}

$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$crudites = isset($_POST['crudites']) ? implode(', ', $_POST['crudites']) : NULL;
$sauce = isset($_POST['sauce']) ? implode(', ', $_POST['sauce']) : NULL;
$boisson = isset($_POST['boisson']) ? $_POST['boisson'] : NULL;

if ($productId === 19) {  // ID du menu kebab gratuit
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Vérifier si le kebab est déjà dans le panier
    $kebabExists = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] === 19) {
            $kebabExists = true;
            break;
        }
    }

    if (!$kebabExists) {
        // Ajouter le menu kebab gratuit au panier
        $_SESSION['cart'][] = [
            'id' => $productId,
            'name' => 'Menu Kebab Gratuit',
            'price' => 0.00,
            'quantity' => 1,
            'crudites' => $crudites,
            'sauce' => $sauce,
            'boisson' => $boisson
        ];

        // Retirer temporairement 150 points de la session
        $_SESSION['temp_points_deduction'] = 150;
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Produit non valide.']);
}
