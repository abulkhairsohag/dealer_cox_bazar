<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');

include_once("class/Database.php");
$dbOb = new Database();
$employee_name = Session::get("name");
$user_name = Session::get("username");
$password = Session::get("password");

$query = "SELECT * FROM employee_main_info where name = '$employee_name' and user_name = '$user_name' and password = '$password' ";
$get_employee_iformation = $dbOb->find($query);
$get_employee_id = $get_employee_iformation['id_no'];

$query = "SELECT * from delivery_employee where id_no = '$get_employee_id'";
$get_delivery_employee = $dbOb->find($query);
$delivery_employee_area = $get_delivery_employee['area'];
$company = $get_delivery_employee['company'];




if (isset($_POST['products_id_no_get_info'])) {
	$products_id_no = $_POST['products_id_no_get_info'];

	

	$query = "SELECT * FROM products WHERE company = '$company' AND products_id_no = '$products_id_no'";
	$get_products = $dbOb->find($query);
	$today = date("d-m-Y");
	$offer = "";

	if (strtotime($get_products['offer_start_date']) <= strtotime($today) && strtotime($get_products['offer_end_date'])>=strtotime($today) ) {
		$offer = $get_products['promo_offer'];
	}else{
		$offer = "----";
	}
	echo json_encode(['products'=>$get_products,'offer'=>$offer]);
}

// now we are going to add information 

	// now we are going to add data into database

	 if (isset($_POST['submit'])) {

            $employee_id       = $_POST['employee_id'];
            $employee_name     = $_POST['employee_name'];
            $area_employee     = $_POST['area_employee'];
            $employee_company  = $_POST['employee_company'];

            $order_no  = $_POST['order_no'];
            $shop_name = $_POST['shop_name'];
            $address   = $_POST['address'];
            $mobile_no = $_POST['mobile_no'];

            $products_id_no  = $_POST['products_id_no'];
            $products_name	 = $_POST['products_name'];
            $category        = $_POST['category'];
            $quantity        = $_POST['quantity'];

            $sell_price   = $_POST['sell_price'];
            $mrp_price    = $_POST['mrp_price'];
            $total_price  = $_POST['total_price'];
            $promo_offer  = $_POST['promo_offer'];


            $net_total        = $_POST['net_total'];
            $vat              = $_POST['vat'];
            $vat_amount       = $_POST['vat_amount'];
            $discount         = $_POST['discount'];
            $discount_amount  = $_POST['discount_amount'];
            $grand_total      = $_POST['grand_total'];
            $pay              = $_POST['pay'];
            $due              = $_POST['due'];
            $order_date       = date("d-m-Y");

            
			$query = "INSERT INTO  new_order_details

			(employee_id,employee_name,area_employee,company,order_no,shop_name,address,mobile_no,net_total,vat,vat_amount,discount,discount_amount,grand_total,pay,due,order_date,delivery_report)

			VALUES

			('$employee_id','$employee_name','$area_employee','$employee_company','$order_no','$shop_name','$address','$mobile_no','$net_total','$vat','$vat_amount','$discount','$discount_amount','$grand_total','$pay','$due','$order_date','0')";

			$last_id =$dbOb->custom_insert($query);
			$insert_order_expense = '';


			if ($last_id) {
				for ($i=0; $i < count($products_id_no); $i++) {
					$query = "INSERT INTO  new_order_expense
					(new_order_serial_no,	products_id_no,	products_name,	category,quantity,	sell_price,	mrp_price,total_price,promo_offer)
					VALUES
					('$last_id','$products_id_no[$i]','$products_name[$i]','$category[$i]','$quantity[$i]','$sell_price[$i]','$mrp_price[$i]','$total_price[$i]','$promo_offer[$i]')";
					$insert_order_expense =$dbOb->insert($query);


				}


				if ($insert_order_expense) {
						$message = "Congratulaiton! Order Is Successfully Saved.";
						$type = "success";
						echo json_encode(['message'=>$message,'type'=>$type]);
					}else{
						$message = "Sorry! Order Is Not Saved.";
						$type = "warning";
						echo json_encode(['message'=>$message,'type'=>$type]);

					}
			} else{
						$message = "Sorry! Information Is Not Saved.";
						$type = "warning";
						echo json_encode(['message'=>$message,'type'=>$type]);

			}



	      } // end of  if (isset($_POST['submit']))

 ?>