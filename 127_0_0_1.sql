-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2024 a las 05:35:06
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `campus_gym`
--
CREATE DATABASE IF NOT EXISTS `campus_gym` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `campus_gym`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `Cedula` int(10) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `Apellido` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha_ingreso` date DEFAULT NULL,
  `Celular` bigint(10) NOT NULL,
  `Codigo_rh` int(1) NOT NULL,
  `Enfermedad` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo_plan` int(4) NOT NULL,
  `Codigo_estado` int(1) NOT NULL,
  `Edad` int(10) NOT NULL,
  `Peso` int(10) NOT NULL,
  `Celular_emergencia` bigint(10) NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `Codigo_estado` int(1) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`Codigo_estado`, `Estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_gym`
--

CREATE TABLE `planes_gym` (
  `Codigo_plan` int(4) NOT NULL,
  `Nombre_plan` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Valor` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `planes_gym`
--

INSERT INTO `planes_gym` (`Codigo_plan`, `Nombre_plan`, `Descripcion`, `Valor`) VALUES
(1998, 'Plan Zeus', 'Entrena como el gran dios Zeus.....', 30000),
(2376, 'Plan Artemis', 'Entrena como el dios Artremis...', 15000),
(4554, 'Plan Kratos', 'Entrena con las furias de los dioses...', 60000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_sangre`
--

CREATE TABLE `tipo_sangre` (
  `Codigo_rh` int(1) NOT NULL,
  `Grupo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_sangre`
--

INSERT INTO `tipo_sangre` (`Codigo_rh`, `Grupo`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `Codigo_usuario` int(1) NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`Codigo_usuario`, `Usuario`) VALUES
(1, 'Admin'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Codigo_usuario` int(1) NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `Contraseña` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Codigo_usuario`, `Usuario`, `Contraseña`) VALUES
(1, 'admin', 'admin123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Cedula`),
  ADD UNIQUE KEY `Codigo_rh` (`Codigo_rh`,`Codigo_plan`,`Codigo_estado`),
  ADD KEY `Codigo_rh_2` (`Codigo_rh`,`Codigo_plan`,`Codigo_estado`),
  ADD KEY `Codigo_plan` (`Codigo_plan`),
  ADD KEY `Codigo_estado` (`Codigo_estado`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`Codigo_estado`);

--
-- Indices de la tabla `planes_gym`
--
ALTER TABLE `planes_gym`
  ADD PRIMARY KEY (`Codigo_plan`);

--
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_sangre`
--
ALTER TABLE `tipo_sangre`
  ADD PRIMARY KEY (`Codigo_rh`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`Codigo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD KEY `Codigo_usuario` (`Codigo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`Codigo_plan`) REFERENCES `planes_gym` (`Codigo_plan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`Codigo_rh`) REFERENCES `tipo_sangre` (`Codigo_rh`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cliente_ibfk_3` FOREIGN KEY (`Codigo_estado`) REFERENCES `estado` (`Codigo_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`Codigo_usuario`) REFERENCES `tipo_usuario` (`Codigo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
