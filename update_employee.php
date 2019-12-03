<?php 
include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
include_once("class/Database.php");
$dbOb = new Database();




// edit code   


// In this Section We Are Going to add an Employee
if (isset($_POST['edit_employee'])) {

  //Office Information
  $id_no = $_POST['id_no'];
  $area_name = $_POST['area_name'];
  $designation = $_POST['designation'];
  $joining_date = $_POST['joining_date'];
  $basic_salary = $_POST['basic_salary'];
  $house_rent = $_POST['house_rent'];
  $medical_allowance = $_POST['medical_allowance'];
  $transport_allowance = $_POST['transport_allowance'];
  $insurance = $_POST['insurance'];
  $commission = $_POST['commission'];
  $extra_over_time = $_POST['extra_over_time'];
  $total_salary = $_POST['total_salary'];
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];

  //Basic Informaion
  $name = $_POST['name'];
  $fathers_name = $_POST['fathers_name'];
  $mothers_name = $_POST['mothers_name'];
  $spouses_name = $_POST['spouses_name'];
  $birth_date = $_POST['birth_date'];
  $gender = $_POST['gender'];
  $nid_no = $_POST['nid_no'];
  $birth_certificate_no = $_POST['birth_certificate_no'];
  $nationality = $_POST['nationality'];
  $religion = $_POST['religion'];

  $photo = $_FILES['photo'];
  $permitted = array('jpg', 'png', 'gif', 'jpeg');
  $file_name = $photo['name'];
  $file_size = $photo['size'];
  $file_temp = $photo['tmp_name'];
  $div = explode(".", $file_name);
  $file_extension = strtolower(end($div));
  $file_extension = strtolower($file_extension);
  $unique_image = md5(time());
  $unique_image = substr($unique_image, 0, 10) . '.' . $file_extension;
  $uploaded_image = 'images/' . $unique_image;

  //Contact Information
  $present_address = $_POST['present_address'];
  $permanent_address = $_POST['permanent_address'];
  $mobile_no = $_POST['mobile_no'];
  $phone_no = $_POST['phone_no'];
  $email = $_POST['email'];

  // education details
  $exam_name = $_POST['exam_name'];
  $institute = $_POST['institute'];
  $board_university = $_POST['board_university'];
  $group_name = $_POST['group_name'];
  $result = $_POST['result'];
  $passing_year = $_POST['passing_year'];

  //document Information
  $document_name = $_POST['document_name'];
  $document_type = $_POST['document_type'];
  $description = $_POST['description'];
  $upload_document = $_FILES['upload_document'];

  if ($upload_document) {
    $permitted_file = array('pptx', 'ppt', 'docx', 'doc', 'pdf');
    $file_name_file = $upload_document['name'];
    $file_size_file = $upload_document['size'];
    $file_temp_file = $upload_document['tmp_name'];


    $div_file = explode(".", $file_name_file);
    $file_extension_file = strtolower(end($div_file));
    $file_extension_file = strtolower($file_extension_file);
    $unique_file = md5(time());
    $unique_file = substr($unique_file, 0, 10) . '.' . $file_extension_file;
    $uploaded_file = 'file/' . $unique_file;
  }

  // Account Information 
  $account_name = $_POST['account_name'];
  $bank_name = $_POST['bank_name'];
  $branch_name = $_POST['branch_name'];
  $account_no = $_POST['account_no'];

  // Helth Information
  $height = $_POST['height'];
  $wieght = $_POST['wieght'];
  $blood_group = $_POST['blood_group'];
  $body_identify_mark = $_POST['body_identify_mark'];

if ($file_name) {
	unlink($p_photo);
  move_uploaded_file($file_temp, $uploaded_image);
  $query = "UPDATE employee_main_info SET photo='$uploaded_image' WHERE serial_no = '$e_id' ";
  $updated_employee = $dbOb->update($query);
  ?>
<script>
  swal("Edit successfully", "You clicked the button!", "success");
</script>
  <?php
}

        $query = "UPDATE employee_main_info SET
              area_name='$area_name',designation='$designation',basic_salary='$basic_salary',house_rent='$house_rent',medical_allowance='$medical_allowance',transport_allowance='$transport_allowance',insurance='$insurance',commission='$commission',extra_over_time='$extra_over_time',total_salary='$total_salary',name='$name',fathers_name='$fathers_name',mothers_name='$mothers_name',spouses_name='$spouses_name',birth_date='$birth_date',nid_no='$nid_no',birth_certificate_no='$birth_certificate_no',nationality='$nationality',religion='$religion',present_address='$present_address',permanent_address='$permanent_address',mobile_no='$mobile_no',phone_no='$phone_no',email='$email',account_name='$account_name',bank_name='$bank_name',branch_name='$branch_name',account_no='$account_no',height='$height',wieght='$wieght',blood_group='$blood_group',body_identify_mark='$body_identify_mark'
            WHERE serial_no = '$e_id' ";
    $updated_employee = $dbOb->update($query);
    if ($updated_employee) {
      move_uploaded_file($file_temp_file, $uploaded_file);
      $query1 = "UPDATE employee_document_info SET
              document_name='$document_name',document_type='$document_type',description='$description',upload_document='$uploaded_file'
            WHERE main_tbl_serial_no = '$e_id' ";
            $updated_document_info = $dbOb->update($query1);
    }
    if ($updated_document_info) {

    $query2 = "DELETE FROM employee_academic_info WHERE main_tbl_serial_no = '$e_id'";
    $del_academic_info = $dbOb->delete($query2);

    if ($del_academic_info) {
    for ($i = 0; $i < count($institute); $i++) { // here academic information is going to be inserted
      $query_academical_info = "INSERT INTO `employee_academic_info`
      (main_tbl_serial_no,institute,exam_name,board_university,group_name,result,passing_year)
      VALUES
      ('$e_id','$institute[$i]','$exam_name[$i]','$board_university[$i]','$group_name[$i]','$result[$i]','$passing_year[$i]')";

      $insert_acadmical_info = $dbOb->insert($query_academical_info);
    }
    if ($insert_acadmical_info) {
       ?>
<script>
  swal("Edit successfully", "You clicked the button!", "success");
</script>
  <?php
    }

    }
  }
}




// end code

