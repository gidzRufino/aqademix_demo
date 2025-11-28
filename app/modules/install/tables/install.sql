--
-- Paste your SQL dump into this file
--

CREATE TABLE `esk_admission_remarks` (
    `remark_id` int(11) NOT NULL AUTO_INCREMENT,
    `remarks` varchar(255) NOT NULL,
    `code_indicator_id` int(11) NOT NULL,
    `remark_to` varchar(55) NOT NULL,
    `remark_date` varchar(55) NOT NULL,
    `rem_month` tinyint(2) NOT NULL,
    PRIMARY KEY (`remark_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_advisory` (
    `faculty_id` varchar(55) DEFAULT NULL,
    `grade_id` int(11) NOT NULL,
    `section_id` int(11) NOT NULL,
    `adv_id` int(11) NOT NULL AUTO_INCREMENT,
    `school_year` year(4) NOT NULL,
    PRIMARY KEY (`adv_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_attendance_log_book` (
    `log_id` int(11) NOT NULL AUTO_INCREMENT,
    `rfid` varchar(55) NOT NULL,
    `time` varchar(55) NOT NULL,
    `in_out` int(11) NOT NULL COMMENT '0 = out; 1 = in',
    `date` varchar(55) NOT NULL,
    PRIMARY KEY (`log_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_attendance_sheet` (
  `att_id` int(11) NOT NULL,
  `att_st_id` varchar(55) NOT NULL COMMENT 'students id number',
  `u_rfid` varchar(255) NOT NULL,
  `time_in` varchar(255) NOT NULL,
  `time_out` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time_in_pm` varchar(255) NOT NULL,
  `time_out_pm` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=time_out; 1=time_in',
  `remarks` int(11) NOT NULL,
  `remarks_from` varchar(55) NOT NULL,
  `scan_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `esk_attendance_summary` (
    `sum_id` int(11) NOT NULL AUTO_INCREMENT,
    `section_id` int(11) NOT NULL,
    `male_total` int(11) NOT NULL,
    `female_total` int(11) NOT NULL,
    `month` varchar(55) NOT NULL,
    `attend_auto` int(11) NOT NULL,
    `ave_male_total` float NOT NULL,
    `ave_female_total` float NOT NULL,
    `percent_male` float NOT NULL,
    `percent_female` float NOT NULL,
    PRIMARY KEY (`sum_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE `esk_barangay` (
    `barangay_id` int(11) NOT NULL AUTO_INCREMENT,
    `barangay` varchar(55) NOT NULL,
    PRIMARY KEY (`barangay_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_calendar` (
    `cal_id` int(11) NOT NULL AUTO_INCREMENT,
    `cal_date` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`cal_id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE `esk_calendar_events` (
  `event_date` date NOT NULL,
  `event` varchar(255) NOT NULL,
  `time_start` varchar(55) NOT NULL,
  `time_end` varchar(55) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `person_involved` varchar(55) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_calendar_events_category` (
    `cat_id` int(11) NOT NULL,
    `events_category` varchar(55) NOT NULL,
    PRIMARY KEY (`cat_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `esk_calendar_events_category` (`cat_id`, `events_category`) VALUES
(1, 'School'),
(2, 'Department'),
(3, 'Personal'),
(4, 'Legal Holiday');

CREATE TABLE `esk_chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_from` varchar(255) NOT NULL DEFAULT '',
  `chat_to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  `relation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE `esk_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mun_city` varchar(300) NOT NULL,
  `province_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `province_id` (`province_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1637 ;

--
-- Dumping data for table `esk_cities`
--

INSERT INTO `esk_cities` (`id`, `mun_city`, `province_id`) VALUES
(1, 'Bangued', 1),
(2, 'Boliney', 1),
(3, 'Bucay', 1),
(4, 'Bucloc', 1),
(5, 'Daguioman', 1),
(6, 'Danglas', 1),
(7, 'Dolores', 1),
(8, 'La Paz', 1),
(9, 'Lacub', 1),
(10, 'Lagangilang', 1),
(11, 'Lagayan', 1),
(12, 'Langiden', 1),
(13, 'Licuan-Baay', 1),
(14, 'Luba', 1),
(15, 'Malibcong', 1),
(16, 'Manabo', 1),
(17, 'Peñarrubia', 1),
(18, 'Pidigan', 1),
(19, 'Pilar', 1),
(20, 'Sallapadan', 1),
(21, 'San Isidro', 1),
(22, 'San Juan', 1),
(23, 'San Quintin', 1),
(24, 'Tayum', 1),
(25, 'Tineg', 1),
(26, 'Tubo', 1),
(27, 'Villaviciosa', 1),
(28, 'Butuan City', 2),
(29, 'Buenavista', 2),
(30, 'Cabadbaran', 2),
(31, 'Carmen', 2),
(32, 'Jabonga', 2),
(33, 'Kitcharao', 2),
(34, 'Las Nieves', 2),
(35, 'Magallanes', 2),
(36, 'Nasipit', 2),
(37, 'Remedios T. Romualdez', 2),
(38, 'Santiago', 2),
(39, 'Tubay', 2),
(40, 'Bayugan', 3),
(41, 'Bunawan', 3),
(42, 'Esperanza', 3),
(43, 'La Paz', 3),
(44, 'Loreto', 3),
(45, 'Prosperidad', 3),
(46, 'Rosario', 3),
(47, 'San Francisco', 3),
(48, 'San Luis', 3),
(49, 'Santa Josefa', 3),
(50, 'Sibagat', 3),
(51, 'Talacogon', 3),
(52, 'Trento', 3),
(53, 'Veruela', 3),
(54, 'Altavas', 4),
(55, 'Balete', 4),
(56, 'Banga', 4),
(57, 'Batan', 4),
(58, 'Buruanga', 4),
(59, 'Ibajay', 4),
(60, 'Kalibo', 4),
(61, 'Lezo', 4),
(62, 'Libacao', 4),
(63, 'Madalag', 4),
(64, 'Makato', 4),
(65, 'Malay', 4),
(66, 'Malinao', 4),
(67, 'Nabas', 4),
(68, 'New Washington', 4),
(69, 'Numancia', 4),
(70, 'Tangalan', 4),
(71, 'Legazpi City', 5),
(72, 'Ligao City', 5),
(73, 'Tabaco City', 5),
(74, 'Bacacay', 5),
(75, 'Camalig', 5),
(76, 'Daraga', 5),
(77, 'Guinobatan', 5),
(78, 'Jovellar', 5),
(79, 'Libon', 5),
(80, 'Malilipot', 5),
(81, 'Malinao', 5),
(82, 'Manito', 5),
(83, 'Oas', 5),
(84, 'Pio Duran', 5),
(85, 'Polangui', 5),
(86, 'Rapu-Rapu', 5),
(87, 'Santo Domingo', 5),
(88, 'Tiwi', 5),
(89, 'Anini-y', 6),
(90, 'Barbaza', 6),
(91, 'Belison', 6),
(92, 'Bugasong', 6),
(93, 'Caluya', 6),
(94, 'Culasi', 6),
(95, 'Hamtic', 6),
(96, 'Laua-an', 6),
(97, 'Libertad', 6),
(98, 'Pandan', 6),
(99, 'Patnongon', 6),
(100, 'San Jose', 6),
(101, 'San Remigio', 6),
(102, 'Sebaste', 6),
(103, 'Sibalom', 6),
(104, 'Tibiao', 6),
(105, 'Tobias Fornier', 6),
(106, 'Valderrama', 6),
(107, 'Calanasan', 7),
(108, 'Conner', 7),
(109, 'Flora', 7),
(110, 'Kabugao', 7),
(111, 'Luna', 7),
(112, 'Pudtol', 7),
(113, 'Santa Marcela', 7),
(114, 'Baler', 8),
(115, 'Casiguran', 8),
(116, 'Dilasag', 8),
(117, 'Dinalungan', 8),
(118, 'Dingalan', 8),
(119, 'Dipaculao', 8),
(120, 'Maria Aurora', 8),
(121, 'San Luis', 8),
(122, 'Isabela City', 9),
(123, 'Akbar', 9),
(124, 'Al-Barka', 9),
(125, 'Hadji Mohammad Ajul', 9),
(126, 'Hadji Muhtamad', 9),
(127, 'Lamitan', 9),
(128, 'Lantawan', 9),
(129, 'Maluso', 9),
(130, 'Sumisip', 9),
(131, 'Tabuan-Lasa', 9),
(132, 'Tipo-Tipo', 9),
(133, 'Tuburan', 9),
(134, 'Ungkaya Pukan', 9),
(135, 'Balanga City', 10),
(136, 'Abucay', 10),
(137, 'Bagac', 10),
(138, 'Dinalupihan', 10),
(139, 'Hermosa', 10),
(140, 'Limay', 10),
(141, 'Mariveles', 10),
(142, 'Morong', 10),
(143, 'Orani', 10),
(144, 'Orion', 10),
(145, 'Pilar', 10),
(146, 'Samal', 10),
(147, 'Basco', 11),
(148, 'Itbayat', 11),
(149, 'Ivana', 11),
(150, 'Mahatao', 11),
(151, 'Sabtang', 11),
(152, 'Uyugan', 11),
(153, 'Batangas City', 12),
(154, 'Lipa City', 12),
(155, 'Tanauan City', 12),
(156, 'Agoncillo', 12),
(157, 'Alitagtag', 12),
(158, 'Balayan', 12),
(159, 'Balete', 12),
(160, 'Bauan', 12),
(161, 'Calaca', 12),
(162, 'Calatagan', 12),
(163, 'Cuenca', 12),
(164, 'Ibaan', 12),
(165, 'Laurel', 12),
(166, 'Lemery', 12),
(167, 'Lian', 12),
(168, 'Lobo', 12),
(169, 'Mabini', 12),
(170, 'Malvar', 12),
(171, 'Mataas na Kahoy', 12),
(172, 'Nasugbu', 12),
(173, 'Padre Garcia', 12),
(174, 'Rosario', 12),
(175, 'San Jose', 12),
(176, 'San Juan', 12),
(177, 'San Luis', 12),
(178, 'San Nicolas', 12),
(179, 'San Pascual', 12),
(180, 'Santa Teresita', 12),
(181, 'Santo Tomas', 12),
(182, 'Taal', 12),
(183, 'Talisay', 12),
(184, 'Taysan', 12),
(185, 'Tingloy', 12),
(186, 'Tuy', 12),
(187, 'Baguio City', 13),
(188, 'Atok', 13),
(189, 'Bakun', 13),
(190, 'Bokod', 13),
(191, 'Buguias', 13),
(192, 'Itogon', 13),
(193, 'Kabayan', 13),
(194, 'Kapangan', 13),
(195, 'Kibungan', 13),
(196, 'La Trinidad', 13),
(197, 'Mankayan', 13),
(198, 'Sablan', 13),
(199, 'Tuba', 13),
(200, 'Tublay', 13),
(201, 'Almeria', 14),
(202, 'Biliran', 14),
(203, 'Cabucgayan', 14),
(204, 'Caibiran', 14),
(205, 'Culaba', 14),
(206, 'Kawayan', 14),
(207, 'Maripipi', 14),
(208, 'Naval', 14),
(209, 'Tagbilaran City', 15),
(210, 'Alburquerque', 15),
(211, 'Alicia', 15),
(212, 'Anda', 15),
(213, 'Antequera', 15),
(214, 'Baclayon', 15),
(215, 'Balilihan', 15),
(216, 'Batuan', 15),
(217, 'Bien Unido', 15),
(218, 'Bilar', 15),
(219, 'Buenavista', 15),
(220, 'Calape', 15),
(221, 'Candijay', 15),
(222, 'Carmen', 15),
(223, 'Catigbian', 15),
(224, 'Clarin', 15),
(225, 'Corella', 15),
(226, 'Cortes', 15),
(227, 'Dagohoy', 15),
(228, 'Danao', 15),
(229, 'Dauis', 15),
(230, 'Dimiao', 15),
(231, 'Duero', 15),
(232, 'Garcia Hernandez', 15),
(233, 'Getafe', 15),
(234, 'Guindulman', 15),
(235, 'Inabanga', 15),
(236, 'Jagna', 15),
(237, 'Lila', 15),
(238, 'Loay', 15),
(239, 'Loboc', 15),
(240, 'Loon', 15),
(241, 'Mabini', 15),
(242, 'Maribojoc', 15),
(243, 'Panglao', 15),
(244, 'Pilar', 15),
(245, 'President Carlos P. Garcia', 15),
(246, 'Sagbayan', 15),
(247, 'San Isidro', 15),
(248, 'San Miguel', 15),
(249, 'Sevilla', 15),
(250, 'Sierra Bullones', 15),
(251, 'Sikatuna', 15),
(252, 'Talibon', 15),
(253, 'Trinidad', 15),
(254, 'Tubigon', 15),
(255, 'Ubay', 15),
(256, 'Valencia', 15),
(257, 'Malaybalay City', 16),
(258, 'Valencia City', 16),
(259, 'Baungon', 16),
(260, 'Cabanglasan', 16),
(261, 'Damulog', 16),
(262, 'Dangcagan', 16),
(263, 'Don Carlos', 16),
(264, 'Impasug-ong', 16),
(265, 'Kadingilan', 16),
(266, 'Kalilangan', 16),
(267, 'Kibawe', 16),
(268, 'Kitaotao', 16),
(269, 'Lantapan', 16),
(270, 'Libona', 16),
(271, 'Malitbog', 16),
(272, 'Manolo Fortich', 16),
(273, 'Maramag', 16),
(274, 'Pangantucan', 16),
(275, 'Quezon', 16),
(276, 'San Fernando', 16),
(277, 'Sumilao', 16),
(278, 'Talakag', 16),
(279, 'Malolos City', 17),
(280, 'Meycauayan City', 17),
(281, 'San Jose del Monte City', 17),
(282, 'Angat', 17),
(283, 'Balagtas', 17),
(284, 'Baliuag', 17),
(285, 'Bocaue', 17),
(286, 'Bulacan', 17),
(287, 'Bustos', 17),
(288, 'Calumpit', 17),
(289, 'Doña Remedios Trinidad', 17),
(290, 'Guiguinto', 17),
(291, 'Hagonoy', 17),
(292, 'Marilao', 17),
(293, 'Norzagaray', 17),
(294, 'Obando', 17),
(295, 'Pandi', 17),
(296, 'Paombong', 17),
(297, 'Plaridel', 17),
(298, 'Pulilan', 17),
(299, 'San Ildefonso', 17),
(300, 'San Miguel', 17),
(301, 'San Rafael', 17),
(302, 'Santa Maria', 17),
(303, 'Tuguegarao City', 18),
(304, 'Abulug', 18),
(305, 'Alcala', 18),
(306, 'Allacapan', 18),
(307, 'Amulung', 18),
(308, 'Aparri', 18),
(309, 'Baggao', 18),
(310, 'Ballesteros', 18),
(311, 'Buguey', 18),
(312, 'Calayan', 18),
(313, 'Camalaniugan', 18),
(314, 'Claveria', 18),
(315, 'Enrile', 18),
(316, 'Gattaran', 18),
(317, 'Gonzaga', 18),
(318, 'Iguig', 18),
(319, 'Lal-lo', 18),
(320, 'Lasam', 18),
(321, 'Pamplona', 18),
(322, 'Peñablanca', 18),
(323, 'Piat', 18),
(324, 'Rizal', 18),
(325, 'Sanchez-Mira', 18),
(326, 'Santa Ana', 18),
(327, 'Santa Praxedes', 18),
(328, 'Santa Teresita', 18),
(329, 'Santo Niño', 18),
(330, 'Solana', 18),
(331, 'Tuao', 18),
(332, 'Basud', 19),
(333, 'Capalonga', 19),
(334, 'Daet', 19),
(335, 'Jose Panganiban', 19),
(336, 'Labo', 19),
(337, 'Mercedes', 19),
(338, 'Paracale', 19),
(339, 'San Lorenzo Ruiz', 19),
(340, 'San Vicente', 19),
(341, 'Santa Elena', 19),
(342, 'Talisay', 19),
(343, 'Vinzons', 19),
(344, 'Iriga City', 20),
(345, 'Naga City', 20),
(346, 'Baao', 20),
(347, 'Balatan', 20),
(348, 'Bato', 20),
(349, 'Bombon', 20),
(350, 'Buhi', 20),
(351, 'Bula', 20),
(352, 'Cabusao', 20),
(353, 'Calabanga', 20),
(354, 'Camaligan', 20),
(355, 'Canaman', 20),
(356, 'Caramoan', 20),
(357, 'Del Gallego', 20),
(358, 'Gainza', 20),
(359, 'Garchitorena', 20),
(360, 'Goa', 20),
(361, 'Lagonoy', 20),
(362, 'Libmanan', 20),
(363, 'Lupi', 20),
(364, 'Magarao', 20),
(365, 'Milaor', 20),
(366, 'Minalabac', 20),
(367, 'Nabua', 20),
(368, 'Ocampo', 20),
(369, 'Pamplona', 20),
(370, 'Pasacao', 20),
(371, 'Pili', 20),
(372, 'Presentacion', 20),
(373, 'Ragay', 20),
(374, 'Sagñay', 20),
(375, 'San Fernando', 20),
(376, 'San Jose', 20),
(377, 'Sipocot', 20),
(378, 'Siruma', 20),
(379, 'Tigaon', 20),
(380, 'Tinambac', 20),
(381, 'Catarman', 21),
(382, 'Guinsiliban', 21),
(383, 'Mahinog', 21),
(384, 'Mambajao', 21),
(385, 'Sagay', 21),
(386, 'Roxas City', 22),
(387, 'Cuartero', 22),
(388, 'Dao', 22),
(389, 'Dumalag', 22),
(390, 'Dumarao', 22),
(391, 'Ivisan', 22),
(392, 'Jamindan', 22),
(393, 'Ma-ayon', 22),
(394, 'Mambusao', 22),
(395, 'Panay', 22),
(396, 'Panitan', 22),
(397, 'Pilar', 22),
(398, 'Pontevedra', 22),
(399, 'President Roxas', 22),
(400, 'Sapi-an', 22),
(401, 'Sigma', 22),
(402, 'Tapaz', 22),
(403, 'Bagamanoc', 23),
(404, 'Baras', 23),
(405, 'Bato', 23),
(406, 'Caramoran', 23),
(407, 'Gigmoto', 23),
(408, 'Pandan', 23),
(409, 'Panganiban', 23),
(410, 'San Andres', 23),
(411, 'San Miguel', 23),
(412, 'Viga', 23),
(413, 'Virac', 23),
(414, 'Cavite City', 24),
(415, 'Dasmariñas City', 24),
(416, 'Tagaytay City', 24),
(417, 'Trece Martires City', 24),
(418, 'Alfonso', 24),
(419, 'Amadeo', 24),
(420, 'Bacoor', 24),
(421, 'Carmona', 24),
(422, 'General Mariano Alvarez', 24),
(423, 'General Emilio Aguinaldo', 24),
(424, 'General Trias', 24),
(425, 'Imus', 24),
(426, 'Indang', 24),
(427, 'Kawit', 24),
(428, 'Magallanes', 24),
(429, 'Maragondon', 24),
(430, 'Mendez', 24),
(431, 'Naic', 24),
(432, 'Noveleta', 24),
(433, 'Rosario', 24),
(434, 'Silang', 24),
(435, 'Tanza', 24),
(436, 'Ternate', 24),
(437, 'Bogo City', 25),
(438, 'Cebu City', 25),
(439, 'Carcar City', 25),
(440, 'Danao City', 25),
(441, 'Lapu-Lapu City', 25),
(442, 'Mandaue City', 25),
(443, 'Naga City', 25),
(444, 'Talisay City', 25),
(445, 'Toledo City', 25),
(446, 'Alcantara', 25),
(447, 'Alcoy', 25),
(448, 'Alegria', 25),
(449, 'Aloguinsan', 25),
(450, 'Argao', 25),
(451, 'Asturias', 25),
(452, 'Badian', 25),
(453, 'Balamban', 25),
(454, 'Bantayan', 25),
(455, 'Barili', 25),
(456, 'Boljoon', 25),
(457, 'Borbon', 25),
(458, 'Carmen', 25),
(459, 'Catmon', 25),
(460, 'Compostela', 25),
(461, 'Consolacion', 25),
(462, 'Cordoba', 25),
(463, 'Daanbantayan', 25),
(464, 'Dalaguete', 25),
(465, 'Dumanjug', 25),
(466, 'Ginatilan', 25),
(467, 'Liloan', 25),
(468, 'Madridejos', 25),
(469, 'Malabuyoc', 25),
(470, 'Medellin', 25),
(471, 'Minglanilla', 25),
(472, 'Moalboal', 25),
(473, 'Oslob', 25),
(474, 'Pilar', 25),
(475, 'Pinamungahan', 25),
(476, 'Poro', 25),
(477, 'Ronda', 25),
(478, 'Samboan', 25),
(479, 'San Fernando', 25),
(480, 'San Francisco', 25),
(481, 'San Remigio', 25),
(482, 'Santa Fe', 25),
(483, 'Santander', 25),
(484, 'Sibonga', 25),
(485, 'Sogod', 25),
(486, 'Tabogon', 25),
(487, 'Tabuelan', 25),
(488, 'Tuburan', 25),
(489, 'Tudela', 25),
(490, 'Compostela', 26),
(491, 'Laak', 26),
(492, 'Mabini', 26),
(493, 'Maco', 26),
(494, 'Maragusan', 26),
(495, 'Mawab', 26),
(496, 'Monkayo', 26),
(497, 'Montevista', 26),
(498, 'Nabunturan', 26),
(499, 'New Bataan', 26),
(500, 'Pantukan', 26),
(501, 'Kidapawan City', 27),
(502, 'Alamada', 27),
(503, 'Aleosan', 27),
(504, 'Antipas', 27),
(505, 'Arakan', 27),
(506, 'Banisilan', 27),
(507, 'Carmen', 27),
(508, 'Kabacan', 27),
(509, 'Libungan', 27),
(510, 'M''lang', 27),
(511, 'Magpet', 27),
(512, 'Makilala', 27),
(513, 'Matalam', 27),
(514, 'Midsayap', 27),
(515, 'Pigkawayan', 27),
(516, 'Pikit', 27),
(517, 'President Roxas', 27),
(518, 'Tulunan', 27),
(519, 'Panabo City', 28),
(520, 'Island Garden City of Samal', 28),
(521, 'Tagum City', 28),
(522, 'Asuncion', 28),
(523, 'Braulio E. Dujali', 28),
(524, 'Carmen', 28),
(525, 'Kapalong', 28),
(526, 'New Corella', 28),
(527, 'San Isidro', 28),
(528, 'Santo Tomas', 28),
(529, 'Talaingod', 28),
(530, 'Davao City', 29),
(531, 'Digos City', 29),
(532, 'Bansalan', 29),
(533, 'Don Marcelino', 29),
(534, 'Hagonoy', 29),
(535, 'Jose Abad Santos', 29),
(536, 'Kiblawan', 29),
(537, 'Magsaysay', 29),
(538, 'Malalag', 29),
(539, 'Malita', 29),
(540, 'Matanao', 29),
(541, 'Padada', 29),
(542, 'Santa Cruz', 29),
(543, 'Santa Maria', 29),
(544, 'Sarangani', 29),
(545, 'Sulop', 29),
(546, 'Mati City', 30),
(547, 'Baganga', 30),
(548, 'Banaybanay', 30),
(549, 'Boston', 30),
(550, 'Caraga', 30),
(551, 'Cateel', 30),
(552, 'Governor Generoso', 30),
(553, 'Lupon', 30),
(554, 'Manay', 30),
(555, 'San Isidro', 30),
(556, 'Tarragona', 30),
(557, 'Arteche', 31),
(558, 'Balangiga', 31),
(559, 'Balangkayan', 31),
(560, 'Borongan', 31),
(561, 'Can-avid', 31),
(562, 'Dolores', 31),
(563, 'General MacArthur', 31),
(564, 'Giporlos', 31),
(565, 'Guiuan', 31),
(566, 'Hernani', 31),
(567, 'Jipapad', 31),
(568, 'Lawaan', 31),
(569, 'Llorente', 31),
(570, 'Maslog', 31),
(571, 'Maydolong', 31),
(572, 'Mercedes', 31),
(573, 'Oras', 31),
(574, 'Quinapondan', 31),
(575, 'Salcedo', 31),
(576, 'San Julian', 31),
(577, 'San Policarpo', 31),
(578, 'Sulat', 31),
(579, 'Taft', 31),
(580, 'Buenavista', 32),
(581, 'Jordan', 32),
(582, 'Nueva Valencia', 32),
(583, 'San Lorenzo', 32),
(584, 'Sibunag', 32),
(585, 'Aguinaldo', 33),
(586, 'Alfonso Lista', 33),
(587, 'Asipulo', 33),
(588, 'Banaue', 33),
(589, 'Hingyon', 33),
(590, 'Hungduan', 33),
(591, 'Kiangan', 33),
(592, 'Lagawe', 33),
(593, 'Lamut', 33),
(594, 'Mayoyao', 33),
(595, 'Tinoc', 33),
(596, 'Batac City', 34),
(597, 'Laoag City', 34),
(598, 'Adams', 34),
(599, 'Bacarra', 34),
(600, 'Badoc', 34),
(601, 'Bangui', 34),
(602, 'Banna', 34),
(603, 'Burgos', 34),
(604, 'Carasi', 34),
(605, 'Currimao', 34),
(606, 'Dingras', 34),
(607, 'Dumalneg', 34),
(608, 'Marcos', 34),
(609, 'Nueva Era', 34),
(610, 'Pagudpud', 34),
(611, 'Paoay', 34),
(612, 'Pasuquin', 34),
(613, 'Piddig', 34),
(614, 'Pinili', 34),
(615, 'San Nicolas', 34),
(616, 'Sarrat', 34),
(617, 'Solsona', 34),
(618, 'Vintar', 34),
(619, 'Candon City', 35),
(620, 'Vigan City', 35),
(621, 'Alilem', 35),
(622, 'Banayoyo', 35),
(623, 'Bantay', 35),
(624, 'Burgos', 35),
(625, 'Cabugao', 35),
(626, 'Caoayan', 35),
(627, 'Cervantes', 35),
(628, 'Galimuyod', 35),
(629, 'Gregorio Del Pilar', 35),
(630, 'Lidlidda', 35),
(631, 'Magsingal', 35),
(632, 'Nagbukel', 35),
(633, 'Narvacan', 35),
(634, 'Quirino', 35),
(635, 'Salcedo', 35),
(636, 'San Emilio', 35),
(637, 'San Esteban', 35),
(638, 'San Ildefonso', 35),
(639, 'San Juan', 35),
(640, 'San Vicente', 35),
(641, 'Santa', 35),
(642, 'Santa Catalina', 35),
(643, 'Santa Cruz', 35),
(644, 'Santa Lucia', 35),
(645, 'Santa Maria', 35),
(646, 'Santiago', 35),
(647, 'Santo Domingo', 35),
(648, 'Sigay', 35),
(649, 'Sinait', 35),
(650, 'Sugpon', 35),
(651, 'Suyo', 35),
(652, 'Tagudin', 35),
(653, 'Iloilo City', 36),
(654, 'Passi City', 36),
(655, 'Ajuy', 36),
(656, 'Alimodian', 36),
(657, 'Anilao', 36),
(658, 'Badiangan', 36),
(659, 'Balasan', 36),
(660, 'Banate', 36),
(661, 'Barotac Nuevo', 36),
(662, 'Barotac Viejo', 36),
(663, 'Batad', 36),
(664, 'Bingawan', 36),
(665, 'Cabatuan', 36),
(666, 'Calinog', 36),
(667, 'Carles', 36),
(668, 'Concepcion', 36),
(669, 'Dingle', 36),
(670, 'Dueñas', 36),
(671, 'Dumangas', 36),
(672, 'Estancia', 36),
(673, 'Guimbal', 36),
(674, 'Igbaras', 36),
(675, 'Janiuay', 36),
(676, 'Lambunao', 36),
(677, 'Leganes', 36),
(678, 'Lemery', 36),
(679, 'Leon', 36),
(680, 'Maasin', 36),
(681, 'Miagao', 36),
(682, 'Mina', 36),
(683, 'New Lucena', 36),
(684, 'Oton', 36),
(685, 'Pavia', 36),
(686, 'Pototan', 36),
(687, 'San Dionisio', 36),
(688, 'San Enrique', 36),
(689, 'San Joaquin', 36),
(690, 'San Miguel', 36),
(691, 'San Rafael', 36),
(692, 'Santa Barbara', 36),
(693, 'Sara', 36),
(694, 'Tigbauan', 36),
(695, 'Tubungan', 36),
(696, 'Zarraga', 36),
(697, 'Cauayan City', 37),
(698, 'Santiago City', 37),
(699, 'Alicia', 37),
(700, 'Angadanan', 37),
(701, 'Aurora', 37),
(702, 'Benito Soliven', 37),
(703, 'Burgos', 37),
(704, 'Cabagan', 37),
(705, 'Cabatuan', 37),
(706, 'Cordon', 37),
(707, 'Delfin Albano', 37),
(708, 'Dinapigue', 37),
(709, 'Divilacan', 37),
(710, 'Echague', 37),
(711, 'Gamu', 37),
(712, 'Ilagan', 37),
(713, 'Jones', 37),
(714, 'Luna', 37),
(715, 'Maconacon', 37),
(716, 'Mallig', 37),
(717, 'Naguilian', 37),
(718, 'Palanan', 37),
(719, 'Quezon', 37),
(720, 'Quirino', 37),
(721, 'Ramon', 37),
(722, 'Reina Mercedes', 37),
(723, 'Roxas', 37),
(724, 'San Agustin', 37),
(725, 'San Guillermo', 37),
(726, 'San Isidro', 37),
(727, 'San Manuel', 37),
(728, 'San Mariano', 37),
(729, 'San Mateo', 37),
(730, 'San Pablo', 37),
(731, 'Santa Maria', 37),
(732, 'Santo Tomas', 37),
(733, 'Tumauini', 37),
(734, 'Tabuk', 38),
(735, 'Balbalan', 38),
(736, 'Lubuagan', 38),
(737, 'Pasil', 38),
(738, 'Pinukpuk', 38),
(739, 'Rizal', 38),
(740, 'Tanudan', 38),
(741, 'Tinglayan', 38),
(742, 'San Fernando City', 39),
(743, 'Agoo', 39),
(744, 'Aringay', 39),
(745, 'Bacnotan', 39),
(746, 'Bagulin', 39),
(747, 'Balaoan', 39),
(748, 'Bangar', 39),
(749, 'Bauang', 39),
(750, 'Burgos', 39),
(751, 'Caba', 39),
(752, 'Luna', 39),
(753, 'Naguilian', 39),
(754, 'Pugo', 39),
(755, 'Rosario', 39),
(756, 'San Gabriel', 39),
(757, 'San Juan', 39),
(758, 'Santo Tomas', 39),
(759, 'Santol', 39),
(760, 'Sudipen', 39),
(761, 'Tubao', 39),
(762, 'Biñan City', 40),
(763, 'Calamba City', 40),
(764, 'San Pablo City', 40),
(765, 'Santa Rosa City', 40),
(766, 'Alaminos', 40),
(767, 'Bay', 40),
(768, 'Cabuyao', 40),
(769, 'Calauan', 40),
(770, 'Cavinti', 40),
(771, 'Famy', 40),
(772, 'Kalayaan', 40),
(773, 'Liliw', 40),
(774, 'Los Baños', 40),
(775, 'Luisiana', 40),
(776, 'Lumban', 40),
(777, 'Mabitac', 40),
(778, 'Magdalena', 40),
(779, 'Majayjay', 40),
(780, 'Nagcarlan', 40),
(781, 'Paete', 40),
(782, 'Pagsanjan', 40),
(783, 'Pakil', 40),
(784, 'Pangil', 40),
(785, 'Pila', 40),
(786, 'Rizal', 40),
(787, 'San Pedro', 40),
(788, 'Santa Cruz', 40),
(789, 'Santa Maria', 40),
(790, 'Siniloan', 40),
(791, 'Victoria', 40),
(792, 'Iligan City', 41),
(793, 'Bacolod', 41),
(794, 'Baloi', 41),
(795, 'Baroy', 41),
(796, 'Kapatagan', 41),
(797, 'Kauswagan', 41),
(798, 'Kolambugan', 41),
(799, 'Lala', 41),
(800, 'Linamon', 41),
(801, 'Magsaysay', 41),
(802, 'Maigo', 41),
(803, 'Matungao', 41),
(804, 'Munai', 41),
(805, 'Nunungan', 41),
(806, 'Pantao Ragat', 41),
(807, 'Pantar', 41),
(808, 'Poona Piagapo', 41),
(809, 'Salvador', 41),
(810, 'Sapad', 41),
(811, 'Sultan Naga Dimaporo', 41),
(812, 'Tagoloan', 41),
(813, 'Tangcal', 41),
(814, 'Tubod', 41),
(815, 'Marawi City', 42),
(816, 'Bacolod-Kalawi', 42),
(817, 'Balabagan', 42),
(818, 'Balindong', 42),
(819, 'Bayang', 42),
(820, 'Binidayan', 42),
(821, 'Buadiposo-Buntong', 42),
(822, 'Bubong', 42),
(823, 'Bumbaran', 42),
(824, 'Butig', 42),
(825, 'Calanogas', 42),
(826, 'Ditsaan-Ramain', 42),
(827, 'Ganassi', 42),
(828, 'Kapai', 42),
(829, 'Kapatagan', 42),
(830, 'Lumba-Bayabao', 42),
(831, 'Lumbaca-Unayan', 42),
(832, 'Lumbatan', 42),
(833, 'Lumbayanague', 42),
(834, 'Madalum', 42),
(835, 'Madamba', 42),
(836, 'Maguing', 42),
(837, 'Malabang', 42),
(838, 'Marantao', 42),
(839, 'Marogong', 42),
(840, 'Masiu', 42),
(841, 'Mulondo', 42),
(842, 'Pagayawan', 42),
(843, 'Piagapo', 42),
(844, 'Poona Bayabao', 42),
(845, 'Pualas', 42),
(846, 'Saguiaran', 42),
(847, 'Sultan Dumalondong', 42),
(848, 'Picong', 42),
(849, 'Tagoloan II', 42),
(850, 'Tamparan', 42),
(851, 'Taraka', 42),
(852, 'Tubaran', 42),
(853, 'Tugaya', 42),
(854, 'Wao', 42),
(855, 'Ormoc City', 43),
(856, 'Tacloban City', 43),
(857, 'Abuyog', 43),
(858, 'Alangalang', 43),
(859, 'Albuera', 43),
(860, 'Babatngon', 43),
(861, 'Barugo', 43),
(862, 'Bato', 43),
(863, 'Baybay', 43),
(864, 'Burauen', 43),
(865, 'Calubian', 43),
(866, 'Capoocan', 43),
(867, 'Carigara', 43),
(868, 'Dagami', 43),
(869, 'Dulag', 43),
(870, 'Hilongos', 43),
(871, 'Hindang', 43),
(872, 'Inopacan', 43),
(873, 'Isabel', 43),
(874, 'Jaro', 43),
(875, 'Javier', 43),
(876, 'Julita', 43),
(877, 'Kananga', 43),
(878, 'La Paz', 43),
(879, 'Leyte', 43),
(880, 'Liloan', 43),
(881, 'MacArthur', 43),
(882, 'Mahaplag', 43),
(883, 'Matag-ob', 43),
(884, 'Matalom', 43),
(885, 'Mayorga', 43),
(886, 'Merida', 43),
(887, 'Palo', 43),
(888, 'Palompon', 43),
(889, 'Pastrana', 43),
(890, 'San Isidro', 43),
(891, 'San Miguel', 43),
(892, 'Santa Fe', 43),
(893, 'Sogod', 43),
(894, 'Tabango', 43),
(895, 'Tabontabon', 43),
(896, 'Tanauan', 43),
(897, 'Tolosa', 43),
(898, 'Tunga', 43),
(899, 'Villaba', 43),
(900, 'Cotabato City', 44),
(901, 'Ampatuan', 44),
(902, 'Barira', 44),
(903, 'Buldon', 44),
(904, 'Buluan', 44),
(905, 'Datu Abdullah Sangki', 44),
(906, 'Datu Anggal Midtimbang', 44),
(907, 'Datu Blah T. Sinsuat', 44),
(908, 'Datu Hoffer Ampatuan', 44),
(909, 'Datu Montawal', 44),
(910, 'Datu Odin Sinsuat', 44),
(911, 'Datu Paglas', 44),
(912, 'Datu Piang', 44),
(913, 'Datu Salibo', 44),
(914, 'Datu Saudi-Ampatuan', 44),
(915, 'Datu Unsay', 44),
(916, 'General Salipada K. Pendatun', 44),
(917, 'Guindulungan', 44),
(918, 'Kabuntalan', 44),
(919, 'Mamasapano', 44),
(920, 'Mangudadatu', 44),
(921, 'Matanog', 44),
(922, 'Northern Kabuntalan', 44),
(923, 'Pagalungan', 44),
(924, 'Paglat', 44),
(925, 'Pandag', 44),
(926, 'Parang', 44),
(927, 'Rajah Buayan', 44),
(928, 'Shariff Aguak', 44),
(929, 'Shariff Saydona Mustapha', 44),
(930, 'South Upi', 44),
(931, 'Sultan Kudarat', 44),
(932, 'Sultan Mastura', 44),
(933, 'Sultan sa Barongis', 44),
(934, 'Talayan', 44),
(935, 'Talitay', 44),
(936, 'Upi', 44),
(937, 'Boac', 45),
(938, 'Buenavista', 45),
(939, 'Gasan', 45),
(940, 'Mogpog', 45),
(941, 'Santa Cruz', 45),
(942, 'Torrijos', 45),
(943, 'Masbate City', 46),
(944, 'Aroroy', 46),
(945, 'Baleno', 46),
(946, 'Balud', 46),
(947, 'Batuan', 46),
(948, 'Cataingan', 46),
(949, 'Cawayan', 46),
(950, 'Claveria', 46),
(951, 'Dimasalang', 46),
(952, 'Esperanza', 46),
(953, 'Mandaon', 46),
(954, 'Milagros', 46),
(955, 'Mobo', 46),
(956, 'Monreal', 46),
(957, 'Palanas', 46),
(958, 'Pio V. Corpuz', 46),
(959, 'Placer', 46),
(960, 'San Fernando', 46),
(961, 'San Jacinto', 46),
(962, 'San Pascual', 46),
(963, 'Uson', 46),
(964, 'Caloocan', 47),
(965, 'Las Piñas', 47),
(966, 'Makati', 47),
(967, 'Malabon', 47),
(968, 'Mandaluyong', 47),
(969, 'Manila', 47),
(970, 'Marikina', 47),
(971, 'Muntinlupa', 47),
(972, 'Navotas', 47),
(973, 'Parañaque', 47),
(974, 'Pasay', 47),
(975, 'Pasig', 47),
(976, 'Quezon City', 47),
(977, 'San Juan City', 47),
(978, 'Taguig', 47),
(979, 'Valenzuela City', 47),
(980, 'Pateros', 47),
(981, 'Oroquieta City', 48),
(982, 'Ozamiz City', 48),
(983, 'Tangub City', 48),
(984, 'Aloran', 48),
(985, 'Baliangao', 48),
(986, 'Bonifacio', 48),
(987, 'Calamba', 48),
(988, 'Clarin', 48),
(989, 'Concepcion', 48),
(990, 'Don Victoriano Chiongbian', 48),
(991, 'Jimenez', 48),
(992, 'Lopez Jaena', 48),
(993, 'Panaon', 48),
(994, 'Plaridel', 48),
(995, 'Sapang Dalaga', 48),
(996, 'Sinacaban', 48),
(997, 'Tudela', 48),
(998, 'Cagayan de Oro City', 49),
(999, 'Gingoog City', 49),
(1000, 'Alubijid', 49),
(1001, 'Balingasag', 49),
(1002, 'Balingoan', 49),
(1003, 'Binuangan', 49),
(1004, 'Claveria', 49),
(1005, 'El Salvador', 49),
(1006, 'Gitagum', 49),
(1007, 'Initao', 49),
(1008, 'Jasaan', 49),
(1009, 'Kinoguitan', 49),
(1010, 'Lagonglong', 49),
(1011, 'Laguindingan', 49),
(1012, 'Libertad', 49),
(1013, 'Lugait', 49),
(1014, 'Magsaysay', 49),
(1015, 'Manticao', 49),
(1016, 'Medina', 49),
(1017, 'Naawan', 49),
(1018, 'Opol', 49),
(1019, 'Salay', 49),
(1020, 'Sugbongcogon', 49),
(1021, 'Tagoloan', 49),
(1022, 'Talisayan', 49),
(1023, 'Villanueva', 49),
(1024, 'Barlig', 50),
(1025, 'Bauko', 50),
(1026, 'Besao', 50),
(1027, 'Bontoc', 50),
(1028, 'Natonin', 50),
(1029, 'Paracelis', 50),
(1030, 'Sabangan', 50),
(1031, 'Sadanga', 50),
(1032, 'Sagada', 50),
(1033, 'Tadian', 50),
(1034, 'Bacolod City', 51),
(1035, 'Bago City', 51),
(1036, 'Cadiz City', 51),
(1037, 'Escalante City', 51),
(1038, 'Himamaylan City', 51),
(1039, 'Kabankalan City', 51),
(1040, 'La Carlota City', 51),
(1041, 'Sagay City', 51),
(1042, 'San Carlos City', 51),
(1043, 'Silay City', 51),
(1044, 'Sipalay City', 51),
(1045, 'Talisay City', 51),
(1046, 'Victorias City', 51),
(1047, 'Binalbagan', 51),
(1048, 'Calatrava', 51),
(1049, 'Candoni', 51),
(1050, 'Cauayan', 51),
(1051, 'Enrique B. Magalona', 51),
(1052, 'Hinigaran', 51),
(1053, 'Hinoba-an', 51),
(1054, 'Ilog', 51),
(1055, 'Isabela', 51),
(1056, 'La Castellana', 51),
(1057, 'Manapla', 51),
(1058, 'Moises Padilla', 51),
(1059, 'Murcia', 51),
(1060, 'Pontevedra', 51),
(1061, 'Pulupandan', 51),
(1062, 'Salvador Benedicto', 51),
(1063, 'San Enrique', 51),
(1064, 'Toboso', 51),
(1065, 'Valladolid', 51),
(1066, 'Bais City', 52),
(1067, 'Bayawan City', 52),
(1068, 'Canlaon City', 52),
(1069, 'Guihulngan City', 52),
(1070, 'Dumaguete City', 52),
(1071, 'Tanjay City', 52),
(1072, 'Amlan', 52),
(1073, 'Ayungon', 52),
(1074, 'Bacong', 52),
(1075, 'Basay', 52),
(1076, 'Bindoy', 52),
(1077, 'Dauin', 52),
(1078, 'Jimalalud', 52),
(1079, 'La Libertad', 52),
(1080, 'Mabinay', 52),
(1081, 'Manjuyod', 52),
(1082, 'Pamplona', 52),
(1083, 'San Jose', 52),
(1084, 'Santa Catalina', 52),
(1085, 'Siaton', 52),
(1086, 'Sibulan', 52),
(1087, 'Tayasan', 52),
(1088, 'Valencia', 52),
(1089, 'Vallehermoso', 52),
(1090, 'Zamboanguita', 52),
(1091, 'Allen', 53),
(1092, 'Biri', 53),
(1093, 'Bobon', 53),
(1094, 'Capul', 53),
(1095, 'Catarman', 53),
(1096, 'Catubig', 53),
(1097, 'Gamay', 53),
(1098, 'Laoang', 53),
(1099, 'Lapinig', 53),
(1100, 'Las Navas', 53),
(1101, 'Lavezares', 53),
(1102, 'Lope de Vega', 53),
(1103, 'Mapanas', 53),
(1104, 'Mondragon', 53),
(1105, 'Palapag', 53),
(1106, 'Pambujan', 53),
(1107, 'Rosario', 53),
(1108, 'San Antonio', 53),
(1109, 'San Isidro', 53),
(1110, 'San Jose', 53),
(1111, 'San Roque', 53),
(1112, 'San Vicente', 53),
(1113, 'Silvino Lobos', 53),
(1114, 'Victoria', 53),
(1115, 'Cabanatuan City', 54),
(1116, 'Gapan City', 54),
(1117, 'Science City of Muñoz', 54),
(1118, 'Palayan City', 54),
(1119, 'San Jose City', 54),
(1120, 'Aliaga', 54),
(1121, 'Bongabon', 54),
(1122, 'Cabiao', 54),
(1123, 'Carranglan', 54),
(1124, 'Cuyapo', 54),
(1125, 'Gabaldon', 54),
(1126, 'General Mamerto Natividad', 54),
(1127, 'General Tinio', 54),
(1128, 'Guimba', 54),
(1129, 'Jaen', 54),
(1130, 'Laur', 54),
(1131, 'Licab', 54),
(1132, 'Llanera', 54),
(1133, 'Lupao', 54),
(1134, 'Nampicuan', 54),
(1135, 'Pantabangan', 54),
(1136, 'Peñaranda', 54),
(1137, 'Quezon', 54),
(1138, 'Rizal', 54),
(1139, 'San Antonio', 54),
(1140, 'San Isidro', 54),
(1141, 'San Leonardo', 54),
(1142, 'Santa Rosa', 54),
(1143, 'Santo Domingo', 54),
(1144, 'Talavera', 54),
(1145, 'Talugtug', 54),
(1146, 'Zaragoza', 54),
(1147, 'Alfonso Castaneda', 55),
(1148, 'Ambaguio', 55),
(1149, 'Aritao', 55),
(1150, 'Bagabag', 55),
(1151, 'Bambang', 55),
(1152, 'Bayombong', 55),
(1153, 'Diadi', 55),
(1154, 'Dupax del Norte', 55),
(1155, 'Dupax del Sur', 55),
(1156, 'Kasibu', 55),
(1157, 'Kayapa', 55),
(1158, 'Quezon', 55),
(1159, 'Santa Fe', 55),
(1160, 'Solano', 55),
(1161, 'Villaverde', 55),
(1162, 'Abra de Ilog', 56),
(1163, 'Calintaan', 56),
(1164, 'Looc', 56),
(1165, 'Lubang', 56),
(1166, 'Magsaysay', 56),
(1167, 'Mamburao', 56),
(1168, 'Paluan', 56),
(1169, 'Rizal', 56),
(1170, 'Sablayan', 56),
(1171, 'San Jose', 56),
(1172, 'Santa Cruz', 56),
(1173, 'Calapan City', 57),
(1174, 'Baco', 57),
(1175, 'Bansud', 57),
(1176, 'Bongabong', 57),
(1177, 'Bulalacao', 57),
(1178, 'Gloria', 57),
(1179, 'Mansalay', 57),
(1180, 'Naujan', 57),
(1181, 'Pinamalayan', 57),
(1182, 'Pola', 57),
(1183, 'Puerto Galera', 57),
(1184, 'Roxas', 57),
(1185, 'San Teodoro', 57),
(1186, 'Socorro', 57),
(1187, 'Victoria', 57),
(1188, 'Puerto Princesa City', 58),
(1189, 'Aborlan', 58),
(1190, 'Agutaya', 58),
(1191, 'Araceli', 58),
(1192, 'Balabac', 58),
(1193, 'Bataraza', 58),
(1194, 'Brooke''s Point', 58),
(1195, 'Busuanga', 58),
(1196, 'Cagayancillo', 58),
(1197, 'Coron', 58),
(1198, 'Culion', 58),
(1199, 'Cuyo', 58),
(1200, 'Dumaran', 58),
(1201, 'El Nido', 58),
(1202, 'Kalayaan', 58),
(1203, 'Linapacan', 58),
(1204, 'Magsaysay', 58),
(1205, 'Narra', 58),
(1206, 'Quezon', 58),
(1207, 'Rizal', 58),
(1208, 'Roxas', 58),
(1209, 'San Vicente', 58),
(1210, 'Sofronio Española', 58),
(1211, 'Taytay', 58),
(1212, 'Angeles City', 59),
(1213, 'City of San Fernando', 59),
(1214, 'Apalit', 59),
(1215, 'Arayat', 59),
(1216, 'Bacolor', 59),
(1217, 'Candaba', 59),
(1218, 'Floridablanca', 59),
(1219, 'Guagua', 59),
(1220, 'Lubao', 59),
(1221, 'Mabalacat', 59),
(1222, 'Macabebe', 59),
(1223, 'Magalang', 59),
(1224, 'Masantol', 59),
(1225, 'Mexico', 59),
(1226, 'Minalin', 59),
(1227, 'Porac', 59),
(1228, 'San Luis', 59),
(1229, 'San Simon', 59),
(1230, 'Santa Ana', 59),
(1231, 'Santa Rita', 59),
(1232, 'Santo Tomas', 59),
(1233, 'Sasmuan', 59),
(1234, 'Alaminos City', 60),
(1235, 'Dagupan City', 60),
(1236, 'San Carlos City', 60),
(1237, 'Urdaneta City', 60),
(1238, 'Agno', 60),
(1239, 'Aguilar', 60),
(1240, 'Alcala', 60),
(1241, 'Anda', 60),
(1242, 'Asingan', 60),
(1243, 'Balungao', 60),
(1244, 'Bani', 60),
(1245, 'Basista', 60),
(1246, 'Bautista', 60),
(1247, 'Bayambang', 60),
(1248, 'Binalonan', 60),
(1249, 'Binmaley', 60),
(1250, 'Bolinao', 60),
(1251, 'Bugallon', 60),
(1252, 'Burgos', 60),
(1253, 'Calasiao', 60),
(1254, 'Dasol', 60),
(1255, 'Infanta', 60),
(1256, 'Labrador', 60),
(1257, 'Laoac', 60),
(1258, 'Lingayen', 60),
(1259, 'Mabini', 60),
(1260, 'Malasiqui', 60),
(1261, 'Manaoag', 60),
(1262, 'Mangaldan', 60),
(1263, 'Mangatarem', 60),
(1264, 'Mapandan', 60),
(1265, 'Natividad', 60),
(1266, 'Pozzorubio', 60),
(1267, 'Rosales', 60),
(1268, 'San Fabian', 60),
(1269, 'San Jacinto', 60),
(1270, 'San Manuel', 60),
(1271, 'San Nicolas', 60),
(1272, 'San Quintin', 60),
(1273, 'Santa Barbara', 60),
(1274, 'Santa Maria', 60),
(1275, 'Santo Tomas', 60),
(1276, 'Sison', 60),
(1277, 'Sual', 60),
(1278, 'Tayug', 60),
(1279, 'Umingan', 60),
(1280, 'Urbiztondo', 60),
(1281, 'Villasis', 60),
(1282, 'Lucena City', 61),
(1283, 'Tayabas City', 61),
(1284, 'Agdangan', 61),
(1285, 'Alabat', 61),
(1286, 'Atimonan', 61),
(1287, 'Buenavista', 61),
(1288, 'Burdeos', 61),
(1289, 'Calauag', 61),
(1290, 'Candelaria', 61),
(1291, 'Catanauan', 61),
(1292, 'Dolores', 61),
(1293, 'General Luna', 61),
(1294, 'General Nakar', 61),
(1295, 'Guinayangan', 61),
(1296, 'Gumaca', 61),
(1297, 'Infanta', 61),
(1298, 'Jomalig', 61),
(1299, 'Lopez', 61),
(1300, 'Lucban', 61),
(1301, 'Macalelon', 61),
(1302, 'Mauban', 61),
(1303, 'Mulanay', 61),
(1304, 'Padre Burgos', 61),
(1305, 'Pagbilao', 61),
(1306, 'Panukulan', 61),
(1307, 'Patnanungan', 61),
(1308, 'Perez', 61),
(1309, 'Pitogo', 61),
(1310, 'Plaridel', 61),
(1311, 'Polillo', 61),
(1312, 'Quezon', 61),
(1313, 'Real', 61),
(1314, 'Sampaloc', 61),
(1315, 'San Andres', 61),
(1316, 'San Antonio', 61),
(1317, 'San Francisco', 61),
(1318, 'San Narciso', 61),
(1319, 'Sariaya', 61),
(1320, 'Tagkawayan', 61),
(1321, 'Tiaong', 61),
(1322, 'Unisan', 61),
(1323, 'Aglipay', 62),
(1324, 'Cabarroguis', 62),
(1325, 'Diffun', 62),
(1326, 'Maddela', 62),
(1327, 'Nagtipunan', 62),
(1328, 'Saguday', 62),
(1329, 'Antipolo City', 63),
(1330, 'Angono', 63),
(1331, 'Baras', 63),
(1332, 'Binangonan', 63),
(1333, 'Cainta', 63),
(1334, 'Cardona', 63),
(1335, 'Jalajala', 63),
(1336, 'Morong', 63),
(1337, 'Pililla', 63),
(1338, 'Rodriguez', 63),
(1339, 'San Mateo', 63),
(1340, 'Tanay', 63),
(1341, 'Taytay', 63),
(1342, 'Teresa', 63),
(1343, 'Alcantara', 64),
(1344, 'Banton', 64),
(1345, 'Cajidiocan', 64),
(1346, 'Calatrava', 64),
(1347, 'Concepcion', 64),
(1348, 'Corcuera', 64),
(1349, 'Ferrol', 64),
(1350, 'Looc', 64),
(1351, 'Magdiwang', 64),
(1352, 'Odiongan', 64),
(1353, 'Romblon', 64),
(1354, 'San Agustin', 64),
(1355, 'San Andres', 64),
(1356, 'San Fernando', 64),
(1357, 'San Jose', 64),
(1358, 'Santa Fe', 64),
(1359, 'Santa Maria', 64),
(1360, 'Calbayog City', 65),
(1361, 'Catbalogan City', 65),
(1362, 'Almagro', 65),
(1363, 'Basey', 65),
(1364, 'Calbiga', 65),
(1365, 'Daram', 65),
(1366, 'Gandara', 65),
(1367, 'Hinabangan', 65),
(1368, 'Jiabong', 65),
(1369, 'Marabut', 65),
(1370, 'Matuguinao', 65),
(1371, 'Motiong', 65),
(1372, 'Pagsanghan', 65),
(1373, 'Paranas', 65),
(1374, 'Pinabacdao', 65),
(1375, 'San Jorge', 65),
(1376, 'San Jose De Buan', 65),
(1377, 'San Sebastian', 65),
(1378, 'Santa Margarita', 65),
(1379, 'Santa Rita', 65),
(1380, 'Santo Niño', 65),
(1381, 'Tagapul-an', 65),
(1382, 'Talalora', 65),
(1383, 'Tarangnan', 65),
(1384, 'Villareal', 65),
(1385, 'Zumarraga', 65),
(1386, 'Alabel', 66),
(1387, 'Glan', 66),
(1388, 'Kiamba', 66),
(1389, 'Maasim', 66),
(1390, 'Maitum', 66),
(1391, 'Malapatan', 66),
(1392, 'Malungon', 66),
(1393, 'Enrique Villanueva', 67),
(1394, 'Larena', 67),
(1395, 'Lazi', 67),
(1396, 'Maria', 67),
(1397, 'San Juan', 67),
(1398, 'Siquijor', 67),
(1399, 'Sorsogon City', 68),
(1400, 'Barcelona', 68),
(1401, 'Bulan', 68),
(1402, 'Bulusan', 68),
(1403, 'Casiguran', 68),
(1404, 'Castilla', 68),
(1405, 'Donsol', 68),
(1406, 'Gubat', 68),
(1407, 'Irosin', 68),
(1408, 'Juban', 68),
(1409, 'Magallanes', 68),
(1410, 'Matnog', 68),
(1411, 'Pilar', 68),
(1412, 'Prieto Diaz', 68),
(1413, 'Santa Magdalena', 68),
(1414, 'General Santos City', 69),
(1415, 'Koronadal City', 69),
(1416, 'Banga', 69),
(1417, 'Lake Sebu', 69),
(1418, 'Norala', 69),
(1419, 'Polomolok', 69),
(1420, 'Santo Niño', 69),
(1421, 'Surallah', 69),
(1422, 'T''boli', 69),
(1423, 'Tampakan', 69),
(1424, 'Tantangan', 69),
(1425, 'Tupi', 69),
(1426, 'Maasin City', 70),
(1427, 'Anahawan', 70),
(1428, 'Bontoc', 70),
(1429, 'Hinunangan', 70),
(1430, 'Hinundayan', 70),
(1431, 'Libagon', 70),
(1432, 'Liloan', 70),
(1433, 'Limasawa', 70),
(1434, 'Macrohon', 70),
(1435, 'Malitbog', 70),
(1436, 'Padre Burgos', 70),
(1437, 'Pintuyan', 70),
(1438, 'Saint Bernard', 70),
(1439, 'San Francisco', 70),
(1440, 'San Juan', 70),
(1441, 'San Ricardo', 70),
(1442, 'Silago', 70),
(1443, 'Sogod', 70),
(1444, 'Tomas Oppus', 70),
(1445, 'Tacurong City', 71),
(1446, 'Bagumbayan', 71),
(1447, 'Columbio', 71),
(1448, 'Esperanza', 71),
(1449, 'Isulan', 71),
(1450, 'Kalamansig', 71),
(1451, 'Lambayong', 71),
(1452, 'Lebak', 71),
(1453, 'Lutayan', 71),
(1454, 'Palimbang', 71),
(1455, 'President Quirino', 71),
(1456, 'Senator Ninoy Aquino', 71),
(1457, 'Banguingui', 72),
(1458, 'Hadji Panglima Tahil', 72),
(1459, 'Indanan', 72),
(1460, 'Jolo', 72),
(1461, 'Kalingalan Caluang', 72),
(1462, 'Lugus', 72),
(1463, 'Luuk', 72),
(1464, 'Maimbung', 72),
(1465, 'Old Panamao', 72),
(1466, 'Omar', 72),
(1467, 'Pandami', 72),
(1468, 'Panglima Estino', 72),
(1469, 'Pangutaran', 72),
(1470, 'Parang', 72),
(1471, 'Pata', 72),
(1472, 'Patikul', 72),
(1473, 'Siasi', 72),
(1474, 'Talipao', 72),
(1475, 'Tapul', 72),
(1476, 'Surigao City', 73),
(1477, 'Alegria', 73),
(1478, 'Bacuag', 73),
(1479, 'Basilisa', 73),
(1480, 'Burgos', 73),
(1481, 'Cagdianao', 73),
(1482, 'Claver', 73),
(1483, 'Dapa', 73),
(1484, 'Del Carmen', 73),
(1485, 'Dinagat', 73),
(1486, 'General Luna', 73),
(1487, 'Gigaquit', 73),
(1488, 'Libjo', 73),
(1489, 'Loreto', 73),
(1490, 'Mainit', 73),
(1491, 'Malimono', 73),
(1492, 'Pilar', 73),
(1493, 'Placer', 73),
(1494, 'San Benito', 73),
(1495, 'San Francisco', 73),
(1496, 'San Isidro', 73),
(1497, 'San Jose', 73),
(1498, 'Santa Monica', 73),
(1499, 'Sison', 73),
(1500, 'Socorro', 73),
(1501, 'Tagana-an', 73),
(1502, 'Tubajon', 73),
(1503, 'Tubod', 73),
(1504, 'Bislig City', 74),
(1505, 'Tandag City', 74),
(1506, 'Barobo', 74),
(1507, 'Bayabas', 74),
(1508, 'Cagwait', 74),
(1509, 'Cantilan', 74),
(1510, 'Carmen', 74),
(1511, 'Carrascal', 74),
(1512, 'Cortes', 74),
(1513, 'Hinatuan', 74),
(1514, 'Lanuza', 74),
(1515, 'Lianga', 74),
(1516, 'Lingig', 74),
(1517, 'Madrid', 74),
(1518, 'Marihatag', 74),
(1519, 'San Agustin', 74),
(1520, 'San Miguel', 74),
(1521, 'Tagbina', 74),
(1522, 'Tago', 74),
(1523, 'Tarlac City', 75),
(1524, 'Anao', 75),
(1525, 'Bamban', 75),
(1526, 'Camiling', 75),
(1527, 'Capas', 75),
(1528, 'Concepcion', 75),
(1529, 'Gerona', 75),
(1530, 'La Paz', 75),
(1531, 'Mayantoc', 75),
(1532, 'Moncada', 75),
(1533, 'Paniqui', 75),
(1534, 'Pura', 75),
(1535, 'Ramos', 75),
(1536, 'San Clemente', 75),
(1537, 'San Jose', 75),
(1538, 'San Manuel', 75),
(1539, 'Santa Ignacia', 75),
(1540, 'Victoria', 75),
(1541, 'Bongao', 76),
(1542, 'Languyan', 76),
(1543, 'Mapun', 76),
(1544, 'Panglima Sugala', 76),
(1545, 'Sapa-Sapa', 76),
(1546, 'Sibutu', 76),
(1547, 'Simunul', 76),
(1548, 'Sitangkai', 76),
(1549, 'South Ubian', 76),
(1550, 'Tandubas', 76),
(1551, 'Turtle Islands', 76),
(1552, 'Olongapo City', 77),
(1553, 'Botolan', 77),
(1554, 'Cabangan', 77),
(1555, 'Candelaria', 77),
(1556, 'Castillejos', 77),
(1557, 'Iba', 77),
(1558, 'Masinloc', 77),
(1559, 'Palauig', 77),
(1560, 'San Antonio', 77),
(1561, 'San Felipe', 77),
(1562, 'San Marcelino', 77),
(1563, 'San Narciso', 77),
(1564, 'Santa Cruz', 77),
(1565, 'Subic', 77),
(1566, 'Dapitan City', 78),
(1567, 'Dipolog City', 78),
(1568, 'Bacungan', 78),
(1569, 'Baliguian', 78),
(1570, 'Godod', 78),
(1571, 'Gutalac', 78),
(1572, 'Jose Dalman', 78),
(1573, 'Kalawit', 78),
(1574, 'Katipunan', 78),
(1575, 'La Libertad', 78),
(1576, 'Labason', 78),
(1577, 'Liloy', 78),
(1578, 'Manukan', 78),
(1579, 'Mutia', 78),
(1580, 'Piñan', 78),
(1581, 'Polanco', 78),
(1582, 'President Manuel A. Roxas', 78),
(1583, 'Rizal', 78),
(1584, 'Salug', 78),
(1585, 'Sergio Osmeña Sr.', 78),
(1586, 'Siayan', 78),
(1587, 'Sibuco', 78),
(1588, 'Sibutad', 78),
(1589, 'Sindangan', 78),
(1590, 'Siocon', 78),
(1591, 'Sirawai', 78),
(1592, 'Tampilisan', 78),
(1593, 'Pagadian City', 79),
(1594, 'Zamboanga City', 79),
(1595, 'Aurora', 79),
(1596, 'Bayog', 79),
(1597, 'Dimataling', 79),
(1598, 'Dinas', 79),
(1599, 'Dumalinao', 79),
(1600, 'Dumingag', 79),
(1601, 'Guipos', 79),
(1602, 'Josefina', 79),
(1603, 'Kumalarang', 79),
(1604, 'Labangan', 79),
(1605, 'Lakewood', 79),
(1606, 'Lapuyan', 79),
(1607, 'Mahayag', 79),
(1608, 'Margosatubig', 79),
(1609, 'Midsalip', 79),
(1610, 'Molave', 79),
(1611, 'Pitogo', 79),
(1612, 'Ramon Magsaysay', 79),
(1613, 'San Miguel', 79),
(1614, 'San Pablo', 79),
(1615, 'Sominot', 79),
(1616, 'Tabina', 79),
(1617, 'Tambulig', 79),
(1618, 'Tigbao', 79),
(1619, 'Tukuran', 79),
(1620, 'Vincenzo A. Sagun', 79),
(1621, 'Alicia', 80),
(1622, 'Buug', 80),
(1623, 'Diplahan', 80),
(1624, 'Imelda', 80),
(1625, 'Ipil', 80),
(1626, 'Kabasalan', 80),
(1627, 'Mabuhay', 80),
(1628, 'Malangas', 80),
(1629, 'Naga', 80),
(1630, 'Olutanga', 80),
(1631, 'Payao', 80),
(1632, 'Roseller Lim', 80),
(1633, 'Siay', 80),
(1634, 'Talusan', 80),
(1635, 'Titay', 80),
(1636, 'Tungawan', 80);

-- --------------------------------------------------------

--
-- Table structure for table `esk_cue_count`
--

CREATE TABLE `esk_cue_count` (
  `cue_id` int(11) NOT NULL AUTO_INCREMENT,
  `cue_number` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `next_id` int(11) NOT NULL,
  `cue_status` int(11) NOT NULL COMMENT '0=serving, 1=done',
  `station_id` int(11) NOT NULL,
  PRIMARY KEY (`cue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_cue_dept`
--

CREATE TABLE `esk_cue_dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cue_process` varchar(55) NOT NULL,
  `cue_dept_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_cue_station`
--

CREATE TABLE `esk_cue_station` (
  `station_id` int(11) NOT NULL AUTO_INCREMENT,
  `station_name` varchar(55) NOT NULL,
  `online` int(11) NOT NULL COMMENT '1 = online; 0 =offline',
  `dept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `esk_cue_station`
--

INSERT INTO `esk_cue_station` (`station_id`, `station_name`, `online`, `dept_id`, `user_id`) VALUES
(1, 'Cashier 1', 0, 7, 0),
(2, 'Cashier 2', 1, 7, 587);

CREATE TABLE `esk_c_courses` (
  `course_id` int(11) NOT NULL,
  `course` varchar(255) CHARACTER SET latin1 NOT NULL,
  `short_code` tinytext CHARACTER SET latin1 NOT NULL,
  `dept_id` int(11) NOT NULL,,
  `no_years` int(11) NOT NULL
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `esk_c_departments`
--

CREATE TABLE `esk_c_departments` (
  `cc_id` int(11) NOT NULL AUTO_INCREMENT,
  `college_department` varchar(300) NOT NULL,
  `cc_short_code` varchar(35) NOT NULL,
  PRIMARY KEY (`cc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `esk_c_faculty_assignment`
--

CREATE TABLE `esk_c_faculty_assignment` (
  `fac_id` int(11) NOT NULL,
  `spc_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL COMMENT 'for Dean / Chairperson',
  PRIMARY KEY (`fac_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- AUTO_INCREMENT for table `esk_c_faculty_assignment`
--
ALTER TABLE `esk_c_faculty_assignment`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_schedule`
--

CREATE TABLE `esk_c_schedule` (
  `sched_id` int(11) NOT NULL AUTO_INCREMENT,
  `sched_time_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `cs_spc_id` varchar(100) NOT NULL,
  `section_id` int(11) NOT NULL,
  `school_year` year(4) NOT NULL,
  PRIMARY KEY (`sched_id`),
  KEY `sched_time_id` (`sched_time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_section`
--

CREATE TABLE `esk_c_section` (
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(35) NOT NULL,
  `course_id` int(11) NOT NULL,
  `sec_sem` int(11) NOT NULL,
  `sec_school_year` year(4) NOT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_subjects`
--

CREATE TABLE `esk_c_subjects` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_desc_title` varchar(255) NOT NULL,
  `sub_code` varchar(55) NOT NULL,
  `s_lect_unit` float NOT NULL,
  `s_lab_unit` float NOT NULL,
  `pre_req` int(11) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_subjects_per_course`
--

CREATE TABLE `esk_c_subjects_per_course` (
  `spc_id` int(11) NOT NULL AUTO_INCREMENT,
  `spc_sub_id` int(11) NOT NULL,
  `spc_course_id` int(11) NOT NULL,
  `spc_sem_id` int(11) NOT NULL COMMENT '1=first;2=second;3=summer',
  `year_level` int(11) NOT NULL,
  `school_year` year(4) NOT NULL,
  PRIMARY KEY (`spc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `esk_c_subjects_per_course`
--

INSERT INTO `esk_c_subjects_per_course` (`spc_id`, `spc_sub_id`, `spc_course_id`, `spc_sem_id`, `year_level`, `school_year`) VALUES
(1, 1, 10, 1, 1, 2016),
(2, 2, 10, 1, 1, 2016),
(3, 7, 10, 1, 2, 2016),
(4, 3, 10, 1, 1, 2016),
(5, 8, 10, 1, 1, 2016),
(6, 5, 10, 1, 1, 2016),
(7, 9, 10, 1, 1, 2016),
(8, 10, 10, 1, 1, 2016),
(9, 11, 10, 1, 1, 2016),
(10, 12, 10, 1, 1, 2016),
(11, 13, 10, 1, 1, 2016);

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_time`
--

CREATE TABLE `esk_c_time` (
  `ctime_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_from` int(11) NOT NULL,
  `time_to` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  PRIMARY KEY (`ctime_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_c_menu` (
  `cmenu_id` int(11) NOT NULL,
  `cmenu_name` varchar(55) NOT NULL,
  `cmenu_link` varchar(255) NOT NULL,
  `cmenu_type` varchar(55) NOT NULL,
  `cmenu_parent` int(11) NOT NULL,
  `cmenu_icon` varchar(55) NOT NULL,
  `cmenu_note` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is used for college menu';

--
-- Dumping data for table `esk_c_menu`
--

INSERT INTO `esk_c_menu` (`cmenu_id`, `cmenu_name`, `cmenu_link`, `cmenu_type`, `cmenu_parent`, `cmenu_icon`, `cmenu_note`) VALUES
(1, 'Admission', 'college/admission', 'main', 0, 'fa-user-plus', 'Registration for a college student'),
(2, 'Student Roster', 'college/getStudents', 'main', 0, 'fa-users', 'List of College Students');

-- --------------------------------------------------------

--
-- Table structure for table `esk_c_menu_access`
--

CREATE TABLE `esk_c_menu_access` (
  `cma_id` int(11) NOT NULL,
  `cma_user_id` int(11) NOT NULL,
  `cma_personal_access` varchar(255) NOT NULL,
  `cma_department_access` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_c_menu`
--
ALTER TABLE `esk_c_menu`
  ADD PRIMARY KEY (`cmenu_id`);

--
-- Indexes for table `esk_c_menu_access`
--
ALTER TABLE `esk_c_menu_access`
  ADD PRIMARY KEY (`cma_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_c_menu`
--
ALTER TABLE `esk_c_menu`
  MODIFY `cmenu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `esk_c_menu_access`
--
ALTER TABLE `esk_c_menu_access`
  MODIFY `cma_id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `esk_daily_remarks` (
  `remark_id` int(11) NOT NULL AUTO_INCREMENT,
  `remark` mediumtext,
  `remark_from_id` varchar(55) DEFAULT NULL,
  `remark_to_id` varchar(55) DEFAULT NULL,
  `remark_date` varchar(55) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `category` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`remark_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_department`
--

CREATE TABLE `esk_department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(55) DEFAULT NULL,
  `customized_dept_id` int(11) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `esk_department`
--

INSERT INTO `esk_department` (`dept_id`, `department`, `customized_dept_id`) VALUES
(1, 'Administrators', 0),
(2, 'Admin', 0),
(6, 'Academic', 0),
(7, 'Finance', 0),
(8, 'Human Resource', 0),
(9, 'Admission', 0);

-- --------------------------------------------------------

--
-- Table structure for table `esk_department_heads`
--

CREATE TABLE `esk_department_heads` (
  `dh_id` int(11) NOT NULL AUTO_INCREMENT,
  `dh_head` int(11) NOT NULL,
  `dh_assoc` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`dh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='this table is used for texting department heads' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_deped_code_indicator`
--

CREATE TABLE `esk_deped_code_indicator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `Indicator` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='this is used in (sf 1) deped forms remarks column' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `esk_deped_code_indicator`
--

INSERT INTO `esk_deped_code_indicator` (`id`, `code`, `Indicator`) VALUES
(1, 'T/O', 'Transferred Out'),
(2, 'T/I', 'Transferred In'),
(3, 'DRP', 'Dropped'),
(4, 'LE', 'Late Enrollment');

-- --------------------------------------------------------

--
-- Table structure for table `esk_dll`
--

CREATE TABLE `esk_dll` (
  `dll_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` varchar(55) NOT NULL,
  `dll_sub_id` int(11) NOT NULL,
  `dll_grade_id` int(11) NOT NULL,
  `dll_section_id` int(11) NOT NULL,
  `dll_date` date NOT NULL,
  `dll_submitted` date NOT NULL,
  `checked` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `dll_assess_id` int(11) NOT NULL,
  PRIMARY KEY (`dll_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Main daily lesson log ' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_activities`
--

CREATE TABLE `esk_dll_activities` (
  `act_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) NOT NULL,
  `act_dll_id` int(11) NOT NULL,
  PRIMARY KEY (`act_id`),
  KEY `act_dll_id` (`act_dll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_comments`
--

CREATE TABLE `esk_dll_comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `comments` varchar(1000) NOT NULL,
  `com_dll_id` int(11) NOT NULL,
  PRIMARY KEY (`com_id`),
  KEY `com_dll_id` (`com_dll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_lessons`
--

CREATE TABLE `esk_dll_lessons` (
  `less_id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson` varchar(500) NOT NULL,
  `less_dll_id` int(11) NOT NULL,
  PRIMARY KEY (`less_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_materials_used`
--

CREATE TABLE `esk_dll_materials_used` (
  `mat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mat_type_id` int(11) NOT NULL,
  `page_num` varchar(255) NOT NULL,
  `mat_dll_id` int(11) NOT NULL,
  PRIMARY KEY (`mat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_references`
--

CREATE TABLE `esk_dll_references` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_type_id` int(11) NOT NULL,
  `page_num` varchar(55) NOT NULL,
  `ref_dll_id` int(11) NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_refmat_type`
--

CREATE TABLE `esk_dll_refmat_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_mat` varchar(55) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='DLL reference and materials' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_dll_refmat_type`
--

INSERT INTO `esk_dll_refmat_type` (`type_id`, `ref_mat`) VALUES
(1, 'Teacher’s guide'),
(2, 'Teacher’s Manual'),
(3, 'Textbook'),
(4, 'Module'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `esk_dll_remarks`
--

CREATE TABLE `esk_dll_remarks` (
  `rem_id` int(11) NOT NULL AUTO_INCREMENT,
  `mastery_level` float NOT NULL,
  `beginning_level` float NOT NULL,
  `rem_dll_id` int(11) NOT NULL,
  PRIMARY KEY (`rem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_ethnic_group`
--

CREATE TABLE `esk_ethnic_group` (
  `eg_id` int(11) NOT NULL AUTO_INCREMENT,
  `ethnic_group` varchar(255) NOT NULL,
  PRIMARY KEY (`eg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



-- --------------------------------------------------------

--
-- Table structure for table `esk_faculty_assign`
--

CREATE TABLE `esk_faculty_assign` (
  `ass_id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_id` varchar(55) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  `specs_id` int(11) NOT NULL COMMENT 'for TLE Subjects',
  PRIMARY KEY (`ass_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Constraints for table `esk_dll_comments`
--
ALTER TABLE `esk_dll_comments`
  ADD CONSTRAINT `esk_dll_comments_ibfk_1` FOREIGN KEY (`com_dll_id`) REFERENCES `esk_dll` (`dll_id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `esk_holidays` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_level_department`
--

CREATE TABLE `esk_level_department` (
  `level_dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_department` varchar(55) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`level_dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_level_department`
--

INSERT INTO `esk_level_department` (`level_dept_id`, `level_department`) VALUES
(1, 'Pre - School'),
(2, 'Elementary'),
(3, 'Junior High'),
(4, 'Senior High'),
(5, 'College');



CREATE TABLE `esk_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `menu_type` varchar(55) DEFAULT NULL,
  `menu_parent` int(55) NOT NULL,
  `menu_li_class` varchar(55) DEFAULT NULL,
  `menu_a_class` varchar(55) DEFAULT NULL,
  `menu_note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_menu`
--

INSERT INTO `esk_menu` (`menu_id`, `menu_name`, `menu_link`, `menu_type`, `menu_parent`, `menu_li_class`, `menu_a_class`, `menu_note`) VALUES
(1, 'Dashboard', 'main/dashboard', 'menu', 0, '', 'fa-dashboard', ''),
(2, 'Students', '#', 'menu', 0, 'dropdown', 'fa-university', ''),
(3, 'Employees', '#', 'menu', 0, 'dropdown', 'fa-male', ''),
(4, 'Attendance', '#', 'menu', 0, 'dropdown', 'fa-calendar', ''),
(5, 'Settings', '#', 'modal', 0, 'dropdown', 'fa-cogs', ''),
(6, 'Admission', 'registrar/admission', 'submenu', 2, '', 'fa-plus', ''),
(7, 'Add Employee', 'hr/addEmployee', 'submenu', 3, '', 'fa-plus', ''),
(9, 'DepEd Reports', 'reports', 'submenu', 2, '', 'fa-file-text', ''),
(11, 'Student Roster', 'registrar/getAllStudents', 'submenu', 2, '', 'fa-users', ''),
(12, 'Employee Masterlist', 'hr/getAllEmployee', 'submenu', 3, '', 'fa-users', ''),
(13, 'Employee\'s DTR', 'employee/teachersList', 'submenu', 3, '', '', ''),
(14, 'DTR Summary', '#', 'submenu', 3, '', '', ''),
(15, 'Where You Belong', 'hr/whereYouBelong', 'submenu', 3, '', 'fa-sitemap', ''),
(16, 'Attendance Report', 'attendance/dailyPerSubject', 'submenu', 4, '', 'fa-check-square-o', ''),
(17, 'Access Control', 'main/accessControl', 'menu', 0, '', 'fa-key', ''),
(18, 'Human Resource', 'hr/settings', 'submenu', 5, '', 'fa-group', ''),
(19, 'Payroll Report', 'hr/payroll', 'submenu', 3, '', '', ''),
(20, 'School Settings', 'main/schoolsettings', 'submenu', 5, '', '', ''),
(21, 'Subject Settings', 'main/subjectSettings', 'submenu', 5, '', '', ''),
(22, 'Reports', 'reports/', 'submenu', 2, '', 'fa-book', ''),
(23, 'My Students', 'registrar/getAllStudents', 'menu', 0, NULL, 'fa-male', NULL),
(24, 'Grading System', 'gradingsystem', 'menu', 0, '', 'fa-calculator', NULL),
(25, 'My Accounts', 'financemanagement', 'menu', 0, NULL, 'fa-calculator', NULL),
(26, 'Borrowed Books', 'librarymanagement', 'menu', 0, NULL, 'fa-book', NULL),
(27, 'Subject Assign', 'academic/facultyAssignment', 'submenu', 3, NULL, 'fa-book', NULL),
(28, 'My Subjects', 'academic/mySubjects', 'menu', 0, NULL, 'fa-book', NULL),
(29, 'Finance', 'finance', 'menu', 0, '', 'fa-money', NULL),
(30, 'Settings', 'financemanagement/config', 'submenu', 29, NULL, 'fa-gear', 'finance management settings'),
(31, 'Reports', 'financemanagement/reports', 'submenu', 29, NULL, 'fa-line-chart', 'finance management report'),
(32, 'Collection Notice', 'financemanagement/collect', 'submenu', 29, NULL, 'fa-shekel', 'finance management collection notice'),
(33, 'Top Performer', 'gradingsystem/topPerformer', 'submenu', 2, 'dropdown', 'fa-books', 'top students in every subject'),
(34, 'News Management', 'messaging/announcement', 'menu', 0, NULL, 'fa-newspaper-o', NULL),
(35, 'Accounts', 'financemanagement/actz', 'submenu', 29, NULL, 'fa-users', 'finance accounts dashboard'),
(36, 'Dashboard', 'financemanagement/pos', 'submenu', 29, NULL, 'fa-shopping-cart', 'finance sales dashboard'),
(37, 'Co Curricular', 'gradingsystem/co_curricular/main/', 'submenu', 2, NULL, '', ''),
(38, 'New DLL', 'daily_lesson_log/create', 'submenu', 0, '', 'fa-info', 'create dll'),
(39, 'DLL\'s', 'daily_lesson_log', 'submenu', 0, '', 'fa-files-o', 'create dll'),
(50, 'Department Management', 'coursemanagement', 'submenu', 5, NULL, 'fa-university', ''),
(51, 'College Students', 'college/getCollegeStudents', 'submenu', 2, NULL, 'fa-university', ''),
(52, 'Library Module', 'librarymodule', 'menu', 0, NULL, 'fa-book', NULL),
(53, 'Birthdays', 'registrar/birthdays', 'submenu', 2, '', 'fa-plus', ''),
(54, 'Finance Accounts', 'finance/accounts', 'menu', 0, '', 'fa-money', NULL),
(55, 'List of Late Students', 'attendance/attendance_reports/dailyTardy', 'submenu', 2, '', 'fa-check-square-o', NULL),
(56, 'GS Monitoring', 'gradingsystem/gradingsystem_reports/viewAssessmentPerSection/', 'menu', 0, '', 'fa-calculator', NULL),
(57, 'View Grading Sheet', 'gradingsystem/gsView', 'menu', 0, NULL, 'fa-file-o', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_menu`
--
ALTER TABLE `esk_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_menu`
--
ALTER TABLE `esk_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

-- --------------------------------------------------------

--
-- Table structure for table `esk_mother_tongue`
--

CREATE TABLE `esk_mother_tongue` (
  `mt_id` int(11) NOT NULL AUTO_INCREMENT,
  `mother_tongue` varchar(255) NOT NULL,
  PRIMARY KEY (`mt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `esk_mother_tongue`
--

INSERT INTO `esk_mother_tongue` (`mt_id`, `mother_tongue`) VALUES
(1, 'Cebuano'),
(2, 'Bisaya'),
(3, 'Tagalog'),
(4, 'Higa-onon'),
(5, 'Maranao'),
(6, 'english'),
(7, 'Visayan'),
(8, 'Visayan'),
(9, 'CEBUANO'),
(10, 'Ilonggo'),
(11, 'ilonggo'),
(12, 'Japanese'),
(13, '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_notify`
--

CREATE TABLE `esk_notify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noti_type` int(11) NOT NULL,
  `noti_urgency` varchar(255) NOT NULL,
  `noti_from` varchar(55) NOT NULL,
  `noti_to` varchar(55) NOT NULL,
  `noti_msg` varchar(500) NOT NULL,
  `noti_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noti_read` varchar(300) NOT NULL,
  `noti_link` varchar(255) DEFAULT NULL,
  `noti_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `esk_notify_type`
--

CREATE TABLE `esk_notify_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(55) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `esk_notify_type`
--

INSERT INTO `esk_notify_type` (`type_id`, `type`) VALUES
(1, 'single'),
(2, 'department'),
(3, 'system'),
(4, 'attendance');

-- --------------------------------------------------------

--
-- Table structure for table `esk_pass_slip`
--

CREATE TABLE `esk_pass_slip` (
  `pass_slip_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_issue` varchar(100) DEFAULT NULL,
  `employee_id` varchar(100) DEFAULT NULL,
  `reason` varchar(300) DEFAULT NULL,
  `place` varchar(300) DEFAULT NULL,
  `authorized_by_hr` varchar(100) DEFAULT NULL,
  `time_in` varchar(100) DEFAULT NULL,
  `time_out` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pass_slip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `esk_provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

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
  `rel_id` int(11) NOT NULL AUTO_INCREMENT,
  `religion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `esk_religion`
--

INSERT INTO `esk_religion` (`rel_id`, `religion`) VALUES
(1, 'Roman Catholic'),
(2, 'SDA'),
(3, 'Protestant'),
(4, 'Born Again'),
(5, 'CAMACOP'),
(6, 'Foursquare'),
(7, 'LDS (Mormons)'),
(8, 'One Way Outreach, Inc'),
(9, 'Alliance'),
(10, 'UCCP'),
(11, 'Baptist'),
(12, 'United Pentecostal Church'),
(13, 'sda'),
(15, 'I.N.C.'),
(16, 'Assembly of God'),
(17, 'Seventh Day Adevtist'),
(18, 'aglipay'),
(19, 'Catholic'),
(20, 'Buddhist'),
(21, 'Methodist'),
(22, 'Evangelical Christian'),
(23, 'Aglipay'),
(24, 'SDA Reformed Church'),
(25, 'SDA (Reformed Church)');

-- --------------------------------------------------------

--
-- Table structure for table `esk_remarks_category`
--

CREATE TABLE `esk_remarks_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `esk_remarks_category`
--

INSERT INTO `esk_remarks_category` (`cat_id`, `category_name`) VALUES
(1, 'Late'),
(2, 'Cutting Classes');

-- --------------------------------------------------------

--
-- Table structure for table `esk_schedule`
--

CREATE TABLE `esk_schedule` (
  `sched_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) DEFAULT NULL,
  `sched_time_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  PRIMARY KEY (`sched_id`),
  KEY `sched_time_id` (`sched_time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_sched_rooms`
--

CREATE TABLE `esk_sched_rooms` (
  `rm_id` int(11) NOT NULL AUTO_INCREMENT,
  `room` varchar(55) NOT NULL,
  `rm_desc` varchar(300) NOT NULL,
  PRIMARY KEY (`rm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_sched_time`
--

CREATE TABLE `esk_sched_time` (
  `time_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_fr` time NOT NULL,
  `time_to` time NOT NULL,
  PRIMARY KEY (`time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_section`
--

CREATE TABLE `esk_section` (
  `section_id` int(11) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `grade_level_id` int(11) DEFAULT NULL,
  `schedule_id` varchar(55) NOT NULL,
  `str_id` int(11) NOT NULL COMMENT 'this applies if senior high',
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `time_in_pm` time NOT NULL,
  `time_out_pm` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_section`
--
ALTER TABLE `esk_section`
  ADD PRIMARY KEY (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_section`
--
ALTER TABLE `esk_section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Table structure for table `esk_session`
--

CREATE TABLE `esk_session` (
  `id` varchar(40) NOT NULL,
  `session_id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  `data` blob NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for table `esk_schedule`
--
ALTER TABLE `esk_schedule`
  ADD CONSTRAINT `esk_schedule_ibfk_1` FOREIGN KEY (`sched_time_id`) REFERENCES `esk_sched_time` (`time_id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `esk_settings` (
  `set_logo` varchar(255) DEFAULT NULL,
  `school_id` varchar(55) NOT NULL,
  `set_school_name` varchar(255) DEFAULT NULL,
  `set_school_address` varchar(255) DEFAULT NULL,
  `region` varchar(55) NOT NULL,
  `district` varchar(55) NOT NULL,
  `division` varchar(55) NOT NULL,
  `division_address` varchar(300) NOT NULL,
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
  `level_catered` int(11) NOT NULL COMMENT '0=All level; 1=elementary; 2=high school',
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE `esk_settings_quarter` (
  `quarter_id` int(11) NOT NULL AUTO_INCREMENT,
  `quarter` varchar(100) DEFAULT NULL,
  `from_date` varchar(100) NOT NULL,
  `to_date` varchar(100) NOT NULL,
  `number_of_holidays` int(11) NOT NULL,
  `school_year` int(11) NOT NULL,
  PRIMARY KEY (`quarter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `esk_settings_quarter`
--

INSERT INTO `esk_settings_quarter` (`quarter_id`, `quarter`, `from_date`, `to_date`, `number_of_holidays`, `school_year`) VALUES
(1, '1st Quarter', '05-01-2016', '09-18-2016', 10, 2014),
(2, '2nd Quarter', '09-19-2016', '11-30-2016', 10, 2014),
(3, '3rd Quarter', '12-01-2016', '01-31-2017', 10, 2014),
(4, '4th Quarter', '02-01-2017', '04-30-2017', 10, 2014);

-- --------------------------------------------------------

--
-- Table structure for table `esk_subjects`
--

CREATE TABLE `esk_subjects` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `short_code` varchar(55) NOT NULL,
  `parent_subject` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `esk_subjects`
--

INSERT INTO `esk_subjects` (`subject_id`, `subject`, `short_code`, `parent_subject`, `order`) VALUES
(1, 'English', 'English', 0, 0),
(2, 'Filipino', 'Filipino', 0, 0),
(3, 'Mathematics', 'Math', 0, 0),
(4, 'Science', 'Science', 0, 0),
(5, 'Computer', 'Computer', 0, 0),
(6, 'Values Education', 'Val. Ed', 0, 0),
(8, 'Makabayan', 'Mkbyn', 0, 0),
(9, 'Araling Panlipunan', 'AP', 0, 0),
(10, 'Technology and Livelihood Education', 'TLE', 0, 0),
(12, 'Esp / EP', 'Esp/EP', 0, 0),
(13, 'Music', 'Music', 11, 0),
(14, 'Arts', 'Arts', 11, 0),
(15, 'Physical Education', 'PE', 11, 0),
(16, 'Health', 'Health', 11, 0),
(17, 'BGB-cat', 'BGB\n', 0, 0),
(18, 'MAPEH', 'MAPEH', 0, 0),
(19, 'Mother Tongue', 'Mother Tongue', 0, 0),
(20, 'BGB', 'BGB', 0, 0),
(21, 'HELE', 'hele', 0, 0),
(22, 'Social Studies', 'Social Studies', 0, 0),
(23, 'Civics', 'Civics', 0, 0),
(24, 'Bible', '', 0, 0),
(25, 'Oral Communication', '', 0, 0),
(26, 'Pathfindering', '', 0, 0),
(27, 'Home Room', '', 0, 0),
(28, 'Work Education', '', 0, 0),
(29, 'Conduct', '', 0, 0),
(30, '', '', 0, 0),
(31, 'Reading', '', 0, 0),
(32, 'Media and Information Leteracy', '', 0, 0),
(33, 'Creative Writing', '', 0, 0),
(34, 'Komunikasyon at Pananaliksik sa wika at kulturang Pilipino', '', 0, 0),
(35, 'General Mathematics', '', 0, 0),
(36, 'Pre-Calculus', '', 0, 0),
(37, 'Earth Science', '', 0, 0),
(38, 'Philosopy of Wok 1', '', 0, 0),
(39, 'Entrepreneurship', '', 0, 0),
(40, 'Organization and Management', '', 0, 0),
(41, 'English for Academic and Professional Purposes', '', 0, 0),
(42, 'PE ', '', 0, 0),
(43, 'Physical Education and Health 1', '', 0, 0),
(44, 'Earth and Life Sciences', '', 0, 0),
(45, 'Teachings of Jesus', '', 0, 0),
(46, 'CAT', '', 0, 0),
(47, 'Research', '', 0, 0),
(48, 'Phylosophy of Works', '', 0, 0);


-- --------------------------------------------------------

--
-- Table structure for table `esk_sh_subjects`
--


CREATE TABLE `esk_sh_subjects` (
  `id` int(11) NOT NULL,
  `sh_sub_id` int(11) NOT NULL,
  `strand_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `school_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_sh_subjects`
--
ALTER TABLE `esk_sh_subjects`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

--
-- Table structure for table `esk_sh_strand`
--

CREATE TABLE `esk_sh_strand` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `strand` varchar(255) NOT NULL,
  `short_code` varchar(55) NOT NULL,
  `track_id` int(11) NOT NULL,
  `offered` int(11) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `esk_sh_strand`
--

INSERT INTO `esk_sh_strand` (`st_id`, `strand`, `short_code`, `track_id`, `offered`) VALUES
(1, 'Accountancy, Business and Management', 'ABM', 1, 0),
(2, 'Humanities and Social Sciences', 'HUMSS', 1, 0),
(3, 'Science, Technology, Engineering and Mathematics', 'STEM', 1, 0),
(4, 'General Academic Strand', 'GAS', 1, 0),
(5, 'Home Economics', 'HE', 2, 0),
(6, 'Information and Communications Technology', 'ICT', 2, 0),
(7, 'Industrial Arts', 'IA', 2, 0),
(8, 'Agri-Fishery', 'AF', 2, 0),
(9, 'Sports', 'Sports', 3, 0),
(10, 'Arts and Design', 'A&D', 4, 0);


-- --------------------------------------------------------

--
-- Table structure for table `esk_subjects_settings`
--

CREATE TABLE `esk_subjects_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_id` smallint(6) NOT NULL,
  `grade_level_id` tinyint(4) NOT NULL,
  `school_year` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `esk_subjects_settings`
--

INSERT INTO `esk_subjects_settings` (`id`, `sub_id`, `grade_level_id`, `school_year`) VALUES
(1, 1, 8, 2016),
(2, 2, 8, 2016),
(3, 3, 8, 2016),
(4, 9, 8, 2016),
(5, 6, 8, 2016),
(6, 10, 8, 2016),
(7, 13, 8, 2016),
(8, 14, 8, 2016),
(9, 15, 8, 2016),
(10, 16, 8, 2016),
(22, 4, 8, 2016),
(23, 26, 8, 2016),
(24, 27, 8, 2016),
(25, 28, 8, 2016),
(26, 29, 8, 2016),
(30, 1, 2, 2016),
(31, 3, 2, 2016),
(32, 9, 2, 2016),
(33, 12, 2, 2016),
(34, 2, 2, 2016),
(35, 5, 2, 2016),
(36, 19, 2, 2016),
(37, 31, 2, 2016),
(38, 13, 2, 2016),
(39, 14, 2, 2016),
(40, 15, 2, 2016),
(41, 16, 2, 2016),
(51, 24, 14, 2016),
(52, 24, 1, 2016),
(53, 2, 1, 2016),
(54, 3, 14, 2016),
(55, 3, 1, 2016),
(56, 31, 14, 2016),
(57, 31, 1, 2016),
(59, 25, 12, 0000),
(60, 33, 12, 0000),
(61, 34, 12, 0000),
(62, 35, 12, 0000),
(63, 36, 12, 0000),
(64, 37, 12, 0000),
(66, 39, 12, 0000),
(67, 40, 12, 0000),
(68, 41, 12, 0000),
(70, 43, 12, 0000),
(71, 44, 12, 0000),
(72, 45, 12, 0000),
(73, 46, 8, 0000),
(75, 48, 12, 0000),
(76, 24, 8, 0000),
(77, 24, 2, 0000),
(78, 18, 8, 0000),
(79, 5, 8, 0000);

-- --------------------------------------------------------

--
-- Table structure for table `esk_subject_settings`
--

CREATE TABLE `esk_subject_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level_id` varchar(55) NOT NULL,
  `subject_id` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_system_logs`
--

CREATE TABLE `esk_system_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `account_id` varchar(50) NOT NULL,
  `log_title` varchar(100) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `section` varchar(55) NOT NULL,
  `counts` int(11) NOT NULL,
  `log_date` date NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_ticker`
--

CREATE TABLE `esk_ticker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticker_title` varchar(55) NOT NULL,
  `ticker_msg` varchar(300) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `esk_ticker`
--

INSERT INTO `esk_ticker` (`id`, `ticker_title`, `ticker_msg`, `active`, `timestamp`) VALUES
(7, 'WELCOME TO', 'e-sKwela School Management and Information System', 1, '2015-10-24 16:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `esk_updated_tables`
--

CREATE TABLE `esk_updated_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(55) NOT NULL,
  `primary_key` varchar(55) NOT NULL,
  `primary_key_value` varchar(300) NOT NULL,
  `action` varchar(55) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'type of updates(e.g. gradingsystem)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `esk_update_types`
--

CREATE TABLE `esk_update_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_type` varchar(55) NOT NULL,
  `num_of_updates` int(11) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Types of Updates' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `esk_update_types`
--

INSERT INTO `esk_update_types` (`type_id`, `update_type`, `num_of_updates`) VALUES
(1, 'General Information', 0),
(2, 'Enrollment Information', 4611),
(3, 'Attendance Information', 67784),
(4, 'Academic Information', 2793),
(5, 'Personal Information', 34);

-- --------------------------------------------------------

--
-- Table structure for table `esk_user_accounts`
--

CREATE TABLE `esk_user_accounts` (
  `u_id` varchar(55) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `pword` varchar(255) DEFAULT NULL,
  `utype` int(11) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `if_p` int(11) NOT NULL,
  `islogin` int(11) NOT NULL,
  `child_links` varchar(255) NOT NULL,
  `isActive` int(11) NOT NULL COMMENT 'To check if account is already activated',
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`uname`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_user_accounts`
--

INSERT INTO `esk_user_accounts` (`u_id`, `uname`, `pword`, `utype`, `secret_key`, `if_p`, `islogin`, `child_links`, `isActive`, `parent_id`) VALUES
('0310062', '0310062', '3d0a0a46a1bada5d90794993259da906', 1, NULL, 0, 1, '', 1, 0);


-- --------------------------------------------------------

--
-- Table structure for table `esk_user_groups`
--

CREATE TABLE `esk_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL,
  `menu_access` varchar(500) NOT NULL,
  `dash_access` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `esk_user_groups`
--

INSERT INTO `esk_user_groups` (`id`, `position_id`, `menu_access`, `dash_access`) VALUES
(1, 1, '1,2,3,5,6,7,9,11,12,13,14,15,17,18,19,20,21,27,29,30,31,32,34,35,36,50,51,52', '1,2,3,6,10,12,13,14'),
(5, 4, '1,23', '2,13'),
(15, 38, '1,2,3,4,5,6,9,11,16,21,22,23,24,27,28,33,34,37,38,39', '1,2,3,10,6,13,12'),
(16, 39, '2,11,9,28,33,21,23,5,22,36,37,38,24', '2,13,15'),
(17, 40, '1,2,9,29,30,31,32,34,35,36,11,28,24', ''),
(18, 41, '1,2,3,7,12,19,15,18,5', '3,12,7'),
(19, 42, '1,2,3,4,5,6,9,11,16,21,22,23,24,27,28,33,34,37,38,39', '1,3,2,6,12,13,15'),
(20, 43, '1,2,3,4,5,6,7,9,11,12,15,16,17,18,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,50,51,52', '1,2,3,4,6,8,10,11,12,13,14,17,15,16'),
(21, 44, '', '1,3,2,4,6,8,14,16,17'),
(22, 49, '1,2,3,4,5,6,9,11,16,20,21,22,23,24,27,28,33,34,37,38,39,50,51', ''),
(23, 53, '1,52', '2,52'),
(24, 63, '2,3,4,5,6,9,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,50,51,52', ''),
(25, 2, '1,2,3,5', ''),
(26, 60, '1,2,3,5', ''),
(27, 57, '1,2,3,5', '');

-- --------------------------------------------------------

--
-- Table structure for table `esk_websync_controller`
--

CREATE TABLE `esk_websync_controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `present_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `previous_timestamp` varchar(55) NOT NULL,
  `date` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `esk_subjects` ADD `is_core` INT NOT NULL COMMENT 'used for senior high only' AFTER `order` ;


-- --------------------------------------------------------

--
-- Table structure for table `esk_system_settings`
--

CREATE TABLE `esk_system_settings` (
  `sys_id` int(11) NOT NULL,
  `system_version` varchar(15) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--- 
--- attendance summary update
--- 

ALTER TABLE `esk_attendance_summary` ADD `school_year` YEAR NOT NULL AFTER `percent_female`;
ALTER TABLE `esk_attendance_summary` ADD `time_generated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

--
-- Indexes for table `esk_calendar_events`
--
ALTER TABLE `esk_calendar_events`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `esk_calendar_events`
--
ALTER TABLE `esk_calendar_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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

CREATE TABLE `esk_c_finance_charges` (
  `charge_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL COMMENT 'connected to fin_items',
  `amount` double NOT NULL,
  `semester` int(11) NOT NULL,
  `school_year` year(4) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `timecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `esk_c_finance_plan` (
  `fin_plan_id` int(11) NOT NULL,
  `fin_course_id` int(11) NOT NULL,
  `fin_year_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Finance Plans';

--
-- Indexes for table `esk_c_finance_charges`
--
ALTER TABLE `esk_c_finance_charges`
  ADD PRIMARY KEY (`charge_id`);

--
-- Indexes for table `esk_c_finance_plan`
--
ALTER TABLE `esk_c_finance_plan`
  ADD PRIMARY KEY (`fin_plan_id`);
--
-- AUTO_INCREMENT for table `esk_c_finance_charges`
--
ALTER TABLE `esk_c_finance_charges`
  MODIFY `charge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `esk_c_finance_plan`
--
ALTER TABLE `esk_c_finance_plan`
  MODIFY `fin_plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `esk_c_courses` ADD `num_years` INT NOT NULL AFTER `dept_id`;