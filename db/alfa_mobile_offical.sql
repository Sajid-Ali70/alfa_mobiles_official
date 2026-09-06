-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2026 at 08:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alfa_mobile_offical`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `password`, `created_at`, `updated_at`) VALUES
(1, '$2y$10$03gA/M42vx1hcUIt3PnT/uSVqQuN5YTKzGj.f2VPy52R47f0mqfUK', '2026-09-06 05:37:55', '2026-09-06 05:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) NOT NULL DEFAULT 'Alfa Mobiles',
  `app_icon` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `rating_score` varchar(10) DEFAULT '4.3',
  `reviews_count` varchar(50) DEFAULT '1.9K reviews',
  `downloads_count` varchar(50) DEFAULT '3K+',
  `content_rating` varchar(100) DEFAULT 'Rated for 3+',
  `updated_date` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_notes` text DEFAULT NULL,
  `screenshots` text DEFAULT NULL,
  `apk_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `app_name`, `app_icon`, `banner_url`, `contact_number`, `contact_email`, `developer`, `category`, `tags`, `rating_score`, `reviews_count`, `downloads_count`, `content_rating`, `updated_date`, `description`, `release_notes`, `screenshots`, `apk_url`, `created_at`, `updated_at`) VALUES
(1, 'Alfa Mobiles', '/asset/image/01_app_icon.png', '/img/banner.png', NULL, NULL, NULL, NULL, NULL, '4.3', '1.9K reviews', '3K+', 'Rated for 3+', NULL, NULL, NULL, NULL, NULL, '2026-09-06 05:37:55', '2026-09-06 05:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings_newdata`
--

CREATE TABLE `app_settings_newdata` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `app_icon` varchar(255) DEFAULT NULL,
  `rating_score` decimal(2,1) DEFAULT 4.8,
  `reviews_count` varchar(50) DEFAULT '1M reviews',
  `downloads_count` varchar(50) DEFAULT '500M+',
  `content_rating` varchar(100) DEFAULT 'Rated for 3+',
  `updated_date` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_notes` text DEFAULT NULL,
  `screenshots` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings_newdata`
--

INSERT INTO `app_settings_newdata` (`id`, `app_name`, `developer`, `category`, `tags`, `app_icon`, `rating_score`, `reviews_count`, `downloads_count`, `content_rating`, `updated_date`, `description`, `release_notes`, `screenshots`, `created_at`, `updated_at`) VALUES
(1, 'imo video calls and chat', 'imo.im', 'Communication', 'Contains ads · In-app purchases', '/imo_files/imo.50ad88b6.png', 4.8, '1M reviews', '500M+', 'Rated for 3+', 'Aug 14, 2023', 'imo is a free, simple, and faster video calling & instant messaging app. Send text or voice messages or video call with your friends and family easily and quickly, even with a poor network signal.', '• Improved connection stability for HD video calls\n• Bug fixes and overall performance improvements\n• Enhanced instant message translation accuracy', '[]', '2026-08-30 09:47:30', '2026-08-30 09:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo_url`, `created_at`, `updated_at`) VALUES
(1, 'Samsung', '/uploads/brands/brand_1788673232.svg', '2026-09-06 00:40:32', '2026-09-06 00:40:32'),
(2, 'Apple', '/uploads/brands/brand_1788673268.png', '2026-09-06 00:41:08', '2026-09-06 00:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mobiles`
--

CREATE TABLE `mobiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `series_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(100) NOT NULL,
  `specs` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mobiles`
--

INSERT INTO `mobiles` (`id`, `brand_id`, `series_id`, `name`, `price`, `specs`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Samsung Galaxy s10', '75000', '8GB RAM - 128GB STORAGE', '/uploads/mobiles/mobile_1788673348.jfif', '2026-09-06 00:42:28', '2026-09-06 00:42:28'),
(2, 2, 2, 'IPHONE X', '42500', '256GB STORAGE - FACEID', '/uploads/mobiles/mobile_1788673391.jfif', '2026-09-06 00:43:11', '2026-09-06 00:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `delivery_type` varchar(100) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `wallet_service` varchar(100) DEFAULT NULL,
  `account_holder` varchar(255) DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `mobile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `tenure` varchar(50) DEFAULT NULL,
  `monthly_emi` varchar(100) DEFAULT NULL,
  `total_price` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `full_name`, `cnic`, `mobile_number`, `address`, `delivery_type`, `payment_method`, `wallet_service`, `account_holder`, `proof_image`, `mobile_id`, `color`, `tenure`, `monthly_emi`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AM-260906-8662', 'Sajid Ali', '3310026178869', '03277949105', 'faisalabad', 'Open Parcel via TCS Rider (Recommended)', 'Digital Wallet', 'Easypaisa', 'Sajid Ali', '/uploads/proofs/proof_1788673517.jfif', 1, 'Black', '12 Months', 'Rs. 6,250', 'Rs. 75,000', 'Completed', '2026-09-06 00:45:17', '2026-09-06 00:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`id`, `brand_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'S Series', '2026-09-06 00:40:44', '2026-09-06 00:40:44'),
(2, 2, 'X Series', '2026-09-06 00:41:21', '2026-09-06 00:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4UbU2wbHZkTY9r9Kf4NhuqHx2iZalx8FW0l6GMC4', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Mobile Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6InZtdnJFemZ4UnBZNVYwRXUxZDJJMlJmR2Y1SVFxeDZRcHhqenI3dVYiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTU6ImFkbWluX2xvZ2dlZF9pbiI7YjoxO3M6MTU6Im9yZGVyX21vYmlsZV9pZCI7czoxOiIyIjtzOjExOiJvcmRlcl9jb2xvciI7czo1OiJCbGFjayI7czoxMjoib3JkZXJfdGVudXJlIjtzOjk6IjEyIE1vbnRocyI7czo5OiJvcmRlcl9lbWkiO3M6OToiUnMuIDMsNTQyIjtzOjExOiJvcmRlcl90b3RhbCI7czoxMDoiUnMuIDQyLDUwMCI7czoxNDoib3JkZXJfY3VzdG9tZXIiO2E6NTp7czoxMzoiZGVsaXZlcnlfdHlwZSI7czozOToiT3BlbiBQYXJjZWwgdmlhIFRDUyBSaWRlciAoUmVjb21tZW5kZWQpIjtzOjk6ImZ1bGxfbmFtZSI7czo5OiJTYWppZCBBbGkiO3M6NDoiY25pYyI7czoxMzoiMzMxMDAyNjE3ODg2OSI7czoxMzoibW9iaWxlX251bWJlciI7czoxMToiMDMyNzc5NDkxMDUiO3M6NzoiYWRkcmVzcyI7czoxMDoiZmFpc2FsYWJhZCI7fX0=', 1788676112);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings_newdata`
--
ALTER TABLE `app_settings_newdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `mobiles`
--
ALTER TABLE `mobiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_settings_newdata`
--
ALTER TABLE `app_settings_newdata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mobiles`
--
ALTER TABLE `mobiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mobiles`
--
ALTER TABLE `mobiles`
  ADD CONSTRAINT `mobiles_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mobiles_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
