-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3360
-- Generation Time: Mar 31, 2025 at 02:29 AM
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
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `user_id`, `content`, `created_at`, `approved`) VALUES
(1, 13, 1, 'E-business technologies enable digital transformation by providing online transaction capabilities, improving customer engagement through digital platforms, allowing real-time data analytics, facilitating global market reach, and creating more efficient supply chain management.', '2025-03-30 21:48:43', 1),
(3, 7, 1, 'Creating apps that work seamlessly across different platforms (iOS, Android) can be complex and resource-intensive.', '2025-03-30 21:56:16', 1),
(6, 14, 5, 'Oracle offers robust features like high scalability, advanced security, comprehensive data management tools, excellent performance for large-scale applications, built-in machine learning capabilities, and strong support for complex enterprise requirements.', '2025-03-30 23:29:22', 1),
(8, 13, 1, 'Enabling personalized customer experiences.', '2025-03-31 00:09:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `subject_id`, `question`, `created_at`, `approved`) VALUES
(4, 1, 3, 'How does implementation differ from the initial design phase of an IT project?', '2025-03-30 18:22:23', 1),
(7, 1, 4, 'What are the current challenges in mobile technology development?', '2025-03-30 18:28:07', 1),
(13, 1, 6, 'How do e-business technologies transform traditional business models?', '2025-03-30 19:43:02', 1),
(14, 4, 7, 'What makes Oracle a preferred enterprise database management system?', '2025-03-30 22:07:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`) VALUES
(2, 'CP5046', 'ICT Project 1: Analysis and Design'),
(3, 'CP5047 ', 'ICT Project 2: Implementation and Commissioning '),
(4, 'CP5307 ', 'Advanced Mobile Technology - Lecture'),
(5, 'CP5307', 'Advanced Mobile Technology - Lab'),
(6, 'CP5310', 'E-Business Technologies'),
(7, 'CP5503', 'Enterprise Database Systems - Oracle'),
(8, 'CP5520', 'Advanced Databases and Applications'),
(9, 'CP5601', 'Advanced Data Communications Principles'),
(10, 'CP5602', 'Advanced Algorithm Analysis'),
(15, 'CP5603', 'Advanced E-Security');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `jcu_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `jcu_number`, `password`, `role`) VALUES
(1, 'CIT-221-023/2017', '$2y$10$ojCribSrW5ISAP9qyGoAaeP.uYPC2vPbRozs6pkFuFHyn5wwVGxEe', 'admin'),
(4, 'CIT-221-023/2018', '$2y$10$sy3KY86T2htTUzpoVmbKqOuh0msu3.TH9f7tkOrW6AHHlUpce0I6q', 'student'),
(5, 'CIT-221-023/2016', '$2y$10$AF.5hi7GwOYn0.ptMWaqM.h9jc85Jk0uoLcNjxCQAw.uXumA9KDry', 'student'),
(6, 'CIT-221-023/2019', '$2y$10$kzV46y5BO.dtt27jpLXh9em2uxZTIvN7BX6peZi1jYSINLjKlnUWi', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jc_number` (`jcu_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
