<?php include_once 'templates/headerAdmin.html'; ?>

<form class="product-form" method="POST" action="php/CRUD.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="create">

    <label for="nom" class="form-label">Nom du produit :</label>
    <input type="text" id="nom" name="nom" class="form-input" required><br>
    <label for="prix" class="form-label">Prix du produit :</label>
    <input type="text" id="prix" name="prix" class="form-input" required><br>
    <label for="bio" class="form-label">Description du produit :</label>
    <input type="text" id="bio" name="bio" class="form-input" required><br>
    <label for="stock" class="form-label">Stock du produit :</label>
    <input type="text" id="stock" name="stock" class="form-input" required><br>
    <label for="image" class="form-label">Image du produit :</label>
    <input type="file" id="image" name="image" class="image" accept="image/*"><br>
    <input type="submit" value="Mettre en ligne le produit" class="submit-button">
</form>