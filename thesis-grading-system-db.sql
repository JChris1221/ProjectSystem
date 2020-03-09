-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2020 at 04:30 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesis-grading-system-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `Id` int(11) NOT NULL,
  `Username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Role_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`Id`, `Username`, `Password`, `Firstname`, `Lastname`, `Role_Id`) VALUES
(2, 'Admin', '0192023a7bbd73250516f069df18b500', 'Dan', 'Felix', 1),
(5, 'martha1221', '81dc9bdb52d04dc20036dbd8313ed055', 'Martha', 'House', 2),
(6, 'chap32', 'e2fc714c4727ee9395f324cd2e7f331f', 'Spike', 'Chapman', 2),
(7, 'patty', '912e79cd13c64069d91da65d62fbb78c', 'Patricia', 'Stone', 2),
(8, 'kay', '4ea3144e35fd47aafa5bc4bd9190e4ab', 'Kaylen', 'Schroeder', 2);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_assignment`
--

CREATE TABLE `faculty_assignment` (
  `Group_Id` int(11) NOT NULL,
  `Account_Id` int(11) NOT NULL,
  `Faculty_Type_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty_assignment`
--

INSERT INTO `faculty_assignment` (`Group_Id`, `Account_Id`, `Faculty_Type_Id`) VALUES
(14, 5, 3),
(14, 6, 3),
(14, 7, 1),
(14, 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_types`
--

CREATE TABLE `faculty_types` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty_types`
--

INSERT INTO `faculty_types` (`Id`, `Name`) VALUES
(1, 'Adviser'),
(2, 'Panel Chair'),
(3, 'Panelist');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `Id` int(11) NOT NULL,
  `Thesis_Title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`Id`, `Thesis_Title`) VALUES
(14, 'Side effects of programming');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Id`, `Name`) VALUES
(1, 'Admin'),
(2, 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Id` int(11) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Group_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Id`, `Firstname`, `Lastname`, `Group_Id`) VALUES
(4, 'Fabio', 'Ratcliffe', 14),
(5, 'Saul', 'Xiong', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RoleId` (`Role_Id`);

--
-- Indexes for table `faculty_assignment`
--
ALTER TABLE `faculty_assignment`
  ADD PRIMARY KEY (`Group_Id`,`Account_Id`,`Faculty_Type_Id`),
  ADD KEY `Account_Id` (`Account_Id`),
  ADD KEY `Faculty_Type_Id` (`Faculty_Type_Id`);

--
-- Indexes for table `faculty_types`
--
ALTER TABLE `faculty_types`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Group_Id` (`Group_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`Role_Id`) REFERENCES `roles` (`Id`);

--
-- Constraints for table `faculty_assignment`
--
ALTER TABLE `faculty_assignment`
  ADD CONSTRAINT `faculty_assignment_ibfk_1` FOREIGN KEY (`Group_Id`) REFERENCES `groups` (`Id`),
  ADD CONSTRAINT `faculty_assignment_ibfk_2` FOREIGN KEY (`Account_Id`) REFERENCES `accounts` (`Id`),
  ADD CONSTRAINT `faculty_assignment_ibfk_3` FOREIGN KEY (`Faculty_Type_Id`) REFERENCES `faculty_types` (`Id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`Group_Id`) REFERENCES `groups` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
