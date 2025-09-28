-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 28, 2025 at 12:55 PM
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
-- Database: `n3_sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `equipment_id` int NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `status` enum('pending','borrowed','returned') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_at` datetime DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`id`, `user_id`, `equipment_id`, `qty`, `status`, `created_at`, `due_at`, `note`) VALUES
(19, 2, 4, 1, 'returned', '2025-09-28 18:26:45', '2025-10-12 23:59:59', ''),
(20, 4, 3, 1, 'returned', '2025-09-28 18:42:24', '2025-10-12 23:59:59', ''),
(21, 4, 3, 1, 'returned', '2025-09-28 19:01:50', '2025-10-12 23:59:59', ''),
(22, 11, 4, 1, 'returned', '2025-09-28 19:40:19', '2025-10-12 23:59:59', ''),
(23, 4, 2, 1, 'returned', '2025-09-28 19:53:47', '2025-10-12 23:59:59', '');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `description`, `image_url`, `stock`) VALUES
(1, 'Football', 'ลูกฟุตบอล ขนาด 5', 'https://images.unsplash.com/photo-1486286701208-1d58e9338013?fm=jpg&q=60&w=1200', 8),
(2, 'Basketball', 'ลูกบาส ไซซ์ 7', 'https://images.unsplash.com/photo-1546519638-68e109498ffc?fm=jpg&q=60&w=1200', 5),
(3, 'Volleyball', 'วอลเลย์บอล มาตรฐาน', 'https://cdn1.sportngin.com/attachments/call_to_action/e349-190383150/DSC01633-153_large.jpg', 2),
(4, 'Badminton Set', 'ไม้ + ลูกขนไก่', 'https://assets.superblog.ai/site_cuid_clr6oh1no0006rmr89yhkxgu8/images/badminton-14280461280-1721457562607-compressed.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `phone`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@localhost', '12345678', 'admin'),
(2, 'mockito', 'mock', 'mock', 'mock@localhost', '123456', 'user'),
(4, 'brian', 'brian', 'brian', 'brian@localhost', '0878857451', 'user'),
(10, 'rick', 'rick', '123456789', 'rick@localhost', '0878857451', 'user'),
(11, 'takumi_ae86', 'takumi', '24102546', 'takumi@mail.com', '+66615595149', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_borrows_user_status` (`user_id`,`status`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
