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
        <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <link href="css/smartpaginator.css" rel="stylesheet" type="text/css" />
        
        
        <style>
            .hidden-span{
                display:none;
            }
        </style>
        
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
<!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
<script type="text/javascript" src="js/jquery.zohoviewer.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

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

            
        if($_POST['empresa']){

            $paramss = ['action' => '11', 'empresa' => $_POST['empresa']];
            $ress = json_decode(listaFornecedor($paramss));
            //print_r($ress);
            if($ress->result === "sucess"){
                $forn = $ress->datas;
                //print_r($emp);
            }else{
                echo '<script>alert("'.$ress->error.'")</script>';
            }
        }
        if($_POST['empresa']){
            $parameters = ['action' => '33', 'empresa' => $_POST['empresa']];
            $resul = json_decode(listaCentros($parameters));
            // print_r($resul);
                if($resul->result === "sucess"){
                    $centros = $resul->datas;
                    //print_r($emp);
                }else{
                    echo '<script>alert('.$resul->error.')</script>';
                }
        }
       
        if($_POST['empresa']){
            $pmts = ['action' => '28', 'empresa' => $_POST['empresa']];
            $rst = json_decode(listarFormaPagamento($pmts));

            if($rst->result === "sucess"){
                $frmpag = $rst->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$rst->error.')</script>';
            }
        }
        ?>
	<div class="container text-left">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Buscar Contas a Pagar</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                   
                        
                            <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"><p>Empresa (segure CTRL para selecionar mais de uma)</p></label>
                                    <div class="col-sm-10">
                                        <select name="empresa[]" multiple="true" id="empresa" size="8" >
                                        <div class="col-sm-10">
                                            <option value=""  >Selecione</option>
                                                <?php
                                                foreach($emp as $item){
                                                    if($_POST['empresa']){
                                                ?>
                                                <option value="<?=$item->idemp?>" <?php if(isset($_POST['empresa']) && in_array($item->idemp,$_POST['empresa'])) echo 'selected';?>><?=$item->tipo_empresa?> - <?=$item->nome_fantasia?></option>
                                                <?php 
                                                    }else{
                                                        ?>
                                                        <option value="<?=$item->idemp?>"><?=$item->tipo_empresa?> - <?=$item->nome_fantasia?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Fornecedor*</label>
                                    <div class="col-sm-10">
                                        <select name="fornecedor" id="fornecedor" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                            foreach($forn as $item){
                                                // if($forn){
                                            ?>
                                            <option value="<?=$item->idforn?>" <?=($item->idforn == $_POST['fornecedor'])?'selected':''?>><?=$item->nome_fantasia?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>

                                        <div id="carregando-forn" style="display:none">Carregando...</div>
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
                                            <option value="<?=$item->idcentro?>" <?=($item->idcentro == $_POST['centro'])?'selected':''?>><?=$item->centro?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
                                        <div id="carregando-cent" style="display:none">Carregando...</div>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nota Fiscal</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nota_fiscal" class="form-control">
                                    </div>
                                </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Documento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="documento" class="form-control">
                                </div>
                            </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Descrição</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="descricao" class="form-control">
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data do Documento</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_doc_ini" id="message" value="<?=$_POST['dt_doc_ini']?>" class="form-control" placeholder="Data documento">
                                    Para:<input type="date" name="dt_doc_fin" id="message" value="<?=$_POST['dt_doc_ini']?>" class="form-control" placeholder="Data documento">
                                </div>
                                </div> 
                            
                                <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data do Vencimento</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_vencimento_ini" id="message" value="<?=$_POST['dt_vencimento_ini']?>" class="form-control" placeholder="Data Vencimento">
                                    <b>Para:</b><input type="date" name="dt_vencimento_fin" id="message" value="<?=$_POST['dt_vencimento_fin']?>" class="form-control" placeholder="Data Vencimento">
                                </div>
                                </div> 
                           
                                <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data do Pagamento</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_pag_ini" id="message" class="form-control" placeholder="Data Vencimento">
                                    para:<input type="date" name="dt_pag_fin" id="message" class="form-control" placeholder="Data Vencimento">
                                </div>
                                </div> 
                           
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Data de Inserção</label>
                                <div class="col-sm-10">
                                    <b>De:</b><input type="date" name="dt_ins_ini" id="message" class="form-control" placeholder="Data Vencimento">
                                    para:<input type="date" name="dt_ins_fin" id="message" class="form-control" placeholder="Data Vencimento">
                                </div>
                                </div> 
                                
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status Autorização</label>
                                    <div class="col-sm-10">
                                        <select name="status"  class="form-control selectpicker" data-live-search="true">
                                            <option data-tokens="">Selecione</option>
                                            <option data-tokens="AUTORIZADO">AUTORIZADO</option>
                                            <option data-tokens="DESAUTORIZADO">DESAUTORIZADO</option>
                                            <option data-tokens="PENDENTE">PENDENTE</option>
                                        </select>
                                    </div>
                                </div>
                           
                            
                                    <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Forma de Pagamento</label>
                                    <div class="col-sm-10">
                                        <select name="frm_pag" id="pagamento" class="form-control">
                                        <option value="" selected>Selecione</option>
                                        <?php
                                            foreach($frmpag as $item){
                                            ?>
                                            <option value="<?=$item->idfrmpag?>" <?=($item->idfrmpag == $_POST['pagamento'])?'selected':''?>><?=$item->pagamento?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div id="carregando-pag" style="display:none">Carregando...</div>
                                </div>
                           
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Status Pagamento</label>
                                        <div class="col-sm-10">
                                            <select name="status_pag"  class="form-control selectpicker" data-live-search="true">
                                                <option data-tokens="">Selecione</option>
                                                <option data-tokens="ABERTO">ABERTO</option>
                                                <option data-tokens="ATRASADO">ATRASADO</option>
                                                <option data-tokens="CANCELADO">CANCELADO</option>
                                                <option data-tokens="PAGO">PAGO</option>
                                            </select>
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
         
        //print_r($_POST['empresa']);
        if($_POST['empresa']){
            $emp = $_POST['empresa'];
            for($i=0;$i < sizeof($emp);$i++){
                if($i == (sizeof($emp)-1)){
                    $array .= $emp[$i];
                }else{
                    $array .= $emp[$i].',';
                }
                
            }
            // $tmp = explode(',',$_POST['empresa']);
            // $empresas = "'".implode("','",$tmp)."'";
        }
        
        //if(!$_POST['empresa']){$array = 0;}
         $params = [
             'fornecedor' => $_POST['fornecedor'],
             'empresa' => $array,
             'centro' => $_POST['centro'],
             'documento' => $_POST['documento'],
             'nota_fiscal' => $_POST['nota_fiscal'],
             'dt_doc_ini' => $_POST['dt_doc_ini'],
             'dt_doc_fin' => $_POST['dt_doc_fin'],
             'dt_vencimento_ini' => $_POST['dt_vencimento_ini'],
             'dt_vencimento_fin' => $_POST['dt_vencimento_fin'],
             'dt_pag_ini' => $_POST['dt_pag_ini'],
             'dt_pag_fin' => $_POST['dt_pag_fin'],
             'dt_ins_ini' => $_POST['dt_ins_ini'],
             'dt_ins_fin' => $_POST['dt_ins_fin'],
             'status_pag' => $_POST['status_pag'],
             'status' => $_POST['status'],
             'frm_pag' => $_POST['frm_pag'],
             'descricao' => $_POST['descricao'],
             'excluida' => 'nao',
             'action'=>'35'
         ];

        // print_r($params);

         $result = json_decode(listarContaPagar($params));
         //print_r($result);
         if($result->result === "sucess"){
             $list = $result->datas;
             //print_r($list);
         }

         $resultados = json_decode(graphContaPagarFrmPag($params));
         $grap = $resultados->datas;

         $_SESSION['list'] = $list;
         $_SESSION['graph'] = $grap;
     }
if($list){ ?>
    <div class="container">
		<div class="row">
            <h2 class="title text-center">Resultado da Busca</h2>
            <form method="post" id="form2" target="_blank">
            <?php if($_SESSION['nivel'] > 1){ ?>
            <button type="button" class="btn btn-warning" id="authallbtn" data-toggle="modal" data-target="#authall">Autorizar Selecionados</button>
            <button type="button" id="pagallbtn" class="btn btn-success">Quitar Selecionados</button>
            <button type="button"id="unauthallbtn" class="btn btn-danger">Desautorizar Selecionados</button>
            <a href="gerar_pdf.php" target="_blank" id="pdf" class="btn btn-primary">Baixar PDF dos resultados</a>
            <button type="button" id="xls" class="btn btn-success" onclick="toXls()">Baixar XLS dos resultados</button>
            <?php } ?>
            <br/>
            <br/>
            <div id="paginator">
                <table class="table cell-border" id="mytable">
                    <thead>
                        <tr>
                        
                            <th>Item</th>
                            <th>Ação</th>
                            <th>Empresa</th>
                            <th>Fornecedor</th>
                            <th>Centro de Custo</th>
                            <th>Nota Fiscal</th>
                            <th>Nr. Documento</th>
                            <th>Dt. Documento</th>
                            <th>Vr. Documento</th>
                            <th>Dt. Vencimento</th>
                            <th>Descrição</th>
                            <th>Observação</th>
                            <th>Status Autorização</th>
                            <th>Dt. Autorização</th>
                            <th>Status Pagamento</th>
                            <th>Dt. Pagamento</th>
                            <th>Desconto</th>
                            <th>Mul/Jur/Enc</th>
                            <th>Vr. Pago</th>
                            <th>Forma Pagamento</th>
                            <th>Obs. Pagamento</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach($list as $item){
                                $somaval += $item->val_doc;
                                $somamulta += $item->multa;
                                $somadesc += $item->vr_desc;
                                $somavalpag += $item->vr_pag;
                                ?>
                        <?php if($item->status_autorizacao == 'AUTORIZADO' && ($item->status_pag == 'ABERTO' || $item->status_pag == 'ATRASADO')){?>
                                <tr style="background-color:#f7ef94">
                        <?php } ?>
                        <?php if($item->status_autorizacao == 'DESAUTORIZADO' && ($item->status_pag == 'ABERTO' || $item->status_pag == 'ATRASADO')){?>
                                <tr style="background-color: #CE3C2D; color:white;">
                        <?php } ?>
                        <?php if($item->status_pag == 'PAGO'){?>
                                <tr  style="background-color: #7ebf97; color: #000;">
                        <?php } ?>
                        <?php if($item->status_autorizacao == 'PENDENTE'){?>
                                <tr>
                        <?php } ?>
                                <td><?=$item->id_conta?></td>
                                <td nowrap class="icones">
                                <?php
                                if($item->status_pag == 'PAGO'){
                                ?>
                                    <!-- <a href="documentos/comprovantes/conta_pagar/<?=$item->comprovante?>" class="quitar" id="embedURL" title="Visualizar Comprovante"><i class="fa fa-file-text" aria-hidden="true"></i></a>  -->
                                    <a href="#" class="quitar" data-toggle="modal" data-target="#embedComp<?=$item->id_conta?>" title="Visualizar Comprovante"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                <?php }else{ 
                                       if($_SESSION['nivel'] > 1){ ?>
                                    <input type="checkbox" name="check" id="check" value="<?=$item->id_conta?>"/> 
                                    <a href="#" data-toggle="modal" data-target="#pag<?=$item->id_conta?>" class="quitar" title="Quitar"><i class="fa fa-money" aria-hidden="true"></i></a>
                                <?php 
                                       }
                                    } ?>
                                    <a href="#" data-toggle="modal" data-target="#detalhes<?=$item->id_conta?>" title="Detalhes da Conta"><i class="fa fa-search" aria-hidden="true"></i></a>  
                                    <a href="#" data-toggle="modal" data-target="#embedDoc<?=$item->id_conta?>" title="Visualizar Arquivo"><i class="fa fa-files-o" aria-hidden="true"></i></a>  
                                    <a href="edt_cntpag.php?idconta=<?=$item->id_conta?>" target="blank" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
                                    <a href="#" data-toggle="modal" data-target="#del<?=$item->id_conta?>" title="Excluir"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php if($item->status_autorizacao == 'PENDENTE' || $item->status_autorizacao == 'DESAUTORIZADO' && $_SESSION['nivel'] > 1){ ?>
                                    
                                    <a href="#" data-toggle="modal" data-target="#auth<?=$item->id_conta?>" title="Autorizar"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a> 
                                <?php } 
                                    if($item->status_autorizacao == 'PENDENTE' || ($item->status_autorizacao == 'AUTORIZADO' && $item->status_pag == 'ABERTO') && $_SESSION['nivel'] > 1 ){
                                ?>
                                    <a href="#"  data-toggle="modal" data-target="#unauth<?=$item->id_conta?>" class="desautorizar" title="Desautorizar"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a> 
                                <?php } ?>
                                    
                                    
                                </td>
                                    
                                    <td><?=$item->empresa?></td>
                                    <td><?=$item->fornecedor?></td>
                                    <td><?=$item->centro?></td>
                                    <td><?=$item->num_nota?></td>
                                    <td><?=$item->num_doc?></td>
                                    <td><?=recebedata($item->dt_doc)?></td>
                                    <td><?=number_format($item->val_doc,2,',','.')?></td>
                                    <?php if($item->dt_vencimento < date("Y-m-d") && $item->status_pag != 'PAGO'){ ?>
                                    <td><span class="hidden-span"><?=$item->dt_vencimento?></span><a href="#" style="color: red;" data-toggle="modal" data-target="#edtdata<?=$item->id_conta?>"><?=recebedata($item->dt_vencimento)?></a></td>
                                    <?php }else{ ?>
                                        <td><span class="hidden-span"><?=$item->dt_vencimento?></span><?=recebedata($item->dt_vencimento)?></td>
                                    <?php } ?>
                                    <td><?=$item->descricao?></td>
                                    <td><?=$item->obs?></td>
                                    <td><?=$item->status_autorizacao?></td>
                                    <td><?=recebedata($item->dt_autorizacao)?></td>
                                    <td><?=$item->status_pag?></td>
                                    <td><?=recebedata($item->dt_pag)?></td>
                                    <td><?=number_format($item->vr_desc,2,',','.')?></td>
                                    <td><?=number_format($item->multa,2,',','.')?></td>
                                    <td><?=number_format($item->vr_pag,2,',','.')?></td>
                                    <td><?=$item->frm_pag?></td>
                                    <td><?=$item->obs_pag?></td>
                                    <!-- Modal -->
                            <td> 
                            <div class="modal fade" id="detalhes<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 class="modal-title" style="color: #000" id="ModalLabel">Detalhes Conta</h5>
                                                </div>
                                                <div class="modal-body" style="color: #000;">
                                                    <table class="table">
                                                    
                                                        
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr, Documento</td><td><?=$item->documento?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Status Pagamento</td><td><?=$item->status_pag?></td></tr>
                                                        <tr><td>Status Autorização</td><td><?=$item->status_autorizacao?></td></tr>
                                                        <tr><td>Obs. Autorização</td><td><?=$item->obs_status?></td></tr>
                                                        <?php if($item->login_ins){ ?>
                                                            <tr><td>Login Inserção</td><td><?=$item->login_ins?></td></tr>
                                                            <tr><td>Data Inserção</td><td><?=recebedata($item->dt_ins).' '.$item->hr_ins?></td></tr>
                                                        <?php } ?>
                                                        <?php if($item->login_aut){ ?>
                                                            <tr><td>Login Autorização</td><td><?=$item->login_aut?></td></tr>
                                                            <tr><td>Data Autorização</td><td><?=recebedata($item->dt_aut).' '.$item->hr_aut?></td></tr>
                                                        <?php } ?>
                                                        <?php if($item->login_baixa){ ?>
                                                            <tr><td>Login Baixa</td><td><?=$item->login_baixa?></td></tr>
                                                            <tr><td>Data Baixa</td><td><?=recebedata($item->dt_baixa).' '.$item->hr_baixa?></td></tr>
                                                        <?php } ?>
                                                        <?php if($item->login_exc){ ?>
                                                            <tr><td>Login Exclusão</td><td><?=$item->login_exc?></td></tr>
                                                            <tr><td>Data Exclusão</td><td><?=recebedata($item->dt_exc).' '.$item->hr_exc?></td></tr>
                                                        <?php } ?>
                                                        
                                                        
                                                    <?php  ?>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                            <div class="modal fade" id="embedDoc<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 class="modal-title" style="color: #000" id="ModalLabel">Visualizar Documento Registro <?=$item->id_conta?></h5>
                                                </div>
                                                <?php if(is_file("documentos/conta_pagar/".$item->documento)){ ?>
                                                <div class="modal-body" style="color: #000;">
                                                    <embed src="documentos/conta_pagar/<?=$item->documento?>" type="application/pdf" width="100%" height="650px"/>
                                                </div>
                                                <?php }else{ ?>
                                                    <div class="modal-body" style="color: #000;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" id="no-file" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                                        <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                    </svg>
                                                    <p class="no-file-warning">O documento buscado não está disponível no sistema.</p>
                                                </div>
                                                    <?php } ?>
                                                <!-- <div class="modal-footer">
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="autorizar" class="btn btn-primary" onclick="editadata(<?=$item->id_conta?>)" id="edtbtn<?=$item->id_conta?>">Atualizar</button>
                                                </div> -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="embedComp<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 class="modal-title" style="color: #000" id="ModalLabel">Visualizar Comprovante Registro <?=$item->id_conta?></h5>
                                                </div>
                                               
                                                <?php if(is_file("documentos/comprovantes/conta_pagar/".$item->comprovante)){ ?>
                                                <div class="modal-body" style="color: #000;">
                                                    <embed src="documentos/comprovantes/conta_pagar/<?=$item->comprovante?>" type="application/pdf" width="100%" height="650px"/>
                                                </div>
                                                <?php }else{ ?>
                                                    <div class="modal-body" style="color: #000;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" id="no-file" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                                        <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                    </svg>
                                                    <p class="no-file-warning">O comprovante buscado não está disponível no sistema.</p>
                                                </div>
                                                    <?php } ?>
                                                <!-- <div class="modal-footer">
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="autorizar" class="btn btn-primary" onclick="editadata(<?=$item->id_conta?>)" id="edtbtn<?=$item->id_conta?>">Atualizar</button>
                                                </div> -->
                                                
                                            </div>
                                        </div>
                                    </div>
                            <div class="modal fade" id="edtdata<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 class="modal-title" style="color: #000" id="ModalLabel">Atualizar Data de Vencimento</h5>
                                                </div>
                                                <div class="modal-body" style="color: #000;">
                                                    <table class="table">
                                                   
                                                        
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr, Documento</td><td><?=$item->documento?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Status Pagamento</td><td><?=$item->status_pag?></td></tr>
                                                        <tr><td>Status Autorização</td><td><?=$item->status_autorizacao?></td></tr>
                                                        <tr><td>Obs. Autorização</td><td><?=$item->obs_status?></td></tr>
                                                        <tr><td>Nova Data</td><td><input type="date" style="width: 100%;" name="dt_vencimento" id="data<?=$item->id_conta?>"></td></tr>
                                                        <!--<tr><td>Site</td><td><?=$item->site?></td></tr> -->
                                                        
                                                    <?php  ?>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="autorizar" class="btn btn-primary" onclick="editadata(<?=$item->id_conta?>)" id="edtbtn<?=$item->id_conta?>">Atualizar</button>
                                                </div>
                                                <script>
                                                    function editadata(id){
                                                        //alert(id)
                                                        data = $('#data'+id).val();
                                                        cod = $('#idconta'+id).val();
                                                        usu = $('#usuario').val();
                                                        if(data){
                                                            //alert(obs);
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "includes/api.php",
                                                                data: {'codigo':cod,'usuario':usu,'dt_vencimento':data,'action':40},
                                                                success: function(result){
                                                                    let res = JSON.parse(result)
                                                                    console.log(res.msg)                                       
                                                                    alert(res.msg);
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
                                                        }else{
                                                            alert("É necessário informar a nova data!");
                                                        }
                                                        
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                <?php if($item->status != 'AUTORIZADO'){ ?>
                            <div class="modal fade" id="auth<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 class="modal-title" style="color: #000" id="ModalLabel">Autorizar Pagamento</h5>
                                                </div>
                                                <div class="modal-body" style="color: #000;">
                                                    <table class="table">
                                                    
                                                        
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr, Documento</td><td><?=$item->documento?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Status Pagamento</td><td><?=$item->status_pag?></td></tr>
                                                        <tr><td>Status Autorização</td><td><?=$item->status_autorizacao?></td></tr>
                                                    <tr><td>Obs. Autorização</td><td><?=$item->obs_status?></td></tr>
                                                        <tr><td>Observações de Autorização</td><td><input type="text" style="width: 100%;" name="autorizar" id="autorizar<?=$item->id_conta?>"></td></tr>
                                                        <!--<tr><td>Site</td><td><?=$item->site?></td></tr> -->
                                                        
                                                    <?php  ?>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="autorizar" class="btn btn-primary" onclick="autoriza(<?=$item->id_conta?>)" id="authbtn<?=$item->id_conta?>">Autorizar</button>
                                                </div>
                                                <script>
                                                    function autoriza(id){
                                                        //alert(id)
                                                        obs = $('#autorizar'+id).val();
                                                        cod = $('#idconta'+id).val();
                                                        usu = $('#usuario').val();

                                                        //alert(obs);
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "includes/api.php",
                                                            data: {'codigos':cod,'usuario':usu,'obs':obs,'action':36},
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

                                    <?php } 
                                     if($item->status != 'DESAUTORIZADO') {
                                    ?> 

                                    <div class="modal fade" id="unauth<?=$item->id_conta?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="ModalLabel">Desautorizar Conta</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                   
                                                        
                                                        <tr><td>Empresa</td><td><?=$item->empresa?></td></tr>
                                                        <!-- <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr> -->
                                                        <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr, Documento</td><td><?=$item->documento?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Status Pagamento</td><td><?=$item->status_pag?></td></tr>
                                                        <tr><td>Status Autorização</td><td><?=$item->status_autorizacao?></td></tr>
                                                        <tr><td>Obs. Autorização</td><td><?=$item->obs_status?></td></tr>
                                                        <tr><td>Observações de Desautorização</td><td><input type="text" name="desautorizar" style="width: 100%;" id="desautorizar<?=$item->id_conta?>"></td></tr>
                                                        <!--<tr><td>Site</td><td><?=$item->site?></td></tr> -->
                                                        
                                                    <?php  ?>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="desautorizar" class="btn btn-primary" onclick="desautoriza(<?=$item->id_conta?>)" id="unauthbtn<?=$item->id_conta?>">Desautorizar</button>
                                                </div>
                                                <script>
                                                    function desautoriza(id){
                                                        obs = $('#desautorizar'+id).val();
                                                        cod = $('#idconta'+id).val();
                                                        usu = $('#usuario').val();

                                                        //alert(obs);
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "includes/api.php",
                                                            data: {'codigos':cod,'usuario':usu,'obs':obs,'action':37},
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
                                    <?php } 
                                    if($status_pag != 'PAGO'){
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
                                                        <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
                                                        <tr><td>Centro de Custo</td><td><?=$item->centro?></td></tr>
                                                        <tr><td>Nr, Documento</td><td><?=$item->documento?></td></tr>
                                                        <tr><td>Dt. Documento</td><td><?=recebedata($item->dt_doc)?></td></tr>
                                                        <tr><td>Vr. Documento</td><td><?=number_format($item->val_doc,2,',','.')?></td></tr>
                                                        <tr><td>Dt. Vencimento</td><td><?=recebedata($item->dt_vencimento)?></td></tr>
                                                        <tr><td>Descrição</td><td><?=$item->descricao?></td></tr>
                                                        <tr><td>Arquivo Da Conta</td><td><a href="documentos/<?=$item->documento?>" download><i class="fa fa-download" aria-hidden="true"></i></a> </td></tr>
                                                        <tr><td>Observaões</td><td><?=$item->obs?></td></tr>
                                                        <tr><td>Status Pagamento</td><td><?=$item->status_pag?></td></tr>
                                                        <tr><td>Status Autorização</td><td><?=$item->status_autorizacao?></td></tr>
                                                    <tr><td>Obs. Autorização</td><td><?=$item->obs_status?></td></tr>
                                                    <tr><td>Forma Pagamento</td><td><?=$item->frm_pag?></td></tr>
                                                    <?php $hoje = date('Y-m-d');?>
                                                    <tr><td>Data Pagamento*</td><td><input type="date" name="dt_pag" id="dt_pag<?=$item->id_conta?>" class="form-control" required value="<?=$hoje?>"></td></tr>
                                                    <tr><td>Desconto</td><td><input type="text"  name="desconto" id="valordesc<?=$item->id_conta?>" value="0,00"></td></tr>
                                                        <tr><td>Multa/Juros/Encargos</td><td><input type="text"  name="multa" required id="valormul<?=$item->id_conta?>" value="0,00"></td></tr>
                                                        <tr><td>Valor Pago*</td><td><input type="text"  name="vr_pago" required id="valorpag<?=$item->id_conta?>" value="0,00"></td></tr>
                                                    <tr><td>Comprovante de Pagamento</td><td><input type="file" id="file<?=$item->id_conta?>" name="comprovante" accept=".pdf, .jpeg, .png" style="widith:100%"></tr>
                                                    <tr><td>Observações de Desautorização</td><td><input type="text" name="pagamento" style="width:100%;"  id="pagamento<?=$item->id_conta?>"></td></tr>
                                                        <!--<tr><td>Site</td><td><?=$item->site?></td></tr> -->
                                                        
                                                    <?php  ?>
                                                    </table>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="<?=$item->id_conta?>" name="idconta" id="idconta<?=$item->id_conta?>"/>
                                                    <input type="hidden" value="<?=$item->val_doc?>" name="val_doc" id="valdoc<?=$item->id_conta?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="desautorizar" class="btn btn-primary" onclick="quita(<?=$item->id_conta?>)" id="pagbtn<?=$item->id_conta?>">Quitar</button>
                                                </div>
                                                <script>
                                                       
                                                        $(function(){
                                                            $("#telefone, #fax").mask("(00) 0000-0000");
                                                            $("#cep").mask("00.000-000");
                                                            $("#valor").mask("##.00", {reverse: true});
                                                            $("#ret").mask("#.00", {reverse: true});
                                                            $("#extra").mask("#.00", {reverse: true});
                                                            $("#fatura").mask("#.00", {reverse: true});
                                                            $("#valordesc<?=$item->id_conta?>").mask("###.00", {reverse: true});
                                                            $("#valormul<?=$item->id_conta?>").mask("###.00", {reverse: true});
                                                            $("#valorpag<?=$item->id_conta?>").mask("###.00", {reverse: true});
                                                            $("#csll").mask("0.00", {reverse: true});
                                                            $("#inss").mask("0.00", {reverse: true});
                                                            $("#iss").mask("0.00", {reverse: true});
                                                            $("#valdoc<?=$item->id_conta?>").mask("###.00", {reverse: true});

                                                            $("#valordesc<?=$item->id_conta?>").blur(function(){
                                                                var val_doc = parseFloat($("#valdoc<?=$item->id_conta?>").val());
                                                                var valor = parseFloat($("#valordesc<?=$item->id_conta?>").val());
                                                                var valor2 = parseFloat($("#valormul<?=$item->id_conta?>").val())
                                                                var soma = (valor+valor2);
                                                                var total = (val_doc + valor2 - valor);
                                                                console.log('Total',total)

                                                                $("#valorpag<?=$item->id_conta?>").val(total);

                                                            })
                                                            $("#valormul<?=$item->id_conta?>").blur(function(){
                                                                var val_doc = parseFloat($("#valdoc<?=$item->id_conta?>").val());
                                                                var valor = parseFloat($("#valordesc<?=$item->id_conta?>").val());
                                                                var valor2 = parseFloat($("#valormul<?=$item->id_conta?>").val())
                                                                var soma = (valor+valor2);
                                                                var total = val_doc + valor2 -valor;
                                                                console.log('Total',total)

                                                                $("#valorpag<?=$item->id_conta?>").val(total);

                                                            })
                                                        })

                                                    function quita(id){
                                                        obs = $('#pagamento'+id).val();
                                                        cod = $('#idconta'+id).val();
                                                        desc = $('#valordesc'+id).val();
                                                        mul = $('#valormul'+id).val();
                                                        vrpag = $('#valorpag'+id).val();
                                                        dt_pag = $('#dt_pag'+id).val();
                                                        usu = $('#usuario').val();
                                                        console.log('Desc',desc)
                                                        console.log('Mul',mul)
                                                        //alert(vrpag);
                                                        var file_data = $('#file'+id).prop('files')[0];  
                                                        var nomearquivo = $('#file'+id).val().replace(/C:\\fakepath\\/i, '');
                                                        if(!file_data){
                                                            alert("É necessário informar o comprovante!");
                                                            return false
                                                        }
                                                        if(vrpag == '0,00' || vrpag == 0){
                                                            alert("É necessário informar o valor pago!");
                                                            return false
                                                        }
                                                        if(desc < 0.00){
                                                            alert("É necessário informar o valor pago!");
                                                            return false
                                                        }
                                                        if(mul < 0.00){
                                                            alert("É necessário informar o valor pago!");
                                                            return false
                                                        }
                                                        if(file_data && vrpag != '0,00' && vrpag != 0){
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "includes/api.php",
                                                                data: {'codigos':cod,'obs':obs, 'usuario':usu, 'desc':desc,'mul':mul,'vrpag':vrpag,'dt_pag':dt_pag, 'comprovante':nomearquivo,'action':50},
                                                                success: function(result){
                                                                                                                    
                                                                    alert(result);
                                                                    var dados = jQuery(this).serialize();
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "includes/api.php",
                                                                        data: dados,
                                                                        success: function(msg){
                                                                            //alert(msg);
                                                                            var file_data = $('#file'+id).prop('files')[0];   
                                                                            var form_data = new FormData();                  
                                                                            form_data.append('file', file_data);
                                                                            //alert(form_data);
                                                                            //console.log(data)
                                                                            $.ajax({
                                                                                url: 'upload.php', // server-side PHP script 
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
                                                                                                                                
                                                                        }	
                                                                    });
                                                                    return false;
                                                                                                                    
                                                                                                                        
                                                                }	
                                                            });
                                                        }
                                                    }
                                                    </script>
                                            </div>
                                        </div>
                                    </div>

                                    <?php } ?>

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
                                                        <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
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
                                                        data: {'codigos':cod,'usuario':usu,'action':39},
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
                            
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="tablesorter-ignoreRow" style="background-color:#5488cc; color:#fff;"><td colspan="8"><b>Total</b></td><td><b><?=number_format($somaval,2,',','.')?></b></td><td colspan="7"></td><td><b><?=number_format($somadesc,2,',','.')?></b></td><td><b><?=number_format($somamulta,2,',','.')?></b></td><td colspan="2"><b><?=number_format($somavalpag,2,',','.')?></b></td><td></td><td></td></tr>
                            </tfoot>

                </table>
                <div class="container">
		<div class="row">
            <h2 class="title text-center">Resumo por Forma de Pagamento</h2>
        
            <table class="table cell-border" id="other-table">
                <thead>
                    <th>Empresa</th>
                    <th>Forma de pagamento</th>
                    <th>Valor Documento</th>
                    <th>Valor Pago</th>
                </thead>
                <?php foreach($grap as $item){ ?>
                    <tr>
                        <td><?=$item->empresa?></td>
                        <td><?=$item->pagamento?></td>
                        <td><?=$item->val_doc?></td>
                        <td><?=$item->vr_pag?></td>
                        
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
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
    


<!-- tablesorter widgets (optional) -->
<!-- <script type="text/javascript" src="js/dist/js/jquery.tablesorter.widgets.js"></script> -->
<script type="text/javascript">
	
        function checar() { 
            
        $.ajax({
        method: "POST",
        dataType: 'html',
        url: "includes/checa.php",
        data: {'tabela':'conta_pagar'} ,
        success: function(resultado){ 
            console.log(resultado)
            if(resultado == 'Sucesso'){
                $.ajax({
                    method: "POST",
                    dataType: 'html',
                    url: "includes/att.php",
                    data: 'data',
                    success: function(resultado){
                        //console.log(resultado)
                        document.location.reload(true);
                    }
                })
                 
            }
             
        },
        error: function(request,status,error){
            //alert(request.responseText);
        }

        })
    }

    window.setInterval("checar()", 1000)
    
    

</script>

<script>
    function toPdf(){
        $('#form2').append('<input type="hidden" name="dados" value="<?php echo htmlentities(serialize($list)); ?>" id="dados" />');
        $('#form2').append('<input type="hidden" name="graph" value="<?php echo htmlentities(serialize($grap)); ?>" id="graph" />');
        $("#form2").attr("action", "gerar_pdf.php").submit();
    }
    function toXls(){
        $('#form2').append('<input type="hidden" name="dados" value="<?php echo htmlentities(serialize($list)); ?>" id="dados" />');
        $('#form2').append('<input type="hidden" name="graph" value="<?php echo htmlentities(serialize($grap)); ?>" id="graph" />');
        $("#form2").attr("action", "gerar_xls.php").submit();
    }
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
                                            console.log('Lista',lista);
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
                                    //         console.log('Fornecedores',msg);
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
            "order": [[ 9, "asc" ]],
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100,"Tudo"]]
        });
       
        
     });
     $('#embedURL').zohoViewer();
  </script>
    
 <script>
        $(function(){
            $("#fornecedor").change(function(){
                console.log('Fornecedor escolhido',$(this).val());
            })
            $('#empresa').on('change',function(){
                
                var Codigos = new Array();
 
                $("select[name='empresa[]']").each(function(){
                    Codigos.push($(this).val());
                    console.log('Codigos',Codigos[0]);
                });
                //alert($(this).val())
                $('#fornecedor').hide();
                $('#carregando-forn').show();
                var options = '<option value="">Selecione</option>';
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':Codigos[0],'action':32},
                    success: function(msg){
                        //alert(msg);
                        console.log('Fornecedores',msg)
                        let values = JSON.parse(msg);
                        if(values != "null"){
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
                    }	,
                    error: function(e){
                        $('#fornecedor').html(
                            '<option value="">-- Selecione um centro de custo --</option>'
                        ).show();
                        $('#carregando-forn').hide();
                    }
                });
            });
            $('#empresa').on('change',function(){
                var Codigos = new Array();
 
                $("select[name='empresa[]']").each(function(){
                    Codigos.push($(this).val());
                    console.log('Codigos',Codigos[0]);
                });
                //alert($(this).val())
                $('#centro').hide();
                $('#carregando-cent').show();
                var options = '<option value="">Selecione</option>';

                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':Codigos[0],'action':33},
                    success: function(msg){
                        //alert(msg);
                        console.log('Centros',msg)
                        let values = JSON.parse(msg);
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
                                '<option value="">-- Selecione uma empresa --</option>'
                            ).show();
                            $('#carregando-cent').hide();
                        }
                    }	,
                    error: function(e){
                        $('#centro').html(
                            '<option value="">-- Selecione uma empresa --</option>'
                        ).show();
                        $('#carregando-cent').hide();
                    }	
                });
            });
            $('#empresa').on('change',function(){
                var Codigos = new Array();
 
                $("select[name='empresa[]']").each(function(){
                    Codigos.push($(this).val());
                    console.log('Codigos',Codigos[0]);
                });
                //alert($(this).val())
                $('#pagamento').hide();
                $('#carregando-pag').show();
                var options = '<option value="">Selecione</option>';


                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':Codigos[0],'action':65},
                    success: function(msg){
                        //alert(msg);
                        console.log('Pagamentos',msg)
                        let values = JSON.parse(msg);
                        if(values != "null"){
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
                                '<option value="">-- Selecione uma empresa --</option>'
                            ).show();
                            $('#carregando-pag').hide();
                        }
                    }	,
                    error: function(e){
                        $('#pagamento').html(
                            '<option value="">-- Selecione uma empresa --</option>'
                        ).show();
                        $('#carregando-pag').hide();
                    }	
                });

                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresa':JSON.stringify(Codigos[0]),'action':66},
                    success: function(msg){
                        //alert(msg);
                        console.log('Recebimentos',msg)
                    }	
                });

            
            })

            //$("#ordena").tablesorter({ sortList: [[0,0], [1,0]] });
            
        });

        

       
		$("#telefone, #fax").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");

        
	
    </script>
    <!-- <script>
        $(function() {
            $( "#fornecedor" ).autocomplete({
                source: 'includes/search.php'
            });
        });
    </script> -->
    
</body>
</html>