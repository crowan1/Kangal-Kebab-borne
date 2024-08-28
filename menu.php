<?php
session_start();
$_SESSION['method'] = '';
if(isset($_GET["method"]) && !empty($_GET["method"])){
    $_SESSION['method'] = $_GET["method"];
} 
include("db.php");

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  

//     // Normaliser les données du panier
//     foreach ($_SESSION['cart'] as $key => &$item) {
//         // Vérifiez que chaque article a les clés nécessaires
//         if (!isset($item['id']) || !isset($item['quantity']) || !isset($item['price'])) {
//             echo "Erreur : un ou plusieurs articles dans le panier sont invalides.";
//             var_dump($item); // Affichez l'élément invalide pour le débogage
//             exit();
       
//         }

//         // Vérifiez que 'price' est un nombre sans devise
//         $item['price'] = floatval(preg_replace('/[^\d.]/', '', $item['price']));

//         // Assurez-vous que 'quantity' est un entier
//         $item['quantity'] = intval($item['quantity']);

//         // Si l'ID n'est pas un entier, il y a un problème
//         if (!is_int($item['id']) || $item['id'] <= 0) {
//             echo "Erreur : ID de produit invalide.";
//             var_dump($item); // Affichez l'élément invalide pour le débogage
//             exit();
//         }
//     }

//     if (isset($_POST['action']) && $_POST['action'] === 'checkout') {
//         if (empty($_SESSION['cart'])) {
//             echo "Erreur : Votre panier est vide.";
//             exit();
//         }

//         $total_price = 0;

//         foreach ($_SESSION['cart'] as $item) {
//             $total_price += $item['price'] * $item['quantity'];
//         }

//         $modeService = $_SESSION['modeService'] ?? 'Non spécifié';
//         $getCommande = $_SESSION['getCommande'] ?? 'Non spécifié';

//         // Créer la commande dans la table 'orders'
//         $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, modeService, getCommande) VALUES (:user_id, :total_price, :modeService, :getCommande)");
//         $stmt->execute([
//             ':user_id' => $_SESSION['user_id'],
//             ':total_price' => $total_price,
//             ':modeService' => $modeService,
//             ':getCommande' => $getCommande
//         ]);

//         $order_id = $pdo->lastInsertId();

//         // Ajouter chaque élément du panier à la table 'order_items'
//         foreach ($_SESSION['cart'] as $item) {
//             $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, sauces, crudites, supplements, boisson) VALUES (:order_id, :product_id, :quantity, :price, :sauces, :crudites, :supplements, :boisson)");
//             $stmt->execute([
//                 ':order_id' => $order_id,
//                 ':product_id' => $item['id'],
//                 ':quantity' => $item['quantity'],
//                 ':price' => $item['price'],
//                 ':sauces' => isset($item['sauces']) ? json_encode($item['sauces']) : null,
//                 ':crudites' => isset($item['crudites']) ? json_encode($item['crudites']) : null,
//                 ':supplements' => isset($item['supplements']) ? json_encode($item['supplements']) : null,
//                 ':boisson' => isset($item['boisson']) ? $item['boisson'] : null
//             ]);
//         }

//         // Vider le panier après la commande
//         $_SESSION['cart'] = [];

//         // Rediriger vers la page de confirmation
//         header("Location: confirmation.php");
//         exit();
//     }
// }

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
    if (isLoggedIn() && !empty($_SESSION['first_name']) && strtolower($_SESSION['first_name']) !== "borne") : ?>
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
            echo '<p class="p-if-not-img">'. htmlspecialchars('Une image arrive bientôt !').' </p>' ;
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

<?php include('basket-menu.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryItems = document.querySelectorAll('.categorie-list li');
    const products = document.querySelectorAll('.menus .menu');
    let selectedProduct = null;

    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            const categoryId = this.getAttribute('data-category');
            products.forEach(product => {
                if (product.getAttribute('data-category') === categoryId) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });

    products.forEach(product => {
        product.addEventListener('click', function () {
            selectedProduct = {
                id: this.getAttribute('data-product-id'),
                name: this.getAttribute('data-product-name'),
                price: parseFloat(this.getAttribute('data-product-price'))
            };
            const modal = new bootstrap.Modal(document.getElementById('addToCartModal'));
            modal.show();
        });
    });

    // document.getElementById('confirmAddToCart').addEventListener('click', function () {
        // if (selectedProduct) {
        //     if (!sessionStorage.getItem('cart')) {
        //         sessionStorage.setItem('cart', JSON.stringify([]));
        //     }

        //     const cart = JSON.parse(sessionStorage.getItem('cart'));

        //     const existingProductIndex = cart.findIndex(item => item.id === selectedProduct.id);

        //     if (existingProductIndex !== -1) {
        //         cart[existingProductIndex].quantity += 1;
        //     } else {
        //         selectedProduct.quantity = 1; 
        //         cart.push(selectedProduct);
        //     }

        //     sessionStorage.setItem('cart', JSON.stringify(cart));
        //     updateCartDisplay(cart);

        //     const modal = bootstrap.Modal.getInstance(document.getElementById('addToCartModal'));
        //     modal.hide();
        // }
    // });

    // function updateCartDisplay(cart) {
    //     let cartHTML = '';
    //     let total = 0;
    //     cart.forEach(item => {
    //         cartHTML += `<p>${item.name} - ${item.quantity} x ${item.price}€</p>`;
    //         total += item.price * item.quantity;
    //     });
    //     document.getElementById('cart-items').innerHTML = cartHTML || '<p>Votre panier est vide.</p>';
    //     document.getElementById('bouton-panier').innerHTML = `Total de votre commande: ${total.toFixed(2)}€`;
    // }

    // if (sessionStorage.getItem('cart')) {
    //     updateCartDisplay(JSON.parse(sessionStorage.getItem('cart')));
    // }


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
