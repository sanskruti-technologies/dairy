-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2020 at 09:50 AM
-- Server version: 5.7.26-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-11+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vammadairy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer` varchar(150) NOT NULL,
  `order_period` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `is_cart_checkout` int(1) NOT NULL,
  `cart_user` varchar(50) NOT NULL,
  `order_book` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart_detail`
--

CREATE TABLE `cart_detail` (
  `cart_detail_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `rate` float NOT NULL,
  `amount` float NOT NULL,
  `gst_rate` varchar(25) NOT NULL,
  `gst_amount` float NOT NULL,
  `grand_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(25) NOT NULL,
  `customer_type` varchar(25) NOT NULL,
  `customer_group` varchar(25) NOT NULL,
  `username` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erpnext_sync_config`
--

CREATE TABLE `erpnext_sync_config` (
  `config_id` int(11) NOT NULL,
  `config_key` varchar(150) NOT NULL,
  `config_value` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `item_group` varchar(500) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `standard_rate` float NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_groups`
--

CREATE TABLE `item_groups` (
  `item_group_id` int(11) NOT NULL,
  `item_group_name` varchar(50) NOT NULL,
  `parent_item_group` varchar(50) DEFAULT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_tax_template`
--

CREATE TABLE `item_tax_template` (
  `item_tax_id` int(11) NOT NULL,
  `item_tax_name` varchar(50) NOT NULL,
  `item_tax_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_tax_template_detail`
--

CREATE TABLE `item_tax_template_detail` (
  `item_tax_detail_id` int(11) NOT NULL,
  `item_tax_id` int(11) NOT NULL,
  `item_tax` varchar(50) NOT NULL,
  `item_tax_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `doctype_name` varchar(50) NOT NULL,
  `user_type` varchar(50) DEFAULT NULL,
  `adress_name` varchar(50) NOT NULL,
  `address_type` varchar(50) NOT NULL,
  `address_line1` varchar(50) NOT NULL,
  `address_line2` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`cart_detail_id`);

INSERT INTO `users` (`user_id`, `username`, `first_name`, `middle_name`, `name`, `email`, `last_name`, `mobile_no`, `doctype_name`, `user_type`, `adress_name`, `address_type`, `address_line1`, `address_line2`, `city`, `country`, `address`) VALUES
(1, 'dharadshah', 'Dhara', NULL, 'dharadshah@gmail.com', 'dharadshah@gmail.com', 'Shah', NULL, 'HR-EMP-00047', 'Employee', '', '', '', '', '', '', 'Address Line 1,\nAddress Line 2,\nSurat'),
(2, 'gajendra', 'Gajendra', NULL, 'gajendranishad1432@gmail.com', 'gajendranishad1432@gmail.com', 'Nishad', NULL, 'GAIA', 'Employee', 'Gajendra - Billing', 'Office', 'Address Line 1', 'Address Line 2', 'Surat', 'India', NULL),
(3, 'distributer', 'Distributer', NULL, 'test@smb.com', NULL, 'Test', NULL, 'test SMB', 'Customer', '', '', '', '', '', '', NULL);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `erpnext_sync_config`
--
ALTER TABLE `erpnext_sync_config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_groups`
--
ALTER TABLE `item_groups`
  ADD PRIMARY KEY (`item_group_id`);

--
-- Indexes for table `item_tax_template`
--
ALTER TABLE `item_tax_template`
  ADD PRIMARY KEY (`item_tax_id`);

--
-- Indexes for table `item_tax_template_detail`
--
ALTER TABLE `item_tax_template_detail`
  ADD PRIMARY KEY (`item_tax_detail_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cart_detail`
--
ALTER TABLE `cart_detail`
  MODIFY `cart_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `erpnext_sync_config`
--
ALTER TABLE `erpnext_sync_config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `item_groups`
--
ALTER TABLE `item_groups`
  MODIFY `item_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `item_tax_template`
--
ALTER TABLE `item_tax_template`
  MODIFY `item_tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `item_tax_template_detail`
--
ALTER TABLE `item_tax_template_detail`
  MODIFY `item_tax_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
