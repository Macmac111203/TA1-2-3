-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 11:18 AM
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
(17, '\'Data Analysis\' has been assigned to you. Please review and start working on it', 8, 'New Task Assigned', '2025-04-25', 1),
(18, '\'Database Management\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2025-04-25', 1),
(19, '\'Powerpoint Presentation\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2025-04-25', 1),
(20, '\'Employee Training Program Development\' has been assigned to you. Please review and start working on it', 8, 'New Task Assigned', '2025-04-25', 1),
(21, '\'Documentation\' has been assigned to you. Please review and start working on it', 2, 'New Task Assigned', '2025-04-25', 1),
(22, '\'System Admin\' has been assigned to you. Please review and start working on it', 7, 'New Task Assigned', '2025-04-25', 1),
(23, '\'Computer Management\' has been assigned to you. Please review and start working on it', 8, 'New Task Assigned', '2025-04-25', 1);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`) VALUES
(28, 'Data Analysis', 'Create a analytics report on how the data of the company works in the last few months.', 8, '2025-04-29', 'pending', '2025-04-25 08:38:39'),
(29, 'Database Management', 'Manage the company database based on the growth of it.', 2, '2025-04-01', 'pending', '2025-04-25 08:40:05'),
(30, 'Powerpoint Presentation', 'Create a powerpoint for the meeting.', 7, '2025-04-25', 'pending', '2025-04-25 08:41:15'),
(31, 'Employee Training Program Development', 'Develop and implement a new training program focused on enhancing employee skills in project management and teamwork.', 8, '2025-04-05', 'pending', '2025-04-25 08:43:09'),
(32, 'Documentation', 'Document the reports in the meeting.', 2, '2025-04-25', 'pending', '2025-04-25 08:48:11'),
(33, 'System Admin', 'Manage the system data.', 7, '0000-00-00', 'pending', '2025-04-25 08:50:53'),
(34, 'Computer Management', 'Make sure all of the computer does not have any problems.', 8, '0000-00-00', 'pending', '2025-04-25 08:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Oliver', 'admin', '$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O', 'admin', '2025-04-24 17:10:04'),
(2, 'Praise Elijah Asejo', 'praise@sejo', '$2y$10$/R0gG0IFszLulQqQy5ErAuBCKrTU0/lzp.p6iLpnYaNVXgxm/8KTi', 'employee', '2025-04-24 17:10:40'),
(7, 'Mark Angelo Evangelista', 'mark@ngelo', '$2y$10$QCB5Nx/jKfOQGL4dybb30.vgcg75lpRIVO501clYVtAdwIVBdpGiW', 'employee', '2025-04-24 17:11:05'),
(8, 'Marc Leo Ragos', 'macmac', '$2y$10$QnPXkL28TiaQ4cVVdgIQZueh2H/MvVUDO6GAf5rNlb1HBVQnWpj4e', 'employee', '2025-04-24 17:11:34');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
