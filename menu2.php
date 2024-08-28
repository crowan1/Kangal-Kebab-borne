<?php
session_start();
$_SESSION['method'] = '';
if (isset($_GET["method"]) && !empty($_GET["method"])) {
    $_SESSION['method'] = $_GET["method"];
}
include("db.php");


function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}



if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}



// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Normaliser les données du panier
    foreach ($_SESSION['cart'] as $key => &$item) {
        // Vérifiez que chaque article a les clés nécessaires
        if (!isset($item['id']) || !isset($item['quantity']) || !isset($item['price'])) {
            echo "Erreur : un ou plusieurs articles dans le panier sont invalides.";
            var_dump($item); // Affichez l'élément invalide pour le débogage
            exit();

        }

        // Vérifiez que 'price' est un nombre sans devise
        $item['price'] = floatval(preg_replace('/[^\d.]/', '', $item['price']));

        // Assurez-vous que 'quantity' est un entier
        $item['quantity'] = intval($item['quantity']);

        // Si l'ID n'est pas un entier, il y a un problème
        if (!is_int($item['id']) || $item['id'] <= 0) {
            echo "Erreur : ID de produit invalide.";
            var_dump($item); // Affichez l'élément invalide pour le débogage
            exit();
        }
    }


}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="banniere">
        <img src="img/1.jpg" alt="">
        <img src="img/2.jpg" alt="">
        <img src="img/3.jpg" alt="">
    </div>

    <div class="milieu">
        <?php
        if (isLoggedIn() && !empty($_SESSION['first_name']) && strtolower($_SESSION['first_name']) !== "borne"): ?>
            <div class="if-log-name-point">
                <h4>Bienvenue sur notre borne, <?php echo htmlspecialchars($_SESSION['first_name']) ?> !</h4>
                <p> Vous avez 0 points </p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    try {
        // Afficher les catégories
        $stmtCategories = $pdo->query("SELECT id, name FROM categories ORDER BY id");

        echo '<div class="categorie">';
        echo '<ul class="categorie-list">';
        while ($row = $stmtCategories->fetch(PDO::FETCH_ASSOC)) {
            echo '<li data-category="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</li>';
        }
        echo '</ul>';
        echo '</div>';

        // Afficher les produits
        $stmtProducts = $pdo->query("SELECT id, name, description, price, image, category_id FROM products");

        echo '<div class="menus">';
        while ($product = $stmtProducts->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="menu" data-category="' . htmlspecialchars($product['category_id']) . '" data-product-id="' . htmlspecialchars($product['id']) . '" data-product-name="' . htmlspecialchars($product['name']) . '" data-product-price="' . htmlspecialchars($product['price']) . '">';
            if (!empty($product['image'])) {
                echo '<img src="' . htmlspecialchars($product['image']) . '" alt="Product Image">';
            } else {
                echo '<p class="p-if-not-img">' . htmlspecialchars('Une image arrive bientôt !') . ' </p>';
            }
            echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
            echo '<span>' . htmlspecialchars($product['price']) . '€</span>';
            echo '</div>';
        }
        echo '</div>';
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    ?>

    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addToCartLabel">Ajouter au panier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous ajouter cet article à votre panier ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmAddToCart">Ajouter au panier</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Panier add -->





    <div class="panier">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                        id="bouton-panier">
                        Total de votre commande
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body" id="cart-items">
                        <?php
                        if (empty($_SESSION['cart'])) {
                            echo "<p>Votre panier est vide.</p>";
                        } else {
                            foreach ($_SESSION['cart'] as $item) {
                                echo "<p>{$item['name']} - {$item['quantity']} x {$item['price']}€</p>";
                            }
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="panier-buttons">
                        <button class="btn btn-danger" id="cancel-order">Annuler la commande</button>
                        <form id="order-form" action="confirmation.php" method="post">
                            <input type="hidden" id="cart-data" name="cart-data"
                                value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>">
                            <button type="submit" class="btn btn-success" name="action" value="checkout">Valider la
                                commande</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- end panier add -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById('confirmAddToCart').addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const quantity = this.getAttribute('data-quantity');

                fetch('add_panier.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}&quantity=${quantity}`,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
            });



        });
    </script>

</body>

</html>