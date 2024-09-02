<?php
session_start();
if(!isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])){
    header("location: ./index.php"); 
    exit; 
}

$_SESSION['method'] = '';
if(isset($_GET["method"]) && !empty($_GET["method"])){
    $_SESSION['method'] = $_GET["method"];
} 
include("db.php");


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


include('header.php')
?>


<div class="milieu">
    <?php 
    if (isLoggedIn() && !empty($_SESSION['first_name']) && strtolower($_SESSION['first_name']) !== "borne") : ?>
    <div class="if-log-name-point">
        <h4>Bienvenue sur notre borne, <?php echo htmlspecialchars($_SESSION['first_name']) ?> !</h4>
        <p> Vous avez 0 points </p>
    </div>
    <?php endif; ?>
</div>

<style>

.category-icon {
    width: 4VH; 
    height: 4VH;
    margin-right: 10px;
    vertical-align: middle; 
}

</style>

<!-- Boutons categories  -->
<?php
try {
    include("db.php");

    $stmtCategories = $pdo->query("SELECT id, name FROM categories ORDER BY id");
    
    echo '<div class="categorie">';
    echo '<ul class="categorie-list">';
    while ($row = $stmtCategories->fetch(PDO::FETCH_ASSOC)) {

        $categoryIcon = ''; 
    
        switch ($row['id']) {
            case 2:
                $categoryIcon = 'img/icons/un-soda.png';
                break;
            case 3:
                $categoryIcon = 'img/icons/kofta.png';
                break;
            case 4: 
                $categoryIcon = 'img/icons/doner-kebab.png';
                break;
            case 5:
                $categoryIcon = 'img/icons/kebab.png';
                break;
            case 6:
                $categoryIcon = 'img/icons/burger.png'; 
                break;
            case 7:
                $categoryIcon = 'img/icons/burger.png'; 
            break;
            case 8:
                $categoryIcon = 'img/icons/forfait-alimentaire.png';
                break;
            case 9:
                $categoryIcon = 'img/icons/part-de-gateau.png';
                break; 
            default:
                $categoryIcon = '#'; 
                break;
        }
    
        echo '<li data-category="' . $row['id'] . '">';
        echo '<img src="' . htmlspecialchars($categoryIcon) . '" alt="' . htmlspecialchars($row['name']) . ' Icon" class="category-icon"> ';
        echo htmlspecialchars($row['name']);
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
    

    $stmtProducts = $pdo->query("SELECT id, name, description, price, image, category_id FROM products");

    echo '<div class="menus">';
    while ($product = $stmtProducts->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="menu" data-category="' . htmlspecialchars($product['category_id']) . '" data-product-id="' . htmlspecialchars($product['id']) . '" data-product-name="' . htmlspecialchars($product['name']) . '" data-product-price="' . htmlspecialchars($product['price']) . '">';
    echo '<img src="img/icons/soutien.png" alt="Support" class="support-logo" data-description="' . htmlspecialchars($product['description']) . '">';

if (!empty($product['image'])) {
    echo '<img src="' . htmlspecialchars($product['image']) . '" alt="Product Image">';
} else {
    echo '<p class="p-if-not-img">'. htmlspecialchars('Une image arrive bientôt !').' </p>' ;
}
echo '<div style="position: relative;">';
echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
echo '</div>';
echo '<span>' . htmlspecialchars($product['price']) . '€</span>';
echo '</div>';

    }
    echo '</div>';
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>


<!-- Modals -->
<div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportModalLabel">Description du produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour personnaliser les menus -->
<div class="modal fade" id="addToCartMenuModal" tabindex="-1" aria-labelledby="addToCartMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartMenuLabel">Personnalisez votre menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="customizeMenuForm">
                    <div class="mb-3">
                        <h5>Choisissez vos crudités :</h5>
                        <div class="input-choix-crudites">
                            <input type="checkbox" id="sandwich_crudites_salade" name="crudites[]" value="salade">
                            <label for="sandwich_crudites_salade"> <img src="img/icons/salade.png" alt="image salade">Salade</label><br>
                            <input type="checkbox" id="sandwich_crudites_tomate" name="crudites[]" value="tomate">
                            <label for="sandwich_crudites_tomate"><img src="img/icons/tomate.png" alt="image tomate">Tomate</label><br>
                            <input type="checkbox" id="sandwich_crudites_oignons" name="crudites[]" value="oignons">
                            <label for="sandwich_crudites_oignons"> <img src="img/icons/oignon.png" alt="image oignons">Oignons</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Choisissez votre/vos sauce(s) :</h5>
                        <div>
    <input type="checkbox" id="menu_sauce_blanche" name="sauce[]" value="blanche">
    <label for="menu_sauce_blanche">Blanche</label><br>
    
    <input type="checkbox" id="menu_sauce_andalouse" name="sauce[]" value="andalouse">
    <label for="menu_sauce_andalouse">Andalouse</label><br>
    
    <input type="checkbox" id="menu_sauce_algerienne" name="sauce[]" value="algerienne">
    <label for="menu_sauce_algerienne">Algérienne</label><br>
    
    <input type="checkbox" id="menu_sauce_samourai" name="sauce[]" value="samourai">
    <label for="menu_sauce_samourai">Samouraï</label><br>
    
    <input type="checkbox" id="menu_sauce_harissa" name="sauce[]" value="harissa">
    <label for="menu_sauce_harissa">Harissa</label><br>
    
    <input type="checkbox" id="menu_sauce_ketchup" name="sauce[]" value="ketchup">
    <label for="menu_sauce_ketchup">Ketchup</label><br>
    
    <input type="checkbox" id="menu_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
    <label for="menu_sauce_mayonnaise">Mayonnaise</label>
</div>

                        <p id="sauce-extra-message" style="color: red; display: none;">Supplément de 0,50€ pour 3 sauces</p>

                    </div>

                    <div class="mb-3">
                        <h5>Choisissez votre boisson :</h5>
                        <div>
                            <?php 
                            $stmtBoissons = $pdo->query("SELECT id, name FROM products WHERE category_id = 2");
                            while ($boisson = $stmtBoissons->fetch(PDO::FETCH_ASSOC)): ?>
                                <input type="radio" id="menu_boisson_<?php echo htmlspecialchars($boisson['id']); ?>" name="boisson" value="<?php echo htmlspecialchars($boisson['name']); ?>" required>
                                <label for="menu_boisson_<?php echo htmlspecialchars($boisson['id']); ?>"><?php echo htmlspecialchars($boisson['name']);  ?></label><br>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <input type="hidden" id="menu_product_id" name="product_id" value="">
                    <input type="hidden" id="menu_quantity" name="quantity" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddMenuToCart">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal simple pour les boissons -->
<div class="modal fade" id="addToCartBoissonModal" tabindex="-1" aria-labelledby="addToCartBoissonLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartBoissonLabel">Ajouter la boisson</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous ajouter cette boisson à votre panier ?</p>
                <input type="hidden" id="boisson_product_id" name="product_id" value="">
                <input type="hidden" id="boisson_quantity" name="quantity" value="1">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddBoissonToCart">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal pour personnaliser les sandwiches -->
<div class="modal fade" id="addToCartSandwichModal" tabindex="-1" aria-labelledby="addToCartSandwichLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartSandwichLabel">Personnalisez votre commande</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
            <form id="customizeSandwichForm">
            <div class="mb-3">
            <h5>Choisissez vos crudités :</h5>
            <div class="input-choix-crudites">
                <input type="checkbox" id="sandwich_crudites_salade_sandwich" name="crudites[]" value="salade">
                <label for="sandwich_crudites_salade_sandwich"> <img src="img/icons/salade.png" alt="image salade">Salade</label><br>
                <input type="checkbox" id="sandwich_crudites_tomate_sandwich" name="crudites[]" value="tomate">
                <label for="sandwich_crudites_tomate_sandwich"><img src="img/icons/tomate.png" alt="image tomate">Tomate</label><br>
                <input type="checkbox" id="sandwich_crudites_oignons_sandwich" name="crudites[]" value="oignons">
                <label for="sandwich_crudites_oignons_sandwich"> <img src="img/icons/oignon.png" alt="image oignons">Oignons</label>
            </div>
        </div>

                    <div class="mb-3">
                        <h5>Choisissez votre/vos sauce(s) :</h5>
                        <div>
                            <input type="checkbox" id="sandwich_sauce_blanche" name="sauce[]" value="blanche">
                            <label for="sandwich_sauce_blanche">Blanche</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_andalouse" name="sauce[]" value="andalouse">
                            <label for="sandwich_sauce_andalouse">Andalouse</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_algerienne" name="sauce[]" value="algerienne">
                            <label for="sandwich_sauce_algerienne">Algérienne</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_samourai" name="sauce[]" value="samourai">
                            <label for="sandwich_sauce_samourai">Samouraï</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_harissa" name="sauce[]" value="harissa">
                            <label for="sandwich_sauce_harissa">Harissa</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_ketchup" name="sauce[]" value="ketchup">
                            <label for="sandwich_sauce_ketchup">Ketchup</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
                            <label for="sandwich_sauce_mayonnaise">Mayonnaise</label>
                        </div>
                        <p id="sauce-extra-message" style="color: red; display: none;">Supplément de 0,50€ pour 3 sauces</p>

                    </div>

                    <input type="hidden" id="menu_product_id" name="product_id" value="">
                    <input type="hidden" id="menu_quantity" name="quantity" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddSandwichToCart">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal pour personnaliser les barquettes -->
<div class="modal fade" id="addToCartBarquetteModal" tabindex="-1" aria-labelledby="addToCartBarquetteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartBarquetteLabel">Choisissez votre/vos sauce(s)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="customizeBarquetteForm">
                    
                <div class="mb-3">
                        <h5>Choisissez votre/vos sauce(s) :</h5>
                        <div>
                            <input type="checkbox" id="sandwich_sauce_blanche" name="sauce[]" value="blanche">
                            <label for="sandwich_sauce_blanche">Blanche</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_andalouse" name="sauce[]" value="andalouse">
                            <label for="sandwich_sauce_andalouse">Andalouse</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_algerienne" name="sauce[]" value="algerienne">
                            <label for="sandwich_sauce_algerienne">Algérienne</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_samourai" name="sauce[]" value="samourai">
                            <label for="sandwich_sauce_samourai">Samouraï</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_harissa" name="sauce[]" value="harissa">
                            <label for="sandwich_sauce_harissa">Harissa</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_ketchup" name="sauce[]" value="ketchup">
                            <label for="sandwich_sauce_ketchup">Ketchup</label><br>
                            
                            <input type="checkbox" id="sandwich_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
                            <label for="sandwich_sauce_mayonnaise">Mayonnaise</label>
                        </div>
                        <p id="sauce-extra-message" style="color: red; display: none;">Supplément de 0,50€ pour 3 sauces</p>

                    </div>

                    <input type="hidden" id="barquette_product_id" name="product_id" value="">
                    <input type="hidden" id="barquette_quantity" name="quantity" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddBarquetteToCart">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal simple pour les desserts -->
<div class="modal fade" id="addToCartDessertModal" tabindex="-1" aria-labelledby="addToCartDessertLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartDessertLabel">Ajouter le dessert</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous ajouter ce dessert à votre panier ?</p>
                <input type="hidden" id="dessert_product_id" name="product_id" value="">
                <input type="hidden" id="dessert_quantity" name="quantity" value="1">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddDessertToCart">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>


<!-- modal pour informations -->
<div class="modal fade" id="productDescriptionModal" tabindex="-1" aria-labelledby="productDescriptionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDescriptionLabel">Product Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="productDescriptionContent">
                <!-- Product description will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal pour ajouter au panier 
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartLabel">Ajouter au panier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez-vous ajouter ce dessert  à votre panier ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddToCart">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div> -->




<?php include('basket-menu.php'); ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="menu.js"></script>


<style>

    .input-choix-crudites img {
        width: 20px;
    margin-right: 10px;

    }

    .menus {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    height: 58vh;
    position: fixed;
    overflow-y: scroll;
    margin: 0 30px;
}

.menu {
    position: relative;
    border: 1px solid rgb(232, 232, 232);
    background-color: rgba(243, 241, 241, 0.196);
    border-radius: 14px;
    width: 320px;
    height: 20vh;
    margin: 0.5rem;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
    text-align: center;
    font-family: "Roboto";
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.menu img.support-logo {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    cursor: pointer;
    z-index: 10;
}

.menu img {
    width: 50%;
    max-height: 50%;
    object-fit: contain;
    height: 10vh;
}

.menu h4 {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin: 5px 0;
}

.menu span {
    background-color: #FFBB25;
    padding: 5px 40px;
    border-radius: 25px;
    color: white;
    font-weight: bold;
}

.active-category {
    border: 3px solid #B20F0F;
    border-radius: 10px;
    background-color: #f0f0f0;
}
.order-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    border: 2px solid #B20F0F;  
    padding: 10px;  
    margin-bottom: 10px;  
    border-radius: 5px; 
    background-color: rgba(243, 241, 241, 0.5);
}


</style>