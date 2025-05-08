-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 06:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crazy_sale`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is-blocked` varchar(255) NOT NULL,
  `blocked_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(255) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `post_id`, `email`, `name`, `time`, `image`, `profile_pic`, `description`) VALUES
(1, '1', 'jalalsahloul81@gmail.com', '1', '1', 'apparel3.jpg', 'noprofile.jpg', '1'),
(2, '28', 'jalalsahloul81@gmail.com', 'qwe', '2024-05-22 12:44:25', 'apparel1.jpg', 'apparel1.jpg', 'fgh'),
(3, '27', 'jalalsahloul81@gmail.com', 'jalal', '2024-05-22 12:36:33', 'apparel1.jpg', 'feed-5.jpg', 'asd'),
(4, '26', 'jalalsahloul81@gmail.com', 'jalal', '2024-05-22 12:17:04', 'apparel1.jpg', 'apparel4.jpg', 'fdf');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `sizenumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `email`, `product_id`, `image`, `name`, `price`, `qty`, `size`, `sizenumber`) VALUES
(66, 'jalalsahloul80@gmail.com', '1', 'apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '', ''),
(77, 'jalalsahloul81@gmail.com', '1', 'apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shownname` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `shownname`, `image`) VALUES
(1, 'skincare', 'Skin Care', 'skincare.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(255) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `time`, `name`, `email`, `profile_pic`, `comment`) VALUES
(1, '30', '2025-05-08 15:03:22', '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1'),
(2, '30', '2025-05-08 15:03:40', '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1'),
(3, '30', '2025-05-08 15:03:49', '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1'),
(4, '30', '2025-05-08 15:04:15', '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1'),
(5, '30', '2025-05-08 15:05:07', '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `companyreviews`
--

CREATE TABLE `companyreviews` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `friend_email` varchar(255) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_email`, `friend_email`, `status`, `created_at`, `updated_at`, `username`, `lastname`, `image`) VALUES
(15, 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', 'accepted', '2024-05-25 17:25:16', '2024-05-25 17:25:16', '', '', ''),
(16, 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', 'accepted', '2024-05-25 17:25:16', '2024-05-25 17:25:16', '', '', ''),
(17, 'jalalsahloul81@gmail.com', 'jalalsahloul82@gmail.com', 'accepted', '2024-05-26 07:30:33', '2024-05-26 07:30:33', '', '', ''),
(18, 'jalalsahloul82@gmail.com', 'jalalsahloul81@gmail.com', 'accepted', '2024-05-26 07:30:33', '2024-05-26 07:30:33', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_email`, `receiver_email`, `status`, `time`) VALUES
(52, 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', 'pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `likedposts`
--

CREATE TABLE `likedposts` (
  `id` int(255) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_notifications`
--

CREATE TABLE `main_notifications` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reciever_email` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `is_read` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_notifications`
--

INSERT INTO `main_notifications` (`id`, `name`, `email`, `reciever_email`, `content`, `time`, `is_read`) VALUES
(1, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 73, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 16:58:44', '0'),
(2, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 74, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 16:58:44', '0'),
(3, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 75, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 16:58:44', '0'),
(4, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 73, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 16:59:25', '0'),
(5, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 74, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 16:59:25', '0'),
(6, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 75, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 16:59:25', '0'),
(7, 'Crazy Sale', 'crazysaleofficially.com', 'jalalsahloul81@gmail.com', 'Order Number: 76, Product Name: Black Womens Coat Dress, Quantity: 1, Subtotal: 1200. Your order has been placed successfully.', '2025-05-06 17:15:35', '0');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `read_status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `sender_email`, `receiver_email`, `lastname`, `time`, `read_status`, `image`) VALUES
(46, 'hi', 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 01:14:42', '', ''),
(47, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 01:20:10', '', ''),
(48, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 01:21:05', 'read', ''),
(49, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 01:25:48', 'read', ''),
(50, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul82@gmail.com', '', '2024-05-27 01:26:10', 'read', ''),
(51, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 01:28:44', 'read', ''),
(52, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul82@gmail.com', '', '2024-05-27 01:28:46', 'read', ''),
(53, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 01:34:54', 'read', ''),
(54, 'hi', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 01:38:05', 'read', ''),
(55, 'hi', 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 01:38:29', 'read', ''),
(56, 'hi', 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 01:39:48', 'read', ''),
(57, 'hi', 'jalalsahloul82@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 01:46:08', 'read', ''),
(58, 'hi', 'jalalsahloul82@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 01:49:54', 'read', ''),
(59, 'fg', 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 01:50:07', 'read', ''),
(60, 'gi', 'jalalsahloul82@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 02:05:32', 'read', ''),
(61, 'sdf', 'jalalsahloul82@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 02:14:34', 'read', ''),
(62, 'asdasd', 'jalalsahloul82@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 02:17:30', 'read', ''),
(63, 'asd', 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', '', '2024-05-27 02:17:46', 'read', ''),
(64, 'hgdf', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 02:19:41', 'unread', ''),
(65, 'fg', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 02:19:42', 'unread', ''),
(66, 'dfg', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2024-05-27 02:19:43', 'unread', ''),
(67, '1', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2025-05-07 15:33:13', 'unread', ''),
(68, 'd', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2025-05-08 17:42:47', 'unread', ''),
(69, 'f', 'jalalsahloul81@gmail.com', 'jalalsahloul80@gmail.com', '', '2025-05-08 18:06:05', 'unread', '');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `receiver_email`, `sender_email`, `profile_pic`, `username`, `lastname`, `content`, `time`, `status`) VALUES
(2, 'jalalsahloul81@gmail.com', '', 'noprofile.jpg', '1', '1', 'hi', '1', '1'),
(3, 'jalalsahloul81@gmail.com', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1', '', '1  commented on your post', '2025-05-08 15:05:07', 'unread'),
(4, 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', '../profileimg/noprofile.jpg', '1', '', 'You have a new friend request from 1 ', '2025-05-08 17:31:23', 'unread'),
(5, 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1', '', '1  sent you a message: d', '2025-05-08 17:42:47', 'unread'),
(6, 'jalalsahloul80@gmail.com', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1', '1', '1 1 sent you a message: f', '2025-05-08 18:06:05', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `pending`
--

CREATE TABLE `pending` (
  `id` int(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `visa_card_name` varchar(255) NOT NULL,
  `visa_card_number` varchar(255) NOT NULL,
  `visa_expiry_date` varchar(255) NOT NULL,
  `visa_CVV` varchar(255) NOT NULL,
  `master_card_name` varchar(255) NOT NULL,
  `master_card_number` varchar(255) NOT NULL,
  `master_expiry_date` varchar(255) NOT NULL,
  `master_CVV` varchar(255) NOT NULL,
  `wish_image` varchar(255) NOT NULL,
  `added_time` varchar(255) NOT NULL,
  `sizenumber` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending`
--

INSERT INTO `pending` (`id`, `product_id`, `order_number`, `image`, `name`, `price`, `qty`, `subtotal`, `email`, `first_name`, `last_name`, `street_address`, `country`, `state`, `town`, `zip_code`, `phone_number`, `payment_method`, `visa_card_name`, `visa_card_number`, `visa_expiry_date`, `visa_CVV`, `master_card_name`, `master_card_number`, `master_expiry_date`, `master_CVV`, `wish_image`, `added_time`, `sizenumber`, `size`, `status`) VALUES
(5, '1', '74', 'apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '1200', 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '2025-05-07 16:58:44', '', '0', ''),
(6, '1', '75', 'apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '1200', 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '2025-05-07 16:58:44', '', '0', ''),
(8, '1', '74', 'apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '1200', 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '2025-05-07 16:59:25', '', '0', ''),
(9, '1', '75', 'apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '1200', 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '2025-05-07 16:59:25', '', '0', ''),
(10, '1', '76', './images_products/apparel3.jpg', 'Black Womens Coat Dress', '1200', '1', '1200', 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', 'Beirut', 'Achrafieh', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '2025-05-07 17:15:35', '', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `email`, `image`, `title`, `description`, `time`, `profile_pic`) VALUES
(23, 'jalal', 'jalalsahloul81@gmail.com', 'apparel1.jpg', 'asd', 'asd', '2024-05-21 21:43:11', 'apparel4.jpg'),
(28, 'qwe', 'jalalsahloul80@gmail.com', 'apparel1.jpg', 'tyh', 'fgh', '2024-05-22 12:44:25', 'apparel1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productreviews`
--

CREATE TABLE `productreviews` (
  `id` int(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `review` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `stars` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productreviews`
--

INSERT INTO `productreviews` (`id`, `product_id`, `email`, `name`, `summary`, `review`, `date`, `stars`) VALUES
(13, '1', 'jalalsahloul81@gmail.com', '1', '1', '1', '2025-05-05', '5');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `storename` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `oprice` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `shipping` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` varchar(255) NOT NULL,
  `sold` varchar(255) NOT NULL DEFAULT '0',
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `storename`, `name`, `price`, `oprice`, `discount`, `shipping`, `image`, `stock`, `sold`, `category`, `brand`, `activity`, `material`, `gender`, `details`, `slug`, `size`) VALUES
(1, '', 'Black Womens Coat Dress', '1200', '1800', '50%', 'free shipping', 'apparel3.jpg', '2000', '0', 'makeup', 'nike', 'qwe', 'qweqw', 'e', 'asd', '', 'S; M; L; XL'),
(2, '', 'T-shirt', '1', '2', '34', 'free', 'apparel1.jpg', '30', '1', 'skincare', '', '', '', '', '', '', ''),
(3, '', '3', '3', '3', '3', '3', 'apparel4.jpg', '3', '3', 'skincare', '', '', '', '', '', '', ''),
(4, '', '4', '4', '4', '4', '4', 'apparel5.jpg', '4', '4', 'skincare', '', '', '', '', '', '', ''),
(5, '', '5', '5', '5', '5', '5', 'apparel5.jpg', '5', '5', 'skincare', '', '', '', '', '', '', ''),
(6, '', '6', '6', '6', '6', '6', 'apparel4.jpg', '6', '6', 'skincare', '', '', '', '', '', '', ''),
(7, '', '7', '7', '7', '7', '7', './img/apparel4.jpg', '7', '7', 'skincare', '', '', '', '', '', '', ''),
(8, '', '8', '8', '8', '8', '8', './img/apparel4.jpg', '8', '8', 'skincare', '', '', '', '', '', '', ''),
(9, '', '9', '9', '9', '9', '9', './img/apparel4.jpg', '9', '9', 'skincare', '', '', '', '', '', '', ''),
(10, '', '10', '10', '10', '10', '10', './img/apparel4.jpg', '10', '10', 'skincare', '', '', '', '', '', '', ''),
(11, '', '11', '11', '11', '11', '11', './img/apparel4.jpg', '11', '11', 'skincare', '', '', '', '', '', '', ''),
(12, '', '12', '12', '12', '12', '12', './img/apparel4.jpg', '12', '12', 'skincare', '', '', '', '', '', '', ''),
(13, '', '13', '13', '13', '13', '13', './img/apparel4.jpg', '13', '13', 'skincare', '', '', '', '', '', '', ''),
(14, '', '14', '14', '14', '14', '14', './img/apparel4.jpg', '14', '14', 'skincare', '', '', '', '', '', '', ''),
(15, '', '15', '15', '15', '15', '15', './img/apparel4.jpg', '15', '15', 'skincare', '', '', '', '', '', '', ''),
(16, '', '16', '16', '16', '16', '16', './img/apparel4.jpg', '16', '16', '', '', '', '', '', '', '', ''),
(17, '', '17', '17', '17', '17', '17', './img/apparel4.jpg', '17', '17', '', '', '', '', '', '', '', ''),
(18, '', '18', '18', '18', '18', '18', './img/apparel4.jpg', '18', '18', 'skincare', '', '', '', '', '', '', ''),
(30, 'username', 'username', '1', '1', '1', '', 'uploads/home4.jpg', '1', '0', 'option1', 'Brand', 'Activity', 'Material', 'Gender', 'Description', '', ''),
(31, 'username', 'username', '1', '1', '1', '', 'uploads/home1.jpg', '1', '0', 'option1', 'Brand', 'Activity', 'Material', 'Gender', 'Description', '', ''),
(40, 'usern', 'Product Name', '1', '1', '1', '', 'uploads/g1.png', '1', '0', 'option1', 'Brand', 'Activity', 'Material', 'Gender', 'Description', '', ''),
(41, 'usern', 'Product Name', '1', '1', '1', '', 'uploads/banner2.jpg', '1', '0', 'option1', 'Brand', 'Activity', 'Material', 'Gender', 'Description', '', ''),
(42, 'us', 'Product Name', '1', '1', '1', '', 'uploads/home4.jpg', '1', '0', 'option1', 'Brand', 'Activity', 'Material', 'Gender', 'Description', '', ''),
(44, 'username', '1', '1', '1', '1', '1', 'boyhats.jpg', '1', '1', '1', '1', '1', '1', '1', '1', '', ''),
(45, 'username', '1', '1', '1', '1', '1', 'boyhats.jpg', '1', '1', '1', '1', '1', '1', '1', '1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` int(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `image`) VALUES
(1, '1', 'apparel4.jpg'),
(6, '4', 'bags.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_id`, `product_id`) VALUES
(1, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `refunded`
--

CREATE TABLE `refunded` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `visa_card_name` varchar(255) DEFAULT NULL,
  `visa_card_number` varchar(25) DEFAULT NULL,
  `visa_expiry_date` varchar(10) DEFAULT NULL,
  `visa_cvv` varchar(10) DEFAULT NULL,
  `master_card_name` varchar(255) DEFAULT NULL,
  `master_card_number` varchar(25) DEFAULT NULL,
  `master_expiry_date` varchar(10) DEFAULT NULL,
  `master_cvv` varchar(10) DEFAULT NULL,
  `wish_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `sizenumber` varchar(10) DEFAULT NULL,
  `refunded_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refunded`
--

INSERT INTO `refunded` (`id`, `email`, `product_id`, `order_number`, `image`, `name`, `price`, `qty`, `subtotal`, `email_address`, `first_name`, `last_name`, `street_address`, `country`, `state`, `town`, `zip_code`, `phone_number`, `payment_method`, `visa_card_name`, `visa_card_number`, `visa_expiry_date`, `visa_cvv`, `master_card_name`, `master_card_number`, `master_expiry_date`, `master_cvv`, `wish_image`, `status`, `size`, `sizenumber`, `refunded_time`) VALUES
(1, 'jalalsahloul81@gmail.com', '1', '73', 'apparel3.jpg', 'Black Womens Coat Dress', 1200.00, 1, 1200.00, 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '', '0', '', '2025-05-06 15:15:59'),
(2, 'jalalsahloul81@gmail.com', '1', '73', 'apparel3.jpg', 'Black Womens Coat Dress', 1200.00, 1, 1200.00, 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '', '0', '', '2025-05-06 15:15:59'),
(3, 'jalalsahloul81@gmail.com', '1', '73', 'apparel3.jpg', 'Black Womens Coat Dress', 1200.00, 1, 1200.00, 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '', '0', '', '2025-05-06 15:15:59'),
(4, 'jalalsahloul81@gmail.com', '1', '73', 'apparel3.jpg', 'Black Womens Coat Dress', 1200.00, 1, 1200.00, 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '', '0', '', '2025-05-06 15:15:59'),
(7, 'jalalsahloul81@gmail.com', '1', '73', 'apparel3.jpg', 'Black Womens Coat Dress', 1200.00, 1, 1200.00, 'jalalsahloul81@gmail.com', 'Jalal', 'Sahloul', 'Bwarej', 'Lebanon', '', '', '1800', '76755421', 'cash', '', '', '', '', '', '', '', '', '', '', '0', '', '2025-05-06 15:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `slider_sales`
--

CREATE TABLE `slider_sales` (
  `id` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title1` varchar(255) NOT NULL,
  `title2` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `button_text` varchar(255) NOT NULL,
  `button_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider_sales`
--

INSERT INTO `slider_sales` (`id`, `image`, `title1`, `title2`, `subtitle`, `button_text`, `button_link`) VALUES
(3, 'slider1.jpg', '1', '1', '1', '1', '1'),
(7, 'slider0.jpg', '2', '2', '2', '2', '2'),
(8, 'slider2.jpg', '3', '3', '3', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `ownername` varchar(255) NOT NULL,
  `owneridentity` varchar(255) NOT NULL,
  `storename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `logo`, `ownername`, `owneridentity`, `storename`, `email`, `phonenumber`, `country`, `license`) VALUES
(1, 'beauty.jpg', '', '', 'username', '', '', 'LB', '');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `name`, `email`, `profile_pic`, `title`, `photo`) VALUES
(20, 'qwe', 'jalalsahloul80@gmail.com', 'apparel1.jpg', 'aSD', 'apparel1.jpg'),
(21, 'qwe', 'jalalsahloul80@gmail.com', 'apparel1.jpg', 'aSD', 'apparel2.jpg'),
(35, '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1', '681ca3a5bd325_payment-3.png'),
(36, '1', 'jalalsahloul81@gmail.com', 'noprofile.jpg', '1', '681ca3e21c240_noprofile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `story_views`
--

CREATE TABLE `story_views` (
  `id` int(255) NOT NULL,
  `story_id` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `contacts` varchar(255) NOT NULL,
  `verify_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `lastname`, `email`, `password`, `image`, `country`, `birthday`, `contacts`, `verify_status`) VALUES
(10, '1', '1', 'jalalsahloul81@gmail.com', '$2y$10$ooXXEuWioBrqF3vt8D4kuuDeKzz8i5QXBJ.aSSu471844Uc4/dKM2', 'noprofile.jpg', '', '', '', ''),
(11, '1', '1', 'jalalsahloul80@gmail.com', '$2y$10$zWmhiIlXhZiaZ90fdLrGVek2k16VcPDrdzHoOwOBgCKh0wUBhcY4u', 'noprofile.jpg', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `email`, `product_id`) VALUES
(371, 'jalalsahloul81@gmail.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companyreviews`
--
ALTER TABLE `companyreviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_friendship` (`user_email`,`friend_email`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likedposts`
--
ALTER TABLE `likedposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_notifications`
--
ALTER TABLE `main_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending`
--
ALTER TABLE `pending`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productreviews`
--
ALTER TABLE `productreviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refunded`
--
ALTER TABLE `refunded`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_sales`
--
ALTER TABLE `slider_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `story_views`
--
ALTER TABLE `story_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `companyreviews`
--
ALTER TABLE `companyreviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `likedposts`
--
ALTER TABLE `likedposts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_notifications`
--
ALTER TABLE `main_notifications`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pending`
--
ALTER TABLE `pending`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `refunded`
--
ALTER TABLE `refunded`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `slider_sales`
--
ALTER TABLE `slider_sales`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `story_views`
--
ALTER TABLE `story_views`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
