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

<p>Olá, <?php echo $_SESSION["usuario"]; ?>!</p>

<a href="logout.php">Sair</a>

</body>
</html>