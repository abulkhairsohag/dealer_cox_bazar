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

if (isset($_POST['from_date'])) {
	$from_date = strtotime($_POST['from_date']);
	$to_date = strtotime($_POST['to_date']);
	$zone_serial_no = $_POST['zone_serial_no'];
	// die($zone_serial_no);

	$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
	$get_zone = $dbOb->select($query);
	$ware_house_serial_no = "";
	if ($get_zone) {
		$ware_house_serial_no = $get_zone->fetch_assoc()['ware_house_serial_no'];
	}

	$total_debit = 0;
	$total_credit = 0;
	$cash_balance = 0;


	$from_date_show = validation($_POST['from_date']);
	$to_date_show = validation($_POST['to_date']);

	// die($from_date_show);


	if ($from_date_show == $to_date_show) {
		$show_date = 'Date :'.$from_date_show ;
	}else{
		$show_date = 'Date : '.$from_date_show.' <span class="badge bg-red"> TO </span> '.$to_date_show;
	}

	$printing_date = date('d F, Y');
	$printing_time = date('h:i:s A');

	$print_table = 'print_table';


 $company_profile = '';
 $query = "SELECT * FROM profile";
 $get_profile = $dbOb->select($query);
 if ($get_profile) {
   $company_profile = $get_profile->fetch_assoc();
 }
 $organization_name = validation($company_profile['organization_name']);
 $organization_address = validation($company_profile['address']);
 $organization_email = validation($company_profile['email']);
 $organization_mobile_no = validation($company_profile['mobile_no']);

	// calculating delivery 
	$delivery = 0;
	$query = "SELECT * FROM delivered_order_payment_history WHERE zone_serial_no = '$zone_serial_no'";
	$get_order_delivery = $dbOb->select($query);

	if ($get_order_delivery) {
		while ($row = $get_order_delivery->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$delivery = $delivery*1 + $row['pay_amt']*1;
			}
		}
	}


	// calculating cell Invoice  
	$cell_invoice = 0;

	$query = "SELECT * FROM invoice_details WHERE invoice_option = 'Sell Invoice' AND zone_serial_no = '$zone_serial_no'";
 		$get_sell_invoice = $dbOb->select($query);
 		if ($get_sell_invoice) {
 			while ($row = $get_sell_invoice->fetch_assoc()) {
 				if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {
					$cell_invoice += 1* $row['pay'];
 				}
 			}

 		}
