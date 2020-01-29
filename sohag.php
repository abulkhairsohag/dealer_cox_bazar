<?php 


$i = 0;


		$query = "SELECT * FROM truck_load WHERE ware_house_serial_no = '$ware_house_serial_no' AND unload_status = '1'";
		$get_load = $dbOb->select($query);

		$unload_tbl = '<div  id="print_table" style="color:black">
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
										  <th scope="col">Vehicle Reg No</th>
										  <th scope="col">Vehicle Name</th>
										  
										  <th scope="col">Sales Man</th>
										  <th scope="col">Load & Unload <br>Date</th>
										  <th scope="col">Product ID</th>
										  <th scope="col">Product Name</th>
										  <th scope="col">Loaded </th>
										  <th scope="col">Unloaded</th>
										  <th scope="col">Back</th>
										</tr>
										  </thead>
										  <tbody>';

		if ($get_load) {
			$j= 0;
			while ($load_info = $get_load->fetch_assoc()) {
				$unload_date = strtotime($load_info['unload_date']);
				if ($unload_date >= $to_date && $unload_date <= $from_date) {
					$truck_load_tbl_id = $load_info['serial_no'];
					$query = "SELECT * FROM truck_unloaded_products WHERE truck_load_tbl_id = '$truck_load_tbl_id'";
					$get_products = $dbOb->select($query);
					$i = 0 ;

					if ($get_products) {
						while ($row = $get_products->fetch_assoc()) {
							$i++;
						}
					}
					$unload_tbl .='<tr align="left" style="color:black">
											<td rowspan="'.$i.'">'.++$j.'</td>
											<td rowspan="'.$i.'">'.$load_info['vehicle_reg_no'].'</td>
											<td rowspan="'.$i.'">'.$load_info['vehicle_name'].'</td>
											<td rowspan="'.$i.'">'.$load_info["employee_id"].'<br>'.$load_info["emplyee_name"]'</td>
											<td rowspan="'.$i.'">'.$load_info["loading_date"].'<br>'.$load_info["unload_date"]'</td>';
					if ($get_products) {
						while ($row = $get_products->fetch_assoc()) {
							 $unload_tbl .= '<td>'.$row['product_id'].'</td>
											<td>'.$row['products_name'].'</td>
											<td>'.$row['loaded_pcs'].'</td>
											<td>'.$row['sold_pcs'].'</td>
											<td>'.$row['back_pcs'].'</td>';
						}
					}
					$unload_tbl .= '</tr>';
				}
			}

		}
			$unload_tbl .= '  </tbody>
			</table>';
		 $unload_tbl .= '</div><div><a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a> </div>';
		echo json_encode($unload_tbl);



 ?>