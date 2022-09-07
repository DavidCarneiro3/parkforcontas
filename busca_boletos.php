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
        <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
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

<!-- start preloader -->
        <!-- <div id="loader-wrapper">
            <div class="logo"></div>
            <div id="loader">
            </div>
        </div> -->
        <!-- end preloader -->
		
		<br />

	</header><!--/header-->
<br />
        
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Buscar Boletos</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        
                    <div class="form-group">
                            <label   style="float: left; margin-left: 2%;">Convenio</label>
                            <select name="convenio" class="form-control" id="convenio" required>
                                    <option value="">Selecione</option>
                                    <option value="2184070" <?=($_POST['convenio'] == 2184070)?'selected':''?> >NECAVA</option>
                                    <option value="2786559" <?=($_POST['convenio'] == 2786559)?'selected':''?> >PARKFOR</option>
                                    <option value="3309918" <?=($_POST['convenio'] == 3309918)?'selected':''?> >TSST</option>
                                    <option value="3348211" <?=($_POST['convenio'] == 3348211)?'selected':''?> >V&T</option>
                                    <option value="3468148" <?=($_POST['convenio'] == 3468148)?'selected':''?> >MARAPONGA FOOD</option>
                                    <option value="3035927" <?=($_POST['convenio'] == 3035927)?'selected':''?> >CIPETRAN PP</option>
                                </select>
                            </div> 
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Situação</label>
                            <select name="situacao" class="form-control" id="situacao" required>
                                <option value="" selected>Selecione</option>
                                <option value="A" <?=($_POST['situacao'] == "A")?'selected':''?>>ABERTO</option>
                                <option value="B" <?=($_POST['situacao'] == "B")?'selected':''?>>Baixados/Protestados/Liquidados</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label   style="float: left; margin-left: 2%;">Código Situação</label>
                            <select name="cod_situacao" class="form-control" id="cod_situacao">
                                    <option value="">Selecione</option>
                                    <option value="01" <?=($_POST['cod_situacao'] == '01')?'selected':''?> >NORMAL (APENAS PARA SITUAÇÃO ABERTO)</option>
                                    <option value="02" <?=($_POST['cod_situacao'] == '02')?'selected':''?> >MOVIMENTO CARTORIO</option>
                                    <option value="03" <?=($_POST['cod_situacao'] == '03')?'selected':''?> >EM CARTORIO</option>
                                    <option value="04" <?=($_POST['cod_situacao'] == '04')?'selected':''?> >TITULO COM OCORRENCIA DE CARTORIO</option>
                                    <option value="05" <?=($_POST['cod_situacao'] == '05')?'selected':''?> >PROTESTADO ELETRONICO </option>
                                    <option value="06" <?=($_POST['cod_situacao'] == '06')?'selected':''?> >LIQUIDADO</option>
                                    <option value="07" <?=($_POST['cod_situacao'] == '07')?'selected':''?> >BAIXADO</option>
                                    <option value="08" <?=($_POST['cod_situacao'] == '08')?'selected':''?> >TITULO COM PENDENCIA DE CARTORIO</option>
                                    <option value="09" <?=($_POST['cod_situacao'] == '09')?'selected':''?> >TITULO PROTESTADO MANUAL</option>
                                    <option value="10" <?=($_POST['cod_situacao'] == '10')?'selected':''?> >TITULO BAIXADO/PAGO EM CARTORIO</option>
                                    <option value="11" <?=($_POST['cod_situacao'] == '11')?'selected':''?> >TITULO LIQUIDADO/PROTESTADO</option>
                                    <option value="12" <?=($_POST['cod_situacao'] == '12')?'selected':''?> >TITULO LIQUID/PGCRTO</option>
                                    <option value="13" <?=($_POST['cod_situacao'] == '13')?'selected':''?> >TITULO PROTESTADO AGUARDANDO BAIXA</option>
                                    <option value="14" <?=($_POST['cod_situacao'] == '14')?'selected':''?> >TITULO EM LIQUIDACAO</option>
                                    <option value="15" <?=($_POST['cod_situacao'] == '15')?'selected':''?> >TITULO AGENDADO</option>
                                    <option value="16" <?=($_POST['cod_situacao'] == '16')?'selected':''?> >TITULO CREDITADO</option>
                                    <option value="17" <?=($_POST['cod_situacao'] == '17')?'selected':''?> >PAGO EM CHEQUE - AGUARD.LIQUIDACAO</option>
                                    <option value="18" <?=($_POST['cod_situacao'] == '18')?'selected':''?> >PAGO PARCIALMENTE CREDITADO</option>
                                    <option value="80" <?=($_POST['cod_situacao'] == '80')?'selected':''?> >EM PROCESSAMENTO (ESTADO TRANSITÓRIO)</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-4 col-form-label">Data de Vencimento Inicial</label>
                                <input type="date" name="dt_venc_ini" id="message" value="<?=$_POST['dt_venc_ini']?>" class="form-control" placeholder="Data Vencimento">
                            </div>
                            <div class="form-group">
                            <label class="col-sm-4 col-form-label">Data de Vencimento Final</label>
                                <input type="date" name="dt_venc_fin" id="message" value="<?=$_POST['dt_venc_fin']?>" class="form-control" placeholder="Data Vencimento">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-form-label">Data de Registro Inicial</label>
                                <input type="date" name="dt_reg_ini" id="message" value="<?=$_POST['dt_reg_ini']?>" class="form-control" placeholder="Data Registro">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-form-label">Data de Registro Final</label>
                                <input type="date" name="dt_reg_fin" id="message" value="<?=$_POST['dt_reg_fin']?>" class="form-control" placeholder="Data Registro">
                            </div>       
                        <div class="form-group">
                            <input type="submit" name="btn" class="btn btn-primary" value="Buscar">
                        </div>
                    </form>
                </div>
            </div>
            
                                
	</div>
    <?php 
     
     if($_POST['btn']){
        //print_r($_POST);
        $params = [
            'empresa' => $_POST['empresa'],
            'codigo' => $_POST['codigo'],
            'ativo' => $_POST['ativo'],
            'convenio' => $_POST['convenio'],
            'action'=>'42'
        ];

         $result = json_decode(listaEmpresas($params));
         //print_r($result);
         if($result->result === "sucess"){
             $list = $result->datas;
             //print_r($list);
         }

         $par = [
            'convenio' => $_POST['convenio'],
            'agencia' => $list[0]->agencia,
            'conta' => $list[0]->conta,
            'situacao' => $_POST['situacao'],
            'cod_situacao' => $_POST['cod_situacao'],
            'data_reg_ini' => $_POST['dt_reg_ini'],
            'data_reg_fin' => $_POST['dt_reg_fin'],
            'data_venc_ini' => $_POST['dt_venc_ini'],
            'data_venc_fin' => $_POST['dt_venc_fin'],
         ];
         //print_r($par);
        
         $dados = json_decode(listabol($par));
         $boletos = $dados->boletos;
        //  print_r($dados);
        
     }
