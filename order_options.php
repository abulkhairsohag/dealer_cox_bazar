<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once ('helper/helper.php');
include_once("class/Database.php");
$dbOb = new Database();
if (isset($_POST['vehicle_reg_no'])) {
	$vehicle_reg_no = $_POST['vehicle_reg_no'];
	$query = "SELECT * FROM truck_load WHERE vehicle_reg_no = '$vehicle_reg_no' AND unload_status = '0'";
	$truck_load_tbl_id = $dbOb->find($query)['serial_no'];
	$query = "SELECT * FROM truck_loaded_products WHERE truck_load_tbl_id = '$truck_load_tbl_id'";
	$get_loaded_products = $dbOb->select($query);
}
?>

<tr>
	<td>
		<select name="products_id_no[]" class="form-control main_product_id product_id" id="products_id_no" name="products_id_no[]"  required>
			<option value=""></option>
			<?php
			if ($get_loaded_products) {
				while ($row = $get_loaded_products->fetch_assoc()) {
					?>
					<option value="<?php echo ($row['product_id']) ?>"> <?php echo ($row['product_id'] . ', ' . $row['products_name']) ?> </option>
					<?php
				}
			}
			

			?>
		</select>
	</td>
	<td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly=""></td>

	<td><input type="text"  class="form-control main_sell_price sell_price" id="sell_price" name="sell_price[]" readonly="" ></td>

	<td style="display: none"><input type="text"  class="form-control main_sell_price_pcs sell_price_pcs" id="sell_price_pcs" name="sell_price_pcs[]" readonly="" ></td>

	<td><input type="text"  class="form-control main_original_sell_price original_sell_price" id="original_sell_price" name="original_sell_price[]" readonly="" ></td>

	<td><input type="text"  class="form-control main_qty qty" id="qty" name="qty[]" value="" readonly=""></td>
	<td><input type="text"  class="form-control main_qty qty_pcs" id="qty_pcs" name="qty_pcs[]" value="" readonly="" ></td>

	<td style="display: none"><input type="text"  class="form-control main_qty pack_size" id="pack_size" name="pack_size[]"  readonly=""></td>


	<td><input type="text" class="form-control main_total_price total_price" id="total_price" name="total_price[]" readonly=""></td>
	<td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>

</tr>