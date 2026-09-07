<?php
// controllers/AuthController.php

if (file_exists(__DIR__ . '/../models/Cliente.php')) {
    require_once __DIR__ . '/../models/Cliente.php';
}

if (file_exists(__DIR__ . '/../config/database.php')) {
    require_once __DIR__ . '/../config/database.php';
}

class AuthController {
    private $db;

    public function __construct() {
        if (class_exists('Database')) {
            $this->db = Database::getInstance()->getConnection();
        }

        if (!$this->db) {
            die("Error crítico: No se pudo establecer la conexión a la base de datos en AuthController.");
        }
    }

    public function showLogin(): void {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function showRegistro(): void {
        require_once __DIR__ . '/../views/auth/registro.php';
    }

public function registrar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreCompleto = trim($_POST['nombre'] ?? '');
            $email          = trim($_POST['email'] ?? '');
            $telefono       = trim($_POST['telefono'] ?? '');
            $password       = $_POST['password'] ?? '';

            $partesNombre = explode(' ', $nombreCompleto, 2);
            $nombre   = $partesNombre[0] ?? '';
            $apellido = $partesNombre[1] ?? '';

            if (empty($nombre) || empty($email) || empty($password)) {
                echo "<script>alert('Por favor llena los campos obligatorios.'); window.history.back();</script>";
                exit;
            }

            try {
                $stmt = $this->db->prepare("
                    INSERT INTO usuarios (nombre, apellido, correo, contrasena, telefono, direccion, id_rol)
                    VALUES (:nombre, :apellido, :correo, :contrasena, :telefono, :direccion, :id_rol)
                ");

                $exito = $stmt->execute([
                    ':nombre'     => $nombre,
                    ':apellido'   => $apellido,
                    ':correo'     => $email,
                    ':contrasena' => password_hash($password, PASSWORD_BCRYPT),
                    ':telefono'   => $telefono,
                    ':direccion'  => '',
                    ':id_rol'     => 2
                ]);

                if ($exito) {
                    echo "<script>alert('¡Cuenta creada con éxito!'); window.location.href='" . BASE_URL . "index.php?url=login';</script>";
                    exit;
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    echo "<script>alert('Este correo electrónico ya está registrado. Por favor usa otro o inicia sesión.'); window.history.back();</script>";
                } else {
                    echo "Error de MySQL al registrar: " . $e->getMessage();
                }
                exit;
            }
        } else {
            // CORRECCIÓN: Si entra por GET, muestra el formulario de registro en lugar de quedarse en blanco
            $this->showRegistro();
        }
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                echo "<script>alert('Ingresa correo y contraseña.'); window.history.back();</script>";
                exit;
            }

            try {
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = :correo");
                $stmt->execute([':correo' => $email]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$usuario) {
                    echo "<script>alert('El correo no se encuentra registrado.'); window.location.href='" . BASE_URL . "login';</script>";
                    exit;
                }

                $hashBD = $usuario['contrasena'] ?? $usuario['contraseña'] ?? '';

                $passwordValida = false;
                if (!empty($hashBD)) {
                    if (password_verify($password, $hashBD)) {
                        $passwordValida = true;
                    } elseif ($password === $hashBD) {
                        // Migración automática de contraseña en texto plano a hash seguro
                        $passwordValida = true;
                        $nuevoHash = password_hash($password, PASSWORD_BCRYPT);
                        $updateStmt = $this->db->prepare("UPDATE usuarios SET contrasena = :nuevoHash WHERE id_usuario = :id");
                        $updateStmt->execute([':nuevoHash' => $nuevoHash, ':id' => $usuario['id_usuario']]);
                    }
                }

                if ($passwordValida) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $_SESSION['user_id']     = $usuario['id_usuario'];
                    $_SESSION['user_nombre'] = $usuario['nombre'];
                    $_SESSION['user_rol']    = $usuario['id_rol'];

                    // Redirección dinámica basada en el rol usando BASE_URL
                    $destino = ($usuario['id_rol'] == 1) 
                        ? BASE_URL . 'admin/cotizaciones' 
                        : BASE_URL;

                    header('Location: ' . $destino);
                    exit;
                } else {
                    echo "<div style='font-family:sans-serif; padding:30px; background:#fff3cd; color:#856404; border:1px solid #ffeeba; margin:30px; border-radius:8px;'>";
                    echo "<h2>⚠️ Error de Autenticación</h2>";
                    echo "<p>El correo existe en la base de datos, pero la contraseña no coincide.</p>";
                    echo "<p><b>Correo:</b> " . htmlspecialchars($email) . "</p>";
                    echo "<a href='" . BASE_URL . "login' style='padding:10px 20px; background:#d35400; color:#fff; text-decoration:none; border-radius:5px; display:inline-block; margin-top:10px;'>Volver al Login</a>";
                    echo "</div>";
                    exit;
                }
            } catch (PDOException $e) {
                echo "Error de base de datos: " . $e->getMessage();
                exit;
            }
        } else {
            $this->showLogin();
        }
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}