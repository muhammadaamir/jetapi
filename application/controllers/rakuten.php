<?php

class Ftp extends CI_Controller{
    function __Construct() {
        parent::__Construct();
        $this->load->library('Rakuten'); // load libbrary
        $this->load->model('ProductModel');
    }
    
    public function index(){
        echo "in ftp index";
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
     
    public function write(){
        
        //....**** direct method ..*****
//        $this->load->dbutil();
//        $object=$this->ProductModel->mp_feed();
//        $csv = $this->dbutil->csv_from_result($object);
//        write_file(FCPATH."/assets/csv_files/mp_feed.csv", $csv);
        $rakuten = new Rakuten();
        if($rakuten->products())
            echo "success";

    }
}

