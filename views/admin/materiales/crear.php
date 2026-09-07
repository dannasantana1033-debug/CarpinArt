<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Material - CarpinArt</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .btn-submit { background-color: #d35400; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background-color: #b94600; }
        .btn-back { display: inline-block; margin-top: 15px; color: #666; text-decoration: none; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Material</h1>
        
        <form action="/carpinart/public/index.php?url=admin/materiales/crear" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Material:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="form-group">
                <label for="stock">Stock (Cantidad):</label>
                <input type="number" id="stock" name="stock" min="0" value="0" required>
            </div>

            <div class="form-group">
                <label for="costo">Costo ($):</label>
                <input type="number" id="costo" name="costo" step="0.01" min="0" required>
            </div>

            <button type="submit" class="btn-submit">Guardar Material</button>
        </form>

        <a href="/carpinart/public/index.php?url=admin/materiales" class="btn-back">← Volver al listado</a>
    </div>
</body>
</html>