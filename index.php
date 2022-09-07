<!DOCTYPE html>
<?php 
session_start();
//echo $_SESSION['id'];
date_default_timezone_set('America/Sao_Paulo');

include("includes/conexao.php");
include("includes/funcoes.php");
include("includes/control.php");
include("includes/load.php");
include("consulta_boleto.php");
if(!$_SESSION['id']){
	echo $_SESSION['id'];
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

	</header>
	<!--/header-->
	<?php
	// ATT STATUS CNT PAG
	// $par = ['action' => '62'];
	// $res = loadApi($par);
	//print_r($res);
	//echo '</br>';
	// ATT STATUS CNT REC
	// $params = ['action' => '63'];
	// $resu = loadApi($params);
	//print_r($resu);
	?>
	<!--slider-->
	<!-- <section id="slider">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free E-Commerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="images/home/girl1.jpg" class="girl img-responsive" alt="" />
									<img src="images/home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>
							
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section> -->
	<!--/slider-->
	
	<section id="prin-section">
		<div class="container">
			<div class="row">
			<?php include("includes/menu.php"); 
			$data = date("2022-04-25");
			$dias = 5;
			$novadata = date('Y-m-d', strtotime("+{$dias} days",strtotime($data)));

			$par = ['dt_vencimento_ini' => $data, 'dt_vencimento_fin' => $novadata];
			// $result = json_decode(listaContaReceberBoleto($par));
			// $itens = $result->datas;
			// print_r($result);
			$itens = false;
			
			?>
				
				<!--recommended_items-->
				<?php if($itens){ 
					
					
				?>
				<div class="recommended_items">
						<h2 class="title text-center">Boletos a Vencer</h2>
						<div class="bol-area">
							<table class="table table-bordered">
								<tr>
									<th>Empresa</th>
									<th>Cliente</th>
									<th>Número Boleto</th>
									<th>Valor</th>
									<th>Vencimento</th>
									<th>Status</th>
									<th>Ação</th>
								</tr>
								<?php foreach($itens as $item){ 
									$parameters = ['nosso_num' => $item->num_bol, 'convenio' => $item->convenio];
									$res_bol = json_decode(consultaBol($parameters));
									// print_r($res_bol);
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
								<tr>
									<td><?=$item->empresa?></td>
									<td><?=$item->cliente?></td>
									<td><?=$item->num_bol?></td>
									<td><?=$item->val_servico?></td>
									<td><?=recebedata($item->venc_boleto)?></td>
									<td><?=$res_bol->codigoEstadoTituloCobranca?></td>
									<td><a href="detalhe_boleto.php?convenio=<?=$item->convenio?>&num_bol=<?=$item->num_bol?>" target="_blank" title="Detalhes do Boleto"><i class="fa fa-search" aria-hidden="true"></i></a></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						
					</div>
					<?php } ?>
					<!--/recommended_items-->
					<!--features_items-->
				
						<?php if($_SESSION['grupo'] == 10 || $_SESSION['grupo'] == 11){ ?>
						<h2 class="title text-center">Gráficos Gerenciais</h2>
						<div class="col-lg-9">
						<div id="ano" style="width: 100%; height: 500px;"></div>
						</div>
						<div class="col-lg-12">
						<div id="empresas" style="width: 100%; height: 600px;"></div>
						</div>
						<div class="col-lg-12">
						<div id="empresasanterior" style="width: 100%; height: 600px;"></div>
						</div>
						<div class="col-lg-12">
						<div id="empresasvigente" style="width: 100%; height: 600px;"></div>
						</div>
						<div class="col-lg-4">
						<div id="formarec" style="width: 100%; height: 500px;"></div>
						</div>
						<div class="col-lg-4">
						<div id="formapag" style="width: 100%; height: 500px;"></div>
						</div>
						
						<?php } ?>
						
					<!--features_items end-->
					
					
					
				
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		
		
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
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/jquery.nicescroll.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script>

  

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
		  $grap_res = array();
		  $graph_rec_abe = array();
		  $graph_rec_tmp = array();
      
	$params = [
		'dt_vencimento_ini' => enviadata($dt1),
		'dt_vencimento_fin' => enviadata($dt2),
		// 'status_pag' => 'PAGO',
		'excluida' => 'não'
		
	];
	
        
		//$graph_rec_tmp = json_decode(grapRelCntRecFrmRec($params));
        $graph_rel = json_decode(graphFinEmpresa($params));
        //print_r($graph_rel);
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
		  format: 'none',
          hAxis: {title: 'Mês'},
	      format: 'none',
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
            
          ['Empresa', 'Saídas','Entradas', 'Lucro/Prejuízo'],
          <?php 
		  $params = [
			'dt_vencimento_ini' => date("Y-01-01"),
			'dt_vencimento_fin' => date("Y-m-d"),
			// 'status_pag' => 'PAGO',
			'excluida' => 'não'
			
		];
		  $res_graph = json_decode(graphFinEmpresa($params));
		  //print_r($res_graph);
		  $grap_res_fin = $res_graph->datas;

            foreach($grap_res_fin as $item){ ?>
          ['<?=substr($item->empresa,0,14)?>', <?=($item->val_doc_pag)?>,<?=($item->val_doc_rec)?>,<?=($item->val_doc_rec > 0)?($item->val_doc_rec-$item->val_doc_pag):0?>],
          <?php }
          ?>
        ]);

        var options = {
			// chartArea: {width: '60%'},
			bar: {groupWidth: "55%"},
          	title: 'Saidas e entradas por empresa desde o início do ano',
		  	animation: {
			  startup: true,
			  duration: 1000,
        	  easing: 'out',
			},
		  //bar: { groupWidth: '75%' },
          isStacked: true,
		  colors: ['#d9534f', '#268ac1', '#fac30f'],
		  legend: 'none',
		  
        };

        var chart = new google.visualization.BarChart(document.getElementById('empresas'));

        chart.draw(data, options);
      }
      
    </script>

