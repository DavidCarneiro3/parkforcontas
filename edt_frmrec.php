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
					<div class="col-lg-22">
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
								<li class="dropdown"><a href="#"><i class="fa fa-truck" aria-hidden="true"></i> Fornecedores</a>
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
                                
								<li><a href="#" class="active"><i class="fa fa-credit-card" aria-hidden="true"></i> Contas a Receber<i class="fa fa-angle-down"></i></a>
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
								<li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> Gerencial</a>
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
        $id = ($_GET['idfrmrec'])? $_GET['idfrmrec'] : $_POST['idfrmrec'];
        if($_POST['btn']){
            //print_r($_POST);
            $params = [
                'codigo' => $_POST['codigo'],
                'recebimento' => $_POST['recebimento'],
                'obs' => $_POST['obs'],
                'ativo' => $_POST['ativo'],
                'idfrmrec' => $id,
                'usuario' => $_SESSION['user'],
                'action'=> '43'
            ];

            $result = loadApi($params);
            //print_r($result);
            if($result->result === "sucess"){
                echo '<script>alert("Forma de Recebimento Atualizada.")</script>';
            }else{ 
                echo '<script>alert("'.$result->error.'")</script>';
            }
        }

        if($_POST['del']){
            $prms = ['action' => '44', 'idfrmrec' => $_POST['idfrmrec']];
            $del = loadApi($prms);
            if($del->result == 'sucess'){
                echo '<script>
                alert("Registro excluído!");
                window.location.href = "busca_frmrec.php";
                </script>';
                
            }
            else{
                echo '<script>alert("Erro ao excluir registro!")</script>';
                print_r($del);
            }
        }

        // $idfrmpag = $_GET['idfrmpag'];
        // $parameters = ['idfrmpag' => $idfrmpag, 'action' => '28'];
        // $cons = loadApi($parameters);
        // $res = $cons->datas;
        //print_r($res);

        $par = ['action' => '6'];
        $data = loadApi($par);
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        

        $pr = ['idfrmrec' => $id, 'action' => '42'];
        $res = loadApi($pr);
        //print_r($res);
        if($res->result === "sucess"){
            $rec = $res->datas;
            //print_r($rec);
        }else{
            echo '<script>alert("'.$res->error.' '.$res->msg.'")</script>';
        }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Editar Forma de Recebiemtno</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" maxlength="200" value="<?=$rec[0]->codigo?>">
                            
                        </div>
                        
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Recebimento</label>
                            <input type="text" name="recebimento" id="recebimento" class="form-control"  maxlength="200" value="<?=$rec[0]->recebimento?>">
                        </div>  
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Ativo</label>
                            <select name="ativo">
                                <option value="" >Selecione</option>
                                <option value="Sim" <?=($rec[0]->ativo == "Sim")? 'selected' : '' ?>>Sim</option>
                                <option value="Não" <?=($rec[0]->ativo == "Não")? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>
                        <input type="hidden" name="idfrmrec" value="<?=$rec[0]->idfrmrec?>" />
                        
                                              
                        <div class="form-group">
                            <a class="btn btn-info" href="javascript:location.href = 'busca_frmrec.php'">Voltar</a>
                            <?php if($_SESSION['nivel'] > 1){ ?>
                            <input type="submit" name="del" class="btn btn-danger" value="Deletar" data-toggle="modal" data-target="#exampleModal">
                            <?php } ?>
                            <input type="submit" name="btn" class="btn btn-primary" value="Editar">
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
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
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