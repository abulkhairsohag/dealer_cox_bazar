<?php 

include_once 'include/header.php';
include_once "class/Session.php";
Session::init();
Session::checkSession();

if (!permission_check('new_order')) {
	?>
	<script>
		window.location.href = '403.php';
	</script>
	<?php
}
?>


<div class="right_col" role="main">
	<div class="row">

		<!-- page content -->


		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-md-6 text-left">
							<h2>Add New Order</h2>
						</div>
						<div class="col-md-6 float-right" align="right">
							<?php
							if (permission_check('load_truck_button')) {
								?>
								<a href="truck_load.php" class="btn btn-primary" > <span class="badge"></span> Load Truck</a>
								<?php 
							}
							if (permission_check('unload_truck_button')) {
								?>
								<a href="truck_unload.php" class="btn btn-success" > <span class="badge"></span> Unload Truck</a>
							<?php } ?>
						</div>

					</div>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<!-- form starts form here -->
					<form class="form-horizontal form-bordered" id="add_data_form"  data-parsley-validate action="" method="post">


						<div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

							<div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
								Employee And Shop Information
							</div>
						</div>


						<!-- delivery man info -->
						<div class="col-md-12" style="margin-bottom: 30px;width: 100%" align="center" >
							<table style="width: 100%">


								<thead>
									<tr>
										<th style="text-align: center;padding-bottom: 10px; color: red">Sales Man's ID</th>
										<th style="text-align: center;padding-bottom: 10px; color: red">Name</th>
										<th style="text-align: center;padding-bottom: 10px; color: red">Delivery Man's ID</th>
										<th style="text-align: center;padding-bottom: 10px; color: red">Name</th>
									</tr>
								</thead>

								<tbody>

									<tr>
										<td>
											<select name="order_employee_id" id="order_employee_id"  required="" class="form-control order_employee_id ">
												<option value="">Please Select</option>
												<?php

												$query = "SELECT * FROM employee_duty WHERE active_status = 'Active' ORDER BY id_no";
												$get_sales_man = $dbOb->select($query);
												if ($get_sales_man) {
													while ($row = $get_sales_man->fetch_assoc()) {
														?>
														<option value="<?php echo $row['id_no']; ?>" <?php if (Session::get("order_emp_id") == $row['id_no']) {
															echo "selected";
														} ?>><?php echo $row['id_no'].', '.$row['name']; ?></option>
														<?php
													}
												}

												?>

											</select>
										</td>
										<td>
											<input type="text" class="form-control order_employee_name" id="order_employee_name" name="order_employee_name" readonly="" value="<?php if (Session::get("order_employee_name")) {
												echo Session::get("order_employee_name");
											} ?>" >
										</td>
										<td>
											<select name="delivery_employee_id" id="delivery_employee_id"  required="" class="form-control delivery_employee_id ">
												<option value="">Please Select</option>
												<?php
												if (Session::get("zone_serial_no")){
													if (Session::get("zone_serial_no") != '-1') {
														$zone_serial_no = Session::get("zone_serial_no");
														$query = "SELECT DISTINCT employee_id FROM truck_load WHERE zone_serial_no ='$zone_serial_no' AND unload_status = 0 ";
														$get_emp = $dbOb->select($query);
														if ($get_emp) {

															while ($row = $get_emp->fetch_assoc()) {
																$emp_id = $row['employee_id'];
																$query = "SELECT * FROM employee_main_info WHERE id_no = '$emp_id'";
																$get_emp_ifo = $dbOb->select($query);
																if ($get_emp_ifo) {
																	$emp= $get_emp_ifo->fetch_assoc();
																	?>
																	<option value="<?php echo $emp['id_no']; ?>"><?php echo $emp['id_no'].', '.$emp['name']; ?></option>
																	<?php
																}
															}
														}

													}
												}else{
													$query = "SELECT DISTINCT employee_id FROM truck_load WHERE  unload_status = 0 ";
													$get_emp = $dbOb->select($query);
													if ($get_emp) {

														while ($row = $get_emp->fetch_assoc()) {
															$emp_id = $row['employee_id'];
															$query = "SELECT * FROM employee_main_info WHERE id_no = '$emp_id'";
															$get_emp_ifo = $dbOb->select($query);
															if ($get_emp_ifo) {
																$emp= $get_emp_ifo->fetch_assoc();
																?>
																<option value="<?php echo $emp['id_no']; ?>"><?php echo $emp['id_no'].', '.$emp['name']; ?></option>
																<?php
															}
														}
													}
												}
												?>

											</select>
										</td> 
										<td>
											<input type="text" class="form-control delivery_employee_name" required="" id="delivery_employee_name" name="delivery_employee_name" readonly="" value="" >
										</td>

									</tr>


								</tbody>
							</table>
						</div>

						<div class="form-group row" style="display:none">
							<label class="col-md-3 col-6 control-label" for="inputDefault">Order Number</label>
							<div class="col-md-6 col-6">
								<!-- <select class="form-control" id="invoice_option" name="invoice_option" required=""> -->
									<?php
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
									?>
									<input type="text" class="form-control" id="order_no" name="order_no" readonly="" value="<?php echo $order_new_id; ?>">
								</div>
							</div>


							<div class="form-group row" style="display:none">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Vehicle Reg. No<span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text"  name="vehicle_reg_no" id="vehicle_reg_no"  required="" class="form-control vehicle_reg_no " readonly="">
								</div>
							</div>

							<div class="form-group row" style="display:none">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Vehicle Name<span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text"  name="vehicle_name" id="vehicle_name"  required="" class="form-control vehicle_name " readonly="">
								</div>
							</div>

							<div class="form-group row"  style="display:none">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Truck Load Serial No<span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text"  name="truck_load_serial_no" id="truck_load_serial_no"  required="" class="form-control truck_load_serial_no " readonly="">
								</div>
							</div>


							<div class="form-group row"  style="display:none" style="display:none">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Select Ware House<span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text"  name="ware_house_serial_no" id="ware_house_serial_no"  required="" class="form-control ware_house_serial_no " readonly="">

								</div>
							</div>

							<div class="form-group" style="display:none">
								<label class="col-md-3 control-label" for="inputDefault">Zone <span class="required" style="color: red">*</span></label>
								<div class="col-md-6">
									<input type="text"  name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no " readonly="">



								</div>
							</div>

							<div class="form-group" >
								<label class="col-md-3 control-label" for="inputDefault">Area <span class="required" style="color: red">*</span></label>
								<div class="col-md-6">
									<select name="area_employee" id="area_employee"  required="" class="form-control area_employee ">


										<option value="">Please Select Correct Delivery Man ...</option>


									</select>
								</div>
							</div>






							<div class="form-group row">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Select Customer<span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<select class="form-control" id="cust_id" name="cust_id" required="">

										<option value="">Select Area First</option>

									</select>
								</div>
							</div>

							<div class="form-group row" style="display: none">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Customer Name <span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text" class="form-control" id="customer_name" name="customer_name" readonly>
								</div>
							</div>

							<div class="form-group row" style="display:none">
								<label class="col-md-3 col-6 control-label" for="inputDefault" >Shop Name <span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text" class="form-control" id="shop_name" name="shop_name" readonly>
								</div>
							</div>

							<div class="form-group row" style="display: none">
								<label class="col-md-3 col-6 control-label" for="inputDefault">Address <span class="required" style="color: red">*</span></label>
								<div class="col-md-6 col-6">
									<input type="text" class="form-control" id="address" name="address" readonly>
								</div>
							</div>

							<div class="form-group" style="display: none">
								<label class="col-md-3 control-label" for="inputDefault">Mobile Number <span class="required" style="color: red">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="mobile_no" name="mobile_no" readonly>
								</div>
							</div>



							<div class="form-group">
								<label class="col-md-3 control-label" for="inputDefault">Date<span class="required" style="color: red">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control datepicker" id="date" name="date" readonly="" value='<?php echo date("d-m-Y")?>' required="" >  
								</div>
							</div>



							<div class="form-group bg-success" style="padding-bottom: 5px;margin-top: 30px">

								<div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
									Add Order Details
								</div>
							</div>

							<table class="table" class="">

								<thead>
									<tr>
										<th style="text-align: center;">Product ID</th>
										<th style="text-align: center;">Name</th>
										<th style="text-align: center;">Sell Price(Pack)</th>
										
										<th style="text-align: center;">Original Price</th>
										<th style="text-align: center;">QTY(Pack)</th>
										<th style="text-align: center;">QTY(Pcs)</th>
										
										<th style="text-align: center;">Total Price</th>
										<th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
									</tr>
								</thead>
								<tbody id="invoice_details">

									

								</tbody>

							</table>

							<?php
							$query = "SELECT * FROM invoice_setting";
							$get_invoice = $dbOb->select($query);
							if ($get_invoice) {
								$invoice_setting = $get_invoice->fetch_assoc();
							}
							?>
							<div class="form-group">
								<h3>
									<label class="col-md-3 control-label" for="inputDefault"  style="text-align: left; color: #34495E"></label></h3>
								</div>



								<div class="form-group">
									<label class="col-md-3 control-label" for="net_payable_amt">Net Payable Amount(৳)</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="net_payable_amt" name="net_payable_amt" readonly="" value="0">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label" for="pay">Paid Amount(৳)</label>
									<div class="col-md-6">
										<input type="number" min="0" step="1" class="form-control" id="pay" name="pay">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label" for="due">Due Amount(৳)</label>
									<div class="col-md-6">
										<input type="number" min="0" class="form-control" id="due" name="due" readonly="" value="0">
									</div>
								</div>

								<div class="form-group" align="center">
									<?php 
									if (permission_check('new_order_save_button')) {
										?>
										<input type="submit" name="submit" value="Save" class="btn btn-success" style="">
									<?php } ?>
									<input type="reset" name="reset" value="Reset" class="btn btn-warning">
								</div>

							</form>

						</div>
					</div>
				</div>

				<!-- /page content -->

			</div>
		</div>
		<?php include_once 'include/footer.php';?>

