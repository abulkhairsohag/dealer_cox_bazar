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



// getting employee info while changing the employee id
if (isset($_POST['employee_id'])) {

	$id = validation($_POST['employee_id']);
	$attendance = validation($_POST['attendance']);

	$today = strtotime(date("d-m-Y"));
	$query = "SELECT * FROM employee_attendance ";
	$get_attendance = $dbOb->select($query);

	if ($get_attendance) {
		while ($row = $get_attendance->fetch_assoc()) {
			$attendance_date = strtotime($row['attendance_date']);
			$emp_id = $row['employee_id_no'];
			if ($emp_id == $id && $attendance_date == $today) {
				$attendance_tbl_id = $row['serial_no'];
				$query = "UPDATE employee_attendance SET attendance = '$attendance' WHERE serial_no = '$attendance_tbl_id'";
				$update_attendance = $dbOb->update($query);
				if ($update_attendance) {
					$message = "Attendance Updated";
					$type = "success";
					echo json_encode(['message'=>$message,'type'=>$type]);
				}else{
					$message = "Attendance Not Updated";
					$type = "success";
					echo json_encode(['message'=>$message,'type'=>$type]);

				}
			}
		}
	}
}



// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
			 
			 $today = date("d-m-Y");
              $query = "SELECT * FROM employee_attendance WHERE attendance_date = '$today' ORDER BY serial_no DESC";
              $get_attendance = $dbOb->select($query);
              if ($get_attendance) {
                $i=0;
                while ($row = $get_attendance->fetch_assoc()) {
                  $i++;

                  if ($row['attendance'] == '1') {
                    $checked = "checked";
                  }else{
                    $checked = "";
                  }


                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['employee_id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td>
                      <input type="checkbox" name="attendance_status" class="form-control js-switch attendance_status" data-fouc <?php echo $checked; ?> id="<?php echo($row['employee_id_no']) ?>">
                    </td>
                  </tr>

                  <?php
                }
              }
}

?>