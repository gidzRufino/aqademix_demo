-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2018 at 11:04 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `quizitems`
--

CREATE TABLE `quizitems` (
  `qi_id` int(11) NOT NULL,
  `date_created` date DEFAULT NULL,
  `date_activation_key` date DEFAULT NULL,
  `date_expired` date DEFAULT NULL,
  `qi_title` varchar(50) DEFAULT NULL,
  `instruction` varchar(60) DEFAULT NULL,
  `qt_id` int(11) DEFAULT NULL,
  `qtag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizitems`
--

INSERT INTO `quizitems` (`qi_id`, `date_created`, `date_activation_key`, `date_expired`, `qi_title`, `instruction`, `qt_id`, `qtag_id`) VALUES
(1, NULL, '2018-03-17', '2018-03-18', 'think twist', 'identify of each question. God bless you all', 2, 4),
(6, NULL, '2018-03-17', '2018-03-24', 'true or false 101', 'try', 3, 0),
(7, NULL, '2018-03-17', '2018-03-24', 'true or false 102', 'try', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quizmultiple`
--

CREATE TABLE `quizmultiple` (
  `qm_id` int(11) NOT NULL,
  `choice` varchar(50) DEFAULT NULL,
  `choice_stated` varchar(50) DEFAULT NULL,
  `qi_id` int(11) DEFAULT NULL,
  `qq_id` int(11) DEFAULT NULL,
  `num_choices` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quizquestions`
--

CREATE TABLE `quizquestions` (
  `qq_id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `right_answer` varchar(50) NOT NULL,
  `qi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizquestions`
--

INSERT INTO `quizquestions` (`qq_id`, `question`, `right_answer`, `qi_id`) VALUES
(1, 'who is the most handsome in the philippines? input the family name only', 'cabatana', 1),
(2, 'who is the most powerful man in the philippines? input the code name only', 'mampz', 1),
(3, 'most gentlement dog of the year?', 'pug', 1),
(4, 'who is the most beautiful thing on earth?', 'shoe', 1),
(5, 'yes', 'True', 6),
(6, 'no', 'False', 6),
(7, 'yes', 'True', 7),
(8, 'no', 'False', 7),
(9, 'yes', 'True', 7),
(10, 'no', 'False', 7);

-- --------------------------------------------------------

--
-- Table structure for table `quizsubject`
--

CREATE TABLE `quizsubject` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizsubject`
--

INSERT INTO `quizsubject` (`sub_id`, `sub_name`) VALUES
(1, 'samplesub'),
(2, 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `quiztag`
--

CREATE TABLE `quiztag` (
  `qtag_id` int(11) NOT NULL,
  `tag_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiztag`
--

INSERT INTO `quiztag` (`qtag_id`, `tag_name`) VALUES
(3, 'grammare'),
(4, 'word cookies');

-- --------------------------------------------------------

--
-- Table structure for table `quiztype`
--

CREATE TABLE `quiztype` (
  `qt_id` int(11) NOT NULL,
  `qtuiz_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiztype`
--

INSERT INTO `quiztype` (`qt_id`, `qtuiz_type`) VALUES
(1, 'Multple Choice'),
(2, 'Identification'),
(3, 'True or False');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quizitems`
--
ALTER TABLE `quizitems`
  ADD PRIMARY KEY (`qi_id`);

--
-- Indexes for table `quizmultiple`
--
ALTER TABLE `quizmultiple`
  ADD PRIMARY KEY (`qm_id`);

--
-- Indexes for table `quizquestions`
--
ALTER TABLE `quizquestions`
  ADD PRIMARY KEY (`qq_id`);

--
-- Indexes for table `quizsubject`
--
ALTER TABLE `quizsubject`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `quiztag`
--
ALTER TABLE `quiztag`
  ADD PRIMARY KEY (`qtag_id`);

--
-- Indexes for table `quiztype`
--
ALTER TABLE `quiztype`
  ADD PRIMARY KEY (`qt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quizitems`
--
ALTER TABLE `quizitems`
  MODIFY `qi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quizmultiple`
--
ALTER TABLE `quizmultiple`
  MODIFY `qm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizquestions`
--
ALTER TABLE `quizquestions`
  MODIFY `qq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quizsubject`
--
ALTER TABLE `quizsubject`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiztag`
--
ALTER TABLE `quiztag`
  MODIFY `qtag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quiztype`
--
ALTER TABLE `quiztype`
  MODIFY `qt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
