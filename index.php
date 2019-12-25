<?php 
include_once('include/header.php'); 
include_once("class/Database.php");

$dbOb = new Database();

$company = 0;
$query = "SELECT * FROM company";
$company = $dbOb->count_row_number($query);
if ($company<1) {
  $company  = 0 ;
}


$products = 0 ;
$query = "SELECT * FROM products";
$products = $dbOb->count_row_number($query);
if ($products<1) {
  $products  = 0 ;
}

$sales_man  = 0 ;
$query = "SELECT * FROM employee_duty";
$sales_man = $dbOb->count_row_number($query);
if ($sales_man<1) {
  $sales_man  = 0 ;
}

$today = date('d-m-Y');
$query = "SELECT * FROM bank_deposite";
$get_bank_deposite = $dbOb->select($query);

$bank_deposite = 0 ;
if ($get_bank_deposite) {
  while ($row = $get_bank_deposite->fetch_assoc()) {

    if ($row['deposite_date'] == $today) {
      $bank_deposite = (int)$bank_deposite + (int)$row['amount'];
    }
  }
}


// claculating  expense 
$today = date('d-m-Y');
$query = "SELECT * FROM expense";
$get_expense = $dbOb->select($query);

$expense = 0 ;
if ($get_expense) {
  while ($row = $get_expense->fetch_assoc()) {

    if ($row['expense_date'] == $today) {
      $expense = (int)$expense + (int)$row['paid_amount'];
    }
  }
}


// counting today sales order 
$sales_order = 0;
// $query = "SELECT * FROM new_order_details WHERE order_date = '$today'";
// $sales_order = $dbOb->count_row_number($query);
// if ($sales_order<1) {
//   $sales_order  = 0 ;
// }

$total_sales_amount = 0 ;
$get_new_order = $dbOb->select($query);
if ($get_new_order) {
 while ($row = $get_new_order->fetch_assoc() ) {
   $total_sales_amount = (int)$total_sales_amount + (int)$row['payable_amt'];
 }
}



// counting today delivery pending 
$delivery_pending  = 0 ;
// $query = "SELECT * FROM new_order_details WHERE order_date = '$today' AND delivery_report = '0'";
// $delivery_pending = $dbOb->count_row_number($query);
// if ($delivery_pending<1) {
//   $delivery_pending  = 0 ;

// }

// counting today delivery complete 
$delivery_complete = 0 ;
$query = "SELECT * FROM order_delivery WHERE delivery_date = '$today'";

$delivery_complete = $dbOb->count_row_number($query);
if ($delivery_complete<1) {
  $delivery_complete  = 0 ;
}



$total_delivery_amount = 0;
$query = "SELECT * FROM delivered_order_payment_history";
$get_order_delivery = $dbOb->select($query);

if ($get_order_delivery) {
  while ($row = $get_order_delivery->fetch_assoc()) {
    if ($row['date'] == $today) {
      $total_delivery_amount = (int)$total_delivery_amount + (int)$row['pay_amt'];
    }
  }
}






// cash balance calculation ------------------------------------------------
  $from_date = strtotime(date("d-m-Y")) ;
  $to_date = $from_date;


  $total_debit = 0;
  $total_credit = 0;
  $cash_balance = 0;

  // calculating delivery 
  $delivery = 0;
  $query = "SELECT * FROM order_delivery";
  $get_order_delivery = $dbOb->select($query);

  if ($get_order_delivery) {
    while ($row = $get_order_delivery->fetch_assoc()) {
      if (strtotime($row['delivery_date']) >= $from_date && strtotime($row['delivery_date']) <= $to_date) {
        $delivery = (int)$delivery + (int)$row['pay'];
      }
    }
  }

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




  // calculating EMPLOYEE Comission 
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

  

?>

