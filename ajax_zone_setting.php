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
	$serial_no = $_POST['serial_no_edit'];
	$query = "SELECT * FROM zone WHERE serial_no = '$serial_no'";
	$zone_info = $dbOb->find($query);

	$query = "SELECT * FROM area_zone WHERE zone_serial_no = '$serial_no'";
	$get_area = $dbOb->select($query);
	$area_serial_no = [];
	if ($get_area) {
		$i = 0;
		while ($area = $get_area->fetch_assoc()) {
			$area_serial_no[] = $area['area_serial_no'];
			$i++ ; 
		}
	}

	die(json_encode(['area_serial_no'=>$area_serial_no, 'zone_info'=>$zone_info]));
}



if (isset($_POST['submit'])) { 
	$zone_name = validation($_POST['zone_name']);
	$area_name =  validation($_POST['area_name']);
	
	$edit_id = $_POST['edit_id'];

	if ($edit_id) { // UPDATING DATA INTO DATABASE

		$query = "SELECT * FROM zone WHERE serial_no <> '$edit_id'";
		$get_zone = $dbOb->select($query);

		$confirmation_edit = true;
		if ($get_zone) {
			while ($row = $get_zone->fetch_assoc()) {
				if ($row['zone_name']==$zone_name) {
					$confirmation_edit = false;
					break;
				}
			}
			
		}
		if ($confirmation_edit) {

			$query = "UPDATE zone 
			SET 
			zone_name = '$zone_name'
			WHERE 
			serial_no = '$edit_id'
			";
			$update_data = $dbOb->update($query);
			if ($update_data) {
				$query = "DELETE FROM area_zone WHERE zone_serial_no = '$edit_id'";
				$delete = $dbOb->delete($query);
				if ($delete) {
					
// here is the change of areas 
						$insertrow1 = '';
						for ($i = 0; $i < count($area_name); $i++) {
							$area_serial_no = $area_name[$i];
							$query = "SELECT * FROM area WHERE serial_no = '$area_serial_no'";
							$name = $dbOb->find($query)['area_name'];
							$sql2 = "INSERT INTO area_zone(zone_serial_no,area_serial_no,area_name) VALUES('$edit_id','$area_serial_no','$name')";
							$insertrow1 = $dbOb->insert($sql2);
						}
						if ($insertrow1) {
							$message = "Congratulations! Information Updated successfully.";
							$type = 'success';
							echo json_encode(['message'=>$message,'type'=>$type]);
						}else{
							$message = 'Zone Updated But Areas Not Inserted. Something Happened Wrong.';
							$type = 'warning';
							die(json_encode(['message'=>$message,'type'=>$type]));
						}





				}
				
			}else{
				$message = 'Sorry! Data not updated.';
				$type = 'warning';
				die( json_encode(['message'=>$message,'type'=>$type]));

			}
		}else{
			$message = 'Zone Not Updated. This Zone Name Already Exist.';
			$type = 'warning';
			die(json_encode(['message'=>$message,'type'=>$type]));
		}
	}else{ //INSERTING DATA INTO DATABASE
		$query = "SELECT * FROM zone WHERE zone_name = '$zone_name'";
		$get_zone = $dbOb->find($query);
		$get_zone_name = $get_zone['zone_name'];

		$confirmation = true;
		if ($get_zone_name) {
			$confirmation = false;
		}

		if ($confirmation) {

			$query = "INSERT INTO zone 
			(zone_name)
			VALUES 
			('$zone_name')";
			$last = $dbOb->custom_insert($query);
			if ($last) {
				for ($i = 0; $i < count($area_name); $i++) {
					$area_serial_no = $area_name[$i];
					$query = "SELECT * FROM area WHERE serial_no = '$area_serial_no'";
					$name = $dbOb->find($query)['area_name'];
					$sql2 = "INSERT INTO area_zone(zone_serial_no,area_serial_no,area_name) VALUES('$last','$area_serial_no','$name')";
					$insertrow1 = $dbOb->insert($sql2);
				}
				if ($insertrow1) {
					$message = "Congratulations! Information Saved successfully.";
					$type = 'success';
					echo json_encode(['message'=>$message,'type'=>$type]);
				}else{
					$message = 'Zone Inserted But Areas Not Inserted. Something Happened Wrong.';
					$type = 'warning';
					die(json_encode(['message'=>$message,'type'=>$type]));
				}
				
			}else{
				$message = 'Sorry! Information is not Saved.';
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
			
		}else{
			$message = 'Zone Not Inserted. This Zone Name Already Exist.';
			$type = 'warning';
			die(json_encode(['message'=>$message,'type'=>$type]));

		}
	}
}

if (isset($_POST['sohag'])) {
$query = "SELECT * FROM zone ORDER BY serial_no DESC";
          $get_zone = $dbOb->select($query);
          if ($get_zone) {
            $i = 0;
            while ($row = $get_zone->fetch_assoc()) {
              $i++;
              ?>

              <tr id="table_row_<?php echo $row['serial_no'] ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $row['zone_name'] ?></td>
                <td>
                  <?php 
                  $zone_serial_no = $row['serial_no'];
                  $query = "SELECT * FROM area_zone WHERE zone_serial_no = '$zone_serial_no' ";
                  $get_area = $dbOb->select($query);
                  if ($get_area) {
                    while ($area = $get_area->fetch_assoc()) {
                      $area_name = $area['area_name'];
                     
                      ?>
                      <span class="badge bg-green" style="margin:1px"><?php echo  $area_name ?></span>
                      <?php 
                    }
                  }
                  ?>
                </td>
                <td align="center">
                  
                  <?php 
                  if (permission_check('zone_edit_button')) {
                    ?> 
                    <a  class="badge bg-blue  edit_data" id="<?php echo $row['serial_no'] ?>"  data-toggle="modal" data-target="#add_update_modal"style="margin:2px">Edit</a> 
                  <?php } ?>
                  
                  <?php 
                  if (permission_check('zone_delete_button')) {
                    ?> 

                    <a  class="badge  bg-red delete_data" id="<?php echo $row['serial_no'] ?>" style="margin:2px"> Delete</a> 
                  <?php } ?> 

                </td>
              </tr>


              <?php
            }
          }
}


if (isset($_POST['delete_id'])) {
	$delete_id = $_POST['delete_id'];
	$query = "DELETE FROM zone WHERE serial_no = '$delete_id'";
	$delete = $dbOb->delete($query);

	if ($delete) {
		$query = "DELETE FROM area_zone WHERE zone_serial_no = '$delete_id'";
		$delete_areas = $dbOb->delete($query);
	}

	if ($delete) {
		$message = "Congratulations! Information Is Successfully Deleted";
		$type = "success";
		die(json_encode(['message'=>$message,'type'=>$type]));
	}else{
		$message = "Sorry! Information Is Not Deleted";
		$type = "warnin";
		die(json_encode(['message'=>$message,'type'=>$type]));

	}
}


?>