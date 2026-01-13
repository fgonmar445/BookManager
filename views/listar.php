<?php
require_once __DIR__ . '/../config/auth.php';

$title = "Listado de Libros";
$showLogout = true;
$bodyClass = "";

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Listado de Libros</h3>
    <a href="index.php?action=create" class="btn btn-success">Añadir Nuevo Libro</a>
</div>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success">
        <?php
        if ($_GET['message'] == 'created') echo 'Libro creado correctamente.';
        if ($_GET['message'] == 'updated') echo 'Libro actualizado correctamente.';
        if ($_GET['message'] == 'deleted') echo 'Libro eliminado correctamente.';
        ?>
    </div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha Publicación</th>
                        <th>Precio (€)</th>
                        <th>Disponible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?= $libro['id'] ?></td>
                            <td><?= htmlspecialchars($libro['titulo']) ?></td>
                            <td><?= htmlspecialchars($libro['autor']) ?></td>
                            <td><?= htmlspecialchars($libro['fecha_publicacion']) ?></td>
                            <td><?= number_format($libro['precio'], 2) ?></td>
                            <td>
                                <?= $libro['disponible']
                                    ? '<span class="badge bg-success">Sí</span>'
                                    : '<span class="badge bg-secondary">No</span>' ?>
                            </td>
                            <td>
                                <a href="index.php?action=edit&id=<?= $libro['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                
                                <form id="form-delete-<?= $libro['id'] ?>"
                                    action="index.php?action=delete"
                                    method="POST"
                                    style="display:inline;">

                                    <input type="hidden" name="id" value="<?= $libro['id'] ?>">

                                    <input type="hidden" name="csrf_token"
                                        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmarEliminacion(<?= $libro['id'] ?>)">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar libro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("form-delete-" + id).submit();
        }
    });
}

</script>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";
?>