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

if (isset($_POST['get_products_id_no'])) {
	$products_id_no = $_POST['get_products_id_no'];
	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$get_products = $dbOb->find($query);
	echo json_encode($get_products);
}

//getting information while clicked on edit 
if (isset($_POST['serial_no_edit'])) {
	$serial_no = $_POST['serial_no_edit'];
	$query = "SELECT * FROM company_products_return WHERE serial_no = '$serial_no'";
	$return_info = $dbOb->find($query);
	$ware_house_serial_no = $return_info['ware_house_serial_no'];

	$products_id_no = $return_info["products_id_no"];
	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$product_info = $dbOb->find($query);
	$current_quantity = $product_info["quantity"];

	$query = "SELECT * FROM ware_house ";
	$get_ware_house = $dbOb->select($query);
	if ($get_ware_house) {
		$ware_house_option = '<option value="">Please Select One</option>';

		while ($row = $get_ware_house->fetch_assoc()) {
			
			$ware_house_option .= '<option value="'.$row["serial_no"].'"'. ($ware_house_serial_no == $row["serial_no"] ?  "selected" : "") .'>'.$row['ware_house_name'].'</option>';
		}
	}else{
		$ware_house_option = '<option value="">Ware House Not Found..</option>';
	}


	echo json_encode(['return_info'=>$return_info,'current_quantity'=>$current_quantity,'ware_house_option'=>$ware_house_option]);
}


// adding and updating data 

