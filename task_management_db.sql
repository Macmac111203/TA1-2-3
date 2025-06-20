-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 11:21 PM
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
-- Database: `task_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `recipient`, `type`, `date`, `is_read`) VALUES
(35, '\'Update Employee Attendance Records\' has been assigned to you. Please review and start working on it', 9, 'New Task Assigned', '2025-06-21', 0),
(36, '\'Integrate Firebase Authentication\' has been assigned to you. Please review and start working on it', 9, 'New Task Assigned', '2025-06-21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`, `file_name`) VALUES
(43, 'Deploy Website to Live Server', 'Move all site files from the staging environment to the production server. Update environment variables and test all routes and APIs.', 9, '2025-06-21', 'completed', '2025-06-20 20:02:41', 'iPhone 16 - 1.jpg'),
(44, 'Test Login and Registration Features', 'Perform manual and automated tests on the login and registration modules. Check for input validation, error handling, and successful redirection.', 11, '2025-06-22', 'pending', '2025-06-20 20:07:21', 'iPhone 16 - 2.jpg'),
(45, 'Create Product Landing Page', 'Design and develop a responsive landing page showcasing the new product features. Include a call-to-action button and a subscription form.', 12, '2025-06-25', 'pending', '2025-06-20 20:51:56', 'iPhone 16 - 13.jpg'),
(46, 'Update Employee Attendance Records', 'Input the latest attendance logs into the system and verify data accuracy. Flag any anomalies such as absences or overtime.', 9, '2025-06-28', 'in_progress', '2025-06-20 21:00:36', 'iPhone 16 - 22.jpg'),
(47, 'Integrate Firebase Authentication', 'Set up Firebase Auth for the mobile app. Implement email/password and phone number login methods and test them thoroughly.', 9, '2025-06-30', 'pending', '2025-06-20 21:04:51', 'iPhone 16 - 12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `role`, `department`, `created_at`) VALUES
(1, 'Maku Ley', 'admin', 'makuley@gmail.com', '$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O', 'admin', 'IT', '2025-04-24 17:10:04'),
(9, 'Leo Ragos', 'Leoragos', 'Leoragos@gmail.com', '$2y$10$sLELV3CcazMQOQiKNzsXJeyT3KrrSlPBrILz356J4jmaLGnd5GllC', 'employee', 'IT', '2025-06-19 13:38:17'),
(11, 'Praise Asejo', 'praise_asejo', 'praise_asejo@gmail.com', '$2y$10$NNCUDN7nqa3tE/vtfRtWaetFt9XtWzYs7mzvRX4zwQxzlRR7lN7Pa', 'employee', 'HR', '2025-06-20 19:41:19'),
(12, 'Mark Angelo', 'mark_angelo', 'mark_angelo@gmail.com', '$2y$10$YhyPWvYHLdHD8nnMD.nO.uQA8UneeWeUwgeqMt86f6Mam5ehded8e', 'employee', 'Finance', '2025-06-20 19:52:16'),
(13, 'Marc Carolino', 'admin@example.com', 'marc_carolino@gmail.com', '$2y$10$YpTH6vKz1rQuZNeu74gJiOPGpKCyr/xicABmCSoPCm1rR7TPjoX.O', 'admin', 'Finance', '2025-06-20 20:46:11'),
(14, 'User Example', 'user@example.com', 'user_example@gmail.com', '$2y$10$jfkcbu7W9W4S1Q7s8aeDp.S9lN0g0DAKqGU3Kmwq4HfCs4Slx8bFC', 'employee', 'Marketing', '2025-06-20 21:13:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
