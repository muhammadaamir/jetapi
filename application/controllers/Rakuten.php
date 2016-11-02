<?php

class Rakuten extends CI_Controller{
    function __Construct() {
        parent::__Construct();
        $this->load->library('RakutenApi'); 
    }
    
    public function index(){
        echo "in Rakuten controller";
    }
    
    public function products(){  
        $path = FCPATH."/assets/csv_files/sku_feed.csv";
        $RakutenApi = new RakutenApi();   
        $result=$RakutenApi->products($path);
        if($result)
            echo "Products csv written to the file ".$path;
    }
    
    public function quantity(){
        $path = FCPATH."/assets/csv_files/mp_feed.csv";
        $RakutenApi = new RakutenApi();   
        $result=$RakutenApi->quantity($path);
        if($result)
            echo "Quantity csv written to the file ".$path;
    }

    





    public function conn() {
//        $this->load->library('ftp');
//        $config['hostname']='trade.marketplace.buy.com';
//        if($this->ftp->connect($config)){
//            echo "connected";
//        }
//        else echo "could not connect.";
        
        
        $conn_id= ftp_connect("trade.marketplace.buy.com");
        if($conn_id){
            echo "connected";
        }
        else echo "could not connect";
    }
}

