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

if (isset($_POST['serial_no_edit'])) {
	$serial_no_edit = $_POST['serial_no_edit'];
	$query = "SELECT * FROM products WHERE serial_no = '$serial_no_edit'";
	$get_expense = $dbOb->find($query);
	echo json_encode($get_expense);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

	$company = strtolower(validation($_POST["company"]));

	$query = "SELECT * FROM id_no_generator WHERE id_type = 'product' ORDER BY serial_no DESC LIMIT 1";
	$get_prod = $dbOb->select($query);
	if ($get_prod) {
		$last_id = $get_prod->fetch_assoc()['id'];
		$last_id = explode('-',$last_id)[1];
		$last_id = $last_id*1+1;
		$id_length = strlen ($last_id); 
		$remaining_length = 6 - $id_length;
		$zeros = "";
		if ($remaining_length > 0) {
			for ($i=0; $i < $remaining_length ; $i++) { 
				$zeros = $zeros.'0';
			}
			$last_id = $zeros.$last_id ;
		}
		$products_id_no = "PR-".$last_id;
	}else{
		$products_id_no = "PR-000001";
	}


	$products_name = validation($_POST["products_name"]);
	$category = validation($_POST["category"]);
	$company_price_pack = validation($_POST["company_price"]);
	$sell_price = validation($_POST["sell_price"]);
	$mrp_price = validation($_POST["mrp_price"]);
	$pack_size = validation($_POST["pack_size"]);
	$quantity_pkt = validation($_POST["quantity_pkt"]);
	$quantity_pcs = validation($_POST["quantity_pcs"]);
	$total_stock_pcs = $quantity_pkt*$pack_size + $quantity_pcs*1;

	$per_pcs_company_price = $company_price_pack/$pack_size;

	$product_photo = $_FILES['product_photo'];
	if ($product_photo) {
		$permitted = array('jpg','png','gif','jpeg');
		$file_name = $product_photo['name'];
		$file_size = $product_photo['size'];
		$file_temp = $product_photo['tmp_name'];
		$div = explode(".", $file_name);
		$file_extension = strtolower(end($div));
		$file_extension = strtolower($file_extension);
		$unique_image = md5(time()); 
		$unique_image= substr($unique_image, 0,10).'.'.$file_extension;
		$uploaded_image = 'product_photo/'.$unique_image;
	}else{
		$uploaded_image = "";
	}

	$description =  validation($_POST["description"]);
	$stock_date =  validation($_POST["stock_date"]);
	$ware_house_serial_no = validation($_POST["ware_house_serial_no"]);
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$ware_house_name = $dbOb->find($query)['ware_house_name'];

	$edit_id = validation($_POST["edit_id"]);


	if ($edit_id) { // updating data
		$query = "SELECT * FROM products WHERE serial_no = '$edit_id'";
		$get_product = $dbOb->find($query);


		if (!empty($file_name)) { // while editing if an image is choosen then the following section will work
			if (!in_array($file_extension, $permitted)) {
				$message = "Please Upload Image With Extension : ".implode(', ',$permitted);
				$type = "warning";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				if ($get_product['product_photo']) {
					unlink($get_product['product_photo']);
				}
				if (move_uploaded_file($file_temp, $uploaded_image)) {
					$query = "UPDATE products 
					SET 
					company = '$company',
					products_name = '$products_name',
					category = '$category',
					
					sell_price = '$sell_price',
					mrp_price = '$mrp_price',
					pack_size = '$pack_size',
					product_photo = '$uploaded_image',
					description = '$description'

					WHERE
					serial_no = '$edit_id' ";

					$update = $dbOb->update($query);
					if ($update) {
						$message = "Congratulations! Information Is Successfully Updated.";
						$type = 'success';
						echo json_encode(['message'=>$message,'type'=>$type]);
					}else{
						$message = "Sorry! Information Is Not Updated.";
						$type = 'warning';
						echo json_encode(['message'=>$message,'type'=>$type]);
					}
				}
			}
		}else{ // end of    if (!empty($file_name))   ie while editing if no image is selected then the following section will work
			$query = "UPDATE products 
			SET 
			company = '$company',
			products_name = '$products_name',
			category = '$category',
			
			sell_price = '$sell_price',
			mrp_price = '$mrp_price',
			pack_size = '$pack_size',
			
			description = '$description'

			WHERE
			serial_no = '$edit_id' ";

			$update = $dbOb->update($query);
			if ($update) {
				$message = "Congratulations! Information Is Successfully Updated.";
				$type = 'success';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = "Sorry! Information Is Not Updated.";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}

		}


	}else{ // end of    if ($edit_id)   ie now adding data 
		
		if (!empty($file_name)) {
			if (!in_array($file_extension, $permitted)) {
				$message = "Please Upload Image With Extension : ".implode(', ',$permitted);
				$type = "warning";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				if (move_uploaded_file($file_temp, $uploaded_image)) {
					$query = "INSERT INTO products 
					(company ,products_id_no ,products_name ,category ,company_price ,sell_price,mrp_price,pack_size ,quantity, product_photo,description,stock_date )
					VALUES 
					('$company' ,'$products_id_no' ,'$products_name' ,'$category'  ,'$company_price_pack' ,'$sell_price','$mrp_price'  ,'$pack_size' ,'$quantity_pkt','$uploaded_image','$description','$stock_date')";
					$insert = $dbOb->insert($query);
					if ($insert) {

						$query = "INSERT INTO id_no_generator (id,id_type) VALUES ('$products_id_no','product')";
						$insert_id = $dbOb->insert($query);

						$query = "INSERT INTO product_stock (products_id_no, quantity, stock_date,company_price,ware_house_serial_no,ware_house_name)
						VALUES ('$products_id_no', '$total_stock_pcs', '$stock_date','$per_pcs_company_price','$ware_house_serial_no','$ware_house_name')";
						$insert_stock = $dbOb->insert($query);

						$message = "Congratulations! Information Is Successfully Saved.";
						$type = 'success';
						echo json_encode(['message'=>$message,'type'=>$type]);
					}else{
						$message = "Sorry! Information Is Not Saved.";
						$type = 'warning';
						echo json_encode(['message'=>$message,'type'=>$type]);
					}
				}
			}
		}else{ //end of    if (!empty($file_name))   ie no image is choosen 
			$query = "INSERT INTO products 
			(company ,products_id_no ,products_name ,category ,company_price ,sell_price,mrp_price,pack_size ,quantity,description,stock_date )
			VALUES 
			('$company' ,'$products_id_no' ,'$products_name' ,'$category'  ,'$company_price_pack' ,'$sell_price','$mrp_price'  ,'$pack_size' ,'$quantity','$description','$stock_date')";
			$insert = $dbOb->insert($query);
			if ($insert) {
				$query = "INSERT INTO id_no_generator (id,id_type) VALUES ('$products_id_no','product')";
				$insert_id = $dbOb->insert($query);

				$query = "INSERT INTO product_stock (products_id_no, quantity, stock_date,company_price,ware_house_serial_no,ware_house_name)
				VALUES ('$products_id_no', '$total_stock_pcs', '$stock_date','$per_pcs_company_price','$ware_house_serial_no','$ware_house_name')";
				$insert_stock = $dbOb->insert($query);

				$message = "Congratulations! Information Is Successfully Saved.";
				$type = 'success';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = "Sorry! Information Is Not Saved.";
				$type = 'warning';
				echo json_encode(['message'=>$message,'type'=>$type]);
			}
		}

	}

}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$products_id_no = $_POST['serial_no_delete'];

	$query_product_details = "DELETE FROM products WHERE products_id_no = '$products_id_no'";
	$query_stock_product = "DELETE FROM product_stock WHERE products_id_no = '$products_id_no'";

	$delete_stock_product = $dbOb->delete($query_stock_product);
	if ($delete_stock_product) {
		$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
		$get_products = $dbOb->find($query);
		if ($get_products) {
			if ($get_products["product_photo"]) {
				unlink($get_products["product_photo"]);
			}
		}
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
	$products_id_no_stock = $_POST['get_products_id_no_stock'];
	$query = "SELECT * FROM `products` WHERE products_id_no = '$products_id_no_stock'";
	$get_products_info = $dbOb->find($query);
	



	echo json_encode($get_products_info);
	die();
}

