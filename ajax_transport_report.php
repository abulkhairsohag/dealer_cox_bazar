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

	$from_date_show = $_POST['from_date'];
	$to_date_show = $_POST['to_date'];

	$ware_house_serial_no  = validation($_POST['ware_house_serial_no']);

	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$ware_house_name = $dbOb->find($query)['ware_house_name'];

	$query = "SELECT * FROM `zone` WHERE ware_house_serial_no = '$ware_house_serial_no'";
	$zone_name = '';

	$get_zone = $dbOb->select($query);
	if ($get_zone) {
		$zone_name = $get_zone->fetch_assoc()['zone_name'];
	}


	$report_type = validation($_POST['report_type']);
	
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


	if($report_type == "unload"){
		$i = 0;



		$unload_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 <h5>'.$show_date.'</h5>
			 
					 </span>
					 <div class="text-center">
						 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>TRUCK UNLOAD REPORT</b></h4>
					 </div>
					 <br>
						 <table class="table table-responsive">
							 <tbody>
								 <tr>
									 <td class="text-left">
				                        <h5 style="margin:0px ; margin-top: -8px;">Zone Name : <span></span>'.$zone_name.'</span></h5>
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
					 <table class="table table-bordered table-responsive" style=" border: 1px solid black; ">
										  <thead style="background:#4CAF50; color:white" >
										  <tr style=" border: 1px solid black; ">
										  <th  style=" border: 1px solid black; " scope="col">#</th>
										  <th  style=" border: 1px solid black; " scope="col">Vehicle <br>Reg No</th>
										  <th  style=" border: 1px solid black; " scope="col">Vehicle <br> Name</th>
										  
										  <th  style=" border: 1px solid black; " scope="col">Sales Man</th>
										  <th  style=" border: 1px solid black; " scope="col">Load Date <br> Unload Date</th>
										  <th  style=" border: 1px solid black; " scope="col">Product ID</th>
										  <th  style=" border: 1px solid black; " scope="col">Product Name</th>
										  <th  style=" border: 1px solid black; " scope="col">Loaded <br>QTY</th>
										  <th  style=" border: 1px solid black; " scope="col">Sold<br>QTY</th>
										  <th  style=" border: 1px solid black; " scope="col">Back<br>QTY</th>
										</tr>
										  </thead>
										  <tbody>';
		
		$query = "SELECT * FROM truck_load WHERE ware_house_serial_no = '$ware_house_serial_no' AND unload_status = '1'";
		$get_load = $dbOb->select($query);
		// die($query);

		if ($get_load) {
			$j= 0;
			while ($load_info = $get_load->fetch_assoc()) {
				$unload_date = strtotime($load_info['unload_date']);
				if ($unload_date <= $to_date && $unload_date >= $from_date) {
					$truck_load_tbl_id = $load_info['serial_no'];
					$query = "SELECT * FROM truck_unloaded_products WHERE truck_load_tbl_id = '$truck_load_tbl_id'";
					$get_products = $dbOb->select($query);
					$i = 0 ;

					if ($get_products) {
						while ($row = $get_products->fetch_assoc()) {
							$i++;
						}
					}
					$unload_tbl .='<tr align="left" style="color:black; vertical-align: middle;border: 1px solid black;" >
											<td style="vertical-align : middle;text-align:center;border: 1px solid black;" rowspan="'.$i.'">'.++$j.'</td>
											<td style="vertical-align : middle;text-align:center;border: 1px solid black;" rowspan="'.$i.'">'.$load_info['vehicle_reg_no'].'</td>
											<td style="vertical-align : middle;text-align:center;border: 1px solid black;" rowspan="'.$i.'">'.$load_info['vehicle_name'].'</td>
											<td style="vertical-align : middle;text-align:center;border: 1px solid black;" rowspan="'.$i.'">'.$load_info["employee_id"].'<br>'.$load_info["emplyee_name"].'</td>
											<td style="vertical-align : middle;text-align:center;border: 1px solid black;" rowspan="'.$i.'">'.$load_info["loading_date"].'<br>'.$load_info["unload_date"].'</td>';
					$get_prod = $dbOb->select($query);
					if ($get_prod) {
						while ($row = $get_prod->fetch_assoc()) {
							$productS_id_no = $row['product_id'];
							$query_prod = "SELECT * FROM products WHERE products_id_no = '$productS_id_no'";
							$gt_prd = $dbOb->select($query_prod) ;
							$pack_size = 0;
							if ($gt_prd) {
								$pack_size = $gt_prd->fetch_assoc()['pack_size'];
							}
							if (!$pack_size) {
								$back_pcs = $row['back_pcs'] ;
								$sold_pcs = $row['sold_pcs'] ;
								$load_pcs = $row['loaded_pcs'] ;
								$load_pkt = 0;
								$sold_pkt = 0;
								$back_pkt = 0;
							}else{
							$load_pkt = floor($row['loaded_pcs']/$pack_size);
							$sold_pkt = floor($row['sold_pcs']/$pack_size);
							$back_pkt = floor($row['back_pcs']/$pack_size);

							$back_pcs = $row['back_pcs'] % $pack_size;
							$sold_pcs = $row['sold_pcs'] % $pack_size;
							$load_pcs = $row['loaded_pcs'] % $pack_size;
							}

							 $unload_tbl .= '<td style="vertical-align : middle;text-align:center; border: 1px solid black; ">'.$row['product_id'].'</td>
											<td style="vertical-align : middle;text-align:center; border: 1px solid black; ">'.$row['products_name'].'</td>
											<td style="vertical-align : middle;text-align:center; border: 1px solid black; ">'.$load_pkt.' Pkt<br>'.$load_pcs.' Pcs'.'</td>
											<td style="vertical-align : middle;text-align:center; border: 1px solid black; ">'.$sold_pkt.' Pkt<br>'.$sold_pcs.' Pcs'.'</td>
											<td style="vertical-align : middle;text-align:center; border: 1px solid black; ">'.$back_pkt.' Pkt<br>'.$back_pcs.' Pcs'.'</td></tr>';
						}
					}
				}
			}

		}
		if ($j==0) {
			$unload_tbl .='<tr align="center" style="color:red"><td colspan="10">No Record Found</td></tr>';
			# code...
		}
			$unload_tbl .= '  </tbody>
			</table>';
		 $unload_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a> </div>';
		echo json_encode($unload_tbl);

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