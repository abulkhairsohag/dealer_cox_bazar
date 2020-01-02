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
 	$to_date = strtotime($_POST['to_date']);
 	$vehicle_reg = validation($_POST['vehicle_reg']);
 	$route  = validation($_POST['route']);
 	$report_type = validation($_POST['report_type']);


 	$query = "SELECT * FROM transport WHERE reg_no = '$vehicle_reg'";
 	$get_vehicle = $dbOb->find($query);
 		


 	if ($report_type == "load") {
 		$i = 0;

 		$query = "SELECT * FROM truck_load WHERE vehicle_reg_no = '$vehicle_reg'";
 		$get_load = $dbOb->select($query);

 		if ($get_load) {
 			$load_tbl = '<span align="center"><h3 style="color:red">Load Informatin Of</h3>';
 			$load_tbl .= '<h4>Vehicle Reg No : '.$get_vehicle['reg_no'].'</h4>';
 			$load_tbl .= '<h4>Name : '.$get_vehicle['vehicle_name'].'</h4>';
 			$load_tbl .= '<h4>Type : '.$get_vehicle['type'].'</h4></span><hr>';

 			$load_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Area Name</th>
						      <th scope="col">Employee Name</th>
						      <th scope="col">Date</th>
						      <th scope="col">Loaded Product Name</th>
						      <th scope="col">Quantity</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_load->fetch_assoc()) {

 				if (strtotime($row['loading_date']) >= $from_date && strtotime($row['loading_date']) <= $to_date) {
 					$id = $row['serial_no'];
 					$query = "SELECT * FROM truck_loaded_products WHERE truck_load_tbl_id = '$id'";
		      		$get_product = $dbOb->select($query);
		      		$total_row = $get_product->num_rows + 1 ;

 					$load_tbl .= '<tr>
									      <td  rowspan="'.$total_row.'" >'.++$i.'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['area_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['emplyee_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['loading_date'].'</td></tr>';

					      		
					      		
					      		if ($get_product) {
					      				while ($res = $get_product->fetch_assoc()) {
					      					
					      				$load_tbl .='<tr><td>'.$res['products_name'].'</td>';
					      				 $load_tbl .='<td>'.$res['quantity'].'</td>';
					      						
					      				}
					      		}

					$load_tbl .=' </tr>';
 					
 				}
 				
 			}
 			$load_tbl .= '  </tbody> </table>';
 		}
 		echo json_encode($load_tbl);

 		// the following section is for reporting the truck unload 
 	}else if($report_type == "unload"){
 		$i = 0;

 		// echo json_encode("soahg");
 		// die();

 		$query = "SELECT * FROM truck_load WHERE vehicle_reg_no = '$vehicle_reg' AND unload_status = '1'";
 		$get_load = $dbOb->select($query);

 		if ($get_load) {
 			$unload_tbl = '<span align="center"><h3 style="color:red">Unload Informatin Of</h3>';
 			$unload_tbl .= '<h4>Vehicle Reg No : '.$get_vehicle['reg_no'].'</h4>';
 			$unload_tbl .= '<h4>Name : '.$get_vehicle['vehicle_name'].'</h4>';
 			$unload_tbl .= '<h4>Type : '.$get_vehicle['type'].'</h4></span><hr>';

 			$unload_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Area Name</th>
						      <th scope="col">Employee Name</th>
						      <th scope="col">Date</th>
						      <th scope="col">Product Name</th>
						      <th scope="col">Loaded Qty.</th>
						      <th scope="col">Sold Qty.</th>
						      <th scope="col">Unloaded Qty.</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_load->fetch_assoc()) {

 				if (strtotime($row['unload_date']) >= $from_date && strtotime($row['unload_date']) <= $to_date) {
 					$id = $row['serial_no'];
 					$query = "SELECT * FROM truck_unloaded_products WHERE truck_load_tbl_id = '$id'";
		      		$get_product = $dbOb->select($query);
		      		$total_row = $get_product->num_rows + 1 ;

 					$unload_tbl .= '<tr>
									      <td  rowspan="'.$total_row.'" >'.++$i.'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['area_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['emplyee_name'].'</td>
									      <td  rowspan="'.$total_row.'" >'.$row['unload_date'].'</td></tr>';

					      		
					      		
					      		if ($get_product) {
					      				while ($res = $get_product->fetch_assoc()) {
					      					
					      				$unload_tbl .='<tr><td>'.$res['products_name'].'</td>';
					      				 $unload_tbl .='<td>'.$res['loaded_qty'].'</td>';
					      				 $unload_tbl .='<td>'.$res['sold_qty'].'</td>';
					      				 $unload_tbl .='<td>'.$res['unload_qty'].'</td>';
					      						
					      				}
					      		}

					$unload_tbl .=' </tr>';
 					
 				}
 				
 			}
 			$unload_tbl .= '  </tbody> </table>';
 		}
 		echo json_encode($unload_tbl);

 	}else if($report_type == "list"){

 		if ($route == 'all') {
 			$query = "SELECT * FROM truck_load";
 			$get_route = $dbOb->select($query);
 			if ($get_route) {
 				$route_tbl = '<span align="center"><h3 style="color:red">Transport Informatin Of All Route</h3>';
	 			

	 			$route_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">Serial No</th>
							      <th scope="col">Area Name</th>
							      <th scope="col">Vehicle Name</th>
							      <th scope="col">Type</th>
							      <th scope="col">Reg. No</th>
							      <th scope="col">Employee Name</th>
							      <th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>';
 				while ($row = $get_route->fetch_assoc()) {
 					if (strtotime($row['loading_date']) >= $from_date && $row['loading_date'] <= $to_date) {
 						$route_tbl .= '<tr>
									      <td>'.++$i.'</td>
									      <td>'.$row['area_name'].'</td>
									      <td>'.$row['vehicle_name'].'</td>
									      <td>'.$row['vehicle_type'].'</td>
									      <td>'.$row['vehicle_reg_no'].'</td>
									      <td>'.$row['emplyee_name'].'</td>
									      <td>'.$row['loading_date'].'</td>
									   </tr>';
 					}
 				}

				$route_tbl .= '  </tbody> </table>';

 			}
 			echo json_encode($route_tbl);
 		}else{ // this section is for other location 
 			$query = "SELECT * FROM truck_load  WHERE area_name = '$route'";
 			$get_route = $dbOb->select($query);
 			if ($get_route) {
 				$route_tbl = '<span align="center"><h3 style="color:red">Transport Informatin Of Route: <h1>'.$route.'</h1></h3><hr>';
	 			

	 			$route_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">Serial No</th>
							      <th scope="col">Vehicle Name</th>
							      <th scope="col">Type</th>
							      <th scope="col">Reg. No</th>
							      <th scope="col">Employee Name</th>
							      <th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>';
 				while ($row = $get_route->fetch_assoc()) {
 					if (strtotime($row['loading_date']) >= $from_date && $row['loading_date'] <= $to_date) {
 						$route_tbl .= '<tr>
									      <td>'.++$i.'</td>
									      <td>'.$row['vehicle_name'].'</td>
									      <td>'.$row['vehicle_type'].'</td>
									      <td>'.$row['vehicle_reg_no'].'</td>
									      <td>'.$row['emplyee_name'].'</td>
									      <td>'.$row['loading_date'].'</td>
									   </tr>';
 					}
 				}

				$route_tbl .= '  </tbody> </table>';

 			}
 			echo json_encode($route_tbl); 


 		}

 	}else if($report_type == "self"){
 		$query = "SELECT * FROM transport WHERE owner_type = 'Self'";
 		$get_transport = $dbOb->select($query);
 		if ($get_transport) {
 			$i = 0;
 			$self_tbl = '<span align="center"><h3 style="color:red">Self Transport Information</h3><hr>';
	 			

	 			$self_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">Serial No</th>
							      <th scope="col">Vehicle Name</th>
							      <th scope="col">Type</th>
							      <th scope="col">Reg. No</th>
							      <th scope="col">Engine No</th>
							      <th scope="col">Insurance No</th>
							      <th scope="col">Driver Name</th>
							      <th scope="col">License No</th>
							    </tr>
							  </thead>
							  <tbody>';
 			while ($row = $get_transport->fetch_assoc()) {
 				$self_tbl .= '<tr>
									      <td>'.++$i.'</td>
									      <td>'.$row['vehicle_name'].'</td>
									      <td>'.$row['type'].'</td>
									      <td>'.$row['reg_no'].'</td>
									      <td>'.$row['engine_no'].'</td>
									      <td>'.$row['insurance_no'].'</td>
									      <td>'.$row['driver_name'].'</td>
									      <td>'.$row['license_no'].'</td>
									   </tr>';
 			}
 			$self_tbl .= '  </tbody> </table>';
 		}
 		echo json_encode($self_tbl);
  	}else if($report_type == "rent"){
 		$query = "SELECT * FROM transport WHERE owner_type <> 'Self'";
 		$get_transport = $dbOb->select($query);
 		if ($get_transport) {
 			$i = 0;
 			$rent_tbl = '<span align="center"><h3 style="color:red">Rent Transport Information</h3><hr>';
	 			

	 			$rent_tbl .= '<table class="table table-bordered table-responsive">
							  <thead style="background:#4CAF50; color:white" >
							    <tr>
							      <th scope="col">Serial No</th>
							      <th scope="col">Vehicle Name</th>
							      <th scope="col">Type</th>
							      <th scope="col">Reg. No</th>
							      <th scope="col">Engine No</th>
							      <th scope="col">Insurance No</th>
							      <th scope="col">Driver Name</th>
							      <th scope="col">License No</th>
							    </tr>
							  </thead>
							  <tbody>';
 			while ($row = $get_transport->fetch_assoc()) {
 				$rent_tbl .= '<tr>
									      <td>'.++$i.'</td>
									      <td>'.$row['vehicle_name'].'</td>
									      <td>'.$row['type'].'</td>
									      <td>'.$row['reg_no'].'</td>
									      <td>'.$row['engine_no'].'</td>
									      <td>'.$row['insurance_no'].'</td>
									      <td>'.$row['driver_name'].'</td>
									      <td>'.$row['license_no'].'</td>
									   </tr>';
 			}
 			$rent_tbl .= '  </tbody> </table>';
 		}
 		echo json_encode($rent_tbl);

 	}
 	
 	
}
 ?>