<?php 
    include("includes/load.php"); 
    include("includes/funcoes.php"); 
    include("consulta_boleto.php"); 
    $data = date("Y-m-d");
    $dias = 5;
    $novadata = date('Y-m-d', strtotime("-{$dias} days",strtotime($data)));

    $par = ['dt_vencimento_ini' => $novadata, 'dt_vencimento_fin' => $data];
    $result = json_decode(listaContaReceberBoleto($par));
    $itens = $result->datas;
    //print_r($result);
    foreach($itens as $item){
        $parameters = ['nosso_num' => $item->num_bol, 'convenio' => $item->convenio];
		$res_bol = json_decode(consultaBol($parameters));
        //echo $res_bol->codigoEstadoTituloCobranca;
        if($res_bol->codigoEstadoTituloCobranca == 1){
            $status_bol = 'NORMAL/ABERTO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 2){
            $status_bol = 'MOVIMENTO CARTORIO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 3){
            $status_bol = 'EM CARTORIO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 4){
            $status_bol = 'TITULO COM OCORRENCIA DE CARTORIO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 5){
            $status_bol = 'PROTESTADO ELETRONICO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 6){
            $status_bol = 'LIQUIDADO';
            $par = [
                    'idcnt' => $item->id_conta,
                    'sit' => $status_bol,
                    'status' => 'RECEBIDO',
                    'valor_pago' => $res_bol->valorPagoSacado,
                    'multa_pago' => $res_bol->valorMultaRecebido,
                    'juros_pago' => $res_bol->valorJuroMoraRecebido,
                    'dt_receb' => $res_bol->dataCreditoLiquidacao
                   ];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 7){
            $status_bol = 'BAIXADO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 8){
            $status_bol = 'TITULO COM PENDENCIA DE CARTORIO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 9){
            $status_bol = 'TITULO PROTESTADO MANUAL';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 10){
            $status_bol = 'TITULO BAIXADO/PAGO EM CARTORIO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 11){
            $status_bol = 'TITULO LIQUIDADO/PROTESTADO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 12){
            $status_bol = 'TITULO LIQUID/PGCRTO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 13){
            $status_bol = 'TITULO PROTESTADO AGUARDANDO BAIXA';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 14){
            $status_bol = 'TITULO EM LIQUIDACAO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 15){
            $status_bol = 'TITULO AGENDADO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 16){
            $status_bol = 'TITULO CREDITADO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 17){
            $status_bol = 'PAGO EM CHEQUE';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 18){
            $status_bol = 'AGUARD.LIQUIDACAO';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 19){
            $status_bol = 'PAGO PARCIALMENTE';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 20){
            $status_bol = 'TITULO AGENDADO COMPE 80';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        if($res_bol->codigoEstadoTituloCobranca == 21){
            $status_bol = 'EM PROCESSAMENTO (ESTADO TRANSITÓRIO)';
            $par = ['sit' => $status_bol, 'idcnt' => $item->id_conta];
            $res = json_decode(atualiza_sit_bol($par));
        }
        echo '<pre>';
        print_r($res);
    }
?>