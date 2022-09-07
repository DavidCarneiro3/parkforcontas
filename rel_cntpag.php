<!DOCTYPE html>
<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
include("includes/control.php");
include("includes/funcoes.php");
include("includes/load.php");
if ($_SESSION['id'] < 1) {
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


</head>
<!--/head-->

<body>
    <header id="header">
        <!--header-->
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
                                <li><?= $_SESSION['tipo'] ?> : <?= $_SESSION['name'] ?></li>
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
<!--header-bottom-->
        <!-- <div class="header-bottom">
            
            <div class="container">
                <div class="row">
                    <div class="col-sm-20">
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
                                <li class="dropdown"><a href="#"><i class="fa fa-truck" aria-hidden="true"></i> Fornecedores</a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="insert_forne.php">Inserir</a></li>
                                        <li><a href="busca_forn.php">Consultar/Editar</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i>Clientes</a>
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
                                <li><a href="#"><i class="fa fa-money" aria-hidden="true"></i> Contas a Pagar</a>
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
                                <li><a href="#" class="active"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> Relatórios<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="rel_cntrece.php">Contas a Receber</a></li>
                                        <li><a href="rel_cntpag.php">Contas a Pagar</a></li>
                                        <li><a href="faturamento.php">Faturamento</a></li>
                                    </ul>
                                </li>

                                <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> Gerencial</a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="meus_dados.php">Meus Dados</a></li>
                                        <?php if ($_SESSION['nivel'] == 3) { ?>
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
        </div> -->
        <!--/header-bottom-->
    </header>
    <!--/header-->
    <?php

$params = ['action' => '5', 'status' => 'ATIVA'];
$res = json_decode(listaEmpresas($params));

    if($res->result === "sucess"){
        $emp = $res->datas;
        //print_r($emp);
    }else{
        echo '<script>alert('.$res->error.')</script>';
    }

// $paramss = ['action' => '11'];
// $ress = json_decode(listaFornecedor($paramss));

//     if($ress->result === "sucess"){
//         $forn = $ress->datas;
//         //print_r($emp);
//     }else{
//         echo '<script>alert('.$ress->error.')</script>';
//     }

// $parameters = ['action' => '20'];
// $resul = json_decode(listaCentros($parameters));

//     if($resul->result === "sucess"){
//         $centros = $resul->datas;
//         //print_r($emp);
//     }else{
//         echo '<script>alert('.$resul->error.')</script>';
//     }

// $pmts = ['action' => '28'];
// $rst = json_decode(listarFormaPagamento($pmts));

//     if($rst->result === "sucess"){
//         $frmpag = $rst->datas;
//         //print_r($emp);
//     }else{
//         echo '<script>alert('.$rst->error.')</script>';
//     }
    ?>
    <div class="container text-left">
        <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
            <div class="contact-form">
                <h2 class="title text-center">Relatório Contas a Pagar</h2>
                <div class="status alert alert-success" style="display: none"></div>
                <form id="main-contact-form" class="contact-form row text-left" name="contact-form" method="post">
                   
                        
                            <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Empresa</label>
                                    <div class="col-sm-10">
                                        <select name="empresa"  class="form-control" id="empresa">
                                        <div class="col-sm-10">
                                            <option value=""  >Selecione</option>
                                                <?php
                                                foreach($emp as $item){
                                                  
                                                ?>
                                                <option value="<?=$item->idemp?>" <?= ($_POST['empresa'] && $_POST['epresa'] == $item->idemp)? 'selected':'';?>><?=$item->tipo_empresa?> - <?=$item->nome_fantasia?></option>
                                                <?php 
                                                    
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Fornecedor</label>
                                    <div class="col-sm-10">
                                        <select name="fornecedor" id="fornecedor" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                            //foreach($forn as $item){
                                                if($forn){
                                            ?>
                                            <option selected value="<?=$forn[0]->fornecedor?>"><?=$forn[0]->fornecedor?></option>
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
                                            // foreach($centros as $item){
                                            ?>
                                            <!-- <option value="<?=$item->centro?>"><?=$item->centro?></option> -->
                                            <?php 
                                            // }
                                            ?>
                                        </select>
                                        <div id="carregando-cent" style="display:none">Carregando...</div>
                                    </div>
                                </div>
                            
                            <!-- <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Documento</label>
                                <div class="col-sm-10">
                                    <input type="text" name="documento" class="form-control">
                                </div>
                            </div> -->
                            
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
                                    <label class="col-sm-2 col-form-label">Forma de Pagamento</label>
                                    <div class="col-sm-10">
                                        <select name="frm_pag" id="pagamento" class="form-control">
                                        <option value="" selected>Selecione</option>
                                        <?php
                                            // foreach($frmpag as $item){
                                            ?>
                                            <!-- <option value="<?=$item->pagamento?>"><?=$item->pagamento?></option> -->
                                            <?php 
                                            // }
                                            ?>
                                        </select>
                                        <div id="carregando-pag" style="display:none">Carregando...</div>
                                    </div>
                                    
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
                                    <input type="submit" name="btn" class="btn btn-primary" value="Buscar">
                                </div>
                            
                    </form>
            </div>
        </div>


    </div>
    <?php
    if ($_POST['btn']) {

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
            'frm_pag' => $_POST['frm_pag'],
            'descricao' => $_POST['descricao'],
            'excluida' => 'não'
        ];

        //print_r($_POST);

        $result = json_decode(relContaPagar($params));
        //print_r($result);
        if ($result->result === "sucess") {
            $list = $result->datas;
            //print_r($list);
        } else {
            echo '<script>alert("' . $result->msg . '")</script>';
        }

        $par = ['emp' => $_POST['empresa']];
        $list_emp = json_decode(listaEmpresas($par));
        $l_emp = $list_emp->datas;
        //print_r($l_emp);


        $res_graph = json_decode(graphContaPagarFrmPag($params));
        //print_r($res_graph);
        if($res_graph->result == "sucess"){
            $grap_res = $res_graph->datas;
        }else{
            echo '<script>alert("' . $res_graph->error . '")</script>';
        }

        $resumo = json_decode(relContaPagarRes($params));
        //print_r($res_graph);
        if($resumo->result == "sucess"){
            $resum = $resumo->datas;
        }else{
            echo '<script>alert("' . $resum->error . '")</script>';
        }
    }
    if ($list) { ?>
        <div class="container">
            <div class="row">
                
                <h2 class="title text-center">Resultado da Busca</h2>
                <div class="cabecalho">
                <h4>Empresa: <?=$l_emp[0]->nome_fantasia?> </h4>
                <h5>Filtros: 
                <?php 
                if($_POST['centro']){
                    $parc = ['centro' => $_POST['centro']];
                    $consc = json_decode(listaCentros($parc));
                    echo "<p> Centro de Custo: ".$consc[0]->centro."</p>";
                }
                if($_POST['fornecedor']){
                    $parf = ['id_forn' => $_POST['fornecedor']];
                    $consf = json_decode(listaFornecedor($parc));
                    echo "<p>Fornecedor: ".$consf[0]->nome_fantasia."</p>";
                }
                if($_POST['frm_pag']){
                    $parfp = ['idfrmpag' => $_POST['frm_pag']];
                    $consfp = json_decode(listarFormaPagamento($parc));
                    echo "<p>Forma de Pagamento: ".$consfp[0]->pagamento."</p>";
                }
                if($_POST['status']){
                    echo "<p>Status: ".recebedata($_POST['status'])."</p>";
                }
                if($_POST['dt_doc_ini']){
                    echo "<p>Data documento a partir de: ".recebedata($_POST['dt_doc_ini'])."</p>";
                }
                if($_POST['dt_doc_fin']){
                    echo "<p>Data documento até: ".recebedata($_POST['dt_doc_fin'])."</p>";
                }
                
                if($_POST['dt_vencimento_ini']){
                    echo "<p>Data vencimento a partir de: ".recebedata($_POST['dt_vencimento_ini'])."</p>";
                }
                if($_POST['dt_vencimento_fin']){
                    echo "<p>Data vencimento até: ".recebedata($_POST['dt_vencimento_fin'])."</p>";
                }
                if($_POST['dt_pag_ini']){
                    echo "<p>Data pagamento a partir de: ".recebedata($_POST['dt_pag_ini'])."</p>";
                }
                if($_POST['dt_pag_fin']){
                    echo "<p>Data pagamento até: ".recebedata($_POST['dt_pag_fin'])."</p>";
                }
                 ?>   
                </h5>
                </div>
                <br />
                <?php if ($_SESSION['nivel'] > 1) { ?>
                    <form method="post" id="form2" target="blank">

                    <?php } ?>
                    <div id="paginator">
                        <table class="table cell-border" id="mytable"> 
                            <thead>
                                <tr style="color: #000; background-color: #ccc; text-align:center;">
                                    
                                    <th>Empresa</th>
                                    <th>Centro de Custo</th>
                                    <th>Vr. Documento</th>
                                    <th>Desconto</th>
                                    <th>Multa/Juros/Enc</th>
                                    <th>Valor Pago</th>
                                    <th>Valor Aberto</th>
                                    <th>% (Valor Doc.)</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list as $item) {
                                    $somaval += $item->val_doc;
                                    $somamulta += $item->multa;
                                    $somadesc += $item->vr_desc;
                                    $somavalpag += $item->vr_pag;
                                    $somavalaberto += ($item->val_doc - $item->vr_pag);

                                ?>



                                    <tr>

                                        <td><?= $item->empresa ?></td>
                                        <td><?= $item->centro ?></td>
                                        <td><?= number_format($item->val_doc, 2, ',', '.') ?></td>
                                        <td><?= number_format($item->desconto, 2, ',', '.') ?></td>
                                        <td><?= number_format($item->multa, 2, ',', '.') ?></td>
                                        <td><?= number_format($item->vr_pag, 2, ',', '.') ?></td>
                                        <td><?= number_format($item->val_doc-$item->vr_pag, 2, ',', '.') ?></td>
                                        <td align="center"><?=number_format(($item->val_doc*100)/$resum[0]->val_doc,2).'%' ?></td>
                                        <!-- Modal -->


                                    </tr>

                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color:#5488cc; color:#fff;">
                                    <td colspan="2"><b>Total</b></td>

                                    <td><b><?= number_format($resum[0]->val_doc, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($resum[0]->vr_desc, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($resum[0]->multa, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($resum[0]->vr_pag, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($somavalaberto, 2, ',', '.') ?></b></td>
                                    <td></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    <!-- <button type="button" class="btn btn-primary" id="authallbtn" data-toggle="modal" data-target="#authall">Autorizar Selecionados</button>
            <button type="button" id="pagallbtn" class="btn btn-success">Quitar Selecionados</button>
            <button type="button"id="unauthallbtn" class="btn btn-danger">Desautorizar Selecionados</button> -->
                    </form>



                    <br />
            </div>
            <div id="piechart" style="width: 100%; height: 500px;"></div>

        </div>
    <?php } ?>
    <!--Footer-->
    <footer id="footer">
        <!--  -->

        <br />

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2021 Parkfor. Todos os diretos reservados.</p>

                </div>
            </div>
        </div>

    </footer>
   
    <!--/Footer-->
    <script src="js/jquery.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- load jQuery and tablesorter scripts -->
    <!-- <script type="text/javascript" src="js/dist/js/jquery-latest.js"></script> -->
    <!-- <script type="text/javascript" src="js/dist/js/jquery.tablesorter.js"></script> -->
    <!-- <script src="js/smartpaginator.js" type="text/javascript"></script> -->
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>



    <!-- tablesorter widgets (optional) -->
    <!-- <script type="text/javascript" src="js/dist/js/jquery.tablesorter.widgets.js"></script> -->
    <!-- Gráfico de pagamentos por forma de pagamento -->
    <script>
        $(function(){
            $("#fornecedor").change(function(){
                console.log('Fornecedor escolhido',$(this).val());
            })
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

            //$("#ordena").tablesorter({ sortList: [[0,0], [1,0]] });
            
        });
    </script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Pagamento', 'Valor Documento','Desconto', 'Multa', 'Valor Pago'],
          <?php 
          
            foreach($grap_res as $item){ ?>
          ['<?=$item->pagamento?>', <?=($item->val_doc)?>,<?=($item->vr_desc)?>,<?=($item->mult)?>,<?=($item->vr_pag)?>],
          <?php }
          ?>
        ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0,1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" 
                        },
                        2,
                        { calc: "stringify",
                         sourceColumn: 2,
                         type: "string",
                         role: "annotation" 
                        },
                        3,
                        { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" 
                        },
                        4,
                        { calc: "stringify",
                         sourceColumn: 4,
                         type: "string",
                         role: "annotation" 
                        },
                       ]);

        var options = {
          title: '<?=$l_emp[0]->nome_fantasia?>'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));

        chart.draw(view, options);
      }
    </script>
    


    

       
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

       


</body>

</html>