<?php

class Rakuten extends CI_Controller{
    function __Construct() {
        parent::__Construct();
        $this->load->library('RakutenApi');
        $this->load->library('excel');
    }
    
    public function index(){
        echo "in Rakuten controller";
    }
    
    public function products(){  
        $path = FCPATH."/assets/csv_files/sku_feed.csv";
        $RakutenApi  = new RakutenApi();   
        $result=$RakutenApi->products($path);
        if($result)
            echo "Products csv written to the file ".$path;
    }
    
    public function quantity(){
        $filename = 'mp_feed';
        $title = 'title name';
        $file = $filename . '.xls'; //save our workbook as this file name
        $query = $this->ProductModel->getProduct();

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$file.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($filename);
        $this->excel->getActiveSheet()->setCellValue('A1', 'ListingId');
        $this->excel->getActiveSheet()->setCellValue('B1', 'ProductId');
        $this->excel->getActiveSheet()->setCellValue('C1', 'ProductIdType');
        $this->excel->getActiveSheet()->setCellValue('D1', 'ItemCondition');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Price');
        $this->excel->getActiveSheet()->setCellValue('F1', 'MAP');
        $this->excel->getActiveSheet()->setCellValue('G1', 'MAPType');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Quantity');
        $this->excel->getActiveSheet()->setCellValue('I1', 'OfferExpeditedShipping');
        $this->excel->getActiveSheet()->setCellValue('J1', 'Description');
        $this->excel->getActiveSheet()->setCellValue('K1', 'ShippingRateStandard');
        $this->excel->getActiveSheet()->setCellValue('L1', 'ShippingRateExpedited');
        $this->excel->getActiveSheet()->setCellValue('M1', 'ShippingLeadTime');
        $this->excel->getActiveSheet()->setCellValue('N1', 'OfferTwoDayShipping');
        $this->excel->getActiveSheet()->setCellValue('O1', 'ShippingRateTwoDay');
        $this->excel->getActiveSheet()->setCellValue('P1', 'OfferOneDayShipping');
        $this->excel->getActiveSheet()->setCellValue('Q1', 'ShippingRateOneDay');
        $this->excel->getActiveSheet()->setCellValue('R1', 'OfferLocalDeliveryShippingRates');
        $this->excel->getActiveSheet()->setCellValue('S1', 'ReferenceId');
        $this->excel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
        
        $i = 3;
        $listing_id = 'listing-id';
        $seller_sku = 'seller-sku';
        $item_desc = 'item-description';
        $product_id = 'product-id';
        $product_id_type = 'product-id-type';
        $item_condition = 'item-condition';
        $expedited_shipping = 'expedited-shipping';
            
            
        foreach($query as $item){
            $this->excel->getActiveSheet()->setCellValue('A'.$i, $item->$listing_id);
            $this->excel->getActiveSheet()->setCellValue('B'.$i, $item->$product_id);
            $this->excel->getActiveSheet()->setCellValue('C'.$i, $item->$product_id_type);
            $this->excel->getActiveSheet()->setCellValue('D'.$i, $item->$item_condition);
            $this->excel->getActiveSheet()->setCellValue('E'.$i, $item->price);
            $this->excel->getActiveSheet()->setCellValue('F'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('G'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('H'.$i, $item->quantity);
            $this->excel->getActiveSheet()->setCellValue('I'.$i, $item->$expedited_shipping);
            $this->excel->getActiveSheet()->setCellValue('J'.$i, $item->$item_desc);
            $this->excel->getActiveSheet()->setCellValue('K'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('L'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('M'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('N'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('O'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('P'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('Q'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('R'.$i, '');
            $this->excel->getActiveSheet()->setCellValue('S'.$i, $item->$seller_sku);
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(TRUE);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(TRUE);
            
            $i++;
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        $objWriter->save('php://output');
//        $path = FCPATH."/assets/csv_files/mp_feed.csv";
//        $RakutenApi = new RakutenApi();   
//        $result=$RakutenApi->quantity($path);
//        if($result)
//            echo "Quantity csv written to the file ".$path;
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

