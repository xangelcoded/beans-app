-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 08:39 AM
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
-- Database: `beans_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `scans`
--

CREATE TABLE `scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `label` enum('Good','Ripe','Underripe','Defective') NOT NULL,
  `confidence` decimal(5,4) NOT NULL,
  `verdict` enum('Good','Ripe','Underripe','Defective','Uncertain') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `percentages_json` text DEFAULT NULL,
  `heatmap_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scans`
--

INSERT INTO `scans` (`id`, `user_id`, `label`, `confidence`, `verdict`, `image_path`, `scanned_at`, `percentages_json`, `heatmap_path`) VALUES
(2, 1, 'Good', 1.0000, 'Good', NULL, '2025-05-27 03:33:58', NULL, NULL),
(3, 1, 'Defective', 1.0000, 'Defective', NULL, '2025-05-27 03:34:17', NULL, NULL),
(4, 1, 'Ripe', 1.0000, 'Ripe', NULL, '2025-05-27 03:34:33', NULL, NULL),
(5, 1, 'Ripe', 1.0000, 'Ripe', NULL, '2025-05-27 04:38:41', NULL, NULL),
(6, 1, 'Good', 1.0000, 'Good', NULL, '2025-05-27 05:00:15', NULL, NULL),
(7, 1, 'Ripe', 1.0000, 'Ripe', NULL, '2025-05-27 05:01:42', NULL, NULL),
(8, 1, 'Good', 1.0000, 'Good', NULL, '2025-05-29 03:26:10', NULL, NULL),
(9, 1, 'Defective', 1.0000, 'Defective', NULL, '2025-05-29 03:34:33', NULL, NULL),
(10, 1, 'Good', 1.0000, 'Good', 'uploads/1748556086_medium (12).png', '2025-05-29 22:02:36', NULL, NULL),
(11, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748559485_green (12).png', '2025-05-29 22:59:03', NULL, NULL),
(12, 1, '', 1.0000, 'Uncertain', 'uploads/1748559569_green (12).png', '2025-05-29 22:59:58', NULL, NULL),
(13, 1, 'Good', 1.0000, 'Good', 'uploads/1748559672_medium (12).png', '2025-05-29 23:01:20', NULL, NULL),
(14, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748559696_green (12).png', '2025-05-29 23:01:43', NULL, NULL),
(15, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748559751_green (12).png', '2025-05-29 23:02:38', NULL, NULL),
(16, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748562441_green (12).png', '2025-05-29 23:47:46', NULL, NULL),
(17, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748562669_green (12).png', '2025-05-29 23:51:17', NULL, NULL),
(18, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748562687_green (12).png', '2025-05-29 23:51:34', NULL, NULL),
(19, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748562783_green (12).png', '2025-05-29 23:53:10', NULL, NULL),
(20, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748562816_green (12).png', '2025-05-29 23:53:43', NULL, NULL),
(21, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748563850_green (12).png', '2025-05-30 00:10:57', NULL, NULL),
(22, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748564051_green (12).png', '2025-05-30 00:14:18', NULL, NULL),
(23, 1, 'Defective', 0.9998, 'Defective', 'uploads/1748564067_Broken_09.jpg', '2025-05-30 00:14:35', NULL, NULL),
(24, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748570894_medium (12).png', '2025-05-30 02:08:30', NULL, NULL),
(25, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748570920_medium (12).png', '2025-05-30 02:08:49', NULL, NULL),
(26, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748570961_medium (12).png', '2025-05-30 02:09:29', NULL, NULL),
(27, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748571000_medium (12).png', '2025-05-30 02:10:10', NULL, NULL),
(28, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748571328_medium (12).png', '2025-05-30 02:15:38', NULL, NULL),
(29, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748571693_green (12).png', '2025-05-30 02:21:41', NULL, NULL),
(30, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748571736_green (12).png', '2025-05-30 02:22:24', NULL, NULL),
(31, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748571768_light (12).png', '2025-05-30 02:22:57', NULL, NULL),
(32, 1, 'Defective', 0.9930, 'Defective', 'uploads/1748571821_Broken_12.jpg', '2025-05-30 02:23:51', NULL, NULL),
(33, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748571889_light (12).png', '2025-05-30 02:24:59', NULL, NULL),
(34, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748575841_medium (12).png', '2025-05-30 03:30:58', NULL, NULL),
(35, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748575858_medium (12).png', '2025-05-30 03:31:09', NULL, NULL),
(36, 1, 'Ripe', 0.9999, 'Ripe', 'uploads/1748575911_dark (1) (1).png', '2025-05-30 03:32:00', NULL, NULL),
(37, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748576016_light (12).png', '2025-05-30 03:33:51', NULL, NULL),
(38, 1, 'Defective', 0.9998, 'Defective', 'uploads/1748576102_Broken_09.jpg', '2025-05-30 03:35:12', NULL, NULL),
(39, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748576406_green (12).png', '2025-05-30 03:40:15', NULL, NULL),
(40, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748576454_medium (12).png', '2025-05-30 03:41:02', NULL, NULL),
(41, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748576495_light (12).png', '2025-05-30 03:41:45', NULL, NULL),
(42, 1, 'Defective', 0.9990, 'Defective', 'uploads/1748576910_Fade_02.jpg', '2025-05-30 03:48:47', NULL, NULL),
(43, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748576939_green (17).png', '2025-05-30 03:49:13', NULL, NULL),
(44, 1, 'Ripe', 0.9989, 'Ripe', 'uploads/1748576961_medium (1).png', '2025-05-30 03:49:35', NULL, NULL),
(45, 1, 'Defective', 0.9990, 'Defective', 'uploads/1748587692_Fade_02.jpg', '2025-05-30 06:49:22', NULL, NULL),
(46, 1, 'Underripe', 0.9085, 'Underripe', 'uploads/1748587830_green (13).png', '2025-05-30 06:51:27', NULL, NULL),
(47, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748588746_medium (12) (1).png', '2025-05-30 07:06:14', NULL, NULL),
(48, 1, 'Defective', 0.9979, 'Defective', 'uploads/1748589057_Broken_03.jpg', '2025-05-30 07:11:21', NULL, NULL),
(49, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748589781_green (12) (1).png', '2025-05-30 07:23:29', NULL, NULL),
(50, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1748589886_dark (16).png', '2025-05-30 07:25:11', NULL, NULL),
(51, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1748813307_light (14).png', '2025-06-01 21:29:08', NULL, NULL),
(52, 1, 'Good', 0.3500, 'Good', 'uploads/1749069176_mixed.png', '2025-06-04 20:33:22', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749069176.png'),
(53, 1, 'Good', 0.3500, 'Good', 'uploads/1749069220_mixed.png', '2025-06-04 20:34:08', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749069220.png'),
(54, 1, 'Good', 1.0000, 'Good', 'uploads/1749069284_dark (16) - Copy.png', '2025-06-04 20:34:54', '{\"Good\":1,\"Defective\":0,\"Ripe\":0,\"Underripe\":0}', 'uploads/heatmap_1749069284.png'),
(55, 1, 'Defective', 1.0000, 'Defective', 'uploads/1749069380_Broken_01 (1) - Copy.jpg', '2025-06-04 20:36:33', '{\"Defective\":1,\"Good\":0,\"Ripe\":0,\"Underripe\":0}', 'uploads/heatmap_1749069380.png'),
(56, 1, 'Defective', 1.0000, 'Defective', 'uploads/1749069545_Broken_01 (1) - Copy.jpg', '2025-06-04 20:39:15', '{\"Defective\":1,\"Good\":0,\"Ripe\":0,\"Underripe\":0}', 'uploads/heatmap_1749069545.png'),
(57, 1, 'Good', 0.3500, 'Good', 'uploads/1749069691_mixed.png', '2025-06-04 20:41:56', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749069691.png'),
(58, 1, 'Good', 0.3500, 'Good', 'uploads/1749070091_mixed.png', '2025-06-04 20:48:35', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749070091.png'),
(59, 1, 'Good', 0.3500, 'Good', 'uploads/1749070259_mixed.png', '2025-06-04 20:51:26', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749070259.png'),
(60, 1, 'Good', 0.3500, 'Good', 'uploads/1749070394_mixed.png', '2025-06-04 20:53:29', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749070394.png'),
(61, 1, 'Good', 0.3500, 'Good', 'uploads/1749070470_mixed.png', '2025-06-04 20:54:51', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749070470.png'),
(62, 1, 'Good', 0.3500, 'Good', 'uploads/1749070665_mixed.png', '2025-06-04 20:58:07', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749070665.png'),
(63, 1, 'Good', 0.3500, 'Good', 'uploads/1749070937_mixed.png', '2025-06-04 21:02:43', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749070937.png'),
(64, 1, 'Good', 0.3500, 'Good', 'uploads/1749071213_mixed.png', '2025-06-04 21:07:19', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749071213.png'),
(65, 1, 'Good', 0.3500, 'Good', 'uploads/1749071270_mixed.png', '2025-06-04 21:08:06', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749071270.png'),
(66, 1, 'Good', 0.3500, 'Good', 'uploads/1749071310_mixed.png', '2025-06-04 21:08:52', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749071310.png'),
(67, 1, 'Good', 0.3500, 'Good', 'uploads/1749071502_mixed.png', '2025-06-04 21:12:28', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749071502.png'),
(68, 1, 'Good', 0.3500, 'Good', 'uploads/1749071621_mixed.png', '2025-06-04 21:14:05', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749071621.png'),
(69, 1, 'Good', 0.3500, 'Good', 'uploads/1749071743_mixed.png', '2025-06-04 21:16:27', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749071743.png'),
(70, 1, 'Good', 0.3500, 'Good', 'uploads/1749072069_mixed.png', '2025-06-04 21:21:31', '{\"Good\":0.3541666666666667,\"Ripe\":0.3333333333333333,\"Defective\":0.3125,\"Underripe\":0}', 'uploads/heatmap_1749072069.png'),
(71, 1, '', 0.0000, '', 'uploads/1749073398_mixed.png', '2025-06-04 21:43:38', NULL, NULL),
(72, 1, '', 0.0000, '', 'uploads/1749073418_mixed.png', '2025-06-04 21:43:55', NULL, NULL),
(73, 1, '', 0.0000, '', 'uploads/1749073435_mixed.png', '2025-06-04 21:44:10', NULL, NULL),
(74, 1, '', 0.0000, '', 'uploads/1749073451_mixed.png', '2025-06-04 21:44:26', NULL, NULL),
(75, 1, '', 0.0000, '', 'uploads/1749073900_mixed.png', '2025-06-04 21:51:56', NULL, NULL),
(76, 1, '', 0.0000, '', 'uploads/1749074023_mixed.png', '2025-06-04 21:54:06', NULL, NULL),
(77, 1, '', 0.0000, '', 'uploads/1749074099_mixed.png', '2025-06-04 21:55:22', NULL, NULL),
(78, 1, '', 0.0000, '', 'uploads/1749074141_mixed.png', '2025-06-04 21:56:02', NULL, NULL),
(79, 1, '', 0.0000, '', 'uploads/1749074372_mixed.png', '2025-06-04 21:59:54', NULL, NULL),
(80, 1, '', 0.0000, '', 'uploads/1749074654_dark (100).png', '2025-06-04 22:04:23', NULL, NULL),
(81, 1, '', 0.0000, '', 'uploads/1749074702_mixed.png', '2025-06-04 22:05:25', NULL, NULL),
(82, 1, '', 0.0000, '', 'uploads/1749075019_mixed.png', '2025-06-04 22:10:41', NULL, NULL),
(83, 1, '', 0.0000, '', 'uploads/1749075234_mixed.png', '2025-06-04 22:14:17', NULL, NULL),
(84, 1, '', 0.0000, '', 'uploads/1749075516_mixed.png', '2025-06-04 22:18:59', NULL, NULL),
(85, 1, 'Defective', 0.8939, 'Defective', 'uploads/1750063580_A.png', '2025-06-16 08:46:44', NULL, NULL),
(86, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1750063727_dark (13).png', '2025-06-16 08:48:55', NULL, NULL),
(87, 1, 'Ripe', 1.0000, 'Ripe', 'uploads/1750215368_medium (12) (1).png', '2025-06-18 02:57:43', NULL, NULL),
(88, 1, 'Underripe', 1.0000, 'Underripe', 'uploads/1750215565_light (11).png', '2025-06-18 03:00:15', NULL, NULL),
(89, 1, '', 0.8734, 'Uncertain', 'uploads/1750216573_A.png', '2025-06-18 03:17:08', NULL, NULL),
(90, 1, 'Ripe', 0.9997, 'Ripe', 'uploads/1750216785_dark (15).png', '2025-06-18 03:20:24', NULL, NULL),
(91, 1, 'Defective', 0.9228, 'Defective', 'uploads/1750216890_Dry Cherry_08.jpg', '2025-06-18 03:22:30', NULL, NULL),
(92, 1, 'Ripe', 0.9997, 'Ripe', 'uploads/1750217153_dark (15).png', '2025-06-18 03:26:56', NULL, NULL),
(93, 1, 'Defective', 0.9556, 'Defective', 'uploads/1750217540_Dry Cherry_01.jpg', '2025-06-18 03:33:36', NULL, NULL),
(94, 1, 'Good', 0.5125, 'Uncertain', 'uploads/1750226647_dark (15).png', '2025-06-18 06:04:20', NULL, NULL),
(95, 1, 'Underripe', 0.9548, 'Underripe', 'uploads/1750226885_green (12).png', '2025-06-18 06:08:15', NULL, NULL),
(96, 1, 'Defective', 0.8046, 'Uncertain', 'uploads/1750226935_Broken_01 (1) - Copy.jpg', '2025-06-18 06:09:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `default_threshold` decimal(3,2) DEFAULT 0.70,
  `offline_enabled` tinyint(1) DEFAULT 1,
  `theme` enum('Light','Coffee') DEFAULT 'Coffee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`user_id`, `default_threshold`, `offline_enabled`, `theme`) VALUES
(1, 0.70, 1, 'Light');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(120) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, 'angelmikaelasch@gmail.com', '$2y$10$ZqTlv6eeivlLY74Gn/ff4.d9l3edLfwVvKiXStjZl2neMKRqmofrm', '2025-05-26 22:47:51', '2025-05-26 22:47:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scans`
--
ALTER TABLE `scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scans`
--
ALTER TABLE `scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scans`
--
ALTER TABLE `scans`
  ADD CONSTRAINT `scans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
