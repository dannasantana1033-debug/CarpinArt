<?php
// routes/web.php

// Ruta principal (Inicio)
$router->get('', ['CotizacionController', 'crear']);

// Rutas de Cotización
$router->get('cotizacion/crear', ['CotizacionController', 'crear']);
$router->post('cotizacion/guardar', ['CotizacionController', 'guardar']);
$router->get('cotizacion/misCotizaciones', ['CotizacionController', 'misCotizaciones']);

// Rutas del Taller (Admin)
$router->get('admin/cotizaciones', ['AdminController', 'index']);

// Rutas del CRUD de Clientes
$router->get('admin/clientes', ['ClienteController', 'index']);
$router->post('admin/clientes/guardar', ['ClienteController', 'store']);
$router->post('admin/clientes/actualizar', ['ClienteController', 'update']);
$router->post('admin/clientes/eliminar', ['ClienteController', 'delete']);

// Rutas de Autenticación
$router->get('login', ['AuthController', 'showLogin']);
$router->post('login', ['AuthController', 'login']);
$router->get('registro', ['AuthController', 'showRegistro']);
$router->post('registro', ['AuthController', 'registrar']);
$router->get('logout', ['AuthController', 'logout']);