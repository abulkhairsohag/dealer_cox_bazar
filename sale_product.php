<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('sale_product')){
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
          <h2>Sell Product (Own Shop)</h2>
          <div class="row float-right" align="right">
           <?php 
           if (permission_check('sales_list')) {

            ?>
            <a href="sales.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fas fa-list-ul"> </i></span> View Sales List</a>
            
          <?php } ?>

        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <!-- form starts form here -->
        <form class="form-horizontal form-bordered" id="add_data_form"  data-parsley-validate action="" method="post">


          <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

            <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
              Employee And Customer Information 
            </div>
          </div>

          <div class="col-md-12" style="padding-bottom: 30px;width: 100%" align="center" >
           <table style="width: 100%">


            <thead>
              <tr>
                <th style="text-align: center;padding-bottom: 10px; color: red">Employee ID</th>
                <th style="text-align: center;padding-bottom: 10px; color: red">Employee Name</th>
                <!-- <th style="text-align: center;padding-bottom: 10px; color: red">Company</th> -->
                <th style="text-align: center;padding-bottom: 10px; color: red">Date</th>
              </tr>
            </thead>

            <tbody>
              <?php 
              include_once("class/Database.php");
              $dbOb = new Database();
              $employee_name = Session::get("name");
              $user_name = Session::get("username");
              $password = Session::get("password");

              $query = "SELECT * FROM employee_main_info where name = '$employee_name' and user_name = '$user_name' and password = '$password' ";
              $get_employee_iformation = $dbOb->find($query);
              $get_employee_id = $get_employee_iformation['id_no'];

              $query = "SELECT * from own_shop_employee where id_no = '$get_employee_id' AND active_status = 'Active'";
              $get_duty_employee = $dbOb->find($query);
              // $company = $get_duty_employee['company'];

              ?>
              <tr>
                <td>
                  <input type="text" class="form-control " id="employee_id" name="employee_id" readonly="" value="<?php echo($get_duty_employee['id_no']) ?>" required="">
                </td>
                <td>
                  <input type="text" class="form-control" id="employee_name" name="employee_name" readonly="" value="<?php echo $employee_name ?>" >
                </td>
                
               <!--  <td>
                  <input type="text" class="form-control" id="employee_company" name="employee_company" readonly="" value="<?php //echo $company ?>" >
                </td> -->
                <td>
                  <input type="text" class="form-control " id="date" name="date" readonly="" value="<?php echo date("d-m-Y") ?>">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

<!-- 
          <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

            <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
              
            </div>
          </div> -->

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Order Number</label>
            <div class="col-md-6">
             <!-- <select class="form-control" id="invoice_option" name="invoice_option" required=""> -->
              <input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo('ORDER-'.substr(uniqid('', true), -5).substr(number_format(time() * rand(),0,'',''),0,2)) ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Customer<span class="required" style="color: red">*</span></label>
            <div class="col-md-6">
              <select name="customer_id" id="customer_id" class="form-control select2" required="">
                <option value="-1">Walking Customer</option>
                <?php 
                $query = "SELECT * from own_shop_client Order BY client_name ";
                $get_client = $dbOb->select($query);
                if ($get_client) {
                  while ($row = $get_client->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row['serial_no'] ?>"><?php echo ucwords($row['client_name']).', '.$row['mobile_no']; ?></option>

                    <?php
                  }
                }
                ?>
              </select>
            </div>
            <div class="col-md-2"> <a data-toggle="modal" id="add_customer" data-target="#add_customer_modal" class="btn bg-green">Add Customer</a> </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Customer Name </label>
            <div class="col-md-6">
              <input type="text" class="form-control customer_info" id="customer_name" name="customer_name" >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Mobile No</label>
            <div class="col-md-6">
              <input type="text" class="form-control customer_info" id="mobile_no" name="mobile_no" >
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

                <th style="text-align: center;">Available QTY</th>
                <!-- <th style="display: none;">vcgfvbjh</th> -->
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Sell Price (৳)</th>
                <th style="text-align: center;">MRP (৳)</th>
                <th style="text-align: center;">Total Amount (৳)</th>
                <th style="text-align: center;">Offer</th>
                <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
              </tr>
            </thead>
            <tbody id="invoice_details">

              <tr>
                <td >
                  <input type="hidden" class="product_id">
                  <select  class="form-control main_product_id select2" id="products_id_no" name="products_id_no[]">
                    <option value=""></option>
                    <?php 
                    include_once('class/Database.php');
                    $dbOb = new Database();
                    $query = "SELECT * FROM products";
                    $get_products = $dbOb->select($query);
                    if ($get_products) {
                      while ($row = $get_products->fetch_assoc()) {
                        ?>
                        <option value="<?php echo($row['products_id_no']) ?>"> <?php echo($row['products_id_no'].', '.$row['products_name']) ?> </option>

                        <?php
                      }
                    }
                    ?>
                  </select>
                </td>
                <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td>
                <td><input type="text" class="form-control main_category available_qty" name="available_qty[]" readonly="" ></td>
                <td style="display: none;"><input type="text" class="form-control main_category available_qty_hidden" name="available_qty_hidden[]" readonly="" ></td>
                <td><input type="number" min="0" step="1" class="form-control main_quantity quantity" id="quantity" name="quantity[]"  ></td>
                <td><input type="number" min="0" step="0.01" class="form-control main_sell_price sell_price" id="sell_price" name="sell_price[]" readonly=""></td>
                <td><input type="number" min="0" step="0.01" class="form-control main_mrp_price mrp_price" id="mrp_price" name="mrp_price[]" readonly="" value="0"></td>
                <td><input type="number" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly="" value="0" readonly=""></td>
                <td><input type="text" class="form-control main_promo_offer promo_offer" id="promo_offer" name="promo_offer[]" readonly=""></td>
                <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>

              </tr>

            </tbody>

          </table>


          <div class="form-group">
            <h3>
              <label class="col-md-3 control-label" for="inputDefault"  style="text-align: left; color: #34495E"></label></h3>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Net Total (৳)</label>
              <div class="col-md-6">
                <input type="number" class="form-control" id="net_total" name="net_total" value="0" readonly="">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vat (%)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="vat" name="vat" value="0" placeholder="0">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vat Amount (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" class="form-control" id="vat_amount" name="vat_amount" value="0" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Discount (%)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="discount" name="discount" value="0" placeholder="0">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Discount Amount (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" class="form-control" id="discount_amount" name="discount_amount" value="0" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Grand Total(৳)</label>
              <div class="col-md-6">
                <input type="number" class="form-control" id="grand_total" name="grand_total" readonly="" value="0">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Paid (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="pay" name="pay" value="0" placeholder="0">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Due (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="due" name="due" readonly="" value="0">
              </div>
            </div>

            <div class="form-group" align="center">
            <?php 
            if (permission_check('sale_product_save_button')) {
              ?>
              <input type="submit" name="submit" value="Save" class="btn btn-success" style="">
              <?php } ?>
              <input type="reset" name="reset" value="Reset" class="btn btn-warning">
            </div>

          </form>


        </div>
      </div>
    </div>


    <!-- Modal For Adding and Updating data  -->
    <div class="modal fade" id="add_customer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white"></h3>
            <div style="float:right;">

            </div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="background: #f2ffe6">

                  <div class="x_content" style="background: #f2ffe6">
                    <br />
                    <!-- Form starts From here  -->
                    <form id="form_add_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                     <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Name<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text"  required="" id="add_customer_name" name="add_customer_name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address  <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea type="text" required="" id="add_customer_address" name="add_customer_address" class="form-control col-md-7 col-xs-12" ></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile  <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" required="" id="add_customer_mobile_no" name="add_customer_mobile_no" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" id="add_customer_email" name="add_customer_email" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>


                    <div style="display: none;">
                      <input type="number" id="edit_id" name="edit_id">
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="reset" class="btn btn-primary" >Reset</button>
                        <button type="submit" class="btn btn-success" id="submit_button"></button>
                      </div>
                    </div>


                  </form>
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
  </div> <!-- End of modal for  Adding and Updating data-->


    <!-- /page content -->

  </div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    var selected_products = []; 

    $("#add_more").click(function(){


      $('#invoice_details').append('<tr><td><select name="products_id_no[]" class="form-control main_product_id secondary_product_id select2" id="products_id_no" name="products_id_no[]"><option value=""></option><?php 
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
            ?><option value="<?php echo($row['products_id_no']) ?>"> <?php echo($row['products_id_no'].', '.$row['products_name']) ?> </option><?php
          }
        }
        ?></select></td><td><input type="text" class="form-control secondary_products_name products_name"  name="products_name[]" readonly=""></td><td><input type="text" class="form-control secondary_category available_qty" name="available_qty[]" readonly="" ></td><td  style="display: none;"><input type="text" class="form-control main_category available_qty_hidden" name="available_qty_hidden[]" readonly="" ></td><td><input type="number" min="0" step="1" class="form-control secondary_quantity quantity" id="quantity" name="quantity[]"  ></td><td><input type="number" min="0" step="0.01" class="form-control secondary_sell_price sell_price" id="sell_price" name="sell_price[]" readonly=""></td><td><input type="number" min="0" step="0.01" class="form-control secondary_mrp_price mrp_price" id="mrp_price" name="mrp_price[]" readonly="" value="0"></td><td><input type="number" class="form-control secondary_total_price total_price" id="total_price" name="total_price[]" readonly="" value="0" readonly=""></td><td><input type="text" class="form-control secondary_promo_offer promo_offer" id="promo_offer" name="promo_offer[]" readonly=""></td><td><button type="button" class="btn btn-danger remove_button secondary_remove_btn"><i class="fas fa-times"></i></button></td></tr>');
    });



    var id_and_qty = new Array();
    var list_id = new Array();


    $(document).on('click','.remove_button', function(e) {
      var got_id = 0;
      var tr=$(this).parent().parent();
      var remove_row = $(this).closest("tr");
      var product_id = $(this).attr('id');


      var quantity =tr.find("#quantity").val();

      if (isNaN(quantity) || quantity == '') {
        quantity = 0;
      }

      for (i = 0; i < list_id.length; i++) { 
        var id = list_id[i];

      // console.log(id);
      if (id == product_id) {
        got_id = 1;
        break;
      }else{
        got_id = 0;
      }
      }

      if (got_id == 1) {
        $.each(id_and_qty,function(key,val){
          if (val.product_id == product_id) {
            // tr.find(".available_qty").val(val.available_qty);
            val.available_qty = parseInt(val.available_qty) + parseInt(quantity);
            
          }
        })
      }

      // console.log(product_id);
      remove_row.remove();
      cal();
    });



    // invoice calculation 
    $("#invoice_details").delegate('#quantity','keyup',function(){
      var got_id = 0;
      var tr=$(this).parent().parent();

      var quantity =tr.find("#quantity").val();

      if (isNaN(quantity) || quantity == '') {
        quantity = 0;
      }

      var sell_price=tr.find("#sell_price").val();


      var product_id =tr.find(".main_product_id").val();



      id_and_qty.forEach(function(e,val) {

       list_id.push(e.product_id);
     });

          // console.log(list_id);
          for (i = 0; i < list_id.length; i++) { 
            var id = list_id[i];

              // console.log(id);
              if (id == product_id) {
                got_id = 1;
                break;
              }else{
                got_id = 0;
              }
            }

            if (got_id == 1) {
              $.each(id_and_qty,function(key,val){
                if (val.product_id == product_id) {
                  val.available_qty = parseInt(tr.find(".available_qty_hidden").val()) - parseInt(quantity);
                  tr.find(".available_qty").val(val.available_qty);
                  // break;
                }
              })
            }else{
              var available_qty_hidden =tr.find(".available_qty_hidden").val();
              var new_available = parseInt(available_qty_hidden) - parseInt(quantity);
              tr.find(".available_qty").val(new_available);

              id_and_qty.push({product_id: product_id, available_qty: new_available});
            }

            // checking if quantity is greater than the available quantity 
            if (quantity>parseInt(tr.find(".available_qty_hidden").val())) {
               swal({
                  title: "You don't have this much product.",
                  icon: "warning",
                  button: "Done",
                });
               tr.find("#quantity").val(0);
               tr.find(".available_qty").val(tr.find(".available_qty_hidden").val());
               tr.find("#total_price").val(0);
                quantity = 0;

            }


            sell_price = parseInt(sell_price);
            quantity = parseInt(quantity);
            
            var amt =quantity*sell_price;
            tr.find("#total_price").val(amt);
            cal();
    });

    
    $(document).on('change','.main_product_id', function() {
      var got_id = 0;
      var tr=$(this).parent().parent();
      var products_id_no_get_info =tr.find("#products_id_no").val();
      
      $.ajax({
        url:"ajax_new_order.php",
        data:{products_id_no_get_info:products_id_no_get_info},
        type:"post",
        dataType:'json',
        success:function(data){
          tr.find(".products_name").val(data.products.products_name);

          id_and_qty.forEach(function(e,val) {

           list_id.push(e.product_id);
         });

            // console.log(list_id);
            for (i = 0; i < list_id.length; i++) { 
              var id = list_id[i];

                // console.log(id);
                if (id == products_id_no_get_info) {
                  got_id = 1;
                  break;
                }else{
                  got_id = 0;
                }
              }

              if (got_id == 1) {
                $.each(id_and_qty,function(key,val){
                  if (val.product_id == products_id_no_get_info) {
                   tr.find(".available_qty").val(val.available_qty);
                   tr.find(".available_qty_hidden").val(val.available_qty);
                 }
               })
              }else{
                tr.find(".available_qty").val(data.products.quantity);
                tr.find(".available_qty_hidden").val(data.products.quantity);
              }


              tr.find(".remove_button").attr('id',products_id_no_get_info);


              tr.find(".mrp_price").val(data.products.mrp_price);
              tr.find(".sell_price").val(data.products.marketing_sell_price);
              tr.find(".promo_offer").val(data.offer);
            }
          });

      cal();
    });




    // now we are going to  insert data 
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_sell_product.php',
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



// the following function is for invoice claculation
function cal()
{
  var net_total =0;

  $(".total_price").each(function(){
    net_total=net_total+($(this).val()*1);

  });
  $("#net_total").val(net_total);
  
  var vat = $("#vat").val();
  var discount = $("#discount").val();

  if (vat>=0 && vat <= 100) {
    var vat_amount = net_total*$("#vat").val()/100;
    $("#vat_amount").val(vat_amount);
    var discount_amount = $("#discount_amount").val();

    if (discount_amount>0) {
      grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount) - parseFloat(discount_amount));
    }else{
     grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount)) ;
   }

   $("#grand_total").val(grand_total);

   var pay_amount = $("#pay").val();
   if (pay_amount>0) {
     due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
     
   }else{
    due_amount = roundToTwo (parseFloat(grand_total));
  }

  $("#due").val(due_amount);

      }else{ // if  vat   is not found then net total will be the grand total
        $("#grand_total").val(net_total);
      }

      if(discount>0 && discount <= 100){

        var net_total = $("#net_total").val();
        var vat_amount = $("#vat_amount").val();

        var discount_amount = roundToTwo (net_total*$("#discount").val()/100);
        
        $("#discount_amount").val(discount_amount);

        var total = parseFloat(net_total) + parseFloat(vat_amount);
        var grand_total = roundToTwo (parseFloat(total)  - parseFloat(discount_amount)) ;
        
        $("#grand_total").val(grand_total);

        var pay_amount = $("#pay").val();

        if (pay_amount=="" || isNaN(pay_amount)) {

         pay_amount =0;
       }

       if (pay_amount >= 0) {
         due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
         
       }
       

       $("#due").val(due_amount);

      }else{ // if  discount  is not found then net total will be the grand total
        $("#grand_total").val(net_total);
      }

      vat_cal(vat);
      
    }
