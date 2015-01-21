-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '-05:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Club`;
CREATE TABLE `Club` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `abbr` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ClubAttribute`;
CREATE TABLE `ClubAttribute` (
  `clubId` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `playersCount` int(11) NOT NULL,
  `tournamentsWin` int(11) NOT NULL,
  `weekPrestige` int(11) NOT NULL,
  `prestigeFund` int(11) NOT NULL,
  `clubChampionship` int(11) NOT NULL,
  `memo` varchar(255) NOT NULL,
  PRIMARY KEY (`clubId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `Member`;
CREATE TABLE `Member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `ip` varchar(25) CHARACTER SET latin2 COLLATE latin2_czech_cs DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `Player`;
CREATE TABLE `Player` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`name`),
  UNIQUE KEY `id_date` (`id`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;


DROP TABLE IF EXISTS `PlayerAttribute`;
CREATE TABLE `PlayerAttribute` (
  `date` datetime NOT NULL,
  `playerId` smallint(5) unsigned NOT NULL,
  `clubId` smallint(5) unsigned NOT NULL,
  `level` tinyint(3) NOT NULL,
  `prestige` mediumint(8) unsigned DEFAULT NULL,
  `achievement` smallint(5) NOT NULL,
  `wonMatch` mediumint(8) NOT NULL,
  `defeatedMatch` mediumint(8) NOT NULL,
  `wonMoney` int(11) NOT NULL,
  `lostMoney` int(11) NOT NULL,
  `task` smallint(5) NOT NULL,
  `strokeBasic` smallint(5) NOT NULL,
  `movementBasic` smallint(5) NOT NULL,
  `conditionBasic` smallint(5) NOT NULL,
  `strokeEquipment` smallint(5) NOT NULL,
  `movementEquipment` smallint(5) NOT NULL,
  `conditionEquipment` smallint(5) NOT NULL,
  `strokeAbility` smallint(5) NOT NULL,
  `conditionAbility` smallint(5) NOT NULL,
  `movementAbility` smallint(5) NOT NULL,
  `movementHinterland` smallint(5) NOT NULL,
  `strokeHinterland` smallint(5) NOT NULL,
  `conditionHinterland` smallint(5) NOT NULL,
  `clubMatch` smallint(5) NOT NULL,
  `tournament` smallint(5) NOT NULL,
  `title` smallint(5) NOT NULL,
  KEY `playerId` (`playerId`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2015-01-21 14:39:55