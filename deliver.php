<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('delivery_pending_invoice_button')){
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
          <h2>Deliver The Order</h2>
          <!-- <div class="row float-right" align="right">
            <a href="order_list.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fas fa-list-ul"> </i></span> View Order List</a>
          </div> -->
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

          <!-- ------------------------------------------------------------------------- -->

          <!-- the following section is for employee information -->
          <div class="col-md-12" style="margin-bottom: 30px;width: 100%" align="center" >
           <table style="width: 100%">


          
           <thead>
                <tr>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Delivery Employee ID</th>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Delivery Employee Name</th>
                  <th style="text-align: center;padding-bottom: 10px; color: red">Area</th>
                  <!-- <th style="text-align: center;padding-bottom: 10px; color: red">Company</th> -->
                  <th style="text-align: center;padding-bottom: 10px; color: red">Delivery Date</th>
                </tr>
              </thead>

            <tbody>
              <?php 
              include_once("class/Database.php");
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
                
                $order_id = $get_order_details['order_no'];
                $query = "SELECT * FROM order_summery_shop_info WHERE order_no = '$order_id' ORDER BY serial_no DESC LIMIT 1";
                $get_summery = $dbOb->find($query);
                $summery_id = $get_summery['summery_id'];
                $query = "SELECT * FROM order_summery WHERE  summery_id = '$summery_id'";
                $summery_info = $dbOb->find($query);
              }
              ?>
            <!-- the following section is for order employee this is hidden field-->
              <tr style="display:none">
                  <input type="hidden" class="form-control " id="order_ser_no" name="order_ser_no" readonly="" value="<?php echo($get_order_details['serial_no']) ?>" >
                <td>
                  <input type="text" class="form-control employee_id" id="employee_id" name="employee_id" readonly="" value="<?php echo($get_order_details['employee_id']) ?>" >
                </td>
                <td>
                  <input type="text" class="form-control employee_name" id="employee_name" name="employee_name" readonly="" value="<?php echo $get_order_details['employee_name'] ?>" >
                </td>
                <td>
                  <input type="text" class="form-control area_employee" id="area_employee" name="area_employee" readonly="" value="<?php echo $get_order_details['area_employee'] ?>" >
                </td>
                <!-- <td>
                  <input type="text" class="form-control" id="employee_company" name="employee_company" readonly="" value="<?php //echo $get_order_details['company'] ?>" >
                </td> -->
                <td>
                  <input type="text" class="form-control " id="date" name="date" readonly="" value="<?php echo $get_order_details['order_date']  ?>">
                </td>
              </tr>
              
            <!-- The following section is for delivery man -->
            <tr>
                  <td>
                    <input type="text" class="form-control " id="employee_id_delivery" name="employee_id_delivery" readonly="" value="<?php echo $summery_info['deliv_emp_id']?>"  >
                   
                  </td>
                  <td>
                    <input type="text" class="form-control employee_name_delivery" id="employee_name_delivery" name="employee_name_delivery" readonly=""  value="<?php echo $summery_info['deliv_emp_name']?>"  >
                  </td>
                  <td>
                    <input type="text" class="form-control" id="area_employee_delivery" name="area_employee_delivery" readonly="" value="<?php echo $get_order_details['area_employee'] ?>" >
                  </td> 
                 <!--  <td>
                    <input type="text" class="form-control" id="employee_company_delivery" name="employee_company_delivery" readonly="" value="<?php //echo $company_delivery_employee ?>" >
                  </td> -->
                  <td>
                    <input type="text" class="form-control date-picker datepicker delivery_date" value="" id="delivery_date" name="delivery_date" readonly="" required>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
        <!-- End of delivery man information  -->

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Order Number</label>
          <div class="col-md-6">
           <!-- <select class="form-control" id="invoice_option" name="invoice_option" required=""> -->
            <input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo($get_order_details['order_no']) ?>">
          </div>
        </div>

        
        <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Customer ID <span class="required" style="color: red">*</span></label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="cust_id" name="cust_id" required="" value="<?php echo $get_order_details['cust_id'] ?>" readonly>
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


        <div class="table-responsive"> 
        <table class="table" >

