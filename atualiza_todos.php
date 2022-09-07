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
								<li><a href="#"><i class="fa fa-users" aria-hidden="true"></i>Clientes</a>
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
								<li><a href="#" class="active"><i class="fa fa-money" aria-hidden="true"></i> Contas a Pagar<i class="fa fa-angle-down"></i></a>
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

$tmp = $_POST['codigos'];
$opcao = $_POST['opcao'];
//$opcao = 'Quitar';
//print_r($_POST);


if($_POST['btn'] == 'atualiza'){
            
    if($opcao == 'Autoriza'){
        $pr = ['codigos' => $tmp, 'usuario' => $_SESSION['name'], 'obs' => $_POST['obs'], 'action' => '36'];
        $res = loadApi($pr);
         //print_r($result);
         echo '<script>alert("'.$res.'");window.close();</script>';
    }
    if($opcao == 'Desautoriza'){
        $pr = ['codigos' => $tmp, 'usuario' => $_SESSION['name'], 'obs' => $_POST['obs'], 'action' => '37'];
        $res = loadApi($pr);
         //print_r($result);
         echo '<script>alert("'.$res.'");window.close();</script>';
    }
    if($opcao == 'Quita'){
        if(!empty($_FILES['comprovante'])){
            $file = $_FILES['comrovante'];
            $ext = pathinfo($_FILES['comprovante']['name'], PATHINFO_EXTENSION);
            $newname = $_FILES['comprovante']['name'];
            $dir = 'documentos/comprovantes/conta_pagar/';
            //echo 'Ext '.$ext;
            //echo 'NewName '.$newname;
        }
        if($ext){
            $pr = ['codigos' => $tmp, 'dt_pag' => $_POST['dt_pag'], 'usuario' => $_SESSION['name'], 'obs' => $_POST['obs'], 'comprovante' => $newname, 'action' => '38'];
            $res = loadApi($pr);
            //print_r($result);
            if($res  === "Contas a Pagar Quitadas!"){
                
                //echo 'Sucesso '.$res;
                move_uploaded_file($_FILES['comprovante']['tmp_name'], $dir.$newname);
                echo '<script>
                alert("Contas Quitadas!.");
                window.close();
                </script>';
            }else{
                //echo 'Erro '.$res;
                echo '<script>alert("Erro ao quitar contas!")</script>';
            }
        }else{
            echo '<script>alert("É necessário o envio do print do comprovante. erro"'.$_FILES['comprovante']['error'].')</script>';
        }
    }
    
}
$par = ['codigos' => $tmp, 'action' => '35'];
$result = json_decode(listarContaPagar($par));
//print_r($result);
if($result->result === "sucess"){
    $list = $result->datas;
    //print_r($list);
}else{
    echo '<script>alert("'.$result->msg.'")</script>';
}
?>

<div class="container">
    <div class="row">
<?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
    <h2 class="title text-center"><?=$opcao?> Selecionados</h2>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Fornecedor</th>
                    <th>Centro de Custo</th>
                    <th>Documento</th>
                    <th>Dt. Documento</th>
                    <th>Vr. Documento</th>
                    <th>Dt. Vencimento</th>
                    <th>Descrição</th>
                    <th>Observações</th>
                    <th>Status Autorização</th>
                    <th>Status Pagamento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list as $item){ 
                    $somaval += $item->val_doc;
                    $somamulta == $item->multa;
                    $somadesc += $item->vr_desc;
                    $somavalpag += $item->vr_pag;
                ?>
                 <tr>
                     <td><?=$item->empresa?></td>
                     <td><?=$item->fornecedor?></td>
                     <td><?=$item->centro?></td>
                     <td><?=$item->num_doc?></td>
                     <td><?=$item->dt_doc?></td>
                     <td><?=$item->val_doc?></td>
                     <td><?=$item->dt_vencimento?></td>
                     <td><?=$item->descricao?></td>
                     <td><?=$item->obs?></td>
                     <td><?=$item->status_autorizacao?></td>
                     <td><?=$item->status_pag?></td>
                 </tr>
                <?php } ?>
            </tbody>
            <tfoot>
            <tr class="tablesorter-ignoreRow"><td colspan="5" style="text-align:left;"><b>Total</b></td><td><b><?=number_format($somaval,2,',','.')?></b></td></tr>
            </tfoot>
        
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
                    <div class="form-group">
                        <input type="text" name="obs" placeholder="informe aqui as observações de autorização"  class="form-control"/>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="codigos" value="<?=$tmp?>"/>
                    <input type="hidden" name="opcao" value="<?=$opcao?>"/>
                    <button type="button" id="cancel" class="btn btn-danger">Cancelar</button>
                    <button type="submit" name="btn" value="atualiza" class="btn btn-primary"><?=$opcao?></button>
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