-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 11:19 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CART_ID` int(11) NOT NULL,
  `C_ID` int(11) NOT NULL,
  `I_CODE` varchar(20) NOT NULL,
  `QTY` int(11) NOT NULL DEFAULT 1,
  `ADDED_DATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CART_ID`, `C_ID`, `I_CODE`, `QTY`, `ADDED_DATE`) VALUES
(2, 222, '227', 1, '2026-06-29 17:31:04'),
(4, 222, '147', 1, '2026-06-29 19:40:59'),
(5, 222, '163', 2, '2026-06-29 19:41:43'),
(8, 223, '258', 1, '2026-06-30 15:10:08'),
(9, 223, '118', 1, '2026-06-30 15:10:13'),
(10, 224, '260', 1, '2026-06-30 15:56:44'),
(14, 226, '261', 1, '2026-06-30 18:20:53'),
(15, 226, '262', 1, '2026-06-30 18:20:56'),
(17, 225, '118', 1, '2026-06-30 19:58:45'),
(18, 225, '107', 1, '2026-06-30 19:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CAT_ID` int(11) NOT NULL,
  `CAT_NAM` varchar(25) NOT NULL,
  `CAT_IMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CAT_ID`, `CAT_NAM`, `CAT_IMAGE`) VALUES
(1, 'MOBILE', 'mobile.jpg'),
(2, 'FURNITURE', 'fur.jpg'),
(3, 'WATCH', 'wat.jpg'),
(4, 'ELECTRONICS', 'ele.jpg'),
(5, 'VEHICLES', 'veh.jpg'),
(6, 'PROPERTIES', 'prop.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `C_ID` int(5) NOT NULL,
  `C_NAME` varchar(255) DEFAULT NULL,
  `C_PASS` varchar(255) DEFAULT NULL,
  `C_EMAIL` varchar(255) DEFAULT NULL,
  `C_MOB` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`C_ID`, `C_NAME`, `C_PASS`, `C_EMAIL`, `C_MOB`) VALUES
(186, 'RENISH', '1', 'rita.s.kotecha@gmail.com', '7862953955'),
(209, 'tiya m modha', '$2y$10$i9uG0MpjUrSaq5VDmUC1Bu8KCgMY2etHaZLKPyEeSJrYYUib9M0ru', 'tiya@gmail.com', '9913462663'),
(210, 'delina M Dabhi', 'Delina@12#12', 'delu@gmail.com', '8795678956'),
(211, 'Haniya H Joshi', 'Haniya@123', 'haniya@gmail.com', '8795678956'),
(220, 'avni M modha', '$2y$10$bu3c8P9i6f8PTUWp0hCJdu5JCCk71d8C5PbZfXdxci15q2/L.6WbK', 'avni@gmail.com', '9265555826'),
(221, 'Hema M Modha', '$2y$10$TnVpS8TqD0edEQTBwQ6Gv.gjYyDTc0FY7yXvxQXJaOvvAiL7g0uLy', 'hema@gmail.com', '8795678956'),
(222, 'Krinshi S Kotiya', '$2y$10$bAL.pY7dGn6kX1.P8JWPLuHsVZolyJ1.2crYVcl4rk/oyxdQy4uFe', 'krinshi@gmail.com', '8795678956'),
(223, 'Holi M sharma', '$2y$10$YFP0vLy/kpZUn7pTJQ.yfunU18GQNMZ7ZSZDfA1lLoY2hmF6MUHLW', 'holi@gmail.com', '8795678956'),
(224, 'Aelina J makwana', '$2y$10$K1nGJFbLqOEmjvYrXZPUEej7UEeM1ANhazH6LLPaYOnwTA.4C1P9O', 'aelina@gmail.com', '8795678956'),
(225, 'Honey M jungi', '$2y$10$k1hjr8XBHtq4LE83FnXhFOmFjcJLwO8ujSfqSCM4xOZUwO1DVb.fS', 'honeyy@gmail.com', '9265555826');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `I_CODE` int(255) NOT NULL,
  `C_ID` int(255) NOT NULL,
  `CAT_NAM` varchar(50) DEFAULT NULL,
  `I_NAME` varchar(100) DEFAULT NULL,
  `I_IMAGE` varchar(100) NOT NULL,
  `I_DATE` date DEFAULT NULL,
  `I_PRICE` decimal(10,2) DEFAULT NULL,
  `SELL_STATUS` varchar(1) NOT NULL,
  `DES` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`I_CODE`, `C_ID`, `CAT_NAM`, `I_NAME`, `I_IMAGE`, `I_DATE`, `I_PRICE`, `SELL_STATUS`, `DES`) VALUES