// vat claculation 
$(document).on('keyup blur','#vat',function(){
  var vat = $(this).val();
  if (vat>100) {
    alert("You Cannot Take Vat More Than 100%");
    $(this).val(0)
  }else{
    vat_cal(vat);

  }

});


$(document).on('keyup blur','#discount',function(){
  var discount_amt = $(this).val();
  if (discount_amt>100) {
    alert("You Cannot Provide A Discount More Than 100%");
    $(this).val(0)
  }else{

    var net_total = $("#net_total").val();
    var vat_amount = $("#vat_amount").val();

    var discount_amount = roundToTwo (net_total*$("#discount").val()/100);
    
    $("#discount_amount").val(discount_amount);

    var total = parseFloat(net_total) + parseFloat(vat_amount);
    var grand_total = roundToTwo (parseFloat(total)  - parseFloat(discount_amount)) ;
    
    $("#grand_total").val(grand_total);

    var pay_amount = $("#pay").val();
    if (pay_amount>0) {
     due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
     
   }else{
    due_amount =  roundToTwo (parseFloat(grand_total));

  }

  $("#due").val(due_amount);

  }

});

$(document).on('keyup blur','#pay',function(){
  var pay_amount = $(this).val();
  var grand_total = $("#grand_total").val();
  if (isNaN(pay_amount) || pay_amount == "") {
    pay_amount =0;
  }
  var due_amount = parseFloat(grand_total) - parseFloat(pay_amount);
  due_amount = roundToTwo (due_amount);
  $("#due").val(due_amount);
});

