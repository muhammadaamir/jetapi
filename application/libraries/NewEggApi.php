<?php
/** To use this just:
	1. put in your api information at the top
	2. store/retreive your API token in the specified locations
	3.store your api calls 
	
	Ex:  $jet->uploadFile($feed_type, $path);
		$jet->processOrdersByStatus('ready');
		$jet->apiPUT("/orders/".$JET_ORDER_ID."/acknowledge", $data);
	**/
//defined('BASEPATH') OR exit('No direct script access allowed');

class NewEggApi
{
    protected static $api_user_id   = "ed5cdf174a0351a181a22a6eda5ed0a7";
    protected static $api_secret    = "cf8ac89a-d561-4eb3-8f01-e194e94fec19";

//	protected static $merchant_id   = "83aed6a03a794cb7af70cab7cb01dce4";
    protected static  $seller_id="AC4E";
    protected static $api_prefix 	= 'https://api.newegg.com/marketplace/';
    
    
    /*     
     * authorize credentials
     */
    public function isValid(){
        $endpoint="ordermgmt/servicestatus?sellerid=".$this::$seller_id;
        $ch= curl_init($this::$api_prefix.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization:'.$this::$api_user_id ,'SecretKey:'.$this::$api_secret , 'Content-type: application/json','Accept: application/json') );
        $response= curl_exec($ch);
        $error= curl_error($ch);
        curl_close($ch);
        if(strpos($response, 'Invalid')||  strpos($response, 'invalid'))                
            return FALSE;
        else                
            return TRUE;

    }
        

                
        public function getOrders(){
                        $orders_array=array("101062180","101062360","101062420","101062460");
            for($i=0;$i<count($orders_array);$i++) {
                $end_point="ordermgmt/orderstatus/orders/".$orders_array[$i]."?sellerid=AC4E";
                $ch = curl_init($this::$api_prefix . $end_point);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization:'.$this::$api_user_id,'SecretKey:'.$this::$api_secret,'Content-type: application/json','Accept: application/json' ) );
                $response = curl_exec($ch);
                return $response;
            }

                
//            $data[] = array("OrderDownloaded"=> true,
//                "OrderNumber"=> "159243598",
//                "OrderStatusCode"=> 1,
//                "OrderStatusName"=> "PartiallyShipped",
//                "SellerID"=> "A006",
//                "SalesChannel"=>0,
//                "FulfillmentOption"=>0);
//        
//            $data[] = array("OrderDownloaded"=> true,
//                "OrderNumber"=> "159243599",
//                "OrderStatusCode"=> 2,
//                "OrderStatusName"=> "Shipped",
//                "SellerID"=> "A006",
//                "SalesChannel"=>0,
//                "FulfillmentOption"=>1);
//            
//            return $data;
        }
        
        public function orderUpdate($orderId, $status){
            
            $response = true; //call api function
            
            return $response;
        }
        
        public function orderShipped($orderId){
            
            $response = true; //call api function
            
            return $response;
        }
        
        public function orderCancel($orderId){
            
            $response = true; //call api function
            
            return $response;
        }
        
        public function orderStatus($status){
            
            
            return $data;
        }
        
        public function getNewToken(){
		$ch = curl_init($this::$api_prefix.'/Token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');
		$request = json_encode(array(
			"user" => $this::$api_user_id,
			"pass" => $this::$api_secret
		));                                              
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($request))                                                                       
		);       
		$data = curl_exec($ch);
		curl_close($ch);
		if($data = json_decode($data)){
			if($token = $data->id_token){
				//SAVE $token SOMEWHERE and save last time you got a token
				$this->setToken($token);
				return true;
			}
		}
		return false;
	}

	/**
	 * Upload bulk file to Jet
	 **/
	public function uploadFile($type, $path){
    		$data = $this->apiGET('files/uploadToken');
		$url = $data->url;
		$file_id = $data->jet_file_id;
		$this->apiFilePUT($url, $path, $file_id);
		$response = $this->apiGET('files/uploaded', array("url" => $url, "file_type" => $type, "file_name" => basename($path)));
                return $response;
    }

	/**
	 * PUT request to $url
	 **/
	public function apiPUT($end_point, $request){
		
		if(substr($end_point,0,1) === "/") $end_point = substr($end_point,1);
		
		//get token if it has been over 9 hours since the last token
		//CHANGE THIS TO WHERE YOU SAVED THE TOKEN AND TS
		if($this->getToken())	$this->getNewToken();

		$api_call_data = array();
		$api_call_data["request_ts"] = date("r", strtotime("now"));
		
		$ch = curl_init($this::$api_prefix . $end_point);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');
		$request = json_encode($request);              
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($request),
			 //CHANGE THIS TO WHERE YOU SAVED YOUR TOKEN
			'Authorization: Bearer ' . $this->getToken()  )                                                                       
		);       
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
		$data = curl_exec($ch);
		
		echo (curl_error ($ch ));
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$api_call_data["request_data"]  = (string)var_export($request, true);
		$api_call_data["response_ts"]   = date("r", strtotime("now"));
		$api_call_data["response_data"] = (string)var_export($data, true);
		$api_call_data["request_url"]   = $this::$api_prefix . $end_point;
		$api_call_data["service_type"]  = "Jet";
		$api_call_data["status_code"]   = $httpcode;
		//SAVE $api_call_data SOMEWHERE
		
		return json_decode($data);
	}

	/**
	 * PUT request to $url
	 **/
	public function apiFilePUT($url, $path, $file_id = null){
		//get token if it has been over 9 hours since the last token
		//CHANGE THIS TO WHERE YOU SAVED THE TOKEN AND TS
		if($this->getToken())	$this->getNewToken();

		$api_call_data = array();
		$api_call_data["request_ts"] = date("r", strtotime("now"));
		
		//gzip the data
		$file = file_get_contents($path);
		$gz_file = gzencode($file,9);
		$g_path = $path.".gz";
		$gfp = fopen($g_path, 'w+');
		fwrite($gfp, $gz_file);
		rewind($gfp);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_PUT, 1);
		//If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(  'x-ms-blob-type: BlockBlob' ) );
		curl_setopt($ch, CURLOPT_INFILE, $gfp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($g_path));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec ($ch);
		fclose($gfp);
		
		//delete the file / gzip file
		//unlink($path);
		unlink($g_path);
		
		$api_call_data["response_ts"] = date("r", strtotime("now"));
		$api_call_data["response_data"] = (string)var_export($data, true);
		$api_call_data["request_url"] = $url;
		$api_call_data["service_type"] = "Jet";
		$api_call_data["check_status"] = true;
		if($file_id) $api_call_data["service_id"] = $file_id;
		//SAVE $api_call_data
		return $data;
	}

	/**
	 * Jet API GET
	 **/
	public function apiGET($end_point, $request = null){
		if(substr($end_point,0,1) === "/") $end_point = substr($end_point,1);
		//get token if it has been over 9 hours since the last token
		//CHANGE THIS TO WHERE YOU SAVED THE TOKEN AND TS
		if($this->getToken())	$this->getNewToken();

		$api_call_data = array();
		$api_call_data["request_ts"] = date("r", strtotime("now"));
		
		$ch = curl_init($this::$api_prefix . $end_point);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $this->getToken() ) );
		//If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');
		if($request){
			$request = json_encode($request);                                              
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
			$api_call_data["request_data"] = (string)var_export($request, true);
		}
		$data = utf8_encode (curl_exec($ch));
		echo (curl_error ($ch ));
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$api_call_data["response_ts"] = date("r", strtotime("now"));
		$api_call_data["response_data"] = (string)var_export($data, true);
		$api_call_data["request_url"] = $this::$api_prefix . $end_point;
		$api_call_data["service_type"] = "Jet";
		$api_call_data["status_code"] = $httpcode;
		//SAVE $api_call_data
		
		return json_decode($data);
	}
	
	/**
	* Poll for orders
	**/
	public function processOrdersByStatus($status){
		$data = $this->apiGET("orders/$status");
		foreach($data->order_urls as $end_point){
			$this->processOrder($end_point);
		}
	}
	
	/**
	* Process Order
	**/
	public function processOrder($end_point){
		$data = $this->apiGET($end_point);
		//STORE AND PROCESS $data
	}
        
        public function setToken($token){
		$_SESSION['setToken'] = $token;
                $_SESSION['time']     = time();
                return $_SESSION['setToken'];
	}
        
        public function getToken(){
            return $_SESSION['setToken'];
        }
}
