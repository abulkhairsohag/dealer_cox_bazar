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
	$query = "SELECT * FROM area WHERE serial_no = '$serial_no'";
	$area_info = $dbOb->find($query);
	$zone_name = '';
	echo json_encode(['area_info'=>$area_info,'zone_name'=>$zone_name]);
}



if (isset($_POST['submit'])) { 
	$area_name = validation($_POST['area_name']);
	// $zone_name = validation($_POST['zone_name']);
	$district_name = validation($_POST['district_name']);
	$thana_name = validation($_POST['thana_name']);
	$line_route = validation($_POST['line_route']);
	$edit_id = validation($_POST['edit_id']);

	if ($edit_id) { // UPDATING DATA INTO DATABASE

		$query = "SELECT * FROM area WHERE serial_no <> '$edit_id'";
		$get_area = $dbOb->select($query);

		$confirmation_edit = true;
		if ($get_area) {
			while ($row = $get_area->fetch_assoc()) {
				if ($row['area_name']==$area_name) {
					$confirmation_edit = false;
					break;
				}
			}
			
		}
		if ($confirmation_edit) {

			$query = "UPDATE area 
			SET 
			area_name = '$area_name',
			district_name = '$district_name',
			thana_name = '$thana_name',
			line_route = '$line_route'
			WHERE 
			serial_no = '$edit_id'
			";
			$update_data = $dbOb->update($query);

			if ($update_data) {
				$query = "UPDATE area_zone SET area_name = '$area_name' WHERE area_serial_no = '$edit_id'";
				$update_area_zone = $dbOb->update($query);
				$message = "Congratulations! Information successfully updated.";
				$type = 'success';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = 'Sorry! Data not updated.';
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}

		}else{
			$message = 'Area Not Updated. This Area Name Already Exist.';
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}else{ //INSERTING DATA INTO DATABASE
		$query = "SELECT * FROM area WHERE area_name = '$area_name'";
		$get_area = $dbOb->find($query);
		$get_area_name = $get_area['area_name'];

		$confirmation = true;
		if ($get_area_name) {
			$confirmation = false;
		}

		if ($confirmation) {

			$query = "INSERT INTO area 
			(area_name,district_name,thana_name,line_route)
			VALUES 
			('$area_name','$district_name','$thana_name','$line_route')";
			$last = $dbOb->custom_insert($query);
			if ($last) {
			
				$message = "Congratulations! Information Saved successfully.";
				$type = 'success';
				echo json_encode(['message'=>$message,'type'=>$type]);
			
				
			}else{
				$message = 'Sorry! Information is not Saved.';
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);

			}
			
		}else{
			$message = 'Area Not Inserted. This Area Name Already Exist.';
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}
}

if (isset($_POST['sohag'])) {
	          $query = "SELECT * FROM area ORDER BY serial_no DESC";
          $get_area = $dbOb->select($query);
          if ($get_area) {
            $i = 0;
            while ($row = $get_area->fetch_assoc()) {
              $i++;
              $area_id = $row['serial_no'];
              ?>

              <tr id="table_row_<?php echo $row['serial_no'] ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $row['area_name'] ?></td>
                <td>
                  <?php 
                  $query = "SELECT * FROM area_zone WHERE area_serial_no = '$area_id' ";
                  $get_zone = $dbOb->select($query);
                  if ($get_zone) {
                    while ($zone = $get_zone->fetch_assoc()) {
                      $all_zone = $zone['zone_serial_no'];
                      $query = "SELECT * FROM zone where serial_no = '$all_zone'";
                      $get_zone_name = $dbOb->select($query);
                      if ($get_zone_name) {
                        $zone_name = $get_zone_name->fetch_assoc()['zone_name'];
                        
                      }
                      ?>
                      <span class="badge bg-green"><?php echo  $zone_name ?></span>
                      <?php 
                    }
                  }
                  ?>
                </td>
                <td><?php echo $row['district_name'] ?></td>
                <td><?php echo $row['thana_name'] ?></td>
                <td><?php echo $row['line_route'] ?></td>
                <td align="center">


                  <?php 
                  if (permission_check('area_edit_button')) {
                    ?> 
                    <a  class="badge bg-blue  edit_data" id="<?php echo $row['serial_no'] ?>"  data-toggle="modal" data-target="#add_update_modal"style="margin:2px">Edit</a> 
                  <?php } ?>


                  <?php 
                  if (permission_check('area_delete_button')) {
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
	$query = "DELETE FROM area WHERE serial_no = '$delete_id'";
	$delete = $dbOb->delete($query);

	if ($delete) {
		$query = "DELETE FROM area_zone WHERE area_serial_no = '$delete_id'";
		$delete_area_zone = $dbOb->delete($query);
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