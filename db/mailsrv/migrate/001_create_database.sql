/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

SET FOREIGN_KEY_CHECKS=0;

#
# Structure for the `mail_campaignes` table : 
#

DROP TABLE IF EXISTS `mail_campaignes`;

CREATE TABLE `mail_campaignes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subject` varchar(255) default NULL,
  `body_html` longtext,
  `body_plain` longtext,
  `delivery_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `status` enum('new','started','in_progress','processed','sended') NOT NULL default 'new',
  `start_date` datetime default NULL,
  `in_progress_date` datetime default NULL,
  `processed_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`,`delivery_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `mail_campaignes__images` table : 
#

DROP TABLE IF EXISTS `mail_campaignes__images`;

CREATE TABLE `mail_campaignes__images` (
  `id` int(11) NOT NULL auto_increment,
  `campaign_id` int(11) unsigned NOT NULL,
  `image_name` varchar(255) default NULL,
  `image_source` longtext NOT NULL,
  `image_content_type` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__images_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `mail_campaignes__params` table : 
#

DROP TABLE IF EXISTS `mail_campaignes__params`;

CREATE TABLE `mail_campaignes__params` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `campaign_id` int(11) unsigned NOT NULL,
  `name` varchar(255) default NULL,
  `value` text,
  PRIMARY KEY  (`id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__params_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `mail_campaignes__raw` table : 
#

DROP TABLE IF EXISTS `mail_campaignes__raw`;

CREATE TABLE `mail_campaignes__raw` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `campaign_id` int(11) unsigned NOT NULL,
  `subject` varchar(255) default NULL,
  `body_html` longtext,
  `body_plain` longtext,
  `message` longtext,
  PRIMARY KEY  (`id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__raw_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `mail_campaignes__recipients` table : 
#

DROP TABLE IF EXISTS `mail_campaignes__recipients`;

CREATE TABLE `mail_campaignes__recipients` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `campaign_id` int(11) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) default NULL,
  `params` longtext,
  `create_date` datetime NOT NULL,
  `status` enum('new','in_progress','processed') NOT NULL default 'new',
  `in_progress_date` datetime default NULL,
  `processed_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__recipients_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `mail_campaignes__senders` table : 
#

DROP TABLE IF EXISTS `mail_campaignes__senders`;

CREATE TABLE `mail_campaignes__senders` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `campaign_id` int(11) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `campaigne_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__senders_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
