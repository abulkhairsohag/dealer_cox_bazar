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
          <h2>Offer Product List</h2>
          <div class="row float-right" align="right">
           <?php
           if (permission_check('add_product')) {
            ?>
            <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Offer Product</a>
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
              <th style="width: 35px">Pack Size</th>
              <th style="width: 35px">Available QTY(PCS)</th>
              <th style="width: 35px">Ware House</th>
              <!-- <th style="width: 80px">Barcode</th> -->
              <th style="width: 210px;text-align: center;">Action</th>
            </tr>
          </thead>


          <tbody id="data_table_body">
            <?php
            include_once 'class/Database.php';
            $dbOb = new Database();
            $query = "SELECT * FROM offered_products ORDER BY serial_no DESC";
            $get_products = $dbOb->select($query);
            if ($get_products) {
              $i = 0;
              while ($row = $get_products->fetch_assoc()) {
                $i++;
                $products_id = $row['products_id'];
                $query= "SELECT * FROM products WHERE products_id_no = '$products_id' ";
                $get_product_details = $dbOb->select($query);
                 $product_details = '';
                if ($get_product_details) {
                  $product_details = $get_product_details->fetch_assoc();
                }
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo strtoupper($product_details['company']); ?></td>
                  <td><?php echo $row['products_id']; ?></td>
                  <td><?php echo $product_details['products_name']; ?></td>
                  <td><?php echo $product_details['category']; ?></td>
                  
                  <td><?php echo $product_details['pack_size']; ?></td>
                  <td><?php echo $row['available_qty']; ?></td>
                  <td><?php echo $row['ware_house_name']; ?></td>
                

                  <td align="center">

             

                  <?php
                  if (permission_check('product_stock_button')) {
                    ?>

                    <a class="badge bg-green stock_data" id="<?php echo ($row['products_id']) ?>"   data-toggle="modal" data-target="#stock_data_modal">Stock This Product </a>
                  <?php }?>


                  <?php
                  if (permission_check('product_delete_button')) {
                    ?>

                    <a  class="badge  bg-red delete_data" id="<?php echo ($row['products_id']) ?>"  style="margin:2px"> Delete</a>
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
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Select Product <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select required="" id="products_id" name="products_id" class="form-control col-md-7 col-xs-12" >ware_house_serial_no
                        <option value="">Select a Product</option>
                        <?php
                        $query = "SELECT * FROM products";
                        $get_products = $dbOb->select($query);
                        if ($get_products) {
                          while ($row = $get_products->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['products_id_no'] ?>"> <?php echo $row['products_id_no'].', '.$row['products_name'] ?> </option>

                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>



                  <div class="form-group" id="quantity_div">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Quantity<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="1" required="" id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" placeholder="Product QTY Not Packet QTY">
                    </div>
                  </div>

                  <div class="form-group row">
    <label class="col-md-3 col-6 control-label" for="inputDefault">Select Ware House<span class="required" style="color: red">*</span></label>
    <div class="col-md-6 col-6">
        <select name="ware_house_serial_no" id="ware_house_serial_no"  required="" class="form-control ware_house_serial_no col-md-7 col-xs-12 ">
          
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


                  <div class="form-group" id="">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Stock Date<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       
         <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="" required="" readonly="">
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
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){

  

 

    $(document).on('click','#add_data',function(){
      $("#ModalLabelAdd").html("Add Offer Product");
      $("#submit_button").html("Save");

      $("#products_id").val("");
      $("#quantity").val("");
      $("#ware_house_serial_no").val("");
      $("#stock_date").val("");
      $("#edit_id").val("");

    });

      // now we are going to update and insert data
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_add_offer_product.php',
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



      // this time we are adding new stock
      $(document).on('submit','#form_stock_data',function(event){
        event.preventDefault();
        var formDataStock = new FormData($("#form_stock_data")[0]);
        formDataStock.append('submit_stock','submit_stock');

        $.ajax({
          url:'ajax_add_offer_product.php',
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
            url:"ajax_add_offer_product.php",
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
        url:"ajax_add_offer_product.php",
        data:{get_products_id_no_stock:get_products_id_no_stock},
        type:"post",
        dataType:"json",
        success:function(data){
          $("#products_id_stock").val(data.products_id);
          $("#products_name_stock").val(data.products_name);
          $("#available_quantity").val(data.available_qty);
          $("#total_quantity").val(data.available_qty);
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



  }); // end of document ready function

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_add_offer_product.php",
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