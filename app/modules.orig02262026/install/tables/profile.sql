--
-- Paste your SQL dump into this file
--

CREATE TABLE `esk_profile` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `rfid` varchar(55) NOT NULL,
  `lastname` varchar(55) DEFAULT NULL,
  `firstname` varchar(55) DEFAULT NULL,
  `middlename` varchar(55) DEFAULT NULL,
  `add_id` int(11) NOT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `rel_id` int(11) NOT NULL,
  `bdate_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `status` varchar(55) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `bplace_id` int(11) NOT NULL,
  `ethnic_group_id` int(11) NOT NULL,
  `occupation_id` int(11) NOT NULL,
  `educ_attain_id` int(11) NOT NULL,
  `avatar` varchar(55) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `add_id` (`add_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `esk_profile`
--

INSERT INTO `esk_profile` (`user_id`, `rfid`, `lastname`, `firstname`, `middlename`, `add_id`, `sex`, `rel_id`, `bdate_id`, `contact_id`, `status`, `nationality`, `account_type`, `parent_id`, `bplace_id`, `ethnic_group_id`, `occupation_id`, `educ_attain_id`, `avatar`) VALUES
(1, '', 'Rufino', 'Genesis', 'Yecyec', 1, '1', 1, 1, 0, NULL, 'Filipino', 1, 0, 0, 0, 0, 0, '');

--
-- Table structure for table `esk_profile_address_info`
--

CREATE TABLE `esk_profile_address_info` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` int(11) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `esk_profile_address_info`
--

INSERT INTO `esk_profile_address_info` (`address_id`, `street`, `barangay_id`, `city_id`, `province_id`, `country`, `zip_code`) VALUES
(1, 'Gumamella St.', 1, 998, 49, 'Philippines', 9000);

--
-- Table structure for table `esk_profile_contact_details`
--

CREATE TABLE `esk_profile_contact_details` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_phone` varchar(255) DEFAULT NULL,
  `cd_mobile` varchar(255) DEFAULT NULL,
  `cd_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT= 1;

--
-- Dumping data for table `esk_profile_contact_details`
--

INSERT INTO `esk_profile_contact_details` (`contact_id`, `cd_phone`, `cd_mobile`, `cd_email`) VALUES
(1, '0', NULL, '');

--
-- Table structure for table `esk_profile_educ_attain`
--

CREATE TABLE `esk_profile_educ_attain` (
  `ea_id` int(11) NOT NULL AUTO_INCREMENT,
  `attainment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ea_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `esk_profile_educ_attain`
--

INSERT INTO `esk_profile_educ_attain` (`ea_id`, `attainment`) VALUES
(1, 'Elementary Level'),
(2, 'Elementary Graduate'),
(3, 'High School Level'),
(4, 'High School Graduate'),
(5, 'College Level '),
(6, 'College Graduate');

--
-- Table structure for table `esk_profile_employee`
--

