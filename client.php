<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('customer_info')){
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
          <h2>Customer List</h2>
          <div class="row float-right" align="right">
            <?php 
              if (permission_check('add_customer_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Customer</a>

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
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Customer ID</th>
                <th style="text-align: center;">Category</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Shop Name</th>
                <th style="text-align: center;">Mobile No</th>
                <th style="text-align: center;">Area</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM client ORDER BY serial_no DESC";
              $get_client = $dbOb->select($query);
              if ($get_client) {
                $i=0;
                while ($row = $get_client->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['cust_id']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['organization_name']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['area_name']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('customer_view_button')) {
                        ?>

                        <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 
                        <?php
                      }
                      ?>

                      <?php 
                      if (permission_check('customer_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                        <?php
                      }
                      ?>
                      <?php 
                      if (permission_check('customer_delete_button')) {
                        ?> 
                         <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
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
                    <!-- Form starts From here  -->
                    <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Area Name </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="area_name" id="area_name" required="" class="form-control col-md-7 col-xs-12">
                            <option value="">Select Area Name</option>
                            <?php
                            $query = "SELECT * FROM area";
                            $get_area = $dbOb->select($query);
                            if ($get_area) {
                              while ($row = $get_area->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row['area_name'];?>"><?php echo $row['area_name'] ?></option>

                                <?php
                              }
                            } 
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Category<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="category_name" id="category_name" required="" class="form-control col-md-7 col-xs-12">
                            <option value="">Select Category Name</option>
                            <?php
                            $query = "SELECT * FROM client_category ORDER BY category_name";
                            $get_category = $dbOb->select("$query");
                            if ($get_category) {
                             while ($row = $get_category->fetch_assoc()) {
                               ?>
                               <option value="<?php echo $row['category_name'];?>"><?php echo $row['category_name'] ?></option>

                               <?php
                             }
                           } 
                           ?>
                         </select>
                       </div>
                     </div>

                     <div class="form-group" id="cust_id_div">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer ID<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                          $query = "SELECT * FROM id_no_generator WHERE id_type = 'client' ORDER BY serial_no DESC LIMIT 1";
                          $get_cust = $dbOb->select($query);
                          if ($get_cust) {
                            $last_id = $get_cust->fetch_assoc()['id'];
                            $last_id = explode('-',$last_id)[1];
                            $last_id = $last_id*1+1;
                            $id_length = strlen ($last_id); 
                            $remaining_length = 6 - $id_length;
                            $zeros = "";
                            if ($remaining_length > 0) {
                              for ($i=0; $i < $remaining_length ; $i++) { 
                                $zeros = $zeros.'0';
                              }
                              $last_id = $zeros.$last_id ;
                            }
                            $cust_new_id = "CUST-".$last_id;
                          }else{
                            $cust_new_id = "CUST-000001";
                          }
                        ?>
                      <input type="text" id="cust_id" name="cust_id" readonly="" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $cust_new_id ; ?>" >
                      </div>
                    </div>

                     <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Name<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text"  required=""id="client_name" name="client_name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shop Name <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" required="" id="organization_name" name="organization_name" class="form-control col-md-7 col-xs-12" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address  <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea type="text" required="" id="address" name="address" class="form-control col-md-7 col-xs-12" ></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile  <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" required="" id="mobile_no" name="mobile_no" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email"  id="email" name="email" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description  </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" ></textarea>
                      </div>
                    </div>

                    <div  id="previous_due_div">
                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Previous Dew Amt  </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" min="0"   id="previous_dew" name="previous_dew" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Dew Date  </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="dew_date" name="dew_date" class="form-control datepicker col-md-7 col-xs-12" readonly="">
                      </div>
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
          <button type="button" class="btn btn-danger" id="close"data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> <!-- End of modal for  Adding and Updating data-->




  <!-- Modal For Showing data  -->
  <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " style="width: 700px" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #006666">
          <h3 class="modal-title" id="ModalLabel" style="color: white">Customer Information In Detail</h3>
          <div style="float:right;">

          </div>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" style="background: #f2ffe6">

                <div class="x_content" style="background: #f2ffe6">
                  <br />



                  <!-- Table  -->
                  <table class="table table-bordered" style="background: white">


                    <!-- Table body -->
                    <tbody>
                      <tr>
                        <td><h5>Customer ID</h5></td>
                        <td><h5 id="cust_id_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Customer Name</h5></td>
                        <td><h5 id="client_name_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Shop Name</h5></td>
                        <td><h5 id="organization_name_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Address</h5></td>
                        <td><h5 id="address_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Mobile</h5></td>
                        <td><h5 id="mobile_no_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Email</h5></td>
                        <td><h5 id="email_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Area Name</h5></td>
                        <td><h5 id="area_name_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Customer Category</h5></td>
                        <td><h5 id="category_name_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Description</h5></td>
                        <td><h5 id="description_show"></h5></td>
                      </tr>
                    </tbody>
                    <!-- Table body -->
                  </table>
                  <!-- Table  -->





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
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Customer Information");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $("#previous_due_div").css('display','none');
      $("#previous_dew").val("");
      $("#dew_date").val("");

      $.ajax({
        url:"ajax_client.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#area_name").val(data.area_name);
          $("#cust_id_div").hide();
          $("#category_name").val(data.category_name);
          $("#client_name").val(data.client_name);
          $("#organization_name").val(data.organization_name);
          $("#address").val(data.address);
          $("#mobile_no").val(data.mobile_no);
          $("#email").val(data.email);
          $("#description").val(data.description);
          $("#edit_id").val(data.serial_no);

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Provide New Customer Information");
      $("#submit_button").html("Save");
      $("#area_name").val("");
      $("#category_name").val("");
      $("#client_name").val("");
      // $("#cust_id").val("");
      $("#cust_id_div").show();
      $("#organization_name").val("");
      $("#address").val("");
      $("#mobile_no").val("");
      $("#email").val("");
      $("#description").val("");
      $("#edit_id").val("");
      $("#previous_dew").val("");
      $("#dew_date").val("");

      $("#previous_due_div").css('display','');
      
    });

    $(document).on('click','#close',function(){
      location.reload();
    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_client.php',
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
              location.reload();
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
            url:"ajax_client.php",
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

// in the following section details of a client will be shown 
$(document).on('click','.view_data',function(){
  var serial_no_edit = $(this).attr("id");
  // alert(serial_no_edit);
  $.ajax({
    url:"ajax_client.php",
    data:{serial_no_edit:serial_no_edit},
    type:"POST",
    dataType:"json",
    success:function(data){
      $("#client_name_show").html(data.client_name);
      $("#cust_id_show").html(data.cust_id);
      $("#organization_name_show").html(data.organization_name);
      $("#address_show").html(data.address);
      $("#mobile_no_show").html(data.mobile_no);
      $("#email_show").html(data.email);
      $("#area_name_show").html(data.area_name);
      $("#category_name_show").html(data.category_name);
      $("#description_show").html(data.description);
    }

  });
});
  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_client.php",
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
