<?php
session_start();

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
exit; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartData = $_POST['cart-data'] ?? '[]';
    $cart = json_decode($cartData, true);
} else {
    $cart = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

        .container-basket {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .basket-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .basket-box h1 {
            margin-bottom: 20px;
            font-weight: 900;
            color: #333;
            text-align: center;
        }

        .basket-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .basket-item h4 {
            margin: 0 0 10px;
            font-weight: 700;
        }

        .basket-item p {
            margin: 0;
            color: #555;
        }

        .btn-submit {
            background-color: #FFBB25;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        .btn-submit:hover {
            background-color: #ffa31a;
        }

        .button-left-basket {
            display: block;
            text-align: center;
            background-color: #FFBB25;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .button-left-basket:hover {
            background-color: #ffa31a;
        }

        @media (max-width: 576px) {
            .banniere {
                height: 150px;
            }

            .banniere img {
                width: 33.33%;
            }

            .basket-box {
                padding: 20px;
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

    <div class="container-basket">
        <div class="basket-box">
            <h1>Votre Panier</h1>
            <?php if (empty($cart)): ?>
                <p>Votre panier est vide.</p>
            <?php else: ?>
                <form action="payment.php" method="post">
                    <input type="hidden" name="cart-data" value='<?php echo htmlspecialchars(json_encode($cart)); ?>'>
                    <?php foreach ($cart as $item): ?>
                        <div class="basket-item">
                            <h4><?php echo htmlspecialchars($item['name']); ?> - <?php echo number_format($item['price'], 2); ?>€</h4>
                            <p><strong>Quantité:</strong> <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <?php if (!empty($item['supplements'])): ?>
                                <p><strong>Suppléments:</strong> <?php echo htmlspecialchars(implode(', ', $item['supplements'])); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['sauces'])): ?>
                                <p><strong>Sauces:</strong> <?php echo htmlspecialchars(implode(', ', $item['sauces'])); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['crudites'])): ?>
                                <p><strong>Crudités:</strong> <?php echo htmlspecialchars(implode(', ', $item['crudites'])); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['boisson'])): ?>
                                <p><strong>Boisson:</strong> <?php echo htmlspecialchars($item['boisson']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn-submit">Aller au Paiement</button>
                </form>
            <?php endif; ?>
            <a class="button-left-basket" href="menu.php">Continuer de commander</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
