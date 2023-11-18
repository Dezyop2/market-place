<?php
require_once 'connexion.php';

$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        switch ($_POST["action"]) {
            case "create":
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
                    echo "Erreur lors de l'ajout du produit : " . $stmt->error;
                }
                break;

            case "update":
                // UPDATE (Mettre à jour un produit)
                if (isset($_POST["id"]) && isset($_POST["new_prix"])) {
                    $id = $_POST["id"];
                    $newPrix = $_POST["new_prix"];

                    $sql = "UPDATE produit SET prix = ? WHERE id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $newPrix, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "Le produit a été mis à jour avec succès.";
                    } else {
                        echo "Erreur lors de la mise à jour du produit : " . $stmt->error;
                    }
                } else {
                    echo "Erreur : Identifiant du produit ou nouveau prix manquant.";
                }
                break;

            case "delete":
                // DELETE (Supprimer un produit)
                if (isset($_POST["id"])) {
                    $id = $_POST["id"];
                    $sql = "DELETE FROM produit WHERE id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "Le produit a été supprimé avec succès.";
                    } else {
                        echo "Erreur lors de la suppression du produit : " . $stmt->error;
                    }
                } else {
                    echo "Erreur : Identifiant du produit manquant.";
                }
                break;

            case "read":
                // READ (Lire un produit par ID)
                if (isset($_POST["id"])) {
                    $id = $_POST["id"];
                    $sql = "SELECT * FROM produit WHERE id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT);
                    
                    if ($stmt->execute()) {
                        $product = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($product) {
                            // Afficher les détails du produit
                            echo "ID : " . $product["id"] . "<br>";
                            echo "Nom : " . $product["nom"] . "<br>";
                            echo "Prix : " . $product["prix"] . "<br>";
                            echo "Description : " . $product["bio"] . "<br>";
                            echo "Stock : " . $product["stock"] . "<br>";
                            // Vous pouvez également afficher l'image ici si nécessaire
                        } else {
                            echo "Aucun produit trouvé pour cet ID.";
                        }
                    } else {
                        echo "Erreur lors de la lecture du produit : " . $stmt->error;
                    }
                } else {
                    echo "Erreur : L'ID du produit n'a pas été spécifié.";
                }
                break;

            default:
                echo "Action non reconnue.";
                break;
        }
    } else {
        echo "Étape 1 ratée";
    }
}

$pdo = null;
?>
