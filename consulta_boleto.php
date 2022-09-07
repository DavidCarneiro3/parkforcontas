<?php
require_once 'vendor/autoload.php';
require_once 'vendor/marquesjuniorpalmas/webservice-banco-brasil/src/BancoBrasil.php';


use MarquesJunior\Bancos\BancoBrasil;


//CONSULTAR BOLETO
function consultaBol($dados){
  //$dadosc = unserialize($_POST['dadosc']);
  if($dados['convenio'] == '2184070'){
    $clientid = 'eyJpZCI6ImIyYzY0MWQtMzI1Mi00ZDE5LWE1ZjEtM2YwYTQyIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI0NTI1LCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6ImI0MTY5YWMtMzU1NC00MmJmLWEyNjUtOTAyZWRiZjc4MzQ4MmFjNiIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNDUyNSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ3MDI5OTg1ODYzfQ';
    $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    $ambiente = 'producao';
    
    
  }
  
  if($dados['convenio'] == '2786559'){
    $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
    $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3348211'){
    // $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    // $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
    // $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    // $ambiente = 'producao';
    // define('CLIENTID', '');
    // define('SECRETID', '');
    // define('DEVELOPER_KEY', '7091b08b0bffbee01364e181b0050d56b9f1a5b8');
    // define('AMBIENTE', 'producao');
  }
  
  if($dados['convenio'] == '3309918'){
    $clientid = 'eyJpZCI6IjU2MDhiMzktMjhlIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkzLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6IjY1ZmZhYjgtMmY5NS00ZWJkLWJhYWItODg2NjdiZGM5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzE5OTg1fQ';
    $developerkey = '7091308b0bffbe101367e18120050b56b971a5bb';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3468148'){
    $clientid = 'eyJpZCI6ImFiYTVjYjctNGJmNC00NGViLTkxY2EtYjI5ZSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
    $secretid = 'eyJpZCI6Ijg4MmQ1NmQtZWQ4OC00ZTVmLTlmYTgtYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyNTIyfQ';
    $developerkey = '7091708b0effbe80136de18130050e56b9f1a5b8';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3035927'){
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
    $convenio = $dados['convenio'];

    $id_boleto = $dados['nosso_num'];
    $numeroConvenio = $convenio;

    $read = $bb->readBoleto($id_boleto, $numeroConvenio);
    $res = array('Res' => $read,'Conv' => $numeroConvenio, 'Bol' => $id_boleto, 'app_key' => DEVELOPER_KEY);
    return json_encode($read, JSON_PRETTY_PRINT);
}

//LISTAR BOLETOS
function listabol($parameters){
  
  if($parameters){
    $dados = $parameters;
  }else{
    $dados = unserialize($_POST['dadosc']);
  }
  // $dados = unserialize($_POST['dadosc']);
  if($dados['convenio'] == '2184070'){
    $clientid = 'eyJpZCI6ImIyYzY0MWQtMzI1Mi00ZDE5LWE1ZjEtM2YwYTQyIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI0NTI1LCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6ImI0MTY5YWMtMzU1NC00MmJmLWEyNjUtOTAyZWRiZjc4MzQ4MmFjNiIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNDUyNSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ3MDI5OTg1ODYzfQ';
    $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    $ambiente = 'producao';
    
    
  }
  
  if($dados['convenio'] == '2786559'){
    $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
    $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3348211'){
    // $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    // $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
    // $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    // $ambiente = 'producao';
    // define('CLIENTID', '');
    // define('SECRETID', '');
    // define('DEVELOPER_KEY', '7091b08b0bffbee01364e181b0050d56b9f1a5b8');
    // define('AMBIENTE', 'producao');
  }
  
  if($dados['convenio'] == '3309918'){
    $clientid = 'eyJpZCI6IjU2MDhiMzktMjhlIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkzLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6IjY1ZmZhYjgtMmY5NS00ZWJkLWJhYWItODg2NjdiZGM5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzE5OTg1fQ';
    $developerkey = '7091308b0bffbe101367e18120050b56b971a5bb';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3468148'){
    $clientid = 'eyJpZCI6ImFiYTVjYjctNGJmNC00NGViLTkxY2EtYjI5ZSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
    $secretid = 'eyJpZCI6Ijg4MmQ1NmQtZWQ4OC00ZTVmLTlmYTgtYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyNTIyfQ';
    $developerkey = '7091708b0effbe80136de18130050e56b9f1a5b8';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3035927'){
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

    $tmpa = explode('-',$dados['agencia']);
    $agencia = $tmpa[0];

    $tmpc = explode('-',$dados['conta']);
    $conta = $tmpc[0];
    $situacao = $dados['situacao'];

    $cod_situacao = $dados['cod_situacao'];
    if($dados['data_reg_ini'] && $dados['data_reg_fin']){
      $data_reg_ini = recebedata($dados['data_reg_ini']);
      $data_reg_fin = recebedata($dados['data_reg_fin']);
    }
    if($dados['data_venc_ini'] && $dados['data_venc_fin']){
      $data_venc_ini = recebedata($dados['data_venc_ini']);
      $data_venc_fin = recebedata($dados['data_venc_fin']);
    }
    

    $read = $bb->listaBoleto($agencia, $conta,$situacao,$cod_situacao,$data_reg_ini,$data_reg_fin,$data_venc_ini,$data_venc_fin);
    $res = array('Res' => $read,'Ag' => $agencia, 'Conta' => $conta, 'app_key' => DEVELOPER_KEY, 'params' => $parameters, 'dados' => $dados, 'dt_reg' => $data_reg_ini.' '.$data_reg_fin);
    return json_encode($read, JSON_PRETTY_PRINT);
}

//BAIXA/CANCELAMENTO BOLETO
function baixaBol(){
  $dados = unserialize($_POST['dadosc']);
  if($dados['convenio'] == '2184070'){
    $clientid = 'eyJpZCI6ImIyYzY0MWQtMzI1Mi00ZDE5LWE1ZjEtM2YwYTQyIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI0NTI1LCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6ImI0MTY5YWMtMzU1NC00MmJmLWEyNjUtOTAyZWRiZjc4MzQ4MmFjNiIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNDUyNSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ3MDI5OTg1ODYzfQ';
    $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    $ambiente = 'producao';
    
    
  }
  
  if($dados['convenio'] == '2786559'){
    $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
    $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3348211'){
    // $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    // $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
    // $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
    // $ambiente = 'producao';
    // define('CLIENTID', '');
    // define('SECRETID', '');
    // define('DEVELOPER_KEY', '7091b08b0bffbee01364e181b0050d56b9f1a5b8');
    // define('AMBIENTE', 'producao');
  }
  
  if($dados['convenio'] == '3309918'){
    $clientid = 'eyJpZCI6IjU2MDhiMzktMjhlIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkzLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
    $secretid = 'eyJpZCI6IjY1ZmZhYjgtMmY5NS00ZWJkLWJhYWItODg2NjdiZGM5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzE5OTg1fQ';
    $developerkey = '7091308b0bffbe101367e18120050b56b971a5bb';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3468148'){
    $clientid = 'eyJpZCI6ImFiYTVjYjctNGJmNC00NGViLTkxY2EtYjI5ZSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
    $secretid = 'eyJpZCI6Ijg4MmQ1NmQtZWQ4OC00ZTVmLTlmYTgtYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyNTIyfQ';
    $developerkey = '7091708b0effbe80136de18130050e56b9f1a5b8';
    $ambiente = 'producao';
  }
  
  if($dados['convenio'] == '3035927'){
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

    $convenio = $dados['convenio'];

    $id_boleto = $dados['nosso_num'];
    $baixar['numeroConvenio'] = $convenio;

    $read = $bb->baixaBoleto($id_boleto, $baixar);
    $res = array('Res' => $read,'Conv' => $convenio, 'Bol' => $id_boleto, 'app_key' => DEVELOPER_KEY);
    return json_encode($read, JSON_PRETTY_PRINT);
}

?>