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
	$query = "SELECT * FROM receive WHERE serial_no = '$serial_no_edit'";
	$get_receive = $dbOb->find($query);
	echo json_encode($get_receive);
}

// the following section is for inserting and updating data 
if (isset($_POST['submit'])) {

          $receive_type = validation($_POST['receive_type']);
          $client_name = validation($_POST['client_name']);
          $organization_name = validation($_POST['organization_name']);
          $address = validation($_POST['address']);
          $mobile_no = validation($_POST['mobile_no']);
          $invoice_docs_no = validation($_POST['invoice_docs_no']);
          $total_amount = validation($_POST['total_amount']);
         
		  $description = validation($_POST['description']);
		  $zone_serial_no = validation($_POST['zone_serial_no']);
		  $query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
		  $zone_name = validation($dbOb->find($query)['zone_name']);
		  $receive_date = validation($_POST['receive_date']);
          $edit_id = validation($_POST['edit_id']);

	if ($edit_id) {
		$query = "UPDATE receive 
				  SET 
					receive_type = '$receive_type',
					client_name = '$client_name',
					organization_name 	='$organization_name',
					address ='$address',
					mobile_no = '$mobile_no',
					invoice_docs_no = '$invoice_docs_no',
					total_amount = '$total_amount',
					
					description 	= '$description',
					zone_serial_no = '$zone_serial_no',
					zone_name = '$zone_name'
					
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
		$query = "INSERT INTO receive 
					(receive_type,client_name,organization_name,address,mobile_no,invoice_docs_no,total_amount,description,receive_date,zone_serial_no,zone_name)
				  VALUES 
				  	('$receive_type','$client_name','$organization_name','$address','$mobile_no','$invoice_docs_no','$total_amount','$description','$receive_date','$zone_serial_no','$zone_name')";
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
	$query = "DELETE FROM receive WHERE serial_no = '$serial_no_delete'";
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
      			if (Session::get("zone_serial_no")){
                  if (Session::get("zone_serial_no") != '-1') {
                    $zone_serial_no = Session::get("zone_serial_no");
                    $query = "SELECT * FROM receive WHERE zone_serial_no = '$zone_serial_no' ORDER BY serial_no DESC";
                  }
               }else{
                 $query = "SELECT * FROM receive ORDER BY serial_no DESC";
               }
              $get_receive = $dbOb->select($query);
              if ($get_receive) {
                $i=0;
                while ($row = $get_receive->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['receive_type']; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['organization_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['invoice_docs_no']; ?></td>
                    <td><?php echo $row['total_amount']; ?></td>
                    <td><?php echo $row['receive_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('receive_edit_button')) {
                        ?>
                         <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('receive_delete_button')) {
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