<?php include_once 'include/header.php';?>

<?php
if (!permission_check('offer_setup')) {
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
          <h2>Offer List</h2>
          <div class="row float-right" align="right">

            <?php

            if (permission_check('add_new_offer')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Offer</a>
              <?php
            }
            ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th  style="text-align: center;">Sl No.</th>
                <th  style="text-align: center;">Product ID</th>
                <th  style="text-align: center;">Name</th>
                <th  style="text-align: center;">With Packet</th>
                <th  style="text-align: center;">Offer Qty</th>
                <th  style="text-align: center;">Starts</th>
                <th  style="text-align: center;">Ends</th>
                <th  style="text-align: center;">Status</th></th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="tbl_body">
              <?php
              include_once "class/Database.php";
              $dbOb = new Database();
              $query = "SELECT * FROM offers ORDER BY serial_no DESC";
              $get_offers = $dbOb->select($query);
              if ($get_offers) {
                $i = 0;
                while ($row = $get_offers->fetch_assoc()) {
                  $products_id = $row['products_id'];
                  $query = "SELECT * FROM products WHERE products_id_no = '$products_id'";
                  $get_prod_name = $dbOb->select($query);
                  $products_name = '';
                  if ($get_prod_name) {
                    $products_name = $get_prod_name->fetch_assoc()['products_name'];
                  }
                  if ($row['status'] == 1) {
                    $badge = " bg-green";
                    $status = "Active";
                  }else if($row['status'] == 0){
                    $badge = " bg-red";
                    $status = "Inactive";
                  }else{
                    $badge = " bg-orange";
                    $status = "Expired";
                  }
                  $today = date('d-m-Y');
                  $serial_no = $row['serial_no'];
                  if (strtotime($row['to_date']) < strtotime($today)) {
                    $query = "UPDATE offers set status = '3' where serial_no = '$serial_no'";
                    $update = $dbOb->update($query);
                    $badge = " bg-orange";
                    $status = "Expired";

                  }
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['products_id'] ?></td>
                    <td><?php echo $products_name ?></td>
                    <td><?php echo $row['packet_qty'] ?></td>
                    <td><?php echo $row['product_qty']; ?></td>
                    <td><?php echo $row['from_date'] ?></td>
                    <td><?php echo $row['to_date'] ?></td>
                    <td> <span class="<?php echo $badge?>"> <?php echo $status; ?> </span></td>
                    <td align="center">


                     <?php
                     if (permission_check('offer_edit_button')) {
                      ?>
                      <a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                      <?php
                    }
                    if (permission_check('offer_delete_button')) {
                      ?>
                      <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>

                      <?php
                    }

                    ?>
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
                  <!-- Form starts from here -->
                  <form id="form_edit_data" method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">



                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Select Product <span class="required" style="color: red">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select required="" id="products_id" name="products_id" class="form-control col-md-7 col-xs-12" >
                          <option value="">Select a Product</option>
                          <?php
                          $query = "SELECT * FROM products";
                          $get_products = $dbOb->select($query);
                          if ($get_products) {
                            while ($row = $get_products->fetch_assoc()) {
                              ?>
                              <option value="<?php echo $row['products_id_no'] ?>"> <?php echo $row['products_id_no'] . ', ' . $row['products_name'] ?> </option>

                              <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    
                    <div class="form-group" id="quantity_div">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Offer With Packet<span class="required" style="color: red">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="number" min="1" step="1" required="" id="packet_qty" name="packet_qty" class="form-control col-md-7 col-xs-12" placeholder="QTY Of Packet">
                      </div>
                    </div>


                    <div class="form-group" id="quantity_div">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Offer Quantity(PCs)<span class="required" style="color: red">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="number" min="1" step="1" required="" id="product_qty" name="product_qty" class="form-control col-md-7 col-xs-12" placeholder="Product QTY">
                      </div>
                    </div>

                    
                    <div class="form-group" id="">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Offer Starts From<span class="required" style="color: red">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">

                        <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="" required="" readonly="" placeholder="Select Start Date">
                      </div>
                    </div>
                    
                    <div class="form-group" id="">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Offer Ends AT<span class="required" style="color: red">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">

                       <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="" placeholder="Select Start Date">
                     </div>
                   </div>
                   
                   <div class="form-group" id="">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Active Status<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                     <select required="" id="status" name="status" class="form-control col-md-7 col-xs-12" >
                       <option value="1">Active</option>
                       <option value="0">Inactive</option>
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







<!-- /page content -->

</div>
</div>
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Offer Information");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");
      //alert(serial_no_edit);
      $.ajax({
        url:"ajax_offer_setup.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#products_id").val(data.products_id);
          $("#packet_qty").val(data.packet_qty);
          $("#product_qty").val(data.product_qty);
          $("#from_date").val(data.from_date);
          $("#to_date").val(data.to_date);
          $("#status").val(data.status);
          $("#edit_id").val(data.serial_no);
        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add New Offer Information");
      $("#submit_button").html("Save");

      $("#products_id").val('');
      $("#packet_qty").val('');
      $("#product_qty").val('');
      $("#from_date").val('');
      $("#to_date").val('');
      $("#status").val('');
      $("#edit_id").val("");
    });

    // now we are going to insert and update information by submitting form
    $(document).on('submit','#form_edit_data',function(e){
      e.preventDefault();
      var formData = new FormData($("#form_edit_data")[0]);
      formData.append('submit','submit');
      $.ajax({
        url:"ajax_offer_setup.php",
        data:formData,
        type:'POST',
        dataType:"json",
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
           show_data_table();
         }

       }
     });
    }); // end of form submission

  // now the following section will be used to delete data from database
  $(document).on('click','.delete_data',function(){
    var delete_id = $(this).attr("id");


    swal({
      title: "Are you sure To Delete?",
      text: "It Will Delete All Related Information.",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url:"ajax_offer_setup.php",
          data:{delete_id:delete_id},
          type:"POST",
          dataType:'json',
          success:function(data){
           swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
           show_data_table();
         }
       });
      }
    });

  });
// the following section is for showing data




    }); // end of document ready

  // the following function is declared for showing table data after adding data and upadating and deleting data
  function show_data_table()
  {
    $.ajax({
      url:"ajax_offer_setup.php",
      data:{sohag:"sohag"},
      type:"POST",
      dataType:"text",
      success:function(data_tbl){
        sohag.destroy();
        $("#tbl_body").html(data_tbl);
        init_DataTables();
      }
    });
  }
</script>

</body>
</html>