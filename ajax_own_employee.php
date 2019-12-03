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
	$query = "SELECT * FROM own_shop_employee WHERE serial_no = '$serial_no_edit'";
	$get_delivery_employee = $dbOb->find($query);
	echo json_encode($get_delivery_employee);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {
	  $id_no = $_POST["id_no"];
      $name = $_POST["name"];
      $mobile_no = $_POST["mobile_no"];
      $email = $_POST["email"];
      $present_address = $_POST["present_address"];
      $active_date = date('d-m-Y');
      $inactive_date = date('d-m-Y');
      $active_status = $_POST["active_status"];
      $edit_id = $_POST["edit_id"];

	if ($edit_id) { // now editing data

		$confirmation_edit = true;
		$query = "SELECT * FROM own_shop_employee WHERE serial_no <> '$edit_id'";
		$get_delivery_emp = $dbOb->select($query);
		
		if ($get_delivery_emp) {
			while ($row = $get_delivery_emp->fetch_assoc()) {

				if ($row['active_status'] == 'Active') {
					$message = 'Already Employee Is Active In This Shop.';
					$type = 'warning';
					echo  json_encode(['message'=>$message,'type'=>$type]);
					exit();
				}else{
					if ($row['id_no']==$id_no && $row['active_status'] == 'Active') {
						$confirmation_edit = false;
						break;
					}
				}
			}
			
		}

		if ($confirmation_edit) {
			
			$query = "UPDATE own_shop_employee 
					  SET 
						id_no = '$id_no',
						name = '$name', 
						mobile_no 	='$mobile_no',
						email = '$email',
						present_address = '$present_address',
						active_date = '$active_date',
						inactive_date = '$inactive_date',
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
			$message = "This Employee Is Already Active As Own Shop Employee.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}else{ //now adding data into database

		$confirmation = true;
		$query = "SELECT * FROM own_shop_employee WHERE id_no = '$id_no' AND active_status = 'Active'";
		$get_emp_delivery = $dbOb->find($query);
		$emp_existing_id = $get_emp_delivery['id_no'];
		if ($emp_existing_id) {
			$confirmation = false;
		}else{
			$query = "SELECT * FROM own_shop_employee WHERE  active_status = 'Active'";
			$get_active_employee = $dbOb->select($query);
			if ($get_active_employee) {
				while ($row = $get_active_employee->fetch_assoc()) {
					if ($row['area'] == $area && $row['active_status'] == 'Active') {
						$message = 'Already One Employee Is Active In This Shop.';
						$type = 'warning';
						echo  json_encode(['message'=>$message,'type'=>$type]);
						exit();
					}
				}
			}
		}


		if ($confirmation) {
			$query = "INSERT INTO own_shop_employee 
						(id_no,name,mobile_no,email,present_address,active_date,inactive_date,active_status)
					  VALUES 
					  	('$id_no','$name','$mobile_no','$email','$present_address','$active_date','$inactive_date','$active_status')";
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
			$message = "This Employee Is Already Active As Own Shop Employee ";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}

}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM own_shop_employee WHERE serial_no = '$serial_no_delete'";
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
              
 
              $query = "SELECT * FROM own_shop_employee ORDER BY serial_no DESC";
              $get_shop_employee = $dbOb->select($query);
              if ($get_shop_employee) {
                $i=0;
                while ($row = $get_shop_employee->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['active_date']; ?></td>
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
                      if (permission_check('own_shop_employee_edit_button')) {
                        ?>
                         <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('own_shop_employee_delete_button')) {
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
 if (isset($_POST['id_no_own_employee'])) {
 	$id_no = $_POST['id_no_own_employee'];
 	$query = "SELECT * FROM employee_main_info WHERE id_no ='$id_no'";

 	$get_employee_info = $dbOb->find($query);
 	echo json_encode($get_employee_info);
 }

 ?>