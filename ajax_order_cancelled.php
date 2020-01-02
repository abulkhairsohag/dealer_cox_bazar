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

	$query_details = "SELECT * FROM new_order_details WHERE serial_no = '$serial_no'";
	$query_expense = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$serial_no'";

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
			$tr .= $row["pack_size"];
			$tr .= '</td><td>';
			$tr .= $row["unit_tp"];
			$tr .= '</td><td>';
			$tr .= $row["unit_vat"] ;
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
		$tr .= number_format($delivery_details['net_total_tp'],2);

		$tr .= '</td><td>';
		$tr .= number_format($delivery_details['net_total_vat'],2);
		$tr .='</td><td class="text-right">';
		$tr .= number_format($delivery_details['net_total'],2);
		'</td></tr></tr>';

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Discount On TP';
		$tr .= $delivery_details['discount'];
		$tr .= '</td>';
		$tr .= '<td  colspan="2" class="text-center">';
		$tr .= $delivery_details['discount_on_tp'];

		$tr .= ' %</td><td class="text-right"> - ';
		$tr .= number_format($delivery_details['discount_amount'],2);
		$tr .='</td></tr>';

		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Payable Amount  </td><td colspan="3" class="text-right" style="color:blue">';
		$tr .= number_format($delivery_details['payable_without_extra_discount'],2);
		$tr .= '</td></tr>';


		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Extra Discount';
		// $tr .= $delivery_details['extra_discount'];
		$tr .= '</td>';
		$tr .= '<td  colspan="2" class="text-center">';
		$tr .= $delivery_details['extra_discount'];

		$tr .= ' %</td><td class="text-right"> - ';
		$tr .= number_format(($delivery_details['payable_without_extra_discount']*$delivery_details['extra_discount'])/100,2);
		$tr .='</td></tr>';






		$tr .= '<tr style="color:black"><td colspan="8" style="text-align: right;">Net Payable Amount  </td><td colspan="3" class="text-right" style="color:blue">';
		$tr .= number_format($delivery_details['payable_amt'],2);
		$tr .= '</td></tr>';
	}

	echo json_encode(['details'=>$delivery_details,'expense'=>$tr]);
}

?>