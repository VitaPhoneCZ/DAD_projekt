-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 04:21 PM
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
  `status` enum('open','in_progress','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(101, 3, 'Problém s přihlášením', 'Uživatel se nemůže přihlásit do systému, hlásí nesprávné heslo.', 'open', '2025-03-20 09:15:00', '2025-03-20 09:15:00'),
(102, 5, 'Chyba při odesílání formuláře', 'Formulář se neodesílá, zobrazuje chybu 500.', 'open', '2025-03-19 13:30:00', '2025-03-19 13:30:00'),
(103, 2, 'Požadavek na reset hesla', 'Uživatel požaduje reset hesla, protože zapomněl staré.', 'open', '2025-03-18 07:45:00', '2025-03-18 07:45:00'),
(104, 4, 'Nezobrazují se notifikace', 'Systém neposílá upozornění na nové zprávy.', 'open', '2025-03-17 15:10:00', '2025-03-17 15:10:00'),
(105, 6, 'Špatné zobrazení stránky v Edge', 'Webová stránka se v prohlížeči Edge rozpadá.', 'open', '2025-03-16 08:25:00', '2025-03-16 08:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

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
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
