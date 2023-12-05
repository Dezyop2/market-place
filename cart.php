<?php
include_once("templates/header.html");

// panier.php

session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

if (isset($_POST['ajouter_panier'])) {
    // Récupérez les informations du produit depuis le formulaire
    $idproduit = $_POST['idproduit'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];

    // Ajoutez le produit au panier
    $_SESSION['panier'][] = array(
        'idproduit' => $idproduit,
        'nom' => $nom,
        'prix' => $prix,
        // Ajoutez d'autres informations du produit au besoin
    );

    echo "Le produit a été ajouté au panier.";
}

// Supprimer un produit du panier
if (isset($_POST['supprimer_produit'])) {
    $index = $_POST['index'];

    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
    }
}

// Affichez ici le contenu du panier (noms et prix uniquement)
echo '<h2>Votre Panier</h2>';
echo '<ul>';

foreach ($_SESSION['panier'] as $index => $produit) {
    echo '<li>';
    echo 'Nom : ' . $produit['nom'] . ' | ';
    echo 'Prix : ' . $produit['prix'];
    // Vous pouvez ajouter d'autres informations du produit au besoin

    // Formulaire pour supprimer le produit du panier
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="index" value="' . $index . '">';
    echo '<button type="submit" name="supprimer_produit">Supprimer</button>';
    echo '</form>';

    echo '</li>';
}

echo '</ul>';
?>