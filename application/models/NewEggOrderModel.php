<?php

class NewEggOrderModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_order_detail($orderId) {
        $this->db->select('*');
        $this->db->from('neweggorders');
        $this->db->join('newegg_item_info', 'neweggorders.order_number = newegg_item_info.order_number');
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

    function SaveOrderDetail($neweggorder,$iteminfo, $pkginfo, $pkgiteminfo) {
        $this->db->insert('neweggorders', $neweggorder);
        $this->db->insert('newegg_item_info',$iteminfo);
        $this->db->insert('newegg_pkg_info',$pkginfo);
        $this->db->insert('newegg_pkg_item_info',$pkgiteminfo);
    }

    function checkOrderIdExist($orderId) {
        $this->db->select("*");
        $this->db->from('neweggorders');
        $this->db->join('newegg_item_info','neweggorders.order_number = newegg_item_info.order_number');
        $this->db->join('newegg_pkg_info','neweggorders.order_number = newegg_pkg_info.order_number');
        $this->db->join('newegg_pkg_item_info','neweggorders.order_number = newegg_pkg_item_info.order_number');
        $this->db->where('neweggorders.order_number', $orderId);
        $query = $this->db->get();
        return $query->result();
    }
    
    function update_status($orderId,$status,$ship_date) {

        $end_point = "ordermgmt/orderstatus/orders/";
        $NewEggApi= new NewEggApi();
        $value = $NewEggApi->getOrders($orderId, $end_point);
        
        $this->db->set('order_status',$value['OrderStatusCode']);
        $this->db->set('order_status_description',$value['OrderStatusName']);
        $this->db->where('order_number', $orderId);
        $this->db->update('neweggorders');
        if($status=='cancel'){
           
            $pkg_info_fields=array('pkg_type','ship_carrier','ship_service','tracking_number','ship_date');
            foreach ($pkg_info_fields as $field) {
                $this->db->set($field,NULL);
            }
            $this->db->where('order_number', $orderId);
            $this->db->update('newegg_pkg_info');
            
            $pkg_item_info_fields=array('seller_part_number','mfr_part_number','shipped_quantity');
            foreach ($pkg_item_info_fields as $field2) {
                $this->db->set($field2,NULL);
            }
            $this->db->where('order_number', $orderId);
            $this->db->update('newegg_pkg_item_info');
        }
        else{
            $this->db->set('ship_date',$ship_date);
            $this->db->where('order_number', $orderId);
            $this->db->update('newegg_pkg_info');
        }
    }

    public function updateRecord($status, $orderId) {
        error_reporting(0);
        $endpoint="ordermgmt/orderstatus/orders/";
        $NewEggApi= new NewEggApi();
        $response=$NewEggApi->orderUpdate($endpoint, $status, $orderId);
        $new_status=$response[0]->Result->OrderStatus;
        $ship_date=$response[0]->Result->Shipment->PackageList[0]->ShipDate;
        if($new_status){
            $this->update_status($orderId,$status,$ship_date);
            return "Status updated: ".$new_status;
        }
        else{
            return $response[0]->Message;
        }
    }
    // on confirm_order .. call insert_order_details to save the details in db
    public function insert_order_details(){
        $orderIds = array("101062180","101062360","101062420","101062460");
        $NewEggApi = new NewEggApi();
        foreach ($orderIds as $orderId) {
            $value=$NewEggApi->orderDetails($orderId);
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
            
            $iteminfo["order_number"]           = $value["ResponseBody"]["OrderInfoList"][0]["OrderNumber"];
            $iteminfo["seller_part_number"]     = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["SellerPartNumber"];
            $iteminfo["item_number"]            = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["NeweggItemNumber"];
            $iteminfo["mfr_part_number"]        = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["MfrPartNumber"];
            $iteminfo["upc_code"]               = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["UPCCode"];
            $iteminfo["ordered_quantity"]       = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["OrderedQty"];
            $iteminfo["shipped_quantity"]       = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["ShippedQty"];
            $iteminfo["unit_price"]             = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["UnitPrice"];
            $iteminfo["status"]                 = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["Status"];
            $iteminfo["status_description"]     = $value["ResponseBody"]["OrderInfoList"][0]["ItemInfoList"][0]["StatusDescription"];
            
            $pkginfo["order_number"]            = $value["ResponseBody"]["OrderInfoList"][0]["OrderNumber"];
//            $pkginfo["pkg_type"]                = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["PackageType"];
//            $pkginfo["ship_carrier"]            = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ShipCarrier"];
//            $pkginfo["ship_service"]            = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ShipService"];
//            $pkginfo["tracking_number"]         = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["TrackingNumber"];
//            $pkginfo["ship_date"]               = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ShipDate"];
//            
            $pkgiteminfo["order_number"]        = $value["ResponseBody"]["OrderInfoList"][0]["OrderNumber"];
//            $pkgiteminfo["seller_part_number"]  = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ItemInfoList"][0]["SellerPartNumber"];
//            $pkgiteminfo["mfr_part_number"]     = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ItemInfoList"][0]["MfrPartNumber"];
//            $pkgiteminfo["shipped_quantity"]    = $value["ResponseBody"]["OrderInfoList"][0]["PackageInfoList"][0]["ItemInfoList"][0]["ShippedQty"];
            
            $checkOrderIdExist = $this->checkOrderIdExist($orderId);
            if(!count($checkOrderIdExist)){
                $this->SaveOrderDetail($neweggorder, $iteminfo, $pkginfo, $pkgiteminfo);
            }
        }
        return true;
    }
    
    public function confirm_order($orderId){
        $NewEggApi= new NewEggApi();
        $response=$NewEggApi->confirmOrder($orderId);
        if($response){
            $this->insert_order_details($orderId);
            return TRUE;
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
