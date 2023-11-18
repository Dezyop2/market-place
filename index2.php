<?php include_once 'templates/header.html'; ?>

<p class="titre_stock">
    Tous les produits
</p>

<?php
require_once 'php/connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

$sql = "SELECT * FROM produit WHERE suppr = 0 ORDER BY RAND()";
$stmt = $pdo->query($sql);

if ($stmt) {
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($products) {
        echo '<div class="products-container">';
        foreach ($products as $product) {
            echo '<div class="product-container">';
            echo '<div class="product-details">';
            echo "<h2 class='product-title'>" . $product["nom"] . "</h2>";
            echo '<div class="product-image-container">';
            echo '<img src="data:' . $product["image_type"] . ';base64,' . base64_encode($product["image_data"]) . '" alt="' . $product["nom"] . '" class="product-image">';
            echo '</div>';
            echo "<p class='product-price'><a class='titre'>prix : </a>" . $product["prix"] . "</p>";
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "Aucun produit trouvé.";
    }
} else {
    echo "Erreur : " . $pdo->errorInfo();
}

$pdo = null;
?>

<?php include_once 'templates/footer.html'; ?>