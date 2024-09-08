<?php
session_start();

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit();
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


if ($total == 0) {
    header("Location: confi.php");
    exit();
}
?>

<body>

<div class="banniere">
    <img src="img/1.jpg" alt="Image 1">
    <img src="img/2.jpg" alt="Image 2">
    <img src="img/3.jpg" alt="Image 3">
</div>

<h1>Confirmation de Paiement</h1>
<p style="text-align: center;" id="total-basket">Total du panier : <?php echo number_format($total, 2, ',', ' '); ?>€</p>

<div class="container-payment">
    <div class="buttonChoix disabled">
        <div class="overlay-text">Bientôt disponible !</div>
        <img src="img/icons/carte-bancaire.png" alt="Carte Bleue">
        <span>Payer par Carte Bleue</span>
    </div>

    <form action="chevalet.php" method="post">

        <?php if ($_SESSION['method'] == 'place'): ?>
            <input type="hidden" name="payment-method" value="cash">
            <button type="submit" class="buttonChoix">
                <img src="img/icons/en-especes.png" alt="Espèces">
                <span>Payer en Borne (Cash)</span>
            </button>
        <?php else: ?>

            <input type="hidden" name="payment-method" value="cash">
            <button type="submit" formaction="confi.php" class="buttonChoix">
                <img src="img/icons/en-especes.png" alt="Espèces">
                <span>Payer en Borne (Cash)</span>
            </button>
        <?php endif; ?>
    </form>
</div>

<div id="button-back">
    <a href="menu.php" class="btn-back">Retour au Panier</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


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

        #total-basket {
            font-size: 30px;
        }

        .banniere {
            display: flex;
    justify-content: space-around;
    width: 100%;
    height: 250px;
    background-color: #B20F0F;
        }

        .banniere img {
            width: 33.33% !important;
            object-fit: contain;
        }

        h1 {
            display: flex;
            justify-content: center;
            font-size: 5vh;
            margin-top: 50px;
        }

        .container-payment {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 40vh; 
            padding: 20px;
        }

        .buttonChoix {
            background-color: #FFBB25;
            height: 250px; 
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
            background-color: rgba(128, 128, 128, 0.5);
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

        #button-back a {
            text-decoration: none;
            font-size: 30px;
            color: white;
            background-color: #FFBB25;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
