<?php
// controllers/LibroController.php
include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/Libro.php';

class LibroController
{
    private $db;
    private $libro;

    public function __construct()
    {

        // Proteger todo el CRUD
        require_once __DIR__ . '/../config/auth.php';

        $database = new Database();
        $this->db = $database->getConnection();
        $this->libro = new Libro($this->db);
    }

    public function index()
    {
        $stmt = $this->libro->read();
        $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . '/../views/listar.php';
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Sanitización
            $this->libro->titulo = htmlspecialchars(trim($_POST['titulo']));
            $this->libro->autor = htmlspecialchars(trim($_POST['autor']));
            $this->libro->fecha_publicacion = $_POST['fecha_publicacion'];
            $this->libro->precio = floatval($_POST['precio']);
            $this->libro->disponible = isset($_POST['disponible']) ? 1 : 0;

            if ($this->libro->create()) {
                header("Location: index.php?action=listar&message=created");
                exit();
            } else {
                $error = "Error al crear libro.";
                include __DIR__ . '/../views/crear.php';
            }
        } else {
            include __DIR__ . '/../views/crear.php';
        }
    }

    public function edit()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Sanitización
            $this->libro->id = intval($_POST['id']);
            $this->libro->titulo = htmlspecialchars(trim($_POST['titulo']));
            $this->libro->autor = htmlspecialchars(trim($_POST['autor']));
            $this->libro->fecha_publicacion = $_POST['fecha_publicacion'];
            $this->libro->precio = floatval($_POST['precio']);
            $this->libro->disponible = isset($_POST['disponible']) ? 1 : 0;

            if ($this->libro->update()) {
                header("Location: index.php?action=listar&message=updated");
                exit();
            } else {
                $error = "Error al actualizar libro.";
            }
        }

        // Mostrar formulario de edición
        if (isset($_GET['id'])) {
            $this->libro->id = $_GET['id'];
            $this->libro->readOne();

            if ($this->libro->titulo) {
                $libro_data = (object)[
                    'id' => $this->libro->id,
                    'titulo' => $this->libro->titulo,
                    'autor' => $this->libro->autor,
                    'fecha_publicacion' => $this->libro->fecha_publicacion,
                    'precio' => $this->libro->precio,
                    'disponible' => $this->libro->disponible
                ];

                include __DIR__ . '/../views/editar.php';
            } else {
                echo "Libro no encontrado.";
            }
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->libro->id = $_GET['id'];

            if ($this->libro->delete()) {
                header("Location: index.php?action=listar&message=deleted");
                exit();
            } else {
                header("Location: index.php?action=listar&message=error_delete");
                exit();
            }
        }
    }
}
