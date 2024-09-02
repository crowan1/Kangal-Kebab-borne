<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = isset($_POST['index']) ? intval($_POST['index']) : -1;

    if ($index >= 0 && isset($_SESSION['cart'][$index])) {
        
        array_splice($_SESSION['cart'], $index, 1);
        echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Index invalide']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête invalide']);
}
?>
