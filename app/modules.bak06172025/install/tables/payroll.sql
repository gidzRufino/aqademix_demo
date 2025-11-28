-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2018 at 04:27 PM
-- Server version: 5.6.38
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eskwela_ccsa_2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_charges`
--

CREATE TABLE `esk_payroll_charges` (
  `pc_id` int(11) NOT NULL,
  `pc_profile_id` varchar(300) NOT NULL COMMENT 'payroll profile',
  `pc_amount` float NOT NULL,
  `pc_code` int(11) NOT NULL COMMENT 'payroll period',
  `pc_item_id` int(11) NOT NULL COMMENT 'payroll items'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_items`
--

CREATE TABLE `esk_payroll_items` (
  `pi_item_id` int(11) NOT NULL,
  `pi_item_name` varchar(300) NOT NULL,
  `pi_item_type` int(11) NOT NULL COMMENT '0 = Debit; 1 = Credit',
  `pi_item_cat` int(11) NOT NULL COMMENT '0 = Default; 1 = Other Deduction'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_payroll_items`
--

INSERT INTO `esk_payroll_items` (`pi_item_id`, `pi_item_name`, `pi_item_type`, `pi_item_cat`) VALUES
(1, 'SSS', 0, 1),
(2, 'PhilHealth', 0, 1),
(3, 'Pag-ibig', 0, 1),
(4, 'Tax', 0, 1),
(5, 'SSS Loan', 0, 1),
(6, 'Pag-ibig Loan', 0, 1),
(7, 'Uniform', 0, 1),
(8, 'Laptop Loan', 0, 1),
(9, 'SIL', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_period`
--

CREATE TABLE `esk_payroll_period` (
  `per_id` int(11) NOT NULL,
  `per_from` date NOT NULL,
  `per_to` date NOT NULL,
  `per_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_payroll_period`
--

INSERT INTO `esk_payroll_period` (`per_id`, `per_from`, `per_to`, `per_code`) VALUES
(1, '2017-12-01', '2017-12-15', 115201712),
(2, '2018-01-01', '2018-01-15', 115201801),
(3, '2018-02-01', '2018-02-15', 115201802),
(4, '2018-01-26', '2018-02-10', 2147483647),
(5, '2018-05-26', '2018-06-10', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_profile`
--

CREATE TABLE `esk_payroll_profile` (
  `pp_id` int(11) NOT NULL,
  `pp_em_id` varchar(300) NOT NULL,
  `pp_sg_id` int(11) NOT NULL,
  `pp_debit_to` int(11) NOT NULL COMMENT 'accounting system',
  `pp_credit_to` int(11) NOT NULL COMMENT 'accounting system',
  `pp_act_to` int(11) NOT NULL COMMENT 'accounting system'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_shift`
--

CREATE TABLE `esk_payroll_shift` (
  `ps_id` int(11) NOT NULL,
  `ps_department` varchar(55) NOT NULL,
  `ps_from` time NOT NULL,
  `ps_to` time NOT NULL,
  `ps_from_pm` time NOT NULL,
  `ps_to_pm` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_payroll_shift`
--

INSERT INTO `esk_payroll_shift` (`ps_id`, `ps_department`, `ps_from`, `ps_to`, `ps_from_pm`, `ps_to_pm`) VALUES
(1, 'Office', '08:00:00', '12:00:00', '13:00:00', '17:00:00'),
(2, 'Faculty', '07:30:00', '12:00:00', '13:30:00', '16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_shift_group`
--

CREATE TABLE `esk_payroll_shift_group` (
  `grp_id` int(11) NOT NULL,
  `shift_groupings` varchar(255) NOT NULL,
  `shift_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_payroll_shift_group`
--

INSERT INTO `esk_payroll_shift_group` (`grp_id`, `shift_groupings`, `shift_id`) VALUES
(1, 'Office', 1);

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_stat_ben`
--

CREATE TABLE `esk_payroll_stat_ben` (
  `stat_id` int(11) NOT NULL,
  `stat_item_id` int(11) NOT NULL COMMENT 'payroll_items',
  `stat_sg_id` int(11) NOT NULL COMMENT 'salary grade',
  `stat_amount` float NOT NULL,
  `stat_ded_sched` int(11) NOT NULL COMMENT '0 = first; 1 = second;'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esk_payroll_transaction`
--

CREATE TABLE `esk_payroll_transaction` (
  `ptrans_id` int(11) NOT NULL,
  `ptrans_profile_id` varchar(300) NOT NULL,
  `ptrans_pay_code` int(11) NOT NULL,
  `ptrans_charge_grp_id` int(11) NOT NULL,
  `ptrans_amount` float NOT NULL,
  `ptrans_timestamp` datetime NOT NULL,
  `ptrans_status` int(11) NOT NULL COMMENT '0=not release; 1 = release',
  `ptrans_date_release` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_payroll_charges`
--
ALTER TABLE `esk_payroll_charges`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `esk_payroll_items`
--
ALTER TABLE `esk_payroll_items`
  ADD PRIMARY KEY (`pi_item_id`);

--
-- Indexes for table `esk_payroll_period`
--
ALTER TABLE `esk_payroll_period`
  ADD PRIMARY KEY (`per_id`);

--
-- Indexes for table `esk_payroll_shift`
--
ALTER TABLE `esk_payroll_shift`
  ADD PRIMARY KEY (`ps_id`);

--
-- Indexes for table `esk_payroll_shift_group`
--
ALTER TABLE `esk_payroll_shift_group`
  ADD PRIMARY KEY (`grp_id`);

--
-- Indexes for table `esk_payroll_stat_ben`
--
ALTER TABLE `esk_payroll_stat_ben`
  ADD PRIMARY KEY (`stat_id`);

--
-- Indexes for table `esk_payroll_transaction`
--
ALTER TABLE `esk_payroll_transaction`
  ADD PRIMARY KEY (`ptrans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_payroll_charges`
--
ALTER TABLE `esk_payroll_charges`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_payroll_items`
--
ALTER TABLE `esk_payroll_items`
  MODIFY `pi_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `esk_payroll_period`
--
ALTER TABLE `esk_payroll_period`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `esk_payroll_shift`
--
ALTER TABLE `esk_payroll_shift`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `esk_payroll_shift_group`
--
ALTER TABLE `esk_payroll_shift_group`
  MODIFY `grp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `esk_payroll_stat_ben`
--
ALTER TABLE `esk_payroll_stat_ben`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_payroll_transaction`
--
ALTER TABLE `esk_payroll_transaction`
  MODIFY `ptrans_id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
