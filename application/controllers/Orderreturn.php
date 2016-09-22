<?php error_reporting(0);

class Orderreturn extends CI_Controller {

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
        $this->load->model('OrderReturnModel');
        $this->load->helper("url");
        $this->load->library("pagination");
    }
    
    function shippingResponse(){
      $JetApi = new JetApi();
        $JetApi->getNewToken();
        $token = $JetApi->getToken();
        $status = "acknowledge";
        $end_point = "returns/" . $status;
        $response =  array ( "/return/state/57e542a613fa42d8b6e8362dbd5911f5" , "/return/state/a10b4b28467c490984e0b387e1cc2d9a" , "/return/state/32c05c3230fc498e95f82129efd10213" ); 
       // $response = $JetApi->apiGET($end_point, null);
//print_r($response); die;
        $return_merchant_SKUs = array ("order_item_id" => "ac62a44553734370b7ec90ee320f6eca", "alt_order_item_id" => "A1223456");
        foreach ($response as $key){
           
            $values = explode("/return/state/" , $key);
            
                 $end_point2 = "returns/" . $status . "/" . $values[1]; 
                  
                   $innerResponse = $JetApi->apiGET($end_point2, null);
                   
                   $data["merchant_return_authorization_id"] = "5462a44553734370b7ec90ee320f6eca";
                    $data["reference_return_authorization_id"] = "123456789012-01";
                    $data["return_status"] = "created";
                    $data["refund_without_return"] = FALSE;
                    $data["merchant_order_id"] = "9b13bdd68c314d1b9c8b93277dea4da1";
                    $data["reference_order_id"] = 123456789012;
                    $data["alt_order_id"] = 12345678;
                    $data["return_date"] = "2014-11-01T21:19:00Z";
                    
                    $data["shipping_carrier"] = "UPS";
                    $data["tracking_number"] = "1Z23W456123345890";
                    $data["merchant_return_charge"] = 5.0;
                    $data["order_item_id"] = "ac62a44553734370b7ec90ee320f6eca";
                    foreach ($return_merchant_SKUs as $item){
                        $dataitem['order_item_id'] = "ac62a44553734370b7ec90ee320f6eca";
                        $dataitem['alt_order_item_id'] = "A1223456";
                        $dataitem['merchant_sku'] = "AB12345";
                        $dataitem['merchant_sku_title'] = "red bottle";
                        $dataitem['return_quantity'] = 1;
                        $dataitem['reason'] = "no longer need/want";
                        $dataitem['principal'] = 2.0;
                        $dataitem['tax'] =  1.4;
                        $dataitem['shipping_cost'] = 1.0;
                        $dataitem['shipping_tax'] =  0.07;
                         $this->OrderReturnModel->insertReturnMerchantSkus($dataitem);
                    }
                   
                    $this->OrderReturnModel->insertOrderReturns($data);
                   
//                    $data["order_detail_request_ship_by"] = $orderDetail->order_detail->request_ship_by;
//                    $data["order_detail_request_delivery_by"] = $orderDetail->order_detail->request_delivery_by;
                    
                   
                   
  //print_r($innerResponse); die;
             
        }
        
     
        
    }
    
       function returnOrderList(){
           $config = array();
        $config["base_url"] = base_url() . "orderreturn/returnorderlist";
        $config["total_rows"] = $this->OrderReturnModel->record_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
        $data["results"] = $this->OrderReturnModel->fetch_orders($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        //print_r($data); die;
        $this->load->view("order_return_view", $data);
        
        }
        
           public function orderReturnDetail($orderId) {
        
        $data["results"] = $this->OrderReturnModel->order_detail($orderId);
        //print_r($data); die;
        $this->load->view("order_return_detail", $data);
    }
        
}
    
 