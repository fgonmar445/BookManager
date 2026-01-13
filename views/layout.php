<?php
// Cabeceras de seguridad
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("X-XSS-Protection: 1; mode=block");

// Content Security Policy (ajustada para Bootstrap y tus scripts)

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'BookManager' ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="/BookManager/public/styles.css">
</head>

<body class="<?= $bodyClass ?? '' ?>" style="min-height: 100vh; margin:0;">

    <!-- NAVBAR (solo si no está oculto) -->
    <?php if (empty($hideNavbar)): ?>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php?action=listar">
                    <i class="bi bi-book-half"></i> BookManager
                </a>

                <?php if (isset($_SESSION['usuario_logueado']) && $_SESSION['usuario_logueado'] === true): ?>
                    <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <?php if (!empty($noContainer)): ?>
        <?= $content ?>
    <?php else: ?>
        <div class="container mt-4">
            <?= $content ?>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script propio -->
    <script src="/BookManager/public/app.js"></script>

    <script>
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('message');
            window.history.replaceState({}, '', url);

            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) alert.remove();
            }, 2000);
        }
    </script>


</body>

</html>