<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-...your-integrity-hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"/>
    </head>

<body>

<!-- style de la page -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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

        .categorie-list {
            display: flex;
            width: 100%;
            gap: 15px;
            justify-content: center;
        }


        .categorie-list li {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 15px;
            list-style: none;
            background-color: #FFBB25;
            border-radius: 14px;
            padding: 0.5rem 1rem;
            margin-top: 1rem;
            text-align: center;
            color: white;
            font-family: 'Montserrat';
            font-weight: 800;
        }

        .categorie-list:hover {
            cursor: pointer;
        }

        .menus {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            height: 62vh;
            position: fixed;
            overflow-x: scroll;
        }

        .menu {
            border: 1px solid rgb(232, 232, 232);
            background-color: rgba(243, 241, 241, 0.196);
            border-radius: 14px;
            width: 320px;
            height: 15vh;
            margin: 0.5rem;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
            text-align: center;
            font-family: "Roboto";
        }

        .menu img {
            width: 30%;
            object-fit: contain;
        }

        .menu span {
            background-color: #FFBB25;
            padding: 5px 40px;
            border-radius: 25px;
            color: white;
        }

        .panier {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .p-if-not-img {
            padding-top: 15px;
            font-weight: 900;
        }

        #bouton-panier {
            background-color: #B20F0F;
            color: white;
            font-weight: 700;
            font-family: 'Montserrat';
        }
    </style>

    <div class="banniere">
        <img src="img/1.jpg" alt="">
        <img src="img/2.jpg" alt="">
        <img src="img/3.jpg" alt="">
    </div>

    <div class="milieu">

    <!-- requete php --> 
