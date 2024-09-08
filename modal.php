<div class="modal fade" id="kebabRewardModal" tabindex="-1" aria-labelledby="kebabRewardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kebabRewardModalLabel">Personnaliser votre menu kebab gratuit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customizeKebabForm">
                    <div class="mb-3">
                        <h5>Choisissez vos crudités :</h5>
                        <div class="input-choix-crudites">
                            <input type="checkbox" id="crudites_salade" name="crudites[]" value="salade">
                            <label for="crudites_salade"><img src="img/icons/salade.png" alt="Salade"> Salade</label><br>
                            <input type="checkbox" id="crudites_tomate" name="crudites[]" value="tomate">
                            <label for="crudites_tomate"><img src="img/icons/tomate.png" alt="Tomate"> Tomate</label><br>
                            <input type="checkbox" id="crudites_oignons" name="crudites[]" value="oignons">
                            <label for="crudites_oignons"><img src="img/icons/oignon.png" alt="Oignons"> Oignons</label>
                        </div>
                    </div>

                 
                    <div class="mb-3">
                        <h5>Choisissez votre/vos sauce(s) :</h5>
                        <div>
    <input type="checkbox" id="menu_sauce_blanche" name="sauce[]" value="blanche">
    <label for="menu_sauce_blanche"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Blanche</label><br>
    
    <input type="checkbox" id="menu_sauce_andalouse" name="sauce[]" value="andalouse">
    <label for="menu_sauce_andalouse"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Andalouse</label><br>
    
    <input type="checkbox" id="menu_sauce_algerienne" name="sauce[]" value="algerienne">
    <label for="menu_sauce_algerienne"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Algérienne</label><br>
    
    <input type="checkbox" id="menu_sauce_samourai" name="sauce[]" value="samourai">
    <label for="menu_sauce_samourai"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Samouraï</label><br>
    
    <input type="checkbox" id="menu_sauce_harissa" name="sauce[]" value="harissa">
    <label for="menu_sauce_harissa"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Harissa</label><br>
    
    <input type="checkbox" id="menu_sauce_ketchup" name="sauce[]" value="ketchup">
    <label for="menu_sauce_ketchup"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Ketchup</label><br>
    
    <input type="checkbox" id="menu_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
    <label for="menu_sauce_mayonnaise"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Mayonnaise</label>
</div>

                        <p id="sauce-extra-message" style="color: red; display: none;">Supplément de 0,50€ pour 3 sauces</p>

                    </div>

                    <div class="mb-3">
                        <h5>Ajouter des suppléments :</h5>
                        <div class="input-choix-supplements">
                            <input type="checkbox" id="supplement_cheese" name="supplements[]" value="cheese">
                            <label for="supplement_cheese"><img src="img/icons/fromage.png" alt="Fromage"> Cheese (+1€)</label><br>
                            <input type="checkbox" id="supplement_viande" name="supplements[]" value="viande">
                            <label for="supplement_viande"><img src="img/icons/kebab-viande.png" alt="Viande"> Viande (+1€)</label><br>
                            <input type="checkbox" id="supplement_feta" name="supplements[]" value="feta">
                            <label for="supplement_feta"><img src="img/icons/feta.png" alt="Feta"> Feta (+1€)</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Choisissez votre boisson :</h5>
                        <div>
                            <?php 
                            $stmtBoissons = $pdo->query("SELECT id, name FROM products WHERE category_id = 2");
                            while ($boisson = $stmtBoissons->fetch(PDO::FETCH_ASSOC)): ?>
                                <input type="radio" id="boisson_<?php echo htmlspecialchars($boisson['id']); ?>" name="boisson" value="<?php echo htmlspecialchars($boisson['name']); ?>" required>
                                <label for="boisson_<?php echo htmlspecialchars($boisson['id']); ?>"><img src="img/icons/canette-de-soda.png" alt="Boisson"> <?php echo htmlspecialchars($boisson['name']); ?></label><br>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <input type="hidden" id="product_id" name="product_id" value="19"> <!-- ID du menu kebab -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmKebabReward">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>


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
    <div class="modal-dialog" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addToCartMenuLabel">Personnalisez votre menu</h1>
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
    <label for="menu_sauce_blanche"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Blanche</label><br>
    
    <input type="checkbox" id="menu_sauce_andalouse" name="sauce[]" value="andalouse">
    <label for="menu_sauce_andalouse"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Andalouse</label><br>
    
    <input type="checkbox" id="menu_sauce_algerienne" name="sauce[]" value="algerienne">
    <label for="menu_sauce_algerienne"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Algérienne</label><br>
    
    <input type="checkbox" id="menu_sauce_samourai" name="sauce[]" value="samourai">
    <label for="menu_sauce_samourai"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Samouraï</label><br>
    
    <input type="checkbox" id="menu_sauce_harissa" name="sauce[]" value="harissa">
    <label for="menu_sauce_harissa"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Harissa</label><br>
    
    <input type="checkbox" id="menu_sauce_ketchup" name="sauce[]" value="ketchup">
    <label for="menu_sauce_ketchup"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Ketchup</label><br>
    
    <input type="checkbox" id="menu_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
    <label for="menu_sauce_mayonnaise"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Mayonnaise</label>
