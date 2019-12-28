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



// inserting data into data base 

if (isset($_POST['submit'])) {

	


	$ware_house_serial_no= $_POST['ware_house_serial_no'];
	$ware_house_name= '';
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_ware_house  = $dbOb->select($query);
	if ($get_ware_house) {
		$ware_house_name = $get_ware_house->fetch_assoc()['ware_house_name'];
	}


	$stock_date= $_POST['stock_date'];

	$product_id= $_POST['product_id'];
	$products_name = $_POST['products_name'];
	$category = $_POST['category'];
	$quantity = $_POST['quantity'];
	$quantity_offer = $_POST['quantity_offer'];
	$sell_price = $_POST['sell_price'];

    $query = "SELECT * FROM own_shop_products_stock";
    $get_own_shop_stock = $dbOb->select($query);
    $avaialble_products_id = [];
    if ($get_own_shop_stock) {
        $i = 0;
        while ($row = $get_own_shop_stock->fetch_assoc()) {
            $avaialble_products_id[$row['products_id']] = $row['quantity_pcs'];
            $i++;
        }
    }

    	for ($i=0; $i <count($product_id) ; $i++) { 
            $availability = false;
            $pr_id = $product_id[$i];
            if ($quantity[$i] > 0) {
                foreach ($avaialble_products_id as $id=>$qty_pcs) {
                    if ($id == $pr_id) {
                        $query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
                        $product_info =  $dbOb->find($query);
                        $pack_size =$product_info['pack_size'];
                        $new_pcs = $quantity[$i] * $pack_size;
                        $available_pcs = $qty_pcs +  $new_pcs;
                        if ($quantity_offer[$i] != "N/A") {
                             $available_pcs += $quantity_offer[$i];
                        }
                        $query = "SELECT * FROM own_shop_products_stock  WHERE products_id = '$id'";
                        $existing_sell_price = $dbOb->find($query)['sell_price'];
                        if ($sell_price[$i] == "") {
                            $new_sell_price = $existing_sell_price;
                        }else{
                             $new_sell_price = $sell_price[$i];
                        }
                        $query ="UPDATE own_shop_products_stock SET quantity_pcs = '$available_pcs', sell_price = '$new_sell_price' WHERE products_id = '$id'";
                        $update = $dbOb->update($query);
                        if ($update) {
                            $available_product_qty_pack =  $product_info['quantity'];
                            $nw_available = $available_product_qty_pack - $quantity[$i];
                            $query = "UPDATE products SET quantity = '$nw_available' WHERE products_id_no = '$id'";
                            $update_main_prod = $dbOb->update($query);
                            $query = "INSERT INTO own_shop_stock_history 
                            (products_id,product_name,quantity_packet,quantity_offer,stock_date,ware_house_serial_no,ware_house_name)
                            VALUES
                            ('$product_id[$i]','$products_name[$i]','$quantity[$i]','$quantity_offer[$i]','$stock_date','$ware_house_serial_no','$ware_house_name')";
                            $insert_history = $dbOb->insert($query);
                        }
                        $availability = true;
                      break ;

                    }
                }


                // if product is not added to the shop before then they will be added here
                if (!$availability) {
                    $query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
                    $product_info =  $dbOb->find($query);
                    $pack_size =$product_info['pack_size'];
                 
                    $new_pcs = $quantity[$i] * $pack_size;
                    $available_pcs =  $new_pcs ;
                    if ($quantity_offer[$i] != "N/A") {
                            $available_pcs += $quantity_offer[$i];
                    }
                  

                    $query = "INSERT INTO own_shop_products_stock 
                                        (products_id,product_name,category,quantity_pcs,sell_price)
                                        values
                                        ('$product_id[$i]','$products_name[$i]','$category[$i]','$available_pcs','$sell_price[$i]')";
                    $insert_stock = $dbOb->insert($query);

                    if ($insert_stock) {
                        $available_product_qty_pack =  $product_info['quantity'];
                            $nw_available = $available_product_qty_pack - $quantity[$i];
                            $query = "UPDATE products SET quantity = '$nw_available' WHERE products_id_no = '$pr_id'";
                            $update_main_prod = $dbOb->update($query);

                          $query = "INSERT INTO own_shop_stock_history 
                            (products_id,product_name,quantity_packet,quantity_offer,stock_date,ware_house_serial_no,ware_house_name)
                            VALUES
                            ('$product_id[$i]','$products_name[$i]','$quantity[$i]','$quantity_offer[$i]','$stock_date','$ware_house_serial_no','$ware_house_name')";
                            $insert_history = $dbOb->insert($query);
                    }
                }
            }
        }

        if ($insert_history) {
            $message = "Products Added To The Shop Successfully...";
            $type = "success";
           die(json_encode(['message'=>$message,'type'=>$type]));
        }else{
    		$message = "Products Add Failed..";
    		$type = 'warning';
    		die(json_encode(['message'=>$message,'type'=>$type]));

    	}

	

}
	
 ?>