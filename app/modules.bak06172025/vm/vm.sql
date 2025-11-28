-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 03, 2017 at 07:28 PM
-- Server version: 5.6.34
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `eskwela.lca_2016`
--

-- --------------------------------------------------------

--
-- Table structure for table `esk_vm_accounts`
--

CREATE TABLE `esk_vm_accounts` (
  `va_id` int(11) NOT NULL,
  `va_firstname` varchar(25) NOT NULL,
  `va_lastname` varchar(25) NOT NULL,
  `va_company` varchar(25) NOT NULL,
  `va_avatar` varchar(25) NOT NULL,
  `va_remarks` text NOT NULL,
  `va_uid` varchar(25) NOT NULL,
  `va_dept` varchar(25) NOT NULL,
  `va_last_visit` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_vm_accounts`
--

INSERT INTO `esk_vm_accounts` (`va_id`, `va_firstname`, `va_lastname`, `va_company`, `va_avatar`, `va_remarks`, `va_uid`, `va_dept`, `va_last_visit`) VALUES
(1, 'b', 'b', 'b', '170503180941.jpg', '', '', '6', '05/03/17'),
(2, 'Chamae Mae', 'Douge', 'The Douge Company', '160820013601.jpg', '', '', '6', '05/03/17'),
(3, 'Printet', 'Cook', 'Cook', '170104193312.jpg', '', '', '6', '05/03/17'),
(4, 'Jerome', 'Lirazan', 'COOK', '160816141337.jpg', '', '', '6', '08/17/16'),
(5, 'Arcielita', 'Rufino', 'CSS Core', '160909001348.jpg', '', '779', '8', '08/18/16'),
(6, 'Daisy Jane', 'Cook', 'COOK', '160816151909.jpg', '', '', '6', '08/17/16'),
(12, 'Cathy', 'Meowmeow', 'The Cat Company', '160817183256.jpg', '', '', '6', '08/20/16'),
(13, 'Blackie', 'Doug', 'COOK', '161205145733.jpg', '', '', '7', '01/04/17'),
(14, 'Kari', 'Jobe', 'Integrity Music', '160820014408.jpg', '', '', '6', '05/03/17'),
(15, 'Roseler', 'Yecyec', 'Bohol', '170105130000.jpg', '', '778', '8', '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_vm_log`
--

CREATE TABLE `esk_vm_log` (
  `log_id` int(11) NOT NULL,
  `log_user_id` varchar(25) NOT NULL,
  `log_va_id` varchar(25) NOT NULL,
  `log_in` varchar(25) NOT NULL,
  `log_out` varchar(25) NOT NULL,
  `log_date` varchar(25) NOT NULL,
  `log_dept` varchar(25) NOT NULL,
  `log_avatar` varchar(25) NOT NULL,
  `log_remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_vm_log`
--

INSERT INTO `esk_vm_log` (`log_id`, `log_user_id`, `log_va_id`, `log_in`, `log_out`, `log_date`, `log_dept`, `log_avatar`, `log_remarks`) VALUES
(1, '776', '4', '02:14 pm', '02:02 am', '08/16/16', '6', '160816141337.jpg', ''),
(2, '778', '5', '03:18 pm', '03:22 am', '08/16/16', '7', '160816151802.jpg', ''),
(3, '781', '6', '03:19 pm', '03:31 am', '08/16/16', '6', '160816151909.jpg', ''),
(4, '776', '5', '02:13 am', '03:52 am', '08/17/16', '6', '160817021307.jpg', ''),
(5, '778', '3', '03:32 am', '03:52 am', '08/17/16', '8', '160817033207.jpg', ''),
(6, '775', '2', '03:33 am', '02:46 am', '08/17/16', '6', '160817033356.jpg', ''),
(7, '778', '2', '03:52 am', '03:53 am', '08/17/16', '8', '160817035251.jpg', ''),
(8, '776', '5', '06:08 pm', '02:47 am', '08/17/16', '6', '160817180759.jpg', ''),
(9, '777', '12', '06:33 pm', '01:34 am', '08/17/16', '6', '160817183256.jpg', ''),
(10, '781', '13', '06:33 pm', '05:46 pm', '08/17/16', '7', '160817183340.jpg', ''),
(11, '782', '14', '02:46 am', '01:34 am', '08/18/16', '8', '160818024538.jpg', ''),
(12, '778', '13', '01:35 am', '12:14 am', '08/20/16', '7', '160820013519.jpg', ''),
(13, '776', '2', '01:36 am', '06:10 pm', '08/20/16', '6', '160820013601.jpg', ''),
(14, '775', '14', '01:44 am', '06:10 pm', '08/20/16', '6', '160820014408.jpg', ''),
(15, '779', '5', '12:13 am', '', '09/09/16', '8', '160909001348.jpg', ''),
(16, '780', '13', '02:57 pm', '07:33 pm', '12/05/16', '7', '161205145733.jpg', ''),
(17, '781', '3', '07:33 pm', '06:10 pm', '01/04/17', '6', '170104193312.jpg', ''),
(18, '778', '15', '01:00 pm', '', '01/05/17', '8', '170105130000.jpg', ''),
(19, '780', '1', '06:09 pm', '06:10 pm', '05/03/17', '6', '170503180941.jpg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_vm_accounts`
--
ALTER TABLE `esk_vm_accounts`
  ADD PRIMARY KEY (`va_id`);

--
-- Indexes for table `esk_vm_log`
--
ALTER TABLE `esk_vm_log`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_vm_accounts`
--
ALTER TABLE `esk_vm_accounts`
  MODIFY `va_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `esk_vm_log`
--
ALTER TABLE `esk_vm_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;