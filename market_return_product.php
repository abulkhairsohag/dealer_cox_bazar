<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('return_sold_product_from_market')){
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
          <h2>Product List (Which Are Returned From Market)</h2>
          <div class="row float-right" align="right">


            <?php 
            if (permission_check('return_product_button')) {

              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Return Product</a>
              
            <?php } ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th style="">Product ID</th>
                  <th style="">Product Name</th>
                  <th style="">Company</th>
                  <th style="">Shop</th>
                  <th style="">Marketing<br/>Sell Price</th>
                  <th style="">Return Qty</th>
                  <th style="">Price</th>
                  <th style="">Unloaded ?</th>
                  <th style="">Reason</th>
                  <th style="">Date</th>
                  <th style="text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody id="data_table_body">
                <?php
                include_once('class/Database.php');
                $dbOb = new Database();
                $query = "SELECT * FROM market_products_return ORDER BY serial_no DESC";
                $get_return_products = $dbOb->select($query);
                if ($get_return_products) {
                  $i=0;
                  while ($row = $get_return_products->fetch_assoc()) {
                    $i++;
                    if ($row['unload_status'] == '1') {
                      $unload_status = 'Yes';
                      $background = 'green';
                    }else{
                      $unload_status = 'No';
                      $background = 'red';
                    }
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo strtoupper($row['products_id_no']); ?></td>
                      <td><?php echo $row['products_name']; ?></td>
                      <td><?php echo $row['company']; ?></td>
                      <td><?php echo $row['shop_name']; ?></td>
                      <td><?php echo $row['marketing_sell_price']; ?></td>
                      <td><?php echo $row['return_quantity']; ?></td>
                      <td><?php echo $row['total_price']; ?></td>
                      <td><span style="color: white" class="badge bg-<?php echo($background) ?>"><?php echo($unload_status) ?></span></td>
                      <td><?php echo $row['return_reason']; ?></td>
                      <td><?php echo $row['return_date']; ?></td>
                      <td align="center">


                        <?php 
                        if (permission_check('return_product_edit_button')) {

                          ?>
                          <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                        <?php } ?>

                        <?php 
                        if (permission_check('return_product_delete_button')) {

                          ?>
                          <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                        <?php } ?>

                        <?php 
                        if (permission_check('return_product_view_button')) {

                          ?>
                          <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 
                        <?php } ?>

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
      <!-- Modal For Adding and Updating data  -->
      <div class="modal fade" id="add_update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group bg-success" style="padding-bottom: 5px; ">
                          <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                            Delivery Employee Information
                          </div>
                        </div>
                        <!-- the following section is for delivery enployee informaiton  -->
                        <div class="col-md-12" style="margin-bottom: 30px;width: 100%" align="center" >
                          <table style="width: 100%">
                            <thead>
                              <tr>
                                <th style="text-align: center;padding-bottom: 10px; color: red">Employee ID</th>
                                <th style="text-align: center;padding-bottom: 10px; color: red">Employee Name</th>
                                <th style="text-align: center;padding-bottom: 10px; color: red">Area</th>
                                <!-- <th style="text-align: center;padding-bottom: 10px; color: red">Company</th> -->
                                <th style="text-align: center;padding-bottom: 10px; color: red">Return Date</th>
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
                  <input type="text" class="form-control " id="employee_id_delivery" name="employee_id_delivery" readonly="" value="<?php echo($get_duty_employee['id_no']) ?>" >
                </td>
                <td>
                  <input type="text" class="form-control" id="employee_name_delivery" name="employee_name_delivery" readonly="" value="<?php echo $employee_name ?>" >
                </td>
                <td>
                  <select name="area_employee_delivery" id="area_employee_delivery"  required="" class="form-control">
                    <option value="">Please Select</option>
                    <?php 
                    
                      $query = "SELECT * FROM area";
                      $get_area = $dbOb->select($query);
                      if ($get_area) {
                        while ($row = $get_area->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['area_name'];?>"><?php echo $row['area_name'];?></option>
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
                <input type="text"  class="form-control date-picker datepicker" id="delivery_date" name="delivery_date" readonly="" value="" required>
                </td>
              </tr>
                    <?php }else{
                      // this else section is for admin. if admin wants to take a order then he will work in this section
                        ?>
              <tr>
                <td>
                  
                  <select name="employee_id_delivery" id="employee_id_delivery" class="form-control" required>
                    <option value="">Please Select Employee</option>
                    <?php
                       $query = "SELECT * from employee_main_info where  active_status = 'Active'";
                       $get_sales_man = $dbOb->select($query);
                       if ($get_sales_man) {
                         while ($emp = $get_sales_man->fetch_assoc()) {
                           ?>
                             <option value="<?php echo $emp['id_no']?>"><?php echo $emp['id_no'].', '.$emp['name']?></option>
                           <?php
                         }
                       }
                    ?>
                  </select>
                </td>
                <td>
                  <input type="text" class="form-control" id="employee_name_delivery" name="employee_name_delivery" readonly="" value="" >
                </td>
                <td>
                  <select name="area_employee_delivery" id="area_employee_delivery"  required="" class="form-control">
                    <option value="">Please Select</option>
                    <?php 
                    
                      $query = "SELECT * FROM area";
                      $get_area = $dbOb->select($query);
                      if ($get_area) {
                        while ($row = $get_area->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['area_name'];?>"><?php echo $row['area_name'];?></option>
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
                <input type="text"  class="form-control date-picker datepicker" id="delivery_date" name="delivery_date" readonly="" value="" required>
                </td>
              </tr>

<?php


                    } ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- end of delivery employee informaiton  -->
                        <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">
                          <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                            Product Return Information
                          </div>
                        </div>
                        <div class="form-group" id="product_id_div">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product ID <span class="required" style="color: red">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="products_id_no" id="products_id_no" class="form-control col-md-7 col-xs-12" required="">
                              <option value=""></option>
                              <?php
                              $query = "SELECT * FROM `products`";
                              $get_products = $dbOb->select($query);
                              if ($get_products) {
                                while ($row = $get_products->fetch_assoc()) {
                                  ?>
                                  <option value="<?php echo($row['products_id_no']); ?>"><?php echo $row['products_id_no'].", ".$row['products_name'].", ".$row['company']; ?></option>
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
                            <input type="text" id="products_name" name="products_name"  class="form-control col-md-7 col-xs-12" readonly="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company Name  </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="company" name="company" class="form-control col-md-7 col-xs-12" readonly="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Current Quantity</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="current_quantity" name="current_quantity" class="form-control col-md-7 col-xs-12" readonly="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Marketing Sell Price </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  id="marketing_sell_price" name="marketing_sell_price" class="form-control col-md-7 col-xs-12" readonly="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Return Quantity <span class="required" style="color: red">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" step="1"  id="return_quantity" name="return_quantity" class="form-control col-md-7 col-xs-12" required="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Price</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" required="" id="total_price" name="total_price" class="form-control col-md-7 col-xs-12" readonly="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Return Reason<span class="required" style="color: red">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="return_reason" id="return_reason" class="form-control col-md-7 col-xs-12" required="">
                              <option value="">Select A Reason</option>
                              <option value="Product Damage">Product Damage</option>
                              <option value="Manufacture Date Expire">Manufacture Date Expire</option>
                              <option value="Close Shop">Close Shop</option>
                              <option value="Payment Problem">Payment Problem</option>
                              <option value="Order Minimize">Order Minimize</option>
                              <option value="Others">Others</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Describe Reason</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input  type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" >
                          </div>
                        </div>

                        
        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Select Customer<span class="required" style="color: red">*</span></label>
          <div class="col-md-6">
            <select class="form-control" id="cust_id" name="cust_id" required="">
              <option value="">Select Area First</option>
            
            <?php 
            $query = "SELECT * FROM client WHERE area_name = '$duty_employee_area'";
            $get_client = $dbOb->select($query);
            if ($get_client) {
              while ($row =  $get_client->fetch_assoc()) {
                ?>
                  <option value="<?php echo $row['cust_id']?>"><?php echo $row['client_name']?></option>
                <?php
              }
            }
            ?>
            </select>
          </div>
        </div>


                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shop Name <span class="required" style="color: red">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  id="shop_name" name="shop_name" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shop Phone Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="shop_phn" name="shop_phn" class="form-control col-md-7 col-xs-12" >
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





      <!-- Modal For Showing data  -->
      <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="width: 700px" role="document">
          <div class="modal-content modal-lg">
            <div class="modal-header" style="background: #006666">
              <h3 class="modal-title" id="ModalLabel" style="color: white">Product Return Information (From Market)</h3>
              <div style="float:right;">

              </div>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel" style="background: #f2ffe6">

                    <div class="x_content" style="background: #f2ffe6">
                      <br />

                      <div class="row"><div class="col"> <h3 style="color:blue">EMPLOYEE AND SHOP INFORMATION</h3><hr></div></div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">ID </h5></div>
                        <div class="col-md-3" style="color: black"><h5 id="employee_id" ></h5></div>
                        <div class="col-md-3"></div>
                      </div>


                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Name</h5></div>
                        <div class="col-md-3" ><h5 id="employee_name" style="color:black"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Area</h5></div>
                        <div class="col-md-3"><h5 id="employee_area" style="color:black"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Shop Name</h5></div>
                        <div class="col-md-3"><h5 id="show_shop_name" style="color:black"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Shop Name</h5></div>
                        <div class="col-md-3"><h5 id="show_shop_phn" style="color:black"></h5></div>
                        <div class="col-md-3"></div>
                      </div>



                      <!-- now showing product return Information -->
                      <div class="row" style="margin-top: 30px;"><div class="col"> <h3 style="color: blue">RETURNED PRODUCT INFORMATION</h3><hr></div></div>




                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">ID</h5></div>
                        <div class="col-md-3"><h5 id="products_id_show" style="color:black"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Name</h5></div>
                        <div class="col-md-3"><h5 id="products_name_show" style="color:black"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Company Name</h5></div>
                        <div class="col-md-3"><h5 id="products_company_show" style="color:black"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:blue">Marketing Sell Price</h5></div>
                        <div class="col-md-3"><h5 id="marketing_sell_price_show" style="color:red"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:blue">Return Quantity</h5></div>
                        <div class="col-md-3"><h5 id="return_quantity_show" style="color:red"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:blue">Total Price</h5></div>
                        <div class="col-md-3"><h5 id="total_price_show" style="color:red"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Return Reason</h5></div>
                        <div class="col-md-3"><h5 id="return_reason_show" style="color:black"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Description</h5></div>
                        <div class="col-md-3"><h5 id="description_show" style="color:black"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:0px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:blue">Return Date</h5></div>
                        <div class="col-md-3"><h5 id="return_date_show" style="color:red"> </h5></div>
                        <div class="col-md-3"></div>
                      </div>

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
</div>
<?php include_once('include/footer.php'); ?>
<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){
      $("#ModalLabel").html("Update Return Product Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");
      $.ajax({
        url:"ajax_market_return_product.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#products_id_no").val(data.info.products_id_no);
          $("#product_id_div").hide();
          $("#products_name").val(data.info.products_name);
          $("#company").val(data.info.company);
          $("#current_quantity").val(data.current_quantity);
          $("#marketing_sell_price").val(data.info.marketing_sell_price);
          $("#return_quantity").val(data.info.return_quantity);
          $("#total_price").val(data.info.total_price);
          $("#return_reason").val(data.info.return_reason);
          $("#description").val(data.info.description);
          $("#shop_name").val(data.info.shop_name);
          $("#shop_phn").val(data.info.shop_phn);
          $("#edit_id").val(data.info.serial_no);
        }
      });
    });


    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add Return Product Information.");
      $("#submit_button").html("Save");
      $("#products_id_no").val('');
      $("#product_id_div").show();
      $("#products_name").val('');
      $("#company").val('');
      $("#current_quantity").val('');
      $("#marketing_sell_price").val('');
      $("#return_quantity").val('');
      $("#total_price").val('');
      $("#return_reason").val('');
      $("#description").val('');
      $("#edit_id").val('');
      $("#shop_phn").val('');
      $("#shop_name").val('');

    });


  // getting data while changing the product id
  $(document).on('change','#products_id_no',function(){
  //console.log('Sohag');
  var get_products_id_no = $(this).val();
  $.ajax({
    url: "ajax_market_return_product.php",
    data:{get_products_id_no:get_products_id_no},
    type: "POST",
    dataType:'json',
    success:function(data){
      $("#products_name").val(data.product_info.products_name);
      $("#company").val(data.product_info.company);
      $("#current_quantity").val(data.product_info.quantity);
      $("#marketing_sell_price").val(data.sell_price);
      cal();
    }
  });
  
});
  // now calculating the total price while key up at return quantity
  $(document).on("keyup blur","#return_quantity",function(){
    cal();
  });
  // now we are going to update and insert data
  $(document).on('submit','#form_edit_data',function(e){
    e.preventDefault();
    var formData = new FormData($("#form_edit_data")[0]);
    formData.append('submit','submit');
    $.ajax({
      url:'ajax_market_return_product.php',
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
          url:"ajax_market_return_product.php",
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

  // the following section is for showing data 
  $(document).on('click','.view_data',function(){
    var view_id = $(this).attr("id");
    // alert(view_id);
    // console.log(view_id);
    $.ajax({
      url:"ajax_market_return_product.php",
      data:{view_id:view_id},
      type:"POST",
      dataType:'json',
      success:function(data){
       $("#employee_id").html(data.employee_id_delivery);
       $("#employee_name").html(data.employee_name_delivery);
       $("#employee_area").html(data.area_employee_delivery);
       $("#show_shop_name").html(data.shop_name);
       $("#show_shop_phn").html(data.shop_phn);

       $("#products_id_show").html(data.products_id_no);
       $("#products_name_show").html(data.products_name);
       $("#products_company_show").html(data.company);
       $("#marketing_sell_price_show").html(data.marketing_sell_price);
       $("#return_quantity_show").html(data.return_quantity);
       $("#total_price_show").html(data.total_price);
       $("#return_reason_show").html(data.return_reason);
       $("#description_show").html(data.description);
       $("#return_date_show").html(data.return_date);
     }
   });

  });

  $(document).on('change','#area_employee_delivery',function(){
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
          $("#shop_phn").val(data.mobile_no);
        }
      });
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



  //the following function is defined for showing data into the table
  function get_data_table(){
    $.ajax({
      url:"ajax_market_return_product.php",
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
  
  function cal(){
    var marketing_sell_price = $("#marketing_sell_price").val();
    var return_quantity = $("#return_quantity").val();
    var total_price = marketing_sell_price * return_quantity;
    $("#total_price").val(parseInt(total_price));
  }
</script>
</body>
</html>