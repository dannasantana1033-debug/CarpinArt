<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">

<header class="main-header">
    <div class="logo">
        <a href="<?= BASE_URL ?>">🪚 CarpinArt</a>
    </div>
    <nav class="nav-links">
        <a href="<?= BASE_URL ?>">Inicio</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="user-welcome">Hola, <?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario') ?></span>
            <a href="<?= BASE_URL ?>index.php?url=logout" class="btn-logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>index.php?url=login">Login</a>
            <a href="<?= BASE_URL ?>index.php?url=registro" class="btn-register">Registro</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container" style="margin-top: 3rem; margin-bottom: 3rem; max-width: 800px; background: #fff; padding: 2.5rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2>Solicita tu Mueble a Medida</h2>
        <p>Cuéntanos tu idea. Diseñamos y fabricamos piezas exclusivas ajustadas a tus necesidades.</p>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="<?= BASE_URL ?>cotizacion/guardar" method="POST" style="display: flex; flex-direction: column; gap: 1.2rem;">
            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label style="font-weight: 600; color: #3e2723;">Título del Proyecto:</label>
                <input type="text" name="titulo_proyecto" required placeholder="Ej: Escritorio moderno" style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label style="font-weight: 600; color: #3e2723;">Descripción o Diseño:</label>
                <textarea name="descripcion_diseno" rows="4" required placeholder="Describe detalles y estilo..." style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label style="font-weight: 600; color: #3e2723;">Largo (cm):</label>
                    <input type="number" name="largo_cm" step="0.1" required style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label style="font-weight: 600; color: #3e2723;">Ancho (cm):</label>
                    <input type="number" name="ancho_cm" step="0.1" required style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label style="font-weight: 600; color: #3e2723;">Alto (cm):</label>
                    <input type="number" name="alto_cm" step="0.1" required style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label style="font-weight: 600; color: #3e2723;">Presupuesto Estimado ($):</label>
                <input type="number" step="0.01" name="presupuesto_estimado_cliente" placeholder="Ej: 500000" style="padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <button type="submit" style="margin-top: 1rem; padding: 0.85rem; background: #3e2723; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Enviar Solicitud 🪚</button>
        </form>
    <?php else: ?>
        <div style="text-align: center; padding: 2rem;">
            <p style="margin-bottom: 1rem; color: #555;">Debes iniciar sesión para solicitar una cotización.</p>
            <a href="<?= BASE_URL ?>index.php?url=login" style="padding: 0.75rem 1.5rem; background: #3e2723; color: #fff; border-radius: 4px; text-decoration: none; font-weight: bold;">Iniciar Sesión</a>
        </div>
    <?php endif; ?>
</div>