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

if (isset($_POST['serial_no_edit'])) {
	$serial_no_edit = $_POST['serial_no_edit'];
	$query = "SELECT * FROM own_shop_client WHERE serial_no = '$serial_no_edit'";
	$get_client = $dbOb->find($query);
	echo json_encode($get_client);
}


// inserting role information of the user
if (isset($_POST['submit'])) {
	$add_customer_name = validation($_POST['add_customer_name']);
	$add_customer_address = validation($_POST['add_customer_address']);
	$add_customer_mobile_no = validation($_POST['add_customer_mobile_no']);
	$add_customer_email = validation($_POST['add_customer_email']);
	$edit_id 	= validation($_POST['edit_id']);

		if ($edit_id) {
		$query = "UPDATE own_shop_client 
				  SET 
					client_name 	='$add_customer_name',
					address 		= '$add_customer_address',
					mobile_no 		= '$add_customer_mobile_no',
					email 			= '$add_customer_email'
					
				  WHERE
					serial_no = '$edit_id' ";

		$update = $dbOb->update($query);
		if ($update) {
			$message = "Congratulaitons! Information Is Successfully Updated.";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Updated.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);

		}
	}else{

	$query = "INSERT INTO own_shop_client (client_name,address,mobile_no,email) VALUES ('$add_customer_name','$add_customer_address','$add_customer_mobile_no','$add_customer_email')";
	$insert_customer = $dbOb->insert($query);

	if ($insert_customer) {
		$message = "Congratulations! Customer Is Successfully Insert.";
		$type = "success";
		echo json_encode(['message'=>$message,'type'=>$type]);
	}else{
		$message = "Sorry! Customer Is Not Insert.";
		$type = "warning";
		echo json_encode(['message'=>$message,'type'=>$type]);

	}

	
}
}

// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM own_shop_client WHERE serial_no = '$serial_no_delete'";
	$delete = $dbOb->delete($query);
	if ($delete) {
		$message = "Congratulaitons! Information Is Successfully Deleted.";
		$type = "success";
		echo json_encode(['message'=>$message, 'type'=>$type]);
	}else{
		$message = "Sorry! Information Is Not Deleted.";
		$type = "warning";
		echo json_encode(['message'=>$message, 'type'=>$type]);

	}
}





// the following section is for fetching data from database 
if (isset($_POST["sohag"])) {
              $query = "SELECT * FROM own_shop_client ORDER BY serial_no DESC";
              $get_client = $dbOb->select($query);
              if ($get_client) {
                $i=0;
                while ($row = $get_client->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td align="center">


                      <?php 

                      if (permission_check('client_update')) {
                        ?>

                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_customer_modal" style="margin:2px">Edit</a> 
                        <?php
                      }
                      ?>


                      <?php 

                      if (permission_check('client_delete')) {
                        ?> 

                         <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
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
