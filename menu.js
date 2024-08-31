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
                price: parseFloat(this.getAttribute('data-product-price')),
                category: parseInt(this.getAttribute('data-category'))
            };
            
            if ([6, 7].includes(selectedProduct.category)) {
                const modal = new bootstrap.Modal(document.getElementById('addToCartMenuModal'));
                modal.show();
            } else if (selectedProduct.category === 2) {
                const modal = new bootstrap.Modal(document.getElementById('addToCartBoissonModal'));
                modal.show();
            } else if ([9, 4, 5].includes(selectedProduct.category)) { 
                const modal = new bootstrap.Modal(document.getElementById('addToCartSandwichModal'));
                modal.show();
            } else if (selectedProduct.category === 8) { 
                const modal = new bootstrap.Modal(document.getElementById('addToCartBarquetteModal'));
                modal.show();
            }
        });
    });

    document.getElementById('confirmAddMenuToCart').addEventListener('click', function () {
        submitForm('customizeMenuForm', selectedProduct, 'addToCartMenuModal');
    });

    document.getElementById('confirmAddBoissonToCart').addEventListener('click', function () {
        submitSimpleForm(selectedProduct, 'addToCartBoissonModal');
    });

    document.getElementById('confirmAddSandwichToCart').addEventListener('click', function () {
        submitForm('customizeSandwichForm', selectedProduct, 'addToCartSandwichModal');
    });

    document.getElementById('confirmAddBarquetteToCart').addEventListener('click', function () {
        submitForm('customizeBarquetteForm', selectedProduct, 'addToCartBarquetteModal');
    });

    function submitForm(formId, product, modalId) {
        const form = document.getElementById(formId);
        const formData = new FormData(form);
        formData.append('product_id', product.id);
        formData.append('quantity', 1);

        fetch('add_panier.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                updateCartDisplay();
                resetModal(formId, modalId);
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }

    function submitSimpleForm(product, modalId) {
        const formData = new FormData();
        formData.append('product_id', product.id);
        formData.append('quantity', 1);

        fetch('add_panier.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                updateCartDisplay();
                resetModal(null, modalId);
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }

    function resetModal(formId, modalId) {
        if (formId) {
            document.getElementById(formId).reset();
        }
        const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        modal.hide();
    }

    function updateCartDisplay() {
        fetch('get_cart.php')
        .then(response => response.json())
        .then(data => {
            let cartHTML = '';
            let total = 0;
            data.cart.forEach(item => {
                cartHTML += `<p>${item.name} - ${item.quantity} x ${item.price}€</p>`;
                total += item.price * item.quantity;
            });
            document.getElementById('cart-items').innerHTML = cartHTML || '<p>Votre panier est vide.</p>';
            document.getElementById('bouton-panier').innerHTML = `Total de votre commande: ${total.toFixed(2)}€`;
        })
        .catch(error => console.error('Erreur:', error));
    }

    updateCartDisplay();
});
