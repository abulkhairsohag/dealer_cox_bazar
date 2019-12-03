-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2019 at 12:17 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dealership_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `serial_no` int(11) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`serial_no`, `account_name`, `organization_name`, `address`, `mobile_no`, `bank_name`, `bank_account_no`, `branch_name`, `description`) VALUES
(1, 'Saving', 'SattIt', 'Godagari,Rajshahi,Bangladesh', '01753474401', 'UCB Bank', '12326562306595451', 'Mohakhali branch', 'good condition');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `serial_no` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `district_name` varchar(255) NOT NULL,
  `thana_name` varchar(255) NOT NULL,
  `line_route` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`serial_no`, `area_name`, `district_name`, `thana_name`, `line_route`) VALUES
(2, 'Godagari', 'Rajshahi', 'Godagari', 'Rajshahi - Chapai'),
(3, 'RDA Market', 'Rajshahi', 'Boalia', 'Dhaka - Rajshahi'),
(4, 'Talaimari', 'Rjshshi', 'asd', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `area_zone`
--

CREATE TABLE `area_zone` (
  `serial_no` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `area_zone`
--

INSERT INTO `area_zone` (`serial_no`, `area_id`, `zone_id`) VALUES
(1, 11, 2),
(2, 11, 3),
(3, 11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `bank_deposite`
--

CREATE TABLE `bank_deposite` (
  `serial_no` int(11) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `deposite_date` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_deposite`
--

INSERT INTO `bank_deposite` (`serial_no`, `bank_name`, `bank_account_no`, `account_holder_name`, `branch_name`, `amount`, `deposite_date`, `description`) VALUES
(1, 'UCB Bank', '1232656230659', 'Abul Khair Sohag', 'Karwan Bazar', '100', '01-07-2019', 'good condition'),
(2, 'UCB Bank', '1232656230659', 'Abul Khair Sohag', 'Karwan Bazar', '100', '03-07-2019', 'good condition edit'),
(3, 'Modhumoti Bank', '12326562306595451', 'Abul Khair Sohag', 'Karwan Bazar', '100', '10-07-2019', 'good condition edit'),
(4, 'Habib Bank', '1232656230659', 'Abul Khair Sohag', 'Karwan Bazar', '100', '15-07-2019', 'good condition edit'),
(5, 'Ishlami Bank', '12326562306595451', 'Abul Khair Sohag', 'Karwan Bazar', '100', '11-07-2019', 'good '),
(6, 'UCB Bank', '1232656230659', 'Abul Khair Sohag', 'Karwan Bazar', '100', '12-07-2019', 'Nice Loocking'),
(7, 'Modhumoti Bank', '1232656230659', 'Abul Khair Sohag', 'Karwan Bazar', '100', '13-07-2019', 'good condition edit');

-- --------------------------------------------------------

--
-- Table structure for table `bank_loan`
--

CREATE TABLE `bank_loan` (
  `serial_no` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `installment_amount` varchar(255) NOT NULL,
  `installment_date` varchar(255) NOT NULL,
  `loan_taken_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_loan`
--

INSERT INTO `bank_loan` (`serial_no`, `bank_name`, `branch_name`, `total_amount`, `installment_amount`, `installment_date`, `loan_taken_date`) VALUES
(1, 'sfs', 'sdf', '10000', '100', '17-07-2019', '17-07-2019'),
(2, 'sfsd', 'fsdfs', '100000', '100', '25-07-2019', '25-07-2019'),
(3, 'dfsdafdasfsaf', 'asfsafasfsadf', '10000', '100', '25-07-2019', '25-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `bank_loan_pay`
--

CREATE TABLE `bank_loan_pay` (
  `id` int(11) NOT NULL,
  `bank_loan_id` int(11) NOT NULL,
  `pay_amt` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank_loan_pay`
--

INSERT INTO `bank_loan_pay` (`id`, `bank_loan_id`, `pay_amt`, `date`) VALUES
(13, 1, '100', '10-07-2019'),
(14, 1, '100', '12-07-2019'),
(15, 1, '100', '16-07-2019'),
(16, 1, '100', '20-07-2019'),
(17, 1, '600', '25-07-2019'),
(18, 1, '1000', '25-07-2019'),
(19, 3, '1000', '25-07-2019'),
(20, 1, '8000', '25-07-2019');

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
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_withdraw`
--

INSERT INTO `bank_withdraw` (`serial_no`, `bank_name`, `bank_account_no`, `cheque_no`, `branch_name`, `amount`, `receiver_name`, `cheque_active_date`, `description`) VALUES
(1, 'UCB Bank', '1232656230659', '1254520545122121', 'Karwan Bazar', '100', 'sohag', '16-07-2019', ''),
(2, 'UCB Bank', '12326562306595451', '10215412051052', 'Mohakhali branch', '25', 'kanak', '02-07-2019', ''),
(3, 'UCB Bank', '6145812025451000', '1254520545122121', 'Karwan Bazar', '100', 'tariq', '04-07-2019', ''),
(4, 'Habib Bank', '12326562306595451', '10215412051052', 'Alupotti', '25', 'amran', '11-07-2019', '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `serial_no` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`serial_no`, `category_name`) VALUES
(1, 'Electronics'),
(2, 'Mobile Phone'),
(3, 'Laptop'),
(4, 'Television');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `serial_no` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`serial_no`, `area_name`, `category_name`, `client_name`, `organization_name`, `address`, `mobile_no`, `email`, `description`) VALUES
(1, 'RDA Market', 'Irrigular', 'Abul Khair Sohag', 'SattIt', 'jhgjk hjgjh jg ugyurrsyh tydjhderys', '01753474401', 'sohag@gmail.com', ''),
(2, 'Godagari', 'Best', 'sdfsadf', 'sadfsda', 'fsdf', 'sdfsfasdf', 'MGI@gmail.com', 'sdfsaf');

-- --------------------------------------------------------

--
-- Table structure for table `client_category`
--

CREATE TABLE `client_category` (
  `serial_no` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_category`
--

INSERT INTO `client_category` (`serial_no`, `category_name`) VALUES
(1, 'Regular'),
(2, 'Irrigular'),
(3, 'Best');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`serial_no`, `company_name`, `responder_name`, `respoder_designation`, `address`, `mobile_no`, `phone_no`, `fax`, `email`, `website`, `product_type`, `product_quality`, `description`) VALUES
(1, 'Samsung', 'Tarikul Islam', 'CEO', 'talaimari, Rajshahi', '01756545580', '', '', 'tariqulislamrc@gmail.com', 'www.sattit.com', '', '', ''),
(2, 'Dell', 'Amran', 'COO', 'Talaimari, Rajshahi', '01823656602', '', '', 'amran@gmail.com', 'www.sattit.com', '', '', ''),
(3, 'Sattit', 'Sohag', 'programmer', 'talaimari, Rajshahi', '01753474401', '01753474401', '', 'abulkhairsohag@gmail.com', 'www.sattit.com', '', '', '');

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
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_commission`
--

INSERT INTO `company_commission` (`serial_no`, `company`, `month`, `target_product`, `target_sell_amount`, `comission_persent`, `date`) VALUES
(1, 'Satt Academy', '01-2019', '1000', '21000000', '10', '17-07-2019'),
(2, 'Satt Academy', '03-2019', '500', '10000', '1', '17-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `company_products_return`
--

CREATE TABLE `company_products_return` (
  `serial_no` int(11) NOT NULL,
  `products_id_no` varchar(255) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `dealer_price` varchar(255) NOT NULL,
  `return_quantity` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `return_reason` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `return_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_products_return`
--

INSERT INTO `company_products_return` (`serial_no`, `products_id_no`, `products_name`, `company`, `dealer_price`, `return_quantity`, `total_price`, `return_reason`, `description`, `return_date`) VALUES
(1, 'PR-161517', 'Samsung Galaxy j5 6', 'samsung', '10', '10', '100', 'Product Damage', '', '10-07-2019'),
(2, 'PR-014453', 'DMS software', 'sattit', '01', '50', '50', 'Product Damage', '', '10-07-2019'),
(3, 'PR-674085', 'Smart Television', 'samsung', '0', '100', '0', 'Product Damage', '', '10-07-2019'),
(4, 'PR-598527', 'smart watch', 'samsung', '0', '100', '0', 'Product Damage', '', '10-07-2019'),
(5, 'PR-014453', 'DMS software', 'sattit', '01', '10', '10', 'Manufacture Date Expire', '', '13-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_employee`
--

CREATE TABLE `delivery_employee` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `vehicle_reg_no` varchar(255) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `active_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_employee`
--

INSERT INTO `delivery_employee` (`serial_no`, `id_no`, `name`, `company`, `area`, `vehicle_reg_no`, `from_date`, `to_date`, `active_status`) VALUES
(4, 'EMP-02236552', 'abir', NULL, 'Godagari', '54215241302132421', '02-07-2019', '31-07-2019', 'Inactive'),
(5, 'EMP-24784820', 'sadik', NULL, 'RDA Market', '54215241302132421', '01-07-2019', '31-07-2019', 'Inactive'),
(6, 'EMP-88723529', 'Md. Abul Khair', NULL, 'Godagari', '542152413021324', '08-07-2019', '31-07-2019', 'Active'),
(7, 'EMP-24784820', 'sadik', NULL, 'RDA Market', '542152413021324145', '02-07-2019', '05-07-2019', 'Inactive');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_academic_info`
--

INSERT INTO `employee_academic_info` (`serial_no`, `main_tbl_serial_no`, `institute`, `exam_name`, `board_university`, `group_name`, `result`, `passing_year`) VALUES
(2, 2, 'MHS', 'ssc', 'a', 'Science', '5', '2010'),
(3, 3, 'asd', 'ssc', 'asd', 'asd', '5', '2010'),
(4, 4, 'sad', 'ssc', 'asda', 'sdas', '5', '2010'),
(25, 5, 'klj', 'ssc', 'lkj', 'klj', '6', '2010');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_attendance`
--

INSERT INTO `employee_attendance` (`serial_no`, `employee_id_no`, `name`, `designation`, `attendance`, `attendance_date`, `attendance_month`) VALUES
(1, 'EMP-57064510', 'Tarikul Islam', 'slsllsl', '0', '10-07-2019', '07-2019'),
(2, 'EMP-88723529', 'Md. Abul Khair', 'manager', '0', '10-07-2019', '07-2019'),
(3, 'EMP-24784820', 'sadik', 'ksdkfj', '0', '10-07-2019', '07-2019'),
(4, 'EMP-32619416', 'Motiur Rahman', 'ceo', '0', '10-07-2019', '07-2019'),
(5, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '11-07-2019', '07-2019'),
(6, 'EMP-24784820', 'sadik', 'ksdkfj', '1', '11-07-2019', '07-2019'),
(7, 'EMP-32619416', 'Motiur Rahman', 'ceo', '0', '11-07-2019', '07-2019'),
(8, 'EMP-02236552', 'abir', '444', '1', '11-07-2019', '07-2019'),
(9, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '13-07-2019', '07-2019'),
(10, 'EMP-02236552', 'sadik', 'ksdkfj', '1', '13-07-2019', '07-2019'),
(11, 'EMP-02236552', 'Motiur Rahman', 'ceo', '1', '13-07-2019', '07-2019'),
(12, 'EMP-02236552', 'abir', '444', '1', '13-07-2019', '07-2019'),
(13, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '24-07-2019', '07-2019'),
(14, 'EMP-24784820', 'sadik', 'ksdkfj', '1', '24-07-2019', '07-2019'),
(15, 'EMP-32619416', 'Motiur Rahman', 'ceo', '1', '24-07-2019', '07-2019'),
(16, 'EMP-02236552', 'abir', '444', '1', '24-07-2019', '07-2019'),
(17, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '25-07-2019', '07-2019'),
(18, 'EMP-24784820', 'sadik', 'ksdkfj', '1', '25-07-2019', '07-2019'),
(19, 'EMP-32619416', 'Motiur Rahman', 'ceo', '0', '25-07-2019', '07-2019'),
(20, 'EMP-02236552', 'Abir', '444', '1', '25-07-2019', '07-2019'),
(21, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '27-07-2019', '07-2019'),
(22, 'EMP-24784820', 'sadik', 'ksdkfj', '0', '27-07-2019', '07-2019'),
(23, 'EMP-32619416', 'Motiur Rahman', 'ceo', '1', '27-07-2019', '07-2019'),
(24, 'EMP-02236552', 'Abir', '444', '1', '27-07-2019', '07-2019'),
(25, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '29-07-2019', '07-2019'),
(26, 'EMP-24784820', 'sadik', 'ksdkfj', '1', '29-07-2019', '07-2019'),
(27, 'EMP-32619416', 'Motiur Rahman', 'ceo', '1', '29-07-2019', '07-2019'),
(28, 'EMP-02236552', 'Abir', '444', '1', '29-07-2019', '07-2019'),
(29, 'EMP-88723529', 'Md. Abul Khair', 'manager', '1', '30-07-2019', '07-2019'),
(30, 'EMP-24784820', 'sadik', 'ksdkfj', '1', '30-07-2019', '07-2019'),
(31, 'EMP-32619416', 'Motiur Rahman', 'ceo', '0', '30-07-2019', '07-2019'),
(32, 'EMP-02236552', 'Abir', '444', '1', '30-07-2019', '07-2019'),
(33, 'EMP-88723529', 'Md. Abul Khair', 'manager', '0', '31-07-2019', '07-2019'),
(34, 'EMP-24784820', 'sadik', 'ksdkfj', '0', '31-07-2019', '07-2019'),
(35, 'EMP-32619416', 'Motiur Rahman', 'ceo', '0', '31-07-2019', '07-2019'),
(36, 'EMP-02236552', 'Abir', '444', '1', '31-07-2019', '07-2019'),
(37, 'EMP-88723529', 'Md. Abul Khair', 'manager', '0', '02-08-2019', '08-2019'),
(38, 'EMP-24784820', 'sadik', 'ksdkfj', '0', '02-08-2019', '08-2019'),
(39, 'EMP-32619416', 'Motiur Rahman', 'ceo', '0', '02-08-2019', '08-2019'),
(40, 'EMP-02236552', 'Abir', '444', '0', '02-08-2019', '08-2019');

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
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_commission`
--

INSERT INTO `employee_commission` (`serial_no`, `id_no`, `name`, `designation`, `company`, `month`, `sell_target`, `total_sell_amount`, `comission_persent`, `date`) VALUES
(1, 'EMP-24784820', 'sadik', 'ksdkfj', '10', '04-2019', '200', '101000', '10', '17-07-2019'),
(2, 'EMP-02236552', 'abir', '444', 'Satt Academy', '04-2019', '200', '1010', '10', '17-07-2019');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_document_info`
--

INSERT INTO `employee_document_info` (`serial_no`, `main_tbl_serial_no`, `document_name`, `document_type`, `description`, `upload_document`) VALUES
(2, 2, '', '', ' ', ''),
(3, 3, '', '', ' ', ''),
(4, 4, '', '', ' ', ''),
(5, 5, '', '', ' ', 'file/7936894ab2.');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_duty`
--

INSERT INTO `employee_duty` (`serial_no`, `id_no`, `name`, `area`, `company`, `per_day`, `per_month`, `comission`, `description`, `active_status`) VALUES
(6, 'EMP-32619416', 'Motiur Rahman', 'Godagari', NULL, '10', '300', '1', '10', 'Active'),
(7, 'EMP-24784820', 'sadik', 'RDA Market', NULL, '100', '50000', '10', 'Nice Loocking', 'Active');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_main_info`
--

INSERT INTO `employee_main_info` (`serial_no`, `id_no`, `area_name`, `designation`, `joining_date`, `basic_salary`, `house_rent`, `medical_allowance`, `transport_allowance`, `insurance`, `commission`, `extra_over_time`, `total_salary`, `user_name`, `password`, `name`, `fathers_name`, `mothers_name`, `spouses_name`, `birth_date`, `gender`, `nid_no`, `birth_certificate_no`, `nationality`, `religion`, `photo`, `present_address`, `permanent_address`, `mobile_no`, `phone_no`, `email`, `account_name`, `bank_name`, `branch_name`, `account_no`, `height`, `wieght`, `blood_group`, `body_identify_mark`, `active_status`) VALUES
(2, 'EMP-88723529', 'Godagari', 'manager', '10-07-2019', '10', '10', '10', '01', '10', '10', '9', '60', 'sohag', '123456', 'Md. Abul Khair', 'Md. Salah Uddin ', 'Most. Khairun Nesa', '', '01-07-2019', 'Male', '1212154', '', 'Bangladeshi', 'Islam', 'images/7bc5ea967a.jpg', 'Taliamari, Rajshahi', 'Taliamari, Rajshahi', '01753474401', '01753474401', 'abulkhairsohag@gmail.com', 'Saving', 'Modhumoti Bank', 'Karwan Bazar', '51212121545201254212', '6', '5', 'O (+ve)', '', 'Active'),
(3, 'EMP-24784820', 'Talaimari ', 'ksdkfj', '10-07-2019', '100', '2000', '100', '100', '100', '100', '100', '2600', 'sadik', '123456', 'sadik', 'dasf', 'asdfa', 'dsfa', '02-07-2019', 'Male', '6543210', '5445156', 'Bangladeshi', 'Islam', 'images/8813d33e29.jpg', 'Taliamari, Rajshahi', 'Taliamari, Rajshahi', '0156897841', '01718627564', 'a@gmail.com', 'Saving', 'Habib Bank', 'Mohakhali branch', '5121212154520125421', '6', '54', 'AB (+ve)', '', 'Active'),
(4, 'EMP-32619416', 'RDA Market', 'ceo', '10-07-2019', '10', '10', '10', '10', '10', '10', '10', '70', 'motiur', '123456', 'Motiur Rahman', 'dfa', 'asdf', 'afds', '16-07-2019', 'Male', '3512321', '', 'Bangladeshi', 'Islam', 'images/fa0431d17d.jpg', 'Taliamari, Rajshahi', 'Taliamari, Rajshahi', '01753474401', '01753474401212', 'abulkhairsohag@gmail.com', 'debit', 'Modhumoti Bank', 'Karwan Bazar', '5121212154520125421', '6', '54', 'AB (+ve)', '', 'Active'),
(5, 'EMP-02236552', 'Godagari', '444', '10-07-2019', '100', '100', '100', '100', '100', '100', '100', '700', 'abir', '123456', 'Abir', 'kjk', 'ljkl', 'jklj', '08-07-2019', 'Male', '566565', '6+5', '6+5', '21', 'images/68cff895a5.', '231', '21', '21', '21', 'a@gmail.com', 'Saving', 'Habib Bank', 'Alupotti', '5121212154520125421', '55', '54', 'O (+ve)', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employee_payments`
--

CREATE TABLE `employee_payments` (
  `serial_no` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `total_salary` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `attendance` varchar(255) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `advance_amount` varchar(255) NOT NULL,
  `salary_paid` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_payments`
--

INSERT INTO `employee_payments` (`serial_no`, `id_no`, `name`, `designation`, `total_salary`, `month`, `attendance`, `pay_type`, `advance_amount`, `salary_paid`, `description`, `date`) VALUES
(1, 'EMP-88723529', 'Md. Abul Khair', 'manager', '60', '02-2019', '0', 'Full Salary', '0', '60', 'good condition', '17-07-2019'),
(2, 'EMP-24784820', 'sadik', 'ksdkfj', '2600', '03-2019', '0', 'Salary Advance', '100', '2700', '', '17-07-2019'),
(3, 'EMP-02236552', 'abir', '444', '612', '01-2019', '0', 'Salary Advance', '200', '812', '', '17-07-2019');

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
  `paid_amount` varchar(255) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `next_paid_date` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `expense_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`serial_no`, `expense_type`, `client_name`, `organization_name`, `address`, `mobile_no`, `invoice_docs_no`, `invoice_docs_img`, `total_amount`, `paid_amount`, `due_amount`, `next_paid_date`, `description`, `expense_date`) VALUES
(4, 'sell Something', 'dfdg', 'dgfd', 'dgd', '21', 'SF', 'invoice_img/90b49071d6.jpg', '10', '10', '0', '08-01-2019', '', '01-08-2019');

-- --------------------------------------------------------

--
-- Table structure for table `expense_head`
--

CREATE TABLE `expense_head` (
  `serial_no` int(11) NOT NULL,
  `head_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense_head`
--

INSERT INTO `expense_head` (`serial_no`, `head_name`) VALUES
(2, 'Buy something'),
(3, 'sell Something');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `serial_no` int(11) NOT NULL,
  `invoice_option` varchar(255) DEFAULT NULL,
  `client_option` varchar(255) DEFAULT NULL,
  `office_account_no` varchar(255) DEFAULT NULL,
  `office_organization_name` varchar(255) DEFAULT NULL,
  `office_bank_name` varchar(255) DEFAULT NULL,
  `office_branch_name` varchar(255) DEFAULT NULL,
  `new_client_name` varchar(255) DEFAULT NULL,
  `new_organization_name` varchar(255) DEFAULT NULL,
  `new_address` varchar(255) DEFAULT NULL,
  `new_phone_no` varchar(255) DEFAULT NULL,
  `net_total` varchar(255) DEFAULT NULL,
  `vat` varchar(255) DEFAULT NULL,
  `vat_amount` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `discount_amount` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `pay` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `invoice_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`serial_no`, `invoice_option`, `client_option`, `office_account_no`, `office_organization_name`, `office_bank_name`, `office_branch_name`, `new_client_name`, `new_organization_name`, `new_address`, `new_phone_no`, `net_total`, `vat`, `vat_amount`, `discount`, `discount_amount`, `grand_total`, `pay`, `due`, `invoice_date`) VALUES
(1, 'Sell Invoice', 'New Client', '', '', '', '', 'Md. Abul Khair Sohag', 'TRT ', 'asd', 'asd', '100', '0', '0', '0', '0', '100', '10', '100', '11-07-2019'),
(2, 'Sell Invoice', 'Office Account', '12326562306595451', 'SattIt', 'UCB Bank', 'Mohakhali branch', '', '', '', '', '100', '0', '0', '0', '0', '100', '20', '100', '16-07-2019'),
(3, 'Buy Invoice', 'Office Account', '12326562306595451', 'SattIt', 'UCB Bank', 'Mohakhali branch', '', '', '', '', '1000', '0', '0', '0', '0', '1000', '30', '1000', '16-07-2019'),
(4, 'Buy Invoice', 'Office Account', '12326562306595451', 'SattIt', 'UCB Bank', 'Mohakhali branch', '', '', '', '', '10200', '0', '0', '0', '0', '10200', '40', '10200', '16-07-2019'),
(5, 'Buy Invoice', 'Office Account', '12326562306595451', 'SattIt', 'UCB Bank', 'Mohakhali branch', '', '', '', '', '20201', '0', '0', '0', '0', '20201', '40', '20201', '20-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_expense`
--

CREATE TABLE `invoice_expense` (
  `serial_no` int(11) NOT NULL,
  `invoice_serial_no` int(11) NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_expense`
--

INSERT INTO `invoice_expense` (`serial_no`, `invoice_serial_no`, `service`, `description`, `unit`, `quantity`, `price`, `total`) VALUES
(2, 1, 'sdf', 'asd', 'ads', '010', '010', '100'),
(3, 1, 'ds', 'sdf', 'sdf', '0', '0', '0'),
(4, 2, 'sell', 'sss', '2121', '10', '10', '100'),
(5, 3, 'sell', 'fsdf', 'sdf', '10', '100', '1000'),
(6, 4, 'software edit', 'Dealer Mangement System', 'dd', '10', '1010', '10100'),
(7, 4, 'software edit', '10', '10', '100', '01', '100'),
(8, 5, 'sdf', 'sdf', 'sdf', '10', '1000', '10000'),
(9, 5, '1', '0101', '1010', '0101', '0101', '10201');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`serial_no`, `name`, `username`, `password`, `email`, `role`, `user_id`, `user_type`) VALUES
(2, 'Tazbinur', 'tazbinur', '123456', 'tazbi@gmail.com', NULL, '1', 'user'),
(3, 'MD. Abu taher', 'taher', '123456', 'taher@gmail.com', 'sales man', '2', 'user'),
(5, 'Md. Abul Khair', 'sohag', '123456', 'abulkhairsohag@gmail.com', 'Delivery Man', '2', 'employee'),
(6, 'sadik', 'sadik', '123456', 'a@gmail.com', 'delivery man', '3', 'employee'),
(7, 'Motiur Rahman', 'motiur', '123456', 'abulkhairsohag@gmail.com', 'Sales Man', '4', 'employee'),
(8, 'abir', 'abir', '123456', 'a@gmail.com', 'Own Shop Employee', '5', 'employee'),
(9, 'admin', 'admin', 'admin', 'admin@gmail.com', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `market_products_return`
--

CREATE TABLE `market_products_return` (
  `serial_no` int(11) NOT NULL,
  `employee_id_delivery` varchar(255) NOT NULL,
  `employee_name_delivery` varchar(255) NOT NULL,
  `area_employee_delivery` varchar(255) NOT NULL,
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
  `unload_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market_products_return`
--

INSERT INTO `market_products_return` (`serial_no`, `employee_id_delivery`, `employee_name_delivery`, `area_employee_delivery`, `shop_name`, `shop_phn`, `products_id_no`, `products_name`, `company`, `marketing_sell_price`, `return_quantity`, `total_price`, `return_reason`, `description`, `return_date`, `unload_status`, `unload_date`) VALUES
(3, 'EMP-32619416', 'Motiur Rahman', 'Talaimari', 'sohag shop', '', 'PR-674085', 'Smart Television', 'samsung', '1', '1', '1', 'Order Minimize', '', '11-07-2019', '1', '13-07-2019'),
(4, 'EMP-88723529', 'Md. Abul Khair', 'Godagari', 'sohag shop d', '', 'PR-965922', 'inspire 45', 'dell', '1', '10', '10', 'Close Shop', '', '13-07-2019', '1', '22-07-2019'),
(5, 'EMP-88723529', 'Md. Abul Khair', 'Godagari', 'asda', '', 'PR-965922', 'inspire 45', 'dell', '1', '10', '10', 'Close Shop', '', '13-07-2019', '1', '22-07-2019'),
(6, 'EMP-88723529', 'Md. Abul Khair', 'Godagari', 'dsfgsdfgsdfsdf', '', 'PR-161517', 'Samsung Galaxy j5 6', 'samsung', '10', '10', '100', 'Close Shop', '', '13-07-2019', '1', '22-07-2019'),
(7, 'EMP-88723529', 'Md. Abul Khair', 'Godagari', 'sfsdfsfsdf', '', 'PR-674085', 'Smart Television', 'samsung', '1', '10', '10', 'Manufacture Date Expire', 'Nice Loocking', '13-07-2019', '1', '22-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `new_order_details`
--

CREATE TABLE `new_order_details` (
  `serial_no` int(11) NOT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) NOT NULL,
  `area_employee` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `net_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `vat_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `discount_amount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `pay` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `order_date` varchar(255) NOT NULL,
  `delivery_report` varchar(255) NOT NULL,
  `delivery_cancel_report` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_order_details`
--

INSERT INTO `new_order_details` (`serial_no`, `employee_id`, `employee_name`, `area_employee`, `company`, `order_no`, `shop_name`, `address`, `mobile_no`, `net_total`, `vat`, `vat_amount`, `discount`, `discount_amount`, `grand_total`, `pay`, `due`, `order_date`, `delivery_report`, `delivery_cancel_report`) VALUES
(3, 'EMP-88723529', 'Md. Abul Khair', 'Talaimari ', '', 'ORDER-6058633', 'sohag shop', 'Godagari,Rajshahi,Bangladesh', '01753474401', '130', '0', '0', '0', '0', '130', '0', '130', '10-07-2019', '0', '0'),
(11, '', 'Md.Abul Khair', '', '', 'ORDER-4863913', 'sadf', 'sad', 'asd', '2', '0', '0', '0', '0', '2', '0', '2', '11-07-2019', '0', '0'),
(12, 'EMP-32619416', 'Motiur Rahman', 'Godagari', '', 'ORDER-0470510', 'kanak Shop', 'godagari', '20857520201', '110', '10', '11', '10', '11', '110', '10', '100', '13-07-2019', '1', '0'),
(13, 'EMP-32619416', 'Motiur Rahman', 'Godagari', '', 'ORDER-4069220', 'sohag shop', 'Rajshahi', '01753474401', '55', '0', '0', '0', '0', '55', '50', '5', '13-07-2019', '0', '1'),
(14, 'EMP-32619416', 'Motiur Rahman', 'Godagari', '', 'ORDER-5581731', 'sdfs', 'sdfs', 'sf', '200', '0', '0', '0', '0', '200', '160', '40', '25-07-2019', '1', '0'),
(15, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(16, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(17, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(18, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(19, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(20, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(21, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(22, '', '', '', '', 'ORDER-5309130', '', '', '', '300', '0', '0', '0', '0', '300', '0', '300', '28-07-2019', '0', '0'),
(23, 'EMP-32619416', 'Motiur Rahman', 'Godagari', '', 'ORDER-6674039', '10', '10', '10', '200', '1', '2', '0', '0', '202', '0', '202', '29-07-2019', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `new_order_expense`
--

CREATE TABLE `new_order_expense` (
  `serial_no` int(11) NOT NULL,
  `new_order_serial_no` varchar(255) NOT NULL,
  `products_id_no` varchar(255) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `sell_price` varchar(255) NOT NULL,
  `mrp_price` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `promo_offer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_order_expense`
--

INSERT INTO `new_order_expense` (`serial_no`, `new_order_serial_no`, `products_id_no`, `products_name`, `category`, `quantity`, `sell_price`, `mrp_price`, `total_price`, `promo_offer`) VALUES
(21, '3', 'PR-674085', 'Smart Television', 'Television', '10', '1', '0', '10', '----'),
(22, '3', 'PR-674085', 'Smart Television', 'Television', '10', '1', '0', '10', '----'),
(23, '3', 'PR-674085', 'Smart Television', 'Television', '10', '1', '0', '10', '----'),
(24, '3', 'PR-598527', 'smart watch', 'Electronics', '10', '10', '10', '100', '----'),
(31, '11', 'PR-674085', 'Smart Television', 'Television', '2', '1', '0', '2', '----'),
(32, '12', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10', '10', '10', '100', '----'),
(33, '12', 'PR-014453', 'DMS software', 'Electronics', '10', '0', '1', '0', '----'),
(34, '12', 'PR-674085', 'Smart Television', 'Television', '10', '1', '0', '10', '----'),
(35, '13', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '5', '10', '10', '50', '----'),
(36, '13', 'PR-014453', 'DMS software', 'Electronics', '5', '0', '1', '0', '----'),
(37, '13', 'PR-965922', 'inspire 45', 'Laptop', '5', '1', '0', '5', '----'),
(38, '14', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10', '10', '10', '100', '----'),
(39, '14', 'PR-014453', 'DMS software', 'Electronics', '10', '10', '1', '100', '----'),
(40, '15', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(41, '15', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(42, '16', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(43, '16', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(44, '17', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(45, '17', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(46, '18', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(47, '18', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(48, '19', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(49, '19', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(50, '20', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(51, '20', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(52, '21', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(53, '21', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(54, '22', 'PR-014453', 'DMS software', '', '10', '10', '1', '100', '----'),
(55, '22', 'PR-161517', 'Samsung Galaxy j5 6', '', '20', '10', '10', '200', '----'),
(58, '23', 'PR-161517', 'Samsung Galaxy j5 6', '', '10', '10', '10', '100', '----'),
(59, '23', 'PR-965922', 'inspire 45', '', '10', '10', '0', '100', '----');

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery`
--

CREATE TABLE `order_delivery` (
  `serial_no` int(11) NOT NULL,
  `order_tbl_serial_no` varchar(255) NOT NULL,
  `delivery_employee_id` varchar(255) NOT NULL,
  `delivery_employee_name` varchar(255) NOT NULL,
  `order_employee_id` varchar(255) NOT NULL,
  `order_employee_name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `net_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `vat_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `discount_amount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `pay` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `order_date` varchar(255) NOT NULL,
  `delivery_date` varchar(255) NOT NULL,
  `delivery_month` varchar(255) DEFAULT NULL,
  `own_shop` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_delivery`
--

INSERT INTO `order_delivery` (`serial_no`, `order_tbl_serial_no`, `delivery_employee_id`, `delivery_employee_name`, `order_employee_id`, `order_employee_name`, `area`, `company`, `order_no`, `shop_name`, `address`, `mobile_no`, `net_total`, `vat`, `vat_amount`, `discount`, `discount_amount`, `grand_total`, `pay`, `due`, `order_date`, `delivery_date`, `delivery_month`, `own_shop`) VALUES
(10, '12', 'EMP-88723529', 'Md. Abul Khair', 'EMP-32619416', 'Motiur Rahman', 'Godagari', '', 'ORDER-0470510', 'kanak Shop', 'godagari', '20857520201', '110', '10', '11', '10', '11', '110', '10', '100', '13-07-2019', '13-07-2019', '07-2019', '0'),
(12, '14', 'EMP-88723529', 'Md. Abul Khair', 'EMP-32619416', 'Motiur Rahman', 'Godagari', '', 'ORDER-5581731', 'sdfs', 'sdfs', 'sf', '200', '0', '0', '0', '0', '200', '160', '40', '25-07-2019', '25-07-2019', '07-2019', '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_expense`
--

CREATE TABLE `order_delivery_expense` (
  `serial_no` int(11) NOT NULL,
  `delivery_tbl_serial_no` varchar(255) NOT NULL,
  `order_tbl_serial_no` varchar(255) NOT NULL,
  `products_id_no` varchar(255) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `sell_price` varchar(255) NOT NULL,
  `mrp_price` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `promo_offer` varchar(255) NOT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_delivery_expense`
--

INSERT INTO `order_delivery_expense` (`serial_no`, `delivery_tbl_serial_no`, `order_tbl_serial_no`, `products_id_no`, `products_name`, `category`, `quantity`, `sell_price`, `mrp_price`, `total_price`, `promo_offer`, `date`) VALUES
(19, '10', '12', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10', '10', '10', '100', '----', '15-7-2019'),
(20, '10', '12', 'PR-161517', 'DMS software', 'Electronics', '10', '10', '1', '0', '----', '15-07-2019'),
(21, '10', '12', 'PR-674085', 'Smart Television', 'Television', '10', '1', '0', '10', '----', '17-07-2019'),
(24, '12', '14', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10', '10', '10', '100', '----', '25-07-2019'),
(25, '12', '14', 'PR-014453', 'DMS software', 'Electronics', '10', '10', '1', '100', '----', '25-07-2019');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `own_shop_client`
--

INSERT INTO `own_shop_client` (`serial_no`, `client_name`, `address`, `mobile_no`, `email`) VALUES
(1, 'Abul Khair Sohag', 'jhgjk hjgjh jg ugyurrsyh tydjhderys', '01753474401', 'sohag@gmail.com'),
(2, 'kanak', 'Kumar para', '017562', 'kanak@gmail.com'),
(5, 'sohag', 'asfsdfsd', 'fsafdaa', '');

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
(0, 'EMP-02236552', 'Abir', '21', 'a@gmail.com', '231', 'Active', '30-07-2019', '30-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_sell`
--

CREATE TABLE `own_shop_sell` (
  `serial_no` int(11) NOT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `net_total` varchar(255) DEFAULT NULL,
  `vat` varchar(255) DEFAULT NULL,
  `vat_amount` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `discount_amount` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `pay` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `sell_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `own_shop_sell`
--

INSERT INTO `own_shop_sell` (`serial_no`, `order_no`, `employee_id`, `employee_name`, `customer_id`, `customer_name`, `mobile_no`, `net_total`, `vat`, `vat_amount`, `discount`, `discount_amount`, `grand_total`, `pay`, `due`, `sell_date`) VALUES
(9, 'ORDER-6085023', 'EMP-02236552', 'abir', '-1', 'sohag', '01753474401', '200', '0', '0', '0', '0', '200', '150', '50', '31-07-2019'),
(10, 'ORDER-9958782', 'EMP-02236552', 'abir', '1', 'Abul Khair Sohag', '01753474401', '300', '10', '30', '10', '30', '300', '300', '0', '31-07-2019'),
(11, 'ORDER-4349413', 'EMP-02236552', 'abir', '2', 'kanak', '017562', '250', '0', '0', '0', '0', '250', '250', '0', '31-07-2019'),
(12, 'ORDER-2692427', 'EMP-02236552', 'abir', '1', 'Abul Khair Sohag', '01753474401', '200', '0', '0', '0', '0', '200', '150', '50', '31-07-2019'),
(13, 'ORDER-1950713', 'EMP-02236552', 'abir', '1', 'Abul Khair Sohag', '01753474401', '320', '0', '0', '0', '0', '320', '320', '0', '31-07-2019'),
(14, 'ORDER-0933742', 'EMP-02236552', 'abir', '1', 'Abul Khair Sohag', '01753474401', '200', '0', '0', '0', '0', '200', '100', '100', '31-07-2019'),
(15, 'ORDER-0209921', 'EMP-02236552', 'abir', '-1', '', '', '140', '0', '0', '0', '0', '140', '0', '140', '31-07-2019'),
(16, 'ORDER-0857628', 'EMP-02236552', 'abir', '-1', '', '', '100', '0', '0', '0', '0', '100', '0', '100', '31-07-2019'),
(17, 'ORDER-1090221', 'EMP-02236552', 'abir', '-1', '', '', '100', '0', '0', '0', '0', '100', '0', '100', '31-07-2019'),
(18, 'ORDER-8808613', 'EMP-02236552', 'abir', '-1', '', '', '50', '0', '0', '0', '0', '50', '50', '0', '31-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `own_shop_sell_product`
--

CREATE TABLE `own_shop_sell_product` (
  `serial_no` int(11) NOT NULL,
  `sell_tbl_id` varchar(255) DEFAULT NULL,
  `products_id_no` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `sell_price` varchar(255) DEFAULT NULL,
  `mrp_price` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `promo_offer` varchar(255) DEFAULT NULL,
  `sell_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `own_shop_sell_product`
--

INSERT INTO `own_shop_sell_product` (`serial_no`, `sell_tbl_id`, `products_id_no`, `products_name`, `quantity`, `sell_price`, `mrp_price`, `total_price`, `promo_offer`, `sell_date`) VALUES
(36, '9', 'PR-014453', 'DMS software', '10', '10', '1', '100', '----', '31-07-2019'),
(37, '9', 'PR-674085', 'Smart Television', '10', '10', '0', '100', '----', '31-07-2019'),
(38, '10', 'PR-161517', 'Samsung Galaxy j5 6', '10', '10', '10', '100', '----', '31-07-2019'),
(39, '10', 'PR-674085', 'Smart Television', '20', '10', '0', '200', '----', '31-07-2019'),
(40, '11', 'PR-965922', 'inspire 45', '10', '10', '0', '100', '----', '31-07-2019'),
(41, '11', 'PR-674085', 'Smart Television', '15', '10', '0', '150', '----', '31-07-2019'),
(42, '12', 'PR-014453', 'DMS software', '10', '10', '1', '100', '----', '31-07-2019'),
(43, '12', 'PR-674085', 'Smart Television', '10', '10', '0', '100', '----', '31-07-2019'),
(44, '13', 'PR-014453', 'DMS software', '10', '10', '1', '100', '----', '31-07-2019'),
(45, '13', 'PR-965922', 'inspire 45', '10', '10', '0', '100', '----', '31-07-2019'),
(46, '13', 'PR-674085', 'Smart Television', '12', '10', '0', '120', '----', '31-07-2019'),
(47, '14', 'PR-965922', 'inspire 45', '10', '10', '0', '100', '----', '31-07-2019'),
(48, '14', 'PR-674085', 'Smart Television', '10', '10', '0', '100', '----', '31-07-2019'),
(49, '15', 'PR-161517', 'Samsung Galaxy j5 6', '12', '10', '10', '120', '----', '31-07-2019'),
(50, '15', 'PR-674085', 'Smart Television', '2', '10', '0', '20', '----', '31-07-2019'),
(51, '16', 'PR-014453', 'DMS software', '10', '10', '1', '100', '----', '31-07-2019'),
(52, '17', 'PR-161517', 'Samsung Galaxy j5 6', '10', '10', '10', '100', '----', '31-07-2019'),
(53, '18', 'PR-161517', 'Samsung Galaxy j5 6', '5', '10', '10', '50', '----', '31-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `serial_no` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(92, 'order_list'),
(93, 'order_view_button'),
(94, 'order_edit_button'),
(95, 'order_delete_button'),
(96, 'order_delivery'),
(97, 'deliver_order_button'),
(98, 'save_deliver_order_button'),
(99, 'cancel_order_button'),
(100, 'delivery_pending'),
(101, 'view_pending_order_info_button'),
(102, 'delivery_complete'),
(103, 'view_delivery_complete_info_button'),
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
(160, 'product_report'),
(161, 'transport_report'),
(162, 'market_report'),
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
(177, 'own_shop_customer_delete_button');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `serial_no` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `products_id_no` varchar(255) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `company_price` varchar(255) DEFAULT NULL,
  `dealer_price` varchar(255) NOT NULL,
  `marketing_sell_price` varchar(255) NOT NULL,
  `mrp_price` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `promo_offer` varchar(255) DEFAULT NULL,
  `offer_start_date` varchar(255) DEFAULT NULL,
  `offer_end_date` varchar(255) DEFAULT NULL,
  `product_photo` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `stock_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`serial_no`, `company`, `products_id_no`, `products_name`, `category`, `weight`, `color`, `company_price`, `dealer_price`, `marketing_sell_price`, `mrp_price`, `quantity`, `promo_offer`, `offer_start_date`, `offer_end_date`, `product_photo`, `description`, `stock_date`) VALUES
(1, 'samsung', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10', '10', '5', '10', '10', '10', 25, '', '', '', 'product_photo/a6c26dc3ba.jpg', '', '10-07-2019'),
(2, 'dell', 'PR-965922', 'inspire 45', 'Laptop', '10', '10', '5', '10', '10', '0', 90, '', '', '', 'product_photo/ef1df9a986.jpg', '', '10-07-2019'),
(3, 'sattit', 'PR-014453', 'DMS software', 'Electronics', '10', '10', '5', '10', '10', '1', 62, '', '', '', 'product_photo/4d93c06c9f.jpg', '', '10-07-2019'),
(4, 'samsung', 'PR-674085', 'Smart Television', 'Television', '10', '10', '5', '10', '10', '0', 11, '', '', '', 'product_photo/fa2e755a23.png', '', '10-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE `product_stock` (
  `serial_no` int(11) NOT NULL,
  `company_product_return_id` varchar(255) DEFAULT '0',
  `products_id_no` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `stock_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_stock`
--

INSERT INTO `product_stock` (`serial_no`, `company_product_return_id`, `products_id_no`, `quantity`, `stock_date`) VALUES
(1, '0', 'PR-161517', 10, '10-07-2019'),
(2, '0', 'PR-965922', 100, '10-07-2019'),
(3, '0', 'PR-014453', 100, '10-07-2019'),
(4, '0', 'PR-674085', 100, '10-07-2019'),
(7, '0', 'PR-674085', 20, '10-07-2019'),
(8, '0', 'PR-674085', 80, '10-07-2019'),
(9, '0', 'PR-014453', 150, '10-07-2019'),
(10, '0', 'PR-965922', 20, '10-07-2019'),
(11, '0', 'PR-161517', 90, '10-07-2019'),
(12, '1', 'PR-161517', -10, '10-07-2019'),
(13, '2', 'PR-014453', -50, '10-07-2019'),
(14, '3', 'PR-674085', -100, '10-07-2019'),
(16, '0', 'PR-161517', 10, '10-07-2019'),
(18, '0', 'PR-674085', 9, '11-07-2019'),
(19, '0', 'PR-674085', 4, '13-07-2019'),
(20, '5', 'PR-014453', -10, '13-07-2019');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`serial_no`, `organization_name`, `address`, `mobile_no`, `phone_no`, `email`, `website`, `api_url`, `license_code`, `favicon`, `logo`) VALUES
(1, 'SATT IT', 'Manik Mia Road, Talaimari, Rajshahi', '0185054500', '5212054', 'info@sattit.com', 'www.sattit.com', '54sd5fs5', '5415sad15', 'favicon/8e756db285.jpg', 'logo/abec678b5d.png');

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
  `paid_amount` varchar(255) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `next_paid_date` varchar(255) DEFAULT NULL,
  `receive_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receive`
--

INSERT INTO `receive` (`serial_no`, `receive_type`, `client_name`, `organization_name`, `address`, `mobile_no`, `invoice_docs_no`, `total_amount`, `paid_amount`, `due_amount`, `description`, `next_paid_date`, `receive_date`) VALUES
(1, 'wewe', 'rwerwer', 'wer', 'werwe', '21', 'sdf', '100', '100', '0', '', '31-07-19', '31-07-2019');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `serial_no` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`serial_no`, `role_name`) VALUES
(2, 'Sales Man'),
(5, 'Delivery Man'),
(6, 'Own Shop Employee'),
(7, 'System User Accountant'),
(8, 'System user Product Manager');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `role_serial_no` varchar(255) NOT NULL,
  `permission_serial_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`role_serial_no`, `permission_serial_no`) VALUES
('5', '90'),
('5', '96'),
('5', '97'),
('5', '98'),
('5', '99'),
('5', '106'),
('5', '107'),
('5', '108'),
('5', '109'),
('5', '110'),
('2', '90'),
('2', '91'),
('2', '92'),
('2', '93'),
('2', '94'),
('2', '95'),
('2', '106'),
('2', '107'),
('2', '108'),
('2', '109'),
('2', '110'),
('6', '58'),
('6', '59'),
('6', '60'),
('6', '61'),
('6', '62'),
('6', '63'),
('6', '64'),
('7', '111'),
('7', '112'),
('7', '113'),
('7', '114'),
('7', '115'),
('7', '116'),
('7', '117'),
('7', '118'),
('7', '119'),
('7', '120'),
('7', '121'),
('7', '122'),
('7', '123'),
('7', '124'),
('7', '125'),
('7', '126'),
('7', '127'),
('7', '128'),
('7', '129'),
('7', '130'),
('7', '131'),
('7', '132'),
('7', '133'),
('7', '134'),
('7', '135'),
('7', '136'),
('7', '137'),
('7', '138'),
('7', '139'),
('7', '140'),
('7', '141'),
('7', '142'),
('7', '143'),
('7', '144'),
('7', '145'),
('7', '146'),
('7', '147'),
('7', '148'),
('7', '149'),
('7', '150'),
('7', '151'),
('7', '152'),
('7', '153'),
('7', '154'),
('7', '155'),
('7', '156'),
('7', '157'),
('8', '76'),
('8', '77'),
('8', '78'),
('8', '79'),
('8', '80'),
('8', '81'),
('8', '82'),
('8', '83'),
('8', '84'),
('8', '85'),
('8', '86'),
('8', '87'),
('8', '88'),
('8', '89');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`serial_no`, `vehicle_name`, `type`, `reg_no`, `engine_no`, `insurance_no`, `driver_name`, `license_no`, `owner_type`) VALUES
(1, 'desh travels', 'Bush', '542152413021324', '4545', '15123154185', 'Md. Abu Taher ', '45487878', 'Self'),
(3, 'Sohag truck', 'Truck', '54215241302132421', '150cc', '15123154185edit', 'Md. Abul Khair', 'fgddf', 'Self'),
(4, 'National Travels', 'Bush', '542152413021324145', '14', '15123154185', 'sohag', 'sihab2010', 'Self'),
(5, 'Sadharon Paribaan', 'truck', '2132123123123', '32151231321', '2151234152', 'sakil', '3545615', 'Rent');

-- --------------------------------------------------------

--
-- Table structure for table `truck_load`
--

CREATE TABLE `truck_load` (
  `serial_no` int(11) NOT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `emplyee_name` varchar(255) DEFAULT NULL,
  `vehicle_reg_no` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `loading_date` varchar(255) DEFAULT NULL,
  `order_numbers` varchar(255) DEFAULT NULL,
  `unload_status` varchar(255) NOT NULL DEFAULT '0',
  `unload_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `truck_load`
--

INSERT INTO `truck_load` (`serial_no`, `area_name`, `employee_id`, `emplyee_name`, `vehicle_reg_no`, `vehicle_name`, `vehicle_type`, `loading_date`, `order_numbers`, `unload_status`, `unload_date`) VALUES
(2, 'Godagari', 'EMP-32619416', 'Motiur Rahman', '542152413021324', 'desh travels', 'Bush', '10-07-2019', 'ORDER-4686842, ORDER-5802119', '1', '12-07-2019'),
(3, 'Talaimari ', 'EMP-88723529', 'Md. Abul Khair', '54215241302132415454', 'desh travels', 'Bush', '11-07-2019', 'ORDER-6347211', '1', '10-07-2019'),
(4, 'Godagari', 'EMP-88723529', 'Md. Abul Khair', '54215241302132421', 'Sohag truck', 'Truck', '13-07-2019', 'ORDER-0470510, ORDER-4069220', '0', NULL);

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
  `quantity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `truck_loaded_products`
--

INSERT INTO `truck_loaded_products` (`serial_no`, `truck_load_tbl_id`, `product_id`, `products_name`, `category`, `quantity`) VALUES
(1, '1', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10'),
(2, '1', 'PR-014453', 'DMS software', 'Electronics', '10'),
(3, '1', 'PR-598527', 'smart watch', 'Electronics', '10'),
(4, '2', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '10'),
(5, '2', 'PR-014453', 'DMS software', 'Electronics', '20'),
(6, '2', 'PR-598527', 'smart watch', 'Electronics', '20'),
(7, '2', 'PR-965922', 'inspire 45', 'Laptop', '10'),
(8, '3', 'PR-014453', 'DMS software', 'Electronics', '20'),
(9, '3', 'PR-674085', 'Smart Television', 'Television', '10'),
(10, '4', 'PR-161517', 'Samsung Galaxy j5 6', 'Mobile Phone', '15'),
(11, '4', 'PR-014453', 'DMS software', 'Electronics', '15'),
(12, '4', 'PR-674085', 'Smart Television', 'Television', '10'),
(13, '4', 'PR-965922', 'inspire 45', 'Laptop', '5');

-- --------------------------------------------------------

--
-- Table structure for table `truck_unloaded_products`
--

CREATE TABLE `truck_unloaded_products` (
  `serial_no` int(11) NOT NULL,
  `truck_load_tbl_id` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `products_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `loaded_qty` varchar(255) DEFAULT NULL,
  `sold_qty` varchar(255) DEFAULT NULL,
  `unload_qty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `truck_unloaded_products`
--

INSERT INTO `truck_unloaded_products` (`serial_no`, `truck_load_tbl_id`, `product_id`, `products_name`, `category`, `loaded_qty`, `sold_qty`, `unload_qty`) VALUES
(1, '2', 'PR-014453', 'DMS software', 'Electronics', '20', '0', '20'),
(2, '2', 'PR-674085', 'Smart Television', 'Television', '10', '0', '10');

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
(1, 'Tazbinur', 'Cashier', '01753454401', 'Talaimari, Rajshahi.', 'tazbi@gmail.com', 'tazbinur', 'tazbinur'),
(2, 'MD. Abu taher', 'Manager', '01760989288', 'Godagari,Rajshahi,Bangladesh', 'taher@gmail.com', 'taher', 'taher');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_role`
--

CREATE TABLE `user_has_role` (
  `role_serial_no` varchar(255) NOT NULL,
  `user_serial_no` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_has_role`
--

INSERT INTO `user_has_role` (`role_serial_no`, `user_serial_no`, `user_type`) VALUES
('2', '3', 'employee'),
('1', '2', 'user'),
('2', '4', 'employee'),
('5', '2', 'employee'),
('6', '5', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `serial_no` int(11) NOT NULL,
  `zone_name` varchar(255) DEFAULT NULL,
  `thana_name` varchar(255) DEFAULT NULL,
  `line_route` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`serial_no`, `zone_name`, `thana_name`, `line_route`) VALUES
(2, 'Alupotti', 'Boalia', ''),
(3, 'a', 'a', 'a'),
(4, 'b', 'b', 'b'),
(5, 'c', 'c', 'c');

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
-- Indexes for table `new_order_details`
--
ALTER TABLE `new_order_details`
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `new_order_expense`
--
ALTER TABLE `new_order_expense`
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
  ADD PRIMARY KEY (`serial_no`);

--
-- Indexes for table `own_shop_client`
--
ALTER TABLE `own_shop_client`
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
-- Indexes for table `permission`
--
ALTER TABLE `permission`
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
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `area_zone`
--
ALTER TABLE `area_zone`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank_deposite`
--
ALTER TABLE `bank_deposite`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bank_loan`
--
ALTER TABLE `bank_loan`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank_loan_pay`
--
ALTER TABLE `bank_loan_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bank_withdraw`
--
ALTER TABLE `bank_withdraw`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_category`
--
ALTER TABLE `client_category`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_commission`
--
ALTER TABLE `company_commission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_products_return`
--
ALTER TABLE `company_products_return`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_employee`
--
ALTER TABLE `delivery_employee`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `due_payment_invoice`
--
ALTER TABLE `due_payment_invoice`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_academic_info`
--
ALTER TABLE `employee_academic_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `employee_commission`
--
ALTER TABLE `employee_commission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_document_info`
--
ALTER TABLE `employee_document_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_duty`
--
ALTER TABLE `employee_duty`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_main_info`
--
ALTER TABLE `employee_main_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_payments`
--
ALTER TABLE `employee_payments`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_head`
--
ALTER TABLE `expense_head`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_expense`
--
ALTER TABLE `invoice_expense`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `market_products_return`
--
ALTER TABLE `market_products_return`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `new_order_details`
--
ALTER TABLE `new_order_details`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `new_order_expense`
--
ALTER TABLE `new_order_expense`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `order_delivery`
--
ALTER TABLE `order_delivery`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_delivery_expense`
--
ALTER TABLE `order_delivery_expense`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `own_shop_client`
--
ALTER TABLE `own_shop_client`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `own_shop_sell`
--
ALTER TABLE `own_shop_sell`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `own_shop_sell_product`
--
ALTER TABLE `own_shop_sell_product`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receive`
--
ALTER TABLE `receive`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `truck_load`
--
ALTER TABLE `truck_load`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `truck_loaded_products`
--
ALTER TABLE `truck_loaded_products`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `truck_unloaded_products`
--
ALTER TABLE `truck_unloaded_products`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
