CREATE TABLE `esk_canteen_dashboard_menu_buttons` (
  `id_menu_btn` int(20) NOT NULL,
  `name_menu_btn` varchar(50) NOT NULL,
  `menu_link` varchar(255) NOT NULL,
  `menu_btn_style` varchar(50) NOT NULL,
  `menu_btn_icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_canteen_dashboard_menu_buttons`
--

INSERT INTO `esk_canteen_dashboard_menu_buttons` (`id_menu_btn`, `name_menu_btn`, `menu_link`, `menu_btn_style`, `menu_btn_icon`) VALUES
(1, 'POS', 'canteen/pos', 'primary', 'money'),
(2, 'Sales', '', 'info', 'credit-card'),
(3, 'Inventory', '', 'success', 'file-excel-o'),
(4, 'Reports', '', 'default', 'bar-chart'),
(5, 'User', '', 'warning', 'user'),
(6, 'Products', 'canteen/products', 'danger', 'product-hunt');

-- --------------------------------------------------------

--
-- Table structure for table `esk_canteen_items`
--

CREATE TABLE `esk_canteen_items` (
  `canteen_item_id` int(20) NOT NULL,
  `canteen_item_name` varchar(255) NOT NULL,
  `canteen_item_price` float NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `item_left` int(255) NOT NULL,
  `item_sold` int(50) NOT NULL,
  `canteen_item_cat` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_canteen_items`
--

INSERT INTO `esk_canteen_items` (`canteen_item_id`, `canteen_item_name`, `canteen_item_price`, `total_quantity`, `item_left`, `item_sold`, `canteen_item_cat`) VALUES
(1, 'Adobong Kangkong', 15, 5, 0, 0, 1),
(2, 'Ampalaya', 10, 5, 0, 0, 1),
(3, 'Ampalaya with Egg', 15, 5, 0, 0, 1),
(4, 'Bam - e', 12, 0, 0, 0, 1),
(5, 'Banana ', 3, 0, 0, 0, 1),
(6, 'Buko ', 10, 0, 0, 0, 4),
(7, 'Buko Juice', 5, 0, 0, 0, 4),
(8, 'Buko Salad', 20, 0, 0, 0, 4),
(9, 'Hot Choco', 10, 0, 0, 0, 4),
(10, 'Hot Milk', 12, 0, 0, 0, 4),
(11, 'Juice', 10, 0, 0, 0, 4),
(12, 'Juice Packed', 7, 0, 0, 0, 4),
(13, 'Lemon Juice', 10, 0, 0, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `esk_canteen_menu_categories`
--

CREATE TABLE `esk_canteen_menu_categories` (
  `menu_cat_id` int(20) NOT NULL,
  `menu_cat_name` varchar(50) NOT NULL,
  `menu_pic` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_canteen_menu_categories`
--

INSERT INTO `esk_canteen_menu_categories` (`menu_cat_id`, `menu_cat_name`, `menu_pic`) VALUES
(1, 'Meals', '0'),
(2, 'Snacks', '0'),
(3, 'Desserts', '0'),
(4, 'Drinks', '0');

-- --------------------------------------------------------

--
-- Table structure for table `esk_canteen_personal_load_info`
--

CREATE TABLE `esk_canteen_personal_load_info` (
  `cpli_id` int(11) NOT NULL,
  `cpli_fin_item_id` int(11) NOT NULL,
  `cpli_user_id` int(11) NOT NULL,
  `cpli_load` float NOT NULL,
  `cpli_daily_limit` float NOT NULL,
  `cpli_refill_reminder` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esk_canteen_personal_load_info`
--

INSERT INTO `esk_canteen_personal_load_info` (`cpli_id`, `cpli_fin_item_id`, `cpli_user_id`, `cpli_load`, `cpli_daily_limit`, `cpli_refill_reminder`) VALUES
(4, 0, 970, 112, 100, 200);

-- --------------------------------------------------------

--
-- Table structure for table `esk_canteen_transaction`
--

CREATE TABLE `esk_canteen_transaction` (
  `transaction_id` int(20) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customer_id` varchar(255) NOT NULL,
  `employee_id` int(255) NOT NULL,
  `transact_total` varchar(255) NOT NULL,
  `customer_cash` varchar(255) NOT NULL,
  `customer_change` varchar(255) NOT NULL,
  `transact_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_canteen_transaction`
--

INSERT INTO `esk_canteen_transaction` (`transaction_id`, `transaction_date`, `customer_id`, `employee_id`, `transact_total`, `customer_cash`, `customer_change`, `transact_num`) VALUES
(1, '2017-06-06 14:45:11', '186', 1, 'Php 24.00', '24.00', '0', '0606104225');

-- --------------------------------------------------------

--
-- Table structure for table `esk_canteen_transaction_rec`
--

CREATE TABLE `esk_canteen_transaction_rec` (
  `rec_id` int(20) NOT NULL,
  `item_id` int(50) NOT NULL,
  `item_quantity` varchar(20) NOT NULL,
  `transaction_num` varchar(255) NOT NULL,
  `item_price` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cashier_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esk_canteen_transaction_rec`
--

INSERT INTO `esk_canteen_transaction_rec` (`rec_id`, `item_id`, `item_quantity`, `transaction_num`, `item_price`, `customer_id`, `cashier_id`, `transaction_date`) VALUES
(19, 1, '1', '0607025508', '12', 970, 1, '2017-06-07'),
(20, 3, '1', '0607025508', '15', 970, 1, '2017-06-07'),
(21, 13, '1', '0607025508', '10', 970, 1, '2017-06-07'),
(22, 1, '1', '0607031506', '12', 970, 1, '2017-06-07'),
(23, 3, '1', '0607031506', '15', 970, 1, '2017-06-07'),
(24, 8, '1', '0607031506', '20', 970, 1, '2017-06-07'),
(25, 1, '1', '0607034819', '15', 970, 1, '2017-06-07'),
(26, 3, '1', '0607034819', '15', 970, 1, '2017-06-07'),
(27, 9, '1', '0607034819', '10', 970, 1, '2017-06-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `esk_canteen_items`
--
ALTER TABLE `esk_canteen_items`
  ADD PRIMARY KEY (`canteen_item_id`);

--
-- Indexes for table `esk_canteen_menu_categories`
--
ALTER TABLE `esk_canteen_menu_categories`
  ADD PRIMARY KEY (`menu_cat_id`);

--
-- Indexes for table `esk_canteen_personal_load_info`
--
ALTER TABLE `esk_canteen_personal_load_info`
  ADD PRIMARY KEY (`cpli_id`);

--
-- Indexes for table `esk_canteen_transaction`
--
ALTER TABLE `esk_canteen_transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `esk_canteen_transaction_rec`
--
ALTER TABLE `esk_canteen_transaction_rec`
  ADD PRIMARY KEY (`rec_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `esk_canteen_items`
--
ALTER TABLE `esk_canteen_items`
  MODIFY `canteen_item_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `esk_canteen_personal_load_info`
--
ALTER TABLE `esk_canteen_personal_load_info`
  MODIFY `cpli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `esk_canteen_transaction`
--
ALTER TABLE `esk_canteen_transaction`
  MODIFY `transaction_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `esk_canteen_transaction_rec`
--
ALTER TABLE `esk_canteen_transaction_rec`
  MODIFY `rec_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `esk_canteen_items` ADD `serve_option` INT NOT NULL COMMENT '1 = breakfast; 2 = Lunch; 3 = Dinner' AFTER `canteen_item_cat`;