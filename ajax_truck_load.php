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


// changing area and getting the product quantity to be loaded



// inserting data into data base 

if (isset($_POST['submit'])) {
	$deliv_emp_id = $_POST['deliv_emp_id'];
	$deliv_emp_name = $_POST['deliv_emp_name'];
	$deliv_emp_phone = $_POST['deliv_emp_phone'];
	$area = $_POST['area'];
	$summery_id = $_POST['summery_id'];

	// die($summery_id);
	
	$printing_date = $_POST['printing_date'];
	$time = $_POST['time'];

	$vehicle_reg_no = $_POST['vehicle_reg_no'];
	$vehicle_name = $_POST['vehicle_name'];
	$driver_name = $_POST['driver_name'];

	$total_payable_amt = $_POST['total_payable_amt'];
	
	$product_id = $_POST['product_id'];
	$product_name = $_POST['product_name'];
	$category = $_POST['category'];
	$quantity = $_POST['quantity'];

	$order_no = $_POST['order_no'];
	$shop_name = $_POST['shop_name'];
	$customer_name = $_POST['customer_name'];
	$mobile_no = $_POST['mobile_no'];
	$payable_amt = $_POST['payable_amt'];
	$insert_shop = "";
	if ($total_payable_amt != '') {
		$query = "INSERT INTO order_summery 
				  (summery_id,deliv_emp_id,deliv_emp_name,deliv_emp_phone,area,printing_date,printing_time,total_payable_amt,vehicle_reg_no,vehicle_name,driver_name)
				  VALUES
				  ('$summery_id','$deliv_emp_id','$deliv_emp_name','$deliv_emp_phone','$area','$printing_date','$time','$total_payable_amt','$vehicle_reg_no','$vehicle_name','$driver_name')";

		$summery_serial_no = $dbOb->custom_insert($query);

		if ($summery_serial_no) {
			for ($i=0; $i < count($product_id); $i++) { 
				$pr_id = $product_id[$i];
				$pr_name = $product_name[$i];
				$cat = $category[$i];
				$qty = $quantity[$i];
				
				$query = "INSERT INTO order_summery_product_info 
						 (summery_serial_no,summery_id,product_id,product_name,category,quantity)
						 VALUES
						 ('$summery_serial_no','$summery_id','$pr_id','$pr_name','$cat','$qty')";
				$insert_product = $dbOb->insert($query);
			}

			if ($insert_product) {
				for ($i=0; $i < count($order_no); $i++) { 
					$ord_no = $order_no[$i];
					$shp_name = $shop_name[$i];
					$cust_name = $customer_name[$i];
					$mob_no = $mobile_no[$i];
					$pbl_amt = $payable_amt[$i];
					
					$query = "INSERT INTO  order_summery_shop_info 
							 (summery_serial_no,summery_id,order_no,shop_name,customer_name,mobile_no,payable_amt,vehicle_reg_no,vehicle_name,driver_name)
							 VALUES
							 ('$summery_serial_no','$summery_id','$ord_no','$shp_name','$cust_name','$mob_no','$pbl_amt','$vehicle_reg_no','$vehicle_name','$driver_name')";
					$insert_shop = $dbOb->insert($query);
				}
			}
		}
	}

	if ($insert_shop) {
		die(json_encode("inserted"));
	}


}

 ?>