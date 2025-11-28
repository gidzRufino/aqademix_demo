CREATE TABLE `esk_gs_spr` (
  `spr_id` int(11) NOT NULL,
  `spr_adviser` varchar(100) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `strandid` tinyint(1) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  `school_year` int(11) NOT NULL,
  `go_to_next_level` int(11) NOT NULL COMMENT '1 = is admitted to the next level',
  `gen_ave` float NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `school_id` varchar(55) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `esk_gs_spr_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr`
--
ALTER TABLE `esk_gs_spr`
  ADD PRIMARY KEY (`esk_gs_spr_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr`
--
ALTER TABLE `esk_gs_spr`
  MODIFY `esk_gs_spr_code` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_ar` (
  `ar_id` varchar(55) NOT NULL,
  `spr_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `first` char(35) NOT NULL,
  `second` char(35) NOT NULL,
  `third` char(35) NOT NULL,
  `fourth` char(35) NOT NULL,
  `avg` char(35) NOT NULL,
  `sem` tinyint(1) NOT NULL,
  `esk_gs_spr_ar_code` int(11) NOT NULL COMMENT 'new auto_inc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_ar`
--
ALTER TABLE `esk_gs_spr_ar`
  ADD PRIMARY KEY (`esk_gs_spr_ar_code`),
  ADD UNIQUE KEY `ar_id` (`ar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_ar`
--
ALTER TABLE `esk_gs_spr_ar`
  MODIFY `esk_gs_spr_ar_code` int(11) NOT NULL AUTO_INCREMENT COMMENT 'new auto_inc';


CREATE TABLE `esk_gs_spr_attendance` (
  `spr_att` varchar(55) NOT NULL,
  `spr_id` int(11) NOT NULL,
  `June` tinyint(4) NOT NULL,
  `July` tinyint(4) NOT NULL,
  `August` tinyint(4) NOT NULL,
  `September` tinyint(4) NOT NULL,
  `October` tinyint(4) NOT NULL,
  `November` tinyint(4) NOT NULL,
  `December` tinyint(4) NOT NULL,
  `January` tinyint(4) NOT NULL,
  `February` tinyint(4) NOT NULL,
  `March` tinyint(4) NOT NULL,
  `April` tinyint(4) NOT NULL,
  `May` tinyint(3) NOT NULL,
  `is_school` tinyint(1) NOT NULL,
  `esk_gs_spr_attendance_code` int(11) NOT NULL COMMENT 'new auto_inc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_attendance`
--
ALTER TABLE `esk_gs_spr_attendance`
  ADD PRIMARY KEY (`esk_gs_spr_attendance_code`),
  ADD UNIQUE KEY `spr_att` (`spr_att`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_attendance`
--
ALTER TABLE `esk_gs_spr_attendance`
  MODIFY `esk_gs_spr_attendance_code` int(11) NOT NULL AUTO_INCREMENT COMMENT 'new auto_inc';


CREATE TABLE `esk_gs_spr_attendance_tardy` (
  `spr_tardy_id` varchar(55) NOT NULL,
  `spr_id` int(11) NOT NULL,
  `June` tinyint(4) NOT NULL,
  `July` tinyint(4) NOT NULL,
  `August` tinyint(4) NOT NULL,
  `September` tinyint(4) NOT NULL,
  `October` tinyint(4) NOT NULL,
  `November` tinyint(4) NOT NULL,
  `December` tinyint(4) NOT NULL,
  `January` tinyint(4) NOT NULL,
  `February` tinyint(4) NOT NULL,
  `March` tinyint(4) NOT NULL,
  `April` tinyint(4) NOT NULL,
  `esk_gs_spr_attendance_tardy_code` int(11) NOT NULL COMMENT 'new auto_inc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_attendance_tardy`
--
ALTER TABLE `esk_gs_spr_attendance_tardy`
  ADD PRIMARY KEY (`esk_gs_spr_attendance_tardy_code`),
  ADD UNIQUE KEY `spr_tardy_id` (`spr_tardy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_attendance_tardy`
--
ALTER TABLE `esk_gs_spr_attendance_tardy`
  MODIFY `esk_gs_spr_attendance_tardy_code` int(11) NOT NULL AUTO_INCREMENT COMMENT 'new auto_inc';


CREATE TABLE `esk_gs_spr_gen_rec` (
  `gr_id` int(11) NOT NULL,
  `stid` varchar(300) NOT NULL,
  `elem_ave` char(55) NOT NULL,
  `jhs_ave` char(55) NOT NULL,
  `shs_ave` char(55) NOT NULL,
  `elem_add_id` int(11) NOT NULL,
  `jhs_add_id` int(11) NOT NULL,
  `shs_add_id` int(11) NOT NULL,
  `elem_sy` int(11) NOT NULL,
  `jhs_sy` int(11) NOT NULL,
  `shs_sy` int(11) NOT NULL,
  `elem_released_date` date NOT NULL,
  `jhs_released_date` date NOT NULL,
  `shs_released_date` date NOT NULL,
  `esk_gs_spr_gen_rec_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_gen_rec`
--
ALTER TABLE `esk_gs_spr_gen_rec`
  ADD PRIMARY KEY (`esk_gs_spr_gen_rec_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_gen_rec`
--
ALTER TABLE `esk_gs_spr_gen_rec`
  MODIFY `esk_gs_spr_gen_rec_code` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_profile` (
  `sprp_id` int(11) NOT NULL,
  `sprp_st_id` varchar(55) NOT NULL,
  `sprp_lrn` varchar(55) DEFAULT NULL,
  `sprp_lastname` varchar(55) NOT NULL,
  `sprp_firstname` varchar(55) NOT NULL,
  `sprp_middlename` varchar(55) DEFAULT NULL,
  `sprp_extname` varchar(55) NOT NULL,
  `sprp_gender` varchar(55) NOT NULL,
  `sprp_father` varchar(255) NOT NULL,
  `sprp_father_occ` varchar(55) DEFAULT NULL,
  `sprp_mother` varchar(255) NOT NULL,
  `sprp_mother_occ` varchar(55) NOT NULL,
  `sprp_bdate` date NOT NULL,
  `sprp_bplace` varchar(500) NOT NULL,
  `sprp_f_nationality` varchar(55) NOT NULL,
  `sprp_m_nationality` varchar(55) NOT NULL,
  `sprp_add_id` int(11) NOT NULL,
  `sprp_rel_id` varchar(55) NOT NULL,
  `esk_gs_spr_profile_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Permanent Record for non existing account';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_profile`
--
ALTER TABLE `esk_gs_spr_profile`
  ADD PRIMARY KEY (`esk_gs_spr_profile_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_profile`
--
ALTER TABLE `esk_gs_spr_profile`
  MODIFY `esk_gs_spr_profile_code` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_profile_address_info` (
  `address_id` int(11) NOT NULL,
  `sprp_profile_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay_id` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` int(11) NOT NULL,
  `is_home` int(11) NOT NULL,
  `esk_gs_spr_profile_address_info_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_profile_address_info`
--
ALTER TABLE `esk_gs_spr_profile_address_info`
  ADD PRIMARY KEY (`esk_gs_spr_profile_address_info_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_profile_address_info`
--
ALTER TABLE `esk_gs_spr_profile_address_info`
  MODIFY `esk_gs_spr_profile_address_info_code` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_school` (
  `spr_school_id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `school_add_id` int(11) NOT NULL,
  `division` varchar(55) NOT NULL,
  `district` varchar(55) NOT NULL,
  `region` varchar(55) NOT NULL,
  `esk_gs_spr_school_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_school`
--
ALTER TABLE `esk_gs_spr_school`
  ADD PRIMARY KEY (`esk_gs_spr_school_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_school`
--
ALTER TABLE `esk_gs_spr_school`
  MODIFY `esk_gs_spr_school_code` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_school_days` (
  `scDays_id` int(11) NOT NULL,
  `spr_school_id` int(11) NOT NULL,
  `June` tinyint(4) NOT NULL,
  `July` tinyint(4) NOT NULL,
  `August` tinyint(4) NOT NULL,
  `September` tinyint(4) NOT NULL,
  `October` tinyint(4) NOT NULL,
  `November` tinyint(4) NOT NULL,
  `December` tinyint(4) NOT NULL,
  `January` tinyint(4) NOT NULL,
  `February` tinyint(4) NOT NULL,
  `March` tinyint(4) NOT NULL,
  `school_year` int(11) NOT NULL,
  `esk_gs_spr_school_days_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_school_days`
--
ALTER TABLE `esk_gs_spr_school_days`
  ADD PRIMARY KEY (`esk_gs_spr_school_days_code`),
  ADD UNIQUE KEY `school_year` (`scDays_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_school_days`
--
ALTER TABLE `esk_gs_spr_school_days`
  MODIFY `esk_gs_spr_school_days_code` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_sit` (
  `id` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `name_of_test` varchar(255) NOT NULL,
  `date_taken` varchar(55) NOT NULL,
  `score` float NOT NULL,
  `percentile_rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Standard Intelligent Test';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_sit`
--
ALTER TABLE `esk_gs_spr_sit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_sit`
--
ALTER TABLE `esk_gs_spr_sit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



CREATE TABLE `esk_gs_spr_eligibility` (
  `elig_id` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `credential_presented` varchar(11) NOT NULL COMMENT 'for elementary: 1-Kinder progress report; 2-ECCD checklist; 3-Kindergarten cert of completion',
  `school_id` int(11) NOT NULL,
  `pept_passer` tinyint(4) NOT NULL COMMENT '0 - No; 1 - Yes',
  `pept_rating` int(11) NOT NULL,
  `date` date NOT NULL,
  `testing_center` varchar(255) NOT NULL,
  `remarks` varchar(500) NOT NULL COMMENT 'for elementary only',
  `elem_completer` tinyint(4) NOT NULL COMMENT 'for jhs; 0 - No, 1 - Yes',
  `gen_ave` int(11) NOT NULL COMMENT 'for jhs and shs',
  `citation` int(11) NOT NULL COMMENT 'for jhs',
  `als_passer` tinyint(4) NOT NULL COMMENT 'for jhs and shs; 0 - No, 1 - Yes',
  `als_rating` int(11) NOT NULL COMMENT 'for jhs and shs',
  `high_school_completer` tinyint(4) NOT NULL COMMENT 'for shs; 0 - No, 1 - Yes',
  `jhs_completer` tinyint(4) NOT NULL COMMENT 'for shs; 0 - No, 1 - Yes',
  `jhs_gen_ave` int(11) NOT NULL COMMENT 'for shs',
  `date_shs_admission` date NOT NULL COMMENT 'for shs',
  `esk_gs_spr_eligibility_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_eligibility`
--
ALTER TABLE `esk_gs_spr_eligibility`
  ADD PRIMARY KEY (`esk_gs_spr_eligibility_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_eligibility`
--
ALTER TABLE `esk_gs_spr_eligibility`
  MODIFY `esk_gs_spr_eligibility_code` int(11) NOT NULL AUTO_INCREMENT;