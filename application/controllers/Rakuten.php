<?php

class Rakuten extends CI_Controller{
    function __Construct() {
        parent::__Construct();
        //$this->load->library('Rakuten'); // load libbrary
        $this->load->model('ProductModel');
        $this->load->library('RakutenApi');      
        }
    
    public function index(){
        echo "in Rakuten controller";
    }
    
    public function write(){
        
        //....**** direct method ..*****
//        $this->load->dbutil();
//        $object=$this->ProductModel->mp_feed();
//        $csv = $this->dbutil->csv_from_result($object);
//        write_file(FCPATH."/assets/csv_files/mp_feed.csv", $csv);
        
        $RakutenApi = new RakutenApi();
        $response = $RakutenApi->Func();
//        $result=$this->rakuten->Func();
//        if($result)
            echo "success :".$response;
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

