DROP DATABASE IF EXISTS ferrovia_db;
CREATE DATABASE ferrovia_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ferrovia_db;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  nome VARCHAR(150),
  cargo VARCHAR(80) DEFAULT 'admin',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- admin com senha em TEXTO: lucas123
INSERT INTO usuarios (username, senha, nome, cargo)
VALUES ('admin', 'lucas123', 'Administrador', 'admin');

CREATE TABLE funcionarios (
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
  estado VARCHAR(5),
  localizacao VARCHAR(200),
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE trens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(50) NOT NULL UNIQUE,
  descricao VARCHAR(255),
  capacidade INT DEFAULT 0,
  status ENUM('operacional','manutencao','inativo') DEFAULT 'operacional',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rotas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  origem VARCHAR(150),
  destino VARCHAR(150),
  duracao_min INT,
  ativo TINYINT(1) DEFAULT 1,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Testes
INSERT INTO trens (codigo, descricao, capacidade, status)
VALUES ('TREM-001','Locomotiva Diesel',120,'operacional');

INSERT INTO rotas (nome, origem, destino, duracao_min)
VALUES ('Regional A','Cidade A','Cidade B',120);

INSERT INTO funcionarios (nome, cpf, cargo, email, telefone, cep, rua, bairro, cidade, estado, localizacao)
VALUES ('João Silva','123.456.789-00','Maquinista','joao@exemplo.com','(48)99999-0000','88010000','Rua Exemplo','Centro','Florianópolis','SC','Depósito Central');
