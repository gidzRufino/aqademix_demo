CREATE TABLE `esk_gs_num_of_sdays_per_year` (
  `numDays_id` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `dept_id` tinyint(1) NOT NULL,
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
  `April` int(11) NOT NULL,
  `May` int(11) NOT NULL,
  `spr_school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_num_of_sdays_per_year`
--
ALTER TABLE `esk_gs_num_of_sdays_per_year`
  ADD PRIMARY KEY (`numDays_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_num_of_sdays_per_year`
--
ALTER TABLE `esk_gs_num_of_sdays_per_year`
  MODIFY `numDays_id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr_school` (
  `sch_id` int(11) NOT NULL,
  `school_name` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_school`
--
ALTER TABLE `esk_gs_spr_school`
  ADD PRIMARY KEY (`sch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_school`
--
ALTER TABLE `esk_gs_spr_school`
  MODIFY `sch_id` int(11) NOT NULL AUTO_INCREMENT;



CREATE TABLE `esk_gs_previous_record` (
  `rowid` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `name_of_school` varchar(255) NOT NULL,
  `gen_ave` float NOT NULL,
  `school_year` int(11) NOT NULL,
  `total_years` int(11) NOT NULL,
  `curriculum` varchar(55) NOT NULL,
  `history_type` tinyint(1) NOT NULL COMMENT '1 = pre school; 2 - elementary; 3 - junior high'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table for form 137';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_previous_record`
--
ALTER TABLE `esk_gs_previous_record`
  ADD PRIMARY KEY (`rowid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_previous_record`
--
ALTER TABLE `esk_gs_previous_record`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `esk_gs_spr` (
  `spr_id` int(11) NOT NULL,
  `spr_adviser` varchar(100) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `strandid` tinyint(1) NOT NULL,
  `school_name` varchar(55) NOT NULL,
  `school_year` int(11) NOT NULL,
  `go_to_next_level` int(11) NOT NULL COMMENT '1 = is admitted to the next level',
  `gen_ave` float NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `school_id` varchar(55) NOT NULL,
  `district` varchar(55) NOT NULL,
  `division` varchar(55) NOT NULL,
  `region` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_ar`
--
CREATE TABLE `esk_gs_spr_ar` (
  `ar_id` int(11) NOT NULL,
  `spr_id` int(11) NOT NULL,
  `subject_id` smallint(4) NOT NULL,
  `first` float NOT NULL,
  `second` float NOT NULL,
  `third` float NOT NULL,
  `fourth` float NOT NULL,
  `avg` decimal(5,2) NOT NULL,
  `sem` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--


-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_attendance`
--

CREATE TABLE `esk_gs_spr_attendance` (
  `spr_att` int(11) NOT NULL,
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
  `April` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_attendance_tardy`
--

CREATE TABLE `esk_gs_spr_attendance_tardy` (
  `spr_tardy_id` int(11) NOT NULL,
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
  `April` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_profile`
--

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
  `sprp_father_occ` varchar(55) NOT NULL,
  `sprp_mother` varchar(255) NOT NULL,
  `sprp_mother_occ` varchar(55) NOT NULL,
  `sprp_bdate` date NOT NULL,
  `sprp_bplace` varchar(500) NOT NULL,
  `sprp_nationality` varchar(55) NOT NULL,
  `sprp_add_id` int(11) NOT NULL,
  `sprp_rel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Permanent Record for non existing account';

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_sit`
--

CREATE TABLE `esk_gs_spr_sit` (
  `id` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `name_of_test` varchar(255) NOT NULL,
  `date_taken` varchar(55) NOT NULL,
  `score` float NOT NULL,
  `percentile_rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Standard Intelligent Test';


CREATE TABLE `esk_gs_spr_profile_address_info` (
  `address_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr_profile_address_info`
--
ALTER TABLE `esk_gs_spr_profile_address_info`
  ADD PRIMARY KEY (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr_profile_address_info`
--
ALTER TABLE `esk_gs_spr_profile_address_info`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_gs_spr`
--
ALTER TABLE `esk_gs_spr`
  ADD PRIMARY KEY (`spr_id`);

--
-- Indexes for table `esk_gs_spr_ar`
--
ALTER TABLE `esk_gs_spr_ar`
  ADD PRIMARY KEY (`ar_id`);

--
-- Indexes for table `esk_gs_spr_attendance`
--
ALTER TABLE `esk_gs_spr_attendance`
  ADD PRIMARY KEY (`spr_att`);

--
-- Indexes for table `esk_gs_spr_attendance_tardy`
--
ALTER TABLE `esk_gs_spr_attendance_tardy`
  ADD PRIMARY KEY (`spr_tardy_id`);

--
-- Indexes for table `esk_gs_spr_profile`
--
ALTER TABLE `esk_gs_spr_profile`
  ADD PRIMARY KEY (`sprp_id`);

--
-- Indexes for table `esk_gs_spr_sit`
--
ALTER TABLE `esk_gs_spr_sit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_gs_spr`
--
ALTER TABLE `esk_gs_spr`
  MODIFY `spr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_gs_spr_ar`
--
ALTER TABLE `esk_gs_spr_ar`
  MODIFY `ar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_gs_spr_attendance`
--
ALTER TABLE `esk_gs_spr_attendance`
  MODIFY `spr_att` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_gs_spr_attendance_tardy`
--
ALTER TABLE `esk_gs_spr_attendance_tardy`
  MODIFY `spr_tardy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_gs_spr_profile`
--
ALTER TABLE `esk_gs_spr_profile`
  MODIFY `sprp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_gs_spr_sit`
--
ALTER TABLE `esk_gs_spr_sit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

