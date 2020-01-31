-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2020 at 08:42 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodordersystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bankid` int(5) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `bank_status` int(1) NOT NULL,
  `bank_branch` varchar(50) NOT NULL,
  `bank_details` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bankid`, `bank_name`, `bank_status`, `bank_branch`, `bank_details`) VALUES
(1, 'กรุงเทพ', 1, 'เซ็นทรัลลาดพร้าว', 'ทดสอบ'),
(2, 'กรุงไทย', 0, 'ฟิวเจอร์พาร์ครังสิต', 'เลขบัญชี 384-2-48484-9'),
(4, 'กสิกรไทย', 1, 'ฟิวเจอร์พาร์ครังสิต', '-'),
(5, 'ไทยพาณิชย์', 0, 'ฟิวเจอร์พาร์ครังสิต', 'เลขบัญชี 212-1-48485-1'),
(6, 'กรุงเทพ', 0, 'บิ๊กซีสะพานควาย', ''),
(7, 'กรุงเทพ', 0, 'ฟิวเจอร์พาร์ครังสิต', '124-6-65455-4'),
(8, 'กสิกรไทย', 0, 'ฟิวเจอร์พาร์ครังสิต', 'เลขบัญชี 313-4-48393-1\r\n'),
(9, 'ออมสิน', 0, 'พระสมุทรเจดีย์', 'เลขบัญชี 123-3-38383-1');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cusid` int(5) NOT NULL,
  `cus_name` varchar(50) NOT NULL,
  `cus_user` varchar(20) NOT NULL,
  `cus_birth` date NOT NULL,
  `cus_tel` varchar(15) NOT NULL,
  `cus_email` varchar(30) NOT NULL,
  `cus_status` int(1) NOT NULL,
  `cus_password` char(40) NOT NULL,
  `cus_postnum` varchar(5) NOT NULL,
  `cus_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cusid`, `cus_name`, `cus_user`, `cus_birth`, `cus_tel`, `cus_email`, `cus_status`, `cus_password`, `cus_postnum`, `cus_address`) VALUES
(2, 'กฤตวัฒน์ บุญชัยวัฒนา', 'tiees288', '1997-10-20', '0841592654', 'tiees288@gmail.com', 0, 'c841d27e9a1400f2bb1cb830667d4f98a2cab659', '10400', '602/1 ถ.พระราม6 สามเสนใน พญาไท กรุงเทพ'),
(10, 'สมใจ ใจดี', 'tiees188', '1995-10-19', '0841382813', 'gkewkfwkef@gmail.com', 0, 'c841d27e9a1400f2bb1cb830667d4f98a2cab659', '10120', 'kwfwkfkewfkwfkewfwe;l'),
(12, 'สมคิด ใจเย็น', 'tiee188', '1994-11-11', '0852848484', 'somkid@gmail.com', 1, '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', '10120', 'กรุงเทพมหานคร'),
(13, 'สมปอง สองใจ', 'tiee177', '1995-12-11', '0855112142', 'sompong@gmail.com', 0, 'c841d27e9a1400f2bb1cb830667d4f98a2cab659', '10100', 'fkwkfwekfwek'),
(26, 'สมดั่งใจ ซื่อสัตย์', '0813919139', '1978-01-12', '0813919139', 'somdungjai@hotmail.com', 0, '6391159bee4d5c6ba5d17773ded3a73a37302a33', '10112', 'รังสิต'),
(27, 'บุญสม สมบูรณ์', '0821883818', '1997-12-28', '0821883818', 'sombun@gmai.com', 0, '735946114c31d45edd643fd07789474d49d3d1b3', '10111', 'กรุงเทพ'),
(28, 'สมศรี มีตังใช้', '0811222725', '1960-06-15', '0811222725', 's.somsri@hotmail.com', 0, 'b6d52a1a567edc760085dbb07e82aafb30928f7b', '10130', 'อุบลราชธานี'),
(32, 'จักรพัน ช่วยทดสอบ', '0931939191', '1998-01-19', '0931939191', 'jakkapan.test@gmai.com', 1, '3e466b970f58615d31c8bf9ea00e3ae910345425', '10112', 'test'),
(35, 'จักรพันธ์ ชอบท้อแท้', 'jakkapan007', '1997-01-12', '0811282838', 'jakkapan.tortae@hotmail.com', 0, 'e99cf5bf7cc7086b922e77652c2c79394f7bcb4e', '10222', 'kwfwekfwekf'),
(36, 'สมคิด ใจเย็น', '0210300130', '1994-11-11', '0210300130', 'sso2mkid@gmail.com', 0, '53268bf3d4086c6009491831742484018e2ace4a', '10122', 'ลำปาง'),
(39, 'สมศักดิ์ แสนรัก', '0818482842', '1990-02-14', '0818482842', 'somsak@hotmail.com', 0, '64aa749bb5ecf53a72bc2ae91a394463a8d15a23', '10111', 'กรุงเทพ'),
(41, 'ชอบธรรม ไม่โกง', '0811929393', '1954-02-24', '0811929393', 'fkkfdweek@hotmail.com', 0, '7d1064a9f47ab68742eee1139a92d0e5e95dc31f', '10310', 'รังสิต ปทุมธานี'),
(42, 'นํ้าดอกไม้ อร่อยมาก', 'nanako', '2007-02-05', '0877071887', 'jakkapan.mali@hotmail.com', 0, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '10290', '76/3 หมู่4'),
(43, 'มุก', 'Mook10', '2007-02-06', '0812345678', 'ncywcn@hotmail.com', 0, '7c222fb2927d828af22f592134e8932480637c0d', '11111', 'รังสิตย์ภิรมย์'),
(46, 'Somkanae Yuyongsin', 'nornae23', '1970-01-01', '0830646663', 'solady_naenie@hotmail.com', 0, 'f6ec362b401a5b6a7829e9c1152bea2f5a2da7ee', '10500', '123'),
(47, 'ธีระชัย  แย้มดี', 'gunkun', '1970-01-01', '0631906855', 'gunkun11@hotmail.com', 0, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '20822', 'aaaaa'),
(49, 'จักรพันธ์ ', 'hon11', '1970-01-01', '0877755555', 'kun25645@hotmail.com', 1, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '12090', 'aaaaaaaaaaaa'),
(51, 'จักรยึก จักรยัก', '05022541', '1970-01-01', '0869850133', 'kun1234@hotmail.com', 0, 'dd84468b2dd311739439d102a308c77a3519f536', '12054', 'aaaaaaaaaaa'),
(52, 'จักรพันธ์  มะลิแย้ม', '0631906899', '2007-12-31', '0631906899', 'zaza@hotmail.com', 0, '51311af009f1db8b71fcfec43d3097dffc85e4e0', '12090', 'aaaaa'),
(53, 'มะยิแย้ม จิตแจ่มใส่', '0850542313', '2009-03-19', '0850542313', 'konnn@hotmail.com', 0, 'f6b360be3e3529b421fb9139def0db8a93d71371', '20854', '205/3 หมู่4'),
(55, 'จักรพัน ฝันลำเอียง', '0842289293', '1949-03-16', '0842289293', 'jakkapadn.to2rt2ae@hotmail.com', 0, '8b295c6bd7ecab3a1bd69030583b1563f5c2fea2', '10310', 'ท้อแท้ทุกที่'),
(56, 'สามารถ รักโลก', 'tiees278', '1997-10-20', '0811222725', 'tiees278@gmail.com', 0, '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', '10130', 'กรุงเทพ'),
(57, 'john', 'johnjohn', '2007-12-12', '0888898986', 'john@john.com', 0, '98720f0c84cca93a8daca922504fabfa9429bae4', '72210', 'หฟกหฟกหฟกหฟก'),
(58, 'Thanaphat', 'prapra', '2007-12-04', '0847774487', 'pakka28124@hotmail.co.th', 0, '1f6c3b2c37acc5c769284e60e1b72f688c1d9049', '10110', 'ฟหกฟหกฟห'),
(59, 'กัตตวิทย์ สมใจหมาย', '0842859302', '1985-07-25', '0842859302', 'Kattawit@gmail.com', 0, '85b6a42742711d921a703ecf3d1ba637f942720f', '10120', 'รังสิต ปทุมธานี'),
(60, 'สมหมาย ใจกล้า', 'tiees298', '1980-12-31', '0866557788', 'sommai@gmail.com', 0, '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', '10140', 'รังสิต ปทุมธานี'),
(61, 'นางสายใจ ใจดี', 'tiees268', '0000-00-00', '0817484838', 'saijai.j@hotmail.com', 0, '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', '10120', 'รังสิต ปทุมธานี'),
(62, 'มะลิแย้ม  จักรพันธ์', 'jakkapan', '1974-10-25', '0847336664', 'looph@hotmail.com', 0, 'dd84468b2dd311739439d102a308c77a3519f536', '10290', '76/3'),
(64, 'Johny Walker', '0837484828', '1961-12-01', '0837484828', 'Johny@gmail.com', 0, '4adaaf06335e3a7feab240e51973488320464a01', '10150', 'Bangkok'),
(65, 'สายไหม ใสไหม', 'krittawats', '1990-07-19', '0918483848', 'saimai@hotmail.com', 0, '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', '10200', 'รังสิต ปทุมธานี'),
(67, 'เบ จูฮยอน', 'Maimyyyyy', '1991-01-21', '0822278398', 'Maimyy@hotmail.com', 0, 'd77eb659be084651d02fc84719bef9265e070142', '13160', '55/148 จ.อยุธยา'),
(68, 'ยศกร สุขนิสัย', 'jakkapan22', '0000-00-00', '0844705454', 'koknn@hotmail.com', 0, 'dd84468b2dd311739439d102a308c77a3519f536', '10290', '79/3 หมู่'),
(69, 'krittawat boon', 'krittawat222', '2008-12-25', '0811838381', 'kritta@hotmail.com', 0, 'c841d27e9a1400f2bb1cb830667d4f98a2cab659', '10120', 'กรุงเทพ'),
(70, 'เกาอัด  เสริมดี', 'admin', '0000-00-00', '0863158963', 'koggknn@hotmail.com', 0, 'dd84468b2dd311739439d102a308c77a3519f536', '10290', '77/3'),
(71, 'กิตินันท์ รักยืนยง', 'tiees218', '1984-07-12', '0833313341', 'kitinan@gmail.com', 0, '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', '10130', 'กรุงเทพมหานคร');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `foodid` int(5) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `food_type` int(1) NOT NULL COMMENT 'ประเภทอาหาร',
  `food_price` float(7,2) NOT NULL,
  `food_qty` int(4) NOT NULL COMMENT 'จำนวน',
  `food_count` varchar(30) NOT NULL,
  `food_image` varchar(100) NOT NULL,
  `food_recomend` int(1) NOT NULL DEFAULT 0 COMMENT 'จำนวนการแนะนำ',
  `food_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`foodid`, `food_name`, `food_type`, `food_price`, `food_qty`, `food_count`, `food_image`, `food_recomend`, `food_status`) VALUES
