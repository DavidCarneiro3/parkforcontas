<style>
  .icon-error{
    font-size: 34px;
    color: #268ac1;
}
.text-error{
    font-size: 18px;
    color: #ccc;
    font-weight: bolder;
}
</style>
<?php

require_once 'vendor/autoload.php';
require_once 'vendor/marquesjuniorpalmas/webservice-banco-brasil/src/BancoBrasil.php';

include("includes/funcoes.php");
include("includes/load.php");
include("includes/conexao.php");

// if($dadosc[convenio] == ){
//   require_once 'includes/configteste.php';
// }

$dadosc = unserialize($_POST['dadosc']);
if($dadosc['convenio'] == '2184070'){
  $clientid = 'eyJpZCI6ImIyYzY0MWQtMzI1Mi00ZDE5LWE1ZjEtM2YwYTQyIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI0NTI1LCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  $secretid = 'eyJpZCI6ImI0MTY5YWMtMzU1NC00MmJmLWEyNjUtOTAyZWRiZjc4MzQ4MmFjNiIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNDUyNSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ3MDI5OTg1ODYzfQ';
  $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
  $ambiente = 'producao';
  
  
}

if($dadosc['convenio'] == '2786559'){
  $clientid = 'eyJpZCI6Ijc1IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkyLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  $secretid = 'eyJpZCI6IjJhZTlkMDMtNzE3ZS00ZDFlLTg2NGUtNmJkMmNhYjlmNDZhNzgxYzUxOWEtYzcxNS0iLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MjUwOTIsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY0ODQ4ODcwMTE1M30';
  $developerkey = '7091608b01ffbe40136de181d0050756b901a5b6';
  $ambiente = 'producao';
}

if($dadosc['convenio'] == '3348211'){
  $clientid = 'eyJpZCI6IjE3YzM4YmEtMDI3Zi00NzJlLSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjozMTA2OCwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
  $secretid = 'eyJpZCI6IjJhY2QwMjItZjY0ZS00ODAiLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6MzEwNjgsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxLCJzZXF1ZW5jaWFsQ3JlZGVuY2lhbCI6MSwiYW1iaWVudGUiOiJwcm9kdWNhbyIsImlhdCI6MTY1OTcyOTUxNzY3Mn0';
  $developerkey = '7091108b00ffbe301368e18120050b56b9a1a5b6';
  $ambiente = 'producao';
//   define('CLIENTID', '');
//   define('SECRETID', '');
//   define('DEVELOPER_KEY', '7091b08b0bffbee01364e181b0050d56b9f1a5b8');
//   define('AMBIENTE', 'producao');
}

if($dadosc['convenio'] == '3309918'){
  $clientid = 'eyJpZCI6IjU2MDhiMzktMjhlIiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI1MDkzLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MX0';
  $secretid = 'eyJpZCI6IjY1ZmZhYjgtMmY5NS00ZWJkLWJhYWItODg2NjdiZGM5MCIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5Mywic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzE5OTg1fQ';
  $developerkey = '7091308b0bffbe101367e18120050b56b971a5bb';
  $ambiente = 'producao';
}

if($dadosc['convenio'] == '3468148'){
  $clientid = 'eyJpZCI6ImFiYTVjYjctNGJmNC00NGViLTkxY2EtYjI5ZSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
  $secretid = 'eyJpZCI6Ijg4MmQ1NmQtZWQ4OC00ZTVmLTlmYTgtYyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5NSwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyNTIyfQ';
  $developerkey = '7091708b0effbe80136de18130050e56b9f1a5b8';
  $ambiente = 'producao';
}

if($dadosc['convenio'] == '3035927'){
  $clientid = 'eyJpZCI6IjFjZWVlMTUtMzNjOC00MmEwLSIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5OCwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjF9';
  $secretid = 'eyJpZCI6ImZjMWE5MyIsImNvZGlnb1B1YmxpY2Fkb3IiOjAsImNvZGlnb1NvZnR3YXJlIjoyNTA5OCwic2VxdWVuY2lhbEluc3RhbGFjYW8iOjEsInNlcXVlbmNpYWxDcmVkZW5jaWFsIjoxLCJhbWJpZW50ZSI6InByb2R1Y2FvIiwiaWF0IjoxNjQ4NDg4NzUyOTQ2fQ';
  $developerkey = '7091808b06ffbef01366e181d0050256b961a5be';
  $ambiente = 'producao';
}
  define('CLIENTID', $clientid);
  define('SECRETID', $secretid);
  define('DEVELOPER_KEY', $developerkey);
  define('AMBIENTE', $ambiente);

