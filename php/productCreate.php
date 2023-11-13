<?php
require_once 'connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prix = $_POST["prix"];
    $bio = $_POST["bio"];
    $stock = $_POST["stock"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
        $imageType = $_FILES["image"]["type"];
    } else {
        echo "Erreur : Veuillez sélectionner une image valide.";
        exit;
    }

    $sql = "INSERT INTO produit (nom, prix, bio, stock, image_data, image_type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $nom, PDO::PARAM_STR);
    $stmt->bindParam(2, $prix, PDO::PARAM_STR);
    $stmt->bindParam(3, $bio, PDO::PARAM_STR);
    $stmt->bindParam(4, $stock, PDO::PARAM_STR);
    $stmt->bindParam(5, $imageData, PDO::PARAM_LOB);
    $stmt->bindParam(6, $imageType, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Le produit a été ajouté avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$pdoManager->closeConnection();
?>