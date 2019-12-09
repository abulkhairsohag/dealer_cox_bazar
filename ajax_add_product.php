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
?>



<?php 
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

	$company = strtolower($_POST["company"]);
	$products_id_no = substr(uniqid('', true), -4).substr(number_format(time() * rand(),0,'',''),0,2);
	$products_id_no = "PR-".$products_id_no;
	$products_name = $_POST["products_name"];
	$category = $_POST["category"];
	$weight = $_POST["weight"];
	$color = $_POST["color"];
	$company_price = $_POST["company_price"];
	$dealer_price = $_POST["dealer_price"];
	$marketing_sell_price = $_POST["marketing_sell_price"];
	$mrp_price = $_POST["mrp_price"];
	$pack_size = $_POST["pack_size"];
	$quantity = $_POST["quantity"];
	$promo_offer = $_POST["promo_offer"];
	$offer_start_date = $_POST["offer_start_date"];
	$offer_end_date = $_POST["offer_end_date"];

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

	$description =  $_POST["description"];
	$stock_date = date("d-m-Y");

	$edit_id = $_POST["edit_id"];


	if ($edit_id) { // updating data
		$query = "SELECT * FROM products WHERE serial_no = '$edit_id'";
		$get_product = $dbOb->find($query);

		// $total_quantity = $quantity;
		// if ($get_product) {
		// 	$total_quantity = intval($get_product['quantity']) + intval($quantity);
		// }
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
					weight = '$weight',
					color = '$color',
					
					dealer_price = '$dealer_price',
					marketing_sell_price = '$marketing_sell_price',
					mrp_price = '$mrp_price',
					pack_size = '$pack_size',
					promo_offer = '$promo_offer',
					offer_start_date = '$offer_start_date',
					offer_end_date = '$offer_end_date',
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
			weight = '$weight',
			color = '$color',
			
			dealer_price = '$dealer_price',
			marketing_sell_price = '$marketing_sell_price',
			mrp_price = '$mrp_price',
			pack_size = '$pack_size',
			promo_offer = '$promo_offer',
			offer_start_date = '$offer_start_date',
			offer_end_date = '$offer_end_date',
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
					(company ,products_id_no ,products_name ,category ,weight ,color ,company_price ,dealer_price ,marketing_sell_price ,mrp_price,pack_size ,quantity ,promo_offer ,offer_start_date ,offer_end_date,product_photo,description,stock_date )
					VALUES 
					('$company' ,'$products_id_no' ,'$products_name' ,'$category' ,'$weight' ,'$color' ,'$company_price' ,'$dealer_price' ,'$marketing_sell_price' ,'$mrp_price'  ,'$pack_size' ,'$quantity' ,'$promo_offer' ,'$offer_start_date' ,'$offer_end_date','$uploaded_image','$description','$stock_date')";
					$insert = $dbOb->insert($query);
					if ($insert) {
						$query = "INSERT INTO product_stock (products_id_no, quantity, stock_date,company_price)
						VALUES ('$products_id_no', '$quantity', '$stock_date','$company_price')";
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
			(company ,products_id_no ,products_name ,category ,weight ,color ,company_price ,dealer_price ,marketing_sell_price ,mrp_price,pack_size ,quantity ,promo_offer ,offer_start_date ,offer_end_date,description,stock_date )
			VALUES 
			('$company' ,'$products_id_no' ,'$products_name' ,'$category' ,'$weight' ,'$color' ,'$company_price' ,'$dealer_price' ,'$marketing_sell_price' ,'$mrp_price','$pack_size' ,'$quantity' ,'$promo_offer' ,'$offer_start_date' ,'$offer_end_date','$description','$stock_date')";
			$insert = $dbOb->insert($query);
			if ($insert) {
				$query = "INSERT INTO product_stock (products_id_no, quantity, stock_date,company_price)
				VALUES ('$products_id_no', '$quantity', '$stock_date','$company_price')";
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

	$products_id_no_stock = $_POST['products_id_no_stock'];
	$available_quantity   = $_POST['available_quantity'];
	$new_quantity 		  = $_POST['new_quantity'];
	$total_quantity 	  = $_POST['total_quantity'];
	$stock_date 	  	  = $_POST['stock_date'];
	$company_price_stock  = $_POST['company_price_stock'];

	$query = "UPDATE `products` SET quantity = '$total_quantity', company_price = '$company_price_stock' WHERE products_id_no = '$products_id_no_stock'";
	$update = $dbOb->update($query);
	if ($update) {
		// $stock_date = date('d-m-Y');
		$query = "INSERT INTO `product_stock` (products_id_no,quantity,stock_date,company_price)
		VALUES 
		('$products_id_no_stock','$new_quantity','$stock_date','$company_price_stock')";
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

if (isset($_POST['submit_original_price'])) {
	$serial_no  = $_POST['product_id_orig_price'];
	$actual_purchase_price  = $_POST['original_price'];
	$query = "UPDATE products SET actual_purchase_price = '$actual_purchase_price' WHERE serial_no = '$serial_no'";
	$update = $dbOb->update($query);
	if ($update) {
		$message = "Congratulations! Original Price Is Updated";
		$type = 'success';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else{
		$message = "Sorry! Price Is Not Updated";
		$type = 'warning';
		echo json_encode(['message'=>$message,'type'=>$type]);
	}

}

// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
	$query = "SELECT * FROM products ORDER BY serial_no DESC";
	$get_products = $dbOb->select($query);
	if ($get_products) {
		$i=0;
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
				<td><?php echo $row['mrp_price']; ?></td>
				<td><?php echo $row['pack_size']; ?></td>
				<td><?php echo $row['quantity']; ?></td>
				<!-- <td><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php //echo($row['products_id_no']) ?>' alt='Barcode Generator TEC-IT'/ width="100px" height=70px></td> -->
				<td align="center">

          
				<?php 
                   if (permission_check('product_edit_button')) {
                    ?>
                    <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                  <?php } ?>

                  <?php 
                  if (permission_check('product_stock_button')) {
                    ?>

                    <a class="badge bg-green stock_data" id="<?php echo($row['products_id_no']) ?>"   data-toggle="modal" data-target="#stock_data_modal">Stock This Product </a>
                  <?php } ?>
                  

                  <?php 
                  if (permission_check('product_delete_button')) {
                    ?> 

                    <a  class="badge  bg-red delete_data" id="<?php echo($row['products_id_no']) ?>"  style="margin:2px"> Delete</a> 
                  <?php } ?>
              
                  

                  <?php 
                  if (permission_check('product_view_button')) {
                    ?>
                    
                    <a class="badge bg-orange view_details"  id="<?php echo $row['products_id_no'] ?>" data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a>
                  <?php } ?>
				  
                  
                </td>
                
              </tr>

              <?php
            }
          }
}

?>