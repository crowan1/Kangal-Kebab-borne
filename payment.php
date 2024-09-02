<?php
session_start(); 

if(!isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])){
    header("location: ./index.php"); 
    exit; 
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Votre panier est vide. Veuillez retourner au menu et ajouter des articles à votre panier.</p>";
    echo '<a href="menu.php" class="btn btn-primary">Retourner au menu</a>';
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            font-weight: 800;
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

        h1 {
            display: flex;
            justify-content: center;
            font-size: 5vh;
            margin-top: 50px;
        }

        .container-payment {
            flex: 1;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 40vh; 
            padding: 20px;
        }

        .buttonChoix {
            background-color: #FFBB25;
            height: 200px; 
            width: 350px; 
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            cursor: pointer;
            border: none; 
        }

        .buttonChoix img {
            margin-right: 10px;
            width: 10vh; 
            margin-bottom: 15px;
        }

        .buttonChoix.disabled {
            cursor: not-allowed;
            background-color: rgba(128, 128, 128, 0.5); /* Fond gris avec 50% de transparence */
            opacity: 0.6;
            position: relative;
        }

        .buttonChoix.disabled img {
            filter: grayscale(100%);
        }

        .buttonChoix.disabled .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2vh;
            font-weight: 900;
            z-index: 2;
            text-align: center;
        }

        #button-back {
            font-family: 'Roboto';
            font-weight: 800;
            display: flex;
            margin: auto;
            margin-top: 15px;
            justify-content: center;
            width: 25vh;
        }
    </style>
</head>
<body>

    <div class="banniere">
        <img src="img/1.jpg" alt="Image 1">
        <img src="img/2.jpg" alt="Image 2">
        <img src="img/3.jpg" alt="Image 3">
    </div>

    <h1>Confirmation de Paiement</h1>
    <p style="text-align: center;">Total du panier : <?php echo number_format($total, 2, ',', ' '); ?>€</p>

    <div class="container-payment">
        <div class="buttonChoix disabled">
            <div class="overlay-text">Bientôt disponible !</div>
            <img src="img/icons/carte-bancaire.png" alt="Carte Bleue">
            <span>Payer par Carte Bleue</span>
        </div>
        
        <form action="confi.php" method="post">
            <button type="submit" name="payment-method" value="cash" class="buttonChoix">
                <img src="img/icons/en-especes.png" alt="Espèces">
                <span>Payer en Borne</span>
            </button>
        </form>
    </div>

    <div id="button-back">
        <a href="menu.php" class="btn btn-secondary">Retour au Panier</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
