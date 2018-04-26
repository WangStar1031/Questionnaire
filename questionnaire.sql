# Host: localhost  (Version 5.5.5-10.1.19-MariaDB)
# Date: 2018-04-24 23:13:50
# Generator: MySQL-Front 6.0  (Build 1.121)


#
# Structure for table "course"
#

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "course"
#

INSERT INTO `course` VALUES (1,'ENGLISH 1'),(2,'English 2'),(3,'English 3'),(4,'English4'),(5,'English 5');

#
# Structure for table "teacher"
#

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CourseId` varchar(255) DEFAULT NULL,
  `UserNumber` varchar(255) DEFAULT NULL,
  `FamilyName` varchar(255) DEFAULT NULL,
  `GivenName` varchar(255) DEFAULT NULL,
  `UserPassword` varchar(255) DEFAULT NULL,
  `eMail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "teacher"
#

INSERT INTO `teacher` VALUES (1,'1','0001','Wang','Xing','123guraud!','123@123.com'),(2,'1','0002','Wang','XX','123123','1234@1234.com'),(3,'1','0003','Wang','X','1234','1234'),(4,'1','q','q','q','q','q'),(5,'1','1','1','1','1','1'),(6,'1','1','1','1','1','1');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CourseId` varchar(255) DEFAULT NULL,
  `UserNumber` varchar(255) DEFAULT NULL,
  `FamilyName` varchar(255) DEFAULT NULL,
  `GivenName` varchar(255) DEFAULT NULL,
  `UserPassword` varchar(255) DEFAULT NULL,
  `eMail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,NULL,NULL,'admin',NULL,'admin12345',NULL),(2,'1','1110','Wang','X',NULL,''),(3,'1','1111','Wang','XX',NULL,'1233'),(4,'1','1112','Wang','XXX',NULL,''),(5,'1','1113','Will','De',NULL,''),(6,'1','1114','Will','DD',NULL,''),(10,'1','123','123','123',NULL,'123');
