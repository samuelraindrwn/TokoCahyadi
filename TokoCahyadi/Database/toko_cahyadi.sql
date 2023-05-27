-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2023 at 06:56 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_cahyadi`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` varchar(10) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `stock` int(10) NOT NULL,
  `product_price` int(15) NOT NULL,
  `product_pict` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `stock`, `product_price`, `product_pict`) VALUES
('P0001', 'Green Lake', 148, 350000, 'Img/product/Gr-batik.jpg'),
('P0002', 'Maroon Lake', 174, 250000, 'Img/product/maroon.jpg'),
('P0003', 'Nest of Bird', 189, 450000, 'Img/product/Nest-of-Bird-Batik.jpg'),
('P0004', 'Breeze Cotton', 268, 700000, 'Img/product/Breeze-Cotton-Batik.jpg'),
('P0005', 'Blue Ainsley', 84, 525000, 'Img/product/Blue-ainsley.jpg'),
('P0006', 'Blue Arcane', 227, 325000, 'Img/product/blue-arcane.jpg'),
('P0007', 'Blue Wheel', 150, 210000, 'Img/product/Blue-wheel.jpg'),
('P0008', 'Brown Tulip', 319, 350000, 'Img/product/brown-tulip.jpg'),
('P0009', 'Creamy Dark Blue', 177, 430000, 'Img/product/Creamy-dark-blue-batik.jpg'),
('P0010', 'Goofy Red', 93, 125000, 'Img/product/goofy-red.jpg'),
('P0011', 'Star Blossom', 129, 210000, 'Img/product/star-blossom.jpg'),
('P0012', 'Warm Seasons', 255, 135000, 'Img/product/Warm-seasons.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `transaksi_date` date NOT NULL,
  `shipping_address` varchar(100) NOT NULL,
  `cust_city` varchar(50) NOT NULL,
  `cust_region` varchar(50) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `total_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `user_id`, `transaksi_date`, `shipping_address`, `cust_city`, `cust_region`, `post_code`, `total_price`) VALUES
('TID09a554a', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 15785000),
('TID14a3e58', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 700000),
('TID44cfaa1', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 700000),
('TID8e3f54a', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 700000),
('TID8f00954', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 700000),
('TIDc1f0c5f', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 1400000),
('TIDd409a5e', 'U_262', '2023-04-28', 'Villa Tomang Baru Blok C1 No 5', 'Tangerang', 'Banten', '15560', 189000000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transDetail_id` varchar(10) NOT NULL,
  `transaksi_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `quantity` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transDetail_id`, `transaksi_id`, `product_id`, `quantity`) VALUES
('TDID0cc3d3', 'TID8e3f54a', 'P0001', 2),
('TDID29b6df', 'TID09a554a', 'P0009', 5),
('TDID2e6d15', 'TID09a554a', 'P0011', 3),
('TDID318e5c', 'TID44cfaa1', 'P0004', 1),
('TDID385ea5', 'TID09a554a', 'P0004', 4),
('TDID40d784', 'TIDc1f0c5f', 'P0004', 2),
('TDID460ce5', 'TIDd409a5e', 'P0004', 270),
('TDID4de7ce', 'TID14a3e58', 'P0001', 2),
('TDID5e24ea', 'TID09a554a', 'P0002', 2),
('TDID6459b3', 'TID09a554a', 'P0005', 5),
('TDID8c0b96', 'TID09a554a', 'P0007', 4),
('TDID8f18a5', 'TID8f00954', 'P0001', 2),
('TDIDba2e94', 'TID09a554a', 'P0010', 5),
('TDIDba87c4', 'TID09a554a', 'P0012', 4),
('TDIDc78b38', 'TID09a554a', 'P0008', 2),
('TDIDca7cb6', 'TID09a554a', 'P0001', 4),
('TDIDf903ee', 'TID09a554a', 'P0003', 3),
('TDIDfd8665', 'TID09a554a', 'P0006', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_pict` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `dob`, `username`, `password`, `email`, `profile_pict`) VALUES
('U_262', 'Samuel ', 'Rai', '2023-04-24', 'samuelraindrwn', '827ccb0eea8a706c4c34a16891f84e', 'samuelray12@gmail.com', '../Img/pp/4f755341-32a1-403d-a9e3-5aa1a035b63f copy.jpg'),
('U_5266', 'cesco', 'Ade', '2023-04-25', 'cesco', '202cb962ac59075b964b07152d234b', 'cesco@gmail.com', '../Img/pp/image.png'),
('U_8430', 'Lone', 'Gunawan', '2023-03-31', 'leon', '5c443b2003676fa5e8966030ce3a86', 'leon@gmail.com', '../Img/pp/4f755341-32a1-403d-a9e3-5aa1a035b63f copy.jpg'),
('U_950', 'rio', 'Ade', '2023-04-01', 'rio', '202cb962ac59075b964b07152d234b', 'santoso@gmail.com', '../Img/pp/4f755341-32a1-403d-a9e3-5aa1a035b63f copy.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD UNIQUE KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transDetail_id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `transaksi_id` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
