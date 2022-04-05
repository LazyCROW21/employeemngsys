-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2022 at 07:33 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--
CREATE DATABASE IF NOT EXISTS `ems` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ems`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Email` varchar(120) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Address` varchar(210) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Id`, `Name`, `Email`, `Phone`, `Address`, `City`, `State`, `Country`, `CreatedAt`, `UpdatedAt`, `DeletedAt`) VALUES
(1, 'Devpulse', 'avischi0@unc.edu', '2341211204', '26002 Del Sol Circle', 'Canton', 'Ohio', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(2, 'Dabvine', 'mthaine1@dailymotion.com', '2603211814', '23604 Arrowood Alley', 'Fort Wayne', 'Indiana', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(3, 'Leenti', 'rshulver2@gnu.org', '2073324450', '84883 Jenna Parkway', 'Portland', 'Maine', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(4, 'Fadeo', 'ipires3@psu.edu', '7868777128', '79144 Sugar Alley', 'Miami', 'Florida', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(5, 'Tazz', 'ahedworth4@networksolutions.com', '9128198223', '575 Myrtle Trail', 'Savannah', 'Georgia', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(6, 'Gigaclub', 'vkaming5@wikispaces.com', '8507271554', '29 Bashford Circle', 'Pensacola', 'Florida', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(7, 'Lazzy', 'tbridges6@lycos.com', '8129724198', '74 Kinsman Terrace', 'Evansville', 'Indiana', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(8, 'Kazu', 'vskace7@shareasale.com', '8137257054', '95727 Chinook Park', 'Tampa', 'Florida', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(9, 'Twimm', 'kwodham8@weebly.com', '3608311618', '224 New Castle Trail', 'Vancouver', 'Washington', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(10, 'Voomm', 'kalten9@si.edu', '7605976170', '937 Memorial Road', 'San Diego', 'California', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(11, 'Linkbridge', 'rstobbarta@blogs.com', '2028313717', '3 Bashford Plaza', 'Washington', 'District of Columbia', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(12, 'Tekfly', 'lelbyb@webeden.co.uk', '5094788717', '5530 Crescent Oaks Point', 'Spokane', 'Washington', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(13, 'Jaloo', 'rmurkittc@eventbrite.com', '2028769563', '19 Di Loreto Circle', 'Washington', 'District of Columbia', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(14, 'Zoomdog', 'nmattschasd@uol.com.br', '3029218752', '5 Fremont Lane', 'Wilmington', 'Delaware', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(15, 'Edgeify', 'ustainsone@cdc.gov', '9152125180', '0 Huxley Center', 'El Paso', 'Texas', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(16, 'Agivu', 'khausef@cloudflare.com', '3604540866', '1 Dryden Trail', 'Vancouver', 'Washington', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(17, 'Innotype', 'mmaystong@networkadvertising.org', '7865849565', '23 Stone Corner Plaza', 'Miami', 'Florida', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(18, 'Voomm', 'djakubovicsh@yolasite.com', '2316029356', '25 2nd Lane', 'Muskegon', 'Michigan', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(19, 'Innojam', 'rwallheadi@canalblog.com', '7032381590', '3 Merry Road', 'Washington', 'District of Columbia', 'United States', '2022-04-04 20:49:11', NULL, NULL),
(20, 'Topiczoom', 'iofenerj@about.com', '7319772192', '14 Maple Wood Park', 'Jackson', 'Tennessee', 'United States', '2022-04-04 20:49:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Id` int(11) NOT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Id`, `Name`, `CreatedAt`, `UpdatedAt`, `DeletedAt`) VALUES
(1, 'Human Resources', '2021-12-18 15:02:41', '2021-04-27 12:19:54', NULL),
(2, 'Support', '2021-04-01 15:22:12', '2021-04-23 18:04:17', NULL),
(3, 'Support', '2021-05-23 02:49:19', '2021-11-03 04:02:41', NULL),
(4, 'Training', '2022-01-29 10:32:55', '2022-03-03 20:19:31', NULL),
(5, 'Services', '2021-08-25 09:04:22', '2021-12-28 20:35:51', NULL),
(6, 'Business Development', '2021-08-08 21:11:44', '2021-11-16 15:06:06', '2022-03-21 11:40:16'),
(7, 'Marketing', '2022-04-03 00:18:45', '2021-04-21 06:54:36', NULL),
(8, 'Product Management', '2021-12-18 10:26:54', '2021-10-16 10:42:20', '2022-02-18 19:51:32'),
(9, 'Accounting', '2021-11-12 06:11:43', '2022-03-19 15:15:33', '2021-12-10 08:07:07'),
(10, 'Accounting', '2021-05-22 21:39:26', '2021-07-20 07:01:05', '2021-04-13 16:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `Id` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`Id`, `DepartmentId`, `Name`, `CreatedAt`, `UpdatedAt`, `DeletedAt`) VALUES
(1, 3, 'Community Outreach Specialist', '2021-09-29 20:23:28', '2022-03-17 16:49:54', NULL),
(2, 8, 'Social Worker', '2022-02-22 10:38:44', '2021-09-17 14:31:41', NULL),
(3, 2, 'Structural Analysis Engineer', '2021-08-04 07:05:20', '2022-04-06 20:34:28', NULL),
(4, 7, 'Professor', '2021-10-15 06:06:22', '2022-02-10 13:07:34', NULL),
(5, 4, 'Civil Engineer', '2021-12-11 17:09:01', '2022-01-07 15:02:56', NULL),
(6, 5, 'VP Sales', '2021-09-12 02:28:57', '2022-02-17 17:44:49', '2021-04-12 22:29:28'),
(7, 3, 'Clinical Specialist', '2021-07-06 14:27:27', '2021-10-20 14:22:31', NULL),
(8, 8, 'Clinical Specialist', '2022-02-23 21:58:58', '2021-09-20 11:39:11', NULL),
(9, 6, 'Sales Associate', '2021-05-25 08:36:42', '2022-02-28 12:21:04', NULL),
(10, 3, 'Senior Financial Analyst', '2022-01-19 04:17:38', '2021-12-20 11:53:43', NULL),
(11, 5, 'Community Outreach Specialist', '2021-04-12 14:02:44', '2021-08-20 06:30:44', NULL),
(12, 9, 'Sales Representative', '2021-10-12 18:37:50', '2021-04-27 08:18:03', NULL),
(13, 3, 'Senior Financial Analyst', '2021-05-21 18:27:22', '2021-11-14 01:44:55', NULL),
(14, 2, 'Editor', '2022-01-10 18:44:15', '2021-04-21 21:03:45', '2021-09-04 05:37:32'),
(15, 10, 'Programmer Analyst II', '2021-05-13 08:39:55', '2021-07-30 07:08:00', '2021-12-25 04:36:45'),
(16, 5, 'Paralegal', '2022-01-16 10:58:08', '2021-04-12 13:29:20', '2021-10-21 12:25:17'),
(17, 5, 'Automation Specialist II', '2021-11-28 03:03:18', '2021-09-16 17:35:40', NULL),
(18, 3, 'Geological Engineer', '2022-03-11 15:38:52', '2022-02-26 15:18:07', NULL),
(19, 2, 'Health Coach I', '2021-11-29 00:48:58', '2021-07-15 09:09:37', '2022-01-06 20:58:22'),
(20, 10, 'VP Marketing', '2022-01-02 20:05:32', '2021-08-26 05:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `Id` int(11) NOT NULL,
  `EmployeeId` int(11) DEFAULT NULL,
  `StartedAt` datetime DEFAULT NULL,
  `StartHalf` varchar(1) NOT NULL,
  `EndedAt` datetime DEFAULT NULL,
  `EndHalf` varchar(1) NOT NULL,
  `LeaveType` varchar(20) DEFAULT NULL,
  `EffectOnPay` varchar(15) NOT NULL,
  `Reason` varchar(256) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `RespondedBy` int(11) DEFAULT NULL,
  `RespondedOn` datetime DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`Id`, `EmployeeId`, `StartedAt`, `StartHalf`, `EndedAt`, `EndHalf`, `LeaveType`, `EffectOnPay`, `Reason`, `status`, `RespondedBy`, `RespondedOn`, `CreatedAt`, `UpdatedAt`, `DeletedAt`) VALUES
(1, 10, '2021-12-30 13:33:21', 'E', '2021-12-19 21:12:27', 'E', 'Vacation', 'WithPay', 'Duis consequat dui nec nisi volutpat eleifend.', 'Rejected', 24, '2021-10-29 22:35:12', '2021-09-05 17:07:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 6, '2021-07-17 08:14:53', 'E', '2021-08-05 09:13:08', 'E', 'Sick - Family', 'WithPay', 'Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh. Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio ', 'Approved', 18, '2021-11-24 21:23:44', '2021-05-09 08:25:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 14, '2021-05-28 17:59:11', 'M', '2022-01-09 07:58:31', 'E', 'Maternity', 'LossOfPay', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat. Curabitur gravida nisi at nibh.', 'Rejected', NULL, NULL, '2022-01-27 02:05:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 6, '2021-05-11 05:13:06', 'M', '2021-12-08 11:01:02', 'M', 'Maternity', 'WithPay', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus. Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel a', 'Rejected', 22, '2021-05-20 23:57:24', '2021-05-04 09:25:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 25, '2021-09-13 16:38:14', 'E', '2021-06-06 15:56:49', 'M', 'Parental', 'WithPay', 'Phasellus in felis. Donec semper sapien a libero. Nam dui. Proin leo odio, porttitor id, consequat in, consequat ut, nulla.', 'Rejected', NULL, NULL, '2021-06-20 16:30:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `Id` int(11) NOT NULL,
  `Employee` int(11) DEFAULT NULL,
  `BasicPay` int(11) DEFAULT NULL,
  `HRA` int(11) DEFAULT NULL,
  `DA` int(11) DEFAULT NULL,
  `TA` int(11) DEFAULT NULL,
  `IncomeTax` int(11) DEFAULT NULL,
  `ProfessionalTax` int(11) DEFAULT NULL,
  `PF` int(11) DEFAULT NULL,
  `Overtime` int(11) DEFAULT NULL,
  `Bonus` int(11) DEFAULT NULL,
  `MedicalAllowances` int(11) DEFAULT NULL,
  `GratedOn` datetime DEFAULT NULL,
  `GrantedBy` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `Id` int(11) NOT NULL,
  `Value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `Id` int(11) NOT NULL,
  `Title` varchar(256) DEFAULT NULL,
  `Client` int(11) DEFAULT NULL,
  `Lead` int(11) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `Earning` float DEFAULT NULL,
  `Deadline` datetime DEFAULT NULL,
  `Completed` tinyint(1) NOT NULL DEFAULT 0,
  `StartedAt` datetime DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`Id`, `Title`, `Client`, `Lead`, `Description`, `Earning`, `Deadline`, `Completed`, `StartedAt`, `CreatedAt`, `UpdatedAt`, `DeletedAt`) VALUES
(1, 'Daltfresh', 2, 19, 'Phasellus in felis.', 55840.1, '2022-04-04 20:21:12', 0, '2021-09-23 16:38:35', '2021-03-12 14:35:13', NULL, NULL),
(2, 'Flexidy', 6, 14, 'Donec semper sapien a libero. Nam dui.', 79418, NULL, 1, '2022-02-09 12:23:41', '2021-06-30 09:50:47', '2021-12-13 15:11:46', '2021-08-18 18:23:48'),
(3, 'Span', 1, 7, 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis. Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor.', 74303.8, '2022-04-25 20:21:18', 0, '2022-04-13 14:24:44', '2021-04-01 15:11:10', NULL, NULL),
(4, 'Cookley', 5, 15, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus. Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis.', 49784.5, '2022-04-05 20:21:23', 1, '2021-03-29 05:16:56', '2021-05-06 09:52:00', NULL, NULL),
(5, 'Cardguard', 4, 25, 'Morbi a ipsum. Integer a nibh.', 82636.1, NULL, 1, '2022-02-28 08:12:21', '2021-12-10 23:38:17', NULL, NULL),
(6, 'Ventosanzap', 2, 1, 'Duis at velit eu est congue elementum. In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo. Aliquam quis turpis eget elit sodales scelerisque.', 30901.3, '2022-04-21 20:21:28', 0, '2021-06-17 21:22:24', '2022-03-04 11:08:16', NULL, NULL),
(7, 'Job', 10, 17, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus. Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis.', 44854.3, NULL, 1, '2021-07-25 04:02:18', '2021-07-27 08:13:27', NULL, NULL),
(8, 'Holdlamis', 5, 8, 'Proin at turpis a pede posuere nonummy. Integer non velit. Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi.', 53671.7, NULL, 1, '2021-07-24 13:49:43', '2021-11-07 18:43:26', '2021-06-06 17:06:46', '2022-03-06 09:01:10'),
(9, 'Transcof', 3, 21, 'Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl. Aenean lectus.', 76332.2, NULL, 1, '2021-07-18 17:40:00', '2021-08-14 21:18:13', NULL, NULL),
(10, 'Opela', 1, 25, 'Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat. In congue. Etiam justo.', 80074.2, '2022-04-30 20:21:34', 1, '2021-09-10 08:46:54', '2022-01-19 20:05:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_emp`
--

CREATE TABLE `project_emp` (
  `Id` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Address` varchar(510) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Basic` float NOT NULL,
  `DateOfJoining` date NOT NULL,
  `DepartmentId` int(11) DEFAULT NULL,
  `DesignationId` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `DeletedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `Name`, `Email`, `Phone`, `DateOfBirth`, `Gender`, `Address`, `City`, `State`, `Basic`, `DateOfJoining`, `DepartmentId`, `DesignationId`, `CreatedAt`, `UpdatedAt`, `DeletedAt`) VALUES
(1, 'Alexandrina Melwall', 'amelwall0@is.gd', '1473385775', '2021-02-09', 'F', '4954 Dakota Parkway', 'Pescara', 'Abruzzi', 35866.6, '2021-11-28', 9, 16, '2021-08-29 17:56:59', NULL, NULL),
(2, 'Wrennie Pinxton', 'wpinxton1@bluehost.com', '7257605370', '2021-06-17', 'M', '0 Lakeland Road', 'Pescara', 'Abruzzi', 23899.1, '2022-02-06', 5, 8, '2021-07-25 18:11:22', NULL, NULL),
(3, 'Pegeen Pashenkov', 'ppashenkov2@usgs.gov', '2466262660', '2019-01-04', 'M', '214 Rockefeller Hill', 'Pescara', 'Abruzzi', 25968.6, '2021-04-24', 3, 17, '2021-08-02 06:36:25', '2022-01-24 15:24:38', '2022-03-14 20:39:18'),
(4, 'Clyde Macias', 'cmacias3@amazon.co.jp', '1573248935', '2021-04-21', 'F', '2740 Russell Trail', 'Pescara', 'Abruzzi', 21364.5, '2021-11-22', 5, 15, '2022-03-10 20:09:21', NULL, NULL),
(5, 'Janis Stodart', 'jstodart4@spiegel.de', '2608239309', '2021-10-22', 'M', '9397 Northwestern Court', 'Pescara', 'Abruzzi', 82517.8, '2021-09-26', 7, 5, '2021-09-05 14:48:46', '2021-07-16 00:34:59', '2022-03-08 22:20:04'),
(6, 'Clementine Marishenko', 'cmarishenko5@redcross.org', '8789196229', '2019-09-25', 'F', '88 Transport Plaza', 'Pescara', 'Abruzzi', 70873.6, '2022-01-23', 4, 19, '2022-03-03 07:02:28', NULL, NULL),
(7, 'Liv Le Fevre', 'lle6@icio.us', '7116206987', '2020-05-24', 'M', '0838 Nobel Crossing', 'Pescara', 'Abruzzi', 62142.6, '2022-02-09', 10, 8, '2021-08-30 13:29:21', NULL, NULL),
(8, 'Petronella Lobe', 'plobe7@bravesites.com', '5743309113', '2022-03-08', 'F', '13 Roxbury Hill', 'Pescara', 'Abruzzi', 66127.5, '2021-08-30', 1, 15, '2021-05-17 14:04:16', NULL, NULL),
(9, 'Samuele Clemmey', 'sclemmey8@xing.com', '2063375526', '2021-02-21', 'M', '60198 Boyd Way', 'Pescara', 'Abruzzi', 54193.6, '2021-06-07', 2, 15, '2021-10-29 21:27:52', NULL, NULL),
(10, 'Feliza McLarens', 'fmclarens9@prweb.com', '4657529712', '2020-02-06', 'M', '61 Lighthouse Bay Court', 'Pescara', 'Abruzzi', 23985.9, '2021-08-10', 10, 20, '2022-03-25 15:21:59', '2021-04-26 21:12:25', '2021-11-05 06:01:10'),
(11, 'Hayden Ragg', 'hragga@spotify.com', '2349174847', '2020-01-19', 'F', '7065 Oak Point', 'Pescara', 'Abruzzi', 84172.6, '2021-11-06', 5, 9, '2021-04-05 04:24:23', '2021-11-30 14:00:54', '2021-11-24 03:26:44'),
(12, 'Lynn Loffill', 'lloffillb@mapy.cz', '4254257069', '2020-11-09', 'F', '526 Saint Paul Alley', 'Pescara', 'Abruzzi', 86253.7, '2021-11-23', 5, 2, '2022-02-27 13:59:46', NULL, NULL),
(13, 'Alfreda Rowan', 'arowanc@ycombinator.com', '5527946474', '2022-04-09', 'M', '810 Golf View Junction', 'Pescara', 'Abruzzi', 44489.5, '2022-03-30', 9, 19, '2021-06-20 15:41:19', NULL, NULL),
(14, 'Jackqueline Blaiklock', 'jblaiklockd@ucla.edu', '4527811871', '2018-11-02', 'F', '1 Express Trail', 'Pescara', 'Abruzzi', 84176.5, '2021-08-11', 1, 17, '2022-01-05 18:43:38', NULL, NULL),
(15, 'Nikaniki Sparey', 'nspareye@shop-pro.jp', '6378920807', '2020-08-11', 'F', '36 Killdeer Alley', 'Pescara', 'Abruzzi', 22212.5, '2021-10-21', 4, 16, '2021-11-10 03:17:54', NULL, NULL),
(16, 'Fallon Scandrick', 'fscandrickf@skype.com', '6787836400', '2022-02-18', 'M', '5867 Forest Terrace', 'Pescara', 'Abruzzi', 95169.5, '2021-04-19', 9, 11, '2021-08-12 03:28:07', NULL, NULL),
(17, 'Christie Thorsen', 'cthorseng@dion.ne.jp', '5586456440', '2020-05-08', 'F', '7 Schurz Circle', 'Pescara', 'Abruzzi', 47766, '2021-12-16', 9, 1, '2021-06-04 00:41:44', '2021-12-07 19:51:19', '2021-11-01 01:35:08'),
(18, 'Nolly Nairns', 'nnairnsh@blinklist.com', '6273682658', '2019-02-15', 'F', '3899 Elka Circle', 'Pescara', 'Abruzzi', 98296.4, '2021-08-21', 5, 18, '2021-11-20 22:24:29', NULL, NULL),
(19, 'Thornie Downing', 'tdowningi@meetup.com', '2637681082', '2019-12-26', 'M', '55089 Mandrake Trail', 'Pescara', 'Abruzzi', 43093, '2021-07-05', 3, 1, '2021-04-08 01:25:07', NULL, NULL),
(20, 'Matthaeus Shoebridge', 'mshoebridgej@google.com', '5204707872', '2019-02-08', 'F', '2684 Corben Drive', 'Pescara', 'Abruzzi', 41045.7, '2021-10-25', 9, 13, '2022-04-09 07:57:31', NULL, NULL),
(21, 'Andy Siemantel', 'asiemantelk@nymag.com', '5811553263', '2022-01-17', 'M', '3975 Hermina Way', 'Pescara', 'Abruzzi', 54227.1, '2021-09-14', 5, 10, '2022-02-09 11:46:48', '2021-10-26 22:21:04', '2021-09-19 15:55:08'),
(22, 'Gregg Timpany', 'gtimpanyl@hugedomains.com', '8332104251', '2020-12-05', 'F', '767 Buell Park', 'Pescara', 'Abruzzi', 33062.7, '2021-05-21', 2, 11, '2021-06-26 05:06:18', '2021-07-17 09:10:52', '2022-03-01 22:24:04'),
(23, 'Tuck Andrzejczak', 'tandrzejczakm@ca.gov', '7952982632', '2021-06-09', 'F', '81567 Di Loreto Place', 'Pescara', 'Abruzzi', 32070.6, '2021-10-31', 9, 2, '2021-07-13 23:01:15', NULL, NULL),
(24, 'Frasier Haddleton', 'fhaddletonn@opera.com', '6912330063', '2021-08-28', 'F', '4 Northland Point', 'Pescara', 'Abruzzi', 30632.9, '2021-12-29', 2, 8, '2021-06-12 02:21:12', NULL, NULL),
(25, 'Elbertine Quirk', 'equirko@blogspot.com', '7508396713', '2022-01-31', 'M', '648 Lake View Junction', 'Pescara', 'Abruzzi', 41687.5, '2021-06-20', 8, 4, '2021-08-12 23:00:11', NULL, NULL),
(26, 'Adam Meddick', 'ameddickp@intel.com', '7546041456', '2021-05-15', 'M', '341 8th Street', 'Pescara', 'Abruzzi', 54386.9, '2021-08-26', 3, 18, '2022-04-04 04:16:52', NULL, NULL),
(27, 'Reynard Lambert-Ciorwyn', 'rlambertciorwynq@reuters.com', '7831036146', '2019-10-17', 'F', '92264 Sycamore Junction', 'Pescara', 'Abruzzi', 64585.7, '2021-07-08', 1, 12, '2021-07-11 12:53:36', NULL, NULL),
(28, 'Allix Niles', 'anilesr@addtoany.com', '7069838170', '2021-11-08', 'F', '8 Hoard Park', 'Pescara', 'Abruzzi', 58961.6, '2021-12-26', 4, 7, '2021-11-30 21:04:18', NULL, NULL),
(29, 'Rodney Vina', 'rvinas@sourceforge.net', '3121024827', '2019-09-01', 'M', '370 Elgar Pass', 'Pescara', 'Abruzzi', 22234.1, '2021-07-05', 9, 4, '2021-10-04 12:32:29', NULL, NULL),
(30, 'Sada McDougald', 'smcdougaldt@e-recht24.de', '1074741084', '2019-01-31', 'F', '5 Nancy Road', 'Pescara', 'Abruzzi', 86449.4, '2021-12-21', 5, 17, '2021-09-18 04:50:32', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Phone` (`Phone`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `DepartmentId` (`DepartmentId`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Employee` (`EmployeeId`),
  ADD KEY `ApprovedBy` (`RespondedBy`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Employee` (`Employee`),
  ADD KEY `GrantedBy` (`GrantedBy`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Client` (`Client`),
  ADD KEY `Lead` (`Lead`) USING BTREE;

--
-- Indexes for table `project_emp`
--
ALTER TABLE `project_emp`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `project_emp-project` (`ProjectId`),
  ADD KEY `project_emp-user` (`UserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Designation` (`DesignationId`),
  ADD KEY `Department` (`DepartmentId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_emp`
--
ALTER TABLE `project_emp`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `designation`
--
ALTER TABLE `designation`
  ADD CONSTRAINT `designation_ibfk_1` FOREIGN KEY (`DepartmentId`) REFERENCES `department` (`Id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_ibfk_1` FOREIGN KEY (`EmployeeId`) REFERENCES `user` (`Id`),
  ADD CONSTRAINT `leaves_ibfk_2` FOREIGN KEY (`RespondedBy`) REFERENCES `user` (`Id`);

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`Employee`) REFERENCES `user` (`Id`),
  ADD CONSTRAINT `payroll_ibfk_2` FOREIGN KEY (`GrantedBy`) REFERENCES `user` (`Id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`Client`) REFERENCES `client` (`Id`),
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`Lead`) REFERENCES `user` (`Id`);

--
-- Constraints for table `project_emp`
--
ALTER TABLE `project_emp`
  ADD CONSTRAINT `project_emp-project` FOREIGN KEY (`ProjectId`) REFERENCES `project` (`Id`),
  ADD CONSTRAINT `project_emp-user` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`DepartmentId`) REFERENCES `department` (`Id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`DesignationId`) REFERENCES `designation` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
