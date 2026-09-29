<?php

require_once "database.php";

$database = new Database();
$pdo = $database->conectar();

$sql = "

CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(64) NOT NULL
);

CREATE TABLE IF NOT EXISTS fornecedores(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS produtos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2),
    fornecedor_id INT,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
);

CREATE TABLE IF NOT EXISTS cestas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS cesta_produtos(
    cesta_id INT,
    produto_id INT,
    PRIMARY KEY(cesta_id,produto_id),
    FOREIGN KEY(cesta_id) REFERENCES cestas(id),
    FOREIGN KEY(produto_id) REFERENCES produtos(id)
);

";

$pdo->exec($sql);

echo "Tabelas criadas com sucesso!";