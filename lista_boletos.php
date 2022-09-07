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
        <!-- choose a theme file -->
<!-- <link rel="stylesheet" href="js/dist/css/theme.default.css"> -->


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

	</header><!--/header-->
<br />
<?php
$dados = unserialize($_POST['dadosc']);
$agencia = $dados['agencia'];
$conta = $dados['conta'];
$convenio = $dados['convenio'];
$situacao = $dados['situacao'];
$empresa = $dados['empresa'];
$fk_empresa = $dados['fk_empresa'];
//$opcao = 'Quitar';
// print_r($dados);

$getSeq = json_decode(seqBol($fk_empresa));
// print_r($getSeq);
$par = ['agencia' => $agencia, 'conta' => $conta, 'situacao' => $situacao];
$result = json_decode(listaBol($par));
$boletos = $result->boletos;
// print_r($result);
?>

<div class="container">
    <div class="row">
<?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
    <h2 class="title text-center">Boletos <?=$empresa?></h2>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Numero</th>
                    <th>Data Registro</th>
                    <th>Vencimento</th>
                    <th>Situação</th>
                    <th>Data Credito</th>
                    <th>Vr. Original</th>
                    <th>Vr. Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($boletos as $item){ 
                ?>
                 <tr>
                     <td><?=$item->numeroBoletoBB?></td>
                     <td><?=str_replace('.','/',$item->dataRegistro)?></td>
                     <td><?=str_replace('.','/',$item->dataVencimento)?></td>
                     <td><?=$item->estadoTituloCobranca?></td>
                     <td><?=str_replace('.','/',$item->dataCredito)?></td>
                     <td><?=number_format($item->valorOriginal,2,',','.')?></td>
                     <td><?=number_format($item->valorPago,2,',','.')?></td>
                 </tr>
                <?php } ?>
            </tbody>
        
        </table>
        <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post" enctype="multipart/form-data" data-ajax="false">
            <div class="contact-form">
            
                    <?php if($opcao == 'Quita'){ ?>
                        <div class="form-group">
                            <input type="date" name="dt_pag" value="<?=date('Y-m-d')?>"  class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="file" id="file" name="comprovante" accept=".pdf, .jpeg, .png" style="widith:100%">
                        </div>
                    <?php } ?>
                    
                </div>
                <div>
                    <input type="hidden" name="codigos" value="<?=$tmp?>"/>
                    <input type="hidden" name="opcao" value="<?=$opcao?>"/>
                    <button type="button" id="cancel" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
 <!--Footer-->
 <footer id="footer">
		<!--  -->
		
        <br/>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2021 Parkfor. Todos os diretos reservados.</p>
					
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script>
        $("#cancel").on('click',function(){
            window.close();
        })
    </script>
</body>
</html>