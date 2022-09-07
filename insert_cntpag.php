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
		</div>-->
<!--/header-bottom-->
	</header><!--/header-->
<br />
    <?php
        

        $par = ['action' => '5', 'status' => 'ATIVA'];
        $data = loadApi($par);
        $list =  $data->datas;
        //print_r($list);
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        // $pr = ['action' => '11'];
        // $retorno = loadApi($pr);
        // $fr = $retorno->datas;

        $prm = ['action' => '28'];
        $res = loadApi($prm);

        if($res->result === "sucess"){
            $frmpag = $res->datas;
            //print_r($frmpag);
        }
            
        $prms = ['action' => '20'];
        $results = loadApi($prms);
    
        if($results->result === "sucess"){
            $centros = $results->datas;
            //print_r($centros);
        }
        $hoje = date("Y-m-d");
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Inserir conta a pagar</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post" enctype="multipart/form-data" data-ajax="false">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Empresa*</label>
                            <div class="col-sm-10">
                                <select name="fk_empresa" id="empresa" class="form-control"  required="required">
                                
                                    <option value="" disabled selected>Selecione</option>
                                    <?php
                                    foreach($list as $item){
                                    ?>
                                    <option value="<?=$item->idemp?>"><?=$item->tipo_empresa.' - '.$item->nome_fantasia?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fornecedor*</label>
                            <div class="col-sm-10">
                                <select name="fornecedor" id="fornecedor" class="form-control">
                                    
                                <option value="" disabled selected>Selecione</option>
                                <?php
                                    //foreach($fr as $item){
                                    ?>
                                    <!-- <option value="<?=$item->idforn?>"><?=$item->fornecedor.' - '.$item->nome_fantasia?></option> -->
                                    <?php 
                                // }
                                    ?>
                                </select>
                                <div id="carregando-forn" style="display:none">Carregando...</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Centro de Custo*</label>
                            <div class="col-sm-10">
                                <select name="centro" id="centro" class="form-control" required="required">
                                <option value="" disabled selected>Selecione</option>
                                <?php
                                    foreach($centros as $key){
                                    ?>
                                    <option value="<?=$key->idcentro?>"><?=$key->centro?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <div id="carregando-cent" style="display:none">Carregando...</div>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Numero nota fiscal</label>
                            <div class="col-sm-10">
                                <input type="text" name="nota_fiscal" class="form-control"  placeholder="Numero nota fiscal">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Numero Documento*</label>
                            <div class="col-sm-10">
                                <input type="text" name="num_doc" class="form-control" required="required" placeholder="Numero Documento*">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Data do Documento*</label>
                            <div class="col-sm-10">
                                <input type="date" name="dt_doc" class="form-control" value="<?=$hoje?>" required="required" placeholder="Data Documento*">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Valor do Documento*</label>
                            <div class="col-sm-10">
                                <input type="text" name="val_doc" id="valor" onkeyup="formatarMoeda()" class="form-control" placeholder="Valor Documento*" required="required">
                            </div>
                        </div> 
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Data do Vencimento*</label>
                            <div class="col-sm-10">
                                <input type="date" name="dt_vencimento" id="message" class="form-control" placeholder="Data Vencimento*" required="required">
                            </div>
                        </div> 
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Parcelas</label>
                        <div class="col-sm-10">
                        <select name="parcela" id="parcela" class="form-control" style="width: 70px; margin-right: 65%;">
                            <?php for($i = 1; $i <= 60; $i++){ ?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php } ?>
                        </select>
                        </div>
                        </div>  
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Forma de Pagamento*</label>
                            <div class="col-sm-10">
                                <select name="frmpag" id="pagamento" class="form-control" required="required">
                                    <option value="" selected="true">Selecione</option>
                                    <?php foreach($frmpag as $frm){ ?>
                                        <option value="<?=$frm->idfrmpag?>"><?=$frm->codigo.' - '.$frm->pagamento?></option>
                                    <?php } ?>
                                </select>
                                <div id="carregando-pag" style="display:none">Carregando...</div>
                            </div>
                        </div> 
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Descrição*</label>
                        <div class="col-sm-10">
                            <input type="text" name="descricao" id="descricao" class="form-control" required="required" placeholder="Descrição*">
                        </div>
                        </div> 
                        
                        
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Documento</label><br/>
                        <div class="col-sm-10">
                            <input type="file" id="file" name="documento" accept=".pdf, .jpeg, .png" style="widith:100%">
                        </div>
                        </div>  
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Observações</label>
                        <div class="col-sm-10">
                            <input type="obs" name="obs" id="obs" class="form-control"  placeholder="Observações">
                        </div>
                        </div>                      
                        <div class="form-group row">
                            <input type="submit" name="btn" class="btn btn-primary" value="Cadastrar">
                        </div>
                        <?php
                            if($_POST['btn']){
                                //print_r($_POST);
                                
                                if(!empty($_FILES['documento'])){
                                    $file = $_FILES['documento'];
                                    $ext = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                                    $newname = $_FILES['documento']['name'];
                                    $dir = 'documentos/conta_pagar/';

                                }
                                if($ext){
                                    $parametros = [
                                        'nota_fiscal' => $_POST['nota_fiscal'],
                                        'fornecedor' => ucwords($_POST['fornecedor']),
                                        'centro' => ucwords($_POST['centro']),
                                        'num_doc' => addslashes($_POST['num_doc']),
                                        'fk_empresa' => $_POST['fk_empresa'],
                                        'dt_doc' => $_POST['dt_doc'],
                                        'val_doc' => $_POST['val_doc'],
                                        'dt_vencimento' => $_POST['dt_vencimento'],
                                        'parcela' => $_POST['parcela'],
                                        'frmpag' => $_POST['frmpag'],
                                        'descricao' =>$_POST['descricao'],
                                        'documento' =>$newname,
                                        'obs' => $_POST['obs'],
                                        'usuario' => $_SESSION['user'],
                                        'action'=>'34'
                                    ];
                        
                                    $resultados = json_decode(inserirContaPagar($parametros));
                                    print_r($resultados);
                                    if($resultados->result === "sucess"){
                                        
                                    
                                        move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                                        echo '<script>alert("Conta a Pagar Cadastrada.")</script>';
                                    }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
                                }else{
                                    echo '<script>alert("É necessário o envio do print do documento")</script>';
                                }
                                
                            }
                    ?>
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
            // $("#fornecedor").change(function(){alert($("#fornecedor").val())});
            // $("#centro").change(function(){alert($("#centro").val())});

            $('#empresa').change(function(){
                var empresa = $(this).val();
                var options = '<option value="">Selecione</option>';
                if( $(this).val() ) {
                $('#fornecedor').hide();
                $('#carregando-forn').show();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':empresa,'action':32},
                    success: function(j){
                        console.log(j)
                        let values = JSON.parse(j);
                        if(values){
                            values.forEach(function(el){
                                options += '<option value="' +
                                el.idforn + '">' +
                                el.fornecedor + '</option>';
                            })
                            //console.log(options)
                            $('#fornecedor').html(options).show();
                            $('#carregando-forn').hide();
                        }else{
                            $('#fornecedor').html(
                                '<option value="">-- Selecione uma empresa --</option>'
                            ).show();
                            $('#carregando-forn').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#fornecedor').html(
                            '<option value="">-- Selecione uma empresa --</option>'
                        ).show();
                        $('#carregando-forn').hide();
                    }
                })
                }
            })

            $('#empresa').change(function(){
                var empresa = $(this).val();
                var options = '<option value="">Selecione</option>';
                if( $(this).val() ) {
                $('#centro').hide();
                $('#carregando-cent').show();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':empresa,'action':33},
                    success: function(j){
                        console.log(j)
                        let values = JSON.parse(j);
                        if(values != "null"){
                            values.forEach(function(el){
                                options += '<option value="' +
                                el.idcentro + '">' +
                                el.centro + '</option>';
                            })
                            //console.log(options)
                            $('#centro').html(options).show();
                            $('#carregando-cent').hide();
                        }else{
                            $('#centro').html(
                                '<option value="">-- Selecione um centro de custo --</option>'
                            ).show();
                            $('#carregando-cent').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#centro').html(
                            '<option value="">-- Selecione um centro de custo --</option>'
                        ).show();
                        $('#carregando-cent').hide();
                    }
                })
                }
            })
            
            $('#empresa').change(function(){
                var empresa = $(this).val();
                var options = '<option value="">Selecione</option>';
                if( $(this).val() ) {
                $('#pagamento').hide();
                $('#carregando-pag').show();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':empresa,'action':65},
                    success: function(j){
                        console.log('Pagamentos',j)
                        let values = JSON.parse(j);
                        if(values){
                            values.forEach(function(el){
                                options += '<option value="' +
                                el.idfrmpag + '">' +
                                el.pagamento + '</option>';
                            })
                            //console.log(options)
                            $('#pagamento').html(options).show();
                            $('#carregando-pag').hide();
                        }else{
                            $('#pagamento').html(
                                '<option value="">-- Selecione um centro de custo --</option>'
                            );
                            $('#carregando-pag').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#pagamento').html(
                            '<option value="">-- Selecione um centro de custo --</option>'
                        ).show();
                        $('#carregando-pag').hide();
                    }
                })
                }
            })

            
        });
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