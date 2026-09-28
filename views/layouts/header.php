<?php
// Asegurarse de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar el rol de forma segura y flexible (soporta 'role', 'rol' o 'user_rol')
$rolActual = $_SESSION['role'] ?? $_SESSION['rol'] ?? $_SESSION['user_rol'] ?? '';
$isAdmin = ($rolActual === 'admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarpinArt - Muebles a Medida</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --wood-dark: #2B1810;
            --wood-amber: #D96B27;
            --wood-light: #F8F5F0;
            --wood-accent: #E2A049;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--wood-light);
            color: #333;
        }

        .navbar-custom {
            background-color: var(--wood-dark) !important;
            border-bottom: 4px solid var(--wood-amber);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-size: 1.6rem;
            font-weight: 700;
            color: #FFF !important;
        }

        .brand-highlight {
            color: var(--wood-amber);
        }

        .tagline {
            font-size: 0.72rem;
            color: var(--wood-accent);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: block;
        }

        .nav-link {
            color: #E0E0E0 !important;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--wood-amber) !important;
        }

        .btn-carpenter {
            background-color: var(--wood-amber);
            color: #FFF !important;
            font-weight: 600;
            border-radius: 6px;
            padding: 0.5rem 1.2rem;
            transition: background-color 0.2s;
        }

        .btn-carpenter:hover {
            background-color: #B85213;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            background-color: #FFFFFF;
        }

        .section-header {
            border-left: 5px solid var(--wood-amber);
            padding-left: 12px;
            color: var(--wood-dark);
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Navbar Única, Moderna y Adaptativa -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-2">
    <div class="container">
        <!-- Logo con Icono de Carpintería -->
        <a class="navbar-brand d-flex align-items-center gap-3" href="<?= BASE_URL ?>">
            <div class="bg-warning text-dark p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fa-solid fa-hammer fa-lg text-dark"></i>
            </div>
            <div>
                <div>Carpin<span class="brand-highlight">Art</span></div>
                <span class="tagline">Diseño y Carpintería</span>
            </div>
        </a>

        <!-- Botón Menú Móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCarpinArt">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Opciones de Navegación -->
        <div class="collapse navbar-collapse" id="navbarCarpinArt">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>"><i class="fa-solid fa-house me-1"></i> Inicio</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <?php if ($isAdmin): ?>
                        <!-- OPCIONES DE ADMINISTRADOR -->
                        <li class="nav-item">
                            <a class="btn btn-outline-warning btn-sm" href="<?= BASE_URL ?>admin/cotizaciones">
                                <i class="fa-solid fa-screwdriver-wrench me-1"></i> Panel Taller
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- OPCIONES DE CLIENTE -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>cotizacion/crear"><i class="fa-solid fa-ruler-combined me-1"></i> Cotizar Mueble</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>cotizacion/misCotizaciones">
                                <i class="fa-solid fa-folder-open me-1"></i> Mis Cotizaciones
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Saludo y Botón Salir -->
                    <li class="nav-item ms-lg-3 text-light d-flex align-items-center">
                        <span class="small">Hola, <strong><?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario') ?></strong></span>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-danger btn-sm" href="<?= BASE_URL ?>logout">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Salir
                        </a>
                    </li>

                <?php else: ?>
                    <!-- Si NO ha iniciado sesión -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>login">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-carpenter text-white" href="<?= BASE_URL ?>registro">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-5">