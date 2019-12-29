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

if (isset($_POST['serial_no_edit'])) {
	$serial_no_edit = $_POST["serial_no_edit"];
	$query = "SELECT * FROM company where serial_no = '$serial_no_edit'";
	$get_company = $dbOb->find($query);

	echo json_encode($get_company);
	
}

// now the following section is going to insert and update data 
if (isset($_POST['submit'])) {

	// $category_name = $_POST["category_name"];
	$company_name = validation($_POST["company_name"]);
	$responder_name = validation($_POST["responder_name"]);
	$respoder_designation = validation($_POST["respoder_designation"]);
	$address = validation($_POST["address"]);
	$mobile_no = validation($_POST["mobile_no"]);
	$phone_no = validation($_POST["phone_no"]);
	// $user_name = validation($_POST["user_name"]);
	$fax = validation($_POST["fax"]);
	$email = validation($_POST["email"]);
	$website = validation($_POST["website"]);
	$product_type = validation($_POST["product_type"]);
	$product_quality = validation($_POST["product_quality"]);
	$description = validation($_POST["description"]);
	$edit_id = validation($_POST["edit_id"]);

	if ($edit_id) {
		$query = "UPDATE company
		set 
		
		company_name = '$company_name',
		responder_name = '$responder_name',
		respoder_designation = '$respoder_designation',
		address = '$address',
		mobile_no = '$mobile_no',
		phone_no = '$phone_no',
		
		fax = '$fax',
		email = '$email',
		website = '$website',
		product_type = '$product_type',
		product_quality = '$product_quality',
		description = '$description'
		where 
		serial_no = '$edit_id'
		";
		$update = $dbOb->update($query);
		if ($update) {
			$message = "Congratulations! Information Is Successfully Updated";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Updated";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}else{

		$query = "INSERT INTO company 
		(company_name ,responder_name,respoder_designation ,address ,mobile_no ,phone_no  ,fax ,email ,website ,product_type ,product_quality ,description )
		VALUES
		('$company_name' ,'$responder_name','$respoder_designation' ,'$address' ,'$mobile_no' ,'$phone_no' ,'$fax' ,'$email' ,'$website' ,'$product_type' ,'$product_quality' ,'$description')
		";
		$insert = $dbOb->insert($query);
		if ($insert) {
			$message = "Congratulations! Information Is Successfully Inserted";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Inserted";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}

	}
}

// the following section is for showing the table after editing and adding data into the table 
if (isset($_POST['sohag'])) {
	$query = "SELECT * FROM company ORDER BY serial_no DESC";
	$get_all_company = $dbOb->select($query);
	if ($get_all_company) {
		$i=0;
		while ($row = $get_all_company->fetch_assoc()) {
			$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['company_name'] ?></td>
				<td><?php echo $row['responder_name'] ?></td>
				<td><?php echo $row['mobile_no'] ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['product_type'] ?></td>
				
				<td align="center">
                    
                    <?php 

                    if (permission_check('company_view_button')) {
                     ?>
                     <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 
                     <?php
                   }

                   ?>
                   <?php 
                   if (permission_check('company_edit_button')) {
                     ?>
                     <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                     <?php
                   }
                   ?>
                   <?php 
                   if (permission_check('company_delete_button')) {
                     ?>
                     <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 

                     <?php
                   }
                   ?>  
                 </td>
               </tr>

                  <?php
                }
              }

}

// now its time to delete data 
if (isset($_POST['delete_id'])) {
	$delete_id = $_POST['delete_id'];
	$query = "DELETE FROM company WHERE serial_no = '$delete_id'";
	$delete = $dbOb->delete($query);
	if ($delete) {
		$message = "Congratulations! Informations Is Successfully Delete.";
		$type = 'success';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else{
		$message = "Sorry! Informations Is Not Delete.";
		$type = 'warning';
		echo json_encode(['message'=>$message,'type'=>$type]);

	}
}
?>