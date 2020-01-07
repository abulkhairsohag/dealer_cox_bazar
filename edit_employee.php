<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('employee_edit_button')){
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

  if (isset($_GET['serial_no'])) {
    $e_id = $_GET['serial_no'];
  }else{ ?>
    <script>
      window.location.href = "employee_list.php"
    </script>
  <?php }






  $query = "SELECT * FROM employee_main_info WHERE serial_no = '$e_id' ";
  $get_area = $dbOb->select($query)->fetch_assoc();
  if ($get_area) {
    $id = $get_area['serial_no'];
    $id_no = $get_area['id_no'];
    $area_name1 = $get_area['area_name'];
    $designation = $get_area['designation'];
    $joining_date = $get_area['joining_date'];
    $basic_salary = $get_area['basic_salary'];
    $house_rent = $get_area['house_rent'];
    $medical_allowance = $get_area['medical_allowance'];
    $transport_allowance = $get_area['transport_allowance'];
    $insurance = $get_area['insurance'];
    $commission = $get_area['commission'];
    $extra_over_time = $get_area['extra_over_time'];
    $total_salary = $get_area['total_salary'];
    $user_name = $get_area['user_name'];
    $name = $get_area['name'];
    $fathers_name = $get_area['fathers_name'];
    $mothers_name = $get_area['mothers_name'];
    $spouses_name = $get_area['spouses_name'];
    $birth_date = $get_area['birth_date'];
    $gender = $get_area['gender'];
    $nid_no = $get_area['nid_no'];
    $birth_certificate_no = $get_area['birth_certificate_no'];
    $nationality = $get_area['nationality'];
    $religion = $get_area['religion'];
    $photo = $get_area['photo'];
    $present_address = $get_area['present_address'];
    $permanent_address = $get_area['permanent_address'];
    $mobile_no = $get_area['mobile_no'];
    $phone_no = $get_area['phone_no'];
    $email = $get_area['email'];
    $account_name = $get_area['account_name'];
    $bank_name = $get_area['bank_name'];
    $branch_name = $get_area['branch_name'];
    $account_no = $get_area['account_no'];
    $height = $get_area['height'];
    $wieght = $get_area['wieght'];
    $blood_group = $get_area['blood_group'];
    $body_identify_mark = $get_area['body_identify_mark'];
    $active_status = $get_area['active_status'];

  }

  $query1 = "SELECT * FROM employee_document_info WHERE main_tbl_serial_no = '$id' ";
  $employee_document = $dbOb->select($query1)->fetch_assoc();
  if ($employee_document) {
    $document_name = $employee_document['document_name'];
    $document_type = $employee_document['document_type'];
    $description = $employee_document['description'];
    $upload_document = $employee_document['upload_document'];
  }
  ?>
  <form id="add_data_form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="" enctype="multipart/form-data">
    <div class="sohag">
      <marquee direction="">Edit Employee Information</marquee>
    </div>
    <div style="font-size: 16px;color: red" align="center">Pelase Fill Up All * (star) Marked Fields Before Adding Employee</div>
    <div id="accordion">
      <h3 class="accordian_sohag">Office Information</h3>
      <div>
        <div class="row ">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content accordian_field">
                <br />
                <input type="hidden" name="e_id"  value="<?php echo $e_id ; ?>">
                <!-- Form Starts From Here  -->
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ID No <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="id_no" name="id_no" readonly="" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $id_no ?>" >
                  </div>
                </div>
                <div class="form-group">
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
                          $area_name = $row['area_name'];
                          ?>
                          <option value="<?php echo $area_name ?>" <?php if ($area_name == $area_name1) { ?> selected  <?php  } ?> ><?php echo $area_name ?></option>

                          <?php
                        }
                      }
                      ?>

                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Designation<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="designation" class="form-control col-md-7 col-xs-12" type="text" name="designation" required="" value="<?php echo $designation ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Joining Date <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="joining_date" class=" form-control col-md-7 col-xs-12" required="required" value="<?php echo $joining_date ?>" readonly="" placeholder="Select Joining Date">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Basic Salary (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="basic_salary" class="form-control col-md-7 col-xs-12" type="number" min="0" name="basic_salary" required="" value="<?php echo $basic_salary ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">House Rent (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="house_rent" class="form-control col-md-7 col-xs-12" type="number" min="0" name="house_rent" required="" value="<?php echo $house_rent ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Medical Allowance (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="medical_allowance" class="form-control col-md-7 col-xs-12" type="number" min="0" name="medical_allowance" required="" value="<?php echo $medical_allowance ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Transport Allowance (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="transport_allowance" class="form-control col-md-7 col-xs-12" type="number" min="0" name="transport_allowance" required="" value="<?php echo $transport_allowance ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Insurance (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="insurance" class="form-control col-md-7 col-xs-12" type="number" min="0" name="insurance" required="" value="<?php echo $insurance ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Commission (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" min="0" id="commission" class="form-control col-md-7 col-xs-12" name="commission" required="" value="<?php echo $commission ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Exra Over Time (tk)<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="extra_over_time" class="form-control col-md-7 col-xs-12" type="number" min="0" name="extra_over_time" required="" value="<?php echo $extra_over_time ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Salary (tk)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="total_salary" class="form-control col-md-7 col-xs-12" type="number" min='0' name="total_salary" readonly="" style="background: #2996A5;color: white;text-align: center;"  value="<?php echo $total_salary ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User Name  <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" required="" readonly="" id="user_name" name="user_name" class="form-control col-md-7 col-xs-12" value="<?php echo $user_name ?>" >
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
                    <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst($name) ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Father's Name <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fathers_name" name="fathers_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $fathers_name ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mother's name<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="mothers_name" class="form-control col-md-7 col-xs-12" type="text" name="mothers_name" required="" value="<?php echo $mothers_name ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Spouse's name</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="spouses_name" class="form-control col-md-7 col-xs-12" type="text" name="spouses_name" value="<?php echo $spouses_name ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required" style="color: red">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="birth_date" name="birth_date" class="date-picker form-control col-md-7 col-xs-12 datepicker" required="required" readonly='' placeholder="Select Date Of Birth" value="<?php echo $birth_date ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Gender<span class="required" style="color: red">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <input id="gender" class="form-control col-md-7 col-xs-12" type="text" name="gender" required="" value="<?php echo $gender ?>">
                 </div>
               </div>
               <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">NID Number<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="nid_no" class="form-control col-md-7 col-xs-12" type="number" name="nid_no" required="" value="<?php echo $nid_no ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Birth Certificate No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="birth_certificate_no" class="form-control col-md-7 col-xs-12" type="text" name="birth_certificate_no" value="<?php echo $birth_certificate_no ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Nationality<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="nationality" class="form-control col-md-7 col-xs-12" type="text" name="nationality" required="" value="<?php echo $nationality ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Religion<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="religion" class="form-control col-md-7 col-xs-12" type="text" name="religion" required="" value="<?php echo $religion ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" style=" padding-top: 20px;" class=" control-label col-md-3 col-sm-3 col-xs-12">Photo<span class="required" style="color: red;">*</span></label>
                <div class="col-md-5 col-sm-5 col-xs-12" style=" padding-top: 12px;">
                  <input id="photo" class="form-control col-md-7 col-xs-12" type="file" name="photo" >
                </div>
                <div class="col-md-1 col-sm-1 col-xs-12" >
                  <img width="80px" height="60px" src="<?php echo $photo ?>" alt="">
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
                  <input type="text" id="present_address" name="present_address" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $present_address ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Permanent Address<span class="required" style="color: red">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="permanent_address" name="permanent_address" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $permanent_address ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Number<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="mobile_no" class="form-control col-md-7 col-xs-12" type="text" name="mobile_no" required="" value="<?php echo $mobile_no ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="phone_no" class="form-control col-md-7 col-xs-12" type="text" name="phone_no" value="<?php echo $phone_no ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="email" id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="example: abc@sometext.com" value="<?php echo $email ?>">
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
              <?php 
              $query2 = "SELECT * FROM employee_academic_info WHERE main_tbl_serial_no = '$id' ";
              $employee_academic = $dbOb->select($query2);
              if ($employee_academic) {
                while ($result = $employee_academic->fetch_assoc()) { ?>
                  <tr>
                    <td><input type="text" class="form-control" id="exam_name" name="exam_name[]" required="" value="<?php echo $result['exam_name'];  ?>"></td>
                    <td><input type="text" class="form-control" id="institute" name="institute[]" required="" value="<?php echo $result['institute'];  ?>"></td>
                    <td><input type="text" class="form-control" id="board_university" name="board_university[]" required="" value="<?php echo $result['board_university'];  ?>"></td>
                    <td><input type="text" class="form-control" id="group_name" name="group_name[]" required="" value="<?php echo $result['group_name'];  ?>"></td>
                    <td><input type="number" min="0" step="0.01" class="form-control" id="result" name="result[]" required="" value="<?php echo $result['result'];  ?>"></td>
                    <td><input type="number" min="0" step="1" class="form-control" id="passing_year" name="passing_year[]" required="" value="<?php echo $result['passing_year'];  ?>"></td>
                    <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>
                  </tr>

                <?php } 
              }

              ?>
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
                  <input type="text" id="document_name" name="document_name" class="form-control col-md-7 col-xs-12"value="<?php echo $document_name ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Document Type
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="document_type" name="document_type" class="form-control col-md-7 col-xs-12"value="<?php echo $document_type ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea id="description" class="form-control col-md-7 col-xs-12" type="text" name="description"><?php echo $description ?></textarea>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Account Name<span class="required" style="color: red">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="account_name" name="account_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $account_name ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Bank Name<span class="required" style="color: red">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="bank_name" name="bank_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $bank_name ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="branch_name" class="form-control col-md-7 col-xs-12" type="text" name="branch_name" required="" value="<?php echo $branch_name ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Account Number<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="account_no" class="form-control col-md-7 col-xs-12" type="number" name="account_no" required="" value="<?php echo $account_no ?>">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Height<span class="required" style="color: red">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="height" name="height" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $height ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Weight<span class="required" style="color: red">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="wieght" name="wieght" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $wieght ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Blood Group<span class="required" style="color: red">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="blood_group" id="blood_group" class="form-control col-md-7 col-xs-12" required="">
                    <option value="">Select Blood Group</option>
                    <option value="A (+ve)" <?php if ($blood_group == 'A (+ve)') {
                      echo "selected";
                    } ?>>A (+ve)</option>
                    <option value="B (+ve)" <?php if ($blood_group == 'B (+ve)') {
                      echo "selected";
                    } ?>>B (+ve)</option>
                    <option value="AB (+ve)" <?php if ($blood_group == 'AB (+ve)') {
                      echo "selected";
                    } ?>>AB (+ve)</option>
                    <option value="O (+ve)" <?php if ($blood_group == 'O (+ve)') {
                      echo "selected";
                    } ?>>O (+ve)</option>
                    <option value="A (-ve)" <?php if ($blood_group == 'A (-ve)') {
                      echo "selected";
                    } ?>>A (-ve)</option>
                    <option value="B (-ve)" <?php if ($blood_group == 'B (-ve)') {
                      echo "selected";
                    } ?>>B (-ve)</option>
                    <option value="AB (-ve)" <?php if ($blood_group == 'AB (-ve)') {
                      echo "selected";
                    } ?>>AB (-ve)</option>
                    <option value="O (-ve)" <?php if ($blood_group == 'O (-ve)') {
                      echo "selected";
                    } ?>>O (-ve)</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Body Identify Mark</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="body_identify_mark" class="form-control col-md-7 col-xs-12" type="text" name="body_identify_mark" value="<?php echo $body_identify_mark ?>">
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
          <input type="radio" class="flat" required="" id="active" name="active_status" value="Active" <?php if ($active_status == 'Active') {
            echo 'checked';
          } ?>> <span style="color: green">Active</span>
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" class="flat" required="" id="inactive" name="active_status" value="Inactive" <?php if ($active_status == 'Inactive') {
            echo 'checked';
          } ?> > <span style="color: red">Inactive</span>
        </label>
      </div>
    </div>
  </div>


  <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px">
    <input class="btn btn-success  btn-block" type="submit" name="edit_employee" id="submit_employee" value="Edit Employee" style="height: 50px;font-size: 20px" title="Pelase Fill Up All * Mrked Fields Before Editing Employee">

  </div>
</form>
</div>
<!-- /page content -->
</div>
</div>
<?php include_once('include/footer.php'); ?>


<script>
  $(document).ready(function() {
    // $('#submit_employee').click(function(){
    //   var form = $('#add_data_form');
    //   form[0].submit();
    // })
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

   $('#submit_employee').click(function(){
    console.log("sohag");
      // var form = $('#add_data_form');
      // form[0].submit();
       var formData = new FormData($("#add_data_form")[0]);
      formData.append("submit", "submit");
       $.ajax({
        url: "ajax_edit_employee.php",
        data: formData,
        type: "POST",
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
         if (data.type == "success") {
             swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
             setTimeout(function(){ 
              window.location = 'employee_list.php'; }, 2000);
         }
        }
      });
    })

    


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