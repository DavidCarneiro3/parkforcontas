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
    <div class="container text-left">
        <?php include("includes/menu.php"); ?>
    <div class="col-sm-9">
            <div class="contact-form">
                <h2 class="title text-center">Relatório Faturamento</h2>
                <div class="status alert alert-success" style="display: none"></div>
                <form id="main-contact-form" action="faturamento_imp.php" target="_blank" class="contact-form row text-left" name="contact-form" method="post">
                   
                        
                            <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Empresa</label>
                                    <div class="col-sm-10">
                                        <select name="empresa"  class="form-control" id="empresa">
                                        <div class="col-sm-10">
                                            <option value=""  >Selecione</option>
                                                <?php
                                                foreach($emp as $item){
                                                  
                                                ?>
                                                <option value="<?=$item->idemp?>" <?= ($_POST['empresa'] && $_POST['empresa'] == $item->idemp)? 'selected':'';?> ><?=$item->tipo_empresa?> - <?=$item->nome_fantasia?></option>
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
                                    <label class="col-sm-2 col-form-label">Forma de Recebimento</label>
                                    <div class="col-sm-10">
                                        <select name="frm_pag" id="recebimento" class="form-control">
                                        <option value="" selected>Selecione</option>
                                        <?php
                                            // foreach($frmpag as $item){
                                            ?>
                                            <!-- <option value="<?=$item->pagamento?>"><?=$item->pagamento?></option> -->
                                            <?php 
                                            // }
                                            ?>
                                        </select>
                                        <div id="carregando-rec" style="display:none">Carregando...</div>
                                    </div>
                                    
                                </div>
                           
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Status Recebimento</label>
                                        <div class="col-sm-10">
                                            <select name="status_pag"  class="form-control">
                                                <option options="">Selecione</option>
                                                <option options="ABERTO">ABERTO</option>
                                                <option options="ATRASADO">ATRASADO</option>
                                                <option options="CANCELADO">CANCELADO</option>
                                                <option options="PAGO">PAGO</option>
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
            
          ['Recebimento', 'Valor Documento','Desconto', 'Multa', 'Valor Recebido','Valor Extra','Valor Fatura','Valor Retido' , 'Valor Serviço'],
          <?php 
             if($res_rec){
            foreach($res_rec as $item){ ?>
          ['<?=$item->recebimento?>', <?=($item->val_doc)?>,<?=($item->vr_desc)?>,<?=($item->mult)?>,<?=($item->vr_pag)?>,<?=($item->vr_extra)?>,<?=($item->vr_fat)?>,<?=($item->vr_ret)?>,<?=($item->vr_serv)?>],
          <?php 
          $soma_res_rec += $item->val_doc;
          }
          ?>
          
          <?php
          
             }

             $soma_res_rec_abe = $res_rec_abe[0]->val_doc;
          ?>
          ['<?=$res_rec_abe[0]->recebimento?>', <?=($res_rec_abe[0]->val_doc)?>,<?=($res_rec_abe[0]->vr_desc)?$res_rec_abe[0]->vr_desc:0?>,<?=($res_rec_abe[0]->mult)?$res_rec_abe[0]->mult:0?>,<?=($res_rec_abe[0]->vr_pag)?$res_rec_abe[0]->vr_pag:0?>,<?=($res_rec_abe[0]->vr_extra)?>,<?=($res_rec_abe[0]->vr_fat)?>,<?=($res_rec_abe[0]->vr_ret)?>,<?=($res_rec_abe[0]->vr_serv)?>],
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
                        5,
                        { calc: "stringify",
                         sourceColumn: 5,
                         type: "string",
                         role: "annotation" 
                        },
                        6,
                        { calc: "stringify",
                         sourceColumn: 6,
                         type: "string",
                         role: "annotation" 
                        },
                        7,
                        { calc: "stringify",
                         sourceColumn: 7,
                         type: "string",
                         role: "annotation" 
                        },
                        8,
                        { calc: "stringify",
                         sourceColumn: 8,
                         type: "string",
                         role: "annotation" 
                        },
                       ]);

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