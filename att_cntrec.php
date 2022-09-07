<?php
    include("includes/load.php"); 
    include("includes/funcoes.php");
    include("includes/control.php"); 
    $data = date("Y-m-d");
    $dias = 1;
    $novadata = date('Y-m-d', strtotime("-{$dias} days",strtotime($data)));

    $params = [
        'dt_vencimento_fin' => $data,
        'status' => 'ABERTO',
        'action' => '46'
    ];
    $result = loadApi($params);
    // print_r($result);
    $list = $result->datas;
    print_r($list);

    foreach($list as $item){
        $par = [
            'idcnt' => $item->id_conta,
            'status' => 'ATRASADO',
           ];
        $res = json_decode(atualiza_sit_bol($par));
        print_r($res);
    }

?>