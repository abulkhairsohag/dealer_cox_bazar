<?php 

include_once 'include/header.php';
include_once "class/Session.php";
Session::init();
Session::checkSession();
?>

<?php
if (!permission_check('new_order')) {
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
          <div class="row">
            <div class="col-md-6 text-left">
              <h2>Add New Order</h2>
            </div>
            <div class="col-md-6 float-right" align="right">
              <?php
              if (permission_check('truck_load_for_delivery')) {
               ?>
               <a href="truck_load.php" class="btn btn-primary" > <span class="badge"></span> Load Truck</a>
             <?php }?>
             <?php
             if (permission_check('new_order')) {
               ?>
               <a href="truck_unload.php" class="btn btn-success" > <span class="badge"></span> Unload Truck</a>
             <?php }?>
           </div>

         </div>

         <div class="clearfix"></div>
       </div>
       <div class="x_content">

        <!-- form starts form here -->
        <form class="form-horizontal form-bordered" id="add_data_form"  data-parsley-validate action="" method="post">


          <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

            <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
              Employee And Shop Information
            </div>
          </div>

          
          <!-- delivery man info -->
          <div class="col-md-12" style="margin-bottom: 30px;width: 100%" align="center" >
           <table style="width: 100%">


            <thead>
              <tr>
                <th style="text-align: center;padding-bottom: 10px; color: red">Sales Man's ID</th>
                <th style="text-align: center;padding-bottom: 10px; color: red">Name</th>
                <th style="text-align: center;padding-bottom: 10px; color: red">Delivery Man's ID</th>
                <th style="text-align: center;padding-bottom: 10px; color: red">Name</th>
              </tr>
            </thead>

            <tbody>

             <tr>
              <td>
                <select name="order_employee_id" id="order_employee_id"  required="" class="form-control order_employee_id ">
                  <option value="">Please Select</option>
                  <?php

                  $query = "SELECT * FROM employee_duty WHERE active_status = 'Active' ORDER BY id_no";
                  $get_sales_man = $dbOb->select($query);
                  if ($get_sales_man) {
                    while ($row = $get_sales_man->fetch_assoc()) {
                     ?>
                     <option value="<?php echo $row['id_no']; ?>" <?php if (Session::get("order_emp_id") == $row['id_no']) {
                      echo "selected";
                    } ?>><?php echo $row['id_no'].', '.$row['name']; ?></option>
                    <?php
                  }
                }

                ?>

              </select>
            </td>
            <td>
              <input type="text" class="form-control order_employee_name" id="order_employee_name" name="order_employee_name" readonly="" value="<?php if (Session::get("order_employee_name")) {
                echo Session::get("order_employee_name");
              } ?>" >
            </td>
            <td>
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
          </td> 
          <td>
           <input type="text" class="form-control delivery_employee_name" required="" id="delivery_employee_name" name="delivery_employee_name" readonly="" value="<?php if (Session::get("delivery_employee_name")) {
            echo Session::get("delivery_employee_name");
          } ?>" >
        </td>

      </tr>


    </tbody>
  </table>
</div>

<div class="form-group row" style="display:none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Order Number</label>
  <div class="col-md-6 col-6">
   <!-- <select class="form-control" id="invoice_option" name="invoice_option" required=""> -->
     <?php
     $query = "SELECT * FROM order_delivery ORDER BY serial_no DESC LIMIT 1";
     $get_order = $dbOb->select($query);
     $today = date("Ymd");
     if ($get_order) {
      $last_id = $get_order->fetch_assoc()['order_no'];
      $exploded_id = explode('-', $last_id);
      $exploded_id = str_split($exploded_id[1],8);

      if ($exploded_id[0] == $today) {
        $last_id = $exploded_id[1] * 1 + 1;
        $id_length = strlen($last_id);
        $remaining_length = 4 - $id_length;
        $zeros = "";

        if ($remaining_length > 0) {
          for ($i = 0; $i < $remaining_length; $i++) {
            $zeros = $zeros . '0';
          }
          $order_new_id = 'INV-'.$exploded_id[0] . $zeros . $last_id;
        }
      }else {
        $order_new_id = 'INV-'.$today."0001";
      }
    } else {
      $order_new_id = 'INV-'.$today."0001";
    }
    ?>
    <input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo $order_new_id; ?>">
  </div>
