<?php
include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['area'])) {
    
    
  

    $query = "SELECT * FROM order_summery ORDER BY serial_no DESC LIMIT 1";
$get_summery = $dbOb->select($query);
    if ($get_summery) {
  $today = date("Ymd");
    $last_id = $get_summery->fetch_assoc()['summery_id'];
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
      $summery_new_id = 'SUM-'.$exploded_id[0] . $zeros . $last_id;
    }
  }else {
    $summery_new_id = 'SUM-'.$today."0001";
  }
}

	$area_name = $_POST['area'];
	$employee_id = $_POST['employee_id'];
	$employee_name = $_POST['employee_name'];
	$employee_phone_no = $_POST['employee_phone_no'];

	$print_table = 'print_table';
	$printing_date = date('d F, Y');
	$printing_time = date('h:i:s A');

	$company_profile = '';
	$query = "SELECT * FROM profile";
	$get_profile = $dbOb->select($query);
	if ($get_profile) {
		$company_profile = $get_profile->fetch_assoc();
		// die('sohag');
	}


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

<div class="form-group bg-success" style="padding-bottom: 5px;margin-top: 30px">
    <div class="col-md-6 control-label" for="inputDefault" style="text-align: left; color: #34495E;font-size: 20px">
        Summery Information.....
    </div>
</div>
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
                        <h5 style="margin:0px ; margin-top: -8px;">Summery No : <span><?php echo $summery_new_id;?></span></span>
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

</div>';



