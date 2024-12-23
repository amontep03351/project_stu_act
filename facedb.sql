-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 02:24 PM
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
-- Database: `facedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `credits` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `description`, `start_date`, `start_time`, `end_date`, `end_time`, `credits`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'กิจกรรม 1', 'รายละเอียดกิจกรรม 1 ที่นี่...', '2024-01-01', '10:00:00', '2024-01-01', '12:00:00', 2, 0, '', '2024-12-22 08:35:02', '2024-12-23 12:16:53'),
(2, 'กิจกรรม 2', 'รายละเอียดกิจกรรม 2 ที่นี่...', '2024-01-02', '11:00:00', '2024-01-02', '13:00:00', 3, 0, '', '2024-12-22 08:35:02', '2024-12-23 12:19:45'),
(3, 'กิจกรรม 3', 'รายละเอียดกิจกรรม 3 ที่นี่...', '2024-01-03', '09:00:00', '2024-01-03', '11:00:00', 1, 1, '', '2024-12-22 08:35:02', '2024-12-22 08:35:02'),
(4, 'กิจกรรม 4 ss', 'รายละเอียดกิจกรรม 4 ที่นี่...', '2024-01-04', '14:00:00', '2024-01-04', '16:00:00', 4, 1, '', '2024-12-22 08:35:02', '2024-12-23 12:15:16'),
(5, 'กิจกรรม 5', 'รายละเอียดกิจกรรม 5 ที่นี่...', '2024-01-05', '08:00:00', '2024-01-05', '10:00:00', 2, 1, '', '2024-12-22 08:35:02', '2024-12-22 08:35:02'),
(6, 'est', '', '2024-12-12', '19:50:00', '2024-12-19', '20:51:00', 3, 0, '', '2024-12-22 10:52:26', '2024-12-22 10:52:26'),
(7, 'tes', '', '2024-12-17', '17:54:00', '2024-12-09', '17:54:00', 3, 0, '', '2024-12-22 10:52:47', '2024-12-22 10:52:47'),
(8, 'test', 'testsss', '2024-12-09', '19:57:00', '2024-12-17', '17:59:00', 3, 1, 'uploads/activity_6767f0e03a7e50.08953624.png', '2024-12-22 10:58:40', '2024-12-22 10:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `check_ins`
--

CREATE TABLE `check_ins` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_in_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `check_ins`
--

INSERT INTO `check_ins` (`id`, `student_id`, `activity_id`, `check_in_date`, `check_in_time`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-12-23', '09:00:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(2, 1, 2, '2024-12-23', '09:30:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(3, 1, 3, '2024-12-23', '10:00:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(4, 1, 4, '2024-12-23', '10:30:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(5, 1, 5, '2024-12-23', '11:00:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(6, 1, 6, '2024-12-23', '11:30:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(7, 1, 7, '2024-12-23', '12:00:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04'),
(8, 1, 8, '2024-12-23', '12:30:00', '2024-12-23 13:01:04', '2024-12-23 13:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`) VALUES
(1, 'สาขาวิทยาการคอมพิวเตอร์'),
(2, 'สาขาวิศวกรรมคอมพิวเตอร์'),
(3, 'สาขาระบบสารสนเทศ');

-- --------------------------------------------------------

--
-- Table structure for table `faces`
--

CREATE TABLE `faces` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `publish_date` date NOT NULL,
  `publish_time` time NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `publish_date`, `publish_time`, `image`) VALUES
