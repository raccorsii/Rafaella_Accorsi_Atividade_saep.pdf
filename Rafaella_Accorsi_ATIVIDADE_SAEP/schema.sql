-- Tabela eleitor
CREATE TABLE eleitor (
    id_eleitor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    numero_titulo VARCHAR(50) NOT NULL,
    cidade VARCHAR(100)
);

-- Tabela candidato
CREATE TABLE candidato (
    id_candidato INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    numero_candidato VARCHAR(20) NOT NULL,
    cargo VARCHAR(100),
    partido_ficticio VARCHAR(100)
);

INSERT INTO eleitor (nome, numero_titulo, cidade) VALUES
('Ana Souza', 'TIT001', 'Santo André'),
('Bruno Lima', 'TIT002', 'Mauá');

INSERT INTO candidatos (nome, numero_candidato, cargo, partido_ficticio) VALUES
('Candidato Alfa', '10', 'Representante', 'Partido Exemplo A'),
('Candidato Beta', '20', 'Representante', 'Partido Exemplo B');
