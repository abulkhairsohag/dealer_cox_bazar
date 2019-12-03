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

	$query = "SELECT * FROM market_products_return WHERE employee_id_delivery = '$employee_id' AND unload_status = '0'";
	$get_returned_product = $dbOb->select($query);

    $product = [];

	if ($get_returned_product) {
		while ($row = $get_returned_product->fetch_assoc()) {
			$product_id = $row['products_id_no'];

	    	if(array_key_exists($product_id, $product)){
	    		$product[$product_id] += (int)$row['return_quantity'];
	    	}else{
	    		$product[$product_id] = (int)$row['return_quantity'];
    		}
		}
	}



      $sell_price = [];
		foreach ($product as $key => $value) {
			$query = "SELECT * FROM market_products_return WHERE products_id_no = '$key' ORDER BY serial_no DESC";
			$get_sell_price = $dbOb->find($query);
			$sell_price[$key] = $get_sell_price['marketing_sell_price'];
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
	                  <th style="text-align: center;">Merket Sell Price</th>
	                  <th style="text-align: center;">Returned</th>
	                  <th style="text-align: center;">Total Price</th>
	                </tr>
	              </thead>
	              <tbody id="">';

	    foreach ($product as $key => $value) {
	    	$query = "SELECT * FROM products WHERE products_id_no = '$key'";
			$get_product = $dbOb->find($query);

			$id = $key;
			$name = $get_product['products_name'];
			$category = $get_product['category'];
			$return_qty = $value;
			$marketing_sell_price = $sell_price[$key];
			$total_price = (int)($return_qty * $marketing_sell_price) ;

			$product_info .='<tr> <td> <input type="text" class="form-control main_product_id product_id" name="product_id[]" readonly="" value="';
					$product_info .=$id;
					$product_info .= '"> </td> <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly="" value="';
					$product_info .=$name;
					$product_info .= '"></td>';

					$product_info .=  '<td><input type="text" class="form-control main_category category" name="category[]" readonly="" value="';
					$product_info .=$category;
					$product_info .= '">';

					$product_info .=  '<td><input type="text" class="form-control main_category loaded" name="loaded_qty[]" readonly="" value="';
					$product_info .=$marketing_sell_price;
					$product_info .= '">';

					$product_info .=  '<td><input type="text" class="form-control main_category sold" name="sold_qty[]" readonly="" value="';
					$product_info .=$return_qty;
					$product_info .= '">';

					$product_info .= '</td> <td><input type="number" min="0" step="1" class="form-control main_quantity quantity" id="unload_qty" name="unload_qty[]" readonly=""  value="';
					$product_info .=$total_price;
					$product_info .= '" > </td> </tr>';



	    }
		$product_info .= ' </tbody>  </table>';



	echo json_encode(['get_emp_info'=>$get_emp_info,'product_info'=>$product_info]);
}




















// inserting data into data base 

if (isset($_POST['submit'])) {
	
	$employee_id = $_POST['employee_id'];
	$product_id = $_POST['product_id'];

	$unload_date = date("d-m-Y");

	for ($i=0; $i < count($product_id) ; $i++) { 
		$prdct_id = $product_id[$i];
		$query = "UPDATE market_products_return 
				  SET 
				  unload_status = '1',
				  unload_date = '$unload_date'
				  WHERE employee_id_delivery = '$employee_id' AND products_id_no = '$prdct_id' AND unload_status = '0' ";
		$update_mrkt_return_prdct = $dbOb->update($query);
	}

    	if ($update_mrkt_return_prdct) {
    		$message = "Returned Products Stored Back Successfully";
    		$type = 'success';
    		echo json_encode(['message'=>$message,'type'=>$type]);
    	}else{
    		$message = "Store  Failed";
    		$type = 'warning';
    		echo json_encode(['message'=>$message,'type'=>$type]);

    	}
}

 ?>