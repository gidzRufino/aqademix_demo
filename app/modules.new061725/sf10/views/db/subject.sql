CREATE TABLE `esk_subjects` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `short_code` varchar(55) NOT NULL,
  `parent_subject` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `is_core` int(11) NOT NULL COMMENT 'used for senior high only'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_subjects`
--
ALTER TABLE `esk_subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_subjects`
--
ALTER TABLE `esk_subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;
