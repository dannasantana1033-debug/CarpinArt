<?php

// se hace la modificacion del index de 
 // forma temporal

// Activar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/CotizacionController.php';

// Captura robusta de la URL (soporta ?url= y reescritura de Apache)
$url = $_GET['url'] ?? '';
if (empty($url)) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $basePath = '/carpinart/public/';
    
    if (strpos($uri, $basePath) === 0) {
        $url = substr($uri, strlen($basePath));
    } else {
        $url = ltrim($uri, '/');
    }
}
$url = trim($url, '/');

$authController = new AuthController();
$cotizacionController = new CotizacionController();

// Enrutamiento directo
switch ($url) {
    case 'login':
        $authController->login();
        break;
    
    case 'registro':
        $authController->registrar();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'cotizacion/crear':
        $cotizacionController->crear();
        break;

    default:
        // Si no coincide con ninguna ruta válida, carga el home
        require_once __DIR__ . '/../views/home/index.php';
        break;
}