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
        $(document).ready(function(){
//            $(".action").click(function(){
//                alert('a');
//            });
            
        });
        function action(id, objButton){
            var id = id;
            var statusValue = objButton.value;
//            alert(id );
            $.ajax({
                url: '<?php echo site_url('order/updateOrder'); ?>',
                type: 'POST',
                data: {
                    status: statusValue,
                    id:id
                },
                dataType: 'json',
                success: function(data) {
//                    console.log(data);
                    //alert(data.status);
                    location.reload();
                },
                error: function(){
                  alert("error");
                }
            });
        }
        </script>

</head>
<body>
 <div id="container" style="padding: 50px">
    <h1>Orders</h1>
    <div class="table">
        <table class="table table-bordered">
          <thead>
              <tr>
                  <th>Order Id</th>
                  <th>Order Placed Date</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
          </thead>
        <?php
        
        if($results){
            foreach($results as $data) {?>
                <tr>
                    <td><?php echo $data->order_id?></td>
                    <td><?php echo date('d/m/Y h:m a', strtotime($data->order_placed_date)) ?></td>
                    <td><?php echo $data->status?></td>
                    <td>
                        <?php if($data->status != 'accept'){ ?>
                            <button type="button" class="btn btn-primary" value='accept' onclick='action("<?php echo $data->id ?>",this)'>Accept</button>
                            <button type="button" class="btn btn-danger " value='reject' onclick='action("<?php echo $data->id ?>",this)'>Reject</button>
                        <?php }else{ ?>
                            <button type="button" class="btn btn-success" value='shipping' >Shipping</button>
                        <?php }?>
                        <a href='<?php echo "/order/oderDetail/".$data->order_id ?>' class="btn btn-info" role="button">View Detail</a>
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
