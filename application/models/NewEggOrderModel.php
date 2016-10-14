<?php

class NewEggOrderModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function update_status($orderId) {

        $end_point = "ordermgmt/orderstatus/orders/";
        $NewEggApi= new NewEggApi();
        $value = $NewEggApi->getOrders($orderId, $end_point);
        $data=array();
        $data["order_status_code"]  = $value["OrderStatusCode"];
        $data["order_status_name"]  = $value["OrderStatusName"];
        $this->db->where('order_number', $orderId);
        $this->db->update('new_egg_order', $data);
    }

    public function order_detail($orderId) {
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->join('order_item', 'order_detail.order_id = order_item.order_id');
        $this->db->where('order_detail.order_id', $orderId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function record_count() {
        return $this->db->count_all("new_egg_order");
    }

    public function fetch_orders($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get('new_egg_order');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function Show_all_orders() {

        $query = $this->db->get('order');
        return $query->result();
    }

    function SaveOrderId($url, $orderId) {
        $this->db->insert('order', array('url' => $url, 'order_id' => $orderId));
    }

    function SaveOrderDetail($data) {
        $this->db->insert('order_detail', $data);
    }

    function SaveOrder($data) {
        $this->db->insert('new_egg_order', $data);
    }

    function checkOrderIdExist($orderId) {
        $this->db->select("*");
        $this->db->from('new_egg_order');
        $this->db->where('order_number', $orderId);
        $query = $this->db->get();
        return $query->result();
    }

    function getRecord() {
        $end_point = "ordermgmt/orderstatus/orders/";
        $orderIds = array("101062180","101062360","101062420","101062460");
        $NewEggApi = new NewEggApi();
        foreach ($orderIds as $orderId) {
            $value = $NewEggApi->getOrders($orderId, $end_point);
            
            $data["order_number"]       = $value["OrderNumber"];
            $data["seller_id"]          = $value["SellerID"];
            $data["order_status_code"]  = $value["OrderStatusCode"];
            $data["order_status_name"]  = $value["OrderStatusName"];
            $data["order_downloaded"]   = $value["OrderDownloaded"];
    //            $data["sales_channel"]      = $value["SalesChannel"];
    //            $data["fulfillment_option"] = $value["FulfillmentOption"];
            $checkOrderIdExist = $this->checkOrderIdExist($orderId);
            if(!count($checkOrderIdExist)){
                $this->SaveOrder($data);
            }
        }
        return true;
    }

    function updateRecord($status, $orderId) {
        error_reporting(0);
        $endpoint="ordermgmt/orderstatus/orders/";
        $NewEggApi= new NewEggApi();
        $response=$NewEggApi->orderUpdate($endpoint, $status, $orderId);
        $new_status=$response[0]->Result->OrderStatus;
        if($new_status){
            $this->update_status($orderId);
            return "Status updated: ".$new_status;
        }
        else{
            return $response[0]->Message;
        }
    }
    
    
    
    function isValid(){
        $new_egg_obj= new NewEggApi();
        return $new_egg_obj->isValid();
    }

}
