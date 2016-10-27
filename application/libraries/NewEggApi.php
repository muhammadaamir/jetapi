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
    }
    
    public function order_delivery($orderId,$request_fields){
        $endpoint="shippingservice/shippinglabel/shippingrequest?sellerid=".self::$seller_id;
        for($i=0;$i<count($request_fields);$i++){
            $item_body[$i] = array(
                'SellerPartNumber'  => $request_fields[$i]["seller_part_number"],
                'Quantity'          => $request_fields[$i]["ordered_qty"]
            );
        }
        for($i=0;$i<1;$i++){
            $pkg_body[$i]   = array(
                'PackageWeight'=> '5',
                'PackageLength'=> '5.00',
                'PackageHeight'=> '4.00',
                'PackageWidth' => '3.00',
                'ItemList'     => array(
                    'Item'      => $item_body
                )
                
            );
        }
        $request_body   =   array(
            'OperationType' =>  "SubmitShippingRequest",
            'RequestBody'   =>  array(
                'Shipment'  =>  array(
                    'OrderNumber'        =>  $orderId,
                    'ShippingCarrierCode'=> '100',
                    'ShippingServiceCode'=> '101',
                    'ShipFromFirstName'  => $request_fields[0]["first_name"],
                    'ShipFromLastName'   => $request_fields[0]["last_name"],
                    'ShipFromPhoneNumber'=> $request_fields[0]["contact_number"],
                    'ShipFromAddress1'   => $request_fields[0]["address1"],
                    'ShipFromCityName'   => $request_fields[0]["city"],
                    'ShipFromStateCode'  => $request_fields[0]["state"],
                    'ShipFromZipCode'    => $request_fields[0]["zip"],
                    'ShipFromCountryCode'=> 'USA',
                    'PackageList'        => array(
                        'Package'        => $pkg_body
                    )
                )
            )
        );
        $request_body=  json_encode($request_body);
        //print_r($request_body);
        //die();
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

        public function orderUpdate($orderId,$request_fields){
        $endpoint="ordermgmt/orderstatus/orders/".$orderId."?sellerid=".self::$seller_id."&version=304";
        $action= ($request_fields[0]["status"]=='cancel')? $action="1" :$action="2";
        if($action=="1"){
            $request_body=array(
                'Action'=>$action,
                'Value'=>'72'
            );
        }
        else{
            $num_of_pkg=count($request_fields);
            for($i=0;$i<$num_of_pkg;$i++){
                $pkg_body[$i]=array(
                                'TrackingNumber'=>  $this->get_tracking_num(),
                                'ShipCarrier'=>'TCS',
                                'ShipService'=>'ground',
                                'ItemList'=>array(
                                    'Item'=>array(
                                        'SellerPartNumber'=>$request_fields[$i]["seller_part_number"],
                                        'ShippedQty'=>$request_fields[$i]["ordered_qty"]
                                    )
                                )
                        );
            }
            
            $request_body=array(
                'Action'=>$action,
                'Value' => array(
                    'Shipment'=>array(
                        'Header'=>array(
                            "SellerID"=>self::$seller_id,
                            "SONumber"=>(int)$orderId
                        ),
                        'PackageList'=>array(
                            'Package'=>$pkg_body
                        )
                    )
                ),

            );
        }
        $request_body=  json_encode($request_body);
//        print_r($request_body);
//        die();
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
//        return json_decode($data);

            return $this->create_json($data);
    }
    
    public function orderDetails(){
        $endpoint="ordermgmt/order/orderinfo?sellerid=".self::$seller_id."&version=304";
        $request_body=array(
            'OperationType'=>'GetOrderInfoRequest',
            'RequestBody'=>array(
                'RequestCriteria'=>array(
                    'OrderNumberList'=>array(
//                        'OrderNumber'=>$orderId
                    )
                )
            )
        );
        $request_body=  json_encode($request_body);
//        print_r($request_body);
//        die();
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
                    'OrderNumber'=> (int)$orderId
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
    
    
    public function fromNeweggWarehouse($sPartNumber){
        $endpoint="sbnmgmt/inboundshipment/plansuggestion?sellerid=".self::$seller_id;
        for($i=0;$i<count($sPartNumber);$i++){
            $item_body[$i]=array(
                'SellerPartNumber'  =>  $sPartNumber[$i],
                'PlannedQuantity'   =>  20
            );
        }
        $request_body=array(
            'OperationType' =>  'GetPlanSuggestionRequest',
            'RequestBody'   =>  array(
                'PlanSuggestion'    =>  array(
                    'ItemList'  =>  array(
                        'Item'  =>  $item_body
                    )
                )
            )
        );
        $request_body= json_encode($request_body);
//        print_r($request_body);
//        die();
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
    
    public function get_shipping_request_details($orderId){
        $endpoint="shippingservice/shippinglabel/shippingdetail?sellerid=".self::$seller_id;
        $request_body=array(
            'OperationType' =>'GetShippingDetailRequest',
            'RequestBody'   => array(
                //'RequestID' => '',
                'OrderNumber'   => $orderId
            )
        );
        $request_body= json_encode($request_body);
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
    
    public function get_confirm_shipping_request($requestIdArray){
        $endpoint= "shippingservice/shippinglabel/confirmshippingrequest?sellerid=".self::$seller_id;
        $requestID = array();
        foreach ($requestIdArray as $id) {
            $requestID[] = $id;
        }
        $request_body=array(
            'OperationType' =>'ConfirmShippingRequest',
            'RequestBody'   => array(
                'RequestIDList' => $requestID
            )
        );
        $request_body= json_encode($request_body);
        //print_r($request_body);
        //die();
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
    
    public function get_package_list($requestId,$orderId){
        $endpoint = "shippingservice/shippinglabel/packagelist?sellerid=".self::$seller_id;
        $request_body=array(
            'OperationType' =>'GetPackageListRequest',
            'RequestBody'   => array(
                'RequestID'     => $requestId,
                'OrderNumber'   => $orderId
            )
        );
        $request_body= json_encode($request_body);
        //print_r($request_body);
        //die();
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



	

        
 
        
     

