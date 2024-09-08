<style>

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
    padding-top: 10px;
    border-top: 1px solid #e5e5e5;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5PX;
}

.popup-buttons .btn {
    width: 45%;
}

#close-popup {
    color: white;
}


    #close-popup {
        color: white;
    }

    #submit-popup {
        font-size: 30px;
        color: #FFF;
        
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

.btn-delete-order {
    font-size: 30px;
    border-radius: 5px;
    background-color: #B20F0F;
    width: auto;
    color: white;
}


#cancel-order{
    height: 60PX;
    BORDER: NONE;
    width: 100%;
    PADDING: 0PX 50PX;
}

</style>
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
                                <button type="submit" class="btn-delete-order" id="cancel-order">Annuler</button>
                            </form>
                        </div>
                    </div>

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
