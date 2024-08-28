<?php 

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

?>


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
                        <input type="hidden" id="cart-data" name="cart-data" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>">
                        <button type="submit" class="btn btn-success" name="action" value="checkout">Valider la commande</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('order-form').addEventListener('submit', function(event) {
    const cart = JSON.parse(sessionStorage.getItem('cart') || '[]');

    if (cart.length > 0) {
        document.getElementById('cart-data').value = JSON.stringify(cart);
    } else {
        alert('Votre panier est vide.');
        event.preventDefault(); 
    }
});
</script>
