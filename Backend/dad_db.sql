-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 17. dub 2025, 17:07
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
(1, 1, 'test', 'testtt', 'Uzavřený', 'Střední', 'Linux', '2025-03-28 10:53:10', '2025-03-28 17:24:51'),
(2, 1, 'test2', 'omgpomoc', 'Uzavřený', 'Vysoká', 'Mac', '2025-03-28 11:10:59', '2025-03-28 15:38:30'),
(3, 2, 'amognus', 'simon je gej', 'Uzavřený', 'Vysoká', 'iPhone', '2025-03-28 11:22:58', '2025-03-31 08:14:36'),
(4, 4, 'test test1', 'tady neni problem', 'Uzavřený', 'Nízká', 'Android', '2025-03-28 16:34:28', '2025-03-28 17:15:58'),
(5, 4, 'pomoc', 'ja amm problem se sranim', 'Uzavřený', 'Vysoká', 'Android', '2025-03-31 08:07:59', '2025-03-31 08:09:45'),
(6, 4, 'Crashování systému', 'Dobrý den, když se snažím zapnout databázi na mém telefonu tak padá', 'Uzavřený', 'Střední', 'iPhone', '2025-04-01 11:57:09', '2025-04-01 12:06:44'),
(7, 4, 'testttt', 'ano test', 'Otevřený', 'Nízká', 'Windows', '2025-04-01 13:10:40', NULL),
(8, 4, 'aded', 'dfgtč', 'Otevřený', 'Střední', 'Mac', '2025-04-01 13:43:46', NULL),
(9, 4, 'kkkkk', 'amogus', 'Uzavřený', 'Vysoká', 'Linux', '2025-04-01 13:52:04', '2025-04-01 13:52:58'),
(10, 4, 'novy tik', 'dyk more', 'Otevřený', 'Střední', 'Android', '2025-04-15 11:55:19', NULL),
(11, 4, 'test', 'testttt', 'Otevřený', 'Nízká', 'Windows', '2025-04-15 13:12:01', NULL),
(12, 1, 'asdasdasdasd', 'asdasdasd', 'Otevřený', 'Vysoká', 'Linux', '2025-04-17 15:45:02', NULL),
(13, 1, 'asdasdasdasdasd', 'sdsdsdsd', 'Otevřený', 'Střední', 'Windows', '2025-04-17 15:48:05', NULL),
(14, 1, '77855441', '4444', 'Otevřený', 'Střední', 'Linux', '2025-04-17 15:52:23', NULL),
(15, 4, 'fgfgfg', 'vghhhh', 'Otevřený', 'Nízká', 'Windows', '2025-04-17 15:56:15', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `ticket_id`, `user_id`, `message`, `created_at`) VALUES
(1, 4, 1, 'Test 1 od Admina', '2025-03-28 16:12:30'),
(2, 4, 4, 'Test 2 od uakladatele', '2025-03-28 16:12:52'),
(3, 4, 1, '?', '2025-03-28 16:19:12'),
(4, 1, 1, 'zdar xd', '2025-03-28 16:24:42'),
(5, 1, 1, 'muj vlastni ticket', '2025-03-28 16:24:49'),
(6, 1, 1, 'Ticket byl uzavřen uživatelem ', '2025-03-28 16:24:51'),
(7, 5, 1, 'co je tvuj promlem?', '2025-03-31 06:08:20'),
(8, 5, 4, 'mam ucpanou prdel', '2025-03-31 06:08:37'),
(9, 5, 1, 'oducpi pripad uzavren', '2025-03-31 06:09:39'),
(10, 5, 1, 'Ticket byl uživatelem uzavřen', '2025-03-31 06:09:45'),
(11, 3, 1, 'to není probklém to je fakt', '2025-03-31 06:14:34'),
(12, 3, 1, 'Ticket byl uživatelem uzavřen', '2025-03-31 06:14:36'),
(13, 6, 1, 'Zdravím, omlouvám se ale na iphone ios je databáže estě šaptně optimalizovaná', '2025-04-01 09:57:50'),
(14, 6, 4, 'Dobrý den, díky za odpověď, bude se oprava toho někdy řešit?', '2025-04-01 09:58:21'),
(15, 6, 1, 'Ano, čekáme na vývojáře aplikace až vydají aktualizaci která to opraví, mezitím můžete to otevírat na jiném zařízení nebo vím půjčíme android telefon', '2025-04-01 09:59:22'),
(16, 6, 4, 'Díky moc za informaci, tak já to pro zatím budu otevírat na svém počítačí', '2025-04-01 10:06:30'),
(17, 6, 4, 'Ticket byl uživatelem uzavřen', '2025-04-01 10:06:44'),
(18, 7, 4, 'test', '2025-04-01 11:14:55'),
(19, 7, 4, 'test', '2025-04-01 11:17:13'),
(20, 9, 1, 'zdar', '2025-04-01 11:52:37'),
(21, 9, 4, 'sdfsdf', '2025-04-01 11:52:54'),
(22, 9, 4, 'Ticket byl uživatelem uzavřen', '2025-04-01 11:52:58'),
(23, 7, 4, 'asdf', '2025-04-01 11:59:11'),
(24, 7, 4, 'sdf', '2025-04-01 11:59:12'),
(25, 7, 4, 'sdf', '2025-04-01 11:59:12'),
(26, 7, 4, 'sdf', '2025-04-01 11:59:13'),
(27, 7, 4, 'sdfsdf', '2025-04-01 11:59:15'),
(28, 10, 1, 'no', '2025-04-15 09:57:03'),
(29, 10, 1, 'no', '2025-04-15 09:59:45'),
(30, 10, 1, 'ne', '2025-04-15 10:04:29'),
(31, 10, 1, 'noo', '2025-04-15 10:09:13'),
(32, 10, 4, 'jo', '2025-04-15 11:04:17'),
(33, 11, 4, 'j', '2025-04-15 11:13:02'),
(34, 11, 4, 'j', '2025-04-15 11:20:41'),
(35, 12, 1, 'drth', '2025-04-17 13:45:33'),
(36, 15, 4, 'ahoj test', '2025-04-17 14:03:27'),
(37, 15, 4, 'test', '2025-04-17 14:12:05'),
(38, 15, 4, 'test', '2025-04-17 14:24:12'),
(39, 15, 4, 'test', '2025-04-17 14:47:52'),
(40, 15, 4, 'test', '2025-04-17 14:48:08'),
(41, 15, 4, 'testt', '2025-04-17 14:50:28');

-- --------------------------------------------------------

--
-- Struktura tabulky `unread_notifications`
--

CREATE TABLE `unread_notifications` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_count` int(11) DEFAULT NULL,
  `read_by` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `unread_notifications`
--

INSERT INTO `unread_notifications` (`id`, `ticket_id`, `user_id`, `notification_count`, `read_by`) VALUES
(1, 8, 4, 1, ',1,4'),
(2, 10, 4, 1, ',1,4'),
(3, 11, 1, 1, ',4,1'),
(6, 15, 4, 1, '4,1');

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
-- Indexy pro tabulku `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `unread_notifications`
--
ALTER TABLE `unread_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unread_notifications_fk_ticket` (`ticket_id`),
  ADD KEY `unread_notifications_fk_user` (`user_id`),
  ADD KEY `unread_notifications_fk_read_by` (`read_by`(768));

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pro tabulku `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pro tabulku `unread_notifications`
--
ALTER TABLE `unread_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

--
-- Omezení pro tabulku `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `unread_notifications`
--
ALTER TABLE `unread_notifications`
  ADD CONSTRAINT `unread_notifications_fk_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unread_notifications_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
