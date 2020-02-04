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
	$query = "SELECT * FROM employee_payments WHERE serial_no = '$serial_no_edit'";
	$get_payment = $dbOb->find($query);
  $emp_id = $get_payment['id_no'];

  $query = "SELECT * FROM employee_main_info WHERE id_no = '$emp_id'";
  $get_emp = $dbOb->find($query);
  $emp_salary = $get_emp['total_salary'];

	echo json_encode(['get_payment'=>$get_payment,'emp_salary'=>$emp_salary]);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {


          $id_no = validation($_POST['id_no']);
          $name = validation($_POST['name']);
          $designation = validation($_POST['designation']);
          $advance_amount = validation($_POST['advance_amount']);
          $total_salary = validation($_POST['total_salary']);
          $salary_to_be_paid = validation($_POST['salary_to_be_paid']);
          $salary_paid = $salary_to_be_paid;

          $month = validation($_POST['month']);

          $next_month = null;
          $extra_for_next_month = 0;

          if ($salary_to_be_paid > $total_salary) {
            $salary_paid = $total_salary;
            $extra_for_next_month = $salary_to_be_paid - $total_salary ;
            $month_calc = explode('-', $month);

            $month_no = $month_calc[0];
            $year = $month_calc[1];
            $month_no =$month_no*1 + 1*1;
            if ($month_no > 12) {
              $month_no = 1;
              $year = $year*1 + 1*1;
            }
            $next_month = '0'.$month_no.'-'.$year;
          }

          $attendance = validation($_POST['attendance']);
          $pay_type = validation($_POST['pay_type']);
          

          $description = validation($_POST['description']);
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
      $query = "SELECT * FROM employee_payments WHERE previous_pay_serial_no = $edit_id";
      $get_extra_payment = $dbOb->select($query);

      if ($get_extra_payment) {
        $query = "DELETE FROM employee_payments WHERE previous_pay_serial_no = $edit_id";
      }
      

          $query = "UPDATE employee_payments 
                SET 
                id_no = '$id_no',
                name = '$name',
                designation = '$designation',
                total_salary = '$total_salary',
                month = '$month',
                attendance = '$attendance',
                pay_type = '$pay_type',
                advance_amount = '$advance_amount',
                salary_paid = '$salary_paid',
                description   ='$description',
                date = '$date',
                zone_serial_no = '$zone_serial_no',
                zone_name = '$zone_name'
                WHERE
                serial_no = '$edit_id' ";

          $update = $dbOb->update($query);

          if ($next_month) {
            $total_salary = salary_calculation($id_no,$next_month);
            $query = "INSERT INTO employee_payments 
                (id_no,name,designation,total_salary,month,attendance,pay_type,advance_amount,salary_paid,description,date,zone_serial_no,zone_name,previous_pay_serial_no)
                VALUES 
                  ('$id_no','$name','$designation','$total_salary','$next_month','$attendance','$pay_type','$extra_for_next_month','$extra_for_next_month','$description','$date','$zone_serial_no','$zone_name','$insert_id')";

            $insert_next = $dbOb->insert($query);
          }

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


          $query = "INSERT INTO employee_payments 
                (id_no,name,designation,total_salary,month,attendance,pay_type,advance_amount,salary_paid,description,date,zone_serial_no,zone_name)
                VALUES 
                  ('$id_no','$name','$designation','$total_salary','$month','$attendance','$pay_type','$advance_amount','$salary_paid','$description','$date','$zone_serial_no','$zone_name')";

          $insert_id = $dbOb->custom_insert($query);

          if ($next_month) {
            $total_salary = salary_calculation($id_no,$next_month);
            $query = "INSERT INTO employee_payments 
                (id_no,name,designation,total_salary,month,attendance,pay_type,advance_amount,salary_paid,description,date,zone_serial_no,zone_name,previous_pay_serial_no)
                VALUES 
                  ('$id_no','$name','$designation','$total_salary','$next_month','$attendance','$pay_type','$extra_for_next_month','$extra_for_next_month','$description','$date','$zone_serial_no','$zone_name','$insert_id')";

            $insert_next = $dbOb->insert($query);
          }
          if ($insert_id) {
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
	$query = "DELETE FROM employee_payments WHERE serial_no = '$serial_no_delete'";
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


// now getting employee attendance iformation
if (isset($_POST['emp_id_no'])) {
  $emp_id_no = $_POST['emp_id_no'];
  $payment_month = $_POST['payment_month'];

  $query = "SELECT * FROM employee_attendance WHERE employee_id_no = '$emp_id_no' AND attendance = 'Present' AND attendance_month = '$payment_month' ";
  $attendance = $dbOb->count_row_number($query);
  if ($attendance == false) {
    $attendance = 0;
  }
  echo json_encode( $attendance);
  die();
}

// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
        
        if (Session::get("zone_serial_no")){
                  if (Session::get("zone_serial_no") != '-1') {
                    $zone_serial = Session::get("zone_serial_no");
                    $query = "SELECT * FROM employee_payments WHERE zone_serial_no = '$zone_serial' ORDER BY serial_no DESC";
                    $get_employee_commission = $dbOb->select($query);
                  }
                }else{
                  $query = "SELECT * FROM employee_payments ORDER BY serial_no DESC";
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
                    <td><?php echo $row['total_salary']; ?></td>
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
                    <td><?php echo $row['attendance']; ?></td>
                    <td><?php echo $row['pay_type']; ?></td>
                    <td><?php echo $row['salary_paid']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('payment_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>
                      <?php 
                      if (permission_check('payment_delete_button')) {
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
  $emp_id = $_POST['employee_id_no'];
  $month = $_POST['month_nam'];

  $query = "SELECT *  FROM employee_main_info WHERE id_no = '$emp_id'";
  $get_emp  =  $dbOb->find($query);
  $salary = salary_calculation($emp_id,$month);


  die(json_encode(['employee_info'=>$get_emp,'salary'=>$salary]));
}

 ?>