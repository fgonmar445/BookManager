<?php
require_once __DIR__ . '/../config/auth.php';

$title = "Crear Libro";
$showLogout = false;
$noContainer = true;

/* Esto centra vertical y horizontalmente */
$bodyClass = "d-flex justify-content-center align-items-center";

ob_start();
?>

<div class="login-card" style="width: 500px;">

    <div class="card-header text-center text-white">
        <h4>Crear Nuevo Libro</h4>
    </div>

    <div class="card-body">

        <form id="formLibro" method="POST" action="index.php?action=create">
            <input type="hidden" name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">



            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
                <div id="tituloHelp" class="form-text text-warning" style="visibility:hidden;"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Autor</label>
                <input type="text" id="autor" name="autor" class="form-control" required>
                <div id="autorHelp" class="form-text text-warning" style="visibility:hidden;"></div>

            </div>

            <div class="mb-3">
                <label class="form-label">Fecha de Publicación</label>
                <input type="date" id="fecha_publicacion" name="fecha_publicacion" class="form-control" required>
                <div id="fecha_publicacionHelp" class="form-text text-warning" style="visibility:hidden;"></div>

            </div>

            <div class="mb-3">
                <label class="form-label">Precio (€)</label>
                <input type="number" step="0.01" id="precio" name="precio" class="form-control" required>
                <div id="precioHelp" class="form-text text-warning" style="visibility:hidden;"></div>

            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="disponible" value="1" id="disponible">
                <label class="form-check-label" for="disponible">
                    Disponible
                </label>
            </div>

            <div class="d-flex justify-content-center">
                <button class="btn w-75" style="background:#ffdd57; color:#283e51; font-weight:bold;">
                    Crear Libro
                </button>
            </div>

        </form>

    </div>

    <div class="card-footer text-center">
        <a href="index.php?action=listar" class="btn link-light">Volver al listado</a>
    </div>

</div>

<script src="/BookManager/public/validarLibro.js"></script>


<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";
?>