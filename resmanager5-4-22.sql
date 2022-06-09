-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2022 at 01:05 PM
-- Server version: 5.5.34
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `mr_category`
--

CREATE TABLE IF NOT EXISTS `mr_category` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY` varchar(25) NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mr_category`
--

INSERT INTO `mr_category` (`CID`, `CATEGORY`, `STATUS`) VALUES
(1, 'Procurement', 1),
(2, 'Appointment/Promotion', 1),
(3, 'Event Organization', 1),
(4, 'MOU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mr_department`
--

CREATE TABLE IF NOT EXISTS `mr_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deptname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `mr_department`
--

INSERT INTO `mr_department` (`id`, `deptname`, `status`) VALUES
(1, 'Aeronautical Engineering', 1),
(2, 'Architecture', 1),
(3, 'Chemistry', 1),
(4, 'Civil Engineering', 1),
(5, 'Computer Center', 1),
(6, 'Computer Science And Enginnering', 1),
(7, 'Dean Academics', 1),
(8, 'Dean Admin', 1),
(9, 'Dean Infra & Planning', 1),
(10, 'Dean R & D', 1),
(11, 'Dean Student Affairs', 1),
(12, 'Electrical Manitanance ', 1),
(13, 'Electrical and Electronics Engineering', 1),
(14, 'Electronics And Communication Engineering', 1),
(15, 'Exam Section', 1),
(16, 'Information Science And Engineering', 1),
(17, 'Library', 1),
(18, 'Maintenance', 1),
(19, 'Master of Bussiness Administration', 1),
(20, 'Master of Computer Application', 1),
(21, 'Mathematics', 1),
(22, 'Mechanical Engineering', 1),
(23, 'Office', 1),
(24, 'Physics', 1),
(25, 'Placement Cell', 1),
(26, 'Sports', 1),
(27, 'Vehicle maintanance ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mr_sancauthority`
--

CREATE TABLE IF NOT EXISTS `mr_sancauthority` (
  `AID` int(11) NOT NULL AUTO_INCREMENT,
  `AUTHORITY` varchar(15) NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`AID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mr_sancauthority`
--

INSERT INTO `mr_sancauthority` (`AID`, `AUTHORITY`, `STATUS`) VALUES
(1, 'PRINCIPAL', 1),
(2, 'GC CHAIRMAN', 1),
(3, 'GC', 1),
(4, 'BOM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mr_status`
--

CREATE TABLE IF NOT EXISTS `mr_status` (
  `SNO` int(11) NOT NULL AUTO_INCREMENT,
  `CID` int(11) NOT NULL,
  `RSTATUSNAME` varchar(30) NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SNO`),
  KEY `fk_foreign_CID` (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `mr_status`
--

INSERT INTO `mr_status` (`SNO`, `CID`, `RSTATUSNAME`, `STATUS`) VALUES
(1, 1, 'Resolution initiated', 1),
(2, 1, 'Quotation called', 1),
(3, 1, 'Comparative prepared', 1),
(4, 1, 'Agency finalized', 1),
(5, 1, 'Order placed', 1),
(6, 1, 'Material service Received', 1),
(7, 1, 'Bills Settled', 1),
(8, 2, 'Order Issued', 1),
(9, 2, 'Candidate Reported /Joined', 1),
(10, 3, 'Preparations started', 1),
(11, 3, 'Event about to happen', 1),
(12, 3, 'Event conducted', 1),
(13, 3, 'Bills Settled', 1),
(14, 4, 'Signed /Executed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mr_usertype`
--

CREATE TABLE IF NOT EXISTS `mr_usertype` (
  `SLNO` int(11) NOT NULL AUTO_INCREMENT,
  `USERTYPE` varchar(64) NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SLNO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mr_usertype`
--

INSERT INTO `mr_usertype` (`SLNO`, `USERTYPE`, `STATUS`) VALUES
(1, 'PRINCIPAL', 1),
(2, 'GC', 1),
(3, 'HOD / Section Head', 1),
(4, 'Office', 1),
(5, 'Payment', 1),
(6, 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `res_master`
--

CREATE TABLE IF NOT EXISTS `res_master` (
  `SNO` int(11) NOT NULL AUTO_INCREMENT,
  `RES_TITLE` varchar(128) NOT NULL,
  `CID` int(11) NOT NULL,
  `DEPT` int(11) NOT NULL,
  `RESDATE` date NOT NULL,
  `RESCODE` varchar(30) NOT NULL,
  `RESNO` varchar(64) NOT NULL,
  `RES_STATUS_ID` int(11) NOT NULL,
  `RES_IMAGE_URL` varchar(64) DEFAULT NULL,
  `RES_TEXT` longtext,
  `AID` int(11) NOT NULL,
  `CRDATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SNO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `res_master`
--

INSERT INTO `res_master` (`SNO`, `RES_TITLE`, `CID`, `DEPT`, `RESDATE`, `RESCODE`, `RESNO`, `RES_STATUS_ID`, `RES_IMAGE_URL`, `RES_TEXT`, `AID`, `CRDATE`, `STATUS`) VALUES
(1, 'Purchasing Computers', 1, 5, '2021-06-01', '115', 'GCRES100', 1, NULL, 'Purchasing Computers', 2, '2021-06-01', 1),
(2, 'Purchase of Projectors', 1, 5, '2021-07-01', '215', 'GCRES101', 1, NULL, 'Purchase of Projectors', 2, '2021-07-01', 1),
(3, 'Purchase of Desks', 1, 5, '2021-08-01', '315', 'GCRES102', 1, NULL, 'Purchase of Desks', 2, '2021-08-01', 1),
(4, 'Purchase of Server', 1, 5, '2021-09-01', '415', 'GCRES103', 1, NULL, 'Purchase of Server', 4, '2021-09-01', 1),
(5, 'Purchase of WorkBenches', 1, 14, '2021-10-01', '5114', 'GCRES104', 1, NULL, 'Purchase of WorkBenches', 3, '2021-10-01', 1),
(6, 'Purchase of Lathe', 1, 22, '2021-11-01', '6122', 'GCRES105', 1, NULL, 'Purchase of Lathe', 2, '2021-11-01', 1),
(7, 'Purchase of Software', 1, 6, '2021-12-01', '716', 'GCRES106', 1, NULL, 'Purchase of Software', 2, '2021-12-01', 1),
(8, 'CSE Requirements', 1, 6, '2022-01-01', '816', 'GCRES107', 1, NULL, 'CSE Requirements', 1, '2022-01-01', 0),
(9, 'ECE Requirements', 1, 14, '2022-01-07', '9114', 'GCRES108', 1, NULL, 'ECE Requirements', 1, '2022-01-07', 1),
(10, 'EE Requirements', 1, 13, '2022-01-14', '10113', 'GCRES109', 1, NULL, 'EE Requirements', 1, '2022-01-14', 1),
(11, 'ME Requirements', 1, 22, '2022-01-21', '11122', 'GCRES110', 1, NULL, 'ME Requirements', 1, '2022-01-21', 1),
(12, 'CV Requirements', 1, 4, '2022-01-28', '1214', 'GCRES111', 1, NULL, 'CV Requirements', 1, '2022-01-28', 1),
(13, 'MBA Requirements', 1, 19, '2022-02-01', '20220328GCC0341', 'GCRES112', 1, NULL, 'MBA Requirements modified.', 2, '2022-03-28', 1),
(14, 'MCA Requirements', 1, 20, '2022-02-01', '14120', 'GCRES113', 1, NULL, 'MCA Requirements', 1, '2022-02-01', 1),
(15, 'AERO Requirements', 1, 1, '2022-02-08', '1511', 'GCRES114', 1, NULL, 'AERO Requirements', 1, '2022-02-08', 1),
(16, 'ARCH Requirements', 1, 2, '2022-02-08', '1612', 'GCRES115', 1, NULL, 'ARCH Requirements', 1, '2022-02-08', 1),
(17, 'Appointment of Assistant Professors In CSE', 2, 6, '2021-10-10', '1726', 'GCRES116', 1, NULL, 'Appointment of Assistant Professors In CSE', 2, '2021-10-10', 1),
(18, 'Appointment of Assistant Professors EC', 2, 14, '2021-10-11', '18214', 'GCRES117', 1, NULL, 'Appointment of Assistant Professors EC', 2, '2021-10-11', 1),
(19, 'Appointment of Assistant Professors ISE', 2, 16, '2021-10-12', '19216', 'GCRES118', 1, NULL, 'Appointment of Assistant Professors ISE', 2, '2021-10-12', 1),
(20, 'Appointment of Assistant Professors ME', 2, 22, '2021-10-13', '20222', 'GCRES119', 1, NULL, 'Appointment of Assistant Professors ME', 2, '2021-10-13', 1),
(21, 'Appointment of Assistant Professors Civil', 2, 4, '2021-10-14', '2124', 'GCRES120', 1, NULL, 'Appointment of Assistant Professors Civil', 2, '2021-10-14', 1),
(22, 'Appointment of Assistant Professors Architecture', 2, 2, '2021-10-15', '2222', 'GCRES121', 1, NULL, 'Appointment of Assistant Professors Architecture', 2, '2021-10-15', 1),
(23, 'Appointment of Assistant Professors Aero', 2, 1, '2021-10-16', '2321', 'GCRES122', 1, NULL, 'Appointment of Assistant Professors Aero', 2, '2021-10-16', 1),
(24, 'Appointment of Assistant Professors MBA', 2, 19, '2021-10-17', '24219', 'GCRES123', 1, NULL, 'Appointment of Assistant Professors MBA', 2, '2021-10-17', 1),
(25, 'Appointment of Assistant Professors MCA', 2, 20, '2021-10-18', '25220', 'GCRES124', 1, NULL, 'Appointment of Assistant Professors MCA', 2, '2021-10-18', 1),
(26, 'AURA 2021', 3, 4, '2021-01-01', '20220328P0314', 'GCRES125', 1, NULL, '', 1, '2022-03-28', 1),
(27, 'AURA 2022', 3, 4, '2022-01-01', '20220328P0441', 'GCRES126', 1, 'NULL', 'AURA 2022', 1, '2022-03-28', 1),
(28, 'FDP', 3, 14, '2022-01-02', '28314', 'GCRES127', 1, NULL, 'FDP', 1, '2022-01-02', 1),
(29, 'International Conference', 3, 14, '2022-01-15', '29314', 'GCRES128', 1, NULL, 'International Conference', 1, '2022-01-15', 1),
(30, 'STTP', 3, 14, '2022-02-04', '30314', 'GCRES129', 1, NULL, 'STTP', 1, '2022-02-04', 1),
(31, 'MOU Ktech', 4, 6, '2021-01-01', '3146', 'GCRES130', 1, NULL, 'MOU Ktech', 1, '2021-01-01', 1),
(32, 'MOU TCS', 4, 6, '2022-01-01', '3246', 'GCRES131', 1, NULL, 'MOU TCS', 1, '2022-01-01', 1),
(33, 'MOU Infosys', 4, 6, '2021-01-01', '3346', 'GCRES132', 1, NULL, 'MOU Infosys', 1, '2021-01-01', 1),
(34, 'MOU Samsung', 4, 6, '2022-01-01', '3446', 'GCRES133', 1, NULL, 'MOU Samsung', 1, '2022-01-01', 1),
(35, 'MOU Wipro', 4, 6, '2022-01-02', '3546', 'GCRES134', 1, NULL, 'MOU Wipro', 1, '2022-01-02', 1),
(36, 'ECE procurement testing', 1, 14, '2022-01-22', '20220211GCC0131', 'BIBE7465', 1, 'CRM1.jpeg', NULL, 2, '2022-02-11', 1),
(37, 'upload testing', 2, 15, '2022-03-03', '20220301GC1100', '3452334', 8, 'Winterschool-2.jpeg', NULL, 3, '2022-03-01', 1),
(38, 'upload testing', 1, 6, '2022-02-25', '20220328GC0329', '543', 1, 'Winterschool-2.jpeg', NULL, 3, '2022-03-28', 1),
(39, 'Internal Hackathon 2022', 3, 6, '2022-03-16', '20220316GCC0136', '23', 1, 'uipath-exam2.jpg', 'NULL', 2, '2022-03-16', 1),
(40, 'Chair Purchasing', 1, 15, '2022-04-01', '20220401GCC0715', '567', 1, 'NULL', 'this is a resolution for Chair purchasing.', 2, '2022-04-01', 1),
(41, 'Chair Procurement for civil', 1, 4, '2022-04-02', '20220404GCC0827', 'wer2', 1, 'NULL', 'This is for texting the cont. \r\nThe procurement of chairs for civil department.', 2, '2022-04-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `res_status_master`
--

CREATE TABLE IF NOT EXISTS `res_status_master` (
  `SNO` int(11) NOT NULL AUTO_INCREMENT,
  `RID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `MDATE` date NOT NULL,
  `REMARK` text NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SNO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `res_status_master`
--

INSERT INTO `res_status_master` (`SNO`, `RID`, `CID`, `SID`, `MDATE`, `REMARK`, `STATUS`) VALUES
(1, 1, 1, 1, '2021-06-01', '0', 1),
(2, 2, 1, 1, '2021-07-01', '0', 1),
(3, 3, 1, 1, '2021-08-01', '0', 1),
(4, 4, 1, 1, '2021-09-01', '0', 1),
(5, 5, 1, 1, '2021-10-01', '0', 1),
(6, 6, 1, 1, '2021-11-01', '0', 1),
(7, 7, 1, 1, '2021-12-01', '0', 1),
(8, 8, 1, 1, '2022-01-01', '0', 1),
(9, 9, 1, 1, '2022-01-07', '0', 1),
(10, 10, 1, 1, '2022-01-14', '0', 1),
(11, 11, 1, 1, '2022-01-21', '0', 1),
(12, 12, 1, 1, '2022-01-28', '0', 1),
(13, 13, 1, 1, '2022-02-01', '0', 1),
(14, 14, 1, 1, '2022-02-01', '0', 1),
(15, 15, 1, 1, '2022-02-08', '0', 1),
(16, 16, 1, 1, '2022-02-08', '0', 1),
(17, 17, 2, 8, '2021-10-10', '0', 1),
(18, 18, 2, 8, '2021-10-11', '0', 1),
(19, 19, 2, 8, '2021-10-12', '0', 1),
(20, 20, 2, 8, '2021-10-13', '0', 1),
(21, 21, 2, 8, '2021-10-14', '0', 1),
(22, 22, 2, 8, '2021-10-15', '0', 1),
(23, 23, 2, 1, '2021-10-16', '0', 1),
(24, 24, 2, 1, '2021-10-17', '0', 1),
(25, 25, 2, 1, '2021-10-18', '0', 1),
(26, 26, 3, 1, '2021-01-01', '0', 1),
(27, 27, 3, 1, '2022-01-01', '0', 1),
(28, 28, 3, 1, '2022-01-02', '0', 1),
(29, 29, 3, 1, '2022-01-15', '0', 1),
(30, 30, 3, 1, '2022-02-04', '0', 1),
(31, 31, 4, 1, '2021-01-01', '0', 1),
(32, 32, 4, 1, '2022-01-01', '0', 1),
(33, 33, 4, 1, '2021-01-01', '0', 1),
(34, 34, 4, 1, '2022-01-01', '0', 1),
(35, 35, 4, 1, '2022-01-02', '0', 1),
(36, 8, 1, 2, '2022-02-11', '0', 1),
(37, 26, 3, 10, '2022-02-11', '0', 1),
(38, 31, 4, 14, '2022-02-11', '0', 1),
(39, 36, 1, 1, '2022-01-22', '0', 1),
(40, 36, 1, 2, '2022-02-11', '0', 1),
(41, 36, 1, 2, '2022-02-11', '0', 1),
(42, 9, 1, 2, '2022-02-11', '0', 1),
(43, 8, 1, 3, '2022-02-12', '0', 1),
(44, 8, 1, 4, '2022-02-14', '0', 1),
(45, 8, 1, 5, '2022-02-14', '0', 1),
(46, 37, 2, 8, '2022-03-03', '0', 1),
(47, 38, 1, 1, '2022-02-25', '0', 1),
(48, 26, 3, 11, '2022-03-02', '0', 1),
(49, 8, 1, 6, '2022-03-05', '0', 1),
(50, 8, 1, 7, '2022-03-06', '0', 1),
(51, 35, 4, 14, '2022-03-06', '0', 1),
(52, 7, 1, 2, '2022-03-07', '0', 1),
(53, 7, 1, 3, '2022-03-07', '0', 1),
(54, 33, 4, 14, '2022-03-07', '0', 1),
(55, 7, 1, 4, '2022-03-08', '0', 1),
(56, 27, 3, 10, '2022-03-15', '0', 1),
(57, 26, 3, 12, '2022-03-15', '0', 1),
(58, 0, 1, 1, '2022-02-14', '0', 1),
(59, 39, 3, 1, '2022-03-16', '0', 1),
(60, 0, 1, 1, '2022-02-24', 'NULL', 1),
(61, 40, 1, 1, '2022-04-01', 'NULL', 1),
(62, 41, 1, 1, '2022-04-02', 'NULL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE IF NOT EXISTS `user_master` (
  `SNO` int(11) NOT NULL AUTO_INCREMENT,
  `USERTYPE` int(11) NOT NULL,
  `DEPT_ID` int(11) NOT NULL,
  `NAME` varchar(64) NOT NULL,
  `EMAIL` varchar(64) NOT NULL,
  `USERNAME` varchar(64) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL,
  `PHONE` bigint(11) NOT NULL,
  `CDATE` datetime DEFAULT NULL,
  `STATUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`SNO`),
  KEY `fk_foreign_SLNO` (`USERTYPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`SNO`, `USERTYPE`, `DEPT_ID`, `NAME`, `EMAIL`, `USERNAME`, `PASSWORD`, `PHONE`, `CDATE`, `STATUS`) VALUES
(1, 1, 0, 'Principal', 'principal@git.edu', 'principal@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 87623876254, '2022-01-20 00:00:00', 1),
(2, 2, 0, 'GC Chairman', 'gcc@git.edu', 'gcc@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 98792362623, '2022-01-20 00:00:00', 1),
(3, 3, 1, 'Aeronautical Engineering', 'aero@git.edu', 'aero@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(4, 3, 2, 'Architecture', 'arch@git.edu', 'arch@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(5, 3, 3, 'Chemistry', 'chem@git.edu', 'chem@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(6, 3, 4, 'Civil Engineering', 'civil@git.edu', 'civil@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(7, 3, 5, 'Computer Center', 'cc@git.edu', 'cc@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(8, 3, 6, 'Computer Science & Engineering', 'cse@git.edu', 'cse@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(9, 3, 7, 'Dean Academics', 'deanacad@git.edu', 'deanacad@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(10, 3, 8, 'Dean Admin', 'deanadmin@git.edu', 'deanadmin@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(11, 3, 9, 'Dean Infra & Planning', 'deaninfra@git.edu', 'deaninfra@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(12, 3, 10, 'Dean R & D', 'deanrnd@git.edu', 'deanrnd@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(13, 3, 11, 'Dean Student Affairs', 'deanstudentaffair@git.edu', 'deanstudentaffair@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(14, 3, 12, 'Electrical Maintanance', 'emaintanance@git.edu', 'emaintanance@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(15, 3, 13, 'Electrical &Electronics Engineering', 'ee@git.edu', 'ee@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(16, 3, 14, 'Electronics & Communication Engineering', 'ec@git.edu', 'ec@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(17, 3, 15, 'Exam Section', 'exam@git.edu', 'exam@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(18, 3, 16, 'Information Science & Engineering', 'ise@git.edu', 'ise@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(19, 3, 17, 'Library', 'library@git.edu', 'library@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(20, 3, 18, 'Maintanance', 'maintanance@git.edu', 'maintanance@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(21, 3, 19, 'Master of Bussiness Administration', 'mba@git.edu', 'mba@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(22, 3, 20, 'Master of Computer Application', 'mca@git.edu', 'mca@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(23, 3, 21, 'Mathematics', 'maths@git.edu', 'maths@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(24, 3, 22, 'Mechanical Engineering', 'mech@git.edu', 'mech@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(25, 3, 23, 'Office User', 'officeuser@git.edu', 'officeuser@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 98648762575, '2022-01-20 00:00:00', 1),
(26, 3, 24, 'Physics', 'phy@git.edu', 'phy@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(27, 3, 25, 'Placement Cell', 'placement@git.edu', 'placement@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(28, 3, 26, 'Sports', 'sports@git.edu', 'sports@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(29, 3, 27, 'Vehical Maaintanance', 'vehical@git.edu', 'vehical@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(30, 4, 0, 'Office', 'office@git.edu', 'office@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(31, 5, 0, 'Payament Section', 'payment@git.edu', 'payment@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1),
(32, 6, -1, 'Admin', 'admin@git.edu', 'admin@git.edu', 'ca04c3b84a22b5fa4ea6e7ad8ee78999', 9634653742, '2022-01-20 00:00:00', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mr_status`
--
ALTER TABLE `mr_status`
  ADD CONSTRAINT `fk_foreign_CID` FOREIGN KEY (`CID`) REFERENCES `mr_category` (`CID`);

--
-- Constraints for table `user_master`
--
ALTER TABLE `user_master`
  ADD CONSTRAINT `fk_foreign_SLNO` FOREIGN KEY (`USERTYPE`) REFERENCES `mr_usertype` (`SLNO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