<div class="right_col" role="main">
  <div class="row">
    <!-- page content -->

    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Summery</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="dashboard-widget-content">

                <!-- summery section started  -->
                <div class="row top_tiles">
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background: #995c00">
                      <div class="count" style="color: white"><?php echo $company; ?></div>
                      <h4 style="color: white" align="center"><br>Company <br></h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background: #669999">
                      <div class="count" style="color: white"><?php echo $products; ?></div>
                      <h4 style="color: white" align="center"><br>Products <br></h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background:  #b30047">
                      <div class="count" style="color: white"><?php echo $sales_man; ?></div>
                      <h4 style="color: white" align="center">Sales <br> Man</h4>
                    </div>
                  </div>
                  
                </div>


                <div class="row top_tiles">
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" style="color: white">
                    <div class="tile-stats" style="background: #2A3F54">
                      <div class="count" ><?php echo $sales_order ?></div>
                      <h4 align="center" >Today Sales <br> Order</h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" style="color: white">
                    <div class="tile-stats" style="background:#669999">
                      <div class="count"><?php echo $delivery_pending ?></div>
                      <h4 align="center"><br>Today Delivery <br> Pending</h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" style="color: white">
                    <div class="tile-stats" style="background: #b30047">
                      <div class="count"><?php echo $delivery_complete; ?></div>
                      <h4 align="center"><br>Today Delivery <br> Complete</h4>
                    </div>
                  </div>
                  
                </div>


                <div class="row top_tiles">
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" style="color: white">
                    <div class="tile-stats" style="background: #2A3F54">
                      <div class="count"><?php echo $total_sales_amount ?><span > ৳</span></div>
                      <h4 align="center"><br>Sales Amount (Total Order Taken) <br></h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" style="color: white">
                    <div class="tile-stats" style="background: #cccc00">
                      <div class="count"><?php echo $total_delivery_amount ?><span > ৳</span></div>
                      <h4 align="center"><br>Delivery <br> Amount (Paid)</h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background:  #b30047">
                      <div class="count" style="color: white"><?php echo $bank_deposite; ?><span > ৳</span></div>
                      <h4 style="color: white" align="center">Bank <br> Deposite</h4>
                    </div>
                  </div>
                  

                </div>
                <div class="row top_tiles">
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background: #2A3F54">
                      <div class="count" style="color: white"><?php echo $expense ?><span > ৳</span></div>
                      <h4 style="color: white" align="center">Expense <br><br> </h4>
                    </div>
                  </div>

                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" >
                    <div class="tile-stats" style="background: #cccc00">
                      <div class="count" style="color: white"><?php echo $cash_balance; ?></span><span > ৳</span></div>
                      <input type="hidden" name="today" id="today" value="<?php echo(date("d-m-Y")) ?>">
                      <h4 style="color: white" align="center"><br>Cash Balance</h4>
                    </div>
                  </div>

                </div>
              </div><!-- end of summery section  -->
            </div>
          </div>
        </div>
      </div>
    </div> <!--End of summry div-->

    <div class="col-md-4 col-sm-12 col-xs-12 " >
      <div class="x_panel">
        <div class="x_title">
          <h2>Notifications</h2>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
          <div class="dashboard-widget-content">
            
<!-- the following section is for showing product quantity notification -->
            <?php 
            $query = "SELECT * FROM products WHERE quantity <='24' order by quantity";
            $get_product =  $dbOb->select($query);
            if ($get_product) {
             ?>

                  <h4 style="background: #34495E; color: white; padding: 10px;text-align: center;">Product Quantity</h4>
                

              <div class="table-responsive">
                <table class="table table-striped mb-none">
                  <thead style="background: green;color: white">

                    <tr>
                      <th>Product Name</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    while ($row = $get_product->fetch_assoc()) {
                      if ($row['quantity']<='24' and $row['quantity']>'12' ) {
                        $color = "#993300";
                      }else{
                        $color = "#ff471a";
                      }
                      ?>
                      <tr style="color: <?php echo $color ?>">
                        <td><?php echo $row['products_name'] ?></td>
                        <td><?php echo $row['quantity'] ?></td>
                      </tr>
                      
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            <?php
          };
          ?>

<!-- product quantity notification ends here  -->

<!-- marketing employee duty area starts from here  -->

                  <h4 style="background: #34495E; color: white; padding: 10px;text-align: center;">Active Sales Man</h4>
                
           

                  <div class="table-responsive">
                    <table class="table table-striped mb-none">
                      <thead style="background: green;color: white">
                        <tr>
                          <th>Employee Name</th>
                          <th>Area</th>

                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $query = "SELECT * FROM employee_duty WHERE active_status = 'Active'";
                        $get_employee_marketing =  $dbOb->select($query);
                        if ($get_employee_marketing) {
                          while ($row = $get_employee_marketing->fetch_assoc()) {
                            
                              ?>
                              <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['area']; ?></td>

                              </tr>
                              <?php
                            
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  
                
            
<!-- marketing employee duty area ends here -->

<!-- marketing employee duty area starts from here  -->

            
                  <h4 style="background: #34495E; color: white; padding: 10px;text-align: center;">Active Delivery Man</h4>
                
              

                  <div class="table-responsive">
                    <table class="table table-striped mb-none">
                      <thead style="background: green;color: white">
                        <tr>
                          <th>Employee Name</th>
                          <th>Area</th>

                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $query = "SELECT * FROM delivery_employee WHERE active_status = 'Active'";
                        $get_employee_marketing =  $dbOb->select($query);
                        if ($get_employee_marketing) {
                          while ($row = $get_employee_marketing->fetch_assoc()) {
                            
                              ?>
                              <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['area']; ?></td>

                              </tr>
                              <?php
                            
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
              
           

          <!-- notification ends here  -->
        </div>
      </div> <!-- end of main content -->
    </div>
  </div>

  <!-- /page content -->
</div>
</div>

<?php include_once('include/footer.php'); ?>
</body>
</html>

<?php 
if (Session::get('message')) {
 ?>
 
 <script>


   swal({
    title: "Congratulations <?php echo Session::get('name'); ?> !",
    text: "<?php echo Session::get('message'); ?>",
    icon: "success",
    button: "Done!",
  });
</script>
<script>



</script>
<?php
Session::set("message",Null);
}
?>