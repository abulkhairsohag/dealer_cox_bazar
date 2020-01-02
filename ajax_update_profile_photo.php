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



// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	$user_id = validation($_POST['user_id']);
	$user_type = validation($_POST['user_type']);

    $profile_photo = $_FILES['profile_photo'];

    $permitted = array('jpg','png','gif','jpeg');
    $file_name = $profile_photo['name'];
    $file_size = $profile_photo['size'];
    $file_temp = $profile_photo['tmp_name'];

    $div = explode(".", $file_name);
    $file_extension = strtolower(end($div));
  
    $unique_image = md5(time()); 
    $unique_image= substr($unique_image, 0,10).'.'.$file_extension;
    $uploaded_image = 'images/'.$unique_image;




    if ($user_type == "employee") {
	  $query = "SELECT * FROM employee_main_info WHERE serial_no = '$user_id' ";
	  $get_emp_info =  $dbOb->find($query);
	  $photo = $get_emp_info['photo'];
	  
	   if ($photo) {
        	unlink($photo);
	    }
	   if ( move_uploaded_file($file_temp, $uploaded_image)) {
		   	$query_update = "UPDATE employee_main_info SET photo = '$uploaded_image' WHERE serial_no = '$user_id' ";
		    $update_photo = $dbOb->update($query_update);
	   }
	    
	    if ($update_photo) {
	    	$message = "Profile Photo Updated Successfully";
	    	$type = "success";
	    	echo json_encode(["message"=>$message,"type"=>$type,'uploaded_image'=>$uploaded_image]);
	    }else{
	    	$message = "Profile Photo Update Failed";
	    	$type = "warning";
	    	echo json_encode(["message"=>$message,"type"=>$type]);
	     }

}

}

?>