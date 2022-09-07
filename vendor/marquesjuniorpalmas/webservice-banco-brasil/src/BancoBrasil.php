<?php

namespace MarquesJunior\BancoBrasil;

class BancoBrasil {
    
    
    private $clientID;
    private $clientSecret;
    private $developer_application_key;
    private $urlToken;
    private $urls;
    
    private $ambiente;
    
    private $queryString;

    private $complements;
    
    private $base64;
    
    private $headers;
    private $header;
    
    private $fields;
    
    
    public function __construct($clientID, $clientSecret, $developer_key, $ambiente = 'producao') {
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->developer_application_key = $developer_key;
        $this->base64 = "{$this->clientID}:{$this->clientSecret}";
        
        if($ambiente == 'sandbox'){
            $this->urlToken = 'https://oauth.sandbox.bb.com.br/oauth/token';
            $this->urls = 'https://api.sandbox.bb.com.br/cobrancas/v2';
            $this->queryString = '?gw-app-key=';
            $this->ambiente = $ambiente;
            $this->complements = '';
        }else{
            $this->urlToken = 'https://oauth.bb.com.br/oauth/token';
            $this->urls = 'https://api.bb.com.br/cobrancas/v2';
            $this->queryString = '?gw-dev-app-key=';
            $this->ambiente = $ambiente;
            $this->complements = '';
        }
    }
    
    
    public function getTokenAcess()
    {
        
        $fields['grant_type'] = 'client_credentials';
        $fields['scope'] = 'cobrancas.boletos-info cobrancas.boletos-requisicao';
        $this->fields($fields,'query');
        
        $ci = curl_init($this->urlToken);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_POST, true);
        curl_setopt($ci, CURLOPT_POSTFIELDS, $this->fields);
        curl_setopt($ci, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
            'Authorization: Basic '. base64_encode($this->clientID.':'.$this->clientSecret).''
        ]);
        
        $resposta = curl_exec($ci);
        curl_close($ci);
        
        $resultado = json_decode($resposta);
        
        return $resultado;
    }
    
    protected function headers(array $headers): void {
        if (!$headers) { return; }
        foreach ($headers as $k => $v) {
            $this->header($k,$v);
        }
    }
    
    protected function header(string $key, string $value): void {
        if(!$key || is_int($key)){ return; }
        $keys = filter_var($key, FILTER_SANITIZE_STRIPPED);
        $values = filter_var($value, FILTER_SANITIZE_STRIPPED);
        $this->headers[] = "{$keys}: {$values}";
    }
    
    protected function fields(array $fields, string $format="json"): void {
        if($format == "json") {
            $this->fields = (!empty($fields) ? json_encode($fields) : null);
        }
        if($format == "query"){
            $this->fields = (!empty($fields) ? http_build_query($fields) : null);
        }
    }

    
    protected function upload(array $fields) {
        if(empty($fields)){ $this->fields = null; return;}
        foreach ($fields as $key => $field){
            $this->fields[$key] = curl_file_create(
                $field['tmp_name'],
                $field['type'],
                $field['name']
            );
        }
    }
    
    public function registerBoleto(array $fields = null){
        
        if($this->ambiente == 'sandbox'){
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Developer-Application-Key" => $this->developer_application_key
            ]);
        }else{
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Application-Key" => $this->developer_application_key
            ]);
        }
        
        $this->fields($fields,'json');
        
        $curl = curl_init("{$this->urls}/boletos{$this->queryString}{$this->developer_application_key}");
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->fields,
            CURLOPT_HTTPHEADER => ($this->headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => true
        ]);
        
        $data = json_decode(curl_exec($curl));
        
        return $data;
    }
    
    public function alterBoleto($idBoleto, array $fields = null){
        
        if($this->ambiente == 'sandbox'){
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Developer-Application-Key" => $this->developer_application_key
            ]);
        }else{
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Application-Key" => $this->developer_application_key
            ]);
        }
        
        $this->fields($fields,'json');
        
        $curl = curl_init("{$this->urls}/boletos/{$idBoleto}{$this->queryString}{$this->developer_application_key}");
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => $this->fields,
            CURLOPT_HTTPHEADER => ($this->headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => true
        ]);
        
        $data = json_decode(curl_exec($curl));
        
        return $data;
    }
    
    public function baixaBoleto($idBoleto, array $fields = null){
        
        if($this->ambiente == 'sandbox'){
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Developer-Application-Key" => $this->developer_application_key
            ]);
        }else{
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Application-Key" => $this->developer_application_key
            ]);
        }
        
        $this->fields($fields,'json');
        
        $curl = curl_init("{$this->urls}/boletos/{$idBoleto}/baixar{$this->queryString}{$this->developer_application_key}");
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->fields,
            CURLOPT_HTTPHEADER => ($this->headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => true
        ]);
        
        $data = json_decode(curl_exec($curl));
        
        return $data;
    }
    
    // public function readBoleto($idBoleto, $convenio){
        
    //     if($this->ambiente == 'sandbox'){
    //         $this->headers([
    //             "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
    //             "X-Developer-Application-Key" => $this->developer_application_key
    //         ]);
    //     }else{
    //         $this->headers([
    //             "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
    //             "X-Application-Key" => $this->developer_application_key
    //         ]);
    //     }
        
    //     $curl = curl_init("{$this->urls}/boletos/{$idBoleto}?numeroConvenio={$convenio}");
    //     curl_setopt_array($curl,[
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_POSTFIELDS => [],
    //         CURLOPT_HTTPHEADER => ($this->headers),
    //         CURLOPT_SSL_VERIFYPEER => false,
    //         CURLINFO_HEADER_OUT => true
    //     ]);
        
    //     $data = json_decode(curl_exec($curl));
        
    //     return $data;
    // }
    public function readBoleto($idBoleto, $convenio){
        
        if($this->ambiente == 'sandbox'){
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Developer-Application-Key" => $this->developer_application_key
            ]);
        }else{
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Application-Key" => $this->developer_application_key
            ]);
        }
        
        $curl = curl_init("{$this->urls}/boletos/{$idBoleto}{$this->queryString}{$this->developer_application_key}&numeroConvenio={$convenio}");
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => ($this->headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => true
        ]);
        
        $data = json_decode(curl_exec($curl));
        
        return $data;
    }

    public function listaBoleto($agencia, $conta,$situacao,$cod_situacao,$data_reg_ini,$data_reg_fin,$data_venc_ini,$data_venc_fin){
        
        if($this->ambiente == 'sandbox'){
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Developer-Application-Key" => $this->developer_application_key
            ]);
        }else{
            $this->headers([
                "Authorization"     => "Bearer " . $this->getTokenAcess()->access_token,
                "Content-Type"      => "application/json",
                // "X-Application-Key" => $this->developer_application_key
            ]);
        }

        if($cod_situacao){
            $this->complements .= '&codigoEstadoTituloCobranca='.$cod_situacao;
        }
        if($data_reg_ini != null && $data_reg_fin != null){
            $this->complements .= '&dataInicioRegistro='.str_replace('/','.',$data_reg_ini).'&dataFimRegistro='.str_replace('/','.',$data_reg_fin);
        }
        if($data_venc_ini != null && $data_venc_fin != null){
            $this->complements .= '&dataInicioVencimento='.str_replace('/','.',$data_venc_ini).'&dataFimVencimento='.str_replace('/','.',$data_venc_fin);
        }
        
        $curl = curl_init("{$this->urls}/boletos{$this->queryString}{$this->developer_application_key}&indicadorSituacao={$situacao}&agenciaBeneficiario={$agencia}&contaBeneficiario={$conta}{$this->complements}");
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => ($this->headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => true
        ]);
        
        $data = json_decode(curl_exec($curl));
        
        return $data;
    }
}