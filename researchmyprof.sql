# Host: localhost  (Version 5.7.17-log)
# Date: 2018-06-20 15:04:49
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "edit_history"
#

CREATE TABLE `edit_history` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_edited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edit_reason` varchar(255) DEFAULT NULL,
  KEY `profile_id` (`profile_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `edit_history_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`),
  CONSTRAINT `edit_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "edit_history"
#


#
# Structure for table "institution"
#

CREATE TABLE `institution` (
  `postal_code` varchar(255) NOT NULL DEFAULT '',
  `i_name` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`postal_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "institution"
#

INSERT INTO `institution` VALUES ('CB21TN','University of Cambridge'),('H3A0G4','McGill University'),('OX12JD','University of Oxford'),('T1K3M4','University of Lethbridge'),('T2N1N4','University of Calgary'),('T4N5H5','Red Deer College'),('T6G2R3','University of Alberta');

#
# Structure for table "location"
#

CREATE TABLE `location` (
  `postal_code` varchar(256) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  KEY `location_ibfk_1` (`postal_code`),
  CONSTRAINT `location_ibfk_1` FOREIGN KEY (`postal_code`) REFERENCES `institution` (`postal_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "location"
#

INSERT INTO `location` VALUES ('H3A0G4','Canada','Montreal'),('T4N5H5','Canada','Red Deer'),('T6G2R3','Canada','Edmonton'),('T2N1N4','Canada','Calgary'),('CB21TN','Britain','Cambridge'),('T1K3M4','Canada','Lethbridge'),('OX12JD','Britain','Oxford');

#
# Structure for table "publication"
#

CREATE TABLE `publication` (
  `name` varchar(256) NOT NULL DEFAULT '',
  `link_to` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "publication"
#

INSERT INTO `publication` VALUES ('Simple and effective behavior tracking by post processing of association rules into segments','https://ieeexplore.ieee.org/document/6118896/');

#
# Structure for table "topic"
#

CREATE TABLE `topic` (
  `name` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "topic"
#

INSERT INTO `topic` VALUES ('Art'),('Astronomy'),('Biology'),('Chemistry'),('Computer Science'),('Economics'),('Engineering'),('English'),('Geology'),('Geophysics'),('History'),('Math'),('Music'),('Neuroscience'),('Physics'),('Zoology');

#
# Structure for table "related_to"
#

CREATE TABLE `related_to` (
  `Tname` varchar(255) NOT NULL DEFAULT '0',
  `Pname` varchar(255) NOT NULL DEFAULT '',
  KEY `Tname` (`Tname`),
  KEY `Pname` (`Pname`),
  CONSTRAINT `related_to_ibfk_1` FOREIGN KEY (`Tname`) REFERENCES `topic` (`name`),
  CONSTRAINT `related_to_ibfk_2` FOREIGN KEY (`Pname`) REFERENCES `publication` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "related_to"
#

INSERT INTO `related_to` VALUES ('Computer Science','Simple and effective behavior tracking by post processing of association rules into segments');

#
# Structure for table "user"
#

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(255) NOT NULL DEFAULT '',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_mod` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'admin','2018-06-13 18:12:27','admin',1,0),(6,'mod','2018-06-13 18:13:14','mod',0,1),(7,'user','2018-06-13 18:13:26','user',0,0);

#
# Structure for table "profile"
#

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_creator` int(11) DEFAULT NULL,
  `I_postal` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`profile_id`),
  KEY `user_id_creator` (`user_id_creator`),
  KEY `institution_postal` (`I_postal`),
  CONSTRAINT `institution_postal` FOREIGN KEY (`I_postal`) REFERENCES `institution` (`postal_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id_creator`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "profile"
#

INSERT INTO `profile` VALUES (1,1,'T2N1N4','Tamer Jarada'),(2,1,'T2N1N4','Tamer Jarada2'),(3,1,'T6G2R3','Some One');

#
# Structure for table "report"
#

CREATE TABLE `report` (
  `profile_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_resolved` datetime DEFAULT NULL,
  `date_submit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `info` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`date_submit`),
  KEY `profile_id` (`profile_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`),
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "report"
#

INSERT INTO `report` VALUES (1,7,'2018-06-18 21:45:59','2018-06-17 19:32:07','Its all wrong!'),(1,7,NULL,'2018-06-18 21:45:59','asdasd');

#
# Structure for table "authored"
#

CREATE TABLE `authored` (
  `profile_id` int(11) NOT NULL DEFAULT '0',
  `Pname` varchar(255) DEFAULT NULL,
  KEY `profile_id` (`profile_id`),
  KEY `Pname` (`Pname`),
  CONSTRAINT `authored_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`),
  CONSTRAINT `authored_ibfk_2` FOREIGN KEY (`Pname`) REFERENCES `publication` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "authored"
#

INSERT INTO `authored` VALUES (1,'Simple and effective behavior tracking by post processing of association rules into segments');

#
# Structure for table "interested_in"
#

CREATE TABLE `interested_in` (
  `profile_id` int(11) NOT NULL DEFAULT '0',
  `Tname` varchar(255) NOT NULL DEFAULT '',
  KEY `profile_id` (`profile_id`),
  KEY `tname` (`Tname`),
  CONSTRAINT `interested_in_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`),
  CONSTRAINT `tname` FOREIGN KEY (`Tname`) REFERENCES `topic` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "interested_in"
#

INSERT INTO `interested_in` VALUES (1,'Computer Science'),(2,'Physics'),(3,'Computer Science'),(1,'Math');

#
# Structure for table "worked_with"
#

CREATE TABLE `worked_with` (
  `profile_idA` int(11) NOT NULL DEFAULT '0',
  `profile_idB` int(11) NOT NULL DEFAULT '0',
  KEY `profile_idA` (`profile_idA`),
  KEY `profile_idB` (`profile_idB`),
  CONSTRAINT `worked_with_ibfk_1` FOREIGN KEY (`profile_idA`) REFERENCES `profile` (`profile_id`),
  CONSTRAINT `worked_with_ibfk_2` FOREIGN KEY (`profile_idB`) REFERENCES `profile` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "worked_with"
#

