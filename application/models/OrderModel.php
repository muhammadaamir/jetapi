<?php

class OrderModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function update_status($orderId, $status) {
        $this->db->where('order_id', $orderId);
        $this->db->update('order_detail', $status);
    }
    
    public function order_detail($orderId) {
        $this->db->select('*');    
        $this->db->from('order_detail');
        $this->db->join('order_item', 'order_detail.order_id = order_item.order_id');
        $this->db->where('order_detail.order_id',$orderId);
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
        return $this->db->count_all("order");
    }

    public function fetch_orders($limit, $start) {
        $this->db->limit($limit, $start);
//        $query = $this->db->get("order");
        
//        $this->db->select('order_detail.order_id, order_detail.url, order_detail.order_placed_date, order_detail.buyer_name, order_detail.status, order_detail.buyer_phone_number, order_detail.product_title, order_detail.shipping_to_address_address1,order_item.base_price');    
//        $this->db->from('order_detail');
//        $this->db->join('order_item', 'order_detail.order_id = order_item.order_id');
        $this->db->where('status !=','reject');
        $query = $this->db->get('order_detail');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
   
    function Show_all_orders()
    {

        $query = $this->db->get('order');
        return $query->result();
        

    }
    
    function SaveOrderId($url, $orderId) {
        $this->db->insert('order', array('url' => $url, 'order_id' => $orderId));
    }

    function SaveOrderDetail($data) {
        $this->db->insert('order_detail', $data);
    }

    function SaveOrderItem($data) {
        $this->db->insert('order_item', $data);
    }
    
    function checkOrderIdExist($orderId){
        $this->db->select("*");
        $this->db->from('order');
        $this->db->where('order_id', $orderId);
        $query = $this->db->get();
        return $query->result();
    }
    
    function getRecord($status) {
        $end_point = "orders/" . $status;
        $JetApi = new JetApi();
        $JetApi->getNewToken();
        $token = $JetApi->getToken();
        $response = $JetApi->apiGET($end_point, null);
        foreach ($response as $values) {
            foreach ($values as $value) {
                $url = $value;
                $orderDetail = explode("withoutShipmentDetail/", $url);
                $orderId = $orderDetail[1];
                $checkOrderIdExist = $this->checkOrderIdExist($orderId);
                if(!count($checkOrderIdExist)){
                    $this->SaveOrderId($url, $orderId);
                    $orderDetail = $JetApi->apiGET($url, null);
                    $data["alt_order_id"] = $orderDetail->alt_order_id;
                    $data["buyer_name"] = $orderDetail->buyer->name;
                    $data["buyer_phone_number"] = $orderDetail->buyer->phone_number;
                    $data["customer_reference_order_id"] = $orderDetail->customer_reference_order_id;
                    $data["fulfillment_node"] = $orderDetail->fulfillment_node;
                    $data["has_shipments"] = $orderDetail->has_shipments;
                    $data["hash_email"] = $orderDetail->hash_email;
                    $data["jet_request_directed_cancel"] = $orderDetail->jet_request_directed_cancel;
                    $data["merchant_order_id"] = $orderDetail->merchant_order_id;
                    $data["order_detail_request_shipping_method"] = $orderDetail->order_detail->request_shipping_method;
                    $data["order_detail_request_shipping_carrier"] = $orderDetail->order_detail->request_shipping_carrier;
                    $data["order_detail_request_service_level"] = $orderDetail->order_detail->request_service_level;
                    $data["order_detail_request_ship_by"] = $orderDetail->order_detail->request_ship_by;
                    $data["order_detail_request_delivery_by"] = $orderDetail->order_detail->request_delivery_by;
                    foreach ($orderDetail->order_items as $item) {
                        $dataItem["order_item_id"] = $item->order_item_id;
                        $dataItem["merchant_sku"] = $item->merchant_sku;
                        $dataItem["request_order_quantity"] = $item->request_order_quantity;
                        $dataItem["request_order_cancel_qty"] = $item->request_order_cancel_qty;
                        $dataItem["item_tax_code"] = $item->item_tax_code;
                        $dataItem["item_tax"] = $item->item_price->item_tax;
                        $dataItem["item_shipping_cost"] = $item->item_price->item_shipping_cost;
                        $dataItem["item_shipping_tax"] = $item->item_price->item_shipping_tax;
                        $dataItem["base_price"] = $item->item_price->base_price;
                        $dataItem["order_id"] = $orderId;
                        $this->SaveOrderItem($dataItem);
                    }
                    $data["product_title"] = $item->product_title;
                    $data["url"] = $item->url;
                    $data["order_placed_date"] = $orderDetail->order_placed_date;
                    $data["order_totals_item_price_item_tax"] = $orderDetail->order_totals->item_price->item_tax;
                    $data["order_totals_item_price_item_shipping_cost"] = $orderDetail->order_totals->item_price->item_shipping_cost;
                    $data["order_totals_item_price_item_shipping_tax"] = $orderDetail->order_totals->item_price->item_shipping_tax;
                    $data["order_totals_item_price_base_price"] = $orderDetail->order_totals->item_price->base_price;
                    $data["order_transmission_date"] = $orderDetail->order_transmission_date;
                    $data["reference_order_id"] = $orderDetail->reference_order_id;
                    $data["shipping_to_recipient_name"] = $orderDetail->shipping_to->recipient->name;
                    $data["shipping_to_recipient_phone_number"] = $orderDetail->shipping_to->recipient->phone_number;
                    $data["shipping_to_address_address1"] = $orderDetail->shipping_to->address->address1;
                    $data["shipping_to_address_address2"] = $orderDetail->shipping_to->address->address2;
                    $data["shipping_to_address_city"] = $orderDetail->shipping_to->address->city;
                    $data["shipping_to_address_state"] = $orderDetail->shipping_to->address->state;
                    $data["shipping_to_address_zip_code"] = $orderDetail->shipping_to->address->zip_code;
                    $data["status"] = $orderDetail->status;
                    $data["order_id"] = $orderId;
                    $this->SaveOrderDetail($data);
                } else {
                    //do nothing
                }    
            }
        }
    }

}
