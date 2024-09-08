<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $crudites = isset($_POST['crudites']) ? implode(', ', $_POST['crudites']) : NULL;
    $sauce = isset($_POST['sauce']) ? implode(', ', $_POST['sauce']) : NULL;
    $boisson = isset($_POST['boisson']) ? $_POST['boisson'] : NULL;
    $supplements = isset($_POST['supplements']) ? $_POST['supplements'] : [];
    $additionalSaucePrice = 0.50;
    $supplementCheesePrice = 1;
    $supplementViandePrice = 1;

    if ($productId > 0 && $quantity > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $stmt = $pdo->prepare("SELECT id, name, price, points FROM products WHERE id = :id");
        $stmt->execute([':id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $extraCost = 0;

            // Gestion des sauces supplémentaires
            if (!empty($sauce)) {
                $sauces = explode(', ', $sauce);
                if (count($sauces) > 2) {
                    $extraCost = (count($sauces) - 2) * $additionalSaucePrice;
                }
            }

            // Ajout des suppléments cheese et viande
            if (in_array('cheese', $supplements)) {
                $extraCost += $supplementCheesePrice;
            }
            if (in_array('viande', $supplements)) {
                $extraCost += $supplementViandePrice;
            }
            if (in_array('feta', $supplements)) {  
                $extraCost += $supplementFetaPrice;
            }
            

            $finalPrice = $product['price'] + $extraCost;

            $isSameProduct = false;
            foreach ($_SESSION['cart'] as &$item) {
                if (
                    $item['id'] == $productId &&
                    $item['crudites'] === $crudites &&
                    $item['sauce'] === $sauce &&
                    $item['boisson'] === $boisson &&
                    $item['supplements'] === implode(', ', $supplements)
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
                    'boisson' => $boisson,
                    'supplements' => implode(', ', $supplements) // Enregistrer les suppléments
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
