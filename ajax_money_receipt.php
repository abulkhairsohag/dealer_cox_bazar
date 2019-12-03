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

include_once 'class/Database.php';
$dbOb = new Database();

if (isset($_POST['from_date'])) {

	$from_date = strtotime($_POST['from_date']);
	$from_date_show = $_POST['from_date'];
	$to_date = strtotime($_POST['to_date']);
	$to_date_show = $_POST['to_date'];
	$employee_id = $_POST['employee_id'];

	$query = "SELECT * FROM money_receipt_main_tbl ORDER BY serial_no DESC LIMIT 1";
	$get_receipt = $dbOb->select($query);
		if ($get_receipt) {
	  $today = date("Ymd");
		$last_id = $get_receipt->fetch_assoc()['receipt_no'];
		$exploded_id = explode('-', $last_id);
	  $exploded_id = str_split($exploded_id[1],8);

	  if ($exploded_id[0] == $today) {
	    $last_id = $exploded_id[1] * 1 + 1;
	    $id_length = strlen($last_id);
	    $remaining_length = 4 - $id_length;
	    $zeros = "";

	    if ($remaining_length > 0) {
	      for ($i = 0; $i < $remaining_length; $i++) {
	        $zeros = $zeros . '0';
	      }
	      $new_receipt_no = 'MR-'.$exploded_id[0] . $zeros . $last_id;
	    }
	  }else {
	    $new_receipt_no = 'MR-'.$today."0001";
	  }
	}


	$printing_date = date('d F, Y');
	$printing_time = date('h:i:s A');

	$query = "SELECT * FROM employee_main_info WHERE id_no = '$employee_id'";
	$emp_info = $dbOb->find($query);
	$emp_name = $emp_info['name'];

	$query = "SELECT * FROM delivered_order_payment_history WHERE delivery_emp_id = '$employee_id'";
	$get_payment = $dbOb->select($query);

	$company_profile = '';
	$query = "SELECT * FROM profile";
	$get_profile = $dbOb->select($query);
	if ($get_profile) {
		$company_profile = $get_profile->fetch_assoc();
		// die('sohag');
	}

	if ($from_date == $to_date) {
		$show_date = 'Date :' . $from_date_show;
	} else {
		$show_date = 'Date : ' . $from_date_show . ' <span class="badge bg-red"> TO </span> ' . $to_date_show;
	}
	$table = ' <div  id="print_table" style="color:black">
                        <span class="text-center">
                            <h3><b>' . strtoupper($company_profile['organization_name']) . '</b></h3>
                            <h5>' . $company_profile['address'] . ', ' . $company_profile['mobile_no'] . '</h5>
                            <h5>' . $show_date . '</h5>
                    </span>
                        <table class="table table-responsive">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5 style="margin:0px ; margin-top: -8px;"><b>Receipt No : <span>' . $new_receipt_no . '</span></b> </h5>
                                        <h5 style="margin:0px ; margin-top: -8px;">Employee ID: <span>' . $employee_id . '</span></h5>
                                        <h5 style="margin:0px ; margin-top: -8px;">Name:<span> ' . $emp_name . '</span></h5>
                                    </td>
                                    <td class="text-center">
                                        <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>MONEY RECEIPT</b></h4>
                                    </td>
                                    <td class="text-right">
                                        <h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span></span>' . $printing_date . '</span></h5>
                                        <h5 style="margin:0px ; margin-top: -8px;">Time : <span></span>' . $printing_time . '</span></h5>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    <!--
                    <hr> -->
                    <table class="table table-bordered table-responsive">
                        <thead style="background:#4CAF50; color:white" >
                            <tr>
                                <th>Sl No</th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Shop Name</th>
                                <th>Area</th>
                                <th>Payment Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>';

	$i = 0;
	$total_pay = 0;
	if ($get_payment) {
		while ($row = $get_payment->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$i++;
				$deliv_serial_no = $row['deliver_order_serial_no'];
				$query = "SELECT * FROM order_delivery WHERE serial_no = '$deliv_serial_no'";
				$get_deliv = $dbOb->select($query);
				if ($get_deliv) {
					$deliv_info = $get_deliv->fetch_assoc();
					if ($row['pay_amt'] > 0) {

						$table .= ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $deliv_info['order_no'] . '</td>
                                <td>' . $deliv_info['order_date'] . '</td>
                                <td>' . $deliv_info['shop_name'] . '</td>
                                <td>' . $deliv_info['area'] . '</td>
                                <td>' . $row['date'] . '</td>
                                <td>' . $row['pay_amt'] . '</td>
                            </tr>';
						$total_pay += $row['pay_amt'];
					}

				}

			}
		}

	}

	if ($i > 0) {
		$table .= '<tr>
        <td colspan="6" class="text-right">Total Amount</td>
        <td>' . $total_pay . '</td>
    </tr>';
	} else {
		$table .= '<tr style="color:red" class="text-center">
                     <td colspan="7" class="text-center">No Payment Found</td>
                  </tr>';
	}

	$table .= '</tbody>
            </table>';

	$print_table = 'print_table';

	$table .= '<div class="container-fulid">
                    <div class="row">
                        <div class="col-md-12">';
	if ($i > 0) {
		# code...
		$table .= '<h5>IN WORD: ' . strtoupper(convertNumberToWord($total_pay)) . ' (TAKA ONLY).</h5>';
	}
	$table .= '</div>
                        <br>

                    </div>
                    <table class="table table-responsive text-center" style="margin-top:100px">
                            <tbody>
                                <tr>
                                    <td>
                                    <b> MPO/SR </b>
                                    </td>
                                    <td>
                                    <b> Accounts</b>
                                    </td>

                                </tr>

                            </tbody>
                        </table>

                </div>
                </div>
                <br>
                <br>
                <div class="mt-3 text-center" >

                <input type="hidden" name="receipt_no" id="receipt_no" value="' . $new_receipt_no . '">
                <input type="hidden" name="from_date_print" id="from_date_print" value="' . $from_date_show . '">
                <input type="hidden" name="to_date_print" id="to_date_print" value="' . $to_date_show . '">
                <input type="hidden" name="employee_id_print" id="employee_id_print" value="' . $employee_id . '">
                <input type="hidden" name="employee_name_print" id="employee_name_print" value="' . $emp_name . '">
                <input type="hidden" name="printing_date" id="printing_date" value="' . $printing_date . '">
                <input type="hidden" name="printing_time" id="printing_time" value="' . $printing_time . '">
                <input type="hidden" name="in_word" id="in_word" value="' . strtoupper(convertNumberToWord($total_pay)) . '">
                <input type="hidden" name="total_pay" id="total_pay" value="' . $total_pay . '">';

	if ($total_pay > 0) {
		$table .= '   <a class="text-light btn-success btn" onclick="printContent(\'' . $print_table . '\')" name="print" id="print_receipt">Save & Print</a>';
	}

	$table .= ' </div>';

	echo json_encode($table);
	exit();

}

function convertNumberToWord($num = false) {
	$num = str_replace(array(',', ' '), '', trim($num));
	if (!$num) {
		return false;
	}
	$num = (int) $num;
	$words = array();
	$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
		'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen',
	);
	$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
	$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
		'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
		'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion',
	);
	$num_length = strlen($num);
	$levels = (int) (($num_length + 2) / 3);
	$max_length = $levels * 3;
	$num = substr('00' . $num, -$max_length);
	$num_levels = str_split($num, 3);
	for ($i = 0; $i < count($num_levels); $i++) {
		$levels--;
		$hundreds = (int) ($num_levels[$i] / 100);
		$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
		$tens = (int) ($num_levels[$i] % 100);
		$singles = '';
		if ($tens < 20) {
			$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
		} else {
			$tens = (int) ($tens / 10);
			$tens = ' ' . $list2[$tens] . ' ';
			$singles = (int) ($num_levels[$i] % 10);
			$singles = ' ' . $list1[$singles] . ' ';
		}
		$words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
	} //end for loop
	$commas = count($words);
	if ($commas > 1) {
		$commas = $commas - 1;
	}
	return implode(' ', $words);
}
?>