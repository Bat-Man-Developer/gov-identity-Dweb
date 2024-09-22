-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 02:26 AM
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
-- Table structure for table `citizenship_applications`
--

CREATE TABLE `citizenship_applications` (
  `citizenship_application_id` int(11) NOT NULL,
  `citizenship_application_full_name` varchar(255) NOT NULL,
  `citizenship_application_date_of_birth` date NOT NULL,
  `citizenship_application_place_of_birth` varchar(255) NOT NULL,
  `citizenship_application_current_nationality` varchar(100) NOT NULL,
  `citizenship_application_residence_years` int(11) NOT NULL,
  `citizenship_application_language_proficiency` varchar(50) NOT NULL,
  `citizenship_application_criminal_record` tinyint(1) NOT NULL,
  `citizenship_application_employment_status` varchar(100) NOT NULL,
  `citizenship_application_reason_for_application` text NOT NULL,
  `citizenship_application_status` varchar(20) NOT NULL,
  `citizenship_application_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `citizenship_application_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `civil_registrations`
--

CREATE TABLE `civil_registrations` (
  `civil_registration_id` int(11) NOT NULL,
  `civil_registration_type` varchar(50) NOT NULL,
  `civil_registration_full_name` varchar(255) NOT NULL,
  `civil_registration_date_of_event` date NOT NULL,
  `civil_registration_place_of_event` varchar(255) NOT NULL,
  `civil_registration_father_name` varchar(255) NOT NULL,
  `civil_registration_mother_name` varchar(255) NOT NULL,
  `civil_registration_gender` varchar(10) NOT NULL,
  `civil_registration_nationality` varchar(100) NOT NULL,
  `civil_registration_address` text NOT NULL,
  `civil_registration_contact_number` varchar(20) NOT NULL,
  `civil_registration_status` varchar(20) NOT NULL,
  `civil_registration_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `civil_registration_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_applications`
--

CREATE TABLE `id_applications` (
  `id_application_id` int(11) NOT NULL,
  `id_application_full_name` varchar(255) NOT NULL,
  `id_application_date_of_birth` date NOT NULL,
  `id_application_place_of_birth` varchar(255) NOT NULL,
  `id_application_gender` varchar(10) NOT NULL,
  `id_application_nationality` varchar(100) NOT NULL,
  `id_application_address` text NOT NULL,
  `id_application_father_name` varchar(255) NOT NULL,
  `id_application_mother_name` varchar(255) NOT NULL,
  `id_application_marital_status` varchar(20) NOT NULL,
  `id_application_occupation` varchar(100) NOT NULL,
  `id_application_document_type` varchar(50) NOT NULL,
  `id_application_photo_path` varchar(255) NOT NULL,
  `id_application_signature_path` varchar(255) NOT NULL,
  `id_application_status` varchar(20) NOT NULL,
  `id_application_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_application_created_at` timestamp NOT NULL DEFAULT current_timestamp()
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

-- --------------------------------------------------------

--
-- Table structure for table `visa_applications`
--

CREATE TABLE `visa_applications` (
  `visa_application_id` int(11) NOT NULL,
  `visa_application_full_name` varchar(255) NOT NULL,
  `visa_application_passport_number` varchar(50) NOT NULL,
  `visa_application_nationality` varchar(100) NOT NULL,
  `visa_application_date_of_birth` date NOT NULL,
  `visa_application_type` varchar(50) NOT NULL,
  `visa_application_entry_date` date NOT NULL,
  `visa_application_stay_duration` int(11) NOT NULL,
  `visa_application_purpose` text NOT NULL,
  `visa_application_accommodation` varchar(255) NOT NULL,
  `visa_application_financial_means_proof` varchar(255) NOT NULL,
  `visa_application_status` varchar(20) NOT NULL,
  `visa_application_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visa_application_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `citizenship_applications`
--
ALTER TABLE `citizenship_applications`
  ADD PRIMARY KEY (`citizenship_application_id`);

--
-- Indexes for table `civil_registrations`
--
ALTER TABLE `civil_registrations`
  ADD PRIMARY KEY (`civil_registration_id`);

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
-- Indexes for table `visa_applications`
--
ALTER TABLE `visa_applications`
  ADD PRIMARY KEY (`visa_application_id`);

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
-- AUTO_INCREMENT for table `citizenship_applications`
--
ALTER TABLE `citizenship_applications`
  MODIFY `citizenship_application_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `civil_registrations`
--
ALTER TABLE `civil_registrations`
  MODIFY `civil_registration_id` int(11) NOT NULL AUTO_INCREMENT;

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

--
-- AUTO_INCREMENT for table `visa_applications`
--
ALTER TABLE `visa_applications`
  MODIFY `visa_application_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
