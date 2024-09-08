<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = intval($_POST['index']);
    
    if (isset($_SESSION['cart'][$index])) {
        // Supprime l'élément du panier
        unset($_SESSION['cart'][$index]);

        // Ré-indexer le panier pour éviter des trous dans l'indexation
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Article non trouvé dans le panier']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
}
?>
