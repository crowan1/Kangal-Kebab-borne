<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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

        .container-login {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 30px;
            font-weight: 900;
            color: #333;
        }

        .form-control {
            height: 50px;
            font-size: 16px;
        }

        .btn-login {
            background-color: #FFB000;
            color: #fff;
            font-weight: 700;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 18px;
        }

        .btn-login:hover {
            background-color: #e09e00;
        }

        @media (max-width: 576px) {
            .banniere {
                height: 150px;
            }

            .banniere img {
                width: 33.33%;
            }

            .login-box {
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

    <div class="container-login">
        <div class="login-box">
            <h2>Se connecter</h2>
            <form id="loginForm" action="./login_back.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="code" placeholder="Entrez votre code ou email" required>
                </div>
                <button type="submit" class="btn btn-login">Se connecter</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
