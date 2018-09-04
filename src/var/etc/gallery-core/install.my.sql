-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.1.26-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportiere Struktur von Tabelle abfall-rohstoffe.gallery_core_gallery
CREATE TABLE IF NOT EXISTS `gallery_core_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `default_gallery_image_id` int(10) unsigned DEFAULT NULL,
  `order_index` int(10) unsigned DEFAULT NULL,
  `online` tinyint(3) unsigned DEFAULT NULL,
  `last_mod_date` datetime DEFAULT NULL,
  `last_mod_by` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `gallery_group_id` int(10) unsigned DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_mod` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_index_1` (`default_gallery_image_id`),
  KEY `gallery_core_gallery_index_2` (`gallery_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle abfall-rohstoffe.gallery_core_gallery_group
CREATE TABLE IF NOT EXISTS `gallery_core_gallery_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `online` tinyint(3) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle abfall-rohstoffe.gallery_core_gallery_group_t
CREATE TABLE IF NOT EXISTS `gallery_core_gallery_group_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `path_part` varchar(255) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `file_title_image` varchar(255) DEFAULT NULL,
  `gallery_group_id` int(10) unsigned DEFAULT NULL,
  `n2n_locale` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_group_t_index_1` (`gallery_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle abfall-rohstoffe.gallery_core_gallery_image
CREATE TABLE IF NOT EXISTS `gallery_core_gallery_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_image` varchar(255) DEFAULT NULL,
  `gallery_id` int(10) unsigned DEFAULT NULL,
  `order_index` int(10) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `last_mod_date` datetime DEFAULT NULL,
  `last_mod_by` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `last_mod` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_image_index_1` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle abfall-rohstoffe.gallery_core_gallery_image_t
CREATE TABLE IF NOT EXISTS `gallery_core_gallery_image_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `alt_tag` varchar(255) DEFAULT NULL,
  `description` text,
  `tags` varchar(255) DEFAULT NULL,
  `gallery_image_id` int(10) unsigned DEFAULT NULL,
  `n2n_locale` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_image_t_index_1` (`gallery_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle abfall-rohstoffe.gallery_core_gallery_t
CREATE TABLE IF NOT EXISTS `gallery_core_gallery_t` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path_part` varchar(255) DEFAULT NULL,
  `file_title_image` varchar(255) DEFAULT NULL,
  `description` text,
  `gallery_id` int(10) unsigned DEFAULT NULL,
  `n2n_locale` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_core_gallery_t_index_1` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
