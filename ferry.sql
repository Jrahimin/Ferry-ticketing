-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2017 at 04:42 AM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ferry`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_details` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `passenger_info` text COLLATE utf8mb4_unicode_ci,
  `seat_selected_departure` text COLLATE utf8mb4_unicode_ci,
  `seat_selected_destination` text COLLATE utf8mb4_unicode_ci,
  `collector_info` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `location`, `image_url`, `status`, `created_at`, `updated_at`, `deleted_at`, `telephone`, `account_number`) VALUES
(1, 'TourTrip Inernational Ferry Company', 'good', '10/L, Noya Paltan, Dhaka', 'images/company_logo/2380542d-25f6-4a2d-92c2-4372a6c4af1a.jpg', 1, '2017-12-05 23:20:14', '2017-12-05 23:20:14', NULL, '12345678901', '1532fbe6-e6ac-4d49-898f-293412b71a7d'),
(2, 'byteLab Family Tour', 'many', 'noya paltan masjid road, dhaka', 'images/company_logo/66d7f9a4-675d-4f40-9f03-aecb56370bbb.jpg', 1, '2017-12-05 23:20:44', '2017-12-05 23:20:44', NULL, '80970790790', '7ccf26aa-b0df-434d-abb4-89d7d9f241ca');

-- --------------------------------------------------------

--
-- Table structure for table `ferries`
--

