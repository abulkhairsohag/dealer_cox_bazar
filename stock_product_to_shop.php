<?php include_once('include/header.php'); 

include_once("class/Database.php");
$dbOb = new Database();
?>


<?php 
if(!permission_check('stock_product_to_shop')){
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

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Stock Date </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="stock_date" name="stock_date" value='<?php echo date("d-m-Y") ?>' readonly="">
              </div>
            </div>


<!-- in the following div product info will be placed using ajax while changing the area  -->

                <div id="invoice_details">
                        <div class="form-group bg-success" style="padding-bottom: 5px;margin-top: 30px">

	              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
	               Give Packet Qty To The Following Products.....
	              </div>
	            </div>

	            <table class="table" class="">

	              <thead>
	                <tr>
	                  <th style="text-align: center;">Product ID</th>
	                  <th style="text-align: center;">Product Name</th>
	                  <th style="text-align: center;">Category</th>
	                  <th style="text-align: center;">Available(Pack)</th>
	                  <th style="text-align: center;">Quantity(Packet)</th>
	                  <th style="text-align: center;">Offer QTY(PCS)</th>
	                  <th style="text-align: center;">Sell Price</th>
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
                          </td>
                          <td>
                            <input type="number" min="0" step="1" class="form-control main_quantity quantity" name="quantity[]"  value="">
                          </td>
                          <td>
                            <input type="text" class="form-control main_quantity_offer quantity_offer" name="quantity_offer[]" readonly=""  value="">
                          </td>
                          <td>
                            <input type="number" min="0" class="form-control main_sell_price sell_price" name="sell_price[]" value="" >
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

            if (permission_check('stock_product_to_shop_save_button')) {
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
        url:'ajax_stock_product_to_shop.php',
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






 $(document).on('change','#ware_house_serial_no',function(){
     var ware_house_serial_no = $(this).val();
       $(".available").val("");
       $(".quantity").val("");
       $(".quantity_offer").val("");
       $(".sell_price").val("");
  });

  $(document).on('change keyup blur','.quantity',function(){
    var quantity = $(this).val();
     var tr = $(this).parent().parent();
     var product_id = tr.find(".product_id").val();
     var ware_house_serial_no  = $("#ware_house_serial_no").val();
    var available_qty  = tr.find(".available").val();

     if ( parseInt(available_qty) < parseInt(quantity)) {
             swal({
                title: 'warning',
                text: "The Quantity You Have Provided Is Out Of Stock..",
                icon: 'warning',
                button: "Done",
              });
             tr.find(".quantity").val("");
             tr.find(".quantity_offer").val("");
             tr.find(".sell_price").val("");
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
       $(".sell_price").val("");

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