$(document).on('change','#customer_id',function(){
  var customer = $(this).val();
  if (customer != '-1') {
    $('.customer_info').attr("readonly", true);
    // console.log(customer)
  }else{
    $('.customer_info').attr("readonly", false);
  }

  $.ajax({
    url:'ajax_sell_product.php',
    data:{customer:customer},
    type:'POST',
    dataType:'json',
    success:function(data){
      $('#customer_name').val(data.client_name);
      $('#mobile_no').val(data.mobile_no);
    }



  });
});


  }); // end of document ready function 

function vat_cal(vat){

    var net_total = $("#net_total").val();
    var vat_amount = net_total*$("#vat").val()/100;
    var grand_total = 0;
    var due_amount = 0 ;
    $("#vat_amount").val(vat_amount);
    var discount_amount = $("#discount_amount").val();

    if (discount_amount>0) {
      grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount) - parseFloat(discount_amount));
      
    }else{
     grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount)) ;
     
   }

   $("#grand_total").val(grand_total);

   var pay_amount = $("#pay").val();
   if (pay_amount>0) {
     due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
     
   }else{
    due_amount = roundToTwo (parseFloat(grand_total));


  }

  $("#due").val(due_amount);
}

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>




<script>
  

    $(document).on('click','#add_customer',function(){
      $("#ModalLabel").html("Provide New Customer Information");
      $("#submit_button").html("Save");
      $("#add_customer_name").val("");
      $("#add_customer_address").val("");
      $("#add_customer_mobile_no").val("");
      $("#add_customer_email").val("");
    });


    // now we are going to  insert data 
    $(document).on('submit','#form_add_data',function(e){
      e.preventDefault();
      var formData = new FormData($("#form_add_data")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_customer_add.php',
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
            $("#customer_id").html(data.client);
            $('#add_customer_modal').modal("hide");



          }
        }
      });
    }); // end of insert 


$("#customer_id").select2({ width: '100%' }); 
$("#product_id").select2({ width: '100%' }); 
</script>

</body>
</html>