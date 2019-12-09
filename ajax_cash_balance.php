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
	$total_debit = 0;
	$total_credit = 0;
	$cash_balance = 0;


	$from_date_show = $_POST['from_date'];
	$to_date_show = $_POST['to_date'];

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
 $organization_name = $company_profile['organization_name'];
 $organization_address = $company_profile['address'];
 $organization_email = $company_profile['email'];
 $organization_mobile_no = $company_profile['mobile_no'];

	// calculating delivery 
	$delivery = 0;
	$query = "SELECT * FROM delivered_order_payment_history";
	$get_order_delivery = $dbOb->select($query);

	if ($get_order_delivery) {
		while ($row = $get_order_delivery->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$delivery = $delivery*1 + $row['pay_amt']*1;
			}
		}
	}

	// die($delivery.'sdf');

	// calculating Own Shop Sell
	$own_shop_sell = 0;
	$query = "SELECT * FROM own_shop_sell";
	$get_own_shop_sell = $dbOb->select($query);

	if ($get_own_shop_sell) {
		while ($row = $get_own_shop_sell->fetch_assoc()) {
			if (strtotime($row['sell_date']) >= $from_date && strtotime($row['sell_date']) <= $to_date) {
				$own_shop_sell = (int)$own_shop_sell + (int)$row['pay'];
			}
		}
	}


	// calculating Receive 
	$receive = 0;
	$query = "SELECT * FROM receive";
	$get_receive = $dbOb->select($query);

	if ($get_receive) {
		while ($row = $get_receive->fetch_assoc()) {
			if (strtotime($row['receive_date']) >= $from_date && strtotime($row['receive_date']) <= $to_date) {
				$receive = (int)$receive + (int)$row['paid_amount'];
			}
		}
	}


	// calculating cell Invoice  
	$cell_invoice = 0;

	$query = "SELECT * FROM invoice_details WHERE invoice_option = 'Sell Invoice'";
 		$get_sell_invoice = $dbOb->select($query);
 		if ($get_sell_invoice) {
 			while ($row = $get_sell_invoice->fetch_assoc()) {
 				if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {
					$cell_invoice += (int) $row['pay'];
 				}
 			}

 		}



	// calculating Bank Withdraw 
	$bank_withdraw = 0;
	$query = "SELECT * FROM bank_withdraw";
	$get_bank_withdraw = $dbOb->select($query);

	if ($get_bank_withdraw) {
		while ($row = $get_bank_withdraw->fetch_assoc()) {
			if (strtotime($row['cheque_active_date']) >= $from_date && strtotime($row['cheque_active_date']) <= $to_date) {
				$bank_withdraw = (int)$bank_withdraw + (int)$row['amount'];
			}
		}
	}




	// calculating Bank Loan 
	$bank_loan = 0;
	$query = "SELECT * FROM bank_loan";
	$get_bank_loan = $dbOb->select($query);

	if ($get_bank_loan) {
		while ($row = $get_bank_loan->fetch_assoc()) {
			if (strtotime($row['loan_taken_date']) >= $from_date && strtotime($row['loan_taken_date']) <= $to_date) {
				$bank_loan = (int)$bank_loan + (int)$row['total_amount'];
			}
		}
	}


	// calculating company Comission 
	$company_commission = 0;
	$query = "SELECT * FROM company_commission";
	$get_company_comission = $dbOb->select($query);

	if ($get_company_comission) {
		while ($row = $get_company_comission->fetch_assoc()) {
			
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {

				if ($row['target_product'] <= $row['target_sell_amount']) {
					$target = $row['target_sell_amount'];
					$comission_persent = $row['comission_persent'];

					$comission_amount = (int)$target * (int)$comission_persent / 100 ;

					$comission = (int)$target + (int)$comission_amount;
					$company_commission = (int)$company_commission + (int)$comission;
				}

			}
		}
	}


	// calculating company Products Return
	$company_products_return = 0;
	$query = "SELECT * FROM company_products_return";
	$get_company_products_return = $dbOb->select($query);

	if ($get_company_products_return) {
		while ($row = $get_company_products_return->fetch_assoc()) {
			if (strtotime($row['return_date']) >= $from_date && strtotime($row['return_date']) <= $to_date) {
				$company_products_return = (int)$company_products_return + (int)$row['total_price'];
			}
		}
	}

   $total_credit = (int)$delivery + (int)$own_shop_sell +(int)$receive +(int)$cell_invoice +(int)$bank_withdraw +(int)$bank_loan +(int)$company_commission +(int)$company_products_return;


   // now calculating expense amount
	$expense = 0;
	$query = "SELECT * FROM expense";
	$get_expense = $dbOb->select($query);

	if ($get_expense) {
		while ($row = $get_expense->fetch_assoc()) {
			if (strtotime($row['expense_date']) >= $from_date && strtotime($row['expense_date']) <= $to_date) {
				$expense = (int)$expense + (int)$row['paid_amount'];
			}
		}
	}



   // now calculating Salary Payment
	$salary_payment = 0;
	$query = "SELECT * FROM employee_payments";
	$get_salary_payment = $dbOb->select($query);

	if ($get_salary_payment) {
		while ($row = $get_salary_payment->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$salary_payment = (int)$salary_payment + (int)$row['salary_paid'];
			}
		}
	}



   // now calculating bank Deposite	
	$bank_deposite = 0;
	$query = "SELECT * FROM bank_deposite";
	$get_bank_deposite = $dbOb->select($query);

	if ($get_bank_deposite) {
		while ($row = $get_bank_deposite->fetch_assoc()) {
			if (strtotime($row['deposite_date']) >= $from_date && strtotime($row['deposite_date']) <= $to_date) {
				$bank_deposite = (int)$bank_deposite + (int)$row['amount'];
			}
		}
	}





   // now calculating Loan Pay
	$loan_pay = 0;
	$query = "SELECT * FROM bank_loan_pay";
	$get_loan_pay = $dbOb->select($query);

	if ($get_loan_pay) {
		while ($row = $get_loan_pay->fetch_assoc()) {
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
				$loan_pay = (int)$loan_pay + (int)$row['pay_amt'];
			}
		}
	}


	// calculating BUY Invoice  
	$buy_invoice = 0;
	$query = "SELECT * FROM invoice_details WHERE invoice_option = 'Buy Invoice'";
	$get_buy_invoice = $dbOb->select($query);

	if ($get_buy_invoice) {
		while ($row = $get_buy_invoice->fetch_assoc()) {
			if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {
				$buy_invoice = (int)$buy_invoice + (int)$row['pay'];
			}
		}
	}




	// calculating product buy 
	$products_buy = 0;
	$query = "SELECT * FROM product_stock";
	$get_products_buy = $dbOb->select($query);

	if ($get_products_buy) {
		while ($row = $get_products_buy->fetch_assoc()) {
			if (strtotime($row['stock_date']) >= $from_date && strtotime($row['stock_date']) <= $to_date) {
				$quantity = $row['quantity'];
				if ($quantity >0) {
					$products_id_no = $row['products_id_no'];
					$query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
					$get_products = $dbOb->find($query);
					$price_per_product = $get_products['company_price'];

					$price = $quantity * $price_per_product;

					$products_buy = (int)$products_buy + (int)$price;
				}

			}
		}
	}




	// calculating Market Return Product 
	$market_return = 0;
	$query = "SELECT * FROM market_products_return";
	$get_market_return = $dbOb->select($query);

	if ($get_market_return) {
		while ($row = $get_market_return->fetch_assoc()) {
			if (strtotime($row['return_date']) >= $from_date && strtotime($row['return_date']) <= $to_date) {
				$market_return = (int)$market_return + (int)$row['total_price'];
			}
		}
	}



	// calculating company Comission 
	$employee_commission = 0;
	$query = "SELECT * FROM employee_commission";
	$get_employee_commission = $dbOb->select($query);

	if ($get_employee_commission) {
		while ($row = $get_employee_commission->fetch_assoc()) {
			
			if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {

				if ($row['sell_target'] <= $row['total_sell_amount']) {
					$target = $row['total_sell_amount'];
					$comission_persent = $row['comission_persent'];
					$extra_sell = $row['total_sell_amount'] -  $row['sell_target'] ;

					$comission = (int)$extra_sell * (int)$comission_persent / 100 ;

					$employee_commission = (int)$employee_commission + (int)$comission;
				}

			}
		}
	}


    $total_debit = (int)$expense + (int)$salary_payment + (int)$bank_deposite + (int)$loan_pay + (int)$buy_invoice + (int)$products_buy+ (int)$market_return + (int)$employee_commission;

    $cash_balance = (int)$total_credit - (int)$total_debit;

	echo json_encode(['delivery'=>number_format($delivery,2),'own_shop_sell'=>number_format($own_shop_sell,2),'receive'=>number_format($receive,2),'cell_invoice'=>number_format($cell_invoice,2),'bank_withdraw'=>number_format($bank_withdraw,2),'bank_loan'=>number_format($bank_loan,2),'company_commission'=>number_format($company_commission,2),'company_products_return'=>number_format($company_products_return,2),'total_debit'=>number_format($total_debit,2),'expense'=>number_format($expense,2),'salary_payment'=>number_format($salary_payment,2),'bank_deposite'=>number_format($bank_deposite,2),'loan_pay'=>number_format($loan_pay,2),'buy_invoice'=>number_format($buy_invoice,2),'products_buy'=>number_format($products_buy,2),'market_return'=>number_format($market_return,2),'employee_commission'=>number_format($employee_commission,2),'total_credit'=>number_format($total_credit,2),'cash_balance'=>number_format($cash_balance,2),'show_date'=>$show_date,'printing_date'=>$printing_date,'printing_time'=>$printing_time,'print_table'=>$print_table,'organization_name'=>$organization_name,'organization_address'=>$organization_address,'organization_email'=>$organization_email,'organization_mobile_no'=>$organization_mobile_no]);
} // end of if isset......

?>
