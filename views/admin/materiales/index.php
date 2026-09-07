<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Materiales - CarpinArt</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; font-size: 24px; }
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; font-size: 14px; }
        .btn-primary { background-color: #27ae60; }
        .btn-primary:hover { background-color: #219653; }
        .btn-warning { background-color: #f39c12; }
        .btn-danger { background-color: #c0392b; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; }
        .btn-back { display: inline-block; margin-top: 20px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventario de Materiales</h1>
        <a href="/carpinart/public/index.php?url=admin/materiales/crear" class="btn btn-primary">+ Nuevo Material</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Precio Unitario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($materiales)): ?>
                    <?php foreach ($materiales as $row): ?>
                    <tr>
                        <td><?= $row['id_material'] ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['descripcion']) ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td>$<?= number_format($row['precio_unitario'], 2) ?></td>
                        <td>
                            <a href="/carpinart/public/index.php?url=admin/materiales/editar&id=<?= $row['id_material'] ?>" class="btn btn-warning">Editar</a>
                            <a href="/carpinart/public/index.php?url=admin/materiales/eliminar&id=<?= $row['id_material'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este material?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #777;">No hay materiales registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="/carpinart/public/index.php?url=admin/dashboard" class="btn-back">← Volver al Dashboard</a>
    </div>
</body>
</html>