-- phpMyAdmin SQL Dump
-- version 4.1.13
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 15 May 2014, 10:00:27
-- Sunucu sürümü: 5.5.37-0ubuntu0.12.04.1
-- PHP Sürümü: 5.3.10-1ubuntu3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `schoolProject`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcement`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `choices`
--

CREATE TABLE IF NOT EXISTS `choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `choice` text COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `choices`
--

INSERT INTO `choices` (`id`, `question_id`, `choice`) VALUES
(1, 3, 'sdf'),
(2, 3, 'sdf'),
(3, 3, 'sdf'),
(4, 3, 'sdf'),
(5, 3, 'dsf');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `choice_answers`
--

CREATE TABLE IF NOT EXISTS `choice_answers` (
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `class`
--

INSERT INTO `class` (`id`, `name`, `is_deleted`) VALUES
(1, 'Birinci SÄ±nÄ±f', 'false'),
(2, 'Ä°kinci SÄ±nÄ±f', 'false'),
(3, 'ÃœÃ§Ã¼ncÃ¼ SÄ±nÄ±f', 'false'),
(4, 'DÃ¶rdÃ¼ncÃ¼ SÄ±nÄ±f', 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `advisor_id` int(11) NOT NULL,
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `department`
--

INSERT INTO `department` (`id`, `name`, `advisor_id`, `is_deleted`) VALUES
(1, 'Bilgisayar MÃ¼hendisliÄŸi', 22, 'false'),
(2, 'Harita MÃ¼hendisliÄŸi', 0, 'false'),
(3, 'Makina MÃ¼hendisliÄŸi', 0, 'false'),
(4, 'GÄ±da MÃ¼hendisliÄŸi', 0, 'false'),
(5, 'EndÃ¼stri MÃ¼hendisliÄŸi', 0, 'false'),
(6, 'Kimya MÃ¼hendisliÄŸi', 0, 'false'),
(7, 'Elektrik Elektronik MÃ¼hendisliÄŸi', 0, 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exam`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `exam`
--

INSERT INTO `exam` (`id`, `lesson_id`, `class_id`, `department_id`, `teacher_id`, `title`, `detail`, `type`, `start_time`, `finish_time`, `is_deleted`) VALUES
(1, 9, 4, 1, 22, 'Vize', 'sdfmdsbf adÃ¶f adÃ¶sf Ã¶', 'online', '2014-05-23 10:42:28', '2014-05-21 10:42:28', 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `homework`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `homework`
--

INSERT INTO `homework` (`id`, `lesson_id`, `teacher_id`, `class_id`, `department_id`, `title`, `detail`, `finish_time`, `is_deleted`) VALUES
(1, 9, 22, 4, 1, 'Ä°lk Ã¶devimiz', 'Bu bizim ilk Ã¶devimiz', '2014-05-20 10:58:51', 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lesson`
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
-- Tablo döküm verisi `lesson`
--

INSERT INTO `lesson` (`id`, `name`, `class_id`, `department_id`, `teacher_id`, `is_deleted`) VALUES
(1, 'Bilgisayar MÃ¼hendisliÄŸinde Ã–zel Konular 2', 1, 1, 25, 'false'),
(2, 'Sistem Programlama', 2, 1, 24, 'false'),
(3, 'Ã–zdevinirler KuramÄ±', 2, 1, 25, 'false'),
(4, 'SayÄ±sal Ã‡Ã¶zÃ¼mleme', 2, 1, 25, 'false'),
(5, 'AyrÄ±k Matematik', 1, 1, 25, 'false'),
(7, 'Algoritmalar', 2, 1, 23, 'false'),
(8, 'Web Programlama', 2, 1, 37, 'false'),
(9, 'Bilgisayar MÃ¼hendisliÄŸinde Ã–zel Konular', 4, 1, 22, 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lesson_student`
--

CREATE TABLE IF NOT EXISTS `lesson_student` (
  `student_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `confirmation` varchar(20) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `lesson_student`
--

INSERT INTO `lesson_student` (`student_id`, `lesson_id`, `confirmation`, `time`) VALUES
(34, 1, 'false', '2014-05-15 07:34:08'),
(34, 1, 'false', '2014-05-15 07:34:10'),
(34, 1, 'false', '2014-05-15 07:34:11'),
(34, 5, 'false', '2014-05-15 07:44:48'),
(34, 2, 'false', '2014-05-15 07:46:25'),
(34, 3, 'false', '2014-05-15 07:46:26'),
(34, 4, 'false', '2014-05-15 07:46:27'),
(34, 7, 'false', '2014-05-15 07:46:28'),
(34, 8, 'true', '2014-05-15 07:46:30'),
(34, 9, 'true', '2014-05-15 07:46:31'),
(33, 1, 'false', '2014-05-15 07:46:54'),
(33, 5, 'false', '2014-05-15 07:46:55'),
(33, 2, 'false', '2014-05-15 07:46:56'),
(33, 3, 'false', '2014-05-15 07:46:56'),
(33, 7, 'false', '2014-05-15 07:46:57'),
(33, 4, 'false', '2014-05-15 07:46:58'),
(33, 8, 'true', '2014-05-15 07:46:59'),
(33, 9, 'true', '2014-05-15 07:47:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `members`
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
  `password` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(35) COLLATE utf8_turkish_ci NOT NULL,
  `adress` text COLLATE utf8_turkish_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmation` varchar(20) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  `role` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `is_advisor` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  `is_deleted` varchar(5) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=38 ;

--
-- Tablo döküm verisi `members`
--

INSERT INTO `members` (`id`, `name`, `surname`, `studentNumber`, `department_id`, `class_id`, `gender`, `telephone`, `password`, `email`, `adress`, `time`, `confirmation`, `role`, `is_advisor`, `is_deleted`) VALUES
(1, 'Hursit', 'Topal', '10060291', 0, 0, '', '', 'levend03', 'hursit.topal@bil.omu.edu.tr', '', '2014-05-01 10:50:41', 'true', 'admin', '', 'false'),
(22, 'BÃ¼nyamin', 'Karabulut', '', 1, 0, 'erkek', '03624373069', 'bunyamin.karabulut', 'bunyamin.karabulut@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:43:27', 'true', 'teacher', 'true', 'false'),
(23, 'Nurettin', 'Åženyer', '', 1, 0, 'erkek', '03624373069', 'nurettin.senyer', 'nurettin.senyer@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:48:28', 'true', 'teacher', 'false', 'false'),
(24, 'Recai', 'OktaÅŸ', '', 1, 0, 'erkek', '03624373069', 'recai.oktas', 'recai.oktas@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:49:15', 'true', 'teacher', 'false', 'false'),
(25, 'Sedat', 'Akleylek', '', 1, 0, 'erkek', '03624373069', 'sedat.akleylek', 'sedat.akleylek@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:49:45', 'true', 'teacher', 'false', 'false'),
(26, 'Kerem ', 'Erzurumlu', '', 1, 0, 'erkek', '03624373069', 'kerem.erzurumlu', 'kerem.erzurumlu@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:50:37', 'true', 'teacher', 'false', 'false'),
(27, 'Erdal', 'KÄ±lÄ±Ã§', '', 1, 0, 'erkek', '03624373069', 'erdal.kilic', 'erdal.kilic@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:51:15', 'true', 'teacher', 'false', 'false'),
(28, 'GÃ¶khan', 'Kayhan', '', 1, 0, 'erkek', '03624373069', 'gokhan.kayhan', 'gokhan.kayhan@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:51:52', 'true', 'teacher', 'false', 'false'),
(29, 'Erhan', 'ErgÃ¼n', '', 1, 0, 'erkek', '03624373069', 'erhan.ergun', 'erhan.ergun@bil.omu.edu.tr', '19 MayÄ±s Ãœniversitesi Bilgisayar MÃ¼hendisliÄŸi SAMSUN', '2014-05-15 06:52:28', 'true', 'teacher', 'false', 'false'),
(30, 'Selim', 'BayÄ±k', '10060277', 1, 4, 'erkek', '05433333333', 'selim.bayik', 'selim.bayik@bil.omu.edu.tr', 'Samsun OMU', '2014-05-15 07:07:04', 'true', 'student', 'false', 'false'),
(31, 'Koray', 'Tahta', '10060599', 1, 4, 'erkek', '05455555555', 'koray.tahta', 'koray.tahta@bil.omu.edu.tr', 'OMU SAMSUN', '2014-05-15 07:08:17', 'true', 'student', 'false', 'false'),
(32, 'Alaattin', 'Usta', '10060281', 1, 4, 'erkek', '05433945453', 'alaattin.usta', 'alaattin.usta@bil.omu.edu.tr', 'OMU SAMSUN', '2014-05-15 07:09:54', 'true', 'student', 'false', 'false'),
(33, 'Ensar', 'Hamzacebi', '10060271', 1, 4, 'erkek', '05435698745', 'ensar.hamzacebi', 'ensar.hamzacebi@bil.omu.edu.tr', 'SAMSUN OMU', '2014-05-15 07:11:29', 'true', 'student', 'false', 'false'),
(34, 'Mehmet', 'BaÅŸal', '10060288', 1, 4, 'erkek', '05436987412', 'mehmet.basal', 'mehmet.basal@bil.omu.edu.tr', 'SAMSUN OMU', '2014-05-15 07:12:05', 'true', 'student', 'false', 'false'),
(35, 'Yavuz Selim', 'Mutlu', '11000054', 1, 3, 'erkek', '05444444444', 'yavuz.selim', 'yavuz.selim@bil.omu.edu.tr', 'Samsun OMU', '2014-05-15 07:13:00', 'true', 'student', 'false', 'false'),
(36, 'Hakan Kaan', 'Arslan', '110254598', 1, 3, 'erkek', '05466666666', 'hakan.kaan', 'hakan.kaan@bil.omu.edu.tr', 'SAMSUN OMU', '2014-05-15 07:13:44', 'true', 'student', 'false', 'false'),
(37, 'Ä°smail', 'Ä°ÅŸeri', '', 1, 0, 'erkek', '03624323069', 'ismail.iseri', 'ismail.iseri@bil.omu.edu.tr', 'Samsun OMU', '2014-05-15 07:30:45', 'true', 'teacher', 'false', 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `question` longtext COLLATE utf8_turkish_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `question`, `type`) VALUES
(1, 1, 'Ä°lk Sorumuz', 'written'),
(2, 1, 'Ä°kinci Sorumuz', 'written'),
(3, 1, 'ÃœÃ§Ã¼ncÃ¼ Sorumuz', 'multiple choice');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_exam`
--

CREATE TABLE IF NOT EXISTS `student_exam` (
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_homeworks`
--

CREATE TABLE IF NOT EXISTS `student_homeworks` (
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `homework` longtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `written_answers`
--

CREATE TABLE IF NOT EXISTS `written_answers` (
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` longtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
