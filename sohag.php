<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

















<?php
include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['area'])) {



		$query = "SELECT * FROM new_order_details WHERE delivery_report <> '1' AND delivery_cancel_report <> '1' AND area_employee = '$area_name'";
		$get_order_info = $dbOb->select($query);

		$product = [];
		$order_numbers = [];

		if ($get_order_info) {
			$j = 0;
			while ($row = $get_order_info->fetch_assoc()) {
				$order_numbers[$j] = $row['order_no'];
				$j++;
				$serial_no_order  = $row['serial_no'];
				$query = "SELECT * FROM new_order_expense WHERE new_order_serial_no = '$serial_no_order'";

			    $order_expense = $dbOb->select($query);
			    if ($order_expense) {
			    	while ($res = $order_expense ->fetch_assoc()) {
			    		$product_id = $res['products_id_no'];
			    	if(array_key_exists($product_id, $product))
			    	{
			    		$product[$product_id] +=   (int)$res['quantity'];
			    	}else{

			    	$product[$product_id] = (int)$res['quantity'];
			    		}
			    	
			    	}
			    }

			}
		}else{

        }
        ?>


<div class="row" id="print_table">

    <div style="color:black" class="col-md-12">
        <span class="text-center">
            <h3><b><?php echo strtoupper($company_profile['organization_name']);?></b></h3>
            <h5><?php $company_profile['address'] ; ?></h5>
            <h5><?php $company_profile['email'].', '.$company_profile['mobile_no']?></h5>

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
                        <h5 style="margin:0px ; margin-top: -8px;">Area : <span><?php echo $area_name;?></span></span>
                        </h5>
                        <h5 style="margin:0px ; margin-top: -8px;">D/A ID :
                            <span><?php echo $employee_id?></span></span></span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Name :
                            <span><?php echo $employee_name; ?></span></span></span></h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Phone No :
                            <span><?php echo $employee_phone_no; ?></span></span></span></h5>
                    </td>
                    <td class="text-center">

                    </td>
                    <td class="text-right">
                        <h5 style="margin:0px ; margin-top: -8px;">Printing Date :
                            <span><?php echo $printing_date ; ?></span></span>
                        </h5>
                        <h5 style="margin:0px ; margin-top: -8px;">Time :
                            <span><?php echo $printing_time;?></span></span></span></h5>
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
		if ($product) {
			$i = 0;
			foreach ($product as $key => $value) {
				$i++;
				$query = "SELECT * FROM products WHERE products_id_no = '$key'";
				$get_product = $dbOb->find($query);
	
				$name = $get_product['products_name'];
				$category = $get_product['category'];
                $quantity = $value;
                ?>



            <tr style="color:black" align="left">
                <td><?php echo $i ;?></td>
                <td><?php echo $key ;?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $category; ?></td>
                <td><?php echo $quantity ;?></td>

            </tr>
            <?php		   
			}
			$found="yes";
		}else{
            ?>
            <tr>
                <td colspan="5" align="center" style="color:red">Order Not Found In This Area</td>
            </tr>
        </tbody>
    </table>

    <?php	} 

		$query = "SELECT * FROM new_order_details WHERE delivery_report <> '1' AND delivery_cancel_report <> '1' AND area_employee = '$area_name'";
        $get_order = $dbOb->select($query);
        ?>

    <table style="margin-top:50px;">
        <tr>
            <th scope="col">
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
		$j = 0;
		$total_amt = 0;
		if ($get_order) {
			while ($row = $get_order->fetch_assoc()) {
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
                    $total_amt += $row['payable_amt'];
            }
            ?>
            <tr style="color:red" class="bg-success">
                <td colspan="5" align="right">Total Amount</td>
                <td><?php echo $total_amt;?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <table class="table table-responsive" style="margin-top:52px">
        <tbody>
            <tr>
                <td class="text-center">
                    <h5>Authorized By</h5>
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

}
?>
















</body>
</html>