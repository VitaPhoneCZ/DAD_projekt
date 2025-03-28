-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 28. bře 2025, 11:33
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `dad_db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `password_reset_codes`
--

CREATE TABLE `password_reset_codes` (
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `tickets`
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
-- Vypisuji data pro tabulku `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `priority`, `platform`, `created_at`, `closed_at`) VALUES
(1, 1, 'test', 'testtt', 'Otevřený', 'Střední', 'Linux', '2025-03-28 10:53:10', NULL),
(2, 1, 'test2', 'omgpomoc', 'Uzavřený', 'Vysoká', 'Mac', '2025-03-28 11:10:59', NULL),
(3, 2, 'amognus', 'simon je gej', 'Otevřený', 'Vysoká', 'iPhone', '2025-03-28 11:22:58', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
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
-- Vypisuji data pro tabulku `users`
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
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `password_reset_codes`
--
ALTER TABLE `password_reset_codes`
  ADD PRIMARY KEY (`email`);

--
-- Indexy pro tabulku `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
