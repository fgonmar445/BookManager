<?php
require_once __DIR__ . '/../config/Database.php';                      // incluimos el código de conexión a la BD

class Usuario
{
    private $PDO;
    private $tabla_nombre = "users";                 // Tu tabla de usuarios

    public function __construct()
    {
        $database = new Database();                    // aquí se invoca al constructor Database, que crea la conexión
        $this->PDO = $database->getConnection();       // y se almacena en el objeto usuario, cuando se invoca su constructor
    }

    public function login($idusuario, $password)
{
    // 1. Buscar el usuario por su ID
    $query = "SELECT * FROM " . $this->tabla_nombre . " WHERE idUser = ? LIMIT 1";
    $stmt = $this->PDO->prepare($query);
    $stmt->bindParam(1, $idusuario);
    $stmt->execute();

    // 2. Si no existe, devolver false
    if ($stmt->rowCount() === 0) {
        return false;
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Verificar la contraseña hasheada
    if (password_verify($password, $row['password'])) {
        return $row; // Login correcto
    }

    return false; // Contraseña incorrecta
}
}