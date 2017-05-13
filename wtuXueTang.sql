/*
Navicat MySQL Data Transfer

Source Server         : 192.168.32.10
Source Server Version : 50717
Source Host           : 192.168.32.10:3306
Source Database       : wtuXueTang

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-05-07 18:43:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for comment_title
-- ----------------------------
DROP TABLE IF EXISTS `comment_title`;
CREATE TABLE `comment_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` varchar(255) DEFAULT NULL,
  `comment_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comment_title
-- ----------------------------
INSERT INTO `comment_title` VALUES ('1', 'T_1024', '该问些什么问题呢');
INSERT INTO `comment_title` VALUES ('3', 'T_1024', '前端框架怎么学');

-- ----------------------------
-- Table structure for course_capter
-- ----------------------------
DROP TABLE IF EXISTS `course_capter`;
CREATE TABLE `course_capter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` varchar(255) DEFAULT NULL,
  `capter_id` varchar(255) DEFAULT NULL,
  `c_content` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `capter_introduce` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `c_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `c_id` (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of course_capter
-- ----------------------------
INSERT INTO `course_capter` VALUES ('7', 'T_1024', 'T_1024_1', '课程一', '这是T_1024课程一的介绍', '../../../static/video/ogg-19M.ogg');
INSERT INTO `course_capter` VALUES ('8', 'T_1024', 'T_1024_2', '课程二', '这是T_1024课程二的介绍', 'http://www.w3school.com.cn/i/movie.ogg');
INSERT INTO `course_capter` VALUES ('9', 'T_1024', 'T_1024_3', '课程三', '这是T_1024课程三的介绍', '../../../static/video/ogg-19M.ogg');
INSERT INTO `course_capter` VALUES ('12', 'T_1026', 'T_1026_1', '。net课程1', '这是T_1024课程一的介绍', 'url');
INSERT INTO `course_capter` VALUES ('13', 'T_1027', 'T_1027_1', '英语练习1', '我的大所多撒多无大多', 'url');

-- ----------------------------
-- Table structure for course_comment
-- ----------------------------
DROP TABLE IF EXISTS `course_comment`;
CREATE TABLE `course_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `head_pic` varchar(400) DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of course_comment
-- ----------------------------
INSERT INTO `course_comment` VALUES ('1', '1', '0', 'xwk', null, '哈哈哈 今天天气不错', '2017-03-29 10:43:46');
INSERT INTO `course_comment` VALUES ('3', '1', '1', 'xwk22', null, '是啊  天气不错', '2017-03-29 11:09:51');
INSERT INTO `course_comment` VALUES ('4', '1', '3', 'xwk33', null, '你哪里人', '2017-03-29 11:10:18');
INSERT INTO `course_comment` VALUES ('5', '1', '1', 'xwk22', null, '天气不错  适合出去玩', '2017-03-29 11:10:44');
INSERT INTO `course_comment` VALUES ('6', '2', '0', 'dadsd', null, 'asdasdad', '2017-04-14 11:23:05');

-- ----------------------------
-- Table structure for course_configure
-- ----------------------------
DROP TABLE IF EXISTS `course_configure`;
CREATE TABLE `course_configure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_creator` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `c_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `c_no` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `c_start` datetime(6) DEFAULT NULL,
  `c_end` datetime(6) DEFAULT NULL,
  `c_classify` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `c_introduce` varchar(255) CHARACTER SET utf8 NOT NULL,
  `c_exmine` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of course_configure
-- ----------------------------
INSERT INTO `course_configure` VALUES ('1', 'hc', '前端开发', 'T_1024', '2017-03-14 16:05:50.000000', '2017-03-14 16:05:50.000000', 'web开发', '这是一个介绍前端开发的实例视频，适合人群为所有水平的学生', '2');
INSERT INTO `course_configure` VALUES ('3', 'hc', '.net开发', 'T_1026', '2017-03-22 13:56:13.000000', '2017-03-23 13:56:18.000000', '。net', '这是一个介绍。net的开发课程，适合所有人群', '2');
INSERT INTO `course_configure` VALUES ('4', 'rewq', '英语练习', 'T_1027', '2017-03-21 17:05:49.000000', '2017-03-21 17:05:56.000000', '语种练习', '这是一个介绍英语练习的视频，适合准备考四六级的同学学习', '1');

-- ----------------------------
-- Table structure for course_unit
-- ----------------------------
DROP TABLE IF EXISTS `course_unit`;
CREATE TABLE `course_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  ` capterid` varchar(255) DEFAULT '',
  ` u_url` varchar(255) DEFAULT NULL,
  `c_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of course_unit
-- ----------------------------
INSERT INTO `course_unit` VALUES ('3', 'T_1024_1', 'asdasf', 'T_1024');
INSERT INTO `course_unit` VALUES ('4', 'T_1024_2', 'awdwwd', 'T_1024');
INSERT INTO `course_unit` VALUES ('5', 'T_1024_3', 'wad', 'T_1024');

-- ----------------------------
-- Table structure for exercises
-- ----------------------------
DROP TABLE IF EXISTS `exercises`;
CREATE TABLE `exercises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` varchar(255) NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `right_option` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `option_1` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `option_2` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `option_3` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of exercises
-- ----------------------------
INSERT INTO `exercises` VALUES ('1', 'T_1024', '兔子和乌龟比什么绝对不会输？', '仰卧起坐', '跳远', '跳高', '赛跑', '20');
INSERT INTO `exercises` VALUES ('2', 'T_1024', '小明妈妈：“小明赶紧切土豆去！”小明：“切，我不切！提问：小明要不要去切土豆？？', '不切', '切', '在犹豫', '不知道', '20');

-- ----------------------------
-- Table structure for user_identity
-- ----------------------------
DROP TABLE IF EXISTS `user_identity`;
CREATE TABLE `user_identity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `role` int(2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tx_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_identity
-- ----------------------------
INSERT INTO `user_identity` VALUES ('1', 'xwk', 'xwk123', 'male', '1', '1028606271@qq.com', 'http://localhost/studyApi/PhalApi/upload/wtu/2017/04/11/1491899428.jpg');
INSERT INTO `user_identity` VALUES ('4', 'xwk2', '123', 'female', '1', '1234567w', 'http://localhost/studyApi/PhalApi/upload/wtu/2017/03/21/1490067199.jpg');
INSERT INTO `user_identity` VALUES ('13', 'xwkdasdkasf', '12312', 'male', '2', 'adwdasf', '');
INSERT INTO `user_identity` VALUES ('14', 'askdk', 'asd', 'female', '1', 'ads', '');
INSERT INTO `user_identity` VALUES ('15', 'wda', '1asd', 'male', '2', '123', '');
INSERT INTO `user_identity` VALUES ('16', 'awd', 'daw', 'female', '2', 'wad', '');
INSERT INTO `user_identity` VALUES ('17', 'wad', '1asd', 'female', '2', 'das', '');
INSERT INTO `user_identity` VALUES ('18', 'wda111', 'sadasddw', 'female', '1', 'wd', '');
INSERT INTO `user_identity` VALUES ('19', 'dawdasds', 'dwdsadwd', 'female', '3', 'wda', '');
INSERT INTO `user_identity` VALUES ('20', 'wd2d', '1sda', 'female', '3', 'adsad', '');
INSERT INTO `user_identity` VALUES ('21', 'asdasd', '1222', 'female', '3', '22', '');
INSERT INTO `user_identity` VALUES ('22', '1dasdsad', 'saf', 'male', '2', 'wda', '');
INSERT INTO `user_identity` VALUES ('23', 'wda', '11111', 'male', '2', 'wd', '');
INSERT INTO `user_identity` VALUES ('24', 'wad', '11111', 'female', '2', '222', '');
INSERT INTO `user_identity` VALUES ('25', '2awda', 'qwd', 'male', '1', 'qwe', '');
INSERT INTO `user_identity` VALUES ('26', '33', '2', 'female', '2', 'd', '');
INSERT INTO `user_identity` VALUES ('27', 'qwe', 'qwe', 'female', '2', 'qw', '');
INSERT INTO `user_identity` VALUES ('28', 'hc', '123', 'female', '3', 'wqeqwe', '');
INSERT INTO `user_identity` VALUES ('29', 'wqe', 'wqe', 'female', '2', 'wqe', '');
INSERT INTO `user_identity` VALUES ('30', 'rewq', 'qwe2e', 'female', '3', 'qwe', '');
INSERT INTO `user_identity` VALUES ('31', '2e', '2e', 'female', '2', '2e', '');
INSERT INTO `user_identity` VALUES ('37', 'dengxing', '123', 'male', '2', 'asda@asda.com', null);
INSERT INTO `user_identity` VALUES ('38', 'hechao', '123', 'male', '3', 'asdas@w.com', null);
INSERT INTO `user_identity` VALUES ('39', 'rewq111', '123', 'male', '3', 'asda@qq.com', null);
INSERT INTO `user_identity` VALUES ('40', 'dengxing123', '123', 'male', '2', 'ada@wad.com', null);
INSERT INTO `user_identity` VALUES ('41', 'lium1', '123', 'male', '2', 'asdad@qq.com', 'http://localhost/studyApi/PhalApi/upload/wtu/2017/04/11/1491899687.jpg');
INSERT INTO `user_identity` VALUES ('42', 'cao12', '123', 'male', '2', 'asda@ada.com', null);
INSERT INTO `user_identity` VALUES ('43', 'zhangquan', 'zq123', 'male', '2', 'asdasdasd@qq.com', 'http://localhost/studyApi/PhalApi/upload/wtu/2017/04/27/1493273110.jpg');
