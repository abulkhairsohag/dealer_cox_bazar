<?php include_once 'include/header.php';?>

<?php
if (!permission_check('account_report')) {
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
        <h2 class="panel-title" style="color: white"><h3>Accounts Report</h3></h2>
      </div>
      <div class="panel-body">



     <div class="form-group col-md-12" id="zone" style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Zone<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">

        <?php 

           if (Session::get("zone_serial_no")){
              if (Session::get("zone_serial_no") != '-1') {
                $zone_serial_no = Session::get("zone_serial_no");
                ?>
                <input type="text" class="form-control " id='zone_serial_no' name="zone_serial_no" value="<?php echo $zone_serial_no ?>" required="" readonly="">

                <?php
              }
            }else{
              ?>
               <input type="text" class="form-control " id='zone_serial_no' name="zone_serial_no" value="-1" required="" readonly="">
               <?php
            }
        
        ?>
      </div>
    </div>

       <div class="form-group col-md-12" id="date_from">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");?>
         <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today ?>" required="" readonly="">
       </div>
     </div>





     <div class="form-group col-md-12" id="date_to">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">

        <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today ?>" required="" readonly="">
      </div>
    </div>



    <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">


        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="Receive From Customer">Receive From Customer</option>
          <option value="Pay To Company">Pay To Company</option>
          <option value="Bank Deposit">Bank Deposit</option>
          <option value="Bank Withdraw">Bank Withdraw</option>
          <option value="Bank Loan">Bank Loan</option>
          <option value="Buy Invoice">Expense Invoice</option>
          <option value="Sell Invoice">Income Invoice</option>
          <option value="All Invoice">All Invoice</option>
          <option value="Company Commission">Company Commission</option>
          <option value="Employee Commission">Employee Commission</option>
          <option value="Employee Payment">Employee Payment</option>
          <option value="Balance Sheet/Cash Balance">Balance Sheet/Cash Balance</option>
        </select>
      </div>
    </div>





    <div class="form-group" style="margin-bottom: 20px;" align="center">

      <div class="col-md-12 col-sm-6 col-xs-8">
         <?php
if (permission_check('account_report')) {
	?>
        <button class="btn btn-success" id="view_record">View Record</button>
        <?php }?>
      </div>
    </div>






  </div>
</div>
<div class="well" style="background: white;margin-top: 20px">
  <div class="row" id="show_table">




  </div>
</div>



<!-- Modal For Showing data  -->
<div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " style="width: 700px" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title" id="ModalLabel" style="color: white">Bank Loan Information</h3>
        <div style="float:right;">

        </div>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="background: #f2ffe6">

              <div class="x_content" style="background: #f2ffe6">
                <br />


                <div style="margin : 20px" id="info_table">

                  <div class="row"><div class="col"> <h3 style="color:  #34495E">General Information</h3><hr></div></div>

                  <div class="row" style="margin-top:10px" >
                    <div class="col-md-3"></div>
                    <div class="col-md-3"><h5 style="color:black">Bank Name </h5></div>
                    <div class="col-md-3"><h5 style="color:black" id="bank_name_view" ></h5></div>
                    <div class="col-md-3"></div>
                  </div>

                  <div class="row" style="margin-top:10px" >
                    <div class="col-md-3"></div>
                    <div class="col-md-3"><h5 style="color:black">Branch Name</h5></div>
                    <div class="col-md-3" ><h5 style="color:black" id="branch_name_view"></h5></div>
                    <div class="col-md-3"></div>
                  </div>

                  <div class="row" style="margin-top:10px" >
                    <div class="col-md-3"></div>
                    <div class="col-md-3"><h5 style="color:black">Total Loan Amount</h5></div>
                    <div class="col-md-3"><h5 style="color:black" id="total_pay_amount_view"></h5></div>
                    <div class="col-md-3"></div>
                  </div>


                  <div class="row" style="margin-top:10px"><div class="col"> <h3 style="color:  #34495E">Pay Information</h3><hr></div></div>


                  <div class="table-responsive">
                    <table class="table table-striped mb-none">
                      <thead style="background: green">
                        <tr style="color: white">
                          <th>#</th>
                          <th>Pay Amount</th>
                          <th>Pay Date</th>
                        </tr>
                      </thead>
                      <tbody id="order_table">



                      </tbody>
                    </table>
                  </div>

                </div>   <!-- End of info table  -->

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- End of modal for  Showing data-->

<!-- /page content -->

</div>
</div>
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){
    $(document).on('click','#view_record',function(){
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var report_type = $("#report_type").val();
      var zone_serial_no = $("#zone_serial_no").val();
      // alert(zone_serial_no);
      $("#show_table").html("");

      if (report_type == 'Balance Sheet/Cash Balance') {

        $.ajax({
          url: "ajax_cash_balance.php",
          method: "POST",
          data:{from_date:from_date,to_date:to_date,report_type:report_type,zone_serial_no:zone_serial_no},
          dataType: "json",
          success:function(data){

            var cash_balance_tbl ='<div class="row" id="print_table" ><div style="color:black" class="col-md-12"><span class="text-center"><h3><b>'+data.organization_name+'</b></h3><h5>'+data.organization_address+'</h5><h5>'+data.organization_email+', '+data.organization_mobile_no+'</h5><h5 id="show_date">'+data.show_date+'</h5></span><div class="text-center"><h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>BALANCE SHEET</b></h4> </div><br><table class="table table-responsive"><tbody><tr><td><h5 style="margin:0px ; margin-top: -8px;">Zone : <span id="printing_date">'+data.zone_name+'</span></span></h5></td><td class="text-center"></td><td class="text-right"><h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span id="printing_date">'+data.printing_date+'</span></span></h5><h5 style="margin:0px ; margin-top: -8px;">Time : <span id="printing_time">'+data.printing_time+'</span></span></span></h5></td></tr></tbody></table></div> <div class="col-md-12 text-dark" style="color:black"><table class="table table-responsive table-bordered "><tbody><tr class="text-center bg-green"><td colspan="2"><h4><b>CASH IN</b></h4></td> <td  colspan="2"><h4><b>CASH OUT </b></h4></td></tr><tr class="bg-success"> <td> <h5><b>DESCRIPTION</b></h5>  </td> <td> <h5><b>AMOUNT (৳)</b></h5>  </td> <td> <h5><b>DESCRIPTION</b></h5>  </td> <td> <h5><b>AMOUNT (৳)</b></h5>  </td> </tr> <tr> <td>Delivery  </td> <td id="delivery" class="text-right"> '+data.delivery+' </td> <td>Product Purchase  </td> <td id="expense" class="text-right">'+data.products_buy+'</td> </tr> <tr> <td>Company Product Return </td> <td id="company_products_return" class="text-right">'+data.company_products_return+'</td> <td>Market Returned Product  </td>  <td id="market_returned_product" class="text-right">'+data.market_return+'</td>  </tr> <tr> <td>Company Commission </td> <td id="company_commission" class="text-right">'+data.company_commission+'</td>   <td>Salary Payment  </td> <td id="salary_payment" class="text-right">'+data.salary_payment+'</td> </tr> <tr> <td>Income Invoice  </td>  <td id="sell_invoice" class="text-right">'+data.cell_invoice+'</td> <td>Expense Invoice  </td> <td id="buy_invoice" class="text-right">'+data.buy_invoice+'</td> </tr> <tr> <td>Bank Withdraw </td> <td id="bank_withdraw" class="text-right">'+data.bank_withdraw+'</td><td>Bank Deposit  </td>  <td id="bank_deposite" class="text-right">'+data.bank_deposite+'</td> </tr> <tr> <td>Bank Loan </td> <td id="bank_loan" class="text-right">'+data.bank_loan+'</td>  <td>Loan Pay  </td> <td id="loan_pay" class="text-right">'+data.loan_pay+'</td> </tr><tr><td>Receive</td><td id="receive" class="text-right" >'+data.receive+'</td><td>Expense  </td><td id="expense" class="text-right">'+data.expense+'</td></tr> <tr>  <td></td>  <td>   </td><td>Employee Commission  </td> <td id="employee_commission" class="text-right">'+data.employee_commission+'</td></tr> <tr><td>Total Cash In</td><td id="total_credit" class="text-right">'+data.total_credit+'</td><td>Total Cash Out </td> <td id="total_debit" class="text-right">'+data.total_debit+'</td></tr> <tr class="bg-success"><td colspan="4" class="text-center"> <h4><b>Cash In Hand : <span id="cash_balance">'+data.cash_balance+'</span> (Taka)</b></h4></td>  </tr> </tbody> </table> </div> </div> <div class="text-center"> <a class="text-light btn-primary btn" onclick="printContent(\'print_table\')" name="print" id="print_receipt"> <i class="fa fa-print"></i> Print Balance Sheet</a> </div>';
            $("#show_table").html(cash_balance_tbl);
          }
        });

      }else{
        $.ajax({
          url: "ajax_accounts_report.php",
          method: "POST",
          data:{from_date:from_date,to_date:to_date,report_type:report_type},
          dataType: "json",
          success:function(data){
            $("#show_table").html(data);
            // console.log(data);
          }
        });
      }



    });



    $(document).on('click','.view_data',function(){
      var serial_no = $(this).attr("id");
  // alert(serial_no_edit);
  $.ajax({
    url : "ajax_view_bank_loan.php",
    method: "POST",
    data : {serial_no_view:serial_no},
    dataType: "json",
    success:function(data){

      $("#bank_name_view").html(data.query_loan['bank_name']);
      $("#branch_name_view").html(data.query_loan['branch_name']);
      $("#total_pay_amount_view").html(data.query_loan['total_amount']);
      $("#installment_amount_view").html(data.query_loan['installment_amount']);
      $("#installment_date_view").html(data.query_loan['installment_date']);


      $("#order_table").html(data.expense);

    }
  });
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