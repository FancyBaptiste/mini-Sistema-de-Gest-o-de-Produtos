<?php

class Produto
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($nome, $descricao, $preco, $fornecedor_id)
    {
        $sql = "INSERT INTO produtos (nome, descricao, preco, fornecedor_id)
                VALUES (:nome, :descricao, :preco, :fornecedor_id)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":fornecedor_id", $fornecedor_id);

        return $stmt->execute();
    }

    public function listar()
    {
        $sql = "SELECT
                    produtos.*,
                    fornecedores.nome AS fornecedor
                FROM produtos
                INNER JOIN fornecedores
                    ON produtos.fornecedor_id = fornecedores.id
                ORDER BY produtos.nome";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM produtos WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nome, $descricao, $preco, $fornecedor_id)
    {
        $sql = "UPDATE produtos
                SET nome = :nome,
                    descricao = :descricao,
                    preco = :preco,
                    fornecedor_id = :fornecedor_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":fornecedor_id", $fornecedor_id);

        return $stmt->execute();
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM produtos WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}