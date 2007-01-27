
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- channel
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `channel`;


CREATE TABLE `channel`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`topic` TEXT(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- channel_nick
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `channel_nick`;


CREATE TABLE `channel_nick`
(
	`channel_id` INTEGER  NOT NULL,
	`nick_id` INTEGER  NOT NULL,
	PRIMARY KEY (`channel_id`,`nick_id`),
	CONSTRAINT `channel_nick_FK_1`
		FOREIGN KEY (`channel_id`)
		REFERENCES `channel` (`id`)
		ON DELETE CASCADE,
	INDEX `channel_nick_FI_2` (`nick_id`),
	CONSTRAINT `channel_nick_FK_2`
		FOREIGN KEY (`nick_id`)
		REFERENCES `nick` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- irc_identity
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `irc_identity`;


CREATE TABLE `irc_identity`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `irc_identity_FI_1` (`user_id`),
	CONSTRAINT `irc_identity_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- nick
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `nick`;


CREATE TABLE `nick`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nick` VARCHAR(255)  NOT NULL,
	`irc_identity_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `nick_FI_1` (`irc_identity_id`),
	CONSTRAINT `nick_FK_1`
		FOREIGN KEY (`irc_identity_id`)
		REFERENCES `irc_identity` (`id`)
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;


CREATE TABLE `user`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(255)  NOT NULL,
	`password` VARCHAR(255)  NOT NULL,
	`is_active` VARCHAR(255)  NOT NULL,
	`is_admin` VARCHAR(255)  NOT NULL,
	`ts_registered` DATETIME  NOT NULL,
	`ts_lastlogin` DATETIME  NOT NULL,
	`locale` VARCHAR(255) default 'en@locale=Europe/London' NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
