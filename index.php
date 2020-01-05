<?php 
include_once('include/header.php'); 
include_once("class/Database.php");

$dbOb = new Database();

    $ware_house_serial_no = "";
    $zone_serial_no = "";
    if (Session::get("ware_house_serial_login")){
      if (Session::get("ware_house_serial_login") != '-1') {
         $ware_house_serial_no = Session::get("ware_house_serial_login");
         $zone_serial_no = Session::get("zone_serial_no");
      }
      $admin = false;
    } else{
        $admin = true;
    }

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

$delivery_man  = 0 ;
$query = "SELECT * FROM delivery_employee";
$delivery_man = $dbOb->count_row_number($query);
if ($delivery_man<1) {
  $delivery_man  = 0 ;
}

$today = date('d-m-Y');



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



  if ($zone_serial_no) {
    $query = "SELECT * FROM order_delivery WHERE delivery_date = '$today' AND zone_serial_no = '$zone_serial_no'";
  }else{
    $query = "SELECT * FROM order_delivery WHERE delivery_date = '$today'";
  }

$total_sales_amount = 0 ;
$get_new_order = $dbOb->select($query);
if ($get_new_order) {
 while ($row = $get_new_order->fetch_assoc() ) {
   $total_sales_amount = (int)$total_sales_amount + (int)$row['payable_amt'];
 }
}
//  calculating due
$today_due = 0;
  if ($zone_serial_no) {
    $query = "SELECT * FROM order_delivery WHERE due > 0 AND delivery_date = '$today' AND zone_serial_no = '$zone_serial_no'";
  }else{
    $query = "SELECT * FROM order_delivery WHERE delivery_date = '$today'";
  }

