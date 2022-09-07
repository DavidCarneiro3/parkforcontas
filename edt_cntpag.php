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
                'num_doc' => $_POST['num_doc'],
                'fk_empresa' => $_POST['fk_empresa'],
                'dt_doc' => $_POST['dt_doc'],
                'val_doc' => $_POST['val_doc'],
                'multa' => $_POST['multa'],
                'vr_pago' => $_POST['vr_pago'],
                'desconto' => $_POST['desconto'],
                'dt_vencimento' => $_POST['dt_vencimento'],
                'frmpag' => $_POST['frmpag'],
                'descricao' =>$_POST['descricao'],
                'documento' =>$newname,
                'obs' => $_POST['obs'],
                'usuario' => $_SESSION['user'],
                'codigo' => $_POST['idconta'],
                'action'=>'40'
            ];

            $resultados = loadApi($parametros);
            //print_r($result);
            if($resultados->result === "sucess"){
                
            
                move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                echo '<script>alert("Conta a Pagar Cadastrada.")</script>';
            }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
        }else{
            $parametros = [
                'nota_fiscal' => $_POST['nota_fiscal'],
                'fornecedor' => ucwords($_POST['fornecedor']),
                'centro' => ucwords($_POST['centro']),
                'num_doc' => $_POST['num_doc'],
                'fk_empresa' => $_POST['fk_empresa'],
                'dt_doc' => $_POST['dt_doc'],
                'val_doc' => $_POST['val_doc'],
                'multa' => $_POST['multa'],
                'vr_pago' => $_POST['vr_pago'],
                'desconto' => $_POST['desconto'],
                'dt_vencimento' => $_POST['dt_vencimento'],
                'frmpag' => $_POST['frmpag'],
                'descricao' =>$_POST['descricao'],
                //'documento' =>$newname,
                'obs' => $_POST['obs'],
                'usuario' => $_SESSION['user'],
                'codigo' => $_POST['idconta'],
                'action'=>'40'
            ];

            $resultados = loadApi($parametros);
             print_r($resultados);
            //echo '<script>alert("'.$resultados->campo.'")</script>';
            if($resultados->result === "sucess"){
                //move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                echo '<script>alert("'.$resultados->msg.' '.$resultados->msg.'")</script>';
            }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
        }
        
    }
        $p = ['action' => 35, 'codigos' => ($_GET['idconta'])?$_GET['idconta']:$_POST['idconta']];
        $r = json_decode(listarContaPagar($p));
        if($r->result === "sucess"){
            $dados = $r->datas;
            // print_r($dados);
        }else{echo '<script>alert("'.$r->error.'")</script>';}

        
            
        $prms = ['action' => '20', 'empresa' => $dados[0]->fk_emp];
        $results = json_decode(listaCentros($prms));
        // print_r($results);
        if($results->result === "sucess"){
            $centros = $results->datas;
            //print_r($centros);
        }else{echo '<script>alert("'.$results->error.'")</script>';}

        $par = ['action' => '6'];
        $data = loadApi($par);
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $pr = ['action' => '11', 'empresa' => $dados[0]->fk_emp];
        $retorno = json_decode(listaFornecedor($pr));
        $fr = $retorno->datas;
        // print_r($pr);
        $prm = ['action' => '28', 'empresa' => $dados[0]->fk_emp];
        $res = loadApi($prm);
        if($res->result === "sucess"){
            $frmpag = $res->datas;
            //print_r($frmpag);
        }else{echo '<script>alert("'.$res->error.'")</script>';}

        //echo $dados[0]->fk_centro;
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Editar conta a pagar</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post" enctype="multipart/form-data" data-ajax="false">
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa*</label>
                            <select name="fk_empresa" id="empresa"  class="form-control" required="required">
                            <option value=""  >Selecione</option>
                                <?php
                                foreach($list as $item){
                                ?>
                                  <option value="<?=$item->idemp?>" <?=($dados[0]->fk_emp==$item->idemp)? 'selected' : '' ?>><?=$item->tipo_empresa.' - '.$item->razao_social?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Fornecedor</label>
                            <select name="fornecedor"  class="form-control" id="fornecedor">
                            <option value=""  >Selecione</option>
                            <?php
                                foreach($fr as $item){
                                ?>
                                  <option value="<?=$item->idforn?>" <?=($dados[0]->fk_forn==$item->idforn)? 'selected' : '' ?> ><?=$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Centro de Custo</label>
                            <select name="centro" id="centro"  class="form-control">
                            <option value=""  >Selecione</option>
                            <?php
                                foreach($centros as $key){
                                ?>
                                  <option value="<?=$key->idcentro?>" <?=($dados[0]->fk_centro==$key->idcentro)? 'selected' : '' ?> ><?=$key->centro?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Numero nota fiscal*</label>
                            <input type="text" name="nota_fiscal" class="form-control" required="required" value="<?=$dados[0]->num_nota?>" placeholder="Numero nota fiscal*">
                        </div>
                        </br>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Numero Documento*</label>
                            <input type="text" name="num_doc" class="form-control" required="required" value="<?=$dados[0]->num_doc?>" placeholder="Numero Documento*">
                        </div>
                        </br>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Data do Documento*</label>
                            <input type="date" name="dt_doc" class="form-control" required="required" value="<?=$dados[0]->dt_doc?>" placeholder="Data Documento*">
                        </div>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor do Documento*</label>
                            <input type="text" name="val_doc" id="valdoc" onkeyup="formatarMoeda()" class="form-control" value="<?=number_format($dados[0]->val_doc,2,',','.')?>" placeholder="Valor Documento*" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Multa/Juros/Encargos</label>
                            <input type="text" name="multa" id="valormul" onkeyup="formatarMoeda()" class="form-control" value="<?=number_format($dados[0]->multa,2,',','.')?>" placeholder="Valor Multa" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Desconto</label>
                            <input type="text" name="desconto" id="valordesc" onkeyup="formatarMoeda()" class="form-control" value="<?=number_format($dados[0]->vr_desc,2,',','.')?>" placeholder="Valor Desconto" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Pago</label>
                            <input type="text" name="vr_pago" id="valorpag" onkeyup="formatarMoeda()" class="form-control" value="<?=number_format($dados[0]->vr_pag,2,',','.')?>" placeholder="Valor Pago" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Data do Vencimento*</label>
                            <input type="date" name="dt_vencimento" id="message" class="form-control" value="<?=$dados[0]->dt_vencimento?>" placeholder="Data Vencimento*" required="required">
                        </div>  
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Forma de Pagamento*</label>
                            <select name="frmpag" id="estados"   class="form-control">
                                <option value="" selected="true">Selecione</option>
                                <?php foreach($frmpag as $frm){ ?>
                                    <option value="<?=$frm->idfrmpag?>" <?=($dados[0]->fk_frmpag==$frm->idfrmpag)? 'selected' : '' ?> ><?=$frm->codigo.' - '.$frm->pagamento?></option>
                                <?php } ?>
                            </select>
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Descrição*</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="<?=$dados[0]->descricao?>" required="required" placeholder="Descrição*">
                        </div> 
                        
                        
                        <div class="form-group">
                        <label>Documento</label><br/>
                        <input type="file" id="file" name="documento" accept=".pdf, .jpeg, .png" style="widith:100%">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="obs" name="obs" id="obs" class="form-control" value="<?=$dados[0]->obs?>" placeholder="Observações">
                        </div>                      
                        <div class="form-group">
                            <input type="hidden" name="idconta" value="<?=$_GET['idconta']?>"/>
                            <button type="button" id="cancel" class="btn btn-danger">Cancelar</button>
                            <input type="submit" name="btn" class="btn btn-primary" value="Atualizar">
                        </div>
                        <?php
                            
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
        $("#telefone, #fax").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");
        $("#valor").mask("##.00", {reverse: true});
        $("#ret").mask("#.00", {reverse: true});
        $("#extra").mask("#.00", {reverse: true});
        $("#fatura").mask("#.00", {reverse: true});
        $("#valordesc").mask("###.00", {reverse: true});
        $("#valormul").mask("###.00", {reverse: true});
        $("#valorpag").mask("###.00", {reverse: true});
        $("#csll").mask("0.00", {reverse: true});
        $("#inss").mask("0.00", {reverse: true});
        $("#iss").mask("0.00", {reverse: true});
        $("#valdoc").mask("###.00", {reverse: true});

        $("#valordesc").blur(function(){
            var val_doc = parseFloat($("#valdoc").val());
            console.log('Doc',val_doc)
            var valor = parseFloat($("#valordesc").val());
            console.log('Desc',valor)
            var valor2 = parseFloat($("#valormul").val())
            var soma = parseFloat(valor+valor2);
            var total = parseFloat(val_doc + valor2 - valor);
            console.log('Total',total)

            $("#valorpag").val(total);

        })
        $("#valormul").blur(function(){
            var val_doc = parseFloat($("#valdoc").val());
            var valor = parseFloat($("#valordesc").val());
            var valor2 = parseFloat($("#valormul").val())
            var soma = parseFloat(valor+valor2);
            var total = parseFloat(val_doc + valor2 -valor);
            console.log('Total',total)

            $("#valorpag").val(total);

        })
    })
        
        $("#cancel").on('click',function(){
            window.close();
        })
    
     
		$("#telefone, #fax").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");

        function formatarMoeda() {
            var elemento = document.getElementById('valor');
            var valor = elemento.value;
            

            valor = valor + '';
            valor = parseInt(valor.replace(/[\D]+/g, ''));
            valor = valor + '';
            valor = valor.replace(/([0-9]{2})$/g, ",$1");

            if (valor.length > 6) {
                valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
            }

            elemento.value = valor;
            if(valor == 'NaN') elemento.value = '';
            
        }
	
    </script>
</body>
</html>