DROP TABLE IF EXISTS `ferries`;
CREATE TABLE IF NOT EXISTS `ferries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_seat` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `captain_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_crew` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ferries`
--

INSERT INTO `ferries` (`id`, `name`, `image_url`, `number_of_seat`, `created_at`, `updated_at`, `deleted_at`, `status`, `captain_name`, `number_of_crew`, `company_id`) VALUES
(1, 'Large', 'images/ferry_logo/d3ed1279-4be3-4bb3-91d7-bfd946e92cc4.jpg', 250, '2017-12-05 23:21:28', '2017-12-05 23:21:28', NULL, 1, 'Amin', 25, 1),
(2, 'Heavy', 'images/ferry_logo/56fc0235-9713-4eff-b9ee-3ebb203be2ca.jpg', 300, '2017-12-10 22:22:06', '2017-12-10 22:22:06', NULL, 1, 'Alam', 22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_04_07_083602_add_different_usertype_column_to_users_table', 1),
(4, '2017_04_07_122516_set_staff_user_and_user_default', 1),
(5, '2017_04_10_044356_remove_differentUserField', 1),
(6, '2017_04_10_044810_add_field_role_to_user', 1),
(7, '2017_04_10_094221_softDeleting_to_users_table', 1),
(8, '2017_04_10_100218_removing_status_field', 1),
(9, '2017_04_11_054251_create_table_ferries', 1),
(10, '2017_04_11_061411_create_table_trips', 1),
(11, '2017_04_13_092008_deleteing_field_from_ferries_table', 1),
(12, '2017_04_13_092839_add_three_field_to_ferries_table', 1),
(13, '2017_04_17_040445_create_passenger_types_table', 1),
(14, '2017_04_17_061357_create_ports_table', 1),
(15, '2017_04_17_075414_drop_column_longitude_and_latitude_in_port_table', 1),
(16, '2017_04_17_075702_create_again_longitude_and_latitude_to_port_table', 1),
(17, '2017_04_17_081903_add_status_field_to_port', 1),
(18, '2017_04_17_082331_add_default_value_to_status_field_to_port_table', 1),
(19, '2017_04_17_084337_changing_two_fields_type_to_port_table', 1),
(20, '2017_04_17_092523_drop_field_status_for_field_type', 1),
(21, '2017_04_17_092712_to_make_status_field_tinyint_and_default_one', 1),
(22, '2017_04_17_105337_modifying_latitude_and_longitude', 1),
(23, '2017_04_17_110453_modifying_latitude_and_longitude_again', 1),
(24, '2017_04_18_034541_deleting_country_field_from_port_table', 1),
(25, '2017_04_18_083222_changing_length_country_code_to_ports_table', 1),
(26, '2017_04_19_082236_drop_name_field_from_trips', 1),
(27, '2017_04_19_082432_add_fields_to_trips_table', 1),
(28, '2017_04_19_095654_trips_table_creation_with_fields', 1),
(29, '2017_04_19_104040_create_passenger_price', 1),
(30, '2017_04_19_120750_add_id_in_Trip_passenger_price', 1),
(31, '2017_04_27_085001_create_settings_table', 1),
(32, '2017_05_20_005809_create_company_table', 1),
(33, '2017_05_22_182041_add_telephone_and_account_number_to_company_table', 1),
(34, '2017_05_22_183112_add_company_id_to_users_table', 1),
(35, '2017_05_22_190735_add_company_id_to_ferry_table', 1),
(36, '2017_05_22_190954_add_company_id_to_trip_table', 1),
(37, '2017_05_30_192003_create_cart_details_table', 1),
(38, '2017_05_30_202145_deleting_column_of_cart_details', 1),
(39, '2017_05_30_202724_drop_card_details_table', 1),
(40, '2017_05_30_210043_create_cart_table', 1),
(41, '2017_06_01_230522_add_column_updated_cart_details', 1),
(42, '2017_06_02_002913_add_column_in_cart_table', 1),
(43, '2017_06_02_003725_drop_updaetd_cart_details_from_cart_table', 1),
(44, '2017_08_10_192905_add_field_ferry_seat_and_remaining_seat_in_trip_table', 1),
(45, '2017_08_11_165919_create_customer_table', 1),
(46, '2017_08_11_183645_create_tickets_table', 1),
(47, '2017_08_11_193534_add_field_customer_table', 1),
(48, '2017_08_11_234746_change_table_name', 1),
(49, '2017_08_28_214805_add_field_to_order', 1),
(50, '2017_09_28_084001_rename_price_id_to_price_in_trip_passenger_price_table', 1),
(51, '2017_09_28_084433_change_int_float_price_in_trip_passenger_price_table', 1),
(52, '2017_12_06_060653_create_passengers_table', 2),
(53, '2017_12_06_103813_add_field_to_passengers', 3),
(54, '2017_12_08_034904_add_deleted_at_to_tickets', 4),
(56, '2017_12_11_050656_add_price_to_tickets', 5),
(57, '2017_12_12_053506_add_code_to_passengers', 6),
(58, '2017_12_12_063624_add_code_to_passenger', 7),
(59, '2017_12_13_042626_add_order_id_to_tickets', 8),
(60, '2017_12_13_043702_create_order_new', 9),
(61, '2017_12_13_045221_create_orders_table_fresh', 10),
(62, '2017_12_13_070640_add_company_id_to_tickets', 11),
(63, '2017_12_14_054600_add_order_type_trip_to_orders', 12),
(64, '2017_12_14_080812_add_depart_destination_to_orders', 13),
(65, '2017_12_14_105046_add_soft_delete_to_passengers', 14),
(66, '2016_06_01_000001_create_oauth_auth_codes_table', 15),
(67, '2016_06_01_000002_create_oauth_access_tokens_table', 15),
(68, '2016_06_01_000003_create_oauth_refresh_tokens_table', 15),
(69, '2016_06_01_000004_create_oauth_clients_table', 15),
(70, '2016_06_01_000005_create_oauth_personal_access_clients_table', 15),
(72, '2017_12_27_044809_add_checked_to_ticket', 16),
(73, '2017_12_27_063738_change_field_trips', 17),
(74, '2017_12_27_100516_add_dateTime_tickets', 18);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('810e4b710b365bd8e27a403d761c51f10dcf7a6e1684794af18d051b90ca8bb17a5e69cbf2f392e1', 2, 1, 'MyApp', '[]', 0, '2017-12-26 22:38:32', '2017-12-26 22:38:32', '2018-12-27 04:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Ferry Ticketing Personal Access Client', 'LyIYJNqA3X2beW6U6hD8UiMTKScd4uWXQdRo0cLY', 'http://localhost', 1, 0, 0, '2017-12-26 22:32:43', '2017-12-26 22:32:43'),
(2, NULL, 'Ferry Ticketing Password Grant Client', 'cMNR4VE6ET6knbdWB97xMfBx3S4ZoHyUmPaLOyju', 'http://localhost', 0, 1, 0, '2017-12-26 22:32:44', '2017-12-26 22:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2017-12-26 22:32:44', '2017-12-26 22:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `trip_type` int(10) UNSIGNED NOT NULL,
  `departure_trip_id` int(10) UNSIGNED NOT NULL,
  `return_trip_id` int(10) UNSIGNED DEFAULT NULL,
  `departure_port_id` int(10) UNSIGNED NOT NULL,
  `destination_port_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `email`, `contact_no`, `created_at`, `updated_at`, `deleted_at`, `trip_type`, `departure_trip_id`, `return_trip_id`, `departure_port_id`, `destination_port_id`) VALUES
