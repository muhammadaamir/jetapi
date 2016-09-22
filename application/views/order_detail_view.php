<html>
<head>
	<meta charset="utf-8">
	<title>Jet Api</title>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-1.10.2.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</head>
<body>
<div id="container" style="padding: 50px">
  <h1>Order Detail</h1>
    <div id="body">
      <table class="table table-bordered ">
        <?php if(count($results[0])>0){?>
        <tr>
            <td>Order Id: </td>
            <td><?php echo $results[0]->order_id; ?></td>
        </tr>
        <tr>
            <td>Order Placed Date: </td>
            <td><?php echo date('d/m/Y h:m a', strtotime($results[0]->order_placed_date)); ?></td>
        </tr>
        <tr>
            <td>Buyer Name: </td>
            <td><?php echo $results[0]->buyer_name; ?></td>
        </tr>
        <tr>
            <td>Buyer Phone#: </td>
            <td><?php echo  $results[0]->buyer_phone_number;?></td>
        </tr>
        <tr>
            <td>Shipping Address: </td>
            <td><?php echo  $results[0]->product_title;?></td>
        </tr>
        <tr>
            <td>Product Title: </td>
            <td><?php echo  $results[0]->shipping_to_address_address1; ?></td>
        </tr>
        <tr>
            <td>Status: </td>
            <td><?php echo  $results[0]->status;?></td>
        </tr>
        <tr>
            <td>Base Price: </td>
            <td><?php echo  $results[0]->base_price;  ?></td>
        </tr>

        <tr>
            <td> Url: </td>
            <td><?php echo $results[0]->url;?></td>
        </tr>
        <tr>
            <td> Alt Order Id: </td>
            <td><?php echo $results[0]->alt_order_id;?></td>
        </tr>
        <tr>
            <td> Customer Reference Order Id: </td>
            <td><?php echo $results[0]->customer_reference_order_id;?></td>
        </tr>
        <tr>
            <td> Fulfillment Node: </td>
            <td><?php echo $results[0]->fulfillment_node;?></td>
        </tr>
        <?php if($results[0]->has_shipments){
           echo "<tr>
               <td> Has Shipments: </td>
               <td>True</td>
            </tr>";
        }else{
             echo "<tr>
                 <td> Has Shipments: </td>
                 <td>False</td>
            </tr>";
        }
        if($results[0]->jet_request_directed_cancel){
            echo "<tr>
                <td> Jet Request Directed Cancel: </td>
                <td>True</td>
            </tr>";
        }else{
            echo "<tr>
                <td> Jet Request Directed Cancel: </td>
                <td>False</td>
            </tr>";
        }?>
        <tr>
            <td> Hash Email: </td>
            <td><?php echo $results[0]->hash_email;?></td>
        </tr>
        <tr>
            <td> Merchant Order Id: </td>
            <td><?php echo $results[0]->merchant_order_id;?></td>
        </tr>
        <tr>
            <td> Order Detail Request Shipping Method: </td>
            <td><?php echo $results[0]->order_detail_request_shipping_method;?></td>
        </tr>
        <tr>
            <td> Order Detail Request Shipping Carrier: </td>
            <td><?php echo $results[0]->order_detail_request_shipping_carrier;?></td>
        </tr>
        <tr>
            <td> Order Detail Request Service Level: </td>
            <td><?php echo $results[0]->order_detail_request_service_level;?></td>
        </tr>
        <tr>
            <td> Order Detail Request Ship By: </td>
            <td><?php echo $results[0]->order_detail_request_ship_by;?></td>
        </tr>
        <tr>
            <td> Order Detail Request Delivery By: </td>
            <td><?php echo $results[0]->order_detail_request_delivery_by;?></td>
        </tr>
        <tr>
            <td> Order Totals Item Price Item Tax: </td>
            <td><?php echo $results[0]->order_totals_item_price_item_tax;?></td>
        </tr>
        <tr>
            <td> Order Totals Item Price Item Shipping Cost: </td>
            <td><?php echo $results[0]->order_totals_item_price_item_shipping_cost;?></td>
        </tr>
        <tr>
            <td> Order Totals Item Price Item Shipping Tax: </td>
            <td><?php echo $results[0]->order_totals_item_price_item_shipping_tax;?></td>
        </tr>
        <tr>
            <td> Order Totals Item Price Base Price: </td>
            <td><?php echo $results[0]->order_totals_item_price_base_price;?></td>
        </tr>
        <tr>
            <td> Order Transmission Date: </td>
            <td><?php echo date('d/m/Y h:m a', strtotime($results[0]->order_transmission_date));?></td>
        </tr>
        <tr>
            <td> Reference Order Id: </td>
            <td><?php echo $results[0]->reference_order_id;?></td>
        </tr>
        <tr>
            <td> Shipping To Recipient Name: </td>
            <td><?php echo $results[0]->shipping_to_recipient_name;?></td>
        </tr>
        <tr>
            <td> Shipping To Recipient Phone Number: </td>
            <td><?php echo $results[0]->shipping_to_recipient_phone_number;?></td>
        </tr>
        <tr>
            <td> Shipping To Address Address1: </td>
            <td><?php echo $results[0]->shipping_to_address_address1;?></td>
        </tr>
        <tr>
            <td> Shipping To Address Address2: </td>
            <td><?php echo $results[0]->shipping_to_address_address2;?></td>
        </tr>
        <tr>
            <td> Shipping To Address City: </td>
            <td><?php echo $results[0]->shipping_to_address_city;?></td>
        </tr>
        <tr>
            <td> Shipping To Address State: </td>
            <td><?php echo $results[0]->shipping_to_address_state;?></td>
        </tr>
        <tr>
            <td> Shipping To Address Zip Code: </td>
            <td><?php echo $results[0]->shipping_to_address_zip_code;?></td>
        </tr>
        <tr>
        <td colspan='2'><b>Order Item's</b></td>
        </tr>
        <?php $count = 1;
        foreach($results as $data) {?>
            <tr>
            <td colspan='2'><b>Item-<?php echo $count ?></b></td>
            </tr>
            <tr>
                <td> Order Item Id: </td>
                <td><?php echo $data->order_item_id;?></td>
            </tr>
            <tr>
                <td> Merchant Sku: </td>
                <td><?php echo $data->merchant_sku;?></td>
            </tr>
            <tr>
                <td> Request Order Quantity: </td>
                <td><?php echo $data->request_order_quantity;?></td>
            </tr>
            <tr>
                <td> Request Order Cancel Qty: </td>
                <td><?php echo $data->request_order_cancel_qty;?></td>
            </tr>
            <tr>
                <td> Item Tax Code: </td>
                <td><?php echo $data->item_tax_code; ?></td>
            </tr>
            <tr>
                <td> Item Tax: </td>
                <td><?php echo $data->item_tax; ?></td>
            </tr>
            <tr>
                <td> Item Shipping Cost: </td>
                <td><?php echo $data->item_shipping_cost; ?></td>
            </tr>
            <tr>
                <td> Item Shipping Tax: </td>
                <td><?php echo $data->item_shipping_tax; ?></td>
            </tr>
        <?php $count++; } } ?>    
    </table>
  </div>
  <p class="footer"></p>
</div>
</body>
</html>