CREATE TABLE `esk_profile_employee` (
  `employee_id` varchar(55) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'link to profile user_id',
  `position_id` int(11) NOT NULL,
  `awards_cert` varchar(255) DEFAULT NULL,
  `sss` varchar(55) DEFAULT NULL,
  `phil_health` varchar(55) DEFAULT NULL,
  `pag_ibig` varchar(55) DEFAULT NULL,
  `tin` varchar(55) DEFAULT NULL,
  `prc_id` varchar(55) NOT NULL,
  `incase_name` varchar(55) DEFAULT NULL,
  `incase_contact` varchar(55) DEFAULT NULL,
  `incase_relation` varchar(255) DEFAULT NULL,
  `position_details` varchar(55) DEFAULT NULL,
  `work_details` varchar(55) DEFAULT NULL,
  `date_hired` varchar(11) NOT NULL,
  `em_status` varchar(55) NOT NULL,
  `pg_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_profile_employee`
--

INSERT INTO `esk_profile_employee` (`employee_id`, `user_id`, `position_id`, `awards_cert`, `sss`, `phil_health`, `pag_ibig`, `tin`, `prc_id`, `incase_name`, `incase_contact`, `incase_relation`, `position_details`, `work_details`, `date_hired`, `em_status`, `pg_id`) VALUES
('0310062', 1, 1, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', '', 0);

--
-- Table structure for table `esk_profile_employee_course`
--

CREATE TABLE `esk_profile_employee_course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course` varchar(300) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `esk_profile_employee_course`
--

INSERT INTO `esk_profile_employee_course` (`course_id`, `course`) VALUES
(1, 'Bachelor of Secondary Education');


-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_deductions`
--

CREATE TABLE `esk_profile_employee_deductions` (
  `salary_grade` int(11) NOT NULL,
  `SSS` float NOT NULL,
  `phil_health` float NOT NULL,
  `pag_ibig` float NOT NULL,
  `tin` float NOT NULL,
  PRIMARY KEY (`salary_grade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_profile_employee_deductions`
--

INSERT INTO `esk_profile_employee_deductions` (`salary_grade`, `SSS`, `phil_health`, `pag_ibig`, `tin`) VALUES
(1, 181.7, 100, 100, 0),
(2, 199.8, 100, 110, 0),
(3, 218, 100, 120, 0),
(4, 236.2, 100, 130, 0),
(5, 254.3, 100, 140, 0),
(6, 272.5, 100, 150, 0),
(7, 290.7, 100, 160, 0),
(8, 308.8, 100, 170, 0),
(9, 327, 112.5, 180, 0),
(10, 345.2, 112.5, 190, 0),
(11, 363.3, 125, 200, 0),
(12, 381.5, 125, 210, 0),
(13, 399.7, 137.5, 220, 0),
(14, 417.8, 137.5, 230, 0),
(15, 436, 150, 240, 0),
(16, 454.2, 150, 250, 0),
(17, 472.3, 162.5, 260, 0),
(18, 490.5, 162.5, 270, 0),
(19, 508.7, 175, 280, 0),
(20, 526.8, 175, 290, 0),
(21, 545, 187.5, 300, 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_edbak`
--

CREATE TABLE `esk_profile_employee_edbak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `c_school_id` int(11) DEFAULT NULL,
  `c_year_grad` varchar(55) DEFAULT NULL,
  `m_school_id` int(11) DEFAULT NULL,
  `m_year_grad` varchar(55) DEFAULT NULL,
  `major_id` int(11) NOT NULL,
  `minor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_edbak_school`
--

CREATE TABLE `esk_profile_employee_edbak_school` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(55) DEFAULT NULL,
  `school_add` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `esk_profile_employee_edbak_school`
--

INSERT INTO `esk_profile_employee_edbak_school` (`s_id`, `school_name`, `school_add`) VALUES
(1, 'Bukidnon State University', 'Malaybalay City, Bukidnon'),
(2, 'South Philippine Adventist College', 'Camachiles, Matanao Davao Del Sur'),
(3, 'SOUTH PHILIPPINE ADVENTIST COLLEGE', 'CAMANCHILES, MATANAO DAVAO DEL SUR'),
(4, 'Philippine Normal University-Manila', 'Taft Avenue, Manila'),
(5, 'South Philippine Adventist College', 'Camanchiles Matanao Davao del Sur'),
(6, 'University of Mindanao', 'Matina, Davao City'),
(7, 'SPAC', 'Km. 68, Camanchiles, Matanao, Davao Del Sur'),
(8, 'USEP', 'Bo. Obrero,Davao City'),
(9, 'Central Mindanao University', 'Musuan,Maramag,Bukidnon'),
(10, 'MOUNTAIN VIEW COLLEGE', 'VALENCIA, BUKIDNON');


CREATE TABLE `esk_profile_employee_time_settings` (
  `set_id` int(11) NOT NULL,
  `day_name` varchar(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_profile_employee_time_settings`
--

INSERT INTO `esk_profile_employee_time_settings` (`set_id`, `day_name`, `time_in`, `time_out`) VALUES
(1, 'Monday', '07:30:00', '05:00:00'),
(2, 'Tuesday', '07:30:00', '05:00:00'),
(3, 'Wednesday', '07:30:00', '05:00:00'),
(4, 'Thursday', '07:30:00', '05:00:00'),
(5, 'Friday', '07:30:00', '05:00:00'),
(6, 'Saturday', '07:30:00', '05:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_profile_employee_time_settings`
--
ALTER TABLE `esk_profile_employee_time_settings`
  ADD PRIMARY KEY (`set_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_profile_employee_time_settings`
--
ALTER TABLE `esk_profile_employee_time_settings`
  MODIFY `set_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_education`
--

CREATE TABLE `esk_profile_employee_education` (
  `eb_id` int(11) NOT NULL AUTO_INCREMENT,
  `eb_employee_id` varchar(55) NOT NULL,
  `eb_level_id` int(11) NOT NULL,
  `eb_school_id` int(11) NOT NULL,
  `eb_course_id` int(11) NOT NULL,
  `eb_year_grad` int(11) NOT NULL,
  `eb_highest_earn` varchar(55) CHARACTER SET latin1 NOT NULL,
  `eb_dates_from` int(11) NOT NULL,
  `eb_dates_to` int(11) NOT NULL,
  `eb_awards` varchar(300) CHARACTER SET latin1 NOT NULL,
  `eb_major_id` int(11) NOT NULL,
  `eb_minor_id` int(11) NOT NULL,
  PRIMARY KEY (`eb_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Employee''s Educational Background' AUTO_INCREMENT=1 ;


--
-- Table structure for table `esk_profile_employee_educ_level`
--

CREATE TABLE `esk_profile_employee_educ_level` (
  `el_id` int(11) NOT NULL AUTO_INCREMENT,
  `el_level` varchar(55) NOT NULL,
  PRIMARY KEY (`el_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_profile_employee_educ_level`
--

INSERT INTO `esk_profile_employee_educ_level` (`el_id`, `el_level`) VALUES
(1, 'Elementary'),
(2, 'Secondary'),
(3, 'Vocational / Trade Course'),
(4, 'College'),
(5, 'Graduate Studies');

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_major_minor`
--

CREATE TABLE `esk_profile_employee_major_minor` (
  `maj_min_id` int(11) NOT NULL AUTO_INCREMENT,
  `maj_min` varchar(55) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`maj_min_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_profile_employee_major_minor`
--

INSERT INTO `esk_profile_employee_major_minor` (`maj_min_id`, `maj_min`) VALUES
(1, 'English'),
(2, 'Mathematics'),
(3, 'Generalist'),
(5, 'Accountancy');

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_od`
--

CREATE TABLE `esk_profile_employee_od` (
  `od_id` int(11) NOT NULL AUTO_INCREMENT,
  `od_deduction_desc` varchar(500) NOT NULL,
  `od_item_id` int(11) NOT NULL,
  `od_acnt_id` varchar(55) NOT NULL,
  `od_principal_amount` float NOT NULL,
  `od_terms_id` int(11) NOT NULL COMMENT 'link to fin_frequency',
  `no_terms` int(11) NOT NULL,
  `approved` int(11) NOT NULL COMMENT 'if this deduction / loan is approved or not',
  `due_date` date NOT NULL,
  `paid_off` int(11) NOT NULL,
  `od_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`od_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_od_items`
--

CREATE TABLE `esk_profile_employee_od_items` (
  `odi_id` int(11) NOT NULL AUTO_INCREMENT,
  `odi_items` varchar(55) NOT NULL,
  `interest` float NOT NULL,
  PRIMARY KEY (`odi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_profile_employee_od_items`
--

INSERT INTO `esk_profile_employee_od_items` (`odi_id`, `odi_items`, `interest`) VALUES
(1, 'School Loan', 21.6),
(2, 'SSS Loan', 0),
(3, 'Pag-ibig Loan', 0),
(4, 'Canteen Credit', 0),
(5, 'Cash Advance', 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_od_payment_terms`
--

CREATE TABLE `esk_profile_employee_od_payment_terms` (
  `odp_id` int(11) NOT NULL AUTO_INCREMENT,
  `odp_terms` varchar(55) NOT NULL,
  PRIMARY KEY (`odp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_profile_employee_od_payment_terms`
--

INSERT INTO `esk_profile_employee_od_payment_terms` (`odp_id`, `odp_terms`) VALUES
(1, 'Weekly'),
(2, 'Bi Monthly'),
(3, 'Monthly'),
(4, 'Quarterly'),
(5, 'On Pay Day');

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_od_transaction`
--

CREATE TABLE `esk_profile_employee_od_transaction` (
  `od_trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `od_deduct_id` int(11) NOT NULL,
  `charge` float NOT NULL,
  `credit` float NOT NULL,
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(300) NOT NULL,
  PRIMARY KEY (`od_trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_paymentschedule`
--

CREATE TABLE `esk_profile_employee_paymentschedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monthly` int(11) NOT NULL COMMENT '1=monthly;0=bi-monthly; 2 = weekly',
  `firstpay` varchar(55) NOT NULL,
  `nextpay` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `esk_profile_employee_paymentschedule`
--

INSERT INTO `esk_profile_employee_paymentschedule` (`id`, `monthly`, `firstpay`, `nextpay`) VALUES
(1, 0, '18', '20');

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_payroll_trans`
--

CREATE TABLE `esk_profile_employee_payroll_trans` (
  `p_trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_acct_id` varchar(55) NOT NULL,
  `p_sg_id` int(11) NOT NULL,
  `p_od_id` int(11) NOT NULL,
  `p_trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `p_date_fr` date NOT NULL,
  `p_date_to` date NOT NULL,
  `p_approved` int(11) NOT NULL COMMENT '1 = hr; 2 = Admin',
  `p_released` int(11) NOT NULL,
  `p_released_date` date NOT NULL,
  `status` varchar(300) NOT NULL,
  PRIMARY KEY (`p_trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_employee_salary_grade`
--

CREATE TABLE `esk_profile_employee_salary_grade` (
  `salary_grade` int(11) NOT NULL AUTO_INCREMENT,
  `salary` int(11) NOT NULL,
  PRIMARY KEY (`salary_grade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `esk_profile_employee_salary_grade`
--

INSERT INTO `esk_profile_employee_salary_grade` (`salary_grade`, `salary`) VALUES
(1, 5000),
(2, 5500),
(3, 6000),
(4, 6500),
(5, 7000),
(6, 7500),
(7, 8000),
(8, 8500),
(9, 9000),
(10, 9500),
(11, 10000),
(12, 10500),
(13, 11000),
(14, 11500),
(15, 12000),
(16, 12500),
(17, 13000),
(18, 13500),
(19, 14000),
(20, 14500),
(21, 15000),
(22, 15500),
(23, 16000);

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_medical`
--

CREATE TABLE `esk_profile_medical` (
  `user_id` varchar(255) NOT NULL,
  `physician_id` int(11) DEFAULT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `other_important` varchar(255) DEFAULT NULL,
  `blood_type` varchar(35) DEFAULT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_med_allergies`
--

CREATE TABLE `esk_profile_med_allergies` (
  `alrgy_id` int(11) NOT NULL AUTO_INCREMENT,
  `alrgy_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`alrgy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_med_cmc`
--

CREATE TABLE `esk_profile_med_cmc` (
  `med_id` int(11) NOT NULL AUTO_INCREMENT,
  `med_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`med_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_med_others`
--

CREATE TABLE `esk_profile_med_others` (
  `id` int(11) NOT NULL,
  `others` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_med_physician`
--

CREATE TABLE `esk_profile_med_physician` (
  `physician_id` int(11) NOT NULL AUTO_INCREMENT,
  `physician` varchar(255) DEFAULT NULL,
  `physician_contact_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`physician_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_occupation`
--

CREATE TABLE `esk_profile_occupation` (
  `occ_id` int(11) NOT NULL AUTO_INCREMENT,
  `occupation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`occ_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `esk_profile_parents`
--

CREATE TABLE `esk_profile_parents` (
  `parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `father_id` int(11) NOT NULL COMMENT 'link to profile user_id',
  `mother_id` int(11) NOT NULL COMMENT 'link to profile user_id',
  `guardian` int(11) NOT NULL COMMENT '1 = if guardian ',
  `relationship` varchar(30) DEFAULT NULL,
  `f_office_name` varchar(255) NOT NULL,
  `f_office_address_id` int(11) NOT NULL,
  `m_office_name` varchar(255) NOT NULL,
  `m_office_address_id` int(11) NOT NULL,
  `ice_name` varchar(300) NOT NULL,
  `ice_contact` varchar(55) NOT NULL,
  `m_monthly_income` int(11) NOT NULL,
  `f_monthly_income` int(11) NOT NULL,
  `no_family_member` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `esk_profile_position`
--

CREATE TABLE `esk_profile_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) DEFAULT NULL,
  `position_dept_id` int(11) NOT NULL,
  `p_rank` int(11) NOT NULL,
  `p_alias` varchar(55) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `esk_profile_position`
--

INSERT INTO `esk_profile_position` (`position_id`, `position`, `position_dept_id`, `p_rank`, `p_alias`) VALUES
(1, 'Super Administrator', 1, 0, ''),
(2, 'President', 9, 0, ''),
(38, 'Principal - High School', 6, 0, ''),
(39, 'Faculty', 6, 0, ''),
(40, 'Cashier', 7, 0, ''),
(41, 'Human Resource Department Head', 8, 0, ''),
(42, 'Asst. to the Principal', 6, 0, ''),
(43, 'IT Coordinator', 2, 0, ''),
(44, 'Registrar', 9, 0, ''),
(45, 'Driver', 10, 0, ''),
(46, 'Utility', 10, 0, ''),
(48, 'Guidance Counselor', 9, 0, ''),
(49, 'Registrar', 2, 0, ''),
(51, 'Scholarship Coordinator', 2, 0, ''),
(52, 'Security Guard', 2, 0, ''),
(53, 'Librarian', 2, 0, ''),
(54, 'Staff', 2, 0, ''),
(55, 'Purchaser', 7, 0, ''),
(56, 'President', 1, 0, ''),
(57, 'VPAA', 1, 0, ''),
(58, 'VPSA', 1, 0, ''),
(59, 'VPF', 1, 0, ''),
(60, 'Tresurer', 7, 0, ''),
(61, 'DSF', 7, 0, ''),
(62, 'Accountant', 7, 0, ''),
(63, 'IT Manager', 2, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_students`
--

CREATE TABLE `esk_profile_students` (
  `st_id` varchar(55) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'link to profile user_id',
  `lrn` varchar(55) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `mother_tongue_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=admitted',
  PRIMARY KEY (`st_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_students_admission`
--

CREATE TABLE `esk_profile_students_admission` (
  `admission_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_year` int(11) NOT NULL,
  `date_admitted` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `school_last_attend` varchar(300) NOT NULL,
  `sla_address` varchar(500) NOT NULL,
  PRIMARY KEY (`admission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `esk_profile_students_c_admission`
--

CREATE TABLE `esk_profile_students_c_admission` (
  `admission_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_year` int(11) NOT NULL,
  `semester` int(11) NOT NULL COMMENT '1=first, 2=2nd, 3 = summer',
  `date_admitted` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `year_level` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `school_last_attend` varchar(300) NOT NULL,
  `sla_address_id` varchar(500) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  PRIMARY KEY (`admission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `esk_profile_students_c_load`
--

CREATE TABLE `esk_profile_students_c_load` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_adm_id` int(11) NOT NULL COMMENT 'connected with admission',
  `cl_user_id` int(11) NOT NULL,
  `cl_sub_id` int(11) NOT NULL,
  `cl_section` int(11) NOT NULL,
  `cl_overide` int(11) NOT NULL COMMENT 'if prerequisite is not satisfied but enrolled',
  `cl_remarks` varchar(255) NOT NULL COMMENT 'remarks for overidding',
  `is_final` int(11) NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_students_mlm`
--

CREATE TABLE `esk_profile_students_mlm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `mlm_grade_id` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `code_indicator` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='mlm means Monthly Learner''s Movement' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_profile_students_ro_years`
--

CREATE TABLE `esk_profile_students_ro_years` (
  `ro_id` int(11) NOT NULL AUTO_INCREMENT,
  `ro_years` int(11) NOT NULL,
  PRIMARY KEY (`ro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `esk_profile_students_ro_years`
--

INSERT INTO `esk_profile_students_ro_years` (`ro_id`, `ro_years`) VALUES
(1, 2017),
(2, 2018);

ALTER TABLE `esk_gs_settings` ADD `customized_mapeh` INT NOT NULL ;


---
--- Added to HR Settings
---

ALTER TABLE `esk_profile_employee_paymentschedule` ADD `stat_ben_sched` INT NOT NULL COMMENT '0 = every 2nd PD; 1 = every First PD; 2 = every PD' AFTER `nextpay`; 

CREATE TABLE `eskwela_bi_2016`.`esk_profile_employee_time_settings` ( 
`set_id` INT NOT NULL AUTO_INCREMENT , 
`day_id` INT NOT NULL , 
`time_in` TIME NOT NULL , 
`time_out` TIME NOT NULL , 
PRIMARY KEY (`set_id`)) ENGINE = InnoDB;

ALTER TABLE `esk_profile_employee_payroll_trans` ADD `sta_ben_is_paid` INT NOT NULL COMMENT 'if statutory benefits are paid during this payroll' AFTER `status`;

CREATE TABLE `esk_profile_temp_id` (
  `temp_id` int(11) NOT NULL,
  `generated_id` varchar(55) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_profile_temp_id`
--
ALTER TABLE `esk_profile_temp_id`
  ADD PRIMARY KEY (`temp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_profile_temp_id`
--
ALTER TABLE `esk_profile_temp_id`
  MODIFY `temp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `esk_profile_students_admission` ADD `st_type` INT NOT NULL COMMENT '0=New; Old=1; ' AFTER `st_id`;