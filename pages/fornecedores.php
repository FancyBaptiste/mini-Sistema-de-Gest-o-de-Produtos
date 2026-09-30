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

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    if ($fornecedor->cadastrar($nome, $telefone, $email)) {
        $mensagem = "Fornecedor cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar fornecedor.";
    }
}

$lista = $fornecedor->listar();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Fornecedores</title>
</head>

<body>

<h2>Cadastro de Fornecedores</h2>

<p><?php echo $mensagem; ?></p>

<form method="POST">

    <label>Nome</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Telefone</label><br>
    <input type="text" name="telefone"><br><br>

    <label>E-mail</label><br>
    <input type="email" name="email"><br><br>

    <button type="submit">Cadastrar</button>

</form>

<hr>

<h2>Fornecedores cadastrados</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Telefone</th>
    <th>Email</th>
</tr>
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Telefone</th>
    <th>Email</th>
    <th>Ações</th>
</tr>

<?php foreach($lista as $item): ?>

<tr>

    <td><?= $item["id"] ?></td>

    <td><?= $item["nome"] ?></td>

    <td><?= $item["telefone"] ?></td>

    <td><?= $item["email"] ?></td>

    <td>

        <a href="editar_fornecedor.php?id=<?= $item['id'] ?>">
            Editar
        </a>

        |

        <a href="excluir_fornecedor.php?id=<?= $item['id'] ?>"
           onclick="return confirm('Deseja realmente excluir este fornecedor?')">
            Excluir
        </a>

    </td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>