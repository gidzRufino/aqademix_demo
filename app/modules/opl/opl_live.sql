-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2020 at 08:21 AM
-- Server version: 10.3.22-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eskwelap_pilgrim_2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_comments`
--

CREATE TABLE `esk_opl_comments` (
  `com_id` int(11) NOT NULL,
  `com_type` tinyint(1) NOT NULL COMMENT '1=post; 2=task; 3=discussion; 4=student response to task',
  `com_details` varchar(3000) NOT NULL,
  `com_from` varchar(35) NOT NULL,
  `com_to` varchar(35) NOT NULL,
  `com_isReply` tinyint(1) NOT NULL,
  `com_replyto_id` int(11) NOT NULL,
  `com_sys_code` int(6) NOT NULL,
  `com_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `com_isStudent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='For Comments';

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_discussion`
--

CREATE TABLE `esk_opl_discussion` (
  `dis_id` int(11) NOT NULL,
  `dis_title` char(100) NOT NULL,
  `dis_details` mediumtext NOT NULL,
  `dis_unit_id` int(11) NOT NULL,
  `dis_subject_id` int(11) NOT NULL,
  `dis_grade_id` tinyint(3) NOT NULL,
  `dis_section_id` tinyint(3) NOT NULL,
  `dis_start_date` datetime NOT NULL,
  `dis_author_id` varchar(35) NOT NULL,
  `dis_sys_code` int(6) NOT NULL,
  `dis_read_by` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='For Lesson Discussion';

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_posts`
--

CREATE TABLE `esk_opl_posts` (
  `op_id` int(11) NOT NULL,
  `op_owner_id` varchar(35) NOT NULL,
  `op_post` longtext NOT NULL,
  `op_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `op_likes` text NOT NULL,
  `op_is_public` tinyint(1) NOT NULL,
  `op_to_class` smallint(4) NOT NULL COMMENT 'class_id',
  `op_to_department` smallint(4) NOT NULL COMMENT 'department_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_qm_qq`
--

CREATE TABLE `esk_opl_qm_qq` (
  `qq_id` int(11) NOT NULL,
  `question` longtext NOT NULL,
  `plain_question` mediumtext NOT NULL,
  `qq_answer` char(255) NOT NULL,
  `qq_qt_id` int(11) NOT NULL,
  `created_by` varchar(55) NOT NULL,
  `qq_difficult_level` int(11) NOT NULL,
  `qq_skills` varchar(100) DEFAULT NULL,
  `is_standard_test` int(11) NOT NULL,
  `sys_code` int(6) NOT NULL,
  `qq_marking_type` tinyint(1) NOT NULL,
  `qq_links` mediumint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_qm_quiz_items`
--

CREATE TABLE `esk_opl_qm_quiz_items` (
  `qi_id` int(11) NOT NULL,
  `qi_grade_level_id` int(11) NOT NULL,
  `qi_section_id` int(11) NOT NULL,
  `qi_qq_ids` varchar(1000) NOT NULL,
  `qi_date_created` datetime NOT NULL,
  `qi_created_by` char(35) NOT NULL,
  `qi_date_activation` datetime NOT NULL,
  `qi_date_expired` datetime NOT NULL,
  `qi_title` varchar(300) NOT NULL,
  `qi_is_public` int(11) NOT NULL COMMENT '0=exclusive; 1=public',
  `qi_is_final` int(11) NOT NULL COMMENT '1=final',
  `qi_subject_id` int(11) NOT NULL,
  `qi_sys_code` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_qm_type`
--

CREATE TABLE `esk_opl_qm_type` (
  `qm_type_id` int(11) NOT NULL,
  `qm_type` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_opl_qm_type`
--

INSERT INTO `esk_opl_qm_type` (`qm_type_id`, `qm_type`) VALUES
(1, 'Identification'),
(2, 'True or False'),
(3, 'Multiple Choice');

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_resourcelist`
--

CREATE TABLE `esk_opl_resourcelist` (
  `resource_id` varchar(55) NOT NULL,
  `resource_title` varchar(255) NOT NULL,
  `resource_details` longtext NOT NULL,
  `s_id` varchar(55) NOT NULL,
  `topic` varchar(500) NOT NULL,
  `grade_id` varchar(55) NOT NULL,
  `tags` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_rubric_criteria`
--

CREATE TABLE `esk_opl_rubric_criteria` (
  `rcid` int(11) NOT NULL,
  `rc_ruid` int(11) NOT NULL,
  `rc_criteria` varchar(100) NOT NULL COMMENT 'alias/name of the criteria',
  `rc_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_rubric_description`
--

CREATE TABLE `esk_opl_rubric_description` (
  `rdid` int(11) NOT NULL,
  `rd_rcid` int(11) NOT NULL COMMENT 'ref to rubric criteria',
  `rd_scale` int(11) NOT NULL COMMENT 'what part of the scale',
  `rd_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_rubric_info`
--

CREATE TABLE `esk_opl_rubric_info` (
  `ruid` int(11) NOT NULL,
  `ru_alias` varchar(50) NOT NULL,
  `ru_access` tinyint(4) NOT NULL COMMENT 'private or public or whatever',
  `ru_type` tinyint(4) NOT NULL COMMENT 'pt or itt',
  `ru_auth_id` varchar(50) NOT NULL COMMENT 'userid or auth id',
  `ru_remarks` text NOT NULL,
  `ri_scale` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_rubric_student`
--

CREATE TABLE `esk_opl_rubric_student` (
  `srid` int(11) NOT NULL,
  `sr_stid` varchar(50) NOT NULL COMMENT 'student id',
  `sr_ref_id` varchar(50) NOT NULL COMMENT 'referrence ID to task or questions',
  `sr_rdid` int(11) NOT NULL COMMENT 'ref to rubric_description',
  `sr_point` decimal(10,2) NOT NULL COMMENT 'point given',
  `sr_comment` text NOT NULL COMMENT 'comment on the student performance',
  `is_question` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_tasks`
--

CREATE TABLE `esk_opl_tasks` (
  `task_code` int(6) NOT NULL COMMENT 'system generated code',
  `task_type` tinyint(2) NOT NULL,
  `task_submission_type` tinyint(1) NOT NULL COMMENT '1 = file; 2 = Use Editor; 3 = Online Form',
  `task_subject_id` tinyint(4) NOT NULL,
  `task_grade_id` tinyint(2) NOT NULL,
  `task_section_id` tinyint(4) NOT NULL,
  `task_details` longtext NOT NULL,
  `task_title` varchar(500) NOT NULL,
  `task_lesson_id` mediumint(9) NOT NULL,
  `task_start_time` datetime NOT NULL,
  `task_end_time` datetime NOT NULL,
  `task_is_online` tinyint(1) NOT NULL,
  `task_online_link` mediumint(9) NOT NULL,
  `task_author_id` varchar(35) NOT NULL,
  `task_auto_id` int(11) NOT NULL,
  `task_target_audience` tinyint(1) NOT NULL COMMENT '0 = class, 1 = grade level, 2= all students, 3=Allow sharing',
  `task_total_score` int(11) NOT NULL,
  `task_attachments` varchar(1000) DEFAULT NULL,
  `marking_type` tinyint(1) NOT NULL,
  `marking_link` mediumint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tasks and quizzes';

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_task_submitted`
--

CREATE TABLE `esk_opl_task_submitted` (
  `ts_code` int(6) NOT NULL COMMENT 'system generated code',
  `ts_task_id` mediumint(9) NOT NULL,
  `ts_submitted_by` varchar(35) NOT NULL,
  `ts_details` longtext NOT NULL COMMENT 'if submission is not attachement',
  `ts_submission_type` tinyint(1) NOT NULL,
  `ts_file_name` char(35) DEFAULT NULL,
  `ts_date_submitted` datetime NOT NULL,
  `ts_score` decimal(3,2) NOT NULL,
  `ts_comment` varchar(1000) DEFAULT NULL,
  `ts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_task_type`
--

CREATE TABLE `esk_opl_task_type` (
  `tt_id` int(11) NOT NULL,
  `tt_type` char(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_opl_task_type`
--

INSERT INTO `esk_opl_task_type` (`tt_id`, `tt_type`) VALUES
(1, 'Quiz'),
(2, 'Assignment'),
(3, 'Exercises'),
(4, 'Major Exam');

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_units`
--

CREATE TABLE `esk_opl_units` (
  `ou_id` int(11) NOT NULL,
  `ou_unit_title` varchar(1000) NOT NULL,
  `ou_unit_objectives` longtext NOT NULL,
  `ou_unit_overview` longtext NOT NULL,
  `ou_subject_id` int(11) NOT NULL,
  `ou_grade_level_id` tinyint(4) NOT NULL,
  `ou_tag` varchar(1000) NOT NULL,
  `ou_opl_code` varchar(15) NOT NULL,
  `ou_owners_id` varchar(35) NOT NULL,
  `ou_is_public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_opl_comments`
--
ALTER TABLE `esk_opl_comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `esk_opl_discussion`
--
ALTER TABLE `esk_opl_discussion`
  ADD PRIMARY KEY (`dis_id`);

--
-- Indexes for table `esk_opl_posts`
--
ALTER TABLE `esk_opl_posts`
  ADD PRIMARY KEY (`op_id`);

--
-- Indexes for table `esk_opl_qm_qq`
--
ALTER TABLE `esk_opl_qm_qq`
  ADD PRIMARY KEY (`qq_id`);

--
-- Indexes for table `esk_opl_qm_quiz_items`
--
ALTER TABLE `esk_opl_qm_quiz_items`
  ADD PRIMARY KEY (`qi_id`);

--
-- Indexes for table `esk_opl_qm_type`
--
ALTER TABLE `esk_opl_qm_type`
  ADD PRIMARY KEY (`qm_type_id`);

--
-- Indexes for table `esk_opl_rubric_criteria`
--
ALTER TABLE `esk_opl_rubric_criteria`
  ADD PRIMARY KEY (`rcid`);

--
-- Indexes for table `esk_opl_rubric_description`
--
ALTER TABLE `esk_opl_rubric_description`
  ADD PRIMARY KEY (`rdid`);

--
-- Indexes for table `esk_opl_rubric_info`
--
ALTER TABLE `esk_opl_rubric_info`
  ADD PRIMARY KEY (`ruid`);

--
-- Indexes for table `esk_opl_rubric_student`
--
ALTER TABLE `esk_opl_rubric_student`
  ADD PRIMARY KEY (`srid`);

--
-- Indexes for table `esk_opl_tasks`
--
ALTER TABLE `esk_opl_tasks`
  ADD PRIMARY KEY (`task_auto_id`);

--
-- Indexes for table `esk_opl_task_submitted`
--
ALTER TABLE `esk_opl_task_submitted`
  ADD PRIMARY KEY (`ts_id`);

--
-- Indexes for table `esk_opl_task_type`
--
ALTER TABLE `esk_opl_task_type`
  ADD PRIMARY KEY (`tt_id`);

--
-- Indexes for table `esk_opl_units`
--
ALTER TABLE `esk_opl_units`
  ADD PRIMARY KEY (`ou_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_opl_comments`
--
ALTER TABLE `esk_opl_comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_discussion`
--
ALTER TABLE `esk_opl_discussion`
  MODIFY `dis_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_posts`
--
ALTER TABLE `esk_opl_posts`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_qm_qq`
--
ALTER TABLE `esk_opl_qm_qq`
  MODIFY `qq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_qm_quiz_items`
--
ALTER TABLE `esk_opl_qm_quiz_items`
  MODIFY `qi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_qm_type`
--
ALTER TABLE `esk_opl_qm_type`
  MODIFY `qm_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `esk_opl_rubric_criteria`
--
ALTER TABLE `esk_opl_rubric_criteria`
  MODIFY `rcid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_rubric_description`
--
ALTER TABLE `esk_opl_rubric_description`
  MODIFY `rdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_rubric_info`
--
ALTER TABLE `esk_opl_rubric_info`
  MODIFY `ruid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_tasks`
--
ALTER TABLE `esk_opl_tasks`
  MODIFY `task_auto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_task_submitted`
--
ALTER TABLE `esk_opl_task_submitted`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_opl_task_type`
--
ALTER TABLE `esk_opl_task_type`
  MODIFY `tt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `esk_opl_units`
--
ALTER TABLE `esk_opl_units`
  MODIFY `ou_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
