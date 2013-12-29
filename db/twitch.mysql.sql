-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 29 dec 2013 om 09:05
-- Serverversie: 5.5.32-log
-- PHP-versie: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tabelstructuur voor tabel `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` varchar(36) NOT NULL,
  `broadcast_id` text NOT NULL,
  `video_id` text NOT NULL,
  `video_url` text NOT NULL,
  `status` text NOT NULL,
  `path` text NOT NULL,
  `size` text NOT NULL,
  `created` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ffmpegjobs`
--

CREATE TABLE IF NOT EXISTS `ffmpegjobs` (
  `id` varchar(36) NOT NULL,
  `type` text NOT NULL,
  `broadcast_id` text NOT NULL,
  `video_id` text NOT NULL,
  `status` text NOT NULL,
  `created` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