<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Empresa', 'Saídas','Entradas', 'Lucro/Prejuízo'],
          <?php 
		  $dia_tmp = date("m");
		   $dia = $dia_tmp - 1;
		  if($dia < 10){
			  $dia = "0".$dia;
		  }
		  
		  $dtm1 = "01/".$dia."/".date("Y"); 
          $dtm2 = ultimo_dia_mes($dia)."/".$dia."/".date("Y");
		  $paramsa = [
			'dt_vencimento_ini' => enviadata($dtm1),
			'dt_vencimento_fin' => enviadata($dtm2),
			// 'status_pag' => 'PAGO',
			'excluida' => 'não'
			
		];
		  $res_grapha = json_decode(graphFinEmpresa($paramsa));
		  //print_r($res_grapha);
		  $grap_res_fina = $res_grapha->datas;

            foreach($grap_res_fina as $item){ ?>
          ['<?=substr($item->empresa,0,14)?>', <?=($item->val_doc_pag)?>,<?=($item->val_doc_rec)?>,<?=($item->val_doc_rec > 0)?($item->val_doc_rec-$item->val_doc_pag):0?>],
          <?php }
          ?>
        ]);

        var options = {
			// chartArea: {width: '60%'},
			bar: {groupWidth: "55%"},
          	title: 'Saidas e entradas por empresa mês <?=dia_do_mes($dia)?>',
		  	animation: {
			  startup: true,
			  duration: 1000,
        	  easing: 'out',
			},
		  //bar: { groupWidth: '75%' },
          isStacked: true,
		  colors: ['#d9534f', '#268ac1', '#fac30f'],
		  legend: 'none',
		  
        };

        var chart = new google.visualization.BarChart(document.getElementById('empresasanterior'));

        chart.draw(data, options);
      }
      
    </script>

