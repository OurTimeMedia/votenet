/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50616
 Source Host           : localhost
 Source Database       : fission_ei_production

 Target Server Type    : MySQL
 Target Server Version : 50616
 File Encoding         : utf-8

 Date: 09/02/2014 14:00:55 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `ei_voter_reminder`
-- ----------------------------
DROP TABLE IF EXISTS `ei_voter_reminder`;
CREATE TABLE `ei_voter_reminder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `notified` int(1) DEFAULT '0',
  `notified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