// echo DEVELOPER_KEY;

use MarquesJunior\Bancos\BancoBrasil;

use Dompdf\Dompdf;
use Dompdf\Options;

$bb = new MarquesJunior\BancoBrasil\BancoBrasil(CLIENTID, SECRETID, DEVELOPER_KEY, AMBIENTE);


$hoje = date("d/m/Y");
$vencimento = $dadosc['datavenc'];

$fk_empresa = $dadosc['fk_empresa'];
$convenio = $dadosc['convenio'];
$dadosseq = ['fk_empresa' => $fk_empresa, 'convenio' => $dadosc['convenio']];
print_r($dadosseq);
$getSeq = json_decode(seqBol($dadosseq));
print_r($getSeq);
$num = $getSeq->datas;
if(!$num){
  $num = 1;
}else{
  $num = $num + 1;
}

if($dadosc['tipo_cliente'] == 'PJ'){
  $tipo = 2;
}else{
  $tipo = 1;
}

$tmp = str_replace('-','',$dadosc['cep']);
$cep = str_replace('.','',$tmp);


$nossoNumero = "000".$convenio.str_pad($num,10,"0", STR_PAD_RIGHT);

$carteira = '17';
$variacao_carteira = '19';
$modalidade = '1';
$data_emissao = $hoje;
$data_vencimento = $vencimento;
$valor_original = $dadosc['valor'];
$codigo_aceite = 'N';
$codigo_tipo_titulo = '2';
$receber_parcial = 'N';
if($dadosc['multa_bol']>0){
  $cobrar_multa = 'S';
}else{
  $cobrar_multa = 'N';
}
if($dadosc['juros_bol']>0){
  $cobrar_juros = 'S';
}else{
  $cobrar_juros = 'N';
}
$numero_titulo_cliente = $nossoNumero;
$quantidadeDiasProtesto = $dadosc['dias_protesto'];
$quantidadeDiasNegativacao = $dadosc['dias_negativa'];
$numeroDiasLimiteRecebimento = $dadosc['dias_venc'];

if($dadosc['multa_bol']>0){
  $tipo_multa = '2';
  $valor_multa = $dadosc['multa_bol'];
}
if($dadosc['juros_bol']>0){
  $tipo_juros = '2';
  $valor_juros = $dadosc['juros_bol'];
  $data_multa = somadata(1,$vencimento);
}



$pagador_tipo_doc = $tipo;
$pagador_doc = $dadosc['cnpj_cli'];
$pagador_nome = $dadosc['cliente'];
$pagador_endereco = $dadosc['endereco'];
$pagador_cep = $cep;
$pagador_cidade = ($dadosc['cidade'])?$dadosc['cidade']:'Fortaleza';
$pagador_bairro = $dadosc['bairro'];
$pagador_uf = $dadosc['uf'];



$post_create['numeroConvenio'] = $convenio;
$post_create['numeroCarteira'] = $carteira;
$post_create['numeroVariacaoCarteira'] = $variacao_carteira;
$post_create['codigoModalidade'] = $modalidade;
$post_create['dataEmissao'] = str_replace('/','.',$data_emissao);
$post_create['dataVencimento'] = str_replace('/','.',$data_vencimento);
$post_create['valorOriginal'] = $valor_original;
$post_create['codigoAceite'] = $codigo_aceite;
$post_create['codigoTipoTitulo'] = $codigo_tipo_titulo;
$post_create['indicadorPermissaoRecebimentoParcial'] = $receber_parcial;
$post_create['indicadorCobrarJuros'] = $cobrar_juros;
$post_create['indicadorCobrarMulta'] = $cobrar_multa;
$post_create['numeroTituloCliente'] = $numero_titulo_cliente;
$post_create['numeroDiasLimiteRecebimento'] = $numeroDiasLimiteRecebimento;
$post_create['quantidadeDiasProtesto'] = $quantidadeDiasProtesto;
$post_create['quantidadeDiasNegativacao'] = $quantidadeDiasNegativacao;

