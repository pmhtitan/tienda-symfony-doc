-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-01-2022 a las 19:38:26
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_symfony_doc`
--
CREATE DATABASE IF NOT EXISTS `tienda_symfony_doc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tienda_symfony_doc`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

DROP TABLE IF EXISTS `carrito`;
CREATE TABLE IF NOT EXISTS `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_77E6BED5DB38439E` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `usuario_id`, `subtotal`, `created_at`, `updated_at`) VALUES
(5, 2, 0, '2020-08-25 19:59:57', '2020-08-25 19:59:57'),
(6, 6, 0, '2020-08-29 17:44:11', '2020-08-29 17:44:11'),
(7, 1, 133.48, '2020-10-29 17:27:27', '2020-10-29 17:27:27'),
(8, 11, 67.98, '2020-11-08 19:49:13', '2020-11-08 19:49:13'),
(9, 12, 300, '2020-12-16 10:39:27', '2020-12-16 10:39:27'),
(10, 3, 0, '2021-03-02 16:12:29', '2021-03-02 16:12:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'zapatos', '2020-07-26 18:05:17', '2020-07-26 18:05:17'),
(2, 'zapatillas', '2020-07-26 18:07:59', '2020-07-26 18:07:59'),
(3, 'Sudaderas', '2020-07-28 00:02:25', '2020-07-28 00:02:25'),
(4, 'Abrigos', '2020-07-28 00:02:41', '2020-07-28 00:02:41'),
(5, 'pantalones', '2020-08-18 11:59:40', '2020-08-18 11:59:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_facturacion`
--

DROP TABLE IF EXISTS `datos_facturacion`;
CREATE TABLE IF NOT EXISTS `datos_facturacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` int(11) NOT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_postal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F03143BDDB38439E` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datos_facturacion`
--

