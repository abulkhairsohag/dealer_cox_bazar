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

// getting information while pressing on edit button
if (isset($_POST['serial_no_edit'])) {
    $serial_no_edit = $_POST['serial_no_edit'];
    $query = "SELECT * FROM user where serial_no = '$serial_no_edit' ";
    $get_info = $dbOb->find($query);
    echo json_encode($get_info);
}

// inserting user iformation
if (isset($_POST['submit'])) {
    $name = validation($_POST['name']);
    $designation = validation($_POST['designation']);
    $mobile_no = validation($_POST['mobile_no']);
    $address = validation($_POST['address']);
    $email = validation($_POST['email']);
    $user_name = validation($_POST['user_name']);
    $password = validation($_POST['password']);
    $confirm_password = validation($_POST['confirm_password']);
    $edit_id = validation($_POST['edit_id']);

    if ($edit_id) {
        $query = "SELECT * FROM user WHERE serial_no = '$edit_id'";
        $get_login_info = $dbOb->find($query);

        $query = "UPDATE user
		set
		name = '$name',
		designation = '$designation',
		mobile_no = '$mobile_no',
		address = '$address',
		email = '$email',
		user_name = '$user_name',
		password = '$password'
		WHERE
		serial_no = '$edit_id'
		";
        $update = $dbOb->update($query);
        if ($update) {
            $x_name = $get_login_info['name'];
            $x_user_name = $get_login_info['user_name'];
            $query = "UPDATE login
			SET
			name = '$name',
			username = '$user_name',
			password = '$password',
			email = '$email',
			user_type = 'user'
			WHERE
			user_id = '$edit_id'
			";
            $update_login = $dbOb->update($query);
            if ($update_login) {
                $message = "Congratulations! Information Successfully Updated";
                $type = "success";
                echo json_encode(['type' => $type, 'message' => $message]);
            } else {
                $message = "Sorry! Information Is Not Updated.";
                $type = "warning";
                echo json_encode(['type' => $type, 'message' => $message]);
            }
        } else {
            $message = "Sorry! Information Is Not Updated.";
            $type = "warning";
            echo json_encode(['type' => $type, 'message' => $message]);
        }
    } else { // this time inserting data into the database

        $query = "INSERT INTO user (name,designation,mobile_no,address,email,user_name,password)
		VALUES
		('$name','$designation','$mobile_no','$address','$email','$user_name','$password')";
        $last_insert_id = $dbOb->custom_insert($query);

        if ($last_insert_id) {
            $query = "INSERT INTO login (name,username,password,email,user_id,user_type)
			VALUES ('$name','$user_name','$password','$email','$last_insert_id','user')";
            $insert_login = $dbOb->insert($query);
            if ($insert_login) {
                $message = "Congratulations! Information Successfully Saved";
                $type = "success";
                echo json_encode(['type' => $type, 'message' => $message]);
            } else {
                $message = "Sorry! Information Is Not Saved.";
                $type = "warning";
                echo json_encode(['type' => $type, 'message' => $message]);
            }

        } else {
            $message = "Sorry! Information Is Not Saved.";
            $type = "warning";
            echo json_encode(['type' => $type, 'message' => $message]);
        }

    }

}

// inserting role information of the user
if (isset($_POST['submit_role'])) {
    $role_serial_no = validation($_POST['role_name']);
    $user_serial_no = validation($_POST['user_serial_no']);
    $zone_serial_no = validation($_POST['zone_serial_no']);

    $query = "SELECT * FROM role WHERE serial_no = '$role_serial_no'";
    $get_role = $dbOb->find($query);
    $role_name = $get_role['role_name'];

    $query = "DELETE FROM user_has_role WHERE user_serial_no = '$user_serial_no' AND user_type = 'user'";
    $delete_role = $dbOb->delete($query);

    $query = "DELETE FROM user_zone_permission WHERE user_serial_no = '$user_serial_no'";
    $delete_zone_permission = $dbOb->delete($query);


    $query = "INSERT INTO user_has_role (role_serial_no,user_serial_no,user_type) VALUES ('$role_serial_no','$user_serial_no','user')";
    $insert_user_has_role = $dbOb->insert($query);
    if ($insert_user_has_role) {
        $query = "INSERT INTO user_zone_permission (user_serial_no,zone_serial_no) values ('$user_serial_no','$zone_serial_no')";
        $insert_zone_permission =$dbOb->insert($query);
        if ($insert_zone_permission) {
             $query = "UPDATE login
                SET
                role = '$role_name'
                WHERE
                user_id = '$user_serial_no' AND user_type = 'user'";
                $update_login = $dbOb->update($query);
                }
       
    }
    if ($update_login) {
        $message = "Congratulations! Role Is Successfully Saved.";
        $type = "success";
        echo json_encode(['message' => $message, 'type' => $type]);
    } else {
        $message = "Sorry! Role Is Not Saved.";
        $type = "warning";
        echo json_encode(['message' => $message, 'type' => $type]);

    }
}