</div>

                        <p id="sauce-extra-message" style="color: red; display: none;">Supplément de 0,50€ pour 3 sauces</p>

                    </div>

                    <div class="mb-3">
            <h5>Ajouter des suppléments :</h5>
            <div class="input-choix-supplements">
                <input type="checkbox" id="sandwich_supplement_cheese" name="supplements[]" value="cheese">
                <label for="sandwich_supplement_cheese"><img id="img-icon-cheese" alt="cheese-icon" src="img/icons/fromage.png">  Cheese (+1€)</label><br>
                <input type="checkbox" id="sandwich_supplement_viande" name="supplements[]" value="viande">
                <label for="sandwich_supplement_viande"><img id="img-icon-kebab" alt="kebab-icon" src="img/icons/kebab-viande.png"> Viande (+1€)</label><br>
                
            </div>
        </div>

        <div class="mb-3">
    <h5>Choisissez votre boisson :</h5>
    <div>
        <?php 
        $stmtBoissons = $pdo->query("SELECT id, name FROM products WHERE category_id = 2");
        while ($boisson = $stmtBoissons->fetch(PDO::FETCH_ASSOC)): ?>
            <input type="radio" id="menu_boisson_<?php echo htmlspecialchars($boisson['id']); ?>" name="boisson" value="<?php echo htmlspecialchars($boisson['name']); ?>" required>
            <label for="menu_boisson_<?php echo htmlspecialchars($boisson['id']); ?>">
                <img src="img/icons/canette-de-soda.png" alt="Image boisson" style="width:30px; height:30px; vertical-align:middle;">
                <?php echo htmlspecialchars($boisson['name']); ?>
            </label><br>
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
    <div class="modal-dialog" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addToCartBoissonLabel">Ajouter la boisson</h1>
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
    <div class="modal-dialog" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addToCartSandwichLabel">Personnalisez votre commande</h1>
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
    <input type="checkbox" id="menu_sauce_blanche" name="sauce[]" value="blanche">
    <label for="menu_sauce_blanche"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Blanche</label><br>
    
    <input type="checkbox" id="menu_sauce_andalouse" name="sauce[]" value="andalouse">
    <label for="menu_sauce_andalouse"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Andalouse</label><br>
    
    <input type="checkbox" id="menu_sauce_algerienne" name="sauce[]" value="algerienne">
    <label for="menu_sauce_algerienne"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Algérienne</label><br>
    
    <input type="checkbox" id="menu_sauce_samourai" name="sauce[]" value="samourai">
    <label for="menu_sauce_samourai"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Samouraï</label><br>
    
    <input type="checkbox" id="menu_sauce_harissa" name="sauce[]" value="harissa">
    <label for="menu_sauce_harissa"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Harissa</label><br>
    
    <input type="checkbox" id="menu_sauce_ketchup" name="sauce[]" value="ketchup">
    <label for="menu_sauce_ketchup"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Ketchup</label><br>
    
    <input type="checkbox" id="menu_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
    <label for="menu_sauce_mayonnaise"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Mayonnaise</label>
</div>

                        <p id="sauce-extra-message" style="color: red; display: none;">Supplément de 0,50€ pour 3 sauces</p>

                    </div>
                    <div class="mb-3">
            <h5>Ajouter des suppléments :</h5>
            <div class="input-choix-supplements">
                <input type="checkbox" id="sandwich_supplement_cheese" name="supplements[]" value="cheese">
                <label for="sandwich_supplement_cheese"><img id="img-icon-cheese" alt="cheese-icon" src="img/icons/fromage.png">  Cheese (+1€)</label><br>
                <input type="checkbox" id="sandwich_supplement_viande" name="supplements[]" value="viande">
                <label for="sandwich_supplement_viande"><img id="img-icon-kebab" alt="kebab-icon" src="img/icons/kebab-viande.png"> Viande (+1€)</label><br>
                <input type="checkbox" id="sandwich_supplement_feta" name="supplements[]" value="feta">
        <label for="sandwich_supplement_feta"><img id="img-icon-feta" alt="feta-icon" src="img/icons/feta.png"> Feta (+1€)</label>
            </div>
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
    <div class="modal-dialog" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addToCartBarquetteLabel">Choisissez votre/vos sauce(s)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="customizeBarquetteForm">
            
                <div class="mb-3">
                        <h5>Choisissez votre/vos sauce(s) :</h5>
                        <div>
    <input type="checkbox" id="menu_sauce_blanche" name="sauce[]" value="blanche">
    <label for="menu_sauce_blanche"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Blanche</label><br>
    
    <input type="checkbox" id="menu_sauce_andalouse" name="sauce[]" value="andalouse">
    <label for="menu_sauce_andalouse"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Andalouse</label><br>
    
    <input type="checkbox" id="menu_sauce_algerienne" name="sauce[]" value="algerienne">
    <label for="menu_sauce_algerienne"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Algérienne</label><br>
    
    <input type="checkbox" id="menu_sauce_samourai" name="sauce[]" value="samourai">
    <label for="menu_sauce_samourai"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Samouraï</label><br>
    
    <input type="checkbox" id="menu_sauce_harissa" name="sauce[]" value="harissa">
    <label for="menu_sauce_harissa"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Harissa</label><br>
    
    <input type="checkbox" id="menu_sauce_ketchup" name="sauce[]" value="ketchup">
    <label for="menu_sauce_ketchup"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Ketchup</label><br>
    
    <input type="checkbox" id="menu_sauce_mayonnaise" name="sauce[]" value="mayonnaise">
    <label for="menu_sauce_mayonnaise"><img id="img-icon-sauce" alt="sauce-icon" src="img/icons/sauce-soja.png"> Mayonnaise</label>
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
    <div class="modal-dialog" id="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addToCartDessertLabel">Ajouter le dessert</h1>
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
    <div class="modal-dialog" id="modal-dialog">
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
