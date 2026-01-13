<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tiempo máximo de sesión (30 minutos)
$tiempo_maximo = 1800;

if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso']) > $tiempo_maximo) {
    session_unset();
    session_destroy();
    header("Location: /BookManager/index.php?action=login&expired=1");
    exit();
}

$_SESSION['ultimo_acceso'] = time();

// Validar login
if (!isset($_SESSION['usuario_logueado']) || $_SESSION['usuario_logueado'] !== true) {
    header("Location: /BookManager/index.php?action=login");
    exit();
}
