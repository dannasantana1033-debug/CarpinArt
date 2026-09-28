-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2026 a las 18:15:54
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carpinart_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `imagen`, `created_at`) VALUES
(1, 'Camas y Alcobas', 'Camas de todas las dimensiones, respaldos y veladores', NULL, '2026-08-10 14:28:21'),
(2, 'Clósets y Armarios', 'Muebles de almacenamiento para ropa y dormitorios', NULL, '2026-08-10 14:28:21'),
(3, 'Mesas y Comedores', 'Mesas de centro, comedores principales y auxiliares', NULL, '2026-08-10 14:28:21'),
(4, 'Escritorios', 'Muebles para estudio y oficina', NULL, '2026-08-10 14:28:21'),
(5, 'Cocinas Integrales', 'Módulos superiores e inferiores para cocina', NULL, '2026-08-10 14:28:21'),
(6, 'Puertas y Repisas', 'Puertas de paso, exteriores y estantería de pared', NULL, '2026-08-10 14:28:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones_personalizadas`
--

CREATE TABLE `cotizaciones_personalizadas` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `material_preferido_id` int(10) UNSIGNED DEFAULT NULL,
  `titulo_proyecto` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_diseno` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `largo_cm` decimal(8,2) DEFAULT NULL,
  `ancho_cm` decimal(8,2) DEFAULT NULL,
  `alto_cm` decimal(8,2) DEFAULT NULL,
  `imagen_referencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presupuesto_estimado_cliente` decimal(10,2) DEFAULT NULL,
  `precio_cotizado_carpintero` decimal(10,2) DEFAULT NULL,
  `tiempo_estimado_dias` int(10) UNSIGNED DEFAULT NULL,
  `estado` enum('pendiente','en_revision','cotizada','aceptada','rechazada','cancelada') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `notas_carpintero` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Null si es una cotización 100% personalizada',
  `nombre_item` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible` int(11) NOT NULL DEFAULT '0',
  `ubicacion_almacen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ej: Madera Maciza, MDF, Triplay, Melamina',
  `precio_m2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock_m2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `nombre`, `descripcion`, `tipo`, `precio_m2`, `stock_m2`, `created_at`, `updated_at`) VALUES
(1, 'Madera Roble Macizo', NULL, 'Madera Maciza', '85.00', '150.00', '2026-08-10 14:28:21', '2026-08-10 14:28:21'),
(2, 'Madera Cedro', NULL, 'Madera Maciza', '95.00', '100.00', '2026-08-10 14:28:21', '2026-08-10 14:28:21'),
(3, 'MDF 18mm RH (Resistente Humedad)', NULL, 'MDF', '35.00', '300.00', '2026-08-10 14:28:21', '2026-08-10 14:28:21'),
(4, 'Melamina RH Blanco Rhur', NULL, 'Melamina', '28.00', '450.00', '2026-08-10 14:28:21', '2026-08-10 14:28:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `cotizacion_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Vinculado si proviene de un mueble a medida',
  `codigo_pedido` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costo_envio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `estado_pedido` enum('pendiente','pagado','en_fabricacion','listo_despacho','enviado','entregado','cancelado') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `direccion_entrega` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodo_pago` enum('tarjeta','transferencia','efectivo_contraentrega') COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia_pago` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio_base` decimal(10,2) NOT NULL,
  `medidas_estandar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ej: 190x140x40 cm',
  `tiempo_entrega_dias` int(10) UNSIGNED NOT NULL DEFAULT '5',
  `imagen_principal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('disponible','agotado','descontinuado') COLLATE utf8mb4_unicode_ci DEFAULT 'disponible',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `created_at`) VALUES
(1, 'administrador', 'Carpintero / Dueño con acceso total al sistema', '2026-08-10 14:28:21'),
(2, 'cliente', 'Usuario registrado para compra y cotización', '2026-08-10 14:28:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('activo','inactivo','bloqueado') COLLATE utf8mb4_unicode_ci DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cotizaciones_personalizadas`
--
ALTER TABLE `cotizaciones_personalizadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cotizaciones_materiales` (`material_preferido_id`),
  ADD KEY `idx_cotizaciones_usuario` (`usuario_id`),
  ADD KEY `idx_cotizaciones_estado` (`estado`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_pedidos` (`pedido_id`),
  ADD KEY `fk_detalle_productos` (`producto_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_pedido` (`codigo_pedido`),
  ADD KEY `fk_pedidos_cotizaciones` (`cotizacion_id`),
  ADD KEY `idx_pedidos_usuario` (`usuario_id`),
  ADD KEY `idx_pedidos_estado` (`estado_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_productos_categoria` (`categoria_id`),
  ADD KEY `idx_productos_estado` (`estado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cotizaciones_personalizadas`
--
ALTER TABLE `cotizaciones_personalizadas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizaciones_personalizadas`
--
ALTER TABLE `cotizaciones_personalizadas`
  ADD CONSTRAINT `fk_cotizaciones_materiales` FOREIGN KEY (`material_preferido_id`) REFERENCES `materiales` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cotizaciones_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `fk_detalle_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_cotizaciones` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones_personalizadas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
