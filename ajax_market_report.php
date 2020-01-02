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
	
 	$from_date = strtotime($_POST['from_date']);
 	$from_date_show = $_POST['from_date'];
 	$to_date = strtotime($_POST['to_date']);
 	$to_date_show = $_POST['to_date'];
 	$report_type = validation($_POST['report_type']);
 	$area = $_POST['area'];
	 $employee_type = validation($_POST['employee_type']);
	 
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


 	if ($report_type == 'Orders') {
 		$query = "SELECT * FROM new_order_details ORDER BY serial_no DESC";
 		$get_orders = $dbOb->select($query);
 		if ($get_orders) {
			 $j=0;
			 $i=0;

 			$order_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>ALL ORDER LIST</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							
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

 			$order_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Sales Man</th>
						      <th scope="col">Area Name</th>
						      <th scope="col">Shop</th>
						      <th scope="col">Payable</th>
						      <th scope="col">Status</th>
						      <th scope="col">Date</th>
						      <th scope="col">Product Name</th>
						      <th scope="col">Qty</th>
						    </tr>
						  </thead>
						  <tbody>';
			$total_items = $get_orders ->num_rows;
			while ($row = $get_orders->fetch_assoc()) {
				$j++;
				if (strtotime($row['order_date']) >= $from_date && strtotime($row['order_date']) <= $to_date){

 					$id = $row['serial_no'];
 					$query = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$id'";
		      		$get_product = $dbOb->select($query);
		      		$total_row = $get_product->num_rows + 1 ;

		      		$status = '';
		      		if ($row['delivery_report'] == '1') {
		      			$status = 'Delivered';
		      			$color = 'bg-green';
		      		}else if($row['delivery_cancel_report'] == '1'){
		      			$status = 'Cancelled';
		      			$color = 'bg-red';

		      		}else if($row['delivery_report'] == '0' && $row['delivery_cancel_report'] == '0'){
		      			$status = 'Pending';
		      			$color = 'bg-orange';

		      		}

 					$order_tbl .= '<tr align="left" style="color:black">
									      <td  rowspan="'.$total_row.'" >'.++$i.'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['employee_id'].'<br>'.$row['employee_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['area_employee'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['shop_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['payable_amt'].'</td>
									      <td  rowspan="'.$total_row.'" ><span class="badge '.$color.' ">'.$status.'</span></td>
									      <td  rowspan="'.$total_row.'" >'.$row['order_date'].'</td>
								</tr>';

					      	if ($j == $total_items) {
					      			$display = 'none';
					      		}
					      		
					      		if ($get_product) {
					      				while ($res = $get_product->fetch_assoc()) {
					      					
					      				$order_tbl .='<tr align="left" style="color:black"><td>'.$res['products_name'].'</td>';
					      				 $order_tbl .='<td>'.$res['quantity'].'</td>';
					      						
					      				}

					      				$order_tbl .='<tr style="display:'.$display.'"> <td colspan="9"></td></tr>';
					      		}


					$order_tbl .=' </tr>';
					
 					
 				}
			}
			
		 }
		 if ($i == 0) {
			$order_tbl .=' <tr><td  class="text-center" style="color:red" colspan="9">No Order Found</td></tr>';
		}
		 $order_tbl .= '  </tbody> </table></div>
									<div class="mt-3">
														<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
														</div>';
 		echo json_encode($order_tbl);
 	}elseif ($report_type == 'Delivery') {
 		$query = "SELECT * FROM order_delivery ORDER BY serial_no DESC";
 		$get_orders = $dbOb->select($query);
 		if ($get_orders) {
			 $j=0;
			 $i=0;

 			$order_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>DELIVERED ORDER LIST</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							
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

 			$order_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Delivery Employee Name</th>
						      <th scope="col">Area Name</th>
						      <th scope="col">Shop</th>
						      <th scope="col">Amount</th>
						      <th scope="col">Pay</th>
						      <th scope="col">Due</th>
						      <th scope="col">Date</th>
						      <th scope="col">Product Name</th>
						      <th scope="col">Qty</th>
						    </tr>
						  </thead>
						  <tbody>';
			$total_items = $get_orders ->num_rows;
			while ($row = $get_orders->fetch_assoc()) {
				$j++;
				if (strtotime($row['order_date']) >= $from_date && strtotime($row['order_date']) <= $to_date){

 					$id = $row['serial_no'];
 					$query = "SELECT * FROM order_delivery_expense WHERE delivery_tbl_serial_no = '$id'";
		      		$get_product = $dbOb->select($query);
		      		$total_row = $get_product->num_rows + 1 ;

	      			$status = 'Delivered';
	      			$color = 'bg-green';
		      		
 					$order_tbl .= '<tr align="left" style="color:black">
									      <td  rowspan="'.$total_row.'" >'.++$i.'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['delivery_employee_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['area'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['shop_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['payable_amt'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['pay'].'</td>
									      <td style="color:red" rowspan="'.$total_row.'" >'.$row['due'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['delivery_date'].'</td>
								</tr>';

					      	if ($j == $total_items) {
					      			$display = 'none';
					      		}
					      		
					      		if ($get_product) {
					      				while ($res = $get_product->fetch_assoc()) {
					      					
					      				$order_tbl .='<tr align="left" style="color:black"><td>'.$res['products_name'].'</td>';
					      				 $order_tbl .='<td>'.$res['quantity'].'</td>';
					      						
					      				}

					      				$order_tbl .='<tr style="display:'.$display.'"> <td colspan="10"></td></tr>';
					      		}


					$order_tbl .=' </tr>';
 					
 				}
			}
		 }
		 if ($i == 0) {
			$order_tbl .=' <tr><td  class="text-center" style="color:red" colspan="10">No Order Found</td></tr>';
		}
		 $order_tbl .='  </tbody> </table></div>
		 <div class="mt-3">
							 <a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
							 </div>';
 		echo json_encode($order_tbl);

 	}elseif ($report_type == 'Delivery_pending') { 
 		$query = "SELECT * FROM new_order_details WHERE delivery_report = '0' AND delivery_cancel_report = '0' ORDER BY serial_no DESC";
 		$get_orders = $dbOb->select($query);
 		if ($get_orders) {
			 $j=0;
			 $i=0;

 			$order_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PENDING ORDER LIST</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							
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


 			$order_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Order Employee Name</th>
						      <th scope="col">Area Name</th>
						      <th scope="col">Shop</th>
						      <th scope="col">Amount</th>
						      <th scope="col">Status</th>
						      <th scope="col">Date</th>
						      <th scope="col">Product Name</th>
						      <th scope="col">Qty</th>
						    </tr>
						  </thead>
						  <tbody>';
			$total_items = $get_orders ->num_rows;
			while ($row = $get_orders->fetch_assoc()) {
				$j++;
				if (strtotime($row['order_date']) >= $from_date && strtotime($row['order_date']) <= $to_date){

 					$id = $row['serial_no'];
 					$query = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$id'";
		      		$get_product = $dbOb->select($query);
		      		$total_row = $get_product->num_rows + 1 ;

		      		$status = '';
		      		if ($row['delivery_report'] == '1') {
		      			$status = 'Delivered';
		      			$color = 'bg-green';
		      		}else if($row['delivery_cancel_report'] == '1'){
		      			$status = 'Cancelled';
		      			$color = 'bg-red';

		      		}else if($row['delivery_report'] == '0' && $row['delivery_cancel_report'] == '0'){
		      			$status = 'Pending';
		      			$color = 'bg-orange';

		      		}

 					$order_tbl .= '<tr align="left" style="color:black">
									      <td  rowspan="'.$total_row.'" >'.++$i.'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['employee_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['area_employee'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['shop_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['payable_amt'].'</td>
									      <td  rowspan="'.$total_row.'" ><span class="badge '.$color.' ">'.$status.'</span></td>
									      <td  rowspan="'.$total_row.'" >'.$row['order_date'].'</td>
								</tr>';

					      	if ($j == $total_items) {
					      			$display = 'none';
					      		}
					      		
					      		if ($get_product) {
					      				while ($res = $get_product->fetch_assoc()) {
					      					
					      				$order_tbl .='<tr align="left" style="color:black"><td>'.$res['products_name'].'</td>';
					      				 $order_tbl .='<td>'.$res['quantity'].'</td>';
					      						
					      				}

					      				$order_tbl .='<tr style="display:'.$display.'"> <td colspan="9"></td></tr>';
					      		}


					$order_tbl .=' </tr>';
 					
 				}
			}
		 }
		 if ($i == 0) {
			$order_tbl .=' <tr><td  class="text-center" style="color:red" colspan="10">No Order Found</td></tr>';
		}
		 $order_tbl .= '  </tbody> </table></div>
				 <div class="mt-3">
									 <a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
									 </div>';
 		echo json_encode($order_tbl);
 	}elseif ($report_type == 'Delivery_cancelled') {
 		$query = "SELECT * FROM new_order_details WHERE delivery_cancel_report = '1' ORDER BY serial_no DESC";
 		$get_orders = $dbOb->select($query);
 		if ($get_orders) {
			 $j=0;
			 $i=0;
 			$order_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>CANCELLED ORDER LIST</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							
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

 			$order_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee Name</th>
						      <th scope="col">Area Name</th>
						      <th scope="col">Shop</th>
						      <th scope="col">Amount</th>
						      <th scope="col">Status</th>
						      <th scope="col">Date</th>
						      <th scope="col">Product Name</th>
						      <th scope="col">Qty</th>
						    </tr>
						  </thead>
						  <tbody>';

			$total_items = $get_orders ->num_rows;
			while ($row = $get_orders->fetch_assoc()) {
				$j++;
				if (strtotime($row['order_date']) >= $from_date && strtotime($row['order_date']) <= $to_date){

 					$id = $row['serial_no'];
 					$query = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$id'";
		      		$get_product = $dbOb->select($query);
		      		$total_row = $get_product->num_rows + 1 ;

		      		$status = '';
		      		if ($row['delivery_report'] == '1') {
		      			$status = 'Delivered';
		      			$color = 'bg-green';
		      		}else if($row['delivery_cancel_report'] == '1'){
		      			$status = 'Cancelled';
		      			$color = 'bg-red';

		      		}else if($row['delivery_report'] == '0' && $row['delivery_cancel_report'] == '0'){
		      			$status = 'Pending';
		      			$color = 'bg-orange';

		      		}

 					$order_tbl .= '<tr align="left" style="color:black">
									      <td  rowspan="'.$total_row.'" >'.++$i.'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['employee_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['area_employee'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['shop_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['payable_amt'].'</td>
									      <td  rowspan="'.$total_row.'" ><span class="badge '.$color.' ">'.$status.'</span></td>
									      <td  rowspan="'.$total_row.'" >'.$row['order_date'].'</td>
								</tr>';

					      	if ($j == $total_items) {
					      			$display = 'none';
					      		}
					      		
					      		if ($get_product) {
					      				while ($res = $get_product->fetch_assoc()) {
					      					
					      				$order_tbl .='<tr align="left" style="color:black"><td>'.$res['products_name'].'</td>';
					      				 $order_tbl .='<td>'.$res['quantity'].'</td>';
					      						
					      				}

					      				$order_tbl .='<tr style="display:'.$display.'"> <td colspan="9"></td></tr>';
					      		}


					$order_tbl .=' </tr>';
 					
 				}
			}
		 }
		 if ($i == 0) {
			$order_tbl .=' <tr><td  class="text-center" style="color:red" colspan="10">No Order Found</td></tr>';
		}
		 $order_tbl .='  </tbody> </table></div>
		 <div class="mt-3">
							 <a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
							 </div>';
 		echo json_encode($order_tbl);
 	}elseif ($report_type == 'return_from_customer') {
		$query = "SELECT * FROM market_products_return";
			 $get_return = $dbOb->select($query);
			 $i=0;
	 		if ($get_return) {
	 			$return_market_tbl = '<div  id="print_table" style="color:black">
				 <span class="text-center">
					 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
					 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
					 <h5>'.$show_date.'</h5>
					 
			 </span>
			 <div class="text-center">
				 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PRODUCTS RETURNED FROM CUSTOMER</b></h4>
			 </div>
			 <br>
				 <table class="table table-responsive">
					 <tbody>
						 <tr>
							 <td class="text-LEFT">
								
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

	 			$return_market_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">SL No</th>
							      <th scope="col">Returned By</th>
							      <th scope="col">Area</th>
							      <th scope="col">Shop Name</th>
							      <th scope="col">Reason</th>
							      <th scope="col">Product Name</th>
							      <th scope="col">Return Qty</th>
							      <th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>';

				  $i = 0;
				  $total_return = 0;

	 				while ($row = $get_return->fetch_assoc()) {
	 					$return_date = strtotime($row['return_date']);
	 					if ($return_date >= $from_date && $return_date <= $to_date) {
	 						$product_id = $row['products_id_no'];
	 						// $quantity = (int)$row['return_quantity'];

				 			$return_market_tbl .= '<tr align="left" style="color:black">
										      <td>'.++$i.'</td>
										      <td>'.$row['employee_id_delivery'].'<br>'.$row['employee_name_delivery'].'</td>
										      <td>'.$row['area_employee_delivery'].'</td>
										      <td>'.$row['shop_name'].'</td>
										      <td>'.$row['return_reason'].'</td>
										      <td>'.$row['products_name'].'</td>
										      <td>'.$row['return_quantity'].'</td>
										      <td>'.$row['return_date'].'</td>
										    </tr>';
	 						$total_return += (int)$row['return_quantity'];
	 					}
					 }
					 if ($i == 0) {
						$return_market_tbl .=' <tr><td  class="text-center" style="color:red" colspan="10">No Order Found</td></tr>';
					}
	 				

			 		$return_market_tbl .= '  </tbody>
									</table>';
					$return_market_tbl .= '  </tbody> </table></div>
					<div class="mt-3">
										<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
										</div>';

					echo json_encode($return_market_tbl);
					exit();
		}
 	}elseif ($report_type == 'area_wise_employee') {
 		// echo json_encode($employee_type);
 		// die();
 		if ($area == 'all_area') {
 			if ($employee_type == 'sales_man') {
 				$query = "SELECT * FROM employee_duty order by active_status";
 				$get_sales_man = $dbOb->select($query);
 				if ($get_sales_man) {

		 			$sales_man_all_area = '<span align="center"><h3 style="color:red">Sales Man Of All Area</h3><hr>';

		 			$sales_man_all_area .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								    <tr>
								      <th scope="col">Serial No</th>
								      <th scope="col">Employee ID</th>
								      <th scope="col">Name</th>
								      <th scope="col">Area</th>
								      <th scope="col">Description</th>
								      <th scope="col">Status</th>
								    </tr>
								  </thead>
								  <tbody>';
	 					while ($row = $get_sales_man->fetch_assoc()) {
	 						if ($row['active_status'] == 'Active') {
	 							$status = "Active";
	 							$color = "bg-green";
	 						}else{

	 							$status = "Inactive";
	 							$color = "bg-red";
	 						}
	 						$sales_man_all_area .= '<tr align="left" style="color:black">
												      <td>'.++$i.'</td>
												      <td>'.$row['id_no'].'</td>
												      <td>'.$row['name'].'</td>
												      <td>'.$row['area'].'</td>
												      <td>'.$row['description'].'</td>
												      <td><span class="badge '.$color.'">'.$status.'</span></td>
												  </tr>';
	 						
	 					}
	 					$sales_man_all_area .= '  </tbody> </table>';
 				}
 				echo json_encode($sales_man_all_area);
 			}else if($employee_type == 'delivery_man'){ // if employee type is selected as delivery employee ie delivery man

 				$query = "SELECT * FROM delivery_employee order by active_status";
 				$get_delivery_man = $dbOb->select($query);
 				if ($get_delivery_man) {

		 			$delivery_man_all_area = '<span align="center"><h3 style="color:red">Delivery Man Of All Area</h3><hr>';

		 			$delivery_man_all_area .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								    <tr>
								      <th scope="col">Serial No</th>
								      <th scope="col">Employee ID</th>
								      <th scope="col">Name</th>
								      <th scope="col">Area</th>
								      <th scope="col">From</th>
								      <th scope="col">To</th>
								      <th scope="col">Status</th>
								    </tr>
								  </thead>
								  <tbody>';
	 					while ($row = $get_delivery_man->fetch_assoc()) {
	 						if ($row['active_status'] == 'Active') {
	 							$status = "Active";
	 							$color = "bg-green";
	 						}else{

	 							$status = "Inactive";
	 							$color = "bg-red";
	 						}
	 						$delivery_man_all_area .= '<tr align="left" style="color:black">
												      <td>'.++$i.'</td>
												      <td>'.$row['id_no'].'</td>
												      <td>'.$row['name'].'</td>
												      <td>'.$row['area'].'</td>
												      <td>'.$row['from_date'].'</td>
												      <td>'.$row['to_date'].'</td>
												      <td><span class="badge '.$color.'">'.$status.'</span></td>
												  </tr>';
	 						
	 					}
	 					$delivery_man_all_area .= '  </tbody> </table>';
 				}
 				echo json_encode($delivery_man_all_area);

 			}
 		}else{ // if others area except all area is selected then the following block of codes wil be exrcuted

 			if ($employee_type == 'sales_man') {
 				$query = "SELECT * FROM employee_duty WHERE area = '$area' order by active_status";
 				$get_sales_man = $dbOb->select($query);
 				if ($get_sales_man) {

		 			$sales_man_all_area = '<span align="center"><h3 style="color:red">Sales Man Of Area: '.$area.'</h3><hr>';

		 			$sales_man_all_area .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								    <tr>
								      <th scope="col">Serial No</th>
								      <th scope="col">Employee ID</th>
								      <th scope="col">Name</th>
								      <th scope="col">Area</th>
								      <th scope="col">Description</th>
								      <th scope="col">Status</th>
								    </tr>
								  </thead>
								  <tbody>';
	 					while ($row = $get_sales_man->fetch_assoc()) {
	 						if ($row['active_status'] == 'Active') {
	 							$status = "Active";
	 							$color = "bg-green";
	 						}else{

	 							$status = "Inactive";
	 							$color = "bg-red";
	 						}
	 						$sales_man_all_area .= '<tr align="left" style="color:black">
												      <td>'.++$i.'</td>
												      <td>'.$row['id_no'].'</td>
												      <td>'.$row['name'].'</td>
												      <td>'.$row['area'].'</td>
												      <td>'.$row['description'].'</td>
												      <td><span class="badge '.$color.'">'.$status.'</span></td>
												  </tr>';
	 						
	 					}
	 					$sales_man_all_area .= '  </tbody> </table>';
 				}
 				echo json_encode($sales_man_all_area);
 			}else if($employee_type=='delivery_man'){ // if employee type is selected as delivery employee ie delivery man

 				$query = "SELECT * FROM delivery_employee WHERE area = '$area' order by active_status";
 				$get_delivery_man = $dbOb->select($query);
 				if ($get_delivery_man) {

		 			$delivery_man_all_area = '<span align="center"><h3 style="color:red">Delivery Man Of Area: '.$area.'</h3><hr>';

		 			$delivery_man_all_area .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								    <tr>
								      <th scope="col">Serial No</th>
								      <th scope="col">Employee ID</th>
								      <th scope="col">Name</th>
								      <th scope="col">Area</th>
								      <th scope="col">From</th>
								      <th scope="col">To</th>
								      <th scope="col">Status</th>
								    </tr>
								  </thead>
								  <tbody>';
	 					while ($row = $get_delivery_man->fetch_assoc()) {
	 						if ($row['active_status'] == 'Active') {
	 							$status = "Active";
	 							$color = "bg-green";
	 						}else{

	 							$status = "Inactive";
	 							$color = "bg-red";
	 						}
	 						$delivery_man_all_area .= '<tr align="left" style="color:black">
												      <td>'.++$i.'</td>
												      <td>'.$row['id_no'].'</td>
												      <td>'.$row['name'].'</td>
												      <td>'.$row['area'].'</td>
												      <td>'.$row['from_date'].'</td>
												      <td>'.$row['to_date'].'</td>
												      <td><span class="badge '.$color.'">'.$status.'</span></td>
												  </tr>';
	 						
	 					}
	 					$delivery_man_all_area .= '  </tbody> </table>';
 				}
 				echo json_encode($delivery_man_all_area);

 			}

 		}
 	}elseif ($report_type == 'sample_product_test') {
 		# code...
 	}

 
 	
}
 ?>