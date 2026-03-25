-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 03:07 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MUAFFA', 'ADITYA', 'aditbehh04@gmail.com', '$2y$10$PRf3CH43DU4IrQln.Y1vieFnmRvr5LALipezR5ba.f.Zz6LnCCzg.', 'r94VrLk2hTwUiMfjA9NHDAicbyCg7KE5loXvp70nmW12q4vNwxGXeE4tq6sc', '2026-02-05 02:28:24', '2026-02-05 02:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast_messages`
--

CREATE TABLE `broadcast_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `admin_name` varchar(100) DEFAULT 'LUXE Official',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `broadcast_messages`
--

INSERT INTO `broadcast_messages` (`id`, `message`, `admin_name`, `created_at`, `updated_at`) VALUES
(1, 'halo gaiss', 'MUAFFA', '2026-02-09 06:26:16', NULL),
(2, 'ada gambar gembiraa nicchh !!!', 'MUAFFA', '2026-02-09 06:26:42', '2026-02-09 06:35:20'),
(5, '\"akan lanching produknya di awal maret ya gais, stay tune yaa\"', 'MUAFFA', '2026-02-09 06:46:35', '2026-02-09 06:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` int(10) UNSIGNED DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_settings`
--

CREATE TABLE `home_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key_name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_settings`
--

INSERT INTO `home_settings` (`id`, `key_name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hero_subtitle', 'Premium Essentials', NULL, '2026-02-07 07:49:52'),
(2, 'hero_title_top', 'The Art', NULL, '2026-02-07 07:49:52'),
(3, 'hero_title_bottom', 'of Fashion', NULL, '2026-02-07 07:49:52'),
(4, 'hero_description', 'Discover our curated collection of high-end essentials.', NULL, '2026-02-07 07:49:52'),
(5, 'login_title_top', 'Elevate your everyday with', NULL, '2026-02-07 07:06:12'),
(6, 'login_title_bottom', 'curated essentials.', NULL, '2026-02-07 07:06:12'),
(7, 'register_title_top', 'Quality is not an act,', NULL, '2026-02-07 07:55:32'),
(8, 'register_title_bottom', 'it is a habit.', NULL, '2026-02-07 07:55:32'),
(9, 'register_description', 'Join our community of product and style enthusiasts.', NULL, '2026-02-07 07:55:32'),
(10, 'hero_image', 'hero_image_1770473163.jpg', NULL, '2026-02-07 07:06:03'),
(11, 'login_image', 'login_image_1770473172.jpg', NULL, '2026-02-07 07:06:12'),
(12, 'register_image', 'register_image_1770473181.jpg', NULL, '2026-02-07 07:06:21'),
(13, 'forgot_title_top', 'Restore your access to', NULL, '2026-02-07 07:56:10'),
(14, 'forgot_title_bottom', 'Quality lifestyle.', NULL, '2026-02-07 07:56:10'),
(15, 'image', 'C:\\xampp\\tmp\\php49FB.tmp', NULL, '2026-02-07 07:17:14'),
(16, 'forgot_image', 'forgot_image_1770474071.jpg', NULL, '2026-02-07 07:21:11'),
(17, 'reset_title_top', 'Secure your account', NULL, '2026-02-07 07:56:32'),
(18, 'reset_title_bottom', 'with a new identity.', NULL, '2026-02-07 07:56:32'),
(19, 'reset_image', 'reset_image_1770474566.jpg', NULL, '2026-02-07 07:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED DEFAULT 1,
  `total_price` decimal(15,2) NOT NULL,
  `voucher_used` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `color_choice` varchar(50) DEFAULT NULL,
  `size_choice` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `subdistrict` varchar(100) DEFAULT NULL,
  `address_detail` text DEFAULT NULL,
  `status` enum('pending','processing','shipped','completed') DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `received_proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `voucher_used`, `phone_number`, `postal_code`, `color_choice`, `size_choice`, `country`, `province`, `city`, `district`, `subdistrict`, `address_detail`, `status`, `payment_proof`, `received_proof`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 1, 68.00, NULL, '081249771960', '-', 'Black', 'S', 'Indonesia', '35', '3515', '3515110', '3515110012', 'gedangan sidoarjo', 'completed', 'PROOF_1770569810_1.png', 'RECEIVED_1770570674_1.png', '2026-02-08 09:56:50', '2026-02-08 10:11:14'),
(5, 1, 2, 1, 61.00, 'NADZIROH', '081249771960', '-', NULL, NULL, 'Indonesia', '35', '3515', '3515150', '3515150010', 'sidoarjo', 'completed', 'PROOF_1770572326_1.png', NULL, '2026-02-08 10:38:46', '2026-02-08 10:44:09'),
(6, 1, 1, 1, 50.00, NULL, '081249771960', '-', NULL, NULL, 'Indonesia', '35', '3515', '3515150', '3515150010', 'sidoarjo', 'completed', 'PROOF_1770572694_1.png', 'RECEIVED_1770625097_1.png', '2026-02-08 10:44:54', '2026-02-09 01:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('muaffaaditya88@gmail.com', 'GiMYHoRsnotVdB8VH17oJORA6m3FWQglWt8ZEIMEkBEh8C4CwlQoGDdjZnWT', '2026-02-09 12:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `detail` text DEFAULT NULL,
  `colors` text DEFAULT NULL,
  `sizes` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `original_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `promo_price` decimal(15,2) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `voucher_code` varchar(50) DEFAULT NULL,
  `voucher_price` decimal(15,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `slug`, `detail`, `colors`, `sizes`, `image`, `original_price`, `promo_price`, `discount_percent`, `voucher_code`, `voucher_price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'baju unisex', '[\"Men\",\"Women\",\"Unisex\"]', 'baju-unisex-799', 'buat cowo dan buat cewe', '[\"White\"]', '[\"S\",\"XL\"]', 'prod_1770472034.jpg', 65.00, NULL, NULL, 'ADITYA', 40.00, 1, '2026-02-07 06:47:14', '2026-02-09 06:03:26'),
(2, 'celana baggy', '[\"Unisex\"]', 'celana-baggy-335', NULL, '[\"Black\"]', '[\"S\"]', 'prod_main_1770478852_69875d0492113.jpg', 80.00, NULL, NULL, 'PURBA', 7.00, 1, '2026-02-07 08:40:52', '2026-02-09 06:03:49'),
(3, 'celana jeans', '[\"Unisex\"]', 'celana-jeans-413', 'untuk kuliah dan kerja', '[\"Black\",\"White\"]', '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', 'prod_main_1770479830_698760d64fa80.jpg', 70.00, 63.00, 10, NULL, NULL, 1, '2026-02-07 08:57:10', '2026-02-09 05:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_galleries`
--

CREATE TABLE `product_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_galleries`
--

INSERT INTO `product_galleries` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, 'gal_1770478852_69875d0496d52.jpg', '2026-02-07 08:40:52', '2026-02-07 08:40:52'),
(2, 3, 'gal_1770479830_698760d656e4d.jpg', '2026-02-07 08:57:10', '2026-02-07 08:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `user_id`, `email`, `created_at`) VALUES
(1, 1, 'muaffaaditya88@gmail.com', '2026-02-09 06:18:30'),
(2, 2, '3130023042@student.unusa.ac.id', '2026-02-12 09:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `apple_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `role`, `password`, `google_id`, `apple_id`, `avatar`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'M.MU\'AFFA', 'ADITYA', 'muaffaaditya88@gmail.com', 'user', '$2y$12$I4d/TNUq67RKVOfx7rMnVOtBBx1tc4V5w7bzsuv7aHvqyLyHNFvee', NULL, NULL, NULL, NULL, 'bLuIATgr2CLnegin7fdv8Qrf6coBY6gTEpumKRvM6K7fW6z5tlxjy0mIGndn', '2026-02-06 10:18:01', '2026-02-12 16:36:56'),
(2, '3130023042', 'M.MU\'AFFA ADITYA', '3130023042@student.unusa.ac.id', 'user', NULL, '116042333110371777244', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIZFORiFqXHK_3AnPIudqRXzycLQcbABMgjq7FJ3abddIuywg=s96-c', NULL, 'YXl2TbJqBJL9euheyRxGCHxHNaJ3YQNmOoWdYkJHgaTELtm6JdmGTOh8nGPA', '2026-02-06 10:42:10', '2026-02-08 07:41:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `broadcast_messages`
--
ALTER TABLE `broadcast_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `home_settings`
--
ALTER TABLE `home_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

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
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`),
  ADD UNIQUE KEY `apple_id` (`apple_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `broadcast_messages`
--
ALTER TABLE `broadcast_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `home_settings`
--
ALTER TABLE `home_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_galleries`
--
ALTER TABLE `product_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD CONSTRAINT `product_galleries_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `subscribers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
