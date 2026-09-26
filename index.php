<?php

require "config/Database.php";

$database = new Database();

$conexao = $database->conectar();

echo "<h1>Conexão realizada com sucesso!</h1>";

?>