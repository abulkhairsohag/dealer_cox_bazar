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

	// fetching account info using an account number
	if (isset($_POST['office_account_no_sohag'])) {
		$office_account_no = $_POST['office_account_no_sohag'];
		$query = "SELECT * FROM account WHERE bank_account_no = '$office_account_no'";
		$get_bank_account = $dbOb->find($query);
		if ($get_bank_account) {
			echo json_encode($get_bank_account);
		}
	}
	// end of fetching account info 

	// now we are going to add data into database

	 if (isset($_POST['submit'])) {

            $invoice_option     = $_POST['invoice_option'];
            $client_option      = $_POST['client_option'];
            $office_account_no  = $_POST['office_account_no'];
            $office_organization_name = $_POST['office_organization_name'];
            $office_bank_name   = $_POST['office_bank_name'];
            $office_branch_name = $_POST['office_branch_name'];
            $new_client_name    = $_POST['new_client_name'];
            $new_organization_name = $_POST['new_organization_name'];
            $new_address        = $_POST['new_address'];
            $new_phone_no       = $_POST['new_phone_no'];

            $net_total          = $_POST['net_total'];
            $vat                = $_POST['vat'];
            $vat_amount         = $_POST['vat_amount'];
            $discount           = $_POST['discount'];
            $discount_amount    = $_POST['discount_amount'];
            $grand_total        = $_POST['grand_total'];
            $pay                = $_POST['pay'];
            $due                = $_POST['due'];
            $invoice_date 		= date("d-m-Y");



            $service     = $_POST['service'];
            $description = $_POST['description'];
            $unit       = $_POST['unit'];
            $quantity    = $_POST['quantity'];
            $price       = $_POST['price'];
            $total       = $_POST['total'];
//echo $office_organization_name;
			$query = "INSERT INTO  invoice_details
			(invoice_option,	client_option,	office_account_no, office_organization_name,	office_bank_name,	office_branch_name,	new_client_name,	new_organization_name,	new_address,	new_phone_no,	net_total,	vat,	vat_amount,	discount,	discount_amount,	grand_total,	pay,	due, invoice_date)
			VALUES
			('$invoice_option',	'$client_option',	'$office_account_no','$office_organization_name',	'$office_bank_name',	'$office_branch_name',	'$new_client_name',	'$new_organization_name',	'$new_address',	'$new_phone_no',	'$net_total',	'$vat',	'$vat_amount',	'$discount',	'$discount_amount',	'$grand_total',	'$pay',	'$due','$invoice_date')";

			$last_id =$dbOb->custom_insert($query);
			$insert_invoice_expense = '';

			if ($last_id != null) {
				for ($i=0; $i < count($service); $i++) {
					$query = "INSERT INTO  invoice_expense
					(invoice_serial_no,	service,	description,	unit,	quantity,	price,	total)
					VALUES
					('$last_id',	'$service[$i]',	'$description[$i]',	'$unit[$i]',	'$quantity[$i]',	'$price[$i]',	'$total[$i]')	";
					$insert_invoice_expense =$dbOb->insert($query);

					

				}
				if ($insert_invoice_expense) {
						$message = "Congratulaiton! Information Is Successfully Saved.";
						$type = "success";
						echo json_encode(['message'=>$message,'type'=>$type]);
					}else{
						$message = "Sorry! Information Is Not Saved.";
						$type = "warning";
						echo json_encode(['message'=>$message,'type'=>$type]);

					}
			} else{
				echo json_encode("sohag");
			}



	      } // end of  if (isset($_POST['submit']))

	      

?>