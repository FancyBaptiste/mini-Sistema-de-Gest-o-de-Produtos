<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/Database.php";
require_once "../classes/Fornecedor.php";

$database = new Database();
$db = $database->conectar();

$fornecedor = new Fornecedor($db);

// Busca o fornecedor
if (!isset($_GET["id"])) {
    header("Location: fornecedores.php");
    exit;
}

$id = $_GET["id"];
$dados = $fornecedor->buscarPorId($id);

// Atualiza o fornecedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $fornecedor->editar($id, $nome, $telefone, $email);

    header("Location: fornecedores.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Fornecedor</title>
</head>
<body>

<h2>Editar Fornecedor</h2>

<form method="POST">

    <label>Nome</label><br>
    <input type="text" name="nome"
        value="<?= $dados["nome"] ?>" required><br><br>

    <label>Telefone</label><br>
    <input type="text" name="telefone"
        value="<?= $dados["telefone"] ?>"><br><br>

    <label>E-mail</label><br>
    <input type="email" name="email"
        value="<?= $dados["email"] ?>"><br><br>

    <button type="submit">Salvar Alterações</button>

</form>

<br>

<a href="fornecedores.php">Voltar</a>

</body>
</html>