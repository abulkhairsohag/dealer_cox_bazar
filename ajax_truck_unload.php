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

if (isset($_POST['id'])) {
	$employee_id = $_POST['id'];
	$query = "SELECT * FROM employee_main_info WHERE id_no = '$employee_id'";
	$get_emp_info = $dbOb->find($query);

	echo json_encode($get_emp_info);
}
if (isset($_POST['reg_no'])) {
	$vehicle_reg_no = $_POST['reg_no'];
	$query = "SELECT * FROM transport WHERE reg_no = '$vehicle_reg_no'";
	$get_vehicle = $dbOb->find($query);

	echo json_encode($get_vehicle);
}








// changing area and getting the product quantity to be loaded
if (isset($_POST['area'])) {
	$area_name = $_POST['area'];



		$query = "SELECT * FROM truck_load WHERE area_name = '$area_name' AND unload_status = '0'";
		$get_load_info = $dbOb->find($query);
		$load_id = $get_load_info['serial_no'];

		$product_id_qty_loaded = [];
		$order_numbers = [];
		$j = 0;
		$i = 0;

		if ($get_load_info) {
			
			$order_numbers = $get_load_info['order_numbers'];
			$serial_no_load  = $get_load_info['serial_no'];
			$query = "SELECT * FROM truck_loaded_products WHERE truck_load_tbl_id = '$serial_no_load'";

		    $products_loaded = $dbOb->select($query);
		    if ($products_loaded) {
		    	while ($res = $products_loaded ->fetch_assoc()) {
		    		$product_id = $res['product_id'];
		    		$product_id_qty_loaded[$product_id] = (int)$res['quantity'];
		    	}
			}

		}

		$order_numbers = explode(', ', $order_numbers);
		$product_delivered = [];
		foreach ($order_numbers as $key => $value) {
			$query = "SELECT * FROM order_delivery WHERE order_no = '$value'";
			$get_delivery_info = $dbOb->find($query);

			if ($get_delivery_info) {
				$delivery_serial_no = $get_delivery_info['serial_no'];

				$query = "SELECT * FROM order_delivery_expense WHERE delivery_tbl_serial_no = '$delivery_serial_no'";
				$delivered_product = $dbOb->select($query);
				 if ($delivered_product) {
			    	while ($res = $delivered_product ->fetch_assoc()) {
			    		$product_id = $res['products_id_no'];
			    	if(array_key_exists($product_id, $product_delivered))
			    	{
			    		$product_delivered[$product_id] +=   (int)$res['quantity'];
			    	}else{

			    	$product_delivered[$product_id] = (int)$res['quantity'];
			    		}
			    	
			    	}
			    }
			}
			
		}


		
		foreach ($order_numbers as $key => $value) {
			$query = "SELECT * FROM new_order_details WHERE order_no = '$value' AND delivery_report <> '1' 	OR delivery_cancel_report = '1'";
			$get_delivery_info = $dbOb->find($query);

			if ($get_delivery_info) {
				$delivery_serial_no = $get_delivery_info['serial_no'];

				$query = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$delivery_serial_no'";
				$cancel_and_pending_product = $dbOb->select($query);
				 if ($cancel_and_pending_product) {
			    	while ($res = $cancel_and_pending_product ->fetch_assoc()) {
			    		$product_id = $res['products_id_no'];
			    	if(array_key_exists($product_id, $product_delivered))
			    	{
			    		$product_delivered[$product_id] +=   0;
			    	}else{

			    	$product_delivered[$product_id] = 0;
			    		}
			    	
			    	}
			    }
			}
			
		}












	$product_info = '<div class="form-group bg-success" style="padding-bottom: 5px;margin-top: 30px">

	              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
	                Following Products To Be Unloaded From Truck.....
	              </div>
	            </div>

	            <table class="table" class="">

	              <thead>
	                <tr>
	                  <th style="text-align: center;">Product ID</th>
	                  <th style="text-align: center;">Product Name</th>
	                  <th style="text-align: center;">Category</th>
	                  <th style="text-align: center;">Loaded</th>
	                  <th style="text-align: center;">Sold</th>
	                  <th style="text-align: center;">Back</th>
	                </tr>
	              </thead>
	              <tbody id="">';

		foreach ($product_id_qty_loaded as $loaded_product_id => $qty_loaded) {
			$query = "SELECT * FROM products WHERE products_id_no = '$loaded_product_id'";
			$get_product = $dbOb->find($query);

			$name = $get_product['products_name'];
			$category = $get_product['category'];

			foreach ($product_delivered as $delivered_product_id => $qty_delivered) {
				if ($loaded_product_id == $delivered_product_id) {
					$return_qty = $qty_loaded - $qty_delivered;
					$product_info .='<tr> <td> <input type="text" class="form-control main_product_id product_id" name="product_id[]" readonly="" value="';
					$product_info .=$delivered_product_id;
					$product_info .= '"> </td> <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly="" value="';
					$product_info .=$name;
					$product_info .= '"></td>';

					$product_info .=  '<td><input type="text" class="form-control main_category category" name="category[]" readonly="" value="';
					$product_info .=$category;
					$product_info .= '">';

					$product_info .=  '<td><input type="text" class="form-control main_category loaded" name="loaded_qty[]" readonly="" value="';
					$product_info .=$qty_loaded;
					$product_info .= '">';

					$product_info .=  '<td><input type="text" class="form-control main_category sold" name="sold_qty[]" readonly="" value="';
					$product_info .=$qty_delivered;
					$product_info .= '">';

					$product_info .= '</td> <td><input type="number" min="0" step="1" class="form-control main_quantity quantity" id="unload_qty" name="unload_qty[]" readonly=""  value="';
					$product_info .=$return_qty;
					$product_info .= '" > </td> </tr>';
				}
			}

			
	               
		}
		$product_info .= ' </tbody>  </table>';
		$product_info .= '<input type="hidden" name="load_id" id="load_id" value="';
					$product_info .= $load_id ;
					$product_info .='">';
		


		echo json_encode(['option'=>$options,'product_info'=>$product_info,'load_info'=>$get_load_info]);
}






