<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
 
        .banniere{
            display: flex;
            justify-content: space-around;
            width: 100%;
            height: 250px;
            background-color:#B20F0F ;
        }
        .banniere img{
            width:33.33% !important;
            object-fit: contain;
        }
        .emporterSurPlace{
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 40vh;
        }
        .buttonChoix{
            border: 1PX solid rgb(225, 225, 225);
            background-color: rgba(243, 243, 243, 0.962);
            height: 200px;
            width: 350px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: black;
        }
    </style>

    <div class="banniere">
        <img src="img/1.jpg" alt="">
        <img src="img/2.jpg" alt="">
        <img src="img/3.jpg" alt="">
    </div>
  

    <div class="emporterSurPlace">
    <a class="buttonChoix emporter" href="menu.php">
        A Emporter
    </a>
    <a class="buttonChoix surPlace" href="menu.php">
        Sur Place
    </a>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>