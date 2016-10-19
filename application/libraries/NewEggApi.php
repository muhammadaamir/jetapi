<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class NewEggApi
{
    protected static $api_user_id   = "ed5cdf174a0351a181a22a6eda5ed0a7";
    protected static $api_secret    = "cf8ac89a-d561-4eb3-8f01-e194e94fec19";
    protected static  $seller_id    = "AC4E";
    protected static $api_prefix    = 'https://api.newegg.com/marketplace/';
    
    
       
    function get_tracking_num(){
        $length=6;
        $string="";
        while ($length>0){
            $string.= dechex(mt_rand(0, 15));
            $length--;
        }
        return $string;
    }
    
    
    /*     
     * authorize credentials
     */
    public function isValid(){
        $endpoint="ordermgmt/servicestatus?sellerid=".$this::$seller_id;
        $ch= curl_init($this::$api_prefix.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Authorization:'.self::$api_user_id ,'SecretKey:'.$this::$api_secret , 'Content-type: application/json','Accept: application/json') );
        $response= curl_exec($ch);
        $error= curl_error($ch);
        curl_close($ch);
        if(strpos($response, 'Invalid')||  strpos($response, 'invalid'))                
            return FALSE;
        else                
            return TRUE;

    }
    
    
    public function create_json($data){
        $data = preg_replace('/: /', ':', $data);
        $data = preg_replace('/, /', ',', $data);
        $data = preg_replace('/[^A-Za-z0-9\- :,.\{\}\[\]\(\)"]/', '', $data);
        $data = preg_replace('/\[ /', '[', $data);
        $data = preg_replace('/ \]/', ']', $data);
        $data = preg_replace('/\{ /', '{', $data);
        $data = preg_replace('/ \}/', '}', $data);
//        $data = '{'. $data;
        $data = json_decode($data, true);
        return $data;
    }
                   
    public function getOrders($orderId, $end_point){
        
        $end_point = $end_point.$orderId."?sellerid=".self::$seller_id;
        $ch = curl_init(self::$api_prefix . $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 
            'Authorization:'.self::$api_user_id,
            'SecretKey:'.self::$api_secret,
            'Content-Type: application/json',
            'Accept: application/json' ) );
        $data =  curl_exec($ch);
        return $this->create_json($data);

//        return $this->create_json($data);
    }
        
    public function orderUpdate($endpoint,$orderId,$request_fields){
        $endpoint=$endpoint.$orderId."?sellerid=".self::$seller_id."&version=304";
        $action= ($request_fields["status"]=='cancel')? $action='1' :$action='2';
        if($action=='1'){
            $request_body=array(
                'Action'=>$action,
                'Value'=>'72'
            );
        }
        else{
            $request_body=array(
                'Action'=>$action,
                'Value' => array(
                    'Shipment'=>array(
                        'Header'=>array(
                            "SellerID"=>self::$seller_id,
                            "SONumber"=>$orderId
                        ),
                        'PackageList'=>array(
                            'Package'=>array(
                                'TrackingNumber'=>  $this->get_tracking_num(),
                                'ShipCarrier'=>'TCS',
                                'ShipService'=>'ground',
                                'ItemList'=>array(
                                    'Item'=>array(
                                        'SellerPartNumber'=>$request_fields["seller_part_number"],
                                        'ShippedQty'=>$request_fields["shipped_qty"]
                                    )

                                )
                            )
                        )
                    )
                ),

            );
        }
        $request_body=  json_encode($request_body);
        $ch=  curl_init(self::$api_prefix.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization:'.self::$api_user_id,
            'SecretKey:'.self::$api_secret,
            'Content-Type: application/json',
            'Accept: application/json' ) );
        $data=  curl_exec($ch);
        return json_decode($data);

//            return $this->create_json($data);
    }
    
    public function orderDetails($orderId){
        $endpoint="ordermgmt/order/orderinfo?sellerid=".self::$seller_id."&version=304";
        $request_body=array(
            'OperationType'=>'GetOrderInfoRequest',
            'RequestBody'=>array(
                'RequestCriteria'=>array(
                    'OrderNumberList'=>array(
                        'OrderNumber'=>$orderId
                    )
                )
            )
        );
        $request_body=  json_encode($request_body);
        $ch=  curl_init(self::$api_prefix.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization:'.self::$api_user_id,
            'SecretKey:'.self::$api_secret,
            'Content-Type: application/json',
            'Accept: application/json' ) );
        $data=  curl_exec($ch);
        return $this->create_json($data);
    }

    public function confirmOrder($orderId){
        $endpoint="ordermgmt/orderstatus/orders/confirmation?sellerid=".self::$seller_id;
        $request_body=  array(
            'OperationType'=>'OrderConfirmationRequest',
            'RequestBody'=>array(
                'DownloadedOrderList'=>array(
                    'OrderNumber'=>$orderId
                )
            )
        );
        $request_body=  json_encode($request_body);
        $ch=  curl_init(self::$api_prefix.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization:'.self::$api_user_id,
            'SecretKey:'.self::$api_secret,
            'Content-Type: application/json',
            'Accept: application/json' ) );
        $data=  curl_exec($ch);
        return $this->create_json($data);     
    }
    
    
    public function removeItem($orderId,$SPartNumber){
        $endpoint="ordermgmt/killitem/orders/".$orderId."?sellerid=".self::$seller_id;
        $request_body=array(
            'OperationType'=>'KillItemRequest',
            'RequestBody'=>array(
                'KillItem'=>array(
                    'Order'=>array(
                        'ItemList'=>array(
                            'Item'=>array(
                                'SellerPartNumber'=>$SPartNumber
                            )
                        )
                    )
                )
            )
        );
        $request_body=  json_encode($request_body);
        $ch=  curl_init(self::$api_prefix.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Authorization:'.self::$api_user_id,
            'SecretKey:'.self::$api_secret,
            'Content-Type: application/json',
            'Accept: application/json' ) );
        $data=  curl_exec($ch);
        return $this->create_json($data);    
    }
    
}



	

        
 
        
     

