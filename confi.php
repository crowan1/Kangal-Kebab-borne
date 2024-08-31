<?php
session_start(); 

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    header("Location: ./index.php"); 
    exit(); 
}
include("db.php");

$paymentMethod = $_POST['payment-method'] ?? '';

if ($paymentMethod === 'cash' || $paymentMethod === 'card') {
    try {

        $pdo->beginTransaction();

        $totalPoints = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalPoints += $item['points'] * $item['quantity'];
        }

        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_price, modeService, getCommande, PaymentMethod) 
            VALUES (:user_id, :total_price, :modeService, 'borne', :payment_method)
        ");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':total_price' => array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $_SESSION['cart'])),
            ':modeService' => $_SESSION['method'], 
            ':payment_method' => $paymentMethod 
        ]);

        $orderId = $pdo->lastInsertId();

        foreach ($_SESSION['cart'] as $item) {
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price, sauces, crudites, boisson) 
                VALUES (:order_id, :product_id, :quantity, :price, :sauces, :crudites, :boisson)
            ");
            $stmt->execute([
                ':order_id' => $orderId,
                ':product_id' => $item['id'],
                ':quantity' => $item['quantity'],
                ':price' => $item['price'],
                ':sauces' => $item['sauce'] ?? NULL, // Sauvegarde de la sauce sélectionnée
                ':crudites' => $item['crudites'] ?? NULL, // Sauvegarde des crudités sélectionnées
                ':boisson' => $item['boisson'] ?? NULL // Sauvegarde de la boisson sélectionnée
            ]);
        }

        $pdo->commit();

        unset($_SESSION['cart']);
        unset($_SESSION['method']);

        session_unset();
        session_destroy();
       
        header("Location: success.php");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur lors du traitement de la commande : " . $e->getMessage();
    }
} else {
    echo "Méthode de paiement invalide.";
}
