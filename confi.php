<?php
session_start();

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit();
}

include("db.php");

$paymentMethod = $_POST['payment-method'] ?? '';
$chevalet = isset($_POST['chevalet']) ? (int)$_POST['chevalet'] : null;

if ($_SESSION['method'] === 'sur place') {
    if ($chevalet === null || $chevalet < 1 || $chevalet > 20) {
        echo "Numéro de chevalet invalide. Veuillez saisir un numéro entre 1 et 20.";
        exit();
    }
}

try {
    $pdo->beginTransaction();

    $totalPoints = 0;
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalPoints += isset($item['points']) ? $item['points'] * $item['quantity'] : 0; // Calcul des points du produit
        $totalPrice += $item['price'] * $item['quantity']; // Calcul du prix total de la commande
    }

    // Insertion de la commande dans la table `orders`
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, total_price, modeService, getCommande, PaymentMethod, paymentStatus, chevalet) 
        VALUES (:user_id, :total_price, :modeService, 'borne', :payment_method, 'Validé', :chevalet)
    ");
    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':total_price' => $totalPrice,
        ':modeService' => $_SESSION['method'],
        ':payment_method' => $paymentMethod,
        ':chevalet' => $chevalet
    ]);

    $orderId = $pdo->lastInsertId();
    $_SESSION['order_id'] = $orderId;

    // Insérer les éléments de commande dans la table `order_items`
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
            ':sauces' => $item['sauce'] ?? NULL,
            ':crudites' => $item['crudites'] ?? NULL,
            ':boisson' => $item['boisson'] ?? NULL
        ]);
    }

    // Ajouter les points calculés à l'utilisateur
    if ($totalPoints > 0) {
        $stmt = $pdo->prepare("UPDATE user_points SET points = points + :totalPoints WHERE user_id = :user_id");
        $stmt->execute([
            ':totalPoints' => $totalPoints,
            ':user_id' => $_SESSION['user_id']
        ]);
    }

    // Si la session a des points à déduire (points déjà utilisés), les déduire également
    if (isset($_SESSION['temp_points_deduction'])) {
        $stmt = $pdo->prepare("UPDATE user_points SET points = points - 150 WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        unset($_SESSION['temp_points_deduction']);
    }

    $pdo->commit();

    // Vider le panier et autres sessions liées après la commande
    unset($_SESSION['cart']);
    unset($_SESSION['method']);

    header("Location: success.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erreur lors du traitement de la commande : " . $e->getMessage();
}
