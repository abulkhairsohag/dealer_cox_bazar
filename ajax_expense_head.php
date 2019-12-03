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
include_once('class/Database.php');
$dbOb = new Database();

// fetching data from the table of the database and showing them
if (isset($_POST['serial_no_edit'])) {
	$serial_no_edit = $_POST['serial_no_edit'];
	$query = "SELECT * FROM expense_head WHERE serial_no = '$serial_no_edit'";
	$get_head = $dbOb->find($query);
	echo json_encode($get_head);
}


// adding or Updating the table
if (isset($_POST['submit'])) {
	$head_name = $_POST['head_name'];
	$edit_id = $_POST['edit_id'];

	if ($edit_id) {

		$query = "SELECT * FROM expense_head WHERE serial_no <> '$edit_id'";
		$get_exp_head = $dbOb->select($query);

		$confirmation_edit = true;
		if ($get_exp_head) {
			while ($row = $get_exp_head->fetch_assoc()) {
				if ($row['head_name']==$head_name) {
					$confirmation_edit = false;
					break;
				}
			}
			
		}

		if ($confirmation_edit) {

			$query = "UPDATE expense_head 
			SET 
			head_name='$head_name'
			WHERE 
			serial_no = '$edit_id'";
			$update = $dbOb->update($query);
			if ($update) {
				$message = 'Congtatulations! Information Successfully Updated.';
				$type = 'success';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = 'Sorry! Information Is Not Updated.';
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
			
		}else{
			$message = 'Sorry! Head Name Is Not Updated.The Head Name Is Already Exist.';
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}else{ // inserting data into database
		$query = "SELECT * FROM expense_head WHERE head_name = '$head_name'";
		$get_head = $dbOb->find($query);
		$get_head_name = $get_head['head_name'];

		$confirmation = true;
		if ($get_head_name) {
			$confirmation = false;
		}
		
		if ($confirmation) {
			$query = "INSERT INTO expense_head (head_name) values ('$head_name')";
			$insert = $dbOb->insert($query);
			if ($insert) {
				$message = 'Congtatulations! Information Successfully Saved.';
				$type = 'success';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}else{
				$message = 'Sorry! Information Is Not Saved.';
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
		}else{
			$message = 'Sorry! Head Name Is Not Added.The Head Name Is Already Exist.';
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}
}

// showing information from the database
if (isset($_POST['sohag'])) {
	$query = "SELECT * FROM expense_head ORDER BY serial_no DESC";
	$get_expense_head = $dbOb->select($query);

	if ($get_expense_head) {
		$i = 0;
		while ($row = $get_expense_head->fetch_assoc()) {
			$i++;
			?>

			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['head_name']; ?></td>
				<td align="center">
                      <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 

                       <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a>        
                    </td>
                  </tr>
			<?php
		}
		exit();
	}
}

// deleting data from the table using one delete id
if (isset($_POST['delete_id'])) {
	$delete_id = $_POST['delete_id'];
	$query = "DELETE FROM expense_head WHERE serial_no = '$delete_id'";
	$delete = $dbOb->delete($query);
	if ($delete) {
		$message = "Congtatulations! Information Successfully Deleted";
		$type = "success";
		echo json_encode(['type'=>$type,'message'=>$message]);
	}else{
		$message = "Sorry! Information Is Not Deleted";
		$type = "warning";
		echo json_encode(['type'=>$type,'message'=>$message]);

	}
}
?>