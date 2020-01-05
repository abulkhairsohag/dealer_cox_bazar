<?php include_once 'include/header.php';?>


<?php
if (!permission_check('own_shop_products')) {
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

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Own Shop Product List</h2>
          <div class="row float-right" align="right">
           
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-buttons" class="table table-striped table-bordered">
          <thead>

            <tr>
              <th style="width: 12px">#</th>
              <th style="width: 70px">ID</th>
              <th style="width: 70px">Name</th>
              <th style="width: 80px">Category</th>
              <th style="width: 35px">Available QTY(PCS)</th>
              <th style="width: 35px">Sell Price</th>
            </tr>
          </thead>


          <tbody id="data_table_body">
            <?php
            include_once 'class/Database.php';
            $dbOb = new Database();
            $query = "SELECT * FROM own_shop_products_stock ORDER BY products_id";
            $get_products = $dbOb->select($query);
            if ($get_products) {
              $i = 0;
              while ($row = $get_products->fetch_assoc()) {
                $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row['products_id']; ?></td>
                  <td><?php echo strtoupper($row['product_name']); ?></td>
                  <td><?php echo strtoupper($row['category']); ?></td>
                  <td><?php echo $row['quantity_pcs']; ?></td>
                  <td><?php echo $row['sell_price']; ?></td>

                  

              </tr>

              <?php
            }
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
</div>






<!-- the following modal is for updating original price of product -->

<!-- End of update original price of a product -->


<!-- /page content -->

</div>
</div>
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){








      // this time we are adding new stock
      $(document).on('submit','#form_stock_data',function(event){
        event.preventDefault();
        var formDataStock = new FormData($("#form_stock_data")[0]);
        formDataStock.append('submit_stock','submit_stock');

        $.ajax({
          url:'ajax_add_product.php',
          data:formDataStock,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
            if (data.type == 'success') {
              $("#new_quantity").val("");
              $("#stock_date").val("");
              $("#stock_data_modal").modal("hide");
              get_data_table();
            }
          }
        });
      });



    //getting and setting data for adding stock.
   

  // calculating total number of avaulable product after adding new stock

 




  }); // end of document ready function

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_add_product.php",
    data:{'sohag':'sohag'},
    type:"POST",
    dataType:"text",
    success:function(data_tbl){
      sohag.destroy();
      $("#data_table_body").html(data_tbl);
      init_DataTables();

    }
  });
}
// the following function is for image preview
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#photo_div").removeClass();
      $("#photo_div").addClass("col-md-4 col-sm-4 col-xs-8");
      $("#photo_div").css("margin-top","50px");
      $("#photo_label").css("margin-top","50px");
      $('#output_image')
      .show()
      .attr('src', e.target.result)
      .width(128)
      .height(120);

    };

    reader.readAsDataURL(input.files[0]);
  }
}

</script>

</body>
</html>