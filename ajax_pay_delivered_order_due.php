<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
 

include_once('class/Database.php');
$dbOb = new Database();


	if (isset($_POST['deliv_order_serial_no'])) {
        $serial_no = $_POST['deliv_order_serial_no'];
        $query = "SELECT * FROM order_delivery WHERE serial_no = '$serial_no'";
        $get_order = $dbOb->select($query);

        if ($get_order) {
            $due = $get_order->fetch_assoc()['due'];
        }
        die(json_encode($due));
    }

    if (isset($_POST['submit'])) {
        $deliver_order_serial_no = $_POST['deliver_order_serial_no'];
        $current_due = $_POST['current_due'];
        $pay_amt = $_POST['pay_amt'];
        $employee_id = $_POST['employee_id'];
        $pay_date = $_POST['pay_date'];
        // $message=$deliver_order_serial_no;
        // die(json_encode(['message'=>$message]));

        // die($deliver_order_serial_no);


        $query = "SELECT * FROM order_delivery WHERE serial_no = '$deliver_order_serial_no'";
        $get_order_info = $dbOb->select($query);
        if ($get_order_info) {
            $order_info = $get_order_info->fetch_assoc();
        }

        $new_pay = $order_info['pay']*1 + $pay_amt*1;
        
        $query = "INSERT INTO delivered_order_payment_history 
                  (deliver_order_serial_no,delivery_emp_id,pay_amt,date) 
                  VALUES
                  ('$deliver_order_serial_no','$employee_id','$pay_amt','$pay_date')";
        $insert_expense = $dbOb->insert($query);

        if ($insert_expense) {
            $query = "UPDATE order_delivery SET pay = '$new_pay', due = '$current_due' WHERE serial_no = '$deliver_order_serial_no'";
            $update_order = $dbOb->update($query);
            if ($update_order) {
                $message = "Payment Received Successfully";
                $type = "success";
            }else{
                $message = "Payment inserted But Order Not Updated";
                $type = "warning";
            }
        }else{
            $message = "Sorry! Payment Not Received";
            $type = "warning";
        }

        die(json_encode(['message'=>$message,'type'=>$type]));

    }



    

// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
          
    $query = "SELECT * FROM order_delivery where due > 0  ORDER BY serial_no DESC ";

              $get_order_info = $dbOb->select($query);
              if ($get_order_info) {
                $i=0;
                while ($row = $get_order_info->fetch_assoc()) {
                  $i++;

                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $row['shop_name']; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['area']; ?></td>
                    <td><?php echo $row['ware_house_name']; ?></td>
                    <td><?php echo $row['payable_amt']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['due']; ?></td>
                    <td><?php echo $row['delivery_date']; ?></td>
                    <td align="center">


                      <a class="badge  bg-blue view_data  " id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal">view </a>
                      
                          
                      <?php 
                      if (permission_check('unpaid_but_delivered_pay_button')) {
                        ?>

                        <a class="badge  bg-green pay " id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#pay_modal">Pay </a>
                        <?php 
                      }
                       ?>
                    </td>
                  </tr>

                  <?php
                }
              }
   
}

 ?>