<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('own_shop_report')){
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

    <div>
      <div class="panel-heading" style="background: #34495E;color: white; padding-bottom: 10px" align="center">
        <h2 class="panel-title" style="color: white"><h3>Own Shop Report</h3></h2>
      </div>
      <div class="panel-body">


       <div class="form-group col-md-12" id="date_from">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");  ?>
         <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today  ?>" required="" readonly="">
       </div>
     </div>



     <div class="form-group col-md-12" id="date_to">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        
        <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="">
      </div>
    </div>



    <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="Sell Report">Sell Report</option>
          <option value="Due sell Report">Due sell Report</option>
          <option value="Paid sell Report">Fully Paid sell Report</option>
          <option value="Customer Wise Report">Customer Wise Report</option>
          <option value="Employee Wise Sell Report">Employee Wise Sell Report</option>
        </select>
      </div>
    </div>


     <div class="form-group col-md-12" id="customer_div" style="display: none; ">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Customer</label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="customer_id" id="customer_id"class="form-control select2" >
          <option value="">Select Customer</option>
          <option value="-1">Walking Customer</option>
          <?php 

            $query = "SELECT * FROM own_shop_client";
            $get_client = $dbOb->select($query);
            if ($get_client) {
              while ($row = $get_client->fetch_assoc()) {
                ?>
                  <option value="<?php echo $row['serial_no'] ?>"><?php echo $row['client_name'] ?></option>
                <?php
              }
            }

           ?>
        </select>
      </div>
    </div>



     <div class="form-group col-md-12" id="paid_due_div" style="display: none; ">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Paid/Due Sell</label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="paid_due" id="paid_due"class="form-control" >
          <option value="all">All (Paid And Due)</option>
          <option value="paid">Paid</option>
          <option value="due">Due</option>
        </select>
      </div>
    </div>



     <div class="form-group col-md-12" id="employee_div" style="display: none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Employee</label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="employee_id" id="employee_id"class="form-control select2" >
          <option value="">Select Employee</option>
          <?php 

            $query = "SELECT * FROM own_shop_employee";
            $get_shop_employee = $dbOb->select($query);
            if ($get_shop_employee) {
              while ($row = $get_shop_employee->fetch_assoc()) {
                ?>
                  <option value="<?php echo $row['id_no'] ?>"><?php echo $row['name'].', '.$row['id_no'] ?></option>
                <?php
              }
            }

           ?>
        </select>
      </div>
    </div>





    <div class="form-group" style="margin-bottom: 20px;" align="center">

      <div class="col-md-12 col-sm-6 col-xs-8">
         <?php 
            if (permission_check('own_shop_report')) {
          ?>
        <button class="btn btn-success" id="view_record">View Record</button>
        <?php } ?> 
      </div>
    </div>






  </div>
</div>
<div class="well" style="background: white;margin-top: 20px">
  <div class="row" id="show_table">




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
                                          <th>ID</th>
                                          <th>Name</th>
                                          <!-- <th>Category</th> -->
                                          <th>Promo Offer</th>
                                          <th>MRP (৳)</th>
                                          <th>Quantity</th>
                                          <th>Sell Price (৳)</th>
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
    $(document).on('click','#view_record',function(){
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var report_type = $("#report_type").val();
      var employee_id = $("#employee_id").val();
      var customer_id = $("#customer_id").val();
      var paid_due = $("#paid_due").val();

      $("#show_table").html("");

        $.ajax({

          url: "ajax_own_shop_report.php",
          method: "POST",
          data:{
                from_date:from_date,
                to_date:to_date,
                report_type:report_type,
                employee_id:employee_id,
                customer_id:customer_id,
                paid_due: paid_due
            },
          dataType: "json",
          success:function(data){
            $("#show_table").html(data);
            // console.log(data);
          }
        });

    });

    $(document).on('change','#report_type',function(){
      var report_type = $(this).val();
      if (report_type == 'Customer Wise Report') {
        $("#customer_div").show(500);
        $("#paid_due_div").show(500);
        $("#employee_div").hide(500);
      }else if(report_type == 'Employee Wise Sell Report'){
        $("#customer_div").hide(500);

        $("#paid_due_div").hide(500);
        $("#employee_div").show(500);
      }else{
        $("#paid_due_div").hide(500);
        $("#customer_div").hide(500);
        $("#employee_div").hide(500);

      }
    });

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

   

  }); // end of document ready 

$("#customer_id").select2({ width: '100%' }); 
$("#employee_id").select2({ width: '100%' }); 

</script>


</body>
</html>