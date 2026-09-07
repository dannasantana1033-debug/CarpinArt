<!-- views/admin/cotizaciones.php -->

<style>
.admin-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.admin-header {
    margin-bottom: 2rem;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 1rem;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th, .admin-table td {
    padding: 0.85rem;
    border-bottom: 1px solid #eee;
    font-size: 0.9rem;
}

.admin-table th {
    background-color: #3e2723;
    color: #fff;
    text-align: left;
}

.form-quote {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    background: #fdfdfd;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-quote input, .form-quote textarea {
    padding: 0.4rem;
    font-size: 0.85rem;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.btn-responder {
    background: #2e7d32;
    color: #fff;
    border: none;
    padding: 0.4rem;
    font-weight: bold;
    cursor: pointer;
    border-radius: 3px;
}

.btn-responder:hover {
    background: #1b5e20;
}
</style>

<div class="admin-container">
    <div class="admin-header">
        <h2>Gestión de Cotizaciones - Taller CarpinArt</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Proyecto</th>
                <th>Medidas y Material</th>
                <th>Presupuesto Cliente</th>
                <th>Estado</th>
                <th>Gestionar Cotización</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cotizaciones as $cot): ?>
                <tr>
                    <td>#<?= $cot['id']; ?></td>
                    <td>
                        <strong><?= Security::sanitizeString($cot['cliente_nombre']); ?></strong><br>
                        <small><?= Security::sanitizeString($cot['cliente_email']); ?></small>
                    </td>
                    <td>
                        <strong><?= Security::sanitizeString($cot['titulo_proyecto']); ?></strong><br>
                        <small><?= Security::sanitizeString($cot['descripcion_diseno']); ?></small>
                    </td>
                    <td>
                        <b>Mat:</b> <?= Security::sanitizeString($cot['material_nombre'] ?? 'Por asesorar'); ?><br>
                        <small><?= "{$cot['largo_cm']}x{$cot['ancho_cm']}x{$cot['alto_cm']} cm"; ?></small>
                    </td>
                    <td>$<?= number_format($cot['presupuesto_estimado_cliente'] ?? 0, 2); ?></td>
                    <td><span class="badge"><?= $cot['estado']; ?></span></td>
                    <td>
                        <?php if (in_array($cot['estado'], ['pendiente', 'en_revision'])): ?>
                            <form action="<?= BASE_URL ?>admin/cotizaciones/guardar" method="POST" class="form-quote">
                                <input type="hidden" name="cotizacion_id" value="<?= $cot['id']; ?>">
                                
                                <label>Precio ($):</label>
                                <input type="number" step="0.01" name="precio_cotizado" required placeholder="0.00">
                                
                                <label>Días hábiles:</label>
                                <input type="number" name="tiempo_estimado_dias" required placeholder="Ej: 15">
                                
                                <label>Notas del carpintero:</label>
                                <textarea name="notas_carpintero" rows="2" placeholder="Detalles de madera, acabados..."></textarea>
                                
                                <button type="submit" class="btn-responder">Enviar Cotización</button>
                            </form>
                        <?php else: ?>
                            <small><b>Precio:</b> $<?= number_format($cot['precio_cotizado_carpintero'], 2); ?></small><br>
                            <small><b>Días:</b> <?= $cot['tiempo_estimado_dias']; ?> días</small>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>