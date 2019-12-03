<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');

include_once("class/Database.php");
$dbOb = new Database();


// The following section is for showing data 
if (isset($_POST['serial_no_view'])) {
	$serial_no = $_POST['serial_no_view'];

	$query_loan = "SELECT * FROM bank_loan WHERE serial_no = '$serial_no'";
	$query_loan_pay = "SELECT * FROM bank_loan_pay WHERE bank_loan_id = '$serial_no'";

	$bank_loan_details = $dbOb->find($query_loan);
	$loan_pay = $dbOb->select($query_loan_pay);
	$tr = '' ;
	if ($loan_pay) {
		$i = 0;
		$total_pay = 0;
		while ($row = $loan_pay->fetch_assoc()) {
			$total_pay += $row['pay_amt'];
			$total_amount = $bank_loan_details['total_amount'];
			$total_due = $total_amount - $total_pay;
			$i++;
			$tr .='<tr style="color:black"><td>';
			$tr .= $i;
			$tr .= '</td><td>';
			$tr .=number_format($row["pay_amt"],2);
			$tr .= '</td><td>';
			$tr .= $row["date"] ;
			$tr .= '</td></tr>';
		}

		$tr .= '</td></tr><tr style="color:black" ><td align="right">Total Paid (৳)  </td><td colspan="2" style="color:green">';
		$tr .= number_format($total_pay,2);
		$tr .= '</td></tr><tr style="color:black"><td align="right">Total due (৳)  </td><td colspan="2" style="color:red">';
		$tr .= number_format($total_due,2);
		$tr .= '</td></tr>';
	}else{
		$total_pay = 0;
	}

	echo json_encode(['query_loan'=>$bank_loan_details,'expense'=>$tr]);
}

?>