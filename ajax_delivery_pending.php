<?php
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once "class/Session.php";
Session::init();
Session::checkSession();
error_reporting(1);
include_once 'helper/helper.php';
?>


<?php

include_once "class/Database.php";
$dbOb = new Database();

// The following section is for deleting data

if (isset($_POST['serial_no_delete'])) {
	$serial_no = $_POST['serial_no_delete'];

	$query = "DELETE FROM new_order_details WHERE serial_no = '$serial_no'";
	$delete_order_details = $dbOb->delete($query);
	if ($delete_order_details) {
		$query = "DELETE FROM new_order_expense WHERE new_order_serial_no = '$serial_no'";
		$delete_order_expense = $dbOb->delete($query);
		if ($delete_order_expense) {
			$message = "Congratulations! Information Is Successfully Deleted.";
			$type = "success";
			echo json_encode(['message' => $message, 'type' => $type]);
		} else {
			$message = "Sorry! Information Is Not Deleted.";
			$type = "warning";
			echo json_encode(['message' => $message, 'type' => $type]);
		}
	} else {
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message' => $message, 'type' => $type]);
	}
}

// the following section is for fetching data from database
if (isset($_POST["sohag"])) {

	$query = "SELECT * FROM new_order_details
              where
              delivery_report = '0'
              and
              delivery_cancel_report ='0'
              ORDER BY area_employee ";

	$get_order_info = $dbOb->select($query);
	if ($get_order_info) {
		$i = 0;
		while ($row = $get_order_info->fetch_assoc()) {
			$i++;
			?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['employee_name']; ?></td>
        <td><?php echo $row['order_no']; ?></td>
        <td><?php echo $row['shop_name']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><?php echo $row['payable_amt']; ?></td>
        <td><?php echo $row['order_date']; ?></td>
        <td align="center">
        <?php
if (permission_check('delivery_pending_view_button')) {
				?>
                        <a class="badge  bg-blue view_data  " id="<?php echo ($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal">view </a>
                      <?php }?>

                      <?php
if (permission_check('delivery_pending_edit_button')) {
				?>
                        <a href="edit_new_order.php?serial_no=<?php echo urldecode($row['serial_no']); ?>" class="badge  bg-blue edit_data" >Edit </a>
                      <?php }?>


                        <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>


                      <?php
if (permission_check('delivery_pending_invoice_button')) {
				?>
                      <a href="invoice.php?serial_no=<?php echo urldecode($row['serial_no']); ?>" class="badge  bg-green " target="__blank" >Invoice </a>
                       <?php }?>

                      <?php
if (permission_check('delivery_pending_cancel_order_button')) {

				?>
                        <a  class="badge bg-orange cancel_order"  id="<?php echo ($row['serial_no']) ?>">  Cancel Order</a>
                      <?php }?>

                    </td>
                  </tr>

                  <?php
}
	}

}

?>