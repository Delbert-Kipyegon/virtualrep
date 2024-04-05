-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 11:58 AM
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
-- Database: `form`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `company`, `info`, `amount`, `meeting_time`, `platform`, `meeting_link`, `agenda_link`, `special_instructions`, `files_link`, `status`, `assigned_to`, `created_at`) VALUES
(15, 'Ingressive For Good', 'Attend the meeting ', 20.00, '2024-03-31 20:00:00', 'Zoom', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'Please keep time', 'https://forum-kenya.server.app.mobipine.com/login', 'rejected', 4, '2024-03-30 04:45:10'),
(16, 'Kenya defence forces', 'Detailed Info', 234.00, '1212-12-12 12:12:00', 'Google', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'Hello', 'https://forum-kenya.server.app.mobipine.com/login', 'completed', 32, '2024-03-30 04:48:03'),
(17, 'KU', 'talk about mental stuff', 10.00, '2024-04-02 20:00:00', 'Zoom', 'https://forum-kenya.server.app.mobipine.com/login', 'https://forum-kenya.server.app.mobipine.com/login', 'None', 'https://forum-kenya.server.app.mobipine.com/login', 'completed', 32, '2024-04-03 14:15:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
