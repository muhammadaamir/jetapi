<?php

class NewEggOrderModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_pkg_details($orderId){
        $this->db->select('*');
    }

    public function get_order_detail($orderId) {
        $this->db->select('*');
        $this->db->from('neweggorders');
        $this->db->join('newegg_item_info', 'neweggorders.order_number = newegg_item_info.order_number');
//        $this->db->join('newegg_pkg_info','neweggorders.order_number = newegg_pkg_info.order_number');
//        $this->db->join('newegg_pkg_item_info','neweggorders.order_number = newegg_pkg_item_info.order_number');
        $this->db->where('neweggorders.order_number', $orderId);
        $query = $this->db->get();
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
            
//            foreach ($pkgiteminfo[0] as $pkgitem) {
//                 $this->db->insert('newegg_pkg_item_info',$pkgitem);
//            }
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
     //   error_reporting(0);
        $NewEggApi= new NewEggApi();
        $toShip_details=$this->get_order_detail($orderId);
        
        if($status=='cancel'||$status=='ship'){
            for($i=0;$i<count($toShip_details);$i++){
                $request_fields[$i]=array(
                    "status"=>$status,
                    "seller_part_number"=>$toShip_details[$i]->seller_part_number,
                    "ordered_qty"=>$toShip_details[$i]->ordered_quantity );
            }
            $endpoint="ordermgmt/orderstatus/orders/";
            $response=$NewEggApi->orderUpdate($endpoint, $orderId, $request_fields);
            if($response){
                if($status=='cancel')
                    $new_status=$response[0]["Result"]["OrderStatus"];
                else
                    $new_status=$response["Result"]["OrderStatus"];
            
                if($new_status){
                    $this->update_status($orderId,$status);
                    return "Status :". $new_status."..Process Result msg: ".$response["Result"]["Shipment"]["PackageList"][0]["ProcessResult"];
                }
                else{
                    return $response[0]["Message"];
                }
            }
        }
        else{
            $request_fields=array();
            $endpoint="shippingservice/shippinglabel/shippingrequest?sellerid=";
            $response= $NewEggApi->order_delivery($endpoint,$orderId,$request_fields);
            if($response){
                return $response;
            }
            else{
                return $response[0]["Message"];
            }
        }         
    }

    public function insert_order_details(){
        $orderIds = array("101062180","101062360","101062420","101062460","101355900","101355920" , "101355980",
            "101356020","101356060","101356080","101356140","101356200","101356260","101356280");
        $NewEggApi = new NewEggApi();
        foreach ($orderIds as $orderId) {
            $checkOrderIdExist = $this->checkOrderIdExist($orderId);
            if(!count($checkOrderIdExist)){
                $value=$NewEggApi->orderDetails($orderId);
                $iteminfo=array();
                $pkgiteminfo=array();
                $pkginfo=  array();
                $neweggorder=array();  

                $neweggorder["order_number"]        = $value["ResponseBody"]["OrderInfoList"][0]["OrderNumber"];
                $neweggorder["seller_id"]           = $value["SellerID"];
                $neweggorder["invoice_number"]      = $value["ResponseBody"]["OrderInfoList"][0]["InvoiceNumber"];
                $neweggorder["order_downloaded"]    = $value["ResponseBody"]["OrderInfoList"][0]["OrderDownloaded"];
                $neweggorder["order_date"]          = $value["ResponseBody"]["OrderInfoList"][0]["OrderDate"];
                $neweggorder["order_status"]        = $value["ResponseBody"]["OrderInfoList"][0]["OrderStatus"];
                $neweggorder["order_status_description"]  = $value["ResponseBody"]["OrderInfoList"][0]["OrderStatusDescription"];
                $neweggorder["customer_name"]       = $value["ResponseBody"]["OrderInfoList"][0]["CustomerName"];
                $neweggorder["customer_phone_number"]  =$value["ResponseBody"]["OrderInfoList"][0]["CustomerPhoneNumber"];
                $neweggorder["customer_email"]      = $value["ResponseBody"]["OrderInfoList"][0]["CustomerEmailAddress"];
                $neweggorder["address1"]            = $value["ResponseBody"]["OrderInfoList"][0]["ShipToAddress1"];
                $neweggorder["address2"]            = $value["ResponseBody"]["OrderInfoList"][0]["ShipToAddress2"];
                $neweggorder["city"]                = $value["ResponseBody"]["OrderInfoList"][0]["ShipToCityName"];
                $neweggorder["state_code"]          = $value["ResponseBody"]["OrderInfoList"][0]["ShipToStateCode"];
                $neweggorder["zip_code"]            = $value["ResponseBody"]["OrderInfoList"][0]["ShipToZipCode"];
                $neweggorder["country_code"]        = $value["ResponseBody"]["OrderInfoList"][0]["ShipToCountryCode"];
                $neweggorder["ship_service"]        = $value["ResponseBody"]["OrderInfoList"][0]["ShipService"];
                $neweggorder["order_item_amount"]   = $value["ResponseBody"]["OrderInfoList"][0]["OrderItemAmount"];
                $neweggorder["shipping_amount"]     = $value["ResponseBody"]["OrderInfoList"][0]["ShippingAmount"];
                $neweggorder["discount_amount"]     = $value["ResponseBody"]["OrderInfoList"][0]["DiscountAmount"];
                $neweggorder["order_quantity"]      = $value["ResponseBody"]["OrderInfoList"][0]["OrderQty"];
                $neweggorder["refund_amount"]       = $value["ResponseBody"]["OrderInfoList"][0]["RefundAmount"];
     //           $neweggorder["sales_tax"]           = $value["ResponseBody"]["OrderInfoList"][0]["SalesTax"];
                $neweggorder["order_total_amount"]  = $value["ResponseBody"]["OrderInfoList"][0]["OrderTotalAmount"];
                $neweggorder["sales_channel"]       = $value["ResponseBody"]["OrderInfoList"][0]["SalesChannel"];
                $neweggorder["fulfillment_option"]  = $value["ResponseBody"]["OrderInfoList"][0]["FulfillmentOption"];
                
                $item_info_array=$value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"];
                for($i=0;$i<count($item_info_array);$i++){
                    $iteminfo[$i]["order_number"]           = $value["ResponseBody"]["OrderInfoList"][0]["OrderNumber"];
                    $iteminfo[$i]["seller_part_number"]     = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["SellerPartNumber"];
                    $iteminfo[$i]["item_number"]            = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["NeweggItemNumber"];
                    $iteminfo[$i]["mfr_part_number"]        = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["MfrPartNumber"];
                    $iteminfo[$i]["upc_code"]               = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["UPCCode"];
                    $iteminfo[$i]["ordered_quantity"]       = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["OrderedQty"];
                    $iteminfo[$i]["shipped_quantity"]       = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["ShippedQty"];
                    $iteminfo[$i]["unit_price"]             = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["UnitPrice"];
                    $iteminfo[$i]["status"]                 = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["Status"];
                    $iteminfo[$i]["status_description"]     = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][$i]["StatusDescription"];
                }
                $pkg=$value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"];
                if(!empty($pkg)){
                    for($i=0;$i<count($pkg);$i++){

                        $pkginfo[$i]["order_number"]            = $orderId;
                        $pkginfo[$i]["pkg_type"]                = $pkg[$i]["PackageType"];
                        $pkginfo[$i]["ship_carrier"]            = $pkg[$i]["ShipCarrier"];
                        $pkginfo[$i]["ship_service"]            = $pkg[$i]["ShipService"];
                        $pkginfo[$i]["tracking_number"]         = $pkg[$i]["TrackingNumber"];
                        $pkginfo[$i]["ship_date"]               = $pkg[$i]["ShipDate"];

                       // $this->db->insert('newegg_pkg_info',$pkginfo);
                        $pkgItem=$pkg[$i]["ItemInfoList"];

                        for($j=0;$j<count($pkgItem);$j++){
                            $pkgiteminfo[$i][$j]["order_number"]        = $orderId;
                            $pkgiteminfo[$i][$j]["seller_part_number"]  = $pkgItem[$j]["SellerPartNumber"];
                            $pkgiteminfo[$i][$j]["mfr_part_number"]     = $pkgItem[$j]["MfrPartNumber"];
                            $pkgiteminfo[$i][$j]["shipped_quantity"]    = $pkgItem[$j]["ShippedQty"];
                        }
                    }
                }
                
                $this->SaveOrderDetail($neweggorder, $iteminfo,$pkginfo,$pkgiteminfo);
            }
      
        }     
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
    
    public function remove_item($orderId){
        $NewEggApi=new NewEggApi();
        $details_response=$this->get_order_detail($orderId);
        $SPartNumber= $details_response[0]->seller_part_number;
        $response=$NewEggApi->removeItem($orderId,$SPartNumber);
        return $response;
    }
            
    public function is_valid(){
        $NewEggApi= new NewEggApi();
        return $NewEggApi->isValid();
    }

}
