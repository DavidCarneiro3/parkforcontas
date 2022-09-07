<?php 
session_start();
include("includes/conexao.php");
$user = $_POST['user'];
        $pass = $_POST['pass'];
        $query = $mysqli->query("SELECT * FROM usuarios WHERE user = '".$user."'");
        
        if(!$query){
          echo "<script>alert('Usuário não encontrado!')</script>";
          header("location:login.php");
        }else{
            $res = $query->fetch_array();
            if($res['pass'] != md5($pass)){
                $result = array('result' => 'error', 'error' => 'Senha incorreta.', 'msg' => $user);
            }else{
              if($res['acces'] == 1){
                $tip = "Usuário";
              }
              if($res['acces'] == 2){
                $tip = "Administrativo";
              }
              if($res['acces'] == 3){
                $tip = "Gerencial";
              }
              
              $_SESSION["name"] = $res['name'];
              $_SESSION["user"] = $user;
              //$_SESSION["pass"] = $_POST['pass'];
			  $_SESSION["tipo"] = $tip;
              $_SESSION["id"] = $res['iduser'];
			  $_SESSION["nivel"] = $res['acces'];
                
                
            }
            if($_SESSION['id'] > 0){
                header("location:index.php");
            }else{
                echo '<script>alert("Não há sessão ativa para esse usuário!");</script>';
                header("location:login.php");
            }

        }
?>