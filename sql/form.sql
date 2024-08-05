-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 03:30 PM
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
-- Database: `autoship_virtualrep`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `task_id`, `user_email`, `status`, `comments`, `created_at`, `updated_at`) VALUES
(2, 29, 'delbertyegon@gmail.com', 'accepted', 'Job accepted', '2024-05-08 15:24:44', '2024-05-08 15:24:44'),
(3, 30, 'delbertyegon@gmail.com', 'rejected', 'Job rejected', '2024-05-08 15:34:59', '2024-05-08 15:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `meeting_time` datetime NOT NULL,
  `platform` varchar(100) NOT NULL,
  `meeting_link` varchar(255) NOT NULL,
  `agenda_link` varchar(255) NOT NULL,
  `special_instructions` text NOT NULL,
  `files_link` varchar(255) NOT NULL,
  `status` enum('accepted','rejected','completed','pending') NOT NULL DEFAULT 'pending',
  `assigned_to` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `company`, `info`, `amount`, `meeting_time`, `platform`, `meeting_link`, `agenda_link`, `special_instructions`, `files_link`, `status`, `assigned_to`, `created_at`) VALUES
(22, 'Brent&#39;s', 'X', '0', 12.00, '2024-04-09 15:07:00', 'Google', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'None', 'https://forum-kenya.server.app.mobipine.com/login', 'completed', 32, '2024-04-05'),
(23, 'ABC', 'ABC', '0', 12.00, '2024-04-05 15:36:00', 'A', 'https://forum-kenya.server.app.mobipine.com/login', 'http://localhost/210733_Login_System/Form/task/admin_dashboard.php?page=add_task', 'None', 'https://forum-kenya.server.app.mobipine.com/login', 'accepted', 32, '2024-04-05'),
(24, 'Frameowrk', 'Framework Enterprises Limited', '0', 200.00, '2024-04-29 18:00:00', 'Zoom', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'None', 'https://forum-kenya.server.app.mobipine.com/login', 'rejected', 32, '2024-05-06'),
(25, 'Task Test', 'X1', '0', 12.00, '2024-05-06 18:04:00', 'Google', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'None', 'https://forum-kenya.server.app.mobipine.com/login', 'pending', 32, '2024-05-06'),
(26, 'Test 2', 'Test 2', 'Test 2 Tasks', 12.00, '2024-05-06 18:20:00', 'Zoom', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'None', 'https://forum-kenya.server.app.mobipine.com/login', 'pending', 32, '2024-05-06'),
(29, 'Task Test 5', 'Task Test 5', 'Task Test 5', 12.00, '2024-05-08 18:18:00', 'Google', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'Task Test 5', 'https://forum-kenya.server.app.mobipine.com/login', 'accepted', 67, '2024-05-08'),
(30, 'Test 6', 'Test 6', 'Test 6', 23.00, '2024-05-01 18:34:00', 'Google', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'Test 6', 'https://forum-kenya.server.app.mobipine.com/login', 'rejected', 67, '2024-05-08'),
(31, 'Test 7', 'Test 7', 'Test 7', 122.00, '2024-05-08 18:38:00', 'Zoom', 'http://localhost/210733_Login_System/Form/task/admin_dashboard.php?page=add_task', 'https://forum-kenya.server.app.mobipine.com/login', 'Test 7', 'http://localhost/210733_Login_System/Form/task/admin_dashboard.php?page=add_task', 'pending', 67, '2024-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique_id` int(50) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` int(50) NOT NULL,
  `verification_status` varchar(50) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unique_id`, `fname`, `lname`, `email`, `phone`, `password`, `otp`, `verification_status`, `Role`) VALUES
(23, 1115210456, 'Cyprian', 'CP', 'lemtukeicyprian@gmail.com', '01234567890', '5d41402abc4b2a76b9719d911017c592', 0, 'Verified', 'admin'),
(32, 1417488369, 'DELBERT', 'KIPYEGON', 'delbertkip@gmail.com', '0792961634', '5d41402abc4b2a76b9719d911017c592', 0, 'Verified', 'user'),
(67, 1312197469, 'DELBERT', 'KIPYEGON', 'delbertyegon@gmail.com', '0792961634', '5d41402abc4b2a76b9719d911017c592', 0, 'Verified', 'user'),
(71, 540241121, 'Del', 'Del', 'delbertkiki@gmail.com', '0792961634', '5d41402abc4b2a76b9719d911017c592', 0, 'Verified', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `user_id`, `gender`, `paypal_email`, `country`, `dob`) VALUES
(4, 32, 'Male', 'delbertkip@gmail.com', 'public_html', '4434-03-21'),
(13, 67, 'Female', 'esomenik@gmail.com', 'Egypt', '2024-05-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_email` (`user_email`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_task_notification` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
