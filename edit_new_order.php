<?php include_once 'include/header.php';?>

<?php
if (!permission_check('delivery_pending_edit_button') && !permission_check('new_order')) {
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
          <h2>Update New Order</h2>
          <div class="row float-right" align="right">

          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <!-- form starts form here -->
          <form class="form-horizontal form-bordered" id="add_data_form" action="" method="post">


            <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                Order Employee And Shop Information
              </div>
            </div>

            <div class="col-md-12" style="margin-bottom: 30px;width: 100%" align="center" >
             <table style="width: 100%">


              <thead>
                <tr>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Employee ID</th>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Employee Name</th>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Area</th>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Order Date</th>
                </tr>
              </thead>

              <tbody>
                <?php
                include_once "class/Database.php";
                $dbOb = new Database();
                $serial_no = '';
                $get_order_details = "";
                $get_order_expense = "";

                if (isset($_GET['serial_no'])) {

                 $serial_no = $_GET['serial_no'];
                 $query_order_details = "SELECT * FROM new_order_details WHERE serial_no = '$serial_no'";
                 $query_order_expense = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$serial_no'";

                 $get_order_details = $dbOb->find($query_order_details);
                 $get_order_expense = $dbOb->select($query_order_expense);
               }

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

                 ?>
                 <tr>
                  <td>
                    <input type="text" class="form-control employee_id" id="employee_id" name="employee_id" readonly="" value="<?php echo ($get_order_details['employee_id']) ?>" >

                  </td>
                  <td>
                    <input type="text" class="form-control employee_name" id="employee_name" name="employee_name" readonly="" value="<?php echo $get_order_details['employee_name'] ?>" >
                  </td>
                    <td>
                <!-- <input type="text" class="form-control" id="area_employee" name="area_employee" readonly="" value="<?php echo $get_order_details['area_employee'] ?>" > -->
                <select class="form-control area_employee" id="area_employee" name="area_employee">
                   <?php
                    $query = "SELECT * from area  ORDER BY area_name";
                    $get_area = $dbOb->select($query);
                    if ($get_area) {
                      while ($row = $get_area->fetch_assoc()) {
                       ?>
                       <option value="<?php echo $row['area_name'] ?>" <?php
                       if ($row['area_name'] == $get_order_details['area_employee']) {
                        echo 'selected';
                      }
                      ?> ><?php echo $row['area_name'] ; ?></option>

                      <?php
                    }
                  }

                  ?>
                </select>
              </td>

                  <td>
                    <input type="text" class="form-control datepicker" id="date" name="date" readonly="" value="<?php echo $get_order_details['order_date'] ?>">
                  </td>
                </tr>

                <?php
// $company = $get_duty_employee['company'];
              } else {

               ?>
               <tr>
                <td>
                  <select class="form-control employee_id" id="employee_id" name="employee_id">
                    <?php
                    $query = "SELECT * from employee_duty where  active_status = 'Active' ORDER BY name";
                    $get_emp = $dbOb->select($query);
                    if ($get_emp) {
                      while ($row = $get_emp->fetch_assoc()) {
                       ?>
                       <option value="<?php echo $row['id_no'] ?>" <?php
                       if ($row['id_no'] == $get_order_details['employee_id']) {
                        echo 'selected';
                      }
                      ?> ><?php echo $row['id_no'] . ',' . $row['name'] ?></option>

                      <?php
                    }
                  }

                  ?>
                </select>
              </td>
              <td>
                <input type="text" class="form-control employee_name" id="employee_name" name="employee_name" readonly="" value="<?php echo $get_order_details['employee_name'] ?>" >
              </td>
              <td>
               
                <select class="form-control area_employee" id="area_employee" name="area_employee">
                   <?php
                    $query = "SELECT * from area  ORDER BY area_name";
                    $get_area = $dbOb->select($query);
                    if ($get_area) {
                      while ($row = $get_area->fetch_assoc()) {
                       ?>
                       <option value="<?php echo $row['area_name'] ?>" <?php
                       if ($row['area_name'] == $get_order_details['area_employee']) {
                        echo 'selected';
                      }
                      ?> ><?php echo $row['area_name'] ; ?></option>

                      <?php
                    }
                  }

                  ?>
                </select>
              </td>

              <td>
                <input type="text" class="form-control datepicker" id="date" name="date" readonly="" value="<?php echo $get_order_details['order_date'] ?>">
              </td>
            </tr>

            <?php

          }

          ?>

        </tbody>
      </table>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Order Number</label>
      <div class="col-md-6">
       <!-- <select class="form-control" id="invoice_option" name="invoice_option" required=""> -->
        <input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo ($get_order_details['order_no']) ?>">
      </div>
    </div>

    <!-- the following input is for confirming if the edit operiation is performing by employee or admin  -->

    <?php
    if (Session::get("user_type") == 'employee') {
     ?>
     <input type="hidden" name="employee_confirmation" id="employee_confirmation" value="yes">

     <?php
   }

   ?>

   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Customer ID <span class="required" style="color: red">*</span></label>
    <div class="col-md-6">
   

      <select class="form-control" id="cust_id" name="cust_id">
        
        <?php
                  $area = $get_order_details['area_employee'];
                    $query = "SELECT * from client WHERE area_name = '$area'  ORDER BY organization_name";
                    $get_cust = $dbOb->select($query);
                    if ($get_cust) {
                      while ($row = $get_cust->fetch_assoc()) {
                       ?>
                       <option value="<?php echo $row['cust_id'] ?>" <?php
                       if ($row['cust_id'] == $get_order_details['cust_id']) {
                        echo 'selected';
                      }
                      ?> ><?php echo $row['cust_id'].', '.$row['organization_name'] ; ?></option>

                      <?php
                    }
                  }

                  ?>

      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Customer Name <span class="required" style="color: red">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="customer_name" name="customer_name" required="" value="<?php echo $get_order_details['customer_name'] ?>" readonly>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Shop Name <span class="required" style="color: red">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="shop_name" name="shop_name" required="" value="<?php echo $get_order_details['shop_name'] ?>" readonly>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Address <span class="required" style="color: red">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="address" name="address" required="" value="<?php echo $get_order_details['address'] ?>" readonly>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Mobile Number <span class="required" style="color: red">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="mobile_no" name="mobile_no" required="" value="<?php echo $get_order_details['mobile_no'] ?>" readonly>
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
        <!-- <th style="text-align: center;">Pack Size</th> -->
        <th style="text-align: center;">Unit TP</th>
        <th style="text-align: center;">Unit VAT</th>
        <!-- <th style="text-align: center;">TP + VAT</th> -->
        <th style="text-align: center;">QTY</th>
        <th style="text-align: center;">Total TP</th>
        <!-- <th style="text-align: center;">Total VAT</th> -->
        <th style="text-align: center;">Total Price</th>
        <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
      </tr>
    </thead>
    <tbody id="invoice_details">


      <?php

      if ($get_order_expense) {
       while ($row = $get_order_expense->fetch_assoc()) {

        ?>
        <tr>

          <td><input type="text" name="products_id_no[]" class="form-control main_product_id" id="products_id_no" readonly="" value="<?php echo ($row['products_id_no']) ?>"></td>

          <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""   value="<?php echo ($row['products_name']) ?>"></td>


          <td style="display:none"><input type="text" class="form-control main_pack_size pack_size" name="pack_size[]" readonly=""    value="<?php echo ($row['pack_size']) ?>"></td>

          <td><input type="text" class="form-control main_unit_tp unit_tp" id="unit_tp" name="unit_tp[]" readonly=""    value="<?php echo ($row['unit_tp']) ?>"></td>

          <td><input type="text" class="form-control main_unit_vat unit_vat" id="unit_vat" name="unit_vat[]" readonly=""   value="<?php echo ($row['unit_vat']) ?>"></td>

          <td style="display:none"><input type="text" class="form-control main_tp_plus_vat tp_plus_vat" id="tp_plus_vat" name="tp_plus_vat[]" readonly=""   value="<?php echo ($row['tp_plus_vat']) ?>"></td>

          <td><input type="text" class="form-control main_qty" id="qty" name="qty[]"   value="<?php echo ($row['quantity']) ?>"></td>

          <td><input type="text" class="form-control main_total_tp total_tp" id="total_tp" name="total_tp[]" readonly=""   value="<?php echo ($row['total_tp']) ?>"></td>

          <td style="display:none"><input type="text" class="form-control main_total_vat total_vat" id="total_vat" name="total_vat[]" readonly=""   value="<?php echo ($row['total_vat']) ?>"></td>

          <td><input type="text" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly=""   value="<?php echo ($row['total_price']) ?>"></td>

          <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>

        </tr>
        <?php
      }
    }

    ?>

  </tbody>

