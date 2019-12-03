<?php
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once "class/Session.php";
Session::init();
Session::checkSession();
error_reporting(1);
include_once 'helper/helper.php';
?>

<?php
include_once "class/Database.php";
$dbOb = new Database();

if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];

	// keeping information for deleting data from login table
	$query = "SELECT * FROM employee_main_info WHERE serial_no = '$serial_no_delete'";
	$get_login_info = $dbOb->find($query);
	$x_name = $get_login_info['name'];
	$x_user_name = $get_login_info['user_name'];

	$main_tbl_query = "SELECT * FROM  employee_main_info WHERE serial_no = '$serial_no_delete'";
	$main_tbl_info = $dbOb->find($main_tbl_query);

	$document_query = "SELECT * FROM  employee_document_info WHERE serial_no = '$serial_no_delete'";
	$document_tbl_info = $dbOb->find($document_query);

	$delete_main_tbl = $delete_document = $delete_academic_information = '';

	// deleting main table information
	if (unlink($main_tbl_info['photo'])) {
		$delete_main_tbl_query = "DELETE FROM employee_main_info WHERE serial_no = '$serial_no_delete'";
		$delete_main_tbl = $dbOb->delete($delete_main_tbl_query);
	}

	// if main table information is deleted then document table information will be deleted
	if ($delete_main_tbl) {
		if ($document_tbl_info['upload_document'] != '') {
			unlink($document_tbl_info['upload_document']);
			$delete_document_query = "DELETE FROM employee_document_info WHERE main_tbl_serial_no = '$serial_no_delete'";
			$delete_document = $dbOb->delete($delete_document_query);
		} else {
			$delete_document_query = "DELETE FROM employee_document_info WHERE main_tbl_serial_no = '$serial_no_delete'";
			$delete_document = $dbOb->delete($delete_document_query);
		}
	}

	// if document table information is deleted then academic informaion will be deleted
	if ($delete_document) {
		$delete_academic_query = "DELETE FROM employee_academic_info WHERE main_tbl_serial_no = '$serial_no_delete'";
		$delete_academic_information = $dbOb->delete($delete_academic_query);
	}

	// now printing message if academic information is deletee
	if ($delete_academic_information) {

		$query = "DELETE FROM login  WHERE name = '$x_name' AND username = '$x_user_name' AND user_type = 'employee'";
		$delete_login = $dbOb->delete($query);

		$query = "DELETE FROM user_has_role  WHERE user_serial_no = '$serial_no_delete' AND user_type = 'employee'";
		$delete_user_has_role = $dbOb->delete($query);
		///////////////////////////////////////////---------------------------////////////////////
		if ($delete_login) {

			$message = "Congratulations! Information Is Successfully Deleted.";
			$type = "success";
			echo json_encode(['message' => $message, 'type' => $type]);
		} else {
			$message = "Sorry! Information Is Not Deleted";
			$type = "warning";
			echo json_encode(['message' => $message, 'type' => $type]);
		}
	} else {
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);
	}
}

// the following section will be used to add the role of an employee
if (isset($_POST['submit'])) {
	$role_serial_no = $_POST['role_name'];
	$employee_serial_no = $_POST['employee_serial_no'];

	$query = "SELECT * FROM role WHERE serial_no = '$role_serial_no'";
	$get_role = $dbOb->find($query);
	$role_name = $get_role['role_name'];

	$query = "DELETE FROM user_has_role WHERE user_serial_no = '$employee_serial_no' AND user_type = 'employee'";
	$delete_role = $dbOb->delete($query);

	$query = "INSERT INTO user_has_role (role_serial_no,user_serial_no,user_type) VALUES ('$role_serial_no','$employee_serial_no','employee')";
	$insert_user_has_role = $dbOb->insert($query);
	if ($insert_user_has_role) {
		$query = "UPDATE login
		SET
		role = '$role_name'
		WHERE
		user_id = '$employee_serial_no' AND user_type = 'employee'";
		$update_login = $dbOb->update($query);
	}
	if ($update_login) {
		$message = "Congratulations! Role Is Successfully Saved.";
		$type = "success";
		echo json_encode(['message' => $message, 'type' => $type]);
	} else {
		$message = "Sorry! Role Is Not Saved.";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);

	}
}

