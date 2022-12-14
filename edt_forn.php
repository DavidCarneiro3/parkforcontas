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
        $id = ($_GET['idforn'])?$_GET['idforn']:$_POST['idforn'];
        if($_POST['btn']){
            $params = [
                'cnpj' => $_POST['cnpj'],
                'fornecedor' => ucwords($_POST['fornecedor']),
                'fantasia' => ucwords($_POST['nome_fantasia']),
                'tipo_fornecedor' => $_POST['tipo_fornecedor'],
                'fk_empresa' => $_POST['fk_empresa'],
                'endereco' => $_POST['endereco'],
                'complemento' => $_POST['complemento'],
                'bairro' => $_POST['bairro'],
                'cep' => $_POST['cep'],
                'uf' => $_POST['uf'],
                'cidade' =>$_POST['cidade'],
                'fone' => $_POST['fone'],
                'fax' => $_POST['fax'],
                'email' => $_POST['email'],
                'site' => $_POST['site'],
                'usuario' => $_SESSION['user'],
                'idforn' => $id,
                'action'=>'16'
            ];

            $result = loadApi($params);
            //print_r($_POST);
            print_r($result);
            if($result->result === "sucess"){
                echo '<script>alert("Fornecedor Atualizado.")</script>';
            }else{ ?>
                <script> alert('<?=$result->error?>') </script>;
      <?php }
        }

        if($_POST['del']){
            //print_r($_POST);
            $prms = ['action' => '23', 'idforn' => $id, 'usuario' => $_SESSION['user']];
            $del = loadApi($prms);
            if($del->result == 'sucess'){
                echo '<script>
                alert("Registro exclu??do!");
                window.location.href = "busca_emp.php";
                </script>';
                
            }
            else{
                echo '<script>alert("Erro ao excluir registro!")</script>';
                //print_r($del);
            }
        }

        $par = ['action' => '6', 'status' => 'ATIVA'];
        $data = loadApi($par);
        $list =  $data->datas;
        
        $param = ['action' => '7'];
        $resu = loadApi($param);
        $estados = $resu->datas;

        $params = [
            'id_forn' => $id,
            'usuario' => $_SESSION['user'],
            'action'=>'11'
        ];

        $result = loadApi($params);

        if($result->result === "sucess"){
            $res = $result->datas;
            // print_r($res);
        }else{
            echo '<script>alert('.$result->error.')</script>';
        }
        ?>
	<div class="container">
            <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
                <div class="contact-form">
                    <h2 class="title text-center">Editar Fornecedor</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                        <div class="form-group">
                            <input type="text" name="cnpj" id="cnpj" class="form-control" value="<?=$res[0]->cpf_cnpj?>" placeholder="CNPJ Apenas n??meros*">
                        </div>
                        </br>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Empresa</label>
                            <select name="fk_empresa">
                            <option value="">Selecione</option>
                                <?php
                                foreach($list as $item){
                                ?>
                                  <option value="<?=$item->idemp?>" <?=($res[0]->fk_empresa == $item->idemp)?'selected':''?>><?=$item->tipo_empresa.' - '.$item->nome_fantasia?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Tipo Fornecedor*</label>
                            <select name="tipo_fornecedor" >
                            <option value="" disabled selected>Selecione</option>
                                <option value="PF" selected="<?=($res[0]->tipo_fornecedor == 'PF')?'true':'false'?>">Pessoa F??sica</option>
                                <option value="PJ" selected="<?=($res[0]->tipo_fornecedor == 'PJ')?'true':'false'?>">Pessoa Jur??dica</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" name="fornecedor" class="form-control" value="<?=$res[0]->fornecedor?>" placeholder="Fornecedor*">
                        </div>
                        </br>
                        <div class="form-group">
                            <input type="text" name="nome_fantasia" class="form-control" value="<?=$res[0]->nome_fantasia?>" placeholder="Nome Fantasia*">
                        </div>
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">Endere??o</label> -->
                            <input type="text" name="endereco" id="message" value="<?=$res[0]->endereco?>" class="form-control" placeholder="Endere??o*" >
                        </div> 
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">PIS</label> -->
                            <input type="text" name="complemento" id="message"  value="<?=$res[0]->complemento?>" class="form-control" placeholder="Complemento">
                        </div> 
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">COFINS</label> -->
                            <input type="text" name="bairro" id="message" value="<?=$res[0]->bairro?>" class="form-control"  placeholder="Bairro*">
                        </div> 
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">CSLL</label> -->
                            <input type="text" name="cep" id="cep" class="form-control" value="<?=$res[0]->cep?>" placeholder="CEP*">
                        </div> 
                        <div class="form-group">
                            <label style="float: left; margin-left: 2%;">Estado(UF)*</label>
                            <select name="uf" id="estados" >
                                <option value="" selected="true">Selecione</option>
                                <?php foreach($estados as $uf){ ?>
                                    <option value="<?=$uf->sigl_estado?>" <?=($res[0]->uf)?'selected':''?>><?=$uf->sigl_estado.' - '.$uf->dsc_estado?></option>
                                <?php } ?>
                            </select>
                        </div> 
                        <div class="form-group">
                        <label style="float: left; margin-left: 2%;">Cidade*</label>
                        <select name="cidade" id="cod_cidades" >
                            <option value="<?=$res[0]->cidade?>"><?=$res[0]->cidade?></option>
                        </select>
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="fone" id="telefone" value="<?=$res[0]->fone?>" class="form-control"  placeholder="Telefone*">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="fax" id="fax" class="form-control" value="<?=$res[0]->fax?>" placeholder="Fax">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="email" id="message" class="form-control" value="<?=$res[0]->email?>" placeholder="Email">
                        </div>  
                        <div class="form-group">
                        <!-- <label style="float: left; margin-left: 2%;">ISS</label> -->
                            <input type="text" name="site" id="message" class="form-control" value="<?=$res[0]->site?>" placeholder="Site">
                        </div>                       
                        <input type="hidden" name="idforn" value="<?=$res[0]->idforn?>"/>                    
                        <div class="form-group">
                            <a class="btn btn-info" href="javascript:location.href = 'busca_forn.php'">Voltar</a>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Aten????o!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja apagar esse registro!?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
					<p class="pull-left">Copyright ?? 2021 Parkfor. Todos os diretos reservados.</p>
					
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
            $('#estados').change(function(){
                if( $(this).val() ) {
                $('#cod_cidades').hide();
                $('.carregando').show();
                $.getJSON(
                    'includes/api.php?action=8&uf=',
                    {
                    uf: $(this).val(),
                    ajax: 'true'
                    }, function(j){
                    var options = '<option value="">Selecione</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' +
                        j[i].dsc_cidade + '">' +
                        j[i].dsc_cidade + '</option>';
                    }
                    $('#cod_cidades').html(options).show();
                    $('.carregando').hide();
                    });
                } else {
                $('#cod_cidades').html(
                    '<option value="">-- Escolha um estado --</option>'
                );
                }
            });
        });
     
		$("#telefone, #fax").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");

        $("#cnpj").on('blur',function(){
            
            cnpj = $("#cnpj").val();
            console.log(cnpj)
            cnpj = cnpj.replace(/[^\d]+/g,'');
            //$("#erro").html('V??lido');

            if(cnpj == ''){
                $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                $("#erro").html("Cnpj N??o pode ser vazio!");
                $("#cnpj").focus()
                return false;
            }else{
                $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                $("#erro").html('V??lido');
            }
            
            if (cnpj.length != 14){
                $('#erro').removeClass('cnpj_verde').addClass('cnpj_vermelho')
                $("#erro").html("Cnpj com tamanho inv??lido!");
                $("#cnpj").focus()
                return false;
            }else{
                $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                $("#erro").html('V??lido');
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
                    $("#erro").html("Cnpj com padr??o inv??lido!");
                    $("#cnpj").focus()
                    return false;
                }else{
                    $('#erro').removeClass('cnpj_vermelho').addClass('cnpj_verde')
                    $("#erro").html('V??lido');
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
                $("#erro").html('V??lido');
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
                $("#erro").html('V??lido');
            }
                    
            return true;
        })
	
    </script>
</body>
</html>