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

if (isset($_POST['order_no'])) {
    $order_no = validation($_POST['order_no']) ;
    $query = "SELECT * FROM order_summery_shop_info WHERE order_no = '$order_no'";
    $get_summery  =  $dbOb->select($query);
    if ($get_summery) {
        $summery_confirmation = 'yes';
    }else{
        $summery_confirmation = 'no';
    }
    
    die(json_encode($summery_confirmation));
}

 ?>