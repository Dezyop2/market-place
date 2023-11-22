<?php
include_once 'templates/header.html';
require_once 'php/connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if (isset($_GET['q'])) {
    $searchTerm = $_GET['q'];

    $sql = "SELECT * FROM produit WHERE nom LIKE :searchTerm";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->execute();

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
                echo "<p class='product-price'><a class='titre'>prix : </a>" . $product["prix"] . "</p>";
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "Aucun produit trouvé pour la recherche.";
        }
    } else {
        echo "Erreur lors de la recherche : " . $stmt->errorInfo()[2];
    }
} else {
    echo "Aucun terme de recherche spécifié.";
}

$pdo = null;
?>