</div>


<div class="form-group row" style="display:none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Vehicle Reg. No<span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <input type="text"  name="vehicle_reg_no" id="vehicle_reg_no"  required="" class="form-control vehicle_reg_no " readonly="">
  </div>
</div>

<div class="form-group row" style="display:none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Vehicle Name<span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <input type="text"  name="vehicle_name" id="vehicle_name"  required="" class="form-control vehicle_name " readonly="">
  </div>
</div>

<div class="form-group row"  style="display:none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Truck Load Serial No<span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <input type="text"  name="truck_load_serial_no" id="truck_load_serial_no"  required="" class="form-control truck_load_serial_no " readonly="">
  </div>
</div>


<div class="form-group row"  style="display:none" style="display:none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Select Ware House<span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
  <input type="text"  name="ware_house_serial_no" id="ware_house_serial_no"  required="" class="form-control ware_house_serial_no " readonly="">
       
  </div>
</div>

<div class="form-group" style="display:none">
  <label class="col-md-3 control-label" for="inputDefault">Zone <span class="required" style="color: red">*</span></label>
  <div class="col-md-6">
  <input type="text"  name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no " readonly="">

   

  </div>
</div>

<div class="form-group" >
  <label class="col-md-3 control-label" for="inputDefault">Area <span class="required" style="color: red">*</span></label>
  <div class="col-md-6">
   <select name="area_employee" id="area_employee"  required="" class="form-control area_employee ">

    
      <option value="">Please Select Correct Delivery Man ...</option>
   

    </select>
  </div>
</div>






<div class="form-group row">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Select Customer<span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <select class="form-control" id="cust_id" name="cust_id" required="">

      <option value="">Select Area First</option>
    
    </select>
  </div>
</div>

<div class="form-group row" style="display: none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Customer Name <span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <input type="text" class="form-control" id="customer_name" name="customer_name" readonly>
  </div>
</div>

<div class="form-group row" style="display:none">
  <label class="col-md-3 col-6 control-label" for="inputDefault" >Shop Name <span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <input type="text" class="form-control" id="shop_name" name="shop_name" readonly>
  </div>
</div>

<div class="form-group row" style="display: none">
  <label class="col-md-3 col-6 control-label" for="inputDefault">Address <span class="required" style="color: red">*</span></label>
  <div class="col-md-6 col-6">
    <input type="text" class="form-control" id="address" name="address" readonly>
  </div>
</div>

<div class="form-group" style="display: none">
  <label class="col-md-3 control-label" for="inputDefault">Mobile Number <span class="required" style="color: red">*</span></label>
  <div class="col-md-6">
    <input type="text" class="form-control" id="mobile_no" name="mobile_no" readonly>
  </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Date<span class="required" style="color: red">*</span></label>
  <div class="col-md-6">
    <input type="text" class="form-control datepicker" id="date" name="date" readonly="" value="" required="">  
  </div>
</div>



<div class="form-group bg-success" style="padding-bottom: 5px;margin-top: 30px">

  <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
    Add Order Details
  </div>
</div>

