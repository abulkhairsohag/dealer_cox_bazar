<?php 
include_once('include/header.php'); 

if(!permission_check('product_wise_stock_report')){
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

    <!-- This div is for selecting Company Name -->
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">

          <!-- form starts form here -->
          <form class="form-horizontal form-bordered" id="select_company_form" action="" method="post">
            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select A Product</label>
              <div class="col-md-6">
               <select class="form-control " id="products_id_no" name="products_id_no" required="">
                <option value=""></option>

                <?php 
                include_once('class/Database.php');
                $dbOb = new Database();
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
      </form>
    </div>
  </div>
</div>
<!-- end of  div for selecting Company Name -->

<!-- The following div is for showing data into data table  -->
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2 style="color: black">Stock And Return Report</h2>
      <div class="row float-right" align="right">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <table id="datatable-buttons" class="table table-striped table-bordered">
        <thead>

          <tr>
            <th style="width: 20px">#</th>
            <th style="width: 100px">products_id_no</th>
            <th style="width: 50px">Stock Qty</th>
            <th  style="width: 50px">Company Return Qty</th>
            <th  style="width: 50px">Ware House</th>
            <th  style="width: 50px">Date</th>
          </tr>
        </thead>

        <tbody id="data_table_body">

        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){
    $(document).on('change','#products_id_no',function(){
      var products_id_no = $(this).val();
      $.ajax({
        url:"ajax_productwise_stock_report.php",
        data:{'products_id_no':products_id_no},
        type:"POST",
        dataType:"text",
        success:function(data_tbl){
          sohag.destroy();
          $("#data_table_body").html(data_tbl);
          init_DataTables();  
        }
      });
    });
  }); // end of document ready function 
</script>
</body>
</html>