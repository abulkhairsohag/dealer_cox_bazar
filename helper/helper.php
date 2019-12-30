<?php 

	include_once('class/Database.php');
	 $dbOb = new Database();
	 

	
	function permission_check($permission){
		$dbOb =  new Database();
		$role_name = Session::get("role");
		$user_serial_no = Session::get("user_id");
		$user_type = Session::get("user_type");

		if ($role_name == 'admin') {
			return true;
		}

		$query = "SELECT * FROM role WHERE role_name = '$role_name'";
		$role_info = $dbOb->find($query);
		$role_serial_no = $role_info['serial_no'];

		$query = "SELECT * FROM user_has_role WHERE user_type = '$user_type' AND user_serial_no ='$user_serial_no' AND role_serial_no = '$role_serial_no'";
		$get_user_has_role = $dbOb->find($query);

		
		if (!$get_user_has_role) {
			return false;
		}

		

		$query = "SELECT * FROM role_has_permission WHERE role_serial_no = '$role_serial_no'";
		$get_permission = $dbOb->select($query);
		$permissions = [];

		if ($get_permission) {
			while ($row = $get_permission->fetch_assoc()) {
				$get_permission_serial_no =  $row['permission_serial_no'];
				$query = "SELECT * FROM permission WHERE serial_no = '$get_permission_serial_no'";
				$permissions[] = $dbOb->find($query)['permission_name'];
			}
		}
		if (in_array($permission, $permissions)) {
			return true;
		}

		return false;

	}

	// the following function will be used for vlaidating data while receiving by the post method..
	// this validation will be performed before inserting the data into database 
 	function validation($data) {
		 global $dbOb;
		 if (is_array($data)) {
			 return $data;
		 }
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		$data = mysqli_real_escape_string($dbOb->link, $data);
		return $data;
	}

// the following function will be used to get stock information of a product .
	function get_ware_house_stock($ware_house_serial_no, $product_id){

				global $dbOb;

				// getting total stock quantity of the product
				$query = "SELECT * FROM product_stock WHERE quantity > 0 AND ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id'";
				$get_stock = $dbOb->select($query);
				$stock_qty = 0;
				if ($get_stock) {
					while ($stock = $get_stock->fetch_assoc()) {
						$stock_qty += $stock['quantity'];
					}
				} // end of products stock


				// now getting Company return products 
				$query = "SELECT * FROM company_products_return WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id'";
				$get_comany_return = $dbOb->select($query);
				$company_return_qty = 0;
				if ($get_comany_return) {
					while ($company_return = $get_comany_return->fetch_assoc()) {
						$company_return_qty += $company_return['return_quantity'];
					}
				} // end of  Company return products 


				// now getting Market return products 
				$query = "SELECT * FROM market_products_return WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id'";
				$get_market_return = $dbOb->select($query);
				$market_return_qty = 0;
				if ($get_market_return) {
					while ($market_return = $get_market_return->fetch_assoc()) {
						$market_return_qty += $market_return['return_quantity'];
					}
				} // end of Market return products 


				// Now getting Unloaded trucks Products 
				$truck_load_serial_no = [];
				$query = "SELECT * FROM truck_load WHERE unload_status = 0 AND ware_house_serial_no = '$ware_house_serial_no'";
				$get_unloaded_truck = $dbOb->select($query);
				$truck_loaded_product_qty = 0;
				if ($get_unloaded_truck) {
					$i = 0 ;
					while ($row = $get_unloaded_truck->fetch_assoc()) {
						$truck_load_serial_no[$i] = $row['serial_no'];
						$truck_load_tbl_id = $row['serial_no'];
						$query = "SELECT * FROM truck_loaded_products WHERE truck_load_tbl_id = '$truck_load_tbl_id' AND product_id = '$product_id'";
						$get_unloaded_product = $dbOb->select($query);
						if ($get_unloaded_product) {
							$truck_loaded_product_qty += $get_unloaded_product->fetch_assoc()['quantity'];
						}
					}
				} // end of unloaded truck products
				
				$truck_load_serial = Null;
				$product_sell_qty = 0;
				if ($truck_load_serial_no) {
					$truck_load_serial = implode(',',$truck_load_serial_no);
				}
				if ($truck_load_serial) {
					// now getting Product sell
				$query = "SELECT * FROM order_delivery_expense WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id' 	AND delivery_status = 1 AND truck_load_serial_no NOT IN ($truck_load_serial) " ;
				$get_product_sell = $dbOb->select($query);
			
			
				if ($get_product_sell) {
					while ($product_sell = $get_product_sell->fetch_assoc()) {
						$product_sell_qty += $product_sell['qty'];
					}
				} // end of Product sell
				}
				


				// now getting own shop products that are taken from the ware house
				$query = "SELECT * FROM own_shop_stock_history WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id = '$product_id'";
				$get_store_product = $dbOb->select($query);
				$store_product_qty = 0;
				if ($get_store_product) {
					while ($row = $get_store_product->fetch_assoc()) {
						$store_product_qty += $row['quantity_packet'];
					}
				} // end of own shop products quantity 


				// now its time to calculate in stock quantity 
				$in_stock_qty = ($stock_qty*1 + $market_return_qty*1) - ($company_return_qty*1 + $product_sell_qty*1 + $truck_loaded_product_qty*1 + $store_product_qty*1);

				return $in_stock_qty;
	}

	// the following function is for getting product qty in a truck after delivering some products..
	function get_truck_load_qty($products_id_no, $load_serial_no) {
		 global $dbOb;
		 $query = "SELECT * FROM order_delivery_expense WHERE products_id_no ='$products_id_no' AND truck_load_serial_no = '$load_serial_no' AND delivery_status = 1";
		 $get_info = $dbOb->select($query);
		 $delivered_qty = 0 ;
		 if ($get_info) {
			 while ($row = $get_info->fetch_assoc()) {
				 $delivered_qty += $row['qty'];
			 }
		 }
		return $delivered_qty;
	}

 ?>