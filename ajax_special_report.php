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

include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['from_date'])) {
	
 	$from_date = strtotime($_POST['from_date']);
 	$from_date_show = $_POST['from_date'];
 	$to_date = strtotime($_POST['to_date']);
 	$to_date_show = $_POST['to_date'];
	 $report_type = $_POST['report_type'];
	//  die($report_type);
	$pr_id  = $_POST['product_id'];

	$area = $_POST['area'];
	// die($area);
	
	$print_table = 'print_table';
	$printing_date = date('d F, Y');
	$printing_time = date('h:i:s A');
    
    $query = "SELECT * FROM invoice_setting";
    $get_invoice = $dbOb->select($query);
    if ($get_invoice) {
    $invoice_setting = $get_invoice->fetch_assoc();
    }

		$company_profile = '';
		$query = "SELECT * FROM profile";
		$get_profile = $dbOb->select($query);
		if ($get_profile) {
			$company_profile = $get_profile->fetch_assoc();
			// die('sohag');
		}
		if ($from_date_show == $to_date_show) {
			$show_date = 'Report Date :'.$from_date_show ;
		}else{
			$show_date = 'Report Date : '.$from_date_show.' <span class="badge bg-red"> TO </span> '.$to_date_show;
		}

 	$query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
 	$product_info = $dbOb->find($query);


    if ($report_type == 'all_product_stock_and_sell') {

		$query = "SELECT * FROM products ORDER BY serial_no DESC";
		$get_product = $dbOb->select($query);
		
		$stock_tbl = '<div  id="print_table" style="color:black">
							<span class="text-center">
								<h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
								<h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
								<h5>'.$show_date.'</h5>
								
						</span>
						<div class="text-center">
							<h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>ALL PRODUCT STOCK & SELL</b></h4>
						</div>
						<br>
							<table class="table table-responsive">
								<tbody>
									<tr>
										<td>
											
										</td>
										<td class="text-center">
											
										</td>
										<td class="text-right">
											<h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span></span>'.$printing_date.'</span></h5>
											<h5 style="margin:0px ; margin-top: -8px;">Time : <span></span>'.$printing_time.'</span></h5>
										</td>
									</tr>
								
								</tbody>
							</table>
						<!--     
						<hr> -->';

		$stock_tbl .= '<table class="table table-bordered table-responsive">
							<thead style="background:#4CAF50; color:white" >
								<tr>
									<th>Sl<br> No.</th>
									<th>Product<br>Name</th>
									<th>Purchase<br>(Qty)</th>
									<th>Purchase<br>(Taka)</th>
									<th>Return To <br> Company (Qty)</th>
									<th>Product <br> Sell (Qty)</th>
									<th>Product <br> Sell (Taka)</th>
									<th>Profit On<br>Sell (Taka)</th>
									<th>In Stock<br>(Qty)</th>
									<th>In Stock<br>(Taka)</th>
								</tr>
							</thead>
							<tbody>';

		$total_purchase_amt = 0;
		$total_product_sell_amt = 0;
		$total_profit_on_sell_amt = 0 ;
		$total_in_stock_amt = 0;
		
		if ($get_product) {
			$i=0;
			while ($row = $get_product->fetch_assoc()) {

				$i++;
				$products_id_no = $row['products_id_no'];

				// Product Stock
				$stock_query = "SELECT * FROM product_stock WHERE products_id_no = '$products_id_no'";
				$get_stock = $dbOb->select($stock_query);
				if ($get_stock) {
					$stock = 0;
					$return = 0;
					$product_sell = 0;
					$return_product = 0;
					while ($stock_row = $get_stock->fetch_assoc()) {
						if (strtotime($stock_row['stock_date']) >= $from_date && strtotime($stock_row['stock_date']) <= $to_date ) {
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
				}
	
				//  Product Sell
				$order_query = "SELECT * FROM order_delivery_expense WHERE products_id_no = '$products_id_no'";
				$get_order = $dbOb->select($order_query);
				if ($get_order) {
					
					while ($order_row = $get_order->fetch_assoc()) {
						if (strtotime($order_row['date']) >= $from_date && strtotime($order_row['date']) <= $to_date ) {
							$order_quantity = $order_row['quantity'];
							$product_sell = $product_sell + $order_quantity;
						}
						
					}
				}
	
				// Return Product Order
				$return_query = "SELECT * FROM market_products_return WHERE products_id_no = '$products_id_no'";
				$get_return = $dbOb->select($return_query);
				if ($get_return) {
					
					while ($order_row = $get_return->fetch_assoc()) {
						if (strtotime($order_row['return_date']) >= $from_date && strtotime($order_row['return_date']) <= $to_date ) {
							$return_quantity = $order_row['return_quantity'];
							$return_product = $return_product + $return_quantity;
						}
						
					}
				}
	
				$grand_total_stock = $total_stock - $product_sell;
				$grand_total_stock = $grand_total_stock + $return_product;

				$company_return_price = $return*$row['actual_purchase_price'];

				

				$mrp = $row['mrp_price'];
				$unit_tp = $mrp - ($mrp* $invoice_setting['discount_on_mrp'])/100;
				$unit_vat = $unit_tp*$invoice_setting['vat']/100;
				$total_tp = $unit_tp;
				$total_vat = $unit_vat;
				$total_price = (float)$total_tp + (float)$total_vat; 
				$discount_on_total_tp = $total_tp * $invoice_setting['discount_on_tp'] / 100 ;
				$sell_price = $total_price - $discount_on_total_tp;
				$sell_price = $sell_price -($sell_price*$invoice_setting['special_discount']/100);
				
				$stock_tbl .= '<tr>
									<td>'. $i.' </td>
									<td> '. ucfirst($row['products_name']).'</td>
									<td> '. $stock.'</td>
									<td> '. $stock*$row['actual_purchase_price'].'</td>
									<td> '. $return.'</td>
									<td> '. $product_sell.'</td>
									<td> '. round($product_sell * $sell_price).'</td>
									<td> '. (round($product_sell * $sell_price) - ($product_sell*$row['actual_purchase_price'])).'</td>
									<td> '. $row['quantity'].'</td>
									<td> '. $row['quantity']*$row['actual_purchase_price'].'</td>
								</tr>';

				$total_purchase_amt += $stock*$row['actual_purchase_price'];
				$total_product_sell_amt += round($product_sell * $sell_price);
				$total_profit_on_sell_amt +=  (round($product_sell * $sell_price) - ($product_sell*$row['actual_purchase_price']));
				$total_in_stock_amt += $row['quantity']*$row['actual_purchase_price'];

			}
		}
		$stock_tbl .= '<tr class="bg-success"  style="color:red">
							<td colspan="3" class="text-right">Total Amount</td>
							<td colspan=""> '.$total_purchase_amt.'</td>
							<td colspan="2"></td>
							<td> '.$total_product_sell_amt.'</td>
							<td> '.$total_profit_on_sell_amt.'</td>
							<td colspan=""></td>
							<td colspan="2"> '.$total_in_stock_amt.'</td>
						</tr>';
		$print_table = 'print_table';
		$stock_tbl .= '  </tbody>
		</table></div>
		<div class="mt-3">
							<a class=" text-light btn-success btn" onclick="printContent(\''.$print_table.'\')"><i class="icon-printer"></i> Print</span> </a>
							</div>';
		
		echo json_encode($stock_tbl);
			exit();

	}


}
 ?>