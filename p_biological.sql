-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 22, 2014 at 07:24 PM
-- Server version: 4.1.22
-- PHP Version: 4.3.9
-- 
-- Database: `inventory`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `p_biological`
-- 

DROP TABLE IF EXISTS `p_biological`;
CREATE TABLE `p_biological` (
  `id` double NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `state_memo` text NOT NULL,
  `comm_memo` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- 
-- Dumping data for table `p_biological`
-- 

INSERT INTO `p_biological` (`id`, `name`, `state_memo`, `comm_memo`) VALUES 
(1, 'DT', 'State\r\nMoe stuff can go here!\r\nAnd you can always put more stuff here!\r\nThis is a test!!!!!!!!!!!!!', 'Commercial Text goes here.\r\nAnd notice that this is the Commercial stuff\r\nThis is from Elva!'),
(2, 'DtaP', '', ''),
(3, 'Kinrix', '', ''),
(4, 'Pentacel', '', ''),
(5, 'Hep A', '', ''),
(6, 'Hep B', '', ''),
(7, 'MMR', '', ''),
(8, 'HIB', '', ''),
(9, 'HPV', '', ''),
(10, 'MCV4*(N)', '', ''),
(11, 'MCV4(S)', '', ''),
(12, 'PCV13', '', ''),
(13, 'ROTA', '', ''),
(14, 'IPV', '', ''),
(15, 'Tdap', '', ''),
(16, 'Varicella', '', ''),
(17, 'TD', '', ''),
(18, 'Flu(6-35)', '', ''),
(19, 'Flu(3y+) State only', '', ''),
(20, 'Flumist', '', ''),
(21, 'Pediarix', '', ''),
(22, 'Rotarix', '', ''),
(23, 'Flu(4y+) Commercial only', '', '');
