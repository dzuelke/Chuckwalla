-- phpMyAdmin SQL Dump
-- version 2.8.1-rc1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 27, 2007 at 11:47 AM
-- Server version: 5.0.21
-- PHP Version: 5.2.1-dev

SET FOREIGN_KEY_CHECKS=0;

SET AUTOCOMMIT=0;
START TRANSACTION;

-- 
-- Database: `agavi-td`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `channel`
-- 

CREATE TABLE `channel` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `topic` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `channel_nick`
-- 

CREATE TABLE `channel_nick` (
  `channel_id` int(10) unsigned NOT NULL,
  `nick_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`channel_id`,`nick_id`),
  KEY `nick_id` (`nick_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `irc_identity`
-- 

CREATE TABLE `irc_identity` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `nick`
-- 

CREATE TABLE `nick` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nick` varchar(255) NOT NULL,
  `irc_identity_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `irc_identity_id` (`irc_identity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `channel_nick`
-- 
ALTER TABLE `channel_nick`
  ADD CONSTRAINT `channel_nick_ibfk_2` FOREIGN KEY (`nick_id`) REFERENCES `nick` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `channel_nick_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE;

-- 
-- Constraints for table `irc_identity`
-- 
ALTER TABLE `irc_identity`
  ADD CONSTRAINT `irc_identity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

-- 
-- Constraints for table `nick`
-- 
ALTER TABLE `nick`
  ADD CONSTRAINT `nick_ibfk_1` FOREIGN KEY (`irc_identity_id`) REFERENCES `irc_identity` (`id`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
