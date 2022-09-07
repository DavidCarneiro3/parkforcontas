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
        $id = ($_GET['idemp'])?$_GET['idemp']:$_POST['idemp'];
        if($_POST['btn']){
            
            $params = [
                'razao_social' => $_POST['razao_social'],
                'nome_fantasia' => $_POST['nome_fantasia'],
                'cnpj' => $_POST['cnpj'],
                'tipo_empresa' => $_POST['tipo_empresa'],
                'matriz' => $_POST['matriz'],
                'num_banco' => $_POST['num_banco'],
                'banco' => $_POST['banco'],
                'conta' => $_POST['conta'],
                'agencia' => $_POST['agencia'],
                'convenio' => $_POST['convenio'],
                'carteira' => $_POST['carteira'],
                'variacao' => $_POST['variacao'],
                'irrf' => $_POST['irrf'],
                'pis' => $_POST['pis'],
                'cofins' => $_POST['cofins'],
                'inss' => $_POST['inss'],
                'csll' => $_POST['csll'],
                'iss' => $_POST['iss'],
                'usuario' => $_SESSION['user'],
                'idemp' => $id,
                'status' => $_POST['status'],
                'action'=>'15'
            ];
            //print_r($params);
            $result = loadApi($params);
            // print_r($result);
            if($result->result === "sucess"){
                echo '<script>alert("Empresa Atualizada.")</script>';
            }else{echo '<script>alert("'.$result->error.'")</script>';}
        }
        if($_POST['del']){
            //print_r($_POST);
            $prms = ['action' => '24', 'idemp' => $id, 'usuario' => $_SESSION['user']];
            $del = loadApi($prms);
            if($del->result == 'sucess'){
                echo '<script>
                alert("Registro excluído!");
                window.location.href = "busca_emp.php";
                </script>';
                
            }
            else{
                echo '<script>alert("Erro ao excluir registro!")</script>';
                //print_r($del);
            }
        }

        $par = ['emp' => $id, 'action' => '6'];
        $list = loadApi($par);
        $empresa = $list->datas;
        //print_r($empresa);
        //echo $empresa[0]->cnpj;

        $params = ['action' => '5'];
        $res = loadApi($params);

            if($res->result === "sucess"){
                $emp = $res->datas;
                //print_r($emp);
            }else{
                echo '<script>alert('.$result->error.')</script>';
            }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Editar Empresa</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                    <input type="hidden" name="cnpj"  value="<?=$empresa[0]->cnpj?>">
                        <div class="form-group">
                            <input type="text" name="razao_social" class="form-control" value="<?=$empresa[0]->razao_social?>" placeholder="Razão Social*">
                        </div>
                        <div class="form-group">
                            <input type="text" name="cpfcnpj" id="cnpj" class="form-control"  disabled="true" value="<?=$empresa[0]->cnpj?>" placeholder="CNPJ Apenas números*">
                        </div>
                        <div class="form-group">
                            <input type="text" name="nome_fantasia" class="form-control" value="<?=$empresa[0]->nome_fantasia?>" placeholder="Nome Fantasia*">
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo Empresa*</label>
                            <select name="tipo_empresa" required="required">
                            <option value="">Selecione</option>
                            <?php if($empresa[0]->tipo_empresa == 'Matriz'){ ?>
                                <option value="Matriz" selected="true">Matriz</option>
                                <option value="Filial">Filial</option>
                                <?php }else{ ?>
                                    <option value="Matriz" >Matriz</option>
                                    <option value="Filial" selected>Filial</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Matriz</label>
                            <select name="matriz">
                            <option value="" disabled selected>Selecione</option>
                                <?php
                                foreach($emp as $item){
                                ?>
                                  <option value="<?=$item->idemp?>" <?=($empresa[0]->fk_matriz && $item->idemp==$empresa[0]->fk_matriz)?'selected':''?>><?=$item->razao_social?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Número do Banco</label>
                            <input type="text" name="num_banco" id="message" class="form-control" value="<?=$empresa[0]->num_banco?>" placeholder="Número do Banco">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Banco</label>
                            <input type="text" name="banco" id="message" class="form-control" value="<?=$empresa[0]->banco?>" placeholder="Banco">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Conta</label>
                            <input type="text" name="conta" id="message" class="form-control" value="<?=$empresa[0]->conta?>" placeholder="Conta">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Agência</label>
                            <input type="text" name="agencia" id="message" class="form-control" value="<?=$empresa[0]->agencia?>" placeholder="Agência">
                        </div> 
                        
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Convênio</label>
                            <input type="text" name="convenio" id="message" class="form-control" value="<?=$empresa[0]->convenio?>" placeholder="Convênio">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">IRRF</label>
                            <input type="text" name="irrf" id="message" class="form-control" value="<?=$empresa[0]->irrf?>" placeholder="Porcentagem IRRF">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">PIS</label>
                            <input type="text" name="pis" id="message" class="form-control" value="<?=$empresa[0]->pis?>" placeholder="Porcentagem PIS">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">COFINS</label>
                            <input type="text" name="cofins" id="message" class="form-control" value="<?=$empresa[0]->cofins?>" placeholder="Porcentagem COFINS">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">CSLL</label>
                            <input type="text" name="csll" id="message" class="form-control" value="<?=$empresa[0]->csll?>" placeholder="Porcentagem CSLL">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">INSS</label>
                            <input type="text" name="inss" id="message" class="form-control" value="<?=$empresa[0]->inss?>" placeholder="Porcentagem INSS">
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">ISS</label>
                            <input type="text" name="iss" id="message" class="form-control" value="<?=$empresa[0]->iss?>" placeholder="Porcentagem ISS">
                        </div>   
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Status</label>
                            <select name="status">
                            <option value="" disabled selected>Selecione</option>
                                <option value="ATIVA" <?=($_SESSION['nivel'] < 3)? 'disabled':''?> <?=($empresa[0]->status=='ATIVA')?'selected':''?>>ATIVA</option>
                                <option value="DESATIVADA" <?=($_SESSION['nivel'] < 3)? 'disabled':''?> <?=($empresa[0]->status=='DESATIVADA')?'selected':''?>>DESATIVADA</option>
                            </select>
                        </div>
                        <input type="hidden" name="idemp" value="<?=$empresa[0]->idemp?>"/>
                        <div class="form-group">
                        <!-- <a class="btn btn-info" href="javascript:location.href = 'busca_emp.php'">Voltar</a> -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                Deletar
                            </button>
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
                                        <input type="hidden" name="idemp" value="<?=$empresa[0]->idemp?>"/>
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
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script>
        $("#cnpj").on('blur',function(){
            
            cnpj = $("#cnpj").val();
            console.log(cnpj)
            cnpj = cnpj.replace(/[^\d]+/g,'');
            //$("#erro").html('Válido');

            if(cnpj == ''){
                $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                $("#erro").html("Cnpj Não pode ser vazio!");
                $("#cnpj").focus()
                return false;
            }else{
                $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                $("#erro").html('Válido');
            }
            
            if (cnpj.length != 14){
                $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                $("#erro").html("Cnpj com tamanho inválido!");
                $("#cnpj").focus()
                return false;
            }else{
                $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                $("#erro").html('Válido');
            }

            // Elimina CNPJs invalidos conhecidos
            if (cnpj == "00000000000000" || 
                cnpj == "11111111111111" || 
                cnpj == "22222222222222" || 
                cnpj == "33333333333333" || 
                cnpj == "44444444444444" || 
                cnpj == "55555555555555" || 
                cnpj == "66666666666666" || 
                cnpj == "77777777777777" || 
                cnpj == "88888888888888" || 
                cnpj == "99999999999999"){
                    $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                    $("#erro").html("Cnpj com padrão inválido!");
                    $("#cnpj").focus()
                    return false;
                }else{
                    $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                    $("#erro").html('Válido');
                }
                
            // Valida DVs
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)){
                $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                $("#erro").html("Primeiro digito errado!");
                $("#cnpj").focus()
                return false;
            }else{
                $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                $("#erro").html('Válido');
            }
                
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)){
                $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                $("#erro").html("Segundo digito errado!");
                $("#cnpj").focus()
                return false;
            }else{
                $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                $("#erro").html('Válido');
            }
                    
            return true;
        })
    </script>
</body>
</html>