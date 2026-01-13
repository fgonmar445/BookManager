<?php
require_once __DIR__ . '/../config/Database.php';

class Usuario
{
    private $PDO;
    private $tabla_nombre = "users";

    public function __construct()
    {
        // Crear conexión a la base de datos
        $database = new Database();
        $this->PDO = $database->getConnection();
    }

    public function login($username, $password)
    {
        /******************************************************
         * 1. Buscar usuario por su identificador
         ******************************************************/
        $query = "SELECT idUser, password FROM " . $this->tabla_nombre . " 
                  WHERE idUser = ? LIMIT 1";

        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        // Hash falso para igualar tiempos en caso de usuario inexistente
        $fakeHash = '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';

        /******************************************************
         * 2. Usuario no encontrado → igualar tiempos
         ******************************************************/
        if ($stmt->rowCount() === 0) {
            password_verify($password, $fakeHash);
            return false;
        }

        /******************************************************
         * 3. Obtener datos del usuario
         ******************************************************/
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || !isset($row['password'])) {
            // Seguridad adicional: si falta la columna password
            password_verify($password, $fakeHash);
            return false;
        }

        /******************************************************
         * 4. Verificar contraseña real
         ******************************************************/
        if (password_verify($password, $row['password'])) {

            // Eliminar la contraseña antes de devolver datos
            unset($row['password']);

            return $row;
        }

        /******************************************************
         * 5. Contraseña incorrecta → igualar tiempos
         ******************************************************/
        password_verify($password, $fakeHash);
        return false;
    }
}
