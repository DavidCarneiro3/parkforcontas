<?php
//session_start();
// CONEXAO, N�O MECHER

//$mysqli = new mysqli ("localhost", "david", "david@123", "contas");
//$mysqli = new mysqli ("contas_bd.mysql.dbaas.com.br", "contas_bd", "contas@123", "contas_bd");
//$mysqli = new mysqli ("park_contas.mysql.dbaas.com.br", "park_contas", "contas@123", "park_contas");
$mysqli = new mysqli ("localhost", "u939380865_parkfor", "Contas@123", "u939380865_parkfor_contas");

$mysqli->query("SET NAMES 'utf8'"); 
$mysqli->query("SET CHARACTER SET utf8");  
$mysqli->query("SET SESSION collation_connection = 'utf8_unicode_ci'"); 

if (mysqli_connect_errno()) {
   echo 'Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error();
}
?>