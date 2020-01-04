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

include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['from_date'])) {

	$from_date =  strtotime($_POST['from_date']);
	$to_date =  strtotime($_POST['to_date']);
	$report_type = validation($_POST['report_type']);
	$customer_id = validation($_POST['customer_id']);
	$employee_id = validation($_POST['employee_id']);
	$paid_due = validation($_POST['paid_due']);


			

	$total_amount = 0 ;
	$total_pay = 0;
	$total_due  = 0 ;
	$i = 0;

	$query = "SELECT * FROM own_shop_sell";
	$get_own_shop_sell = $dbOb->select($query);

	if ($report_type == 'Sell Report') {
		$query = "SELECT * FROM own_shop_sell";
		$get_own_shop_sell = $dbOb->select($query);
		if ($get_own_shop_sell) {

			$all_sell_tbl = '<span align="center"><h3 style="color:red">All Sell Report</h3><hr>';


 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					if ($row['customer_id'] == '-1') {
						$customr_nm = "Walking Customer";
					}else{
						$customr_nm = $row['customer_name'];
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$customr_nm.'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
		}
		echo json_encode($all_sell_tbl);
	}elseif ($report_type == 'Due sell Report') {
		$query = "SELECT * FROM own_shop_sell WHERE due > '0'";
		$get_own_shop_sell = $dbOb->select($query);

		if ($get_own_shop_sell) {

			$all_sell_tbl = '<span align="center"><h3 style="color:red">Due Sell Report</h3><hr>';


 		
 		 		
 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					if ($row['customer_id'] == '-1') {
						$customr_nm = "Walking Customer";
					}else{
						$customr_nm = $row['customer_name'];
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$customr_nm.'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
		}
		echo json_encode($all_sell_tbl);
	}elseif ($report_type == 'Paid sell Report') {

		$query = "SELECT * FROM own_shop_sell WHERE due = '0'";
		$get_own_shop_sell = $dbOb->select($query);

		if ($get_own_shop_sell) {

			$all_sell_tbl = '<span align="center"><h3 style="color:red">Paid Sell Report</h3><hr>';


 		
 		 		
 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					if ($row['customer_id'] == '-1') {
						$customr_nm = "Walking Customer";
					}else{
						$customr_nm = $row['customer_name'];
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$customr_nm.'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
		}
		echo json_encode($all_sell_tbl);
	}elseif ($report_type == 'Customer Wise Report') {

		if ($paid_due == "all") {
			

			$query = "SELECT * FROM own_shop_sell WHERE customer_id = '$customer_id'";
			$get_own_shop_sell = $dbOb->select($query);

			$query = "SELECT * FROM own_shop_sell WHERE customer_id = '$customer_id'";
			$get_customer =$dbOb->find($query);
			$name = $get_customer['customer_name'];
			$mobile_no =  $get_customer["mobile_no"];
			
			if ($get_own_shop_sell) {

				$all_sell_tbl = '<span align="center"><h3 style="color:red">Sell Report Of Customer  </h3><h4 style="color:green">Name : '.$name.'</h4><h4 style="color:green">Mobile No. : '.$mobile_no.'</h4><hr>';


	 			
 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					if ($row['customer_id'] == '-1') {
						$customr_nm = "Walking Customer";
					}else{
						$customr_nm = $row['customer_name'];
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$customr_nm.'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
			}
			echo json_encode($all_sell_tbl);
			// the following section is for paid
		}elseif ($paid_due == 'paid') {

			// echo json_encode($paid_due);
			// die();
			$query = "SELECT * FROM own_shop_sell WHERE customer_id = '$customer_id' AND due = '0'";
			$get_own_shop_sell = $dbOb->select($query);


			$query = "SELECT * FROM own_shop_sell WHERE customer_id = '$customer_id'";
			$get_customer =$dbOb->find($query);
			$name = $get_customer['customer_name'];
			$mobile_no =  $get_customer["mobile_no"];
			


			if ($get_own_shop_sell) {

				$all_sell_tbl = '<span align="center"><h3 style="color:red">Paid Sell Report Of Customer  </h3><h4 style="color:green">Name : '.$name.'</h4><h4 style="color:green">Mobile No. : '.$mobile_no.'</h4><hr>';


	 			
 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$row['customer_name'].'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
			}
			echo json_encode($all_sell_tbl);
			// the following section is for due
		}elseif ($paid_due == 'due') {


			$query = "SELECT * FROM own_shop_sell WHERE customer_id = '$customer_id' AND due > '0'";
			$get_own_shop_sell = $dbOb->select($query);


			$query = "SELECT * FROM own_shop_sell WHERE customer_id = '$customer_id'";
			$get_customer =$dbOb->find($query);
			$name = $get_customer['customer_name'];
			$mobile_no =  $get_customer["mobile_no"];
			


			if ($get_own_shop_sell) {

				$all_sell_tbl = '<span align="center"><h3 style="color:red">Paid Sell Report Of Customer  </h3><h4 style="color:green">Name : '.$name.'</h4><h4 style="color:green">Mobile No. : '.$mobile_no.'</h4><hr>';


	 			
 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					if ($row['customer_id'] == '-1') {
						$customr_nm = "Walking Customer";
					}else{
						$customr_nm = $row['customer_name'];
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$customr_nm.'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
			}
			echo json_encode($all_sell_tbl);
			// the following section is for due
		}
	}elseif ($report_type == 'Employee Wise Sell Report') {

		$query = "SELECT * FROM own_shop_sell WHERE employee_id = '$employee_id'";
		$get_own_shop_sell = $dbOb->select($query);


		$query = "SELECT * FROM own_shop_sell WHERE employee_id = '$employee_id'";
		$get_emp =$dbOb->find($query);
		$name = $get_emp['employee_name'];

		if ($get_own_shop_sell) {

			$all_sell_tbl = '<span align="center"><h3 style="color:red">Sell Report Of Employee  </h3><h4 style="color:green">Name : '.$name.'</h4><h4 style="color:green">ID : '.$employee_id.'</h4><hr>';


 		
 		 		$all_sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Mobile No.</th>
						      <th scope="col">Sold By</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Sell Date</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
			while ($row = $get_own_shop_sell->fetch_assoc()) {
				if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
					if ($row['due'] > 0) {
						$color = 'red';
						$badge = 'bg-red';
					}else{
						$color = 'green';
						$badge = 'bg-green';
					}
					if ($row['customer_id'] == '-1') {
						$customr_nm = "Walking Customer";
					}else{
						$customr_nm = $row['customer_name'];
					}
					$all_sell_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$customr_nm.'</td>
								      <td>'.$row['mobile_no'].'</td>
								      <td>'.$row['employee_name'].'</td>
								      <td>'.number_format($row['grand_total'],2).'</td>
								      <td>'.number_format($row['pay'],2).'</td>
								      <td style="color:'.$color.'">'.number_format($row['due'],2).'</td>
								      <td>'.$row['sell_date'].'</td>
								      <td>
								      <a  class="badge  '.$badge.' view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a>
								      </td>
								    </tr>';
					$total_amount += $row['grand_total'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				}
			}


 			$all_sell_tbl .='<tr>
								      <td colspan="4"  align="right" style="color:red">Total</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_amount,2).'</td>
								      <td colspan="" align="left" style="color:green">'.number_format($total_pay,2).'</td>
								      <td colspan="3" align="left" style="color:red">'.number_format($total_due,2).'</td>
								      
								    </tr>';

 			 $all_sell_tbl.= '  </tbody>
						</table>';
		}
		echo json_encode($all_sell_tbl);
	}

	}
 ?>