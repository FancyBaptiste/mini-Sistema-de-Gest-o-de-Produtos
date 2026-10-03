<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/Database.php";
require_once "../classes/Produto.php";
require_once "../classes/Fornecedor.php";

$database = new Database();
$db = $database->conectar();

$produto = new Produto($db);
$fornecedor = new Fornecedor($db);

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $fornecedor_id = $_POST["fornecedor_id"];

    if ($produto->cadastrar($nome, $descricao, $preco, $fornecedor_id)) {
        $mensagem = "Produto cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar produto.";
    }
}

$listaProdutos = $produto->listar();
$listaFornecedores = $fornecedor->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
</head>
<body>

<h2>Cadastro de Produtos</h2>

<p><?php echo $mensagem; ?></p>

<form method="POST">

    <label>Nome</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Descrição</label><br>
    <textarea name="descricao"></textarea><br><br>

    <label>Preço</label><br>
    <input type="number" step="0.01" name="preco" required><br><br>

    <label>Fornecedor</label><br>

    <select name="fornecedor_id" required>

        <option value="">Selecione...</option>

        <?php foreach($listaFornecedores as $f): ?>

            <option value="<?= $f["id"] ?>">
                <?= $f["nome"] ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <button type="submit">Cadastrar Produto</button>

</form>

<hr>

<h2>Produtos cadastrados</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Descrição</th>
    <th>Preço</th>
    <th>Fornecedor</th>
</tr>

<?php foreach($listaProdutos as $item): ?>

<tr>

<td><?= $item["id"] ?></td>
<td><?= $item["nome"] ?></td>
<td><?= $item["descricao"] ?></td>
<td>R$ <?= number_format($item["preco"], 2, ",", ".") ?></td>
<td><?= $item["fornecedor"] ?></td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>