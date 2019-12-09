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


	// end of fetching account info 

	// now we are going to add data into database

	 if (isset($_POST['submit'])) {

            $invoice_option     = $_POST['invoice_option'];
            $name = $_POST['name'];
            $designation   = $_POST['designation'];
            $phone_no = $_POST['phone_no'];
            $description    = $_POST['description'];
            $purpose = $_POST['purpose'];
            $amount        = $_POST['amount'];
            $total_amount       = $_POST['net_total'];
            $pay       = $_POST['net_total'];
            $invoice_date       = $_POST['invoice_date'];
//echo $office_organization_name;
			$query = "INSERT INTO  invoice_details
			(invoice_option,name,designation,phone_no,total_amount,pay, invoice_date)
			VALUES
			('$invoice_option',	'$name','$designation','$phone_no',	'$total_amount','$pay',	'$invoice_date')";

			$last_id =$dbOb->custom_insert($query);
			$insert_invoice_expense = '';

			if ($last_id != null) {
				for ($i=0; $i < count($purpose); $i++) {
					$query = "INSERT INTO  invoice_expense
					(invoice_serial_no,description,	purpose,amount)
					VALUES
					('$last_id','$description[$i]',	'$purpose[$i]','$amount[$i]')";
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