<thead>
  <tr>
    <th style="text-align: center;">Product ID</th>
    <th style="text-align: center;">Name</th>
    <th style="text-align: center;">Pack Size</th>
    <th style="text-align: center;">Unit TP</th>
    <th style="text-align: center;">Unit VAT</th>
    <th style="text-align: center;">TP + VAT</th>
    <th style="text-align: center;">QTY</th>
    <th style="text-align: center;">Total TP</th>
    <th style="text-align: center;">Total VAT</th>
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
  
      <td><input type="text" name="products_id_no[]" class="form-control main_product_id" id="products_id_no" readonly="" value="<?php echo($row['products_id_no']) ?>"></td>
   
      <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""   value="<?php echo($row['products_name']) ?>"></td>


      <td><input type="text" class="form-control main_pack_size pack_size" name="pack_size[]" readonly=""    value="<?php echo($row['pack_size']) ?>"></td>

      <td><input type="text" class="form-control main_unit_tp unit_tp" id="unit_tp" name="unit_tp[]" readonly=""    value="<?php echo($row['unit_tp']) ?>"></td>

      <td><input type="text" class="form-control main_unit_vat unit_vat" id="unit_vat" name="unit_vat[]" readonly=""   value="<?php echo($row['unit_vat']) ?>"></td>

      <td><input type="text" class="form-control main_tp_plus_vat tp_plus_vat" id="tp_plus_vat" name="tp_plus_vat[]" readonly=""   value="<?php echo($row['tp_plus_vat']) ?>"></td>

      <td><input type="text" class="form-control main_qty" id="qty" name="qty[]"   value="<?php echo($row['quantity']) ?>"></td>

      <td><input type="text" class="form-control main_total_tp total_tp" id="total_tp" name="total_tp[]" readonly=""   value="<?php echo($row['total_tp']) ?>"></td>

      <td><input type="text" class="form-control main_total_vat total_vat" id="total_vat" name="total_vat[]" readonly=""   value="<?php echo($row['total_vat']) ?>"></td>

      <td><input type="text" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly=""   value="<?php echo($row['total_price']) ?>"></td>

      <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>

    </tr>
            <?php
          }
        }

       ?>

  </tbody>

</table>
</div>


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
    <input type="text" class="form-control" id="net_total_tp" name="net_total_tp" value="<?php echo $get_order_details['net_total_tp']  ?>" readonly="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Total Vat Amount (৳)</label>
  <div class="col-md-6">
    <input type="text"  class="form-control" id="net_total_vat" name="net_total_vat" value="<?php echo $get_order_details['net_total_vat']  ?>" readonly="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Discount On TP (%)</label>
  <div class="col-md-6">
    <input type="text"   class="form-control" id="discount" name="discount" value="<?php echo $get_order_details['discount_on_tp']  ?>" placeholder="0" readonly>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Discount Amount (৳)</label>
  <div class="col-md-6">
    <input type="text"  class="form-control" id="discount_amount" name="discount_amount" value="<?php echo $get_order_details['discount_amount']  ?>" readonly="">
  </div>
</div>

<div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Payable Amount(৳)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="payable_amt" name="payable_amt" readonly="" value="<?php echo $get_order_details['payable_without_extra_discount']  ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="extra_discount">Extra Discount(%)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="extra_discount" name="extra_discount" readonly=""  value="<?php echo $get_order_details['extra_discount']  ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="net_payable_amt">Net Payable Amount(৳)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="net_payable_amt" name="net_payable_amt" readonly="" value="<?php echo $get_order_details['payable_amt']  ?>">
            </div>
          </div>



          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Paid (৳)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="pay" name="pay" value="<?php echo($get_order_details['pay']) ?>" placeholder="0">
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Due (৳)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="due" name="due" readonly="" value="<?php echo($get_order_details['due']) ?>">
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
              <input type="text" class="form-control" id="vat" name="vat" readonly="" value="<?php echo $invoice_setting['vat']?>">
            </div>
          </div>
          <div class="form-group" style="display:none">
            <label class="col-md-3 control-label" for="discount_on_mrp">discount on MRP (%)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="discount_on_mrp" name="discount_on_mrp" readonly="" value="<?php echo $invoice_setting['discount_on_mrp']?>">
            </div>
          </div>


          <div class="form-group" style="display: none">
            
            <input type="text" class="form-control" id="edit_id" name="edit_id" readonly="" value="<?php echo($serial_no) ?>">
            
          </div>

          <div class="form-group" align="center">

          
              <input type="submit" name="submit" value="Deliver Order" class="btn btn-success" style="">


            
           
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

