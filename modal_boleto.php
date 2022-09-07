<?php
$parameters = ['nosso_num' => $_GET['num_bol'], 'convenio' => $_GET['convenio']];
                                                print_r($parameters);
                                                $res_bol = json_decode(consultaBol($parameters));
                                                print_r($res_bol);
                                                if($res_bol->codigoEstadoTituloCobranca){
                                                ?>
                                                    <table class="table">
                                                        <tr><td>Nome Sacado</td><td><?=$item->nomeSacadoCobranca?></td></tr>
                                                        <tr><td>Convenio</td><td><?=$_POST['convenio']?></td></tr>
                                                        <?php if($res_bol->codigoLinhaDigitavel){ ?>
                                                        <tr><td>Codigo de Barras</td><td><?=$res_bol->codigoLinhaDigitavel?></td></tr>
                                                        <?php } ?>
                                                        <tr><td>Data Emissão</td><td><?=str_replace('.','/',$res_bol->dataEmissaoTituloCobranca)?></td></tr>
                                                        <tr><td>Data Vencimento</td><td><?=str_replace('.','/',$res_bol->dataVencimentoTituloCobranca)?></td></tr>
                                                        <tr><td>Vr. Boleto</td><td><?=number_format($res_bol->valorAtualTituloCobranca,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Pago</td><td><?=number_format($res_bol->valorPagoSacado,2,',','.')?></td></tr>
                                                        <tr>
                                                            <td>Situação</td><td>
                                                                <?php 
                                                                if($res_bol->codigoEstadoTituloCobranca == 1){
                                                                    echo 'NORMAL/ABERTO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 2){
                                                                    echo 'MOVIMENTO CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 3){
                                                                    echo 'EM CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 4){
                                                                    echo 'TITULO COM OCORRENCIA DE CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 5){
                                                                    echo 'PROTESTADO ELETRONICO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 6){
                                                                    echo 'LIQUIDADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 7){
                                                                    echo 'BAIXADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 8){
                                                                    echo 'TITULO COM PENDENCIA DE CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 9){
                                                                    echo 'TITULO PROTESTADO MANUAL';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 10){
                                                                    echo 'TITULO BAIXADO/PAGO EM CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 11){
                                                                    echo 'TITULO LIQUIDADO/PROTESTADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 12){
                                                                    echo 'TITULO LIQUID/PGCRTO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 13){
                                                                    echo 'TITULO PROTESTADO AGUARDANDO BAIXA';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 14){
                                                                    echo 'TITULO EM LIQUIDACAO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 15){
                                                                    echo 'TITULO AGENDADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 16){
                                                                    echo 'TITULO CREDITADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 17){
                                                                    echo 'PAGO EM CHEQUE';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 18){
                                                                    echo 'AGUARD.LIQUIDACAO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 19){
                                                                    echo 'PAGO PARCIALMENTE';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 20){
                                                                    echo 'TITULO AGENDADO COMPE 80';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 21){
                                                                    echo 'EM PROCESSAMENTO (ESTADO TRANSITÓRIO)';
                                                                }


                                                                ?>
                                                                
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr><td>Download Boleto</td><td><a href="documentos/boletos/<?=$item->boleto_arq?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                       
                                                    
                                                    </table>
                                                    <?php if($res_bol->codigoEstadoTituloCobranca != 7){?>
                                                    <button type="button" onclick="<?php echo 'baixaBoleto'.$item->numeroBoletoBB ?>(<?=$item->numeroBoletoBB?>)" class="btn btn-danger">Baixa/Cancelar Boleto</button>
                                                    <?php } ?>
                                                    <script>
                                                        function <?php echo 'baixaBoleto'.$item->numeroBoletoBB ?>(id){
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "baixa_boleto.php",
                                                                data: {'convenio':<?=$item->convenio?>,'num_bol':<?=$item->num_bol?>},
                                                                success: function(result){
                                                                    console.log(result);
                                                                    let values = JSON.parse(result)
                                                                    if(values.numeroContratoCobranca != null){
                                                                        alert('Boleto baixado/cancelado!');
                                                                    }else{
                                                                        alert('Erro ao baixar/cancelar boleto!');
                                                                    }
                                                                    document.location.reload(true);
                                                                },
                                                                error: function(err){console.log(err)}
                                                            })
                                                        }
                                                        
                                                    </script>
                                                    <?php } 
                                                        
                                                    
                                                    ?>