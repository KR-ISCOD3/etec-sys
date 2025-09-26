-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Sep 26, 2025 at 06:24 PM
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
-- Database: `db_etec_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `name`, `created_by`, `created_at`) VALUES
(5, 'ETEC Head Office', 17, '2025-09-20 17:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_by`, `created_at`) VALUES
(11, 'Web-Frontend', 17, '2025-09-12 09:37:18'),
(12, 'Web-Backend', 17, '2025-09-12 09:37:27'),
(13, 'Network', 17, '2025-09-12 09:37:52'),
(14, 'Graphic-Design', 17, '2025-09-12 09:38:26'),
(15, 'Office', 17, '2025-09-12 09:38:40'),
(16, 'Mobile-App', 17, '2025-09-12 09:41:56'),
(17, 'Desktop-App', 17, '2025-09-12 09:43:06'),
(28, 'Basic Code', 17, '2025-09-14 06:28:06'),
(29, 'Basic IT', 17, '2025-09-14 06:30:40'),
(36, 'Maintenance', 17, '2025-09-14 13:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `lesson` varchar(255) NOT NULL,
  `total_stu` int(11) DEFAULT 0,
  `class_status` varchar(50) DEFAULT NULL,
  `course_id` int(10) DEFAULT NULL,
  `instructor_id` int(11) UNSIGNED DEFAULT NULL,
  `building_id` int(11) DEFAULT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `class_type_id` int(11) DEFAULT NULL,
  `time_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `lesson`, `total_stu`, `class_status`, `course_id`, `instructor_id`, `building_id`, `floor_id`, `room_id`, `class_type_id`, `time_id`, `term_id`, `created_at`) VALUES
(4, 'Introduction', 0, 'progress', 43, 41, 5, 16, 22, 7, 9, 4, '2025-09-26 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `class_types`
--

CREATE TABLE `class_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_types`
--

INSERT INTO `class_types` (`id`, `name`, `created_by`, `created_at`) VALUES
(7, 'Scholarship Class', 17, '2025-09-15 09:33:44'),
(8, 'Physical Class', 17, '2025-09-15 09:33:51'),
(9, 'Hybrid Class', 17, '2025-09-15 09:34:06'),
(10, 'Online Class', 17, '2025-09-15 09:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `category_id` tinyint(3) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `category_id`, `created_by`, `created_at`) VALUES
(28, 'Web Design + Jquery', 11, 17, '2025-09-14 06:18:08'),
(29, 'Web Design + React.js', 11, 17, '2025-09-14 06:18:24'),
(30, 'Web Design + Vue.js', 11, 17, '2025-09-14 06:18:54'),
(31, 'Ts + Angular', 11, 17, '2025-09-14 06:19:40'),
(32, 'PHP + Ajax', 12, 17, '2025-09-14 06:23:43'),
(33, 'PHP + Laravel', 12, 17, '2025-09-14 06:23:54'),
(34, 'Java + Spring Boot', 12, 17, '2025-09-14 06:24:12'),
(35, 'C# + asp.NET', 12, 17, '2025-09-14 06:24:35'),
(36, 'Node.js + Express', 12, 17, '2025-09-14 06:24:55'),
(37, 'Basic Js + React.js', 11, 17, '2025-09-14 06:25:45'),
(38, 'Basic Js + Vue.js', 11, 17, '2025-09-14 06:26:08'),
(39, 'Dart + Flutter', 16, 17, '2025-09-14 06:26:26'),
(40, 'React Native', 16, 17, '2025-09-14 06:26:40'),
(41, 'Java + Mysql', 17, 17, '2025-09-14 06:26:53'),
(42, 'C# + Mysql', 17, 17, '2025-09-14 06:27:17'),
(43, 'C++/OOP/Mysql', 28, 17, '2025-09-14 06:27:53'),
(44, 'Basic IT (C++ and Network)', 29, 17, '2025-09-14 06:30:12'),
(45, 'C and C++/OOP/Algorithsm', 28, 17, '2025-09-14 06:31:57'),
(46, 'Python/OOP/Mysql', 28, 17, '2025-09-14 06:32:45'),
(47, 'Python + Flask', 12, 17, '2025-09-14 06:33:15'),
(48, 'Adobe PS + UX/UI', 14, 17, '2025-09-14 06:33:48'),
(49, 'Adobe PS + Illustrator', 14, 17, '2025-09-14 06:34:01'),
(50, 'UX/UI', 14, 17, '2025-09-14 06:34:18'),
(51, 'Basic Network', 13, 17, '2025-09-14 06:34:47'),
(52, 'Basic Cyber', 13, 17, '2025-09-14 06:34:58'),
(53, 'Advance CISCO', 13, 17, '2025-09-14 06:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `floor` varchar(100) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `building_id`, `floor`, `created_by`, `created_at`) VALUES
(16, 5, 'Ground Floor', 17, '2025-09-20 17:12:32'),
(17, 5, 'Floor 1', 17, '2025-09-20 17:12:32'),
(18, 5, 'Floor 2', 17, '2025-09-20 17:12:32'),
(19, 5, 'Floor 3', 17, '2025-09-20 17:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `roadmaps`
--

CREATE TABLE `roadmaps` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `lessons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lessons`)),
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roadmaps`
--

INSERT INTO `roadmaps` (`id`, `course_id`, `lessons`, `created_by`, `created_at`) VALUES
(12, 43, '\"[\\\"Introduction\\\",\\\"Condition\\\",\\\"Loop\\\",\\\"Function\\\",\\\"Array\\\",\\\"Pointer\\\",\\\"OOP\\\",\\\"Encapsulation\\\",\\\"Inheritance\\\",\\\"Polymorphism\\\",\\\"File\\\",\\\"Mysql\\\"]\"', 17, '2025-09-14 22:20:26'),
(16, 50, '\"[\\\"Introduction\\\",\\\"Test\\\"]\"', 17, '2025-09-26 13:41:52'),
(17, 51, '\"[\\\"Introduction\\\",\\\"Test\\\"]\"', 17, '2025-09-26 13:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `room` varchar(100) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `building_id`, `floor_id`, `room`, `created_by`, `created_at`) VALUES
(22, 5, 16, 'E001', 17, '2025-09-20 17:12:32'),
(23, 5, 16, 'E002', 17, '2025-09-20 17:12:32'),
(24, 5, 17, 'E101', 17, '2025-09-20 17:12:32'),
(25, 5, 17, 'E102', 17, '2025-09-20 17:12:32'),
(26, 5, 17, 'E103', 17, '2025-09-20 17:12:32'),
(27, 5, 17, 'E104', 17, '2025-09-20 17:12:32'),
(28, 5, 17, 'E105', 17, '2025-09-20 17:12:32'),
(29, 5, 18, 'E201', 17, '2025-09-20 17:12:32'),
(30, 5, 18, 'E202', 17, '2025-09-20 17:12:32'),
(31, 5, 18, 'E203', 17, '2025-09-20 17:12:32'),
(32, 5, 18, 'E204', 17, '2025-09-20 17:12:32'),
(33, 5, 18, 'E205', 17, '2025-09-20 17:12:32'),
(34, 5, 18, 'E206', 17, '2025-09-20 17:12:32'),
(35, 5, 19, 'Office', 17, '2025-09-20 17:12:32'),
(36, 5, 19, 'Graphic Design Room', 17, '2025-09-20 17:12:32'),
(37, 5, 19, 'E301', 17, '2025-09-20 17:12:32'),
(38, 5, 19, 'E302', 17, '2025-09-20 17:12:32'),
(39, 5, 19, 'E303', 17, '2025-09-20 17:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_type_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `class_type_id`, `term_id`, `time_id`, `created_by`, `created_at`) VALUES
(31, 8, 4, 5, 17, '2025-09-17 04:30:29'),
(32, 8, 4, 6, 17, '2025-09-17 04:30:29'),
(33, 8, 4, 7, 17, '2025-09-17 04:30:29'),
(34, 8, 4, 8, 17, '2025-09-17 04:30:29'),
(35, 8, 4, 9, 17, '2025-09-17 04:30:29'),
(36, 8, 4, 10, 17, '2025-09-17 04:30:29'),
(37, 8, 4, 11, 17, '2025-09-17 04:30:29'),
(38, 8, 5, 12, 17, '2025-09-17 04:30:47'),
(39, 8, 5, 13, 17, '2025-09-17 04:30:47'),
(40, 8, 5, 14, 17, '2025-09-17 04:30:47'),
(41, 10, 4, 5, 17, '2025-09-17 04:34:30'),
(42, 10, 4, 6, 17, '2025-09-17 04:34:30'),
(43, 10, 4, 7, 17, '2025-09-17 04:34:30'),
(44, 10, 4, 8, 17, '2025-09-17 04:34:30'),
(45, 10, 4, 9, 17, '2025-09-17 04:34:30'),
(46, 10, 4, 10, 17, '2025-09-17 04:34:30'),
(47, 10, 4, 11, 17, '2025-09-17 04:34:30'),
(51, 10, 5, 12, 17, '2025-09-17 05:21:58'),
(52, 10, 5, 13, 17, '2025-09-17 05:21:58'),
(53, 10, 5, 14, 17, '2025-09-17 05:21:58'),
(61, 7, 5, 12, 17, '2025-09-17 06:08:30'),
(62, 7, 5, 13, 17, '2025-09-17 06:08:30'),
(63, 7, 5, 14, 17, '2025-09-17 06:08:30'),
(64, 9, 4, 5, 17, '2025-09-17 06:11:14'),
(65, 9, 4, 6, 17, '2025-09-17 06:11:14'),
(66, 9, 4, 7, 17, '2025-09-17 06:11:14'),
(67, 9, 4, 8, 17, '2025-09-17 06:11:14'),
(68, 9, 4, 9, 17, '2025-09-17 06:11:14'),
(69, 9, 4, 10, 17, '2025-09-17 06:11:14'),
(70, 9, 4, 11, 17, '2025-09-17 06:11:14'),
(71, 9, 5, 12, 17, '2025-09-17 06:11:41'),
(72, 9, 5, 13, 17, '2025-09-17 06:11:41'),
(73, 9, 5, 14, 17, '2025-09-17 06:11:41'),
(74, 7, 4, 15, 17, '2025-09-17 15:16:00'),
(75, 7, 4, 17, 17, '2025-09-17 15:16:00'),
(76, 7, 4, 18, 17, '2025-09-17 15:16:00'),
(77, 7, 4, 19, 17, '2025-09-17 15:16:00');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `term` varchar(100) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `term`, `created_by`, `created_at`) VALUES
(4, 'Mon & Thu', 17, '2025-09-16 03:42:20'),
(5, 'Sat & Sun', 17, '2025-09-16 03:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `id` int(11) NOT NULL,
  `time` varchar(100) NOT NULL,
  `created_by` int(6) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `time`, `created_by`, `created_at`) VALUES
(5, '9:00 am - 10:30 am', 17, '2025-09-16 04:26:05'),
(6, '11:00 am - 12:15 pm', 17, '2025-09-16 04:26:23'),
(7, '12:30 pm - 01:45 pm', 17, '2025-09-16 04:26:52'),
(8, '02:00 pm - 3:15 pm', 17, '2025-09-16 04:27:24'),
(9, '03:30 pm - 05:00 pm', 17, '2025-09-16 04:27:41'),
(10, '06:00 pm - 07:15 pm', 17, '2025-09-16 04:28:00'),
(11, '07:15 pm - 8:30 pm', 17, '2025-09-16 04:28:23'),
(12, '08:00 am - 11:00 am', 17, '2025-09-16 04:28:44'),
(13, '11:00 am - 01:30 pm', 17, '2025-09-16 04:29:00'),
(14, '02:00 pm - 05:00 pm', 17, '2025-09-16 04:29:14'),
(15, '09:00 am - 11:00 am', 17, '2025-09-17 06:03:47'),
(17, '11:00 am - 01:30 pm', 17, '2025-09-17 06:04:34'),
(18, '03:30 pm - 05:30 pm', 17, '2025-09-17 06:04:52'),
(19, '05:30 pm - 07:30 pm', 17, '2025-09-17 15:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `pass` char(60) NOT NULL,
  `role` enum('admin','instructor','student') NOT NULL DEFAULT 'student',
  `approval` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `image` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `tel`, `email`, `pass`, `role`, `approval`, `image`, `created_at`, `updated_at`) VALUES
(17, 'admin', 'Male', NULL, 'etec@gmail.com', 'etec@2012', 'admin', 'approved', NULL, '2025-09-11 03:59:13', '2025-09-22 06:32:41'),
(33, 'Raksmey', 'Male', NULL, 'raksmey@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-22 07:52:02', '2025-09-22 07:52:20'),
(34, 'Sok Pisey', 'Male', NULL, 'pisey@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-22 07:53:36', '2025-09-22 07:53:41'),
(35, 'Jonh Cina', 'Male', NULL, 'john031@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-22 08:08:36', '2025-09-22 08:08:47'),
(36, 'Messi', 'Male', NULL, 'messi@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-22 08:11:51', '2025-09-22 08:12:10'),
(37, 'Ronaldo', 'Male', NULL, 'ronaldo@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-22 08:14:49', '2025-09-22 08:16:09'),
(38, 'Dara', 'Male', NULL, 'Dara@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-22 08:15:37', '2025-09-22 08:16:49'),
(41, 'Genz', 'Male', NULL, 'genz@gmail.com', '123', 'instructor', 'approved', NULL, '2025-09-26 08:49:21', '2025-09-26 08:50:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_buildings_created_by` (`created_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_classes_course` (`course_id`),
  ADD KEY `fk_classes_instructor` (`instructor_id`),
  ADD KEY `fk_classes_building` (`building_id`),
  ADD KEY `fk_classes_floor` (`floor_id`),
  ADD KEY `fk_classes_room` (`room_id`),
  ADD KEY `fk_classes_class_type` (`class_type_id`),
  ADD KEY `fk_classes_time` (`time_id`),
  ADD KEY `fk_classes_term` (`term_id`);

--
-- Indexes for table `class_types`
--
ALTER TABLE `class_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_floors_created_by` (`created_by`),
  ADD KEY `idx_floors_building_id` (`building_id`);

--
-- Indexes for table `roadmaps`
--
ALTER TABLE `roadmaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_created_by` (`created_by`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rooms_created_by` (`created_by`),
  ADD KEY `idx_rooms_building_id` (`building_id`),
  ADD KEY `idx_rooms_floor_id` (`floor_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_class_type` (`class_type_id`),
  ADD KEY `fk_term` (`term_id`),
  ADD KEY `fk_time` (`time_id`),
  ADD KEY `fk_user` (`created_by`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_terms_created_by` (`created_by`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_time_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class_types`
--
ALTER TABLE `class_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roadmaps`
--
ALTER TABLE `roadmaps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `fk_buildings_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_classes_building` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  ADD CONSTRAINT `fk_classes_class_type` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`),
  ADD CONSTRAINT `fk_classes_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_classes_floor` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`),
  ADD CONSTRAINT `fk_classes_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_classes_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `fk_classes_term` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`),
  ADD CONSTRAINT `fk_classes_time` FOREIGN KEY (`time_id`) REFERENCES `times` (`id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `floors`
--
ALTER TABLE `floors`
  ADD CONSTRAINT `fk_floors_building` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_floors_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_rooms_building` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rooms_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_rooms_floor` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_class_type` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_term` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_time` FOREIGN KEY (`time_id`) REFERENCES `times` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `fk_terms_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `times`
--
ALTER TABLE `times`
  ADD CONSTRAINT `fk_time_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
