<?php include_once('include/header.php'); ?>

<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title hidden-print">
          <h2 style="font-size: 23px">Print Barcode Of Product</h2>
          <div class="row float-right" align="right">
            <a href="add_product.php" class="btn btn-primary" ><span class="badge"><i class="fas fa-reply"></i></span> Back</a>
          </div>
          <div class="row float-center" align="center">
            <button class="btn btn-success" onclick="window.print()" style="font-size: 20px"><span class="badge" style="width: 30px;height: 20px"><i class="fa fa-print"></i></span> Print Barcode</button>  
    
          </div>
       
      
          <div class="clearfix "></div>
        </div>
        <div class="x_content">

          <table id="print_table" class="table table-striped table-bordered">

            <tbody id="">
             <?php 
                include_once("class/Database.php");
                $dbOb = new Database();
                $products_id_no = '';
                if (isset($_GET['products_id_no'])) {
                  $products_id_no = $_GET['products_id_no'];
                  $query = "SELECT * FROM products WHERE products_id_no = '$products_id_no'";
                  $get_product = $dbOb->find($query);
                  for ($i=0; $i <8 ; $i++) { 
                    ?>

                    <tr>
                      <td align="center">Name:<?php echo $get_product['products_name']; ?></br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $products_id_no ?>' alt='Barcode Generator TEC-IT'/ width="100px" height=70px></td>
                      <td align="center">Name:<?php echo $get_product['products_name']; ?></br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $products_id_no ?>' alt='Barcode Generator TEC-IT'/ width="100px" height=70px></td>
                      <td align="center">Name:<?php echo $get_product['products_name']; ?></br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $products_id_no ?>' alt='Barcode Generator TEC-IT'/ width="100px" height=70px></td>
                      <td align="center">Name:<?php echo $get_product['products_name']; ?></br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $products_id_no ?>' alt='Barcode Generator TEC-IT'/ width="100px" height=70px></td>
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

  <!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>


</body>
</html>