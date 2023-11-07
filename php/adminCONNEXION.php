<?php
require_once("connexion.php");

class Authentification {
    private $pdo;

    public function __construct(DBManagement $pdoManager) {
        $this->pdo = $pdoManager->getPDO();
    }

    public function verifierAuthentification($pseudo, $mot_de_passe) {
        $sql = "SELECT * FROM marketadmin WHERE nom = :pseudo";
        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':pseudo', $pseudo);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mdp'])) {
            return true;
        }

        return false;
    }
}

$pdoManager = new DBManagement("market-nws");

$auth = new Authentification($pdoManager);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['nom'];
    $mot_de_passe = $_POST['mdp'];

    if ($auth->verifierAuthentification($pseudo, $mot_de_passe)) {
        header("Location:../Admin.php");
        exit();
    } else {
        echo "L'authentification a échoué. Veuillez réessayer.";
    }
}
?>