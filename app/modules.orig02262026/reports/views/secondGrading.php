CREATE TABLE `eskdiv_settings` (
  `set_logo` varchar(255) DEFAULT NULL,
  `school_id` varchar(55) NOT NULL,
  `set_school_name` varchar(255) DEFAULT NULL,
  `set_school_address` varchar(255) DEFAULT NULL,
  `region` varchar(55) NOT NULL,
  `district` varchar(55) NOT NULL,
  `division` varchar(55) NOT NULL,
  `school_year` int(11) DEFAULT NULL,
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `monthly_report` varchar(55) DEFAULT NULL,
  `web_address` varchar(255) NOT NULL,
  `att_check` int(11) NOT NULL COMMENT '1 = auto; 0 = manual',
  `bosy` date NOT NULL,
  `eosy` date NOT NULL,
  `short_name` varchar(55) NOT NULL,
  `time_in` int(11) NOT NULL,
  `time_out` int(11) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `eskdiv_settings`
--

INSERT INTO `eskdiv_settings` (`set_logo`, `school_id`, `set_school_name`, `set_school_address`, `region`, `district`, `division`, `school_year`, `rowid`, `monthly_report`, `web_address`, `att_check`, `bosy`, `eosy`, `short_name`, `time_in`, `time_out`) VALUES
('noImage.png', '315410', 'Macasandig National High School', 'Macasandig, Cagayan de Oro City', 'X', 'II', 'Cagayan de Oro City', 2014, 1, '14', '', 0, '2014-06-02', '2015-03-31', 'Macasanding NHS', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `eskdiv_settings_passing_rate`
--

CREATE TABLE `eskdiv_settings_passing_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `attendance` int(11) NOT NULL,
  `quizzes` int(11) NOT NULL,
  `major_exams` int(11) NOT NULL,
  `projects` int(11) NOT NULL,
  `assignments` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `eskdiv_settings_passing_rate`
--

INSERT INTO `eskdiv_settings_passing_rate` (`id`, `subject_id`, `section_id`, `attendance`, `quizzes`, `major_exams`, `projects`, `assignments`) VALUES
(1, 0, 0, 10, 40, 40, 15, 5);

-- --------------------------------------------------------

--
-- Table structure for table `eskdiv_settings_quarter`
--

CREATE TABLE `eskdiv_settings_quarter` (
  `quarter_id` int(11) NOT NULL AUTO_INCREMENT,
  `quarter` varchar(100) DEFAULT NULL,
  `from_date` varchar(100) CHARACTER SET latin1 NOT NULL,
  `to_date` varchar(100) CHARACTER SET latin1 NOT NULL,
  `number_of_holidays` int(11) NOT NULL,
  PRIMARY KEY (`quarter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `eskdiv_settings_quarter`
--

INSERT INTO `eskdiv_settings_quarter` (`quarter_id`, `quarter`, `from_date`, `to_date`, `number_of_holidays`) VALUES
(1, '1st Quarter', '05-01-2014', '08-31-2014', 10),
(2, '2nd Quarter', '09-01-2014', '11-30-2014', 10),
(3, '3rd Quarter', '12-01-2014', '01-31-2015', 10),
(4, '4th Quarter', '02-01-2015', '03-31-2015', 10);

-- --------------------------------------------------------

--
-- Table structure for table `eskdiv_subject_settings`
--

CREATE TABLE `eskdiv_subject_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level_id` varchar(55) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `eskdiv_subject_settings`
--

INSERT INTO `eskdiv_subject_settings` (`id`, `grade_level_id`, `subject_id`) VALUES
(6, '5', '1,2,3,4,5,6'),
(10, '13', '1,2,3,4,8,9,10,12,13,14,15,16'),
(13, '18', '1,2,3,4,9,10,12,13,14,15,16'),
(14, '12', '1,2,3,4,8,9,10,12,13,14,15,16'),
(15, '11', '1,2,3,4,8,9,10,12,13,14,15,16,11');
