<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('market_report')){
  ?>
  <script>
    window.location.href = '403.php';
  </script>
  <?php 
}
 ?>

<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->

    <div>
      <div class="panel-heading" style="background: #34495E;color: white; padding-bottom: 10px" align="center">
        <h2 class="panel-title" style="color: white"><h3>Market Report</h3></h2>
      </div>
      <div class="panel-body">

<div id="date">
       <div class="form-group col-md-12">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");  ?>
         <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today  ?>" required="" readonly="">
       </div>
     </div>



     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        
        <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="">
      </div>
    </div>
    </div>



     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="Orders">All Orders</option>
          <option value="Delivery">Delivery Completed</option>
          <option value="Delivery_pending">Delivery Pending</option>
          <option value="Delivery_cancelled">Delivery Cancelled</option>
          <option value="return_from_customer">Returned Product From Customer</option>
          <!-- <option value="order_and_delivery">Order & Delivery</option> -->
          <!-- <option value="area_wise_employee">Area Wise Employee List</option> -->
          <!-- <option value="sample_product_delivery">Sample Product Delivery To Customer</option> -->
          <!-- <option value="sample_product_test">Sample Product Test in DEPO</option> -->
        </select>
      </div>
    </div>


<div id="area_employee" style="display: none;">
     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Area<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="area" id="area" class="form-control">
          <option value="">Please Select One</option>
          <option value="all_area">All Area</option>
          <?php 
            $query = "SELECT * FROM area";
            $get_area = $dbOb->select($query);
            if ($get_area) {
              while ($row = $get_area->fetch_assoc()) {
                ?>
                  <option value="<?php echo $row['area_name'] ?>"><?php echo $row['area_name'] ?></option>
                <?php
              }
            }

           ?>

        </select>
      </div>
    </div>

     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Employee Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="employee_type" id="employee_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="sales_man">Sales Man</option>
          <option value="delivery_man">Delivery Man</option>
          

        </select>
      </div>
    </div>
    </div>





    <div class="form-group" style="margin-bottom: 20px;" align="center">

      <div class="col-md-12 col-sm-6 col-xs-8">
         <?php 
            if (permission_check('market_report')) {
          ?>
        <button class="btn btn-success" id="view_record">View Record</button>
        <?php } ?>  
      </div>
    </div>






  </div>
</div>
<div class="well" style="background: white;margin-top: 20px">
  <div class="row" id="show_table">




  </div>
</div>

<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){
    $(document).on('click','#view_record',function(){
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var report_type = $("#report_type").val();
      var area = $("#area").val();
      var employee_type = $("#employee_type").val();
       $("#show_table").html('');

      $.ajax({
        url: "ajax_market_report.php",
        method: "POST",
        data:{from_date:from_date,to_date:to_date,report_type:report_type,area:area,employee_type:employee_type},
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
          // console.log(data);
        }
      });

    });

    $(document).on('change','#report_type',function(){
      $report_type = $(this).val();

      if ($report_type == 'area_wise_employee') {
        $("#area_employee").show(1000);
        $("#date").hide(1000);
      }else{
        $("#area_employee").hide(1000);
        $("#date").show(1000);
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