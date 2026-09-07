<?php
// Ejemplo de uso dentro de models/Producto.php

class Producto {
    private PDO $db;

    public function __construct() {
        // Obtiene la instancia única PDO sin crear nuevas conexiones
        $this->db = Database::getInstance();
    }

    public function obtenerTodos(): array {
        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                WHERE p.estado = :estado";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':estado' => 'disponible']);

        return $stmt->fetchAll();
    }
}