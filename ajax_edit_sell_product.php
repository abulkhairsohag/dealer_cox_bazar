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
	$sell_date      = $_POST['sell_date'];
	$customer_id  	= $_POST['customer_id'];
	$customer_name  = $_POST['customer_name'];
	$mobile_no   	= $_POST['mobile_no'];

	$products_id_no = $_POST['products_id_no'];
	$products_name 	= $_POST['products_name'];
	$quantity      	= $_POST['quantity'];
	$sell_price    	= $_POST['sell_price'];
	$mrp_price     	= $_POST['mrp_price'];
	$total_price   	= $_POST['total_price'];
	$promo_offer   	= $_POST['promo_offer'];


	$net_total     	 = $_POST['net_total'];
	$vat           	 = $_POST['vat'];
	$vat_amount    	 = $_POST['vat_amount'];
	$discount      	 = $_POST['discount'];
	$discount_amount = $_POST['discount_amount'];
	$grand_total     = $_POST['grand_total'];
	$pay             = $_POST['pay'];
	if ($pay==null || $pay == '') {
		$pay = 0;
	}
	$due             = $_POST['due']; 

	$query = "UPDATE own_shop_sell 
				SET 
				customer_id		= '$customer_id',
				customer_name	= '$customer_name', 
				mobile_no		= '$mobile_no',
				net_total		= '$net_total',
				vat				= '$vat',
				vat_amount		= '$vat_amount',
				discount		= '$discount',
				discount_amount	= '$discount_amount',
				grand_total		= '$grand_total',
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
	 			$quantity_exist = $row['quantity'];
	 			$prod_id = $row['products_id_no'];
	 			$query = "SELECT * FROM products WHERE products_id_no = '$prod_id'";
	 			$get_prod = $dbOb->find($query);
	 			$product_available = (int)$get_prod['quantity'] + (int)$quantity_exist ; 

	 			$query = "UPDATE products SET quantity = '$product_available' WHERE products_id_no = '$prod_id'";
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
					(sell_tbl_id,products_id_no,products_name,quantity,sell_price,	mrp_price,total_price,promo_offer,sell_date)
					VALUES
					('$edit_id','$products_id_no[$i]','$products_name[$i]','$quantity[$i]','$sell_price[$i]',	'$mrp_price[$i]','$total_price[$i]','$promo_offer[$i]','$sell_date')";

					$insert_own_shop_sell_product =$dbOb->insert($query);

					$product_id_number = $products_id_no[$i];
					$query = "SELECT * FROM products WHERE products_id_no = '$product_id_number'";
					$get_product_tbl = $dbOb->find($query);

					$persent_product_qty = $get_product_tbl["quantity"];

					$available_qty_after_sell = (int)$persent_product_qty - (int)$quantity[$i];
					$query = "UPDATE products SET quantity = '$available_qty_after_sell' WHERE products_id_no = '$product_id_number'";
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