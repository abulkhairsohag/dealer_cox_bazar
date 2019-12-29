<?php
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once "class/Session.php";
Session::init();
Session::checkSession();
error_reporting(1);
include_once 'helper/helper.php';
?>


<?php
include_once "class/Database.php";
$dbOb = new Database();

if (isset($_POST['serial_no_edit'])) {
	$serial_no_edit = $_POST['serial_no_edit'];
	$query = "SELECT * FROM bank_loan WHERE serial_no = '$serial_no_edit'";
	$get_bank_loan = $dbOb->find($query);
	echo json_encode($get_bank_loan);
}

// the following section is for inserting and updating data
if (isset($_POST['submit'])) {

	$bank_name = validation($_POST['bank_name']);
	$branch_name = validation($_POST['branch_name']);
	$total_amount = validation($_POST['total_amount']);
	$installment_amount = validation($_POST['installment_amount']);
	$installment_date = validation($_POST['installment_date']);
	$loan_taken_date = date('d-m-Y');
	$edit_id = validation($_POST['edit_id']);

	if ($edit_id) {
		$query = "UPDATE bank_loan
				  SET
					bank_name = '$bank_name',
					branch_name ='$branch_name',
					total_amount = '$total_amount',
					installment_amount = '$installment_amount',
					installment_date = '$installment_date'

				  WHERE
					serial_no = '$edit_id' ";

		$update = $dbOb->update($query);
		if ($update) {
			$message = "Congratulaitons! Information Is Successfully Updated.";
			$type = 'success';
			echo json_encode(['message' => $message, 'type' => $type]);
		} else {
			$message = "Sorry! Information Is Not Updated.";
			$type = 'warning';
			echo json_encode(['message' => $message, 'type' => $type]);

		}
	} else {
		$sql = "INSERT INTO bank_loan (bank_name, branch_name, total_amount,installment_amount,installment_date,loan_taken_date) VALUES ('$bank_name','$branch_name','$total_amount','$installment_amount','$installment_date','$loan_taken_date')";
		$insert = $dbOb->insert($sql);
		if ($insert) {
			$message = "Congratulaitons! Information Is Successfully Insert.";
			$type = 'success';
			echo json_encode(['message' => $message, 'type' => $type]);
		} else {
			$message = "Sorry! Information Is Not Insert.";
			$type = 'warning';
			echo json_encode(['message' => $message, 'type' => $type]);
		}

	}

}

// the following section is for pay data
if (isset($_POST['serial_no_pay'])) {
	$serial_no_pay = $_POST['serial_no_pay'];
	$query = "SELECT * FROM bank_loan WHERE serial_no = '$serial_no_pay'";
	$get_bank_pay = $dbOb->find($query);

	$pay_query = "SELECT * FROM bank_loan_pay WHERE bank_loan_id = '$serial_no_pay'";
	$pay_data = $dbOb->select($pay_query);
	if ($pay_data) {
		$total_pay = 0;
		while ($pay_row = $pay_data->fetch_assoc()) {
			$total_pay += $pay_row['pay_amt'];
		}
	} else {
		$total_pay = 0;
	}

	echo json_encode(['bank_pay' => $get_bank_pay, 'total_pay' => $total_pay]);
}
if (isset($_POST['submit_pay'])) {
	$bank_loan_id = $_POST['edit_id_pay'];
	$pay_amt = $_POST['installment_pay'];
	$pay_date = date("d-m-Y");

	$sql = "INSERT INTO bank_loan_pay
  				(bank_loan_id, pay_amt, `date`)
  				VALUES
  				 ('$bank_loan_id','$pay_amt','$pay_date')";

	$insert = $dbOb->insert($sql);
	if ($insert) {
		$message = "Congratulaitons! Payment Successfully Saved.";
		$type = 'success';
		echo json_encode(['message' => $message, 'type' => $type]);
	} else {
		$message = "Sorry! Payment Is Not Saved.";
		$type = 'warning';
		echo json_encode(['message' => $message, 'type' => $type]);
	}
}

// the following block of code is for deleting data
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM bank_loan WHERE serial_no = '$serial_no_delete'";
	$delete = $dbOb->delete($query);
	if ($delete) {
		$message = "Congratulaitons! Information Is Successfully Deleted.";
		$type = "success";
		echo json_encode(['message' => $message, 'type' => $type]);
	} else {
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);

	}
}

// the following section is for fetching data from database
if (isset($_POST["sohag"])) {

	$query = "SELECT * FROM bank_loan ORDER BY serial_no DESC";
	$get_bank_loan = $dbOb->select($query);
	if ($get_bank_loan) {
		$i = 0;
		while ($row = $get_bank_loan->fetch_assoc()) {
			$total_amount = $row['total_amount'];
			$bank_loan_id = $row['serial_no'];
			$i++;
			?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['bank_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['installment_amount']; ?></td>
                    <td><?php echo $total_amount; ?></td>



                    <?php

			$pay_query = "SELECT * FROM bank_loan_pay WHERE bank_loan_id = '$bank_loan_id'";
			$pay_data = $dbOb->select($pay_query);
			if ($pay_data) {
				$total_pay = 0;
				while ($pay_row = $pay_data->fetch_assoc()) {
					$total_pay += $pay_row['pay_amt'];
				}
				$due = $total_amount - $total_pay;
			} else {
				$total_pay = 0;
				$due = $total_amount;
			}?>

                    <td><?php echo $total_pay; ?></td>
                    <td style="color: red"><?php echo $due; ?></td>


                    <?php
if ($total_pay < $total_amount) {
				$display = "";
				?>
                      <td><?php echo '<span class="badge bg-red">UnPaid</span>'; ?></td>
                    <?php } else {
				$display = "none";
				?>
                      <td><?php echo '<span class="badge bg-green">Paid</span>'; ?></td>
                    <?php }
			?>
                    <td><?php echo $row['loan_taken_date']; ?></td>
                    <td><?php echo $row['installment_date']; ?></td>
                    <td align="center">

                      <?php
if (permission_check('bank_loan_view_button')) {
				?>
                      <a  class="badge  bg-green view_data" id="<?php echo ($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
                        <?php }?>

                      <?php
if (permission_check('bank_loan_edit_button')) {
				?>
                        <a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                      <?php }?>

                      <?php
if (permission_check('bank_loan_delete_button')) {
				?>

                        <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>
                      <?php }?>


                      <?php
if (permission_check('bank_loan_pay_button')) {
				?>
                      <a style="display: <?php echo $display; ?>; margin:2px "  class="badge pay_data bg-green" id="<?php echo ($row['serial_no']) ?>" data-toggle="modal" data-target="#pay_modal"  > Pay</a>
                      <?php }?>
                    </td>
                  </tr>

                  <?php
}
	}
}

?>