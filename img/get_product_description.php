<?php
include("db.php");

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);

    $stmt = $pdo->prepare("SELECT description FROM products WHERE id = :id");
    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        echo json_encode(['status' => 'success', 'description' => $product['description']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
}
