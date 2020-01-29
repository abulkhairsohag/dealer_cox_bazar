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
	$area_name 		= validation($_POST['area_name']);
	$category_name 	= validation($_POST['category_name']);
	$cust_id 	= validation($_POST['cust_id']);
	$client_name 	= validation($_POST['client_name']);
	$organization_name = validation($_POST['organization_name']);
	$address 		= validation($_POST['address']);
	$mobile_no 		= validation($_POST['mobile_no']);
	$email 			= validation($_POST['email']);
	$description 	= validation($_POST['description']);
	$previous_dew 	= validation($_POST['previous_dew']);
	$dew_date 	    = validation($_POST['dew_date']);

	$edit_id 	= validation($_POST['edit_id']);

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
			$query = "INSERT INTO id_no_generator (id,id_type) VALUES ('$cust_id','client')";
			$insert_id = $dbOb->insert($query);

			if ($previous_dew > 0) {


                 $query = "SELECT * FROM order_delivery ORDER BY serial_no DESC LIMIT 1";
			     $get_order = $dbOb->select($query);
			     $today = date("Ymd");
			     if ($get_order) {
			      $last_id = $get_order->fetch_assoc()['order_no'];
			      $exploded_id = explode('-', $last_id);
			      $exploded_id = str_split($exploded_id[1],8);

			      if ($exploded_id[0] == $today) {
			        $last_id = $exploded_id[1] * 1 + 1;
			        $id_length = strlen($last_id);
			        $remaining_length = 4 - $id_length;
			        $zeros = "";

			        if ($remaining_length > 0) {
			          for ($i = 0; $i < $remaining_length; $i++) {
			            $zeros = $zeros . '0';
			          }
			          $order_new_id = 'INV-'.$exploded_id[0] . $zeros . $last_id;
			        }
			      }else {
			        $order_new_id = 'INV-'.$today."0001";
			      }
			    } else {
			      $order_new_id = 'INV-'.$today."0001";
				}
				
				$zone_serial_no = "";
				$query = "SELECT * FROM area_zone WHERE area_name = '$area_name'";
				$get_zone = $dbOb->select($query);
				if ($get_zone) {
					$zone_serial_no = validation($get_zone->fetch_assoc()['zone_serial_no']);
				}

				$zone_name = '';
				$ware_house_serial_no = '';
				$ware_house_name = '';
				$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
				$get_zone_info = $dbOb->select($query);
				if ($get_zone_info) {
					$zone = $get_zone_info->fetch_assoc();
					$zone_name = validation($zone['zone_name']);
					$ware_house_serial_no = $zone['ware_house_serial_no'];
					$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
					$get_ware_house = $dbOb->select($query);
					if ($get_ware_house) {
						$ware_house_name = validation($get_ware_house->fetch_assoc()['ware_house_name']);
					}
				}

				$query ="INSERT INTO order_delivery 
				(order_no,ware_house_serial_no,ware_house_name,zone_serial_no,zone_name,area,cust_id,customer_name,shop_name,address,mobile_no,payable_amt,pay,due,delivery_date,delivery_status,cancel_status,previous_due)
				VALUES 
				('$order_new_id','$ware_house_serial_no','$ware_house_name','$zone_serial_no','$zone_name','$area_name','$cust_id','$client_name','$organization_name','$address','$mobile_no','$previous_dew','0','$previous_dew','$dew_date','1','0','1')";
				$insert_dew = $dbOb->insert($query);
			}
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
	$serial_no_delete = validation($_POST['serial_no_delete']);
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