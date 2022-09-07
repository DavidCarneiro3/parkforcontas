<?php
include("funcoes.php");
include("load.php");
//print_r($_POST);

$dadosb = $_POST['dadosb'];
$dadosc = $_POST['dadosc'];
$qrcode = $dadosb['qrCode'];
$to = $_POST['to'];
$nameto = $_POST['nameto'];
 //print_r($dadosc);


// DADOS DO BOLETO PARA O SEU CLIENTE
//$convenio = "3128557";
//$num = rand(1, 999);
// ob_start();
$dias_de_prazo_para_pagamento = 3;
$taxa_boleto = 0.00;
$data_venc = date(recebedata($dadosc['dt_doc']), time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $dadosc['val_doc']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $dadosb['numero'];
$dadosboleto["numero_documento"] = $dadosc['num_doc'];	// Num do pedido ou do documento
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
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até ".$dias_de_prazo_para_pagamento." dias após o vencimento";
$dadosboleto["instrucoes3"] = $dadosb['qrcode'];
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = "1";
$dadosboleto["aceite"] = "N";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = "3515"; // Num da agencia, sem digito
$dadosboleto["conta"] = "16562"; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = "3128557";  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
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
$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
$dadosboleto["cpf_cnpj"] = "";
$dadosboleto["endereco"] = "Avenida Godofredo Maciel, 2841 - MARAPONGA";
$dadosboleto["cidade_uf"] = "FORTALEZA - CE";
$dadosboleto["cedente"] = "NECAVA INSPECAO E PESQUISA EM TRANSPORTES LTDA";

//QR CODE
$dadosboleto["qrUrl"] = $qrcode['url'];
$dadosboleto["qrTextId"] = $qrcode['textId'];
$dadosboleto["qrEmv"] = $qrcode['emv'];

// NÃO ALTERAR!
ob_clean();
ob_start();
include("funcoes_bb.php"); 
include("layout_bb.php");
$content = ob_get_clean();
$raiz = $_SERVER['DOCUMENT_ROOT'];
require $raiz.'/eshopper/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
try{

  $options = new Options();
  $options->setChroot(__DIR__);
  $options->setIsRemoteEnabled(true);

  $dompdf = new Dompdf($options);
  //$dompdf->setPaper('A4','portrait');
  $dompdf->loadHtml($content);
  $dompdf->render();
  
  //header('Content-type: Application/pdf');
  //echo $dompdf->output($raiz.'/eshopper/documentos/boletos/'.$dadosb['numero'].'.pdf', 'F');
  file_put_contents(__DIR__.'/'.$dadosb['numero'].'.pdf',$dompdf->output());
  $body = "Prezado <b>".$dadosc['cliente']."</b>, segue em anexo boleto referente a(o): ".$dadosc['descricao'].', com venceimento em: <b>'.$dadosboleto['data_vencimento'];
  echo $content;
  $mail = json_decode(enviaEmail($to,$nameto,'Boleto Necava',$body,$raiz.'/eshopper/documentos/boletos/'.$dadosb['numero'].'.pdf'));
  echo $mail->result;
}catch(Exception $e){
  echo $e;
}
?>