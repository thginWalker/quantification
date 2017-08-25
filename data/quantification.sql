# Host: localhost  (Version: 5.5.53)
# Date: 2017-08-25 10:21:02
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin"
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_number` char(12) DEFAULT NULL COMMENT '工号',
  `ad_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `ad_name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `ad_sex` char(2) DEFAULT NULL COMMENT '性别（0男，1女）',
  `ad_email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `ad_distinguish` int(1) DEFAULT NULL COMMENT '判别（0书记，1班主任）',
  `ad_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='超级管理员';

#
# Data for table "admin"
#

INSERT INTO `admin` VALUES (1,'sxn','21232f297a57a5a743894a0e4a801fc3','12111','0','122222@qq.com',0,'书记'),(2,'js','21232f297a57a5a743894a0e4a801fc3','1','1','1',1,''),(3,'xz','21232f297a57a5a743894a0e4a801fc3','assaas','0','22',1,NULL),(4,'212121',NULL,'212112','1','22',1,NULL),(5,'wewewewe',NULL,'wewewewe','0','22',1,NULL),(6,'233223',NULL,'23322332','0','22',1,NULL),(7,'问问',NULL,'二位','0','22',1,NULL),(8,'二位',NULL,'问问','0','22',1,NULL),(9,'1111',NULL,'12121','0','22',1,NULL),(10,'544554',NULL,'544554','45','5455445',NULL,NULL),(11,'5454',NULL,'54545',NULL,'4554',NULL,NULL),(12,'54554',NULL,'4554','54','5454',NULL,NULL),(13,'13',NULL,'13','0','3',NULL,NULL),(14,'14',NULL,'13','0','3',NULL,NULL),(15,'1111',NULL,'1111111111','0','111',NULL,NULL),(16,'1111111',NULL,'1111111111','0','13',NULL,NULL),(17,'1111',NULL,'1111111111',NULL,'',NULL,NULL);

#
# Structure for table "classes"
#

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `major_id` int(11) DEFAULT NULL COMMENT '专业ID',
  `admin_id` int(11) DEFAULT NULL COMMENT '班主任',
  `cl_grade` varchar(255) DEFAULT NULL COMMENT '年级',
  `cl_classes` varchar(255) DEFAULT NULL COMMENT '班级',
  `cl_headmaster` varchar(255) DEFAULT NULL COMMENT '班主任信息',
  `cl_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='班级表';

#
# Data for table "classes"
#

INSERT INTO `classes` VALUES (6,3,3,'2016','3','xz(assaas)',''),(8,3,212121,'2015','4','()',''),(10,3,2,'2016','3','xuzhen(dsdsds)',''),(11,2,7,'2016','2','问问(二位)',''),(13,2,2,'2016','2','2',NULL),(14,2,2,'2016','2','2',NULL),(15,2,2,'2016','2','2',NULL),(16,2,2,'2016','2','2',NULL),(19,11,0,'2016','3','()',''),(20,2,NULL,'2016','1','2',NULL),(21,2,NULL,'2016','2','22',NULL),(26,2,3,'2018','1','xz(assaas)',''),(27,2,3,'2018','2','xz(assaas)',''),(28,2,6,'2016','1','233223(23322332)',''),(29,0,3,'2018','1','xz(assaas)',''),(30,3,0,'2018','9','()','');

#
# Structure for table "committee"
#

