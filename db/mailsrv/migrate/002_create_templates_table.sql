CREATE TABLE `mail_templates` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` varchar(50) NOT NULL,
  `description` text,
  `create_date` datetime NOT NULL,
  `last_used` datetime default NULL,
  `status` enum('pending','active','blocked') NOT NULL default 'pending',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mail_templates__localizations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `template_id` int(11) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `subject` varchar(255) default NULL,
  `body_html` longtext,
  `body_plain` longtext,
  `is_default` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `mail_templates__localizations_fk` FOREIGN KEY (`template_id`) REFERENCES `mail_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mail_templates__localizations_images` (
  `id` int(11) NOT NULL auto_increment,
  `localization_id` int(11) unsigned NOT NULL,
  `image_name` varchar(255) default NULL,
  `image_source` longtext NOT NULL,
  `image_content_type` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `localization_id` (`localization_id`),
  CONSTRAINT `mail_templates__localizations_images_fk` FOREIGN KEY (`localization_id`) REFERENCES `mail_templates__localizations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

ALTER TABLE `mail_campaignes` ADD COLUMN `template_id` INTEGER(11) UNSIGNED DEFAULT NULL AFTER `id`;
ALTER TABLE `mail_campaignes` ADD INDEX  (`template_id`);
ALTER TABLE `mail_campaignes` ADD CONSTRAINT `mail_campaignes_fk` FOREIGN KEY (`template_id`) REFERENCES `mail_templates` (`id`) ON DELETE SET NULL;

ALTER TABLE `mail_campaignes__raw` ADD COLUMN `locale` VARCHAR(5) DEFAULT NULL AFTER `campaign_id`;
ALTER TABLE `mail_campaignes__raw` ADD COLUMN `is_default_locale` SMALLINT(1) DEFAULT NULL AFTER `locale`;

ALTER TABLE `mail_campaignes__recipients` ADD COLUMN `locale` VARCHAR(5) DEFAULT NULL AFTER `name`;