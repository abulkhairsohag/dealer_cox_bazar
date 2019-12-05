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
include_once 'class/Database.php';
$dbOb = new Database();

// fetching data from the table of the database and showing them
if (isset($_POST['serial_no_edit'])) {
    $serial_no_edit = $_POST['serial_no_edit'];
    $query = "SELECT * FROM client_category WHERE serial_no = '$serial_no_edit'";
    $get_category = $dbOb->find($query);
    echo json_encode($get_category);
}

// adding or Updating the table
if (isset($_POST['submit'])) {
    $category_name = $_POST['category_name'];
    $edit_id = $_POST['edit_id'];

    if ($edit_id) {

        $query = "SELECT * FROM client_category WHERE serial_no <> '$edit_id'";
        $get_category_info = $dbOb->select($query);

        $confirmation_edit = true;
        if ($get_category_info) {
            while ($row = $get_category_info->fetch_assoc()) {
                if ($row['category_name'] == $category_name) {
                    $confirmation_edit = false;
                    break;
                }
            }

        }

        if ($confirmation_edit) {

            $query = "UPDATE client_category
			SET
			category_name='$category_name'
			WHERE
			serial_no = '$edit_id'";
            $update = $dbOb->update($query);
            if ($update) {
                $message = 'Congratulations! Information Successfully Updated.';
                $type = 'success';
                echo json_encode(['message' => $message, 'type' => $type]);
            } else {
                $message = 'Sorry! Information Is Not Updated.';
                $type = 'warning';
                echo json_encode(['message' => $message, 'type' => $type]);

            }

        } else {
            $message = 'Sorry! Category Is Not Updated.The Category Name Already Exist.';
            $type = 'warning';
            echo json_encode(['message' => $message, 'type' => $type]);

        }
    } else { // inserting data into database
        $query = "SELECT * FROM client_category WHERE category_name = '$category_name'";
        $get_category = $dbOb->find($query);
        $get_category_name = $get_category['category_name'];

        $confirmation = true;
        if ($get_category_name) {
            $confirmation = false;
        }

        if ($confirmation) {
            $query = "INSERT INTO client_category (category_name)
			values
			('$category_name')";
            $insert = $dbOb->insert($query);
            if ($insert) {
                $message = 'Congratulations! Information Successfully Saved.';
                $type = 'success';
                echo json_encode(['message' => $message, 'type' => $type]);

            } else {
                $message = 'Sorry! Information Is Not Saved.';
                $type = 'warning';
                echo json_encode(['message' => $message, 'type' => $type]);

            }
        } else {
            $message = 'Sorry! Category Is Not Added.The Category Name Already Exist.';
            $type = 'warning';
            echo json_encode(['message' => $message, 'type' => $type]);

        }
    }
}

// showing information from the database
if (isset($_POST['sohag'])) {

    $query = "SELECT * FROM client_category ORDER BY serial_no DESC";
    $get_category = $dbOb->select($query);
    if ($get_category) {
        $i = 0;
        while ($row = $get_category->fetch_assoc()) {
            $i++;
            ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['category_name']; ?></td>
				<td align="center">

					<?php
if (permission_check('customer_category_edit_button')) {
                ?>
						<a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"  data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
					<?php }?>

					<?php
if (permission_check('customer_category_delete_button')) {
                ?>

						<a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>
					<?php }?>
				</td>
			</tr>

			<?php
}
    }
}

// deleting data from the table using one delete id
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $query = "DELETE FROM client_category WHERE serial_no = '$delete_id'";
    $delete = $dbOb->delete($query);
    if ($delete) {
        $message = "Congratulations! Information Successfully Deleted";
        $type = "success";
        echo json_encode(['type' => $type, 'message' => $message]);
    } else {
        $message = "Sorry! Information Is Not Deleted";
        $type = "warning";
        echo json_encode(['type' => $type, 'message' => $message]);

    }
}
?>