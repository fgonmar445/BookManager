<?php
// models/Libro.php
class Libro
{
    private $conn;
    private $table_name = "libros";

    public $id;
    public $titulo;
    public $autor;
    public $fecha_publicacion;
    public $precio;
    public $disponible;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Leer todos los libros
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Crear un libro
    public function create()
    {
        // Validación interna
        if (empty($this->titulo) || strlen($this->titulo) < 3) return false;
        if (empty($this->autor) || strlen($this->autor) < 3) return false;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->fecha_publicacion)) return false;
        if (!is_numeric($this->precio) || $this->precio < 0) return false;
        if (!in_array($this->disponible, [0, 1], true)) return false;


        $query = "INSERT INTO " . $this->table_name . " 
              (titulo, autor, fecha_publicacion, precio, disponible)
              VALUES (:titulo, :autor, :fecha_publicacion, :precio, :disponible)";



        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":fecha_publicacion", $this->fecha_publicacion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":disponible", $this->disponible, PDO::PARAM_INT);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    // Leer un libro por ID
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->titulo = $row['titulo'];
            $this->autor = $row['autor'];
            $this->fecha_publicacion = $row['fecha_publicacion'];
            $this->precio = $row['precio'];
            $this->disponible = $row['disponible'];
            return true;
        }

        return false;
    }


    // Actualizar un libro
    public function update()
    {
        // Validación interna
        if (empty($this->titulo) || strlen($this->titulo) < 3) return false;
        if (empty($this->autor) || strlen($this->autor) < 3) return false;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->fecha_publicacion)) return false;
        if (!is_numeric($this->precio) || $this->precio < 0) return false;
        if (!in_array($this->disponible, [0, 1], true)) return false;


        $query = "UPDATE " . $this->table_name . "
              SET titulo=:titulo, autor=:autor, fecha_publicacion=:fecha_publicacion,
                  precio=:precio, disponible=:disponible
              WHERE id=:id";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":fecha_publicacion", $this->fecha_publicacion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":disponible", $this->disponible, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    // Eliminar un libro
    public function delete()
    {
        // Validación interna
        if (!is_numeric($this->id) || $this->id <= 0) {
            return false;
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);

        $stmt->execute();

        // Confirmar que realmente se eliminó un registro
        return $stmt->rowCount() > 0;
    }
}
