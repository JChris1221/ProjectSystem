-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2020 at 08:47 AM
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
(6, 'chap32', '81dc9bdb52d04dc20036dbd8313ed055', 'Spike', 'Chapman', 2),
(7, 'patty', '81dc9bdb52d04dc20036dbd8313ed055', 'Patricia', 'Stone', 2),
(8, 'kay', '81dc9bdb52d04dc20036dbd8313ed055', 'Kaylen', 'Schroeder', 2);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Panelist_Id` int(11) NOT NULL,
  `Group_Id` int(11) NOT NULL,
  `Comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Panelist_Id`, `Group_Id`, `Comment`) VALUES
(5, 18, 'test comment from martha'),
(8, 16, 'Some Random Comment'),
(8, 18, 'Comment from kaylen schroeder (AI Can\'t ever turn robots to human blah blah)');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Beginner` varchar(255) NOT NULL,
  `Acceptable` varchar(255) NOT NULL,
  `Proficient` varchar(255) NOT NULL,
  `Exemplary` varchar(255) NOT NULL,
  `Weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`Id`, `Title`, `Beginner`, `Acceptable`, `Proficient`, `Exemplary`, `Weight`) VALUES
(1, 'Content', 'Central purpose or argument is not clearly identified Analysis is Vague or not evident. Reader is confused or may be misinformed', 'Information Supports central purpose or argument at times. Analysis is basic or general. Reader gains few insights', 'Information provides reasonable support for a central purpose or argument and displays evidence of a basic analysis of a significant topic Reader gains some insights.', 'Balanced presentation of relevant information that clearly supports a central purpose or argument and shows a thoughtful, in-depth, analysis of a significant topic. Reader gains important insights.', 0.066),
(2, 'Organization', 'The writing is not logically organized. Frequently, ideas fail to make sense together. The reader cannot identify a line of reasoning and loses interest', 'In general, the writing is arranged logically, although occasionally ideas fail to make sense together. The reader is fairly clear about what the writer intends.', 'The ideas are arranged logically to support the central purpose or argument. They are usually clearly linked to each other. For the most part the reader can follow the line of reasoning', 'The ideas are arranged logically to support the purpose or argument. They flow smoothly from one to another and are clearly linked to each other. The reader can follow the line of reasoning', 0.066),
(3, 'Use of Reference', 'References are seldom cited to support statements.', 'Although attribution is occasionally given, many statements seem unsubstantiated. The reader is confused about the source of information ideas.', 'Professionally legitimate sources that supports the claims are generally present and attribution is, for the most part, clear and fairly represented', 'Compelling evidence from professionally legitimate sources is given to support claims. Attribution is clear and represented', 0.066),
(4, 'Language Conventions', 'There are many grammatical errors.', 'Periodic grammatical errors.', 'There are occasional grammatical errors.', 'The writing is free or almost free of errors', 0.066),
(5, 'Tone', 'The tone is unprofessional. It is not appropriate for an academic research paper.', 'The tone is not consistently professional or appropriate for an academic research paper.', 'The tone is generally professional. For the most part, it is appropriate for an academic research paper.', 'The tone is consistently professional and appropriate for an academic research paper', 0.066),
(6, 'Instructional Content 1', 'Information is inaccurate, incomplete or outdated.', 'Information is not always accurate, complete or current.', 'Information is accurate and most is complete and current', 'Information is accurate, complete and current', 0.066),
(7, 'Instructional Content 2', 'Facts do not come from reliable sources or sources are not identified.', 'Facts come from questionable sources.', 'Facts usually come from reliable sources which are clearly identified.', 'Facts usually come from reliable sources which are clearly identified.', 0.066),
(8, 'Instructional Content 3', 'Little or no overall context for information.', 'Content is note related to larger context', 'Content is usually related to larger context', 'Content and context are consistent with the theme', 0.066),
(9, 'Instructional Content 4', 'Purpose is unclear.', 'Content lacks sense of purpose or central theme.', 'General purpose is identified.', 'All information relates to the stated purpose and learning goals.', 0.066),
(10, 'Instructional Content 5', 'Content focuses entirely on fundamental concepts, rote memory, or recitation of facts; no provision for moving students to higher levels of thinking by applying what is learned', 'Content focuses on fundamental concepts and rarely engages students in higher levels of thinking; students are rarely asked to apply what they learn.', 'Content provides some activities which encourage higher levels of thinking; students are frequently asked to apply what they have learned', 'Content moves learners beyond the basics and encourages higher levels of thinking; students are engaged in applying what they learn', 0.066),
(11, 'Layout 1', 'Layout is confusing.', 'Layout is not intuitive.', 'Layout is clear but learners need help to find necessary features.', 'Layout is clear and intuitive; learners can always find what they need', 0.066),
(12, 'Layout 2', 'Learners cannot navigate through the information to find what they need', 'Layout is difficult to navigate', 'Learners can usually navigate through the information to find what they need.', 'It is easy to navigate through the information to find necessary features.', 0.066),
(13, 'Layout 3', 'Layout is illogical and unpredictable.', 'Layout is frequently illogical.', 'Layout is logical in most cases, but sometimes confusing.', 'Layout is logical.', 0.066),
(14, 'Layout 4', 'Layout is inconsistent.', 'Layout is frequently inconsistent.', 'Layout is frequently consistent but occasionally confusing.', 'Layout is consistent on all pages.', 0.066),
(15, 'Complete', 'Several of the problems are not completed.', 'All but two of the problems are completed.', 'All but one of the problems are completed.', 'All problems are completed.', 0.066);

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
(16, 5, 1),
(16, 6, 2),
(16, 7, 3),
(16, 7, 4),
(16, 8, 3),
(18, 5, 3),
(18, 6, 2),
(18, 7, 1),
(18, 8, 3),
(18, 8, 4),
(19, 5, 2),
(19, 6, 3),
(19, 6, 4),
(19, 7, 3),
(19, 8, 1);

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
(3, 'Panelist'),
(4, 'Professor');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `Criteria_Id` int(11) NOT NULL,
  `Group_Id` int(11) NOT NULL,
  `Panelist_Id` int(11) NOT NULL,
  `Grade` int(11) NOT NULL,
  `DateGiven` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Criteria_Id`, `Group_Id`, `Panelist_Id`, `Grade`, `DateGiven`) VALUES
