<?php
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once "class/Session.php";
Session::init();
Session::checkSession();
error_reporting(1);
include_once 'helper/helper.php';
?>

<?php

include_once 'class/Database.php';
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
			$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
			$get_products = $dbOb->find($query);
			die(json_encode(['products' => $get_products, 'load_qty' => $load_qty]));
		}else {
			$message = "Sorry This Product Is Not Loaded In The Truck.";
			$type = 'warning';
			die(json_encode(['message'=>$message, 'type'=>$type]));
		}
		
	}

	
	// $offer = "";


	// echo json_encode(['products' => $get_products, 'offer' => $offer]);
}

// now we are going to add information

// now we are going to add data into database

if (isset($_POST['submit'])) {

	$order_employee_id = $_POST['order_employee_id'];
	$order_employee_name = $_POST['order_employee_name'];
	$delivery_employee_id = $_POST['delivery_employee_id'];
	$delivery_employee_name = $_POST['delivery_employee_name'];
	$order_no = $_POST['order_no'];

	$vehicle_reg_no = $_POST['vehicle_reg_no'];
	$vehicle_name = $_POST['vehicle_name'];
	$truck_load_serial_no = $_POST['truck_load_serial_no'];
	$ware_house_serial_no = $_POST['ware_house_serial_no'];
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'"; 
	$get_ware_house = $dbOb->select($query);
	$ware_house_name = "";
	if ($get_ware_house) {
		$ware_house_name = $get_ware_house->fetch_assoc()['ware_house_name'];
	}

	$zone_serial_no = $_POST['zone_serial_no'];
	$zone_name =  "";
	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'"; 
	$get_zone = $dbOb->select($query);
	if ($get_zone) {
		$zone_name = $get_zone->fetch_assoc()['zone_name'];
	}
	$area = $_POST['area_employee'];
	$cust_id = $_POST['cust_id'];
	$customer_name = $_POST['customer_name'];
	$shop_name = $_POST['shop_name'];
	$address = $_POST['address'];
	$mobile_no = $_POST['mobile_no'];
	$delivery_date = $_POST['date'];
	$payable_amt = $_POST['net_payable_amt'];

	$pay = $_POST['pay'];
	$due = $_POST['due'];

	$products_id_no = $_POST['products_id_no'];
	$products_name = $_POST['products_name'];
	$qty = $_POST['qty'];
	$offer_qty = $_POST['offer_qty'];
	$total_price = $_POST['total_price'];
	
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

	

			$query = "INSERT INTO  order_delivery_expense
					(delivery_tbl_serial_no,products_id_no,products_name,qty,offer_qty,total_price,purchase_price,ware_house_serial_no,truck_load_serial_no,zone_serial_no,vehicle_reg_no,order_employee_id,delivery_employee_id,delivery_date)
					VALUES
					('$last_id','$products_id_no[$i]','$products_name[$i]','$qty[$i]','$offer_qty[$i]','$total_price[$i]','$purchase_price','$ware_house_serial_no','$truck_load_serial_no','$zone_serial_no','$vehicle_reg_no','$order_employee_id','$delivery_employee_id','$delivery_date')";
			$insert_order_expense = $dbOb->insert($query);
			if ($insert_order_expense) {
				$update_qty = $available_qty - $qty[$i];
				$query = "UPDATE products SET quantity = '$update_qty' WHERE products_id_no = '$prod_id'";
				$update_product_tbl = $dbOb->update($query);
			}
		}

		if ($insert_order_expense) {

			$message = "Congratulaiton! Order Is Successfully Saved.";
			$type = "success";
			echo json_encode(['message' => $message, 'type' => $type]);
		} else {
			$message = "Sorry! Order Is Not Saved.";
			$type = "warning";
			echo json_encode(['message' => $message, 'type' => $type]);

		}
	} else {
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
	$area_name = $_POST['area_name'];
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
	}else{
		$message = "Please Assign ".$data.', With A Vehicle Then Take Order.. ';
		$type = 'warning';
		die(json_encode(['message'=>$message,'type'=>$type]));
	}

	echo json_encode(['delivery_emp_name'=>$data,'vehicle'=>$vehicle]);
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
	Session::set("zone_serial_no",$zone_serial_no);
	Session::set("zone_name",$zone_name);
	
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
	$area = Session::get("area_employee");
	$customer_id = Session::get("customer_id");
	$delivery_emp_id = Session::get("delivery_emp_id");
	$query = "SELECT * FROM truck_load WHERE employee_id ='$delivery_emp_id' AND unload_status = 0";
	$get_vehicle = $dbOb->select($query);
	$vehicle = "";
	if ($get_vehicle) {
		$vehicle = $get_vehicle->fetch_assoc();
	}
	echo json_encode(['area'=>$area,'customer_id'=>$customer_id,'vehicle'=>$vehicle]);
}
?>