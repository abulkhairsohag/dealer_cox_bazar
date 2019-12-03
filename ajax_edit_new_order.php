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

if (isset($_POST['products_id_no_get_info'])) {
	$products_id_no = $_POST['products_id_no_get_info'];

	$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
	$get_products = $dbOb->find($query);
	$today = date("d-m-Y");
	$offer = "";

	if (strtotime($get_products['offer_start_date']) <= strtotime($today) && strtotime($get_products['offer_end_date'])>=strtotime($today) ) {
		$offer = $get_products['promo_offer'];
	}else{
		$offer = "----";
	}
	echo json_encode(['products'=>$get_products,'offer'=>$offer]);
}

// now we are going to add information 

	// now we are going to add data into database

if (isset($_POST['submit'])) {

	$employee_id       = $_POST['employee_id'];
	$employee_name     = $_POST['employee_name'];
	$area_employee     = $_POST['area_employee'];
	$order_date     = $_POST['date'];

	// $employee_company  = $_POST['employee_company'];

	$cust_id  = $_POST['cust_id'];
	$customer_name  = $_POST['customer_name'];
	$shop_name = $_POST['shop_name'];
	$address   = $_POST['address'];
	$mobile_no = $_POST['mobile_no'];

	
	$products_id_no = $_POST['products_id_no'];
	$products_name = $_POST['products_name'];
	$pack_size = $_POST['pack_size'];
	$unit_tp = $_POST['unit_tp'];
	$unit_vat = $_POST['unit_vat'];
	$tp_plus_vat = $_POST['tp_plus_vat'];
	$qty = $_POST['qty'];
	$total_tp = $_POST['total_tp'];
	$total_vat = $_POST['total_vat'];
	$total_price = $_POST['total_price'];

	$net_total         = $_POST['net_total'];
	$net_total_tp         = $_POST['net_total_tp'];
	$net_total_vat         = $_POST['net_total_vat'];
	$discount_on_tp         = $_POST['discount'];
	$discount_amount  = $_POST['discount_amount'];
	$payable_without_extra_discount      = $_POST['payable_amt'];
	$extra_discount      = $_POST['extra_discount'];
	$payable_amt      = $_POST['net_payable_amt'];

	$edit_id 		 = $_POST['edit_id'];

	$query = "UPDATE  new_order_details
	SET 
	employee_id 	= '$employee_id',
	employee_name 	= '$employee_name',
	area_employee 	= '$area_employee',
	cust_id 	= '$cust_id',
	customer_name 	= '$customer_name',
	shop_name 	= '$shop_name',
	address 	= '$address',
	mobile_no 	= '$mobile_no',
	discount_on_tp = '$discount_on_tp',
	discount_amount = '$discount_amount',
	payable_without_extra_discount = '$payable_without_extra_discount',
	extra_discount = '$extra_discount',
	payable_amt = '$payable_amt',
	due = '$payable_amt',
	order_date = '$order_date',
	net_total = '$net_total',
	net_total_tp = '$net_total_tp',
	net_total_vat = '$net_total_vat'
	WHERE
	serial_no = '$edit_id'";

	$update_order_info  =$dbOb->update($query);
	$insert_order_expense = '';


	if ($update_order_info) {
		$query = "DELETE FROM new_order_expense WHERE new_order_serial_no = '$edit_id'";
		$delete_order_expense = $dbOb->delete($query);
		if ($delete_order_expense) {

			for ($i=0; $i < count($products_id_no); $i++) {
				$query = "INSERT INTO  new_order_expense
				(new_order_serial_no,products_id_no,products_name,pack_size,unit_tp,unit_vat,tp_plus_vat,quantity,total_tp,total_vat,total_price)
				VALUES
				('$edit_id','$products_id_no[$i]','$products_name[$i]','$pack_size[$i]','$unit_tp[$i]','$unit_vat[$i]','$tp_plus_vat[$i]','$qty[$i]','$total_tp[$i]','$total_vat[$i]','$total_price[$i]')";

				$insert_order_expense =$dbOb->insert($query);
			}


			if ($insert_order_expense) {
				  $message = "Congratulations! Information Is Successfully Updated.";
		          $type = "success";
		          Session::set("update_message",$message);
		          Session::set("update_type",$type);
		          echo json_encode(['message'=>$message,'type'=>$type]);
			}else{
				$message = "Sorry! Order Is Not Updated.";
				$type = "warning";
				echo json_encode(['message'=>$message,'type'=>$type]);

			}

		}


	} else{
		$message = "Sorry! Information Is Not Saved.";
		$type = "warning";
		echo json_encode(['message'=>$message,'type'=>$type]);

	}



	      } // end of  if (isset($_POST['submit']))

	      ?>