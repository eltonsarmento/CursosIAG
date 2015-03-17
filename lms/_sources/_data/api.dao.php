<?php
// ===================================================================
class ApiDAO {
    // =================================================================== 
    private $system = NULL;
    // ===================================================================
    public function __construct() {
		$this->system =& getInstancia();		
	}
    // ===================================================================
    public function rdStation_lead( $identifier, $data_array ) {
        
        $api_url = "http://www.rdstation.com.br/api/1.2/conversions";
        $rdstation_token = "c6afdcfc58eded9c1077be69a6f68c2d";
        
        try {
            
            if (empty($data_array["token_rdstation"]) && !empty($rdstation_token)) { $data_array["token_rdstation"] = $rdstation_token; }
            if (empty($data_array["identificador"]) && !empty($identifier)) { $data_array["identificador"] = $identifier; }
            if (empty($data_array["c_utmz"])) { $data_array["c_utmz"] = $_COOKIE["__utmz"]; }

            if ( !empty($data_array["token_rdstation"]) && !( empty($data_array["email"]) && empty($data_array["email_lead"]) ) ) {
                
                $data_query = http_build_query($data_array);
                
                if (in_array ('curl', get_loaded_extensions())) {
                    
                    $ch = curl_init($api_url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_query);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_exec($ch);
                    
                    curl_close($ch);
                    
                } else {
                
                    $params = array('http' => array('method' => 'POST', 'content' => $data_query, 'ignore_errors' => true));
                    $ctx = stream_context_create($params); 
                    $fp = @fopen($api_url, 'rb', false, $ctx);
                }
            }
            
        } catch (Exception $e) { }
        
	}
    
}