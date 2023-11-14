<?php include_once 'templates/header.html'; ?>

<p class="titre_stock">
    Fin de stock
</p>

<?php
require_once 'php/connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

$sql = "SELECT * FROM produit ORDER BY stock ASC LIMIT 1";
$stmt = $pdo->query($sql);

if ($stmt) {
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        echo '<div class="product-container">';
        echo '<div class="product-details">';
        echo "<h2 class='product-title'>" . $product["nom"] . "</h2>";
        echo '<img src="data:' . $product["image_type"] . ';base64,' . base64_encode($product["image_data"]) . '" alt="' . $product["nom"] . '" class="product-image">';
        echo '<div class="product-info">';
        echo "<p class='product-price'><a class='titre'>prix : </a>" . $product["prix"] . "</p>";
        echo '</div>';
        echo '</div>';
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