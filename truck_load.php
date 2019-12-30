<?php include_once('include/header.php'); 

include_once("class/Database.php");
$dbOb = new Database();
?>


<?php 
if(!permission_check('truck_load_for_delivery')){
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


    <div class="col-md-12 col-sm-12 col-xs-12" style="color: black">
      <div class="x_panel">
        <div class="x_title">
          <div class="row float-right" align="right">



          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <!-- form starts form here -->
          <form class="form-horizontal form-bordered" id="add_data_form" action="" method="post">


            <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                Area, Employee & Transport Information 
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Delivery Man's ID <span class="required" style="color: red">*</span></label>
              <div class="col-md-6">
                    <select name="delivery_employee_id" id="delivery_employee_id"  required="" class="form-control delivery_employee_id ">
                <option value="">Please Select</option>
                <?php
                $query = "SELECT * FROM delivery_employee WHERE active_status = 'Active' ORDER BY id_no";
                $get_delivery_man = $dbOb->select($query);
                if ($get_delivery_man) {
                  while ($row = $get_delivery_man->fetch_assoc()) {
                   ?>
                   <option value="<?php echo $row['id_no']; ?>" <?php if (Session::get("delivery_emp_id") == $row['id_no']) {
                    echo "selected";
                  } ?>><?php echo $row['id_no'].', '.$row['name']; ?></option>
                  <?php
                }
              }
              ?>

            </select>
              </div>
            </div>

            <div class="form-group" style="display:none">
              <label class="col-md-3 control-label" for="inputDefault">Delivery Man's Name </label>
              <div class="col-md-6">
                <input type="text" class="form-control delivery_employee_name" id="delivery_employee_name" name="delivery_employee_name" readonly="" value="<?php if (Session::get("delivery_employee_name")) {
            echo Session::get("delivery_employee_name");
          } ?>" >
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Zone </label>
               <div class="col-md-6">
            <select name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no ">
              <option value="">Please Select One</option>
              <?php

              $query = "SELECT * FROM zone ORDER BY zone_name";
              $get_zone = $dbOb->select($query);
              if ($get_zone) {
                while ($row = $get_zone->fetch_assoc()) {

                ?>
                <option value="<?php echo $row['serial_no']; ?>" <?php if (Session::get("zone_serial_no") == $row["serial_no"]) {
                  echo "selected";
                } ?>
                ><?php echo $row['zone_name']; ?></option>
                <?php
              }
            }

            ?>

            </select>
            
              </div>
            </div>


            <div class="form-group" >
              <label class="col-md-3 control-label" for="inputDefault">Area <span class="required" style="color: red">*</span></label>
              <div class="col-md-6">
              <select name="area_employee" id="area_employee"  required="" class="form-control area_employee ">

                <?php 

                if (Session::get("area_options")) {
                  echo Session::get("area_options");
                }else{
                  ?>
                  <option value="">Please Select Zone First</option>
                  <?php
                }
                ?>

                </select>
              </div>
            </div>


  <div class="form-group row">
    <label class="col-md-3 col-6 control-label" for="inputDefault">Select Ware House<span class="required" style="color: red">*</span></label>
    <div class="col-md-6 col-6">
        <select name="ware_house_serial_no" id="ware_house_serial_no"  required="" class="form-control ware_house_serial_no ">
          <option value="">Please Select One</option>
          <?php

          $query = "SELECT * FROM ware_house ORDER BY ware_house_name";
          $get_ware_house = $dbOb->select($query);
          if ($get_ware_house) {
            while ($row = $get_ware_house->fetch_assoc()) {

            ?>
            <option value="<?php echo $row['serial_no']; ?>" <?php if (Session::get("ware_house_serial_no") == $row["serial_no"]) {
              echo "selected";
            } ?>
            ><?php echo $row['ware_house_name']; ?></option>
            <?php
          }
        }

        ?>

    </select>
    </div>
  </div>




            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vehicle Registraton No <span class="required" style="color: red">*</span></label>
              <div class="col-md-6">
                <select name="vehicle_reg_no" id="vehicle_reg_no" class="form-control" required="">
                  <option value="">Select Vehicle Reg. No</option>
                  <?php 
                  $query = "SELECT * FROM transport";
                  $transport = $dbOb->select($query);
                  if ($transport) {
                    while ($row = $transport->fetch_assoc()) {
                      $veicle_reg = $row["reg_no"];
                      $vehicle_name  = $row["vehicle_name"];
                      ?>
                      <option value="<?php echo $veicle_reg ?>"><?php echo $veicle_reg.', '.$vehicle_name ; ?></option>

                      <?php
                    }
                  }
                  ?>

                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vehicle Name </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="vehicle_name" name="vehicle_name"  required="" readonly="" >
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vehicle Type </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" readonly="" required="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Loading Date </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="loading_date" name="loading_date" value='<?php echo date("d-m-Y") ?>' readonly="">
              </div>
            </div>


