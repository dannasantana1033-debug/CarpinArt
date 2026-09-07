<?php
class Usuario {
    private $db;

    public function __construct() {
        // Asumiendo que tienes una clase Database para la conexión PDO
        $this->db = Database::getInstance();
    }

    /**
     * Registra un nuevo cliente con la contraseña encriptada (hash)
     */
    public function registrar(array $datos): bool {
        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, 'cliente')";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'nombre'   => $datos['nombre'],
            'email'    => $datos['email'],
            'password' => $datos['password'] // Ya debe venir con password_hash()
        ]);
    }

    /**
     * Busca un usuario por su correo electrónico
     */
    public function obtenerPorEmail(string $email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}