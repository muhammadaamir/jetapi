<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class Rakuten{
        function __Construct() {
            $this->CI =& get_instance();
            $this->CI->load->model('ProductModel');
            $this->CI->load->helper('file');
        }
        static $listing_id = 'listing-id';
        static $seller_sku = 'seller-sku';
        static $item_name = 'item-name';
        static $item_desc = 'item-description';
        static $product_id = 'product-id';
        static $product_id_type = 'product-id-type';
        static $item_condition = 'item-condition';
        static $expedited_shipping = 'expedited-shipping';
        
        
        public function Func(){
            return 'function';
        }
        
        public function products(){
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
                if(!fputcsv($a, $new_array)){
                    return FALSE;
                }
            }
            return TRUE;
        }
        
        
        public function quantity(){
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
