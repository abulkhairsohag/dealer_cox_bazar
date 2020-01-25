<?php
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once "class/Session.php";
include_once 'helper/helper.php';
include_once 'class/Database.php';

Session::init();
Session::checkSession();
error_reporting(1);
$dbOb = new Database();

if (isset($_POST['products_id_no_get_info'])) {
	$products_id_no = $_POST['products_id_no_get_info'];
	$vehicle_reg_no = $_POST['vehicle_reg_no_get_info'];

	if ($vehicle_reg_no == "") {
		$message = "Please Select A Delivery Man Who Is Assigned With A Truck That Is Not Unloaded.";
		$type = 'warning';
		die(json_encode(['message'=>$message, 'type'=>$type]));
	}

	$query = "SELECT * FROM truck_load WHERE vehicle_reg_no = '$vehicle_reg_no' AND unload_status = 0";
	$get_load_info = $dbOb->select($query);

	if ($get_load_info) {
		$load = $get_load_info->fetch_assoc();
		$load_serial_no = $load['serial_no'];
		$query = "SELECT * FROM truck_loaded_products WHERE truck_load_tbl_id = '$load_serial_no' AND product_id = '$products_id_no'";
		$get_product_existance = $dbOb->select($query);
		if ($get_product_existance) {
			$load_qty = $get_product_existance->fetch_assoc()['quantity'];
			$delivered_qty = get_truck_load_qty($products_id_no, $load_serial_no);
			$remaining_qty = $load_qty - $delivered_qty;
			$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
			$get_products = $dbOb->find($query);
			$query = "SELECT * FROM offers WHERE products_id = '$products_id_no' AND status = '1' ";
			$get_offer  = $dbOb->select($query);
			if ($get_offer) {
				$offer = $get_offer->fetch_assoc();
				$offer_pack = $offer['packet_qty'];
				$offer_product = $offer['product_qty'];
				$offer_product_with_unit_packet = $offer_product/$offer_pack;
				$pack_size = $get_products['pack_size'];
				$new_pack_size = $pack_size*1 + $offer_product_with_unit_packet*1 ;
				$original_sell_price = $get_products['sell_price'];
				$new_sell_p_unit = $original_sell_price /$new_pack_size;
				// round($product_sell_profit,3)
				$new_packet_sell_price = round(($new_sell_p_unit*$pack_size),2);
				
			}else{
				$new_packet_sell_price = $get_products['sell_price'];
				$original_sell_price = $get_products['sell_price'];
			}
			die(json_encode(['products' => $get_products, 'load_qty' => $remaining_qty,'sell_price'=>$new_packet_sell_price,'original_sell_price'=>$original_sell_price]));
		}else {
			$message = "Sorry This Product Is Not Loaded In The Truck.";
			$type = 'warning';
			die(json_encode(['message'=>$message, 'type'=>$type]));
		}
		
	}

}

// now we are going to add information

// now we are going to add data into database

