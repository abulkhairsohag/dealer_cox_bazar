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

// The following section is for showing data
if (isset($_POST['serial_no_view'])) {
	$serial_no = $_POST['serial_no_view'];

	$query_details = "SELECT * FROM new_order_details WHERE serial_no = '$serial_no'";
	$query_expense = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$serial_no'";

	$order_details = $dbOb->find($query_details);
	$order_expense = $dbOb->select($query_expense);
	$tr = '';
	if ($order_expense) {
		$i = 0;
		while ($row = $order_expense->fetch_assoc()) {
			$i++;
			$tr .= '<tr style="color:black"><td>';
			$tr .= $i;
			$tr .= '</td><td>';
			$tr .= ($row["products_id_no"]);
			$tr .= '</td><td>';
			$tr .= $row["products_name"];
			$tr .= '</td><td>';
			$tr .= $row["pack_size"];
			$tr .= '</td><td>';
			$tr .= $row["unit_tp"];
			$tr .= '</td><td>';
			$tr .= $row["unit_vat"];
			$tr .= '</td><td>';
			$tr .= $row["tp_plus_vat"];
			$tr .= '</td><td>';
			$tr .= $row["quantity"];
			$tr .= '</td><td>';
			$tr .= $row["total_tp"];
			$tr .= '</td><td>';
			$tr .= $row["total_vat"];
			$tr .= '</td><td class="text-right">';
			$tr .= $row["total_price"];
			$tr .= '</td></tr>';
		}

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Total  </td><td>';
		$tr .= number_format($order_details['net_total_tp'], 2);

		$tr .= '</td><td>';
		$tr .= number_format($order_details['net_total_vat'], 2);
		$tr .= '</td><td class="text-right">';
		$tr .= number_format($order_details['net_total'], 2);
		'</td></tr></tr>';

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Discount On TP';
		$tr .= $order_details['discount'];
		$tr .= '</td>';
		$tr .= '<td  colspan="2" class="text-center">';
		$tr .= $order_details['discount_on_tp'];

		$tr .= ' %</td><td class="text-right"> - ';
		$tr .= number_format($order_details['discount_amount'], 2);
		$tr .= '</td></tr>';

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Payable Amount  </td><td colspan="3" class="text-right" style="color:blue">';
		$tr .= number_format($order_details['payable_without_extra_discount'], 2);
		$tr .= '</td></tr>';

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Extra Discount';
		// $tr .= $delivery_details['extra_discount'];
		$tr .= '</td>';
		$tr .= '<td  colspan="2" class="text-center">';
		$tr .= $order_details['extra_discount'];

		$tr .= ' %</td><td class="text-right"> - ';
		$tr .= number_format(($order_details['payable_without_extra_discount'] * $order_details['extra_discount']) / 100, 2);
		$tr .= '</td></tr>';

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Net Payable Amount  </td><td colspan="3" class="text-right" style="color:blue">';
		$tr .= number_format($order_details['payable_amt'], 2);
		$tr .= '</td></tr>';
	}

	echo json_encode(['details' => $order_details, 'expense' => $tr]);
}

// The following section is for deleting data

if (isset($_POST['serial_no_delete'])) {
	$serial_no = $_POST['serial_no_delete'];

	$query = "DELETE FROM new_order_details WHERE serial_no = '$serial_no'";
	$delete_order_details = $dbOb->delete($query);
	if ($delete_order_details) {
		$query = "DELETE FROM new_order_expense WHERE new_order_serial_no = '$serial_no'";
		$delete_order_expense = $dbOb->delete($query);
		if ($delete_order_expense) {
			$message = "Congratulations! Information Is Successfully Deleted.";
			$type = "success";
			echo json_encode(['message' => $message, 'type' => $type]);
		} else {
			$message = "Sorry! Information Is Not Deleted.";
			$type = "warning";
			echo json_encode(['message' => $message, 'type' => $type]);
		}
	} else {
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);
	}
}

// the following section is for fetching data from database
if (isset($_POST["sohag"])) {
	$employee_id = $_POST['emp_id'];

	$query = "SELECT * FROM new_order_details WHERE employee_id = '$employee_id' AND delivery_report = '0' AND delivery_cancel_report = '0' ORDER BY serial_no DESC ";
	$get_order_info = $dbOb->select($query);
	if ($get_order_info) {
		$i = 0;
		while ($row = $get_order_info->fetch_assoc()) {
			$i++;

			?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $row['shop_name']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['area_employee']; ?></td>
                    <td><?php echo $row['payable_amt']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td align="center">

                         <a  class="badge  bg-green view_data" id="<?php echo ($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>



                        <a href='edit_new_order.php?serial_no=<?php echo urldecode($row['serial_no']); ?>&employee="yes"' class="badge  bg-blue edit_data" >Edit </a>



                        <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>

                    </td>
                  </tr>

                  <?php
}
	}

}

?>