DROP TABLE IF EXISTS `committee`;
CREATE TABLE `committee` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `classes_id` int(11) DEFAULT NULL COMMENT '班级ID',
  `student_id` int(11) DEFAULT NULL COMMENT '学生ID',
  `co_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='量化委员表';

#
# Data for table "committee"
#

INSERT INTO `committee` VALUES (1,6,80,NULL);

#
# Structure for table "dynamic"
#

DROP TABLE IF EXISTS `dynamic`;
CREATE TABLE `dynamic` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `studentunion_id` varchar(255) DEFAULT NULL COMMENT '学生会ID',
  `classes_id` varchar(255) DEFAULT NULL COMMENT '班级ID',
  `dy_name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `dy_time` int(11) DEFAULT NULL COMMENT '时间',
  `dy_reason` varchar(255) DEFAULT NULL COMMENT '原因',
  `dy_fraction` varchar(255) DEFAULT NULL COMMENT '分数',
  `dy_judge` int(1) DEFAULT '0' COMMENT '判别（0未审核，1通过，2不通过）',
  `dy_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='动态表';

#
# Data for table "dynamic"
#

INSERT INTO `dynamic` VALUES (5,'2','8','23111',1501084800,'3','5',1,'12'),(7,'1','6','12',1496332800,'12','12',1,'12'),(9,'1','8','12',1496678400,'2','2',2,'2'),(10,'2','11','12',1499097600,'12','12',0,'12'),(11,'2','8','12113333',1501084800,'12；；；；','1',2,'1212'),(12,'2','8','2',1499270400,'2','2222',2,''),(13,'2','6','13',1498665600,'13','13',2,''),(14,'2','6','111',1498492800,'11','11',0,'1'),(15,'2','10','1',1467734400,'1','1',0,''),(16,'2','6','1',1500480000,'1','1',1,'1');

#
# Structure for table "gateway"
#

DROP TABLE IF EXISTS `gateway`;
CREATE TABLE `gateway` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ga_number` varchar(255) DEFAULT NULL COMMENT '账号',
  `ga_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `ga_name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `ga_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='门户管理员';

#
# Data for table "gateway"
#

INSERT INTO `gateway` VALUES (1,'gateway','3e21ab62fb17400301d9f0156b6c3031',NULL,NULL);

#
# Structure for table "major"
#

DROP TABLE IF EXISTS `major`;
CREATE TABLE `major` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_majorname` varchar(255) DEFAULT NULL COMMENT '专业名',
  `ma_abbreviation` varchar(255) DEFAULT NULL COMMENT '简称',
  `ma_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='专业表';

#
# Data for table "major"
#

INSERT INTO `major` VALUES (2,'计算机科学与技术','计科1','修改'),(3,'物联网工程','物联网','修改'),(6,'计算机科学与技术','计科',''),(11,'计算机科学与技术','计科111',''),(14,'软工',NULL,'添加'),(15,'软件工程','软工',''),(17,'计算机应用技术','应用','');

#
# Structure for table "overall"
#

DROP TABLE IF EXISTS `overall`;
CREATE TABLE `overall` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) DEFAULT NULL COMMENT '学生ID',
  `ov_week` varchar(255) DEFAULT NULL COMMENT '周次',
  `ov_mouth` varchar(255) DEFAULT NULL COMMENT '月次',
  `ov_wfraction` varchar(255) DEFAULT NULL COMMENT '周总分',
  `ov_mfraction` varchar(255) DEFAULT NULL COMMENT '月总分',
  `ov_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生总分表';

#
# Data for table "overall"
#


#
# Structure for table "student"
#

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `classes_id` int(11) DEFAULT NULL COMMENT '班级id',
  `nt_number` varchar(15) DEFAULT NULL COMMENT '学号',
  `nt_name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `nt_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `nt_sex` int(1) DEFAULT NULL COMMENT '性别（0男，1女）',
  `nt_idnumber` char(18) DEFAULT NULL COMMENT '身份证号',
  `nt_email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `nt_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='学生表';

#
# Data for table "student"
#

