<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Supprimer le kebab gratuit du panier
foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] === 19) {  // ID du menu kebab gratuit
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);  // Réindexer le panier
        break;
    }
}

// Restaurer les points temporairement déduits
if (isset($_SESSION['temp_points_deduction'])) {
    unset($_SESSION['temp_points_deduction']);
}

header("Location: menu.php");
exit();
