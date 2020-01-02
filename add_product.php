<?php include_once 'include/header.php';?>


<?php
if (!permission_check('add_product')) {
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
           <?php
           if (permission_check('add_product')) {
            ?>
            <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Product</a>
          <?php }?>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-buttons" class="table table-striped table-bordered">
          <thead>

            <tr>
              <th style="width: 12px">#</th>
              <th style="width: 80px">Company</th>
              <th style="width: 70px">ID</th>
              <th style="width: 70px">Name</th>
              <th style="width: 80px">Category</th>
              <th style="width: 35px">Company Price</th>
              <th style="width: 35px">Sell Price</th>
              <th style="width: 35px">MRP</th>
              <th style="width: 35px">Pack Size</th>
              <th style="width: 210px;text-align: center;">Action</th>
            </tr>
          </thead>


          <tbody id="data_table_body">
            <?php
            include_once 'class/Database.php';
            $dbOb = new Database();
            $query = "SELECT * FROM products ORDER BY serial_no DESC";
            $get_products = $dbOb->select($query);
            if ($get_products) {
              $i = 0;
              while ($row = $get_products->fetch_assoc()) {
                $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo strtoupper($row['company']); ?></td>
                  <td><?php echo $row['products_id_no']; ?></td>
                  <td><?php echo $row['products_name']; ?></td>
                  <td><?php echo $row['category']; ?></td>
                  <td><?php echo $row['company_price']; ?></td>
                  <td><?php echo $row['sell_price']; ?></td>
                  <td><?php echo $row['mrp_price']; ?></td>
                  <td><?php echo $row['pack_size']; ?></td>

                  <td align="center">

                   <?php
                   if (permission_check('product_edit_button')) {
                    ?>
                    <a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                  <?php }?>

                  <?php
                  if (permission_check('product_stock_button')) {
                    ?>

                    <a class="badge bg-green stock_data" id="<?php echo ($row['products_id_no']) ?>"   data-toggle="modal" data-target="#stock_data_modal">Stock This Product </a>
                  <?php }?>


                  <?php
                  if (permission_check('product_delete_button')) {
                    ?>

                    <a  class="badge  bg-red delete_data" id="<?php echo ($row['products_id_no']) ?>"  style="margin:2px"> Delete</a>
                  <?php }?>



                  <?php
                  if (permission_check('product_view_button')) {
                    ?>

                    <a class="badge bg-orange view_details"  id="<?php echo $row['products_id_no'] ?>" data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a>
                  <?php }?>




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

<!-- Modal For stocking products data  -->
<div class="modal fade" id="stock_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title"  style="color: white">Provide Stock Information</h3>
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
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product ID </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="products_id_no_stock" name="products_id_no_stock" class="form-control col-md-7 col-xs-12" readonly="" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Name </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="products_name_stock" name="products_name_stock" class="form-control col-md-7 col-xs-12" readonly="" >
                    </div>
                  </div>


                  <div class="form-group" style="display:none">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Available Quantity
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" id="available_quantity" name="available_quantity"  class="form-control col-md-7 col-xs-12" readonly="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Quantity (Packet)<span class="required" style="color: red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" step="1"  required=""id="new_quantity" name="new_quantity"  class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>


                  <div class="form-group" style="display:none">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Total Quantity
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" id="total_quantity" name="total_quantity"  class="form-control col-md-7 col-xs-12" readonly="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Company Price
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" id="company_price_stock" name="company_price_stock"  class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock_date">Stock Date
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="stock_date" name="stock_date"  class="form-control col-md-7 col-xs-12 datepicker" value="" readonly="" required>
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
</div> <!-- End of modal for  stocking products data-->


<!-- Modal For Adding and Updating data  -->
<div class="modal fade" id="add_update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title" id="ModalLabelAdd" style="color: white"></h3>
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
                <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select required="" id="company" name="company" class="form-control col-md-7 col-xs-12" >
                        <option value="">Select a company name</option>
                        <?php
                        $query = "SELECT * FROM company ORDER BY company_name ";
                        $get_company_name = $dbOb->select($query);
                        if ($get_company_name) {
                          while ($row = $get_company_name->fetch_assoc()) {
                            ?>
                            <option value="<?php echo strtolower($row['company_name']) ?>"> <?php echo $row['company_name'] ?> </option>

                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Products Name<span class="required" style="color: red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text"  required=""id="products_name" name="products_name"  class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>



                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Category<span class="required" style="color: red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select name="category" id="category" required="" class="form-control col-md-7 col-xs-12">
                        <option value="">Select Category Name</option>
                        <?php
                        $query = "SELECT * FROM category ORDER BY category_name";
                        $get_category = $dbOb->select("$query");
                        if ($get_category) {
                          while ($row = $get_category->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['category_name']; ?>"><?php echo $row['category_name'] ?></option>

                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>



                  <div class="form-group" id="company_price_div">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company Price <span class="required" style="color: red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" step="0.01"  id="company_price" name="company_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group" id="company_price_div">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Sell Price <span class="required" style="color: red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" step="0.01"  id="sell_price" name="sell_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>



                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">MRP Price </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="0.01" id="mrp_price" name="mrp_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="pack_size" class="control-label col-md-3 col-sm-3 col-xs-12">Pack Size<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="1" required="" id="pack_size" name="pack_size" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group" id="quantity_div">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Quantity (Packet)<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="1" required="" id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>




                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" id="photo_label">Product Photo </label>
                    <div id="photo_div" class="col-md-6 col-sm-6 col-xs-12">
                      <input type="file" id="product_photo" name="product_photo" onchange="readURL(this)" class="form-control col-md-7 col-xs-12 ">
                    </div>
                    <img id="output_image"  src="#" alt="">

                  </div>


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" >
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


<!-- the following modal is for updating original price of product -->

<!-- End of update original price of a product -->

<!-- Modal For Showing data  -->
<div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " style="width: 700px" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header" style="background: #006666" align="center">
        <h3 class="modal-title" id="ModalLabel" style="color: white">Product Information In Detail</h3>

      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="">

              <div class="x_content" style="">
                <br />

                <div style="margin : 20px; color:black" id="info_table" class="col-md-12 text-dark">
                  <div class="col-md-6">

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Company Name : </h5></div>
                      <div class="col-md-6"><h5 id="company_name_show"></h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Product ID Number : </h5></div>
                      <div class="col-md-6"><h5 id="products_id_no_show"></h5></div>
                    </div>
                    <hr>


                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Products Name : </h5></div>
                      <div class="col-md-6"><h5 id="products_name_show"></h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Category : </h5></div>
                      <div class="col-md-6"><h5 id="category_show"></h5></div>
                    </div>
                    <hr>

                    
                     <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Description : </h5></div>
                      <div class="col-md-6"><h5 id="description_show"> </h5></div>
                    </div>
                    <hr>



                  </div> <!-- end of first row --->

                  <!-- Start of second row --->
                  <div class="col-md-6">


                  
                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Company Price : </h5></div>
                      <div class="col-md-6"><h5 id="company_price_show"> </h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>MRP Price : </h5></div>
                      <div class="col-md-6"><h5 id="mrp_price_show"> </h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Pack Size : </h5></div>
                      <div class="col-md-6"><h5 id="pack_size_show"> </h5></div>
                    </div>
                    <hr>

                    <!-- <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Total Buy Item (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="total_buy_item"> </h5></div>
                    </div>
                    <hr> -->



                  <!--   <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Total Sell (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="total_sold_item"> </h5></div>
                    </div>
                    <hr> -->

                    <!-- <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Return From Market (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="return_from_market"> </h5></div>
                    </div>
                    <hr> -->

                  <!--   <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Return To Company (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="return_to_company"> </h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>In Stock (QTY): </h5></div>
                      <div class="col-md-6"><h5 id="in_stock"> </h5></div>
                    </div>
                    <hr> -->

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Product Photo : </h5></div>
                      <div class="col-md-6"><h5 id="product_photo_show"> </h5></div>
                    </div>
                    <hr>

                   



                  </div>
                  <!-- end of second row --->

                </div>   <!-- End of info table  -->
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
</div> <!-- End of modal for  Showing data-->

<!-- /page content -->

</div>
</div>
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){

    // showing product information
    $(document).on('click','.view_details',function(){
      var products_id_no_view = $(this).attr("id");

      $.ajax({
        url:"ajax_companywise_prosuct_list.php",
        data:{products_id_no_view:products_id_no_view},
        type:"post",
        dataType:"json",
        success:function(data){
          $("#company_name_show").html(data.products_info.company);
          $("#products_id_no_show").html(data.products_info.products_id_no);
          $("#products_name_show").html(data.products_info.products_name);
          $("#category_show").html(data.products_info.category);
          $("#weight_show").html(data.products_info.weight);
          $("#color_show").html(data.products_info.color);
          $("#company_price_show").html(data.products_info.company_price+' ৳');
          $("#dealer_price_show").html(data.products_info.dealer_price);
          $("#mrp_price_show").html(data.products_info.mrp_price+' ৳');
          $("#pack_size_show").html(data.products_info.pack_size+` 's`);
          $("#marketing_sell_price_show").html(data.products_info.marketing_sell_price);
          $("#quantity_show").html(data.products_info.quantity);
          $("#barcode_show").html('<img src="https://barcode.tec-it.com/barcode.ashx?data='+data.products_info.products_id_no+'" alt="Photo Not Available" width="110px" >');
          $("#promo_offer_show").html(data.products_info.promo_offer);
          $("#offer_start_date_show").html(data.products_info.offer_start_date);
          $("#offer_end_date_show").html(data.products_info.offer_end_date);
          $("#product_photo_show").html('<img src="'+data.products_info.product_photo+'" alt="Photo Not Available" width="110px" >');
          $("#description_show").html(data.products_info.description);
          $("#total_buy_item").html(data.buy);
          $("#total_sold_item").html(data.sell);
          $("#return_from_market").html(data.return_from_market);
          $("#return_to_company").html(data.return_to_company);
          $("#in_stock").html(data.in_stock);



        }
      });
    });

    $(document).on('click','.edit_data',function(){

      $("#ModalLabelAdd").html("Update Product Information");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_add_product.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#company").val(data.company);
          $("#products_name").val(data.products_name);
          $("#category").val(data.category);
          $("#weight").val(data.weight);
          $("#color").val(data.color);
          // $("#company_price").val(data.company_price);
          $("#dealer_price").val(data.dealer_price);
          $("#marketing_sell_price").val(data.marketing_sell_price);
          $("#mrp_price").val(data.mrp_price);
          $("#pack_size").val(data.pack_size);
          $("#quantity").val(data.quantity);
          $("#quantity").val(data.quantity);
          $("#sell_price").val(data.sell_price);
       
          $("#edit_id").val(data.serial_no);

          $("#photo_div").removeClass();
          $("#photo_div").addClass("col-md-4 col-sm-4 col-xs-8");
          $("#photo_div").css("margin-top","50px");
          $("#photo_label").css("margin-top","50px");

          $("#output_image").show();
          $('#output_image')
          .attr('src', data.product_photo)
          .width(128)
          .height(120);

          $("#quantity_div").hide();
          $("#quantity_div").val("");
          $("#quantity").attr('required',false);

          $("#company_price").val("");
          $("#company_price").attr('required',false);
          $("#company_price_div").hide();
          $(".ware_house_serial_no_main").attr('required',false);
          $("#warehouse_div").hide();


        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabelAdd").html("Add Product Information");
      $("#submit_button").html("Save");

      $("#company").val("");
      $("#products_name").val("");
      $("#category").val("");
      $("#weight").val("");
      $("#color").val("");
      $("#company_price").val("");
      $("#dealer_price").val("");
      $("#marketing_sell_price").val("");
      $("#marketing_sell_price").val("");
      $("#mrp_price").val("");
      $("#pack_size").val("");
      $("#quantity").val("");
      $("#promo_offer").val("");
      $("#offer_start_date").val("");
      $("#offer_end_date").val("");
      $("#product_photo").val("");
      $("#edit_id").val("");

      $("#photo_div").removeClass();
      $("#photo_div").addClass("col-md-6 col-sm-6 col-xs-12");
      $("#output_image").hide();
      $("#photo_div").css("margin-top","0px");
      $("#photo_label").css("margin-top","0px");
      $("#quantity_div").show();
      $("#quantity").attr('required',true);

      $("#company_price").val("");
      $("#company_price").attr('required',true);
      $("#company_price_div").show();
      $("#warehouse_div").show();
      $(".ware_house_serial_no_main").val('');
      $(".ware_house_serial_no_main").attr('required',true);

    });

      // now we are going to update and insert data
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_add_product.php',
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
              $("#add_update_modal").modal("hide");
              get_data_table();
            }
          }
        });
    }); // end of insert and update



        // now update original price
        $(document).on('submit','#update_original_price_form',function(e){
          e.preventDefault();
          var formData = new FormData($("#update_original_price_form")[0]);
          formData.append('submit_original_price','submit_original_price');

          $.ajax({
            url:'ajax_add_product.php',
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
                $("#update_original_price_modal").modal("hide");
                get_data_table();
              }
            }
          });
    }); // end of update original price





      // this time we are adding new stock
      $(document).on('submit','#form_stock_data',function(event){
        event.preventDefault();
        var formDataStock = new FormData($("#form_stock_data")[0]);
        formDataStock.append('submit_stock','submit_stock');

        $.ajax({
          url:'ajax_add_product.php',
          data:formDataStock,
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
              $("#new_quantity").val("");
              $("#stock_date").val("");
              $("#stock_data_modal").modal("hide");
              get_data_table();
            }
          }
        });
      });

    //delete data by id
    $(document).on('click','.delete_data',function(){
      var serial_no_delete = $(this).attr("id");
      swal({
        title: "Are you sure to delete?",
        text: "Once deleted, all related information will be lost!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({
            url:"ajax_add_product.php",
            data:{serial_no_delete:serial_no_delete},
            type:"POST",
            dataType:'json',
            success:function(data){
              swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
              get_data_table();
            }
          });

        }
      });

  }); // end of delete

    //getting and setting data for adding stock.
    $(document).on('click','.stock_data',function(){
      var get_products_id_no_stock = $(this).attr("id");
      $.ajax({
        url:"ajax_add_product.php",
        data:{get_products_id_no_stock:get_products_id_no_stock},
        type:"post",
        dataType:"json",
        success:function(data){
          $("#products_id_no_stock").val(data.products_id_no);
          $("#products_name_stock").val(data.products_name);
          $("#available_quantity").val(data.quantity);
          $("#total_quantity").val(data.quantity);
          $("#company_price_stock").val(data.company_price);
        }
      });
    });

  // calculating total number of avaulable product after adding new stock
  $(document).on('keyup blur change','#new_quantity',function(){
    var new_quantity = $(this).val();
    var available_quantity = $("#available_quantity").val();
    if (isNaN(new_quantity) || new_quantity == "") {
      new_quantity = 0;
    }
    var total_quantity = parseInt(available_quantity) + parseInt(new_quantity);
    $("#total_quantity").val(total_quantity);
  });

  $(document).on('click','.original_price',function(){
    var serial_no_edit  = $(this).attr('id');
    $("#original_price").val('');
    $.ajax({
      url:"ajax_add_product.php",
      data:{serial_no_edit:serial_no_edit},
      type:"POST",
      dataType:"json",
      success:function(data){
        $("#product_id_orig_price").val(data.serial_no);
        $("#original_price").val(data.actual_purchase_price);

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

  }); // end of document ready function

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_add_product.php",
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
// the following function is for image preview
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#photo_div").removeClass();
      $("#photo_div").addClass("col-md-4 col-sm-4 col-xs-8");
      $("#photo_div").css("margin-top","50px");
      $("#photo_label").css("margin-top","50px");
      $('#output_image')
      .show()
      .attr('src', e.target.result)
      .width(128)
      .height(120);

    };

    reader.readAsDataURL(input.files[0]);
  }
}

</script>

</body>
</html>