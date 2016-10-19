<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Jet Api</title>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
        
        <script>
        $(document).on('click','.order',function(){
            $('#loader-'+id).show();
            var id = $(this).attr('order-id');
            var statusValue = $(this).val();
//            alert(id );
            $.ajax({
                url: '<?php echo base_url('NewEggOrder/updateOrder'); ?>',
                type: 'POST',
                crossDomain:true,
                xhrFields:{withCredentials:true},
                data: {
                    status: statusValue,
                    id:id
                },
                beforeSend: function (xhr) {
                        $('#loader-'+id).show();
                    },
                success: function(data) {
//                    
//                    var data = JSON.stringify(data);
                    alert(data);
                    console.log("     order# "+id+" Status: "+statusValue);
//                    location.reload();
                    $('#loader-'+id).hide();
                },
                error: function(err){
                    $('#loader-'+id).hide();
                    alert(err+" in error");
                
               
                }
            });
        });
        
        
        $(document).on('click','.confirm-order',function(){
            var id= $(this).val();
            $.ajax({
                url:'<?php echo base_url('NewEggOrder/confirmOrder')?>',
                type:'POST',
                data: {
                    id:id
                },
                success:function(data){
                    alert(data+" in success");
                },
                error: function(err){
                    alert(err+" in error");
                }
                        
            });
        });
        </script>

</head>
<body>
 <div id="container" style="padding: 50px">
    <h1>New Egg Orders</h1>
    <div class="table">
        <table class="table table-striped table-hover">
          <thead>
              <tr>
                  <th>Order Id</th>
                  <th>Status</th>
                  <th>Seller Id</th>
                  <th>Action</th>
              </tr>
          </thead>
        <?php
        
        if($results){
            foreach($results as $data) {?>
                <tr>
                    <td><?php echo $data->order_number?></td>
                    <td><?php echo $data->order_status_description?></td>
                    <td><?php echo $data->seller_id ?></td>
                    <td>
                        <div id="div-<?php echo $data->order_number ?>">
                            <?php
                            $status=$data->order_status_description;
                            if($status == 'Shipped'){ ?>
                                <button type="button" class="btn btn-success order" value='shipped' order-id="<?php echo $data->order_number ?>" >Shipping</button>
                            <?php
                            }elseif($status == 'Invoiced'){

                            }elseif($status=='Unshipped'||$status=='Partially Shipped'){?>
                            <button type="button" class="btn btn-danger order" value='cancel' order-id="<?php echo $data->order_number ?>" >Cancel Order</button>
                            <button type="button" class="btn btn-primary order" value='ship' order-id="<?php echo $data->order_number ?>" >Ship Order</button>
                            <?php

                            }elseif($status=='Voided'){ ?>
                                <button type="button" class="btn btn-primary order" value='ship' order-id="<?php echo $data->order_number ?>" >Ship Order</button>
                            <?php }
                            else{?>
                            <?php
                            }
                            ?>
                            <a href='<?php echo "oderDetail/".$data->order_number ?>' class="btn btn-info" role="button">View Detail</a>
                            <span style="display:none" id="loader-<?php echo $data->order_number ?>"><img src="<?php echo base_url("assets/img/loader.gif"); ?>" /></span>
                        </div>
                    </td>
                <tr>
            <?php }} ?>
        </table>
        <p><?php echo $links; ?></p>
    </div>
            
    <div class="container" style="padding:30px">
        <div class="row">
            <div class="col-sm-4" style="padding:40px; width: 150px; height: 150px; background-color:lightgrey">Order : 101355900</div>
            <div class="col-sm-2" style="padding:20px"> <button class="btn btn-info confirm-order" value="101355900">Confirm Order</button></div>
        </div>
    </div>
    <p class="footer"></p>
 </div>
</body>
</html>
