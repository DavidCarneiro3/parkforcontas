<meta charset="utf-8">
<?php

//session_start();
date_default_timezone_set('America/Fortaleza');
header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
  header("Content-type: application/json; charset=utf-8");
  header('Content-Type: text/html; charset=utf-8');
ob_clean();
include("conexao.php");
include('funcoes.php');
// session_start();
$action = $_POST['action'];
if(!$_POST['action']){
  $action = $_GET['action'];
}

// ---------------dados para boletos BB------------------------
// sandbox

$ambiente = "sandbox";

if($ambiente == 'sandbox'){
 $clientID = "eyJpZCI6ImYyYjA3NGUtMDI4ZC00OGZiLTk3MjItOGMiLCJjb2RpZ29QdWJsaWNhZG9yIjowLCJjb2RpZ29Tb2Z0d2FyZSI6Mjk0NDEsInNlcXVlbmNpYWxJbnN0YWxhY2FvIjoxfQ";
  
  $client_secret = "eyJpZCI6IjEzZjc0OTctOTVlNy00NTk1LTg0IiwiY29kaWdvUHVibGljYWRvciI6MCwiY29kaWdvU29mdHdhcmUiOjI5NDQxLCJzZXF1ZW5jaWFsSW5zdGFsYWNhbyI6MSwic2VxdWVuY2lhbENyZWRlbmNpYWwiOjEsImFtYmllbnRlIjoiaG9tb2xvZ2FjYW8iLCJpYXQiOjE2NDQ1MDQ0MzcwNjl9";
  
  $app_key = "d27bc77909ffab70136ae17d70050356b9c1a5ba";
  
  $urlToken = 'https://oauth.sandbox.bb.com.br/oauth/token';
  $urls = 'https://api.sandbox.bb.com.br/cobrancas/v2';
  $ambiente = $ambiente;
}else{
  $urlToken = 'https://oauth.bb.com.br/oauth/token';
  $urls = 'https://api.bb.com.br/cobrancas/v2';
  $ambiente = $ambiente;
}

function fields(array $fields, string $format="json") {
  if($format == "json") {
      return $fields = (!empty($fields) ? json_encode($fields) : null);
  }
  if($format == "query"){
      return $fields = (!empty($fields) ? http_build_query($fields) : null);
  }
}

function getToken(){
  
  $fields['grant_type'] = 'client_credentials';
  $fields['scope'] = 'cobrancas.boletos-info cobrancas.boletos-requisicao';
  $fields = fields($fields,'query');



  $ci = curl_init($GLOBALS['urlToken']);
  curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ci, CURLOPT_POST, true);
  curl_setopt($ci, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ci, CURLOPT_HTTPHEADER, [
      "Content-Type: application/x-www-form-urlencoded",
      'Authorization: Basic '. base64_encode( $GLOBALS['clientID'].':'.$GLOBALS['client_secret']).''
  ]);
  
  $resposta = curl_exec($ci);
  curl_close($ci);
  
  $resultado = json_decode($resposta);
  
  return $resultado;
}
//-------------------- FIM ------------------------------------
//var_dump($_POST);

