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


// getting product information 
if (isset($_POST['get_products_id_no'])) {
	$products_id_no = $_POST['get_products_id_no'];
	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$get_products = $dbOb->find($query);



	echo json_encode($get_products);




	// $profit = (int)$sell_price - (int)$product_info['company_price'];

}
//now getting return information
if (isset($_POST['serial_no_edit'])) {

	$serial_no = $_POST['serial_no_edit'];
	$query = "SELECT * FROM market_products_return WHERE serial_no = '$serial_no'";
	$get_return_products_info = $dbOb->find($query);
	$products_id_no = $get_return_products_info['products_id_no'];

	$zone_serial_no = $get_return_products_info['zone_serial_no'];
	$query = "SELECT * FROM area_zone WHERE zone_serial_no = '$zone_serial_no'";
	$area_name = $get_return_products_info['area_employee_delivery'];
	$get_area_zone = $dbOb->select($query);
	if ($get_area_zone) {
		$area_options = '<option value="">Please Select One</option>';

		while ($row = $get_area_zone->fetch_assoc()) {
			$area_options .= '<option value="'.$row["area_name"].'"'. ($area_name == $row["area_name"] ?  "selected" : "") .'>'.$row['area_name'].'</option>';
		}
	}else{
		$area_options = '<option value="">Area Not Assigned In This Zone</option>';
	}




	$query = "SELECT * FROM client WHERE area_name = '$area_name' ORDER BY organization_name";
	$get_client = $dbOb->select($query);
	if ($get_client) {
		$client_options = '<option value="">Please Select One</option>';

		while ($row = $get_client->fetch_assoc()) {
			$cust_id = $get_return_products_info['cust_id'];
			$client_options .= '<option value="'.$row["cust_id"].'"'. ($cust_id == $row["cust_id"] ?  "selected" : "") .'>'.$row['organization_name'].'</option>';
		}
	}else{
		$client_options = '<option value="">Client Not Found In This Area</option>';
	}

	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$current_quantity = $dbOb->find($query)['quantity'];

	echo json_encode(['info'=>$get_return_products_info,'current_quantity'=>$current_quantity,'area_options'=>$area_options,'client_options'=>$client_options]);

}


