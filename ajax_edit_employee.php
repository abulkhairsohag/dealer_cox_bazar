<?php
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');


if (isset($_POST['submit']) ){
  //Office Information
  $e_id = validation($_POST['e_id']);
// die("sohag");
  $id_no = validation($_POST['id_no']);
  $area_name = validation($_POST['area_name']);
  $designation = validation($_POST['designation']);
  $joining_date = validation($_POST['joining_date']);
  $basic_salary = validation($_POST['basic_salary']);
  $house_rent = validation($_POST['house_rent']);
  $medical_allowance = validation($_POST['medical_allowance']);
  $transport_allowance = validation($_POST['transport_allowance']);
  $insurance = validation($_POST['insurance']);
  $commission = validation($_POST['commission']);
  $extra_over_time = validation($_POST['extra_over_time']);
  $total_salary = validation($_POST['total_salary']);
  // $user_name = validation($_POST['user_name']);
  // $password = validation($_POST['password']);
  //Basic Informaion
  $name = validation($_POST['name']);
  $fathers_name = validation($_POST['fathers_name']);
  $mothers_name = validation($_POST['mothers_name']);
  $spouses_name = validation($_POST['spouses_name']);
  $birth_date = validation($_POST['birth_date']);
  $gender = validation($_POST['gender']);
  $nid_no = validation($_POST['nid_no']);
  $birth_certificate_no = validation($_POST['birth_certificate_no']);
  $nationality = validation($_POST['nationality']);
  $religion = validation($_POST['religion']);

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
  $present_address = validation($_POST['present_address']);
  $permanent_address = validation($_POST['permanent_address']);
  $mobile_no = validation($_POST['mobile_no']);
  $phone_no = validation($_POST['phone_no']);
  $email = validation($_POST['email']);

  // education details
  $exam_name = validation($_POST['exam_name']);
  $institute = validation($_POST['institute']);
  $board_university = validation($_POST['board_university']);
  $group_name = validation($_POST['group_name']);
  $result = validation($_POST['result']);
  $passing_year = validation($_POST['passing_year']);

  //document Information
  $document_name = validation($_POST['document_name']);
  $document_type = validation($_POST['document_type']);
  $description = validation($_POST['description']);
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
  $account_name = validation($_POST['account_name']);
  $bank_name = validation($_POST['bank_name']);
  $branch_name = validation($_POST['branch_name']);
  $account_no = validation($_POST['account_no']);

  // Helth Information
  $height = validation($_POST['height']);
  $wieght = validation($_POST['wieght']);
  $blood_group = validation($_POST['blood_group']);
  $body_identify_mark = validation($_POST['body_identify_mark']);

  $active_status = validation($_POST['active_status']);

  if ($file_name) {
    $query_img = "SELECT * FROM employee_main_info WHERE serial_no = '$e_id' ";
    $get_img = $dbOb->select($query_img)->fetch_assoc();
    $img = $get_img['photo'];
    unlink($img);
    move_uploaded_file($file_temp, $uploaded_image);
    $query = "UPDATE employee_main_info SET photo='$uploaded_image' WHERE serial_no = '$e_id' ";
    $updated_main_employee = $dbOb->update($query);

  }

  $query = "UPDATE employee_main_info SET
  area_name='$area_name',designation='$designation',basic_salary='$basic_salary',house_rent='$house_rent',medical_allowance='$medical_allowance',transport_allowance='$transport_allowance',insurance='$insurance',commission='$commission',extra_over_time='$extra_over_time',total_salary='$total_salary',name='$name',fathers_name='$fathers_name',mothers_name='$mothers_name',spouses_name='$spouses_name',birth_date='$birth_date',nid_no='$nid_no',birth_certificate_no='$birth_certificate_no',nationality='$nationality',religion='$religion',present_address='$present_address',permanent_address='$permanent_address',mobile_no='$mobile_no',phone_no='$phone_no',email='$email',account_name='$account_name',bank_name='$bank_name',branch_name='$branch_name',account_no='$account_no',height='$height',wieght='$wieght',blood_group='$blood_group',body_identify_mark='$body_identify_mark',active_status='$active_status'
  WHERE serial_no = '$e_id' ";
  $updated_employee = $dbOb->update($query);


  if ($updated_employee) {
    if ($file_name_file) {
      $query = "SELECT * FROM employee_document_info WHERE main_tbl_serial_no = '$e_id'";
      $get_doc_info = $dbOb->select($query);
      if ($get_doc_info) {
        $doc_file = $get_doc_info->fetch_assoc()['upload_document'];
        unlink( $doc_file);
      }
      move_uploaded_file($file_temp_file, $uploaded_file);
      $query1 = "UPDATE employee_document_info SET
      document_name='$document_name',document_type='$document_type',description='$description',upload_document='$uploaded_file'
      WHERE main_tbl_serial_no = '$e_id' ";
    }else{
      $query1 = "UPDATE employee_document_info SET
      document_name='$document_name',document_type='$document_type',description='$description'
      WHERE main_tbl_serial_no = '$e_id' ";
    }

    $updated_document_info = $dbOb->update($query1);


    $query2 = "DELETE FROM employee_academic_info WHERE main_tbl_serial_no = '$e_id'";
    $del_academic_info = $dbOb->delete($query2);

    if ($del_academic_info) {
    for ($i = 0; $i < count($institute); $i++) { // here academic information is going to be inserted
      $insti = validation($institute[$i]);
      $exm_nam = validation($exam_name[$i]);
      $board = validation($board_university[$i]);
      $group = validation($group_name[$i]);
      $rslt = validation($result[$i]);
      $pass_ye = validation($passing_year[$i]);
      $query_academical_info = "INSERT INTO `employee_academic_info`
      (main_tbl_serial_no,institute,exam_name,board_university,group_name,result,passing_year)
      VALUES
      ('$e_id','$insti','$exm_nam','$board','$group','$rslt','$pass_ye')";

      $insert_acadmical_info = $dbOb->insert($query_academical_info);
    }


  }
  $message = "Information Updated Successfully..";
  $type = "success";
  die(json_encode(['message'=>$message,'type'=>$type]));
}else{
  $message = "Information Not Updated";
  $type = "warning";
  die(json_encode(['message'=>$message,'type'=>$type]));
}
}



?>