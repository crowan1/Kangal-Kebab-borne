<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = json_decode(file_get_contents('php://input'), true);

    if (is_array($cart)) {
 
        foreach ($cart as &$item) {
            if (!isset($item['id']) || !isset($item['quantity']) || !isset($item['price'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
                exit();
            }
 
            $item['id'] = intval($item['id']);
            $item['quantity'] = intval($item['quantity']);
            $item['price'] = floatval(preg_replace('/[^\d.]/', '', $item['price']));
        }

    
        $_SESSION['cart'] = $cart;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
    }
    exit;
}
