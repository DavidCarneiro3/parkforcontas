<?php
session_start();
unset($_SESSION['usuario']);
unset($_SESSION['senha']);
unset($_SESSION['id']);
unset($_SESSION['teste']);
session_destroy();
header("location:login.php");
?>