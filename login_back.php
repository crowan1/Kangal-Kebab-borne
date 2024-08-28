<?php 

session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "./db.php"; 
    $pdo = new PDO('mysql:host=localhost;dbname=kangalkebab', 'root', 'root');

    $code = $_POST['code'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE code = :code OR email = :code");
    $stmt->execute(['code' => $code]);
    $user = $stmt->fetch();

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
}