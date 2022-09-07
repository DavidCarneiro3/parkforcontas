<?php
// date_default_timezone_set('America/Fortaleza');
// header("Access-Control-Allow-Origin: *");
//   header("Access-Control-Allow-Credentials: true");
//   header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
//   header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
//   header("Content-type: application/json; charset=utf-8");
//   header("Content-type: text/plain; charset=utf-8");
// ob_clean();
// include('conexao.php');
// include('funcoes.php');
// ---------------dados para boletos BB------------------------
// sandbox

$ambiente = "sandbox";

if($ambiente == 'sandbox'){
  $clientID = "eyJpZCI6ImYyYjA3NGUtMDI4ZC00OGZiLTk3MjItOGMiLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6Mjk0NDEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxfQ";
  
  $client_secret = "eyJpZCI6IjEzZjc0OTctOTVlNy00NTk1LTg0IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI5NDQxLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MSwic2VxdWVuY2lhbENyZWRlbmNpYWwiOjEsImFtYmllbnRlIjoiaG9tb2xvZ2FjYW8iLCJpYXQiOjE2NDQ1MDQ0MzcwNjl9";
  
  $app_key = "d27bc77909ffab70136ae17d70050356b9c1a5ba";
  
  $urlToken = 'https://oauth.sandbox.bb.com.br/oauth/token';
  $urls = 'https://api.sandbox.bb.com.br/cobrancas/v2';
  $ambiente = $ambiente;
}else{
  $urlToken = 'https://oauth.bb.com.br/oauth/token';
  $urls = 'https://api.bb.com.br/cobrancas/v2';
  $ambiente = $ambiente;
}

function fields(array $fields, string $format="json") {
  if($format == "json") {
      return $fields = (!empty($fields) ? json_encode($fields) : null);
  }
  if($format == "query"){
      return $fields = (!empty($fields) ? http_build_query($fields) : null);
  }
}

function getToken(){
  
  $fields['grant_type'] = 'client_credentials';
  $fields['scope'] = 'cobrancas.boletos-info cobrancas.boletos-requisicao';
  $fields = fields($fields,'query');



  $ci = curl_init($GLOBALS['urlToken']);
  curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ci, CURLOPT_POST, true);
  curl_setopt($ci, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ci, CURLOPT_HTTPHEADER, [
      "Content-Type: application/x-www-form-urlencoded",
      'Authorization: Basic '. base64_encode( $GLOBALS['clientID'].':'.$GLOBALS['client_secret']).''
  ]);
  
  $resposta = curl_exec($ci);
  curl_close($ci);
  
  $resultado = json_decode($resposta);
  
  return $resultado;
}
//-------------------- FIM ------------------------------------
// 
function geraBoleto($params){
  //$params['documento'];
  $convenio = "3128557";
  //$insc = $params['inscricao'];
  $insc = "74910037000193";
  $find = array("(",")","-"," ");
  $fone = str_replace($find,"",$params['fone']);
  $token = getToken();
  //print_r($token);
  //echo $token->access_token;
  if(strlen($insc) == 11){
  $tipoInsc = 1;
  }else if(strlen($insc) == 14){
  $tipoInsc = 2;
  }
  $num = rand(1, 9999);
  $nossoNumero = "000".$convenio.str_pad($num,10,"0", STR_PAD_RIGHT);
  $hoje = date("d/m/Y");
  $venc = somadata(2,$hoje);
  $postfields = array(
                  "numeroConvenio"=> intval($convenio),
                  "numeroCarteira"=>17,
                  "numeroVariacaoCarteira"=>35,
                  "codigoModalidade"=>1,
                  "dataEmissao"=> date("d.m.Y"),
                  "dataVencimento"=> str_replace("/",".",$venc),
                  "valorOriginal"=> floatval($params['total']),
                  "valorAbatimento"=>0,
                  "quantidadeDiasProtesto"=> 3,
                  "quantidadeDiasNegativacao"=>0,
                  "orgaoNegativador"=>'0',
                  "indicadorAceiteTituloVencido"=>"S",
                  "numeroDiasLimiteRecebimento"=>3,
                  "codigoAceite"=>"A",
                  "codigoTipoTitulo"=>2,
                  "descricaoTipoTitulo"=>"DM",
                  "indicadorPermissaoRecebimentoParcial"=>"N",
                  "numeroTituloBeneficiario"=>"123456",
                  "campoUtilizacaoBeneficiario"=>"UM TEXTO",
                  "numeroTituloCliente"=> $nossoNumero,
                  "mensagemBloquetoOcorrencia"=>"Outro texto",
                  "desconto"=> array(
                  "tipo"=>0,
                  "dataExpiracao"=>"",
                  "porcentagem"=>0,
                  "valor"=>0
                  ),
                  "segundoDesconto"=> array(
                  "dataExpiracao"=>"",
                  "porcentagem"=>0,
                  "valor"=>0
                  ), 
                  "terceiroDesconto"=> array(
                  "dataExpiracao"=>"",
                  "porcentagem"=>0,
                  "valor"=>0
                  ),
                  "jurosMora"=> array(
                      "tipo"=>0,
                      "porcentagem"=>0,
                      "valor"=>0
                  ),
                  "multa"=> array(
                      "tipo"=>0,
                      "data"=>"",
                      "porcentagem"=>0,
                      "valor"=>0
                  ),
                  "pagador"=> array(
                      "tipoInscricao"=> $tipoInsc,
                      "numeroInscricao"=> intval($insc),
                      "nome"=> $params['cliente'],
                      "endereco"=> $params['endereco'],
                      "cep"=> str_replace(".","",str_replace("-","",$params['cep'])),
                      "cidade"=> $params['cidade'],
                      "bairro"=> $params['bairro'],
                      "uf"=> $params['uf'],
                      "telefone"=> $fone
                  ),
                  "beneficiarioFinal"=> array(
                      "tipoInscricao"=>2,
                      "numeroInscricao"=>98959112000179,
                      "nome"=>"Dirceu Borboleta"
                  ),
                  "indicadorPix"=>"S"
                );
  try{
  $curl = curl_init();
  if ($curl === false) {
  throw new Exception('failed to initialize');
  }
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sandbox.bb.com.br/cobrancas/v2/boletos?gw-dev-app-key='.$GLOBALS['app_key'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  //CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem',
  CURLOPT_SSL_VERIFYPEER => false,
  CURLINFO_HEADER_OUT => true,
  CURLOPT_POSTFIELDS => json_encode($postfields),
  CURLOPT_HTTPHEADER => array(
      'accept: application/json',
      'Authorization: Bearer '.$token->access_token,
      'Content-Type: application/json',
      //'X-Developer-Application-Key : '.$GLOBALS['app_key'].''
  ),
  CURLOPT_VERBOSE => TRUE,
  ));

  $response = curl_exec($curl);
  if ($response === false) {
  throw new Exception(curl_error($curl), curl_errno($curl));
  }

  curl_close($curl);
}catch(Exception $e){
$err = array('erro' => 'Curl failed with error'.$e->getCode().': '.$e->getMessage(), 'key' => $GLOBALS['app_key']);
  echo json_encode($err);
  // trigger_error(sprintf(
  //   'Curl failed with error #%d: %s',
  //   $e->getCode(), $e->getMessage()),
   // E_USER_ERROR);
}
  if($response){
    //$resultado = array('response' => json_decode($response));
    return json_decode($response);
  }
  
}
?>