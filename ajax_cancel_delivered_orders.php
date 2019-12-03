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

if (isset($_POST['cancel_order_tbl_serial_no'])) {

	$order_id = $_POST['cancel_order_tbl_serial_no'];
	$deliver_id = $_POST['cancel_delivery_tbl_serial_no'];

	$query = "DELETE FROM order_delivery WHERE serial_no = '$deliver_id'";
	$delete_deliv = $dbOb->delete($query);
	if ($delete_deliv) {
        // updating product quantity
        $query = "SELECT * FROM order_delivery_expense WHERE delivery_tbl_serial_no = '$deliver_id'";
        $get_exp_info = $dbOb->select($query);
        if ($get_exp_info) {
            while ($exp = $get_exp_info->fetch_assoc()) {
                $product_id = $exp['products_id_no'];
                $qty = $exp['quantity'];
                $query = "SELECT * FROM products WHERE products_id_no = '$product_id'";
                $get_product = $dbOb->select($query);
                if ($get_product) {
                    $new_qty = $get_product->fetch_assoc()['quantity']*1 + $qty*1;
                    $query = "UPDATE products set quantity = '$new_qty' WHERE products_id_no = '$product_id'";
                    $update_product = $dbOb->update($query);

                }
            }
        }
        // now deleting the ordered products from  order_delivery_expense table
        $query = "DELETE FROM order_delivery_expense  WHERE delivery_tbl_serial_no = '$deliver_id'";
        $delete_deliv_exp = $dbOb->delete($query); 
        
        // now updating the new order table and setting the cancel info
        if ($delete_deliv_exp) {
            $query = "UPDATE new_order_details 
            SET 
            delivery_cancel_report = '1', 
            delivery_report = '0'
            WHERE 
            serial_no = '$order_id'";
            $update_new_order = $dbOb->update($query);
            if ($update_new_order) {
                $message = "Congratulations! Order Successfully Cancelled...";
                $type = 'success';
                die(json_encode(['message'=>$message,'type'=>$type]));
            }else{
                $message = "Sorry! Deleted From Delivery But Not Cancelled Yeat..";
                $type = 'warning';
                die(json_encode(['message'=>$message,'type'=>$type]));
            }
        }

	
	}else{
		$message = "Sorry! Cancellation Failed.";
			$type = 'warning';
			die(json_encode(['message'=>$message,'type'=>$type]));
	}

}
	



?>