// In the following section we are going to add new stock
if (isset($_POST['submit_stock'])) {

	$products_id_no_stock = validation($_POST['products_id_no_stock']);
	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no_stock'";
	$get_prod_info =$dbOb->find($query);
	$pack_size = $get_prod_info['pack_size'];

	$available_quantity   = validation($_POST['available_quantity']);
	$new_quantity_pack 		  = validation($_POST['new_quantity_pack']);
	$new_quantity_pcs 		  = validation($_POST['new_quantity_pcs']);

	if (($new_quantity_pack == '' || $new_quantity_pack < 1) && ($new_quantity_pcs == '' || $new_quantity_pcs < 1)) {
		$message = "Please Provide Quantity";
		$type = "warning";
		die(json_encode(['message'=>$message,'type'=>$type]));
	}

	$total_stock_pcs = $new_quantity_pack*$pack_size + $new_quantity_pcs*1 ;


	$stock_date 	  	  = validation($_POST['stock_date']);
	$company_price_stock  = validation($_POST['company_price_stock']);
	$per_pcs_company_price = $company_price_stock / $pack_size ;
	$ware_house_serial_no  = validation($_POST['ware_house_serial_no']);
	$ware_house_name = '';
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_ware_house = $dbOb->select($query);
	if ($get_ware_house) {
		$ware_house_name = $get_ware_house->fetch_assoc()['ware_house_name'];
	}

	$query = "UPDATE `products` SET company_price = '$company_price_stock' WHERE products_id_no = '$products_id_no_stock'";
	$update = $dbOb->update($query);
	if ($update) {
		// $stock_date = date('d-m-Y');
		$query = "INSERT INTO `product_stock` (products_id_no,quantity,stock_date,company_price,ware_house_serial_no,ware_house_name)
		VALUES 
		('$products_id_no_stock','$total_stock_pcs','$stock_date','$per_pcs_company_price','$ware_house_serial_no','$ware_house_name')";
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
// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
	$query = "SELECT * FROM products ORDER BY serial_no DESC";
	$get_products = $dbOb->select($query);
	if ($get_products) {
		$i = 0;
		while ($row = $get_products->fetch_assoc()) {
			$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo strtoupper($row['company']); ?></td>
				<td><?php echo $row['products_id_no']; ?></td>
				<td><?php echo $row['products_name']; ?></td>
				<td><?php echo $row['category']; ?></td>
				<td><?php echo $row['company_price']; ?></td>
				<td><?php echo $row['sell_price']; ?></td>
				<td><?php echo $row['mrp_price']; ?></td>
				<td><?php echo $row['pack_size']; ?></td>

				<td align="center">

					<?php
					if (permission_check('product_edit_button')) {
						?>
						<a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
					<?php }?>

					<?php
					if (permission_check('product_stock_button')) {
						?>

						<a class="badge bg-green stock_data" id="<?php echo ($row['products_id_no']) ?>"   data-toggle="modal" data-target="#stock_data_modal">Stock This Product </a>
					<?php }?>


					<?php
					if (permission_check('product_delete_button')) {
						?>

						<a  class="badge  bg-red delete_data" id="<?php echo ($row['products_id_no']) ?>"  style="margin:2px"> Delete</a>
					<?php }?>



					<?php
					if (permission_check('product_view_button')) {
						?>

						<a class="badge bg-orange view_details"  id="<?php echo $row['products_id_no'] ?>" data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a>
					<?php }?>




				</td>

			</tr>

			<?php
		}
	}
}

?>