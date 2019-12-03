<?php 

	include_once('class/Database.php');

	
	function permission_check($permission){
		$dbOb =  new Database();
		$role_name = Session::get("role");
		$user_serial_no = Session::get("user_id");
		$user_type = Session::get("user_type");

		if ($role_name == 'admin') {
			return true;
		}

		$query = "SELECT * FROM role WHERE role_name = '$role_name'";
		$role_info = $dbOb->find($query);
		$role_serial_no = $role_info['serial_no'];

		$query = "SELECT * FROM user_has_role WHERE user_type = '$user_type' AND user_serial_no ='$user_serial_no' AND role_serial_no = '$role_serial_no'";
		$get_user_has_role = $dbOb->find($query);

		
		if (!$get_user_has_role) {
			return false;
		}

		

		$query = "SELECT * FROM role_has_permission WHERE role_serial_no = '$role_serial_no'";
		$get_permission = $dbOb->select($query);
		$permissions = [];

		if ($get_permission) {
			while ($row = $get_permission->fetch_assoc()) {
				$get_permission_serial_no =  $row['permission_serial_no'];
				$query = "SELECT * FROM permission WHERE serial_no = '$get_permission_serial_no'";
				$permissions[] = $dbOb->find($query)['permission_name'];
			}
		}
		if (in_array($permission, $permissions)) {
			return true;
		}

		return false;

	}


 ?>