INSERT INTO regions(regiao, estado)
VALUES
    ('Campo das Vertentes', 'MG'),
    ('Central Mineira', 'MG'),
    ('Jequitinhoca', 'MG'),
    ('Metropolitana de Belo Horizonte', 'MG'),
    ('Noroeste de Minas', 'MG'),
    ('Norte de Minas', 'MG'),
    ('Oeste de Minas', 'MG'),
    ('Sul e Sudoeste de Minas', 'MG'),
    ('Triângulo Mineiro de Alto Paranaíba', 'MG'),
    ('Vale do Mucuri', 'MG'),
    ('Vale do Rio Doce', 'MG'),
    ('Zona da Mata', 'MG'),
    ('Distrito Federal', 'DF'),
    ('São José do Rio Preto', 'SP'),
    ('Ribeirão Preto', 'SP'),
    ('Araçaituba', 'SP'),
    ('Bauru', 'SP'),
    ('Araraquara', 'SP'),
    ('Piracicaba', 'SP'),
    ('Campinas', 'SP'),
    ('Presidente Prudente', 'SP'),
    ('Marília', 'SP'),
    ('Assis', 'SP'),
    ('Itapetininga', 'SP'),
    ('Macro Metropolitana Paulista', 'SP'),
    ('Vale do Paraíba Paulista', 'SP'),
    ('Litoral Sul Paulista', 'SP'),
    ('Metropolitana de São Paulo', 'SP'),
    ('Baixadas Litorâneas', 'RJ'),
    ('Centro Fluminense', 'RJ'),
    ('Metropolitana do Rio de Janeiro', 'RJ'),
    ('Noroeste Fluminense', 'RJ'),
    ('Norte Fluminense', 'RJ'),
    ('Sul Fluminense', 'RJ');

INSERT INTO user(name, cpf, email, password_hash, picture_file, gender, gender_identity, is_escort, price, region)
VALUES
('Taco',0,'taco@taco.taco',0,'1.jpg','Feminino','Cisgênero',true,0, 3),
('2B',1,'2b@2b.2b',0,'2.jpg','Feminino','Trans (Não-Operado)',true,0, 6),
('Félix',2,'felix@rezero.nya','62fd1cca53a41d603010606bd514b079bcf6f08ae8f931832d428441d3ce136316b5d3de7858ff2d8ee4915d27501e0d294741dc1bf68e434e81c1c2da1958f2','3.jpg','Masculino','Cisgênero',true,0, 8),
('Astolfo',3,'astolfo@fate.jp',0,'4.jpg','Masculino','Cisgênero',true,0, 3),
('Uke',4,'uke@mummy.egypt',0,'5.jpg','Masculino','Trans (Operado)',true,0, 10),
('Marley',5,'famous@person.com',0,'6.jpg','Outro','Intersexo',true,0, 6);