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
        <!-- <div id="loader-wrapper">
            <div class="logo"></div>
            <div id="loader">
            </div>
        </div> -->
        <!-- end preloader -->
		
		<br />

	</header><!--/header-->
<br />
    <?php
        $par = ['action' => '5'];
        $conv = json_decode(listarConveniosEmpresas($par));
        //print_r($conv);
        $convenios =  $conv->datas;
        

        $par = ['action' => '5'];
        $data = json_decode(listaEmpresaAtiva($par));
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $pr = ['action' => '14'];
        $retorno = loadApi($pr);
        $cli= $retorno->datas;

        $prm = ['action' => '42'];
        $res = loadApi($prm);

        if($res->result === "sucess"){
            $frmrec= $res->datas;
            //print_r($frmpag);
        }
            
        $prms = ['action' => '20'];
        $results = json_decode(listaCentrosRec($prms));
    
        if($results->result === "sucess"){
            $centros = $results->datas;
            //print_r($centros);
        }

        $pmts = ['ativo' => 'Sim','action' => '42', 'empresa' => $_POST['empresa']];
            $rst = json_decode(listarFormaRecebimento($pmts));
            //print_r($rst);
            if($rst->result === "sucess"){
                $frmpag = $rst->datas;
                //print_r($emp);
            }

        $hoje = date("Y-m-d");
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
                    'fk_empresa' => $_POST['empresa'],
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
                    'recebimento' => $_POST['recebimento'],
                    'convenio' => $_POST['convenio'],
                    'protesta' => $_POST['protesta'],
                    'dias_protesta' => $_POST['dias_protesta'],
                    'negativa' => $_POST['negativa'],
                    'dias_negativa' => $_POST['dias_negativa'],
                    'orgao_negativa' => $_POST['orgao_negativa'],
                    'dias_venc' => $_POST['dias_venc'],
                    'juros' => $_POST['juros_bol'],
                    'multa' => $_POST['multa_bol'],
                    'vencimento_boleto' => $_POST['vencimento_boleto'],
                    'dias_venc' => $_POST['dias_venc'],
                    'parcela' => $_POST['parcela'],
                    'action'=>'45'
                ];

                //print_r($_POST);
    
                $resultados = json_decode(inserirContaReceber($parametros));
                // print_r($resultados);
                if($resultados->result === "sucess"){
                    
                
                    move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                    echo '<script>alert("'.$resultados->datas.'")</script>';
                }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
            }else{
                $parametros = [
                    
                    'cliente' => $_POST['cliente'],
                    'centro' => $_POST['centro'],
                    'num_doc' => $_POST['num_doc'],
                    'fk_empresa' => $_POST['empresa'],
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
                    'descricao' => ucwords(addslashes($_POST['descricao'])),
                    // 'documento' =>$newname,
                    'obs' => ucwords(addslashes($_POST['obs'])),
                    'usuario' => $_SESSION['user'],
                    'recebimento' => $_POST['recebimento'],
                    'convenio' => $_POST['convenio'],
                    'protesta' => $_POST['protesta'],
                    'dias_protesto' => $_POST['dias_protesto'],
                    'negativa' => $_POST['negativa'],
                    'dias_negativa' => $_POST['dias_negativa'],
                    'orgao_negativa' => $_POST['orgao_negativa'],
                    'juros' => $_POST['juros_bol'],
                    'multa' => $_POST['multa_bol'],
                    'vencimento_boleto' => $_POST['vencimento_boleto'],
                    'dias_venc' => $_POST['dias_venc'],
                    'parcela' => $_POST['parcela'],
                    'action'=>'45'
                ];

                // print_r($_POST);
    
                $resultados = json_decode(inserirContaReceber($parametros));
                // print_r($resultados);
                if($resultados->result === "sucess"){
                    
                
                    // move_uploaded_file($_FILES['documento']['tmp_name'], $dir.$newname);
                    echo '<script>alert("'.$resultados->datas.'")</script>';
                }else{echo '<script>alert("'.$resultados->error.' - '.$resultados->msg.'")</script>';}
            }

            $hoje = $_POST['dt_doc'];
            
        }
                    
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Inserir conta a receber</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post" enctype="multipart/form-data" data-ajax="false">
                    <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Empresa</label>
                                    <div class="col-sm-10">
                                    <select name="empresa" id="empresa" class="form-control">
                                    <option value="" selected>Selecione</option>
                                        <?php
                                        foreach($list as $item){
                                        ?>
                                        <option value="<?=$item->idemp?>" <?=($item->idemp == $_POST['empresa'])?'selected':''?>><?=$item->tipo_empresa.' - '.$item->nome_fantasia?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Centro de Custos</label>
                                    <div class="col-sm-10">
                                    <select name="centro" id="centro" class="form-control">
                                    <option value="" selected>Selecione</option>
                                        <?php
                                        foreach($centros as $item){
                                        ?>
                                        <option value="<?=$item->idcentrorec?>" <?=($item->idcentrorec == $_POST['centro'])?'selected':''?>><?=$item->centro?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div id="carregando-cent" style="display:none">Carregando...</div>
                                </div>
                            
                                <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Cliente</label>
                            <div class="col-sm-10">
                            <select name="cliente" id="cliente" class="form-control">
                            <option value=""  selected>Selecione</option>
                            <?php
                                foreach($cli as $item){
                                ?>
                                  <option value="<?=$item->idcli?>" <?=($item->idcli == $_POST['cliente'])?'selected':''?>><?=$item->cliente.' - '.$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                            <div id="carregando-cli" style="display:none">Carregando...</div>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Numero Documento*</label>
                        <div class="col-sm-10">
                            <input type="text" name="num_doc" class="form-control" value="<?=$_POST['num_doc']?>" required="required" placeholder="Numero Documento*">
                        </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Data do Documento*</label>
                            <div class="col-sm-10">
                            <input type="date" name="dt_doc" class="form-control" value="<?=$hoje?>" required="required" placeholder="Data Documento*">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor*</label>
                        <div class="col-sm-10">
                            <input type="text" name="val_serv" id="valor" class="form-control" value="0.00" required="required" placeholder="Valor Serviço*">
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
                        <label  class="col-sm-2 col-form-label">Valor Retroativo*</label>
                        <div class="col-sm-10">
                            <input type="text" name="val_ret" id="ret" class="form-control" value="0.00" placeholder="Valor*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor Extra*</label>
                        <div class="col-sm-10">
                            <input type="text" name="val_ext" id="extra" class="form-control" value="0.00" placeholder="Valor*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor Fatura*</label>
                        <div class="col-sm-10">
                            <input type="text" name="val_fat" id="fatura" class="form-control" value="0.00" placeholder="Valor*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor IRRF*</label>
                        <div class="col-sm-10">
                            <div id="irrfi" class="info"></div>
                            <input type="text" name="val_irrf" id="irrf" class="form-control" style="width:90%" placeholder="Valor*" required="required">
                        </div>
                            
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor Pis*</label>
                        <div class="col-sm-10">
                        <div id="pisi" class="info"></div>
                            <input type="text" name="val_pis" id="pis" class="form-control" style="width:90%" placeholder="Valor*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor COFINS*</label>
                        <div class="col-sm-10">
                            <div id="cofinsi" class="info"></div>
                            <input type="text" name="val_cof" id="cofins" class="form-control" style="width:90%" placeholder="Valor*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor CSLL*</label>
                        <div class="col-sm-10">
                        <div id="cslli" class="info"></div>
                            <input type="text" name="val_csll" id="csll" class="form-control" style="width:90%" placeholder="Valor*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor INSS*</label>
                        <div class="col-sm-10">
                            <div id="inssi" class="info"></div>
                            <input type="text" name="val_inss" id="inss" class="form-control" style="width:90%" placeholder="Valor*" required="required">
                        </div>
                        
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor ISS*</label>
                        <div class="col-sm-10">
                            <div id="issi" class="info"></div>
                            <input type="text" name="val_iss" id="iss" class="form-control" style="width:90%" placeholder="Valor*" required="required">
                        </div>   
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Reter ISS*</label>
                        <div class="col-sm-10">
                            <select name="reter_iss" class="form-control" id="reter_iss">
                                <option value="SIM" selected>SIM</option>
                                <option value="NÃO">NÃO</option>
                            </select>
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Valor Documento*</label>
                        <div class="col-sm-10">
                            <input type="text" name="val_doc" id="val_doc" class="form-control" placeholder="Valor*" required="required">
                        </div>
                        </div>  
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Data do Vencimento*</label>
                        <div class="col-sm-10">
                            <input type="date" name="dt_vencimento" id="message"  value="<?=$_POST['dt_vencimento']?>" class="form-control" placeholder="Data Vencimento*" required="required">
                        </div>
                        </div> 
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Descrição*</label>
                        <div class="col-sm-10">
                            <input type="text" name="descricao" id="descricao" value="<?=$_POST['descricao']?>" class="form-control" required="required" placeholder="Descrição*">
                        </div>
                        </div> 
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Forma de Recebimento</label>
                            <div class="col-sm-10">
                            <select name="recebimento" id="recebimento" class="form-control">
                                <option value="" selected>Selecione</option>
                                <?php
                                    foreach($frmpag as $item){
                                    ?>
                                    <option value="<?=$item->idfrmrec?>" <?=($item->idfrmrec == $_POST['recebimento'])?'selected':''?>><?=$item->codigo?> - <?=$item->recebimento?></option>
                                    <?php 
                                    }
                                    ?>
                            </select>
                            <div id="carregando-rec" style="display:none">Carregando...</div>
                        </div>
                        
                        </div>
                        
                        
                        <div id="control" class="control">
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Convenio</label>
                            <div class="col-sm-10">
                            <select name="convenio" class="form-control" id="convenio">
                                    <option value="">Selecione</option>
                                    <!--<option value="2184070">NECAVA</option>
                                    <option value="2786559">PARKFOR</option>
                                    <option value="3309918">TSST</option>
                                    <option value="3348211">V&T</option>
                                    <option value="3468148">MARAPONGA FOOD</option>
                                    <option value="3035927">CIPETRAN PP</option>-->
                                    <?php 
                                    foreach($convenios as $item){
                                        ?>
                                        <option value="<?=$item->convenio?>"><?=$item->nome_fantasia?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            </div> 
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Protestar Boleto</label>
                            <div class="col-sm-10">
                            <select name="protesta" class="form-control" id="protesta">
                                    <option value="SIM">SIM</option>
                                    <option value="NÃO" selected>NÃO</option>
                                </select>
                            </div>
                            </div> 
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Dias para protetar</label>
                            <div class="col-sm-10">
                                <input type="text" name="dias_protesto" id="dias_prot" value="0" class="form-control" disabled placeholder="Dias para protestar boleto">
                            </div>
                            </div> 
                            
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Nagativar Boleto</label>
                            <div class="col-sm-10">
                            <select name="negativa" class="form-control" id="negativa">
                                    <option value="SIM">SIM</option>
                                    <option value="NÃO" selected>NÃO</option>
                                </select>
                            </div>
                            </div> 
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Dias para negativar</label>
                            <div class="col-sm-10">
                                <input type="text" name="dias_negativa" id="diasnegativa"  value="0" class="form-control" disabled placeholder="Dias para negativar boleto">
                            </div>
                            </div> 
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Orgão Negativador</label>
                            <div class="col-sm-10">
                            <select name="orgao_negativa" class="form-control" disabled id="orgaonegativa">
                                    <option value="" selected>Selecione</option>
                                    <option value="10" >SERASA</option>
                                    <option value="11">QUOD</option>
                                </select>
                            </div>
                            </div> 
                            

                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Juros %</label>
                            <div class="col-sm-10">
                                <input type="text" name="juros_bol" id="juros_bol" class="form-control"  value="0.00"  placeholder="Percentual de juros">
                            </div>
                            </div> 
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Multa %</label>
                            <div class="col-sm-10">
                                <input type="text" name="multa_bol" id="multa_bol" class="form-control"  value="0.00" placeholder="Percentual de juros">
                            </div>
                            </div> 
                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Data de Vencimento Boleto</label>
                            <div class="col-sm-10">
                            <input type="date" name="vencimento_boleto" id="message" class="form-control" placeholder="Data Vencimento Boleto">
                            </div>
                            </div> 

                            <div class="form-group row">
                            <label  class="col-sm-2 col-form-label">Dias para Receber Após Vencimento</label>
                            <div class="col-sm-10">
                                <input type="text" name="dias_venc" id="diasvenc"  value="0" class="form-control" placeholder="Dias para receber após vencimento">
                            </div>
                            </div> 
                        
                        </div>
                        
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Documento</label>
                        <div class="col-sm-10">
                            <input type="file" id="file" name="documento" accept=".pdf, .jpeg, .png" style="width:100%">
                        </div>
                        </div>  
                        <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Observaões</label>
                        <div class="col-sm-10">
                            <input type="obs" name="obs" id="obs" value="<?=$_POST['obs']?>" class="form-control"  placeholder="Observações">
                        </div>
                        </div>                      
                        <div class="form-group row">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        $(function(){
            // $("#empresa").change(function(){alert($("#empresa").val())});
            // $("#fornecedor").change(function(){alert($("#fornecedor").val())});
            // $("#centro").change(function(){alert($("#centro").val())});

            $('#empresa').on('change',function(){
                var empresa = $(this).val();
                var options = '<option value="">Selecione</option>';
                if( $(this).val() ) {
                $('#cliente').hide();
                $('#carregando-cli').show();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':empresa,'action':67},
                    success: function(j){
                        console.log('Clientes',j)
                        let values = JSON.parse(j);
                        if(values != "null"){
                            values.forEach(function(el){
                                options += '<option value="' +
                                el.idcli + '">' +
                                el.cliente + '</option>';
                            })
                            //console.log(options)
                            $('#cliente').html(options).show();
                            $('#carregando-cli').hide();
                        }else{
                            $('#cliente').html(
                                '<option value="">-- Selecione uma empresa --</option>'
                            ).show();
                            $('#carregando-cli').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#cliente').html(
                            '<option value="">-- Selecione uma empresa --</option>'
                        ).show();
                        $('#carregando-cli').hide();
                    }
                })
                }
            })

            $('#empresa').on('change',function(){
                var empresa = $(this).val();
                var options = '<option value="">Selecione</option>';
                if( $(this).val() ) {
                $('#centro').hide();
                $('#carregando-cent').show();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':empresa,'action':68},
                    success: function(j){
                        console.log('Centros',j)
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
            
            $('#empresa').on('change',function(){
                var empresa = $(this).val();
                var options = '<option value="">Selecione</option>';
                if( $(this).val() ) {
                $('#recebimento').hide();
                $('#carregando-rec').show();
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':empresa,'action':66},
                    success: function(j){
                        console.log('recebimentos',j)
                        let values = JSON.parse(j);
                        if(values != "null"){
                            values.forEach(function(el){
                                options += '<option value="' +
                                el.idfrmrec + '">' +
                                el.recebimento + '</option>';
                            })
                            //console.log(options)
                            $('#recebimento').html(options).show();
                            $('#carregando-rec').hide();
                        }else{
                            $('#recebimento').html(
                                '<option value="">-- Selecione um centro de custo --</option>'
                            ).show();
                            $('#carregando-rec').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#recebimento').html(
                            '<option value="">-- Selecione um centro de custo --</option>'
                        ).show();
                        $('#carregando-rec').hide();
                    }
                })
                }
            })

            $("#recebimento").change(function(){
                var rec = $(this).val();
                //alert(rec);
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'idfrmrec':rec,'action':42},
                    success: function(j){
                        console.log('recebimentos',j)
                        let values = JSON.parse(j);
                        console.log(values.datas)
                        if(values.datas[0].recebimento == 'BOLETO'){
                            $('#control').show();
                        }else{
                            $('#control').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#control').hide();
                    }
                })
            });

            $("#protesta").change(function(){
                var value = $(this).val();
                if(value == 'NÃO'){
                    $("#dias_prot").val(0)
                    $("#dias_prot").prop('disabled',true)
                }else{
                    $("").val();
                    $("#dias_prot").prop('disabled',false)
                }
            })

            $("#negativa").change(function(){
                var value = $(this).val();
                if(value == 'NÃO'){
                    $("#diasnegativa").val(0)
                    $("#diasnegativa").prop('disabled',true)
                    $("#orgaonegativa").prop('disabled',true)
                }else{
                    $("#orgaonegativa").prop('disabled',false)
                    $("#diasnegativa").prop('disabled',false)
                }
            })
        });
     
		

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
            
            $('#empresa').change(function(){
                var codigo = $(this).val();
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