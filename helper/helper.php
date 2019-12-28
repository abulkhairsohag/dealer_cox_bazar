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

	function get_ware_house_in_stock($ware_house_serial_no, $product_id){
	
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

				// now getting Product sell
				$query = "SELECT * FROM order_delivery_expense WHERE ware_house_serial_no = '$ware_house_serial_no' AND products_id_no = '$product_id' 	AND delivery_status =  1";
				$get_product_sell = $dbOb->select($query);
				$product_sell_qty = 0;
				if ($get_product_sell) {
					while ($product_sell = $get_product_sell->fetch_assoc()) {
						$product_sell_qty += $product_sell['qty'];
					}
				} // end of Product sell

				// now its time to calculate in stock quantity 

				$in_stock_qty = ($stock_qty*1 + $market_return_qty*1) - ($company_return_qty*1 + $product_sell_qty);

				return $in_stock_qty;
	}


 ?>