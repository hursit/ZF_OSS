
-- phpMyAdmin SQL Dump
-- version 4.1.13
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2014 at 01:42 AM
-- Server version: 5.5.37-0ubuntu0.12.04.1
-- PHP Version: 5.5.12-2+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `schoolProject`
--
CREATE DATABASE IF NOT EXISTS `schoolProject` DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci;
USE `schoolProject`;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8_turkish_ci NOT NULL,
  `detail` text COLLATE utf8_turkish_ci NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `department_id` (`department_id`),
  KEY `lesson_id_2` (`lesson_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `department_id`, `class_id`, `lesson_id`, `teacher_id`, `title`, `detail`, `time`, `is_deleted`) VALUES
(2, 1, 1, 5, 1, 'ikinci duyurum', 'buu benim ikinci duyurum', '2014-06-03 07:43:21', 'false'),
(3, 1, 1, 1, 22, 'Ä°lk duyurumuz', 'Bu bizim ilk duyurumuz', '2014-06-03 07:47:27', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE IF NOT EXISTS `choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `choice` text COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `question_id`, `choice`) VALUES
(1, 3, 'sdf'),
(2, 3, 'sdf'),
(3, 3, 'sdf'),
(4, 3, 'sdf'),
(5, 3, 'dsf');

-- --------------------------------------------------------

--
-- Table structure for table `choice_answers`
--

