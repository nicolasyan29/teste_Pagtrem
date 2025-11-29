-- banco_combinado.sql (definitivo)
CREATE DATABASE IF NOT EXISTS ferrovia_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ferrovia_db;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  nome VARCHAR(150) DEFAULT NULL,
  cargo VARCHAR(80) DEFAULT 'usuario',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS funcionarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  cpf VARCHAR(20),
  cargo VARCHAR(100),
  email VARCHAR(120),
  telefone VARCHAR(30),
  cep VARCHAR(10),
  rua VARCHAR(255),
  bairro VARCHAR(150),
  cidade VARCHAR(150),
  estado VARCHAR(3),
  localizacao VARCHAR(200),
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS trens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(50) NOT NULL UNIQUE,
  descricao VARCHAR(255),
  capacidade INT DEFAULT 0,
  status ENUM('operacional','manutencao','inativo') DEFAULT 'operacional',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rotas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  origem VARCHAR(150),
  destino VARCHAR(150),
  duracao_min INT,
  ativo TINYINT(1) DEFAULT 1,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS manutencoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  trem_id INT NOT NULL,
  descricao TEXT,
  data_prevista DATE,
  concluido TINYINT(1) DEFAULT 0,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (trem_id) REFERENCES trens(id) ON DELETE CASCADE
);

-- admin: senha 'admin123' (troque depois)
INSERT INTO usuarios (username, senha, nome, cargo)
VALUES ('admin', '$2y$10$7V3g6ZzQn2dN4qWJf8j5Quy6kL8a1y0PqS8r5m6t1u2v3w4x5y6z7', 'Administrador', 'admin');

-- dados de teste
INSERT INTO trens (codigo, descricao, capacidade, status) VALUES ('TREM-001','Locomotiva Diesel',120,'operacional');
INSERT INTO rotas (nome, origem, destino, duracao_min) VALUES ('Regional A','Cidade A','Cidade B',120);
INSERT INTO manutencoes (trem_id, descricao, data_prevista) VALUES (1,'Troca de óleo e inspeção geral', DATE_ADD(CURDATE(), INTERVAL 7 DAY));
INSERT INTO funcionarios (nome, cpf, cargo, email, telefone, cep, rua, bairro, cidade, estado, localizacao)
VALUES ('João Silva','123.456.789-00','Maquinista','joao@exemplo.com','(48)99999-0000','88010000','Rua Exemplo','Centro','Florianópolis','SC','Depósito Central');
