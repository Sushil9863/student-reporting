-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2026 at 03:43 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

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
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `class_id` int NOT NULL,
  `section` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `father_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mother_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_contact` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `guardian_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guardian_relation` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
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

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
