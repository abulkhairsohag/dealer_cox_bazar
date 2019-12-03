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
        <h2 class="panel-title" style="color: white"><h3>Product Report</h3></h2>
      </div>
      <div class="panel-body">


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





     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="sales_dues">Sales And Dues Statement</option>
          <option value="area_wise_sales_dues">Area Wise Sales And Dues</option>
          <option value="all_product_stock_and_sell">All Product Stock & sell</option>
          <option value="product_wise_stock_and_sell">Product Wise Stock & sell</option>
          <option value="sell">Product Wise Sell</option>
          <option value="market_return">Product Wise Returned From Market</option>
          <option value="company_return">Product Wise Returned To Company</option>
          <option value="top_sell">Top Selling Product</option>
          <option value="lowest_sell">Lowest Selling Product</option>
          <option value="top_profit">Top Profitable Product</option>
          <option value="lowest_profit">Lowest Profitable Product</option>
          <!-- <option value="sample_product">Sample Products From Company</option> -->
          <!-- <option value="sample_product_stock">Sample Products In Stock</option> -->
        </select>
      </div>
    </div>

    <div class="form-group col-md-12" id="product_info" style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Product <span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="product_id" id="product_id" class="form-control">
                <option value="">Please Select One</option>
                <?php 
              
                $query = "SELECT distinct products_id_no FROM product_stock";
                $get_product = $dbOb->select($query);

                if ($get_product) {
                 while ($row = $get_product->fetch_assoc()) {
                  $id = $row['products_id_no'];
                  $query_product_info = "SELECT * FROM products WHERE products_id_no = '$id'";
                  $get_product_info  = $dbOb->find($query_product_info);
                   ?>

                   <option value="<?php echo $row['products_id_no'] ?>"> <?php echo $get_product_info['products_name'].', '.$get_product_info['company']; ?> </option>

                   <?php
                 }
               }
               ?>
        </select>
      </div>
    </div>

    <div class="form-group col-md-12" id="area_div" style="display:none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Area <span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="area" id="area" class="form-control">
                <option value="">Please Select One</option>
                <?php 
               
                $query = "SELECT * FROM area";
                $get_area = $dbOb->select($query);

                if ($get_area) {
                 while ($row = $get_area->fetch_assoc()) {
                   ?>

                   <option value="<?php echo $row['area_name'] ?>"> <?php echo $row['area_name']; ?> </option>

                   <?php
                 }
               }
               ?>
        </select>
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

      $("#show_table").html("");


      $.ajax({
        url: "ajax_product_report.php",
        method: "POST",
        data:{from_date:from_date,to_date:to_date,report_type:report_type,product_id:product_id,area:area},
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
          // console.log(data);

        }
      });

    });


    $(document).on('change','#report_type',function(){
    	var report_type = $(this).val();

    	if (report_type == "top_sell" || report_type == "lowest_sell" || report_type == "top_profit" ||report_type == "lowest_profit" || report_type == "all_product_stock_and_sell" || report_type == "" || report_type == "sales_dues") {
    		$("#product_info").hide('1500');
    		$("#product_id").val('');
    		$("#area_div").hide('1500');
    	}else if(report_type == 'area_wise_sales_dues'){
    		$("#product_info").hide('1500');
    		$("#product_id").val('');
    		$("#area_div").show('1500');
    		$("#area").val('');
      }else{
    		$("#area_div").hide('1500');
    		$("#area").val('');
    		$("#product_id").val('');
    		$("#product_info").show('1500');

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