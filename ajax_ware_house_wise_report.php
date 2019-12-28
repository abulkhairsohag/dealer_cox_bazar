<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');


include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['from_date'])) {
	
 	$from_date = strtotime($_POST['from_date']);
 	$from_date_show = $_POST['from_date'];
 	$to_date = strtotime($_POST['to_date']);
 	$to_date_show = $_POST['to_date'];
	 $report_type = $_POST['report_type'];
	//  die($report_type);
	$pr_id  = $_POST['product_id'];
	$ware_house_serial_no  = $_POST['ware_house_serial_no'];
	$ware_house_name  = "";
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_ware_house = $dbOb->select($query);
	if ($get_ware_house) {
		$ware_house_name = $get_ware_house->fetch_assoc()['ware_house_name'];
	}

	$area = $_POST['area'];
	// die($area);
	
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

 	$query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
 	$product_info = $dbOb->find($query);


 	if ($report_type == 'product_wise_stock_and_sell') {

		$stock_date_arr = [];
 		$query = "SELECT * FROM product_stock WHERE company_product_return_id = '0' and products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no'";
 		$get_product_stock = $dbOb->select($query);
		 $total_stock = 0;
 		if ($get_product_stock) {

			  $i = 0;
 				while ($row = $get_product_stock->fetch_assoc()) {

 					$stock_date = strtotime($row['stock_date']);
 					if ($stock_date >= $from_date && $stock_date <= $to_date) {
 						$date = $row['stock_date'];
 						$date_converted = strtotime($date);
 						if(array_key_exists($date_converted, $stock_date_arr))
				    	{
				    		$stock_date_arr[$date_converted] +=   (int)$row['quantity'];

				    	}else{
				    		$stock_date_arr[$date_converted] = (int)$row['quantity'];
			    		}
			 			
 					}
 				}
 				foreach ($stock_date_arr as $key => $value) {
 					
 						$total_stock += (int)$value;
 				}
 		}

		 $query = "SELECT * FROM order_delivery_expense WHERE products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no' AND deliver_status = 1";
 		$get_sell = $dbOb->select($query);

		 $total_sold = 0;
 		if ($get_sell) {
 			$sell_date = [];
 			$i = 0;
 			while ($row = $get_sell->fetch_assoc()) {
 				if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date ) {
 					$product_id = $row['products_id_no'];
 					$date = $row['delivery_date'];
 					$date_converted = strtotime($date);
 					
						
 					if(array_key_exists($date_converted, $sell_date))
			    	{
			    		$sell_date[$date_converted] +=   (int)$row['qty'];

			    	}else{
			    		$sell_date[$date_converted] = (int)$row['qty'];
		    		}
 				}
 			}
 		}
 		$query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
 		$product_info = $dbOb->find($query);

		$total_sold = 0;
 		foreach ($sell_date as $key => $value) {

			$total_sold += (int)$value;
 			
 		}

		 $query = "SELECT * FROM market_products_return WHERE products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no'";
		 		$get_return = $dbOb->select($query);
		 		if ($get_return) {
		 			
					  $i = 0;
					  $total_return = 0;

		 				while ($row = $get_return->fetch_assoc()) {
		 					$return_date = strtotime($row['return_date']);
		 					if ($return_date >= $from_date && $return_date <= $to_date) {
		 						$product_id = $row['products_id_no'];
		 	
		 						$total_return += (int)$row['return_quantity'];
		 					}
		 				}
		 	
			}

			$company_return = [];
			$total_company_return = 0;
			$query = "SELECT * FROM product_stock WHERE company_product_return_id <> '0' and products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no'";
			$get_company_return = $dbOb->select($query);
			if ($get_company_return) {

				 $i = 0;
				 $total_company_return = 0;
					while ($row = $get_company_return->fetch_assoc()) {

						$stock_date = strtotime($row['stock_date']);
						if ($stock_date >= $from_date && $stock_date <= $to_date) {
							$date = $row['stock_date'];
							$date_converted = strtotime($date);
							if(array_key_exists($date_converted, $company_return))
						   {
							   $company_return[$date_converted] +=   -1 * (int)$row['quantity'];

						   }else{
							   $company_return[$date_converted] = -1 * (int)$row['quantity'];
						   }

							
						}
					}

				
					foreach ($company_return as $key => $value) {
		
							$total_company_return += (int)$value;
					}
 		}

 		
		 $stock_tbl =  '<div  id="print_table" style="color:black">
		 <span class="text-center">
			 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			 <h5>'.$show_date.'</h5>
			 
	 </span>
	 <div class="text-center">
		 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PRODUCT WISE STOCK & SELL</b></h4>
	 </div>
	 <br>
		 <table class="table table-responsive">
			 <tbody>
				 <tr>
					 <td class="text-LEFT">
						<h5 style="margin:0px ; margin-top: -8px;">Product ID : <span></span>'.$pr_id.'</span></h5>
						<h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$product_info['products_name'].'</span></h5>
						<h5 style="margin:0px ; margin-top: -8px;">Company : <span></span>'.$product_info['company'].'</span></h5>
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

		 $stock_tbl .= '<table class="table table-bordered table-responsive">
					  <thead style="background:#4CAF50; color:white" >
						<tr>
						  
						  <th scope="col">Stock</th>
						  <th scope="col">Sell</th>
						  <th scope="col">Return From Market</th>
						  <th scope="col">Return To Company</th>
						</tr>
					  </thead>
					  <tbody>';


				 $stock_tbl .= '<tr>
									
									  <td>'.$total_stock.'</td>
									  <td>'.$total_sold.'</td>
									  <td>'.$total_return.'</td>
									  <td>'.$total_company_return.'</td>
									</tr>';


									$print_table = 'print_table';

									$stock_tbl .= '  </tbody> </table></div>
									<div class="mt-3">
														<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
														</div>';
			echo json_encode($stock_tbl);
			exit();

 	}elseif ($report_type == 'sell') {

 		$query = "SELECT * FROM order_delivery_expense WHERE products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no' AND delivery_status = 1";
 		$get_sell = $dbOb->select($query);

 		if ($get_sell) {
 			$sell_date = [];
 			$i = 0;
 			$total_sell = 0;
 			while ($row = $get_sell->fetch_assoc()) {
 				if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date ) {
 					$product_id = $row['products_id_no'];
 					$date = $row['delivery_date'];
 					$date_converted = strtotime($date);
 					
						
 					if(array_key_exists($date_converted, $sell_date))
			    	{
			    		$sell_date[$date_converted] +=   (int)$row['qty'];

			    	}else{
			    		$sell_date[$date_converted] = (int)$row['qty'];
		    		}
 				}
 			}
 		}
 		$query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
 		$product_info = $dbOb->find($query);

 		
			 $sell_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PRODUCT WISE SELL</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							<h5 style="margin:0px ; margin-top: -8px;">Product ID : <span></span>'.$pr_id.'</span></h5>
							<h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$product_info['products_name'].'</span></h5>
							<h5 style="margin:0px ; margin-top: -8px;">Company : <span></span>'.$product_info['company'].'</span></h5>
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
 			
 			$sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Sold Quantity</th>
						      <th scope="col">Date</th>
						    </tr>
						  </thead>
						  <tbody>';

		$total_sold = 0;
 		foreach ($sell_date as $key => $value) {

			$sell_tbl .= '<tr>
					      <td>'.++$i.'</td>
					      <td>'.$value.'</td>
					      <td>'.date("d-m-Y", $key).'</td>
					    </tr>';
			$total_sold += (int)$value;
 			
 		}

		$sell_tbl .= '<tr style="color: red">
				      <td colspan="" align="right">Total Quantity</td>
				      <td colspan="2">'.$total_sold.'</td>
				    </tr>';
					$print_table = 'print_table';

					$sell_tbl .= '  </tbody> </table></div>
					<div class="mt-3">
										<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
										</div>';
		echo json_encode($sell_tbl);
		exit();

	}elseif ($report_type == 'market_return') {

		$query = "SELECT * FROM market_products_return WHERE products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no'";
		$get_return = $dbOb->select($query);
		$i = 0;
		$total_return = 0;

		$return_market_tbl = '<div  id="print_table" style="color:black">
		<span class="text-center">
			<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			<h5>'.$show_date.'</h5>
			
				</span>
				<div class="text-center">
					<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PRODUCT WISE RETURN FROM MARKET</b></h4>
				</div>
				<br>
					<table class="table table-responsive">
						<tbody>
							<tr>
								<td class="text-LEFT">
								<h5 style="margin:0px ; margin-top: -8px;">Product ID : <span></span>'.$pr_id.'</span></h5>
								<h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$product_info['products_name'].'</span></h5>
								<h5 style="margin:0px ; margin-top: -8px;">Company : <span></span>'.$product_info['company'].'</span></h5>
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
									<th scope="col">Serial No</th>
									<th scope="col">Area</th>
									<th scope="col">Reason</th>
									<th scope="col">Return Quantity</th>
									<th scope="col">Date</th>
								</tr>
								</thead>
								<tbody>';


		 		if ($get_return) {

		 				while ($row = $get_return->fetch_assoc()) {
		 					$return_date = strtotime($row['return_date']);
		 					if ($return_date >= $from_date && $return_date <= $to_date) {
		 						$product_id = $row['products_id_no'];
		 						// $quantity = (int)$row['return_quantity'];

					 			$return_market_tbl .= '<tr>
											      <td>'.++$i.'</td>
											      <td>'.$row['area_employee_delivery'].'</td>
											      <td>'.$row['return_reason'].'</td>
											      <td>'.$row['return_quantity'].'</td>
											      <td>'.$row['return_date'].'</td>
											    </tr>';
		 						$total_return += (int)$row['return_quantity'];
		 					}
		 				}
					}
			if ($i == 0) {
				$return_market_tbl .= '<tr style="color: red">
								<td colspan="5" align="center">No Record Found</td>
							</tr>';
			}else{

				$return_market_tbl .= '<tr style="color: red">
									<td colspan="3" align="right">Total Returnde Quantity</td>
									<td colspan="2">'.$total_return.'</td>
								</tr>';
			}

							$print_table = 'print_table';

							$return_market_tbl .= '  </tbody> </table></div>
							<div class="mt-3">
												<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
												</div>';
			echo json_encode($return_market_tbl);
			exit();

 		
	}elseif ($report_type == 'company_return') {

 		 $company_return = [];
	 		$query = "SELECT * FROM product_stock WHERE company_product_return_id <> '0' and products_id_no = '$pr_id' AND ware_house_serial_no = '$ware_house_serial_no'";
			 $get_company_return = $dbOb->select($query);
			 $i = 0;
			 $total_stock = 0;
			 
			 $stock_tbl =  '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>PRODUCT WISE RETURN TO COMPANY</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							<h5 style="margin:0px ; margin-top: -8px;">Product ID : <span></span>'.$pr_id.'</span></h5>
							<h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$product_info['products_name'].'</span></h5>
							<h5 style="margin:0px ; margin-top: -8px;">Company : <span></span>'.$product_info['company'].'</span></h5>
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

			 $stock_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
							<tr>
							  <th scope="col">Serial No</th>
							  <th scope="col">Returned Quantity</th>
							  <th scope="col">Date</th>
							</tr>
						  </thead>
						  <tbody>';

	 		if ($get_company_return) {

				  
	 				while ($row = $get_company_return->fetch_assoc()) {

	 					$stock_date = strtotime($row['stock_date']);
	 					if ($stock_date >= $from_date && $stock_date <= $to_date) {
	 						$date = $row['stock_date'];
	 						$date_converted = strtotime($date);
	 						if(array_key_exists($date_converted, $company_return))
					    	{
					    		$company_return[$date_converted] +=   -1 * (int)$row['quantity'];

					    	}else{
					    		$company_return[$date_converted] = -1 * (int)$row['quantity'];
				    		}

				 			
	 					}
	 				}

	 			
				

	 				foreach ($company_return as $key => $value) {
	 					$stock_tbl .= '<tr>
										      <td>'.++$i.'</td>
										      <td>'.$value.'</td>
										      <td>'.date("d-m-Y",$key).'</td>
										    </tr>';
	 						$total_stock += (int)$value;
	 				}

				}

				if ($i == 0) {
					$stock_tbl .= '<tr style="color: red">
								 <td colspan="3" align="center">No Record Found</td>
							   </tr>';
				}else{
				$stock_tbl .= '<tr style="color: red">
								 <td colspan="" align="right">Total Return</td>
								 <td colspan="2">'.$total_stock.'</td>
							   </tr>';
				}

				$print_table = 'print_table';

				$stock_tbl .= '  </tbody> </table></div>
				<div class="mt-3">
									<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
									</div>';

			   echo json_encode($stock_tbl);
			   exit();
	}elseif ($report_type == 'top_sell') {

		$query = "SELECT * FROM order_delivery_expense AND ware_house_serial_no = '$ware_house_serial_no' AND delivery_status = 1";
		$get_sell = $dbOb->select($query);
		$i = 0;
 		$total_sell = 0;
		 

		 $sell_tbl =  '<div  id="print_table" style="color:black">
		 <span class="text-center">
			 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			 <h5>'.$show_date.'</h5>
			 
	 </span>
	 <div class="text-center">
		 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>TOP SELL</b></h4>
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

 			
 			$sell_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Product ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Company</th>
						      <th scope="col">Sold Quantity</th>
						    </tr>
						  </thead>
						  <tbody>';

 		if ($get_sell) {
 			$product = [];
 			
 			while ($row = $get_sell->fetch_assoc()) {
 				if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date ) {
 					$product_id = $row['products_id_no'];
 					$date = $row['delivery_date'];
 					$date_converted = strtotime($date);
 					
						
 					if(array_key_exists($product_id, $product))
			    	{
			    		$product[$product_id] +=   (int)$row['qty'];

			    	}else{
			    		$product[$product_id] = (int)$row['qty'];
		    		}
 				}
 			}
 		}
		 arsort($product);
		 

		$total_sold = 0;
 		foreach ($product as $key => $value) {
 			$query = "SELECT * FROM products WHERE products_id_no = '$key'";
 			$product_info = $dbOb->find($query);
			$sell_tbl .= '<tr>
					      <td>'.++$i.'</td>
					      <td>'.$product_info['products_id_no'].'</td>
					      <td>'.$product_info['products_name'].'</td>
					      <td>'.$product_info['company'].'</td>
					      <td>'.$value.'</td>
					    </tr>';
 			
		 }
		 
		 if ($i == 0) {
			$sell_tbl .= '<tr style="color:red">
					      <td colspan="5" align="center">No Record Found</td>
					    </tr>';
		 }

		 $print_table = 'print_table';

				 $sell_tbl .= '  </tbody> </table></div>
				 <div class="mt-3">
									 <a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
									 </div>';
		echo json_encode($sell_tbl);
		exit();
 		
	}elseif ($report_type == 'lowest_sell') {

				$query = "SELECT * FROM order_delivery_expense AND ware_house_serial_no = '$ware_house_serial_no' AND delivery_status = 1";
				 $get_sell = $dbOb->select($query);
				 $i = 0;



				 $sell_tbl =   '<div  id="print_table" style="color:black">
				 <span class="text-center">
					 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
					 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
					 <h5>'.$show_date.'</h5>
					 
			 </span>
			 <div class="text-center">
				 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>LOWEST SELL</b></h4>
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
		

		 			
		 			$sell_tbl .= '<table class="table table-bordered table-responsive">
								  <thead style="background:#4CAF50; color:white" >
								    <tr>
								      <th scope="col">Serial No</th>
								      <th scope="col">Product ID</th>
								      <th scope="col">Name</th>
								      <th scope="col">Company</th>
								      <th scope="col">Sold Quantity</th>
								    </tr>
								  </thead>
								  <tbody>';

		 		if ($get_sell) {
		 			$product = [];
		 			$total_sell = 0;
		 			while ($row = $get_sell->fetch_assoc()) {
		 				if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date ) {
		 					$product_id = $row['products_id_no'];
		 					$date = $row['delivery_date'];
		 					$date_converted = strtotime($date);
		 					
								
		 					if(array_key_exists($product_id, $product))
					    	{
					    		$product[$product_id] +=   (int)$row['qty'];

					    	}else{
					    		$product[$product_id] = (int)$row['qty'];
				    		}
		 				}
		 			}
		 		}
	
				 asort($product);
				

				$total_sold = 0;
		 		foreach ($product as $key => $value) {
		 			$query = "SELECT * FROM products WHERE products_id_no = '$key'";
		 			$product_info = $dbOb->find($query);
					$sell_tbl .= '<tr>
							      <td>'.++$i.'</td>
							      <td>'.$product_info['products_id_no'].'</td>
							      <td>'.$product_info['products_name'].'</td>
							      <td>'.$product_info['company'].'</td>
							      <td>'.$value.'</td>
							    </tr>';
		 			
				 }
				 if ($i == 0) {
					$sell_tbl .= '<tr style="color:red">
								  <td colspan="5" align="center">No Record Found</td>
								</tr>';
				 }

				 $print_table = 'print_table';

				 $sell_tbl .= '  </tbody> </table></div>
				 <div class="mt-3">
									 <a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
									 </div>';
				echo json_encode($sell_tbl);
				exit();
 		
	}elseif($report_type == 'top_profit'){	
		$query = "SELECT * FROM order_delivery_expense AND ware_house_serial_no = '$ware_house_serial_no' AND delivery_status = 1";
			 $get_sell = $dbOb->select($query);
			 $i = 0;
			 
			 $sell_tbl =   '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>TOP PROFITABLE PRODUCT</b></h4>
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
	

	 			
	 			$sell_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">Serial No</th>
							      <th scope="col">Product ID</th>
							      <th scope="col">Name</th>
							      <th scope="col">Company</th>
							      <th scope="col">Total Profit</th>
							    </tr>
							  </thead>
							  <tbody>';

	 		if ($get_sell) {
	 			$product = [];
	 			$total_sell = 0;
	 			while ($row = $get_sell->fetch_assoc()) {
	 				if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date ) {
	 					$product_id = $row['products_id_no'];
	 					$date = $row['delivery_date'];
	 					$date_converted = strtotime($date);
	 					
							
	 					if(array_key_exists($product_id, $product))
				    	{
				    		$profit = $row['sell_price'] *1 - $row['purchase_price']*1;
				    		$product[$product_id] +=  $profit;
				    	}else{
				    		$profit = $row['sell_price'] *1 - $row['purchase_price']*1;
				    		$product[$product_id] = (int)$profit;
			    		}
	 				}
	 			}
	 		}
			 arsort($product);
			 
			$total_sold = 0;
	 		foreach ($product as $key => $value) {
	 			$query = "SELECT * FROM products WHERE products_id_no = '$key'";
	 			$product_info = $dbOb->find($query);
				$sell_tbl .= '<tr>
						      <td>'.++$i.'</td>
						      <td>'.$product_info['products_id_no'].'</td>
						      <td>'.$product_info['products_name'].'</td>
						      <td>'.$product_info['company'].'</td>
						      <td>'.$value.'</td>
						    </tr>';
	 			
			 }
			 if ($i == 0) {
				$sell_tbl .= '<tr style="color:red">
							  <td colspan="5" align="center">No Record Found</td>
							</tr>';
			 }


			
			 $print_table = 'print_table';

			$sell_tbl .= '  </tbody> </table></div>
			<div class="mt-3">
								<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
								</div>';
			echo json_encode($sell_tbl);
			exit();

		
	}elseif($report_type == 'lowest_profit'){

			$query = "SELECT * FROM order_delivery_expense AND ware_house_serial_no = '$ware_house_serial_no' AND delivery_status = 1";
			 $get_sell = $dbOb->select($query);
			 $i = 0;


			 	 		
			 $sell_tbl =   '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>LOWEST PROFITABLE PRODUCT</b></h4>
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
			//  $sell_tbl .= '</span><hr>';
	 			$sell_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">Serial No</th>
							      <th scope="col">Product ID</th>
							      <th scope="col">Name</th>
							      <th scope="col">Company</th>
							      <th scope="col">Total Profit</th>
							    </tr>
							  </thead>
							  <tbody>';

	 		if ($get_sell) {
	 			$product = [];
	 			$total_sell = 0;
	 			while ($row = $get_sell->fetch_assoc()) {
	 				if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date ) {
	 					$product_id = $row['products_id_no'];
	 					$date = $row['delivery_date'];
	 					$date_converted = strtotime($date);
	 					
							
	 					if(array_key_exists($product_id, $product))
				    	{
				    		$profit = $row['sell_price'] *1 - $row['purchase_price']*1;
				    		$product[$product_id] +=  $profit;
				    	}else{
				    		$profit = $row['sell_price'] *1 - $row['purchase_price']*1;
				    		$product[$product_id] = (int)$profit;
			    		}
	 				}
	 			}
	 		}
	 		asort($product);


			$total_sold = 0;
	 		foreach ($product as $key => $value) {
	 			$query = "SELECT * FROM products WHERE products_id_no = '$key'";
	 			$product_info = $dbOb->find($query);
				$sell_tbl .= '<tr>
						      <td>'.++$i.'</td>
						      <td>'.$product_info['products_id_no'].'</td>
						      <td>'.$product_info['products_name'].'</td>
						      <td>'.$product_info['company'].'</td>
						      <td>'.$value.'</td>
						    </tr>';
	 			
			 }
			 if ($i == 0) {
				$sell_tbl .= '<tr style="color:red">
							  <td colspan="5" align="center">No Record Found</td>
							</tr>';
			 }

			
			 $print_table = 'print_table';

			$sell_tbl .= '  </tbody> </table></div>
			<div class="mt-3">
								<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
								</div>';
			echo json_encode($sell_tbl);
			exit();
		

	}elseif ($report_type == 'all_product_stock_and_sell') {

		$query = "SELECT * FROM products ORDER BY serial_no DESC";
		$get_product = $dbOb->select($query);
		
		$stock_tbl = '<div  id="print_table" style="color:black">
							<span class="text-center">
								<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
								<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
								<h5>'.$show_date.'</h5>
								
						</span>
						<div class="text-center">
							<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>ALL PRODUCT STOCK & SELL</b></h4>
						</div>
						<br>
							<table class="table table-responsive">
								<tbody>
									<tr>
										<td class="text-left">
											<h5 style="margin:0px ; margin-top: -8px;">Ware House Name : <span></span>'.$ware_house_name.'</span></h5>
										
											
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

		$stock_tbl .= '<table class="table table-bordered table-responsive">
							<thead style="background:#4CAF50; color:white" >
								<tr>
									<th>Sl<br> No.</th>
									<th>Product<br>Name</th>
									<th>Purchase<br>(Qty)</th>
									<th>Purchase<br>(৳)</th>
									<th>Company Return(Qty)</th>
									<th>Company Return (৳)</th>
									<th>Market Return (Qty)</th>
									<th>Market Return (৳)</th>
									<th>Product <br> Sell (Qty)</th>
									<th>Product <br> Sell (৳)</th>
									<th>Profit On<br>Sell (৳)</th>
									
								</tr>
							</thead>
							<tbody>';

		$total_purchase_amt = 0;
		$total_company_product_return_tk = 0;
		$total_return_market_tk = 0;
		$total_product_sell_amt = 0;
		$total_profit_on_sell_amt = 0 ;
		$total_in_stock_amt = 0;
		
		if ($get_product) {
			$i=0;
			while ($row = $get_product->fetch_assoc()) {

				$i++;
				$products_id_no = $row['products_id_no'];

				// Product Stock
				$stock = 0;
				$stock_taka = 0;
				$return = 0;
				$product_sell = 0;
				$product_sell_price = 0;
				$product_sell_profit = 0;
				$return_product = 0;
				$stock_query = "SELECT * FROM product_stock WHERE products_id_no = '$products_id_no' AND ware_house_serial_no = '$ware_house_serial_no'  AND products_id_no = '$products_id_no'";
				$get_stock = $dbOb->select($stock_query);
				if ($get_stock) {
					
					while ($stock_row = $get_stock->fetch_assoc()) {
						if (strtotime($stock_row['stock_date']) >= $from_date && strtotime($stock_row['stock_date']) <= $to_date ) {
							$quantity = $stock_row['quantity'];
							if ($quantity > 0) {
								$stock = $stock + $quantity;
								$stock_taka += $stock_row['company_price']*$quantity;
							}else{
								$return = $return + $quantity;
								$return = $return * (-1);
							}
							$total_stock = $stock - $return;
						}
					}
				}
	
	
	
				//  Product Sell
				$product_sell =0;
				$product_sell_price = 0;
				$product_sell_profit  = 0;
				$order_query = "SELECT * FROM order_delivery_expense WHERE products_id_no = '$products_id_no' AND ware_house_serial_no = '$ware_house_serial_no' AND delivery_status = 1  AND products_id_no = '$products_id_no'" ;
				$get_order = $dbOb->select($order_query);
				if ($get_order) {
					
					while ($order_row = $get_order->fetch_assoc()) {
						if (strtotime($order_row['delivery_date']) >= $from_date && strtotime($order_row['delivery_date']) <= $to_date ) {
							$order_quantity = $order_row['qty'];
							$product_sell = $product_sell + $order_quantity;
							$product_sell_price += $order_row['total_price'];
							$product_sell_profit += ($order_row['total_price'] - $order_row['purchase_price']);
						}
						
					}
				}
	
				// Return Product Order
				$return_market_product = 0 ;
				$return_market_tk = 0 ;
				$return_query = "SELECT * FROM market_products_return WHERE products_id_no = '$products_id_no' AND ware_house_serial_no = '$ware_house_serial_no'";
				$get_return = $dbOb->select($return_query);
				if ($get_return) {
					
					while ($order_row = $get_return->fetch_assoc()) {
						if (strtotime($order_row['return_date']) >= $from_date && strtotime($order_row['return_date']) <= $to_date ) {
							$return_quantity = $order_row['return_quantity'];
							$return_market_product = $return_market_product + $return_quantity;
							$return_market_tk = $return_market_tk + $order_row['total_price'];
						}
						
					}
				}
				
				// company products return
				$company_product_return = 0;
				$company_product_return_tk = 0;
				$query = "SELECT * FROM `company_products_return` WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$products_id_no'";
				$get_company_product_return = $dbOb->select($query);
				if ($get_company_product_return) {
					
					while ($return_row = $get_company_product_return->fetch_assoc()) {
						if (strtotime($return_row['return_date']) >= $from_date && strtotime($return_row['return_date']) <= $to_date ) {
							$company_product_return += $return_row['return_quantity'];
							$company_product_return_tk += $return_row['total_price'];
						}
						
					}
				}

				// $company_return_price = $return*$row['company_price'];


				$query = "SELECT * FROM invoice_setting";
				$get_invoice = $dbOb->select($query);
				if ($get_invoice) {
				$invoice_setting = $get_invoice->fetch_assoc();
				}

				$mrp = $row['mrp_price'];
				$unit_tp = $mrp - ($mrp* $invoice_setting['discount_on_mrp'])/100;
				$unit_vat = $unit_tp*$invoice_setting['vat']/100;
				$total_tp = $unit_tp;
				$total_vat = $unit_vat;
				$total_price = (float)$total_tp + (float)$total_vat; 
				$discount_on_total_tp = $total_tp * $invoice_setting['discount_on_tp'] / 100 ;
				$sell_price = $total_price - $discount_on_total_tp;
				$sell_price = $sell_price -($sell_price*$invoice_setting['special_discount']/100);
				
				$stock_tbl .= '<tr>
									<td>'. $i.' </td>
									<td> '. ucfirst($row['products_name']).'</td>
									<td> '. $stock.'</td>
									<td> '. $stock_taka.'</td>
									<td> '. $company_product_return.'</td>
									<td> '. $company_product_return_tk.'</td>
									<td> '. $return_market_product.'</td>
									<td> '. $return_market_tk.'</td>
									<td> '. $product_sell.'</td>
									<td> '. $product_sell_price.'</td>
									<td> '. (round($product_sell_profit,3)).'</td>
									
								</tr>';

				$total_purchase_amt += $stock_taka;
				$total_company_product_return_tk += $company_product_return_tk;
				$total_return_market_tk += $return_market_tk;
				$total_product_sell_amt += $product_sell_price;
				$total_profit_on_sell_amt +=  $product_sell_profit;
				// $total_in_stock_amt += $row['quantity']*$row['company_price'];

			}
		}
		$stock_tbl .= '<tr class="bg-success"  style="color:red">
							<td colspan="3" class="text-right">Total Amount</td>
							<td colspan=""> '.$total_purchase_amt.'</td>
							<td colspan=""></td>
							<td> '.round($total_company_product_return_tk).'</td>
							<td colspan=""></td>
							<td> '.round($total_return_market_tk).'</td>
							<td colspan=""></td>
							<td> '.round($total_product_sell_amt).'</td>
							
							<td> '.round($total_profit_on_sell_amt).'</td>
							
						</tr>';
		$print_table = 'print_table';
		$stock_tbl .= '  </tbody>
		</table></div>
		<div class="mt-3">
							<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
							</div>';
		
		echo json_encode($stock_tbl);
			exit();

	}elseif ($report_type == 'sales_dues') {
		$query = "SELECT DISTINCT cust_id FROM `order_delivery`";
		$get_cus =  $dbOb->select($query);

		if ($get_cus) {
			$i = 0;
			$cust_id = [];
			while ($row = $get_cus->fetch_assoc()) {
				$cust_ids[$i] = $row['cust_id'];
				$i++; 
			}
		}

		$sales_dues_tbl = '<div  id="print_table" style="color:black">
		<span class="text-center">
			<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			<h5>'.$show_date.'</h5>
			
				</span>
				<div class="text-center">
					<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>SALES AND DUES STATEMENT</b></h4>
				</div>		<table class="table table-responsive">
						<tbody>
							<tr>
								<td class="text-left">
									<h4><b>All Shop & All Area</b></h4>
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
										<th scope="col">Shop Name</th>
										<th scope="col">Total TP</th>
										<th scope="col">Total VAT</th>
										<th scope="col">Total TP+VAT </th>
										<th scope="col">Payable</th>
										<th scope="col">Pay</th>
										<th scope="col">Due</th>
									</tr>
										</thead>
										<tbody>';

		$i = 0;
		$count = 0;
		$total_tp = 0;
		$total_vat = 0;
		$total_tp_vat = 0;
		$total_payable = 0;
		$total_pay = 0;
		$total_due = 0;

		$grand_total_tp = 0;
		$grand_total_vat = 0;
		$grand_total_tp_vat = 0;
		$grand_total_payable = 0;
		$grand_total_pay = 0;
		$grand_total_due = 0;
		$i=0;

		foreach ($cust_ids as $key => $cust_id) {
			$query = "SELECT * FROM order_delivery WHERE cust_id = '$cust_id'";
			$get_order = $dbOb->select($query);
			if ($get_order) {
				while ($row = $get_order->fetch_assoc()) {
					$order_date = strtotime($row['order_date']);
					if ($order_date >= $from_date && $order_date <= $to_date) {
						$count++;
						$shop_name = $row['shop_name'];
						$total_tp += $row['net_total_tp']; 
						$total_vat += $row['net_total_vat']; 
						$total_payable += $row['payable_amt']; 
						$total_pay += $row['pay']; 
						$total_due += $row['due']; 
					}
				}
				if ($count > 0) {
					$i++;
					$sales_dues_tbl .= ' <tr align="left" style="color:black">
					<td>'.$i.'</td>
					<td>'.$shop_name.'</td>
					<td>'.$total_tp.'</td>
					<td>'.$total_vat.'</td>
					<td>'.($total_vat*1 + $total_tp*1).'</td>
					<td>'.$total_payable.'</td>
					<td>'.$total_pay.'</td>
					<td>'.$total_due.'</td>
				</tr>';

				$grand_total_tp +=$total_tp;
				$grand_total_vat += $total_vat;
				$grand_total_tp_vat += ($total_vat*1 + $total_tp*1);
				$grand_total_payable += $total_payable;
				$grand_total_pay += $total_pay;
				$grand_total_due += $total_due;


				$count = 0;
				$shop_name ='';
				$total_tp = 0; 
				$total_vat = 0 ; 
				$total_payable = 0; 
				$total_pay = 0; 
				$total_due = 0;
				}
			}
		}

		if ($i == 0) {
			$sales_dues_tbl .= '<tr>
								   <td colspan="8"  align="center" style="color:red">No Order Found</td>
							   </tr>';
			
		   }else{
			   $sales_dues_tbl .= '<tr class="bg-success">
								   <td colspan="2"  align="right" style="color:red">Total</td>
								   <td align="left" style="color:red">'.$grand_total_tp.'</td>
								   <td align="left" style="color:red">'.$grand_total_vat.'</td>
								   <td align="left" style="color:red">'.$grand_total_tp_vat.'</td>
								   <td align="left" style="color:red">'.$grand_total_payable.'</td>
								   <td align="left" style="color:red">'.$grand_total_pay.'</td>
								   <td align="left" style="color:red">'.$grand_total_due.'</td>
							   </tr>';
			$sohag = '';
		   }
		   $sales_dues_tbl .= '  </tbody>
		   </table>';
		$sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
			   
		</div>';
		echo json_encode($sales_dues_tbl);

	}elseif ($report_type == 'area_wise_sales_dues') {
		$query = "SELECT  DISTINCT cust_id FROM `order_delivery`";
		$get_cus =  $dbOb->select($query);

		// die($report_type);

		if ($get_cus) {
			$i = 0;
			$cust_id = [];
			while ($row = $get_cus->fetch_assoc()) {
				$cust_ids[$i] = $row['cust_id'];
				$i++; 
			}
		}

		$sales_dues_tbl = '<div  id="print_table" style="color:black">
		<span class="text-center">
			<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			<h5>'.$show_date.'</h5>
			
				</span>
				<div class="text-center">
					<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>AREA WISE SALES AND DUES</b></h4>
				</div>
				<br>
					<table class="table table-responsive">
						<tbody>
							<tr>
								<td class="text-left">
								<h4 style="margin:0px ; margin-top: -8px;"><b>Area : <span></span>'.$area.'</span></b></h4>
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
									<th scope="col">Shop Name</th>
									<th scope="col">Total TP</th>
									<th scope="col">Total VAT</th>
									<th scope="col">Total TP+VAT </th>
									<th scope="col">Payable</th>
									<th scope="col">Pay</th>
									<th scope="col">Due</th>
								</tr>
									</thead>
									<tbody>';

		$i = 0;
		$count = 0;
		$total_tp = 0;
		$total_vat = 0;
		$total_tp_vat = 0;
		$total_payable = 0;
		$total_pay = 0;
		$total_due = 0;

		$grand_total_tp = 0;
		$grand_total_vat = 0;
		$grand_total_tp_vat = 0;
		$grand_total_payable = 0;
		$grand_total_pay = 0;
		$grand_total_due = 0;
		$i=0;

		foreach ($cust_ids as $key => $cust_id) {
			$query = "SELECT * FROM order_delivery WHERE cust_id = '$cust_id' AND area = '$area'";
			$get_order = $dbOb->select($query);
			if ($get_order) {
				while ($row = $get_order->fetch_assoc()) {
					$order_date = strtotime($row['order_date']);
					if ($order_date >= $from_date && $order_date <= $to_date) {
						$count++;
						$shop_name = $row['shop_name'];
						$total_tp += $row['net_total_tp']; 
						$total_vat += $row['net_total_vat']; 
						$total_payable += $row['payable_amt']; 
						$total_pay += $row['pay']; 
						$total_due += $row['due']; 
					}
				}
				if ($count > 0) {
					$i++;
					$sales_dues_tbl .= ' <tr align="left" style="color:black">
					<td>'.$i.'</td>
					<td>'.$shop_name.'</td>
					<td>'.$total_tp.'</td>
					<td>'.$total_vat.'</td>
					<td>'.($total_vat*1 + $total_tp*1).'</td>
					<td>'.$total_payable.'</td>
					<td>'.$total_pay.'</td>
					<td>'.$total_due.'</td>
				</tr>';

				$grand_total_tp +=$total_tp;
				$grand_total_vat += $total_vat;
				$grand_total_tp_vat += ($total_vat*1 + $total_tp*1);
				$grand_total_payable += $total_payable;
				$grand_total_pay += $total_pay;
				$grand_total_due += $total_due;


				$count = 0;
				$shop_name ='';
				$total_tp = 0; 
				$total_vat = 0 ; 
				$total_payable = 0; 
				$total_pay = 0; 
				$total_due = 0;
				}
			}
		}

		if ($i == 0) {
			$sales_dues_tbl .= '<tr>
								   <td colspan="8"  align="center" style="color:red">No Order Found</td>
							   </tr>';
			
		   }else{
			   $sales_dues_tbl .= '<tr class="bg-success">
								   <td colspan="2"  align="right" style="color:red">Total</td>
								   <td align="left" style="color:red">'.$grand_total_tp.'</td>
								   <td align="left" style="color:red">'.$grand_total_vat.'</td>
								   <td align="left" style="color:red">'.$grand_total_tp_vat.'</td>
								   <td align="left" style="color:red">'.$grand_total_payable.'</td>
								   <td align="left" style="color:red">'.$grand_total_pay.'</td>
								   <td align="left" style="color:red">'.$grand_total_due.'</td>
							   </tr>';
			$sohag = '';
		   }
		   $sales_dues_tbl .= '  </tbody>
		   </table>';
		$sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
			   
		</div>';
		echo json_encode($sales_dues_tbl);
	}elseif ($report_type == 'products in stock') {
		$query = "SELECT * FROM products";
		$get_product = $dbOb->select($query);
		$sales_dues_tbl = '<div  id="print_table" style="color:black">
								<span class="text-center">
									<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
									<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
									<h5>Report Date : '.date("d-m-Y").'</h5>
									
										</span>
										<div class="text-center">
											<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>Product In Stock</b></h4>
										</div>		<table class="table table-responsive">
												<tbody>
													<tr>
														<td class="text-left">
															<h5 style="margin:0px ; margin-top: -8px;">Ware House Name : <span></span>'.$ware_house_name.'</span></h5>
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
																<th scope="col">Product ID</th>
																<th scope="col">Name</th>
																<th scope="col">Company</th>
																<th scope="col">Pack Size</th>
																<th scope="col">In Stock (Pack)</th>
															</tr>
																</thead>
																<tbody>';
		if ($get_product) {
			$i = 0;
			while ($product = $get_product->fetch_assoc()) {
				$i ++;
				$product_id = $product['products_id_no'];

				// now getting products stock
				// $in_stock_qty = get_ware_house_in_stock($ware_house_serial_no, $product_id);
				$query = "SELECT * FROM product_stock WHERE quantity > 0 AND ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id'";
		$get_stock = $dbOb->select($query);
				$stock_qty = 0;
				if ($get_stock) {
					while ($stock = $get_stock->fetch_assoc()) {
						$stock_qty += $stock['quantity'];
					}
				} // end of products stock

				// now getting Company return products 
				$query = "SELECT * FROM company_products_return WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id'";
				$get_comany_return = $dbOb->select($query);
				$company_return_qty = 0;
				if ($get_comany_return) {
					while ($company_return = $get_comany_return->fetch_assoc()) {
						$company_return_qty += $company_return['return_quantity'];
					}
				} // end of  Company return products 

				// now getting Market return products 
				$query = "SELECT * FROM market_products_return WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id'";
				$get_market_return = $dbOb->select($query);
				$market_return_qty = 0;
				if ($get_market_return) {
					while ($market_return = $get_market_return->fetch_assoc()) {
						$market_return_qty += $market_return['return_quantity'];
					}
				} // end of Market return products 

				// now getting Product sell
				$query = "SELECT * FROM order_delivery_expense WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id' 	AND delivery_status =  1";
				$get_product_sell = $dbOb->select($query);
				$product_sell_qty = 0;
				if ($get_product_sell) {
					while ($product_sell = $get_product_sell->fetch_assoc()) {
						$product_sell_qty += $product_sell['qty'];
					}
				} // end of Product sell

				// now its time to calculate in stock quantity 

				$in_stock_qty = ($stock_qty*1 + $market_return_qty*1) - ($company_return_qty*1 + $product_sell_qty);

				$sales_dues_tbl .= ' <tr align="left" style="color:black">
											<td>'.$i.'</td>
											<td>'.$product['products_id_no'].'</td>
											<td>'.ucwords($product['products_name']).'</td>
											<td>'.ucwords($product['company']).'</td>
											<td>'.$product['pack_size'].'</td>
											<td>'.$in_stock_qty.'</td>
										</tr>';


			} // end of fetch assoc of get product
		} // end of if get product
		  $sales_dues_tbl .= '  </tbody>
		   </table>';
		$sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
			   
		</div>';
		echo json_encode($sales_dues_tbl);
		die	();
	}



}
 ?>