<?php
require_once 'connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        echo "deuxieme étape";
        if ($_POST["action"] == "create") {

                // CREATE (Ajouter un produit)

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
                echo "erreur ajout";
            }
        } elseif ($_POST["action"] == "update") {

                // UPDATE (Mettre à jour un produit)

            $id = $_POST["id"];
            $newPrix = $_POST["new_prix"];

            $sql = "UPDATE produit SET prix = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $newPrix, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Le produit a été mis à jour avec succès.";
            } else {
                echo "Erreur : " . $stmt->error;
            }
        } elseif ($_POST["action"] == "delete") {

                // DELETE (Supprimer un produit)

            $id = $_POST["id"];

            $sql = "DELETE FROM produit WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Le produit a été supprimé avec succès.";
            } else {
                echo "Erreur : " . $stmt->error;
            }
        }
    }else{
        echo "etape 1 raté";
    }
}

                // READ (Lire tous les produits)

// $sql = "SELECT * FROM produit";
// $result = $pdo->query($sql);
// if ($result) {
//     echo "<h2>Liste des produits :</h2>";
//     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//         echo "ID : " . $row["id"] . ", Nom : " . $row["nom"] . ", Prix : " . $row["prix"] . "<br>";
//     }
// } else {
//     echo "Aucun produit trouvé.";
// }

// $pdoManager->closeConnection();

$pdo = null;

?>