-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2021 at 08:53 AM
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
  `course_code_th` varchar(5) NOT NULL COMMENT 'รหัสวิชา ภาษาไทย',
  `course_code_en` varchar(5) DEFAULT NULL COMMENT 'รหัสวิชา ภาษาอังกฤษ',
  `course_name_th` varchar(80) NOT NULL COMMENT 'ชื่อวิชา ภาษาไทย',
  `course_name_en` varchar(80) DEFAULT NULL COMMENT 'ชื่อวิชา ภาษาอังกฤษ',
  `course_credit` int(1) DEFAULT NULL COMMENT 'หน่วยกิต',
  `course_lec` int(1) DEFAULT NULL COMMENT 'หน่วยกิต ภาคบรรยาย',
  `course_lab` int(1) DEFAULT NULL COMMENT 'หน่วยกิต ภาคปฏิบัติ',
  `course_self` int(1) DEFAULT NULL COMMENT 'หน่วยกิต ภาคการศึกษาด้วยตนเอง',
  `course_lec_hrs` int(2) NOT NULL DEFAULT 15,
  `course_lab_hrs` int(2) NOT NULL DEFAULT 15,
  `course_self_hrs` int(2) NOT NULL DEFAULT 0,
  `course_status` varchar(10) NOT NULL DEFAULT 'enable' COMMENT 'สถานะ',
  `course_editor` varchar(20) DEFAULT NULL COMMENT 'ผู้บันทึก',
  `course_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_active_primary`
--

CREATE TABLE `course_active_primary` (
  `cap_id` int(11) NOT NULL,
  `cap_notes` varchar(30) DEFAULT NULL,
  `cap_semester` int(1) NOT NULL,
  `cap_year` varchar(4) NOT NULL,
  `course_id` int(11) NOT NULL,
  `cap_citizenid` varchar(13) NOT NULL,
  `cap_lecture_hours` int(1) DEFAULT 0,
  `cap_lab_hours` int(1) DEFAULT 0,
  `cap_self_hours` int(1) DEFAULT 0,
  `cap_status` varchar(10) NOT NULL DEFAULT 'enable',
  `cap_editor` varchar(20) DEFAULT NULL,
  `cap_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_active_secondary`
--

CREATE TABLE `course_active_secondary` (
  `cas_id` int(11) NOT NULL,
  `cap_id` int(11) NOT NULL,
  `cas_citizenid` varchar(13) NOT NULL,
  `cas_lecture_hours` int(1) NOT NULL,
  `cas_lab_hours` int(1) NOT NULL,
  `cas_self_hours` int(1) NOT NULL,
  `cas_status` varchar(10) NOT NULL DEFAULT 'enable',
  `cas_editor` varchar(20) DEFAULT NULL,
  `cas_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_additional`
--

CREATE TABLE `teacher_additional` (
  `ta_id` int(11) NOT NULL,
  `ta_citizenid` varchar(13) NOT NULL,
  `ta_prefix` varchar(20) DEFAULT NULL,
  `ta_firstname` varchar(30) NOT NULL,
  `ta_lastname` varchar(30) NOT NULL,
  `ta_status` varchar(10) NOT NULL DEFAULT 'enable',
  `ta_editor` varchar(20) DEFAULT NULL,
  `ta_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teaching_load`
--

CREATE TABLE `teaching_load` (
  `teaching_load_id` int(11) NOT NULL,
  `teaching_load_citizenid` varchar(13) NOT NULL,
  `teaching_load_titlePosition` varchar(30) DEFAULT NULL,
  `teaching_load_firstName` varchar(50) NOT NULL,
  `teaching_load_lastName` varchar(50) NOT NULL,
  `teaching_load_lec_hours` int(3) NOT NULL DEFAULT 0,
  `teaching_load_lab_hours` int(3) NOT NULL DEFAULT 0,
  `teaching_load_semester` int(1) NOT NULL,
  `teaching_load_edu_year` varchar(4) NOT NULL,
  `teaching_load_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cap`  AS SELECT `cap`.`cap_id` AS `cap_id`, `cap`.`cap_notes` AS `cap_notes`, `cap`.`cap_semester` AS `cap_semester`, `cap`.`cap_year` AS `cap_year`, `cap`.`course_id` AS `course_id`, `course`.`course_code_th` AS `course_code_th`, `course`.`course_code_en` AS `course_code_en`, `course`.`course_name_th` AS `course_name_th`, `course`.`course_name_en` AS `course_name_en`, `course`.`course_credit` AS `course_credit`, `course`.`course_lec` AS `course_lec`, `course`.`course_lab` AS `course_lab`, `course`.`course_self` AS `course_self`, `course`.`course_lec_hrs` AS `course_lec_hrs`, `course`.`course_lab_hrs` AS `course_lab_hrs`, `course`.`course_self_hrs` AS `course_self_hrs`, `cap`.`cap_citizenid` AS `cap_citizenid`, `cap`.`cap_lecture_hours` AS `cap_lecture_hours`, `cap`.`cap_lab_hours` AS `cap_lab_hours`, `cap`.`cap_self_hours` AS `cap_self_hours` FROM (`course_active_primary` `cap` left join `course` on(`course`.`course_id` = `cap`.`course_id`)) WHERE `course`.`course_status` = 'enable' AND `cap`.`cap_status` = 'enable' ;

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
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_active_primary`
--
ALTER TABLE `course_active_primary`
  MODIFY `cap_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_active_secondary`
--
ALTER TABLE `course_active_secondary`
  MODIFY `cas_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_additional`
--
ALTER TABLE `teacher_additional`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teaching_load`
--
ALTER TABLE `teaching_load`
  MODIFY `teaching_load_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
