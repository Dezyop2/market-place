<?php
include_once 'templates/headerAdmin.html';

require_once 'php/connexion.php';
$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();


class ProductListWithActions
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function displayProductList()
    {
        $sql = "SELECT * FROM produit WHERE suppr = 0";
        $stmt = $this->pdo->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($products)) {
            foreach ($products as $product) {
                $this->renderProductDetails($product);
            }
        } else {
            echo 'Aucun produit n\'est disponible pour le moment.';
        }
    }

    private function renderProductDetails($product)
    {
        echo 'Nom : ' . $product['nom'] . '<br>';
        echo 'Prix : ' . $product['prix'] . '<br>';
        echo 'Description : ' . $product['bio'] . '<br>';
        echo 'Stock : ' . $product['stock'] . '<br>';

        if ($product['mise_avant'] == 0) {
            echo '<form method="post" action="php/mea.php">';
            echo '<input type="hidden" name="id" value="' . $product['idproduit'] . '">';
            echo '<input type="submit" name="forwardButton" value="Mettre en avant">';
            echo '</form>';
        } else {
            echo '<form method="post" action="php/mea.php">';
            echo '<input type="hidden" name="id" value="' . $product['idproduit'] . '">';
            echo '<input type="submit" name="forwardButton" value="Ne plus mettre en avant">';
            echo '</form>';
        }
    }
}

$pdoManager = new DBManagement('market-nws');
$pdo = $pdoManager->getPDO();

$productListWithActions = new ProductListWithActions($pdo);
$productListWithActions->displayProductList();
?>
