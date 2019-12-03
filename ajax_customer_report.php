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

if (isset($_POST['report_type'])) {
	
 	$report_type = $_POST['report_type'];
    $customer_id = $_POST['customer_id'];
    $area = $_POST['area'];

    $query = "SELECT * FROM client WHERE cust_id = '$customer_id'";
    $get_cust_info = $dbOb->select($query);
    if ($get_cust_info) {
        $cust= $get_cust_info->fetch_assoc();
        $cust_shop = $cust['organization_name'];
        $cust_name = $cust['client_name'];
        $cust_phone = $cust['mobile_no'];
        $cust_area = $cust['area_name'];
    }

 

    // die($customer_id);
    
	$from_date = strtotime($_POST['from_date']);
	$from_date_show = $_POST['from_date'];
	$to_date = strtotime($_POST['to_date']);
	$to_date_show = $_POST['to_date'];

	$print_table = 'print_table';
	$printing_date = date('d F, Y');
	$printing_time = date('h:i:s A');

    $company_profile = '';
    $query = "SELECT * FROM profile";
    $get_profile = $dbOb->select($query);
    if ($get_profile) {
        $company_profile = $get_profile->fetch_assoc();
    }
    if ($from_date_show == $to_date_show) {
        $show_date = 'Report Date :'.$from_date_show ;
    }else{
        $show_date = 'Report Date : '.$from_date_show.' <span class="badge bg-red"> TO </span> '.$to_date_show;
    }

 if($report_type == 'customer_wise_order'){
		 $query = "SELECT * FROM `order_delivery` WHERE cust_id ='$customer_id'";
		 $get_order = $dbOb->select($query);

		 $sales_dues_tbl = '<div  id="print_table" style="color:black">
		 <span class="text-center">
			 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			 <h5>'.$show_date.'</h5>
			 
	 </span>
	 <div class="text-center">
		 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>CUSTOMER WISE DELIVERY REPORT</b></h4>
	 </div>
	 <br>
		 <table class="table table-responsive">
			 <tbody>
				 <tr>
					 <td class="text-left">
                        <h5 style="margin:0px ; margin-top: -8px;">Customer ID : <span></span>'.$customer_id.'</span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Shop Name : <span></span>'.$cust_shop.'</span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$cust_name.'</span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Phone : <span></span>'.$cust_phone.'</span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Area : <span></span>'.$cust_area.'</span></h5>
					 </td>
					 <td class="text-center">
						 
					 </td>
					 <td class="text-right">
						 <h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span></span>'.$printing_date.'</span></h5>
						 <h5 style="margin:0px ; margin-top: -8px;">Time : <span></span>'.$printing_time.'</span></h5>
					 </td>
				 </tr>
			 
			 </tbody>
		 </table>
	 <!--     
	 <hr> -->
	 <table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						  <tr>
						  <th scope="col">SL No</th>
						  <th scope="col">Employee ID</th>
						  <th scope="col">Name</th>
						  <th scope="col">Order No</th>
						  <th scope="col">Total TP</th>
						  <th scope="col">Total VAT</th>
						  <th scope="col">Total TP+VAT </th>
						  <th scope="col">Payable</th>
						  <th scope="col">Pay</th>
						  <th scope="col">Due</th>
						  <th scope="col">Order</th>
						  <th scope="col">Delivery</th>
						</tr>
						  </thead>
						  <tbody>';
		$i = 0;
		$total_tp = 0;
		$total_vat = 0;
		$total_tp_vat = 0;
		$total_payable = 0;
		$total_pay = 0;
		$total_due = 0;
		 if ($get_order) {
			 

			 while ($row = $get_order->fetch_assoc()) {
				 $order_date = strtotime($row['order_date']);
				 if ($order_date >= $from_date &&  $order_date <= $to_date) {
					 if ($row['due']==0) {
						$pay =  '<span class="badge bg-green">Paid</span>';
					 }else{
						$pay =  $row['due'];
					 }
					
					 $sales_dues_tbl .= ' <tr align="left" style="color:black">
											<td>'.++$i.'</td>
											<td>'.$row['order_employee_id'].'</td>
											<td>'.$row['order_employee_name'].'</td>
											<td>'.$row['order_no'].'</td>
											<td>'.($row['net_total_tp']) .'</td>
											<td>'.($row['net_total_vat']) .'</td>
											<td>'.($row['net_total_tp']*1+$row['net_total_vat']*1) .'</td>
											<td>'.$row['payable_amt'].'</td>
											<td>'.$row['pay'].'</td>
											<td >'.$pay.'</td>
											<td>'.$row['order_date'].'</td>
											<td>'.$row['delivery_date'].'</td>
										</tr>';
					$total_tp += $row['net_total_tp'];
					$total_vat += $row['net_total_vat'];
					$total_tp_vat += ($row['net_total_tp']*1+$row['net_total_vat']*1);
					$total_payable += $row['payable_amt'];
					$total_pay += $row['pay'];
					$total_due += $row['due'];
				 }
				//  end of inner if statement where date is compared
			 }
			//  end of while loop
		 }

		if ($i == 0) {
			 $sales_dues_tbl .= '<tr>
									<td colspan="14"  align="center" style="color:red">No Order Found</td>
								</tr>';
			 
			}else{
				$sales_dues_tbl .= '<tr class="bg-success">
									<td colspan="4"  align="right" style="color:red">Total</td>
									<td colspan=""  align="left" style="color:red">'.$total_tp.'</td>
									<td colspan=""  align="left" style="color:red">'.$total_vat.'</td>
									<td colspan=""  align="left" style="color:red">'.$total_tp_vat.'</td>
									<td colspan=""  align="left" style="color:red">'.$total_payable.'</td>
									<td colspan=""  align="left" style="color:red">'.$total_pay.'</td>
									<td colspan="3"  align="left" style="color:red">'.$total_due.'</td>
								</tr>';
			}
			$sales_dues_tbl .= '  </tbody>
			</table>';
		 $sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
                
		 </div>';
		 echo json_encode($sales_dues_tbl);
		 
	 }else if ($report_type == 'area_wise_customer') {
		 $query = "SELECT * FROM client WHERE area_name = '$area' ";
		 $get_cust = $dbOb->select($query);
		
		//  die($report_type);
		$sales_dues_tbl = '<div  id="print_table" style="color:black">
						<span class="text-center">
							<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
							<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
							
							
					</span>
					<div class="text-center">
						<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>AREA WISE CUSTOMERS</b></h4>
					</div>
					<br>
						<table class="table table-responsive">
							<tbody>
								<tr>
									<td class="text-left">
									<h4 style="margin:0px ; margin-top: -8px;"><B>Area : <span></span>'.$area.'</span></B></h4>
									</td>
									<td class="text-center">
										
									</td>
									<td class="text-right">
										<h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span></span>'.$printing_date.'</span></h5>
										<h5 style="margin:0px ; margin-top: -8px;">Time : <span></span>'.$printing_time.'</span></h5>
									</td>
								</tr>
							
							</tbody>
						</table>
					<!--     
					<hr> -->
					<table class="table table-bordered table-responsive">
										<thead style="background:#4CAF50; color:white" >
										<tr>
										<th scope="col">SL No</th>
										<th scope="col">ID</th>
										<th scope="col">Name</th>
										<th scope="col">Shop Name</th>
										<th scope="col">Address</th>
										<th scope="col">Mobile No</th>
										<th scope="col">Email</th>
									</tr>
										</thead>
										<tbody>';
										
		$i = 0;					
		if ($get_cust) {
			// die('sohag');
			while ($row = $get_cust->fetch_assoc()) {
				$sales_dues_tbl .= ' <tr align="left" style="color:black">
										<td>'.++$i.'</td>
										<td>'.$row['cust_id'].'</td>
										<td>'.$row['client_name'].'</td>
										<td>'.$row['organization_name'].'</td>
										<td>'.$row['address'] .'</td>
										<td>'.$row['mobile_no'] .'</td>
										<td>'.$row['email'].'</td>
									</tr>';

			}
		}
		if ($i==0) {
			$sales_dues_tbl .= ' <tr align="left" style="color:black">
									<td class="text-center text-danger" colspan="7">No Customer Found In This Area</td>
								</tr>';
		}
		$sales_dues_tbl .= '  </tbody>
			</table>';
		 $sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
                
		 </div>';
		 echo json_encode($sales_dues_tbl);
	 }
 
 	
}
 ?>