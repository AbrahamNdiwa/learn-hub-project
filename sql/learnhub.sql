-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3360
-- Generation Time: Mar 10, 2025 at 10:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learnhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `note_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `user_id`, `action`, `note_id`, `created_at`) VALUES
(1, 1, 'Bookmarked Note', 6, '2025-03-10 20:34:30'),
(2, 1, 'Removed from Bookmarks', 6, '2025-03-10 20:34:31'),
(3, 1, 'Bookmarked Note', 6, '2025-03-10 20:34:33'),
(4, 1, 'Removed from Bookmarks', 6, '2025-03-10 20:34:33'),
(5, 1, 'Bookmarked Note', 6, '2025-03-10 20:34:34'),
(6, 1, 'Removed from Bookmarks', 6, '2025-03-10 20:34:37'),
(7, 1, 'Bookmarked Note', 6, '2025-03-10 20:34:37'),
(8, 1, 'Removed from Bookmarks', 6, '2025-03-10 20:34:37'),
(9, 1, 'Bookmarked Note', 7, '2025-03-10 20:35:11'),
(10, 1, 'Removed from Bookmarks', 7, '2025-03-10 20:35:12'),
(11, 1, 'Bookmarked Note', 7, '2025-03-10 20:35:13'),
(12, 1, 'Removed from Bookmarks', 7, '2025-03-10 20:35:14'),
(13, 1, 'Bookmarked Note', 7, '2025-03-10 20:35:15'),
(15, 1, 'Added a New Note', 8, '2025-03-10 20:38:27'),
(16, 1, 'Updated Note', NULL, '2025-03-10 20:39:09'),
(17, 1, 'Updated Note', 8, '2025-03-10 20:40:06'),
(18, 1, 'Bookmarked Note', 8, '2025-03-10 20:41:28'),
(19, 1, 'Removed from Bookmarks', 8, '2025-03-10 20:41:30'),
(20, 1, 'Bookmarked Note', 8, '2025-03-10 20:41:34'),
(21, 1, 'Removed from Bookmarks', 8, '2025-03-10 20:44:09'),
(22, 1, 'Bookmarked Note', 8, '2025-03-10 20:44:23'),
(23, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:44:32'),
(24, 1, 'Bookmarked Note', 3, '2025-03-10 20:44:48'),
(25, 1, 'Removed from Bookmarks', 3, '2025-03-10 19:44:49'),
(26, 1, 'Bookmarked Note', 3, '2025-03-10 20:46:25'),
(27, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:46:25'),
(28, 1, 'Bookmarked Note', 3, '2025-03-10 20:46:26'),
(29, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:46:26'),
(30, 1, 'Bookmarked Note', 3, '2025-03-10 20:46:26'),
(31, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:46:26'),
(32, 1, 'Bookmarked Note', 3, '2025-03-10 20:46:26'),
(33, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:46:27'),
(34, 1, 'Bookmarked Note', 3, '2025-03-10 20:48:07'),
(35, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:48:07'),
(36, 1, 'Bookmarked Note', 3, '2025-03-10 20:50:17'),
(37, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:50:18'),
(38, 1, 'Bookmarked Note', 3, '2025-03-10 20:50:21'),
(39, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:50:21'),
(40, 1, 'Bookmarked Note', 3, '2025-03-10 20:50:42'),
(41, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:50:42'),
(42, 1, 'Bookmarked Note', 3, '2025-03-10 20:50:43'),
(43, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:50:43'),
(44, 1, 'Bookmarked Note', 3, '2025-03-10 20:53:51'),
(45, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:53:51'),
(46, 1, 'Bookmarked Note', 3, '2025-03-10 20:58:02'),
(47, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:58:02'),
(48, 1, 'Bookmarked Note', 3, '2025-03-10 20:58:03'),
(49, 1, 'Removed from Bookmarks', 3, '2025-03-10 20:58:03'),
(50, 1, 'Bookmarked Note', 1, '2025-03-10 21:02:34'),
(51, 1, 'Removed from Bookmarks', 1, '2025-03-10 21:02:34'),
(52, 1, 'Bookmarked Note', 1, '2025-03-10 21:02:35'),
(53, 1, 'Removed from Bookmarks', 1, '2025-03-10 21:02:35'),
(54, 1, 'Bookmarked Note', 1, '2025-03-10 21:02:35'),
(55, 1, 'Removed from Bookmarks', 1, '2025-03-10 21:02:35'),
(56, 1, 'Bookmarked Note', 1, '2025-03-10 21:02:35'),
(57, 1, 'Added a New Note', 9, '2025-03-10 21:03:32'),
(58, 1, 'Bookmarked Note', 9, '2025-03-10 21:04:23'),
(59, 1, 'Removed from Bookmarks', 9, '2025-03-10 21:04:24'),
(60, 1, 'Bookmarked Note', 9, '2025-03-10 21:04:24'),
(61, 1, 'Removed from Bookmarks', 9, '2025-03-10 21:08:25'),
(62, 1, 'Removed from Bookmarks', 7, '2025-03-10 21:08:34'),
(63, 1, 'Bookmarked Note', 7, '2025-03-10 21:08:35'),
(64, 1, 'Bookmarked Note', 3, '2025-03-10 21:09:12'),
(65, 1, 'Removed from Bookmarks', 8, '2025-03-10 21:17:58'),
(66, 1, 'Bookmarked Note', 9, '2025-03-10 21:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `note_id`, `created_at`) VALUES
(8, 4, 3, '2025-03-04 12:57:00'),
(9, 4, 1, '2025-03-04 12:57:09'),
(10, 3, 4, '2025-03-04 12:59:28'),
(70, 1, 1, '2025-03-10 21:02:35'),
(73, 1, 7, '2025-03-10 21:08:35'),
(74, 1, 3, '2025-03-10 21:09:12'),
(75, 1, 9, '2025-03-10 21:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `note_id`, `created_at`) VALUES
(1, 1, 1, '2025-03-04 12:29:24'),
(2, 3, 4, '2025-03-04 12:59:28'),
(3, 1, 4, '2025-03-04 13:05:13'),
(4, 1, 6, '2025-03-10 07:28:41'),
(5, 1, 3, '2025-03-10 17:43:17'),
(6, 1, 7, '2025-03-10 20:27:10'),
(7, 1, 9, '2025-03-10 21:05:19'),
(8, 1, 8, '2025-03-10 21:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `bookmarks` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `category`, `bookmarks`, `likes`, `views`, `created_at`) VALUES
(1, 1, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Physics', 2, 1, 50, '2025-03-04 08:18:55'),
(3, 4, 'Why do we use it?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'Chemistry', 2, 1, 37, '2025-03-04 12:55:51'),
(4, 4, 'Where can I get some?', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Biology', 1, 2, 14, '2025-03-04 12:56:14'),
(6, 1, 'Test', 'On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish.', 'Chemistry', 0, 1, 25, '2025-03-10 07:24:41'),
(7, 1, 'Denouncing pleasure and praising pain', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. ', 'Math', 1, 1, 12, '2025-03-10 19:21:05'),
(8, 1, 'Failure', 'Fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always hold', 'Math', 0, 1, 9, '2025-03-10 20:38:27'),
(9, 1, 'Last test', 'Test', 'Math', 1, 1, 9, '2025-03-10 21:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'Mary Kiwi', 'maryk@gmail.com', '$2y$10$8R0VO7uzMTamhD4bvooY9eY/C0nvWtWdzDIGzMD3CMG7gtn4KTqby', '2025-03-04 07:53:24'),
(3, 'John Doe', 'john@gmail.com', '$2y$10$gCH3.SSwm28MSb2pDq031.thIvDQ9Ivzra3TmLJsn1GqqsGbaz0iu', '2025-03-04 12:51:16'),
(4, 'Jane Doe', 'jane@gmail.com', '$2y$10$a27AHGYXpyQr3n0c.nv1m.qzhutrNKqflW0vcwhOZ2NO.SW9sRtBW', '2025-03-04 12:55:00'),
(5, 'Ndiwa Test', 'ndish@gmail.com', '$2y$10$ESWKnPa3mDIue3ht25FizO9EnU63ks0gtXunHa3Lo0LOoHnIPqcgS', '2025-03-10 19:19:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`note_id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
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
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
