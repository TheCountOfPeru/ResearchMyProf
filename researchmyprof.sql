# Host: localhost  (Version 5.7.17-log)
# Date: 2018-06-12 16:57:12
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
  `name` varchar(256) NOT NULL DEFAULT '',
  `postal_code` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`postal_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "institution"
#


#
# Structure for table "location"
#

CREATE TABLE `location` (
  `postal_code` varchar(256) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  KEY `postal_code` (`postal_code`),
  CONSTRAINT `location_ibfk_1` FOREIGN KEY (`postal_code`) REFERENCES `institution` (`postal_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "location"
#


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


#
# Structure for table "user"
#

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(255) NOT NULL DEFAULT '',
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  `is_mod` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "user"
#


#
# Structure for table "profile"
#

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_creator` int(11) NOT NULL DEFAULT '0',
  `I_postal` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `date_of_birth` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`profile_id`),
  KEY `user_id_creator` (`user_id_creator`),
  KEY `institution_postal` (`I_postal`),
  CONSTRAINT `institution_postal` FOREIGN KEY (`I_postal`) REFERENCES `institution` (`postal_code`),
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id_creator`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "profile"
#


#
# Structure for table "report"
#

CREATE TABLE `report` (
  `profile_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_resolved` datetime DEFAULT '0000-00-00 00:00:00',
  `date_submit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `info` varchar(255) NOT NULL DEFAULT '',
  KEY `profile_id` (`profile_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`),
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "report"
#


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

