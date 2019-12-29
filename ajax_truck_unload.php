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


// changing area and getting the product quantity to be loaded
if (isset($_POST['reg_no'])) {
	$reg_no = $_POST['reg_no'];

		$query = "SELECT * FROM truck_load WHERE vehicle_reg_no = '$reg_no' AND unload_status = '0'";
		$get_load_info = $dbOb->find($query);
		$truck_load_tbl_id = $get_load_info['serial_no'];

		$product_loaded_qty = [];
		$product_loaded_offer_qty = [];
	

		if ($get_load_info) {
		
			$query = "SELECT * FROM truck_loaded_products WHERE truck_load_tbl_id = '$truck_load_tbl_id'";

		    $products_loaded = $dbOb->select($query);
		    if ($products_loaded) {
		    	while ($res = $products_loaded ->fetch_assoc()) {
		    		$product_id = $res['product_id'];
					$product_loaded_qty[$product_id] = $res['quantity'];
		    		$product_loaded_offer_qty[$product_id] = $res['quantity_offer'];
		    	}
			}

		}

		$product_delivered = [];
		$product_delivered_offer = [];
		foreach ($product_loaded_qty as $key => $value) {
			$product_delivered_qty = 0 ;
			$product_delivered_offer_qty = 0 ; 
			$query = "SELECT * FROM order_delivery_expense WHERE products_id_no = '$key' AND  truck_load_serial_no = '$truck_load_tbl_id' AND delivery_status = '1'";
			$get_delivery_info = $dbOb->select($query);

			if ($get_delivery_info) {

				while ($row = $get_delivery_info->fetch_assoc()) {
					$product_delivered_qty += $row['qty'] ;
					if ($row['offer_qty'] != 'N/A') {
			
						$product_delivered_offer_qty += $row['offer_qty'] ; 
					}else{
						$product_delivered_offer_qty = $row['offer_qty'];
					}
				}
			}
			$product_delivered[$key] = $product_delivered_qty; 
			$product_delivered_offer[$key] = $product_delivered_offer_qty; 
			
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
	                  <th style="text-align: center;">Loaded(Packet)</th>
	                  <th style="text-align: center;">Loaded Offer(PCS)</th>
	                  <th style="text-align: center;">Sold(Packet)</th>
	                  <th style="text-align: center;">Sold Offer(PCS)</th>
	                  <th style="text-align: center;">Back(Packet)</th>
	                  <th style="text-align: center;">Back Offer(PCS)</th>
	                </tr>
	              </thead>
	              <tbody id="">';

		foreach ($product_loaded_qty as $product_id => $loaded_packet) {
			$query = "SELECT * FROM products WHERE products_id_no = '$product_id'";
			$get_product = $dbOb->find($query);
			$name = $get_product['products_name'];
			$category = $get_product['category'];
			$loaded_offer_qty = $product_loaded_offer_qty[$product_id];
			$sold_packet = $product_delivered[$product_id];
			$sold_offer_qty = $product_delivered_offer[$product_id];
			$back_packet = $loaded_packet - $sold_packet ;
			$back_offer_qty = $loaded_offer_qty - $sold_offer_qty ;

			$product_info .='<tr> <td> <input type="text" class="form-control main_product_id product_id" name="product_id[]" readonly="" value="';
			$product_info .=$product_id;
			$product_info .= '"> </td> <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly="" value="';
			$product_info .=$name;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_loaded_packet loaded_packet" name="loaded_packet[]" readonly="" value="';
			$product_info .=$loaded_packet;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_loaded_offer_qty loaded_offer_qty" name="loaded_offer_qty[]" readonly="" value="';
			$product_info .=$loaded_offer_qty;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_sold_packet sold_packet" name="sold_packet[]" readonly="" value="';
			$product_info .=$sold_packet;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_sold_offer_qty sold_offer_qty" name="sold_offer_qty[]" readonly="" value="';
			$product_info .=$sold_offer_qty;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_back_packet back_packet" name="back_packet[]" readonly="" value="';
			$product_info .=$back_packet;
			$product_info .= '"></td>';

			$product_info .= ' <td><input type="text"   class="form-control main_back_offer_qty back_offer_qty" id="back_offer_qty" name="back_offer_qty[]" readonly=""  value="';
			$product_info .=$back_offer_qty;
			$product_info .= '" > </td> </tr>';
		}
		$product_info .= ' </tbody>  </table>';
		$product_info .= '<input type="hidden" name="load_id" id="load_id" value="';
					$product_info .= $truck_load_tbl_id ;
					$product_info .='">';

		echo json_encode(['product_info'=>$product_info]);
		die();
}


// inserting data into data base 

if (isset($_POST['submit'])) {
	
	$load_id = validation($_POST['load_id']);
	$unload_date = validation($_POST['unloading_date']);

	$product_id = validation($_POST['product_id']);
	$products_name = validation($_POST['products_name']);
	$loaded_packet = validation($_POST['loaded_packet']);
	$loaded_offer_qty = validation($_POST['loaded_offer_qty']);
	$sold_packet = validation($_POST['sold_packet']);
	$sold_offer_qty = validation($_POST['sold_offer_qty']);
	$back_packet = validation($_POST['back_packet']);
	$back_offer_qty = validation($_POST['back_offer_qty']);



	$query = "UPDATE  truck_load 
			  SET 
			  unload_status = '1',
			  unload_date = '$unload_date'
			  WHERE 
			  serial_no = $load_id ";
    $update_load = $dbOb->update($query);

    if ($update_load) {

    	for ($i=0; $i <count($product_id) ; $i++) { 
    
    		$query ="INSERT INTO truck_unloaded_products 
			  (truck_load_tbl_id,product_id,products_name,loaded_packet,loaded_offer_qty,sold_packet,sold_offer_qty,back_packet,back_offer_qty) 
			  VALUES 
			  ('$load_id', '$product_id[$i]','$products_name[$i]','$loaded_packet[$i]','$loaded_offer_qty[$i]','$sold_packet[$i]','$sold_offer_qty[$i]','$back_packet[$i]','$back_offer_qty[$i]') ";

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