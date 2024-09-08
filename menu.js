document.addEventListener('DOMContentLoaded', function () {
    const categoryItems = document.querySelectorAll('.categorie-list li');
    const products = document.querySelectorAll('.menus .menu');
    let selectedProduct = null;
    const additionalSaucePrice = 0.50;

    // Fonction pour retirer la classe active de toutes les catégories
    function removeActiveCategoryClass() {
        categoryItems.forEach(item => {
            item.classList.remove('active-category');
        });
    }

    // Filtre les produits par catégorie
    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            const categoryId = this.getAttribute('data-category');
            
            removeActiveCategoryClass();
            
            this.classList.add('active-category');
            
            products.forEach(product => {
                if (product.getAttribute('data-category') === categoryId) {
                    product.style.display = 'flex';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });

    // Sélection des produits et affichage des modals
    products.forEach(product => {
        product.addEventListener('click', function (event) {
            if (event.target.classList.contains('support-logo')) {
                event.stopPropagation();
                return;
            }

            selectedProduct = {
                id: this.getAttribute('data-product-id'),
                name: this.getAttribute('data-product-name'),
                price: parseFloat(this.getAttribute('data-product-price')),
                category: parseInt(this.getAttribute('data-category'))
            };

            // Modal catégorie
            switch (selectedProduct.category) {
                case 2: // Boissons
                    showModal('addToCartBoissonModal');
                    break;
                case 3: // Kofta
                case 4: // Doner
                case 5: // Kebab
                    showModal('addToCartSandwichModal', '#customizeSandwichForm');
                    break;
                case 6: // Menu
                case 7: // Menu
                    showModal('addToCartMenuModal', '#customizeMenuForm');
                    break;
                case 8: // Barquette
                    showModal('addToCartBarquetteModal', '#customizeBarquetteForm');
                    break;
                case 9: // Dessert
                    showModal('addToCartDessertModal');
                    break;
                default:
                    alert('Catégorie non prise en charge.');
            }
        });
    });

    function showModal(modalId, formSelector) {
        resetForm(formSelector);
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();

        if (formSelector) {
            handleSauceSelection(formSelector);
            handleSupplementSelection(formSelector); // Gérer les suppléments
        }
    }

    function resetForm(formSelector) {
        if (formSelector) {
            const form = document.querySelector(formSelector);
            if (form) {
                form.reset(); // Réinitialise le formulaire
            }
            updatePrice(selectedProduct.price, 0, formSelector); 
        }
    }

    function handleSauceSelection(formSelector) {
        const sauceInputs = document.querySelectorAll(`${formSelector} input[name="sauce[]"]`);
        sauceInputs.forEach(sauce => {
            sauce.addEventListener('change', function () {
                const selectedSauces = document.querySelectorAll(`${formSelector} input[name="sauce[]"]:checked`);
                const extraCost = selectedSauces.length > 2 ? (selectedSauces.length - 2) * additionalSaucePrice : 0;
                updatePrice(selectedProduct.price + extraCost, selectedSauces.length, formSelector);
            });
        });
    }

    function handleSupplementSelection(formSelector) {
        const cheeseInput = document.querySelector(`${formSelector} input[name="supplements[]"][value="cheese"]`);
        const viandeInput = document.querySelector(`${formSelector} input[name="supplements[]"][value="viande"]`);

        function updateSupplementPrice() {
            let extraCost = 0;
            if (cheeseInput.checked) extraCost += 1; // 1€ pour le supplément cheese
            if (viandeInput.checked) extraCost += 1; // 1€ pour le supplément viande

            const totalPrice = selectedProduct.price + extraCost; // Prix total avec les suppléments
            document.querySelector('.modal-title').innerText = `Personnalisez votre menu - Total: ${totalPrice.toFixed(2)}€`;
        }

        cheeseInput.addEventListener('change', updateSupplementPrice);
        viandeInput.addEventListener('change', updateSupplementPrice);
    }

    function updatePrice(newPrice, sauceCount, formSelector) {
        document.querySelector('.modal-title').innerText = `Personnalisez votre menu - Total: ${newPrice.toFixed(2)}€`;

        const sauceMessage = document.querySelector(`${formSelector} #sauce-extra-message`);
        if (sauceCount > 2) {
            sauceMessage.style.display = 'flex';
        } else {
            sauceMessage.style.display = 'none';
        }
    }

    function submitForm(formId, product, modalId) {
        let formData;
        
        if (formId === null) {
            formData = new FormData();
        } else {
            const form = document.getElementById(formId);
            formData = new FormData(form);
        }
        
        formData.append('product_id', product.id);
        formData.append('quantity', 1);
    
        fetch('add_panier.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                updateCartDisplay();  // Rafraîchir l'affichage du panier
                resetModal(formId, modalId); // Réinitialise le modal
            } else {
                console.error('Erreur: ' + data.message);
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
   // Ajoutez cet événement après l'affichage du panier
function updateCartDisplay() {
    fetch('get_cart.php')
    .then(response => response.json())
    .then(data => {
        let cartHTML = '';
        let total = 0;
        data.cart.forEach((item, index) => {
            cartHTML += `<div class="cart-item">`;
            cartHTML += `<p><strong>${item.name} - ${item.quantity} x ${item.price.toFixed(2)}€</strong></p>`;
            if (item.crudites) {
                cartHTML += `<p><strong>Crudités:</strong> ${item.crudites}</p>`;
            }
            if (item.sauce) {
                cartHTML += `<p><strong>Sauce:</strong> ${item.sauce}</p>`;
            }
            if (item.boisson) {
                cartHTML += `<p><strong>Boisson:</strong> ${item.boisson}</p>`;
            }
            cartHTML += `<img src="img/icons/croix-rouge.png" class="delete-item" data-index="${index}" alt="Supprimer" style="cursor: pointer; width: 20px; height: 20px;">`;
            cartHTML += `</div>`;
            total += item.price * item.quantity;
        });
        document.getElementById('cart-items').innerHTML = cartHTML || '<p>Votre panier est vide.</p>';
        document.getElementById('bouton-panier').innerHTML = `Total de votre commande: ${total.toFixed(2)}€`;

        // Ajouter l'événement de suppression pour chaque croix rouge
        document.querySelectorAll('.delete-item').forEach(function (deleteButton) {
            deleteButton.addEventListener('click', function () {
                const itemIndex = this.getAttribute('data-index');
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'index=' + itemIndex
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateCartDisplay(); // Mettre à jour le panier après suppression
                    } else {
                        console.error('Erreur: ' + data.message);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });
        });
    })
    .catch(error => console.error('Erreur:', error));
}

    
    document.getElementById('confirmAddMenuToCart').addEventListener('click', function () {
        submitForm('customizeMenuForm', selectedProduct, 'addToCartMenuModal');
    });

    document.getElementById('confirmAddSandwichToCart').addEventListener('click', function () {
        submitForm('customizeSandwichForm', selectedProduct, 'addToCartSandwichModal');
    });

    document.getElementById('confirmAddBoissonToCart').addEventListener('click', function () {
        submitForm(null, selectedProduct, 'addToCartBoissonModal');
    });

    document.getElementById('confirmAddBarquetteToCart').addEventListener('click', function () {
        submitForm('customizeBarquetteForm', selectedProduct, 'addToCartBarquetteModal');
    });

    document.getElementById('confirmAddDessertToCart').addEventListener('click', function () {
        submitForm(null, selectedProduct, 'addToCartDessertModal');
    });

    updateCartDisplay();

    const supportLogos = document.querySelectorAll('.support-logo');
    supportLogos.forEach(logo => {
        logo.addEventListener('click', function (event) {
            event.stopPropagation();
            const description = this.getAttribute('data-description');
            showSupportModal(description);
        });
    });

    function showSupportModal(description) {
        const modal = new bootstrap.Modal(document.getElementById('supportModal'));
        document.querySelector('#supportModal .modal-title').innerText = "Description du produit";
        document.querySelector('#supportModal .modal-body').innerText = description;
        modal.show();
    }
});