<table class="table" class="">

  <thead>
    <tr>
      <th style="text-align: center;">Product ID</th>
      <th style="text-align: center;">Name</th>
      <th style="text-align: center;">Price</th>
      <th style="text-align: center;">QTY</th>
      <th style="text-align: center;">Offer QTY</th>
      <th style="text-align: center;">Total Price</th>
      <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
    </tr>
  </thead>
  <tbody id="invoice_details">

    <tr>
      <td>
        <select name="products_id_no[]" class="form-control main_product_id product_id" id="products_id_no" name="products_id_no[]"  required>
          <option value=""></option>
          <?php
          include_once 'class/Database.php';
          $dbOb = new Database();
          $query = "SELECT * FROM products";
          $get_products = $dbOb->select($query);
          if ($get_products) {
           while ($row = $get_products->fetch_assoc()) {
            ?>
            <option value="<?php echo ($row['products_id_no']) ?>"> <?php echo ($row['products_id_no'] . ', ' . $row['products_name']) ?> </option>

            <?php
          }
        }
        ?>
      </select>
    </td>
    <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td>

    <td><input type="text"  class="form-control main_sell_price sell_price" id="sell_price" name="sell_price[]" readonly="" ></td>
    <td><input type="text"  class="form-control main_qty qty" id="qty" name="qty[]" value="" readonly=""></td>
    <td><input type="text"   class="form-control main_offer_qty offer_qty" id="offer_qty" name="offer_qty[]" readonly=""></td>

    <td><input type="text" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly=""></td>
    <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>

  </tr>

</tbody>

</table>

