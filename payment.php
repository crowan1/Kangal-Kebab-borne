<?php
session_start(); 

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $cartData = $_POST['cart-data'] ?? '[]';
//     $cart = json_decode($cartData, true);

//     // if (empty($cart)) {
//     //     header('Location: basket.php');
//     //     exit();
//     // }

//     $total = 0;
//     foreach ($cart as $item) {
//         $total += $item['price'];
//     }
// } else {
//     header('Location: basket.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
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

        .container-payment {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .payment-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .payment-box h1 {
            margin-bottom: 20px;
            font-weight: 900;
            color: #333;
        }

        .payment-box p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .payment-options div {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .payment-options button {
            background-color: #FFB000;
            color: #fff;
            font-weight: 700;
            padding: 12px;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
            width: 200px;
            font-size: 18px;
        }

        .payment-options img {
            width: 50px;
            margin-right: 10px;
        }

        .payment-options button:hover {
            background-color: #e09e00;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        @media (max-width: 576px) {
            .banniere {
                height: 150px;
            }

            .banniere img {
                width: 33.33%;
            }

            .payment-box {
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

    <div class="container-payment">
        <div class="payment-box">
            <h1>Confirmation de Paiement</h1>
            <p>Total du panier : <?php echo number_format($total, 2, ',', ' '); ?>€</p>

            <!-- todo 

            payer en espece :  href="confirmation.php?method=espece"
            payer par carte :  href="confirmation.php?method=carte"
            
            -->
            <div class="payment-options">
                <form action="confirm.php" method="post">
                    <!-- <input type="hidden" name="cart-data" value='<?php echo htmlspecialchars(json_encode($cart)); ?>'>
                    <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>"> -->

                    <div>
                        <img src="img/icons/paiement-par-carte-de-credit.png" alt="Carte Bleue">
                        <button type="submit" name="payment-method" value="card">Payer par Carte Bleue</button>
                    </div>
                    
                    <div>
                        <img src="img/icons/en-especes.png" alt="Espèces">
                        <button type="submit" name="payment-method" value="cash">Payer en Espèces</button>
                    </div>
                </form>
                <a href="basket.php" class="btn btn-secondary mt-3">Retour au Panier</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
