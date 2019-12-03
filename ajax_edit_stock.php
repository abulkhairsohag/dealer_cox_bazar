<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
$user_type = Session::get("user_type");
?>


<?php 

include_once("class/Database.php");
$dbOb = new Database();

if (isset($_POST['submit'])) {

	$quantity           = $_POST['quantity'];
	$existing_quantity  = $_POST['existing_quantity'];
	$products_id_no     = $_POST['products_id_no'];
	$company_price      = $_POST['company_price'];
	$stock_date         = $_POST['stock_date'];
	$serial_no_edit     = $_POST['serial_no_edit'];
    
    $query = "SELECT * FROM products WHERE products_id_no = '$products_id_no' ";
    $products_info = $dbOb->select($query);
    if ($products_info) {
        $available_qty = $products_info->fetch_assoc()['quantity'];
    }else{
        $message = "No Need to Update. Product Is No longer Available..";
        $type = "warning";
        die(json_encode(['message'=>$message,'type'=>$type]));
    }
    
    $new_available_qty = $available_qty - $existing_quantity  + $quantity ;
    
    $query = "UPDATE products SET 
                quantity = '$new_available_qty',
                company_price= '$company_price'
                
             WHERE products_id_no = '$products_id_no'";
    
    $update = $dbOb->update($query);
 
    if ($update) {
        $query = "UPDATE product_stock SET 
                    quantity = '$quantity',
                    stock_date= '$stock_date',
                    company_price= '$company_price'
             where serial_no = '$serial_no_edit'";
             
        $update_stock = $dbOb->update($query);
        if ($update_stock) {
            $message ='Stock Updated Successfully';
			$type = 'success';
            die(json_encode(['message'=>$message,'type'=>$type]));
        }else{
            $message ='Products Table Updated but Stock Not Updated';
			$type = 'warning';
            die(json_encode(['message'=>$message,'type'=>$type]));
        }
    }else{
        $message ='Update Failed';
        $type = 'warning';
        die(json_encode(['message'=>$message,'type'=>$type]));
    }
    


}

if (isset($_POST['serial_no_edit'])) {
	$serial_no = $_POST['serial_no_edit'];
	// die($serial_no);
	$query = "SELECT * FROM product_stock WHERE serial_no = '$serial_no'";	
	$get_stock = $dbOb->find($query);
	echo json_encode($get_stock);
}


// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
    $query = "SELECT * FROM products";
    $products = $dbOb->select($query);
    $stock_serial_no = [];
    if ($products) {
        $j = 0;
        while ($prod = $products->fetch_assoc()) {
            $products_id = $prod['products_id_no'];
            $query = "SELECT * FROM product_stock WHERE quantity > 0 AND products_id_no = '$products_id' ORDER BY serial_no DESC";
            $get_stock_info = $dbOb->select($query);
            if ($get_stock_info) {
                $stock_serial_no[$j] = $get_stock_info->fetch_assoc()['serial_no'];
                $j++;
            }
        }
    }
    $query = "SELECT * FROM product_stock WHERE quantity > 0 ORDER BY serial_no DESC";
    $get_products = $dbOb->select($query);
    if ($get_products) {
      $i=0;
      while ($row = $get_products->fetch_assoc()) {
          $products_id = $row['products_id_no'];
          $query = "SELECT * FROM products WHERE products_id_no = '$products_id'";
          $get_info = $dbOb->select($query);
          $product_name = '';
          if ($get_info) {
              $product_name = $get_info->fetch_assoc()['products_name'];
          }
        $i++;
        ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $products_id; ?></td>
          <td><?php echo $product_name; ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td><?php echo $row['company_price']; ?></td>
          <td><?php echo $row['company_price'] * $row['quantity']; ?></td>
          <td><?php echo $row['stock_date']; ?></td>

          <td align="center">

           <?php 
            if (in_array($row['serial_no'], $stock_serial_no)) {
                
            
            ?>
            <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#stock_data_modal" style="margin:2px">Edit</a>
          <?php } ?>
          
        </td>
        
      </tr>

      <?php
    }
  }
}
?>