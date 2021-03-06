<?php include_once 'include/header.php';
error_reporting(1);
?>


<?php
if (!permission_check('new_order')) {
	?>
  <script>
    window.location.href = '403.php';
  </script>
  <?php
}

include_once "class/Database.php";
include_once "class/Session.php";
$dbOb = new Database();
$employee_name = Session::get("name");
$user_name = Session::get("username");
$password = Session::get("password");

$query = "SELECT * FROM employee_main_info where name = '$employee_name' and user_name = '$user_name' and password = '$password' ";
$get_employee_iformation = '';
$get_employee = $dbOb->select($query);
if ($get_employee) {
	$get_employee_iformation = $get_employee->fetch_assoc();
	$employee_id = $get_employee_iformation['id_no'];
	?>
<!-- this input is for getting data table back after deleting data -->
<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $employee_id ?>">
  <?php
}

?>


<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Invoice List</h2>
          <div class="row float-right" align="right">

            <?php
if (permission_check('new_order')) {
	?>
              <a href="new_order.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Order</a>
            <?php }?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

         <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Order Number</th>
                <th style="text-align: center;">Shop Name</th>
                <th style="text-align: center;">Customer Name</th>
                <th style="text-align: center;">Area</th>
                <th style="text-align: center;">Total Payable</th>
                <th style="text-align: center;">Order Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php
include_once 'class/Database.php';
$dbOb = new Database();
$query = "SELECT * FROM new_order_details WHERE employee_id = '$employee_id' AND delivery_report = '0' AND delivery_cancel_report = '0' ORDER BY serial_no DESC ";
$get_order_info = $dbOb->select($query);
if ($get_order_info) {
	$i = 0;
	while ($row = $get_order_info->fetch_assoc()) {
		$i++;

		?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $row['shop_name']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['area_employee']; ?></td>
                    <td><?php echo $row['payable_amt']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td align="center">

                         <a  class="badge  bg-green view_data" id="<?php echo ($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>

                        <a href='edit_new_order.php?serial_no=<?php echo urldecode($row['serial_no']); ?>' class="badge  bg-blue edit_data" >Edit </a>

                        <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>

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
                        <div class="col-md-3"><h5 style="color:black" id="employee_id" ></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Employee Name</h5></div>
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
                                          <th>Pack Size</th>
                                          <th>Unit TP</th>
                                          <th>Unit VAT</th>
                                          <th>TP + VAT</th>
                                          <th>QTY</th>
                                          <th>Total TP</th>
                                          <th>Total VAT</th>
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
            <?php include_once 'include/footer.php';?>

            <script>
              $(document).ready(function(){

    //delete data by id
    $(document).on('click','.delete_data',function(){
      var serial_no_delete = $(this).attr("id");
      swal({
        title: "Are you sure to delete?",
        text: "Once deleted, all related information will be lost!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({
            url:"ajax_order_list.php",
            data:{serial_no_delete:serial_no_delete},
            type:"POST",
            dataType:'json',
            success:function(data){
              swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
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
    url : "ajax_order_list.php",
    method: "POST",
    data : {serial_no_view:serial_no},
    dataType: "json",
    success:function(data){

      $("#employee_id").html(data.details['employee_id']);
      $("#employee_name").html(data.details['employee_name']);
      $("#area_employee").html(data.details['area_employee']);
      $("#cust_id").html(data.details['cust_id']);
      $("#customer_name").html(data.details['customer_name']);
      $("#order_date").html(data.details['order_date']);
      $("#shop_name").html(data.details['shop_name']);
      $("#address").html(data.details['address']);
      $("#mobile_no").html(data.details['mobile_no']);




      $("#order_table").html(data.expense);

    }
  });
});
  }); // end of document ready function

// the following function is defined for showing data into the table
function get_data_table(){
  var emp_id = $('#emp_id').val();
  // alert(emp_id);
  $.ajax({
    url:"ajax_order_list.php",
    data:{'sohag':'sohag',emp_id:emp_id},
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
      title: "<?php echo (Session::get("update_type")); ?>",
      text: "<?php echo (Session::get("update_message")); ?>",
      icon: "<?php echo (Session::get("update_type")); ?>",
      buttons: "Done",

    })
  </script>

  <?php
Session::set("update_message", Null);
	Session::set("update_type", Null);
}
?>
</body>
</html>
