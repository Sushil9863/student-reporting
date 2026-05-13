-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2026 at 06:49 AM
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
-- Database: `student_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`) VALUES
(1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `daily_records`
--

CREATE TABLE `daily_records` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `homework_done` tinyint(1) DEFAULT 0,
  `classwork_done` tinyint(1) DEFAULT 0,
  `behavior` enum('good','average','poor') DEFAULT 'average',
  `discipline` enum('good','warning','bad') DEFAULT 'good',
  `uniform` enum('proper','improper') DEFAULT 'proper',
  `handwriting` enum('improving','same','poor') DEFAULT 'same',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_records`
--

INSERT INTO `daily_records` (`id`, `student_id`, `date`, `homework_done`, `classwork_done`, `behavior`, `discipline`, `uniform`, `handwriting`, `remarks`, `created_at`) VALUES
(1, 1, '2026-05-02', 1, 1, 'good', 'good', 'improper', 'improving', '', '2026-05-02 04:36:40'),
(2, 1, '2026-05-03', 1, 0, 'average', 'good', 'proper', 'improving', '', '2026-05-02 04:39:06'),
(3, 1, '2026-05-04', 0, 1, 'average', 'warning', 'proper', 'same', '', '2026-05-02 04:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section` varchar(10) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `parent_contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_relation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `class_id`, `section`, `father_name`, `mother_name`, `parent_contact`, `address`, `guardian_name`, `guardian_relation`) VALUES
(1, 'Bidhan Uprety', 1, 'Rose', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Student 1', 1, 'Lotus', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Student 2', 1, 'C', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Demo Stuudent', 1, 'B', 'Demo Father', 'Demo Mother', '9876543210', 'Khairahani-12', '', ''),
(7, 'Demo Student 2', 1, 'A', 'Demo Father 2', 'Demo Mother 2', '987545421', 'Parsa', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `daily_records`
--
ALTER TABLE `daily_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_date` (`student_id`,`date`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_date` (`date`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_records`
--
ALTER TABLE `daily_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daily_records`
--
ALTER TABLE `daily_records`
  ADD CONSTRAINT `daily_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
