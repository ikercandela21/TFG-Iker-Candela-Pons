-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2025 a las 13:04:21
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
-- Base de datos: `tfg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `juego_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` mediumblob NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `nombre`, `descripcion`, `stock`, `imagen`, `precio`) VALUES
(2, 'Miecraft', 'Gran juego con ininita diversion', 6, 0x6d696e6563726166742e6a7067, 19.99),
(3, 'Fifa', 'Historico juego de futbol', 0, 0x666966612e6a706567, 8),
(7, 'Robots 2', 'Segundo juego de robots', 6, 0x726f626f7473322e6a706567, 2.99),
(11, 'GTA V', 'Gran juego', 6, 0x6774612e6a7067, 59.99),
(17, 'Gran Turismo', 'Juego de carreras que te dejara con la boca abierta', 9, 0x4772616e54757269736d6f2e6a706567, 21.99),
(18, 'Los Sims', 'Espectacular juego de simulación', 9, 0x73696d732e6a706567, 20),
(19, 'UFC', 'Juego de pelea', 9, 0x756663352d322e6a706567, 20),
(20, 'Mario Bros', 'Antiguo juego', 9, 0x6d6172696f2e6a706567, 19.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `juego_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `codigoJuego` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `juego_id`, `cantidad`, `fecha`, `codigoJuego`) VALUES
(25, 2, 11, 1, '2025-05-16', 'vlsQgzX9YjOn2a5MDGVy'),
(26, 2, 7, 1, '2025-05-16', 'Yf69wJxlDTjm4ZpkszFE'),
(27, 2, 3, 1, '2025-05-16', '8BvuiO7omNGJVCbdpWyw'),
(28, 2, 3, 1, '2025-05-16', 'b9cXom4Ry3NjGpAsdZBL'),
(29, 2, 2, 1, '2025-05-16', 'K2sYVUn4R6xEXuFrPtHL'),
(30, 2, 2, 1, '2025-05-16', 'u9qgIo4scl1yW7LKi2Vp'),
(31, 2, 19, 1, '2025-05-19', 'bhlxjAIgSkR6TNQdzeiL'),
(32, 2, 7, 1, '2025-05-19', 'F2Q19t5aHkCAurEoK7Y8'),
(33, 2, 7, 1, '2025-05-19', 'IAs25wljHOaGWdbTv9Y6'),
(34, 2, 2, 1, '2025-05-19', 'dFCVQcDhtopZ3Wy1Ywl5'),
(35, 2, 18, 1, '2025-05-19', 'vptXYg1iF970jNQ6dhWR'),
(36, 2, 3, 1, '2025-05-19', 'GOWKIx0zVJQcnP2E3dZe'),
(37, 2, 3, 1, '2025-05-19', 'qfTgQwSktBvNFxnz824o'),
(38, 2, 3, 1, '2025-05-19', 'fPYOT7sdFeKzZXhU5Stm'),
(39, 2, 3, 1, '2025-05-19', 'MToE3Qu1iJNjnL8DZGOW'),
(40, 2, 3, 1, '2025-05-19', 'e8YDl7ZXJ90yxcMaKTQ3'),
(41, 2, 3, 1, '2025-05-19', 'jGCKg2VdlwFaeu0J7pxQ'),
(42, 2, 3, 1, '2025-05-21', 'XBfne6wxGF41d3W9usYZ'),
(43, 2, 20, 1, '2025-05-22', 'uzGwomf7O4qvDnNA0CFg'),
(44, 2, 7, 1, '2025-05-22', 'wxJhHjtLnErWgqYQUcPF'),
(45, 7, 3, 1, '2025-05-22', 'ChWJp5GzRS4BHFZm1Xrq'),
(46, 7, 7, 1, '2025-05-22', 'r0PEjL3kNvTxltD7hyGn'),
(47, 7, 11, 1, '2025-05-22', 'Yf7rKbXQIuA9yCSF2Mhj'),
(48, 2, 2, 1, '2025-05-22', 'LVFAHdBwD91Xy5E8ksvh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `email`, `contraseña`, `tipo`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', 'admin', 'admin'),
(2, 'Iker', 'Iker811', 'iker@gmail.com', 'iker', 'cliente'),
(3, 'Nuria', 'Nuria222', 'nuria@gmail.com', 'Nuri', 'admin'),
(7, 'Pepe', 'pepe', 'pepe@gmail.com', 'pepe', 'cliente'),
(8, 'Paco', 'paco1', 'paco@gmail.com', 'paco', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `juego_id` (`juego_id`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `juego_id` (`juego_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`juego_id`) REFERENCES `juegos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`juego_id`) REFERENCES `juegos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
