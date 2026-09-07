<?php
// models/Cotizacion.php

class Cotizacion {
    private $db;

    public function __construct() {
        // Obtener la conexión PDO usando el Singleton
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Crear una nueva solicitud de cotización
     */
    public function crear(array $datos): bool {
        $sql = "INSERT INTO cotizaciones (
                    usuario_id, 
                    material_preferido_id, 
                    titulo_proyecto, 
                    descripcion_diseno, 
                    largo_cm, 
                    ancho_cm, 
                    alto_cm, 
                    imagen_referencia, 
                    presupuesto_estimado_cliente,
                    estado,
                    fecha_creacion
                ) VALUES (
                    :usuario_id, 
                    :material_preferido_id, 
                    :titulo_proyecto, 
                    :descripcion_diseno, 
                    :largo_cm, 
                    :ancho_cm, 
                    :alto_cm, 
                    :imagen_referencia, 
                    :presupuesto_estimado_cliente,
                    'pendiente',
                    NOW()
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':usuario_id'                   => $datos['usuario_id'],
            ':material_preferido_id'        => $datos['material_preferido_id'],
            ':titulo_proyecto'              => $datos['titulo_proyecto'],
            ':descripcion_diseno'           => $datos['descripcion_diseno'],
            ':largo_cm'                     => $datos['largo_cm'],
            ':ancho_cm'                     => $datos['ancho_cm'],
            ':alto_cm'                      => $datos['alto_cm'],
            ':imagen_referencia'            => $datos['imagen_referencia'],
            ':presupuesto_estimado_cliente' => $datos['presupuesto_estimado_cliente']
        ]);
    }

    /**
     * Obtener todas las cotizaciones de un usuario específico
     */
    public function obtenerPorUsuario(int $usuarioId): array {
        $sql = "SELECT c.*, m.nombre AS nombre_material 
                FROM cotizaciones c
                LEFT JOIN materiales m ON c.material_preferido_id = m.id
                WHERE c.usuario_id = :usuario_id
                ORDER BY c.fecha_creacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);

        return $stmt->fetchAll();
    }

    /**
     * Responder a una cotización desde el panel de administración
     */
    public function responderCotizacion(int $id, float $precio, int $dias, string $notas): bool {
        $sql = "UPDATE cotizaciones 
                SET precio_cotizado_carpintero = :precio,
                    tiempo_estimado_dias = :dias,
                    notas_carpintero = :notas,
                    estado = 'respondida',
                    fecha_respuesta = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':precio' => $precio,
            ':dias'   => $dias,
            ':notas'  => $notas,
            ':id'     => $id
        ]);
    }
}