switch($action)
{
  
  
    //SELECIONAR USUARIO
    case 1:
      session_start();
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $query = $mysqli->query("SELECT * FROM usuarios WHERE user = '".$user."'");
        
        if(!$query){
          $result = array('result' => 'error', 'error' => 'Usuário não encontrado.');
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
                
                $arr = array('iduser' => $res['iduser'],'name' => $res['name'],'email' => $res['email'], 'cpf' => $res['cpf'], 'user' => $res['user'], 'pass' => $res['pass'], 'tipo' => $tip, 'access' => $res['acces'], 'grupo' => $res['fk_grupo']);
            }
            if(@sizeof($arr) > 0){
                $result = array('result' => 'sucess', 'datas' => $arr, 'dir' => dirname(__FILE__));
            }

        }
        echo json_encode($result, JSON_PRETTY_PRINT);
      break;

      //SELECIONAR USUARIO LOGADO
    case 2:
      $iduser = $_POST['iduser'];
      $status = $_POST['status'];
      $tipo = $_POST['tipo'];
      $empresa = $_POST['empresa'];

      $where = Array();
      if($iduser){
        $where[] = "iduser = $iduser";
      }
      if($status){
        $where[] = "status = $status";
      }
      if($tipo){
        $where[] = "acces = $tipo";
      }
      if($empresa){
        $where[] = "fk_empresa = $empresa";
      }

      $sql = "SELECT * FROM  usuarios";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
      

      $query = $mysqli->query($sql);
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Nenhum usuário encontrado.');
      }else{
        
          while($res = $query->fetch_array()){
            $emp = '';
            if($res['fk_empresa'] >= 1){
              $cons1 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
              $temp = $cons1->fetch_array();
              $emp = $temp['nome_fantasia'];
            }else{
              $emp = '';
            }

            if($res['acces'] == 1){
              $tip = "Usuário";
            }
            if($res['acces'] == 2){
              $tip = "Administrativo";
            }
            if($res['acces'] == 3){
              $tip = "Gerencial";
            }
            
            $arr[] = array('iduser' => $res['iduser'],'name' => $res['name'],'email' => $res['email'], 'cpf' => $res['cpf'], 'user' => $res['user'], 'pass' => $res['pass'], 'status' => $res['status'],'fk_empresa' => $res['fk_empresa'],'empresa' => $emp,'tipo' => $tip, 'acces' => $res['acces'], 'grupo' => $res['fk_grupo']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'erro' => 'Nenhum usuário encontrado', 'campo' => $sql);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR USUÁRIO
    case 3:
      $nome = ucwords($_POST['nome']);
      $email = $_POST['email'];
      $cpf = $_POST['cpf'];
      $usuario = $_POST['usuario'];
      $senha = md5($_POST['senha']);
      $tipo = $_POST['tipo'];
      $empresa = $_POST['empresa'];

      if($nome && $email && $cpf && $usuario && $senha && $tipo && $empresa != null){
        $sel = $mysqli->query("INSERT INTO usuarios (name,email,cpf,user,pass,acces,fk_empresa) VALUES ('$nome','$email','$cpf','$usuario','$senha',$tipo,$empresa)");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $name.' '.$email.' '.$cpf.' '.$tipo;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','usuarios','$hoje','$hora','".$name.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Usuário inserido com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir usuário.','campo' => $mysli->error);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatorios incompletos.','campo' => $tipo);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR EMPRESA
    case 4:
      $codigo = $_POST['codigo'];
      $cnpj = $_POST['cnpj'];
      $razao = ucwords($_POST['razao_social']);
      $fantasia = ucwords($_POST['nome_fantasia']);
      $tipo = $_POST['tipo_empresa'];
      $matriz = $_POST['matriz'];
      if(!$matriz){
        $matriz = 0;
      }
      $irrf = $_POST['irrf'];
      $pis = $_POST['pis'];
      $cofins = $_POST['cofins'];
      $p5952 = $_POST['p5952'];
      if(!$p5952){
        $p5952 = 0;
      }
      $csll = $_POST['csll'];
      $inss = $_POST['inss'];
      $iss = $_POST['iss'];
      $usuario = $_POST['usuario'];

      // if($cnpj && $razao && $fantasia && $tipo){
       // if($matriz != null && $matriz > 0){
          $sql = "INSERT INTO empresas (razao_social, nome_fantasia, cnpj, p5952,tipo_empresa, fk_matriz, irrf, pis, cofins, csll, inss, iss,status) VALUES ('$razao','$fantasia','$cnpj',$p5952,'$tipo',$matriz,$irrf,$pis,$cofins,$csll,$inss,$iss,'ATIVA')";
        //}else{
          //$sql = "INSERT INTO empresas (ident, razao_social, nome_fantasia, cnpj, p5952,tipo_empresa, irrf, pis, cofins, csll, inss, iss,status) VALUES ($codigo,'$razao','$fantasia','$cnpj',$p5952,'$tipo',$irrf,$pis,$cofins,$csll,$inss,$iss,'ATIVA')";
       // }
        $cons = $mysqli->query("SELECT * FROM empresas WHERE razao_social = '$razao'");
        if($cons->num_rows == 0){
          $sel = $mysqli->query($sql);
          if($sel){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $razao.' '.$fantasia.' '.$cnpj.' '.$tipo;
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','empresas','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'sucess', 'datas' => 'Usuário inserido com sucesso.');
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Empresa.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir Empresa.', 'msg' => 'Empresa já cadastrada', 'campo' => $sql);
        }
        
      // }else{
      //   $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
      // }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //SELECIONAR EMPRESAS CADASTRADAS PARA SELECT
    case 5:
      $status = $_POST['status'];
      if($status){
        $where = "WHERE status = '$status'";
      }else{
        $where = '';
      }
      $query = $mysqli->query("SELECT * FROM empresas ".$where." ORDER BY razao_social");
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Empresas não encontradas.');
      }else{
        
          while($res = $query->fetch_array()){
            //echo ($res['razao_social']);
            $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_matriz']."");
            if($sel){
              //echo "Entrou";
              $mat = $sel->fetch_array();
            }
            
            $arr[] = array('idemp' => $res['ident'],'razao_social' => ($res['razao_social']),'nome_fantasia' => ($res['nome_fantasia']), 'cnpj' => $res['cnpj'], 'tipo_empresa' => $res['tipo_empresa'], 'matriz' => ($mat['razao_social']),'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'inss' => $res['inss'],'csll' => $res['csll'],'iss' => $res['iss'],'status' => $res['status']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR EMPRESAS CADASTRADAS
    case 6:
      $tipo = $_POST['tipo_empresa'];
      $emp = $_POST['emp'];
      $status = $_POST['status'];
      $matriz = $_POST['matriz'];
      if(!$matriz){
        $matriz = -1;
      }
      if(!$emp){
        $emp = 0;
      }
      if($matriz > 0 || $status || $tipo || $emp){
        $query = $mysqli->query("SELECT * FROM empresas WHERE tipo_empresa = '".$tipo."' OR status = '$status' OR fk_matriz = $matriz OR ident = $emp  ORDER BY nome_fantasia ASC");
      }else{
        $query = $mysqli->query("SELECT * FROM empresas ORDER BY nome_fantasia ASC");
      }
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Empresas não encontradas.','campo' => $tipo);
      }else{
          while($res = $query->fetch_array()){
            if($res['fk_matriz'] != 0){
              $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_matriz']."");
              if($sel){
                $mat = $sel->fetch_array();
              }
            }
           
            $arr[] = array('idemp' => $res['ident'],'razao_social' => ($res['razao_social']),'nome_fantasia' => ($res['nome_fantasia']), 'cnpj' => $res['cnpj'], 'tipo_empresa' => $res['tipo_empresa'], 'fk_matriz' => ($mat['ident']),'matriz' => ($mat['razao_social']),'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'inss' => $res['inss'],'csll' => $res['csll'],'iss' => $res['iss'],'status' => $res['status'],'banco' => $res['banco'],'num_banco' => $res['num_banco'],'convenio' => $res['convenio'],'carteira' => $res['carteira'],'variacao' => $res['variacao'],'agencia' => $res['agencia'],'conta' => $res['conta']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }else{
            $result = array('result' => 'error', 'error' => 'Nenhum registro encontrado');
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR ESTADOS
    case 7:
      $query = $mysqli->query("SELECT * FROM estados ORDER BY sigl_estado ASC");

      if(!$query){
        $result = array('result' => 'error', 'error' => 'Estados não encontrados.');
      }else{
          while($res = $query->fetch_array()){
            $arr[] = array('cod_estado' => $res['cod_estado'],'dsc_estado' => $res['dsc_estado'],'sigl_estado' => $res['sigl_estado']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR CIDADES
    case 8:
      $uf = $_GET['uf'];
      $sel = $mysqli->query("SELECT cod_estado FROM estados WHERE sigl_estado = '$uf'");
      $cod = $sel->fetch_array();
      $query = $mysqli->query("SELECT * FROM cidades WHERE cod_estado = ".$cod['cod_estado']." ORDER BY dsc_cidade ASC");

      if(!$query){
        $result = array('result' => 'error', 'error' => 'Cidades não encontrados.');
      }else{
          while($res = $query->fetch_array()){
            $arr[] = array('cod_cidade' => $res['cod_cidade'],'cod_estado' => $res['cod_estado'],'dsc_cidade' => $res['dsc_cidade']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($arr);
    break;

    // INSERIR FORNECEDOR
    case 9:
      //print_r($_POST);
      $cod_cidade = $_POST['cidade'];
      $busca = $mysqli->query("SELECT * FROM cidades WHERE cod_cidade = $cod_cidade");
      if($busca){
        $cid_tmp = $busca->fetch_array();
      }
      $busc = $mysqli->query("SELECT * FROM estados WHERE cod_estado = ".$cid_tmp['cod_estado']."");
      if($busc){
        $est_tmp = $busc->fetch_array();
      }
      $codigo = $_POST['codigo'];
      $cnpj = $_POST['cnpj'];
      $fornecedor = mysqli_real_escape_string($mysqli,ucwords($_POST['fornecedor']));
      $fantasia = mysqli_real_escape_string($mysqli,ucwords($_POST['fantasia']));
      $tipo = $_POST['tipo_fornecedor'];
      $fk_empresa = $_POST['fk_empresa'];
      $endereco = mysqli_real_escape_string($mysqli,$_POST['endereco']);
      $complemento = $_POST['complemento'];
      $bairro = mysqli_real_escape_string($mysqli,$_POST['bairro']);
      $cep = $_POST['cep'];
      $uf = $est_tmp['sigl_estado'];
      $cidade = mysqli_real_escape_string($mysqli,$cid_tmp['dsc_cidade']);
      $fone = $_POST['fone'];
      $fax = $_POST['fax'];
      $email = $_POST['email'];
      $site = $_POST['site'];
      $usuario = $_POST['usuario'];
      $sql = "INSERT INTO fornecedores (cpf_cnpj, fornecedor, tipo_fornecedor, fk_empresa, nome_fantasia, endereco, complemento, bairro, cep, uf, cidade, fone, fax, email, site) VALUES ('$cnpj','$fornecedor','$tipo',$fk_empresa,'$fantasia','$endereco','$complemento','$bairro','$cep','$uf','$cidade','$fone','$fax','$email','$site')";
      if($cnpj){
        //if($fornecedor && $fantasia && $tipo){
        // $busca = $mysqli->query("SELECT * FROM fornecedores WHERE fornecedor = '$fornecedor'");
        // $lines = $busca->num_rows;
        // if($lines == 0){
          
          $sel = $mysqli->query($sql);
          if($sel){
            $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $cnpj.' '.$tipo.' '.$fantasia.' '.$fornecedor;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','fornecedores','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'sucess', 'datas' => 'Fornecedor inserido com sucesso.', 'msg' => 'Fornecedor inserido com sucesso.', 'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Empresa.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        // }else{
        //   $result = array('result' => 'error', 'error' => 'Já existe Fornecedor cadastrado no sistema com esse CPF/CNPJ.','msg' => 'Já existe Fornecedor cadastrado no sistema com esse CPF/CNPJ.', 'campo' => $sql);
        // }
        
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: Dados obrigatórios incompletos.', 'campo' => $sql);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR FORNECDORES CADASTRADOS POR PARTE DO NOME
    case 10:
      $nome = $_GET['term'];
      
      $query = $mysqli->query("SELECT * FROM fornecedores WHERE fornecedor like '%$nome%'");
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Empresas não encontradas.','campo' => $tipo);
      }else{
          while($res = $query->fetch_array()){
            $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_matriz']."");
            $mat = $sel->fetch_array();
            $arr[] = array('fornecedor' => ($res['fornecedor']));
          }
          

      }
      echo json_encode($arr);
    break;

    //LISTAR FORNECDORES CADASTRADOS
    case 11:
      $tipo = $_POST['tipo_fornecedor'];
      $emp = $_POST['empresa'];
      $cpf_cnpj = $_POST['cpf_cnpj'];
      $fornecedor = $_POST['fornecedor'];
      $idforn = $_POST['id_forn'];

      $where = Array();   

      if ($tipo){
        $where[] = "`tipo_fornecedor` =  '$tipo'";
      }
      if($emp){
        $where[] = "`fk_empresa` = $emp";
      }
      if($cpf_cnpj){
        $where[] = "`cpf_cnpj` = '$cpf_cnpj'";
      }
      if($fornecedor){
        $where[] = "`fornecedor` LIKE '%".$fornecedor."%'";
      }
      if($idforn){
        $where[] = "`idforn` = '$idforn'";
      }
      
        //echo $empresa;
        
        $sql = "SELECT * FROM  fornecedores";
        //$sql = "SELECT fornecedor FROM  fornecedores";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
        //echo $sql;
        $sel = $mysqli->query($sql);
        //echo $mysqli->error;
      
      // if($fornecedor || $cpf_cnpj || $tipo || $emp > 0 || $idforn > 0){
      //   $sql = "SELECT * FROM fornecedores WHERE tipo_fornecedor = '$tipo' OR cpf_cnpj = '$cpf_cnpj' OR fk_empresa = $emp OR fornecedor = '$fornecedor' OR idforn = $idforn";
      // }else{
      //   $sql = "SELECT * FROM fornecedores ORDER BY fornecedor ASC";
      // }
      
      //$query = $mysqli->query($sql);
      if(!$sel){
        $result = array('result' => 'error', 'error' => 'Fornecedores não encontrados.','campo' => $sql);
      }else{
          while($res = $sel->fetch_array()){
            $cons = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            $mat = $cons->fetch_array();
            $arr[] = array('idforn' => $res['idforn'],'fornecedor' => ($res['fornecedor']),'nome_fantasia' => ($res['nome_fantasia']), 'empresa' => $mat['nome_fantasia'], 'fk_empresa' => $res['fk_empresa'],'cpf_cnpj' => ($res['cpf_cnpj']), 'tipo_fornecedor' => ($res['tipo_fornecedor']),'endereco' => ($res['endereco']),'complemento' => ($res['complemento']),'bairro' => ($res['bairro']),'cep' => ($res['cep']),'uf' => ($res['uf']),'cidade' => ($res['cidade']),'fone' => ($res['fone']),'fax' => ($res['fax']),'email' => ($res['email']),'site' => ($res['site']));
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //DETALHAR FORNECDOR
    case 12:
      $cod = $_POST['cod'];
    
      if($cod){
        $query = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = $cod");
      }else{
        $result = array('result' => 'error', 'error' => 'Fornecedor não encontrado.','campo' => $tipo);
      }
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Fornecedor não encontrado.','campo' => $tipo);
      }else{
          $res = $query->fetch_array();
            $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            $mat = $sel->fetch_array();
            $arr[] = array('idforn' => $res['idforn'],'fornecedor' => $res['fornecedor'],'nome_fantasia' => ($res['nome_fantasia']), 'cpf_cnpj' => $res['cpf_cnpj'], 'tipo_fornecedor' => $res['tipo_fornecedor'], 'empresa' => ($mat['razao_social']),'endereco' => $res['endereco'],'complemento' => ($res['complemento']),'bairro' => $res['bairro'],'cep' => $res['cep'],'uf' => $res['uf'],'cidade' => $res['cidade'],'fone' => $res['fone'],'fax' => $res['fax'],'email' => $res['email'],'site' => $res['site']);
          
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR CLIENTE
    case 13:
      $cod_cidade = $_POST['cidade'];
      $busca = $mysqli->query("SELECT * FROM cidades WHERE cod_cidade = $cod_cidade");
      if($busca){
        $cid_tmp = $busca->fetch_array();
      }
      $busc = $mysqli->query("SELECT * FROM estados WHERE cod_estado = ".$cid_tmp['cod_estado']."");
      if($busc){
        $est_tmp = $busc->fetch_array();
      }
      $codigo = $_POST['codigo'];
      $cpfcnpj = $_POST['cpf_cnpj'];
      $cliente = mysqli_real_escape_string($mysqli,ucwords($_POST['cliente']));
      $fantasia = mysqli_real_escape_string($mysqli,ucwords($_POST['fantasia']));
      $tipo = $_POST['tipo_cliente'];
      $fk_empresa = $_POST['fk_empresa'];
      $endereco = mysqli_real_escape_string($mysqli,$_POST['endereco']);
      $complemento = $_POST['complemento'];
      $bairro = mysqli_real_escape_string($mysqli,$_POST['bairro']);
      $cep = $_POST['cep'];
      $uf = $est_tmp['sigl_estado'];
      $cidade = mysqli_real_escape_string($mysqli,$cid_temp['dsc_cidade']);
      $fone = $_POST['fone'];
      $fax = $_POST['fax'];
      $email = $_POST['email'];
      $reter = $_POST['reter'];
      $usuario = $_POST['usuario'];
      $sql = "INSERT INTO clientes (cpf_cnpj, fk_empresa, cliente, tipo_cliente, nome_fantasia, endereco, complemento, bairro, cep, uf, cidade, fone, fax, email, reter) VALUES ('$cpfcnpj',$fk_empresa,'$cliente','$tipo','$fantasia','$endereco','$complemento','$bairro','$cep','$uf','$cidade','$fone','$fax','$email','$reter')";
      // if($cpfcnpj && $cliente && $fantasia && $tipo && $endereco && $bairro && $cep && $uf && $cidade && $fone){
      //if($cliente && $fantasia && $tipo){
        $cons = $mysqli->query("SELECT * FROM clientes WHERE cliente = '$cliente' AND fk_empresa = $fk_empresa");
        $lines = $cons->num_rows;
        if($lines == 0){
          $sel = $mysqli->query($sql);
          if($sel){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $cpfcnpj.' '.$cliente.' '.$fantasia.' '.$tipo;
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','clientes','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'sucess', 'datas' => 'Cliente inserido com sucesso.', 'msg' => 'Cliente inserido com sucesso.', 'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Cliente.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        }else{
          $result = array('result' => 'error', 'error' => 'Cliente já cadastrado', 'msg' => 'Cliente já cadastrado', 'campo' => $sql);
        }
        
      // }else{
      //   $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.', 'msg' => 'Dados obrigatórios incompletos.', 'campo' => $sql);
      // }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR CLIENTES CADASTRADOS
    case 14:
      $tipo = $_POST['tipo_cliente'];
      $cliente = $_POST['cliente'];
      $emp = $_POST['empresa'];
      $cpf_cnpj = $_POST['cpf_cnpj'];
      //$fornecedor = $_POST['cliente'];
      $idcli = $_POST['id_cli'];
      // if(!$emp){
      //   $emp = 0;
      // }
      // echo $emp;
      // if($cliente || $cpf_cnpj || $tipo){
      //   //echo 'entrou';
      //   $query = $mysqli->query("SELECT * FROM clientes WHERE tipo_cliente = '$tipo' OR cpf_cnpj = '$cpf_cnpj' OR fk_empresa = $emp OR cliente = '$cliente' OR idcli = $idcli");
      // }else{
      //   $query = $mysqli->query("SELECT * FROM clientes ORDER BY cliente ASC");
      // }
      
      $where = Array();   

      if ($tipo){
        $where[] = "`tipo_cliente` =  '$tipo'";
      }
      if($cliente){
        $where[] = "`cliente` LIKE '%".$cliente."%'";
      }
      if($cpf_cnpj){
        $where[] = "`cpf_cnpj` = '$cpf_cnpj'";
      }
      if($fornecedor){
        $where[] = "`fornecedor` = '$fornecedor'";
      }
      if($idcli){
        $where[] = "`idcli` = '$idcli'";
      }
      if($emp){
        $where[] = "`fk_empresa` = $emp";
      }
      
        //echo $empresa;
        
        $sql = "SELECT * FROM  clientes";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
        $sql = $sql.' ORDER BY nome_fantasia';
        //echo $sql;
        $query = $mysqli->query($sql);
        //echo $mysqli->error;
      
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'clientes não encontrados.','campo' => $sql);
      }else{
          while($res = $query->fetch_array()){
            // $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            // $mat = $sel->fetch_array();
            $arr[] = array('idcli' => $res['idcli'],'cliente' => ($res['cliente']),'nome_fantasia' => ($res['nome_fantasia']), 'fk_empresa' => $res['fk_empresa'],'cpf_cnpj' => $res['cpf_cnpj'], 'tipo_cliente' => ($res['tipo_cliente']), 'endereco' => ($res['endereco']),'complemento' => ($res['complemento']),'bairro' => ($res['bairro']),'cep' => $res['cep'],'uf' => ($res['uf']),'cidade' => ($res['cidade']),'fone' => ($res['fone']),'fax' => ($res['fax']),'email' => ($res['email']),'reter' => ($res['reter']));
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // ATUALIZAR EMPRESA
    case 15:
      $idemp = $_POST['idemp'];
      $cnpj = $_POST['cnpj'];
      $razao = ucwords($_POST['razao_social']);
      $fantasia = ucwords($_POST['nome_fantasia']);
      $tipo = $_POST['tipo_empresa'];
      $matriz = $_POST['matriz'];
      $irrf = $_POST['irrf'];
      $pis = $_POST['pis'];
      $cofins = $_POST['cofins'];
      $csll = $_POST['csll'];
      $inss = $_POST['inss'];
      $iss = $_POST['iss'];
      $status = $_POST['status'];
      $usuario = $_POST['usuario'];

      $num_banco = $_POST['num_banco'];
      $banco = $_POST['banco'];
      $agencia = $_POST['agencia'];
      $conta = $_POST['conta'];
      $carteira = $_POST['carteira'];
      $modalidade = $_POST['modalidade'];
      $convenio = $_POST['convenio'];
      $variacao = $_POST['variacao'];

      if(!$matriz){
        $matriz = 0;
      }

      if(!$convenio){
        $convenio = "Não informado";
      }
      if(!$conta){
        $conta = "Não informado";
      }
      if(!$agencia){
        $agencia = "Não informado";
      }
      if(!$banco){
        $banco = "Não informado";
      }
      if(!$num_banco){
        $num_banco = "Não informado";
      }
      $sql = "UPDATE empresas SET  razao_social = '$razao', nome_fantasia = '$fantasia', tipo_empresa = '$tipo', fk_matriz = $matriz, irrf = $irrf, pis = $pis, cofins = $cofins, csll = $csll, inss = $inss, iss = $iss, status = '$status', convenio = '$convenio', banco = '$banco', conta = '$conta', agencia = '$agencia', num_banco = '$num_banco' WHERE ident = $idemp";
      if($cnpj && $razao && $fantasia && $tipo){
        $sel = $mysqli->query($sql);
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $cnpj.' '.$razao.' '.$fantasia.' '.$tipo;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','empresa','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Empresa atualizada com sucesso.', 'msg' => 'Empresa atualizada com sucesso.', 'campo' => $sql);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Empresa.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Dados obrigatórios incompletos.' , 'campo' => $sql);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // ATUALIZAR FORNECEDOR
    case 16:
      //print_r($_POST);
      $idforn =$_POST['idforn'];
      $cnpj = $_POST['cnpj'];
      $fornecedor = ucwords($_POST['fornecedor']);
      $fantasia = ucwords($_POST['fantasia']);
      $tipo = $_POST['tipo_fornecedor'];
      $fk_empresa = $_POST['fk_empresa'];
      $endereco = $_POST['endereco'];
      $complemento = $_POST['complemento'];
      $bairro = $_POST['bairro'];
      $cep = $_POST['cep'];
      $uf = $_POST['uf'];
      $cidade = $_POST['cidade'];
      $fone = $_POST['fone'];
      $fax = $_POST['fax'];
      $email = $_POST['email'];
      $site = $_POST['site'];
      $usuario = $_POST['usuario'];

      // if($cnpj && $fornecedor && $fantasia && $tipo && $fk_empresa && $endereco && $bairro && $cep && $uf && $cidade && $fone){
        $sel = $mysqli->query("UPDATE fornecedores SET fornecedor = '$fornecedor', fk_empresa = $fk_empresa, tipo_fornecedor = '$tipo', nome_fantasia = '$fantasia', endereco = '$endereco', complemento = '$complemento', bairro = '$bairro', cep = '$cep', uf = '$uf', cidade = '$cidade', fone = '$fone', fax = '$fax', email = '$email', site = '$site' WHERE idforn = $idforn");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $cnpj.' '.$fornecedor.' '.$fantasia.' '.$tipo;
          $sqlIns = "INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','fornecedor','$hoje','$hora','$usuario','$dados','antigo')";
          $ins = $mysqli->query($sqlIns);
          if($ins){
            $reg = "Registro criado!";
          }else{
            $reg = "Registro não criado!";
          }
          $result = array('result' => 'sucess', 'datas' => 'Fornecedor inserido com sucesso.', 'msg' => $mysqli->error, 'campo' => $reg, 'info' => $sqlIns);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir Empresa.', 'msg' => $mysqli->error, 'campo' => $razao);
        }
      // }else{
      //   $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
      // }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    

    // ATUALIZAR CLIENTE
    case 17:
      //print_r($_POST);
      $cpfcnpj = $_POST['cpf_cnpj'];
      $cliente = ucwords(addslashes($_POST['cliente']));
      $fantasia = ucwords(addslashes($_POST['fantasia']));
      $tipo = $_POST['tipo_cliente'];
      $fk_empresa = $_POST['fk_empresa'];
      $endereco = $_POST['endereco'];
      $complemento = $_POST['complemento'];
      $bairro = $_POST['bairro'];
      $cep = $_POST['cep'];
      $uf = $_POST['uf'];
      $cidade = $_POST['cidade'];
      $fone = $_POST['fone'];
      $fax = $_POST['fax'];
      $email = $_POST['email'];
      $reter = $_POST['reter'];
      $usuario = $_POST['usuario'];
      
      $sql = "UPDATE clientes SET cliente = '$cliente', fk_empresa = $fk_empresa, tipo_cliente = '$tipo', nome_fantasia = '$fantasia', endereco = '$endereco', complemento = '$complemento', bairro = '$bairro', cep = '$cep', uf = '$uf', cidade = '$cidade', fone = '$fone', fax = '$fax', email = '$email', reter = '$reter' WHERE cpf_cnpj = '$cpfcnpj'";
      if($cpfcnpj && $cliente && $fantasia && $tipo && $fk_empresa && $fone){
        
        $sel = $mysqli->query($sql);
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $cpfcnpj.' '.$cliente.' '.$fantasia.' '.$tipo;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','clientes','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Cliente atualizado com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Empresa.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => $mysqli->error, 'campo' => $sql);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //DETALHAR CLIENTE
    case 18:
      $cod = $_POST['cod'];
    
      if($cod){
        $query = $mysqli->query("SELECT * FROM clientes WHERE idcli = $cod");
      }else{
        $result = array('result' => 'error', 'error' => 'Cliente não encontrado.','campo' => $tipo);
      }
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Cliente não encontrado.','campo' => $tipo);
      }else{
          $res = $query->fetch_array();
            $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            $mat = $sel->fetch_array();
            $arr[] = array('idcli' => $res['idcli'],'cliente' => $res['cliente'],'nome_fantasia' => ($res['nome_fantasia']), 'cpf_cnpj' => $res['cpf_cnpj'], 'tipo_cliente' => $res['tipo_cliente'], 'empresa' => ($mat['razao_social']),'endereco' => $res['endereco'],'complemento' => $res['complemento'],'bairro' => $res['bairro'],'cep' => $res['cep'],'uf' => $res['uf'],'cidade' => $res['cidade'],'fone' => $res['fone'],'fax' => $res['fax'],'email' => $res['email'],'reter' => $res['reter']);
          
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR CENTRO DE CUSTO
    case 19:
      //print_r($_POST);
      $codigo = $_POST['codigo'];
      $fk_empresa = $_POST['fk_empresa'];
      $centro = ucwords(addslashes($_POST['centro']));
      $obs = $_POST['obs'];
      $usuario = $_POST['usuario'];

      if($centro){
        // $cons = $mysqli->query("SELECT * FROM centro_custo WHERE centro = '$centro'");
        // if($cons->num_rows == 0){
          $sql = "INSERT INTO centro_custo (centro, obs, fk_empresa) VALUES ('$centro','$obs', $fk_empresa)";
          $sel = $mysqli->query($sql);
          if($sel){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $centro.' '.$obs;
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','centro_custo','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'sucess', 'datas' => 'Centro de Custos inserido com sucesso.');
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Centro de Custos.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        // }else{
        //   $result = array('result' => 'error', 'error' => 'Erro ao inserir Centro de Custos.', 'msg' => 'Centro de Custo já cadastrado', 'campo' => $sql);
        // }
       
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$sql);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR CENTROS DE CUSTOS
    case 20:
      $centro = $_POST['centro'];
      $empresa = $_POST['empresa'];
      $idcentro = $_POST['idcentro'];

      $where = Array();

      if($centro){
        $where[] = "`centro` LIKE '%".$centro."%'";
      } 
      if($idcentro){
        $where[] = "`idcentro` = $idcentro";
      }

       
      $sql = "SELECT * FROM  centro_custo";
      if( sizeof( $where ) ){
        $sql .= ' WHERE '.implode( ' AND ',$where )."";
      }

      $sql = $sql.' ORDER BY centro  ASC';
      //echo $sql;
      $query = $mysqli->query($sql);
      //echo $mysqli->error;

      if(!$query){
        $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campo' => $empresa);
      }else{
          while($res = $query->fetch_array()){
            //echo ($res['obs']);
            // $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            // $mat = $sel->fetch_array();
            $arr[] = array('idcentro' => $res['idcentro'],'centro' => ($res['centro']),'fk_empresa' => $mat['ident'],'obs' => ($res['obs']),'campo' => $centro);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }else{
            $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campo' => $sql);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;


    // ATUALIZAR FORNECEDOR
    case 21:
      //print_r($_POST);
      $centro = ucwords($_POST['centro']);
      $fornecedor = ($_POST['obs']);
      $usuario = $_POST['usuario'];

      if($cnpj && $fornecedor && $fantasia && $tipo && $fk_empresa && $endereco && $bairro && $cep && $uf && $cidade && $fone){
        $sel = $mysqli->query("UPDATE fornecedores SET fornecedor = '$fornecedor', fk_empresa = $fk_empresa, tipo_fornecedor = '$tipo', nome_fantasia = '$fantasia', endereco = '$endereco', complemento = '$complemento', bairro = '$bairro', cep = '$cep', uf = '$uf', cidade = '$cidade', fone = '$fone', fax = '$fax', email = '$email', site = '$site' WHERE cpf_cnpj = '$cnpj'");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $cnpj.' '.$fornecedor.' '.$fantasia.' '.$tipo;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','fornecedores','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Fornecedor inserido com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir Empresa.', 'msg' => $mysqli->error, 'campo' => $razao);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR CLIENTE
    case 22:
      $idcli = $_POST['idcli'];
      $usuario = $_POST['usuario'];
      if($idcli){
        $del = $mysqli->query("DELETE FROM clientes WHERE idcli = $idcli");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','clientes','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Cliente excluido!.', 'msg' => $mysqli->error, 'campo' => $idcli);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar cliente!.', 'msg' => $mysqli->error, 'campo' => $idcli);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR FORNECEDOR
    case 23:
      $idforn = $_POST['idforn'];
      $usuario = $_POST['usuario'];
      if($idforn){
        $del = $mysqli->query("DELETE FROM fornecedores WHERE idforn = $idforn");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','fornecedores','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Fornecedor excluido!.', 'msg' => $mysqli->error, 'campo' => $idforn);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar fornecedor!.', 'msg' => $mysqli->error, 'campo' => $idforn);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR EMPRESA
    case 24:
      $idemp = $_POST['idemp'];
      $usuario = $_POST['usuario'];

      if($idemp){
        $del = $mysqli->query("DELETE FROM empresas WHERE ident = $idemp");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','empresas','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Empresa excluida!.', 'msg' => $mysqli->error, 'campo' => $idemp);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar empresa!.', 'msg' => $mysqli->error, 'campo' => $idemp);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR CENTRO DE CUSTO
    case 25:
      $idcent = $_POST['idcent'];
      $usuario = $_POST['usuario'];

      if($idcent){
        $del = $mysqli->query("DELETE FROM centro_custo WHERE idcentro = $idcent");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','centro_custp','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Centro de Custo excluida!.', 'msg' => $mysqli->error, 'campo' => $idcent);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar Centro de Custo!.', 'msg' => $mysqli->error, 'campo' => $idcent);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR CENTRO DE CUSTO
    case 26:
      //print_r($_POST);
      $fk_empresa = $_POST['fk_empresa'];
      $centro = ucwords($_POST['centro']);
      $obs = $_POST['obs'];
      $idcent = $_POST['idcent'];
      $usuario = $_POST['usuario'];

      if($centro){
        $sel = $mysqli->query("UPDATE centro_custo SET centro = '$centro', obs = '$obs' WHERE idcentro = $idcent");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $centro.' '.$obs;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','centro_custo','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Centro de Custos inserido com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Centro de Custos.', 'msg' => $mysqli->error, 'campo' => $centro);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR FORMA DE PAGAMENTO
    case 27:
      //print_r($_POST);
      // $id = ($_POST['codigo']);
      $pagamento = strtoupper($_POST['pagamento']);
      $codigo = $_POST['codigo'];
      $empresa = $_POST['empresa'];
      $obs = $_POST['obs'];
      $usuario = $_POST['usuario'];

      // $sele = $mysqli->query("SELECT * FROM frm_pagamento WHERE codigo = '$codigo'");
      // $count = $sele->num_rows;
      // if($count == 0){
        $sql = "INSERT INTO frm_pagamento (fk_empresa,pagamento, codigo,status) VALUES ($empresa,'$pagamento','$codigo','ATIVO')";
        if($pagamento && $codigo){
          // $cons = $mysqli->query("SELECT * FROM frm_pagamento WHERE pagamento = '$pagamento'");
          // if($cons->num_rows == 0){
            
            $sel = $mysqli->query($sql);
            if($sel){
              $hoje = date("Y-m-d");
              $hora = date("H:i");
              $dados = $pagamento.' '.$codigo;
              $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','frm_pagamento','$hoje','$hora','".$usuario.",'$dados')");
              $result = array('result' => 'sucess', 'datas' => 'Forma de Pagamento inserido com sucesso.', 'msg' => $mysqli->error, 'campo' => $sql);
            }else{
              $result = array('result' => 'error', 'error' => 'Erro ao inserir Forma de Pagamento.', 'msg' => $mysqli->error, 'campo' => $sql);
            }
          // }else{
          //   $result = array('result' => 'error', 'error' => 'Erro ao inserir Forma de Pagamento.', 'msg' => 'Forma de Pagamento já cadastrada', 'campo' => $sql);
          // }
          
        }else{
          $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Dados obrigatórios incompletos.', 'campo' => $sql);
        }
      // }else{
      //   $result = array('result' => 'error', 'error' => 'Não foi possível cadastrar. Código já cadastrado!.','msg' => 'Não foi possível cadastrar. Código já cadastrado!.', 'campo' => $sql);
      // }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR FORMA DE PAGAMENTO
    case 28:
      $pagamento = $_POST['pagamento'];
      $codigo = $_POST['codigo'];
      $ativo = $_POST['ativo'];
      $idfrmpag = $_POST['idfrmpag'];
      if(!$idfrmpag){
        $idfrmpag = 0;
      }
    
      if($codigo || $ativo || $idfrmpag){
        $query = $mysqli->query("SELECT * FROM frm_pagamento WHERE codigo = '".$codigo."' OR ativo = '$ativo'  OR idfrmpag = $idfrmpag");
      }else{
        $query = $mysqli->query("SELECT * FROM frm_pagamento ORDER BY pagamento ASC");
      }
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Forma de Pagamento não encontrado.','campo' => $ativo);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idfrmpag' => $res['idfrmpag'],'codigo' => $res['codigo'],'pagamento' => ($res['pagamento']),'ativo' => $res['ativo'],'campo' => $centro);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }else{}

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR FORMA DE PAGAMENTO
    case 29:
      //print_r($_POST);
      $pagamento = ucwords($_POST['pagamento']);
      $codigo = $_POST['codigo'];
      $ativo = $_POST['ativo'];
      $idfrmpag = $_POST['idfrmpag'];
      $usuario = $_POST['usuario'];

      if($codigo && $pagamento && $ativo){
        $sel = $mysqli->query("UPDATE frm_pagamento SET codigo = '$codigo', pagamento = '$pagamento', ativo = '$ativo' WHERE idfrmpag = $idfrmpag");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $pagamento.' '.$codigo.' '.$ativo;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','frm_pagamento','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Forma de Pagamento atualizada com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Forma de Pagamento.', 'msg' => $mysqli->error, 'campo' => $centro);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR FORMA DE PAGAMENTO
    case 31:
      $idfrmpag = $_POST['idfrmpag'];
      $usuario = $_POST['usuario'];

      if($idfrmpag){
        $del = $mysqli->query("DELETE FROM frm_pagamento WHERE idfrmpag = $idfrmpag");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','frm_pagamento','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Fora de Pagamento excluida!.', 'msg' => $mysqli->error, 'campo' => $idcent);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao deletar. Campos Obrigatório Ausente!.', 'msg' => $mysqli->error, 'campo' => $idfrmpag);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar. Campos Obrigatório Ausente!.', 'msg' => $mysqli->error, 'campo' => $idfrmpag);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR FORNECDORES POR EMPRESA
    case 32:
      
      $emp = $_POST['empresa'];
      if(is_array($emp)){
        $ids = implode(',',$emp);
      }else{
        $ids = $emp;
      }
      
      if($emp > 0){
        $query = $mysqli->query("SELECT * FROM fornecedores WHERE fk_empresa IN ($ids) ORDER BY nome_fantasia ASC");
      }else{
        $array = json_decode($_POST['empresa']);
        foreach($array as $item){
          $id[] = $item;
        }
        $ids = implode(',',$id);
        $query = $mysqli->query("SELECT * FROM fornecedores WHERE fk_empresa IN ($ids) ORDER BY nome_fantasia ASC");
      }
      $lines = $query->num_rows;
      
      if($lines < 1){
        $result = array('result' => 'error', 'error' => 'Fornecedores não encontrados.','campo' => $emp);
      }else{
          while($res = $query->fetch_array()){
            $arr[] = array('idforn' => $res['idforn'],'fornecedor' => $res['nome_fantasia']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      if($arr){
        echo json_encode($arr);
      }else{
        echo json_encode("null");
      }
      
    break;

    //LISTAR CENTRO DE CUSTO POR EMPRESA
    case 33:
      
      $emp = $_POST['empresa'];
      if(is_array($emp)){
        $tmp = implode(',',$emp);
        $cons = $mysqli->query("SELECT fk_matriz FROM empresas WHERE ident IN ($tmp)");
        $lines = $cons->num_rows;
        $vet = array();
        if($lines > 0){
          while($res = $cons->fetch_array()){
            if($res['fk_matriz'] != null){
              $vet[] = $res['fk_matriz'];
            }
          }
          $results = array_merge($emp,$vet);
          $ids = implode(',',$results);
        }
      }else{
        $tmp = $emp;
        $cons = $mysqli->query("SELECT fk_matriz FROM empresas WHERE ident IN ($tmp)");
        $lines = $cons->num_rows;
        $vet = array();
        if($lines > 0){
          $res = $cons->fetch_array();
          if($res['fk_matriz'] != null){
            $fk = $res['fk_matriz'];
            $ids = $tmp.','.$fk;
          }else{
            $ids = $tmp;
          }
        }
      }
      $sql = "SELECT * FROM centro_custo WHERE fk_empresa IN ($ids) ORDER BY centro";
      if($ids > 0){
        $query = $mysqli->query($sql);
      }else{
        $array = json_decode($_POST['empresa']);
        foreach($array as $item){
          $id[] = $item;
        }
        $tmp = implode(',',$id);
        $cons = $mysqli->query("SELECT ident,fk_matriz FROM empresas WHERE ident IN ($tmp)");
        $lines = $cons->num_rows;
        $vet = array();
        if($lines > 0){
          while($res = $cons->fetch_array()){
            if($res['fk_matriz'] != null){
              $vet[] = $res['fk_matriz'];
            }
          }
          $ids = array_merge($tmp,$vet);
        }
        $query = $mysqli->query("SELECT * FROM centro_custo WHERE fk_empresa IN ($ids) ORDER BY centro");
      }
      $lines = $query->num_rows;
      
      if($lines < 1){
        $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrados.','campos' => $sql.' Emp: '.$emp,'Vet' => $vet, 'ids' => $ids,'lines' => $lines, 'sql1' => $sql1, 'resu' => $resu);
      }else{
          while($res = $query->fetch_array()){
            $arr[] = array('idcentro' => $res['idcentro'],'centro' => $res['centro'], 'campo' => $sql);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }
      }
      if($arr){
        echo json_encode($arr);
      }else{
        echo json_encode($result);
      }
      
    break;

    // INSERIR CONTA A PAGAR
    case 34:
      //print_r($_POST);
      $codigo = $_POST['codigo'];
      $nota_fiscal = $_POST['nota_fiscal'];
      $fornecedor = $_POST['fornecedor'];
      $num_doc = ($_POST['num_doc']);
      $dt_doc = $_POST['dt_doc'];
      $fk_empresa = $_POST['fk_empresa'];
      // $parcela = $_POST['parcela'];
      $centro = $_POST['centro'];
      //$val_doc = $_POST['val_doc'];
      $val_doc = str_replace(',','.',str_replace('.','',$_POST['val_doc']));
      $dt_vencimento = $_POST['dt_vencimento'];
      $frmpag = $_POST['frmpag'];
      $descricao = strtoupper($_POST['descricao']);
      $docname = $_POST['documento'];
      $obs = $_POST['obs'];
      $dt_entrada = $_POST['dt_insercao'];
      $usuario = $_POST['usuario'];  
      $dt_pag = $_POST['dt_pag']; 
      $val_pag = $_POST['val_pag'];
      $val_desc = $_POST['val_desc'];
      $val_mul = $_POST['val_mul'];
      $status_pag = $_POST['status_pag'];
      $status = $_POST['status'];
      $dt_aut = $_POST['dt_aut'];
      $obs_aut = $_POST['obs_aut'];
      $excluida = $_POST['excluida'];
      $dt_exc = $_POST['dt_exc'];
      $dt_baixa = $_POST['dt_baixa'];
      if($status == 'PENDENTE' && $status_pag == 'ABERTO' && $excluida == 'não'){
        $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,vr_desc,multa,vr_pag) VALUES 
      ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida',$val_desc,$val_mul,$val_pag)";
      }
      if($status == 'AUTORIZADO' && $status_pag == 'ABERTO' && $excluida == 'não'){
        $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,vr_desc,multa,vr_pag,dt_autorizacao) VALUES 
      ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida',$val_desc,$val_mul,$val_pag,'$dt_aut')";
      }
      if($status == 'AUTORIZADO' && $status_pag == 'PAGO' && $excluida == 'não'){
        $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,dt_pag,vr_desc,multa,vr_pag,dt_baixa,dt_autorizacao) VALUES 
      ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida','$dt_pag',$val_desc,$val_mul,$val_pag,'$dt_baixa','$dt_aut')";
      }
      if($status == 'AUTORIZADO' && $status_pag == 'PAGO' && $excluida == 'sim'){
        $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,dt_pag,vr_desc,multa,vr_pag,dt_exclusao,dt_baixa,dt_autorizacao) VALUES 
      ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida','$dt_pag',$val_desc,$val_mul,$val_pag,'$dt_exc','$dt_baixa','$dt_aut')";
      }
   
      if($status == 'AUTORIZADO' && $status_pag == 'ABERTO' && $excluida == 'sim'){
        $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,vr_desc,multa,vr_pag,dt_exclusao,dt_baixa,dt_autorizacao) VALUES 
      ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida',$val_desc,$val_mul,$val_pag,'$dt_exc','$dt_baixa','$dt_aut')";
      }
      if($status == 'PENDENTE' && $status_pag == 'ABERTO' && $excluida == 'sim'){
       $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,vr_desc,multa,vr_pag,dt_exclusao) VALUES 
     ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida',$val_desc,$val_mul,$val_pag,'$dt_exc')";
     }
     if($status == 'DESAUTORIZADO' && $status_pag == 'ABERTO' && $excluida == 'não'){
       $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,vr_desc,multa,vr_pag,dt_autorizacao) VALUES 
     ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida',$val_desc,$val_mul,$val_pag,'$dt_aut')";
     }
     if($status == 'DESAUTORIZADO' && $status_pag == 'ABERTO' && $excluida == 'sim'){
       $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,vr_desc,multa,vr_pag,dt_exclusao,dt_autorizacao) VALUES 
     ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida','$dt_pag',$val_desc,$val_mul,'$dt_exc',,'$dt_aut')";
     }
     if($status == 'DESAUTORIZADO' && $status_pag == 'PAGO' && $excluida == 'sim'){
       $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,dt_pag,vr_desc,multa,vr_pag,dt_exclusao,dt_baixa,dt_autorizacao) VALUES 
     ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida','$dt_pag',$val_desc,$val_mul,$val_pag,'$dt_exc','$dt_baixa','$dt_aut')";
     }
     if($status == 'DESAUTORIZADO' && $status_pag == 'PAGO' && $excluida == 'não'){
       $sql = "INSERT INTO conta_pagar (idcntpagar,fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,dt_pag,vr_desc,multa,vr_pag,dt_baixa,dt_autorizacao) VALUES 
     ($codigo,$fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','$status','$status_pag','$dt_entrada','$excluida','$dt_pag',$val_desc,$val_mul,$val_pag,'$dt_baixa','$dt_aut')";
     }
      
      if($nota_fiscal){
        // $busca = $mysqli->query("SELECT * FROM conta_pagar WHERE num_doc = $num_doc");
        // $lines = $busca->num_rows;
        // if($lines){
        //   $result = array('result' => 'error', 'error' => 'Documento informado anteriormente.','msg' => 'Msg: '.$num_doc);
        // }else{
          $cons = $mysqli->query($sql);
          if($cons){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $nota_fiscal.' '.$num_doc.' '.$descricao.' '.$obs;
            $ins = $mysqli->query("INSERT INTO registros (idcontapagar,tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','conta_pagar','$hoje','$hora','".$usuario.",'$dados')");
            //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
            $result = array('result' => 'sucess', 'datas' => 'Conta a Pagar inserida com sucesso.','msg' => 'Conta a Pagar inserida com sucesso.', 'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        // }
        
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Dados obrigatórios incompletos.', 'campo' => $sql);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // LISTAR CONTAS A PAGAR
    case 35:
             $fornecedor = $_POST['fornecedor'];
             if($_POST['empresa'] == 0){
              $empresa = '';
             }else{
              $empresa = $_POST['empresa'];
             }
             //$tmp = explode(',',$_POST['empresa']);
             //$empresas = "'".implode("','",$tmp)."'";
             $centro = $_POST['centro'];
             $documento = ($_POST['documento']?$_POST['documento']:0);
             $nota_fiscal = ($_POST['nota_fiscal']?$_POST['nota_fiscal']:0);
             $dt_doc_ini = $_POST['dt_doc_ini'];
             $dt_doc_fin = $_POST['dt_doc_fin'];
             $dt_vencimento_ini = $_POST['dt_vencimento_ini'];
             $dt_vencimento_fin = $_POST['dt_vencimento_fin'];
             $dt_pag_ini = $_POST['dt_pag_ini'];
             $dt_pag_fin = $_POST['dt_pag_fin'];
             $dt_ins_ini = $_POST['dt_ins_ini'];
             $dt_ins_fin = $_POST['dt_ins_fin'];
             $status = $_POST['status'];
             $status_pag = $_POST['status_pag'];
             $frm_pag = $_POST['frm_pag'];
             if($_POST['descricao']){
              $descricao = '%'.$_POST['descricao'].'%';
             }else{
              $descricao = $_POST['descricao'];
             }
             $codigos = $_POST['codigos'];
             $excluida = $_POST['excluida'];
         $where = Array();    

         if($dt_vencimento_ini && !$dt_vencimento_fin){
           $dt_vencimento_fin = date("Y-m-d");
         }

            //echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

      if($fornecedor != 'Selecione' && $fornecedor != null){
        $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
        if($frn){
          $frn_res = $frn->fetch_array();
          $frn_val = ($frn_res['idforn']?$frn_res['idforn']:0);
          $where[] = "`fk_fornecedor` = {$frn_val}";
        }
        
      } 
      if ($frm_pag != 'Selecione' && $frm_pag != null){
        $frmpag = $mysqli->query("SELECT * FROM frm_pagamento WHERE pagamento = '$frm_pag'");
        if($frmpag){
          $frm_res = $frmpag->fetch_array();
          $frm_val = ($frm_res['idfrmpag']?$frm_res['idfrmpag']:0);
          $where[] = "`fk_frmpag` = {$frm_val}";
        }
      }
      if($empresa){
        $where[] = "`fk_empresa` IN ({$empresa})";
      }
      if($codigos){
        $where[] = "`idcntpagar` IN ({$codigos})";
      }
      if($centro != 'Selecione' && $centro != null){
        $cnt = $mysqli->query("SELECT idcentro FROM centro_custo WHERE centro = '$centro'");
        if($cnt){
          $cnt_res = $cnt->fetch_array();
          $cnt_val = ($cnt_res['idcentro']?$cnt_res['idcentro']:0);
          $where[] = "`fk_centro` = {$cnt_val}";
        }
      }
      if($documento){
        $where[] = "`num_doc` = $documento";
      }
      if($nota_fiscal){
        $where[] = "`num_nota` = $nota_fiscal";
      }
      if($dt_doc_ini && $dt_doc_fin){
        $where[] = "`dt_doc` between '{$dt_doc_ini}' AND '$dt_doc_fin'";
      } 
      if (($dt_vencimento_ini && $dt_vencimento_fin)){
        $where[] = "`dt_vencimento` between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
      } 
      if ($dt_pag_ini && $dt_pag_fin){
        $where[] = "`dt_pag` between '$dt_pag_ini' AND '$dt_pag_fin'"; 
      } 
      if ($dt_ins_ini && $dt_ins_fin){
        $where[] = "`dt_entrada` between '$dt_ins_ini' AND '$dt_ins_fin'"; 
      } 
      if ($status != null && $status != 'Selecione'){
        $where[] = "`status_autorizacao` =  '$status'";
      }
      if ($status_pag != null && $status_pag != 'Selecione'){
        $where[] = "`status_pag` =  '$status_pag'";
      }
      if($descricao){
        $where[] = "`descricao` like '%$descricao%'";
      }
      if($excluida){
        $where[] = "`excluida` = '$excluida'";
      }
        //echo $empresa;
        
        $sql = "SELECT * FROM  conta_pagar";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
        //echo $sql;
        $sel = $mysqli->query($sql);
        //echo $mysqli->error;
      
        while($res = $sel->fetch_array()){
          @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
          @$mat = $sel2->fetch_array();
          @$ctc = $mysqli->query("SELECT * FROM centro_custo WHERE idcentro = ".$res['fk_centro']."");
          @$ctc_res = $ctc->fetch_array();
          @$frnc = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = ".$res['fk_fornecedor']."");
          @$frnc_res = $frnc->fetch_array();
          @$frmpagt = $mysqli->query("SELECT * FROM frm_pagamento WHERE idfrmpag = ".$res['fk_frmpag']."");
          @$frmp_res = $frmpagt->fetch_array();
          $arr[] = array('id_conta' => $res['idcntpagar'], 'documento' => ($res['documento']), 'comprovante' => $res['comprovante'], 'fornecedor' => ($frnc_res['nome_fantasia']), 'fk_forn' => $res['fk_fornecedor'], 'fk_emp' => $res['fk_empresa'], 'fk_frmpag' => $res['fk_frmpag'], 'fk_centro' => $res['fk_centro'],'empresa' => ($mat['nome_fantasia']), 'centro' => ($ctc_res['centro']), 'num_nota' => $res['num_nota'], 'num_doc' => $res['num_doc'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'dt_vencimento' => $res['dt_vencimento'],'frm_pag' => ($frmp_res['pagamento']),'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'obs_status' => ($res['obs_status']), 'status_autorizacao' => $res['status_autorizacao'],'dt_autorizacao' => $res['dt_autorizacao'],'status_pag' => $res['status_pag'],'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['vr_pag']?$res['vr_pag']:0.00),'multa' => ($res['multa']?$res['multa']:0.00),'vr_desc' => ($res['vr_desc']?$res['vr_desc']:0.00),'obs_pag' => ($res['obs_pag']));
        }
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$sql, 'campo' => $centro);
        }
      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //ATUALIZAR STATUS AUTORIZACAO CONTA A PAGAR
    case 36:
      $cod = $_POST['codigos'];
      $obs = $_POST['obs'];
      $hoje = date("Y-m-d");
      $usuario = $_POST['usuario'];
      $hora = date("H:i:s");
      if($cod){
        $cons = $mysqli->query("UPDATE conta_pagar SET status_autorizacao = 'AUTORIZADO', dt_autorizacao = '$hoje', obs_status = '$obs', login_autorizacao = '$usuario', hr_autorizacao = '$hora' WHERE idcntpagar IN ($cod)");
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $data = 'Status auterado para AUTORIZADO códigos: '.$cod;
          $dados = str_replace(',','-',$data);
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','".$usuario."','$dados','novo')");
          $result = 'Conta a Pagar Autorizada!'.$mysqli->error;
        }else{
          $result =  'Erro ao Autorizar Conta a Pagar. - '.$mysqli->error;
        }
        
      }else{
        $result =  'Erro ao Autorizar Conta, Dados incompltos.'.$mysqli->error;
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //ATUALIZAR STATUS DESAUTORIZACAO CONTA A PAGAR
    case 37:
      $cod = $_POST['codigos'];
      $obs = $_POST['obs'];
      $hoje = date("Y-m-d");
      $usuario = $_POST['usuario'];
      $hora = date("H:i:s");

      if($cod){
        $cons = $mysqli->query("UPDATE conta_pagar SET status_autorizacao = 'DESAUTORIZADO', dt_autorizacao = '$hoje', obs_status = '$obs', login_autorizacao = '$usuario', hr_autorizacao = '$hora' WHERE idcntpagar IN ($cod)");
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $data = 'Status auterado para DESAUTORIZADO códigos: '.$cod;
          $dados = str_replace(',','-',$data);
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','".$usuario."','$dados','novo')");
          $result = 'Conta a Pagar Desautorizada!'. $mysqli->error;
        }else{
          $result = 'Erro ao Desautorizar Conta a Pagar. - '. $mysqli->error;
        }
        
      }else{
        $result = 'Erro ao Desautorizar Conta, Dados incompltos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //QUITAR CONTA A PAGAR SELECIONADAS
    case 38:
      $cod = $_POST['codigos'];
      $obs = $_POST['obs'];
      $multa = str_replace(',','.',str_replace('.','',$_POST['mul']));
      $desc = str_replace(',','.',str_replace('.','',$_POST['desc']));
      $vr_pago = str_replace(',','.',str_replace('.','',$_POST['vrpag']));
      $dt_pag = $_POST['dt_pag'];
      $comprovante = $_POST['comprovante'];
      $usuario = $_POST['usuario'];
     
      
      if($cod){
        $select = $mysqli->query("SELECT * FROM conta_pagar WHERE idcntpagar IN ($cod)");
        while($res = $select->fetch_array()){
          $sele = $mysqli->query("SELECT * FROM conta_pagar WHERE idcntpagar = ".$res['idcntpagar']."");
          if($sele){
            $dt = $sele->fetch_array();
            if($dt['dt_autorizacao'] == '0000-00-00' || $dt['dt_autorizacao'] == null){
              $dtsql = ", `dt_autorizacao` = '$dt_pag'";
            }
          }
          $sql = "UPDATE conta_pagar SET status_pag = 'PAGO', status_autorizacao = 'AUTORIZADO', comprovante = '$comprovante', obs_pag = '$obs', login_baixa = '$usuario', hr_baixa = '$hora', dt_pag = '$dt_pag', vr_desc = ".$res['vr_desc'].", multa = ".$res['multa'].", vr_pag = ".$res['val_doc']."".$dtsql." WHERE idcntpagar = ".$res['idcntpagar']."";
          $cons = $mysqli->query($sql);
          if(!$cons){
            $erro .= $res['idcntpagar'].',';
          }else{
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $data = 'Quitação códigos: '.$cod;
            $dados = str_replace(',','-',$data);
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','".$usuario."','$dados','novo')");
          }
        }
        
        
        if(!$erro){
          $result = 'Contas a Pagar Quitadas!';
        }else{
          $result = 'Erro ao Quitar Contas a Pagar de números: '.$erro.' erro: '.$sql;
        }
        
      }else{
        $result = 'Erro ao Quitar Conta, Dados incompltos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //ATUALIZAR STATUS EXCLUIDO CONTA A PAGAR
    case 39:
      $cod = $_POST['codigos'];
      //$obs = $_POST['obs'];
      $hoje = date("Y-m-d");
      $hora = date('H:i:s');
      $usuario = $_POST['usuario'];

      if($cod){
        $cons = $mysqli->query("UPDATE conta_pagar SET excluida = 'sim', dt_exclusao = '$hoje', login_exclusao = '$usuario', hr_exclusao = '$hora' WHERE idcntpagar IN ($cod)");
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Exclusão da conta de número: '.$cod;
          //$dados = str_replace(',','-',$data);
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','".$usuario."','$dados','novo')");
          $result = 'Conta a Pagar excluída!'. $mysqli->error;
        }else{
          $result = 'Erro ao excluir Conta a Pagar. - '. $mysqli->error;
        }
        
      }else{
        $result = 'Erro ao excluir Conta, Dados incompletos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR CONTA A PAGAR
    case 40:
      //print_r($_POST);
      $nota_fiscal = $_POST['nota_fiscal'];
      $fornecedor = ucwords($_POST['fornecedor']);
      $num_doc = ($_POST['num_doc']);
      $dt_doc = $_POST['dt_doc'];
      $fk_empresa = $_POST['fk_empresa'];
      //$parcela = $_POST['parcela'];
      $centro = $_POST['centro'];
      //$val_doc = $_POST['val_doc'];
      $val_doc = $_POST['val_doc'];
      $val_multa = $_POST['multa'];
      $val_desc = $_POST['desconto'];
      $vr_pago = $_POST['vr_pago'];
      $dt_vencimento = $_POST['dt_vencimento'];
      $frmpag = $_POST['frmpag'];
      $descricao = strtoupper($_POST['descricao']);
      $docname = $_POST['documento'];
      $obs = $_POST['obs'];
      $dt_entrada = date("Y-m-d");
      $usuario = $_POST['usuario'];
      $codigo = $_POST['codigo'];

      $update = Array();
      $qr = "SELECT * FROM conta_pagar WHERE idcntpagar = $codigo";

      $sel = $mysqli->query($qr);
      $flag = 0;
      if($sel){
        $res = $sel->fetch_array();
        if($nota_fiscal && $res['num_nota'] != $nota_fiscal){
          $update[] = "`num_nota` = $nota_fiscal";
          $campos .= ' Número Nota';
          $flag = 1;
        }
        if($fornecedor && $res['fk_fornecedor'] != $fornecedor){
          $update[] = "`fk_fornecedor` = $fornecedor";
          $campos .= ' Fornecedor';
          $flag = 1;
        }
        if($num_doc && $res['num_doc'] != $num_doc){
          $update[] = "`num_doc` = '$num_doc'";
          $campos .= ' Número Documento';
          $flag = 1;
        }
        if($dt_doc && $res['dt_doc'] != $dt_doc){
          $update[] = "`dt_doc` = '$dt_doc'";
          $campos .= ' Data do Documento';
          $flag = 1;
        }
        if($fk_empresa && $res['fk_empresa'] != $fk_empresa){
          $update[] = "`fk_empresa` = $fk_empresa";
          $campos .= ' Empresa';
          $flag = 1;
        }
        if($centro && $res['fk_centro'] != $centro){
          $update[] = "`fk_centro` = $centro";
          $campos .= ' Centro de Custo';
          $flag = 1;
        }
        if($val_doc && $res['val_doc'] != $val_doc){
          $update[] = "`val_doc` = $val_doc";
          $campos .= ' Valor Documento';
          $flag = 1;
        }
        if($val_multa && $res['multa'] != $val_multa){
          $update[] = "`multa` = $val_multa";
          $campos .= ' Valor Multa';
          $flag = 1;
        }
        if($val_desc && $res['vr_desc'] != $val_desc){
          $update[] = "`vr_desc` = $val_desc";
          $campos .= ' Valor Desconto';
          $flag = 1;
        }
        if($vr_pago && $res['vr_pag'] != $vr_pago){
          $update[] = "`vr_pag` = $vr_pago";
          $campos .= ' Valor Pago';
          $flag = 1;
        }
        if($dt_vencimento && $res['dt_vencimento'] != $dt_vencimento){
          $update[] = "`dt_vencimento` = '$dt_vencimento'";
          if($dt_vencimento >= $res['dt_vencimento'] && $res['status_pag'] == 'ATRASADO'){
            $update[] = "`status_pag` = 'ABERTO'";
          }
          $campos .= ' Vencimento';
          $flag = 1;
        }
        if($frmpag && $res['fk_frmpag'] != $frmpag){
          $update[] = "`fk_frmpag` = $frmpag";
          $campos .= ' Forma de Pagamento';
          $flag = 1;
        }
        if($descricao && $res['descricao'] != $descricao){
          $update[] = "`descricao` = '$descricao'";
          $campos .= ' Descricao';
          $flag = 1;
        }
        if($docname && $docname && $res['documento'] != $docname){
          $update[] = "`documento` = '$docname'";
          $campos .= ' Arquivo de Documento';
          $flag = 1;
        }
        if($obs && $res['obs'] != $obs){
          $update[] = "`obs` = '$obs'";
          $campos .= ' Observação';
          $flag = 1;
        }

      }
      if($flag == 1){
        $sql = "UPDATE conta_pagar SET ".implode(',',$update)." WHERE idcntpagar = $codigo";
      
        $cons = $mysqli->query($sql);
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Campos alterados:'.$campos;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','$usuario','$dados','novo')");
          $result = array('result' => 'sucess', 'msg' => 'Conta a Pagar atualizada com sucesso.', 'campo' => $campos, 'sqlerror' => $mysqli->error);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      }else{
        $result = array('result' => 'sucess',  'msg' => 'Nenhuma informação alterada', 'campo' => $res['dt_vencimento']);
      }
      
        
        
      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR FORMA DE RECEBIMENTO
    case 41:
      //print_r($_POST);
      $recebimento = strtoupper($_POST['recebimento']);
      $codigo = strtoupper($_POST['codigo']);
      // $id = $_POST['codigo'];
      $empresa = $_POST['empresa'];
      $obs = $_POST['obs'];
      $usuario = $_POST['usuario'];
      $sql = "INSERT INTO frm_recebimento (fk_empresa,recebimento, codigo,ativo) VALUES ($empresa,'$recebimento','$codigo','Sim')";
      $sele = $mysqli->query("SELECT * FROM frm_recebimento WHERE recebimento = '$recebimento' AND codigo = '$codigo' AND fk_empresa = $empresa");
      $count = $sele->num_rows;
      if($count == 0){
        if($recebimento && $codigo){
          $sel = $mysqli->query($sql);
          if($sel){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $recebimento.' '.$codigo;
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','frm_recebimento','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'sucess', 'datas' => 'Forma de recebimento inserido com sucesso.', 'msg' => 'Forma de recebimento inserido com sucesso.', 'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Forma de recebimento.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        }else{
          $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Dados obrigatórios incompletos.', 'campo' => $sql);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Não foi possível cadastrar. Código já cadastrado!.','msg' => 'Não foi possível cadastrar. Código já cadastrado!.', 'campo' => $sql);
      }
      

      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR FORMA DE RECEBIMENTO
    case 42:
      $recebimento = $_POST['recebimento'];
      $codigo = $_POST['codigo'];
      $ativo = $_POST['ativo'];
      $idfrmrec = $_POST['idfrmrec'];
      $where = Array();

      if($recebimento){
        $where[] = "`recebimento` = '$recebimento'";
      }
      if($codigo){
        $where[] = "`codigo` = '$codigo'";
      }
      if($ativo){
        $where[] = "`ativo` = '$ativo'";
      }
      if($idfrmrec){
        $where[] = "`idfrmrec` = $idfrmrec";
      }
      
    
      $sql = "SELECT * FROM  frm_recebimento";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
      
      $query = $mysqli->query($sql);
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Forma de recebimento não encontrado.','campo' => $ativo);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idfrmrec' => $res['idfrmrec'],'codigo' => $res['codigo'],'recebimento' => ($res['recebimento']),'ativo' => $res['ativo'],'campo' => $centro);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }else{
            $result = array('result' => 'error', 'error' => 'Nenhuma forma de recebimento encontrada');
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR FORMA DE RECEBIMENTO
    case 43:
      //print_r($_POST);
      $recebimento = ucwords($_POST['recebimento']);
      $codigo = $_POST['codigo'];
      $ativo = $_POST['ativo'];
      $idfrmrec = $_POST['idfrmrec'];
      $usuario = $_POST['usuario'];

      if($codigo && $recebimento && $ativo){
        $sel = $mysqli->query("UPDATE frm_recebimento SET codigo = '$codigo', recebimento = '$recebimento', ativo = '$ativo' WHERE idfrmrec = $idfrmrec");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $recebimento.' '.$codigo.' '.$ativo;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','frm_recebimento','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Forma de recebimento atualizada com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Forma de recebimento.', 'msg' => $mysqli->error, 'campo' => $centro);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$ativo);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR FORMA DE RECEBIMENTO
    case 44:
      $idfrmrec = $_POST['idfrmrec'];
      $usuario = $_POST['usuario'];

      if($idfrmrec){
        $del = $mysqli->query("DELETE FROM frm_recebimento WHERE idfrmrec = $idfrmrec");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','frm_recebimento','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Fora de recebimento excluida!.', 'msg' => $mysqli->error, 'campo' => $idcent);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao deletar Forma de recebimento!.', 'msg' => $mysqli->error, 'campo' => $idcent);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar Dados Obrigatórios Ausentes!.', 'msg' => $mysqli->error, 'campo' => $idcent);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR CONTA A RECEBER
    case 45:
      //print_r($_POST);
      $codigo = $_POST['codigo'];
  $fk_empresa = $_POST['fk_empresa'];
  $cliente = $_POST['cliente'];
  if(!$cliente){
    $cliente = 0;
  }
  $hr_entr = $_POST['hr_entrada'];
  $login_ins = $_POST['login_entr'];
  $hr_baixa = $_POST['hr_baixa'];
  $login_baixa = $_POST['login_baixa'];
  $num_doc = $_POST['num_doc'];
  $num_doc = $_POST['num_doc'];
  $dt_doc = $_POST['dt_doc'];
  $dt_vencimento = $_POST['dt_vencimento'];
  $val_serv = $_POST['val_serv'];
  $val_mul = $_POST['val_mul'];
  $val_desc = $_POST['val_desc'];
  $val_rec = $_POST['val_rec'];
  $val_ret = $_POST['val_ret'];
  $centro = $_POST['centro'];
  if(!$centro){
    $centro = 0;
  }
  $frm_rec = $_POST['frm_rec'];
  $val_doc = $_POST['val_doc'];
  $val_extra = $_POST['val_extra'];
  $val_fat = $_POST['val_fat'];
  $irrf = $_POST['val_irrf'];
  $pis = $_POST['val_pis'];
  $cofins = $_POST['val_cofins'];
  $inss = $_POST['val_inss'];
  $iss = $_POST['val_iss'];
  $csll = $_POST['val_csll'];
  $iss_ret = $_POST['iss_ret'];
  $descricao = $_POST['descricao'];
  $reter = $_POST['reter'];
  $arquivo = $_POST['documento'];
  if(!$arquivo){
    $arquivo = "N/I";
  }
  $obs = $_POST['obs'];
  $obs_rec = $_POST['obs_rec'];
  $dt_entrada = date("Y-m-d");
  $dt_rec = $_POST['dt_rec'];
  $status = $_POST['status'];
  $dt_baixa = $_POST['dt_baixa'];
  $usuario = $_POST['usuario'];
  $num = rand(1, 9999);
  $sql = "INSERT INTO conta_receber (idcntrec,val_multa,val_desc,val_pag,fk_frmrec,iss_ret,obs_pag,dt_pag,dt_baixa,fk_empresa, fk_cliente, fk_centro, num_doc, dt_doc, val_doc, dt_venc, val_servico, val_ret, val_extra, val_fat, documento, descricao,obs, status, irrf, pis, cofins, csll, inss, iss, reter, dt_entrada,hr_insercao,login_insercao,login_baixa,hr_baixa) 
          VALUES ($codigo,$val_mul,$val_desc,$val_rec,$frm_rec,$iss_ret,'$obs_rec','$dt_rec','$dt_baixa',$fk_empresa,$cliente,$centro,'$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$val_serv,$val_ret,$val_extra,$val_fat,'$arquivo','$descricao','$obs','$status',$irrf,$pis,$cofins,$csll,$inss,$iss,'$reter','$dt_entrada','$hr_entr','$login_ins','$login_baixa','$hr_baixa')";
  // if($fk_empresa && $cliente && $val_serv && $val_fat && $val_doc && $num_doc  && $dt_doc && $centro && $dt_vencimento){
    // $busca = $mysqli->query("SELECT * FROM conta_receber WHERE num_doc = $num_doc");
    // $lines = $busca->num_rows;
    // if($lines){
    //   $result = array('result' => 'error', 'error' => 'Documento informado anteriormente.','msg' => 'Msg: '.$num_doc);
    // }else{
      $cons = $mysqli->query($sql);
      if($cons){
        $hoje = date("Y-m-d");
        $hora = date("H:i");
        $dados = $cliente.' '.$num_doc.' '.$descricao.' '.$obs;
        $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','conta_receber','$hoje','$hora','".$usuario.",'$dados')");
        //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Receber.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
        $result = array('result' => 'sucess', 'datas' => 'Conta a Receber inserida com sucesso.', 'msg' => 'Conta a Receber inserida com sucesso.', 'campo' => $sql);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Receber.', 'msg' => $mysqli->error, 'campo' => $sql);
      }
    //}
    
  // }else{
  //   //$result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$fk_empresa.' && '.$cliente.' && '.$val_serv.' && '.$val_fat.' && '.$val_doc.' && '.$num_doc .' && '.$dt_doc.' && '.$centro.' && '.$dt_vencimento);
  //   $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos!', 'msg' => 'Dados obrigatórios incompletos!', 'campo' => $sql);
  // }
  echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // LISTAR CONTAS A RECEBER
    case 46:
      $fk_empresa = $_POST['empresa'];
      $cliente = $_POST['cliente'];
      $num_doc = $_POST['num_doc'];
      $dt_doc_ini = $_POST['dt_doc_ini'];
      $dt_doc_fin = $_POST['dt_doc_fin'];
      $dt_vencimento_ini = $_POST['dt_vencimento_ini'];
      $dt_vencimento_fin = $_POST['dt_vencimento_fin'];
      $centro = $_POST['centro'];
      $status = $_POST['status'];
      $reter = $_POST['reter'];
      $documento = $_POST['documento'];
      $frm_rec = $_POST['frm_rec'];
      $codigos = $_POST['codigos'];
      $usuario = $_POST['usuario'];
      $num_bol = $_POST['num_bol'];
    //   $val_pag = $_POST['val_pag'];
             
      $where = Array();

      if($dt_vencimento_ini && !$dt_vencimento_fin){
        $dt_vencimento_fin = date("Y-m-d");
      }
      //echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

      if($cliente){
        $where[] = "`fk_cliente` = {$cliente}";
      }
    //   if($val_pag){
    //     $where[] = "`val_pag` = {$val_pag}";
    //   } 
      if ($frm_rec){
        $where[] = "`fk_frmrec` = {$frm_rec}";
      }
      if($empresa){
        $where[] = "`fk_empresa` IN ({$empresa})";
      }
      if($codigos){
        $where[] = "`idcntrec` IN ({$codigos})";
      }
      if($centro){
        $where[] = "`fk_centro` = {$centro}";
      }
      if($documento){
        $where[] = "`num_doc` = $documento";
      }
      if($reter){
        $where[] = "`reter` = '$reter'";
      }
      if($num_bol){
        $where[] = "`num_boleto` = '$num_bol'";
      }
      if($dt_doc_ini && $dt_doc_fin){
        $where[] = "`dt_doc` between '{$dt_doc_ini}' AND '$dt_doc_fin'";
      } 
      if ($dt_vencimento_ini && $dt_vencimento_fin){
        $where[] = "`dt_venc` between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
      } 
     
      if ($status){
        $where[] = "`status` =  '$status'";
      }
    
        
        //echo $empresa;
        
        $sql = "SELECT * FROM conta_receber";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
        //echo $sql;
        $cons = $mysqli->query($sql);
        //echo $mysqli->error;
        if($cons){
          while($res = $cons->fetch_array()){
            @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            if($sel2){@$mat = $sel2->fetch_array();}
            
            @$ctc = $mysqli->query("SELECT * FROM centro_custo WHERE idcentro = ".$res['fk_centro']."");
            if($ctc){@$ctc_res = $ctc->fetch_array();}
            
            @$frnc = $mysqli->query("SELECT * FROM clientes WHERE idcli = ".$res['fk_cliente']."");
            if($frn){@$frnc_res = $frnc->fetch_array();}
            
            $count = 0;
            $rec = '';
            if($res['fk_frmrec'] != null){
              @$frmpagt = $mysqli->query("SELECT * FROM frm_recebimento WHERE idfrmrec = ".$res['fk_frmrec']."");
              if($frmpagt){
                @$frmp_res = $frmpagt->fetch_array();
                $rec = $frmp_res['recebimento'];
                $count++;
              }
              
            }
            
            $arr[] = array('id_conta' => $res['idcntrec'], 'documento' => ($res['documento']), 'comprovante' => ($res['comprovante']), 'cliente' => ($frnc_res['cliente']), 'cpf_cnpj' => ($frnc_res['cpf_cnpj']), 'cidade' => ($frnc_res['cidade']), 'bairro' => ($frnc_res['bairro']), 'endereco' => ($frnc_res['endereco']), 'cep' => ($frnc_res['cep']), 'uf' => ($frnc_res['uf']), 'fone' => ($frnc_res['fone']), 'fk_cli' => $res['fk_cliente'], 'fk_emp' => $res['fk_empresa'], 'fk_frmrec' => $res['fk_frmrec'], 'fk_centro' => $res['fk_centro'],'empresa' => ($mat['razao_social']), 'centro' => ($ctc_res['centro']), 'num_doc' => $res['num_doc'],'val_servico' => $res['val_servico'],'val_ret' => $res['val_ret'],'val_fat' => $res['val_fat'],'val_extra' => $res['val_extra'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'csll' => $res['csll'],'inss' => $res['inss'],'iss' => $res['iss'],'dt_vencimento' => $res['dt_venc'],'frm_rec' => $rec,'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'status' => $res['status'],'reter' => ($res['reter']), 'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['val_pag']?$res['val_pag']:0.00),'multa' => ($res['val_multa']?$res['val_multa']:0.00),'vr_desc' => ($res['val_desc']?$res['val_desc']:0.00),'obs_pag' => ($res['obs_pag']));
          }
        }
        
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr, 'msg' => $sql);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao listar dados.','msg' => 'Nenhum dado encontrado: '.$sql);
        }
      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //QUITAR CONTA A RECEBER
    case 47:
      $cod = $_POST['codigos'];
      $obs = $_POST['obs'];
      $multa = str_replace(',','.',str_replace('.','',$_POST['mul']));
      $desc = str_replace(',','.',str_replace('.','',$_POST['desc']));
      $vr_pago = str_replace(',','.',str_replace('.','',$_POST['vrpag']));
      $dt_pag = $_POST['dt_pag'];
      $comprovante = $_POST['comprovante'];
      if(!$comprovante){
        $comprovante = 'N/I';
      }
      $usuario = $_POST['usuario'];
      $frmrec = $_POST['frmpag'];
      
      

     
      
      if($cod){
        // $select = $mysqli->query("SELECT * FROM conta_receber WHERE idcntrec = $cod");
        // while($res = $select->fetch_array()){
        //   $sele = $mysqli->query("SELECT * FROM conta_receber WHERE idcntrec = ".$res['idcntrec']."");
        //   if($sele){
        //     $dt = $sele->fetch_array();
        //     if($dt['dt_autorizacao'] == '0000-00-00' || $dt['dt_autorizacao'] == null){
        //       $dtsql = ", `dt_autorizacao` = '$dt_pag'";
        //     }
        //   }
        //   $sql = "UPDATE conta_receber SET status = 'RECEBIDO', comprovante = '$comprovante', obs_pag = '$obs', dt_pag = '$dt_pag', vr_desc = ".$desc.", multa = ".$multa.", vr_pag = ".$vr_pago."  WHERE idcntrec = ".$res['idcntrec']."";
        //   $cons = $mysqli->query($sql);
        //   if(!$cons){
        //     $erro .= $mysli->error;
        //   }
        // }
        $sql = "UPDATE conta_receber SET status = 'RECEBIDO', comprovante = '$comprovante', obs_pag = '$obs', fk_frmrec = $frmrec, dt_pag = '$dt_pag', val_desc = ".$desc.", val_multa = ".$multa.", val_pag = ".$vr_pago."  WHERE idcntrec = ".$cod."";
        $cons = $mysqli->query($sql);
        if(!$cons){
          $result = 'Erro ao Quitar Contas a Pagar de números: '.$cod.' erro: '.$mysqli->error.'Sql: '.$sql;
        }else{
          $result = 'Contas a Pagar Quitadas!';
        }
        $hoje = date("Y-m-d");
        $hora = date("H:i");
        $dados = 'Quitação códigos: '.$cod;
        //$dados = str_replace(',','-',$data);
        $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_receber','$hoje','$hora','".$usuario."','$dados','novo')");
        
      }else{
        $result = 'Erro ao Quitar Conta, Dados incompltos.'.$cod;
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    
    // EDITAR CONTA A RECEBER
    case 48:
      //print_r($_POST);
      $fk_empresa = $_POST['fk_empresa'];
      $cliente = $_POST['cliente'];
      if(!$cliente){
        $cliente = 0;
      }
      $num_doc = $_POST['num_doc'];
      $dt_doc = $_POST['dt_doc'];
      $dt_vencimento = $_POST['dt_vencimento'];
      $val_serv = $_POST['val_serv'];
      $val_ret = $_POST['val_ret'];
      $centro = $_POST['centro'];
      if(!$centro){
        $centro = 0;
      }
      $val_doc = $_POST['val_doc'];
      $val_extra = $_POST['val_extra'];
      $val_fat = $_POST['val_fat'];
      $irrf = $_POST['val_irrf'];
      $pis = $_POST['val_pis'];
      $cofins = $_POST['val_cofins'];
      $inss = $_POST['val_inss'];
      $iss = $_POST['val_iss'];
      $csll = $_POST['val_csll'];
      $descricao = strtoupper($_POST['descricao']);
      $reter = $_POST['reter'];
      $docname = $_POST['documento'];
      $obs = $_POST['obs'];
      $dt_entrada = date("Y-m-d");
      $usuario = $_POST['usuario'];
      $codigo = $_POST['codigo'];
      $frmpag = $_POST['frmpag'];
      $status = $_POST['status'];

      $update = Array();
      $qr = "SELECT * FROM conta_receber WHERE idcntrec = $codigo";

      $sel = $mysqli->query($qr);
      $flag = 0;
      if($sel){
        $res = $sel->fetch_array();
        if($res['fk_empresa'] != $fk_empresa){
          $update[] = "`fk_empresa` = $fk_empresa";
          $campos .= ' Empresa';
          $flag = 1;
        }
        if($res['fk_cliente'] != $fornecedor){
          $update[] = "`fk_cliente` = $cliente";
          $campos .= ' Cliente';
          $flag = 1;
        }
        if($res['fk_centro'] != $centro){
          $update[] = "`fk_centro` = $centro";
          $campos .= ' Centro de Custo';
          $flag = 1;
        }
        if($res['num_nota'] != $nota_fiscal){
          $update[] = "`num_nota` = $nota_fiscal";
          $campos .= ' Número Nota';
          $flag = 1;
        }
        
        if($res['num_doc'] != $num_doc){
          $update[] = "`num_doc` = $num_doc";
          $campos .= ' Número Documento';
          $flag = 1;
        }
        if($res['dt_doc'] != $dt_doc){
          $update[] = "`dt_doc` = '$dt_doc'";
          $campos .= ' Data do Documento';
          $flag = 1;
        }
        if($res['val_servico'] != $val_serv){
          $update[] = "`val_servico` = $val_serv";
          $campos .= ' Valor Serviço';
          $flag = 1;
        }
        if($res['val_ret'] != $val_ret){
          $update[] = "`val_ret` = $val_ret";
          $campos .= ' Valor Retroativo';
          $flag = 1;
        }
        if($res['val_extra'] != $val_extra){
          $update[] = "`val_extra` = $val_extra";
          $campos .= ' Valor Extra';
          $flag = 1;
        }
        if($res['val_fat'] != $val_fat){
          $update[] = "`val_fat` = $val_fat";
          $campos .= ' Valor Fatura';
          $flag = 1;
        }
        if($res['pis'] != $pis){
          $update[] = "`pis` = $pis";
          $campos .= ' Valor Pis';
          $flag = 1;
        }
        if($res['cofins'] != $cofins){
          $update[] = "`cofins` = $cofins";
          $campos .= ' Valor Cofins';
          $flag = 1;
        }
        if($res['irrf'] != $irrf){
          $update[] = "`irrf` = $irrf";
          $campos .= ' Valor Irrf';
          $flag = 1;
        }
        if($res['csll'] != $csll){
          $update[] = "`csll` = $csll";
          $campos .= ' Valor Csll';
          $flag = 1;
        }
        if($res['iss'] != $iss){
          $update[] = "`iss` = $iss";
          $campos .= ' Valor Documento';
          $flag = 1;
        }
        if($res['reter'] != $reter){
          $update[] = "`reter` = '$reter'";
          $campos .= 'Reter Iss';
          $flag = 1;
        }
        if($res['val_doc'] != $val_doc){
          $update[] = "`val_doc` = $val_doc";
          $campos .= ' Valor Documento';
          $flag = 1;
        }
        if($res['dt_venc'] != $dt_vencimento){
          $update[] = "`dt_venc` = '$dt_vencimento'";
          $campos .= ' Vencimento';
          $flag = 1;
        }
        if($res['fk_frmpag'] != $frmpag){
          $update[] = "`fk_frmpag` = $frmpag";
          $campos .= ' Forma de Pagamento';
          $flag = 1;
        }
        if($res['descricao'] != $descricao){
          $update[] = "`descricao` = '$descricao'";
          $campos .= ' Descricao';
          $flag = 1;
        }
        if($docname && $res['documento'] != $docname){
          $update[] = "`documento` = '$docname'";
          $campos .= ' Arquivo de Documento';
          $flag = 1;
        }
        if($res['obs'] != $obs){
          $update[] = "`obs` = '$obs'";
          $campos .= ' Observação';
          $flag = 1;
        }
        if($res['fk_frmrec'] != $frmpag){
          $update[] = "`fk_frmrec` = '$frmpag'";
          $campos .= ' Forma de Recebimento';
          $flag = 1;
        }

      }
      if($flag == 1){
        $sql = "UPDATE conta_receber SET ".implode(',',$update)." WHERE idcntrec = $codigo";
      
        $cons = $mysqli->query($sql);
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Campos alterados:'.$campos;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_receber','$hoje','$hora','$usuario','$dados','novo')");
          $result = array('result' => 'sucess', 'msg' => 'Conta a Receber atualizada com sucesso.', 'campo' => $qr, 'sqlerror' => $mysqli->error);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Conta a Receber.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      }else{
        $result = array('result' => 'sucess',  'msg' => 'Nenhuma informação alterada', 'campo' => $qr);
      }
      
      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //ATUALIZAR STATUS EXCLUIDO CONTA A RECEBER
    case 49:
      $cod = $_POST['codigos'];
      //$obs = $_POST['obs'];
      $hoje = date("Y-m-d");
      $usuario = $_POST['usuario'];

      if($cod){
        $cons = $mysqli->query("DELETE FROM conta_receber WHERE idcntrec IN ($cod)");
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Exclusão da conta de número: '.$cod;
          //$dados = str_replace(',','-',$data);
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('DELETE','conta_receber','$hoje','$hora','".$usuario."','$dados','novo')");
          $result = 'Conta a Receber excluída!'. $mysqli->error;
        }else{
          $result = 'Erro ao excluir Conta a Receber. - '. $mysqli->error;
        }
        
      }else{
        $result = 'Erro ao excluir Conta, Dados incompletos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //QUITAR CONTA A PAGAR
    case 50:
      $cod = $_POST['codigos'];
      $obs = $_POST['obs'];
      $multa = $_POST['mul'];
      $desc = $_POST['desc'];
      $vr_pago = $_POST['vrpag'];
      $dt_pag = $_POST['dt_pag'];
      $comprovante = $_POST['comprovante'];
      $usuario = $_POST['usuario'];
      $sel  = $mysqli->query("SELECT * FROM conta_pagar WHERE idcntpagar = $cod");
      if($sel){
        $res = $sel->fetch_array();
        if($res['dt_autorizacao'] == null || $res['dt_autorizacao'] == '' || $res['dt_autorizacao'] == '0000-00-00'){
          $dt = ", dt_autorizacao = '$dt_pag'";
        }else{
          $dt = '';
        }
      }
      if($cod){
    
          $sql = "UPDATE conta_pagar SET status_pag = 'PAGO', status_autorizacao = 'AUTORIZADO', comprovante = '$comprovante', obs_pag = '$obs', dt_baixa = '$dt_pag', dt_pag = '$dt_pag', vr_desc = ".$desc.", multa = ".$multa.", vr_pag = ".$vr_pago."".$dt." WHERE idcntpagar = ".$res['idcntpagar']."";
          $cons = $mysqli->query($sql);
          if(!$cons){
            $result = 'Erro ao Quitar Conta a Pagar: '.$cod.' erro: '.$mysqli->error;
          }else{
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $data = 'Quitação códigos: '.$cod;
            $dados = str_replace(',','-',$data);
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','".$usuario."','$dados','novo')");
            $result = 'Conta a Pagar Quitada!';
          }
      }else{
        $result = 'Erro ao Quitar Conta, Dados incompltos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

       // INSERIR TIPO DE DOCUMENTO
    case 51:
      //print_r($_POST);
      $tipo = ucwords($_POST['tipo']);
      $codigo = $_POST['codigo'];
      // $empresa = $_POST['empresa'];
      $status = $_POST['status'];
      $usuario = $_POST['usuario'];

      $sele = $mysqli->query("SELECT * FROM tipo_documento WHERE codigo = '$tipo'");
      $count = $sele->num_rows;
      if($count == 0){
        if($tipo){
          $sel = $mysqli->query("INSERT INTO tipo_documento (tipo,status) VALUES ('$tipo','$status')");
          if($sel){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $tipo.' '.$codigo;
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','tipo_documento','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'sucess', 'datas' => 'Tipo de documento inserido com sucesso.');
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Tipo de documento.', 'msg' => $mysqli->error, 'campo' => $razao);
          }
        }else{
          $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$tipo);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Não foi possível cadastrar. Tipo já cadastrado!.','msg' => 'Msg: '.$cnpj);
      }
      

      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR TIPO DE DOCUMENTO
    case 52:
      $tipo = $_POST['tipo'];
      $codigo = $_POST['codigo'];
      $status = $_POST['status'];
      $idtipodoc = $_POST['idtipodoc'];
      $where = Array();

      if($tipo){
        $where[] = "`tipo` = '$tipo'";
      }
      if($codigo){
        $where[] = "`codigo` = '$codigo'";
      }
      if($status){
        $where[] = "`status` = '$status'";
      }
      if($idtipodoc){
        $where[] = "`idtipodoc` = $idtipodoc";
      }
      
    
      $sql = "SELECT * FROM  tipo_documento";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
      
      $query = $mysqli->query($sql);
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Tipo de documento não encontrado.','campo' => $status);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idtipodoc' => $res['idtipodoc'],'tipo' => $res['tipo'],'status' => $res['status'],'campo' => $tipo);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR TIPO DE DOCUMENTO
    case 53:
      //print_r($_POST);
      $tipo = ucwords($_POST['tipo']);
      // $codigo = $_POST['codigo'];
      $status = $_POST['status'];
      $idtipodoc = $_POST['idtipodoc'];
      $usuario = $_POST['usuario'];

      if($idtipodoc && $tipo && $status){
        $sel = $mysqli->query("UPDATE tipo_documento SET  tipo = '$tipo', status = '$status' WHERE idtipodoc = $idtipodoc");
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $tipo.' '.$idtipodoc.' '.$status;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','tipo_documento','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Tipo de documento atualizada com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Tipo de documento.', 'msg' => $mysqli->error, 'campo' => $centro);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$status);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // DELETAR TIPO DE DOCUMENTO
    case 54:
      $idtipodoc = $_POST['idtipodoc'];
      $usuario = $_POST['usuario'];

      if($idtipodoc){
        $del = $mysqli->query("DELETE FROM tipo_documento WHERE idtipodoc = $idtipodoc");
        if($del){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = '';
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('DELETE','tipo_documento','$hoje','$hora','".$usuario.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Tipo de documento excluido!.', 'msg' => $mysqli->error, 'campo' => $idcent);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao deletar Tipo de documento!.', 'msg' => $mysqli->error, 'campo' => $idcent);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao deletar Dados Obrigatórios Ausentes!.', 'msg' => $mysqli->error, 'campo' => $idcent);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // INSERIR DOCUMENTOs
    case 55:
      //print_r($_POST);
      $nota_fiscal = $_POST['nota_fiscal'];
      $fornecedor = $_POST['fornecedor'];
      $num_doc = ($_POST['num_doc']);
      $dt_doc = $_POST['dt_doc'];
      $fk_empresa = $_POST['fk_empresa'];
      $cliente = $_POST['cliente'];
      $tipo = $_POST['tipo'];
      //$val_doc = $_POST['val_doc'];
      $val_doc = $_POST['val_doc'];
      $dt_vencimento = $_POST['dt_vencimento'];
      $frmpag = $_POST['frmpag'];
      $descricao = strtoupper($_POST['descricao']);
      $docname = $_POST['documento'];
      $obs = $_POST['obs'];
      $dt_entrada = date("Y-m-d");
      $usuario = $_POST['usuario'];

      if($nota_fiscal && $fornecedor && $num_doc && $dt_doc && $fk_empresa && $tipo && $val_doc && $dt_vencimento && $tipo && $cliente){
        $busca = $mysqli->query("SELECT * FROM documentos WHERE num_doc = $num_doc");
        $lines = $busca->num_rows;
        if($lines){
          $result = array('result' => 'error', 'error' => 'Documento informado anteriormente.','msg' => 'Msg: '.$num_doc);
        }else{
          $cons = $mysqli->query("INSERT INTO documentos (fk_empresa, fk_fornecedor, fk_tipo, fk_cliente, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, documento, descricao,obs, dt_entrada) VALUES 
                                                       ($fk_empresa,$fornecedor,$tipo,$cliente,$nota_fiscal,$num_doc,'$dt_doc',$val_doc,'$dt_vencimento','$docname','$descricao','$obs','$dt_entrada')");
          if($cons){
            $hoje = date("Y-m-d");
            $hora = date("H:i");
            $dados = $nota_fiscal.' '.$num_doc.' '.$descricao.' '.$obs;
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','conta_pagar','$hoje','$hora','".$usuario.",'$dados')");
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Documento.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
            $result = array('result' => 'sucess', 'datas' => 'Documento inserido com sucesso.');
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Documento.', 'msg' => $mysqli->error, 'campo' => $docname);
          }
        }
        
      }else{
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // LISTAR DOCUMENTOs
    case 56:
             $fornecedor = $_POST['fornecedor'];
             if($_POST['empresa'] == 0){
              $empresa = '';
             }else{
              $empresa = $_POST['empresa'];
             }
             //$tmp = explode(',',$_POST['empresa']);
             //$empresas = "'".implode("','",$tmp)."'";
             $tipo = $_POST['tipo'];
             $documento = ($_POST['documento']?$_POST['documento']:0);
             $nota_fiscal = ($_POST['nota_fiscal']?$_POST['nota_fiscal']:0);
             $dt_doc_ini = $_POST['dt_doc_ini'];
             $dt_doc_fin = $_POST['dt_doc_fin'];
             $dt_vencimento_ini = $_POST['dt_vencimento_ini'];
             $dt_vencimento_fin = $_POST['dt_vencimento_fin'];
             $dt_pag_ini = $_POST['dt_pag_ini'];
             $dt_pag_fin = $_POST['dt_pag_fin'];
             $dt_ins_ini = $_POST['dt_ins_ini'];
             $dt_ins_fin = $_POST['dt_ins_fin'];
             $status = $_POST['status'];
             $clientes = $_POST['clientes'];
             if($_POST['descricao']){
              $descricao = '%'.$_POST['descricao'].'%';
             }else{
              $descricao = $_POST['descricao'];
             }
             $codigos = $_POST['codigos'];
            //  $excluida = $_POST['excluida'];
         $where = Array();    

            //echo json_encode(array($empresa,$fornecedor,$clientes,$tipo,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

      if($fornecedor != 'Selecione' && $fornecedor != null){
        $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
        if($frn){
          $frn_res = $frn->fetch_array();
          $frn_val = ($frn_res['idforn']?$frn_res['idforn']:0);
          $where[] = "`fk_fornecedor` = {$frn_val}";
        }
        
      } 
      if ($cliente != 'Selecione' && $clientes != null){
        $cli = $mysqli->query("SELECT * FROM clientes WHERE cliente = '$cliente'");
        if($idcli){
          $frm_res = $idcli->fetch_array();
          $frm_val = ($frm_res['ididcli']?$frm_res['idcli']:0);
          $where[] = "`fk_frmpag` = {$frm_val}";
        }
      }
      if($empresa){
        $where[] = "`fk_empresa` IN ({$empresa})";
      }
      if($codigos){
        $where[] = "`iddocumento` = {$codigos}";
      }
      if($tipo != 'Selecione' && $tipo != null){
        $cnt = $mysqli->query("SELECT idtipo FROM tipo_documento WHERE idtipodoc = '$tipo'");
        if($cnt){
          $cnt_res = $cnt->fetch_array();
          $cnt_val = ($cntres['idtipodoc']?$cnt_res['idtipodoc']:0);
          $where[] = "`fk_tipo` = {$cnt_val}";
        }
      }
      if($documento){
        $where[] = "`num_doc` = $documento";
      }
      if($nota_fiscal){
        $where[] = "`num_nota` = $nota_fiscal";
      }
      if($dt_doc_ini && $dt_doc_fin){
        $where[] = "`dt_doc` between '{$dt_doc_ini}' AND '$dt_doc_fin'";
      } 
      if ($dt_vencimento_ini && $dt_vencimento_fin){
        $where[] = "`dt_vencimento` between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
      } 
      if ($dt_pag_ini && $dt_pag_fin){
        $where[] = "`dt_pag` between '$dt_pag_ini' AND '$dt_pag_fin'"; 
      } 
      if ($dt_ins_ini && $dt_ins_fin){
        $where[] = "`dt_entrada` between '$dt_ins_ini' AND '$dt_ins_fin'"; 
      } 
      if ($status != null && $status != 'Selecione'){
        $where[] = "`status_autorizacao` =  '$status'";
      }
      if ($status_pag != null && $status_pag != 'Selecione'){
        $where[] = "`status_pag` =  '$status_pag'";
      }
      if($descricao){
        $where[] = "`descricao` like '%$descricao%'";
      }
      if($excluida){
        $where[] = "`excluida` = '$excluida'";
      } 
        //echo $empresa;
        
        $sql = "SELECT * FROM  documentos";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
        //echo $sql;
        $sel = $mysqli->query($sql);
        //echo $mysqli->error;
      
        while($res = $sel->fetch_array()){
          @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
          @$mat = $sel2->fetch_array();
          @$ctc = $mysqli->query("SELECT * FROM tipo_documento WHERE idtipodoc = ".$res['fk_tipo']."");
          @$ctc_res = $ctc->fetch_array();
          @$frnc = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = ".$res['fk_fornecedor']."");
          @$frnc_res = $frnc->fetch_array();
          @$cli = $mysqli->query("SELECT * FROM clientes WHERE idcli = ".$res['fk_cliente']."");
          @$cli_res = $cli->fetch_array();
          $arr[] = array('iddoc' => $res['iddocumento'], 'documento' => $res['documento'], 'comprovante' => $res['comprovante'], 'fornecedor' => $frnc_res['fornecedor'], 'fk_forn' => $res['fk_fornecedor'], 'fk_emp' => $res['fk_empresa'], 'fk_cliente' => $res['fk_cliente'], 'fk_tipo' => $res['fk_tipo'],'empresa' => ($mat['razao_social']), 'tipo' => $ctc_res['tipo'], 'num_nota' => $res['num_nota'], 'num_doc' => $res['num_doc'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'dt_vencimento' => $res['dt_vencimento'],'descricao' => $res['descricao'],'obs' => $res['obs'], 'cliente' => $cli_res['cliente']);
        }
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao listar dados.','msg' => 'Msg: '.$sql);
        }
      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //EXCLUIR DOCUMENTOs
    case 57:
      $cod = $_POST['codigos'];
      //$obs = $_POST['obs'];
      $hoje = date("Y-m-d");
      $usuario = $_POST['usuario'];

      if($cod){
        $cons = $mysqli->query("DELETE documento WHERE iddocumento = $cod");
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Exclusão da documento de número: '.$cod;
          //$dados = str_replace(',','-',$data);
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('DELETE','documentos','$hoje','$hora','".$usuario."','$dados','novo')");
          $result = 'Documento excluída!'. $mysqli->error;
        }else{
          $result = 'Erro ao excluir Documento. - '. $mysqli->error;
        }
        
      }else{
        $result = 'Erro ao excluir Conta, Dados incompletos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR CONTA A PAGAR
    case 58:
      //print_r($_POST);
      $nota_fiscal = $_POST['nota_fiscal'];
      $fornecedor = ucwords($_POST['fornecedor']);
      $num_doc = ($_POST['num_doc']);
      $dt_doc = $_POST['dt_doc'];
      $fk_empresa = $_POST['fk_empresa'];
      $cliente = $_POST['cliente'];
      $tipo = $_POST['tipo'];
      //$val_doc = $_POST['val_doc'];
      $val_doc = $_POST['val_doc'];
      $dt_vencimento = $_POST['dt_vencimento'];
      $tipo = $_POST['tipo'];
      $descricao = strtoupper($_POST['descricao']);
      $docname = $_POST['documento'];
      $obs = $_POST['obs'];
      $dt_entrada = date("Y-m-d");
      $usuario = $_POST['usuario'];
      $codigo = $_POST['codigo'];

      $update = Array();
      $qr = "SELECT * FROM documentos WHERE iddocumento = $codigo";

      $sel = $mysqli->query($qr);
      $flag = 0;
      if($sel){
        $res = $sel->fetch_array();
        if($res['num_nota'] != $nota_fiscal){
          $update[] = "`num_nota` = $nota_fiscal";
          $campos .= ' Número Nota';
          $flag = 1;
        }
        if($res['fk_fornecedor'] != $fornecedor){
          $update[] = "`fk_fornecedor` = $fornecedor";
          $campos .= ' Fornecedor';
          $flag = 1;
        }
        if($res['num_doc'] != $num_doc){
          $update[] = "`num_doc` = $num_doc";
          $campos .= ' Número Documento';
          $flag = 1;
        }
        if($res['dt_doc'] != $dt_doc){
          $update[] = "`dt_doc` = '$dt_doc'";
          $campos .= ' Data do Documento';
          $flag = 1;
        }
        if($res['fk_empresa'] != $fk_empresa){
          $update[] = "`fk_empresa` = $fk_empresa";
          $campos .= ' Empresa';
          $flag = 1;
        }
        if($res['fk_tipo'] != $tipo){
          $update[] = "`fk_tipo` = $tipo";
          $campos .= ' tipo de Documento';
          $flag = 1;
        }
        if($res['val_doc'] != $val_doc){
          $update[] = "`val_doc` = $val_doc";
          $campos .= ' Valor Documento';
          $flag = 1;
        }
        if($res['dt_vencimento'] != $dt_vencimento){
          $update[] = "`dt_vencimento` = '$dt_vencimento'";
          $campos .= ' Vencimento';
          $flag = 1;
        }
        if($res['fk_tipo'] != $tipo){
          $update[] = "`fk_tipo` = $tipo";
          $campos .= ' Tipo de Documento';
          $flag = 1;
        }
        if($res['fk_cliente'] != $cliente){
          $update[] = "`fk_cliente` = $cliente";
          $campos .= ' Cliente';
          $flag = 1;
        }
        if($res['descricao'] != $descricao){
          $update[] = "`descricao` = '$descricao'";
          $campos .= ' Descricao';
          $flag = 1;
        }
        if($docname && $res['documento'] != $docname){
          $update[] = "`documento` = '$docname'";
          $campos .= ' Arquivo de Documento';
          $flag = 1;
        }
        if($res['obs'] != $obs){
          $update[] = "`obs` = '$obs'";
          $campos .= ' Observação';
          $flag = 1;
        }

      }
      if($flag == 1){
        $sql = "UPDATE documentos SET ".implode(',',$update)." WHERE iddocumento = $codigo";
      
        $cons = $mysqli->query($sql);
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Campos alterados:'.$campos;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','documento','$hoje','$hora','$usuario','$dados','novo')");
          $result = array('result' => 'sucess', 'msg' => 'Conta a Pagar atualizada com sucesso.', 'campo' => $sql, 'sqlerror' => $mysqli->error);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao atualizar Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      }else{
        $result = array('result' => 'sucess',  'msg' => 'Nenhuma informação alterada', 'campo' => $sql);
      }
      
        
        
      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // EDITAR USUÁRIO
    case 59:
      $iduser = $_POST['iduser'];
      $nome = ucwords($_POST['nome']);
      $email = $_POST['email'];
      $cpf = $_POST['cpf'];
      $usuario = $_POST['usuario'];
      $senha = ($_POST['senha'])?md5($_POST['senha']):'';
      $tipo = $_POST['tipo'];
      $empresa = $_POST['empresa'];
      $status = $_POST['status'];

      $flag = 0;
      $update = Array();
      $cons = $mysqli->query("SELECT * FROM usuarios WHERE iduser = $iduser");
      if($cons){
        $vals = $cons->fetch_array();
      }
      if($nome && $nome != $vals['name']){
        $update[] = "name = '$nome'";
        $campos = " Nome";
        $flag = 1;
      }
      if($email && $email != $vals['email']){
        $update[] = "email = '$email'";
        $campos = " Email";
        $flag = 1;
      }
      if($cpf && $cpf != $vals['cpf']){
        $update[] = "cpf = '$cpf'";
        $campos = " Nome";
        $flag = 1;
      }
      if($status && $status != $vals['status']){
        $update[] = "status = '$status'";
        $campos = " Status";
        $flag = 1;
      }
      if($usuario && $usuario != $vals['user']){
        $update[] = "user = '$usuario'";
        $campos = " Usuario";
        $flag = 1;
      }
      if($senha && $senha != $vals['pass']){
        $update[] = "pass = '$senha'";
        $campos = " Senha";
        $flag = 1;
      }
      if($tipo && $tipo != $vals['acces']){
        $update[] = "acces = $tipo";
        $campos = " Nivel de Acesso";
        $flag = 1;
      }
      if($empresa != $vals['fk_empresa']){
        $update[] = "fk_empresa = $empresa";
        $campos = "Nome";
        $flag = 1;
      }

      $sql = "UPDATE usuarios SET ".implode(',',$update)." WHERE iduser = $iduser";
      if($flag == 1){
        $sel = $mysqli->query($sql);
        if($sel){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = "Campos atualizados: ".$campos;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','usuarios','$hoje','$hora','".$name.",'$dados')");
          $result = array('result' => 'sucess', 'datas' => 'Usuário inserido com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir usuário.','campo' => $sql);
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Sem alterações.','campo' => $tipo);
      }
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //EXCLUIR USUARIO
    case 60:
      $cod = $_POST['iduser'];
      //$obs = $_POST['obs'];
      //$hoje = date("Y-m-d");
      $usuario = $_POST['usuario'];

      if($cod){
        $cons = $mysqli->query("DELETE usuarios WHERE iddocumento = $cod");
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = 'Exclusão da usuario:: '.$usuario;
          //$dados = str_replace(',','-',$data);
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('DELETE','usuarios','$hoje','$hora','".$usuario."','$dados','novo')");
          $result = 'Documento excluída!'. $mysqli->error;
        }else{
          $result = 'Erro ao excluir Documento. - '. $mysqli->error;
        }
        
      }else{
        $result = 'Erro ao excluir Conta, Dados incompletos.';
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    //LISTAR LOG
    case 61:
      $op = $_POST['op'];
      $dt_ini = $_POST['dt_ini'];
      $dt_fin = $_POST['dt_fin'];

      if($dt_ini && !$dt_fin){
        $dt_fin = date("Y-m-d");
      }
      
    
      if($op || ($dt_ini && $dt_fin)){
        $query = $mysqli->query("SELECT * FROM registros WHERE tipo = '".$op."' OR dt_entrada BETWEEN '$dt_ini' AND '$dt_fin'");
      }else{
        $query = $mysqli->query("SELECT * FROM registros ORDER BY dt_entrada DESC");
      }
      
      
      while($res = $query->fetch_array()){
        // $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
        // $mat = $sel->fetch_array();
        $arr[] = array('idreg' => $res['idreg'],'tipo' => $res['tipo'],'tabela' => $res['tabela'],'dt_entrada' => $res['dt_entrada'],'hora' => $res['hora'],'usuario' => $res['usuario'],'dados' => $res['dados'],'campo' => $op);
      }
      if(@sizeof($arr) > 0){
        $result = array('result' => 'sucess', 'datas' => $arr);
      }else{
        $result = array('result' => 'error', 'error' => 'Nenhum registro encontrado', 'campo' => $mysqli->error);
      }

      
      echo json_encode($result, JSON_PRETTY_PRINT);
    break;
    
    // ATUALIZAÇÃO AUTOMATICA DE STATUS DE PAGAMENTO CONTA A PAGAR POR DATA DE VENCIMENTO
    case 62:
      $hoje = date("Y-m-d");
      
      $sel = $mysqli->query("SELECT * FROM conta_pagar WHERE dt_vencimento < '$hoje' AND status_pag <> 'PAGO' AND excluida = 'não'");
      if($sel){
        while($res = $sel->fetch_array()){
          $up = $mysqli->query("UPDATE conta_pagar SET status_pag = 'ATRASADO' WHERE idcntpagar = ".$res['idcntpagar']." AND status_pag = 'ABERTO'");
          if($up){
            $hora = date("H:i");
            $dados = 'Atualizar status da conta: '.$res['num_doc'];
            //$dados = str_replace(',','-',$data);
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','Sistema','$dados','novo')");
          }
        }
        $result = array('result' => 'sucess', 'datas' => 'Status de contas a pagar atualizados', 'msg' => $mysqli->error);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao listar dados', 'msg' => $mysqli->error);
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    // ATUALIZAÇÃO AUTOMATICA DE STATUS DE PAGAMENTO CONTA A RECEBER POR DATA DE VENCIMENTO
    case 63:
      $hoje = date("Y-m-d");
      
      $sel = $mysqli->query("SELECT * FROM conta_receber WHERE dt_venc < '$hoje' AND status = 'ABERTO'");
      if($sel){
        while($res = $sel->fetch_array()){
          $up = $mysqli->query("UPDATE conta_receber SET status = 'ATRASADO' WHERE idcntrec = ".$res['idcntrec']." AND status = 'ABERTO'");
          if($up){
            $hora = date("H:i");
            $dados = 'Atualizar status da conta: '.$res['num_doc'];
            //$dados = str_replace(',','-',$data);
            $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_receber','$hoje','$hora','Sistema','$dados','novo')");
          }
        }
        $result = array('result' => 'sucess', 'datas' => 'Status de contas a receber atualizados', 'msg' => $mysqli->error);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao listar dados', 'msg' => $mysqli->error);
      }

      echo json_encode($result, JSON_PRETTY_PRINT);
    break;

    case 64:
      // 
      $convenio = "3128557";
      $insc = $_POST['inscricao'];
      $find = array("(",")","-"," ");
      $fone = str_replace($find,"",$_POST['fone']);
      $token = getToken();
      //print_r($token);
      //echo $token->access_token;
      if(strlen($insc) == 11){
        $tipoInsc = 1;
      }else if(strlen($insc) == 14){
        $tipoInsc = 2;
      }
      $nossoNumero = "000".$convenio.str_pad($_POST['documento'],10,"0", STR_PAD_RIGHT);
      
      $postfields = [
                      "numeroConvenio"=> $convenio,
                      "numeroCarteira"=>'17',
                      "numeroVariacaoCarteira"=>'35',
                      "codigoModalidade"=>'4',
                      "dataEmissao"=> date("d.m.Y"),
                      "dataVencimento"=> str_replace("/",".",$_POST['datavenc']),
                      "valorOriginal"=> $_POST['total'],
                      "valorAbatimento"=>'0',
                      "quantidadeDiasProtesto"=>'3',
                      "quantidadeDiasNegativacao"=>'0',
                      "orgaoNegativador"=>'0',
                      "indicadorAceiteTituloVencido"=>"S",
                      "numeroDiasLimiteRecebimento"=>3,
                      "codigoAceite"=>"A",
                      "codigoTipoTitulo"=>'2',
                      "descricaoTipoTitulo"=>"DM",
                      "indicadorPermissaoRecebimentoParcial"=>"N",
                      "numeroTituloBeneficiario"=>"123456",
                      "campoUtilizacaoBeneficiario"=>"UM TEXTO",
                      "numeroTituloCliente"=> $nossoNumero,
                      "mensagemBloquetoOcorrencia"=>"Outro texto",
                      "desconto"=>[
                        "tipo"=>'0',
                        "dataExpiracao"=>"",
                        "porcentagem"=>'0',
                        "valor"=>'0'
                      ],
                      "segundoDesconto"=>[
                        "dataExpiracao"=>"",
                        "porcentagem"=>'0',
                        "valor"=>'0'
                      ],"terceiroDesconto"=>[
                        "dataExpiracao"=>"",
                        "porcentagem"=>0,
                        "valor"=>'0'
                      ],
                      "jurosMora"=>[
                          "tipo"=>'0',
                          "porcentagem"=>'0',
                          "valor"=>'0'
                        ],
                        "multa"=>[
                          "tipo"=>'0',
                          "data"=>"",
                          "porcentagem"=>'0',
                          "valor"=>'0'
                        ],
                        "pagador"=>[
                          "tipoInscricao"=> $tipoInsc,
                          "numeroInscricao"=> $insc,
                          "nome"=> $_POST['cliente'],
                          "endereco"=> $_POST['endereco'],
                          "cep"=> $_POST['cep'],
                          "cidade"=> $_POST['cidade'],
                          "bairro"=> $_POST['bairro'],
                          "uf"=> $_POST['uf'],
                          "telefone"=> $fone
                        ],
                        "beneficiarioFinal"=>[
                          "tipoInscricao"=>'2',
                          "numeroInscricao"=>'98959112000179',
                          "nome"=>"Necava"
                        ],
                        "indicadorPix"=>"S"
                      ];
      try{
      $curl = curl_init();
      if ($ch === false) {
        throw new Exception('failed to initialize');
      }
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sandbox.bb.com.br/cobrancas/v2/boletos?gw-dev-app-key='.$GLOBALS['urls'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_CAINFO, "/Applications/MAMP/Library/OpenSSL/certs/cacert.pem",
        CURLOPT_POSTFIELDS => json_encode($postfields),
        CURLOPT_HTTPHEADER => array(
          'accept: application/json',
          'Authorization: Bearer '.$token->access_token,
          'Content-Type: application/json',
          'X-Developer-Application-Key : '.$GLOBALS['app_key'].''
        ),
        CURLOPT_VERBOSE => TRUE,
      ));

      $response = curl_exec($curl);
      if ($response === false) {
        throw new Exception(curl_error($curl), curl_errno($curl));
      }

      curl_close($curl);
    }catch(Exception $e){
      echo json_encode('Curl failed with error'.$e->getCode().': '.$e->getMessage());
      // trigger_error(sprintf(
      //   'Curl failed with error #%d: %s',
      //   $e->getCode(), $e->getMessage()),
       // E_USER_ERROR);
    }
      if($response){
        echo json_encode($response, JSON_PRETTY_PRINT);
      }
      
    break;

    //LISTAR FORMA DE PAGAMENTO POR EMPRESA
    case 65:
      
      $emp = $_POST['empresa'];
      if(is_array($emp)){
        $ids = implode(',',$emp);
      }else{
        $ids = $emp;
      }
      
      if($emp > 0){
        $query = $mysqli->query("SELECT * FROM frm_pagamento WHERE fk_empresa IN ($ids) ORDER BY pagamento ASC");
      }else{
        $array = json_decode($_POST['empresa']);
        foreach($array as $item){
          $id[] = $item;
        }
        $ids = implode(',',$id);
        $query = $mysqli->query("SELECT * FROM frm_pagamento WHERE fk_empresa IN ($ids) ORDER BY pagamento ASC");
      }

      $lines = $query->num_rows;
      
      
      if($lines < 1){
        $result = array('result' => 'error', 'error' => 'Forma de pagamento não encontrados.','campo' => $emp);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idfrmpag' => $res['idfrmpag'],'pagamento' => $res['pagamento'],);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      if($arr){
        echo json_encode($arr);
      }else{
        echo json_encode('null');
      }
      
    break;

    //LISTAR FORMA DE RECEBIMENTO POR EMPRESA
    case 66:
      
      $emp = $_POST['empresa'];
      if(is_array($emp)){
        $ids = implode(',',$emp);
      }else{
        $ids = $emp;
      }
      
      if($emp > 0){
        $query = $mysqli->query("SELECT * FROM frm_recebimento WHERE fk_empresa IN ($emp) ORDER BY recebimento ASC");
      }else{
        $array = json_decode($_POST['empresa']);
        foreach($array as $item){
          $id[] = $item;
        }
        $ids = implode(',',$id);
        $query = $mysqli->query("SELECT * FROM frm_recebimento WHERE fk_empresa IN ($ids) ORDER BY recebimento ASC");
      }

      $lines = $query->num_rows;
      
      
      if($lines < 1){
        $result = array('result' => 'error', 'error' => 'Forma de pagamento não encontrados.','campo' => $emp);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idfrmrec' => $res['idfrmrec'],'recebimento' => $res['recebimento'],);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      if($arr){
        echo json_encode($arr);
      }else{
        echo json_encode('null');
      }
      
    break;

    //LISTAR CLIENTES POR EMPRESA
    case 67:
      
      $emp = $_POST['empresa'];
      
      if($emp > 0){
        $query = $mysqli->query("SELECT * FROM clientes WHERE fk_empresa IN ($emp) ORDER BY cliente ASC");
      }else{
        $array = json_decode($_POST['empresa']);
        foreach($array as $item){
          $id[] = $item;
        }
        $ids = implode(',',$id);
        $query = $mysqli->query("SELECT * FROM clientes WHERE fk_empresa IN ($ids) ORDER BY pagamento ASC");
      }
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Clientes não encontrados.','campo' => $emp);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idcli' => $res['idcli'],'cliente' => $res['cliente'],);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      if($arr){
        echo json_encode($arr);
      }else{
        echo json_encode('null');
      }
      
    break;

    //LISTAR CENTRO DE CUSTO RECEBER POR EMPRESA
    case 68:
      
      $emp = $_POST['empresa'];
      if(is_array($emp)){
        $ids = implode(',',$emp);
      }else{
        $ids = $emp;
      }
      
      if($emp > 0){
        $query = $mysqli->query("SELECT * FROM centro_custo_rec WHERE fk_empresa IN ($ids) ORDER BY centro");
      }else{
        $array = json_decode($_POST['empresa']);
        foreach($array as $item){
          $id[] = $item;
        }
        $ids = implode(',',$id);
        $query = $mysqli->query("SELECT * FROM centro_custo_rec WHERE fk_empresa IN ($ids) ORDER BY centro");
      }
      $lines = $query->num_rows;
      
      if($lines < 1){
        $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrados.','campo' => $emp);
      }else{
          while($res = $query->fetch_array()){
            $arr[] = array('idcentro' => $res['idcentrorec'],'centro' => $res['centro']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      if($arr){
        echo json_encode($arr);
      }else{
        echo json_encode("null");
      }
      
    break;

    // LISTA CENTROS DE CUSTO RECEBER
case 69:
  // include("includes/conexao.php");
    $centro = $_POST['centro'];
    $empresa = $_POST['empresa'];
    $idcentro = $_POST['idcentro'];

    $where = Array();

    if($centro){
      $where[] = "`centro` LIKE '%$centro%'";
    } 
    if($idcentro){
      $where[] = "`idcentrorec` = {$idcentro}";
    }

    if($empresa){
      $where[] = "`fk_empresa` = {$empresa}";
    }

     
    $sql = "SELECT * FROM  centro_custo_rec";
    if( sizeof( $where ) ){
      $sql .= ' WHERE '.implode( ' AND ',$where )."";
    }
    $sql = $sql.' ORDER BY centro ASC';
    //echo $sql;
    $query = $mysqli->query($sql);
    //echo $mysqli->error;

    if(!$query){
      $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campo' => $sql);
    }else{
        while($res = $query->fetch_array()){
          //echo ($res['obs']);
          $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
          $mat = $sel->fetch_array();
          $arr[] = array('idcentrorec' => $res['idcentrorec'],'centro' => ($res['centro']),'fk_empresa' => $mat['ident'],'obs' => ($res['obs']),'empresa' => $mat['nome_fantasia']);
        }
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr,'campo' => $sql);
        }else{
          $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campo' => $sql);
        }

    }
    echo json_encode($result, JSON_PRETTY_PRINT);
break;

case 100:
  $fornecedor = $_POST['fornecedor'];
  if($_POST['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $_POST['empresa'];
  }
  //$tmp = explode(',',$_POST['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $_POST['centro'];
  $documento = ($_POST['documento']?$_POST['documento']:0);
  $nota_fiscal = ($_POST['nota_fiscal']?$_POST['nota_fiscal']:0);
  $dt_doc_ini = $_POST['dt_doc_ini'];
  $dt_doc_fin = $_POST['dt_doc_fin'];
  $dt_vencimento_ini = $_POST['dt_vencimento_ini'];
  $dt_vencimento_fin = $_POST['dt_vencimento_fin'];
  $dt_pag_ini = $_POST['dt_pag_ini'];
  $dt_pag_fin = $_POST['dt_pag_fin'];
  $dt_ins_ini = $_POST['dt_ins_ini'];
  $dt_ins_fin = $_POST['dt_ins_fin'];
  $status = $_POST['status'];
  $status_pag = $_POST['status_pag'];
  $frm_pag = $_POST['frm_pag'];
  if($_POST['descricao']){
  $descricao = '%'.$_POST['descricao'].'%';
  }else{
  $descricao = $_POST['descricao'];
  }
  $codigos = $_POST['codigos'];
  $excluida = $_POST['excluida'];
  $where = Array();    

  

//echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

  if($fornecedor){
    $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
      $where[] = "cp.fk_fornecedor = $fornecedor";
    
  } 
  if ($frm_pag ){
      $where[] = "cp.fk_frmrec = $frm_pag";
    
  }
  if($empresa){
    $where[] = "cp.fk_empresa IN ({$empresa})";
  }
  if($codigos){
    $where[] = "cp.idcntpagar IN ({$codigos})";
  }
  if($centro){
    $where[] = "cp.fk_centro = {$centro}";
  }
  if($documento){
    $where[] = "cp.num_doc = $documento";
  }
  if($nota_fiscal){
    $where[] = "cp.num_nota = $nota_fiscal";
  }
  if($dt_doc_ini && $dt_doc_fin){
    $where[] = "cp.dt_doc between '{$dt_doc_ini}' AND '$dt_doc_fin'";
  } 
  if (($dt_vencimento_ini && $dt_vencimento_fin)){
    $where[] = "cp.dt_vencimento between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
  } 
  if ($dt_pag_ini && $dt_pag_fin){
    $where[] = "cp.dt_pag between '$dt_pag_ini' AND '$dt_pag_fin'"; 
  } 
  if ($dt_ins_ini && $dt_ins_fin){
    $where[] = "cp.dt_entrada between '$dt_ins_ini' AND '$dt_ins_fin'"; 
  } 
  if($dt_vencimento_ini && !$dt_vencimento_fin){
    $where[] = "cp.dt_vencimento >= '$dt_vencimento_ini'";
    }
  
    if($dt_doc_ini && !$dt_doc_fin){
      $where[] = "cp.dt_doc >= '{$dt_doc_ini}'";
    }
    if($dt_ins_ini && !$dt_ins_fin){
      $where[] = "cp.dt_entrada >= '$dt_ins_ini'"; 
    }
    if($dt_pag_ini && !$dt_pag_fin){
      $where[] = "cp.dt_pag >= '$dt_pag_ini'";
    }
  if ($status != null && $status != 'Selecione'){
    $where[] = "cp.status_autorizacao =  '$status'";
  }
  if ($status_pag != null && $status_pag != 'Selecione'){
    $where[] = "cp.status_pag =  '$status_pag'";
  }
  if($descricao){
    $where[] = "cp.descricao like '%$descricao%'";
  }
  if($excluida){
    $where[] = "cp.excluida = '$excluida'";
  }

  $sql = "SELECT SUM(cr.val_servico) AS val_serv, SUM(cr.val_ret) AS val_ret, SUM(cr.val_extra) AS val_extra, SUM(cr.val_fat) AS val_fat, SUM(cr.val_doc) AS val_doc, SUM(cr.val_pag) AS val_pag, SUM(cr.val_desc) AS val_desc, SUM(cr.val_multa) AS val_multa, fr.recebimento FROM conta_receber cr JOIN frm_recebimento fr ON(cr.fk_frmrec=fr.idfrmrec) ";
  if( sizeof( $where ) ){
    $sql .= ' WHERE '.implode( ' AND ',$where )."";
  }
  $sql = $sql." GROUP BY fr.idfrmrec ORDER BY fr.recebimento ASC";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      // $cons = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      // $mat = $cons->fetch_array();
      $arr[] = array('val_doc' => $res['val_doc'], 'vr_desc' => $res['vr_desc'], 'vr_pag' => $res['vr_pag'], 'mult' => $res['multa'], 'recebimento' => $res['recebimento']);
    }
    if(@sizeof($arr) > 0){
      $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao gerar gráfico', 'campo' => $sql);
  }

  echo json_encode($result, JSON_PRETTY_PRINT);
break;

    default:
		//validarSessao("");
		echo 'Ação Inesistente.';
		break;
}


?>