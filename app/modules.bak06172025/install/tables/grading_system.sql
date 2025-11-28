--
-- Paste your SQL dump into this file
--

--
-- Table structure for table `esk_grade_level`
--

CREATE TABLE `esk_grade_level` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) DEFAULT NULL,
  `levelCode` varchar(255) DEFAULT NULL,
  `deptCode` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `esk_grade_level`

INSERT INTO `esk_grade_level` (`grade_id`, `level`, `levelCode`, `deptCode`, `order`, `dept_id`) VALUES
(1, 'Kinder', 'kinder', 11, 3, 1),
(2, 'Grade 1', 'grade1', 22, 4, 2),
(3, 'Grade 2', 'grade2', 22, 5, 2),
(4, 'Grade 3', 'grade3', 22, 6, 2),
(5, 'Grade 4', 'grade4', 22, 7, 2),
(6, 'Grade 5', 'grade5', 22, 8, 2),
(7, 'Grade 6', 'grade6', 22, 9, 2),
(8, 'Grade 7', 'grade7', 33, 10, 3),
(9, 'Grade 8', 'grade8', 33, 11, 3),
(10, 'Grade 9', 'grade9', 33, 12, 3),
(11, 'Grade 10', 'grade10', 33, 13, 3),
(12, 'Grade 11', 'grade11', 44, 14, 4),
(13, 'Grade 12', 'grade12', 44, 15, 4),
(14, 'Nursery', 'nursery', 11, 1, 1),
(15, 'Prep', 'prep', 11, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_assessment`
--

CREATE TABLE `esk_gs_assessment` (
  `assess_id` int(11) NOT NULL AUTO_INCREMENT,
  `assess_title` varchar(55) NOT NULL,
  `assess_date` varchar(55) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `faculty_id` varchar(55) NOT NULL,
  `no_items` int(11) NOT NULL,
  `passing_rate` int(11) NOT NULL,
  `quiz_cat` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`assess_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_asses_category`
--

CREATE TABLE `esk_gs_asses_category` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(55) NOT NULL,
  `weight` float NOT NULL,
  `department` int(11) NOT NULL COMMENT '0=grade 1 - 6; 1=grade 7 - 10; 3=grade 11 -12',
  `subject_id` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `esk_gs_asses_category`
--

INSERT INTO `esk_gs_asses_category` (`code`, `category_name`, `weight`, `department`, `subject_id`, `school_year`) VALUES
(11, 'Knowledge', 0.15, 0, 0, 2014),
(12, 'Process', 0.2, 0, 0, 2014),
(13, 'Understanding', 0.2, 0, 0, 2014),
(14, 'Product/Performance', 0.3, 0, 0, 2014),
(15, 'Behavior', 0.15, 0, 0, 2014),
(16, 'Knowledge', 0.1, 1, 21, 2014),
(17, 'Process', 0.2, 1, 21, 2014),
(18, 'Understanding', 0.2, 1, 21, 2014),
(19, 'Product/Performance', 0.35, 1, 21, 2014),
(20, 'Behavior', 0.15, 1, 21, 2014),
(21, 'Written Work', 0.3, 0, 1, 2016),
(22, 'Performance Task', 0.5, 0, 1, 2016),
(23, 'Quarterly Assessment', 0.2, 0, 1, 2016),
(24, 'Written Work', 0.3, 0, 2, 2016),
(25, 'Performance Task', 0.5, 0, 2, 2016),
(26, 'Quarterly Assessment', 0.2, 0, 2, 2016),
(27, 'Written Work', 0.3, 0, 9, 2016),
(28, 'Performance Task', 0.5, 0, 9, 2016),
(29, 'Quarterly Assessment', 0.2, 0, 9, 2016),
(30, 'Written Work', 0.3, 0, 12, 2016),
(31, 'Performance Task', 0.5, 0, 12, 2016),
(32, 'Quarterly Assessment', 0.2, 0, 12, 2016),
(33, 'Written Work', 0.4, 0, 3, 2016),
(34, 'Performance Task', 0.4, 0, 3, 2016),
(35, 'Quarterly Assessment', 0.2, 0, 3, 2016),
(36, 'Written Work', 0.4, 0, 4, 2016),
(37, 'Performance Task', 0.4, 0, 4, 2016),
(38, 'Quarterly Assessment', 0.2, 0, 4, 2016),
(39, 'Written Work', 0.2, 0, 13, 2016),
(40, 'Performance Task', 0.6, 0, 13, 2016),
(41, 'Quarterly Assessment', 0.2, 0, 13, 2016),
(42, 'Written Work', 0.2, 0, 14, 2016),
(43, 'Performance Task', 0.6, 0, 14, 2016),
(44, 'Quarterly Assessment', 0.2, 0, 14, 2016),
(45, 'Written Work', 0.2, 0, 15, 2016),
(46, 'Performance Task', 0.6, 0, 15, 2016),
(47, 'Quarterly Assessment', 0.2, 0, 15, 2016),
(48, 'Written Work', 0.2, 0, 16, 2016),
(49, 'Performance Task', 0.6, 0, 16, 2016),
(50, 'Quarterly Assessment', 0.2, 0, 16, 2016),
(51, 'Written Work', 0.2, 0, 10, 2016),
(52, 'Performance Task', 0.6, 0, 10, 2016),
(53, 'Quarterly Assessment', 0.2, 0, 10, 2016),
(54, 'Written Work', 0.25, 0, 37, 2016),
(55, 'Performance Task', 0.5, 0, 37, 2016),
(56, 'Quarterly Assessment', 0.25, 0, 37, 2016),
(57, 'Written Work', 0.25, 0, 25, 2016),
(58, 'Performance Task', 0.5, 0, 25, 2016),
(59, 'Quarterly Assessment', 0.25, 0, 25, 2016),
(60, 'Written Work', 0.25, 0, 35, 2016),
(61, 'Performance Task', 0.5, 0, 35, 2016),
(62, 'Quarterly Assessment', 0.25, 0, 35, 2016),
(63, 'Written Work', 0.25, 0, 41, 2016),
(64, 'Performance Task', 0.45, 0, 41, 2016),
(65, 'Quarterly Assessment', 0.3, 0, 41, 2016),
(66, 'Written Work', 0.25, 0, 34, 2016),
(67, 'Performance Task', 0.5, 0, 34, 2016),
(68, 'Quarterly Assessment', 0.25, 0, 34, 2016),
(69, 'Written Work', 0.25, 0, 39, 2016),
(70, 'Performance Task', 0.45, 0, 39, 2016),
(71, 'Quarterly Assessment', 0.3, 0, 39, 2016),
(72, 'Written Work', 0.1, 0, 48, 2016),
(73, 'Performance Task', 0.7, 0, 48, 2016),
(74, 'Quarterly Assessment', 0.2, 0, 48, 2016),
(75, 'Written Work', 0.3, 0, 45, 2016),
(76, 'Performance Task', 0.4, 0, 45, 2016),
(77, 'Quarterly Assessment', 0.3, 0, 45, 2016),
(78, 'Written Work', 0.25, 0, 32, 2016),
(79, 'Written Work', 0.25, 0, 36, 2016),
(80, 'Performance Task', 0.45, 0, 36, 2016),
(81, 'Quarterly Assessment', 0.3, 0, 36, 2016),
(82, 'Written Work', 0.25, 0, 40, 2016),
(83, 'Performance Task', 0.45, 0, 40, 2016),
(84, 'Quarterly Assessment', 0.3, 0, 40, 2016),
(85, 'Written Work', 0.25, 0, 44, 2016),
(86, 'Performance Task', 0.5, 0, 44, 2016),
(87, 'Quarterly Assessment', 0.25, 0, 44, 2016),
(88, 'Written Work', 0.25, 0, 33, 2016),
(89, 'Performance Task', 0.45, 0, 33, 2016),
(90, 'Quarterly Assessment', 0.3, 0, 33, 2016),
(91, 'Written Work', 0.3, 0, 5, 2016),
(92, 'Performance Task', 0.3, 0, 5, 2016),
(93, 'Quarterly Assessment', 0.4, 0, 5, 2016),
(94, 'Written Work', 0.25, 0, 43, 2016),
(95, 'Performance Task', 0.5, 0, 43, 2016),
(96, 'Quarterly Assessment', 0.25, 0, 43, 2016);

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_behavior_rate`
--

CREATE TABLE `esk_gs_behavior_rate` (
  `bh_id` int(11) NOT NULL AUTO_INCREMENT,
  `bh_name` text NOT NULL,
  `bh_group` tinyint(4) NOT NULL COMMENT 'for depEd order #8 s.2015',
  `gs_used` smallint(6) NOT NULL,
  PRIMARY KEY (`bh_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `esk_gs_behavior_rate`
--

INSERT INTO `esk_gs_behavior_rate` (`bh_id`, `bh_name`, `bh_group`, `gs_used`) VALUES
(1, 'Cooperative', 0, 1),
(2, 'Creative', 0, 1),
(3, 'God-Loving', 0, 1),
(4, 'Good Sport', 0, 1),
(5, 'Honest', 0, 1),
(6, 'Industrious', 0, 1),
(7, 'Kind', 0, 1),
(8, 'Modest', 0, 1),
(9, 'Obedient', 0, 1),
(10, 'Patriotic', 0, 1),
(11, 'Respectful', 0, 1),
(12, 'Responsible', 0, 1),
(13, 'School Spirit-conscious', 0, 1),
(14, 'Self-motivated', 0, 1),
(15, 'Time-Conscious', 0, 1),
(16, 'Well-groomed', 0, 1),
(18, 'Expresses one''s spiritual beliefs while respecting the spiritual beliefs of others', 1, 2),
(19, 'Shows Adherence to ethical principles by upholding the truth', 1, 2),
(20, 'Is sensitive to individual, social and cultural differences', 2, 2),
(21, 'Demonstrates contributions toward solidarity', 2, 2),
(22, 'Cares for the environment and utilizes resources wisely, judiciously and economically', 3, 2),
(23, 'Demonstrates pride in being a Filipino; exercises the rights and responsibility of a Filipino Citizen', 4, 2),
(24, 'Demonstrates appropriate behavior in carrying out activities in the school, community and country', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_card_remarks`
--

CREATE TABLE `esk_gs_card_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `remarks` varchar(300) NOT NULL,
  `term` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_cc_cat`
--

CREATE TABLE `esk_gs_cc_cat` (
  `cc_id` int(11) NOT NULL,
  `areas_act` varchar(55) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  PRIMARY KEY (`cc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='co-curricular areas / activities';

--
-- Dumping data for table `esk_gs_cc_cat`
--

INSERT INTO `esk_gs_cc_cat` (`cc_id`, `areas_act`, `short_code`) VALUES
(1, 'Contest and Competitions', '(CC)'),
(2, 'Student Leadership', '(SL)'),
(3, 'Campus Journalism', '(CJ)'),
(4, 'Officership and Membership', '(OM)'),
(5, 'Participation and Attendance', '(PA)');

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_cc_involvement`
--

CREATE TABLE `esk_gs_cc_involvement` (
  `cc_involvement_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `cc_level_part_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `date_event` varchar(10) NOT NULL,
  `term` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `is_verified` int(11) NOT NULL,
  PRIMARY KEY (`cc_involvement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_cc_level_part`
--

CREATE TABLE `esk_gs_cc_level_part` (
  `part_id` int(11) NOT NULL,
  `part_pos` varchar(255) NOT NULL,
  `rank` varchar(55) NOT NULL,
  `points` float NOT NULL,
  `cc_cat_id` int(11) NOT NULL,
  PRIMARY KEY (`part_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='points for co-curricular performace';

--
-- Dumping data for table `esk_gs_cc_level_part`
--

INSERT INTO `esk_gs_cc_level_part` (`part_id`, `part_pos`, `rank`, `points`, `cc_cat_id`) VALUES
(1, 'International', 'Gold', 15, 1),
(2, 'International', 'Silver', 10, 1),
(3, 'International', 'Bronze', 8, 1),
(4, 'International', 'Participant', 6, 1),
(5, 'National', 'Gold', 10, 1),
(6, 'National', 'Silver', 8, 1),
(7, 'National', 'Bronze', 6, 1),
(8, 'National', 'Participant', 4, 1),
(9, 'Regional', 'Gold', 8, 1),
(10, 'Regional', 'Silver', 6, 1),
(11, 'Regional', 'Bronze', 4, 1),
(12, 'Regional', 'Participant', 2, 1),
(13, 'Division', 'Gold', 6, 1),
(14, 'Division', 'Silver', 4, 1),
(15, 'Division', 'Bronze', 2, 1),
(16, 'Division', 'Participant', 1, 1),
(17, 'District', 'Gold', 4, 1),
(18, 'District', 'Silver', 2, 1),
(19, 'District', 'Bronze', 1, 1),
(20, 'District', 'Participant', 0.75, 1),
(21, 'School', 'Gold', 2, 1),
(22, 'School', 'Silver', 1, 1),
(23, 'School', 'Bronze', 0.75, 1),
(24, 'School', 'Participant', 0.5, 1),
(25, 'President / Mayor', 'National', 15, 2),
(26, 'President / Mayor', 'Regional', 12, 2),
(27, 'President / Mayor', 'Division', 10, 2),
(28, 'President / Mayor', 'District / School', 8, 2),
(29, 'Vice President / Vice Mayor', 'National', 12, 2),
(30, 'Vice President / Vice Mayor', 'Regional', 10, 2),
(31, 'Vice President / Vice Mayor', 'Division', 8, 2),
(32, 'Vice President / Vice Mayor', 'District / School', 6, 2),
(33, 'Secretary / Treasurer', 'National', 10, 2),
(34, 'Secretary / Treasurer', 'Regional', 8, 2),
(35, 'Secretary / Treasurer', 'Division', 6, 2),
(36, 'Secretary / Treasurer', 'District / School', 4, 2),
(37, 'Auditor, Peace Officer, Public Information Officer', 'National', 8, 2),
(38, 'Auditor, Peace Officer, Public Information Officer', 'Regional', 6, 2),
(39, 'Auditor, Peace Officer, Public Information Officer', 'Division', 4, 2),
(40, 'Auditor, Peace Officer, Public Information Officer', 'District / School', 2, 2),
(41, 'Representative / Councilor', 'National', 6, 2),
(42, 'Representative / Councilor', 'Regional', 4, 2),
(43, 'Representative / Councilor', 'Division', 2, 2),
(44, 'Representative / Councilor', 'District / School', 1, 2),
(45, 'COMELEC and Committee Chair and Vice Chair', 'National', 4, 2),
(46, 'COMELEC and Committee Chair and Vice Chair', 'Regional', 2, 2),
(47, 'COMELEC and Committee Chair and Vice Chair', 'Division', 1, 2),
(48, 'COMELEC and Committee Chair and Vice Chair', 'District / School', 0.75, 2),
(49, 'COMELEC and Committee Member', 'National', 2, 2),
(50, 'COMELEC and Committee Member', 'Regional', 1, 2),
(51, 'COMELEC and Committee Members', 'Division', 0.75, 2),
(52, 'COMELEC and Committee Members', 'District / School', 0.5, 2),
(53, 'Homeroom President', 'District / School', 1, 2),
(54, 'Other Homeroom Officers', 'District / School', 0.75, 2),
(55, 'Other Officers', 'District / School', 0.5, 2),
(56, 'Editor-In-Chief', 'Editor-In-Chief', 6, 3),
(57, 'Associate Editor', 'Associate Editor', 5, 3),
(58, 'Managing Editor', 'Managing Editor', 5, 3),
(59, 'Section Editor', 'Section Editor', 4, 3),
(60, 'Contributor', 'Contributor', 3, 3),
(61, 'Others ', 'Others', 2, 3),
(62, 'International', 'President or Equivalent', 10, 4),
(63, 'International', 'Vice President or Equivalent', 8, 4),
(64, 'International', 'Secretary, Treasurer and Other Officers or Equivalent', 6, 4),
(65, 'International', 'Members', 4, 4),
(66, 'National', 'President or Equivalent', 8, 4),
(67, 'National', 'Vice President or Equivalent', 6, 4),
(68, 'National', 'Secretary, Treasurer and Other Officers or Equivalent', 4, 4),
(69, 'National', 'Members', 3, 4),
(70, 'Regional', 'President or Equivalent', 6, 4),
(71, 'Regional', 'Vice President or Equivalent', 4, 4),
(72, 'Regional', 'Secretary, Treasurer and Other Officers or Equivalent', 3, 4),
(73, 'Regional', 'Members', 2, 4),
(74, 'Division', 'President or Equivalent', 4, 4),
(75, 'Division', 'Vice President or Equivalent', 3, 4),
(76, 'Division', 'Secretary, Treasurer and Other Officers or Equivalent', 2, 4),
(77, 'Division', 'Members', 1.5, 4),
(78, 'District', 'President or Equivalent', 3, 4),
(79, 'District', 'Vice President or Equivalent', 2, 4),
(80, 'District', 'Secretary, Treasurer and Other Officers or Equivalent', 1.5, 4),
(81, 'District', 'Members', 1, 4),
(82, 'School', 'President or Equivalent', 2, 4),
(83, 'School', 'Vice President or Equivalent', 1.5, 4),
(84, 'School', 'Secretary, Treasurer and Other Officers or Equivalent', 1, 4),
(85, 'School', 'Members', 0.75, 4),
(86, 'International', 'International\n', 8, 5),
(87, 'National', 'National', 6, 5),
(88, 'Regional', 'Regional', 4, 5),
(89, 'Division', 'Division', 3, 5),
(90, 'District', 'District\n', 2, 5),
(91, 'School', 'School', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_cc_total`
--

CREATE TABLE `esk_gs_cc_total` (
  `tot_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_st_id` varchar(55) NOT NULL,
  `total` float NOT NULL,
  `grade_id` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `weighted_rank` int(11) NOT NULL,
  PRIMARY KEY (`tot_id`),
  KEY `to_st_id` (`to_st_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_days_present`
--

CREATE TABLE `esk_gs_days_present` (
  `rowid` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `days_id` tinyint(4) NOT NULL COMMENT 'connected with num_school_days',
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
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_assessment`
--

CREATE TABLE `esk_gs_final_assessment` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `first` float NOT NULL,
  `second` float NOT NULL,
  `third` float NOT NULL,
  `fourth` float NOT NULL,
  `final` float NOT NULL,
  `remarks_id` int(11) NOT NULL,
  `school_year` varchar(55) NOT NULL,
  `is_validated` int(11) NOT NULL COMMENT '0 = no; 1 = yes',
  PRIMARY KEY (`as_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_bh_rate`
--

CREATE TABLE `esk_gs_final_bh_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `rate` int(11) NOT NULL,
  `bh_id` int(11) NOT NULL,
  `grading` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_card`
--

CREATE TABLE `esk_gs_final_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `final_rating` float NOT NULL,
  `grading` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `is_final` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_cc_involvement`
--

CREATE TABLE `esk_gs_final_cc_involvement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `rate` float NOT NULL,
  `grading` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_rank`
--

CREATE TABLE `esk_gs_final_rank` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `final_total` float NOT NULL,
  `rank` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_incomplete_subjects`
--

CREATE TABLE `esk_gs_incomplete_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `sy` int(11) NOT NULL,
  `as_of` int(11) NOT NULL COMMENT '0=previous, 1=current',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This is for incomplete subject column in SF5' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_letter_grade`
--

CREATE TABLE `esk_gs_letter_grade` (
  `letter_grade` varchar(5) NOT NULL,
  `description` varchar(55) NOT NULL,
  `from_grade` float NOT NULL,
  `to_grade` float NOT NULL,
  PRIMARY KEY (`letter_grade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_gs_letter_grade`
--

INSERT INTO `esk_gs_letter_grade` (`letter_grade`, `description`, `from_grade`, `to_grade`) VALUES
('A', 'Advance', 90, 100),
('AP', 'Approaching Proficiency', 80, 84.999),
('B', 'Beginning', 0, 74.999),
('D', 'Developing', 75, 79.999),
('P', 'Proficient', 85, 89.999);

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_num_of_sdays_per_year`
--

CREATE TABLE `esk_gs_num_of_sdays_per_year` (
  `school_year` int(11) NOT NULL,
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
  PRIMARY KEY (`school_year`),
  UNIQUE KEY `school_year` (`school_year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_previous_record`
--

CREATE TABLE `esk_gs_previous_record` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `name_of_school` varchar(255) NOT NULL,
  `gen_ave` float NOT NULL,
  `school_year` int(11) NOT NULL,
  `total_years` int(11) NOT NULL,
  `curriculum` varchar(55) NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table for form 137' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_raw_score`
--

CREATE TABLE `esk_gs_raw_score` (
  `raw_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `raw_score` int(11) NOT NULL,
  `assess_id` int(11) NOT NULL,
  `equivalent` float NOT NULL,
  PRIMARY KEY (`raw_id`),
  KEY `assess_id` (`assess_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `esk_gs_settings`
--

CREATE TABLE `esk_gs_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `by_base` int(11) NOT NULL,
  `base` int(11) NOT NULL,
  `formula` varchar(55) NOT NULL,
  `kpup_default` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `gs_used` int(11) NOT NULL,
  `customized` int(11) NOT NULL,
  `used_specialization` int(11) NOT NULL COMMENT 'uses specialization in grade 9 & 10',
  `customized_beh_settings` int(11) NOT NULL,
  `customized_mapeh` int(11) NOT NULL,
  `customized_f137` int(11) NOT NULL,
  `customized_card` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `esk_gs_settings`
--

INSERT INTO `esk_gs_settings` (`id`, `by_base`, `base`, `formula`, `kpup_default`, `school_year`, `gs_used`, `used_specialization`) VALUES
(2, 0, 0, '', 0, 2016, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_specialization`
--

CREATE TABLE `esk_gs_specialization` (
  `specialization_id` int(11) NOT NULL AUTO_INCREMENT,
  `specialization` varchar(300) NOT NULL,
  PRIMARY KEY (`specialization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_gs_specialization`
--

INSERT INTO `esk_gs_specialization` (`specialization_id`, `specialization`) VALUES
(1, 'Information and Communication Technology'),
(2, 'Cookery'),
(3, 'Food and Beverages'),
(4, 'Carpentry'),
(5, 'Bread and Pastry');

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spec_students`
--

CREATE TABLE `esk_gs_spec_students` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_user_id` int(11) NOT NULL,
  `spec_st_id` varchar(55) CHARACTER SET utf8 NOT NULL,
  `spec_taken_id` int(11) NOT NULL,
  `spec_school_year` year(4) NOT NULL,
  PRIMARY KEY (`spec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr`
--

CREATE TABLE `esk_gs_spr` (
  `spr_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `school_name` varchar(55) NOT NULL,
  `school_year` int(11) NOT NULL,
  `go_to_next_level` int(11) NOT NULL COMMENT '1 = is admitted to the next level',
  PRIMARY KEY (`spr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_ar`
--

CREATE TABLE `esk_gs_spr_ar` (
  `ar_id` int(11) NOT NULL AUTO_INCREMENT,
  `spr_id` int(11) NOT NULL,
  `subject_id` tinyint(4) NOT NULL,
  `first` float NOT NULL,
  `second` float NOT NULL,
  `third` float NOT NULL,
  `fourth` float NOT NULL,
  PRIMARY KEY (`ar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_attendance`
--

CREATE TABLE `esk_gs_spr_attendance` (
  `spr_att` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`spr_att`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_sit`
--

CREATE TABLE `esk_gs_spr_sit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` varchar(55) NOT NULL,
  `name_of_test` varchar(255) NOT NULL,
  `date_taken` varchar(55) NOT NULL,
  `score` float NOT NULL,
  `percentile_rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Standard Intelligent Test' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_summary_rplp`
--

CREATE TABLE `esk_gs_summary_rplp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `pro_m` int(11) NOT NULL,
  `pro_f` int(11) NOT NULL,
  `irr_m` int(11) NOT NULL,
  `irr_f` int(11) NOT NULL,
  `re_m` int(11) NOT NULL,
  `re_f` int(11) NOT NULL,
  `b_m` int(11) NOT NULL,
  `b_f` int(11) NOT NULL,
  `d_m` int(11) NOT NULL,
  `d_f` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_f` int(11) NOT NULL,
  `ap_m` int(11) NOT NULL,
  `ap_f` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_f` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Summary Reports on Promotion and Level of Proficiency' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_transmutation`
--

CREATE TABLE `esk_gs_transmutation` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `transmutation` int(11) NOT NULL,
  `from_grade` float NOT NULL,
  `to_grade` float NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `esk_gs_transmutation`
--

INSERT INTO `esk_gs_transmutation` (`trans_id`, `transmutation`, `from_grade`, `to_grade`) VALUES
(1, 100, 100, 100),
(2, 99, 98.4, 99.99),
(3, 98, 96.8, 98.39),
(4, 97, 95.2, 96.79),
(5, 96, 93.6, 95.19),
(6, 95, 92, 93.59),
(7, 94, 90.4, 91.99),
(8, 93, 88.8, 90.39),
(9, 92, 87.2, 88.79),
(10, 91, 85.6, 87.19),
(11, 90, 84, 85.59),
(12, 89, 82.4, 83.99),
(13, 88, 80.8, 82.39),
(14, 87, 79.2, 80.79),
(15, 86, 77.6, 79.19),
(16, 85, 76, 77.59),
(17, 84, 74.4, 75.99),
(18, 83, 72.8, 74.39),
(19, 82, 71.2, 72.79),
(20, 81, 69.6, 71.19),
(21, 80, 68, 69.59),
(22, 79, 66.4, 67.99),
(23, 78, 64.8, 66.39),
(24, 77, 63.2, 64.79),
(25, 76, 61.6, 63.19),
(26, 75, 60, 61.59),
(27, 74, 56, 59.99),
(28, 73, 52, 51.99),
(29, 72, 48, 51.99),
(30, 71, 44, 47.99),
(31, 70, 40, 43.99),
(32, 69, 36, 39.99),
(33, 68, 32, 35.99),
(34, 67, 28, 31.99),
(35, 66, 24, 27.99),
(36, 65, 20, 23.99),
(37, 64, 16, 19.99),
(38, 63, 12, 15.99),
(39, 62, 8, 11.99),
(40, 61, 4, 7.99),
(41, 60, 0, 3.99);


-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_behavior_core_values`
--

CREATE TABLE `esk_gs_behavior_core_values` (
  `core_id` int(11) NOT NULL AUTO_INCREMENT,
  `core_values` varchar(55) NOT NULL,
   PRIMARY KEY (`core_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT = 5;

--
-- Dumping data for table `esk_gs_behavior_core_values`
--

INSERT INTO `esk_gs_behavior_core_values` (`core_id`, `core_values`) VALUES
(1, 'MAKA DIYOS'),
(2, 'MAKA TAO'),
(3, 'MAKA KALIKASAN'),
(4, 'MAKA BANSA');


-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_behavior_rate_customized`
--

CREATE TABLE `esk_gs_behavior_rate_customized` (
  `bhs_id` int(11) NOT NULL AUTO_INCREMENT,
  `bhs_indicators` varchar(300) NOT NULL,
  `bhs_group_id` int(11) NOT NULL,
  PRIMARY KEY (`bhs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Used for customized behavioral statements' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_bh_rate_customized`
--

CREATE TABLE `esk_gs_final_bh_rate_customized` (
  `bhrc_id` int(11) NOT NULL AUTO_INCREMENT,
  `indi_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `term` int(1) NOT NULL,
  `sy` year(4) NOT NULL,
  PRIMARY KEY (`bhrc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_final_bh_rate_cust_trans`
--

CREATE TABLE `esk_gs_final_bh_rate_cust_trans` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `transmutation` varchar(55) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `bs_id` int(11) NOT NULL,
  `trans_info` varchar(55) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE `esk_gs_component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Dumping data for table `esk_gs_component`
--

INSERT INTO `esk_gs_component` (`id`, `component`) VALUES
(1, 'Written Work'),
(2, 'Performance Task'),
(3, 'Quarterly Assessment');

ALTER TABLE `esk_gs_asses_category` ADD `component_id` INT NOT NULL AFTER `code`;

ALTER TABLE `esk_gs_settings` ADD `customized` INT NOT NULL AFTER `gs_used` ;

ALTER TABLE `esk_gs_settings` ADD `customized_calculation` INT NOT NULL AFTER `customized_card`;