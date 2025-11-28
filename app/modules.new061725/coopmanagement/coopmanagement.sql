
CREATE TABLE `esk_coop_account_details` (
  `cad_id` int(11) NOT NULL,
  `cad_profile_id` int(11) NOT NULL COMMENT 'fk to profile',
  `cad_share_capital` decimal(12,2) NOT NULL,
  `cad_savings` decimal(12,2) NOT NULL,
  `cad_account_no` char(16) NOT NULL,
  `cad_membership_type_id` int(11) NOT NULL,
  `cad_date_registered` datetime NOT NULL,
  `cad_spouse_is_member` int(11) NOT NULL,
  `is_approver` int(11) NOT NULL COMMENT 'Loan Application Approver'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_coop_loan_amortization`
--

CREATE TABLE `esk_coop_loan_amortization` (
  `lad_id` int(11) NOT NULL,
  `lad_ref_num` char(16) NOT NULL,
  `lad_date` date NOT NULL,
  `lad_balance` float NOT NULL,
  `lad_status` int(11) NOT NULL COMMENT '0 = unpaid; 1=paid. 2=overdue',
  `lad_payment` char(35) NOT NULL COMMENT 'payment reference id',
  `lad_remarks` char(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_coop_loan_approver`
--

CREATE TABLE `esk_coop_loan_approver` (
  `cla_id` int(11) NOT NULL,
  `cla_ref_number` char(55) NOT NULL COMMENT 'loan reference number',
  `cla_rvwd_by` char(55) DEFAULT NULL,
  `cla_date_rvwd` datetime NOT NULL,
  `cla_aprv_by_1` char(55) DEFAULT NULL,
  `cla_date_aprv_1` datetime NOT NULL,
  `cla_aprv_by_2` char(55) DEFAULT NULL,
  `cla_date_aprv_2` datetime NOT NULL,
  `cla_aprv_by_3` char(55) DEFAULT NULL,
  `cla_date_aprv_3` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_coop_loan_details`
--

CREATE TABLE `esk_coop_loan_details` (
  `ld_id` int(11) NOT NULL,
  `ld_ref_number` char(55) NOT NULL,
  `ld_account_num` char(16) NOT NULL,
  `ld_loan_date` date NOT NULL,
  `ld_loan_type` int(11) NOT NULL,
  `ld_principal_amount` float NOT NULL,
  `ld_weekly_amortization` float NOT NULL,
  `ld_total_amortization` float NOT NULL,
  `ld_terms` float NOT NULL,
  `ld_mop` int(11) NOT NULL,
  `ld_interest` float NOT NULL,
  `ld_clpp` float NOT NULL,
  `ld_service_fee` float NOT NULL,
  `ld_maturity_date` date NOT NULL,
  `ld_date_approved` datetime NOT NULL,
  `ld_date_released` datetime NOT NULL,
  `ld_released_trans_num` char(35) DEFAULT NULL,
  `ld_status` int(11) NOT NULL COMMENT '0=pending; 1=approved; 2=released',
  `ld_comaker_account` char(16) DEFAULT NULL,
  `ld_comaker_account_2` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_coop_loan_type`
--

CREATE TABLE `esk_coop_loan_type` (
  `clt_id` int(11) NOT NULL,
  `clt_type` char(35) NOT NULL,
  `clt_interest` float NOT NULL,
  `clt_service_charge` float NOT NULL,
  `clt_overdue_penalty` float NOT NULL,
  `clt_clpp` float NOT NULL,
  `clt_payroll_link` int(11) NOT NULL COMMENT 'link to payroll items'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_coop_loan_type`
--

INSERT INTO `esk_coop_loan_type` (`clt_id`, `clt_type`, `clt_interest`, `clt_service_charge`, `clt_overdue_penalty`, `clt_clpp`, `clt_payroll_link`) VALUES
(1, 'Regular Loan', 0.02, 0.02, 0.03, 1.1, 11),
(2, 'Loan Against Deposit', 0.03, 0.02, 0.03, 0, 15),
(3, 'Emergency Loan', 0.01, 0.02, 0.03, 0, 14),
(4, 'Cash Advance Loan', 0.04, 0.01, 0.03, 0, 13),
(5, 'Special Loan', 0.03, 0.02, 0.03, 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `esk_coop_transaction`
--

CREATE TABLE `esk_coop_transaction` (
  `cft_id` int(11) NOT NULL,
  `cft_profile_id` int(11) NOT NULL,
  `cft_account_no` char(35) NOT NULL,
  `cft_trans_num` varchar(55) NOT NULL,
  `cft_or_number` char(35) DEFAULT NULL,
  `cft_trans_amount` float NOT NULL,
  `cft_trans_type` int(11) NOT NULL,
  `cft_lrn` char(35) DEFAULT NULL,
  `cft_gl_type` int(11) NOT NULL,
  `cft_trans_date` datetime NOT NULL,
  `cft_remarks` varchar(500) DEFAULT NULL,
  `cft_payment_type` int(11) NOT NULL COMMENT '0=cash; 1=cheque;',
  `cft_bank_id` int(11) NOT NULL COMMENT 'if payment is cheque',
  `cft_cheque_num` char(35) DEFAULT NULL,
  `cft_teller_id` char(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_coop_transaction_type`
--

CREATE TABLE `esk_coop_transaction_type` (
  `ctt_id` int(11) NOT NULL,
  `ctt_type` char(35) NOT NULL,
  `ctt_short_code` char(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_coop_transaction_type`
--

INSERT INTO `esk_coop_transaction_type` (`ctt_id`, `ctt_type`, `ctt_short_code`) VALUES
(1, 'Savings Deposit', 'SD'),
(2, 'Share Capital Deposit', 'SCD'),
(3, 'Loan Payment', 'LP'),
(4, 'Withdrawal Request', 'WDRW'),
(5, 'Loan Disbursement', 'LD'),
(6, 'Capital Build Up', 'CBU'),
(7, 'Loan Protection Program', 'LPP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_coop_account_details`
--
ALTER TABLE `esk_coop_account_details`
  ADD PRIMARY KEY (`cad_id`);

--
-- Indexes for table `esk_coop_loan_amortization`
--
ALTER TABLE `esk_coop_loan_amortization`
  ADD PRIMARY KEY (`lad_id`);

--
-- Indexes for table `esk_coop_loan_approver`
--
ALTER TABLE `esk_coop_loan_approver`
  ADD PRIMARY KEY (`cla_id`);

--
-- Indexes for table `esk_coop_loan_details`
--
ALTER TABLE `esk_coop_loan_details`
  ADD PRIMARY KEY (`ld_id`);

--
-- Indexes for table `esk_coop_loan_type`
--
ALTER TABLE `esk_coop_loan_type`
  ADD PRIMARY KEY (`clt_id`);

--
-- Indexes for table `esk_coop_transaction`
--
ALTER TABLE `esk_coop_transaction`
  ADD PRIMARY KEY (`cft_id`);

--
-- Indexes for table `esk_coop_transaction_type`
--
ALTER TABLE `esk_coop_transaction_type`
  ADD PRIMARY KEY (`ctt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_coop_account_details`
--
ALTER TABLE `esk_coop_account_details`
  MODIFY `cad_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_coop_loan_amortization`
--
ALTER TABLE `esk_coop_loan_amortization`
  MODIFY `lad_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_coop_loan_approver`
--
ALTER TABLE `esk_coop_loan_approver`
  MODIFY `cla_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_coop_loan_details`
--
ALTER TABLE `esk_coop_loan_details`
  MODIFY `ld_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_coop_loan_type`
--
ALTER TABLE `esk_coop_loan_type`
  MODIFY `clt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `esk_coop_transaction`
--
ALTER TABLE `esk_coop_transaction`
  MODIFY `cft_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_coop_transaction_type`
--
ALTER TABLE `esk_coop_transaction_type`
  MODIFY `ctt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
