-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260424.57908919e4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2026 at 03:25 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `summit_wir`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('summit-wir-cache-bc33ea4e26e5e1af1408321416956113a4658763', 'i:1;', 1777210975),
('summit-wir-cache-bc33ea4e26e5e1af1408321416956113a4658763:timer', 'i:1777210975;', 1777210975),
('summit-wir-cache-f6e1126cedebf23e1463aee73f9df08783640400', 'i:1;', 1777121789),
('summit-wir-cache-f6e1126cedebf23e1463aee73f9df08783640400:timer', 'i:1777121789;', 1777121789);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(6, 1, 1, 1, '2026-04-25 05:45:26', '2026-04-25 05:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Tents', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(2, 'Backpacks', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(3, 'Cooking Gear', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(4, 'Clothing', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(5, 'Lighting', '2025-11-09 18:26:42', '2025-11-09 18:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_21_154635_create_categories_table', 1),
(5, '2025_09_21_154718_create_products_table', 1),
(6, '2025_09_21_154944_create_orders_table', 1),
(7, '2025_09_21_155058_create_order_details_table', 1),
(8, '2025_10_26_101205_create_cart_items_table', 1),
(9, '2026_04_26_140000_normalize_order_status_values', 2),
(10, '2026_04_26_154800_add_snap_token_to_orders_table', 3),
(11, '2026_04_26_000001_add_whatsapp_otp_to_users_table', 4),
(12, '2026_04_26_000002_add_whatsapp_receipt_sent_at_to_orders_table', 5),
(13, '2026_04_26_000003_add_whatsapp_receipt_send_attempted_at_to_orders_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `loan_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `duration` int NOT NULL,
  `total_price` bigint UNSIGNED NOT NULL,
  `total_fine` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_receipt_sent_at` timestamp NULL DEFAULT NULL,
  `whatsapp_receipt_send_attempted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `loan_date`, `return_date`, `duration`, `total_price`, `total_fine`, `status`, `snap_token`, `whatsapp_receipt_sent_at`, `whatsapp_receipt_send_attempted_at`, `created_at`, `updated_at`) VALUES
(37, NULL, '2026-04-26 05:26:51', '2026-04-27 05:26:51', 1, 85000, 0, 'completed', '6b72920e-d1ce-4df4-8ea7-1dfa1da156c1', NULL, NULL, '2026-04-25 22:25:54', '2026-04-25 22:28:20'),
(38, NULL, '2026-04-26 05:30:51', '2026-04-27 05:30:51', 1, 170000, 0, 'completed', '34547b47-04c6-4352-a088-601bb4ae82c4', NULL, NULL, '2026-04-25 22:29:56', '2026-04-25 22:52:54'),
(39, NULL, '2026-04-26 14:01:14', '2026-04-27 14:01:14', 1, 170000, 0, 'on_rent', '4e9fed7c-2ab4-4f2c-84d1-485fea17cc5d', NULL, NULL, '2026-04-26 07:00:35', '2026-04-26 07:01:14'),
(40, NULL, '2026-04-26 14:16:44', '2026-04-27 14:16:44', 1, 120000, 0, 'on_rent', '27ef99fa-bdf5-4fcb-9876-a578638e6e12', '2026-04-26 07:16:46', '2026-04-26 07:16:44', '2026-04-26 07:16:15', '2026-04-26 07:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `product_id`, `order_id`, `quantity`, `created_at`, `updated_at`) VALUES
(67, 1, 37, 1, '2026-04-25 22:25:54', '2026-04-25 22:25:54'),
(68, 3, 38, 1, '2026-04-25 22:29:56', '2026-04-25 22:29:56'),
(69, 3, 39, 1, '2026-04-26 07:00:35', '2026-04-26 07:00:35'),
(70, 2, 40, 1, '2026-04-26 07:16:15', '2026-04-26 07:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint UNSIGNED NOT NULL,
  `stock` int NOT NULL,
  `sold` int NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `sold`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Tents Item 1', 'Durable and reliable Tents item for mountain use.', 85000, 20, 1, 'products/ZZNuIsd2CXHW2Szx12jdmTrHIMjIJf0VdZpdbOf3.png', '2025-11-09 18:26:42', '2026-04-25 22:28:20', NULL),
(2, 1, 'Tents Item 2', 'Durable and reliable Tents item for mountain use.', 120000, 12, 1, 'products/1A8igU9PCLiEBRnIiwgHn4k2NhvmVq6jpqEGiKgC.png', '2025-11-09 18:26:42', '2026-04-26 07:16:44', NULL),
(3, 1, 'Tents Item 3', 'Durable and reliable Tents item for mountain use.', 170000, 18, 2, 'products/7VJzXQRnLi2Z15JzxQ14aIqgXTNV5uEPdmqPqdrM.png', '2025-11-09 18:26:42', '2026-04-26 07:01:14', NULL),
(4, 1, 'Tents Item 4', 'Durable and reliable Tents item for mountain use.', 250000, 16, 0, 'products/whbPnqhx2gLwU7dS8cmXZfoRhju7hZTeDcRM9KZq.png', '2025-11-09 18:26:42', '2026-04-25 21:51:21', NULL),
(5, 1, 'Tents Item 5', 'Durable and reliable Tents item for mountain use.', 142337, 15, 0, 'products/tents.jpg', '2025-11-09 18:26:42', '2026-04-25 20:54:39', '2026-04-25 20:54:39'),
(6, 1, 'Tents Item 6', 'Durable and reliable Tents item for mountain use.', 120031, 7, 0, 'products/tents.jpg', '2025-11-09 18:26:42', '2026-04-25 20:28:04', '2026-04-25 20:28:04'),
(7, 1, 'Tents Item 7', 'Durable and reliable Tents item for mountain use.', 133111, 11, 0, 'products/tents.jpg', '2025-11-09 18:26:42', '2026-04-25 20:28:00', '2026-04-25 20:28:00'),
(8, 1, 'Tents Item 8', 'Durable and reliable Tents item for mountain use.', 110414, 7, 0, 'products/tents.jpg', '2025-11-09 18:26:42', '2026-04-25 20:27:55', '2026-04-25 20:27:55'),
(9, 1, 'Tents Item 9', 'Durable and reliable Tents item for mountain use.', 79020, 11, 0, 'products/tents.jpg', '2025-11-09 18:26:42', '2026-04-25 20:27:50', '2026-04-25 20:27:50'),
(10, 1, 'Tents Item 10', 'Durable and reliable Tents item for mountain use.', 114343, 16, 0, 'products/tents.jpg', '2025-11-09 18:26:42', '2026-04-25 20:27:44', '2026-04-25 20:27:44'),
(11, 2, 'Backpacks Item 1', 'Durable and reliable Backpacks item for mountain use.', 100000, 11, 0, 'products/L6WKktOb35WEPXxHZWxZzSGfILndA7Eip6cCcSp3.png', '2025-11-09 18:26:42', '2026-04-25 21:51:45', NULL),
(12, 2, 'Backpacks Item 2', 'Durable and reliable Backpacks item for mountain use.', 150000, 9, 0, 'products/6xOjO2Ma7eLneyQOfzytaV06y0Swqc2ApeYcFQ2S.png', '2025-11-09 18:26:42', '2026-04-25 21:52:02', NULL),
(13, 2, 'Backpacks Item 3', 'Durable and reliable Backpacks item for mountain use.', 200000, 10, 1, 'products/Wt2iFhwVPcUeicjiHJ6YpblbviDnn9RaIbJYbRKp.png', '2025-11-09 18:26:42', '2026-04-25 22:24:35', NULL),
(14, 2, 'Backpacks Item 4', 'Durable and reliable Backpacks item for mountain use.', 250000, 14, 0, 'products/oEopqoeQ7Vqxja13ooQimSNkT4achZyt4wbA0etw.png', '2025-11-09 18:26:42', '2026-04-25 21:52:27', NULL),
(15, 2, 'Backpacks Item 5', 'Durable and reliable Backpacks item for mountain use.', 121846, 10, 0, 'products/backpacks.jpg', '2025-11-09 18:26:42', '2026-04-25 21:26:03', '2026-04-25 21:26:03'),
(16, 2, 'Backpacks Item 6', 'Durable and reliable Backpacks item for mountain use.', 108785, 7, 0, 'products/backpacks.jpg', '2025-11-09 18:26:42', '2026-04-25 21:26:08', '2026-04-25 21:26:08'),
(17, 2, 'Backpacks Item 7', 'Durable and reliable Backpacks item for mountain use.', 109164, 9, 0, 'products/backpacks.jpg', '2025-11-09 18:26:42', '2026-04-25 21:26:12', '2026-04-25 21:26:12'),
(18, 2, 'Backpacks Item 8', 'Durable and reliable Backpacks item for mountain use.', 149759, 9, 0, 'products/backpacks.jpg', '2025-11-09 18:26:42', '2026-04-25 21:26:17', '2026-04-25 21:26:17'),
(19, 2, 'Backpacks Item 9', 'Durable and reliable Backpacks item for mountain use.', 126532, 10, 0, 'products/backpacks.jpg', '2025-11-09 18:26:42', '2026-04-25 21:26:21', '2026-04-25 21:26:21'),
(20, 2, 'Backpacks Item 10', 'Durable and reliable Backpacks item for mountain use.', 88132, 10, 0, 'products/backpacks.jpg', '2025-11-09 18:26:42', '2026-04-25 21:26:26', '2026-04-25 21:26:26'),
(21, 3, 'Cooking Gear Item 1', 'Durable and reliable Cooking Gear item for mountain use.', 90000, 10, 0, 'products/KfQCQUMUMa5tbAqi1OGkF7tCoZg2YHBgryoz6Q6q.png', '2025-11-09 18:26:42', '2026-04-25 21:52:44', NULL),
(22, 3, 'Cooking Gear Item 2', 'Durable and reliable Cooking Gear item for mountain use.', 130000, 16, 0, 'products/iC0NFuf1Tl2jTNp4uGbgkera4Czq51VhNPY3bKFJ.png', '2025-11-09 18:26:42', '2026-04-25 21:53:03', NULL),
(23, 3, 'Cooking Gear Item 3', 'Durable and reliable Cooking Gear item for mountain use.', 149214, 15, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:32:16', '2026-04-25 21:32:16'),
(24, 3, 'Cooking Gear Item 4', 'Durable and reliable Cooking Gear item for mountain use.', 64385, 17, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:33:49', '2026-04-25 21:33:49'),
(25, 3, 'Cooking Gear Item 5', 'Durable and reliable Cooking Gear item for mountain use.', 89510, 9, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:33:57', '2026-04-25 21:33:57'),
(26, 3, 'Cooking Gear Item 6', 'Durable and reliable Cooking Gear item for mountain use.', 73876, 12, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:34:03', '2026-04-25 21:34:03'),
(27, 3, 'Cooking Gear Item 7', 'Durable and reliable Cooking Gear item for mountain use.', 147981, 15, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:34:10', '2026-04-25 21:34:10'),
(28, 3, 'Cooking Gear Item 8', 'Durable and reliable Cooking Gear item for mountain use.', 100390, 18, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:34:16', '2026-04-25 21:34:16'),
(29, 3, 'Cooking Gear Item 9', 'Durable and reliable Cooking Gear item for mountain use.', 126467, 7, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:34:22', '2026-04-25 21:34:22'),
(30, 3, 'Cooking Gear Item 10', 'Durable and reliable Cooking Gear item for mountain use.', 130308, 20, 0, 'products/cooking-gear.jpg', '2025-11-09 18:26:42', '2026-04-25 21:34:27', '2026-04-25 21:34:27'),
(31, 4, 'Clothing Item 1', 'Durable and reliable Clothing item for mountain use.', 110000, 10, 0, 'products/cyA5Acj52guMDAFqHqH5QkxVoJNwZFQqJB0AEAMG.png', '2025-11-09 18:26:42', '2026-04-25 21:53:36', NULL),
(32, 4, 'Clothing Item 2', 'Durable and reliable Clothing item for mountain use.', 150000, 13, 0, 'products/iZbULl9AGTZhBXEToBOb5mxja4eV3yzVuNm4aZyT.png', '2025-11-09 18:26:42', '2026-04-25 21:54:45', NULL),
(33, 4, 'Clothing Item 3', 'Durable and reliable Clothing item for mountain use.', 115093, 9, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:15', '2026-04-25 21:43:15'),
(34, 4, 'Clothing Item 4', 'Durable and reliable Clothing item for mountain use.', 79570, 8, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:21', '2026-04-25 21:43:21'),
(35, 4, 'Clothing Item 5', 'Durable and reliable Clothing item for mountain use.', 106138, 20, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:30', '2026-04-25 21:43:30'),
(36, 4, 'Clothing Item 6', 'Durable and reliable Clothing item for mountain use.', 134592, 13, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:08', '2026-04-25 21:43:08'),
(37, 4, 'Clothing Item 7', 'Durable and reliable Clothing item for mountain use.', 97555, 16, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:02', '2026-04-25 21:43:02'),
(38, 4, 'Clothing Item 8', 'Durable and reliable Clothing item for mountain use.', 113214, 13, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:42:55', '2026-04-25 21:42:55'),
(39, 4, 'Clothing Item 9', 'Durable and reliable Clothing item for mountain use.', 52120, 20, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:42:48', '2026-04-25 21:42:48'),
(40, 4, 'Clothing Item 10', 'Durable and reliable Clothing item for mountain use.', 62693, 15, 0, 'products/clothing.jpg', '2025-11-09 18:26:42', '2026-04-25 21:42:43', '2026-04-25 21:42:43'),
(41, 5, 'Lighting Item 1', 'Durable and reliable Lighting item for mountain use.', 50000, 14, 0, 'products/cyz0LVgY20seee9Gpw6dli0UNKeKtJvtYu9nu3I2.png', '2025-11-09 18:26:42', '2026-04-25 21:55:01', NULL),
(42, 5, 'Lighting Item 2', 'Durable and reliable Lighting item for mountain use.', 100000, 9, 0, 'products/cWjQllKwcXDfW8Z2SKNJV9H4sGybM7vxt3q9rypJ.png', '2025-11-09 18:26:42', '2026-04-25 21:55:20', NULL),
(43, 5, 'Lighting Item 3', 'Durable and reliable Lighting item for mountain use.', 134029, 14, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:49:31', '2026-04-25 21:49:31'),
(44, 5, 'Lighting Item 4', 'Durable and reliable Lighting item for mountain use.', 146539, 10, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:49:35', '2026-04-25 21:49:35'),
(45, 5, 'Lighting Item 5', 'Durable and reliable Lighting item for mountain use.', 148905, 16, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:49:40', '2026-04-25 21:49:40'),
(46, 5, 'Lighting Item 6', 'Durable and reliable Lighting item for mountain use.', 57355, 14, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:57', '2026-04-25 21:43:57'),
(47, 5, 'Lighting Item 7', 'Durable and reliable Lighting item for mountain use.', 82583, 11, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:50', '2026-04-25 21:43:50'),
(48, 5, 'Lighting Item 8', 'Durable and reliable Lighting item for mountain use.', 133572, 15, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:38', '2026-04-25 21:43:38'),
(49, 5, 'Lighting Item 9', 'Durable and reliable Lighting item for mountain use.', 119382, 17, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:43:44', '2026-04-25 21:43:44'),
(50, 5, 'Lighting Item 10', 'Durable and reliable Lighting item for mountain use.', 84046, 15, 0, 'products/lighting.jpg', '2025-11-09 18:26:42', '2026-04-25 21:41:06', '2026-04-25 21:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('vr5jx3nkVIyetr1ioF7bqbm1trB17uH6oJCDgKBj', 27, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWg1aXVVaGxUdlRRWFJMZDBiVXNta1JNdE1lMEM5bnZVSHdHUDQ0QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlL29yZGVycy9yZW50aW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjc7fQ==', 1777213054);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_otp` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_otp_expires_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `no_hp`, `ktp_image`, `whatsapp_otp`, `whatsapp_otp_expires_at`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2025-11-09 18:26:35', '$2y$12$Aq0feKFCKo4vwFbmHKqY3ubqJDb5F.IgLiKXmvBwEsL4Hg/Uy3L9e', '081234567890', 'ktp_images/ktp.jpg', NULL, NULL, 'user', NULL, '2025-11-09 18:26:35', '2026-04-26 19:57:26', '2026-04-26 19:57:26'),
(28, 'Sansline', 'rafiprovider4@gmail.com', '2026-04-26 19:48:50', '$2y$12$oDuk66vsSa7W0Ua9Xb3ITuZbtgdL4Aqr4XoCcZ.zS4e8n.vQSrWNC', '085774912005', NULL, NULL, NULL, 'admin', NULL, '2026-04-26 19:48:19', '2026-04-26 19:48:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
