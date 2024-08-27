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
                    <form id="order-form" action="checkout.php" method="post">
                        <input type="hidden" id="cart-data" name="cart-data" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'])); ?>">
                        <button type="submit" class="btn btn-success" id="confirm-order">Valider la commande</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('cancel-order').addEventListener('click', function () {
    $.post('update_cart.php', { action: 'clear' }, function (response) {
        updateCartDisplay(response.cart);
    }, 'json');
});

function updateCartDisplay(cart) {
    let cartHTML = '';
    let total = 0;
    cart.forEach(item => {
        cartHTML += `<p>${item.name} - ${item.quantity} x ${item.price}€</p>`;
        total += item.price * item.quantity;
    });
    document.getElementById('cart-items').innerHTML = cartHTML || '<p>Votre panier est vide.</p>';
    document.getElementById('bouton-panier').innerHTML = `Total de votre commande: ${total.toFixed(2)}€`;
}
</script>
