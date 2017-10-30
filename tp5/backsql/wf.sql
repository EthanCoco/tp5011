/*
Navicat MySQL Data Transfer

Source Server         : localhostphpstudy
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : wf

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-10-30 20:46:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wf01
-- ----------------------------
DROP TABLE IF EXISTS `wf01`;
CREATE TABLE `wf01` (
  `wf01001` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '流程ID',
  `wf01002` varchar(100) NOT NULL COMMENT '流程名称',
  `wf01003` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `wf01004` varchar(255) DEFAULT NULL COMMENT '流程描述',
  `wf01005` tinyint(1) NOT NULL DEFAULT '0' COMMENT '流程启用状态（0=未启用，1=启用）',
  PRIMARY KEY (`wf01001`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='流程表WF01';

-- ----------------------------
-- Records of wf01
-- ----------------------------

-- ----------------------------
-- Table structure for wf02
-- ----------------------------
DROP TABLE IF EXISTS `wf02`;
CREATE TABLE `wf02` (
  `wf02001` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '环节ID',
  `wf02002` bigint(20) NOT NULL COMMENT '流程ID',
  `wf02003` varchar(100) NOT NULL COMMENT '环节名称',
  `wf02004` int(8) DEFAULT NULL COMMENT '环节顺序',
  PRIMARY KEY (`wf02001`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='环节表';

-- ----------------------------
-- Records of wf02
-- ----------------------------

-- ----------------------------
-- Table structure for wf08
-- ----------------------------
DROP TABLE IF EXISTS `wf08`;
CREATE TABLE `wf08` (
  `wf08001` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '环节处理ID主键',
  `wf08002` bigint(20) NOT NULL COMMENT '环节ID',
  `wf08003` tinyint(1) NOT NULL DEFAULT '1' COMMENT '环节处理值（1=默认填写，2=查看，3=审核，4=入库回写）',
  PRIMARY KEY (`wf08001`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='环节处理表';

-- ----------------------------
-- Records of wf08
-- ----------------------------

-- ----------------------------
-- Table structure for wf09
-- ----------------------------
DROP TABLE IF EXISTS `wf09`;
CREATE TABLE `wf09` (
  `wf09001` bigint(20) NOT NULL COMMENT '环节关联审核表主键ID',
  `wf09002` bigint(20) NOT NULL COMMENT '环节ID',
  `wf09003` varchar(50) NOT NULL COMMENT '环节对应审核字段',
  `wf09004` varchar(50) DEFAULT NULL COMMENT '环节对应的审核不通过原因字段',
  `wf09005` varchar(50) NOT NULL COMMENT '环节对应审核时间字段',
  `wf09006` varchar(50) DEFAULT NULL COMMENT '环节对应审核人（操作人）字段',
  PRIMARY KEY (`wf09001`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='环节对应审核字段信息表';

-- ----------------------------
-- Records of wf09
-- ----------------------------