(1, 'ข่าวที่ 1: การเปิดตัวสินค้าใหม่', 'เราขอแนะนำสินค้ารุ่นใหม่ที่มีคุณสมบัติพิเศษ...', '2024-12-01', '09:00:00', ''),
(2, 'ข่าวที่ 2: การอัพเดตระบบ sd', 'ระบบของเราจะมีการอัพเดตในวันที่ 5 ธันวาคม 2024...', '2024-12-02', '10:15:00', ''),
(3, 'ข่าวที่ 3: โปรโมชั่นลดราคาพิเศษ', 'โปรโมชั่นลดราคาสำหรับสมาชิกใหม่ 30% ทุกชิ้น...', '2024-12-03', '14:30:00', ''),
(4, 'ข่าวที่ 4: การจัดงานสัมมนา', 'ขอเชิญร่วมงานสัมมนาในวันที่ 10 ธันวาคม 2024...', '2024-12-04', '11:00:00', ''),
(5, 'ข่าวที่ 5: การปรับปรุงเว็บไซต์', 'เว็บไซต์ของเราจะมีการปรับปรุงในวันที่ 15 ธันวาคม 2024...', '2024-12-05', '08:45:00', ''),
(7, 'ข่าวที่ 7: การประกาศผลรางวัล', 'ผลการประกาศรางวัลของการแข่งขันในปีนี้...', '2024-12-07', '13:20:00', ''),
(9, 'ข่าวที่ 9: การเปิดรับสมัครงาน', 'เรากำลังเปิดรับสมัครงานในตำแหน่งต่างๆ...', '2024-12-09', '09:30:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `program_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `program_name`) VALUES
(1, 'หลักสูตรวิทยาศาสตร์คอมพิวเตอร์'),
(2, 'หลักสูตรวิศวกรรมซอฟต์แวร์'),
(3, 'หลักสูตรเทคโนโลยีสารสนเทศ');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `student_id`, `activity_id`, `registration_date`) VALUES
(1, 1, 1, '2024-12-23 12:57:45'),
(2, 1, 2, '2024-12-23 12:57:45'),
(3, 1, 3, '2024-12-23 12:57:45'),
(4, 1, 4, '2024-12-23 12:57:45'),
(5, 1, 5, '2024-12-23 12:57:45'),
(6, 1, 6, '2024-12-23 12:57:45'),
(7, 1, 7, '2024-12-23 12:57:45'),
(8, 1, 8, '2024-12-23 12:57:45'),
(9, 4, 4, '2024-12-23 13:17:29'),
(10, 4, 3, '2024-12-23 13:17:35'),
(11, 4, 8, '2024-12-23 13:21:17'),
(12, 4, 5, '2024-12-23 13:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `encoding` blob NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL DEFAULT 'student',
  `year_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `first_name`, `last_name`, `email`, `password`, `role`, `year_id`, `program_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, '1', 'Somchai', 'Sukhum', 'somchai.sukhum@example.com', 'hashed_password_1', 'student', 1, 1, 1, '2024-01-01 03:00:00', '2024-12-23 12:37:40'),
(2, '2', 'Anong', 'Suthipon', 'anong.suthipong@example.com', 'hashed_password_2', 'teacher', 0, 0, 0, '2023-05-15 02:30:00', '2024-12-23 12:45:21'),
(3, '3', 'Pimchanok', 'Chaiyaporn', 'admin@gmail.com', '$2y$10$Js4ZDduDoQcKLhXtxQgIH.lDJ5FjBE2wteQXuu54.QN90ZWIRDkAq', 'admin', 2022, 3, 3, '2022-08-10 01:45:00', '2024-12-22 09:06:31'),
(4, '1234', 'ทดสอบ', 'ทดสอบ', 'test@gmail.com', '$2y$10$Js4ZDduDoQcKLhXtxQgIH.lDJ5FjBE2wteQXuu54.QN90ZWIRDkAq', 'student', 1, 1, 1, '2024-12-22 09:04:28', '2024-12-22 09:07:45'),
(5, '234234234', 'asdasd', 'asdasd', 'asduads@sfsdf.com', '$2y$10$0nqbjlq.wBEwAhZCWTQqn.khMRrM8bGplJr81w.jjqhrZCpTrwXcq', 'student', 2, 2, 2, '2024-12-23 12:33:07', '2024-12-23 12:33:07'),
(6, '', 'ssdf', 'sdfsfds', 'sfdsdf@gmail.com', '$2y$10$EVX4nm9j1vtmm/.UU6QdMOy8abRIH.1.gKyjCXKB1xidcEUzQalq2', 'teacher', 0, 0, 0, '2024-12-23 12:42:04', '2024-12-23 12:45:15'),
(7, '', 'ทดสอบ', 'ทดสอบ', 'tea@gmail.com', '$2y$10$VaGqNv.PjTAdzlkmbz6NqekdhZLYZymSXUCKpkCUL5jdD8NUkLk1K', 'teacher', 0, 0, 0, '2024-12-23 12:46:03', '2024-12-23 12:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `year_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `year_name`) VALUES
(1, 'ปี 1'),
(2, 'ปี 2'),
(3, 'ปี 3'),
(4, 'ปี 4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faces`
--
ALTER TABLE `faces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faces`
--
ALTER TABLE `faces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD CONSTRAINT `check_ins_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `check_ins_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`);

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