(8, 104, 'MOBILE', 'oppo 13pro', 'oppo.jpg', '2024-08-03', 15000.00, 'Y', 'its oppo mobile'),
(9, 105, 'MOBILE', 'vivo', 'vivo.jpg', '0000-00-00', 20000.00, 'N', 'its vivo phone'),
(10, 106, 'MOBILE', 'motorola', 'moto.jpg', '2023-05-23', 18000.00, 'N', 'hello moto.'),
(11, 107, 'MOBILE', 'iphone', 'iph.jpg', '2026-01-22', 45000.00, 'N', 'iphone '),
(12, 108, 'MOBILE', 'hawai', 'hawai.jpg', '2025-11-05', 35000.00, 'N', 'hawai phone'),
(13, 109, 'MOBILE', 'mi', 'mi.jpg', '2023-05-23', 20000.00, 'N', 'mi phones '),
(14, 110, 'MOBILE', 'nokia', 'nokia.jpg', '2022-08-12', 5000.00, 'N', 'its old.'),
(16, 112, 'MOBILE', 'realme', 'real.jpg', '2024-08-11', 20000.00, 'N', 'its realme'),
(101, 0, 'Wooden Chair', 'chair1.jpg', '2020', '0000-00-00', 0.00, 'C', 'chair'),
(105, 105, 'FURNITURE', 'Bed king size', 'bed.jpg', '2026-05-02', 200000.00, 'n', 'king size wooden bed .'),
(106, 106, 'FURNITURE', 'Office Chair', 'chair2.jpg', '2026-05-03', 3500.00, 'n', 'Adjustable office chair'),
(107, 107, 'FURNITURE', 'Study Table', 'table2.jpg', '2026-05-03', 4000.00, 'n', 'Compact study table'),
(109, 109, 'FURNITURE', 'Coffee Table', 'table3.jpg', '2026-05-04', 2500.00, 'n', 'Small coffee table'),
(110, 110, 'FURNITURE', 'Bookshelf', 'shelf1.jpg', '2026-05-05', 3000.00, 'n', 'Wooden bookshelf'),
(111, 111, 'FURNITURE', 'TV Unit', 'tvunit1.jpg', '2026-05-05', 5000.00, 'n', 'Modern TV unit'),
(112, 112, 'FURNITURE', 'Recliner Chair', 'chair3.jpg', '2026-05-06', 8000.00, 'n', 'Comfortable recliner'),
(117, 117, 'FURNITURE', 'Folding Table', 'table5.jpg', '2026-05-08', 2200.00, 'n', 'Portable folding table'),
(118, 115, 'FURNITURE', 'Wooden Bench', 'wood.jpg', '2025-01-01', 3200.00, 'N', 'strong wooden bench for sitting.'),
(119, 115, 'FURNITURE', 'Corner sofa', 'cor.jpg', '2023-05-23', 18000.00, 'n', 'L shape sofa.'),
(120, 117, 'FURNITURE', 'Computer table', 'comp.jpg', '2023-05-23', 5000.00, 'n', 'Computer table'),
(121, 113, 'MOBILE', 'NexaCore X1', 'nex.jpg', '2022-09-11', 10000.00, 'N', 'its unique phone.'),
(122, 114, 'MOBILE', 'Vortex Prime Z', 'vor.jpg', '2022-04-16', 10000.00, 'Y', 'its unique phone.'),
(123, 115, 'MOBILE', 'Lumina Edge Pro', 'lum.jpg', '2021-01-11', 12000.00, 'N', 'its unique phone.'),
(124, 116, 'MOBILE', 'Zenith Nova 5G', 'nova.jpg', '2024-05-22', 9000.00, 'N', 'its unique phone.'),
(125, 201, 'WATCHE', 'ChronoX Classic', 'watch1.jpg', '2022-03-15', 4500.00, 'N', 'Elegant classic analog watch.'),
(126, 202, 'WATCHE', 'Titanium Sport Fit', 'watch2.jpg', '2023-06-10', 7200.00, 'N', 'Durable sports watch with modern design.'),
(127, 203, 'WATCHE', 'Luxe Gold Edition', 'watch3.jpg', '2021-11-05', 15000.00, 'N', 'Premium gold finish luxury watch.'),
(128, 204, 'WATCHE', 'Aero Digital X', 'watch4.jpg', '2024-01-20', 3800.00, 'N', 'Lightweight digital watch with LED display.'),
(129, 205, 'WATCHE', 'SmartPulse Z', 'watch5.jpg', '2023-08-12', 9800.00, 'N', 'Smartwatch with heart rate and fitness tracking.'),
(130, 206, 'WATCHE', 'Vintage Leather Dial', 'watch6.jpg', '2022-09-30', 5200.00, 'N', 'Stylish leather strap with vintage dial.'),
(131, 207, 'WATCHE', 'Storm Resistant Pro', 'watch7.jpg', '2024-04-18', 8600.00, 'N', 'Water-resistant watch for extreme conditions.'),
(132, 208, 'WATCHE', 'Minimal Edge Slim', 'watch8.jpg', '2021-07-22', 3000.00, 'N', 'Ultra-slim minimalist design watch.'),
(133, 201, 'WATCH', 'ChronoX Classic', 'watch1.jpg', '2022-03-15', 4500.00, 'N', 'Elegant classic analog watch.'),
(134, 202, 'WATCH', 'Titanium Sport Fit', 'watch2.jpg', '2023-06-10', 7200.00, 'N', 'Durable sports watch with modern design.'),
(135, 203, 'WATCH', 'Luxe Gold Edition', 'watch3.jpg', '2021-11-05', 15000.00, 'N', 'Premium gold finish luxury watch.'),
(136, 204, 'WATCH', 'Aero Digital X', 'watch4.jpg', '2024-01-20', 3800.00, 'N', 'Lightweight digital watch with LED display.'),
(137, 205, 'WATCH', 'SmartPulse Z', 'watch5.jpg', '2023-08-12', 9800.00, 'N', 'Smartwatch with heart rate and fitness tracking.'),
(138, 206, 'WATCH', 'Vintage Leather Dial', 'watch6.jpg', '2022-09-30', 5200.00, 'N', 'Stylish leather strap with vintage dial.'),
(139, 207, 'WATCH', 'Storm Resistant Pro', 'watch7.jpg', '2024-04-18', 8600.00, 'N', 'Water-resistant watch for extreme conditions.'),
(140, 208, 'WATCH', 'Minimal Edge Slim', 'watch8.jpg', '2021-07-22', 3000.00, 'N', 'Ultra-slim minimalist design watch.'),
(145, 213, 'WATCH', 'Leather Strap Old', 'watch13.jpg', '2020-09-30', 1100.00, 'N', 'Used leather strap watch, decent condition.'),
(146, 214, 'WATCH', 'Refit Slim Watch', 'watch14.jpg', '2021-06-14', 1300.00, 'N', 'Refitted slim watch, lightweight and clean.'),
(147, 215, 'WATCH', 'Vintage Mini Dial', 'watch15.jpg', '2018-12-01', 1000.00, 'N', 'Vintage small dial watch, pre-owned.'),
(148, 216, 'WATCH', 'Secondhand Sport Lite', 'watch16.jpg', '2022-03-22', 1400.00, 'N', 'Lightweight sports watch, used condition.'),
(149, 301, 'ELECTRONICS', 'Smart LED TV 32\"', 'tv1.jpg', '2023-01-12', 14500.00, 'N', 'HD ready smart LED TV with apps support.'),
(150, 302, 'ELECTRONICS', 'Bluetooth Speaker Mini', 'speaker1.jpg', '2022-11-05', 1200.00, 'N', 'Portable speaker with deep bass.'),
(151, 303, 'ELECTRONICS', 'Wireless Headphones X', 'headphone1.jpg', '2024-02-18', 2500.00, 'N', 'Comfortable wireless headphones with noise isolation.'),
(152, 304, 'ELECTRONICS', 'USB Power Bank 10000mAh', 'powerbank1.jpg', '2023-06-22', 900.00, 'N', 'Fast charging portable power bank.'),
(153, 305, 'ELECTRONICS', 'Gaming Mouse RGB', 'mouse1.jpg', '2024-03-10', 700.00, 'N', 'Ergonomic gaming mouse with RGB lights.'),
(154, 306, 'ELECTRONICS', 'Mechanical Keyboard Lite', 'keyboard1.jpg', '2023-08-14', 1800.00, 'N', 'Compact mechanical keyboard with backlight.'),
(155, 307, 'ELECTRONICS', 'HD Webcam Pro', 'webcam1.jpg', '2022-09-19', 1600.00, 'N', '1080p webcam for video calls and streaming.'),
(159, 311, 'ELECTRONICS', 'Mini Home Projector', 'projector1.jpg', '2023-07-25', 5500.00, 'N', 'Compact projector for home entertainment.'),
(160, 312, 'ELECTRONICS', 'WiFi Router Dual Band', 'router1.jpg', '2024-04-02', 2800.00, 'N', 'High-speed dual band wireless router.'),
(161, 313, 'ELECTRONICS', 'External Hard Drive 1TB', 'hdd1.jpg', '2023-10-11', 4200.00, 'N', 'Portable 1TB storage device.'),
(162, 314, 'ELECTRONICS', 'USB Flash Drive 64GB', 'usb1.jpg', '2022-08-30', 500.00, 'N', 'Compact high-speed USB storage.'),
(163, 315, 'ELECTRONICS', 'Laptop Cooling Pad', 'coolpad1.jpg', '2024-02-05', 750.00, 'N', 'Cooling stand for laptops with fan support.'),
(164, 401, 'VEHICLE', 'Maruti Suzuki Alto 800', 'car1.jpg', '2018-05-10', 180000.00, 'N', 'Used Alto in good condition with mileage.'),
(165, 402, 'VEHICLE', 'Honda Activa 5G', 'scooter1.jpg', '2019-07-18', 45000.00, 'N', 'Reliable scooter, well maintained.'),
(166, 403, 'VEHICLE', 'Hero Splendor Plus', 'bike1.jpg', '2017-03-22', 38000.00, 'N', 'Fuel efficient bike, secondhand.'),
(167, 404, 'VEHICLE', 'Hyundai i10 Magna', 'car2.jpg', '2016-11-30', 220000.00, 'N', 'Compact car, good city usage.'),
(168, 405, 'VEHICLE', 'Bajaj Pulsar 150', 'bike2.jpg', '2018-08-14', 55000.00, 'N', 'Sporty bike in decent condition.'),
(169, 406, 'VEHICLE', 'TVS Jupiter', 'scooter2.jpg', '2020-01-05', 52000.00, 'N', 'Smooth scooter with good pickup.'),
(170, 407, 'VEHICLE', 'Honda City 2015', 'car3.jpg', '2015-09-09', 350000.00, 'N', 'Premium sedan, second owner.'),
(171, 408, 'VEHICLE', 'Royal Enfield Classic 350', 'bike3.jpg', '2017-06-25', 110000.00, 'N', 'Well maintained classic bike.'),
(172, 409, 'VEHICLE', 'Tata Nano CX', 'car4.jpg', '2014-04-11', 90000.00, 'N', 'Budget small car, used.'),
(173, 410, 'VEHICLE', 'Suzuki Access 125', 'scooter3.jpg', '2019-10-20', 48000.00, 'N', 'Comfortable scooter, good condition.'),
(174, 411, 'VEHICLE', 'Mahindra Bolero 2016', 'car5.jpg', '2016-12-02', 420000.00, 'N', 'Strong SUV, used for rural roads.'),
(175, 412, 'VEHICLE', 'KTM Duke 200', 'bike4.jpg', '2018-02-15', 95000.00, 'N', 'Performance bike, secondhand.'),
(176, 413, 'VEHICLE', 'Hyundai Eon Era', 'car6.jpg', '2015-07-07', 160000.00, 'N', 'Small hatchback, economical.'),
(177, 414, 'VEHICLE', 'Hero HF Deluxe', 'bike5.jpg', '2017-01-19', 30000.00, 'N', 'Basic commuter bike, low cost.'),
(178, 415, 'VEHICLE', 'TVS Apache RTR 160', 'bike6.jpg', '2019-03-28', 65000.00, 'N', 'Sport bike, good performance.'),
(179, 401, 'VEHICLES', 'Maruti Suzuki Alto 800', 'car1.jpg', '2018-05-10', 180000.00, 'N', 'Used Alto in good condition with mileage.'),
(181, 403, 'VEHICLES', 'Hero Splendor Plus', 'bike1.jpg', '2017-03-22', 38000.00, 'N', 'Fuel efficient bike, secondhand.'),
(183, 405, 'VEHICLES', 'Bajaj Pulsar 150', 'bike2.jpg', '2018-08-14', 55000.00, 'N', 'Sporty bike in decent condition.'),
(184, 406, 'VEHICLES', 'TVS Jupiter', 'scooter2.jpg', '2020-01-05', 52000.00, 'N', 'Smooth scooter with good pickup.'),
(185, 407, 'VEHICLES', 'Honda City 2015', 'car3.jpg', '2015-09-09', 350000.00, 'N', 'Premium sedan, second owner.'),
(186, 408, 'VEHICLES', 'Royal Enfield Classic 350', 'bike3.jpg', '2017-06-25', 110000.00, 'N', 'Well maintained classic bike.'),
(187, 409, 'VEHICLES', 'Tata Nano CX', 'car4.jpg', '2014-04-11', 90000.00, 'N', 'Budget small car, used.'),
(188, 410, 'VEHICLES', 'Suzuki Access 125', 'scooter3.jpg', '2019-10-20', 48000.00, 'N', 'Comfortable scooter, good condition.'),
(189, 411, 'VEHICLES', 'Mahindra Bolero 2016', 'car5.jpg', '2016-12-02', 420000.00, 'N', 'Strong SUV, used for rural roads.'),
(190, 412, 'VEHICLES', 'KTM Duke 200', 'bike4.jpg', '2018-02-15', 95000.00, 'N', 'Performance bike, secondhand.'),
(191, 413, 'VEHICLES', 'Hyundai Eon Era', 'car6.jpg', '2015-07-07', 160000.00, 'N', 'Small hatchback, economical.'),
(192, 414, 'VEHICLES', 'Hero HF Deluxe', 'bike5.jpg', '2017-01-19', 30000.00, 'N', 'Basic commuter bike, low cost.'),
(194, 401, 'VEHICAL', 'Maruti Suzuki Alto 800', 'car1.jpg', '2018-05-10', 180000.00, 'N', 'Used Alto in good condition with mileage.'),
(195, 402, 'VEHICAL', 'Honda Activa 5G', 'scooter1.jpg', '2019-07-18', 45000.00, 'N', 'Reliable scooter, well maintained.'),
(196, 403, 'VEHICAL', 'Hero Splendor Plus', 'bike1.jpg', '2017-03-22', 38000.00, 'N', 'Fuel efficient bike, secondhand.'),
(198, 405, 'VEHICAL', 'Bajaj Pulsar 150', 'bike2.jpg', '2018-08-14', 55000.00, 'N', 'Sporty bike in decent condition.'),
(205, 412, 'VEHICAL', 'KTM Duke 200', 'bike4.jpg', '2018-02-15', 95000.00, 'N', 'Performance bike, secondhand.'),
(206, 413, 'VEHICAL', 'Hyundai Eon Era', 'car6.jpg', '2015-07-07', 160000.00, 'N', 'Small hatchback, economical.'),
(207, 414, 'VEHICAL', 'Hero HF Deluxe', 'bike5.jpg', '2017-01-19', 30000.00, 'N', 'Basic commuter bike, low cost.'),
(209, 115, 'VEHICAL', 'cycle', 'cycle.jpg', '2023-05-23', 500.00, 'N', 'Newly secondhand cycle.'),
(210, 501, 'PROPERTIES', 'Small 1BHK House', 'house1.jpg', '2015-06-12', 450000.00, 'N', 'Used 1BHK house in decent condition.'),
(211, 502, 'PROPERTIES', 'Old 2BHK Flat', 'flat1.jpg', '2014-09-20', 650000.00, 'N', 'Secondhand 2BHK flat, budget friendly.'),
(212, 503, 'PROPERTIES', 'Village Small House', 'house2.jpg', '2013-03-15', 300000.00, 'N', 'Affordable village house, used.'),
(213, 504, 'PROPERTIES', '1RK Budget Room', 'room1.jpg', '2018-11-10', 200000.00, 'N', 'Small 1RK room, low price.'),
(214, 505, 'PROPERTIES', 'Old Shop Space', 'shop1.jpg', '2012-07-25', 350000.00, 'N', 'Used shop space in local area.'),
(215, 506, 'PROPERTIES', '2BHK Old House', 'house3.jpg', '2016-02-18', 700000.00, 'N', 'Spacious but old 2BHK house.'),
(216, 507, 'PROPERTIES', 'Small Office Room', 'office1.jpg', '2017-08-05', 400000.00, 'N', 'Compact office space, secondhand.'),
(217, 508, 'PROPERTIES', 'Old Farm Land', 'land1.jpg', '2010-01-30', 500000.00, 'N', 'Agricultural land at low price.'),
(222, 513, 'PROPERTIES', 'Village Farm House', 'house4.jpg', '2012-06-11', 420000.00, 'N', 'Simple farmhouse in village area.'),
(223, 514, 'PROPERTIES', 'Budget Rental Room', 'room2.jpg', '2018-01-28', 180000.00, 'N', 'Cheap rental room, resale.'),
(224, 515, 'PROPERTIES', 'Old 3BHK House', 'house5.jpg', '2014-03-03', 850000.00, 'N', 'Large 3BHK house, used condition.'),
(225, 516, 'PROPERTIES', 'Small Corner Shop', 'shop2.jpg', '2016-09-16', 300000.00, 'N', 'Corner shop space, budget deal.'),
(226, 115, 'MOBILE', 'LAVA', 'lava.jpg', '2025-01-01', 15000.00, 'N', 'lava lelo.'),
(227, 116, 'MOBILE', 'Nothing', 'not.jpg', '2026-04-24', 25000.00, 'N', 'its newly phone'),
(230, 173, 'Select main category', '', 'img/230 doodle.png', '0000-00-00', 0.00, 'N', ''),
(235, 173, 'Select main category', '', 'img/235 back.jpg', '0000-00-00', 0.00, 'N', ''),
(236, 173, 'Select main category', '', 'img/236ele.jpg', '0000-00-00', 0.00, 'N', ''),
(238, 173, 'Select main category', '', 'img/238Avatar.jpeg', '0000-00-00', 0.00, 'N', ''),
(251, 208, 'MOBILE', 'Oppo Reno 5', 'opporeno.jpg ', '0000-00-00', 12000.00, 'N', 'new feature era'),
(258, 212, 'FURNITURE', 'stool', 'table5.jpg', '0000-00-00', 1000.00, 'N', 'stool.'),
(260, 212, 'VEHICLES', 'access 25', 'scooter2.jpg', '0000-00-00', 80000.00, 'N', 'scooty'),
(261, 209, 'VEHICLES', 'helicoptor', '-', '0000-00-00', 2000000.00, 'N', 'new item'),
(262, 209, 'VEHICLES', 'Fortune car', 'Avatar.jpeg', '0000-00-00', 200000.00, 'N', 'car'),
(263, 219, 'ELECTRONICS', 'photo Frame lightning', 'logooo.jpg', '0000-00-00', 400.00, 'N', 'new light frame'),
(264, 219, 'ELECTRONICS', 'hair dryer', 'hdd1.jpg', '0000-00-00', 1000.00, 'N', 'new item');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `O_ID` int(11) NOT NULL,
  `O_DATE` date DEFAULT NULL,
  `B_ID` int(11) DEFAULT NULL,
  `S_ID` int(11) DEFAULT NULL,
  `I_CODE` int(11) DEFAULT NULL,
  `O_PRICE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`O_ID`, `O_DATE`, `B_ID`, `S_ID`, `I_CODE`, `O_PRICE`) VALUES
(1, '0000-00-00', 186, 1, 2, 18000),
(2, '0000-00-00', 187, 103, 7, 35000),
(3, '0000-00-00', 208, 104, 8, 15000),
(4, '0000-00-00', 208, 187, 243, 20000),
(6, '0000-00-00', 208, 114, 122, 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CART_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CAT_ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`C_ID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`I_CODE`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`O_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CART_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CAT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `C_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `I_CODE` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `O_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
