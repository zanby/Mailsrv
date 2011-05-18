ALTER TABLE `mail_campaignes__callbacks` MODIFY COLUMN `type` ENUM('before','after','recipients') NOT NULL;
ALTER TABLE `mail_campaignes` ADD COLUMN `pmb_subject` VARCHAR(255) DEFAULT NULL AFTER `body_plain`;
ALTER TABLE `mail_campaignes` ADD COLUMN `pmb_message` LONGTEXT AFTER `pmb_subject`;
ALTER TABLE `mail_templates__localizations` ADD COLUMN `pmb_subject` VARCHAR(255) DEFAULT NULL AFTER `body_plain`;
ALTER TABLE `mail_templates__localizations` ADD COLUMN `pmb_message` LONGTEXT AFTER `pmb_subject`;
ALTER TABLE `mail_campaignes__raw` ADD COLUMN `pmb_subject` VARCHAR(255) DEFAULT NULL AFTER `body_plain`;
ALTER TABLE `mail_campaignes__raw` ADD COLUMN `pmb_message` LONGTEXT AFTER `pmb_subject`;