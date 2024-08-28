<?php
session_start();

 
$order_id = $_SESSION['order_id'] ?? 'N/A';

 
if ($order_id === 'N/A') {
    $order_id = 'un numéro de commande généré';
}

 
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Réussie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .banniere {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            height: 250px;
            background-color: #B20F0F;
        }

        .banniere img {
            width: 30%;
            height: 100%;
            object-fit: cover;
        }

        .container-success {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .success-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .success-box h2 {
            margin-bottom: 20px;
            font-weight: 900;
            color: #333;
        }

        .success-box p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn-home {
            background-color: #FFB000;
            color: #fff;
            font-weight: 700;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 18px;
        }

        .btn-home:hover {
            background-color: #e09e00;
        }

        @media (max-width: 576px) {
            .banniere {
                height: 150px;
            }

            .banniere img {
                width: 33.33%;
            }

            .success-box {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="banniere">
        <img src="img/1.jpg" alt="Image 1">
        <img src="img/2.jpg" alt="Image 2">
        <img src="img/3.jpg" alt="Image 3">
    </div>

    <div class="container-success">
        <div class="success-box">
            <h2>Merci pour votre commande !</h2>
            <p>Votre commande numéro <strong><?php echo htmlspecialchars($order_id); ?></strong> a été enregistrée avec succès.</p>
            <p>Vous allez être redirigé vers la page d'accueil dans quelques secondes.</p>
            <a href="index.php" class="btn-home">Retour à l'accueil</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        // Redirection vers la page d'accueil après 5 secondes
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>
</body>
</html>
