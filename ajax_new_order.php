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

//echo $office_organization_name;

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
	echo json_encode($data);
}

if (isset($_POST['emp_id'])) {
	$emp_id = $_POST['emp_id'];
	$query = "SELECT * FROM employee_main_info WHERE id_no = '$emp_id'";
	$employee = $dbOb->select($query);
	if ($employee) {
		$data = $employee->fetch_assoc()['name'];
	}
	echo json_encode($data);
}

?>