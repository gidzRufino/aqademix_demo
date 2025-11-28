-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 09, 2019 at 03:37 AM
-- Server version: 5.6.38
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `eskwela.ccsa_2018`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_book`
--

CREATE TABLE `esk_lib_book` (
  `bk_id` varchar(25) NOT NULL,
  `bk_gb_id` varchar(25) DEFAULT NULL,
  `bk_pub_id` int(11) DEFAULT NULL,
  `bk_pub_date` varchar(55) DEFAULT NULL,
  `bk_serial_num` varchar(55) DEFAULT NULL,
  `bk_media_type` varchar(20) DEFAULT NULL,
  `bk_call_number` varchar(25) DEFAULT NULL,
  `bk_rfid` varchar(150) DEFAULT NULL,
  `bk_st_id` int(11) NOT NULL COMMENT 'changes on every transaction',
  `bk_st_date` varchar(15) NOT NULL COMMENT 'changes on every transaction',
  `bk_cost_price` double DEFAULT NULL,
  `bk_date_acquired` varchar(55) DEFAULT NULL,
  `bk_edition` varchar(55) DEFAULT NULL,
  `bk_copyright_yr` varchar(11) DEFAULT NULL,
  `bk_isbn` varchar(55) DEFAULT NULL,
  `bk_shelf_id` varchar(55) DEFAULT NULL,
  `bk_fn_id` int(11) DEFAULT NULL,
  `bk_borrow_days` int(11) DEFAULT NULL,
  `bk_physical_desc` varchar(150) DEFAULT NULL,
  `bk_source` varchar(50) DEFAULT NULL,
  `bk_tr_id` varchar(25) NOT NULL COMMENT 'changes on every transaction'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_book`
--

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
(2, 'Pre-School'),
(3, 'Grade School'),
(4, 'High School'),
(5, 'Faculty'),
(6, 'Staff');

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
(100, 990, 'History of other areas', 10);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_lib_entity_user`
--


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
  `gb_sub_title` varchar(100) DEFAULT NULL,
  `gb_series_statement` text,
  `gb_au_id` int(11) DEFAULT NULL,
  `gb_author` varchar(50) DEFAULT NULL,
  `gb_co_author` varchar(100) DEFAULT NULL,
  `gb_periodical_title` varchar(100) DEFAULT NULL,
  `gb_sor` varchar(225) DEFAULT NULL,
  `gb_volume` varchar(55) DEFAULT NULL,
  `gb_dw_id` int(11) DEFAULT NULL,
  `gb_dw` varchar(100) DEFAULT NULL,
  `gb_ca_id` int(11) DEFAULT NULL COMMENT 'category id',
  `gb_remarks` text,
  `gb_pic` varchar(55) DEFAULT NULL,
  `gb_topical_terms` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_general`
