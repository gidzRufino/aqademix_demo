-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2018 at 04:12 PM
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
-- Table structure for table `esk_qm_access_level`
--

CREATE TABLE `esk_qm_access_level` (
  `qm_access_id` int(11) NOT NULL,
  `qm_access_level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_access_level`
--

INSERT INTO `esk_qm_access_level` (`qm_access_id`, `qm_access_level`) VALUES
(1, 'Admin'),
(2, 'Evaluator'),
(3, 'Contributor'),
(4, 'Tester');

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
(1, 'English'),
(2, 'Science'),
(3, 'Physics'),
(4, 'Grade 8'),
(5, 'Knowledge'),
(6, 'Forces'),
(7, 'Resultant forces'),
(8, 'Objects in motion');

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_cat_items`
--

CREATE TABLE `esk_qm_cat_items` (
  `qci_id` int(11) NOT NULL,
  `qci_qq_id` int(11) NOT NULL,
  `qci_qc_tags` varchar(300) NOT NULL,
  `qci_sub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_cat_items`
--

INSERT INTO `esk_qm_cat_items` (`qci_id`, `qci_qq_id`, `qci_qc_tags`, `qci_sub_id`) VALUES
(1, 1, 'English,Science', 0),
(2, 2, 'Science', 0),
(3, 3, 'Physics,Grade 8,Knowledge', 0),
(4, 5, 'Physics,forces,resultant forces,objects in motion', 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_qq`
--

CREATE TABLE `esk_qm_qq` (
  `qq_id` int(11) NOT NULL,
  `question` longtext NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `qq_qt_id` int(11) NOT NULL,
  `created_by` varchar(55) NOT NULL,
  `qq_difficult_level` int(11) NOT NULL,
  `qq_skills` varchar(100) DEFAULT NULL,
  `is_standard_test` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_qq`
--

INSERT INTO `esk_qm_qq` (`qq_id`, `question`, `grade_level_id`, `qq_qt_id`, `created_by`, `qq_difficult_level`, `qq_skills`, `is_standard_test`) VALUES
(1, 'Who is the King of the Jungle?', 0, 2, '0310062', 0, 'Writing Skill,Critical Thinking Skill', 0),
(2, 'Who is the Creator of the Universe', 0, 1, '0310062', 0, 'Creative Thinking Skill', 0),
(3, 'What is the unit of measure for electrical resistance?', 0, 1, '0310062', 0, NULL, 0),
(5, '<p>An object is moving at constant velocity heading due south when suddenly it changed direction to southwest.&nbsp; Explain whant happened to the object.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [3 pts]</p>\n<p>&nbsp;</p>\n<p>Marking Criteria:</p>\n<p>A. An answer that contains "a force is acting on it with a direction to the west or southwest" --------------------- 3 points</p>\n<p>B. An answer that contains "the object is acted upon by a force" ----------------- 2 pts</p>\n<p>C. Other answers ------------------------------------------------------------------ 0 </p>', 0, 3, '0310062', 0, NULL, 0),
(6, '<p>Bob&nbsp; wants to light 2 small light bulbs with a resistance ratings of 3 Ohms and 8 Ohms connected in serries connection using 4 1.5-volt batteries. Determine the following:</p>\n<p>a. Total current of the system</p>\n<p>b. Voltage drops of each light bulb</p>', 0, 4, '0310062', 0, NULL, 0);

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
(13, 1, 'a', 0, 'Lion'),
(14, 1, 'b', 0, 'Tiger'),
(15, 1, 'c', 0, 'King Kong'),
(16, 1, 'a', 1, ''),
(17, 2, 'God', 1, ''),
(18, 3, 'ohms', 1, ''),
(19, 4, '', 1, ''),
(20, 5, '', 1, ''),
(21, 6, 'a. 0.55 Amperes     b. Light Bulb 1(3 Ohm)  - 1.65 Volt', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_skills`
--

CREATE TABLE `esk_qm_skills` (
  `qm_skills_id` int(11) NOT NULL,
  `qm_skills` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_skills`
--

INSERT INTO `esk_qm_skills` (`qm_skills_id`, `qm_skills`) VALUES
(1, 'Writing Skill'),
(2, 'Critical Thinking Skill'),
(3, 'Creative Thinking Skill'),
(4, 'Technology Skill');

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
(2, 'Multiple Choice'),
(3, 'Divergent or open-ended questions'),
(4, 'Word problems');

-- --------------------------------------------------------

--
-- Table structure for table `esk_qm_user_access`
--

CREATE TABLE `esk_qm_user_access` (
  `qm_ua_id` int(11) NOT NULL,
  `qm_ua_user_id` varchar(55) NOT NULL,
  `qm_ua_access_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_qm_user_access`
--

INSERT INTO `esk_qm_user_access` (`qm_ua_id`, `qm_ua_user_id`, `qm_ua_access_id`) VALUES
(3, '0310062', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_qm_access_level`
--
ALTER TABLE `esk_qm_access_level`
  ADD PRIMARY KEY (`qm_access_id`);

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
-- Indexes for table `esk_qm_skills`
--
ALTER TABLE `esk_qm_skills`
  ADD PRIMARY KEY (`qm_skills_id`);

--
-- Indexes for table `esk_qm_type`
--
ALTER TABLE `esk_qm_type`
  ADD PRIMARY KEY (`qm_type_id`);

--
-- Indexes for table `esk_qm_user_access`
--
ALTER TABLE `esk_qm_user_access`
  ADD PRIMARY KEY (`qm_ua_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_qm_access_level`
--
ALTER TABLE `esk_qm_access_level`
  MODIFY `qm_access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `esk_qm_cat`
--
ALTER TABLE `esk_qm_cat`
  MODIFY `qc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `esk_qm_cat_items`
--
ALTER TABLE `esk_qm_cat_items`
  MODIFY `qci_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `esk_qm_qq`
--
ALTER TABLE `esk_qm_qq`
  MODIFY `qq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `esk_qm_quiz_items`
--
ALTER TABLE `esk_qm_quiz_items`
  MODIFY `qi_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_qm_quiz_selection`
--
ALTER TABLE `esk_qm_quiz_selection`
  MODIFY `qs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `esk_qm_skills`
--
ALTER TABLE `esk_qm_skills`
  MODIFY `qm_skills_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `esk_qm_type`
--
ALTER TABLE `esk_qm_type`
  MODIFY `qm_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `esk_qm_user_access`
--
ALTER TABLE `esk_qm_user_access`
  MODIFY `qm_ua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
