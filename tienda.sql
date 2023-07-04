-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2023 a las 08:25:47
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`, `descripcion`, `updated_at`, `created_at`) VALUES
(1, 'Telefonos Samsung', 'marca samsung', '2023-05-10', '2023-05-19 19:53:33'),
(2, 'Laptop', 'marca samsung', '2023-05-15', '2023-05-15 16:39:31'),
(4, 'Accesorios', 'marca huawei', '2023-05-19', '2023-05-19 04:29:07'),
(5, 'componentes', 'marca huawei', '2023-05-19', '2023-05-19 04:29:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cedula` varchar(45) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fechaNac` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cedula`, `nombre`, `fechaNac`, `email`, `updated_at`, `created_at`) VALUES
('504460215', 'Jordy Palacios Brown', '2023-06-06', 'JordyBrown230@gmail.com', '2023-06-25 05:25:44', '2023-06-25 05:25:44'),
('504460216', 'rastman', '2023-05-04', 'ra@gmail.com', '2023-06-24 21:29:13', '2023-06-24 21:29:13'),
('50703232', 'Jeudy Saul Palacios Brown', '2023-05-02', 'Saulyt23@gmail.com', '2023-05-19 05:03:39', '2023-05-19 05:00:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleorden`
--

CREATE TABLE `detalleorden` (
  `idDetalleOrden` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` float NOT NULL,
  `ivaUnitario` float NOT NULL,
  `orden` int(11) NOT NULL,
  `producto` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccioncliente`
--

CREATE TABLE `direccioncliente` (
  `idDireccionesCliente` int(11) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `cliente` varchar(45) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `direccioncliente`
--

INSERT INTO `direccioncliente` (`idDireccionesCliente`, `direccion`, `cliente`, `updated_at`, `created_at`) VALUES
(6, 'Costa Rica, Liberia', '504460215', '2023-06-25 19:10:21', '2023-06-25 19:08:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL,
  `cedula` varchar(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `fechaNac` date NOT NULL,
  `fechaIngreso` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `tipoEmpleado` varchar(60) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idEmpleado`, `cedula`, `nombre`, `fechaNac`, `fechaIngreso`, `email`, `tipoEmpleado`, `updated_at`, `created_at`) VALUES
(4, '504460215', 'Jordy Palacios Brown', '2002-02-10', '2022-02-10', 'Jordy@gmail.com', 'Chofer', '2023-05-21 06:05:53', '2023-05-21 06:01:29'),
(5, '59598598', 'Mari Vega', '2023-06-25', '2009-06-09', 'marivega0626@gmail.com', 'Dependiente', '2023-06-25 05:34:22', '2023-06-25 05:34:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `idEnvio` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `chofer` int(11) DEFAULT NULL,
  `vehiculo` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`idEnvio`, `direccion`, `chofer`, `vehiculo`, `updated_at`, `created_at`) VALUES
(4, 'liberia', 4, 6, '2023-06-24 15:05:50', '2023-06-24 15:03:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `idOrden` int(11) NOT NULL,
  `tipoRetiro` varchar(45) NOT NULL,
  `fechaOrden` date NOT NULL,
  `total` float NOT NULL,
  `ivaTotal` float NOT NULL,
  `cliente` varchar(45) NOT NULL,
  `empleado` int(11) DEFAULT NULL,
  `envio` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`idOrden`, `tipoRetiro`, `fechaOrden`, `total`, `ivaTotal`, `cliente`, `empleado`, `envio`, `updated_at`, `created_at`) VALUES
(6, 'Envio', '2023-06-24', 74.96, 0.13, '500001214', NULL, 4, '2023-06-24 15:03:40', '2023-06-24 15:03:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `precioUnitario` float NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `proveedor` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `nombre`, `precioUnitario`, `stock`, `image`, `proveedor`, `categoria`, `updated_at`, `created_at`) VALUES
(18, 'Laptop razer', 213, 2, '1687658047echodot.jpg', 1, 2, '2023-06-25 22:08:17', '2023-06-25 01:54:08'),
(19, 'Laptop hp', 120, 54, '1687658184echodot.jpg', 343, 2, '2023-06-25 22:08:29', '2023-06-25 01:56:24'),
(20, 'Procesador Ryzer', 1159, 30, '1687730014echodot.jpg', 1, 5, '2023-06-25 22:08:45', '2023-06-25 21:53:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `nombreCompania` varchar(80) NOT NULL,
  `numTelefono` varchar(30) NOT NULL,
  `email` varchar(45) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idProveedor`, `nombreCompania`, `numTelefono`, `email`, `updated_at`, `created_at`) VALUES
(1, 'peque SA', '60606070', 'mari230@gmail.com', '2023-05-22 20:00:37', '2023-05-24 20:00:37'),
(343, 'Gomu gomu no mi', '+506 70908080', 'hola@gmail.com', '2023-05-19 04:54:23', '2023-05-15 16:07:03'),
(3005, 'Hola maa', '+506 890', 'hol1@gmail.com', '2023-05-15 16:20:55', '2023-05-15 16:20:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonocliente`
--

CREATE TABLE `telefonocliente` (
  `idTelefonosCliente` int(11) NOT NULL,
  `numTelefono` varchar(30) NOT NULL,
  `cliente` varchar(45) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `telefonocliente`
--

INSERT INTO `telefonocliente` (`idTelefonosCliente`, `numTelefono`, `cliente`, `updated_at`, `created_at`) VALUES
(6, '606060', '504460215', NULL, NULL),
(7, '60606070', '504460216', NULL, NULL),
(9, '888888', '504460215', '2023-06-25 16:27:17', '2023-06-25 06:55:03'),
(10, '909099001', '504460215', '2023-06-25 07:01:03', '2023-06-25 07:01:03'),
(11, '0000000', '504460215', '2023-06-25 16:29:33', '2023-06-25 16:29:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(45) NOT NULL,
  `password` varchar(170) NOT NULL,
  `tipoUsuario` varchar(45) NOT NULL,
  `remember_token` varchar(300) DEFAULT NULL,
  `cliente` varchar(45) DEFAULT NULL,
  `empleado` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombreUsuario`, `password`, `tipoUsuario`, `remember_token`, `cliente`, `empleado`, `updated_at`, `created_at`) VALUES
(4, 'jordy21', '8b0d3092f43f5d341b63a6c31314444cbdc5d403a6096099497c63080e2eaa8c', 'admin', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOjQsIm5vbWJyZVVzdWFyaW8iOiJqb3JkeTIxIiwidGlwb1VzdWFyaW8iOiJhZG1pbiIsImNsaWVudGUiOiI1MDQ0NjAyMTUiLCJlbXBsZWFkbyI6bnVsbCwiaWF0IjoxNjg3NzM4MDQzLCJleHAiOjE2ODc3NDAwNDN9.l4HVwq-SKZcg0urk0B_5NQlWh0ocgYCPfrxrk2-gPTI', '504460215', NULL, '2023-06-26 00:07:23', '2023-06-25 05:25:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `numUnidad` int(11) NOT NULL,
  `placa` varchar(45) NOT NULL,
  `color` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `modelo` int(6) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`numUnidad`, `placa`, `color`, `tipo`, `modelo`, `updated_at`, `created_at`) VALUES
(6, 'M8080', 'Naranja', 'Moto', 2000, '2023-06-24 15:04:30', '2023-06-24 15:04:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cedula`) USING BTREE;

--
-- Indices de la tabla `detalleorden`
--
ALTER TABLE `detalleorden`
  ADD PRIMARY KEY (`idDetalleOrden`),
  ADD KEY `FK_DetalleOrden_Orden_idx` (`orden`),
  ADD KEY `FK_DetalleOrden_Producto_idx` (`producto`);

--
-- Indices de la tabla `direccioncliente`
--
ALTER TABLE `direccioncliente`
  ADD PRIMARY KEY (`idDireccionesCliente`),
  ADD KEY `FK_DireccionesCliente_Cliente_idx` (`cliente`) USING BTREE;

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idEmpleado`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`idEnvio`),
  ADD KEY `FK_Envio_Vehiculo` (`vehiculo`),
  ADD KEY `FK_ENVIO_EMPLEADO` (`chofer`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`idOrden`),
  ADD KEY `ID_ORDEN_CLIENTE` (`cliente`),
  ADD KEY `ID_ORDEN_EMPLEADO` (`empleado`),
  ADD KEY `ID_ORDEN_ENVIO` (`envio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `FK_Producto_Proveedor_idx` (`proveedor`),
  ADD KEY `FK_Producto_Categoria_idx` (`categoria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idProveedor`);

--
-- Indices de la tabla `telefonocliente`
--
ALTER TABLE `telefonocliente`
  ADD PRIMARY KEY (`idTelefonosCliente`),
  ADD KEY `FK_TelefonosCliente_Cliente` (`cliente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `FK_Usuario_Empleado` (`empleado`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`numUnidad`),
  ADD UNIQUE KEY `placa_UNIQUE` (`placa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalleorden`
--
ALTER TABLE `detalleorden`
  MODIFY `idDetalleOrden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `direccioncliente`
--
ALTER TABLE `direccioncliente`
  MODIFY `idDireccionesCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `idEnvio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `idOrden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3006;

--
-- AUTO_INCREMENT de la tabla `telefonocliente`
--
ALTER TABLE `telefonocliente`
  MODIFY `idTelefonosCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `numUnidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalleorden`
--
ALTER TABLE `detalleorden`
  ADD CONSTRAINT `FK_DetalleOrden_Orden` FOREIGN KEY (`orden`) REFERENCES `orden` (`idOrden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_DetalleOrden_Producto` FOREIGN KEY (`producto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direccioncliente`
--
ALTER TABLE `direccioncliente`
  ADD CONSTRAINT `FK_DireccionesCliente_Cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`cedula`);

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `FK_ENVIO_EMPLEADO` FOREIGN KEY (`chofer`) REFERENCES `empleado` (`idEmpleado`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `ID_ORDEN_ENVIO` FOREIGN KEY (`envio`) REFERENCES `envio` (`idEnvio`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_Producto_Categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Producto_Proveedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`idProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefonocliente`
--
ALTER TABLE `telefonocliente`
  ADD CONSTRAINT `FK_TelefonosCliente_Cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`cedula`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_Usuario_Empleado` FOREIGN KEY (`empleado`) REFERENCES `empleado` (`idEmpleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
