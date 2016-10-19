<?php

class NewEggOrder extends CI_Controller {
    
    function __Construct() {
        parent::__Construct();
        $this->load->database(); // load database
        $this->load->library('NewEggApi'); // load libbrary
        $this->load->model('NewEggOrderModel');
        $this->load->helper("url");
        $this->load->library("pagination");
    }

    public function index() {
//        $response=$this->NewEggOrderModel->is_valid();

        $this->NewEggOrderModel->insert_order_details();
        echo "New Egg Record Add...";
    }
    
    public function lists() {
        $config = array();
        $config["base_url"] = base_url() . "NewEggOrder/lists";
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
//        $orderId="101062460";
        $data["results"] = $this->NewEggOrderModel->get_order_detail($orderId);
//        print_r($data);
        $this->load->view("new_egg_order_detail", $data);
    }
    
    public function updateOrder(){
        $status   = $this->input->post('status');
        $orderId  = $this->input->post('id');
//        $status='cancel';
//        $orderId="101062460";
        $response = $this->NewEggOrderModel->updateRecord($status, $orderId);   
        if($response){
            echo $response;
        }
        else echo "Could not update!";
    }
    
    
    public function confirmOrder(){
        $orderId= $this->input->post('id');
        $response=$this->NewEggOrderModel->confirm_order($orderId);
        if($response){
            echo $response;
        }
        else echo "Error from Controller:NewEggOrder/confirmOrder <br> Couldn't perform Order Confirmation!";
    }
    
    public function removeItem(){
        $orderId=  $this->input->post('id');
        $response=$this->NewEggOrderModel->remove_item($orderId);
        if($response){
            echo $response;
        }
        else echo "Could not remove item";
    }
    
    
}
