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
include_once("class/Database.php");
$dbOb = new Database();

if (isset($_POST['id'])) {
	$employee_id = $_POST['id'];
	$query = "SELECT * FROM employee_main_info WHERE id_no = '$employee_id'";
	$get_emp_info = $dbOb->find($query);

	echo json_encode($get_emp_info);
}
if (isset($_POST['reg_no'])) {
	$vehicle_reg_no = $_POST['reg_no'];
	$get_vehicle='';

	$query = "SELECT * FROM truck_load WHERE vehicle_reg_no = '$vehicle_reg_no' AND unload_status = '0'";
	$get_unload_status = $dbOb->select($query);
	$message = '';
	$type = '';
	if ($get_unload_status) {
		$message = "Please Unload The Truck First..";
		$type = "warning";
		// die();
	}else{
		$query = "SELECT * FROM transport WHERE reg_no = '$vehicle_reg_no'";
		$get_vehicle = $dbOb->find($query);
	}

	echo json_encode(['message'=>$message,'type'=>$type,'get_vehicle'=>$get_vehicle]);
}


// inserting data into data base 

if (isset($_POST['submit'])) {

	$zone_serial_no= validation($_POST['zone_serial_no']);
	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
	$get_zone = $dbOb->select($query);
	$zone_name = '';
	if ($get_zone) {
		$zone_name = validation($get_zone->fetch_assoc()['zone_name']);
	}

	$area_name= validation($_POST['area_employee']);

	$ware_house_serial_no= validation($_POST['ware_house_serial_no']);
	$ware_house_name= '';
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_ware_house  = $dbOb->select($query);
	if ($get_ware_house) {
		$ware_house_name = validation($get_ware_house->fetch_assoc()['ware_house_name']);
	}

	$employee_id = validation($_POST['delivery_employee_id']);
	$emplyee_name =  "";
	$query = "SELECT * FROM employee_main_info WHERE id_no = '$employee_id'";
	$get_emp = $dbOb->select($query);
	if ($get_emp) {
		$emplyee_name = $get_emp->fetch_assoc()['name'];
	}
	$query = "SELECT * FROM truck_load WHERE employee_id = '$employee_id' AND unload_status = 0 ";
	$get_duplicate = $dbOb->select($query);
	if ($get_duplicate) {
		$message = $emplyee_name.", Is Already Assigned With Vehicle: ".$get_duplicate->fetch_assoc()['vehicle_name'].' . Please Unload It First';
		$type = 'warning';
		die(json_encode(['message'=>$message,'type'=>$type]));
	}
	$vehicle_reg_no = validation($_POST['vehicle_reg_no']);
	$vehicle_name= validation($_POST['vehicle_name']);
	$vehicle_type= validation($_POST['vehicle_type']);
	$loading_date= validation($_POST['loading_date']);

	$product_id= validation($_POST['product_id']);
	$products_name = validation($_POST['products_name']);
	$category = validation($_POST['category']);
	$quantity = validation($_POST['quantity']);
	$quantity_offer = validation($_POST['quantity_offer']);

	
	$query = "INSERT INTO truck_load 
			  (zone_serial_no, zone_name, area_name, ware_house_serial_no, ware_house_name, employee_id, emplyee_name, vehicle_reg_no, vehicle_name, vehicle_type, loading_date) 
			  VALUES 
			  ('$zone_serial_no', '$zone_name', '$area_name', '$ware_house_serial_no', '$ware_house_name', '$employee_id', '$emplyee_name', '$vehicle_reg_no', '$vehicle_name', '$vehicle_type', '$loading_date') ";
    $main_tbl_last_insert_id = $dbOb->custom_insert($query);

    if ($main_tbl_last_insert_id) {

    	for ($i=0; $i <count($product_id) ; $i++) { 
    		$id = $product_id[$i];
    		$name = $products_name[$i];
    		$cat = $category[$i];
    		$qty = $quantity[$i];
    		$qty_offer = $quantity_offer[$i];
			if ($qty != '') {
				$query ="INSERT INTO truck_loaded_products 
				  (truck_load_tbl_id, product_id, products_name, category, quantity,quantity_offer) 
				  VALUES 
				  ('$main_tbl_last_insert_id', '$id', '$name', '$cat', '$qty','$qty_offer') ";
	
				$insert_lad_product = $dbOb->insert($query);
			}

    	}

    	if ($insert_lad_product) {
    		$message = "Truck Loaded Successfully";
    		$type = 'success';
    		echo json_encode(['message'=>$message,'type'=>$type]);
    	}else{
    		$message = "Truck Loaded Failed";
    		$type = 'warning';
    		echo json_encode(['message'=>$message,'type'=>$type]);

    	}
    }
}
	if (isset($_POST['product_id_check'])) {
		$products_id = $_POST['product_id_check'];
		
		$query = "SELECT * FROM `offers` WHERE products_id = '$products_id' ORDER BY serial_no DESC LIMIT 1";
		$get_offer = $dbOb->select($query);
		$offer_qty = 0;
		
		if ($get_offer) {
			$offer = $get_offer->fetch_assoc();
			if (strtotime(date('d-m-Y')) <= strtotime($offer['to_date']) && $offer['status'] == 1) {
				die(json_encode($offer));
			}else{
				die(json_encode("N/A"));
			}
		}else{
			die(json_encode("N/A"));
		}

	}
 ?>