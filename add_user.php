<?php include_once('include/header.php'); ?>

<?php 

if(!permission_check('add_system_user')){
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
          <h2>User List <small>Users</small></h2>
          <div class="row float-right" align="right">

            <?php 
            if (permission_check('add_new_user_button')) {
              ?>
              <a href="add_area.php" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New User</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th  style="text-align: center;">Sl No</th>
                <th  style="text-align: center;">Name</th>
                <th  style="text-align: center;">Designation </th>
                <th  style="text-align: center;">Mobile No</th>
                <th  style="text-align: center;">Address</th>
                <th  style="text-align: center;">Email</th>
                <th  style="text-align: center;">User Name</th>
                <th  style="text-align: center;">Password</th>
                <th  style="text-align: center;">Role</th>
                <th  style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="tbl_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM user ORDER BY serial_no DESC";
              $get_user = $dbOb->select($query);
              if ($get_user) {
                $i = 0;
                while ($row = $get_user->fetch_assoc()) {
                  $i++;
                  $user_serial_no = $row['serial_no'];
                    $query = "SELECT * FROM user_has_role WHERE user_serial_no = '$user_serial_no' AND user_type = 'user'";
                    $get_user_role = $dbOb->select($query);
                    if ($get_user_role) {
                      $user_and_role = $get_user_role->fetch_assoc();
                      $role_serial_no = $user_and_role['role_serial_no'];
                      $query = "SELECT * FROM role WHERE serial_no = '$role_serial_no'";
                      $get_role_info = $dbOb->select($query);
                      if ($get_role_info) {
                        $role_name = $get_role_info->fetch_assoc()['role_name'];
                        $role_badge_color = 'bg-blue';
                      }else{
                        $role_name = 'Not Assigned';
                        $role_badge_color = 'bg-red';
                      }
                    }else{
                      $role_name = 'Not Assigned';
                      $role_badge_color = 'bg-red';
                    }
                  ?>
                  <tr class="tbl_row"<?php echo $row['serial_no']; ?>>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation'] ?></td>
                    <td><?php echo $row['mobile_no'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['user_name'] ?></td>
                    <td><?php echo $row['password'] ?></td>
                    <td><span class="badge <?php echo $role_badge_color?>"><?php echo $role_name; ?></span></td>
								
                    <td align="center">

                      <?php 
                      if (permission_check('user_edit_button')) {
                        ?>

                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                      <?php } ?>

                      <?php 
                      if (permission_check('user_delete_button')) {
                        ?> 

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                      <?php } ?>

                         

                        <a  class="badge bg-green  assign_role_button" id="<?php echo $row['serial_no'] ?>" data-toggle="modal" data-target="#assign_role_modal" style="margin:2px">Role</a>  
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



    <!--  Modal For Adding and Updating role of an employee  -->
    <div class="modal fade" id="assign_role_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Provide informarion of employee role</h3>
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
                    <form id="assign_role_form" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Select Role  <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="role_name" id="role_name" class="form-control col-md-7 col-xs-12" required="" >
                            <option value="">Please select a role</option>
                            <?php 
                            include_once ('class/Database.php');
                            $dbOb = new Database();
                            $query = "SELECT * FROM role";

                            $get_role = $dbOb->select($query);
                            if ($get_role) {
                              while ($row = $get_role->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row['serial_no'] ?>"><?php echo $row['role_name'] ?></option>
                                <?php
                              }
                            }

                            ?>
                          </select>
                        </div>
                      </div>

                      <div style="display: none;">
                        <input type="text" name="user_serial_no" id="user_serial_no">
                      </div>


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary" >Reset</button>
                          <button type="submit" class="btn btn-success"> Save</button>
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
    </div> <!-- End of modal for  Adding role of the employee-->






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
                <div class="x_panel" style="background: #f1f5f2">

                  <div class="x_content" style="background: #f1f5f2">
                    <br />
                    <!-- Forma starts from here  -->
                    <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Designation<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required=""id="designation" name="designation" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="mobile_no" name="mobile_no" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="address" name="address" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="email" name="email" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User Name  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="user_name" name="user_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" required="" id="password" name="password" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" required="" id="confirm_password" name="confirm_password" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>




                      <div style="display: none;">
                        <input type="number" id="edit_id" name="edit_id">
                      </div>



                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary" >Reset</button>
                          <input type="submit" class="btn btn-success" id="submit_button" name="submit">
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

      $("#ModalLabelAdd").html("Update User Information");
      $("#submit_button").val("Update");

      var serial_no_edit = $(this).attr("id");
      //alert(serial_no_edit);
      $.ajax({
        url:"ajax_add_user.php",
        data:{serial_no_edit:serial_no_edit},
        type:"post",
        dataType:'json',
        success:function(data){
          $("#name").val(data.name);
          $("#designation").val(data.designation);
          $("#mobile_no").val(data.mobile_no);
          $("#address").val(data.address);
          $("#email").val(data.email);
          $("#user_name").val(data.user_name);
          $("#password").val(data.password);
          $("#confirm_password").val(data.password);
          $("#edit_id").val(data.serial_no);
        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabelAdd").html("Add New User Information");
      $("#submit_button").val("Save");
      $("#name").val('');
      $("#designation").val('');
      $("#mobile_no").val('');
      $("#address").val('');
      $("#email").val('');
      $("#user_name").val('');
      $("#password").val('');
      $("#confirm_password").val('');
      $("#edit_id").val('');
    });

// putting  the serial_no of user to user_serial_no input field while pressing on assign role button 
$(document).on('click','.assign_role_button',function(){
  var user_serial_no = $(this).attr("id");
  $("#user_serial_no").val(user_serial_no);
});

/// inserting user role 
$(document).on('submit','#assign_role_form',function(e){
  e.preventDefault();
  var formData = new FormData($("#assign_role_form")[0]);
  formData.append('submit_role','submit_role');

  $.ajax({
    url:'ajax_add_user.php',
    data:formData,
    type:'POST',
    dataType: 'json',
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
       $("#assign_role_modal").modal("hide"); 
       show_data_table();
     }
   }
 });
});

// Inserting user information 
$("#form_edit_data").on('submit',function(e){
  e.preventDefault();

  var formData = new FormData($("#form_edit_data")[0]);
  formData.append('submit',"submit");
      //console.log(formData);
      $.ajax({
        url:"ajax_add_user.php",
        data:formData,
        type:"POST",
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

           $.ajax({
            url:'ajax_add_user.php',
            data:{sohag:'sohag'},
            type:"POST",
            dataType:"text",
            success:function(data_tbl){
              $("#tbl_body").html(data_tbl);
              //console.log(data_tbl);

            }
          });
         }
       }

     });


    });

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
        url:"ajax_add_user.php",
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

          $.ajax({
            url:'ajax_add_user.php',
            data:{sohag:'sohag'},
            type:"POST",
            dataType:"text",
            success:function(data_tbl){
              sohag.destroy();
              $("#tbl_body").html(data_tbl);
              init_DataTables();

            }
          });
        }
      });

    } 
  });
});


});

</script>

</body>
</html>