// getting data table information
if (isset($_POST['sohag'])) {
     $query = "SELECT * FROM user ORDER BY serial_no DESC";
              $get_user = $dbOb->select($query);
              if ($get_user) {
                $i = 0;
                while ($row = $get_user->fetch_assoc()) {
                  $i++;
                  $user_serial_no = $row['serial_no'];
                    $query = "SELECT * FROM user_has_role WHERE user_serial_no = '$user_serial_no' AND user_type = 'user'";
                    $get_user_role = $dbOb->select($query);
                    if ($get_user_role) {
                      $user_and_role = $get_user_role->fetch_assoc();
                      $role_serial_no = $user_and_role['role_serial_no'];
                      $query = "SELECT * FROM role WHERE serial_no = '$role_serial_no'";
                      $get_role_info = $dbOb->select($query);
                      if ($get_role_info) {
                        $role_name = $get_role_info->fetch_assoc()['role_name'];
                        $role_badge_color = 'bg-blue';
                      }else{
                        $role_name = 'Not Assigned';
                        $role_badge_color = 'bg-red';
                      }
                    }else{
                      $role_name = 'Not Assigned';
                      $role_badge_color = 'bg-red';
                    }
                    // getting zone info 
                    $query = "SELECT * FROM user_zone_permission WHERE user_serial_no = '$user_serial_no' ";
                    $get_user_zone = $dbOb->select($query);
                    if ($get_user_zone) {
                      $user_and_zone = $get_user_zone->fetch_assoc();
                      $zone_serial_no = $user_and_zone['zone_serial_no'];
                      $query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
                      $zone = $dbOb->select($query);
                      if ($zone) {
                        $zone_name = $zone->fetch_assoc()['zone_name'];
                        $zone_badge_color = 'bg-blue';
                      }else{
                        $zone_name = 'Not Assigned';
                        $zone_badge_color = 'bg-red';
                      }
                    }else{
                      $zone_name = 'Not Assigned';
                      $zone_badge_color = 'bg-red';
                    }
                  ?>
                  <tr class="tbl_row"<?php echo $row['serial_no']; ?>>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation'] ?></td>
                    <td><?php echo $row['mobile_no'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['user_name'] ?></td>
                    <td><?php echo $row['password'] ?></td>
                    <td><span class="badge <?php echo $role_badge_color?>"><?php echo $role_name; ?></span></td>
                    <td><span class="badge <?php echo $zone_badge_color?>"><?php echo $zone_name; ?></span></td>
								
                    <td align="center">

                      <?php 
                      if (permission_check('user_edit_button')) {
                        ?>

                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                      <?php } ?>

                      <?php 
                      if (permission_check('user_delete_button')) {
                        ?> 

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                      <?php } ?>

                         

                        <a  class="badge bg-green  assign_role_button" id="<?php echo $row['serial_no'] ?>" data-toggle="modal" data-target="#assign_role_modal" style="margin:2px">Role</a>  
                    </td>
                  </tr>
                  <?php
                }
              }
}

// here we are going to delete data from the database
if (isset($_POST['delete_id'])) {

    $delete_id = $_POST['delete_id'];

    $query = "SELECT * FROM user WHERE serial_no = '$delete_id'";
    $get_login_info = $dbOb->find($query);
    $x_name = $get_login_info['name'];
    $x_user_name = $get_login_info['user_name'];

    $query = "DELETE FROM user WHERE serial_no = '$delete_id'";
    $delete_data = $dbOb->delete($query);

    if ($delete_data) {
        $query = "DELETE FROM login  WHERE name = '$x_name' AND username = '$x_user_name' AND user_type = 'user'";
        $delete_login = $dbOb->delete($query);
        if ($delete_login) {

            $query = "DELETE FROM user_has_role  WHERE user_serial_no = '$delete_id' AND user_type = 'user'";
            $delete_user_has_role = $dbOb->delete($query);

            $message = "Congratulations! Information Is Successfully Deleted.";
            $type = "success";
            echo json_encode(['message' => $message, 'type' => $type]);

        } else {
            $message = "Sorry! Information Is Not Deleted";
            $type = "warning";
            echo json_encode(['message' => $message, 'type' => $type]);

        }
    } else {
        $message = "Sorry! Information Is Not Deleted";
        $type = "warning";
        echo json_encode(['message' => $message, 'type' => $type]);

    }
}

?>