<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $crudites = isset($_POST['crudites']) ? implode(', ', $_POST['crudites']) : NULL;
    $sauce = isset($_POST['sauce']) ? implode(', ', $_POST['sauce']) : NULL;
    $boisson = isset($_POST['boisson']) ? $_POST['boisson'] : NULL;
    $additionalSaucePrice = 0.50;

    if ($productId > 0 && $quantity > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $stmt = $pdo->prepare("SELECT id, name, price, points FROM products WHERE id = :id");
        $stmt->execute([':id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $extraCost = 0;
            if (!empty($sauce)) {
                $sauces = explode(', ', $sauce);
                if (count($sauces) > 2) {
                    $extraCost = (count($sauces) - 2) * $additionalSaucePrice;
                }
            }

            $finalPrice = $product['price'] + $extraCost;

            $isSameProduct = false;
            foreach ($_SESSION['cart'] as &$item) {
                if (
                    $item['id'] == $productId &&
                    $item['crudites'] === $crudites &&
                    $item['sauce'] === $sauce &&
                    $item['boisson'] === $boisson
                ) {
                    $item['quantity'] += $quantity;
                    $isSameProduct = true;
                    break;
                }
            }

            if (!$isSameProduct) {
                $_SESSION['cart'][] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $finalPrice,
                    'points' => $product['points'],
                    'quantity' => $quantity,
                    'crudites' => $crudites,
                    'sauce' => $sauce,
                    'boisson' => $boisson
                ];
            }

            echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Produit non trouvé']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de produit ou quantité invalide']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête invalide']);
}
