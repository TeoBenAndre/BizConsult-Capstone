-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 10:47 AM
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
-- Database: `bizconsult`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultant_profiles`
--

CREATE TABLE `consultant_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expertise` varchar(255) NOT NULL,
  `biography` text DEFAULT NULL,
  `services_offered` text DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('client','consultant') NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`, `full_name`, `phone_number`, `created_at`, `updated_at`, `is_verified`) VALUES
(1, 'clint@gmail.com', '$2y$10$cxB2JRMRPnyOxPcDjMtIge5PwjaNsU0jxlguLWgrcIRiZ8TkEjFve', 'client', 'clint daguplo', '09684344670', '2025-05-31 07:51:57', '2025-05-31 07:51:57', 0),
(2, 'bis@gmail.com', '$2y$10$B0KueEzy5gb2znDs12VLJeWkq0agTLHJdzE64MVLwNxcD8Sz0.ofK', 'consultant', 'Biz Comsult', '09684344670', '2025-05-31 08:19:16', '2025-05-31 08:19:16', 0),
(3, 'clntdaguplo@gmail.com', '$2y$10$xNKAy8/FEFmgrj5/pLpUduiaxfhw3.zgb7CrvCRmNGJMVK.KF0Y96', 'consultant', 'Clnt Daguplo', '09123456789', '2025-05-31 08:31:55', '2025-05-31 08:31:55', 0),
(4, 'clintclint@gmail.com', '$2y$10$G7ydflndSgaUKYA8ZB4yv.HnslZaZcPeqms80gyoPEvkQRLMTtfpG', 'consultant', 'Clint Clint', '09987654321', '2025-05-31 08:36:04', '2025-05-31 08:36:04', 0),
(5, 'biz@gmail.com', '$2y$10$lcG0J6D1hgtp3TyEuPuAWeUqrHPRgTV1L4ZGLnwHfwB..IdBx7M4e', 'consultant', 'Biz Consult', '09339258147', '2025-05-31 08:39:36', '2025-05-31 08:39:36', 1),
(6, 'user@gmail.com', '$2y$10$cdTN6wYbdHlxL1w0R7N84.iuu6J4cTAI12TTabrwPVBVsuMuVnhS.', 'client', 'User Consult', '09147258369', '2025-05-31 08:40:48', '2025-05-31 08:40:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_2fa`
--

CREATE TABLE `user_2fa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_verification`
--

CREATE TABLE `user_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `verification_token` varchar(255) NOT NULL,
  `token_expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_verification`
--

INSERT INTO `user_verification` (`id`, `user_id`, `verification_token`, `token_expiry`, `is_verified`, `created_at`) VALUES
(1, 1, '3724de34c25f889a19a42605659192881b0f360494af7ddf76681d95f9d4d77b34dc861f0016c6f4ec466850d81758396c27', '2025-05-31 02:51:57', 0, '2025-05-31 07:51:57'),
(2, 2, '5f8bebf7508775762d5afa1f933cbc6ac7f6ee324ddd6ba5f1e542a8252be76b1bf44dcd68294991f5816c689cdcd7eceee6', '2025-05-31 03:19:16', 0, '2025-05-31 08:19:16'),
(3, 3, 'ab956e5f4eb0bd3b430c2ace4015bfc0da657c88b78883a9c29f46db428bb7316a9ae5831bb4839ca9237533bf4d133c8a9c', '2025-05-31 03:31:55', 0, '2025-05-31 08:31:55'),
(4, 4, '56edf82f74fd25df8dce043d0124ef17c79cd43b9a7f1f32ced086d9eaf3bbf4633704eb5d8b858cc941f0952cd8d3a01a2e', '2025-05-31 03:36:04', 0, '2025-05-31 08:36:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant_profiles`
--
ALTER TABLE `consultant_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_2fa`
--
ALTER TABLE `user_2fa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_verification`
--
ALTER TABLE `user_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant_profiles`
--
ALTER TABLE `consultant_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_2fa`
--
ALTER TABLE `user_2fa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_verification`
--
ALTER TABLE `user_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultant_profiles`
--
ALTER TABLE `consultant_profiles`
  ADD CONSTRAINT `consultant_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_2fa`
--
ALTER TABLE `user_2fa`
  ADD CONSTRAINT `user_2fa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_verification`
--
ALTER TABLE `user_verification`
  ADD CONSTRAINT `user_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
