<?php 
session_start(); 

if(!isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])){
    header("location: ./index.php"); 
    exit; 
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du Service</title>
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
            width: 33.33%;
            object-fit: contain;
        }

        .emporterSurPlace {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 40vh; 
        }

        .buttonChoix {
            background-color: rgba(243, 243, 243, 0.962);
            height: 200px; 
            width: 350px; 
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: black;
            cursor: pointer;
        }

        .buttonChoix img {
            margin-right: 10px;
            width: 10vh; 
            margin-bottom: 15px;
        }

        .selected {
            border: 3px solid red;
            background-color: #FFD6D6;
        }

        #continueBtn {
            display: flex;
            margin: auto;
            background-color: #FFB000;
            color: white;
            padding: 1vh 5vh;
            border: none;
            border-radius: 5px;
        }

        #button-back {
            font-family: 'Roboto';
            font-weight: 800;
            display: flex;
            margin: auto;
            margin-top: 15px;
            justify-content: center;
            width: 10vh;
        }
    </style>
</head>
<body>

    <div class="banniere">
        <img src="img/1.jpg" alt="image avec logo">
        <img src="img/2.jpg" alt="image avec un kebab">
        <img src="img/3.jpg" alt="image un logo open">
    </div>
    <h2>CHOISISSEZ VOTRE MODE DE SERVICE</h2>
    <div class="emporterSurPlace">
        <a id="surPlace" class="buttonChoix" onclick="selectChoice('surPlace')" href="menu.php?method=place">
            <img src="img/icons/fourchette-et-couteau.png" alt="Fourchette et couteau">
            SUR PLACE
        </a>
        <a id="emporter" class="buttonChoix" onclick="selectChoice('emporter')" href="menu.php?method=emporter">
            <img src="img/icons/a-emporter.png" alt="sac à emporter">
            À EMPORTER
        </a>
    </div>

    <!-- <button id="continueBtn">CONTINUER</button>
    <a href="index.php" id="button-back" class="btn btn-secondary mb-3">RETOUR</a>
     -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedChoice = null;

        function selectChoice(choiceId) {
            document.querySelectorAll('.buttonChoix').forEach(button => {
                button.classList.remove('selected');
            });

            selectedChoice = choiceId;
            document.getElementById(choiceId).classList.add('selected');
        }

        document.getElementById('continueBtn').addEventListener('click', () => {
            if (selectedChoice) {
                sessionStorage.setItem('modeService', selectedChoice);
                sessionStorage.setItem('getCommande', selectedChoice === 'surPlace' ? 'Sur place' : 'À emporter');
                // window.location.href = 'menu.php';
            } else {
                alert('Veuillez sélectionner un mode de service.');
            }
        });
    </script>
</body>
</html>
