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
    $query = "SELECT * FROM offers where serial_no = '$serial_no_edit' ";
    $get_info = $dbOb->find($query);
    echo json_encode($get_info);
}

// inserting user iformation
if (isset($_POST['submit'])) {
    $products_id = validation($_POST['products_id']);
    $packet_qty = validation($_POST['packet_qty']);
    $product_qty = validation($_POST['product_qty']);
    $from_date = validation($_POST['from_date']);
    $to_date = validation($_POST['to_date']);
    $status = validation($_POST['status']);
    $edit_id = validation($_POST['edit_id']);
   if (strtotime($from_date) > strtotime($to_date)) {
        $message = "Offer Start Date Cannot Be Greater Than The End Date.";
        $type = "warning";
        die(json_encode(['message'=>$message,'type'=>$type]));

    }

    if ($edit_id) {
        $query = "SELECT * FROM offers WHERE serial_no <> '$edit_id'";
        $get_product = $dbOb->select($query);
        $existing = false;
        if ($get_product) {
            while ($row = $get_product->fetch_assoc()) {
                if ($row['products_id'] == $products_id ) {
                    $existing = true;
                }
            }
        }

        if ($existing) {
            $message = "Sorry! This Product Is Already Exists. Please Update That";
            $type = "warning";
            die(json_encode(['type' => $type, 'message' => $message]));

        }else{
            $query = "UPDATE offers
                    set
                    products_id ='$products_id',
                    packet_qty = '$packet_qty',
                    product_qty = '$product_qty',
                    from_date = '$from_date',
                    to_date = '$to_date',
                    status = '$status'
                    WHERE 
                    serial_no = '$edit_id'
                    ";
            $update = $dbOb->update($query);
            if ($update) {
                $message = "Congratulations! Information Successfully Updated";
                $type = "success";
                echo json_encode(['type' => $type, 'message' => $message]);

            } else {
                $message = "Sorry! Information Is Not Updated.";
                $type = "warning";
                echo json_encode(['type' => $type, 'message' => $message]);
            }

        }
        
    } else { // this time inserting data into the database
        $query = "SELECT * FROM offers WHERE products_id = '$products_id' AND status<>'1'";
        $get_product = $dbOb->select($query);

        if ($get_product) {
            $query = "DELETE FROM offers WHERE products_id = '$products_id'";
            $delete = $dbOb->delete($query);
        }

        $query = "SELECT * FROM offers WHERE products_id = '$products_id' AND status = '1'";
        $get_product = $dbOb->select($query);
        if ($get_product) {
            $message = "One Offer For This Product Is Already Going On. You Can Update It.";
            $type = "warning";
            die(json_encode(['message'=>$message,'type'=>$type]));
        }



        $query = "INSERT INTO offers (products_id,packet_qty,product_qty,from_date,to_date,status)
		VALUES
		('$products_id','$packet_qty','$product_qty','$from_date','$to_date','$status')";
        $insert = $dbOb->insert($query);

        if ($insert) {
           $message = "Congratulations! Information Successfully Saved";
           $type = "success";
           echo json_encode(['type' => $type, 'message' => $message]);


        } else {
            $message = "Sorry! Information Is Not Saved.";
            $type = "warning";
            echo json_encode(['type' => $type, 'message' => $message]);
        }

    }

}

// getting data table information
if (isset($_POST['sohag'])) {
$query = "SELECT * FROM offers ORDER BY serial_no DESC";
$get_offers = $dbOb->select($query);
if ($get_offers) {
    $i = 0;
    while ($row = $get_offers->fetch_assoc()) {
        $products_id = $row['products_id'];
        $query = "SELECT * FROM products WHERE products_id_no = '$products_id'";
        $get_prod_name = $dbOb->select($query);
        $products_name = '';
        if ($get_prod_name) {
            $products_name = $get_prod_name->fetch_assoc()['products_name'];
        }
        if ($row['status'] == 1) {
            $badge = " bg-green";
            $status = "Active";
        } else if ($row['status'] == 0) {
            $badge = " bg-red";
            $status = "Inactive";
        } else {
            $badge = " bg-orange";
            $status = "Expired";
        }
        $today = date('d-m-Y');
        $serial_no = $row['serial_no'];
        if (strtotime($row['to_date']) < strtotime($today)) {
            $query = "UPDATE offers set status = '3' where serial_no = '$serial_no'";
            $update = $dbOb->update($query);
            $badge = " bg-orange";
            $status = "Expired";

        }
        $i++;
        ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row['products_id'] ?></td>
                  <td><?php echo $products_name ?></td>
                  <td><?php echo $row['packet_qty'] ?></td>
                  <td><?php echo $row['product_qty']; ?></td>
                  <td><?php echo $row['from_date'] ?></td>
                  <td><?php echo $row['to_date'] ?></td>
                  <td> <span class="<?php echo $badge ?>"> <?php echo $status; ?> </span></td>
                  <td align="center">


                   <?php
if (permission_check('company_edit_button')) {
            ?>
                     <a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                     <?php
}

        ?>
                   <?php

        if (permission_check('company_delete_button')) {
            ?>
                     <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>

                     <?php
}

        ?>
                 </td>
               </tr>

               <?php
}
}
}

// here we are going to delete data from the database
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $query = "DELETE FROM offers WHERE serial_no = '$delete_id'";
    $delete_data = $dbOb->delete($query);

    if ($delete_data) {
        $message = "Congratulations! Information Is Successfully Deleted.";
        $type = "success";
        echo json_encode(['message' => $message, 'type' => $type]);
    } else {
        $message = "Sorry! Information Is Not Deleted";
        $type = "warning";
        echo json_encode(['message' => $message, 'type' => $type]);

    }
}

?>