// inserting data into data base 

if (isset($_POST['submit'])) {
	
	$load_id = $_POST['load_id'];
	$unloading_date = $_POST['unloading_date'];

	$product_id = $_POST['product_id'];
	$products_name = $_POST['products_name'];
	$category = $_POST['category'];
	$loaded_qty = $_POST['loaded_qty'];
	$sold_qty = $_POST['sold_qty'];
	$unload_qty = $_POST['unload_qty'];



	$query = "UPDATE  truck_load 
			  SET 
			  unload_status = '1',
			  unload_date = '$unload_date'
			  WHERE 
			  serial_no = $load_id ";
    $update_load = $dbOb->update($query);

    if ($update_load) {

    	for ($i=0; $i <count($product_id) ; $i++) { 
    		$id = $product_id[$i];
    		$name = $products_name[$i];
    		$cat = $category[$i];
    		$load =  $loaded_qty[$i];
			$sold =  $sold_qty[$i];
			$unload =  $unload_qty[$i];

    		$query ="INSERT INTO truck_unloaded_products 
			  (truck_load_tbl_id, product_id, products_name, category, loaded_qty, sold_qty, unload_qty) 
			  VALUES 
			  ('$load_id', '$id', '$name', '$cat', '$load', '$sold', '$unload') ";

			$insert_unload = $dbOb->insert($query);

    	}

    	if ($insert_unload) {
    		$message = "Truck Unloaded Successfully";
    		$type = 'success';
    		echo json_encode(['message'=>$message,'type'=>$type]);
    	}else{
    		$message = "Truck Unload Failed";
    		$type = 'warning';
    		echo json_encode(['message'=>$message,'type'=>$type]);

    	}
    }
}

 ?>