<!-- //--------------------------------------------------->
<!-- form for storing data  -->
<!-- --------------------------------------------------->
<div align="center">
    <form method="post" action="" id="summery_form">
        <div style="display:none">
        <div class="row text-center my-5" style="margin-bottom:20px">
            <h2>Summery Main Table Info</h2>
        </div>
        <div class="row">
            <div class="col-md-3 from-group">
                <label>Delivery Employee Id</label>
                <input class="form-control" type="text" readonly name="deliv_emp_id" id="deliv_emp_id"
                    value="<?php echo $employee_id; ?>" />
            </div>
            <div class="col-md-3 from-group">
                <label>Delivery Employee Name</label>
                <input class="form-control" type="text" readonly name="deliv_emp_name" id="deliv_emp_name"
                    value="<?php echo $employee_name ;?>" />
            </div>
            <div class="col-md-3 from-group">
                <label>Delivery Employee phone</label>
                <input class="form-control" type="text" readonly name="deliv_emp_phone" id="deliv_emp_phone"
                    value="<?php echo $employee_phone_no?>" />
            </div>
            <div class="col-md-3 from-group">
                <label>Area</label>
                <input class="form-control" type="text" readonly name="area" id="area"
                    value="<?php echo $area_name; ?>" />
            </div>
            <div class="col-md-3 from-group">
                <label>Summery No</label>
                <input class="form-control" type="text" readonly name="summery_id" id="summery_id"
                    value="<?php echo $summery_new_id; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 from-group">
                <label>Printing Date</label>
                <input class="form-control" type="text" readonly name="printing_date" id="printing_date"
                    value="<?php echo $printing_date;?>" />
            </div>
            <div class="col-md-6 from-group">
                <label>Time</label>
                <input class="form-control" type="text" readonly name="time" id="time" value="<?php echo $printing_time;?>" />
            </div>
        </div>
        <div class="row text-center my-5" style="margin-top:20px">
            <h2>Summery Product Info</h2>
        </div>
        <div class="row">
            <div class="col-md-3 from-group">
                <label>Product ID</label>
            </div>
            <div class="col-md-3 from-group">
                <label>Product Name</label>
            </div>
            <div class="col-md-3 from-group">
                <label>Category</label>
            </div>
            <div class="col-md-3 from-group">
                <label>Quantity</label>
            </div>
        </div>

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
        <div class="row">
            <div class="col-md-3 from-group">
                <input class="form-control" type="text" readonly name="product_id[]" id="product_id[]"
                    value="<?php echo $key;?>" />
            </div>
            <div class="col-md-3 from-group">
                <input class="form-control" type="text" readonly name="product_name[]" id="product_name[]"
                    value="<?php echo $name?>" />
            </div>
            <div class="col-md-3 from-group">
                <input class="form-control" type="text" readonly name="category[]" id="category[]"
                    value="<?php echo $category ;?>" />
            </div>
            <div class="col-md-3 from-group">
                <input class="form-control" type="text" readonly name="quantity[]" id="quantity[]"
                    value="<?php echo $quantity; ?>" />
            </div>
        </div>
        <?php
							   
					}
                }
                ?>

        <div class="row text-center my-5" style="margin-top:20px">
            <h2>Summery Shop Info</h2>
        </div>
        <div class="row">
            <div class="col-md-3 from-group">
                <label>Order No</label>
            </div>
            <div class="col-md-2 from-group">
                <label>Shop Name</label>
            </div>
            <div class="col-md-2 from-group">
                <label>Customer Name</label>
            </div>
            <div class="col-md-3 from-group">
                <label>Mobile No</label>
            </div>
            <div class="col-md-2 from-group">
                <label>Payable</label>
            </div>
        </div>

        <?php
		$query = "SELECT * FROM new_order_details WHERE delivery_report <> '1' AND delivery_cancel_report <> '1' AND area_employee = '$area_name'";
		$get_order = $dbOb->select($query);

		$j = 0;
		$total_amt = 0;
		if ($get_order) {
			while ($row = $get_order->fetch_assoc()) {
				$date = $row['order_date'];
		?>
        <div class="row">
            <div class="col-md-3 from-group">
                <input class="form-control" type="text" readonly name="order_no[]" id="order_no[]"
                    value="<?php echo $row['order_no']?>" />
            </div>
            <div class="col-md-2 from-group">
                <input class="form-control" type="text" readonly name="shop_name[]" id="shop_name[]"
                    value="<?php echo $row['shop_name'];?>" />
            </div>
            <div class="col-md-2 from-group">
                <input class="form-control" type="text" readonly name="customer_name[]" id="customer_name[]"
                    value="<?php echo $row['customer_name'];?>" />
            </div>
            <div class="col-md-3 from-group">
                <input class="form-control" type="text" readonly name="mobile_no[]" id="mobile_no[]"
                    value="<?php echo $row['mobile_no'];?>" />
            </div>
            <div class="col-md-2 from-group">
                <input class="form-control" type="text" readonly name="payable_amt[]" id="payable_amt[]"
                    value="<?php echo $row['payable_amt'];?>" />
            </div>
        </div>
        <?php
					$total_amt += $row['payable_amt'];
            }
            ?>
        <div class="row">

            <div class="col-md-10 from-group">
            </div>

            <div class="col-md-2 from-group">
                <label>Total Payable</label>
                <input class="form-control" type="text" readonly name="total_payable_amt" id="total_payable_amt"
                    value="<?php echo $total_amt?>" />
            </div>
        </div>
        </div>
        <?php
			
		}
	?>



        <?php
                if ($total_amt > 0) {
                    ?>
        <input type="submit" class="text-light btn-success btn" name="print" id="print_receipt" value="Save & Print">
        <?php
                }
                ?>
    </form>

</div>
</div>
<script>
    $(document).on("click", "#print_receipt", function (e) {
        e.preventDefault();
        var formData = new FormData($("#summery_form")[0]);
        formData.append("submit", "submit");

        $.ajax({
            url: "ajax_truck_load.php",
            data: formData,
            type: "POST",
            dataType: "json",
            cache: false,
            processData: false,
            contentType: false,

            success: function (data) {

                if (data == 'inserted') {
                    printContent('print_table')
                }

            }
        });
    }); // end of insert 


    function printContent(el) {
        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

        return window.location.reload(true);

    }
</script>
<?php
	
}
?>