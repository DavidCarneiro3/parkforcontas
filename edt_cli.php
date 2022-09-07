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
<!--<div class="header-bottom">
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
								<li class="dropdown"><a href="#"><i class="fa fa-truck" aria-hidden="true"></i> Fornecedores</a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="insert_forne.php">Inserir</a></li>
										<li><a href="busca_forn.php">Consultar/Editar</a></li>
                                    </ul>
                                </li> 
								<li><a href="#" class="active"><i class="fa fa-users" aria-hidden="true"></i>Clientes<i class="fa fa-angle-down"></i></a>
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
		</div>-->
<!--/header-bottom-->
	</header><!--/header-->
<br />
    <?php
        if($_POST['btn']){
            $params = [
                'cpf_cnpj' => $_POST['cnpj'],
                'cliente' => ucwords($_POST['cliente']),
                'fantasia' => ucwords($_POST['nome_fantasia']),
                'tipo_cliente' => $_POST['tipo_cliente'],
                'fk_empresa' => $_POST['empresa'],
                'endereco' => $_POST['endereco'],
                'complemento' => $_POST['complemento'],
                'bairro' => $_POST['bairro'],
                'cep' => $_POST['cep'],
                'uf' => $_POST['uf'],
                'cidade' =>$_POST['cidade'],
                'fone' => $_POST['fone'],
                'fax' => $_POST['fax'],
                'email' => $_POST['email'],
                'reter' => $_POST['reter'],
                'usuario' => $_SESSION['user'],
                'action'=> '17'
            ];
            //print_r($_POST);
            //echo '</br>';
            $result = loadApi($params);
            // print_r($result);
            if($result->result === "sucess"){
                echo '<script>alert("Cliente Atualizado.")</script>';
            }else{echo '<script>alert("'.$result->error.'")</script>';}
        }
        
        if($_POST['del']){
            //print_r($_POST);
            $del = ['idcli' => $_POST['idcli'],'action' => '22', 'usuario' => $_SESSION['mame']];
            $result = loadApi($del);
            if($result->result == 'sucess'){
                echo '<script>alert("Registro excluído!")</script>';
                header('Location: busca_cli.php');
            }
            else{
                echo '<script>alert("Erro ao excluir registro!")</script>';
                //print_r($result);
            }
            
        }

        $par = ['action' => '6'];
        $data = loadApi($par);
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $parameter = ['action' => '14', 'id_cli' => $_GET['idcli']];
        $data = loadApi($parameter);
        $res = $data->datas;
        // print_r($res);
            // if($res->result === "sucess"){
            //     $emp = $res->datas;
            //     print_r($emp);
            // }else{
            //     echo '<script>alert('.$result->error.')</script>';
            // }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Editar Cliente</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        <input type="hidden" name="cnpj" value="<?=$res[0]->cpf_cnpj?>">
                        <div class="form-group">
                            <input type="number" name="cpfcnpj" class="form-control" value="<?=$res[0]->cpf_cnpj?>" disabled="true" placeholder="CPF/CNPJ Apenas números*">
                        </div>
                         <div class="form-group">
                                    <label class="col-sm-2 col-form-label">Empresa</label>
                                    <select name="empresa" id="empresa" class="form-control">
                                    <option value="" selected>Selecione</option>
                                        <?php
                                        foreach($list as $item){
                                        ?>
                                        <option value="<?=$item->idemp?>" <?=($item->idemp == $res[0]->fk_empresa)?'selected':''?>><?=$item->tipo_empresa.' - '.$item->nome_fantasia?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo Cliente*</label>
                            <select name="tipo_cliente" >
                            <option value="" disabled selected>Selecione</option>
                                <option value="PF" <?=($res[0]->tipo_cliente == 'PF')?'selected':''?>>Pessoa Física</option>
                                <option value="PJ" <?=($res[0]->tipo_cliente == 'PJ')?'selected':''?>>Pessoa Jurídica</option>
                            </select>
                        </div>
                        </br>
                        <div class="form-group">
                            <input type="text" name="cliente" class="form-control" value="<?=$res[0]->cliente?>" required="required" placeholder="Nome Cliente*">
                        </div>
                        </br>
                        <div class="form-group">
                            <input type="text" name="nome_fantasia" class="form-control"  value="<?=$res[0]->nome_fantasia?>" required="required" placeholder="Nome Fantasia*">
                        </div>
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">Endereço</label> -->
                            <input type="text" name="endereco" id="message" class="form-control" value="<?=$res[0]->endereco?>" placeholder="Endereço*" required="required">
                        </div> 
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">PIS</label> -->
                            <input type="text" name="complemento" id="message" class="form-control" value="<?=$res[0]->complemento?>" placeholder="Complemento">
                        </div> 
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">COFINS</label> -->
                            <input type="text" name="bairro" id="message" class="form-control" value="<?=$res[0]->bairro?>" required="required" placeholder="Bairro*">
                        </div> 
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">CSLL</label> -->
                            <input type="text" name="cep" id="cep" class="form-control" value="<?=$res[0]->cep?>" required="required" placeholder="CEP*">
                        </div> 
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Estado(UF)*</label>
                            <select name="uf" id="estados" required="required">
                                <option value="" selected="true">Selecione</option>
                                <?php foreach($estados as $uf){ ?>
                                    <option value="<?=$uf->sigl_estado?>" <?=$res[0]->uf?"selected":""?>><?=$uf->sigl_estado.' - '.$uf->dsc_estado?></option>
                                <?php } ?>
                            </select>
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Cidade*</label>
                        <select name="cidade" id="cod_cidades"required="required" >
                            <option value="<?=$res[0]->cidade?>"><?=$res[0]->cidade?></option>
                        </select>
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="fone" id="telefone" class="form-control" value="<?=$res[0]->fone?>" required="required" placeholder="Telefone*">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="fax" id="fax" class="form-control" value="<?=$res[0]->fax?>"  placeholder="Fax">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="email" id="message" class="form-control" value="<?=$res[0]->email?>"  placeholder="Email">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                        <label style="float: left; margin-left: 2%;">Reter ISS*</label>
                            <select name="reter" required="required">
                            <option value="" disabled selected>Selecione</option>
                                <option value="SIM" <?=($res[0]->reter == 'SIM')?'selected':''?>>Sim</option>
                                <option value="NÃO" <?=($res[0]->reter == 'NÃO')?'selected':''?>>Não</option>
                            </select>
                        </div> 
                        <input type="hidden" name="idcli" value="<?=$res[0]->idcli?>"/>                      
                        <div class="form-group">
                        <a class="btn btn-info" href="javascript:location.href = 'busca_cli.php'">Voltar</a>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Aviso!</h5>
                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button> -->
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir esse registro!?
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