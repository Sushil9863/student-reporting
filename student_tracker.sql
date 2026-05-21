-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2026 at 11:11 AM
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
(6, '3 N'),
(7, '4 P'),
(2, '4 R'),
(5, '5 A'),
(4, '5 D');

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subject_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_records`
--

INSERT INTO `daily_records` (`id`, `student_id`, `date`, `homework_done`, `classwork_done`, `behavior`, `discipline`, `uniform`, `handwriting`, `remarks`, `created_at`, `subject_id`) VALUES
(10, 72, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(11, 66, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(12, 71, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(13, 65, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(14, 75, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(15, 64, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(16, 69, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(17, 78, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(18, 68, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(19, 76, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(20, 67, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(21, 77, '2026-05-15', 0, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(22, 62, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(23, 63, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(24, 79, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(25, 80, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(26, 74, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(27, 70, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(28, 73, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:15:55', 3),
(29, 72, '2026-05-15', 1, 0, 'good', 'warning', 'improper', 'improving', '', '2026-05-15 04:17:36', 1),
(30, 66, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(31, 71, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(32, 65, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(33, 75, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(34, 64, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(35, 69, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(36, 78, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(37, 68, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(38, 76, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(39, 67, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(40, 77, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(41, 62, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(42, 63, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(43, 79, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(44, 80, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(45, 74, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(46, 70, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1),
(47, 73, '2026-05-15', 1, 1, 'good', 'good', 'proper', 'improving', '', '2026-05-15 04:17:36', 1);

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
(8, 'Pranish Raila', 2, 'Rara', 'Pramod Raila', 'Kalpana Raila', '9845182831', 'Khairahani 6', '', ''),
(9, 'Sangit Ghimire', 2, 'Rara', 'Sushil Ghimire', 'Samjhana Ghimire', '9864515707', 'Rapti 8', '', ''),
(10, 'Samrat Gautam', 2, 'Rara', 'Ramesh Gautam', 'Sita Gautam', '9764548061', 'Khairahani 6', '', ''),
(11, 'Aayam Poudel', 2, 'Rara', 'Ram Prasad Poudel', 'Ashmita Poudel', '9845432125', 'Khairahani-8', '', ''),
(12, 'Sanjit Ghimire', 2, 'Rara', 'Sushil Ghimire', 'Samjhana Ghimire', '9864515707', 'Rapti 8', '', ''),
(13, 'Saugat Subedi', 2, 'Rara', 'Subarna Subedi', 'Gauri Subedi', '9821188545', 'Khairahani 9', '', ''),
(14, 'Aarnav Chaudhary', 2, 'Rara', 'Ramesh Chaudhary', 'Anita Chaudhary', '9865239590', 'Khairahani 7', '', ''),
(15, 'Kyaliska Praja', 2, 'Rara', 'Krishna Praja', 'Manju Praja', '', 'Khairahani 6', '', ''),
(16, 'samip Duwadi', 2, 'Rara', 'Suresh Duwadi', 'Mandira Pandey', '', 'Khairahani 12', '', ''),
(17, 'Shyavion Chaudhary', 2, 'Rara', 'Samir Chaudhary', 'Anjila Chaudhary', '', 'Khairahani 9', '', ''),
(18, 'Rijash Chaudhary', 2, 'Rara', 'Jaleshwor Chaudhary', 'Renuka Chaudhary', '9821288267', 'Khairahani 9', '', ''),
(19, 'Unisha Chhetri', 2, 'Rara', 'Kamal Chhetri', 'Kabita Chhetri', '9844208883', 'Khairahani 8, Magani', '', ''),
(20, 'Suprabha Lohani', 2, 'Rara', 'Pradip Lohani', 'Sushma Lohani', '984520128', 'Khairahani 1', '', ''),
(21, 'Anshu Subedi', 2, 'Rara', 'Bharat Subedi', 'Gita Subedi', '9814240083', 'Khairahani 5', '', ''),
(22, 'Rashmi Rana Magar', 2, 'Rara', 'Resham Rana magar', 'Sangita Rana Magar', '', 'Chainpur', '', ''),
(23, 'Grayson Chaudhary', 2, 'Rara', 'Sante Chaudhary', 'Maya Chaudhary', '', 'Khairahani 6', '', ''),
(24, 'Brijesh Kandel', 2, 'Rara', 'Binod Kandel', 'Sarala Khadka', '9840129143', 'Khairahani 6', '', ''),
(25, 'Dipsan Bartaula', 2, 'Rara', 'Bishnu Bartaula', 'Durga Bartaula', '9845957840', 'Khairahani 8', '', ''),
(26, 'Sabin Bhatta', 2, 'Rara', 'Ram Prasad Bhatta', 'Sarmila Bhatta Khanal', '9843636095', 'Khairahani 10', '', ''),
(27, 'Aayush Sharma Lamichhane', 2, 'Rara', 'Bipin Sharma Lamichhane', 'Anita Sharma Lamichhane', '9841381424', 'Khairahani 6', '', ''),
(28, 'Neeva Singh Thakuri', 2, 'Rara', 'Kamal Thakuri', 'Kanchan Thakuri', '9855084081', 'Khairahani 8', '', ''),
(29, 'Krisha Thapaliya', 2, 'Rara', 'Krishnahari Thapaliya', 'Saraswati Ranabhat', '9867026867', 'Khairahani 6', '', ''),
(30, 'Renaissance Shrestha', 2, 'Rara', 'Yadav Shrestha', 'Fulmaya Shrestha', '', 'Khairahani 6', '', ''),
(31, 'Sparsha Mudbhari', 2, 'Rara', 'DharmaRaj Mudbhari', 'Rishika Mudbhari', '9855043597', 'Khairahani 8', '', ''),
(32, 'Sasoul Kandel', 4, 'D', 'Shalikram Kandel', 'Sunita Kandel', '9845957712', 'Khairahani-6', '', ''),
(33, 'Prankit Chaudhary', 4, 'D', 'Dinesh Chaudhary', 'Nirmala Mahato', '9845480258', 'Khairahani 10', '', ''),
(34, 'Aparna Poudel', 4, 'D', 'Ananda Poudel', 'Prava Lamichhane', '9845078601', 'Khairahani 8', '', ''),
(35, 'Samyug Shrestha', 4, 'D', 'Uttam K Shrestha', 'Apeksha Shrestha', '9845146816', 'Khairahani 12', '', ''),
(36, 'Ritesh Adhikari', 4, 'D', 'Ramesh Adhikari', 'Santoshi Adhikari', '9861190522', 'Khairahani 6', '', ''),
(37, 'Hardik Shiwakoti', 4, 'D', 'Ramesh Shiwakoti', 'Hita Shiwakoti', '9845089676', 'Khairahani 6', '', ''),
(38, 'Diwansi Poudel', 4, 'D', 'Dinesh Poudel', 'Sima Poudel', '9845270646', 'Rapti 5', '', ''),
(39, 'Aariya Saru Magar', 4, 'D', 'Bhujendra Saru Magar', 'Gita Godar', '9865027919', 'Khairahani 6', '', ''),
(40, 'Asia Lamichhane', 4, 'D', 'Arjun Lamichhane', 'Gita Lamichhane', '9845817290', 'Khairahani 9', '', ''),
(41, 'Aarushi Tamang', 4, 'D', 'Surendra Tamang', 'Ramisha Pun', '9816238371', 'Rapti 9', 'Bishal Pun', 'Maternal Uncle'),
(42, 'Krishu Pathak', 4, 'D', 'Krishna Pathak', 'Sunita Pathak', '9845055871', 'Khairahani 12', '', ''),
(43, 'Shanvi Chaudhary', 4, 'D', 'Chunamani Chaudhary', 'Tomendri Chaudhary', '9845160494', 'Khairahani 8', '', ''),
(44, 'Aarav Bartaula', 4, 'D', 'Keshav Bartaula', 'Nirmala Adhikari', '9845108437', 'Khairahani 6 ', '', ''),
(45, 'Aaroshi Kandel', 4, 'D', 'Raju Kandel', 'Anita Kandel', '9864246825', 'Khairahani 5', '', ''),
(46, 'Sara Duwadi', 4, 'D', 'Raj Duwadi', 'Mira Duwadi', '9814238160', 'Khairahani 12', 'Mandira Pandey', 'Maternal Aunt'),
(47, 'Ritis Pathak', 4, 'D', 'Ramchandra Pathak', 'Sharmila Pathak', '9860288725', 'Rapti 7', '', ''),
(48, 'Aarav Sapkota', 4, 'D', 'Gopal Sapkota', 'Nita Simkhada', '9855070710', 'Khairahani 6', '', ''),
(49, 'Simant Dhungana', 4, 'D', 'Rajesh Dhungana', 'Anjana Dhungana', '9821111730', 'Rapti 9', '', ''),
(50, 'Prachi Phuyal', 4, 'D', 'Rajan K.C', 'Pratima K.C', '9845820318', 'Khairahani 5', '', ''),
(51, 'Nayan Chaudhary', 4, 'D', 'Bijay Chaudhary', 'Sunita Chaudhary', '9855036951', 'Khairahani 8', '', ''),
(52, 'Nishan Chaudhary', 4, 'D', 'Naresh Chaudhary', 'Mina Chaudhary', '9845734256', 'Bairahani', '', ''),
(53, 'Sulav Ruwali', 4, 'D', 'Lokraj Ruwali', 'Sudha Ruwali', '9855070904', 'Bhandara', '', ''),
(54, 'Ujan Poudel', 4, 'D', 'Mahendra Poudel', 'Shova K.C', '9867761968', 'Tarauli', '', ''),
(55, 'Samyog Timalsena', 5, 'A', 'Saroj Timalsena', 'Rebati Timalsena', '9845172622', 'Daduwa', '', ''),
(56, 'Shreya Bardewa', 5, 'A', 'Mitra Bardewa', 'Bina Bardewa', '9809101686', 'Parsa', '', ''),
(57, 'Pranish K.C', 5, 'A', 'Prem K.C.', 'Isha K.C.', '9847783111', 'Sawanpur', '', ''),
(58, 'Siddhika Adhikari', 6, 'N', 'Subodh Adhikari', 'Sandisha Marahatta', '9845532797', 'Rapti 8', '', ''),
(59, 'Aayan Maharjan', 2, 'Rara', 'Dipak Maharjan', 'Apsara Maharjan', '9855024084', 'Parsa', '', ''),
(60, 'Sanjina Chalise', 2, 'Rara', 'Narayan Chalise', 'Sabita Chalise', '9844735072', 'Budauli', '', ''),
(61, 'Sayara Thapa', 2, 'Rara', 'Raja Ram Thapa', 'Sushma Thapa', '9855087746', 'Badagaun', '', ''),
(62, 'Samar Duwadi', 7, 'Phewa', 'Suresh Duwadi', 'Mandira Pandey', '', 'Khairahani 6', '', ''),
(63, 'Samarpan Thapa', 7, 'Phewa', 'Suresh Thapa', 'Pushpa Thapa', '', 'Tungara', '', ''),
(64, 'Gahan Shrestha', 7, 'Phewa', 'Nim Shrestha', 'Kanchan Shrestha', '', 'Rasauli', '', ''),
(65, 'Arshab Chaudhary ', 7, 'Phewa', 'Anjan Chaudhary ', 'Ranjita Chaudhary ', '9845948023', 'Khairahani 7', '', ''),
(66, 'Aditya Sapkota', 7, 'Phewa', 'Shyam Sapkota', 'Laxmi Sapkota ', '9845018326', 'Bairahani', '', ''),
(67, 'Prabhat Kandel', 7, 'Phewa', 'Pradip Kandel', 'Devi Kandel', '9865423223', 'Majhuee', 'Anita Poudel', 'Aunty'),
(68, 'Nikita Pun', 7, 'Phewa', 'Bhim Bdr Pun', '', '', 'Amilapani', '', ''),
(69, 'Krisika Thapa', 7, 'Phewa', 'Krishna Thapa', 'Devika Thapa', '9820298843', 'Badagaun', '', ''),
(70, 'Subiksha Dhital', 7, 'Phewa', 'Indra Dhital', 'Sujata Dhital', '', 'Bhandara', '', ''),
(71, 'Angel Sarraf', 7, 'Phewa', 'Mukesh Sarraf', 'Priti Sarraf', '9801355022', 'Parsa', '', ''),
(72, 'Aarohi Poudel', 7, 'Phewa', 'Samsher Poudel', 'Ambika Poudel', '9817270101', 'Budauli', '', ''),
(73, 'Unisha Rana', 7, 'Phewa', 'Prem Bahadur Rana', 'Durga Rana', '', 'Karaiya', '', ''),
(74, 'Smith Mahato', 7, 'Phewa', 'Bheshraj Chaudhary ', 'Sabita Mahato', '', 'Jyamire', '', ''),
(75, 'Bikalpa Dhungana', 7, 'Phewa', 'Bir Bahadur Dhungana', 'Kamala Acharya', '', 'Simaltandi', '', ''),
(76, 'Nishan Khatri', 7, 'Phewa', 'Ganga Bahadur Khatri', 'Kabita Khatri', '9864649764', 'Sisani', '', ''),
(77, 'Rushika Sharma', 7, 'Phewa', 'Krishna Sharma', 'Rekha Sharma', '9845177224', 'Parsa', '', ''),
(78, 'Mirap Shrestha', 7, 'Phewa', 'Mahan Shrestha ', 'Punam Shrestha ', '', 'Salauli', '', ''),
(79, 'Samir Ansari', 7, 'Phewa', 'Salim Andari', 'Rakshya Mahato', '9825237798', 'Jamauli', '', ''),
(80, 'Saurav Baral', 7, 'Phewa', 'Num Bdr Baral', 'Samjhana Baral', '9867000541', 'Parsa', '', ''),
(81, 'Kristal Chaudhary ', 5, 'A', 'Krishna Chaudhary', 'Kabita Chaudhary ', '9844238837', 'Tulsipur', '', ''),
(82, 'Aarush Chhetri', 5, 'A', 'Shyam Chhetri ', 'Muna K C', '9847245617', 'Parsa', '', ''),
(83, 'Krishma Shrestha', 5, 'A', 'Udaya Narayan Shrestha', 'Mandira Shrestha', '9818095998', 'Dhusari', '', ''),
(84, 'Krish Bohara', 5, 'A', 'Krishna Bohara', 'Laxmi Bohara', '9742486668', 'Budauli', '', ''),
(85, 'Sabhyata Bhetwal', 5, 'A', 'Balkrishna Bhetwal', 'Bhawani Bhetwal', '', 'Rapti 4 daduwa', '', ''),
(86, 'Pragya Adhikari', 5, 'A', 'Prem Adhikari ', 'Parbati Adhikari ', '9745291153', 'Khairahani 12', '', ''),
(87, 'Aayam Rai', 5, 'A', 'Purna Rai', 'Tara Rai', '9860652064', 'Durga bhawani', '', ''),
(88, 'Shristi Thapa Magar', 5, 'A', 'Ek Bahadur Thapa', 'Bindu Thapa', '9814287440', 'Simreni', '', ''),
(89, 'Shiwangi Shrestha', 5, 'A', 'Nabin K Shrestha', 'Sapana Malla', '9845183144', 'Khairahani 12 ', '', ''),
(90, 'Aarohi Chaudhary ', 5, 'A', 'Susan Chaudhary ', 'Muna Chaudhary ', '9809166060', 'Khairahani 1 baheri', '', ''),
(91, 'Mandip Pandey', 5, 'A', 'Krishna Pandey', 'Gita Pandey', '9840670755', 'Khairahani 6', '', ''),
(92, 'Abhiyan Shrestha', 5, 'A', 'Lekh B Shrestha', 'Mina Shrestha ', '', 'Bhandara', '', ''),
(93, 'Samar Chaudhary ', 5, 'A', 'Bimal Chaudhary ', 'Bikrami Chaudhary ', '', 'Bairahani', '', ''),
(94, 'Safal Aryal', 5, 'A', 'Saroj Aryal', 'Sila Rijal', '9846337768', 'Khairahani 10 milan chowk ', '', ''),
(95, 'Anuj Lamichhane ', 5, 'A', 'Arjun Lamichhane ', 'Anita Lamichhane ', '9843203298', 'Budauli', '', ''),
(96, 'Ankit Uprety', 5, 'A', 'Uddav Uprety', 'Ambika Shiwakoti', '9845172372', 'Kathar', '', ''),
(97, 'Suprim Bartaula', 5, 'A', 'Ram K Bartaula', 'Sunita Bartaula', '', 'Parsa', '', ''),
(98, 'Samar Jung Rai', 5, 'A', 'Namraj Rai', 'Sushma Rai', '', 'Parsa', '', ''),
(99, 'Shishir Uprety', 5, 'A', 'Rajan Uprety', 'Santi Uprety', '9861469811', 'Sisahani', '', ''),
(100, 'Ankush Khand', 5, 'A', 'Ajay Khand', 'Kusma Khand', '9822248453', 'Amritpani', '', ''),
(101, 'Binam Shrestha ', 5, 'A', 'Bimal Shrestha', 'Samjhana Shrestha', '9819274827', 'Simreni', '', ''),
(102, 'Prafulla Mainali', 5, 'A', 'Pallav Mainali', 'Sweta Mainali', '', 'Kharkhutte', '', ''),
(103, 'Arman Ansari', 5, 'A', 'Anwarul Ansari', 'Samma Khatun', '', 'Tulsipur ', '', ''),
(104, 'Sahas Chaudhary ', 5, 'A', 'Ramdin Chaudhary ', 'Narayani Aryal', '', 'Bhandara', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(3, 'Computer'),
(1, 'English I'),
(2, 'English II'),
(7, 'Khairahani'),
(4, 'Maths'),
(5, 'Nepali'),
(6, 'Samajik');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_classes`
--

