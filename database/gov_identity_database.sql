-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 07:22 PM
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
-- Database: `gov_identity_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_first_name` varchar(255) NOT NULL,
  `admin_surname` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_first_name`, `admin_surname`, `admin_email`, `admin_password`, `admin_created_at`) VALUES
(5, 'Kay', 'Mudau', 'kkay.mudau008@gmail.com', '$2y$10$xuAvPN4zgfogvE/pIIFjRe1KLtMoHOxHixITuTeUcDkbuM9cmdmlS', '2024-09-18 20:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_action` varchar(255) NOT NULL,
  `log_status` text NOT NULL,
  `log_location` varchar(255) NOT NULL,
  `log_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_applications`
--

CREATE TABLE `id_applications` (
  `id_application_id` int(11) NOT NULL,
  `id_application_first_name` varchar(255) NOT NULL,
  `id_application_surname` varchar(255) NOT NULL,
  `id_application_type` varchar(255) NOT NULL,
  `id_application_status` varchar(255) NOT NULL,
  `id_application_created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_role` varchar(150) NOT NULL,
  `user_first_name` varchar(255) NOT NULL,
  `user_surname` varchar(255) NOT NULL,
  `user_sex` varchar(10) NOT NULL,
  `user_dob` datetime NOT NULL DEFAULT current_timestamp(),
  `user_country` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `user_modified_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `user_first_name`, `user_surname`, `user_sex`, `user_dob`, `user_country`, `user_email`, `user_phone`, `user_password`, `user_status`, `user_modified_at`, `user_created_at`) VALUES
(5, '', 'Kay', 'Mudau', 'male', '2024-09-19 00:00:00', 'South Africa', 'kkay.mudau008@gmail.com', '07866543876', '$2y$10$zs1XU9cuaQFjZCpAlfV6XeReqxJz.WINZSr35BSh2U3djZUTuaML2', 'active', '2024-09-18 22:19:36', '2024-09-18 22:19:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `id_applications`
--
ALTER TABLE `id_applications`
  ADD PRIMARY KEY (`id_application_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id_applications`
--
ALTER TABLE `id_applications`
  MODIFY `id_application_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
