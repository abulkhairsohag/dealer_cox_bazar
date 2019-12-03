<?php include_once 'include/header.php';?>

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
               <a href="truck_load.php" class="btn btn-primary" > <span class="badge"></span> Print Summery</a>
             <?php }?>
             <?php
             if (permission_check('new_order')) {
               ?>
               <a href="order_list.php" class="btn btn-success" > <span class="badge"></span> Order List</a>
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

          <div class="col-md-12" style="margin-bottom: 30px;width: 100%" align="center" >
           <table style="width: 100%">


            <thead>
              <tr>
                <th style="text-align: center;padding-bottom: 10px; color: red">Employee ID</th>
                <th style="text-align: center;padding-bottom: 10px; color: red">Employee Name</th>
                <th style="text-align: center;padding-bottom: 10px; color: red">Area</th>
                <!-- <th style="text-align: center;padding-bottom: 10px; color: red">Company</th> -->
                <th style="text-align: center;padding-bottom: 10px; color: red">Date</th>
              </tr>
            </thead>

            <tbody>
              <?php
              include_once "class/Database.php";
              $dbOb = new Database();
              $employee_name = Session::get("name");
              $user_name = Session::get("username");
              $password = Session::get("password");

              $query = "SELECT * FROM employee_main_info where name = '$employee_name' and user_name = '$user_name' and password = '$password' ";
              $get_employee_iformation = '';
              $get_employee = $dbOb->select($query);
              if ($get_employee) {
               $get_employee_iformation = $get_employee->fetch_assoc();
               $get_employee_id = $get_employee_iformation['id_no'];

               $query = "SELECT * from employee_duty where id_no = '$get_employee_id' AND active_status = 'Active'";
               $get_duty_employee = $dbOb->find($query);
               $duty_employee_area = $get_duty_employee['area'];

	// $company = $get_duty_employee['company'];

               ?>
               <tr>
                <td>
                  <input type="text" class="form-control employee_id" id="employee_id" name="employee_id" readonly="" value="<?php echo ($get_duty_employee['id_no']) ?>" >
                </td>
                <td>
                  <input type="text" class="form-control employee_name" id="employee_name" name="employee_name" readonly="" value="<?php echo $employee_name ?>" >
                </td>
                <td>
                  <select name="area_employee" id="area_employee"  required="" class="form-control area_employee" >
                    <option value="">Please Select</option>
                    <?php

                    $query = "SELECT * FROM area ORDER BY area_name";
                    $get_area = $dbOb->select($query);
                    if ($get_area) {
                      while ($row = $get_area->fetch_assoc()) {
                       ?>
                       <option value="<?php echo $row['area_name']; ?>"><?php echo $row['area_name']; ?></option>
                       <?php
                     }
                   }

                   ?>

                 </select>
               </td>
               <!--  <td>
                  <input type="text" class="form-control" id="employee_company" name="employee_company" readonly="" value="<?php //echo $company ?>" >
                </td> -->
                <td>
                  <input type="text" class="form-control datepicker" id="date" name="date" readonly="" value="" required="">
                </td>
              </tr>
            <?php } else {
	// this else section is for admin. if admin wants to take a order then he will work in this section
             ?>
             <tr>
              <td>

               <input type="text" name="employee_id" id="employee_id" class="form-control employee_id" readonly="" required>
             </td>
             <td>
              <input type="text" class="form-control employee_name" id="employee_name" name="employee_name" readonly="" value="" >
            </td>
            <td>
              <select name="area_employee" id="area_employee"  required="" class="form-control area_employee">
                <option value="">Please Select</option>
                <?php

                $query = "SELECT * FROM area ORDER BY area_name";
                $get_area = $dbOb->select($query);
                if ($get_area) {
                  while ($row = $get_area->fetch_assoc()) {
                   ?>
                   <option value="<?php echo $row['area_name']; ?>"><?php echo $row['area_name']; ?></option>
                   <?php
                 }
               }

               ?>

             </select>
           </td>
               <!--  <td>
                  <input type="text" class="form-control" id="employee_company" name="employee_company" readonly="" value="<?php //echo $company ?>" >
                </td> -->
                <td>
                  <input type="text" class="form-control datepicker" id="date" name="date" readonly="" value="" required="">
                </td>
              </tr>

              <?php

            }?>
          </tbody>
        </table>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-6 control-label" for="inputDefault">Order Number</label>
        <div class="col-md-6 col-6">
         <!-- <select class="form-control" id="invoice_option" name="invoice_option" required=""> -->
           <?php
           $query = "SELECT * FROM new_order_details ORDER BY serial_no DESC LIMIT 1";
           $get_order = $dbOb->select($query);
           if ($get_order) {
            $today = date("Ymd");
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
          } 
          ?>
          <input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo $order_new_id; ?>">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-6 control-label" for="inputDefault">Select Customer<span class="required" style="color: red">*</span></label>
        <div class="col-md-6 col-6">
          <select class="form-control" id="cust_id" name="cust_id" required="">
            <option value="">Select Area First</option>

            <?php
            $query = "SELECT * FROM client WHERE area_name = '$duty_employee_area'";
            $get_client = $dbOb->select($query);
            if ($get_client) {
             while ($row = $get_client->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['cust_id'] ?>"><?php echo $row['client_name'] ?></option>
              <?php
            }
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-6 control-label" for="inputDefault">Customer Name <span class="required" style="color: red">*</span></label>
      <div class="col-md-6 col-6">
        <input type="text" class="form-control" id="customer_name" name="customer_name" readonly>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-6 control-label" for="inputDefault">Shop Name <span class="required" style="color: red">*</span></label>
      <div class="col-md-6 col-6">
        <input type="text" class="form-control" id="shop_name" name="shop_name" readonly>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-6 control-label" for="inputDefault">Address <span class="required" style="color: red">*</span></label>
      <div class="col-md-6 col-6">
        <input type="text" class="form-control" id="address" name="address" readonly>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Mobile Number <span class="required" style="color: red">*</span></label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="mobile_no" name="mobile_no" readonly>
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
          <th style="text-align: center;">Unit TP</th>
          <th style="text-align: center;">Unit VAT</th>
          <!-- <th style="text-align: center;">TP + VAT</th> -->
          <th style="text-align: center;">QTY</th>
          <th style="text-align: center;">Total TP</th>
          <th style="text-align: center;">Total Price</th>
          <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
        </tr>
      </thead>
      <tbody id="invoice_details">

        <tr>
          <td>
            <select name="products_id_no[]" class="form-control main_product_id" id="products_id_no" name="products_id_no[]"  required>
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
        <td style="display:none"><input type="text" class="form-control main_pack_size pack_size" name="pack_size[]" readonly="" ></td>
        <td><input type="text"  class="form-control main_unit_tp unit_tp" id="unit_tp" name="unit_tp[]" readonly="" ></td>
        <td><input type="text"   class="form-control main_unit_vat unit_vat" id="unit_vat" name="unit_vat[]" readonly=""></td>
        <td style="display:none"><input type="text"   class="form-control main_tp_plus_vat tp_plus_vat" id="tp_plus_vat" name="tp_plus_vat[]" readonly=""></td>
        <td><input type="text"  class="form-control main_qty" id="qty" name="qty[]" value="0"></td>
        <td><input type="text" class="form-control main_total_tp total_tp" id="total_tp" name="total_tp[]" readonly=""></td>
        <td style="display:none"><input type="text" class="form-control main_total_vat total_vat" id="total_vat" name="total_vat[]" readonly=""></td>
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
    <label class="col-md-3 control-label" for="inputDefault">Net Total Price (৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_total" name="net_total" value="0" readonly="">
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Net Total TP (৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_total_tp" name="net_total_tp" value="0" readonly="">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Total Vat Amount (৳)</label>
    <div class="col-md-6">
      <input type="text"  class="form-control" id="net_total_vat" name="net_total_vat" value="0" readonly="">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Discount On TP (%)</label>
    <div class="col-md-6">
      <input type="text"   class="form-control" id="discount" name="discount" value="<?php echo $invoice_setting['discount_on_tp'] ?>" readonly="" placeholder="0">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Discount Amount (৳)</label>
    <div class="col-md-6">
      <input type="text"  class="form-control" id="discount_amount" name="discount_amount" value="0" readonly="">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Payable Amount(৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="payable_amt" name="payable_amt" readonly="" value="0">
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="extra_discount">Extra Discount(%)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="extra_discount" name="extra_discount" readonly="" value="<?php echo $invoice_setting['special_discount'] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="net_payable_amt">Net Payable Amount(৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_payable_amt" name="net_payable_amt" readonly="" value="0">
    </div>
  </div>

  <div class="form-group" style="display:none">
    <label class="col-md-3 control-label" for="vat">vat(%)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="vat" name="vat" readonly="" value="<?php echo $invoice_setting['vat'] ?>">
    </div>
  </div>
  <div class="form-group" style="display:none">
    <label class="col-md-3 control-label" for="discount_on_mrp">discount on MRP (%)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="discount_on_mrp" name="discount_on_mrp" readonly="" value="<?php echo $invoice_setting['discount_on_mrp'] ?>">
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
      $('#invoice_details').append('<tr><td><select  required name="products_id_no[]" class="form-control main_product_id secondary_product_id" id="products_id_no" name="products_id_no[]"><option value=""></option><?php
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
      ?></select></td><td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td><td  style="display:none"><input type="text" class="form-control main_pack_size pack_size" name="pack_size[]" readonly="" ></td><td><input type="text"  class="form-control main_unit_tp unit_tp" id="unit_tp" name="unit_tp[]" readonly="" ></td><td><input type="text"   class="form-control main_unit_vat unit_vat" id="unit_vat" name="unit_vat[]" readonly=""></td><td style="display:none"><input type="text"   class="form-control main_tp_plus_vat tp_plus_vat" id="tp_plus_vat" name="tp_plus_vat[]" readonly="" ></td><td><input type="text"  class="form-control main_qty" id="qty" name="qty[]" value="0"></td><td "><input type="text" class="form-control main_total_tp total_tp" id="total_tp" name="total_tp[]" readonly=""></td><td  style="display:none"><input type="text" class="form-control main_total_vat total_vat" id="total_vat" name="total_vat[]" readonly=""></td><td><input type="text" class="form-control main_total_price  total_price" id="total_price" name="total_price[]" readonly=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
    });

    $(document).on('click','.remove_button', function(e) {
      var remove_row = $(this).closest("tr");
      remove_row.remove();
      cal();
    });

    $(document).on('change','.main_product_id', function() {
      var tr=$(this).parent().parent();
      var products_id_no_get_info =tr.find("#products_id_no").val();
      var qty = tr.find("#qty").val();
      if (isNaN(qty) || qty == '') {
        qty = 0;
      }

      var discount_on_mrp = $("#discount_on_mrp").val();
      var vat = $("#vat").val();

      // console.log(tr);
      // tr.find(".main_category").val(products_id_no);
      // console.log(qty);
      $.ajax({
        url:"ajax_new_order.php",
        data:{products_id_no_get_info:products_id_no_get_info},
        type:"post",
        dataType:'json',
        success:function(data){
          tr.find(".products_name").val(data.products.products_name);
          tr.find(".pack_size").val(data.products.pack_size);
          var mrp_price = data.products.mrp_price;
          var unit_tp = mrp_price - mrp_price*(discount_on_mrp/100);
          tr.find(".unit_tp").val(unit_tp);

          var unit_vat = (unit_tp*vat/100);
          tr.find(".unit_vat").val(unit_vat);

          var tp_plus_vat = (unit_vat + unit_tp);
          tr.find(".tp_plus_vat").val(tp_plus_vat);
          // console.log(qty);
          var total_tp = (tr.find(".unit_tp").val() * qty) ;
          var total_vat = (tr.find(".unit_vat").val() * qty) ;
          var total_price = (tr.find(".tp_plus_vat").val() * qty) ;

          tr.find(".total_tp").val(total_tp);
          tr.find(".total_vat").val(total_vat);
          tr.find(".total_price").val(total_price );
          cal();
        }
      });

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
$("#invoice_details").delegate('#qty','keyup blur',function(){
  var tr=$(this).parent().parent();

  var quantity =tr.find("#qty").val();


  if (isNaN(quantity) || quantity == '') {
    quantity = 0;
  }

  var total_tp = (tr.find(".unit_tp").val() * quantity) ;
  var total_vat =  (tr.find(".unit_vat").val() * quantity) ;
  var total_price =  (tr.find(".tp_plus_vat").val() * quantity) ;


  tr.find(".total_tp").val(total_tp);
  tr.find(".total_vat").val(total_vat);
  tr.find(".total_price").val(total_price);
  cal();
});



// the following function is for invoice claculation
function cal()
{
  var net_total =0;

  $(".total_price").each(function(){
    net_total=(net_total+($(this).val()*1));

  });
  $("#net_total").val(net_total);

  var net_total_tp = 0 ;
  $(".total_tp").each(function(){
    net_total_tp=net_total_tp+($(this).val()*1);
  });
  net_total_tp = (net_total_tp);

  $("#net_total_tp").val(net_total_tp);

  var net_total_vat = 0 ;
  $(".total_vat").each(function(){
    net_total_vat=(net_total_vat+($(this).val()*1));
  });
  $("#net_total_vat").val(net_total_vat);

    // var vat = $("#vat").val();
    var discount = $("#discount").val();


    if(discount>0 && discount <= 100){
        // var net_total_tp = $("#net_total_tp").val();
        // var net_total = $("#net_total").val();

        var discount_amount =  (net_total_tp*$("#discount").val()/100);

        $("#discount_amount").val(discount_amount);

        var payable_amt =((parseFloat(net_total)  - parseFloat(discount_amount)));



        $("#payable_amt").val(payable_amt);

        var extra_discount = $('#extra_discount').val();
        if (isNaN(extra_discount) || extra_discount == '') {
          extra_discount = 0;
        }

        var net_payable_amt = Math.round(payable_amt - payable_amt*extra_discount/100) ;
        $('#net_payable_amt').val(net_payable_amt);

      }else{ // if  discount  is not found then net total will be the grand total
        $("#payable_amt").val(net_total);
        var extra_discount = $('#extra_discount').val();
        if (isNaN(extra_discount) || extra_discount == '') {
          extra_discount = 0;
        }
        // $.round = Math.round;

        var net_payable_amt = Math.round(payable_amt - (payable_amt*extra_discount/100)) ;
        $('#net_payable_amt').val(net_payable_amt);

      }

    }



// discount calculation
$(document).on('keyup blur','#discount',function(){
  var discount = $(this).val();
  if (discount>100) {
    alert("You Cannot Provide A Discount More Than 100%");
    $(this).val(0)
  }else{

    var net_total_tp = $("#net_total_tp").val();
    var net_total = $("#net_total").val();

    var discount_amount =  (net_total_tp*$("#discount").val()/100);

    $("#discount_amount").val(discount_amount);

    var payable_amt =  (parseFloat(net_total)  - parseFloat(discount_amount)) ;

    $("#payable_amt").val(payable_amt);

    var extra_discount = $('#extra_discount').val();
    if (isNaN(extra_discount) || extra_discount == '') {
      extra_discount = 0;
    }

    var net_payable_amt = Math.round(payable_amt - payable_amt*extra_discount/100) ;
    $('#net_payable_amt').val(net_payable_amt);


  }

});

$(document).on('change','#cust_id',function(){
  var cust_id = $(this).val();
  // alert(cust_id);
  $.ajax({
    url:'ajax_new_order.php',
    data:{customer_id:cust_id},
    type:'POST',
    dataType:'json',
    success:function(data){
      if (data.sales_man_id) {
        $("#customer_name").val(data.client_name);
        $("#shop_name").val(data.organization_name);
        $('#address').val(data.address);
        $("#mobile_no").val(data.mobile_no);
        $(".employee_id").val(data.sales_man_id);
        $(".employee_name").val(data.sales_man_name);
      }else{
        swal({
          title: 'warning',
          text: 'Sales Man Not Assigned In "'+$('.area_employee').val()+'" area. Please Assign A Sales Man.',
          icon: 'warning',
          button: "Done",
        });

      }
      
    }
  });
});

$(document).on('change','.area_employee',function(){
  $("#customer_name").val("");
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
$(document).on('change','#employee_id',function(){
 var emp_id = $(this).val();
 $.ajax({
  url:'ajax_new_order.php',
  data:{emp_id:emp_id},
  type:'POST',
  dataType:'json',
  success:function(data){
    $(".employee_name").val(data);
    $(".employee_id").val(emp_id);
  }
});
});


  }); // end of document ready function

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>

</body>
</html>