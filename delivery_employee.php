<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('delivery_man')){
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
          <h2> Delivery Employee List</h2>
          <div class="row float-right" align="right">

            <?php 
            if (permission_check('add_new_delivery_man_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Delivery Employee</a>
            <?php } ?>

          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Active Status</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM delivery_employee ORDER BY serial_no DESC";
              $get_delivery_employee = $dbOb->select($query);
              if ($get_delivery_employee) {
                $i=0;
                while ($row = $get_delivery_employee->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                   
                    <?php 
                      if ($row['active_status'] == "Active") {
                        $color = "green";
                      }
                      if($row['active_status'] == "Inactive"){
                        $color = "red";
                      }
                     ?>
                    <td style="color: <?php echo $color; ?>"><b><?php echo $row['active_status']; ?></b></td>
                    <td align="center">

                      <?php 
                      if (permission_check('delivery_man_edit_button')) {
                        ?>
                         <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('delivery_man_delete_button')) {
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee ID <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select required=""id="id_no" name="id_no" required="required" class="form-control col-md-7 col-xs-12">
                            <option value=""></option>
                            <?php 
                            $query = "SELECT * FROM employee_main_info WHERE active_status = 'Active'";
                            $get_employee = $dbOb->select($query);
                            if ($get_employee) {
                              while ($row = $get_employee->fetch_assoc()) {
                                $id = $row['id_no'];
                                $query = "SELECT * FROM employee_duty WHERE id_no = '$id' AND active_status = 'Active'";
                                $get_employee_duty = $dbOb->find($query);

                                $query1 = "SELECT * FROM own_shop_employee WHERE id_no = '$id' and active_status = 'Active'";
                                $get_own_employee = $dbOb->find($query1);
                                if (!$get_employee_duty && !$get_own_employee) {
                                  ?>
                                  <option value="<?php echo $row['id_no'] ?>"> <?php echo $row['id_no'].', '.$row['name']; ?> </option>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Name </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12" readonly="" >
                        </div>
                      </div>


          

                




           




                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Active Status  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <div class="radio">
                            <label>
                              <input type="radio" class="flat" required="" id="active" name="active_status" value="Active" checked=""> Active
                            </label>
                          </div>
                          <div class="radio">
                            <label>
    
                              <input type="radio" class="flat" required="" id="inactive" name="active_status" value="Inactive" > Inactive
                            </label>
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

      $("#ModalLabel").html("Update Delivery Employee Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_delivery_employee.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){

          $("#id_no").val(data.id_no);
          $("#name").val(data.name);
          $("#area").val(data.area);
          // $("#company").val(data.company);
          $("#vehicle_reg_no").val(data.vehicle_reg_no);
          $("#from_date").val(data.from_date);
          $("#to_date").val(data.to_date);
          $("#edit_id").val(data.serial_no);

          if (data.active_status == "Active") {
              $('#active').iCheck('check');
              $('#inactive').iCheck('uncheck');
            }else if(data.active_status == "Inactive"){
             $('#active').iCheck('uncheck');
             $('#inactive').iCheck('check');
           }


        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add New Delivery Employee Information.");
      $("#submit_button").html("Save");


      $("#id_no").val("");
      $("#name").val("");
      $("#area").val("");
      // $("#company").val("");
      $("#vehicle_reg_no").val("");
      $("#from_date").val("");
      $("#to_date").val("");
      $("#edit_id").val("");
      
      $('#active').iCheck('check');
      $('#inactive').iCheck('uncheck');

    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_delivery_employee.php',
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
            url:"ajax_delivery_employee.php",
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

    // getting employee name by his id 
    $(document).on('change','#id_no',function(){
      var id_no_employee = $(this).val();
      $.ajax({
        url:"ajax_delivery_employee.php",
        data:{id_no_employee:id_no_employee},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#name").val(data.name);
        }
      });

    });

  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_delivery_employee.php",
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
