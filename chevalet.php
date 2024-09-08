<?php
session_start();

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit();
}

if ($_SESSION['method'] !== 'place') {
    header("Location: menu.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numéro de Chevalet</title>
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
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .banniere {
            position: absolute;
            top: 0;
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
            text-align: center;
            font-size: 3vh;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container {
            position: absolute;
            top: 40%;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        label {
            font-size: 1.2em;
            margin-bottom: 10px;
            text-align: left;
            color: #333;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }

        button {
            padding: 12px 20px;
            background-color: #FFBB25;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
        }

        button:hover {
            background-color: #e6a623;
        }

        #button-back {
            position: absolute;
            top: 70%;
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
            font-size: 20px;
            color: white;
            background-color: #FFBB25;
            padding: 10px 20px;
            border-radius: 5px;
        }

        #button-back a:hover {
            background-color: #e6a623;
        }
    </style>
</head>
<body>

<div class="banniere">
    <img src="img/1.jpg" alt="Image 1">
    <img src="img/2.jpg" alt="Image 2">
    <img src="img/3.jpg" alt="Image 3">
</div>

<div class="form-container">
    <h1>Entrer votre Numéro de Chevalet</h1>
    <form action="confi.php" method="post">
        <label for="chevalet">Numéro de Chevalet (1-20) :</label>
        <input type="number" name="chevalet" id="chevalet" min="1" max="20" required>
        <button type="submit">Confirmer</button>
    </form>
</div>

<div id="button-back">
    <a href="payment.php" class="btn-back">Retour au Paiement</a>
</div>

</body>
</html>
