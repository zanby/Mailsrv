CREATE TABLE `mail_campaignes__callbacks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` varchar(50) NOT NULL,
  `campaign_id` int(11) unsigned NOT NULL,
  `type` enum('before','after') NOT NULL,
  `action` varchar(255) NOT NULL,
  `wsdl` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `mail_campaignes__callbacks_fk` FOREIGN KEY (`campaign_id`) REFERENCES `mail_campaignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mail_campaignes__callbacks_params` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `callback_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `callback_id` (`callback_id`),
  CONSTRAINT `mail_campaignes__callbacks_params_fk` FOREIGN KEY (`callback_id`) REFERENCES `mail_campaignes__callbacks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;