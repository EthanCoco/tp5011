/*
Navicat MySQL Data Transfer

Source Server         : localhostphpstudy
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tp5

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-18 20:52:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_ucname
-- ----------------------------
DROP TABLE IF EXISTS `blog_ucname`;
CREATE TABLE `blog_ucname` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户基本信息字段ID',
  `name` varchar(50) NOT NULL COMMENT '字段名',
  `zhname` varchar(50) NOT NULL COMMENT '字段中文名',
  `type` tinyint(1) NOT NULL COMMENT '所属模块（0=基本资料，1=个人信息，2=联系方式）',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '字段是否启用（0=禁用，1=启用）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='用户字段表';

-- ----------------------------
-- Records of blog_ucname
-- ----------------------------
INSERT INTO `blog_ucname` VALUES ('1', 'name', '姓名', '0', '1');
INSERT INTO `blog_ucname` VALUES ('2', 'gender', '性别', '0', '1');
INSERT INTO `blog_ucname` VALUES ('3', 'birth', '出生日期', '0', '1');
INSERT INTO `blog_ucname` VALUES ('4', 'haddr', '家乡', '0', '1');
INSERT INTO `blog_ucname` VALUES ('6', 'naddr', '现居住地', '0', '1');
INSERT INTO `blog_ucname` VALUES ('8', 'marry', '婚姻', '0', '1');
INSERT INTO `blog_ucname` VALUES ('9', 'post', '职位', '0', '1');
INSERT INTO `blog_ucname` VALUES ('10', 'com', '单位', '0', '1');
INSERT INTO `blog_ucname` VALUES ('11', 'workstatus', '工作状况', '0', '1');
INSERT INTO `blog_ucname` VALUES ('12', 'interesttec', '感兴趣的技术', '1', '1');
INSERT INTO `blog_ucname` VALUES ('13', 'latest', '最近目标', '1', '1');
INSERT INTO `blog_ucname` VALUES ('14', 'zym', '座右铭', '1', '1');
INSERT INTO `blog_ucname` VALUES ('15', 'introduction', '自我介绍', '1', '1');
INSERT INTO `blog_ucname` VALUES ('16', 'msn', 'MSN', '2', '1');
INSERT INTO `blog_ucname` VALUES ('17', 'qq', 'QQ', '2', '1');
INSERT INTO `blog_ucname` VALUES ('18', 'phone', '手机号码', '2', '1');
INSERT INTO `blog_ucname` VALUES ('19', 'git', 'gitHub', '2', '1');

-- ----------------------------
-- Table structure for blog_uinfo
-- ----------------------------
DROP TABLE IF EXISTS `blog_uinfo`;
CREATE TABLE `blog_uinfo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cname` varchar(50) DEFAULT NULL COMMENT '字段名',
  `cvalue` varchar(100) DEFAULT NULL COMMENT 'cname对应的值',
  `ctype` tinyint(1) DEFAULT NULL COMMENT '所属类型',
  `cseen` tinyint(1) DEFAULT '0' COMMENT '可见设置（0=任何人，1=仅好友，2保密）',
  `chome` tinyint(1) DEFAULT '0' COMMENT '是否显示在首页（1=显示，0=不显示）',
  `uid` bigint(20) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_uinfo
-- ----------------------------
INSERT INTO `blog_uinfo` VALUES ('2', 'name', null, '0', '0', '0', '1');
INSERT INTO `blog_uinfo` VALUES ('3', 'gender', null, '0', '0', '0', '1');

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `uid` bigint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id 自增',
  `ucount` varchar(255) NOT NULL DEFAULT '' COMMENT '用户账号',
  `upass` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `uname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `uemail` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `ulasttime` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
  `uip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `ustatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态（1=启用，0=禁用）',
  `utype` int(1) NOT NULL DEFAULT '2' COMMENT '用户类别（0=超级管理员，1=其他管理人员，2=普通用户）',
  `uimageurl` varchar(255) DEFAULT NULL COMMENT '用户图片地址',
  `uregtime` timestamp NULL DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `ucount` (`ucount`),
  UNIQUE KEY `uemail` (`uemail`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of blog_user
-- ----------------------------
INSERT INTO `blog_user` VALUES ('1', 'lijianlin', '82bdc4f63cfa37b7335c0f478310c088', '李建林', '2319048747@qq.com', '0000-00-00 00:00:00', '', '1', '2', '11111', null);
