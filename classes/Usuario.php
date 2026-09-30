<?php

class Usuario
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($email, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (hash('sha256', $senha) === $usuario['senha']) {
                return $usuario;
            }
        }

        return false;
    }

    public function cadastrar($nome, $email, $senha)
    {
        // Criptografa a senha usando SHA-256
        $senhaHash = hash('sha256', $senha);

        $sql = "INSERT INTO usuarios (nome, email, senha)
                VALUES (:nome, :email, :senha)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senhaHash);

        return $stmt->execute();
    }
}