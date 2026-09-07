<!-- views/auth/login.php -->

<style>
.login-wrapper {
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    background: linear-gradient(135deg, #1e130c 0%, #3a2212 40%, #5d3215 70%, #d4a373 100%);
    border-radius: 12px;
}

.login-card {
    width: 100%;
    max-width: 480px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2.8rem 2.2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35), 0 0 20px rgba(212, 163, 115, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.brand-badge {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #e67e22, #d35400);
    color: #ffffff;
    font-size: 2.2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.2rem auto;
    box-shadow: 0 8px 20px rgba(211, 84, 0, 0.4);
    border: 3px solid #fff;
}

.login-header h2 {
    color: #2c1d1a;
    font-size: 2.1rem;
    font-weight: 800;
    margin: 0 0 0.4rem 0;
    letter-spacing: -0.5px;
}

.login-header p {
    color: #6e584f;
    font-size: 0.95rem;
    font-weight: 500;
    margin: 0;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.4rem;
    color: #3e2723;
    font-weight: 700;
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 0.85rem 1.1rem;
    background-color: #fcf8f5;
    border: 2px solid #e2d1c3;
    border-radius: 12px;
    font-size: 0.98rem;
    color: #2c1d1a;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    background-color: #ffffff;
    border-color: #d35400;
    box-shadow: 0 0 0 4px rgba(211, 84, 0, 0.15);
}

.btn-login {
    width: 100%;
    padding: 0.95rem;
    background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(211, 84, 0, 0.35);
    transition: all 0.3s ease;
    margin-top: 0.8rem;
    letter-spacing: 0.5px;
}

.btn-login:hover {
    background: linear-gradient(135deg, #d35400 0%, #a04000 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(211, 84, 0, 0.45);
}

.alert {
    padding: 0.85rem 1rem;
    border-radius: 10px;
    margin-bottom: 1.25rem;
    font-size: 0.88rem;
    font-weight: 600;
}

.alert-danger {
    background-color: #fce8e6;
    color: #c0392b;
    border: 1px solid #f5b7b1;
}

.login-footer {
    text-align: center;
    margin-top: 1.8rem;
    padding-top: 1.4rem;
    border-top: 1px solid #e8ddd5;
    font-size: 0.92rem;
    color: #6e584f;
}

.login-footer a {
    color: #d35400;
    font-weight: 800;
    text-decoration: none;
    transition: color 0.2s;
}

.login-footer a:hover {
    color: #a04000;
    text-decoration: underline;
}
</style>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="brand-badge">🪚</div>
            <h2>Iniciar Sesión</h2>
            <p>Accede a tu cuenta para gestionar tus cotizaciones</p>
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

        <form action="<?= defined('BASE_URL') ? BASE_URL : '/carpinart/'; ?>login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? ''; ?>">

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-login">Ingresar</button>
        </form>

        <div class="login-footer">
            <p>¿Aún no tienes una cuenta? <a href="<?= defined('BASE_URL') ? BASE_URL : '/carpinart/'; ?>registro">Regístrate aquí</a></p>
        </div>
    </div>
</div>