<!-- in the following div product info will be placed using ajax while changing the area  -->

                <div id="invoice_details">
                        <div class="form-group bg-success" style="padding-bottom: 5px;margin-top: 30px">

	              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
	                Following Products To Be Loaded.....
	              </div>
	            </div>

	            <table class="table" class="">

	              <thead>
	                <tr>
	                  <th style="text-align: center;">Product ID</th>
	                  <th style="text-align: center;">Product Name</th>
	                  <th style="text-align: center;">Category</th>
                    <th style="text-align: center;">Available</th>
	                  <th style="text-align: center;">Quantity(Packet)</th>
	                  <th style="text-align: center;">Offer QTY(PCS)</th>
	                </tr>
	              </thead>
	              <tbody id="">  
                <?php 
                  $query = "SELECT * FROM `products`";
                  $get_products = $dbOb->select($query);
                  if ($get_products) {
                    while ($row = $get_products->fetch_assoc()) {
                      ?>
                        <tr>
                          <td>
                            <input type="text" class="form-control main_product_id product_id" name="product_id[]" readonly="" value="<?php echo $row['products_id_no']?>">
                          </td>
                          <td>
                            <input type="text" class="form-control main_products_name products_name" name="products_name[]" readonly="" value="<?php echo $row['products_name']?>">
                          </td>
                          <td>
                            <input type="text" class="form-control main_category category" name="category[]" readonly="" value="<?php echo $row['category']?>">
                          </td>
                          <td>
                            <input type="text" class="form-control main_available available" name="available[]" readonly="" value="">
                          </td>
                          <td>
                            <input type="number" min="0" step="1" class="form-control main_quantity quantity" name="quantity[]"  value="">
                          </td>
                          <td>
                            <input type="text" class="form-control main_quantity_offer quantity_offer" name="quantity_offer[]" readonly=""  value="">
                          </td>
                        </tr> 
                      <?php
                    }
                  }
                  
                ?>
                 
                </tbody>
              </table>
                             
                </div>






            <div class="form-group" align="center">
            <?php 

            if (permission_check('truck_load_save_button')) {
              ?>
              <input type="submit" name="submit" value="Save" class="btn btn-success" style="">
              <?php } ?>
              <input type="reset" name="reset" value="Reset" class="btn btn-warning">
            </div>

          </form>


        </div>
      </div>
    </div>





    <!-- /page content -->

  </div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){



 $(document).on('change','#vehicle_reg_no', function() {
      var reg_no = $(this).val();
      $("#vehicle_name").val('');
      $("#vehicle_type").val('');

      $.ajax({
        url:"ajax_truck_load.php",
        data:{reg_no:reg_no},
        type:"post",
        dataType:'json',
        success:function(data){
          if (data.message) {
            console.log(data.message)
             swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
          }else{
            $("#vehicle_name").val(data.get_vehicle.vehicle_name);
            $("#vehicle_type").val(data.get_vehicle.type);
          }
        }
      });
});


    // now we are going to  insert data 
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_truck_load.php',
        data:formData,
        type:'POST',
        dataType:'json',
        cache: false,
        processData: false,
        contentType: false,

        success:function(data){
           // alert('ppppp');
           swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
           if (data.type == 'success') {
            setTimeout(function(){
              location. reload(true)
            },2000);


          }
        }
      });
    }); // end of insert 


    $(document).on('change','#delivery_employee_id',function(){
     var emp_id = $(this).val();
     $.ajax({
        url:'ajax_new_order.php',
        data:{delivery_emp_id:emp_id},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#delivery_employee_name").val(data);
          // $(".employee_id").val(emp_id);
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

  $(document).on('change','#area_employee',function(){
     var area_name = $(this).val();
     $.ajax({
        url:'ajax_new_order.php',
        data:{area_name:area_name},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#cust_id").html(data);
          // $(".employee_id").val(emp_id);
          // console.log(data.area_options);
        }
      });
  });

  $(document).on('change','#ware_house_serial_no',function(){
     var ware_house_serial_no = $(this).val();
       $(".available").val("");
       $(".quantity").val("");
       $(".quantity_offer").val("");
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

  $(document).on('change keyup blur','.quantity',function(){
    var quantity = $(this).val();
    var tr = $(this).parent().parent();
    var product_id = tr.find(".product_id").val();
    var ware_house_serial_no  = $("#ware_house_serial_no").val();
    var available_qty  = tr.find(".available").val();

     if (ware_house_serial_no == "") {
        
       $(".available").val("");
       $(".quantity").val("");
       $(".quantity_offer").val("");

     }else{
  
        if (available_qty < quantity) {
             swal({
                title: 'warning',
                text: "The Quantity You Have Provided Is Out Of Stock..",
                icon: 'warning',
                button: "Done",
              });
             tr.find(".quantity").val("");
             tr.find(".quantity_offer").val("");
        }else{
           $.ajax({
            url:'ajax_truck_load.php',
            data:{product_id_check:product_id},
            type:'POST',
            dataType:'json',
            success:function(data){
             if (data == 'N/A') {
               tr.find(".quantity_offer").val(data);
             }else{
               var offer_integer = parseInt(quantity / data.packet_qty);
               tr.find(".quantity_offer").val(offer_integer * data.product_qty);
             }
             
            }
          });
        }
   }
  });

 // here we are going to get products available quantity  
  $(document).on('click','.quantity',function(){
    var quantity = $(this).val();
     var tr = $(this).parent().parent();
     var product_id = tr.find(".product_id").val();
     var ware_house_serial_no  = $("#ware_house_serial_no").val();

     if (ware_house_serial_no == "") {
         swal({
                title: 'warning',
                text: "Please Select Ware House First..",
                icon: 'warning',
                button: "Done",
              });
         $(".available").val("");
       $(".quantity").val("");
       $(".quantity_offer").val("");

     }else{
  
       $.ajax({
          url:'ajax_truck_load.php',
          data:{ware_serial:ware_house_serial_no,prod_id:product_id},
          type:'POST',
          dataType:'json',
          success:function(data){
           tr.find(".available").val(data);
          }
        });
   } // end of else
  });

  }); // end of document ready function 

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>

</body>
</html>