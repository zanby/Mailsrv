DELETE FROM `mail_campaignes`;
ALTER TABLE `mail_campaignes` ADD COLUMN `uid` VARCHAR(50) NOT NULL UNIQUE AFTER `id`;
