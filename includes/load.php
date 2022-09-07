<?php
//PEGAR CONVENIOS DAS EMPRESAS
function listarConveniosEmpresas($dados){
  include("conexao.php");
    
      $sql ="SELECT * FROM empresas WHERE convenio IS NOT NULL AND convenio <> 0 ORDER BY nome_fantasia";
      $query = $mysqli->query($sql);
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Empresas não encontradas.', 'campo' => $sql);
      }else{
        
          while($res = $query->fetch_array()){
            //echo ($res['razao_social']);
            $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_matriz']."");
            if($sel){
              //echo "Entrou";
              $mat = $sel->fetch_array();
            }
            
            $arr[] = array('idemp' => $res['ident'],'razao_social' => ($res['razao_social']),'nome_fantasia' => ($res['nome_fantasia']), 'cnpj' => $res['cnpj'], 'tipo_empresa' => $res['tipo_empresa'], 'matriz' => ($mat['razao_social']),'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'inss' => $res['inss'],'csll' => $res['csll'],'iss' => $res['iss'],'status' => $res['status'], 'convenio' => $res['convenio']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
          }

      }
  return json_encode($result, JSON_PRETTY_PRINT);
}
//ATUALIZA NOSSO NUMERO BOLETO E ARQUIVO
function attNossoNumBoleto($dados){
  include("conexao.php");

  $nossNum = $dados['nosso_numero'];
  $id_conta = $dados['id_conta'];
  $seq = $dados['sequ'];
  $bol_arq = $dados['arq_bol'];

  $sql = "UPDATE conta_receber SET num_boleto = '$nossNum', seq_boleto = $seq, boleto_arq = $bol_arq WHERE idcntrec = $id_conta";
  $up = $mysqli->query($sql);
  if($up){
    $result = array('result' => 'sucess', 'datas' => 'Informações de boleto atualizadas.', 'msg' => 'Informações de boleto atualizadas. ', 'campo' => $sql);
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao atualizar informações do boleto.', 'msg' => 'Erro ao atualizar informações do boleto. '.$mysqli->error, 'campo' => $sql);
  }

  $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,usuario,dados) VALUES ('INSERT','conta_receber','sistema','".date("Y-m-d")."','".$result['msg'].' '.addslashes($result['campo'])."')");

  return json_encode($result, JSON_PRETTY_PRINT);
}
// INSERIR CONTA RECEBER
function inserirContaReceber($dados){
  include("conexao.php");

  $codigo = $dados['codigo'];
  $fk_empresa = $dados['fk_empresa'];
  
  $cliente = $dados['cliente'];
  if(!$cliente){
    $cliente = 0;
  }
  $num_doc = $dados['num_doc'];
  $dt_doc = $dados['dt_doc'];
  $dt_vencimento = $dados['dt_vencimento'];
  $val_serv = $dados['val_serv'];
  $val_mul = $dados['val_mul'];
  $val_desc = $dados['val_desc'];
  $val_rec = $dados['val_rec'];
  $val_ret = $dados['val_ret'];
  $centro = $dados['centro'];
  if(!$centro){
    $centro = 0;
  }
  $frm_rec = $dados['recebimento'];
  if(!$frm_rec){
    $frm_rec = 0;
  }
  $val_doc = $dados['val_doc'];
  $val_extra = $dados['val_extra'];
  $val_fat = $dados['val_fat'];
  $irrf = $dados['val_irrf'];
  $pis = $dados['val_pis'];
  $cofins = $dados['val_cofins'];
  $inss = $dados['val_inss'];
  $iss = $dados['val_iss'];
  $csll = $dados['val_csll'];
  $iss_ret = $dados['iss_ret'];
  $descricao = strtoupper($dados['descricao']);
  $reter = $dados['reter'];
  $arquivo = $dados['documento'];
  $obs = $dados['obs'];
  // if(!$obs){
  //   $obs = 'N/I';
  // }
  $obs_rec = $dados['obs_rec'];
  $dt_entrada = date("Y-m-d");
  //$dt_entrada = $dados['dt_entrada'];
  $dt_rec = $dados['dt_rec'];
  $status = $dados['status'];
  $dt_baixa = $dados['dt_baixa'];
  $usuario = $dados['usuario'];
  $hr_ins = date("H:i:s");
  $parcela = $dados['parcela'];
  //$num = rand(1, 9999);
  $busc = $mysqli->query("SELECT * FROM frm_recebimento WHERE idfrmrec = $frm_rec");
  if($busc->num_rows > 0){
    $frmrec = $busc->fetch_array();
  }
  $convenio = $dados['convenio'];
  $protesta = $dados['protesta'];
  $negativa = $dados['negativa'];
  $juros = $dados['juros'];
  $multa = $dados['multa'];
  $dias_protesto = ($dados['dias_protesto'])?$dados['dias_protesto']:0;
  $dias_negativa = ($dados['dias_negativa'])?$dados['dias_negativa']:0;
  // $vencimento_boleto = $dados['vencimento_boleto'];
  $orgao_negativa = ($dados['orgao_negativa'])?$dados['orgao_negativa']:0;
  $dias_venc = $dados['dias_venc'];
  if($parcela < 2){
    
    if($frmrec['recebimento'] === 'BOLETO'){
      
      $sql = "INSERT INTO conta_receber (fk_empresa,fk_frmrec, fk_cliente,fk_centro, num_doc, dt_doc, val_doc, dt_venc, val_servico, val_ret, val_extra, val_fat, descricao,obs, status, irrf, pis, cofins, csll, inss, iss, dt_entrada, reter,hr_insercao,login_insercao, protesta,dias_protesto,negativa,dias_negativa,orgao_negativa,juros,multa,venc_boleto,convenio,dias_venc,parcela) 
                               VALUES ($fk_empresa,$frm_rec,$cliente,$centro,'$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$val_serv,$val_ret,$val_extra,$val_fat,'$descricao','$obs','ABERTO',$irrf,$pis,$cofins,$csll,$inss,$iss,'$dt_entrada','$reter','$hr_ins','$usuario','$protesta',$dias_protesto,'$negativa',$dias_negativa,$orgao_negativa,$juros,$multa,'$dt_vencimento','$convenio',$dias_venc,1)";
    }else{
      $sql = "INSERT INTO conta_receber (fk_empresa, fk_frmrec, fk_cliente,fk_centro, num_doc, dt_doc, val_doc, dt_venc, val_servico, val_ret, val_extra, val_fat, descricao,obs, status, irrf, pis, cofins, csll, inss, iss, dt_entrada, reter,hr_insercao,login_insercao,parcela) 
                               VALUES ($fk_empresa,$frm_rec,$cliente,$centro,'$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$val_serv,$val_ret,$val_extra,$val_fat,'$descricao','$obs','ABERTO',$irrf,$pis,$cofins,$csll,$inss,$iss,'$dt_entrada','$reter','$hr_ins','$usuario',1)";
    }
    if($fk_empresa){
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
          if($ins){
            $log = 'Log criado.';
          }else{
            $log = 'Log não criado.';
          }
          //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Receber.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
          $result = array('result' => 'sucess', 'datas' => 'Conta a Receber inserida com sucesso.', 'msg' => 'Conta a Receber inserida com sucesso. '.$log, 'campo' => $sql);
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Receber.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      //}
      
    }else{
      //$result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$fk_empresa.' && '.$cliente.' && '.$val_serv.' && '.$val_fat.' && '.$val_doc.' && '.$num_doc .' && '.$dt_doc.' && '.$centro.' && '.$dt_vencimento);
      $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos!', 'msg' => 'Dados obrigatórios incompletos!', 'campo' => $sql);
    }
  }else{
    for($i=0; $i < $parcela; $i++){
      $dt_tmp = new DateTime($dt_vencimento);
      $dt_tmp->add(new DateInterval('P'.$i.'M'));
      $newdate = $dt_tmp->format("Y-m-d");
      if($frmrec['recebimento'] === 'BOLETO'){
        
        // $dt_tmp_bol = new DateTime($vencimento_boleto);
        // $dt_tmp_bol->add(new DateInterval('P'.$i.'M'));
        // $newdate_bol = $dt_tmp_bol->format("Y-m-d");
        $sql = "INSERT INTO conta_receber (fk_empresa,fk_frmrec, fk_cliente,fk_centro, num_doc, dt_doc, val_doc, dt_venc, val_servico, val_ret, val_extra, val_fat, descricao,obs, status, irrf, pis, cofins, csll, inss, iss, dt_entrada, reter,hr_insercao,login_insercao, protesta,dias_protesto,negativa,dias_negativa,orgao_negativa,juros,multa,venc_boleto,convenio,dias_venc,parcela) 
                                 VALUES ($fk_empresa,$frm_rec,$cliente,$centro,'$num_doc','$dt_doc',$val_doc,'$newdate',$val_serv,$val_ret,$val_extra,$val_fat,'$descricao','$obs','ABERTO',$irrf,$pis,$cofins,$csll,$inss,$iss,'$dt_entrada','$reter','$hr_ins','$usuario','$protesta',$dias_protesto,'$negativa',$dias_negativa,$orgao_negativa,$juros,$multa,'$newdate','$convenio',$dias_venc,($i+1))";
      }else{
        $sql = "INSERT INTO conta_receber (fk_empresa, fk_cliente,fk_centro, num_doc, dt_doc, val_doc, dt_venc, val_servico, val_ret, val_extra, val_fat, descricao,obs, status, irrf, pis, cofins, csll, inss, iss, dt_entrada, reter,hr_insercao,login_insercao,parcela) 
                                 VALUES ($fk_empresa,$cliente,$centro,'$num_doc','$dt_doc',$val_doc,'$newdate',$val_serv,$val_ret,$val_extra,$val_fat,'$descricao','$obs','ABERTO',$irrf,$pis,$cofins,$csll,$inss,$iss,'$dt_entrada','$reter','$hr_ins','$usuario',($i+1))";
      }
      if($fk_empresa){
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
            if($ins){
              $log = 'Log criado.';
            }else{
              $log = 'Log não criado.';
            }
            //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Receber.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
            $result = array('result' => 'sucess', 'datas' => 'Conta a Receber inserida com sucesso.', 'msg' => 'Conta a Receber inserida com sucesso. '.$log, 'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Receber.', 'msg' => $mysqli->error, 'campo' => $sql);
          }
        //}
        
      }else{
        //$result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$fk_empresa.' && '.$cliente.' && '.$val_serv.' && '.$val_fat.' && '.$val_doc.' && '.$num_doc .' && '.$dt_doc.' && '.$centro.' && '.$dt_vencimento);
        $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos!', 'msg' => 'Dados obrigatórios incompletos!', 'campo' => $sql);
      }
    }
  }
  
  
  
  
  return json_encode($result, JSON_PRETTY_PRINT);
}

//LISTAR CONTAS PAGAR
function listarContaPagar($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  // if($dados['empresa'] == 0){
  // $empresa = '';
  // }else{
  // $empresa = $dados['empresa'];
  // }
  if($dados['empresa'] && is_array($dados['empresa'])){
    $tmp = explode(',',$dados['empresa']);
    $empresa = "'".implode("','",$tmp)."'";
  }else{
    $empresa = $dados['empresa'];
  }
  
 
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $dt_exc_ini = $dados['dt_exc_ini'];
  $dt_exc_fin = $dados['dt_exc_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
  $where = Array();    

  

//echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

  if($fornecedor){
    $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
      $where[] = "`fk_fornecedor` = $fornecedor";
    
  } 
  if ($frm_pag ){
      $where[] = "`fk_frmpag` = $frm_pag";
    
  }
  if($empresa){
    $where[] = "`fk_empresa` IN ({$empresa})";
  }
  if($codigos){
    $where[] = "`idcntpagar` IN ({$codigos})";
  }
  if($centro){
    $where[] = "`fk_centro` = {$centro}";
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
  if (($dt_exc_ini && $dt_exc_fin)){
    $where[] = "`dt_exclusao` between '$dt_exc_ini' AND '$dt_exc_fin'"; 
  } 
  if ($dt_pag_ini && $dt_pag_fin){
    $where[] = "`dt_pag` between '$dt_pag_ini' AND '$dt_pag_fin'"; 
  } 
  if ($dt_ins_ini && $dt_ins_fin){
    $where[] = "`dt_entrada` between '$dt_ins_ini' AND '$dt_ins_fin'"; 
  } 
  if($dt_vencimento_ini && !$dt_vencimento_fin){
    $where[] = "`dt_vencimento` >= '$dt_vencimento_ini'";
    }
  if($dt_exc_ini && !$dt_exc_fin){
    $where[] = "`dt_exclusao` >= '$dt_vencimento_ini'";
  }
  
    if($dt_doc_ini && !$dt_doc_fin){
      $where[] = "`dt_doc` >= '{$dt_doc_ini}'";
    }
    if($dt_ins_ini && !$dt_ins_fin){
      $where[] = "`dt_entrada` >= '$dt_ins_ini'"; 
    }
    if($dt_pag_ini && !$dt_pag_fin){
      $where[] = "`dt_pag` >= '$dt_pag_ini'";
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
    $sql = $sql.' ORDER BY dt_vencimento';
    //echo $sql;
    $sel = $mysqli->query($sql);
    //echo $mysqli->error;
    $count = $sel->num_rows;
    if($count > 0){
      while($res = $sel->fetch_array()){
        @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
        @$mat = $sel2->fetch_array();
        @$ctc = $mysqli->query("SELECT * FROM centro_custo WHERE idcentro = ".$res['fk_centro']."");
        @$ctc_res = $ctc->fetch_array();
        @$frnc = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = ".$res['fk_fornecedor']."");
        @$frnc_res = $frnc->fetch_array();
        @$frmpagt = $mysqli->query("SELECT * FROM frm_pagamento WHERE idfrmpag = ".$res['fk_frmpag']."");
        @$frmp_res = $frmpagt->fetch_array();
        $arr[] = array('id_conta' => $res['idcntpagar'], 'documento' => ($res['documento']), 'comprovante' => $res['comprovante'], 'fornecedor' => ($frnc_res['nome_fantasia']), 'fk_forn' => $res['fk_fornecedor'], 'fk_emp' => $res['fk_empresa'], 'fk_frmpag' => $res['fk_frmpag'], 'fk_centro' => $res['fk_centro'],'empresa' => ($mat['nome_fantasia']), 'centro' => ($ctc_res['centro']), 'num_nota' => $res['num_nota'], 'num_doc' => $res['num_doc'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'dt_vencimento' => $res['dt_vencimento'],'frm_pag' => ($frmp_res['pagamento']),'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'obs_status' => ($res['obs_status']), 'status_autorizacao' => $res['status_autorizacao'],'dt_autorizacao' => $res['dt_autorizacao'],'status_pag' => $res['status_pag'],'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['vr_pag']?$res['vr_pag']:0.00),'multa' => ($res['multa']?$res['multa']:0.00),'vr_desc' => ($res['vr_desc']?$res['vr_desc']:0.00),'obs_pag' => $res['obs_pag'], 'login_ins' => $res['login_insercao'], 'login_aut' => $res['login_autorizacao'], 'login_exc' => $res['login_exclusao'], 'login_baixa' => $res['login_baixa'], 'dt_ins' => $res['dt_entrada'], 'hr_ins' => $res['hr_insercao'], 'dt_aut' => $res['dt_insercao'], 'dt_baixa' => $res['dt_baixa'], 'hr_aut' => $res['hr_autorizacso'], 'hr_baixa' => $res['hr_baixa'], 'hr_exc' => $res['hr_exclusao'], 'dt_exc' => $res['dt_exclusao']);
      }
      if(@sizeof($arr) > 0){
          $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$sql, 'campo' => $centro);
      }
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Nenhum registro encontrado', 'campo' => $sql);
    }
    
  
  return json_encode($result, JSON_PRETTY_PRINT);
}

//RELATORIO CONTAS PAGAR
function relContaPagar($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
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
    
    $sql = "SELECT SUM(val_doc) AS val_doc, SUM(vr_desc) AS vr_desc, SUM(vr_pag) AS vr_pag, SUM(multa) AS multa, fk_empresa, fk_centro FROM conta_pagar";
    if( sizeof( $where ) ){
      $sql .= ' WHERE '.implode( ' AND ',$where )." GROUP BY fk_centro ORDER BY val_doc DESC";
    }else{
      $sql = $sql.' GROUP BY fk_centro ORDER BY val_doc DESC';
    }
    //echo $sql;
    $sel = $mysqli->query($sql);
    //echo $mysqli->error;
  
    while($res = $sel->fetch_array()){
      @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      @$mat = $sel2->fetch_array();
      @$ctc = $mysqli->query("SELECT * FROM centro_custo WHERE idcentro = ".$res['fk_centro']."");
      @$ctc_res = $ctc->fetch_array();
      // @$frnc = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = ".$res['fk_fornecedor']."");
      // @$frnc_res = $frnc->fetch_array();
      // @$frmpagt = $mysqli->query("SELECT * FROM frm_pagamento WHERE idfrmpag = ".$res['fk_frmpag']."");
      // @$frmp_res = $frmpagt->fetch_array();
      $arr[] = array('id_conta' => $res['idcntpagar'], 'documento' => ($res['documento']), 'comprovante' => $res['comprovante'], 'fornecedor' => ($frnc_res['fornecedor']), 'fk_forn' => $res['fk_fornecedor'], 'fk_emp' => $res['fk_empresa'], 'fk_frmpag' => $res['fk_frmpag'], 'fk_centro' => $res['fk_centro'],'empresa' => ($mat['razao_social']), 'centro' => ($ctc_res['centro']), 'num_nota' => $res['num_nota'], 'num_doc' => $res['num_doc'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'dt_vencimento' => $res['dt_vencimento'],'frm_pag' => ($frmp_res['pagamento']),'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'obs_status' => ($res['obs_status']), 'status_autorizacao' => $res['status_autorizacao'],'dt_autorizacao' => $res['dt_autorizacao'],'status_pag' => $res['status_pag'],'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['vr_pag']?$res['vr_pag']:0.00),'multa' => ($res['multa']?$res['multa']:0.00),'vr_desc' => ($res['vr_desc']?$res['vr_desc']:0.00),'obs_pag' => ($res['obs_pag']));
    }
    if(@sizeof($arr) > 0){
        $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$sql, 'campo' => $centro);
    }
  
  return json_encode($result, JSON_PRETTY_PRINT);
}

//RELATORIO CONTAS PAGAR RESUMO
function relContaPagarRes($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
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
    $where[] = "`vr_pag` > 0.00";
  }
  if($descricao){
    $where[] = "`descricao` like '%$descricao%'";
  }
  if($excluida){
    $where[] = "`excluida` = '$excluida'";
  }
    //echo $empresa;
    
    $sql = "SELECT SUM(val_doc) AS val_doc, SUM(vr_desc) AS vr_desc, SUM(vr_pag) AS vr_pag, SUM(multa) AS multa, fk_empresa, fk_centro FROM conta_pagar";
    if( sizeof( $where ) ){
      $sql .= ' WHERE '.implode( ' AND ',$where );
    }
    //echo $sql;
    $sel = $mysqli->query($sql);
    //echo $mysqli->error;
  
    while($res = $sel->fetch_array()){
      // @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      // @$mat = $sel2->fetch_array();
      // @$ctc = $mysqli->query("SELECT * FROM centro_custo WHERE idcentro = ".$res['fk_centro']."");
      // @$ctc_res = $ctc->fetch_array();
      // @$frnc = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = ".$res['fk_fornecedor']."");
      // @$frnc_res = $frnc->fetch_array();
      // @$frmpagt = $mysqli->query("SELECT * FROM frm_pagamento WHERE idfrmpag = ".$res['fk_frmpag']."");
      // @$frmp_res = $frmpagt->fetch_array();
      $arr[] = array('id_conta' => $res['idcntpagar'], 'documento' => ($res['documento']), 'comprovante' => $res['comprovante'], 'fornecedor' => ($frnc_res['fornecedor']), 'fk_forn' => $res['fk_fornecedor'], 'fk_emp' => $res['fk_empresa'], 'fk_frmpag' => $res['fk_frmpag'], 'fk_centro' => $res['fk_centro'],'empresa' => ($mat['razao_social']), 'centro' => ($ctc_res['centro']), 'num_nota' => $res['num_nota'], 'num_doc' => $res['num_doc'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'dt_vencimento' => $res['dt_vencimento'],'frm_pag' => ($frmp_res['pagamento']),'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'obs_status' => ($res['obs_status']), 'status_autorizacao' => $res['status_autorizacao'],'dt_autorizacao' => $res['dt_autorizacao'],'status_pag' => $res['status_pag'],'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['vr_pag']?$res['vr_pag']:0.00),'multa' => ($res['multa']?$res['multa']:0.00),'vr_desc' => ($res['vr_desc']?$res['vr_desc']:0.00),'obs_pag' => ($res['obs_pag']));
    }
    if(@sizeof($arr) > 0){
        $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$sql, 'campo' => $centro);
    }
  
  return json_encode($result, JSON_PRETTY_PRINT);
}

