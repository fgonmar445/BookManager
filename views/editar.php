<?php require_once __DIR__ . '/../config/auth.php'; ?>


<!-- views/libros/editar.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Libro</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow">
                    <div class="card-header bg-warning text-dark text-center">
                        <h4>Editar Libro</h4>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="index.php?action=edit&id=<?php echo $libro_data->id; ?>">

                            <input type="hidden" name="id" value="<?php echo $libro_data->id; ?>">

                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" name="titulo" class="form-control"
                                    value="<?php echo htmlspecialchars($libro_data->titulo); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <input type="text" name="autor" class="form-control"
                                    value="<?php echo htmlspecialchars($libro_data->autor); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fecha de Publicación</label>
                                <input type="date" name="fecha_publicacion" class="form-control"
                                    value="<?php echo htmlspecialchars($libro_data->fecha_publicacion); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" step="0.01" name="precio" class="form-control"
                                    value="<?php echo htmlspecialchars($libro_data->precio); ?>" required>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="disponible" id="disponible"
                                    <?php echo $libro_data->disponible ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="disponible">
                                    Disponible
                                </label>
                            </div>

                            <button type="submit" name="update" class="btn btn-primary w-100">
                                Actualizar Libro
                            </button>

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