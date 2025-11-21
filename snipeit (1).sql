-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 21, 2024 at 02:03 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snipeit`
--
CREATE DATABASE IF NOT EXISTS `snipeit` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `snipeit`;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_accessories`
--

DROP TABLE IF EXISTS `stzl_accessories`;
CREATE TABLE IF NOT EXISTS `stzl_accessories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `requestable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int UNSIGNED DEFAULT NULL,
  `min_amt` int DEFAULT NULL,
  `manufacturer_id` int DEFAULT NULL,
  `model_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `accessories_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_accessories_users`
--

DROP TABLE IF EXISTS `stzl_accessories_users`;
CREATE TABLE IF NOT EXISTS `stzl_accessories_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `accessory_id` int DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_action_logs`
--

DROP TABLE IF EXISTS `stzl_action_logs`;
CREATE TABLE IF NOT EXISTS `stzl_action_logs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` int DEFAULT NULL,
  `target_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `filename` text COLLATE utf8mb4_unicode_ci,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int NOT NULL,
  `expected_checkin` date DEFAULT NULL,
  `accepted_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `thread_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `accept_signature` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_meta` text COLLATE utf8mb4_unicode_ci,
  `action_date` datetime DEFAULT NULL,
  `stored_eula` text COLLATE utf8mb4_unicode_ci,
  `action_source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_logs_thread_id_index` (`thread_id`),
  KEY `action_logs_created_at_index` (`created_at`),
  KEY `action_logs_item_type_item_id_action_type_index` (`item_type`,`item_id`,`action_type`),
  KEY `action_logs_target_type_target_id_action_type_index` (`target_type`,`target_id`,`action_type`),
  KEY `action_logs_target_type_target_id_index` (`target_type`,`target_id`),
  KEY `action_logs_company_id_index` (`company_id`),
  KEY `action_logs_action_type_index` (`action_type`),
  KEY `action_logs_remote_ip_index` (`remote_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_action_logs`
--

INSERT INTO `stzl_action_logs` (`id`, `user_id`, `action_type`, `target_id`, `target_type`, `location_id`, `note`, `filename`, `item_type`, `item_id`, `expected_checkin`, `accepted_id`, `created_at`, `updated_at`, `deleted_at`, `thread_id`, `company_id`, `accept_signature`, `log_meta`, `action_date`, `stored_eula`, `action_source`, `remote_ip`, `user_agent`) VALUES
(1, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-02-27 18:07:58', '2024-02-27 18:07:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(2, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 2, NULL, NULL, '2024-02-27 19:08:53', '2024-02-27 19:08:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(3, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 3, NULL, NULL, '2024-02-27 19:09:47', '2024-02-27 19:09:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(4, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 4, NULL, NULL, '2024-02-27 19:11:44', '2024-02-27 19:11:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(5, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2024-02-27 19:13:03', '2024-02-27 19:13:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(6, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 6, NULL, NULL, '2024-02-27 19:13:53', '2024-02-27 19:13:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(7, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 7, NULL, NULL, '2024-02-27 19:14:47', '2024-02-27 19:14:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(8, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 8, NULL, NULL, '2024-02-27 19:16:33', '2024-02-27 19:16:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(9, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 9, NULL, NULL, '2024-02-27 19:22:17', '2024-02-27 19:22:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(10, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 10, NULL, NULL, '2024-02-27 19:22:59', '2024-02-27 19:22:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(11, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 11, NULL, NULL, '2024-02-27 19:24:08', '2024-02-27 19:24:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(12, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 12, NULL, NULL, '2024-02-27 19:24:46', '2024-02-27 19:24:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(13, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 13, NULL, NULL, '2024-02-27 19:25:34', '2024-02-27 19:25:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(14, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 14, NULL, NULL, '2024-02-27 19:26:26', '2024-02-27 19:26:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(15, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 15, NULL, NULL, '2024-02-27 19:30:53', '2024-02-27 19:30:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(16, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 16, NULL, NULL, '2024-02-27 19:31:57', '2024-02-27 19:31:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(17, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 17, NULL, NULL, '2024-02-27 19:33:13', '2024-02-27 19:33:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(18, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 18, NULL, NULL, '2024-02-27 19:33:57', '2024-02-27 19:33:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(19, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 19, NULL, NULL, '2024-02-27 19:35:08', '2024-02-27 19:35:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(20, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 20, NULL, NULL, '2024-02-27 19:37:48', '2024-02-27 19:37:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(21, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 21, NULL, NULL, '2024-02-27 19:39:23', '2024-02-27 19:39:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(22, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 22, NULL, NULL, '2024-02-27 19:40:06', '2024-02-27 19:40:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(23, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 23, NULL, NULL, '2024-02-27 19:46:44', '2024-02-27 19:46:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(24, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 24, NULL, NULL, '2024-02-27 19:47:11', '2024-02-27 19:47:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(25, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 25, NULL, NULL, '2024-02-27 19:49:12', '2024-02-27 19:49:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(26, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 26, NULL, NULL, '2024-02-27 19:53:03', '2024-02-27 19:53:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(27, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 27, NULL, NULL, '2024-02-27 19:54:05', '2024-02-27 19:54:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(28, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 28, NULL, NULL, '2024-02-27 19:54:43', '2024-02-27 19:54:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(29, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 29, NULL, NULL, '2024-02-27 19:55:36', '2024-02-27 19:55:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(30, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 30, NULL, NULL, '2024-02-27 19:57:35', '2024-02-27 19:57:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(31, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 31, NULL, NULL, '2024-02-27 19:58:09', '2024-02-27 19:58:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(32, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 32, NULL, NULL, '2024-02-27 20:01:01', '2024-02-27 20:01:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(33, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 33, NULL, NULL, '2024-02-27 20:01:59', '2024-02-27 20:01:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(34, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 34, NULL, NULL, '2024-02-27 20:03:56', '2024-02-27 20:03:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(35, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 35, NULL, NULL, '2024-02-27 20:04:38', '2024-02-27 20:04:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(36, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 36, NULL, NULL, '2024-02-27 20:05:24', '2024-02-27 20:05:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(37, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 37, NULL, NULL, '2024-02-27 20:11:05', '2024-02-27 20:11:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(38, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 38, NULL, NULL, '2024-02-27 20:13:18', '2024-02-27 20:13:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(39, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 39, NULL, NULL, '2024-02-27 20:18:35', '2024-02-27 20:18:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(40, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 40, NULL, NULL, '2024-02-27 20:19:12', '2024-02-27 20:19:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(41, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 41, NULL, NULL, '2024-02-27 20:22:36', '2024-02-27 20:22:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(42, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 42, NULL, NULL, '2024-02-27 20:24:39', '2024-02-27 20:24:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(43, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 43, NULL, NULL, '2024-02-27 20:26:49', '2024-02-27 20:26:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(44, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 44, NULL, NULL, '2024-02-27 20:27:21', '2024-02-27 20:27:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(45, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 45, NULL, NULL, '2024-02-27 20:29:28', '2024-02-27 20:29:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(46, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 46, NULL, NULL, '2024-02-27 20:41:08', '2024-02-27 20:41:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(47, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 47, NULL, NULL, '2024-02-27 20:41:41', '2024-02-27 20:41:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(48, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 48, NULL, NULL, '2024-02-27 20:44:57', '2024-02-27 20:44:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(49, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 49, NULL, NULL, '2024-02-27 20:46:40', '2024-02-27 20:46:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(50, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 50, NULL, NULL, '2024-02-27 20:47:53', '2024-02-27 20:47:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(51, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 51, NULL, NULL, '2024-02-27 20:48:44', '2024-02-27 20:48:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(52, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 52, NULL, NULL, '2024-02-27 20:49:17', '2024-02-27 20:49:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(53, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 53, NULL, NULL, '2024-02-27 20:51:25', '2024-02-27 20:51:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(54, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 54, NULL, NULL, '2024-02-27 20:52:15', '2024-02-27 20:52:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(55, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 55, NULL, NULL, '2024-02-27 20:53:03', '2024-02-27 20:53:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(56, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 56, NULL, NULL, '2024-02-27 20:53:46', '2024-02-27 20:53:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(57, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 57, NULL, NULL, '2024-02-27 20:54:19', '2024-02-27 20:54:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(58, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 58, NULL, NULL, '2024-02-27 20:54:59', '2024-02-27 20:54:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(59, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 59, NULL, NULL, '2024-02-27 20:55:36', '2024-02-27 20:55:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(60, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 60, NULL, NULL, '2024-02-27 20:56:15', '2024-02-27 20:56:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(61, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 61, NULL, NULL, '2024-02-27 20:56:48', '2024-02-27 20:56:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(62, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 62, NULL, NULL, '2024-02-27 20:57:21', '2024-02-27 20:57:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(63, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 15, NULL, NULL, '2024-02-29 20:34:17', '2024-02-29 20:34:17', NULL, NULL, NULL, NULL, '{\"_snipeit_jumlah_barang_7\":{\"old\":\"1\",\"new\":\"10\"}}', NULL, NULL, 'gui', '180.252.81.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36'),
(64, 1, 'checkout', 1, 'App\\Models\\Location', 1, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-02-29 20:54:05', '2024-02-29 20:54:05', NULL, NULL, NULL, NULL, '{\"location_id\":{\"old\":null,\"new\":1}}', '2024-03-01 03:54:05', NULL, 'gui', '180.252.81.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36'),
(65, 1, 'checkout', 1, 'App\\Models\\Location', 1, 'Re-Export', NULL, 'App\\Models\\Asset', 15, NULL, NULL, '2024-03-06 00:37:32', '2024-03-06 00:37:32', NULL, NULL, NULL, NULL, '{\"location_id\":{\"old\":null,\"new\":1}}', '2024-03-06 07:37:32', NULL, 'gui', '180.253.31.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'),
(66, 1, 'audit', NULL, NULL, 1, NULL, '', 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-17 11:13:39', '2024-04-17 11:13:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(67, 1, 'checkin from', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-04-17 11:14:33', '2024-04-17 11:14:33', NULL, NULL, NULL, NULL, NULL, '2024-04-17 18:14:33', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(68, 1, 'audit', NULL, NULL, 1, NULL, '', 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-17 11:17:28', '2024-04-17 11:17:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(69, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\User', 2, NULL, NULL, '2024-04-17 11:25:41', '2024-04-17 11:25:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cli/unknown', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(70, 1, 'checkout', 2, 'App\\Models\\User', NULL, 'tes', NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-17 11:25:52', '2024-04-17 11:25:52', NULL, NULL, NULL, NULL, NULL, '2024-04-17 18:25:52', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(71, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-04-17 20:19:32', '2024-04-17 20:19:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(72, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\User', 3, NULL, NULL, '2024-04-17 23:50:51', '2024-04-17 23:50:51', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'cli/unknown', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(73, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 2, NULL, NULL, '2024-04-18 00:00:36', '2024-04-18 00:00:36', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(74, 1, 'checkout', 3, 'App\\Models\\User', NULL, 'Checked out on asset creation', NULL, 'App\\Models\\Asset', 2, NULL, NULL, '2024-04-18 00:00:36', '2024-04-18 00:00:36', NULL, NULL, 1, NULL, NULL, '2024-04-18 07:00:36', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(75, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 3, NULL, NULL, '2024-04-18 00:09:53', '2024-04-18 00:09:53', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(76, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 4, NULL, NULL, '2024-04-18 00:11:12', '2024-04-18 00:11:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(77, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 3, NULL, NULL, '2024-04-18 00:12:46', '2024-04-18 00:12:46', NULL, NULL, 1, NULL, '{\"asset_tag\":{\"old\":\"23\",\"new\":\"testing\"},\"serial\":{\"old\":\"23\",\"new\":\"testing\"},\"satuan_barang\":{\"old\":\"\",\"new\":\"H87\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(78, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 3, NULL, NULL, '2024-04-18 00:14:28', '2024-04-18 00:14:28', NULL, NULL, 1, NULL, '{\"satuan_barang\":{\"old\":\"H87\",\"new\":\"PCE\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(79, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-04-18 02:00:21', '2024-04-18 02:00:21', NULL, NULL, NULL, NULL, '{\"name\":{\"old\":\"asssdsa\",\"new\":\"Uraian barang 55\"},\"asset_tag\":{\"old\":\"123\",\"new\":\"barang55\"},\"serial\":{\"old\":\"234\",\"new\":\"asd\"},\"company_id\":{\"old\":null,\"new\":\"1\"},\"kategori_barang\":{\"old\":\"bahan baku\",\"new\":\"bahan penolong\"},\"saldo_awal\":{\"old\":200000,\"new\":\"100000\"},\"satuan_barang\":{\"old\":\"PCE\",\"new\":\"MND\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(80, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-04-18 02:01:28', '2024-04-18 02:01:28', NULL, NULL, 1, NULL, '{\"pemasukan\":{\"old\":0,\"new\":\"100\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(81, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-18 11:58:40', '2024-04-18 11:58:40', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(82, 1, 'checkout', 1, 'App\\Models\\Asset', NULL, 'Checked out on asset creation', NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-18 11:58:40', '2024-04-18 11:58:40', NULL, NULL, 1, NULL, NULL, '2024-04-18 18:58:40', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(83, 1, 'checkin from', 1, 'App\\Models\\Asset', NULL, '32423', NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-19 03:20:18', '2024-04-19 03:20:18', NULL, NULL, 1, NULL, '{\"location_id\":{\"old\":null,\"new\":\"1\"}}', '2024-04-19 10:20:17', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(84, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2024-04-19 09:21:51', '2024-04-19 09:21:51', NULL, NULL, 1, NULL, '{\"stock_opname\":{\"old\":22,\"new\":\"0\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(85, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-04-19 09:22:57', '2024-04-19 09:22:57', NULL, NULL, 1, NULL, '{\"kategori_barang\":{\"old\":\"Mesin dan Peralatan\",\"new\":\"bahan penolong\"},\"jumlah_barang\":{\"old\":1,\"new\":\"20\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(86, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2024-04-19 09:25:14', '2024-04-19 09:25:14', NULL, NULL, 1, NULL, '{\"kategori_barang\":{\"old\":\"bahan penolong\",\"new\":\"barang dalam proses\"},\"nomor_kategori_barang\":{\"old\":5,\"new\":6}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(87, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\User', 4, NULL, NULL, '2024-04-19 09:26:38', '2024-04-19 09:26:38', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'cli/unknown', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(88, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\User', 5, NULL, NULL, '2024-04-19 09:27:29', '2024-04-19 09:27:29', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'cli/unknown', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(89, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\User', 6, NULL, NULL, '2024-04-19 09:32:09', '2024-04-19 09:32:09', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'cli/unknown', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(90, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 6, NULL, NULL, '2024-04-19 10:54:27', '2024-04-19 10:54:27', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(91, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 7, NULL, NULL, '2024-04-19 10:58:32', '2024-04-19 10:58:32', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(92, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 7, NULL, NULL, '2024-04-19 10:59:04', '2024-04-19 10:59:04', NULL, NULL, 1, NULL, '{\"status_id\":{\"old\":3,\"new\":\"2\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(93, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 8, NULL, NULL, '2024-04-19 11:27:10', '2024-04-19 11:27:10', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(94, 1, 'checkout', 1, 'App\\Models\\Location', 1, NULL, NULL, 'App\\Models\\Asset', 8, NULL, NULL, '2024-04-19 14:10:54', '2024-04-19 14:10:54', NULL, NULL, NULL, NULL, '{\"expected_checkin\":{\"old\":null,\"new\":\"2024-04-24\"},\"location_id\":{\"old\":null,\"new\":1}}', '2024-04-19 21:10:53', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(95, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 9, NULL, NULL, '2024-04-19 22:44:48', '2024-04-19 22:44:48', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(96, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 10, NULL, NULL, '2024-04-20 01:59:29', '2024-04-20 01:59:29', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(97, 1, 'checkout', 1, 'App\\Models\\Location', 1, NULL, NULL, 'App\\Models\\Asset', 7, NULL, NULL, '2024-04-20 02:04:47', '2024-04-20 02:04:47', NULL, NULL, NULL, NULL, '{\"expected_checkin\":{\"old\":null,\"new\":\"2024-04-20\"},\"location_id\":{\"old\":null,\"new\":1}}', '2024-04-20 09:04:47', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(98, 1, 'checkin from', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 8, NULL, NULL, '2024-04-20 03:36:23', '2024-04-20 03:36:23', NULL, NULL, NULL, NULL, '{\"expected_checkin\":{\"old\":\"2024-04-24\",\"new\":null}}', '2024-04-20 10:36:23', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(99, 1, 'checkin from', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 7, NULL, NULL, '2024-04-20 03:36:51', '2024-04-20 03:36:51', NULL, NULL, NULL, NULL, '{\"expected_checkin\":{\"old\":\"2024-04-20\",\"new\":null}}', '2024-04-20 10:36:51', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(100, 1, 'checkout', 1, 'App\\Models\\Location', 1, NULL, NULL, 'App\\Models\\Asset', 7, NULL, NULL, '2024-04-20 03:40:57', '2024-04-20 03:40:57', NULL, NULL, NULL, NULL, NULL, '2024-04-20 10:40:57', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(101, 1, 'checkout', 1, 'App\\Models\\Location', 1, NULL, NULL, 'App\\Models\\Asset', 9, NULL, NULL, '2024-04-20 03:41:29', '2024-04-20 03:41:29', NULL, NULL, NULL, NULL, '{\"location_id\":{\"old\":null,\"new\":1}}', '2024-04-20 10:41:29', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(102, 1, 'create', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 11, NULL, NULL, '2024-04-20 12:56:48', '2024-04-20 12:56:48', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(103, 1, 'checkout', 1, 'App\\Models\\Location', 1, 'Checked out on asset creation', NULL, 'App\\Models\\Asset', 11, NULL, NULL, '2024-04-20 12:56:49', '2024-04-20 12:56:49', NULL, NULL, NULL, NULL, NULL, '2024-04-20 19:56:48', NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'),
(104, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Asset', 11, NULL, NULL, '2024-04-20 12:57:53', '2024-04-20 12:57:53', NULL, NULL, 1, NULL, '{\"saldo_awal\":{\"old\":20000,\"new\":\"20\"},\"saldo_buku\":{\"old\":20000,\"new\":20},\"stock_opname\":{\"old\":0,\"new\":\"20\"},\"selisih\":{\"old\":-20000,\"new\":0},\"jumlah_barang\":{\"old\":10,\"new\":\"20\"},\"harga_satuan_barang\":{\"old\":20000,\"new\":\"200\"}}', NULL, NULL, 'gui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_adjusment`
--

