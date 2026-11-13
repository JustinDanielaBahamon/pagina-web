-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2024 a las 04:06:09
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hamaca_mb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cod_cliente` int(11) NOT NULL,
  `nom_cliente` varchar(150) NOT NULL,
  `ape_cliente` varchar(150) NOT NULL,
  `doc_cliente` varchar(150) NOT NULL,
  `tel_cliente` bigint(15) NOT NULL,
  `correo_cliente` varchar(150) NOT NULL,
  `ciu_cliente` varchar(150) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

-- Datos de `clientes` omitidos: eran datos de prueba con informacion personal.

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `cod_factura` int(11) NOT NULL,
  `cod_cliente` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `total` double NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 NOT NULL,
  `direccion` varchar(30) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factura`
--

-- Datos de `factura` omitidos: eran datos de prueba con informacion personal.

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE `factura_detalle` (
  `cod_factura_detalle` int(11) NOT NULL,
  `cod_factura` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` bigint(20) NOT NULL,
  `valor_unitario` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `cod_producto` int(11) NOT NULL,
  `nom_producto` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `valor_unidad` double NOT NULL,
  `cant_producto` double NOT NULL,
  `desc_producto` text CHARACTER SET utf8mb4 NOT NULL,
  `imagen_producto` text CHARACTER SET utf8mb4 NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod_producto`, `nom_producto`, `valor_unidad`, `cant_producto`, `desc_producto`, `imagen_producto`, `estado`) VALUES
(1, 'hamacas de palo azul', 350000, 1, 'Material	Algod?n y orl?n\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo', 'h16.jpg', 1),
(2, 'hamacas de palo', 350000, 2, 'Material	Algod?n y orl?n\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo', 'h15.jpg', 1),
(3, 'hamacas de palo', 350000, 1, 'Material	Algod?n y orl?n\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul', 'h16.jpg', 1),
(6, 'hamacas ', 400000, 2, 'Material Algod?n y orl?n Capacidad 1-2 personas Colores Disponibles Azul', 'h17.jpg', 1),
(7, 'hamacas de palo ', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$', 'h18.jpg', 1),
(8, 'HAMACA CON PALO BLANCO', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h19.jpg', 1),
(9, 'hamacas de palo negro', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h20.jpg', 1),
(10, 'hamacas de palo amarilla', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h21.jpg', 1),
(11, 'hamacas de palo rayada', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h22.jpg', 1),
(12, 'hamacas con palo roja', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h23.jpg', 1),
(13, 'hamacas ', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h24.jpg', 1),
(14, 'hamaca', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h25.jpg', 1),
(15, 'hamaca rayada', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h26.jpg', 1),
(16, 'hamaca negra', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h27.jpg', 1),
(17, 'hamaca azul', 350000, 1, 'Material	Algodón y orlón\r\nCapacidad	1-2 personas\r\nColores Disponibles	Azul, Verde, Amarillo, Rojo\r\nPrecio	$\r\n', 'h28.jpg', 1),
(18, 'bolsos', 60000, 1, 'color negro', 'bol1.jpg', 1),
(19, 'bolsos', 60000, 1, 'color blanco', 'bol2.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `pass` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

-- Datos de `usuarios` omitidos: eran datos de prueba con informacion personal.

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cod_cliente`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`cod_factura`,`cod_cliente`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`cod_factura_detalle`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cod_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `cod_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `cod_factura_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `cod_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
