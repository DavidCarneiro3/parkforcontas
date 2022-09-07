<!DOCTYPE html>
<?php 
date_default_timezone_set('America/Sao_Paulo');
session_start();
include("includes/control.php");
include("includes/funcoes.php");
include("includes/load.php");
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

<!-- start preloader -->
        <div id="loader-wrapper">
            <div class="logo"></div>
            <div id="loader">
            </div>
        </div>
        <!-- end preloader -->
		
		<br />

	</header><!--/header-->
<br />
    <?php
        if($_POST['btn']){
            $params = [
                'codigo' => $_POST['codigo'],
                'recebimento' => $_POST['recebimento'],
                'obs' => $_POST['obs'],
                'empresa' => $_POST['fk_empresa'],
                'usuario' => $_SESSION['user'],
                'action'=> '41'
            ];

            $result = loadApi($params);
            //print_r($result);
            if($result->result === "sucess"){
                echo '<script>alert("Forma de Recebimento Cadastrada.")</script>';
            }else{echo '<script>alert("'.$result->error.'")</script>';}
        }

        $par = ['action' => '6'];
        $data = loadApi($par);
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $params = ['action' => '5', 'status' => 'ATIVA'];
        $res = loadApi($params);

            if($res->result === "sucess"){
                $emp = $res->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$result->error.')</script>';
            }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Inserir Forma de Recebimento</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa</label>
                            <select name="fk_empresa" class="form-control">
                            <option value="" selected>Selecione</option>
                                <?php
                                foreach($list as $item){
                                ?>
                                  <option value="<?=$item->idemp?>"><?=$item->tipo_empresa.' - '.$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- <label style="float: left; margin-left: 2%;">Código</label> -->
                            <input type="text" name="codigo" id="centro" style="width:12%" class="form-control"  maxlength="2" placeholder="Cód. Ex. BL">
                        </div>
                        
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="recebimento" id="centro" class="form-control"  maxlength="200" placeholder="Forma de recebimento">
                        </div>  
                        <!-- <div class="form-group"> -->
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <!-- <input type="text" name="obs" id="message" maxlength="200" class="form-control"  placeholder="Observação">
                        </div>   -->
                                              
                        <div class="form-group">
                            <input type="submit" name="btn" class="btn btn-primary" value="Cadastrar">
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
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script>
        $(function(){
            $('#estados').change(function(){
                if( $(this).val() ) {
                $('#cod_cidades').hide();
                $('.carregando').show();
                $.getJSON(
                    'includes/api.php?action=8&uf=',
                    {
                    uf: $(this).val(),
                    ajax: 'true'
                    }, function(j){
                    var options = '<option value="">Selecione</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' +
                        j[i].dsc_cidade + '">' +
                        j[i].dsc_cidade + '</option>';
                    }
                    $('#cod_cidades').html(options).show();
                    $('.carregando').hide();
                    });
                } else {
                $('#cod_cidades').html(
                    '<option value="">-- Escolha um estado --</option>'
                );
                }
            });
        });
     
		$("#telefone, #fax").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");
	
    </script>
</body>
</html>