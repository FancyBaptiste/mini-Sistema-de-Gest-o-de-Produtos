<?php

class Cesta
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Adiciona um produto na cesta
    public function adicionar($usuario_id, $produto_id)
    {
        // Verifica se o usuário já possui uma cesta
        $sql = "SELECT id FROM cestas WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $cesta = $stmt->fetch(PDO::FETCH_ASSOC);
            $cesta_id = $cesta["id"];
        } else {
            // Cria uma nova cesta
            $sql = "INSERT INTO cestas(usuario_id) VALUES(:usuario_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->execute();

            $cesta_id = $this->conn->lastInsertId();
        }

        // Adiciona o produto à cesta
        $sql = "INSERT INTO cesta_produtos(cesta_id, produto_id)
                VALUES(:cesta_id, :produto_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":cesta_id", $cesta_id);
        $stmt->bindParam(":produto_id", $produto_id);

        return $stmt->execute();
    }

    // Lista os produtos da cesta
    public function listar($usuario_id)
    {
        $sql = "SELECT p.*
                FROM produtos p
                INNER JOIN cesta_produtos cp
                    ON cp.produto_id = p.id
                INNER JOIN cestas c
                    ON c.id = cp.cesta_id
                WHERE c.usuario_id = :usuario_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}