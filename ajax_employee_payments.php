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


          $id_no = $_POST['id_no'];
          $name = $_POST['name'];
          $designation = $_POST['designation'];
          $total_salary = $_POST['total_salary'];
          $month = $_POST['month'];
          $attendance = $_POST['attendance'];
          $pay_type = $_POST['pay_type'];
          $advance_amount = $_POST['advance_amount'];
          if ($advance_amount=="") {
            $advance_amount = 0;
          }
          $salary_paid =  (int)$total_salary + (int)$advance_amount;
          $description = $_POST['description'];
          $date = date("d-m-Y");
          $edit_id = $_POST['edit_id'];


	if ($edit_id) {
    $query = "SELECT * FROM employee_payments WHERE serial_no <> $edit_id";
    $get_payment_data = $dbOb->select($query);
    $confirmation = true;
    if ($get_payment_data) {
      while ($row = $get_payment_data->fetch_assoc()) {
        if ($row['id_no'] == $id_no && $row['month'] == $month) {
          $confirmation = false;
        }
      }
    }

    if ($confirmation) {
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
          $message = "Payment Of This Employee Already Given.";
          $type = 'warning';
          echo json_encode(['message'=>$message,'type'=>$type]);
        }
	}else{
    $query = "SELECT * FROM employee_payments WHERE id_no = '$id_no' AND month = '$month'";
    $get_pay_info = $dbOb->find($query);

    $confirmation = true;
    if ($get_pay_info) {
       $confirmation = false;
    }

    if ($confirmation) {

        $query = "INSERT INTO employee_payments 
              (id_no,name,designation,total_salary,month,attendance,pay_type,advance_amount,salary_paid,description,date)
              VALUES 
                ('$id_no','$name','$designation','$total_salary','$month','$attendance','$pay_type','$advance_amount','$salary_paid','$description','$date')";

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
      $message = "Payment Is Already Given.";
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
}

// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
        
              $query = "SELECT * FROM employee_payments ORDER BY serial_no DESC";
              $get_employee_commission = $dbOb->select($query);
              if ($get_employee_commission) {
                $i=0;
                while ($row = $get_employee_commission->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
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
                    <td><?php echo $row['advance_amount']; ?></td>
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
  $id_no = $_POST['employee_id_no'] ; 
  $query = "SELECT *  FROM employee_main_info WHERE id_no = '$id_no'";
  $get_emp  =  $dbOb->find($query);
  echo json_encode($get_emp);
}

 ?>