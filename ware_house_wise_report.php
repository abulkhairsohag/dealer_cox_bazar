<?php include_once('include/header.php'); 

include_once('class/Database.php');
$dbOb = new Database();

if(!permission_check('ware_house_wise_report')){
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
        <h2 class="panel-title" style="color: white"><h3>Ware House Wise Report</h3></h2>
      </div>
      <div class="panel-body">




       <div class="form-group col-md-12">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Ware House<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
          
          <select name="ware_house_serial_no" id="ware_house_serial_no"  required="" class="form-control ware_house_serial_no ">
            
            <?php
            if (Session::get("ware_house_serial_login")){
              if (Session::get("ware_house_serial_login") != '-1') {
                
                ?>
                <option value='<?php echo Session::get("ware_house_serial_login"); ?>'><?php echo Session::get("ware_house_name_login"); ?></option>
                <?php
              }else{
                ?>
                <option value=''><?php echo Session::get("ware_house_name_login"); ?></option>
                <?php
              }
            }else{

              $query = "SELECT * FROM ware_house ORDER BY ware_house_name";
              $get_ware_house = $dbOb->select($query);
              if ($get_ware_house) {
                ?>
                <option value="">Please Select One</option>
                <?php
                while ($row = $get_ware_house->fetch_assoc()) {

                  ?>
                  <option value="<?php echo $row['serial_no']; ?>" <?php if (Session::get("ware_house_serial_no") == $row["serial_no"]) {
                    echo "selected";
                  } ?>
                  ><?php echo $row['ware_house_name']; ?></option>
                  <?php
                }
              }else{
                ?>
                <option value="">Please Add Ware House First</option>
                <?php
              }
            }

            ?>

          </select>
        </div>
      </div>


      <div class="form-group col-md-12">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
          

          <select name="report_type" id="report_type" class="form-control">
            <option value="">Please Select One</option>
            <option value="all_product_stock_and_sell">All Product Stock & sell</option>
            <option value="products in stock">Products In Stock</option>
            <!-- <option value="offer products in stock">Offer Products In Stock</option> -->
            <option value="dues">Summery Of Dues</option>
            <option value="order wise dues">Order Wise Dues</option>
            <option value="all sales">All Sales Summery</option>
            <!--  -->
          </select>
        </div>
      </div>

      
      <div id="date_div" style="display:none">

        <div class="form-group col-md-12">
          <div class="col-md-1"></div>
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span class="required" style="color: red">*</span></label>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <?php $today = date("d-m-Y");  ?>
            <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today  ?>" required="" readonly="">
          </div>
        </div>



        <div class="form-group col-md-12">
          <div class="col-md-1"></div>
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span class="required" style="color: red">*</span></label>
          <div class="col-md-4 col-sm-6 col-xs-12">
            
            <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="">
          </div>
        </div>


      </div>


      <div class="form-group" style="margin-bottom: 20px;" align="center">

        <div class="col-md-12 col-sm-6 col-xs-8">
         <?php 
         if (permission_check('product_report')) {
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
          <h3 class="modal-title" id="ModalLabel" style="color: white">Order Information In Detail</h3>
          <div style="float:right;">

          </div>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" style="background: #f2ffe6">

                <div class="x_content" style="background: #f2ffe6">
                  <br/>


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
                      <div class="col-md-3"><h5 style="color:black">Customer_id</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="cust_id"></h5></div>
                      <div class="col-md-3"></div>
                    </div>
                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Customer Name</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="customer_name"></h5></div>
                      <div class="col-md-3"></div>
                    </div>
                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Shop Name</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="shop_name"></h5></div>
                      <div class="col-md-3"></div>
                    </div>

                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Address</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="address"></h5></div>
                      <div class="col-md-3"></div>
                    </div>

                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Mobile Number</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="mobile_no"> </h5></div>
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
                            <th>Sell Price<br>(Pack)</th>
                            <th>Sell Price<br>(Pcs)</th>
                            <th>Sell QTY<br>(Pack)</th>
                            <th>Sell QTY<br>(Pcs)</th>
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
                  <br/>


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
                      <div class="col-md-3"><h5 style="color:black">Customer_id</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="cust_id"></h5></div>
                      <div class="col-md-3"></div>
                    </div>
                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Customer Name</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="customer_name"></h5></div>
                      <div class="col-md-3"></div>
                    </div>
                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Shop Name</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="shop_name"></h5></div>
                      <div class="col-md-3"></div>
                    </div>

                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Address</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="address"></h5></div>
                      <div class="col-md-3"></div>
                    </div>

                    <div class="row" style="margin-top:10px" >
                      <div class="col-md-3"></div>
                      <div class="col-md-3"><h5 style="color:black">Mobile Number</h5></div>
                      <div class="col-md-3"><h5 style="color:black" id="mobile_no"> </h5></div>
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
                            <th>Sell Price<br>(Pack)</th>
                            <th>Sell Price<br>(Pcs)</th>
                            <th>Sell QTY<br>(Pack)</th>
                            <th>Sell QTY<br>(Pcs)</th>
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
      var product_id = $("#product_id").val();
      var area = $("#area").val();
      var ware_house_serial_no = $("#ware_house_serial_no").val();

      $("#show_table").html("");
      if (ware_house_serial_no == '') {
        swal({
          title: 'warning',
          text: "Please Select A Ware House",
          icon: 'warning',
          button: "Done",
        });
      }else if(report_type == ''){
       swal({
        title: 'warning',
        text: "Please Select A Report Type",
        icon: 'warning',
        button: "Done",
      });
     }else{
      $.ajax({
        url: "ajax_ware_house_wise_report.php",
        method: "POST",
        data:{from_date:from_date,to_date:to_date,report_type:report_type,product_id:product_id,area:area,ware_house_serial_no:ware_house_serial_no},
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
            // console.log(data);

          }
        });
    }

  });


    $(document).on('change','#report_type',function(){
      var report_type = $(this).val();
      if (report_type == "all sales" || report_type == 'all_product_stock_and_sell') {
        $("#date_div").show('1500');
      }else{
        $("#date_div").hide('1500');
      }
    });

    $(document).on('click','.order_no',function(){
        var serial_no = $(this).attr('id');
        // alert(serial_no);
        $('#view_modal').modal('show');
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

    
    $(document).on('change','#ware_house_serial_no',function(){
     var ware_house_serial_no = $(this).val();
     $.ajax({
      url:'ajax_new_order.php',
      data:{ware_house_serial_no:ware_house_serial_no},
      type:'POST',
      dataType:'json',
      success:function(data){
          // $("#cust_id").html(data);
        }
      });
   });
  });

  function printContent(el){
    var a = document.body.innerHTML;
    var b = document.getElementById(el).innerHTML;
    document.body.innerHTML = b;
    window.print();
    document.body.innerHTML = a;
    return window.location.reload(true);

  }
  $("#area").select2({ width: '100%' }); 
  $("#product_id").select2({ width: '100%' }); 
</script>

</body>
</html>