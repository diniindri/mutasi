/*
 Navicat Premium Data Transfer

 Source Server         : mamp
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:8889
 Source Schema         : db_m-alika

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 20/05/2021 09:45:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for keys
-- ----------------------------
DROP TABLE IF EXISTS `keys`;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of keys
-- ----------------------------
BEGIN;
INSERT INTO `keys` VALUES (1, 1, 'hGfdg456ghD4f566afjh6Fg@hgb#jijk', 1, 0, 0, NULL, 1595413807);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(18) DEFAULT NULL,
  `nama` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (4, '198407022003121004', 'Dana Kristiawan', 'danakristiawan@gmail.com', '$2y$10$.WOt64Sf2QnX4NqPkea60uNJMrnhZhWLAGW/JFRvkN1VYK3LG79Wq', 1, 1577811600);
INSERT INTO `users` VALUES (6, '195601011993031001', 'Wagino', 'wagino@gmail.com', '$2y$10$nZp/KQM9KRAabKuW8iTqeersCYgUNIpPA5GIDEq.kXyvdh/aEBjv6', 1, 1609434000);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
