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
	
 	$report_type = validation($_POST['report_type']);
	$employee_id = validation($_POST['employee_id']);
	$deliv_employee_id = validation($_POST['deliv_employee_id']);

	$query = "SELECT * FROM employee_main_info where id_no = '$employee_id'";
	$get_emp = $dbOb->select($query);
	$emp = '';
	if ($get_emp) {
		$emp = $get_emp->fetch_assoc();
	}

	$emp_name = $emp['name'];
	$emp_mobile = $emp['mobile_no'];

	$employee_id_sales = $_POST['employee_id_sales'];

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
			// die('sohag');
		}
		if ($from_date_show == $to_date_show) {
			$show_date = 'Report Date :'.$from_date_show ;
		}else{
			$show_date = 'Report Date : '.$from_date_show.' <span class="badge bg-red"> TO </span> '.$to_date_show;
		}

 	$month = $_POST['month_name'];

 	$exploded_month = explode('/', $month);
 	$month = $exploded_month[0].'-'.$exploded_month[2];

 	switch ($exploded_month[0]) {
 		case '01':
 			$month_name = 'January'.' '.$exploded_month[2];
 			break;
 		case '02':
 			$month_name = 'February'.' '.$exploded_month[2];
 			break;
 		case '03':
 			$month_name = 'March'.' '.$exploded_month[2];
 			break;
 		case '04':
 			$month_name = 'April'.' '.$exploded_month[2];
 			break;
 		case '05':
 			$month_name = 'May'.' '.$exploded_month[2];
 			break;
 		case '06':
 			$month_name = 'June'.' '.$exploded_month[2];
 			break;
 		case '07':
 			$month_name = 'July'.' '.$exploded_month[2];
 			break;
 		case '08':
 			$month_name = 'August'.' '.$exploded_month[2];
 			break;
 		case '09':
 			$month_name = 'September'.' '.$exploded_month[2];
 			break;
 		case '10':
 			$month_name = 'October'.' '.$exploded_month[2];
 			break;
 		case '11':
 			$month_name = 'November'.' '.$exploded_month[2];
 			break;
 		case '12':
 			$month_name = 'December'.' '.$exploded_month[2];
 			break;
 		
 		default:
 			# code...
 			break;
 	}
 
 	if ($report_type == 'attendance') {
 		$query = "SELECT * FROM employee_attendance where attendance_month = '$month'";
 		$get_attendance = $dbOb->select($query);
 		if ($get_attendance) {
 			$emp_present = [];
 			$emp_absent = [];
 			
 			// $attendance = 0 ;
 			while ($row = $get_attendance->fetch_assoc()) {
 				$emp_id = $row['employee_id_no'];
 				if ($row['attendance'] == '1') {
 					if(array_key_exists($emp_id, $emp_present))
			    	{
			    		$emp_present[$emp_id] +=   1;

			    	}else{
			    		$emp_present[$emp_id] = 1;
		    		}
 				}else{
 					if(array_key_exists($emp_id, $emp_absent))
			    	{
			    		$emp_absent[$emp_id] +=   1;

			    	}else{
			    		$emp_absent[$emp_id] = 1;
		    		}
 				}
 			}
 		}

 		$query = "SELECT distinct employee_id_no FROM employee_attendance where attendance_month = '$month'";
 		$get_id = $dbOb->select($query);

 		if ($get_id) {
 			$i=0;
			
			 $attendance_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>EMPLOYEE ATTENDANCE</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-left">
							<b><h5 style="margin:0px ; margin-top: -8px;">MONTH : <span></span>'.strtoupper($month_name).'</span></h5></b>
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

 			$attendance_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Present</th>
						      <th scope="col">Absent</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_id->fetch_assoc()) {
 				// $i++;
 				$employe_id = $row['employee_id_no'];
	 			$query = "SELECT * FROM employee_main_info where id_no = '$employe_id'";
	 			$emp_name = $dbOb->find($query);
	 			$emp_name = $emp_name['name'];

	 			foreach ($emp_present as $key => $value) {
	 				if ($employe_id == $key) {
	 					$present = $value;
	 					break;
	 				}else{
	 					$present = 0;
	 				}
	 			}
	 			foreach ($emp_absent as $key => $value) {
	 				if ($employe_id == $key) {
	 					$absent = $value;
	 					break;
	 				}else{
	 					$absent = 0;
	 				}
	 			}

	 			$attendance_tbl .= '<tr align="left" style="color:black">
												      <td>'.++$i.'</td>
												      <td>'.$employe_id.'</td>
												      <td>'.$emp_name.'</td>
												      <td>'.$present.'</td>
												      <td>'.$absent.'</td>
												  </tr>';

 				 // echo json_encode($emp_id);
 			} // end of swhile
 			$attendance_tbl .= '  </tbody>
									</table>';
			$attendance_tbl .= '  </tbody> </table></div>
			<div class="mt-3">
								<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
								</div>';
 		}

 			



 		echo json_encode($attendance_tbl);


 		// the following section is for showing employee information

 		// the following section is for calculating salary of an employee
 	}elseif ($report_type == 'salary') {
 		$query = "SELECT * FROM employee_main_info WHERE active_status = 'Active'";
 		$get_employee = $dbOb->select($query);
 		if ($get_employee) {
 			$i = 0;
 			$mothly_salar_tbl = '<span align="center"><h3 style="color:red">Monthly Salary Report Of Employee</h3><hr>';

 			$mothly_salar_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Photo</th>
						      <th scope="col">Mobile No </th>
						      <th scope="col">Salary</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_employee->fetch_assoc()) {
			$mothly_salar_tbl .= '<tr align="left" style="color:black">
							      <td>'.++$i.'</td>
							      <td>'.$row['id_no'].'</td>
							      <td>'.$row['name'].'</td>
							      <td><img src="'.$row['photo'].'" width="100px"></td>
							      <td>'.$row['mobile_no'].'</td>
							      <td>'.$row['total_salary'].'</td>
							  </tr>';
 				
 			} // end of while loop 
 			$mothly_salar_tbl .= '  </tbody>
									</table>';
 		}
 		echo json_encode($mothly_salar_tbl);
 	}elseif ($report_type == 'target') {

 		$query = "SELECT * FROM employee_duty WHERE active_status = 'Active'";
 		$get_employee = $dbOb->select($query);
 		if ($get_employee) {
 			$i = 0;
 			$present_employee_tbl = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>EMPLOYEE TARGET INFO</b></h4>
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

 			$present_employee_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Area</th>
						      <th scope="col">Daily Target </th>
						      <th scope="col">Monthly Target</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_employee->fetch_assoc()) {
			$present_employee_tbl .= '<tr align="left" style="color:black">
							      <td>'.++$i.'</td>
							      <td>'.$row['id_no'].'</td>
							      <td>'.$row['name'].'</td>
							      <td>'.$row['area'].'</td>
							      <td>'.$row['per_day'].'</td>
							      <td>'.$row['per_month'].'</td>
							      
							      
							  </tr>';
 				
 			} // end of while loop 
 			$present_employee_tbl .= '  </tbody>
									</table>';
			$present_employee_tbl .='  </tbody> </table></div>
			<div class="mt-3">
								<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
								</div>';
 		}
 		echo json_encode($present_employee_tbl);
 		# code...
 	}elseif ($report_type == 'target_achivmant') {
 		$query = "SELECT * FROM employee_duty WHERE active_status = 'Active'";
 		$get_employee = $dbOb->select($query);
 		if ($get_employee) {
 			$i = 0;
 			$achivement_report = '<div  id="print_table" style="color:black">
			 <span class="text-center">
				 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
				 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
				 
				 
		 </span>
		 <div class="text-center">
			 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>EMPLOYEE TARGET ACHIEVEMENT</b></h4>
		 </div>
		 <br>
			 <table class="table table-responsive">
				 <tbody>
					 <tr>
						 <td class="text-LEFT">
							<b><h5 style="margin:0px ; margin-top: -8px;">MONTH : <span></span>'.strtoupper($month_name).'</span></h5></b>
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

 			$achivement_report .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Area</th>
						      <th scope="col">Monthly Target</th>
						      <th scope="col">Achivement<br> Amount</th>
						      <th scope="col">Target<br>Achived ?</th>
						      <th scope="col">Extra / Less Of<br>Achivement</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_employee->fetch_assoc()) {
 				$empl_id = $row['id_no'];

 				$query = "SELECT * FROM order_delivery WHERE order_employee_id = '$empl_id' AND delivery_month = '$month'";
 				$get_delivery = $dbOb->select($query);
 				// echo json_encode($get_delivery->fetch_assoc());
 				if ($get_delivery) {
 					$delivery_amt = 0;
 					while ($res = $get_delivery->fetch_assoc()) {
 						$delivery_amt += $res['payable_amt'];
 					}


 					if ($row['per_month'] <= $delivery_amt) {
 						$achived = '<span class = "badge bg-green">YES</span>';
 						$extra_amt = $delivery_amt - $row['per_month'];
 						$extra_amt = '<span class = "badge bg-green">'.$extra_amt.' ( Taka )</span>';
 					}else{
 						$achived = '<span class = "badge bg-red">NO</span>';
 						$extra_amt = $delivery_amt - $row['per_month'];
 						$extra_amt = '<span class = "badge bg-red">'.$extra_amt.' ( Taka )</span>';

 					}
 					$achivement_report .= '<tr align="left" style="color:black">
										      <td>'.++$i.'</td>
										      <td>'.$row['id_no'].'</td>
										      <td>'.$row['name'].'</td>
										      <td>'.$row['area'].'</td>
										      <td>'.$row['per_month'].'</td>
										      <td>'.$delivery_amt.'</td>
										      <td>'.$achived.'</td>
										      <td>'.$extra_amt.'</td>
										  </tr>';
 				}
 			}
 			$achivement_report .= '  </tbody>
									</table>';
			$achivement_report .='  </tbody> </table></div>
			<div class="mt-3">
								<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
								</div>';
 		}
 		echo json_encode($achivement_report);

 	}elseif ($report_type == 'present_employee') {
 		$query = "SELECT * FROM employee_main_info WHERE active_status = 'Active'";
 		$get_employee = $dbOb->select($query);
 		if ($get_employee) {
 			$i = 0;
 			$present_employee_tbl = '<span align="center"><h3 style="color:red">Report Of Present Employee</h3><hr>';

 			$present_employee_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Photo</th>
						      <th scope="col">Mobile No </th>
						      <th scope="col">Salary</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_employee->fetch_assoc()) {
			$present_employee_tbl .= '<tr align="left" style="color:black">
							      <td>'.++$i.'</td>
							      <td>'.$row['id_no'].'</td>
							      <td>'.$row['name'].'</td>
							      <td><img src="'.$row['photo'].'" width="100px"></td>
							      <td>'.$row['mobile_no'].'</td>
							      <td>'.$row['total_salary'].'</td>
							      <td>
							      	<a href="view_employee.php?serial_no='.$row['serial_no'].'" type="button" class="badge bg-green view_data"> View Details</a>
							      </td>
							      
							  </tr>';
 				
 			} // end of while loop 
 			$present_employee_tbl .= '  </tbody>
									</table>';
 		}
 		echo json_encode($present_employee_tbl);
 	}elseif ($report_type == 'ex_employee') {
 		$query = "SELECT * FROM employee_main_info WHERE active_status <> 'Active'";
 		$get_employee = $dbOb->select($query);
 		if ($get_employee) {
 			$i = 0;
 			$present_employee_tbl = '<span align="center"><h3 style="color:red">Report Of Ex Employee</h3><hr>';

 			$present_employee_tbl .= '<table class="table table-bordered table-responsive">
						  <thead style="background:#4CAF50; color:white" >
						    <tr>
						      <th scope="col">Serial No</th>
						      <th scope="col">Employee ID</th>
						      <th scope="col">Name</th>
						      <th scope="col">Photo</th>
						      <th scope="col">Mobile No </th>
						      <th scope="col">Salary</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>';
 			while ($row = $get_employee->fetch_assoc()) {
			$present_employee_tbl .= '<tr align="left" style="color:black">
							      <td>'.++$i.'</td>
							      <td>'.$row['id_no'].'</td>
							      <td>'.$row['name'].'</td>
							      <td><img src="'.$row['photo'].'" width="100px"></td>
							      <td>'.$row['mobile_no'].'</td>
							      <td>'.$row['total_salary'].'</td>
							      <td>
							      	<a href="view_employee.php?serial_no='.$row['serial_no'].'" type="button" class="badge bg-green view_data"> View Details</a>
							      </td>
							      
							  </tr>';
 				
 			} // end of while loop 
 			$present_employee_tbl .= '  </tbody>
									</table>';
 		}
 		echo json_encode($present_employee_tbl);
 	}else if($report_type == 'sales_and_dues'){

 		if (Session::get("zone_serial_no")){
 			if (Session::get("zone_serial_no") != '-1') {
 				$zone_serial = Session::get("zone_serial_no");
 				$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial'";
 				$get_zone = $dbOb->find($query);
 				$zone_name = $get_zone['zone_name'];
 				$query = "SELECT * FROM `order_delivery` WHERE zone_serial_no = '$zone_serial' ORDER BY zone_serial_no";
 			}
 		}else{
 			$zone_name = "All Zone";
 			$query = "SELECT * FROM `order_delivery`  ORDER BY zone_serial_no";
 		}
		 //  $query = "SELECT * FROM `order_delivery`";
		 $get_order = $dbOb->select($query);

		 $sales_dues_tbl = '<div  id="print_table" style="color:black">
		 <span class="text-center">
			 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			 <h5>'.$show_date.'</h5>
			 
					 </span>
					 <div class="text-center">
						 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>ALL SALES MAN\'S SALES & DUES</b></h4>
					 </div>
					 <br>
						 <table class="table table-responsive">
							 <tbody>
								 <tr>
									 <td>
										 <h5 style="margin:0px ; margin-top: -8px;">Zone Name : <span></span>'.$zone_name.'</span></h5>
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
						  <th scope="col">Sales Man</th>
						  <th scope="col">Delivery Man</th>
						  <th scope="col">Zone Name</th>
						  <th scope="col">Order No</th>
						  <th scope="col">Shop / (Area)</th>
						  <th scope="col">Payable</th>
						  <th scope="col">Pay</th>
						  <th scope="col">Due</th>
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
						 $delivery_date = strtotime($row['delivery_date']);
						 if ($delivery_date >= $from_date &&  $delivery_date <= $to_date) {
							 $i++;
							 if ($row['due']==0) {
								$pay =  '<span class="badge bg-green">Paid</span>';
							 }else{
								$pay =  $row['due'];
							 }
							
							 $sales_dues_tbl .= ' <tr align="left" style="color:black">
													<td>'.$i.'</td>
													<td>'.$row['order_employee_id'].'<br>'.$row['order_employee_name'].'</td>
													<td>'.$row['delivery_employee_id'].'<br>'.$row['delivery_employee_name'].'</td>
													<td>'.$row['zone_name'].'</td>
													<td>'.$row['order_no'].'</td>
													<td>'.$row['shop_name'].'<br>('.$row['area'].')</td>
													<td>'.round($row['payable_amt'],2).'</td>
													<td>'.round($row['pay'],2).'</td>
													<td >'.round($pay,2).'</td>
													<td>'.$row['delivery_date'].'</td>
												</tr>';
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
											<td colspan="10"  align="center" style="color:red">No Order Found</td>
										</tr>';
					 
					}else{
						$sales_dues_tbl .= '<tr class="bg-success">
											<td colspan="6"  align="right" style="color:red">Total</td>
											<td colspan=""  align="left" style="color:red">'.$total_payable.'</td>
											<td colspan=""  align="left" style="color:red">'.$total_pay.'</td>
											<td colspan="2"  align="left" style="color:red">'.$total_due.'</td>
										</tr>';
					}
					$sales_dues_tbl .= '  </tbody>
					</table>';
				 $sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
		                
				 </div>';
				 echo json_encode($sales_dues_tbl);
		 
	 }else if ($report_type == 'empwise_dues') {
		
			$query = "SELECT * FROM `order_delivery` WHERE order_employee_id = '$employee_id'" ;
			 $get_order = $dbOb->select($query);

			 $sales_dues_tbl = '<div  id="print_table" style="color:black">
					 <span class="text-center">
						 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
						 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
						 <h5>'.$show_date.'</h5>
						 
				 </span>
				 <div class="text-center">
					 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>SALES MAN WISE DUES</b></h4>
				 </div>
				 <br>
					 <table class="table table-responsive">
						 <tbody>
							 <tr>
								 <td class="text-left">
								 <h5 style="margin:0px ; margin-top: -8px;">Employee ID : <span></span>'.$employee_id.'</span></h5>
								 <h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$emp_name.'</span></h5>
								 <h5 style="margin:0px ; margin-top: -8px;">Mobile No : <span></span>'.$emp_mobile.'</span></h5>
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
									  <th scope="col">Order No</th>
									  <th scope="col">Shop / (Area)</th>
									  <th scope="col">Zone</th>
									  <th scope="col">Delivery Man</th>
									  <th scope="col">Payable</th>
									  <th scope="col">Pay</th>
									  <th scope="col">Due</th>
									  <th scope="col">Delivery</th>
									</tr>
									  </thead>
									  <tbody>';
					$i = 0;
					
					$total_payable = 0;
					$total_pay = 0;
					$total_due = 0;
					 if ($get_order) {
						 

						 while ($row = $get_order->fetch_assoc()) {
							 $delivery_date = strtotime($row['delivery_date']);
							 if ($delivery_date >= $from_date &&  $delivery_date <= $to_date && $row['due'] > 0) {
								 $i++;
								 if ($row['due']>0) {
									 $color = 'red';
								 }else{
									 $color = 'black';
								 }
								 $sales_dues_tbl .= ' <tr align="left" style="color:black">
														<td>'.$i.'</td>
														<td>'.$row['order_no'].'</td>
														<td>'.$row['shop_name'].'<br>('.$row['area'].')</td>
														<td>'.$row['zone_name'].'</td>
														<td>'.$row['delivery_employee_id'].'<br>'.$row['delivery_employee_name'].'</td>
														<td>'.$row['payable_amt'].'</td>
														<td>'.$row['pay'].'</td>
														<td>'.$row['due'].'</td>
														<td>'.$row['delivery_date'].'</td>
													</tr>';
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
												<td colspan="9"  align="center" style="color:red">No Order Found</td>
											</tr>';
						 
						}else{
							$sales_dues_tbl .= '<tr class="bg-success">
												<td colspan="5"  align="right" style="color:red">Total</td>
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

	 }else if ($report_type == 'sales_man_wise_party_coverage') {
		
		$query = "SELECT * FROM `order_delivery` WHERE order_employee_id = '$employee_id'" ;
		 $get_order = $dbOb->select($query);

		 $sales_dues_tbl = '<div  id="print_table" style="color:black">
					<span class="text-center">
						<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
						<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
						<h5>'.$show_date.'</h5>
						
				</span>
				<div class="text-center">
					<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>SALES MAN WISE PARTY COVERAGE</b></h4>
				</div>
				<br>
					<table class="table table-responsive">
						<tbody>
							<tr>
								<td class="text-left">
								<h5 style="margin:0px ; margin-top: -8px;">Sales Man ID : <span></span>'.$employee_id.'</span></h5>
								<h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$emp_name.'</span></h5>
								<h5 style="margin:0px ; margin-top: -8px;">Mobile No : <span></span>'.$emp_mobile.'</span></h5>
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
									<th scope="col">Order No</th>
									<th scope="col">Shop / (Area)</th>
									<th scope="col">Delivery Man</th>
									<th scope="col">Payable</th>
									<th scope="col">Pay</th>
									<th scope="col">Due</th>
									<th scope="col">Order</th>
									<th scope="col">Delivery</th>
									</tr>
									</thead>
									<tbody>';
		$i = 0;
		
		$total_payable = 0;
		$total_pay = 0;
		$total_due = 0;
		 if ($get_order) {
			 

			 while ($row = $get_order->fetch_assoc()) {
				 $order_date = strtotime($row['order_date']);
				 if ($order_date >= $from_date &&  $order_date <= $to_date) {
					 $i++;
					

					 if ($row['due'] == 0) {
						$pay =  '<span class="badge bg-green">Paid</span>';
					 }else{
						$pay =  $row['due'];
					 }
					 $sales_dues_tbl .= ' <tr align="left" style="color:black">
											<td>'.$i.'</td>
											<td>'.$row['order_no'].'</td>
											<td>'.$row['shop_name'].'<br>('.$row['area'].')</td>
											<td>'.$row['delivery_employee_id'].'<br>'.$row['delivery_employee_name'].'</td>
											<td>'.$row['payable_amt'].'</td>
											<td>'.$row['pay'].'</td>
											<td>'.$pay.'</td>
											<td>'.$row['order_date'].'</td>
											<td>'.$row['delivery_date'].'</td>
										</tr>';
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
									<td colspan="9"  align="center" style="color:red">No Order Found</td>
								</tr>';
			 
			}else{
				$sales_dues_tbl .= '<tr class="bg-success">
									<td colspan="4"  align="right" style="color:red">Total</td>
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

	 }else if ($report_type == 'delivery_man_wise_sales') {
		$query = "SELECT * FROM employee_main_info where id_no = '$deliv_employee_id'";
		$get_emp = $dbOb->select($query);
		$emp = '';
		if ($get_emp) {
			$emp = $get_emp->fetch_assoc();
		}
		$emp_name = $emp['name'];
		$emp_mobile = $emp['mobile_no'];
		
		$query = "SELECT * FROM `order_delivery` WHERE delivery_employee_id = '$deliv_employee_id'" ;
		 $get_order = $dbOb->select($query);

		 $sales_dues_tbl = '<div  id="print_table" style="color:black">
		 <span class="text-center">
			 <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
			 <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
			 <h5>'.$show_date.'</h5>
			 
	 </span>
	 <div class="text-center">
		 <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>DELIVERY MAN WISE SALES</b></h4>
	 </div>
	 <br>
		 <table class="table table-responsive">
			 <tbody>
				 <tr>
					 <td class="text-left">
					 <h5 style="margin:0px ; margin-top: -8px;">Delivery Man ID : <span></span>'.$deliv_employee_id.'</span></h5>
					 <h5 style="margin:0px ; margin-top: -8px;">Name : <span></span>'.$emp_name.'</span></h5>
					 <h5 style="margin:0px ; margin-top: -8px;">Mobile No : <span></span>'.$emp_mobile.'</span></h5>
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
						  <th scope="col">Order No</th>
						  <th scope="col">Shop / (Area)</th>
						  <th scope="col">Sales Man</th>
						  <th scope="col">Payable</th>
						  <th scope="col">Pay</th>
						  <th scope="col">Due</th>
						  <th scope="col">Order</th>
						  <th scope="col">Delivery</th>
						</tr>
						  </thead>
						  <tbody>';
		$i = 0;
		
		$total_payable = 0;
		$total_pay = 0;
		$total_due = 0;
		 if ($get_order) {
			 

			 while ($row = $get_order->fetch_assoc()) {
				 $order_date = strtotime($row['order_date']);
				 if ($order_date >= $from_date &&  $order_date <= $to_date) {
					 $i++;
					

					 if ($row['due'] == 0) {
						$pay =  '<span class="badge bg-green">Paid</span>';
					 }else{
						$pay =  $row['due'];
					 }
					 $sales_dues_tbl .= ' <tr align="left" style="color:black">
											<td>'.$i.'</td>
											<td>'.$row['order_no'].'</td>
											<td>'.$row['shop_name'].'<br>('.$row['area'].')</td>
											<td>'.$row['order_employee_id'].'<br>'.$row['order_employee_name'].'</td>
											<td>'.$row['payable_amt'].'</td>
											<td>'.$row['pay'].'</td>
											<td>'.$pay.'</td>
											<td>'.$row['order_date'].'</td>
											<td>'.$row['delivery_date'].'</td>
										</tr>';
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
									<td colspan="9"  align="center" style="color:red">No Order Found</td>
								</tr>';
			 
			}else{
				$sales_dues_tbl .= '<tr class="bg-success">
									<td colspan="4"  align="right" style="color:red">Total</td>
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

	 }else if ($report_type == 'sales_summery') {


			$net_total_payable = 0 ;
		$zone_name = "";
			if (Session::get("zone_serial_no")){
                if (Session::get("zone_serial_no") != '-1') {
                	$zone_serial = Session::get("zone_serial_no");
                	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial'";
                	$get_zone = $dbOb->find($query);
                	$zone_name = $get_zone['zone_name'];
                }
            }else{
            		$zone_name = "All Zone";
            }
				$i = 0;
				$emp_id = '';
				$emp_name = '';
				$sales_dues_tbl = '<div  id="print_table" style="color:black">
				<span class="text-center">
					<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
					<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
					<h5>'.$show_date.'</h5>
					
			</span>
			<div class="text-center">
				<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>ALL SALES MAN\'S SALE SUMMERY</b></h4>
			</div>
			<br>
				<table class="table table-responsive">
					<tbody>
						<tr>
							<td class="text-left">
							<h5 style="margin:0px ; margin-top: -8px;">Zone Name : <span></span>'.$zone_name.'</span></h5>
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
								 <th scope="col">Sales Man\'s ID</th>
								 <th scope="col">Sales Man\'s Name</th>
								 <th scope="col">Sale Amount (Payable)</th>
								 <th scope="col">Paid</th>
								 <th scope="col">Due</th>
							   </tr>
								 </thead>
								 <tbody>';

	            $query = "SELECT  DISTINCT order_employee_id FROM `order_delivery`" ;
				$get_emp = $dbOb->select($query);
				if ($get_emp) {
					while ($emp = $get_emp->fetch_assoc()) {
						
						$total_payable = 0;
						$total_pay = 0;
						$total_due = 0;
						$emp_id = $emp['order_employee_id'];

						if (Session::get("zone_serial_no")){
			                if (Session::get("zone_serial_no") != '-1') {
			                	$zone_serial = Session::get("zone_serial_no");
								$query = "SELECT * FROM order_delivery WHERE order_employee_id = '$emp_id' AND  zone_serial_no = '$zone_serial' " ;
			                }
			            }else{
							$query = "SELECT * FROM order_delivery WHERE order_employee_id = '$emp_id'";
			            }


						$emp_name = '';
						$get_orders = $dbOb->select($query);
						if ($get_orders) {
							while ($row = $get_orders->fetch_assoc()) {
								$delivery_date = strtotime($row['delivery_date']);
								if ($delivery_date >= $from_date &&  $delivery_date <= $to_date) {
									$total_payable += $row['payable_amt'];
									$total_pay += $row['pay'];
									$total_due += $row['due'];
									$emp_name = $row['order_employee_name'];
								}
							}
						}
						if ($total_payable > 0) {
							$net_total_payable += $total_payable ;
							$sales_dues_tbl .= ' <tr align="left" style="color:black">
											<td>'.++$i.'</td>
											<td>'.$emp_id.'</td>
											<td>'.$emp_name.'</td>
											<td>'.$total_payable.'</td>
											<td>'.$total_pay.'</td>
											<td>'.$total_due.'</td>
										</tr>';
							
						}

					} //end of getting employee
				}

				if ($i == 0) {
					$sales_dues_tbl .= '<tr>
										   <td colspan="6"  align="center" style="color:red">No Record Found</td>
									   </tr>';
				   }else{
					$sales_dues_tbl .= ' <tr style="color:red" class="bg-success">
											<td align="right"  colspan="5">Total Amount</td>
											<td>'.$net_total_payable.'</td>
										</tr>';

				   }

				$sales_dues_tbl .= '  </tbody>
										</table>';
		 		$sales_dues_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
                
		 </div>';
		 echo json_encode($sales_dues_tbl);
		// die();
				

			//end of all employee 
			//  start of individual employee report
		

	 }



 
 	
}
 ?>