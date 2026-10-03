<?php
session_start();

require_once "../config/database.php";
require_once "../classes/Usuario.php";

$database = new Database();
$db = $database->conectar();

$usuario = new Usuario($db);

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $resultado = $usuario->login($email, $senha);

    if ($resultado) {

        $_SESSION["usuario"] = $resultado;

        header("Location: dashboard.php");
        exit;

    } else {

        $mensagem = "E-mail ou senha inválidos.";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if($mensagem != ""): ?>
<p style="color:red;"><?php echo $mensagem; ?></p>
<?php endif; ?>

<form method="POST">

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha</label><br>
    <input type="password" name="senha" required><br><br>

    <button type="submit">Entrar</button>

</form>

</body>
</html>