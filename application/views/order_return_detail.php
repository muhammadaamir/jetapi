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
  <h1>Return Order Detail</h1>
    <div id="body">
      <table class="table table-bordered ">
          <?php //echo '<pre>'; print_r($results); ?>
        <?php if(count($results[0])>0){?>
        <tr>
            <td>Merchant Return Authorization Id </td>
            <td><?php echo $results[0]->merchant_return_authorization_id; ?></td>
        </tr>
        <tr>
            <td>Reference return authorization id </td>
            <td><?php echo $results[0]->reference_return_authorization_id; ?></td>
        </tr>
        <tr>
            <td>Return status  </td>
            <td><?php echo $results[0]->return_status; ?></td>
        </tr>
        <?php if($results[0]->refund_without_return){
           echo "<tr>
               <td> Refund without return: </td>
               <td>True</td>
            </tr>";
        }else{
             echo "<tr>
                 <td> Refund without return </td>
                 <td>False</td>
            </tr>";
        }?>
        <tr>
            <td>Merchant order id : </td>
            <td><?php echo  $results[0]->merchant_order_id;?></td>
        </tr>
        <tr>
            <td>Reference order id : </td>
            <td><?php echo  $results[0]->reference_order_id; ?></td>
        </tr>
        <tr>
            <td>Alt order id: </td>
            <td><?php echo  $results[0]->alt_order_id;?></td>
        </tr>
        <tr>
            <td>Return date : </td>
            <td><?php echo  $results[0]->return_date;  ?></td>
        </tr>
        <tr>
            <td> shipping carrier: </td>
            <td><?php echo $results[0]->shipping_carrier;?></td>
        </tr>
        <tr>
            <td> tracking number: </td>
            <td><?php echo $results[0]->tracking_number;?></td>
        </tr>
        <tr>
            <td> merchant return charge: </td>
            <td><?php echo $results[0]->merchant_return_charge;?></td>
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
                <td> Alt order item id: </td>
                <td><?php echo $data->alt_order_item_id;?></td>
            </tr>
            <tr>
                <td> Merchant sku: </td>
                <td><?php echo $data->merchant_sku;?></td>
            </tr>
            <tr>
                <td> Return quantity : </td>
                <td><?php echo $data->return_quantity; ?></td>
            </tr>
            <tr>
                <td> Reason: </td>
                <td><?php echo $data->reason; ?></td>
            </tr>
            <tr>
                <td> Principal : </td>
                <td><?php echo $data->principal; ?></td>
            </tr>
            <tr>
                <td> Shipping Tax: </td>
                <td><?php echo $data->tax; ?></td>
            </tr>
            <tr>
                <td> Shipping Cost: </td>
                <td><?php echo $data->shipping_cost; ?></td>
            </tr>
            <tr>
                <td> Shipping Tax: </td>
                <td><?php echo $data->shipping_tax; ?></td>
            </tr>
            
        <?php $count++; } } ?>    
    </table>
  </div>
  <p class="footer"></p>
</div>
</body>
</html>