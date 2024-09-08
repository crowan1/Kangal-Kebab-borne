<?php

session_start();

if (isset($_SESSION['temp_points_deduction']) && $_SESSION['temp_points_deduction'] === 150) {
    // Restaurer les points dans la session (pas besoin de restaurer en base car ils n'ont jamais été déduits définitivement)
    unset($_SESSION['temp_points_deduction']);
}



session_unset();
session_destroy();

header(("Location: index.php"));
exit();

?>