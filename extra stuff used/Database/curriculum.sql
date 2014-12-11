-- phpMyAdmin SQL Dump
-- version 4.0.0
-- http://www.phpmyadmin.net
--
-- Host: web-db.cs.fiu.edu
-- Generation Time: Sep 28, 2014 at 02:07 PM
-- Server version: 5.0.51a
-- PHP Version: 5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `curriculum`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_profiles`
--

CREATE TABLE IF NOT EXISTS `acl_profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL default '',
  `firstname` varchar(50) NOT NULL default '',
  `birthday` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acl_profiles`
--

INSERT INTO `acl_profiles` (`user_id`, `lastname`, `firstname`, `birthday`) VALUES
(1, 'Admin', 'Administrator', '0000-00-00'),
(2, 'Demo', 'Demo', '0000-00-00'),
(3, 'Aparicio', 'Oscar', '1986-08-14'),
(4, 'Downey', 'Tim', '2012-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `acl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `acl_profiles_fields` (
  `id` int(10) NOT NULL auto_increment,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL default '0',
  `field_size_min` int(3) NOT NULL default '0',
  `required` int(1) NOT NULL default '0',
  `match` varchar(255) NOT NULL default '',
  `range` varchar(255) NOT NULL default '',
  `error_message` varchar(255) NOT NULL default '',
  `other_validator` varchar(5000) NOT NULL default '',
  `default` varchar(255) NOT NULL default '',
  `widget` varchar(255) NOT NULL default '',
  `widgetparams` varchar(5000) NOT NULL default '',
  `position` int(3) NOT NULL default '0',
  `visible` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acl_profiles_fields`
--

INSERT INTO `acl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'birthday', 'Birthday', 'DATE', 0, 0, 2, '', '', '', '', '0000-00-00', 'UWjuidate', '{"ui-theme":"redmond"}', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `acl_users`
--

CREATE TABLE IF NOT EXISTS `acl_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL default '',
  `createtime` int(10) NOT NULL default '0',
  `lastvisit` int(10) NOT NULL default '0',
  `superuser` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `acl_users`
--

INSERT INTO `acl_users` (`id`, `username`, `password`, `email`, `activkey`, `createtime`, `lastvisit`, `superuser`, `status`) VALUES
(1, 'admin', 'c514c91e4ed341f263e458d44b3bb0a7', 'downeyt@cis.fiu.edu', '0b8ae4558e66e5cad4a8386c451f78df', 1261146094, 1411680816, 1, 1),
(2, 'demo', 'c514c91e4ed341f263e458d44b3bb0a7', 'demo@example.com', '42c3e87b79ee1c17020eef05bdd00404', 1261146096, 1411758220, 0, 1),
(3, 'oscara', '7aae2b7148974363c9240685fb009273', 'oscar.a.aparicio@gmail.com', '149ca99882b3bab3d17578979145de9e', 1352233958, 1353781293, 0, 1),
(4, 'downeyt', '95ccb43f85db4b99a597b7621cfbbb3b', 'downeyt@cs.fiu.edu', 'b8138e2b0e2988902a034794329319a3', 1353041029, 1409847459, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY  (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '2', NULL, 'N;'),
('Authenticated', '1', NULL, 'N;'),
('Admin', '1', NULL, 'N;'),
('Guest', '2', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Authenticated', 2, NULL, NULL, 'N;'),
('Guest', 2, 'GuestUser', NULL, 'N;'),
('Admin', 2, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY  (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `year` int(4) NOT NULL,
  `term` enum('FALL','SPRING','SUMMER') NOT NULL,
  `activated` int(1) NOT NULL default '0',
  `startingDate` timestamp NULL default NULL,
  `activation_userId` int(10) default NULL,
  `parent_catalogId` int(10) default NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `parent_catalogId` (`parent_catalogId`),
  KEY `activation_userId` (`activation_userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `creationDate`, `year`, `term`, `activated`, `startingDate`, `activation_userId`, `parent_catalogId`, `description`) VALUES
(0, 'first year', '2012-11-21 03:38:25', 2000, 'FALL', 1, '2012-11-21 03:38:25', NULL, NULL, NULL),
(2, 'IT Changes', '2012-11-22 06:39:11', 2016, 'FALL', 0, '2016-08-22 04:00:00', NULL, 0, 'A new elective set is being proposed.');

-- --------------------------------------------------------

--
-- Table structure for table `curr_course`
--

CREATE TABLE IF NOT EXISTS `curr_course` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=226 ;

--
-- Dumping data for table `curr_course`
--

INSERT INTO `curr_course` (`id`, `name`, `catalog_id`) VALUES
(1, 'Introduction to Computer Programming', 0),
(2, 'Introduction to Computing', 0),
(3, 'Introduction to Microcomputers', 0),
(4, 'MicroComputer Lab', 0),
(5, 'Intro to Microcomputer Applications for Business', 0),
(6, 'Business Lab', 0),
(7, 'Computer Programming I', 0),
(8, 'Programming I Lab', 0),
(9, 'Programming I Tutoring', 0),
(10, 'Programming in Java', 0),
(11, 'STUDY SESSION', 0),
(12, 'C for Engineers (FLAME)', 0),
(13, 'Microsoft Windows NT Administration', 0),
(14, 'C for Engineers (FLAME)', 0),
(15, 'Data Analysis', 0),
(16, 'Data Analysis Lab', 0),
(17, 'Introduction to Java Programming', 0),
(18, 'Data Analysis', 0),
(19, 'Programming Lab I', 0),
(20, 'Data Analysis Lab', 0),
(21, 'Intro to Java Programming', 0),
(22, 'Programming I for IT', 0),
(23, 'Programming Lab I', 0),
(24, 'Computer Programming I', 0),
(25, 'Programming I Lab', 0),
(26, 'Computer Programming I', 0),
(27, 'Computer Programming Lab I', 0),
(28, 'Microcomputer Organization', 0),
(29, 'Professional Ethics and Social Issues in Computer Science', 0),
(30, 'Technology in the Global Arena', 0),
(31, 'Fundamentals of Computer Systems', 0),
(32, 'Programming in Visual Basic', 0),
(33, 'Microcomputer Organization', 0),
(34, 'Computer Programming II', 0),
(35, 'Computer Programming III', 0),
(36, 'Introduction to Using Unix/Linux Systems', 0),
(37, 'Introduction to Using Unix/Linux Systems', 0),
(38, 'Introduction to Using Unix/Linux Systems', 0),
(39, 'Fundamentals of Computer Systems', 0),
(40, 'Web-based Programming', 0),
(41, 'Logic for Computer Science', 0),
(42, 'Web-based Programming', 0),
(43, 'Data Structures for IT', 0),
(44, 'Data Structures', 0),
(45, 'Using the Internet', 0),
(46, 'Microcomputer Organization', 0),
(47, 'Microcomputer Organization', 0),
(48, 'Introduction to Human-Computer Interaction', 0),
(49, 'Computer Operating Systems', 0),
(50, 'Computer Operating Systems', 0),
(51, 'Intermediate Java Programming', 0),
(52, 'Advanced Web Server Communication', 0),
(53, 'Designing Web Pages', 0),
(54, 'Independent Study', 0),
(55, 'Special Topics', 0),
(56, 'Cooperative Education in Computer Science', 0),
(57, 'Designing Web Pages', 0),
(58, 'Intermediate Java Programming', 0),
(59, 'Designing Web Pages', 0),
(60, 'Programming II for IT', 0),
(61, 'Introduction to Human-Computer Interaction', 0),
(62, 'Designing Web Pages', 0),
(63, 'Windows Programming for IT majors', 0),
(64, 'Windows Components Technology', 0),
(65, 'Software Engineering I', 0),
(66, 'Software Design and Development Project', 0),
(67, 'Software Design and Development Project', 0),
(68, 'Software Engineering II', 0),
(69, 'Component-Based Software Development', 0),
(70, 'Fundamentals of Software Testing', 0),
(71, 'Structured Computer Organization', 0),
(72, 'Advanced Unix Programming', 0),
(73, 'Advanced Windows Programming', 0),
(74, 'Applied Computer Networking', 0),
(75, 'Applied Computer Networking', 0),
(76, 'Applied Computer Networking', 0),
(77, 'Programming III', 0),
(78, 'Unix System Administration', 0),
(79, 'Unix System Administration', 0),
(80, 'Computer and Network Security', 0),
(81, 'Knowledge-Based Management Systems', 0),
(82, 'Information Storage and Retrieval Concepts', 0),
(83, 'Computer and Network Security', 0),
(84, 'Database Administration', 0),
(85, 'IT Automation', 0),
(86, 'Data Communications', 0),
(87, 'Advanced Network Management', 0),
(88, 'Data Communications', 0),
(89, 'Competitive Programming and Problem Solving', 0),
(90, 'Introduction to Parallel Computing', 0),
(91, 'Algorithm Techniques', 0),
(92, 'Database Management', 0),
(93, 'Principles of Programming Languages', 0),
(94, 'Advanced Unix Programming', 0),
(95, 'Operating Systems Principles', 0),
(96, 'Operating System Principles Lab', 0),
(97, 'STUDY SESSION', 0),
(98, 'Mobile Application Development', 0),
(99, 'Information Storage and Retrieval Concepts', 0),
(100, 'Principles to Computer Graphics', 0),
(101, 'Database Management', 0),
(102, 'Net-centric Computing', 0),
(103, 'Survey of Database Systems', 0),
(104, 'Database Administration', 0),
(105, 'Introduction to Data Mining', 0),
(106, 'Web Application Programming', 0),
(107, 'Component-Based Software Development', 0),
(108, 'Website Construction and Management', 0),
(109, 'Website Construction and Management', 0),
(110, 'Independent Study', 0),
(111, 'Research Experiences in Computer Science', 0),
(112, 'Senior Project', 0),
(113, 'Research Experience for Undergraduate Students', 0),
(114, 'Special Topics (Data Center Operations)', 0),
(115, 'Cooperative Education in Computer Science', 0),
(116, 'IT Automation', 0),
(117, 'Component-Based Software Development', 0),
(118, 'Advanced Applied Computer Networking', 0),
(119, 'IT Automation', 0),
(120, 'Introduction to Parallel Computing', 0),
(121, 'Database Administration', 0),
(122, 'Unix System Administration', 0),
(123, 'Introduction to Data Mining', 0),
(124, 'Applied Networking II', 0),
(125, 'Telecom Tech &amp; Apps', 0),
(126, 'Advanced Software Engineering', 0),
(127, 'Multimedia Systems and Applications', 0),
(128, 'Computer Systems Fundamentals', 0),
(129, 'Comp Comm Net Techs', 0),
(130, 'Telecomm Soft &amp; Meth', 0),
(131, 'Software Design', 0),
(132, 'Software Testing', 0),
(133, 'Secure Telecom Tran', 0),
(134, 'Grid Enablement of Scientific Applications', 0),
(135, 'Software and Data Modeling', 0),
(136, 'Expert Systems', 0),
(137, 'Multimedia Computer Communications', 0),
(138, 'Introduction to Bioinformatics Tools', 0),
(139, 'Micro Processing for Software Designers', 0),
(140, 'Storage Systems', 0),
(141, 'Information Assurance', 0),
(142, 'Systems Security', 0),
(143, 'Information Security and Privacy', 0),
(144, 'Introduction to Algorithms', 0),
(145, 'Theory of Computation I', 0),
(146, 'Sftwr Dvmnt Telecom', 0),
(147, 'Telecommunication Network Programming', 0),
(148, 'Information Theory', 0),
(149, 'Introduction to Bioinformatics', 0),
(150, 'Principles of Data Mining', 0),
(151, 'Introduction to Artificial Intelligence', 0),
(152, 'Introduction to Machine Learning', 0),
(153, 'Operating Systems', 0),
(154, 'Compiler Construction', 0),
(155, 'Affective Intelligent Agents', 0),
(156, 'Telecommunications Enterprise Planning and Strategy', 0),
(157, 'Virtualized Systems', 0),
(158, 'Advanced Computer Graphics', 0),
(159, 'Software and Data Modeling', 0),
(160, 'Principles of Database Management Systems', 0),
(161, 'Principles of Data Mining', 0),
(162, 'Independent Study', 0),
(163, 'Project Research', 0),
(164, 'Research Experience for Graduate Students', 0),
(165, 'Special Topics', 0),
(166, 'Cooperative Education in Computer Science', 0),
(167, 'Affective Intelligent Agents', 0),
(168, 'Introduction to Bioinformatics Tools', 0),
(169, 'Introduction to Bioinformatics', 0),
(170, 'Operating Systems', 0),
(171, 'Computer Literacy for Performing Arts Production', 0),
(172, 'PRINCIPLES OF DATABASE MANAGEMENT SYSTEMS', 0),
(173, 'Multimedia Systems &amp; Applications', 0),
(174, 'STORAGE SYSTEMS', 0),
(175, 'Cooperative Education in Computer Science', 0),
(176, 'High-Performance Grid Computing and Research Networking', 0),
(177, 'Computer Programming Concepts', 0),
(178, 'Software Verification', 0),
(179, 'Software Specification', 0),
(180, 'Simulation and Modeling', 0),
(181, 'Distributed Processing', 0),
(182, 'Advanced Topics in Concurrent and Distributed Systems', 0),
(183, 'Telecommunication Network Analysis and Design', 0),
(184, 'Advanced Network Algorithms', 0),
(185, 'Optical Networks', 0),
(186, 'Internetworking', 0),
(187, 'Mble &amp; Wrlss Netwks', 0),
(188, 'Mobile Computing', 0),
(189, 'Analysis of Algorithms', 0),
(190, 'Modeling and Performance Evaluation of Telecommunication Networks', 0),
(191, 'Theory of Computation II', 0),
(192, 'Networks Management and Control Standards', 0),
(193, 'Wireless Information Systems', 0),
(194, 'Distributed Processing', 0),
(195, 'Advanced Topics in Concurrent and Distributed Systems', 0),
(196, 'Advanced Database Management', 0),
(197, 'Semantics of Programming Languages', 0),
(198, 'Advanced Operating Systems', 0),
(199, 'Special Topics - Advanced Topics in Software Engineering', 0),
(200, 'Advanced Database Systems', 0),
(201, 'Advanced Topics in Information Retrieval', 0),
(202, 'Advanced Topics in Data Mining', 0),
(203, 'Special Topics on Databases', 0),
(204, 'Industrial Development of Telecommunications', 0),
(205, 'Programming for the web', 0),
(206, 'Telecommunications Public Policy Development and Standards', 0),
(207, 'Independent Study', 0),
(208, 'Special Topics - Advanced Topics in Theory', 0),
(209, 'Advanced Special Topics', 0),
(210, 'Special Topics - Advanced Topics in Information Processing', 0),
(211, 'Topics in Cognitive Science', 0),
(212, 'Computer Science Seminar', 0),
(213, 'Graduate Seminar', 0),
(214, 'Topics in Algorithms', 0),
(215, 'Special Topics - Advanced Topics in Computer Architecture', 0),
(216, 'Thesis', 0),
(217, 'Bioinformatics Tools', 0),
(218, 'Advanced Topics in Information Retrieval', 0),
(219, 'Advanced Topics in Data Mining', 0),
(220, 'Graduate Research', 0),
(221, 'Ph.D. Dissertation', 0),
(222, 'Calculus I', 0),
(223, 'Calculus II', 0),
(224, 'Physics with Calculus I w/Lab', 0),
(225, 'Physics with Calculus II w/Lab', 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_coursePrefix`
--

CREATE TABLE IF NOT EXISTS `curr_coursePrefix` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `school_id` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`),
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `curr_coursePrefix`
--