//RELATORIO CONTAS PAGAR RESUMO GERAL
function relContaPagarResGeral($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
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
    $where[] = "`vr_pag` > 0.00";
  }
  if($descricao){
    $where[] = "`descricao` like '%$descricao%'";
  }
  if($excluida){
    $where[] = "`excluida` = '$excluida'";
  }

  $where[] = "(SELECT SUM(val_doc) FROM conta_receber WHERE `dt_vencimento` BETWEEN '$dt_vencimento_ini' AND '$dt_vencimento_fin') > 0";
    //echo $empresa;
    
    $sql = "SELECT SUM(cp.val_doc) AS val_doc_pag, IF((SELECT SUM(val_doc) FROM conta_receber WHERE `dt_venc` BETWEEN '$dt_vencimento_ini' AND '$dt_vencimento_fin'),(SELECT SUM(val_doc) FROM conta_receber WHERE `dt_venc` BETWEEN '$dt_vencimento_ini' AND '$dt_vencimento_fin'),0) AS val_doc_rec FROM conta_pagar cp";
    if( sizeof( $where ) ){
      $sql .= ' WHERE '.implode( ' AND ',$where );
    }
  
    //echo $sql;
    $sel = $mysqli->query($sql);
    //echo $mysqli->error;
  
    while($res = $sel->fetch_array()){
      // @$sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      // @$mat = $sel2->fetch_array();
      // @$ctc = $mysqli->query("SELECT * FROM centro_custo WHERE idcentro = ".$res['fk_centro']."");
      // @$ctc_res = $ctc->fetch_array();
      // @$frnc = $mysqli->query("SELECT * FROM fornecedores WHERE idforn = ".$res['fk_fornecedor']."");
      // @$frnc_res = $frnc->fetch_array();
      // @$frmpagt = $mysqli->query("SELECT * FROM frm_pagamento WHERE idfrmpag = ".$res['fk_frmpag']."");
      // @$frmp_res = $frmpagt->fetch_array();
      $arr[] = array('val_doc_pag' => $res['val_doc_pag'], 'val_doc_rec' => $res['val_doc_rec']);
    }
    if(@sizeof($arr) > 0){
        $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$sql, 'campo' => $centro);
    }
  
  return json_encode($result, JSON_PRETTY_PRINT);
}

