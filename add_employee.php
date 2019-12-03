<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('add_employee')){
  ?>
  <script>
    window.location.href = '403.php';
  </script>
  <?php 
}
 ?>
 
<div class="right_col" role="main">
  <div class="row">
  </div>
  <!-- page content -->
  <?php
  include_once("class/Database.php");
  $dbOb =  new Database();
  ?>
  <form id="add_data_form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="" enctype="multipart/form-data">
    <div class="sohag">
      <marquee direction="">Provide Employee Information</marquee>
    </div>
    <div style="font-size: 16px;color: red" align="center">Please Fill Up All * (star) Marked Fields Before Adding Employee</div>
    <div id="accordion">
      <h3 class="accordian_sohag">Office Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <!-- Form Starts From Here  -->
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ID No <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php 
                      $query = "SELECT * FROM employee_main_info ORDER BY serial_no DESC LIMIT 1";
                      $get_employee = $dbOb->select($query);
                      if ($get_employee) {
                        $last_id = $get_employee->fetch_assoc()['id_no'];
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
                        $employee_new_id = "EMP-".$last_id;
                      }else{
                        $employee_new_id = "EMP-000001";
                      }
                    ?>
                    <input type="text" id="id_no" name="id_no" readonly="" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $employee_new_id ; ?>" >
                  </div>
                </div>
                
       <!--          <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Area Name <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="area_name" id="area_name" required="required" class="form-control col-md-7 col-xs-12">
                      <option value="">Select Area Name</option>

                      <?php
                      $query = "SELECT * FROM area";
                      $get_area = $dbOb->select($query);
                      if ($get_area) {
                        while ($row = $get_area->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['area_name'] ?>"> <?php echo $row['area_name'] ?></option>
                          <?php
                        }
                      }
                      ?>

                    </select>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Designation<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="designation" class="form-control col-md-7 col-xs-12" type="text" name="designation" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Joining Date <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="joining_date" name="joining_date" class=" form-control col-md-7 col-xs-12 date-picker datepicker" value="<?php echo date("d-m-Y") ?>" required="required" readonly="" placeholder="Select Joining Date">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Basic Salary (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="basic_salary" class="form-control col-md-7 col-xs-12" type="number" min="0" name="basic_salary" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">House Rent (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="house_rent" class="form-control col-md-7 col-xs-12" type="number" min="0" name="house_rent" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Medical Allowance (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="medical_allowance" class="form-control col-md-7 col-xs-12" type="number" min="0" name="medical_allowance" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Transport Allowance (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="transport_allowance" class="form-control col-md-7 col-xs-12" type="number" min="0" name="transport_allowance" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Insurance (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="insurance" class="form-control col-md-7 col-xs-12" type="number" min="0" name="insurance" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Commission (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" min="0" id="commission" class="form-control col-md-7 col-xs-12" name="commission" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Exra Over Time (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="extra_over_time" class="form-control col-md-7 col-xs-12" type="number" min="0" name="extra_over_time" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Salary (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="total_salary" class="form-control col-md-7 col-xs-12" type="number" min='0' name="total_salary" readonly="" style="background: #2996A5;color: white;text-align: center;" value="0">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Create Login Account ?  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12" >
                    <input type="checkbox" id="create_confirmation" name="create_confirmation" class="icheckbox_flat-green " >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User Name  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="user_name" name="user_name" class="form-control col-md-7 col-xs-12" value="" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password"  id="password" name="password" class="form-control col-md-7 col-xs-12" value="" >
                  </div>
                </div>

         



              </div>
            </div>
          </div>
        </div>
      </div>
      <h3 class="accordian_sohag">Basic Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Father's Name <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fathers_name" name="fathers_name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mother's name</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="mothers_name" class="form-control col-md-7 col-xs-12" type="text" name="mothers_name" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Spouse's name</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="spouses_name" class="form-control col-md-7 col-xs-12" type="text" name="spouses_name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="birth_date" name="birth_date" class="date-picker form-control col-md-7 col-xs-12 datepicker"  readonly='' placeholder="Select Date Of Birth">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Gender<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="gender" id="gender" class="form-control col-md-7 col-xs-12" required="">
                      <option value="">Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">NID Number<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nid_no" class="form-control col-md-7 col-xs-12" type="number" name="nid_no" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Birth Certificate No</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="birth_certificate_no" class="form-control col-md-7 col-xs-12" type="text" name="birth_certificate_no">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Nationality </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nationality" class="form-control col-md-7 col-xs-12" type="text" name="nationality">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Religion </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="religion" class="form-control col-md-7 col-xs-12" type="text" name="religion">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="photo" class="form-control col-md-7 col-xs-12" type="file" name="photo" required="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h3 class="accordian_sohag">Contact Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Present Address <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="present_address" name="present_address" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Permanent Address<span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="permanent_address" name="permanent_address" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Number<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="mobile_no" class="form-control col-md-7 col-xs-12" type="text" name="mobile_no" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="phone_no" class="form-control col-md-7 col-xs-12" type="text" name="phone_no">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="email" id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="example: abc@sometext.com">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h3 class="accordian_sohag">Academical Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table" class="">
              <thead>
                <tr>
                  <th style="text-align: center;">Exam Name<span class="required" style="color: red">*</span></th>
                  <th style="text-align: center;">Institute<span class="required" style="color: red">*</span></th>
                  <th style="text-align: center;">Board/University<span class="required" style="color: red">*</span></th>
                  <th style="text-align: center;">Group/Dept.<span class="required" style="color: red">*</span></th>
                  <th style="text-align: center;">Result<span class="required" style="color: red">*</span></th>
                  <th style="text-align: center;">Passing Year<span class="required" style="color: red">*</span></th>
                  <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
                </tr>
              </thead>
              <tbody id="edu_info_table">
                <tr>
                  <td><input type="text" class="form-control" id="exam_name" name="exam_name[]" required=""></td>
                  <td><input type="text" class="form-control" id="institute" name="institute[]" required=""></td>
                  <td><input type="text" class="form-control" id="board_university" name="board_university[]" required=""></td>
                  <td><input type="text" class="form-control" id="group_name" name="group_name[]" required=""></td>
                  <td><input type="number" min="0" step="0.01" class="form-control" id="result" name="result[]" required=""></td>
                  <td><input type="number" min="0" step="1" class="form-control" id="passing_year" name="passing_year[]" required=""></td>
                  <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <h3 class="accordian_sohag">Documentation Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Document Name
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="document_name" name="document_name" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Document Type
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="document_type" name="document_type" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="description" class="form-control col-md-7 col-xs-12" type="text" name="description"> </textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Document</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" id="upload_document" class="form-control col-md-7 col-xs-12" name="upload_document">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h3 class="accordian_sohag">Account Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Account Name 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="account_name" name="account_name"  class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Bank Name
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="bank_name" name="bank_name"  class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="branch_name" class="form-control col-md-7 col-xs-12" type="text" name="branch_name"  >
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Account Number </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="account_no" class="form-control col-md-7 col-xs-12" type="number" name="account_no"  >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h3 class="accordian_sohag">Helth Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Height 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="height" name="height"   class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Weight 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="wieght" name="wieght"  d" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Blood Group </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="blood_group" id="blood_group" class="form-control col-md-7 col-xs-12" >
                      <option value="">Select Blood Group</option>
                      <option value="A (+ve)">A (+ve)</option>
                      <option value="B (+ve)">B (+ve)</option>
                      <option value="AB (+ve)">AB (+ve)</option>
                      <option value="O (+ve)">O (+ve)</option>
                      <option value="A (-ve)">A (-ve)</option>
                      <option value="B (-ve)">B (-ve)</option>
                      <option value="AB (-ve)">AB (-ve)</option>
                      <option value="O (-ve)">O (-ve)</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Body Identify Mark</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="body_identify_mark" class="form-control col-md-7 col-xs-12" type="text" name="body_identify_mark">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="form-group" style="margin-top: 30px;margin-bottom: 30px">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"><h4 style="color: #2A3F54">Active Status </h4> </label>
      <div class="col-md-6 col-sm-6 col-xs-12">

        <div class="radio">
          <label>
            <input type="radio" class="flat" required="" id="active" name="active_status" value="Active" checked=""> <span style="color: green">Active</span>
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" class="flat" required="" id="inactive" name="active_status" value="Inactive" > <span style="color: red">Inactive</span>
          </label>
        </div>
      </div>
    </div>


    <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px">
      <input class="btn btn-primary  btn-block" type="submit" name="submit" id="submit_employee" value="Add Employee" style="height: 50px;font-size: 20px" title="Pelase Fill Up All * Mrked Fields Before Adding Employee">

    </div>
  </form>
</div>
<!-- /page content -->
</div>
</div>
<?php include_once('include/footer.php'); ?>


<script>
  $(document).ready(function() {
    //this section is for adding multiple fields for inserting data in education table
    $("#add_more").click(function() {
      $('#edu_info_table').append('<tr><td><input type="text" class="form-control" id="exam_name" name="exam_name[]" required=""></td><td><input type="text" class="form-control" id="institute" name="institute[]" required=""></td><td><input type="text" class="form-control" id="board_university" name="board_university[]" required=""></td><td><input type="text" class="form-control" id="group_name" name="group_name[]" required=""></td><td><input type="number" min="0" step="0.01" class="form-control" id="result" name="result[]" required=""></td><td><input type="number" min="0" step="1" class="form-control" id="passing_year" name="passing_year[]" required=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
    });
    // this section is for removing row from education table
    $(document).on('click', '.remove_button', function(e) {
      var remove_row = $(this).closest("tr");
      remove_row.remove();
    });

    $(document).on('keyup blur', "#basic_salary", function() {
      calculate_salary();
    });

    $(document).on('keyup blur', "#house_rent", function() {
      calculate_salary();
    });

    $(document).on('keyup blur', "#medical_allowance", function() {
      calculate_salary();
    });

    $(document).on('keyup blur', "#transport_allowance", function() {
      calculate_salary();
    });

    $(document).on('keyup blur', "#insurance", function() {
      calculate_salary();
    });

    $(document).on('keyup blur', "#commission", function() {
      calculate_salary();
    });

    $(document).on('keyup blur', "#extra_over_time", function() {
      calculate_salary();
    });

    // now we are going to submit form ie. inserting data 

    $(document).on('submit', '#add_data_form', function(e) {
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append("submit", "submit");

      $.ajax({
        url: "ajax_add_employee.php",
        data: formData,
        type: "POST",
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
          swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });

          if (data.type == 'success') {
            $("#id_no").val("");
            $("#area_name").val("");
            $("#designation").val("");
            $("#joining_date").val("");
            $("#basic_salary").val("");
            $("#house_rent").val("");
            $("#medical_allowance").val("");
            $("#transport_allowance").val("");
            $("#insurance").val("");
            $("#commission").val("");
            $("#extra_over_time").val("");
            $("#total_salary").val("");

            //Basic Informaion
            $("#name").val("");
            $("#fathers_name").val("");
            $("#mothers_name").val("");
            $("#spouses_name").val("");
            $("#birth_date").val("");
            $("#gender").val("");
            $("#nid_no").val("");
            $("#birth_certificate_no").val("");
            $("#nationality").val("");
            $("#religion").val("");

            $("#photo").val("");

            //Contact Information
            $("#present_address").val("");
            $("#permanent_address").val("");
            $("#mobile_no").val("");
            $("#phone_no").val("");
            $("#email").val("");

            // education details
            $("#exam_name").val("");
            $("#institute").val("");
            $("#board_university").val("");
            $("#group_name").val("");
            $("#result").val("");
            $("#passing_year").val("");

            //document Information
            $("#document_name").val("");
            $("#document_type").val("");
            $("#description").val("");
            $("#upload_document").val("");

            // Account Information 
            $("#account_name").val("");
            $("#bank_name").val("");
            $("#branch_name").val("");
            $("#account_no").val("");

            // Helth Information 
            $("#height").val("");
            $("#wieght").val("");
            $("#blood_group").val("");
            $("#body_identify_mark").val("");
            setTimeout(function(){
              location.reload(true);
            },3000);
          }
        }

      });
    });


  }); // end of document ready


  // the following function is for auto calculating the total salary of the enployee 
  function calculate_salary() {
    var basic_salary = $("#basic_salary").val();
    var house_rent = $("#house_rent").val();
    var medical_allowance = $("#medical_allowance").val();
    var transport_allowance = $("#transport_allowance").val();
    var insurance = $("#insurance").val();
    var commission = $("#commission").val();
    var extra_over_time = $("#extra_over_time").val();

    if (basic_salary == "") {
      basic_salary = 0;
    }

    if (house_rent == "") {
      house_rent = 0;
    }

    if (medical_allowance == "") {
      medical_allowance = 0;
    }

    if (transport_allowance == "") {
      transport_allowance = 0;
    }

    if (insurance == "") {
      insurance = 0;
    }

    if (commission == "") {
      commission = 0;
    }

    if (extra_over_time == "") {
      extra_over_time = 0;
    }

    var total_salary = parseFloat(basic_salary) + parseFloat(house_rent) + parseFloat(medical_allowance) + parseFloat(transport_allowance) + parseFloat(insurance) + parseFloat(commission) + parseFloat(extra_over_time);
    //console.log(total_salary);
    $("#total_salary").val(total_salary);
  }
  
</script>
</body>

</html>