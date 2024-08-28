<?php
session_start();
require "./db.php";
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([2]);
$user = $stmt->fetch();

var_dump($user);


if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_type'] = 'connecter'; 

    header("Location: choice.php");
    exit;
} else {
    echo "<script>alert('Identifiant incorrect.');</script>";
}