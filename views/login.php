<?php

$title = "Login";
$bodyClass = "d-flex align-items-center justify-content-center";
$showLogout = false;
$noContainer = true;


ob_start();
?>

<div class="login-card ">

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
            <div id="userHelp" class="form-text text-warning" style="visibility:hidden;"></div>
        </div>

        <div class="mb-3">
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="pass" id="pass"
                placeholder="Introduce tu contraseña" required>
            <div id="passHelp" class="form-text text-warning" style="visibility:hidden;"></div>
        </div>

        <button type="submit" class="btn btn-login w-100 mt-2 text-white">Entrar</button>
    </form>
</div>

<script src="/BookManager/public/verificaciones.js"></script>


<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";
?>
