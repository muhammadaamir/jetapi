<?php

class Excel {

    public $excel;

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH.'libraries/Classes/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function header() {
        $styleArray = array(
    'font'  => array(
        'size'  => 10,
        'name'  => 'Liberation Serif'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
    );
    
    $this->excel->getActiveSheet()->setCellValue('A1', 'Candidate Number');
    $this->excel->getActiveSheet()->setCellValue('B1', 'Candidate Number');
    $this->excel->getActiveSheet()->setCellValue('C1', 'First Name');
    $this->excel->getActiveSheet()->setCellValue('D1', 'Last Name');
    $this->excel->getActiveSheet()->setCellValue('E1', 'DOB:(DD/MM/YYYY)');
    $this->excel->getActiveSheet()->setCellValue('F1', 'Postcode');
    $this->excel->getActiveSheet()->setCellValue('G1', 'Gender');
    $this->excel->getActiveSheet()->setCellValue('H1', 'Email');
    
    }
    
    public function data_excel($i,$item){
        $this->excel->getActiveSheet()->setCellValue('A'.$i, $i);
        $this->excel->getActiveSheet()->setCellValue('B'.$i,  'candidate_number');
        $this->excel->getActiveSheet()->setCellValue('C'.$i,  'name');
        $this->excel->getActiveSheet()->setCellValue('D'.$i,  'lname');
        $this->excel->getActiveSheet()->setCellValue('E'.$i,  'dob');
        $this->excel->getActiveSheet()->setCellValue('F'.$i,  'post_code');
        
    }

    public function load() {
        
        $this->excel->getActiveSheet()->setTitle('Sheet');
        $inputFile = FCPATH."/assets/csv_files/sku_feed.xls";
        $inputFileType = PHPExcel_IOFactory::identify($inputFile);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            
        $this->excel = $objReader->load($inputFile);
    }

    public function save() {
        
        $filename   = "sku_1";
            $filestring = "";
            $filestring = $this->excel;         
            $filename = $filename.".xls";
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
            header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
            header('Cache-Control: max-age=0');
            $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
            $writer->save('php://output');
            
        // Write out as the new file
//        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//        $objWriter->save($path);
    }

    public function stream($filename) {
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"".$filename."\""); 
        header("Cache-control: private");        
        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');
    }

    public function  __call($name, $arguments) {  
        // make sure our child object has this method  
        if(method_exists($this->excel, $name)) {  
            // forward the call to our child object  
            return call_user_func_array(array($this->excel, $name), $arguments);  
        }  
        return null;  
    }  
}

?>
