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


echo"<pre";
var_dump($_SESSION);
echo "</pre>";

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
    width: 20px; 
    height: 20px;
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

                case 9 ; 
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



<!-- Modal for customizing the menus -->
<div class="modal fade" id="addToCartMenuModal" tabindex="-1" aria-labelledby="addToCartMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartMenuLabel">Customize Your Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customizeMenuForm">
                    <!-- Crudités selection remains unchanged -->
                    <div class="mb-3">
                        <h5>Choose Your Crudités:</h5>
                        <div>
                            <input type="checkbox" id="menu_crudites_salade" name="crudites[]" value="salade">
                            <label for="menu_crudites_salade">Salade</label><br>
                            <input type="checkbox" id="menu_crudites_tomate" name="crudites[]" value="tomate">
                            <label for="menu_crudites_tomate">Tomate</label><br>
                            <input type="checkbox" id="menu_crudites_oignons" name="crudites[]" value="oignons">
                            <label for="menu_crudites_oignons">Oignons</label>
                        </div>
                    </div>

                    <!-- Sauce selection updated to use checkboxes -->
                    <div class="mb-3">
                        <h5>Choose Your Sauce(s):</h5>
                        <div>
                            <input type="checkbox" id="menu_sauce_blanche" name="sauce[]" value="blanche">
                            <label for="menu_sauce_blanche">Blanche</label><br>
                            <input type="checkbox" id="menu_sauce_andalouse" name="sauce[]" value="andalouse">
                            <label for="menu_sauce_andalouse">Andalouse</label><br>
                            <input type="checkbox" id="menu_sauce_ketchup" name="sauce[]" value="ketchup">
                            <label for="menu_sauce_ketchup">Ketchup</label>
                        </div>
                    </div>

                    <!-- Beverages and other items remain unchanged -->
                    <div class="mb-3">
                        <h5>Choose Your Drink:</h5>
                        <div>
                            <?php 
                            $stmtBoissons = $pdo->query("SELECT id, name FROM products WHERE category_id = 2");
                            while ($boisson = $stmtBoissons->fetch(PDO::FETCH_ASSOC)): ?>
                                <input type="radio" id="menu_boisson_<?php echo htmlspecialchars($boisson['id']); ?>" name="boisson" value="<?php echo htmlspecialchars($boisson['name']); ?>" required>
                                <label for="menu_boisson_<?php echo htmlspecialchars($boisson['id']); ?>"><?php echo htmlspecialchars($boisson['name']); ?></label><br>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <input type="hidden" id="menu_product_id" name="product_id" value="">
                    <input type="hidden" id="menu_quantity" name="quantity" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddMenuToCart">Add to Cart</button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
<!-- Modal for customizing sandwiches -->
<div class="modal fade" id="addToCartSandwichModal" tabindex="-1" aria-labelledby="addToCartSandwichLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartSandwichLabel">Customize Your Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customizeSandwichForm">
                    <!-- Crudités selection remains unchanged -->
                    <div class="mb-3">
                        <h5>Choose Your Crudités:</h5>
                        <div>
                            <input type="checkbox" id="sandwich_crudites_salade" name="crudites[]" value="salade">
                            <label for="sandwich_crudites_salade">Salade</label><br>
                            <input type="checkbox" id="sandwich_crudites_tomate" name="crudites[]" value="tomate">
                            <label for="sandwich_crudites_tomate">Tomate</label><br>
                            <input type="checkbox" id="sandwich_crudites_oignons" name="crudites[]" value="oignons">
                            <label for="sandwich_crudites_oignons">Oignons</label>
                        </div>
                    </div>

                    <!-- Sauce selection updated to use checkboxes -->
                    <div class="mb-3">
                        <h5>Choose Your Sauce(s):</h5>
                        <div>
                            <input type="checkbox" id="sandwich_sauce_blanche" name="sauce[]" value="blanche">
                            <label for="sandwich_sauce_blanche">Blanche</label><br>
                            <input type="checkbox" id="sandwich_sauce_andalouse" name="sauce[]" value="andalouse">
                            <label for="sandwich_sauce_andalouse">Andalouse</label><br>
                            <input type="checkbox" id="sandwich_sauce_ketchup" name="sauce[]" value="ketchup">
                            <label for="sandwich_sauce_ketchup">Ketchup</label>
                        </div>
                    </div>

                    <input type="hidden" id="sandwich_product_id" name="product_id" value="">
                    <input type="hidden" id="sandwich_quantity" name="quantity" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddSandwichToCart">Add to Cart</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour les barquettes -->
<div class="modal fade" id="addToCartBarquetteModal" tabindex="-1" aria-labelledby="addToCartBarquetteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addToCartBarquetteLabel">Choose Your Sauce(s)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customizeBarquetteForm">
                    <div class="mb-3">
                        <h5>Choose Your Sauce(s):</h5>
                        <div>
                            <input type="checkbox" id="barquette_sauce_blanche" name="sauce[]" value="blanche">
                            <label for="barquette_sauce_blanche">Blanche</label><br>
                            <input type="checkbox" id="barquette_sauce_andalouse" name="sauce[]" value="andalouse">
                            <label for="barquette_sauce_andalouse">Andalouse</label><br>
                            <input type="checkbox" id="barquette_sauce_ketchup" name="sauce[]" value="ketchup">
                            <label for="barquette_sauce_ketchup">Ketchup</label>
                        </div>
                    </div>

                    <input type="hidden" id="barquette_product_id" name="product_id" value="">
                    <input type="hidden" id="barquette_quantity" name="quantity" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddBarquetteToCart">Add to Cart</button>
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
