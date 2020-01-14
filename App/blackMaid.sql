-- --------------------------------------------------------
-- Host:                         localhost
-- Server versie:                5.7.27-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              10.3.0.5806
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Databasestructuur van black_maid wordt geschreven
CREATE DATABASE IF NOT EXISTS `black_maid` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `black_maid`;

-- Structuur van  tabel black_maid.cards wordt geschreven
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_category_id` int(11) NOT NULL,
  `card_type_id` int(11) NOT NULL,
  `card_penalty_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_cards_category_id` (`card_category_id`),
  KEY `cards_ibfk_2` (`card_type_id`),
  KEY `fk_cards_penalty_id` (`card_penalty_id`),
  CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`card_category_id`) REFERENCES `card_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cards_ibfk_2` FOREIGN KEY (`card_type_id`) REFERENCES `card_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cards_ibfk_3` FOREIGN KEY (`card_penalty_id`) REFERENCES `card_penalties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel black_maid.cards: ~32 rows (ongeveer)
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` (`id`, `card_category_id`, `card_type_id`, `card_penalty_id`) VALUES
	(1, 1, 1, 2),
	(2, 1, 2, 2),
	(3, 1, 3, 2),
	(4, 1, 4, 2),
	(5, 1, 5, 2),
	(6, 1, 6, 2),
	(7, 1, 7, 2),
	(8, 1, 8, 2),
	(9, 2, 1, 1),
	(10, 2, 2, 1),
	(11, 2, 3, 1),
	(12, 2, 4, 1),
	(13, 2, 5, 1),
	(14, 2, 6, 1),
	(15, 2, 7, 1),
	(16, 2, 8, 1),
	(17, 3, 1, 1),
	(18, 3, 2, 1),
	(19, 3, 3, 1),
	(20, 3, 4, 1),
	(21, 3, 5, 3),
	(22, 3, 6, 1),
	(23, 3, 7, 1),
	(24, 3, 8, 1),
	(25, 4, 1, 1),
	(26, 4, 2, 1),
	(27, 4, 3, 1),
	(28, 4, 4, 1),
	(29, 4, 5, 1),
	(30, 4, 6, 4),
	(31, 4, 7, 1),
	(32, 4, 8, 1);
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;

-- Structuur van  view black_maid.cards_view wordt geschreven
-- Tijdelijke tabel wordt aangemaakt zodat we geen VIEW afhankelijkheidsfouten krijgen
CREATE TABLE `cards_view` (
	`id` INT(11) NOT NULL,
	`category` VARCHAR(45) NOT NULL COLLATE 'utf8_general_ci',
	`type` VARCHAR(45) NOT NULL COLLATE 'utf8_general_ci',
	`value` INT(11) NOT NULL,
	`penalty_points` INT(11) NOT NULL
) ENGINE=MyISAM;

-- Structuur van  tabel black_maid.card_categories wordt geschreven
CREATE TABLE IF NOT EXISTS `card_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `kind_UNIQUE` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel black_maid.card_categories: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `card_categories` DISABLE KEYS */;
INSERT INTO `card_categories` (`id`, `category`) VALUES
	(3, 'clover'),
	(2, 'diamonds'),
	(1, 'hearts'),
	(4, 'spades');
/*!40000 ALTER TABLE `card_categories` ENABLE KEYS */;

-- Structuur van  tabel black_maid.card_penalties wordt geschreven
CREATE TABLE IF NOT EXISTS `card_penalties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel black_maid.card_penalties: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `card_penalties` DISABLE KEYS */;
INSERT INTO `card_penalties` (`id`, `value`) VALUES
	(1, 0),
	(2, 1),
	(3, 3),
	(4, 5);
/*!40000 ALTER TABLE `card_penalties` ENABLE KEYS */;

-- Structuur van  tabel black_maid.card_types wordt geschreven
CREATE TABLE IF NOT EXISTS `card_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `type_UNIQUE` (`type`),
  UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel black_maid.card_types: ~8 rows (ongeveer)
/*!40000 ALTER TABLE `card_types` DISABLE KEYS */;
INSERT INTO `card_types` (`id`, `type`, `value`) VALUES
	(1, 'Seven', 0),
	(2, 'Eight', 1),
	(3, 'Nine', 2),
	(4, 'Ten', 3),
	(5, 'Jack', 4),
	(6, 'Queen', 5),
	(7, 'King', 6),
	(8, 'Ace', 7);
/*!40000 ALTER TABLE `card_types` ENABLE KEYS */;

-- Structuur van  tabel black_maid.players wordt geschreven
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumpen data van tabel black_maid.players: ~4 rows (ongeveer)
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` (`id`, `name`) VALUES
	(1, 'Donald'),
	(2, 'Katrien'),
	(3, 'Willie'),
	(4, 'Mickey');
/*!40000 ALTER TABLE `players` ENABLE KEYS */;

-- Structuur van  view black_maid.cards_view wordt geschreven
-- Tijdelijke tabel wordt verwijderd, en definitieve VIEW wordt aangemaakt.
DROP TABLE IF EXISTS `cards_view`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `cards_view` AS select `c`.`id` AS `id`,`cg`.`category` AS `category`,`ct`.`type` AS `type`,`ct`.`value` AS `value`,`cp`.`value` AS `penalty_points` from (((`cards` `c` join `card_categories` `cg` on((`c`.`card_category_id` = `cg`.`id`))) join `card_types` `ct` on((`c`.`card_type_id` = `ct`.`id`))) join `card_penalties` `cp` on((`c`.`card_penalty_id` = `cp`.`id`)));

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
