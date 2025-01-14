-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 05:20 PM
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
-- Database: `projet_if3`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `id_accommodation` int(11) NOT NULL,
  `id_accommodation_list` int(11) NOT NULL,
  `accommodation_name` varchar(255) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `disponibilities` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`id_accommodation`, `id_accommodation_list`, `accommodation_name`, `amenities`, `disponibilities`) VALUES
(5, 1, 'Mercure Hotel', 'Spa', 74),
(6, 2, 'Crystal Waters Resort', 'Spa', 14),
(8, 3, 'Hut forest', 'Jacuzzi', 49),
(9, 1, 'Ibis Budget', 'Nothing, there are poor.', 24),
(10, 3, 'Center Park Adventure', 'Pool, spa, ...', 250);

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_list`
--

CREATE TABLE `accommodation_list` (
  `id_accommodation_list` int(11) NOT NULL,
  `accommodation_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation_list`
--

INSERT INTO `accommodation_list` (`id_accommodation_list`, `accommodation_type_name`) VALUES
(1, 'hotel'),
(2, 'lodging'),
(3, 'wooden_hut');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  `rating` int(5) NOT NULL,
  `comments` text NOT NULL,
  `feedback_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id_feedback`, `id_client`, `id_service`, `rating`, `comments`, `feedback_date`) VALUES
(1, 5, 2, 5, 'a\r\n', '2024-11-15'),
(2, 5, 2, 5, 'Projet galère, mais content du résultat malgré quelques trucs manquants', '2024-11-17');

-- --------------------------------------------------------

--
-- Table structure for table `history_accommodation`
--

CREATE TABLE `history_accommodation` (
  `id_accommodation_history` int(11) NOT NULL,
  `id_accommodation` int(11) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `special_request` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_accommodation`
--

