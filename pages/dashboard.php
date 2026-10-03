<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Bem-vindo ao Sistema</h1>

<p>Olá, <?php echo $_SESSION["usuario"]["nome"]; ?>!</p>

<a href="fornecedores.php">Fornecedores</a><br>
<a href="produtos.php">Produtos</a><br>
<a href="cesta.php">Cesta</a><br><br>
<a href="visualizar_cesta.php">Minha Cesta</a><br>

<a href="logout.php">Sair</a>

</body>
</html>