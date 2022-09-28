-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2022 at 12:56 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tbs_2015`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(50) NOT NULL,
  `ccode` varchar(10) NOT NULL,
  `ctitle` varchar(50) NOT NULL,
  `cunit` int(2) NOT NULL,
  `level` int(2) NOT NULL,
  `semester` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `ccode`, `ctitle`, `cunit`, `level`, `semester`) VALUES
(2, 'COM112', 'Introduction To Programming', 4, 1, 'First'),
(3, 'COM111', 'Introduction To computer', 4, 1, 'First'),
(4, 'STA112', 'Descriptive Statistics', 3, 1, 'First'),
(5, 'COM211', 'Java Programming I', 6, 2, 'Third'),
(6, 'COM212', 'MIS', 4, 2, 'Third');

-- --------------------------------------------------------

--
-- Table structure for table `course_allocation`
--

CREATE TABLE `course_allocation` (
  `id` int(50) NOT NULL,
  `c_id` int(50) NOT NULL,
  `dpt_id` int(50) NOT NULL,
  `academic_session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_allocation`
--

INSERT INTO `course_allocation` (`id`, `c_id`, `dpt_id`, `academic_session`) VALUES
(2, 3, 1, '2017/2018'),
(12, 2, 5, '2017/2018'),
(13, 2, 1, '2017/2018'),
(15, 3, 1, '2017/2019'),
(17, 4, 1, '2017/2018'),
(18, 4, 2, '2017/2018'),
(19, 4, 6, '2017/2018'),
(32, 5, 1, '2017/2018'),
(33, 6, 1, '2017/2018');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(50) NOT NULL,
  `dpt_name` varchar(100) NOT NULL,
  `dpt_school` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dpt_name`, `dpt_school`) VALUES
(1, 'Computer science', 'Management and technology'),
(2, 'Agric Technology', 'Business Administration'),
(6, 'Statistics', 'Management and technology');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(50) NOT NULL,
  `staffid` varchar(12) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `department` int(50) NOT NULL,
  `rank` varchar(40) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staffid`, `surname`, `first_name`, `middle_name`, `department`, `rank`, `gender`) VALUES
(1, 'FPB/S/P/001', 'Ahmed', 'Muhammed', 'A', 1, 'HOD', 'Male'),
(3, 'FPB/S/P/002', 'Julius', 'Igbasho', 'Irlomum', 1, 'HOD', 'Male'),
(4, 'FPB/S/P/005', 'Muhammad', 'Ahmed', 'J', 6, 'HOD', 'Male'),
(5, 'FPB/S/P/009', 'Musa', 'Bala', 'Aminu', 6, 'HOD', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `time_table_schedule`
--

CREATE TABLE `time_table_schedule` (
  `id` int(50) NOT NULL,
  `dpt_id` int(50) NOT NULL,
  `staff_id` int(50) NOT NULL,
  `course_id` int(50) NOT NULL,
  `level` int(2) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `session` varchar(10) NOT NULL,
  `time` varchar(20) NOT NULL,
  `day` varchar(10) NOT NULL,
  `venue` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_table_schedule`
--

INSERT INTO `time_table_schedule` (`id`, `dpt_id`, `staff_id`, `course_id`, `level`, `semester`, `session`, `time`, `day`, `venue`) VALUES
(48, 1, 3, 3, 1, 'First', '2017/2018', '10:00 - 12:00', 'Monday', 'LAB 3'),
(49, 1, 1, 4, 1, 'First', '2017/2018', '08:00 - 10:00', 'Monday', 'LAB 3'),
(51, 1, 1, 3, 1, 'First', '2017/2018', '10:00 - 12:00', 'Friday', 'LAB 2'),
(52, 1, 3, 3, 1, 'First', '2017/2018', '10:00 - 12:00', 'Wednesday', 'LAB 2'),
(54, 1, 1, 2, 1, 'First', '2017/2018', '02:00 - 04:00', 'Monday', 'Theater 1'),
(55, 1, 1, 5, 2, 'Third', '2017/2018', '02:00 - 04:00', 'Monday', 'LAB 3'),
(61, 1, 1, 5, 2, 'Third', '2017/2018', '08:00 - 10:00', 'Tuesday', 'LAB 3'),
(63, 1, 3, 6, 2, 'Third', '2017/2018', '10:00 - 12:00', 'Tuesday', 'LAB 2'),
(64, 1, 1, 5, 2, 'Third', '2017/2018', '10:00 - 12:00', 'Monday', 'Theater 1');

-- --------------------------------------------------------

--
-- Table structure for table `ttbs_staff`
--

CREATE TABLE `ttbs_staff` (
  `id` int(50) NOT NULL,
  `staff_id` int(50) NOT NULL,
  `course_id` int(50) NOT NULL,
  `dpt_id` int(50) NOT NULL,
  `level` int(2) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ttbs_staff`
--

INSERT INTO `ttbs_staff` (`id`, `staff_id`, `course_id`, `dpt_id`, `level`, `semester`, `session`) VALUES
(1, 1, 3, 1, 1, 'First', '2017/2018'),
(2, 1, 2, 1, 1, 'First', '2017/2018'),
(3, 3, 2, 1, 0, '', '2017/2018');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `department`, `username`, `password`, `type`) VALUES
(1, '1', 'FPB/SP/001', '123', 0),
(2, NULL, 'Admin', 'admin', 1),
(3, '2', '4wbcd', '6dLv1', 0),
(8, '6', 'Wwo$O', '5g1tf', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_allocation`
--
ALTER TABLE `course_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_table_schedule`
--
ALTER TABLE `time_table_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ttbs_staff`
--
ALTER TABLE `ttbs_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_allocation`
--
ALTER TABLE `course_allocation`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `time_table_schedule`
--
ALTER TABLE `time_table_schedule`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `ttbs_staff`
--
ALTER TABLE `ttbs_staff`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
