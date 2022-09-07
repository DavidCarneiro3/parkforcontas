<?php
    $dir = __DIR__.'/documentos/comprovantes/conta_pagar/';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
    // if ( 0 < $_FILES['file']['error'] ) {
        move_uploaded_file($_FILES['file']['tmp_name'], $dir . $_FILES['file']['name']);
        
    }
    else {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }

?>