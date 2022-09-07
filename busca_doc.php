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
        <!-- load jQuery and tablesorter scripts -->
        <!-- <script type="text/javascript" src="js/dist/js/jquery-latest.js"></script> -->
        <script type="text/javascript" src="js/dist/js/jquery.tablesorter.js"></script>
        <script src="js/smartpaginator.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.scrollUp.min.js"></script>
        <script src="js/jquery.prettyPhoto.js"></script>
        <script src="js/main.js"></script>
    

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
        $pr = ['action' => '14'];
        $ret = loadApi($pr);
        $cli= $ret->datas;

        $params = ['action' => '5', 'status' => 'ATIVA'];
        $res = loadApi($params);

            if($res->result === "sucess"){
                $emp = $res->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$res->error.')</script>';
            }

        $paramss = ['action' => '11'];
        $ress = loadApi($paramss);

            if($ress->result === "sucess"){
                $forn = $ress->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$ress->error.')</script>';
            }

        $parameters = ['action' => '52', 'status' => 'ATIVO'];
        $resul = loadApi($parameters);

            if($resul->result === "sucess"){
                $tipos = $resul->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$resul->error.')</script>';
            }

        $pmts = ['action' => '28'];
        $rst = loadApi($pmts);

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
                    <h2 class="title text-center">Buscar Documentos</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                   
                            <div class="form-group">
                                    <label style="float: left; margin-left: 2%;">Empresa</label>
                                    <select name="empresa" id="empresa"  class="form-control selectpicker" data-live-search="true">
                                    <option data-tokens="" disabled selected>Selecione</option>
                                        <?php
                                        foreach($emp as $item){
                                        ?>
                                        <option data-tokens="<?=$item->idemp?>"><?=$item->razao_social?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                           
                                <div class="form-group">
                                    <label style="float: left; margin-left: 2%;">Tipo de Documento</label>
                                    <select name="tipo" class="form-control selectpicker" data-live-search="true">
                                    <option data-tokens="" selected>Selecione</option>
                                        <?php
                                        foreach($tipos as $item){
                                        ?>
                                        <option data-tokens="<?=$item->idtipodoc?>"><?=$item->tipo?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                </div>
                           
                                <div class="form-group">
                                    <label style="float: left; margin-left: 2%;">Fornecedor</label>
                                    <select name="fornecedor" id="fornecedor" class="form-control selectpicker" data-live-search="true">
                                    <option data-tokens="" selected>Selecione</option>
                                    <?php
                                        foreach($forn as $item){
                                        ?>
                                        <option data-tokens="<?=$item->fornecedor?>"><?=$item->fornecedor?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <script>
                                        $(function() {
                                            $('.selectpicker').selectpicker();
                                        });
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label style="float: left; margin-left: 2%;">Cliente</label>
                                    <select name="fornecedor" id="fornecedor" class="form-control selectpicker" data-live-search="true">
                                    <option data-tokens="" selected>Selecione</option>
                                    <?php
                                        foreach($cli as $item){
                                        ?>
                                        <option data-tokens="<?=$item->cliente?>"><?=$item->cliente?> - <?=$item->nome_fantasia?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <script>
                                        $(function() {
                                            $('.selectpicker').selectpicker();
                                        });
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label style="float: left; margin-left: 2%;">Nota Fiscal</label>
                                    <input type="text" name="nota_fiscal" class="form-control">
                                </div>
                            
                            <div class="form-group">
                                <label style="float: left; margin-left: 2%;">Documento</label>
                                <input type="text" name="documento" class="form-control">
                            </div>
                           
                                <div class="form-group">
                                    <label style="float: left; margin-left: 2%;">Descrição</label>
                                    <input type="text" name="descricao" class="form-control">
                                </div>
                            
                                <div class="form-group">
                                <label style="float: left; margin-left: 2%;">Data do Documento</label></br></br>
                                <b>De:</b><input type="date" name="dt_doc_ini" id="message" class="form-control" placeholder="Data Vencimento">
                                <b>Para:</b><input type="date" name="dt_doc_fin" id="message" class="form-control" placeholder="Data Vencimento">
                                </div> 
                            
                                <div class="form-group">
                                <label style="float: left; margin-left: 2%;">Data do Venciemto</label></br></br>
                                    <b>De:</b><input type="date" name="dt_vencimento_ini" id="message" class="form-control" placeholder="Data Vencimento">
                                    <b>Para:</b><input type="date" name="dt_vencimento_fin" id="message" class="form-control" placeholder="Data Vencimento">
                                </div> 
                            
                                        
                                <div class="form-group">
                                    <input type="hidden" name="action" value="35" />
                                    <input type="hidden" name="usuario" value="<?=$_SESSION['name']?>" />
                                    <input type="submit" name="btn" class="btn btn-primary" value="Buscar">
                                </div>
                           
                </div>
            </div>
            
                                
	</div>
    <?php 
     if($_POST['btn']){
         
        //print_r($_POST['empresa']);
        // if($_POST['empresa']){
        //     $emp = $_POST['empresa'];
        //     for($i=0;$i < sizeof($emp);$i++){
        //         if($i == (sizeof($emp)-1)){
        //             $array .= $emp[$i];
        //         }else{
        //             $array .= $emp[$i].',';
        //         }
                
        //     }
        //     // $tmp = explode(',',$_POST['empresa']);
        //     // $empresas = "'".implode("','",$tmp)."'";
        // }
        
        //if(!$_POST['empresa']){$array = 0;}
         $params = [
             'fornecedor' => $_POST['fornecedor'],
             'empresa' => $_POST['empresa'],
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
             'cliente' => $_POST['cliente'],
             'descricao' => $_POST['descricao'],
             'excluida' => 'não',
             'action'=>'56'
         ];

         //print_r($params);

         $result = loadApi($params);
        //  print_r($result);
         if($result->result === "sucess"){
             $list = $result->datas;
             //print_r($list);
         }
     }
if($list){ ?>
    <div class="container">
		<div class="row">
            <h2 class="title text-center">Resultado da Busca</h2>
            <form method="post" id="form2" target="blank">
            
            <br/>
            <br/>
            <div id="paginator">
                <table class="table cell-border hover" id="mytable">
                    <thead>
                        <tr style="color: #000; background-color: #ccc; text-align:center;">
                       
                            <th>Item</th>
                            <th>Ação</th>
                            <th>Empresa</th>
                            <th>Tipo Documento</th>
                            <th>Fornecedor</th>
                            <th>Cliente</th>
                            <th>Nota Fiscal</th>
                            <th>Nr. Documento</th>
                            <th>Dt. Documento</th>
                            <th>Vr. Documento</th>
                            <th>Dt. Vencimento</th>
                            <th>Descrição</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach($list as $item){
                                $somaval += $item->val_doc;
                                $somamulta += $item->multa;
                                $somadesc += $item->vr_desc;
                                $somavalpag += $item->vr_pag;
                                ?>
                       
                                <tr>
                       
                                <td><?=$item->iddoc?></td>
                                <td nowrap>
                            
                                    <a href="documentos/documento/<?=$item->documento?>" download title="Visualizar Arquivo"><i class="fa fa-files-o" aria-hidden="true"></i></a>  
                                    <a href="edt_doc.php?iddoc=<?=$item->iddoc?>" target="blank" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
                                    <a href="#" data-toggle="modal" data-target="#del<?=$item->iddoc?>" title="Excluir"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                
                                
                                </td>
                                    
                                    <td><?=$item->empresa?></td>
                                    <td><?=$item->tipo?></td>
                                    <td><?=$item->fornecedor?></td>
                                    <td><?=$item->cliente?></td>
                                    <td><?=$item->num_nota?></td>
                                    <td><?=$item->num_doc?></td>
                                    <td><?=recebedata($item->dt_doc)?></td>
                                    <td><?=number_format($item->val_doc,2,',','.')?></td>
                                    <td><?=recebedata($item->dt_vencimento)?></td>
                                    <td><?=$item->descricao?></td>
                                    <td><?=$item->obs?></td>
                                    
                                    <!-- Modal -->
                           
                            
                                    <div class="modal fade" id="del<?=$item->iddoc?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="ModalLabel">Excluir Conta</h4>
                                                </div>
                                                <div class="modal-body" style="color: #000">
                                                    Tem certeza que quer excluir esse registro?
                                                </div>
                                                <div class="modal-footer">
                                                <input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['name']?>" />
                                                <input type="hidden" value="<?=$item->iddoc?>" name="idconta" id="idconta<?=$item->iddoc?>"/>
                                                    <button type="submit" class="btn btn-danger" style="margin-top:3px;" data-dismiss="modal">Fechar</button>
                                                    <button type="button" name="deletar" class="btn btn-primary" onclick="excluir(<?=$item->iddoc?>)" id="delbtn<?=$item->iddoc?>">Excluir</button>
                                                </div>
                                                <script>

                                                function excluir(id){
                                                    cod = id;
                                                    usu = $('#usuario').val();
                                                    //alert(obs);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "includes/api.php",
                                                        data: {'codigos':cod,'usuario':usu,'action':57},
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
                                
                                    
                                </tr>
                            
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="tablesorter-ignoreRow" style="background-color:#5488cc; color:#fff;"><td colspan="9"><b>Total</b></td><td><b><?=number_format($somaval,2,',','.')?></b></td><td></td><td></td><td></td></tr>
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
            //alert(resultado);
            if(resultado == 'Sucesso'){
                $.ajax({
                    method: "POST",
                    dataType: 'html',
                    url: "includes/att.php",
                    data: 'data',
                    success: function(resultado){
                        console.log(resultado)
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

    window.setInterval("checar()", 1000)
    
    

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
<<script>
    $(function() {
        // alert('Entra aqui mas não funciona a ordenação');
        $("#mytable").DataTable({
            "language": {
                "url": "includes/br.json"
            },
            "pagingType": "full_numbers"
        });
       
       
     });
  </script>
    
 <script>
        $(function(){
            $('#empresa').change(function(){
                
                var Codigos = new Array();
 
                $("select[name='empresa[]']").each(function(){
                    Codigos.push($(this).val());
                    
                });
                //alert($(this).val())
                $.ajax({
                    type: "POST",
                    url: "includes/api.php",
                    data: {'empresas':Codigos,'action':32},
                    success: function(msg){
                        //alert(msg);
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