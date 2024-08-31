<?php
session_start();
include("db.php");  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $crudites = isset($_POST['crudites']) ? implode(', ', $_POST['crudites']) : NULL;
    $sauce = isset($_POST['sauce']) ? implode(', ', $_POST['sauce']) : NULL;
    $boisson = isset($_POST['boisson']) ? $_POST['boisson'] : NULL;

    if ($productId > 0 && $quantity > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $stmt = $pdo->prepare("SELECT id, name, price, points FROM products WHERE id = :id");
        $stmt->execute([':id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) { 
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'points' => $product['points'],
                    'quantity' => $quantity,
                    'crudites' => $crudites,
                    'sauce' => $sauce,
                    'boisson' => $boisson
                ];
            }

            echo json_encode(['status' => 'success', 'message' => 'Produit ajouté au panier']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Produit non trouvé']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
}
