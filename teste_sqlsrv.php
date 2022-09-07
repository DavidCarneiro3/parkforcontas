<?php
include("includes/sqlsrv_conexao.php");

$lista = $conn->prepare("SELECT * FROM vwSessoes");
$lista->execute();

print_r($lista);
?>