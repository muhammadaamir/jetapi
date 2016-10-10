<?php

class NewEggOrderModel extends CI_Model {

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
        $this->db->from('order_detail');
        $this->db->where('order_id', $orderId);
        $query = $this->db->get();
        return $query->result();
    }

    function getRecord() {
        $NewEggApi = new NewEggApi();
        $response = $NewEggApi->getOrders();
//        foreach ($response as $value) {
//            $data["order_downloaded"]   = $value["OrderDownloaded"];
//            $data["order_number"]       = $value["OrderNumber"];
//            $data["order_status_code"]  = $value["OrderStatusCode"];
//            $data["order_status_name"]  = $value["OrderStatusName"];
//            $data["seller_id"]          = $value["SellerID"];
//            $data["sales_channel"]      = $value["SalesChannel"];
//            $data["fulfillment_option"] = $value["FulfillmentOption"];
//            $this->SaveOrder($data);
//        }
        return $response;
    }

    function updateRecord($status, $orderId) {
        $d = new DateTime();
        $d->add(new DateInterval('P2D'));
        $results = $this->OrderModel->order_detail($orderId);
        if ($status['status'] == "shipped") {
            $request["alt_order_id"] = $results[0]->alt_order_id;
            $dataShipments["alt_shipment_id"] = $results[0]->merchant_order_id;
            $dataShipments["shipment_tracking_number"] = $results[0]->reference_order_id;
            $dataShipments["response_shipment_date"] = $results[0]->order_detail_request_ship_by;
            $dataShipments["response_shipment_method"] = $results[0]->order_detail_request_shipping_method;
            $dataShipments["expected_delivery_date"] = $results[0]->order_detail_request_delivery_by;
            $dataShipments["ship_from_zip_code"] = $results[0]->shipping_to_address_zip_code;
            $dataShipments["carrier_pick_up_date"] = $d->format('Y-m-d\TH:i:s.Z') . "13Z"; //"2016-09-24T07:41:31.2740935Z";//;$results[0]->order_transmission_date;
            $dataShipments["carrier"] = $results[0]->order_detail_request_shipping_carrier;
            foreach ($results as $result) {
                $shipmentItem["shipment_item_id"] = $result->order_item_id;
                $shipmentItem["alt_shipment_item_id"] = $result->order_item_id;
                $shipmentItem["merchant_sku"] = $result->merchant_sku;
                $shipmentItem["response_shipment_sku_quantity"] = (int) $result->request_order_quantity;
                $shipmentItemTmp[] = $shipmentItem;
            }
            $dataShipments["shipment_items"] = $shipmentItemTmp;
            $tmp[] = $dataShipments;
            $request["shipments"] = $tmp;
            $end_point = "orders/" . $orderId . "/shipped"; // orders/{jet_defined_order_id}/acknowledge
        } elseif ($status['status'] == "returned") {
            $request["alt_order_id"] = $results[0]->alt_order_id;
            $dataShipments["alt_shipment_id"] = $results[0]->merchant_order_id;
            foreach ($results as $result) {
                $shipmentItem["shipment_item_id"] = $result->order_item_id;
                $shipmentItem["alt_shipment_item_id"] = $result->order_item_id;
                $shipmentItem["merchant_sku"] = $result->merchant_sku;
                $shipmentItem["response_shipment_cancel_qty"] = (int) $result->request_order_quantity;
                $shipmentItemTmp[] = $shipmentItem;
            }
            $dataShipments["shipment_items"] = $shipmentItemTmp;
            $tmp[] = $dataShipments;
            $request["shipments"] = $tmp;
            $end_point = "orders/" . $orderId . "/shipped";
        } else {
            if ($status['status'] == "accepted") {
                $orderItemAcknowledgementStatus = "fulfillable";
                $acknowledgementStatus = $status['status'];
            } else {
                $orderItemAcknowledgementStatus = "nonfulfillable - no inventory";
                $acknowledgementStatus = "rejected - item level error";
            }
            $request["acknowledgement_status"] = $acknowledgementStatus; //this order will moved to the 'acknowledged' status
            $request["alt_order_id"] = $results[0]->alt_order_id;
            foreach ($results as $result) {
                $dataItem["order_item_acknowledgement_status"] = $orderItemAcknowledgementStatus;
                $dataItem["order_item_id"] = $result->order_item_id;
                $dataItem["alt_order_item_id"] = $result->order_item_id;
                $tmp[] = $dataItem;
            }
            $request["order_items"] = $tmp;
            $end_point = "orders/" . $orderId . "/acknowledge"; // orders/{jet_defined_order_id}/acknowledge
        }
        $JetApi = new JetApi();
        $JetApi->getNewToken();
        $token = $JetApi->getToken();
        $response = $JetApi->apiPUT($end_point, $request);
        $this->OrderModel->update_status($orderId, $status);
        return $response;
    }
    
    
    
    function isValid(){
        $new_egg_obj= new NewEggApi();
        return $new_egg_obj->isValid();
    }

}
