<?php
// app/controllers/CotizacionController.php

if (file_exists(__DIR__ . '/../config/database.php')) {
    require_once __DIR__ . '/../config/database.php';
}

class CotizacionController {
    private $db;

    public function __construct() {
        if (class_exists('Database')) {
            $this->db = Database::getInstance()->getConnection();
        }

        if (!isset($this->db) || !$this->db) {
            die("Error crítico: No se pudo establecer la conexión a la base de datos en CotizacionController.");
        }
    }

    public function crear(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Proteger la ruta: si no ha iniciado sesión, redirigir al login
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Debes iniciar sesión para solicitar una cotización.'); window.location.href='" . BASE_URL . "index.php?url=login';</script>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion         = trim($_POST['descripcion'] ?? '');
            $medidas             = trim($_POST['medidas'] ?? '');
            $presupuestoEstimado = trim($_POST['presupuesto_estimado'] ?? 0);
            $idUsuario           = $_SESSION['user_id'];

            if (empty($descripcion) || empty($medidas)) {
                echo "<script>alert('Por favor completa los campos obligatorios de descripción y medidas.'); window.history.back();</script>";
                exit;
            }

            try {
                $stmt = $this->db->prepare("
                    INSERT INTO cotizaciones (id_usuario, descripcion, medidas, presupuesto_estimado)
                    VALUES (:id_usuario, :descripcion, :medidas, :presupuesto_estimado)
                ");

                $exito = $stmt->execute([
                    ':id_usuario'           => $idUsuario,
                    ':descripcion'          => $descripcion,
                    ':medidas'              => $medidas,
                    ':presupuesto_estimado' => $presupuestoEstimado
                ]);

                if ($exito) {
                    echo "<script>alert('¡Cotización enviada con éxito! Nos pondremos en contacto contigo pronto.'); window.location.href='" . BASE_URL . "';</script>";
                    exit;
                }
            } catch (PDOException $e) {
                echo "Error al guardar la cotización: " . $e->getMessage();
                exit;
            }
        } else {
            require_once __DIR__ . '/../views/cotizaciones/crear.php';
        }
    }
}