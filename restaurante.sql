create database restaurante;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--




--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas_licores`
--

CREATE TABLE `bebidas_licores` (
  `id_bebidas` int(10) NOT NULL,
  `nombre_bebidas` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio_unitario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bebidas_licores`
--

INSERT INTO `bebidas_licores` (`id_bebidas`, `nombre_bebidas`, `descripcion`, `precio_unitario`) VALUES
(1, 'Limonchelo', 'Bajativo de limón', 1990),
(2, 'Coca-Cola', 'Bebida gaseosa 350ml', 1500),
(3, 'Sprite', 'Bebida gaseosa 350ml', 1500),
(4, 'Fanta Naranja', 'Bebida gaseosa 350ml', 1500),
(5, 'Jugo Natural de Naranja', 'Jugo exprimido', 2500),
(6, 'Limonada', 'Limonada casera', 2300),
(7, 'Cerveza Kunstmann Torobayo', 'Botella 330ml', 3500),
(8, 'Cerveza Corona', 'Botella 330ml', 3000),
(9, 'Pisco Sour', 'Trago tradicional chileno', 4500),
(10, 'Vino Tinto Cabernet', 'Copa de vino tinto', 4000),
(11, 'Agua Mineral', 'Agua sin gas 500ml', 1200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `subtotal`) VALUES
(1, 1, 2, 1, 1500),
(2, 1, 3, 1, 1500),
(3, 1, 8, 1, 8500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ensaladas`
--

CREATE TABLE `ensaladas` (
  `id_ensalada` int(10) NOT NULL,
  `nombre_ensaladas` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio_unitario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ensaladas`
--

INSERT INTO `ensaladas` (`id_ensalada`, `nombre_ensaladas`, `descripcion`, `precio_unitario`) VALUES
(1, 'Ensalada Caprese', 'Tomate, mozzarella y albahaca fresca', 5500),
(2, 'Ensalada César Italiana', 'Lechuga romana, parmesano y crutones', 6200),
(3, 'Ensalada Mediterránea', 'Aceitunas, pepino, tomate y queso feta', 5900),
(4, 'Ensalada Primavera', 'Verduras frescas de temporada', 5200),
(5, 'Ensalada de Rúcula', 'Rúcula, parmesano y aceite de oliva', 6500),
(6, 'Ensalada Toscana', 'Frijoles blancos, cebolla y tomate', 5800),
(7, 'Ensalada de Pesto', 'Pasta corta con pesto y tomates cherry', 6000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `numero_mesa` varchar(5) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `numero_mesa`, `capacidad`, `estado`) VALUES
(1, 'M1', 4, 'Libre'),
(2, 'M2', 8, 'Libre'),
(3, 'M3', 4, 'Libre'),
(4, 'M4', 4, 'Libre'),
(5, 'M5', 4, 'Libre'),
(6, 'M6', 4, 'Libre'),
(7, 'M7', 8, 'Libre'),
(8, 'M8', 6, 'Libre'),
(9, 'M9', 4, 'Libre'),
(10, 'M10', 8, 'Libre'),
(11, 'M11', 6, 'Libre'),
(12, 'M12', 6, 'Libre'),
(13, 'M13', 4, 'Libre'),
(14, 'M14', 4, 'Libre'),
(15, 'M15', 8, 'Libre'),
(16, 'M16', 4, 'Libre'),
(17, 'M17', 4, 'Libre'),
(18, 'M18', 6, 'Libre'),
(19, 'M19', 6, 'Libre'),
(20, 'M20', 4, 'Libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(10) NOT NULL,
  `mesa` int(10) NOT NULL,
  `mesero` varchar(100) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `total` int(15) NOT NULL,
  `forma de pago` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `mesa`, `mesero`, `fecha_pedido`, `total`, `forma de pago`) VALUES
(1, 1, '2', '2025-11-23', 14500, 'Efectivo'),
(2, 1, '20', '2025-11-23', 18400, 'Efectivo'),
(3, 1, '2', '2025-11-23', 21790, 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_de_fondo`
--

CREATE TABLE `platos_de_fondo` (
  `id_plato_fondo` int(10) NOT NULL,
  `nombre_plato` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio_unitario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos_de_fondo`
--

INSERT INTO `platos_de_fondo` (`id_plato_fondo`, `nombre_plato`, `descripcion`, `precio_unitario`) VALUES
(1, 'Spaghetti al pesto', 'Spaghetti con salsa de pesto', 15500),
(2, 'Lasagna alla Bolognese', 'Lasaña tradicional italiana con salsa boloñesa y queso gratinado', 11500),
(3, 'Risotto ai Funghi', 'Risotto cremoso con champiñones frescos y parmesano', 10500),
(4, 'Gnocchi al Pesto', 'Gnocchi de papa con salsa pesto genovesa', 9800),
(5, 'Spaghetti Carbonara', 'Spaghetti con salsa de huevo, queso pecorino y panceta', 9200),
(6, 'Tagliatelle Alfredo', 'Pasta fresca con salsa alfredo cremosa', 9900),
(7, 'Pollo alla Parmigiana', 'Pechuga de pollo apanada con salsa de tomate y queso mozzarella gratinado', 10800),
(8, 'Pizza Margherita', 'Pizza clásica con salsa de tomate, mozzarella y albahaca', 8500),
(9, 'Pizza Quattro Formaggi', 'Pizza con mezcla de cuatro quesos italianos', 9500),
(10, 'Fettuccine ai Frutti di Mare', 'Fettuccine con salsa de mariscos y vino blanco', 12800),
(11, 'Saltimbocca alla Romana', 'Filete delgado de cerdo con jamón serrano y salvia', 13500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(10) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripción` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripción`) VALUES
(1, 'Administrador', 'Quien administra todo el restaurante'),
(2, 'Mesero', 'Quien se encarga de recolectar los pedidos de los clientes'),
(3, 'Cajero', 'Quien se encarga de generar boletas y hacer los cobros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(10) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `id_rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombre_usuario`, `password`, `email`, `activo`, `id_rol`) VALUES
(1, 'Luis Tomás Benjamín Carrasco Godoy', '$2y$10$ySgXur3dn6foRuhHtw.fwOAEPrtU7soIfD0o2HADt7Dejdd.vSMHW', 'tomascarrascogodoy@gmail.com', 1, 1),
(2, 'Juan Pérez', '$2y$10$.8ctcziRT7VgAZk.KPpRouvKSmyhza3gll/WlYQASS9/GtP40Qw.m', 'juanpe@gmail.com', 1, 2),
(3, 'María López', '$2y$10$7E3P7vxqQN20nW9VjZ5/8eRf9r.AfcMQORug2yLSnykxzx4X0si6K', 'maria.lopez@gmail.com', 1, 2),
(4, 'Carlos Ramírez', '$2y$10$6ZV263IaWYvDY0/7MEmIJud8HNZwwOUSHqeQmsrU9B5t/a0.YJ/l2', 'carlos.ramirez@gmail.com', 1, 2),
(5, 'Fernanda Soto', '$2y$10$OGwKB4cPZMa6gSVuOdmO2.jzUKKK6j35diBg.jKS8LEg/m2YWJlWC', 'fernanda.soto@gmail.com', 1, 3),
(6, 'Pedro Morales', '$2y$10$p5G.ApbMkcUnN8WE3ILZz.X4.UXfO1358s8iwOluhaPP4AgpdfVIa', 'pedro.morales@gmail.com', 1, 3),
(7, 'Beatriz Díaz', '$2y$10$c/HXzkVlHKwFpEbg4gg22eoArLYLPXnm.iU0kPHV5lkHF4N67vyZi', 'beatriz.diaz@gmail.com', 1, 3),
(8, 'Giovanni Rinaldi', '$2y$10$lar8StZmNy.rsp1tifOBNegVRUDp1ZEdAYbGTqzCu/OS3GFH/np7m', 'giovanni@gmail.com', 1, 2),
(9, 'Marco Santini', '$2y$10$tUsdxHi7QWar0OSAJvL14uQA0LyIHLZM1HvLAF4oX1UAnnETbBpAm', 'marcos@gmail.com', 1, 2),
(10, 'Elena Bianchi', '$2y$10$NsTbwjcGAS/iBMvaGDLJ9.zBgwWDuA3Fk7AtycK1aOBVHg3Kc1/Le', 'elenab@gmail.com', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bebidas_licores`
--
ALTER TABLE `bebidas_licores`
  ADD PRIMARY KEY (`id_bebidas`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `platos_de_fondo`
--
ALTER TABLE `platos_de_fondo`
  ADD PRIMARY KEY (`id_plato_fondo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD KEY `FkRol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bebidas_licores`
--
ALTER TABLE `bebidas_licores`
  MODIFY `id_bebidas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `platos_de_fondo`
--
ALTER TABLE `platos_de_fondo`
  MODIFY `id_plato_fondo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
