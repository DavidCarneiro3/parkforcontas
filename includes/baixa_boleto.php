<?php
include("includes/conexao.php");
require_once 'vendor/autoload.php';
require_once 'vendor/marquesjuniorpalmas/webservice-banco-brasil/src/BancoBrasil.php';


use MarquesJunior\Bancos\BancoBrasil;


$dados = ($_POST);
if($_POST['convenio'] == '2184070'){
  $clientid = 'eyJpZCI6ImIyYzY0MWQtMzI1Mi00ZDE5LWE1ZjEtM2YwYTQyIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI0NTI1LCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  $secretid = 'eyJpZCI6ImI0MTY5YWMtMzU1NC00MmJmLWEyNjUtOTAyZWRiZjc4MzQ4MmFjNiIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNDUyNSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ3MDI5OTg1ODYzfQ';
  $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
  $ambiente = 'producao';
  
  
}

if($_POST['convenio'] == '2786559'){
  $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
  $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
  $ambiente = 'producao';
}

if($_POST['convenio'] == '3348211'){
  // $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  // $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
  // $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
  // $ambiente = 'producao';
  // define('CLIENTID', '');
  // define('SECRETID', '');
  // define('DEVELOPER_KEY', '7091b08b0bffbee01364e181b0050d56b9f1a5b8');
  // define('AMBIENTE', 'producao');
}

if($_POST['convenio'] == '3309918'){
  $clientid = 'eyJpZCI6IjU2MDhiMzktMjhlIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkzLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  $secretid = 'eyJpZCI6IjY1ZmZhYjgtMmY5NS00ZWJkLWJhYWItODg2NjdiZGM5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzE5OTg1fQ';
  $developerkey = '7091308b0bffbe101367e18120050b56b971a5bb';
  $ambiente = 'producao';
}

if($_POST['convenio'] == '3468148'){
  $clientid = 'eyJpZCI6ImFiYTVjYjctNGJmNC00NGViLTkxY2EtYjI5ZSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
  $secretid = 'eyJpZCI6Ijg4MmQ1NmQtZWQ4OC00ZTVmLTlmYTgtYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyNTIyfQ';
  $developerkey = '7091708b0effbe80136de18130050e56b9f1a5b8';
  $ambiente = 'producao';
}

if($_POST['convenio'] == '3035927'){
  $clientid = 'eyJpZCI6IjFjZWVlMTUtMzNjOC00MmEwLSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5OCwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
  $secretid = 'eyJpZCI6ImZjMWE5MyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5OCwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyOTQ2fQ';
  $developerkey = '7091808b06ffbef01366e181d0050256b961a5be';
  $ambiente = 'producao';
}
  define('CLIENTID', $clientid);
  define('SECRETID', $secretid);
  define('DEVELOPER_KEY', $developerkey);
  define('AMBIENTE', $ambiente);
  $bb = new MarquesJunior\BancoBrasil\BancoBrasil(CLIENTID, SECRETID, DEVELOPER_KEY, AMBIENTE);

//   $convenio = $dados['convenio'];
$convenio = $_POST['convenio'];
$obs_baixa = $_POST['obs_baixa'];
$status_baixa = $_POST['status_baixa'];
  $id_boleto = '000'.$_POST['num_bol'];
  // $id_boleto = $_POST['num_bol'];
  $baixar['numeroConvenio'] = $convenio;
$hoje = date('d.m.Y');
  $read = $bb->baixaBoleto($id_boleto, $baixar);
  if($read->dataBaixa == $hoje){
    $mysqli->query("UPDATE conta_receber SET obs_baixa_canc = '$obs_baixa', status_baixa_bol = '$status_baixa' WHERE num_boleto = '$id_boleto'");
  }
  $res = array('Res' => $read,'Conv' => $baixar, 'Bol' => $id_boleto, 'app_key' => DEVELOPER_KEY, 'obs_bol' => $obs_baixa, 'status_baixa' => $status_baixa);
  echo json_encode($res, JSON_PRETTY_PRINT);
?>