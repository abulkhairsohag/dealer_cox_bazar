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



// the following section is for inserting and updating data 
if (isset($_POST['attendance_date'])) {
	$attendance_date = $_POST['attendance_date'];

	$query = "SELECT * FROM employee_attendance WHERE attendance_date = '$attendance_date'";
	$get_attendance = $dbOb->select($query);
	if ($get_attendance) {
		 $i=0;
		$attendance_tbl = '<div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2 style="color:green"><b>Attendance List Of Employee </b></h2>
          <h2 style="color:red"><i> (Date: '.$attendance_date.')</i></h2>
          <div class="row float-right" align="right">
           
           
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered" style="color:black">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">ID Number</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Designation</th>
                <th style="text-align: center;">Attendance</th>
                <!-- <th style="display: none;"></th> -->
              </tr>
            </thead>


            <tbody id="data_table_body">';
		while ($row = $get_attendance->fetch_assoc()) {
			$i++;

	          if ($row['attendance'] == '1') {
	            $checked = "checked";
	          }else{
	            $checked = "";
	          }

	          $attendance_tbl .= '<tr>
				                    <td>'. $i.'</td>
				                    <td>'. $row['employee_id_no'].'</td>
				                    <td>'. $row['name'].'</td>
				                    <td>'. $row['designation'].'</td>
				                    <td>
				                      <input type="checkbox" name="attendance_status" class=" js-switch attendance_status" data-fouc '. $checked.' id="'.$row['employee_id_no'].'" data-date="'.$row['attendance_date'].'">
				                    </td>
                  				</tr>';
		}

		$attendance_tbl .= '</tbody> </table> </div> </div> </div>';
	}

	echo json_encode($attendance_tbl);

}



if (isset($_POST['employee_id'])) {

	$id = validation($_POST['employee_id']);
	$attendance = validation($_POST['attendance']);
	$attendance_date = validation($_POST['date']);
	$query = "UPDATE employee_attendance SET attendance = '$attendance' WHERE employee_id_no = '$id' AND attendance_date = '$attendance_date'";
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

?>