INSERT INTO `history_accommodation` (`id_accommodation_history`, `id_accommodation`, `checkin_date`, `checkout_date`, `special_request`) VALUES
(1, 5, '0001-01-01', '0002-02-02', 'Nooo'),
(2, 6, '0002-02-02', '0003-03-02', 'a\r\n'),
(3, 5, '0001-01-01', '0002-02-02', 'no'),
(4, 5, '0001-01-01', '0002-02-02', 'no'),
(5, 5, '0001-01-01', '0002-02-02', 'no'),
(6, 5, '0000-00-00', '0000-00-00', ''),
(7, 5, '0000-00-00', '0000-00-00', ''),
(8, 5, '0000-00-00', '0000-00-00', ''),
(9, 5, '0000-00-00', '0000-00-00', ''),
(10, 5, '0000-00-00', '0000-00-00', ''),
(11, 5, '0000-00-00', '0000-00-00', ''),
(12, 5, '0002-02-01', '0004-03-02', 'no'),
(13, 5, '0002-02-01', '0004-03-02', 'no'),
(14, 5, '0002-02-01', '0004-03-02', 'no'),
(15, 5, '0000-00-00', '0000-00-00', ''),
(16, 5, '0000-00-00', '0000-00-00', ''),
(17, 5, '0001-01-01', '0002-02-02', 'no\r\n'),
(18, 5, '0001-01-01', '0002-02-02', 'no\r\n'),
(19, 5, '0001-01-01', '0002-02-02', 'noo'),
(20, 5, '0001-01-01', '0002-02-02', 'noo'),
(21, 5, '0001-01-01', '0002-02-02', 'noo'),
(22, 5, '0001-01-01', '0002-02-02', 'noo'),
(23, 5, '0001-01-01', '0002-02-02', 'noo'),
(24, 9, '2024-12-05', '2024-12-07', 'Supplément frite'),
(25, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(26, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(27, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(28, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(29, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(30, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(31, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(32, 10, '0045-03-02', '0046-04-02', 'No thanks'),
(33, 9, '2005-05-25', '2006-12-12', 'Frite'),
(34, 9, '2005-05-25', '2006-12-12', 'Frite'),
(35, 9, '2005-05-25', '2006-12-12', 'Frite'),
(36, 5, '0010-10-05', '0033-12-10', 'nope'),
(37, 8, '9999-09-09', '1000-09-09', 'BNHDZEZBSQYUHIFJ ?CKLBZFJNGBZY8QBDJOKJGYUQOH'),
(38, 5, '0555-05-05', '0000-00-00', 'qnjsdhjnqsk'),
(39, 5, '5511-05-05', '4567-03-12', 'YESSSSSSSSSS'),
(40, 5, '5511-05-05', '4567-03-12', 'NIDZJQBNK HYUDSIH QIJHNCUHLJQN GHQSB DGYQUH'),
(41, 5, '5511-05-05', '4567-03-12', 'YESSSSS FUK'),
(42, 5, '5511-05-05', '4567-03-12', 'YESSSSS FUK'),
(43, 5, '5511-05-05', '4567-03-12', 'YESSSSS FUK'),
(44, 5, '5511-05-05', '4567-03-12', 'YESSSSS FUK'),
(45, 5, '5511-05-05', '4567-03-12', 'YESSSSS FUK'),
(46, 5, '0000-00-00', '0000-00-00', 'Yes I have it'),
(47, 5, '0000-00-00', '0000-00-00', 'Yes I have it'),
(48, 5, '0000-00-00', '0000-00-00', 'Yes I have it'),
(49, 5, '0000-00-00', '0000-00-00', 'Yes I have it'),
(50, 5, '0000-00-00', '0000-00-00', 'Yes I have it'),
(51, 5, '0000-00-00', '0000-00-00', 'Yes I have it'),
(52, 5, '0005-09-09', '0055-09-09', 'Yes I have it'),
(53, 5, '0555-05-05', '0000-00-00', 'qnjsdhjnqsk'),
(54, 5, '5511-05-05', '4567-03-12', 'YESSSSS FUK'),
(55, 5, '0005-05-05', '0006-06-06', 'nope'),
(56, 9, '2025-05-13', '2025-05-17', 'Une portion de frite dans l\'avion SVP');

-- --------------------------------------------------------

--
-- Table structure for table `history_transportation`
--

CREATE TABLE `history_transportation` (
  `id_transport_history` int(11) NOT NULL,
  `id_transport` int(11) NOT NULL,
  `departure_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `ticket_number` int(255) NOT NULL,
  `id_seat_preferences` int(3) NOT NULL DEFAULT 1,
  `departure_city` varchar(255) NOT NULL,
  `arrival_city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_transportation`
--

INSERT INTO `history_transportation` (`id_transport_history`, `id_transport`, `departure_date`, `return_date`, `ticket_number`, `id_seat_preferences`, `departure_city`, `arrival_city`) VALUES
(1, 3, '0001-01-01', NULL, 1, 2, '', ''),
(2, 3, '0001-01-01', NULL, 2, 2, '', ''),
(3, 3, '0001-01-01', NULL, 3, 2, '', ''),
(4, 3, '0001-01-01', NULL, 4, 2, '', ''),
(5, 3, '0001-01-01', NULL, 5, 2, '', ''),
(6, 2, '0010-05-02', NULL, 6, 1, '', ''),
(7, 2, '0020-02-20', NULL, 7, 2, 'New York', 'Paris'),
(8, 2, '0020-02-20', NULL, 8, 2, 'New York', 'Paris'),
(9, 2, '0020-02-20', NULL, 9, 2, 'New York', 'Paris'),
(10, 2, '0005-05-05', NULL, 10, 3, 'Paris', 'Paris'),
(11, 2, '0005-05-05', NULL, 11, 1, 'Paris', 'Paris'),
(12, 2, '0005-05-05', '0006-05-05', 12, 1, 'Paris', 'Paris'),
(13, 2, '0005-05-05', '0110-01-01', 13, 2, 'Paris', 'Paris'),
(14, 2, '0007-07-07', '0009-09-09', 14, 2, 'New York', 'Paris'),
(15, 2, '0007-07-07', '0009-09-09', 15, 2, 'New York', 'Paris'),
(16, 2, '0007-07-07', '0009-09-09', 16, 2, 'New York', 'Paris'),
(17, 2, '0007-07-07', '0009-09-09', 17, 2, 'New York', 'Paris'),
(18, 2, '7777-07-07', '0000-00-00', 18, 3, 'Paris', 'Paris'),
(19, 2, '5555-04-04', '9652-04-08', 19, 2, 'Paris', 'Paris'),
(20, 2, '5555-04-04', '9652-04-08', 20, 2, 'Paris', 'Paris'),
(21, 2, '5555-04-04', '9652-04-08', 21, 2, 'Paris', 'Paris'),
(22, 2, '0000-00-00', '0749-08-09', 22, 1, 'Paris', 'London'),
(23, 2, '0555-05-05', '0000-00-00', 23, 1, 'Paris', 'Paris'),
(24, 2, '5511-05-05', '4567-03-12', 24, 1, 'Paris', 'Paris'),
(25, 2, '5511-05-05', '4567-03-12', 25, 1, 'Paris', 'Paris'),
(26, 2, '5511-05-05', '4567-03-12', 26, 1, 'Paris', 'Paris'),
(27, 2, '5511-05-05', '4567-03-12', 27, 1, 'Paris', 'Paris'),
(28, 2, '5511-05-05', '4567-03-12', 28, 1, 'Paris', 'Paris'),
(29, 2, '5511-05-05', '4567-03-12', 29, 1, 'Paris', 'Paris'),
(30, 2, '0000-00-00', '0000-00-00', 30, 1, 'Paris', 'Paris'),
(31, 2, '0000-00-00', '0000-00-00', 31, 1, 'Paris', 'Paris'),
(32, 2, '0000-00-00', '0000-00-00', 32, 1, 'Paris', 'Paris'),
(33, 2, '0000-00-00', '0000-00-00', 33, 1, 'Paris', 'Paris'),
(34, 2, '0000-00-00', '0000-00-00', 34, 1, 'Paris', 'Paris'),
(35, 2, '0000-00-00', '0000-00-00', 35, 1, 'Paris', 'Paris'),
(36, 2, '0005-09-09', '0055-09-09', 36, 1, 'Paris', 'Paris'),
(37, 2, '0555-05-05', '0000-00-00', 37, 1, 'Paris', 'Paris'),
(38, 2, '5511-05-05', '4567-03-12', 38, 1, 'Paris', 'Paris'),
(39, 2, '0007-07-07', '0008-08-08', 39, 2, 'Paris', 'Paris'),
(40, 2, '2025-05-13', '2025-05-17', 40, 2, 'Paris', 'New York');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id_invoice` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `invoice_date` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('issued','paid','void','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itineraries`
--

CREATE TABLE `itineraries` (
  `id_itinerary` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `travel_schedule` text NOT NULL,
  `accommodation_details` text NOT NULL,
  `activities` text NOT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `downloadable_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_client`
--

CREATE TABLE `login_client` (
  `id_client` int(11) NOT NULL,
  `id_loyalty` int(11) NOT NULL DEFAULT 1,
  `first_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `point_earned` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_client`
--

INSERT INTO `login_client` (`id_client`, `id_loyalty`, `first_name`, `name`, `birthdate`, `email`, `password`, `point_earned`) VALUES
(1, 1, 'Cfefs Qjdnqj', 'Fnjoesnfnsq F Qejf', '0001-01-01', 'c@c.dddd', '$2y$10$wYbNjMjp0aDPANlmK5WUQeuaCbL3eS/PqWSL4exOW4TIKneIG1iK.', 150),
(2, 3, 'Jean', 'Legrand', '1999-05-14', 'b@b.fr', 'b', 2330),
(3, 2, 'Max', 'Faure', '1987-09-10', 'd@d.fr', 'd', 1200),
(4, 3, 'Lucie', 'Bergeron', '2003-02-04', 'e@e.fr', 'e', 570),
(5, 3, 'A', 'A', '0001-01-01', 'a@a.a', '$2y$10$OCaGjx2aKp68wb8R5cqBYeUEyYW0BRMkWdtwz1djIONv6nTCjAWJO', 2000),
(6, 1, 'Dédé', 'Dédé', '0005-05-05', 'dede@dede.fr', '$2y$10$nziVSGiq7ccHtTWMi9Z/8eCqBvILUkQ7gHKnE2MZ2R5PGWHQlpzji', 0),
(7, 2, 'Fabien', 'FalseName', '2004-04-20', 'fab@utbm.fr', '$2y$10$diei87HO3wHty3qDYteXJeuI0qUOWJLSbGGyfZhPimuN4recOSYmC', 1488);

-- --------------------------------------------------------

--
-- Table structure for table `login_staff`
--

CREATE TABLE `login_staff` (
  `id_employee` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_staff`
--

INSERT INTO `login_staff` (`id_employee`, `first_name`, `name`, `birthdate`, `role`, `email`, `phone_number`, `password`) VALUES
(5, 'Fabien', 'FalseName', '2004-04-20', 'admin', 'a@a.fr', 7, '$2y$10$z5nB9AZGi9Z2A5SHRH2AQugZXH/0cWfIdGH1LfjCcBVQk9Mo3gZRy'),
(7, 'Test', 'Test', '0005-05-05', 'Booking Agent', 'test@test.fr', 5, '$2y$10$l5zJ/P03YUg4CBUFNFOACeiJrcscWLa4k3xP6ypkJUeBQhwhFoKke'),
(10, 'A', 'A', '0004-09-04', 'Booking Agent', 'a@a.cd', 5, '$2y$10$42fVsi.Yd5NhJ7hxRyQ3v.H4lvTnZNvWQ1zw5okT1/ZHYv8NnFmx6'),
(12, 'Test', 'Test', '0005-05-05', 'Ticketing Agent', 'test@test.test', 5252, '$2y$10$oyvhHzAeP1j5724cMUOJxu2qXojMV8OhNQC2rQXIeKWF8CvZZKmyG'),
(13, 'Thomas', 'FalseName', '2004-04-15', 'Administrative Assistant', 'tho@FalseName.fr', 7, '$2y$10$sRcP4d0fZ7XYvk8W6udygO.Q4oGVU2NDxKpQwOd0.F9CUFg3CaLR.'),
(14, 'Test', 'Test2', '0005-07-05', 'Booking Agent', 'test3@aj.fr', 7, '$2y$10$6IXqd1AeYCUcdOSCo4qmleanRz81eGy47BQNtAS42XBmVHxFAGMOq'),
(15, 'Jean', 'Marc', '0001-01-01', 'Accountant', 'jean.marc@utbm.fr', 6, '$2y$10$kLZJT.EAub94ECfDpPaoJ.lu46msOsvXWjGxinXv3G6KcBmSKEoNm');

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_program`
--

CREATE TABLE `loyalty_program` (
  `id_loyalty` int(11) NOT NULL,
  `loyalty_status` varchar(255) NOT NULL,
  `discount_rate` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loyalty_program`
--

INSERT INTO `loyalty_program` (`id_loyalty`, `loyalty_status`, `discount_rate`) VALUES
(1, 'bronze', 0),
(2, 'silver', 0),
(3, 'gold', 0),
(4, 'diamond', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payement`
--

CREATE TABLE `payement` (
  `id_payement` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `payement_status` enum('pending','completed','refunded','') NOT NULL DEFAULT 'pending',
  `payement_method` enum('credit card','bank transfer','cash','') NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payement_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_client`
--

CREATE TABLE `reservation_client` (
  `id_client` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `id_package` int(11) DEFAULT NULL,
  `id_history_transport` int(11) DEFAULT NULL,
  `id_history_accommodation` int(11) DEFAULT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date DEFAULT NULL,
  `status` enum('pending','confirmed','canceled','') NOT NULL DEFAULT 'pending',
  `confirmation_number` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_client`
--

INSERT INTO `reservation_client` (`id_client`, `id_reservation`, `id_package`, `id_history_transport`, `id_history_accommodation`, `checkin_date`, `checkout_date`, `status`, `confirmation_number`, `price`) VALUES
(5, 5, NULL, NULL, 5, '0001-01-01', '0002-02-02', 'confirmed', 363371, 200.00),
(5, 9, NULL, NULL, 9, '2024-12-05', '2024-12-07', 'pending', 463401, NULL),
(5, 10, NULL, NULL, 25, '0045-03-02', '0046-04-02', 'pending', 470489, NULL),
(5, 12, NULL, 5, NULL, '0001-01-01', NULL, 'pending', 470490, NULL),
(5, 13, NULL, NULL, 33, '2005-05-25', '2006-12-12', 'pending', 470491, NULL),
(5, 14, NULL, 9, NULL, '0020-02-20', NULL, 'canceled', 470492, 200.00),
(5, 15, NULL, 10, NULL, '0005-05-05', NULL, 'pending', 470493, 200.00),
(5, 16, NULL, 11, NULL, '0005-05-05', NULL, 'canceled', 470494, 200.00),
(5, 17, NULL, 12, NULL, '0005-05-05', '0006-05-05', 'pending', 470495, 200.00),
(5, 18, NULL, NULL, 36, '0010-10-05', '0033-12-10', 'canceled', 470496, 700000.00),
(5, 19, NULL, 13, NULL, '0005-05-05', '0110-01-01', 'pending', 470497, 200.00),
(5, 20, NULL, 14, NULL, '0007-07-07', '0009-09-09', 'pending', 470498, 200.00),
(5, 21, NULL, 15, NULL, '0007-07-07', '0009-09-09', 'canceled', 470499, 200.00),
(5, 22, NULL, 16, NULL, '0007-07-07', '0009-09-09', 'pending', 470500, 200.00),
(5, 23, NULL, 17, NULL, '0007-07-07', '0009-09-09', 'pending', 470501, 200.00),
(5, 24, NULL, NULL, 37, '9999-09-09', '1000-09-09', 'canceled', 470502, 440951.00),
(5, 25, NULL, 18, NULL, '7777-07-07', '0000-00-00', 'canceled', 470503, 200.00),
(5, 26, NULL, 19, NULL, '5555-04-04', '9652-04-08', 'canceled', 470504, 200.00),
(5, 27, NULL, 20, NULL, '5555-04-04', '9652-04-08', 'canceled', 470505, 200.00),
(5, 28, NULL, 21, NULL, '5555-04-04', '9652-04-08', 'canceled', 470506, 200.00),
(5, 29, NULL, 22, NULL, '0000-00-00', '0749-08-09', 'pending', 470507, 80.00),
(5, 30, 26, 35, 6, '0000-00-00', '0000-00-00', 'confirmed', 470508, 1039442.40),
(5, 31, 27, 36, 52, '0005-09-09', '0055-09-09', 'canceled', 470509, 986148.00),
(5, 32, 28, 37, 38, '0555-05-05', '0000-00-00', 'canceled', 470510, 51112284.30),
(5, 33, 29, 38, 39, '5511-05-05', '4567-03-12', 'canceled', 470511, 18000752.40),
(5, 34, NULL, NULL, 55, '0005-05-05', '0006-06-06', 'pending', 470512, -35.00),
(5, 35, NULL, 39, NULL, '0007-07-07', '0008-08-08', 'pending', 470513, 200.00),
(7, 36, 30, 40, 56, '2025-05-13', '2025-05-17', 'confirmed', 470514, 694.80);

-- --------------------------------------------------------

--
-- Table structure for table `seat_preferences`
--

CREATE TABLE `seat_preferences` (
  `id_seat_preferences` int(3) NOT NULL,
  `side` enum('No preference','Window','Aisle') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat_preferences`
--

INSERT INTO `seat_preferences` (`id_seat_preferences`, `side`) VALUES
(1, 'No preference'),
(2, 'Window'),
(3, 'Aisle');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id_service` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `service_name`) VALUES
(1, 'accommodation'),
(2, 'transportation'),
(3, 'package');

-- --------------------------------------------------------

--
-- Table structure for table `transportation`
--

CREATE TABLE `transportation` (
  `id_transport` int(11) NOT NULL,
  `id_transport_list` int(11) NOT NULL,
  `remaining_place` int(255) NOT NULL,
  `company_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportation`
--

INSERT INTO `transportation` (`id_transport`, `id_transport_list`, `remaining_place`, `company_name`) VALUES
(2, 1, 68, 'AirFrance'),
(3, 2, 100, 'SNCF'),
(5, 4, 500, 'BlaBlaCar');

-- --------------------------------------------------------

--
-- Table structure for table `transportation_list`
--

CREATE TABLE `transportation_list` (
  `id_transport_list` int(11) NOT NULL,
  `transport_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportation_list`
--

INSERT INTO `transportation_list` (`id_transport_list`, `transport_name`) VALUES
(1, 'airplane'),
(2, 'train'),
(3, 'bus'),
(4, 'car rentals');

-- --------------------------------------------------------

--
-- Table structure for table `travel_package`
--

CREATE TABLE `travel_package` (
  `id_package` int(11) NOT NULL,
  `id_transport_history` int(11) NOT NULL,
  `id_accommodation_history` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travel_package`
--

INSERT INTO `travel_package` (`id_package`, `id_transport_history`, `id_accommodation_history`, `duration`) VALUES
(1, 1, 1, 0),
(2, 1, 1, 0),
(3, 1, 1, 0),
(4, 2, 1, 0),
(6, 2, 2, 0),
(7, 2, 3, 0),
(8, 3, 1, 0),
(10, 3, 2, 0),
(11, 3, 3, 0),
(12, 4, 1, 0),
(18, 27, 39, 344842),
(19, 28, 39, 344842),
(20, 29, 39, 344842),
(21, 30, 6, 18628),
(22, 31, 6, 18628),
(23, 32, 6, 18628),
(24, 33, 6, 18628),
(25, 34, 6, 18628),
(26, 35, 6, 18628),
(27, 36, 52, 18262),
(28, 37, 38, 530761),
(29, 38, 39, 344842),
(30, 40, 56, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`id_accommodation`),
  ADD KEY `accommodation_ibfk_1` (`id_accommodation_list`);

--
-- Indexes for table `accommodation_list`
--
ALTER TABLE `accommodation_list`
  ADD PRIMARY KEY (`id_accommodation_list`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_feedback`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_service` (`id_service`);

--
-- Indexes for table `history_accommodation`
--
ALTER TABLE `history_accommodation`
  ADD PRIMARY KEY (`id_accommodation_history`),
  ADD KEY `id_accommodation` (`id_accommodation`);

--
-- Indexes for table `history_transportation`
--
ALTER TABLE `history_transportation`
  ADD PRIMARY KEY (`id_transport_history`),
  ADD KEY `id_transport` (`id_transport`),
  ADD KEY `id_seat_preferences` (`id_seat_preferences`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id_invoice`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Indexes for table `itineraries`
--
ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id_itinerary`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Indexes for table `login_client`
--
ALTER TABLE `login_client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `id_loyalty` (`id_loyalty`);

--
-- Indexes for table `login_staff`
--
ALTER TABLE `login_staff`
  ADD PRIMARY KEY (`id_employee`);

--
-- Indexes for table `loyalty_program`
--
ALTER TABLE `loyalty_program`
  ADD PRIMARY KEY (`id_loyalty`);

--
-- Indexes for table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`id_payement`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Indexes for table `reservation_client`
--
ALTER TABLE `reservation_client`
  ADD PRIMARY KEY (`id_reservation`),
  ADD UNIQUE KEY `confirmation_number` (`confirmation_number`),
  ADD KEY `id_package` (`id_package`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_transport` (`id_history_transport`),
  ADD KEY `id_history_accommodation` (`id_history_accommodation`);

--
-- Indexes for table `seat_preferences`
--
ALTER TABLE `seat_preferences`
  ADD PRIMARY KEY (`id_seat_preferences`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`);

--
-- Indexes for table `transportation`
--
ALTER TABLE `transportation`
  ADD PRIMARY KEY (`id_transport`);

--
-- Indexes for table `transportation_list`
--
ALTER TABLE `transportation_list`
  ADD PRIMARY KEY (`id_transport_list`);

--
-- Indexes for table `travel_package`
--
ALTER TABLE `travel_package`
  ADD PRIMARY KEY (`id_package`),
  ADD KEY `id_history_transport` (`id_transport_history`),
  ADD KEY `id_accommodation_history` (`id_accommodation_history`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `id_accommodation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `accommodation_list`
--
ALTER TABLE `accommodation_list`
  MODIFY `id_accommodation_list` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_accommodation`
--
ALTER TABLE `history_accommodation`
  MODIFY `id_accommodation_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `history_transportation`
--
ALTER TABLE `history_transportation`
  MODIFY `id_transport_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id_invoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itineraries`
--
ALTER TABLE `itineraries`
  MODIFY `id_itinerary` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_client`
--
ALTER TABLE `login_client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_staff`
--
ALTER TABLE `login_staff`
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loyalty_program`
--
ALTER TABLE `loyalty_program`
  MODIFY `id_loyalty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payement`
--
ALTER TABLE `payement`
  MODIFY `id_payement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_client`
--
ALTER TABLE `reservation_client`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `seat_preferences`
--
ALTER TABLE `seat_preferences`
  MODIFY `id_seat_preferences` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transportation`
--
ALTER TABLE `transportation`
  MODIFY `id_transport` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transportation_list`
--
ALTER TABLE `transportation_list`
  MODIFY `id_transport_list` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `travel_package`
--
ALTER TABLE `travel_package`
  MODIFY `id_package` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD CONSTRAINT `accommodation_ibfk_1` FOREIGN KEY (`id_accommodation_list`) REFERENCES `accommodation_list` (`id_accommodation_list`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `login_client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_accommodation`
--
ALTER TABLE `history_accommodation`
  ADD CONSTRAINT `history_accommodation_ibfk_1` FOREIGN KEY (`id_accommodation`) REFERENCES `accommodation` (`id_accommodation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_transportation`
--
ALTER TABLE `history_transportation`
  ADD CONSTRAINT `history_transportation_ibfk_1` FOREIGN KEY (`id_transport`) REFERENCES `transportation` (`id_transport`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_transportation_ibfk_2` FOREIGN KEY (`id_seat_preferences`) REFERENCES `seat_preferences` (`id_seat_preferences`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation_client` (`id_reservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `itineraries`
--
ALTER TABLE `itineraries`
  ADD CONSTRAINT `itineraries_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation_client` (`id_reservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login_client`
--
ALTER TABLE `login_client`
  ADD CONSTRAINT `login_client_ibfk_1` FOREIGN KEY (`id_loyalty`) REFERENCES `loyalty_program` (`id_loyalty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payement`
--
ALTER TABLE `payement`
  ADD CONSTRAINT `payement_ibfk_2` FOREIGN KEY (`id_reservation`) REFERENCES `reservation_client` (`id_reservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_client`
--
ALTER TABLE `reservation_client`
  ADD CONSTRAINT `reservation_client_ibfk_2` FOREIGN KEY (`id_package`) REFERENCES `travel_package` (`id_package`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_client_ibfk_3` FOREIGN KEY (`id_client`) REFERENCES `login_client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_client_ibfk_4` FOREIGN KEY (`id_history_transport`) REFERENCES `history_transportation` (`id_transport_history`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_client_ibfk_5` FOREIGN KEY (`id_history_accommodation`) REFERENCES `history_accommodation` (`id_accommodation_history`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_client_ibfk_6` FOREIGN KEY (`id_history_accommodation`) REFERENCES `history_accommodation` (`id_accommodation_history`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `travel_package`
--
ALTER TABLE `travel_package`
  ADD CONSTRAINT `travel_package_ibfk_1` FOREIGN KEY (`id_transport_history`) REFERENCES `history_transportation` (`id_transport_history`),
  ADD CONSTRAINT `travel_package_ibfk_3` FOREIGN KEY (`id_accommodation_history`) REFERENCES `history_accommodation` (`id_accommodation_history`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
