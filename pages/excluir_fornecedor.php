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

if (isset($_GET["id"])) {

    $fornecedor->excluir($_GET["id"]);

}

header("Location: fornecedores.php");
exit;