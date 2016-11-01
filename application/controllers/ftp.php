<?php

class Ftp extends CI_Controller{
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
        $this->load->model('ProductModel');
        $this->load->helper('file');
        
                
        $listing_id = 'listing-id';
        $seller_sku = 'seller-sku';
        $item_name = 'item-name';
        $item_desc = 'item-description';
        $product_id = 'product-id';
        $product_id_type = 'product-id-type';
        $item_condition = 'item-condition';
        $expedited_shipping = 'expedited-shipping';
        
        //....**** direct method ..*****
//        $this->load->dbutil();
//        $object=$this->ProductModel->mp_feed();
//        $csv = $this->dbutil->csv_from_result($object);
//        write_file(FCPATH."/assets/csv_files/mp_feed.csv", $csv);

        
        //...**** sku_feed ...*****
        $wb= fopen(FCPATH."/assets/csv_files/sku_feed.csv", 'wb');
        $a= fopen(FCPATH."/assets/csv_files/sku_feed.csv", 'a');
        $headings=array('gtin','mfg-name','asin','seller-sku','title','description',
            'main-image','listing-price','mfg-part-number','category-id','seller-id','weight');
        $static_fields=array('0349','ABCD','1kg');
        
        fputcsv($wb, $headings);
        
        $array=$this->ProductModel->getProduct();
        foreach ($array as $row){
            $new_array = array(
                $row->$listing_id,$row->manufacturer,$row->asin1,$row->$seller_sku,
                $row->$item_name,$row->$item_desc,$row->product_image,$row->price,$row->$product_id,
                $static_fields[0],$static_fields[1],$static_fields[2]);
            fputcsv($a, $new_array);
        }
        
        
           //....**** mp_feed ..*****
        $wb= fopen(FCPATH."/assets/csv_files/mp_feed.csv", 'wb');
        $a= fopen(FCPATH."/assets/csv_files/mp_feed.csv", 'a');
        $headings = array(
            'ListingId','ProductId','ProductIdType','ItemCondition','Price','Quantity',
            'OfferExpeditedShipping','Description','ReferenceId');
        fputcsv($wb, $headings);
        
        $array=$this->ProductModel->getProduct();
        foreach ($array as $row){
            $new_array = array(
                $row->$listing_id,$row->$product_id,$row->$product_id_type,$row->$item_condition,
               $row->price,$row->quantity,$row->$expedited_shipping,$row->$item_desc,$row->$seller_sku);
            fputcsv($a, $new_array);
        }
    }
}

