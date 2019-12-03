<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');

include_once("class/Database.php");
$dbOb = new Database();

if (isset($_POST['customer'])) {
	$cus_id = $_POST['customer'];
	$query = "SELECT * FROM own_shop_client where serial_no ='$cus_id'";
	$get_customer =$dbOb->find($query);
	echo  json_encode($get_customer);
}

// now we are going to add information 

if (isset($_POST['submit'])) {
	$order_no  		= $_POST['order_no'];
	$employee_id    = $_POST['employee_id'];
	$employee_name  = $_POST['employee_name'];

	$customer_id  	= $_POST['customer_id'];
	$customer_name  = $_POST['customer_name'];
	$mobile_no   	= $_POST['mobile_no'];

	$products_id_no = $_POST['products_id_no'];
	$products_name 	= $_POST['products_name'];
	$quantity      	= $_POST['quantity'];
	$sell_price    	= $_POST['sell_price'];
	$mrp_price     	= $_POST['mrp_price'];
	$total_price   	= $_POST['total_price'];
	$promo_offer   	= $_POST['promo_offer'];

	$sell_date   = date("d-m-Y");

	$net_total     	 = $_POST['net_total'];
	$vat           	 = $_POST['vat'];
	$vat_amount    	 = $_POST['vat_amount'];
	$discount      	 = $_POST['discount'];
	$discount_amount = $_POST['discount_amount'];
	$grand_total     = $_POST['grand_total'];
	$pay             = $_POST['pay'];
	if ($pay=='null' || $pay == '') {
		$pay = 0;
	}
	$due             = $_POST['due'];

	$query = "INSERT INTO  own_shop_sell

			(order_no,employee_id,employee_name,customer_id,customer_name,mobile_no,net_total,vat,vat_amount,discount,discount_amount,grand_total,pay,due,sell_date)

			VALUES

			('$order_no','$employee_id','$employee_name','$customer_id','$customer_name','$mobile_no','$net_total','$vat','$vat_amount','$discount','$discount_amount','$grand_total','$pay','$due','$sell_date')";

	$last_id =$dbOb->custom_insert($query);
	$insert_own_shop_sell_product = '';

	if ($last_id) {
		for ($i=0; $i < count($products_id_no); $i++) {
			$date = date('d-m-Y');
			$query = "INSERT INTO  own_shop_sell_product
			(sell_tbl_id,products_id_no,products_name,quantity,sell_price,	mrp_price,total_price,promo_offer,sell_date)
			VALUES
			('$last_id','$products_id_no[$i]','$products_name[$i]','$quantity[$i]','$sell_price[$i]',	'$mrp_price[$i]','$total_price[$i]','$promo_offer[$i]','$sell_date')";

			$insert_own_shop_sell_product =$dbOb->insert($query);

			$product_id_number = $products_id_no[$i];
			$query = "SELECT * FROM products WHERE products_id_no = '$product_id_number'";
			$get_product_tbl = $dbOb->find($query);

			$persent_product_qty = $get_product_tbl["quantity"];

			$available_qty_after_sell = (int)$persent_product_qty - (int)$quantity[$i];
			$query = "UPDATE products SET quantity = '$available_qty_after_sell' WHERE products_id_no = '$product_id_number'";
			$product_tbl_update = $dbOb->update($query);
		}
		if ($product_tbl_update) {
			$message = "Congratulaiton! Products Sold Successfully.";
			$type = "success";
			echo json_encode(['message'=>$message,'type'=>$type]);
		} else{
			$message = "Sorry!Failed To Sell Products.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}
	// insert completed 


}

	// delete sell 

	if (isset($_POST['delete_id'])) {
	 	$delete_id = $_POST['delete_id'];
	 	// echo json_encode($delete_id);
	 	// die();

	 	$query = "DELETE FROM own_shop_sell WHERE serial_no = '$delete_id'";
	 	$delete_sell = $dbOb->delete($query);

	 	if ($delete_sell) {
	 		$query = "SELECT * FROM own_shop_sell_product WHERE sell_tbl_id = '$delete_id'";
	 		$get_product = $dbOb->select($query);

	 		$query = "DELETE FROM own_shop_sell_product WHERE sell_tbl_id = '$delete_id'";
	 		$delete_products = $dbOb->delete($query);
	 		if ($delete_products) {
	 			if ($get_product) {
	 				while ($row = $get_product->fetch_assoc()) {
	 					$product_id = $row['products_id_no'];
	 					$quantity = $row['quantity'];
	 					$query = "SELECT * FROM products WHERE products_id_no = '$product_id'";
	 					$get_product_info = $dbOb->find($query);
	 					$present_qty = (int)$get_product_info['quantity'] + (int)$quantity;

	 					$query = "UPDATE products SET quantity = '$present_qty' WHERE products_id_no = '$product_id'";
	 					$update_product = $dbOb->update($query);
	 				}
	 			}
	 		}
	 	}
	 	if ($update_product) {
	 		$message = 'Sell Deleted.';
	 		$type = "success";
	 		echo json_encode(['message'=>$message,'type'=>$type]);
	 	}else{
	 		$message = 'Sell Not Deleted.';
	 		$type = "warning";
	 		echo json_encode(['message'=>$message,'type'=>$type]);}
	 }





	 // The following section is for showing data 
if (isset($_POST['serial_no_view'])) {
	$serial_no = $_POST['serial_no_view'];

	$query_details = "SELECT * FROM own_shop_sell WHERE serial_no = '$serial_no'";
	$query_expense = "SELECT * FROM own_shop_sell_product WHERE sell_tbl_id = '$serial_no'";

	$order_details = $dbOb->find($query_details);
	$order_expense = $dbOb->select($query_expense);
	$tr = '' ;
	if ($order_expense) {
		$i = 0;
		while ($row = $order_expense->fetch_assoc()) {
			$i++;
			$tr .='<tr style="color:black"><td>';
			$tr .= $i;
			$tr .= '</td><td>';
			$tr .=($row["products_id_no"]);
			$tr .= '</td><td>';
			$tr .= $row["products_name"] ;
			$tr .= '</td><td>';
			$tr .= $row["promo_offer"];
			$tr .= '</td><td>';
			$tr .= $row["mrp_price"] ;
			$tr .= '</td><td>';
			$tr .= $row["quantity"];
			$tr .= '</td><td>';
			$tr .= $row["sell_price"];
			$tr .= '</td><td class="text-right">';
			$tr .= number_format($row["total_price"],2);
			$tr .= '</td></tr>';
		}

		$tr .= '<tr style="color:black"><td colspan="7" style="text-align: right;">Net Total (৳)  </td><td colspan="1" class="text-right">';
		$tr .= number_format($order_details['net_total'],2);

		$tr .= '</td></tr><tr style="color:black"><td colspan="7" style="text-align: right;">vat  (';
		$tr .= $order_details['vat'];
		$tr .=' % )  </td>';


		$tr .= '<td colspan="1" class="text-right">';
		$tr .= number_format($order_details['vat_amount'],2);

		$tr .='</td></tr>';

		$tr .= '<tr style="color:black"><td colspan="7" style="text-align: right;">Discount (';
		$tr .= $order_details['discount'];
		$tr .= '%)  </td>';
		$tr .= '<td colspan="1" class="text-right">';
		$tr .= number_format($order_details['discount_amount'],2);

		$tr .= '</td></tr>';

		$tr .= '<tr style="color:black"><td colspan="7" style="text-align: right;">Grand Total (৳)  </td><td colspan="1" class="text-right" style="color:blue">';
		$tr .= number_format($order_details['grand_total'],2);
		$tr .= '</td></tr><tr style="color:black"><td colspan="7" style="text-align: right;">Total Paid (৳)  </td><td colspan="1" class="text-right" style="color:green">';
		$tr .= number_format($order_details['pay'],2);
		$tr .= '</td></tr><tr style="color:black"><td colspan="7" style="text-align: right;">due (৳)  </td><td colspan="1" class="text-right" style="color:red">';
		$tr .= number_format($order_details['due'],2);
		$tr .= '</td></tr>';
	}

	echo json_encode(['details'=>$order_details,'expense'=>$tr]);
}




	 // the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
          
            $query = "SELECT * FROM own_shop_sell ORDER BY serial_no DESC ";
              $get_order_info = $dbOb->select($query);
              if ($get_order_info) {
                $i=0;
                while ($row = $get_order_info->fetch_assoc()) {
                  $i++;

                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['grand_total']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['due']; ?></td>
                    <td><?php echo $row['sell_date']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('sale_product_view_button')) {
                        ?>
                         <a  class="badge  bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a> 
                         <?php } ?>

                      <?php 
                      if (permission_check('sale_product_edit_button')) {
                        ?>
                        <a href="edit_own_shop_sell.php?serial_no=<?php echo urldecode($row['serial_no']);?>" class="badge  bg-blue edit_data" >Edit </a>
                      <?php } ?>
                      
                      <?php 
                      if (permission_check('sale_product_delete_button')) {
                        ?>
                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 

                      <?php } ?>  
                    </td>
                  </tr>


                  <?php
                }
              }
             
}

?>