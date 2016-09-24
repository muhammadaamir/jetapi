<?php

class OrderReturnModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function checkOrderIdExist($orderId){
        $this->db->select("*");
        $this->db->from('order_return');
        $this->db->where('order_id', $orderId);
        $query = $this->db->get();
        return $query->result();
    }
    
    function insertOrderReturns($data){
        $this->db->insert('order_return', $data);
        
    }
    
    function insertReturnMerchantSkus($data){
        $this->db->insert('return_merchant_skus', $data);
    }
    
    public function record_count() {
        return $this->db->count_all("order");
    }
    
      public function fetch_orders($limit, $start) {
        $this->db->limit($limit, $start);

        $this->db->select('*')
        ->from('order_return');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    
    public function getRecord($status){
        $JetApi     = new JetApi();
        $JetApi->getNewToken();
        $token      = $JetApi->getToken();
        $end_point  = "returns/" . $status;
        $response   = $JetApi->apiGET($end_point, null);
        foreach ($response as $values) {
            foreach ($values as $value) {
                $url         = $value;
                $orderDetail = explode("returns/state/", $url);
                $orderId = $orderDetail[1];
                $checkOrderIdExist = $this->checkOrderIdExist($orderId);
                if(!count($checkOrderIdExist)){
                    $orderDetail = $JetApi->apiGET($url, null);
                    $data["merchant_return_authorization_id"] = $orderDetail->merchant_return_authorization_id;
                    $data["reference_return_authorization_id"] = $orderDetail->reference_return_authorization_id;
                    $data["return_status"] = $orderDetail->return_status;
                    $data["refund_without_return"] = (bool)$orderDetail->refund_without_return;
                    $data["merchant_order_id"] = $orderDetail->merchant_order_id;
                    $data["reference_order_id"] = $orderDetail->reference_order_id;
                    $data["alt_order_id"] = $orderDetail->alt_order_id;
                    $data["return_date"] = $orderDetail->return_date;
                    $data["shipping_carrier"] = $orderDetail->shipping_carrier;
                    $data["tracking_number"] = $orderDetail->tracking_number;
                    $data["merchant_return_charge"] = (float)$orderDetail->merchant_return_charge;
                    $data['order_id'] = $orderId;
                    foreach ($orderDetail->return_merchant_SKUs as $item){
                        $dataitem['order_item_id']      = $item->order_item_id;
                        $dataitem['alt_order_item_id']  = $item->alt_order_item_id;
                        $dataitem['merchant_sku']       = $item->merchant_sku;
                        $dataitem['return_quantity']    = (int)$item->return_quantity;
                        $dataitem['reason']         = "no longer need/want";
                        $dataitem['principal']      = (float)$item->requested_refund_amount->principal;
                        $dataitem['tax']            =  (float)$item->requested_refund_amount->tax;
                        $dataitem['shipping_cost']  = (float)$item->requested_refund_amount->shipping_cost;
                        $dataitem['shipping_tax']   =  (float)$item->requested_refund_amount->shipping_tax;
                        $dataitem['order_id']       = $orderId;
                        $this->OrderReturnModel->insertReturnMerchantSkus($dataitem);
                    }
                   
                    $this->OrderReturnModel->insertOrderReturns($data);
                }else{
                    
                }   
            }       
        }
    }

    public function order_detail($orderId) {
        $this->db->select('*');    
        $this->db->from('order_return');
        $this->db->join('return_merchant_skus', 'order_return.order_id = return_merchant_skus.order_id');
        $this->db->where('order_return.order_id',$orderId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    
}
