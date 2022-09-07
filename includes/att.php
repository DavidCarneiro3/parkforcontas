<?php
date_default_timezone_set('America/Fortaleza');
 include('conexao.php');
 include('funcoes.php');
 $hoje = date("Y-m-d");
 $hora = date("H:i");
 $cons = $mysqli->query("UPDATE registros SET status = 'antigo'");
 if($cons){
     $count = $cons->num_rows;
     if($count > 0){
        $res = 'Sucesso';
     }else{
        $res = 'Erro';

     }
     
 }
 echo $res;
?>