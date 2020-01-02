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

            $invoice_option     = validation($_POST['invoice_option']);
            $name = validation($_POST['name']);
            $designation   = validation($_POST['designation']);
            $phone_no = validation($_POST['phone_no']);
            $description    = validation($_POST['description']);
            $purpose = validation($_POST['purpose']);
            $amount        = validation($_POST['amount']);
            $total_amount       = validation($_POST['net_total']);
            $pay       = validation($_POST['net_total']);
            $invoice_date       = validation($_POST['invoice_date']);
			$zone_serial_no = validation($_POST['zone_serial_no']);
			$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
			$get_zone = $dbOb->select($query);
			$zone_name = '';
			if ($get_zone) {
				$zone_name = validation($get_zone->fetch_assoc()['zone_name']);
			}

			$query = "INSERT INTO  invoice_details
			(invoice_option,name,designation,phone_no,total_amount,pay, invoice_date,zone_serial_no,zone_name)
			VALUES
			('$invoice_option',	'$name','$designation','$phone_no',	'$total_amount','$pay',	'$invoice_date','$zone_serial_no','$zone_name')";

			$last_id =$dbOb->custom_insert($query);
			$insert_invoice_expense = '';

			if ($last_id != null) {
				for ($i=0; $i < count($purpose); $i++) {
					$descript= validation($description[$i]);
					$purp = validation($purpose[$i]);
					$amt = validation($amount[$i]);
					$query = "INSERT INTO  invoice_expense
					(invoice_serial_no,description,	purpose,amount)
					VALUES
					('$last_id','$descript','$purp','$amt')";
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



	      } // end of  if (isset(validation($_POST['submit'])))

	      

?>