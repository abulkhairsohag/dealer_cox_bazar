<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
?>



<?php 
include_once("class/Database.php");
$dbOb = new Database();




// the following section is for fetching data from database 
if (isset($_POST["products_id_no"])) 
  
          $products_id_no = $_POST["products_id_no"];
          $total_stock = 0;
          $total_return = 0;
          $query = "SELECT * FROM product_stock WHERE products_id_no = '$products_id_no' ORDER BY serial_no DESC";
          $get_stock = $dbOb->select($query);
          if ($get_stock) {
            $i=0;
            while ($row = $get_stock->fetch_assoc()) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['products_id_no']; ?></td>
                
                <?php 

                  if ($row['quantity']>=0) {
                    $stock = $row['quantity'];
                    $total_stock +=$row['quantity'];
                    $return = '----';
                  }else{
                    $return = -1*(int)$row['quantity'];
                    $total_return  += -1*(int)$row['quantity'];
                    $stock = '----';
                  }

                 ?>

                <td><?php echo $stock; ?></td>
                <td><?php echo $return; ?></td>
                <td><?php echo $row['stock_date']; ?></td>
                   
              </tr>

              <?php
            }

            ?>
             <tr>
              <td style="color: red"><?php echo (int)++$i; ?></td>
              <td style="color: red">Total </td>
              <td style="color: red"><?php echo $total_stock; ?></td>
              <td style="color: red"><?php echo $total_return; ?></td>
              <td style="color: red">-- -- ----</td>
            </tr>
             <?php
           


            exit();
          

}

?>