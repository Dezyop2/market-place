<?php
include_once 'templates/headerAdmin.html';

require_once 'php/connexion.php';
$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["modifier"])) {
        // Mettre à jour les produits dans la base de données
        if (isset($_POST["idproduit"])) {
            $idproduit = $_POST["idproduit"];
            $noms = $_POST["nom"];
            $prix = $_POST["prix"];
            $bio = $_POST["bio"];
            $stock = $_POST["stock"];

            for ($i = 0; $i < count($idproduit); $i++) {
                $sql = "UPDATE produit SET nom = ?, prix = ?, bio = ?, stock = ? WHERE idproduit = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $noms[$i], PDO::PARAM_STR);
                $stmt->bindParam(2, $prix[$i], PDO::PARAM_STR);
                $stmt->bindParam(3, $bio[$i], PDO::PARAM_STR);
                $stmt->bindParam(4, $stock[$i], PDO::PARAM_STR);
                $stmt->bindParam(5, $idproduit[$i], PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo "Le produit avec l'ID " . $idproduit[$i] . " a été mis à jour avec succès.<br>";
                } else {
                    echo "Erreur lors de la mise à jour du produit avec l'ID " . $idproduit[$i] . " : " . $stmt->error . "<br>";
                }
            }
        }
    } elseif (isset($_POST["supprimer"])) {
        // Mettre à jour la valeur 'suppr' à 1 pour le produit
        if (isset($_POST["idproduit"])) {
            $idproduit = key($_POST["supprimer"]);
            $sql = "UPDATE produit SET suppr = 1 WHERE idproduit = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $idproduit, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                echo "Le produit avec l'ID " . $idproduit . " a été marqué comme supprimé avec succès.<br>";
            } else {
                echo "Erreur lors de la mise à jour de la valeur 'suppr' pour le produit avec l'ID " . $idproduit . " : " . $stmt->error . "<br>";
            }
        }
    }
}

$sql = "SELECT * FROM produit WHERE suppr = 0";
$stmt = $pdo->query($sql);

if ($stmt) {
    echo '<form method="POST" action="AdminMea.php">';
    echo '<div class="tableau-admin"><table><thead>';
    echo '<tr><th>ID</th><th>Nom</th><th>Prix</th><th>Stock</th><th>Mettre en avant</th></tr>';
    echo '</thead><tbody>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row["idproduit"] . '</td>';
        echo '<td>' . $row["nom"] . '</td>';
        echo '<td>' . $row["prix"] . '</td>';
        echo '<td>' . $row["stock"] . '</td>';
        echo '<td><input type="hidden" name="idproduit[]" value="' . $row["idproduit"] . '"><input class="boutton-mea" type="submit" name="mea[' . $row["idproduit"] . ']" value="mettre en avant"></td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
    echo '</form>';
} else {
    echo "Erreur lors de la récupération des produits : " . $pdo->error;
}

$pdo = null;
?>
