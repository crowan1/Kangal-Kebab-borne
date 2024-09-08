<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0; 
            font-family: 'Roboto', sans-serif;
            font-weight: 800;
        }

        h2 {
            display: flex;
            justify-content: center;
            font-size: 5vh;
            margin-top: 100px;
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

        .choice-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 40vh;
        }

        .buttonChoix {
            background-color: rgba(243, 243, 243, 0.962);
            height: 300px;
            width: 350px;
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: black;
            position: relative;
        }

        .buttonChoix img {
            margin-right: 10px;
            width: 12vh;
            margin-bottom: 15px;
        }

        .selected {
            border: 3px solid red;
            background-color: #FFD6D6;
        }
    </style>
</head>
<body>

    <div class="banniere">
        <img src="img/1.jpg" alt="">
        <img src="img/2.jpg" alt="">
        <img src="img/3.jpg" alt="">
    </div>
    <h2>BIENVENUE</h2>
    <div class="choice-container">
        <a id="connecter" class="buttonChoix" href="#" onclick="selectChoice('login')">
            <img src="img/icons/se-connecter.png" alt="icon d'un compte">
            SE CONNECTER
        </a>
        <a id="inviter" class="buttonChoix" href="#" onclick="selectChoice('inviter')">
            <img src="img/icons/aucun-profil.png" alt="icon d'un compte barré">
            CONTINUER EN TANT QU'INVITÉ
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        function selectChoice(choiceId) {
            if (choiceId === 'inviter') {
                sessionStorage.setItem('user_type', 'inviter');
                window.location.href = 'connect_as_guest.php';
            } else if (choiceId === 'login'){
             window.location.href="login.php";
            } else {
                alert('Cette option est bientôt disponible.');
            }
        }
    </script>
</body>
</html> 