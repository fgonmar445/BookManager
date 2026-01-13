<?php
// config/Database.php
class Database
{
    private $host = "localhost";
    private $db_name = "login-php";
    private $username = "login-php";
    private $password = "1234";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";

            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,          // Excepciones
                PDO::ATTR_EMULATE_PREPARES => false,                 // Preparadas reales
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // Fetch por defecto
            ]);
        } catch (PDOException $exception) {
            echo "Error de conexión a la base de datos: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
