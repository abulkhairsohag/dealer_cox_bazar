<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('sale_product_edit_button')){
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
           if (permission_check('market_order_list')) {

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
                      $serial_no = '';
                      $get_order_details = "";
                      $get_order_expense = "";

                      if (isset($_GET['serial_no'])) {
                        $serial_no = $_GET['serial_no'];
                        $query_details = "SELECT * FROM own_shop_sell WHERE serial_no = '$serial_no'";
                        $query_expense = "SELECT * FROM own_shop_sell_product WHERE sell_tbl_id = '$serial_no'";

                        $details = $dbOb->find($query_details);
                        $expense = $dbOb->select($query_expense);
                      }
                     ?>
              <!-- keeping edit id in a hidden field -->
                <input type="hidden" class="form-control " id="edit_id" name="edit_id" readonly="" value="<?php echo $serial_no ?>" required="">
              <tr>
                <td>
                  <input type="text" class="form-control " id="employee_id" name="employee_id" readonly="" value="<?php echo($details['employee_id']) ?>" required="">
                </td>
                <td>
                  <input type="text" class="form-control" id="employee_name" name="employee_name" readonly="" value="<?php echo $details['employee_name'] ?>" >
                </td>
                
               <!--  <td>
                  <input type="text" class="form-control" id="employee_company" name="employee_company" readonly="" value="<?php //echo $company ?>" >
                </td> -->
                <td>
                  <input type="text" class="form-control " id="date" name="date" readonly="" value="<?php echo $details['sell_date'] ?>">
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
              <input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo($details['order_no']) ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Customer <span class="required" style="color: red">*</span></label>
            <div class="col-md-6">
              
              <select name="customer_id" id="customer_id" class="form-control select2" required="">
                <option value="-1">Walking Customer</option>
                <?php 
                $query = "SELECT * from own_shop_client Order BY client_name ";
                $get_client = $dbOb->select($query);
                if ($get_client) {
                  while ($row = $get_client->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row['serial_no'] ?>" <?php if ($details['customer_id'] == $row['serial_no']) {
                      echo 'selected';
                    } ?>><?php echo ucwords($row['client_name']).', '.$row['mobile_no']; ?></option>

                    <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Customer Name </label>
            <div class="col-md-6">
              <input type="text" class="form-control customer_info" id="customer_name" name="customer_name" value="<?php echo $details['customer_name'] ?>" <?php if ($details['customer_id'] != '-1') {
                echo 'readonly';
              } ?>>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Mobile No</label>
            <div class="col-md-6">
              <input type="text" class="form-control customer_info" id="mobile_no" name="mobile_no" value="<?php echo $details['mobile_no'] ?>" <?php if ($details['customer_id'] != '-1') {
                echo 'readonly';
              } ?>>
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
                <th style="text-align: center;">Sell Price (৳)</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Total Price (৳)</th>
                <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
              </tr>
            </thead>
            <tbody id="invoice_details">
            
            <?php 
              if ($expense) {
                while ($row = $expense->fetch_assoc()) {
                  $pr_id = $row['products_id_no'];
                  $query = "SELECT * FROM own_shop_products_stock where products_id = '$pr_id'";
                  $get_product = $dbOb->find($query);
                  $available_qty = $get_product['quantity_pcs'];
                  // die($available_qty);
                  ?>

              <tr>
              
                <td >
                  <!-- <input type="hidden" class="product_id"> -->
                   <input type="text" class="form-control main_product_id product_id" id="products_id_no" name="products_id_no[]" value="<?php echo $row['products_id_no'] ?>" readonly="" >
                </td>

                <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly="" value="<?php echo $row['products_name'] ?>"></td>

                <td><input type="text" class="form-control main_category sell_price" name="sell_price[]" readonly="" value="<?php echo $row['sell_price'] ?>"></td>
              
                <td><input type="number" min="0" step="1" data-available="<?php echo $available_qty; ?>"   class="form-control main_quantity qty" id="qty" name="qty[]"  value="<?php echo $row['qty'] ?>" placeholder="<?php echo $available_qty; ?>"></td>

               
                <td><input type="number" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly="" value="<?php echo $row['total_price'] ?>" readonly=""></td>
                
                
                <td><button type="button" class="btn btn-danger remove_button" id="<?php echo $row['products_id_no'] ?>"><i class="fas fa-times"></i></button></td>

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
            <label class="col-md-3 control-label" for="net_payable_amt">Net Payable Amount(৳)</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="net_payable_amt" name="net_payable_amt" readonly="" value="<?php echo $details['net_payable_amt'] ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="pay">Paid Amount(৳)</label>
            <div class="col-md-6">
              <input type="number" min="0" step="1" class="form-control" id="pay" name="pay" value="<?php echo $details['pay'] ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="due">Due Amount(৳)</label>
            <div class="col-md-6">
              <input type="number" min="0" class="form-control" id="due" name="due" readonly="" value="<?php echo $details['due'] ?>">
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
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    var selected_products = []; 

    
    $("#add_more").click(function(){


      $('#invoice_details').append('<tr><td><select name="products_id_no[]" class="form-control main_product_id secondary_product_id select2 product_id" id="products_id_no" name="products_id_no[]"><option value=""></option><?php 
        include_once('class/Database.php');
        $dbOb = new Database();
        $employee_name = Session::get("name");
        $user_name = Session::get("username");
        $password = Session::get("password");

        
       $query = "SELECT * FROM own_shop_products_stock";
        $get_products = $dbOb->select($query);
        if ($get_products) {
         while ($row = $get_products->fetch_assoc()) {
          ?>
          <option value="<?php echo ($row['products_id']) ?>"> <?php echo ($row['products_id'] . ', ' . $row['product_name']) ?> </option><?php
        }
      }
      ?></select></td><td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td><td><input type="text"  class="form-control main_sell_price sell_price" id="sell_price" name="sell_price[]" readonly="" ></td><td><input type="text"  class="form-control main_qty" id="qty" name="qty[]" value="" readonly="" required=""></td><td><input type="text" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
    });



    $(document).on('click','.remove_button', function(e) {
      var remove_row = $(this).closest("tr");
      remove_row.remove();
      cal();
    });




    
    $(document).on('change','.product_id', function() {

      var tr=$(this).parent().parent();
      var products_id_no_get_info =tr.find("#products_id_no").val();
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
        tr.find("#products_id_no").val('');

      }else{

        var qty = tr.find("#qty").val();
        if (isNaN(qty) || qty == '') {
          qty = 0;
        }
        var discount_on_mrp = $("#discount_on_mrp").val();
        var vat = $("#vat").val();

      $.ajax({
        url:"ajax_sell_product.php",
         data:{products_id_no_get_info:products_id_no_get_info},
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
          }

          tr.find(".sell_price").val(data.products.sell_price);
          tr.find(".products_name").val(data.products.product_name);
          var total_price = (data.products.sell_price * qty) ;
          tr.find(".total_price").val(total_price );

          tr.find("#qty").attr("readonly", false);
          tr.find("#qty").attr("placeholder", data.available_qty);
          tr.find("#qty").attr("data-available", data.available_qty);
          tr.find("#qty").focus();

          cal();
        }
      });
    }
      // cal();
    });




// invoice calculation
  $("#invoice_details").delegate('#qty','keyup blur change',function(){
    var tr=$(this).parent().parent();

    var quantity =tr.find("#qty").val();
    var available =tr.find("#qty").data('available');
    // alert(available);

    if (quantity > available) {
       swal({
              title: 'warning',
              text: 'The Quantity You Have Entered Is Not Available In The Shop',
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

    





    // now we are going to  insert data 
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_edit_sell_product.php',
        data:formData,
        type:'POST',
        dataType:'json',
        cache: false,
        processData: false,
        contentType: false,

        success:function(data){
           // alert('ppppp');
           
           if (data.type == 'success') {
              setTimeout(function(){
                window.location = 'sales.php';
              });
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




 $(document).on('keyup blur change','#pay',function(){
  //  console.log();
   console.log($("#net_payable_amt").val());
     var pay = parseFloat($(this).val());
     var payable  = parseFloat($("#net_payable_amt").val());
     if (pay > payable) {
        swal({
          title: 'warning',
          text: 'Pay Amount Cannot Be Greater Than Payable Amount..',
              icon: 'warning',
              button: "Done",
            });
        $(this).val(0);
        $("#due").val(payable);
     }
      cal();
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

  $(document).on('change','.employee_id',function(){
     var employee_id = $(this).val();
    //  alert(employee_id);
     $.ajax({
        url:'ajax_sell_product.php',
        data:{employee_id_get:employee_id},
        type:'POST',
        dataType:'json',
        success:function(data){
          $(".employee_name").val(data);
          // $(".employee_id").val(emp_id);
        }
      });
  });

  }); // end of document ready function 


</script>




<script>

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



  

    $(document).on('click','#add_customer',function(){
      $("#ModalLabel").html("Provide New Customer Information");
      $("#submit_button").html("Save");
      $("#add_customer_name").val("");
      $("#add_customer_address").val("");
      $("#add_customer_mobile_no").val("");
      $("#add_customer_email").val("");
    });


     // now we are going to  insert data 
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_edit_sell_product.php',
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



$("#customer_id").select2({ width: '100%' }); 
$("#product_id").select2({ width: '100%' }); 
</script>

</body>
</html>