(1, 16, 8, 3, '2020-03-16'),
(1, 18, 5, 2, '2020-03-16'),
(1, 18, 8, 1, '2020-03-16'),
(1, 19, 5, 1, '2020-03-16'),
(2, 16, 8, 1, '2020-03-16'),
(2, 18, 5, 3, '2020-03-16'),
(2, 18, 8, 2, '2020-03-16'),
(2, 19, 5, 2, '2020-03-16'),
(3, 16, 8, 4, '2020-03-16'),
(3, 18, 5, 3, '2020-03-16'),
(3, 18, 8, 4, '2020-03-16'),
(3, 19, 5, 3, '2020-03-16'),
(4, 16, 8, 2, '2020-03-16'),
(4, 18, 5, 2, '2020-03-16'),
(4, 18, 8, 2, '2020-03-16'),
(4, 19, 5, 2, '2020-03-16'),
(5, 16, 8, 3, '2020-03-16'),
(5, 18, 5, 3, '2020-03-16'),
(5, 18, 8, 1, '2020-03-16'),
(5, 19, 5, 3, '2020-03-16'),
(6, 16, 8, 4, '2020-03-16'),
(6, 18, 5, 2, '2020-03-16'),
(6, 18, 8, 5, '2020-03-16'),
(6, 19, 5, 3, '2020-03-16'),
(7, 16, 8, 2, '2020-03-16'),
(7, 18, 5, 3, '2020-03-16'),
(7, 18, 8, 1, '2020-03-16'),
(7, 19, 5, 4, '2020-03-16'),
(8, 16, 8, 3, '2020-03-16'),
(8, 18, 5, 1, '2020-03-16'),
(8, 18, 8, 4, '2020-03-16'),
(8, 19, 5, 3, '2020-03-16'),
(9, 16, 8, 1, '2020-03-16'),
(9, 18, 5, 1, '2020-03-16'),
(9, 18, 8, 4, '2020-03-16'),
(9, 19, 5, 2, '2020-03-16'),
(10, 16, 8, 3, '2020-03-16'),
(10, 18, 5, 1, '2020-03-16'),
(10, 18, 8, 4, '2020-03-16'),
(10, 19, 5, 1, '2020-03-16'),
(11, 16, 8, 2, '2020-03-16'),
(11, 18, 5, 2, '2020-03-16'),
(11, 18, 8, 3, '2020-03-16'),
(11, 19, 5, 3, '2020-03-16'),
(12, 16, 8, 3, '2020-03-16'),
(12, 18, 5, 4, '2020-03-16'),
(12, 18, 8, 1, '2020-03-16'),
(12, 19, 5, 3, '2020-03-16'),
(13, 16, 8, 4, '2020-03-16'),
(13, 18, 5, 4, '2020-03-16'),
(13, 18, 8, 3, '2020-03-16'),
(13, 19, 5, 2, '2020-03-16'),
(14, 16, 8, 3, '2020-03-16'),
(14, 18, 5, 1, '2020-03-16'),
(14, 18, 8, 4, '2020-03-16'),
(14, 19, 5, 4, '2020-03-16'),
(15, 16, 8, 3, '2020-03-16'),
(15, 18, 5, 4, '2020-03-16'),
(15, 18, 8, 1, '2020-03-16'),
(15, 19, 5, 3, '2020-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `Id` int(11) NOT NULL,
  `Thesis_Title` varchar(255) DEFAULT NULL,
  `Section` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`Id`, `Thesis_Title`, `Section`) VALUES
