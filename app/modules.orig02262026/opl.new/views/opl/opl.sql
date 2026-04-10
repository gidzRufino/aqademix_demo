CREATE TABLE `esk_opl_comments` (
  `com_id` int(11) NOT NULL,
  `com_type` tinyint(1) NOT NULL COMMENT '1=post; 2=task; 3=discussion; 4=student response to task',
  `com_details` varchar(3000) NOT NULL,
  `com_from` varchar(35) NOT NULL,
  `com_to` varchar(35) NOT NULL,
  `com_isReply` tinyint(1) NOT NULL,
  `com_replyto_id` int(11) NOT NULL,
  `com_sys_code` int(6) NOT NULL,
  `com_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `com_isStudent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='For Comments';

-- --------------------------------------------------------

--
-- Table structure for table `esk_opl_posts`
--

CREATE TABLE `esk_opl_posts` (
  `op_id` int(11) NOT NULL,
  `op_owner_id` varchar(35) NOT NULL,
  `op_post` longtext NOT NULL,
  `op_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `op_likes` text NOT NULL,
  `op_is_public` tinyint(1) NOT NULL,
  `op_to_class` smallint(4) NOT NULL COMMENT 'class_id',
  `op_subject_id` tinyint(4) NOT NULL,
  `op_unit_code` varchar(35) NOT NULL,
  `op_to_department` smallint(4) NOT NULL COMMENT 'department_id',
  `op_is_link` tinyint(1) NOT NULL,
  `op_task_title` varchar(55) DEFAULT NULL,
  `op_task_start` datetime NOT NULL,
  `op_task_deadline` datetime NOT NULL
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
  `task_total_score` int(11) NOT NULL
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
  `ts_date_submitted` datetime NOT NULL,
  `ts_score` decimal(3,2) NOT NULL,
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
-- Indexes for table `esk_opl_posts`
--
ALTER TABLE `esk_opl_posts`
  ADD PRIMARY KEY (`op_id`);

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
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `esk_opl_posts`
--
ALTER TABLE `esk_opl_posts`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT;

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
