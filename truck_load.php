<?php include_once('include/header.php'); 

include_once("class/Database.php");
$dbOb = new Database();
?>


<?php 
if(!permission_check('truck_load_for_delivery')){
  ?>
  <script>
    window.location.href = '403.php';
  </!-->
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


            <div class="form-group" style="display:none">
              <label class="col-md-3 control-label" for="inputDefault">Area </label>
              <div class="col-md-6">
              <select name="area_employee" id="area_employee"   class="form-control area_employee ">

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

          
          ?>
            <option value="">Select Zone First</option>
          <?php
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
                    <th style="text-align: center;">Available (Pack)</th>
                    <th style="text-align: center;">Available (PCS)</th>
                 
	                  <th style="text-align: center;">Quantity (Packet)</th>
                    <th style="text-align: center;">Quantity (Pcs)</th>
	                 
	                </tr>
	              </thead>
	              <tbody id="invoice_details">  
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
                            <input type="text" class="form-control main_available_pcs available_pcs" name="available_pcs[]" readonly="" value="">
                          </td>
                          <td style="display:none">
                            <input type="hidden" class="form-control main_all_in_pcs all_in_pcs" name="all_in_pcs[]" readonly="" value="">
                          </td>
                          <td style="display:none">
                            <input type="hidden" class="form-control main_pack_size pack_size" name="pack_size[]" readonly="" value="">
                          </td>
                          <td>
                            <input type="number" min="0" step="1" class="form-control main_quantity quantity" name="quantity[]"  value="">
                          </td>
                           <td>
                            <input type="number" min="0" step="1" class="form-control main_quantity_pcs quantity_pcs" name="quantity_pcs[]"  value="">
                          </td>
                          <td  style="display:none">
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
        url:'ajax_get_ware_house.php',
        data:{zone_serial_no:zone_serial_no},
        type:'POST',
        dataType:'json',
        success:function(data){
          // $("#area_employee").html(data.area_options);
          $("#ware_house_serial_no").html(data);
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
    var quantity_pack = $(this).val();
    if (quantity_pack == '' || isNaN(quantity_pack)) {
      quantity_pack = 0;
    }
    var tr = $(this).parent().parent();
    var product_id = tr.find(".product_id").val();
    var ware_house_serial_no  = $("#ware_house_serial_no").val();
    var all_in_pcs  = tr.find(".all_in_pcs").val();
    if (all_in_pcs == '' || isNaN(all_in_pcs)) {
      all_in_pcs = 0;
    }
    var pack_size  = tr.find(".pack_size").val();
    if (pack_size == '' || isNaN(pack_size)) {
      pack_size = 0;
    }
    var quantity_pcs  = tr.find(".quantity_pcs").val();
    if (quantity_pcs == '' || isNaN(quantity_pcs)) {
      quantity_pcs = 0;
    }
    
    var available_packet  = tr.find(".available").val();
    var available_pcs  = tr.find(".available_pcs").val();


     if (ware_house_serial_no == "") {
        
       $(".available").val("");
       $(".available_pcs").val("");
       $(".all_in_pcs").val("");
       $(".pack_size").val("");
       $(".quantity").val("");
       $(".quantity_pcs").val("");
       $(".quantity_offer").val("");

     }else{

       var provided_pcs = quantity_pack*pack_size + quantity_pcs*1;
      console.log(provided_pcs);
      
        if ( parseInt(all_in_pcs) < parseInt(provided_pcs)) {
             swal({
                title: 'warning',
                text: 'The Quantity Is Out Of Stock. ',
                icon: 'warning',
                button: "Done",
              });
             tr.find(".quantity").val("");
             tr.find(".quantity_offer").val("");
             tr.find(".quantity_pcs").val("");
        }
   }
  });
 
  // validating for product qty in pcs
  $(document).on('change keyup blur','.quantity_pcs',function(){
    var quantity_pcs = $(this).val();
    if (quantity_pcs == '' || isNaN(quantity_pcs)) {
      quantity_pcs = 0;
    }
    var tr = $(this).parent().parent();
    var product_id = tr.find(".product_id").val();
    var ware_house_serial_no  = $("#ware_house_serial_no").val();
    var all_in_pcs  = tr.find(".all_in_pcs").val();
    if (all_in_pcs == '' || isNaN(all_in_pcs)) {
      all_in_pcs = 0;
    }
    var pack_size  = tr.find(".pack_size").val();
    if (pack_size == '' || isNaN(pack_size)) {
      pack_size = 0;
    }
    var quantity_pack  = tr.find(".quantity").val();
    if (quantity_pack == '' || isNaN(quantity_pack)) {
      quantity_pack = 0;
    }
    
    var available_packet  = tr.find(".available").val();
    if (available_packet == '' || isNaN(available_packet)) {
      available_packet = 0;
    }
    var available_pcs  = tr.find(".available_pcs").val();
     if (available_pcs == '' || isNaN(available_pcs)) {
      available_pcs = 0;
    }


     if (ware_house_serial_no == "") {
        
       $(".available").val("");
       $(".available_pcs").val("");
       $(".all_in_pcs").val("");
       $(".pack_size").val("");
       $(".quantity").val("");
       $(".quantity_pcs").val("");
       $(".quantity_offer").val("");

     }else{

       var provided_pcs = quantity_pack*pack_size + quantity_pcs*1;

       console.log(provided_pcs);
       
  
        if ( parseInt(all_in_pcs) < parseInt(provided_pcs)) {
             swal({
                title: 'warning',
                text: 'The Quantity Is Out Of Stock. Available QTY = ',
                icon: 'warning',
                button: "Done",
              });
             tr.find(".quantity").val("");
             tr.find(".quantity_offer").val("");
             tr.find(".quantity_pcs").val("");
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
       $(".pack_size").val("");

     }else{
  
       $.ajax({
          url:'ajax_truck_load.php',
          data:{ware_serial:ware_house_serial_no,prod_id:product_id},
          type:'POST',
          dataType:'json',
          success:function(data){
           var total_pcs = data.available_qty;
           var pack_size = data.pack_size;
           var available_packet = Math.floor(total_pcs/pack_size);
           var available_pcs = total_pcs%pack_size ;

           tr.find(".available").val(available_packet);
           tr.find(".available_pcs").val(available_pcs);
           tr.find(".all_in_pcs").val(data.available_qty);
           tr.find(".pack_size").val(data.pack_size);
          }
        });
   } // end of else
  });

 // here we are going to get products available quantity  
  $(document).on('click','.quantity_pcs',function(){
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
       $(".pack_size").val("");

     }else{
  
       $.ajax({
          url:'ajax_truck_load.php',
          data:{ware_serial:ware_house_serial_no,prod_id:product_id},
          type:'POST',
          dataType:'json',
          success:function(data){
              var total_pcs = data.available_qty;
              var pack_size = data.pack_size;
              var available_packet = Math.floor(total_pcs/pack_size);
              var available_pcs = total_pcs%pack_size ;

              tr.find(".available").val(available_packet);
              tr.find(".available_pcs").val(available_pcs);
              tr.find(".all_in_pcs").val(data.available_qty);
              tr.find(".pack_size").val(data.pack_size);
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