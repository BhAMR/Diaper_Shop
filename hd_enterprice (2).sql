-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Dez 2025 um 08:20
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hd_enterprice`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin`
--

CREATE TABLE `admin` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '0192023a7bbd73250516f069df18b5'),
('admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `category_id` int(20) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `has_size` tinyint(1) NOT NULL DEFAULT 0,
  `has_packet` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `has_size`, `has_packet`, `status`) VALUES
(1, 'Baby Diapers', 1, 1, 'Active'),
(2, 'Ponds Powder', 0, 0, 'Active'),
(3, 'Wipes', 1, 1, 'Active'),
(4, 'Baby Lotion', 0, 0, 'Active'),
(5, 'Baby Soap', 0, 0, 'Active');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT '''Pending''',
  `order_status` enum('placed','cancelled') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `customer_name`, `mobile`, `address`, `pincode`, `city`, `quantity`, `price`, `total_amount`, `payment_status`, `order_status`, `created_at`) VALUES
(1, 4, 'jayraj ahir', '4567689098', 'A-102,HariVandana-2,Yogi-chock', '394111', 'Kim Char Rasta, Mangrol, Surat', 2, 0.00, 0.00, '', '', '2025-12-19 06:14:48'),
(2, 5, 'bhargav rangani', '4567689098', 'rbfdcxefwds', '394110', 'Anita, Olpad, Surat', 3, 0.00, 0.00, NULL, NULL, '2025-12-19 06:16:17'),
(3, 3, 'Avsar', '5678987654', 'fgrhtyjmjhgf bdcxz', '360050', 'Bakhalvad, Jasdan, Rajkot', 1, 125.00, 125.00, NULL, NULL, '2025-12-19 06:25:27'),
(4, 4, 'Jinal', '3490089876', 'h-502,bhavani hights, Maharaja farm road  ', '394101', 'Mota Varachha, Chorasi, Surat', 3, 475.00, 1425.00, NULL, NULL, '2025-12-19 06:30:31');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `otp_log`
--

CREATE TABLE `otp_log` (
  `id` int(11) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pincodes`
--

CREATE TABLE `pincodes` (
  `pincode` varchar(6) NOT NULL,
  `delivery_charge` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `pincodes`
--

INSERT INTO `pincodes` (`pincode`, `delivery_charge`) VALUES
('394101', 30),
('395006', 40),
('400001', 60);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category_id` int(50) DEFAULT NULL,
  `size` enum('NB','S','M','L','XL','XXL','XXXL') DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `packet_pieces` int(11) DEFAULT 75,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('In Stock','Out Of Stock') DEFAULT 'In Stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`product_id`, `name`, `category_id`, `size`, `price`, `packet_pieces`, `stock`, `image`, `status`) VALUES
(1, 'Diapers For Babay', 1, 'M', 375, 56, 0, 'prod_6941236a921ba.jpg', 'In Stock'),
(2, 'Himalaya Soap', 5, '', 49, 0, 15, '1765866506babySoap.jpg', 'In Stock'),
(3, 'Baby Lotions', 4, '', 125, 0, 10, '1765866541babyLotion.jpg', 'In Stock'),
(4, 'Adults Wipes', 3, 'M', 475, 75, 20, '1765866603waterWipes.jpg', 'In Stock'),
(5, 'Baby Powder', 2, '', 149, 0, 10, '1765954683babyPowder.jpg', 'In Stock');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `is_verifide` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `otp_log`
--
ALTER TABLE `otp_log`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pincodes`
--
ALTER TABLE `pincodes`
  ADD PRIMARY KEY (`pincode`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_categories` (`category_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `otp_log`
--
ALTER TABLE `otp_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
