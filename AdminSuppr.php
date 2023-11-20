<?php
include_once 'templates/headerAdmin.html';

require_once 'php/connexion.php';
$pdoManager = new DBManagement("market-nws");
$pdo = $pdoManager->getPDO();

$sql = "SELECT * FROM produit WHERE suppr = 0";
$stmt = $pdo->query($sql);

if ($stmt) {
    echo '<form method="POST" action="php/CRUD.php">';
    echo '<div class="tableau-admin"><table><thead>';
    echo '    <input type="hidden" name="action" value="delete">';
    echo '<tr><th>ID</th><th>Nom</th><th>Prix</th><th>Bio</th><th>Stock</th><th>Supprimer</th></tr>';
    echo '</thead><tbody>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row["idproduit"] . '</td>';
        echo '<td>' . $row["nom"] . '</td>';
        echo '<td>' . $row["prix"] . '</td>';
        echo '<td>' . $row["bio"] . '</td>';
        echo '<td>' . $row["stock"] . '</td>';
        echo '<td><input type="submit" name="supprimer[' . $row["idproduit"] . ']" value="Supprimer"></td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
    echo '</form>';
} else {
    echo "Erreur lors de la récupération des produits : " . $pdo->error;
}

$pdo = null;
?>