INSERT INTO `teacher_classes` (`id`, `teacher_id`, `class_id`) VALUES
(15, 5, 2),
(16, 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`id`, `teacher_id`, `class_id`, `subject_id`) VALUES
(8, 5, 2, 3),
(9, 5, 7, 1),
(10, 5, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher') NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `class_id`, `full_name`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, 'Administrator', '2026-05-13 13:41:18'),
(2, 'sushil', '$2y$10$akEev/lKyuRYXNY/D15gp.tXmJpUryKXbAEuZnDFk5BRk0MVXk/ca', 'teacher', NULL, 'Sushil Lamichhane', '2026-05-13 13:47:18'),
(4, 'Bikash', '$2y$10$Z3FHXW3vIGW3wbmGpeNZheqsnISvUu2pAfgCPsGrGedOEEvnlmz8K', 'teacher', NULL, 'Bikash', '2026-05-14 02:00:47'),
(5, 'neeran', '$2y$10$cl1xS5t/C2vTPRQ43G1EjOFD3Psd66RRKRxbEDr/DExKpSdf66k1G', 'teacher', NULL, 'Niran', '2026-05-14 02:59:42');

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
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_subject_unique` (`class_id`,`subject_id`),
  ADD KEY `idx_class_id` (`class_id`),
  ADD KEY `idx_subject_id` (`subject_id`);

--
-- Indexes for table `daily_records`
--
ALTER TABLE `daily_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_date_subject` (`student_id`,`date`,`subject_id`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_date` (`date`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_class_unique` (`teacher_id`,`class_id`),
  ADD KEY `idx_teacher_id` (`teacher_id`),
  ADD KEY `idx_class_id` (`class_id`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_subject_unique` (`teacher_id`,`class_id`,`subject_id`),
  ADD KEY `idx_teacher_id` (`teacher_id`),
  ADD KEY `idx_class_id` (`class_id`),
  ADD KEY `idx_subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_records`
--
ALTER TABLE `daily_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

--
-- Constraints for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD CONSTRAINT `teacher_classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_classes_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
