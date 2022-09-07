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
        $params = ['action' => '5','status' => 'ATIVA', 'tipo_empresa' => 'MATRIZ'];
        $res = json_decode(listaEmpresas($params));
        //print_r($res);
            if($res->result === "sucess"){
                $emp = $res->datas;
                //print_r($emp);
            }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Buscar Empresa</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Status</label>
                            <select name="status">
                                <option value="" disabled selected>Selecione</option>
                                <option value="ATIVA">ATIVA</option>
                                <option value="DESATIVADA">DESATIVADA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo</label>
                            <select name="tipo_empresa">
                                <option value="" disabled selected>Selecione</option>
                                <option value="Matriz">Matriz</option>
                                <option value="Filial">Filial</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Matriz</label>
                            <select name="matriz">
                            <option value="" disabled selected>Selecione</option>
                                <?php
                                foreach($emp as $item){
                                ?>
                                  <option value="<?=$item->idemp?>"><?=$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
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
      
         $params = [
             'tipo_empresa' => $_POST['tipo_empresa'],
             'matriz' => $_POST['matriz'],
             'status' => $_POST['status'],
             'action'=>'6'
         ];

         $result = json_decode(listaEmpresas($params));
         //print_r($result);
         if($result->result === "sucess"){
             $list = $result->datas;
             //print_r($list);
         }
     }
if($list){ ?>
    <div class="container">
		<div class="row">
            <h2 class="title text-center">Resultado da Busca</h2>
            <table class="table cell-border" id="mytable">
                <thead>
                    <th>Código</th>
                    <th>CNPJ</th>
                    <th>Razão Social</th>
                    <th>Nome Fantasia</th>
                    <th>Tipo Empresa</th>
                    <th>Matriz</th>
                    <th>IRRF (%)</th>
                    <th>PIS (%)</th>
                    <th>COFINS (%)</th>
                    <th>CSLL (%)</th>
                    <th>INSS (%)</th>
                    <th>ISS (%)</th>
                    <th>Status</th>
                    <th>Ação</th>
                </thead>
                <?php foreach($list as $item){ ?>
                    <tr>
                        <td><?=$item->idemp?></td>
                        <td><?=$item->cnpj?></td>
                        <td><?=$item->razao_social?></td>
                        <td><?=$item->nome_fantasia?></td>
                        <td><?=$item->tipo_empresa?></td>
                        <td><?=$item->matriz?></td>
                        <td><?=$item->irrf?></td>
                        <td><?=$item->pis?></td>
                        <td><?=$item->cofins?></td>
                        <td><?=$item->csll?></td>
                        <td><?=$item->inss?></td>
                        <td><?=$item->iss?></td>
                        <td><?=$item->status?></td>
                        <td><a target="_blank" href="edt_emp.php?idemp=<?=$item->idemp?>"><i class="fa fa-gear" aria-hidden="true"></i></s></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php }else{
        if($_POST['btn']){ ?>
   <div class="text-center">
       <label class="icon-error">:(</label>
       <p class="text-error">Nenhum resultado encontrado na busca</p>
   </div>
    <?php } 
    } ?>
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