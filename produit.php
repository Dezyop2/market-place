<?php
include_once("templates/header.html");
require_once 'php/connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM produit WHERE idproduit = :id"; // Ajout de "*"
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $productId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo "<div class='all-info'>";
            echo "<h2 class='product-title'>" . $product["nom"] . "</h2>";
            echo '<div class="product-image-container">';
            echo '<img src="data:' . $product["image_type"] . ';base64,' . base64_encode($product["image_data"]) . '" alt="' . $product["nom"] . '" class="product-image">';
            echo '</div>';
            echo "<p><a>Description : </a>" . $product["bio"] . "</p>";
            echo "<p><a>prix : </a>" . $product["prix"] . "</p>";
            echo '<form method="post" action="cart.php">';
            echo '<input type="hidden" name="idproduit" value="' . $product["idproduit"] . '">';
            echo '<input type="hidden" name="nom" value="' . $product["nom"] . '">';
            echo '<input type="hidden" name="prix" value="' . $product["prix"] . '">';
            echo '<input type="submit" name="ajouter_panier" value="Ajouter au panier">';
            echo '</form>';
            echo "</div>";
        } else {
            echo "Aucun produit trouvé pour l'ID spécifié.";
        }
    } else {
        echo "Erreur lors de la récupération du produit : " . $stmt->errorInfo()[2];
    }
} else {
    echo "Aucun ID de produit spécifié.";
}
?>
