<?php include_once 'templates/headerAdmin.html'; ?>

<form method="GET" action="adminModif.php">
    <label for="product_name">Choisir un produit :</label>
    <input type="text" id="product_name" name="product_name" placeholder="Nom du produit">
    <input type="submit" value="Modifier">
</form>

<?php
// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["product_name"])) {
    $selectedProductName = $_GET["product_name"];

    // Appeler la fonction de lecture du produit par nom depuis CRUD.php
    $product = readProductByName($selectedProductName);

    if ($product) {
        // Afficher les détails du produit
        echo "ID : " . $product["id"] . "<br>";
        echo "Nom : " . $product["nom"] . "<br>";
        echo "Prix : " . $product["prix"] . "<br>";
        echo "Description : " . $product["bio"] . "<br>";
        echo "Stock : " . $product["stock"] . "<br>";
        // Vous pouvez également afficher l'image ici si nécessaire
    } else {
        echo "Aucun produit trouvé pour ce nom.";
    }
}
?>

<?php
// Inclure le fichier CRUD.php pour la gestion des opérations CRUD
require_once 'php/CRUD.php';

// Vérifier si l'ID du produit à modifier est spécifié
if (isset($_GET['id'])) {
    // Récupérer l'ID du produit à partir de l'URL
    $id = $_GET['id'];

    // Appeler la fonction de lecture du produit par ID depuis CRUD.php
    $product = readProductById($id);

    if ($product) {
        // Afficher le formulaire de modification
?>
        <form class="product-form" method="POST" action="php/CRUD.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <label for="nom" class="form-label">Nom du produit :</label>
            <input type="text" id="nom" name="nom" class="form-input" value="<?php echo $product['nom']; ?>" required><br>
            
            <label for="prix" class="form-label">Prix du produit :</label>
            <input type="text" id="prix" name="new_prix" class="form-input" value="<?php echo $product['prix']; ?>" required><br>
            
            <label for="bio" class="form-label">Description du produit :</label>
            <input type="text" id="bio" name="bio" class="form-input" value="<?php echo $product['bio']; ?>" required><br>
            
            <label for="stock" class="form-label">Stock du produit :</label>
            <input type="text" id="stock" name="stock" class="form-input" value="<?php echo $product['stock']; ?>" required><br>
            
            <label for="image" class="form-label">Image du produit :</label>
            <input type="file" id="image" name="image" class="image" accept="image/*"><br>
            
            <!-- Afficher l'image actuelle -->
            <img src="data:<?php echo $product['image_type']; ?>;base64,<?php echo base64_encode($product['image_data']); ?>" alt="<?php echo $product['nom']; ?>" class="current-image">
            
            <input type="submit" value="Mettre à jour le produit" class="submit-button">
        </form>
<?php
    } else {
        echo "Aucun produit trouvé pour cet ID.";
    }
} else {
    echo "L'ID du produit n'a pas été spécifié.";
}
?>