// now performing action after submission of the form 
if (isset($_POST['submit'])) {
	$employee_id_delivery = validation($_POST['employee_id_delivery']);
	$employee_name_delivery = validation($_POST['employee_name_delivery']);
	$zone_serial_no = validation($_POST['zone_serial_no']);
	$query ="SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
	$zone = $dbOb->select($query);
	$zone_name = "";
	if ($zone) {
		$zone_name = validation($zone->fetch_assoc()['zone_name']);
	}

	$area_employee = validation($_POST['area_employee']);
	$ware_house_serial_no = validation($_POST['ware_house_serial_no']);
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_ware_house = $dbOb->select($query);
	$ware_house_name ="";
	if ($get_ware_house) {
		$ware_house_name = validation($get_ware_house->fetch_assoc()['ware_house_name']);
	}
	$cust_id =  validation($_POST['cust_id']);
	$shop_name = validation($_POST['shop_name']);
	$shop_phn = validation($_POST['shop_phn']);
	$products_id_no = validation($_POST['products_id_no']);
	$products_name = validation($_POST['products_name']);
	$company = validation($_POST['company']);
	$marketing_sell_price = validation($_POST['marketing_sell_price']);
	$return_quantity = validation($_POST['return_quantity']);
	$total_price = validation($_POST['total_price']);
	$return_reason = validation($_POST['return_reason']);
	$description = validation($_POST['description']);
	$return_date = validation($_POST['return_date']);

	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$current_quantity = $dbOb->find($query)['quantity'];

	$edit_id = validation($_POST['edit_id']);
	// $return_date = date("d-m-Y");

	if ($edit_id) {
		$query = "SELECT * FROM market_products_return WHERE serial_no = '$edit_id'";
		$x_return_qty = $dbOb->find($query)['return_quantity'];

		$query = "UPDATE market_products_return 
				  SET 
				  employee_id_delivery = '$employee_id_delivery',
				  employee_name_delivery = '$employee_name_delivery',
				  area_employee_delivery = '$area_employee',
				  cust_id = '$cust_id',
				  shop_name = '$shop_name',
				  shop_phn = '$shop_phn',
				  company = '$company',
				  marketing_sell_price = '$marketing_sell_price',
				  return_quantity = '$return_quantity',
				  total_price = '$total_price',
				  return_reason = '$return_reason', 
				  description = '$description',
				  return_date = '$return_date',
				  ware_house_serial_no = '$ware_house_serial_no',
				  ware_house_name = '$ware_house_name',
				  zone_serial_no = '$zone_serial_no',
				  zone_name = '$zone_name'
				  WHERE 
				  serial_no = '$edit_id'";
		$update_return = $dbOb->update($query);

		if ($update_return) {
			$available_qty=(int)$current_quantity - (int)$x_return_qty + (int)$return_quantity; 

			$query = "UPDATE products SET quantity = '$available_qty' WHERE products_id_no = '$products_id_no'";
				$update_products = $dbOb->update($query);

			if ($update_products) {
				$message = "Congratulations! Information is successfully Updated.";
				$type = "success";
				echo json_encode(['message'=>$message,'type'=>$type]);
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
		$query = "INSERT INTO `market_products_return` 
				  (employee_id_delivery,employee_name_delivery,	area_employee_delivery,cust_id,shop_name,shop_phn,products_id_no,products_name,company,marketing_sell_price,return_quantity,total_price,return_reason, description,return_date,ware_house_serial_no,ware_house_name,zone_serial_no,zone_name) 
				 VALUES 
				 ('$employee_id_delivery','$employee_name_delivery','$area_employee','$cust_id','$shop_name','$shop_phn','$products_id_no','$products_name','$company','$marketing_sell_price','$return_quantity','$total_price','$return_reason','$description','$return_date','$ware_house_serial_no','$ware_house_name','$zone_serial_no','$zone_name')";
		$insert = $dbOb->insert($query);
		if ($insert) {
				$update_qty = (int)$current_quantity*1 + (int)$return_quantity*1;

				$query = "UPDATE products SET quantity = '$update_qty' WHERE products_id_no = '$products_id_no'";
				$update_products = $dbOb->update($query);

			if ($update_products) {
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

// now we are going to delete delete data 
if (isset($_POST['serial_no_delete'])) {
	$delete_id = $_POST['serial_no_delete'];
	$query = "SELECT * FROM market_products_return WHERE serial_no = '$delete_id'";
	$return_info = $dbOb->find($query);

	$x_return_qty = $return_info['return_quantity'];
	$products_id_no = $return_info['products_id_no'];

	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$product_qty_at_this_time = $dbOb->find($query)['quantity'];

	$available_qty = (int)$product_qty_at_this_time - (int)$x_return_qty;

	$query = "DELETE FROM market_products_return WHERE serial_no = '$delete_id'";	
	$delete = $dbOb->delete($query);

	if ($delete) {
		$query = "UPDATE products SET quantity = '$available_qty' WHERE products_id_no = '$products_id_no'";
		$update_products = $dbOb->update($query);
		if ($update_products) {
			$message = "Congratulations! Information Is Successfully Deleted";
			$type = "success";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Deleted";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);

		}

	}else{
			$message = "Sorry! Information Is Not Deleted";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
}

// the following section is form showing return information 
if (isset($_POST['view_id'])) {
	$serial_no = $_POST['view_id'];
	$query = "SELECT * FROM market_products_return WHERE serial_no = '$serial_no'";
	$get_return_informaiton = $dbOb->find($query);

	echo json_encode($get_return_informaiton);
}


// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
             
	 if (Session::get("zone_serial_no")){
                  if (Session::get("zone_serial_no") != '-1') {
                    $zone_serial = Session::get("zone_serial_no");
                    $query = "SELECT * FROM market_products_return WHERE zone_serial_no = '$zone_serial' ORDER BY serial_no DESC";
                    $get_return_products = $dbOb->select($query);
                  }
                }else{
                    $query = "SELECT * FROM market_products_return ORDER BY serial_no DESC";
                    $get_return_products = $dbOb->select($query);
                }
                    

                    if ($get_return_products) {
                      $i=0;
                      while ($row = $get_return_products->fetch_assoc()) {
                        $i++;
                        if ($row['unload_status'] == '1') {
                          $unload_status = 'Yes';
                          $background = 'green';
                        }else{
                          $unload_status = 'No';
                          $background = 'red';
                        }
                        ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo strtoupper($row['products_id_no']); ?></td>
                          <td><?php echo $row['products_name']; ?></td>
                          <td><?php echo $row['company']; ?></td>
                          <td><?php echo $row['shop_name']; ?></td>
                          <td><?php echo $row['marketing_sell_price']; ?></td>
                          <td><?php echo $row['return_quantity']; ?></td>
                          <td><?php echo $row['total_price']; ?></td>
                          <td><span style="color: white" class="badge bg-<?php echo($background) ?>"><?php echo($unload_status) ?></span></td>
                          <td><?php echo $row['ware_house_name']; ?></td>
                          <td><?php echo $row['return_date']; ?></td>
                          <td align="center">


                            <?php 
                            if (permission_check('return_product_edit_button')) {

                              ?>
                              <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                            <?php } ?>

                            <?php 
                            if (permission_check('return_product_delete_button')) {

                              ?>
                              <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                            <?php } ?>

                            <?php 
                            if (permission_check('return_product_view_button')) {

                              ?>
                              <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 
                            <?php } ?>

                          </td>
                        </tr>
                        <?php
                      }
                    }
}
 ?>