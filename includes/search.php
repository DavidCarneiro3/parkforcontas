<?php
session_start();
date_default_timezone_set('America/Fortaleza');
header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
  header("Content-type: application/json; charset=utf-8");
  header("Content-type: text/plain; charset=utf-8");
ob_clean();
include('conexao.php');
include('funcoes.php');

$nome = $_GET['term'];
      
$query = $mysqli->query("SELECT * FROM fornecedores WHERE fornecedor like '%$nome%'");

if(!$query){
  $result = array('result' => 'error', 'error' => 'Empresas não encontradas.','campo' => $tipo);
}else{
    while($res = $query->fetch_array()){
      $arr[] = $res['fornecedor'];
    }
    

}
echo json_encode($arr);
?>