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
	$order_employee_id = $_POST['order_employee_id'];

	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$get_products = $dbOb->find($query);
	$today = date("d-m-Y");
	$offer = "";

	if (strtotime($get_products['offer_start_date']) <= strtotime($today) && strtotime($get_products['offer_end_date']) >= strtotime($today)) {
		$offer = $get_products['promo_offer'];
	} else {
		$offer = "----";
	}

	echo json_encode(['products' => $get_products, 'offer' => $offer]);
}

// now we are going to add information

// now we are going to add data into database

if (isset($_POST['submit'])) {

	$employee_id = $_POST['employee_id'];
	$employee_name = $_POST['employee_name'];
	$area_employee = $_POST['area_employee'];
	$employee_company = $_POST['employee_company'];

	$order_no = $_POST['order_no'];

	$cust_id = $_POST['cust_id'];
	$customer_name = $_POST['customer_name'];
	$shop_name = $_POST['shop_name'];
	$address = $_POST['address'];
	$mobile_no = $_POST['mobile_no'];

	$products_id_no = $_POST['products_id_no'];
	$products_name = $_POST['products_name'];
	$pack_size = $_POST['pack_size'];
	$unit_tp = $_POST['unit_tp'];
	$unit_vat = $_POST['unit_vat'];
	$tp_plus_vat = $_POST['tp_plus_vat'];
	$qty = $_POST['qty'];
	$total_tp = $_POST['total_tp'];
	$total_vat = $_POST['total_vat'];
	$total_price = $_POST['total_price'];

	$net_total = $_POST['net_total'];
	$net_total_tp = $_POST['net_total_tp'];
	$net_total_vat = $_POST['net_total_vat'];
	$discount_on_tp = $_POST['discount'];
	$discount_amount = $_POST['discount_amount'];
	$payable_without_extra_discount = $_POST['payable_amt'];
	$extra_discount = $_POST['extra_discount'];
	$payable_amt = $_POST['net_payable_amt'];
	// $pay              = $_POST['pay'];
	$order_date = $_POST['date'];

	//          $message = $products_id_no;
	// $type = 'warning';

	// echo json_encode(['message'=>$message,'type'=>$type]);
	// die();

	

	$query = "INSERT INTO  new_order_details

			(employee_id,employee_name,area_employee,company,order_no,cust_id,customer_name,shop_name,address,mobile_no,discount_on_tp,discount_amount,payable_without_extra_discount,extra_discount,payable_amt,pay,due,order_date,delivery_report,delivery_cancel_report,net_total,net_total_tp,net_total_vat)

			VALUES

			('$employee_id','$employee_name','$area_employee','$employee_company','$order_no','$cust_id','$customer_name','$shop_name','$address','$mobile_no','$discount_on_tp','$discount_amount','$payable_without_extra_discount','$extra_discount','$payable_amt','0','$payable_amt','$order_date','0','0','$net_total','$net_total_tp','$net_total_vat')";

	$last_id = $dbOb->custom_insert($query);
	$insert_order_expense = '';

	if ($last_id) {
		for ($i = 0; $i < count($products_id_no); $i++) {

			$prod_id = $products_id_no[$i];
			$query = "SELECT * FROM products where products_id_no = '$prod_id'";
			$purchase_price = $dbOb->find($query)['company_price'] * $qty[$i];

			$discount_tp = ($total_tp[$i] * $discount_on_tp / 100);
			$sell_price = $total_price[$i] - $discount_tp;
			$sell_price = round(($sell_price - ($sell_price * $extra_discount / 100)), 2);

			$query = "INSERT INTO  new_order_expense
					(new_order_serial_no,products_id_no,products_name,pack_size,unit_tp,unit_vat,tp_plus_vat,quantity,total_tp,total_vat,total_price,purchase_price,sell_price)
					VALUES
					('$last_id','$products_id_no[$i]','$products_name[$i]','$pack_size[$i]','$unit_tp[$i]','$unit_vat[$i]','$tp_plus_vat[$i]','$qty[$i]','$total_tp[$i]','$total_vat[$i]','$total_price[$i]','$purchase_price','$sell_price')";
			$insert_order_expense = $dbOb->insert($query);

			// 		          $message = $products_id_no[$i];
			// $type = 'warning';

			// echo json_encode(['message'=>$message,'type'=>$type]);
			// die();

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

} // end of  if (isset($_POST['submit']))

if (isset($_POST['customer_id'])) {
	$cust_id = $_POST['customer_id'];
	$query = "SELECT * FROM client WHERE cust_id = '$cust_id'";
	$get_cust = $dbOb->select($query);
	if ($get_cust) {
		$data = $get_cust->fetch_assoc();
	}

	
	echo json_encode($data);
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