<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Empresa', 'Saídas','Entradas', 'Lucro/Prejuízo'],
          <?php 
		  $params = [
			'dt_vencimento_ini' => date("Y-m-01"),
			'dt_vencimento_fin' => date("Y-m-d"),
			// 'status_pag' => 'PAGO',
			'excluida' => 'não'
			
		];
		  $res_graph = json_decode(graphFinEmpresa($params));
		  //print_r($res_graph);
		  $grap_res_fin = $res_graph->datas;

            foreach($grap_res_fin as $item){ ?>
          ['<?=substr($item->empresa,0,14)?>', <?=($item->val_doc_pag)?>,<?=($item->val_doc_rec)?>,<?=($item->val_doc_rec > 0)?($item->val_doc_rec-$item->val_doc_pag):0?>],
          <?php }
          ?>
        ]);

        var options = {
			// chartArea: {width: '60%'},
			bar: {groupWidth: "55%"},
          	title: 'Saidas e entradas por empresa mês <?=dia_do_mes(date("m"))?>',
		  	animation: {
			  startup: true,
			  duration: 1000,
        	  easing: 'out',
			},
		  //bar: { groupWidth: '75%' },
          isStacked: true,
		  colors: ['#d9534f', '#268ac1', '#fac30f'],
		  legend: 'none',
		  
        };

        var chart = new google.visualization.BarChart(document.getElementById('empresasvigente'));

        chart.draw(data, options);
      }
      
    </script>

<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Forma de pagamento', 'Quantidade'],
          <?php 
		  $params = [
			'dt_vencimento_ini' => date("Y-01-01"),
			'dt_vencimento_fin' => date("Y-m-d"),
			// 'status_pag' => 'PAGO',
			'excluida' => 'não'
			
		];
		  $res_graph_pie = json_decode(graphPieFrmRec($params));
		  //print_r($res_graph_pie);
		  $grap_res_fin_pie = $res_graph_pie->datas;

            foreach($grap_res_fin_pie as $item_pie){ ?>
          ['<?=$item_pie->recebimento?>', <?=($item_pie->qtd)?>],
          <?php }
          ?>
        ]);

        var options = {
          title: 'Entradas por forma de recebimento desde o início do ano',
		  pieStartAngle: 0,
          isStacked: true,
		  pieHole: 0.4,
		  legend: 'none',
		  
		  
        };

        var chart = new google.visualization.PieChart(document.getElementById('formarec'));
		google.visualization.events.addListener(chart, 'ready', function () {
			if (options.pieStartAngle < 160) {
			options.pieStartAngle++;
			setTimeout(function () {
				chart.draw(data, options);
			}, 1);
			}
		});
        chart.draw(data, options);
      }
      
    </script>
	<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart'],'language': 'pt'});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       

        var data = google.visualization.arrayToDataTable([
            
          ['Forma de pagamento', 'Quantidade'],
          <?php 
		  $params = [
			'dt_vencimento_ini' => date("Y-01-01"),
			'dt_vencimento_fin' => date("Y-m-d"),
			// 'status_pag' => 'PAGO',
			'excluida' => 'não'
			
		];
		  $res_graph_pie_pag = json_decode(graphPieFrmPag($params));
		  //print_r($res_graph_pie_pag);
		  $grap_res_fin_pie_pag = $res_graph_pie_pag->datas;

            foreach($grap_res_fin_pie_pag as $item_pie_pag){ ?>
          ['<?=$item_pie_pag->pagamento?>', <?=($item_pie_pag->qtd)?>],
          <?php }
          ?>
        ]);

        var options = {
          title: 'Saídas por forma de pagamento desde o início do ano',
		  pieStartAngle: 0,
		  pieHole: 0.4,
		  legend: 'none',
		  
		  
        };

        var chart = new google.visualization.PieChart(document.getElementById('formapag'));
		google.visualization.events.addListener(chart, 'ready', function () {
			if (options.pieStartAngle < 180) {
			options.pieStartAngle++;
			setTimeout(function () {
				chart.draw(data, options);
			}, 1);
			}
		});
        chart.draw(data, options);
      }
      
    </script>
</body>
</html>