<?php
session_start();
date_default_timezone_set('America/Fortaleza');
 include('conexao.php');
 include('funcoes.php');
 $hoje = date("Y-m-d");
 $hora = date("H:i");
 $tabela = $_POST['tabela'];
 $usuario = $_SESSION['name'];
 $cons = $mysqli->query("SELECT * FROM registros WHERE tabela = '$tabela' AND tipo = 'UPDATE' AND dt_entrada = '$hoje' AND status = 'novo' AND usuario = '$usuario'");
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