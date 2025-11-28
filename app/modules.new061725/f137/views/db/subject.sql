CREATE TABLE `esk_subjects` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `short_code` varchar(55) NOT NULL,
  `parent_subject` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `is_core` int(11) NOT NULL COMMENT 'used for senior high only',
  `esk_subjects_code` int(11) NOT NULL COMMENT 'new auto_inc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_subjects`
--
ALTER TABLE `esk_subjects`
  ADD PRIMARY KEY (`esk_subjects_code`),
  ADD UNIQUE KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_subjects`
--
ALTER TABLE `esk_subjects`
  MODIFY `esk_subjects_code` int(11) NOT NULL AUTO_INCREMENT COMMENT 'new auto_inc';
