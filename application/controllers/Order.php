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
        $status['status']= "accepted"; //$this->input->post('status');
        $orderId =  "d0080105c678433d8ad1761f2e7afd70"; //$this->input->post('id');
        $results = $this->OrderModel->order_detail($orderId);
        $request["acknowledgement_status"]= $status['status']; //this order will moved to the 'acknowledged' status
        $request["alt_order_id"]= $results[0]->alt_order_id;
        foreach ($results as $result){
            $dataItem["order_item_acknowledgement_status"]= "fulfillable";
            $dataItem["order_item_id"]=$result->order_item_id;
            $dataItem["alt_order_item_id"]= $result->order_item_id;
            $tmp[] = $dataItem;
        }
        $request["order_items"]= $tmp;
        $JetApi = new JetApi();
        $JetApi->getNewToken();
        $token = $JetApi->getToken();
        $end_point = "orders/" . $orderId."/acknowledge"; // orders/{jet_defined_order_id}/acknowledge
        $response = $JetApi->apiPUT($end_point, $request);
//        $this->OrderModel->update_status($orderId, $status);        
//        print_r($response);
        echo json_encode($status);
    }

}
