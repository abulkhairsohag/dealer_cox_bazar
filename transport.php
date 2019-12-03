<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('transport_info')){
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
          <h2>Vehicle List</h2>
          <div class="row float-right" align="right">

            <?php 

            if (permission_check('add_new_vehicle_button')) {
              ?> 
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Vehicle</a>
            <?php } ?>

          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Vehicle Name</th>
                <th style="text-align: center;">Type</th>
                <th style="text-align: center;">Registration No</th>
                <th style="text-align: center;">Engine No</th>
                <th style="text-align: center;">Insurance No</th>
                <th style="text-align: center;">Driver Name</th>
                <th style="text-align: center;">License No</th>
                <th style="text-align: center;">Owner Type</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM transport ORDER BY serial_no DESC";
              $get_transport = $dbOb->select($query);
              if ($get_transport) {
                $i=0;
                while ($row = $get_transport->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['vehicle_name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['reg_no']; ?></td>
                    <td><?php echo $row['engine_no']; ?></td>
                    <td><?php echo $row['insurance_no']; ?></td>
                    <td><?php echo $row['driver_name']; ?></td>
                    <td><?php echo $row['license_no']; ?></td>
                    <td><?php echo $row['owner_type']; ?></td>
                    <td align="center">


                      <?php 

                      if (permission_check('transport_edit_button')) {
                        ?> 
                       <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>



                      <?php 

                      if (permission_check('transport_delete_button')) {
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

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle Name </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required=""id="vehicle_name" name="vehicle_name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Vehicle Type<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required=""id="type" name="type" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Registrarion Number <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="reg_no" name="reg_no" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Engine Number  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="engine_no" name="engine_no" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Insurance Number  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="insurance_no" name="insurance_no" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Driver Name  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="driver_name" name="driver_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">License Number <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  type="text" id="license_no" name="license_no" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Owner Type  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="owner_type" id="owner_type" class="form-control col-md-7 col-xs-12" required="">
                            <option value="">Select Owner Type</option>
                            <option value="Self">Self</option>
                            <option value="Rent">Rent</option>
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
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Vehicle Information");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_transport.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#vehicle_name").val(data.vehicle_name);
          $("#type").val(data.type);
          $("#reg_no").val(data.reg_no);
          $("#engine_no").val(data.engine_no);
          $("#insurance_no").val(data.insurance_no);
          $("#driver_name").val(data.driver_name);
          $("#license_no").val(data.license_no);
          $("#owner_type").val(data.owner_type);
          $("#edit_id").val(data.serial_no);

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add New Vehicle Information");
      $("#submit_button").html("Saved");
      $("#vehicle_name").val("");
      $("#type").val("");
      $("#reg_no").val("");
      $("#engine_no").val("");
      $("#insurance_no").val("");
      $("#driver_name").val("");
      $("#license_no").val("");
      $("#owner_type").val("");
      $("#edit_id").val("");
    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_transport.php',
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
            url:"ajax_transport.php",
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


  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_transport.php",
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
