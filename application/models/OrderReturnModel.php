<?php

class OrderReturnModel extends CI_Model {

    public function __construct() {
        parent::__construct();
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
    
    public function order_detail($orderId) {
        $this->db->select('*');    
        $this->db->from('order_return');
        $this->db->join('return_merchant_skus', 'order_return.order_item_id = return_merchant_skus.order_item_id');
        $this->db->where('order_return.order_item_id',$orderId);
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
