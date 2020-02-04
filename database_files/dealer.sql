-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 04, 2020 at 12:03 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dealer`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `serial_no` bigint(20) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `serial_no` bigint(20) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `district_name` varchar(255) NOT NULL,
  `thana_name` varchar(255) NOT NULL,
  `line_route` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`serial_no`, `area_name`, `district_name`, `thana_name`, `line_route`) VALUES
(1, 'Pourashava', 'Coxs Bazar', 'Coxs Bazar', 'Poura shava Line'),
(2, 'Khurshkhul', 'Coxs Bazar', 'Coxs Bazar', 'Khurushkhul Line'),
(3, 'Link Road', 'Coxs Bazar', 'Coxs Bazar', 'Link Road Line'),
(4, 'Nuniachara', 'Coxs Bazar', 'Coxs Bazar', 'Nuniachara Line'),
(5, 'Baharchar', 'Coxs Bazar', 'Coxs Bazar', 'BaharChara Line'),
(6, 'Kolatoli', 'Coxs Bazar', 'Coxs Bazar', 'Kolatoli Line'),
(7, 'Barabazar', 'coxbazer', 'coxbazar', 'coxbazar'),
(9, 'Marissa bazar', 'coxbazer', 'Ramu', 'coutbazar'),
(10, ',sonarpara,', 'coxbazer', 'ukia', 'coutbazar'),
(12, 'coutbazar', 'coxbazer', 'ukia', 'coutbazar');

-- --------------------------------------------------------

--
-- Table structure for table `area_zone`
--

CREATE TABLE `area_zone` (
  `serial_no` int(11) NOT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `area_serial_no` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `area_zone`
--

INSERT INTO `area_zone` (`serial_no`, `zone_serial_no`, `area_serial_no`, `area_name`) VALUES
(30, '1', '1', 'Pourashava'),
(31, '1', '2', 'Khurshkhul'),
(32, '1', '3', 'Link Road'),
(33, '1', '4', 'Nuniachara'),
(34, '1', '5', 'Baharchar'),
(35, '1', '6', 'Kolatoli'),
(36, '1', '7', 'Barabazar'),
(38, '3', '9', 'Marissa bazar'),
(39, '3', '10', ',sonarpara,'),
(40, '3', '12', 'coutbazar');

-- --------------------------------------------------------

--
-- Table structure for table `bank_deposite`
--

CREATE TABLE `bank_deposite` (
  `serial_no` int(11) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `deposite_date` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_loan`
--

