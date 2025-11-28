-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2018 at 12:40 PM
-- Server version: 5.6.38
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eskwela_lc_2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_chart_of_accounts`
--

CREATE TABLE `esk_as_chart_of_accounts` (
  `coa_id` int(11) NOT NULL,
  `coa_code` varchar(55) NOT NULL,
  `coa_name` varchar(300) NOT NULL,
  `coa_cat_id` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `is_displayed` int(11) NOT NULL COMMENT '0=hide; 1=show',
  `tb_show` int(11) NOT NULL COMMENT 'show in trial balance',
  `bs_show` int(11) NOT NULL COMMENT 'show in balance sheet'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_as_chart_of_accounts`
--

INSERT INTO `esk_as_chart_of_accounts` (`coa_id`, `coa_code`, `coa_name`, `coa_cat_id`, `account_type`, `is_displayed`, `tb_show`, `bs_show`) VALUES
(1, 'A0001', 'Cash on Hand', 5, 1, 0, 0, 0),
(2, 'A0002', 'Cash on Bank', 5, 1, 0, 0, 0),
(3, 'A0003', 'Petty Cash Fund', 5, 1, 1, 0, 0),
(4, 'A0004', 'Trade and Other Receivables', 6, 1, 1, 0, 0),
(5, 'A0005', 'Inventory', 7, 1, 0, 0, 0),
(6, 'A0006', 'Prepaid Expenses', 2, 1, 0, 0, 0),
(7, 'A0007', 'Other Current Assets', 1, 1, 0, 0, 0),
(35, 'E001', 'Payroll', 18, 1, 1, 0, 0),
(36, 'A0007', 'Cash in Bank - BOC 2218', 5, 1, 1, 0, 0),
(37, 'A0008', 'Cash in Bank - LBP 4163', 5, 1, 1, 0, 0),
(38, 'A0009', 'Cash in Bank - LBP 8591', 5, 1, 1, 0, 0),
(39, 'A0010', 'Cash in Bank - RCBC 502', 5, 1, 1, 0, 0),
(40, 'A0011', 'Petty Cash Fund', 5, 1, 0, 0, 0),
(41, 'A0012', 'Cash Shortage/Overages', 2, 1, 1, 0, 0),
(42, 'A0013', 'Books', 7, 1, 1, 0, 0),
(43, 'A0014', 'Mugs', 7, 1, 1, 0, 0),
(44, 'A0015', 'Tumbler', 7, 1, 1, 0, 0),
(45, 'A0016', 'Uniform', 7, 1, 1, 0, 0),
(46, 'A0017', 'Employees\'s Cash Advances', 2, 1, 1, 0, 0),
(47, 'A0018', 'Prepaid Insurance', 2, 1, 1, 0, 0),
(48, 'A0019', 'Building and Improvements', 19, 1, 1, 0, 0),
(49, 'A0020', 'Accumulated Depreciation', 19, 0, 1, 0, 0),
(50, 'A0021', 'Building and Improvements - Materials', 19, 1, 1, 0, 0),
(51, 'A0022', 'School Equiptment', 19, 0, 0, 0, 0),
(52, 'A0022', 'School Equiptment', 19, 1, 1, 0, 0),
(53, 'A0023', 'Sch. Equiptment - Accum. Depreciation', 19, 0, 1, 0, 0),
(54, 'A0024', 'School Furniture And Fixtures', 19, 1, 1, 0, 0),
(55, 'A0025', 'Sch. Furniture And Fixtures - Accum. Depreciation', 19, 0, 1, 0, 0),
(56, 'L0001', 'HDMF Premium Payable ', 3, 0, 1, 0, 0),
(57, 'L0002', 'HDMF Loans Payable', 3, 0, 1, 0, 0),
(58, 'L0003', 'Accrued HDMF - Employer', 3, 0, 1, 0, 0),
(59, 'L0004', 'PHIC Premium Payable', 3, 0, 1, 0, 0),
(60, 'L0005', 'Accrued PHIC - Employer', 3, 0, 1, 0, 0),
(61, 'L0006', 'SSS Premium Payable', 3, 0, 1, 0, 0),
(62, 'L0007', 'SSS Loans Payable', 3, 0, 1, 0, 0),
(63, 'L0008', 'Accrued SSS - Employer', 3, 0, 1, 0, 0),
(64, 'L0009', 'Taxes Payable : WTH Compensation ', 3, 0, 1, 0, 0),
(65, 'L0010', 'Unearned Revenue', 3, 0, 1, 0, 0),
(66, 'L0011', 'Workers Canteen Payable', 3, 0, 1, 0, 0),
(67, 'L0012', 'Coop Contribution Payable', 3, 0, 1, 0, 0),
(68, 'L0013', 'Tithes Payable', 3, 0, 1, 0, 0),
(69, 'L0014', 'Tuition Payable', 3, 0, 0, 0, 0),
(70, 'C0001', 'Opening Balance Equity', 20, 0, 1, 0, 0),
(71, 'R0001', 'Tuition Fees', 10, 0, 1, 0, 0),
(72, 'R0002', 'Registration Fees', 11, 0, 1, 0, 0),
(73, 'R0003', 'Miscellaneous School Fees', 11, 0, 1, 0, 0),
(74, 'P0001', 'Cost Book Sold', 21, 1, 0, 0, 0),
(75, 'R0003', 'Books', 22, 0, 1, 0, 0),
(76, 'E0002', 'Travel - Land', 23, 1, 1, 0, 0),
(77, 'E0003', 'Travel - Allowance', 23, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_coa_category`
--

CREATE TABLE `esk_as_coa_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(300) NOT NULL,
  `cat_parent_id` int(11) NOT NULL,
  `cat_type` int(11) NOT NULL COMMENT 'debit or credit',
  `has_child` int(11) NOT NULL,
  `coa_order` int(11) NOT NULL,
  `cat_show` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_as_coa_category`
--

INSERT INTO `esk_as_coa_category` (`cat_id`, `cat_name`, `cat_parent_id`, `cat_type`, `has_child`, `coa_order`, `cat_show`) VALUES
(1, 'Assets', 0, 0, 1, 3, 0),
(2, 'Current Assets', 1, 0, 1, 10, 0),
(3, 'Current Liabilities', 0, 0, 0, 4, 0),
(4, 'Shareholder\'s Equity', 0, 0, 0, 10, 0),
(5, 'Cash and cash equivalents', 2, 0, 0, 10, 0),
(6, 'Accounts and Other Receivables', 2, 0, 0, 10, 0),
(7, 'Inventories', 2, 0, 0, 10, 0),
(8, 'None-Current Assets', 1, 0, 0, 10, 0),
(9, 'Revenue', 0, 0, 1, 1, 1),
(10, 'Tuition Revenue', 9, 0, 0, 10, 1),
(11, 'Miscellaneous Revenue', 9, 0, 0, 10, 1),
(12, 'Laboratory Revenues', 9, 0, 0, 10, 0),
(13, 'Trainings Revenues', 9, 0, 0, 10, 0),
(16, 'Other Fees', 9, 0, 0, 10, 0),
(17, 'Expenses', 0, 0, 0, 2, 1),
(18, 'Salaries and Wages', 17, 0, 0, 10, 0),
(19, 'Fixed Assets', 0, 0, 0, 10, 0),
(20, 'Equity', 0, 0, 0, 10, 0),
(21, 'Cost of Sales', 7, 0, 0, 10, 1),
(22, 'Books', 9, 0, 0, 0, 1),
(23, 'Travel', 17, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_cv_transactions`
--

CREATE TABLE `esk_as_cv_transactions` (
  `cv_id` int(11) NOT NULL,
  `cv_trans_code` int(11) NOT NULL,
  `check_no` varchar(55) NOT NULL,
  `cv_approved_by` varchar(55) DEFAULT NULL,
  `cv_received_by` varchar(55) NOT NULL,
  `cv_date_received` date NOT NULL,
  `cv_debits_to` int(11) NOT NULL COMMENT 'for accounting',
  `cv_credits_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cash / Check Voucher Transactions';

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_expense_transaction`
--

CREATE TABLE `esk_as_expense_transaction` (
  `exp_id` int(11) NOT NULL,
  `exp_date` date NOT NULL,
  `exp_particulars` varchar(1000) NOT NULL,
  `exp_account_title` int(11) NOT NULL,
  `exp_bank` int(11) NOT NULL,
  `exp_amount` float NOT NULL,
  `exp_trans_code` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_as_expense_transaction`
--

INSERT INTO `esk_as_expense_transaction` (`exp_id`, `exp_date`, `exp_particulars`, `exp_account_title`, `exp_bank`, `exp_amount`, `exp_trans_code`) VALUES
(1, '2018-03-14', 'Travel to Narra', 76, 38, 9718, 18060791708),
(2, '2018-03-05', 'Travel to Narra Monthly Travel Allowance', 77, 38, 1200, 18060793002);

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_inv_category`
--

CREATE TABLE `esk_as_inv_category` (
  `cat_id` int(11) NOT NULL,
  `inv_category` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_as_inv_category`
--

INSERT INTO `esk_as_inv_category` (`cat_id`, `inv_category`) VALUES
(1, 'Books'),
(2, 'Uniform');

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_inv_items`
--

CREATE TABLE `esk_as_inv_items` (
  `inv_id` int(11) NOT NULL,
  `inv_name` varchar(55) NOT NULL,
  `inv_desc` varchar(300) NOT NULL,
  `inv_cat_id` int(11) NOT NULL,
  `inv_no_stocks` float NOT NULL,
  `inv_price` float NOT NULL,
  `inv_markup` float NOT NULL,
  `inv_cashier_link` int(11) NOT NULL COMMENT 'cashier item link',
  `inv_as_link` int(11) NOT NULL COMMENT 'accounting system link'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Inventory Items';

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_pr_transactions`
--

CREATE TABLE `esk_as_pr_transactions` (
  `pr_id` int(11) NOT NULL,
  `pr_item_id` int(11) NOT NULL,
  `pr_quantity` int(11) NOT NULL,
  `amount` float NOT NULL,
  `pr_trans_code` bigint(20) NOT NULL,
  `pr_request_by` varchar(300) NOT NULL,
  `pr_approved_by` varchar(55) NOT NULL,
  `pr_remarks` varchar(1000) NOT NULL,
  `pr_date_requested` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Purchase Request Transactions';

-- --------------------------------------------------------

--
-- Table structure for table `esk_as_transactions`
--

CREATE TABLE `esk_as_transactions` (
  `as_trans_id` int(11) NOT NULL,
  `as_coa_id` int(11) NOT NULL,
  `as_je_num` int(11) NOT NULL,
  `as_trans_description` text NOT NULL,
  `as_trans_date` date NOT NULL,
  `as_trans_amount` float NOT NULL,
  `as_trans_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--
--
-- Table structure for table `esk_c_finance_bank`
--

CREATE TABLE `esk_c_finance_bank` (
  `fbank_id` int(11) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `bank_short_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_c_finance_bank`
--
ALTER TABLE `esk_c_finance_bank`
  ADD PRIMARY KEY (`fbank_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_c_finance_bank`
--
ALTER TABLE `esk_c_finance_bank`
  MODIFY `fbank_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `esk_c_finance_encashments`
--

CREATE TABLE `esk_c_finance_encashments` (
  `encash_id` int(11) NOT NULL,
  `encash_bank_id` int(11) NOT NULL,
  `encash_cheque_num` varchar(55) NOT NULL,
  `encash_amount` float NOT NULL,
  `encash_date` date NOT NULL,
  `encash_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_c_finance_encashments`
--
ALTER TABLE `esk_c_finance_encashments`
  ADD PRIMARY KEY (`encash_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_c_finance_encashments`
--
ALTER TABLE `esk_c_finance_encashments`
  MODIFY `encash_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `esk_as_chart_of_accounts`
--
ALTER TABLE `esk_as_chart_of_accounts`
  ADD PRIMARY KEY (`coa_id`);

--
-- Indexes for table `esk_as_coa_category`
--
ALTER TABLE `esk_as_coa_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `esk_as_cv_transactions`
--
ALTER TABLE `esk_as_cv_transactions`
  ADD PRIMARY KEY (`cv_id`);

--
-- Indexes for table `esk_as_expense_transaction`
--
ALTER TABLE `esk_as_expense_transaction`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `esk_as_inv_category`
--
ALTER TABLE `esk_as_inv_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `esk_as_inv_items`
--
ALTER TABLE `esk_as_inv_items`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `esk_as_pr_transactions`
--
ALTER TABLE `esk_as_pr_transactions`
  ADD PRIMARY KEY (`pr_id`);

--
-- Indexes for table `esk_as_transactions`
--
ALTER TABLE `esk_as_transactions`
  ADD PRIMARY KEY (`as_trans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_as_chart_of_accounts`
--
ALTER TABLE `esk_as_chart_of_accounts`
  MODIFY `coa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `esk_as_coa_category`
--
ALTER TABLE `esk_as_coa_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `esk_as_cv_transactions`
--
ALTER TABLE `esk_as_cv_transactions`
  MODIFY `cv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_as_expense_transaction`
--
ALTER TABLE `esk_as_expense_transaction`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `esk_as_inv_category`
--
ALTER TABLE `esk_as_inv_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `esk_as_inv_items`
--
ALTER TABLE `esk_as_inv_items`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_as_pr_transactions`
--
ALTER TABLE `esk_as_pr_transactions`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_as_transactions`
--
ALTER TABLE `esk_as_transactions`
  MODIFY `as_trans_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `esk_c_finance_transactions` ADD `bank_id` INT NOT NULL AFTER `t_type` ;