//GRAFICO POR PERÍODO
function graphFinEmpresa($dados){
  include("conexao.php");

  $dt_ini = $dados['dt_vencimento_ini'];
  $dt_fin = $dados['dt_vencimento_fin'];

  $sql = "SELECT e.ident,e.ident,e.nome_fantasia, SUM(cr.val_doc) AS val_doc_rec, (SELECT SUM(val_doc) FROM conta_pagar WHERE fk_empresa = e.ident AND dt_vencimento BETWEEN '$dt_ini' AND '$dt_fin' AND excluida = 'não' AND vr_pag > 0.00) AS val_doc_pag FROM conta_receber cr JOIN empresas e ON(cr.fk_empresa=e.ident) WHERE cr.dt_venc BETWEEN '$dt_ini' AND '$dt_fin' GROUP BY e.ident ORDER BY e.nome_fantasia";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      $arr[] = array('ident' => $res['ident'], 'empresa' => $res['nome_fantasia'], 'val_doc_pag' => $res['val_doc_pag'], 'val_doc_rec' => $res['val_doc_rec']);
      if(@sizeof($arr) > 0){
        $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->error, 'campo' => $sql);
      }
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->errror, 'campo' => $sql);
  }
  

return json_encode($result, JSON_PRETTY_PRINT);

}

//GRAFICO POR EMPRESA E PERÍODO
function graphEmpresa($dados){
  include("conexao.php");

  $dt_ini = $dados['dt_vencimento_ini'];
  $dt_fin = $dados['dt_vencimento_fin'];
  $fk_empresa = $dados['empresa'];

  $sql = "SELECT e.ident,e.ident,e.nome_fantasia, SUM(cr.val_doc) AS val_doc_rec, (SELECT SUM(val_doc) FROM conta_pagar WHERE fk_empresa = e.ident AND dt_vencimento BETWEEN '$dt_ini' AND '$dt_fin' AND excluida = 'não' AND vr_pag > 0.00) AS val_doc_pag FROM conta_receber cr JOIN empresas e ON(cr.fk_empresa=e.ident) WHERE cr.dt_venc BETWEEN '$dt_ini' AND '$dt_fin' AND cr.fk_empresa = $fk_empresa GROUP BY e.ident";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      $arr[] = array('ident' => $res['ident'], 'empresa' => $res['nome_fantasia'], 'val_doc_pag' => $res['val_doc_pag'], 'val_doc_rec' => $res['val_doc_rec']);
      if(@sizeof($arr) > 0){
        $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->error, 'campo' => $sql);
      }
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->errror, 'campo' => $sql);
  }
  

return json_encode($result, JSON_PRETTY_PRINT);

}

//GRAFICO PIE FRM RECEBIMENTO
function graphPieFrmRec($dados){
  include("conexao.php");

  $dt_ini = $dados['dt_vencimento_ini'];
  $dt_fin = $dados['dt_vencimento_fin'];

  $sql = "SELECT COUNT(cr.fk_frmrec) AS qtd, fr.recebimento FROM `conta_receber` cr JOIN frm_recebimento fr ON(cr.fk_frmrec=fr.idfrmrec) WHERE cr.dt_venc BETWEEN '$dt_ini' AND '$dt_fin' GROUP BY fr.recebimento";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      $arr[] = array('qtd' => $res['qtd'], 'recebimento' => $res['recebimento']);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->errror, 'campo' => $sql);
  }
  if(@sizeof($arr) > 0){
    $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
}else{
  $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->error, 'campo' => $sql);
}

return json_encode($result, JSON_PRETTY_PRINT);
}

//GRAFICO PIE FRM PAGAMENTO
function graphPieFrmPag($dados){
  include("conexao.php");

  $dt_ini = $dados['dt_vencimento_ini'];
  $dt_fin = $dados['dt_vencimento_fin'];

  $sql = "SELECT COUNT(cp.fk_frmpag) AS qtd, fp.pagamento FROM `conta_pagar` cp JOIN frm_pagamento fp ON(cp.fk_frmpag=fp.idfrmpag) WHERE cp.dt_vencimento BETWEEN '$dt_ini' AND '$dt_fin' GROUP BY fp.pagamento";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      $arr[] = array('qtd' => $res['qtd'], 'pagamento' => $res['pagamento']);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->errror, 'campo' => $sql);
  }
  if(@sizeof($arr) > 0){
    $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
}else{
  $result = array('result' => 'error', 'error' => 'Erro ao listar dados. Nenhum registro encontrado.','msg' => 'Msg: '.$mysqli->error, 'campo' => $sql);
}

return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTAR CONTAS RECEBER
function listaContaReceber($dados){
    //header('Content-Type: application/json');
      include("conexao.php");
      //include("funcoes.php");

      $fk_empresa = $dados['empresa'];
      $cliente = $dados['cliente'];
      $num_doc = $dados['num_doc'];
      $dt_doc_ini = $dados['dt_doc_ini'];
      $dt_doc_fin = $dados['dt_doc_fin'];
      $dt_vencimento_ini = $dados['dt_vencimento_ini'];
      $dt_vencimento_fin = $dados['dt_vencimento_fin'];
      $centro = $dados['centro'];
      $status = $dados['status'];
      $sit_bol = $dados['sit_bol'];
      $reter = $dados['reter'];
      $documento = $dados['documento'];
      $frm_rec = $dados['frm_rec'];
      $codigos = $dados['codigos'];
      $usuario = $dados['usuario'];
      $num_bol = $dados['num_bol'];
             
      $where = Array();

      if($dt_vencimento_ini && !$dt_vencimento_fin){
        $dt_vencimento_fin = date("Y-m-d");
        }
      
        if($dt_doc_ini && !$dt_doc_fin){
          $dt_doc_fin = date("Y-m-d");
        }
        if($dt_ins_ini && !$dt_ins_fin){
          $dt_ins_fin = date("Y-m-d");
        }
        if($dt_pag_ini && !$dt_pag_fin){
          $dt_pag_fin = date("Y-m-d");
        }
      //echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));


      if($fk_empresa){
        $where[] = "`fk_empresa` = {$fk_empresa}";
      } 

      if($num_doc){
        $where[] = "`num_doc` = {$num_doc}";
      } 

      if($cliente){
        $where[] = "`fk_cliente` = {$cliente}";
      } 
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

      if ($sit_bol){
        $where[] = "`sit_boleto` =  '$sit_bol'";
      }
    
        
        //echo $empresa;
        
        $sql = "SELECT * FROM conta_receber";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }

        $sql = $sql.' ORDER BY dt_venc ASC';
        //echo $sql;
        $cons = $mysqli->query($sql);
        $lines = $cons->num_rows;
        //echo $mysqli->error;
        if($lines > 0){
          while($res = $cons->fetch_array()){
            $sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            if($sel2){$mat = $sel2->fetch_array();}
            
            @$ctc = $mysqli->query("SELECT * FROM centro_custo_rec WHERE idcentrorec = ".$res['fk_centro']."");
            if($ctc){$ctc_res = $ctc->fetch_array();}else{$ctc_res=0;}
            
            $frnc = $mysqli->query("SELECT * FROM clientes WHERE idcli = ".$res['fk_cliente']."");
            if($frnc){$frnc_res = $frnc->fetch_array();}
            
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

            if($res['convenio']){
              $sel3 = $mysqli->query("SELECT agencia, conta FROM empresas WHERE convenio = '".$res['convenio']."'");
              if($sel3->num_rows > 0){
                $emp_data = $sel3->fetch_array();
              }
            }
            
            $arr[] = array('id_conta' => $res['idcntrec'], 'documento' => ($res['documento']), 'comprovante' => ($res['comprovante']),'num_bol' => $res['num_boleto'], 'seq_boleto' => ($res['seq_boleto']),  'boleto_arq' => ($res['boleto_arq']), 'sit_bol' => $res['sit_boleto'], 'tipo_cliente' => ($frnc_res['tipo_cliente']),'cliente' => ($frnc_res['cliente']), 'cpf_cnpj' => $frnc_res['cpf_cnpj'], 'cidade' => ($frnc_res['cidade']), 'bairro' => ($frnc_res['bairro']), 'endereco' => ($frnc_res['endereco']), 'cep' => $frnc_res['cep'], 'uf' => $frnc_res['uf'], 'fone' => $frnc_res['fone'], 'fk_cli' => $res['fk_cliente'], 'fk_emp' => $res['fk_empresa'], 'fk_frmrec' => $res['fk_frmrec'], 'fk_centro' => $res['fk_centro'],'emp_razao_social' => $mat['razao_social'],'empresa' => ($mat['nome_fantasia']),'agencia' => ($emp_data['agencia']),'conta' => ($emp_data['conta']),'cnpj_emp' => ($mat['cnpj']),'fk_centro' => ($res['fk_centro']),'centro' => ($ctc_res['centro']), 'num_doc' => $res['num_doc'],'val_servico' => $res['val_servico'],'val_ret' => $res['val_ret'],'val_fat' => $res['val_fat'],'val_extra' => $res['val_extra'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'csll' => $res['csll'],'inss' => $res['inss'],'iss' => $res['iss'],'dt_vencimento' => $res['dt_venc'],'frm_rec' => $rec,'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'status' => $res['status'],'reter' => ($res['reter']), 'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['val_pag']?$res['val_pag']:0.00),'multa' => ($res['val_multa']?$res['val_multa']:0.00),'vr_desc' => ($res['val_desc']?$res['val_desc']:0.00),'obs_pag' => ($res['obs_pag']), 'login_insercao' => $res['login_insercao'], 'hr_insercao' => $res['hr_insercao'], 'login_baixa' => $res['login_baixa'], 'hr_baixa' => $res['hr_baixa'], 'dt_entrada' => $res['dt_entrada'], 'dt_baixa' => $res['dt_baixa'], 'dt_pag' => $res['dt_pag'], 'protesta' => $res['protesta'],'dias_protesto' => $res['dias_protesto'],'negativa' => $res['negativa'],'dias_negativa' => $res['dias_negativa'],'orgao_negativa' => $res['orgao_negativa'],'juros_bol' => $res['juros'], 'multa_bol' => $res['multa'], 'venc_boleto' => $res['venc_boleto'], 'convenio' => $res['convenio'], 'dias_venc' => $res['dias_venc'], 'parcela' => $res['parcela']);
            if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr, 'msg' => $count);
            }else{
              $result = array('result' => 'error', 'error' => 'Erro ao listar dados.','msg' => 'Nenhum dado encontrado: '.$sql);
            }
          }
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao listar dados.','msg' => 'Nenhum dado encontrado: '.$sql);
        }
        
        
        
      return json_encode($result, JSON_PRETTY_PRINT);
}