(2, 'กะเพราขาหมู', 0, 35.00, 5, 'จาน', 'images/food/กะเพราขาหมู.jpg', 51, 0),
(3, 'ไข่เจียว', 1, 5.00, 50, 'จาน', 'images/food/ไข่เจียว.jpg', 47, 0),
(5, 'คะน้าหมูกรอบ', 0, 35.00, 20, 'จาน', 'images/food/คะน้าหมูกรอบ.jpg', 18, 0),
(6, 'สุกี้น้ำทะเล', 2, 40.00, 19, 'ชาม', 'images/food/สุกี้น้ำทะเล.jpg', 35, 0),
(8, 'สุกี้น้ำหมู', 2, 40.00, 10, 'ชาม', 'images/food/สุกี้น้ำหมู.jpg', 10, 0),
(9, 'หมูทอดกระเทียม', 1, 30.00, 5, 'จาน', 'images/food/หมูทอดกระเทียม.jpg', 7, 0),
(12, 'มาม่าผัดขี้เมา', 0, 35.00, 10, 'จาน', 'images/food/มาม่าผัดขี้เมา.jpg', 0, 1),
(13, 'โค๊ก', 3, 15.00, 50, 'ขวด', 'images/food/โค๊ก.jpg', 38, 0),
(14, 'ผัดซีอิ้ว', 0, 35.00, 20, 'จาน', 'images/food/ผัดซีอิ๊ว.jpg', 0, 0),
(15, 'สุกี้แห้งทะเล', 2, 40.00, 30, 'ชาม', 'images/food/สุกี้แห้งทะเล.jpg', 0, 1),
(16, 'น้ำแดง', 3, 20.00, 30, 'ขวด', 'images/food/น้ำแดง.jpg', 2, 0),
(17, 'คะน้าปลากระป๋อง', 0, 35.00, 25, 'จาน', 'images/food/คะน้าปลากระป๋อง.jpg', 0, 0),
(23, 'กะเพราหมูกรอบ', 0, 35.00, 50, 'จาน', 'images/food/กะเพราหมูกรอบ.jpg', 6, 0),
(24, 'ราดหน้าหมู', 0, 35.00, 30, 'จาน', 'images/food/ราดหน้าหมู.jpg', 7, 0),
(25, 'ปลาหมึกผัดผงกะหรี่', 0, 45.00, 35, 'จาน', 'images/food/ปลาหมึกผัดผงกะหรี่.jpg', 7, 0),
(27, 'กระเจี๊ยบ', 3, 20.00, 20, 'ขวด', 'images/food/กระเจี๊ยบ.jpg', 4, 0),
(29, 'แตงโมปั่น', 3, 35.00, 20, 'แก้ว', 'images/food/น้ำแตงโม.jpg', 9, 0),
(30, 'ชามะลิ', 3, 30.00, 20, 'ขวด', 'images/food/jasmine-tea.jpg', 29, 0),
(31, 'เนสเล่ เพียวไลฟ์', 3, 10.00, 100, 'ขวด', 'images/food/nestle_pure.jpg', 1, 0),
(32, 'ไข่ดาว', 1, 5.00, 20, 'จาน', 'images/food/images_ไข่ดาว.jpeg', 5, 0),
(33, 'ทดสอบ อาหาร', 2, 30.00, 20, 'ชิ้น', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `materialdetails`
--

CREATE TABLE `materialdetails` (
  `matdetailid` int(5) NOT NULL,
  `matdetail_qty` int(3) NOT NULL COMMENT 'จำนวน(ที่มี)',
  `matdetail_status` int(1) NOT NULL COMMENT 'สถานะ',
  `foodid` int(5) NOT NULL,
  `matterialid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `materialid` int(5) NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `material_qty` int(4) NOT NULL,
  `material_count` varchar(30) NOT NULL,
  `material_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`materialid`, `material_name`, `material_qty`, `material_count`, `material_status`) VALUES
(1, 'เนื้อกุ้ง', 15, 'ชิ้น', 0),
(2, 'เนื้อหมู', 15, 'ชิ้น', 0),
(3, 'เนื้อไก่', 40, 'ชิ้น', 0),
(5, 'ปลาหมึก', 20, 'กรัม', 1),
(6, 'เห็ดม่วง', 20, 'กรัม', 0),
(7, 'ไก่ยาง', 6, 'ตัว', 0),
(8, 'เนื้อปู', 300, 'กรัม', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetid` int(5) UNSIGNED ZEROFILL NOT NULL,
  `orderdet_amount` int(3) NOT NULL COMMENT 'จำนวนอาหารที่สั่ง',
  `orderdet_status` int(1) NOT NULL COMMENT 'สถานะ',
  `orderdet_price` float(7,2) NOT NULL COMMENT 'ราคาที่สั่ง',
  `orderdet_note` varchar(100) NOT NULL COMMENT 'หมายเหตุ',
  `orderid` int(5) UNSIGNED ZEROFILL NOT NULL,
  `foodid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการสั่ง',
  `orderdate` datetime NOT NULL COMMENT 'วัน/เวลาที่สั่ง',
  `order_date_tobedelivery` date NOT NULL COMMENT 'วันกำหนดส่ง',
  `order_time_tobedelivery` time NOT NULL COMMENT 'เวลากำหนดส่ง',
  `order_date_delivered` date NOT NULL COMMENT 'วันที่ส่ง',
  `order_time_delivered` time NOT NULL COMMENT 'เวลาส่ง',
  `order_delivery_place` varchar(100) NOT NULL COMMENT 'สถานที่ส่ง',
  `order_status` int(1) NOT NULL COMMENT 'สถานะการสั่ง',
  `order_type` int(1) NOT NULL COMMENT 'ประเภทการสั่ง',
  `order_totalprice` float(7,2) NOT NULL COMMENT 'ราคารวม',
  `order_evidence` varchar(100) NOT NULL COMMENT 'หลักฐานการชำระ',
  `order_evidence_date` datetime NOT NULL,
  `tables_no` int(5) DEFAULT NULL,
  `payno` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `cusid` int(5) NOT NULL,
  `reserv_id` int(5) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payno` int(5) UNSIGNED ZEROFILL NOT NULL,
  `pay_date` datetime NOT NULL,
  `pay_billdate` datetime NOT NULL,
  `payamount` float(7,2) NOT NULL,
  `pay_type` int(1) NOT NULL,
  `pay_status` int(1) NOT NULL,
  `pay_note` varchar(100) NOT NULL,
  `staffid` int(5) NOT NULL,
  `bankid` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reserv_id` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการจอง',
  `reserv_date_appointment` date NOT NULL COMMENT 'วันที่นัด',
  `reserv_time_appointment` time NOT NULL COMMENT 'เวลานัด',
  `reserv_date_reservation` datetime NOT NULL,
  `reserv_status` int(1) NOT NULL,
  `reserv_note` varchar(100) NOT NULL,
  `cusid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reserv_id`, `reserv_date_appointment`, `reserv_time_appointment`, `reserv_date_reservation`, `reserv_status`, `reserv_note`, `cusid`) VALUES
(00001, '2020-01-23', '11:30:00', '2020-01-22 12:59:00', 0, '', 28);

-- --------------------------------------------------------

--
-- Table structure for table `reservelist`
--

CREATE TABLE `reservelist` (
  `reservlist_id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `reservlist_amount` int(3) NOT NULL COMMENT 'จำนวนคนจอง',
  `reservlist_status` int(1) NOT NULL COMMENT 'สถานะ',
  `reservlist_note` varchar(100) NOT NULL COMMENT 'หมายเหตุ',
  `reserv_id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `tables_no` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservelist`
--

INSERT INTO `reservelist` (`reservlist_id`, `reservlist_amount`, `reservlist_status`, `reservlist_note`, `reserv_id`, `tables_no`) VALUES
(00001, 4, 0, '', 00001, 21);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` int(5) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_username` varchar(20) NOT NULL,
  `staff_password` char(40) NOT NULL,
  `staff_address` varchar(50) NOT NULL,
  `staff_postnum` varchar(5) NOT NULL,
  `staff_email` varchar(30) NOT NULL,
  `staff_tel` varchar(15) NOT NULL,
  `staff_birth` date NOT NULL,
  `staff_nationid` varchar(13) NOT NULL,
  `staff_level` int(1) NOT NULL,
  `staff_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `staff_name`, `staff_username`, `staff_password`, `staff_address`, `staff_postnum`, `staff_email`, `staff_tel`, `staff_birth`, `staff_nationid`, `staff_level`, `staff_status`) VALUES
(1, 'เจ้าของร้าน', 'admin', '7ff3900aa7317ee9f16dc3e18d52adf2d54e89af', 'กรุงเทพมหานคร รังสิต', '10400', 'admin.foodorder@hotmail.com', '021304402', '1980-02-14', '1101402158707', 1, 0),
(8, 'กฤตวัฒน์ บุญชัยวัฒนา', 'staff', '7c222fb2927d828af22f592134e8932480637c0d', 'wefewfkwkfwfke', '10121', 'tiees28ก8@gmail.com', '0841592644', '1997-10-20', '1101402144444', 0, 0),
(13, 'สมใจ รักทำงาน', '1021020103031', '08e8e488a5ce774f5fc5111a19c2f3b33da880dd', 'กรุงเทพมหานคร', '10111', 'somjai@hotmail.com', '0818318312', '1989-04-12', '1021020103031', 0, 0),
(14, 'จักรพัน มะลิไม่แย้ม', '4203113013030', '6a22f3557518abca1fda88e44cbd11306ff1f32e', 'kewfwefkwe', '11110', 'jakkapasn@hotmail.com', '0939193193', '1998-02-05', '4203113013030', 0, 0),
(15, 'ขยัน ตั้งใจ', '1303030032304', '845aacbbffa926425d21bd7c22b8da5bc64c8dfe', 'รังสิต ปทุมธานี', '10210', 'kayun@hotmai.com', '0841139391', '1989-04-12', '1303030032304', 0, 0),
(19, 'ธีรชัย มะลิแย้ม', '1040404020200', 'f21daf57866d04692aafe9edf601be065e30a4d2', 'กรุงเทพมหานคร', '10120', 'teerachai.ma@hotmail.com', '0913818118', '1977-02-10', '1040404020200', 0, 0),
(20, 'ธีรชัย มะลิแย้มแย้ม', '3044939494344', 'bc8189d0706d5e974bb249486813f789e11a6651', 'kewfwkfkew', '10111', 'fwelflew@hotmail.com', '0913818228', '1996-10-20', '3044939494344', 0, 1),
(21, 'สมคะเน อยู่ยงสินธุ์', '1040103113030', '3cfec8c701e34a503950bfad2ffe369144519878', 'กรุงเทพฯ', '10340', 'somkanae.yuyo@bumail.net', '0811929992', '1995-12-23', '1040103113030', 0, 0),
(28, 'จักรพันธ์ ร้อยล้าน', '1110500054444', '3fec41893c8c0d7e9f8f25dc98bd4cd0b8974d39', 'ท้อแท้ในย่านพระราม 2', '10290', 'lolpp@hotmail.com', '0844041887', '1997-02-04', '1110500054444', 1, 0),
(29, 'แอดมิน ชอบทดสอบ', 'test_admin', '9eac717147af31497c3ba768d00f90ea46807910', 'กรุงเทพมหานคร', '10140', '', '0891111111', '2000-11-30', '', 1, 0),
(30, 'จักรพัน ชอบหาเรื่อง', '4234223224422', '010b6c56166cd5aaa82e81ef255181ca669980be', 'ำดไดไำด', '10120', 'jakkddapan.n@krittawat.com', '0843432010', '2001-06-14', '4234223224422', 1, 0),
(33, 'จักรกฤดิ์ ชอบผิดนัด', '1040949479293', 'cc5fb5adce99cea1dce94c5a64cddce551954ada', 'กรุงเทพมหานคร', '10110', '', '0827561718', '1990-06-13', '1040949479293', 0, 0),
(34, 'มะลิ ยิ้มแย้ม', '1393049498483', '536c6f9bf1cd3854a1ef2434497b9b60a19f89f0', 'จตุจักร กรุงเทพมหานคร', '10200', 'Mali.yim@gmail.com', '0813859594', '1993-11-17', '1393049498483', 0, 0),
(35, 'สุไพลิน น้อยคนดี', '1122222444455', '47a9af7851c1e4e3720423dbb13fbfeb4c21e786', 'เพชรบูรณ์', '40140', 'Suphailin.noyk@bumail.net', '0811222333', '1997-12-28', '1122222444455', 0, 0),
(37, 'ทดสอบ พนักงาน', '1848383848848', '19790b36000e6f7433af5f78f538e19a1c36db4d', 'กรุงเทพมหานคร', '10400', 'Test@krittawat.net', '0828272772', '1985-10-16', '1848383848848', 0, 0),
(38, 'ทดดดด สอบบบบ', '1050400020220', '9c5cbd7c8714fe2cf617ff7ac6703c0fd4a69a55', 'กรุงเทพ', '10220', '', '0811949492', '2002-12-27', '1050400020220', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tables_no` int(5) NOT NULL,
  `tables_seats` int(2) NOT NULL,
  `tables_status_reserve` int(1) NOT NULL,
  `tables_status_use` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tables_no`, `tables_seats`, `tables_status_reserve`, `tables_status_use`) VALUES
(6, 4, 0, 0),
(9, 2, 0, 0),
(10, 4, 0, 0),
(13, 6, 0, 1),
(15, 6, 0, 0),
(16, 4, 0, 0),
(17, 6, 0, 0),
(18, 2, 0, 0),
(19, 12, 0, 0),
(21, 4, 0, 0),
(22, 12, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bankid`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cusid`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`foodid`);

--
-- Indexes for table `materialdetails`
--
ALTER TABLE `materialdetails`
  ADD PRIMARY KEY (`matdetailid`),
  ADD KEY `foodid` (`foodid`),
  ADD KEY `matterialid` (`matterialid`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`materialid`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetid`),
  ADD KEY `orderid` (`orderid`),
  ADD KEY `foodid` (`foodid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `tables_no` (`tables_no`),
  ADD KEY `bill_no` (`payno`),
  ADD KEY `cusid` (`cusid`),
  ADD KEY `reserv_id` (`reserv_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payno`),
  ADD KEY `staffid` (`staffid`),
  ADD KEY `bankid` (`bankid`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reserv_id`),
  ADD KEY `cusid` (`cusid`);

--
-- Indexes for table `reservelist`
--
ALTER TABLE `reservelist`
  ADD PRIMARY KEY (`reservlist_id`),
  ADD KEY `reserv_id` (`reserv_id`),
  ADD KEY `tables_no` (`tables_no`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`tables_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bankid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cusid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `foodid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `materialdetails`
--
ALTER TABLE `materialdetails`
  MODIFY `matdetailid` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `materialid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetid` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการสั่ง';

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payno` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reserv_id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจอง', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservelist`
--
ALTER TABLE `reservelist`
  MODIFY `reservlist_id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `tables_no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materialdetails`
--
ALTER TABLE `materialdetails`
  ADD CONSTRAINT `materialdetails_ibfk_1` FOREIGN KEY (`foodid`) REFERENCES `foods` (`foodid`),
  ADD CONSTRAINT `materialdetails_ibfk_2` FOREIGN KEY (`matterialid`) REFERENCES `materials` (`materialid`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`foodid`) REFERENCES `foods` (`foodid`),
  ADD CONSTRAINT `orderdetails_ibfk_3` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cusid`) REFERENCES `customers` (`cusid`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`tables_no`) REFERENCES `tables` (`tables_no`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`payno`) REFERENCES `payment` (`payno`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`reserv_id`) REFERENCES `reservations` (`reserv_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`bankid`) REFERENCES `banks` (`bankid`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`staffid`) REFERENCES `staff` (`staffid`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`cusid`) REFERENCES `customers` (`cusid`);

--
-- Constraints for table `reservelist`
--
ALTER TABLE `reservelist`
  ADD CONSTRAINT `reservelist_ibfk_1` FOREIGN KEY (`tables_no`) REFERENCES `tables` (`tables_no`),
  ADD CONSTRAINT `reservelist_ibfk_2` FOREIGN KEY (`reserv_id`) REFERENCES `reservations` (`reserv_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