INSERT INTO `curr_coursePrefix` (`id`, `name`, `school_id`, `catalog_id`) VALUES
(1, 'CAP', 0, 1),
(2, 'CDA', 0, 1),
(3, 'CEN', 0, 1),
(4, 'CGS', 0, 1),
(5, 'CIS', 0, 1),
(6, 'CNT', 0, 1),
(7, 'COP', 0, 1),
(8, 'COT', 0, 1),
(9, 'CTS', 0, 1),
(10, 'MAP', 0, 1),
(11, 'TCN', 0, 1),
(12, 'MAC', 0, 1),
(13, 'PHY', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `curr_course_department`
--

CREATE TABLE IF NOT EXISTS `curr_course_department` (
  `id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `department_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id` (`course_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curr_department`
--

CREATE TABLE IF NOT EXISTS `curr_department` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curr_dgu`
--

CREATE TABLE IF NOT EXISTS `curr_dgu` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `lastActivated_catalogId` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `curr_dgu`
--

INSERT INTO `curr_dgu` (`id`, `name`, `lastActivated_catalogId`, `catalog_id`) VALUES
(1, 'School of Computing & Information Sciences', 0, 0),
(2, 'Engineering & Computing', 0, 0),
(3, 'Arts and Sciences', 0, 0),
(18, 'School of Business', 0, 0),
(19, 'name9', 0, 0),
(21, 'Culinary Arts', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_group`
--

CREATE TABLE IF NOT EXISTS `curr_group` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `curr_group`
--

INSERT INTO `curr_group` (`id`, `name`, `catalog_id`) VALUES
(1, 'CS Prerequisites', 0),
(2, 'CS Core Courses', 0),
(3, 'CS Elective ', 0),
(4, 'SDD Prerequisite', 0),
(5, 'SDD Core Course', 0),
(6, 'SDD Elective Courses', 0),
(7, 'IT Prerequisites', 0),
(8, 'IT Core Courses', 0),
(9, 'IT Elective', 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_group_set`
--

CREATE TABLE IF NOT EXISTS `curr_group_set` (
  `id` int(10) NOT NULL auto_increment,
  `group_id` int(10) NOT NULL,
  `set_id` int(10) NOT NULL,
  `required` bit(1) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `group_id` (`group_id`),
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `curr_group_set`
--

INSERT INTO `curr_group_set` (`id`, `group_id`, `set_id`, `required`, `catalog_id`) VALUES
(1, 1, 1, '\0', 0),
(2, 2, 2, '\0', 0),
(3, 3, 3, '\0', 0),
(4, 3, 4, '\0', 0),
(5, 4, 5, '\0', 0),
(6, 5, 6, '\0', 0),
(7, 6, 7, '\0', 0),
(8, 7, 8, '\0', 0),
(9, 7, 9, '\0', 0),
(10, 7, 10, '\0', 0),
(11, 8, 11, '\0', 0),
(12, 8, 12, '\0', 0),
(13, 8, 13, '\0', 0),
(14, 9, 14, '\0', 0),
(15, 9, 15, '\0', 0),
(16, 9, 16, '\0', 0),
(17, 9, 17, '\0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_major`
--

CREATE TABLE IF NOT EXISTS `curr_major` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `lastActivated_catalogId` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `curr_major`
--

INSERT INTO `curr_major` (`id`, `name`, `lastActivated_catalogId`, `catalog_id`) VALUES
(1, 'BS in Computer Science', 1, 0),
(2, 'BS in Information Technology', 1, 0),
(3, 'Minor in Computer Science', 1, 0),
(4, 'English', 0, 0),
(5, 'Mathematics', 0, 0),
(6, 'Engineering Science (minor)', 0, 0),
(7, 'BA in Information Technology', 0, 0),
(8, 'BS in Computer Engineering', 0, 0),
(9, 'BS in Electrical Engineering', 0, 0),
(10, 'BS in Mechanical Engineering', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_majorType`
--

CREATE TABLE IF NOT EXISTS `curr_majorType` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `curr_majorType`
--

INSERT INTO `curr_majorType` (`id`, `name`, `catalog_id`) VALUES
(1, 'Bachelors of Science', 0),
(2, 'Bachelors of Arts', 0),
(3, 'Masters of Science', 0),
(4, 'Minor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_major_track`
--

CREATE TABLE IF NOT EXISTS `curr_major_track` (
  `id` int(10) NOT NULL auto_increment,
  `major_id` int(10) NOT NULL,
  `track_id` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `major_id` (`major_id`),
  KEY `track_id` (`track_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `curr_major_track`
--

INSERT INTO `curr_major_track` (`id`, `major_id`, `track_id`, `catalog_id`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 2, 3, 0),
(4, 2, 4, 0),
(5, 1, 4, 0),
(6, 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_requisite`
--

CREATE TABLE IF NOT EXISTS `curr_requisite` (
  `id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `requisite_id` int(10) NOT NULL,
  `level` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id` (`course_id`),
  KEY `requisite_id` (`requisite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `curr_set`
--

CREATE TABLE IF NOT EXISTS `curr_set` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `curr_set`
--

INSERT INTO `curr_set` (`id`, `name`, `catalog_id`) VALUES
(1, 'CS Prerequisite Set 1', 0),
(2, 'CS Core Set 2', 0),
(3, 'CS Elective 1', 0),
(4, 'CS Elective 2', 0),
(5, 'SDD Prerequisite Set 1', 0),
(6, 'SDD Core Set 2', 0),
(7, 'SDD Elective Set 1', 0),
(8, 'IT Prerequisites Set 1', 0),
(9, 'IT Prerequisite Set 2', 0),
(10, 'IT Prerequisite Set 3', 0),
(11, 'IT Core Set 1', 0),
(12, 'IT Core Set 2', 0),
(13, 'IT Core Set 3', 0),
(14, 'IT Elective Set 1', 0),
(15, 'IT Elective Set 2', 0),
(16, 'IT Elective Set 3', 0),
(17, 'IT Elective Set 4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_set_course`
--

CREATE TABLE IF NOT EXISTS `curr_set_course` (
  `id` int(10) NOT NULL auto_increment,
  `set_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `set_id` (`set_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `curr_set_course`
--

INSERT INTO `curr_set_course` (`id`, `set_id`, `course_id`, `catalog_id`) VALUES
(1, 1, 7, 0),
(2, 2, 31, 0),
(3, 2, 71, 0),
(4, 2, 65, 0),
(5, 2, 2, 0),
(6, 2, 29, 0),
(7, 2, 30, 0),
(8, 2, 102, 0),
(9, 2, 34, 0),
(10, 2, 44, 0),
(11, 2, 77, 0),
(12, 2, 93, 0),
(13, 2, 95, 0),
(14, 2, 101, 0),
(15, 2, 41, 0),
(16, 3, 64, 0),
(17, 3, 83, 0),
(18, 3, 72, 0),
(19, 3, 73, 0),
(20, 3, 88, 0),
(21, 3, 100, 0),
(22, 5, 7, 0),
(23, 6, 31, 0),
(24, 6, 71, 0),
(25, 6, 65, 0),
(26, 6, 2, 0),
(27, 6, 29, 0),
(28, 6, 30, 0),
(29, 6, 102, 0),
(30, 6, 34, 0),
(31, 6, 44, 0),
(32, 6, 77, 0),
(33, 6, 93, 0),
(34, 6, 95, 0),
(35, 6, 101, 0),
(36, 6, 41, 0),
(37, 7, 64, 0),
(38, 7, 83, 0),
(39, 7, 72, 0),
(40, 7, 73, 0),
(41, 7, 88, 0),
(42, 7, 100, 0),
(43, 7, 64, 0),
(44, 7, 83, 0),
(45, 7, 72, 0),
(46, 7, 73, 0),
(47, 7, 88, 0),
(48, 7, 100, 0),
(49, 5, 222, 0),
(50, 5, 223, 0),
(51, 5, 224, 0),
(52, 5, 225, 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_track`
--

CREATE TABLE IF NOT EXISTS `curr_track` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `curr_track`
--

INSERT INTO `curr_track` (`id`, `name`, `catalog_id`) VALUES
(1, 'Computer Science', 0),
(2, 'Software Design and Development', 0),
(3, 'Information Technology', 0),
(4, 'Software Major', 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_track_group`
--

CREATE TABLE IF NOT EXISTS `curr_track_group` (
  `id` int(10) NOT NULL auto_increment,
  `track_id` int(10) NOT NULL,
  `group_id` int(10) NOT NULL,
  `required` bit(1) default NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `track_id` (`track_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `curr_track_group`
--

INSERT INTO `curr_track_group` (`id`, `track_id`, `group_id`, `required`, `catalog_id`) VALUES
(1, 1, 1, NULL, 0),
(2, 1, 2, NULL, 0),
(3, 1, 3, NULL, 0),
(4, 2, 4, NULL, 0),
(5, 2, 5, NULL, 0),
(6, 2, 6, NULL, 0),
(7, 1, 4, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `his_course`
--

CREATE TABLE IF NOT EXISTS `his_course` (
  `id` int(10) NOT NULL auto_increment,
  `coursePrefix_id` int(10) NOT NULL,
  `number` int(10) NOT NULL,
  `abstract` varchar(255) default NULL,
  `credits` int(1) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `coursePrefix_id` (`coursePrefix_id`),
  KEY `catalog_id` (`catalog_id`),
  KEY `identifier_id` (`identifier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=227 ;

--
-- Dumping data for table `his_course`
--

INSERT INTO `his_course` (`id`, `coursePrefix_id`, `number`, `abstract`, `credits`, `notes`, `catalog_id`, `identifier_id`) VALUES
(1, 7, 1000, 'Uses graphics and animation in a media programming environment to engage students with no programming experience. Students develop problem solving skills and learn fundamental programming concepts.', 3, '', 0, 1),
(2, 4, 1920, 'Overview of the computing field to students, research programs and career options.', 1, 'Be familiar with the scope of degree programs in the computing field. Master the overview of Computer Science program. Be exposed to research opportunities.', 0, 2),
(3, 4, 2060, 'A hands-on study of microcomputer software packages for applications such as operating system, word processing, spreadsheets, and database management. For students without a technical background.', 3, 'Not acceptable for credit to Computer Science majors.', 0, 3),
(4, 4, 2060, '...', 0, '', 0, 4),
(5, 4, 2100, 'A hands-on study of spreadsheet and database management package for business students without a technical background.', 3, 'Not acceptable for credit to Computer Science majors.', 0, 5),
(6, 4, 2100, '', 0, '', 0, 6),
(7, 7, 2210, 'A first course in computer science that uses a structured programming language to study programming and problem solving on the computer. Includes the design, construction and analysis of programs. Student participation in a closed instructional lab is req', 4, 'This course has been renumbered temporarily to the following:&lt;BR&gt;&lt;BR&gt;COP 2994/COP 2994L for Spring 2002semester&lt;BR&gt;COP 2996/COP 2996L for Summer 2002 semester(s)&lt;BR&gt;', 0, 7),
(8, 7, 2210, '', 0, 'This course has been renumbered temporarily to the following:<br />\r\n<br />\r\nCOP 2994L for Spring 2002 semester<br />\r\nCOP 2996L for Summer 2002 semester(s)', 0, 8),
(9, 7, 2210, '', 0, '', 0, 9),
(10, 7, 2250, 'A first course in Programming for IT majors. Syntax and semantics of Java. Classes and Objects. Object Oriented program development. Not acceptable for credit for Computer Science majors.', 3, 'Will satify MIS programming language requirement.', 0, 10),
(11, 7, 2250, '', 0, '', 0, 11),
(12, 7, 2270, 'A first course in programming geared for engineering and natural science students that describes the ANSI C programming language. Includes developing algorithms and writing code for problems in engineering and science.', 0, 'Previously CGS 2423. Not acceptable for credit to Computer Science majors.', 0, 12),
(13, 3, 2300, 'A two part course covering Introduction to Networking and the Windows NT Operating System. This course will cover material that is covered on the Microsoft Certified Systems Engineer (MCSE) exam.', 3, '', 0, 13),
(14, 4, 2423, 'A first course in programming geared for engineering and natural science students that describes the ANSI C programming language. Includes developing algorithms and writing code for problems in engineering and science.', 3, 'Not acceptable for credit to Computer Science majors.', 0, 14),
(15, 4, 2518, 'A hands-on study of how to use a modern spreadsheet program to analyze data, including how to perform queries, summarize data, and solve equations. For non-technical students. Not acceptable for CS majors.', 3, '', 0, 15),
(16, 4, 2518, '', 0, '', 0, 16),
(17, 7, 2800, 'An introductory level course in programming using the Java Programming Language.<br />\r\nTopics include primitive types, control structures, classes and objects, strings, arrays, Applets and GUI components.<br />\r\nNot acceptable for credit for Computer Sci', 3, 'Will satisfy the MIS language requirement.', 0, 17),
(18, 4, 2990, 'A hands-on study of how to use a modern spreadsheet program to analyze data, including how to perform queries, summarize data, and solve equations. For non-technical students. Not acceptable for CS majors.', 3, 'Experimental number for Spring 2004.', 0, 18),
(19, 7, 2990, 'This Lab is in conjunction with COP 2210', 1, '', 0, 19),
(20, 4, 2990, 'A hands-on study of how to use a modern spreadsheet program to analyze data, including how to perform queries, summarize data, and solve equations. For non-technical students. Not acceptable for CS majors.', 0, 'Experimental number for Spring 2004.', 0, 20),
(21, 7, 2991, 'An introductory course in the Object oriented language Java.<br />\r\n', 3, 'Experimental course for Fall 2001. This course will satisify the programming requirement for MIS majors.<br />\r\nSame course as COP 2250', 0, 21),
(22, 7, 2993, 'An introductory  level course in programming using the Java programming language. <br />\r\nTopics include primitive types, control structures, classes and projects, strings, arrays, Applets and GUI components.', 3, 'Experimental course Spring 2002. Not acceptable for credit for CS majors. Will satisfy MIS language requirement.<br />\r\nSame as COP 2250', 0, 22),
(23, 7, 2993, '', 1, '', 0, 23),
(24, 7, 2994, 'A first course in computer science that uses a structured programming language<br />\r\nto study programming and problem solving on the computer. Includes the design, construction and analysis of programs.<br />\r\nStudent participation in a closed instructio', 4, 'SAME COURSE AS COP 2210.<br />\r\nExperimental course for Spring 2002.', 0, 24),
(25, 7, 2994, '', 0, '', 0, 25),
(26, 7, 2996, 'A first course in computer science that uses a structured programming language to study<br />\r\n                                      programming and problem solving on the computer. Includes the design, construction and<br />\r\n                            ', 4, 'Experimental course for Summer 2002. Same as COP 2210', 0, 26),
(27, 7, 2996, 'The Lab course that goes along with COP 2210.', 0, '', 0, 27),
(28, 2, 3003, 'A study of the hardware components of modern microcomputers and their organization. Evaluation and comparison of the various microcomputer systems. Not acceptable for credit for Computer Science majors.', 0, 'Previously COP 3643.', 0, 28),
(29, 4, 3092, 'Ethical, legal and social issues and the responsibility of computer professionals. Codes of conduct, risks and reliability, responsibility, liability, privacy, security and free speech issues.', 1, '', 0, 29),
(30, 4, 3095, '', 3, 'Legal, ethical, social impacts of computer technology on society,\r\ngovernance, quality of life: intellectual property, privacy, anonymity,\r\nprofessionalism, social identity in the U.S. and globally.', 0, 30),
(31, 2, 3103, 'Overview of the computer systems organization. Data representation. Machine and assembly language programming.', 0, 'Previously COP 3402. ', 0, 31),
(32, 7, 3175, 'An introduction to Visual Basic Programming with emphasis on Business Applications.', 3, 'Not acceptable for credit for Computer Science majors.', 0, 32),
(33, 4, 3260, 'A study of the hardware components of modern microcomputers and their organization. Evaluation and comparison of the various microcomputer systems. Not acceptable for credit for Computer Science majors.', 3, '', 0, 33),
(34, 7, 3337, 'An intermediate level course in Object-Oriented programming. Topics include primitive types, control structures, strings, arrays, objects and classes, data abstraction inheritance polymorphism and an introduction to data structures.', 3, '', 0, 34),
(35, 7, 3338, 'Advanced programming concepts including object-oriented programming. Topics include inheritance and polymorphism in the C++ programming language and programming in a pure object-oriented language such as Java.', 3, 'Discontinued Fall 2001, new course is COP 4338', 0, 35),
(36, 7, 3344, 'Techniques of Unix/Linux systems. Basic use, file system structure, process system structure, unix tools (regular expressions, grep, find), simple and complex shell usage, shell scripts, Xwindows. Not acceptable for credit for Computer Science majors.', 3, '', 0, 36),
(37, 7, 3348, 'Techniques of Unix/Linux systems. Basic use, file system structure, process system structure, unix tools (regular expressions, grep, find), simple and complex shell usage, shell scripts, Xwindows. Not acceptable for credit for Computer Science majors.', 3, 'OLD COURSE COP 3344.<br />All changes from this field review will be effective beginning August 1, 2008.', 0, 37),
(38, 7, 3353, 'Techniques of Unix/Linux systems. Basic use, file system structure, process system structure, unix tools (regular expressions, grep, find), simple and complex shell usage, shell scripts, Xwindows. Not acceptable for credit for Computer Science majors.', 0, 'Previously COP 3348. ', 0, 38),
(39, 7, 3402, 'Overview of the computer systems organization. Data representation. Machine and assembly language programming.', 3, '', 0, 39),
(40, 4, 3416, 'A programming course in Java with emphasis on web-based applications;Applets; Components; Servlets; Java Beans. Not acceptable for credit for Computer Science majors.', 3, 'OLD COURSE WAS CGS 3425.<br />\r\nAll changes from this field review will be effective beginning August 1, 2008', 0, 40),
(41, 8, 3420, 'An introduction to the logical concepts and computational aspects of propositional and predicate logic, as well as to concepts and techniques underlying logic programming, in particular, the computer language Prolog.', 3, '', 0, 41),
(42, 4, 3425, 'A programming course in Java with emphasis on web-based applications;Applets; Components; Servlets; Java Beans. Not acceptable for credit for Computer Science majors.', 3, '', 0, 42),
(43, 7, 3465, 'Basic concepts of running time of a program, data structures including lists, stacks, queues, binary search trees, hash tables, and internal sorting.<br />\r\nNot acceptable for credit for CS majors.<br />\r\n<br />\r\n<br />\r\n<br />\r\n', 3, '', 0, 43),
(44, 7, 3530, 'Basic concepts of data organization, running time of a program, abstract types, data structures including linked lists, n-ary trees, sets and graphs, internal sorting.', 3, '', 0, 44),
(45, 4, 3559, 'Internet history and importance. What is available on the Net. Tools such as email, listserves, telnet, ftp, Archie, Veronica, Gopher, netfind, the World Wide Web, Wais, and Mosaic.', 1, 'Nontechnical.', 0, 45),
(46, 7, 3643, 'A study of the hardware components of modern microcomputers and their organization. Evaluation and comparison of the various microcomputer systems. Not acceptable for credit for Computer Science majors.', 3, 'OLD COURSE CGS 3260.<br /> All changes from this field review will be effective beginning August 1, 2008.', 0, 46),
(47, 4, 3643, 'A study of the hardware components of modern microcomputers and their organization. Evaluation and comparison of the various microcomputer systems. Not acceptable for credit for Computer Science majors.', 3, 'OLD COURSE CGS 3260.', 0, 47),
(48, 3, 3721, 'Fundamental concepts of human-computer interaction, cognitive models, user-centered design principles and evaluation, emerging technologies.', 3, '', 0, 48),
(49, 4, 3760, 'Introduction to fundamental concepts of operating systems and their implementation in UNIX, Windows NT and Windows 95/98. Not acceptable for credit for Computer Science majors.', 3, '', 0, 49),
(50, 4, 3767, 'Introduction to fundamental concepts of operating systems and their implementation in UNIX and Windows.&lt;br /&gt;Not acceptable for credit for Computer Science majors.', 3, 'OLD COURSE CGS 3760.&lt;br /&gt;All changes from this field review will be effective beginning August 1, 2008', 0, 50),
(51, 7, 3804, 'A second course in programming.  Continues Programming in Java by discussing object-oriented programming in more detail, with larger programming projects and emphasis on inheritence. Not acceptable for credit for CS majors.', 3, 'This course was offered before as COP 399X.', 0, 51),
(52, 7, 3832, 'Maintain a web server on the Internet. Learn HTML, PERL, and JavaScript. Configure the Apache web server. Write interactive server scripts. Discuss Web security &amp; ASP. Use Java applets &amp; ActiveX controls.', 3, '', 0, 52),
(53, 7, 3835, 'Designing basic pages for display on the World Wide Web. Fundamental<br />\r\ndesign elements and contemporary design tools are discussed. Computer literacy is expected.<br />\r\n<br />\r\n<br />\r\n', 3, 'also offered as CGS 399X.', 0, 53),
(54, 5, 3900, 'Individual conferences, assigned readings, and reports on independent investigations.', 1, '', 0, 54),
(55, 5, 3930, 'A course designed to give groups of students an opportunity to pursue special studies not otherwise offered.', 1, '', 0, 55),
(56, 7, 3949, 'One semester of full-time work, or equi valent, in an outside organization, limited to students admitted to the CO-OP program. A written report and supervisor evaluation is required of each student.', 1, '', 0, 56),
(57, 4, 3990, 'Intended to introduce students to the fundamentals of designing basic pages for display on the<br />\r\n                                      WWW. The fundametal design elements on the web will be discussed as well as contemporary<br />\r\n                   ', 3, 'Not acceptable for credit for Computer Science majors.<br />\r\nEffective summer 2002 the course number for Designing Web Pages is COP 3835', 0, 57),
(58, 7, 3990, 'A second course in Java programming. Continues Programming in Java by discussing object-oriented programming in  more detail, with larger programming projects and emphasis on inheritance. Not acceptable for credit for CS majors.', 3, 'Experimental course for Fall 2002.', 0, 58),
(59, 4, 3993, 'Intended to introduce students to the fundamentals of designing basic pages<br />\r\nfor display on the WWW. The fundametal design elements on the web will be discussed as well as contemporary <br />\r\ntools to aid in the design of web pages.', 3, 'Effective Summer 2002 the course number for Designing Web Pages is COP 3835. ', 0, 59),
(60, 7, 3993, 'A second course in programming for IT majors. Continues programming I (IT) by discussing<br />\r\nobject-oriented programming in a more detail, with larger programming projects and emphasis on inheritance. <br />\r\n', 3, 'Not acceptable for credit for CS majors.<br />\r\nExperimental course for Spring 2002. Will satisfy MIS language requirement.', 0, 60),
(61, 1, 3993, 'Students will learn the fundamental concepts of human-computer interaction and user-centered design thinking. Students will also become familiar with novel approaches relating to recent human computer interaction. ', 3, '', 0, 61),
(62, 4, 3996, 'Intended to introduce students to the fundamentals of designing basic pages for display on the<br />\r\n                                      WWW. The fundametal design elements on the web will be discussed as well as contemporary<br />\r\n                   ', 3, 'Not acceptable for credit for Computer Science majors.<br />\r\nEffective Summer 2002 the course number for Designing Web Pages is COP 3835. ', 0, 62),
(63, 7, 4005, 'Application development techniques in Windows: Classes, Objects, Controls, Forms, and Dialogs, Database, and Multi-tier Application Architecture. Students CANNOT receive credit for both COP 4005 and COP 4226', 3, 'The second half of COP 4005 requires the exposure to database concepts that will be taught in the first half of CGS 4366.', 0, 63),
(64, 7, 4009, 'Component-Based and Distributed Programming Techniques: C#, Common Type System, Windows and Web Forms, Multithreading, Distributed Objects.', 3, 'Offered as COP 4991 FALL 2002', 0, 64),
(65, 3, 4010, 'Software Process Model, software analysis and specification, software design, testing.', 3, '', 0, 65),
(66, 3, 4012, 'Students design, implement, document, and test software systems working in faculty supervised projects teams <br />\r\nin faculty supervised project teams and utilizing knowledge obtained in previous courses. Required for Software Design<br />\r\nand Developm', 3, 'OLD COURSE CEN 4015.<br />\r\nAll changes from this field review will be effective beginning August 1, 2008', 0, 66),
(67, 3, 4015, 'Students design, implement, document, and test software systems working in faculty supervised projects teams <br />\r\nin faculty supervised project teams and utilizing knowledge obtained in previous courses. Required for Software Design<br />\r\nand Developm', 3, 'Required for SDD Track only', 0, 67),
(68, 3, 4021, 'Issues underlying the successful development of large scale software projects;&lt;br /&gt;Software Architectures;&lt;br /&gt;Software Planning and Management; Team Structure;&lt;br /&gt;Cost Estimation.', 3, 'Required for SDD Track&lt;br /&gt;This course counts as a &amp;#34;Set 1 Elective&amp;#34; for CS majors.', 0, 68),
(69, 3, 4023, 'Concept of software components, component models and web services such as WSDL and SOAP.', 3, '', 0, 69),
(70, 3, 4072, 'Fundamentals of software testing. Topics include: test plan creation, test case generation, program inspections, specification-based and implementation-based testing, GUI testing, and testing tools.', 3, '', 0, 70),
(71, 2, 4101, 'Covers the levels of organization in a computer. Design of memory, buses, ALU, CPU; design of microprogram. Covers virtual memory, I/O, multiple processes, CISC, RISC and parallel architectures.', 3, '', 0, 71),
(72, 7, 4225, 'Overview: files and directories, shell scripting and systems programming; Unix tools; Unix internals; file systems, process structure. Using the system call interface. Interprocess communication.', 3, '', 0, 72),
(73, 7, 4226, 'Advanced Windows Programming topics including Object Linking and Embedding (OLE), Open Database Connectivity (ODBC), Memory Management Techniques, Dynamic Link Libraries, Multithreaded Programming and Client/Server Applications.', 3, '', 0, 73),
(74, 4, 4254, 'Principles of computer network design, operation and management, Network Protocols. Network configuration. Network security.<br />\r\nNot acceptable for credit for Computer Science majors.', 3, 'OLD COURSE CGS 4283, then 4285.<br />\r\nAll changes from this field review will be effective beginning August 1, 2008.', 0, 74),
(75, 4, 4283, 'Principles of computer network design, operation and management, Network Protocols. Network configuration. Network security.<br />\r\nNot acceptable for credit for Computer Science majors.', 3, '', 0, 75),
(76, 4, 4285, 'Principles of computer network design, operation and management, Network Protocols. Network configuration. Network security. Not acceptable for credit for Computer Science majors.', 3, '', 0, 76),
(77, 7, 4338, 'Topics include Object-Oriented programming, Advanced Programming Concepts and Modern Programming Techniques.', 3, 'Old course was COP 3338.', 0, 77),
(78, 7, 4343, 'Techniques of Unix System administration: system configuration and management; network setup, configuration and management.', 3, 'Experimental course in Summer 2004 was COP 4996. To introduce IT stundents to the advanced concepts of system administration.', 0, 78),
(79, 9, 4348, 'Techniques of Unix System administration: system configuration and management; network setup, configuration and management.', 3, 'This new prefix will replace prefix COP 4343 beginning Fall 2009.', 0, 79),
(80, 5, 4363, 'Technical study of issues and solutions for computer and network security and privacy.  The security problem, encryption and decryption, public key encryption, authentication, operating system security, program security.', 3, 'Also offered as COP 4995 Spring 2003 &amp; COP 4993 Spring 2004.', 0, 80),
(81, 4, 4365, 'Introduction to knowledge-based and expert systems. Knowledge acquisition, knowledge representation, and creation of expert system.<br />\r\nNot acceptable for credit for Computer Science majors.', 3, 'Undergraduate majors in the IT Degree Program.', 0, 81),
(82, 4, 4366, 'Introduction to information management and retrieval concepts. The design and implementation of a relational database using a commercial DBMS. Online information retrieval and manipulation. Not acceptable for credit for Computer Science majors.', 3, 'Undergraduate Majors in the IT Degree Program.', 0, 82),
(83, 6, 4403, 'Fundamental concepts and principles of computing and network security, symmetric and asymmetric cryptography, hash functions, authentication, firewalls and intrusion detection, and operational issues.', 3, 'This course is only required for IT majors who declared their major after the Summer 2010 semester.', 0, 83),
(84, 9, 4408, 'Client-Server architecture; planning, installation, server configuration; user management; performance optimization; backup, restoration; security configuration; replication management; administrative tasks.', 0, 'Previously COP 4723.', 0, 84),
(85, 5, 4431, 'IT automation: mgmt models, auditing, assets, change mgmt, network monitoring, OS imaging, patch mgmt, help desk, remote control, user state mgmt, end-point security, backup, disaster recovery.', 3, 'Experimental course for FALL 2009 (COP 4990) &amp; SPRING 2009 (COP 4993).<br />\r\n', 0, 85),
(86, 3, 4500, 'Study Computer network models and protocol layers. Topics include error handling, frames, broadcast networks, channel allocation; network routing algorithms, internetworking, TCP/IP, and ATM protocols.', 3, '', 0, 86),
(87, 6, 4504, 'Advanced principles of modern internetworking network design and implementation. Hands on experience with routers and switches and core Internet support protocols.', 3, '', 0, 87),
(88, 6, 4513, 'STUDY COMPUTER NETWORK MODELS AND PROTOCOL LAYERS. TOPICS INCLUDE: ERROR HANDLING, FRAMES, BROADCAST NETWORKS, CHANNEL ALLOCATION; NETWORK ROUTING ALGORITHMS, INTERNETWORKING, TCP/IP, ATM PROTOCOLS.', 3, 'Used to be CEN 4500', 0, 88),
(89, 7, 4516, 'Problem solving for programming competitions. Algorithms, analysis, programming, debugging, group collaboration. Participation in team practices and rigorous individual preparation. ', 3, '', 0, 89),
(90, 7, 4520, 'This course introduces the field of parallel computing. The students will be taught how to design efficient parallel programs and how to use parallel computing techniques to solve scientific problems.', 3, '', 0, 90),
(91, 7, 4534, 'Basic algorithm design, including greedy algorithms, divide-and-conquer, dynamic programming, randomization, and backtracking. Graph, string, numerical, geometric, and optimization algorithms.', 3, '', 0, 91),
(92, 7, 4540, 'Logical aspects of databases. Topics include Semantic Binary, Relational, Network, and Hierarchical Models, E-R Model, Database design; SQL; Physical Database Organization; Deductive or Rule - based Databases; Fourth - Generational Language.', 3, '', 0, 92),
(93, 7, 4555, 'A comparitave study of several programming languages and paradigms. Emphasis is given to design, evaluation and implementation. Programs are written in a few of the languages.', 3, 'Old prerequisite was COP 3337. New prerequisite as of Spring 2004 is COP 3530', 0, 93),
(94, 7, 4604, 'Overview: files and directories, shell scripting and systems programming; Unix tools; Unix internals; file systems, process structure. Using the system call interface. Interprocess communication.', 0, 'Previously COP 4225.', 0, 94),
(95, 7, 4610, 'Operating systems design principles and implementation techniques. Address spaces, system call interface, processes / threads, interprocess communication, deadlock, scheduling, memory, virtual memory, I/O, file systems.', 3, '', 0, 95),
(96, 7, 4610, '', 0, '', 0, 96),
(97, 7, 4610, '', 0, '', 0, 97),
(98, 7, 4655, 'Design and development of mobile applications. Introduction to the mobile application frameworks, including user interface, sensors, event handling, data management and network interface.', 3, '', 0, 98),
(99, 7, 4703, 'Introduction to information management and retrieval concepts. The design and implementation of a relational database using a commercial DBMS. Online information retrieval and manipulation. Not acceptable for credit for Computer Science majors.', 3, 'Previously CGS 4366. Undergraduate Majors in the IT Degree Program.', 0, 99),
(100, 1, 4710, 'A first course in algorithms and techniques for computer image generation; display devices, geometric transformations and their matrix representations, coordinate systems, scan conservation, clipping, anti-aliasing, 3D view generation, color, hidden surfa', 3, '', 0, 100),
(101, 7, 4710, 'Logical aspects of databases. Topics include Semantic Binary, Relational, Network, and Hierarchical Models, E-R Model, Database design; SQL; Physical Database Organization; Deductive or Rule - based Databases; Fourth - Generational Language.', 0, 'Previously COP 4540.', 0, 101),
(102, 6, 4713, 'Fundamental concepts and principles of computing and network security, \r\nsymmetric and asymmetric cryptography, hash functions, authentication, \r\nfirewalls and intrusion detection, and operational issues.\r\n', 3, '', 0, 102),
(103, 7, 4722, 'Desing and management of enterprise systems; concurrency techniques; distributed, object-oriented, spatial, and multimedia databases; database integration; datawarehousing and datamining; OLAP; XML interchange.', 3, '', 0, 103),
(104, 7, 4723, 'Client-Server architecture; planning, installation, server configuration; user management; performance optimization; backup, restoration; security configuration; replication management; administrative tasks.', 3, 'This course&#39;s Experimental number in Summer 2004 was CGS 4996.', 0, 104),
(105, 1, 4770, 'Data mining applications, data preparation, data reduction and various data mining techniques such as association, clustering, classification, anomaly detection.', 3, 'The goal of this course is to develop an understanding of the fundamental principles of data mining, and then apply these concepts to real data, thus gaining a working knowledge of data mining techniques.', 0, 105),
(106, 7, 4813, 'Designing and implementing web applications, using classes. Web controls, state management, user authentication, SMTP EMAIL, custom error handling, and database objects. Includes creating database-driven web sites, creating and consuming web servers.', 3, '', 0, 106),
(107, 7, 4814, 'Concept of software components, component models and web services such as WSDL and SOAP.', 3, 'Previously CEN 4023.', 0, 107),
(108, 4, 4825, 'The fundamentals of creating and maintaining a website. Installation and maintenance of a web-server. Techniques for building multimedia interactive web-pages. ', 3, 'This course is equivalent to COP 3832. ', 0, 108),
(109, 4, 4854, 'The fundamentals of creating and maintaining a website. Installation and maintenance of a web-server. Techniques for building multimedia interactive web-pages.', 3, 'OLD COURSE CGS 4825. All changes from this field review will be effective beginning August 1, 2008.', 0, 109),
(110, 5, 4905, 'Individual conferences, assigned readings, and reports on independent investigations.', 1, '', 0, 110),
(111, 7, 4906, 'Participation in ongoing research in the research centers of the school.', 1, '', 0, 111),
(112, 5, 4911, 'Students work on faculty supervised projects in teams of up to 5 members to design and implement solutions to problems utilizing knowledge obtained across the spectrum of Computer Science courses.', 3, 'The objective of this course is to have the student use all the concepts learned in CS courses to solve a major computing problem from formulation and requirements.', 0, 112),
(113, 5, 4912, 'Participation in ongoing research in the research centers of the school. ', 0, '', 0, 113),
(114, 5, 4930, 'A course designed to give groups of students an opportunity to pursue special studies not otherwise offered.', 1, '', 0, 114),
(115, 7, 4949, 'One semester of full-time work, or equivalent, in an outside organization, limited to students admitted to the CO-OP program. A written report and supervisor evaluation is required of each student.', 1, '', 0, 115),
(116, 7, 4990, 'IT automation: mgmt models, auditing, assets, change mgmt, network monitoring, OS imaging, patch mgmt, help desk, remote control, user state mgmt, end-point security, backup, disaster recovery.', 3, '', 0, 116),
(117, 7, 4991, 'Concept of software components, component models and web services such as WSDL and SOAP.', 3, '', 0, 117),
(118, 4, 4993, 'Advanced topics in applied computer networking., Advanced Ethernet, Advanced TCP/IP, Router configuration, Applied network support processes, Metering and monitoring, security and firewalls.', 3, 'CGS 4990 was the Experimental course number for  Fall 2005. ', 0, 118),
(119, 7, 4993, 'IT automation: mgmt models, auditing, assets, change mgmt, network monitoring, OS imaging, patch mgmt, help desk, remote control, user state mgmt, end-point security, backup, disaster recovery.', 3, 'Experimental course number for Spring 2009.<br />\r\n<br />\r\n', 0, 119),
(120, 7, 4994, 'This course introduces the field of parallel computing. The students will be taught how to design efficient parallel programs and how to use parallel computing techniques to solve scientific problems.', 3, 'Experimental course for Spring 2009.', 0, 120),
(121, 4, 4996, 'Client-Server architecture; planning, installation, server configuration; user management; performance optimization; backup, restoration; security configuration; replication management; administrative tasks.', 3, 'Experimental course for summer 2004. New course number is COP 4723.', 0, 121),
(122, 7, 4996, 'Techniques of Unix System administration: system configuration and management; network setup, configuration and management.', 3, 'Experimental course for Summer 2004. To introduce IT stundents to the advanced concepts of system administration. New course number as of Fall 2004 is COP 4343.', 0, 122),
(123, 7, 499, 'Data mining applications, data preparation, data reduction and various data mining techniques such as association, clustering, classification, anomaly detection.', 3, 'Experimental number for fall 2006', 0, 123),
(124, 4, 499, 'Advanced topics in applied computer networking., Advanced Ethernet, Advanced TCP/IP, Router configuration, Applied network support processes, Metering and monitoring, security and firewalls.', 1, 'Experimental course for Spring 2007', 0, 124),
(125, 11, 5010, 'An in-depth introduction to voice and data networks, signaling and modulation, multiplexing, frequency band and propagation characteristics, special analysis of signals, and traffic analysis.', 3, '', 0, 125),
(126, 3, 5011, 'This course deals with the design of large scale computer programs. Included are topics dealing with planning design, implementation, validation, metrics, and the management of such software projects.', 3, 'Course offered every Fall semester', 0, 126),
(127, 1, 5011, 'Course covers organization of multimedia systems, data representation, quality of service, scheduling algorithms, synchronization, and tele-communications of multimedia streams.', 3, '', 0, 127),
(128, 5, 5027, 'Fundamentals concepts of IT Systems: operating systems, networking, distributed systems, platform technologies, web services and human-computer interaction. Covers design principles, algorithms and implementation techniques.', 3, 'Graduate Students in Information Technology will learn the fundamentals of hardware, software, and network components used in typical computer-based information systems.', 0, 128),
(129, 11, 5030, 'Teaches the dynamics related to computer communications, how computers are grouped together to form networks, various networking implementation strategies, and current technologies.', 3, '', 0, 129),
(130, 11, 5060, 'A high-level look into network architectures and distributed applications, client-server models, network software platforms and advanced techniques for programs specifications through implementation.<br />\r\n', 3, '', 0, 130),
(131, 3, 5064, 'Study of object-oriented analysis and design of software systems based on the standard design language UML; case studies.', 3, '', 0, 131),
(132, 3, 5076, 'Introduce tools and techniques used to validate artifacts developed during the software development process.  Included topics are: model validation, software metrics, implementation-based testing, specification-based testing, integration testing and syste', 3, 'CEN 5992 Experimental course number for FALL 2004.', 0, 132),
(133, 11, 5080, 'elecom and information security issues such as: digital signatures, cryptography as applied to telecom transactions, network policing, nested authentication, and improving system trust.', 3, '', 0, 133),
(134, 3, 5082, 'Fundamental principles and applications of high-performance computing and parallel programming using OpenMP, MPI, Globus Toolkit, Web Services, and Grid Services.', 3, 'Students in scientific disciplines (including, but not restricted to, Physics, Computational Chemistry, Biology, and Meteorology) will learn the fundamentals of high-performance computing, parallel programming, and developing large-scale scientific applic', 0, 134),
(135, 3, 5087, 'Essential software and data modeling methods and techniques such as UML, XML, and ER. This course covers basic and advanced modeling concepts: how to model, how to manage complexity with patterns and tools.', 0, 'Previously COP 5716.', 0, 135),
(136, 3, 5120, 'Introduction to expert systems, knowledge representation techniques and construction of expert systems. A project such as the implementation of an expert system in a high level AI-language is required.', 3, 'Course offered every Spring semester', 0, 136),
(137, 11, 5150, 'Covers multimedia computer communications technologies including, multimedia over networks, videoconferencing, telephone, compression algorithms and techniques for transmitting data efficiently.', 3, '', 0, 137),
(138, 4, 5166, 'Introsuction to bioinformatics; analytical and predictive tools; practical use of tools for sequence alignments, phylogeny, visualizations, pattern discovery, gene expression analysis, and protein structure.', 2, '', 0, 138),
(139, 2, 5312, 'Design of application software for OEM pro-ducts. Topics include 16-bit micro-processor architecture and assembly language, HLLs for design of micro- processor software, software for multi-processing and multiprocessor systems.', 3, '', 0, 139),
(140, 5, 5346, 'Introduction to storage systems, storage system components, storage architecture, devices, trends and applications, performance, RAID, MEMS and portable storage, file-systems, OS storage management.', 3, 'In this class, we will examine storage systems in detail, starting from its individual components to how large scale storage systems are built. We will learn how to manage storage systems, how they relate to the rest of the computer system, and how to des', 0, 140),
(141, 5, 5372, 'Information assurance algorithms and techniques. Security vulnerabilities. Symmetric and public key encryption. Authentication and Kerberos. Key infrastructure and certificates. Mathematical foundations.', 3, 'Information security, privacy, and authentication are perennial problems on networked computers. This course will provide computer science graduate students with an opportunity to study the nature of the threats and the technical details and theoretical f', 0, 141),
(142, 5, 5373, '', 3, '', 0, 142),
(143, 5, 5374, '', 3, '', 0, 143),
(144, 8, 5407, 'Design of efficient date structures and algorithms; analysis of algorithms and asymptotic time complexity; graph, string, and geometric algorithms; NP-completeness.<br />\r\n', 3, 'COT 5993 Experimental course for Spring 2005.', 0, 144),
(145, 8, 5420, 'Mathematical models of computation; regular, context-free, recursive, and recursively enumerable languages; equivalence of models; techniques for proving non-membership of a language in a class: pumping lemmas, diagonalization, reductions.', 3, 'Course offered every Fall semester', 0, 145),
(146, 11, 5440, 'Focuses on the aspects, tools, and techniques of developing software applications for telecommunications networks.', 3, '', 0, 146),
(147, 11, 5445, 'Advancedtelecommunications network programming skills including Router and Bridge Software, socket programming and protocol handler.', 3, '', 0, 147),
(148, 11, 5455, 'Entropy and measure of information.  Proof and interpretation of Shannon&#039;s fundamental theorem for various channels, including noiseless, discrete, time-discrete and time-continous channels.', 3, '', 0, 148),
(149, 1, 5510, 'Introduction to bioinformatics; algorithmic, analytical and predictive tools and techniques; programming and visualization tools; machine learning; pattern discovery; analysis of sequence alignments, phylogeny data, gene expression data, and protein struc', 3, '', 0, 149),
(150, 7, 5577, 'Principles of data mining concepts, knowledge representation, inferring rules, statistical modeling, decision trees, association rules, classification rules, clustering, predictive models, and instance-based learning.', 3, 'COP 5992 Experimental course number for FALL 2004.', 0, 150),
(151, 1, 5602, 'Presents the basic concepts of AI and their applications to game playing, problem solving, automated reasoning, natural language processing and expert systems.', 3, 'Course offered every Fall semester', 0, 151),
(152, 1, 5610, 'Decision trees, Bayesian learning reinforcement learning as well as theoretical concepts such as inductive bias, the PAC learning, minimum description length principle.', 3, 'The goal of the course is to develop a basic understanding of the theory and practice of machine learning from a variety of perspectives.', 0, 152),
(153, 7, 5614, 'Operating systems design principles, algorithms and implementation techniques: Process and memory management, disk and I/O systems, communications and security.', 3, 'Operating Systems was offered as COP 5994 Experimental course for Spring 2005.', 0, 153),
(154, 7, 5621, 'Basic techniques of compilation; scanning; grammers and LL and LR parsing, code generation; symbol table management; optimization.', 3, 'Course offered every Spring semester', 0, 154),
(155, 1, 5627, 'Design and implementation methods using artificial intelligence (AI) techniques, human-computer interaction (HCI) principles, emotion theories; applications, e.g. health informatics, education, games.', 3, '', 0, 155),
(156, 11, 5640, 'Methodologies for re-engineering, project management, strategic planning, change management, RFPs, and life-cycle management within the telecommunications and IT arena.<br />\r\n', 3, '', 0, 156),
(157, 2, 5655, 'Topics include the concepts and principles of virtualization and the mechanisms and techniques of building virtualized systems, from individual virtual machines to virtualized networked infrastructure.', 3, '', 0, 157),
(158, 1, 5701, 'Advanced topics in computer graphics; system architecture, interactive techniques, image synthesis, current research areas.', 3, '', 0, 158),
(159, 7, 5716, 'Essential software and data modeling methods and techniques such as UML, XML, and ER. ', 3, 'This course covers basic and advanced modeling concepts: how to model, how to manage complexity with patterns and tools.', 0, 159),
(160, 7, 5725, 'Overview of Database Systems, Relational Model, Relational Algebra and Relational Calculus; SQL; Database Applications; Storage and Indexing; Query Evaluation; Transaction Management; Selected database topics will also be discussed.', 3, 'COP 5990 Experimental course number for FALL 2004.', 0, 160),
(161, 1, 5771, 'Principles of data mining concepts, knowledge representation, inferring rules, statistical modeling, decision trees, association rules, classification rules, clustering, predictive models, and instance-based learning.', 0, 'Previously COP 5577.', 0, 161),
(162, 5, 5900, 'Individual conferences, assigned readings, and reports on independent investigations.', 1, '', 0, 162),
(163, 5, 5910, 'Advanced undergraduate or master&#039;s level research for particular projects.', 1, 'Repeatable.', 0, 163),
(164, 5, 5915, 'Participation in ongoing research in the research centers of the school.', 0, '', 0, 164),
(165, 5, 5931, 'A course designed to give groups of students an opportunity to pursue special studies not otherwise offered.', 1, '', 0, 165),
(166, 7, 5949, ' One semester of full-time work or equivalent in an outside organization. Limited to students admitted to the CO-OP program. A written report and supervisor evaluation is required of each student.', 1, 'This course was offered as COP 599X in previous terms. ', 0, 166),
(167, 1, 5990, 'Affective intelligent agents emergence, their applications (e.g. health informatics, edutainment) research methods integrating emotion theories. Al techniques and HCI principles for modeling.', 3, 'Experimental course for Fall 2008', 0, 167),
(168, 4, 5991, 'Introsuction to bioinformatics; analytical and predictive tools; practical use of tools for sequence alignments, phylogeny, visualizations, pattern discovery, gene expression analysis, and protein structure.', 2, 'To introduce students to the efficient use of practical analytical tools from Bioinformatics and to teach them to interpret the results from using the tools. EXPERIMENTAL COURSE FOR FALL 2003', 0, 168),
(169, 1, 5991, 'Introduction to bioinformatics; algorithmic, analytical and predictive tools and techniques; programming and visualization tools; machine learning; pattern discovery; analysis of sequence alignments, phylogeny data, gene expression data, and protein struc', 3, 'To introduce students to the algorithmic and analytical techniques used in Bioinformatics and prepare them for research in bioinformatics. EXPERIMENTAL COURSE FOR FALL 2003', 0, 169),
(170, 7, 5991, 'Operating systems design principles, algorithms and implementation techniques: process and memory management, disk and I/O systems, communications and security.', 3, 'Experimental course number for FALL 2004.', 0, 170),
(171, 4, 5993, 'Designed to familiarize students with fundamentals of computer theory and operation using the most accepted performing computer arts platforms.', 3, '', 0, 171),
(172, 7, 5993, 'Overview of Database Systems, Relational Model, Relational Algebra and Relational Calculus; SQL; Database Applications; Storage and Indexing; Query Evaluation; Transaction Management; Selected database topics will also be discussed.', 3, 'Eperimental course for Spring 2005.', 0, 172),
(173, 5, 5993, 'Multimedia Systems and Applications (3) Course covers organization of multimedia systems, data representation, quality of service, scheduling algorithms, synchronization and tele-communication of multimedia streams.', 3, '', 0, 173),
(174, 7, 5995, 'Introduction to Storage Systems, Storage Systems components, Storage Architectures, Devices, Trends and Applications, Performace, RAID, MEMS and Portable Storage, File-systems, OS Storage Management.', 3, 'EXPERIMENTAL COURSE FOR SPRING 2005', 0, 174),
(175, 7, 5996, 'One semester of full-time work, or equivalent, in an outside organization, limited to students admitted to the CO-OP program.<br />\r\nA written report and supervisor evaluation is required of each student.', 1, '', 0, 175),
(176, 3, 5, 'Fundamental principles and applications of high-performance computing including High-Speed Networks, Clusters, Grids, Globus Toolkits, Scheduling, MPI, OpenMP, Web Services, and Grid Services.<br />\r\n', 3, 'Graduate students will learn the fundamentals of parallel programming, high-performance computing, and developing large-scale scientific applications using cluster and grid computing technologies.', 0, 176),
(177, 7, 6007, 'For non-computer science graduate students.  The concepts of object oriented programming, an introduction to an object oriented programming language, internet programming and applications of programming  to learning technologies. ', 3, 'Students will be able to use an object oriented programming language to develop learning technology tools.', 0, 177),
(178, 3, 6070, 'Study of formal verification of software systems; verification methods; verification of sequential and concurrent software systems.', 3, 'CEN 6993 Software Verification offered as Experimental course for Spring 2005.', 0, 178),
(179, 3, 6075, 'Study of formal specification in the software development process, specification methods; specification of sequential and concurrent systems.', 3, '', 0, 179),
(180, 10, 6127, 'Two areas are covered in this course; advanced queueing models and simulation techniques. The relationships between these two areas, applications, and simulation languages will be among the topics covered.', 3, '', 0, 180),
(181, 6, 6207, 'Study of distributed processing using networking and distributed computing techniques. Investigation of distributed algorithms and models of distributed computing. ', 3, 'Course offered every Fall semester.<br />\r\nOLD COURSE CEN 6501.<br />\r\nAll changes from this field review will be effective beginning August 1, 2008. ', 0, 181),
(182, 6, 6208, 'Study of the major aspects of concurrent and distributed systems. Topics include foundations of concurrent computation, languaages and tools for concurrent systems, distributed real-time systems, distribvuted multimedia systems, and concurrent object-orie', 3, 'Course offered on even years in Spring semester.<br />\r\nOLD COURSE CEN 6502.<br />\r\nAll changes from this field review will be effective beginning August 1, 2008. ', 0, 182),
(183, 11, 6210, 'A systematic, analytic and descriptive approach to the evaluation of telecommunications networks, networking principles, and control and quality of service.', 3, '', 0, 183),
(184, 11, 6215, 'This course will cover algorithms that are used in network research and implementation.', 3, '', 0, 184),
(185, 11, 6230, 'Enabling technologies, multiplexing techniques, WDM, broadcast networks, wavelength-routed networks, network architectures, protocols, network algorithms, and device-network interfaces.', 3, '', 0, 185),
(186, 11, 6260, 'The course will discuss advanced topics, current trends and control of internetworking. An analytical and descriptive approach will be used to cover the subject of internetworking.', 3, '', 0, 186),
(187, 11, 6270, 'Techniques in the design and operation of wireless networks; LANs, MANs, and WANs; analytical models; application of traffic and mobility models; mobility control, and wireless ATM.', 3, '', 0, 187),
(188, 11, 6275, 'Enabling technologies and impediments of mobile computing. It includes mobile architectural design, mobile-aware and transparent adaptation, mobile data access and file systems, and ad-hoc networks.', 3, '', 0, 188),
(189, 8, 6405, 'Design of advanced data structures and algorithms; advanced analysis techniques; lower bound proofs; advanced algorithms for graphs, string, geometric, and numerical problems; approximation algorithms; randomized and online-algorithms.', 3, 'Course offered every Spring semester', 0, 189),
(190, 11, 6420, 'Covers methods and research issues in the models and performance evaluation of high-speed and cellular networks. Focuses on the tools from Markov queues, queuing networks theory and applications.', 0, '', 0, 190),
(191, 8, 6421, 'Advanced computability theory; diagonalization and reductions; applications of computability theory to logic; computational complexity; the classes P, NP, and PSPACE; polynomial-time reductions and completeness.', 3, 'Course offered every Spring semester', 0, 191),
(192, 11, 6430, 'Protocols for management of telecom networks, including Simple Network Management Protocol and Common Management Information Protocol. Extension of protocols to optimize network performance.', 3, '', 0, 192),
(193, 11, 6450, 'Enabling technologies and impediments of wireless information systems. Focuses on software architectures, and information and location management in the wireless environment.', 3, '', 0, 193),
(194, 3, 6501, 'Study of distributed processing using networking and distributed computing techniques. Investigation of distributed algorithms and models of distributed computing. ', 3, 'Course offered every Fall semester', 0, 194),
(195, 3, 6502, 'Study of the major aspects of concurrent and distributed systems. Topics include foundations of concurrent computation, languaages and tools for concurrent systems, distributed real-time systems, distribvuted multimedia systems, and concurrent object-orie', 3, 'Course offered on even years in Spring semester', 0, 195),
(196, 7, 6545, 'Introduction to database design, architecture and implementation aspects of DBMS, distributed databases, and advanced aspects of databases selected by the instructor.', 3, 'Course offered every Fall semester', 0, 196),
(197, 7, 6556, 'This course provides an overview of systematic and effective approaches to programming. Abstraction; formal specification techniques; program verification and; semantics of programming languages.', 3, 'Course offered on even years in Spring semester', 0, 197),
(198, 7, 6611, ' Advanced topics in operating system design; microkernel; memory architectures; multi-processor issues; multimedia operating systems; case studies.  ', 3, 'Course offered ever Spring semester', 0, 198),
(199, 5, 6612, 'This course deals with selected topics in software engineering.', 3, 'Course offered on odd years in Spring semester', 0, 199),
(200, 7, 6727, 'Design, architectures and implementation aspects of DBMS, distributed databases, and advanced aspects of databases selected by the instructor.', 3, 'Course offered every Fall semester<br />\r\n', 0, 200),
(201, 1, 6776, 'Information Retrieval (IR) principles including indexing and searching document collections, as well as advanced IR topics such as Web search and IR-style search in databases.', 3, 'This course is an advanced graduate course to complete knowledge spectrum in the wider area of Knowledge Discovery and Management, which consists of Databases, Data Mining, Machine Learning and Information Retrieval.', 0, 201),
(202, 1, 6778, 'Topics such as web data mining, stream data mining, relational data mining, tree/graph mining, spatiotemporal data indexing and mining, privacy-preserving data mining, high-dimensional data clustering, basics of natural language processing, social network', 3, 'The goal of this course is to develop an understanding of advanced topics in data mining.', 0, 202),
(203, 7, 6795, 'Study of selected advanced topics in databases and related areas.', 3, '', 0, 203);
INSERT INTO `his_course` (`id`, `coursePrefix_id`, `number`, `abstract`, `credits`, `notes`, `catalog_id`, `identifier_id`) VALUES
(204, 11, 6820, 'This course, from a management perspective, addresses the evolution of the telecom industry, the impact it has on reshaping our world, and the importance of management decisions in telecom.', 3, '', 0, 204),
(205, 4, 6834, 'Installation and maintenance of servers.  Techniques for building secure multimedia interactive web pages.  A hands on project to develop an educational interactive multimedia web site is required.  Not acceptable for CS majors.', 3, 'To introduce the students to the fundamental concepts of creating and maintaining web sites.', 0, 205),
(206, 11, 6880, 'A concept-oriented examination of the domestic and international telecommunications policy processes and standards setting environment.', 3, '', 0, 206),
(207, 5, 6900, 'Indvidual conferences, assigned readings, and reports on independent investigations.', 1, '', 0, 207),
(208, 8, 6930, 'This course deals with selected special topics in computing theory.', 3, 'Course offered on even years in Spring semester', 0, 208),
(209, 5, 6930, 'Fall 2012 - Visualization', 0, '', 0, 209),
(210, 5, 6931, 'This course deals with selected special topics in information processing.', 3, 'Course offered on odd years in Spring semester', 0, 210),
(211, 8, 6931, 'A &quot;top-down&quot; view of Computer Science, in particular artificial intelligence, by studying the computational aspects of human cognition.', 3, 'Course offered on odd years in Spring semester', 0, 211),
(212, 5, 6933, 'Regularly scheduled seminar series featuring speakers on computer science related topics.', 1, 'This course will formalize our existing colloquium series. Students will be able to get credit for attendance.', 0, 212),
(213, 11, 6935, 'Investigation and report by graduate students on topics of current interest in telecommunication and networking.', 0, '', 0, 213),
(214, 8, 6936, 'Advanced data structures, pattern matching algorithms, file compression, cryptography, computational geometry, numerical algorithms, combinatorial optimization algorithms and additional topics.', 3, '', 0, 214),
(215, 2, 6939, 'This course deals with selected special topics in computer architecture.', 3, 'Course offered on odd years in Fall semester', 0, 215),
(216, 5, 6970, '', 1, '', 0, 216),
(217, 1, 6990, 'Introduction in Bioinformatics Genomic Databases (GenBank, SwissProt, PDB).  Tools for sequence alignment, sequencing mapping molecular structural analysis, microarray data analysis, phylogeny.  Techniques (Pattern Discovery, Machine Learning, Classificat', 2, '', 0, 217),
(218, 7, 6990, 'Information Retrieval (IR) principles including indexing and searching document collections, as well as advanced IR topics such as Web search and IR-style search in databases.', 3, 'Experimental number for Fall 2006', 0, 218),
(219, 7, 6993, 'Topics such as web data mining, stream data mining, relational data mining, tree/graph mining, spatiotemporal data indexing and mining, privacy-preserving data mining, high-dimensional data clustering, basics of natural language processing, social network', 3, 'Experimental course for Spring 2007', 0, 219),
(220, 5, 7910, 'Doctoral research prior to candidacy.', 1, ' Repeatable', 0, 220),
(221, 5, 7980, '', 1, 'This course was previously Ph. D. Thesis. Tittle change was effective Summer 2002.', 0, 221),
(222, 12, 2311, NULL, 3, '', 0, 222),
(223, 12, 2312, NULL, 0, '', 0, 223),
(224, 13, 2048, NULL, 0, '', 0, 224),
(226, 13, 2049, NULL, 0, '', 0, 225);

-- --------------------------------------------------------

--
-- Table structure for table `his_coursePrefix`
--

CREATE TABLE IF NOT EXISTS `his_coursePrefix` (
  `id` int(10) NOT NULL,
  `prefix` varchar(3) NOT NULL,
  `description` varchar(255) default NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `identifier_id` (`identifier_id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `his_coursePrefix`
--

INSERT INTO `his_coursePrefix` (`id`, `prefix`, `description`, `catalog_id`, `identifier_id`) VALUES
(1, 'CAP', NULL, 0, 1),
(2, 'CDA', NULL, 0, 2),
(3, 'CEN', NULL, 0, 3),
(4, 'CGS', NULL, 0, 4),
(5, 'CIS', NULL, 0, 5),
(6, 'CNT', NULL, 0, 6),
(7, 'COP', NULL, 0, 7),
(8, 'COT', NULL, 0, 8),
(9, 'CTS', NULL, 0, 9),
(10, 'MAP', NULL, 0, 10),
(11, 'TCN', NULL, 0, 11),
(12, 'MAC', NULL, 0, 12),
(13, 'PHY', NULL, 0, 13);

-- --------------------------------------------------------

--
-- Table structure for table `his_course_department`
--

CREATE TABLE IF NOT EXISTS `his_course_department` (
  `id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `department_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id` (`course_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_department`
--

CREATE TABLE IF NOT EXISTS `his_department` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  `department_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_dgu`
--

CREATE TABLE IF NOT EXISTS `his_dgu` (
  `id` int(10) NOT NULL auto_increment,
  `description` text,
  `code` varchar(255) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `identifier_id` (`identifier_id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `his_dgu`
--

INSERT INTO `his_dgu` (`id`, `description`, `code`, `catalog_id`, `identifier_id`) VALUES
(1, 'School of Computing & Information Sciences', '', 0, 1),
(2, 'Engineering & Computing', '', 0, 2),
(3, 'Arts and Sciences', 'UGAS', 0, 3),
(4, 'supeas mucho mas', 'super hello2', 0, 18),
(5, 'desc ', 'code1', 0, 19),
(10, '', '', 0, 21);

-- --------------------------------------------------------

--
-- Table structure for table `his_group`
--

CREATE TABLE IF NOT EXISTS `his_group` (
  `id` int(10) NOT NULL,
  `minCredits` int(10) default NULL,
  `maxCredits` int(10) default NULL,
  `minSets` int(10) default NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `catalog_id` (`catalog_id`),
  KEY `identifier_id` (`identifier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `his_group`
--

INSERT INTO `his_group` (`id`, `minCredits`, `maxCredits`, `minSets`, `catalog_id`, `identifier_id`) VALUES
(1, NULL, NULL, NULL, 0, 1),
(2, NULL, NULL, NULL, 0, 2),
(3, NULL, NULL, NULL, 0, 3),
(4, NULL, NULL, NULL, 0, 4),
(5, NULL, NULL, NULL, 0, 5),
(6, NULL, NULL, NULL, 0, 6),
(7, NULL, NULL, NULL, 0, 7),
(8, NULL, NULL, NULL, 0, 8),
(9, NULL, NULL, NULL, 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `his_group_set`
--

CREATE TABLE IF NOT EXISTS `his_group_set` (
  `id` int(10) NOT NULL,
  `group_id` int(10) NOT NULL,
  `set_id` int(10) NOT NULL,
  `required` bit(1) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `group_id` (`group_id`),
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_major`
--

CREATE TABLE IF NOT EXISTS `his_major` (
  `id` int(10) NOT NULL auto_increment,
  `description` varchar(255) default NULL,
  `dgu_id` int(10) NOT NULL,
  `majorType_id` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `dgu_id` (`dgu_id`),
  KEY `majorType_id` (`majorType_id`),
  KEY `catalog_id` (`catalog_id`),
  KEY `identifier_id` (`identifier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `his_major`
--

INSERT INTO `his_major` (`id`, `description`, `dgu_id`, `majorType_id`, `catalog_id`, `identifier_id`) VALUES
(1, 'The Bachelor of Science (BS) in Mechanical Engineering is designed to give the student a thorough understanding of the basic laws of science', 1, 1, 0, 1),
(2, 'Our ABET-accredited program emphasizes engineering concepts and design in the varied and rapidly expanding fields of electrical engineering.', 1, 1, 0, 2),
(3, 'The minor in Aerospace Engineering requires the 16 credits listed below with a minimum grade of “C” in each course.', 1, 4, 0, 3),
(7, 'The minor in Energy Science requires the 16 credits listed below with a minimum grade of “C” in each course.', 1, 4, 0, 6),
(8, 'The Bachelor of Science (BS) in Computer Engineering focuses on engineering concepts and design in lightning-fast field of computer engineering. ', 1, 1, 0, 7),
(9, 'The Bachelor of Science (BS) in Computer Engineering focuses on engineering concepts and design in lightning-fast field of computer engineering. ', 1, 1, 2, 7),
(10, 'The Bachelor of Science (BS) in Mechanical Engineering is designed to give the student a thorough understanding of the basic laws of science', 1, 1, 2, 1),
(11, 'Our ABET-accredited program emphasizes engineering concepts and design in the varied and rapidly expanding fields of electrical engineering.', 1, 1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `his_majorType`
--

CREATE TABLE IF NOT EXISTS `his_majorType` (
  `id` int(10) NOT NULL,
  `name` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  `majorType_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_major_track`
--

CREATE TABLE IF NOT EXISTS `his_major_track` (
  `id` int(10) NOT NULL,
  `major_id` int(10) NOT NULL,
  `track_id` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `major_id` (`major_id`),
  KEY `track_id` (`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_requisite`
--

CREATE TABLE IF NOT EXISTS `his_requisite` (
  `id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `requisite_id` int(10) NOT NULL,
  `level` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id` (`course_id`),
  KEY `requisite_id` (`requisite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_set`
--

CREATE TABLE IF NOT EXISTS `his_set` (
  `id` int(10) NOT NULL,
  `minCredits` int(10) default NULL,
  `maxCredits` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `his_set`
--

INSERT INTO `his_set` (`id`, `minCredits`, `maxCredits`, `catalog_id`, `identifier_id`) VALUES
(1, NULL, 0, 0, 1),
(2, NULL, 0, 0, 2),
(3, NULL, 0, 0, 3),
(4, NULL, 0, 0, 4),
(5, NULL, 0, 0, 5),
(6, NULL, 0, 0, 6),
(7, NULL, 0, 0, 7),
(8, 3, 3, 0, 8),
(9, 3, 3, 0, 9),
(10, 9, 9, 0, 10),
(11, 30, 30, 0, 11),
(12, 3, 3, 0, 12),
(13, 3, 3, 0, 13),
(14, 0, 6, 0, 14),
(15, 0, 6, 0, 15),
(16, 0, 6, 0, 16),
(17, 0, 6, 0, 17);

-- --------------------------------------------------------

--
-- Table structure for table `his_set_course`
--

CREATE TABLE IF NOT EXISTS `his_set_course` (
  `id` int(10) NOT NULL,
  `set_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `set_id` (`set_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `his_track`
--

CREATE TABLE IF NOT EXISTS `his_track` (
  `id` int(10) NOT NULL,
  `description` varchar(255) default NULL,
  `minCredits` int(10) default NULL,
  `catalog_id` int(10) NOT NULL,
  `identifier_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `identifier_id` (`identifier_id`),
  KEY `catalog_id` (`catalog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `his_track`
--

INSERT INTO `his_track` (`id`, `description`, `minCredits`, `catalog_id`, `identifier_id`) VALUES
(1, 'There are two tracks available in the upper division program for Computer Science. The Computer Science (CS) track should be followed by the student who intends to continue on to graduate study in computer science.', NULL, 0, 1),
(2, 'The Software Design and Development (SDD) track may be followed by the student who intends to pursue a software engineering career. ', NULL, 0, 2),
(3, 'The IT major gives the student a broad understanding of information technology concepts. It is designed for the student who wishes to work as a technical support staff or administrator. ', NULL, 0, 3),
(4, 'In addition to the broad understanding of information technology concepts, the student gains a theoretical understanding of computer science. ', NULL, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `his_track_group`
--

CREATE TABLE IF NOT EXISTS `his_track_group` (
  `id` int(10) NOT NULL,
  `track_id` int(10) NOT NULL,
  `group_id` int(10) NOT NULL,
  `required` bit(1) default NULL,
  `catalog_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `track_id` (`track_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Rights`
--

CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`itemname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `curr_course`
--
ALTER TABLE `curr_course`
  ADD CONSTRAINT `curr_course_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `curr_coursePrefix`
--
ALTER TABLE `curr_coursePrefix`
  ADD CONSTRAINT `curr_coursePrefix_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `acl_users` (`superuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `curr_course_department`
--
ALTER TABLE `curr_course_department`
  ADD CONSTRAINT `curr_course_department_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `curr_course` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curr_course_department_ibfk_4` FOREIGN KEY (`department_id`) REFERENCES `curr_department` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `curr_group`
--
ALTER TABLE `curr_group`
  ADD CONSTRAINT `curr_group_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `curr_group_set`
--
ALTER TABLE `curr_group_set`
  ADD CONSTRAINT `curr_group_set_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `curr_group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curr_group_set_ibfk_4` FOREIGN KEY (`set_id`) REFERENCES `curr_set` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `curr_major`
--
ALTER TABLE `curr_major`
  ADD CONSTRAINT `curr_major_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `curr_majorType`
--
ALTER TABLE `curr_majorType`
  ADD CONSTRAINT `curr_majorType_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `curr_major_track`
--
ALTER TABLE `curr_major_track`
  ADD CONSTRAINT `curr_major_track_ibfk_3` FOREIGN KEY (`major_id`) REFERENCES `curr_major` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curr_major_track_ibfk_4` FOREIGN KEY (`track_id`) REFERENCES `curr_track` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `curr_requisite`
--
ALTER TABLE `curr_requisite`
  ADD CONSTRAINT `curr_requisite_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `curr_course` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curr_requisite_ibfk_4` FOREIGN KEY (`requisite_id`) REFERENCES `curr_requisite` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `curr_set`
--
ALTER TABLE `curr_set`
  ADD CONSTRAINT `curr_set_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `curr_set_course`
--
ALTER TABLE `curr_set_course`
  ADD CONSTRAINT `curr_set_course_ibfk_3` FOREIGN KEY (`set_id`) REFERENCES `curr_set` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curr_set_course_ibfk_4` FOREIGN KEY (`course_id`) REFERENCES `curr_course` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `curr_track`
--
ALTER TABLE `curr_track`
  ADD CONSTRAINT `curr_track_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `curr_track_group`
--
ALTER TABLE `curr_track_group`
  ADD CONSTRAINT `curr_track_group_ibfk_3` FOREIGN KEY (`track_id`) REFERENCES `curr_track` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curr_track_group_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `curr_group` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `his_course`
--
ALTER TABLE `his_course`
  ADD CONSTRAINT `his_course_ibfk_1` FOREIGN KEY (`coursePrefix_id`) REFERENCES `curr_coursePrefix` (`id`);

--
-- Constraints for table `his_coursePrefix`
--
ALTER TABLE `his_coursePrefix`
  ADD CONSTRAINT `his_coursePrefix_ibfk_2` FOREIGN KEY (`identifier_id`) REFERENCES `curr_coursePrefix` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `his_coursePrefix_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `his_dgu`
--
ALTER TABLE `his_dgu`
  ADD CONSTRAINT `his_dgu_ibfk_4` FOREIGN KEY (`identifier_id`) REFERENCES `curr_dgu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `his_group`
--
ALTER TABLE `his_group`
  ADD CONSTRAINT `his_group_ibfk_3` FOREIGN KEY (`identifier_id`) REFERENCES `curr_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `his_group_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `his_major`
--
ALTER TABLE `his_major`
  ADD CONSTRAINT `his_major_ibfk_5` FOREIGN KEY (`dgu_id`) REFERENCES `curr_dgu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `his_major_ibfk_2` FOREIGN KEY (`majorType_id`) REFERENCES `curr_majorType` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `his_major_ibfk_3` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `his_major_ibfk_4` FOREIGN KEY (`identifier_id`) REFERENCES `curr_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `his_requisite`
--
ALTER TABLE `his_requisite`
  ADD CONSTRAINT `his_requisite_ibfk_5` FOREIGN KEY (`course_id`) REFERENCES `his_course` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `his_requisite_ibfk_6` FOREIGN KEY (`requisite_id`) REFERENCES `his_requisite` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `his_track`
--
ALTER TABLE `his_track`
  ADD CONSTRAINT `his_track_ibfk_2` FOREIGN KEY (`identifier_id`) REFERENCES `curr_track` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `his_track_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
