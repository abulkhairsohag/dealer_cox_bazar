<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('paid_and_delivered')){
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
    <?php 
    include_once("class/Database.php");
    $dbOb = new Database();
    $employee_name = Session::get("name");
    $user_name = Session::get("username");
    $password = Session::get("password");


    ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Paid And Delivered Orders</h2>
          <div class="row float-right" align="right">


          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">Order Number</th>
                <th style="text-align: center;">Shop Name</th>
                <th style="text-align: center;">Zone Name</th>
                <th style="text-align: center;">Area</th>
                <th style="text-align: center;">Ware House</th>
                <th style="text-align: center;">Payable</th>
                <th style="text-align: center;">Paid</th>
                <th style="text-align: center;">Delivery</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();

              $query = "SELECT * FROM order_delivery where due = 0 ORDER BY serial_no DESC ";

              $get_order_info = $dbOb->select($query);
              if ($get_order_info) {
                $i=0;
                while ($row = $get_order_info->fetch_assoc()) {
                  $i++;

                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $row['shop_name']; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['area']; ?></td>
                    <td><?php echo $row['ware_house_name']; ?></td>
                    <td><?php echo $row['payable_amt']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['delivery_date']; ?></td>
                    <td align="center">
                      
                      <?php 
                      if (permission_check('paid_and_delivered_view_button')) {
                        ?>
                        <a class="badge  bg-blue view_data  " id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal">view </a>
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



                      <div class="row"><div class="col"> <h3 style="color:  #34495E">Order Employee Information</h3><hr></div></div>



                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">ID </h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="employee_id" ></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Name</h5></div>
                        <div class="col-md-3" ><h5 style="color:black" id="employee_name"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Area</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="area_employee"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Order Date</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="order_date"></h5></div>
                        <div class="col-md-3"></div>
                      </div>



                      <div class="row"><div class="col"> <h3 style="color:  #34495E">Delivery Employee Information</h3><hr></div></div>


                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">ID </h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="employee_id_delivery" ></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Name</h5></div>
                        <div class="col-md-3" ><h5 style="color:black" id="employee_name_delivery"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Area</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="area_employee_delivery"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Delivery Date</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="delivery_date"></h5></div>
                        <div class="col-md-3"></div>
                      </div>



                      <div class="row"><div class="col"> <h3 style="color:  #34495E">Customer Information</h3><hr></div></div>
                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Customer_id</h4></div>
                          <div class="col-md-3"><h5 style="color:black" id="cust_id"></h4></div>
                            <div class="col-md-3"></div>
                          </div>
                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Customer Name</h4></div>
                          <div class="col-md-3"><h5 style="color:black" id="customer_name"></h4></div>
                            <div class="col-md-3"></div>
                          </div>
                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Shop Name</h4></div>
                          <div class="col-md-3"><h5 style="color:black" id="shop_name"></h4></div>
                            <div class="col-md-3"></div>
                          </div>

                          <div class="row" style="margin-top:10px" >
                            <div class="col-md-3"></div>
                            <div class="col-md-3"><h5 style="color:black">Address</h4></div>
                              <div class="col-md-3"><h5 style="color:black" id="address"></h4></div>
                                <div class="col-md-3"></div>
                              </div>

                              <div class="row" style="margin-top:10px" >
                                <div class="col-md-3"></div>
                                <div class="col-md-3"><h5 style="color:black">Mobile Number</h4></div>
                                  <div class="col-md-3"><h5 style="color:black" id="mobile_no"> </h4></div>
                                    <div class="col-md-3"></div>
                                  </div>



                                  <div class="row" style="margin-top:10px"><div class="col"> <h3 style="color:  #34495E">Order Information</h3><hr></div></div>


                                  <div class="table-responsive">
                                    <table class="table table-striped mb-none">
                                       <thead style="background: green">
                                          <tr style="color: white">
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Sell Price</th>
                                            <th>Sell QTY(Packet)</th>
                                            <th>Offer QTY(PCS)</th>
                                            <th class="text-right">Total Price (৳)</th>
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



// in the following section, details of a client will be shown 
$(document).on('click','.view_data',function(){
  var serial_no = $(this).attr("id");
  // alert(serial_no_edit);
  $.ajax({
    url : "ajax_delivery_complete.php",
    method: "POST",
    data : {serial_no_view:serial_no},
    dataType: "json",
    success:function(data){

      $("#employee_id").html(data.details['order_employee_id']);
      $("#employee_name").html(data.details['order_employee_name']);
      $("#area_employee").html(data.details['area']);
      $("#order_date").html(data.details['order_date']);

      $("#employee_id_delivery").html(data.details['delivery_employee_id']);
      $("#employee_name_delivery").html(data.details['delivery_employee_name']);
      $("#area_employee_delivery").html(data.details['area']);
      $("#delivery_date").html(data.details['delivery_date']);




      $("#cust_id").html(data.details['cust_id']);
      $("#customer_name").html(data.details['customer_name']);
      $("#shop_name").html(data.details['shop_name']);
      $("#address").html(data.details['address']);
      $("#mobile_no").html(data.details['mobile_no']);


      $("#order_table").html(data.expense);

    }
  });
});

  }); // end of document ready function 


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
