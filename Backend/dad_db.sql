-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 24. bře 2025, 10:30
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
  `status` enum('open','in_progress','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(101, 3, 'Problém s přihlášením', 'Uživatel se nemůže přihlásit do systému, hlásí nesprávné heslo.', 'open', '2025-03-20 09:15:00', '2025-03-20 09:15:00'),
(102, 5, 'Chyba při odesílání formuláře', 'Formulář se neodesílá, zobrazuje chybu 500.', 'open', '2025-03-19 13:30:00', '2025-03-19 13:30:00'),
(103, 2, 'Požadavek na reset hesla', 'Uživatel požaduje reset hesla, protože zapomněl staré.', 'open', '2025-03-18 07:45:00', '2025-03-18 07:45:00'),
(104, 4, 'Nezobrazují se notifikace', 'Systém neposílá upozornění na nové zprávy.', 'open', '2025-03-17 15:10:00', '2025-03-17 15:10:00'),
(105, 6, 'Špatné zobrazení stránky v Edge', 'Webová stránka se v prohlížeči Edge rozpadá.', 'open', '2025-03-16 08:25:00', '2025-03-16 08:25:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `ticket_comments`
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
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','agent','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `created_at`, `password`) VALUES
(1, 'Admin', 'vitek.fikrle@student.souepl.cz', 'admin', '2025-03-11 08:25:38', '$2y$10$Zk3meW1CZxcKryZ04sGeoe6wzgW799SNBFSKit8Pt0mmdKMft7ww6'),
(2, 'Admin2', 'simon.opatrny@student.souepl.cz', 'admin', '2025-03-12 07:55:24', '$2y$10$hQZ/sNfQ9jF/NMr4yiefnefA0WfIkjpKHnnfDT2qHH/p7ee8iHxJG'),
(3, 'SkidybySigmál', 'ne@seznam.cz', 'agent', '2025-03-12 08:59:20', '$2y$10$bp/e3yFyIDY4T87y0FqUP.glXv0eJbmXB/uLt6pR5NjC5TRex93Zm'),
(4, 'test1@gmail.com', 'test1@gmail.com', 'user', '2025-03-24 09:24:36', '$2y$10$Nm2MqWa.9jW4e3Z8f1o5HOJVztvrwrHlW..IPPlIuFJVHxxn74mFi'),
(5, 'test2@gmail.com', 'test2@gmail.com', 'user', '2025-03-24 09:24:43', '$2y$10$bWbPz2WEsNS2NZ8GkygdLODRauvGK550Qzgy4DsLAJ3x6L7G3tOl.'),
(6, 'test3@gmail.com', 'test3@gmail.com', 'user', '2025-03-24 09:24:54', '$2y$10$1r6lzGBRDs9Qx/k.t5zEzO0OSViDOB3LzKZQVSFWRrPuUx2rJi.Vi');

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
-- Indexy pro tabulku `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pro tabulku `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
