<?php
require_once "../config/Database.php";
require_once "../classes/Usuario.php";

$database = new Database();
$db = $database->conectar();

$usuario = new Usuario($db);

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if ($usuario->cadastrar($nome, $email, $senha)) {
        $mensagem = "Usuário cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>

<h2>Cadastro de Usuário</h2>

<p><?php echo $mensagem; ?></p>

<form method="POST">

    <label>Nome</label><br>
    <input type="text" name="nome" required><br><br>

    <label>E-mail</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha</label><br>
    <input type="password" name="senha" required><br><br>

    <button type="submit">Cadastrar</button>

</form>

<br>

<a href="login.php">Ir para Login</a>

</body>
</html>