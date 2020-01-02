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
	$query = "SELECT * FROM employee_commission WHERE serial_no = '$serial_no_edit'";
	$get_employee_comission = $dbOb->find($query);
	echo json_encode($get_employee_comission);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

          $id_no = validation($_POST['id_no']);
          $name = validation($_POST['name']);
          $designation = validation($_POST['designation']);
          $company = validation($_POST['company']);
          $month = validation($_POST['month']);
          $sell_target = validation($_POST['sell_target']);
          $total_sell_amount = validation($_POST['total_sell_amount']);
          $comission_persent = validation($_POST['comission_persent']);
          $date = date("d-m-Y");
          $edit_id = validation($_POST['edit_id']);

          $zone_serial_no = validation($_POST['zone_serial_no']);
          $query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
          $get_zone = $dbOb->select($query);
          $zone_name = '';
          if ($get_zone) {
            $zone_name = validation($get_zone->fetch_assoc()['zone_name']);
          }

	if ($edit_id) {
		$query = "UPDATE employee_commission 
				  SET 
          id_no = '$id_no',
          name = '$name',
          designation = '$designation',
          company = '$company',
          month = '$month',
          sell_target = '$sell_target',
					total_sell_amount = '$total_sell_amount',
          comission_persent   ='$comission_persent',
					date = '$date',
          zone_serial_no = '$zone_serial_no',
          zone_name      = '$zone_name'
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
		$query = "INSERT INTO employee_commission 
					(id_no,name,designation,company,month,sell_target,total_sell_amount,comission_persent,date,zone_serial_no,zone_name)
				  VALUES 
				  	('$id_no','$name','$designation','$company','$month','$sell_target','$total_sell_amount','$comission_persent','$date','$zone_serial_no','$zone_name')";

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
	}

}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM employee_commission WHERE serial_no = '$serial_no_delete'";
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
              if (Session::get("zone_serial_no")){
                  if (Session::get("zone_serial_no") != '-1') {
                    $zone_serial = Session::get("zone_serial_no");
                    $query = "SELECT * FROM employee_commission WHERE zone_serial_no = '$zone_serial' ORDER BY serial_no DESC";
                    $get_employee_commission = $dbOb->select($query);
                  }
                }else{
                  $query = "SELECT * FROM employee_commission ORDER BY serial_no DESC";
                  $get_employee_commission = $dbOb->select($query);
                }
              if ($get_employee_commission) {
                $i=0;
                while ($row = $get_employee_commission->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <!-- <td><?php //echo $row['company']; ?></td> -->
                    <?php 
                    $month = $row['month'];
                    $exp = explode('-', $month);
                    $month = $exp[0];
                    $year = $exp[1];
                    $month_name = '';
                    switch ($month) {
                      case '01':
                      $month_name = "January".'-'.$year;
                      break;
                      case '02':
                      $month_name = "February".'-'.$year;
                      break;
                      case '03':
                      $month_name = "March".'-'.$year;
                      break;
                      case '04':
                      $month_name = "April".'-'.$year;
                      break;
                      case '05':
                      $month_name = "May".'-'.$year;
                      break;
                      case '06':
                      $month_name = "June".'-'.$year;
                      break;
                      case '07':
                      $month_name = "July".'-'.$year;
                      break;
                      case '08':
                      $month_name = "August".'-'.$year;
                      break;
                      case '09':
                      $month_name = "September".'-'.$year;
                      break;
                      case '10':
                      $month_name = "October".'-'.$year;
                      break;
                      case '11':
                      $month_name = "November".'-'.$year;
                      break;
                      case '12':
                      $month_name = "December".'-'.$year;
                      break;
                      
                      
                    }
                    ?>
                    <td><?php echo $month_name; ?></td>
                    <td><?php echo $row['sell_target']; ?></td>
                    <td><?php echo $row['total_sell_amount']; ?></td>
                    <td><?php echo $row['comission_persent']; ?></td>
                    <?php 
                    
                    if ($row['sell_target'] <= $row['total_sell_amount']) {
                      $target = $row['total_sell_amount'];
                      $comission_persent = $row['comission_persent'];
                      $extra_sell = $row['total_sell_amount'] -  $row['sell_target'] ;
                      $comission_amount = (int)$extra_sell * (int)$comission_persent / 100 ;
                      ?>
                      <td><?php echo $comission_amount; ?></td>
                      
                      <?php
                    }else{
                      ?>
                      <td class="text-danger"><?php echo "Not Available"; ?></td>

                      <?php
                    }
                    ?>
                    <td><?php echo $row['date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('employee_comission_edit_button')) {
                        ?>
                        
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>
                      <?php 
                      if (permission_check('employee_comission_delete_button')) {
                        ?>

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a>  
                      <?php } ?>    
                    </td>
                  </tr>

                  <?php
                }
              }
}


/// now gettting employee information 
if (isset($_POST['employee_id_no'])) {
  $id_no = $_POST['employee_id_no'] ; 
  $query = "SELECT *  FROM employee_main_info WHERE id_no = '$id_no'";
  $get_emp  =  $dbOb->find($query);
  echo json_encode($get_emp);
}

 ?>