--

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
(1, 'Alpha Books,', 'Indianapolis, IN :', '', '', '', ''),
(2, 'Amulet Books,', 'New York: NY', '', '', '', ''),
(3, 'Greystone Books,', 'Vancouver, Canada', '', '', '', ''),
(4, 'Michael Wiese Productions', 'Studio City, CA', '', '', '', ''),
(5, 'Random House Canada', 'Toronto, Canada:', '', '', '', ''),
(6, 'Penguin Group,', 'New York, NY:', '', '', '', ''),
(7, 'Anvil Publishing,', 'Pasig, Metro Manila, Philippines:', '', '', '', ''),
(8, 'National Book Store', 'Manila, Philippines:', '', '', '', ''),
(9, 'New York : Grosset & Dunlap, ©2003.', '', '', '', '', ''),
(10, 'Tangerine Press,', '', '', '', '', ''),
(11, 'Philippines : Lampara Publishing Hous Inc. ', '', '', '', '', ''),
(12, 'Brookfield : Millbrook Press', '', '', '', '', ''),
(13, 'Philippines : Philippine Publishing House', '', '', '', '', ''),
(14, 'U.S.A : Scholastic Inc.', '', '', '', '', ''),
(15, 'New York, NY: Tangerine Press', '', '', '', '', ''),
(16, 'New York : Scholastic Press', '', '', '', '', ''),
(17, 'Vancouver/Toronto : Whitecap Books', '', '', '', '', ''),
(18, 'Ontario: Canada: Crabtree Publishing Company', '', '', '', '', ''),
(19, 'London : Harper Collins Children\'s Books', '', '', '', '', ''),
(20, 'Milwaukee : Gareth Stevens Pub., ', '', '', '', '', ''),
(21, 'United States of America : Disney Enterprises ', '', '', '', '', ''),
(22, 'New York : Little Simon', '', '', '', '', ''),
(23, 'Woodbridge, Connecticut: A Blackbirch Press Book', '', '', '', '', ''),
(24, 'Great Britain : Penguin Group ', '', '', '', '', ''),
(25, 'New York : Gareth Stevens Children\'s Book ', '', '', '', '', ''),
(26, 'New York, NY: Gloucester Press', '', '', '', '', ''),
(27, 'Boston : Allyn and Bacon', '', '', '', '', ''),
(28, 'United States of America : Rourke Enterprises, Inc.', '', '', '', '', ''),
(29, 'New York, NY : McGraw Hill', '', '', '', '', ''),
(30, 'U.S.A : Western Publishing Company, Inc.', '', '', '', '', ''),
(31, 'New York : Scholastic', '', '', '', '', ''),
(32, 'United States of America : H.B. Productions, Inc. ', '', '', '', '', ''),
(33, 'India : Sunrise Publishers', '', '', '', '', ''),
(34, 'Brookfield, Connecticut : Twenty-First Century Books', '', '', '', '', ''),
(35, 'United States of America : Simon & Schuster Source', '', '', '', '', ''),
(36, 'San Diego, California : Lucent Books', '', '', '', '', ''),
(37, 'Hungary : Exley Publications,', '', '', '', '', ''),
(38, 'Philippines : Straight Lines International', '', '', '', '', ''),
(39, 'Hong Kong : Brimar Publishing Inc., ', '', '', '', '', ''),
(40, 'California : Oxmoor House', '', '', '', '', ''),
(41, 'United Kingdom : Beaufoy publishing Limited, ', '', '', '', '', ''),
(42, 'Cambridge, Massachusetts : The MIT Press', '', '', '', '', ''),
(43, 'New York : Facts on File, Inc., ', '', '', '', '', ''),
(44, 'New York, NY: Vintage Books', '', '', '', '', ''),
(45, 'China : Miles Kelly Publishing Ltd., ', '', '', '', '', ''),
(46, 'United States of America : Reading Challenge, Inc., ', '', '', '', '', ''),
(47, 'New York, NY : Teachers College Press', '', '', '', '', ''),
(48, 'Scarborough, Ontario : Nelson Canada', '', '', '', '', ''),
(49, 'Mattituck, NY : Nick Murray Company', '', '', '', '', ''),
(50, 'U.S.A : McClanahan Book Company ', '', '', '', '', ''),
(51, 'Melbourne, Australia : Cambridge University Press', '', '', '', '', ''),
(52, 'New York : Amulet Books ', '', '', '', '', ''),
(53, 'Canada : Scholastic Canada Ltd. ', '', '', '', '', ''),
(54, 'New York : Chelsea House Publishers', '', '', '', '', ''),
(55, 'Canada : Methuen Children\'s Books Ltd. ', '', '', '', '', ''),
(56, 'Springfield, Jew Jersey : Enslow Publishers', '', '', '', '', ''),
(57, 'Sydney : ABC Books', '', '', '', '', ''),
(58, 'New York : Simon Spotlight', '', '', '', '', ''),
(59, 'New York : Atlantic Monthly Press', '', '', '', '', ''),
(60, 'Nashville, TN. : Make  Believe Ideas', '', '', '', '', ''),
(61, 'New York : Comapny\'s Coming Publishing Limited, ', '', '', '', '', ''),
(62, 'Copenhagen : DJOF Publishing', '', '', '', '', ''),
(63, 'Philippines : OMF Literature Inc.', '', '', '', '', ''),
(64, 'Rocklin, California : Forum', '', '', '', '', ''),
(65, 'New York : Grosset & Dunlap, ', '', '', '', '', ''),
(66, 'New York : Facts On File', '', '', '', '', ''),
(67, 'United States of America : National Geographic Society ', '', '', '', '', ''),
(68, 'Canada : Aladdin Paperbacks ', '', '', '', '', ''),
(69, 'New York : Scholastic Inc.', '', '', '', '', ''),
(70, 'New York : Zebra Books', '', '', '', '', ''),
(71, 'Western Florida : Warner Bros. Entertainment ', '', '', '', '', ''),
(72, 'Madaluyong City : OMF Literature ', '', '', '', '', ''),
(73, 'Mandaluyong City : OMF Literature ', '', '', '', '', ''),
(74, 'Joshua Morris Publishing ', '', '', '', '', ''),
(75, 'China : Sterling Publishing Co., Inc.', '', '', '', '', ''),
(76, 'New York : Doubleday', '', '', '', '', ''),
(77, '[Racine, Wis.] : Western Pub. Co. ; [New York] : Children\'s Television Workshop, ', '', '', '', '', ''),
(78, 'London : Usborne ', '', '', '', '', ''),
(79, 'United States of America : Penguin Group (USA) Inc., ', '', '', '', '', ''),
(80, 'Toronto : Grolier', '', '', '', '', ''),
(81, 'Franklin, Tennessee : Dalmatian Press', '', '', '', '', ''),
(82, 'New York : Paragon, ', '', '', '', '', ''),
(83, 'United States of America : Chicken Soup Publishing, LLC ', '', '', '', '', ''),
(84, 'London : BBC Children\'s Books', '', '', '', '', ''),
(85, 'Toronto, Canada : Vintage Canada', '', '', '', '', ''),
(86, 'Canada : Coles, ', '', '', '', '', ''),
(87, 'Place of Publication not identified : Houghton Miffin Company, ', '', '', '', '', ''),
(88, '[Place of Publication not identified] : Houghton Miffin Company, ', '', '', '', '', ''),
(89, 'Canada : McGraw-Hill Ryerson Limited ', '', '', '', '', ''),
(90, 'New York : Disney Press, ', '', '', '', '', ''),
(91, 'New Jersey : Crescent Books', '', '', '', '', ''),
(92, 'New York : Faith Words', '', '', '', '', ''),
(93, 'London : Orion Children\'s Book, ', '', '', '', '', ''),
(94, 'New York : Viking, Penguin Group', '', '', '', '', ''),
(95, 'Cambridge : Candlewick Press', '', '', '', '', ''),
(96, 'Bath, UK : Paragon Publishing', '', '', '', '', ''),
(97, 'China : Global Educational System [GES] Ltd., ', '', '', '', '', ''),
(98, 'Uhrichsville, OH : Barbour Publishing', '', '', '', '', ''),
(99, 'Philippines : Harvest House Publishers, ', '', '', '', '', ''),
(100, 'New York, NY : Kensington books', '', '', '', '', ''),
(101, 'United States of America : Random House, Inc., ', '', '', '', '', ''),
(102, 'San Diego, California : Lucent Books', '', '', '', '', ''),
(103, 'New York : Golden Book', '', '', '', '', ''),
(104, 'United States of America : Penguin Putnam Inc., ', '', '', '', '', ''),
(105, 'Santa Fe, New Mexico : John Muir Publications', '', '', '', '', ''),
(106, 'New York : Random House ', '', '', '', '', ''),
(107, 'New York, NY : Avon', '', '', '', '', ''),
(108, 'United States of America : Little, Brown & Company (Canada) Limited ', '', '', '', '', ''),
(109, 'Quezon City : Shepherds Voice, ', '', '', '', '', ''),
(110, 'California : Disney Enterprises', '', '', '', '', ''),
(111, 'Toronto : International thompson Publishing, ', '', '', '', '', ''),
(112, 'Toronto : International Thompson Publishing, ', '', '', '', '', ''),
(113, 'Chicago : Advance Publishers ', '', '', '', '', ''),
(114, 'China : Nelson Price Milburn Ltd. ', '', '', '', '', ''),
(115, 'New York : Beginner Books', '', '', '', '', ''),
(116, 'New York, NY : Warwick Press', '', '', '', '', ''),
(117, 'Canada : Pearson Education ', '', '', '', '', ''),
(118, 'Elgin, IL : New Dawn Press', '', '', '', '', ''),
(119, 'Singapore : SAP Group Pte Ltd. ', '', '', '', '', ''),
(120, 'Quezon City : Adarna House Inc. ', '', '', '', '', ''),
(121, 'Toronto, Ontario : McClelland & Stewart', '', '', '', '', ''),
(122, 'Canada : Methuen Children\'s Books Ltd. ', '', '', '', '', ''),
(123, 'London : Collins Educational', '', '', '', '', ''),
(124, 'New York : Orchard Books, ', '', '', '', '', ''),
(125, 'New York : Holiday House', '', '', '', '', ''),
(126, 'New York : Puffin Books', '', '', '', '', ''),
(127, 'London : Egmont, ', '', '', '', '', ''),
(128, 'Geel, Belgium : Peter Haddock Publishing', '', '', '', '', ''),
(129, 'Austin, Texas : Raintree Steck-Vaughn', '', '', '', '', ''),
(130, 'Allex,Tex : Barney Pub., ', '', '', '', '', ''),
(131, 'Canada : Borealis Press, Limited ', '', '', '', '', ''),
(132, 'New York : Thomas Y. Crowell', '', '', '', '', ''),
(133, 'Canada : Ginn and Company Educational Publishers', '', '', '', '', ''),
(134, 'Canada : Mayer Games Inc.,', '', '', '', '', ''),
(135, 'Berkhamsted, UK : Make Believe Ideas', '', '', '', '', ''),
(136, 'Colorado Springs, CO : International Bible Society, ', '', '', '', '', ''),
(137, 'New York : Benchmark Books', '', '', '', '', ''),
(138, 'United States of America : Bantam Doubleday Dell books for Young Readers, ', '', '', '', '', ''),
(139, 'Mankato, Minn. : QEB Publishing', '', '', '', '', ''),
(140, 'Manila : Anvil Publishing Inc., ', '', '', '', '', ''),
(141, 'Philippines : Booklore Publishing Group, ', '', '', '', '', ''),
(142, 'Manila : Unleash International Corporation, ', '', '', '', '', ''),
(143, 'Auburn Maine, USA : Ladybird Books, ', '', '', '', '', ''),
(144, 'Canmore, Alberta : Altitude Publishing Canada', '', '', '', '', ''),
(145, 'Gosfrod, NSW : Scholastic Australia', '', '', '', '', ''),
(146, 'China : Scholastic Inc., ', '', '', '', '', ''),
(147, 'Alberta, Canada : Reading Wings', '', '', '', '', ''),
(148, 'United States of America : Word Publishing ', '', '', '', '', ''),
(149, 'North Mankato, Minn. : Smart Apple Media', '', '', '', '', ''),
(150, 'United States of America : Hachette Book Group ', '', '', '', '', ''),
(151, 'Dominguez Hills, CA : Educational Insights', '', '', '', '', ''),
(152, 'Hong Kong : Macmillan Education Autrilia Pty Ltd., ', '', '', '', '', ''),
(153, 'California : Worlds of Wonder Inc., ', '', '', '', '', ''),
(154, 'London : Raintree', '', '', '', '', ''),
(155, 'New York, NY : Simon & Schuster', '', '', '', '', ''),
(156, 'Chicago, Illinois : Heinenmann Library', '', '', '', '', ''),
(157, 'Lincolnwood, Illinois : Publications International', '', '', '', '', ''),
(158, 'New York : Riverhead Books', '', '', '', '', ''),
(159, 'New York : Henry Holt and Company', '', '', '', '', ''),
(160, 'United States : Abdo Consulting Group, Inc.,', '', '', '', '', ''),
(161, 'New York : Harmony Books', '', '', '', '', ''),
(162, 'U.S.A : The Standard Publishing Company ', '', '', '', '', ''),
(163, 'New York : Modern Publishing', '', '', '', '', ''),
(164, 'Canada : Walt Disney Enterprises, ', '', '', '', '', ''),
(165, 'Minneapolis : Lerner Publications Company', '', '', '', '', ''),
(166, 'Canada : Everytown Inc. ', '', '', '', '', ''),
(167, 'England : Wayland', '', '', '', '', ''),
(168, 'New York : Greenwillow Books', '', '', '', '', ''),
(169, 'Calgary : Weigl', '', '', '', '', ''),
(170, 'Pleasantville, New York : The Reader\'s Digest Association', '', '', '', '', ''),
(171, 'Quezon City : Lampara Publication House, ', '', '', '', '', ''),
(172, 'Aukland, New Zealand : Shortland Publications', '', '', '', '', ''),
(173, 'New York : American Girl, LCC, ', '', '', '', '', ''),
(174, 'London : Headline Book Publishing', '', '', '', '', ''),
(175, 'Hong Kong : Caillou Productions Inc., ', '', '', '', '', ''),
(176, 'New York : Quill William Morrow', '', '', '', '', ''),
(177, 'New York : DK Publishing', '', '', '', '', ''),
(178, 'New York : Franklin Watts', '', '', '', '', ''),
(179, 'New York : Pocket Books', '', '', '', '', ''),
(180, 'London : Gambit Publications', '', '', '', '', ''),
(181, 'London : Gambit Publications', '', '', '', '', ''),
(182, 'New York : Aladdin Paperbacks', '', '', '', '', ''),
(183, 'New York : Harper & Row Publishers', '', '', '', '', ''),
(184, 'England : Brimax Books', '', '', '', '', ''),
(185, 'New York : The Viking Press', '', '', '', '', ''),
(186, 'Alberta, Canada : Lone Pine Publishing', '', '', '', '', ''),
(187, 'New York : Clarion Books', '', '', '', '', ''),
(188, 'New York : Alfred A. Knopf', '', '', '', '', ''),
(189, 'New York : MacMillan Publishing', '', '', '', '', ''),
(190, 'Toronto : University of Toronto Press', '', '', '', '', ''),
(191, 'New York : Flash Point', '', '', '', '', ''),
(192, 'New York : Roaring Brook Press', '', '', '', '', ''),
(193, 'Canada : Whitecap Books, ', '', '', '', '', ''),
(194, 'Hong Kong : Free Spirit Publishing Inc., ', '', '', '', '', ''),
(195, 'Madaluyong City, Metro Manila : Hiyas ', '', '', '', '', ''),
(196, 'Linden, NJ : Grandreams', '', '', '', '', ''),
(197, 'New York : Bantam Books', '', '', '', '', ''),
(198, 'Canada : Stoddart Publishing', '', '', '', '', ''),
(199, 'Montreal, Canada : Phidal Publishing', '', '', '', '', ''),
(200, 'Pasig City : Anvil Pub., ', '', '', '', '', ''),
(201, 'England : Lion Publishing', '', '', '', '', ''),
(202, 'Chanhassen, Minn. : NorthWord Press, ', '', '', '', '', ''),
(203, 'U.S.A : The Viking Press ', '', '', '', '', ''),
(204, 'New York : Hyperion Books for Children', '', '', '', '', ''),
(205, 'New York : Lerner Publications Company ', '', '', '', '', ''),
(206, 'Toronto : Scholastic', '', '', '', '', ''),
(207, 'China : School Specialty Children\'s Publishing', '', '', '', '', ''),
(208, 'Racine, Wisconsin : Western Publishing', '', '', '', '', ''),
(209, 'New York : Crabtree Publishing Company ', '', '', '', '', ''),
(210, 'New York : Camden House Publishing, ', '', '', '', '', ''),
(211, 'Edmonton, Canada : Creative Publishing', '', '', '', '', ''),
(212, 'Toronto : Greey de Pencier Books', '', '', '', '', ''),
(213, 'Canada : Grolier Limited ', '', '', '', '', ''),
(214, 'United Stated of America : F+W Publication, Inc.,', '', '', '', '', ''),
(215, 'Ontario : Pokeweed Press', '', '', '', '', ''),
(216, 'United States of America : Troll Associates, ', '', '', '', '', ''),
(217, 'San Diego, CA : Greenhaven Press', '', '', '', '', ''),
(218, 'Aiea, Hawaii : Island Heritage Pub., ', '', '', '', '', ''),
(219, 'Washington, DC. : Review and Herald Pub. Association,', '', '', '', '', ''),
(220, 'Hong Kong : Greey de Pencier Books Inc., ', '', '', '', '', ''),
(221, 'London : Picture Lions ', '', '', '', '', ''),
(222, 'London : Dorling Kindersley', '', '', '', '', ''),
(223, 'London : Orion Children\'s Book ', '', '', '', '', ''),
(224, 'USA : Parker Brothers', '', '', '', '', ''),
(225, 'Milwaukee. WI : World Almanac Library', '', '', '', '', ''),
(226, 'Slough, Berkshire : Rising Sun', '', '', '', '', ''),
(227, 'Great britain : Harper Collins Publishers', '', '', '', '', ''),
(228, 'Canada : Webcom Limited ', '', '', '', '', ''),
(229, 'Danbury, Connecticut : Childs World/Grolier', '', '', '', '', ''),
(230, 'Winnipeg, MB : Great Plains Publications', '', '', '', '', ''),
(231, 'Toronto, Ontario : Canada', '', '', '', '', ''),
(232, 'Toronto, Ontario : White Knight Publications', '', '', '', '', ''),
(233, 'San Rafael, CA : Amber-Allen Publshing', '', '', '', '', ''),
(234, 'New York : Amy Einhorn Books', '', '', '', '', ''),
(235, 'Boston : Houghton, Miffin, ', '', '', '', '', ''),
(236, 'Edmonton, AB : Innovation Expedition', '', '', '', '', ''),
(237, 'Toronto, Canada : Irwin Publising', '', '', '', '', ''),
(238, 'Wayzara, Minnesota : Learnig Strategies Corporation', '', '', '', '', ''),
(239, 'Wayzata, Minnesota : Learnig Strategies Corporation', '', '', '', '', ''),
(240, 'Philippine : Eternal Publications ', '', '', '', '', ''),
(241, 'Austin, Texas : Steck-Vaugh', '', '', '', '', ''),
(242, 'Cambridge, Massachusetts : South End Press', '', '', '', '', ''),
(243, 'Columbus, Ohio : Waterbird Books', '', '', '', '', ''),
(244, 'Hong Kong : Scholastic Canada Ltd., ', '', '', '', '', ''),
(245, 'England : Castle Street Press', '', '', '', '', ''),
(246, 'Stanford, California : Stanford University Press', '', '', '', '', ''),
(247, 'Lutherville, MD : Flying Frog Publishing', '', '', '', '', ''),
(248, 'Canada : Vancouver Natural History Society ', '', '', '', '', ''),
(249, 'Chicago : Moody Press', '', '', '', '', ''),
(250, 'New York : Newbridge Educational Publishing ', '', '', '', '', ''),
(251, 'California : Klutz', '', '', '', '', ''),
(252, 'Berkeley, California : Seal Press', '', '', '', '', ''),
(253, 'Canada : [publisher not identified]', '', '', '', '', ''),
(254, 'Colorado Springs : Authentic Publishing ', '', '', '', '', ''),
(255, 'London : Robinson', '', '', '', '', ''),
(256, 'New York, N.Y. : inchworm Press, ', '', '', '', '', ''),
(257, 'New York, N.Y. : Inchworm Press, ', '', '', '', '', ''),
(258, 'Malaysia : Capstone Press, ', '', '', '', '', ''),
(259, 'London : Coronet Books', '', '', '', '', ''),
(260, 'East St. Paul, Manitoba : Blueberry Hill Publications', '', '', '', '', ''),
(261, 'New York : Farrar, Straus and Giroux', '', '', '', '', ''),
(262, 'New York : Golden Press', '', '', '', '', ''),
(263, 'Vancouver, Canada : Alive Books', '', '', '', '', ''),
(264, 'Chicago : Kidsbooks, ', '', '', '', '', ''),
(265, 'U.S.A. : Children Press, ', '', '', '', '', ''),
(266, 'Minneapolis, Minn : Dilon Press, ', '', '', '', '', ''),
(267, 'New York : Wonder Books', '', '', '', '', ''),
(268, 'Ontario : Scholastic Book Fairs', '', '', '', '', ''),
(269, 'Carthage, Illinois : Fearon Teacher Aids', '', '', '', '', ''),
(270, 'North Mankato, Minn. : Picture Window Books ', '', '', '', '', ''),
(271, 'Flagstaff, Arizona : Northland Publishing', '', '', '', '', ''),
(272, 'New York : Peter Bedrick Book', '', '', '', '', ''),
(273, 'Cambridge, Massachusetts : Barefoot Books', '', '', '', '', ''),
(274, 'United Kingdom : Tony Potter Publishing, ', '', '', '', '', ''),
(275, 'Hemel Hempstead : Macdonald Young Books', '', '', '', '', ''),
(276, 'Quezon City : Rex Book Store, Inc. ', '', '', '', '', ''),
(277, 'Quezon City : LORIMAR Publishing Inc., ', '', '', '', '', ''),
(278, 'U.S.A : Puffin Books, ', '', '', '', '', ''),
(279, 'Manila : Inovative Educational Materials, Inc., ', '', '', '', '', ''),
(280, 'Manila, Philippines : Philippine Publishing House, ', '', '', '', '', ''),
(281, 'Manila : Rex Book Store, ', '', '', '', '', ''),
(282, 'Sywell : Igloo', '', '', '', '', ''),
(283, 'New York : Mouse Works', '', '', '', '', ''),
(284, 'Singapore : Educational Publishing House Pte Ltd.', '', '', '', '', ''),
(285, 'Singapore : Educational Publishing House Pte Ltd., ', '', '', '', '', ''),
(286, 'Quezon City : C & E Pub. Inc., ', '', '', '', '', ''),
(287, 'Philippines : Abiva Publishing House Inc., ', '', '', '', '', ''),
(288, 'Cebu City : Ropredave Book Supply & Gen. MDSE, ', '', '', '', '', ''),
(289, 'London : Penguin Books', '', '', '', '', ''),
(290, 'Columbus, Ohio : Gingham Dog Press', '', '', '', '', ''),
(291, 'British Columbia, Canada : Biologic Publishing', '', '', '', '', ''),
(292, '[Place of publication not identified] : Legato Publications, ', '', '', '', '', ''),
(293, 'British Columbia, Canada : Biologic Publishing', '', '', '', '', ''),
(294, 'British Columbia, Canada : Biologic Publishing', '', '', '', '', ''),
(295, 'British Columbia, Canada : Biologic Publishing', '', '', '', '', ''),
(296, 'British Columbia, Canada : Biologic Publishing', '', '', '', '', ''),
(297, 'British Columbia, Canada : Biologic Publishing', '', '', '', '', ''),
(298, 'British Columbia : Biologic Publishing', '', '', '', '', ''),
(299, 'Vancouver, Canada : Greystone Books', '', '', '', '', ''),
(300, 'New York : W.W. Norton & Co', '', '', '', '', ''),
(301, 'Toronto : Kids Can Press', '', '', '', '', ''),
(302, 'United States : Zarrella Publications', '', '', '', '', ''),
(303, 'New Jersey : Troll Associates', '', '', '', '', ''),
(304, 'Mankato, Minn. : Capstone Press', '', '', '', '', ''),
(305, 'United States od America : United States Department of the Interior, Fish and Wildlife Service', '', '', '', '', ''),
(306, 'Boston : Houghton Mifflin Company', '', '', '', '', ''),
(307, 'England : Brown Watson, ', '', '', '', '', ''),
(308, 'Philippines : Wise Books Marketing, ', '', '', '', '', ''),
(309, 'New York : Aladdin Books', '', '', '', '', ''),
(310, 'Quezon City : Shepherd\'s Voice Publications, Inc., ', '', '', '', '', ''),
(311, 'New Delhi : Sterling Press Private Limited', '', '', '', '', ''),
(312, 'New York : McClanahan Book Company', '', '', '', '', ''),
(313, 'New York : Bantam Doubleday Dell Publishing Group, Inc. ', '', '', '', '', ''),
(314, 'Sydney, Australia : McGraw-Hill Australia', '', '', '', '', ''),
(315, 'Pasig City : Anvil Publishing Inc., ', '', '', '', '', ''),
(316, 'London : Prospero Books', '', '', '', '', ''),
(317, 'Philadelphia : Chelsea House Publishers', '', '', '', '', ''),
(318, 'Victoria, Australia : Five Mile Press', '', '', '', '', ''),
(319, 'New York : Disney Enterprises, Inc.,', '', '', '', '', ''),
(320, 'Ada, OK : Garrett Educational Corporation', '', '', '', '', ''),
(321, 'San Francisco : Chronicle Books', '', '', '', '', ''),
(322, 'New York : Playmore', '', '', '', '', ''),
(323, 'Allen, Texas : Lyrick Publishing', '', '', '', '', ''),
(324, 'Reading, Mass. : Addison-Wesley Publication', '', '', '', '', ''),
(325, 'New York : Harper Collins Publishers, ', '', '', '', '', ''),
(326, 'Mankato, MN : Weigl Publishers', '', '', '', '', ''),
(327, 'New York, N.Y. : Scholastic Inc., ', '', '', '', '', ''),
(328, 'Portugal : Usborne Publishing Ltd., ', '', '', '', '', ''),
(329, 'Chicago, III. : Heinemann Library, ', '', '', '', '', ''),
(330, 'Philippines : Lampara Publishing House, Inc., ', '', '', '', '', ''),
(331, 'New York : Muppet Press', '', '', '', '', ''),
(332, 'Toronto : McGraw-Hill Ryerson', '', '', '', '', ''),
(333, 'Quezon City : ISA-JECHO Publishing Inc., ', '', '', '', '', ''),
(334, 'Richmond Hill, Ontario : Scholastic Book Services', '', '', '', '', ''),
(335, 'Philippines : Sound Publishing Corporation, ', '', '', '', '', ''),
(336, 'United States of America : Time-life Films, Inc., ', '', '', '', '', ''),
(337, 'Philippines : New Day Publishers, ', '', '', '', '', ''),
(338, 'New York : Simon Spotlight/Nick Jr.', '', '', '', '', ''),
(339, 'Mandaluyong City : National Book Store, ', '', '', '', '', ''),
(340, '[Worthington, Ohio] : Willowisp Press', '', '', '', '', ''),
(341, 'Pasig City, Philippines ; Anvil Publishing Inc., ', '', '', '', '', ''),
(342, 'Burbank, Ca. : Walt Disney Records', '', '', '', '', ''),
(343, 'Quezon City : Vibal Foundation Inc., ', '', '', '', '', ''),
(344, 'Singapore : Media Masters', '', '', '', '', ''),
(345, 'Philippines : National Book Store, ', '', '', '', '', ''),
(346, 'Vero Beach, Fla. : Rourke', '', '', '', '', ''),
(347, 'Nevada, California : Dawn Publications', '', '', '', '', ''),
(348, 'New York : Antheneum Books for Young Readers', '', '', '', '', ''),
(349, 'Quezon City : Shepherd\'s Voice Publications, Inc., ', '', '', '', '', ''),
(350, 'New York : Golden Books', '', '', '', '', ''),
(351, 'New York : Rosen Pub. Group', '', '', '', '', ''),
(352, 'United States : Simon & Schuster, Inc., ', '', '', '', '', ''),
(353, 'United States : Simon & Schuster, Inc., ', '', '', '', '', ''),
(354, 'New York : Lark Books', '', '', '', '', ''),
(355, 'Philippines : CKC Publications, ', '', '', '', '', ''),
(356, 'Dubuque, IA : Wm. C. Brown Publishers', '', '', '', '', ''),
(357, 'Toronto, Canada : Annick Press', '', '', '', '', ''),
(358, 'Boston, Mass. : Pearson', '', '', '', '', ''),
(359, 'New York : Viking Kestrel', '', '', '', '', ''),
(360, 'Alexandria, Va. : Association for Supervision and Curriculum Development', '', '', '', '', ''),
(361, 'Mandaluyong : National Book Store, ', '', '', '', '', ''),
(362, 'Milwaukee, Wis. : Ideals Pub. Corp.', '', '', '', '', ''),
(363, 'New York : Disney Press/ Grolier Enterprises', '', '', '', '', ''),
(364, 'London : Brockhampton Press', '', '', '', '', ''),
(365, '[Singapore?] : Child\'s Play International', '', '', '', '', ''),
(366, 'Chicago : Childrens Press', '', '', '', '', ''),
(367, 'Philippines : Pacific Press Publishing Association, ', '', '', '', '', ''),
(368, 'Philippines : Pacific Press Publishing Association, ', '', '', '', '', ''),
(369, 'New York : OXFORD UNIVERSITY PRESS, ', '', '', '', '', ''),
(370, 'New York : Sterling Children\'s Books', '', '', '', '', ''),
(371, 'United States of America : Harper Collins Publishers Ltd., ', '', '', '', '', ''),
(372, 'New York : McGraw-Hill, ', '', '', '', '', ''),
(373, 'New York : North-South Books, ', '', '', '', '', ''),
(374, 'Burnaby, B.C. : Canasia Toys and Gifts Inc.', '', '', '', '', ''),
(375, 'U.S.A : Grolier Limited, ', '', '', '', '', ''),
(376, 'Cambridge ; United Kingdom : Cambridge University Press', '', '', '', '', ''),
(377, 'Don Mills, Ont. : Tribute Publishing,', '', '', '', '', ''),
(378, 'Montréal : Chouette Pub.,', '', '', '', '', ''),
(379, 'U.S.A : EDC PUBLISHING, ', '', '', '', '', ''),
(380, 'Ontario, Canada : Trifolium Books', '', '', '', '', ''),
(381, 'Bristol, PA : Sandvik Innovations', '', '', '', '', ''),
(382, 'London : Hodder Children\'s', '', '', '', '', ''),
(383, 'San Francisco, Calif. : Jossey-Bass', '', '', '', '', ''),
(384, 'Ontario, Canada : Camden House Publishing, ', '', '', '', '', ''),
(385, 'Thousand Oaks, Calif. : Sage Publications', '', '', '', '', ''),
(386, 'Calgary : Springbank Publishing', '', '', '', '', ''),
(387, 'Philadelphia, PA : Running Press Book Publishers', '', '', '', '', ''),
(388, 'Toronto, Canada : John Wiley & Sons Canada', '', '', '', '', ''),
(389, 'New York : Atheneum Books for Young Readers, ', '', '', '', '', ''),
(390, 'Durham : Duke University Press', '', '', '', '', ''),
(391, 'New York : Children\'s Press, ', '', '', '', '', ''),
(392, 'Hoboken, N.J. : John Wiley & Sons', '', '', '', '', ''),
(393, 'Philippines : Philippine Book Company, ', '', '', '', '', ''),
(394, 'Mississauga, Ontario : John Wiley & Sons Canada', '', '', '', '', ''),
(395, 'Chicago : Kidsbooks,', '', '', '', '', ''),
(396, 'Toronto : Key Porter Books', '', '', '', '', ''),
(397, 'Huntington Beach, CA : Creative Teaching Press', '', '', '', '', ''),
(398, 'Champaign, IL : Human Kinetics', '', '', '', '', ''),
(399, 'Richmond Hill, Ont. : Scholastic Canada,', '', '', '', '', ''),
(400, 'Toronto : HarperCollins, ', '', '', '', '', ''),
(401, '[Washington, D.C.] : National Geographic Society', '', '', '', '', ''),
(402, 'Toronto : McClelland and Stewart Limited,', '', '', '', '', ''),
(403, 'New York : Downtown Bookworks', '', '', '', '', ''),
(404, 'United States of America : Bethany House Publishers, ', '', '', '', '', ''),
(405, 'Colorado Springs, Colorado : Waterbrook Press,', '', '', '', '', ''),
(406, 'London : Coran Octopus', '', '', '', '', ''),
(407, 'New York : Simon & Schuster,', '', '', '', '', ''),
(408, 'St. Paul, MN : Voyageur Press', '', '', '', '', ''),
(409, 'St. Paul, MN : Voyageur Press', '', '', '', '', ''),
(410, 'Brookfield, Conn. : Copper Beech Books', '', '', '', '', ''),
(411, 'Toronto : Maple Tree Press', '', '', '', '', ''),
(412, 'New York : Grosset & Dunlap', '', '', '', '', ''),
(413, 'New York : Little, Brown and Company, ', '', '', '', '', ''),
(414, 'United States : Yankee Publishing Incorporated, ', '', '', '', '', ''),
(415, 'Parada, Valenzuela City : S.G.E. Publishing, Inc., ', '', '', '', '', ''),
(416, 'Manila, Philippines : OMF LITERATURE INC., ', '', '', '', '', ''),
(417, 'United States of America : Thomas Nelson, Inc., ', '', '', '', '', ''),
(418, 'United States of America : Tommy Nelson, Inc., ', '', '', '', '', ''),
(419, 'New York : Grosset & Dunlap,', '', '', '', '', ''),
(420, 'Intercourse, PA : Good Books', '', '', '', '', ''),
(421, 'New York, NY : Skyhorse Publication', '', '', '', '', ''),
(422, 'New York : Scholastic Press/Callaway', '', '', '', '', ''),
(423, 'North Mankato, MN : Thameside Press', '', '', '', '', ''),
(424, 'New York : Barron\'s Educational Series', '', '', '', '', ''),
(425, 'San Diego : Harcourt Brace', '', '', '', '', ''),
(426, 'Bath : Netscribes', '', '', '', '', ''),
(427, 'Springfield, Mass. : Federal Street Press', '', '', '', '', ''),
(428, '[Chanhassen, MN] : Child\'s World', '', '', '', '', ''),
(429, 'New York : Workman Publication', '', '', '', '', ''),
(430, 'New York : Sterling Publishing Corporation', '', '', '', '', ''),
(431, 'New York : Thomson Learning', '', '', '', '', ''),
(432, 'Mahwah, N.J. : Watermill Press', '', '', '', '', ''),
(433, 'Chicago : World Book', '', '', '', '', ''),
(434, 'New York : Weigl Publishers', '', '', '', '', ''),
(435, 'New York : Jump at the Sun/Hyperion Books for Children,', '', '', '', '', ''),
(436, 'Toronto : Scholastic Canada,', '', '', '', '', ''),
(437, 'New York : St. Martin\'s Griffin', '', '', '', '', ''),
(438, 'Toronto : Random House Canada', '', '', '', '', ''),
(439, 'Manila, Philippines : Palinsad General Merchandise, ', '', '', '', '', ''),
(440, 'Philippines : Vinsprint, Inc., ', '', '', '', '', ''),
(441, 'Toronto, Ont. : McClelland & Stewart', '', '', '', '', ''),
(442, 'Philippines : MD Reprographics, ', '', '', '', '', ''),
(443, 'Philippines : MG Reprographics, ', '', '', '', '', ''),
(444, 'Danbury, CT : Scholastic', '', '', '', '', ''),
(445, 'Toronto : Doubleday Canada', '', '', '', '', ''),
(446, 'New York : Houghton Mifflin Company, ', '', '', '', '', ''),
(447, 'United States of America : Sourcebooks, Inc., ', '', '', '', '', ''),
(448, 'Quezon City, Philippines : Claretian Publiction, ', '', '', '', '', ''),
(449, 'Halfmoon Bay, B.C. : Caitlin Press', '', '', '', '', ''),
(450, 'New York : Philomel Books', '', '', '', '', ''),
(451, 'Edison, NJ : Chartwell Books', '', '', '', '', ''),
(452, 'Quezon City : Silver Burdett Company, ', '', '', '', '', ''),
(453, '[New York] : Rich Press', '', '', '', '', ''),
(454, 'Markham, Ont. : Scholastic Canada', '', '', '', '', ''),
(455, 'Great Britain : Dorling Kindersley Limited, ', '', '', '', '', ''),
(456, 'Canada : Fifth House Publishers, ', '', '', '', '', ''),
(457, 'New Delhi : Rupa Publication India Pvt. Ltd., ', '', '', '', '', ''),
(458, 'United States of America : Penguin Books, ', '', '', '', '', ''),
(459, 'Canada : Harcourt Brace Jovanovich, Inc., ', '', '', '', '', ''),
(460, 'Waco, Tex. : Prufrock Press', '', '', '', '', ''),
(461, 'Quezon City, Philippines : Alay Pinoy Publishing House, ', '', '', '', '', ''),
(462, 'Irvine, Calif. : QEB Pub.', '', '', '', '', ''),
(463, 'New York : Square Fish, ', '', '', '', '', ''),
(464, 'New York : Random House, ', '', '', '', '', ''),
(465, 'Great Britain : Penguin Group, ', '', '', '', '', ''),
(466, 'New York : Morrow Junior Books', '', '', '', '', ''),
(467, 'United States of America : William Morrow and Company, Inc., ', '', '', '', '', ''),
(468, 'La Jolla, California : Kane/Miller Book Publishers,', '', '', '', '', ''),
(469, 'London : New Holland Publishers, ', '', '', '', '', ''),
(470, 'United States of America : Pleasant World,', '', '', '', '', ''),
(471, 'China : Choutte Publishing Inc. and CINAR Corporation, ', '', '', '', '', ''),
(472, 'New York : Aladdin Paperbacks,', '', '', '', '', ''),
(473, 'Philippines : Anvil Publishing Inc.,', '', '', '', '', ''),
(474, 'Laguna Hills, Calif. : Walter Foster Pub.', '', '', '', '', ''),
(475, 'Manila, Philippines : Rex Book Store, ', '', '', '', '', ''),
(476, 'New York : Lothrop, Lee & Shepard Books', '', '', '', '', ''),
(477, 'Toronto : Douglas & McIntyre', '', '', '', '', ''),
(478, 'San Francisco, CA : Sierra Club Books for Children', '', '', '', '', ''),
(479, 'Chicago : American Library Association', '', '', '', '', ''),
(480, 'Laguna Hills, CA : QEB', '', '', '', '', ''),
(481, 'Victoria, British Columbia : Sono Nis Press,', '', '', '', '', ''),
(482, 'New York : Macmillan Publishing Company, ', '', '', '', '', ''),
(483, 'Los Angeles : JEREMY P. TARCHER, INC., ', '', '', '', '', ''),
(484, 'New York : Bantam Skylark,', '', '', '', '', ''),
(485, 'Berkeley, Calif. : Ten Speed Press', '', '', '', '', ''),
(486, 'Greendale, WI : Reiman Media Group', '', '', '', '', ''),
(487, 'Downers Grove, Ill. : InterVarsity Press,', '', '', '', '', ''),
(488, '[New York] : [Playmore Inc./Waldman],', '', '', '', '', ''),
(489, 'Manila : Lampara Books, ', '', '', '', '', ''),
(490, 'London : Moonlight', '', '', '', '', ''),
(491, 'New York, NY : St. Martin\'s Press', '', '', '', '', ''),
(492, 'Milwaukee, Wisconsin : Rethinking Schools', '', '', '', '', ''),
(493, 'New York : Penguin Books', '', '', '', '', ''),
(494, 'London : Tick Tock', '', '', '', '', ''),
(495, 'Austin, Tex. : Hells Canyon Publication', '', '', '', '', ''),
(496, 'United States of America : Focus on the Family Publishing, ', '', '', '', '', ''),
(497, 'Cambridge : Worth Press', '', '', '', '', ''),
(498, 'New York : Avon Books, ', '', '', '', '', ''),
(499, 'New York : Gotham Books', '', '', '', '', ''),
(500, 'Calgary : Script Publishing Inc., ', '', '', '', '', ''),
(501, 'New York : Perennial', '', '', '', '', ''),
(502, 'New York : Harper Entertainment, ', '', '', '', '', ''),
(503, 'New York : Three Rivers Press', '', '', '', '', ''),
(504, 'Washington, D.C. : National Geographic Society, ', '', '', '', '', ''),
(505, 'Guelph, Ont. : Surviving Adversity', '', '', '', '', ''),
(506, 'Avon, Massachusetts : Adams Media', '', '', '', '', ''),
(507, 'New York : Innovative Kids, ', '', '', '', '', ''),
(508, 'Allen, Tex. : Big Red Chair Books,', '', '', '', '', ''),
(509, 'London : Dean', '', '', '', '', ''),
(510, 'Tondo, MAnila : Loacan Publishing House, ', '', '', '', '', ''),
(511, 'Tondo, Manila : Loacan Publishing House, ', '', '', '', '', ''),
(512, 'United States of America : Pleasant Company Publications, ', '', '', '', '', ''),
(513, 'Toronto : Scholastic Canada Ltd., ', '', '', '', '', ''),
(514, 'Toronto : Douglas & McIntyre, ', '', '', '', '', ''),
(515, 'Boston : Houghton Mifflin Company, ', '', '', '', '', ''),
(516, 'New York : Dalmatian Press, ', '', '', '', '', ''),
(517, '[Columbus, NC] : Peel Productions ', '', '', '', '', ''),
(518, 'New York : Scholastic Inc., ', '', '', '', '', ''),
(519, 'Singapore : Compass Production, ', '', '', '', '', ''),
(520, 'Canada : Pencier Books, ', '', '', '', '', ''),
(521, 'Toronto : James Lorimer & Company Publishers, ', '', '', '', '', ''),
(522, 'Michigan, USA : Zondervan Publishing, ', '', '', '', '', ''),
(523, 'Lincolnwood, Illinois : Publication International, Ltd., ', '', '', '', '', ''),
(524, 'Jenkintown, Pa. : American Anti-Vivisection Society, ', '', '', '', '', ''),
(525, 'New York : The Mysterious Press, ', '', '', '', '', ''),
(526, 'Vancouver : Drew Marketing & Productions, ', '', '', '', '', ''),
(527, 'New York : Kingfisher, ', '', '', '', '', ''),
(528, 'New Delhi : New Dawn Press Group, ', '', '', '', '', ''),
(529, 'Vero Beach, Florida : The Rourke Book Co., Inc., ', '', '', '', '', ''),
(530, 'United States of America : Grolier Enterprises, Inc., ', '', '', '', '', ''),
(531, 'New York : Reed International Book Australia Ltd., ', '', '', '', '', ''),
(532, '[U.S.A] : Scholastic, ', '', '', '', '', ''),
(533, '[U.S.A?] : Scholastic, ', '', '', '', '', ''),
(534, 'Henderson Road, Singapore : Singapore Asina Publication., ', '', '', '', '', ''),
(535, 'London : Titan Books', '', '', '', '', ''),
(536, 'Oak Brook, Illinois : Institute in Basic Youth Conflicts', '', '', '', '', ''),
(537, '[Publisher not identified]', '', '', '', '', ''),
(538, 'New York : Cartwheel Books ', '', '', '', '', ''),
(539, 'Florida : Advance Publishers', '', '', '', '', ''),
(540, 'Greensboro,  North Carolina : Spectrum,', '', '', '', '', ''),
(541, 'Singapore : Farfield Book Publishers,', '', '', '', '', ''),
(542, 'New York : McGraw-Hill Education, ', '', '', '', '', ''),
(543, 'United States of America : Lyrick Publishing, ', '', '', '', '', ''),
(544, 'New Delhi : Maanu Graphics, ', '', '', '', '', ''),
(545, 'Pasay City : VINSPRINT, INC., ', '', '', '', '', ''),
(546, 'China : Alligator Books Limited, ', '', '', '', '', ''),
(547, 'United States of America : SP Publications, Inc., ', '', '', '', '', ''),
(548, '[Canada] : Hal Leonard Corporation, ', '', '', '', '', ''),
(549, 'United States of America : McGraw-Hill Companies, ', '', '', '', '', ''),
(550, 'United States of America : Nelson Doubleday, Inc. and Odhams Books Ltd., ', '', '', '', '', ''),
(551, 'United States of America : Back to the Bible Publishers, ', '', '', '', '', ''),
(552, 'United States of America : Baker Book House Company, ', '', '', '', '', ''),
(553, 'U.S.A : Scholastic Inc., ', '', '', '', '', ''),
(554, 'United States of America : HarperCollins Publishers, ', '', '', '', '', ''),
(555, 'Danbury, Conn. : Grolier', '', '', '', '', ''),
(556, 'United States of America : Simon & Schuster Childre\'s Publishing Division, ', '', '', '', '', ''),
(557, '[Mahwah, NJ] : Troll Communications L.L.C., ', '', '', '', '', ''),
(558, '[San Francisco, California?] : HarperSanFrancisco, ', '', '', '', '', ''),
(559, 'Austin, Texas : Steck-Vaughn Company, ', '', '', '', '', ''),
(560, 'Canada : Fitzhenry & Whiteside, ', '', '', '', '', ''),
(561, 'New York : Nancy Hall, Inc., ', '', '', '', '', ''),
(562, 'Regina : Coteau Books,', '', '', '', '', ''),
(563, 'New York : Dover Publications,', '', '', '', '', ''),
(564, 'Toronto, Canada : Random House Canada, ', '', '', '', '', ''),
(565, 'New York, New York : Bantam Doubleday Dell Books, ', '', '', '', '', ''),
(566, 'Hong Kong : Learning Media Limited, ', '', '', '', '', ''),
(567, '[Washington, D.C.] : National Wildlife Federation', '', '', '', '', ''),
(568, 'Belgium : Aladdin Books Ltd., ', '', '', '', '', ''),
(569, 'Brookfield, Conn. : Cooper Beech Books', '', '', '', '', ''),
(570, 'New York : Alfred A. Knopf, Inc. : Distributed by Random House, 1990.', '', '', '', '', ''),
(571, 'Chicago, IL : Kidsbooks', '', '', '', '', ''),
(572, 'New Delhi : Steling Press Private Limited, ', '', '', '', '', ''),
(573, 'New Delhi : Steling Press Private Limited, ', '', '', '', '', ''),
(574, 'Milwaukee : Gareth Stevens Childen\'s Books, ', '', '', '', '', ''),
(575, 'Bath : Parragon', '', '', '', '', ''),
(576, 'Ontario, Canada : Maple Tree Press Inc., ', '', '', '', '', ''),
(577, 'Mandaluyong City : OMF Literature, Inc. ', '', '', '', '', ''),
(578, 'Mandaluyong City : OMF Literature, Inc.,', '', '', '', '', ''),
(579, 'Manila : 827 Publications, ', '', '', '', '', ''),
(580, 'Don Mills, Ont. : Harlequin Teen,', '', '', '', '', ''),
(581, 'Edinburgh : Saint Andrew Press, ', '', '', '', '', ''),
(582, 'Cambridge, MA : Candlewick Press, ', '', '', '', '', ''),
(583, 'U.S.A : Howell Book House, ', '', '', '', '', ''),
(584, 'Vancouver, B.C : whitecap Books, ', '', '', '', '', ''),
(585, 'Vancouver, B.C : Whitecap Books, ', '', '', '', '', ''),
(586, 'London : Penguin Group, ', '', '', '', '', ''),
(587, 'Canmore, Alta. : Altitude Pub. Canada,', '', '', '', '', ''),
(588, 'Minneapolis, MN : Free Spirit Publication,', '', '', '', '', ''),
(589, 'Minneapolis, MN : Free Spirit Pub., ', '', '', '', '', ''),
(590, 'New York, NY : MONDO Pub.', '', '', '', '', ''),
(591, 'Toronto : Nelson Canada, ', '', '', '', '', ''),
(592, 'Singapore : Fairfield Book Publishers, ', '', '', '', '', ''),
(593, 'Philippines : Technology Resources Center, ', '', '', '', '', ''),
(594, 'Philippines : Bookware Publishing Corporation, ', '', '', '', '', ''),
(595, 'Canada : Penguin Group, ', '', '', '', '', ''),
(596, 'United States of America : Simon & Schuster Inc., ', '', '', '', '', ''),
(597, 'New York : Workman Publication, ', '', '', '', '', ''),
(598, 'Canada : HrperCollins Publishers Ltd., ', '', '', '', '', ''),
(599, 'Canada : HarperCollins Publishers Ltd., ', '', '', '', '', ''),
(600, 'Toronto : Penguin Canada, ', '', '', '', '', ''),
(601, 'Toronto : Stoddart Kids, ', '', '', '', '', ''),
(602, 'Morton Grove, Illinois, Albert Whitman & Company, ', '', '', '', '', ''),
(603, 'London : Walker Books Ltd., ', '', '', '', '', ''),
(604, 'Mahwah, N.J. : Troll Associates,', '', '', '', '', ''),
(605, 'New York : Crescent Books', '', '', '', '', ''),
(606, 'Wheaton, IL : Tyndale for Kids', '', '', '', '', ''),
(607, 'Wheaton, Illinois  : Crossway Books,', '', '', '', '', ''),
(608, 'London : Faber and Faber, ', '', '', '', '', ''),
(609, 'New York : Basic Books, ', '', '', '', '', ''),
(610, 'Grand Rapids, MI : Zondervan, ', '', '', '', '', ''),
(611, 'New York : Poptropica,', '', '', '', '', ''),
(612, 'London : Little Tiger Press', '', '', '', '', ''),
(613, 'Quezon City : KEN Incorporated,', '', '', '', '', ''),
(614, 'Maplewood, NJ : Blue Apple Books', '', '', '', '', ''),
(615, 'Phildelphia : J.B. Lippincott Company, ', '', '', '', '', ''),
(616, 'Philippines : Great Book Publishing, ', '', '', '', '', ''),
(617, 'Philippines : Harmony Publishing House', '', '', '', '', ''),
(618, 'Deerfield Beach, Florida : Health Communications Inc., ', '', '', '', '', ''),
(619, 'New York : Crown Publishers, Inc., ', '', '', '', '', ''),
(620, 'New York : Atria Books', '', '', '', '', ''),
(621, '[Ottawa] : Scouts Canada National Council, ', '', '', '', '', ''),
(622, 'Toronto, Ontario : Tundra Books of Northern New York, ', '', '', '', '', ''),
(623, 'London : Routledge', '', '', '', '', ''),
(624, 'Montreal : Lobster Press, ', '', '', '', '', ''),
(625, '[U.S.A] : Grolier Educational Group, ', '', '', '', '', ''),
(626, 'Oxford : New Internationalist', '', '', '', '', ''),
(627, 'Toronto : Grolier Limited, ', '', '', '', '', ''),
(628, 'Toronto : Grolier Limited, ', '', '', '', '', ''),
(629, 'Philippines : Philippines Graphic Arts, Inc., ', '', '', '', '', ''),
(630, 'Toronto, Canada : Stoddart Publishing Co. Limited, ', '', '', '', '', ''),
(631, 'Emmaus, Pa : Rodale Press, ', '', '', '', '', ''),
(632, 'Minnesota : Harvest House Publisher,', '', '', '', '', ''),
(633, 'United States of America : NavPress, ', '', '', '', '', ''),
(634, 'United States of America : Lerner Publications Company, ', '', '', '', '', ''),
(635, 'Philadelphia : Quirk Books, ', '', '', '', '', ''),
(636, 'New York, NY : HarperCollins Publishers, ', '', '', '', '', ''),
(637, 'Garden City, N.Y. : Doubleday, ', '', '', '', '', ''),
(638, 'Toronto : Stoddart', '', '', '', '', ''),
(639, 'Manila, Pihilippines : OMF Literature Inc.', '', '', '', '', ''),
(640, 'New York : John Wiley & Sons', '', '', '', '', ''),
(641, 'New York : Oxford University Press', '', '', '', '', ''),
(642, 'Franklin Lakes, N.J. : Career Press', '', '', '', '', ''),
(643, 'Pickering, Ont. : BayRidge Books', '', '', '', '', ''),
(644, 'Pickering, Ont. : BayRidge Books', '', '', '', '', ''),
(645, 'New York : Western Publishing Company, Inc., ', '', '', '', '', ''),
(646, 'Milwaukee, WI : World Almanac Library', '', '', '', '', ''),
(647, 'Batangas City : MGH Enterprises, ', '', '', '', '', ''),
(648, 'Honesdale, Penn. : Boyds Mills Press', '', '', '', '', ''),
(649, 'Austin [Tex.] : Holt, Rinehart and Winston', '', '', '', '', ''),
(650, 'U.S.A : Impact Publications, ', '', '', '', '', ''),
(651, 'Canada : Safe Play Press, ', '', '', '', '', ''),
(652, 'New York : Workman Publishing', '', '', '', '', ''),
(653, 'U.S.A : Dalmatian Press, ', '', '', '', '', ''),
(654, 'New York, N.Y. : Gallery Books', '', '', '', '', ''),
(655, 'Palo Alto, California : Klutz, ', '', '', '', '', ''),
(656, 'U.S.A : Dalmatian Publishing Group, LLC, ', '', '', '', '', ''),
(657, 'Toronto : Robert Rose, ', '', '', '', '', ''),
(658, 'Chicago : World Book, ', '', '', '', '', ''),
(659, 'Edina, Minn. : Abdo & Daughters ', '', '', '', '', ''),
(660, 'Crystal Lake, Ill. : Rigby Education', '', '', '', '', ''),
(661, 'New York : Bradbury Press', '', '', '', '', ''),
(662, 'London : Red Fox', '', '', '', '', ''),
(663, 'New York  : Mulberry Paperback', '', '', '', '', ''),
(664, 'UK : Miles Kelly Publlishing Ltd., ', '', '', '', '', ''),
(665, 'UK : Miles Kelly Publishing Ltd., ', '', '', '', '', ''),
(666, 'United States of America : Disney Book Group, ', '', '', '', '', ''),
(667, 'New York : Penguin Group, ', '', '', '', '', ''),
(668, 'New Delhi : B. Jain Publishers Ltd., ', '', '', '', '', ''),
(669, 'China : Simon & Schuster Children\'s Publishing Division, ', '', '', '', '', ''),
(670, 'New York, New York : Reader\'s Digest Children\'s Books, ', '', '', '', '', ''),
(671, 'New York : Teaching Resources, ', '', '', '', '', ''),
(672, 'Hauppauge, NY : Barron\'s', '', '', '', '', ''),
(673, 'London : Hermes House', '', '', '', '', ''),
(674, '[Washington, D.C.] : National Geographic Society, ', '', '', '', '', ''),
(675, '[London?] : Tick Tock', '', '', '', '', ''),
(676, 'London : Puffin', '', '', '', '', ''),
(677, 'Chicago : Children\'s Press', '', '', '', '', ''),
(678, 'London : Capella/Arcturus Publishing', '', '', '', '', ''),
(679, 'Carol Stream, IL : Tyndale House Publishers', '', '', '', '', ''),
(680, 'Calgary : Venture Guiding', '', '', '', '', ''),
(681, 'London : Harper Collins Publishers', '', '', '', '', ''),
(682, 'New York : Hyperion Books', '', '', '', '', ''),
(683, 'Tulsa, Oklahoma : Harrison House', '', '', '', '', ''),
(684, 'New York : Marshall Cavendish', '', '', '', '', ''),
(685, 'New York : Marshall Cavendish', '', '', '', '', ''),
(686, 'Boston, Mass. : Pearson Prentice Hall', '', '', '', '', ''),
(687, 'Nashville : Royal Publishers', '', '', '', '', ''),
(688, 'New York, Time, Inc.', '', '', '', '', ''),
(689, 'Pleasantville, NY : Reader\'s Digest Young Families, ', '', '', '', '', ''),
(690, '[Canada] : Annick Press, ', '', '', '', '', ''),
(691, '[New York] : Time-Life Films,', '', '', '', '', ''),
(692, 'Montréal, Québec ; Plattsburgh, N.Y. : Tundra Books,', '', '', '', '', ''),
(693, 'Minneapolis : Carolrhoda Books', '', '', '', '', ''),
(694, 'Chanhassen, Minn. : NorthWord Press, ', '', '', '', '', ''),
(695, 'Makati, Plippines : Sound Publishing Corporation, ', '', '', '', '', ''),
(696, 'Brooklyn, NY : Handprint Books,', '', '', '', '', ''),
(697, 'New York : Learning Triangle Press', '', '', '', '', ''),
(698, '[United States] : Mouse Works : Distributed by Buena Vista Pictures Distribution Inc.,', '', '', '', '', ''),
(699, 'Bridlington, England : Peter Haddock Ltd. ', '', '', '', '', ''),
(700, 'Grand Rapids : Fideler Company', '', '', '', '', ''),
(701, 'London : Hamlyn', '', '', '', '', ''),
(702, 'London : Mercury Junior', '', '', '', '', ''),
(703, 'New York : Price Stern Sloan', '', '', '', '', ''),
(704, 'Orlando : Harcourt,', '', '', '', '', ''),
(705, 'New York : Time Books', '', '', '', '', ''),
(706, 'Henley-on-Thames : Atlantic Europe, ', '', '', '', '', ''),
(707, 'New York, NY : Torstar Books', '', '', '', '', ''),
(708, 'United Kingdom : Atlantic Europe Publishing Company Limited, ', '', '', '', '', ''),
(709, 'Austrilia : Atlantic Europe Publishing Company Limited, ', '', '', '', '', ''),
(710, 'New York : Tangerine Press,', '', '', '', '', ''),
(711, 'Wigston, Leicestershire : Southwater', '', '', '', '', ''),
(712, '[Washington] : National Geographic Society,', '', '', '', '', ''),
(713, 'New York : Walker, ', '', '', '', '', ''),
(714, 'Minneapolis, MN : Lerner Publications Co., ', '', '', '', '', ''),
(715, 'U.S.A : Kevin M. & Thomas W. Donovan,', '', '', '', '', ''),
(716, 'London : Usborne Publishing, ', '', '', '', '', ''),
(717, 'Pampanga : Brainworld Publishing ; Manila : ISP International', '', '', '', '', ''),
(718, 'Stow, OH : Twin Sisters', '', '', '', '', ''),
(719, 'Grand Rapids, Mich. : Baker Books,', '', '', '', '', ''),
(720, 'New Delhi, India : Young Lerner Publications, ', '', '', '', '', ''),
(721, 'London : Aladdin Books', '', '', '', '', ''),
(722, 'London : Artus Publishing Company', '', '', '', '', ''),
(723, 'China : Hinkler Books Pty. Ltd., ', '', '', '', '', ''),
(724, 'London : Dorling Kindersly,  ', '', '', '', '', ''),
(725, 'New York : Mallard Press', '', '', '', '', ''),
(726, 'New York : Philomel Books, ', '', '', '', '', ''),
(727, 'Pleasantville, N.Y. : Reader\'s Digest Association, ', '', '', '', '', ''),
(728, 'New York : Grand Central Publishing, ', '', '', '', '', ''),
(729, 'Great Bardfield : Miles Kelly, ', '', '', '', '', ''),
(730, 'New York : Gallery Books,', '', '', '', '', ''),
(731, 'New York, N.Y., U.S.A. : Viking Kestrel,', '', '', '', '', ''),
(732, 'New York : Crescent Books', '', '', '', '', ''),
(733, 'England : Peter Haddock Limited, ', '', '', '', '', ''),
(734, 'Washington, DC : National Geographic/Conservation International', '', '', '', '', ''),
(735, 'Belguim : Ravette Books Limited, ', '', '', '', '', ''),
(736, 'New York : Parents\' Magazine Press,', '', '', '', '', ''),
(737, 'Somerville, Massachusetts. : Candlewick Press,', '', '', '', '', ''),
(738, 'Auburn, ME : Flying Frog,', '', '', '', '', ''),
(739, 'Cos Cob, CT : Chicken Soup for the Soul Pub.,', '', '', '', '', ''),
(740, 'North Michigan, Chicago : World Book, Inc., ', '', '', '', '', ''),
(741, '[Place of publication not identified] : Sterling', '', '', '', '', ''),
(742, 'Oxford : Oxford University Press,', '', '', '', '', ''),
(743, '[Washington, D.C.] : National Geographic Society, ', '', '', '', '', ''),
(744, 'New York : Greenwillow Books, ', '', '', '', '', ''),
(745, 'New York : Greenwillow Books, ', '', '', '', '', ''),
(746, 'Chicago, IL : Kidsbooks, ', '', '', '', '', ''),
(747, 'India : Sacheva Publications, ', '', '', '', '', ''),
(748, 'Newmarket : Brimax,', '', '', '', '', ''),
(749, 'New York : Four Winds Press, ', '', '', '', '', ''),
(750, 'New York : Aaron Publishing Group, Inc., ', '', '', '', '', ''),
(751, 'India : Sunrise Publishers, ', '', '', '', '', ''),
(752, 'New York : Crabtree Pub. Co.,', '', '', '', '', ''),
(753, 'London : Andromeda Children\'s Books, ', '', '', '', '', ''),
(754, 'New York : Hyperion Books for Children, ', '', '', '', '', ''),
(755, 'United States of America : Merriam, Incorporated, Publishers, ', '', '', '', '', ''),
(756, 'China : Wordsworth Editions Limited, ', '', '', '', '', ''),
(757, 'Toronto : Kids Can Press,', '', '', '', '', ''),
(758, 'New York : Shooting Star Press,', '', '', '', '', ''),
(759, 'London : DK Publishing, Inc., ', '', '', '', '', ''),
(760, 'St Helens : Book People,', '', '', '', '', ''),
(761, 'Mineola, N.Y. : Dover Publications,', '', '', '', '', ''),
(762, 'India : Sterling Press Private Limited, ', '', '', '', '', ''),
(763, 'New York : Viking Kestrel,', '', '', '', '', ''),
(764, 'Mankato, Minn. : Stargazer Books, ', '', '', '', '', ''),
(765, 'Victoria, B.C. : Orca,', '', '', '', '', ''),
(766, 'United States of America : Gareth Stevens Publishing, ', '', '', '', '', ''),
(767, 'Boston : Pauline Books & Media', '', '', '', '', ''),
(768, 'London : Collins Picture Books', '', '', '', '', ''),
(769, 'Canada : A Groundwood Book, ', '', '', '', '', ''),
(770, 'China : Ripley Publishing, ', '', '', '', '', ''),
(771, '[New York] : Twim Books, ', '', '', '', '', ''),
(772, '[New York] : Twim Books, ', '', '', '', '', ''),
(773, '[New York] : Twim Books, ', '', '', '', '', ''),
(774, '[New York] : Twin Books, ', '', '', '', '', ''),
(775, '[Hong Kong] : Twin Books, ', '', '', '', '', ''),
(776, 'New York : Barnes & Noble Books,', '', '', '', '', ''),
(777, 'Hove : Wayland,', '', '', '', '', ''),
(778, 'London : Watts,', '', '', '', '', ''),
(779, 'London : Hodder & Stoughton, ', '', '', '', '', '');
INSERT INTO `esk_lib_publication` (`pub_id`, `pub_publication`, `pub_address`, `pub_contact_number`, `pub_contact_person`, `pub_web`, `pub_email`) VALUES
(780, 'Alexandria, Va. : Time-Life Books,', '', '', '', '', ''),
(781, 'United States of America : Wonder Books, Inc., ', '', '', '', '', ''),
(782, 'London : Puffin Books, ', '', '', '', '', ''),
(783, 'Beverly, MA : Quarry,', '', '', '', '', ''),
(784, '[Toronto : Grolier], ', '', '', '', '', ''),
(785, 'Mankato, Minnesota : The Childs World, ', '', '', '', '', ''),
(786, 'Philippines : Cacho Hermanos Inc.,', '', '', '', '', ''),
(787, 'New York : Time-Life Films,', '', '', '', '', ''),
(788, '[Swansea] : Celtic Educational,', '', '', '', '', ''),
(789, 'Canada : Macmillan of Canada Toronto, ', '', '', '', '', ''),
(790, 'Brookfield, Conn. : Copper Beech Books,', '', '', '', '', ''),
(791, 'Valenzuela City : Tru-copy Publishing House, inc., ', '', '', '', '', ''),
(792, 'Brookfield, Conn. : Millbrook Press,', '', '', '', '', ''),
(793, 'New York : M. Evans', '', '', '', '', ''),
(794, 'London : Chancellor Press', '', '', '', '', ''),
(795, 'Buffalo, N.Y. ; Richmond Hill, ON : Firefly Books,', '', '', '', '', ''),
(796, 'Boston : Houghton Mifflin Harcourt, ', '', '', '', '', ''),
(797, 'New York : Dutton Children\'s Books,', '', '', '', '', ''),
(798, 'Morris Plains, New Jersey : The Unicorn Publishing House, Inc., ', '', '', '', '', ''),
(799, 'Canada : Science Research Associates (Canada) Limited, ', '', '', '', '', ''),
(800, 'Brookfield, Conn : Copper Beech Books,', '', '', '', '', ''),
(801, 'London : Octopus Books,', '', '', '', '', ''),
(802, 'Shahdara, Delhi : Rohan Book Company Pvt. Ltd., ', '', '', '', '', ''),
(803, 'Canada : Scholastic Canada Ltd., ', '', '', '', '', ''),
(804, 'Toronto : Macfarlane Walter & Ross', '', '', '', '', ''),
(805, 'Glenview, Ill. : Scott, Foresman', '', '', '', '', ''),
(806, 'Michigan : Zonderkidz, ', '', '', '', '', ''),
(807, 'London : Ladybird Books Ltd.,', '', '', '', '', ''),
(808, '	Surrey, B.C. : Foundations for Living Society', '', '', '', '', ''),
(809, 'Toronto : McClelland and Stewart,', '', '', '', '', ''),
(810, 'Toronto : McArthur & Co', '', '', '', '', ''),
(811, 'Diliman, Quezon City : University of the Philippines Press', '', '', '', '', ''),
(812, 'Chicago, Illinois : The Child\'s World, ', '', '', '', '', ''),
(813, 'New York : Puffin Books, ', '', '', '', '', ''),
(814, 'New York : A Golden Book, ', '', '', '', '', ''),
(815, 'China : Bison Group, ', '', '', '', '', ''),
(816, 'San Diego, California : Silver Dolphin Books, ', '', '', '', '', ''),
(817, 'Canada : Holt, Rinehart and Winston of Canada, Limited, ', '', '', '', '', ''),
(818, 'Canada : Madison Press Books, ', '', '', '', '', ''),
(819, 'Great Britain : Octopus Publishing Group Ltd., ', '', '', '', '', ''),
(820, 'Toronto : OXFORD UNIVERSITY PRESS, ', '', '', '', '', ''),
(821, 'New York : National Geographic Society, ', '', '', '', '', ''),
(822, 'New York : Franklin Watts, ', '', '', '', '', ''),
(823, 'Austin, Texas : Raintree Steck-Vaughn, ', '', '', '', '', ''),
(824, 'London : Franklin Watts, ', '', '', '', '', ''),
(825, 'England : Wayland Publishers, ', '', '', '', '', ''),
(826, 'San Francisco, California : Sierra Club Books, ', '', '', '', '', ''),
(827, 'Tucson, Arizona : Rion Nuevo Publishers, ', '', '', '', '', ''),
(828, 'Brookfield, Connecticut : The Millbrook Press, ', '', '', '', '', ''),
(829, 'China : Red Bird Publishing Ltd., ', '', '', '', '', ''),
(830, 'New York : Children\'s Publishing, ', '', '', '', '', ''),
(831, 'Oxford : Clarendon Press, ', '', '', '', '', ''),
(832, 'Great Britain : HarperCollins Publisher,', '', '', '', '', ''),
(833, 'U.S.A : Golden Books Pblishing Company, Inc., ', '', '', '', '', ''),
(834, 'U.S.A : Golden Books Publishing Company, Inc., ', '', '', '', '', ''),
(835, 'Canada : Secondary Story Press, ', '', '', '', '', ''),
(836, 'Willowdale, Ontario : Firefly Books, ', '', '', '', '', ''),
(837, '[Chicago] : Advance Publishers, ', '', '', '', '', ''),
(838, 'Ashland, Oh : Brainy Baby Co., LLC., ', '', '', '', '', ''),
(839, 'New York : Workman Publishing, ', '', '', '', '', ''),
(840, 'Chicago, illinois : Raintree, ', '', '', '', '', ''),
(841, 'Cambridge England : Brimax Books, ', '', '', '', '', ''),
(842, 'China : Twin Siters IP, LLC, ', '', '', '', '', ''),
(843, 'China : Twin Sisters IP, LLC, ', '', '', '', '', ''),
(844, 'Leicester : Inter-Varsity', '', '', '', '', ''),
(845, 'Edmonton : Christian History Project', '', '', '', '', ''),
(846, 'Virgilio S Almario; Sentro ng Wikang Filipino. Publisher:	Pasig City : Sentro ng Wikang Filipino : I', '', '', '', '', ''),
(847, '[Alexandria, Va.] : Time-Life Books', '', '', '', '', ''),
(848, '[Agincourt, Ont.] : Gage Educational Publishing', '', '', '', '', ''),
(849, 'Philippines : Wordlink Marketing Corporation, ', '', '', '', '', ''),
(850, 'Philippines : MSA Publishing House, ', '', '', '', '', ''),
(851, 'New York : Time-Life Books', '', '', '', '', ''),
(852, 'Brangien Davis; Katharine Wroth Publisher:	Seattle, Wash. : Skipstone', '', '', '', '', ''),
(853, 'Seattle, Wash. : Skipstone', '', '', '', '', ''),
(854, 'Parañaque : Luminaire Printing and Publishing Corporation, ', '', '', '', '', ''),
(855, 'New York : Ballantine Books', '', '', '', '', ''),
(856, 'New York, NY : HarperOne', '', '', '', '', ''),
(857, 'New York : W.H. Freeman', '', '', '', '', ''),
(858, 'London : Flame Tree', '', '', '', '', ''),
(859, 'Quezon City, Philippines : Solar Publishing', '', '', '', '', ''),
(860, 'Parkway, Quezon City : Aklat Ani Publsihing and Educational Trading Center', '', '', '', '', ''),
(861, 'Philippines : Wiseman\'s Books Trading', '', '', '', '', ''),
(862, 'Mandaluyong City, Philippines : Anvil Publishing', '', '', '', '', ''),
(863, 'San Francisco : W.H. Freeman and Company,', '', '', '', '', ''),
(864, 'China : [Papp], ', '', '', '', '', ''),
(865, 'Pleasantville, N.Y. : Reader\'s Digest Children\'s Books, ', '', '', '', '', ''),
(866, 'Philippines : C & E Publishing, Inc., ', '', '', '', '', ''),
(867, 'Intramuros, Manila : Purely Books Trading & Publishing', '', '', '', '', ''),
(868, '[London] : Guinness World Records', '', '', '', '', ''),
(869, 'New York : Guinness World Records Ltd.', '', '', '', '', ''),
(870, 'Danbury, Conneticut : Scholastic Library Publishing', '', '', '', '', ''),
(871, 'Vero Beach, Florida : Rourke Corporation', '', '', '', '', ''),
(872, 'Philippines : Winepress Publishing, ', '', '', '', '', ''),
(873, 'Manila, Philippines : Merriam and Webster Bookstore', '', '', '', '', ''),
(874, 'Quezon City, Philippines : All-Nations Publishing Corporation', '', '', '', '', ''),
(875, 'Intramuros, Manila : Mindshapers Corporation', '', '', '', '', ''),
(876, 'Manila, Philippines : Francisca Reyes Aquino', '', '', '', '', ''),
(877, 'Sampaloc, Manila : REX Book Store', '', '', '', '', ''),
(878, 'Quezon City : Adarna House, Inc., ', '', '', '', '', ''),
(879, 'Philippines : Church Strengthening Ministry, Inc., ', '', '', '', '', ''),
(880, 'Quezon City : Shepard\'s Voice Publications', '', '', '', '', ''),
(881, 'Las Piñas, Metro Manila : M & L Licudine Enterprises', '', '', '', '', ''),
(882, 'Manila : Milflores Publishing', '', '', '', '', ''),
(883, 'Manila : Unleash International Company, ', '', '', '', '', ''),
(884, 'New York : William Morrow/HarperCollins Publishers', '', '', '', '', ''),
(885, 'Philippine : Worldlink Books, ', '', '', '', '', ''),
(886, 'Toronto : Knopf Canada', '', '', '', '', ''),
(887, 'Crows Nest, N.S.W. : Allen & Unwin', '', '', '', '', ''),
(888, 'New York : Warner Books', '', '', '', '', ''),
(889, 'Toronto : Viking Canada', '', '', '', '', ''),
(890, 'London : Arcturus', '', '', '', '', ''),
(891, 'Nederland : Time-Life International', '', '', '', '', ''),
(892, 'New York : Simon Spotlight, ', '', '', '', '', ''),
(893, 'Westport, Conn. : H.S. Stuttman', '', '', '', '', ''),
(894, 'Canada : Thistldown Press Ltd., ', '', '', '', '', ''),
(895, 'New York : Hyperion Miramax Books, ', '', '', '', '', ''),
(896, 'United States of America : Penguin Young Readers Group, ', '', '', '', '', ''),
(897, 'Kansas City : Hallmark Books, ', '', '', '', '', ''),
(898, 'Columbia : National Geographic Society, ', '', '', '', '', ''),
(899, 'Canada : Firefly Books Ltd., ', '', '', '', '', ''),
(900, 'New York : Lodestar Books', '', '', '', '', ''),
(901, 'Italy : Grolier Limited, ', '', '', '', '', ''),
(902, 'Columbus, OH : School Specialty Children\'s Publishing', '', '', '', '', ''),
(903, 'Orlando : Harcourt Brace & Company, ', '', '', '', '', ''),
(904, 'Kuala Lumpur : Maxim Press & Publications', '', '', '', '', ''),
(905, 'India : QEB Publishing, Inc.,', '', '', '', '', ''),
(906, 'Los Angeles, California : Price Stern Sloan, Inc., ', '', '', '', '', ''),
(907, 'Canada : Thomas Nelson & Sons (Canada) Limited, ', '', '', '', '', ''),
(908, 'New York : Grolier Limited, ', '', '', '', '', ''),
(909, 'Mankato, Minn. : Creative Education', '', '', '', '', ''),
(910, 'New York : Golden Book ; Racine, Wis. : Western Pub. Co.,', '', '', '', '', ''),
(911, '[England] : QEB Publishing, Inc., ', '', '', '', '', ''),
(912, '[New York] : Puffin Books, ', '', '', '', '', ''),
(913, 'New York : Funk & Wagnalls', '', '', '', '', ''),
(914, 'New York : Blue Sky Press', '', '', '', '', ''),
(915, 'London : Alligator Books Ltd.', '', '', '', '', ''),
(916, 'Mumbai, India : Wilco Publishing House', '', '', '', '', ''),
(917, 'New York : Potter Craft', '', '', '', '', ''),
(918, 'Brookfield, Conn. : Copper Beech Books,', '', '', '', '', ''),
(919, 'Australia : Hinkler Books Pty Ltd.,', '', '', '', '', ''),
(920, 'Hong Kong : Educational Insights, ', '', '', '', '', ''),
(921, 'New York : Worth Press Ltd., ', '', '', '', '', ''),
(922, '[London] : Guinness World Records,', '', '', '', '', ''),
(923, 'Leicestershire, England : Brown Watson,', '', '', '', '', ''),
(924, 'Montreal : Reader\'s Digest Association (Canada), ', '', '', '', '', ''),
(925, 'South Melbourne, Victoria : Nelson Australia', '', '', '', '', ''),
(926, 'Australia : The Five Mile Press Pty Ltd., ', '', '', '', '', ''),
(927, 'New York : Dorling Kindersley Pub.,', '', '', '', '', ''),
(928, 'Hong Kong : American Greatings, ', '', '', '', '', ''),
(929, 'New Delhi : Discovery Pub. House', '', '', '', '', ''),
(930, 'Mankato, Minn. : Bridgestone Books,', '', '', '', '', ''),
(931, 'New York : Billboard Books', '', '', '', '', ''),
(932, 'London : Michael Joseph Ltd.', '', '', '', '', ''),
(933, 'publisher not identified', '', '', '', '', ''),
(934, 'New York : G.P. Putnam\'s Sons,', '', '', '', '', ''),
(935, 'New York : Time Home Entertainment Inc., ', '', '', '', '', ''),
(936, '[Canada] : Montbec, Inc., ', '', '', '', '', ''),
(937, 'United States of America : RGA Publishing Group, Inc., ', '', '', '', '', ''),
(938, 'Italy : Bloomsbury Publishing Ltd., ', '', '', '', '', ''),
(939, 'Boston : Little, Brown and Company, ', '', '', '', '', ''),
(940, 'Italy : Vineyard Books, ', '', '', '', '', ''),
(941, 'New York : J.B. Communications', '', '', '', '', ''),
(942, 'Minneapolis, MN : Lerner Publications, ', '', '', '', '', ''),
(943, '[Singapore] : Bramley Books, ', '', '', '', '', ''),
(944, '[Hong Kong] : Groiler, ', '', '', '', '', ''),
(945, 'Newton Abbot, Eng. : David & Charles,', '', '', '', '', ''),
(946, '[Alexandria, VA] : Time-Life Books,', '', '', '', '', ''),
(947, 'Auckland, N.Z. : Ashton Scholastic, ', '', '', '', '', ''),
(948, 'Dallas : Word Publishing,', '', '', '', '', ''),
(949, 'India : B. Jain Publishers Ltd.,', '', '', '', '', ''),
(950, 'Australia : Cengage Learning, ', '', '', '', '', ''),
(951, 'U.S.A. : Western Publishing Company, Inc., ', '', '', '', '', ''),
(952, 'Racine, Wisconsin : Western Publishing,', '', '', '', '', ''),
(953, 'Makati City : Diwa Learning System Inc., ', '', '', '', '', ''),
(954, 'New York : Marshall Cavendish Corporation,', '', '', '', '', ''),
(955, 'Italy : Groiler Enterprises Inc.,', '', '', '', '', ''),
(956, 'Toronto : Somerville House Publishing,', '', '', '', '', ''),
(957, 'New York : Crabtree,', '', '', '', '', ''),
(958, 'Lincolnwood, Ill. : Publications International,', '', '', '', '', ''),
(959, '[New York] : Beginner Books,', '', '', '', '', ''),
(960, 'London : Medici Society,', '', '', '', '', ''),
(961, 'Brookfield, Conn. : Twenty-First Century Books, ', '', '', '', '', ''),
(962, 'Milwaukee : Gareth Stevens Children\'s Books,', '', '', '', '', ''),
(963, 'Quezon City : All-nations Publishing Corporation, Inc.,', '', '', '', '', ''),
(964, 'New York : Time for Kids Books,', '', '', '', '', ''),
(965, 'United States of America : Zondernvan Publishing House,', '', '', '', '', ''),
(966, 'Nork Way : Rourke Enterprise Inc.,', '', '', '', '', ''),
(967, 'Oxford : Heinemann Educational Books,', '', '', '', '', ''),
(968, 'North Mankato, Minn. : Smart Apple Media,', '', '', '', '', ''),
(969, 'London : Arcturus Publishing Limited,', '', '', '', '', ''),
(970, 'New York, NY : Platt & Munk, Publishers,', '', '', '', '', ''),
(971, 'China : Creative Edge, LLC., ', '', '', '', '', ''),
(972, 'London : Heinemann,', '', '', '', '', ''),
(973, 'Vancouver : GreyStone Books, ', '', '', '', '', ''),
(974, 'London : Boxtree,', '', '', '', '', ''),
(975, 'New York : Simon Spotlight/Nickelodeon,', '', '', '', '', ''),
(976, 'New York : Simon & Schuster Books for Young, ', '', '', '', '', ''),
(977, 'Broomall, PA : Mason Cres', '', '', '', '', ''),
(978, 'Toronto : Harcourt Brace', '', '', '', '', ''),
(979, 'Mankato, MN : Smart Apple Media, ', '', '', '', '', ''),
(980, 'New York : Margaret K. McElderry Books', '', '', '', '', ''),
(981, 'New York, N.Y. : Baronet Books/Playmore', '', '', '', '', ''),
(982, 'Riverdale, NY : Baen ; New York : Distributed by Simon & Schuster', '', '', '', '', ''),
(983, 'New York : PowerKids Press,', '', '', '', '', ''),
(984, '[New York] : Watchtower Bible and Tract Society of New York, Inc.,', '', '', '', '', ''),
(985, 'Erin, Ont. : Boston Mills Press, ', '', '', '', '', ''),
(986, 'New York : Watson-Guptill Publications', '', '', '', '', ''),
(987, 'Greenvale, NY : Mondo Pub.,', '', '', '', '', ''),
(988, 'Red Deer, Alta. : Red Deer College Press', '', '', '', '', ''),
(989, 'North Mankato, MN : Smart Apple Media, ', '', '', '', '', ''),
(990, 'Columbus, Ohio : Waterbird Books,', '', '', '', '', ''),
(991, 'Toronto : Kids Can Press, ', '', '', '', '', ''),
(992, '[England] : Guinness World Records Ltd.,', '', '', '', '', ''),
(993, 'New York : Guinness World Records Ltd.,', '', '', '', '', ''),
(994, 'Oak Hammock Marsh, Man. : Ducks Unlimited Canada,', '', '', '', '', ''),
(995, 'London : Red Fox,', '', '', '', '', ''),
(996, 'Grand Rapids, Mich. : Zondervan Pub. House,', '', '', '', '', ''),
(997, 'Lake Mary, FL : B Plus Marketing Inc.,', '', '', '', '', ''),
(998, 'New York, N.Y. : Sports Illustrated for Kids,', '', '', '', '', ''),
(999, 'San Francisco : Berrett-Koehler Publisher', '', '', '', '', ''),
(1000, 'New York : Prestel', '', '', '', '', ''),
(1001, 'Oxford : Lion Children\'s', '', '', '', '', ''),
(1002, 'London : Usborne, ', '', '', '', '', ''),
(1003, 'Princeton, NJ : Two-Can Publishing', '', '', '', '', ''),
(1004, 'Nashville, Tenn. : Ideals Children\'s Books,', '', '', '', '', ''),
(1005, 'New Delhi : Young Learner Publications,', '', '', '', '', ''),
(1006, 'China : Weldon Owen Inc.,', '', '', '', '', ''),
(1007, 'London : Macmillan', '', '', '', '', ''),
(1008, 'New York : Holiday House,', '', '', '', '', ''),
(1009, 'USA : Shepell.fgi', '', '', '', '', ''),
(1010, 'London : TickTock, an imprint of Octopus Publishing Group Ltd, ', '', '', '', '', ''),
(1011, 'Toronto : Crabtree Pub. Co., ', '', '', '', '', ''),
(1012, 'New York : Cobblehill Book', '', '', '', '', ''),
(1013, 'Mandaluyong City : Melody Corner Library,', '', '', '', '', ''),
(1014, '[U.S.A] : Hopscotch Educational Publishing Ltd.,', '', '', '', '', ''),
(1015, 'New York : Dial Books for Young Readers,', '', '', '', '', ''),
(1016, 'Carthage, Ill. : Good Apple,', '', '', '', '', ''),
(1017, 'New York : Scholastic Press,', '', '', '', '', ''),
(1018, 'Edmonton : Federation of Alberta Naturalists,', '', '', '', '', ''),
(1019, 'London : Dorling Kindersley,', '', '', '', '', ''),
(1020, 'Berkeley, CA : Peachpit Press', '', '', '', '', ''),
(1021, 'New York : Aladdin Paperbacks, ', '', '', '', '', ''),
(1022, 'New York : Forge', '', '', '', '', ''),
(1023, 'New York, NY : HarperEntertainment,', '', '', '', '', ''),
(1024, 'New York : Berkley Prime Crime', '', '', '', '', ''),
(1025, 'Los Altos, Calif. : Crisp', '', '', '', '', ''),
(1026, 'London : Orion', '', '', '', '', ''),
(1027, '[Place of publication not identified] : Acropolis Books', '', '', '', '', ''),
(1028, 'El Cajon, California : Master Book Publishers', '', '', '', '', ''),
(1029, 'Cubao, Quezon City : Sheperd\'s Voice Publications', '', '', '', '', ''),
(1030, 'Berkeley, Calif. : Parallax Press', '', '', '', '', ''),
(1031, 'New York : Papercutz, ', '', '', '', '', ''),
(1032, 'Ottawa : The Canadian Career Development Foundation', '', '', '', '', ''),
(1033, 'Great Britain : Wordsworth Children\'s Classics,', '', '', '', '', ''),
(1034, 'Toronto, Canada : General Paperbacks,', '', '', '', '', ''),
(1035, 'Boston : Houghton Mifflin,', '', '', '', '', ''),
(1036, 'London : Alligator Books,', '', '', '', '', ''),
(1037, 'New York : A Beech Tree Paperback Book,', '', '', '', '', ''),
(1038, 'Canada : Ragweed Press,', '', '', '', '', ''),
(1039, 'London : Macdonald and Jane\'s', '', '', '', '', ''),
(1040, 'Washington, D.C. : Counterpoint', '', '', '', '', ''),
(1041, 'Montréal : Baraka Books', '', '', '', '', ''),
(1042, 'Toronto : M&S', '', '', '', '', ''),
(1043, 'Edmonton : Hurtig Publishers', '', '', '', '', ''),
(1044, 'Glen Huon, Tas. : P. Rush', '', '', '', '', ''),
(1045, 'Edmonton : NS Group', '', '', '', '', ''),
(1046, 'Toronto : Greey de Pencier Books,', '', '', '', '', ''),
(1047, 'Winnipeg : Enfield & Wizenty', '', '', '', '', ''),
(1048, 'New Delhi, India : Sterling Paperbacks', '', '', '', '', ''),
(1049, '[Mahwah, N.J.] : Troll Associates,', '', '', '', '', ''),
(1050, 'Boston, Massachusetts : Megan Tingley Books', '', '', '', '', ''),
(1051, 'Calgary : Pow!-R Publications', '', '', '', '', ''),
(1052, 'New York : Picador', '', '', '', '', ''),
(1053, 'Nashville, TN : W Publishing Group,', '', '', '', '', ''),
(1054, 'London : Ladybird,', '', '', '', '', ''),
(1055, 'Edmonton : Reidmore Books', '', '', '', '', ''),
(1056, 'United States of America : Barbour Publishing, Inc.,', '', '', '', '', ''),
(1057, 'New York : Simon Pulse, ', '', '', '', '', ''),
(1058, 'Singapore : Cengage Learning Asia', '', '', '', '', ''),
(1059, 'Seattle, WA : Bilingual Books', '', '', '', '', ''),
(1060, 'New Lanark : Corbie,', '', '', '', '', ''),
(1061, 'London : SevenOaks', '', '', '', '', ''),
(1062, 'Loughborough : Ladybird, ', '', '', '', '', ''),
(1063, 'New York : Margaret K. McElderry Books,', '', '', '', '', ''),
(1064, 'London : HarperCollinsEntertainment,', '', '', '', '', ''),
(1065, 'Quezon City : Solar Publishing Corporation,', '', '', '', '', ''),
(1066, 'New York : Amulet Books,', '', '', '', '', ''),
(1067, 'New York, N.Y. : Dell Publishing', '', '', '', '', ''),
(1068, 'Colorado Springs, Colorado : Nexgen', '', '', '', '', ''),
(1069, 'London : Simon & Schuster,', '', '', '', '', ''),
(1070, 'New York, NY : Free Press', '', '', '', '', ''),
(1071, 'Kansas City, Missouri : Beacon Hill Press', '', '', '', '', ''),
(1072, 'New York : Blue Sky Press,', '', '', '', '', ''),
(1073, 'Grand Rapids, Mich. : Discovery House Publishers', '', '', '', '', ''),
(1074, '[Portland, Or.] : Multnomah Press', '', '', '', '', ''),
(1075, 'London ; New York : Phaidon', '', '', '', '', ''),
(1076, 'Canada : A Little Kids Book,', '', '', '', '', ''),
(1077, 'Tokyo : Tokoyopop,', '', '', '', '', ''),
(1078, 'New York : Sterling, ', '', '', '', '', ''),
(1079, 'Bath, UK : Parragon Publication,', '', '', '', '', ''),
(1080, '[Bethesda, MD] : Alban Institute', '', '', '', '', ''),
(1081, '[Indianapolis, IN] : New Riders PubLISHING', '', '', '', '', ''),
(1082, 'Scarborough, Ont. : Prentice-Hall Canada', '', '', '', '', ''),
(1083, 'Toronto : Madison Marketing Ltd.,', '', '', '', '', ''),
(1084, 'New York : Doubleday/Currency', '', '', '', '', ''),
(1085, 'New York : HarperFestival,', '', '', '', '', ''),
(1086, 'Aiea, Hawaii : Island Heritage,', '', '', '', '', ''),
(1087, 'New York : Fawcett Gold Medal,', '', '', '', '', ''),
(1088, 'Kingston, Ont. : Quarry Press', '', '', '', '', ''),
(1089, 'Edmonton : University of Alberta Press', '', '', '', '', ''),
(1090, 'Hong Kong : Macmillan Educational Australia Pty Ltd.,', '', '', '', '', ''),
(1091, 'Brooklyn, NY : Melville House', '', '', '', '', ''),
(1092, 'London : Collins,', '', '', '', '', ''),
(1093, 'Victoria, B.C. : Pacific-Rim Publishers', '', '', '', '', ''),
(1094, 'Deerfield Beach, Fla. : Health Communications, ', '', '', '', '', ''),
(1095, 'Calgary : Bayeux Arts', '', '', '', '', ''),
(1096, 'Calgary : Red Deer Press', '', '', '', '', ''),
(1097, 'San Diego, Calif. : Portable Press', '', '', '', '', ''),
(1098, 'Flinders Park, S. Aust. : Era Publications', '', '', '', '', ''),
(1099, 'New York : Harper & Row, ', '', '', '', '', ''),
(1100, 'East Lawrencetown, N.S. : Pottersfield, ', '', '', '', '', ''),
(1101, 'New York, NY : HarperBusiness', '', '', '', '', ''),
(1102, 'Makawao, Maui, Hawaii : Inner Ocean Pub. ; [Berkeley, Calif.] : Distributed by Publishers Group West', '', '', '', '', ''),
(1103, 'Prescott, AZ : One World Press', '', '', '', '', ''),
(1104, 'Calgary, Alta. : Calgary Archives and Historical Publishers', '', '', '', '', ''),
(1105, 'New York : Random House Children\'s Books,', '', '', '', '', ''),
(1106, 'El Cajon, CA : Youth Specialties ; Grand Rapids, MI : Zondervan', '', '', '', '', ''),
(1107, 'New York : Atria Books/Beyond Words', '', '', '', '', ''),
(1108, 'New York : Simon & Schuster Books for Young Readers,', '', '', '', '', ''),
(1109, 'Englewood Cliffs, N.J. : Prentice-Hall', '', '', '', '', ''),
(1110, 'Canada : Troll Associates,', '', '', '', '', ''),
(1111, 'New Jersey : Troll Associates,', '', '', '', '', ''),
(1112, 'New York : Bullseye Books,', '', '', '', '', ''),
(1113, 'Hong Kong : Blue Banana Books Ltd.,', '', '', '', '', ''),
(1114, 'U.S.A : Watermill,', '', '', '', '', ''),
(1115, 'India : Spider Books,', '', '', '', '', ''),
(1116, 'Chicago, Ill. : Open Court', '', '', '', '', ''),
(1117, 'Toronto : ECW Press', '', '', '', '', ''),
(1118, 'Toronto, Canada : Irwin Publishing,', '', '', '', '', ''),
(1119, 'London : Rider', '', '', '', '', ''),
(1120, 'New York : Berkley Pub. Group', '', '', '', '', ''),
(1121, 'London :Jonathan Cape,', '', '', '', '', ''),
(1122, 'Vancouver : Douglas & McIntyre,', '', '', '', '', ''),
(1123, 'New York : Aladdin,', '', '', '', '', ''),
(1124, 'Sanger, Calif. : Quill Driver Books/Word Dancer Press', '', '', '', '', ''),
(1125, 'Godalming, England : Colour Library Bks. Ltd.', '', '', '', '', ''),
(1126, '[U.S.A] : [National Book Store],', '', '', '', '', ''),
(1127, 'New York : Pocket Books,', '', '', '', '', ''),
(1128, 'Quezon City : Amos Book, Inc.,', '', '', '', '', ''),
(1129, 'Nashville : Thomas Nelson, ', '', '', '', '', ''),
(1130, 'Singapore : Periplus,', '', '', '', '', ''),
(1131, 'Mumbai, India : Walt Disney Company (India)', '', '', '', '', ''),
(1132, 'Toronto : McClelland & Stewart,', '', '', '', '', ''),
(1133, 'Toronto : H·I·P Books,', '', '', '', '', ''),
(1134, 'New York : Center Street', '', '', '', '', ''),
(1135, 'Novato, Calif. : New World Library', '', '', '', '', ''),
(1136, 'Eugene, Or. : Harvest House Publishers', '', '', '', '', ''),
(1137, 'Calgary : EKSAL Quality Systems', '', '', '', '', ''),
(1138, 'Berkeley, Calif. : Conari Press', '', '', '', '', ''),
(1139, 'White Rock, B.C. : Roper House Publishing', '', '', '', '', ''),
(1140, 'Minneapolis, Minn. : Bethany House Publishers, ', '', '', '', '', ''),
(1141, '[Place of publication not identified] : The Johnson O\'Connor Research Foundation, Inc.', '', '', '', '', ''),
(1142, 'Colorado Springs, Colo. : Focus on the Family,', '', '', '', '', ''),
(1143, 'Colorado Springs, Colorado : Focus on the Family,', '', '', '', '', ''),
(1144, 'New York : Harper & Row Publishers,', '', '', '', '', ''),
(1145, 'Norwalk, CT : Soundprints,', '', '', '', '', ''),
(1146, 'New York : Columbia University Press', '', '', '', '', ''),
(1147, 'New York : Sparknotes', '', '', '', '', ''),
(1148, 'England : Penguin Books,', '', '', '', '', ''),
(1149, 'Singapore : Embassy of Chile', '', '', '', '', ''),
(1150, 'New York : [Avon Books],', '', '', '', '', ''),
(1151, 'U.S.A. : Penguin Putnam Inc.,', '', '', '', '', ''),
(1152, 'Toronto, Canada : James Lorimer & Company Ltd., Publishers,', '', '', '', '', ''),
(1153, 'New York : Philomel Books, Penguin Young Readers Group', '', '', '', '', ''),
(1154, 'Halifax, N.S. : Nimbus Publishing', '', '', '', '', ''),
(1155, 'Toronto : Owl', '', '', '', '', ''),
(1156, 'UK : David Dale House,', '', '', '', '', ''),
(1157, 'London : Longman Group Limited, ', '', '', '', '', ''),
(1158, 'New York : Viking', '', '', '', '', ''),
(1159, 'Toronto : A Bantam Skylark Book,', '', '', '', '', ''),
(1160, 'Calgary : Capacity Builders', '', '', '', '', ''),
(1161, 'Dallas, Texas : Ram Publishing Corporation,', '', '', '', '', ''),
(1162, 'New York, NY : Harper Business', '', '', '', '', ''),
(1163, 'Victoria, B.C. : Orca Book Publishers', '', '', '', '', ''),
(1164, 'Shaftesbury : Element Children\'s Books,', '', '', '', '', ''),
(1165, 'Toronto : Bantam Books', '', '', '', '', ''),
(1166, 'New York : Vanguard Press', '', '', '', '', ''),
(1167, 'Worksop : Award Publications Ltd', '', '', '', '', ''),
(1168, 'Vancouver, B.C., Canada : Ronsdale Press', '', '', '', '', ''),
(1169, 'Quezon City : Mindmasters Publishing Inc.,', '', '', '', '', ''),
(1170, 'Winnipeg, Manitoba : CMU Press', '', '', '', '', ''),
(1171, 'New York : Broadway Books', '', '', '', '', ''),
(1172, 'Victoria, B.C. : Sono Nis Press,', '', '', '', '', ''),
(1173, 'New York : Allworth Press', '', '', '', '', ''),
(1174, 'Toronto : Napoleon Publishing,', '', '', '', '', ''),
(1175, 'New York : A Richard Jackson Book,', '', '', '', '', ''),
(1176, 'New York : William Morrow and Company, Inc.,', '', '', '', '', ''),
(1177, 'Irvine, CA : RandallFraser Pub', '', '', '', '', ''),
(1178, 'New York : Modern Publishing,', '', '', '', '', ''),
(1179, 'San Diego : Harcourt Brace Company,', '', '', '', '', ''),
(1180, 'Toronto : Tundra Books,', '', '', '', '', ''),
(1181, 'New York, New York : Collins, ', '', '', '', '', ''),
(1182, 'Tucson, Ariz. : Wheatmark', '', '', '', '', ''),
(1183, 'London : Hay House', '', '', '', '', ''),
(1184, 'Toronto : Lung Association', '', '', '', '', ''),
(1185, 'Toronto, ON : CanWest Books', '', '', '', '', ''),
(1186, 'New York : A.A. Knopf,', '', '', '', '', ''),
(1187, 'Charlottesville, VA : Hampton Roads Publishing Company', '', '', '', '', ''),
(1188, 'Orlando : Harcourt, Inc.,', '', '', '', '', ''),
(1189, '[Calgary] : Sheldon M. Chumir Foundation for Ethics in Leadership', '', '', '', '', ''),
(1190, 'U.S.A. : Victor Books,', '', '', '', '', ''),
(1191, 'Colorado Springs, Colo. : Focus on the Family Book Publishig,', '', '', '', '', ''),
(1192, 'New York, NY : HarperKidsEntertainment,', '', '', '', '', ''),
(1193, 'Edmonton : Company\'s Coming Publishing', '', '', '', '', ''),
(1194, 'Edmonton : Company\'s Coming Publishing', '', '', '', '', ''),
(1195, 'Butte, Mont. : Wild Norton Fire', '', '', '', '', ''),
(1196, '[Kansas City, Mo.] Hallmark Editions', '', '', '', '', ''),
(1197, 'New York : Sterling Publishing Co., Inc.,', '', '', '', '', ''),
(1198, 'U.S.A. : A Watermill Classic,', '', '', '', '', ''),
(1199, 'Boston : Harvard Business School Press', '', '', '', '', ''),
(1200, 'Grand Rapids, Mich. : Zondervan, ', '', '', '', '', ''),
(1201, 'New Delhi: Venus', '', '', '', '', ''),
(1202, 'Edison, NJ : Castle Books', '', '', '', '', ''),
(1203, 'Vancouver : Raincoast Books', '', '', '', '', ''),
(1204, 'Toronto, ON : House of Anansi Press', '', '', '', '', ''),
(1205, 'New York : HarperCollins', '', '', '', '', ''),
(1206, 'Stanford, Calif. : Stanford Business Books', '', '', '', '', ''),
(1207, 'Houston, TX ; Edmonton : Vantage Publishing', '', '', '', '', ''),
(1208, 'New York, NY : Washington Square Press', '', '', '', '', ''),
(1209, 'New York : Dutton', '', '', '', '', ''),
(1210, 'Kansas City, Mo. : Andrews McMeel Publishing', '', '', '', '', ''),
(1211, 'Ashland, OH : Bendon Pub., International', '', '', '', '', ''),
(1212, 'Calgary : RedStone Publishing', '', '', '', '', ''),
(1213, 'Ashland, Ohio : Landoll, Inc.,', '', '', '', '', ''),
(1214, 'Lynnwood, WA, USA : Aglow Publications', '', '', '', '', ''),
(1215, 'Canada : Walrus Books,', '', '', '', '', ''),
(1216, 'England : Ladybird Books Ltd.,', '', '', '', '', ''),
(1217, 'Spain : Mediasat Group,', '', '', '', '', ''),
(1218, 'Orlando : Magic Carpet Books Harcourt, Inc.,', '', '', '', '', ''),
(1219, 'Carlsbad, California : Hay House', '', '', '', '', ''),
(1220, 'Tarrytown, N.Y. : F.H. Revell', '', '', '', '', ''),
(1221, 'New York, N.Y., U.S.A. : Plume', '', '', '', '', ''),
(1222, 'Chicago : The University of Chicago Press', '', '', '', '', ''),
(1223, 'Loveland, Colorado : Group', '', '', '', '', ''),
(1224, 'New York : HarperTrophy,', '', '', '', '', ''),
(1225, 'New York : A Parachute Press Book,', '', '', '', '', ''),
(1226, 'Edmonton : Hodgepog Books,', '', '', '', '', ''),
(1227, 'San Francisco, CA : Turning Stone Press', '', '', '', '', ''),
(1228, 'Los Angeles, Calif. : Babypie Publishing', '', '', '', '', ''),
(1229, 'New York : Wellness Central', '', '', '', '', ''),
(1230, 'Cary, NC : Trans World Radio', '', '', '', '', ''),
(1231, 'New York : Pantheon Books', '', '', '', '', ''),
(1232, 'Ventura, Calif., U.S.A. : Regal', '', '', '', '', ''),
(1233, 'Taos, N.M., USA : White Dove International', '', '', '', '', ''),
(1234, 'New York : Scribner', '', '', '', '', ''),
(1235, '[Auckland] N.Z. : Shortland Publications,', '', '', '', '', ''),
(1236, 'Kearney, NE : Morris Publishing', '', '', '', '', ''),
(1237, 'New York : Scholastic Book Services,', '', '', '', '', ''),
(1238, 'West Monroe, LA : Howard Publishing', '', '', '', '', ''),
(1239, 'New York : Business Plus', '', '', '', '', ''),
(1240, 'Stroud : Tempus', '', '', '', '', ''),
(1241, '[Edmunton] : Garth Toombs', '', '', '', '', ''),
(1242, 'Toronto, Canada : Alfred A. Knopf Canada', '', '', '', '', ''),
(1243, 'New York : Shaye Areheart Books', '', '', '', '', ''),
(1244, 'London : MacLehose Press', '', '', '', '', ''),
(1245, 'New York, NY : Katherine Tegen Books, an imprint of HarperCollinsPublishers', '', '', '', '', ''),
(1246, 'Toronto : Anchor Canada', '', '', '', '', ''),
(1247, '[Place of publication not identified] : Viacom International', '', '', '', '', ''),
(1248, 'LLC : Dalmatian Press', '', '', '', '', ''),
(1249, 'London : Grafton', '', '', '', '', ''),
(1250, '[U.S.A.] : Pearson Education Limited,', '', '', '', '', ''),
(1251, 'California : Focus on the Family Publishing,', '', '', '', '', ''),
(1252, 'United States of America : Grolier Books, ', '', '', '', '', ''),
(1253, 'Kansas City : Ariel Books,', '', '', '', '', ''),
(1254, 'Los Angeles : Troubador Press,', '', '', '', '', ''),
(1255, 'Honesdale, Pa. : Boyds Mills Press,', '', '', '', '', ''),
(1256, 'London : Frances Lincoln Children\'s Books, ', '', '', '', '', ''),
(1257, 'Roseville, California : Prima Publishing,', '', '', '', '', ''),
(1258, 'London : A. & C. Black,', '', '', '', '', ''),
(1259, '[Hong Kong ] : Treasure Press,', '', '', '', '', ''),
(1260, 'Tunbridge Wells, Kent : Ticktock Media,', '', '', '', '', ''),
(1261, 'New York : Scholastic Canada Ltd.', '', '', '', '', ''),
(1262, 'Canada : How Love Shines Inc.', '', '', '', '', ''),
(1263, 'London : Maxim Press & Publication Sdn. Bhd.,', '', '', '', '', ''),
(1264, 'Toronto : Doubleday, ', '', '', '', '', ''),
(1265, 'Vancouver : Raincoast Books, ', '', '', '', '', ''),
(1266, 'England : Colour Library Books Ltd.,', '', '', '', '', ''),
(1267, 'China : Naumann & Gobel,', '', '', '', '', ''),
(1268, 'Vancouver : Douglas & McIntyre Publishing Group,', '', '', '', '', ''),
(1269, 'Toronto : Maple Tree Press Inc.,', '', '', '', '', ''),
(1270, 'Vancouver : Gage Education Publishing Company,', '', '', '', '', ''),
(1271, 'U.S.A. : Flowerpot Press,', '', '', '', '', ''),
(1272, 'New York : Crabtree Publishing Company,', '', '', '', '', ''),
(1273, 'New York : Checkmark Books,', '', '', '', '', ''),
(1274, 'Singapore : Pearson Education South Asia Pte Ltd.,', '', '', '', '', ''),
(1275, 'Canada : Templar Book,', '', '', '', '', ''),
(1276, 'Australia : Steve Parish Kids,', '', '', '', '', ''),
(1277, 'Canada : A Dorling Kindersley Book,', '', '', '', '', ''),
(1278, 'Rave India, Delhi : Young Learner Publication,', '', '', '', '', ''),
(1279, 'United States : World Book, Inc.,', '', '', '', '', ''),
(1280, 'London : Charles Letts,', '', '', '', '', ''),
(1281, 'New York : E.P. Dutton & Co., Inc.,', '', '', '', '', ''),
(1282, 'Woodbridge, Connecticut : Blackbirch Press, Inc.,', '', '', '', '', ''),
(1283, 'Toronto : Greey de Pencier Books, Inc.,', '', '', '', '', ''),
(1284, 'UK : A New Burlington Book, ', '', '', '', '', ''),
(1285, 'Mankato, Minn. : Sea-to-Sea,', '', '', '', '', ''),
(1286, '[Australia] : Macmillan Education Australia,', '', '', '', '', ''),
(1287, 'Italy : Wayland Publishers Ltd.,', '', '', '', '', ''),
(1288, ' Australia : Hinkler Books Pty Ltd, ', '', '', '', '', ''),
(1289, 'United States : The Canada Council for the Arts,', '', '', '', '', ''),
(1290, 'San Francisco : Chronicle Books,', '', '', '', '', ''),
(1291, 'New York : Golden Press,', '', '', '', '', ''),
(1292, 'U.S.A. : American Greetings Corporation,', '', '', '', '', ''),
(1293, 'China : Southwestern Company,', '', '', '', '', ''),
(1294, 'Chicago : Advance Publishers,', '', '', '', '', ''),
(1295, 'Parañaque City, Metro Manila, Philippines : AR Skills Development and Management Services', '', '', '', '', ''),
(1296, 'Oakland, CA : New Harbinger Publications', '', '', '', '', ''),
(1297, 'Upper Saddle River, N.J. : Creative Homeowner', '', '', '', '', ''),
(1298, 'Richland, WA : Margaret Greger', '', '', '', '', ''),
(1299, 'New York : Charles Scribner\'s Sons,', '', '', '', '', ''),
(1300, 'Washington, D.C. : Island Press', '', '', '', '', ''),
(1301, 'Nevada City, CA : Dawn Publications,', '', '', '', '', ''),
(1302, 'China : Blackbirch Press,', '', '', '', '', ''),
(1303, 'New York : Benchmark Books,', '', '', '', '', ''),
(1304, 'Philadelphia, PA : Running Press Kids', '', '', '', '', ''),
(1305, 'Canada : Cool Reading,', '', '', '', '', ''),
(1306, '[United States] : Paradise Press', '', '', '', '', ''),
(1307, 'United States of America : Watermill Press,', '', '', '', '', ''),
(1308, 'London : Hodder and Stoughton,', '', '', '', '', ''),
(1309, 'United States of America : Ballatine Books,', '', '', '', '', ''),
(1310, 'Beijing : China Intercontinental Press', '', '', '', '', ''),
(1311, 'New York : Aladdin Classics,', '', '', '', '', ''),
(1312, 'United States : A Yearling Book,', '', '', '', '', ''),
(1313, 'Noida : Maple Press', '', '', '', '', ''),
(1314, 'New York : Cartwheel Books/Scholastic', '', '', '', '', ''),
(1315, 'Great Britain : Orchard Books,', '', '', '', '', ''),
(1316, 'Salt Lake City : Gibbs Smith Publisher,', '', '', '', '', ''),
(1317, 'Minneapolis, MN : World Wide Publications', '', '', '', '', ''),
(1318, 'New York : A Tom Doherty Associates Book,', '', '', '', '', ''),
(1319, 'Great Britain : Usborne Publishing Ltd.,', '', '', '', '', ''),
(1320, 'New York : Cliff Street Books', '', '', '', '', ''),
(1321, 'New York : Bantam Books,', '', '', '', '', ''),
(1322, 'Great Britain : Hodder Children\'s Books,', '', '', '', '', ''),
(1323, 'Markham, Ont. : Fitzhenry & Whiteside, ', '', '', '', '', ''),
(1324, 'Ontario : Ginn Publishing Canada Inc.,', '', '', '', '', ''),
(1325, 'Ware, Hertfordshire : Wordsworth Editions', '', '', '', '', ''),
(1326, 'St. Petersburg, FL : Willowisp Press,', '', '', '', '', ''),
(1327, 'Philippines : Pearson Education South Asia Pte Ltd.,', '', '', '', '', ''),
(1328, 'Richmond, In. : LGR Publishing,', '', '', '', '', ''),
(1329, 'New Zealand : International Thompson Publishing,', '', '', '', '', ''),
(1330, 'New York : School Specialty Publishing,', '', '', '', '', ''),
(1331, 'India : Media Eight International Publishing Limited,', '', '', '', '', ''),
(1332, 'New York : The Berkley Publishing Book,', '', '', '', '', ''),
(1333, 'Toronto : Strathearn Books', '', '', '', '', ''),
(1334, 'Mankato, Minn. : Capstone Press,', '', '', '', '', ''),
(1335, 'Grand Rapids, MI : Campus Life Books', '', '', '', '', ''),
(1336, 'United States of America : Penguin Group,', '', '', '', '', ''),
(1337, 'New York : Golden Books Publishing Company, Inc.,', '', '', '', '', ''),
(1338, 'London : Wayland Publishers Ltd.,', '', '', '', '', ''),
(1339, '[Hong Kong] : Young Naturalist Foundation,', '', '', '', '', ''),
(1340, 'United Kingdom : Ladybird Books Ltd.,', '', '', '', '', ''),
(1341, '[China] : Studio Fun International,', '', '', '', '', ''),
(1342, 'Middleton, Wis. : American Girl Publication,', '', '', '', '', ''),
(1343, '[China] : Pearson,', '', '', '', '', ''),
(1344, 'Vancouver : Whitecap Books, ', '', '', '', '', ''),
(1345, 'New York : The Diagram Group,', '', '', '', '', ''),
(1346, 'Washington : Smartlab,', '', '', '', '', ''),
(1347, 'United States of America : Usborne Publishing Ltd.,', '', '', '', '', ''),
(1348, 'New York : Scholastic Canada Ltd.,', '', '', '', '', ''),
(1349, 'New York : Scholastic Reference,', '', '', '', '', ''),
(1350, 'Mahwah, N.J. : Troll Associates, ', '', '', '', '', ''),
(1351, 'North Vancouver, B.C. : Whitecap Books,', '', '', '', '', ''),
(1352, 'Winnipeg : Turnstone,', '', '', '', '', ''),
(1353, 'Quintin Publishers', 'P.O. Box 340, Waterloo, Quebec CANADA', '', '', '', ''),
(1354, 'World Book-Childcraft International, Inc', 'Chicago', '', '', '', ''),
(1355, 'Meriam-Webster, Incorporated', '', '', '', '', ''),
(1356, 'Pan Books Ltd.', 'Cavaye Palace, London SW10 9pg', '', '', '', ''),
(1357, 'Portico Books', '10 Southcombe Street, London', '', '', '', ''),
(1358, 'McClelland & Stewart Inc.', 'Canada', '', '', '', ''),
(1359, 'Ripley Publishing', '', '', '', '', ''),
(1360, 'Rebo Productions Ltd.', '', '', '', '', ''),
(1361, 'Octopus Publishing Group Ltd.', '', '', '', '', ''),
(1362, 'Mandarin Offset', 'Hong Kong', '', '', '', ''),
(1363, 'Detselig Enterprise Ltd.', 'Calgary, Aberta', '', '', '', ''),
(1364, 'Parks and People (Friends of Jasper National Park)', 'Jasper, Alberta', '', '', '', ''),
(1365, 'Bill Adler Books, Inc.', '', '', '', '', ''),
(1366, 'Fenn Publishing Company Ltd.', '', '', '', '', ''),
(1367, 'Waldman Publishing Corp.', '', '', '', '', ''),
(1368, 'Evan-Moor Corp.', '', '', '', '', ''),
(1369, 'Tops Learning Systems', '', '', '', '', ''),
(1370, 'Carson-Dellosa Publishing LLC', '', '', '', '', ''),
(1371, 'School Zone Publishing Company', '', '', '', '', ''),
(1372, 'Paulo Publications', 'Calgary, Alberta, Canada', '', '', 'www.paulo.tv', 'wordsofkidsdom@paulo.tv'),
(1373, 'Family Communications Inc. Publication', '', '', '', '', ''),
(1374, 'Westland Ltd.', '', '', '', '', ''),
(1375, 'MCMXCII Playmore Inc., Publishers', 'New York', '', '', '', ''),
(1376, 'Victoria Calgary Vancouver', '', '', '', '', ''),
(1377, 'Avon Camelot', '', '', '', '', ''),
(1378, 'Colorado, Springs, Colo. : Faith Kidz', '', '', '', '', ''),
(1379, 'Toronto : Canadian Children\'s Book Centre', '', '', '', '', ''),
(1380, 'Trapps Publishing', '', '', '', '', ''),
(1381, 'New York : Merrigold Press', '', '', '', '', ''),
(1382, 'Mountain Press Publishing Company', '', '', '', '', ''),
(1383, 'Quebec Amerique Inc.', 'Montreal, Quebec', '', '', '', ''),
(1384, 'The Wright Group ', 'Bothell, WA 98011', '', '', '', ''),
(1385, 'Harry N. Abrams Inc.', 'Newyork', '', '', '', ''),
(1386, 'London : Bounty Books', '', '', '', '', ''),
(1387, 'London : Mitchell Beazley', '', '', '', '', ''),
(1388, '[Romsey, England] : M.B.P. Ltd.', '', '', '', '', ''),
(1389, 'St. Louis, MO : Concordia Pub. House', '', '', '', '', ''),
(1390, 'Columbia S.A.:  Allan Publishers, Inc.', '', '', '', '', ''),
(1391, 'Topeka, KS : Florists\' Review Enterprises', '', '', '', '', ''),
(1392, 'Gloucester, Mass. : Fair Winds', '', '', '', '', ''),
(1393, 'Maple Ridge, British Columbia : Polar Expressions Publishing', '', '', '', '', ''),
(1394, 'Ste. Rose, MB : Glenn Hopfner', '', '', '', '', ''),
(1395, 'Bloomington : iUniverse', '', '', '', '', ''),
(1396, 'Dallas, TX : Gold Pen Publishing', '', '', '', '', ''),
(1397, 'Wishing Well Books', '', '', '', '', ''),
(1398, 'Annies Attic', '', '', '', '', ''),
(1399, 'Robert Frederick Ltd.', 'United Kingdom', '', '', '', ''),
(1400, 'Allen, Texas : Barney Pub.', '', '', '', '', ''),
(1401, 'Sea Star Books', '', '', '', '', ''),
(1402, 'Melbourne : Lothian', '', '', '', '', ''),
(1403, 'Burlington, Ont. : Hayes Pub. Co.', '', '', '', '', ''),
(1404, 'Scarborough, Ont. : ITP Nelson', '', '', '', '', ''),
(1405, '[Columbia] : Ottenheimer Publishers, Inc.', '', '', '', '', ''),
(1406, 'Berenstain Publishing Inc.', 'Michigan', '', '', '', ''),
(1407, 'Island Heritage', '', '', '', '', ''),
(1408, 'North Wind Press, A division of Scholastic Canada Ltd.', 'Ontario, Canada', '', '', '', ''),
(1409, 'The Canadian Children\'s Book Centre', 'Toronto, Canada', '', '', '', ''),
(1410, 'Marvel Characters, Inc.', '', '', '', '', ''),
(1411, 'Fulcrum Publishing', 'Golden, Colorado', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_lib_shelf`
--

CREATE TABLE `esk_lib_shelf` (
  `sh_id` int(11) NOT NULL,
  `sh_number` varchar(50) NOT NULL,
  `sh_location_desc` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_lib_shelf`
--

INSERT INTO `esk_lib_shelf` (`sh_id`, `sh_number`, `sh_location_desc`) VALUES
(1, 'Library Shelf', '');

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
  `tt_topical_term` varchar(150) NOT NULL
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_lib_author`
--
ALTER TABLE `esk_lib_author`
  MODIFY `au_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esk_lib_category`
--
ALTER TABLE `esk_lib_category`
  MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `esk_lib_dewey`
--
ALTER TABLE `esk_lib_dewey`
  MODIFY `dw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `esk_lib_dewey_category`
--
ALTER TABLE `esk_lib_dewey_category`
  MODIFY `dwc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `esk_lib_entity_user`
--
ALTER TABLE `esk_lib_entity_user`
  MODIFY `eu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

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
  MODIFY `pub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1412;

--
-- AUTO_INCREMENT for table `esk_lib_shelf`
--
ALTER TABLE `esk_lib_shelf`
  MODIFY `sh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