DROP TABLE IF EXISTS `stzl_adjusment`;
CREATE TABLE IF NOT EXISTS `stzl_adjusment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asset_id` int NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `kode_barang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_barang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_kategori_barang` int NOT NULL,
  `nama_barang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_barang` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_barang` int NOT NULL,
  `saldo_awal` int NOT NULL,
  `jumlah_pemasukan_barang` int NOT NULL,
  `jumlah_pengeluaran_barang` int NOT NULL,
  `penyesuaian` int NOT NULL,
  `harga_total_barang` int NOT NULL,
  `saldo_akhir` int NOT NULL,
  `hasil_pencacah` int NOT NULL,
  `jumlah_selisih` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kirim` enum('S','B') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `kode_dokumen` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_dokumen` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dokumen` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_adjusment`
--

INSERT INTO `stzl_adjusment` (`id`, `asset_id`, `tanggal_pelaksanaan`, `kode_barang`, `kategori_barang`, `nomor_kategori_barang`, `nama_barang`, `satuan_barang`, `jumlah_barang`, `saldo_awal`, `jumlah_pemasukan_barang`, `jumlah_pengeluaran_barang`, `penyesuaian`, `harga_total_barang`, `saldo_akhir`, `hasil_pencacah`, `jumlah_selisih`, `keterangan`, `status_kirim`, `created_at`, `updated_at`, `kode_dokumen`, `nomor_dokumen`, `tanggal_dokumen`) VALUES
(1, 9, '2024-04-24', 'data tes', 'bahan penolong', 2, 'data untuk testing', 'PCE', 5, 5, 0, 0, 3, 5000, 0, 0, 2, 'adjus', 'B', '2024-04-20 12:37:54', '2024-04-20 12:37:54', '0407632', '100/adjus', '2024-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_assets`
--

