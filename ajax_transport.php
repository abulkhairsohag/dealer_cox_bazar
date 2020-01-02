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
	$serial_no_edit = validation($_POST['serial_no_edit']);
	$query = "SELECT * FROM transport WHERE serial_no = '$serial_no_edit'";
	$get_transport = $dbOb->find($query);
	echo json_encode($get_transport);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	 $vehicle_name = validation($_POST['vehicle_name']);
      $type = validation($_POST['type']);
      $reg_no = validation($_POST['reg_no']);
      $engine_no = validation($_POST['engine_no']);
      $insurance_no = validation($_POST['insurance_no']);
      $driver_name = validation($_POST['driver_name']);
      $license_no = validation($_POST['license_no']);
      $owner_type = validation($_POST['owner_type']);
      $edit_id = validation($_POST['edit_id']);

	if ($edit_id) {

		$query_validate = "SELECT * FROM transport WHERE serial_no <>'$edit_id'";
		$get_validate = $dbOb->select($query_validate);

		$confirm_reg_no = true;
		$confirm_license = true;
		if ($get_validate) {
			while ($validate = $get_validate->fetch_assoc()) {
				
				if ($validate['reg_no'] == $reg_no) {
					$confirm_reg_no = false;
				}
				if ($validate['license_no'] == $license_no) {
					$confirm_license = false;
				}
			}
		}

		if ($confirm_reg_no == true && $confirm_license == true) {
				$query = "UPDATE transport 
						  SET 
							vehicle_name = '$vehicle_name',
							type = '$type',
							reg_no 	='$reg_no',
							engine_no ='$engine_no',
							insurance_no = '$insurance_no',
							driver_name = '$driver_name',
							license_no 	= '$license_no',
							owner_type 	= '$owner_type'
							
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
			//////////////
		}else{
			if ($confirm_reg_no==false) {
				$message = "Sorry! Information Is Not Updated. Because, Vehicle Reg No Already Exist";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else if($confirm_license == false){
				$message = "Sorry! Information Is Not Updated. Because, License Already Exist";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
		}
	}else{ // now insert data 


		$query_validate = "SELECT * FROM transport";
		$get_validate = $dbOb->select($query_validate);

		$confirm_reg_no = true;
		$confirm_license = true;
		if ($get_validate) {
			while ($validate = $get_validate->fetch_assoc()) {
				
				if ($validate['reg_no'] == $reg_no) {
					$confirm_reg_no = false;
				}
				if ($validate['license_no'] == $license_no) {
					$confirm_license = false;
				}
			}
		}


		if ($confirm_reg_no == true && $confirm_license == true) {
			$query = "INSERT INTO transport 
						(vehicle_name,type,reg_no,engine_no,insurance_no,driver_name,license_no,owner_type)
					  VALUES 
					  	('$vehicle_name','$type','$reg_no','$engine_no','$insurance_no','$driver_name','$license_no','$owner_type')";
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
			if ($confirm_reg_no==false) {
				$message = "Sorry! Information Is Not Saved. Because, Vehicle Reg No Already Exist";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else if($confirm_license == false){
				$message = "Sorry! Information Is Not Saved. Because, License No Already Exist";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
		}
	}

}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM transport WHERE serial_no = '$serial_no_delete'";
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
              
              $query = "SELECT * FROM transport ORDER BY serial_no DESC";
              $get_transport = $dbOb->select($query);
              if ($get_transport) {
                $i=0;
                while ($row = $get_transport->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['vehicle_name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['reg_no']; ?></td>
                    <td><?php echo $row['engine_no']; ?></td>
                    <td><?php echo $row['insurance_no']; ?></td>
                    <td><?php echo $row['driver_name']; ?></td>
                    <td><?php echo $row['license_no']; ?></td>
                    <td><?php echo $row['owner_type']; ?></td>
                    <td align="center">


                      <?php 

                      if (permission_check('transport_edit_button')) {
                        ?> 
                       <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>



                      <?php 

                      if (permission_check('transport_delete_button')) {
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