INSERT INTO `student` VALUES (10,1,'001','21232f297a57a5a743894a0e4a801fc3','21232f297a57a5a743894a0e4a801fc3',0,'370825199603012331',NULL,'班干部'),(14,1,'2147483646','李四',NULL,1,'370825199603012322',NULL,'普通人员'),(15,1,'2147483645','曹尼',NULL,0,'370825199603012331',NULL,NULL),(16,1,'2147483644','撒阿萨',NULL,1,'370825199603223555',NULL,'王柳'),(18,1,'2147483643','大神',NULL,1,'370825199605768875',NULL,NULL),(19,1,'2147483642','大赛热尔',NULL,1,'370825199603034685',NULL,'普通人员'),(21,1,'2147483641','奋斗',NULL,0,'370825199603034764',NULL,''),(22,1,'2147483640','而热热',NULL,1,'370825199603034634',NULL,NULL),(27,1,'2147483639','大富翁',NULL,1,'370825199603034678',NULL,NULL),(28,2,'21474836224','后台',NULL,0,'370825199603033233',NULL,''),(32,2,'32222222','复古风格',NULL,1,'222222222222222222',NULL,'22222222222222222222'),(33,1,'2147483647','和合格后',NULL,1,'370825199603012330',NULL,'3223'),(34,2,'233232323','都是',NULL,1,'的事实上事实上是事实上事实上事实上事',NULL,'32232323'),(35,2,'3222','热尔',NULL,1,'322',NULL,'2323'),(45,2,'2147483647','3222222222222','2222222222222222222222222222222222',1,'222222222222222222',NULL,'2222222222222222222222222222222222'),(47,2,'111','发货人员贵妇人',NULL,1,'1',NULL,'1'),(49,2,'2323','为丰富的',NULL,1,'额问问二无',NULL,'jhhj'),(52,1,'11111','但是',NULL,0,'11',NULL,'1'),(56,2,NULL,'2332','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,'232332'),(58,2,'3223','3223','e10adc3949ba59abbe56e057f20f883e',0,'323232',NULL,'323232'),(59,2,'0','000000','e10adc3949ba59abbe56e057f20f883e',0,'0000000000000',NULL,'00000000'),(60,2,'0','000000000000','e10adc3949ba59abbe56e057f20f883e',0,'00000000',NULL,'0000'),(64,8,'1','1','21232f297a57a5a743894a0e4a801fc3',0,'1','1','1'),(80,6,'sxn','1','21232f297a57a5a743894a0e4a801fc3',1,'1','1@qq.com','1'),(82,6,'1','1',NULL,0,'1','1','1'),(83,6,'1','1',NULL,0,'1','1',''),(84,6,'2','2',NULL,1,'','',''),(85,6,'2','2',NULL,0,'','',''),(86,6,'','2',NULL,0,'','',''),(87,6,'','2',NULL,0,'','',''),(88,6,'','2',NULL,0,'','',''),(89,6,'2','2',NULL,0,'','',''),(90,6,'11',' 去玩',NULL,1,'11','11@qq.com',''),(91,6,'qq','qq',NULL,1,'','',''),(92,6,'','2222',NULL,0,'','','');

#
# Structure for table "studentunion"
#

DROP TABLE IF EXISTS `studentunion`;
CREATE TABLE `studentunion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `on_department` varchar(255) DEFAULT NULL COMMENT '部门',
  `on_number` char(12) DEFAULT NULL COMMENT '工号',
  `on_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `on_email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `on_distinguish` varchar(255) DEFAULT NULL COMMENT '判别（0部门，1秘书处）',
  `on_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='学生会表';

#
# Data for table "studentunion"
#

INSERT INTO `studentunion` VALUES (1,'秘书处','msc','21232f297a57a5a743894a0e4a801fc3','1@qq.com','1',NULL),(2,'宣传部','sxn','21232f297a57a5a743894a0e4a801fc3','1@qq.com','0','1'),(4,'2','2',NULL,'2','0',''),(5,'宣传部','001',NULL,'2@qq.com','0','1'),(6,'社团部','是素数',NULL,'2@qq.com','0','111');

#
# Structure for table "studscoreinfo"
#

DROP TABLE IF EXISTS `studscoreinfo`;
CREATE TABLE `studscoreinfo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL COMMENT '学生id',
  `fo_time` int(11) DEFAULT NULL COMMENT '加分时间',
  `fo_reason` varchar(255) DEFAULT NULL COMMENT '加分原因',
  `fo_fraction` varchar(255) DEFAULT NULL COMMENT '分数',
  `fo_remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='学生成绩表';

#
# Data for table "studscoreinfo"
#

INSERT INTO `studscoreinfo` VALUES (1,10,1498016524,'好好学习','12',NULL),(2,14,1497930374,'好好学习','232',NULL),(3,15,1497930374,'好好学习','43',NULL),(4,16,1498103255,'好好学习','-45',NULL),(5,18,1498016524,'好好学习','54',NULL),(6,19,1498103255,'好好学习','76',NULL),(7,21,1497930374,'好好学习','22',NULL),(8,22,1498103255,'好好学习','1',NULL),(9,27,1498016524,'好好学习','32',NULL),(10,10,1496073600,'q','45',''),(11,37,1498189731,'对于技术的无上崇拜','56',NULL),(12,40,1498016524,'对于技术的无上崇拜','76',NULL),(13,41,1498103255,'对于技术的无上崇拜','23',NULL),(14,52,1498189731,'对于技术的无上崇拜','65',NULL),(15,55,1498103255,'对于技术的无上崇拜','23',NULL),(16,28,1498189731,'对于技术的无上崇拜','-10',NULL),(17,32,1498103255,'对于技术的无上崇拜','23',NULL),(18,34,1498189731,'对于技术的无上崇拜','454',NULL),(19,35,1498103255,'对于技术的无上崇拜','32',NULL),(20,39,1498189731,'对于技术的无上崇拜','43',NULL),(21,45,1498103255,'好好学习','65',NULL),(22,47,1498189731,'好好学习','2',NULL),(23,49,1498103255,'好好学习','34',NULL),(24,53,1498103255,'好好学习','54',NULL),(25,10,1498189731,'好好学习','-12',NULL),(26,10,1497931374,'对于技术的无上崇拜','23',NULL),(27,10,1497931344,'对于技术的无上崇拜','34',NULL),(28,10,1497931324,'对于技术的无上崇拜','45',NULL),(29,10,1497930374,'对于技术的无上崇拜','12',NULL),(30,NULL,2017,'2112','2323','121221'),(31,NULL,2017,'3232','3232','323223'),(32,NULL,2017,'3434','4334','3434'),(33,NULL,2017,'2112','1221','2121'),(34,NULL,2017,'21122','1212','212121'),(35,NULL,2017,'4343','4334','3434'),(36,NULL,2017,'676767','766767','6767'),(37,NULL,2017,'8778','7878','8787'),(38,NULL,2017,'2332','3223','3223'),(39,10,2017,'2323','23','3223'),(40,10,1496246400,'12',NULL,''),(41,14,1496246400,'23','1','23'),(42,NULL,0,'12','12','12'),(43,78,1499184000,'000','1',''),(44,78,1498579200,'2323','1','2323'),(45,80,1499875200,'11','11','');
