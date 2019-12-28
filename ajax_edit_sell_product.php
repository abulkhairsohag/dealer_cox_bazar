<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');

include_once("class/Database.php");
$dbOb = new Database();


// now we are going to add information 

if (isset($_POST['submit'])) {

	$edit_id = $_POST['edit_id'];
	$order_no  		= $_POST['order_no'];
	$employee_id    = $_POST['employee_id'];
	$employee_name  = $_POST['employee_name'];

	$customer_id  	= $_POST['customer_id'];
	$customer_name  = $_POST['customer_name'];
	$mobile_no   	= $_POST['mobile_no'];

	$products_id_no = $_POST['products_id_no'];
	$products_name 	= $_POST['products_name'];
	$sell_price 	= $_POST['sell_price'];
	$qty      	= $_POST['qty'];
	// $sell_price    	= $_POST['sell_price'];
	// $mrp_price     	= $_POST['mrp_price'];
	$total_price   	= $_POST['total_price'];
	$sell_date   	= $_POST['date'];

	 
	$net_payable_amt     	 = $_POST['net_payable_amt'];
	$pay           	 = $_POST['pay'];

	if ($pay=='null' || $pay == '') {
		$pay = 0;
	}
	$due             = $_POST['due'];


	$query = "UPDATE own_shop_sell 
				SET 
				customer_id		= '$customer_id',
				customer_name	= '$customer_name', 
				mobile_no		= '$mobile_no',
				net_payable_amt		= '$net_payable_amt',
				pay				= '$pay',
				due				= '$due'
				WHERE
				serial_no = '$edit_id' ";   

	$update_sell = $dbOb->update($query);

	if ($update_sell) {
	 	$query = "SELECT * FROM own_shop_sell_product WHERE sell_tbl_id = '$edit_id'";
	 	$get_products = $dbOb->select($query);

	 	if ($get_products) {
	 		while ($row = $get_products->fetch_assoc()) {
	 			$quantity_exist = $row['qty'];
	 			$prod_id = $row['products_id_no'];
	 			$query = "SELECT * FROM own_shop_products_stock WHERE products_id= '$prod_id'";
	 			$get_prod = $dbOb->find($query);
	 			$product_available = (int)$get_prod['quantity_pcs'] + (int)$quantity_exist ; 

	 			$query = "UPDATE own_shop_products_stock SET quantity_pcs = '$product_available' WHERE products_id = '$prod_id'";
	 			$update_product = $dbOb->update($query);
	 		}
	 	}

	 	if ($update_product) {
	 		$query = "DELETE FROM own_shop_sell_product WHERE sell_tbl_id = '$edit_id'";
	 		$delete_product = $dbOb->delete($query);
	 		if ($delete_product) {
	 			for ($i=0; $i < count($products_id_no); $i++) {
					// $date = date('d-m-Y');
					$query = "INSERT INTO  own_shop_sell_product
					(sell_tbl_id,products_id_no,products_name,sell_price,qty,total_price,sell_date)
					VALUES
					('$last_id','$products_id_no[$i]','$products_name[$i]','$sell_price[$i]','$qty[$i]','$total_price[$i]','$sell_date')";


					$insert_own_shop_sell_product =$dbOb->insert($query);

					$product_id_number = $products_id_no[$i];
					$query = "SELECT * FROM own_shop_products_stock WHERE products_id = '$product_id_number'";
					$get_product_tbl = $dbOb->find($query);

					$persent_product_qty = $get_product_tbl["quantity_pcs"];

					$available_qty_after_sell = 1*$persent_product_qty - 1*$qty[$i];
					$query = "UPDATE own_shop_products_stock SET quantity_pcs = '$available_qty_after_sell' WHERE products_id = '$product_id_number'";
					$product_tbl_update = $dbOb->update($query);
				}
	 		}
	 	}


		if ($product_tbl_update) {
			$message = "Congratulaiton! Information Successfully Updated.";
			$type = "success";

	          Session::set("update_message",$message);
	          Session::set("update_type",$type);
			echo json_encode(['message'=>$message,'type'=>$type]);
		} else{
			$message = "Sorry!Failed To Sell Products.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	 } else{
			$message = "own shop sell table is not updated.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
	 }
}

?>