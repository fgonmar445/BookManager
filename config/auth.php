<?php

if (!isset($_SESSION['usuario_logueado']) || $_SESSION['usuario_logueado'] !== true) {
    header("Location: /libros_mvc_crud_login/index.php?action=login");
    exit();
}
