-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2022 at 10:14 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faed_teachingload`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_reg_courseid` varchar(10) COLLATE utf8_thai_520_w2 DEFAULT NULL COMMENT 'REG Course id',
  `course_code_th` varchar(5) COLLATE utf8_thai_520_w2 NOT NULL COMMENT 'รหัสวิชา ภาษาไทย',
  `course_code_en` varchar(5) COLLATE utf8_thai_520_w2 DEFAULT NULL COMMENT 'รหัสวิชา ภาษาอังกฤษ',
  `course_name_th` varchar(80) COLLATE utf8_thai_520_w2 NOT NULL COMMENT 'ชื่อวิชา ภาษาไทย',
  `course_name_en` varchar(80) COLLATE utf8_thai_520_w2 DEFAULT NULL COMMENT 'ชื่อวิชา ภาษาอังกฤษ',
  `course_studio` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL DEFAULT '',
  `course_credit` int(1) DEFAULT NULL COMMENT 'หน่วยกิต',
  `course_lec` int(1) DEFAULT NULL COMMENT 'หน่วยกิต ภาคบรรยาย',
  `course_lab` int(1) DEFAULT NULL COMMENT 'หน่วยกิต ภาคปฏิบัติ',
  `course_self` int(1) DEFAULT NULL COMMENT 'หน่วยกิต ภาคการศึกษาด้วยตนเอง',
  `course_lec_hrs` int(2) NOT NULL DEFAULT 15,
  `course_lab_hrs` int(2) NOT NULL DEFAULT 15,
  `course_self_hrs` int(2) NOT NULL DEFAULT 0,
  `course_status` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL DEFAULT 'enable' COMMENT 'สถานะ',
  `course_editor` varchar(20) COLLATE utf8_thai_520_w2 DEFAULT NULL COMMENT 'ผู้บันทึก',
  `course_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_reg_courseid`, `course_code_th`, `course_code_en`, `course_name_th`, `course_name_en`, `course_studio`, `course_credit`, `course_lec`, `course_lab`, `course_self`, `course_lec_hrs`, `course_lab_hrs`, `course_self_hrs`, `course_status`, `course_editor`, `course_lastupdate`) VALUES