// ATUALIZA SITUACAO DO BOLETO
function atualiza_sit_bol($dados){
  include("conexao.php");

  $idcnt = $dados['idcnt'];
  $sit = $dados['sit'];
  $status = $dados['status'];
  $valor_pago = $dados['valor_pago'];
  $multa_pago = $dados['multa_pago'];
  $juros_pago = $dados['juros_pago'];
  $usuario = 'SISTEMA';
  $hr = date("H:i");
  $update = Array();

  if($status){
    $update[] = "status = '$status'";
  }
  if($sit){
    $update[] = "sit_boleto = '$sit'";
  }
  if($valor_pago){
    $update[] = "val_pag = $valor_pago";
  }
  if($multa_pago){
    $update[] = "val_multa = $multa_pago";
    $update[] = "login_baixa = '$usuario'";
    $update[] = "hr_baixa = '$hr'";
  }
  if($juros_pago){
    $update[] = "val_multa = $juros_pago";
  }
  
  if($dt_receb){
    $update[] = "dt_baixa = '$dt_receb'";
    $update[] = "dt_pag = '$dt_receb'";
  }
  

  $sql = "UPDATE conta_receber SET ".implode(',',$update)." WHERE idcntrec = $idcnt";
  $cons = $mysqli->query($sql);
  if($cons){
    $hoje = date("Y-m-d");
    $hora = date("H:i");
    $dados = 'Atualiza situação de boleto';
    $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados,status) VALUES ('UPDATE','conta_pagar','$hoje','$hora','$usuario','$dados','novo')");
    $result = array('result' => 'sucess', 'msg' => 'Conta a Receber atualizada com sucesso.', 'campo' => $sql, 'sqlerror' => $mysqli->error);
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao atualizar Conta a Receber.', 'msg' => $mysqli->error, 'campo' => $sql);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTAR CONTAS RECEBER
function listaContaReceberBoleto($dados){
  //header('Content-Type: application/json');
    include("conexao.php");
    //include("funcoes.php");

    // $data = date("Y-m-d");
    // $dias = 5;
    // $novadata = date('Y-m-d', strtotime("+{$dias} days",strtotime($data)));
    
    $dt_vencimento_ini = $dados['dt_vencimento_ini'];
    $dt_vencimento_fin = $dados['dt_vencimento_fin'];
    
           
    $where = Array();

    $hoje = date("Y-m-d");

  
    $where[] = "`num_boleto` IS NOT NULL";
    $where[] = "`status` = 'ABERTO'";
    $where[] = "dt_doc <= '$hoje'";
    // if($dt_vencimento_fin && $dt_vencimento_fin){
    //   $where[] = "dt_venc BETWEEN '$dt_vencimento_ini' AND '$dt_vencimento_fin'";
    // }
    

    
      
      //echo $empresa;
      
      $sql = "SELECT * FROM conta_receber";
      if( sizeof( $where ) ){
        $sql .= ' WHERE '.implode( ' AND ',$where )."";
      }

      $sql = $sql.' ORDER BY idcntrec DESC';
      //echo $sql;
      $cons = $mysqli->query($sql);
      $lines = $cons->num_rows;
      //echo $mysqli->error;
      if($lines > 0){
        while($res = $cons->fetch_array()){
          $sel2 = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
          if($sel2){$mat = $sel2->fetch_array();}
          
          @$ctc = $mysqli->query("SELECT * FROM centro_custo_rec WHERE idcentrorec = ".$res['fk_centro']."");
          if($ctc){$ctc_res = $ctc->fetch_array();}else{$ctc_res=0;}
          
          $frnc = $mysqli->query("SELECT * FROM clientes WHERE idcli = ".$res['fk_cliente']."");
          if($frnc){$frnc_res = $frnc->fetch_array();}
          
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

          if($res['convenio']){
            $sel3 = $mysqli->query("SELECT agencia, conta FROM empresas WHERE convenio = '".$res['convenio']."'");
            if($sel3->num_rows > 0){
              $emp_data = $sel3->fetch_array();
            }
          }
          
          $arr[] = array('id_conta' => $res['idcntrec'], 'documento' => ($res['documento']), 'comprovante' => ($res['comprovante']),'num_bol' => $res['num_boleto'], 'seq_boleto' => ($res['seq_boleto']),  'boleto_arq' => ($res['boleto_arq']),'tipo_cliente' => ($frnc_res['tipo_cliente']),'cliente' => ($frnc_res['cliente']), 'cpf_cnpj' => $frnc_res['cpf_cnpj'], 'cidade' => ($frnc_res['cidade']), 'bairro' => ($frnc_res['bairro']), 'endereco' => ($frnc_res['endereco']), 'cep' => $frnc_res['cep'], 'uf' => $frnc_res['uf'], 'fone' => $frnc_res['fone'], 'fk_cli' => $res['fk_cliente'], 'fk_emp' => $res['fk_empresa'], 'fk_frmrec' => $res['fk_frmrec'], 'fk_centro' => $res['fk_centro'],'emp_razao_social' => $mat['razao_social'],'empresa' => ($mat['nome_fantasia']),'agencia' => ($emp_data['agencia']),'conta' => ($emp_data['conta']),'cnpj_emp' => ($mat['cnpj']),'fk_centro' => ($res['fk_centro']),'centro' => ($ctc_res['centro']), 'num_doc' => $res['num_doc'],'val_servico' => $res['val_servico'],'val_ret' => $res['val_ret'],'val_fat' => $res['val_fat'],'val_extra' => $res['val_extra'],'dt_doc' => $res['dt_doc'],'val_doc' => $res['val_doc'],'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'csll' => $res['csll'],'inss' => $res['inss'],'iss' => $res['iss'],'dt_vencimento' => $res['dt_venc'],'frm_rec' => $rec,'descricao' => ($res['descricao']),'obs' => ($res['obs']), 'status' => $res['status'],'reter' => ($res['reter']), 'dt_pag' => $res['dt_pag'],'vr_pag' => ($res['val_pag']?$res['val_pag']:0.00),'multa' => ($res['val_multa']?$res['val_multa']:0.00),'vr_desc' => ($res['val_desc']?$res['val_desc']:0.00),'obs_pag' => ($res['obs_pag']), 'login_insercao' => $res['login_insercao'], 'hr_insercao' => $res['hr_insercao'], 'login_baixa' => $res['login_baixa'], 'hr_baixa' => $res['hr_baixa'], 'dt_entrada' => $res['dt_entrada'], 'dt_baixa' => $res['dt_baixa'], 'dt_pag' => $res['dt_pag'], 'protesta' => $res['protesta'],'dias_protesto' => $res['dias_protesto'],'negativa' => $res['negativa'],'dias_negativa' => $res['dias_negativa'],'orgao_negativa' => $res['orgao_negativa'],'juros_bol' => $res['juros'], 'multa_bol' => $res['multa'], 'venc_boleto' => $res['venc_boleto'], 'convenio' => $res['convenio'], 'dias_venc' => $res['dias_venc'], 'parcela' => $res['parcela']);
          if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr, 'msg' => $count);
          }else{
            $result = array('result' => 'error', 'error' => 'Erro ao listar dados.','msg' => 'Nenhum dado encontrado: '.$sql);
          }
        }
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao listar dados.','msg' => 'Nenhum dado encontrado: '.$sql);
      }
      
      
      
    return json_encode($result, JSON_PRETTY_PRINT);
}

