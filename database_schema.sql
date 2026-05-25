-- phpMyAdmin SQL Dump
-- Host: localhost
-- Generation Time: May 25, 2026
-- Server version: 10.4.32-MariaDB (or similar)
-- PHP Version: 8.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c2_agroplan_cz`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `auto_logout_minutes` int(11) DEFAULT 30,
  `two_factor_secret` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Data pro tabulku `admin_users`
-- (Výchozí heslo je: admin123)
--

INSERT INTO `admin_users` (`id`, `email`, `password`, `first_name`, `last_name`, `phone`, `auto_logout_minutes`, `two_factor_secret`) VALUES
(1, 'admin@agroplan.cz', '$2y$10$w/Xl0Y01Y.lHovWJ/vO9L.q5M6O9X.iXJ1zG1x0z2y4w9X0y5z6Q.', 'Hlavní', 'Admin', '+420 123 456 789', 30, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `fk_admin_logs_user` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `visitor_sessions`
--

CREATE TABLE `visitor_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `resolution` varchar(20) DEFAULT NULL,
  `is_bot` tinyint(1) DEFAULT 0,
  `is_new_visitor` tinyint(1) DEFAULT 1,
  `total_time_spent` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `page_visits`
--

CREATE TABLE `page_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `max_scroll_percent` int(11) DEFAULT 0,
  `time_spent_seconds` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `fk_page_visits_session` FOREIGN KEY (`session_id`) REFERENCES `visitor_sessions` (`session_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
