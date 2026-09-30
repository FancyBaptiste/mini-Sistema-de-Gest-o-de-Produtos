<?php

class Fornecedor
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($nome, $telefone, $email)
    {
        $sql = "INSERT INTO fornecedores (nome, telefone, email)
                VALUES (:nome, :telefone, :email)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":email", $email);

        return $stmt->execute();
    }

    public function listar()
    {
        $sql = "SELECT * FROM fornecedores ORDER BY nome";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
{
    $sql = "SELECT * FROM fornecedores WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function editar($id, $nome, $telefone, $email)
{
    $sql = "UPDATE fornecedores
            SET nome = :nome,
                telefone = :telefone,
                email = :email
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":email", $email);

    return $stmt->execute();
}

public function excluir($id)
{
    $sql = "DELETE FROM fornecedores WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);

    return $stmt->execute();
}
}