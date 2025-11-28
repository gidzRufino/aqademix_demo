-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_accounts`
--

CREATE TABLE `esk_fin_accounts` (
  `accounts_id` int(11) NOT NULL,
  `stud_id` varchar(50) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `sy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_department`
--

CREATE TABLE `esk_fin_department` (
  `dept_id` int(11) NOT NULL,
  `dept_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_department`
--

INSERT INTO `esk_fin_department` (`dept_id`, `dept_description`) VALUES
(1, 'General'),
(2, 'Admin'),
(3, 'PTA');

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_detail`
--

CREATE TABLE `esk_fin_detail` (
  `detail_id` int(11) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `d_charge` double NOT NULL,
  `d_credit` double NOT NULL,
  `charge_credit` tinyint(1) NOT NULL COMMENT '1 if credit, 0 if charge',
  `sy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_discount`
--

CREATE TABLE `esk_fin_discount` (
  `discount_ID` int(11) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `discount_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_extra`
--

CREATE TABLE `esk_fin_extra` (
  `extra_id` int(11) NOT NULL,
  `stud_id` varchar(55) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_extra`
--


-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_initial`
--

CREATE TABLE `esk_fin_initial` (
  `init_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_amount` double NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `sy_id` int(15) NOT NULL,
  `implement_date` varchar(25) NOT NULL,
  `ch_cr` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_initial`
--


-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_items`
--

CREATE TABLE `esk_fin_items` (
  `item_id` int(11) NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `dept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_items`
--

INSERT INTO `esk_fin_items` (`item_id`, `item_description`, `dept_id`) VALUES
(1, 'Tuition Fee', 1),
(2, 'Downpayment', 1),
(3, 'Books', 1),
(4, 'Misc.', 1),
(5, 'Computer Lab', 1),
(6, 'PE Uniform', 1),
(7, 'PTA', 2),
(8, 'Previous Account', 2),
(9, 'School ID', 2),
(10, 'ebook', 2),
(11, 'BGB Uniform', 1),
(12, 'Laboratory', 1),
(13, 'Test Papers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_logs`
--

CREATE TABLE `esk_fin_logs` (
  `log_id` int(11) NOT NULL,
  `date_time` varchar(50) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `remarks` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_plan`
--

CREATE TABLE `esk_fin_plan` (
  `plan_id` int(11) NOT NULL,
  `plan_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_plan`
--

INSERT INTO `esk_fin_plan` (`plan_id`, `plan_description`) VALUES
(1, 'General'),
(11, 'Full Scholar');

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_schedule`
--

CREATE TABLE `esk_fin_schedule` (
  `schedule_id` int(11) NOT NULL,
  `schedule_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_schedule`
--

INSERT INTO `esk_fin_schedule` (`schedule_id`, `schedule_description`) VALUES
(1, 'Monthly'),
(2, 'Quarterly'),
(3, 'Semester'),
(4, 'Enrolment'),
(5, 'Summer'),
(6, '1st Semester'),
(7, '2nd Semester');

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_settings`
--

CREATE TABLE `esk_fin_settings` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` varchar(50) NOT NULL,
  `value_2` varchar(255) NOT NULL,
  `value_3` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_fin_settings`
--

INSERT INTO `esk_fin_settings` (`id`, `description`, `value`, `value_2`, `value_3`) VALUES
(1, 'default school year', '5', '2017-2018', '2017');

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_smsrecord`
--

CREATE TABLE `esk_fin_smsrecord` (
  `sms_id` int(11) NOT NULL,
  `destination` varchar(55) NOT NULL,
  `date` varchar(25) NOT NULL,
  `user_id` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_sy`
--

CREATE TABLE `esk_fin_sy` (
  `sy_id` int(11) NOT NULL,
  `school_year` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_sy`
--

INSERT INTO `esk_fin_sy` (`sy_id`, `school_year`) VALUES
(4, '2016-2017'),
(5, '2017-2018'),
(6, '2018-2019'),
(7, '2019-2020'),
(8, '2020-2021');

-- --------------------------------------------------------

--
-- Table structure for table `esk_fin_transaction`
--

CREATE TABLE `esk_fin_transaction` (
  `trans_id` varchar(255) NOT NULL,
  `ref_number` varchar(255) NOT NULL,
  `stud_id` varchar(55) NOT NULL,
  `tdate` varchar(255) NOT NULL,
  `cashier_id` int(11) NOT NULL,
  `tcharge` double NOT NULL,
  `tcredit` double NOT NULL,
  `tremarks` text NOT NULL,
  `sy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_fin_transaction`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_fin_accounts`
--
ALTER TABLE `esk_fin_accounts`
  ADD PRIMARY KEY (`accounts_id`);

--
-- Indexes for table `esk_fin_department`
--
ALTER TABLE `esk_fin_department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `esk_fin_detail`
--
ALTER TABLE `esk_fin_detail`
  ADD UNIQUE KEY `fin_detail_id` (`detail_id`);

--
-- Indexes for table `esk_fin_discount`
--
ALTER TABLE `esk_fin_discount`
  ADD PRIMARY KEY (`discount_ID`);

--
-- Indexes for table `esk_fin_extra`
--
ALTER TABLE `esk_fin_extra`
  ADD PRIMARY KEY (`extra_id`);

--
-- Indexes for table `esk_fin_initial`
--
ALTER TABLE `esk_fin_initial`
  ADD PRIMARY KEY (`init_id`);

--
-- Indexes for table `esk_fin_items`
--
ALTER TABLE `esk_fin_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `esk_fin_logs`
--
ALTER TABLE `esk_fin_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `esk_fin_plan`
--
ALTER TABLE `esk_fin_plan`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `esk_fin_schedule`
--
ALTER TABLE `esk_fin_schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `esk_fin_settings`
--
ALTER TABLE `esk_fin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `esk_fin_smsrecord`
--
ALTER TABLE `esk_fin_smsrecord`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `esk_fin_sy`
--
ALTER TABLE `esk_fin_sy`
  ADD PRIMARY KEY (`sy_id`);

--
-- Indexes for table `esk_fin_transaction`
--
ALTER TABLE `esk_fin_transaction`
  ADD PRIMARY KEY (`trans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_fin_accounts`
--
ALTER TABLE `esk_fin_accounts`
  MODIFY `accounts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `esk_fin_department`
--
ALTER TABLE `esk_fin_department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `esk_fin_detail`
--
ALTER TABLE `esk_fin_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_fin_discount`
--
ALTER TABLE `esk_fin_discount`
  MODIFY `discount_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_fin_extra`
--
ALTER TABLE `esk_fin_extra`
  MODIFY `extra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_fin_initial`
--
ALTER TABLE `esk_fin_initial`
  MODIFY `init_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_fin_items`
--
ALTER TABLE `esk_fin_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `esk_fin_logs`
--
ALTER TABLE `esk_fin_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_fin_plan`
--
ALTER TABLE `esk_fin_plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_fin_smsrecord`
--
ALTER TABLE `esk_fin_smsrecord`
  MODIFY `sms_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_fin_sy`
--
ALTER TABLE `esk_fin_sy`
  MODIFY `sy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_finance_request`
--

CREATE TABLE `esk_c_finance_request` (
  `fr_id` int(11) NOT NULL,
  `fr_requesting_id` int(11) NOT NULL,
  `fr_remarks` varchar(500) NOT NULL,
  `fr_date_requested` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fr_approved` int(11) NOT NULL COMMENT '0=no; 1=yes',
  `fr_approved_by` varchar(55) NOT NULL,
  `fr_allowable_amount` float NOT NULL,
  `approved_date` datetime NOT NULL,
  `fr_year` year(4) NOT NULL,
  `fr_sem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='promisory note / request';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_c_finance_request`
--
ALTER TABLE `esk_c_finance_request`
  ADD PRIMARY KEY (`fr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_c_finance_request`
--
ALTER TABLE `esk_c_finance_request`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT;