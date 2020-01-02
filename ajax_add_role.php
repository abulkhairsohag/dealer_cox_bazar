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
	$serial_no = validation($_POST['serial_no_edit']);
	$query = "SELECT * FROM role WHERE serial_no = '$serial_no'";
	$role = $dbOb->find($query);

	$query = "SELECT * FROM role_has_permission WHERE role_serial_no ='$serial_no'";
	$get_permission = $dbOb->select($query);
	$permission = [];
	if ($get_permission) {
		while ($row = $get_permission->fetch_assoc()) {
			$permission[] = $row['permission_serial_no'];
		}
	}

	echo json_encode(['role'=>$role,'permission'=>$permission]);
}


if (isset($_POST['submit'])) {
	$permission = validation($_POST['permission']);
	$role_name = validation($_POST['role_name']);
	$edit_id = validation($_POST['edit_id']);



	if ($edit_id) { // now we are going to update information

		$query = "SELECT * FROM role WHERE serial_no <> '$edit_id'";
		$get_role = $dbOb->select($query);

		$confirmation = true; 
		if ($get_role) {
			while ($row = $get_role->fetch_assoc()) {
				if ($row['role_name']==$role_name) {
					$confirmation =  false;
					break;
				}
			}
		}

		if ($confirmation == true) {
			$query = "UPDATE role 
			SET 
			role_name = '$role_name'
			WHERE 
			serial_no = '$edit_id'";
			$update_role = $dbOb->update($query);
			if ($update_role) {
				$query = "DELETE FROM role_has_permission WHERE role_serial_no = '$edit_id'";
				$delete_role_permission = $dbOb->delete($query);
				if ($delete_role_permission) {
					////////////////


					for ($i=0; $i < count($permission) ; $i++) { 
						$query_permission  = "INSERT INTO role_has_permission (role_serial_no,permission_serial_no) 
						VALUES 
						('$edit_id','$permission[$i]')";
						$insert_permission = $dbOb->insert($query_permission);
					}

					if ($insert_permission) {
						$message = "Congratulations! Information Is Successfully Inserted.";
						$type = "success";
						echo json_encode(['message'=>$message,'type'=>$type]);
					}else{
						$message = "Sorry! Information Is Not Inserted.";
						$type = "warning";
						echo json_encode(['message'=>$message,'type'=>$type]);

					}
					
					
				}
			}

		}else{
			$message = "Sorry role name : '$role_name' already exist. Please Try Another Non Existing Name.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
		
	}else{ // now we are going to insert information

		$query = "SELECT * FROM role";
		$get_role = $dbOb->select($query);

		$confirmation = true; 
		if ($get_role) {
			while ($row = $get_role->fetch_assoc()) {
				if ($row['role_name']==$role_name) {
					$confirmation =  false;
					break;
				}
			}
		}

		if ($confirmation == true) {
			$query_role = "INSERT INTO role (role_name) VALUES ('$role_name')";
			$role_serial_no = $dbOb->custom_insert($query_role);

			for ($i=0; $i < count($permission) ; $i++) { 
				$query_permission  = "INSERT INTO role_has_permission (role_serial_no,permission_serial_no) 
				VALUES 
				('$role_serial_no','$permission[$i]')";
				$insert_permission = $dbOb->insert($query_permission);
			}

			if ($insert_permission) {
				$message = "Congratulations! Information Is Successfully Inserted.";
				$type = "success";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = "Sorry! Information Is Not Inserted.";
				$type = "warning";
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
			
		}else{
			$message = "Sorry role name : '$role_name' already exist. Please Try Another Non Existing Name.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}

	}

}




if (isset($_POST['sohag'])) {



	$query = "SELECT * FROM role ORDER BY serial_no DESC";
	$get_role = $dbOb->select($query);
	if ($get_role) {
		$i = 0;
		while ($row = $get_role->fetch_assoc()) {
			$i++;
			?>

			<tr id="table_row_<?php echo $row['serial_no'] ?>">
				<td><?php echo $i; ?></td>
				<td><?php echo $row['role_name'] ?></td>
				<td>
					<?php 
					$role_id = $row['serial_no'];
					$query = "SELECT * FROM role_has_permission where role_serial_no = '$role_id'";
					$get_permission = $dbOb->select($query);
					if ($get_permission) {

						while ($permission = $get_permission->fetch_assoc()) {
							$permission_serial_no = $permission['permission_serial_no'];
							$query = "SELECT * FROM permission where serial_no = '$permission_serial_no'";
							$permission_name = $dbOb->find($query);
							?>
							<span class="badge badge-sm" style="margin-bottom: 2px;background: green">
								<?php echo $permission_name['permission_name']; ?>
							</span>
							<?php
						}
					}
					?>
				</td>
				<td align="center">
					<?php 
					if (permission_check('role_edit_button')) {
						?>
						<a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
					<?php } ?>
					<?php 
					if (permission_check('role_delete_button')) {
						?>

						<a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
					<?php } ?>  

				</td>
			</tr>


			<?php
		}
	}

}


if (isset($_POST['delete_id'])) {
	$delete_id = $_POST['delete_id'];
	$query = "DELETE FROM role WHERE serial_no = '$delete_id'";
	$delete_role = $dbOb->delete($query);

	if ($delete_role) {
		$query = "DELETE FROM `role_has_permission` WHERE role_serial_no = '$delete_id'";
		$delete_permission = $dbOb->delete($query);
	}



	if ($delete_permission) {
		$message = "Congratulations! Information Is Successfully Deleted";
		$type = "success";
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else{
		$message = "Sorry! Information Is Not Deleted";
		$type = "warnin";
		echo json_encode(['message'=>$message,'type'=>$type]);

	}
}


?>