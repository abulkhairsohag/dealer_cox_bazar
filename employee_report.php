<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('employee_report')){
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
        <h2 class="panel-title" style="color: white"><h3>Employee Report</h3></h2>
      </div>
      <div class="panel-body">

     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="emp_wise_sales">Sales Man Wise Sale Summery</option>
          <option value="sales_and_dues">All Sales Man's Sales & Dues</option>
          <option value="empwise_dues">Sales Man Wise Dues</option>
          <option value="sales_man_wise_party_coverage">Sales Man Wise Party Coverage</option>
          <option value="delivery_man_wise_sales">Delivery Man Wise Sales</option>
          <option value="attendance"> Attendance</option>
          <option value="salary">Monthly  Salary</option>
          <option value="target">Daily/Monthly Target</option>
          <option value="target_achivmant">Target Achievement</option>
          <option value="present_employee">Present Employee Status</option>
          <option value="ex_employee">Ex Employee Status</option>
        </select>
      </div>
    </div>


    <div class="form-group col-md-12" id="employee_id_div"  style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Sales Man<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="employee_id" id="employee_id" class="form-control">
          <option value="">Please Select A Sales Man</option>
          <?php 
          $query = "SELECT * FROM `employee_duty`";
          $get_sales_man = $dbOb->select($query);
          if ($get_sales_man) {
            while ($row = $get_sales_man->fetch_assoc()) {
              ?>

              <option value="<?php echo $row['id_no']?>"><?php echo $row['id_no'].', '.$row['name']?></option>
<?php
            }
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group col-md-12" id="employee_id_div_sales"  style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Sales Man<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="employee_id_sales" id="employee_id_sales" class="form-control">
          <option value="">Please Select One</option>
          <option value="all_employee">All Sales Man</option>
          <?php 
          $query = "SELECT * FROM `employee_duty`";
          $get_sales_man = $dbOb->select($query);
          if ($get_sales_man) {
            while ($row = $get_sales_man->fetch_assoc()) {
              ?>

              <option value="<?php echo $row['id_no']?>"><?php echo $row['id_no'].', '.$row['name']?></option>
<?php
            }
          }
          ?>
        </select>
      </div>
    </div>


    <div class="form-group col-md-12" id="deliv_employee_id_div"  style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Delivery Man<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="deliv_employee_id" id="deliv_employee_id" class="form-control">
          <option value="">Please Select A Delivery  Man</option>
          <?php 
          $query = "SELECT * FROM `delivery_employee`";
          $get_sales_man = $dbOb->select($query);
          if ($get_sales_man) {
            while ($row = $get_sales_man->fetch_assoc()) {
              ?>

              <option value="<?php echo $row['id_no']?>"><?php echo $row['id_no'].', '.$row['name']?></option>
<?php
            }
          }
          ?>
        </select>
      </div>
    </div>



     <div class="form-group col-md-12" id="month" style="display:none">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Month Name<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");  ?>
         <input class="js-monthpicker" type="hidden" name="month" id="month_name">
         <input type="text" class="form-control" readonly="" placeholder="Select Month"> 
       </div>
     </div>



     <div class="form-group col-md-12" id="date_from" style="display:none">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");  ?>
         <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today  ?>" required="" readonly="">
       </div>
     </div>



     <div class="form-group col-md-12" id="date_to"  style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        
        <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="">
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
            if (permission_check('employee_report')) {
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
      var report_type = $("#report_type").val();
      var month_name = $("#month_name").val();
      var employee_id = $("#employee_id").val();
      var from_date = $("#from_date").val();
      var deliv_employee_id = $("#deliv_employee_id").val();
      var employee_id_sales = $("#employee_id_sales").val();
      // console.log(from_date);
      var to_date = $("#to_date").val();
       $("#show_table").html('');

      $.ajax({
        url: "ajax_employee_report.php",
        method: "POST",
        data:{report_type:report_type,month_name:month_name,employee_id:employee_id,from_date:from_date,to_date:to_date,deliv_employee_id:deliv_employee_id,employee_id_sales:employee_id_sales},
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
          // console.log(data);
        }
      });

    });

    $(document).on('change','#report_type',function(){
      $report_type = $(this).val();

     if($report_type == 'target' || $report_type == 'present_employee' || $report_type == 'ex_employee' || $report_type == 'salary'){
        $("#month").hide(500);
        $("#date_from").hide(500);
        $("#date_to").hide(500);
        $("#employee_id_div").hide(500);
        $("#employee_id").val('');
        $("#deliv_employee_id_div").hide(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div_sales").hide(500);
        $("#employee_id_sales").val('');
      }else if ($report_type == 'target_achivmant' || $report_type == 'attendance') {
        $("#month").show(500);
        $("#date_from").hide(500);
        $("#date_to").hide(500);
        $("#employee_id_div").hide(500);
        $("#employee_id").val('');
        $("#deliv_employee_id_div").hide(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div_sales").hide(500);
        $("#employee_id_sales").val('');
      }else if( $report_type =='sales_and_dues'){
        $("#month").hide(500);
        $("#employee_id_div").hide(500);
        $("#employee_id").val('');
        $("#date_from").show(500);
        $("#date_to").show(500);
        $("#deliv_employee_id_div").hide(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div_sales").hide(500);
        $("#employee_id_sales").val('');
      }else if( $report_type =='empwise_dues'){
        $("#month").hide(500);
        $("#employee_id_div").show(500);
        $("#employee_id").val('');
        $("#date_from").show(500);
        $("#date_to").show(500);
        $("#deliv_employee_id_div").hide(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div_sales").hide(500);
        $("#employee_id_sales").val('');
      }else if( $report_type =='sales_man_wise_party_coverage'){
        $("#month").hide(500);
        $("#employee_id_div").show(500);
        $("#employee_id").val('');
        $("#date_from").show(500);
        $("#date_to").show(500);
        $("#deliv_employee_id_div").hide(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div_sales").hide(500);
        $("#employee_id_sales").val('');
      }else if( $report_type =='delivery_man_wise_sales'){
        $("#month").hide(500);
        $("#employee_id_div").hide(500);
        $("#employee_id").val('');
        $("#date_from").show(500);
        $("#date_to").show(500);
        $("#deliv_employee_id_div").show(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div_sales").hide(500);
        $("#employee_id_sales").val('');
      
      }else if( $report_type =='emp_wise_sales'){
        $("#month").hide(500);
        $("#employee_id_div_sales").show(500);
        $("#employee_id_sales").val('');
        $("#date_from").show(500);
        $("#date_to").show(500);
        $("#deliv_employee_id_div").hide(500);
        $("#deliv_employee_id").val('');
        $("#employee_id_div").hide(500);
        $("#employee_id").val('');
      }
    });
  });


  $('.js-monthpicker').monthpicker({ format: 'm-Y' });
  
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