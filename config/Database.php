<?php

class Database
{
    private $host = "localhost";
    private $dbname = "gestao_produtos";
    private $usuario = "root";
    private $senha = "";

    public function conectar()
    {
        try {

            $pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->usuario,
                $this->senha
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {

            die("Erro ao conectar: " . $e->getMessage());

        }
    }
}