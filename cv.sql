-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.6.17-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.13.0.7147
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla portfolio2.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.admin: ~1 rows (aproximadamente)
INSERT IGNORE INTO `admin` (`id`, `email`, `roles`, `password`) VALUES
	(1, 'carlosandreugasca@gmail.com', '["ROLE_ADMIN"]', '$2y$13$9TKipAax5Ah2J4DMVTdjsuEyf/YrNs653zSLBGfEiZv.pTqC9UhG2');

-- Volcando estructura para tabla portfolio2.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.doctrine_migration_versions: ~6 rows (aproximadamente)
INSERT IGNORE INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20260303135429', '2026-03-03 13:55:33', 65),
	('DoctrineMigrations\\Version20260304110517', '2026-03-04 11:05:50', 119),
	('DoctrineMigrations\\Version20260304220511', '2026-03-04 22:05:26', 127),
	('DoctrineMigrations\\Version20260305132258', '2026-03-05 13:23:26', 123),
	('DoctrineMigrations\\Version20260305143441', '2026-03-05 14:34:58', 24),
	('DoctrineMigrations\\Version20260308221313', '2026-03-08 22:13:24', 173);

-- Volcando estructura para tabla portfolio2.education
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  `current` tinyint(4) DEFAULT NULL,
  `school_name` varchar(200) DEFAULT NULL,
  `school_city` varchar(200) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.education: ~1 rows (aproximadamente)
INSERT IGNORE INTO `education` (`id`, `start_year`, `end_year`, `current`, `school_name`, `school_city`, `title`, `description`) VALUES
	(1, 2012, 2013, 0, 'OIOIO', 'OIOIO', 'www', 'EFWEWFEFEWFEW');

-- Volcando estructura para tabla portfolio2.experience
CREATE TABLE IF NOT EXISTS `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `current` tinyint(4) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `company_city` varchar(200) DEFAULT NULL,
  `position` varchar(200) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.experience: ~2 rows (aproximadamente)
INSERT IGNORE INTO `experience` (`id`, `start_date`, `end_date`, `current`, `company_name`, `company_city`, `position`, `description`) VALUES
	(1, '2024-03-01', NULL, 1, 'wewe', 'wewe', 'wew', '<p>wewew <strong><em><u>wwww </u></em></strong>33333</p>'),
	(2, '2024-01-01', NULL, 1, '444', '909090', '909090', '9090909');

-- Volcando estructura para tabla portfolio2.language
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.language: ~6 rows (aproximadamente)
INSERT IGNORE INTO `language` (`id`, `name`, `description`) VALUES
	(1, 'HTML5', NULL),
	(2, 'CSS', NULL),
	(3, 'JavaScript', NULL),
	(4, 'Python', NULL),
	(5, 'PHP (Symfony, Lavarel, Mustache)', NULL),
	(6, 'Node.js', NULL);

-- Volcando estructura para tabla portfolio2.project
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.project: ~9 rows (aproximadamente)
INSERT IGNORE INTO `project` (`id`, `title`, `slug`, `description`, `created_at`, `image`, `position`) VALUES
	(1, 'Bcnkitchen', 'bcnkitchen', '<p>qwwqw <strong>ewe </strong>ewer</p>', '2026-03-03 22:15:39', '69a75d8c12a01.png', 1),
	(2, 'Kweb', 'kweb', '<p><br></p>', '2026-03-06 23:15:36', NULL, 0),
	(3, 'Clínica de freitas', 'clinica-de-freitas', '<p><br></p>', '2026-03-06 23:30:04', NULL, 3),
	(4, 'Sergi Salvany', 'sergisalvany', '<p><br></p>', '2026-03-06 23:33:15', NULL, 5),
	(5, 'Palprox', 'palprox', '<p><br></p>', '2026-03-06 23:34:20', NULL, 2),
	(6, 'Kionhome.com', 'kionhome', '<p><br></p>', '2026-03-06 23:36:18', NULL, 6),
	(7, 'Salter', 'salter', '<p><br></p>', '2026-03-06 23:37:53', NULL, 7),
	(8, 'Mobbum', 'mobbum', '<p><br></p>', '2026-03-06 23:39:28', NULL, 8),
	(9, 'Centre comercial el Triangle', 'triangle', '<p><br></p>', '2026-03-06 23:52:16', NULL, 4);

-- Volcando estructura para tabla portfolio2.skill
CREATE TABLE IF NOT EXISTS `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla portfolio2.skill: ~3 rows (aproximadamente)
INSERT IGNORE INTO `skill` (`id`, `name`) VALUES
	(1, 'SEO/SEM Marketing'),
	(3, 'Web Development'),
	(7, 'Visual Studio Code');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
