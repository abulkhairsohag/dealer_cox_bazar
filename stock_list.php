<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('stock_list')){
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
          <h2>Product List</h2>
          <div class="row float-right" align="right">
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-buttons" class="table table-striped table-bordered">
          <thead>

            <tr>
              <th style="width: 12px" >#</th>
              <th style="width: 100px">ID</th>
              <th style="width: 150px">Name</th>
              <th style="width: 150px">Ware House</th>
              <th style="width: 100px">Stock Qty</th>
              <th style="width: 100px">Company Price</th>
              <th style="width: 100px">Total Amt(Taka)</th>
              <th >Stock Date</th>
              <th >Action</th>
            </tr>
          </thead>


          <tbody id="data_table_body">
            <?php 
            include_once('class/Database.php');
            $dbOb = new Database();
            $query = "SELECT * FROM products";
            $products = $dbOb->select($query);
            $stock_serial_no = [];
            if ($products) {
                $j = 0;
                while ($prod = $products->fetch_assoc()) {
                    $products_id = $prod['products_id_no'];
                    $query = "SELECT * FROM product_stock WHERE quantity > 0 AND products_id_no = '$products_id' ORDER BY serial_no DESC";
                    $get_stock_info = $dbOb->select($query);
                    if ($get_stock_info) {
                        $stock_serial_no[$j] = $get_stock_info->fetch_assoc()['serial_no'];
                        $j++;
                    }
                }
            }

            if (Session::get("ware_house_serial_login")){
              if (Session::get("ware_house_serial_login") != '-1') {
                $ware_house_serial = Session::get("ware_house_serial_login");
                $query = "SELECT * FROM product_stock WHERE quantity > 0 AND ware_house_serial_no = '$ware_house_serial' ORDER BY serial_no DESC";
              }
            }else{
              $query = "SELECT * FROM product_stock WHERE quantity > 0 ORDER BY serial_no DESC";
            }
            $get_products = $dbOb->select($query);
            if ($get_products) {
              $i=0;
              while ($row = $get_products->fetch_assoc()) {
                  $products_id = $row['products_id_no'];
                  $query = "SELECT * FROM products WHERE products_id_no = '$products_id'";
                  $get_info = $dbOb->select($query);
                  $product_name = '';
                  if ($get_info) {
                      $product_name = $get_info->fetch_assoc()['products_name'];
                  }
                $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $products_id; ?></td>
                  <td><?php echo $product_name; ?></td>
                  <td><?php echo $row['ware_house_name']; ?></td>
                  <td><?php echo $row['quantity']; ?></td>
                  <td><?php echo $row['company_price']; ?></td>
                  <td><?php echo $row['company_price'] * $row['quantity']; ?></td>
                  <td><?php echo $row['stock_date']; ?></td>

                  <td align="center">
                   <?php 
                    if (in_array($row['serial_no'], $stock_serial_no)) {

                    if(permission_check('sale_product_edit_button')){
                      ?>
                    <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#stock_data_modal" style="margin:2px">Edit</a>
                  <?php } }?>
                  
                </td>
                
              </tr>

              <?php
            }
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- Modal For Updating quantity  -->
<div class="modal fade" id="stock_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title"  style="color: white">Update Stock Information</h3>
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
                <form id="form_stock_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                  

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Quantity<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" id="quantity" name="quantity" class="form-control col-md-7 col-xs-12"  required>
                    </div>
                  </div>
                  
                  <div class="form-group" style="display:none"> 
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Existing Quantity<span class="required" style="color: red">*</span> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" id="existing_quantity" name="existing_quantity" class="form-control col-md-7 col-xs-12"  required>
                    </div>
                  </div>
                  
                  <div class="form-group" style="display:none">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product ID<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="products_id_no" name="products_id_no" class="form-control col-md-7 col-xs-12"  required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company Price<span class="required" style="color: red">*</span> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" id="company_price" name="company_price" class="form-control col-md-7 col-xs-12"  required>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock_date">Stock Date
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="stock_date" name="stock_date"  class="form-control col-md-7 col-xs-12 datepicker" value="" readonly="" required>
                    </div>
                  </div>


                  <div class="form-group" style="display:none">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="serial_no_edit">
                    Serial No Edit
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="serial_no_edit" name="serial_no_edit"  class="form-control col-md-7 col-xs-12 " value="" readonly="" required>
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <button type="submit" class="btn btn-success" id="submit_button_stock">Save New Quantity</button>
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

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){
      var serial_no_edit = $(this).attr("id");
      $.ajax({
        url:"ajax_edit_stock.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#quantity").val(data.quantity);
          $("#existing_quantity").val(data.quantity);
          $("#products_id_no").val(data.products_id_no);
          $("#company_price").val(data.company_price);
          $("#ware_house_serial_no").val(data.ware_house_serial_no);
          $("#stock_date").val(data.stock_date);
          $("#serial_no_edit").val(serial_no_edit);
        }
      });
    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_stock_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_stock_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_edit_stock.php',
          data:formData,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
            if (data.type == 'success') {
              $("#stock_data_modal").modal("hide");
              get_data_table();
            }
          }
        });
    }); // end of insert and update 
  
  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_edit_stock.php",
    data:{'sohag':'sohag'},
    type:"POST",
    dataType:"text",
    success:function(data_tbl){
      sohag.destroy();
      $("#data_table_body").html(data_tbl);
      init_DataTables();
    }
  });
}
</script>
</body>
</html>