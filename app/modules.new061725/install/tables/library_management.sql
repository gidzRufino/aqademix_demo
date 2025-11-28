-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_author`
--

CREATE TABLE `esk_lib_author` (
  `au_id` int(11) NOT NULL,
  `au_name` varchar(100) NOT NULL,
  `au_address` varchar(150) NOT NULL,
  `au_web` varchar(150) NOT NULL,
  `au_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_author`
--

INSERT INTO `esk_lib_author` (`au_id`, `au_name`, `au_address`, `au_web`, `au_email`) VALUES
(1, 'MeiMei', 'Mei Address', 'mei.wang.com', 'no@email.com'),
(2, 'blokblah', 'blah address', 'bah.blah.blah', 'no@blah.com'),
(3, 'blah', 'blah address', 'bah.blah.blah', 'no@blah.com'),
(4, 'testi', 'testi address', 'test.com', 'no@testi.com'),
(5, 'besti', 'besti address', 'besti.com', 'no@besti.com');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_book`
--

CREATE TABLE `esk_lib_book` (
  `bk_id` varchar(25) NOT NULL,
  `bk_gb_id` varchar(25) NOT NULL,
  `bk_pub_id` int(11) NOT NULL,
  `bk_pub_date` varchar(55) NOT NULL,
  `bk_call_num` varchar(50) NOT NULL,
  `bk_access_num` varchar(50) NOT NULL,
  `bk_dimension` varchar(25) NOT NULL,
  `bk_extent` varchar(25) NOT NULL,
  `bk_serial_num` varchar(55) NOT NULL,
  `bk_media_type` varchar(20) NOT NULL,
  `bk_rfid` varchar(150) NOT NULL,
  `bk_st_id` int(11) NOT NULL COMMENT 'changes on every transaction',
  `bk_st_date` varchar(15) NOT NULL COMMENT 'changes on every transaction',
  `bk_cost_price` double NOT NULL,
  `bk_date_acquired` varchar(55) NOT NULL,
  `bk_edition` varchar(55) NOT NULL,
  `bk_copyright_yr` varchar(11) NOT NULL,
  `bk_isbn` varchar(55) NOT NULL,
  `bk_shelf_id` varchar(55) NOT NULL,
  `bk_fn_id` int(11) NOT NULL,
  `bk_borrow_days` int(11) NOT NULL,
  `bk_physical_desc` varchar(150) NOT NULL,
  `bk_source` varchar(50) NOT NULL,
  `bk_tr_id` varchar(25) NOT NULL COMMENT 'changes on every transaction'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_book`
--

INSERT INTO `esk_lib_book` (`bk_id`, `bk_gb_id`, `bk_pub_id`, `bk_pub_date`, `bk_call_num`, `bk_access_num`, `bk_dimension`, `bk_extent`, `bk_serial_num`, `bk_media_type`, `bk_rfid`, `bk_st_id`, `bk_st_date`, `bk_cost_price`, `bk_date_acquired`, `bk_edition`, `bk_copyright_yr`, `bk_isbn`, `bk_shelf_id`, `bk_fn_id`, `bk_borrow_days`, `bk_physical_desc`, `bk_source`, `bk_tr_id`) VALUES
('161013143129-1', '161013142754-031', 1, '2012-10-19', '', '', '', '', '234234234432', '', '', 3, '10/13/16', 250, '2016-10-07', '1', '2012', '34234234', 'Shelf Assignment/Location', 3, 3, 'Black / Brown book', 'School Funds', '1610131431-291'),
('161013143129-2', '161013142754-031', 1, '2012-10-19', '', '', '', '', '234234234432', '', '', 3, '10/13/16', 250, '2016-10-07', '1', '2012', '34234234', 'Shelf Assignment/Location', 3, 3, 'Black / Brown book', 'School Funds', '1610131431-292'),
('161013143129-3', '161013142754-031', 1, '2012-10-19', '', '', '', '', '234234234432', '', '', 3, '10/13/16', 250, '2016-10-07', '1', '2012', '34234234', 'Shelf Assignment/Location', 3, 3, 'Black / Brown book', 'School Funds', '1610131431-293'),
('161013143301-1', '161013143220-031', 1, '', '', '', '', '', 'sdf', '', '', 3, '10/13/16', 0, '', '', '', '', 'Shelf Assignment/Location', 0, 0, '', '', '1610131433-011');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_book_keywords`
--

CREATE TABLE `esk_lib_book_keywords` (
  `bkw_kw_id` int(11) NOT NULL,
  `bkw_gb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_category`
--

CREATE TABLE `esk_lib_category` (
  `ca_id` int(11) NOT NULL,
  `ca_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_category`
--

INSERT INTO `esk_lib_category` (`ca_id`, `ca_category`) VALUES
(1, 'General'),
(2, 'Adults'),
(3, 'Kids'),
(4, 'Teens'),
(5, 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_dewey`
--

CREATE TABLE `esk_lib_dewey` (
  `dw_id` int(11) NOT NULL,
  `dw_dewey_code` varchar(50) NOT NULL,
  `dw_dewey_desc` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_dewey`
--

INSERT INTO `esk_lib_dewey` (`dw_id`, `dw_dewey_code`, `dw_dewey_desc`) VALUES
(1, '000', 'Computer Schience, Information, and General Works'),
(2, '100', 'Philosophy and Psychology'),
(3, '200', 'Religion'),
(4, '300', 'Social Sciences'),
(5, '400', 'Language'),
(6, '500', 'Science'),
(7, '600', 'Technology'),
(8, '700', 'Arts and Recreation'),
(9, '800', 'Literature'),
(10, '900', 'History and Geography');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_dewey_category`
--

CREATE TABLE `esk_lib_dewey_category` (
  `dwc_id` int(11) NOT NULL,
  `dwc_cat_id` double NOT NULL,
  `dwc_description` varchar(100) NOT NULL,
  `dwc_dw_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_dewey_category`
--

INSERT INTO `esk_lib_dewey_category` (`dwc_id`, `dwc_cat_id`, `dwc_description`, `dwc_dw_id`) VALUES
(1, 0, 'Computer science, knowledge & systems', 1),
(2, 10, 'Bibliographies', 1),
(3, 20, 'Library & information sciences', 1),
(4, 30, 'Encyclopedias & books of facts', 1),
(5, 40, '[Unassigned]', 1),
(6, 50, 'Magazines, journals & serials', 1),
(7, 60, 'Associations, organizations & museums', 1),
(8, 70, 'News media, journalism & publishing', 1),
(9, 80, 'Quotations', 1),
(10, 90, 'Manuscripts & rare books', 1),
(11, 100, 'Philosophy', 2),
(12, 110, 'Metaphysics', 2),
(13, 120, 'Epistemology', 2),
(14, 130, 'Parapsychology & occultism', 2),
(15, 140, 'Philosophical schools of thought', 2),
(16, 150, 'Psychology', 2),
(17, 160, 'Logic', 2),
(18, 170, 'Ethics', 2),
(19, 180, 'Ancient, medieval & eastern philosophy', 2),
(20, 190, 'Modern western philosophy', 2),
(21, 200, 'Religion', 3),
(22, 210, 'Philosophy & theory of religion', 3),
(23, 220, 'The Bible', 3),
(24, 230, 'Christianity & Christian theology', 3),
(25, 240, 'Christian practice & observance', 3),
(26, 250, 'Christian pastoral practice & religious orders', 3),
(27, 260, 'Christian organization, social work & worship', 3),
(28, 270, 'History of Christianity', 3),
(29, 280, 'Christian denominations', 3),
(30, 290, 'Other religions', 3),
(31, 300, 'Social sciences, sociology & anthropology', 4),
(32, 310, 'Statistics', 4),
(33, 320, 'Political science', 4),
(34, 330, 'Economics', 4),
(35, 340, 'Law', 4),
(36, 350, 'Public administration & military science', 4),
(37, 360, 'Social problems & social services', 4),
(38, 370, 'Education', 4),
(39, 380, 'Commerce, communications & transportation', 4),
(40, 390, 'Customs, etiquette & folklore', 4),
(41, 400, 'Language', 5),
(42, 410, 'Linguistics', 5),
(43, 420, 'English & Old English languages', 5),
(44, 430, 'German & related languages', 5),
(45, 440, 'French & related languages', 5),
(46, 450, 'Italian, Romanian & related languages', 5),
(47, 460, 'Spanish & Portuguese languages', 5),
(48, 470, 'Latin & Italic languages', 5),
(49, 480, 'Classical & modern Greek languages', 5),
(50, 490, 'Other languages', 5),
(51, 500, 'Science', 6),
(52, 510, 'Mathematics', 6),
(53, 520, 'Astronomy', 6),
(54, 530, 'Physics', 6),
(55, 540, 'Chemistry', 6),
(56, 550, 'Earth sciences & geology', 6),
(57, 560, 'Fossils & prehistoric life', 6),
(58, 570, 'Life sciences; biology', 6),
(59, 580, 'Plants (Botany)', 6),
(60, 590, 'Animals (Zoology)', 6),
(61, 600, 'Technology', 7),
(62, 610, 'Medicine & health', 7),
(63, 620, 'Engineering', 7),
(64, 630, 'Agriculture', 7),
(65, 640, 'Home & family management', 7),
(66, 650, 'Management & public relations', 7),
(67, 660, 'Chemical engineering', 7),
(68, 670, 'Manufacturing', 7),
(69, 680, 'Manufacture for specific uses', 7),
(70, 690, 'Building & construction', 7),
(71, 700, 'Arts', 8),
(72, 710, 'Landscaping & area planning', 8),
(73, 720, 'Architecture', 8),
(74, 730, 'Sculpture, ceramics & metalwork', 8),
(75, 740, 'Drawing & decorative arts', 8),
(76, 750, 'Painting', 8),
(77, 760, 'Graphic arts', 8),
(78, 770, 'Photography & computer art', 8),
(79, 780, 'Music', 8),
(80, 790, 'Sports, games & entertainment', 8),
(81, 800, 'Literature, rhetoric & criticism', 9),
(82, 810, 'American literature in English', 9),
(83, 820, 'English & Old English literatures', 9),
(84, 830, 'German & related literatures', 9),
(85, 840, 'French & related literatures', 9),
(86, 850, 'Italian, Romanian & related literatures', 9),
(87, 860, 'Spanish & Portuguese literatures', 9),
(88, 870, 'Latin & Italic literatures', 9),
(89, 880, 'Classical & modern Greek literatures', 9),
(90, 890, 'Other literatures', 9),
(91, 900, 'History', 10),
(92, 910, 'Geography & travel', 10),
(93, 920, 'Biography & genealogy', 10),
(94, 930, 'History of ancient world (to ca. 499)', 10),
(95, 940, 'History of Europe', 10),
(96, 950, 'History of Asia', 10),
(97, 960, 'History of Africa', 10),
(98, 970, 'History of North America', 10),
(99, 980, 'History of South America', 10),
(100, 990, 'History of other areas', 10),
(102, 200.005, 'test Religion', 3);

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_entity_user`
--

CREATE TABLE `esk_lib_entity_user` (
  `eu_id` int(11) NOT NULL,
  `eu_user_id` int(11) NOT NULL,
  `eu_status` varchar(15) NOT NULL,
  `eu_tot_time` varchar(20) NOT NULL,
  `eu_borrows` int(3) NOT NULL,
  `eu_return_count` varchar(11) NOT NULL,
  `eu_ent_id` int(11) NOT NULL,
  `eu_ent_stat` int(11) NOT NULL COMMENT '0-in, 1-out',
  `eu_last_timestamp` varchar(50) NOT NULL,
  `eu_lhour` varchar(20) NOT NULL,
  `eu_lmin` varchar(20) NOT NULL,
  `eu_remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_entity_user`
--

INSERT INTO `esk_lib_entity_user` (`eu_id`, `eu_user_id`, `eu_status`, `eu_tot_time`, `eu_borrows`, `eu_return_count`, `eu_ent_id`, `eu_ent_stat`, `eu_last_timestamp`, `eu_lhour`, `eu_lmin`, `eu_remarks`) VALUES
(1, 577, 'active', '', 0, '', 0, 0, '', '', '', ''),
(2, 181, 'active', '', 0, '', 0, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_entrance`
--

CREATE TABLE `esk_lib_entrance` (
  `en_id` int(11) NOT NULL,
  `en_eu_id` int(11) NOT NULL,
  `en_time_in` varchar(25) NOT NULL,
  `en_time_out` varchar(25) NOT NULL,
  `en_date_in` varchar(50) NOT NULL,
  `en_date_out` varchar(50) NOT NULL,
  `en_time_total` varchar(25) NOT NULL,
  `en_sy_id` int(3) NOT NULL,
  `en_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_feedback`
--

CREATE TABLE `esk_lib_feedback` (
  `fb_id` int(11) NOT NULL,
  `fb_account_id` int(11) NOT NULL,
  `fb_bk_id` int(11) NOT NULL,
  `fb_ranking` varchar(20) NOT NULL,
  `rb_remarks` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_fines`
--

CREATE TABLE `esk_lib_fines` (
  `fn_id` int(11) NOT NULL,
  `fn_desc` varchar(150) NOT NULL,
  `fn_amount` double NOT NULL,
  `fn_frequency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_general`
--

CREATE TABLE `esk_lib_general` (
  `gb_id` varchar(25) NOT NULL,
  `gb_title` varchar(100) NOT NULL,
  `gb_sub_title` varchar(100) NOT NULL,
  `gb_au_id` int(11) NOT NULL,
  `gb_sub_au_id` int(11) NOT NULL,
  `gb_volume` varchar(55) NOT NULL,
  `gb_dw_id` int(11) NOT NULL,
  `gb_ca_id` int(11) NOT NULL COMMENT 'category id',
  `gb_remarks` varchar(200) NOT NULL,
  `gb_pic` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_general`
--

INSERT INTO `esk_lib_general` (`gb_id`, `gb_title`, `gb_sub_title`, `gb_au_id`, `gb_sub_au_id`, `gb_volume`, `gb_dw_id`, `gb_ca_id`, `gb_remarks`, `gb_pic`) VALUES
('161013142754-031', 'The Book of Mei', '', 1, 0, 'Vol. 1', 0, 1, 'Mei Life', ''),
('161013143220-031', 'temp', '', 1, 0, 'sd', 2, 1, 'sd', '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_keywords`
--

CREATE TABLE `esk_lib_keywords` (
  `kw_id` int(11) NOT NULL,
  `kw_kewords` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_media_type`
--

CREATE TABLE `esk_lib_media_type` (
  `md_id` int(11) NOT NULL,
  `md_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_media_type`
--

INSERT INTO `esk_lib_media_type` (`md_id`, `md_type`) VALUES
(1, 'Book'),
(2, 'Magazine'),
(5, 'DVD'),
(6, 'Newspaper'),
(9, 'Booklet'),
(10, 'Tabloid'),
(11, 'Misc.'),
(12, 'Chart'),
(13, 'Sheet');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_pic`
--

CREATE TABLE `esk_lib_pic` (
  `pc_id` int(11) NOT NULL,
  `pc_gb_id` int(11) NOT NULL,
  `pc_picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_publication`
--

CREATE TABLE `esk_lib_publication` (
  `pub_id` int(11) NOT NULL,
  `pub_publication` varchar(100) NOT NULL,
  `pub_address` varchar(150) NOT NULL,
  `pub_contact_number` varchar(50) NOT NULL,
  `pub_contact_person` varchar(150) NOT NULL,
  `pub_web` varchar(100) NOT NULL,
  `pub_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_publication`
--

INSERT INTO `esk_lib_publication` (`pub_id`, `pub_publication`, `pub_address`, `pub_contact_number`, `pub_contact_person`, `pub_web`, `pub_email`) VALUES
(1, 'Mei publishing', 'Mei Street', '09234234234', 'Mei', 'mei.wang.com', 'no@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_shelf`
--

CREATE TABLE `esk_lib_shelf` (
  `sh_id` int(11) NOT NULL,
  `sh_number` varchar(50) NOT NULL,
  `sh_location_desc` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_status`
--

CREATE TABLE `esk_lib_status` (
  `st_id` int(11) NOT NULL,
  `st_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_status`
--

INSERT INTO `esk_lib_status` (`st_id`, `st_status`) VALUES
(1, 'Borrowed'),
(2, 'Returned'),
(3, 'Available'),
(4, 'Inventoried'),
(5, 'Sold'),
(6, 'Donated'),
(7, 'Damaged - For Repair'),
(8, 'Damaged - Disposed'),
(9, 'Lost');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_topical_term`
--

CREATE TABLE `esk_lib_topical_term` (
  `tt_id` int(11) NOT NULL,
  `tt_topical_term` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_transaction`
--

CREATE TABLE `esk_lib_transaction` (
  `tr_id` varchar(25) NOT NULL,
  `tr_st_id` int(11) NOT NULL,
  `tr_bk_id` varchar(25) NOT NULL,
  `tr_date` varchar(25) NOT NULL,
  `tr_due_date` varchar(25) NOT NULL,
  `tr_staff_id` varchar(25) NOT NULL,
  `tr_eu_id` int(11) NOT NULL,
  `tr_debit` double NOT NULL,
  `tr_credit` double NOT NULL,
  `tr_remarks` varchar(150) NOT NULL,
  `tr_flag` int(1) NOT NULL,
  `tr_ret_date` varchar(25) NOT NULL,
  `tr_hour` varchar(10) NOT NULL,
  `tr_sy_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_transaction`
--

INSERT INTO `esk_lib_transaction` (`tr_id`, `tr_st_id`, `tr_bk_id`, `tr_date`, `tr_due_date`, `tr_staff_id`, `tr_eu_id`, `tr_debit`, `tr_credit`, `tr_remarks`, `tr_flag`, `tr_ret_date`, `tr_hour`, `tr_sy_id`) VALUES
('1610131431-291', 3, '161013143129-1', 'October 13, 2016 (14:31)', '', '0310062', 1, 0, 0, 'Initial setup', 0, '', '', 0),
('1610131431-292', 3, '161013143129-2', 'October 13, 2016 (14:31)', '', '0310062', 1, 0, 0, 'Initial setup', 0, '', '', 0),
('1610131431-293', 3, '161013143129-3', 'October 13, 2016 (14:31)', '', '0310062', 1, 0, 0, 'Initial setup', 0, '', '', 0),
('1610131433-011', 3, '161013143301-1', 'October 13, 2016 (14:33)', '', '0310062', 1, 0, 0, 'Initial setup', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_tt_link`
--

CREATE TABLE `esk_lib_tt_link` (
  `ttl_id` int(11) NOT NULL,
  `ttl_tt_id` int(11) NOT NULL,
  `ttl_gb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_lib_author`
--
ALTER TABLE `esk_lib_author`
  ADD PRIMARY KEY (`au_id`);

--
-- Indexes for table `esk_lib_book`
--
ALTER TABLE `esk_lib_book`
  ADD PRIMARY KEY (`bk_id`);

--
-- Indexes for table `esk_lib_category`
--
ALTER TABLE `esk_lib_category`
  ADD PRIMARY KEY (`ca_id`);

--
-- Indexes for table `esk_lib_dewey`
--
ALTER TABLE `esk_lib_dewey`
  ADD PRIMARY KEY (`dw_id`);

--
-- Indexes for table `esk_lib_dewey_category`
--
ALTER TABLE `esk_lib_dewey_category`
  ADD PRIMARY KEY (`dwc_id`);

--
-- Indexes for table `esk_lib_entity_user`
--
ALTER TABLE `esk_lib_entity_user`
  ADD PRIMARY KEY (`eu_id`),
  ADD UNIQUE KEY `eu_user_id` (`eu_user_id`);

--
-- Indexes for table `esk_lib_entrance`
--
ALTER TABLE `esk_lib_entrance`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `esk_lib_feedback`
--
ALTER TABLE `esk_lib_feedback`
  ADD PRIMARY KEY (`fb_id`);

--
-- Indexes for table `esk_lib_fines`
--
ALTER TABLE `esk_lib_fines`
  ADD PRIMARY KEY (`fn_id`);

--
-- Indexes for table `esk_lib_general`
--
ALTER TABLE `esk_lib_general`
  ADD PRIMARY KEY (`gb_id`);

--
-- Indexes for table `esk_lib_keywords`
--
ALTER TABLE `esk_lib_keywords`
  ADD PRIMARY KEY (`kw_id`);

--
-- Indexes for table `esk_lib_media_type`
--
ALTER TABLE `esk_lib_media_type`
  ADD PRIMARY KEY (`md_id`);

--
-- Indexes for table `esk_lib_pic`
--
ALTER TABLE `esk_lib_pic`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `esk_lib_publication`
--
ALTER TABLE `esk_lib_publication`
  ADD PRIMARY KEY (`pub_id`);

--
-- Indexes for table `esk_lib_shelf`
--
ALTER TABLE `esk_lib_shelf`
  ADD PRIMARY KEY (`sh_id`);

--
-- Indexes for table `esk_lib_status`
--
ALTER TABLE `esk_lib_status`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `esk_lib_topical_term`
--
ALTER TABLE `esk_lib_topical_term`
  ADD PRIMARY KEY (`tt_id`);

--
-- Indexes for table `esk_lib_transaction`
--
ALTER TABLE `esk_lib_transaction`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `esk_lib_tt_link`
--
ALTER TABLE `esk_lib_tt_link`
  ADD PRIMARY KEY (`ttl_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_lib_author`
--
ALTER TABLE `esk_lib_author`
  MODIFY `au_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `esk_lib_category`
--
ALTER TABLE `esk_lib_category`
  MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `esk_lib_dewey`
--
ALTER TABLE `esk_lib_dewey`
  MODIFY `dw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `esk_lib_dewey_category`
--
ALTER TABLE `esk_lib_dewey_category`
  MODIFY `dwc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `esk_lib_entity_user`
--
ALTER TABLE `esk_lib_entity_user`
  MODIFY `eu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `esk_lib_entrance`
--
ALTER TABLE `esk_lib_entrance`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_feedback`
--
ALTER TABLE `esk_lib_feedback`
  MODIFY `fb_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_fines`
--
ALTER TABLE `esk_lib_fines`
  MODIFY `fn_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_keywords`
--
ALTER TABLE `esk_lib_keywords`
  MODIFY `kw_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_media_type`
--
ALTER TABLE `esk_lib_media_type`
  MODIFY `md_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `esk_lib_pic`
--
ALTER TABLE `esk_lib_pic`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_publication`
--
ALTER TABLE `esk_lib_publication`
  MODIFY `pub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_lib_shelf`
--
ALTER TABLE `esk_lib_shelf`
  MODIFY `sh_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_status`
--
ALTER TABLE `esk_lib_status`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `esk_lib_topical_term`
--
ALTER TABLE `esk_lib_topical_term`
  MODIFY `tt_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esk_lib_tt_link`
--
ALTER TABLE `esk_lib_tt_link`
  MODIFY `ttl_id` int(11) NOT NULL AUTO_INCREMENT;