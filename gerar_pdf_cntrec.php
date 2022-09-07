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
date_default_timezone_set('America/Sao_Paulo');
require_once 'vendor/autoload.php';
include("includes/funcoes.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$list = $_SESSION['list'];

if($list){ ?>
    <table class="table cell-border" id="mytable">
                    <thead>
                        <tr style="color: #000; background-color: #ccc; text-align:center;">
                       
                            
                            <th>Empresa</th>
                            <th>Cliente</th>
                            <th>Centro de Custo</th>
                            <th>Nr. Documento</th>
                            <th>Dt. Documento</th>
                            <th>Valor</th>
                            <th>Parcela</th>
                            <th>Vr. Retroativo</th>
                            <th>Vr. Extra</th>
                            <th>Vr. Fatura</th>
                            <th>Vr. Pis</th>
                            <th>Vr. COFINS</th>
                            <th>Vr. IRRF</th>
                            <th>Vr. CSLL</th>
                            <th>Vr. INSS</th>
                            <th>Vr. ISS</th>
                            <th>Reter ISS</th>
                            <th>Vr. Documento</th>
                            <th>Dt. Vencimento</th>
                            <th>Descrição</th>
                            <th>Observação</th>
                            <th>Status</th>
                            <th>Dt. Recebimento</th>
                            <th>Desconto</th>
                            <th>Mul/Jur/Enc</th>
                            <th>Vr. Recebido</th>
                            <th>Forma Recebimento</th>
                            <th>Obs. Recebimento</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $i = 0;
                            foreach($list as $item){
                                
                                $somaval += $item->val_doc;
                                $somamulta += $item->multa;
                                $somadesc += $item->vr_desc;
                                $somavalpag += $item->vr_pag;
                                $somavalserv += $item->val_servico;
                                $somavalret += $item->val_ret;
                                $somafat += $item->val_fat;
                                $somavalext += $item->val_extra;
                                $somapis += $item->pis;
                                $somacofins += $item->cofins;
                                $somairrf += $item->irrf;
                                $somacsll += $item->csll;
                                $somainss += $item->inss;
                                $somaiss += $item->iss;
                                $array = Array();
                                $array[$item->id_conta] = $item;
                                ?>
                                </td>
                                <tr>
                                    <td><?=$item->empresa?></td>
                                    <td><?=$item->cliente?></td>
                                    <td><?=$item->centro?></td>
                                    <td><?=$item->num_doc?></td>
                                    <td><?=recebedata($item->dt_doc)?></td>
                                    <td><?=number_format($item->val_servico,2,',','.')?></td>
                                    <td><?=$item->parcela?></td>
                                    <td><?=number_format($item->val_ret,2,',','.')?></td>
                                    <td><?=number_format($item->val_extra,2,',','.')?></td>
                                    <td><?=number_format($item->val_fat,2,',','.')?></td>
                                    <td><?=number_format($item->pis,2,',','.')?></td>
                                    <td><?=number_format($item->cofins,2,',','.')?></td>
                                    <td><?=number_format($item->irrf,2,',','.')?></td>
                                    <td><?=number_format($item->csll,2,',','.')?></td>
                                    <td><?=number_format($item->inss,2,',','.')?></td>
                                    <td><?=number_format($item->iss,2,',','.')?></td>
                                    <td><?=$item->reter?></td>
                                    <td><?=number_format($item->val_doc,2,',','.')?></td>
                                    <td><?=recebedata($item->dt_vencimento)?></td>
                                    <td><?=$item->descricao?></td>
                                    <td><?=$item->obs?></td>
                                    <td><?=$item->status?></td>
                                    <td><?=recebedata($item->dt_pag)?></td>
                                    <td><?=number_format($item->desconto,2,',','.')?></td>
                                    <td><?=number_format($item->multa,2,',','.')?></td>
                                    <td><?=number_format($item->vr_pag,2,',','.')?></td>
                                    <td><?=$item->frm_rec?></td>
                                    <td><?=$item->obs_pag?></td>
                                    <!-- Modal -->
                            
                                    
                                </tr>
                            
                            <?php 
                            $i++;
                        } ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color:#5488cc; color:#fff;"><td colspan="5"><b>Total</b></td><td><b><?=number_format($somavalserv,2,',','.')?></b></td><td></td><td><b><?=number_format($somavalret,2,',','.')?></b></td><td><b><?=number_format($somavalext,2,',','.')?></b></td><td><b><?=number_format($somafat,2,',','.')?></b></td><td><b><?=number_format($somapis,2,',','.')?></b></td><td><b><?=number_format($somacofins,2,',','.')?></b></td><td><b><?=number_format($somairrf,2,',','.')?></b></td><td><b><?=number_format($somacsll,2,',','.')?></b></td><td><b><?=number_format($somainss,2,',','.')?></b></td><td><b><?=number_format($somaiss,2,',','.')?></b></td><td></td><td><b><?=number_format($somaval,2,',','.')?></b></td><td></td><td></td><td></td><td></td><td></td><td><b><?=number_format($somadesc,2,',','.')?></b></td><td><b><?=number_format($somamulta,2,',','.')?></b></td><td><b><?=number_format($somavalpag,2,',','.')?></b></td><td></td><td></td><td></td></tr>
                            </tfoot>

                </table>
    
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
        header('Content-type: Application/pdf');
        // echo $dompdf->output();
        $dompdf->stream('contas_receber_'.date('dmYHi').'.pdf');
        unset($_SESSION['list']);
      }catch(Exception $e){
        echo $e;
      }
    
    }else{
        if($_POST['btn']){ ?>
   <div class="text-center">
       <label class="icon-error">:(</label>
       <p class="text-error">Nenhum resultado encontrado na busca</p>
   </div>
    <?php } 
    } ?>
    
    <script src="js/jquery.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> 
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <!-- load jQuery and tablesorter scripts -->
    <script type="text/javascript" src="js/dist/js/jquery-latest.js"></script>
    <script type="text/javascript" src="js/dist/js/jquery.tablesorter.js"></script>
    <script src="js/smartpaginator.js" type="text/javascript"></script>
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    
