<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('company_product_return')){
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
          <h2>Product List (Which Are Returned To Company)</h2>
          <div class="row float-right" align="right">

            <?php 
            if (permission_check('return_product_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Return Product</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="">#</th>
                <th style="">Product ID</th>
                <th style="">Product Name</th>
                <th style="">Company</th>
                <th style="">Dealer Price</th>
                <th style="">Return Qty</th>
                <th style="">Price</th>
                <th style="">Reason</th>
                <th style="">Description</th>
                <th style="">Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM company_products_return ORDER BY serial_no DESC";
              $get_return_products = $dbOb->select($query);
              if ($get_return_products) {
                $i=0;
                while ($row = $get_return_products->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo strtoupper($row['products_id_no']); ?></td>
                    <td><?php echo $row['products_name']; ?></td>
                    <td><?php echo $row['company']; ?></td>
                    <td><?php echo $row['dealer_price']; ?></td>
                    <td><?php echo $row['return_quantity']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['return_reason']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                    <td align="center">


                      <?php 
                      if (permission_check('return_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>


                      <?php 
                      if (permission_check('return_delete_button')) {
                        ?>

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
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


                      <div class="form-group" id="products_id_div">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product ID <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="products_id_no" id="products_id_no" class="form-control col-md-7 col-xs-12" required="">
                            <option value=""></option>
                            <?php 
                            include_once("class/Database.php");
                            $dbOb = new Database();
                            $query = "SELECT * FROM `products` ORDER BY products_name";
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
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Per Dealer Price </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id="dealer_price" name="dealer_price" class="form-control col-md-7 col-xs-12" readonly="">
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



    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Return Product Information.");
      $("#submit_button").html("Update");

      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_company_product_return.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#products_id_no").val(data.return_info.products_id_no);
          $("#products_id_div").hide();
          $("#products_name").val(data.return_info.products_name);
          $("#company").val(data.return_info.company);
          $("#current_quantity").val(data.current_quantity);
          $("#dealer_price").val(data.return_info.dealer_price);
          $("#return_quantity").val(data.return_info.return_quantity);
          $("#total_price").val(data.return_info.total_price);
          $("#return_reason").val(data.return_info.return_reason);
          $("#description").val(data.return_info.description);
          $("#edit_id").val(data.return_info.serial_no);
          // alert(data.current_quantity);
        }
      });

    });

    $(document).on('click','#add_data',function(){

      $("#ModalLabel").html("Add Return Product Information.");
      $("#submit_button").html("Save");

      $("#products_id_div").show();
      $("#products_id_no").val("");
      $("#products_name").val('');
      $("#company").val('');
      $("#current_quantity").val('');
      $("#dealer_price").val('');
      $("#return_quantity").val('');
      $("#total_price").val('');
      $("#return_reason").val('');
      $("#description").val('');
      $("#edit_id").val('');
      

    });

    // getting data while changing the product id
    $(document).on('change','#products_id_no',function(){
      //console.log('Sohag');
      var get_products_id_no = $(this).val();
      $.ajax({
        url: "ajax_company_product_return.php",
        data:{get_products_id_no:get_products_id_no},
        type: "POST",
        dataType:'json',
        success:function(data){
          $("#products_name").val(data.products_name);
          $("#company").val(data.company);
          $("#current_quantity").val(data.quantity);
          $("#dealer_price").val(data.company_price);
          return_quty_test(); 
          cal();
        }
      });
      
    });

// now calculating the total price while key up at return quantity 
$(document).on("keyup blur","#return_quantity",function(){
  return_quty_test();
  cal();
});
      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_company_product_return.php',
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
            url:"ajax_company_product_return.php",
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


  });

//the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_company_product_return.php",
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

// calculating the total price of the return quantity
function cal(){
  var dealer_price = $("#dealer_price").val();
  var return_quantity = $("#return_quantity").val();

  var total_price = dealer_price * return_quantity;
  $("#total_price").val(total_price);
}

// Checking if the return quantity is more than the available quantity
function return_quty_test(){
  var current_quantity = parseInt( $("#current_quantity").val());
  var return_quantity = parseInt($("#return_quantity").val());

  if ( return_quantity >  current_quantity) {
    swal({
      title: "warning",
      text: "You Can't Return Product More Than The Current Quantity",
      icon: "warning",
      button: "OK",
    });
    $("#return_quantity").val("0");
  }

  if ( return_quantity < 0) {
    swal({
      title: "warning",
      text: "Negative Return Quantity Is Not Allowed.",
      icon: "warning",
      button: "OK",
    });
    $("#return_quantity").val("0");
  }

}

</script>

</body>
</html>