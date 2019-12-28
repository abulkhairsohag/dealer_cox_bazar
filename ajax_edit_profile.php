<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
$user_type = Session::get("user_type");
?>


<?php 

include_once("class/Database.php");
$dbOb = new Database();

if (isset($_GET['submit_edit'])) {

	$organization_name = $dbOb->link->real_escape_string($_GET["organization_name"]);
	$address		   = $dbOb->link->real_escape_string($_GET["address"]);
	$mobile_no 		   = $dbOb->link->real_escape_string($_GET["mobile_no"]);
	$phone_no 		   = $dbOb->link->real_escape_string($_GET["phone_no"]);
	$email			   = $dbOb->link->real_escape_string($_GET["email"]);
	$website   		   = $dbOb->link->real_escape_string($_GET["website"]);
	$api_url           = $dbOb->link->real_escape_string($_GET["api_url"]);
	$license_code      = $dbOb->link->real_escape_string($_GET["license_code"]);
	$edit_id		   = $dbOb->link->real_escape_string($_GET["edit_id"]);

	$query = "UPDATE profile 
	SET 
	organization_name = '$organization_name',
	address = '$address',
	mobile_no = '$mobile_no',
	phone_no = '$phone_no',
	email = '$email',
	website = '$website',
	api_url = '$api_url',
	license_code = '$license_code'
	WHERE 
	serial_no = '$edit_id'
	";
	$update_info = $dbOb->update($query);
	if ($update_info) {
		$message = 'Information successfully updated.';
		$type = 'success';
		echo json_encode([
			'message'=>$message,
			'type'=>$type,
			'organization_name'=>$organization_name,
			'address'=>$address,
			'mobile_no'=>$mobile_no,
			'phone_no'=>$phone_no,
			'email'=>$email,
			'website'=>$website,
			'api_url'=>$api_url,
			'license_code'=>$license_code
		]);
	}else{
		$message = 'Information not updated.';
		$type = 'warning';
		echo json_encode(['messsage'=>$messsage,'type'=>$type]);
	}

}

if (isset($_POST['serial_no_edit_info'])) {
	$serial_no = $_POST['serial_no_edit_info'];
	$query = "SELECT * FROM profile WHERE serial_no = '$serial_no'";	
	$get_profile_detailas = $dbOb->find($query);
	echo json_encode($get_profile_detailas);

}


// the following section is for updating logo and favicon 

if (isset($_POST['submit_edit_logo'])) {
	$serial_no = $_POST['serial_no'];
	$favicon = $_FILES['favicon'];
	$logo = $_FILES['logo'];


	$permitted = array('jpg','png','gif','jpeg');
	$file_name = $logo['name'];
	$file_size = $logo['size'];
	$file_temp = $logo['tmp_name'];

	$file_name2 = $favicon['name'];
	$file_size2 = $favicon['size'];
	$file_temp2 = $favicon['tmp_name'];


	$div = explode(".", $file_name);
	$file_extension = strtolower(end($div));
	$file_extension = strtolower($file_extension);
	$unique_image = md5(time()); 
	$unique_image= substr($unique_image, 0,10).'.'.$file_extension;
	$uploaded_image = 'logo/'.$unique_image;

	$div2 = explode(".", $file_name2);
	$file_extension2 = strtolower(end($div2));
	$file_extension2 = strtolower($file_extension2);
	$unique_image2 = md5(time()); 
	$unique_image2= substr($unique_image, 0,10).'.'.$file_extension2;
	$uploaded_image2 = 'favicon/'.$unique_image2;

	$query ="SELECT logo,favicon FROM profile WHERE serial_no = '$serial_no'";
	$get_logo = $dbOb->find($query);

	if(!empty($file_name) ){

		if (!in_array($file_extension, $permitted)) {
			$message =  "Data not updated. Please Upload Image With Extension : ".implode(', ',$permitted);
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{

			if ($get_logo) {
				unlink($get_logo['logo']);
			}
			move_uploaded_file($file_temp, $uploaded_image);
			
			$query = "UPDATE profile
			SET 
			logo = '$uploaded_image'
			WHERE
			serial_no = '$serial_no'";
			$update_logo = $dbOb->update($query);
		}

	}



	if (!empty($file_name2)) {

		if (!in_array($file_extension2, $permitted)) {
			$message =  "Data not updated. Please Upload Image With Extension : ".implode(', ',$permitted);
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{

			if ($get_logo) {
				unlink($get_logo['favicon']);
			}
			move_uploaded_file($file_temp2, $uploaded_image2);

			$query = "UPDATE profile
			SET 
			favicon = '$uploaded_image2' 
			WHERE
			serial_no = '$serial_no'";
			$update_favicon = $dbOb->update($query);
			

		}
		
	}






	if ($update_logo && $update_favicon) {

		$message =  "Logo And Favicon Is Successfully Updated.";
		$type = 'success';
		echo json_encode(['message'=>$message,'type'=>$type]);

	}else if ($update_logo) {
		$message =  "Logo is successfully updated.";
		$type = 'success';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else if ($update_favicon) {
		$message =  "Favicon is successfully updated.";
		$type = 'success';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}

	
}

?>