ALTER TABLE `mail_campaignes` MODIFY COLUMN `status` ENUM('new','wait','started','in_progress','processed','sended') NOT NULL DEFAULT 'new';
ALTER TABLE `mail_campaignes` MODIFY COLUMN `status` ENUM('new','wait','started','in_progress','processed','sended','canceled') NOT NULL DEFAULT 'new';