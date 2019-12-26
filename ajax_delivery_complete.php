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


// The following section is for showing data 
if (isset($_POST['serial_no_view'])) {
	$serial_no = $_POST['serial_no_view'];

	$query_details = "SELECT * FROM order_delivery WHERE serial_no = '$serial_no'";
	$query_expense = "SELECT * FROM order_delivery_expense WHERE delivery_tbl_serial_no = '$serial_no'";

	$delivery_details = $dbOb->find($query_details);
	$delivery_expense = $dbOb->select($query_expense);
	$tr = '' ;
	if ($delivery_expense) {
		$i = 0;
		while ($row = $delivery_expense->fetch_assoc()) {
			$i++;
			$tr .='<tr style="color:black"><td>';
			$tr .= $i;
			$tr .= '</td><td>';
			$tr .=($row["products_id_no"]);
			$tr .= '</td><td>';
			$tr .= $row["products_name"] ;
			$tr .= '</td><td>';
			$tr .= $row["sell_price"];
			$tr .= '</td><td>';
			$tr .= $row["qty"];
			$tr .= '</td><td>';
			$tr .= $row["offer_qty"] ;
			$tr .= '</td><td class="text-right">';
			$tr .= $row["total_price"];
			$tr .= '</td></tr>';
		}

		$tr .= '<tr style="color:blue"><td colspan="6" style="text-align: right;">Net Payable Amount  </td><td colspan="3" class="text-right" style="color:blue">';
		$tr .= number_format($delivery_details['payable_amt'],2);
		$tr .= '</td></tr>';

		$tr .= '<tr style="color:blue"><td colspan="6" style="text-align: right;">Pay Amount  </td><td colspan="3" class="text-right" style="color:blue">';
		$tr .= number_format($delivery_details['pay'],2);
		$tr .= '</td></tr>';

		$tr .= '<tr style="color:blue"><td colspan="6" style="text-align: right;">Due Amount  </td><td colspan="3" class="text-right" style="color:red">';
		$tr .= number_format($delivery_details['due'],2);
		$tr .= '</td></tr>';
		
	}

	echo json_encode(['details'=>$delivery_details,'expense'=>$tr]);
}


if (isset($_POST['cancel_order_tbl_serial_no'])) {

	$order_id = $_POST['cancel_order_tbl_serial_no'];
	$deliver_id = $_POST['cancel_delivery_tbl_serial_no'];

	$query = "DELETE FROM order_delivery WHERE serial_no = '$deliver_id'";
	$delete_deliv = $dbOb->delete($query);
	if ($delete_deliv) {
		$query = "UPDATE new_order_details 
		SET 
		delivery_cancel_report = '1', 
		delivery_report = '0'
		WHERE 
		serial_no = '$order_id'";
		$update_new_order = $dbOb->update($query);
		if ($update_new_order) {
			$message = "Congratulations! Order Successfully Cancelled...";
			$type = 'success';
			die(json_encode(['message'=>$message,'type'=>$type]));
		}else{
			$message = "Sorry! Deleted From Delivery But Not Cancelled Yeat..";
			$type = 'warning';
			die(json_encode(['message'=>$message,'type'=>$type]));
		}
	}else{
		$message = "Sorry! Cancellation Failed.";
			$type = 'warning';
			die(json_encode(['message'=>$message,'type'=>$type]));
	}

}
	







?>