INSERT INTO `datos_facturacion` (`id`, `usuario_id`, `nombre`, `email`, `telefono`, `provincia`, `localidad`, `direccion`, `codigo_postal`) VALUES
(1, 1, 'Testerus', 'testing@test.com', 685985188, 'Valladolid', 'Valladolid', 'C/ Alcalá Nº123', 47320),
(5, 2, 'Alan', 'Alanmoore@gmail.com', 65532423, 'Valladolid', 'Tudela de Duero', 'C/Carraportillo Nº12', 47320),
(6, 3, 'Jeremy de la Praba', 'prabom@hotmail.com', 685655443, 'Madrid', 'Torremolinos', 'Calle Bartolomé Piso 2 Este 43', 35456),
(8, 5, 'Paula', 'NoTeLoCreesNiTu@hotmail.com', 654654654, 'Madrid', 'Alcobendas', 'C/ de las alcobendas M-40', 28100),
(9, 7, 'Dalamir', 'HolgenDalamir@dalan.com', 656545567, 'Dalamas', 'Danhur', 'C / Danubis 599', 78654),
(10, 8, 'Guadan', 'Elhur@ames.com', 65432234, 'Ahir', 'Durme', 'C / Salvi 2', 65433),
(11, 9, 'Mimi', 'mimir@mimi.com', 565456543, 'Mimiri', 'Mirri', 'C/Mir', 78654),
(12, 6, 'Wacamole S.L', 'wacam@adresss-xl.com', 98352422, 'Walawichh', 'Mendrag', 'C/ Azapick 5455', 30946),
(13, 10, 'Pepe', 'HolgenDalamir@dalan.com', 32, 'Mimiri', 'Durme', 'C/Mir', -21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200724170703', '2020-07-24 17:07:45', 40),
('DoctrineMigrations\\Version20200726105556', '2020-07-26 10:57:32', 575),
('DoctrineMigrations\\Version20200726120135', '2020-07-26 12:02:43', 322),
('DoctrineMigrations\\Version20200817160102', '2020-08-17 16:02:14', 347),
('DoctrineMigrations\\Version20200819144707', '2020-08-19 14:48:06', 643),
('DoctrineMigrations\\Version20200819150237', '2020-08-19 15:04:04', 101),
('DoctrineMigrations\\Version20200823183858', '2020-08-23 18:40:49', 1819);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_carrito`
--

DROP TABLE IF EXISTS `lineas_carrito`;
CREATE TABLE IF NOT EXISTS `lineas_carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carrito_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `precio` double NOT NULL,
  `unidades` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F922286DE2CF6E7` (`carrito_id`),
  KEY `IDX_8F9222867645698E` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lineas_carrito`
--

INSERT INTO `lineas_carrito` (`id`, `carrito_id`, `producto_id`, `precio`, `unidades`) VALUES
(28, 7, 17, 36.33, 3),
(29, 7, 18, 24.49, 1),
(30, 8, 21, 33.99, 2),
(31, 9, 5, 50, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

DROP TABLE IF EXISTS `lineas_pedidos`;
CREATE TABLE IF NOT EXISTS `lineas_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `unidades` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9F6250F94854653A` (`pedido_id`),
  KEY `IDX_9F6250F97645698E` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lineas_pedidos`
--

INSERT INTO `lineas_pedidos` (`id`, `pedido_id`, `producto_id`, `unidades`, `created_at`, `updated_at`) VALUES
(3, 4, 3, 3, '2020-08-17 16:03:49', '2020-08-17 16:03:49'),
(4, 4, 5, 1, '2020-08-17 16:03:49', '2020-08-17 16:03:49'),
(5, 5, 11, 1, '2020-08-18 12:43:26', '2020-08-18 12:43:26'),
(6, 5, 8, 1, '2020-08-18 12:43:26', '2020-08-18 12:43:26'),
(7, 5, 3, 2, '2020-08-18 12:43:26', '2020-08-18 12:43:26'),
(10, 7, 9, 4, '2020-08-19 15:45:29', '2020-08-19 15:45:29'),
(11, 7, 8, 4, '2020-08-19 15:45:29', '2020-08-19 15:45:29'),
(12, 8, 11, 3, '2020-08-27 17:33:04', '2020-08-27 17:33:04'),
(13, 8, 7, 3, '2020-08-27 17:33:04', '2020-08-27 17:33:04'),
(18, 11, 3, 4, '2020-08-29 16:59:59', '2020-08-29 16:59:59'),
(19, 11, 5, 4, '2020-08-29 16:59:59', '2020-08-29 16:59:59'),
(20, 12, 9, 4, '2020-08-29 17:41:21', '2020-08-29 17:41:21'),
(21, 12, 4, 9, '2020-08-29 17:41:21', '2020-08-29 17:41:21'),
(22, 13, 11, 1, '2020-08-29 17:45:51', '2020-08-29 17:45:51'),
(23, 13, 8, 2, '2020-08-29 17:45:51', '2020-08-29 17:45:51'),
(24, 13, 9, 1, '2020-08-29 17:45:51', '2020-08-29 17:45:51'),
(25, 13, 7, 1, '2020-08-29 17:45:51', '2020-08-29 17:45:51'),
(26, 13, 6, 2, '2020-08-29 17:45:51', '2020-08-29 17:45:51'),
(27, 14, 18, 12, '2020-09-09 14:08:30', '2020-09-09 14:08:30'),
(28, 15, 11, 1, '2020-12-30 20:28:21', '2020-12-30 20:28:21'),
(29, 16, 10, 2, '2021-03-02 16:09:36', '2021-03-02 16:09:36'),
(30, 16, 21, 2, '2021-03-02 16:09:36', '2021-03-02 16:09:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `coste` double NOT NULL,
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C4EC16CEDB38439E` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `usuario_id`, `coste`, `estado`, `created_at`, `updated_at`) VALUES
(4, NULL, 194.75, 'pendiente', '2020-08-17 16:03:49', '2020-08-17 16:03:49'),
(5, NULL, 175.75, 'pendiente', '2020-08-18 12:43:26', '2020-08-18 12:43:26'),
(7, 5, 278.75, 'pendiente', '2020-08-19 15:45:29', '2020-08-19 15:45:29'),
(8, 7, 216.75, 'pendiente', '2020-08-27 17:33:04', '2020-08-27 17:33:04'),
(11, 9, 390.75, 'pendiente', '2020-08-29 16:59:59', '2020-08-29 16:59:59'),
(12, 2, 384.75, 'pendiente', '2020-08-29 17:41:21', '2020-08-29 17:41:21'),
(13, 6, 326.75, 'pendiente', '2020-08-29 17:45:51', '2020-08-29 17:45:51'),
(14, 10, 300.63, 'pendiente', '2020-09-09 14:08:30', '2020-09-09 14:08:30'),
(15, 2, 51.75, 'pendiente', '2020-12-30 20:28:21', '2020-12-30 20:28:21'),
(16, 6, 186.73, 'pendiente', '2021-03-02 16:09:36', '2021-03-02 16:09:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` double NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A7BB06153397707A` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `created_at`, `updated_at`) VALUES
(3, 2, 'Running Fasto V-2', 'Aseguran el mejor confort y la rapidez de un león.', 46.5, 24, 'zapatillas-running-5f1f727840819.jpeg', '2020-07-28 00:34:00', '2020-11-04 14:08:12'),
(4, 3, 'Sevilla FC Deport G', 'Vistete con los colores de tu equipo. Disponible en rojo y azul.', 26, 50, 'sudadera-sevillaFC-5f231b7d56984.jpeg', '2020-07-28 00:45:32', '2020-07-30 19:12:07'),
(5, 4, 'AT-2 Sport', 'La nueva gama Sport de Kelme ya está aquí!', 50, 10, 'abrigo-kelme-5f1f755f9de5e.png', '2020-07-28 00:46:23', '2020-07-28 00:46:23'),
(6, 2, 'Zapas Thunderbolt', '¿Harto de la moda? Prueba algo fresco!', 75, 6, 'zapatillas-running2-5f1f757f9d16e.jpeg', '2020-07-28 00:46:55', '2020-07-28 00:46:55'),
(7, 5, 'Sport-way Freestyle', 'Nueva colección de panatalones deportivos, consulte en tienda para saber disponibilidad.', 25, 200, 'Sport-Patantalon-Agosto-5f3bc6cf7582c.jpeg', '2020-08-18 12:17:19', '2020-08-18 12:17:19'),
(8, 5, 'Street Sport [Black Edition]', 'Llega el otoño, y la calle puede ser tuya con esta colección, de black edition style.', 32, 50, 'stress-sport-pantalon-black-5f3bc73feef2c.jpeg', '2020-08-18 12:19:11', '2020-08-18 12:19:11'),
(9, 3, 'Navy Blue Hoodie', 'Sudadera Navy Blue', 36, 20, 'navy-blue-sudadera-5f3bc791e77c3.jpeg', '2020-08-18 12:20:33', '2020-08-18 12:20:33'),
(10, 1, 'Adidas StreetStyle F2', 'Colección F2 de las Zapatillas de Calle Adidas', 56, 100, 'zapatilla-calle-adidas-5f3bc7da5fee0.jpeg', '2020-08-18 12:21:46', '2020-08-18 12:21:46'),
(11, 3, 'Anime One Piece Hoodie XL [Limited Edition]', 'Zoro Edition Wano One Piece Hoodie M-L-XL. Unidades limitadas, fast time offer', 45, 10, 'sudadera-zorro-5f3bc87b957ea.jpeg', '2020-08-18 12:24:27', '2020-08-18 12:26:50'),
(12, 3, 'Free Fire', 'Free Fire Collection Hoodie', 30, 10, 'freeFire-5f53844def37b.jpeg', '2020-09-05 12:27:57', '2020-09-05 12:27:57'),
(13, 3, 'Pink H', 'Hoodie Pink H S', 20, 15, 'Adu-Pink-Over-Hoodie-1-5fc6714fa7bbc.jpeg', '2020-09-05 12:28:27', '2020-12-01 16:37:35'),
(14, 3, 'Free Gaza LS', 'Collection of Free Gaza LS Plus', 55, 40, 's-l300-5f53848eedc94.jpeg', '2020-09-05 12:29:02', '2020-09-05 12:29:02'),
(15, 3, 'Sudadera de los Lakers 23', 'Sudadera de los Lakers 23', 27, 22, 'sudadera-lebron-james-lakers-hoodie-5f5384b74783e.jpeg', '2020-09-05 12:29:43', '2020-09-05 12:29:43'),
(16, 3, 'Wolf Thunder SS', 'The newest addition to Wolf TSS Mark', 44.99, 34, 'northern-lights-hoodie-5f5389f63f576.jpeg', '2020-09-05 12:52:06', '2020-09-05 13:08:02'),
(17, 3, 'Nike Optic Gala', 'Hoodie Nike Optic', 36.33, 10, 'nike-optic-5f538dfcd0d18.png', '2020-09-05 13:09:16', '2020-09-05 13:09:16'),
(18, 3, 'Goods Merchant', 'Style Collection November goods in a shell', 24.49, 15, 'goods-08-172278-5f538e3f2a6f5.jpeg', '2020-09-05 13:10:23', '2020-09-05 13:10:23'),
(19, 3, 'Nike Black', 'Black Edition of Nike Optic. Color picked', 34.99, 12, 'nike-sportswear-club-hoodie-regular-5f538e7dba414.jpeg', '2020-09-05 13:11:25', '2020-09-05 13:11:25'),
(20, 3, 'Anti Rain Suit Hoodie Decoloth Collection', 'Decoloth Collection brigs today this hoodie!', 45.99, 28, 'E1512-ORLC-S-5f538ecf2547e.jpeg', '2020-09-05 13:12:23', '2020-09-05 13:12:47'),
(21, 3, 'Queen Hodie dororthy', 'Dorothy approves this new hoodie bringed from US', 33.99, 70, 'bsi-quee211-5f538f2f6ee58.jpeg', '2020-09-05 13:14:23', '2020-09-05 13:14:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_user` tinyint(1) NOT NULL COMMENT '1=True | 0=False',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `created_at`, `updated_at`, `remember_token`, `session_user`) VALUES
(1, 'tester@tester.com', '{\"roles\": \"ROLE_USER\"}', '$argon2id$v=19$m=65536,t=4,p=1$d0YucFgzakJ4VVA1WmhNYw$CvsaP3xKFYTNY0iRLPfPYR3ZDDJR8HY6vVmtxRmBKBI', NULL, '2020-07-24 18:27:30', '2020-07-24 18:27:30', NULL, 0),
(2, 'asd@asd.com', '{\"roles\": \"ROLE_USER\"}', '$argon2id$v=19$m=65536,t=4,p=1$LmRZUDFYU1FDT3NJZXF0Sw$R6KikGwPldTwcLGf5Z4BI4lMDMv192iLCS8qad5RjEo', NULL, '2020-07-25 20:07:31', '2020-07-25 20:07:31', NULL, 0),
(3, 'admin@admin.com', '{\"roles\": \"ROLE_ADMIN\"}', '$argon2id$v=19$m=65536,t=4,p=1$ZjczYXEzalNhZklkTEdTag$6WyCTcPp94bgi9IW9sULZssybi8J7Uwqiv4LYcI/EJU', NULL, '2020-07-26 19:06:46', '2020-07-26 19:06:46', NULL, 0),
(5, NULL, '[]', NULL, 'Paula', '2020-08-19 15:45:29', '2020-08-19 15:45:29', NULL, 1),
(6, 'wacamole@gmail.com', '{\"roles\": \"ROLE_USER\"}', '$argon2id$v=19$m=65536,t=4,p=1$aDdCNmswc0pyQkFST1B6WA$JibH4lfoVfWNfk7pUTZxMElWVIOn/XR570VczXT8Jj8', NULL, '2020-08-24 18:13:35', '2020-08-24 18:13:35', NULL, 0),
(7, NULL, '[]', NULL, 'Dalamir', '2020-08-27 17:33:04', '2020-08-27 17:33:04', NULL, 1),
(8, NULL, '[]', NULL, 'Guadan', '2020-08-27 17:39:38', '2020-08-27 17:39:38', NULL, 1),
(9, NULL, '[]', NULL, 'Mimi', '2020-08-29 16:59:59', '2020-08-29 16:59:59', NULL, 1),
(10, NULL, '[]', NULL, 'Pepe', '2020-09-09 14:08:30', '2020-09-09 14:08:30', NULL, 1),
(11, 'diego@gmail.com', '{\"roles\": \"ROLE_USER\"}', '$argon2id$v=19$m=65536,t=4,p=1$U2k5Vk9DQlRSY0RySUlYRQ$IqV5ewFvj0nGceIrek0jyfrIUFnfwSknJdNV6L9FBe8', NULL, '2020-11-08 19:48:59', '2020-11-08 19:48:59', NULL, 0),
(12, 'bolt@gmail.com', '{\"roles\": \"ROLE_USER\"}', '$argon2id$v=19$m=65536,t=4,p=1$Wm45aTAvN2pVckdRN05IVw$6tFI2UmMXEtdBOre5PcaOIjPdnP/nOhjjPM55bA261M', NULL, '2020-12-16 10:18:26', '2020-12-16 10:18:26', NULL, 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `FK_77E6BED5DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `datos_facturacion`
--
ALTER TABLE `datos_facturacion`
  ADD CONSTRAINT `FK_F03143BDDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `lineas_carrito`
--
ALTER TABLE `lineas_carrito`
  ADD CONSTRAINT `FK_8F9222867645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_8F922286DE2CF6E7` FOREIGN KEY (`carrito_id`) REFERENCES `carrito` (`id`);

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `FK_9F6250F94854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`),
  ADD CONSTRAINT `FK_9F6250F97645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_C4EC16CEDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_A7BB06153397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
