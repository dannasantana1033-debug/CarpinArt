<?php
// views/admin/productos/crear.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - CarpinArt</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="number"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .btn-submit { background-color: #d35400; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background-color: #b94600; }
        .btn-back { display: inline-block; margin-top: 15px; color: #666; text-decoration: none; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Producto</h1>
        
        <form action="/carpinart/public/index.php?url=admin/productos/crear" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio ($):</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock (Cantidad disponible):</label>
                <input type="number" id="stock" name="stock" min="0" value="0" required>
            </div>

            <div class="form-group">
                <label for="tiempo_entrega">Tiempo de Entrega (ej. 5 a 7 días hábiles):</label>
                <input type="text" id="tiempo_entrega" name="tiempo_entrega">
            </div>

            <div class="form-group">
                <label for="id_categoria">Categoría (ID):</label>
                <input type="number" id="id_categoria" name="id_categoria" value="1" min="1" required>
                <small style="color: #777;">(Puedes cambiar esto por un selector si ya tienes categorías registradas)</small>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del Producto:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Guardar Producto</button>
        </form>

        <a href="/carpinart/public/index.php?url=admin/productos" class="btn-back">← Volver al listado</a>
    </div>
</body>
</html>