CREATE TABLE `bank_loan` (
  `serial_no` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `loan_taken_date` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_loan_pay`
--

CREATE TABLE `bank_loan_pay` (
  `id` int(11) NOT NULL,
  `bank_loan_id` int(11) NOT NULL,
  `pay_amt` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_withdraw`
--

CREATE TABLE `bank_withdraw` (
  `serial_no` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_account_no` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `cheque_active_date` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `serial_no` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`serial_no`, `category_name`) VALUES
(1, 'UHT Milk'),
(2, 'Bangla Tissue'),
(3, 'Mori'),
(4, 'Soft Drinks'),
(5, 'Empro'),
(6, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `serial_no` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `cust_id` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sales_man_id` varchar(255) DEFAULT NULL,
  `sales_man_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`serial_no`, `area_name`, `cust_id`, `category_name`, `client_name`, `organization_name`, `address`, `mobile_no`, `email`, `description`, `sales_man_id`, `sales_man_name`) VALUES
(1, 'Pourashava', 'CUST-000001', 'Regular', 'Mr. Sona Mia Sowdagor', 'Lhaki Stote', 'IBP Road, Bazar Ghata, Cox\'s Bazar', '01', '', '', NULL, NULL),
(3, 'Pourashava', 'CUST-000002', 'Best', 'Abul Kasham', 'Vhi Vhi Store', 'IBP Road, Coxs Bazar', '0192556', '', '', NULL, NULL),
(6, 'Pourashava', 'CUST-000003', 'Best', 'Abdul gani', 'Gani store', 'i.b.p Road,coxbazar.', '12345', '', '', NULL, NULL),
(8, 'Pourashava', 'CUST-000004', 'Best', 'Cash Customer', 'Cash Customer', 'co', '1254', '', '', NULL, NULL),
(9, 'Pourashava', 'CUST-000005', 'Best', 'Mr. YY', 'Family Needs', 'Cox\'s Bazar', '000', '', '', NULL, NULL),
(13, 'Pourashava', 'CUST-000006', 'Best', 'sohag', 'sohag shop', 'abulkhairsoasldfjaklsfjaskjfkldas', '01753474401', 'abulkhairsohag@gmail.com', 'lasjdfkljask', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_category`
--

CREATE TABLE `client_category` (
  `serial_no` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_category`
--

INSERT INTO `client_category` (`serial_no`, `category_name`) VALUES
(11, 'Regular'),
(12, 'Irregular'),
(14, 'Best');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `serial_no` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `responder_name` varchar(255) NOT NULL,
  `respoder_designation` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `product_quality` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`serial_no`, `company_name`, `responder_name`, `respoder_designation`, `address`, `mobile_no`, `phone_no`, `fax`, `email`, `website`, `product_type`, `product_quality`, `description`) VALUES
(1, 'Pran Dairy Ltd', 'My. YY', 'Company Sales Representative', 'Dhaka', '019255', '', '', 'admin@gmail.com', '', 'Milk', '', ''),
(2, 'Globe Soft Drinks', 'Mr. YY', 'Company Sales Representative', 'Noyakhali', '0192556', '', '', 'admin@gmail.com', '', '', '', ''),
(3, 'AB Food', 'Mr. YY', 'Company Sales Representative', 'Dhaka', '0192556', '', '', 'admin@gmail.com', '', '', '', ''),
(4, 'Prome Agro Foods', 'Mr. YY', 'Company Sales Representative', 'Dhaka', '019255', '', '', 'admin@gmail.com', '', '', '', ''),
(5, 'Janata Food', 'Mr. YY', 'Company Sales Representative', 'Dhaka', '0192556', '', '', 'admin@gmail.com', '', '', '', ''),
(6, 'Nisso Kisso Paper Company Ltd', 'Mr. YY', 'Company Sales Representative', 'Dhaka', '0192556', '', '', 'admin@gmail.com', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `company_commission`
--

CREATE TABLE `company_commission` (
  `serial_no` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `target_product` varchar(255) NOT NULL,
  `target_sell_amount` varchar(255) NOT NULL,
  `comission_persent` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_products_return`
--

CREATE TABLE `company_products_return` (
  `serial_no` int(11) NOT NULL,
  `products_id_no` varchar(255) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `company_price` varchar(255) NOT NULL,
  `return_quantity` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `return_reason` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `return_date` varchar(255) NOT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `delivered_order_payment_history`
--

CREATE TABLE `delivered_order_payment_history` (
  `serial_no` int(11) NOT NULL,
  `deliver_order_serial_no` varchar(255) DEFAULT NULL,
  `delivery_emp_id` varchar(255) DEFAULT NULL,
  `pay_amt` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivered_order_payment_history`
--

INSERT INTO `delivered_order_payment_history` (`serial_no`, `deliver_order_serial_no`, `delivery_emp_id`, `pay_amt`, `date`, `zone_serial_no`) VALUES
(1, '2', 'EMP-000008', '26000', '06-01-2020', '1'),
(2, '3', 'EMP-000008', '20000', '06-01-2020', '1'),
(3, '3', 'EMP-000001', '1000', '06-01-2020', '1'),
(4, '2', 'EMP-000001', '250', '06-01-2020', '1'),
(5, '1', 'EMP-000008', '2625', '07-01-2020', '1'),
(6, '2', 'EMP-000008', '3000', '07-01-2020', '1'),
(7, '3', 'EMP-000008', '9549', '07-01-2020', '1'),
(8, '4', 'EMP-000008', '368', '07-01-2020', '1'),
(9, '5', 'EMP-000004', '5000', '09-01-2020', '1'),
(10, '6', 'EMP-000008', '3000', '09-01-2020', '1'),
(11, '7', 'EMP-000004', '1108', '09-01-2020', '1'),
(12, '8', 'EMP-000009', '72', '11-01-2020', '1'),
(13, '9', 'EMP-000009', '360', '11-01-2020', '1'),
(14, '10', 'EMP-000004', '21450', '15-01-2020', '1'),
(15, '11', 'EMP-000004', '', '15-01-2020', '1'),
(16, '12', 'EMP-000004', '68790', '15-01-2020', '1'),
(17, '13', 'EMP-000004', '', '15-01-2020', '1'),
(18, '16', 'EMP-000008', '400', '26-01-2020', '1'),
(19, '17', 'EMP-000008', '450', '26-01-2020', '1'),
(20, '18', 'EMP-000008', '1700', '26-01-2020', '1'),
(21, '19', 'EMP-000008', '450', '26-01-2020', '1'),
(22, '20', 'EMP-000008', '17', '26-01-2020', '1'),
(23, '21', 'EMP-000004', '51', '26-01-2020', '1'),
(24, '22', 'EMP-000004', '400', '26-01-2020', '1'),
(25, '21', 'EMP-000010', '1400', '27-01-2020', '1'),
(26, '23', 'EMP-000004', '', '27-01-2020', '1'),
(27, '24', 'EMP-000004', '0', '27-01-2020', '1'),
(28, '25', 'EMP-000004', '0', '27-01-2020', '1'),
(29, '26', 'EMP-000004', '0', '27-01-2020', '1'),
(30, '27', 'EMP-000008', '0', '28-01-2020', '1'),
(31, '28', 'EMP-000001', '5', '29-01-2020', '1'),
(32, '28', 'EMP-000002', '95', '29-01-2020', '1');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_employee`
--

CREATE TABLE `delivery_employee` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `active_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery_employee`
--

INSERT INTO `delivery_employee` (`serial_no`, `id_no`, `name`, `active_status`) VALUES
(3, 'EMP-000008', 'Mr. Nurul Alam', 'Active'),
(5, 'EMP-000009', 'Mr. YY', 'Active'),
(6, 'EMP-000004', 'Mr. Redwan', 'Active'),
(8, 'EMP-000011', 'Mr. Mizanur Rohman', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `due_payment_invoice`
--

CREATE TABLE `due_payment_invoice` (
  `serial_no` int(11) NOT NULL,
  `invoice_serial_no` int(11) DEFAULT NULL,
  `pay_amount` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `payment_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_academic_info`
--

CREATE TABLE `employee_academic_info` (
  `serial_no` int(11) NOT NULL,
  `main_tbl_serial_no` int(11) DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `exam_name` varchar(255) DEFAULT NULL,
  `board_university` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `passing_year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_academic_info`
--

INSERT INTO `employee_academic_info` (`serial_no`, `main_tbl_serial_no`, `institute`, `exam_name`, `board_university`, `group_name`, `result`, `passing_year`) VALUES
(1, 1, '', '', '', '', '', ''),
(2, 2, '', '', '', '', '', ''),
(4, 4, '', '', '', '', '', ''),
(5, 5, '', '', '', '', '', ''),
(6, 6, '', '', '', '', '', ''),
(7, 7, '', '', '', '', '', ''),
(8, 8, '', '', '', '', '', ''),
(9, 9, '', '', '', '', '', ''),
(10, 10, '', '', '', '', '', ''),
(11, 11, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance`
--

CREATE TABLE `employee_attendance` (
  `serial_no` int(11) NOT NULL,
  `employee_id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `attendance` varchar(255) NOT NULL DEFAULT '0',
  `attendance_date` varchar(255) NOT NULL,
  `attendance_month` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_attendance`
--

INSERT INTO `employee_attendance` (`serial_no`, `employee_id_no`, `name`, `designation`, `attendance`, `attendance_date`, `attendance_month`) VALUES
(1, 'EMP-000001', 'Mr. Bikas Kanti Day', 'Salesman', '0', '06-01-2020', '01-2020'),
(2, 'EMP-000002', 'Mr. Pervaj', 'Salesman', '0', '06-01-2020', '01-2020'),
(3, 'EMP-000003', 'Mr. MIzanur Rohman', 'Salesman', '0', '06-01-2020', '01-2020'),
(4, 'EMP-000004', 'Mr. Redwan', 'Salesman', '0', '06-01-2020', '01-2020'),
(5, 'EMP-000005', 'Mr. Rubel', 'Salesman', '0', '06-01-2020', '01-2020'),
(6, 'EMP-000006', 'Mr. Iqbal Hossain', 'Own Shop Salesman', '0', '06-01-2020', '01-2020'),
(7, 'EMP-000007', 'Mr. Tohid', 'Own Shop Salesman', '0', '06-01-2020', '01-2020'),
(8, 'EMP-000008', 'Mr. Nurul Alam', 'Delivery Man', '0', '06-01-2020', '01-2020'),
(9, 'EMP-000009', 'Mr. YY', 'Delivery Man', '1', '06-01-2020', '01-2020');

-- --------------------------------------------------------

--
-- Table structure for table `employee_commission`
--

CREATE TABLE `employee_commission` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `sell_target` varchar(255) NOT NULL,
  `total_sell_amount` varchar(255) NOT NULL,
  `comission_persent` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_document_info`
--

CREATE TABLE `employee_document_info` (
  `serial_no` int(11) NOT NULL,
  `main_tbl_serial_no` int(11) NOT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `upload_document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_document_info`
--

INSERT INTO `employee_document_info` (`serial_no`, `main_tbl_serial_no`, `document_name`, `document_type`, `description`, `upload_document`) VALUES
(1, 1, '', '', '', ''),
(2, 2, '', '', '', ''),
(4, 4, '', '', '', ''),
(5, 5, '', '', '', ''),
(6, 6, '', '', '', ''),
(7, 7, '', '', '', ''),
(8, 8, '', '', '', ''),
(9, 9, '', '', '', ''),
(10, 10, '', '', '', ''),
(11, 11, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_duty`
--

CREATE TABLE `employee_duty` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `per_day` varchar(255) DEFAULT NULL,
  `per_month` varchar(255) DEFAULT NULL,
  `comission` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_duty`
--

INSERT INTO `employee_duty` (`serial_no`, `id_no`, `name`, `area`, `company`, `per_day`, `per_month`, `comission`, `description`, `active_status`) VALUES
(1, 'EMP-000001', 'Mr. Bikas Kanti Day', '', NULL, '', '', '', '', 'Active'),
(2, 'EMP-000002', 'Mr. Pervaj', '', NULL, '', '', '', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employee_main_info`
--

CREATE TABLE `employee_main_info` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `joining_date` varchar(255) DEFAULT NULL,
  `basic_salary` varchar(255) DEFAULT NULL,
  `house_rent` varchar(255) DEFAULT NULL,
  `medical_allowance` varchar(255) DEFAULT NULL,
  `transport_allowance` varchar(255) DEFAULT NULL,
  `insurance` varchar(255) DEFAULT NULL,
  `commission` varchar(255) DEFAULT NULL,
  `extra_over_time` varchar(255) DEFAULT NULL,
  `total_salary` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `mothers_name` varchar(255) DEFAULT NULL,
  `spouses_name` varchar(255) DEFAULT NULL,
  `birth_date` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `nid_no` varchar(255) DEFAULT NULL,
  `birth_certificate_no` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `wieght` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `body_identify_mark` varchar(255) DEFAULT NULL,
  `active_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_main_info`
--

INSERT INTO `employee_main_info` (`serial_no`, `id_no`, `area_name`, `designation`, `joining_date`, `basic_salary`, `house_rent`, `medical_allowance`, `transport_allowance`, `insurance`, `commission`, `extra_over_time`, `total_salary`, `user_name`, `password`, `name`, `fathers_name`, `mothers_name`, `spouses_name`, `birth_date`, `gender`, `nid_no`, `birth_certificate_no`, `nationality`, `religion`, `photo`, `present_address`, `permanent_address`, `mobile_no`, `phone_no`, `email`, `account_name`, `bank_name`, `branch_name`, `account_no`, `height`, `wieght`, `blood_group`, `body_identify_mark`, `active_status`) VALUES
(1, 'EMP-000001', '', 'Salesman', '01-01-2019', '10000', '0', '0', '0', '0', '0', '0', '10000', '', '', 'Mr. Bikas Kanti Day', 'Mr. YY', '', '', '', 'Male', '2222536987412', '', '', '', 'images/19e8470725.jpg', 'Coxs Bazar', 'Coxs Bazar', '019255', '', '', '', '', '', '', '', '', '', '', 'Active'),
(2, 'EMP-000002', '', 'Salesman', '01-01-2019', '10000', '0', '0', '0', '0', '0', '0', '10000', '', '', 'Mr. Pervaj', 'Mr. YY', '', '', '', 'Male', '2222365897412', '', '', '', 'images/45ac5ec509.jpg', 'Coxs Bazar', 'Coxs Bazar', '0192556', '', '', '', '', '', '', '', '', '', '', 'Active'),
(4, 'EMP-000004', '', 'Salesman', '05-01-2020', '10000', '0', '0', '0', '0', '0', '0', '10000', '', '', 'Mr. Redwan', 'Mr. YY', '', '', '', 'Male', '2222569874123', '', '', '', 'images/d7dfa6fd67.jpg', 'Coxs Bazar', 'Coxs Bazar', '01925', '', '', '', '', '', '', '', '', '', '', 'Active'),
(5, 'EMP-000005', '', 'Salesman', '01-01-2019', '10000', '0', '0', '0', '0', '0', '0', '10000', '', '', 'Mr. Rubel', 'Mr. YY', '', '', '', 'Male', '2222365478913', '', '', '', 'images/ac888b484b.jpg', 'Coxs Bazar', 'Coxs Bazar', '0192556', '', '', '', '', '', '', '', '', '', '', 'Active'),
(6, 'EMP-000006', '', 'Own Shop Salesman', '05-01-2020', '10000', '0', '0', '0', '0', '0', '0', '10000', '', '', 'Mr. Iqbal Hossain', 'Mr. YY', '', '', '', 'Male', '2222368974513', '', '', '', 'images/b08fcf4b87.jpg', 'Coxs Bazar', 'Coxs Bazar', '019255', '', '', '', '', '', '', '', '', '', '', 'Active'),
(7, 'EMP-000007', '', 'Own Shop Salesman', '01-01-2019', '10000', '0', '0', '0', '0', '0', '0', '10000', '', '', 'Mr. Tohid', 'Mr. YY', '', '', '', 'Male', '2222568931456', '', '', '', 'images/acb0632630.jpg', 'Coxs Bazar', 'Coxs Bazar', '019255', '', '', '', '', '', '', '', '', '', '', 'Active'),
(8, 'EMP-000008', '', 'Delivery Man', '01-01-2019', '8000', '0', '0', '0', '0', '0', '0', '8000', '', '', 'Mr. Nurul Alam', 'Mr. YY', '', '', '', 'Male', '2222365897418', '', '', '', 'images/6be273ed04.jpg', 'Coxs Bazar', 'Coxs Bazar', '01925', '', '', '', '', '', '', '', '', '', '', 'Active'),
(9, 'EMP-000009', '', 'Delivery Man', '01-01-2019', '8000', '0', '0', '0', '0', '0', '0', '8000', '', '', 'Mr. YY', 'Mr. XX', '', '', '', 'Male', '2222365478925', '', '', '', 'images/769f033f63.jpg', 'Coxs Bazar', 'Coxs Bazar', '0192552558', '', '', '', '', '', '', '', '', '', '', 'Active'),
(10, 'EMP-000010', '', 'Delivery Man', '01-01-2020', '5000', '0', '0', '0', '0', '0', '0', '5000', '', '', 'Mr. Redwan', 'Mr. YY', '', '', '', 'Male', '2222563148963', '', '', '', 'images/7076820158.jpg', 'Coxs Bazar', 'Coxs Bazar', '01925565756', '', '', '', '', '', '', '', '', '', '', 'Active'),
(11, 'EMP-000011', '', 'Delivery Man', '01-01-2020', '5000', '0', '0', '0', '0', '0', '0', '5000', '', '', 'Mr. Mizanur Rohman', 'Mr. YY', '', '', '', 'Male', '222256984136', '', '', '', 'images/da5ab31e93.jpg', 'Cox\'s Bazar', 'Cox\'s Bazar', '01925565756', '', '', '', '', '', '', '', '', '', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employee_payments`
--

CREATE TABLE `employee_payments` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `total_salary` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `attendance` varchar(255) DEFAULT NULL,
  `pay_type` varchar(255) DEFAULT NULL,
  `advance_amount` varchar(255) DEFAULT NULL,
  `salary_paid` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL,
  `previous_pay_serial_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_payments`
--

INSERT INTO `employee_payments` (`serial_no`, `id_no`, `name`, `designation`, `total_salary`, `month`, `attendance`, `pay_type`, `advance_amount`, `salary_paid`, `description`, `date`, `zone_serial_no`, `zone_name`, `previous_pay_serial_no`) VALUES
(9, 'EMP-000001', 'Mr. Bikas Kanti Day', 'Salesman', '10000', '01-2020', '0', 'Full Salary', '', '10000', '', '30-01-2020', '1', 'Cox\'s Bazar', NULL),
(10, 'EMP-000001', 'Mr. Bikas Kanti Day', 'Salesman', '10000', '02-2020', '0', 'Salary Advance', '5000', '5000', '', '30-01-2020', '1', 'Cox\'s Bazar', NULL),
(11, 'EMP-000001', 'Mr. Bikas Kanti Day', 'Salesman', '5000', '02-2020', '0', 'Salary Advance', '8000', '5000', '', '30-01-2020', '1', 'Cox\'s Bazar', NULL),
(14, 'EMP-000001', 'Mr. Bikas Kanti Day', 'Salesman', '10000', '03-2020', '0', 'Salary Advance', '11000', '10000', '', '30-01-2020', '1', 'Cox\'s Bazar', NULL),
(15, 'EMP-000001', 'Mr. Bikas Kanti Day', 'Salesman', '10000', '04-2020', '0', 'Salary Advance', '1000', '1000', '', '30-01-2020', '1', 'Cox\'s Bazar', '14');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `serial_no` int(11) NOT NULL,
  `expense_type` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `invoice_docs_no` varchar(255) DEFAULT NULL,
  `invoice_docs_img` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `expense_date` varchar(255) NOT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expense_head`
--

CREATE TABLE `expense_head` (
  `serial_no` int(11) NOT NULL,
  `head_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expense_head`
--

INSERT INTO `expense_head` (`serial_no`, `head_name`) VALUES
(2, 'Electricity Bill'),
(3, 'Office Rent'),
(4, 'Ware House Rent'),
(5, 'Income Tax'),
(6, 'VAT'),
(7, 'Vehicle Maintenance'),
(8, 'Family Expenses');

-- --------------------------------------------------------

--
-- Table structure for table `id_no_generator`
--

CREATE TABLE `id_no_generator` (
  `serial_no` int(11) NOT NULL,
  `id` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `id_no_generator`
--

INSERT INTO `id_no_generator` (`serial_no`, `id`, `id_type`) VALUES
(1, 'EMP-000001', 'employee'),
(2, 'EMP-000002', 'employee'),
(3, 'EMP-000003', 'employee'),
(4, 'EMP-000004', 'employee'),
(5, 'EMP-000005', 'employee'),
(6, 'EMP-000006', 'employee'),
(7, 'EMP-000007', 'employee'),
(8, 'EMP-000008', 'employee'),
(9, 'EMP-000009', 'employee'),
(10, 'PR-000001', 'product'),
(11, 'PR-000002', 'product'),
(12, 'PR-000003', 'product'),
(13, 'PR-000004', 'product'),
(14, 'PR-000005', 'product'),
(15, 'PR-000006', 'product'),
(16, 'PR-000007', 'product'),
(17, 'PR-000008', 'product'),
(18, 'PR-000009', 'product'),
(19, 'PR-000010', 'product'),
(20, 'PR-000011', 'product'),
(21, 'PR-000012', 'product'),
(22, 'PR-000013', 'product'),
(23, 'PR-000014', 'product'),
(24, 'PR-000015', 'product'),
(25, 'PR-000016', 'product'),
(26, 'PR-000017', 'product'),
(27, 'PR-000018', 'product'),
(28, 'PR-000019', 'product'),
(29, 'PR-000020', 'product'),
(30, 'PR-000021', 'product'),
(31, 'PR-000022', 'product'),
(32, 'PR-000023', 'product'),
(33, 'PR-000024', 'product'),
(34, 'PR-000025', 'product'),
(35, 'PR-000026', 'product'),
(36, 'PR-000027', 'product'),
(37, 'PR-000028', 'product'),
(38, 'PR-000029', 'product'),
(39, 'PR-000030', 'product'),
(40, 'PR-000031', 'product'),
(41, 'PR-000032', 'product'),
(42, 'PR-000033', 'product'),
(43, 'PR-000034', 'product'),
(44, 'PR-000035', 'product'),
(45, 'PR-000036', 'product'),
(46, 'PR-000037', 'product'),
(47, 'PR-000038', 'product'),
(48, 'PR-000039', 'product'),
(49, 'PR-000040', 'product'),
(50, 'PR-000041', 'product'),
(51, 'PR-000042', 'product'),
(52, 'PR-000043', 'product'),
(53, 'PR-000044', 'product'),
(54, 'PR-000045', 'product'),
(55, 'CUST-000001', 'client'),
(56, 'PR-000046', 'product'),
(57, 'PR-000047', 'product'),
(58, 'PR-000048', 'product'),
(59, 'PR-000049', 'product'),
(60, 'PR-000050', 'product'),
(61, 'PR-000051', 'product'),
(62, 'PR-000052', 'product'),
(63, 'PR-000053', 'product'),
(64, 'PR-000054', 'product'),
(65, 'PR-000055', 'product'),
(66, 'PR-000056', 'product'),
(67, 'PR-000057', 'product'),
(68, 'PR-000058', 'product'),
(69, 'PR-000059', 'product'),
(70, 'PR-000060', 'product'),
(71, 'PR-000061', 'product'),
(72, 'PR-000062', 'product'),
(73, 'PR-000063', 'product'),
(74, 'PR-000064', 'product'),
(75, 'PR-000065', 'product'),
(76, 'PR-000066', 'product'),
(77, 'PR-000067', 'product'),
(78, 'PR-000068', 'product'),
(79, 'PR-000069', 'product'),
(80, 'PR-000070', 'product'),
(81, 'PR-000071', 'product'),
(82, 'PR-000072', 'product'),
(83, 'PR-000073', 'product'),
(84, 'PR-000074', 'product'),
(85, 'PR-000075', 'product'),
(86, 'PR-000076', 'product'),
(87, 'PR-000077', 'product'),
(88, 'PR-000078', 'product'),
(89, 'PR-000079', 'product'),
(90, 'PR-000080', 'product'),
(91, 'CUST-000002', 'client'),
(92, 'CUST-000002', 'client'),
(93, 'CUST-000002', 'client'),
(94, 'CUST-000002', 'client'),
(95, 'CUST-000003', 'client'),
(96, 'CUST-000003', 'client'),
(97, 'CUST-000004', 'client'),
(98, 'EMP-000010', 'employee'),
(99, 'EMP-000011', 'employee'),
(100, 'PR-000081', 'product'),
(101, 'PR-000082', 'product'),
(102, 'PR-000083', 'product'),
(103, 'CUST-000005', 'client'),
(104, 'PR-000084', 'product'),
(105, 'PR-000085', 'product'),
(106, 'PR-000086', 'product'),
(107, 'PR-000087', 'product'),
(108, 'PR-000088', 'product'),
(109, 'PR-000089', 'product'),
(110, 'PR-000090', 'product'),
(111, 'PR-000091', 'product'),
(112, 'PR-000092', 'product'),
(113, 'PR-000093', 'product'),
(114, 'PR-000094', 'product'),
(115, 'PR-000095', 'product'),
(116, 'CUST-000006', 'client'),
(117, 'CUST-000006', 'client'),
(118, 'CUST-000006', 'client'),
(119, 'CUST-000006', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `serial_no` int(11) NOT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `invoice_option` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `designation` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `total_amount` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pay` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `invoice_date` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`serial_no`, `invoice_id`, `invoice_option`, `name`, `designation`, `phone_no`, `total_amount`, `pay`, `invoice_date`, `zone_serial_no`, `zone_name`) VALUES
(2, NULL, 'Buy Invoice', 'Kamal Mistri', '', '', '5000', '5000', '07-01-2020', '1', 'Cox\'s Bazar');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_expense`
--

CREATE TABLE `invoice_expense` (
  `serial_no` int(11) NOT NULL,
  `invoice_serial_no` int(11) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `purpose` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_expense`
--

INSERT INTO `invoice_expense` (`serial_no`, `invoice_serial_no`, `description`, `purpose`, `amount`) VALUES
(2, 2, 'Painter', 'Shop Repair', '5000');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_setting`
--

CREATE TABLE `invoice_setting` (
  `serial_no` int(11) NOT NULL,
  `discount_on_mrp` varchar(255) DEFAULT NULL,
  `discount_on_tp` varchar(255) DEFAULT NULL,
  `special_discount` varchar(255) DEFAULT NULL,
  `vat` varchar(255) DEFAULT NULL,
  `show_dues` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `serial_no` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`serial_no`, `name`, `username`, `password`, `email`, `role`, `user_id`, `user_type`) VALUES
(9, 'admin', 'admin', '123456', 'admin@gmail.com', 'admin', 'admin', 'admin'),
(77, 'Mr. Redwan', '', '', '', 'Delivery Man', '10', 'employee'),
(78, 'Mr. Mizanur Rohman', '', '', '', 'Delivery Man', '11', 'employee'),
(79, 'sohag', 'admin', 'admin', '', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `market_products_return`
--

CREATE TABLE `market_products_return` (
  `serial_no` int(11) NOT NULL,
  `employee_id_delivery` varchar(255) NOT NULL,
  `employee_name_delivery` varchar(255) NOT NULL,
  `area_employee_delivery` varchar(255) NOT NULL,
  `cust_id` varchar(255) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `shop_phn` varchar(255) DEFAULT NULL,
  `products_id_no` varchar(255) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `marketing_sell_price` varchar(255) NOT NULL,
  `return_quantity` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `return_reason` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) NOT NULL,
  `unload_status` varchar(255) NOT NULL DEFAULT '0',
  `unload_date` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `money_receipt_info_tbl`
--

CREATE TABLE `money_receipt_info_tbl` (
  `serial_no` int(11) NOT NULL,
  `receipt_tbl_serial_no` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `payment_date` varchar(255) DEFAULT NULL,
  `payment_amt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `money_receipt_main_tbl`
--

CREATE TABLE `money_receipt_main_tbl` (
  `serial_no` int(11) NOT NULL,
  `receipt_no` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `printing_date` varchar(255) DEFAULT NULL,
  `printing_time` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `in_word` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offered_products`
--

CREATE TABLE `offered_products` (
  `serial_no` int(11) NOT NULL,
  `products_id` varchar(255) NOT NULL,
  `available_qty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offered_products`
--

INSERT INTO `offered_products` (`serial_no`, `products_id`, `available_qty`) VALUES
(1, 'PR-000001', '5');

-- --------------------------------------------------------

--
-- Table structure for table `offered_products_stock`
--

CREATE TABLE `offered_products_stock` (
  `serial_no` int(11) NOT NULL,
  `offer_product_tbl_serial` varchar(255) DEFAULT NULL,
  `products_id` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `stock_date` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offered_products_stock`
--

INSERT INTO `offered_products_stock` (`serial_no`, `offer_product_tbl_serial`, `products_id`, `quantity`, `stock_date`, `ware_house_serial_no`, `ware_house_name`) VALUES
(1, '1', 'PR-000001', '5', '01-01-2020', '1', 'Ware House  # 1');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `serial_no` int(11) NOT NULL,
  `products_id` varchar(255) DEFAULT NULL,
  `packet_qty` varchar(255) DEFAULT NULL,
  `product_qty` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`serial_no`, `products_id`, `packet_qty`, `product_qty`, `from_date`, `to_date`, `status`) VALUES
(13, 'PR-000018', '1', '1', '01-01-2020', '31-01-2020', '1'),
(16, 'PR-000021', '1', '2', '01-01-2020', '31-01-2020', '1'),
(17, 'PR-000001', '1', '5', '15-01-2020', '31-01-2020', '1'),
(18, 'PR-000010', '1', '5', '15-01-2020', '31-01-2020', '1'),
(20, 'PR-000020', '1', '1', '01-01-2020', '31-01-2020', '1'),
(21, 'PR-000005', '1', '2', '01-01-2020', '31-01-2020', '1'),
(22, 'PR-000004', '1', '3', '10-01-2020', '31-01-2020', '1'),
(23, 'PR-000006', '2', '3', '01-01-2020', '31-01-2020', '1'),
(24, 'PR-000007', '1', '5', '01-01-2020', '31-01-2020', '1'),
(25, 'PR-000008', '1', '3', '01-01-2020', '31-01-2020', '1'),
(26, 'PR-000009', '1', '3', '01-01-2020', '31-01-2020', '1'),
(27, 'PR-000012', '1', '5', '01-01-2020', '31-01-2020', '1'),
(28, 'PR-000013', '1', '4', '01-01-2020', '31-01-2020', '1'),
(29, 'PR-000027', '1', '1', '01-01-2020', '31-01-2020', '1'),
(30, 'PR-000090', '1', '3', '20-01-2020', '20-01-2020', '3');

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery`
--

CREATE TABLE `order_delivery` (
  `serial_no` bigint(20) NOT NULL,
  `order_employee_id` varchar(255) DEFAULT NULL,
  `order_employee_name` varchar(255) DEFAULT NULL,
  `delivery_employee_id` varchar(255) DEFAULT NULL,
  `delivery_employee_name` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `truck_load_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `cust_id` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `payable_amt` varchar(255) DEFAULT NULL,
  `pay` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `own_shop` varchar(255) NOT NULL DEFAULT '0',
  `delivery_status` varchar(255) DEFAULT '1',
  `cancel_status` varchar(255) DEFAULT '0',
  `previous_due` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_delivery`
--

INSERT INTO `order_delivery` (`serial_no`, `order_employee_id`, `order_employee_name`, `delivery_employee_id`, `delivery_employee_name`, `order_no`, `vehicle_reg_no`, `vehicle_name`, `truck_load_serial_no`, `ware_house_serial_no`, `ware_house_name`, `zone_serial_no`, `zone_name`, `area`, `cust_id`, `customer_name`, `shop_name`, `address`, `mobile_no`, `payable_amt`, `pay`, `due`, `order_date`, `delivery_date`, `own_shop`, `delivery_status`, `cancel_status`, `previous_due`) VALUES
(21, 'EMP-000001', 'Mr. Bikas Kanti Day', 'EMP-000004', 'Mr. Redwan', 'INV-202001260001', '1554545454', 'van #1', '24', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000004', 'Cash Customer', 'Cash Customer', 'co', '1254', '1451', '1451', '0', NULL, '26-01-2020', '0', '1', '0', '0'),
(22, 'EMP-000001', 'Mr. Bikas Kanti Day', 'EMP-000004', 'Mr. Redwan', 'INV-202001260002', '1554545454', 'van #1', '24', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000002', 'Abul Kasham', 'Vhi Vhi Store', 'IBP Road, Coxs Bazar', '0192556', '465', '400', '65', NULL, '26-01-2020', '0', '1', '0', '0'),
(23, 'EMP-000001', 'Mr. Bikas Kanti Day', 'EMP-000004', 'Mr. Redwan', 'INV-202001270001', '1554545454', 'van #1', '24', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000004', 'Cash Customer', 'Cash Customer', 'co', '1254', '18', '', '18', NULL, '27-01-2020', '0', '1', '0', '0'),
(24, 'EMP-000001', 'Mr. Bikas Kanti Day', 'EMP-000004', 'Mr. Redwan', 'INV-202001270002', '1554545454', 'van #1', '25', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000004', 'Cash Customer', 'Cash Customer', 'co', '1254', '1213', '0', '1213', NULL, '27-01-2020', '0', '1', '0', '0'),
(25, 'EMP-000001', 'Mr. Bikas Kanti Day', 'EMP-000004', 'Mr. Redwan', 'INV-202001270003', '1554545454', 'van #1', '26', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000004', 'Cash Customer', 'Cash Customer', 'co', '1254', '181', '0', '181', NULL, '27-01-2020', '0', '1', '0', '0'),
(26, 'EMP-000001', 'Mr. Bikas Kanti Day', 'EMP-000004', 'Mr. Redwan', 'INV-202001270004', 'afa', 'van #2', '27', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000004', 'Cash Customer', 'Cash Customer', 'co', '1254', '2328', '0', '2328', NULL, '27-01-2020', '0', '1', '0', '0'),
(27, 'EMP-000002', 'Mr. Pervaj', 'EMP-000008', 'Mr. Nurul Alam', 'INV-202001280001', 'afa', 'van #2', '28', '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000004', 'Cash Customer', 'Cash Customer', 'co', '1254', '664', '0', '664', NULL, '28-01-2020', '0', '1', '0', '0'),
(28, NULL, NULL, NULL, NULL, 'INV-202001290001', NULL, NULL, NULL, '1', 'Ware House  # 1', '1', 'Cox\'s Bazar', 'Pourashava', 'CUST-000006', 'sohag', 'sohag shop', 'abulkhairsoasldfjaklsfjaskjfkldas', '01753474401', '100', '5', '95', NULL, '29-01-2020', '0', '1', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_expense`
--

CREATE TABLE `order_delivery_expense` (
  `id` bigint(20) NOT NULL,
  `delivery_tbl_serial_no` varchar(255) DEFAULT NULL,
  `products_id_no` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `sell_price_pack` varchar(255) DEFAULT NULL,
  `sell_price_pcs` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `purchase_price` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `truck_load_serial_no` varchar(255) DEFAULT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `order_employee_id` varchar(255) DEFAULT NULL,
  `delivery_employee_id` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(255) DEFAULT '1',
  `cancel_status` varchar(255) NOT NULL DEFAULT '0',
  `offer` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_delivery_expense`
--

INSERT INTO `order_delivery_expense` (`id`, `delivery_tbl_serial_no`, `products_id_no`, `products_name`, `sell_price_pack`, `sell_price_pcs`, `qty`, `total_price`, `purchase_price`, `ware_house_serial_no`, `truck_load_serial_no`, `zone_serial_no`, `vehicle_reg_no`, `order_employee_id`, `delivery_employee_id`, `delivery_date`, `delivery_status`, `cancel_status`, `offer`) VALUES
(8, '21', 'PR-000001', 'Royal Tiger 250 Ml', '434.48', '18.10', '30', '543.08', '618.75', '1', '24', '1', '1554545454', 'EMP-000001', 'EMP-000004', '26-01-2020', '1', '0', '1'),
(9, '21', 'PR-000002', 'UHT Milk 500ml', '660', '41.25', '22', '907.5', '863.5', '1', '24', '1', '1554545454', 'EMP-000001', 'EMP-000004', '26-01-2020', '1', '0', '0'),
(10, '22', 'PR-000001', 'Royal Tiger 250 Ml', '434.48', '18.10', '12', '217.20000000000002', '247.5', '1', '24', '1', '1554545454', 'EMP-000001', 'EMP-000004', '26-01-2020', '1', '0', '1'),
(11, '22', 'PR-000002', 'UHT Milk 500ml', '660', '41.25', '6', '247.5', '235.5', '1', '24', '1', '1554545454', 'EMP-000001', 'EMP-000004', '26-01-2020', '1', '0', '0'),
(12, '23', 'PR-000001', 'Royal Tiger 250 Ml', '434.48', '18.10', '1', '18.1', '20.625', '1', '24', '1', '1554545454', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '1'),
(13, '24', 'PR-000001', 'Royal Tiger 250 Ml', '434.48', '18.10', '26', '470.68', '536.25', '1', '25', '1', '1554545454', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '1'),
(14, '24', 'PR-000002', 'UHT Milk 500ml', '660', '41.25', '18', '742.5', '706.5', '1', '25', '1', '1554545454', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '0'),
(15, '25', 'PR-000001', 'Royal Tiger 250 Ml', '434.48', '18.10', '10', '181', '206.25', '1', '26', '1', '1554545454', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '1'),
(16, '26', 'PR-000001', 'Royal Tiger 250 Ml', '434.48', '18.10', '27', '488.78000000000003', '556.875', '1', '27', '1', 'afa', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '1'),
(17, '26', 'PR-000002', 'UHT Milk 500ml', '660', '41.25', '17', '701.25', '667.25', '1', '27', '1', 'afa', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '0'),
(18, '26', 'PR-000003', '250ml Fizzup', '318', '13.25', '51', '675.75', '637.5', '1', '27', '1', 'afa', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '0'),
(19, '26', 'PR-000006', '2 lit Fizzup', '346.4', '57.73', '8', '461.85999999999996', '544', '1', '27', '1', 'afa', 'EMP-000001', 'EMP-000004', '27-01-2020', '1', '0', '1'),
(20, '27', 'PR-000006', '2 lit Fizzup', '346.4', '57.73', '6', '346.4', '408', '1', '28', '1', 'afa', 'EMP-000002', 'EMP-000008', '28-01-2020', '1', '0', '1'),
(21, '27', 'PR-000003', '250ml Fizzup', '318', '13.25', '24', '318', '300', '1', '28', '1', 'afa', 'EMP-000002', 'EMP-000008', '28-01-2020', '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_summery`
--

CREATE TABLE `order_summery` (
  `serial_no` int(11) NOT NULL,
  `summery_id` varchar(255) DEFAULT NULL,
  `deliv_emp_id` varchar(255) DEFAULT NULL,
  `deliv_emp_name` varchar(255) DEFAULT NULL,
  `deliv_emp_phone` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `printing_date` varchar(255) DEFAULT NULL,
  `printing_time` varchar(255) DEFAULT NULL,
  `total_payable_amt` varchar(255) DEFAULT NULL,
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_summery_product_info`
--

CREATE TABLE `order_summery_product_info` (
  `serial_no` int(11) NOT NULL,
  `summery_serial_no` varchar(255) DEFAULT NULL,
  `summery_id` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_summery_shop_info`
--

CREATE TABLE `order_summery_shop_info` (
  `serial_no` int(11) NOT NULL,
  `summery_serial_no` varchar(255) DEFAULT NULL,
  `summery_id` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `payable_amt` varchar(255) DEFAULT NULL,
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_client`
--

CREATE TABLE `own_shop_client` (
  `serial_no` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `own_shop_client`
--

INSERT INTO `own_shop_client` (`serial_no`, `client_name`, `address`, `mobile_no`, `email`) VALUES
(1, 'akber', 'larpara', '1254', ''),
(2, 'Save Way', 'Pourashava, Cox\'s Bazar', '2558', '');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_employee`
--

CREATE TABLE `own_shop_employee` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `active_status` varchar(255) DEFAULT NULL,
  `active_date` varchar(255) DEFAULT NULL,
  `inactive_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `own_shop_employee`
--

INSERT INTO `own_shop_employee` (`serial_no`, `id_no`, `name`, `mobile_no`, `email`, `present_address`, `active_status`, `active_date`, `inactive_date`) VALUES
(1, 'EMP-000007', 'Mr. Tohid', '019255', '', 'Coxs Bazar', 'Active', '05-01-2020', '05-01-2020'),
(2, 'EMP-000006', 'Mr. Iqbal Hossain', '019255', '', 'Coxs Bazar', 'Active', '05-01-2020', '05-01-2020');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_products_stock`
--

CREATE TABLE `own_shop_products_stock` (
  `serial_no` int(11) NOT NULL,
  `products_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity_pcs` varchar(255) DEFAULT NULL,
  `sell_price` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `own_shop_products_stock`
--

INSERT INTO `own_shop_products_stock` (`serial_no`, `products_id`, `product_name`, `category`, `quantity_pcs`, `sell_price`) VALUES
(3, 'PR-000001', 'Royal Tiger 250 Ml', 'Soft Drinks', '100', '18.1'),
(4, 'PR-000002', 'UHT Milk 500ml', 'UHT Milk', '80', '41.25');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_sell`
--

CREATE TABLE `own_shop_sell` (
  `serial_no` bigint(20) NOT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `net_payable_amt` varchar(255) DEFAULT NULL,
  `pay` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `sell_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `own_shop_sell`
--

INSERT INTO `own_shop_sell` (`serial_no`, `order_no`, `employee_id`, `employee_name`, `customer_id`, `customer_name`, `mobile_no`, `net_payable_amt`, `pay`, `due`, `sell_date`) VALUES
(1, 'ORDER-7149732', 'EMP-000006', 'Mr. Iqbal Hossain', '-1', '', '', '384', '384', '0', '07-01-2020'),
(2, 'ORDER-5317711', 'EMP-000006', 'Mr. Iqbal Hossain', '-1', '', '', '384', '384', '0', '07-01-2020'),
(3, 'ORDER-7893819', 'EMP-000006', 'Mr. Iqbal Hossain', '1', 'akber', '1254', '2625', '2000', '625', '07-01-2020');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_sell_product`
--

CREATE TABLE `own_shop_sell_product` (
  `serial_no` int(11) NOT NULL,
  `sell_tbl_id` varchar(255) DEFAULT NULL,
  `products_id_no` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `sell_price` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `sell_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `own_shop_sell_product`
--

INSERT INTO `own_shop_sell_product` (`serial_no`, `sell_tbl_id`, `products_id_no`, `products_name`, `sell_price`, `qty`, `total_price`, `sell_date`) VALUES
(1, '1', 'PR-000005', '1 lit Fizzup', '32', '12', '384', '07-01-2020'),
(2, '2', 'PR-000005', '1 lit Fizzup', '32', '12', '384', '07-01-2020'),
(3, '3', 'PR-000001', 'Royal Tiger 250 Ml', '525', '5', '2625', '07-01-2020');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_stock_history`
--

CREATE TABLE `own_shop_stock_history` (
  `serial_no` int(11) NOT NULL,
  `own_shop_products_serial_no` varchar(255) DEFAULT NULL,
  `products_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity_pcs` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `stock_date` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `own_shop_stock_history`
--

INSERT INTO `own_shop_stock_history` (`serial_no`, `own_shop_products_serial_no`, `products_id`, `product_name`, `quantity_pcs`, `price`, `stock_date`, `ware_house_serial_no`, `ware_house_name`) VALUES
(8, NULL, 'PR-000001', 'Royal Tiger 250 Ml', '50', '1031.25', '28-01-2020', '1', 'Ware House  # 1'),
(9, NULL, 'PR-000002', 'UHT Milk 500ml', '40', '1570', '28-01-2020', '1', 'Ware House  # 1'),
(10, NULL, 'PR-000001', 'Royal Tiger 250 Ml', '50', '1031.25', '28-01-2020', '1', 'Ware House  # 1'),
(11, NULL, 'PR-000002', 'UHT Milk 500ml', '40', '1570', '28-01-2020', '1', 'Ware House  # 1');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `serial_no` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`serial_no`, `permission_name`) VALUES
(1, 'important_setting'),
(2, 'company_profile_setting'),
(3, 'edit_info_button'),
(4, 'update_logo_and_favicon_button'),
(5, 'sales_zone_setting'),
(6, 'add_new_zone_button'),
(7, 'zone_edit_button'),
(8, 'zone_delete_button'),
(9, 'sales_area_setting'),
(10, 'add_new_area_button'),
(11, 'area_edit_button'),
(12, 'area_delete_button'),
(13, 'product_category_setting'),
(14, 'add_new_category_button'),
(15, 'category_edit_button'),
(16, 'category_delete_button'),
(17, 'customer_category_setting'),
(18, 'add_new_customer_category_button'),
(19, 'customer_category_edit_button'),
(20, 'customer_category_delete_button'),
(21, 'add_system_user'),
(22, 'add_new_user_button'),
(23, 'user_edit_button'),
(24, 'user_delete_button'),
(25, 'company'),
(26, 'company_information'),
(27, 'add_new_company_button'),
(28, 'company_view_button'),
(29, 'company_edit_button'),
(30, 'company_delete_button'),
(31, 'employee'),
(32, 'add_employee'),
(33, 'add_employee_button'),
(34, 'employee_list'),
(35, 'employee_view_button'),
(36, 'employee_edit_button'),
(37, 'employee_delete_button'),
(38, 'employeee_role_button'),
(39, 'sales_man'),
(40, 'add_new_sales_man_button'),
(41, 'sales_man_edit_button'),
(42, 'sales_man_delete_button'),
(43, 'delivery_man'),
(44, 'add_new_delivery_man_button'),
(45, 'delivery_man_edit_button'),
(46, 'delivery_man_delete_button'),
(47, 'own_shop_employee'),
(48, 'add_own_shop_employee_button'),
(49, 'own_shop_employee_edit_button'),
(50, 'own_shop_employee_delete_button'),
(51, 'attendance_info'),
(52, 'customer'),
(53, 'customer_info'),
(54, 'add_customer_button'),
(55, 'customer_view_button'),
(56, 'customer_edit_button'),
(57, 'customer_delete_button'),
(58, 'own_shop'),
(59, 'sale_product'),
(60, 'sale_product_save_button'),
(61, 'sales_list'),
(62, 'sale_product_view_button'),
(63, 'sale_product_edit_button'),
(64, 'sale_product_delete_button'),
(65, 'transport'),
(66, 'transport_info'),
(67, 'add_new_vehicle_button'),
(68, 'transport_edit_button'),
(69, 'transport_delete_button'),
(70, 'truck_load_for_delivery'),
(71, 'truck_load_save_button'),
(72, 'unload_truck_after_delivery'),
(73, 'unload_save_button'),
(74, 'take_back_market_product_return'),
(75, 'return_product_save_button'),
(76, 'product'),
(77, 'add_product'),
(78, 'product_edit_button'),
(79, 'product_stock_button'),
(80, 'product_delete_button'),
(81, 'print_barcode_button'),
(82, 'product_view_button'),
(83, 'company_wise_product_list'),
(84, 'company_product_return'),
(85, 'return_product_button'),
(86, 'return_edit_button'),
(87, 'return_delete_button'),
(88, 'total_stock_product'),
(89, 'product_wise_stock_report'),
(90, 'order_and_delivery'),
(91, 'new_order'),
(92, 'delivery_pending'),
(93, 'delivery_pending_view_button'),
(94, 'delivery_pending_edit_button'),
(95, 'delivery_pending_invoice_button'),
(96, 'delivery_pending_cancel_order_button'),
(97, 'paid_and_delivered'),
(98, 'paid_and_delivered_view_button'),
(99, 'paid_and_delivered_invoice_button'),
(100, 'unpaid_but_delivered'),
(101, 'unpaid_but_delivered_view_button'),
(102, ' unpaid_but_delivered_pay_button'),
(103, 'unpaid_but_delivered_cancel_order_button'),
(104, 'cancelled_order'),
(105, 'view_cancelled_order_info_button'),
(106, 'return_sold_product_from_market'),
(107, 'return_product_button'),
(108, 'return_product_edit_button'),
(109, 'return_product_view_button'),
(110, 'return_product_delete_button'),
(111, 'account'),
(112, 'add_account'),
(113, 'add_account_button'),
(114, 'account_edit_button'),
(115, 'account_delete_button'),
(116, 'add_bank_deposite'),
(117, 'add_bank_deposite_button'),
(118, 'bank_deposite_edit'),
(119, 'bank_deposite_delete'),
(120, 'add_bank_withdraw'),
(121, 'add_bank_withdraw_button'),
(122, 'bank_withdraw_view_button'),
(123, 'bank_withdraw_edit_button'),
(124, 'bank_withdraw_delete_button'),
(125, 'add_bank_loan'),
(126, 'add_bank_loan_button'),
(127, 'bank_loan_view_button'),
(128, 'bank_loan_edit_button'),
(129, 'bank_loan_delete_button'),
(130, 'bank_loan_pay_button'),
(131, 'add_invoice'),
(132, 'view_invoice_list'),
(133, 'invoice_view_button'),
(134, 'invoice_edit_button'),
(135, 'invoice_delete_button'),
(136, 'receive'),
(137, 'add_receive_button'),
(138, 'receive_edit_button'),
(139, 'receive_delete_button'),
(140, 'company_comission'),
(141, 'add_company_comission_button'),
(142, 'company_comission_edit_button'),
(143, 'company_comission_delete_button'),
(144, 'employee_comission'),
(145, 'add_employee_comission_button'),
(146, 'employee_comission_edit_button'),
(147, 'employee_comission_delete_button'),
(148, 'expense'),
(149, 'add_expense_button'),
(150, 'expense_view_button'),
(151, 'expense_edit_button'),
(152, 'expense_delete_button'),
(153, 'employee_payments'),
(154, 'add_payment_button'),
(155, 'payment_edit_button'),
(156, 'payment_delete_button'),
(157, 'cash_balance'),
(158, 'reports'),
(159, 'account_report'),
(160, 'ware_house_wise_report'),
(161, 'area_wise_report'),
(162, 'employee_report'),
(163, 'own_shop_report'),
(164, 'customer_report'),
(165, 'employee_report'),
(166, 'add_role'),
(167, 'add_role_button'),
(168, 'role_edit_button'),
(169, 'role_delete_button'),
(170, 'add_expense_head'),
(171, 'add_expense_head_button'),
(172, 'expense_head_edit_button'),
(173, 'expense_head_delete_button'),
(174, 'own_shop_customer_list'),
(175, 'add_own_shop_customer_button'),
(176, 'own_shop_customer_edit_button'),
(177, 'own_shop_customer_delete_button'),
(178, 'money_receipt'),
(179, 'money_receipt_list'),
(180, 'send_sms'),
(181, 'invoice_setting'),
(182, 'printed_summery_list'),
(183, 'ware_house'),
(184, 'ware_house_info'),
(185, 'add_new_ware_house'),
(186, 'ware_house_edit_button'),
(187, 'ware_house_delete_button'),
(188, 'attendance'),
(189, 'attendance_view_record_button'),
(190, 'offer_setup'),
(191, 'add_new_offer'),
(192, 'offer_edit_button'),
(193, 'offer_delete_button'),
(194, 'stock_list'),
(195, 'stock_list_edit_button'),
(196, 'add_offer_product'),
(197, 'add_offer_product_button'),
(198, 'offer_stock_this_product_button'),
(199, 'offer_product_delete_button'),
(200, 'order_load_truck_button'),
(201, 'order_unload_truck_button'),
(202, 'print_money_receipt'),
(203, 'money_receipt_view_record_button'),
(204, 'money_receipt_list'),
(205, 'money_receipt_view_button'),
(206, 'money_receipt_print_button'),
(207, 'own_shop'),
(208, 'stock_product_to_shop'),
(209, 'stock_product_to_shop_save_button'),
(210, 'shop_product'),
(211, 'sale_product'),
(212, 'sale_product_view_sale_button'),
(213, 'sale_product_save_button'),
(214, 'sale_list'),
(215, 'sale_product_button'),
(216, 'sale_product_view_button'),
(217, 'sale_product_edit_button'),
(218, 'sale_product_delete_button'),
(219, 'own_shop_customer_list'),
(220, 'own_shop_add_customer_button'),
(221, 'own_shop_customer_edit_button'),
(222, 'own_shop_customer_delete_button'),
(223, 'expense_head'),
(224, 'add_expense_head_button'),
(225, 'expense_head_edit_button'),
(226, 'expense_head_delete_button'),
(227, 'expense'),
(228, 'add_expense_button'),
(229, 'expense_view_button'),
(230, 'expense_edit_button'),
(231, 'expense_delete_button'),
(232, 'receive'),
(233, 'add_receive_button'),
(234, 'receive_edit_button'),
(235, 'receive_delete_button'),
(236, 'customer_report'),
(237, 'transport_report');

-- --------------------------------------------------------

--
-- Table structure for table `previous_offers`
--

CREATE TABLE `previous_offers` (
  `serial_no` int(11) NOT NULL,
  `products_id` varchar(255) DEFAULT NULL,
  `packet_qty` varchar(255) DEFAULT NULL,
  `product_qty` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `serial_no` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `products_id_no` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `company_price` varchar(255) DEFAULT NULL,
  `sell_price` varchar(255) DEFAULT NULL,
  `mrp_price` varchar(255) DEFAULT NULL,
  `pack_size` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `product_photo` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `stock_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`serial_no`, `company`, `products_id_no`, `products_name`, `category`, `company_price`, `sell_price`, `mrp_price`, `pack_size`, `quantity`, `product_photo`, `description`, `stock_date`) VALUES
(1, 'globe soft drinks', 'PR-000001', 'Royal Tiger 250 Ml', 'Soft Drinks', '495', '525', '25', '24', '1672', NULL, '', '05-01-2020'),
(2, 'pran dairy ltd', 'PR-000002', 'UHT Milk 500ml', 'UHT Milk', '628', '660', '45', '16', '70', NULL, '', '05-01-2020'),
(3, 'globe soft drinks', 'PR-000003', '250ml Fizzup', 'Soft Drinks', '300', '318', '16', '24', '136', NULL, '', '05-01-2020'),
(4, 'globe soft drinks', 'PR-000004', '500ml Fizzup', 'Soft Drinks', '509', '540', '30', '24', '0', NULL, '', '05-01-2020'),
(5, 'globe soft drinks', 'PR-000005', '1 lit Fizzup', 'Soft Drinks', '430', '456', '45', '12', '51', NULL, '', '05-01-2020'),
(6, 'globe soft drinks', 'PR-000006', '2 lit Fizzup', 'Soft Drinks', '408', '433', '80', '6', '0', NULL, '', '05-01-2020'),
(7, 'globe soft drinks', 'PR-000007', '250 mangoli', 'Soft Drinks', '447', '475', '24', '24', '29', NULL, '', '05-01-2020'),
(8, 'globe soft drinks', 'PR-000008', '500 mangoli', 'Soft Drinks', '847', '900', '45', '24', '0', NULL, '', '05-01-2020'),
(9, 'globe soft drinks', 'PR-000009', '1 lit mangoli', 'Soft Drinks', '772', '820', '80', '12', '0', NULL, '', '05-01-2020'),
(10, 'globe soft drinks', 'PR-000010', '250 Orange', 'Soft Drinks', '314', '333', '16', '24', '1164', NULL, '', '05-01-2020'),
(11, 'globe soft drinks', 'PR-000011', '500 Orange', 'Soft Drinks', '509', '540', '30', '24', '88', NULL, '', '05-01-2020'),
(12, 'globe soft drinks', 'PR-000012', '175 lychina', 'Soft Drinks', '237', '252', '12', '24', '45', NULL, '', '05-01-2020'),
(13, 'globe soft drinks', 'PR-000013', '175 Orangee', 'Soft Drinks', '296', '314', '15', '24', '117', NULL, '', '05-01-2020'),
(14, 'globe soft drinks', 'PR-000014', '500ml Alma', 'Soft Drinks', '170', '182', '15', '24', '0', NULL, '', '05-01-2020'),
(15, 'janata food', 'PR-000015', 'Jal mori', 'Others', '65', '72', '8', '60', '2', NULL, '', '05-01-2020'),
(16, 'janata food', 'PR-000016', 'Misti mori', 'Mori', '52', '55', '6', '80', '0', NULL, '', '05-01-2020'),
(17, 'janata food', 'PR-000017', '200 mori', 'Mori', '75', '90', '20', '40', '0', NULL, '', '05-01-2020'),
(18, 'pran dairy ltd', 'PR-000018', '1000 UHT Milk', 'UHT Milk', '78', '978', '80', '12', '1992', NULL, '', '05-01-2020'),
(20, 'pran dairy ltd', 'PR-000020', '500ml UHT', 'UHT Milk', '628', '660', '45', '16', '115', NULL, '', '05-01-2020'),
(21, 'pran dairy ltd', 'PR-000021', '200ml UHT', 'UHT Milk', '558.9', '588', '22', '30', '2073', NULL, '', '05-01-2020'),
(22, 'pran dairy ltd', 'PR-000022', '100 ml UHT', 'UHT Milk', '360', '378', '12', '36', '0', NULL, '', '05-01-2020'),
(23, 'pran dairy ltd', 'PR-000023', '200ml Mango milk', 'UHT Milk', '558.9', '588', '22', '30', '0', NULL, '', '05-01-2020'),
(24, 'pran dairy ltd', 'PR-000024', '200ml Mango milk', 'UHT Milk', '558.9', '588', '22', '30', '0', NULL, '', '05-01-2020'),
(25, 'pran dairy ltd', 'PR-000025', '200ml Chocolate Milk', 'UHT Milk', '558.9', '588', '22', '30', '29', NULL, '', '05-01-2020'),
(26, 'pran dairy ltd', 'PR-000026', '250 ml Lassi', 'UHT Milk', '485', '516', '25', '24', '15', NULL, '', '05-01-2020'),
(27, 'pran dairy ltd', 'PR-000027', '175ml Lassi', 'UHT Milk', '390.6', '420', '20', '24', '58', NULL, '', '05-01-2020'),
(28, 'pran dairy ltd', 'PR-000028', '125ml juniour Juice', 'UHT Milk', '804', '844', '12', '80', '9', NULL, '', '05-01-2020'),
(39, 'pran dairy ltd', 'PR-000039', '20gm powder', 'UHT Milk', '924', '960', '10', '120', '44', NULL, '', '05-01-2020'),
(40, 'pran dairy ltd', 'PR-000040', '75gm powder', 'UHT Milk', '36.25', '38', '40', '60', '414', NULL, '', '05-01-2020'),
(41, 'pran dairy ltd', 'PR-000041', '400 gm powder', 'UHT Milk', '206', '215', '230', '1', '110', NULL, '', '05-01-2020'),
(42, 'pran dairy ltd', 'PR-000042', '400 gm powder', 'UHT Milk', '206', '215', '230', '1', '110', NULL, '', '05-01-2020'),
(43, 'pran dairy ltd', 'PR-000043', '500gm powder', 'UHT Milk', '243', '244', '260', '1', '1194', NULL, '', '05-01-2020'),
(44, 'pran dairy ltd', 'PR-000044', '1kg powder', 'UHT Milk', '451.5', '470', '490', '1', '166', NULL, '', '05-01-2020'),
(45, 'pran dairy ltd', 'PR-000045', '200ml latina apple/orange', 'UHT Milk', '1241', '1290', '30', '48', '49', NULL, '', '05-01-2020'),
(46, 'pran dairy ltd', 'PR-000046', '200ml latina mango', 'UHT Milk', '1344', '1392', '35', '48', '0', NULL, '', '05-01-2020'),
(47, 'pran dairy ltd', 'PR-000047', '1000 Latina apple/Orange', 'UHT Milk', '162', '170', '190', '1', '385', NULL, '', '05-01-2020'),
(48, 'pran dairy ltd', 'PR-000048', '1000ml latina mango', 'UHT Milk', '162', '170', '190', '1', '0', NULL, '', '05-01-2020'),
(49, 'pran dairy ltd', 'PR-000049', 'slim 1000ml', 'UHT Milk', '99', '105', '120', '1', '78', NULL, '', '05-01-2020'),
(50, 'pran dairy ltd', 'PR-000050', 'chocolate milk 110ml', 'UHT Milk', '1008', '1100', '15', '80', '4', NULL, '', '05-01-2020'),
(51, 'pran dairy ltd', 'PR-000051', '175 champ', 'UHT Milk', '1003', '1060', '25', '48', '0', NULL, '', '05-01-2020'),
(52, 'pran dairy ltd', 'PR-000052', '100 ghee', 'UHT Milk', '108', '112', '120', '1', '0', NULL, '', '05-01-2020'),
(53, 'pran dairy ltd', 'PR-000053', '200 ghee', 'UHT Milk', '208', '214', '225', '1', '52', NULL, '', '05-01-2020'),
(54, 'prome agro foods', 'PR-000054', 'radey tea', 'Empro', '1080', '1150', '70', '24', '42', NULL, '', '05-01-2020'),
(55, 'prome agro foods', 'PR-000055', '18 lychu', 'Empro', '360', '390', '18', '30', '267', NULL, '', '05-01-2020'),
(56, 'prome agro foods', 'PR-000056', '100 lychu', 'Empro', '500', '550', '100', '6', '85', NULL, '', '05-01-2020'),
(57, 'prome agro foods', 'PR-000057', 'poding pac', 'Empro', '440', '480', '45', '12', '355', NULL, '', '05-01-2020'),
(58, 'prome agro foods', 'PR-000058', 'ld-170', 'Empro', '410', '450', '10', '72', '435', NULL, '', '05-01-2020'),
(59, 'prome agro foods', 'PR-000059', 'lolypop jar', 'Empro', '750', '790', '150', '6', '27', NULL, '', '05-01-2020'),
(60, 'prome agro foods', 'PR-000060', 'lolypop pac', 'Empro', '885', '930', '55', '20', '51', NULL, '', '05-01-2020'),
(61, 'prome agro foods', 'PR-000061', '20 gm chatni', 'Empro', '690', '720', '2', '288', '18', NULL, '', '05-01-2020'),
(62, 'prome agro foods', 'PR-000062', '25gm chanachur', 'Empro', '360', '380', '5', '120', '13', NULL, '', '05-01-2020'),
(63, 'prome agro foods', 'PR-000063', '20gm matar', 'Empro', '348', '360', '5', '120', '17', NULL, '', '05-01-2020'),
(64, 'prome agro foods', 'PR-000064', '20gm jalmori', 'Empro', '500', '540', '5', '144', '9', NULL, '', '05-01-2020'),
(65, 'prome agro foods', 'PR-000065', 'dal 20gm', 'Empro', '650', '680', '5', '216', '8', NULL, '', '05-01-2020'),
(66, 'prome agro foods', 'PR-000066', 'Ice loly jar', 'Empro', '760', '800', '150', '6', '96', NULL, '', '05-01-2020'),
(67, 'ab food', 'PR-000067', 'Jira Biscute jar', 'Others', '530', '570', '50', '12', '10', NULL, '', '05-01-2020'),
(70, 'ab food', 'PR-000070', 'manekka', 'Others', '90', '100', '5', '50', '8', NULL, '', '05-01-2020'),
(71, 'nisso kisso paper company ltd', 'PR-000071', 'Hero coil', 'Others', '850', '950', '35', '30', '84', NULL, '', '05-01-2020'),
(72, 'nisso kisso paper company ltd', 'PR-000072', 'bangla coil', 'Bangla Tissue', '1200', '1400', '35', '42', '10', NULL, '', '05-01-2020'),
(73, 'nisso kisso paper company ltd', 'PR-000073', 'Hand towel', 'Bangla Tissue', '912', '1008', '30', '48', '92', NULL, '', '05-01-2020'),
(74, 'nisso kisso paper company ltd', 'PR-000074', '100 box facial', 'Bangla Tissue', '32', '38', '48', '48', '2', NULL, '', '05-01-2020'),
(75, 'nisso kisso paper company ltd', 'PR-000075', '120 box facial', 'Bangla Tissue', '34', '40', '55', '48', '2', NULL, '', '05-01-2020'),
(76, 'nisso kisso paper company ltd', 'PR-000076', '100 Restorent tissu', 'Bangla Tissue', '28', '30', '40', '63', '12', NULL, '', '06-01-2020'),
(77, 'nisso kisso paper company ltd', 'PR-000077', 'saloon tissu', 'Bangla Tissue', '2040', '2400', '100', '24', '12', NULL, '', '06-01-2020'),
(78, 'nisso kisso paper company ltd', 'PR-000078', '10*10 napkin', 'Bangla Tissue', '18', '20', '25', '128', '4', NULL, '', '06-01-2020'),
(79, 'nisso kisso paper company ltd', 'PR-000079', '100 napkin', 'Bangla Tissue', '34', '35', '48', '63', '15', NULL, '', '06-01-2020'),
(80, 'nisso kisso paper company ltd', 'PR-000080', '100 napkin', 'Bangla Tissue', '', '2205', '2268', '63', '', NULL, '', '06-01-2020'),
(86, 'prome agro foods', 'PR-000095', 'sohag', 'Mori', '10', '10', '', '10', '', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE `product_stock` (
  `serial_no` int(11) NOT NULL,
  `company_product_return_id` varchar(255) DEFAULT '0',
  `products_id_no` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `stock_date` varchar(255) NOT NULL,
  `company_price` varchar(255) NOT NULL DEFAULT '0',
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_stock`
--

INSERT INTO `product_stock` (`serial_no`, `company_product_return_id`, `products_id_no`, `quantity`, `stock_date`, `company_price`, `ware_house_serial_no`, `ware_house_name`) VALUES
(1, '0', 'PR-000001', 1990, '05-01-2020', '495', '1', 'Ware House  # 1'),
(2, '0', 'PR-000002', 100, '05-01-2020', '628', '1', 'Ware House  # 1'),
(3, '0', 'PR-000003', 226, '05-01-2020', '300', '1', 'Ware House  # 1'),
(4, '0', 'PR-000004', 0, '05-01-2020', '509', '1', 'Ware House  # 1'),
(5, '0', 'PR-000005', 84, '05-01-2020', '430', '1', 'Ware House  # 1'),
(6, '0', 'PR-000006', 3, '05-01-2020', '408', '1', 'Ware House  # 1'),
(7, '0', 'PR-000007', 29, '05-01-2020', '447', '1', 'Ware House  # 1'),
(8, '0', 'PR-000008', 0, '05-01-2020', '847', '1', 'Ware House  # 1'),
(9, '0', 'PR-000009', 0, '05-01-2020', '772', '1', 'Ware House  # 1'),
(10, '0', 'PR-000010', 1264, '05-01-2020', '314', '1', 'Ware House  # 1'),
(11, '0', 'PR-000011', 88, '05-01-2020', '509', '1', 'Ware House  # 1'),
(12, '0', 'PR-000012', 55, '05-01-2020', '237', '1', 'Ware House  # 1'),
(13, '0', 'PR-000013', 117, '05-01-2020', '296', '1', 'Ware House  # 1'),
(14, '0', 'PR-000014', 0, '05-01-2020', '170', '1', 'Ware House  # 1'),
(15, '0', 'PR-000015', 2, '05-01-2020', '65', '1', 'Ware House  # 1'),
(16, '0', 'PR-000016', 0, '05-01-2020', '52', '1', 'Ware House  # 1'),
(17, '0', 'PR-000017', 0, '05-01-2020', '75', '1', 'Ware House  # 1'),
(18, '0', 'PR-000018', 1992, '05-01-2020', '78', '1', 'Ware House  # 1'),
(20, '0', 'PR-000020', 115, '05-01-2020', '628', '1', 'Ware House  # 1'),
(21, '0', 'PR-000021', 2073, '05-01-2020', '558.9', '1', 'Ware House  # 1'),
(22, '0', 'PR-000022', 0, '05-01-2020', '360', '1', 'Ware House  # 1'),
(23, '0', 'PR-000023', 0, '05-01-2020', '558.9', '1', 'Ware House  # 1'),
(24, '0', 'PR-000024', 0, '05-01-2020', '558.9', '1', 'Ware House  # 1'),
(25, '0', 'PR-000025', 29, '05-01-2020', '558.9', '1', 'Ware House  # 1'),
(26, '0', 'PR-000026', 15, '05-01-2020', '485', '1', 'Ware House  # 1'),
(27, '0', 'PR-000027', 58, '05-01-2020', '390.6', '1', 'Ware House  # 1'),
(28, '0', 'PR-000028', 9, '05-01-2020', '804', '1', 'Ware House  # 1'),
(39, '0', 'PR-000039', 44, '05-01-2020', '924', '1', 'Ware House  # 1'),
(40, '0', 'PR-000040', 414, '05-01-2020', '36.25', '1', 'Ware House  # 1'),
(41, '0', 'PR-000041', 110, '05-01-2020', '206', '1', 'Ware House  # 1'),
(42, '0', 'PR-000042', 110, '05-01-2020', '206', '1', 'Ware House  # 1'),
(43, '0', 'PR-000043', 1194, '05-01-2020', '243', '1', 'Ware House  # 1'),
(44, '0', 'PR-000044', 166, '05-01-2020', '451.5', '1', 'Ware House  # 1'),
(45, '0', 'PR-000045', 49, '05-01-2020', '1241', '1', 'Ware House  # 1'),
(46, '0', 'PR-000046', 0, '05-01-2020', '1344', '1', 'Ware House  # 1'),
(47, '0', 'PR-000047', 385, '05-01-2020', '162', '1', 'Ware House  # 1'),
(48, '0', 'PR-000048', 0, '05-01-2020', '162', '1', 'Ware House  # 1'),
(49, '0', 'PR-000049', 78, '05-01-2020', '99', '1', 'Ware House  # 1'),
(50, '0', 'PR-000050', 4, '05-01-2020', '1008', '1', 'Ware House  # 1'),
(51, '0', 'PR-000051', 0, '05-01-2020', '1003', '1', 'Ware House  # 1'),
(52, '0', 'PR-000052', 0, '05-01-2020', '108', '1', 'Ware House  # 1'),
(53, '0', 'PR-000053', 52, '05-01-2020', '208', '1', 'Ware House  # 1'),
(54, '0', 'PR-000054', 42, '05-01-2020', '1080', '1', 'Ware House  # 1'),
(55, '0', 'PR-000055', 267, '05-01-2020', '360', '1', 'Ware House  # 1'),
(56, '0', 'PR-000056', 85, '05-01-2020', '500', '1', 'Ware House  # 1'),
(57, '0', 'PR-000057', 355, '05-01-2020', '440', '1', 'Ware House  # 1'),
(58, '0', 'PR-000058', 435, '05-01-2020', '410', '1', 'Ware House  # 1'),
(59, '0', 'PR-000059', 27, '05-01-2020', '750', '1', 'Ware House  # 1'),
(60, '0', 'PR-000060', 51, '05-01-2020', '885', '1', 'Ware House  # 1'),
(61, '0', 'PR-000061', 18, '05-01-2020', '690', '1', 'Ware House  # 1'),
(62, '0', 'PR-000062', 13, '05-01-2020', '360', '1', 'Ware House  # 1'),
(63, '0', 'PR-000063', 17, '05-01-2020', '348', '1', 'Ware House  # 1'),
(64, '0', 'PR-000064', 9, '05-01-2020', '500', '1', 'Ware House  # 1'),
(65, '0', 'PR-000065', 8, '05-01-2020', '650', '1', 'Ware House  # 1'),
(66, '0', 'PR-000066', 96, '05-01-2020', '760', '1', 'Ware House  # 1'),
(67, '0', 'PR-000067', 10, '05-01-2020', '530', '1', 'Ware House  # 1'),
(70, '0', 'PR-000070', 8, '05-01-2020', '90', '1', 'Ware House  # 1'),
(71, '0', 'PR-000071', 84, '05-01-2020', '850', '1', 'Ware House  # 1'),
(72, '0', 'PR-000072', 10, '05-01-2020', '1200', '1', 'Ware House  # 1'),
(73, '0', 'PR-000073', 92, '05-01-2020', '912', '1', 'Ware House  # 1'),
(74, '0', 'PR-000074', 2, '05-01-2020', '32', '1', 'Ware House  # 1'),
(75, '0', 'PR-000075', 2, '05-01-2020', '34', '1', 'Ware House  # 1'),
(76, '0', 'PR-000076', 12, '06-01-2020', '28', '1', 'Ware House  # 1'),
(77, '0', 'PR-000077', 12, '06-01-2020', '2040', '1', 'Ware House  # 1'),
(78, '0', 'PR-000078', 4, '06-01-2020', '18', '1', 'Ware House  # 1'),
(79, '0', 'PR-000079', 15, '06-01-2020', '34', '1', 'Ware House  # 1'),
(80, '0', 'PR-000080', 0, '06-01-2020', '', '1', 'Ware House  # 1'),
(82, '0', 'PR-000001', 25, '28-01-2020', '20.625', '1', 'Ware House  # 1'),
(87, '0', 'PR-000095', 15, '', '1', '1', 'Ware House  # 1');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `serial_no` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `api_url` varchar(255) NOT NULL,
  `license_code` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`serial_no`, `organization_name`, `address`, `mobile_no`, `phone_no`, `email`, `website`, `api_url`, `license_code`, `favicon`, `logo`) VALUES
(1, 'M/S HAZI KASHEM AND SONS', 'Jame Musjid Compelx, Boro Bazer, Cox\'s bazer.', '01819835110', '0341-64505', 'nurulabsar1000@gmail.com', '', '12', 'RAJC-1247 (Reg Date :23-06-2019)', 'favicon/18a9e40c00.png', 'logo/8c49ff4725.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `receive`
--

CREATE TABLE `receive` (
  `serial_no` int(11) NOT NULL,
  `receive_type` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `invoice_docs_no` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `receive_date` varchar(255) NOT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `serial_no` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`serial_no`, `role_name`) VALUES
(9, 'accountant'),
(11, 'admin'),
(17, 'Salesman'),
(18, 'Delivery Man'),
(20, 'Own Shop Salesman'),
(21, 'Wear House Incharge');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `role_serial_no` varchar(255) NOT NULL,
  `permission_serial_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`role_serial_no`, `permission_serial_no`) VALUES
('9', '111'),
('9', '112'),
('9', '113'),
('9', '114'),
('9', '115'),
('9', '116'),
('9', '117'),
('9', '118'),
('9', '119'),
('9', '120'),
('9', '121'),
('9', '122'),
('9', '123'),
('9', '124'),
('9', '125'),
('9', '126'),
('9', '127'),
('9', '128'),
('9', '129'),
('9', '130'),
('9', '131'),
('9', '132'),
('9', '133'),
('9', '134'),
('9', '135'),
('9', '136'),
('9', '137'),
('9', '138'),
('9', '139'),
('9', '140'),
('9', '141'),
('9', '142'),
('9', '143'),
('9', '144'),
('9', '145'),
('9', '146'),
('9', '147'),
('9', '148'),
('9', '149'),
('9', '150'),
('9', '151'),
('9', '152'),
('9', '153'),
('9', '154'),
('9', '155'),
('9', '156'),
('9', '157'),
('11', '1'),
('11', '2'),
('11', '3'),
('11', '4'),
('11', '5'),
('11', '6'),
('11', '7'),
('11', '8'),
('11', '9'),
('11', '10'),
('11', '11'),
('11', '12'),
('11', '13'),
('11', '14'),
('11', '15'),
('11', '16'),
('11', '17'),
('11', '18'),
('11', '19'),
('11', '20'),
('11', '21'),
('11', '22'),
('11', '23'),
('11', '24'),
('11', '170'),
('11', '171'),
('11', '172'),
('11', '173'),
('11', '181'),
('11', '25'),
('11', '26'),
('11', '27'),
('11', '28'),
('11', '29'),
('11', '30'),
('11', '31'),
('11', '32'),
('11', '33'),
('11', '34'),
('11', '35'),
('11', '36'),
('11', '37'),
('11', '38'),
('11', '39'),
('11', '40'),
('11', '41'),
('11', '42'),
('11', '43'),
('11', '44'),
('11', '45'),
('11', '46'),
('11', '51'),
('11', '52'),
('11', '53'),
('11', '54'),
('11', '55'),
('11', '56'),
('11', '57'),
('11', '65'),
('11', '70'),
('11', '71'),
('11', '74'),
('11', '75'),
('11', '182'),
('11', '76'),
('11', '77'),
('11', '78'),
('11', '79'),
('11', '80'),
('11', '81'),
('11', '82'),
('11', '83'),
('11', '84'),
('11', '85'),
('11', '86'),
('11', '87'),
('11', '88'),
('11', '89'),
('11', '90'),
('11', '91'),
('11', '92'),
('11', '93'),
('11', '94'),
('11', '95'),
('11', '96'),
('11', '97'),
('11', '98'),
('11', '99'),
('11', '100'),
('11', '101'),
('11', '102'),
('11', '103'),
('11', '104'),
('11', '105'),
('11', '106'),
('11', '107'),
('11', '108'),
('11', '109'),
('11', '110'),
('11', '178'),
('11', '179'),
('11', '111'),
('11', '112'),
('11', '113'),
('11', '114'),
('11', '115'),
('11', '116'),
('11', '117'),
('11', '118'),
('11', '119'),
('11', '120'),
('11', '121'),
('11', '122'),
('11', '123'),
('11', '124'),
('11', '125'),
('11', '126'),
('11', '127'),
('11', '128'),
('11', '129'),
('11', '130'),
('11', '131'),
('11', '132'),
('11', '133'),
('11', '134'),
('11', '135'),
('11', '136'),
('11', '137'),
('11', '138'),
('11', '139'),
('11', '140'),
('11', '141'),
('11', '142'),
('11', '143'),
('11', '144'),
('11', '145'),
('11', '146'),
('11', '147'),
('11', '148'),
('11', '149'),
('11', '150'),
('11', '151'),
('11', '152'),
('11', '153'),
('11', '154'),
('11', '155'),
('11', '156'),
('11', '157'),
('11', '158'),
('11', '159'),
('11', '160'),
('11', '162'),
('11', '165'),
('11', '166'),
('11', '167'),
('11', '168'),
('11', '169'),
('11', '180'),
('17', ''),
('18', ''),
('20', ''),
('21', '');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `serial_no` int(11) NOT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `reg_no` varchar(255) DEFAULT NULL,
  `engine_no` varchar(255) DEFAULT NULL,
  `insurance_no` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `license_no` varchar(255) DEFAULT NULL,
  `owner_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`serial_no`, `vehicle_name`, `type`, `reg_no`, `engine_no`, `insurance_no`, `driver_name`, `license_no`, `owner_type`) VALUES
(1, 'van #1', 'van', '1554545454', '54', '54', 'sohag', '5', 'Self'),
(2, 'van #2', 'sfsa', 'afa', 'adsfa', 'adsfa', 'asdf', 'adsf', 'Self');

-- --------------------------------------------------------

--
-- Table structure for table `truck_load`
--

CREATE TABLE `truck_load` (
  `serial_no` int(11) NOT NULL,
  `zone_serial_no` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `emplyee_name` varchar(255) DEFAULT NULL,
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `loading_date` varchar(255) DEFAULT NULL,
  `unload_status` varchar(255) NOT NULL DEFAULT '0',
  `unload_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `truck_load`
--

INSERT INTO `truck_load` (`serial_no`, `zone_serial_no`, `zone_name`, `area_name`, `ware_house_serial_no`, `ware_house_name`, `employee_id`, `emplyee_name`, `vehicle_reg_no`, `vehicle_name`, `vehicle_type`, `loading_date`, `unload_status`, `unload_date`) VALUES
(26, '1', 'Cox\'s Bazar', '', '1', 'Ware House  # 1', 'EMP-000004', 'Mr. Redwan', '1554545454', 'van #1', 'van', '27-01-2020', '1', '27-01-2020'),
(27, '1', 'Cox\'s Bazar', '', '1', 'Ware House  # 1', 'EMP-000004', 'Mr. Redwan', 'afa', 'van #2', 'sfsa', '27-01-2020', '1', '27-01-2020'),
(28, '1', 'Cox\'s Bazar', '', '1', 'Ware House  # 1', 'EMP-000008', 'Mr. Nurul Alam', 'afa', 'van #2', 'sfsa', '28-01-2020', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `truck_loaded_products`
--

CREATE TABLE `truck_loaded_products` (
  `serial_no` int(11) NOT NULL,
  `truck_load_tbl_id` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `quantity_offer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `truck_loaded_products`
--

INSERT INTO `truck_loaded_products` (`serial_no`, `truck_load_tbl_id`, `product_id`, `products_name`, `category`, `quantity`, `quantity_offer`) VALUES
(10, '26', 'PR-000001', 'Royal Tiger 250 Ml', 'Soft Drinks', '27', NULL),
(11, '27', 'PR-000001', 'Royal Tiger 250 Ml', 'Soft Drinks', '36', NULL),
(12, '27', 'PR-000002', 'UHT Milk 500ml', 'UHT Milk', '37', NULL),
(13, '27', 'PR-000003', '250ml Fizzup', 'Soft Drinks', '74', NULL),
(14, '27', 'PR-000005', '1 lit Fizzup', 'Soft Drinks', '63', NULL),
(15, '27', 'PR-000006', '2 lit Fizzup', 'Soft Drinks', '17', NULL),
(16, '28', 'PR-000003', '250ml Fizzup', 'Soft Drinks', '48', NULL),
(17, '28', 'PR-000006', '2 lit Fizzup', 'Soft Drinks', '6', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `truck_unloaded_products`
--

CREATE TABLE `truck_unloaded_products` (
  `serial_no` bigint(20) NOT NULL,
  `truck_load_tbl_id` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `loaded_pcs` varchar(255) DEFAULT NULL,
  `sold_pcs` varchar(255) DEFAULT NULL,
  `back_pcs` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `truck_unloaded_products`
--

INSERT INTO `truck_unloaded_products` (`serial_no`, `truck_load_tbl_id`, `product_id`, `products_name`, `loaded_pcs`, `sold_pcs`, `back_pcs`) VALUES
(1, '24', 'PR-000001', 'Royal Tiger 250 Ml', '60', '43', '17'),
(2, '24', 'PR-000002', 'UHT Milk 500ml', '44', '28', '16'),
(3, '25', 'PR-000001', 'Royal Tiger 250 Ml', '29', '26', '3'),
(4, '25', 'PR-000002', 'UHT Milk 500ml', '20', '18', '2'),
(5, '26', 'PR-000001', 'Royal Tiger 250 Ml', '27', '10', '17'),
(6, '27', 'PR-000001', 'Royal Tiger 250 Ml', '36', '27', '9'),
(7, '27', 'PR-000002', 'UHT Milk 500ml', '37', '17', '20'),
(8, '27', 'PR-000003', '250ml Fizzup', '74', '51', '23'),
(9, '27', 'PR-000005', '1 lit Fizzup', '63', '0', '63'),
(10, '27', 'PR-000006', '2 lit Fizzup', '17', '8', '9');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `serial_no` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`serial_no`, `name`, `designation`, `mobile_no`, `address`, `email`, `user_name`, `password`) VALUES
(8, 'abulkhair', 'Admin', '01930926027', 'Coxsbazar', 'Malti@gmail.com', 'admin', 'admin'),
(9, 'Nurul Abser', 'Admin', '01880059363', 'Coxs Bazar', 'Meethounsrtc@gmail.com.com', 'nurulabser', '123456'),
(10, 'Monjur Morshed', 'Admin', '01722700057', 'Coxs Bazar', 'meethounsrtc@gmail.com', 'morshed', '123456'),
(12, 'Mamun', 'Zone In charge', '01925565756', 'Ramu', 'admin@gmail.com', 'mamun', '0341'),
(13, 'Mr. Farque', 'Admin', '01925565756', 'Padua', 'admin@gmail.com', 'Rashed', 'rashed123');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_role`
--

CREATE TABLE `user_has_role` (
  `role_serial_no` varchar(255) NOT NULL,
  `user_serial_no` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_has_role`
--

INSERT INTO `user_has_role` (`role_serial_no`, `user_serial_no`, `user_type`) VALUES
('17', '7', 'employee'),
('17', '6', 'employee'),
('17', '4', 'employee'),
('17', '2', 'employee'),
('17', '1', 'employee'),
('18', '9', 'employee'),
('18', '8', 'employee'),
('21', '5', 'employee'),
('18', '11', 'employee'),
('18', '10', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `user_zone_permission`
--

CREATE TABLE `user_zone_permission` (
  `serial_no` int(11) NOT NULL,
  `user_serial_no` varchar(255) NOT NULL,
  `zone_serial_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_zone_permission`
--

INSERT INTO `user_zone_permission` (`serial_no`, `user_serial_no`, `zone_serial_no`) VALUES
(2, '2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ware_house`
--

CREATE TABLE `ware_house` (
  `serial_no` int(11) NOT NULL,
  `ware_house_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ware_house`
--

INSERT INTO `ware_house` (`serial_no`, `ware_house_name`, `address`) VALUES
(1, 'Ware House  # 1', 'Barmise School Road, Cox\'s Bazar.'),
(2, 'Ware House #2', 'coutbazar.');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `serial_no` int(11) NOT NULL,
  `zone_name` varchar(255) DEFAULT NULL,
  `ware_house_serial_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`serial_no`, `zone_name`, `ware_house_serial_no`) VALUES
(1, 'Cox\'s Bazar', '1'),
(3, 'coutbazar', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `area_zone`
--
ALTER TABLE `area_zone`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `bank_deposite`
--
ALTER TABLE `bank_deposite`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `bank_loan`
--
ALTER TABLE `bank_loan`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `bank_loan_pay`
--
ALTER TABLE `bank_loan_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_withdraw`
--
ALTER TABLE `bank_withdraw`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `client_category`
--
ALTER TABLE `client_category`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `company_commission`
--
ALTER TABLE `company_commission`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `company_products_return`
--
ALTER TABLE `company_products_return`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `delivered_order_payment_history`
--
ALTER TABLE `delivered_order_payment_history`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `delivery_employee`
--
ALTER TABLE `delivery_employee`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `due_payment_invoice`
--
ALTER TABLE `due_payment_invoice`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_academic_info`
--
ALTER TABLE `employee_academic_info`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_commission`
--
ALTER TABLE `employee_commission`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_document_info`
--
ALTER TABLE `employee_document_info`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_duty`
--
ALTER TABLE `employee_duty`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_main_info`
--
ALTER TABLE `employee_main_info`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `employee_payments`
--
ALTER TABLE `employee_payments`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `expense_head`
--
ALTER TABLE `expense_head`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `id_no_generator`
--
ALTER TABLE `id_no_generator`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `invoice_expense`
--
ALTER TABLE `invoice_expense`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `invoice_setting`
--
ALTER TABLE `invoice_setting`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `market_products_return`
--
ALTER TABLE `market_products_return`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `money_receipt_info_tbl`
--
ALTER TABLE `money_receipt_info_tbl`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `money_receipt_main_tbl`
--
ALTER TABLE `money_receipt_main_tbl`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `offered_products`
--
ALTER TABLE `offered_products`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `offered_products_stock`
--
ALTER TABLE `offered_products_stock`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `order_delivery`
--
ALTER TABLE `order_delivery`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `order_delivery_expense`
--
ALTER TABLE `order_delivery_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_summery`
--
ALTER TABLE `order_summery`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `order_summery_product_info`
--
ALTER TABLE `order_summery_product_info`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `order_summery_shop_info`
--
ALTER TABLE `order_summery_shop_info`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_client`
--
ALTER TABLE `own_shop_client`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_employee`
--
ALTER TABLE `own_shop_employee`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_products_stock`
--
ALTER TABLE `own_shop_products_stock`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_sell`
--
ALTER TABLE `own_shop_sell`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_sell_product`
--
ALTER TABLE `own_shop_sell_product`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_stock_history`
--
ALTER TABLE `own_shop_stock_history`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `previous_offers`
--
ALTER TABLE `previous_offers`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `receive`
--
ALTER TABLE `receive`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `truck_load`
--
ALTER TABLE `truck_load`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `truck_loaded_products`
--
ALTER TABLE `truck_loaded_products`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `truck_unloaded_products`
--
ALTER TABLE `truck_unloaded_products`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `user_zone_permission`
--
ALTER TABLE `user_zone_permission`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `ware_house`
--
ALTER TABLE `ware_house`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`serial_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `serial_no` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `serial_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `area_zone`
--
ALTER TABLE `area_zone`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `bank_deposite`
--
ALTER TABLE `bank_deposite`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_loan`
--
ALTER TABLE `bank_loan`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_loan_pay`
--
ALTER TABLE `bank_loan_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_withdraw`
--
ALTER TABLE `bank_withdraw`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `client_category`
--
ALTER TABLE `client_category`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `company_commission`
--
ALTER TABLE `company_commission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_products_return`
--
ALTER TABLE `company_products_return`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `delivered_order_payment_history`
--
ALTER TABLE `delivered_order_payment_history`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `delivery_employee`
--
ALTER TABLE `delivery_employee`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `due_payment_invoice`
--
ALTER TABLE `due_payment_invoice`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_academic_info`
--
ALTER TABLE `employee_academic_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `employee_commission`
--
ALTER TABLE `employee_commission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_document_info`
--
ALTER TABLE `employee_document_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `employee_duty`
--
ALTER TABLE `employee_duty`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employee_main_info`
--
ALTER TABLE `employee_main_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `employee_payments`
--
ALTER TABLE `employee_payments`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expense_head`
--
ALTER TABLE `expense_head`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `id_no_generator`
--
ALTER TABLE `id_no_generator`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice_setting`
--
ALTER TABLE `invoice_setting`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `market_products_return`
--
ALTER TABLE `market_products_return`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `money_receipt_info_tbl`
--
ALTER TABLE `money_receipt_info_tbl`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offered_products`
--
ALTER TABLE `offered_products`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `offered_products_stock`
--
ALTER TABLE `offered_products_stock`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `order_delivery`
--
ALTER TABLE `order_delivery`
  MODIFY `serial_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `order_delivery_expense`
--
ALTER TABLE `order_delivery_expense`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `order_summery`
--
ALTER TABLE `order_summery`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_summery_product_info`
--
ALTER TABLE `order_summery_product_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_summery_shop_info`
--
ALTER TABLE `order_summery_shop_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `own_shop_client`
--
ALTER TABLE `own_shop_client`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `own_shop_employee`
--
ALTER TABLE `own_shop_employee`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `own_shop_products_stock`
--
ALTER TABLE `own_shop_products_stock`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `own_shop_sell`
--
ALTER TABLE `own_shop_sell`
  MODIFY `serial_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `own_shop_sell_product`
--
ALTER TABLE `own_shop_sell_product`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `own_shop_stock_history`
--
ALTER TABLE `own_shop_stock_history`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;
--
-- AUTO_INCREMENT for table `previous_offers`
--
ALTER TABLE `previous_offers`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `receive`
--
ALTER TABLE `receive`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `truck_load`
--
ALTER TABLE `truck_load`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `truck_loaded_products`
--
ALTER TABLE `truck_loaded_products`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `truck_unloaded_products`
--
ALTER TABLE `truck_unloaded_products`
  MODIFY `serial_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user_zone_permission`
--
ALTER TABLE `user_zone_permission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ware_house`
--
ALTER TABLE `ware_house`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
