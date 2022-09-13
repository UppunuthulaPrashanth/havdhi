-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2021 at 06:46 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aspersa9_otes`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(10) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `vendor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `description`, `vendor_id`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 0),
(5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 1),
(6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 5),
(7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 45),
(8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 49),
(9, 'We are india\'s largest market platform for Spas and Beauty parlours', 52),
(10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 21),
(11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum laoreet augue eu porttitor. Curabitur varius velit sed enim semper lobortis. In congue rutrum sem vitae tristique. Nam fermentum semper elit, nec euismod metus malesuada vel. Morbi sit amet nulla aliquam, pulvinar nisl vel, tincidunt diam. Mauris nisl sem, volutpat non arcu quis, porttitor tristique leo. Praesent at pretium metus. Cras sit amet porttitor diam.', 4);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `admin_phone` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `admin_image`, `admin_phone`, `admin_email`, `admin_pass`) VALUES
(1, 'digambar singh', 'images/admin/profile/23-07-19/230719014721pm-activity.png', '8476978906', 'support@analogit.com', '$2y$10$.sOI9/OUKDrJOyNvFnecCO16nw89ekZ6TIC7.P2NHinRmrkTRpVIS');

-- --------------------------------------------------------

--
-- Table structure for table `admin_banner`
--

CREATE TABLE `admin_banner` (
  `banner_id` int(11) NOT NULL,
  `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_for`
--

CREATE TABLE `cancel_for` (
  `res_id` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cancel_for`
--

INSERT INTO `cancel_for` (`res_id`, `reason`) VALUES
(1, 'not available in town'),
(2, 'changed my mind');

-- --------------------------------------------------------

--
-- Table structure for table `cancel_reason`
--

CREATE TABLE `cancel_reason` (
  `reason_id` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cancel_reason`
--

INSERT INTO `cancel_reason` (`reason_id`, `reason`) VALUES
(2, 'shifted to another society.'),
(3, 'Order Placed Wrongly');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `city_image` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cityadmin`
--

CREATE TABLE `cityadmin` (
  `cityadmin_id` int(11) NOT NULL,
  `city_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n/a',
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cityadmin`
--

INSERT INTO `cityadmin` (`cityadmin_id`, `city_id`, `cityadmin_name`, `cityadmin_image`, `cityadmin_phone`, `cityadmin_email`, `cityadmin_pass`, `cityadmin_address`, `lat`, `lng`, `device_id`, `created_at`, `updated_at`) VALUES
(16, '15', 'Test admi', 'cityadmin_img/images/08-10-2020/081020025247pm-220920054850pm-delivery.png', '8090908080', 'test@test.com', '$2y$10$frhGsSpyft4y5/8xi7l3weQdhzM/d1ZNJu7DAaTYJv/NsY0W3FN.C', 'Visakhapatnam International Airport (VTZ), NH 45, Visakhapatnam, Andhra Pradesh, India', '17.728425', '83.223417', 'n/a', '08-10-2020 02:52 pm', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `cookies_policy`
--

CREATE TABLE `cookies_policy` (
  `id` int(11) NOT NULL,
  `cookies_policy` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_cookies_policy` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cookies_policy`
--

INSERT INTO `cookies_policy` (`id`, `cookies_policy`, `en_cookies_policy`) VALUES
(1, '<b>Cookies Policy</b>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `country_code`
--

CREATE TABLE `country_code` (
  `code_id` int(11) NOT NULL,
  `country_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_code`
--

INSERT INTO `country_code` (`code_id`, `country_code`) VALUES
(1, 91);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(100) NOT NULL,
  `coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `cart_value` int(100) NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uses_restriction` int(11) NOT NULL DEFAULT '1',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `en_coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_coupon_description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_vendor`
--

CREATE TABLE `coupon_vendor` (
  `coupon_vendor_id` int(10) NOT NULL,
  `coupon_id` int(10) NOT NULL,
  `vendor_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_sign` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency`, `currency_sign`) VALUES
(1, 'Rupee', '₹');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_answer` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `question`, `answer`, `en_question`, `en_answer`) VALUES
(2, 'How to subscribe a product ?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less.', NULL, NULL),
(5, 'test', 'test', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fcm_key`
--

CREATE TABLE `fcm_key` (
  `unique_id` int(200) NOT NULL,
  `user_app_key` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_app_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fcm_key`
--

INSERT INTO `fcm_key` (`unique_id`, `user_app_key`, `vendor_app_key`) VALUES
(1, 'AAAAc68KAUA:APA91bFA1Gwk6Xxlbw_DgsWEiPVoh6v9eWxIWq2TEbcJFPi63VcV7fi8kuQ_2MUnfv8-uQ49rOgRvsI12gTyo5_iDHWzihOIJAsjozcI363KCFIoGP5MOtbWt1F9bGQJCbEO44pa7FtM', 'AAAAc68KAUA:APA91bFA1Gwk6Xxlbw_DgsWEiPVoh6v9eWxIWq2TEbcJFPi63VcV7fi8kuQ_2MUnfv8-uQ49rOgRvsI12gTyo5_iDHWzihOIJAsjozcI363KCFIoGP5MOtbWt1F9bGQJCbEO44pa7FtM');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `vendor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `google_translate_api`
--

CREATE TABLE `google_translate_api` (
  `id` int(11) NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `google_translate_api`
--

INSERT INTO `google_translate_api` (`id`, `api_key`) VALUES
(1, '1eb1462b68mdcdsf5f818a87bd4c26jsn22fbfd32875d');

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `lang_id` int(11) NOT NULL,
  `lang_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_prefix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`lang_id`, `lang_name`, `lang_prefix`) VALUES
(1, 'English', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `logo_id` int(11) NOT NULL,
  `logo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`logo_id`, `logo_name`, `logo_image`) VALUES
(1, 'GoMarket', 'logo/image/23-08-19/230819124541pm-milk-subscription.png');

-- --------------------------------------------------------

--
-- Table structure for table `mapbox`
--

CREATE TABLE `mapbox` (
  `map_id` int(11) NOT NULL,
  `mapbox_api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapbox`
--

INSERT INTO `mapbox` (`map_id`, `mapbox_api`) VALUES
(1, 'pk.eyJ1IjoidGVjbWFuaWMiLCJhIj-0=--098dsM3BxMzJvb2RmZmNzZWZyNSJ9.zo7JmhVR5yqsRSvmyiXspwtryrty');

-- --------------------------------------------------------

--
-- Table structure for table `map_api`
--

CREATE TABLE `map_api` (
  `key_id` int(11) NOT NULL,
  `map_api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_api`
--

INSERT INTO `map_api` (`key_id`, `map_api_key`) VALUES
(1, 'l9tSWxeB-Glu5orDFikU07bw83E4RSQ');

-- --------------------------------------------------------

--
-- Table structure for table `map_settings`
--

CREATE TABLE `map_settings` (
  `map_id` int(11) NOT NULL,
  `mapbox` int(11) NOT NULL,
  `google_map` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_settings`
--

INSERT INTO `map_settings` (`map_id`, `mapbox`, `google_map`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `msg91`
--

CREATE TABLE `msg91` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `msg91`
--

INSERT INTO `msg91` (`id`, `sender_id`, `api_key`, `active`) VALUES
(1, 'GOGRCK', '197064AVzt8vx55d4d55f3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rem_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_date` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_time` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1=pending,2=complete,3=payment failed, 4=cancelled, 5=cancelled by vendor, 6=Confirm',
  `order_status` int(11) DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reward_use` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reward_discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelling_reason` longtext COLLATE utf8mb4_unicode_ci,
  `share_send_status` int(11) NOT NULL DEFAULT '0' COMMENT '0= share not sent, 1= share sent',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_cart`
--

CREATE TABLE `order_cart` (
  `order_cart_id` int(11) NOT NULL,
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` int(11) NOT NULL,
  `varient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step` int(11) NOT NULL DEFAULT '0',
  `en_varient` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_service_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymentvia`
--

CREATE TABLE `paymentvia` (
  `paymentvia_id` int(11) NOT NULL,
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `payment_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paymentvia`
--

INSERT INTO `paymentvia` (`paymentvia_id`, `payment_mode`, `status`, `payment_key`) VALUES
(4, 'Razor Pay', 1, 'rzp_test_7fnnn7WTaard4h'),
(5, 'Paystack', 1, 'pk_test_f0269be01832feda8b9cce63a261770ecd249f77');

-- --------------------------------------------------------

--
-- Table structure for table `payment_currency`
--

CREATE TABLE `payment_currency` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_currency`
--

INSERT INTO `payment_currency` (`id`, `pay_currency`) VALUES
('CAD', 'CAD'),
('HKD', 'HKD'),
('ISK', 'ISK'),
('PHP', 'PHP'),
('DKK', 'DKK'),
('HUF', 'HUF'),
('CZK', 'CZK'),
('GBP', 'GBP'),
('RON', 'RON'),
('SEK', 'SEK'),
('IDR', 'IDR'),
('INR', 'INR'),
('BRL', 'BRL'),
('RUB', 'RUB'),
('HRK', 'HRK'),
('JPY', 'JPY'),
('THB', 'THB'),
('CHF', 'CHF'),
('EUR', 'EUR'),
('MYR', 'MYR'),
('BGN', 'BGN'),
('TRY', 'TRY'),
('CNY', 'CNY'),
('NOK', 'NOK'),
('NZD', 'NZD'),
('ZAR', 'ZAR'),
('USD', 'USD'),
('MXN', 'MXN'),
('SGD', 'SGD'),
('AUD', 'AUD'),
('ILS', 'ILS'),
('KRW', 'KRW'),
('PLN', 'PLN'),
('CAD', 'CAD'),
('HKD', 'HKD'),
('ISK', 'ISK'),
('PHP', 'PHP'),
('DKK', 'DKK'),
('HUF', 'HUF'),
('CZK', 'CZK'),
('GBP', 'GBP'),
('RON', 'RON'),
('SEK', 'SEK'),
('IDR', 'IDR'),
('INR', 'INR'),
('BRL', 'BRL'),
('RUB', 'RUB'),
('HRK', 'HRK'),
('JPY', 'JPY'),
('THB', 'THB'),
('CHF', 'CHF'),
('EUR', 'EUR'),
('MYR', 'MYR'),
('BGN', 'BGN'),
('TRY', 'TRY'),
('CNY', 'CNY'),
('NOK', 'NOK'),
('NZD', 'NZD'),
('ZAR', 'ZAR'),
('USD', 'USD'),
('MXN', 'MXN'),
('SGD', 'SGD'),
('AUD', 'AUD'),
('ILS', 'ILS'),
('KRW', 'KRW'),
('PLN', 'PLN'),
('CAD', 'CAD'),
('HKD', 'HKD'),
('ISK', 'ISK'),
('PHP', 'PHP'),
('DKK', 'DKK'),
('HUF', 'HUF'),
('CZK', 'CZK'),
('GBP', 'GBP'),
('RON', 'RON'),
('SEK', 'SEK'),
('IDR', 'IDR'),
('INR', 'INR'),
('BRL', 'BRL'),
('RUB', 'RUB'),
('HRK', 'HRK'),
('JPY', 'JPY'),
('THB', 'THB'),
('CHF', 'CHF'),
('EUR', 'EUR'),
('MYR', 'MYR'),
('BGN', 'BGN'),
('TRY', 'TRY'),
('CNY', 'CNY'),
('NOK', 'NOK'),
('NZD', 'NZD'),
('ZAR', 'ZAR'),
('USD', 'USD'),
('MXN', 'MXN'),
('SGD', 'SGD'),
('AUD', 'AUD'),
('ILS', 'ILS'),
('KRW', 'KRW'),
('PLN', 'PLN'),
('CAD', 'CAD'),
('HKD', 'HKD'),
('ISK', 'ISK'),
('PHP', 'PHP'),
('DKK', 'DKK'),
('HUF', 'HUF'),
('CZK', 'CZK'),
('GBP', 'GBP'),
('RON', 'RON'),
('SEK', 'SEK'),
('IDR', 'IDR'),
('INR', 'INR'),
('BRL', 'BRL'),
('RUB', 'RUB'),
('HRK', 'HRK'),
('JPY', 'JPY'),
('THB', 'THB'),
('CHF', 'CHF'),
('EUR', 'EUR'),
('MYR', 'MYR'),
('BGN', 'BGN'),
('TRY', 'TRY'),
('CNY', 'CNY'),
('NOK', 'NOK'),
('NZD', 'NZD'),
('ZAR', 'ZAR'),
('USD', 'USD'),
('MXN', 'MXN'),
('SGD', 'SGD'),
('AUD', 'AUD'),
('ILS', 'ILS'),
('KRW', 'KRW'),
('PLN', 'PLN');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` float NOT NULL,
  `minimum_amount` float NOT NULL,
  `paid_amount` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payout_notification`
--

CREATE TABLE `payout_notification` (
  `payout_notification_id` int(10) NOT NULL,
  `vendor_id` int(10) NOT NULL,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_by_admin` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy`
--

CREATE TABLE `privacy_policy` (
  `id` int(11) NOT NULL,
  `privacy_policy` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_privacy_policy` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policy`
--

INSERT INTO `privacy_policy` (`id`, `privacy_policy`, `en_privacy_policy`) VALUES
(1, '<b>Privacy policy</b>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COD',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1- pending 2-complete 3- payment failed 4- cancelled',
  `cancelling_reason` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_order_details`
--

CREATE TABLE `product_order_details` (
  `store_order_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` datetime NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1- pending 2-complete 3- payment failed 4- cancelled',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `en_product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reedem_values`
--

CREATE TABLE `reedem_values` (
  `reedem_id` int(100) NOT NULL,
  `reward_point` int(100) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reedem_values`
--

INSERT INTO `reedem_values` (`reedem_id`, `reward_point`, `value`) VALUES
(1, 1, '0.5');

-- --------------------------------------------------------

--
-- Table structure for table `referral_points`
--

CREATE TABLE `referral_points` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `points` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referral_points`
--

INSERT INTO `referral_points` (`id`, `name`, `points`, `created_at`, `updated_at`) VALUES
(5, 'Registration Referral', '{\"min\":\"1\",\"max\":\"15\"}', '2021-12-17 09:50:21', '2021-01-25 13:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `responsive_mobile`
--

CREATE TABLE `responsive_mobile` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) NOT NULL,
  `rating` double NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `active` int(10) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_history`
--

CREATE TABLE `reward_history` (
  `reward_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` float NOT NULL,
  `reward_points` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_points`
--

CREATE TABLE `reward_points` (
  `reward_id` int(100) NOT NULL,
  `min_cart_value` int(100) NOT NULL,
  `reward_point` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_image` varchar(255) NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) NOT NULL DEFAULT 'N/A',
  `vendor_id` int(11) NOT NULL,
  `en_service_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_varient`
--

CREATE TABLE `service_varient` (
  `varient_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `varient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `time` int(11) NOT NULL DEFAULT '10',
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `en_varient` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_service_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`, `payment_currency`) VALUES
(31, 'paypal_active', 'No', '2020-11-18 13:56:42', '2021-02-15 16:32:58', 'INR'),
(32, 'paypal_email', 'deekhati63@gmail.com', '2020-11-18 13:56:42', '2021-02-08 15:59:27', NULL),
(34, 'stripe_active', 'Yes', '2020-11-18 13:56:42', '2021-02-15 16:32:58', 'INR'),
(35, 'stripe_secret_key', 'sk_test_AsWOqM4QzNC5kiiuhVaMr1mH00JC9bmg6A', '2020-11-18 13:56:42', '2021-09-07 05:35:26', NULL),
(36, 'stripe_publishable_key', 'pk_test_c0oc159sTDjBAxK4JOCpPElA00WOC6sWJq', '2020-11-18 13:56:42', '2021-09-07 05:35:26', NULL),
(38, 'razorpay_active', 'No', '2020-11-18 13:56:42', '2021-02-15 16:32:58', 'INR'),
(39, 'razorpay_key_id', 'rzp_test_5eJgxBiQclifFX', '2020-11-18 13:56:42', '2021-09-07 05:35:26', NULL),
(40, 'razorpay_secret_key', 'JmgJ4PmkG2TqCG4fBcsk15A9', '2020-11-18 13:56:42', '2021-09-07 05:35:26', NULL),
(42, 'paystack_active', 'No', '2020-11-18 13:56:42', '2021-02-15 16:32:58', 'INR'),
(43, 'paystack_public_key', 'dfssfsdfdsfasdf', '2020-11-18 13:56:42', '2021-09-07 05:35:26', NULL),
(44, 'paystack_secret_key', 'sdgdgdsg', '2020-11-18 13:56:42', '2021-09-07 05:35:26', NULL),
(61, 'paypal_client_id', 'efsdgfdhdfhfdbjjvj', '2021-02-15 16:32:58', '2021-06-19 11:54:57', NULL),
(62, 'paypal_secret_key', 'sdgdhfdhsfhhsf123', '2021-02-15 16:32:58', '2021-06-19 11:54:57', NULL),
(63, 'stripe_merchant_id', 'acct_1HzzheJi3WFPjQpE', '2021-03-11 15:44:01', '2021-09-07 05:35:26', NULL),
(64, 'paymongo_active', 'No', NULL, NULL, 'INR'),
(65, 'paymongo_secret_key', 'secret_key12345', NULL, '2021-06-19 11:54:57', NULL),
(66, 'paymongo_key_id', 'reqrqqewrewqrqrewr', NULL, '2021-06-19 11:54:57', 'INR');

-- --------------------------------------------------------

--
-- Table structure for table `shop_product`
--

CREATE TABLE `shop_product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `en_product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `smsby`
--

CREATE TABLE `smsby` (
  `by_id` int(11) NOT NULL,
  `msg91` int(11) NOT NULL DEFAULT '1',
  `twilio` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smsby`
--

INSERT INTO `smsby` (`by_id`, `msg91`, `twilio`, `status`) VALUES
(1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_api`
--

CREATE TABLE `sms_api` (
  `key_id` int(11) NOT NULL,
  `sender_id` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_api`
--

INSERT INTO `sms_api` (`key_id`, `sender_id`, `sms_api_key`) VALUES
(1, 'GBSCRB', '197064AVzt8vx55d4d55f3');

-- --------------------------------------------------------

--
-- Table structure for table `staff_profile`
--

CREATE TABLE `staff_profile` (
  `staff_id` int(10) NOT NULL,
  `staff_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(10) NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_staff_description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_review`
--

CREATE TABLE `staff_review` (
  `rev_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `review_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `plan_id` int(11) NOT NULL,
  `plans` varchar(255) NOT NULL,
  `days` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `skip_days` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support_queries`
--

CREATE TABLE `support_queries` (
  `support_id` int(11) NOT NULL,
  `phone_number` bigint(255) NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `query_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email`
--

CREATE TABLE `tbl_email` (
  `email_id` int(11) NOT NULL,
  `email_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_referral`
--

CREATE TABLE `tbl_referral` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referral_by` int(11) NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scratch_card`
--

CREATE TABLE `tbl_scratch_card` (
  `id` int(11) NOT NULL,
  `scratch_card_name` varchar(255) NOT NULL,
  `scratch_card_image` varchar(255) NOT NULL,
  `scratch_card_rewards` varchar(255) NOT NULL,
  `min_cart_value` int(11) NOT NULL,
  `use_limit` int(11) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_scratch_card`
--

CREATE TABLE `tbl_user_scratch_card` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `scratch_id` int(11) NOT NULL,
  `earning` varchar(255) CHARACTER SET utf8 NOT NULL,
  `earn_points` int(11) NOT NULL,
  `is_scratch` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `termcondition`
--

CREATE TABLE `termcondition` (
  `id` int(255) NOT NULL,
  `termcondition` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_termcondition` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `termcondition`
--

INSERT INTO `termcondition` (`id`, `termcondition`, `en_termcondition`) VALUES
(4, '<b>Scope</b>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` int(100) NOT NULL,
  `open_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `close_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `twilio`
--

CREATE TABLE `twilio` (
  `twilio_id` int(11) NOT NULL,
  `twilio_sid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twilio_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twilio_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `twilio`
--

INSERT INTO `twilio` (`twilio_id`, `twilio_sid`, `twilio_token`, `twilio_phone`, `active`) VALUES
(1, 'FdsP8Mmc90a2YDvQTOh6CA', 'SMAMPL', '+19169995023', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_credits` int(11) NOT NULL DEFAULT '0',
  `rewards` int(11) NOT NULL DEFAULT '0',
  `phone_verified` int(11) NOT NULL DEFAULT '0',
  `referral_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block` int(11) NOT NULL DEFAULT '0',
  `lat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `noti_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noti_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_by_user` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cityadmin_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_loc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `opening_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closing_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n/a',
  `comission` int(11) DEFAULT NULL,
  `delivery_range` int(11) DEFAULT '100',
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(10) DEFAULT NULL,
  `phone_verified` int(10) NOT NULL DEFAULT '0',
  `online_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ON, OFF',
  `shop_type` int(11) NOT NULL DEFAULT '3' COMMENT '1=male,2=female,3=unisex	',
  `booking_amount` float DEFAULT '0',
  `admin_approval` int(11) NOT NULL DEFAULT '1',
  `admin_share` float(12,2) NOT NULL DEFAULT '0.00',
  `en_description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_area`
--

CREATE TABLE `vendor_area` (
  `vendor_area_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `delivery_charge` int(11) NOT NULL,
  `cod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_category`
--

CREATE TABLE `vendor_category` (
  `vendor_category_id` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ui_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_notification`
--

CREATE TABLE `vendor_notification` (
  `not_id` int(11) NOT NULL,
  `not_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `not_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `read_by_vendor` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_payment`
--

CREATE TABLE `vendor_payment` (
  `payment_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `payment_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_history`
--

CREATE TABLE `wallet_history` (
  `wallet_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_recharge_history`
--

CREATE TABLE `wallet_recharge_history` (
  `wallet_recharge_history_id` int(11) NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recharge_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_recharge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wish_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `en_product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_banner`
--
ALTER TABLE `admin_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `cancel_for`
--
ALTER TABLE `cancel_for`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `cancel_reason`
--
ALTER TABLE `cancel_reason`
  ADD PRIMARY KEY (`reason_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `cityadmin`
--
ALTER TABLE `cityadmin`
  ADD PRIMARY KEY (`cityadmin_id`);

--
-- Indexes for table `cookies_policy`
--
ALTER TABLE `cookies_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_code`
--
ALTER TABLE `country_code`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `coupon_vendor`
--
ALTER TABLE `coupon_vendor`
  ADD PRIMARY KEY (`coupon_vendor_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `fcm_key`
--
ALTER TABLE `fcm_key`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_translate_api`
--
ALTER TABLE `google_translate_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`logo_id`);

--
-- Indexes for table `mapbox`
--
ALTER TABLE `mapbox`
  ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `map_api`
--
ALTER TABLE `map_api`
  ADD PRIMARY KEY (`key_id`);

--
-- Indexes for table `map_settings`
--
ALTER TABLE `map_settings`
  ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `msg91`
--
ALTER TABLE `msg91`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_cart`
--
ALTER TABLE `order_cart`
  ADD PRIMARY KEY (`order_cart_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `paymentvia`
--
ALTER TABLE `paymentvia`
  ADD PRIMARY KEY (`paymentvia_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payout_notification`
--
ALTER TABLE `payout_notification`
  ADD PRIMARY KEY (`payout_notification_id`);

--
-- Indexes for table `privacy_policy`
--
ALTER TABLE `privacy_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product_order_details`
--
ALTER TABLE `product_order_details`
  ADD PRIMARY KEY (`store_order_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reedem_values`
--
ALTER TABLE `reedem_values`
  ADD PRIMARY KEY (`reedem_id`);

--
-- Indexes for table `referral_points`
--
ALTER TABLE `referral_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responsive_mobile`
--
ALTER TABLE `responsive_mobile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_history`
--
ALTER TABLE `reward_history`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_varient`
--
ALTER TABLE `service_varient`
  ADD PRIMARY KEY (`varient_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_product`
--
ALTER TABLE `shop_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smsby`
--
ALTER TABLE `smsby`
  ADD PRIMARY KEY (`by_id`);

--
-- Indexes for table `sms_api`
--
ALTER TABLE `sms_api`
  ADD PRIMARY KEY (`key_id`);

--
-- Indexes for table `staff_profile`
--
ALTER TABLE `staff_profile`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `staff_review`
--
ALTER TABLE `staff_review`
  ADD PRIMARY KEY (`rev_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `support_queries`
--
ALTER TABLE `support_queries`
  ADD PRIMARY KEY (`support_id`);

--
-- Indexes for table `tbl_email`
--
ALTER TABLE `tbl_email`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `tbl_referral`
--
ALTER TABLE `tbl_referral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_scratch_card`
--
ALTER TABLE `tbl_scratch_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_scratch_card`
--
ALTER TABLE `tbl_user_scratch_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `termcondition`
--
ALTER TABLE `termcondition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`);

--
-- Indexes for table `twilio`
--
ALTER TABLE `twilio`
  ADD PRIMARY KEY (`twilio_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_area`
--
ALTER TABLE `vendor_area`
  ADD PRIMARY KEY (`vendor_area_id`);

--
-- Indexes for table `vendor_category`
--
ALTER TABLE `vendor_category`
  ADD PRIMARY KEY (`vendor_category_id`);

--
-- Indexes for table `vendor_notification`
--
ALTER TABLE `vendor_notification`
  ADD PRIMARY KEY (`not_id`);

--
-- Indexes for table `vendor_payment`
--
ALTER TABLE `vendor_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `wallet_history`
--
ALTER TABLE `wallet_history`
  ADD PRIMARY KEY (`wallet_id`);

--
-- Indexes for table `wallet_recharge_history`
--
ALTER TABLE `wallet_recharge_history`
  ADD PRIMARY KEY (`wallet_recharge_history_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `twilio`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `admin_banner`
--
ALTER TABLE `admin_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Indexes for table `cancel_for`
--
ALTER TABLE `cancel_for`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `cancel_reason`
--
ALTER TABLE `cancel_reason`
  MODIFY `reason_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `cityadmin`
--
ALTER TABLE `cityadmin`
  MODIFY `cityadmin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `cookies_policy`
--
ALTER TABLE `cookies_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `country_code`
--
ALTER TABLE `country_code`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `coupon_vendor`
--
ALTER TABLE `coupon_vendor`
  MODIFY `coupon_vendor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `fcm_key`
--
ALTER TABLE `fcm_key`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `google_translate_api`
--
ALTER TABLE `google_translate_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  MODIFY `logo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `mapbox`
--
ALTER TABLE `mapbox`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `map_api`
--
ALTER TABLE `map_api`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `map_settings`
--
ALTER TABLE `map_settings`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Indexes for table `msg91`
--
ALTER TABLE `msg91`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `order_cart`
--
ALTER TABLE `order_cart`
  MODIFY `order_cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `paymentvia`
--
ALTER TABLE `paymentvia`
  MODIFY `paymentvia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `payout_notification`
--
ALTER TABLE `payout_notification`
  MODIFY `payout_notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `privacy_policy`
--
ALTER TABLE `privacy_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `product_order_details`
--
ALTER TABLE `product_order_details`
  MODIFY `store_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `reedem_values`
--
ALTER TABLE `reedem_values`
  MODIFY `reedem_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `referral_points`
--
ALTER TABLE `referral_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `responsive_mobile`
--
ALTER TABLE `responsive_mobile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `reward_history`
--
ALTER TABLE `reward_history`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `service_varient`
--
ALTER TABLE `service_varient`
  MODIFY `varient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `shop_product`
--
ALTER TABLE `shop_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `smsby`
--
ALTER TABLE `smsby`
  MODIFY `by_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `sms_api`
--
ALTER TABLE `sms_api`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `staff_profile`
--
ALTER TABLE `staff_profile`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `staff_review`
--
ALTER TABLE `staff_review`
  MODIFY `rev_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `support_queries`
--
ALTER TABLE `support_queries`
  MODIFY `support_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Indexes for table `tbl_referral`
--
ALTER TABLE `tbl_referral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `tbl_scratch_card`
--
ALTER TABLE `tbl_scratch_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `tbl_user_scratch_card`
--
ALTER TABLE `tbl_user_scratch_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `termcondition`
--
ALTER TABLE `termcondition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `twilio`
--
ALTER TABLE `twilio`
  MODIFY `twilio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `vendor_area`
--
ALTER TABLE `vendor_area`
  MODIFY `vendor_area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `vendor_category`
--
ALTER TABLE `vendor_category`
  MODIFY `vendor_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `vendor_notification`
--
ALTER TABLE `vendor_notification`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `vendor_payment`
--
ALTER TABLE `vendor_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `wallet_history`
--
ALTER TABLE `wallet_history`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `wallet_recharge_history`
--
ALTER TABLE `wallet_recharge_history`
  MODIFY `wallet_recharge_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wish_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
