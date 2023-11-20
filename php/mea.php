<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connexion.php';

    $pdoManager = new DBManagement('market-nws');
    $pdo = $pdoManager->getPDO();

    $productId = $_POST['id'];

    if (isset($_POST['forwardButton'])) {
        $forwardValue = ($_POST['forwardButton'] === 'Mettre en avant') ? 1 : 0;

        $sqlUpdate = "UPDATE produit SET mise_avant = :mise_avant WHERE idproduit = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':mise_avant', $forwardValue, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id', $productId, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            header('Location: ../AdminMea.php');
            exit();
        } else {
            echo 'Erreur lors de la mise à jour.';
        }
    } else {
        echo 'Action non spécifiée.';
    }
} else {
    echo 'Méthode non autorisée.';
}
?>