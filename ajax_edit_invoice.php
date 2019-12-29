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
include_once("class/Session.php");
Session::init();
include_once("class/Database.php");
$dbOb = new Database();

  if (isset($_POST['submit'])) {

    $invoice_option = validation($_POST['invoice_option']);
    $name = validation($_POST['name']);
    $designation = validation($_POST['designation']);
    $phone_no = validation($_POST['phone_no']);
    $description = validation($_POST['description']);
    $purpose = validation($_POST['purpose']);
    $amount = validation($_POST['amount']);
    $total_amount = validation($_POST['net_total']);
    $pay = validation($_POST['net_total']);
    $invoice_date = validation($_POST['invoice_date']);


    $edit_id = validation($_POST['edit_id']);
    
    // $payment_date = date("d-m-Y");



    
    $query = "DELETE FROM invoice_expense WHERE invoice_serial_no = '$edit_id'";
    $delete_exp = $dbOb->delete($query); 

    if ($delete_exp) {
      $query = "UPDATE invoice_details 
                SET
                invoice_option = '$invoice_option', 
                name = '$name', 
                designation = '$designation',
                phone_no = '$phone_no', 
                total_amount = '$total_amount', 
                pay = '$pay',
                invoice_date = '$invoice_date'
                WHERE 
                serial_no = '$edit_id'";

      $update_invoice = $dbOb->update($query);

      if ($update_invoice) {
        $insert_invoice_expense = '';
       for ($i = 0; $i < count($purpose); $i++) {
            $query = "INSERT INTO  invoice_expense
                  (invoice_serial_no,description,	purpose,amount)
                  VALUES
                  ('$edit_id','$description[$i]',	'$purpose[$i]','$amount[$i]')";
            $insert_invoice_expense = $dbOb->insert($query);
        }

        if ($insert_invoice_expense) {
          $message = "Congratulations! Informaiton Is Successfully Updated.";
          $type = "success";
          Session::set("update_message",$message);
          Session::set("update_type",$type);
          echo json_encode(['message'=>$message,'type'=>$type]);
        }else{
          $message = "Sorry! Informaiton Is Not Updated.";
          $type = "warning";
          echo json_encode(['message'=>$message,'type'=>$type]);
        }
      } // end if if($update_invoice)

    } // end of if($delete_exp)

 } // end of  if (isset($_POST['submit']))
 ?>