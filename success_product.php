<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit ajouté</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-align: center;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .popup.show {
            display: block;
        }
    </style>
</head>
<body>

<div class="popup" id="popup">Produit ajouté au panier avec succès</div>

<script>
    window.onload = function() {
        var popup = document.getElementById("popup");
        popup.classList.add("show");

        setTimeout(function() {
            popup.classList.remove("show");
            window.location.href = "menu.php"; 
        }, 2000);
    };
</script>

</body>
</html>
v