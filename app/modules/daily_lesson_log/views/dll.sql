ALTER TABLE `esk_dll` ADD `dll_concept` VARCHAR(500) NOT NULL AFTER `dll_assess_id`;

CREATE TABLE `dll_sections` (
  `dll_sec_id` int(11) NOT NULL,
  `dll_section` varchar(500) NOT NULL,
  `dll_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='customized sections in dll';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dll_sections`
--
ALTER TABLE `dll_sections`
  ADD PRIMARY KEY (`dll_sec_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dll_sections`
--
ALTER TABLE `dll_sections`
  MODIFY `dll_sec_id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `dll_section_details` (
  `sd_id` int(11) NOT NULL,
  `sd_sec_id` int(11) NOT NULL,
  `sd_section_details` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dll_section_details`
--
ALTER TABLE `dll_section_details`
  ADD PRIMARY KEY (`sd_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dll_section_details`
--
ALTER TABLE `dll_section_details`
  MODIFY `sd_id` int(11) NOT NULL AUTO_INCREMENT;