(16, 'Cacophony and Outrage in Programming: Valuing Oppressive Ethnicity', 'J4S'),
(18, 'Artificial Intelligence Can\'t Ever Turn Robots Into Humans Who Can Think and Feel Emotions', 'J4T'),
(19, 'Neural Network on Chip Analysis', 'J4V');

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
(12, 'Wasim', 'Tang', 16),
(13, 'Laibah', 'Farrow', 16),
(15, 'Aurora', 'Kurr', 18),
(16, 'Isobella', 'Bray', 18),
(17, 'Sean', 'Newton', 18),
(18, 'Aamir', 'Wilkinson', 18),
(19, 'Naima', 'Kavanagh', 18),
(20, 'Safia', 'Waller', 19),
(21, 'Dougie', 'Schmitt', 19),
(22, 'Alix', 'Hoover', 19),
(23, 'Logan', 'Plant', 19);

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Panelist_Id`,`Group_Id`),
  ADD KEY `Group_Id` (`Group_Id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`Id`);

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
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`Criteria_Id`,`Group_Id`,`Panelist_Id`),
  ADD KEY `Group_Id` (`Group_Id`),
  ADD KEY `Panelist_Id` (`Panelist_Id`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`Role_Id`) REFERENCES `roles` (`Id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`Panelist_Id`) REFERENCES `accounts` (`Id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`Group_Id`) REFERENCES `groups` (`Id`);

--
-- Constraints for table `faculty_assignment`
--
ALTER TABLE `faculty_assignment`
  ADD CONSTRAINT `faculty_assignment_ibfk_1` FOREIGN KEY (`Group_Id`) REFERENCES `groups` (`Id`),
  ADD CONSTRAINT `faculty_assignment_ibfk_2` FOREIGN KEY (`Account_Id`) REFERENCES `accounts` (`Id`),
  ADD CONSTRAINT `faculty_assignment_ibfk_3` FOREIGN KEY (`Faculty_Type_Id`) REFERENCES `faculty_types` (`Id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`Criteria_Id`) REFERENCES `criteria` (`Id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`Group_Id`) REFERENCES `groups` (`Id`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`Panelist_Id`) REFERENCES `accounts` (`Id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`Group_Id`) REFERENCES `groups` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
