-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 22, 2014 at 07:25 PM
-- Server version: 4.1.22
-- PHP Version: 4.3.9
-- 
-- Database: `inventory`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `p_detail_email`
-- 

DROP TABLE IF EXISTS `p_detail_email`;
CREATE TABLE IF NOT EXISTS `p_detail_email` (
  `id` bigint(20) NOT NULL auto_increment,
  `addr` varchar(40) NOT NULL default '',
  `active_yn` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `p_detail_email`
-- 

INSERT INTO `p_detail_email` (`id`, `addr`, `active_yn`) VALUES 
(1, 'timothyhildebrandt@gmail.com', 'Y'),
(2, 'john@trombly.org', 'N'),
(3, 'juan2trombly@gmail.com', 'N'),
(4, 'janiegarcia1962@yahoo.com', 'N'),
(5, 'ccaacmpc@gmail.com', 'Y'),
(6, 'martha@morganpedi.com', 'N');
