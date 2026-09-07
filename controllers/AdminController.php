<?php
// controllers/AdminController.php

class AdminController {

    /**
     * Muestra la lista completa de cotizaciones recibidas en el taller.
     */
    public function cotizaciones() {
        // Verificar autenticación y rol de administrador
        $this->checkAdminAuth();

        $cotizacionModel = new Cotizacion();
        $cotizaciones = $cotizacionModel->obtenerTodas();

        // Cargar vistas del panel de administración
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/cotizaciones.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Procesa la asignación de precio, tiempo de entrega y notas enviadas por el carpintero.
     */
    public function guardarCotizacion() {
        // Verificar autenticación y rol de administrador
        $this->checkAdminAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'cotizacion_id', FILTER_VALIDATE_INT);
            $precio = filter_input(INPUT_POST, 'precio_cotizado', FILTER_VALIDATE_FLOAT);
            $dias = filter_input(INPUT_POST, 'tiempo_estimado_dias', FILTER_VALIDATE_INT);
            $notas = filter_input(INPUT_POST, 'notas_carpintero', FILTER_SANITIZE_STRING);

            if ($id && $precio !== false && $dias) {
                $cotizacionModel = new Cotizacion();
                $resultado = $cotizacionModel->responderCotizacion($id, $precio, $dias, $notas);

                if ($resultado) {
                    Session::setFlash('success', 'La cotización #' . $id . ' fue enviada con éxito al cliente.');
                } else {
                    Session::setFlash('error', 'Ocurrió un error al intentar guardar los datos de la cotización.');
                }
            } else {
                Session::setFlash('error', 'Por favor ingresa un precio y tiempo de entrega válidos.');
            }

            header('Location: ' . BASE_URL . 'admin/cotizaciones');
            exit;
        }
    }

    /**
     * Cambia manualmente el estado de una cotización (ej. Cancelar o En Revisión).
     */
    public function cambiarEstado() {
        $this->checkAdminAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'cotizacion_id', FILTER_VALIDATE_INT);
            $nuevoEstado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

            $estadosPermitidos = ['pendiente', 'en_revision', 'cancelada'];

            if ($id && in_array($nuevoEstado, $estadosPermitidos)) {
                $cotizacionModel = new Cotizacion();
                $cotizacionModel->actualizarEstado($id, $nuevoEstado);
                Session::setFlash('success', 'El estado de la cotización #' . $id . ' ha sido actualizado.');
            } else {
                Session::setFlash('error', 'Estado no permitido.');
            }

            header('Location: ' . BASE_URL . 'admin/cotizaciones');
            exit;
        }
    }

    /**
     * Middleware de verificación para proteger las rutas administrativas.
     */
    private function checkAdminAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            Session::setFlash('error', 'Acceso denegado. Se requieren permisos de administrador.');
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }
}