if (isset($_POST['submit'])) {

	$order_employee_id = validation($_POST['order_employee_id']);
	$order_employee_name = validation($_POST['order_employee_name']);
	$delivery_employee_id = validation($_POST['delivery_employee_id']);
	$delivery_employee_name = validation($_POST['delivery_employee_name']);
	$order_no = validation($_POST['order_no']);

	$vehicle_reg_no = validation($_POST['vehicle_reg_no']);
	$vehicle_name = validation($_POST['vehicle_name']);
	$truck_load_serial_no = validation($_POST['truck_load_serial_no']);
	$ware_house_serial_no = validation($_POST['ware_house_serial_no']);
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'"; 
	$get_ware_house = $dbOb->select($query);
	$ware_house_name = "";
	if ($get_ware_house) {
		$ware_house_name = validation($get_ware_house->fetch_assoc()['ware_house_name']);
	}

	$zone_serial_no = validation($_POST['zone_serial_no']);
	$zone_name =  "";
	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'"; 
	$get_zone = $dbOb->select($query);
	if ($get_zone) {
		$zone_name = validation($get_zone->fetch_assoc()['zone_name']);
	}
	$area = validation($_POST['area_employee']);
	$cust_id = validation($_POST['cust_id']);
	$customer_name = validation($_POST['customer_name']);
	$shop_name = validation($_POST['shop_name']);
	$address = validation($_POST['address']);
	$mobile_no = validation($_POST['mobile_no']);
	$delivery_date = validation($_POST['date']);
	$payable_amt = validation($_POST['net_payable_amt']);

	$pay = validation($_POST['pay']);
	$due = validation($_POST['due']);

	$products_id_no = validation($_POST['products_id_no']);
	$products_name = validation($_POST['products_name']);
	$sell_price = validation($_POST['sell_price']);

	$qty = validation($_POST['qty']);
	$offer_qty = validation($_POST['offer_qty']);
	$total_price = validation($_POST['total_price']);
	
	$query = "INSERT INTO  order_delivery

	(order_employee_id,order_employee_name,delivery_employee_id,delivery_employee_name,order_no,vehicle_reg_no,vehicle_name,truck_load_serial_no,ware_house_serial_no,ware_house_name,zone_serial_no,zone_name,area,cust_id,customer_name,shop_name,address,mobile_no,payable_amt,pay,due,delivery_date)

	VALUES

	('$order_employee_id','$order_employee_name','$delivery_employee_id','$delivery_employee_name','$order_no','$vehicle_reg_no','$vehicle_name','$truck_load_serial_no','$ware_house_serial_no','$ware_house_name','$zone_serial_no','$zone_name','$area','$cust_id','$customer_name','$shop_name','$address','$mobile_no','$payable_amt','$pay','$due','$delivery_date')";

	$last_id = $dbOb->custom_insert($query);
	$insert_order_expense = '';

	if ($last_id) {
		for ($i = 0; $i < count($products_id_no); $i++) {

			$prod_id = $products_id_no[$i];
			$query = "SELECT * FROM products where products_id_no = '$prod_id'";
			$product = $dbOb->find($query);
			$purchase_price = $product['company_price'] * $qty[$i];
			$available_qty = $product['quantity'] ;

			$query = "SELECT * FROM offers WHERE products_id = '$prod_id' AND status = '1'";
			$get_offer = $dbOb->select($query);
			if ($get_offer) {
				$offer = 1;
			}else{
				$offer = 0;
			}

			$query = "INSERT INTO  order_delivery_expense
			(delivery_tbl_serial_no,products_id_no,products_name,sell_price,qty,offer_qty,total_price,purchase_price,ware_house_serial_no,truck_load_serial_no,zone_serial_no,vehicle_reg_no,order_employee_id,delivery_employee_id,delivery_date,offer)
			VALUES
			('$last_id','$products_id_no[$i]','$products_name[$i]','$sell_price[$i]','$qty[$i]','$offer_qty[$i]','$total_price[$i]','$purchase_price','$ware_house_serial_no','$truck_load_serial_no','$zone_serial_no','$vehicle_reg_no','$order_employee_id','$delivery_employee_id','$delivery_date','$offer')";
			$insert_order_expense = $dbOb->insert($query);
			if ($insert_order_expense) {
				$update_qty = $available_qty - $qty[$i];
				$query = "UPDATE products SET quantity = '$update_qty' WHERE products_id_no = '$prod_id'";
				$update_product_tbl = $dbOb->update($query);
			}
		}

		if ($insert_order_expense) {
			$query = "INSERT INTO delivered_order_payment_history 
			(deliver_order_serial_no,delivery_emp_id,pay_amt,date,zone_serial_no)
			VALUES
			('$last_id','$delivery_employee_id','$pay','$delivery_date','$zone_serial_no')";
			$insert_history = $dbOb->insert($query);
			$message = "Congratulaiton! Order Is Successfully Saved.";
			$type = "success";
			echo json_encode(['message' => $message, 'type' => $type]);
		}else {
			$message = "Sorry! Order Is Not Saved.";
			$type = "warning";
			echo json_encode(['message' => $message, 'type' => $type]);

		}
	}else {
		$message = "Sorry! Information Is Not Saved.";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);

	}
	die();
} // end of  if (isset($_POST['submit']))

if (isset($_POST['customer_id'])) {
	$cust_id = $_POST['customer_id'];
	$query = "SELECT * FROM client WHERE cust_id = '$cust_id'";
	$get_cust = $dbOb->select($query);
	if ($get_cust) {
		$data = $get_cust->fetch_assoc();
	}
	echo json_encode($data);
	die();
}



if (isset($_POST['area_name'])) {
	$area_name = validation($_POST['area_name']);
	$query = "SELECT * FROM client WHERE area_name = '$area_name' order by organization_name asc";
	$get_cust = $dbOb->select($query);
	if ($get_cust) {
		$data = '<option value="">Please Select One</option>';
		while ($row = $get_cust->fetch_assoc()) {
			$data .= ' <option value="' . $row['cust_id'] . '">' . $row['organization_name'] . '</option>';
		}
	} else {
		$data = '<option value="">Customer Not Available In This Area</option>';
	}

	Session::set("area_employee",$area_name);
	Session::set("customer_options",$data);
	
	echo json_encode($data);
}

