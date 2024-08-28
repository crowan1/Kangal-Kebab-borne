<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$response = [
    'cart' => array_values($_SESSION['cart'])
];

header('Content-Type: application/json');
echo json_encode($response);
