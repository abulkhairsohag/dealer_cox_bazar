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
	$query = "SELECT * FROM bank_withdraw WHERE serial_no = '$serial_no_edit'";
	$get_bank_withdraw = $dbOb->find($query);
	echo json_encode($get_bank_withdraw);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	  $bank_name = $_POST['bank_name'];
      $bank_account_no = $_POST['bank_account_no'];
      $cheque_no = $_POST['cheque_no'];
      $branch_name = $_POST['branch_name'];
      $amount = $_POST['amount'];
      $receiver_name = $_POST['receiver_name'];
      $cheque_active_date = $_POST['cheque_active_date'];
      $description = $_POST['description'];
      $edit_id = $_POST['edit_id'];

	if ($edit_id) {
		$query = "UPDATE bank_withdraw 
				  SET 
					bank_name = '$bank_name',
					bank_account_no = '$bank_account_no',
					cheque_no 	='$cheque_no',
					branch_name ='$branch_name',
					amount = '$amount',
					receiver_name = '$receiver_name',
					cheque_active_date = '$cheque_active_date',
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
		$query = "INSERT INTO bank_withdraw 
					(bank_name,bank_account_no,cheque_no,branch_name,amount,receiver_name,cheque_active_date,description)
				  VALUES 
				  	('$bank_name','$bank_account_no','$cheque_no','$branch_name','$amount','$receiver_name','$cheque_active_date','$description')";
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
	$query = "DELETE FROM bank_withdraw WHERE serial_no = '$serial_no_delete'";
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
              
              
              $query = "SELECT * FROM bank_withdraw  ORDER BY serial_no DESC";
              $get_bank_withdraw = $dbOb->select($query);
              if ($get_bank_withdraw) {
                $i=0;
                while ($row = $get_bank_withdraw->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['bank_name']; ?></td>
                    <td><?php echo $row['bank_account_no']; ?></td>
                    <td><?php echo $row['cheque_no']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['receiver_name']; ?></td>
                    <td><?php echo $row['cheque_active_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('bank_withdraw_edit_button')) {
                        ?>
                         <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('bank_withdraw_delete_button')) {
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