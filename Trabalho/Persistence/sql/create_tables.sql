CREATE DATABASE gabriels_picker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE gabriels_picker;

CREATE TABLE regions(
	region_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	estado SET("AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE",
		"PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO") NOT NULL,
	regiao VARCHAR(64)
);

CREATE TABLE user(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(32) NOT NULL,
	email VARCHAR(32) UNIQUE NOT NULL,
	password_hash CHAR(128) NOT NULL,
	picture_file VARCHAR(32) NULL,
	cpf DECIMAL(11) UNIQUE NOT NULL,
	gender ENUM('Masculino', 'Feminino', 'Outro') NOT NULL,
	gender_identity ENUM('Cisgênero', 'Trans (Não-Operado)', 'Trans (Operado)', 'Intersexo', 'Outro') NOT NULL,
	contact VARCHAR(128) NULL,
	region INT(6) UNSIGNED NULL,
	is_escort BOOLEAN NOT NULL,
	price DECIMAL(7, 2) NULL DEFAULT 0,
	is_admin BOOLEAN NOT NULL DEFAULT FALSE,
	FOREIGN KEY (region) REFERENCES regions(region_id) ON DELETE SET NULL
);

CREATE TABLE requests(
	client_id INT(6) UNSIGNED NOT NULL,
	escort_id INT(6) UNSIGNED NOT NULL,
	PRIMARY KEY (client_id, escort_id),
	FOREIGN KEY (client_id) REFERENCES user(id) ON DELETE CASCADE,
	FOREIGN KEY (escort_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE friends(
	 client_id INT(6) UNSIGNED NOT NULL,
	 escort_id INT(6) UNSIGNED NOT NULL,
	 PRIMARY KEY (client_id, escort_id),
	 FOREIGN KEY (client_id) REFERENCES user(id) ON DELETE CASCADE,
	 FOREIGN KEY (escort_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE dates(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	day DATE NOT NULL ,
	user1 INT(6) UNSIGNED NOT NULL,
	user2 INT(6) UNSIGNED NOT NULL,
	region INT(6) UNSIGNED,
	FOREIGN KEY (user1) REFERENCES user(id) ON DELETE CASCADE,
	FOREIGN KEY (user2) REFERENCES user(id) ON DELETE CASCADE,
	FOREIGN KEY (region) REFERENCES regions(region_id) ON DELETE SET NULL
);