<?php
$query = "SELECT * FROM invoice_setting";
$get_invoice = $dbOb->select($query);
if ($get_invoice) {
 $invoice_setting = $get_invoice->fetch_assoc();
}
?>
<div class="form-group">
  <h3>
    <label class="col-md-3 control-label" for="inputDefault"  style="text-align: left; color: #34495E"></label></h3>
  </div>


  
  <div class="form-group">
    <label class="col-md-3 control-label" for="net_payable_amt">Net Payable Amount(৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_payable_amt" name="net_payable_amt" readonly="" value="0">
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-md-3 control-label" for="pay">Paid Amount(৳)</label>
    <div class="col-md-6">
      <input type="number" min="0" step="1" class="form-control" id="pay" name="pay">
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-md-3 control-label" for="due">Due Amount(৳)</label>
    <div class="col-md-6">
      <input type="number" min="0" class="form-control" id="due" name="due" readonly="" value="0">
    </div>
  </div>



  <div class="form-group" align="center">
    <input type="submit" name="submit" value="Save" class="btn btn-success" style="">
    <input type="reset" name="reset" value="Reset" class="btn btn-warning">
  </div>

</form>


</div>
</div>
</div>





<!-- /page content -->

</div>
</div>
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){

    $("#add_more").click(function(){
      $('#invoice_details').append('<tr><td><select  required name="products_id_no[]" class="form-control  product_id secondary_product_id" id="products_id_no" name="products_id_no[]"><option value=""></option><?php
        include_once 'class/Database.php';
        $dbOb = new Database();
        $employee_name = Session::get("name");
        $user_name = Session::get("username");
        $password = Session::get("password");

        $query = "SELECT * FROM employee_main_info where name = '$employee_name' and user_name = '$user_name' and password = '$password' ";
        $get_employee_iformation = $dbOb->find($query);
        $get_employee_id = $get_employee_iformation['id_no'];

        $query = "SELECT * from employee_duty where id_no = '$get_employee_id'";
        $get_duty_employee = $dbOb->find($query);
        $duty_employee_area = $get_duty_employee['area'];
        $company = $get_duty_employee['company'];

        $query = "SELECT * FROM products";
        $get_products = $dbOb->select($query);
        if ($get_products) {
         while ($row = $get_products->fetch_assoc()) {
          ?>
          <option value="<?php echo ($row['products_id_no']) ?>"> <?php echo ($row['products_id_no'] . ', ' . $row['products_name']) ?> </option><?php
        }
      }
      ?></select></td><td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td><td><input type="text"  class="form-control main_sell_price sell_price" id="sell_price" name="sell_price[]" readonly="" ></td><td><input type="text"  class="form-control main_qty qty" id="qty" name="qty[]" value="" readonly=""></td><td><input type="text"   class="form-control main_offer_qty offer_qty" id="offer_qty" name="offer_qty[]" readonly=""></td><td><input type="text" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
    });

    $(document).on('click','.remove_button', function(e) {
      var remove_row = $(this).closest("tr");
      remove_row.remove();
      cal();
    });



    $(document).on('change','.product_id', function() {

      var tr=$(this).parent().parent();
      var products_id_no_get_info =tr.find("#products_id_no").val();
      var vehicle_reg_no_get_info = $("#vehicle_reg_no").val();
      var confirm_availability = false;
      var product_all_id = []
      var i = 0;
      $(".product_id").each(function(){
        // console.log($(this).val());

        product_all_id[i] = $(this).val();
        i++;
      });

      product_all_id.pop();
      var j;
      for (j = 0; j < product_all_id.length; ++j) {
        if (products_id_no_get_info == product_all_id[j] && product_all_id[j] != '') {
          confirm_availability = 'sohag';
        }
      }

      if (confirm_availability == 'sohag') {
        swal({
          title: 'warning',
          text: 'This Product Has Already Been Selected. You Can Change The Quantity',
          icon: 'warning',
          button: "Done",
        });
        tr.find("#products_id_no").val('');

      }else{

        var qty = tr.find("#qty").val();
        if (isNaN(qty) || qty == '') {
          qty = 0;
        }
        var discount_on_mrp = $("#discount_on_mrp").val();
        var vat = $("#vat").val();

      $.ajax({
        url:"ajax_new_order.php",
         data:{products_id_no_get_info:products_id_no_get_info,vehicle_reg_no_get_info:vehicle_reg_no_get_info},
        type:"post",
        dataType:'json',
        success:function(data){
          
         
          if (data.type == 'warning') {
               swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
              tr.find(".products_name").val('');
              //////////////////////////////////////
          }

          tr.find(".sell_price").val(data.products.sell_price);
          tr.find(".products_name").val(data.products.products_name);
          var total_price = (data.products.sell_price * qty) ;
          tr.find(".total_price").val(total_price );

          tr.find("#qty").attr("readonly", false);
          tr.find("#qty").attr("placeholder", data.load_qty);
          tr.find("#qty").attr("data-available", data.load_qty);
          tr.find("#qty").focus();

          cal();
        }
      });
    }
      // cal();
    });




    // now we are going to  insert data
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_new_order.php',
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




// invoice calculation
  $("#invoice_details").delegate('#qty','keyup blur change',function(){
    var tr=$(this).parent().parent();

    var quantity =tr.find("#qty").val();
    var available =tr.find("#qty").data('available');
    // alert(available);

    if (quantity > available) {
       swal({
              title: 'warning',
              text: 'The Quantity You Have Entered Is Not Available In The Truck',
              icon: 'warning',
              button: "Done",
            });
         tr.find("#qty").val('');
         return 0;
      }

     if (isNaN(quantity) || quantity == '') {
        quantity = 0;
      }
      var sell_price = tr.find(".sell_price").val();

      if (isNaN(sell_price) || sell_price == '') {
        sell_price = 0;
      }
      var total_price =  ( sell_price * quantity) ;
      tr.find(".total_price").val(total_price);

      var product_id = tr.find(".product_id").val();
       $.ajax({
        url:'ajax_truck_load.php',
        data:{product_id_check:product_id},
        type:'POST',
        dataType:'json',
        success:function(data){
         if (data == 'N/A') {
           tr.find(".offer_qty").val(data);
         }else{
           var offer_integer = parseInt(quantity / data.packet_qty);
           tr.find(".offer_qty").val(offer_integer * data.product_qty);
         }
         
        }
      });
     
      cal();
  });

  $(document).on('keyup blur change','#pay',function(){
   console.log();
   console.log($("#net_payable_amt").val());
     var pay = parseFloat($(this).val());
     var payable  = parseFloat($("#net_payable_amt").val());
     if (pay > payable) {
        swal({
              title: 'warning',
              text: 'Pay Amount Cannot Be Greater Than The Payable Amt',
              icon: 'warning',
              button: "Done",
            });
        $(this).val(0);
        $("#due").val(payable);
     }
      cal();
  });



  // the following function is for invoice claculation
  function cal()
  {
        var net_total =0;
        var paid = $("#pay").val();
        if (isNaN(paid) || paid == '' ) {
          paid = 0;
        }

        $(".total_price").each(function(){
          net_total=(net_total+($(this).val()*1));
        });
        $("#net_payable_amt").val(net_total);
        $("#due").val(net_total - paid);


  }



  $(document).on('change','#cust_id',function(){
    var cust_id = $(this).val();
    // alert(cust_id);
    $.ajax({
      url:'ajax_new_order.php',
      data:{customer_id:cust_id},
      type:'POST',
      dataType:'json',
      success:function(data){
          $("#customer_name").val(data.client_name);
          $("#shop_name").val(data.organization_name);
          $('#address').val(data.address);
          $("#mobile_no").val(data.mobile_no);
          $(".employee_id").val(data.sales_man_id);
          $(".employee_name").val(data.sales_man_name);
      }
    });
  });

  $(document).on('change','.area_employee',function(){
    $("#customer_name").val("");
    $("#cust_id").val("");
    $("#shop_name").val("");
    $('#address').val("");
    $("#mobile_no").val("");
    $(".employee_id").val("");
    $(".employee_name").val("");


    var area_name = $(this).val();
    $.ajax({

      url:'ajax_new_order.php',
      data:{area_name:area_name},
      type:'POST',
      dataType:'json',
      success:function(data){
        $("#cust_id").html(data);
      }
    });
  });

  $(document).on('change','#order_employee_id',function(){
     var emp_id = $(this).val();
     $.ajax({
        url:'ajax_new_order.php',
        data:{order_emp_id:emp_id},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#order_employee_name").val(data);
          // $(".employee_id").val(emp_id);
        }
      });
  });

  $(document).on('change','#delivery_employee_id',function(){
     var emp_id = $(this).val();
     $.ajax({
        url:'ajax_new_order.php',
        data:{delivery_emp_id:emp_id},
        type:'POST',
        dataType:'json',
        success:function(data){
          if (data.message) {
              swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
            $("#vehicle_reg_no").val('');
            $("#vehicle_name").val('');
            $("#truck_load_serial_no").val('');
            $("#ware_house_serial_no").val('');
            $("#zone_serial_no").val('');
            $("#area_employee").html('<option value=""> Please Select Correct Delivery Man</option>');
            $("#cust_id").html('<option value=""> Please Select Area First...</option>');
            $('.product_id').val('');
            $('.products_name').val('');
            $('.sell_price').val('');
            $('.qty').val('');
            $('.qty').attr('readonly', true);
            $('.offer_qty').val('');
            $('.total_price').val('0');
            $('#net_payable_amt').val('0');
            $('#pay').val('0');
            $('#due').val('0');
          }
          $("#delivery_employee_name").val(data.delivery_emp_name);
          $("#vehicle_reg_no").val(data.vehicle.vehicle_reg_no);
          $("#vehicle_name").val(data.vehicle.vehicle_name);
          $("#truck_load_serial_no").val(data.vehicle.serial_no);
          $("#ware_house_serial_no").val(data.vehicle.ware_house_serial_no);
          $("#zone_serial_no").val(data.vehicle.zone_serial_no);
          

            $("#area_employee").html(data.area);
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


     $.ajax({
        url:'ajax_new_order.php',
        data:{send_area_and_customer:'send_area_and_customer'},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#area_employee").html(data.area);
          $("#vehicle_reg_no").val(data.vehicle.vehicle_reg_no);
          //  alert(data.vehicle);
          $("#vehicle_name").val(data.vehicle.vehicle_name);
          $("#truck_load_serial_no").val(data.vehicle.serial_no);
          $("#ware_house_serial_no").val(data.vehicle.ware_house_serial_no);
          $("#zone_serial_no").val(data.vehicle.zone_serial_no);
        }
      });
  

}); // end of document ready function

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
// $("#area_employee").select2({ width: '100%' }); 
$("#area").select2({ width: '100%' }); 
</script>

</body>
</html>