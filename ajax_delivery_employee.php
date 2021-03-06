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
	$query = "SELECT * FROM delivery_employee WHERE serial_no = '$serial_no_edit'";
	$get_delivery_employee = $dbOb->find($query);
	echo json_encode($get_delivery_employee);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	  $id_no = validation($_POST["id_no"]);
      $name = validation($_POST["name"]);
     
      $active_status = validation($_POST["active_status"]);
      $edit_id = $_POST["edit_id"];

	if ($edit_id) { // now editing data 

		$confirmation_edit = true;
		$query = "SELECT * FROM delivery_employee WHERE serial_no <> '$edit_id'";
		$get_delivery_emp = $dbOb->select($query);
		
		if ($get_delivery_emp) {
			while ($row = $get_delivery_emp->fetch_assoc()) {

				
					if ($row['id_no']==$id_no && $row['active_status'] == 'Active') {
						$confirmation_edit = false;
						break;
					}
			}
			
		}

		if ($confirmation_edit) {
			
			$query = "UPDATE delivery_employee 
					  SET 
						id_no = '$id_no',
						name = '$name', 
						active_status = '$active_status'
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
			$message = "This Employee Is Already Active As Delivery Employee.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}else{ //now adding data into database

		$confirmation = true;
		$query = "SELECT * FROM delivery_employee WHERE id_no = '$id_no' AND active_status = 'Active'";
		$get_emp_delivery = $dbOb->find($query);
		$emp_existing_id = $get_emp_delivery['id_no'];
		if ($emp_existing_id) {
			$confirmation = false;
		}


		if ($confirmation) {
			$query = "INSERT INTO delivery_employee 
						(id_no,name,active_status)
					  VALUES 
					  	('$id_no','$name','$active_status')";
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
			$message = "This Employee Is Already Active As Delivery Employee.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}

}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM delivery_employee WHERE serial_no = '$serial_no_delete'";
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
 
              $query = "SELECT * FROM delivery_employee ORDER BY serial_no DESC";
              $get_delivery_employee = $dbOb->select($query);
              if ($get_delivery_employee) {
                $i=0;
                while ($row = $get_delivery_employee->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td> 
                    
                    <?php 
                      if ($row['active_status'] == "Active") {
                        $color = "green";
                      }
                      if($row['active_status'] == "Inactive"){
                        $color = "red";
                      }
                     ?>
                    <td style="color: <?php echo $color; ?>"><b><?php echo $row['active_status']; ?></b></td>
                    <td align="center">

                      <?php 
                      if (permission_check('delivery_man_edit_button')) {
                        ?>
                         <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('delivery_man_delete_button')) {
                        ?>

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a>  
                      <?php } ?>   
                    </td>
                  </tr>

                  <?php
                }
              }

}

// getiing employee information by its id 
 if (isset($_POST['id_no_employee'])) {
 	$id_no = $_POST['id_no_employee'];
 	$query = "SELECT name FROM employee_main_info WHERE id_no ='$id_no'";

 	$get_employee_info = $dbOb->find($query);
 	echo json_encode($get_employee_info);
 }


 // getiing employee information by its id 
 if (isset($_POST['id_no_own_employee'])) {
 	$id_no = $_POST['id_no_own_employee'];
 	$query = "SELECT * FROM employee_main_info WHERE id_no ='$id_no'";

 	$get_employee_info = $dbOb->find($query);
 	echo json_encode($get_employee_info);
 }

 ?>