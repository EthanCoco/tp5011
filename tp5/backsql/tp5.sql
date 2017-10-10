/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.10
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : tp5

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-10-10 08:30:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_desktop
-- ----------------------------
DROP TABLE IF EXISTS `blog_desktop`;
CREATE TABLE `blog_desktop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openurl` varchar(100) NOT NULL,
  `iconurl` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ordersrot` int(11) NOT NULL DEFAULT '0',
  `fai` varchar(50) NOT NULL,
  `sysdef` tinyint(1) NOT NULL DEFAULT '0',
  `menupid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_desktop
-- ----------------------------
INSERT INTO `blog_desktop` VALUES ('1', 'index/user', '../../../web/images/img/icon/user.png', '用户管理', '1', '2', 'black icon fa fa-user fa-fw', '0', '3');
INSERT INTO `blog_desktop` VALUES ('2', 'index/desktop', '../../../web/images/img/icon/system.png', '桌面设置', '1', '1', 'black icon fa fa-wrench fa-fw', '0', '2');
INSERT INTO `blog_desktop` VALUES ('3', 'index/system', '../../../web/images/img/icon/system.png', '测试数据', '1', '3', 'black icon fa fa-wrench fa-fw', '0', '2');
INSERT INTO `blog_desktop` VALUES ('4', 'index/comwebsite', '../../../web/images/img/icon/website.png', '公司网站', '1', '0', 'black icon fa fa-desktop fa-fw', '1', '1');
INSERT INTO `blog_desktop` VALUES ('5', 'index/usermanual', '../../../web/images/img/icon/usersc.png', '用户手册', '1', '0', 'black icon fa fa-book fa-fw', '1', '1');
INSERT INTO `blog_desktop` VALUES ('6', 'index/help', '../../../web/images/img/icon/help.png', '其他帮助', '1', '0', 'black icon fa fa-question-circle fa-fw', '1', '1');

-- ----------------------------
-- Table structure for blog_menu_folder
-- ----------------------------
DROP TABLE IF EXISTS `blog_menu_folder`;
CREATE TABLE `blog_menu_folder` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `mname` varchar(50) NOT NULL,
  `mfa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_menu_folder
-- ----------------------------
INSERT INTO `blog_menu_folder` VALUES ('1', '系统默认', 'icon fa fa-question-circle fa-fw');
INSERT INTO `blog_menu_folder` VALUES ('2', '系统设置', 'icon fa fa-wrench fa-fw');
INSERT INTO `blog_menu_folder` VALUES ('3', '用户', 'icon fa fa-user fa-fw');
INSERT INTO `blog_menu_folder` VALUES ('4', '测试', 'icon fa fa-user fa-fw');

-- ----------------------------
-- Table structure for blog_msg
-- ----------------------------
DROP TABLE IF EXISTS `blog_msg`;
CREATE TABLE `blog_msg` (
  `mid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL COMMENT '用户ID',
  `mtitle` varchar(100) DEFAULT NULL COMMENT '标题',
  `mcontent` text COMMENT '内容',
  `mtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '发送时间',
  `mstatus` tinyint(1) DEFAULT '1' COMMENT '状态（1=未读，2=已读，0=删除）',
  `muid` bigint(20) DEFAULT NULL COMMENT '发消息者ID',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_msg
-- ----------------------------
INSERT INTO `blog_msg` VALUES ('1', '1', '测试测试11', '测试测试测绘师肯定好看的方式的合法的开始防守打法你到时', '2017-09-20 10:04:36', '1', '31');
INSERT INTO `blog_msg` VALUES ('2', '1', '测试测试11', '测试测试测绘师肯定好看的方式的合法的开始防守打法你到时', '2017-09-20 10:04:36', '1', '31');
INSERT INTO `blog_msg` VALUES ('3', '31', '测试测试22', '测试测试测绘师肯定好看的方式的合法的开始防守打法你到时', '2017-09-19 10:44:11', '1', '1');
INSERT INTO `blog_msg` VALUES ('4', '31', '测试测试22', '测试测试测绘师肯定好看的方式的合法的开始防守打法你到时', '2017-09-19 10:44:13', '1', '1');
INSERT INTO `blog_msg` VALUES ('5', '31', 'sdasdasd', 'asdasdasd', '2017-09-07 14:31:07', '1', '1');

-- ----------------------------
-- Table structure for blog_newmsg
-- ----------------------------
DROP TABLE IF EXISTS `blog_newmsg`;
CREATE TABLE `blog_newmsg` (
  `msgid` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `fun` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `sendid` bigint(20) DEFAULT NULL,
  `reciveid` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `sendtime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`msgid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_newmsg
-- ----------------------------
INSERT INTO `blog_newmsg` VALUES ('1', '系统消息测试', '系统消息系统消息系统消息', null, '1', null, null, '0', '2017-09-22 15:26:15');
INSERT INTO `blog_newmsg` VALUES ('2', '系统消息测试2', '系统消息测试2系统消息测试2', 'Win10.enableFullScreen()', '1', null, null, '0', '2017-09-13 15:26:21');
INSERT INTO `blog_newmsg` VALUES ('3', 'gfdgfdgdf', 'gfgfdgfdgdfgf', null, '2', '2', '1', '0', '2017-09-24 15:14:55');
INSERT INTO `blog_newmsg` VALUES ('4', 'dfsds', 'gsgsfgsg', null, '2', '2', '1', '0', null);
INSERT INTO `blog_newmsg` VALUES ('5', 'ffdsfsdf', 'dfsdfsdf', null, '2', '2', '1', '0', null);

-- ----------------------------
-- Table structure for blog_test
-- ----------------------------
DROP TABLE IF EXISTS `blog_test`;
CREATE TABLE `blog_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `aa` varchar(255) DEFAULT NULL,
  `bb` varchar(255) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20015 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_test
-- ----------------------------

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
  `ulogintime` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `ucount` (`ucount`),
  UNIQUE KEY `uemail` (`uemail`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of blog_user
-- ----------------------------
INSERT INTO `blog_user` VALUES ('1', 'lijianlin', '82bdc4f63cfa37b7335c0f478310c088', '李建林', '2319048747@qq.com', '2017-09-24 14:52:23', '2130706433', '1', '2', '11111', null, '1');
INSERT INTO `blog_user` VALUES ('31', 'blog', '82bdc4f63cfa37b7335c0f478310c088', '团队', '', '0000-00-00 00:00:00', '', '1', '1', null, null, '0');

-- ----------------------------
-- Table structure for blog_user_desktop
-- ----------------------------
DROP TABLE IF EXISTS `blog_user_desktop`;
CREATE TABLE `blog_user_desktop` (
  `udid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `desktopid` int(11) DEFAULT NULL,
  PRIMARY KEY (`udid`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_user_desktop
-- ----------------------------
INSERT INTO `blog_user_desktop` VALUES ('43', '1', '5');
INSERT INTO `blog_user_desktop` VALUES ('44', '1', '4');
INSERT INTO `blog_user_desktop` VALUES ('9', '1', '2');
INSERT INTO `blog_user_desktop` VALUES ('42', '1', '6');
INSERT INTO `blog_user_desktop` VALUES ('35', '1', '1');

-- ----------------------------
-- Table structure for blog_user_newmsg
-- ----------------------------
DROP TABLE IF EXISTS `blog_user_newmsg`;
CREATE TABLE `blog_user_newmsg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `msgid` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_user_newmsg
-- ----------------------------
INSERT INTO `blog_user_newmsg` VALUES ('1', '1', '1', '1');
INSERT INTO `blog_user_newmsg` VALUES ('4', '1', '2', '1');
