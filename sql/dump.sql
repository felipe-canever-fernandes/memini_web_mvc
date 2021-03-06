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
)
ENGINE = INNODB;

-- Deck
CREATE TABLE `avii_desenvweb`.`deck`(
    `deck_id`		INT 			NOT NULL	AUTO_INCREMENT,
    `user_id`		INT 			NOT NULL,
    `title`			VARCHAR(128)	NOT NULL,
    `description`	VARCHAR(255)	NOT NULL	DEFAULT '',

    PRIMARY KEY	(`deck_id`),
    FOREIGN KEY	(`user_id`)	REFERENCES	`avii_desenvweb`.`user`	(`user_id`) ON DELETE CASCADE
)
ENGINE = INNODB;

-- Card
CREATE TABLE `avii_desenvweb`.`card`(
    `card_id`			INT 			NOT NULL	AUTO_INCREMENT,

    `user_id`			INT 			NOT NULL,
    `deck_id`			INT 			NOT NULL,

    `front`				VARCHAR(255)	NOT NULL,
    `back`				VARCHAR(255)	NOT NULL,

    `repetition_count`	INT 			NOT NULL	DEFAULT 0,
    `time_interval`		INT 			NOT NULL	DEFAULT 0,
    `ease_factor`		REAL 			NOT NULL	DEFAULT 2.5,

    PRIMARY KEY	(`card_id`),

    FOREIGN KEY	(`user_id`)	REFERENCES	`avii_desenvweb`.`user`	(`user_id`),
    FOREIGN KEY	(`deck_id`)	REFERENCES	`avii_desenvweb`.`deck`	(`deck_id`) ON DELETE CASCADE
)
ENGINE = INNODB;

-- Users
INSERT INTO `avii_desenvweb`.`user`
    (`name`,	        `email`,                                    `hashed_password`,                                              `is_administrator`)

VALUES
    ('Administrator',   'admin@admin.com',                      '$2y$10$x7lXtPf/OvCjr76rR5D67.Jr6JSjctrSSFc2BWPQ2vzFpUTeVBTzW', TRUE),
    ('User',		    'user@user.com',                        '$2y$10$gYTelaDbYqYz.19LrS8YZeqSytgzdvh6ArYKQQAD6KlfpJEcfSpL6', FALSE);


-- Decks
INSERT INTO `avii_desenvweb`.`deck`
    (`user_id`,	`title`,				`description`)
VALUES
--  Felipe
    (1,			'Latim',				'Palavras em latim.'),
    (1,			'Franc??s',				'Palavras em franc??s.'),
    (1,			'Nomes cient??ficos',	''),
--  Lucas
    (2,			'Ingl??s',				'Palavras em ingl??s.'),
    (2,			'Tabela peri??dica',		'Elementos da tabela peri??dica.');

-- Cards
INSERT INTO `avii_desenvweb`.`card`
    (`user_id`,	`deck_id`,	`front`,			    `back`)
VALUES
    -- Administrator
    -- Latim
    (1,			1,			'domus',				'casa'),
    (1,			1,			'familia',				'fam??lia'),
    (1,			1,			'vir',					'homem'),
    (1,			1,			'f??mina',				'mulher'),
    (1,			1,			'puer',					'menino'),
    (1,			1,			'puella',				'menina'),
    (1,			1,			'??nf??ns',				'beb??'),
    (1,			1,			'canis',				'cachorro'),
    (1,			1,			'f??l??s',				'gato'),
    (1,			1,			'avis',					'passarinho'),
    -- Franc??s
    (1,			2,			'maison',				'casa'),
    (1,			2,			'famille',				'fam??lia'),
    (1,			2,			'homme',				'homem'),
    (1,			2,			'femme',				'mulher'),
    (1,			2,			'gar??on',				'menino'),
    (1,			2,			'fille',				'menina'),
    (1,			2,			'b??b??',					'beb??'),
    (1,			2,			'chien',				'cachorro'),
    (1,			2,			'chat',					'gato'),
    -- Nomes cient??ficos
    (1,			3,			'ser humano',			'Homo sapiens'),
    (1,			3,			'chimpanz??',			'Pan troglodytes'),
    (1,			3,			'cachorro',				'Canis familiaris'),
    (1,			3,			'gato',					'Felis cattus'),
    (1,			3,			'pardal',				'Passer domesticus'),
    (1,			3,			'barata',				'Periplaneta americana'),
    (1,			3,			'laranjeira',			'Citrus ?? sinensis'),
    (1,			3,			'champignon',			'Agaricus bisporus'),

    -- User
    -- Ingl??s
    (2,			4,			'house',				'casa'),
    (2,			4,			'family',				'fam??lia'),
    (2,			4,			'man',					'homem'),
    (2,			4,			'woman',				'mulher'),
    (2,			4,			'boy',					'menino'),
    (2,			4,			'girl',					'menina'),
    (2,			4,			'baby',					'beb??'),
    -- Tabela peri??dica
    (2,			5,			'H',					'hidrog??nio'),
    (2,			5,			'He',					'h??lio'),
    (2,			5,			'Li',					'l??tio'),
    (2,			5,			'Be',					'ber??lio'),
    (2,			5,			'B',					'boro'),
    (2,			5,			'C',					'carbono');

COMMIT;
