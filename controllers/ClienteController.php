<?php
// controllers/ClienteController.php

if (file_exists(__DIR__ . '/../models/Cliente.php')) {
    require_once __DIR__ . '/../models/Cliente.php';
}

class ClienteController {
    private $clienteModel;

    public function __construct() {
        // Comentamos temporalmente la redirección para probar el envío
        /*
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        */
        $this->clienteModel = new Cliente();
    }

    public function index(): void {
        $clientes = $this->clienteModel->obtenerTodos();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/clientes/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($nombre) || empty($email) || empty($password)) {
                echo "Error: Falta llenar nombre, email o contraseña.";
                exit;
            }

            $exito = $this->clienteModel->crear([
                'nombre'    => $nombre,
                'apellido'  => $apellido,
                'email'     => $email,
                'telefono'  => $telefono,
                'direccion' => $direccion,
                'password'  => $password
            ]);

            if ($exito) {
                echo "¡Guardado exitosamente!";
            } else {
                echo "No se pudo guardar el registro.";
            }
            exit;
        }
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $password = $_POST['password'] ?? '';

            $exito = $this->clienteModel->actualizar($id, [
                'nombre'    => $nombre,
                'apellido'  => $apellido,
                'email'     => $email,
                'telefono'  => $telefono,
                'direccion' => $direccion,
                'password'  => $password
            ]);

            header('Location: ' . BASE_URL . 'admin/clientes');
            exit;
        }
    }

    public function delete(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $this->clienteModel->eliminar($id);
            header('Location: ' . BASE_URL . 'admin/clientes');
            exit;
        }
    }
}