<?php
$host = 'localhost';
$dbname = 'kangal';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $icons = [
        'Kebabs' => '<img src="img/icons/doner-kebab.png" alt="Kebabs" style="width: 30px; height: 30px;">',
        'Menu sandwich' => '<img src="img/icons/burger.png" alt="menu sandwich" style="width: 30px; height: 30px;">', 
        'Menu durum' => '<img src="img/icons/burger.png" alt="menu sandwich" style="width: 30px; height: 30px;">',
        'Durum' => '<img src="img/icons/kebab.png" alt="durum" style="width: 24px; height: 30px;">',
        'Sandwich' => '<img src="img/icons/burger-au-fromage.png" alt="burger" style="width: 30px; height: 30px;">', 
        'Assiette' =>'<img src="img/icons/kofta.png" alt="assiette" style="width: 24px; height: 30px;">', 
        'Barquette' => '<i class="fas fa-box"></i>',
        'Boissons' => '<img src="img/icons/un-soda.png" alt="boissons" style="width: 30px; height: 30px;">'
    ];
    
    

    $stmtCategories = $pdo->query("
    SELECT id, name 
    FROM categories 
    ORDER BY id
");

echo '<div class="categorie">';
echo '<ul class="categorie-list">';
while ($row = $stmtCategories->fetch(PDO::FETCH_ASSOC)) {
    $icon = $icons[$row['name']] ?? '<i class="fas fa-question-circle"></i>';
    echo '<li data-category="' . $row['id'] . '">' . $icon . ' ' . htmlspecialchars($row['name']) . '</li>';
}
echo '</ul>';
echo '</div>';
    
    $stmtProducts = $pdo->query("
        SELECT name, description, price, image, category_id 
        FROM products
    ");

    echo '<div class="menus">';
    while ($product = $stmtProducts->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="menu" data-category="' . htmlspecialchars($product['category_id']) . '" data-bs-toggle="modal" data-bs-target="#exampleModal">';
        if (!empty($product['image'])) {
            echo '<img src="' . htmlspecialchars($product['image']) . '" alt="Product Image">';
        } else {
            echo '<p class="p-if-not-img">'. htmlspecialchars('Une image arrive bientot !').' </p>' ;
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

        <hr>

<!-- html du panier -->
    <div class="panier">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="bouton-panier">
                Total de votre commande 
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the
                        collapse plugin adds the appropriate classes that we use to style each element. These classes
                        control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                        modify any of this with custom CSS or overriding our default variables. It's also worth noting
                        that just about any HTML can go within the <code>.accordion-body</code>, though the transition
                        does limit overflow.
                    </div>
                </div>
            </div>


        </div>
    </div>



  <!-- Modal lors qu'on clique sur un produit -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
...
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>
</div>
</div>-->



<!-- Modal pour categorie 1 -->
<div class="modal fade" id="kebabModal" tabindex="-1" aria-labelledby="kebabModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="kebabModalLabel">Configurer votre Kebab</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="kebab-options-form">
                    <div id="kebab-options" style="display: none;">
                        <!-- Sauces -->
                        <h5>Sélectionnez votre sauce :</h5>
                        <div>
                            <input type="checkbox" id="sauce-blanche" name="sauce[]" value="Sauce Blanche">
                            <label for="sauce-blanche">Sauce Blanche</label><br>
                            <input type="checkbox" id="sauce-andalouse" name="sauce[]" value="Sauce Andalouse">
                            <label for="sauce-andalouse">Sauce Andalouse</label><br>
                            <input type="checkbox" id="sauce-bbq" name="sauce[]" value="Sauce BBQ">
                            <label for="sauce-bbq">Sauce BBQ</label><br>
                            <input type="checkbox" id="sauce-ketchup" name="sauce[]" value="Sauce Ketchup">
                            <label for="sauce-ketchup">Sauce Ketchup</label>
                        </div>

                        <!-- Crudités -->
                        <h5>Choisissez vos crudités :</h5>
                        <div>
                            <input type="checkbox" id="crudite-salade" name="crudites[]" value="Salade">
                            <label for="crudite-salade">Salade</label><br>
                            <input type="checkbox" id="crudite-tomate" name="crudites[]" value="Tomate">
                            <label for="crudite-tomate">Tomate</label><br>
                            <input type="checkbox" id="crudite-oignon" name="crudites[]" value="Oignon">
                            <label for="crudite-oignon">Oignon</label>
                        </div>

                        <!-- Boissons -->
                        <h5>Sélectionnez votre boisson :</h5>
                        <div>
                            <input type="checkbox" id="boisson-coca" name="boisson[]" value="Coca-Cola">
                            <label for="boisson-coca">Coca-Cola</label><br>
                            <input type="checkbox" id="boisson-fanta" name="boisson[]" value="Fanta">
                            <label for="boisson-fanta">Fanta</label><br>
                            <input type="checkbox" id="boisson-eau" name="boisson[]" value="Eau">
                            <label for="boisson-eau">Eau</label>
                        </div>

                        <!-- Frites -->
                        <h5>Ajouter des frites :</h5>
                        <div>
                            <input type="checkbox" id="frites" name="frites" value="Frites">
                            <label for="frites">Ajouter des frites</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour categorie 2 -->
<div class="modal fade" id="beverageModal" tabindex="-1" aria-labelledby="beverageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="beverageModalLabel">Ajouter Boisson au Panier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez-vous ajouter cette boisson à votre panier ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal pour categorie 3 -->
<div class="modal fade" id="sauceModal" tabindex="-1" aria-labelledby="kebabModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="kebabModalLabel">Ajoutez une sauce a vos frites</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="kebab-options-form">
                    <div id="kebab-options" >
                        <!-- Sauces -->
                        <h5>Sélectionnez votre sauce :</h5>
                        <div>
                            <input type="checkbox" id="sauce-blanche" name="sauce[]" value="Sauce Blanche">
                            <label for="sauce-blanche">Sauce Blanche</label><br>
                            <input type="checkbox" id="sauce-andalouse" name="sauce[]" value="Sauce Andalouse">
                            <label for="sauce-andalouse">Sauce Andalouse</label><br>
                            <input type="checkbox" id="sauce-bbq" name="sauce[]" value="Sauce BBQ">
                            <label for="sauce-bbq">Sauce BBQ</label><br>
                            <input type="checkbox" id="sauce-ketchup" name="sauce[]" value="Sauce Ketchup">
                            <label for="sauce-ketchup">Sauce Ketchup</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz4fnFO9gybBogGzFwJfKx0AKLbLcHj6cYlZp6jIwWrxJc8ERk7rEIOeEr" crossorigin="anonymous">
        </script>
 

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryItems = document.querySelectorAll('.categorie-list li');
    const products = document.querySelectorAll('.menus .menu');
    const kebabModal = new bootstrap.Modal(document.getElementById('kebabModal'));
    const beverageModal = new bootstrap.Modal(document.getElementById('beverageModal'));
    const sauceModal = new bootstrap.Modal(document.getElementById('sauceModal')); 
    const kebabOptionsDiv = document.getElementById('kebab-options');

    const cart = [];

    function renderCart() {
        const cartContainer = document.querySelector('.accordion-body');
        cartContainer.innerHTML = ''; 

        if (cart.length === 0) {
            cartContainer.innerHTML = '<p>Votre panier est vide.</p>';
        } else {
            cart.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.innerHTML = `
                    <p><strong>${item.name}</strong> - ${item.price}€</p>
                    <p>Suppléments: ${item.supplements.join(', ')}</p>
                    <button class="btn btn-danger btn-sm" onclick="removeCartItem(${index})">Retirer</button>
                    <hr>
                `;
                cartContainer.appendChild(itemElement);
            });
        }
    }

    function resetForm() {
        document.getElementById('kebab-options-form').reset();
    }

    // Produit en fonction de la catégorie
    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            const categoryid = this.getAttribute('data-category');
            products.forEach(product => {
                if (product.getAttribute('data-category') === categoryid) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        });
    });

    // Pop-up pour affichage des produits
    products.forEach(product => {
        product.addEventListener('click', function () {
            const categoryid = this.getAttribute('data-category');

            if (categoryid === '1') { 
                kebabOptionsDiv.style.display = 'block';
                kebabModal.show();
            } else if (categoryid === '2') {
                kebabOptionsDiv.style.display = 'none'; 
                beverageModal.show();
            } else if (categoryid === '3') { 
                sauceModal.show();
            }
        });
    });

    document.querySelector('#kebabModal .btn-primary').addEventListener('click', function () {
        const sauces = Array.from(document.querySelectorAll('#kebab-options-form input[name="sauce[]"]:checked')).map(el => el.value);
        const crudites = Array.from(document.querySelectorAll('#kebab-options-form input[name="crudites[]"]:checked')).map(el => el.value);
        const boissons = Array.from(document.querySelectorAll('#kebab-options-form input[name="boisson[]"]:checked')).map(el => el.value);
        const frites = document.getElementById('frites').checked ? ['Frites'] : [];

        const supplements = [...sauces, ...crudites, ...boissons, ...frites];

        cart.push({
            name: 'Kebab',
            price: '5.00',  
            supplements: supplements
        });

        resetForm();
        kebabModal.hide();
        renderCart();
    });

    document.querySelector('#beverageModal .btn-primary').addEventListener('click', function () {
        cart.push({
            name: 'Boisson',
            price: '2.00', 
            supplements: []
        });

        beverageModal.hide();
        renderCart();
    });

    //ajout sauce categ 3
    document.querySelector('#sauceModal .btn-primary').addEventListener('click', function () {
        const selectedSauces = Array.from(document.querySelectorAll('#sauceModal input[name="sauce[]"]:checked')).map(el => el.value);
        
        cart.push({
            name: 'Sauce',
            price: '0.50', 
            supplements: selectedSauces
        });

        sauceModal.hide();
        renderCart();
    });

    window.removeCartItem = function (index) {
        cart.splice(index, 1);  
        renderCart();  
    }

    renderCart();
});


</script>


<style>

    .modal-content {
        position: relative;
        top: 200px;
        background-color: white;
    }


    .modal-header {
        background-color: #B20F0F;
        color: white;
    }

    .modal-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }

    .modal-body {
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        color: #333;
        padding: 20px;
    }

    .modal-body h5 {
        font-family: 'Lilita One', cursive;
        font-size: 18px;
        color: #B20F0F;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .modal-body label {
        margin-left: 10px;
        font-weight: 500;
        font-size: 14px;
        color: #555;
    }

    .modal-body input[type="checkbox"] {
        accent-color: #FFBB25;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .modal-body div {
        margin-bottom: 15px;
    }

    .modal-footer {
        background-color: #f1f1f1;
        border-top: 1px solid #e5e5e5;
        padding: 15px;
        display: flex;
        justify-content: space-between;
    }

    .btn-primary {
        background-color: #FFBB25;
        border-color: #FFBB25;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #e6a921;
        border-color: #e6a921;
    }

    .btn-secondary {
        font-family: 'Montserrat', sans-serif;
        color: #555;
    }
</style>
