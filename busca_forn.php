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
       
	<div class="container">
            <?php 
            include("includes/menu.php"); 
            $par = ['status' => 'ATIVA'];
            $empresas = json_decode(listaEmpresaAtiva($par));
            $emp = $empresas->datas;
            ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Buscar Fornecedores</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        
                    <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa</label>
                            <select name="empresa" class="form-control">
                            <option value="" disabled selected>Selecione</option>
                                <?php
                                foreach($emp as $item){
                                ?>
                                  <option value="<?=$item->idemp?>"><?=$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo</label>
                            <select name="tipo_fornecedor" class="form-control">
                                <option value="" disabled selected>Selecione</option>
                                <option value="PF">Pessoa Física</option>
                                <option value="PJ">Pessoa Jurídica</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">CPF/CNPJ</label>
                            <input type="number" name="cpf_cnpj" class="form-control" placeholder="Apenas números">
                        </div>

                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Fornecedor</label>
                            <input type="text" name="fornecedor" id="fornecedor" class="form-control" placeholder="Informe parte do nome do fornecedor">
                        </div>
                                           
                        <div class="form-group">
                            <input type="submit" name="btn" class="btn btn-primary" value="Buscar">
                        </div>
                    </form>
                </div>
            </div>
            
                                
	</div>
    <?php 
     if($_POST['btn']){
      
         $params = [
             'tipo_fornecedor' => $_POST['tipo_fornecedor'],
             'empresa' => $_POST['empresa'],
             'cpf_cnpj' => $_POST['cpf_cnpj'],
             'fornecedor' => $_POST['fornecedor'],
             'action'=>'11'
         ];

         $result = json_decode(listaFornecedor($params));
         //print_r($result);
         if($result->result === "sucess"){
             $list = $result->datas;
             //print_r($list);
         }
     }
if($list){ ?>
    <div class="container">
		<div class="row">
            <h2 class="title text-center">Resultado da Busca</h2>
            <table class="table cell-border" id="mytable">
                <thead>
                    <th>Código</th>
                    <th>CPF/CNPJ</th>
                    <th>Fornecedor</th>
                    <th>Nome Fantasia</th>
                    <th>Tipo</th>
                    <th>Empresa</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <!-- <th>Endereço</th>
                    <th>Complemento</th>
                    <th>Bairro</th>
                    <th>Cep</th>
                    <th>UF</th>
                    <th>Cidade</th>
                    <th>Fax</th>
                    <th>Site</th> -->
                    <th>Ação</th>
                    <th></th>
                </thead>
                <?php foreach($list as $item){ ?>
                    <tr>
                        <td><?=$item->idforn?></td>
                        <td><?=$item->cpf_cnpj?></td>
                        <td><?=$item->fornecedor?></td>
                        <td><?=$item->nome_fantasia?></td>
                        <td><?=$item->tipo_fornecedor?></td>
                        <td><?=$item->empresa?></td>
                        <td><?=$item->fone?></td>
                        <td><?=$item->email?></td>
                        <!-- <td><?=$item->endereco?></td>
                        <td><?=$item->complemento?></td>
                        <td><?=$item->bairro?></td>
                        <td><?=$item->cep?></td>
                        <td><?=$item->uf?></td>
                        <td><?=$item->cidade?></td>
                        <td><?=$item->fax?></td>
                        <td><?=$item->site?></td> -->
                         <!-- Modal -->
                   <td> <div class="modal fade" id="modal<?=$item->idforn?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel">Fornecedor Detalhado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <table class="table">
                            
                                
                                <tr><td>Código</td><td><?=$item->idforn?></td></tr>
                                <tr><td>CPF/CNPJ</td><td><?=$item->cpf_cnpj?></td></tr>
                                <tr><td>Fornecedor</td><td><?=$item->fornecedor?></td></tr>
                                <tr><td>Nome Fantasia</td><td><?=$item->nome_fantasia?></td></tr>
                                <tr><td>Tipo Fornecedor</td><td><?=$item->tipo_fornecedor?></td></tr>
                                <!-- <tr><td>Empresa</td><td><?=$item->empresa?></td></tr> -->
                                <tr><td>Fone</td><td><?=$item->fone?></td></tr>
                                <tr><td>Email</td><td><?=$item->email?></td></tr>
                                <tr><td>Endereço</td><td><?=$item->endereco?></td></tr>
                                <tr><td>Complemento</td><td><?=$item->complemento?></td></tr>
                                <tr><td>Bairro</td><td><?=$item->bairro?></td></tr>
                                <tr><td>Cep</td><td><?=$item->cep?></td></tr>
                                <tr><td>Uf</td><td><?=$item->uf?></td></tr>
                                <tr><td>Cidade</td><td><?=$item->cidade?></td></tr>
                                <tr><td>Fax</td><td><?=$item->fax?></td></tr>
                                <tr><td>Site</td><td><?=$item->site?></td></tr>
                                
                            <?php  ?>
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <a href="edt_forn.php?idforn=<?=$item->idforn?>" title="Editar Fornecedor"><i class="fa fa-pencil" aria-hidden="true"></i></s>
                            <a href="#" data-toggle="modal" data-target="#modal<?=$item->idforn?>" title="Detalhes"><i class="fa fa-list" aria-hidden="true"></i></s>
                </td>
                        <td>
                            </td>
                    </tr>
                   
                <?php } ?>
            </table>
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
		
		
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2021 Parkfor. Todos os diretos reservados.</p>
					
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->

    
    <script src="js/jquery.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script>
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
        $(function() {
            $( "#fornecedor" ).autocomplete({
                source: 'includes/search.php'
            });
        });
    </script>
</body>
</html>