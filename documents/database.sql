-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 11, 2014 at 10:06 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `easy_paypal`
--

-- --------------------------------------------------------

--
-- Table structure for table `paypal_metadata`
--

CREATE TABLE `paypal_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `entity_name` varchar(225) NOT NULL,
  `param` varchar(1000) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `INDEX` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_transaction`
--

CREATE TABLE `paypal_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paypal_account` varchar(225) NOT NULL,
  `paypal_destination` varchar(225) NOT NULL,
  `currency` varchar(45) NOT NULL,
  `transaction_type` varchar(45) NOT NULL,
  `has_individual_items` tinyint(4) NOT NULL,
  `has_shipping` tinyint(4) NOT NULL,
  `handling_price` float NOT NULL,
  `ipn_url` varchar(1000) NOT NULL,
  `customer_success_url` varchar(1000) NOT NULL,
  `customer_cancel_url` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_transaction_item`
--

CREATE TABLE `paypal_transaction_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paypal_transaction_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `number` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_paypal_transaction_item_paypal_transaction_idx` (`paypal_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_transaction_listener`
--

CREATE TABLE `paypal_transaction_listener` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paypal_transaction_id` int(11) NOT NULL,
  `param_name` varchar(225) NOT NULL,
  `param_value` varchar(225) DEFAULT NULL,
  `listener` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_paypal_transaction_listener_paypal_transaction1_idx` (`paypal_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `paypal_transaction_item`
--
ALTER TABLE `paypal_transaction_item`
  ADD CONSTRAINT `fk_paypal_transaction_item_paypal_transaction` FOREIGN KEY (`paypal_transaction_id`) REFERENCES `paypal_transaction` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paypal_transaction_listener`
--
ALTER TABLE `paypal_transaction_listener`
  ADD CONSTRAINT `fk_paypal_transaction_listener_paypal_transaction1` FOREIGN KEY (`paypal_transaction_id`) REFERENCES `paypal_transaction` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
