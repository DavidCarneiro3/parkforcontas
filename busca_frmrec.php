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
        $params = ['action' => '5', 'status' => 'ATIVA'];
        $res = loadApi($params);

            if($res->result === "sucess"){
                $emp = $res->datas;
                //print_r($emp);
            }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Buscar Forma de Recebimento</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        
                    <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa</label>
                            <select name="empresa" class="form-control">
                            <option value="" disabled selected>Selecione</option>
                                <?php
                                foreach($emp as $item){
                                ?>
                                  <option value="<?=$item->idemp?>"><?=$item->tipo_empresa?> - <?=$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Ativo</label>
                            <select name="ativo" class="form-control">
                                <option value="" selected>Selecione</option>
                                <option value="sim">Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Informe o Código">
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
            'action'=>'42'
        ];

         $result = json_decode(listarFormaRecebimento($params));
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
                    <th>Recebimento</th>
                    <th>Ativo</th>
                    <th>Ação</th>
                </thead>
                <?php foreach($list as $item){ ?>
                    <tr>
                        <td><?=$item->codigo?></td>
                        <td><?=$item->recebimento?></td>
                        <td><?=$item->ativo?></td>
                        <td>
                            <a href="edt_frmrec.php?idfrmrec=<?=$item->idfrmrec?>" title="E ditar Forma de Recebimento"><i class="fa fa-gear" aria-hidden="true"></i></s>
                            <!-- <a href="busca_cent.php?botao=del&idcentro=<?=$item->idfrmpag?>" alt="Deletar Centro"><i class="fa fa-trash-o" aria-hidden="true"></i></s> -->
                        </td>
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
        $(function() {
            $( "#centro" ).autocomplete({
                source: 'includes/search_cent.php'
            });
        });
    </script>
</body>
</html>