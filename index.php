<?php

/************************************************************
 * 1. INICIAR SESIÓN Y CARGAR CONFIGURACIÓN DE SEGURIDAD
 ************************************************************/

// Este archivo genera el token CSRF y asegura que la sesión esté activa.
// Es importante cargarlo ANTES de cualquier controlador.
require_once __DIR__ . '/config/establecer-sesion.php';


/************************************************************
 * 2. CARGAR CONTROLADORES Y MODELOS NECESARIOS
 ************************************************************/

// Controlador de autenticación (login, logout, authenticate)
require_once __DIR__ . '/controllers/AuthController.php';

// Modelo User (necesario para AuthController)
require_once __DIR__ . '/models/User.php';


/************************************************************
 * 3. DETERMINAR LA ACCIÓN SOLICITADA
 ************************************************************/

// Si no se pasa ninguna acción, por defecto mostramos el login.
$action = $_REQUEST['action'] ?? 'login';


/************************************************************
 * 4. CREAR INSTANCIA DEL CONTROLADOR DE AUTENTICACIÓN
 ************************************************************/

// Siempre necesitamos AuthController disponible.
$auth = new AuthController();


/************************************************************
 * 5. ROUTER PRINCIPAL
 *    Aquí decidimos qué controlador ejecutar según la acción.
 ************************************************************/

switch ($action) {

    /* ------------------------------------------------------
     *  LOGIN
     * ------------------------------------------------------ */

    case 'login':
        // Muestra el formulario de login
        $auth->login();
        break;

    case 'authenticate':
        // Procesa el formulario de login
        $auth->authenticate();
        break;

    case 'logout':
        // Cierra la sesión y vuelve al login
        $auth->logout();
        break;

    case 'dashboard':
        require_once __DIR__ . '/controllers/DashboardController.php';
        $dash = new DashboardController();
        $dash->index();
        break;



    /* ------------------------------------------------------
     *  CRUD DE LIBROS
     *  Solo cargamos LibroController cuando realmente se usa.
     *  Esto evita bucles de redirección.
     * ------------------------------------------------------ */

    case 'listar':
    case 'create':
    case 'edit':
    case 'delete':

        // Cargar el controlador del CRUD SOLO cuando se necesita
        require_once __DIR__ . '/controllers/LibroController.php';

        // Crear instancia del controlador de libros
        $libros = new LibroController();

        // Ejecutar la acción correspondiente
        if ($action === 'listar') $libros->index();
        if ($action === 'create') $libros->create();
        if ($action === 'edit')   $libros->edit();
        if ($action === 'delete') $libros->delete();

        break;


    /* ------------------------------------------------------
     *  ACCIÓN POR DEFECTO
     * ------------------------------------------------------ */

    default:
        // Si la acción no existe, mostramos el login
        $auth->login();
        break;
}
