<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
?>

<?php
include_once("class/Database.php");
$dbOb = new Database();

// In this Section We Are Going to add an Employee
if (isset($_POST['submit'])) {

	//Office Information
	$id_no = $_POST['id_no'];
	$area_name = $_POST['area_name'];
	$designation = $_POST['designation'];
	$joining_date = $_POST['joining_date'];
	$basic_salary = $_POST['basic_salary'];
	$house_rent = $_POST['house_rent'];
	if ($house_rent == '') {
		$house_rent = 0;
	}
	$medical_allowance = $_POST['medical_allowance'];
	if ($medical_allowance == '') {
		$medical_allowance = 0;
	}
	$transport_allowance = $_POST['transport_allowance'];
	if ($transport_allowance == '') {
		$transport_allowance = 0;
	}
	$insurance = $_POST['insurance'];
	if ($insurance == '') {
		$insurance = 0;
	}
	$commission = $_POST['commission'];
	if ($commission == '') {
		$commission = 0;
	}
	$extra_over_time = $_POST['extra_over_time'];
	if ($extra_over_time == '') {
		$extra_over_time = 0;
	}
	$total_salary = $_POST['total_salary'];

	$user_name = $_POST['user_name'];
	$password = $_POST['password'];

	if (isset($_POST['create_confirmation'])) {
		$create_confirmation =  1;
	}else{
		$create_confirmation =  0;
		$user_name = "";
		$password = "";
	}




	//Basic Informaion
	$name =$_POST['name'];
	$fathers_name =$_POST['fathers_name'];
	$mothers_name =$_POST['mothers_name'];
	$spouses_name =$_POST['spouses_name'];
	$birth_date = $_POST['birth_date'];
	$gender = $_POST['gender'];
	$nid_no =$_POST['nid_no'];
	$birth_certificate_no =$_POST['birth_certificate_no'];
	$nationality =$_POST['nationality'];
	$religion =$_POST['religion'];

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
	$present_address =$_POST['present_address'];
	$permanent_address =$_POST['permanent_address'];
	$mobile_no =$_POST['mobile_no'];
	$phone_no =$_POST['phone_no'];
	$email =$_POST['email'];

	// education details
	$exam_name =$_POST['exam_name'];
	$institute =$_POST['institute'];
	$board_university =$_POST['board_university'];
	$group_name =$_POST['group_name'];
	$result =$_POST['result'];
	$passing_year =$_POST['passing_year'];

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
	$account_name =$_POST['account_name'];
	$bank_name =$_POST['bank_name'];
	$branch_name =$_POST['branch_name'];
	$account_no =$_POST['account_no'];

	// Helth Information
	$height =$_POST['height'];
	$wieght =$_POST['wieght'];
	$blood_group =$_POST['blood_group'];
	$body_identify_mark =$_POST['body_identify_mark'];

	// active status 
	$active_status = $_POST['active_status'];

	$last_insert_id = '';


	$query = "SELECT nid_no FROM `employee_main_info` WHERE nid_no = '$nid_no'";
	$find_employee = $dbOb->find($query);
	if ($find_employee) {
		$message = "Sorry! Information Is NOt Saved. One Employee With NID Number: $nid_no, Already Exists. Multiple Person Cannot Have Same NID Number";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);
	} else {

		//now its time to insert
		if (!empty($file_name)) {
			if (!in_array($file_extension, $permitted)) {
				$message = "Please Upload Image With Extension : " . implode(', ', $permitted);
				$type = "warning";
				echo json_encode(['message' => $message, 'type' => $type]);
			} else {
				if (move_uploaded_file($file_temp, $uploaded_image)) {
					$query = "INSERT INTO employee_main_info
				(id_no,area_name,designation,joining_date,basic_salary,house_rent,medical_allowance,transport_allowance,insurance,commission,extra_over_time,total_salary,user_name,password,name,fathers_name,mothers_name,spouses_name,birth_date,gender,nid_no,birth_certificate_no,nationality,religion,photo,present_address,permanent_address,mobile_no,phone_no,email,account_name,bank_name,branch_name,account_no,height,wieght,blood_group,body_identify_mark,active_status)
				VALUES
				('$id_no','$area_name','$designation','$joining_date','$basic_salary','$house_rent','$medical_allowance','$transport_allowance','$insurance','$commission','$extra_over_time','$total_salary','$user_name','$password','$name','$fathers_name','$mothers_name','$spouses_name','$birth_date','$gender','$nid_no','$birth_certificate_no','$nationality','$religion','$uploaded_image','$present_address','$permanent_address','$mobile_no','$phone_no','$email','$account_name','$bank_name','$branch_name','$account_no','$height','$wieght','$blood_group','$body_identify_mark','$active_status')";
					$last_insert_id = $dbOb->custom_insert($query);

					if ($last_insert_id) {

						$query = "INSERT INTO id_no_generator (id,id_type) VALUES ('$id_no','employee')";
						$insert_id = $dbOb->insert($query);

						if (!empty($file_name_file)) { // here data will be inserted if a document is selected
							if (!in_array($file_extension_file, $permitted_file)) {
								$message = "Please Upload Document With Extension : " . implode(', ', $permitted_file);
								$type = "warning";
								echo json_encode(['message' => $message, 'type' => $type]);
							} else { // the following section will be executed if file extension is matched ie document extension matched
								if (move_uploaded_file($file_temp_file, $uploaded_file)) { // firstly if document is transfared then data will be inserted into database
									$query_document_info = "INSERT INTO `employee_document_info`
									(main_tbl_serial_no,document_name,document_type,description,upload_document)
									VALUES
									('$last_insert_id','$document_name','$document_type','$description','$uploaded_file')";

									$insert_document_info = $dbOb->insert($query_document_info);

									if ($insert_document_info) { // in this section if employee_document_info table is inserted then the academic info will be inserted

										for ($i = 0; $i < count($institute); $i++) { // here academic information is going to be inserted
											$query_academical_info = "INSERT INTO `employee_academic_info`
											(main_tbl_serial_no,institute,exam_name,board_university,group_name,result,passing_year)
											VALUES
											('$last_insert_id','$institute[$i]','$exam_name[$i]','$board_university[$i]','$group_name[$i]','$result[$i]','$passing_year[$i]')";

											$insert_acadmical_info = $dbOb->insert($query_academical_info);
										}
										if (true) {
											//here  user name and password will be inserted to the login table 
											///////////////////////////////////////////////////////////////////////////////////////////////////
											
											if ($create_confirmation == 1) {
												$query = "INSERT INTO login (name,username,password,email,user_id,user_type)
												VALUES ('$name','$user_name','$password','$email','$last_insert_id','employee')";
												$insert_login = $dbOb->insert($query);

												if ($insert_login) {
													$message = "Congratulations! Information Successfully Saved";
													$type =  "success";
													echo json_encode(['type' => $type, 'message' => $message]);
												} else {
													$message = "Sorry! Information Is Not Saved.";
													$type = "warning";
													echo json_encode(['type' => $type, 'message' => $message]);
												}
											}else{
												$message = "Congratulations! Information Successfully Saved";
												$type =  "success";
												echo json_encode(['type' => $type, 'message' => $message]);
											}
											
										} else {
											$message = "sorry! Information Is NOt Saved  with file and image upload";
											$type = "warning";
											echo json_encode(['message' => $message, 'type' => $type]);
										}
									} else { // end of if ($insert_document_info)
										$message = "sorry! document_info table is not saved ie query not executed";
										$type = "warning";
										echo json_encode(['message' => $message, 'type' => $type]);
									}
								} else { // end of if (move_uploaded_file($file_tem_file, $uploaded_file))

									$message = "Document Not Saved To Folder";
									$type = "warning";
									echo json_encode(['message' => $message, 'type' => $type]);
								}
							}
						} else { // here data will be inserted if a document is not selected

							$query_document_info = "INSERT INTO `employee_document_info`
								(main_tbl_serial_no,document_name,document_type,description,upload_document)
								VALUES
								('$last_insert_id','$document_name','$document_type','$description','')";

							$insert_document_info = $dbOb->insert($query_document_info);

							if ($insert_document_info) { // in this section if employee_document_info table is inserted then the academic info will be inserted

								for ($i = 0; $i < count($institute); $i++) { // here academic information is going to be inserted
									$query_academical_info = "INSERT INTO `employee_academic_info`
									(main_tbl_serial_no,institute,exam_name,board_university,group_name,result,passing_year)
									VALUES
									('$last_insert_id','$institute[$i]','$exam_name[$i]','$board_university[$i]','$group_name[$i]','$result[$i]','$passing_year[$i]')";
									$insert_acadmical_info = $dbOb->insert($query_academical_info);
								}
								if ($insert_acadmical_info) {
									$query = "INSERT INTO login (name,username,password,email,user_id,user_type)
											  VALUES ('$name','$user_name','$password','$email','$last_insert_id','employee')";
									$insert_login = $dbOb->insert($query);
									if ($insert_login) {
										$message = "Congratulations! Information Successfully Saved";
										$type =  "success";
										echo json_encode(['type' => $type, 'message' => $message]);
									} else {
										$message = "Sorry! Information Is Not Saved.";
										$type = "warning";
										echo json_encode(['type' => $type, 'message' => $message]);
									}
								} else {
									$message = "sorry! Information Is NOt Saved  with file and image upload";
									$type = "warning";
									echo json_encode(['message' => $message, 'type' => $type]);
								}
							} else { // end of if ($insert_document_info)
								$message = "sorry! document_info table is not saved ie query not executed";
								$type = "warning";
								echo json_encode(['message' => $message, 'type' => $type]);
							}
						} // end of else of  if (!empty($file_name_file))
					} else {
						$message = "Sorry! Information Is Not Saved.";
						$type = "warning";
						echo json_encode(['message' => $message, 'type' => $type]);
					}
				} else {
					$message = "Sorry! Image Not Saved To Folder. And Information Is Not Saved.";
					$type = "warning";
					echo json_encode(['message' => $message, 'type' => $type]);
				}
			}
		}
	}
} // End of if(isset[$_POST['submit']])