if (isset($_POST['employee_id_role'])) {
	// $
	$user_serial_no = $row['employee_id_role'];
	$query = "SELECT * FROM user_has_role WHERE user_serial_no = '$user_serial_no' AND user_type = 'employee'";
	$get_user_role = $dbOb->select($query);
	if ($get_user_role) {
		$user_and_role = $get_user_role->fetch_assoc();
		$role_serial_no = $user_and_role['role_serial_no'];
		$query = "SELECT * FROM role WHERE serial_no = '$role_serial_no'";
		$get_role_info = $dbOb->select($query);
		if ($get_role_info) {
			$role_id = $get_role_info->fetch_assoc()['serial_no'];
			$msg = 'success';
		}else{
			$role_id = '';
			$role_badge_color = 'bg-red';
		}
	}else{
		$role_id = 'Not Assigned';
		$role_badge_color = 'bg-red';
	}
	echo json_encode($query);
}

// the following section is for reloding data table
if (isset($_POST['sohag'])) {

	$query = "SELECT * FROM employee_main_info ORDER BY serial_no DESC";
	$get_employee = $dbOb->select($query);
	if ($get_employee) {
		$i=0;
		while ($row = $get_employee->fetch_assoc()) {
			$i++;
			$user_serial_no = $row['serial_no'];
			$query = "SELECT * FROM user_has_role WHERE user_serial_no = '$user_serial_no' AND user_type = 'employee'";
			$get_user_role = $dbOb->select($query);
			if ($get_user_role) {
				$user_and_role = $get_user_role->fetch_assoc();
				$role_serial_no = $user_and_role['role_serial_no'];
				$query = "SELECT * FROM role WHERE serial_no = '$role_serial_no'";
				$get_role_info = $dbOb->select($query);
				if ($get_role_info) {
					$role_name = $get_role_info->fetch_assoc()['role_name'];
					$role_badge_color = 'bg-blue';
				}else{
					$role_name = 'Not Assigned';
					$role_badge_color = 'bg-red';
				}
			}else{
				$role_name = 'Not Assigned';
				$role_badge_color = 'bg-red';
			}
			?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row['id_no'] ?> </td>
				<td> <?php echo $row['name'] ?> </td>
				<td> <?php echo $row['designation'] ?> </td>
				<!-- // <td>  </td> -->
				<td> <?php echo $row['mobile_no'] ?> </td>
<?php 
  if ($row['active_status'] == "Active") {
	$color = "green";
  }
  if($row['active_status'] == "Inactive"){
	$color = "red";
  }
 ?>
<td style="color: <?php echo $color; ?>"><b><?php echo $row['active_status']; ?></b></td>

<td><span class="badge <?php echo $role_badge_color?>"><?php echo $role_name; ?></span></td>
				<td align="center">


<?php 
if (permission_check('employee_view_button')) {
  ?>
					<a href="view_employee.php?serial_no=<?php echo urldecode($row['serial_no']);?>" type="button" class="badge bg-green view_data"> View</a>
<?php } ?>

<?php 
if (permission_check('employee_edit_button')) {
  ?>

<a href="edit_employee.php?serial_no=<?php echo urldecode($row['serial_no']);?>" type="button" class="badge bg-yellow view_data"> Edit</a>
<?php } ?>
<?php 
if (permission_check('employee_delete_button')) {
  ?>
					<a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
<?php } ?>
  <?php 
  if (permission_check('employeee_role_button')) {
	?>
					 <a class="badge bg-green assign_role_button" id="<?php echo $row['serial_no'] ?>" data-toggle="modal" data-target="#assign_role_modal"   title="Assign Role"> Role </a>
 <?php } ?>

				</td>
<td></td>
			</tr>

			<?php
		}
	}

}
?>