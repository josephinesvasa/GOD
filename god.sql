-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 04 mars 2015 kl 15:14
-- Serverversion: 5.6.17
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `god`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `dep_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(50) NOT NULL,
  `active_dep` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `departments_users`
--

CREATE TABLE IF NOT EXISTS `departments_users` (
  `dep_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`dep_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `msg_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `room_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `messages_ibfk_1` (`room_id`),
  KEY `messages_ibfk_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `queries`
--

CREATE TABLE IF NOT EXISTS `queries` (
  `query_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `query` text NOT NULL,
  `q_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `compl` tinyint(1) NOT NULL DEFAULT '0',
  `dep_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`query_id`),
  KEY `dep_id` (`dep_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `replys`
--

CREATE TABLE IF NOT EXISTS `replys` (
  `reply_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reply` text NOT NULL,
  `r_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `query_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `query_id` (`query_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `rooms_users`
--

CREATE TABLE IF NOT EXISTS `rooms_users` (
  `room_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  KEY `rooms_users_ibfk_1` (`room_id`),
  KEY `rooms_users_ibfk_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empl_nr` int(10) unsigned NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL DEFAULT 'password',
  `f_name` varchar(50) NOT NULL,
  `l_name` int(50) NOT NULL,
  `title` varchar(20) NOT NULL,
  `profile_img` text NOT NULL,
  `status` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `dep_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `dep_id` (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `departments_users`
--
ALTER TABLE `departments_users`
  ADD CONSTRAINT `departments_users_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`),
  ADD CONSTRAINT `departments_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Restriktioner för tabell `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Restriktioner för tabell `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`),
  ADD CONSTRAINT `queries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Restriktioner för tabell `replys`
--
ALTER TABLE `replys`
  ADD CONSTRAINT `replys_ibfk_1` FOREIGN KEY (`query_id`) REFERENCES `queries` (`query_id`),
  ADD CONSTRAINT `replys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Restriktioner för tabell `rooms_users`
--
ALTER TABLE `rooms_users`
  ADD CONSTRAINT `rooms_users_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `rooms_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Restriktioner för tabell `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments` (`dep_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
