
CREATE TABLE `mail_accounts` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `domain` varchar(255) default NULL,
  `status` enum('active','blocked') default NULL,
  `is_system` smallint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `last_access` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `username_status` (`username`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Data for the `mail_accounts` table  (Records 1 - 2) */

INSERT INTO `mail_accounts` (`id`, `username`, `password`, `domain`, `status`, `is_system`, `created`, `last_access`) VALUES 
  (1, 'bootstrap', 'da99f3e46d77214129864ee5a91fbe78', NULL, 'active', 1, '2010-01-28', '2010-01-28'),
  (2, 'zanby-product', 'c07760dfce716aae492637b11c28a78f', NULL, 'active', 0, '2010-01-28', '2010-01-28');


