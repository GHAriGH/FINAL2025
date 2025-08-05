<?php
class Database {
    /* private $hostname = "sql107.infinityfree.com";
    private $database = "if0_39512763_gimnasio";
    private $username = "if0_39512763";
    private $password = "qb7adpe3Svc";
    private $charset = "utf8"; */

    private $hostname = "localhost";
    private $database = "gimnasio";
    private $username = "root";
    private $password = "1427";
    private $charset = "utf8";

    function Conectar() {
        try {
            $conexion = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);

            return $pdo;
        } catch(PDOException $e) {
            echo "Error conexion: " . $e->getMessage();
            exit;
        }
    }
}
?>