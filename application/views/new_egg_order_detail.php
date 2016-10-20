<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
	<meta charset="utf-8">
        <title>NewEgg Order Details</title>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-1.10.2.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
    </head>
    <body>
        <div class="container" style="padding:50px">
            <div class="jumbotron">
                <h3>NewEgg Order Details</h3>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped table-hover">
                <?php if(count($results>0))?>
                    <tr class="row">
                        <td class="col-sm-6">
                            Seller ID:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->seller_id; ?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Order Number:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->order_number;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Invoice Number:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->invoice_number;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Order Date:
                        </td>
                        <td class="col-sm-6">
                            <?php echo date('d/M/Y h:m',  strtotime($results[0]->order_date));?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Customer Name:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->customer_name;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Customer Contact Number:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->customer_phone_number;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Order Status:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->order_status_description;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Country:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->country_code;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            City:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->city;?>
                        </td>
                    </tr>
                                  
                    <tr class="row">
                        <td class="col-sm-6">
                            Customer Address:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->address1;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Shipping Amount:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->shipping_amount;?>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col-sm-6">
                            Seller Part Number:
                        </td>
                        <td class="col-sm-6">
                            <?php echo $results[0]->seller_part_number;?>
                        </td>
                    </tr>
                    
                    
            </table>
            
        </div>
    </body>
</html>
