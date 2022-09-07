<?php ob_start(); ?>
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
            #mytable{
                width: 65%;
            }
            td{
                font-size: 7px;
                word-wrap:break-word;
            }
            th{
                font-size: 10px;
            }
        </style>
<?php 
require_once 'vendor/autoload.php';
include("includes/funcoes.php");

use Dompdf\Dompdf;
use Dompdf\Options;
// $list = unserialize($_POST['dados']);
// $graph = unserialize($_POST['graph']);

$list = $_SESSION['list'];
$graph = $_SESSION['graph'];
if($list && $graph){

?>
<table class="table table-sm" id="mytable">
                    <thead>
                        <tr>
                        
                            <th>Item</th>
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
                                    <td><?=$item->empresa?></td>
                                    <td><?=$item->fornecedor?></td>
                                    <td><?=$item->centro?></td>
                                    <td><?=str_replace(',',' ',$item->num_nota)?></td>
                                    <td><?=$item->num_doc?></td>
                                    <td><?=recebedata($item->dt_doc)?></td>
                                    <td><?=number_format($item->val_doc,2,',','.')?></td>
                                    <td><?=recebedata($item->dt_vencimento)?></td>
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
                                    <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color:#5488cc; color:#fff;"><td colspan="7"><b>Total</b></td><td><b><?=number_format($somaval,2,',','.')?></b></td><td colspan="7"></td><td><b><?=number_format($somadesc,2,',','.')?></b></td><td><b><?=number_format($somamulta,2,',','.')?></b></td><td colspan="2"><b><?=number_format($somavalpag,2,',','.')?></b></td><td></td></tr>
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
                <?php foreach($graph as $item){ ?>
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

    <?php
    $content =  ob_get_clean();
    try{

        $options = new Options();
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(true);
      
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('tabloid','landscape');
        
        $dompdf->loadHtml($content);
        $dompdf->render();
        // echo $content;
        //header('Content-type: Application/pdf');
        //echo $dompdf->output();
        $dompdf->stream('contas_pagar_'.date('dmYHi').'.pdf');
        unset($_SESSION['list']);
        unset($_SESSION['graph']);
      }catch(Exception $e){
        echo $e;
      }
    }else{
        print_r($list);
        echo '<br>';
        echo '---------------------------------------------------------------------------------------------------------';
        echo '<br>';
        print_r($graph);
    }
    ?>
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