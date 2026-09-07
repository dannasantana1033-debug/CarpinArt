<?php
// Router.php

class Router {
    private $routes = [];

    public function __construct() {
        // 1. Ruta de la página principal (Home)
        $this->get('', ['HomeController', 'index']);
        $this->get('home', ['HomeController', 'index']);

        // 2. Rutas de Cotizaciones (Sincronizado con cotizacion/crear)
        $this->get('cotizacion/crear', ['CotizacionController', 'crear']);
        $this->post('cotizacion/guardar', ['CotizacionController', 'guardar']);
        $this->get('mis-cotizaciones', ['CotizacionController', 'obtenerPorUsuario']);

        // 3. Rutas de Administración
        $this->get('admin/cotizaciones', ['CotizacionController', 'index']);
        $this->post('admin/cotizacion/responder', ['CotizacionController', 'responder']);

        // 4. Autenticación (Login, Registro, Logout)
        $this->get('login', ['AuthController', 'showLogin']);
        $this->post('login', ['AuthController', 'login']);
        $this->get('registro', ['AuthController', 'showRegistro']);
        $this->post('registro', ['AuthController', 'registrar']);
        $this->get('logout', ['AuthController', 'logout']);

        // 5. CRUD de Materiales
        $this->get('admin/materiales', ['MaterialController', 'index']);
        $this->get('admin/materiales/crear', ['MaterialController', 'crear']);
        $this->post('admin/materiales/guardar', ['MaterialController', 'guardar']);
        $this->get('admin/materiales/editar', ['MaterialController', 'editar']);
        $this->post('admin/materiales/actualizar', ['MaterialController', 'actualizar']);
        $this->get('admin/materiales/eliminar', ['MaterialController', 'eliminar']);
    }

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $path = trim($path, '/');
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch($uri = null, $method = null) {
        if ($uri === null) {
            $uri = $_SERVER['REQUEST_URI'];
            $baseFolder = '/carpinart/';

            if (strpos($uri, $baseFolder) === 0) {
                $uri = substr($uri, strlen($baseFolder));
            }
            $uri = strtok($uri, '?');
        }

        if ($method === null) {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        $uri = trim($uri, '/');
        $method = strtoupper($method);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $controllerName = $handler[0];
            $action = $handler[1];

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        $this->show404($uri);
    }

    public function comprobarRutas() {
        $this->dispatch();
    }

    private function show404($uri) {
        http_response_code(404);
        echo "<div style='font-family: sans-serif; padding: 20px;'>";
        echo "<h1>404 - Página no encontrada</h1>";
        echo "<p>La ruta '<strong>" . htmlspecialchars($uri) . "</strong>' no existe en CarpinArt.</p>";
        echo "</div>";
        exit;
    }
}