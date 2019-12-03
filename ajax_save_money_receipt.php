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

include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['from_date'])) {
    
    $receipt_no = $_POST['receipt_no'];
    $from_date = strtotime($_POST['from_date']);
 	$from_date_show = $_POST['from_date'];
 	$to_date = strtotime($_POST['to_date']);
    $to_date_show = $_POST['to_date'];
     
    $employee_id  = $_POST['employee_id'];
    $emp_name  = $_POST['employee_name'];
    $printing_date  = $_POST['printing_date'];
    $printing_time  = $_POST['printing_time'];
    $in_word  = $_POST['in_word'];
    $total_pay  = $_POST['total_pay'];

    $order_no = '';
    $order_date = '';
    $shop_name = '';
    $area = '';
    $payment_date = '';
    $payment_amt = '';

    

     
    if ($total_pay > 0) {

            $query = "INSERT INTO money_receipt_main_tbl 
                    (receipt_no,from_date,to_date,printing_date,printing_time,employee_id,employee_name,total_amount,in_word) 
                    VALUES 
                    ('$receipt_no','$from_date_show','$to_date_show','$printing_date','$printing_time','$employee_id','$emp_name','$total_pay','$in_word')";
            $insert_main_id = $dbOb->custom_insert($query);

            // die(json_encode('sohag'));
            if ($insert_main_id) {
                $query = "SELECT * FROM delivered_order_payment_history WHERE delivery_emp_id = '$employee_id'";
                $get_payment = $dbOb->select($query);
                $i = 0 ;
                $total_pay = 0;
                if ($get_payment) {
                    while ($row = $get_payment->fetch_assoc()) {
                    if (strtotime($row['date']) >= $from_date && strtotime($row['date']) <= $to_date) {
                        $i++;
                        $deliv_serial_no = $row['deliver_order_serial_no'];
                        $query = "SELECT * FROM order_delivery WHERE serial_no = '$deliv_serial_no'";
                        $get_deliv = $dbOb->select($query);
                        if ($get_deliv) {
                            $deliv_info = $get_deliv->fetch_assoc();
                            $order_no = $deliv_info['order_no'];
                            $order_date = $deliv_info['order_date'];
                            $shop_name = $deliv_info['shop_name'];
                            $area = $deliv_info['area'];
                        }
                        $payment_date = $row['date'];
                        $payment_amt = $row['pay_amt'];
                        $query = "INSERT INTO money_receipt_info_tbl 
                                (receipt_tbl_serial_no,order_no,order_date,shop_name,area,payment_date,payment_amt)
                                VALUES
                                ('$insert_main_id','$order_no','$order_date','$shop_name','$area','$payment_date','$payment_amt')";
                        $insert_info = $dbOb->insert($query);
                        
                        
                    }
                    }
            
                }
                
            }
        }

    }

    if ($insert_info) {
        # code...
        echo json_encode('inserted');
        exit();
    }

     



 ?>