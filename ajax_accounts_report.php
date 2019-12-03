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
	
 	$from_date = strtotime($_POST['from_date']);
	 $to_date = strtotime($_POST['to_date']);
	 
	 $from_date_show = $_POST['from_date'];
	 $to_date_show = $_POST['to_date'];
	 $report_type = $_POST['report_type'];
	// echo json_encode($from_date);
		// 				die();
	 $print_table = 'print_table';
	 $printing_date = date('d F, Y');
	 $printing_time = date('h:i:s A');

		$company_profile = '';
		$query = "SELECT * FROM profile";
		$get_profile = $dbOb->select($query);
		if ($get_profile) {
			$company_profile = $get_profile->fetch_assoc();
			// die('sohag');
		}
		if ($from_date_show == $to_date_show) {
			$show_date = 'Report Date :'.$from_date_show ;
		}else{
			$show_date = 'Report Date : '.$from_date_show.' <span class="badge bg-red"> TO </span> '.$to_date_show;
		}

 	if ($report_type == 'Receive From Customer') {
		$total_delivery = 0;
		// $product_delivery = [];
		$query = "SELECT * FROM delivered_order_payment_history";
		$get_order_delivery = $dbOb->select($query);

		$receive_from_cust_tbl = '<div  id="print_table" style="color:black">
		<span class="text-center">
			<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			<h5>'.$show_date.'</h5>
			
	</span>
	<div class="text-center">
		<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>RECEIVE FROM CUSTOMER</b></h4>
	</div>
	<br>
		<table class="table table-responsive">
			<tbody>
				<tr>
					<td>
						
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
	<hr> -->';


 		$receive_from_cust_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">SL<br>No</th>
						      <th scope="col">Area</th>
						      <th scope="col">Customer Name</th>
						      <th scope="col">Shop Name</th>
						      <th scope="col">Mobile No</th>
						      <th scope="col">Receive<br>Amt (৳)</th>
						      <th scope="col">Receive<br>Date</th>
						    </tr>
						  </thead>
						  <tbody>';
	
		if ($get_order_delivery) {
			$i = 0;
			while ($row = $get_order_delivery->fetch_assoc()) {
				if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
					$order_serial_no = $row['deliver_order_serial_no'];
					$query="SELECT * FROM order_delivery WHERE serial_no = '$order_serial_no'";
					$get_order = $dbOb->select($query);
					if ($get_order) {
						$order = $get_order->fetch_assoc();
					}
					if ($row['pay_amt'] > 0) {
						$receive_from_cust_tbl .= '<tr style="color:black" align="left">
							  <td>'.++$i.'</td>
							  <td>'.$order['area'].'</td>
							  <td>'.$order['customer_name'].'</td>
							  <td>'.$order['shop_name'].'</td>
							  <td>'.$order['mobile_no'].'</td>
							  <td>'.$row['pay_amt'].'</td>
							  <td>'.$row['date'].'</td>
							 
							</tr>';
					$total_delivery = $total_delivery*1 + $row['pay_amt']*1;
					}
				}
			}
		}
		if ($i == 0) {
			$receive_from_cust_tbl .='<tr>
									<td colspan="7"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
			$receive_from_cust_tbl .='<tr style="color:red" class="bg-success" >
									<td colspan="5"  align="right" style="color:red">Total Amount</td>
									<td colspan="2" align="left" style="color:red">'.$total_delivery.'</td>
									
								</tr>';

		}
		

		$receive_from_cust_tbl.= '  </tbody>
		</table>';
		$receive_from_cust_tbl.= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
                
                </div>';
		echo json_encode($receive_from_cust_tbl);
		exit();

 	}elseif ($report_type == 'Pay To Company') {
 		$product = [];
 		$query = "SELECT * FROM product_stock WHERE company_product_return_id = '0'";
		 $get_product_stock = $dbOb->select($query);
		 
 		if ($get_product_stock) {
 				while ($row = $get_product_stock->fetch_assoc()) {
 					$stock_date = strtotime($row['stock_date']);
 					if ($stock_date >= $from_date && $stock_date <= $to_date) {
 						$product_id = $row['products_id_no'];
 						if(array_key_exists($product_id, $product))
				    	{
				    		$product[$product_id] +=   (int)$row['quantity'];
				    	}else{
				    		$product[$product_id] = (int)$row['quantity'];
			    		}
 					}
 				}
 		}

 		$company_payment = [];
 		foreach ($product as $key => $value) {
 			$query = "SELECT * FROM products WHERE products_id_no = '$key'";
 			$get_product_details = $dbOb->find($query);
 			$price = $get_product_details['company_price'];
 			$total_price = $price * $value;
 			$company_name = $get_product_details['company'];

			if(array_key_exists($company_name, $company_payment)) {
	    		$company_payment[$company_name] +=   (int)$total_price;
	    	}else{
	    		$company_payment[$company_name] = (int)$total_price;
    		}
 		}
 			$company_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PAY TO COMPANY</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';


 		$company_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Company Name</th>
						      <th scope="col">Pay Amount ( TAKA )</th>
						    </tr>
						  </thead>
						  <tbody>';
		  $i = 0;
		  $total_pay_comp = 0 ;
 		foreach ($company_payment as $key => $value) {
 			$company_tbl .= '<tr style="color:black" align="left">
						      <td>'.++$i.'</td>
						      <td>'.$key.'</td>
						      <td>'.$value.'</td>
							</tr>';
			$total_pay_comp += $value;
		 }
		 if ($i == 0) {
			$company_tbl .='<tr>
									<td colspan="3"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
		 $company_tbl .= '<tr style="color:red" align="left" class="bg-success">
						      <td colspan="2" class="text-right">Total Amount</td>
						      <td >'.$total_pay_comp.'</td>
							</tr>';
		}
 		$company_tbl .= '  </tbody>
						</table>';
		$company_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
                
		</div>';

		echo json_encode($company_tbl);
		exit();
 	
 	// the following section is for bank deposite calculation 	
 	}elseif ($report_type == 'Bank Deposit') {

 		$query = "SELECT * FROM bank_deposite";
 		$get_bank_deposite = $dbOb->select($query);

		 $i=0;

 		if ($get_bank_deposite) {
 			$deposite_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>BANK DEPOSIT</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';
 			$deposite_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
								<th scope="col">Serial No</th>
								<th scope="col">Bank Name</th>
								<th scope="col">Branch Name</th>
								<th scope="col">Account No</th>
								<th scope="col">Acc Holder Name</th>
								<th scope="col">Amount</th>
								<th scope="col">Date</th>
						    </tr>
						  </thead>
						  <tbody>';
			
			$total_deposite_amount = 0 ;
 			while ($row = $get_bank_deposite->fetch_assoc()) {
 				if (strtotime($row['deposite_date']) >= $from_date && strtotime($row['deposite_date']) <= $to_date) {
 					$deposite_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$row['bank_name'].'</td>
								      <td>'.$row['branch_name'].'</td>
								      <td>'.$row['bank_account_no'].'</td>
								      <td>'.$row['account_holder_name'].'</td>
								      <td>'.$row['amount'].'</td>
								      <td>'.$row['deposite_date'].'</td>
								    </tr>';
					$total_deposite_amount += $row['amount'];
 				}
 			}

 			

				}
				if ($i == 0) {
					$deposite_tbl .='<tr>
											<td colspan="7"  align="center" style="color:red">No Record Found</td>
										</tr>';
				}else{
					$deposite_tbl .='<tr class="bg-success">
								      <td colspan="5"  align="right" style="color:red">Total Amount</td>
								      <td colspan="2" align="left" style="color:red">'.$total_deposite_amount.'</td>
								      
								    </tr>';
				}
								$deposite_tbl.= '  </tbody>
										  </table>';
							   $deposite_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
								  
							   </div>';
				  
										  echo json_encode($deposite_tbl);
										  exit();
 		
 	}elseif ($report_type == 'Bank Withdraw') {
 		
 		$query = "SELECT * FROM bank_withdraw";
		 $get_bank_withdraw = $dbOb->select($query);
		 
		 $i=0;

 		if ($get_bank_withdraw) {
			 $withdraw_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>BANK WITHDRAW</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';
 			$withdraw_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
								<th scope="col">Serial No</th>
								<th scope="col">Bank Name</th>
								<th scope="col">Branch Name</th>
								<th scope="col">Account No</th>
								<th scope="col">Cheque No</th>
								<th scope="col">Receiver Name</th>
								<th scope="col">Amount</th>
								<th scope="col">Date</th>
						    </tr>
						  </thead>
						  <tbody>';
			
			$total_withdraw_amount = 0 ;
 			while ($row = $get_bank_withdraw->fetch_assoc()) {
 				if (strtotime($row['cheque_active_date']) >= $from_date && strtotime($row['cheque_active_date']) <= $to_date) {
 					$withdraw_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$row['bank_name'].'</td>
								      <td>'.$row['branch_name'].'</td>
								      <td>'.$row['bank_account_no'].'</td>
								      <td>'.$row['cheque_no'].'</td>
								      <td>'.$row['receiver_name'].'</td>
								      <td>'.$row['amount'].'</td>
								      <td>'.$row['cheque_active_date'].'</td>
								    </tr>';
					$total_withdraw_amount += $row['amount'];
 				}
 			}
							
			}
			if ($i == 0) {
				$withdraw_tbl .='<tr>
										<td colspan="8"  align="center" style="color:red">No Record Found</td>
									</tr>';
			}else{
				$withdraw_tbl .='<tr class="bg-success">
						      <td colspan="6"  align="right" style="color:red">Total Amount</td>
						      <td colspan="2" align="left" style="color:red">'.$total_withdraw_amount.'</td>
						      
						    </tr>';
			}
			$withdraw_tbl.= '  </tbody>
						</table>';
			$withdraw_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
				
			</div>';

						echo json_encode($withdraw_tbl);
						exit();
 	
 	// the following section is for calculation of bank loan
 	}elseif ($report_type == 'Bank Loan') {
 		$query = "SELECT * FROM bank_loan ORDER BY serial_no DESC";
		 $get_loan = $dbOb->select($query);
		 $i=0;
 		if ($get_loan) {
 			$loan_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>BANK LOAN</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';

 			$loan_tbl .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								     <tr>
						                <th style="text-align: center;">Sl No.</th>
						                <th style="text-align: center;">Bank Name</th>
						                <th style="text-align: center;">Branch Name</th>
						                <th style="text-align: center;">Installment <br> Amount</th>
						                <th style="text-align: center;">Total Loan <br> Amount</th>
						                <th style="text-align: center;">Total Pay <br> Amount</th>
						                <th style="text-align: center;">Due <br> Amount</th>
						                <th style="text-align: center;">Pay Status</th>
						                <th style="text-align: center;">Loan Taken <br> Date</th>
						                <th style="text-align: center;">Installment <br> Date</th>
						                <th style="text-align: center;">Action</th>
						              </tr>
						            </thead>
								  <tbody>';
 			while ($row = $get_loan->fetch_assoc()) {
 				// $total_pay = 0;
 				// $total_due = 0;
 				if (strtotime($row['loan_taken_date']) >= $from_date && strtotime($row['loan_taken_date']) <= $to_date) {
 					$bank_loan_id = $row['serial_no'];
 					 $pay_query = "SELECT * FROM bank_loan_pay WHERE bank_loan_id = '$bank_loan_id'";
                    $pay_data = $dbOb->select($pay_query);
                    if ($pay_data) {
                      $total_pay = 0;
                      while ($pay_row = $pay_data->fetch_assoc()) {
                        $total_pay += $pay_row['pay_amt'];
                      }
                      $due = $row['total_amount'] - $total_pay;
                    }else{
                      $total_pay = 0;
                       $due = $row['total_amount'];
                    }

                    if ($due > 0) {
                    	$pay_status = '<span class="badge bg-red">UNPAID</span>';
                    }else{
                    	$pay_status = '<span class="badge bg-green">PAID</span>';

                    }

 					 $loan_tbl .='<tr  style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$row['bank_name'].'</td>
								      <td>'.$row['branch_name'].'</td>
								      <td>'.$row['installment_amount'].'</td>
								      <td>'.$row['total_amount'].'</td>
								      <td>'.$total_pay.'</td>
								      <td>'.$due.'</td>
								      <td>'.$pay_status.'</td>
								      <td>'.$row['loan_taken_date'].'</td>
								      <td>'.$row['installment_date'].'</td>
				 					  <td>
				 					  	<a  class="badge  bg-green view_data" id="'.$row['serial_no'].'"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View Pay Info</a>
				 					  </td>

								 </tr>';
 					
 				}
 			}
 			
			 if ($i == 0) {
				$loan_tbl .='<tr>
										<td colspan="11"  align="center" style="color:red">No Record Found</td>
									</tr>';
			}
		}
		$loan_tbl.= '  </tbody>
				  </table>';
	  $loan_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
		  
	  </div>';
 		echo json_encode($loan_tbl);
 	}elseif ($report_type == 'Buy Invoice') {
 		//$query = "SELECT * FROM invoice_details WHERE invoice_option = 'Buy Invoice'";
 		$query = "SELECT * FROM invoice_details where invoice_option = 'Buy Invoice'";
 		$get_buy_invoice = $dbOb->select($query);
 		$total_buy_invoice_amount = 0;
 		$total_buy_invoice_pay = 0;
 		$total_buy_invoice_due = 0;
 		$i = 0;

 		if ($get_buy_invoice) {
 			
 			$buy_invoice_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>BUY INVOICE</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';

 			$buy_invoice_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
								<th scope="col">Sl No</th>
								<th scope="col">Organization</th>
								<th scope="col">Bank/Client Name</th>
								<th scope="col">Branch/Address</th>
								<th scope="col">Account/Phone no</th>
								<th scope="col">Amount</th>
								<th scope="col">Pay</th>
								<th scope="col">Due</th>
								<th scope="col">Date</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_buy_invoice->fetch_assoc()) {

 			
 					
 				if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {

 					if ($row['client_option'] == 'New Client') {
						$Organization = $row['new_organization_name'];
						$bank_client_name  = $row['new_client_name'];
						$branch_address  = $row['new_address'];
						$account_phn  = $row['new_phone_no'];
 					}else{
						$Organization = $row['office_organization_name'];
						$bank_client_name  = $row['office_bank_name'];
						$branch_address  = $row['office_branch_name'];
						$account_phn  = $row['office_account_no'];
 					}

 					$buy_invoice_tbl .='<tr style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$Organization.'</td>
								      <td>'.$bank_client_name.'</td>
								      <td>'.$branch_address.'</td>
								      <td>'.$account_phn.'</td>
								      <td>'.$row['grand_total'].'</td>
								      <td>'.$row['pay'].'</td>
								      <td>'.$row['due'].'</td>
								      <td>'.$row['invoice_date'].'</td>
								    </tr>';
					$total_buy_invoice_amount += $row['grand_total'];
					$total_buy_invoice_pay += $row['pay'];
					$total_buy_invoice_due += $row['due'];
 					
 				}
 			}
							
			}
			if ($i == 0) {
				$buy_invoice_tbl .='<tr>
										<td colspan="11"  align="center" style="color:red">No Record Found</td>
									</tr>';
			}else{
				$buy_invoice_tbl .='<tr class="bg-success">
				<td colspan="5"  align="right" style="color:red">Total Amount</td>
				<td style="color:red; text-align:left">'.$total_buy_invoice_amount.'</td>
				<td style="color:red; text-align:left">'.$total_buy_invoice_pay.'</td>
				<td colspan="2" style="color:red; text-align:left">'.$total_buy_invoice_due.'</td>
				
				</tr>';
			}
			$buy_invoice_tbl.= '  </tbody>
						</table>';
			$buy_invoice_tbl.='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
				
			</div>';
 		echo json_encode($buy_invoice_tbl);
						die();
 	}elseif ($report_type == 'Sell Invoice') {
 		$query = "SELECT * FROM invoice_details WHERE invoice_option = 'Sell Invoice'";
 		$get_sell_invoice = $dbOb->select($query);
 		$total_sell_invoice_amount = 0;
 		$total_sell_invoice_pay = 0;
 		$total_sell_invoice_due = 0;

 		$i = 0;

 		if ($get_sell_invoice) {
 			$sell_invoice_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>SELL INVOICE</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';
 			$sell_invoice_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
								<th scope="col">Sl No</th>
								<th scope="col">Organization</th>
								<th scope="col">Bank/Client Name</th>
								<th scope="col">Branch/Address</th>
								<th scope="col">Account/Phone no</th>
								<th scope="col">Amount</th>
								<th scope="col">Pay</th>
								<th scope="col">Due</th>
								<th scope="col">Date</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_sell_invoice->fetch_assoc()) {
 				if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {

 					if ($row['client_option'] == 'New Client') {
						$Organization = $row['new_organization_name'];
						$bank_client_name  = $row['new_client_name'];
						$branch_address  = $row['new_address'];
						$account_phn  = $row['new_phone_no'];
 					}else{
						$Organization = $row['office_organization_name'];
						$bank_client_name  = $row['office_bank_name'];
						$branch_address  = $row['office_branch_name'];
						$account_phn  = $row['office_account_no'];
 					}

 					$sell_invoice_tbl .='<tr  style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$Organization.'</td>
								      <td>'.$bank_client_name.'</td>
								      <td>'.$branch_address.'</td>
								      <td>'.$account_phn.'</td>
								      <td>'.$row['grand_total'].'</td>
								      <td>'.$row['pay'].'</td>
								      <td>'.$row['due'].'</td>
								      <td>'.$row['invoice_date'].'</td>
								    </tr>';
					$total_sell_invoice_amount += $row['grand_total'];
					$total_sell_invoice_pay += $row['pay'];
					$total_sell_invoice_due += $row['due'];
 					
 				}
 			}
 			//
		}
		if ($i == 0) {
			$sell_invoice_tbl .='<tr>
									<td colspan="11"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
			$sell_invoice_tbl .='<tr class="bg-success">
							<td colspan="5"  align="right" style="color:red">Total Amount</td>
							<td style="color:red; text-align:left">'.$total_sell_invoice_amount.'</td>
							<td style="color:red; text-align:left">'.$total_sell_invoice_pay.'</td>
							<td colspan="2" style="color:red; text-align:left" >'.$total_sell_invoice_due.'</td>
							
						</tr>';
		}

		 $sell_invoice_tbl.= '  </tbody>
				   </table>';
	   $sell_invoice_tbl.='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
		   
	   </div>';

				   echo json_encode($sell_invoice_tbl);
				   exit();
 	}elseif ($report_type == 'All Invoice') {
 		
 		$query = "SELECT * FROM invoice_details ORDER BY invoice_option DESC";
 		$get_sell_invoice = $dbOb->select($query);
 		$total_sell_invoice_amount = 0;
 		$total_sell_invoice_pay = 0;
 		$total_sell_invoice_due = 0;

 		$total_buy_invoice_amount = 0;
 		$total_buy_invoice_pay = 0;
 		$total_buy_invoice_due = 0;

 		$i = 0;
 		$k=0;

 		if ($get_sell_invoice) {
 			$sell_invoice_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>BUY & SELL INVOICE</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';

 			$sell_invoice_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
								<th scope="col">Sl No</th>
								<th scope="col">Invoice Type</th>
								<th scope="col">Organization</th>
								<th scope="col">Bank/Client Name</th>
								<th scope="col">Branch/Address</th>
								<th scope="col">Account/Phone no</th>
								<th scope="col">Amount</th>
								<th scope="col">Pay</th>
								<th scope="col">Due</th>
								<th scope="col">Date</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_sell_invoice->fetch_assoc()) {
 				if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {

 					if ($row['client_option'] == 'New Client') {
						$Organization = $row['new_organization_name'];
						$bank_client_name  = $row['new_client_name'];
						$branch_address  = $row['new_address'];
						$account_phn  = $row['new_phone_no'];
 					}else{
						$Organization = $row['office_organization_name'];
						$bank_client_name  = $row['office_bank_name'];
						$branch_address  = $row['office_branch_name'];
						$account_phn  = $row['office_account_no'];
 					}

 					if ($row['invoice_option'] == 'Buy Invoice') {
 						$inv_option ='<span  class="badge bg-red">'.$row['invoice_option'].'</span>';
 						$total_buy_invoice_amount += $row['grand_total'];
						$total_buy_invoice_pay += $row['pay'];
						$total_buy_invoice_due += $row['due'];
 					}else{
 						$inv_option ='<span class="badge bg-green">'.$row['invoice_option'].'</span>';
 						$total_sell_invoice_amount += $row['grand_total'];
						$total_sell_invoice_pay += $row['pay'];
						$total_sell_invoice_due += $row['due'];
 					}
 					
 					
 					if ($k==0) {
 						if ($row['invoice_option'] == 'Buy Invoice') {
 							$sell_invoice_tbl .='<tr>
						      <td colspan="6"  align="right" style="color:red">Total Sell Invoice Amount</td>
						      <td style="color:red; text-align:left">'.$total_sell_invoice_amount.'</td>
						      <td style="color:red; text-align:left">'.$total_sell_invoice_pay.'</td>
						      <td colspan="2" style="color:red; text-align:left">'.$total_sell_invoice_due.'</td>
						      
						    </tr>';
						    $k++;
 						}
 					}

 					$sell_invoice_tbl .='<tr  style="color:black" align="left">
								      <td>'.++$i.'</td>
								      <td>'.$inv_option.'</td>
								      <td>'.$Organization.'</td>
								      <td>'.$bank_client_name.'</td>
								      <td>'.$branch_address.'</td>
								      <td>'.$account_phn.'</td>
								      <td>'.$row['grand_total'].'</td>
								      <td>'.$row['pay'].'</td>
								      <td>'.$row['due'].'</td>
								      <td>'.$row['invoice_date'].'</td>
								    </tr>';

 				}
 			}
 			//
		}
		if ($i == 0) {
			$sell_invoice_tbl .='<tr>
									<td colspan="11"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
			$sell_invoice_tbl .='<tr class="bg-success">
						 <td colspan="6"  align="right" style="color:red">Total Buy Invoice Amount</td>
						 <td style="color:red; text-align:left">'.$total_buy_invoice_amount.'</td>
						 <td style="color:red; text-align:left">'.$total_buy_invoice_pay.'</td>
						 <td colspan="2" style="color:red; text-align:left">'.$total_buy_invoice_due.'</td>
						 
					   </tr>';
		}

		 $sell_invoice_tbl.= '  </tbody>
				   </table>';
	   $sell_invoice_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
		   
	   </div>';

				   echo json_encode($sell_invoice_tbl);
				   exit();
 	}elseif ($report_type == 'Company Commission') {
 		


		$total_company_commission = 0;
		$company_commission = [];
		$i = 0;
		$query = "SELECT * FROM company_commission";
		$get_company_comission = $dbOb->select($query);

		if ($get_company_comission) {
 			$company_comission_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>COMPANY COMMISSION</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';

			$company_comission_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
									<th scope="col">Sl No</th>
									<th scope="col">Company</th>
									<th scope="col">Month</th>
									<th scope="col">Target</th>
									<th scope="col">Sell Amount</th>
									<th scope="col">Comission (%)</th>
									<th scope="col">Comission ( Taka )</th>
									<th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>';
			while ($row = $get_company_comission->fetch_assoc()) {
				
				if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {

					if ($row['target_product'] <= $row['target_sell_amount']) {

						$target = $row['target_sell_amount'];
						$comission_persent = $row['comission_persent'];

						$comission_amount = (int)$target * (int)$comission_persent / 100 ;

						// $comission = (int)$target + (int)$comission_amount;

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


					 $company_comission_tbl .='<tr style="color:black" align="left">
											      <td>'.++$i.'</td>
											      <td>'.$row['company'].'</td>
											      <td>'.$month_name.'</td>
											      <td>'.$row['target_product'].'</td>
											      <td>'.$row['target_sell_amount'].'</td>
											      <td>'.$row['comission_persent'].'</td>
											      <td>'.$comission_amount.'</td>
											      <td>'.$row['date'].'</td>
											    </tr>';

						$total_company_commission = (int)$total_company_commission + (int)$comission_amount;
					}

				}
			}

		}
		if ($i == 0) {
			$company_comission_tbl .='<tr>
									<td colspan="11"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
		$company_comission_tbl .='<tr class="bg-success">
						 <td colspan="6"  align="right" style="color:red">Total Amount</td>
						 <td colspan="2" style="color:red; text-align:left">'.$total_company_commission.'</td>
						 
					   </tr>';
		}

		 $company_comission_tbl.= '  </tbody>
				   </table>';
	   $company_comission_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
	   
	   </div>';

				   echo json_encode($company_comission_tbl);
				   exit();
 	}elseif ($report_type == 'Employee Commission') {
 		$total_employee_commission = 0;
		$query = "SELECT * FROM employee_commission";
		$get_employee_commission = $dbOb->select($query);
		$i = 0;

		if ($get_employee_commission) {
 			$employee_comission_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>EMPLOYEE COMMISSION</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';

			$employee_comission_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
									<th scope="col">Sl No</th>
									<th scope="col">ID</th>
									<th scope="col">Name</th>
									<th scope="col">Designation</th>
									<th scope="col">Month</th>
									<th scope="col">Target</th>
									<th scope="col">Sell Amount</th>
									<th scope="col">Comission (%)</th>
									<th scope="col">Comission ( Taka )</th>
									<th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>';
			while ($row = $get_employee_commission->fetch_assoc()) {
				
				if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {

					if ($row['sell_target'] <= $row['total_sell_amount']) {
						$target = $row['total_sell_amount'];
						$comission_persent = $row['comission_persent'];
						$extra_sell = $row['total_sell_amount'] -  $row['sell_target'] ;
						$comission_amount = (int)$extra_sell * (int)$comission_persent / 100 ;





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


						 $employee_comission_tbl .='<tr  style="color:black" align="left">
												      <td>'.++$i.'</td>
												      <td>'.$row['id_no'].'</td>
												      <td>'.$row['name'].'</td>
												      <td>'.$row['designation'].'</td>
												      <td>'.$month_name.'</td>
												      <td>'.$row['sell_target'].'</td>
												      <td>'.$row['total_sell_amount'].'</td>
												      <td>'.$row['comission_persent'].'</td>
												      <td>'.$comission_amount.'</td>
												      <td>'.$row['date'].'</td>
												    </tr>';

						$total_employee_commission = (int)$total_employee_commission + (int)$comission_amount;
					}

				}
			}

		}
		if ($i == 0) {
			$employee_comission_tbl .='<tr>
									<td colspan="11"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
			$employee_comission_tbl .='<tr class="bg-success">
								<td colspan="8"  align="right" style="color:red">Total Amount</td>
								<td colspan="2" style="color:red; text-align:left">'.$total_employee_commission.'</td>
								
								</tr>';
		}

			  $employee_comission_tbl.= '  </tbody> </table>';
			  $employee_comission_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
			
			  </div>';

						echo json_encode($employee_comission_tbl);
						exit();
 	}elseif ($report_type == 'Balance Sheet/Cash Balance') {
 		//////////////////////////////////////////
 	}elseif ($report_type == 'Employee Payment') {

 		$i = 0;
 		$total_salary_payment = 0;
		$query = "SELECT * FROM employee_payments";
		$get_salary_payment = $dbOb->select($query);

		if ($get_salary_payment) {
 			$employee_pay_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>EMPLOYEE PAYMENTS</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td>
							 
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
		 <hr> -->';

			$employee_pay_tbl .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								    <tr>
										<th scope="col">Sl No</th>
										<th scope="col">ID</th>
										<th scope="col">Name</th>
										<th scope="col">Designation</th>
										<th scope="col">Month</th>
										<th scope="col">Salary</th>
										<th scope="col">Total Paid Salary</th>
										<th scope="col">Date</th>
								    </tr>
								  </thead>
								  <tbody>';
			while ($row = $get_salary_payment->fetch_assoc()) {
				if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {


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

					 $employee_pay_tbl .='<tr style="color:black" align="left">
										      <td>'.++$i.'</td>
										      <td>'.$row['id_no'].'</td>
										      <td>'.$row['name'].'</td>
										      <td>'.$row['designation'].'</td>
										      <td>'.$month_name.'</td>
										      <td>'.$row['total_salary'].'</td>
										      <td>'.$row['salary_paid'].'</td>
										      <td>'.$row['date'].'</td>
										 </tr>';

					$total_salary_payment = (int)$total_salary_payment + (int)$row['salary_paid'];

				}
			}

		}
		if ($i == 0) {
			$employee_pay_tbl .='<tr>
									<td colspan="11"  align="center" style="color:red">No Record Found</td>
								</tr>';
		}else{
			$employee_pay_tbl .='<tr class="bg-success">
									<td colspan="6"  align="right" style="color:red">Total Amount</td>
									<td colspan="2" style="color:red;text-align:left">'.$total_salary_payment.'</td>
									
								</tr>';
		}
		
					  $employee_pay_tbl.= '  </tbody>
								</table>';
					 $employee_pay_tbl .='</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
						
					 </div>';
		
					echo json_encode($employee_pay_tbl);
					exit();

 	}

	}
 ?>