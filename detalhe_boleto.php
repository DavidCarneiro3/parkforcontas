<!DOCTYPE html>
<?php 
date_default_timezone_set('America/Sao_Paulo');
session_start();
include("includes/control.php");
include("includes/funcoes.php");
include("includes/load.php");
include("consulta_boleto.php");
if($_SESSION['id'] < 1){
	echo "<script>location.href='login.php';</script>";
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Parkfor - Contas</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/prettyPhoto.css" rel="stylesheet">
        <link href="css/price-range.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->       
        <link rel="shortcut icon" href="images/icon.ico" />
        <!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png"> -->
    </head><!--/head-->

<body>
<header id="header"><!--header-->
		<!--header_top-->
		<div class="header_top">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-cash"></i> Sistema de Gerenciamento Financeiro</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><i class="fa fa-user"></i></li>
                                <li>&nbsp;</li>
								<li><?=$_SESSION['tipo']?> : <?=$_SESSION['name']?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		 <!--/header_top-->


	</header><!--/header-->
<br />
   
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Detalhes do boleto</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                            <div class="row"  style="color: #000">
                                                <?php
                                                
                                                $parameters = ['nosso_num' => $_GET['num_bol'], 'convenio' => $_GET['convenio']];
                                                //print_r($parameters);
                                                $res_bol = json_decode(consultaBol($parameters));
                                                // print_r($res_bol);
                                                if($res_bol->codigoEstadoTituloCobranca){
                                                ?>
                                                    <table class="table">
                                                        <tr><td>Nome Sacado</td><td><?=$res_bol->nomeSacadoCobranca?></td></tr>
                                                        <tr><td>Numero Boleto</td><td><?=$_GET['num_bol']?></td></tr>
                                                        <tr><td>Convenio</td><td><?=$_GET['convenio']?></td></tr>
                                                        <?php if($res_bol->codigoLinhaDigitavel){ ?>
                                                        <tr><td>Codigo de Barras</td><td><?=$res_bol->codigoLinhaDigitavel?></td></tr>
                                                        <?php } ?>
                                                        <tr><td>Data Emissão</td><td><?=str_replace('.','/',$res_bol->dataEmissaoTituloCobranca)?></td></tr>
                                                        <tr><td>Data Vencimento</td><td><?=str_replace('.','/',$res_bol->dataVencimentoTituloCobranca)?></td></tr>
                                                        <tr><td>Data Crédito</td><td><?=str_replace('.','/',$res_bol->dataCreditoLiquidacao)?></td></tr>
                                                        <tr><td>Data Recebimento</td><td><?=str_replace('.','/',$res_bol->dataRecebimentoTitulo)?></td></tr>
                                                        <tr><td>Data Protesto</td><td><?=str_replace('.','/',$res_bol->dataProtestoTituloCobranca)?></td></tr>
                                                        <tr><td>Data Baixa Automática</td><td><?=str_replace('.','/',$res_bol->dataBaixaAutomaticoTitulo)?></td></tr>
                                                        <tr><td>Vr. Boleto</td><td><?=number_format($res_bol->valorAtualTituloCobranca,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Pago</td><td><?=number_format($res_bol->valorPagoSacado,2,',','.')?></td></tr>
                                                        <tr><td>Percentual de Multa</td><td><?=($res_bol->percentualMultaTitulo)?>%</td></tr>
                                                        <tr><td>Vr. Juros</td><td><?=number_format($res_bol->valorJuroMoraTitulo,2,',','.')?></td></tr>
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
                                                        <?php if($res_bol->codigoEstadoTituloCobranca != 7 && $res_bol->codigoEstadoTituloCobranca != 6){?>
                                                        <tr><td>Observações de Baixa/Cancelamento</td><td><input type="text" value="" name="obs_baixa" style="width:100%;"  id="obs_baixa"></td></tr>
                                                        <?php } ?>
                                                       
                                                    
                                                    </table>
                                                    <?php if($res_bol->codigoEstadoTituloCobranca != 7 && $res_bol->codigoEstadoTituloCobranca != 6){?>
                                                    <button type="button" onclick="baixaBoleto(<?=$_GET['num_bol']?>,'BAIXADO')" class="btn btn-primary">Baixar Boleto</button>
                                                    <button type="button" onclick="baixaBoleto(<?=$_GET['num_bol']?>,'CANCELADO')" class="btn btn-danger">Cancelar Boleto</button>
                                                    <?php } ?>
                                                    <script>
                                                        function baixaBoleto(id,status){
                                                            var resultado = confirm("Deseja alterar status doo boleto: " + <?=$_GET['num_bol']?> + " para: "+status+"?");
                                                            var obs_baixa = document.getElementById('obs_baixa');
                                                            console.log(obs_baixa.value)
                                                            console.log(status)

                                                            if (resultado == true) {
                                                                //alert('SIM!');
                                                                $.ajax({
                                                                type: "POST",
                                                                url: "baixa_boleto.php",
                                                                data: {'convenio':<?=$_GET['convenio']?>,'num_bol':<?=$_GET['num_bol']?>,'obs_baixa':obs_baixa.value, 'status_baixa':status},
                                                                success: function(result){
                                                                    console.log('result',result);
                                                                    let values = JSON.parse(result)
                                                                    console.log('values',values);
                                                                    console.log('Res',values['Res']);
                                                                    if(values['Res'].numeroContratoCobranca != null){
                                                                        alert('Boleto baixado/cancelado!');
                                                                    }else{
                                                                        alert('Erro ao baixar/cancelar boleto!');
                                                                    }
                                                                    document.location.reload(true);
                                                                },
                                                                error: function(err){console.log(err)}
                                                            })
                                                            }
                                                        }
                                                        
                                                    </script>
                                                    <?php } 
                                                        
                                                    
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['name']?>" />
                                                    <input type="hidden" value="<?=$item->numeroBoletoBB?>" name="idconta" id="idconta<?=$item->numeroBoletoBB?>"/>
                                                   
                                                </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja apagar esse registro!?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                                        <input type="submit" name="del" class="btn btn-primary" value="Sim"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        
	</div>
     <!--Footer-->
	<footer id="footer">
		<!--  -->
		
		
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2021 Parkfor. Todos os diretos reservados.</p>
					
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->

    
    <script src="js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    
</body>
</html>