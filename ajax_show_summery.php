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

include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['serial_no'])) {
	$serial_no = $_POST['serial_no'] ;
         
    $company_profile = '';
    $query = "SELECT * FROM profile";
    $get_profile = $dbOb->select($query);
    if ($get_profile) {
        $company_profile = $get_profile->fetch_assoc();
    }

    $query = "SELECT * FROM order_summery WHERE serial_no = '$serial_no'";
    $get_summery = $dbOb->select($query);
    if ($get_summery) {
        $summery = $get_summery->fetch_assoc();
        $deliv_emp_id = $summery['deliv_emp_id']; 
        $deliv_emp_phone = $summery['deliv_emp_phone']; 
        $deliv_emp_name = $summery['deliv_emp_name']; 
        $area = $summery['area']; 
        $summery_id = $summery['summery_id']; 
        $printing_date = $summery['printing_date']; 
        $printing_time = $summery['printing_time']; 
        $total_payable_amt = $summery['total_payable_amt']; 
    }
    ?>

<div class="row" id="print_table">

    <div style="color:black" class="col-md-12">
        <span class="text-center">
            <h3><b><?php echo strtoupper($company_profile['organization_name']);?></b></h3>
            <h5><?php echo $company_profile['address'] ; ?></h5>
            <h5><?php echo $company_profile['email'].', '.$company_profile['mobile_no']?></h5>

        </span>
        <div class="text-center">
            <h4
                style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;">
                <b>ORDER SUMMERY</b></h4>
        </div>
        <br>
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td class="text-left">
                    <h5 style="margin:0px ; margin-top: -8px;">Summery No : <span><?php echo $summery_id;?></span></span>
                        <h5 style="margin:0px ; margin-top: -8px;">Area : <span><?php echo $area;?></span></span>
                        </h5>
                        <h5 style="margin:0px ; margin-top: -8px;">D/A ID :
                            <span><?php echo $deliv_emp_id?></span></span></span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Name :
                            <span><?php echo $deliv_emp_name; ?></span></span></span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Phone No :
                            <span><?php echo $deliv_emp_phone; ?></span></span></span></h5>
                    </td>
                    <td class="text-center">

                    </td>
                    <td class="text-right">
                        <h5 style="margin:0px ; margin-top: -8px;">Printing Date :
                            <span><?php echo $printing_date ; ?></span></span>
                        </h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Time :
                            <span><?php echo $printing_time;?></span></span></span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Reprint Date: <span></span><?php echo date('d F, Y')?></span></h5>  
                            <h5 style="margin:0px ; margin-top: -8px;"> Time: <span></span><?php echo date('h:i:s A')?></span></h5>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <table class="table table-bordered table-responsive">
        <thead style="background:#4CAF50; color:white">
            <tr>
                <th scope="col">Serial No</th>
                <th scope="col">Product ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $query = "SELECT * FROM order_summery_product_info WHERE summery_serial_no = '$serial_no'";
            $product = $dbOb->select($query);
		if ($product) {
			$i = 0;
			while ($row = $product->fetch_assoc()) {
				$i++;
				
                ?>

            <tr style="color:black" align="left">
                <td><?php echo $i ;?></td>
                <td><?php echo $row['product_id'] ;?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['quantity'] ;?></td>

            </tr>
            <?php		   
			}
		}
            ?>

            <table style="margin-top:50px;">
                <tr>
                    <th scope="col" style="color:black">
                        <h2>ORDERS FOR THE FOLLOWING SHOPS</h2>
                    </th>

                </tr>
                </thead>

            </table>

            <table class="table table-bordered table-responsive">
                <thead style="background:#4CAF50; color:white">
                    <tr>
                        <th scope="col">Serial No</th>
                        <th scope="col">Order No</th>
                        <th scope="col">Shop Name</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Mobile No</th>
                        <th scope="col">Payable Amt (৳)</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

        $query = "SELECT * FROM order_summery_shop_info WHERE summery_serial_no = '$serial_no'";
        $get_shop_info = $dbOb->select($query);
		$j = 0;
		$total_amt = 0;
		if ($get_shop_info) {
			while ($row = $get_shop_info->fetch_assoc()) {
                $date = $row['order_date'];
                ?>
                    <tr style="color:black" align="left">
                        <td><?php echo ++$j ;?></td>
                        <td><?php echo $row['order_no'] ?></td>
                        <td><?php echo $row['shop_name']?></td>
                        <td><?php echo $row['customer_name']?></td>
                        <td><?php echo $row['mobile_no']?></td>
                        <td><?php echo $row['payable_amt']?></td>

                    </tr>
                    <?php
                    // $total_amt += $row['payable_amt'];
            }
            ?>
                    <tr style="color:red" class="bg-success">
                        <td colspan="5" align="right">Total Amount</td>
                        <td><?php echo  $total_payable_amt;?></td>
                    </tr>
                    <?php
        }
        ?>
                </tbody>
            </table>

            <table class="table table-responsive" style="margin-top:60px">
                <tbody>
                    <tr>
                        <td class="text-center">
                            <h5>Prepared By</h5>
                        </td>
                        <td class="text-center">
                            <h5>Authorized By</h5>
                        </td>
                        <td class="text-center">
                            <h5>Paid By</h5>
                        </td>
                        <td class="text-center">
                            <h5>Delivered By</h5>
                        </td>
                    </tr>

                </tbody>
            </table>

</div>
<div class="text-center">

<a class="text-light btn-success btn" onclick='printContent("print_table")' name="print" id="print_receipt">Print</a>
</div>

<?php
}
?>