// DADOS PARA GRAFICO DE CONTAS A RECEBER COM FRM RECEB
function grapRelCntRecFrmRec($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
  $where = Array();    

  

//echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

  if($fornecedor){
    $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
      $where[] = "cr.fk_fornecedor = $fornecedor";
    
  } 
  if ($frm_pag ){
      $where[] = "cr.fk_frmrec = $frm_pag";
    
  }
  if($empresa){
    $where[] = "cr.fk_empresa IN ({$empresa})";
  }
  if($codigos){
    $where[] = "cr.idcntpagar IN ({$codigos})";
  }
  if($centro){
    $where[] = "cr.fk_centro = {$centro}";
  }
  if($documento){
    $where[] = "cr.num_doc = $documento";
  }
  if($nota_fiscal){
    $where[] = "cr.num_nota = $nota_fiscal";
  }
  if($dt_doc_ini && $dt_doc_fin){
    $where[] = "cr.dt_doc between '{$dt_doc_ini}' AND '$dt_doc_fin'";
  } 
  if (($dt_vencimento_ini && $dt_vencimento_fin)){
    $where[] = "cr.dt_venc between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
  } 
  if ($dt_pag_ini && $dt_pag_fin){
    $where[] = "cr.dt_pag between '$dt_pag_ini' AND '$dt_pag_fin'"; 
  } 
  if ($dt_ins_ini && $dt_ins_fin){
    $where[] = "cr.dt_entrada between '$dt_ins_ini' AND '$dt_ins_fin'"; 
  } 
  if($dt_vencimento_ini && !$dt_vencimento_fin){
    $where[] = "cr.dt_venc >= '$dt_vencimento_ini'";
    }
  
    if($dt_doc_ini && !$dt_doc_fin){
      $where[] = "cr.dt_doc >= '{$dt_doc_ini}'";
    }
    if($dt_ins_ini && !$dt_ins_fin){
      $where[] = "cr.dt_entrada >= '$dt_ins_ini'"; 
    }
    if($dt_pag_ini && !$dt_pag_fin){
      $where[] = "cr.dt_pag >= '$dt_pag_ini'";
    }
  if ($status != null && $status != 'Selecione'){
    $where[] = "cr.status_autorizacao =  '$status'";
  }
  if ($status_pag != null && $status_pag != 'Selecione'){
    $where[] = "cr.status_pag =  '$status_pag'";
  }
  if($descricao){
    $where[] = "cr.descricao like '%$descricao%'";
  }
  // if($excluida){
  //   $where[] = "cr.excluida = '$excluida'";
  // }

  $sql = "SELECT SUM(cr.val_servico) AS val_serv, SUM(cr.val_ret) AS val_ret, SUM(cr.val_extra) AS val_extra, SUM(cr.val_fat) AS val_fat, SUM(cr.val_doc) AS val_doc, SUM(cr.val_pag) AS val_pag, SUM(cr.val_desc) AS val_desc, SUM(cr.val_multa) AS val_multa, SUM(cr.pis) AS val_pis, SUM(cr.inss) AS val_inss, SUM(cr.csll) AS val_csll, SUM(cr.irrf) AS val_irrf, SUM(cr.iss) AS val_iss, SUM(cr.iss_ret) AS val_iss_ret, SUM(cr.cofins) AS val_cofins, fr.recebimento FROM conta_receber cr JOIN frm_recebimento fr ON(cr.fk_frmrec=fr.idfrmrec) ";
  if( sizeof( $where ) ){
    $sql .= ' WHERE '.implode( ' AND ',$where )."";
  }
  $sql = $sql." GROUP BY fr.idfrmrec ORDER BY fr.recebimento ASC";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      // $cons = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      // $mat = $cons->fetch_array();
      $arr[] = array('vr_extra' => $res['val_extra'], 'vr_serv' => $res['val_serv'], 'vr_fat' => $res['val_fat'], 'vr_ret' => $res['val_ret'], 'val_doc' => $res['val_doc'], 'vr_desc' => $res['val_desc'], 'vr_pag' => $res['val_pag'], 'mult' => $res['val_multa'], 'recebimento' => $res['recebimento']);
    }
    if(@sizeof($arr) > 0){
      $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao gerar gráfico', 'campo' => $sql, 'msg' => $mysqli->error);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

// DADOS PARA GRAFICO DE CONTAS A RECEBER SEM FRM RECEB
function grapRelCntRec($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
  $where = Array();    

  

//echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

  if($fornecedor){
    $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
      $where[] = "fk_fornecedor = $fornecedor";
    
  } 
  if ($frm_pag ){
      $where[] = "fk_frmrec = $frm_pag";
    
  }
  if($empresa){
    $where[] = "fk_empresa IN ({$empresa})";
  }
  if($codigos){
    $where[] = "idcntpagar IN ({$codigos})";
  }
  if($centro){
    $where[] = "fk_centro = {$centro}";
  }
  if($documento){
    $where[] = "num_doc = $documento";
  }
  if($nota_fiscal){
    $where[] = "num_nota = $nota_fiscal";
  }
  if($dt_doc_ini && $dt_doc_fin){
    $where[] = "dt_doc between '{$dt_doc_ini}' AND '$dt_doc_fin'";
  } 
  if (($dt_vencimento_ini && $dt_vencimento_fin)){
    $where[] = "dt_venc between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
  } 
  if ($dt_pag_ini && $dt_pag_fin){
    $where[] = "dt_pag between '$dt_pag_ini' AND '$dt_pag_fin'"; 
  } 
  if ($dt_ins_ini && $dt_ins_fin){
    $where[] = "dt_entrada between '$dt_ins_ini' AND '$dt_ins_fin'"; 
  } 
  if($dt_vencimento_ini && !$dt_vencimento_fin){
    $where[] = "dt_venc >= '$dt_vencimento_ini'";
    }
  
    if($dt_doc_ini && !$dt_doc_fin){
      $where[] = "dt_doc >= '{$dt_doc_ini}'";
    }
    if($dt_ins_ini && !$dt_ins_fin){
      $where[] = "dt_entrada >= '$dt_ins_ini'"; 
    }
    if($dt_pag_ini && !$dt_pag_fin){
      $where[] = "dt_pag >= '$dt_pag_ini'";
    }
  if ($status != null && $status != 'Selecione'){
    $where[] = "status_autorizacao =  '$status'";
  }
  if ($status_pag != null && $status_pag != 'Selecione'){
    $where[] = "status_pag =  '$status_pag'";
  }
  if($descricao){
    $where[] = "descricao like '%$descricao%'";
  }
  // if($excluida){
    $where[] = "status = 'ABERTO'";
  // }

  $sql = "SELECT SUM(val_servico) AS val_serv, SUM(val_ret) AS val_ret, SUM(val_extra) AS val_extra, SUM(val_fat) AS val_fat, SUM(val_doc) AS val_doc, SUM(val_pag) AS val_pag, SUM(val_desc) AS val_desc, SUM(val_multa) AS val_multa, SUM(pis) AS val_pis, SUM(inss) AS val_inss, SUM(csll) AS val_csll, SUM(irrf) AS val_irrf, SUM(iss) AS val_iss, SUM(iss_ret) AS val_iss_ret, SUM(cofins) AS val_cofins, 'EM ABERTO' As recebimento FROM `conta_receber`";
  if( sizeof( $where ) ){
    $sql .= ' WHERE '.implode( ' AND ',$where )."";
  }
  // $sql = $sql." GROUP BY fr.idfrmrec ORDER BY fr.recebimento ASC";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      // $cons = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      // $mat = $cons->fetch_array();
      $arr[] = array('vr_extra' => $res['val_extra'], 'vr_serv' => $res['val_serv'], 'vr_fat' => $res['val_fat'], 'vr_ret' => $res['val_ret'], 'val_doc' => $res['val_doc'], 'vr_desc' => $res['val_desc'], 'vr_pag' => $res['val_pag'], 'mult' => $res['val_multa'], 'recebimento' => $res['recebimento']);
    }
    if(@sizeof($arr) > 0){
      $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql, 'msg' => $mysqli->error);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao gerar gráfico', 'campo' => $sql, 'msg' => $mysqli->error);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

// RESUMO DE CONTAS A RECEBER
function grapRelCntRecRes($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $status = $dados['status'];
  // $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
  $where = Array();    

  

//echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

  if($fornecedor){
    $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
      $where[] = "cr.fk_fornecedor = $fornecedor";
    
  } 
  if ($frm_pag ){
      $where[] = "cr.fk_frmrec = $frm_pag";
    
  }
  if($empresa){
    $where[] = "cr.fk_empresa IN ({$empresa})";
  }
  if($codigos){
    $where[] = "cr.idcntpagar IN ({$codigos})";
  }
  if($centro){
    $where[] = "cr.fk_centro = {$centro}";
  }
  if($documento){
    $where[] = "cr.num_doc = $documento";
  }
  if($nota_fiscal){
    $where[] = "cr.num_nota = $nota_fiscal";
  }
  if($dt_doc_ini && $dt_doc_fin){
    $where[] = "cr.dt_doc between '{$dt_doc_ini}' AND '$dt_doc_fin'";
  } 
  if (($dt_vencimento_ini && $dt_vencimento_fin)){
    $where[] = "cr.dt_venc between '$dt_vencimento_ini' AND '$dt_vencimento_fin'"; 
  } 
  if ($dt_pag_ini && $dt_pag_fin){
    $where[] = "cr.dt_pag between '$dt_pag_ini' AND '$dt_pag_fin'"; 
  } 
  if ($dt_ins_ini && $dt_ins_fin){
    $where[] = "cr.dt_entrada between '$dt_ins_ini' AND '$dt_ins_fin'"; 
  } 
  if($dt_vencimento_ini && !$dt_vencimento_fin){
    $where[] = "cr.dt_venc >= '$dt_vencimento_ini'";
    }
  
    if($dt_doc_ini && !$dt_doc_fin){
      $where[] = "cr.dt_doc >= '{$dt_doc_ini}'";
    }
    if($dt_ins_ini && !$dt_ins_fin){
      $where[] = "cr.dt_entrada >= '$dt_ins_ini'"; 
    }
    if($dt_pag_ini && !$dt_pag_fin){
      $where[] = "cr.dt_pag >= '$dt_pag_ini'";
    }
  if ($status != null && $status != 'Selecione'){
    $where[] = "cr.status_autorizacao =  '$status'";
  }
  if ($status_pag != null && $status_pag != 'Selecione'){
    $where[] = "cr.status_pag =  '$status_pag'";
  }
  if($descricao){
    $where[] = "cr.descricao like '%$descricao%'";
  }
  if($excluida){
    $where[] = "cr.val_doc > 1.00";
  }

  $sql = "SELECT SUM(cr.val_servico) AS val_serv, SUM(cr.val_ret) AS val_ret, SUM(cr.val_extra) AS val_extra, SUM(cr.val_fat) AS val_fat, SUM(cr.val_doc) AS val_doc, SUM(cr.val_pag) AS val_pag, SUM(cr.val_desc) AS val_desc, SUM(cr.val_multa) AS val_multa, SUM(cr.pis) AS val_pis, SUM(cr.inss) AS val_inss, SUM(cr.csll) AS val_csll, SUM(cr.irrf) AS val_irrf, SUM(cr.iss) AS val_iss, SUM(cr.iss_ret) AS val_iss_ret, SUM(cr.cofins) AS val_cofins, 'EM ABERTO' As recebimento FROM conta_receber cr ";
  if( sizeof( $where ) ){
    $sql .= ' WHERE '.implode( ' AND ',$where )."";
  }
  // $sql = $sql." GROUP BY fr.idfrmrec ORDER BY fr.recebimento ASC";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      // $cons = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      // $mat = $cons->fetch_array();
      $arr[] = array('vr_extra' => $res['val_extra'], 'vr_serv' => $res['val_serv'], 'vr_fat' => $res['val_fat'], 'vr_ret' => $res['val_ret'], 'val_doc' => $res['val_doc'], 'vr_desc' => $res['val_desc'], 'vr_pag' => $res['val_pag'], 'mult' => $res['val_multa'], 'recebimento' => $res['recebimento']);
    }
    if(@sizeof($arr) > 0){
      $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql, 'msg' => $mysqli->error);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao gerar gráfico', 'campo' => $sql, 'msg' => $mysqli->error);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

//LISTAR CLIENTES
function listarClientes($dados){
  include("conexao.php");
      $tipo = $dados['tipo_cliente'];
      $cliente = $dados['cliente'];
      $emp = $dados['empresa'];
      $cpf_cnpj = $dados['cpf_cnpj'];
      //$fornecedor = $dados['cliente'];
      $idcli = $dados['id_cli'];
      
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
      // if($fornecedor){
      //   $where[] = "`fornecedor` = $fornecedor";
      // }
      if($idcli){
        $where[] = "`idcli` = $idcli";
      }
      if($emp){
        $where[] = "`fk_empresa` = $emp";
      }
      
        //echo $empresa;
        
        $sql = "SELECT * FROM  clientes";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
        //echo $sql;
        $query = $mysqli->query($sql);
        //echo $mysqli->error;
      
      
      
      if(!$query){
        $result = array('result' => 'error', 'error' => 'clientes não encontrados.','campo' => $sql);
      }else{
          while($res = $query->fetch_array()){
            // $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            // $mat = $sel->fetch_array();
            $arr[] = array('idcli' => $res['idcli'],'cliente' => ($res['cliente']),'nome_fantasia' => ($res['nome_fantasia']), 'cpf_cnpj' => $res['cpf_cnpj'], 'tipo_cliente' => ($res['tipo_cliente']), 'endereco' => ($res['endereco']),'complemento' => ($res['complemento']),'bairro' => ($res['bairro']),'cep' => $res['cep'],'uf' => ($res['uf']),'cidade' => ($res['cidade']),'fone' => ($res['fone']),'fax' => ($res['fax']),'email' => ($res['email']),'reter' => ($res['reter']));
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTAR FORMA RECEBIMENTO
function listarFormaRecebimento($dados){
    include("conexao.php");
    $recebimento = $dados['recebimento'];
      $codigo = $dados['codigo'];
      $ativo = $dados['ativo'];
      $idfrmrec = $dados['idfrmrec'];
      $empresa = $dados['empresa'];
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
      if($empresa){
        $where[] = "`fk_empresa` = $empresa";
      }

      
    
      $sql = "SELECT * FROM  frm_recebimento";
        if( sizeof( $where ) ){
          $sql .= ' WHERE '.implode( ' AND ',$where )."";
        }
      $sql = $sql.' ORDER BY recebimento ASC';
      $query = $mysqli->query($sql);
      if(!$query){
        $result = array('result' => 'error', 'error' => 'Forma de recebimento não encontrado.','campo' => $ativo);
      }else{
          while($res = $query->fetch_array()){
            
            $arr[] = array('idfrmrec' => $res['idfrmrec'],'codigo' => $res['codigo'],'recebimento' => ($res['recebimento']),'ativo' => $res['ativo'],'campo' => $centro);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr);
          }

      }
      return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTAR FORMA PAGAMENTO
function listarFormaPagamento($dados){
  include("conexao.php");
    $pagamento = $dados['pagamento'];
    $codigo = $dados['codigo'];
    $ativo = $dados['ativo'];
    $idfrmpag = $dados['idfrmpag'];
    if(is_array($dados['emprea'])){
      $empresa = implode(',',$dados['empresa']);
    }else{
      $empresa = $dados['empresa'];
    }
    $where = Array();

    if($pagamento){
      $where[] = "`pagamento` = '$pagamento'";
    }
    if($codigo){
      $where[] = "`codigo` = '$codigo'";
    }
    if($ativo){
      $where[] = "`ativo` = '$ativo'";
    }
    if($idfrmpag){
      $where[] = "`idfrmpag` IN ($idfrmpag)";
    }
    if($empresa){
      $where[] = "`fk_empresa` = $empresa";
    }
  
    $sql = "SELECT * FROM  frm_pagamento";
      if( sizeof( $where ) ){
        $sql .= ' WHERE '.implode( ' AND ',$where )."";
      }
    
    $query = $mysqli->query($sql);
    if(!$query){
      $result = array('result' => 'error', 'error' => 'Forma de pagamento não encontrado.','campo' => $ativo);
    }else{
        while($res = $query->fetch_array()){
          
          $arr[] = array('idfrmpag' => $res['idfrmpag'],'codigo' => $res['codigo'],'pagamento' => ($res['pagamento']),'ativo' => $res['ativo'],'campo' => $centro);
        }
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr);
        }

    }
    return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTA EMPRESA POR STATUS
function listaEmpresaAtiva($dados){
    include("conexao.php");
    $status = $dados['status'];
      if($status){
        $where = "WHERE status = '$status'";
      }else{
        $where = '';
      }
      $query = $mysqli->query("SELECT * FROM empresas ".$where." ORDER BY nome_fantasia");
      
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
      return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTA EMPRESA com CONVENIO
function listaEmpresaAtivaConvenio(){
  include("conexao.php");
  
    $query = $mysqli->query("SELECT * FROM empresas WHERE convenio <> '' ORDER BY nome_fantasia");
    
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
          
          $arr[] = array('idemp' => $res['ident'],'razao_social' => ($res['razao_social']),'nome_fantasia' => ($res['nome_fantasia']), 'cnpj' => $res['cnpj'], 'tipo_empresa' => $res['tipo_empresa'], 'matriz' => ($mat['razao_social']),'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'inss' => $res['inss'],'csll' => $res['csll'],'iss' => $res['iss'],'status' => $res['status'], 'convenio' => $res['convenio'],'agencia' => $res['agencia'],'conta' => $res['conta']);
        }
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr);
        }

    }
    return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTA TODAS AS EMPRESAS POR FILTRO
function listaEmpresas($dados){
    include("conexao.php");
      $tipo = $dados['tipo_empresa'];
      $emp = $dados['emp'];
      $status = $dados['status'];
      $matriz = $dados['matriz'];
      $convenio = $dados['convenio'];
      
      $where = Array();

      if($tipo){
        $where[] = "`tipo_empresa` = '$tipo'";
      }
      if($matriz){
        $where[] = "`fk_matriz` = '$matriz'";
      }
      if($status){
        $where[] = "`status` = '$status'";
      }
      if($emp){
        $where[] = "`ident` = $emp";
      }
      if($convenio){
        $where[] = "`convenio` = '$convenio'";
      }
      
  
      $sql = "SELECT * FROM  empresas";
      if( sizeof( $where ) ){
        $sql .= ' WHERE '.implode( ' AND ',$where )."";
      }

      $sql = $sql.' ORDER BY nome_fantasia ASC';
    
    $query = $mysqli->query($sql);
    $lines = $query->num_rows;
   
      if($lines < 1){
        $result = array('result' => 'error', 'error' => 'Empresas não encontradas.','msg' => 'Empresas não encontradas.','campo' => $sql);
      }else{
          while($res = $query->fetch_array()){
            // if($res['fk_matriz'] != 0){
              $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_matriz']."");
              if($sel){
                $mat = $sel->fetch_array();
              }
            //   $mat = null;
            // }
           
            $arr[] = array('idemp' => $res['ident'],'razao_social' => ($res['razao_social']),'nome_fantasia' => ($res['nome_fantasia']), 'cnpj' => $res['cnpj'], 'tipo_empresa' => $res['tipo_empresa'], 'matriz' => ($mat['nome_fantasia']),'irrf' => $res['irrf'],'pis' => $res['pis'],'cofins' => $res['cofins'],'inss' => $res['inss'],'csll' => $res['csll'],'iss' => $res['iss'],'status' => $res['status'], 'convenio' => $res['convenio'],'agencia' => $res['agencia'],'conta' => $res['conta']);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr, 'msg' => 'Empresas encontradas', 'campo' => $sql);
          }

      }
      return json_encode($result, JSON_PRETTY_PRINT);
}

function newTable(){

include("conexao.php");
$json_data = json_decode(file_get_contents(__DIR__.'/contas_json.json'));
//print_r($json_data);
$valores = $json_data;
$i = 1;
  foreach($valores as $item){
    
      //echo 'Emp: '.$item->cod_empresa.', Num Conta: '.$item->cod_conta_pagar.', Obs: '.$item->observacoes.', login att'.$item->login_insercao.', login aut'.$item->login_autorizacao.', login exc'.$item->login_exclusao.', dt baix'.$item->dt_baixa.', login baix'.$item->login_baixa.'<br>';
      if($item->dt_vencimento >= '2021-10-01'){
        $up = array();
        if($item->observacoes){
          $up[] = "`obs` = '$item->observacoes'";
        }
        if($item->login_insercao){
          $up[] = "`login_insercao` = '$item->login_insercao'";
        }
        if($item->login_autorizacao){
          $up[] = "`login_baixa` = '$item->login_autorizacao'";
        }
        if($item->login_exclusao){
          $up[] = "`login_exclusao` = '$item->login_exclusao'";
        }
        if($item->dt_baixa){
          $up[] = "`dt_baixa` = '$item->dt_baixa'";
        }
        if($item->login_baixa){
          $up[] = "`login_baixa` = '$item->login_baixa'";
        }
        if($item->hr_baixa){
          $up[] = "`hr_baixa` = '$item->hr_baixa'";
        }
        if($item->hr_exclusao){
          $up[] = "`hr_exclusao` = '$item->hr_exclusao'";
        }
        if($item->hr_autorizacao){
          $up[] = "`hr_autorizacao` = '$item->hr_autorizacao'";
        }
        if($item->hr_insercao){
          $up[] = "`hr_insercao` = '$item->hr_insercao'";
        }

        $sql = "UPDATE `conta_pagar` SET".implode(' , ',$up)."  WHERE `idcntpagar` = $item->cod_conta_pagar AND fk_empresa = $item->cod_empresa";
        $up = $mysqli->query($sql);
        
        if($up){
          echo $i.' - '.$item->cod_conta_pagar.' atualizado com sucesso!<br>';
          echo 'Consula: '.$sql.'<br>';
        }else{
          echo 'Não foi posível att '.$item->cod_conta_pagar.' '.$mysqli->error.'<br>';
        }
        $i++;
      }
  }
}


function upCntRecFrmRec(){

  include("conexao.php");
  $json_data = json_decode(file_get_contents(__DIR__.'/CONTAS A RECEBER.json'));
  //print_r($json_data);
  $valores = $json_data;
  $i = 1;
    foreach($valores as $item){
      
        //echo 'Emp: '.$item->cod_empresa.', Num Conta: '.$item->cod_conta_pagar.', Obs: '.$item->observacoes.', login att'.$item->login_insercao.', login aut'.$item->login_autorizacao.', login exc'.$item->login_exclusao.', dt baix'.$item->dt_baixa.', login baix'.$item->login_baixa.'<br>';
        // if($item->dt_vencimento >= '2021-10-01'){
          $up = array();
          // if($item->observacoes){
          //   $up[] = "`obs` = '$item->observacoes'";
          // }
          // if($item->login_insercao){
          //   $up[] = "`login_insercao` = '$item->login_insercao'";
          // }
          // if($item->login_autorizacao){
          //   $up[] = "`login_baixa` = '$item->login_autorizacao'";
          // }
          // if($item->login_exclusao){
          //   $up[] = "`login_exclusao` = '$item->login_exclusao'";
          // }
          // if($item->dt_baixa){
          //   $up[] = "`dt_baixa` = '$item->dt_baixa'";
          // }
          // if($item->login_baixa){
          //   $up[] = "`login_baixa` = '$item->login_baixa'";
          // }
          // if($item->hr_baixa){
          //   $up[] = "`hr_baixa` = '$item->hr_baixa'";
          // }
          // if($item->hr_exclusao){
          //   $up[] = "`hr_exclusao` = '$item->hr_exclusao'";
          // }
          // if($item->hr_autorizacao){
          //   $up[] = "`hr_autorizacao` = '$item->hr_autorizacao'";
          // }
          // if($item->hr_insercao){
          //   $up[] = "`hr_insercao` = '$item->hr_insercao'";
          // }

          // if($item->cod_forma_recebimento){
            $up[] = "`fk_frmrec` = '$item->cod_forma_recebimento'";
          // }
  
          $sql = "UPDATE `conta_receber` SET".implode(' , ',$up)."  WHERE `idcntrec` = $item->cod_conta_receber";
          $up = $mysqli->query($sql);
          
          if($up){
            echo $i.' - '.$item->cod_conta_receber.' atualizado com sucesso!<br>';
            echo 'Consula: '.$sql.'<br>';
          }else{
            echo 'Não foi posível att '.$item->cod_conta_receber.' '.$mysqli->error.'<br>';
          }
          $i++;
        // }
    }
  }




// LISTA CENTROS DE CUSTO
function listaCentros($dados){
    include("conexao.php");
    $centro = $dados['centro'];
    $emp = $dados['empresa'];
    if(is_array($emp)){
      $tmp = implode(',',$emp);
      $sql1 = "SELECT fk_matriz FROM empresas WHERE ident IN ($tmp)";
      $cons = $mysqli->query($sql1);
        $lines = $cons->num_rows;
        $vet = array();
        if($lines > 0){
          while($resu = $cons->fetch_array()){
            if($resu['fk_matriz']){
              $vet[] = $resu['fk_matriz'];
            }
          }
          $results = array_merge($emp,$vet);
          $ids = implode(',',$results);
        }
    }else{
      $tmp = $emp;
      $sql1 = "SELECT fk_matriz FROM empresas WHERE ident IN ($tmp)";
        $cons = $mysqli->query($sql1);
        $lines = $cons->num_rows;
        if($lines > 0){
          $resu = $cons->fetch_array();
          if($resu['fk_matriz'] != null){
            $fk = $resu['fk_matriz'];
            $ids = $tmp.','.$fk;
          }else{
            $ids = $tmp;
          }
        }
    }
    
      
      $idcentro = $dados['idcentro'];

      $where = Array();

      if($centro){
        $where[] = "`centro` LIKE '%$centro%'";
      } 
      if($idcentro){
        $where[] = "`idcentro` = {$idcentro}";
      }
      if($emp){
        $where[] = "`fk_empresa` IN ({$ids})";
      }

       
      $sql = "SELECT * FROM  centro_custo";
      if( sizeof( $where ) ){
        $sql .= ' WHERE '.implode( ' AND ',$where )."";
      }
      $sql = $sql.' ORDER BY centro ASC';
      //echo $sql;
      $query = $mysqli->query($sql);
      //echo $mysqli->error;

      if(!$query){
        $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campos' => $sql.' Emp: '.$emp,'Vet' => $vet, 'ids' => $ids,'lines' => $lines, 'sql1' => $sql1, 'resu' => $resu, 'dados' =>  $dados);
      }else{
          while($res = $query->fetch_array()){
            echo ($res['obs']);
            $sel = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
            $mat = $sel->fetch_array();
            $arr[] = array('idcentro' => $res['idcentro'],'centro' => ($res['centro']),'fk_empresa' => $mat['ident'], 'empresa' => $mat['nome_fantasia'],'obs' => ($res['obs']),'campo' => $centro);
          }
          if(@sizeof($arr) > 0){
              $result = array('result' => 'sucess', 'datas' => $arr,'campo' => $sql);
          }else{
            $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campos' => $sql.' Emp: '.$emp,'Vet' => $vet);
          }

      }
      return json_encode($result, JSON_PRETTY_PRINT);
}

// LISTA CENTROS DE CUSTO RECEBER
function listaCentrosRec($dados){
  include("conexao.php");
  $centro = $dados['centro'];
    $empresa = $dados['empresa'];
    $idcentro = $dados['idcentro'];

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
          $arr[] = array('idcentrorec' => $res['idcentrorec'],'centro' => ($res['centro']),'fk_empresa' => $mat['ident'],'empresa' => $mat['nome_fantasia'],'obs' => ($res['obs']),'campo' => $centro);
        }
        if(@sizeof($arr) > 0){
            $result = array('result' => 'sucess', 'datas' => $arr);
        }else{
          $result = array('result' => 'error', 'error' => 'Centros de Custos não encontrado.','campo' => $sql);
        }

    }
    return json_encode($result, JSON_PRETTY_PRINT);
}