</table>



<div class="form-group">
  <h3>
    <label class="col-md-3 control-label" for="inputDefault"  style="text-align: left; color: #34495E"></label></h3>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Net Total Price (৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_total" name="net_total" value="<?php echo $get_order_details['net_total'] ?>" readonly="">
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Net Total TP (৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_total_tp" name="net_total_tp" value="<?php echo $get_order_details['net_total_tp'] ?>" readonly="">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Total Vat Amount (৳)</label>
    <div class="col-md-6">
      <input type="text"  class="form-control" id="net_total_vat" name="net_total_vat" value="<?php echo $get_order_details['net_total_vat'] ?>" readonly="">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Discount On TP (%)</label>
    <div class="col-md-6">
      <input type="text"   class="form-control" id="discount" name="discount" value="<?php echo $get_order_details['discount_on_tp'] ?>" placeholder="0" readonly>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Discount Amount (৳)</label>
    <div class="col-md-6">
      <input type="text"  class="form-control" id="discount_amount" name="discount_amount" value="<?php echo $get_order_details['discount_amount'] ?>" readonly="">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Payable Amount(৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="payable_amt" name="payable_amt" readonly="" value="<?php echo $get_order_details['payable_without_extra_discount'] ?>">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="extra_discount">Extra Discount(%)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="extra_discount" name="extra_discount" readonly=""  value="<?php echo $get_order_details['extra_discount'] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="net_payable_amt">Net Payable Amount(৳)</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="net_payable_amt" name="net_payable_amt" readonly="" value="<?php echo $get_order_details['payable_amt'] ?>">
    </div>
  </div>

  <?php
  $query = "SELECT * FROM invoice_setting";
  $get_invoice = $dbOb->select($query);
  if ($get_invoice) {
   $invoice_setting = $get_invoice->fetch_assoc();
 }
 ?>


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




<div class="form-group" style="display: none">

  <input type="text" class="form-control" id="edit_id" name="edit_id" readonly="" value="<?php echo ($serial_no) ?>">

</div>

<div class="form-group" align="center">
  <input type="submit" name="submit" value="Update Order Information" class="btn btn-success" style="">

  <a href="order_list.php" class="btn btn-danger" id="add_data">  Back</a>
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
      $('#invoice_details').append('<tr><td><select name="products_id_no[]" class="form-control main_product_id secondary_product_id" id="products_id_no" name="products_id_no[]"><option value=""></option><?php
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
      ?></select></td><td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td><td style="display:none"><input type="text" class="form-control main_pack_size pack_size" name="pack_size[]" readonly="" ></td><td><input type="text"  class="form-control main_unit_tp unit_tp" id="unit_tp" name="unit_tp[]" readonly="" ></td><td><input type="text"   class="form-control main_unit_vat unit_vat" id="unit_vat" name="unit_vat[]" readonly=""></td><td style="display:none"><input type="text"   class="form-control main_tp_plus_vat tp_plus_vat" id="tp_plus_vat" name="tp_plus_vat[]" readonly="" ></td><td><input type="text"  class="form-control main_qty" id="qty" name="qty[]" value="0"></td><td><input type="text" class="form-control main_total_tp total_tp" id="total_tp" name="total_tp[]" readonly=""></td><td style="display:none"><input type="text" class="form-control main_total_vat total_vat" id="total_vat" name="total_vat[]" readonly=""></td><td><input type="text" class="form-control main_total_price  total_price" id="total_price" name="total_price[]" readonly=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
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

      var employee_confirmation = $("#employee_confirmation").val();

      $.ajax({
        url:'ajax_edit_new_order.php',
        data:formData,
        type:'POST',
        dataType:'json',
        cache: false,
        processData: false,
        contentType: false,

        success:function(data){
           // alert('ppppp');

           if (data.type == 'success' && employee_confirmation == 'yes') {
            window.location = 'order_list.php';
          }else if(data.type == 'success' && employee_confirmation != 'yes'){
            window.location = 'delivery_pending.php';

          }else{
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
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

        var net_payable_amt = Math.round(payable_amt - payable_amt*extra_discount/100) ;
        $('#net_payable_amt').val(net_payable_amt);

      }

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
        }
      });
});

$(document).on('change','.area_employee',function(){
   var area_name = $(this).val();
   $.ajax({

        url:'ajax_new_order.php',
        data:{area_name:area_name},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#cust_id").html(data);
          $("#customer_name").val("");
          $("#shop_name").val("");
          $("#address").val("");
          $("#mobile_no").val("");
        }
      });
});
$(document).on('change','.employee_id',function(){
   var emp_id = $(this).val();
   $.ajax({
        url:'ajax_new_order.php',
        data:{emp_id:emp_id},
        type:'POST',
        dataType:'json',
        success:function(data){
          $(".employee_name").val(data);
          $(".employee_id").val(emp_id);
          // console.log()
        }
      });
});



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


  }

});

  }); // end of document ready function

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>

</body>
</html>