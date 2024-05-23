-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2023 at 12:05 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brainster_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `bio` varchar(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`, `bio`, `deleted_at`) VALUES
(1, 'Andrej', 'Spasovfewfew', 'EBI', '2023-11-13 21:57:57'),
(2, 'Andrej', 'Spasov', 'najjak', '2023-11-13 22:05:51'),
(3, 'Fugazi', 'Mazi', 'fmroeifmeroif', '2023-11-14 00:17:29'),
(4, 'fneifwndfweo', 'Spasov', 'HEYEY', '2023-11-13 22:05:52'),
(5, 'Fugazi', 'Mazi', 'vrska nema', '2023-11-14 00:11:56'),
(6, 'Fugazi', 'Mazi', 'djfnjef', '2023-11-14 00:17:03'),
(7, 'Fugazi', 'Mazi', 'dnjef', NULL),
(8, 'wefwfe', 'wfewef', 'wfeefw', NULL),
(9, 'wefwfe', 'wfeewf', 'wfeewfewf', NULL),
(10, 'Test', 'Test', 'Testing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `year_published` year(4) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `img_url` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author_id`, `year_published`, `number_of_pages`, `img_url`, `category_id`) VALUES
(7, 'to kill a mockingbird', 7, '2000', 250, 'https://upload.wikimedia.org/wikipedia/commons/4/4f/To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg', 13),
(8, '5000', 9, '2006', 190, 'https://upload.wikimedia.org/wikipedia/commons/4/4f/To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg', 12),
(9, 'Testing', 10, '1955', 105, 'https://images.squarespace-cdn.com/content/v1/5d40204073334a0001f2f066/1602439836717-GUAAN9EXNKDOGD9SKKZM/3674767a84174c9df69d8706e755e37a.jpg?format=2500w', 14);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `deleted_at`) VALUES
(1, 'asAndrejrv3fssxasaaa', '2023-11-12 21:19:19'),
(2, '213f33r3dd3d', '2023-11-12 21:28:01'),
(3, 'Horrore', '2023-11-12 21:27:56'),
(4, 'dThriller3', '2023-11-12 21:14:07'),
(5, 'efrferfr', '2023-11-13 21:38:34'),
(6, 'Horror', '2023-11-13 21:27:41'),
(7, 'wefwfwewdwe', NULL),
(8, 'rfeffsfsdsds', NULL),
(9, 'Horror', NULL),
(10, 'wfeewfwefewf', NULL),
(11, 'fweweffew', NULL),
(12, 'Comedy', NULL),
(13, 'Statix', NULL),
(14, 'Romance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `user_id`, `book_id`, `is_approved`) VALUES
(10, 'nuiiujiuihiuhbUBUYBUYBUYBUBYUB', 6, 7, 1),
(11, 'eferfe', 2, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `note` text DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `book_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `note`, `user_id`, `book_id`) VALUES
(1, 'I HATE THIS BOOK', 2, 7),
(3, 'Hi there', 2, 8),
(126, 'NDFWIUENFWIFN', 5, 7),
(127, 'ewfwefw', 5, 7),
(128, 'wefwefw', 5, 7),
(130, 'wefwef', 6, 7),
(132, 'sfsfs', 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `username`, `password`, `role`) VALUES
(1, 'andrej', 'spasov', 'andrewspasov@yahoo.com', 'andrej', 'andrej', 'admin'),
(2, 'evgenija', 'koteska', 'evgenija@yahoo.com', 'evgenija', 'evgenija', 'user'),
(3, 'Andrej', 'Spasov', 'aspasov2@auvoriaprime.com', 'Andretheruler27', '$2y$10$5kc.vSY8Ef5mV9VHA2b51eK523b6jrHxKkL/dEfWb7Uh1nw2bM02a', 'user'),
(4, 'Mihajlo', 'Mitev', 'maha@yahoo.com', 'maha', '$2y$10$rDCeaUITT/cyw3ThP.BxCuIX3JTtbQvJ87jTD2TyExCBAbZL6V2LS', 'admin'),
(5, 'andrej', 'spasov', 'frefer@yahoo.com', 'lara', 'lara', 'user'),
(6, 'Stefan', 'Nedelkov', 'stefanda@yahoo.com', 'stefan', '$2y$10$9TH6tOiHmNb2xzpTGc6/1OXnnJcEZU/NnyFlvkoUquRHa.bTyLIfO', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
