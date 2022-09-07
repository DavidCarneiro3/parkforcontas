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
   
    <?php
   

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
        // print_r($result);
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
        // print_r($res_graph);
        if($res_graph->result == "sucess"){
            $grap_res = $res_graph->datas;
        }else{
            echo '<script>alert("' . $res_graph->error . '")</script>';
        }

        $resumo = json_decode(relContaPagarRes($params));
        // print_r($res_graph);
        if($resumo->result == "sucess"){
            $resum = $resumo->datas;
        }

        $graph_rec_tmp = json_decode(grapRelCntRecFrmRec($params));
        $graph_rec_abe = json_decode(grapRelCntRec($params));
        // print_r($graph_rec_abe);
        $res_rec_abe = $graph_rec_abe->datas;
        // print_r($res_rec_abe);
        $res_rec = $graph_rec_tmp->datas;
        // print_r($res_rec);

        $soma_res_rec = 0;
        $soma_res_rec_abe = 0;
    
    if ($list) { ?>
        <div class="container">
            <div class="row">
                
                <h2 class="title text-center">Resultado da Busca</h2>
                <div class="cabecalho">
                <h4> Empresa: <?=$l_emp[0]->nome_fantasia?> </h4>
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
                    <h4 style="color: #ccc;">Contas a Pagar por Centro de Custos</h4>
                        <table class="table cell-border"> 
                            <thead>
                                <tr style="color: #000; background-color: #ccc; text-align:center;">
                                    
                                    
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
                                    <td colspan="1"><b>Total</b></td>

                                    <td><b><?= number_format($resum[0]->val_doc, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($resum[0]->vr_desc, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($resum[0]->multa, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($resum[0]->vr_pag, 2, ',', '.') ?></b></td>
                                    <td><b><?= number_format($somavalaberto, 2, ',', '.') ?></b></td>
                                    <td></td>
                                </tr>
                            </tfoot>

                        </table>
                    <!-- <button type="button" class="btn btn-primary" id="authallbtn" data-toggle="modal" data-target="#authall">Autorizar Selecionados</button>
            <button type="button" id="pagallbtn" class="btn btn-success">Quitar Selecionados</button>
            <button type="button"id="unauthallbtn" class="btn btn-danger">Desautorizar Selecionados</button> -->
                    </form>



                    <br />
            </div>
            <h2 class="title text-center">Gráficos Gerenciais</h2>
            <div id="ano" style="width: 100%; height: 500px;"></div>
            <div id="grapcntpagfrmpag" style="width: 100%; height: 500px;"></div>
            <div id="grapcntrecfrmrec" style="width: 100%; height: 500px;"></div>
            <div id="resumo" style="width: 100%; height: 500px;"></div>
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
            $('#empresa').on('change',function(){
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
                        console.log('Fornecedores',j)
                        let values = JSON.parse(j);
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
                                '<option value="">-- Selecione uma empresa --</option>'
                            ).show();
                            $('#carregando-cent').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#centro').html(
                            '<option value="">-- Selecione uma empresa --</option>'
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
                                '<option value="">-- Selecione uma empresa --</option>'
                            ).show();
                            $('#carregando-rec').hide();
                        }
                        

                    },
                    error: function(e){
                        $('#recebimento').html(
                            '<option value="">-- Selecione uma empresa --</option>'
                        ).show();
                        $('#carregando-rec').hide();
                    }
                })
                }
            })

            //$("#ordena").tablesorter({ sortList: [[0,0], [1,0]] });
            
        });
    </script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawVisualization);
      function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
			['Mês','Saidas', 'Entradas','Lucro/Prejuízo'],
      <?php 
        $i = 1;
        while($i <= 12){
          if($i>9){
            $dt1 = "01/".$i."/".date("Y");
            $dt2 = ultimo_dia_mes($i)."/".$i."/".date("Y");
          }else{
            $dt1 = "01/0".$i."/".date("Y"); 
            $dt2 = ultimo_dia_mes($i)."/0".$i."/".date("Y");
          }
		  $res_graph = array();
		  $resumo = array();
		//   $grap_res = array();
		  $graph_rec_abe = array();
		  $graph_rec_tmp = array();
      
	$params = [
		'dt_vencimento_ini' => enviadata($dt1),
		'dt_vencimento_fin' => enviadata($dt2),
		// 'status_pag' => 'PAGO',
        'empresa' => $_POST['empresa'],
		'excluida' => 'não'
		
	];
	
        
		//$graph_rec_tmp = json_decode(grapRelCntRecFrmRec($params));
        $graph_rel = json_decode(graphEmpresa($params));
        
        // print_r($graph_rel);
        $res_graph_fin = $graph_rel->datas;
        //print_r($res_graph_fin);
        //$res_rec = $graph_rec_tmp->datas;
        // print_r($res_rec);
        
        $soma_res_rec = 0;
        $soma_res_pag = 0;
		if($res_graph_fin[0]->val_doc_pag && $res_graph_fin[0]->val_doc_rec){
			foreach($res_graph_fin as $item_fin){ 
				$soma_res_rec += $item_fin->val_doc_rec;
				$soma_res_pag += $item_fin->val_doc_pag;
			}
		}
    	
        
		$soma_res_rec_abe = $soma_res_rec;
		$val_doc_pag = $soma_res_pag;

          ?>
          
          
          ['<?=(nome_do_mes($i))?>', <?=$val_doc_pag?>,<?=($soma_res_rec_abe)?$soma_res_rec_abe:0?>,<?=($soma_res_rec_abe)?($soma_res_rec_abe - $val_doc_pag):0?>],        
    <?php  
            $i++;
        } ?>
        ]);

        var options = {
          title : 'Demonstrativo anual',
          widith: 1000,
		  format: 'currency',
          hAxis: {title: 'Mês'},
          seriesType: 'bars',
          series: {2: {type: 'line'}},
		  colors: ['#d9534f', '#268ac1', '#fac30f'],
		  animation: {
			  startup: true,
			  duration: 1000,
        	  easing: 'out',
			},
			//series: {2: {type: 'line'}}
			// legend: 'none',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('ano'));

        chart.draw(data,options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Pagamento', 'Valor Documento','Valor Pago','Valor Desconto', 'Valor Juros','Valor Em Aberto'],
          <?php 
          
            foreach($grap_res as $item){ ?>
          ['<?=$item->pagamento?>', <?=($item->val_doc)?>,<?=($item->vr_pag)?>,<?=$item->vr_desc?>,<?=$item->mult?>,<?=($item->val_doc-$item->vr_pag)>0?$item->val_doc-$item->vr_pag:0?>],
          <?php }
          ?>
        ]);
        var view = new google.visualization.DataView(data);
        // view.setColumns([0,1,
        //                { calc: "stringify",
        //                  sourceColumn: 1,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 2,
        //                 { calc: "stringify",
        //                  sourceColumn: 2,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                ]);

        var options = {
          title: 'Contas a pagar por forma de pagamento'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('grapcntpagfrmpag'));

        chart.draw(view, options);
      }
      
    </script>
    
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Recebimento', 'Valor Documento', 'Valor Recebido'],
          <?php 
             if($res_rec[0]->vr_pag > 0){
            foreach($res_rec as $item){ ?>
          ['<?=$item->recebimento?>', <?=($item->val_doc)?>,<?=($item->vr_pag)?>],
          <?php 
          $soma_res_rec += $item->val_doc;
          }
          ?>
          
          <?php
          
             }

             $soma_res_rec_abe = $res_rec_abe[0]->val_doc;
          ?>
          ['<?=$res_rec_abe[0]->recebimento?>', <?=($res_rec_abe[0]->val_doc)?>,<?=($res_rec_abe[0]->vr_pag)?$res_rec_abe[0]->vr_pag:0?>],
        ]);
        var view = new google.visualization.DataView(data);
        // view.setColumns([0,1,
        //                { calc: "stringify",
        //                  sourceColumn: 1,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 2,
        //                 { calc: "stringify",
        //                  sourceColumn: 2,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 3,
        //                 { calc: "stringify",
        //                  sourceColumn: 3,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 4,
        //                 { calc: "stringify",
        //                  sourceColumn: 4,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 5,
        //                 { calc: "stringify",
        //                  sourceColumn: 5,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 6,
        //                 { calc: "stringify",
        //                  sourceColumn: 6,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 7,
        //                 { calc: "stringify",
        //                  sourceColumn: 7,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                 8,
        //                 { calc: "stringify",
        //                  sourceColumn: 8,
        //                  type: "string",
        //                  role: "annotation" 
        //                 },
        //                ]);

        var options = {
          title: 'Contas a receber por forma de pagamento'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('grapcntrecfrmrec'));

        chart.draw(view, options);
      }
      
    </script>
     <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Movimento', 'Valor', { role: 'style' }],
          
          ['Saídas', <?=$resum[0]->val_doc?>,'#d9534f'],
          ['Entradas', <?=($soma_res_rec+$soma_res_rec_abe)?>,'#0083C9'],
          ['Lucro/Prejuízo', <?=(($soma_res_rec+$soma_res_rec_abe) - $resum[0]->val_doc)?>,'#7ebf97']
          
        ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0,1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" 
                        },
                        2,
                       ]);

        var options = {
          title: 'Resumo Financeiro'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('resumo'));

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