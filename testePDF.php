<?php  
session_start();
ob_start(); ?>
<table>
    <tr>
    <td>Trestanto</td>
    <td>Mais um PDF</td>
    </tr>
</table>
<?php
require_once dirname(__FILE__).'/vendor/autoload.php';

// use Spipu\Html2Pdf\Html2Pdf;
// use Spipu\Html2Pdf\Exception\Html2PdfException;
// use Spipu\Html2Pdf\Exception\ExceptionFormatter;

use Dompdf\Dompdf;
use Dompdf\Options;

try {
   
    //include dirname(__FILE__).'/testePDF.php';
    $content = ob_get_clean();

    // $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', 0);
    // $html2pdf->writeHTML($content);
    // $html2pdf->output('example08.pdf');

    $options = new Options();
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(true);
      
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('tabloid','landscape');
        
        $dompdf->loadHtml($content);
        $dompdf->render();
        //echo $content;
        header('Content-type: Application/pdf');
        echo $dompdf->output();
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}

?>