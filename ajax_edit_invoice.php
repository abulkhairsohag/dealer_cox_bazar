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

    $invoice_option     = $_POST['invoice_option'];
    $client_option      = $_POST['client_option'];
    $office_account_no  = $_POST['office_account_no'];
    $office_organization_name = $_POST['office_organization_name'];
    $office_bank_name   = $_POST['office_bank_name'];
    $office_branch_name = $_POST['office_branch_name'];
    $new_client_name    = $_POST['new_client_name'];
    $new_organization_name = $_POST['new_organization_name'];
    $new_address        = $_POST['new_address'];
    $new_phone_no       = $_POST['new_phone_no'];
    $net_total          = $_POST['net_total'];
    $vat                = $_POST['vat'];
    $vat_amount         = $_POST['vat_amount'];
    $discount           = $_POST['discount'];
    $discount_amount    = $_POST['discount_amount'];
    $grand_total        = $_POST['grand_total'];
    $pay                = $_POST['pay'];
    $x_paid_amount      = $_POST['x_paid_amount'];
    $due                = $_POST['due'];

    $service     = $_POST['service'];
    $description = $_POST['description'];
    $unit       = $_POST['unit'];
    $quantity    = $_POST['quantity'];
    $price       = $_POST['price'];
    $total       = $_POST['total'];

    $edit_id = $_POST['edit_id'];
    
    $payment_date = date("d-m-Y");

    if ($x_paid_amount != $pay) {
      $given_amount = $pay - $x_paid_amount ;
      if ($given_amount > 0) {
        $query = "INSERT INTO due_payment_invoice
           (invoice_serial_no, pay_amount, due, payment_date)
           VALUES
           ('$edit_id', '$given_amount', '$due', '$payment_date')" ;
        $add_payment = $dbOb->insert($query);
      }

    }

    
    $query = "DELETE FROM invoice_expense WHERE invoice_serial_no = '$edit_id'";
    $delete_exp = $dbOb->delete($query); 

    if ($delete_exp) {
      $query = "UPDATE invoice_details 
                SET
                invoice_option = '$invoice_option', 
                client_option = '$client_option', 
                office_account_no = '$office_account_no',
                office_organization_name = '$office_organization_name', 
                office_bank_name = '$office_bank_name', 
                office_branch_name = '$office_branch_name',
                new_client_name = '$new_client_name', 
                new_organization_name = '$new_organization_name', 
                new_address = '$new_address', 
                new_phone_no = '$new_phone_no', 
                net_total = '$net_total', 
                vat = '$vat', 
                vat_amount = '$vat_amount', 
                discount = '$discount', 
                discount_amount = '$discount_amount', 
                grand_total = '$grand_total', 
                pay = '$pay', 
                due = '$due'
                WHERE 
                serial_no = '$edit_id'";

      $update_invoice = $dbOb->update($query);

      if ($update_invoice) {
        $insert_invoice_expense = '';
        for ($i=0; $i < count($service); $i++) {
        $query = "INSERT INTO  invoice_expense
                (invoice_serial_no, service,  description,  unit,  quantity, price,  total)
                VALUES
                ('$edit_id', '$service[$i]', '$description[$i]', '$unit[$i]', '$quantity[$i]',  '$price[$i]', '$total[$i]') ";
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