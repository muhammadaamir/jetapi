<?php

class NewEggOrderModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_order_detail($orderId) {
        $this->db->select('*');
        $this->db->from('neweggorders');
        $this->db->join('newegg_item_info', 'neweggorders.order_number = newegg_item_info.order_number');
        //$this->db->join('newegg_pkg_info', 'neweggorders.order_number = newegg_pkg_info.order_number');
        $this->db->where('neweggorders.order_number', $orderId);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    
    public function getPackageInfo($orderId){
        $this->db->select('*');
        $this->db->from('neweggorders');  
        $this->db->join('newegg_pkg_info', 'neweggorders.order_number = newegg_pkg_info.order_number');
        $this->db->where('neweggorders.order_number', $orderId);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function record_count() {
        return $this->db->count_all("neweggorders");
    }

    public function fetch_orders($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get('neweggorders');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function SaveOrderDetail($neweggorder,$iteminfo,$pkginfo,$pkgiteminfo) {
        $this->db->insert('neweggorders', $neweggorder);
        foreach ($iteminfo as $item) {
            $this->db->insert('newegg_item_info',$item);
        }
        if(!empty($pkginfo)){
            foreach ($pkginfo as $pkg) {
                $this->db->insert('newegg_pkg_info',$pkg);
            }
            
            for($i=0;$i<count($pkginfo);$i++){
               foreach ($pkgiteminfo[$i] as $pkgitem) {
                   $this->db->insert('newegg_pkg_item_info',$pkgitem);
               }
            }
        }
    }
    
    function checkOrderIdExist($orderId) {
        $this->db->select("*");
        $this->db->from('neweggorders');
        $this->db->where('order_number', $orderId);
        $query = $this->db->get();
        return $query->result();
    }
    
    function update_status($orderId,$status) {

        $NewEggApi= new NewEggApi();
        $response = $NewEggApi->orderDetails($orderId);
        
        $this->db->set('order_status',$response["ResponseBody"]["OrderInfoList"][0]["OrderStatus"]);
        $this->db->set('order_status_description',$response["ResponseBody"]["OrderInfoList"][0]["OrderStatusDescription"]);
        $this->db->where('order_number', $orderId);
        $this->db->update('neweggorders');
        
        for($i=0;$i<count($response["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"]);$i++){
            $this->db->set('status',$response["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["Status"]);
            $this->db->set('status_description',$response["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["StatusDescription"]);
            $this->db->set('shipped_quantity',$response["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["ShippedQty"]);
            $this->db->where('order_number', $orderId);
            $this->db->update('newegg_item_info');
        }
        if($status=='ship'){
            $pkg=$response["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"];
   //         $pkgItem=$response["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ItemInfoList"];
            for($i=0;$i<count($pkg);$i++){
                $pkginfo=array();
                
                $pkginfo["order_number"]            = $orderId;
                $pkginfo["pkg_type"]                = $pkg[$i]["PackageType"];
                $pkginfo["ship_carrier"]            = $pkg[$i]["ShipCarrier"];
                $pkginfo["ship_service"]            = $pkg[$i]["ShipService"];
                $pkginfo["tracking_number"]         = $pkg[$i]["TrackingNumber"];
                $pkginfo["ship_date"]               = $pkg[$i]["ShipDate"];
                
                $checkOrderIdExist = $this->checkOrderIdExist($orderId);
                if(!count($checkOrderIdExist)){
                    $this->db->insert('newegg_pkg_info',$pkginfo);
                }
                else{
                    $this->db->where('order_number',$orderId);
                    $this->db->update('newegg_pkg_info',$pkginfo);    
                }
                
                $pkgItem=$pkg[$i]["ItemInfoList"];
                
                for($j=0;$j<count($pkgItem);$j++){
                    
                    $pkgiteminfo["order_number"]        = $orderId;
                    $pkgiteminfo["seller_part_number"]  = $pkgItem[$j]["SellerPartNumber"];
                    $pkgiteminfo["mfr_part_number"]     = $pkgItem[$j]["MfrPartNumber"];
                    $pkgiteminfo["shipped_quantity"]    = $pkgItem[$j]["ShippedQty"];
                    
                    if(!count($checkOrderIdExist)){
                        $this->db->insert('newegg_pkg_item_info',$pkgiteminfo);
                    }
                    else{
                        $this->db->where('order_number',$orderId);
                        $this->db->update('newegg_pkg_item_info',$pkgiteminfo);
                    }
                    $pkgiteminfo=array();
                    
                }         
            }      
        }
    }

    public function updateRecord($status, $orderId) {
        error_reporting(0);
        $NewEggApi= new NewEggApi();
        $toShip_details=$this->get_order_detail($orderId);
        
        if($status=='cancel'||$status=='ship'){
            for($i=0;$i<count($toShip_details);$i++){
                $request_fields[$i]=array(
                    "status"=>$status,
                    "seller_part_number"=>$toShip_details[$i]->seller_part_number,
                    "ordered_qty"=>$toShip_details[$i]->ordered_quantity );
            }
            
            $response=$NewEggApi->orderUpdate($orderId, $request_fields);
            if($response){
                if(($response["UpdateOrderStatusInfo"]["IsSuccess"])=='true'){
                    $this->update_status($orderId,$status);
                    return TRUE;
                }
                else{
                    return $response[0]["Message"];
                }
            }
        }
        else{
            for($i=0;$i<count($toShip_details);$i++){
                $request_fields[$i]=array(
                    "first_name"    =>$toShip_details[$i]->ship_to_first_name,
                    "last_name"     =>$toShip_details[$i]->ship_to_last_name,
                    "contact_number"=>$toShip_details[$i]->customer_phone_number,
                    "address1"      =>$toShip_details[$i]->address1,
                    "address2"      =>$toShip_details[$i]->address2,
                    "city"          =>$toShip_details[$i]->city,
                    "state"         =>$toShip_details[$i]->state_code,
                    "zip"           =>$toShip_details[$i]->zip_code,
                    "country"       =>$toShip_details[$i]->country_code,
                    "seller_part_number"=>$toShip_details[$i]->seller_part_number,
                    "ordered_qty"   =>$toShip_details[$i]->ordered_quantity   
                );
            }
            
            $response= $NewEggApi->order_delivery($orderId,$request_fields);
            if($response){
                if(($response["NeweggAPIResponse"]["IsSuccess"])=='true')
                    return $response;
                else{
                    return $response[0]["Message"];
                }
            }
        }
    }

    public function insert_order_details(){
        $NewEggApi = new NewEggApi();
        $value=$NewEggApi->orderDetails();
//        print_r($value);
//        die();
        for($cnt=0;$cnt<$value["ResponseBody"]["PageInfo"]["TotalCount"];$cnt++){
            $checkOrderIdExist = $this->checkOrderIdExist($value["ResponseBody"]["OrderInfoList"][$cnt]["OrderNumber"]);
            if(!count($checkOrderIdExist)){
                
                $iteminfo=array();
                $pkgiteminfo=array();
                $pkginfo=  array();
                $neweggorder=array();  

                $neweggorder["order_number"]        = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderNumber"];
                $neweggorder["seller_id"]           = $value["SellerID"];
                $neweggorder["invoice_number"]      = $value["ResponseBody"]["OrderInfoList"][$cnt]["InvoiceNumber"];
                $neweggorder["order_downloaded"]    = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderDownloaded"];
                $neweggorder["order_date"]          = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderDate"];
                $neweggorder["order_status"]        = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderStatus"];
                $neweggorder["order_status_description"]  = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderStatusDescription"];
                $neweggorder["customer_name"]       = $value["ResponseBody"]["OrderInfoList"][$cnt]["CustomerName"];
                $neweggorder["customer_phone_number"]  =$value["ResponseBody"]["OrderInfoList"][$cnt]["CustomerPhoneNumber"];
                $neweggorder["customer_email"]      = $value["ResponseBody"]["OrderInfoList"][$cnt]["CustomerEmailAddress"];
                $neweggorder["address1"]            = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToAddress1"];
                $neweggorder["address2"]            = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToAddress2"];
                $neweggorder["city"]                = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToCityName"];
                $neweggorder["state_code"]          = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToStateCode"];
                $neweggorder["zip_code"]            = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToZipCode"];
                $neweggorder["country_code"]        = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToCountryCode"];
                $neweggorder["ship_service"]        = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipService"];
                $neweggorder["ship_to_first_name"]  = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToFirstName"];
                $neweggorder["ship_to_last_name"]   = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToLastName"];
                $neweggorder["ship_to_company"]     = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShipToCompany"];
                $neweggorder["order_item_amount"]   = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderItemAmount"];
                $neweggorder["shipping_amount"]     = $value["ResponseBody"]["OrderInfoList"][$cnt]["ShippingAmount"];
                $neweggorder["discount_amount"]     = $value["ResponseBody"]["OrderInfoList"][$cnt]["DiscountAmount"];
                $neweggorder["order_quantity"]      = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderQty"];
                $neweggorder["refund_amount"]       = $value["ResponseBody"]["OrderInfoList"][$cnt]["RefundAmount"];
     //           $neweggorder["sales_tax"]           = $value["ResponseBody"]["OrderInfoList"][$cnt]["SalesTax"];
                $neweggorder["order_total_amount"]  = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderTotalAmount"];
                $neweggorder["sales_channel"]       = $value["ResponseBody"]["OrderInfoList"][$cnt]["SalesChannel"];
                $neweggorder["fulfillment_option"]  = $value["ResponseBody"]["OrderInfoList"][$cnt]["FulfillmentOption"];
                
                $item_info_array=$value["ResponseBody"]["OrderInfoList"][$cnt]["ItemInfoList"];
                for($i=0;$i<count($item_info_array);$i++){
                    $iteminfo[$i]["order_number"]           = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderNumber"];
                    $iteminfo[$i]["seller_part_number"]     = $item_info_array[$i]["SellerPartNumber"];
                    $iteminfo[$i]["item_number"]            = $item_info_array[$i]["NeweggItemNumber"];
                    $iteminfo[$i]["mfr_part_number"]        = $item_info_array[$i]["MfrPartNumber"];
                    $iteminfo[$i]["upc_code"]               = $item_info_array[$i]["UPCCode"];
                    $iteminfo[$i]["ordered_quantity"]       = $item_info_array[$i]["OrderedQty"];
                    $iteminfo[$i]["shipped_quantity"]       = $item_info_array[$i]["ShippedQty"];
                    $iteminfo[$i]["unit_price"]             = $item_info_array[$i]["UnitPrice"];
                    $iteminfo[$i]["status"]                 = $item_info_array[$i]["Status"];
                    $iteminfo[$i]["status_description"]     = $item_info_array[$i]["StatusDescription"];
                }
                $pkg=$value["ResponseBody"]["OrderInfoList"][$cnt]["PackageInfoList"];
                if(!empty($pkg)){
                    for($i=0;$i<count($pkg);$i++){

                        $pkginfo[$i]["order_number"]            = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderNumber"];
                        $pkginfo[$i]["pkg_type"]                = $pkg[$i]["PackageType"];
                        $pkginfo[$i]["ship_carrier"]            = $pkg[$i]["ShipCarrier"];
                        $pkginfo[$i]["ship_service"]            = $pkg[$i]["ShipService"];
                        $pkginfo[$i]["tracking_number"]         = $pkg[$i]["TrackingNumber"];
                        $pkginfo[$i]["ship_date"]               = $pkg[$i]["ShipDate"];

                        $pkgItem=$pkg[$i]["ItemInfoList"];

                        for($j=0;$j<count($pkgItem);$j++){
                            $pkgiteminfo[$i][$j]["order_number"]        = $value["ResponseBody"]["OrderInfoList"][$cnt]["OrderNumber"];
                            $pkgiteminfo[$i][$j]["seller_part_number"]  = $pkgItem[$j]["SellerPartNumber"];
                            $pkgiteminfo[$i][$j]["mfr_part_number"]     = $pkgItem[$j]["MfrPartNumber"];
                            $pkgiteminfo[$i][$j]["shipped_quantity"]    = $pkgItem[$j]["ShippedQty"];
                        }
                    }
                }
                
                $this->SaveOrderDetail($neweggorder, $iteminfo,$pkginfo,$pkgiteminfo);
            }
        }
        //$this->get_from_newegg_warehouse();
        return true;
    }   
    
    public function confirm_order($orderId){
        $NewEggApi= new NewEggApi();
        $response=$NewEggApi->confirmOrder($orderId);
        if(($response["NeweggAPIResponse"]["IsSuccess"])=="true"){
            return "Order Confirmation Succeeded";
        }
        else{
            return "Order Confirmation Failed! ".$response[0]["Message"];
        }
    }
    
    function get_sPartNumber(){
        $this->db->distinct();
        $this->db->select('seller_part_number');
        $query = $this->db->get('newegg_item_info');
        if($query->num_rows()>0){
            return $query->result();   
        }
        return FALSE;
    }


    
    public function get_from_newegg_warehouse(){
        foreach ($this->get_sPartNumber() as $sPartNumber) {
            $spn[]=$sPartNumber->seller_part_number;
        }
        $NewEggApi= new NewEggApi();
        $response= $NewEggApi->fromNeweggWarehouse($spn);
        if($response){
            print_r($response);
            die();
            //return $response;
        }
        else {
            return $response[0]["Message"];
        }
    }

    public function remove_item($orderId){
        $NewEggApi=new NewEggApi();
        $details_response=$this->get_order_detail($orderId);
        $SPartNumber= $details_response[0]->seller_part_number;
        $response=$NewEggApi->removeItem($orderId,$SPartNumber);
        return $response;
    }
    
    public function shipping_request_details($orderId){
        $NewEggApi= new NewEggApi();
        $response=  $NewEggApi->get_shipping_request_details($orderId);
        if($response["NeweggAPIResponse"]){
            return $response;
        }
        else{
            return $response[0]["Message"];
        }      
    }

    public function confirm_shipping_request(){
        $requestIdArray=array();
        $NewEggApi= new NewEggApi();
        $response = $NewEggApi->get_confirm_shipping_request($requestIdArray);
        if($response["NeweggAPIResponse"]){
            return $response;
        }
        else{
            return $response[0]["Message"];
        }
    }
    
    
    // "void shipping request" function

    public function package_list(){
        $NewEggApi = new NewEggApi();
        $response = $NewEggApi->get_package_list($requestId,$orderId);
        if($response["NeweggAPIResponse"]){
            return $response;
        }
        else{
            return $response[0]["Message"];
        }
    }


    public function is_valid(){
        $NewEggApi= new NewEggApi();
        return $NewEggApi->isValid();
    }
    
    

}
