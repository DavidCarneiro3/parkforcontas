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
                $dir = 'documentos/conta_receber/';

            }
            if($ext){
                $parametros = [
                    
                    'cliente' => $_POST['cliente'],
                    'centro' => $_POST['centro'],
                    'num_doc' => $_POST['num_doc'],
                    'fk_empresa' => $_POST['fk_empresa'],
                    'dt_doc' => $_POST['dt_doc'],
                    'val_serv' => $_POST['val_serv'],
                    'val_doc' => $_POST['val_doc'],
                    'val_ret' => $_POST['val_ret'],
                    'val_extra' => $_POST['val_ext'],
                    'val_fat' => $_POST['val_fat'],
                    'val_irrf' => $_POST['val_irrf'],
                    'val_pis' => $_POST['val_pis'],
                    'val_cofins' => $_POST['val_cof'],
                    'val_csll' => $_POST['val_csll'],
                    'val_inss' => $_POST['val_inss'],
                    'val_iss' => $_POST['val_iss'],
                    'dt_vencimento' => $_POST['dt_vencimento'],
                    'reter' => $_POST['reter_iss'],
                    'descricao' => ucwords($_POST['descricao']),
                    'documento' =>$newname,
                    'obs' => ucwords($_POST['obs']),
                    'usuario' => $_SESSION['user'],
                    'codigo' => $_GET['idconta'],
                    'action'=>'48'
                ];

                //print_r($_POST);
    
                $resultados = loadApi($parametros);
                print_r($resultados);
                if($resultados->result === "sucess"){
                    
                
                    move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                    echo '<script>alert("'.$resultados->datas.'")</script>';
                }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
            }else{
                $parametros = [
                    
                    'cliente' => $_POST['cliente'],
                    'centro' => $_POST['centro'],
                    'num_doc' => $_POST['num_doc'],
                    'fk_empresa' => $_POST['fk_empresa'],
                    'dt_doc' => $_POST['dt_doc'],
                    'val_serv' => $_POST['val_serv'],
                    'val_doc' => $_POST['val_doc'],
                    'val_ret' => $_POST['val_ret'],
                    'val_extra' => $_POST['val_ext'],
                    'val_fat' => $_POST['val_fat'],
                    'val_irrf' => $_POST['val_irrf'],
                    'val_pis' => $_POST['val_pis'],
                    'val_cofins' => $_POST['val_cof'],
                    'val_csll' => $_POST['val_csll'],
                    'val_inss' => $_POST['val_inss'],
                    'val_iss' => $_POST['val_iss'],
                    'dt_vencimento' => $_POST['dt_vencimento'],
                    'reter' => $_POST['reter_iss'],
                    'descricao' => ucwords($_POST['descricao']),
                    // 'documento' =>$newname,
                    'obs' => ucwords($_POST['obs']),
                    'codigo' => $_GET['idconta'],
                    'usuario' => $_SESSION['user'],
                    'action'=>'48'
                ];

                //print_r($_POST);
    
                $resultados = loadApi($parametros);
                // print_r($resultados);
                if($resultados->result === "sucess"){
                    
                
                    // move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                    echo '<script>alert("'.$resultados->datas.' '.$resultados->msg.'")</script>';
                }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
            }
            
        }
        // $par = ['action' => '5'];
        // $data = loadApi($par);
        // $list =  $data->datas;
        
        // $param = ['action' => '7'];
        // $resu = loadApi($param);
        // $estados = $resu->datas;

        // $pr = ['action' => '14'];
        // $retorno = loadApi($pr);
        // $cli= $retorno->datas;

        // $prm = ['action' => '42'];
        // $res = loadApi($prm);

        // if($res->result === "sucess"){
        //     $frmrec= $res->datas;
        //     //print_r($frmpag);
        // }else{echo '<script>alert("'.$result->error.'")</script>';}
            
        // $prms = ['action' => '20'];
        // $results = loadApi($prms);
    
        // if($results->result === "sucess"){
        //     $centros = $results->datas;
        //     //print_r($centros);
        // }else{echo '<script>alert("'.$results->error.'")</script>';}


        // $p = ['action' => '46', 'codigos' => $_GET['idconta']];
        // $r = loadApi($prms);
        // //print_r($_POST);

        // $r = loadApi($p);
        // //print_r($r);
        //  if($r->result === "sucess"){
        //      $conta = $r->datas;
        //      //print_r($list);
        //  }else{
        //      echo '<script>alert("'.$r->msg.'")</script>';
        //  }
        $p = ['codigos' => $_GET['idconta']];
        $r = json_decode(listaContaReceber($p));
        if($r->result === "sucess"){
            $conta = $r->datas;
            //print_r($conta);
        }else{
            echo '<script>alert("'.$r->msg.'")</script>';
        }
        

        $par = ['action' => '5'];
        $data = json_decode(listaEmpresaAtiva($par));
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $pr = ['action' => '14', 'empresa' => $conta[0]->fk_emp];
        $retorno = loadApi($pr);
        $cli= $retorno->datas;

        $prm = ['action' => '42'];
        $res = loadApi($prm);

        if($res->result === "sucess"){
            $frmrec= $res->datas;
            //print_r($frmpag);
        }else{echo '<script>alert("'.$result->error.'")</script>';}
            
        $prms = ['action' => '20'];
        $results = json_decode(listaCentrosRec($prms));
    
        if($results->result === "sucess"){
            $centros = $results->datas;
            //print_r($centros);
        }else{echo '<script>alert("'.$results->error.'")</script>';}
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Inserir conta a receber</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post" enctype="multipart/form-data" data-ajax="false">
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa*</label>
                            <select name="fk_empresa" id="empresa"  required="required">
                            <option value="" disabled>Selecione</option>
                                <?php
                                foreach($list as $item){
                                ?>
                                  <option value="<?=$item->idemp?>" <?=($conta[0]->fk_emp == $item->idemp)?'selected':''?> ><?=$item->tipo_empresa.' - '.$item->razao_social?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Cliente</label>
                            <select name="cliente" id="cliente">
                            <option value=""  >Selecione</option>
                            <?php
                                foreach($cli as $item){
                                ?>
                                  <option value="<?=$item->idcli?>" <?=($conta[0]->fk_cliente == $item->idcli)?'selected':''?> ><?=$item->cliente.' - '.$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Centro de Custo</label>
                            <select name="centro" id="centro">
                            <option value=""  selected>Selecione</option>
                            <?php
                                foreach($centros as $key){
                                ?>
                                  <option value="<?=$key->idcentrorec?>" <?=($conta[0]->fk_centro == $key->idcentrorec)?'selected':''?> ><?=$key->centro?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Numero Documento*</label>
                            <input type="text" name="num_doc" class="form-control" value="<?=$conta[0]->num_doc?>" placeholder="Numero Documento*">
                        </div>
                        </br>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Data do Documento*</label>
                            <input type="date" name="dt_doc" class="form-control" value="<?=$conta[0]->dt_doc?>" required="required" placeholder="Data Documento*">
                        </div>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Serviço*</label>
                            <input type="text" name="val_serv" id="valor" class="form-control" value="<?=$conta[0]->val_servico?>" required="required" placeholder="Valor Serviço*">
                        </div>
                        </br>
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Retroativo*</label>
                            <input type="text" name="val_ret" id="ret" class="form-control" value="<?=$conta[0]->val_ret?>" placeholder="Valor*" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Extra*</label>
                            <input type="text" name="val_ext" id="extra" class="form-control" value="<?=$conta[0]->val_extra?>" placeholder="Valor*" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Fatura*</label>
                            <input type="text" name="val_fat" id="fatura" class="form-control" value="<?=$conta[0]->val_fat?>" placeholder="Valor*" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor IRRF*</label>
                            <div id="irrfi" class="info"></div>
                            <input type="text" name="val_irrf" id="irrf" class="form-control" value="<?=$conta[0]->irrf?>" style="width:90%" placeholder="Valor*" required="required">
                            
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Pis*</label>
                        <div id="pisi" class="info"></div>
                            <input type="text" name="val_pis" id="pis" class="form-control" value="<?=$conta[0]->pis?>" style="width:90%" placeholder="Valor*" required="required">
                            
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor COFINS*</label>
                            <div id="cofinsi" class="info"></div>
                            <input type="text" name="val_cof" id="cofins" class="form-control" value="<?=$conta[0]->cofins?>" style="width:90%" placeholder="Valor*" required="required">
                            
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor CSLL*</label>
                        <div id="cslli" class="info"></div>
                            <input type="text" name="val_csll" id="csll" class="form-control" value="<?=$conta[0]->csll?>" style="width:90%" placeholder="Valor*" required="required">
                           
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor INSS*</label>
                            <div id="inssi" class="info"></div>
                            <input type="text" name="val_inss" id="inss" class="form-control" value="<?=$conta[0]->inss?>" style="width:90%" placeholder="Valor*" required="required">
                            
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor ISS*</label>
                            <div id="issi" class="info"></div>
                            <input type="text" name="val_iss" id="iss" class="form-control" value="<?=$conta[0]->iss?>" style="width:90%" placeholder="Valor*" required="required">
                            
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Reter ISS*</label>
                            <select name="reter_iss" class="form-control" id="reter_iss">
                                <option value="SIM" <?=($conta[0]->reter == 'SIM')?'selected':''?> >SIM</option>
                                <option value="NÃO" <?=($conta[0]->reter == 'NÃO')?'selected':''?> >NÃO</option>
                            </select>
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Valor Documento*</label>
                        <input type="text" name="val_doc" id="val_doc" class="form-control" value="<?=$conta[0]->val_doc?>" placeholder="Valor*" required="required">
                        </div>  
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Data do Vencimento*</label>
                            <input type="date" name="dt_vencimento" id="message" class="form-control" value="<?=$conta[0]->dt_vencimento?>" placeholder="Data Vencimento*" required="required">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Descrição*</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="<?=$conta[0]->descricao?>" required="required" placeholder="Descrição*">
                        </div> 
                        
                        
                        <div class="form-group">
                        <label>Documento</label><br/>
                        <input type="file" id="file" name="documento" accept=".pdf, .jpeg, .png" style="width:100%">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="obs" name="obs" id="obs" class="form-control" value="<?=$conta[0]->obs?>" placeholder="Observações">
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
        $(document).ready(function(){
            $("#cancel").on('click',function(){
                window.close();
            })
    
            $("#telefone, #fax").mask("(00) 0000-0000");
            $("#cep").mask("00.000-000");
            $("#valor").mask("###.00", {reverse: true});
            $("#ret").mask("###.00", {reverse: true});
            $("#extra").mask("###.00", {reverse: true});
            $("#fatura").mask("###.00", {reverse: true});
            $("#irrf").mask("0.00", {reverse: true});
            $("#pis").mask("0.00", {reverse: true});
            $("#cofins").mask("0.00", {reverse: true});
            $("#csll").mask("0.00", {reverse: true});
            $("#inss").mask("0.00", {reverse: true});
            $("#iss").mask("0.00", {reverse: true});
            $("#val_doc").mask("###.00", {reverse: true});
            
            
            var codigo = $('#empresa').val();
            $.ajax({
                type: "POST",
                url: "includes/api.php",
                data: {'emp':codigo,'action':6},
                success: function(e){
                    let vals =  JSON.parse(e);
                    //console.log(e)
                    $('#irrfi').text(vals.datas[0].irrf+'%');
                    $('#pisi').text(vals.datas[0].pis+'%');
                    $('#cofinsi').text(vals.datas[0].cofins+'%');
                    $('#cslli').text(vals.datas[0].csll+'%');
                    $('#inssi').text(vals.datas[0].inss+'%');
                    $('#issi').text(vals.datas[0].iss+'%');
                }
            })
            

            $('#reter_iss').change(function(){
                reter = $(this).val();
                console.log(reter)
                var soma = parseFloat($("#val_doc").val());
                console.log('val_doc',soma)
                var iss = parseFloat($("#iss").val());
                console.log('iss',iss)
                if(reter == "NÃO"){
                    var total = (soma - iss);
                    $("#val_doc").val(total.toFixed(2).replace(',','.'))
                }else{
                    var total = (soma + iss);
                    $("#val_doc").val(total.toFixed(2).replace(',','.'))
                }
                
                
                // $.ajax({
                //     type: "POST",
                //     url: "includes/api.php",
                //     data: {'emp':codigo,'action':6},
                //     success: function(e){
                //         let vals =  JSON.parse(e);
                //         console.log(parseFloat(vals.datas[0].inss));
                //         $('#irrf').val((soma*(vals.datas[0].irrf/100)).toFixed(2));
                //         var irrf = parseFloat(soma*(vals.datas[0].irrf/100))

                //         $('#pis').val((soma*(vals.datas[0].pis/100)).toFixed(2));
                //         var pis = parseFloat(soma*(vals.datas[0].pis/100))

                //         $('#cofins').val((soma*(vals.datas[0].cofins/100)).toFixed(2));
                //         var cofins = parseFloat(soma*(vals.datas[0].cofins/100))

                //         $('#csll').val((soma*(vals.datas[0].csll/100)).toFixed(2));
                //         var csll = parseFloat(soma*(vals.datas[0].csll/100))

                //         $('#inss').val((soma*(vals.datas[0].inss/100)).toFixed(2));
                //         var inss = parseFloat(soma*(vals.datas[0].inss/100))

                //         $('#iss').val((soma*(vals.datas[0].iss/100)).toFixed(2));
                //         var iss = (soma*(vals.datas[0].iss/100))

                //         console.log('irrf+pis',parseFloat(irrf+pis));
                        
                        
                //         if(reter == "SIM"){
                //             var somav = parseFloat(soma-irrf-pis-cofins-inss-iss);
                //         }else{
                //             var somav = parseFloat(soma-irrf-pis-cofins-inss);
                //         }
                //         console.log('soma #valor',somav.toFixed(2));
                //         $('#val_doc').val(somav.toFixed(2));
                //     }
                // })
            })

            $('#valor').blur(function(){
                var a = parseFloat($('#ret').val() != ''? $('#ret').val(): 0);
                var b = parseFloat($(this).val() != ''? $(this).val(): 0)
                var soma = (a+b);

                //var valor = new Intl.NumberFormat('de-DE').format(soma.toFixed(2))
                console.log(b)

                $('#fatura').val(soma.toFixed(2));
                

                var codigo = $('#empresa').val();
                console.log(codigo)
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'emp':codigo,'action':6},
                    success: function(e){
                        let vals =  JSON.parse(e);
                        console.log(parseFloat(vals.datas[0].inss));
                        $('#irrf').val((soma*(vals.datas[0].irrf/100)).toFixed(2));
                        var irrf = parseFloat(soma*(vals.datas[0].irrf/100))

                        $('#pis').val((soma*(vals.datas[0].pis/100)).toFixed(2));
                        var pis = parseFloat(soma*(vals.datas[0].pis/100))

                        $('#cofins').val((soma*(vals.datas[0].cofins/100)).toFixed(2));
                        var cofins = parseFloat(soma*(vals.datas[0].cofins/100))

                        $('#csll').val((soma*(vals.datas[0].csll/100)).toFixed(2));
                        var csll = parseFloat(soma*(vals.datas[0].csll/100))

                        $('#inss').val((soma*(vals.datas[0].inss/100)).toFixed(2));
                        var inss = parseFloat(soma*(vals.datas[0].inss/100))

                        $('#iss').val((soma*(vals.datas[0].iss/100)).toFixed(2));
                        var iss = (soma*(vals.datas[0].iss/100))

                        console.log('irrf+pis',parseFloat(irrf+pis));
                        var somav = parseFloat(soma-irrf-pis-cofins-inss-iss);
                        console.log('soma #valor',somav.toFixed(2));

                        $('#val_doc').val(somav.toFixed(2).replace(',','.'));
                    }	
                });
                
                
            })

            $('#ret').blur(function(){
                var a = parseFloat($('#valor').val() != ''? $('#valor').val(): 0);
                var b = parseFloat($(this).val() != ''? $(this).val(): 0)
                var soma = (a+b);

                $('#fatura').val(soma.toFixed(2).replace(",","."));

                var codigo = $('#empresa').val();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'emp':codigo,'action':6},
                    success: function(e){
                        let vals =  JSON.parse(e);
                        console.log(parseFloat(vals.datas[0].inss));
                        $('#irrf').val((soma*(vals.datas[0].irrf/100)).toFixed(2));
                        var irrf = parseFloat(soma*(vals.datas[0].irrf/100))

                        $('#pis').val((soma*(vals.datas[0].pis/100)).toFixed(2));
                        var pis = parseFloat(soma*(vals.datas[0].pis/100))

                        $('#cofins').val((soma*(vals.datas[0].cofins/100)).toFixed(2));
                        var cofins = parseFloat(soma*(vals.datas[0].cofins/100))

                        $('#csll').val((soma*(vals.datas[0].csll/100)).toFixed(2));
                        var csll = parseFloat(soma*(vals.datas[0].csll/100))

                        $('#inss').val((soma*(vals.datas[0].inss/100)).toFixed(2));
                        var inss = parseFloat(soma*(vals.datas[0].inss/100))

                        $('#iss').val((soma*(vals.datas[0].iss/100)).toFixed(2));
                        var iss = (soma*(vals.datas[0].iss/100))

                        console.log('irrf+pis',parseFloat(irrf+pis));
                        var somav = parseFloat(soma-irrf-pis-cofins-inss-iss);
                        console.log('soma #valor',somav.toFixed(2));

                        $('#val_doc').val(somav.toFixed(2).replace(',','.'));
                    }	
                });
                

            })
            
            $('#extra').blur(function(){
                var a = parseFloat($('#valor').val() != ''? $('#valor').val(): 0);
                var b = parseFloat($(this).val() != ''? $(this).val(): 0)
                var soma = (a+b);

                $('#fatura').val(soma.toFixed(2).replace(",","."));

                var codigo = $('#empresa').val();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'emp':codigo,'action':6},
                    success: function(e){
                        let vals =  JSON.parse(e);
                        console.log(parseFloat(vals.datas[0].inss));
                        $('#irrf').val((soma*(vals.datas[0].irrf/100)).toFixed(2));
                        var irrf = parseFloat(soma*(vals.datas[0].irrf/100))

                        $('#pis').val((soma*(vals.datas[0].pis/100)).toFixed(2));
                        var pis = parseFloat(soma*(vals.datas[0].pis/100))

                        $('#cofins').val((soma*(vals.datas[0].cofins/100)).toFixed(2));
                        var cofins = parseFloat(soma*(vals.datas[0].cofins/100))

                        $('#csll').val((soma*(vals.datas[0].csll/100)).toFixed(2));
                        var csll = parseFloat(soma*(vals.datas[0].csll/100))

                        $('#inss').val((soma*(vals.datas[0].inss/100)).toFixed(2));
                        var inss = parseFloat(soma*(vals.datas[0].inss/100))

                        $('#iss').val((soma*(vals.datas[0].iss/100)).toFixed(2));
                        var iss = (soma*(vals.datas[0].iss/100))

                        console.log('irrf+pis',parseFloat(irrf+pis));
                        var somav = parseFloat(soma-irrf-pis-cofins-inss-iss);
                        console.log('soma #valor',somav.toFixed(2));

                        $('#val_doc').val(somav.toFixed(2).replace(',','.'));
                    }	
                });
                

            })
                    
            

        })
        
	
    </script>
</body>
</html>