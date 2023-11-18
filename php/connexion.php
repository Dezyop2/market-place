<?php
class DBManagement {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $port = '';
    private $db_name;
    private $pdo;

    public function __construct(string $DBName) {
        $this->db_name = $DBName;
        $this->connect();
    }

    private function connect(): void {
        try {
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->db_name};port={$this->port}", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}
?>