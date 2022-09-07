<?php  
$serverName = "localhost"; 
$uid = "sa";   
$pwd = "Valuetech@123";  
$databaseName = "BOTECO DO IMPRENSA"; 

$connectionInfo = array( "UID"=>$uid,                            
                         "PWD"=>$pwd,                            
                         "Database"=>$databaseName); 

try {
$conn = new PDO("dblib:server=$serverName,1433,dbname=BOTECO DO IMPRENSA","sa","Valuetech@123");
} catch (PDOException $e) {
    die ("Erro na conexao com o banco de dados: ".$e->getMessage());
}
?>