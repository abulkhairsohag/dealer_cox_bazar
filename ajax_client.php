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

if (isset($_POST['serial_no_edit'])) {
	$serial_no_edit = $_POST['serial_no_edit'];
	$query = "SELECT * FROM client WHERE serial_no = '$serial_no_edit'";
	$get_client = $dbOb->find($query);
	echo json_encode($get_client);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {
	$area_name 		= $_POST['area_name'];
	$category_name 	= $_POST['category_name'];
	$cust_id 	= $_POST['cust_id'];
	$client_name 	= $_POST['client_name'];
	$organization_name = $_POST['organization_name'];
	$address 		= $_POST['address'];
	$mobile_no 		= $_POST['mobile_no'];
	$email 			= $_POST['email'];
	$description 	= $_POST['description'];
	$edit_id 	= $_POST['edit_id'];

	if ($edit_id) {
		$query = "UPDATE client 
				  SET 
					area_name 		= '$area_name',
					category_name 	= '$category_name',
					client_name 	='$client_name',
					organization_name ='$organization_name',
					address 		= '$address',
					mobile_no 		= '$mobile_no',
					email 			= '$email',
					description 	= '$description'
					
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
		$query = "INSERT INTO client 
					(area_name,category_name,cust_id,client_name,organization_name,address,mobile_no,email,description)
				  VALUES 
				  	('$area_name','$category_name','$cust_id','$client_name','$organization_name','$address','$mobile_no','$email','$description')";
		$insert = $dbOb->insert($query);
		if ($insert) {
			$message = "Congratulaitons! Information Is Successfully Saved.";
			$type = 'success';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}else{
			$message = "Sorry! Information Is Not Saved.";
			$type = 'warning';
			echo json_encode(['message'=>$message,'type'=>$type]);
		}
	}

}
// the following block of code is for deleting data 
if (isset($_POST['serial_no_delete'])) {
	$serial_no_delete = $_POST['serial_no_delete'];
	$query = "DELETE FROM client WHERE serial_no = '$serial_no_delete'";
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
              $query = "SELECT * FROM client ORDER BY serial_no DESC";
              $get_client = $dbOb->select($query);
              if ($get_client) {
                $i=0;
                while ($row = $get_client->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['cust_id']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['organization_name']; ?></td>
					<td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['area_name']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('customer_view_button')) {
                        ?>

                        <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 
                        <?php
                      }
                      ?>

                      <?php 
                      if (permission_check('customer_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                        <?php
                      }
                      ?>
                      <?php 
                      if (permission_check('customer_delete_button')) {
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