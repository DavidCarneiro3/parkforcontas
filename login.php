<!DOCTYPE html>
<?php 
session_start();
// echo '['.$_SESSION['teste'].']';
// echo '['.$_SESSION['id'].']';
date_default_timezone_set('America/Sao_Paulo');
include("includes/control.php");
include("includes/conexao.php");

if(@$_SESSION['id']){
  echo "<script>location.href='index.php';</script>";
  //echo $_SESSION['teste'];
}

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login | Parkfor</title>
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
    <link rel="shortcut icon" href="images/icon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<?php 
        // if($_POST['entrar']){
		// 	//session_start();
        //   if($_POST['user'] && $_POST['pass']){
        //     $params = [
        //       'user'=>$_POST['user'],
        //       'pass'=>$_POST['pass'],
        //       'action'=>'1'
        //     ];

        //     $result = loadApi($params);
		// 	//print_r($result);
        //     if ($result->result === "sucess") {
        //       //print_r(json_encode($result->datas));
		// 	  $var = $result->datas;
		// 	  //print_r($var);
		// 	  //echo $var->access;
			  
        //       if($_SESSION['id']){
		// 		//echo '<script>location.href="index.php"</script>';
		// 	  }else{
		// 		echo '<script>alert("Não há sessão ativa para esse usuário!");</script>';
		// 	  }
              
        //     }
            
        //   }
          
        // }
        
      ?>
		
		<!--header-middle-->
<div class="header-middle">
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/logo.png" width="60%" alt="" /></a>
						</div>
						
					</div>
					<div class="col-md-8 clearfix">
					
					</div>
				</div>
			</div>
		</div><!--/header-middle
	
		<div class="header-bottom"> header-bottom-->
			<!-- <div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
								<li class="dropdown"><a href="#">Empresas<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Products</a></li>
										<li><a href="product-details.html">Product Details</a></li> 
										<li><a href="checkout.html">Checkout</a></li> 
										<li><a href="cart.html">Cart</a></li> 
										<li><a href="login.html" class="active">Login</a></li> 
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Fornecedores<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="insert_forne.php">Inserir</a></li>
										<li><a href="busca_forn.php">Consultar/Editar</a></li>
                                    </ul>
                                </li> 
								<li><a href="Clientes.html">Clientes</a></li>
								<li><a href="contact-us.html">Contact</a></li>
							</ul>
						</div>
					</div>
				
				</div>
			</div> -->
		</div>
<!--/header-bottom-->
	</header><!--/header-->
<br />
	
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Faça login para acessar o sistema</h2>
						<form action="login.php" method="post">
							<input type="text" placeholder="Usuário" name="user"/>
							<input type="password" placeholder="Senha" name="pass"/>
							
							<button type="submit" class="btn btn-default" name="entrar" value="Entrar">Login</button>
						</form>
						<?php
							if($_POST['entrar']){
								$user = $_POST['user'];
								$pass = $_POST['pass'];
								$query = $mysqli->query("SELECT * FROM usuarios WHERE user = '".$user."'");
								$rows = $query->num_rows;
								if($rows < 1){
								echo "<script>alert('Usuário não encontrado!')</script>";
								}else{
									$res = $query->fetch_array();
									if($res['pass'] != md5($pass)){
										echo "<script>alert('Senha incorreta!')</script>";
										
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
										$_SESSION["grupo"] = $res['fk_grupo'];
										$_SESSION["tipo"] = $tip;
										$_SESSION["id"] = $res['iduser'];
										$_SESSION["nivel"] = $res['acces'];
										echo "<script>location.href='index.php';</script>";
									}
								}
							}
							
						?>
					</div><!--/login form-->
				</div>
				
				
			</div>
		</div>
	</section><!--/form-->
	
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
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>