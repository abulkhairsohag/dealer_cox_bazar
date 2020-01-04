<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('cash_balance')){
  ?>
<script>
  window.location.href = '403.php';
</script>
<?php 
}
 ?>
<style>
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #000;
   
}

</style>
<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->

    <div>
      <div class="panel-heading" style="background: #34495E;color: white; padding-bottom: 10px" align="center">
        <h2 class="panel-title" style="color: white">
          <h3>To See Cash Balance Select The Date Below.</h3>
        </h2>
      </div>
      <div class="panel-body">
        


        <div class="form-group col-md-12">
          <div class="col-md-1"></div>
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Zone<span
              class="required" style="color: red">*</span></label>
          <div class="col-md-4 col-sm-6 col-xs-12">
              <select name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no ">
           
              <?php

              if (Session::get("zone_serial_no")){
                if (Session::get("zone_serial_no") != '-1') {
                
                ?>
                  <option value='<?php echo Session::get("zone_serial_no"); ?>'><?php echo Session::get("zone_name"); ?></option>
                <?php
                }else{
                  ?>
                    <option value=''><?php echo Session::get("zone_name"); ?></option>
                  <?php
                }
              }else{
        $query = "SELECT * FROM zone ORDER BY zone_name";
        $get_zone = $dbOb->select($query);
        if ($get_zone) {
          ?>
           <option value="">Please Select One</option>
           <option value="-1">All Zone</option>
          <?php
                while ($row = $get_zone->fetch_assoc()) {

                ?>
                <option value="<?php echo $row['serial_no']; ?>"  ><?php echo $row['zone_name']; ?></option>
                <?php
              }
            }else{
              ?>
                <option value="">Please Add Zone First..</option>
              <?php

            }
             }

            ?>

            </select>
            
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-1"></div>
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span
              class="required" style="color: red">*</span></label>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <?php $today = date("d-m-Y");  ?>
            <input type="text" class="form-control datepicker " id='from_date' name="from_date"
              value="<?php echo $today  ?>" required="" readonly="">
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-1"></div>
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span
              class="required" style="color: red">*</span></label>
          <div class="col-md-4 col-sm-6 col-xs-12">

            <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>"
              required="" readonly="">
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;" align="center">

          <div class="col-md-12 col-sm-6 col-xs-8">
            <?php 
            if (permission_check('cash_balance')) {
          ?>
            <button class="btn btn-primary" id="view_record">View Record</button>
            <?php } ?>
          </div>
        </div>


        <?php 
$print_table = 'print_table';
$printing_date = date('d F, Y');
$printing_time = date('h:i:s A');

 $company_profile = '';
 $query = "SELECT * FROM profile";
 $get_profile = $dbOb->select($query);
 if ($get_profile) {
   $company_profile = $get_profile->fetch_assoc();
 }