<script>
   $(document).ready(function(){

	$("#add_more").click(function(){
		var vehicle_reg_no = $("#vehicle_reg_no").val();
		get_product_options(vehicle_reg_no,true);
	});

	$(document).on('click','.remove_button', function(e) {
		var remove_row = $(this).closest("tr");
		remove_row.remove();
		cal();
	});


	$(document).on('change','.product_id', function() {

		var tr=$(this).parent().parent();
		var products_id_no_get_info =tr.find("#products_id_no").val();
		var vehicle_reg_no_get_info = $("#vehicle_reg_no").val();
		var confirm_availability = false;
		var product_all_id = [];

		tr.find(".sell_price").val('');
		tr.find(".original_sell_price").val('');
		tr.find(".products_name").val('');
		tr.find(".total_price").val('' );

		tr.find("#qty").val("");
		tr.find("#qty").attr("readonly", true);
		tr.find("#qty").attr("placeholder", '');
		tr.find("#qty").attr("data-available", '');

		tr.find("#qty_pcs").val("");
		tr.find("#qty_pcs").attr("readonly", true);
		tr.find("#qty_pcs").attr("placeholder", '');
		tr.find("#qty_pcs").attr("data-available", '');

		tr.find("#sell_price_pcs").val('');
		tr.find("#pack_size").val('');

		var i = 0;
		$(".product_id").each(function(){
			product_all_id[i] = $(this).val();
			i++;
		});

		product_all_id.pop();
		var j;
		for (j = 0; j < product_all_id.length; ++j) {
			if (products_id_no_get_info == product_all_id[j] && product_all_id[j] != '') {
				confirm_availability = 'sohag';
			}
		}

		if (confirm_availability == 'sohag') {
			swal({
				title: 'warning',
				text: 'This Product Has Already Been Selected. You Can Change The Quantity',
				icon: 'warning',
				button: "Done",
			});
			tr.find("#products_id_no").val('');


		}else{

			var qty = tr.find("#qty").val();
			if (isNaN(qty) || qty == '') {
				qty = 0;
			}
			var discount_on_mrp = $("#discount_on_mrp").val();
			var vat = $("#vat").val();

			$.ajax({
				url:"ajax_new_order.php",
				data:{products_id_no_get_info:products_id_no_get_info,vehicle_reg_no_get_info:vehicle_reg_no_get_info},
				type:"post",
				dataType:'json',
				success:function(data){

					if (data.type == 'warning') {
						swal({
							title: data.type,
							text: data.message,
							icon: data.type,
							button: "Done",
						});
						tr.find(".products_name").val('');
					}

					tr.find(".sell_price").val(data.sell_price);
					tr.find(".original_sell_price").val(data.original_sell_price);
					tr.find(".products_name").val(data.products.products_name);
					var total_price = (data.products.sell_price * qty) ;
					tr.find(".total_price").val(total_price );

					tr.find("#qty").attr("data-available", data.load_qty);
					
					var pack_size = data.products.pack_size;
					var load_pack_qty = data.load_qty;
					var available_packet_qty = Math.floor(load_pack_qty/pack_size); 
					var available_pcs = load_pack_qty%pack_size;
					var sell_p_with_offer = data.sell_price;
					var sell_price_pcs = sell_p_with_offer/pack_size;
					tr.find("#sell_price_pcs").val(sell_price_pcs.toFixed(2) );
					tr.find("#qty").attr("placeholder", available_packet_qty+' Pkt & '+available_pcs+' Pcs');
					tr.find("#qty").focus();
					tr.find("#qty").attr("readonly", false);
					tr.find("#qty_pcs").attr("placeholder", available_packet_qty+' Pkt & '+available_pcs+' Pcs');
					// tr.find("#qty_pcs").focus();
					tr.find("#qty_pcs").attr("readonly", false);
					tr.find("#pack_size").val(pack_size);

					cal();
				}
			});
		}
	});




    // now we are going to  insert data
    $(document).on('submit','#add_data_form',function(e){
    	e.preventDefault();
    	var formData = new FormData($("#add_data_form")[0]);
    	formData.append('submit','submit');

    	$.ajax({
    		url:'ajax_new_order.php',
    		data:formData,
    		type:'POST',
    		dataType:'json',
    		cache: false,
    		processData: false,
    		contentType: false,

    		success:function(data){
           // alert('ppppp');
           swal({
           	title: data.type,
           	text: data.message,
           	icon: data.type,
           	button: "Done",
           });
           if (data.type == 'success') {
           	setTimeout(function(){
           		location. reload(true)
           	},2000);


           }
       }
   });
    }); // end of insert




// invoice calculation for packet quantity
$("#invoice_details").delegate('#qty','keyup blur change',function(){
	var tr=$(this).parent().parent();

	price_calc(tr);
});
// invoice calculation for quantity pcs
$("#invoice_details").delegate('#qty_pcs','keyup blur change',function(){
	var tr=$(this).parent().parent();
	console.log(tr.find("#qty_pcs").val());
	price_calc(tr);
});

$(document).on('keyup blur change','#pay',function(){
	console.log();
	console.log($("#net_payable_amt").val());
	var pay = parseFloat($(this).val());
	var payable  = Math.round(parseFloat($("#net_payable_amt").val()));
	if (pay > payable) {
		swal({
			title: 'warning',
			text: 'Pay Amount Cannot Be Greater Than The Payable Amt',
			icon: 'warning',
			button: "Done",
		});
		$(this).val(0);
		$("#due").val(payable);
	}
	cal();
});


  $(document).on('change','#cust_id',function(){
  		var cust_id = $(this).val();
	    // alert(cust_id);
	    $.ajax({
	    	url:'ajax_new_order.php',
	    	data:{customer_id:cust_id},
	    	type:'POST',
	    	dataType:'json',
	    	success:function(data){
	    		$("#customer_name").val(data.client_name);
	    		$("#shop_name").val(data.organization_name);
	    		$('#address').val(data.address);
	    		$("#mobile_no").val(data.mobile_no);
	    		$(".employee_id").val(data.sales_man_id);
	    		$(".employee_name").val(data.sales_man_name);
	    	}
	    });
	});

  $(document).on('change','.area_employee',function(){
	  	$("#customer_name").val("");
	  	$("#cust_id").val("");
	  	$("#shop_name").val("");
	  	$('#address').val("");
	  	$("#mobile_no").val("");
	  	$(".employee_id").val("");
	  	$(".employee_name").val("");


	  	var area_name = $(this).val();
	  	$.ajax({

	  		url:'ajax_new_order.php',
	  		data:{area_name:area_name},
	  		type:'POST',
	  		dataType:'json',
	  		success:function(data){
	  			$("#cust_id").html(data);
	  		}
	  	});
  });

  $(document).on('change','#order_employee_id',function(){
  	var emp_id = $(this).val();
  	$.ajax({
  		url:'ajax_new_order.php',
  		data:{order_emp_id:emp_id},
  		type:'POST',
  		dataType:'json',
  		success:function(data){
  			$("#order_employee_name").val(data);
	          // $(".employee_id").val(emp_id);
	      }
	  });
  });

  $(document).on('change','#delivery_employee_id',function(){
	  	var emp_id = $(this).val();
	  	$.ajax({
	  		url:'ajax_new_order.php',
	  		data:{delivery_emp_id:emp_id},
	  		type:'POST',
	  		dataType:'json',
	  		success:function(data){
	  			if (data.message) {
	  				swal({
	  					title: data.type,
	  					text: data.message,
	  					icon: data.type,
	  					button: "Done",
	  				});
	  				$("#vehicle_reg_no").val('');
	  				$("#vehicle_name").val('');
	  				$("#truck_load_serial_no").val('');
	  				$("#ware_house_serial_no").val('');
	  				$("#zone_serial_no").val('');
	  				$("#area_employee").html('<option value=""> Please Select Correct Delivery Man</option>');
	  				$("#cust_id").html('<option value=""> Please Select Area First...</option>');
	  				$('.product_id').val('');
	  				$('.products_name').val('');
	  				$('.sell_price').val('');
	  				$('.qty').val('');
	  				$('.qty').attr('readonly', true);
	  				$('.qty').attr('placeholder', '');
	  				$('.qty_pcs').val('');
	  				$('.qty_pcs').attr('readonly', true);
	  				$('.qty_pcs').attr('placeholder', '');
	  				$('.pack_size').val('');
	  				$('.sell_price_pcs').val('');
	  				$('.original_sell_price').val('');


	  				$('.total_price').val('0');
	  				$('#net_payable_amt').val('0');
	  				$('#pay').val('0');
	  				$('#due').val('0');
	  			}
	  			$("#delivery_employee_name").val(data.delivery_emp_name);
	  			$("#vehicle_reg_no").val(data.vehicle.vehicle_reg_no);
	  			$("#vehicle_name").val(data.vehicle.vehicle_name);
	  			$("#truck_load_serial_no").val(data.vehicle.serial_no);
	  			$("#ware_house_serial_no").val(data.vehicle.ware_house_serial_no);
	  			$("#zone_serial_no").val(data.vehicle.zone_serial_no);

	  			$("#area_employee").html(data.area);
	  			// console.log(data.vehicle.vehicle_reg_no);
		         get_product_options(data.vehicle.vehicle_reg_no);
		      }
		  });
  });

  $(document).on('change','#zone_serial_no',function(){
  	var zone_serial_no = $(this).val();
  	$.ajax({
  		url:'ajax_new_order.php',
  		data:{zone_serial_no:zone_serial_no},
  		type:'POST',
  		dataType:'json',
  		success:function(data){
  			$("#area_employee").html(data.area_options);
  			$("#zone_name").val(zone_name);
	          // console.log(data.area_options);
	      }
	  });
  });

  $(document).on('change','#area_employee',function(){
	  	var area_name = $(this).val();
	  	$.ajax({
	  		url:'ajax_new_order.php',
	  		data:{area_name:area_name},
	  		type:'POST',
	  		dataType:'json',
	  		success:function(data){
	  			$("#cust_id").html(data);
	  		}
	  	});
  });

  $(document).on('change','#ware_house_serial_no',function(){
  	var ware_house_serial_no = $(this).val();
  	$.ajax({
  		url:'ajax_new_order.php',
  		data:{ware_house_serial_no:ware_house_serial_no},
  		type:'POST',
  		dataType:'json',
  		success:function(data){
	          // $("#cust_id").html(data);
	      }
	  });
  });


  $.ajax({
	  	url:'ajax_new_order.php',
	  	data:{send_area_and_customer:'send_area_and_customer'},
	  	type:'POST',
	  	dataType:'json',
	  	success:function(data){
	  		$("#area_employee").html(data.area);
		  		// $("#vehicle_reg_no").val(data.vehicle.vehicle_reg_no);
		          //  alert(data.vehicle);
		          // $("#vehicle_name").val(data.vehicle.vehicle_name);
		          // $("#truck_load_serial_no").val(data.vehicle.serial_no);
		          $("#ware_house_serial_no").val(data.vehicle.ware_house_serial_no);
		          $("#zone_serial_no").val(data.vehicle.zone_serial_no);
		      }
		  });
	  

}); // end of document ready function