DROP TABLE IF EXISTS `stzl_assets`;
CREATE TABLE IF NOT EXISTS `stzl_assets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_tag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `serial` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `asset_eol_date` date DEFAULT NULL,
  `eol_explicit` tinyint(1) NOT NULL DEFAULT '0',
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `physical` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status_id` int DEFAULT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `warranty_months` int DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `requestable` tinyint NOT NULL DEFAULT '0',
  `rtd_location_id` int DEFAULT NULL,
  `_snipeit_mac_address_1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accepted` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_checkout` datetime DEFAULT NULL,
  `last_checkin` datetime DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `company_id` int UNSIGNED DEFAULT NULL,
  `assigned_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_audit_date` datetime DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `checkin_counter` int NOT NULL DEFAULT '0',
  `checkout_counter` int NOT NULL DEFAULT '0',
  `requests_counter` int NOT NULL DEFAULT '0',
  `byod` tinyint(1) DEFAULT '0',
  `kategori_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_kategori_barang` int NOT NULL,
  `saldo_awal` double NOT NULL,
  `penyesuaian` double NOT NULL,
  `saldo_buku` double NOT NULL,
  `stock_opname` int NOT NULL,
  `selisih` int NOT NULL,
  `pemasukan` double NOT NULL,
  `pengeluaran` double NOT NULL,
  `jumlah_barang` int NOT NULL,
  `satuan_barang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan_barang` double NOT NULL,
  `no_dokument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kirim` enum('B','S','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B',
  `status_pemasukan` enum('S','B') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'sudah dan belum',
  `status_pengeluaran` enum('S','B') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'sudah dan belum',
  `status_opname` enum('S','B') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'sudah dan belum',
  `status_adjusment` enum('S','B') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'sudah dan belum',
  `_snipeit_status_pemasukan_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_jenis_dokumen_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_nomor_daftar_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_tanggal_daftar_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_nama_pengirim_barang_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_jumlah_barang_7` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_satuan_8` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_tanggal_penerimaan_barang_9` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_nomor_bukti_penerimaan_barang_10` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_site_11` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_department_12` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_owner_13` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_location_14` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_detail_lokasi_15` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_event_16` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_asset_source_17` text COLLATE utf8mb4_unicode_ci,
  `_snipeit_procurement_method_18` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_purchasing_order_no_19` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_harga_satuan_20` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_nilai_barang_21` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `_snipeit_forwarder_22` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `assets_rtd_location_id_index` (`rtd_location_id`),
  KEY `assets_assigned_type_assigned_to_index` (`assigned_type`,`assigned_to`),
  KEY `assets_created_at_index` (`created_at`),
  KEY `assets_deleted_at_status_id_index` (`deleted_at`,`status_id`),
  KEY `assets_deleted_at_model_id_index` (`deleted_at`,`model_id`),
  KEY `assets_deleted_at_assigned_type_assigned_to_index` (`deleted_at`,`assigned_type`,`assigned_to`),
  KEY `assets_deleted_at_supplier_id_index` (`deleted_at`,`supplier_id`),
  KEY `assets_deleted_at_location_id_index` (`deleted_at`,`location_id`),
  KEY `assets_deleted_at_rtd_location_id_index` (`deleted_at`,`rtd_location_id`),
  KEY `assets_deleted_at_asset_tag_index` (`deleted_at`,`asset_tag`),
  KEY `assets_deleted_at_name_index` (`deleted_at`,`name`),
  KEY `assets_serial_index` (`serial`),
  KEY `assets_company_id_index` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_assets`
--

INSERT INTO `stzl_assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `asset_eol_date`, `eol_explicit`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `_snipeit_mac_address_1`, `accepted`, `last_checkout`, `last_checkin`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `checkin_counter`, `checkout_counter`, `requests_counter`, `byod`, `kategori_barang`, `nomor_kategori_barang`, `saldo_awal`, `penyesuaian`, `saldo_buku`, `stock_opname`, `selisih`, `pemasukan`, `pengeluaran`, `jumlah_barang`, `satuan_barang`, `harga_satuan_barang`, `no_dokument`, `status_kirim`, `status_pemasukan`, `status_pengeluaran`, `status_opname`, `status_adjusment`, `_snipeit_status_pemasukan_2`, `_snipeit_jenis_dokumen_3`, `_snipeit_nomor_daftar_4`, `_snipeit_tanggal_daftar_5`, `_snipeit_nama_pengirim_barang_6`, `_snipeit_jumlah_barang_7`, `_snipeit_satuan_8`, `_snipeit_tanggal_penerimaan_barang_9`, `_snipeit_nomor_bukti_penerimaan_barang_10`, `_snipeit_site_11`, `_snipeit_department_12`, `_snipeit_owner_13`, `_snipeit_location_14`, `_snipeit_detail_lokasi_15`, `_snipeit_event_16`, `_snipeit_asset_source_17`, `_snipeit_procurement_method_18`, `_snipeit_purchasing_order_no_19`, `_snipeit_harga_satuan_20`, `_snipeit_nilai_barang_21`, `_snipeit_forwarder_22`) VALUES
(7, 'Urban Concept Car Prototype Qatar Foundation', 'LOGPN-000001', 1, 'LOGPN-000001', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, 1, '2024-04-19 10:58:32', '2024-04-20 03:40:57', 1, NULL, 2, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2024-04-20 10:40:57', '2024-04-20 10:36:51', NULL, 1, 'App\\Models\\Location', NULL, NULL, 1, 1, 2, 0, 0, 'mesin dan peralatan', 5, 20, 0, 20, 20, 0, 0, 0, 20, 'PCE', 9000, '', 'B', 'B', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Prototype Battery electric car for Shell Eco Marathon', 'LOGPN-000002', 1, 'LOGPN-000002', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-19 11:27:10', '2024-04-20 03:36:23', 1, NULL, 2, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2024-04-20 10:36:23', NULL, 1, NULL, NULL, NULL, 1, 1, 1, 0, 0, 'mesin dan peralatan', 5, 10, 0, 10, 10, 0, 0, 0, 10, 'PCE', 3500, '', 'B', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'data untuk testing', 'data tes', 1, 'data tes', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, 1, '2024-04-19 22:44:48', '2024-04-20 03:41:29', 1, NULL, 2, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2024-04-20 10:41:29', NULL, NULL, 1, 'App\\Models\\Location', NULL, NULL, 1, 0, 1, 0, 0, 'bahan penolong', 2, 5, 0, 5, 8, 0, 0, 0, 5, 'PCE', 1000, '', 'B', 'B', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Nanyang Venture XII SHELL ECO Hydrogen Fuel Cell', 'LOGPN-000003', 1, 'LOGPN-000003', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-20 01:59:29', '2024-04-20 01:59:29', 1, NULL, 2, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 'mesin dan peralatan', 5, 0, 0, 0, 0, 0, 0, 0, 2, 'PCE', 8000, '', 'B', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'tessss', '123', 1, '123', NULL, NULL, 0, NULL, NULL, 1, 'sadsad', NULL, 1, '2024-04-20 12:56:48', '2024-04-20 12:57:53', 1, NULL, 2, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2024-04-20 19:56:48', NULL, NULL, 1, 'App\\Models\\Location', NULL, NULL, 1, 0, 1, 0, 0, 'bahan habis pakai', 3, 20, 0, 20, 20, 0, 0, 0, 20, 'PCE', 200, '', 'B', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_asset_logs`
--

DROP TABLE IF EXISTS `stzl_asset_logs`;
CREATE TABLE IF NOT EXISTS `stzl_asset_logs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_id` int NOT NULL,
  `checkedout_to` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `filename` text COLLATE utf8mb4_unicode_ci,
  `requested_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `accessory_id` int DEFAULT NULL,
  `accepted_id` int DEFAULT NULL,
  `consumable_id` int DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `component_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_asset_maintenances`
--

DROP TABLE IF EXISTS `stzl_asset_maintenances`;
CREATE TABLE IF NOT EXISTS `stzl_asset_maintenances` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int UNSIGNED NOT NULL,
  `supplier_id` int UNSIGNED NOT NULL,
  `asset_maintenance_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_warranty` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `asset_maintenance_time` int DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `cost` decimal(20,2) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_asset_uploads`
--

DROP TABLE IF EXISTS `stzl_asset_uploads`;
CREATE TABLE IF NOT EXISTS `stzl_asset_uploads` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_id` int NOT NULL,
  `filenotes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_categories`
--

DROP TABLE IF EXISTS `stzl_categories`;
CREATE TABLE IF NOT EXISTS `stzl_categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `eula_text` longtext COLLATE utf8mb4_unicode_ci,
  `use_default_eula` tinyint(1) NOT NULL DEFAULT '0',
  `require_acceptance` tinyint(1) NOT NULL DEFAULT '0',
  `category_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'asset',
  `checkin_email` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_categories`
--

INSERT INTO `stzl_categories` (`id`, `name`, `created_at`, `updated_at`, `user_id`, `deleted_at`, `eula_text`, `use_default_eula`, `require_acceptance`, `category_type`, `checkin_email`, `image`) VALUES
(1, 'Misc Software', '2024-02-28 05:05:26', '2024-02-28 05:05:26', NULL, NULL, NULL, 0, 0, 'license', 0, NULL),
(2, 'Mesin dan Peralatan', '2024-02-27 15:31:50', '2024-02-27 15:31:50', NULL, NULL, NULL, 0, 0, 'asset', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_checkout_acceptances`
--

DROP TABLE IF EXISTS `stzl_checkout_acceptances`;
CREATE TABLE IF NOT EXISTS `stzl_checkout_acceptances` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `checkoutable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkoutable_id` bigint UNSIGNED NOT NULL,
  `assigned_to_id` int DEFAULT NULL,
  `signature_filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `declined_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `stored_eula` text COLLATE utf8mb4_unicode_ci,
  `stored_eula_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checkout_acceptances_checkoutable_type_checkoutable_id_index` (`checkoutable_type`,`checkoutable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_checkout_requests`
--

DROP TABLE IF EXISTS `stzl_checkout_requests`;
CREATE TABLE IF NOT EXISTS `stzl_checkout_requests` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `requestable_id` int NOT NULL,
  `requestable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `fulfilled_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checkout_requests_user_id_requestable_id_requestable_type` (`user_id`,`requestable_id`,`requestable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_companies`
--

DROP TABLE IF EXISTS `stzl_companies`;
CREATE TABLE IF NOT EXISTS `stzl_companies` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_companies`
--

INSERT INTO `stzl_companies` (`id`, `name`, `fax`, `email`, `phone`, `created_at`, `updated_at`, `image`) VALUES
(1, 'MGPA', NULL, 'mmgpa@gmail.com', '087722233', '2024-04-17 23:49:34', '2024-04-17 23:49:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_components`
--

DROP TABLE IF EXISTS `stzl_components`;
CREATE TABLE IF NOT EXISTS `stzl_components` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `min_amt` int DEFAULT NULL,
  `serial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `components_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_components_assets`
--

DROP TABLE IF EXISTS `stzl_components_assets`;
CREATE TABLE IF NOT EXISTS `stzl_components_assets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `assigned_qty` int DEFAULT '1',
  `component_id` int DEFAULT NULL,
  `asset_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_consumables`
--

DROP TABLE IF EXISTS `stzl_consumables`;
CREATE TABLE IF NOT EXISTS `stzl_consumables` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `requestable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int UNSIGNED DEFAULT NULL,
  `min_amt` int DEFAULT NULL,
  `model_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer_id` int DEFAULT NULL,
  `item_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `consumables_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_consumables_users`
--

DROP TABLE IF EXISTS `stzl_consumables_users`;
CREATE TABLE IF NOT EXISTS `stzl_consumables_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `consumable_id` int DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_custom_fields`
--

DROP TABLE IF EXISTS `stzl_custom_fields`;
CREATE TABLE IF NOT EXISTS `stzl_custom_fields` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `field_values` text COLLATE utf8mb4_unicode_ci,
  `field_encrypted` tinyint(1) NOT NULL DEFAULT '0',
  `db_column` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `show_in_email` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_requestable_list` tinyint(1) DEFAULT '0',
  `is_unique` tinyint(1) DEFAULT '0',
  `display_in_user_view` tinyint(1) DEFAULT '0',
  `auto_add_to_fieldsets` tinyint(1) DEFAULT '0',
  `show_in_listview` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_custom_fields`
--

INSERT INTO `stzl_custom_fields` (`id`, `name`, `format`, `element`, `created_at`, `updated_at`, `user_id`, `field_values`, `field_encrypted`, `db_column`, `help_text`, `show_in_email`, `show_in_requestable_list`, `is_unique`, `display_in_user_view`, `auto_add_to_fieldsets`, `show_in_listview`) VALUES
(1, 'MAC Address', 'regex:/^[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}$/', 'text', NULL, '2024-02-28 05:05:26', NULL, NULL, 0, '_snipeit_mac_address_1', NULL, 0, 0, 0, 0, 0, 0),
(2, 'Status Pemasukan', '', 'listbox', '2024-02-27 15:30:34', '2024-02-27 15:30:34', NULL, 'Barang Fasilitas KEK\r\nBarang non-Fasilitas KEK', 0, '_snipeit_status_pemasukan_2', NULL, 0, 0, 0, 0, 0, 0),
(3, 'Jenis Dokumen', '', 'listbox', '2024-02-27 15:37:10', '2024-02-27 15:37:10', NULL, 'PPKEK\r\nPIB\r\nAWB', 0, '_snipeit_jenis_dokumen_3', NULL, 0, 0, 0, 0, 0, 0),
(4, 'Nomor Daftar', 'numeric', 'text', '2024-02-27 15:41:27', '2024-02-27 15:41:27', NULL, NULL, 0, '_snipeit_nomor_daftar_4', NULL, 0, 0, 0, 0, 0, 0),
(5, 'Tanggal Daftar', 'date', 'text', '2024-02-27 15:41:46', '2024-02-27 15:41:46', NULL, NULL, 0, '_snipeit_tanggal_daftar_5', NULL, 0, 0, 0, 0, 0, 0),
(6, 'Nama Pengirim Barang', '', 'text', '2024-02-27 15:42:32', '2024-02-27 15:42:32', NULL, NULL, 0, '_snipeit_nama_pengirim_barang_6', NULL, 0, 0, 0, 0, 0, 0),
(7, 'Jumlah Barang', 'numeric', 'text', '2024-02-27 15:44:11', '2024-02-27 15:44:11', NULL, NULL, 0, '_snipeit_jumlah_barang_7', NULL, 0, 0, 0, 0, 0, 0),
(8, 'Satuan', '', 'listbox', '2024-02-27 15:44:35', '2024-02-27 15:44:35', NULL, 'PCE\r\nNIU\r\nBX', 0, '_snipeit_satuan_8', NULL, 0, 0, 0, 0, 0, 0),
(9, 'Tanggal Penerimaan Barang', 'date', 'text', '2024-02-27 15:45:11', '2024-02-27 15:45:11', NULL, NULL, 0, '_snipeit_tanggal_penerimaan_barang_9', NULL, 0, 0, 0, 0, 0, 0),
(10, 'Nomor Bukti Penerimaan Barang', '', 'text', '2024-02-27 15:45:49', '2024-02-27 15:45:49', NULL, NULL, 0, '_snipeit_nomor_bukti_penerimaan_barang_10', NULL, 0, 0, 0, 0, 0, 0),
(11, 'Site', '', 'listbox', '2024-02-27 15:53:00', '2024-02-27 15:53:00', NULL, 'Pertamina Mandalika Intenational Circuit', 0, '_snipeit_site_11', NULL, 0, 0, 0, 0, 0, 0),
(12, 'Department', '', 'text', '2024-02-27 15:54:19', '2024-02-27 15:54:19', NULL, NULL, 0, '_snipeit_department_12', NULL, 0, 0, 0, 0, 0, 0),
(13, 'Owner', '', 'listbox', '2024-02-27 15:54:43', '2024-02-27 15:54:43', NULL, 'Barang Penangguhan\r\nMGPA', 0, '_snipeit_owner_13', NULL, 0, 0, 0, 0, 0, 0),
(14, 'Location', '', 'text', '2024-02-27 15:55:16', '2024-02-27 15:55:16', NULL, NULL, 0, '_snipeit_location_14', NULL, 0, 0, 0, 0, 0, 0),
(15, 'Detail Lokasi', '', 'text', '2024-02-27 15:55:31', '2024-02-27 15:55:31', NULL, NULL, 0, '_snipeit_detail_lokasi_15', NULL, 0, 0, 0, 0, 0, 0),
(16, 'Event', '', 'listbox', '2024-02-27 15:57:03', '2024-02-27 15:57:03', NULL, 'Shell Eco-Marathon 2023', 0, '_snipeit_event_16', NULL, 0, 0, 0, 0, 0, 0),
(17, 'Asset Source', '', 'text', '2024-02-27 15:57:34', '2024-02-27 15:57:34', NULL, NULL, 0, '_snipeit_asset_source_17', NULL, 0, 0, 0, 0, 0, 0),
(18, 'Procurement Method', '', 'text', '2024-02-27 15:57:53', '2024-02-27 15:57:53', NULL, NULL, 0, '_snipeit_procurement_method_18', NULL, 0, 0, 0, 0, 0, 0),
(19, 'Purchasing Order No.', '', 'text', '2024-02-27 15:58:29', '2024-02-27 15:58:29', NULL, NULL, 0, '_snipeit_purchasing_order_no_19', NULL, 0, 0, 0, 0, 0, 0),
(20, 'Harga Satuan', 'numeric', 'text', '2024-02-27 15:59:26', '2024-02-27 15:59:26', NULL, NULL, 0, '_snipeit_harga_satuan_20', NULL, 0, 0, 0, 0, 0, 0),
(21, 'Nilai Barang', 'numeric', 'text', '2024-02-27 15:59:51', '2024-02-27 15:59:51', NULL, NULL, 0, '_snipeit_nilai_barang_21', NULL, 0, 0, 0, 0, 0, 0),
(22, 'Forwarder', '', 'text', '2024-02-27 16:00:23', '2024-02-27 16:00:23', NULL, NULL, 0, '_snipeit_forwarder_22', NULL, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_custom_fieldsets`
--

DROP TABLE IF EXISTS `stzl_custom_fieldsets`;
CREATE TABLE IF NOT EXISTS `stzl_custom_fieldsets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_custom_fieldsets`
--

INSERT INTO `stzl_custom_fieldsets` (`id`, `name`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Asset with MAC Address', NULL, NULL, NULL),
(2, 'Mesin dan Peralatan', '2024-02-27 15:29:22', '2024-02-27 15:29:22', 1),
(3, 'Barang Habis Pakai', '2024-02-28 02:41:32', '2024-02-28 02:41:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_custom_field_custom_fieldset`
--

DROP TABLE IF EXISTS `stzl_custom_field_custom_fieldset`;
CREATE TABLE IF NOT EXISTS `stzl_custom_field_custom_fieldset` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `custom_field_id` int NOT NULL,
  `custom_fieldset_id` int NOT NULL,
  `order` int NOT NULL,
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_custom_field_custom_fieldset`
--

INSERT INTO `stzl_custom_field_custom_fieldset` (`id`, `custom_field_id`, `custom_fieldset_id`, `order`, `required`) VALUES
(1, 1, 1, 1, 0),
(24, 4, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_departments`
--

DROP TABLE IF EXISTS `stzl_departments`;
CREATE TABLE IF NOT EXISTS `stzl_departments` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departments_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_depreciations`
--

DROP TABLE IF EXISTS `stzl_depreciations`;
CREATE TABLE IF NOT EXISTS `stzl_depreciations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `months` int NOT NULL,
  `depreciation_min` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_imports`
--

DROP TABLE IF EXISTS `stzl_imports`;
CREATE TABLE IF NOT EXISTS `stzl_imports` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filesize` int NOT NULL,
  `import_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `header_row` text COLLATE utf8mb4_unicode_ci,
  `first_row` text COLLATE utf8mb4_unicode_ci,
  `field_map` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_kits`
--

DROP TABLE IF EXISTS `stzl_kits`;
CREATE TABLE IF NOT EXISTS `stzl_kits` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_kits_accessories`
--

DROP TABLE IF EXISTS `stzl_kits_accessories`;
CREATE TABLE IF NOT EXISTS `stzl_kits_accessories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kit_id` int DEFAULT NULL,
  `accessory_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_kits_consumables`
--

DROP TABLE IF EXISTS `stzl_kits_consumables`;
CREATE TABLE IF NOT EXISTS `stzl_kits_consumables` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kit_id` int DEFAULT NULL,
  `consumable_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_kits_licenses`
--

DROP TABLE IF EXISTS `stzl_kits_licenses`;
CREATE TABLE IF NOT EXISTS `stzl_kits_licenses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kit_id` int DEFAULT NULL,
  `license_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_kits_models`
--

DROP TABLE IF EXISTS `stzl_kits_models`;
CREATE TABLE IF NOT EXISTS `stzl_kits_models` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kit_id` int DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_licenses`
--

DROP TABLE IF EXISTS `stzl_licenses`;
CREATE TABLE IF NOT EXISTS `stzl_licenses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` text COLLATE utf8mb4_unicode_ci,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seats` int NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `depreciation_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `license_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `purchase_order` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `maintained` tinyint(1) DEFAULT NULL,
  `reassignable` tinyint(1) NOT NULL DEFAULT '1',
  `company_id` int UNSIGNED DEFAULT NULL,
  `manufacturer_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `licenses_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_license_seats`
--

DROP TABLE IF EXISTS `stzl_license_seats`;
CREATE TABLE IF NOT EXISTS `stzl_license_seats` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `license_id` int DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `license_seats_license_id_index` (`license_id`),
  KEY `license_seats_assigned_to_license_id_index` (`assigned_to`,`license_id`),
  KEY `license_seats_asset_id_license_id_index` (`asset_id`,`license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_locations`
--

DROP TABLE IF EXISTS `stzl_locations`;
CREATE TABLE IF NOT EXISTS `stzl_locations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_ou` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_locations`
--

INSERT INTO `stzl_locations` (`id`, `name`, `city`, `state`, `country`, `created_at`, `updated_at`, `user_id`, `address`, `address2`, `zip`, `fax`, `phone`, `deleted_at`, `parent_id`, `currency`, `ldap_ou`, `manager_id`, `image`) VALUES
(1, 'Export', 'Luar Negeri', NULL, NULL, '2024-02-29 20:54:00', '2024-02-29 20:54:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_login_attempts`
--

DROP TABLE IF EXISTS `stzl_login_attempts`;
CREATE TABLE IF NOT EXISTS `stzl_login_attempts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `successful` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_login_attempts`
--

INSERT INTO `stzl_login_attempts` (`id`, `username`, `remote_ip`, `user_agent`, `successful`, `created_at`, `updated_at`) VALUES
(1, 'admin', '180.252.86.166', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 1, '2024-02-27 15:05:42', NULL),
(2, 'admin', '180.252.86.166', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 1, '2024-02-27 15:17:56', NULL),
(3, 'admin', '36.69.11.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1, '2024-02-27 17:29:14', NULL),
(4, 'admin', '180.252.85.231', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 1, '2024-02-28 00:35:47', NULL),
(5, 'admin', '103.105.66.49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 OPR/106.0.0.0', 1, '2024-02-28 02:06:54', NULL),
(6, 'admin', '119.110.71.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0', 1, '2024-02-28 19:17:32', NULL),
(7, ' admin', '36.90.20.249', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15', 0, '2024-02-28 23:20:37', NULL),
(8, 'admin', '36.90.20.249', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Safari/605.1.15', 1, '2024-02-28 23:20:48', NULL),
(9, 'admin', '180.252.81.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', 1, '2024-02-29 20:09:23', NULL),
(10, 'admin', '180.252.171.71', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0', 1, '2024-03-02 21:23:00', NULL),
(11, 'admin', '180.253.31.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 0, '2024-03-06 00:04:25', NULL),
(12, 'admin', '180.253.31.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 1, '2024-03-06 00:04:43', NULL),
(13, 'admin', '110.138.94.96', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 1, '2024-03-20 19:11:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_manufacturers`
--

DROP TABLE IF EXISTS `stzl_manufacturers`;
CREATE TABLE IF NOT EXISTS `stzl_manufacturers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty_lookup_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_migrations`
--

DROP TABLE IF EXISTS `stzl_migrations`;
CREATE TABLE IF NOT EXISTS `stzl_migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_migrations`
--

INSERT INTO `stzl_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_12_06_225921_migration_cartalyst_sentry_install_users', 1),
(2, '2012_12_06_225929_migration_cartalyst_sentry_install_groups', 1),
(3, '2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot', 1),
(4, '2012_12_06_225988_migration_cartalyst_sentry_install_throttle', 1),
(5, '2013_03_23_193214_update_users_table', 1),
(6, '2013_11_13_075318_create_models_table', 1),
(7, '2013_11_13_075335_create_categories_table', 1),
(8, '2013_11_13_075347_create_manufacturers_table', 1),
(9, '2013_11_15_015858_add_user_id_to_categories', 1),
(10, '2013_11_15_112701_add_user_id_to_manufacturers', 1),
(11, '2013_11_15_190327_create_assets_table', 1),
(12, '2013_11_15_190357_create_temp_licenses_table', 1),
(13, '2013_11_15_201848_add_license_name_to_licenses', 1),
(14, '2013_11_16_040323_create_depreciations_table', 1),
(15, '2013_11_16_042851_add_depreciation_id_to_models', 1),
(16, '2013_11_16_084923_add_user_id_to_models', 1),
(17, '2013_11_16_103258_create_locations_table', 1),
(18, '2013_11_16_103336_add_location_id_to_assets', 1),
(19, '2013_11_16_103407_add_checkedout_to_to_assets', 1),
(20, '2013_11_16_103425_create_history_table', 1),
(21, '2013_11_17_054359_drop_licenses_table', 1),
(22, '2013_11_17_054526_add_physical_to_assets', 1),
(23, '2013_11_17_055126_create_settings_table', 1),
(24, '2013_11_17_062634_add_license_to_assets', 1),
(25, '2013_11_18_134332_add_contacts_to_users', 1),
(26, '2013_11_18_142847_add_info_to_locations', 1),
(27, '2013_11_18_152942_remove_location_id_from_asset', 1),
(28, '2013_11_18_164423_set_nullvalues_for_user', 1),
(29, '2013_11_19_013337_create_asset_logs_table', 1),
(30, '2013_11_19_061409_edit_added_on_asset_logs_table', 1),
(31, '2013_11_19_062250_edit_location_id_asset_logs_table', 1),
(32, '2013_11_20_055822_add_soft_delete_on_assets', 1),
(33, '2013_11_20_121404_add_soft_delete_on_locations', 1),
(34, '2013_11_20_123137_add_soft_delete_on_manufacturers', 1),
(35, '2013_11_20_123725_add_soft_delete_on_categories', 1),
(36, '2013_11_20_130248_create_status_labels', 1),
(37, '2013_11_20_130830_add_status_id_on_assets_table', 1),
(38, '2013_11_20_131544_add_status_type_on_status_labels', 1),
(39, '2013_11_20_134103_add_archived_to_assets', 1),
(40, '2013_11_21_002321_add_uploads_table', 1),
(41, '2013_11_21_024531_remove_deployable_boolean_from_status_labels', 1),
(42, '2013_11_22_075308_add_option_label_to_settings_table', 1),
(43, '2013_11_22_213400_edits_to_settings_table', 1),
(44, '2013_11_25_013244_recreate_licenses_table', 1),
(45, '2013_11_25_031458_create_license_seats_table', 1),
(46, '2013_11_25_032022_add_type_to_actionlog_table', 1),
(47, '2013_11_25_033008_delete_bad_licenses_table', 1),
(48, '2013_11_25_033131_create_new_licenses_table', 1),
(49, '2013_11_25_033534_add_licensed_to_licenses_table', 1),
(50, '2013_11_25_101308_add_warrantee_to_assets_table', 1),
(51, '2013_11_25_104343_alter_warranty_column_on_assets', 1),
(52, '2013_11_25_150450_drop_parent_from_categories', 1),
(53, '2013_11_25_151920_add_depreciate_to_assets', 1),
(54, '2013_11_25_152903_add_depreciate_to_licenses_table', 1),
(55, '2013_11_26_211820_drop_license_from_assets_table', 1),
(56, '2013_11_27_062510_add_note_to_asset_logs_table', 1),
(57, '2013_12_01_113426_add_filename_to_asset_log', 1),
(58, '2013_12_06_094618_add_nullable_to_licenses_table', 1),
(59, '2013_12_10_084038_add_eol_on_models_table', 1),
(60, '2013_12_12_055218_add_manager_to_users_table', 1),
(61, '2014_01_28_031200_add_qr_code_to_settings_table', 1),
(62, '2014_02_13_183016_add_qr_text_to_settings_table', 1),
(63, '2014_05_24_093839_alter_default_license_depreciation_id', 1),
(64, '2014_05_27_231658_alter_default_values_licenses', 1),
(65, '2014_06_19_191508_add_asset_name_to_settings', 1),
(66, '2014_06_20_004847_make_asset_log_checkedout_to_nullable', 1),
(67, '2014_06_20_005050_make_asset_log_purchasedate_to_nullable', 1),
(68, '2014_06_24_003011_add_suppliers', 1),
(69, '2014_06_24_010742_add_supplier_id_to_asset', 1),
(70, '2014_06_24_012839_add_zip_to_supplier', 1),
(71, '2014_06_24_033908_add_url_to_supplier', 1),
(72, '2014_07_08_054116_add_employee_id_to_users', 1),
(73, '2014_07_09_134316_add_requestable_to_assets', 1),
(74, '2014_07_17_085822_add_asset_to_software', 1),
(75, '2014_07_17_161625_make_asset_id_in_logs_nullable', 1),
(76, '2014_08_12_053504_alpha_0_4_2_release', 1),
(77, '2014_08_17_083523_make_location_id_nullable', 1),
(78, '2014_10_16_200626_add_rtd_location_to_assets', 1),
(79, '2014_10_24_000417_alter_supplier_state_to_32', 1),
(80, '2014_10_24_015641_add_display_checkout_date', 1),
(81, '2014_10_28_222654_add_avatar_field_to_users_table', 1),
(82, '2014_10_29_045924_add_image_field_to_models_table', 1),
(83, '2014_11_01_214955_add_eol_display_to_settings', 1),
(84, '2014_11_04_231416_update_group_field_for_reporting', 1),
(85, '2014_11_05_212408_add_fields_to_licenses', 1),
(86, '2014_11_07_021042_add_image_to_supplier', 1),
(87, '2014_11_20_203007_add_username_to_user', 1),
(88, '2014_11_20_223947_add_auto_to_settings', 1),
(89, '2014_11_20_224421_add_prefix_to_settings', 1),
(90, '2014_11_21_104401_change_licence_type', 1),
(91, '2014_12_09_082500_add_fields_maintained_term_to_licenses', 1),
(92, '2015_02_04_155757_increase_user_field_lengths', 1),
(93, '2015_02_07_013537_add_soft_deleted_to_log', 1),
(94, '2015_02_10_040958_fix_bad_assigned_to_ids', 1),
(95, '2015_02_10_053310_migrate_data_to_new_statuses', 1),
(96, '2015_02_11_044104_migrate_make_license_assigned_null', 1),
(97, '2015_02_11_104406_migrate_create_requests_table', 1),
(98, '2015_02_12_001312_add_mac_address_to_asset', 1),
(99, '2015_02_12_024100_change_license_notes_type', 1),
(100, '2015_02_17_231020_add_localonly_to_settings', 1),
(101, '2015_02_19_222322_add_logo_and_colors_to_settings', 1),
(102, '2015_02_24_072043_add_alerts_to_settings', 1),
(103, '2015_02_25_022931_add_eula_fields', 1),
(104, '2015_02_25_204513_add_accessories_table', 1),
(105, '2015_02_26_091228_add_accessories_user_table', 1),
(106, '2015_02_26_115128_add_deleted_at_models', 1),
(107, '2015_02_26_233005_add_category_type', 1),
(108, '2015_03_01_231912_update_accepted_at_to_acceptance_id', 1),
(109, '2015_03_05_011929_add_qr_type_to_settings', 1),
(110, '2015_03_18_055327_add_note_to_user', 1),
(111, '2015_04_29_234704_add_slack_to_settings', 1),
(112, '2015_05_04_085151_add_parent_id_to_locations_table', 1),
(113, '2015_05_22_124421_add_reassignable_to_licenses', 1),
(114, '2015_06_10_003314_fix_default_for_user_notes', 1),
(115, '2015_06_10_003554_create_consumables', 1),
(116, '2015_06_15_183253_move_email_to_username', 1),
(117, '2015_06_23_070346_make_email_nullable', 1),
(118, '2015_06_26_213716_create_asset_maintenances_table', 1),
(119, '2015_07_04_212443_create_custom_fields_table', 1),
(120, '2015_07_09_014359_add_currency_to_settings_and_locations', 1),
(121, '2015_07_21_122022_add_expected_checkin_date_to_asset_logs', 1),
(122, '2015_07_24_093845_add_checkin_email_to_category_table', 1),
(123, '2015_07_25_055415_remove_email_unique_constraint', 1),
(124, '2015_07_29_230054_add_thread_id_to_asset_logs_table', 1),
(125, '2015_07_31_015430_add_accepted_to_assets', 1),
(126, '2015_09_09_195301_add_custom_css_to_settings', 1),
(127, '2015_09_21_235926_create_custom_field_custom_fieldset', 1),
(128, '2015_09_22_000104_create_custom_fieldsets', 1),
(129, '2015_09_22_003321_add_fieldset_id_to_assets', 1),
(130, '2015_09_22_003413_migrate_mac_address', 1),
(131, '2015_09_28_003314_fix_default_purchase_order', 1),
(132, '2015_10_01_024551_add_accessory_consumable_price_info', 1),
(133, '2015_10_12_192706_add_brand_to_settings', 1),
(134, '2015_10_22_003314_fix_defaults_accessories', 1),
(135, '2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets', 1),
(136, '2015_11_05_061015_create_companies_table', 1),
(137, '2015_11_05_061115_add_company_id_to_consumables_table', 1),
(138, '2015_11_05_183749_add_image_to_assets', 1),
(139, '2015_11_06_092038_add_company_id_to_accessories_table', 1),
(140, '2015_11_06_100045_add_company_id_to_users_table', 1),
(141, '2015_11_06_134742_add_company_id_to_licenses_table', 1),
(142, '2015_11_08_035832_add_company_id_to_assets_table', 1),
(143, '2015_11_08_222305_add_ldap_fields_to_settings', 1),
(144, '2015_11_15_151803_add_full_multiple_companies_support_to_settings_table', 1),
(145, '2015_11_26_195528_import_ldap_settings', 1),
(146, '2015_11_30_191504_remove_fk_company_id', 1),
(147, '2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table', 1),
(148, '2015_12_30_233509_add_timestamp_and_userId_to_custom_fields', 1),
(149, '2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets', 1),
(150, '2016_01_28_041048_add_notes_to_models', 1),
(151, '2016_02_19_070119_add_remember_token_to_users_table', 1),
(152, '2016_02_19_073625_create_password_resets_table', 1),
(153, '2016_03_02_193043_add_ldap_flag_to_users', 1),
(154, '2016_03_02_220517_update_ldap_filter_to_longer_field', 1),
(155, '2016_03_08_225351_create_components_table', 1),
(156, '2016_03_09_024038_add_min_stock_to_tables', 1),
(157, '2016_03_10_133849_add_locale_to_users', 1),
(158, '2016_03_10_135519_add_locale_to_settings', 1),
(159, '2016_03_11_185621_add_label_settings_to_settings', 1),
(160, '2016_03_22_125911_fix_custom_fields_regexes', 1),
(161, '2016_04_28_141554_add_show_to_users', 1),
(162, '2016_05_16_164733_add_model_mfg_to_consumable', 1),
(163, '2016_05_19_180351_add_alt_barcode_settings', 1),
(164, '2016_05_19_191146_add_alter_interval', 1),
(165, '2016_05_19_192226_add_inventory_threshold', 1),
(166, '2016_05_20_024859_remove_option_keys_from_settings_table', 1),
(167, '2016_05_20_143758_remove_option_value_from_settings_table', 1),
(168, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(169, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(170, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(171, '2016_06_01_000004_create_oauth_clients_table', 1),
(172, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(173, '2016_06_01_140218_add_email_domain_and_format_to_settings', 1),
(174, '2016_06_22_160725_add_user_id_to_maintenances', 1),
(175, '2016_07_13_150015_add_is_ad_to_settings', 1),
(176, '2016_07_14_153609_add_ad_domain_to_settings', 1),
(177, '2016_07_22_003348_fix_custom_fields_regex_stuff', 1),
(178, '2016_07_22_054850_one_more_mac_addr_fix', 1),
(179, '2016_07_22_143045_add_port_to_ldap_settings', 1),
(180, '2016_07_22_153432_add_tls_to_ldap_settings', 1),
(181, '2016_07_27_211034_add_zerofill_to_settings', 1),
(182, '2016_08_02_124944_add_color_to_statuslabel', 1),
(183, '2016_08_04_134500_add_disallow_ldap_pw_sync_to_settings', 1),
(184, '2016_08_09_002225_add_manufacturer_to_licenses', 1),
(185, '2016_08_12_121613_add_manufacturer_to_accessories_table', 1),
(186, '2016_08_23_143353_add_new_fields_to_custom_fields', 1),
(187, '2016_08_23_145619_add_show_in_nav_to_status_labels', 1),
(188, '2016_08_30_084634_make_purchase_cost_nullable', 1),
(189, '2016_09_01_141051_add_requestable_to_asset_model', 1),
(190, '2016_09_02_001448_create_checkout_requests_table', 1),
(191, '2016_09_04_180400_create_actionlog_table', 1),
(192, '2016_09_04_182149_migrate_asset_log_to_action_log', 1),
(193, '2016_09_19_235935_fix_fieldtype_for_target_type', 1),
(194, '2016_09_23_140722_fix_modelno_in_consumables_to_string', 1),
(195, '2016_09_28_231359_add_company_to_logs', 1),
(196, '2016_10_14_130709_fix_order_number_to_varchar', 1),
(197, '2016_10_16_015024_rename_modelno_to_model_number', 1),
(198, '2016_10_16_015211_rename_consumable_modelno_to_model_number', 1),
(199, '2016_10_16_143235_rename_model_note_to_notes', 1),
(200, '2016_10_16_165052_rename_component_total_qty_to_qty', 1),
(201, '2016_10_19_145520_fix_order_number_in_components_to_string', 1),
(202, '2016_10_27_151715_add_serial_to_components', 1),
(203, '2016_10_27_213251_increase_serial_field_capacity', 1),
(204, '2016_10_29_002724_enable_2fa_fields', 1),
(205, '2016_10_29_082408_add_signature_to_acceptance', 1),
(206, '2016_11_01_030818_fix_forgotten_filename_in_action_logs', 1),
(207, '2016_11_13_020954_rename_component_serial_number_to_serial', 1),
(208, '2016_11_16_172119_increase_purchase_cost_size', 1),
(209, '2016_11_17_161317_longer_state_field_in_location', 1),
(210, '2016_11_17_193706_add_model_number_to_accessories', 1),
(211, '2016_11_24_160405_add_missing_target_type_to_logs_table', 1),
(212, '2016_12_07_173720_increase_size_of_state_in_suppliers', 1),
(213, '2016_12_19_004212_adjust_locale_length_to_10', 1),
(214, '2016_12_19_133936_extend_phone_lengths_in_supplier_and_elsewhere', 1),
(215, '2016_12_27_212631_make_asset_assigned_to_polymorphic', 1),
(216, '2017_01_09_040429_create_locations_ldap_query_field', 1),
(217, '2017_01_14_002418_create_imports_table', 1),
(218, '2017_01_25_063357_fix_utf8_custom_field_column_names', 1),
(219, '2017_03_03_154632_add_time_date_display_to_settings', 1),
(220, '2017_03_10_210807_add_fields_to_manufacturer', 1),
(221, '2017_05_08_195520_increase_size_of_field_values_in_custom_fields', 1),
(222, '2017_05_22_204422_create_departments', 1),
(223, '2017_05_22_233509_add_manager_to_locations_table', 1),
(224, '2017_06_14_122059_add_next_autoincrement_to_settings', 1),
(225, '2017_06_18_151753_add_header_and_first_row_to_importer_table', 1),
(226, '2017_07_07_191533_add_login_text', 1),
(227, '2017_07_25_130710_add_thumbsize_to_settings', 1),
(228, '2017_08_03_160105_set_asset_archived_to_zero_default', 1),
(229, '2017_08_22_180636_add_secure_password_options', 1),
(230, '2017_08_25_074822_add_auditing_tables', 1),
(231, '2017_08_25_101435_add_auditing_to_settings', 1),
(232, '2017_09_18_225619_fix_assigned_type_not_being_nulled', 1),
(233, '2017_10_03_015503_drop_foreign_keys', 1),
(234, '2017_10_10_123504_allow_nullable_depreciation_id_in_models', 1),
(235, '2017_10_17_133709_add_display_url_to_settings', 1),
(236, '2017_10_19_120002_add_custom_forgot_password_url', 1),
(237, '2017_10_19_130406_add_image_and_supplier_to_accessories', 1),
(238, '2017_10_20_234129_add_location_indices_to_assets', 1),
(239, '2017_10_25_202930_add_images_uploads_to_locations_manufacturers_etc', 1),
(240, '2017_10_27_180947_denorm_asset_locations', 1),
(241, '2017_10_27_192423_migrate_denormed_asset_locations', 1),
(242, '2017_10_30_182938_add_address_to_user', 1),
(243, '2017_11_08_025918_add_alert_menu_setting', 1),
(244, '2017_11_08_123942_labels_display_company_name', 1),
(245, '2017_12_12_010457_normalize_asset_last_audit_date', 1),
(246, '2017_12_12_033618_add_actionlog_meta', 1),
(247, '2017_12_26_170856_re_normalize_last_audit', 1),
(248, '2018_01_17_184354_add_archived_in_list_setting', 1),
(249, '2018_01_19_203121_add_dashboard_message_to_settings', 1),
(250, '2018_01_24_062633_add_footer_settings_to_settings', 1),
(251, '2018_01_24_093426_add_modellist_preferenc', 1),
(252, '2018_02_22_160436_add_remote_user_settings', 1),
(253, '2018_03_03_011032_add_theme_to_settings', 1),
(254, '2018_03_06_054937_add_default_flag_on_statuslabels', 1),
(255, '2018_03_23_212048_add_display_in_email_to_custom_fields', 1),
(256, '2018_03_24_030738_add_show_images_in_email_setting', 1),
(257, '2018_03_24_050108_add_cc_alerts', 1),
(258, '2018_03_29_053618_add_canceled_at_and_fulfilled_at_in_requests', 1),
(259, '2018_03_29_070121_add_drop_unique_requests', 1),
(260, '2018_03_29_070511_add_new_index_requestable', 1),
(261, '2018_04_02_150700_labels_display_model_name', 1),
(262, '2018_04_16_133902_create_custom_field_default_values_table', 1),
(263, '2018_05_04_073223_add_category_to_licenses', 1),
(264, '2018_05_04_075235_add_update_license_category', 1),
(265, '2018_05_08_031515_add_gdpr_privacy_footer', 1),
(266, '2018_05_14_215229_add_indexes', 1),
(267, '2018_05_14_223646_add_indexes_to_assets', 1),
(268, '2018_05_14_233638_denorm_counters_on_assets', 1),
(269, '2018_05_16_153409_add_first_counter_totals_to_assets', 1),
(270, '2018_06_21_134622_add_version_footer', 1),
(271, '2018_07_05_215440_add_unique_serial_option_to_settings', 1),
(272, '2018_07_17_005911_create_login_attempts_table', 1),
(273, '2018_07_24_154348_add_logo_to_print_assets', 1),
(274, '2018_07_28_023826_create_checkout_acceptances_table', 1),
(275, '2018_08_20_204842_add_depreciation_option_to_settings', 1),
(276, '2018_09_10_082212_create_checkout_acceptances_for_unaccepted_assets', 1),
(277, '2018_10_18_191228_add_kits_licenses_table', 1),
(278, '2018_10_19_153910_add_kits_table', 1),
(279, '2018_10_19_154013_add_kits_models_table', 1),
(280, '2018_12_05_211936_add_favicon_to_settings', 1),
(281, '2018_12_05_212119_add_email_logo_to_settings', 1),
(282, '2019_02_07_185953_add_kits_consumables_table', 1),
(283, '2019_02_07_190030_add_kits_accessories_table', 1),
(284, '2019_02_12_182750_add_actiondate_to_actionlog', 1),
(285, '2019_02_14_154310_change_auto_increment_prefix_to_nullable', 1),
(286, '2019_02_16_143518_auto_increment_back_to_string', 1),
(287, '2019_02_17_205048_add_label_logo_to_settings', 1),
(288, '2019_02_20_234421_make_serial_nullable', 1),
(289, '2019_02_21_224703_make_fields_nullable_for_integrity', 1),
(290, '2019_04_06_060145_add_user_skin_setting', 1),
(291, '2019_04_06_205355_add_setting_allow_user_skin', 1),
(292, '2019_06_12_184327_rename_groups_table', 1),
(293, '2019_07_23_140906_add_show_assigned_assets_to_settings', 1),
(294, '2019_08_20_084049_add_custom_remote_user_header', 1),
(295, '2019_12_04_223111_passport_upgrade', 1),
(296, '2020_02_04_172100_add_ad_append_domain_settings', 1),
(297, '2020_04_29_222305_add_saml_fields_to_settings', 1),
(298, '2020_08_11_200712_add_saml_key_rollover', 1),
(299, '2020_10_22_233743_move_accessory_checkout_note_to_join_table', 1),
(300, '2020_10_23_161736_fix_zero_values_for_locations', 1),
(301, '2020_11_18_214827_widen_license_serial_field', 1),
(302, '2020_12_14_233815_add_digit_separator_to_settings', 1),
(303, '2020_12_18_090026_swap_target_type_index_order', 1),
(304, '2020_12_21_153235_update_min_password', 1),
(305, '2020_12_21_210105_fix_bad_ldap_server_url_for_v5', 1),
(306, '2021_02_05_172502_add_provider_to_oauth_table', 1),
(307, '2021_03_18_184102_adds_several_ldap_fields', 1),
(308, '2021_04_07_001811_add_ldap_dept', 1),
(309, '2021_04_14_180125_add_ids_to_tables', 1),
(310, '2021_06_07_155421_add_serial_number_indexes', 1),
(311, '2021_06_07_155436_add_company_id_indexes', 1),
(312, '2021_07_28_031345_add_client_side_l_d_a_p_cert_to_settings', 1),
(313, '2021_07_28_040554_add_client_side_l_d_a_p_key_to_settings', 1),
(314, '2021_08_11_005206_add_depreciation_minimum_value', 1),
(315, '2021_08_24_124354_make_ldap_client_certs_nullable', 1),
(316, '2021_09_20_183216_change_default_label_to_nullable', 1),
(317, '2021_12_27_151849_change_supplier_address_length', 1),
(318, '2022_01_10_182548_add_license_id_index_to_license_seats', 1),
(319, '2022_02_03_214958_blank_out_ldap_active_flag', 1),
(320, '2022_02_16_152431_add_unique_constraint_to_custom_field', 1),
(321, '2022_03_03_225655_add_notes_to_accessories', 1),
(322, '2022_03_03_225754_add_notes_to_components', 1),
(323, '2022_03_03_225824_add_notes_to_consumables', 1),
(324, '2022_03_04_080836_add_remote_to_user', 1),
(325, '2022_03_09_001334_add_eula_to_checkout_acceptance', 1),
(326, '2022_03_10_175740_add_eula_to_action_logs', 1),
(327, '2022_03_21_162724_adds_ldap_manager', 1),
(328, '2022_04_05_135340_add_primary_key_to_custom_fields_pivot', 1),
(329, '2022_05_16_235350_remove_stored_eula_field', 1),
(330, '2022_06_23_164407_add_user_id_to_users', 1),
(331, '2022_06_28_234539_add_username_index_to_users', 1),
(332, '2022_07_07_010406_add_indexes_to_license_seats', 1),
(333, '2022_08_10_141328_add_notes_denorm_to_consumables_users', 1),
(334, '2022_08_25_213308_adds_ldap_default_group_to_settings_table', 1),
(335, '2022_09_29_040231_add_chart_type_to_settings', 1),
(336, '2022_10_05_163044_add_start_termination_date_to_users', 1),
(337, '2022_10_25_193823_add_externalid_to_users', 1),
(338, '2022_10_25_215520_add_label2_settings', 1),
(339, '2022_11_07_134348_add_display_to_user_in_custom_fields', 1),
(340, '2022_11_15_232525_adds_should_autoassign_bool_to_users_table', 1),
(341, '2022_12_20_171851_fix_nullable_migration_for_settings', 1),
(342, '2023_01_18_122534_add_byod_to_assets', 1),
(343, '2023_01_21_225350_add_eol_date_on_assets_table', 1),
(344, '2023_01_23_232933_add_vip_to_users', 1),
(345, '2023_02_12_224353_fix_unescaped_customfields_format', 1),
(346, '2023_02_28_173527_adds_webhook_option_to_settings_table', 1),
(347, '2023_03_21_215218_update_slack_setting', 1),
(348, '2023_04_12_135822_add_supplier_to_components', 1),
(349, '2023_04_25_085912_add_autoadd_to_customfields', 1),
(350, '2023_04_25_181817_adds_ldap_location_to_settings_table', 1),
(351, '2023_04_26_160235_add_warranty_url_to_manufacturers', 1),
(352, '2023_05_08_132921_increase_state_to_more_than_3', 1),
(353, '2023_05_10_001836_add_google_auth_to_settings', 1),
(354, '2023_07_05_092237_change_settings_table_increase_saml_idp_metadata_size', 1),
(355, '2023_07_06_092507_add_phone_fax_to_locations', 1),
(356, '2023_07_13_052204_denormalized_eol_and_add_column_for_explicit_date_to_assets', 1),
(357, '2023_07_14_004221_add_show_in_list_view_to_custom_fields', 1),
(358, '2023_08_01_174150_change_webhook_settings_variable_type', 1),
(359, '2023_08_13_172600_add_email_to_companies', 1),
(360, '2023_08_17_202638_add_last_checkin_to_assets', 1),
(361, '2023_08_21_064609_add_name_ordering_to_settings', 1),
(362, '2023_08_21_181742_add_min_amt_to_models_table', 1),
(363, '2023_09_13_200913_fix_asset_model_min_qty_nullability', 1),
(364, '2023_10_25_064324_add_show_in_requestable_to_custom_fields', 1),
(365, '2023_12_14_032522_add_remote_ip_and_action_source_to_action_logs', 1),
(366, '2023_12_15_024643_add_indexes_to_new_activity_report_fields', 1),
(367, '2023_12_19_081112_fix_language_dirs', 1),
(368, '2024_01_24_145544_create_saml_nonce_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_models`
--

DROP TABLE IF EXISTS `stzl_models`;
CREATE TABLE IF NOT EXISTS `stzl_models` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amt` int DEFAULT NULL,
  `manufacturer_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `depreciation_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `eol` int DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deprecated_mac_address` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fieldset_id` int DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `requestable` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_models`
--

INSERT INTO `stzl_models` (`id`, `name`, `model_number`, `min_amt`, `manufacturer_id`, `category_id`, `created_at`, `updated_at`, `depreciation_id`, `user_id`, `eol`, `image`, `deprecated_mac_address`, `deleted_at`, `fieldset_id`, `notes`, `requestable`) VALUES
(1, 'Mesin dan Peralatan', NULL, NULL, NULL, 2, '2024-02-27 15:32:29', '2024-02-27 15:32:29', NULL, 1, NULL, NULL, 0, NULL, 2, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_models_custom_fields`
--

DROP TABLE IF EXISTS `stzl_models_custom_fields`;
CREATE TABLE IF NOT EXISTS `stzl_models_custom_fields` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_model_id` int NOT NULL,
  `custom_field_id` int NOT NULL,
  `default_value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_oauth_access_tokens`
--

DROP TABLE IF EXISTS `stzl_oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `stzl_oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_oauth_access_tokens`
--

INSERT INTO `stzl_oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('af15b23fadbde752bc62995d8aecd6ba19dcfb6ea9bddefb165eb377949eb2e659d5237cb1c5ccf7', 1, 1, 'aaa', '[]', 1, '2024-02-28 03:29:42', '2024-02-28 03:29:42', '2039-02-28 10:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_oauth_auth_codes`
--

DROP TABLE IF EXISTS `stzl_oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `stzl_oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_oauth_clients`
--

DROP TABLE IF EXISTS `stzl_oauth_clients`;
CREATE TABLE IF NOT EXISTS `stzl_oauth_clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_oauth_clients`
--

INSERT INTO `stzl_oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Snipe-IT Personal Access Client', 'kak2LASbCdi0nLQU1mFPR8zMnZUCQMGRQldwGGBc', NULL, 'http://localhost', 1, 0, 0, '2024-02-27 15:05:44', '2024-02-27 15:05:44'),
(2, NULL, 'Snipe-IT Password Grant Client', 'hIdCJHHxQUXZeS7kh1OMCCapwcbRC3QM1QTJWGm9', 'users', 'http://localhost', 0, 1, 0, '2024-02-27 15:05:44', '2024-02-27 15:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `stzl_oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `stzl_oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_oauth_personal_access_clients`
--

INSERT INTO `stzl_oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-02-27 15:05:44', '2024-02-27 15:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `stzl_oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `stzl_oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_password_resets`
--

DROP TABLE IF EXISTS `stzl_password_resets`;
CREATE TABLE IF NOT EXISTS `stzl_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_pemasukan`
--

DROP TABLE IF EXISTS `stzl_pemasukan`;
CREATE TABLE IF NOT EXISTS `stzl_pemasukan` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `assets_id` int NOT NULL COMMENT 'realasi ke table assets',
  `tipe_dokumen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_daftar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `nomor_pemasukan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pemasukan` date NOT NULL,
  `nama_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_kategori_barang` int NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_barang` int NOT NULL,
  `entry_status` enum('l','tl') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'l->lengkap, tl->tidak lengkap',
  `status_sending` enum('a','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'a->active, n->nonactive',
  `datetime_sending` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_pemasukan`
--

INSERT INTO `stzl_pemasukan` (`id`, `assets_id`, `tipe_dokumen`, `nomor_daftar`, `tanggal_daftar`, `nomor_pemasukan`, `tanggal_pemasukan`, `nama_pengirim`, `kode_barang`, `kategori_barang`, `nomor_kategori_barang`, `nama_barang`, `satuan_barang`, `jumlah_barang`, `entry_status`, `status_sending`, `datetime_sending`, `created_at`, `updated_at`) VALUES
(2, 1, 'sda', '123', '2024-04-02', '1234', '2024-04-18', 'MGPA', 'LOGPN-000001', 'Mesin dan Peralatan', 5, 'Urban Concept Car Prototype Qatar Foundation', 'PCE', 2, 'l', 'n', '2024-04-19 02:39:49', '2024-04-18 19:39:49', '2024-04-18 19:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_pengeluaran`
--

DROP TABLE IF EXISTS `stzl_pengeluaran`;
CREATE TABLE IF NOT EXISTS `stzl_pengeluaran` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int NOT NULL COMMENT 'realasi ke table assets',
  `kode_kegiatan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npwp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nib` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_dokument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_daftar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `nomor_pengeluaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `nama_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_kategori_barang` int NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_barang` int NOT NULL,
  `entry_status` enum('l','tl') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'l->lengkap, tl->tidak lengkap',
  `status_sending` enum('a','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'a->active, n->nonactive',
  `datetime_sending` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_permission_groups`
--

DROP TABLE IF EXISTS `stzl_permission_groups`;
CREATE TABLE IF NOT EXISTS `stzl_permission_groups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_perusahaan`
--

DROP TABLE IF EXISTS `stzl_perusahaan`;
CREATE TABLE IF NOT EXISTS `stzl_perusahaan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `perusahaan_nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan_npwp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan_nib` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL,
  `create_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_perusahaan`
--

INSERT INTO `stzl_perusahaan` (`id`, `perusahaan_nama`, `perusahaan_npwp`, `perusahaan_nib`, `updated_at`, `create_at`) VALUES
(1, '', '902280312915000', '9120305192426', '2024-04-20 06:41:36', '2024-04-20 06:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_requested_assets`
--

DROP TABLE IF EXISTS `stzl_requested_assets`;
CREATE TABLE IF NOT EXISTS `stzl_requested_assets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int NOT NULL,
  `user_id` int NOT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `denied_at` datetime DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_requests`
--

DROP TABLE IF EXISTS `stzl_requests`;
CREATE TABLE IF NOT EXISTS `stzl_requests` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `request_code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_saml_nonces`
--

DROP TABLE IF EXISTS `stzl_saml_nonces`;
CREATE TABLE IF NOT EXISTS `stzl_saml_nonces` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nonce` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `not_valid_after` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `saml_nonces_nonce_index` (`nonce`),
  KEY `saml_nonces_not_valid_after_index` (`not_valid_after`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_settings`
--

DROP TABLE IF EXISTS `stzl_settings`;
CREATE TABLE IF NOT EXISTS `stzl_settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `per_page` int NOT NULL DEFAULT '20',
  `site_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Snipe IT Asset Management',
  `qr_code` int DEFAULT NULL,
  `qr_text` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_asset_name` int DEFAULT NULL,
  `display_checkout_date` int DEFAULT NULL,
  `display_eol` int DEFAULT NULL,
  `auto_increment_assets` int NOT NULL DEFAULT '0',
  `auto_increment_prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `load_remote` tinyint(1) NOT NULL DEFAULT '1',
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alert_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alerts_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `default_eula_text` longtext COLLATE utf8mb4_unicode_ci,
  `barcode_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'QRCODE',
  `webhook_endpoint` text COLLATE utf8mb4_unicode_ci,
  `webhook_channel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webhook_botname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webhook_selected` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'slack',
  `default_currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_css` text COLLATE utf8mb4_unicode_ci,
  `brand` tinyint NOT NULL DEFAULT '1',
  `ldap_enabled` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_server` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_uname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_pword` longtext COLLATE utf8mb4_unicode_ci,
  `ldap_basedn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_default_group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_filter` text COLLATE utf8mb4_unicode_ci,
  `ldap_username_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'samaccountname',
  `ldap_lname_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'sn',
  `ldap_fname_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'givenname',
  `ldap_auth_filter_query` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'uid=',
  `ldap_version` int DEFAULT '3',
  `ldap_active_flag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_dept` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_emp_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_phone_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_jobtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_manager` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_multiple_companies_support` tinyint(1) NOT NULL DEFAULT '0',
  `ldap_server_cert_ignore` tinyint(1) NOT NULL DEFAULT '0',
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT 'en-US',
  `labels_per_page` tinyint NOT NULL DEFAULT '30',
  `labels_width` decimal(6,5) NOT NULL DEFAULT '2.62500',
  `labels_height` decimal(6,5) NOT NULL DEFAULT '1.00000',
  `labels_pmargin_left` decimal(6,5) NOT NULL DEFAULT '0.21975',
  `labels_pmargin_right` decimal(6,5) NOT NULL DEFAULT '0.21975',
  `labels_pmargin_top` decimal(6,5) NOT NULL DEFAULT '0.50000',
  `labels_pmargin_bottom` decimal(6,5) NOT NULL DEFAULT '0.50000',
  `labels_display_bgutter` decimal(6,5) NOT NULL DEFAULT '0.07000',
  `labels_display_sgutter` decimal(6,5) NOT NULL DEFAULT '0.05000',
  `labels_fontsize` tinyint NOT NULL DEFAULT '9',
  `labels_pagewidth` decimal(7,5) NOT NULL DEFAULT '8.50000',
  `labels_pageheight` decimal(7,5) NOT NULL DEFAULT '11.00000',
  `labels_display_name` tinyint NOT NULL DEFAULT '0',
  `labels_display_serial` tinyint NOT NULL DEFAULT '1',
  `labels_display_tag` tinyint NOT NULL DEFAULT '1',
  `alt_barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'C128',
  `alt_barcode_enabled` tinyint(1) DEFAULT '1',
  `alert_interval` int DEFAULT '30',
  `alert_threshold` int DEFAULT '5',
  `name_display_format` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'first_last',
  `email_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_format` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'filastname',
  `username_format` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'filastname',
  `is_ad` tinyint(1) NOT NULL DEFAULT '0',
  `ad_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_port` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '389',
  `ldap_tls` tinyint(1) NOT NULL DEFAULT '0',
  `zerofill_count` int NOT NULL DEFAULT '5',
  `ldap_pw_sync` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_enabled` tinyint DEFAULT NULL,
  `require_accept_signature` tinyint(1) NOT NULL DEFAULT '0',
  `date_display_format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y-m-d',
  `time_display_format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'h:i A',
  `next_auto_tag_base` bigint NOT NULL DEFAULT '1',
  `login_note` text COLLATE utf8mb4_unicode_ci,
  `thumbnail_max_h` int DEFAULT '50',
  `pwd_secure_uncommon` tinyint(1) NOT NULL DEFAULT '0',
  `pwd_secure_complexity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pwd_secure_min` int NOT NULL DEFAULT '8',
  `audit_interval` int DEFAULT NULL,
  `audit_warning_days` int DEFAULT NULL,
  `show_url_in_emails` tinyint(1) NOT NULL DEFAULT '0',
  `custom_forgot_pass_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_alerts_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `labels_display_company_name` tinyint(1) NOT NULL DEFAULT '0',
  `show_archived_in_list` tinyint(1) NOT NULL DEFAULT '0',
  `dashboard_message` text COLLATE utf8mb4_unicode_ci,
  `support_footer` char(5) COLLATE utf8mb4_unicode_ci DEFAULT 'on',
  `footer_text` text COLLATE utf8mb4_unicode_ci,
  `modellist_displays` char(191) COLLATE utf8mb4_unicode_ci DEFAULT 'image,category,manufacturer,model_number',
  `login_remote_user_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `login_common_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `login_remote_user_custom_logout_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `skin` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_images_in_email` tinyint(1) NOT NULL DEFAULT '1',
  `admin_cc_email` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `labels_display_model` tinyint(1) NOT NULL DEFAULT '0',
  `privacy_policy_link` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_footer` char(5) COLLATE utf8mb4_unicode_ci DEFAULT 'on',
  `unique_serial` tinyint(1) NOT NULL DEFAULT '0',
  `logo_print_assets` tinyint(1) NOT NULL DEFAULT '0',
  `depreciation_method` char(10) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `favicon` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_logo` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_logo` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_user_skin` tinyint(1) NOT NULL DEFAULT '0',
  `show_assigned_assets` tinyint(1) NOT NULL DEFAULT '0',
  `login_remote_user_header_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ad_append_domain` tinyint(1) NOT NULL DEFAULT '0',
  `saml_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `saml_idp_metadata` mediumtext COLLATE utf8mb4_unicode_ci,
  `saml_attr_mapping_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saml_forcelogin` tinyint(1) NOT NULL DEFAULT '0',
  `saml_slo` tinyint(1) NOT NULL DEFAULT '0',
  `saml_sp_x509cert` text COLLATE utf8mb4_unicode_ci,
  `saml_sp_privatekey` text COLLATE utf8mb4_unicode_ci,
  `saml_custom_settings` text COLLATE utf8mb4_unicode_ci,
  `saml_sp_x509certNew` text COLLATE utf8mb4_unicode_ci,
  `digit_separator` char(191) COLLATE utf8mb4_unicode_ci DEFAULT '1,234.56',
  `ldap_client_tls_cert` text COLLATE utf8mb4_unicode_ci,
  `ldap_client_tls_key` text COLLATE utf8mb4_unicode_ci,
  `dash_chart_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'name',
  `label2_enable` tinyint(1) NOT NULL DEFAULT '0',
  `label2_template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'DefaultLabel',
  `label2_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label2_asset_logo` tinyint(1) NOT NULL DEFAULT '0',
  `label2_1d_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `label2_2d_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `label2_2d_target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hardware_id',
  `label2_fields` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'name=name;serial=serial;model=model.name;',
  `google_login` tinyint(1) DEFAULT '0',
  `google_client_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_client_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_settings`
--

INSERT INTO `stzl_settings` (`id`, `created_at`, `updated_at`, `user_id`, `per_page`, `site_name`, `qr_code`, `qr_text`, `display_asset_name`, `display_checkout_date`, `display_eol`, `auto_increment_assets`, `auto_increment_prefix`, `load_remote`, `logo`, `header_color`, `alert_email`, `alerts_enabled`, `default_eula_text`, `barcode_type`, `webhook_endpoint`, `webhook_channel`, `webhook_botname`, `webhook_selected`, `default_currency`, `custom_css`, `brand`, `ldap_enabled`, `ldap_server`, `ldap_uname`, `ldap_pword`, `ldap_basedn`, `ldap_default_group`, `ldap_filter`, `ldap_username_field`, `ldap_lname_field`, `ldap_fname_field`, `ldap_auth_filter_query`, `ldap_version`, `ldap_active_flag`, `ldap_dept`, `ldap_emp_num`, `ldap_email`, `ldap_phone_field`, `ldap_jobtitle`, `ldap_manager`, `ldap_country`, `ldap_location`, `full_multiple_companies_support`, `ldap_server_cert_ignore`, `locale`, `labels_per_page`, `labels_width`, `labels_height`, `labels_pmargin_left`, `labels_pmargin_right`, `labels_pmargin_top`, `labels_pmargin_bottom`, `labels_display_bgutter`, `labels_display_sgutter`, `labels_fontsize`, `labels_pagewidth`, `labels_pageheight`, `labels_display_name`, `labels_display_serial`, `labels_display_tag`, `alt_barcode`, `alt_barcode_enabled`, `alert_interval`, `alert_threshold`, `name_display_format`, `email_domain`, `email_format`, `username_format`, `is_ad`, `ad_domain`, `ldap_port`, `ldap_tls`, `zerofill_count`, `ldap_pw_sync`, `two_factor_enabled`, `require_accept_signature`, `date_display_format`, `time_display_format`, `next_auto_tag_base`, `login_note`, `thumbnail_max_h`, `pwd_secure_uncommon`, `pwd_secure_complexity`, `pwd_secure_min`, `audit_interval`, `audit_warning_days`, `show_url_in_emails`, `custom_forgot_pass_url`, `show_alerts_in_menu`, `labels_display_company_name`, `show_archived_in_list`, `dashboard_message`, `support_footer`, `footer_text`, `modellist_displays`, `login_remote_user_enabled`, `login_common_disabled`, `login_remote_user_custom_logout_url`, `skin`, `show_images_in_email`, `admin_cc_email`, `labels_display_model`, `privacy_policy_link`, `version_footer`, `unique_serial`, `logo_print_assets`, `depreciation_method`, `favicon`, `email_logo`, `label_logo`, `allow_user_skin`, `show_assigned_assets`, `login_remote_user_header_name`, `ad_append_domain`, `saml_enabled`, `saml_idp_metadata`, `saml_attr_mapping_username`, `saml_forcelogin`, `saml_slo`, `saml_sp_x509cert`, `saml_sp_privatekey`, `saml_custom_settings`, `saml_sp_x509certNew`, `digit_separator`, `ldap_client_tls_cert`, `ldap_client_tls_key`, `dash_chart_type`, `label2_enable`, `label2_template`, `label2_title`, `label2_asset_logo`, `label2_1d_type`, `label2_2d_type`, `label2_2d_target`, `label2_fields`, `google_login`, `google_client_id`, `google_client_secret`) VALUES
(1, '2024-02-28 05:05:26', '2024-04-20 12:56:48', 1, 20, 'MGPA Inventory', 1, NULL, NULL, NULL, NULL, 0, NULL, 1, NULL, '#f10b2c', 'admin@indocdn.my.id', 1, NULL, 'DATAMATRIX', NULL, NULL, NULL, 'slack', 'USD', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'samaccountname', 'sn', 'givenname', 'uid=', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'en-US', 30, '2.62500', '1.00000', '0.21975', '0.21975', '0.50000', '0.50000', '0.07000', '0.05000', 9, '8.50000', '11.00000', 0, 1, 1, 'C128', 0, 30, 5, 'first_last', 'snipe-it.indocdn.my.id', 'filastname', 'filastname', 0, NULL, '389', 0, 5, 1, NULL, 0, 'Y-m-d', 'h:i A', 74, NULL, 50, 0, NULL, 10, NULL, NULL, 0, NULL, 1, 0, 0, NULL, 'on', NULL, 'image,category,manufacturer,model_number', 0, 0, '', 'black', 1, NULL, 0, NULL, 'on', 0, 0, 'default', NULL, NULL, NULL, 0, 0, '', 0, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, '1,234.56', NULL, NULL, 'name', 0, 'DefaultLabel', NULL, 0, 'default', 'default', 'hardware_id', 'name=name;serial=serial;model=model.name;', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_status_labels`
--

DROP TABLE IF EXISTS `stzl_status_labels`;
CREATE TABLE IF NOT EXISTS `stzl_status_labels` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deployable` tinyint(1) NOT NULL DEFAULT '0',
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_in_nav` tinyint(1) DEFAULT '0',
  `default_label` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_status_labels`
--

INSERT INTO `stzl_status_labels` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `deployable`, `pending`, `archived`, `notes`, `color`, `show_in_nav`, `default_label`) VALUES
(1, 'Pending', 1, NULL, NULL, NULL, 0, 1, 0, 'These assets are not yet ready to be deployed, usually because of configuration or waiting on parts.', NULL, 0, 0),
(2, 'Available', 1, NULL, '2024-04-19 09:35:09', NULL, 1, 0, 0, 'These assets are ready to deploy.', '#aa3399', 0, 0),
(3, 'Archived', 1, NULL, NULL, NULL, 0, 0, 1, 'These assets are no longer in circulation or viable.', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_stock_opname`
--

DROP TABLE IF EXISTS `stzl_stock_opname`;
CREATE TABLE IF NOT EXISTS `stzl_stock_opname` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asset_id` int NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `kode_barang` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_barang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_kategori_barang` int NOT NULL,
  `nama_barang` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_barang` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_barang` int NOT NULL,
  `harga_total_barang` int NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_dokumen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_dokumen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dokumen` date NOT NULL,
  `status_kirim` enum('S','B') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime_sending` datetime NOT NULL,
  `jumlah_barang_sebelumnya` int NOT NULL,
  `selisih_barang` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_stock_opname`
--

INSERT INTO `stzl_stock_opname` (`id`, `asset_id`, `tanggal_pelaksanaan`, `kode_barang`, `kategori_barang`, `nomor_kategori_barang`, `nama_barang`, `satuan_barang`, `jumlah_barang`, `harga_total_barang`, `keterangan`, `kode_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `status_kirim`, `datetime_sending`, `jumlah_barang_sebelumnya`, `selisih_barang`, `created_at`, `updated_at`) VALUES
(3, 9, '2024-04-24', 'data tes', 'bahan penolong', 2, 'data untuk testing', 'PCE', 5, 5000, 'gudang', '0407632', '100/opname', '2024-04-24', 'B', '0000-00-00 00:00:00', 5, 0, '2024-04-20 11:30:10', '2024-04-20 11:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_suppliers`
--

DROP TABLE IF EXISTS `stzl_suppliers`;
CREATE TABLE IF NOT EXISTS `stzl_suppliers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_throttle`
--

DROP TABLE IF EXISTS `stzl_throttle`;
CREATE TABLE IF NOT EXISTS `stzl_throttle` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` int NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stzl_transaksi_adjusment`
--

DROP TABLE IF EXISTS `stzl_transaksi_adjusment`;
CREATE TABLE IF NOT EXISTS `stzl_transaksi_adjusment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaksi_nomor` int NOT NULL,
  `transaksi_ket` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_transaksi_adjusment`
--

INSERT INTO `stzl_transaksi_adjusment` (`id`, `transaksi_nomor`, `transaksi_ket`, `created_at`, `updated_at`) VALUES
(1, 1, 'Adjusment 1', '2024-04-20 19:43:43', '2024-04-20 19:43:43'),
(2, 2, 'Adjusment 2', '2024-04-20 12:58:46', '2024-04-20 12:58:46'),
(3, 3, 'Adjusment 3', '2024-04-20 13:01:18', '2024-04-20 13:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_transaksi_pemasukan`
--

DROP TABLE IF EXISTS `stzl_transaksi_pemasukan`;
CREATE TABLE IF NOT EXISTS `stzl_transaksi_pemasukan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaksi_nomor` int NOT NULL,
  `transaksi_ket` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_transaksi_pemasukan`
--

INSERT INTO `stzl_transaksi_pemasukan` (`id`, `transaksi_nomor`, `transaksi_ket`, `updated_at`, `created_at`) VALUES
(1, 1, 'Pemasukan 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 2, 'Pemasukan 2', '2024-04-20 02:00:22', '2024-04-20 02:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_transaksi_pengeluaran`
--

DROP TABLE IF EXISTS `stzl_transaksi_pengeluaran`;
CREATE TABLE IF NOT EXISTS `stzl_transaksi_pengeluaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaksi_nomor` int NOT NULL,
  `transaksi_ket` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_transaksi_pengeluaran`
--

INSERT INTO `stzl_transaksi_pengeluaran` (`id`, `transaksi_nomor`, `transaksi_ket`, `updated_at`, `created_at`) VALUES
(6, 1, 'Pengeluaran 1', '2024-04-19 20:53:13', '2024-04-19 20:53:13'),
(7, 2, 'Pengeluaran 2', '2024-04-20 02:05:25', '2024-04-20 02:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_transaksi_stockopname`
--

DROP TABLE IF EXISTS `stzl_transaksi_stockopname`;
CREATE TABLE IF NOT EXISTS `stzl_transaksi_stockopname` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaksi_nomor` int NOT NULL,
  `transaksi_ket` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_transaksi_stockopname`
--

INSERT INTO `stzl_transaksi_stockopname` (`id`, `transaksi_nomor`, `transaksi_ket`, `created_at`, `updated_at`) VALUES
(1, 1, 'Stockopname 1', '2024-04-20 18:48:29', '2024-04-20 18:48:29'),
(2, 2, 'Stockopname 2', '2024-04-20 12:08:30', '2024-04-20 12:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `stzl_users`
--

DROP TABLE IF EXISTS `stzl_users`;
CREATE TABLE IF NOT EXISTS `stzl_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `activation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jobtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `employee_num` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `company_id` int UNSIGNED DEFAULT NULL,
  `remember_token` text COLLATE utf8mb4_unicode_ci,
  `ldap_import` tinyint(1) NOT NULL DEFAULT '0',
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'en-US',
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_secret` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_enrolled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_optin` tinyint(1) NOT NULL DEFAULT '0',
  `department_id` int DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote` tinyint(1) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `scim_externalid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autoassign_licenses` tinyint(1) NOT NULL DEFAULT '1',
  `vip` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`),
  KEY `users_company_id_index` (`company_id`),
  KEY `users_username_deleted_at_index` (`username`,`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stzl_users`
--

INSERT INTO `stzl_users` (`id`, `email`, `password`, `permissions`, `activated`, `created_by`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`, `deleted_at`, `website`, `country`, `gravatar`, `location_id`, `phone`, `jobtitle`, `manager_id`, `employee_num`, `avatar`, `username`, `notes`, `company_id`, `remember_token`, `ldap_import`, `locale`, `show_in_list`, `two_factor_secret`, `two_factor_enrolled`, `two_factor_optin`, `department_id`, `address`, `city`, `state`, `zip`, `skin`, `remote`, `start_date`, `end_date`, `scim_externalid`, `autoassign_licenses`, `vip`) VALUES
(1, 'admin@indocdn.my.id', '$2y$10$gtPyBfrv0ELttXAz0QNeGelRwRuD.nLstNNPtBoskaSwSDdQYYK02', '{\"superuser\":1}', 1, NULL, NULL, NULL, '2024-03-06 00:04:43', NULL, NULL, 'System', 'Administrator', '2024-02-28 05:05:26', '2024-03-06 00:04:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, 'owLngMJ46dHKiRTNgeMTWbFmQQy7mym0LkWqwPBqZi4Bv6kPEcHICvZrSVIN', 0, 'en-US', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 0),
(2, 'fajri@gmail.com', '$2y$10$u8WlnBLPU/9L1lKZFjUoJu1pBfR02xq763FEAWptEZxKRW26rSF7u', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'fajri', 'muhamad', '2024-04-17 11:25:41', '2024-04-17 11:25:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fajri10', NULL, NULL, NULL, 0, 'en-US', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 0),
(4, 'reexport@gmail.com', '$2y$10$SSyHOqahWX2UK93sLdToqOY.hWa6MQyiJ3m9yjBLMEibSlxw8zvjW', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'reexport', NULL, '2024-04-19 09:26:38', '2024-04-19 09:26:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'reexport', NULL, 1, NULL, 0, 'en-US', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 0),
(5, 'dsipose@gmail.com', '$2y$10$796Lz7ZncOqlkOdAQvn64e32lbq4aEyjZ/kEyd39g3PqB.HwHhX2W', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'Dsipose', NULL, '2024-04-19 09:27:29', '2024-04-19 09:27:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dispose', NULL, 1, NULL, 0, 'en-US', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 0),
(6, NULL, '$2y$10$Yd3Z4YOgltRUP4lfNCSPs.KVHEJ4DZuKLzhgk8twYNbgL4kGk5.YG', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'Penjualan', NULL, '2024-04-19 09:32:09', '2024-04-19 09:32:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'penjualan', NULL, 1, NULL, 0, 'en-US', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stzl_users_groups`
--

DROP TABLE IF EXISTS `stzl_users_groups`;
CREATE TABLE IF NOT EXISTS `stzl_users_groups` (
  `user_id` int UNSIGNED NOT NULL,
  `group_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
