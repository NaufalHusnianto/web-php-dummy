-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 01, 2026 at 03:16 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `year_published` year DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `rack_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `year_published`, `genre`, `rack_id`, `created_at`, `updated_at`) VALUES
(1, 'Fajar menari', 'Joko Suseno', '123EFGH', '2021', 'Cerita Rakyat', 1, '2024-10-02 14:15:12', '2024-10-02 14:15:12'),
(4, 'IKATAN KOVALEN', 'Joko suseno', 'K45552', '2017', 'Kemia', 3, '2024-10-04 00:10:33', '2024-10-04 00:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  `loan_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned') DEFAULT 'borrowed',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `book_id`, `loan_date`, `return_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-10-03', '2024-10-09', 'returned', '2024-10-02 22:59:52', '2024-10-08 13:30:41'),
(3, 2, 4, '2024-10-04', '2024-10-08', 'returned', '2024-10-04 00:32:22', '2024-10-08 13:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `attempts` int DEFAULT '1',
  `last_attempt` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `email`, `attempts`, `last_attempt`) VALUES
(4, '192.168.1.2', 'admin@email.com', 5, '2026-01-01 15:02:30');

-- --------------------------------------------------------

--
-- Table structure for table `racks`
--

CREATE TABLE `racks` (
  `id` int NOT NULL,
  `rack_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `racks`
--

INSERT INTO `racks` (`id`, `rack_name`, `created_at`, `updated_at`) VALUES
(1, 'Rak Cerita Rakyat', '2024-10-02 14:14:20', '2024-10-02 14:14:20'),
(3, 'Kimia', '2024-10-03 23:59:34', '2024-10-03 23:59:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Naufal Husnianto', 'husniantonaufal@email.com', '$2y$10$Hkr9zoQRBwPWWY2///oJ2e2tS/gfJzupxNzttM2haYb4gte2Cx2yy', 'user', '2024-10-02 22:54:15', '2024-10-08 13:04:03'),
(2, 'Excel Arion', 'pandik@gmail.com', '$2y$10$CINuc7Vw9VzuLfP66mNkLepEnVFXflA305PVmY.JcF3VyaJgSd.Vq', 'user', '2024-10-04 00:16:54', '2024-10-04 00:16:54'),
(4, 'wadaw', 'aldi@email.com', '$2y$10$8xbh.Q/RcqXuOE7O/6h93OLvVuXx0dKJSzRyP96QnnKRJiJEbsL7.', 'user', '2024-10-04 02:34:45', '2024-10-04 02:34:45'),
(5, 'c', 'karina@email.com', '$2y$10$2QVPt2S05SiZ3Q09LYr5IufP04isMZQaqsAzV5TO1nOFR6x/L8sL6', 'user', '2025-12-22 05:06:52', '2025-12-22 05:06:52'),
(6, '<script>alert(\"XSS berhasil\")</script>', 'abc@email.com', '$2y$10$C0xS6XPSWmbozhc7Hz3SM.HZyVNRo2R4SuqR8luDiY3r.md/z81j.', 'user', '2025-12-22 05:09:22', '2025-12-22 05:09:22'),
(7, '<script>alert(\"XSS berhasil\")</script>', 'ali@email.com', '$2y$10$ErOdv0ffqI0WcXm30MOK8u0e75TeYxz.x4vEggxYnKGIRPwJ86khC', 'user', '2025-12-22 05:17:04', '2025-12-22 05:17:04'),
(8, 'admin', 'admin@email.com', '$2y$10$CINuc7Vw9VzuLfP66mNkLepEnVFXflA305PVmY.JcF3VyaJgSd.Vq', 'admin', '2026-01-01 13:27:13', '2026-01-01 13:30:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `rack_id` (`rack_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_email` (`ip_address`,`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_ip` (`ip_address`),
  ADD KEY `idx_last_attempt` (`last_attempt`);

--
-- Indexes for table `racks`
--
ALTER TABLE `racks`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `racks`
--
ALTER TABLE `racks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`rack_id`) REFERENCES `racks` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
