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

if (isset($_POST['products_id_no_get_info'])) {
	$products_id_no = $_POST['products_id_no_get_info'];

	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$get_products = $dbOb->find($query);
	$today = date("d-m-Y");
	$offer = "";

	if (strtotime($get_products['offer_start_date']) <= strtotime($today) && strtotime($get_products['offer_end_date'])>=strtotime($today) ) {
		$offer = $get_products['promo_offer'];
	}else{
		$offer = "----";
	}
	echo json_encode(['products'=>$get_products,'offer'=>$offer]);
}

// now we are going to add information 

if (isset($_POST['submit'])) {
	//delivery employee info 
	$employee_id_delivery     = $_POST['employee_id_delivery'];
	$employee_name_delivery   = $_POST['employee_name_delivery'];
	// die($employee_id_delivery);
	$area_employee_delivery   = $_POST['area_employee_delivery'];
	$company_delivery_employee= $_POST['company_delivery_employee'];
	$delivery_date   		  = $_POST['delivery_date'];
	$delivery_month  		  = date("m-Y");

	// Order employee Info 
	$employee_id     = $_POST['employee_id'];
	$employee_name   = $_POST['employee_name'];
	$area_employee   = $_POST['area_employee'];
	$employee_company= $_POST['employee_company'];
	$order_date   	 = $_POST['date'];

	$order_no  = $_POST['order_no'];
	$cust_id = $_POST['cust_id'];
	$customer_name = $_POST['customer_name'];
	$shop_name = $_POST['shop_name'];
	$address   = $_POST['address'];
	$mobile_no = $_POST['mobile_no'];

	$products_id_no = $_POST['products_id_no'];
	$products_name  = $_POST['products_name'];
	$pack_size 		= $_POST['pack_size'];
	$unit_tp 		= $_POST['unit_tp'];
	$unit_vat 		= $_POST['unit_vat'];
	$tp_plus_vat 	= $_POST['tp_plus_vat'];
	$quantity 			= $_POST['qty'];
	$total_tp 		= $_POST['total_tp'];
	$total_vat 		= $_POST['total_vat'];
	$total_price 	= $_POST['total_price'];


	$net_total        = $_POST['net_total'];
	$net_total_tp     = $_POST['net_total_tp'];
	$net_total_vat    = $_POST['net_total_vat'];
	$discount_on_tp   = $_POST['discount'];
	$discount_amount  = $_POST['discount_amount'];
	$payable_without_extra_discount      = $_POST['payable_amt'];
	$extra_discount      = $_POST['extra_discount'];
	$payable_amt      = $_POST['net_payable_amt'];
	$pay              = $_POST['pay'];
	$due              = $_POST['due'];
	$order_tbl_serial_no = $_POST['edit_id'];
	// $query = "SELECT * FROM delivered_order_payment_history WHERE deliver_order_serial_no = ''";

	$query = "SELECT * FROM order_delivery WHERE order_tbl_serial_no = '$order_tbl_serial_no'";
	$get_deliv_info = $dbOb->select($query);
	if ($get_deliv_info) {
		$message = "Sorry! Order Is Already Delivered.";
		$type = "warning";
		$conf = 'already exist';
		// Session::set("update_message",$message);
		// Session::set("update_type",$type);
		echo json_encode(['message'=>$message,'type'=>$type,'conf'=>$conf]);
	}else{

		$query = "INSERT INTO  order_delivery

		(order_tbl_serial_no,delivery_employee_id,delivery_employee_name,order_employee_id,order_employee_name,area,company,order_no,cust_id,customer_name,shop_name,address,mobile_no, discount_on_tp, discount_amount,payable_without_extra_discount,extra_discount, payable_amt, net_total, net_total_tp, net_total_vat, pay, due ,order_date,delivery_date,delivery_month)

		VALUES

		('$order_tbl_serial_no','$employee_id_delivery','$employee_name_delivery','$employee_id','$employee_name','$area_employee','$employee_company','$order_no','$cust_id','$customer_name','$shop_name','$address','$mobile_no','$discount_on_tp','$discount_amount','$payable_without_extra_discount','$extra_discount','$payable_amt','$net_total','$net_total_tp','$net_total_vat','$pay','$due','$order_date','$delivery_date','$delivery_month')";

		$last_id =$dbOb->custom_insert($query);
		$insert_order_expense = '';


		if ($last_id) {

			$query = "INSERT INTO delivered_order_payment_history (deliver_order_serial_no, delivery_emp_id, pay_amt, date ) values ('$last_id', '$employee_id_delivery','$pay', '$delivery_date' )";
			$insert_pay = $dbOb->insert($query);

			for ($i=0; $i < count($products_id_no); $i++) {
				
				$prod_id = $products_id_no[$i];
				$query = "SELECT * FROM products where products_id_no = '$prod_id'";
				$purchase_price = $dbOb->find($query)['company_price'] * $quantity[$i] ;
				
				$discount_tp = ($total_tp[$i]*$discount_on_tp/100);
				$sell_price = $total_price[$i] - $discount_tp;
				$sell_price = round(($sell_price - ($sell_price*$extra_discount/100)),3);
				
				$date = date('d-m-Y');
				$query = "INSERT INTO  order_delivery_expense
				(delivery_tbl_serial_no, order_tbl_serial_no, products_id_no, products_name, pack_size, unit_tp, unit_vat, tp_plus_vat, quantity, total_tp, total_vat, total_price,date,purchase_price,sell_price)
				VALUES
				('$last_id','$order_tbl_serial_no','$products_id_no[$i]','$products_name[$i]','$pack_size[$i]','$unit_tp[$i]','$unit_vat[$i]','$tp_plus_vat[$i]','$quantity[$i]','$total_tp[$i]','$total_vat[$i]','$total_price[$i]','$delivery_date','$purchase_price','$sell_price')";

				$insert_order_expense =$dbOb->insert($query);

				$product_id_number = $products_id_no[$i];
				$query = "SELECT * FROM products WHERE products_id_no = '$product_id_number'";
				$get_product_tbl = $dbOb->find($query);

				$persent_product_qty = $get_product_tbl["quantity"];

				$available_qty_after_sell = $persent_product_qty - $quantity[$i];
				$query = "UPDATE products SET quantity = '$available_qty_after_sell' WHERE products_id_no = '$product_id_number'";
				$product_tbl_update = $dbOb->update($query);
			}


			if ($product_tbl_update) {
				$query = "UPDATE new_order_details 
				SET 
				delivery_report = '1' 
				WHERE 
				serial_no = '$order_tbl_serial_no'";

				$update_deliver_history = $dbOb->update($query);
				if ($update_deliver_history) {
					$message = "Congratulations! Order Is Successfully Delivered.";
					$type = "success";
					$conf = 'yes';
					
					echo json_encode(['message'=>$message,'type'=>$type,'conf'=>$conf,'deliv_serial_no'=>$last_id]);
				}else{
					$message = "Sorry! Order Is Not Delivered.";
					$type = "warning";
					$conf = 'no';
					
					echo json_encode(['message'=>$message,'type'=>$type,'conf'=>$conf]);

				}
			} else{
				$message = "Sorry! Information Is Not Saved.";
				$type = "warning";
				$conf = 'no';
				
				echo json_encode(['message'=>$message,'type'=>$type,'conf'=>$conf]);

			}


		} 
	}


}// end of  if (isset($_POST['submit']))



// now we are going to cancel the order 
if (isset($_POST['new_order_tbl_serial_no'])) {
	$new_order_serial_no = $_POST['new_order_tbl_serial_no'];
	
	$query = "UPDATE new_order_details 
			SET 
			delivery_cancel_report = '1', 
			delivery_report = '0'
			WHERE 
			serial_no = '$new_order_serial_no'";

	$cancel_delivery = $dbOb->update($query);
	if ($cancel_delivery) {
		$message = "Congratulation! Order Is Successfully Cancelled.";
		$type = "success";
		
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else{
		$message = "Sorry! Order Is Not Cancelled.";
		$type = "warning";
		echo json_encode(['message'=>$message,'type'=>$type]);

	}
}

?>