<!-- views/auth/registro.php -->

<!-- Vinculamos el archivo CSS externo -->
<link rel="stylesheet" href="<?= defined('BASE_URL') ? BASE_URL : '/carpinart/public/'; ?>css/styles.css">


<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <div class="brand-badge">🪚</div>
            <h2>Crear Cuenta en CarpinArt</h2>
            <p>Regístrate para cotizar y dar seguimiento a tus muebles a medida</p>
        </div>

        <?php 
        $errorMsg = null;
        if (class_exists('Session') && method_exists('Session', 'getFlash')) {
            $errorMsg = Session::getFlash('error');
        } elseif (isset($_SESSION['flash_error'])) {
            $errorMsg = $_SESSION['flash_error'];
            unset($_SESSION['flash_error']);
        }

        if ($errorMsg): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>index.php?url=registro" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? ''; ?>">

            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Ej: Carlos Pérez">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono / WhatsApp</label>
                <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Ej: 3001234567">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Mínimo 6 caracteres">
            </div>

            <button type="submit" class="btn-register">Registrarme</button>
        </form>

        <div class="register-footer">
            <p>¿Ya tienes una cuenta? <a href="<?= BASE_URL ?>index.php?url=login">Inicia Sesión</a></p>
        </div>
    </div>
</div>