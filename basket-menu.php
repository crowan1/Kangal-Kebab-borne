<link rel="stylesheet" href="basket-menu.css">
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
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $index => $item): ?>
    <div class="cart-item">
        <p><?php echo htmlspecialchars($item['name']); ?> - <?php echo $item['quantity']; ?> x <?php echo number_format($item['price'], 2, ',', ''); ?> €</p>
        <img src="img/icons/signe-de-la-croix.png" alt="Supprimer" class="delete-item" data-index="<?php echo $index; ?>">
        <?php if (!empty($item['crudites'])): ?>
            <p><strong>Crudités:</strong> <?php echo htmlspecialchars($item['crudites']); ?></p>
        <?php endif; ?>
        <?php if (!empty($item['sauce'])): ?>
            <p><strong>Sauce:</strong> <?php echo htmlspecialchars($item['sauce']); ?></p>
        <?php endif; ?>
        <?php if (!empty($item['boisson'])): ?>
            <p><strong>Boisson:</strong> <?php echo htmlspecialchars($item['boisson']); ?></p>
        <?php endif; ?>
    </div>
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
    #close-popup {
        color: white;
    }

    #cart-items {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 20px;
    }

    .order-item {
        width: max-content;
    }

    .delete-item {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    z-index: 10; 
}

.cart-item {
    position: relative;
    padding: 10px;
    border: 2px solid #B20F0F;
    margin-bottom: 10px;
    border-radius: 5px;
    background-color: rgba(243, 241, 241, 0.5);
}

</style>
