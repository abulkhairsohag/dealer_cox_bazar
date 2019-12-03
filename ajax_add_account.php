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
	$query = "SELECT * FROM account WHERE serial_no = '$serial_no_edit'";
	$get_account = $dbOb->find($query);
	echo json_encode($get_account);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	$account_name = $_POST['account_name'];
	$organization_name = $_POST['organization_name'];
	$address = $_POST['address'];
	$mobile_no = $_POST['mobile_no'];
	$bank_name = $_POST['bank_name'];
	$bank_account_no = $_POST['bank_account_no'];
	$branch_name = $_POST['branch_name'];
	$description = $_POST['description'];
	$edit_id = $_POST['edit_id'];


		
		if ($edit_id) {
			$query = "SELECT * FROM account WHERE bank_account_no = '$bank_account_no' AND serial_no<>'$edit_id'";
			$get_account_no = $dbOb->find($query);

			if (!$get_account_no) {
			
				$query = "UPDATE account 
				SET 
				account_name = '$account_name',
				organization_name = '$organization_name',
				address 	='$address',
				mobile_no ='$mobile_no',
				bank_name = '$bank_name',
				bank_account_no = '$bank_account_no',
				branch_name 	= '$branch_name',
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
			}else{
				$message = "Sorry! Information Is Not Updated. The Account Number: $bank_account_no Is Already Available In Database. Try With Another Account Number";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
		}else{

			$query = "SELECT * FROM account WHERE bank_account_no = '$bank_account_no'";
			$get_account_no = $dbOb->find($query);

			if (!$get_account_no) {
				$query = "INSERT INTO account 
				(account_name,organization_name,address,mobile_no,bank_name,bank_account_no,branch_name,description)
				VALUES 
				('$account_name','$organization_name','$address','$mobile_no','$bank_name','$bank_account_no','$branch_name','$description')";
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
				
			}else{
				$message = "Sorry! Information Is Not Saved. The Account Number: $bank_account_no Is Already Available In Database. Try With Another Account Number";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}
		}



}

// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM account WHERE serial_no = '$serial_no_delete'";
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

	$query = "SELECT * FROM account ORDER BY serial_no DESC";
	$get_account = $dbOb->select($query);
	if ($get_account) {
		$i=0;
		while ($row = $get_account->fetch_assoc()) {
			$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['account_name']; ?></td>
				<td><?php echo $row['organization_name']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['mobile_no']; ?></td>
				<td><?php echo $row['bank_name']; ?></td>
				<td><?php echo $row['bank_account_no']; ?></td>
				<td><?php echo $row['branch_name']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td align="center">

                      <?php 
                      if (permission_check('account_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('account_delete_button')) {
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