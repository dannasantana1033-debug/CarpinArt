<?php
// controllers/AuthController.php

class AuthController {

    /**
     * Muestra el formulario de inicio de sesión o procesa el POST de login.
     */
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($correo && $password) {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->obtenerPorCorreo($correo);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    // Guardar datos básicos en la sesión
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['user_nombre'] = $usuario['nombre'];
                    
                    // Asignar el texto del rol basándonos en el rol_id de la base de datos
                    // (1 = administrador, 2 = cliente)
                    $_SESSION['role'] = ($usuario['rol_id'] == 1) ? 'administrador' : 'cliente';

                    Session::setFlash('success', '¡Bienvenido de nuevo, ' . $usuario['nombre'] . '!');
                    
                    // Redirigir según corresponda
                    if ($_SESSION['role'] === 'administrador') {
                        header('Location: ' . BASE_URL . 'admin/cotizaciones');
                    } else {
                        header('Location: ' . BASE_URL . 'home');
                    }
                    exit;
                } else {
                    Session::setFlash('error', 'Correo o contraseña incorrectos.');
                }
            } else {
                Session::setFlash('error', 'Por favor llena todos los campos.');
            }

            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Cargar vista de inicio de sesión
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/auth/login.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Muestra el formulario de registro o procesa el POST de registro.
     */
    public function registro() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($nombre && $correo && $password) {
                
                // ===================================================
                // ASIGNACIÓN AUTOMÁTICA DE ADMINISTRADOR POR CORREO
                // ===================================================
                $rol_id = 2; // Por defecto es cliente

                // Tu correo configurado como administrador
                $correoAdmin = 'dannasantana1033@gmail.com'; 

                if (strtolower(trim($correo)) === strtolower(trim($correoAdmin))) {
                    $rol_id = 1; // 1 = Administrador en tu tabla roles
                }
                // ===================================================

                $usuarioModel = new Usuario();
                
                // Validar si el correo ya existe
                $existe = $usuarioModel->obtenerPorCorreo($correo);
                if ($existe) {
                    Session::setFlash('error', 'Este correo ya se encuentra registrado.');
                    header('Location: ' . BASE_URL . 'registro');
                    exit;
                }

                // Guardar el usuario enviando el rol_id calculado
                $resultado = $usuarioModel->registrar($nombre, $correo, $password, $rol_id);

                if ($resultado) {
                    Session::setFlash('success', '¡Registro exitoso! Ya puedes iniciar sesión.');
                    header('Location: ' . BASE_URL . 'login');
                    exit;
                } else {
                    Session::setFlash('error', 'Ocurrió un error al intentar registrar el usuario.');
                }
            } else {
                Session::setFlash('error', 'Por favor completa todos los campos.');
            }

            header('Location: ' . BASE_URL . 'registro');
            exit;
        }

        // Cargar vista de registro
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/auth/registro.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Cierra la sesión activa.
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}