//INSERIR CENTRO DE CUSTO
function inserirCentro($dados){
  include("conexao.php");
  //print_r($dados);
  $codigo = $dados['codigo'];
  $fk_empresa = $dados['fk_empresa'];
  $centro = ucwords($dados['centro']);
  $obs = $dados['obs'];
  $usuario = $dados['usuario'];

  if($centro){
    $cons = $mysqli->query("SELECT * FROM centro_custo WHERE centro = '$centro' AND fk_empresa = $fk_empresa");
    if($cons->num_rows == 0){
      $sql = "INSERT INTO centro_custo (idcentro,centro, fk_empresa,obs) VALUES ($codigo,'$centro',$fk_empresa,'$obs')";
      $sel = $mysqli->query($sql);
      if($sel){
        $hoje = date("Y-m-d");
        $hora = date("H:i");
        $dados = $centro.' '.$obs;
        $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','centro_custo','$hoje','$hora','".$usuario.",'$dados')");
        $result = array('result' => 'sucess', 'datas' => 'Centro de Custos inserido com sucesso.','msg'  => 'Centro de Custos inserido com sucesso.', 'campo' => $sql);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao inserir Centro de Custos.', 'msg' => $mysqli->error, 'campo' => $sql);
      }
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao inserir Centro de Custos.', 'msg' => 'Centro de Custo já cadastrado', 'campo' => $sql);
    }
   
  }else{
    $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$sql);
  }
  return json_encode($result, JSON_PRETTY_PRINT);
}

