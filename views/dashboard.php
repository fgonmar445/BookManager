<?php
require_once __DIR__ . '/../config/auth.php';

$title = "Dashboard";
$hideNavbar = false;   // Mostrar navbar
$bodyClass = "";

ob_start();
?>

<div class="container mt-4 mb-2 pb-2">

    <h2 class="fw-bold mb-4">Dashboard de Libros</h2>

    <!-- TARJETAS DE ESTADÍSTICAS -->
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <h5>Total de libros</h5>
                <p class="display-6 text-primary"><?= $stats['total'] ?></p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <h5>Disponibles</h5>
                <p class="display-6 text-success"><?= $stats['disponibles'] ?></p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <h5>Precio promedio</h5>
                <p class="display-6 text-info"><?= $stats['promedio'] ?> €</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <h5>Libro más caro</h5>
                <p class="fw-bold mb-0"><?= $stats['caro']['titulo'] ?></p>
                <p class="text-danger"><?= $stats['caro']['precio'] ?> €</p>
            </div>
        </div>

    </div>

    <!-- ÚLTIMOS LIBROS -->
    <h4 class="mt-5 mb-1">Últimos libros añadidos</h4>

    <div class="card shadow">
        <div class="card-body pb-1">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($stats['recientes'] as $libro): ?>
                        <tr>
                            <td><?= htmlspecialchars($libro['titulo']) ?></td>
                            <td><?= htmlspecialchars($libro['autor']) ?></td>
                            <td><?= htmlspecialchars($libro['fecha_publicacion']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>
<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";
?>