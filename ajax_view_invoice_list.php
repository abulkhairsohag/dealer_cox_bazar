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


// The following section is for showing data 
if (isset($_POST['serial_no_view'])) {
	$serial_no = $_POST['serial_no_view'];

	$query_details = "SELECT * FROM invoice_details WHERE serial_no = '$serial_no' ORDER BY serial_no DESC";
	$query_expense = "SELECT * FROM invoice_expense WHERE invoice_serial_no = '$serial_no'";

	$invoice_details = $dbOb->find($query_details);
	$invoice_expense = $dbOb->select($query_expense);
	$tr = '' ;
	if ($invoice_expense) {
		$i = 0;
		while ($row = $invoice_expense->fetch_assoc()) {
			$i++;
			$tr .='<tr><td>';
			$tr .= $i;
			$tr .= '</td><td>';
			$tr .= $row["description"] ;
			$tr .= '</td><td>';
			$tr .= $row["purpose"];
			$tr .= '</td><td>';
			$tr .= $row["amount"] ;
			$tr .= '</td></tr>';
		}

		$tr .= '<tr><td colspan="3" style="text-align: right;">Net Total (৳)  </td><td colspan="" >';
		$tr .= number_format($invoice_details['pay'],2);

		$tr .= '</td></tr>';
	}

	echo json_encode(['details'=>$invoice_details,'expense'=>$tr]);
}

// The following section is for deleting data 


if (isset($_POST['serial_no_delete'])) {
	$serial_no = $_POST['serial_no_delete'];

	$query = "DELETE FROM invoice_details WHERE serial_no = '$serial_no'";
	$delete_invoice_details = $dbOb->delete($query);
	if ($delete_invoice_details) {
		$query = "DELETE FROM invoice_expense WHERE invoice_serial_no = '$serial_no'";
		$delete_invoice_exp = $dbOb->delete($query);
		if ($delete_invoice_exp) {
			$message = "Congratulations! Information Is Successfully Deleted.";
			$type = "success";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Deleted.";
			$type = "warning";
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}else{
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message'=>$message,'type'=>$type]);
	}
}



// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
   $query = "SELECT * FROM invoice_details ORDER BY serial_no DESC";
              $get_invoice = $dbOb->select($query);
              if ($get_invoice) {
                $i=0;
                while ($row = $get_invoice->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php if ($row['invoice_option'] == 'Sell Invoice') {
                      echo '<span class="badge bg-green">Income</span>';
                    }else{
                      echo '<span class="badge bg-orange">Expense</span>';
                    } ?></td>
                    
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['phone_no']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['invoice_date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('invoice_view_button')) {
                        ?>

                        <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 

                      <?php } ?>

                      <?php 
                      if (permission_check('invoice_edit_button')) {
                        ?>

                        <a href="edit_invoice.php?serial_no=<?php echo urldecode($row['serial_no']);?>" class="badge bg-blue edit_data"  > Edit</a>
                      <?php } ?>

                      <?php 
                      if (permission_check('invoice_delete_button')) {
                        ?>

                         <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 

                        
                      <?php } ?>    
                    </td>
                  </tr>

                  <?php
                }
              }
             
}

?>