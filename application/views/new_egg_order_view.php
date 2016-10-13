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
                url: '<?php echo site_url('order/updateOrder'); ?>',
                type: 'POST',
                data: {
                    status: statusValue,
                    id:id
                },
                dataType: 'json',
                beforeSend: function (xhr) {
                        $('#loader-'+id).show();
                    },
                success: function(data) {
//                    
                    var data = JSON.stringify(data);
//                    alert(data);
                    location.reload();
                    $('#loader-'+id).hide();
                },
                error: function(){
            $('#loader-'+id).hide();
                  alert("error");
                }
            });
        });
        </script>

</head>
<body>
 <div id="container" style="padding: 50px">
    <h1>New Egg Orders</h1>
    <div class="table">
        <table class="table table-bordered">
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
                    <td><?php echo $data->order_status_name?></td>
                    <td><?php echo $data->seller_id ?></td>
                    <td>
                        <div id="div-<?php echo $data->order_number ?>">
                            <?php if($data->order_status_code == 'accepted'){ ?>
                                <button type="button" class="btn btn-success order" value='shipped' order-id="<?php echo $data->order_number ?>" >Shipping</button>
                            <?php
                            }elseif($data->order_status_code == 'rejected'){

                            }elseif($data->order_status_code == 'shipped'){?>
                            
                            <?php

                            }else{ ?>
                                <button type="button" class="btn btn-primary order" value='accepted' order-id="<?php echo $data->order_number ?>" >Accept</button>
                                <button type="button" class="btn btn-danger order" value='rejected' order-id="<?php echo $data->order_number ?>" >Reject</button>
                            <?php }?>
                            <a href='<?php echo "/order/oderDetail/".$data->order_number ?>' class="btn btn-info" role="button">View Detail</a>
                            <span style="display:none" id="loader-<?php echo $data->order_number ?>"><img src="<?php echo base_url("assets/img/loader.gif"); ?>" /></span>
                        </div>
                    </td>
                <tr>
            <?php }} ?>
        </table>
        <p><?php echo $links; ?></p>
    </div>
    <p class="footer"></p>
 </div>
</body>
</html>
