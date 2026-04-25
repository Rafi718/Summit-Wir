-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2026 at 03:01 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.26

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
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(8, '2025_10_26_101205_create_cart_items_table', 1);

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
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `loan_date`, `return_date`, `duration`, `total_price`, `total_fine`, `status`, `created_at`, `updated_at`) VALUES
(1, 14, '2025-11-05 01:26:42', '2025-11-07 01:26:42', 2, 875094, 0, 'pending', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(2, 13, '2025-11-06 01:26:42', '2025-11-08 01:26:42', 2, 751831, 0, 'pending', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(3, 20, '2025-11-07 01:26:42', '2025-11-11 01:26:42', 4, 402087, 0, 'pending', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(4, 13, '2025-11-09 01:26:42', '2025-11-14 01:26:42', 5, 446715, 0, 'pending', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(5, 21, '2025-10-31 01:26:42', '2025-11-03 01:26:42', 3, 212276, 0, 'pending', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(6, 4, '2025-11-04 01:26:42', '2025-11-08 01:26:42', 4, 859843, 0, 'confirmed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(7, 11, '2025-11-06 01:26:42', '2025-11-10 01:26:42', 4, 663987, 0, 'confirmed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(8, 15, '2025-11-06 01:26:42', '2025-11-09 01:26:42', 3, 269184, 0, 'confirmed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(9, 8, '2025-11-08 01:26:42', '2025-11-12 01:26:42', 4, 600361, 0, 'confirmed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(10, 13, '2025-11-01 01:26:42', '2025-11-03 01:26:42', 2, 130308, 0, 'confirmed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(11, 3, '2025-11-04 01:26:42', '2025-11-09 01:26:42', 5, 299753, 0, 'on_rent', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(12, 8, '2025-11-08 01:26:42', '2025-11-11 01:26:42', 3, 624781, 0, 'on_rent', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(13, 4, '2025-11-09 01:26:42', '2025-11-14 01:26:42', 5, 400716, 0, 'on_rent', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(14, 18, '2025-11-05 01:26:42', '2025-11-08 01:26:42', 3, 341430, 0, 'on_rent', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(15, 12, '2025-11-02 01:26:42', '2025-11-07 01:26:42', 5, 695105, 0, 'on_rent', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(16, 19, '2025-11-01 01:26:42', '2025-11-04 01:26:42', 3, 505516, 0, 'cancelled', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(17, 3, '2025-11-09 01:26:42', '2025-11-14 01:26:42', 5, 461637, 0, 'cancelled', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(18, 15, '2025-11-08 01:26:42', '2025-11-10 01:26:42', 2, 221628, 0, 'cancelled', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(19, 21, '2025-11-06 01:26:42', '2025-11-10 01:26:42', 4, 739398, 0, 'cancelled', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(20, 18, '2025-11-01 01:26:42', '2025-11-05 01:26:42', 4, 83903, 0, 'cancelled', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(21, NULL, '2025-11-08 01:26:42', '2025-11-12 01:26:42', 4, 1016049, 14262, 'completed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(22, 3, '2025-10-31 01:26:42', '2025-11-05 01:26:42', 5, 334243, 2757, 'completed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(23, 9, '2025-11-07 01:26:42', '2025-11-09 01:26:42', 2, 416532, 18765, 'completed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(24, 21, '2025-11-04 01:26:42', '2025-11-06 01:26:42', 2, 237060, 9522, 'completed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(25, 13, '2025-11-01 01:26:42', '2025-11-04 01:26:42', 3, 377234, 18938, 'completed', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(26, 15, '2025-10-31 01:26:42', '2025-11-03 01:26:42', 3, 217570, 0, 'on_rent', '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(27, 4, NULL, NULL, 1, 169067, 0, 'pending', '2026-04-19 07:07:51', '2026-04-19 07:07:51'),
(28, 3, NULL, NULL, 1, 214450, 0, 'pending', '2026-04-19 07:48:01', '2026-04-19 07:48:01');

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
(1, 23, 1, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(2, 10, 1, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(3, 4, 1, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(4, 34, 2, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(5, 37, 2, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(6, 19, 2, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(7, 43, 3, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(8, 45, 4, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(9, 35, 5, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(10, 35, 5, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(11, 24, 6, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(12, 31, 6, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(13, 11, 6, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(14, 32, 7, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(15, 34, 7, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(16, 36, 8, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(17, 9, 9, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(18, 22, 9, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(19, 19, 9, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(20, 30, 10, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(21, 40, 11, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(22, 9, 11, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(23, 21, 12, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(24, 33, 12, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(25, 18, 12, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(26, 48, 13, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(27, 20, 14, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(28, 47, 14, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(29, 28, 15, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(30, 24, 15, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(31, 28, 15, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(32, 28, 16, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(33, 4, 16, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(34, 29, 16, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(35, 50, 17, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(36, 28, 17, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(37, 24, 17, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(38, 26, 18, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(39, 33, 19, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(40, 31, 19, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(41, 18, 19, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(42, 1, 20, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(43, 45, 21, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(44, 49, 21, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(45, 6, 21, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(46, 20, 22, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(47, 14, 22, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(48, 11, 23, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(49, 9, 24, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(50, 31, 25, 3, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(51, 40, 25, 1, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(52, 16, 26, 2, '2025-11-09 18:26:42', '2025-11-09 18:26:42'),
(53, 1, 27, 1, '2026-04-19 07:07:51', '2026-04-19 07:07:51'),
(54, 2, 27, 1, '2026-04-19 07:07:51', '2026-04-19 07:07:51'),
(55, 1, 28, 1, '2026-04-19 07:48:01', '2026-04-19 07:48:01'),
(56, 3, 28, 1, '2026-04-19 07:48:01', '2026-04-19 07:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint UNSIGNED NOT NULL,
  `stock` int NOT NULL,
  `sold` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `sold`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Tents Item 1', 'Durable and reliable Tents item for mountain use.', 83903, 20, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(2, 1, 'Tents Item 2', 'Durable and reliable Tents item for mountain use.', 85164, 13, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(3, 1, 'Tents Item 3', 'Durable and reliable Tents item for mountain use.', 130547, 19, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(4, 1, 'Tents Item 4', 'Durable and reliable Tents item for mountain use.', 77879, 16, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(5, 1, 'Tents Item 5', 'Durable and reliable Tents item for mountain use.', 142337, 15, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(6, 1, 'Tents Item 6', 'Durable and reliable Tents item for mountain use.', 120031, 7, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(7, 1, 'Tents Item 7', 'Durable and reliable Tents item for mountain use.', 133111, 11, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(8, 1, 'Tents Item 8', 'Durable and reliable Tents item for mountain use.', 110414, 7, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(9, 1, 'Tents Item 9', 'Durable and reliable Tents item for mountain use.', 79020, 11, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(10, 1, 'Tents Item 10', 'Durable and reliable Tents item for mountain use.', 114343, 16, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(11, 2, 'Backpacks Item 1', 'Durable and reliable Backpacks item for mountain use.', 138844, 11, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(12, 2, 'Backpacks Item 2', 'Durable and reliable Backpacks item for mountain use.', 58934, 9, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(13, 2, 'Backpacks Item 3', 'Durable and reliable Backpacks item for mountain use.', 118819, 11, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(14, 2, 'Backpacks Item 4', 'Durable and reliable Backpacks item for mountain use.', 82037, 14, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(15, 2, 'Backpacks Item 5', 'Durable and reliable Backpacks item for mountain use.', 121846, 10, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(16, 2, 'Backpacks Item 6', 'Durable and reliable Backpacks item for mountain use.', 108785, 7, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(17, 2, 'Backpacks Item 7', 'Durable and reliable Backpacks item for mountain use.', 109164, 9, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(18, 2, 'Backpacks Item 8', 'Durable and reliable Backpacks item for mountain use.', 149759, 9, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(19, 2, 'Backpacks Item 9', 'Durable and reliable Backpacks item for mountain use.', 126532, 10, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(20, 2, 'Backpacks Item 10', 'Durable and reliable Backpacks item for mountain use.', 88132, 10, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(21, 3, 'Cooking Gear Item 1', 'Durable and reliable Cooking Gear item for mountain use.', 129743, 10, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(22, 3, 'Cooking Gear Item 2', 'Durable and reliable Cooking Gear item for mountain use.', 78923, 16, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(23, 3, 'Cooking Gear Item 3', 'Durable and reliable Cooking Gear item for mountain use.', 149214, 15, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(24, 3, 'Cooking Gear Item 4', 'Durable and reliable Cooking Gear item for mountain use.', 64385, 17, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(25, 3, 'Cooking Gear Item 5', 'Durable and reliable Cooking Gear item for mountain use.', 89510, 9, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(26, 3, 'Cooking Gear Item 6', 'Durable and reliable Cooking Gear item for mountain use.', 73876, 12, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(27, 3, 'Cooking Gear Item 7', 'Durable and reliable Cooking Gear item for mountain use.', 147981, 15, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(28, 3, 'Cooking Gear Item 8', 'Durable and reliable Cooking Gear item for mountain use.', 100390, 18, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(29, 3, 'Cooking Gear Item 9', 'Durable and reliable Cooking Gear item for mountain use.', 126467, 7, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(30, 3, 'Cooking Gear Item 10', 'Durable and reliable Cooking Gear item for mountain use.', 130308, 20, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(31, 4, 'Clothing Item 1', 'Durable and reliable Clothing item for mountain use.', 104847, 10, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(32, 4, 'Clothing Item 2', 'Durable and reliable Clothing item for mountain use.', 141759, 13, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(33, 4, 'Clothing Item 3', 'Durable and reliable Clothing item for mountain use.', 115093, 9, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(34, 4, 'Clothing Item 4', 'Durable and reliable Clothing item for mountain use.', 79570, 8, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(35, 4, 'Clothing Item 5', 'Durable and reliable Clothing item for mountain use.', 106138, 20, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(36, 4, 'Clothing Item 6', 'Durable and reliable Clothing item for mountain use.', 134592, 13, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(37, 4, 'Clothing Item 7', 'Durable and reliable Clothing item for mountain use.', 97555, 16, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(38, 4, 'Clothing Item 8', 'Durable and reliable Clothing item for mountain use.', 113214, 13, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(39, 4, 'Clothing Item 9', 'Durable and reliable Clothing item for mountain use.', 52120, 20, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(40, 4, 'Clothing Item 10', 'Durable and reliable Clothing item for mountain use.', 62693, 15, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(41, 5, 'Lighting Item 1', 'Durable and reliable Lighting item for mountain use.', 53195, 14, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(42, 5, 'Lighting Item 2', 'Durable and reliable Lighting item for mountain use.', 76840, 9, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(43, 5, 'Lighting Item 3', 'Durable and reliable Lighting item for mountain use.', 134029, 14, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(44, 5, 'Lighting Item 4', 'Durable and reliable Lighting item for mountain use.', 146539, 10, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(45, 5, 'Lighting Item 5', 'Durable and reliable Lighting item for mountain use.', 148905, 16, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(46, 5, 'Lighting Item 6', 'Durable and reliable Lighting item for mountain use.', 57355, 14, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(47, 5, 'Lighting Item 7', 'Durable and reliable Lighting item for mountain use.', 82583, 11, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(48, 5, 'Lighting Item 8', 'Durable and reliable Lighting item for mountain use.', 133572, 15, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(49, 5, 'Lighting Item 9', 'Durable and reliable Lighting item for mountain use.', 119382, 17, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL),
(50, 5, 'Lighting Item 10', 'Durable and reliable Lighting item for mountain use.', 84046, 15, 0, 'products/product.jpg', '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6DicuiVKayTqB6JItiNngwMUvvzRZTh3kBXoSjkt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVAxMDZJQXlwelR3b3ZxUThpYzhGTnJWTm1HTHhjMU1maklQUVozYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775527440),
('Eh2S9LzMVLzwKCqDxkU42C7qS0Gy2lgTa55DLW9W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibDNhY082ejhZYmsxQnJ1elhMSjlROFdCNUFnRTRybTNqUlptTHBJNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766291971),
('hrcuJS8xkkOh0u6kwO0Xl67CGv4KVaI6s26oJtFc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRGhaRmltbzFsc3FBUUIzRDZwQmR5RnhCQklMWTM3dDFkWlQxVTBuMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjt9fQ==', 1765532136),
('o6vj2LIbubxn8JOWrlgy6olZONxz1DvrJnxXFmhW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGxaU3pDNDczTFZTTDU0QjJldWY1RTZoaEVibzlsRzdVckVpZmNDSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776605392),
('vvDGpI3tBrLdPgfcyrQ7rL7REmTEAIX6FNSDhQNX', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoid2d4ZVRkVnNDMXpJU3lzMFU4bDA5eVU0czNlNEV4NXFYWTE1VUFVUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dC8yOCI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1776610090);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `no_hp`, `ktp_image`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2025-11-09 18:26:35', '$2y$12$Aq0feKFCKo4vwFbmHKqY3ubqJDb5F.IgLiKXmvBwEsL4Hg/Uy3L9e', '081234567890', 'ktp_images/ktp.jpg', 'admin', NULL, '2025-11-09 18:26:35', '2025-11-09 18:26:35', NULL),
(3, 'User 2', 'user2@example.com', '2025-11-09 18:26:36', '$2y$12$5ulGgTB1mkUa0wdHgD37QOmlh5mhe4vEQn8lgLhgl6UDjioVMiXz.', '08123456782', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:36', '2025-11-09 18:26:36', NULL),
(4, 'User 3', 'user3@example.com', '2025-11-09 18:26:36', '$2y$12$9QqsXfJ.Q31Wjtb9Q4CiL.oBpmclO3HSPOAy8qCIGkbi8qcMiLa3C', '08123456783', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:36', '2025-11-09 18:26:36', NULL),
(5, 'User 4', 'user4@example.com', '2025-11-09 18:26:37', '$2y$12$QP5dSEjQab1Z4J7mrw3Yb.zh.3NPcQaza5cIYVMcc51UIHXEA9xQG', '08123456784', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:37', '2025-11-09 18:26:37', NULL),
(6, 'User 5', 'user5@example.com', '2025-11-09 18:26:37', '$2y$12$K2cH6rAgAHfi6kiTO/YjF.c3IR5Rxc5cAVrYpcCoX9eI9SqdCjkFS', '08123456785', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:37', '2025-11-09 18:26:37', NULL),
(7, 'User 6', 'user6@example.com', '2025-11-09 18:26:37', '$2y$12$JPA/oRfQX.8HCBnfQJKcSe2UPUZifR7WiXpL9E3ha4EwdMw7UP2fG', '08123456786', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:37', '2025-11-09 18:26:37', NULL),
(8, 'User 7', 'user7@example.com', '2025-11-09 18:26:38', '$2y$12$WGOBl7sQ7U3ryt3k.9FYcOQSKaXG9Z6FhQNQp91CcNynQD8bgbjzm', '08123456787', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:38', '2025-11-09 18:26:38', NULL),
(9, 'User 8', 'user8@example.com', '2025-11-09 18:26:38', '$2y$12$sMcfcvyGG7JpQvimGDzjx.pvaDMWpygEqAsaH0JTSLYMPlCHypntq', '08123456788', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:38', '2025-11-09 18:26:38', NULL),
(10, 'User 9', 'user9@example.com', '2025-11-09 18:26:38', '$2y$12$FvdGfcBU3jCFkOj8Q4rzk.G06XT38wZMe8C/ff47d93kDYgrMDDGe', '08123456789', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:38', '2025-11-09 18:26:38', NULL),
(11, 'User 10', 'user10@example.com', '2025-11-09 18:26:39', '$2y$12$gxHS0WX8MWTwB0GKVaTDM.E77LK9nZhHJxyp6bDubkm/3l6I7/iZG', '081234567810', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:39', '2025-11-09 18:26:39', NULL),
(12, 'User 11', 'user11@example.com', '2025-11-09 18:26:39', '$2y$12$HbhPmYBrqH7aY9eqPL6WGOGqZbXDImNrSdmVREqMIwdsbpOWSWNoi', '081234567811', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:39', '2025-11-09 18:26:39', NULL),
(13, 'User 12', 'user12@example.com', '2025-11-09 18:26:40', '$2y$12$Q6RolQQ0RKQJ.vV6VXe5wOqKFgzZF/4aTKfEsVo.A45i/KEWoIxIK', '081234567812', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:40', '2025-11-09 18:26:40', NULL),
(14, 'User 13', 'user13@example.com', '2025-11-09 18:26:40', '$2y$12$AdCk8OI/uV3JDcyPSF/O0uYKBSoTxkd6tXsIzVT8AuNowl8ovlegW', '081234567813', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:40', '2025-11-09 18:26:40', NULL),
(15, 'User 14', 'user14@example.com', '2025-11-09 18:26:40', '$2y$12$Qjv1bVMuOsuQI31qdAC0XOLy6PfDByxz9yP4XPj4vcVjDV94B4aku', '081234567814', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:40', '2025-11-09 18:26:40', NULL),
(16, 'User 15', 'user15@example.com', '2025-11-09 18:26:40', '$2y$12$aZ6.Q9V/M44WqYf4x5bhN.8EwECqTozksKYBLUL5REaQ8DjMUBL3S', '081234567815', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:40', '2025-11-09 18:26:40', NULL),
(17, 'User 16', 'user16@example.com', '2025-11-09 18:26:41', '$2y$12$6H8HaUG3sVJJEpSC5C.h0.v1cTQCrktZXoSrKu.Unup7//pLP4cSq', '081234567816', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:41', '2025-11-09 18:26:41', NULL),
(18, 'User 17', 'user17@example.com', '2025-11-09 18:26:41', '$2y$12$9pjfpmLsduAh5Aberj2CDuhEtI/SOKMR2GAjCiqluf/P8GNyfiSZu', '081234567817', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:41', '2025-11-09 18:26:41', NULL),
(19, 'User 18', 'user18@example.com', '2025-11-09 18:26:41', '$2y$12$2axPyCZUyDqY7rf8UHxveOh2uqm0VUmFuKgg9BAwQFRL2CVdIt/FG', '081234567818', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:41', '2025-11-09 18:26:41', NULL),
(20, 'User 19', 'user19@example.com', '2025-11-09 18:26:41', '$2y$12$M1t7yPnmlQxohC0B0OvXxuLQhIqjwFCu0DzzRJAmj8ACz9c..EB06', '081234567819', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:41', '2025-11-09 18:26:41', NULL),
(21, 'User 20', 'user20@example.com', '2025-11-09 18:26:42', '$2y$12$t2Xgf/dENbWTEP9uKBtbKulLFbIHRf0UEvz9WyhzJ234Mef90oiXe', '081234567820', 'ktp_images/ktp.jpg', 'user', NULL, '2025-11-09 18:26:42', '2025-11-09 18:26:42', NULL);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
