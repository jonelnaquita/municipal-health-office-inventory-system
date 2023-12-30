-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 07:38 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`) VALUES
(1, 'Vitamins'),
(2, 'Antipyretics'),
(3, 'Analgesics'),
(4, 'Antibiotics'),
(5, 'Antiseptics'),
(7, 'CNS'),
(11, 'Antioxidants'),
(12, 'Anticholinergics');

-- --------------------------------------------------------

--
-- Table structure for table `customer_list`
--

CREATE TABLE `customer_list` (
  `id` int(30) NOT NULL,
  `product_id` text NOT NULL,
  `firstname` text NOT NULL,
  `middleinitial` varchar(2) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `age` int(50) NOT NULL,
  `birth_day` date DEFAULT NULL,
  `medicine_prescription` varchar(255) NOT NULL,
  `quantity` int(200) NOT NULL,
  `date_encode` date NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_list`
--

INSERT INTO `customer_list` (`id`, `product_id`, `firstname`, `middleinitial`, `lastname`, `contact`, `address`, `age`, `birth_day`, `medicine_prescription`, `quantity`, `date_encode`, `year`) VALUES
(73, '118', 'Anna', '', '', '09875784546', 'Brgy. Anastacia', 16, '2007-02-20', '', 1, '2023-09-20', 0),
(77, '23', 'danie', '', '', '97656456463', 'Brgy. Ayusan II', 23, '2023-09-18', 'Medicine requires prescription', 15, '2023-09-21', 0),
(79, '123', 'johann', '', '', '09673620161', 'Brgy. Anastacia', 20, '2003-10-29', 'Medicine requires prescription', 5, '2023-09-26', 0),
(83, '125', 'Nisha Arrogancia', '', '', '09500558967', 'SPC', 23, '2023-06-13', '', 0, '0000-00-00', 0),
(86, '123', 'Anna', '', '', '09875784546', 'Brgy. Anastacia', 16, '2007-02-20', '', 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `heat_map`
--

CREATE TABLE `heat_map` (
  `id` int(11) NOT NULL,
  `brgy_name` varchar(50) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `heat_map`
--

INSERT INTO `heat_map` (`id`, `brgy_name`, `latitude`, `longitude`) VALUES
(32, 'Brgy. Anastacia', '13.965690', '121.353424'),
(33, 'Brgy. Aquino', '13.970759', '121.292185'),
(34, 'Brgy. Ayusan I', '13.978584', '121.318485'),
(35, 'Brgy. Ayusan II', '13.978584', '121.318485'),
(36, 'Brgy. Behia', '13.902670', '121.339922'),
(37, 'Brgy. Bukal', '13.929922', '121.288786'),
(38, 'Brgy. Bula', '13.924233', '121.308598'),
(39, 'Brgy. Bulakin', '13.984925', '121.344018'),
(40, 'Brgy. Cabatang', '13.970329', '121.382796'),
(41, 'Brgy. Cabay', '13.883146', '121.374222'),
(42, 'Brgy. Del Rosario', '13.855647', '121.385661'),
(43, 'Brgy. Lagalag', '13.939658', '121.380212'),
(44, 'Brgy. Lalig', '13.974496', '121.325106'),
(45, 'Brgy. Lumingon', '13.957160', '121.330441'),
(46, 'Brgy. Lusacan', '13.969073', '121.268100'),
(47, 'Brgy. Paiisa', '13.887353', '121.369349'),
(48, 'Brgy. Palagaran', '13.947533', '121.351114'),
(49, 'Brgy. Poblacion I', '13.978784', '121.319584'),
(50, 'Brgy. Poblacion II', '13.961516', '121.321343'),
(51, 'Brgy. Poblacion III', '13.958693', '121.323436'),
(52, 'Brgy. Poblacion IV', '13.961516', '121.321343'),
(53, 'Brgy. Quipot', '13.954975', '121.320473'),
(54, 'Brgy. San Agustin', '13.950362', '121.319606'),
(55, 'Brgy. Isidro', '13.984962', '121.314118'),
(56, 'Brgy. San Jose', '13.901753', '121.308890'),
(57, 'Brgy. San Juan', '13.897659', '121.357094'),
(58, 'Brgy. San Pedro', '13.967673', '121.308507'),
(59, 'Brgy. Tagbakin', '13.913997', '121.362711'),
(60, 'Brgy. Talisay', '13.945534', '121.359538'),
(61, 'Brgy. Tamisian', '13.938505', '121.300002'),
(62, 'Brgy. San Francisco', '13.892342', '121.349398');

-- --------------------------------------------------------

--
-- Table structure for table `item_description`
--

CREATE TABLE `item_description` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_description`
--

INSERT INTO `item_description` (`id`, `name`) VALUES
(1, 'Azithromycin'),
(2, 'Cefalexin'),
(3, 'Amoxicillin'),
(4, 'Ascorbic Acid'),
(5, 'Aspirin'),
(6, 'Ciprofloxacin'),
(7, 'Co-amox'),
(8, 'Dicycloverine');

-- --------------------------------------------------------

--
-- Table structure for table `item_requested`
--

CREATE TABLE `item_requested` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `availed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_requested`
--

INSERT INTO `item_requested` (`id`, `patient_id`, `product_id`, `quantity`, `availed_date`) VALUES
(4, 2, 123, 2, '2023-12-27'),
(5, 2, 123, 2, '2023-12-27'),
(6, 2, 123, 4, '2023-12-27'),
(7, 2, 123, 3, '2023-12-27'),
(8, 2, 123, 2, '2023-12-27'),
(9, 2, 123, 1, '2023-12-27'),
(10, 2, 123, 2, '2023-12-27'),
(11, 2, 123, 8, '2023-12-27'),
(12, 2, 123, 3, '2023-12-27'),
(13, 2, 123, 18, '2023-12-29'),
(14, 2, 129, 24, '2023-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `manage_sub_category`
--

CREATE TABLE `manage_sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_sub_category`
--

INSERT INTO `manage_sub_category` (`id`, `category_id`, `sub_category_name`, `brand_name`) VALUES
(2, 1, 'Vitamin A', 'Aquasol'),
(4, 1, 'Vitamin B1', 'Thiamine'),
(5, 1, 'Vitamin C', 'C-supreme'),
(6, 4, 'flouroquinolones', 'Ofloxacin'),
(7, 4, 'Penicillins', 'Benzathine'),
(8, 4, 'Cephalosporins', 'Cephalexin'),
(9, 4, 'Macrolides', 'Azithromycin'),
(11, 4, 'Sulfonamides', 'Azulfidine'),
(12, 4, 'Tetracyclines', 'Doryx'),
(13, 4, 'Aminoglycosides', 'Gentamicin '),
(14, 4, 'Carbapenems', 'Meropenem'),
(15, 3, 'Anti-inflammatory Drugs', 'Aspirin'),
(16, 3, 'Anti-inflammatory opioids', 'OxyContin'),
(17, 12, 'Diphenhydramine', 'Benadryl'),
(18, 12, 'Bentyl', 'Dicyclomine'),
(21, 11, 'Ascorbic Acid', 'Acerola C'),
(22, 11, 'Vitamin A', 'Retinol'),
(23, 11, 'Vitamin E', 'Aquasol E'),
(24, 11, 'Lipoic Acid', 'Nutricost ALA'),
(26, 2, 'Salicylates', 'Choline Salicylate'),
(27, 2, 'Ibuprofen', 'Enerlax'),
(28, 5, 'Chorhexidine', 'Orahex oral rinse'),
(31, 1, 'Vitamin B2', 'Reboflavin'),
(32, 1, 'Vitamin B12', 'Super B Energy Complex'),
(33, 4, 'flouroquinolones', 'Ciprofoxacin'),
(34, 4, 'flouroquinolones', 'Levofloxacin'),
(35, 4, 'flouroquinolones', 'Moxifloxacin'),
(36, 4, 'Cephalosporins', 'Cefadroxil'),
(37, 4, 'Cephalosporins', 'Cephradine'),
(38, 4, 'Macrolides', 'Clarithromycin'),
(39, 4, 'Macrolides', 'Difficid'),
(40, 4, 'Macrolides', 'Ery-Tab'),
(41, 4, 'Sulfonamides', 'Azulfidine Entabs'),
(42, 4, 'Sulfonamides', 'Diamox Sequels'),
(43, 4, 'Sulfonamides', 'Sulfazine'),
(44, 4, 'Sulfonamides', 'Sulfazine C');

-- --------------------------------------------------------

--
-- Table structure for table `patient_list`
--

CREATE TABLE `patient_list` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_initial` varchar(5) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_registered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_list`
--

INSERT INTO `patient_list` (`id`, `first_name`, `middle_initial`, `last_name`, `age`, `birthdate`, `contact_number`, `address`, `date_registered`) VALUES
(2, 'Jonel', '', 'Naquita', 23, '2000-12-05', '09166931191', 'Brgy. Anastacia', '2023-12-19'),
(18, 'Jerico', '', 'Naquita', 7, '2016-01-29', '09166931191', 'Brgy. Bula', '2023-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `category_id` text NOT NULL,
  `type_id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `dosage` text NOT NULL,
  `dosage_form` varchar(255) NOT NULL,
  `prescription` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_expiry` date NOT NULL,
  `unit_measure` varchar(255) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `shelf_no` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `type_id`, `item_id`, `supplier_id`, `customer_id`, `sub_category_id`, `sku`, `name`, `qty`, `dosage`, `dosage_form`, `prescription`, `date_added`, `date_expiry`, `unit_measure`, `batch_no`, `brand`, `shelf_no`, `status`) VALUES
(115, '', 3, 0, 3, 0, 4, '', '', 50, '200mg/5ml', 'Solution', 1, '2023-11-23 12:45:26', '2023-11-30', 'Pieces', '2DB257', 'Generic', 2, 'Archived'),
(123, '', 2, 0, 3, 0, 5, '', '', 3, '200mg/5ml', 'Solution', 0, '2023-12-11 17:26:24', '2024-11-12', 'PCS', '2023003', 'Generic', 5, ''),
(125, '', 2, 0, 4, 0, 2, '', '', 10, '200mg/5ml', 'Solution', 1, '2023-12-11 17:37:10', '2024-02-01', 'Pcs', '4', 'Generic', 4, 'Archived'),
(128, '', 2, 0, 4, 0, 2, '', '', 40, '200mg/5ml', 'Solution', 1, '2023-12-29 06:57:31', '2023-12-30', 'PCS', '3', 'Generic', 6, 'Archived'),
(129, '', 2, 0, 5, 0, 2, '', '', 16, '200mg/5ml', 'Solution', 1, '2023-12-29 06:58:16', '2024-12-30', 'PCS', '3', 'Generic', 6, ''),
(130, '', 2, 0, 5, 0, 7, '', '', 50, '200mg/5ml', 'Solution', 1, '2023-12-30 06:31:00', '2024-09-20', 'PCS', '3', 'Generic', 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `receiving_list`
--

CREATE TABLE `receiving_list` (
  `id` int(30) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `batch_no` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sales_list`
--

CREATE TABLE `sales_list` (
  `id` int(30) NOT NULL,
  `ref_no` varchar(30) NOT NULL,
  `customer_id` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `amount_tendered` double NOT NULL,
  `amount_change` double NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_list`
--

INSERT INTO `sales_list` (`id`, `ref_no`, `customer_id`, `total_amount`, `amount_tendered`, `amount_change`, `date_updated`) VALUES
(2, '00000000\n', 0, 310, 400, 90, '2020-10-08 13:23:13'),
(3, '74800422\n', 0, 200, 200, 0, '2020-10-08 13:42:29'),
(4, '01966403\n', 0, 100, 100, 0, '2020-10-08 13:43:08'),
(5, '16232790\n', 1, 250, 300, 50, '2020-10-09 08:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out_items`
--

CREATE TABLE `stock_out_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stock_out_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` enum('Expired','Requested') DEFAULT 'Expired'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_out_items`
--

INSERT INTO `stock_out_items` (`id`, `product_id`, `stock_out_date`, `quantity`, `status`) VALUES
(1, 115, '2023-12-19', 50, 'Expired'),
(2, 125, '2023-12-19', 10, 'Expired'),
(5, 123, '2023-12-27', 2, 'Requested'),
(6, 123, '2023-12-27', 2, 'Requested'),
(7, 123, '2023-12-27', 4, 'Requested'),
(8, 123, '2023-12-27', 3, 'Requested'),
(9, 123, '2023-12-27', 2, 'Requested'),
(10, 123, '2023-12-27', 1, 'Requested'),
(11, 123, '2023-12-27', 2, 'Requested'),
(12, 123, '2023-12-27', 8, 'Requested'),
(13, 123, '2023-12-27', 3, 'Requested'),
(14, 128, '2023-12-29', 40, 'Expired'),
(15, 123, '2023-12-29', 18, 'Requested'),
(16, 129, '2023-12-29', 24, 'Requested');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_list`
--

CREATE TABLE `supplier_list` (
  `id` int(30) NOT NULL,
  `supplier_name` text NOT NULL,
  `contact` varchar(30) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_list`
--

INSERT INTO `supplier_list` (`id`, `supplier_name`, `contact`, `address`) VALUES
(3, 'Supplier 1', '09903257312', 'San Pablo City'),
(4, 'Supplier 2', '85655466', 'Tiaong Quezon'),
(5, 'Supplier 3', '09500558967', 'San Pablo City');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Online Food Ordering System', 'info@sample.com', '+6948 8542 623', '1600654680_photo-1504674900247-0877df9cc836.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;ABOUT US&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;b style=&quot;margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem Ipsum&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#x2019;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;&lt;h2 style=&quot;font-size:28px;background: transparent; position: relative;&quot;&gt;Where does it come from?&lt;/h2&gt;&lt;p style=&quot;text-align: center; margin-bottom: 15px; padding: 0px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400;&quot;&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.&lt;/p&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `type_list`
--

CREATE TABLE `type_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_list`
--

INSERT INTO `type_list` (`id`, `name`) VALUES
(2, 'Capsule'),
(3, 'Drops'),
(4, 'Inhalers'),
(5, 'Tablet'),
(7, 'Suppositories'),
(8, 'Injections');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = cashier',
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `type`, `login_time`, `code`) VALUES
(1, 'Nisha', 'tiaongmunicipalhealthoffice@gmail.com', 'admin', 'c93ccd78b2076528346216b3b2f701e6', 1, '2023-09-14 01:58:41', ''),
(5, 'KENN', '', 'staff', 'c93ccd78b2076528346216b3b2f701e6', 2, '2023-09-14 01:58:41', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logs` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `logs`, `date_added`) VALUES
(6, 1, 'Nisha Login', '2023-12-11 20:00:34'),
(7, 1, 'Nisha Login', '2023-12-12 03:02:46'),
(9, 1, 'Nisha added a new item', '2023-12-12 03:07:09'),
(10, 1, 'Nisha login', '2023-12-12 03:13:56'),
(11, 1, 'Nisha login', '2023-12-12 03:14:33'),
(12, 1, 'Nisha logout', '2023-12-12 03:24:15'),
(13, 1, 'Nisha login', '2023-12-12 03:24:25'),
(14, 1, 'Nisha logout', '2023-12-12 06:08:50'),
(15, 1, 'Nisha login', '2023-12-12 06:12:31'),
(16, 1, 'Nisha logout', '2023-12-12 06:12:34'),
(17, 1, 'Nisha login', '2023-12-12 06:12:45'),
(18, 1, 'Nisha logout', '2023-12-13 10:40:15'),
(19, 1, 'Nisha login', '2023-12-13 10:41:37'),
(20, 1, 'Nisha login', '2023-12-19 05:18:11'),
(21, 1, 'Nisha logout', '2023-12-19 09:23:09'),
(22, 1, 'Nisha login', '2023-12-19 09:27:38'),
(23, 1, 'Nisha logout', '2023-12-19 09:27:42'),
(24, 1, 'Nisha login', '2023-12-19 11:21:22'),
(25, 1, 'Nisha logout', '2023-12-19 16:13:01'),
(26, 1, 'Nisha login', '2023-12-27 09:25:02'),
(27, 1, 'Nisha added a new item', '2023-12-29 14:57:31'),
(28, 1, 'Nisha added a new item', '2023-12-29 14:58:16'),
(29, 1, 'Nisha login', '2023-12-29 18:14:46'),
(30, 1, 'Nisha login', '2023-12-30 10:54:43'),
(31, 1, 'Nisha logout', '2023-12-30 11:43:57'),
(32, 1, 'Nisha login', '2023-12-30 12:04:06'),
(33, 1, 'Nisha logout', '2023-12-30 12:04:13'),
(34, 1, 'Nisha login', '2023-12-30 14:19:10'),
(35, 1, 'Nisha added a new item (Penicillins - Benzathine)', '2023-12-30 14:31:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_list`
--
ALTER TABLE `customer_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heat_map`
--
ALTER TABLE `heat_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_description`
--
ALTER TABLE `item_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_requested`
--
ALTER TABLE `item_requested`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `manage_sub_category`
--
ALTER TABLE `manage_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_list`
--
ALTER TABLE `patient_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receiving_list`
--
ALTER TABLE `receiving_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_list`
--
ALTER TABLE `sales_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_out_items`
--
ALTER TABLE `stock_out_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `supplier_list`
--
ALTER TABLE `supplier_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_list`
--
ALTER TABLE `type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customer_list`
--
ALTER TABLE `customer_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `heat_map`
--
ALTER TABLE `heat_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `item_description`
--
ALTER TABLE `item_description`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `item_requested`
--
ALTER TABLE `item_requested`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `manage_sub_category`
--
ALTER TABLE `manage_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `patient_list`
--
ALTER TABLE `patient_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `receiving_list`
--
ALTER TABLE `receiving_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_list`
--
ALTER TABLE `sales_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_out_items`
--
ALTER TABLE `stock_out_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `supplier_list`
--
ALTER TABLE `supplier_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type_list`
--
ALTER TABLE `type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_requested`
--
ALTER TABLE `item_requested`
  ADD CONSTRAINT `item_requested_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_list` (`id`),
  ADD CONSTRAINT `item_requested_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`);

--
-- Constraints for table `stock_out_items`
--
ALTER TABLE `stock_out_items`
  ADD CONSTRAINT `stock_out_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
