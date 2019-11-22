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
    is_escort BOOLEAN NOT NULL,
    price DECIMAL(7, 2)
);

CREATE TABLE user_fetishes(
    id INT(6) UNSIGNED PRIMARY KEY,
    FOREIGN KEY (id) REFERENCES [user] (id) ON DELETE CASCADE,
    fetish SET('Afeto', 'Anal (ativo)', 'Anal (passivo)', 'Vanilla', 'Carinho pós-coito', 'Fisting', 'Pegging',
        'Bondage', 'Privação sensorial', 'Sadismo', 'Masoquismo', 'Espancamento leve', 'RP geral', 'Diferença de idade',
        'Dominação', 'Submissão', 'Mestre/Escravo', 'Pet play', 'Humilhação', 'Corte', 'Perfuração', 'Sufocamento',
        'Desmaio', 'Golden Shower', 'Escatologia') NULL;
);

CREATE TABLE requests(
    client_id INT(6) NOT NULL,
    escort_id INT(6) NOT NULL,
    PRIMARY KEY (client_id, escort_id),
    FOREIGN KEY (client_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (escort_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE friends(
     client_id INT(6) NOT NULL,
     escort_id INT(6) NOT NULL,
     PRIMARY KEY (client_id, escort_id),
     FOREIGN KEY (client_id) REFERENCES user(id) ON DELETE CASCADE,
     FOREIGN KEY (escort_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE ratings(
    rater_id INT(6) NOT NULL,
    subject_id INT(6) NOT NULL,
    score DECIMAL(1) NOT NULL,
    PRIMARY KEY (rater_id, subject_id),
    FOREIGN KEY (rater_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES user(id) ON DELETE CASCADE
);