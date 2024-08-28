<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($productId > 0 && $quantity > 0) {
       
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        
        if (isset($_SESSION['panier'][$productId])) {
            $_SESSION['panier'][$productId] += $quantity;
        } else {
            $_SESSION['panier'][$productId] = $quantity;
        }

        // Réponse pour indiquer que le produit a été ajouté avec succès
        echo json_encode(['status' => 'success', 'message' => 'Produit ajouté au panier']);
    } else {
        // Réponse en cas d'erreur de données
        echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
    }
} else {
    // Réponse en cas de méthode incorrecte
    echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
}
?>
