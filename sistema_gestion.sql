-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2025 a las 07:25:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoría`
--

CREATE TABLE `categoría` (
  `ID_Categoría` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoría`
--

INSERT INTO `categoría` (`ID_Categoría`, `Nombre`) VALUES
(4, 'Anillos'),
(2, 'Aritos'),
(1, 'Brazaletes'),
(3, 'Cadenas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `ID_Detalle` int(11) NOT NULL,
  `ID_Pedido` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL DEFAULT 1,
  `Subtotal` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID_Pedido` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Descripción` text DEFAULT NULL,
  `Material` text DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int(11) NOT NULL DEFAULT 0,
  `Imagen` varchar(255) DEFAULT NULL,
  `ID_Categoría` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_Producto`, `Nombre`, `Descripción`, `Material`, `Precio`, `Stock`, `Imagen`, `ID_Categoría`) VALUES
(38, 'Aritos de Oro Rosa', 'Estos aritos de oro rosa de 18 quilates son perfectos para cualquier ocasión. Su diseño elegante y minimalista los hace ideales para el uso diario o para eventos especiales. El oro rosa aporta un toque de calidez y sofisticación, y su cierre de presión garantiza comodidad y seguridad.', 'Oro', 5500.00, 45, 'imagenes/1.jpg', 2),
(39, 'Aritos de Plata con Circonitas', 'Estos aritos de plata esterlina están adornados con circonitas cúbicas que brillan intensamente.', 'Plata', 3000.00, 20, 'imagenes/7.jpg', 2),
(40, 'Aritos de Platino con Diamantes', 'Estos aritos de platino son la definición de lujo y elegancia. Cada arito está engastado con pequeños diamantes que añaden un brillo deslumbrante. El platino es un metal precioso conocido por su durabilidad y resistencia, lo que hace que estos aritos sean una inversión para toda la vida.', 'Platino', 7000.00, 50, 'imagenes/8.jpg', 2),
(41, 'Aritos de Acero Inoxidable con Diseño Geométrico', 'Estos aritos de acero inoxidable presentan un diseño geométrico moderno y audaz.', 'Acero', 1000.00, 15, 'imagenes/9.jpg', 2),
(42, 'Aritos de Oro Blanco con Perlas', 'Estos aritos de oro blanco de 14 quilates están adornados con perlas cultivadas de agua dulce. Las perlas añaden un toque de elegancia y feminidad, mientras que el oro blanco proporciona un brillo sutil y sofisticado. Son perfectos para ocasiones formales y eventos especiales.', 'Oro', 4500.00, 25, 'imagenes/10.jpg', 2),
(43, 'Aritos de Plata con Diseño de Filigrana', 'Estos aritos de plata esterlina presentan un intrincado diseño de filigrana que les da un aspecto vintage y romántico.', 'Plata', 2500.00, 10, 'imagenes/18.jpg', 2),
(44, 'Aritos de Platino con Zafiros', 'Estos aritos de platino están engastados con zafiros azules que añaden un toque de color y sofisticación. El platino es un metal precioso que no se oxida ni se desgasta, lo que asegura que estos aritos mantendrán su belleza durante muchos años. Los zafiros son piedras preciosas conocidas por su durabilidad y brillo.', 'Platino', 3500.00, 15, 'imagenes/19.jpg', 2),
(45, 'Aritos de Acero Inoxidable con Acabado Mate', 'Estos aritos de acero inoxidable tienen un acabado mate que les da un aspecto moderno y elegante. El acero inoxidable es un material duradero y resistente, ideal para el uso diario. Su diseño simple y minimalista los hace perfectos para cualquier ocasión.', 'Acero', 1500.00, 15, 'imagenes/20.jpg', 2),
(46, 'Cadena de Oro Amarillo', 'Esta cadena de oro amarillo de 18 quilates es un clásico atemporal. Su diseño simple pero elegante la hace ideal para cualquier ocasión, desde eventos formales hasta el uso diario. El oro amarillo es conocido por su durabilidad y resistencia, lo que asegura una larga vida útil.', 'Oro', 5700.00, 15, 'imagenes/29.jpg', 3),
(47, 'Cadena de Plata con Eslabones Gruesos', 'Esta cadena de plata esterlina presenta eslabones gruesos que le dan un aspecto moderno y audaz.', 'Plata', 3500.00, 25, 'imagenes/30.jpg', 3),
(48, 'Cadena de Platino con Eslabones Finos', 'Esta cadena de platino es la definición de lujo y sofisticación. Los eslabones finos y pulidos crean un look elegante y refinado.', 'Platino', 4000.00, 25, 'imagenes/31.jpg', 3),
(49, 'Cadena de Acero Inoxidable con Diseño de Figaro', 'Esta cadena de acero inoxidable presenta un diseño de Figaro que combina eslabones largos y cortos en un patrón atractivo. El acero inoxidable es resistente a la corrosión y al desgaste, lo que hace que esta cadena sea ideal para el uso diario. Su acabado pulido le da un aspecto elegante y moderno.', 'Acero', 4600.00, 26, 'imagenes/32.jpg', 3),
(50, 'Cadena de Oro Blanco con Dijes Intercambiables', 'Esta cadena de oro blanco de 14 quilates viene con dijes intercambiables, lo que permite personalizar el look según la ocasión. El oro blanco ofrece un brillo sutil y sofisticado, mientras que los dijes añaden un toque de personalidad. Perfecta para quienes gustan de la versatilidad en sus accesorios.', 'Oro', 5000.00, 12, 'imagenes/70.jpg', 3),
(51, 'Cadena de Platino Singapur', 'Esta cadena de platino 14 quilates viene con dijes intercambiables, lo que permite personalizar el look según la ocasión. El oro blanco ofrece un brillo sutil y sofisticado, mientras que los dijes añaden un toque de personalidad. Perfecta para quienes gustan de la versatilidad en sus accesorios.', 'Platino', 5000.00, 12, 'imagenes/11.jpg', 3),
(52, 'Cadena de Platino Tipo Cuerda', ' Presenta un diseño trenzado que le da un aspecto lujoso y resistente. Muy elegante para ocasiones formales.', 'Platino', 4200.00, 40, 'imagenes/12.jpg', 3),
(53, 'Cadena de Oro de 14K Estilo Singapur', 'Tiene un diseño retorcido que refleja la luz de manera llamativa. Perfecta para un look sofisticado y delicado.', 'Oro', 3000.00, 10, 'imagenes/13.jpg', 3),
(54, 'Anillo de Acero Inoxidable', 'Un anillo duradero y resistente a la corrosión, ideal para el uso diario. Su acabado pulido le da un aspecto moderno y elegante.', 'Acero', 2000.00, 25, 'imagenes/22.jpg', 4),
(55, 'Anillo de Oro Amarillo de 18K', 'Este anillo clásico y atemporal está hecho de oro amarillo de 18 quilates, perfecto para ocasiones especiales y como símbolo de compromiso.', 'Oro', 2500.00, 25, 'imagenes/28.jpg', 4),
(56, 'Anillo de Plata 925', 'Fabricado con plata de ley, este anillo es conocido por su brillo y versatilidad. Es una opción popular para regalos y uso diario.', 'Plata', 1500.00, 14, 'imagenes/35.jpg', 4),
(57, 'Anillo de Platino', 'Un anillo de platino puro, conocido por su durabilidad y resistencia al desgaste. Ideal para aquellos que buscan una joya de alta calidad y lujo.', 'Platino', 1600.00, 23, 'imagenes/36.jpg', 4),
(58, 'Anillo de Acero Inoxidable con Incrustaciones de Oro', 'Combina la resistencia del acero inoxidable con la elegancia del oro, creando un diseño único y sofisticado.', 'Acero', 3000.00, 12, 'imagenes/38.jpg', 4),
(59, 'Anillo de Oro Blanco de 14K', 'Este anillo de oro blanco de 14 quilates ofrece un aspecto moderno y elegante, perfecto para bodas y compromisos.', 'Oro', 5000.00, 36, 'imagenes/39.jpg', 4),
(60, 'Anillo de Plata con Detalles de Platino', 'Un anillo de plata con detalles de platino, que añade un toque de lujo y sofisticación a un diseño clásico.', 'Plata', 4000.00, 15, 'imagenes/40.jpg', 4),
(61, 'Anillo de Platino con Diamantes', 'Un anillo de platino adornado con diamantes, ideal para ocasiones especiales y como símbolo de amor eterno.', 'Platino', 7000.00, 10, 'imagenes/41.jpg', 4),
(62, 'Brazalete de Acero Inoxidable', 'Un brazalete duradero y resistente a la corrosión, ideal para el uso diario. Su diseño moderno y elegante lo hace perfecto para cualquier ocasión.', 'Acero', 1500.00, 16, 'imagenes/16.jpg', 1),
(63, 'Brazalete de Oro Amarillo de 18K', 'Este brazalete clásico y atemporal está hecho de oro amarillo de 18 quilates, perfecto para ocasiones especiales y como símbolo de lujo', 'Oro', 4500.00, 25, 'imagenes/17.jpg', 1),
(64, 'Brazalete de Plata 925', 'Fabricado con plata de ley, este brazalete es conocido por su brillo y versatilidad. Es una opción popular para regalos y uso diario.', 'Plata', 2000.00, 45, 'imagenes/82.jpg', 1),
(65, 'Brazalete de Platino', 'Un brazalete de platino puro, conocido por su durabilidad y resistencia al desgaste. Ideal para aquellos que buscan una joya de alta calidad y lujo.', 'Platino', 4000.00, 32, 'imagenes/81.jpg', 1),
(66, 'Brazalete de Acero Inoxidable con Incrustaciones de Oro', 'Combina la resistencia del acero inoxidable con la elegancia del oro, creando un diseño único y sofisticado.', 'Acero', 2500.00, 14, 'imagenes/75.jpg', 1),
(67, 'Brazalete de Oro Blanco de 14K', 'Este brazalete de oro blanco de 14 quilates ofrece un aspecto moderno y elegante, perfecto para bodas y compromisos.', 'Oro', 6000.00, 24, 'imagenes/78.jpg', 1),
(68, 'Brazalete de Plata con Detalles de Platino', 'Un brazalete de plata con detalles de platino, que añade un toque de lujo y sofisticación a un diseño clásico.', 'Plata', 3500.00, 25, 'imagenes/79.jpg', 1),
(69, 'Brazalete de Platino con Diamantes', 'Un brazalete de platino adornado con diamantes, ideal para ocasiones especiales y como símbolo de amor eterno.', 'Platino', 1500.00, 23, 'imagenes/77.jpg', 1),
(70, 'Brazalete de Platino con Diamantes', 'Un brazalete de plata con detalles de platino, que añade un toque de lujo y sofisticación a un diseño clásico.', 'Platino', 2300.00, 16, 'imagenes/75.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `Rol`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `idRol` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `nombre`, `idRol`, `correo`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador Web', 1, 'admin@gmail.com'),
(2, 'vendedor', '88d6818710e371b461efff33d271e0d2fb6ccf47', 'Juan Carlos Arguijo', 2, 'vendedor@gmail.com'),
(3, 'Alex', 'c129b324aee662b04eccf68babba85851346dff9', 'Alex Jose Nuñez Salcedo', 2, 'alexjose@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoría`
--
ALTER TABLE `categoría`
  ADD PRIMARY KEY (`ID_Categoría`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`ID_Detalle`),
  ADD KEY `ID_Pedido` (`ID_Pedido`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID_Pedido`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Categoría` (`ID_Categoría`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoría`
--
ALTER TABLE `categoría`
  MODIFY `ID_Categoría` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `ID_Detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_Pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`ID_Pedido`) REFERENCES `pedido` (`ID_Pedido`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`ID_Categoría`) REFERENCES `categoría` (`ID_Categoría`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