$get_new_order = $dbOb->select($query);
if ($get_new_order) {
 while ($row = $get_new_order->fetch_assoc() ) {
   $today_due = (int)$today_due + (int)$row['due'];
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

if ($zone_serial_no) {
  $query = "SELECT * FROM order_delivery WHERE delivery_date = '$today' AND zone_serial_no = '$zone_serial_no'";
}else{
  $query = "SELECT * FROM order_delivery WHERE delivery_date = '$today'";
}

$delivery_complete = $dbOb->count_row_number($query);
if ($delivery_complete<1) {
  $delivery_complete  = 0 ;
}



// $total_delivery_amount = 0;
// $query = "SELECT * FROM delivered_order_payment_history";
// $get_order_delivery = $dbOb->select($query);

// if ($get_order_delivery) {
//   while ($row = $get_order_delivery->fetch_assoc()) {
//     if ($row['date'] == $today) {
//       $total_delivery_amount = (int)$total_delivery_amount + (int)$row['pay_amt'];
//     }
//   }
// }






// cash balance calculation ------------------------------------------------
  $from_date = strtotime(date("d-m-Y")) ;
  $to_date = $from_date;


  $total_debit = 0;
  $total_credit = 0;
  $cash_balance = 0;

  // calculating delivery 
    $cell_invoice = 0;
      $delivery = 0;
      
      if ($zone_serial_no) {

        $query = "SELECT * FROM delivered_order_payment_history WHERE zone_serial_no = '$zone_serial_no'";
      }else{
        $query = "SELECT * FROM delivered_order_payment_history ";

        }
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
  
  if ($zone_serial_no) {
    $query = "SELECT * FROM invoice_details WHERE invoice_option = 'Sell Invoice' AND zone_serial_no = '$zone_serial_no'";
  }else{
    $query = "SELECT * FROM invoice_details WHERE invoice_option = 'Sell Invoice'";
  }
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
   if ($zone_serial_no) {
     $query = "SELECT * FROM bank_withdraw WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM bank_withdraw";
  }
  $bank_withdraw = 0;
  $get_bank_withdraw = $dbOb->select($query);

  if ($get_bank_withdraw) {
    while ($row = $get_bank_withdraw->fetch_assoc()) {
      if (strtotime($row['cheque_active_date']) >= $from_date && strtotime($row['cheque_active_date']) <= $to_date) {
        $bank_withdraw = 1*$bank_withdraw + 1*$row['amount'];
      }
    }
  }




  // calculating Bank Loan 
   if ($zone_serial_no) {
     $query = "SELECT * FROM bank_loan WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM bank_loan";
  }
  $bank_loan = 0;
  $get_bank_loan = $dbOb->select($query);

  if ($get_bank_loan) {
    while ($row = $get_bank_loan->fetch_assoc()) {
      if (strtotime($row['loan_taken_date']) >= $from_date && strtotime($row['loan_taken_date']) <= $to_date) {
        $bank_loan = 1*$bank_loan + 1*$row['total_amount'];
      }
    }
  }


  // calculating company Comission 
   if ($zone_serial_no) {

     $query = "SELECT * FROM company_commission WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM company_commission";
    
  }
  $company_commission = 0;
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
   if ($zone_serial_no) {

     $query = "SELECT * FROM company_products_return WHERE ware_house_serial_no = '$ware_house_serial_no'";
    }else{
      $query = "SELECT * FROM company_products_return";
    
  }
  $company_products_return = 0;
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
    if ($zone_serial_no) {

      $query = "SELECT * FROM employee_payments WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM employee_payments";
    
  }
  $salary_payment = 0;
  $get_salary_payment = $dbOb->select($query);

  if ($get_salary_payment) {
    while ($row = $get_salary_payment->fetch_assoc()) {
      if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
        $salary_payment = 1*$salary_payment + 1*$row['salary_paid'];
      }
    }
  }



   // now calculating bank Deposite 
    if ($zone_serial_no) {

      $query = "SELECT * FROM bank_deposite WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM bank_deposite";
    
  }
  $bank_deposite = 0;
  $get_bank_deposite = $dbOb->select($query);

  if ($get_bank_deposite) {
    while ($row = $get_bank_deposite->fetch_assoc()) {
      if (strtotime($row['deposite_date']) >= $from_date && strtotime($row['deposite_date']) <= $to_date) {
        $bank_deposite = 1*$bank_deposite + 1*$row['amount'];
      }
    }
  }





   // now calculating Loan Pay
    if ($zone_serial_no) {
      $query = "SELECT * FROM bank_loan_pay WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM bank_loan_pay";
  }
  $loan_pay = 0;
  $get_loan_pay = $dbOb->select($query);

  if ($get_loan_pay) {
    while ($row = $get_loan_pay->fetch_assoc()) {
      if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
        $loan_pay = 1*$loan_pay + 1*$row['pay_amt'];
      }
    }
  }


  // calculating BUY Invoice  
   if ($zone_serial_no) {

     $query = "SELECT * FROM invoice_details WHERE invoice_option = 'Buy Invoice' AND zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM invoice_details WHERE invoice_option = 'Buy Invoice'";
    
  }
  $buy_invoice = 0;
  $get_buy_invoice = $dbOb->select($query);

  if ($get_buy_invoice) {
    while ($row = $get_buy_invoice->fetch_assoc()) {
      if (strtotime($row['invoice_date']) >= $from_date && strtotime($row['invoice_date']) <= $to_date) {
        $buy_invoice = 1*$buy_invoice + 1*$row['pay'];
      }
    }
  }




  // calculating product buy 
   if ($zone_serial_no) {

     $query = "SELECT * FROM product_stock WHERE quantity > 0 AND ware_house_serial_no = '$ware_house_serial_no'";
    }else{
      $query = "SELECT * FROM product_stock WHERE quantity > 0";
    
  }
  $products_buy = 0;
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
   if ($zone_serial_no) {

     $query = "SELECT * FROM market_products_return WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM market_products_return ";
    
  }
  $market_return = 0;
  $get_market_return = $dbOb->select($query);

  if ($get_market_return) {
    while ($row = $get_market_return->fetch_assoc()) {
      if (strtotime($row['return_date']) >= $from_date && strtotime($row['return_date']) <= $to_date) {
        $market_return = 1*$market_return + 1*$row['total_price'];
      }
    }
  }



  // calculating EMPLOYEE Comission 
   if ($zone_serial_no) {

     $query = "SELECT * FROM employee_commission WHERE zone_serial_no = '$zone_serial_no'";
    }else{
      $query = "SELECT * FROM employee_commission";
    
  }
  $employee_commission = 0;
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

  

?>

