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
$company = "";
// this section is for showing full information
if (isset($_POST['products_id_no_view'])) {
	$products_id_no = $_POST['products_id_no_view'] ;

	// $query = "SELECT * FROM `products` WHERE products_id_no = '$products_id_no'";
	// $get_products_info = $dbOb->find($query);

	// $query = "SELECT * FROM `product_stock` WHERE products_id_no = '$products_id_no'";
	// $get_stock = $dbOb->select($query);
	// $total_buy = 0;
	// if ($get_stock) {
	// 	while ($row = $get_stock->fetch_assoc()) {
	// 		$total_buy = (int)$total_buy + (int)$row['quantity'] ;
	// 	}
	// }
	// $totla_sell = (int)$total_buy - (int)$get_products_info['quantity'];


  $query = "SELECT * FROM `products` WHERE products_id_no = '$products_id_no'";
  $get_product = $dbOb->select($query);
  $get_products_info = $dbOb->find($query);
  
  if ($get_product) {
      $i=0;
      while ($row = $get_product->fetch_assoc()) {
          $i++;
          $products_id_no = $row['products_id_no'];
          $stock_query = "SELECT * FROM product_stock WHERE products_id_no = '$products_id_no'";
          $get_stock = $dbOb->select($stock_query);
          $stock = 0;
          $return = 0;
          if ($get_stock) {
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
          $product_sell = 0;
          if ($get_order) {
              while ($order_row = $get_order->fetch_assoc()) {
                  $order_quantity = $order_row['quantity'];
                  $product_sell = $product_sell + $order_quantity;
                  
              }
          }

          // return product Order
          $return_query = "SELECT * FROM market_products_return WHERE products_id_no = '$products_id_no'";
          $get_return = $dbOb->select($return_query);
          $return_product = 0;
          if ($get_return) {
              while ($order_row = $get_return->fetch_assoc()) {
                  $return_quantity = $order_row['return_quantity'];
                  $return_product = $return_product + $return_quantity;
                  
              }
          }

          $grand_total_stock = $total_stock - $product_sell;
          $grand_total_stock = $grand_total_stock + $return_product;
          
      }
      }
	echo json_encode(['products_info'=>$get_products_info,'buy'=>$stock,'sell'=>$product_sell,'return_from_market'=>$return_product,'return_to_company'=>$return, 'in_stock'=>$grand_total_stock]);
}





// the following section is for fetching data from database 
if (isset($_POST["sohag_company"])) 
	$company = $_POST["sohag_company"];
	 
          $query = "SELECT * FROM products WHERE company = '$company' ORDER BY serial_no DESC";
          $get_products = $dbOb->select($query);
          if ($get_products) {
            $i=0;
            while ($row = $get_products->fetch_assoc()) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['company']; ?></td>
                <td><?php echo $row['products_id_no']; ?></td>
                <td><?php echo $row['products_name']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['company_price']; ?></td>
                <td><?php echo $row['mrp_price']; ?></td>
                <td><?php echo $row['pack_size']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                 <td align="center">

                   
                  <?php 
                  if (permission_check('product_view_button')) {
                    ?>
                    
                    <a class="badge bg-green view_details"  id="<?php echo $row['products_id_no'] ?>" data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a>
                  <?php } ?>
                  
                  
                </td>
                
              </tr>

              <?php
            }

}

?>