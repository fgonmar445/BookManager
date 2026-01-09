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
        $query = "INSERT INTO " . $this->table_name . " 
          SET titulo=:titulo, autor=:autor, fecha_publicacion=:fecha_publicacion,
              precio=:precio, disponible=:disponible";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":fecha_publicacion", $this->fecha_publicacion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":disponible", $this->disponible, PDO::PARAM_INT);

        return $stmt->execute();
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
        }
    }

    // Actualizar un libro
    public function update()
    {
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

        return $stmt->execute();
    }

    // Eliminar un libro
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
