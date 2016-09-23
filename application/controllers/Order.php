<?php

class Order extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __Construct() {
        parent::__Construct();
        $this->load->database(); // load database
        $this->load->library('JetApi'); // load libbrary
        $this->load->model('OrderModel');
        $this->load->helper("url");
        $this->load->library("pagination");
    }

    public function index() {
        echo "Ready";
        $status = "ready";
        $this->OrderModel->getRecord($status);
    }
    
    public function lists() {
        $config = array();
        $config["base_url"] = base_url() . "order/lists";
        $config["total_rows"] = $this->OrderModel->record_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
        $data["results"] = $this->OrderModel->fetch_orders($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $this->load->view("order_view", $data);
    }
    
    public function oderDetail($orderId) {
        
        $data["results"] = $this->OrderModel->order_detail($orderId);
        $this->load->view("order_detail_view", $data);
    }
    
    public function updateOrder(){
//        $status['status']   = "shipped";
//        $orderId            = "7b0a97eb6f4c4b448f7ea75efefeb3a4";
        $status['status']   = $this->input->post('status');
        $orderId            = $this->input->post('id');
        $results            = $this->OrderModel->order_detail($orderId);
        if($status['status']== "shipped"){
            $request["alt_order_id"] = $results[0]->alt_order_id;               
                $dataShipments["alt_shipment_id"]           = $results[0]->merchant_order_id;
                $dataShipments["shipment_tracking_number"]  = $results[0]->reference_order_id;
                $dataShipments["response_shipment_date"]    = $results[0]->order_detail_request_ship_by;
                $dataShipments["response_shipment_method"]  = $results[0]->order_detail_request_shipping_method;
                $dataShipments["expected_delivery_date"]    = $results[0]->order_detail_request_delivery_by;
                $dataShipments["ship_from_zip_code"]        = $results[0]->shipping_to_address_zip_code;
                $dataShipments["carrier_pick_up_date"]      = "2016-09-24T07:41:31.2740935Z";//;$results[0]->order_transmission_date;
                $dataShipments["carrier"]                   = $results[0]->order_detail_request_shipping_carrier;
                    foreach ($results as $result){
                        $shipmentItem["shipment_item_id"]               = $result->order_item_id;
                        $shipmentItem["alt_shipment_item_id"]           = $result->order_item_id;
                        $shipmentItem["merchant_sku"]                   = $result->merchant_sku;
                        $shipmentItem["response_shipment_sku_quantity"] = (int)$result->request_order_quantity;
                        $shipmentItemTmp[]                              = $shipmentItem;
                    }
                $dataShipments["shipment_items"]            = $shipmentItemTmp;
                $tmp[]                  = $dataShipments;
            $request["shipments"]   = $tmp;
            $end_point              = "orders/" . $orderId."/shipped"; // orders/{jet_defined_order_id}/acknowledge
        }elseif($status['status']== "returned"){
            $request["alt_order_id"]= $results[0]->alt_order_id;               
                $dataShipments["alt_shipment_id"]           = $results[0]->merchant_order_id;
                    foreach ($results as $result){
                        $shipmentItem["shipment_item_id"]               = $result->order_item_id;
                        $shipmentItem["alt_shipment_item_id"]           = $result->order_item_id;
                        $shipmentItem["merchant_sku"]                   = $result->merchant_sku;
                        $shipmentItem["response_shipment_cancel_qty"]   = (int)$result->request_order_quantity;
                        $shipmentItemTmp[]                              = $shipmentItem;
                    }
                $dataShipments["shipment_items"]            = $shipmentItemTmp;
                $tmp[]                  = $dataShipments;
            $request["shipments"]   = $tmp;
            $end_point              = "orders/" . $orderId."/shipped";
        }else{
            if($status['status']    == "accepted"){
                $orderItemAcknowledgementStatus = "fulfillable";
                $acknowledgementStatus          = $status['status'];
            }else{
                $orderItemAcknowledgementStatus = "nonfulfillable - no inventory";
                $acknowledgementStatus          = "rejected - item level error";
            }
            $request["acknowledgement_status"]  = $acknowledgementStatus; //this order will moved to the 'acknowledged' status
            $request["alt_order_id"]            = $results[0]->alt_order_id;
            foreach ($results as $result){
                $dataItem["order_item_acknowledgement_status"]  = $orderItemAcknowledgementStatus;
                $dataItem["order_item_id"]                      = $result->order_item_id;
                $dataItem["alt_order_item_id"]                  = $result->order_item_id;
                $tmp[]                                          = $dataItem;
            }
            $request["order_items"]             = $tmp;
            $end_point                          = "orders/" . $orderId."/acknowledge"; // orders/{jet_defined_order_id}/acknowledge
        }
        $JetApi     = new JetApi();
        $JetApi->getNewToken();
        $token      = $JetApi->getToken();
        $response   = $JetApi->apiPUT($end_point, $request);
//        var_dump($response);
//        echo json_encode($request);
        $this->OrderModel->update_status($orderId, $status);        
        echo json_encode($response);
    }
}