//INSERIR CENTRO DE CUSTO RECEBER
function inserirCentroRec($dados){
  include("conexao.php");
  //print_r($dados);
  //$codigo = $dados['codigo'];
  $fk_empresa = $dados['fk_empresa'];
  $centro = strtoupper(addslashes($dados['centro']));
  $obs = $dados['obs'];
  $usuario = $dados['usuario'];

  if($centro){
    $cons = $mysqli->query("SELECT * FROM centro_custo_rec WHERE centro = '$centro' AND fk_empresa = $fk_empresa");
    if($cons->num_rows == 0){
      $sql = "INSERT INTO centro_custo_rec (centro, fk_empresa,obs) VALUES ('$centro',$fk_empresa,'$obs')";
      $sel = $mysqli->query($sql);
      if($sel){
        $hoje = date("Y-m-d");
        $hora = date("H:i");
        $dados = $centro.' '.$obs;
        $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','centro_custo_rec','$hoje','$hora','".$usuario.",'$dados')");
        $result = array('result' => 'sucess', 'datas' => 'Centro de Custos inserido com sucesso.','msg'  => 'Centro de Custos inserido com sucesso.', 'campo' => $sql);
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao inserir Centro de Custos.', 'msg' => $mysqli->error, 'campo' => $sql);
      }
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao inserir Centro de Custos.', 'msg' => 'Centro de Custo já cadastrado', 'campo' => $sql);
    }
   
  }else{
    $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$sql);
  }
  return json_encode($result, JSON_PRETTY_PRINT);
}

// EDITAR CENTRO DE CUSTO RECEBER
function upCentroRec($dados){
  include("conexao.php");
  //print_r($_POST);
  $fk_empresa = $dados['fk_empresa'];
  $centro = strtoupper(addslashes($dados['centro']));
  $obs = $dados['obs'];
  $idcent = $dados['idcent'];
  $usuario = $dados['usuario'];

  if($centro){
    $sel = $mysqli->query("UPDATE centro_custo_rec SET centro = '$centro', obs = '$obs', fk_empresa = $fk_empresa WHERE idcentrorec = $idcent");
    if($sel){
      $hoje = date("Y-m-d");
      $hora = date("H:i");
      $dados = $centro.' '.$obs;
      $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','centro_custo_rec','$hoje','$hora','".$usuario.",'$dados')");
      $result = array('result' => 'sucess', 'datas' => 'Centro de Custos inserido com sucesso.');
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao atualizar Centro de Custos.', 'msg' => $mysqli->error, 'campo' => $centro);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Msg: '.$cnpj);
  }
  return json_encode($result, JSON_PRETTY_PRINT);
}


// EDITAR CENTRO DE CUSTO
function upCentro($dados){
  include("conexao.php");
  //print_r($_POST);
  $fk_empresa = $dados['fk_empresa'];
  $centro = ucwords($dados['centro']);
  $obs = $dados['obs'];
  $idcent = $dados['idcent'];
  $usuario = $dados['usuario'];

  if($centro){
    $sel = $mysqli->query("UPDATE centro_custo SET centro = '$centro', obs = '$obs', fk_empresa = $fk_empresa WHERE idcentro = $idcent");
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
  return json_encode($result, JSON_PRETTY_PRINT);
}


//INSERIR CONTAS PAGAR
function inserirContaPagar($dados){
  include("conexao.php");
  //print_r($dados);
  $nota_fiscal = addslashes($dados['nota_fiscal']);
  if(!$nota_fiscal){
    $nota_fiscal = '0000';
  }
  $fornecedor = $dados['fornecedor'];
  if(!$fornecedor){
    $fornecedor = 0;
  }
  $num_doc = addslashes($dados['num_doc']);
  $dt_doc = $dados['dt_doc'];
  $fk_empresa = $dados['fk_empresa'];
  $parcela = $dados['parcela'];
  $centro = $dados['centro'];
  //$val_doc = $dados['val_doc'];
  //$val_doc = str_replace(',','.',str_replace('.','',$dados['val_doc']));
  $val_doc = $dados['val_doc'];
  $dt_vencimento = $dados['dt_vencimento'];
  $frmpag = $dados['frmpag'];
  $descricao = strtoupper(addslashes($dados['descricao']));
  $docname = addslashes($dados['documento']);
  $obs = addslashes($dados['obs']);
  $dt_entrada = date("Y-m-d");
  $usuario = $dados['usuario'];
  $hora = date("H:i:s");

  if($parcela == 1){
      $sql = "INSERT INTO conta_pagar (fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,login_insercao,hr_insercao) VALUES 
      ($fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$dt_vencimento',$frmpag,'$docname','$descricao','$obs','PENDENTE','ABERTO','$dt_entrada','não','$usuario','$hora')";
      $cons = $mysqli->query($sql);
      if($cons){
        $hoje = date("Y-m-d");
        $hora = date("H:i");
        $dados = $nota_fiscal.' '.$num_doc.' '.$descricao.' '.$obs;
        $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','conta_pagar','$hoje','$hora','".$usuario.",'$dados')");
        //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
        $result = array('result' => 'sucess', 'datas' => 'Conta a Pagar inserida com sucesso.');
      }else{
        $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
      }
    }else{
      for($i=0; $i < $parcela; $i++){
        $dt_tmp = new DateTime($dt_vencimento);
        $dt_tmp->add(new DateInterval('P'.$i.'M'));

        $newdate = $dt_tmp->format("Y-m-d");
        $sql = "INSERT INTO conta_pagar (fk_empresa, fk_fornecedor, fk_centro, num_nota, num_doc, dt_doc, val_doc, dt_vencimento, fk_frmpag, documento, descricao,obs, status_autorizacao, status_pag,dt_entrada, excluida,login_insercao,hr_insercao,parcelas) VALUES 
        ($fk_empresa,$fornecedor,$centro,'$nota_fiscal','$num_doc','$dt_doc',$val_doc,'$newdate',$frmpag,'$docname','$descricao','$obs','PENDENTE','ABERTO','$dt_entrada','não','$usuario','$hora',($i+1))";
        $cons = $mysqli->query($sql);
        if($cons){
          $hoje = date("Y-m-d");
          $hora = date("H:i");
          $dados = $nota_fiscal.' '.$num_doc.' '.$descricao.' '.$obs;
          $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','conta_pagar','$hoje','$hora','".$usuario.",'$dados')");
          //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
          $result = array('result' => 'sucess', 'datas' => 'Conta a Pagar inserida com sucesso.');
        }else{
          $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
        }
      }
    }
   
  return json_encode($result, JSON_PRETTY_PRINT);
}


//ATUALIZAR CONTAS VALORES E CODIGO DE BARRAS
function upContasTmp($dados){
  include("conexao.php");
    $codigo = $dados['codigo'];
    $val_doc = $dados['val_doc'];
    $obs = $dados['obs'];
    $val_pag = $dados['val_pag'];
    $val_desc = $dados['val_desc'];
    $val_mul = $dados['val_mul'];

    $sql = "UPDATE conta_pagar SET obs = '$obs' WHERE idcntpagar = $codigo";

    $sel = $mysqli->query($sql);
    if($sel){
      $hoje = date("Y-m-d");
      $hora = date("H:i");
      $dados = 'Valores atualizados: Valor pago, valor desconto, valor multa e Obs.';
      $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','conta_pagar','$hoje','$hora','$usuario','$dados')");
      if($ins){
         $log = 'Log criado.';
       }else{
         $log = 'Log não criado.';
       }
      //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
      $result = array('result' => 'sucess', 'datas' => 'Conta a Pagar inserida com sucesso.','msg' => 'Conta a Pagar inserida com sucesso. '.$log, 'campo' => $sql, 'log' => $mysqli->error);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
    }
    return json_encode($result, JSON_PRETTY_PRINT);
    
}


//ATUALIZAR CONTAS VALORES E CODIGO DE BARRAS
function upCentrosTmp($dados){
  include("conexao.php");
    $codigo = $dados['codigo'];
    $empresa = $dados['empresa'];
    

    $sql = "UPDATE centro_custo SET fk_empresa = $empresa  WHERE idcentro = $codigo";

    $sel = $mysqli->query($sql);
    if($sel){
      $hoje = date("Y-m-d");
      $hora = date("H:i");
      $dados = 'Valores atualizados: empresas vinculadas.';
      $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','centro_custo','$hoje','$hora','$usuario','$dados')");
      if($ins){
         $log = 'Log criado.';
       }else{
         $log = 'Log não criado.';
       }
      //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
      $result = array('result' => 'sucess', 'datas' => 'Centro att com sucesso.','msg' => 'Centro att com sucesso. '.$log, 'campo' => $sql, 'log' => $mysqli->error);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao att centro.', 'msg' => $mysqli->error, 'campo' => $sql);
    }
    return json_encode($result, JSON_PRETTY_PRINT);
    
}

//ATUALIZAR CLIENTES EMPRESAS
function upClientesTmp($dados){
  include("conexao.php");
    $codigo = $dados['codigo'];
    $empresa = $dados['empresa'];
    

    $sql = "UPDATE clientes SET fk_empresa = $empresa  WHERE idcli = $codigo";

    $sel = $mysqli->query($sql);
    if($sel){
      $hoje = date("Y-m-d");
      $hora = date("H:i");
      $dados = 'Valores atualizados: empresas vinculadas.';
      $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('UPDATE','clientes','$hoje','$hora','$usuario','$dados')");
      if($ins){
         $log = 'Log criado.';
       }else{
         $log = 'Log não criado.';
       }
      //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
      $result = array('result' => 'sucess', 'datas' => 'Cliente att com sucesso.','msg' => 'Cliente att com sucesso. '.$log, 'campo' => $sql, 'log' => $mysqli->error);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao att Cliente.', 'msg' => $mysqli->error, 'campo' => $sql);
    }
    return json_encode($result, JSON_PRETTY_PRINT);
    
}

function contaPagarTmp($dados){
  include("conexao.php");
   //print_r($dados);
   $codigo = $dados['codigo'];
   $nota_fiscal = $dados['nota_fiscal'];
   $fornecedor = $dados['fornecedor'];
   $num_doc = ($dados['num_doc']);
   $dt_doc = $dados['dt_doc'];
   $fk_empresa = $dados['fk_empresa'];
   // $parcela = $dados['parcela'];
   $centro = $dados['centro'];
   //$val_doc = $dados['val_doc'];
   //$val_doc = str_replace(',','.',str_replace('.','',$dados['val_doc']));
   $val_doc = $dados['val_doc'];
   $dt_vencimento = $dados['dt_vencimento'];
   $frmpag = $dados['frmpag'];
   $descricao = strtoupper($dados['descricao']);
   $docname = $dados['documento'];
   $obs = $dados['obs'];
   $dt_entrada = $dados['dt_insercao'];
   $usuario = $dados['usuario'];  
   $dt_pag = $dados['dt_pag']; 
   $val_pag = $dados['val_pag'];
   $val_desc = $dados['val_desc'];
   $val_mul = $dados['val_mul'];
   $status_pag = $dados['status_pag'];
   $status = $dados['status'];
   $dt_aut = $dados['dt_aut'];
   $obs_aut = $dados['obs_aut'];
   $excluida = $dados['excluida'];
   $dt_exc = $dados['dt_exc'];
   $dt_baixa = $dados['dt_baixa'];
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
         $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','conta_pagar','$hoje','$hora','$usuario','$dados')");
         if($ins){
            $log = 'Log criado.';
          }else{
            $log = 'Log não criado.';
          }
         //$result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => 'Documento Já Inserido', 'campo' => $num_doc);
         $result = array('result' => 'sucess', 'datas' => 'Conta a Pagar inserida com sucesso.','msg' => 'Conta a Pagar inserida com sucesso. '.$log, 'campo' => $sql, 'log' => $mysqli->error);
       }else{
         $result = array('result' => 'error', 'error' => 'Erro ao inserir Conta a Pagar.', 'msg' => $mysqli->error, 'campo' => $sql);
       }
     // }
     
   }else{
     $result = array('result' => 'error', 'error' => 'Dados obrigatórios incompletos.','msg' => 'Dados obrigatórios incompletos.', 'campo' => $sql);
   }
   return json_encode($result, JSON_PRETTY_PRINT);
}



