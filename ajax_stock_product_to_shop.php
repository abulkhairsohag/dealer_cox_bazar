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

	
	$ware_house_serial_no= validation($_POST['ware_house_serial_no']);
	$ware_house_name= '';
	$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
	$get_ware_house  = $dbOb->select($query);
	if ($get_ware_house) {
		$ware_house_name = validation($get_ware_house->fetch_assoc()['ware_house_name']);
	}


	$stock_date= validation($_POST['stock_date']);

	$product_id= validation($_POST['product_id']);
	$products_name = validation($_POST['products_name']);
	$category = validation($_POST['category']);
	$quantity_pack = validation($_POST['quantity']);
    $quantity_pcs = validation($_POST['quantity_pcs']);
	$pack_size = validation($_POST['pack_size']);
    $new_sell_price = validation($_POST['sell_price']);

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
            $pr_id = $product_id[$i];
            if ($quantity_pack[$i] > 0 || $quantity_pcs[$i] > 0) {

                if (array_key_exists($pr_id,$avaialble_products_id)) {
                    // die("sadfasfas");
                        $qty_pcs = $avaialble_products_id[$pr_id];
                        $query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
                        $product_info =  $dbOb->find($query);

                        $total_pcs = $quantity_pack[$i]*$pack_size[$i] + $quantity_pcs[$i]*1 ;

                        $price =    ($total_pcs/$pack_size[$i])*$product_info['company_price'];

                        $available_pcs = $qty_pcs +  $total_pcs;
                        
                       
                        $query ="UPDATE own_shop_products_stock SET quantity_pcs = '$available_pcs', sell_price = '$new_sell_price[$i]' WHERE products_id = '$pr_id'";
                        $update = $dbOb->update($query);
                        if ($update) {

                            $query = "INSERT INTO own_shop_stock_history 
                            (products_id,product_name,quantity_pcs,price,stock_date,ware_house_serial_no,ware_house_name)
                            VALUES
                            ('$product_id[$i]','$products_name[$i]','$total_pcs','$price','$stock_date','$ware_house_serial_no','$ware_house_name')";
                            $insert_history = $dbOb->insert($query);
                        }

                    }else{
                        // die("2121212dafsa");
                    $query = "SELECT * FROM products WHERE products_id_no = '$pr_id'";
                    $product_info =  $dbOb->find($query);

                    $total_pcs = $quantity_pack[$i]*$pack_size[$i] + $quantity_pcs[$i]*1 ;
                    $price =    $total_pcs/$pack_size[$i] *$product_info['company_price'];


                    $query = "INSERT INTO own_shop_products_stock 
                                        (products_id,product_name,category,quantity_pcs,sell_price)
                                        values
                                        ('$product_id[$i]','$products_name[$i]','$category[$i]','$total_pcs','$new_sell_price[$i]')";
                    $insert_stock = $dbOb->insert($query);

                    if ($insert_stock) {

                          $query = "INSERT INTO own_shop_stock_history 
                            (products_id,product_name,quantity_pcs,price,stock_date,ware_house_serial_no,ware_house_name)
                            VALUES
                            ('$product_id[$i]','$products_name[$i]','$total_pcs','$price','$stock_date','$ware_house_serial_no','$ware_house_name')";
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