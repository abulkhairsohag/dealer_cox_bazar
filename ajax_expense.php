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
	$serial_no_edit = $_POST['serial_no_edit'];
	$query = "SELECT * FROM expense WHERE serial_no = '$serial_no_edit'";
	$get_expense = $dbOb->find($query);
	echo json_encode($get_expense);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	$expense_type = $_POST['expense_type'];
	$client_name = $_POST['client_name'];
	$organization_name = $_POST['organization_name'];
	$address = $_POST['address'];
	$mobile_no = $_POST['mobile_no'];
	$invoice_docs_no = $_POST['invoice_docs_no'];
	$total_amount = $_POST['total_amount'];
	$paid_amount = $_POST['paid_amount'];
	$due_amount = $_POST['due_amount'];
	$description = $_POST['description'];
	$next_paid_date = $_POST['next_paid_date'];
	$edit_id = $_POST['edit_id'];
	$expense_date = date('d-m-Y');

	$invoice_docs_img = $_FILES['invoice_docs_img'];


	$permitted = array('jpg','png','gif','jpeg');
	$file_name = $invoice_docs_img['name'];
	$file_size = $invoice_docs_img['size'];
	$file_temp = $invoice_docs_img['tmp_name'];

	$div = explode(".", $file_name);
	$file_extension = strtolower(end($div));
	
	$unique_image = md5(time()); 
	$unique_image= substr($unique_image, 0,10).'.'.$file_extension;
	$uploaded_image = 'invoice_img/'.$unique_image;



	if ($edit_id) { // update informaion


		$query = "SELECT * FROM expense WHERE serial_no = '$edit_id'";
		$get_exp = $dbOb->find($query);
		$get_img = $get_exp['invoice_docs_img'];


			if(!empty($file_name) ){

			if (!in_array($file_extension, $permitted)) {
				$message =  "Data not updated. Please Upload Image With Extension : ".implode(', ',$permitted);
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
				die();
			}else{

				if ($get_img) {
					unlink($get_img);
				}
				move_uploaded_file($file_temp, $uploaded_image);
				
				$query = "UPDATE expense
				SET 
				invoice_docs_img = '$uploaded_image'
				WHERE
				serial_no = '$edit_id'";
				$update_logo = $dbOb->update($query);
			}

		}


		$query = "UPDATE expense 
		SET 
		expense_type = '$expense_type',
		client_name = '$client_name',
		organization_name 	='$organization_name',
		address ='$address',
		mobile_no = '$mobile_no',
		invoice_docs_no = '$invoice_docs_no',
		total_amount = '$total_amount',
		paid_amount 	= '$paid_amount',
		due_amount 	= '$due_amount',
		next_paid_date 	= '$next_paid_date',
		description 	= '$description'
		
		WHERE
		serial_no = '$edit_id' ";

		$update = $dbOb->update($query);
		if ($update) {
			$message = "Congratulaitons! Information Is Successfully Updated.";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Updated.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}else{ // insert information


		if(!empty($file_name) ){

			if (!in_array($file_extension, $permitted)) {
				$message =  "Data not updated. Please Upload Image With Extension : ".implode(', ',$permitted);
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
				die();
			}else{
				move_uploaded_file($file_temp, $uploaded_image);
			}

		}

		$query = "INSERT INTO expense 
		(expense_type,client_name,organization_name,address,mobile_no,invoice_docs_no,invoice_docs_img,total_amount,paid_amount,due_amount,next_paid_date,description,expense_date)
		VALUES 
		('$expense_type','$client_name','$organization_name','$address','$mobile_no','$invoice_docs_no','$uploaded_image','$total_amount','$paid_amount','$due_amount','$next_paid_date','$description','$expense_date')";
		$insert = $dbOb->insert($query);
		if ($insert) {
			$message = "Congratulaitons! Information Is Successfully Saved.";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Saved.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}

}



// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	
	$query = "SELECT * FROM expense WHERE serial_no = '$serial_no_delete'";
	$get_exp = $dbOb->find($query);
	$get_img = $get_exp['invoice_docs_img'];
	if ($get_img) {
		unlink($get_img);
	}

	$query = "DELETE FROM expense WHERE serial_no = '$serial_no_delete'";
	$delete = $dbOb->delete($query);
	if ($delete) {
		$message = "Congratulaitons! Information Is Successfully Deleted.";
		$type = "success";
		echo json_encode(['message'=>$message, 'type'=>$type]);
	}else{
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message'=>$message, 'type'=>$type]);

	}
}


// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
	$query = "SELECT * FROM expense ORDER BY serial_no DESC";
	$get_expense = $dbOb->select($query);
	if ($get_expense) {
		$i=0;
		while ($row = $get_expense->fetch_assoc()) {
			$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['expense_type']; ?></td>
				<td><?php echo $row['client_name']; ?></td>
				<td><?php echo $row['organization_name']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['mobile_no']; ?></td>
				<td><?php echo $row['invoice_docs_no']; ?></td>
				<td><?php echo $row['total_amount']; ?></td>
				<td><?php echo $row['paid_amount']; ?></td>
				<td><?php echo $row['due_amount']; ?></td>
				<td><?php echo $row['next_paid_date']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td align="center">
                      <?php 
                      if (permission_check('expense_view_button')) {
                        ?>
                      <a  class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a>
                      <?php } ?>

                      <?php 
                      if (permission_check('expense_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>
                      <?php 
                      if (permission_check('expense_delete_button')) {
                        ?>

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                      <?php } ?>     
                    </td>
                  </tr>
                  <?php
                }
              }
}

?>