<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/database.php";

$database = new Database();
$conn = $database->conectar();

if (!isset($_POST["produtos"])) {
    die("Nenhum produto selecionado.");
}

$idUsuario = $_SESSION["usuario"]["id"];
$produtos = $_POST["produtos"];

// Cria uma nova cesta
$sql = "INSERT INTO cestas (usuario_id) VALUES (:usuario)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":usuario", $idUsuario);
$stmt->execute();

$idCesta = $conn->lastInsertId();

// Salva os produtos da cesta
foreach ($produtos as $produto) {

    $sql = "INSERT INTO cesta_produtos (cesta_id, produto_id)
            VALUES (:cesta, :produto)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":cesta", $idCesta);
    $stmt->bindParam(":produto", $produto);
    $stmt->execute();
}

echo "<h2>Cesta criada com sucesso!</h2>";
echo '<a href="dashboard.php">Voltar ao Dashboard</a>';
?>