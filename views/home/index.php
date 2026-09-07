<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Enlace al archivo CSS externo -->
<link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">

<!-- HEADER / NAVEGACIÓN -->
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

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1>Diseño y Carpintería a tu Medida</h1>
        <p>Transformamos la madera en piezas únicas para tu hogar u oficina. Calidad artesanal con acabados profesionales.</p>
        <a href="<?= BASE_URL ?>cotizacion/crear" class="btn-hero">Solicitar Cotización 🪚</a>
    </div>
</section>

<!-- CATÁLOGO -->
<div class="container">
    <div class="section-title">
        <h2>Trabajos Destacados</h2>
        <p>Explora algunas de nuestras creaciones exclusivas</p>
    </div>

    <div class="products-grid">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=600&auto=format&fit=crop" alt="Mueble Sala" class="product-img">
            <div class="product-info">
                <h3>Juegos de Sala</h3>
                <p>Estructuras en madera maciza con acabados de lujo diseñadas para el máximo confort.</p>
                <a href="<?= BASE_URL ?>productos" class="btn-card">Ver Detalle</a>
            </div>
        </div>

        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=600&auto=format&fit=crop" alt="Comedor" class="product-img">
            <div class="product-info">
                <h3>Comedores Rusticos</h3>
                <p>Mesas en cedro y roble talladas a mano ideales para compartir en familia.</p>
                <a href="<?= BASE_URL ?>productos" class="btn-card">Ver Detalle</a>
            </div>
        </div>

        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1595428774223-ef52624120d2?q=80&w=600&auto=format&fit=crop" alt="Closet" class="product-img">
            <div class="product-info">
                <h3>Closets & Armarios</h3>
                <p>Aprovechamiento de espacio inteligente con modulares de madera de alta durabilidad.</p>
                <a href="<?= BASE_URL ?>productos" class="btn-card">Ver Detalle</a>
            </div>
        </div>
    </div>

    <!-- BANNER COTIZACIÓN -->
    <div class="quote-banner">
        <h3>¿Tienes una idea en mente?</h3>
        <p>Envíanos las medidas y especificaciones de tu proyecto. Te enviamos la cotización de inmediato.</p>
        <a href="<?= BASE_URL ?>cotizacion/crear" class="btn-hero">Cotizar Mi Mueble</a>
    </div>
</div>