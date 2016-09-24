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
</head>
<body>
 <div id="container" style="padding: 50px">
    <h1>Return Orders</h1>
    <div class="table">
        <table class="table table-bordered">
          <thead>
              <tr>
                  <th>Merchant Return Authorization Id</th>
                  <th>Reference Return Authorization Id</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
          </thead>
        <?php
        
        if($results){
            foreach($results as $data) {?>
                <tr>
                    <td><?php echo $data->merchant_return_authorization_id?></td>
                    <td><?php echo $data->reference_return_authorization_id ?></td>
                    <td><?php echo $data->return_status ?></td>
                    <td>
                        <a href='<?php echo "/orderreturn/orderReturnDetail/".$data->order_id ?>' class="btn btn-info" role="button">View Detail</a>
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