?>



      </div>
    </div>
    <div class="well" style="background: white;margin-top: 20px">
      <div class="row" id="print_table" >

        <div style="color:black" class="col-md-12">
          <span class="text-center">
            <h3><b><?php echo strtoupper($company_profile['organization_name']); ?></b></h3>
            <h5><?php    echo $company_profile['address']; ?></h5>
            <h5><?php    echo $company_profile['email'].', '.$company_profile['mobile_no']; ?></h5>
            <h5 id="show_date"></h5>

          </span>
          <div class="text-center">
            <h4
              style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;">
              <b>BALANCE SHEET</b></h4>
          </div>
          <br>
          <table class="table table-responsive">
            <tbody>
              <tr>
                <td class="text-left">
                    <h5 style="margin:0px ; margin-top: -8px;">Zone : <span id="zone_name_show"></span></span>
                  </h5>
                </td>
                <td class="text-center">

                </td>
                <td class="text-right">
                  <h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span id="printing_date"></span></span>
                  </h5>
                  <h5 style="margin:0px ; margin-top: -8px;">Time : <span id="printing_time"></span></span></span></h5>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- end of company heading -->

        <div class="col-md-12 text-dark" style="color:black">
          <table class="table table-responsive table-bordered ">
              <tbody>
                <tr class="text-center bg-green">
                  <td colspan="2">
                  <h4><b>CASH IN</b></h4>
                  </td>
                  <td  colspan="2">
                  <h4><b>CASH OUT </b></h4>
                  </td>
                </tr>

                <tr class="bg-success">
                  <td> <h5><b>DESCRIPTION</b></h5>  </td>
                  <td> <h5><b>AMOUNT (৳)</b></h5>  </td>
                  <td> <h5><b>DESCRIPTION</b></h5>  </td>
                  <td> <h5><b>AMOUNT (৳)</b></h5>  </td>
                </tr>

                <tr>
                  <td>Delivery  </td>
                  <td id="delivery" class="text-right"> 0.0  </td>
                   <td>Product Buy  </td>
                  <td id="products_buy" class="text-right"> 0.0  </td>
                </tr>

                <tr>
                  <td>Company Product Return </td>
                  <td id="company_products_return" class="text-right"> 0.0  </td>
                  <td>Market Returned Product  </td>
                  <td id="market_returned_product" class="text-right"> 0.0  </td>
                </tr>
                <tr>
                   <td>Company Commission </td>
                  <td id="company_commission" class="text-right"> 0.0  </td>
                  <td>Salary Payment  </td>
                  <td id="salary_payment" class="text-right"> 0.0  </td>
                </tr>

                <tr>
                  <td>Income Invoice  </td>
                  <td id="sell_invoice" class="text-right"> 0.0  </td>
                  <td>Expense Invoice  </td>
                  <td id="buy_invoice" class="text-right"> 0.0  </td>
                 
                </tr>

                <tr>
                  <td>Bank Withdraw </td>
                  <td id="bank_withdraw" class="text-right"> 0.0  </td>
               
                   <td>Bank Deposit  </td>
                  <td id="bank_deposite" class="text-right"> 0.0  </td>
                </tr>

                <tr>
                  <td>Bank Loan </td>
                  <td id="bank_loan" class="text-right"> 0.0  </td>
                  
                   <td>Loan Pay  </td>
                  <td id="loan_pay" class="text-right"> 0.0  </td>
                </tr>
                
              

               

                <tr>
                  <td></td>
                  <td>   </td>
                  <td>Employee Commission  </td>
                  <td id="employee_commission" class="text-right"> 0.0  </td>
                </tr>
                <tr>
                  <td>Total Cash In</td>
                  <td id="total_credit" class="text-right"> 0.0  </td>
                  <td>Total Cash Out </td>
                  <td id="total_debit" class="text-right"> 0.0  </td>
                </tr>
                <tr class="bg-success">
                  <td colspan="4" class="text-center"> <h4><b>Cash In Hand : <span id="cash_balance">0.0</span> (Taka)</b></h4></td>
                </tr>

              </tbody>
            </table>
        </div>

      </div>
      <div class="text-center">
        <a class="text-light btn-primary btn" onclick="printContent('print_table')" name="print" id="print_receipt"> <i class="fa fa-print"></i> Print Balance Sheet</a>     
      </div>
    </div>

    <!-- /page content -->

  </div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function () {
    $(document).on('click', '#view_record', function () {
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var zone_serial_no = $("#zone_serial_no").val();

      if (zone_serial_no == "") {
        swal({
              title: "warning",
              text: "Please Select Zone",
              icon: "warning",
              button: "Done",
            });
      }else{

      $.ajax({
        url: "ajax_cash_balance.php",
        method: "POST",
        data: {
          from_date: from_date,
          to_date: to_date,
          zone_serial_no:zone_serial_no
        },
        dataType: "json",
        success: function (data) {
          // credit info 
          $("#delivery").html(data.delivery);
          $("#own_shop_sell").html(data.own_shop_sell);
          // $("#receive").html(data.receive);
          $("#sell_invoice").html(data.cell_invoice);
          // console.log(data.cell_invoice);
          $("#buy_invoice").html(data.buy_invoice);
          $("#bank_withdraw").html(data.bank_withdraw);
          $("#bank_loan").html(data.bank_loan);
          $("#company_commission").html(data.company_commission);
          $("#company_products_return").html(data.company_products_return);


          // debit info 
          $("#total_debit").html(data.total_debit);
          $("#expense").html(data.expense);
          $("#salary_payment").html(data.salary_payment);
          $("#bank_deposite").html(data.bank_deposite);
          $("#loan_pay").html(data.loan_pay);
          $("#products_buy").html(data.products_buy);
          $("#market_returned_product").html(data.market_return);
          $("#employee_commission").html(data.employee_commission);
          $("#total_credit").html(data.total_credit);
          $("#cash_balance").html(data.cash_balance);

          $("#show_date").html(data.show_date);
          $("#printing_date").html(data.printing_date);
          $("#printing_time").html(data.printing_time);
          $("#zone_name_show").html(data.zone_name);
          // console.log(show_date);


        }
      });
    }

    });
  });

  function printContent(el){
    var a = document.body.innerHTML;
    var b = document.getElementById(el).innerHTML;
    document.body.innerHTML = b;
    window.print();
    document.body.innerHTML = a;

    return window.location.reload(true);

  }
</script>

</body>

</html>