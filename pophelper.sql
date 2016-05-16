-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 16, 2016 at 05:11 AM
-- Server version: 5.5.42-MariaDB-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `petrasil_pophelper`
--

-- --------------------------------------------------------

--
-- Table structure for table `auto`
--

CREATE TABLE IF NOT EXISTS `auto` (
  `ID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `vrsta` int(1) NOT NULL,
  `cep` int(1) NOT NULL COMMENT 'da li je napunjeno do čepa',
  `naziv` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `km` int(6) NOT NULL COMMENT 'trenutna kilometraža',
  `trosak` int(7) NOT NULL,
  `litara` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `crkve`
--

CREATE TABLE IF NOT EXISTS `crkve` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `crkva` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `crkva` (`crkva`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `imenik`
--

CREATE TABLE IF NOT EXISTS `imenik` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mesto` varchar(30) COLLATE utf8_slovenian_ci NOT NULL COMMENT 'Pohađa crkvu',
  `ime` varchar(50) COLLATE utf8_slovenian_ci NOT NULL COMMENT 'Naziv porodice',
  `serija` int(2) DEFAULT NULL,
  `pposeta` date DEFAULT NULL COMMENT 'Poslednja poseta',
  `status` int(1) NOT NULL DEFAULT '3' COMMENT 'Prijatelj / proučavamo teme / kršten',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `mesta`
--

CREATE TABLE IF NOT EXISTS `mesta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) COLLATE utf8_slovenian_ci NOT NULL COMMENT 'naziv mesta',
  `imegore` varchar(30) COLLATE utf8_slovenian_ci NOT NULL COMMENT 'obeležje mesta za gornji meni',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `posete`
--

CREATE TABLE IF NOT EXISTS `posete` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `osoba` int(5) NOT NULL COMMENT 'ID osobe',
  `datum` date NOT NULL COMMENT 'datum posete',
  `komentar` text COLLATE utf8_slovenian_ci COMMENT 'komentar',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `propovedanja`
--

CREATE TABLE IF NOT EXISTS `propovedanja` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `crkva` int(4) NOT NULL,
  `propoved` int(4) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `propovedi`
--

CREATE TABLE IF NOT EXISTS `propovedi` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `naziv` (`naziv`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `serije`
--

CREATE TABLE IF NOT EXISTS `serije` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serija` int(2) NOT NULL,
  `rbuseriji` int(2) NOT NULL,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `teme`
--

CREATE TABLE IF NOT EXISTS `teme` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `osoba` int(4) NOT NULL,
  `datum` date NOT NULL,
  `tema` int(2) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
