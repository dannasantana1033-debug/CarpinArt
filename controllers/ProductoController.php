<?php
// controllers/ProductoController.php

if (file_exists(__DIR__ . '/../config/database.php')) {
    require_once __DIR__ . '/../config/database.php';
}

class ProductoController {
    private $db;

    public function __construct() {
        if (class_exists('Database')) {
            $this->db = Database::getInstance()->getConnection();
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Listar productos
    public function index() {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY id_producto DESC");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . '/../views/admin/productos/index.php';
    }

    // Mostrar formulario y guardar nuevo producto
    public function crear() {
        // Verificar si es admin
        if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] != 1) {
            header('Location: /carpinart/public/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capturamos todos los campos enviados desde el formulario
            $nombre         = trim($_POST['nombre'] ?? '');
            $descripcion    = trim($_POST['descripcion'] ?? '');
            $precio         = floatval($_POST['precio'] ?? 0);
            $stock          = intval($_POST['stock'] ?? 0);
            $tiempo_entrega = trim($_POST['tiempo_entrega'] ?? '');
            $id_categoria   = intval($_POST['id_categoria'] ?? 1); // 1 por defecto si no se envía
            
            // Procesamiento de la imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = time() . '_' . $_FILES['imagen']['name'];
                $rutaDestino = __DIR__ . '/../public/uploads/' . $nombreArchivo;
                
                // Crea la carpeta uploads si no existe
                if (!is_dir(__DIR__ . '/../public/uploads/')) {
                    mkdir(__DIR__ . '/../public/uploads/', 0777, true);
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = $nombreArchivo;
                }
            }

            // Inserción en la base de datos con tu estructura real
            $stmt = $this->db->prepare("
                INSERT INTO productos (nombre, descripcion, precio, stock, imagen, tiempo_entrega, id_categoria) 
                VALUES (:nombre, :descripcion, :precio, :stock, :imagen, :tiempo_entrega, :id_categoria)
            ");
            
            $stmt->execute([
                ':nombre'         => $nombre,
                ':descripcion'    => $descripcion,
                ':precio'         => $precio,
                ':stock'          => $stock,
                ':imagen'         => $imagen,
                ':tiempo_entrega' => $tiempo_entrega,
                ':id_categoria'   => $id_categoria
            ]);

            // Redirigir de vuelta a la lista de productos
            header('Location: /carpinart/public/index.php?url=admin/productos');
            exit;
        }

        // Si es método GET, solo mostramos la vista del formulario
        require_once __DIR__ . '/../views/admin/productos/crear.php';
    }

    // Eliminar producto
    public function eliminar() {
        if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] != 1) {
            header('Location: /carpinart/public/index.php');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = :id");
            $stmt->execute([':id' => $id]);
        }

        header('Location: /carpinart/public/index.php?url=admin/productos');
        exit;
    }
}