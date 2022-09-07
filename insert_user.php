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

<!--/header-middle-->
	
		<!--header-bottom-->
<!-- <div class="header-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-20">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
								<li class="dropdown"><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i> Empresas</a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="insert_emp.php">Inserir</a></li>
										<li><a href="busca_emp.php">Consultar/Editar</a></li> 
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#"><i class="fa fa-truck" aria-hidden="true"></i>Fornecedores</a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="insert_forne.php">Inserir</a></li>
										<li><a href="busca_forn.php">Consultar/Editar</a></li>
                                    </ul>
                                </li> 
								<li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> Clientes</a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="insert_cli.php">Inserir</a></li>
									<li><a href="busca_cli.php">Consultar/Editar</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-usd" aria-hidden="true"></i> Centro de Custos</a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="insert_cent.php">Inserir</a></li>
									<li><a href="busca_cent.php">Consultar/Editar</a></li>
                                    </ul>
                                </li>
                                
								<li><a href="#"><i class="fa fa-credit-card" aria-hidden="true"></i> Contas a Receber</a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="insert_cntrec.php">Inserir</a></li>
									<li><a href="busca_cntrec.php">Consultar/Editar</a></li>
									<li><a href="insert_frmrec.php">Inserir Forma de Recebimento</a></li>
									<li><a href="busca_frmrec.php">Consultar/Editar Forma de Recebimento</a></li>
                                    </ul>
                                </li>
								<li><a href="#"><i class="fa fa-money" aria-hidden="true"></i> Contas a Pagar</a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="insert_cntpag.php">Inserir</a></li>
									<li><a href="busca_cntpag.php">Consultar/Editar</a></li>
									<li><a href="insert_frmpag.php">Inserir Forma de Pagamento</a></li>
									<li><a href="busca_frmpag.php">Consultar/Editar Forma de Pagamento</a></li>
									<li><a href="busca_cntpag_exc.php">Consultar Contas a Pagar Excluidas</a></li>
                                    </ul>
                                </li>
								<li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Documentos</a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="insert_doc.php">Inserir</a></li>
									<li><a href="busca_doc.php">Consultar/Editar</a></li>
									<li><a href="insert_tip_doc.php">Inserir Tipo de Documento</a></li>
									<li><a href="busca_tip_doc.php">Consultar/Editar Tipo de Documento</a></li>
                                    </ul>
                                </li>
								<li><a href="#"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> Relatórios</a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="rel_cntrece.php">Contas a Receber</a></li>
									<li><a href="rel_cntpag.php">Contas a Pagar</a></li>
									<li><a href="faturamento.php">Faturamento</a></li>
                                    </ul>
                                </li>
								<li><a href="#" class="active"><i class="fa fa-cog" aria-hidden="true"></i> Gerencial<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                     <li><a href="meus_dados.php">Meus Dados</a></li>
									<?php if($_SESSION['nivel'] == 3){ ?>
									<li><a href="insert_user.php">Cadastrar Usuário</a></li>
									<li><a href="busca_user.php">Caonsultar/Editar Usuário</a></li>
									<li><a href="log.php">Log do Sistema</a></li>
									<?php } ?>
									<li><a href="out.php">Sair do Sistema</a></li>
                                    </ul>
                                </li>
							</ul>
						</div>
					</div>
					
				</div>
			</div>
		</div> -->
<!--/header-bottom-->
	</header><!--/header-->
<br />
    <?php
        if($_POST['btn']){
            //print_r($_POST);
            if(!$_POST['matriz']){
                $empresa = 0;
            }else{
                $empresa = $_POST['matriz'];
            }
            
            $params = [
                'nome' => $_POST['nome'],
                'cpf' => $_POST['cpf'],
                'email' => $_POST['email'],
                'usuario' => $_POST['usuario'],
                'senha' => $_POST['senha'],
                'tipo' => $_POST['tipo'],
                'empresa' => $empresa,
                'action'=>'3'
            ];

            $result = loadApi($params);
            //print_r($result);
            if($result->result === "sucess"){
                echo '<script>alert("Cadastrado com Sucesso.")</script>';
            }else{echo '<script>alert("'.$result->error.'")</script>';}
        }

        $params = ['action' => '5'];
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
                    <h2 class="title text-center">Cadastrar Usuário</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                    <div class="form-group">
                            <input type="text" name="nome" id="nome" class="form-control" required="required" placeholder="Nome*">
                            <!-- <div id="erro"></div> -->
                        </div>
                        </br>
                        <div class="form-group">
                            <input type="text" name="cpf" id="cpf" class="form-control" required="required" placeholder="Cpf Apenas Números*">
                        </div>
                        </br>
                        <div class="form-group">
                            <input type="text" name="email" id="email" class="form-control" required="required" placeholder="Email*">
                        </div>
                        <div class="form-group">
                            <input type="text" name="usuario" id="usuario" class="form-control" required="required" placeholder="Usuário*">
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" id="pass" class="form-control" required="required" placeholder="Senha*">
                            <div id="info_pass"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="senha" id="senha" class="form-control" required="required" placeholder="Confirmar Senha*">
                            <div id="info"></div>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo de Usuário*</label>
                            <select name="tipo" required="required">
                            <option value="" disabled selected>Selecione</option>
                                <option value="1">Usuário</option>
                                <option value="2">Administrativo</option>
                                <option value="3">Gerencial</option>
                            </select>
                        </div>
                        
                             
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa de Referência</label>
                            <select name="matriz">
                            <option value="0" disabled selected>Selecione</option>
                                <?php
                                foreach($emp as $item){
                                ?>
                                  <option value="<?=$item->idemp?>"><?=$item->razao_social?> - <?=$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                                           
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
    <script>
        $(function(){
            $("#senha").keyup(function(){
                var pass1 = $("#senha").val();
                var pass2 = $("#pass").val();

                if(pass1 != pass2){
                    $("#info").removeClass("info_verde").addClass("info_vermelho").html("As senhas são diferentes!")
                }
                if(pass1 == pass2){
                    $("#info").removeClass("info_vermelho").addClass("info_verde").html("Válida!")
                }
                
            })
            $("#pass").keyup(function(){
                var pass = $("#pass").val();

                if(pass.length < 6){
                    $("#info_pass").removeClass("info_verde").addClass("info_vermelho").html("A senha precisa ter no mínimo 6 caracteres!")
                }
                if(pass.length >= 6){
                    $("#info_pass").removeClass("info_vermelho").addClass("info_verde").html("Válida!")
                }
            })
        })
        
    </script>
</body>
</html>