<?php

/******************************************************
 * CONFIGURACIÓN SEGURA DE LA COOKIE DE SESIÓN
 ******************************************************/

// Configuramos los parámetros de la cookie de sesión
session_set_cookie_params([
    'lifetime' => 7200,                 //La cookie dura 2 horas (tiempo máximo permitido)
    'path' => '/',                      //Disponible en toda la web
    //'domain' => 'tu-dominio.com',     //Solo en producción
    //'secure' => true,                 //Solo por HTTPS (activar en producción)
    'httponly' => true,                 //Evita acceso desde JavaScript (protege contra XSS)
    'samesite' => 'Strict'              //Evita envío de cookie desde otros sitios (protege contra CSRF)
]);

/******************************************************
 * INICIO DE SESIÓN
 ******************************************************/
session_start();

/******************************************************
 * TIEMPO MÁXIMO TOTAL DE SESIÓN (2 HORAS)
 ******************************************************/
$session_max_lifetime = 7200; // 2 horas = 7200 segundos

// Guardamos el momento en que se creó la sesión
if (!isset($_SESSION['session_start_time'])) {
    $_SESSION['session_start_time'] = time();
}

// Si han pasado más de 2 horas → sesión expirada
if (time() - $_SESSION['session_start_time'] > $session_max_lifetime) {

    //Vaciar variables de sesión
    $_SESSION = [];

    //Eliminar cookie de sesión explícitamente
    if (isset($_COOKIE[session_name()])) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,               //Expira en el pasado
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    //Destruir sesión
    session_destroy();

    //Redirigir al usuario
    header("Location: index.php?expired=1");
    exit;
}

/******************************************************
 * REGENERACIÓN PERIÓDICA DEL ID DE SESIÓN
 ******************************************************/

$regenerate_interval = 1200; //Regenerar cada 20 minutos

// Guardamos el momento de la última regeneración
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
}

// Si han pasado más de X minutos > regenerar ID
if (time() - $_SESSION['last_regeneration'] >= $regenerate_interval) {

    //Regenera el ID de sesión (protege contra session fixation)
    session_regenerate_id(true);

    //Actualiza el tiempo de última regeneración
    $_SESSION['last_regeneration'] = time();
}

/******************************************************
 * GENERACIÓN DEL TOKEN CSRF
 ******************************************************/

// Si no existe un token CSRF, lo creamos
if (empty($_SESSION['csrf_token'])) {

    //Token seguro de 64 bytes convertido a hexadecimal
    $_SESSION['csrf_token'] = bin2hex(random_bytes(64));
}
