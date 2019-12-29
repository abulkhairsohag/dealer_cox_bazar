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
	$query = "SELECT * FROM company_commission WHERE serial_no = '$serial_no_edit'";
	$get_company_comission = $dbOb->find($query);
	echo json_encode($get_company_comission);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

          $company = validation($_POST['company']);
          $month = validation($_POST['month']);
          $target_product = validation($_POST['target_product']);
          $target_sell_amount = validation($_POST['target_sell_amount']);
          $comission_persent = validation($_POST['comission_persent']);

          $date = date("d-m-Y");
          $edit_id = validation($_POST['edit_id']);

	if ($edit_id) {
		$query = "UPDATE company_commission 
				  SET 
					company = '$company',
					month = '$month',
					target_product 	='$target_product',
          target_sell_amount ='$target_sell_amount',
					comission_persent ='$comission_persent',
					date = '$date'
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
		$query = "INSERT INTO company_commission 
					(company,month,target_product,target_sell_amount,comission_persent,date)
				  VALUES 
				  	('$company','$month','$target_product','$target_sell_amount','$comission_persent','$date')";
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
	$query = "DELETE FROM company_commission WHERE serial_no = '$serial_no_delete'";
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
  $query = "SELECT * FROM company_commission ORDER BY serial_no DESC";
              $get_company_commission = $dbOb->select($query);
              if ($get_company_commission) {
                $i=0;
                while ($row = $get_company_commission->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['company']; ?></td>
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
                    <td><?php echo $row['target_product']; ?></td>
                    <td><?php echo $row['target_sell_amount']; ?></td>
                    <td><?php echo $row['comission_persent']; ?></td>
                    
                    <td><?php echo $row['date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('company_comission_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>
                      <?php 
                      if (permission_check('company_comission_delete_button')) {
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