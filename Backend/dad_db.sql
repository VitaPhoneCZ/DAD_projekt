-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 05:48 PM
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
-- Database: `dad_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_codes`
--

CREATE TABLE `password_reset_codes` (
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Otevřený','Uzavřený') DEFAULT 'Otevřený',
  `priority` enum('Nízká','Střední','Vysoká') NOT NULL,
  `platform` enum('Windows','Mac','Linux','Android','iPhone') NOT NULL,
  `created_at` datetime NOT NULL,
  `closed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `priority`, `platform`, `created_at`, `closed_at`) VALUES
(1, 1, 'test', 'testtt', 'Uzavřený', 'Střední', 'Linux', '2025-03-28 10:53:10', '2025-03-28 17:24:51'),
(2, 1, 'test2', 'omgpomoc', 'Uzavřený', 'Vysoká', 'Mac', '2025-03-28 11:10:59', '2025-03-28 15:38:30'),
(3, 2, 'amognus', 'simon je gej', 'Otevřený', 'Vysoká', 'iPhone', '2025-03-28 11:22:58', NULL),
(4, 4, 'test test1', 'tady neni problem', 'Uzavřený', 'Nízká', 'Android', '2025-03-28 16:34:28', '2025-03-28 17:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `ticket_id`, `user_id`, `message`, `created_at`) VALUES
(1, 4, 1, 'Test 1 od Admina', '2025-03-28 16:12:30'),
(2, 4, 4, 'Test 2 od uakladatele', '2025-03-28 16:12:52'),
(3, 4, 1, '?', '2025-03-28 16:19:12'),
(4, 1, 1, 'zdar xd', '2025-03-28 16:24:42'),
(5, 1, 1, 'muj vlastni ticket', '2025-03-28 16:24:49'),
(6, 1, 1, 'Ticket byl uzavřen uživatelem ', '2025-03-28 16:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `created_at`, `password`) VALUES
(1, 'Admin', 'vitek.fikrle@student.souepl.cz', 'it', '2025-03-11 08:25:38', '$2y$10$Zk3meW1CZxcKryZ04sGeoe6wzgW799SNBFSKit8Pt0mmdKMft7ww6'),
(2, 'Admin2', 'simon.opatrny@student.souepl.cz', 'ucitel', '2025-03-12 07:55:24', '$2y$10$hQZ/sNfQ9jF/NMr4yiefnefA0WfIkjpKHnnfDT2qHH/p7ee8iHxJG'),
(3, 'SkidybySigmál', 'ne@seznam.cz', 'zak', '2025-03-12 08:59:20', '$2y$10$bp/e3yFyIDY4T87y0FqUP.glXv0eJbmXB/uLt6pR5NjC5TRex93Zm'),
(4, 'test1@gmail.com', 'test1@gmail.com', 'zak', '2025-03-24 09:24:36', '$2y$10$Nm2MqWa.9jW4e3Z8f1o5HOJVztvrwrHlW..IPPlIuFJVHxxn74mFi'),
(5, 'test2@gmail.com', 'test2@gmail.com', 'zak', '2025-03-24 09:24:43', '$2y$10$bWbPz2WEsNS2NZ8GkygdLODRauvGK550Qzgy4DsLAJ3x6L7G3tOl.'),
(6, 'test3@gmail.com', 'test3@gmail.com', 'zak', '2025-03-24 09:24:54', '$2y$10$1r6lzGBRDs9Qx/k.t5zEzO0OSViDOB3LzKZQVSFWRrPuUx2rJi.Vi'),
(8, 'test', 'testf@senam.cz', 'zak', '2025-03-24 12:51:52', '$2y$10$Ix.iupgov9QMXoQGe..njOEIEwwaraHjk2w2JiEfxn0RJkL.JqEJy'),
(9, 'daryna', 'Daryna.Toporovska@student.souepl.cz', 'it', '2025-03-24 13:08:07', '$2y$10$rZs464fiv4m2vxq/wqgxpOgG26GI.4QdL1PO3/89u84DAb6E4B/ry'),
(10, 'Anonym2000', 'Honza@gmail.com', 'zak', '2025-03-24 15:10:56', '$2y$10$/3UAbL7xQmdah5x497rd1O24nrdvTjwGCVr734ks56qDPkaUHhIn2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_reset_codes`
--
ALTER TABLE `password_reset_codes`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