if($dadosc['juros_bol']>0){
  $post_create['juros_mora']['tipo'] = $tipo_juros;
  $post_create['juros_mora']['porcentagem'] = $valor_juros;
}

if($dadosc['multa_bol']>0){
  $post_create['multa']['tipo'] = $tipo_multa;
  $post_create['multa']['porcentagem'] = $valor_multa;
  $post_create['multa']['data'] = str_replace('/','.',$data_multa);
}


$post_create['pagador']['tipoInscricao'] = $pagador_tipo_doc;
$post_create['pagador']['numeroInscricao'] = $pagador_doc;
$post_create['pagador']['nome'] = $pagador_nome;
$post_create['pagador']['endereco'] = $pagador_endereco;
$post_create['pagador']['cep'] = $pagador_cep;
$post_create['pagador']['cidade'] = $pagador_cidade;
$post_create['pagador']['bairro'] = $pagador_bairro;
$post_create['pagador']['uf'] = $pagador_uf;

$post_create['indicadorPix'] = 'N';

$retorno = $bb->registerBoleto($post_create);
//echo '<pre>';

$dadosb = objectToArray($retorno);

if($dadosd['numero']){}
function objectToArray ($object) {
    if(!is_object($object) && !is_array($object)){
    	return $object;
    }
    return array_map('objectToArray', (array) $object);
}
// $dadosc = unserialize($_POST['dadosc']);