// die($zone_serial_no.'sohag');

	// calculating Bank Withdraw 
	$bank_withdraw = 0;
	$query = "SELECT * FROM bank_withdraw WHERE zone_serial_no = '$zone_serial_no'";
	$get_bank_withdraw = $dbOb->select($query);

	if ($get_bank_withdraw) {
		while ($row = $get_bank_withdraw->fetch_assoc()) {
			if (strtotime($row['cheque_active_date']) >= $from_date && strtotime($row['cheque_active_date']) <= $to_date) {
				$bank_withdraw = 1*$bank_withdraw + 1*$row['amount'];
			}
		}
	}




	// calculating Bank Loan 
	$bank_loan = 0;
	$query = "SELECT * FROM bank_loan WHERE zone_serial_no = '$zone_serial_no'";
	$get_bank_loan = $dbOb->select($query);

	if ($get_bank_loan) {
		while ($row = $get_bank_loan->fetch_assoc()) {
			if (strtotime($row['loan_taken_date']) >= $from_date && strtotime($row['loan_taken_date']) <= $to_date) {
				$bank_loan = 1*$bank_loan + 1*$row['total_amount'];
			}
		}
	}


	// calculating company Comission 
	$company_commission = 0;
	$query = "SELECT * FROM company_commission WHERE zone_serial_no = '$zone_serial_no'";
	$get_company_comission = $dbOb->select($query);

	if ($get_company_comission) {
		while ($row = $get_company_comission->fetch_assoc()) {
			
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {

				if ($row['target_product'] <= $row['target_sell_amount']) {
					$target = $row['target_product'];
					$target_sell_amount = $row['target_sell_amount'];

						$extra_sell = $target_sell_amount - $target ;
						$comission_persent = $row['comission_persent'];
						$comission_amount = $extra_sell * $comission_persent / 100 ;
						$company_commission = 1*$company_commission + 1*$comission_amount;


				}

			}
		}
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// calculating company Products Return
	$company_products_return = 0;
	$query = "SELECT * FROM company_products_return WHERE ware_house_serial_no = '$ware_house_serial_no'";
	$get_company_products_return = $dbOb->select($query);

	if ($get_company_products_return) {
		while ($row = $get_company_products_return->fetch_assoc()) {
			if (strtotime($row['return_date']) >= $from_date && strtotime($row['return_date']) <= $to_date) {
				$company_products_return = 1*$company_products_return + 1*$row['total_price'];
			}
		}
	}

   $total_credit = 1*$delivery + 1*$cell_invoice +1*$bank_withdraw +1*$bank_loan +1*$company_commission +1*$company_products_return;






   // now calculating Salary Payment
	$salary_payment = 0;
	$query = "SELECT * FROM employee_payments WHERE zone_serial_no = '$zone_serial_no'";
	$get_salary_payment = $dbOb->select($query);

	if ($get_salary_payment) {
		while ($row = $get_salary_payment->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$salary_payment = 1*$salary_payment + 1*$row['salary_paid'];
			}
		}
	}



   // now calculating bank Deposite	
	$bank_deposite = 0;
	$query = "SELECT * FROM bank_deposite WHERE zone_serial_no = '$zone_serial_no'";
	$get_bank_deposite = $dbOb->select($query);

	if ($get_bank_deposite) {
		while ($row = $get_bank_deposite->fetch_assoc()) {
			if (strtotime($row['deposite_date']) >= $from_date && strtotime($row['deposite_date']) <= $to_date) {
				$bank_deposite = 1*$bank_deposite + 1*$row['amount'];
			}
		}
	}





   // now calculating Loan Pay
	$loan_pay = 0;
	$query = "SELECT * FROM bank_loan_pay WHERE zone_serial_no = '$zone_serial_no'";
	$get_loan_pay = $dbOb->select($query);

	if ($get_loan_pay) {
		while ($row = $get_loan_pay->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$loan_pay = 1*$loan_pay + 1*$row['pay_amt'];
			}
		}
	}


	// calculating BUY Invoice  
	$buy_invoice = 0;
	$query = "SELECT * FROM invoice_details WHERE invoice_option = 'Buy Invoice' AND zone_serial_no = '$zone_serial_no'";
	$get_buy_invoice = $dbOb->select($query);

	if ($get_buy_invoice) {
		while ($row = $get_buy_invoice->fetch_assoc()) {
			if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {
				$buy_invoice = 1*$buy_invoice + 1*$row['pay'];
			}
		}
	}




	// calculating product buy 
	$products_buy = 0;
	$query = "SELECT * FROM product_stock WHERE quantity > 0 AND ware_house_serial_no = '$ware_house_serial_no'";
	$get_products_buy = $dbOb->select($query);

	if ($get_products_buy) {
		while ($row = $get_products_buy->fetch_assoc()) {
			if (strtotime($row['stock_date']) >= $from_date && strtotime($row['stock_date']) <= $to_date) {
				$quantity = $row['quantity'];
				$company_price = $row['company_price'];
				$price = $quantity * $company_price;
				$products_buy = 1*$products_buy + 1*$price;

			}
		}
	}




	// calculating Market Return Product 
	$market_return = 0;
	$query = "SELECT * FROM market_products_return WHERE zone_serial_no = '$zone_serial_no'";
	$get_market_return = $dbOb->select($query);

	if ($get_market_return) {
		while ($row = $get_market_return->fetch_assoc()) {
			if (strtotime($row['return_date']) >= $from_date && strtotime($row['return_date']) <= $to_date) {
				$market_return = 1*$market_return + 1*$row['total_price'];
			}
		}
	}



	// calculating EMPLOYEE Comission 
	$employee_commission = 0;
	$query = "SELECT * FROM employee_commission WHERE zone_serial_no = '$zone_serial_no'";
	$get_employee_commission = $dbOb->select($query);

	if ($get_employee_commission) {
		while ($row = $get_employee_commission->fetch_assoc()) {
			
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {

				if ($row['sell_target'] <= $row['total_sell_amount']) {
					$target = $row['total_sell_amount'];
					$comission_persent = $row['comission_persent'];
					$extra_sell = $row['total_sell_amount'] -  $row['sell_target'] ;

					$comission = 1*$extra_sell * 1*$comission_persent / 100 ;

					$employee_commission = 1*$employee_commission + 1*$comission;
				}

			}
		}
	}


    $total_debit =  1*$salary_payment + 1*$bank_deposite + 1*$loan_pay + 1*$buy_invoice + 1*$products_buy+ 1*$market_return + 1*$employee_commission;

    $cash_balance = 1*$total_credit - 1*$total_debit;

	echo json_encode(['delivery'=>number_format($delivery,2),'own_shop_sell'=>number_format($own_shop_sell,2),'cell_invoice'=>number_format($cell_invoice,2),'bank_withdraw'=>number_format($bank_withdraw,2),'bank_loan'=>number_format($bank_loan,2),'company_commission'=>number_format($company_commission,2),'company_products_return'=>number_format($company_products_return,2),'total_debit'=>number_format($total_debit,2),'salary_payment'=>number_format($salary_payment,2),'bank_deposite'=>number_format($bank_deposite,2),'loan_pay'=>number_format($loan_pay,2),'buy_invoice'=>number_format($buy_invoice,2),'products_buy'=>number_format($products_buy,2),'market_return'=>number_format($market_return,2),'employee_commission'=>number_format($employee_commission,2),'total_credit'=>number_format($total_credit,2),'cash_balance'=>number_format($cash_balance,2),'show_date'=>$show_date,'printing_date'=>$printing_date,'printing_time'=>$printing_time,'print_table'=>$print_table,'organization_name'=>$organization_name,'organization_address'=>$organization_address,'organization_email'=>$organization_email,'organization_mobile_no'=>$organization_mobile_no]);
} // end of if isset......

?>
