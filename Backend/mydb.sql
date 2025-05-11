-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: endora-db-11.stable.cz:3306
-- Generation Time: Apr 26, 2025 at 12:12 AM
-- Server version: 10.3.35-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dad`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_codes`
--

CREATE TABLE `password_reset_codes` (
  `email` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `password_reset_codes`
--

INSERT INTO `password_reset_codes` (`email`, `code`) VALUES
('Vaclav.Vostatek@student.souepl.cz', '746120'),
('Simon.Opatrny@student.souepl.cz', '418956'),
('Simon.OpatrnyIT@student.souepl.cz', '655105'),
('Roman.Demianenko@student.souepl.cz', '946832'),
('Roman.DemianenkoIT@student.souepl.cz', '853771');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `priority`, `platform`, `created_at`, `closed_at`) VALUES
(1, 1, 'test', 'testtt', 'Uzavřený', 'Střední', 'Linux', '2025-03-28 10:53:10', '2025-03-28 17:24:51'),
(2, 1, 'test2', 'omgpomoc', 'Uzavřený', 'Vysoká', 'Mac', '2025-03-28 11:10:59', '2025-03-28 15:38:30'),
(3, 2, 'amognus', 'simon je gej', 'Uzavřený', 'Vysoká', 'iPhone', '2025-03-28 11:22:58', '2025-03-31 08:14:36'),
(4, 4, 'test test1', 'tady neni problem', 'Uzavřený', 'Nízká', 'Android', '2025-03-28 16:34:28', '2025-03-28 17:15:58'),
(5, 4, 'pomoc', 'ja amm problem se sranim', 'Uzavřený', 'Vysoká', 'Android', '2025-03-31 08:07:59', '2025-03-31 08:09:45'),
(6, 4, 'Crashování systému', 'Dobrý den, když se snažím zapnout databázi na mém telefonu tak padá', 'Uzavřený', 'Střední', 'iPhone', '2025-04-01 11:57:09', '2025-04-01 12:06:44'),
(7, 4, 'testttt', 'ano test', 'Uzavřený', 'Nízká', 'Windows', '2025-04-01 13:10:40', '2025-04-24 16:51:50'),
(8, 4, 'aded', 'dfgtč', 'Uzavřený', 'Střední', 'Mac', '2025-04-01 13:43:46', '2025-04-24 18:00:19'),
(9, 4, 'kkkkk', 'amogus', 'Uzavřený', 'Vysoká', 'Linux', '2025-04-01 13:52:04', '2025-04-01 13:52:58'),
(10, 4, 'novy tik', 'dyk more', 'Uzavřený', 'Střední', 'Android', '2025-04-15 11:55:19', '2025-04-24 18:00:30'),
(11, 4, 'test', 'testttt', 'Uzavřený', 'Nízká', 'Windows', '2025-04-15 13:12:01', '2025-04-24 18:00:51'),
(12, 1, 'asdasdasdasd', 'asdasdasd', 'Uzavřený', 'Vysoká', 'Linux', '2025-04-17 15:45:02', '2025-04-24 18:00:56'),
(13, 1, 'asdasdasdasdasd', 'sdsdsdsd', 'Uzavřený', 'Střední', 'Windows', '2025-04-17 15:48:05', '2025-04-24 18:02:39'),
(14, 1, '77855441', '4444', 'Uzavřený', 'Střední', 'Linux', '2025-04-17 15:52:23', '2025-04-24 18:02:50'),
(15, 4, 'fgfgfg', 'vghhhh', 'Uzavřený', 'Nízká', 'Windows', '2025-04-17 15:56:15', '2025-04-24 17:43:33'),
(16, 1, 'novy test', 'juchůůůůůůů', 'Uzavřený', 'Střední', 'iPhone', '2025-04-24 16:34:45', '2025-04-24 18:02:45'),
(17, 11, 'jasna tutovka', 'gamba', 'Uzavřený', 'Vysoká', 'Android', '2025-04-24 16:46:03', '2025-04-24 16:46:50'),
(18, 4, 'Moje VR umí jen zelenou barvu', 'Můj Oculus Rift umí jen zelenou barvu, a to jede přes HDMI\r\nMam AMD grafiku, to s tím nesouvisí že ne?', 'Uzavřený', 'Vysoká', 'Windows', '2025-04-24 17:25:11', '2025-04-24 18:03:56'),
(19, 12, 'Monitor isue', 'Můj počítač má při zapnutí velký problém.\r\nKdyž ho zapnu, druhá obrazovka se rozdělí na 4 části. Jedna je normální jako vždy, ale zbylé jsou pouze duplikáty té první. Jde to nějak opravit? (já to opravuji tím že obrazovku vypojím z napájení)', 'Uzavřený', 'Vysoká', 'Windows', '2025-04-24 17:26:27', '2025-04-24 17:30:21'),
(20, 12, 'Re: monitor isue', 'Můj počítač má při zapnutí velký problém.\r\nKdyž ho zapnu, druhá obrazovka se rozdělí na 4 části. Jedna je normální jako vždy, ale zbylé jsou pouze duplikáty té první. Jde to nějak opravit? \r\n(já to opravuji tím že obrazovku vypojím z napájení)\r\njsem ochoten zaplatit nemalé peníze mám k tomuto monitoru citový vztah a chci ho jen zpravit', 'Uzavřený', 'Vysoká', 'Windows', '2025-04-24 17:32:54', '2025-04-24 18:04:06'),
(21, 12, 'Mám problém s vyděním tiketů', 'nejsou vidět tikety', 'Uzavřený', 'Nízká', 'Windows', '2025-04-24 17:33:54', '2025-04-24 17:43:23'),
(22, 12, 'Mám problém s vyděním tiketů', 'nejsou vidět tikety', 'Uzavřený', 'Nízká', 'Windows', '2025-04-24 17:33:54', '2025-04-24 17:43:05'),
(23, 12, 'problém s duplikací', 'jakto že se vytvořili 2 tikety i když jsem vytvořil pouze jeden??', 'Uzavřený', 'Nízká', 'Windows', '2025-04-24 17:36:59', '2025-04-24 17:41:42'),
(24, 6, 'Pomoc šimon je niga', 'Šimon nezbírá bavlnu a je niga pls help', 'Uzavřený', 'Vysoká', 'Android', '2025-04-25 08:52:00', '2025-04-25 09:05:05'),
(25, 5, 'ŠimoNIGGA', 'Šimon je Kniger LOL Opice, Vítek mi dal přístup, FRAJER!', 'Uzavřený', 'Vysoká', 'Android', '2025-04-25 08:53:53', '2025-04-25 09:06:33'),
(26, 12, 'IP problém', 'jde využívat jeden account z více IP??', 'Otevřený', 'Střední', 'Windows', '2025-04-25 09:04:22', NULL),
(27, 12, 'Název panelu', 'zjitil jsem že při vytváření tiketu je nahoře v názvu panelu \"Vytvořit nový ticket\" což vypadá dobře ale když otevřu dashboard je vydět mnohem propracovanější strukura názvu a to ve stylu \"Otevřené tickety | Ticket Sistem\" což vypadá mnohem lépe', 'Otevřený', 'Vysoká', 'Windows', '2025-04-25 09:15:09', NULL);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_replies`
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
(41, 15, 4, 'testt', '2025-04-17 14:50:28'),
(42, 19, 4, 'Dobrý večer,\r\nobávám se, že se budete muset spokojit jen s první čtvrtinou obrazovky, neboť je takový druh opravy monitoru velice nákladný.\r\nHezký den.', '2025-04-24 15:30:13'),
(43, 23, 1, 'no asi jo no', '2025-04-24 15:41:09'),
(44, 23, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 15:41:42'),
(45, 23, 12, 'a odpoved?', '2025-04-24 15:41:55'),
(46, 22, 1, 'ok', '2025-04-24 15:43:03'),
(47, 22, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 15:43:05'),
(48, 21, 1, 'no nic no, co mam s tim jako dělat', '2025-04-24 15:43:22'),
(49, 21, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 15:43:23'),
(50, 15, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 15:43:33'),
(51, 8, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:00:19'),
(52, 10, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:00:30'),
(53, 11, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:00:51'),
(54, 12, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:00:56'),
(55, 13, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:02:39'),
(56, 16, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:02:45'),
(57, 14, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:02:50'),
(58, 18, 1, 'musíš downgradovat drivery', '2025-04-24 16:03:54'),
(59, 18, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:03:56'),
(60, 20, 1, 'skill issue', '2025-04-24 16:04:05'),
(61, 20, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-24 16:04:06'),
(62, 24, 6, 'Pls pomoct', '2025-04-25 07:02:44'),
(63, 24, 1, 'Postarame se o to', '2025-04-25 07:04:12'),
(64, 26, 1, 'No prej jo', '2025-04-25 07:04:55'),
(65, 24, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-25 07:05:05'),
(66, 25, 1, 'Fr jsem frajer', '2025-04-25 07:06:31'),
(67, 25, 1, 'Ticket byl uživatelem uzavřen ', '2025-04-25 07:06:33'),
(68, 26, 12, 'já mužu uzavřít ticket?', '2025-04-25 07:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `unread_notifications`
--

CREATE TABLE `unread_notifications` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_count` int(11) DEFAULT NULL,
  `read_by` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unread_notifications`
--

INSERT INTO `unread_notifications` (`id`, `ticket_id`, `user_id`, `notification_count`, `read_by`) VALUES
(1, 8, 4, 1, ',1,4'),
(2, 10, 4, 1, ',1,4'),
(3, 11, 1, 1, ',4,1'),
(6, 15, 4, 1, '4,1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `dark_mode` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `created_at`, `password`, `dark_mode`) VALUES
(1, 'Admin', 'vitek.fikrle@student.souepl.cz', 'it', '2025-03-11 08:25:38', '$2y$10$Zk3meW1CZxcKryZ04sGeoe6wzgW799SNBFSKit8Pt0mmdKMft7ww6', 1),
(2, 'Admin2', 'simon.opatrny@student.souepl.cz', 'ucitel', '2025-03-12 07:55:24', '$2y$10$hQZ/sNfQ9jF/NMr4yiefnefA0WfIkjpKHnnfDT2qHH/p7ee8iHxJG', 0),
(3, 'SkidybySigmál', 'ne@seznam.cz', 'zak', '2025-03-12 08:59:20', '$2y$10$bp/e3yFyIDY4T87y0FqUP.glXv0eJbmXB/uLt6pR5NjC5TRex93Zm', 0),
(4, 'test1@gmail.com', 'test1@gmail.com', 'zak', '2025-03-24 09:24:36', '$2y$10$Nm2MqWa.9jW4e3Z8f1o5HOJVztvrwrHlW..IPPlIuFJVHxxn74mFi', 1),
(5, 'test2@gmail.com', 'test2@gmail.com', 'zak', '2025-03-24 09:24:43', '$2y$10$bWbPz2WEsNS2NZ8GkygdLODRauvGK550Qzgy4DsLAJ3x6L7G3tOl.', 0),
(6, 'test3@gmail.com', 'test3@gmail.com', 'zak', '2025-03-24 09:24:54', '$2y$10$1r6lzGBRDs9Qx/k.t5zEzO0OSViDOB3LzKZQVSFWRrPuUx2rJi.Vi', 0),
(8, 'test', 'testf@senam.cz', 'zak', '2025-03-24 12:51:52', '$2y$10$Ix.iupgov9QMXoQGe..njOEIEwwaraHjk2w2JiEfxn0RJkL.JqEJy', 0),
(9, 'daryna', 'Daryna.Toporovska@student.souepl.cz', 'it', '2025-03-24 13:08:07', '$2y$10$rZs464fiv4m2vxq/wqgxpOgG26GI.4QdL1PO3/89u84DAb6E4B/ry', 0),
(10, 'Anonym2000', 'Honza@gmail.com', 'zak', '2025-03-24 15:10:56', '$2y$10$/3UAbL7xQmdah5x497rd1O24nrdvTjwGCVr734ks56qDPkaUHhIn2', 0),
(11, 'Filda test', 'filda@seznam.cz', 'zak', '2025-04-24 14:36:25', '$2y$10$FBrw.aePP/h/gogWtBseFeYxWJ6pyI9A/dUuSwh9ODzqyYTUB/cRy', 0),
(12, 'Marek xddddddd', 'Marek@gmail.com', 'zak', '2025-04-24 15:20:22', '$2y$10$hhEatGiBvzKgrYEWKjgce.49RdnZpcTRGSRhL.S87SoLB6Yo6HFW6', 1),
(13, 'Václav Vostatek', 'Vaclav.Vostatek@student.souepl.cz', 'zak', '2025-04-24 16:15:19', '', 0),
(14, 'Václav Vostatek IT', 'Vaclav.VostatekIT@student.souepl.cz', 'it', '2025-04-24 16:15:38', '$2y$10$tteVoexLIU3TWXToZaCqYep/8j9zk8OQ12YRjH2YP6uyRi2RtIxY2', 0),
(15, 'Šimon Opatrný', 'Simon.Opatrny@student.souepl.cz', 'zak', '2025-04-24 16:20:04', '', 0),
(16, 'Šimon Opatrný IT', 'Simon.OpatrnyIT@student.souepl.cz', 'it', '2025-04-24 16:20:16', '', 0),
(17, 'Roman Demianenko', 'Roman.Demianenko@student.souepl.cz', 'zak', '2025-04-24 16:20:30', '', 0),
(18, 'Roman Demianenko IT', 'Roman.DemianenkoIT@student.souepl.cz', 'it', '2025-04-24 16:20:42', '', 0),
(19, 'Daryna Toporovska ZAK', 'Daryna.ToporovskaZAK@student.souepl.cz', 'zak', '2025-04-24 16:21:01', '$2y$10$J0ROZej04uH/WflevI4BNemS.Tb4ZXc5mJwZloP3jCaVHJSgVUQ36', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
