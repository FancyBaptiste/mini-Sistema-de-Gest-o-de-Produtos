<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/database.php";

$database = new Database();
$conn = $database->conectar();

$usuario = $_SESSION["usuario"]["id"];

$sql = "SELECT
            p.nome,
            p.preco
        FROM cesta_produtos cp
        INNER JOIN cestas c
            ON cp.cesta_id = c.id
        INNER JOIN produtos p
            ON cp.produto_id = p.id
        WHERE c.usuario_id = :usuario";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":usuario", $usuario);
$stmt->execute();

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
$quantidade = count($produtos);

foreach ($produtos as $produto) {
    $total += $produto["preco"];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Minha Cesta</title>
</head>

<body>

<h2>Minha Cesta</h2>

<table border="1" cellpadding="10">

<tr>
    <th>Produto</th>
    <th>Preço</th>
</tr>

<?php foreach($produtos as $produto): ?>

<tr>

<td><?= $produto["nome"] ?></td>

<td>R$ <?= number_format($produto["preco"],2,",",".") ?></td>

</tr>

<?php endforeach; ?>

</table>

<br>

<h3>Resumo</h3>

<p>

Quantidade de produtos:

<strong><?= $quantidade ?></strong>

</p>

<p>

Valor Total:

<strong>

R$ <?= number_format($total,2,",",".") ?>

</strong>

</p>

<br>

<a href="dashboard.php">Voltar</a>

</body>
</html>