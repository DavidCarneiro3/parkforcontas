<?php
include("includes/conexao.php");
include("includes/control.php");
include("includes/load.php");
include("includes/funcoes.php");
ini_set('max_execution_time', '900');
if(!empty($_FILES['arquivo']['tmp_name'])){
    
   $arquivo = new DOMDocument;

   $arquivo->load($_FILES['arquivo']['tmp_name']);

   $linhas = $arquivo->getElementsByTagName("Row");

   $contLinha = 1;
   echo '<table border="1">';
   //echo '<tr><th>Codigo</th><th>Razao Social</th><th>Fantasia</th><th>matriz</th><th>cnpj</th><th>sql</th><th>Status</th></tr>';
   echo '<tr><th>Codigo</th><th>descricao</th><th>matriz</th><th>sql</th><th>Status</th><th>Log</th></tr>';
   foreach($linhas as $linha){
       if($contLinha > 1){
            // $empresa = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $codigo = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            // $codigo_pag = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
            // $pagamento = $linha->getElementsByTagName("Data")->item(3)->nodeValue;

            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $grupo = $linha->getElementsByTagName("Data")->item(1)->nodeValue;

            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $login = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            // $senha = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
            // $cpf = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
            // $nome = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
            // $cod_grupo = $linha->getElementsByTagName("Data")->item(5)->nodeValue;
            // $status = $linha->getElementsByTagName("Data")->item(6)->nodeValue;
            // $obs = $linha->getElementsByTagName("Data")->item(7)->nodeValue;
            // $dt_cad = $linha->getElementsByTagName("Data")->item(8)->nodeValue;
           
            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $empresa = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            // $tipo = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
            // $cnpj = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
            // $razao_social = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
            // $fornecedor = $linha->getElementsByTagName("Data")->item(5)->nodeValue;
            // $endereco = $linha->getElementsByTagName("Data")->item(6)->nodeValue;
            // $complemento = $linha->getElementsByTagName("Data")->item(7)->nodeValue;
            // $bairro = $linha->getElementsByTagName("Data")->item(8)->nodeValue;
            // $cep = $linha->getElementsByTagName("Data")->item(9)->nodeValue;
            // $cidade = $linha->getElementsByTagName("Data")->item(10)->nodeValue;
            // $fone = $linha->getElementsByTagName("Data")->item(11)->nodeValue;
            // $fax = $linha->getElementsByTagName("Data")->item(12)->nodeValue;
            // $email = $linha->getElementsByTagName("Data")->item(13)->nodeValue;
            // $site = $linha->getElementsByTagName("Data")->item(14)->nodeValue;
            // $ativo = $linha->getElementsByTagName("Data")->item(15)->nodeValue;


            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $empresa = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            // $fornecedor = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
            // $centro = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
            // $num_nota = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
            // $num_doc = $linha->getElementsByTagName("Data")->item(5)->nodeValue;
            // $dt_doc = $linha->getElementsByTagName("Data")->item(6)->nodeValue;
            // $val_doc = $linha->getElementsByTagName("Data")->item(7)->nodeValue;
            // $dt_venc = $linha->getElementsByTagName("Data")->item(8)->nodeValue;
            // $desc = $linha->getElementsByTagName("Data")->item(9)->nodeValue;
            // $obs = $linha->getElementsByTagName("Data")->item(10)->nodeValue;
            // $dt_entrada = $linha->getElementsByTagName("Data")->item(11)->nodeValue;
            // $dt_pag = $linha->getElementsByTagName("Data")->item(12)->nodeValue;
            // $val_pag = $linha->getElementsByTagName("Data")->item(13)->nodeValue;
            // $val_desc = $linha->getElementsByTagName("Data")->item(14)->nodeValue;
            // $val_mul = $linha->getElementsByTagName("Data")->item(15)->nodeValue;
            // $frm_pag = $linha->getElementsByTagName("Data")->item(16)->nodeValue;
            // $obs_pag = $linha->getElementsByTagName("Data")->item(17)->nodeValue;
            // $status_pag = $linha->getElementsByTagName("Data")->item(18)->nodeValue;
            // $status_aut = $linha->getElementsByTagName("Data")->item(19)->nodeValue;
            // $dt_aut = $linha->getElementsByTagName("Data")->item(20)->nodeValue;
            // $obs_aut = $linha->getElementsByTagName("Data")->item(21)->nodeValue;
            // $excluida = $linha->getElementsByTagName("Data")->item(22)->nodeValue; 
            // $dt_exc = $linha->getElementsByTagName("Data")->item(23)->nodeValue;
            // $dt_baixa = $linha->getElementsByTagName("Data")->item(24)->nodeValue;

            // $dt_venc = $linha->getElementsByTagName("Data")->item(19)->nodeValue;
            // $val_rec = $linha->getElementsByTagName("Data")->item(20)->nodeValue;
            // $val_desc = $linha->getElementsByTagName("Data")->item(21)->nodeValue;
            // $val_mul = $linha->getElementsByTagName("Data")->item(22)->nodeValue;
            // $desc = $linha->getElementsByTagName("Data")->item(23)->nodeValue;
            // $obs = $linha->getElementsByTagName("Data")->item(24)->nodeValue;
            // $dt_rec = $linha->getElementsByTagName("Data")->item(25)->nodeValue;
            // $obs_rec = $linha->getElementsByTagName("Data")->item(26)->nodeValue;
            // $status = $linha->getElementsByTagName("Data")->item(27)->nodeValue;
            // $dt_baixa = $linha->getElementsByTagName("Data")->item(28)->nodeValue;

            // if($val_pag == 'N/I'){
            //     $val_pag = 0.00;
            // }
            // if($val_desc == "N/I"){
            //     $val_desc = 0.00;
            // }
            // if($val_mul == "N/I"){
            //     $val_mul = 0.00;
            // }
            // if($fornecedor == "N/I"){
            //     $fornecedor = 0;
            // }
            // if($dt_pag == "N/I"){
            //     $dt_pag = null;
            // }
            // if($dt_aut == "N/I"){
            //     $dt_aut = null;
            // }
            // if($dt_exc == "N/I"){
            //     $dt_exc = null;
            // }
            // if($status == 1){
            //     $status = 'ATIVO';
            // }else{
            //     $status = 'INATIVO';
            // }

            // if($excluida == 1){
            //     $excluida = 'sim';
            // }else{
            //     $excluida = 'não';
            // }

            // $params = [
            //     'codigo' => $codigo,
            //     'nota_fiscal' => $num_nota,
            //     'fornecedor' => $fornecedor,
            //     'centro' => $centro,
            //     'num_doc' => $num_doc,
            //     'fk_empresa' => $empresa,
            //     'dt_doc' => $dt_doc,
            //     'val_doc' => $val_doc,
            //     'dt_vencimento' => $dt_venc,
            //     'dt_insercao' => $dt_entrada,
            //     'frmpag' => $frm_pag,
            //     'descricao' => addslashes($desc),
            //     'documento' => 'N/I',
            //     'obs' => $obs,
            //     'dt_pag' => $dt_pag,
            //     'val_pag' => $val_pag,
            //     'val_desc' => $val_desc,
            //     'val_mul' => $val_mul,
            //     'status_pag' => $status_pag,
            //     'status' => $status_aut,
            //     'dt_aut' => $dt_aut,
            //     'obs_aut' => $obs_aut,
            //     'excluida' => $excluida,
            //     'dt_exc' => $dt_exc,
            //     'dt_baixa' => $dt_baixa,
            //     'usuario' => 'sistema',
            //     'action'=>'34'
            // ];

            // $params = [
            //     'fk_empresa' => $empresa,
            //     'codigo' => $codigo,
            //     'centro' => $centro,
            //     'obs' => $obs,
            //     'usuario' => 'sistema',
            //     'action'=> '19'
            // ];

            $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            $empresa = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            $codigo_cli = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
            $num_doc = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
            $dt_doc = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
            $val_serv = $linha->getElementsByTagName("Data")->item(5)->nodeValue;
            $val_ret = $linha->getElementsByTagName("Data")->item(6)->nodeValue;
            $val_ext = $linha->getElementsByTagName("Data")->item(7)->nodeValue;
            $val_fat = $linha->getElementsByTagName("Data")->item(8)->nodeValue;
            $val_irrf = $linha->getElementsByTagName("Data")->item(9)->nodeValue;
            $val_pis = $linha->getElementsByTagName("Data")->item(10)->nodeValue;
            $val_cofins = $linha->getElementsByTagName("Data")->item(11)->nodeValue;
            $val_csll = $linha->getElementsByTagName("Data")->item(12)->nodeValue;
            $val_inss = $linha->getElementsByTagName("Data")->item(13)->nodeValue;
            $reter_iss = $linha->getElementsByTagName("Data")->item(14)->nodeValue;
            $val_iss = $linha->getElementsByTagName("Data")->item(15)->nodeValue;
            $iss_ret = $linha->getElementsByTagName("Data")->item(16)->nodeValue;
            $val_doc = $linha->getElementsByTagName("Data")->item(17)->nodeValue;
            $dt_venc = $linha->getElementsByTagName("Data")->item(18)->nodeValue;
            $desc = $linha->getElementsByTagName("Data")->item(19)->nodeValue;
            $obs = $linha->getElementsByTagName("Data")->item(20)->nodeValue;
            $dt_entrada = $linha->getElementsByTagName("Data")->item(21)->nodeValue;
            $hr_entrada = $linha->getElementsByTagName("Data")->item(22)->nodeValue;
            $dt_rec = $linha->getElementsByTagName("Data")->item(23)->nodeValue; 
            $login_ent = $linha->getElementsByTagName("Data")->item(24)->nodeValue;
            $val_rec = $linha->getElementsByTagName("Data")->item(25)->nodeValue;
            $val_desc = $linha->getElementsByTagName("Data")->item(26)->nodeValue;
            $val_mul = $linha->getElementsByTagName("Data")->item(27)->nodeValue;
            $frm_rec = $linha->getElementsByTagName("Data")->item(28)->nodeValue;
            $obs_rec = $linha->getElementsByTagName("Data")->item(29)->nodeValue;
            $status = $linha->getElementsByTagName("Data")->item(30)->nodeValue;
            $dt_baixa = $linha->getElementsByTagName("Data")->item(31)->nodeValue;
            $hr_baixa = $linha->getElementsByTagName("Data")->item(32)->nodeValue;
            $login_baixa = $linha->getElementsByTagName("Data")->item(33)->nodeValue;

            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $val_doc = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            // $obs = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
            // $val_pag = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
            // $val_desc = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
            // $val_mul = $linha->getElementsByTagName("Data")->item(5)->nodeValue;

            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $empresa = $linha->getElementsByTagName("Data")->item(1)->nodeValue;

            // $codigo = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            // $empresa = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
            // $obs = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
            

            if($val_rec == 'N/I'){
                $val_rec = 0.00;
            }
            if($val_desc == "N/I"){
                $val_desc = 0.00;
            }
            if($val_mul == "N/I"){
                $val_mul = 0.00;
            }
            if($val_ret == 'N/I'){
                $val_ret = 0.00;
            }
            if($val_ext== "N/I"){
                $val_desc = 0.00;
            }
            if($val_fat == "N/I"){
                $val_mul = 0.00;
            }
            if($frm_rec == "N/I"){
                $frm_rec = 0;
            }
            if($fornecedor == "N/I"){
                $fornecedor = 0;
            }
            // if(strlen($obs) > 40){
            //    $obs = str_replace(',','',$obs);
            // }

            $params = [
                'login_entr' => $login_entr,
                'dt_baixa' => $dt_baixa,
                'hr_baixa' => $hr_baixa,
                'login_baixa' => $login_baixa,
                'dt_entrada' => $dt_entrada,
                'hr_entrada' => $hr_entrada,
                'codigo' => $codigo,                        
                'cliente' => $codigo_cli,
                'frm_rec' => $frm_rec,
                'num_doc' => $num_doc,
                'fk_empresa' => $empresa,
                'dt_doc' => $dt_doc,
                'dt_venc' => $dt_venc,
                'dt_rec' => $dt_rec,
                'dt_baixa' => $dt_baixa,
                'val_desc' => $val_desc,
                'val_mul' => $val_mul,
                'val_serv' => $val_serv,
                'val_doc' => $val_doc,
                'val_rec' => $val_rec,
                'val_ret' => $val_ret,
                'val_extra' => $val_ext,
                'val_fat' => $val_fat,
                'val_irrf' => $val_irrf,
                'val_pis' => $val_pis,
                'val_cofins' => $val_cofins,
                'val_csll' => $val_csll,
                'val_inss' => $val_inss,
                'val_iss' => $val_iss,
                'iss_ret' => $iss_ret,
                'dt_vencimento' => $dt_venc,
                'dt_entrada' => $dt_entrada,
                'reter' => $reter_iss,
                'descricao' => ucwords(addslashes($desc)),
                'documento' =>$newname,
                'obs' => ucwords(addslashes($obs)),
                'status' => $status,
                'obs_rec' => ucwords(addslashes($obs_rec)),
                'usuario' => 'sistema',
                'action'=>'45'
            ];
            
            // $params = [
            //     'codigo' => $codigo,
            //     'cnpj' => $cnpj,
            //     'fornecedor' => ucwords($razao_social),
            //     'fantasia' => ucwords($fornecedor),
            //     'tipo_fornecedor' => $tipo,
            //     'fk_empresa' => $empresa,
            //     'endereco' => $endereco,
            //     'complemento' => $complemento,
            //     'bairro' => $bairro,
            //     'cep' => $cep,
            //     'uf' => $uf,
            //     'cidade' =>$cidade,
            //     'fone' => $fone,
            //     'fax' => $fax,
            //     'email' => $email,
            //     'site' => $site,
            //     'usuario' => 'sistema',
            //     'action'=>'9'
            // ];

            // $params = [
            //     'codigo' => $codigo,
            //     'cpf_cnpj' => $cnpj,
            //     'cliente' =>ucwords($razao_social),
            //     'fantasia' => ucwords($cliente),
            //     'tipo_cliente' => $tipo,
            //     'fk_empresa' => $empresa,
            //     'endereco' => $endereco,
            //     'complemento' => $complemento,
            //     'bairro' => $bairro,
            //     'cep' => $cep,
            //     'uf' => $uf,
            //     'cidade' => $cod_cidade,
            //     'fone' => $fone,
            //     'fax' => $fax,
            //     'email' => $email,
            //     'reter' => $reter,
            //     'usuario' => 'sistema',
            //     'action'=> '13'
            // ];

            // $params = [
            //     'codigo' => $codigo,
            //     'codigo_pag' => $codigo_pag,
            //     'pagamento' => $pagamento,
            //     //'obs' => $obs,
            //     'empresa' => $empresa,
            //     'usuario' => $_SESSION['user'],
            //     'action'=> '27'
            // ];

            //  $params = [
            //     'codigo' => $codigo,
            //     'grupo' => $grupo,
            //     'usuario' => 'sistema',
            //     'action'=> '27'
            // ];

            //   $params = [
            //     'codigo' => $codigo,
            //     'nome' => $nome,
            //     'email' => $email,
            //     'login' => $login,
            //     'senha' => $senha,
            //     'cpf' => $cpf,
            //     'obs' => $obs,
            //     'status' => $status,
            //     'empresa' => 0,
            //     'dt_cad' => $dt_cad,
            //     'grupo' => $cod_grupo,
            //     'usuario' => 'sistema',
            //     'action'=> '27'
            // ];

            //   $params = [
            //     'codigo' => $codigo,
            //     'val_doc' => $val_doc,
            //     'obs' => $obs,
            //     'val_pag' => $val_pag,
            //     'val_mul' => $val_mul,
            //     'val_desc' => $val_desc,
            //     'obs' => $obs,
            //     'status' => $status,
            //     'empresa' => 0,
            //     'dt_cad' => $dt_cad,
            //     'grupo' => $cod_grupo,
            //     'usuario' => 'sistema',
            //     'action'=> '27'
            // ];

            // $params = [
            //         'codigo' => $codigo,
            //         'empresa' => $empresa,
            //         'obs' => $obs,
            //         'usuario' => 'sistema',
            //         'action'=> '27'
            //     ];


             $result = loadApi($params);
            //$result = loadApi($params);
            //$res = $result->error.' '.$result->datas.' '.$result->msg;
            
            //echo '<tr><td>'.$codigo.'</td><td>'.$razao_social.'</td><td>'.$cliente.'</td><td>'.$empresa.'</td><td>'.$cnpj.'</td><td>'.$result->campo.'</td><td>'.$result->msg.'</td></tr>';
            echo '<tr><td>'.$codigo.'</td><td> reter: '.$reter_iss.', nome: '.$nome.', Dt_exc: '.$dt_exc.', Desc: '.$desc.', Obs: '.$obs.', Dt_doc: '.$dt_doc.', Val_desc: '.$val_desc.', Val_doc: '.$val_doc.', Val_mul: '.$val_mul.', Venc: '.$dt_venc.', Nota: '.$num_nota.', Excluida: '.$excluida.', Status_pag: '.$status_pag.', Status_aut: '.$status_aut.', Dt_entrada:'.$dt_entrada.', Dt_Pag:'.$dt_pag.'</td><td>'.$empresa.'</td><td>'.$result->campo.'</td><td>'.$result->msg.'</td><td>'.$result->log.'</td></tr>';
            

            // if($result->result === "sucess"){
            //     echo $razao_social.' - Ok'.'</br>';
            // }else{echo $result->error.' - '.$result->campo.'</br>';}
            // $sql = "INSERT INTO empresas (ident,razao_social, nome_fantasia, cnpj, tipo_empresa, fk_matriz, irrf, pis, cofins, csll, inss, iss,status) VALUES ($id,'$razao_social','$nome_fantasia','$cnpj','$tipo_empresa',$fk_matriz,$irrf,$pis,$cofins,$csll,$inss,$iss,'$status'";
            // $ins = $mysqli->query($sql);
            // if($ins){
            //     echo $razao_social.' Ok'.$mysqli->error.'</br>';
            // }else{
            //     echo $status.' Erro'.$mysqli->error.' </br>';
            // }
       }else{
           $contLinha++;
       }
       
       
   }
   echo '</table>';
}
?>