CREATE TABLE `mail_campaignes__headers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `campaign_id` int(11) unsigned NOT NULL,
  `name` varchar(255) character set latin1 NOT NULL,
  `value` text character set latin1,
  PRIMARY KEY  (`id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__headers_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;