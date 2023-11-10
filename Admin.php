<?php include_once 'templates/headerAdmin.html'; ?>

<h1>nom bio stock prix image</h1>

    <form class="product-form" method="POST" action="php/productCreate.php" enctype="multipart/form-data">
        <label for="pname" class="form-label">Nom du produit :</label>
        <input type="text" id="pname" name="pname" class="form-input" required><br>
        <label for="pprice" class="form-label">Prix du produit :</label>
        <input type="text" id="pprice" name="pprice" class="form-input" required><br>
        <label for="pdesc" class="form-label">Description du produit :</label>
        <input type="text" id="pdesc" name="pdesc" class="form-input" required><br>
        <label for="pstock" class="form-label">Stock du produit :</label>
        <input type="text" id="pstock" name="pstock" class="form-input" required><br>
        <label for="pimage" class="form-label">Image du produit :</label>
        <input type="file" id="pimage" name="pimage" class="image" accept="image/*"><br>
        <input type="submit" value="Mettre en ligne le produit" class="submit-button">
    </form>