(1, NULL, 'สถ274', NULL, 'การออกแบบโครงสร้างไม้และเหล็กในงานสถาปัตยกรรม', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(2, NULL, 'ภท181', NULL, 'การสำรวจ', NULL, '', 2, 1, 3, 3, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(3, NULL, 'สถ431', NULL, 'การวิเคราะห์การบริหารโครงการสถาปัตยกรรม', NULL, '', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(4, NULL, 'สถ376', NULL, 'ระบบโครงสร้างงานสถาปัตยกรรมและภูมิสถาปัตยกรรม', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(5, NULL, 'สถ375', NULL, 'ระบบโครงสร้างงานสถาปัตยกรรมและภูมิสถาปัตยกรรม', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(6, NULL, 'สถ241', NULL, 'สำรวจและการวางผังบริเวณ', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(7, NULL, 'สว594', NULL, 'สัมมนา 4', NULL, '', 1, 0, 2, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(8, NULL, 'สถ114', NULL, 'ประวัติศาสตร์สถาปัตยกรรม', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(9, NULL, 'สถ422', NULL, 'เคหสงเคราะห์', NULL, '', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(10, NULL, 'ภท113', NULL, 'คณิตศาสตร์เพื่องานภูมิทัศน์', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(11, NULL, 'สถ351', NULL, 'การประเมินสภาวะแวดล้อมและความยั่งยืนอาคาร', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(12, NULL, 'ภส367', NULL, 'นิเวศวิทยาภูมิทัศน์', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(13, NULL, 'ผม594', NULL, 'สัมมนา 4', NULL, '', 1, 0, 2, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(14, NULL, 'ผม552', NULL, 'เมืองกับการเปลี่ยนแปลงสภาพภูมิอากาศ', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(15, NULL, 'ผม512', NULL, 'ปฏิบัติการวางผังเมืองและสภาพแวดล้อม', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(16, NULL, 'ผม592', NULL, 'สัมมนา 2', NULL, '', 1, 0, 2, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(17, NULL, 'ผม515', NULL, 'การบริหารจัดการเมืองและนิเวศแวดล้อมอย่างมีส่วนร่วม', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(18, NULL, 'ภส490', NULL, 'กฎหมายที่ดิน ผังเมืองและสิ่งแวดล้อม', NULL, '', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(19, NULL, 'ภท342', NULL, 'การสร้างและตกแต่งภูมิทัศน์', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(20, NULL, 'ภท323', NULL, 'ภูมิสารสนเทศเพื่องานภูมิทัศน์', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(21, NULL, 'ผม514', NULL, 'การวางแผนโครงสร้างพื้นฐานสีเขียว', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(22, NULL, 'ภท111', NULL, 'เขียนแบบก่อสร้างภูมิทัศน์ 1', NULL, '', 3, 1, 6, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(23, NULL, 'ภท335', NULL, 'พืชพรรณ และการออกแบบ 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(24, NULL, 'ภท436', NULL, 'การวางแผนและออกแบบพื้นที่นันทนาการ', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(25, NULL, 'ภท343', NULL, 'การบริหารงานก่อสร้างภูมิทัศน์', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(26, NULL, 'ภท324', NULL, 'ภูมิทัศน์และนวัตกรรม', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(27, NULL, 'ภท315', NULL, 'การประมาณราคาการก่อสร้างภูมิทัศน์', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(28, NULL, 'ภท446', NULL, 'การบริหารจัดการธุรกิจภูมิทัศน์', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(29, NULL, 'ภท231', NULL, 'การออกแบบภูมิทัศน์ 1 กลุ่ม 1', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(30, NULL, 'ภท231', NULL, 'การออกแบบภูมิทัศน์ 1 กลุ่ม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(31, NULL, 'ภท493', NULL, 'โครงงานวิชาชีพภูมิทัศน์', NULL, 'zero', 3, 1, 6, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(32, NULL, 'ภท282', NULL, 'ปฏิบัติการก่อสร้างภูมิทัศน์ 1', NULL, '', 2, 1, 3, 3, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(33, NULL, 'ภท459', NULL, 'หลักการรุกขกรรมสมัยใหม่', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(34, NULL, 'ภท214', NULL, 'สรีระวิทยาของพืชสำหรับงานภูมิทัศน์', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(35, NULL, 'ภท253', NULL, 'วัสดุพืชพรรณสำหรับงานภูมิทัศน์ 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(36, NULL, 'ภส252', NULL, 'วัสดุพืชพรรณและการเลือกใช้ 2 กลุ่ม 1', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(37, NULL, 'ภส252', NULL, 'วัสดุพืชพรรณและการเลือกใช้ 2 กลุุ่่ม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(38, NULL, 'ภท373', NULL, 'การบริหารและการจัดการธุรกิจสนามกอล์ฟ', NULL, 'studio', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:11:21'),
(39, NULL, 'ภท361', NULL, 'นิเวศน์วิทยา และการจัดการสิ่งแวดล้อมสนามกอล์ฟ', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(40, NULL, 'สถ497', NULL, 'สหกิจศึกษา', NULL, 'zero', 9, 0, 270, 0, 0, 0, 0, 'enable', 'Worachet', '2022-03-31 13:11:21'),
(41, NULL, 'ภท152', NULL, 'รุกขวิทยาสำหรับงานภูมิทัศน์', NULL, '', 2, 1, 3, 3, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(42, NULL, 'ภท356', NULL, 'วนวัฒน์วิทยาเพื่องานภูมิทัศน์', NULL, 'studio', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:11:21'),
(43, NULL, 'ภท151', NULL, 'วัสดุพืชพรรณและการจัดจำแนก', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(44, NULL, 'ภส435', NULL, 'การออกแบบภูมิสถาปัตยกรรม 5', NULL, 'studio', 5, 2, 9, 8, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(45, NULL, 'ภส342', NULL, 'การก่อสร้างทางภูมิสถาปัตยกรรม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(46, NULL, 'ภส395', NULL, 'ปฏิบัติงานภูมิสถาปัตยกรรมภาคสนาม', NULL, '', 3, 1, 4, 4, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(47, NULL, 'ภส333', NULL, 'การออกแบบภูมิสถาปัตยกรรม 3', NULL, 'studio', 4, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(48, NULL, 'ภส496', NULL, 'การเตรียมวิทยานิพนธ์', NULL, 'studio', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(49, NULL, 'ภส599', NULL, 'สัมมนาภูมิสถาปัตยกรรม', NULL, '', 3, 2, 2, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(50, NULL, 'ภส122', NULL, 'ประวัติภูมิสถาปัตยกรรม', NULL, '', 2, 2, 0, 4, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(51, NULL, 'ภส339', NULL, 'การออกแบบร่างภูมิสถาปัตยกรรม 3', NULL, '', 1, 0, 3, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(52, NULL, 'ภท222', NULL, 'คอมพิวเตอร์สำหรับงานนำเสนอ กลุ่ม 1', NULL, '', 2, 1, 3, 3, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(53, NULL, 'ภท222', NULL, 'คอมพิวเตอร์สำหรับงานนำเสนอ กลุุ่่ม 2', NULL, '', 2, 1, 3, 3, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(54, NULL, 'ภส446', NULL, 'การบริหารงานก่อสร้างและการดูแลรักษางานภูมิสถาปัตยกรรม', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(55, NULL, 'ภส444', NULL, 'การก่อสร้างทางภูมิสถาปัตยกรรม 4', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(56, NULL, 'ภส182', NULL, 'การออกแบบสถาปัตยกรรม', NULL, 'studio', 5, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:11:20'),
(57, NULL, 'ภส115', NULL, 'เลขะนิเทศ 2', NULL, '', 3, 1, 6, 5, 15, 15, 0, 'enable', 'Umnarj', '2022-04-01 14:49:55'),
(58, NULL, 'ภส354', NULL, 'การออกแบบวางผังพืชพรรณ 2', NULL, 'studio', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(59, NULL, 'ภส225', NULL, 'คอมพิวเตอร์ขั้นสูงในงานภูมิสถาปัตยกรรม', NULL, '', 2, 1, 3, 3, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(60, NULL, 'ภส231', NULL, 'การออกแบบภูมิสถาปัตยกรรม 1', NULL, 'studio', 4, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:11:20'),
(61, NULL, 'ภส237', NULL, 'การออกแบบร่างภูมิสถาปัตยกรรม 1', NULL, '', 1, 0, 3, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(62, NULL, 'สถ382', NULL, 'ออกแบบสถาปัตยกรรมเพื่อสิ่งแวดล้อม 2', NULL, 'studio', 5, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(63, NULL, 'สถ373', NULL, 'คอมพิวเตอร์ขั้นสูงสำหรับงานสถาปัตยกรรม กลุ่่ม 1', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(64, NULL, 'สถ373', NULL, 'คอมพิวเตอร์ขั้นสูงสำหรับงานสถาปัตยกรรม กลุ่่ม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(65, NULL, 'สถ441', NULL, 'การประมาณราคาในงานสถาปัตยกรรม', NULL, '', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(66, NULL, 'สถ141', NULL, 'พื้นฐานงานก่อสร้างเบื้องต้น', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(67, NULL, 'สถ374', NULL, 'เทคโนโลยีสิ่งแวดล้อมทางอาคาร 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(68, NULL, 'สถ482', NULL, 'ออกแบบสถาปัตยกรรม 7', NULL, 'studio', 5, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(69, NULL, 'สถ392', NULL, 'การสื่อสารในการปฏิบัติวิชาชีพ 2', NULL, '', 1, 0, 2, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(70, NULL, 'สถ273', NULL, 'เทคโนโลยีอาคาร 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(71, NULL, 'สถ181', NULL, 'ออกแบบสถาปัตยกรรมเบื้องต้น', NULL, 'studio', 5, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(72, NULL, 'สถ491', NULL, 'การสื่อสารในการปฏิบัติวิชาชีพ 3', NULL, '', 1, 0, 2, 1, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(73, NULL, 'สถ423', NULL, 'การออกแบบสถาปัตยกรรมภายในเบื้องต้น', NULL, '', 3, 3, 0, 6, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41'),
(74, NULL, 'สถ582', NULL, 'วิทยานิพนธ์ทางสถาปัตยกรรม', NULL, 'zero', 9, 0, 27, 0, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:42'),
(75, NULL, 'สถ282', NULL, 'ออกแบบภูมิสังคมสถาปัตยกรรม 2', NULL, 'studio', 5, 2, 6, 7, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:10:41'),
(76, NULL, 'สถ171', NULL, 'พื้นฐานการเขียนแบบสถาปัตยกรรม', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(77, NULL, 'ภส252', NULL, 'วัสดุพืชพรรณและการเลือกใช้ 2 กลุ่ม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(78, NULL, 'ภท222', NULL, 'คอมพิวเตอร์สำหรับงานนำเสนอ กลุ่ม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:40'),
(79, NULL, 'สถ373', NULL, 'คอมพิวเตอร์ขั้นสูงสำหรับงานสถาปัตยกรรม กลุ่ม 2', NULL, '', 3, 2, 3, 5, 15, 15, 0, 'enable', 'Worachet', '2022-03-31 13:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `course_active_primary`
--

CREATE TABLE `course_active_primary` (
  `cap_id` int(11) NOT NULL,
  `cap_notes` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `cap_semester` int(1) NOT NULL,
  `cap_year` varchar(4) COLLATE utf8_thai_520_w2 NOT NULL,
  `cap_department` varchar(60) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `cap_citizenid` varchar(13) COLLATE utf8_thai_520_w2 NOT NULL,
  `cap_lecture_hours` int(1) DEFAULT 0,
  `cap_lab_hours` int(1) DEFAULT 0,
  `cap_self_hours` int(1) DEFAULT 0,
  `cap_status` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL DEFAULT 'enable',
  `cap_editor` varchar(20) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `cap_lastupdate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `course_active_primary`
--

INSERT INTO `course_active_primary` (`cap_id`, `cap_notes`, `cap_semester`, `cap_year`, `cap_department`, `course_id`, `cap_citizenid`, `cap_lecture_hours`, `cap_lab_hours`, `cap_self_hours`, `cap_status`, `cap_editor`, `cap_lastupdate`) VALUES
(1, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 1, '3501300659751', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(2, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 2, '3501300659751', 15, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(3, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 3, '3501300659751', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(4, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 4, '3501300659751', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(5, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 5, '3501300659751', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(6, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 6, '3509900264894', 30, 45, 0, 'enable', 'Worachet', '2022-03-31 15:25:01'),
(7, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 7, '3102002277510', 0, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(8, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 8, '3102002277510', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(9, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 9, '3102401232374', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(10, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 10, '3102401232374', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(11, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 11, '3102401232374', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(12, NULL, 2, '2564', 'การออกแบบและวางแผนสิ่งแวดล้อม', 12, '3500900487984', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(13, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 13, '3501400408130', 0, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(14, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 14, '3501400408130', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(15, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 15, '3501400408130', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(16, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 16, '3501300427515', 0, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(17, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 17, '3501300427515', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(18, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 18, '3200900597758', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(19, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 19, '3200900597758', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(20, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 20, '3200900597758', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(21, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 21, '3200900597758', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(22, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 22, '3450600771394', 15, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(23, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 23, '3450600771394', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(24, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 24, '3450600771394', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(25, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 25, '3570100071295', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(26, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 26, '3570100071295', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(27, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 27, '3580300037805', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(28, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 28, '3580300037805', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(29, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 29, '3310700896700', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(30, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 30, '3310700896700', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(31, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 31, '3310700896700', 0, 0, 0, 'enable', 'Umnarj', '2022-04-01 14:20:42'),
(32, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 32, '3501400435803', 15, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(33, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 33, '3501400435803', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(34, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 34, '3469900146698', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(35, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 35, '3469900146698', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(36, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 36, '3469900146698', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(37, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 77, '3469900146698', 30, 45, 0, 'enable', 'Umnarj', '2022-02-15 19:57:35'),
(38, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 38, '3401200159781', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(39, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 39, '3401200159781', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(40, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 40, '3401200159781', 0, 0, 0, 'enable', 'Umnarj', '2022-04-01 14:20:42'),
(41, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 41, '3100602600115', 15, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(42, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 42, '3100602600115', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(43, NULL, 2, '2564', 'เทคโนโลยีภูมิทัศน์', 43, '3100602600115', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(44, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 44, '3149900340012', 30, 135, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(45, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 45, '3149900340012', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(46, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 46, '3149900340012', 15, 60, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(47, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 47, '3102001706638', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(48, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 48, '3102001706638', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(49, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 49, '3470101438941', 30, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(50, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 50, '3470101438941', 30, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(51, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 51, '3350100395025', 0, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(52, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 52, '3100800946514', 15, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:00'),
(53, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 78, '3100800946514', 30, 45, 0, 'enable', 'Umnarj', '2022-03-28 15:05:49'),
(54, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 54, '3100800946514', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(55, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 55, '3100800946514', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(56, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 56, '1409800024861', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(57, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 57, '1409800024861', 15, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(58, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 58, '1409800024861', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(59, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 59, '1501490000317', 15, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(60, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 60, '1501490000317', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(61, NULL, 2, '2564', 'ภูมิสถาปัตยกรรมศาสตร์', 61, '1501490000317', 0, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(62, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 62, '4501900002319', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(63, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 63, '4501900002319', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(64, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 79, '3501900170116', 30, 45, 0, 'enable', 'Umnarj', '2022-03-28 14:47:54'),
(65, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 65, '3501900170116', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(66, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 66, '3501200164334', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(67, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 67, '3501200164334', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(68, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 68, '3609700307696', 0, 0, 0, 'enable', 'Umnarj', '2022-04-04 14:55:44'),
(69, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 69, '3609700307696', 0, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(70, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 70, '3609700307696', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(71, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 71, '3500100029701', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(72, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 72, '3500100029701', 0, 30, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(73, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 73, '1669800149816', 45, 0, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(74, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 74, '1669800149816', 0, 0, 0, 'enable', 'Umnarj', '2022-04-01 14:20:42'),
(75, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 75, '1560100092083', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(76, NULL, 2, '2564', 'สถาปัตยกรรมศาสตร์', 76, '1560100092083', 30, 45, 0, 'enable', 'Umnarj', '2022-03-31 15:25:01'),
(77, NULL, 2, '2564', 'การวางผังเมืองและสภาพแวดล้อม', 80, '3609700307696', 0, 0, 0, 'delete', 'Worachet', '2022-03-17 15:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `course_active_secondary`
--

CREATE TABLE `course_active_secondary` (
  `cas_id` int(11) NOT NULL,
  `cap_id` int(11) NOT NULL,
  `cas_citizenid` varchar(13) COLLATE utf8_thai_520_w2 NOT NULL,
  `cas_lecture_hours` int(1) NOT NULL,
  `cas_lab_hours` int(1) NOT NULL,
  `cas_self_hours` int(1) NOT NULL,
  `cas_status` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL DEFAULT 'enable',
  `cas_editor` varchar(20) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `cas_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `course_active_secondary`
--

INSERT INTO `course_active_secondary` (`cas_id`, `cap_id`, `cas_citizenid`, `cas_lecture_hours`, `cas_lab_hours`, `cas_self_hours`, `cas_status`, `cas_editor`, `cas_lastupdate`) VALUES
(1, 6, '3501300659751', 15, 22, 0, 'enable', 'Worachet', '2022-03-24 14:21:50'),
(2, 7, '3500700238956', 0, 0, 0, 'delete', 'Umnarj', '2022-03-17 10:53:27'),
(3, 68, '3500700238956', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:23:40'),
(4, 22, '3540700453369', 0, 0, 0, 'enable', 'Umnarj', '2022-03-24 16:21:56'),
(5, 23, '3540700453369', 0, 0, 0, 'enable', 'Umnarj', '2022-03-24 16:22:07'),
(6, 24, '3540700453369', 0, 0, 0, 'enable', 'Umnarj', '2022-03-24 16:22:15'),
(7, 27, '3500700238956', 10, 5, 0, 'delete', 'Worachet', '2022-03-31 10:19:37'),
(8, 72, '3102002277510', 0, 10, 0, 'enable', 'Umnarj', '2022-03-30 15:32:16'),
(9, 72, '1669800149816', 0, 10, 0, 'enable', 'Umnarj', '2022-03-30 15:32:21'),
(19, 60, '3149900340012', 30, 90, 0, 'enable', 'Umnarj', '2022-03-31 15:23:40'),
(20, 59, '1560100092083', 0, 0, 0, 'delete', 'Umnarj', '2022-03-31 15:12:49'),
(21, 26, '3580300037805', 0, 0, 0, 'delete', 'Umnarj', '2022-04-01 14:45:53'),
(22, 45, '3609700307696', 0, 0, 0, 'delete', 'Worachet', '2022-04-04 10:37:28'),
(23, 45, '3500700238956', 0, 0, 0, 'delete', 'Worachet', '2022-04-04 10:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `setting_semester` varchar(1) COLLATE utf8_thai_520_w2 NOT NULL,
  `setting_edu_year` varchar(4) COLLATE utf8_thai_520_w2 NOT NULL,
  `setting_due_date` date NOT NULL,
  `setting_parameter` text COLLATE utf8_thai_520_w2 NOT NULL,
  `setting_value` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_semester`, `setting_edu_year`, `setting_due_date`, `setting_parameter`, `setting_value`) VALUES
(1, 'editable', '2', '2564', '2022-04-21', '', 'true'),
(2, 'editable', '1', '2564', '0000-00-00', '', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `citizenId` varchar(13) COLLATE utf8_thai_520_w2 NOT NULL,
  `titleName` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `titlePosition` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `firstName` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `lastName` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `titleNameEn` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `fistNameEn` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `lastNameEn` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `department` varchar(60) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `positionCode` varchar(6) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `gender` varchar(5) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `personnelType` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `positionTypeId` varchar(5) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `positionType` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `position` varchar(60) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `e_mail` varchar(60) COLLATE utf8_thai_520_w2 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`citizenId`, `titleName`, `titlePosition`, `firstName`, `lastName`, `titleNameEn`, `fistNameEn`, `lastNameEn`, `department`, `positionCode`, `gender`, `personnelType`, `positionTypeId`, `positionType`, `position`, `e_mail`) VALUES
('3609700307696', 'นาย', 'อาจารย์', 'กิตติพงศ์', 'รื่นวงศ์', 'Mr.', 'Kittipong', 'Ruenwong', 'สถาปัตยกรรมศาสตร์', '1132', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'kittipong_rw@mju.ac.th'),
('3100602600115', 'นาย', 'รองศาสตราจารย์ ดร.', 'เกรียงศักดิ์', 'ศรีเงินยวง', 'Mr.', 'Kriangsak', 'Sri-ngernyuang', 'เทคโนโลยีภูมิทัศน์', 'ข465', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'รองศาสตราจารย์', 'kriangsa@mju.ac.th'),
('3102001706638', 'น.ส.', 'ผู้ช่วยศาสตราจารย์', 'จรัสพิมพ์', 'บุญญานันต์', 'Miss', 'Charaspim', 'Boonyanant', 'ภูมิสถาปัตยกรรมศาสตร์', 'ข477', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'charaspi@mju.ac.th'),
('3509900264894', 'นาย', 'อาจารย์ ดร.', 'โชคอนันต์', 'วาณิชย์เลิศธนาสาร', 'Mr.', 'Chokanan', 'Wanitlertthanasarn', 'สถาปัตยกรรมศาสตร์', '588', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'chokanan@mju.ac.th'),
('3102401232374', 'น.ส.', 'รองศาสตราจารย์ ดร.', 'ณัชวิชญ์', 'ติกุล', 'Miss', 'Nachawit', 'Tikul', 'การออกแบบและวางแผนสิ่งแวดล้อม', 'ข515', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'รองศาสตราจารย์', 'nachawit@mju.ac.th'),
('1409800024861', 'นาย', 'อาจารย์', 'ณัฐพล', 'เรืองวิทยานุสรณ์', 'Mr.', 'Natthaphon', 'Ruangwitthayanusorn', 'ภูมิสถาปัตยกรรมศาสตร์', '1052', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'nuttapol_rv@mju.ac.th'),
('1560100092083', 'นาย', 'อาจารย์', 'ดิศสกุล', 'อึ้งตระกูล', 'Mr.', 'Ditsakul', 'Uengtrakool', 'สถาปัตยกรรมศาสตร์', '1133', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'ditsakul_u@mju.ac.th'),
('3710600831424', 'นาย', 'อาจารย์', 'ตุลชัย', 'บ่อทรัพย์', 'Mr.', 'Tullachai', 'Bosup', 'สถาปัตยกรรมศาสตร์', '946', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'tullachai@mju.ac.th'),
('3470101438941', 'นาย', 'อาจารย์ ดร.', 'ทำเนียบ', 'อุฬารกุล', 'Mr.', 'Thamniap', 'Urankul', 'ภูมิสถาปัตยกรรมศาสตร์', '082', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'thamniap@mju.ac.th'),
('3102002277510', 'นาย', 'ผู้ช่วยศาสตราจารย์ ดร.', 'แทนวุธธา', 'ไทยสันทัด', 'Mr.', 'Tanwutta', 'Thaisuntad', 'การออกแบบและวางแผนสิ่งแวดล้อม', '419', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'tanwutta@mju.ac.th'),
('1640600016920', 'นาย', 'อาจารย์', 'ธีรภัทร', 'จิโน', 'Mr.', 'Teerapat', 'Jino', 'ภูมิสถาปัตยกรรมศาสตร์', '1135', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'teerapat_gn@mju.ac.th'),
('3501400408130', 'นาย', 'ผู้ช่วยศาสตราจารย์ ดร.', 'นิกร', 'มหาวัน', 'Mr.', 'Nikorn', 'Mahawan', 'การวางผังเมืองและสภาพแวดล้อม', '846', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'nikorn.m@mju.ac.th'),
('3501400435803', 'นาย', 'ผู้ช่วยศาสตราจารย์', 'บรรจง', 'สมบูรณ์ชัย', 'Mr.', 'Bunchong', 'Somboomchai', 'เทคโนโลยีภูมิทัศน์', 'ข268', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'bunchong@mju.ac.th'),
('3501900170116', 'นาย', 'อาจารย์', 'ปนวัฒน์', 'สุทธิกุญชร', 'Mr.', 'Panawat', 'Sutthikunchon', 'สถาปัตยกรรมศาสตร์', '1056', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'panawat_sk@mju.ac.th'),
('3580300037805', 'นาย', 'อาจารย์ ดร.', 'ปริญญา', 'ปฏิพันธกานต์', 'Mr.', 'Parinya', 'Patiphanthakan', 'เทคโนโลยีภูมิทัศน์', '938', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'Parinya@mju.ac.th'),
('3401200159781', 'น.ส.', 'อาจารย์', 'พรทิพย์', 'จันทร์ราช', 'Miss', 'Porntip', 'Chanrat', 'เทคโนโลยีภูมิทัศน์', '1134', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'porntip_j@mju.ac.th'),
('4501900002319', 'นาย', 'ผู้ช่วยศาสตราจารย์', 'พันธ์ศักดิ์', 'ภักดี', 'Mr.', 'Phansak', 'Phakdi', 'สถาปัตยกรรมศาสตร์', '634', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'punsak@mju.ac.th'),
('3501300659751', 'นาย', 'ผู้ช่วยศาสตราจารย์ ดร.', 'พันธุ์ระวี', 'กองบุญเทียม', 'Mr.', 'Punravee', 'Kongboontiam', 'การออกแบบและวางแผนสิ่งแวดล้อม', '089', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'punravee@mju.ac.th'),
('1669800149816', 'น.ส.', 'อาจารย์', 'พิชญาภา', 'ธัมมิกะกุล', 'Miss', 'Phichayapa', 'Tammikakul', 'สถาปัตยกรรมศาสตร์', '1148', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'phichayapa_tawan@mju.ac.th'),
('3540700453369', 'นาย', 'อาจารย์', 'พิทักษ์พงศ์', 'แบ่งทิศ', 'Mr.', 'Phithakphong', 'Baengthid', 'เทคโนโลยีภูมิทัศน์', '1029', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'phithakphong@mju.ac.th'),
('3520600004007', 'นาย', 'ผู้ช่วยศาสตราจารย์', 'ภูวเดช', 'วงศ์โสม', 'Mr.', 'Phoowadech', 'Wongsom', 'สถาปัตยกรรมศาสตร์', '937', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'phoowadech@mju.ac.th'),
('3149900340012', 'นาย', 'ผู้ช่วยศาสตราจารย์', 'ยุทธภูมิ', 'เผ่าจินดา', 'Mr.', 'Yuttapoom', 'Powjinda', 'ภูมิสถาปัตยกรรมศาสตร์', '590', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'yuttapoom@mju.ac.th'),
('3469900146698', 'นาง', 'ผู้ช่วยศาสตราจารย์ ดร.', 'เยาวนิตย์', 'ธาราฉาย', 'Mrs.', 'Yaowanit', 'Tarachai', 'เทคโนโลยีภูมิทัศน์', 'ข066', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'yaowanit@mju.ac.th'),
('3500100029701', 'น.ส.', 'อาจารย์', 'รงรอง', 'วงษ์วาล', 'Miss', 'Rongrong', 'Wongwal', 'สถาปัตยกรรมศาสตร์', '945', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'rongroung@mju.ac.th'),
('3450600771394', 'น.ส.', 'รองศาสตราจารย์', 'รมย์ชลีรดา', 'ด่านวันดี', 'Miss', 'Romchaleerda', 'Danwandee', 'เทคโนโลยีภูมิทัศน์', 'ข478', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'รองศาสตราจารย์', 'daranee@mju.ac.th'),
('3200900597758', 'นาง', 'ผู้ช่วยศาสตราจารย์ ดร.', 'ลักษณา', 'สัมมานิธิ', 'Mrs.', 'Luxana', 'Summaniti', 'การวางผังเมืองและสภาพแวดล้อม', 'ข269', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'luxsana@mju.ac.th'),
('3100800946514', 'นาย', 'อาจารย์', 'วรินทร์', 'กุลินทรประเสริฐ', 'Mr.', 'Warin', 'Kulintonprasert', 'เทคโนโลยีภูมิทัศน์', '1049', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'warin_kl@mju.ac.th'),
('3501300427515', 'นาย', 'ผู้ช่วยศาสตราจารย์ ดร.', 'วิทยา', 'ดวงธิมา', 'Mr.', 'Wittaya', 'Daungthima', 'การวางผังเมืองและสภาพแวดล้อม', '107', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'w_daungthima@mju.ac.th'),
('3501200164334', 'นาย', 'ผู้ช่วยศาสตราจารย์ ดร.', 'วุฒิกานต์', 'ปุระพรหม', 'Mr.', 'Wuttigarn', 'Puraprom', 'สถาปัตยกรรมศาสตร์', '658', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'puraprom_w@mju.ac.th'),
('1501490000317', 'นาย', 'อาจารย์', 'ศุภณัฐ', 'กาญจนวงศ์', 'Mr.', 'Supanut', 'Kanchanawong', 'ภูมิสถาปัตยกรรมศาสตร์', '499', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'supanut@mju.ac.th'),
('3350100395025', 'น.ส.', 'อาจารย์', 'ศุภัชญา', 'ปรัชญคุปต์', 'Miss', 'Supaschaya', 'Prachchayakup', 'ภูมิสถาปัตยกรรมศาสตร์', '552', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'supaschaya@mju.ac.th'),
('1509900428785', 'น.ส.', 'อาจารย์', 'สุปิยา', 'ปัญญาทอง', 'Miss', 'Supiya', 'Punyathong', 'เทคโนโลยีภูมิทัศน์', '1028', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'supiya@mju.ac.th'),
('3570100071295', 'นาย', 'อาจารย์', 'สุระพงษ์', 'เตชะ', 'Mr.', 'Surapong', 'Techa', 'เทคโนโลยีภูมิทัศน์', 'ข480', 'ชาย', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'อาจารย์', 'surapong@mju.ac.th'),
('3500900487984', 'นาง', 'รองศาสตราจารย์ ดร.', 'อรทัย', 'มิ่งธิพล', 'Mrs.', 'Orathai', 'Mingtipon', 'การออกแบบและวางแผนสิ่งแวดล้อม', 'ข476', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'รองศาสตราจารย์', 'orathai@mju.ac.th'),
('3310700896700', 'นาง', 'ผู้ช่วยศาสตราจารย์', 'อัจฉรี', 'เหมสันต์', 'Mrs.', 'Augcharee', 'Hemsant', 'เทคโนโลยีภูมิทัศน์', 'ข230', 'หญิง', 'พนักงานมหาวิทยาลัย', 'ก', 'ประเภทวิชาการ', 'ผู้ช่วยศาสตราจารย์', 'augcharee@mju.ac.th'),
('3101401814879', 'นาย', 'นาย', 'ศิริชัย', 'หงษ์วิทยากร', 'Mr.', 'Sirichai', 'Hongvityakorn', '', '190', 'ชาย', 'พนักงานส่วนงาน', 'ค', 'ประเภทสนับสนุน', 'ผู้เชี่ยวชาญ', 'supong_fr@mju.ac.th');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_additional`
--

CREATE TABLE `teacher_additional` (
  `ta_id` int(11) NOT NULL,
  `ta_citizenid` varchar(13) COLLATE utf8_thai_520_w2 NOT NULL,
  `ta_prefix` varchar(20) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `ta_firstname` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `ta_lastname` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `ta_status` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL DEFAULT 'enable',
  `ta_editor` varchar(20) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `ta_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_ext`
--

CREATE TABLE `teacher_ext` (
  `teacher_ext_citizenid` varchar(13) COLLATE utf8_thai_520_w2 NOT NULL,
  `teacher_ext_titleName` varchar(16) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `teacher_ext_titlePosition` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `teacher_ext_firstName` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `teacher_ext_lastName` varchar(30) COLLATE utf8_thai_520_w2 NOT NULL,
  `teacher_ext_status` varchar(10) COLLATE utf8_thai_520_w2 NOT NULL DEFAULT 'enable',
  `teacher_ext_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `teacher_ext`
--

INSERT INTO `teacher_ext` (`teacher_ext_citizenid`, `teacher_ext_titleName`, `teacher_ext_titlePosition`, `teacher_ext_firstName`, `teacher_ext_lastName`, `teacher_ext_status`, `teacher_ext_lastupdate`) VALUES
('3500700238956', NULL, 'นาย', 'อำนาจ', 'ชิดทอง', 'enable', '2022-03-15 15:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `teaching_load`
--

CREATE TABLE `teaching_load` (
  `teaching_load_id` int(11) NOT NULL,
  `teaching_load_citizenid` varchar(13) COLLATE utf8_thai_520_w2 NOT NULL,
  `teaching_load_lineid` varchar(33) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `teaching_load_titlePosition` varchar(30) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `teaching_load_firstName` varchar(50) COLLATE utf8_thai_520_w2 NOT NULL,
  `teaching_load_lastName` varchar(50) COLLATE utf8_thai_520_w2 NOT NULL,
  `teaching_load_department` varchar(50) COLLATE utf8_thai_520_w2 DEFAULT NULL,
  `teaching_load_lec_hours` int(3) NOT NULL DEFAULT 0,
  `teaching_load_lab_hours` int(3) NOT NULL DEFAULT 0,
  `teaching_load_semester` int(1) NOT NULL,
  `teaching_load_edu_year` varchar(4) COLLATE utf8_thai_520_w2 NOT NULL,
  `teaching_load_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_thai_520_w2;

--
-- Dumping data for table `teaching_load`
--

INSERT INTO `teaching_load` (`teaching_load_id`, `teaching_load_citizenid`, `teaching_load_lineid`, `teaching_load_titlePosition`, `teaching_load_firstName`, `teaching_load_lastName`, `teaching_load_department`, `teaching_load_lec_hours`, `teaching_load_lab_hours`, `teaching_load_semester`, `teaching_load_edu_year`, `teaching_load_lastupdate`) VALUES
(1, '3609700307696', NULL, 'อาจารย์', 'กิตติพงศ์', 'รื่นวงศ์', 'สถาปัตยกรรมศาสตร์', 30, 75, 2, '2564', '2022-04-04 15:01:14'),
(2, '3100602600115', NULL, 'รองศาสตราจารย์ ดร.', 'เกรียงศักดิ์', 'ศรีเงินยวง', 'เทคโนโลยีภูมิทัศน์', 90, 90, 2, '2564', '2022-04-04 15:01:13'),
(3, '3102001706638', NULL, 'ผู้ช่วยศาสตราจารย์', 'จรัสพิมพ์', 'บุญญานันต์', 'ภูมิสถาปัตยกรรมศาสตร์', 60, 120, 2, '2564', '2022-04-04 15:01:13'),
(4, '3509900264894', NULL, 'อาจารย์ ดร.', 'โชคอนันต์', 'วาณิชย์เลิศธนาสาร', 'สถาปัตยกรรมศาสตร์', 30, 45, 2, '2564', '2022-04-04 15:01:14'),
(5, '3102401232374', NULL, 'รองศาสตราจารย์ ดร.', 'ณัชวิชญ์', 'ติกุล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 105, 90, 2, '2564', '2022-04-04 15:01:13'),
(6, '1409800024861', NULL, 'อาจารย์', 'ณัฐพล', 'เรืองวิทยานุสรณ์', 'ภูมิสถาปัตยกรรมศาสตร์', 75, 225, 2, '2564', '2022-04-04 15:01:13'),
(7, '1560100092083', NULL, 'อาจารย์', 'ดิศสกุล', 'อึ้งตระกูล', 'สถาปัตยกรรมศาสตร์', 60, 135, 2, '2564', '2022-04-04 15:01:13'),
(8, '3710600831424', NULL, 'อาจารย์', 'ตุลชัย', 'บ่อทรัพย์', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2564', '2022-02-28 15:55:14'),
(9, '3470101438941', NULL, 'อาจารย์ ดร.', 'ทำเนียบ', 'อุฬารกุล', 'ภูมิสถาปัตยกรรมศาสตร์', 60, 30, 2, '2564', '2022-04-04 15:01:14'),
(10, '3102002277510', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'แทนวุธธา', 'ไทยสันทัด', 'การออกแบบและวางแผนสิ่งแวดล้อม', 30, 85, 2, '2564', '2022-04-04 15:01:13'),
(11, '1640600016920', NULL, 'อาจารย์', 'ธีรภัทร', 'จิโน', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2564', '2022-02-28 15:55:14'),
(12, '3501400408130', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'นิกร', 'มหาวัน', 'การวางผังเมืองและสภาพแวดล้อม', 60, 90, 2, '2564', '2022-04-04 15:01:14'),
(13, '3501400435803', NULL, 'ผู้ช่วยศาสตราจารย์', 'บรรจง', 'สมบูรณ์ชัย', 'เทคโนโลยีภูมิทัศน์', 45, 90, 2, '2564', '2022-04-04 15:01:14'),
(14, '3501900170116', NULL, 'อาจารย์', 'ปนวัฒน์', 'สุทธิกุญชร', 'สถาปัตยกรรมศาสตร์', 75, 45, 2, '2564', '2022-04-04 15:01:14'),
(15, '3580300037805', NULL, 'อาจารย์ ดร.', 'ปริญญา', 'ปฏิพันธกานต์', 'เทคโนโลยีภูมิทัศน์', 60, 75, 2, '2564', '2022-04-04 15:01:14'),
(16, '3401200159781', NULL, 'อาจารย์', 'พรทิพย์', 'จันทร์ราช', 'เทคโนโลยีภูมิทัศน์', 75, 45, 2, '2564', '2022-04-04 15:01:14'),
(17, '4501900002319', NULL, 'ผู้ช่วยศาสตราจารย์', 'พันธ์ศักดิ์', 'ภักดี', 'สถาปัตยกรรมศาสตร์', 60, 135, 2, '2564', '2022-04-04 15:01:14'),
(18, '3501300659751', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'พันธุ์ระวี', 'กองบุญเทียม', 'การออกแบบและวางแผนสิ่งแวดล้อม', 165, 202, 2, '2564', '2022-04-04 15:01:14'),
(19, '1669800149816', NULL, 'อาจารย์', 'พิชญาภา', 'ธัมมิกะกุล', 'สถาปัตยกรรมศาสตร์', 45, 10, 2, '2564', '2022-04-04 15:01:13'),
(20, '3540700453369', NULL, 'อาจารย์', 'พิทักษ์พงศ์', 'แบ่งทิศ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2564', '2022-02-28 15:55:14'),
(21, '3520600004007', NULL, 'ผู้ช่วยศาสตราจารย์', 'ภูวเดช', 'วงศ์โสม', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2564', '2022-02-28 15:55:14'),
(22, '3149900340012', NULL, 'ผู้ช่วยศาสตราจารย์', 'ยุทธภูมิ', 'เผ่าจินดา', 'ภูมิสถาปัตยกรรมศาสตร์', 105, 330, 2, '2564', '2022-04-04 15:01:13'),
(23, '3469900146698', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'เยาวนิตย์', 'ธาราฉาย', 'เทคโนโลยีภูมิทัศน์', 120, 180, 2, '2564', '2022-04-04 15:01:14'),
(24, '3500100029701', NULL, 'อาจารย์', 'รงรอง', 'วงษ์วาล', 'สถาปัตยกรรมศาสตร์', 30, 120, 2, '2564', '2022-04-04 15:01:14'),
(25, '3450600771394', NULL, 'รองศาสตราจารย์', 'รมย์ชลีรดา', 'ด่านวันดี', 'เทคโนโลยีภูมิทัศน์', 75, 180, 2, '2564', '2022-04-04 15:01:14'),
(26, '3200900597758', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'ลักษณา', 'สัมมานิธิ', 'การวางผังเมืองและสภาพแวดล้อม', 135, 120, 2, '2564', '2022-04-04 15:01:13'),
(27, '3100800946514', NULL, 'อาจารย์', 'วรินทร์', 'กุลินทรประเสริฐ', 'เทคโนโลยีภูมิทัศน์', 105, 180, 2, '2564', '2022-04-04 15:01:13'),
(28, '3501300427515', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วิทยา', 'ดวงธิมา', 'การวางผังเมืองและสภาพแวดล้อม', 30, 60, 2, '2564', '2022-04-04 15:01:14'),
(29, '3501200164334', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วุฒิกานต์', 'ปุระพรหม', 'สถาปัตยกรรมศาสตร์', 60, 90, 2, '2564', '2022-04-04 15:01:14'),
(30, '1501490000317', NULL, 'อาจารย์', 'ศุภณัฐ', 'กาญจนวงศ์', 'ภูมิสถาปัตยกรรมศาสตร์', 45, 180, 2, '2564', '2022-04-04 15:01:13'),
(31, '3350100395025', NULL, 'อาจารย์', 'ศุภัชญา', 'ปรัชญคุปต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 45, 2, '2564', '2022-04-04 15:01:13'),
(32, '1509900428785', NULL, 'อาจารย์', 'สุปิยา', 'ปัญญาทอง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2564', '2022-02-28 15:55:15'),
(33, '3570100071295', NULL, 'อาจารย์', 'สุระพงษ์', 'เตชะ', 'เทคโนโลยีภูมิทัศน์', 60, 60, 2, '2564', '2022-04-04 15:01:14'),
(34, '3500900487984', NULL, 'รองศาสตราจารย์ ดร.', 'อรทัย', 'มิ่งธิพล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 30, 45, 2, '2564', '2022-04-04 15:01:14'),
(35, '3310700896700', NULL, 'ผู้ช่วยศาสตราจารย์', 'อัจฉรี', 'เหมสันต์', 'เทคโนโลยีภูมิทัศน์', 60, 90, 2, '2564', '2022-04-04 15:01:13'),
(36, '3101401814879', NULL, 'นาย', 'ศิริชัย', 'หงษ์วิทยากร', NULL, 0, 0, 2, '2564', '2022-02-28 15:55:15'),
(37, '3609700307696', NULL, 'อาจารย์', 'กิตติพงศ์', 'รื่นวงศ์', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(38, '3100602600115', NULL, 'รองศาสตราจารย์ ดร.', 'เกรียงศักดิ์', 'ศรีเงินยวง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(39, '3102001706638', NULL, 'ผู้ช่วยศาสตราจารย์', 'จรัสพิมพ์', 'บุญญานันต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(40, '3509900264894', NULL, 'อาจารย์ ดร.', 'โชคอนันต์', 'วาณิชย์เลิศธนาสาร', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(41, '3102401232374', NULL, 'รองศาสตราจารย์ ดร.', 'ณัชวิชญ์', 'ติกุล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(42, '1409800024861', NULL, 'อาจารย์', 'ณัฐพล', 'เรืองวิทยานุสรณ์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(43, '1560100092083', NULL, 'อาจารย์', 'ดิศสกุล', 'อึ้งตระกูล', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(44, '3710600831424', NULL, 'อาจารย์', 'ตุลชัย', 'บ่อทรัพย์', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(45, '3470101438941', NULL, 'อาจารย์ ดร.', 'ทำเนียบ', 'อุฬารกุล', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(46, '3102002277510', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'แทนวุธธา', 'ไทยสันทัด', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:27'),
(47, '1640600016920', NULL, 'อาจารย์', 'ธีรภัทร', 'จิโน', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(48, '3501400408130', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'นิกร', 'มหาวัน', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(49, '3501400435803', NULL, 'ผู้ช่วยศาสตราจารย์', 'บรรจง', 'สมบูรณ์ชัย', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(50, '3501900170116', NULL, 'อาจารย์', 'ปนวัฒน์', 'สุทธิกุญชร', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(51, '3580300037805', NULL, 'อาจารย์ ดร.', 'ปริญญา', 'ปฏิพันธกานต์', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(52, '3401200159781', NULL, 'อาจารย์', 'พรทิพย์', 'จันทร์ราช', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(53, '4501900002319', NULL, 'ผู้ช่วยศาสตราจารย์', 'พันธ์ศักดิ์', 'ภักดี', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(54, '3501300659751', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'พันธุ์ระวี', 'กองบุญเทียม', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(55, '1669800149816', NULL, 'อาจารย์', 'พิชญาภา', 'ธัมมิกะกุล', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(56, '3540700453369', NULL, 'อาจารย์', 'พิทักษ์พงศ์', 'แบ่งทิศ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(57, '3520600004007', NULL, 'ผู้ช่วยศาสตราจารย์', 'ภูวเดช', 'วงศ์โสม', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(58, '3149900340012', NULL, 'ผู้ช่วยศาสตราจารย์', 'ยุทธภูมิ', 'เผ่าจินดา', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(59, '3469900146698', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'เยาวนิตย์', 'ธาราฉาย', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(60, '3500100029701', NULL, 'อาจารย์', 'รงรอง', 'วงษ์วาล', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(61, '3450600771394', NULL, 'รองศาสตราจารย์', 'รมย์ชลีรดา', 'ด่านวันดี', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(62, '3200900597758', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'ลักษณา', 'สัมมานิธิ', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(63, '3100800946514', NULL, 'อาจารย์', 'วรินทร์', 'กุลินทรประเสริฐ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(64, '3501300427515', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วิทยา', 'ดวงธิมา', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(65, '3501200164334', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วุฒิกานต์', 'ปุระพรหม', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(66, '1501490000317', NULL, 'อาจารย์', 'ศุภณัฐ', 'กาญจนวงศ์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:28'),
(67, '3350100395025', NULL, 'อาจารย์', 'ศุภัชญา', 'ปรัชญคุปต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2564', '2022-02-28 15:55:29'),
(68, '1509900428785', NULL, 'อาจารย์', 'สุปิยา', 'ปัญญาทอง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:29'),
(69, '3570100071295', NULL, 'อาจารย์', 'สุระพงษ์', 'เตชะ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:29'),
(70, '3500900487984', NULL, 'รองศาสตราจารย์ ดร.', 'อรทัย', 'มิ่งธิพล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2564', '2022-02-28 15:55:29'),
(71, '3310700896700', NULL, 'ผู้ช่วยศาสตราจารย์', 'อัจฉรี', 'เหมสันต์', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2564', '2022-02-28 15:55:29'),
(72, '3101401814879', NULL, 'นาย', 'ศิริชัย', 'หงษ์วิทยากร', NULL, 0, 0, 1, '2564', '2022-02-28 15:55:29'),
(73, '3609700307696', NULL, 'อาจารย์', 'กิตติพงศ์', 'รื่นวงศ์', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:39'),
(74, '3100602600115', NULL, 'รองศาสตราจารย์ ดร.', 'เกรียงศักดิ์', 'ศรีเงินยวง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:39'),
(75, '3102001706638', NULL, 'ผู้ช่วยศาสตราจารย์', 'จรัสพิมพ์', 'บุญญานันต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:39'),
(76, '3509900264894', NULL, 'อาจารย์ ดร.', 'โชคอนันต์', 'วาณิชย์เลิศธนาสาร', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:39'),
(77, '3102401232374', NULL, 'รองศาสตราจารย์ ดร.', 'ณัชวิชญ์', 'ติกุล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:39'),
(78, '1409800024861', NULL, 'อาจารย์', 'ณัฐพล', 'เรืองวิทยานุสรณ์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:39'),
(79, '1560100092083', NULL, 'อาจารย์', 'ดิศสกุล', 'อึ้งตระกูล', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(80, '3710600831424', NULL, 'อาจารย์', 'ตุลชัย', 'บ่อทรัพย์', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(81, '3470101438941', NULL, 'อาจารย์ ดร.', 'ทำเนียบ', 'อุฬารกุล', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(82, '3102002277510', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'แทนวุธธา', 'ไทยสันทัด', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(83, '1640600016920', NULL, 'อาจารย์', 'ธีรภัทร', 'จิโน', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(84, '3501400408130', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'นิกร', 'มหาวัน', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(85, '3501400435803', NULL, 'ผู้ช่วยศาสตราจารย์', 'บรรจง', 'สมบูรณ์ชัย', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(86, '3501900170116', NULL, 'อาจารย์', 'ปนวัฒน์', 'สุทธิกุญชร', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(87, '3580300037805', NULL, 'อาจารย์ ดร.', 'ปริญญา', 'ปฏิพันธกานต์', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(88, '3401200159781', NULL, 'อาจารย์', 'พรทิพย์', 'จันทร์ราช', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(89, '4501900002319', NULL, 'ผู้ช่วยศาสตราจารย์', 'พันธ์ศักดิ์', 'ภักดี', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(90, '3501300659751', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'พันธุ์ระวี', 'กองบุญเทียม', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(91, '1669800149816', NULL, 'อาจารย์', 'พิชญาภา', 'ธัมมิกะกุล', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(92, '3540700453369', NULL, 'อาจารย์', 'พิทักษ์พงศ์', 'แบ่งทิศ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(93, '3520600004007', NULL, 'ผู้ช่วยศาสตราจารย์', 'ภูวเดช', 'วงศ์โสม', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(94, '3149900340012', NULL, 'ผู้ช่วยศาสตราจารย์', 'ยุทธภูมิ', 'เผ่าจินดา', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(95, '3469900146698', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'เยาวนิตย์', 'ธาราฉาย', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(96, '3500100029701', NULL, 'อาจารย์', 'รงรอง', 'วงษ์วาล', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(97, '3450600771394', NULL, 'รองศาสตราจารย์', 'รมย์ชลีรดา', 'ด่านวันดี', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:40'),
(98, '3200900597758', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'ลักษณา', 'สัมมานิธิ', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(99, '3100800946514', NULL, 'อาจารย์', 'วรินทร์', 'กุลินทรประเสริฐ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(100, '3501300427515', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วิทยา', 'ดวงธิมา', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(101, '3501200164334', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วุฒิกานต์', 'ปุระพรหม', 'สถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(102, '1501490000317', NULL, 'อาจารย์', 'ศุภณัฐ', 'กาญจนวงศ์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(103, '3350100395025', NULL, 'อาจารย์', 'ศุภัชญา', 'ปรัชญคุปต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(104, '1509900428785', NULL, 'อาจารย์', 'สุปิยา', 'ปัญญาทอง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(105, '3570100071295', NULL, 'อาจารย์', 'สุระพงษ์', 'เตชะ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(106, '3500900487984', NULL, 'รองศาสตราจารย์ ดร.', 'อรทัย', 'มิ่งธิพล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(107, '3310700896700', NULL, 'ผู้ช่วยศาสตราจารย์', 'อัจฉรี', 'เหมสันต์', 'เทคโนโลยีภูมิทัศน์', 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(108, '3101401814879', NULL, 'นาย', 'ศิริชัย', 'หงษ์วิทยากร', NULL, 0, 0, 1, '2565', '2022-02-28 15:56:41'),
(109, '3609700307696', NULL, 'อาจารย์', 'กิตติพงศ์', 'รื่นวงศ์', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:35'),
(110, '3100602600115', NULL, 'รองศาสตราจารย์ ดร.', 'เกรียงศักดิ์', 'ศรีเงินยวง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(111, '3102001706638', NULL, 'ผู้ช่วยศาสตราจารย์', 'จรัสพิมพ์', 'บุญญานันต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(112, '3509900264894', NULL, 'อาจารย์ ดร.', 'โชคอนันต์', 'วาณิชย์เลิศธนาสาร', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(113, '3102401232374', NULL, 'รองศาสตราจารย์ ดร.', 'ณัชวิชญ์', 'ติกุล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(114, '1409800024861', NULL, 'อาจารย์', 'ณัฐพล', 'เรืองวิทยานุสรณ์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(115, '1560100092083', NULL, 'อาจารย์', 'ดิศสกุล', 'อึ้งตระกูล', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(116, '3710600831424', NULL, 'อาจารย์', 'ตุลชัย', 'บ่อทรัพย์', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(117, '3470101438941', NULL, 'อาจารย์ ดร.', 'ทำเนียบ', 'อุฬารกุล', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(118, '3102002277510', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'แทนวุธธา', 'ไทยสันทัด', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(119, '1640600016920', NULL, 'อาจารย์', 'ธีรภัทร', 'จิโน', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(120, '3501400408130', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'นิกร', 'มหาวัน', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(121, '3501400435803', NULL, 'ผู้ช่วยศาสตราจารย์', 'บรรจง', 'สมบูรณ์ชัย', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(122, '3501900170116', NULL, 'อาจารย์', 'ปนวัฒน์', 'สุทธิกุญชร', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(123, '3580300037805', NULL, 'อาจารย์ ดร.', 'ปริญญา', 'ปฏิพันธกานต์', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(124, '3401200159781', NULL, 'อาจารย์', 'พรทิพย์', 'จันทร์ราช', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(125, '4501900002319', NULL, 'ผู้ช่วยศาสตราจารย์', 'พันธ์ศักดิ์', 'ภักดี', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(126, '3501300659751', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'พันธุ์ระวี', 'กองบุญเทียม', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(127, '1669800149816', NULL, 'อาจารย์', 'พิชญาภา', 'ธัมมิกะกุล', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(128, '3540700453369', NULL, 'อาจารย์', 'พิทักษ์พงศ์', 'แบ่งทิศ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(129, '3520600004007', NULL, 'ผู้ช่วยศาสตราจารย์', 'ภูวเดช', 'วงศ์โสม', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:36'),
(130, '3149900340012', NULL, 'ผู้ช่วยศาสตราจารย์', 'ยุทธภูมิ', 'เผ่าจินดา', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(131, '3469900146698', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'เยาวนิตย์', 'ธาราฉาย', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(132, '3500100029701', NULL, 'อาจารย์', 'รงรอง', 'วงษ์วาล', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(133, '3450600771394', NULL, 'รองศาสตราจารย์', 'รมย์ชลีรดา', 'ด่านวันดี', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(134, '3200900597758', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'ลักษณา', 'สัมมานิธิ', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(135, '3100800946514', NULL, 'อาจารย์', 'วรินทร์', 'กุลินทรประเสริฐ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(136, '3501300427515', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วิทยา', 'ดวงธิมา', 'การวางผังเมืองและสภาพแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(137, '3501200164334', NULL, 'ผู้ช่วยศาสตราจารย์ ดร.', 'วุฒิกานต์', 'ปุระพรหม', 'สถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(138, '1501490000317', NULL, 'อาจารย์', 'ศุภณัฐ', 'กาญจนวงศ์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(139, '3350100395025', NULL, 'อาจารย์', 'ศุภัชญา', 'ปรัชญคุปต์', 'ภูมิสถาปัตยกรรมศาสตร์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(140, '1509900428785', NULL, 'อาจารย์', 'สุปิยา', 'ปัญญาทอง', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(141, '3570100071295', NULL, 'อาจารย์', 'สุระพงษ์', 'เตชะ', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(142, '3500900487984', NULL, 'รองศาสตราจารย์ ดร.', 'อรทัย', 'มิ่งธิพล', 'การออกแบบและวางแผนสิ่งแวดล้อม', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(143, '3310700896700', NULL, 'ผู้ช่วยศาสตราจารย์', 'อัจฉรี', 'เหมสันต์', 'เทคโนโลยีภูมิทัศน์', 0, 0, 2, '2565', '2022-03-02 10:41:37'),
(144, '3101401814879', NULL, 'นาย', 'ศิริชัย', 'หงษ์วิทยากร', NULL, 0, 0, 2, '2565', '2022-03-02 10:41:37');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_cap`
-- (See below for the actual view)
--
CREATE TABLE `v_cap` (
`cap_id` int(11)
,`cap_notes` varchar(30)
,`cap_semester` int(1)
,`cap_year` varchar(4)
,`course_id` int(11)
,`course_code_th` varchar(5)
,`course_code_en` varchar(5)
,`course_name_th` varchar(80)
,`course_name_en` varchar(80)
,`course_credit` int(1)
,`course_lec` int(1)
,`course_lab` int(1)
,`course_self` int(1)
,`course_lec_hrs` int(2)
,`course_lab_hrs` int(2)
,`course_self_hrs` int(2)
,`cap_citizenid` varchar(13)
,`teaching_load_titlePosition` varchar(30)
,`teaching_load_firstName` varchar(50)
,`teaching_load_lastName` varchar(50)
,`cap_lecture_hours` int(1)
,`cap_lab_hours` int(1)
,`cap_self_hours` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_cap2`
-- (See below for the actual view)
--
CREATE TABLE `v_cap2` (
`cap_id` int(11)
,`cap_notes` varchar(30)
,`cap_semester` int(1)
,`cap_year` varchar(4)
,`course_id` int(11)
,`cap_department` varchar(60)
,`course_code_th` varchar(5)
,`course_code_en` varchar(5)
,`course_name_th` varchar(80)
,`course_name_en` varchar(80)
,`course_studio` varchar(10)
,`course_credit` int(1)
,`course_lec` int(1)
,`course_lab` int(1)
,`course_self` int(1)
,`course_lec_hrs` int(2)
,`course_lab_hrs` int(2)
,`course_self_hrs` int(2)
,`cap_citizenid` varchar(13)
,`teaching_load_titlePosition` varchar(30)
,`teaching_load_firstName` varchar(50)
,`teaching_load_lastName` varchar(50)
,`teaching_load_department` varchar(50)
,`cap_lecture_hours` int(1)
,`cap_lab_hours` int(1)
,`cap_self_hours` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_cas`
-- (See below for the actual view)
--
CREATE TABLE `v_cas` (
`cap_id` int(11)
,`cap_notes` varchar(30)
,`cap_semester` int(1)
,`cap_year` varchar(4)
,`course_id` int(11)
,`course_code_th` varchar(5)
,`course_code_en` varchar(5)
,`course_name_th` varchar(80)
,`course_name_en` varchar(80)
,`course_credit` int(1)
,`course_lec` int(1)
,`course_lab` int(1)
,`course_self` int(1)
,`course_lec_hrs` int(2)
,`course_lab_hrs` int(2)
,`course_self_hrs` int(2)
,`cap_citizenid` varchar(13)
,`cap_lecture_hours` int(1)
,`cap_lab_hours` int(1)
,`cap_self_hours` int(1)
);

-- --------------------------------------------------------

--
-- Structure for view `v_cap`
--
DROP TABLE IF EXISTS `v_cap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cap`  AS SELECT `cap`.`cap_id` AS `cap_id`, `cap`.`cap_notes` AS `cap_notes`, `cap`.`cap_semester` AS `cap_semester`, `cap`.`cap_year` AS `cap_year`, `cap`.`course_id` AS `course_id`, `course`.`course_code_th` AS `course_code_th`, `course`.`course_code_en` AS `course_code_en`, `course`.`course_name_th` AS `course_name_th`, `course`.`course_name_en` AS `course_name_en`, `course`.`course_credit` AS `course_credit`, `course`.`course_lec` AS `course_lec`, `course`.`course_lab` AS `course_lab`, `course`.`course_self` AS `course_self`, `course`.`course_lec_hrs` AS `course_lec_hrs`, `course`.`course_lab_hrs` AS `course_lab_hrs`, `course`.`course_self_hrs` AS `course_self_hrs`, `cap`.`cap_citizenid` AS `cap_citizenid`, `telo`.`teaching_load_titlePosition` AS `teaching_load_titlePosition`, `telo`.`teaching_load_firstName` AS `teaching_load_firstName`, `telo`.`teaching_load_lastName` AS `teaching_load_lastName`, `cap`.`cap_lecture_hours` AS `cap_lecture_hours`, `cap`.`cap_lab_hours` AS `cap_lab_hours`, `cap`.`cap_self_hours` AS `cap_self_hours` FROM ((`course_active_primary` `cap` left join `course` on(`course`.`course_id` = `cap`.`course_id`)) left join `teaching_load` `telo` on(`cap`.`cap_citizenid` = `telo`.`teaching_load_citizenid`)) WHERE `course`.`course_status` = 'enable' AND `cap`.`cap_status` = 'enable' GROUP BY `cap`.`cap_id`, `cap`.`cap_notes`, `cap`.`cap_semester`, `cap`.`cap_year`, `cap`.`course_id`, `course`.`course_code_th`, `course`.`course_code_en`, `course`.`course_name_th`, `course`.`course_name_en`, `course`.`course_credit`, `course`.`course_lec`, `course`.`course_lab`, `course`.`course_self`, `course`.`course_lec_hrs`, `course`.`course_lab_hrs`, `course`.`course_self_hrs`, `cap`.`cap_citizenid`, `telo`.`teaching_load_titlePosition`, `telo`.`teaching_load_firstName`, `telo`.`teaching_load_lastName`, `cap`.`cap_lecture_hours`, `cap`.`cap_lab_hours`, `cap`.`cap_self_hours` ORDER BY `cap`.`cap_id` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `v_cap2`
--
DROP TABLE IF EXISTS `v_cap2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`teachingload`@`%` SQL SECURITY DEFINER VIEW `v_cap2`  AS SELECT `cap`.`cap_id` AS `cap_id`, `cap`.`cap_notes` AS `cap_notes`, `cap`.`cap_semester` AS `cap_semester`, `cap`.`cap_year` AS `cap_year`, `cap`.`course_id` AS `course_id`, `cap`.`cap_department` AS `cap_department`, `course`.`course_code_th` AS `course_code_th`, `course`.`course_code_en` AS `course_code_en`, `course`.`course_name_th` AS `course_name_th`, `course`.`course_name_en` AS `course_name_en`, `course`.`course_studio` AS `course_studio`, `course`.`course_credit` AS `course_credit`, `course`.`course_lec` AS `course_lec`, `course`.`course_lab` AS `course_lab`, `course`.`course_self` AS `course_self`, `course`.`course_lec_hrs` AS `course_lec_hrs`, `course`.`course_lab_hrs` AS `course_lab_hrs`, `course`.`course_self_hrs` AS `course_self_hrs`, `cap`.`cap_citizenid` AS `cap_citizenid`, `telo`.`teaching_load_titlePosition` AS `teaching_load_titlePosition`, `telo`.`teaching_load_firstName` AS `teaching_load_firstName`, `telo`.`teaching_load_lastName` AS `teaching_load_lastName`, `telo`.`teaching_load_department` AS `teaching_load_department`, `cap`.`cap_lecture_hours` AS `cap_lecture_hours`, `cap`.`cap_lab_hours` AS `cap_lab_hours`, `cap`.`cap_self_hours` AS `cap_self_hours` FROM ((`course_active_primary` `cap` left join `course` on(`course`.`course_id` = `cap`.`course_id`)) left join `teaching_load` `telo` on(`cap`.`cap_citizenid` = `telo`.`teaching_load_citizenid`)) WHERE `course`.`course_status` = 'enable' AND `cap`.`cap_status` = 'enable' GROUP BY `cap`.`cap_id`, `cap`.`cap_notes`, `cap`.`cap_semester`, `cap`.`cap_year`, `cap`.`course_id`, `cap`.`cap_department`, `course`.`course_code_th`, `course`.`course_code_en`, `course`.`course_name_th`, `course`.`course_name_en`, `course`.`course_credit`, `course`.`course_lec`, `course`.`course_lab`, `course`.`course_self`, `course`.`course_lec_hrs`, `course`.`course_lab_hrs`, `course`.`course_self_hrs`, `cap`.`cap_citizenid`, `telo`.`teaching_load_titlePosition`, `telo`.`teaching_load_firstName`, `telo`.`teaching_load_lastName`, `telo`.`teaching_load_department`, `cap`.`cap_lecture_hours`, `cap`.`cap_lab_hours`, `cap`.`cap_self_hours` ORDER BY `cap`.`cap_id` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `v_cas`
--
DROP TABLE IF EXISTS `v_cas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cas`  AS SELECT `cap`.`cap_id` AS `cap_id`, `cap`.`cap_notes` AS `cap_notes`, `cap`.`cap_semester` AS `cap_semester`, `cap`.`cap_year` AS `cap_year`, `cap`.`course_id` AS `course_id`, `course`.`course_code_th` AS `course_code_th`, `course`.`course_code_en` AS `course_code_en`, `course`.`course_name_th` AS `course_name_th`, `course`.`course_name_en` AS `course_name_en`, `course`.`course_credit` AS `course_credit`, `course`.`course_lec` AS `course_lec`, `course`.`course_lab` AS `course_lab`, `course`.`course_self` AS `course_self`, `course`.`course_lec_hrs` AS `course_lec_hrs`, `course`.`course_lab_hrs` AS `course_lab_hrs`, `course`.`course_self_hrs` AS `course_self_hrs`, `cap`.`cap_citizenid` AS `cap_citizenid`, `cap`.`cap_lecture_hours` AS `cap_lecture_hours`, `cap`.`cap_lab_hours` AS `cap_lab_hours`, `cap`.`cap_self_hours` AS `cap_self_hours` FROM (`course_active_primary` `cap` left join `course` on(`course`.`course_id` = `cap`.`course_id`)) WHERE `course`.`course_status` = 'enable' AND `cap`.`cap_status` = 'enable' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_active_primary`
--
ALTER TABLE `course_active_primary`
  ADD PRIMARY KEY (`cap_id`);

--
-- Indexes for table `course_active_secondary`
--
ALTER TABLE `course_active_secondary`
  ADD PRIMARY KEY (`cas_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `teacher_additional`
--
ALTER TABLE `teacher_additional`
  ADD PRIMARY KEY (`ta_id`);

--
-- Indexes for table `teaching_load`
--
ALTER TABLE `teaching_load`
  ADD PRIMARY KEY (`teaching_load_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `course_active_primary`
--
ALTER TABLE `course_active_primary`
  MODIFY `cap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `course_active_secondary`
--
ALTER TABLE `course_active_secondary`
  MODIFY `cas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_additional`
--
ALTER TABLE `teacher_additional`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teaching_load`
--
ALTER TABLE `teaching_load`
  MODIFY `teaching_load_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
