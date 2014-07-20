SELECT id, email, name
FROM availability A, tz_members M
WHERE M.id = A.idMember
AND A.lastDay > NOW( ) 
AND M.workWithWood = 1


-- phpMyAdmin SQL Dump
-- version 2.9.0
-- http://www.phpmyadmin.net
-- 
-- Servidor: hl114.dinaserver.com
-- Tiempo de generación: 05-11-2013 a las 23:23:58
-- Versión del servidor: 5.1.38
-- Versión de PHP: 5.2.11
-- 
-- Base de datos: `makeit`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `Assignments`
-- 

CREATE TABLE `Assignments` (
  `idMember` int(11) NOT NULL,
  `jobId` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idMember`,`jobId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Volcar la base de datos para la tabla `Assignments`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `availability`
-- 

CREATE TABLE `availability` (
  `idMember` int(11) NOT NULL,
  `initDay` date NOT NULL,
  `lastDay` date NOT NULL,
  PRIMARY KEY (`idMember`,`initDay`,`lastDay`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Volcar la base de datos para la tabla `availability`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `jobs`
-- 

CREATE TABLE `jobs` (
  `token` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `jobId` varchar(23) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathOfVideo` varchar(270) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deliveryAddress` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nameReceiver` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) NOT NULL,
  `material` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `numberofCopies` int(11) NOT NULL,
  `pathDeliveryReceipt` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Volcar la base de datos para la tabla `jobs`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tz_members`
-- 

CREATE TABLE `tz_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regIP` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fotoPath` varchar(270) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountPayPal` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workWith3D` tinyint(1) DEFAULT NULL,
  `workWithWood` tinyint(1) DEFAULT NULL,
  `workWithCeramics` tinyint(1) DEFAULT NULL,
  `workWithPicture` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usr` (`usr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `tz_members`
-- 

INSERT INTO `tz_members` (`id`, `usr`, `pass`, `email`, `regIP`, `dt`, `fotoPath`, `name`, `telephone`, `accountPayPal`, `workWith3D`, `workWithWood`, `workWithCeramics`, `workWithPicture`) VALUES 
(1, 'paramarco', '297881059455c64f62cc3096290906be', 'paramarco@gmail.com', '46.115.101.214', '2013-10-30 21:23:54', '', '', '', NULL, NULL, NULL, NULL, NULL),
(2, 'annebraun', '31824a68ab196cca4481c025def4176f', 'annebraun248@gmail.com', '217.194.71.146', '2013-11-01 22:13:01', '', '', '', NULL, NULL, NULL, NULL, NULL);