(1, 'algrims@gmail.com', '08097097809809', '2017-12-27 04:26:16', '2017-12-27 04:26:16', NULL, 2, 63, 70, 1, 2),
(2, 'algrims@gmail.com', '00997716554', '2017-12-27 04:26:48', '2017-12-27 04:26:48', NULL, 2, 63, 70, 1, 2),
(3, 'algrims@gmail.com', '00997716554', '2017-12-27 04:27:52', '2017-12-27 04:27:52', NULL, 2, 63, 70, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

DROP TABLE IF EXISTS `passengers`;
CREATE TABLE IF NOT EXISTS `passengers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `nationality` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_exp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `name`, `gender`, `dob`, `nationality`, `passport_no`, `passport_exp`, `ticket_id`, `created_at`, `updated_at`, `type_id`, `code`, `deleted_at`) VALUES
(1, 'jamil', 'Male', '2017-12-03', 'bangladeshi', '112121212111', '2018-01-01', 1, '2017-12-27 04:26:48', '2017-12-27 04:26:48', 2, '1:9dUY2Cq7ydSuycGMgjW9', NULL),
(2, 'jamil', 'Male', '2017-12-03', 'bangladeshi', '112121212111', '2018-01-01', 2, '2017-12-27 04:27:52', '2017-12-27 04:27:52', 2, '2:D92qdLaZFq9YAyZF8dcd', NULL),
(3, 'jamil', 'Male', '2017-12-03', 'bangladeshi', '112121212111', '2018-01-01', 3, '2017-12-27 04:27:52', '2017-12-27 04:27:52', 2, '3:rkOhfEjuakbyxBtCmqXQ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `passenger_types`
--

DROP TABLE IF EXISTS `passenger_types`;
CREATE TABLE IF NOT EXISTS `passenger_types` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passenger_types`
--

INSERT INTO `passenger_types` (`id`, `created_at`, `updated_at`, `name`, `status`, `deleted_at`) VALUES
(1, '2017-12-05 23:17:20', '2017-12-05 23:17:20', 'Adult', 1, NULL),
(2, '2017-12-05 23:17:25', '2017-12-05 23:17:25', 'Child', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

DROP TABLE IF EXISTS `ports`;
CREATE TABLE IF NOT EXISTS `ports` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `latitude` double(30,20) NOT NULL,
  `longitude` double(30,20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ports`
--

INSERT INTO `ports` (`id`, `city_name`, `name`, `country_code`, `created_at`, `updated_at`, `deleted_at`, `status`, `latitude`, `longitude`) VALUES
(1, 'chittagong', 'Any', 'BD', '2017-12-05 23:16:40', '2017-12-05 23:16:40', NULL, 1, 40.73145630034573000000, -73.82459320105659000000),
(2, 'Dhaka', 'double', 'BD', '2017-12-05 23:16:55', '2017-12-05 23:16:55', NULL, 1, 40.73015547855510000000, -73.82073082007514000000);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `depart_from` int(10) UNSIGNED NOT NULL,
  `arrive_at` int(10) UNSIGNED NOT NULL,
  `trip_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `price` double NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  `departure_date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `depart_from`, `arrive_at`, `trip_id`, `created_at`, `updated_at`, `deleted_at`, `price`, `order_id`, `company_id`, `checked`, `departure_date_time`) VALUES
(1, 1, 2, 63, '2017-12-27 04:26:48', '2017-12-27 04:26:48', NULL, 450, 2, 1, 0, '2017-12-28 09:30:00'),
(2, 1, 2, 63, '2017-12-27 04:27:52', '2017-12-27 04:27:52', NULL, 450, 3, 1, 0, '2017-12-28 09:30:00'),
(3, 2, 1, 70, '2017-12-27 04:27:52', '2017-12-27 04:27:52', NULL, 400, 3, 2, 0, '2017-12-29 08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
CREATE TABLE IF NOT EXISTS `trips` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departure_port_id` int(11) NOT NULL,
  `destination_port_id` int(11) NOT NULL,
  `ferry_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `ferry_total_seat` int(11) NOT NULL,
  `ferry_remaining_seat` int(11) NOT NULL,
  `departure_date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `departure_port_id`, `destination_port_id`, `ferry_id`, `created_at`, `updated_at`, `deleted_at`, `company_id`, `ferry_total_seat`, `ferry_remaining_seat`, `departure_date_time`) VALUES
(62, 1, 2, 1, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 1, 250, 250, '2017-12-27 09:30:00'),
(63, 1, 2, 1, '2017-12-27 03:07:56', '2017-12-27 04:27:52', NULL, 1, 250, 248, '2017-12-28 09:30:00'),
(64, 1, 2, 1, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 1, 250, 250, '2017-12-29 09:30:00'),
(65, 1, 2, 1, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 1, 250, 250, '2017-12-30 09:30:00'),
(66, 1, 2, 1, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 1, 250, 250, '2017-12-31 09:30:00'),
(67, 1, 2, 1, '2017-12-27 03:09:12', '2017-12-27 03:09:12', NULL, 1, 250, 250, '2017-12-27 11:50:00'),
(68, 2, 1, 2, '2017-12-27 03:50:43', '2017-12-27 03:50:43', NULL, 2, 300, 300, '2017-12-27 08:30:00'),
(69, 2, 1, 2, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 2, 300, 300, '2017-12-28 08:30:00'),
(70, 2, 1, 2, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 2, 300, 300, '2017-12-29 08:30:00'),
(71, 2, 1, 2, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 2, 300, 300, '2017-12-30 08:30:00'),
(72, 2, 1, 2, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 2, 300, 300, '2017-12-31 08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `trip_passenger_price`
--

DROP TABLE IF EXISTS `trip_passenger_price`;
CREATE TABLE IF NOT EXISTS `trip_passenger_price` (
  `passenger_type_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `trip_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trip_passenger_price`
--

INSERT INTO `trip_passenger_price` (`passenger_type_id`, `price`, `trip_id`, `created_at`, `updated_at`, `deleted_at`, `id`) VALUES
(2, 400, 72, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 228),
(1, 650, 72, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 227),
(2, 400, 71, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 226),
(1, 650, 71, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 225),
(2, 400, 70, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 224),
(1, 650, 70, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 223),
(2, 400, 69, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 222),
(1, 650, 69, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 221),
(2, 400, 68, '2017-12-27 03:50:44', '2017-12-27 03:50:44', NULL, 220),
(1, 650, 68, '2017-12-27 03:50:43', '2017-12-27 03:50:43', NULL, 219),
(2, 350, 67, '2017-12-27 03:09:12', '2017-12-27 03:09:12', NULL, 218),
(1, 600, 67, '2017-12-27 03:09:12', '2017-12-27 03:09:12', NULL, 217),
(2, 450, 66, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 216),
(1, 600, 66, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 215),
(2, 450, 65, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 214),
(1, 600, 65, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 213),
(2, 450, 64, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 212),
(1, 600, 64, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 211),
(2, 450, 63, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 210),
(1, 600, 63, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 209),
(2, 450, 62, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 208),
(1, 600, 62, '2017-12-27 03:07:56', '2017-12-27 03:07:56', NULL, 207),
(2, 400, 61, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 206),
(1, 600, 61, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 205),
(2, 400, 60, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 204),
(1, 600, 60, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 203),
(2, 400, 59, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 202),
(1, 600, 59, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 201),
(2, 400, 58, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 200),
(1, 600, 58, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 199),
(2, 400, 57, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 198),
(1, 600, 57, '2017-12-26 23:08:26', '2017-12-26 23:08:26', NULL, 197),
(2, 300, 56, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 196),
(1, 500, 56, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 195),
(2, 300, 55, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 194),
(1, 500, 55, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 193),
(2, 300, 54, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 192),
(1, 500, 54, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 191),
(2, 300, 53, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 190),
(1, 500, 53, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 189),
(2, 300, 52, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 188),
(1, 500, 52, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 187),
(2, 300, 51, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 186),
(1, 500, 51, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 185),
(2, 300, 50, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 184),
(1, 500, 50, '2017-12-18 21:45:22', '2017-12-18 21:45:22', NULL, 183),
(2, 20, 49, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 182),
(1, 50, 49, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 181),
(2, 20, 48, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 180),
(1, 50, 48, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 179),
(2, 20, 47, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 178),
(1, 50, 47, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 177),
(2, 20, 46, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 176),
(1, 50, 46, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 175),
(2, 20, 45, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 174),
(1, 50, 45, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 173),
(2, 20, 44, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 172),
(1, 50, 44, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 171),
(2, 20, 43, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 170),
(1, 50, 43, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 169),
(2, 20, 42, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 168),
(1, 50, 42, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 167),
(2, 20, 41, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 166),
(1, 50, 41, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 165),
(2, 20, 40, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 164),
(1, 50, 40, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 163),
(2, 20, 39, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 162),
(1, 50, 39, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 161),
(2, 20, 38, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 160),
(1, 50, 38, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 159),
(2, 20, 37, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 158),
(1, 50, 37, '2017-12-18 07:09:22', '2017-12-18 07:09:22', NULL, 157),
(1, 600, 1, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 85),
(2, 400, 1, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 86),
(1, 600, 2, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 87),
(2, 400, 2, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 88),
(1, 600, 3, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 89),
(2, 400, 3, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 90),
(1, 600, 4, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 91),
(2, 400, 4, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 92),
(1, 600, 5, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 93),
(2, 400, 5, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 94),
(1, 600, 6, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 95),
(2, 400, 6, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 96),
(1, 600, 7, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 97),
(2, 400, 7, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 98),
(1, 600, 8, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 99),
(2, 400, 8, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 100),
(1, 600, 9, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 101),
(2, 400, 9, '2017-12-16 21:50:26', '2017-12-16 21:50:26', NULL, 102),
(1, 650, 10, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 103),
(2, 450, 10, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 104),
(1, 650, 11, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 105),
(2, 450, 11, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 106),
(1, 650, 12, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 107),
(2, 450, 12, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 108),
(1, 650, 13, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 109),
(2, 450, 13, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 110),
(1, 650, 14, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 111),
(2, 450, 14, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 112),
(1, 650, 15, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 113),
(2, 450, 15, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 114),
(1, 650, 16, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 115),
(2, 450, 16, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 116),
(1, 650, 17, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 117),
(2, 450, 17, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 118),
(1, 650, 18, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 119),
(2, 450, 18, '2017-12-16 21:51:03', '2017-12-16 21:51:03', NULL, 120),
(1, 550, 19, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 121),
(2, 380, 19, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 122),
(1, 550, 20, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 123),
(2, 380, 20, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 124),
(1, 550, 21, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 125),
(2, 380, 21, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 126),
(1, 550, 22, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 127),
(2, 380, 22, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 128),
(1, 550, 23, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 129),
(2, 380, 23, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 130),
(1, 550, 24, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 131),
(2, 380, 24, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 132),
(1, 550, 25, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 133),
(2, 380, 25, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 134),
(1, 550, 26, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 135),
(2, 380, 26, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 136),
(1, 550, 27, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 137),
(2, 380, 27, '2017-12-16 21:52:18', '2017-12-16 21:52:18', NULL, 138),
(1, 620, 28, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 139),
(2, 440, 28, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 140),
(1, 620, 29, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 141),
(2, 440, 29, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 142),
(1, 620, 30, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 143),
(2, 440, 30, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 144),
(1, 620, 31, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 145),
(2, 440, 31, '2017-12-16 21:53:03', '2017-12-16 21:53:03', NULL, 146),
(1, 620, 32, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 147),
(2, 440, 32, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 148),
(1, 620, 33, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 149),
(2, 440, 33, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 150),
(1, 620, 34, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 151),
(2, 440, 34, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 152),
(1, 620, 35, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 153),
(2, 440, 35, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 154),
(1, 620, 36, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 155),
(2, 440, 36, '2017-12-16 21:53:04', '2017-12-16 21:53:04', NULL, 156);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `deleted_at`, `company_id`) VALUES
(1, 'saif', 'sai@gmail.com', '$2y$10$zzHEJUPGInFWF2AQ7Lex..OFu9X/orQqwyg43UEd6oL1xwgc5Uura', 'M759fxKtxOGjJ11feRpOvQXt4t8KYLOatSm8n0MiAH37Dsk3Bzl7CTgo7PX2', '2017-12-05 23:12:27', '2017-12-05 23:12:27', 1, NULL, 1),
(2, 'Rahimin', 'jr@gmail.com', '$2y$10$8ijH.8f26CNIqv5SBZlqqufvzNAOGDA/E82sKplRI809mowFaYLM.', 'pAqHLXk9PqAQSdQz8KJhojaAHYhjSCAlVayVEdWIWE9mqHbFxBfWxFyPtt4S', '2017-12-06 21:52:09', '2017-12-06 21:52:09', 1, NULL, 1),
(3, 'Abdul', 'abc@gmail.com', '$2y$10$1pkEJm4jvzn0bodAd7a4EuSSPE2MaKzvXRo5SgMVoUN3.Sm6Y2y6a', 'sSgQmPQ5HanrAjV4ug5sLvgOo5tqalfQlujZ597vzn2He23QeIkGzfLVcvfe', '2017-12-13 03:02:56', '2017-12-13 03:02:56', 3, NULL, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
