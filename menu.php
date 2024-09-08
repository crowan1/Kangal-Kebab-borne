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

$stmt = $pdo->prepare("SELECT points FROM user_points WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$userPoints = $stmt->fetch(PDO::FETCH_ASSOC);

$points = $userPoints ? $userPoints['points'] : 0;
$tempPoints = isset($_SESSION['temp_points_deduction']) ? $_SESSION['temp_points_deduction'] : 0;

include('header.php')

?>

<link rel="stylesheet" href="menu.css">
<div class="milieu">
<?php 
    if (isLoggedIn() && !empty($_SESSION['first_name']) && strtolower($_SESSION['first_name']) !== "borne") : ?>
<div class="if-log-name-point">
    <h4>Bienvenue, <?php echo htmlspecialchars($_SESSION['first_name']); ?> !</h4>
    <p>Vous avez <?php echo $points - $tempPoints; ?> points</p>

    <?php if ($points - $tempPoints >= 150): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kebabRewardModal">Réclamer votre menu kebab gratuit</button>
    <?php endif; ?>

    <?php if ($tempPoints == 150): ?>
        <form method="post" action="remove_kebab_from_cart.php">
            <button type="submit" class="btn btn-warning">Annuler le menu kebab gratuit</button>
        </form>
    <?php endif; ?>
</div>
    <?php endif; ?>
</div>
        
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

<?php include('modal.php'); ?>

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

<script>
document.getElementById('confirmKebabReward').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('customizeKebabForm'));

    fetch('add_kebab_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.reload();  
        } else {
            alert('Erreur : ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erreur lors de l\'ajout au panier:', error);
    });
});
</script>
