<?php

class NewEggOrder extends CI_Controller {

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
        $this->load->library('NewEggApi'); // load libbrary
        $this->load->model('NewEggOrderModel');
        $this->load->helper("url");
        $this->load->library("pagination");
    }

    public function index() {
        echo "Ready<br>";
        $status = "ready...";
        $response=$this->NewEggOrderModel->isValid();
        if($response) echo "VALID credentials";
        else echo "INVALID credentials....!";
        $response=$this->NewEggOrderModel->getRecord();
        echo $response;
//        $this->NewEggOrderModel->getRecord();
//        echo "New Egg Record Add";
    }
    
    public function lists() {
        $config = array();
        $config["base_url"] = base_url() . "neweggorder/lists";
        $config["total_rows"] = $this->NewEggOrderModel->record_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
        $data["results"] = $this->NewEggOrderModel->fetch_orders($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $this->load->view("new_egg_order_view", $data);
    }
    
    public function oderDetail($orderId) {
        
        $data["results"] = $this->OrderModel->order_detail($orderId);
        $this->load->view("order_detail_view", $data);
    }
    
    public function updateOrder(){
        $status['status']   = $this->input->post('status');
        $orderId            = $this->input->post('id');
        $response = $this->OrderModel->updateRecord($status, $orderId);        
        echo json_encode($response);
    }
}