<div class="right_col" role="main">
  <div class="row">
    <!-- page content -->

    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Summary</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="dashboard-widget-content">

                <!-- summery section started  -->
                <?php if($admin):?>
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
    <?php endif;?>

                <div class="row top_tiles">
                    <?php if($admin) :?>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12" style="color: white">
                    <div class="tile-stats" style="background: #2A3F54">
                      <div class="count" ><?php echo $delivery_man ?></div>
                      <h4 align="center" >Delivery <br> Man</h4>
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="animated flipInY <?php echo ($admin? 'col-lg-4 col-md-4 col-sm-3' : 'col-lg-6 col-md-6 col-sm-6') ?> col-xs-12" style="color: white">
                    <div class="tile-stats" style="background:#669999">
                      <div class="count"><?php echo $delivery_pending ?></div>
                      <h4 align="center"><br>Today Delivery <br> Pending</h4>
                    </div>
                  </div>
                  <div class="animated flipInY <?php echo ($admin? 'col-lg-4 col-md-4 col-sm-3' : 'col-lg-6 col-md-6 col-sm-6') ?> col-xs-12" style="color: white">
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
                      <div class="count"><?php echo $delivery ?><span > ৳</span></div>
                      <h4 align="center"><br>Delivery <br> Amount (Paid)</h4>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background:  #b30047">
                      <div class="count" style="color: white"><?php echo $today_due; ?><span > ৳</span></div>
                      <h4 style="color: white" align="center">Today Total <br> Due</h4>
                    </div>
                  </div>
                  

                </div>
                <div class="row top_tiles">
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background: #2A3F54">
                      <div class="count" style="color: white"><?php echo $total_debit ?><span > ৳</span></div>
                      <h4 style="color: white" align="center">Cash Out <br><br> </h4>
                    </div>
                  </div>
                     <div class="animated flipInY col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="tile-stats" style="background:  #b30047">
                      <div class="count" style="color: white"><?php echo $total_credit; ?><span > ৳</span></div>
                      <h4 style="color: white" align="center">Cash In</h4>
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

<!-- the following section is for showing product quantity notification -->
            <?php 
            if (Session::get("ware_house_serial_login")){
              if (Session::get("ware_house_serial_login") != '-1') {
                $ware_house_serial_no  = Session::get("ware_house_serial_login");
                $query = "SELECT DISTINCT products_id_no FROM product_stock WHERE ware_house_serial_no = '$ware_house_serial_no'";
                $get_product = $dbOb->select($query);
                if ($get_product) {
             ?>

                  <h4 style="background: #34495E; color: white; padding: 10px;text-align: center;">Product Quantity</h4>
                

              <div class="table-responsive">
                <table class="table table-striped mb-none">
                  <thead style="background: green;color: white">

                    <tr>
                      <th>Product Name</th>
                      <th>Quantity(Packet)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    while ($row = $get_product->fetch_assoc()) {
                      $prod_id = $row['products_id_no'];
                      $query = "SELECT * FROM products WHERE products_id_no = '$prod_id'";
                      $product_inform = $dbOb->select($query);
                      $prod_name = "";
                      if ($product_inform) {
                        $prod_name = $product_inform->fetch_assoc()['products_name'];
                      }
                      $quantity = get_ware_house_stock($ware_house_serial_no, $prod_id);
                      if ($quantity<=150 and $quantity>99 ) {
                        $color = "green";
                      }else{
                        $color = "red";
                      }
                      ?>
                      <tr style="color: <?php echo $color ?>">
                        <td><?php echo  $prod_name  ?></td>
                        <td><?php echo $quantity; ?></td>
                      </tr>
                      
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            <?php
          };
              }
            }
            $query = "SELECT * FROM products WHERE quantity <='24' order by quantity";
            $get_product =  $dbOb->select($query);
            
          ?>
<!-- product quantity notification ends here  -->

<!-- marketing employee duty area starts from here  -->

                  <h4 style="background: #34495E; color: white; padding: 10px;text-align: center;">Active Sales Man</h4>
                
           

                  <div class="table-responsive">
                    <table class="table table-striped mb-none">
                      <thead style="background: green;color: white">
                        <tr>
                          <th>Employee Name</th>
                          <!--<th>Area</th>-->

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
                                <!--<td><?php echo $row['area']; ?></td>-->

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
                          <!--<th>Area</th>-->

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
                                <!--<td><?php echo $row['area']; ?></td>-->

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