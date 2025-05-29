-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 08:41 PM
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
-- Database: `my_auction_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `product_id`, `user_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 11, 3, 1999.00, '2025-05-28 18:09:00', '2025-05-28 18:09:00'),
(2, 11, 3, 2019.00, '2025-05-28 18:11:26', '2025-05-28 18:11:26'),
(3, 11, 4, 2079.00, '2025-05-28 18:11:26', '2025-05-28 18:11:26'),
(4, 11, 3, 2059.00, '2025-05-28 18:37:34', '2025-05-28 18:37:34'),
(5, 11, 3, 2069.00, '2025-05-28 18:38:37', '2025-05-28 18:38:37'),
(6, 11, 3, 2089.00, '2025-05-28 18:39:06', '2025-05-28 18:39:06'),
(7, 11, 3, 2099.00, '2025-05-28 19:04:25', '2025-05-28 19:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender_id`, `receiver_id`, `message`, `read`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'HI', 0, '2025-05-29 16:26:11', '2025-05-29 16:26:11'),
(2, 3, 1, 'HI', 0, '2025-05-29 16:26:15', '2025-05-29 16:26:15'),
(3, 3, 1, 'HI', 0, '2025-05-29 16:26:16', '2025-05-29 16:26:16'),
(4, 3, 1, 'HI', 0, '2025-05-29 16:26:16', '2025-05-29 16:26:16'),
(5, 3, 1, 'HI', 0, '2025-05-29 16:26:17', '2025-05-29 16:26:17'),
(6, 3, 1, 'HI', 0, '2025-05-29 16:26:18', '2025-05-29 16:26:18'),
(7, 3, 1, 'HI', 0, '2025-05-29 16:26:19', '2025-05-29 16:26:19'),
(8, 3, 1, 'HI', 0, '2025-05-29 16:26:19', '2025-05-29 16:26:19'),
(9, 3, 1, 'Hy', 0, '2025-05-29 16:29:59', '2025-05-29 16:29:59'),
(10, 3, 1, 'Hello', 0, '2025-05-29 16:30:25', '2025-05-29 16:30:25'),
(11, 3, 1, 'hiiiiii', 0, '2025-05-29 16:50:36', '2025-05-29 16:50:36'),
(12, 3, 1, 'hiiiiii', 0, '2025-05-29 16:50:55', '2025-05-29 16:50:55'),
(13, 3, 1, 'Hii', 0, '2025-05-29 16:54:56', '2025-05-29 16:54:56'),
(14, 3, 1, 'Hi', 0, '2025-05-29 17:05:31', '2025-05-29 17:05:31'),
(15, 3, 1, 'Hey', 0, '2025-05-29 17:07:24', '2025-05-29 17:07:24'),
(16, 1, 3, 'Hello', 0, '2025-05-29 17:09:57', '2025-05-29 17:09:57'),
(17, 3, 1, 'are you there?', 0, '2025-05-29 17:10:17', '2025-05-29 17:10:17'),
(18, 1, 3, 'hey', 0, '2025-05-29 17:10:35', '2025-05-29 17:10:35'),
(19, 3, 1, 'hello', 0, '2025-05-29 17:15:42', '2025-05-29 17:15:42'),
(20, 3, 1, 'hello', 0, '2025-05-29 17:16:13', '2025-05-29 17:16:13'),
(21, 3, 1, 'hello', 0, '2025-05-29 17:16:43', '2025-05-29 17:16:43'),
(22, 3, 1, 'hi', 0, '2025-05-29 17:30:01', '2025-05-29 17:30:01'),
(23, 3, 1, 'hi', 0, '2025-05-29 17:30:32', '2025-05-29 17:30:32'),
(24, 3, 1, 'hi', 0, '2025-05-29 17:31:02', '2025-05-29 17:31:02'),
(25, 3, 1, 'kk', 0, '2025-05-29 17:38:25', '2025-05-29 17:38:25'),
(26, 3, 1, 'ha', 0, '2025-05-29 17:40:10', '2025-05-29 17:40:10'),
(27, 1, 3, 'kk', 0, '2025-05-29 17:40:36', '2025-05-29 17:40:36'),
(28, 3, 1, 'hi', 0, '2025-05-29 17:50:13', '2025-05-29 17:50:13'),
(29, 1, 3, 'kys', 0, '2025-05-29 17:51:29', '2025-05-29 17:51:29'),
(30, 3, 1, 'hk', 0, '2025-05-29 17:58:45', '2025-05-29 17:58:45'),
(31, 3, 1, 'hk', 0, '2025-05-29 17:59:16', '2025-05-29 17:59:16'),
(32, 3, 1, 'hk', 0, '2025-05-29 17:59:46', '2025-05-29 17:59:46'),
(33, 3, 1, 'hk', 0, '2025-05-29 18:00:17', '2025-05-29 18:00:17'),
(34, 3, 1, 'hk', 0, '2025-05-29 18:00:48', '2025-05-29 18:00:48'),
(35, 3, 1, 'checking', 0, '2025-05-29 18:03:03', '2025-05-29 18:03:03'),
(36, 3, 1, 'jk', 0, '2025-05-29 18:05:37', '2025-05-29 18:05:37'),
(37, 3, 1, 'm', 0, '2025-05-29 18:06:52', '2025-05-29 18:06:52'),
(38, 3, 1, 'GG', 0, '2025-05-29 18:10:54', '2025-05-29 18:10:54'),
(39, 3, 1, 'mn', 0, '2025-05-29 18:17:12', '2025-05-29 18:17:12'),
(40, 1, 3, 'gi', 0, '2025-05-29 18:19:12', '2025-05-29 18:19:12'),
(41, 3, 1, 'f', 0, '2025-05-29 18:20:10', '2025-05-29 18:20:10'),
(42, 3, 1, 'ok', 0, '2025-05-29 18:20:44', '2025-05-29 18:20:44'),
(43, 1, 3, 'good night', 0, '2025-05-29 18:28:17', '2025-05-29 18:28:17'),
(44, 3, 1, 'hi', 0, '2025-05-29 18:28:34', '2025-05-29 18:28:34'),
(45, 3, 1, 'yes', 0, '2025-05-29 18:28:56', '2025-05-29 18:28:56');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_26_161553_add_role_to_users_table', 2),
(6, '2025_05_26_161645_create_products_table', 3),
(7, '2025_05_26_164321_create_bids_table', 4),
(8, '2025_05_29_202508_create_chat_messages_table', 5);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `base_price` float NOT NULL DEFAULT 0,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `bid_price` double(8,2) DEFAULT NULL,
  `highest_bidder_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `image`, `description`, `base_price`, `start_date`, `end_date`, `status`, `bid_price`, `highest_bidder_id`, `created_at`, `updated_at`) VALUES
(11, 'Apple Iphone 16', '1748427738_6836e3daeba88.webp', 'iPhone 16 128GB Pink', 1999, '2025-05-28 16:44:00', '2025-05-29 00:37:00', 'closed', 2099.00, 3, '2025-05-28 04:52:18', '2025-05-28 19:07:06');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','bidder') NOT NULL DEFAULT 'bidder'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$P.pKjTeDTEAHBXyMn//.CeinUJof5O8W5.X6Nwp2E4vJODhHZLQBy', NULL, '2025-05-28 03:15:43', '2025-05-28 03:15:43', 'admin'),
(2, 'Bidder', 'bidder@gmail.com', NULL, '$2y$10$UkuqAo/oDUxokGkj.7Guq.m8ydkWdRZPi/ANhvrem4rtGPr9Vfkve', NULL, '2025-05-28 03:31:08', '2025-05-28 03:31:08', 'bidder'),
(3, 'Hari', 'hari@gmail.com', NULL, '$2y$10$mGIM.h6kw9iDpqdEdmmghOMVR1QdZ0GWKxFwGHTxjHMg1XOFXbpwy', NULL, '2025-05-28 04:17:46', '2025-05-28 04:17:46', 'bidder'),
(4, 'HariG', 'harig@gmail.com', NULL, '$2y$10$.Zs0AYQ8KlA4LCEdwFvT3.VA8uLmXZt0w2EcOuNHwsBlgDf0YfHGK', NULL, '2025-05-28 04:20:20', '2025-05-28 04:20:20', 'bidder');

-- --------------------------------------------------------

--
-- Table structure for table `users2`
--

CREATE TABLE `users2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','bidder') NOT NULL DEFAULT 'bidder'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users2`
--

INSERT INTO `users2` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin User', 'admin@gmail.com', NULL, '$2y$10$InJj99cXpU3BPkUogXviT.FkNbf9j3Nw4nmGQTNmVPR624NGx99h6', NULL, '2025-05-26 11:26:26', '2025-05-26 11:26:26', 'admin'),
(2, 'Bidder User', 'bidder@gmail.com', NULL, '$2y$10$hq052hmtyg8GCjqPWlVBX.BSouOk2MP1klf7yBvVpQfxv28NKY2WS', NULL, '2025-05-26 11:26:26', '2025-05-26 11:26:26', 'bidder'),
(4, 'test', 'test@gmail.com', NULL, '$2y$10$Oq4D0ZjrcY6MPXpfOxI64uG6q2ULBfrkX1osFkW/xIY7ryhFN993a', NULL, '2025-05-28 03:03:23', '2025-05-28 03:03:23', 'bidder');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bids_product_id_foreign` (`product_id`),
  ADD KEY `bids_user_id_foreign` (`user_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_sender_id_foreign` (`sender_id`),
  ADD KEY `chat_messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_highest_bidder_id_foreign` (`highest_bidder_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users2`
--
ALTER TABLE `users2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users2`
--
ALTER TABLE `users2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bids_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_highest_bidder_id_foreign` FOREIGN KEY (`highest_bidder_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
