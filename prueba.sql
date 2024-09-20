-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2024 a las 16:44:48
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
-- Base de datos: `prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departments`
--

INSERT INTO `departments` (`id`, `nombre`) VALUES
(1, 'Recursos Humanos'),
(2, 'Desarrollo'),
(3, 'Ventas'),
(4, 'Marketing'),
(5, 'Finanzas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `puesto` varchar(50) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `nombre`, `email`, `puesto`, `salario`, `fecha_contratacion`, `departamento_id`, `rol_id`) VALUES
(1, 'Miguel Rodríguez', 'miguel.rodriguez@example.com', 'Gerente de Finanzas', 4800.00, '2018-02-11', 5, 1),
(2, 'Elena Sánchez', 'elena.sanchez@example.com', 'Desarrolladora Junior', 2900.00, '2021-06-05', 2, 2),
(3, 'David Ruiz', 'david.ruiz@example.com', 'Soporte Técnico', 2600.00, '2022-03-17', 2, 5),
(4, 'Rosa Díaz', 'rosa.diaz@example.com', 'Vendedora', 3100.00, '2020-07-23', 3, 4),
(5, 'Fernando García', 'fernando.garcia@example.com', 'Analista de Marketing', 3400.00, '2019-12-01', 4, 3),
(6, 'Patricia Jiménez', 'patricia.jimenez@example.com', 'Gerente de Desarrollo', 5100.00, '2018-09-10', 2, 1),
(7, 'Jorge Herrera', 'jorge.herrera@example.com', 'Desarrollador Senior', 4200.00, '2020-11-11', 2, 2),
(8, 'Susana Romero', 'susana.romero@example.com', 'Vendedora', 3000.00, '2021-08-14', 3, 4),
(9, 'Raúl Castillo', 'raul.castillo@example.com', 'Analista de Finanzas', 3600.00, '2020-02-18', 5, 3),
(10, 'Alicia Moreno', 'alicia.moreno@example.com', 'Desarrolladora Junior', 2800.00, '2021-10-06', 2, 2),
(11, 'Daniel Pérez', 'daniel.perez@example.com', 'Soporte Técnico', 2700.00, '2021-12-20', 2, 5),
(12, 'Irene Gómez', 'irene.gomez@example.com', 'Vendedora', 3300.00, '2019-06-25', 3, 4),
(13, 'Marcos Reyes', 'marcos.reyes@example.com', 'Gerente de Ventas', 4700.00, '2018-04-03', 3, 1),
(14, 'Claudia Vargas', 'claudia.vargas@example.com', 'Analista de Recursos Humanos', 3500.00, '2019-05-29', 1, 3),
(15, 'Pedro Martínez', 'pedro.martinez@example.com', 'Desarrollador Senior', 4100.00, '2020-09-21', 2, 2),
(16, 'Carmen Silva', 'carmen.silva@example.com', 'Gerente de Recursos Humanos', 5200.00, '2018-01-17', 1, 1),
(17, 'Alberto Fernández', 'alberto.fernandez@example.com', 'Analista de Desarrollo', 3700.00, '2020-03-08', 2, 3),
(18, 'Julia Ortega', 'julia.ortega@example.com', 'Vendedora', 3250.00, '2019-08-19', 3, 4),
(19, 'Sergio Castro', 'sergio.castro@example.com', 'Soporte Técnico', 2550.00, '2021-11-04', 2, 5),
(20, 'Marta López', 'marta.lopez@example.com', 'Analista de Marketing', 3450.00, '2020-05-30', 4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Gerente'),
(2, 'Desarrollador'),
(3, 'Analista'),
(4, 'Vendedor'),
(5, 'Soporte');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_departamento` (`departamento_id`),
  ADD KEY `fk_rol` (`rol_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
