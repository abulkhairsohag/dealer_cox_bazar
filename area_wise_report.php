<?php include_once('include/header.php'); 

include_once('class/Database.php');
$dbOb = new Database();
?>

<?php 
if(!permission_check('area_wise_report')){
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
        <h2 class="panel-title" style="color: white"><h3>Area Wise Report</h3></h2>
      </div>
      <div class="panel-body">



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



    <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Zone<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">

        <select name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no ">
         <?php

         if (Session::get("zone_serial_no")){
          if (Session::get("zone_serial_no") != '-1') {

            ?>
            <option value='<?php echo Session::get("zone_serial_no"); ?>'><?php echo Session::get("zone_name"); ?></option>
            <?php
          }else{
            ?>
            <option value=''><?php echo Session::get("zone_name"); ?></option>
            <?php
          }
        }else{
          $query = "SELECT * FROM zone ORDER BY zone_name";
          $get_zone = $dbOb->select($query);
          if ($get_zone) {
            ?>
            <option value="">Please Select One</option>
            <?php
            while ($row = $get_zone->fetch_assoc()) {

              ?>
              <option value="<?php echo $row['serial_no']; ?>"  ><?php echo $row['zone_name']; ?></option>
              <?php
            }
          }else{
            ?>
            <option value="">Please Add Zone First..</option>
            <?php

          }
        }

        ?>

      </select>
    </div>
  </div>


  <div class="form-group col-md-12">
    <div class="col-md-1"></div>
    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Area<span class="required" style="color: red">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-12">

     <select name="area_employee" id="area_employee"  required="" class="form-control area_employee ">


      <?php 

      if (Session::get("zone_serial_no")){
        $zone_serial_no = Session::get("zone_serial_no") ;
        $query = "SELECT * FROM area_zone WHERE zone_serial_no = '$zone_serial_no'";
        $get_zone = $dbOb->select($query);
        if ($get_zone) {
          ?>
          <option value="">Please Select One</option>
          <?php
          while ($row = $get_zone->fetch_assoc()) {
            ?>
            <option value="<?php echo $row['area_name']?>"><?php echo $row['area_name']?></option>
            <?php
          }
        }else{
          ?>
          <option value="">Please Select Zone First..</option>
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
      <option value="dues">Summery Of Dues</option>
      <option value="order wise dues">Order Wise Dues</option>
      <option value="all sales">All Sales Summery</option>
    </select>
  </div>
</div>

<div class="form-group col-md-12" id="product_info" style="display:none">
  <div class="col-md-1"></div>
  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Product <span class="required" style="color: red">*</span></label>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <select name="product_id" id="product_id" class="form-control select2">
      <option value="">Please Select One</option>
      <?php 

      $query = "SELECT distinct products_id_no FROM product_stock";
      $get_product = $dbOb->select($query);

      if ($get_product) {
       while ($row = $get_product->fetch_assoc()) {
        $id = $row['products_id_no'];
        $query_product_info = "SELECT * FROM products WHERE products_id_no = '$id'";
        $get_product_info  = $dbOb->find($query_product_info);
        ?>

        <option value="<?php echo $row['products_id_no'] ?>"> <?php echo $get_product_info['products_name'].', '.$get_product_info['company']; ?> </option>

        <?php
      }
    }
    ?>
  </select>
</div>
</div>

<div class="form-group col-md-12" id="area_div" style="display:none">
  <div class="col-md-1"></div>
  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Area <span class="required" style="color: red">*</span></label>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <select name="area" id="area" class="form-control select2">
      <option value="">Please Select One</option>
      <?php 

      $query = "SELECT * FROM area ORDER BY area_name";
      $get_area = $dbOb->select($query);

      if ($get_area) {
       while ($row = $get_area->fetch_assoc()) {
         ?>

         <option value="<?php echo $row['area_name'] ?>"> <?php echo $row['area_name']; ?> </option>

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
      // var area = $("#area").val();
      var area = $("#area_employee").val();
      var zone_serial_no = $("#zone_serial_no").val();

      $("#show_table").html("");

      if (area == "") {
        swal({
                title: 'warning',
                text: "Area Not Selected..",
                icon: 'warning',
                button: "Done",
              });
      }else if(report_type == ''){
             swal({
                title: 'warning',
                text: "Report Type Not Selected",
                icon: 'warning',
                button: "Done",
              });
      }else{

          $.ajax({
            url: "ajax_area_wise_report.php",
            method: "POST",
            data:{from_date:from_date,to_date:to_date,report_type:report_type,area:area,zone_serial_no:zone_serial_no},
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

    $(document).on('change','#zone_serial_no',function(){
     var zone_serial_no = $(this).val();
     $.ajax({
      url:'ajax_new_order.php',
      data:{zone_serial_no:zone_serial_no},
      type:'POST',
      dataType:'json',
      success:function(data){
        $("#area_employee").html(data.area_options);
        $("#zone_name").val(zone_name);
          // console.log(data.area_options);
        }
      });
   });

    $(document).on('click','.order_no',function(){
        var serial_no = $(this).attr('id');
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