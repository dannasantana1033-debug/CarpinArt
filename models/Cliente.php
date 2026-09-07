<?php
// models/Cliente.php

class Cliente {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodos(): array {
        $stmt = $this->db->query("SELECT id_usuario AS id, nombre, apellido, correo AS email, telefono, direccion, fecha_registro FROM usuarios ORDER BY id_usuario DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id_usuario AS id, nombre, apellido, correo AS email, telefono, direccion FROM usuarios WHERE id_usuario = :id");
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cliente ?: null;
    }

    public function crear(array $datos): bool {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO usuarios (nombre, apellido, correo, contraseña, telefono, direccion, id_rol)
                VALUES (:nombre, :apellido, :correo, :contrasena, :telefono, :direccion, :id_rol)
            ");
            return $stmt->execute([
                ':nombre'     => $datos['nombre'],
                ':apellido'   => $datos['apellido'] ?? '',
                ':correo'     => $datos['email'],
                ':contrasena' => password_hash($datos['password'], PASSWORD_BCRYPT),
                ':telefono'   => $datos['telefono'],
                ':direccion'  => $datos['direccion'],
                ':id_rol'     => 2 // Asigna el rol de cliente
            ]);
        } catch (PDOException $e) {
            die("Error de MySQL: " . $e->getMessage());
        }
    }

    public function actualizar(int $id, array $datos): bool {
        try {
            if (!empty($datos['password'])) {
                $stmt = $this->db->prepare("
                    UPDATE usuarios 
                    SET nombre = :nombre, correo = :correo, telefono = :telefono, direccion = :direccion, contraseña = :contrasena
                    WHERE id_usuario = :id
                ");
                return $stmt->execute([
                    ':nombre'     => $datos['nombre'],
                    ':correo'     => $datos['email'],
                    ':telefono'   => $datos['telefono'],
                    ':direccion'  => $datos['direccion'],
                    ':contrasena' => password_hash($datos['password'], PASSWORD_BCRYPT),
                    ':id'         => $id
                ]);
            } else {
                $stmt = $this->db->prepare("
                    UPDATE usuarios 
                    SET nombre = :nombre, correo = :correo, telefono = :telefono, direccion = :direccion
                    WHERE id_usuario = :id
                ");
                return $stmt->execute([
                    ':nombre'    => $datos['nombre'],
                    ':correo'    => $datos['email'],
                    ':telefono'  => $datos['telefono'],
                    ':direccion' => $datos['direccion'],
                    ':id'        => $id
                ]);
            }
        } catch (PDOException $e) {
            die("Error de MySQL: " . $e->getMessage());
        }
    }

    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
        return $stmt->execute([':id' => $id]);
    }
}