if(!$dadosb['numero']){
  ?>
  <div class="text-center">
       <label class="icon-error">:(</label>
       <p class="text-error">Erro ao registrar boleto, verifique se as informações de Cedente e Pagador estão corretas e tente novamente.</p>
   </div>
   <?php
  print_r($dadosb);
  echo '<br><br>';
  print_r($dadosc);
   echo '<br><br>';
  print_r($post_create);
}else{
  $dias_de_prazo_para_pagamento = $numeroDiasLimiteRecebimento;
$taxa_boleto = 0.00;
// $data_venc = date(recebedata($dadosc['dt_doc']), time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$data_venc = $dadosc['datavenc']; 
$valor_cobrado = $dadosc['valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $dadosb['numero'];
$dadosboleto["numero_documento"] = $dadosc['id_conta'];	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// $dadosboleto["codigo_barras"] = $dadosb['codigoBarraNumerico']; 	// Código de barras do boleto
// $dadosboleto["linha_digitavel"] = $dadosb['linhaDigitavel']; 	// Código de barras do boleto

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $dadosc['cliente'];
$dadosboleto["endereco1"] = $dadosc['endereco'].', '.$dadosc['bairro'];
$dadosboleto["endereco2"] = $dadosc['cidade'].' - '.$dadosc['uf'].' - '.$dadosc['cep'];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $dadosc['descricao'];
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";

// INSTRUÇÕES PARA O CAIXA
if($valor_multa){
  $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de ".$valor_multa."% após o vencimento";
}

if($valor_juros){
  $dadosboleto["instrucoes2"] = "- Sr. Caixa, cobrar juros de ".$valor_juros."% após o vencimento";
}

$dadosboleto["instrucoes3"] = "- Receber até ".$dias_de_prazo_para_pagamento." dias após o vencimento";
if($quantidadeDiasProtesto > 0){
  $dadosboleto["instrucoes4"] = "Título sujeito a protesto após o prazo limite de pagamento";
}
if($quantidadeDiasNegativacao > 0){
  $dadosboleto["instrucoes5"] = "Título sujeito a negativação após o prazo limite de pagamento";
}


// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = "1";
$dadosboleto["aceite"] = "N";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = $dadosc['agencia']; // Num da agencia, sem digito
$dadosboleto["conta"] = $dadosc['conta']; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = $dadosc['convenio'];  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
$dadosboleto["contrato"] = "999999"; // Num do seu contrato
$dadosboleto["carteira"] = "17";
$dadosboleto["variacao_carteira"] = "35";  // Variação da Carteira, com traço (opcional)

// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos

/*
#################################################
DESENVOLVIDO PARA CARTEIRA 18
- Carteira 18 com Convenio de 8 digitos
  Nosso número: pode ser até 9 dígitos
- Carteira 18 com Convenio de 7 digitos
  Nosso número: pode ser até 10 dígitos
- Carteira 18 com Convenio de 6 digitos
  Nosso número:
  de 1 a 99999 para opção de até 5 dígitos
  de 1 a 99999999999999999 para opção de até 17 dígitos
#################################################
*/


// SEUS DADOS
// $dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
$dadosboleto["cpf_cnpj"] = $dadosc['inscricao'];
// $dadosboleto["endereco"] = "Avenida Godofredo Maciel, 2841 - MARAPONGA";
// $dadosboleto["cidade_uf"] = "FORTALEZA - CE";
$dadosboleto["cedente"] = $dadosc['empresa'];

//QR CODE
$dadosboleto["qrUrl"] = $qrcode['url'];
$dadosboleto["qrTextId"] = $qrcode['textId'];
$dadosboleto["qrEmv"] = $qrcode['emv'];
$bol_arq = $dadosb['numero'].'.pdf';
// NÃO ALTERAR!
// $i = 0;
// if($i == 1){
ob_clean();
ob_start();
include('./phpqrcode/qrlib.php');
include("includes/funcoes_bb.php"); 
include("includes/layout_bb.php");
$content = ob_get_clean();
$raiz = $_SERVER['DOCUMENT_ROOT'];


try{

  $options = new Options();
  $options->setChroot(__DIR__);
  $options->setIsRemoteEnabled(true);

  $dompdf = new Dompdf($options);
  $dompdf->setPaper('A4','portrait');
  $dompdf->loadHtml($content);
  $dompdf->render();
  
  header('Content-type: Application/pdf');
  echo $dompdf->output();
  file_put_contents($raiz.'/contas/documentos/boletos/'.$dadosb['numero'].'.pdf',$dompdf->output());

  // $par = ['id_conta' => $dadosc['id_conta'],'nosso_num' => $dadosb['numero'],'sequ' => $num, 'arqu_bol' => $dadosb['numero'].'.pdf'];
  // $result = json_decode(attNossoNumBoleto($par));

  

  $nossNum = $dadosb['numero'];
  $id_conta = $dadosc['id_conta'];
  $seq = $num;
  

  $sql = "UPDATE conta_receber SET num_boleto = '$nossNum', seq_boleto = $seq, boleto_arq = '$bol_arq' WHERE idcntrec = $id_conta";
  $up = $mysqli->query($sql);
  if($up){
    $result = array('result' => 'sucess', 'datas' => 'Informações de boleto atualizadas.', 'msg' => 'Informações de boleto atualizadas. ', 'campo' => $sql);
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao atualizar informações do boleto.', 'msg' => 'Erro ao atualizar informações do boleto. '.$mysqli->error, 'campo' => $sql);
  }

  $ins = $mysqli->query("INSERT INTO `registros`(`tipo`, `tabela`, `dt_entrada`, `hora`, `usuario`, `dados`, `status`) VALUES ('INSERT','conta_receber','".date("Y-m-d")."','".date("H:i:d")."','sistema','".addslashes($result['msg']).' '.addslashes($result['campo'])."','antigo')");

  
  //readfile($raiz.'/contas/documentos/boletos/'.$dadosb['numero'].'.pdf');
  //$body = "Prezado <b>".$dadosc['cliente']."</b>, segue em anexo boleto referente a(o): ".$dadosc['descricao'].', com venceimento em: <b>'.$dadosboleto['data_vencimento'];
  //echo $content;
  // $mail = json_decode(enviaEmail($to,$nameto,'Boleto Necava',$body,$raiz.'/contas/documentos/boletos/'.$dadosb['numero'].'.pdf'));
  // echo $mail->result;
}catch(Exception $e){
  echo $e;
}
// }
}




?>