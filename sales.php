<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('sales_list')){
  ?>
  <script>
    window.location.href = '403.php';
  </script>
  <?php 
}
 ?>

<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Sell List</h2>
          <div class="row float-right" align="right">

            <?php 
            if (permission_check('sale_product')) {
              ?>
              <a href="sale_product.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fa fa-plus"> </i></span> Sell Product</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Employee ID</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Order Number</th>
                <th style="text-align: center;">Cuatomer Name</th>
                <th style="text-align: center;">Mobile</th>
                <th style="text-align: center;">Total Payable</th>
                <th style="text-align: center;">Paid</th>
                <th style="text-align: center;">Due</th>
                <th style="text-align: center;">Sell Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM own_shop_sell ORDER BY serial_no DESC ";
              $get_order_info = $dbOb->select($query);
              if ($get_order_info) {
                $i=0;
                while ($row = $get_order_info->fetch_assoc()) {
                  $i++;
                  if ($row['customer_id'] == '-1') {
                    $customer_name = "Walking Customer";
                  }else{
                    $customer_name = $row['customer_name'];
                  }
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['net_payable_amt']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['due']; ?></td>
                    <td><?php echo $row['sell_date']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('sale_product_view_button')) {
                        ?>
                         <a  class="badge  bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a> 
                         <?php } ?>

                      <?php 
                      if (permission_check('sale_product_edit_button')) {
                        ?>
                        <a href="edit_own_shop_sell.php?serial_no=<?php echo urldecode($row['serial_no']);?>" class="badge  bg-blue edit_data" >Edit </a>
                      <?php } ?>
                      
                      <?php 
                      if (permission_check('sale_product_delete_button')) {
                        ?>
                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 

                      <?php } ?>  
                    </td>
                  </tr>

                  <?php
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>



    <!-- Modal For Showing data  -->
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " style="width: 700px" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Order Infomation In Detail</h3>
            <div style="float:right;">

            </div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="background: #f2ffe6">

                  <div class="x_content" style="background: #f2ffe6">
                    <br />





                    <div style="margin : 20px" id="info_table">



                      <div class="row"><div class="col"> <h3 style="color:  #34495E">Employee Information</h3><hr></div></div>



                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Employee ID </h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="employee_id_show" ></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Employee Name</h5></div>
                        <div class="col-md-3" ><h5 style="color:black" id="employee_name_show"></h5></div>
                        <div class="col-md-3"></div>
                      </div>


                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Sell Date</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="sell_date_show"></h5></div>
                        <div class="col-md-3"></div>
                      </div>


                      <div class="row"><div class="col"> <h3 style="color:  #34495E">Customer Information</h3><hr></div></div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Customer Name</h4></div>
                          <div class="col-md-3"><h5 style="color:black" id="customer_name_show"></h4></div>
                            <div class="col-md-3"></div>
                          </div>

                          

                              <div class="row" style="margin-top:10px" >
                                <div class="col-md-3"></div>
                                <div class="col-md-3"><h5 style="color:black">Mobile Number</h4></div>
                                  <div class="col-md-3"><h5 style="color:black" id="mobile_no_show"> </h4></div>
                                    <div class="col-md-3"></div>
                                  </div>

                                  <div class="row" style="margin-top:10px"><div class="col"> <h3 style="color:  #34495E">Order Information</h3><hr></div></div>


                                  <div class="table-responsive">
                                    <table class="table table-striped mb-none">
                                      <thead style="background: green">
                                        <tr style="color: white">
                                          <th>#</th>
                                          <th>Product ID</th>
                                          <th>Name</th>
                                          <th>Sell Price (৳)</th>
                                          <th>Quantity</th>
                                          <th>Total Price (৳)</th>
                                        </tr>
                                      </thead>
                                      <tbody id="order_table">



                                      </tbody>
                                    </table>
                                  </div>



                                </div>   <!-- End of info table  -->






                              </div>
                            </div>
                          </div>
                        </div>  
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div> <!-- End of modal for  Showing data-->






                <!-- /page content -->

              </div>
            </div>
            <?php include_once('include/footer.php'); ?>

            <script>
              $(document).ready(function(){

    //delete data by id 
    $(document).on('click','.delete_data',function(){
      var serial_no_delete = $(this).attr("id");
      // alert(serial_no_delete);
      swal({
        title: "Are you sure to delete?",
        text: "Once deleted, all related information will be lost!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
           // alert(serial_no_delete);

          $.ajax({
            url:"ajax_sell_product.php",
            data:{delete_id:serial_no_delete},
            type:"POST",
            dataType:'json',
            success:function(data){
              swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
              // console.log(data);
              get_data_table();
            }
          });

        } 
      });

  }); // end of delete 

// in the following section, details of a client will be shown 
$(document).on('click','.view_data',function(){
  var serial_no = $(this).attr("id");
  // alert(serial_no_edit);
  $.ajax({
    url : "ajax_sell_product.php",
    method: "POST",
    data : {serial_no_view:serial_no},
    dataType: "json",
    success:function(data){

      $("#employee_id_show").html(data.details['employee_id']);
      $("#employee_name_show").html(data.details['employee_name']);
      $("#sell_date_show").html(data.details['sell_date']);
      if (data.details['customer_id'] == '-1' && data.details['customer_name'] == '') {
       var  customer_name = 'Walking Cuatomer';
      }else{
        var customer_name = data.details['customer_name'];
      }
      $("#customer_name_show").html(customer_name);
      $("#mobile_no_show").html(data.details['mobile_no']);




      $("#order_table").html(data.expense);

    }
  });
});
  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_sell_product.php",
    data:{'sohag':'sohag'},
    type:"POST",
    dataType:"text",
    success:function(data_tbl){
      sohag.destroy();
      $("#data_table_body").html(data_tbl);
      init_DataTables();

    }
  });
}

</script>
<?php 

if (Session::get("update_message")) {
  ?>
  <script>
    swal({
      title: "<?php echo(Session::get("update_type")); ?>",
      text: "<?php echo(Session::get("update_message")); ?>",
      icon: "<?php echo(Session::get("update_type")); ?>",
      buttons: "Done",

    })
  </script>

  <?php
  Session::set("update_message",Null);
  Session::set("update_type",Null);
}
?>
</body>
</html>
