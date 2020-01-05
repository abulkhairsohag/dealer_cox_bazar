<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
$user_name = Session::get("username");
$password  = Session::get("password");
error_reporting(1);
include_once ('helper/helper.php');
include_once("class/Database.php");
$dbOb = new Database();

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	$products_id = validation($_POST["products_id"]);
	$quantity = validation($_POST["quantity"]);
	$ware_house_serial_no = validation($_POST["ware_house_serial_no"]);
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$ware_house_name = $dbOb->find($query)['ware_house_name'];
	$stock_date = $_POST["stock_date"];
	// die();

	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$ware_house_name = validation($dbOb->find($query)['ware_house_name']);

	$query = "SELECT * FROM offered_products WHERE products_id = '$products_id'";
	$get_products = $dbOb->select($query);
	if ($get_products) {
		$message = "Product Already Exist. You Can Stock This Product Several Times";
		$type = "warning";
		die(json_encode(['message'=>$message,'type'=>$type]));
	}

	$query = "INSERT INTO offered_products  (products_id, available_qty) VALUES  ('$products_id','$quantity')";
	$insert_id = $dbOb->custom_insert($query);
	if ($insert_id) {
		$query = "INSERT INTO offered_products_stock (offer_product_tbl_serial,products_id,quantity,stock_date,ware_house_serial_no,ware_house_name)
		VALUES ('$insert_id','$products_id','$quantity','$stock_date','$ware_house_serial_no','$ware_house_name')";
		$insert_stock = $dbOb->insert($query);

		$message = "Congratulations! Information Is Successfully Saved.";
		$type = 'success';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else{
		$message = "Sorry! Information Is Not Saved.";
		$type = 'warning';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}

	die();
}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$products_id_no = validation($_POST['serial_no_delete']);

	$query_product_details = "DELETE FROM offered_products WHERE products_id = '$products_id_no'";
	$query_stock_product = "DELETE FROM offered_products_stock WHERE products_id = '$products_id_no'";

	$delete_stock_product = $dbOb->delete($query_stock_product);
	if ($delete_stock_product) {
		$delete_product_details = $dbOb->delete($query_product_details);
		if ($delete_product_details) {
			$message = "Congratulations! Information Is Successfully Deleted.";
			$type = "success";
			echo json_encode(['message'=>$message, 'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Deleted.";
			$type = "warning";
			echo json_encode(['message'=>$message, 'type'=>$type]);
		}
	}else{
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message'=>$message, 'type'=>$type]);
	}
}

// in the following section we are going to get data for addin new quantity of product
if (isset($_POST['get_products_id_no_stock'])) {
	$products_id_no_stock = validation($_POST['get_products_id_no_stock']);
	$query = "SELECT * FROM `offered_products` WHERE products_id = '$products_id_no_stock'";
	$get_products_info = $dbOb->find($query);

	echo json_encode($get_products_info);
	die();
}

// In the following section we are going to add new stock
if (isset($_POST['submit_stock'])) {

	$products_id_stock = validation($_POST['products_id_stock']);
	$available_quantity   = validation($_POST['available_quantity']);
	$new_quantity 		  = validation($_POST['new_quantity']);
	$total_quantity 	  = $available_quantity*1 + $new_quantity*1;
	$stock_date 	  	  = validation($_POST['stock_date_store']);
	$ware_house_serial_no  = validation($_POST['ware_house_serial_no_store']);
	$offer_product_tbl_serial  = validation($_POST['offer_product_tbl_serial']);

	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$ware_house_name = validation($dbOb->find($query)['ware_house_name']);

	$query = "UPDATE `offered_products` SET available_qty = '$total_quantity'  WHERE products_id = '$products_id_stock'";
	$update = $dbOb->update($query);
	if ($update) {
		// $stock_date = date('d-m-Y');
		$query = "INSERT INTO `offered_products_stock` (offer_product_tbl_serial,products_id,quantity,stock_date,ware_house_serial_no,ware_house_name)
		VALUES 
		('$offer_product_tbl_serial','$products_id_stock','$new_quantity','$stock_date','$ware_house_serial_no','$ware_house_name')";
		$insert = $dbOb->insert($query);
		if ($insert) {
			$message = "Congratulations! Information Is Successfully Saved";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Saved";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}else{
		$message = "Sorry! Information Is Not Saved";
		$type = 'warning';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}
}
// updating original price 

// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
	$query = "SELECT * FROM offered_products ORDER BY serial_no DESC";
	$get_products = $dbOb->select($query);
	if ($get_products) {
		$i = 0;
		while ($row = $get_products->fetch_assoc()) {
			$i++;
			$products_id = $row['products_id'];
			$query= "SELECT * FROM products WHERE products_id_no = '$products_id' ";
			$get_product_details = $dbOb->select($query);
			$product_details = '';
			if ($get_product_details) {
				$product_details = $get_product_details->fetch_assoc();
			}
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo strtoupper($product_details['company']); ?></td>
				<td><?php echo $row['products_id']; ?></td>
				<td><?php echo $product_details['products_name']; ?></td>
				<td><?php echo $product_details['category']; ?></td>

				<td><?php echo $product_details['pack_size']; ?></td>
				<td><?php echo $row['available_qty']; ?></td>

				<td align="center">

					<?php
					if (permission_check('offer_stock_this_product_button')) {
						?>

						<a class="badge bg-green stock_data" id="<?php echo ($row['products_id']) ?>"   data-toggle="modal" data-target="#stock_data_modal">Stock This Product </a>
						<?php 
					}
					if (permission_check('offer_product_delete_button')) {
						?>

						<a  class="badge  bg-red delete_data" id="<?php echo ($row['products_id']) ?>"  style="margin:2px"> Delete</a>
					<?php } ?>
				</td>
			</tr>
			<?php
		}
	}
}

?>