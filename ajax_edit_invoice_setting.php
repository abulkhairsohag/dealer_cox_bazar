<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
$user_type = Session::get("user_type");
?>


<?php 

include_once("class/Database.php");
$dbOb = new Database();

if (isset($_POST['submit'])) {

	$discount_on_mrp  = $_POST['discount_on_mrp'];
	$vat		      = $_POST['vat'];
	$discount_on_tp   = $_POST['discount_on_tp'];
	$special_discount = $_POST['special_discount'];

	if (isset($_POST['show_dues'])) {
		$show_dues	= 1;
	}else{
		$show_dues	= 0;
	}
	
	$edit_id		  = $_POST['edit_id'];

	$query = "UPDATE invoice_setting 
	SET
	discount_on_mrp = '$discount_on_mrp',
	discount_on_tp = '$discount_on_tp',
	special_discount = '$special_discount',
	vat = '$vat',
	show_dues = '$show_dues'
	WHERE
	serial_no = '$edit_id'
	";
	$update_info = $dbOb->update($query);
	if ($update_info) {
		$message = 'Information successfully updated.';
		$type = 'success';
		echo json_encode([
			'message'=>$message,
			'type'=>$type,
			'discount_on_mrp'=>$discount_on_mrp,
			'vat'=>$vat,
			'discount_on_tp'=>$discount_on_tp,
			'special_discount'=>$special_discount,
			'show_dues'=>$show_dues,
		]);
	}else{
		$message = 'Information not updated.';
		$type = 'warning';
		echo json_encode(['messsage'=>$messsage,'type'=>$type]);
	}
}

if (isset($_POST['serial_no_edit_info'])) {
	$serial_no = $_POST['serial_no_edit_info'];
	// die($serial_no);
	$query = "SELECT * FROM invoice_setting WHERE serial_no = '$serial_no'";	
	$get_invoice_setting_details = $dbOb->find($query);
	echo json_encode($get_invoice_setting_details);
}

?>