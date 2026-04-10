CREATE TABLE `esk_gs_spr` (
  `spr_id` int(11) NOT NULL,
  `st_id` varchar(55) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `section` varchar(100) DEFAULT NULL,
  `school_name` varchar(55) NOT NULL,
  `school_id` varchar(11) NOT NULL,
  `spr_adviser` varchar(100) DEFAULT NULL,
  `school_year` int(11) NOT NULL,
  `go_to_next_level` int(11) NOT NULL COMMENT '1 = is admitted to the next level',
  `district` varchar(255) NOT NULL,
  `division` varchar(55) NOT NULL,
  `region` varchar(55) NOT NULL,
  `gen_ave` float NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Student Permanent Record';

-- --------------------------------------------------------

--
-- Table structure for table `esk_gs_spr_ar`
--

CREATE TABLE `esk_gs_spr_ar` (
  `ar_id` int(11) NOT NULL,
  `spr_id` int(11) NOT NULL,
  `subject_id` tinyint(4) NOT NULL,
  `first` float NOT NULL,
  `second` float NOT NULL,
  `third` float NOT NULL,
  `fourth` float NOT NULL,
  `avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Academic Record';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attendance Record';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Record of Tardiness';

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
  `sprp_extname` varchar(55) DEFAULT NULL,
  `sprp_gender` varchar(55) DEFAULT NULL,
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
-- Table structure for table `esk_gs_spr_profile_address_info`
--

CREATE TABLE `esk_gs_spr_profile_address_info` (
  `address_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

--
-- Indexes for dumped tables
--

CREATE TABLE `esk_barangay` (
  `barangay_id` int(11) NOT NULL,
  `barangay` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_barangay`
--


CREATE TABLE `esk_provinces` (
  `id` int(11) NOT NULL,
  `province` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_provinces`
--

INSERT INTO `esk_provinces` (`id`, `province`) VALUES
(1, 'Abra'),
(2, 'Agusan del Norte'),
(3, 'Agusan del Sur'),
(4, 'Aklan'),
(5, 'Albay'),
(6, 'Antique'),
(7, 'Apayao'),
(8, 'Aurora'),
(9, 'Basilan'),
(10, 'Bataan'),
(11, 'Batanes'),
(12, 'Batangas'),
(13, 'Benguet'),
(14, 'Biliran'),
(15, 'Bohol'),
(16, 'Bukidnon'),
(17, 'Bulacan'),
(18, 'Cagayan'),
(19, 'Camarines Norte'),
(20, 'Camarines Sur'),
(21, 'Camiguin'),
(22, 'Capiz'),
(23, 'Catanduanes'),
(24, 'Cavite'),
(25, 'Cebu'),
(26, 'Compostela Valley'),
(27, 'Cotabato'),
(28, 'Davao del Norte'),
(29, 'Davao del Sur'),
(30, 'Davao Oriental'),
(31, 'Eastern Samar'),
(32, 'Guimaras'),
(33, 'Ifugao'),
(34, 'Ilocos Norte'),
(35, 'Ilocos Sur'),
(36, 'Iloilo'),
(37, 'Isabela'),
(38, 'Kalinga'),
(39, 'La Union'),
(40, 'Laguna'),
(41, 'Lanao del Norte'),
(42, 'Lanao del Sur'),
(43, 'Leyte'),
(44, 'Maguindanao'),
(45, 'Marinduque'),
(46, 'Masbate'),
(47, 'Metro Manila'),
(48, 'Misamis Occidental'),
(49, 'Misamis Oriental'),
(50, 'Mountain Province'),
(51, 'Negros Occidental'),
(52, 'Negros Oriental'),
(53, 'Northern Samar'),
(54, 'Nueva Ecija'),
(55, 'Nueva Vizcaya'),
(56, 'Occidental Mindoro'),
(57, 'Oriental Mindoro'),
(58, 'Palawan'),
(59, 'Pampanga'),
(60, 'Pangasinan'),
(61, 'Quezon'),
(62, 'Quirino'),
(63, 'Rizal'),
(64, 'Romblon'),
(65, 'Samar'),
(66, 'Sarangani'),
(67, 'Siquijor'),
(68, 'Sorsogon'),
(69, 'South Cotabato'),
(70, 'Southern Leyte'),
(71, 'Sultan Kudarat'),
(72, 'Sulu'),
(73, 'Surigao del Norte'),
(74, 'Surigao del Sur'),
(75, 'Tarlac'),
(76, 'Tawi-Tawi'),
(77, 'Zambales'),
(78, 'Zamboanga del Norte'),
(79, 'Zamboanga del Sur'),
(80, 'Zamboanga Sibugay');

-- --------------------------------------------------------

--
-- Table structure for table `esk_religion`
--

CREATE TABLE `esk_religion` (
  `rel_id` int(11) NOT NULL,
  `religion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--
CREATE TABLE `esk_subjects` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `short_code` varchar(55) NOT NULL,
  `parent_subject` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `is_core` int(11) NOT NULL COMMENT 'used for senior high only'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_subjects`
--

INSERT INTO `esk_subjects` (`subject_id`, `subject`, `short_code`, `parent_subject`, `order`, `is_core`) VALUES
(1, 'English', 'English', 0, 0, 0),
(2, 'Filipino', 'Filipino', 0, 0, 0),
(3, 'Mathematics', 'Math', 0, 0, 0),
(4, 'Science', 'Science', 0, 0, 0),
(5, 'Computer', 'Computer', 0, 0, 0),
(6, 'Edukasyon sa Pagpapakatao', 'Val. Ed', 0, 0, 0),
(8, 'Makabayan', 'Mkbyn', 0, 0, 0),
(9, 'Araling Panlipunan', 'AP', 0, 0, 0),
(10, 'Technology and Livelihood Education', 'TLE', 0, 0, 0),
(12, 'ESP / EP', 'Esp/EP', 0, 0, 0),
(13, 'Music', 'Music', 11, 0, 0),
(14, 'Arts', 'Arts', 11, 0, 0),
(15, 'Physical Education', 'PE', 11, 0, 0),
(16, 'Health', 'Health', 11, 0, 0),
(17, 'BGB-cat', 'BGB\n', 0, 0, 0),
(18, 'MAPEH', 'MAPEH', 0, 0, 0),
(19, 'Mother Tongue', 'Mother Tongue', 0, 0, 0),
(20, 'BGB', 'BGB', 0, 0, 0),
(21, 'HELE', 'hele', 0, 0, 0),
(22, 'Social Studies', 'Social Studies', 0, 0, 0),
(23, 'Civics', 'Civics', 0, 0, 0),
(24, 'Bible', 'Bible', 0, 0, 0),
(25, 'Oral Communication in Context', 'OC', 0, 0, 1),
(26, 'Pathfindering', '', 0, 0, 0),
(27, 'Home Room', '', 0, 0, 0),
(28, 'Work Education', '', 0, 0, 0),
(29, 'Conduct', '', 0, 0, 0),
(30, 'Introduction to World Religions and Belief System', '', 0, 0, 0),
(31, 'Reading', '', 0, 0, 0),
(32, 'Media and Information Literacy', '', 0, 0, 1),
(33, 'Creative Writing', '', 0, 0, 0),
(34, 'Komunikasyon at Pananaliksik sa Wika at Kulturang Filipino', '', 0, 0, 1),
(35, 'General Mathematics', '', 0, 0, 1),
(36, 'Pre-Calculus', '', 0, 0, 0),
(37, 'Earth Science', '', 0, 0, 1),
(38, 'Philosophy of Work 1', '', 0, 0, 0),
(39, 'Entrepreneurship', '', 0, 0, 0),
(40, 'Organization and Management', '', 0, 0, 0),
(41, 'English for Academic and Professional Purposes', '', 0, 0, 0),
(43, 'Physical Education and Health -1', '', 0, 0, 0),
(44, 'Earth and Life Science', '', 0, 0, 1),
(45, 'Teachings of Jesus', '', 0, 0, 0),
(46, 'CAT', '', 0, 0, 0),
(47, 'Practical Research 2', '', 0, 0, 0),
(48, 'Philosophy of Works', '', 0, 0, 0),
(49, 'Introduction to the Philosophy of the Human Person', '', 0, 0, 1),
(50, 'Philippine Politics and Governance', '', 0, 0, 0),
(51, 'Business Finance', '', 0, 0, 0),
(53, 'Edukasyon Pantahanan at Pangkabuhayan', 'EPP', 0, 0, 0),
(54, 'Araling Panlipunan at Filipino (APF)', '', 0, 0, 0),
(55, 'Computer Science', 'Com Scie', 0, 0, 0),
(56, 'Reading and Writing', '', 0, 0, 1),
(57, 'Komunikasyon at Pananaliksik sa Wika at Kulturang Filipino -1', '', 0, 0, 1),
(58, 'Physical Education and Health', '', 0, 0, 1),
(59, '21st Century Literature from the Philippines and the World', '', 0, 0, 1),
(60, 'Media and Introduction Literacy', '', 0, 0, 1),
(61, 'Statistics and Probability', '', 0, 0, 1),
(62, 'Practical Research 1', '', 0, 0, 0),
(63, 'Malikhaing Pagsulat', '', 0, 0, 0),
(64, 'Discipline and Ideas in Social Sciences', '', 0, 0, 0),
(65, 'Understanding Culture', '', 0, 0, 0),
(66, ' Society and Politics', '', 0, 0, 0),
(67, 'Understanding Culture Society and Politics', '', 0, 0, 1),
(68, 'Pagbasa at Pagsusuri ng Iba\'t Ibang Teksto Tungo sa Pananaliksik', '', 0, 0, 1),
(69, 'Creative Nonfiction', '', 0, 0, 0),
(70, 'General Chemistry 1', '', 0, 0, 0),
(71, 'General Chemistry 2', '', 0, 0, 0),
(72, 'Business Mathematics', '', 0, 0, 0),
(73, 'Fundamental of Accountacy and Business Management', '', 0, 0, 0),
(74, 'Practical Research II', '', 0, 0, 0),
(75, 'General Biology 1', '', 0, 0, 0),
(76, 'Fundamentals of Accountancy and Business Management 1', '', 0, 0, 0),
(77, 'General Physics 1', '', 0, 0, 0),
(78, 'General Physics 2', '', 0, 0, 0),
(79, 'Applied Economics', '', 0, 0, 0),
(80, 'Edukasyon sa Pagpapakatao', '', 0, 0, 0),
(81, 'Edukasyon sa Pagpapakatao (ESP)', '', 0, 0, 0),
(82, 'Mother Tongue / Science', '', 0, 0, 0),
(83, 'Math', '', 0, 0, 0),
(84, 'Discipline and Ideas in the Applied Social Sciences', '', 0, 0, 0),
(85, 'Physical Science', '', 0, 0, 1),
(86, 'Fundamentals of Accountancy and Business Management 2', '', 0, 0, 0),
(87, 'Disaster Readiness and Risk Reduction', '', 0, 0, 1),
(88, 'Basic Calculus', '', 0, 0, 0),
(89, 'Personal Development', '', 0, 0, 1),
(90, 'Contemporary Philippine Arts from the Regions', '', 0, 0, 1),
(91, 'Filipino sa Piling Larangan', '', 0, 0, 0),
(92, 'Empowerment Technologies', '', 0, 0, 0),
(93, 'Inquiries', '', 0, 0, 0),
(94, 'Investigation and Immersion', '', 0, 0, 0),
(95, 'Capstone Research', '', 0, 0, 0),
(96, 'General Biology 2', '', 0, 0, 0),
(97, ' Investigation and Immersion', '', 0, 0, 0),
(98, 'Business Enterprise Simulation', '', 0, 0, 0),
(99, 'Business Ethics and Social Responsibility', '', 0, 0, 0),
(100, 'Principles of Marketing', '', 0, 0, 0),
(101, 'Culminating Activity', '', 0, 0, 0),
(102, 'Trends', '', 0, 0, 0),
(103, 'Networks', '', 0, 0, 0),
(104, 'and Critical Thinking in the 21st Century Culture', '', 0, 0, 0),
(105, 'Community Engagement', '', 0, 0, 0),
(106, ' Solidarity and Citizenship', '', 0, 0, 0),
(107, 'Inquiries Investigation and Immersion', '', 0, 0, 0),
(108, ' Investigation and Immersion (ABM)', '', 0, 0, 0),
(109, 'Inquiries Investigation and Immersion (ABM)', '', 0, 0, 0),
(110, 'Inquiries Investigation and Immersion (HUMSS)', '', 0, 0, 0),
(111, 'Inquiries Investigation and Immersion (STEM)', '', 0, 0, 0),
(112, ' Networks', '', 0, 0, 0),
(113, ' and Critical Thinking in the 21st Century', '', 0, 0, 0),
(114, ' Networks and Critical Thinking', '', 0, 0, 0),
(115, 'Trends Networks and Critical Thinking in the 21st Century', '', 0, 0, 0),
(116, 'Community Engagement Solidarity and Citizenship', '', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_subjects`
--
ALTER TABLE `esk_subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_subjects`
--
ALTER TABLE `esk_subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;


--
-- Indexes for table `esk_barangay`
--
ALTER TABLE `esk_barangay`
  ADD PRIMARY KEY (`barangay_id`);

--
-- Indexes for table `esk_cities`
--
ALTER TABLE `esk_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `esk_provinces`
--
ALTER TABLE `esk_provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `esk_religion`
--
ALTER TABLE `esk_religion`
  ADD PRIMARY KEY (`rel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_barangay`
--
ALTER TABLE `esk_barangay`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=664;

--
-- AUTO_INCREMENT for table `esk_cities`
--
ALTER TABLE `esk_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1637;

--
-- AUTO_INCREMENT for table `esk_provinces`
--
ALTER TABLE `esk_provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `esk_religion`
--
ALTER TABLE `esk_religion`
  MODIFY `rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;


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
-- Indexes for table `esk_gs_spr_profile_address_info`
--
ALTER TABLE `esk_gs_spr_profile_address_info`
  ADD PRIMARY KEY (`address_id`);

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
  MODIFY `spr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `esk_gs_spr_ar`
--
ALTER TABLE `esk_gs_spr_ar`
  MODIFY `ar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `esk_gs_spr_attendance`
--
ALTER TABLE `esk_gs_spr_attendance`
  MODIFY `spr_att` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `esk_gs_spr_attendance_tardy`
--
ALTER TABLE `esk_gs_spr_attendance_tardy`
  MODIFY `spr_tardy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `esk_gs_spr_profile`
--
ALTER TABLE `esk_gs_spr_profile`
  MODIFY `sprp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `esk_gs_spr_profile_address_info`
--
ALTER TABLE `esk_gs_spr_profile_address_info`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `esk_gs_spr_sit`
--
ALTER TABLE `esk_gs_spr_sit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
