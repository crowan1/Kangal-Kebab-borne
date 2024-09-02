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
            height: 200px;
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
            width: 10vh;
            margin-bottom: 15px;
        }

        .buttonChoix.disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .buttonChoix.disabled img {
            filter: grayscale(100%);
        }

        .buttonChoix.disabled::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(128, 128, 128, 0.5);  
    z-index: 1;
    pointer-events: none;
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
            cursor: pointer;
        }

        #connecter.disabled {
            pointer-events: none;
            cursor: not-allowed;
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
        <a id="connecter" class="buttonChoix disabled" href="#">
            <div class="overlay-text">Bientôt disponible !</div>
            <img src="img/icons/se-connecter.png" alt="icon d'un compte">
            SE CONNECTER
        </a>
        <a id="inviter" class="buttonChoix" onclick="selectChoice('inviter')" href="#">
            <img src="img/icons/aucun-profil.png" alt="icon d'un compte barré">
            CONTINUER EN TANT QU'INVITÉ
        </a>
    </div>

    <button id="continueBtn">CONTINUER</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        let selectedChoice = null;

        function selectChoice(choiceId) {
            document.querySelectorAll('.buttonChoix').forEach(button => {
                button.classList.remove('selected');
            });

            selectedChoice = choiceId;
            if (choiceId !== 'connecter') {
                document.getElementById(choiceId).classList.add('selected');
            }
        }

        document.getElementById('continueBtn').addEventListener('click', () => {
            if (selectedChoice === 'inviter') {
                sessionStorage.setItem('user_type', 'inviter');
                window.location.href = 'connect_as_guest.php';
            } else {
                alert('Veuillez sélectionner une option.');
            }
        });
    </script>
</body>
</html>