if (isset($_POST['submit'])) {
	$ware_house_serial_no = $_POST['ware_house_serial_no'];
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_warehouse = $dbOb->select($query);
	$ware_house_name = "";
	if ($get_warehouse) {
		$ware_house_name = $get_warehouse->fetch_assoc()['ware_house_name'];
	}
	$products_id_no = $_POST['products_id_no'];
	$products_name = $_POST['products_name'];
	$company = $_POST['company'];
	$products_id_no = $_POST['products_id_no'];
	$dealer_price = $_POST['dealer_price'];
	$return_quantity = $_POST['return_quantity'];
	$total_price = $_POST['total_price'];
	$return_reason = $_POST['return_reason'];
	$description = $_POST['description'];
	$edit_id = $_POST['edit_id'];
	$return_date = $_POST['return_date'];

	if ($edit_id) { // updating information 
		$query = "SELECT * FROM company_products_return WHERE serial_no = '$edit_id'";
		$get_company_products_return_info = $dbOb->find($query);

		$query = "UPDATE company_products_return 
		SET 
		
		return_quantity = '$return_quantity',
		total_price = '$total_price',
		return_reason = '$return_reason',
		description = '$description',
		return_date = '$return_date',
		ware_house_serial_no = '$ware_house_serial_no',
		ware_house_name = '$ware_house_name'
		WHERE 
		serial_no = '$edit_id'";
		$update_return = $dbOb->update($query);

		if ($update_return) {
			$query_get_product = "SELECT quantity FROM products WHERE products_id_no = '$products_id_no'";
			$get_products_qty = $dbOb->find($query_get_product);
			$x_return_quantity = $get_company_products_return_info["return_quantity"];
			$available_qty = (int)$get_products_qty['quantity'] + (int)$x_return_quantity - (int)$return_quantity;

			$query_product_update = "UPDATE products set quantity = '$available_qty' WHERE products_id_no = '$products_id_no'";
			$update_products = $dbOb->update($query_product_update);
			if ($update_products) {
				
				$return_quantity = -1 * (int)$return_quantity;
				$query_stock_update  = "UPDATE product_stock SET quantity = $return_quantity WHERE company_product_return_id= '$edit_id'";
				$update_stock = $dbOb->update($query_stock_update);
				if ($update_stock) {
					$message = "Congratulations ! Information is  Updated.";
					$type = "success";
					echo json_encode(['message'=>$message,'type'=>$type]);
					
				}
			}else{
				$message = "Sorry ! Information is Not Updated.";
				$type = "warning";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}
			
		}else{
			$message = "Sorry ! Information is Not Updated.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}else{ // now inserting data into database 
		$query = "INSERT INTO `company_products_return` 
		(products_id_no,products_name,company,dealer_price,return_quantity,total_price,return_reason,description,return_date,ware_house_serial_no,ware_house_name) 
		VALUES 
		('$products_id_no','$products_name','$company','$dealer_price','$return_quantity','$total_price','$return_reason','$description','$return_date','$ware_house_serial_no','$ware_house_name')";
		$last_insert_id = $dbOb->custom_insert($query);
		if ($last_insert_id) {
			$query_get_product = "SELECT quantity FROM products WHERE products_id_no = '$products_id_no'";
			$get_products_qty = $dbOb->find($query_get_product);
			$available_qty = $get_products_qty['quantity'] - $return_quantity;

			$query_product_update = "UPDATE products set quantity = '$available_qty' WHERE products_id_no = '$products_id_no'";
			$update_products = $dbOb->update($query_product_update);

			$return_quantity = -1 * (int)$return_quantity;
			$query_stock_insert  = "INSERT `product_stock` (company_product_return_id,products_id_no,quantity,stock_date)
			VALUES 
			('$last_insert_id','$products_id_no','$return_quantity','$return_date') ";
			$insert_stock = $dbOb->insert($query_stock_insert);
			if ($update_products && $insert_stock) {
				$message = "Congratulations! Information is successfully saved.";
				$type = "success";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = "Sorry ! Information is Not saved.";
				$type = "warning";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}
			
		}else{
			$message = "Sorry ! Information is Not saved.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}
}


// the following section is for deleting information 
if (isset($_POST['serial_no_delete'])) {
	$serial_no = $_POST['serial_no_delete'];

	$query = "SELECT * FROM company_products_return WHERE serial_no = '$serial_no' ";
	$get_return_info = $dbOb->find($query);

	$query = "DELETE FROM company_products_return WHERE serial_no = '$serial_no'";
	$delete_return = $dbOb->delete($query);

	if ($delete_return) {
		$return_quantity = $get_return_info['return_quantity'];
		$products_id_no = $get_return_info['products_id_no'];

		$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
		$get_products_info = $dbOb->find($query);

		$products_quantity = $get_products_info['quantity'];

		$available_quantity = (int)$products_quantity + (int)$return_quantity;

		$query = "UPDATE products SET quantity ='$available_quantity' WHERE products_id_no = '$products_id_no'";
		$update_products_info = $dbOb->update($query);

		if ($update_products_info) {
			$query = "DELETE FROM product_stock WHERE company_product_return_id = '$serial_no'";
			$delete_stock_info = $dbOb->delete($query);

			if ($delete_stock_info) {
				
				$message = "Congratulations ! Information is deleted successfully .";
				$type = "success";
				echo json_encode(['message'=>$message,'type'=>$type]);
			}
		}
	}

}

// the following section is for fetching data from database and showing them into data table
if (isset($_POST["sohag"])) {

	$query = "SELECT * FROM company_products_return ORDER BY serial_no DESC";
	$get_return_products = $dbOb->select($query);
	if ($get_return_products) {
		$i=0;
		while ($row = $get_return_products->fetch_assoc()) {
			$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo strtoupper($row['products_id_no']); ?></td>
				<td><?php echo $row['products_name']; ?></td>
				<td><?php echo $row['company']; ?></td>
				<td><?php echo $row['dealer_price']; ?></td>
				<td><?php echo $row['return_quantity']; ?></td>
				<td><?php echo $row['total_price']; ?></td>
				<td><?php echo $row['return_reason']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td><?php echo $row['return_date']; ?></td>
				<td align="center">


                      <?php 
                      if (permission_check('return_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>


                      <?php 
                      if (permission_check('return_delete_button')) {
                        ?>

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                      <?php } ?>
                      
                      
                    </td>
                    
                  </tr>

			<?php
		}
	}
}
?>