if($list){ ?>
    <div class="container">
		<div class="row">
            <h2 class="title text-center">Resultado da Busca</h2>
            <table class="table cell-border" id="mytable">
                <thead>
                    <th>Cliente</th>
                    <th>Numero Boleto</th>
                    <th>Data de Registro</th>
                    <th>Data Vencimento</th>
                    <th>Valor Original</th>
                    <th>Valor Atual</th>
                    <th>Situação</th>
                    <th>Valor Pago</th>
                    <th>Data do Crédito</th>
                    <th>Data do Movimento</th>
                    <th>Ação</th>
                </thead>
                <?php 
                if($boletos){
                foreach($boletos as $item){ 
                    $para = [
                        'num_bol' => $item->numeroBoletoBB
                    ];
                    $resu = json_decode(listaContaReceber($para));
                    if($resu){
                        $dados_conta = $resu->datas;
                        // echo $dados_conta[0]->cliente;
                    }
                    
                    ?>
                    <tr>
                        <td><?=($dados_conta[0]->cliente)?$dados_conta[0]->cliente:'Portal BB'?></td>
                        <td><?=$item->numeroBoletoBB?></td>
                        <td><?=str_replace('.','/',$item->dataRegistro)?></td>
                        <td><?=str_replace('.','/',$item->dataVencimento)?></td>
                        <td><?=$item->valorOriginal?></td>
                        <td><?=$item->valorAtual?></td>
                        <td><?=$item->estadoTituloCobranca?></td>
                        <td><?=$item->valorPago?></td>
                        <td><?=str_replace('.','/',$item->dataCredito)?></td>
                        <td><?=str_replace('.','/',$item->dataMovimento)?></td>
                        <td><a href="detalhe_boleto.php?convenio=<?=$_POST['convenio']?>&num_bol=<?=$item->numeroBoletoBB?>" target="_blank" title="Visualizar Arquivo"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                    </tr>
                <?php }
                }else{ ?>
                    <div class="text-center">
                        <label class="icon-error">:(</label>
                        <p class="text-error">Nenhum resultado encontrado na busca</p>
                    </div>
                     <?php } ?>
            </table>
        </div>
        
    </div>
    <br/>
    <?php }else{
        if($_POST['btn']){ ?>
   <div class="text-center">
       <label class="icon-error">:(</label>
       <p class="text-error">Nenhum resultado encontrado na busca</p>
   </div>
    <?php } 
    } ?>
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
        <!-- jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
 
 <!-- jQuery UI -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        $(function() {
        // alert('Entra aqui mas não funciona a ordenação');
        $("#mytable").DataTable({
            "language": {
                "url": "includes/br.json"
            },
            "pagingType": "full_numbers"
        });
       
        
     });
        


    </script>
</body>
</html>