<?php
include_once('include/header.php');
include_once("class/Database.php");
$dbOb = new Database();
$query = "SELECT * FROM products ORDER BY serial_no DESC";
$get_product = $dbOb->select($query);
?>

<?php 
if(!permission_check('total_stock_product')){
  ?>
  <script>
    window.location.href = '403.php';
  </script>
  <?php 
}
 ?>
 
<div class="right_col" role="main">
	<div class="row">
		<!-- page content -->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Total Stock Report </h2>
					<div class="row float-right" align="right">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Product Name</th>
								<th>Company</th>
								<th>Company Price</th>
								<th>Stock</th>
								<th>Return To Company</th>
								<th>Product Sell</th>
								<th>Return From Market</th>
								<th>Total Stock</th>
							</tr>
						</thead>
						<tbody  id="tbl_body">
							<?php
							if ($get_product) {
								$i=0;
								while ($row = $get_product->fetch_assoc()) {
									$i++;
									$products_id_no = $row['products_id_no'];
									$stock_query = "SELECT * FROM product_stock WHERE products_id_no = '$products_id_no'";
									$get_stock = $dbOb->select($stock_query);
									if ($get_stock) {
										$stock = 0;
										$return = 0;
										while ($stock_row = $get_stock->fetch_assoc()) {
											$quantity = $stock_row['quantity'];
											if ($quantity > 0) {
												$stock = $stock + $quantity;
											}else{
												$return = $return + $quantity;
												$return = $return * (-1);
											}
											$total_stock = $stock - $return;
										}
									}

									//  product Sell
									$order_query = "SELECT * FROM order_delivery_expense WHERE products_id_no = '$products_id_no'";
									$get_order = $dbOb->select($order_query);
									if ($get_order) {
										$product_sell = 0;
										while ($order_row = $get_order->fetch_assoc()) {
											$order_quantity = $order_row['quantity'];
											$product_sell = $product_sell + $order_quantity;
											
										}
									}

									// return product Order
									$return_query = "SELECT * FROM market_products_return WHERE products_id_no = '$products_id_no'";
									$get_return = $dbOb->select($return_query);
									if ($get_return) {
										$return_product = 0;
										while ($order_row = $get_return->fetch_assoc()) {
											$return_quantity = $order_row['return_quantity'];
											$return_product = $return_product + $return_quantity;
											
										}
									}

									$grand_total_stock = $total_stock - $product_sell;
									$grand_total_stock = $grand_total_stock + $return_product;
									?>


									<tr>
										<td> <?php echo $i; ?> </td>
										<td> <?php echo ucfirst($row['products_name']); ?> </td>
										<td> <?php echo ucfirst($row['company']); ?> </td>
										<td> <?php echo $row['company_price']; ?> </td>
										<td> <?php echo $stock; ?> </td>
										<td> <?php echo $return; ?> </td>
										<td> <?php echo $product_sell; ?> </td>
										<td> <?php echo $return_product; ?> </td>
										<td> <?php echo $grand_total_stock; ?> </td>
									</tr>
									<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php include_once('include/footer.php'); ?>
</body>
</html>