// the folloeing function is for getting products options that are loaded to the truck
function get_product_options(vehicle_reg_no, append=false){
	var rows = ''
  $.ajax({
	  	url:'order_options.php',
	  	data:{vehicle_reg_no:vehicle_reg_no},
	  	type:'POST',
	  	dataType:'html',
	  	success:function(data){
	  		if (append) {
	  			$("#invoice_details").append(data);
	  		}else{

	  			$("#invoice_details").html(data);
	  		}
	  		// console.log(vehicle_reg_no);
	  	}
	  });
}


function price_calc(tr){
	var quantity_packet =tr.find("#qty").val();
	if (isNaN(quantity_packet) || quantity_packet == '') {
		quantity_packet = 0;
	}
	var quantity_pcs =tr.find("#qty_pcs").val();
	if (isNaN(quantity_pcs) || quantity_pcs == '') {
		quantity_pcs = 0;
	}
	var available_pcs =tr.find("#qty").data('available');
	if (isNaN(available_pcs) || available_pcs == '') {
		available_pcs = 0;
	}
	var pack_size =tr.find("#pack_size").val();
	if (isNaN(pack_size) || pack_size == '') {
		pack_size = 0;
	}

	var total_selected_pcs = pack_size*quantity_packet + quantity_pcs*1;
	console.log(total_selected_pcs);
	if (parseInt(total_selected_pcs) > parseInt(available_pcs)) {
		swal({
			title: 'warning',
			text: 'The Quantity You Have Entered Is Not Available In The Truck',
			icon: 'warning',
			button: "Done",
		});
		tr.find("#qty").val('');
		tr.find("#qty_pcs").val('');
		return 0;
	}


	var sell_price_per_pcs = tr.find(".sell_price_pcs").val();

	if (isNaN(sell_price_per_pcs) || sell_price_per_pcs == '') {
		sell_price_per_pcs = 0;
	}

	var sell_price_pack = tr.find(".sell_price").val();
	if (isNaN(sell_price_pack) || sell_price_pack == '') {
		sell_price_pack = 0;
	}

	var total_price = sell_price_pack*quantity_packet + sell_price_per_pcs * quantity_pcs ;
	tr.find(".total_price").val(total_price);

	cal();
}
  // the following function is for invoice claculation
  function cal(){
	  	var net_total =0;
	  	var paid = $("#pay").val();
	  	if (isNaN(paid) || paid == '' ) {
	  		paid = 0;
	  	}

	  	$(".total_price").each(function(){
	  		net_total=(net_total+($(this).val()*1));
	  	});
	  	$("#net_payable_amt").val(Math.round(net_total));
	  	$("#due").val(Math.round(net_total - paid));
  }
function roundToTwo (num){
	return +(Math.round(num + "e+2")+"e-2");
}
// $("#area_employee").select2({ width: '100%' }); 
$("#area").select2({ width: '100%' }); 
</script>

</body>
</html>