START TRANSACTION;

DROP DATABASE IF EXISTS `avii_desenvweb`;

CREATE DATABASE `avii_desenvweb`;

-- User
CREATE TABLE `avii_desenvweb`.`user`(
    `user_id`	        INT 			NOT NULL	AUTO_INCREMENT,
    `name`	            VARCHAR(255)	NOT NULL,
    `email`	            VARCHAR(127)	NOT NULL,
    `hashed_password`	VARCHAR(255)	NOT NULL,
    `is_administrator`  BOOLEAN         NOT NULL    DEFAULT FALSE,

    PRIMARY KEY (`user_id`),
    UNIQUE KEY  (`email`)
);

-- Users
INSERT INTO `avii_desenvweb`.`user` (`name`,	    `email`,                                `hashed_password`,                                              `is_administrator`)
VALUES								("Felipe",		"felipe.canever.fernandes@outlook.com", "$2y$10$33buAp7lQlCf2AetVfKjeuJ6AR9zf7PtoNqVZKRKuqm.Xi4wPL52K", TRUE);

COMMIT;