//LISTAR FORNECEDORES 
function listaFornecedor($dados){
    include("conexao.php");
    $tipo = $dados['tipo_fornecedor'];
    if(is_array($_POST['empresa'])){
      $emp = implode(',',$dados['empresa']);
    }else{
      $emp = $dados['empresa'];
    }
    
    $cpf_cnpj = $dados['cpf_cnpj'];
    $fornecedor = $dados['fornecedor'];
    $idforn = $dados['id_forn'];

    $where = Array();  
     

    if ($tipo){
      $where[] = "`tipo_fornecedor` =  '$tipo'";
    }
    if($emp){
      $where[] = "`fk_empresa` IN ({$emp})";
    }
    if($cpf_cnpj){
      $where[] = "`cpf_cnpj` = '$cpf_cnpj'";
    }
    if($fornecedor){
      $where[] = "`fornecedor` LIKE '%".$fornecedor."%' OR nome_fantasia LIKE '%$fornecedor%'";
    }
    if($idforn){
      $where[] = "`idforn` = '$idforn'";
    }
    
      //echo $empresa;
      
      $sql = "SELECT * FROM  fornecedores";
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
    return json_encode($result, JSON_PRETTY_PRINT);
}

function graphContaPagarFrmPag($dados){
  include("conexao.php");
  $fornecedor = $dados['fornecedor'];
  if($dados['empresa'] == 0){
  $empresa = '';
  }else{
  $empresa = $dados['empresa'];
  }
  //$tmp = explode(',',$dados['empresa']);
  //$empresas = "'".implode("','",$tmp)."'";
  $centro = $dados['centro'];
  $documento = ($dados['documento']?$dados['documento']:0);
  $nota_fiscal = ($dados['nota_fiscal']?$dados['nota_fiscal']:0);
  $dt_doc_ini = $dados['dt_doc_ini'];
  $dt_doc_fin = $dados['dt_doc_fin'];
  $dt_vencimento_ini = $dados['dt_vencimento_ini'];
  $dt_vencimento_fin = $dados['dt_vencimento_fin'];
  $dt_pag_ini = $dados['dt_pag_ini'];
  $dt_pag_fin = $dados['dt_pag_fin'];
  $dt_ins_ini = $dados['dt_ins_ini'];
  $dt_ins_fin = $dados['dt_ins_fin'];
  $dt_exc_ini = $dados['dt_exc_ini'];
  $dt_exc_fin = $dados['dt_exc_fin'];
  $status = $dados['status'];
  $status_pag = $dados['status_pag'];
  $frm_pag = $dados['frm_pag'];
  if($dados['descricao']){
  $descricao = '%'.$dados['descricao'].'%';
  }else{
  $descricao = $dados['descricao'];
  }
  $codigos = $dados['codigos'];
  $excluida = $dados['excluida'];
  $where = Array();    

  

//echo json_encode(array($empresa,$fornecedor,$frm_pag,$centro,$documento,$nota_fiscal,$dt_doc_ini,$dt_doc_fin,$dt_ins_ini,$dt_ins_fin,$dt_pag_ini,$dt_pag_fin,$dt_vencimento_ini,$dt_vencimento_fin,$status,$descricao,));

  if($fornecedor){
    $frn = $mysqli->query("SELECT idforn FROM fornecedores WHERE fornecedor = '$fornecedor'");
      $where[] = "cp.fk_fornecedor = $fornecedor";
    
  } 
  if ($frm_pag ){
      $where[] = "cp.fk_frmpag = $frm_pag";
    
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
    if($dt_exc_ini && !$dt_exc_fin){
      $where[] = "`dt_exclusao` >= '$dt_vencimento_ini'";
    }
    if (($dt_exc_ini && $dt_exc_fin)){
      $where[] = "`dt_exclusao` between '$dt_exc_ini' AND '$dt_exc_fin'"; 
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

  $sql = "SELECT SUM(cp.val_doc) AS val_doc, SUM(cp.vr_desc) AS vr_desc, SUM(cp.vr_pag) AS vr_pag, SUM(multa) AS multa, cp.fk_empresa, cp.fk_centro, cp.fk_frmpag, fp.pagamento, (FLOOR(RAND() * 401) + 100) AS cor FROM conta_pagar cp JOIN frm_pagamento fp ON(cp.fk_frmpag=fp.idfrmpag) ";
  if( sizeof( $where ) ){
    $sql .= ' WHERE '.implode( ' AND ',$where )."";
  }
  $sql = $sql." GROUP BY cp.fk_frmpag ORDER BY fp.pagamento ASC";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      $cons = $mysqli->query("SELECT * FROM empresas WHERE ident = ".$res['fk_empresa']."");
      $mat = $cons->fetch_array();
      $arr[] = array('val_doc' => $res['val_doc'], 'vr_desc' => $res['vr_desc'], 'vr_pag' => $res['vr_pag'], 'mult' => $res['multa'], 'pagamento' => $res['pagamento'], 'cor' => $res['cor'],'empresa' => $mat['nome_fantasia']);
    }
    if(@sizeof($arr) > 0){
      $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao gerar gráfico', 'campo' => $sql);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

//INSERIR GRUPO
function inserirGrupo($dados){
  include("conexao.php");
  $codigo = $dados['codigo'];
  $grupo = addslashes($dados['grupo']);

  if($grupo){
    $sql = "INSERT INTO grupos (idgrupo,grupo) VALUES ($codigo,'$grupo')";
    $sel = $mysqli->query($sql);

    if($sel){
      $hoje = date("Y-m-d");
        $hora = date("H:i");
        $dados = $grupo.' inserido';
        $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','grupos','$hoje','$hora','".$usuario.",'$dados')");
        if($ins){
          $log = 'Log criado.';
        }else{
          $log = 'Log não criado.';
        }
      $result = array('result' => 'sucess', 'datas' => 'Grupo inserido com sucesso', 'msg' => 'Grupo inserido com sucesso', 'campo' => $sql);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao inserir grupo', 'msg' => 'Erro ao inserir grupo, '.$mysqli->error, 'campo' => $sql);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Erro ao inserir grupo', 'msg' => 'Dados obrigatórios ausentes', 'campo' => $sql);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

//LISTAR GRUPOS GERAL
function listaGrupos(){
  include("conexao.php");
  
  $sql = "SELECT * FROM grupos ORDER BY grupo asc";
  $sel = $mysqli->query($sql);
  if($sel){
    while($res = $sel->fetch_array()){
      $ar[] = array('id_grupo' => $res['id_grupo'], 'grupo' => $res['grupo']);
    }
  }
  if(@sizeof($arr) > 0){
    $result = array('result' => 'sucess', 'datas' => $arr, 'campo' => $sql);
  }else{
    $result = array('result' => 'error', 'error' => 'Nenhum dado encontrado', 'campo' => $sql);
  }

  return json_encode($result,JSON_PRETTY_PRINT);
}

//INSERIR USUARIO
function inserirusuario($dados){
  include("conexao.php");
  $codigo = $dados['codigo'];
  $nome = ucwords($dados['nome']);
  $email = $dados['email'];
  $cpf = $dados['cpf'];
  $login = $dados['login'];
  $senha = md5($dados['senha']);
  //$senha = $dados['senha'];
  $tipo = $dados['tipo'];
  $grupo = $dados['grupo'];
  $tipo = 3;
  $empresa = $dados['empresa'];
  $status = $dados['status'];
  $dt_cad = $dados['dt_cad'];
  $usuario = $dados['usuario'];
  $obs = $dados['obs'];

  if($nome){
    $sql = "INSERT INTO usuarios (iduser,name,email,cpf,user,pass,acces,fk_empresa,fk_grupo,dt_cadastro,status,obs) VALUES ($codigo,'$nome','$email','$cpf','$login','$senha',$tipo,$empresa, $grupo,'$dt_cad','$status','$obs')";
    $sel = $mysqli->query($sql);
    if($sel){
      $hoje = date("Y-m-d");
      $hora = date("H:i");
      $dados = $name.' '.$email.' '.$cpf.' '.$tipo;
      $ins = $mysqli->query("INSERT INTO registros (tipo,tabela,dt_entrada,hora,usuario,dados) VALUES ('INSERT','usuarios','$hoje','$hora','".$usuario.",'$dados')");
      $result = array('result' => 'sucess', 'datas' => 'Usuário inserido com sucesso.', 'msg' => 'Usuário inserido com sucesso.', 'campo' => $sql);
    }else{
      $result = array('result' => 'error', 'error' => 'Erro ao inserir usuário. Usuários já cadastrado','msg' => 'Erro ao inserir usuario, '.$mysqli->error, 'campo' => $sql);
    }
  }else{
    $result = array('result' => 'error', 'error' => 'Dados obrigatorios incompletos.', 'msg' => 'Dados obrigatorios incompletos.','campo' => $sql);
  }
  return json_encode($result, JSON_PRETTY_PRINT);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviaEmail($to,$nameto,$subject,$body,$atach){
 
  $raiz = $_SERVER['DOCUMENT_ROOT'];
  require $raiz.'/contas/vendor/autoload.php';

  $mail = new PHPMailer(true);

  try {
   
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'servidor.hostgator.com.br';                     
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'desenvolvimento@parkfor.com.br';                     
    $mail->Password   = 'Parkfor@123';                              
    $mail->SMTPSecure = 'ssl';            
    $mail->Port       = 465;                                    

   
    $mail->setFrom('desenvolvimento@parkfor.com.br', 'Não responda');
    //$mail->addAddress('joe@example.net', 'Joe User');     
    $mail->addAddress($to,$nameto);               
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    
    $mail->addAttachment($atach);       
   

    
    $mail->isHTML(true);                                 
    $mail->Subject = $subject;
    $mail->Body    = $body.'</br>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $array =  array('result' => 'sucess', 'msg' => 'Email enviaro');
  } catch (Exception $e) {
      $array =  array('result' => 'sucess', 'msg' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
      //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }

  return json_encode($array, JSON_PRETTY_PRINT);
}

//PEGAR SEQUENCIAL BOLETO
function seqBol($dados){
  include("conexao.php");
  $fk_empresa = $dados['fk_empresa'];
  $convenio = $dados['convenio'];
  
  $sql = "SELECT MAX(seq_boleto) AS seq FROM conta_receber WHERE fk_empresa = $fk_empresa AND convenio = '$convenio'";

  $cons = $mysqli->query($sql);

  if($cons){
    $res = $cons->fetch_array();
    $seq = $res['seq'];
    $result =  array('result' => 'sucess', 'datas' => $seq, 'msg' => 'Sequencial recuperado', 'sql' => $sql, 'campo' => $dados);
  }else{
    $result =  array('result' => 'error', 'error' => 'Não foi possível recuperar sequencial', 'msg' => $mysqli->error, 'sql' => $sql, 'campo' => $dados);
  }

  return json_encode($result, JSON_PRETTY_PRINT);
}

?>