<!DOCTYPE html>
<?php 
date_default_timezone_set('America/Sao_Paulo');
session_start();
include("includes/funcoes.php");
include("includes/control.php");
include("includes/load.php");
// include("includes/boletosbb.php");
include("consulta_boleto.php");


$raiz = $_SERVER['DOCUMENT_ROOT'];
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <link href="css/smartpaginator.css" rel="stylesheet" type="text/css" />
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
        <!-- choose a theme file -->
<link rel="stylesheet" href="js/dist/css/theme.blue.css">

<script src="js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
   
<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<!-- load jQuery and tablesorter scripts -->
<!-- <script type="text/javascript" src="js/dist/js/jquery-latest.js"></script> -->
<script type="text/javascript" src="js/dist/js/jquery.tablesorter.js"></script>
<script src="js/smartpaginator.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<style>
            .hidden-span{
                display:none;
            }
        </style>
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
	
		
	</header><!--/header-->
<br />
        <?php
        
        $params = ['action' => '5', 'status' => 'ATIVA'];
        $res = json_decode(listaEmpresas($params));

            if($res->result === "sucess"){
                $emp = $res->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$res->error.')</script>';
            }
        if($_POST['cliente']){
            $paramss = ['action' => '14', 'empresa' => $_POST['empresa']];
            $ress = json_decode(listarClientes($paramss));

            if($ress->result === "sucess"){
                $cli = $ress->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$ress->error.')</script>';
            }
        }
        
        if($_POST['centro']){
            $parameters = ['action' => '20', 'empresa' => $_POST['empresa']];
            $resul = json_decode(listaCentrosRec($parameters));
            // print_r($resul);
            if($resul->result === "sucess"){
                $centros = $resul->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$resul->error.')</script>';
            }
        }
        
        
            $pmts = ['ativo' => 'Sim','action' => '42', 'empresa' => $_POST['empresa']];
            $rst = json_decode(listarFormaRecebimento($pmts));
            //print_r($rst);
            if($rst->result === "sucess"){
                $frmpag = $rst->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$rst->error.')</script>';
            }
        
        
        ?>
	<div class="container text-left">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Buscar Contas a Receber</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                            <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Empresa</label>
                                    <div class="col-sm-10">
                                    <select name="empresa" id="empresa" class="form-control">
                                    <option value="" selected>Selecione</option>
                                        <?php
                                        foreach($emp as $item){
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
                                <label class="col-sm-2 col-form-label">Documento</label>
                                <div class="col-sm-10">
                                <input type="text" name="documento" class="form-control">
                                </div>
                            </div>
                           
                            
                              
                            
                                <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data do Documento</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_doc_ini" id="message" value="<?=$_POST['dt_doc_ini']?>" class="form-control" placeholder="Data Vencimento">
                                    <b>para:</b><input type="date" name="dt_doc_fin" id="message" value="<?=$_POST['dt_doc_fin']?>" class="form-control" placeholder="Data Vencimento">
                                </div> 
                                </div>
                                <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data do Vencimento</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_vencimento_ini" value="<?=$_POST['dt_vencimento_ini']?>" id="message" class="form-control" placeholder="Data Vencimento">
                                    <b>Para:</b><input type="date" name="dt_vencimento_fin" value="<?=$_POST['dt_vencimento_fin']?>" id="message" class="form-control" placeholder="Data Vencimento">
                                </div> 
                                </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data de Recebimento</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_rec_ini" id="message" value="<?=$_POST['dt_rec_ini']?>" class="form-control" placeholder="Data Recebimento">
                                    <b>para:</b><input type="date" name="dt_rec_fin" id="message" value="<?=$_POST['dt_rec_fin']?>" class="form-control" placeholder="Data Recebimento">
                                </div> 
                            </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                    <select name="status"  class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="ABERTO">ABERTO</option>
                                        <option value="ATRASADO">ATRASADO</option>
                                        <option value="CANCELADO">CANCELADO</option>
                                        <option value="RECEBIDO">RECEBIDO</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Situação Boleto</label>
                                    <div class="col-sm-10">
                                    <select name="sit_bol"  class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="NORMAL/ABERTO">NORMAL/ABERTO</option>
                                        <option value="LIQUIDADO">LIQUIDADO</option>
                                        <option value="BAIXADO">BAIXADO(CANCELADO)</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Reter</label>
                                    <div class="col-sm-10">
                                    <select name="reter"  class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="SIM">SIM</option>
                                        <option value="NÃO">NÃO</option>
                                    </select>
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
                                        
                                <div class="form-group row">
                                    <input type="hidden" name="action" value="35" />
                                    <input type="hidden" name="usuario" value="<?=$_SESSION['name']?>" />
                                    <input type="submit" name="btn" class="btn btn-primary" value="Buscar">
                                </div>
                            
                    </form>
                </div>
            </div>
            
                                
	</div>
    <?php 
    
     if($_POST['btn']){
         
        
         $params = [
             'cliente' => $_POST['cliente'],
             'empresa' => $_POST['empresa'],
             'centro' => $_POST['centro'],
             'documento' => $_POST['documento'],
             'reter' => $_POST['reter'],
             'dt_doc_ini' => $_POST['dt_doc_ini'],
             'dt_doc_fin' => $_POST['dt_doc_fin'],
             'dt_vencimento_ini' => $_POST['dt_vencimento_ini'],
             'dt_vencimento_fin' => $_POST['dt_vencimento_fin'],
             'dt_rec_ini' => $_POST['dt_rec_ini'],
             'dt_rec_fin' => $_POST['dt_rec_fin'],
             'status' => $_POST['status'],
             'sit_bol' => $_POST['sit_bol'],
             'frm_rec' => $_POST['frm_rec'],
             'action'=>'46'
         ];

         //print_r($_POST);

        // $result = loadApi($params);
        $result = json_decode(listaContaReceber($params));
        //print_r($result);
         if($result->result === "sucess"){
             $list = $result->datas;
             
         }

         
     }
if($list){ 
    $_SESSION['list'] = $list;
    ?>
    <div class="container">
		<div class="row">
            <h2 class="title text-center">Resultado da Busca</h2>
            <a href="gerar_pdf_cntrec.php" target="_blank" id="pdf" class="btn btn-primary">Baixar PDF dos resultados</a>
            <?php if($_SESSION['nivel'] > 1){ ?>
            <form action="includes/boleto_bb.php" targrt="blank" method="post" id="form2" target="blank">
            <!-- <button type="button" id="pagallbtn" class="btn btn-success">Gerar Boletos Com Selecionadas</button> -->
            <?php } ?>
            <br/>
            <br/>
            <div id="paginator">
                <table class="table cell-border" id="mytable">
                    <thead>
                        <tr style="color: #000; background-color: #ccc; text-align:center;">
                       
                            <th>Item</th>
                            <th>Ação</th>
                            <th>Empresa</th>
                            <th>Cliente</th>
                            <th>Centro de Custo</th>
                            <th>Nr. Documento</th>
                            <th>Dt. Documento</th>
                            <th>Valor</th>
                            <th>Parcela</th>
                            <th>Vr. Retroativo</th>
                            <th>Vr. Extra</th>
                            <th>Vr. Fatura</th>
                            <th>Vr. Pis</th>
                            <th>Vr. COFINS</th>
                            <th>Vr. IRRF</th>
                            <th>Vr. CSLL</th>
                            <th>Vr. INSS</th>
                            <th>Vr. ISS</th>
                            <th>Reter ISS</th>
                            <th>Vr. Documento</th>
                            <th>Dt. Vencimento</th>
                            <th>Descrição</th>
                            <th>Observação</th>
                            <th>Status</th>
                            <th>Sit. Boleto</th>
                            <th>Dt. Recebimento</th>
                            <th>Desconto</th>
                            <th>Mul/Jur/Enc</th>
                            <th>Vr. Recebido</th>
                            <th>Forma Recebimento</th>
                            <th>Obs. Recebimento</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $i = 0;
                            foreach($list as $item){
                                
                                $somaval += $item->val_doc;
                                $somamulta += $item->multa;
                                $somadesc += $item->vr_desc;
                                $somavalpag += $item->vr_pag;
                                $somavalserv += $item->val_servico;
                                $somavalret += $item->val_ret;
                                $somafat += $item->val_fat;
                                $somavalext += $item->val_extra;
                                $somapis += $item->pis;
                                $somacofins += $item->cofins;
                                $somairrf += $item->irrf;
                                $somacsll += $item->csll;
                                $somainss += $item->inss;
                                $somaiss += $item->iss;
                                $array = Array();
                                $array[$item->id_conta] = $item;
                                ?>
                       
                        <?php if($item->status == 'CANCELADA'){?>
                                <tr style="background-color: #CE3C2D; color:white;">
                        <?php } ?>
                        <!-- <?php if($item->status == 'ATRASADO'){?>
                                <tr style="background-color: #ed7b55; color:white;">
                        <?php } ?> -->
                        <?php if($item->status == 'RECEBIDO'){?>
                                <tr style="background-color: #7ebf97; color: #000;">
                        <?php } ?>
                        <?php if($item->status == 'ABERTO' || $item->status == 'ATRASADO'){?>
                                <tr>
                        <?php } ?>
                                <td><?=$item->id_conta?></td>
                                <td nowrap class="icones">
                                <?php
                                if($item->status == 'RECEBIDO'){
                                ?>
                                    <a href="documentos/comprovantes/conta_receber/<?=$item->comprovante?>" download class="quitar" title="Visualizar Comprovante"><i class="fa fa-file-text" aria-hidden="true"></i></a> 
                                <?php }else{ ?>
                                    <a href="#" data-toggle="modal" data-target="#pag<?=$item->id_conta?>" class="quitar" title="Quitar"><i class="fa fa-money" aria-hidden="true"></i></a>
                                    
                                    <?php 
                                    if($item->convenio){
                                        if($item->boleto_arq){ ?>
                                        <a href="#" data-toggle="modal" data-target="#embedDoc<?=$item->id_conta?>" title="Visualizar Arquivo"><i class="fa fa-barcode" aria-hidden="true"></i></a>
                                        <!-- <a href="#" onclick="<?php echo 'listBoleto'.$item->id_conta ?>(<?=$item->id_conta?>)" class="quitar" title="Listar Info Boletos"><i class="fa fa-align-left" aria-hidden="true"></i></a> -->
                                    <?php }else{ 
                                        ?> 
                                            <a href="#" onclick="<?php echo 'goBoleto'.$item->id_conta ?>(<?=$item->id_conta?>)" class="quitar" title="Gerar Boleto"><i class="fa fa-barcode" aria-hidden="true"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <!-- <a href="#" onclick="<?php echo 'listBoleto'.$item->id_conta ?>(<?=$item->id_conta?>)" class="quitar" title="Listar Info Boletos"><i class="fa fa-align-left" aria-hidden="true"></i></a> -->
                                        <?php
                                    } 
                                   
                            }?>
                                <a href="#" data-toggle="modal" data-target="#detalhes<?=$item->id_conta?>" title="Detalhes da Conta"><i class="fa fa-search" aria-hidden="true"></i></a>  
                                    <a href="documentos/boleto/<?=$item->boleto_arq?>" download title="Visualizar Arquivo"><i class="fa fa-files-o" aria-hidden="true"></i></a>  
                                    <a href="edt_cntrec.php?idconta=<?=$item->id_conta?>" target="blank" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
                                    <a href="#" data-toggle="modal" data-target="#del<?=$item->id_conta?>" title="Excluir"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                
                                    
                                    
                                </td>
                                    <td><?=$item->empresa?></td>
                                    <td><?=$item->cliente?></td>
                                    <td><?=$item->centro?></td>
                                    <td><?=$item->num_doc?></td>
                                    <td><?=recebedata($item->dt_doc)?></td>
                                    <td><?=number_format($item->val_servico,2,',','.')?></td>
                                    <td><?=$item->parcela?></td>
                                    <td><?=number_format($item->val_ret,2,',','.')?></td>
                                    <td><?=number_format($item->val_extra,2,',','.')?></td>
                                    <td><?=number_format($item->val_fat,2,',','.')?></td>
                                    <td><?=number_format($item->pis,2,',','.')?></td>
                                    <td><?=number_format($item->cofins,2,',','.')?></td>
                                    <td><?=number_format($item->irrf,2,',','.')?></td>
                                    <td><?=number_format($item->csll,2,',','.')?></td>
                                    <td><?=number_format($item->inss,2,',','.')?></td>
                                    <td><?=number_format($item->iss,2,',','.')?></td>
                                    <td><?=$item->reter?></td>
                                    <td><?=number_format($item->val_doc,2,',','.')?></td>
                                    <td><span class="hidden-span"><?=$item->dt_vencimento?></span><?=recebedata($item->dt_vencimento)?></td>
                                    <td><?=$item->descricao?></td>
                                    <td><?=$item->obs?></td>
                                    <td><?=$item->status?></td>
                                    <td><?=$item->sit_bol?></td>
                                    <td><?=recebedata($item->dt_pag)?></td>
                                    <td><?=number_format($item->desconto,2,',','.')?></td>
                                    <td><?=number_format($item->multa,2,',','.')?></td>
                                    <td><?=number_format($item->vr_pag,2,',','.')?></td>
                                    <td><?=$item->frm_rec?></td>
                                    <td><?=$item->obs_pag?></td>

                                    <!-- Modal -->
                            <td> 
                                <?php if($item->status == "ABERTO") { 
                                    if($item->convenio){ ?>
                                    
                                    <?php 
                                                    $dados = Array();
                                                    $res = Array();
                                                    $temp = 0;
                                                    $par = ['action' => '46','documento' => $item->num_doc];
                                                    // $data = json_decode(listaContaReceber($par));
                                                    // $temp = $data->datas;
                                                    $dados[$i] = $item;
                                                    //print_r($item);
                                                    

                                                        $para = [
                                                                    
                                                                    'id_conta' => $item->id_conta,
                                                                    'documento' => $item->num_doc,
                                                                    'tipo_cliente' => $item->tipo_cliente,
                                                                    'agencia' => $item->agencia,
                                                                    'conta' => $item->conta,
                                                                    'cliente' => $item->cliente,
                                                                    'datavenc' => recebedata($item->dt_vencimento),
                                                                    'cidade' => $item->cidade,
                                                                    'bairro' => $item->bairro,
                                                                    'endereco' => $item->endereco,
                                                                    'cep' => $item->cep,
                                                                    'uf' => $item->uf,
                                                                    'boleto_arq' => $item->boleto_arq,
                                                                    'cnpj_cli' => $item->cpf_cnpj,
                                                                    'uf' => $item->uf,
                                                                    'inscricao' => $item->cnpj_emp,
                                                                    'fone' => $item->fone,
                                                                    'convenio' => $item->convenio,
                                                                    'valor' => $item->val_doc,
                                                                    'empresa' => $item->empresa,
                                                                    'descricao' => $item->descricao,
                                                                    'fk_empresa' => $item->fk_emp,
                                                                    'emp_razao_social' => $item->emp_razao_social,
                                                                    'protesta' => $item->protesta,
                                                                    'negativa' => $item->negativa,
                                                                    'juros_bol' => $item->juros_bol,
                                                                    'multa_bol' => $item->multa_bol,
                                                                    'dias_venc' => $item->dias_venc,
                                                                    'dias_protesto' => $item->dias_protesto,
                                                                    'dias_negativa' => $item->dias_negativa,
                                                                    'vencimento_boleto' => $item->vencimento_boleto,
                                                                    'orgao_negativa' => $item->orgao_negativa,
                                                                    'situacao' => 'A,B'
                                                                ];
                                                        // $results = geraBoleto($para);
                                                        // $res[$i] = $results;
                                                        // echo $erro = $res[$i]->error;
                                                        // print_r($res[$i]);
                                                        
                                                        //$("#form2").attr("action", "atualiza_todos.php").submit();
                                                        //print_r($array);
                                                        //echo $res[$i]->codigoBarraNumerico;
                                                    ?>
                                                    
                                                    <script>
                                                        function <?php echo 'goBoleto'.$item->id_conta ?>(id){
                                                            $('#form2').append('<input type="hidden" name="dadosc" value="<?php echo htmlentities(serialize($para)); ?>" id="dadosc" />');
                                                            $("#form2").attr("action", "registra.php").submit();
                                                        }

                                                        function <?php echo 'listBoleto'.$item->id_conta ?>(id){
                                                            $('#form2').append('<input type="hidden" name="dadosc" value="<?php echo htmlentities(serialize($para)); ?>" id="dadosc" />');
                                                            $("#form2").attr("action", "lista_boletos.php").submit();
                                                        }

                                                        
                                                    </script>
                                    
                                    
                                    <div class="modal fade" id="embedDoc<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" style="color: #000" id="ModalLabel">Detalhes do Boleto</h4>
                                                </div>
                                                <div class="modal-body"  style="color: #000">
                                                <?php
                                                if($item->num_bol){
                                                $parameters = ['nosso_num' => $item->num_bol, 'convenio' => $item->convenio];
                                                //print_r($parameters);
                                                $res_bol = json_decode(consultaBol($parameters));
                                                //print_r($res_bol);
                                                if($res_bol->codigoEstadoTituloCobranca){
                                                ?>
                                                    <table class="table">
                                                      
                                                        <tr><td>Nosso Numero</td><td><?=$item->num_bol?></td></tr>
                                                        <tr><td>Convenio</td><td><?=$item->convenio?></td></tr>
                                                        <tr><td>Codigo de Barras</td><td><?=$res_bol->codigoLinhaDigitavel?></td></tr>
                                                        <tr><td>Data Emissão</td><td><?=str_replace('.','/',$res_bol->dataEmissaoTituloCobranca)?></td></tr>
                                                        <tr><td>Data Vencimento</td><td><?=str_replace('.','/',$res_bol->dataVencimentoTituloCobranca)?></td></tr>
                                                        <tr><td>Vr. Boleto</td><td><?=number_format($res_bol->valorAtualTituloCobranca,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Pago</td><td><?=number_format($res_bol->valorPagoSacado,2,',','.')?></td></tr>
                                                        <tr>
                                                            <td>Situação</td><td>
                                                                <?php 
                                                                if($res_bol->codigoEstadoTituloCobranca == 1){
                                                                    echo 'NORMAL/ABERTO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 2){
                                                                    echo 'MOVIMENTO CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 3){
                                                                    echo 'EM CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 4){
                                                                    echo 'TITULO COM OCORRENCIA DE CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 5){
                                                                    echo 'PROTESTADO ELETRONICO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 6){
                                                                    echo 'LIQUIDADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 7){
                                                                    echo 'BAIXADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 8){
                                                                    echo 'TITULO COM PENDENCIA DE CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 9){
                                                                    echo 'TITULO PROTESTADO MANUAL';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 10){
                                                                    echo 'TITULO BAIXADO/PAGO EM CARTORIO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 11){
                                                                    echo 'TITULO LIQUIDADO/PROTESTADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 12){
                                                                    echo 'TITULO LIQUID/PGCRTO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 13){
                                                                    echo 'TITULO PROTESTADO AGUARDANDO BAIXA';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 14){
                                                                    echo 'TITULO EM LIQUIDACAO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 15){
                                                                    echo 'TITULO AGENDADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 16){
                                                                    echo 'TITULO CREDITADO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 17){
                                                                    echo 'PAGO EM CHEQUE';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 18){
                                                                    echo 'AGUARD.LIQUIDACAO';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 19){
                                                                    echo 'PAGO PARCIALMENTE';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 20){
                                                                    echo 'TITULO AGENDADO COMPE 80';
                                                                }
                                                                if($res_bol->codigoEstadoTituloCobranca == 21){
                                                                    echo 'EM PROCESSAMENTO (ESTADO TRANSITÓRIO)';
                                                                }


                                                                ?>
                                                                
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr><td>Download Boleto</td><td><a href="documentos/boletos/<?=$item->boleto_arq?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                       
                                                    
                                                    </table>
                                                   
                                                    
                                                    <script>
                                                        function <?php echo 'baixaBoleto'.$item->id_conta ?>(id){
                                                            var obs_baixa = $('#obs_baixa<?=$item->id_conta?>').val();
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "baixa_boleto.php",
                                                                data: {'convenio':<?=$item->convenio?>,'num_bol':<?=$item->num_bol?>,'obs_baixa':obs_baixa,'id_conta':<?=$item->id_conta?>},
                                                                success: function(result){
                                                                    console.log('result',result);
                                                                    let values = JSON.parse(result)
                                                                    console.log('values',values);
                                                                    if(values['Res'].numeroContratoCobranca != null){
                                                                        alert('Boleto baixado/cancelado!'+ values);
                                                                    }else{
                                                                        alert('Erro ao baixar/cancelar boleto!'+ values);
                                                                    }
                                                                    // document.location.reload(true);
                                                                },
                                                                error: function(err){console.log(err)}
                                                            })
                                                        }
                                                        
                                                    </script>
                                                    <?php } 
                                                        }
                                                    
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['name']?>" />
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                   
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                            <?php } 
                            
                            if($item->status != 'RECEBIDO'){
                            ?>
                                    <div class="modal fade" id="pag<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" style="color: #000" id="ModalLabel">Quitar Conta</h4>
                                                </div>
                                                <div class="modal-body"  style="color: #000">
                                                    <table class="table">
                                                      
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Cliente</td><td><?=$item->cliente?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr. Documento</td><td><?=$item->num_doc?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Valor</td><td><?=number_format($item->val_servicoc,2,',','.')?></td></tr>
                                                        <tr><td>Parcela</td><td><?=$item->parcela?></td></tr>
                                                        <tr><td>Vr. Retroativo</td><td><?=number_format($item->val_ret,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Fatura</td><td><?=number_format($item->val_fat,2,',','.')?></td></tr>
                                                        <tr><td>Vr. IRRF</td><td><?=number_format($item->irrf,2,',','.')?></td></tr>
                                                        <tr><td>Vr. PIS</td><td><?=number_format($item->pis,2,',','.')?></td></tr>
                                                        <tr><td>Vr. COFINS</td><td><?=number_format($item->cofins,2,',','.')?></td></tr>
                                                        <tr><td>Vr. CSLL</td><td><?=number_format($item->csll,2,',','.')?></td></tr>
                                                        <tr><td>Vr. INSS</td><td><?=number_format($item->inss,2,',','.')?></td></tr>
                                                        <tr><td>Vr. ISS</td><td><?=number_format($item->iss,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/conta_receber/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Status</td><td><?=$item->status?></td></tr>
                                                        <tr><td>Forma Pagamento</td>
                                                            <td>
                                                                <select name="frm_pag" id="frm_pag<?=$item->id_conta?>" class="form-control">
                                                                    <option value="" selected>Selecione</option>
                                                                    <?php
                                                                        foreach($frmpag as $itemp){
                                                                        ?>
                                                                        <option value="<?=$itemp->idfrmrec?>"><?=$itemp->codigo?> - <?=$itemp->recebimento?></option>
                                                                        <?php 
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <?php $hoje = date('Y-m-d');?>
                                                        <tr><td>Data Pagamento*</td><td><input type="date" name="dt_pag" id="dt_pag<?=$item->id_conta?>" class="form-control" required value="<?=$hoje?>"></td></tr>
                                                        <tr><td>Desconto</td><td><input type="text" onkeyup="formatarMoeda('valordesc',<?=$item->id_conta?>)" name="desconto" id="valordesc<?=$item->id_conta?>" value="0,00"></td></tr>
                                                        <tr><td>Multa/Juros/Encargos</td><td><input type="text" onkeyup="formatarMoeda('multa',<?=$item->id_conta?>)" name="multa" required id="valormul<?=$item->id_conta?>" value="0,00"></td></tr>
                                                        <tr><td>Valor Pago*</td><td><input type="text" onkeyup="formatarMoeda('valorpag',<?=$item->id_conta?>)" name="vr_pago" required id="valorpag<?=$item->id_conta?>" value="0,00"></td></tr>
                                                        <tr><td>Comprovante de Pagamento</td><td><input type="file" id="file<?=$item->id_conta?>" name="comprovante" accept=".pdf, .jpeg, .png" style="widith:100%"></tr>
                                                        <tr><td>Observações de Recebimento</td><td><input type="text" value="" name="obs" style="width:100%;"  id="obs<?=$item->id_conta?>"></td></tr>
                                                        <!--<tr><td>Site</td><td><?=$item->site?></td></tr> -->
                                                        
                                                    <?php  ?>
                                                    </table>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['name']?>" />
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="desautorizar" class="btn btn-primary" onclick="quita(<?=$item->id_conta?>)" id="pagbtn<?=$item->id_conta?>">Quitar</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="modal fade" id="detalhes<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" style="color: #000" id="ModalLabel">Detalhes da Conta</h4>
                                                </div>
                                                <div class="modal-body"  style="color: #000">
                                                    <table class="table">
                                                      
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Cliente</td><td><?=$item->cliente?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr. Documento</td><td><?=$item->num_doc?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Valor</td><td><?=number_format($item->val_servicoc,2,',','.')?></td></tr>
                                                        <tr><td>Parcela</td><td><?=$item->parcela?></td></tr>
                                                        <tr><td>Vr. Retroativo</td><td><?=number_format($item->val_ret,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Fatura</td><td><?=number_format($item->val_fat,2,',','.')?></td></tr>
                                                        <tr><td>Vr. IRRF</td><td><?=number_format($item->irrf,2,',','.')?></td></tr>
                                                        <tr><td>Vr. PIS</td><td><?=number_format($item->pis,2,',','.')?></td></tr>
                                                        <tr><td>Vr. COFINS</td><td><?=number_format($item->cofins,2,',','.')?></td></tr>
                                                        <tr><td>Vr. CSLL</td><td><?=number_format($item->csll,2,',','.')?></td></tr>
                                                        <tr><td>Vr. INSS</td><td><?=number_format($item->inss,2,',','.')?></td></tr>
                                                        <tr><td>Vr. ISS</td><td><?=number_format($item->iss,2,',','.')?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/conta_receber/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Agencia</td><td><?=$item->agencia?></td></tr>
                                                        <tr><td>Conta</td><td><?=$item->conta?></td></tr>
                                                        <tr><td>Status</td><td><?=$item->status?></td></tr>
                                                        <tr><td>Forma de Recebimento</td><td><?=$item->frm_rec?></td></tr>
                                                        <tr><td>Protesta Boleto</td><td><?=$item->protesta?></td></tr>
                                                        <tr><td>Dias Para Protestar</td><td><?=$item->dias_protesto?></td></tr>
                                                        <tr><td>Negativa Boleto</td><td><?=$item->negativa?></td></tr>
                                                        <tr><td>Dias Para Negativar</td><td><?=$item->dias_negativa?></td></tr>
                                                        <tr><td>Orgão Negativador</td>
                                                        <td>
                                                            <?php 
                                                            if($item->orgao_negativa == 10){
                                                                echo 'SERASA';
                                                            } 
                                                            if($item->orgao_negativa == 10){
                                                                echo 'QUOD';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                        <tr><td>Vencimento Boleto</td><td><?=recebedata($item->venc_boleto)?></td></tr>
                                                        <tr><td>Convenio</td>
                                                            <td>
                                                                <?php 
                                                                if($item->convenio == '2184070'){
                                                                    echo 'NECAVA';
                                                                }
                                                                if($item->convenio == '2786559'){
                                                                    echo 'PARKFOR';
                                                                }
                                                                if($item->convenio == '3309918'){
                                                                    echo 'TSST';
                                                                }
                                                                if($item->convenio == '3348211'){
                                                                    echo 'V&T';
                                                                }
                                                                if($item->convenio == '3468148'){
                                                                    echo 'MARAPONGA FOOD';
                                                                }
                                                                if($item->convenio == '3035927'){
                                                                    echo 'CIPETRAN PP';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr><td>Login Inserção</td><td><?=$item->login_insercao?></td></tr>
                                                        <tr><td>Data Inserção</td><td><?=recebedata($item->dt_entrada).' '.$item->hr_insercao?></td></tr>
                                                        <?php if($item->login_baixa){ ?>
                                                            <tr><td>Login Baixa</td><td><?=$item->login_baixa?></td></tr>
                                                            <tr><td>Data Baixa</td><td><?=recebedata($item->dt_pag).' '.$item->hr_baixa?></td></tr>
                                                        <?php } ?>
                                                        
                                                    <?php  ?>
                                                    </table>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['name']?>" />
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                   
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="del<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="ModalLabel">Excluir Conta</h4>
                                                </div>
                                                <div class="modal-body" style="color: #000">
                                                    <table class="table">
                                                
                                                        
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Cliente</td><td><?=$item->cliente?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr. Documento</td><td><?=$item->num_doc?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        
                                                        
                                                    <?php  ?>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                <input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['name']?>" />
                                                <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="deletar" class="btn btn-primary" onclick="excluir(<?=$item->id_conta?>)" id="delbtn<?=$item->id_conta?>">Excluir</button>
                                                </div>
                                                <script>

                                                function excluir(id){
                                                    cod = id;
                                                    usu = $('#usuario').val();
                                                    //alert(obs);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "includes/api.php",
                                                        data: {'codigos':cod,'usuario':usu,'action':49},
                                                        success: function(result){
                                                                                                        
                                                            alert(result);
                                                            var dados = jQuery(this).serialize();
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "includes/api.php",
                                                                data: dados,
                                                                success: function(msg){
                                                                    //alert(msg);
                                                                                                                                
                                                                    document.location.reload(true);
                                                                }	
                                                            });
                                                            return false;
                                                                                                        
                                                                                                            
                                                        }	
                                                    });
                                                }
                                            </script>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                    
                                </tr>
                            
                            <?php 
                            $i++;
                        } ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color:#5488cc; color:#fff;"><td colspan="7"><b>Total</b></td><td><b><?=number_format($somavalserv,2,',','.')?></b></td><td></td><td><b><?=number_format($somavalret,2,',','.')?></b></td><td><b><?=number_format($somavalext,2,',','.')?></b></td><td><b><?=number_format($somafat,2,',','.')?></b></td><td><b><?=number_format($somapis,2,',','.')?></b></td><td><b><?=number_format($somacofins,2,',','.')?></b></td><td><b><?=number_format($somairrf,2,',','.')?></b></td><td><b><?=number_format($somacsll,2,',','.')?></b></td><td><b><?=number_format($somainss,2,',','.')?></b></td><td><b><?=number_format($somaiss,2,',','.')?></b></td><td></td><td><b><?=number_format($somaval,2,',','.')?></b></td><td></td><td></td><td></td><td></td><td></td><td><b><?=number_format($somadesc,2,',','.')?></b></td><td><b><?=number_format($somamulta,2,',','.')?></b></td><td><b><?=number_format($somavalpag,2,',','.')?></b></td><td></td><td></td><td></td></tr>
                            </tfoot>

                </table>
            </div>
            <!-- <button type="button" class="btn btn-primary" id="authallbtn" data-toggle="modal" data-target="#authall">Autorizar Selecionados</button>
            <button type="button" id="pagallbtn" class="btn btn-success">Quitar Selecionados</button>
            <button type="button"id="unauthallbtn" class="btn btn-danger">Desautorizar Selecionados</button> -->
            </form>
            

            
            <br/>
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
    <!-- <script src="js/jquery.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> -->
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> -->
    <!-- load jQuery and tablesorter scripts -->
    <!-- <script type="text/javascript" src="js/dist/js/jquery-latest.js"></script> -->
    <!-- <script type="text/javascript" src="js/dist/js/jquery.tablesorter.js"></script> -->
    <!-- <script src="js/smartpaginator.js" type="text/javascript"></script> -->
    
    <!-- <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script> -->
    


<!-- tablesorter widgets (optional) -->
<!-- <script type="text/javascript" src="js/dist/js/jquery.tablesorter.widgets.js"></script> -->
<script>
                                                        function formatarMoeda(ele,id) {
                                                        var elemento1 = document.getElementById(ele+id);
                                                        // var elemento2 = document.getElementById('valormul'+id);
                                                        // var elemento3 = document.getElementById('valorpag'+id);
                                                        var valor1 = elemento1.value;
                                                        // var valor2 = elemento2.value;
                                                        // var valor3 = elemento3.value;
                                                        
                                                        
                                                        valor1 = valor1 + '';
                                                        valor1 = parseInt(valor1.replace(/[\D]+/g, ''));
                                                        valor1 = valor1 + '';
                                                        valor1 = valor1.replace(/([0-9]{2})$/g, ",$1");
                                                    
                                                        
                                                        // if(valor2 != '0.00'){
                                                        //     valor2 = valor2 + '';
                                                        //     valor2 = parseInt(valor2.replace(/[\D]+/g, ''));
                                                        //     valor2 = valor2 + '';
                                                        //     valor2 = valor2.replace(/([0-9]{2})$/g, ",$1");
                                                        // }
                                                        // if(valor3 != '0.00'){
                                                        //     valor3 = valor3 + '';
                                                        //     valor3 = parseInt(valor3.replace(/[\D]+/g, ''));
                                                        //     valor3 = valor3 + '';
                                                        //     valor3 = valor3.replace(/([0-9]{2})$/g, ",$1");
                                                        // }

                                                        if (valor1.length > 6) {
                                                            valor1 = valor1.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
                                                        }

                                                        // if (valor2.length > 6) {
                                                        //     valor2 = valor2.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
                                                        // }

                                                        // if (valor3.length > 6) {
                                                        //     valor3 = valor3.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
                                                        // }

                                                        elemento1.value = valor1;
                                                        if(valor1 == 'NaN') elemento1.value = '0,00';

                                                        // elemento2.value = valor2;
                                                        // if(valor2 == 'NaN') elemento2.value = '0,00';

                                                        // elemento3.value = valor3;
                                                        // if(valor3 == 'NaN') elemento3.value = '0,00';
                                                        
                                                    }
                                                    // function geraBoleto(id){
                                                    //     //console.log('ID',id);
                                                    //     cliente = document.getElementById('emp'+id);
                                                    //     //console.log('Clente',cliente);
                                                    //     num_doc = document.getElementById('num_doc'+id);
                                                    //     endereco = document.getElementById('endereco'+id);
                                                    //     bairro = document.getElementById('bairro'+id);
                                                    //     cidade = document.getElementById('cidade'+id);
                                                    //     uf = document.getElementById('uf'+id);
                                                    //     cep = document.getElementById('cep'+id);
                                                    //     total = document.getElementById('total'+id);
                                                    //     datavenc = document.getElementById('dt_doc'+id);
                                                    //     inscricao = document.getElementById('insc'+id);
                                                    //     // usu = document.getElementById('usuario');
                                                    //     console.log('cliente',cliente.value);
                                                    //     console.log('Documento',num_doc.value);
                                                    //     console.log('data',datavenc.value);
                                                    //     console.log('endereco',endereco.value);
                                                    //     console.log('cidade',cidade.value);
                                                    //     console.log('bairro',bairro.value);
                                                    //     console.log('uf',uf.value);
                                                    //     console.log('cep',cep.value);
                                                    //     console.log('total',total.value);
                                                    //     console.log('inscricao',inscricao.value);

                                                        
                                                        
                                                        
                                                    //     $.ajax({
                                                    //         type: "POST",
                                                    //         url: "includes/boleto_bb.php",
                                                    //         data: {'cliente':cliente.value,'num_doc':num_doc.value, 'endereco': endereco.value,'bairro':bairro.value, 'cidade':cidade.value, 'total':total.value,'datavenc':datavenc.value,'uf':uf.value,'cep':cep.value},
                                                    //         success: function(result){                                        
                                                    //             console.log(result);                                                      
                                                    //         }	
                                                    //     });
                                                        
                                                    // }

                                                    function quita(id){
                                                        frmpag = document.getElementById('frm_pag'+id);
                                                        obs = document.getElementById('obs'+id);
                                                        cod = document.getElementById('idconta'+id);
                                                        desc = document.getElementById('valordesc'+id);
                                                        mul = document.getElementById('valormul'+id);
                                                        vrpag = document.getElementById('valorpag'+id);
                                                        dt_pag = document.getElementById('dt_pag'+id);
                                                        usu = document.getElementById('usuario');
                                                        console.log('frmpag',frmpag.value);
                                                        //alert(vrpag);
                                                        var file_data = document.getElementById('file'+id).value;  
                                                        var nomearquivo = file_data.replace(/C:\\fakepath\\/i, '');
                                                        console.log('nomearquivo',nomearquivo);
                                                        if(!file_data){
                                                            alert("É necessário informar o comprovante!");
                                                            return false
                                                        }
                                                        if(vrpag.value == '0,00' || vrpag.value == 0){
                                                            alert("É necessário informar o valor pago!");
                                                            return false
                                                        }
                                                        if(frmpag.value == ''){
                                                            alert("É necessário informar a forma de recebimento!");
                                                            return false
                                                        }
                                                        if(vrpag.value != '0,00' && vrpag.value != 0 && frmpag.value){
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "includes/api.php",
                                                                data: {'codigos':cod.value,'obs':obs.value, 'frmpag': frmpag.value,'usuario':usu.value, 'desc':desc.value,'mul':mul.value,'vrpag':vrpag.value,'dt_pag':dt_pag.value, 'comprovante':nomearquivo,'action':47},
                                                                success: function(result){
                                                                                                       
                                                                    console.log('id',id)
                                                                    var form_data = new FormData();                  
                                                                    form_data.append('file', document.getElementById('file'+id).files[0]);
                                                                    //alert(form_data);
                                                                    console.log('formdata',form_data)

                                                                    $.ajax({
                                                                        url: 'upload_comp_rec.php', // server-side PHP script 
                                                                        dataType: 'text',  // o que esperar do script PHP
                                                                        cache: false,
                                                                        contentType: false,
                                                                        processData: false,
                                                                        data: form_data,                         
                                                                        type: 'post',
                                                                        success: function(php_script_response){
                                                                            // Mostra a resposta do script PHP 
                                                                            console.log(php_script_response); 
                                                                            document.location.reload(true);
                                                                        }
                                                                    });
                                                                    return false;
                                                                                                                    
                                                                                                                        
                                                                }	
                                                            });
                                                        }else{
                                                            alert('Valores obrigatórios não informados!');
                                                        }
                                                    }
                                                    </script>
<script type="text/javascript">
 
	
        function checar() { 
            
        $.ajax({
        method: "POST",
        dataType: 'html',
        url: "includes/checa.php",
        data: {'tabela':'conta_receber'},
        success: function(resultado){ 
            //alert(resultado);
            console.log(resultado)
            if(resultado == 'Sucesso'){
                $.ajax({
                    method: "POST",
                    dataType: 'html',
                    url: "includes/att.php",
                    data: 'data',
                    success: function(resultado){
                        console.log('res2',resultado)
                        document.location.reload(true);
                    }
                })
                 
            }
        },
        error: function(request,status,error){
            alert(request.responseText);
        }

        })
    }

    //window.setInterval("checar()", 1000)
    
    

</script>

<scrip>
    
</script>

<script>
                                    //alert('entrou');
                                    $(function(){
                                        
                                        var Codigos = new Array();
                                        $("#authallbtn").on('click',function(){
                                            
                                            //alert('entrou');
                                           var lista =  $('input[name="check"]:checked').toArray().map(function(check){
                                                return $(check).val();
                                            })
                                            //alert(lista);
                                            if(lista != ''){
                                                $('#form2').append('<input name="codigos" type="hidden" value="'+lista+'">');
                                                $('#form2').append('<input name="opcao" type="hidden" value="Autoriza">');
                                                $("#form2").attr("action", "atualiza_todos.php").submit();
                                            }else{
                                                alert('É preciso selecionar contas a serem autorizadas!');
                                            }
                                            
                                        })

                                        $("#unauthallbtn").on('click',function(){
                                            
                                            //alert('entrou');
                                           var lista =  $('input[name="check"]:checked').toArray().map(function(check){
                                                return $(check).val();
                                            })
                                            //alert(lista);
                                            if(lista != ''){
                                                $('#form2').append('<input name="codigos" type="hidden" value="'+lista+'">');
                                                $('#form2').append('<input name="opcao" type="hidden" value="Desautoriza">');
                                                $("#form2").attr("action", "atualiza_todos.php").submit();
                                            }else{
                                                alert('É preciso selecionar contas a serem desautorizadas!');
                                            }
                                            
                                        })

                                        $("#pagallbtn").on('click',function(){
                                            
                                            //alert('entrou');
                                           var lista =  $('input[name="check"]:checked').toArray().map(function(check){
                                                return $(check).val();
                                            })
                                            //alert(lista);
                                            if(lista != ''){
                                                $('#form2').append('<input name="codigos" type="hidden" value="'+lista+'">');
                                                $('#form2').append('<input name="opcao" type="hidden" value="Quita">');
                                                $("#form2").attr("action", "atualiza_todos.php").submit();
                                            }else{
                                                alert('É preciso selecionar contas a serem autorizadas!');
                                            }
                                            
                                        })

                                        $("#edtbtn").on('click',function(){
                                            $idconta = $('#idconta').val();
                                            //alert('entrou');
                                            $('#form2').append('<input name="idconta" type="hidden" value="'+idconta+'">');
                                            $("#form2").attr("action", "edt_cntpag.php").submit();
                                            
                                            
                                        })
                                    

                                    // $.ajax({
                                    //     type: "POST",
                                    //     url: "includes/api.php",
                                    //     data: {'empresas':Codigos,'action':32},
                                    //     success: function(msg){
                                    //         //alert(msg);
                                    //     }	
                                    // });
                                    })
                                    
                                </script>
<script>
    $(function() {
        // alert('Entra aqui mas não funciona a ordenação');
        $("#mytable").DataTable({
            "language": {
                "url": "includes/br.json"
            },
            "pagingType": "full_numbers",
            "order": [[ 20, "asc" ]],
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100,"Tudo"]]
        });
       
       
     });
  </script>
    
 <script>
        $(function(){
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
                            );
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
                        );
                        $('#carregando-rec').hide();
                    }
                })
                }
            })

            //$("#ordena").tablesorter({ sortList: [[0,0], [1,0]] });
            
        });

        
        

       
		$("#telefone, #fax").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");

        
	
    </script>
  
    
</body>
</html>