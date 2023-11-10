<?php
require_once 'connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pnom = $_POST["pnom"];
    $pprix = $_POST["pprix"];
    $pbio = $_POST["pbio"];
    $pstock = $_POST["pstock"];

    if (isset($_FILES["pimage"]) && $_FILES["pimage"]["error"] == 0) {
        $imageData = file_get_contents($_FILES["pimage"]["tmp_non"]);
        $imageType = $_FILES["pimage"]["type"];
    } else {
        echo "Erreur : Veuillez sélectionner une image valide.";
        exit;
    }

    $sql = "INSERT INTO products (nom, prix, bio, stock, image_data, image_type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bind_param("ssssbs", $pnom, $pprix, $pbio, $pstock, $imageData, $imageType);

    if ($stmt->execute()) {
        echo "Le produit a été ajouté avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$pdoManager->closeConnection();
?>