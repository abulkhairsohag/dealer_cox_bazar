<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('attendance_info')){
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

    <?php 


    include_once("class/Database.php");
    $dbOb = new Database();

    $date_today = date("d-m-Y");
    $attendance_month = date("m-Y");

    // $query = "SELECT * FROM employee_attendance  WHERE  attendance_date = '$date_today'";
    // $get_attend_today = $dbOb->select($query);

  // inserting attendance data at the start of the day 
    $query = "SELECT * FROM employee_main_info WHERE active_status = 'Active'";
    $get_employee = $dbOb->select($query);
    if ($get_employee) {

      while ($row = $get_employee->fetch_assoc()) {
        $emp_id = $row['id_no'];
        $query = "SELECT * FROM employee_attendance  WHERE employee_id_no = '$emp_id'";
        $emp_today_attendance = $dbOb->select($query);
        $confirmation = true;
        if ($emp_today_attendance) {
          while ($attend = $emp_today_attendance->fetch_assoc()) {
            if (strtotime($attend['attendance_date']) == strtotime($date_today)) {
              $confirmation = false;
              break;
            }
          }
        }
        
        if ($confirmation) {
          $name  = $row['name'];
          $designation  = $row['designation'];
          $query = "INSERT INTO employee_attendance (employee_id_no, name, designation, attendance, attendance_date,attendance_month)
          VALUES 
          ( '$emp_id','$name', '$designation',0,'$date_today','$attendance_month' )";
          $add_attendance = $dbOb->insert($query);

        }

      }
      
    }
    



    ?>


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Attendance List Of Employee (Today)</h2>
          <div class="row float-right" align="right">
           
           
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">ID Number</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Designation</th>
                <th style="text-align: center;">Attendance</th>
                <!-- <th style="display: none;"></th> -->
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database(); 
              $today = date("d-m-Y");
              $query = "SELECT * FROM employee_attendance WHERE attendance_date = '$today' ORDER BY serial_no DESC";
              $get_attendance = $dbOb->select($query);
              if ($get_attendance) {
                $i=0;
                while ($row = $get_attendance->fetch_assoc()) {
                  $i++;

                  if ($row['attendance'] == '1') {
                    $checked = "checked";
                  }else{
                    $checked = "";
                  }


                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['employee_id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td>
                      <input type="checkbox" name="attendance_status" class=" js-switch attendance_status" data-fouc <?php echo $checked; ?> id="<?php echo($row['employee_id_no']) ?>">
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
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Employee ID<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="employee_id_no" id="employee_id_no" class="form-control col-md-7 col-xs-12" >
                            <option value="">Select An Employee ID</option>
                            <?php 
                            $query = "SELECT * FROM employee_main_info";
                            $get_employee = $dbOb->select($query);
                            if ($get_employee) {
                              while ($row = $get_employee->fetch_assoc()) {
                                ?>
                                <option value="<?php echo($row['id_no']) ?>"><?php echo $row['id_no'].', '.$row['name']; ?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Name  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="name" name="name" class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>






                      






                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Designation<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required=""id="designation" name="designation"  class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Designation<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" name="status" class="form-control js-switch status" data-fouc  value="">
                        </div>
                      </div>





                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Attendance  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <div class="radio">
                            <label>
                              <input type="radio" class="flat" required="" id="present_attendance" name="attendance" value="Present" checked=""> Present
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="flat" required="" id="absent_attendance" name="attendance" value="Absent" > Absent
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


    $(document).on('change','.attendance_status',function(){
      var employee_id = $(this).attr("id");
      var attendance = '';
      if (this.checked) {
        attendance = '1';
      }else{
        attendance = '0';

      }


      $.ajax({
        url:"ajax_employee_attendance.php",
        data:{employee_id:employee_id,attendance:attendance},
        type:"POST",
        dataType:'json',
        success:function(data){
          swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
              // get_data_table();
            }
          });
    });



  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_employee_attendance.php",
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