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

	$expense_type = validation($_POST['expense_type']);
	$client_name = validation($_POST['client_name']);
	$organization_name = validation($_POST['organization_name']);
	$address = validation($_POST['address']);
	$mobile_no = validation($_POST['mobile_no']);
	$invoice_docs_no = validation($_POST['invoice_docs_no']);
	$total_amount = validation($_POST['total_amount']);
	$description = validation($_POST['description']);
	$zone_serial_no = validation($_POST['zone_serial_no']);
	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
	$zone_name = validation($dbOb->find($query)['zone_name']);
	$expense_date = validation($_POST['expence_date']);
	$edit_id = validation($_POST['edit_id']);

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
		description 	= '$description',
		zone_serial_no = '$zone_serial_no',
		zone_name      ='$zone_name'
		
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
		(expense_type,client_name,organization_name,address,mobile_no,invoice_docs_no,invoice_docs_img,total_amount,description,expense_date,zone_serial_no,zone_name)
		VALUES 
		('$expense_type','$client_name','$organization_name','$address','$mobile_no','$invoice_docs_no','$uploaded_image','$total_amount','$description','$expense_date','$zone_serial_no','$zone_name')";
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
	if (Session::get("zone_serial_no")){
                if (Session::get("zone_serial_no") != '-1') {
                  $zone_serial = Session::get("zone_serial_no");
                  $query = "SELECT * FROM expense WHERE zone_serial_no = '$zone_serial' ORDER BY serial_no DESC";
                }
              }else{
                $query = "SELECT * FROM expense ORDER BY serial_no DESC";
              }
              $get_expense = $dbOb->select($query);
              if ($get_expense) {
                $i=0;
                while ($row = $get_expense->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['expense_type']; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['invoice_docs_no']; ?></td>
                    <td><img src="<?php echo $row['invoice_docs_img']; ?>" alt=""width='70px'></td>
                    <td><?php echo $row['total_amount']; ?></td>
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