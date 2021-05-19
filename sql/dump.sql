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
    (`name`,	    `email`,                                    `hashed_password`,                                              `is_administrator`)

VALUES
--                                                              060193
    ('Felipe',		'felipe.canever.fernandes@outlook.com',     '$2y$10$33buAp7lQlCf2AetVfKjeuJ6AR9zf7PtoNqVZKRKuqm.Xi4wPL52K', TRUE),
--                                                              081293
    ('Lucas',		'lucas.canever.fernandes@outlook.com',      '$2y$10$tZsYlcu6mGp/SblPIO5KZecgR7axryX/Le8IQv1H98PWIxKA0rCeO', FALSE),
--                                                              120400
    ('Matheus',		'matheus.canever.fernandes@outlook.com',    '$2y$10$9JUyCEwUUXksBmLXEDdp9.eSI24scg3aR8nKCspWP0M5KMSs4.BYy', FALSE);


-- Decks
INSERT INTO `avii_desenvweb`.`deck`
    (`user_id`,	`title`,				`description`)
VALUES
--  Felipe
    (1,			'Latim',				'Palavras em latim.'),
    (1,			'Francês',				'Palavras em francês.'),
    (1,			'Nomes científicos',	''),
--  Lucas
    (2,			'Inglês',				'Palavras em inglês.'),
    (2,			'Tabela periódica',		'Elementos da tabela periódica.'),
--  Matheus
    (3,			'C++',					'');

-- Cards
INSERT INTO `avii_desenvweb`.`card`
    (`user_id`,	`deck_id`,	`front`,			    `back`)
VALUES
    -- Felipe
    -- Latim
    (1,			1,			'domus',				'casa'),
    (1,			1,			'familia',				'família'),
    (1,			1,			'vir',					'homem'),
    (1,			1,			'fēmina',				'mulher'),
    (1,			1,			'puer',					'menino'),
    (1,			1,			'puella',				'menina'),
    (1,			1,			'īnfāns',				'bebê'),
    (1,			1,			'canis',				'cachorro'),
    (1,			1,			'fēlēs',				'gato'),
    (1,			1,			'avis',					'passarinho'),
    -- Francês
    (1,			2,			'maison',				'casa'),
    (1,			2,			'famille',				'família'),
    (1,			2,			'homme',				'homem'),
    (1,			2,			'femme',				'mulher'),
    (1,			2,			'garçon',				'menino'),
    (1,			2,			'fille',				'menina'),
    (1,			2,			'bébé',					'bebê'),
    (1,			2,			'chien',				'cachorro'),
    (1,			2,			'chat',					'gato'),
    -- Nomes científicos
    (1,			3,			'ser humano',			'Homo sapiens'),
    (1,			3,			'chimpanzé',			'Pan troglodytes'),
    (1,			3,			'cachorro',				'Canis familiaris'),
    (1,			3,			'gato',					'Felis cattus'),
    (1,			3,			'pardal',				'Passer domesticus'),
    (1,			3,			'barata',				'Periplaneta americana'),
    (1,			3,			'laranjeira',			'Citrus × sinensis'),
    (1,			3,			'champignon',			'Agaricus bisporus'),

    -- Lucas
    -- Inglês
    (2,			4,			'house',				'casa'),
    (2,			4,			'family',				'família'),
    (2,			4,			'man',					'homem'),
    (2,			4,			'woman',				'mulher'),
    (2,			4,			'boy',					'menino'),
    (2,			4,			'girl',					'menina'),
    (2,			4,			'baby',					'bebê'),
    -- Tabela periódica
    (2,			5,			'H',					'hidrogênio'),
    (2,			5,			'He',					'hélio'),
    (2,			5,			'Li',					'lítio'),
    (2,			5,			'Be',					'berílio'),
    (2,			5,			'B',					'boro'),
    (2,			5,			'C',					'carbono'),

    -- Matheus
    -- C++
    (3,			6,			'função principal',		'int main()'),
    (3,			6,			'incluir biblioteca',	'#include <...>'),
    (3,			6,			'biblioteca de E/S',	'iostream'),
    (3,			6,			'saída',				'std::cout << ...;'),
    (3,			6,			'entrada',				'std::cin >> ...;');

COMMIT;
