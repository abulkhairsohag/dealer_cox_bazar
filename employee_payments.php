<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('employee_payments')){
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
          <h2>Employee Payment List</h2>
          <div class="row float-right" align="right">
            <?php 
            if (permission_check('add_payment_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Payment</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">#</th>
                <th style="text-align: center;">Zone</th>
                <th style="text-align: center;">ID No</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Designation</th>
                <th style="text-align: center;">Total Salary</th>
                <th style="text-align: center;">Month</th>
                <th style="text-align: center;">Attendance</th>
                <th style="text-align: center;">Pay Type</th>
                <th style="text-align: center;">Advance Salary</th>
                <th style="text-align: center;">Salary Paid</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM employee_payments ORDER BY serial_no DESC";
              $get_employee_commission = $dbOb->select($query);
              if ($get_employee_commission) {
                $i=0;
                while ($row = $get_employee_commission->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['total_salary']; ?></td>
                    <?php 
                    $month = $row['month'];
                    $exp = explode('-', $month);
                    $month = $exp[0];
                    $year = $exp[1];
                    $month_name = '';
                    switch ($month) {
                      case '01':
                      $month_name = "January".'-'.$year;
                      break;
                      case '02':
                      $month_name = "February".'-'.$year;
                      break;
                      case '03':
                      $month_name = "March".'-'.$year;
                      break;
                      case '04':
                      $month_name = "April".'-'.$year;
                      break;
                      case '05':
                      $month_name = "May".'-'.$year;
                      break;
                      case '06':
                      $month_name = "June".'-'.$year;
                      break;
                      case '07':
                      $month_name = "July".'-'.$year;
                      break;
                      case '08':
                      $month_name = "August".'-'.$year;
                      break;
                      case '09':
                      $month_name = "September".'-'.$year;
                      break;
                      case '10':
                      $month_name = "October".'-'.$year;
                      break;
                      case '11':
                      $month_name = "November".'-'.$year;
                      break;
                      case '12':
                      $month_name = "December".'-'.$year;
                      break;
                      
                      
                    }
                    ?>
                    <td><?php echo $month_name; ?></td>
                    <td><?php echo $row['attendance']; ?></td>
                    <td><?php echo $row['pay_type']; ?></td>
                    <td><?php echo $row['advance_amount']; ?></td>
                    <td><?php echo $row['salary_paid']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('payment_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>
                      <?php 
                      if (permission_check('payment_delete_button')) {
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
              <label class="col-md-3 control-label" for="inputDefault">Zone </label>
               <div class="col-md-6">
            <select name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no ">
           
              <?php

              if (Session::get("zone_serial_no")){
                if (Session::get("zone_serial_no") != '-1') {
                
                ?>
                  <option value='<?php echo Session::get("zone_serial_no"); ?>'><?php echo Session::get("zone_name"); ?></option>
                <?php
                }else{
                  ?>
                    <option value=''><?php echo Session::get("zone_name"); ?></option>
                  <?php
                }
              }else{
        $query = "SELECT * FROM zone ORDER BY zone_name";
        $get_zone = $dbOb->select($query);
        if ($get_zone) {
          ?>
           <option value="">Please Select One</option>
          <?php
                while ($row = $get_zone->fetch_assoc()) {

                ?>
                <option value="<?php echo $row['serial_no']; ?>"  ><?php echo $row['zone_name']; ?></option>
                <?php
              }
            }else{
              ?>
                <option value="">Please Add Zone First..</option>
              <?php

            }
             }

            ?>

            </select>
            
              </div>
            </div>



                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Employee ID <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="id_no" id="id_no" required="" class="form-control col-md-7 col-xs-12">
                            <option value="">Select Employee</option>
                            <?php 
                            $query = "SELECT * FROM `employee_main_info`";
                            $get_employee  =  $dbOb->select($query);

                            if ($get_employee) {
                              while ($row = $get_employee->fetch_assoc()) {
                                ?>
                                <option value="<?php echo($row['id_no']) ?>"><?php echo $row['id_no'].', '.$row['name'] ?></option>
                                <?php
                              }
                            }

                            ?>
                            
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Designation
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="designation" name="designation"  class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Total Salary<span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number"  min="0" step="0.01"  required="" id="total_salary" name="total_salary"  class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Month Name <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="month" id="month" class="form-control col-md-7 col-xs-12" required="" >
                            <option value="">Select Month</option>
                            <option value="01-<?php echo date("Y") ?>">January-<?php echo date("Y") ?></option>
                            <option value="02-<?php echo date("Y") ?>">February-<?php echo date("Y") ?></option>
                            <option value="03-<?php echo date("Y") ?>">March-<?php echo date("Y") ?></option>
                            <option value="04-<?php echo date("Y") ?>">April-<?php echo date("Y") ?></option>
                            <option value="05-<?php echo date("Y") ?>">May-<?php echo date("Y") ?></option>
                            <option value="06-<?php echo date("Y") ?>">June-<?php echo date("Y") ?></option>
                            <option value="07-<?php echo date("Y") ?>">July-<?php echo date("Y") ?></option>
                            <option value="08-<?php echo date("Y") ?>">August-<?php echo date("Y") ?></option>
                            <option value="09-<?php echo date("Y") ?>">September-<?php echo date("Y") ?></option>
                            <option value="10-<?php echo date("Y") ?>">October-<?php echo date("Y") ?></option>
                            <option value="11-<?php echo date("Y") ?>">November-<?php echo date("Y") ?></option>
                            <option value="12-<?php echo date("Y") ?>">December-<?php echo date("Y") ?></option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Attendance Day (Present)<span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required="" id="attendance" name="attendance"  class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Pay Type  <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="pay_type" id="pay_type" class="form-control col-md-7 col-xs-12" required="">
                            <option value="Full Salary">Full Salary</option>
                            <option value="Salary Advance">Salary Advance</option>
                          </select>
                        </div>
                      </div>


                      <div class="form-group salary_div" style="display: none;" id="advance_amount_div">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Advance Amount<span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="advance_amount" name="advance_amount"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Salary To Be Paid<span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id="salary_to_be_paid" name="salary_to_be_paid"  class="form-control col-md-7 col-xs-12" readonly="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" >
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

      $("#ModalLabel").html("Update Employee Payment Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_employee_payments.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){

          $("#id_no").val(data.get_payment.id_no);
          $("#name").val(data.get_payment.name);
          $("#designation").val(data.get_payment.designation);
          $("#total_salary").val(data.get_payment.total_salary);
          $("#month").val(data.get_payment.month);
          $("#attendance").val(data.get_payment.attendance);
          $("#pay_type").val(data.get_payment.pay_type);
          $("#description").val(data.get_payment.description);
          $("#salary_to_be_paid").val(data.emp_salary);
          $("#edit_id").val(data.get_payment.serial_no);
          $("#zone_serial_no").val(data.zone_serial_no);

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add Employee Payment Information.");
      $("#submit_button").html("Save");

      $("#id_no").val("");
      $("#name").val("");
      $("#designation").val("");
      $("#total_salary").val("");
      $("#month").val("");
      $("#attendance").val("");
      $("#pay_type").val("");
      $("#advance_amount").val("");
      $("#advance_amount_div").hide("");
      $("#salary_to_be_paid").val("");
      $("#description").val("");
      $("#edit_id").val("");

    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_employee_payments.php',
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
            url:"ajax_employee_payments.php",
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

    // getting employee information while changing the employee id 
    $(document).on('change','#id_no',function(){
      var employee_id_no = $(this).val();
      

      $.ajax({
        url:"ajax_employee_payments.php",
        data:{employee_id_no:employee_id_no},
        type:"POST",
        dataType:'json',
        success:function(data){
         
         $("#name").val(data.name);
         $("#designation").val(data.designation);
         $("#total_salary").val(data.total_salary);

         var advance_amount = parseInt($("#advance_amount").val());
         if(isNaN(advance_amount) || advance_amount == ""){
          advance_amount = 0;
        }

        var salary_to_be_paid = parseInt(data.total_salary) + parseInt(advance_amount); 

        $("#salary_to_be_paid").val(salary_to_be_paid);

      }
    });
      get_attendance();

    });

    $(document).on("change","#pay_type",function(){ var type = $(this).val();
      if(type == 'Full Salary'){ 
        $(".salary_div").hide(500);
        $('#advance_amount').removeAttr('required');
        $('#advance_amount').val("");
        salary_calculation();
      }else if (type =='Salary Advance'){ 
        $(".salary_div").show(500); 
        $('#advance_amount').attr('required', 'true'); 
        salary_calculation();
      } 
    });


    $(document).on('keyup blur','#advance_amount',function(){
      salary_calculation();
    });

  }); // end of document ready function 


// the following section for getting employee attendance 
$(document).on('change',"#month",function(){
  get_attendance();
});


// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_employee_payments.php",
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

function salary_calculation(){
  var total_salary = parseInt($("#total_salary").val());
  if(isNaN(total_salary) || total_salary == ""){
    total_salary = 0;
  }
  var advance_amount = $("#advance_amount").val();

  if(isNaN(advance_amount) || advance_amount == ""){
    advance_amount = 0;
  }

  $("#salary_to_be_paid").val(parseInt(total_salary)+parseInt(advance_amount));

}

function get_attendance(){
  var emp_id_no = $("#id_no").val();
  var payment_month = $("#month").val();


          $.ajax({
            url:"ajax_employee_payments.php",
            data:{emp_id_no:emp_id_no,payment_month:payment_month},
            type:"POST",
            dataType:'json',
            success:function(data){
              $("#attendance").val(data);
            }
          });

}
</script>

</body>
</html>