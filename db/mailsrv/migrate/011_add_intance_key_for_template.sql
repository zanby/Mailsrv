ALTER TABLE `mail_templates`  ADD COLUMN `instanceKey` VARCHAR(20) NOT NULL AFTER `uid`;
ALTER TABLE `mail_templates`  CHANGE COLUMN `uid` `uid` VARCHAR(80) NOT NULL AFTER `id`;
ALTER TABLE `mail_templates`  CHANGE COLUMN `instanceKey` `instanceKey` VARCHAR(40) NOT NULL AFTER `uid`;
ALTER TABLE `mail_templates`  DROP INDEX `uid`,  ADD UNIQUE INDEX `uid` (`uid`, `instanceKey`);