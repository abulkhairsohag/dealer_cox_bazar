<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('unpaid_but_delivered')){
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

      // $query = "SELECT * FROM employee_main_info where name = '$employee_name' and user_name = '$user_name' and password = '$password' ";
      // $get_employee_iformation = $dbOb->find($query);
      // $get_employee_id = $get_employee_iformation['id_no'];

      // $query = "SELECT * from delivery_employee where id_no = '$get_employee_id'";
      // $get_delivery_employee = $dbOb->find($query);
      // $delivery_employee_area = $get_delivery_employee['area'];
      // $employee_company = $get_delivery_employee['company'];

    ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Unpaid But Delivered Orders</h2>
          <div class="row float-right" align="right">


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
                <th style="text-align: center;">Zone Name</th>
                <th style="text-align: center;">Area</th>
                <th style="text-align: center;">Payable</th>
                <th style="text-align: center;">Paid</th>
                <th style="text-align: center;">Due</th>
                <th style="text-align: center;">Delivery</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();

              $query = "SELECT * FROM order_delivery where due > 0  ORDER BY serial_no DESC ";

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
                    <td><?php echo $row['payable_amt']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['due']; ?></td>
                    <td><?php echo $row['delivery_date']; ?></td>
                    <td align="center">


                      <a class="badge  bg-blue view_data  " id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal">view </a>
                      
                          
                      <?php 
                      if (permission_check('unpaid_but_delivered_pay_button')) {
                        ?>

                        <a class="badge  bg-green pay " id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#pay_modal">Pay </a>
                        <?php 
                      }
                      if (permission_check('unpaid_but_delivered_cancel_order_button')) {

                        if ($row['pay'] > 0) {
                         $sohag = 'cannot cancel';
                       }else{


                        ?>
                        <a  class="badge bg-red cancel_order " style="margin-top:5px" data-delivery_tbl_serial_no="<?php echo($row['serial_no']) ?>" data-order_tbl_serial_no="<?php echo($row['order_tbl_serial_no']) ?>">  Cancel Order</a>
                      <?php } } ?>
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
            <h3 class="modal-title" id="ModalLabel" style="color: white">Order Information In Detail</h3>
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





                        <!-- Modal For Paying due  -->
                        <div class="modal fade" id="pay_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog " style="width: 700px" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background: #006666">
                                <h3 class="modal-title" id="ModalLabel" style="color: white">Pay The Due</h3>
                                <div style="float:right;">

                                </div>
                              </div>
                              <div class="modal-body">

                                <div class="row">
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel" style="background: #f2ffe6">

                                      <div class="x_content" style="background: #f2ffe6">
                                        <br />


                                        <div class="row">

                                          <div class="col-md-2"></div>
                                          <div class="col-md-8">

                                            <form action="" action="POST" id="pay_due_form">
                                              <div class="form-group" style="display:none">
                                                <label for="total_due">Deliver Order Serial No</label>
                                                <input type="text" class="form-control" name="deliver_order_serial_no" id="deliver_order_serial_no" readonly>
                                              </div>
                                              <div class="form-group">
                                                <label for="total_due">Total Due</label>
                                                <input type="text" class="form-control" name="total_due" id="total_due" readonly>
                                              </div>
                                              <div class="form-group">
                                                <label for="pay_amt">Pay Amount</label>
                                                <input type="number" min="0" class="form-control" name="pay_amt" id="pay_amt" required="">
                                              </div>
                                              <div class="form-group">
                                                <label for="current_due">Current Due</label>
                                                <input type="text" class="form-control" name="current_due" id="current_due" readonly>
                                              </div>

                                              <div class="form-group">
                                                <label for="employee_id">Due Collected By <span style="color:red">*</span></label>
                                                <!-- <input type="text" class="form-control" name="current_due" id="total-due"> -->
                                                <select name="employee_id" id="employee_id" class="form-control" required>
                                                  <option value="">Select Employee</option>
                                                  <?php 

                                                  $query = "SELECT * FROM employee_main_info WHERE active_status = 'Active'";
                                                  $get_emp = $dbOb->select($query);
                                                  if ($get_emp) {
                                                    while ($row = $get_emp->fetch_assoc()) {
                                                      ?>
                                                      <option value="<?php echo $row['id_no']?>"><?php echo $row['id_no'].', '.$row['name']?></option>
                                                      <?php
                                                    }
                                                  }
                                                  ?>
                                                </select>
                                              </div>

                                              <div class="form-group">
                                                <label for="current_due">Pay Date</label>
                                                <input type="text" class="form-control date-picker datepicker" value="<?php echo date('d-m-Y') ?>"   id="pay_date" name="pay_date" readonly="" required="">
                                              </div>

                                              <div class="form-group" align="center">
                                                <input type="submit" class="btn btn-success" name="submit" value="Pay Now">
                                              </div>
                                            </form>

                                          </div>
                                          <div class="col-md-2"></div>
                                        </div>


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
                        </div> <!-- End of modal for  paying due-->


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

$(document).on('click','.pay',function(){
  var deliv_order_serial_no = $(this).attr('id');
  $.ajax({
    url:'ajax_pay_delivered_order_due.php',
    data:{deliv_order_serial_no:deliv_order_serial_no},
    type:'POST',
    dataType:'json',
    success:function(data){
      $("#total_due").val(data);
      $("#current_due").val(data);
      $("#deliver_order_serial_no").val(deliv_order_serial_no);
    }
  });

});

$(document).on('keyup blur','#pay_amt',function(){
  var pay_amt = $(this).val();
  if (isNaN(pay_amt)) {
    pay_amt = 0;
  }
  var total_due = $("#total_due").val();
  if (parseInt(pay_amt) > parseInt(total_due)) {
    alert("Pay Amount Cannot Be Greater Than The Due");
    $("#pay_amt").val("")
  }else{
    var total_due = total_due - pay_amt;
    $("#current_due").val(total_due);
  }

});

      // now we are going to update and insert data 
      $(document).on('submit','#pay_due_form',function(e){
        e.preventDefault();
        var formData = new FormData($("#pay_due_form")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_pay_delivered_order_due.php',
          data:formData,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            console.log(data);
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
            if (data.type == 'success') {
              $("#pay_modal").modal("hide");
              $("#pay_due_form")[0].reset();
              get_data_table();
            }
          }
        });
    }); // end of insert and update 

    // cancelling order 
    $(document).on('click','.cancel_order',function(){
      var cancel_order_tbl_serial_no = $(this).data('order_tbl_serial_no');
      var cancel_delivery_tbl_serial_no = $(this).data('delivery_tbl_serial_no');

      swal({
        title: "Are you sure to Cancel This Order?",
        text: "Once Cancelled, You Will Not Be Able To Recover It!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({
            url:'ajax_cancel_delivered_orders.php',
            data:{cancel_order_tbl_serial_no:cancel_order_tbl_serial_no,cancel_delivery_tbl_serial_no:cancel_delivery_tbl_serial_no},
            type:'POST',
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
    });

  }); // end of document ready function 

function get_data_table(){
  $.ajax({
    url:"ajax_pay_delivered_order_due.php",
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
