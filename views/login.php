
<?php
if (isset($_SESSION['usuario_logueado'])) {
    header("Location: index.php?action=dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/login_mvc/public/styles.css">

</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="login-card">

        <h3 class="text-center mb-4">Iniciar Sesión</h3>

        <!-- Mensaje de error GET -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_GET['error']); ?>
        <?php endif; ?>

        <!-- Mensaje de error desde sesión -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
            </div>

            <?php if ($_SESSION['error'] === "Has superado el número máximo de intentos. Inténtalo más tarde."): ?>
                <a href="index.php?action=logout" class="btn btn-danger w-100 mb-3">
                    Cerrar sesión
                </a>
            <?php endif; ?>

            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="index.php?action=authenticate" method="POST" id="form">

            <input type="hidden" name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

            <div class="mb-3">
                <label for="user" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="user" id="user"
                    placeholder="Introduce tu usuario" required>
                <div id="userHelp" class="form-text text-warning" style="display:none;">
                    El usuario debe tener entre 8 y 15 caracteres.
                </div>
            </div>

            <div class="mb-3">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="pass" id="pass"
                    placeholder="Introduce tu contraseña" required>
                <div id="passHelp" class="form-text text-warning" style="display:none;">
                    La contraseña debe tener entre 8 y 15 caracteres y contener mayúsculas, minúsculas y símbolos.
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mt-2 text-white">Entrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/login_mvc/public/verificaciones.js"></script>

</body>

</html>