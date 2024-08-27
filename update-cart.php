<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = floatval($_POST['product_price']);

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product_id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1
            ];
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'clear') {
        $_SESSION['cart'] = [];
    }

    header('Content-Type: application/json');
    echo json_encode(['cart' => $_SESSION['cart']]);
}
?>
