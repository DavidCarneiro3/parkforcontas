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
					<div class="col-sm-18">
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
								<li class="dropdown"><a href="#" ><i class="fa fa-truck" aria-hidden="true"></i> Fornecedores</a>
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
								<li><a href="#" class="active"><i class="fa fa-file-text" aria-hidden="true"></i> Documentos<i class="fa fa-angle-down"></i></a>
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
        
        $id = ($_GET['iddoc'])?$_GET['iddoc']:$_POST['iddoc'];

        if($_POST['btn']){
            //print_r($_POST);
            
            if(!empty($_FILES['documento'])){
                $file = $_FILES['documento'];
                $ext = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                $newname = $_FILES['documento']['name'];
                $dir = 'documentos/documento/';

            }
            if($ext){
                $parametros = [
                    'nota_fiscal' => $_POST['nota_fiscal'],
                    'fornecedor' => ucwords($_POST['fornecedor']),
                    'tipo' => ucwords($_POST['tipo']),
                    'num_doc' => $_POST['num_doc'],
                    'fk_empresa' => $_POST['fk_empresa'],
                    'dt_doc' => $_POST['dt_doc'],
                    'val_doc' => $_POST['val_doc'],
                    'dt_vencimento' => $_POST['dt_vencimento'],
                    'cliente' => $_POST['cliente'],
                    'frmpag' => $_POST['frmpag'],
                    'descricao' =>$_POST['descricao'],
                    'documento' =>$newname,
                    'obs' => $_POST['obs'],
                    'usuario' => $_SESSION['user'],
                    'action'=>'58'
                ];
    
                $resultados = loadApi($parametros);
                print_r($resultados);
                if($resultados->result === "sucess"){
                    
                
                    move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                    echo '<script>alert("Documento Cadastrado.")</script>';
                }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
            }else{
                $parametros = [
                    'nota_fiscal' => $_POST['nota_fiscal'],
                    'fornecedor' => ucwords($_POST['fornecedor']),
                    'tipo' => ucwords($_POST['tipo']),
                    'num_doc' => $_POST['num_doc'],
                    'fk_empresa' => $_POST['fk_empresa'],
                    'dt_doc' => $_POST['dt_doc'],
                    'val_doc' => $_POST['val_doc'],
                    'dt_vencimento' => $_POST['dt_vencimento'],
                    'cliente' => $_POST['cliente'],
                    'frmpag' => $_POST['frmpag'],
                    'descricao' =>$_POST['descricao'],
                    'codigo' => $id,
                    'obs' => $_POST['obs'],
                    'usuario' => $_SESSION['user'],
                    'action'=>'58'
                ];
    
                $resultados = loadApi($parametros);
                print_r($resultados);
                if($resultados->result === "sucess"){
                    
                
                    //move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                    echo '<script>alert("'.$resultados->datas.' - '.$resultados->msg.'")</script>';
                }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
            }
            
        }

        if($_POST['del']){
            $prms = ['action' => '57', 'codigos' => $id,];
            $del = loadApi($prms);
            if($del->result == 'sucess'){
                echo '<script>
                alert("Registro excluído!");
                window.location.href = "busca_cent.php";
                </script>';
                
            }
            else{
                echo '<script>alert("Erro ao excluir registro!")</script>';
                print_r($del);
            }
        }


        $p = ['action' => '56', 'codigos' => $id];
        $resp = loadApi($p);
        $r = $resp->datas;
        //print_r($r);
        $par = ['action' => '6'];
        $data = loadApi($par);
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $pr = ['action' => '11'];
        $retorno = loadApi($pr);
        $fr = $retorno->datas;

        $pr = ['action' => '14'];
        $ret = loadApi($pr);
        $cli= $ret->datas;

        $prm = ['action' => '42'];
        $res = loadApi($prm);

        $prm = ['action' => '28'];
        $res = loadApi($prm);

        if($res->result === "sucess"){
            $frmpag = $res->datas;
            //print_r($frmpag);
        }else{echo '<script>alert("'.$result->error.'")</script>';}
            
        $prms = ['action' => '52', 'status' => 'ATIVO'];
        $results = loadApi($prms);
    
        if($results->result === "sucess"){
            $tipos = $results->datas;
            //print_r($tipos);
        }else{echo '<script>alert("'.$results->error.'")</script>';}
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Editar Documento</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post" enctype="multipart/form-data" data-ajax="false">
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa*</label>
                            <select name="fk_empresa" id="empresa"  required="required">
                            <option value="" disabled selected>Selecione</option>
                                <?php
                                foreach($list as $item){
                                ?>
                                  <option value="<?=$item->idemp?>" <?=($item->idemp == $r[0]->fk_emp)?'selected':'' ?>><?=$item->tipo_empresa.' - '.$item->razao_social?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo de Documento*</label>
                            <select name="tipo" id="tipo" required="required">
                            <option value="" disabled selected>Selecione</option>
                            <?php
                                foreach($tipos as $key){
                                ?>
                                  <option value="<?=$key->idtipodoc?>" <?=($key->idtipodoc == $r[0]->fk_tipo)?'selected':'' ?>><?=$key->tipo?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Fornecedor*</label>
                            <select name="fornecedor" id="fornecedor" required="required">
                            <option value="" disabled selected>Selecione</option>
                            <?php
                                foreach($fr as $item){
                                ?>
                                  <option value="<?=$item->idforn?>" <?=($item->idforn == $r[0]->fk_forn)?'selected':'' ?>><?=$item->fornecedor.' - '.$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Cliente*</label>
                            <select name="cliente" id="tipo" required="required">
                            <option value="" disabled selected>Selecione</option>
                            <?php
                                foreach($cli as $key){
                                ?>
                                  <option value="<?=$key->idcli?>" <?=($key->idcli == $r[0]->fk_cliente)?'selected':'' ?>><?=$key->cliente.' - '.$key->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Numero nota fiscal*</label>
                            <input type="text" name="nota_fiscal" class="form-control" value="<?=$r[0]->num_nota?>" required="required" placeholder="Numero nota fiscal*">
                        </div>
                        </br>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Numero Documento*</label>
                            <input type="text" name="num_doc" class="form-control" required="required" value="<?=$r[0]->num_doc?>" placeholder="Numero Documento*">
                        </div>
                        </br>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Data do Documento*</label>
                            <input type="date" name="dt_doc" class="form-control" required="required" value="<?=$r[0]->dt_doc?>" placeholder="Data Documento*">
                        </div>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor do Documento*</label>
                            <input type="text" name="val_doc" id="valor" onkeyup="formatarMoeda()" class="form-control" value="<?=$r[0]->val_doc?>" placeholder="Valor Documento*" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Data do Vencimento*</label>
                            <input type="date" name="dt_vencimento" id="message" class="form-control" value="<?=$r[0]->dt_vencimento?>" placeholder="Data Vencimento*" required="required">
                        </div> 
                        <!-- <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Parcelas</label>
                        <select name="parcela" id="parcela"required="required"  style="width: 40px; margin-right: 65%;">
                            <?php for($i = 1; $i <= 60; $i++){ ?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php } ?>
                        </select>
                        </div>   
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Forma de Pagamento*</label>
                            <select name="frmpag" id="estados" required="required">
                                <option value="" selected="true">Selecione</option>
                                <?php foreach($frmpag as $frm){ ?>
                                    <option value="<?=$frm->idfrmpag?>"><?=$frm->codigo.' - '.$frm->pagamento?></option>
                                <?php } ?>
                            </select>
                        </div> -->
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Descrição*</label>
                            <input type="text" name="descricao" id="descricao" value="<?=$r[0]->descricao?>" class="form-control" required="required" placeholder="Descrição*">
                        </div> 
                        
                        
                        <div class="form-group">
                        <label>Documento</label><br/>
                        <input type="file" id="file" name="documento" accept=".doc,.docx, .pdf, .jpeg" style="widith:100%">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="obs" name="obs" id="obs" class="form-control" value="<?=$r[0]->obs?>" placeholder="Observações">
                        </div>                      
                        <div class="form-group">
                            <button type="button" id="cancel" class="btn btn-info">Voltar</button>
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
        $(document).ready(function(){
            $("#cancel").on('click',function(){
                window.close();
            })
        })
        // $(function(){
        //     $('#empresa').change(function(){
        //         if( $(this).val() ) {
        //         $('#fornecedor').hide();
        //         $('.carregando').show();
        //         $.getJSON(
        //             'includes/api.php?action=32&=',
        //             {
        //             empresa: $(this).val(),
        //             ajax: 'true'
        //             }, function(j){
        //             var options = '<option value="">Selecione</option>';
        //             for (var i = 0; i < j.length; i++) {
        //                 options += '<option value="' +
        //                 j[i].idforn + '">' +
        //                 j[i].nome_fantasia + '</option>';
        //             }
        //             $('#fornecedor').html(options).show();
        //             $('.carregando').hide();
        //             });
        //         } else {
        //         $('#fornecedor').html(
        //             '<option value="">-- Selecione uma empresa --</option>'
        //         );
        //         }
        //     });

            
        // });
        $("#telefone, #fax").mask("(00) 0000-0000");
            $("#cep").mask("00.000-000");
            $("#valor").mask("##.00", {reverse: true});
            $("#ret").mask("#.00", {reverse: true});
            $("#extra").mask("#.00", {reverse: true});
            $("#fatura").mask("#.00", {reverse: true});
            $("#irrf").mask("0.00", {reverse: true});
            $("#pis").mask("0.00", {reverse: true});
            $("#cofins").mask("0.00", {reverse: true});
            $("#csll").mask("0.00", {reverse: true});
            $("#inss").mask("0.00", {reverse: true});
            $("#iss").mask("0.00", {reverse: true});
            $("#val_doc").mask("#.00", {reverse: true});
            $("#desc").mask("#.00", {reverse: true});
            $("#val_pag").mask("#.00", {reverse: true});
            $("#multa").mask("#.00", {reverse: true});

        // function formatarMoeda() {
        //     var elemento = document.getElementById('valor');
        //     var valor = elemento.value;
            

        //     valor = valor + '';
        //     valor = parseInt(valor.replace(/[\D]+/g, ''));
        //     valor = valor + '';
        //     valor = valor.replace(/([0-9]{2})$/g, ",$1");

        //     if (valor.length > 6) {
        //         valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        //     }

        //     elemento.value = valor;
        //     if(valor == 'NaN') elemento.value = '';
            
        // }
	
    </script>
</body>
</html>