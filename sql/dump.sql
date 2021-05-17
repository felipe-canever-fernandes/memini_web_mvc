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

COMMIT;
