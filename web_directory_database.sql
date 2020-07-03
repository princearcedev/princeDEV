-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 05:53 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_directory_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(14) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `name`, `username`, `password`) VALUES
(1, 'Prince Arce', '0000', '0000'),
(23, 'Admin', 'admin', 'admin'),
(34, 'Pearl Irish Pateña', 'pearl', 'pxxrl18');

-- --------------------------------------------------------

--
-- Table structure for table `directory`
--

CREATE TABLE `directory` (
  `id` int(14) NOT NULL,
  `system` varchar(200) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `upload_date` varchar(200) DEFAULT NULL,
  `uploader` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `directory`
--

INSERT INTO `directory` (`id`, `system`, `url`, `upload_date`, `uploader`) VALUES
(20, 'FGPS', 'http://172.25.112.171:1000/fgps/main.php', 'June 22, 2020, 1:40 pm', 'Prince Arce'),
(25, 'Scooter Station - MM', 'http://172.25.116.188:3000/kanban_preparation_live/request.php', 'June 23, 2020, 11:47 am', 'Prince Arce'),
(27, 'E - Kanban Annex', 'http://172.25.116.188:3000/kanban_preparation_live', 'June 23, 2020, 11:50 am', 'Prince Arce'),
(28, 'Tube Cutting - Scooter Station', 'http://172.25.112.172:1000/tube_cutting_live/request.php', 'June 23, 2020, 11:50 am', 'Prince Arce'),
(29, 'Tube Cutting - Annex', 'http://172.25.112.172:1000/tube_cutting_live/', 'June 23, 2020, 11:51 am', 'Prince Arce'),
(30, 'Suspended Employees Monitoring System', 'http://172.25.112.171:1000/sem', 'June 23, 2020, 11:52 am', 'Prince Arce'),
(45, 'FG Loading System ', 'http://172.25.112.171:1000/fgls-api/login.php', 'June 24, 2020, 11:20 am', 'Pearl Irish Pateña'),
(46, 'Connector Insertion Training System', 'http://172.25.112.171:1000/crosswire/', 'June 24, 2020, 11:21 am', 'Pearl Irish Pateña'),
(47, 'High Rack Monitoring System', 'http://172.25.112.171:1000/hrms/', 'June 24, 2020, 11:22 am', 'Pearl Irish Pateña'),
(48, 'FALP Website', 'http://172.25.112.171:1000/falpwebv2/', 'June 24, 2020, 11:26 am', 'Pearl Irish Pateña'),
(49, 'PE System', 'http://172.25.112.171:1000/pe/', 'June 24, 2020, 11:27 am', 'Pearl Irish Pateña');

-- --------------------------------------------------------

--
-- Table structure for table `tb_history`
--

CREATE TABLE `tb_history` (
  `id` int(14) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `notif_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_history`
--
ALTER TABLE `tb_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `directory`
--
ALTER TABLE `directory`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tb_history`
--
ALTER TABLE `tb_history`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
