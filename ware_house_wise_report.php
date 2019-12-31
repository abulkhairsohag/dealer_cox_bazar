<?php include_once('include/header.php'); 

      include_once('class/Database.php');
      $dbOb = new Database();
?>

<?php 
if(!permission_check('product_report')){
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
        <h2 class="panel-title" style="color: white"><h3>Ware House Wise Report</h3></h2>
      </div>
      <div class="panel-body">




     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Ware House<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        
        <select name="ware_house_serial_no" id="ware_house_serial_no"  required="" class="form-control ware_house_serial_no ">
          <option value="">Please Select One</option>
          <?php

          $query = "SELECT * FROM ware_house ORDER BY ware_house_name";
          $get_ware_house = $dbOb->select($query);
          if ($get_ware_house) {
            while ($row = $get_ware_house->fetch_assoc()) {

            ?>
            <option value="<?php echo $row['serial_no']; ?>" <?php if (Session::get("ware_house_serial_no") == $row["serial_no"]) {
              echo "selected";
            } ?>
            ><?php echo $row['ware_house_name']; ?></option>
            <?php
          }
        }

        ?>

    </select>
      </div>
    </div>


     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="all_product_stock_and_sell">All Product Stock & sell</option>
          <option value="products in stock">Products In Stock</option>
          <option value="dues">Summery Of Dues</option>
          <option value="order wise dues">Order Wise Dues</option>
          <option value="all sales">All Sales Summery</option>
       <!--  -->
        </select>
      </div>
    </div>

   
        <div id="date_div" style="display:none">

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


    <div class="form-group" style="margin-bottom: 20px;" align="center">

      <div class="col-md-12 col-sm-6 col-xs-8">
         <?php 
            if (permission_check('product_report')) {
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
      var product_id = $("#product_id").val();
      var area = $("#area").val();
      var ware_house_serial_no = $("#ware_house_serial_no").val();

      $("#show_table").html("");

      $.ajax({
        url: "ajax_ware_house_wise_report.php",
        method: "POST",
        data:{from_date:from_date,to_date:to_date,report_type:report_type,product_id:product_id,area:area,ware_house_serial_no:ware_house_serial_no},
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
          // console.log(data);

        }
      });

    });


    $(document).on('change','#report_type',function(){
      var report_type = $(this).val();
      if (report_type == "all sales" || report_type == 'all_product_stock_and_sell') {
        $("#date_div").show('1500');
      }else{
        $("#date_div").hide('1500');
      }
    });


  
  $(document).on('change','#ware_house_serial_no',function(){
     var ware_house_serial_no = $(this).val();
     $.ajax({
        url:'ajax_new_order.php',
        data:{ware_house_serial_no:ware_house_serial_no},
        type:'POST',
        dataType:'json',
        success:function(data){
          // $("#cust_id").html(data);
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
  $("#area").select2({ width: '100%' }); 
  $("#product_id").select2({ width: '100%' }); 
</script>

</body>
</html>