// getting delivery mans info 
if (isset($_POST['delivery_emp_id'])) {
	$delivery_emp_id = $_POST['delivery_emp_id'];
	$query = "SELECT * FROM delivery_employee WHERE id_no = '$delivery_emp_id'";
	$employee = $dbOb->select($query);
	if ($employee) {
		$data = $employee->fetch_assoc()['name'];
	}
	Session::set("delivery_emp_id",$delivery_emp_id);
	Session::set("delivery_employee_name",$data);

	$query = "SELECT * FROM truck_load WHERE employee_id ='$delivery_emp_id' AND unload_status = 0";
	$get_vehicle = $dbOb->select($query);
	$vehicle = "";
	if ($get_vehicle) {
		$vehicle = $get_vehicle->fetch_assoc();
		$zone_serial_no = $vehicle['zone_serial_no'];
		$query = "SELECT * FROM area_zone WHERE zone_serial_no = '$zone_serial_no'";
		$get_area = $dbOb->select($query);
		$area = '<option value="">Please Select One ...</option>';
		if ($get_area) {
			while ($row = $get_area->fetch_assoc()) {
				$area .= '<option value="'.$row['area_name'].'">'.$row['area_name'].'</option>';
			}
		}
	}else{
		$message = "Please Assign ".$data.', With A Vehicle Then Take Order.. ';
		$type = 'warning';
		die(json_encode(['message'=>$message,'type'=>$type]));
	}

	echo json_encode(['delivery_emp_name'=>$data,'vehicle'=>$vehicle,'area'=>$area]);
}

if (isset($_POST['order_emp_id'])) {
	$order_emp_id = $_POST['order_emp_id'];
	$query = "SELECT * FROM employee_duty WHERE id_no = '$order_emp_id'";
	$employee = $dbOb->select($query);
	if ($employee) {
		$data = $employee->fetch_assoc()['name'];
	}
	Session::set("order_emp_id",$order_emp_id);
	Session::set("order_employee_name",$data);
	echo json_encode($data);
}

if (isset($_POST['zone_serial_no'])) {
	$zone_serial_no = $_POST['zone_serial_no'];
	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
	$zone = $dbOb->select($query);
	$zone_name = "";
	if ($zone) {
		$zone_name = $zone->fetch_assoc()['zone_name'];
	}
	// Session::set("zone_name",$zone_name);
	// Session::set("zone_serial_no",$zone_serial_no);
	
	$query = "SELECT * from area_zone WHERE zone_serial_no = '$zone_serial_no'";
	$get_all_area = $dbOb->select($query);
	if ($get_all_area) {
		$area_options = '<option value="">Please Select One</option>';
		while ($row = $get_all_area->fetch_assoc()) {
			$area_options .= '<option value="'.$row["area_name"].'">'.$row['area_name'].'</option>';
		}
	}else{
		$area_options = '<option value="">Area Not Assigned In This Zone</option>';
	}
	Session::set("area_options",$area_options);
	Session::set("customer_options",'');

	die(json_encode(['zone_name'=>$zone_name,'area_options'=>$area_options]));
}


if (isset($_POST['ware_house_serial_no'])) {
	Session::set("ware_house_serial_no",$_POST['ware_house_serial_no']);
	die();
}


if (isset($_POST['send_area_and_customer'])) {
	
	$customer_id = Session::get("customer_id");
	$delivery_emp_id = Session::get("delivery_emp_id");
	$query = "SELECT * FROM truck_load WHERE employee_id ='$delivery_emp_id' AND unload_status = 0";
	$get_vehicle = $dbOb->select($query);
	$vehicle = "";
	$area = '<option value="">Please Select One ...</option>';
	if ($get_vehicle) {
		$vehicle = $get_vehicle->fetch_assoc();
		$zone_serial_no = $vehicle['zone_serial_no'];
		$query = "SELECT * FROM area_zone WHERE zone_serial_no = '$zone_serial_no'";
		$get_area = $dbOb->select($query);
		if ($get_area) {
			while ($row = $get_area->fetch_assoc()) {
				$area .= '<option value="'.$row['area_name'].'">'.$row['area_name'].'</option>';
			}
		}
	}
	echo json_encode(['area'=>$area,'customer_id'=>$customer_id,'vehicle'=>$vehicle]);
}
?>