CREATE TABLE IF NOT EXISTS `choice_answers` (
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `choice_answers`
--

INSERT INTO `choice_answers` (`student_id`, `question_id`, `choice_id`) VALUES
(32, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `is_deleted`) VALUES
(1, 'Birinci SÄ±nÄ±f', 'false'),
(2, 'Ä°kinci SÄ±nÄ±f', 'false'),
(3, 'ÃœÃ§Ã¼ncÃ¼ SÄ±nÄ±f', 'false'),
(4, 'DÃ¶rdÃ¼ncÃ¼ SÄ±nÄ±f', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `advisor_id` int(11) NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `advisor_id`, `is_deleted`) VALUES
(1, 'Bilgisayar MÃ¼hendisliÄŸi', 22, 'true'),
(2, 'Harita MÃ¼hendisliÄŸi', 0, 'true'),
(3, 'Makina MÃ¼hendisliÄŸi', 0, 'true'),
(4, 'GÄ±da MÃ¼hendisliÄŸi', 0, 'true'),
(5, 'EndÃ¼stri MÃ¼hendisliÄŸi', 0, 'true'),
(6, 'Kimya MÃ¼hendisliÄŸi', 0, 'true'),
(7, 'Elektrik Elektronik MÃ¼hendisliÄŸi', 0, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `detail` text COLLATE utf8_turkish_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `finish_time` datetime NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `lesson_id`, `class_id`, `department_id`, `teacher_id`, `title`, `detail`, `type`, `start_time`, `finish_time`, `is_deleted`) VALUES
(1, 9, 4, 1, 22, 'Vize', '                                                                                                                                               sdfmdsbf adÃ¶f adÃ¶sf Ã¶<br>&nbsp;<img src="http://i.imgur.com/vU5Y8o4.jpg" height="156" width="156"><br>cevabÄ± nedir.?<br> \r\n         \r\n         \r\n         \r\n         \r\n         \r\n         \r\n         \r\n         \r\n         \r\n        ', 'online', '2014-06-06 01:51:54', '2014-06-06 02:04:33', 'false'),
(2, 9, 4, 1, 22, 'sa', '                          ssa \r\n         \r\n        ', 'online', '2014-06-05 22:42:08', '2014-06-10 01:51:11', 'false'),
(3, 9, 4, 1, 22, 'deneme', 'sdf', 'online', '2014-06-05 23:40:31', '2014-06-17 23:40:31', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE IF NOT EXISTS `homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `detail` text COLLATE utf8_turkish_ci NOT NULL,
  `finish_time` datetime NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`id`, `lesson_id`, `teacher_id`, `class_id`, `department_id`, `title`, `detail`, `finish_time`, `is_deleted`) VALUES
(1, 9, 22, 4, 1, 'Ä°lk Ã¶devimiz', 'Bu bizim ilk Ã¶devimiz', '2014-06-05 23:12:00', 'false'),
(2, 9, 22, 4, 1, 'ss', 'aa', '2014-05-27 23:43:46', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_turkish_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `name`, `class_id`, `department_id`, `teacher_id`, `is_deleted`) VALUES
(1, 'Bilgisayar MÃ¼hendisliÄŸinde Ã–zel Konular 2', 1, 1, 25, 'false'),
(2, 'Sistem Programlama', 2, 1, 24, 'false'),
(3, 'Ã–zdevinirler KuramÄ±', 2, 1, 25, 'false'),
(4, 'SayÄ±sal Ã‡Ã¶zÃ¼mleme', 2, 1, 25, 'false'),
(5, 'AyrÄ±k Matematik', 1, 1, 25, 'false'),
(7, 'Algoritmalar', 2, 1, 23, 'true'),
(8, 'Web Programlama', 2, 1, 37, 'true'),
(9, 'Bilgisayar MÃ¼hendisliÄŸinde Ã–zel Konular', 4, 1, 22, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_student`
--

CREATE TABLE IF NOT EXISTS `lesson_student` (
  `student_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `confirmation` varchar(20) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `lesson_student`
--

INSERT INTO `lesson_student` (`student_id`, `lesson_id`, `confirmation`, `time`) VALUES
(32, 1, 'false', '2014-06-05 15:22:58'),
(32, 9, 'true', '2014-06-05 15:24:32');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) COLLATE utf8_turkish_ci NOT NULL,
  `surname` varchar(35) COLLATE utf8_turkish_ci NOT NULL,
  `studentNumber` varchar(11) COLLATE utf8_turkish_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `gender` varchar(5) COLLATE utf8_turkish_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(35) COLLATE utf8_turkish_ci NOT NULL,
  `adress` text COLLATE utf8_turkish_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmation` varchar(20) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  `role` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `is_advisor` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `surname`, `studentNumber`, `department_id`, `class_id`, `gender`, `telephone`, `password`, `email`, `adress`, `time`, `confirmation`, `role`, `is_advisor`, `is_deleted`) VALUES
(1, 'Hursit', 'Topal', '10060291', 0, 0, '', '', '59411d4efbf3facd2b8adc56fce39a85c81fb46c', 'hursit.topal@bil.omu.edu.tr', '', '2014-05-01 10:50:41', 'true', 'admin', '', 'false'),
(22, 'BÃ¼nyamin', 'Karabulut', '', 1, 0, 'erkek', '03624373069', '59411d4efbf3facd2b8adc56fce39a85c81fb46c', 'bunyamin.karabulut@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:43:27', 'true', 'teacher', 'true', 'false'),
(23, 'Nurettin', 'Åženyer', '', 1, 0, 'erkek', '03624373069', 'nurettin.senyer', 'nurettin.senyer@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:48:28', 'true', 'teacher', 'false', 'false'),
(24, 'Recai', 'OktaÅŸ', '', 1, 0, 'erkek', '03624373069', 'recai.oktas', 'recai.oktas@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:49:15', 'true', 'teacher', 'false', 'false'),
(25, 'Sedat', 'Akleylek', '', 1, 0, 'erkek', '03624373069', 'sedat.akleylek', 'sedat.akleylek@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:49:45', 'true', 'teacher', 'false', 'false'),
(26, 'Kerem ', 'Erzurumlu', '', 1, 0, 'erkek', '03624373069', 'kerem.erzurumlu', 'kerem.erzurumlu@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:50:37', 'true', 'teacher', 'false', 'false'),
(27, 'Erdal', 'KÄ±lÄ±Ã§', '', 1, 0, 'erkek', '03624373069', 'erdal.kilic', 'erdal.kilic@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:51:15', 'true', 'teacher', 'false', 'false'),
(28, 'GÃ¶khan', 'Kayhan', '', 1, 0, 'erkek', '03624373069', 'gokhan.kayhan', 'gokhan.kayhan@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:51:52', 'true', 'teacher', 'false', 'false'),
(29, 'Erhan', 'ErgÃ¼n', '', 1, 0, 'erkek', '03624373069', 'erhan.ergun', 'erhan.ergun@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:52:28', 'true', 'teacher', 'false', 'false'),
(30, 'Selim', 'BayÄ±k', '10060277', 1, 4, 'erkek', '05433333333', 'selim.bayik', 'selim.bayik@bil.omu.edu.tr', 'Samsun OMU', '2014-05-15 07:07:04', 'true', 'student', 'false', 'false'),
(31, 'Koray', 'Tahta', '10060599', 1, 4, 'erkek', '05455555555', 'koray.tahta', 'koray.tahta@bil.omu.edu.tr', 'OMU SAMSUN', '2014-05-15 07:08:17', 'true', 'student', 'false', 'false'),
(32, 'Alaattin', 'Usta', '10060281', 1, 4, 'erkek', '05433945453', '59411d4efbf3facd2b8adc56fce39a85c81fb46c', 'alaattin.usta@bil.omu.edu.tr', 'OMU SAMSUN', '2014-05-15 07:09:54', 'true', 'student', 'false', 'false'),
(33, 'Ensar', 'Hamzacebi', '10060271', 1, 4, 'erkek', '05435698745', 'ensar.hamzacebi', 'ensar.hamzacebi@bil.omu.edu.tr', 'SAMSUN OMU', '2014-05-15 07:11:29', 'true', 'student', 'false', 'false'),
(34, 'Mehmet', 'BaÅŸal', '10060288', 1, 4, 'erkek', '05436987412', 'mehmet.basal', 'mehmet.basal@bil.omu.edu.tr', 'SAMSUN OMU', '2014-05-15 07:12:05', 'true', 'student', 'false', 'false'),
(35, 'Yavuz Selim', 'Mutlu', '11000054', 1, 3, 'erkek', '05444444444', 'yavuz.selim', 'yavuz.selim@bil.omu.edu.tr', 'Samsun OMU', '2014-05-15 07:13:00', 'true', 'student', 'false', 'false'),
(36, 'Hakan Kaan', 'Arslan', '110254598', 1, 3, 'erkek', '05466666666', 'hakan.kaan', 'hakan.kaan@bil.omu.edu.tr', 'SAMSUN OMU', '2014-05-15 07:13:44', 'true', 'student', 'false', 'false'),
(37, 'Ä°smail', 'Ä°ÅŸeri', '', 1, 0, 'erkek', '03624323069', 'ismail.iseri', 'ismail.iseri@bil.omu.edu.tr', 'Samsun OMU', '2014-05-15 07:30:45', 'true', 'teacher', 'false', 'false'),
(38, 'Adem', 'SandÄ±kcÄ±', '10060222', 1, 3, 'erkek', '54545454545', 'adem.sandikci', 'adem.sandikci@bil.omu.edu.tr', 'adresim', '2014-05-16 07:29:02', 'true', 'student', 'false', 'false'),
(39, 'qw', 'qw', '', 1, 0, 'erkek', '1454125412', 'e1afe74ad804c8c7905b', '1542541254', '4444', '2014-06-05 14:09:35', 'false', 'teacher', 'false', 'false'),
(41, 'qqqqqq', 'qqqqqq', '', 1, 0, 'erkek', '111111111111', '552798b7236cdd5ed5c53fd5c4ca029fb8fef844', 'qqqqqq', 'qqqqqq', '2014-06-05 14:12:37', 'true', 'teacher', 'false', 'false'),
(42, 'pasa', 'topall', '10060298', 1, 1, 'erkek', '1472583694545', '59411d4efbf3facd2b8adc56fce39a85c81fb46c', 'pasa@pasa.com', 'pasa', '2014-06-05 14:16:23', 'true', 'student', 'false', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `question` longtext COLLATE utf8_turkish_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `question`, `type`) VALUES
(1, 1, 'Cengiz Kanat neyin nesidir', 'multiple choice'),
(2, 1, 'Ä°kinci Sorumuz', 'written'),
(3, 1, 'ÃœÃ§Ã¼ncÃ¼ Sorumuz', 'multiple choice');

-- --------------------------------------------------------

--
-- Table structure for table `student_exam`
--

CREATE TABLE IF NOT EXISTS `student_exam` (
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `student_exam`
--

INSERT INTO `student_exam` (`student_id`, `exam_id`) VALUES
(32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_homeworks`
--

CREATE TABLE IF NOT EXISTS `student_homeworks` (
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `homework` longtext COLLATE utf8_turkish_ci NOT NULL,
  `zaman` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `written_answers`
--

CREATE TABLE IF NOT EXISTS `written_answers` (
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` longtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `written_answers`
--

INSERT INTO `written_answers` (`student_id`, `question_id`, `answer`) VALUES
(32, 2, 'sdfsdf');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