$("#add_more").click(function(){
  $('#invoice_details').append('<tr><td><select name="products_id_no[]" class="form-control main_product_id secondary_product_id" id="products_id_no" name="products_id_no[]"><option value=""></option><?php 
    include_once('class/Database.php');
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
        <option value="<?php echo($row['products_id_no']) ?>"> <?php echo($row['products_id_no'].', '.$row['products_name']) ?> </option><?php
      }
    }
    ?></select></td><td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td><td><input type="text" class="form-control main_pack_size pack_size" name="pack_size[]" readonly="" ></td><td><input type="text"  class="form-control main_unit_tp unit_tp" id="unit_tp" name="unit_tp[]" readonly="" ></td><td><input type="text"   class="form-control main_unit_vat unit_vat" id="unit_vat" name="unit_vat[]" readonly=""></td><td><input type="text"   class="form-control main_tp_plus_vat tp_plus_vat" id="tp_plus_vat" name="tp_plus_vat[]" readonly="" ></td><td><input type="text"  class="form-control main_qty" id="qty" name="qty[]" value="0"></td><td><input type="text" class="form-control main_total_tp total_tp" id="total_tp" name="total_tp[]" readonly=""></td><td><input type="text" class="form-control main_total_vat total_vat" id="total_vat" name="total_vat[]" readonly=""></td><td><input type="text" class="form-control main_total_price  total_price" id="total_price" name="total_price[]" readonly=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
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

      var unit_vat = roundToTwo(unit_tp*vat/100);
      tr.find(".unit_vat").val(unit_vat);

      var tp_plus_vat = roundToTwo(unit_vat + unit_tp);
      tr.find(".tp_plus_vat").val(tp_plus_vat);
      // console.log(qty);
      var total_tp = roundToTwo(tr.find(".unit_tp").val() * qty) ;
      var total_vat = roundToTwo(tr.find(".unit_vat").val() * qty) ;
      var total_price = roundToTwo(tr.find(".tp_plus_vat").val() * qty) ;
      
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
      var order_ser_no = $('#order_ser_no').val();

      $.ajax({
        url:'ajax_deliver.php',
        data:formData,
        type:'POST',
        dataType:'json',
        cache: false,
        processData: false,
        contentType: false,

        success:function(data){
          
          if (data.conf == 'yes') {
              window.location = 'delivery-invoice.php?serial_no='+data.deliv_serial_no;
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

  var total_tp = roundToTwo(tr.find(".unit_tp").val() * quantity) ;
  var total_vat =  roundToTwo(tr.find(".unit_vat").val() * quantity) ;
  var total_price =  roundToTwo(tr.find(".tp_plus_vat").val() * quantity) ;

  
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
      net_total=roundToTwo(net_total+($(this).val()*1));

    });
    $("#net_total").val(net_total);

    var net_total_tp = 0 ;
    $(".total_tp").each(function(){
      net_total_tp=net_total_tp+($(this).val()*1);
    });
    net_total_tp = roundToTwo(net_total_tp);

    $("#net_total_tp").val(net_total_tp);

    var net_total_vat = 0 ;
    $(".total_vat").each(function(){
      net_total_vat=roundToTwo(net_total_vat+($(this).val()*1));
    });
    $("#net_total_vat").val(net_total_vat);
    
    // var vat = $("#vat").val();
    var discount = $("#discount").val();


      if(discount>0 && discount <= 100){
        // var net_total_tp = $("#net_total_tp").val();
        // var net_total = $("#net_total").val();

        var discount_amount = roundToTwo (net_total_tp*$("#discount").val()/100);
        
        var payable_amt =roundToTwo((parseFloat(net_total)  - parseFloat(discount_amount)));


        
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

      var due = net_payable_amt - roundToTwo(parseFloat($('#pay').val()));
      $("#due").val(due);
      
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

      var discount_amount = roundToTwo (net_total_tp*$("#discount").val()/100);
      
      $("#discount_amount").val(discount_amount);

      var payable_amt = roundToTwo (parseFloat(net_total)  - parseFloat(discount_amount)) ;
      
      $("#payable_amt").val(payable_amt);

      var due = payable_amt - roundToTwo(parseFloat($('#pay').val()));
        $("#due").val(due);
  }

});

$(document).on('keyup blur','#pay',function(){
    var pay_amount = $(this).val();
    var payable_amt = $("#net_payable_amt").val();
    if (isNaN(pay_amount) || pay_amount == "") {
      pay_amount =0;
    }
    var due_amount = parseFloat(payable_amt) - parseFloat(pay_amount);
    due_amount = parseInt (due_amount);
    $("#due").val(due_amount);
  });

  $(document).on('change','#employee_id_delivery',function(){
   var emp_id = $(this).val();
   $.ajax({
        url:'ajax_new_order.php',
        data:{emp_id:emp_id},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#employee_name_delivery").val(data);
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