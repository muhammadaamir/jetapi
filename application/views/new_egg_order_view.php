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
                <tr>
            <?php }} ?>
        </table>
        <p><?php echo $links; ?></p>
    </div>
    <p class="footer"></p>
 </div>
</body>
</html>
