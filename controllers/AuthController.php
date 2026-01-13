<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/establecer-sesion.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        // Crear el modelo Usuario
        $this->userModel = new Usuario();
    }

    public function login()
    {
        // Si ya está logueado, no permitir volver al login
        if (isset($_SESSION['usuario_logueado']) && $_SESSION['usuario_logueado'] === true) {
            header("Location: index.php?action=listar");
            exit();
        }

        $hideNavbar = true;

        // Generar token CSRF si no existe
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(64));
        }

        // Mostrar formulario de login
        include __DIR__ . '/../views/login.php';
    }

    public function authenticate()
    {
        /******************************************************
         * SOLO ACEPTAR PETICIONES POST
         ******************************************************/
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Debes hacer login para acceder.";
            header("Location: index.php?action=login");
            exit();
        }

        /******************************************************
         * CONTROL DE INTENTOS FALLIDOS
         ******************************************************/
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        $max_attempts = 2;

        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['error'] = "Has superado el número máximo de intentos. Inténtalo más tarde.";
            header("Location: index.php?action=login");
            exit();
        }

        /******************************************************
         * VALIDACIÓN CSRF
         ******************************************************/
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
            die("Solicitud no válida. Token CSRF ausente.");
        }

        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Solicitud no válida. Token CSRF incorrecto.");
        }

        // Invalidar token usado
        unset($_SESSION['csrf_token']);

        /******************************************************
         * RECOGER Y VALIDAR DATOS DEL FORMULARIO
         ******************************************************/
        $username = trim($_POST['user'] ?? '');
        $password = trim($_POST['pass'] ?? '');

        // Validación estricta del usuario
        if (!preg_match('/^[A-Za-z0-9]{8,15}$/', $username)) {
            $_SESSION['error'] = "Usuario inválido.";
            header("Location: index.php?action=login");
            exit();
        }

        // Validación estricta de la contraseña
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*_\-+.,?:;])[A-Za-z0-9!@#$%^&*_\-+.,?:;]{8,15}$/', $password)) {
            $_SESSION['error'] = "Contraseña inválida.";
            header("Location: index.php?action=login");
            exit();
        }

        if ($username === '' || $password === '') {
            $_SESSION['error'] = "Debes rellenar todos los campos.";
            header("Location: index.php?action=login");
            exit();
        }

        /******************************************************
         * AUTENTICACIÓN USANDO EL MODELO Usuario
         ******************************************************/
        $user = $this->userModel->login($username, $password);

        if ($user) {

            /******************************************************
             * LOGIN EXITOSO
             ******************************************************/

            // Resetear intentos fallidos
            $_SESSION['login_attempts'] = 0;

            // Guardar datos de sesión
            $_SESSION['idusuario'] = $user['idUser'];
            $_SESSION['usuario_logueado'] = true;

            // Regenerar ID de sesión para evitar fijación
            session_regenerate_id(true);

            // Generar nuevo token CSRF
            $_SESSION['csrf_token'] = bin2hex(random_bytes(64));

            // Redirigir al listado
            header('Location: index.php?action=listar');
            exit();

        } else {

            /******************************************************
             * LOGIN FALLIDO
             ******************************************************/
            $_SESSION['login_attempts']++;
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";

            header("Location: index.php?action=login");
            exit();
        }
    }

    public function logout()
    {
        /******************************************************
         * CERRAR SESIÓN DE FORMA SEGURA
         ******************************************************/

        // Vaciar variables de sesión
        $_SESSION = [];

        // Destruir sesión
        session_unset();
        session_destroy();

        // Iniciar sesión nueva y regenerar ID
        session_start();
        session_regenerate_id(true);

        // Resetear intentos
        $_SESSION['login_attempts'] = 0;

        // Nuevo token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(64));

        // Redirigir al login
        header('Location: index.php?action=login');
        exit();
    }
}
