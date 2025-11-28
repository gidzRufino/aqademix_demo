-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2018 at 07:20 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 5.6.34-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eskwela_brs_2017`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_cat`
--

CREATE TABLE `esk_qm_cat` (
  `qc_id` int(11) NOT NULL,
  `qm_category` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_cat`
--

INSERT INTO `esk_qm_cat` (`qc_id`, `qm_category`) VALUES
(1, 'Language');

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_cat_items`
--

CREATE TABLE `esk_qm_cat_items` (
  `qci_id` int(11) NOT NULL,
  `qci_qc_id` int(11) NOT NULL,
  `qci_sub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_cat_items`
--

INSERT INTO `esk_qm_cat_items` (`qci_id`, `qci_qc_id`, `qci_sub_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_qq`
--

CREATE TABLE `esk_qm_qq` (
  `qq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `ans_id` int(11) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `qq_qt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_qq`
--

INSERT INTO `esk_qm_qq` (`qq_id`, `question`, `ans_id`, `grade_level_id`, `qq_qt_id`) VALUES
(1, 'Who is the <strong>King of the Jungle</strong>?', 0, 0, 2),
(2, 'Who is the Lord of the Ring?', 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_quiz_items`
--

CREATE TABLE `esk_qm_quiz_items` (
  `qi_id` int(11) NOT NULL,
  `qi_qci_id` int(11) NOT NULL,
  `qi_grade_level_id` int(11) NOT NULL,
  `qi_section_id` int(11) NOT NULL,
  `qi_qq_ids` varchar(300) NOT NULL,
  `qi_date_created` datetime NOT NULL,
  `qi_created_by` int(11) NOT NULL,
  `qi_date_activation` datetime NOT NULL,
  `qi_date_expired` datetime NOT NULL,
  `qi_title` varchar(300) NOT NULL,
  `qi_is_public` int(11) NOT NULL COMMENT '0=exclusive; 1=public',
  `qi_is_final` int(11) NOT NULL COMMENT '1=final',
  `qi_parts` varchar(55) NOT NULL,
  `qi_gs_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_quiz_items`
--

INSERT INTO `esk_qm_quiz_items` (`qi_id`, `qi_qci_id`, `qi_grade_level_id`, `qi_section_id`, `qi_qq_ids`, `qi_date_created`, `qi_created_by`, `qi_date_activation`, `qi_date_expired`, `qi_title`, `qi_is_public`, `qi_is_final`, `qi_parts`, `qi_gs_id`) VALUES
(1, 2, 0, 6, '1,2', '2018-03-18 00:00:00', 1, '2018-03-19 00:00:00', '0000-00-00 00:00:00', 'English', 0, 1, '', 0),
(2, 3, 0, 7, '', '2018-03-18 00:00:00', 1, '2018-03-20 00:00:00', '0000-00-00 00:00:00', 'Subject Verb Agreement', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_quiz_selection`
--

CREATE TABLE `esk_qm_quiz_selection` (
  `qs_id` int(11) NOT NULL,
  `qs_qq_id` int(11) NOT NULL,
  `qs_selection` varchar(55) NOT NULL,
  `ans_flag` int(11) NOT NULL,
  `qs_choice` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_quiz_selection`
--

INSERT INTO `esk_qm_quiz_selection` (`qs_id`, `qs_qq_id`, `qs_selection`, `ans_flag`, `qs_choice`) VALUES
(5, 1, 'a', 0, 'King Kong'),
(6, 1, 'b', 0, 'Lion'),
(7, 1, 'c', 0, 'Tiger'),
(8, 1, 'b', 1, ''),
(9, 2, 'a', 0, 'Legolas'),
(10, 2, 'b', 0, 'Baromir'),
(11, 2, 'c', 0, 'None of the above'),
(12, 2, 'c', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_type`
--

CREATE TABLE `esk_qm_type` (
  `qm_type_id` int(11) NOT NULL,
  `qm_type` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_type`
--

INSERT INTO `esk_qm_type` (`qm_type_id`, `qm_type`) VALUES
(1, 'Identification'),
(2, 'Multiple Choice');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_qm_cat`
--
ALTER TABLE `esk_qm_cat`
  ADD PRIMARY KEY (`qc_id`);

--
-- Indexes for table `esk_qm_cat_items`
--
ALTER TABLE `esk_qm_cat_items`
  ADD PRIMARY KEY (`qci_id`);

--
-- Indexes for table `esk_qm_qq`
--
ALTER TABLE `esk_qm_qq`
  ADD PRIMARY KEY (`qq_id`);

--
-- Indexes for table `esk_qm_quiz_items`
--
ALTER TABLE `esk_qm_quiz_items`
  ADD PRIMARY KEY (`qi_id`);

--
-- Indexes for table `esk_qm_quiz_selection`
--
ALTER TABLE `esk_qm_quiz_selection`
  ADD PRIMARY KEY (`qs_id`);

--
-- Indexes for table `esk_qm_type`
--
ALTER TABLE `esk_qm_type`
  ADD PRIMARY KEY (`qm_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_qm_cat`
--
ALTER TABLE `esk_qm_cat`
  MODIFY `qc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_qm_cat_items`
--
ALTER TABLE `esk_qm_cat_items`
  MODIFY `qci_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `esk_qm_qq`
--
ALTER TABLE `esk_qm_qq`
  MODIFY `qq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `esk_qm_quiz_items`
--
ALTER TABLE `esk_qm_quiz_items`
  MODIFY `qi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `esk_qm_quiz_selection`
--
ALTER TABLE `esk_qm_quiz_selection`
  MODIFY `qs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `esk_qm_type`
--
ALTER TABLE `esk_qm_type`
  MODIFY `qm_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
