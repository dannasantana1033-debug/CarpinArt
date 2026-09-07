<!-- views/clientes/index.php -->
<style>
.crud-container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; font-family: 'Segoe UI', sans-serif; }
.form-box { background: #fff; padding: 1.5rem; border-radius: 8px; border: 1px solid #d7ccc8; margin-bottom: 2rem; border-top: 4px solid #5d4037; }
.form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem; }
.form-group label { display: block; margin-bottom: 0.3rem; font-weight: 600; color: #3e2723; font-size: 0.85rem; }
.form-group input { width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
.btn-brown { background: #4e342e; color: #fff; border: none; padding: 0.7rem 1.2rem; border-radius: 4px; cursor: pointer; font-weight: 600; }
.btn-brown:hover { background: #3e2723; }
.btn-danger { background: #c62828; color: #fff; border: none; padding: 0.4rem 0.7rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem; }
.table-responsive { overflow-x: auto; background: #fff; border-radius: 8px; border: 1px solid #d7ccc8; }
table { width: 100%; border-collapse: collapse; text-align: left; }
th, td { padding: 0.8rem 1rem; border-bottom: 1px solid #efebe9; font-size: 0.9rem; }
th { background-color: #5d4037; color: #ffffff; font-weight: 600; }
tr:hover { background-color: #f5f5f5; }
.alert-success { background: #e8f5e9; color: #2e7d32; padding: 0.8rem; border-radius: 4px; margin-bottom: 1rem; }
.alert-danger { background: #ffebee; color: #c62828; padding: 0.8rem; border-radius: 4px; margin-bottom: 1rem; }
</style>

<div class="crud-container">
    <h2>Gestión de Clientes</h2>

    <?php if (class_exists('Session') && $msg = Session::getFlash('success')): ?>
        <div class="alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if (class_exists('Session') && $msg = Session::getFlash('error')): ?>
        <div class="alert-danger"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Formulario Crear/Editar -->
    <div class="form-box">
        <h3 id="form-title">Nuevo Cliente</h3>
        <form id="cliente-form" action="<?= BASE_URL ?>admin/clientes/guardar" method="POST">
            <input type="hidden" name="id" id="cliente_id">
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Ej: Maria">
                </div>
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="apellido" id="apellido" placeholder="Ej: Lopez">
                </div>
                <div class="form-group">
                    <label>Correo Electrónico *</label>
                    <input type="email" name="email" id="email" required placeholder="correo@ejemplo.com">
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" id="telefono" placeholder="Ej: 3001234567">
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Ej: Calle 10 #12-34">
                </div>
                <div class="form-group">
                    <label>Contraseña <small>(dejar en blanco para mantener)</small></label>
                    <input type="password" name="password" id="password" placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="btn-brown" id="btn-submit">Registrar Cliente</button>
            <button type="button" onclick="resetForm()" id="btn-cancel" class="btn-danger" style="display:none; margin-left: 0.5rem;">Cancelar Edición</button>
        </form>
    </div>

    <!-- Tabla de Clientes -->
    <h3>Lista de Clientes Registrados</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No hay clientes registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clientes as $c): ?>
                        <tr>
                            <td><?= $c['id'] ?></td>
                            <td><?= htmlspecialchars($c['nombre']) ?></td>
                            <td><?= htmlspecialchars($c['apellido'] ?? '') ?></td>
                            <td><?= htmlspecialchars($c['email']) ?></td>
                            <td><?= htmlspecialchars($c['telefono'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($c['direccion'] ?? 'N/A') ?></td>
                            <td style="display: flex; gap: 0.5rem;">
                                <button class="btn-brown" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;" 
                                        onclick='editarCliente(<?= json_encode($c) ?>)'>Editar</button>
                                
                                <form action="<?= BASE_URL ?>admin/clientes/eliminar" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                    <button type="submit" class="btn-danger" onclick="return confirm('¿Eliminar cliente?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function editarCliente(cliente) {
    document.getElementById('form-title').innerText = 'Editar Cliente ID #' + cliente.id;
    document.getElementById('cliente_id').value = cliente.id;
    document.getElementById('nombre').value = cliente.nombre;
    document.getElementById('apellido').value = cliente.apellido || '';
    document.getElementById('email').value = cliente.email;
    document.getElementById('telefono').value = cliente.telefono || '';
    document.getElementById('direccion').value = cliente.direccion || '';
    
    document.getElementById('cliente-form').action = '<?= BASE_URL ?>admin/clientes/actualizar';
    document.getElementById('btn-submit').innerText = 'Actualizar Cliente';
    document.getElementById('btn-cancel').style.display = 'inline-block';
}

function resetForm() {
    document.getElementById('form-title').innerText = 'Nuevo Cliente';
    document.getElementById('cliente_id').value = '';
    document.getElementById('cliente-form').reset();
    document.getElementById('cliente-form').action = '<?= BASE_URL ?>admin/clientes/guardar';
    document.getElementById('btn-submit').innerText = 'Registrar Cliente';
    document.getElementById('btn-cancel').style.display = 'none';
}
</script>