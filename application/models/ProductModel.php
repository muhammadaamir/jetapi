<?php

class ProductModel extends CI_Model {
    
    
    public function sku_feed(){
        $this->db->select('listing-id','manufacturer','asin1','seller-sku','item-name',
            'item-description','product_image','price','product-id');
        $this->db->from('bf_amazon_products');
        $this->db->join('bf_amazon_products_meta','bf_amazon_products.listing-id = bf_amazon_products_meta.listing-id');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    
    public function mp_feed(){
        $this->db->select('listing-id','product-id','product-id-type','item-condition',
                'price','quantity','expedited-shipping','item-description','reference-id');
        $this->db->from('bf_amazon_products');
        $query=  $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        }
    }
            

    function getProduct() {
        $this->db->select("*");
        $this->db->from('bf_amazon_products');
        $this->db->join('bf_amazon_products_meta', 'bf_amazon_products.listing-id = bf_amazon_products_meta.listing-id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    function jetTexonomy($str) {
        $this->db->select("*");
        $this->db->from('jet_texonomy');
        $this->db->where('description', $str);
        $query = $this->db->get();
        return $query->result();
    }

    function updateProduct() {
        $this->db->where('is_upload', '0');
        $this->db->update('bf_amazon_products', array('is_upload' => '1'));
    }

    function SaveJetFileId($jet_file_id) {
        $this->db->insert('bf_files', array('name' => $jet_file_id));
    }

    function createJson($products) {
        $data = array();
        $code = array("1" => "ASIN", "2" => "ISBN", "3" => "UPC", "4" => "EAN");
        $itemname = "item-name";
        $productid = "product-id";
        $productidtype = "product-id-type";
        $sellersku = "seller-sku";
        $itemdescription = "item-description";

        foreach ($products as $product) {
            $data[$product->$sellersku]["product_title"] = $product->$itemname;
            $data[$product->$sellersku]["jet_browse_node_id"] = null;
            $data[$product->$sellersku]["standard_product_codes"] = array(array("standard_product_code" => $product->$productid, "standard_product_code_type" => $code[$product->$productidtype]));
            if (isset($product->quantity)) {
                $data[$product->$sellersku]["multipack_quantity"] = (int) $product->quantity;
            } else {
                $data[$product->$sellersku]["multipack_quantity"] = null;
            }
            $data[$product->$sellersku]["brand"] = $product->brand;
            $data[$product->$sellersku]["manufacturer"] = $product->manufacturer;
            $data[$product->$sellersku]["mfr_part_number"] = $product->$sellersku;
            $data[$product->$sellersku]["product_description"] = $product->$itemdescription;
            $data[$product->$sellersku]["bullets"] = unserialize($product->features);
            $specific = unserialize($product->dimensions);
            $data[$product->$sellersku]["shipping_weight_pounds"] = $specific["package"]['weight'];
            $data[$product->$sellersku]["map_price"] = $product->$sellersku . "/price";
            $data[$product->$sellersku]["map_implementation"] = "101";
            $data[$product->$sellersku]["product_tax_code"] = "Generic Taxable Product";

            if (!empty($product->dimensions)) {
                $specific = unserialize($product->dimensions);
                $tmp = array();
                foreach ($specific["package"] as $skey => $svalue) {
                    $attribute = $this->ProductModel->jetTexonomy($skey);
                    //var_dump($attribute[0]->id);die();
                    if (!empty($attribute)) {
                        $dimensions["attribute_id"] = (int) $attribute[0]->id;
                        $dimensions["attribute_value"] = (string) $svalue;
                        $dimensions["attribute_value_unit"] = "cm";
                        $tmp[] = $dimensions;
                    }
                }
                $data[$product->$sellersku]["attributes_node_specific"] = $tmp;
            } else {
                $data[$product->$sellersku]["attributes_node_specific"] = array();
            }
            //$url = explode('images/I/', $product->product_image);
            //$content = file_get_contents($product->product_image);
//        var_dump(getcwd());die('cwd');
            //file_put_contents('application/download/' . $url[1], $content);

            $data[$product->$sellersku]["main_image_url"] = $product->product_image;
        }

        $jsonFile = 'application/uploads/' . time() . '.json';
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
        $JetApi = new JetApi();
        $JetApi->getNewToken();
        $token = $JetApi->getToken();
        $response = $JetApi->uploadFile("MerchantSKUs", $jsonFile);
        $this->updateProduct();
        $jet_file_id = $response->jet_file_id;
        if (!empty($jet_file_id) && $jet_file_id != "") {
            $this->SaveJetFileId($jet_file_id);
            foreach ($products as $product) {
                $quantity = (int) $product->quantity;
                $price = (float) $product->price;
                $price_endpoint = "merchant-skus/" . $product->$sellersku . "/price";
                $inventory_endpoint = "merchant-skus/" . $product->$sellersku . "/Inventory";
                $price_params = ['price' => $price];
                $inventory_params = ['fulfillment_nodes' => [ "fulfillment_node_id" => "21a6e145f9ed4e0db70ba5f3cd1550a9", "quantity" => $quantity]];
                $JetApi->apiPUT($price_endpoint, $price_params);
                $JetApi->apiPUT($inventory_endpoint, $inventory_params);
            }
            return true;
        } else {
            return false;
        }
    }

}
