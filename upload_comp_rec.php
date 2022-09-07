<?php
    // if ( 0 < $_FILES['file']['error'] ) {
    //     echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    // }
    // else {
    //     move_uploaded_file($_FILES['file']['tmp_name'], 'comprovantes/conta_receber/' . $_FILES['file']['name']);
    // }
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {

        /*Arquivo está sendo enviado para pasta UPLOAD */
        $move_upload_rs = move_uploaded_file($_FILES['file']['tmp_name'], "documentos/comprovantes/conta_receber/" . $_FILES['file']['name']);
        
        if($move_upload_rs){
           die("ok");
        }else{
           die("error");
        }
       
      } else { 
        die("error"); 
      }
?>