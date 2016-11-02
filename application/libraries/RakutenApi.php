<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class RakutenApi{
        function __Construct() {
            $this->CI =& get_instance();
            $this->CI->load->model('ProductModel');
            $this->CI->load->helper('file');
        }
        
        public function products($path){
            $listing_id = 'listing-id';
            $seller_sku = 'seller-sku';
            $item_name = 'item-name';
            $item_desc = 'item-description';
            $product_id = 'product-id';
            
            $wb= fopen($path, 'wb');
            $a= fopen($path, 'a');
            $headings=array('gtin','mfg-name','asin','seller-sku','title','description',
                'main-image','listing-price','mfg-part-number','category-id','seller-id','weight');
            $static_fields=array('0349','ABCD','1kg');

            fputcsv($wb, $headings);

            $array=$this->CI->ProductModel->getProduct();
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
        
        
        public function quantity($path){
            $listing_id = 'listing-id';
            $seller_sku = 'seller-sku';
            $item_desc = 'item-description';
            $product_id = 'product-id';
            $product_id_type = 'product-id-type';
            $item_condition = 'item-condition';
            $expedited_shipping = 'expedited-shipping';
            
            $wb= fopen($path, 'wb');
            $a= fopen($path, 'a');
            $headings = array(
                'ListingId','ProductId','ProductIdType','ItemCondition','Price','Quantity',
                'OfferExpeditedShipping','Description','ReferenceId');
            fputcsv($wb, $headings);

            $array=$this->CI->ProductModel->getProduct();
            foreach ($array as $row){
                $new_array = array(
                    $row->$listing_id,$row->$product_id,$row->$product_id_type,$row->$item_condition,
                   $row->price,$row->quantity,$row->$expedited_shipping,$row->$item_desc,$row->$seller_sku);
                if(!fputcsv($a, $new_array)){
                    return FALSE;
                }
            }
            return TRUE;
        }      
    }
