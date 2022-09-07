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
      
$query = $mysqli->query("SELECT * FROM centro_custo WHERE centro like '%$nome%'");

if(!$query){
  $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrados.','campo' => $tipo);
}else{
    while($res = $query->fetch_array()){
      $arr[] = $res['centro'];
    }
    

}
echo json_encode($arr);
?>