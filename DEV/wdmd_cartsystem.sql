-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2013 at 03:05 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wdmd_cartsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_lvls`
--

CREATE TABLE IF NOT EXISTS `access_lvls` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `access_lvls`
--

INSERT INTO `access_lvls` (`level_id`, `name`) VALUES
(1, 'Customer'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `addresses_shipping`
--

CREATE TABLE IF NOT EXISTS `addresses_shipping` (
  `address_id` int(11) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(9) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE IF NOT EXISTS `ordered_items` (
  `ordered_item_id` int(11) NOT NULL,
  `itemlist_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`ordered_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `itemlist_id` int(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `shipping_cost` decimal(10,0) NOT NULL,
  `tax_cost` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description_short` varchar(255) NOT NULL,
  `description_long` mediumtext NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image_path` varchar(256) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description_short`, `description_long`, `price`, `image_path`, `stock`) VALUES
(5, 'Banana', 'A tasty banana', 'This banana is ripe and delicious.', 1, 'banana', 10),
(4, 'Fedora', 'Cool hat', 'This hat is the pimp shiz', 20, 'fedora', 0),
(1, '25 Texts', 'Buy 25 texts', 'Today is your lucky day! With the 25 texts package, we should be able to get you a date this weekend instead of eating Cheetos and deleting your browser history.', 25, '25texts', -1),
(2, '50 Texts', 'Buy 50 texts', 'After this package of 50 texts, you shouldn''t be going home alone at least one night in the near future.', 50, '50texts', -1),
(3, '100 Texts', 'Buy 100 texts', 'Ready to settle down? Find the one you would really like to see everyday for the rest of your life, pick up this package, and you are set for eternity!', 100, '100texts', -1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_costs`
--

CREATE TABLE IF NOT EXISTS `shipping_costs` (
  `shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` decimal(10,0) NOT NULL,
  PRIMARY KEY (`shipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address_shipping` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(10) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(12) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
