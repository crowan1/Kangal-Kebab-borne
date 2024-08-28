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
                    <?php if (empty($_SESSION['cart'])): ?>
                        <p>Votre panier est vide.</p>
                    <?php else: ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <p><?php echo htmlspecialchars($item['name']); ?> - <?php echo $item['quantity']; ?> x <?php echo htmlspecialchars($item['price']); ?>€</p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="panier-buttons">

                    <!-- Pop-up pour annuler la commande -->
                    <div class="pop-up-delete-order" style="display: none;">
    <div class="popup-header">
        <h2 class="popup-title">Annuler la commande</h2>
    </div>
    <div class="popup-body">
        <h3 class="popup-subtitle">Voulez-vous vraiment annuler votre commande ?</h3>
    </div>
    <div class="popup-buttons">
        <button type="button" class="btn btn-secondary" id="close-popup">Retour</button>
        <form action="delete_order.php" method="POST" style="display: inline;">
            <button type="submit" class="btn btn-danger">Annuler ma commande</button>
        </form>
    </div>
</div>

                    <!-- Bouton pour déclencher la pop-up -->
                    <button type="button" class="btn btn-danger" id="trigger-popup">
                        Annuler la commande
                    </button>

                    <form id="order-form" action="payment.php" method="post">
                        <input type="hidden" id="cart-data" name="cart-data" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart'] ?? [])); ?>">
                        <button type="submit" class="btn btn-success" name="action" value="checkout">Valider la commande</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('order-form').addEventListener('submit', function(event) {
    const cartData = document.getElementById('cart-data').value;
    if (cartData === '[]') {
        alert('Votre panier est vide.');
        event.preventDefault(); 
    }
});

document.getElementById('trigger-popup').addEventListener('click', function () {
    document.querySelector('.pop-up-delete-order').style.display = 'block';
});

document.getElementById('close-popup').addEventListener('click', function () {
    document.querySelector('.pop-up-delete-order').style.display = 'none';
});

</script>

<style>
/* Style pour la pop-up d'annulation de commande */
.pop-up-delete-order {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    width: 100%;
    max-width: 500px;
    text-align: center;
    border-radius: 8px;
}

.popup-header {
    background-color: #B20F0F;
    color: white;
    padding: 10px;
    border-radius: 8px 8px 0 0;
}

.popup-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    margin: 0;
    font-size: 24px;
}

.popup-body {
    padding: 20px;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    color: #333;
}

.popup-subtitle {
    font-size: 18px;
    margin-bottom: 20px;
}

.popup-buttons {
    display: flex;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #e5e5e5;
    margin-top: 20px;
}

.popup-buttons .btn {
    width: 45%;
}


</style>