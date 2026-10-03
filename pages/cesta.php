<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/database.php";

$database = new Database();
$conn = $database->conectar();

$sql = "SELECT * FROM produtos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Selecionar Produtos</title>
</head>
<body>

<h2>Selecione os Produtos</h2>

<form action="adicionar_cesta.php" method="POST">

<?php foreach ($produtos as $produto): ?>

    <input
        type="checkbox"
        name="produtos[]"
        value="<?= $produto["id"] ?>"
    >

    <?= $produto["nome"] ?>
    -
    R$ <?= number_format($produto["preco"],2,",",".") ?>

    <br><br>

<?php endforeach; ?>

<input type="submit" value="Adicionar à Cesta">

</form>

</body>
</html>