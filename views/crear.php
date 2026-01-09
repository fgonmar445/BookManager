<!-- views/libros/crear.php -->
<?php require_once __DIR__ . '/../config/auth.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Libro</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Crear Nuevo Libro</h4>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="index.php?action=create">

                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <input type="text" name="autor" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fecha de Publicación</label>
                                <input type="date" name="fecha_publicacion" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" required>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="disponible" value="1" id="disponible">
                                <label class="form-check-label" for="disponible">
                                    Disponible
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Crear Libro</button>
                        </form>

                    </div>

                    <div class="card-footer text-center">
                        <a href="index.php?action=listar" class="btn btn-link">Volver al listado</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>