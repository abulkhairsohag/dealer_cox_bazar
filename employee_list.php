<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('employee_list')){
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
				<h2>Employee List <small>Users</small></h2>
				<div class="row float-right" align="right">

            <?php 
            if (permission_check('add_employee_button')) {
              ?>
					<a href="add_employee.php" class="btn btn-primary"> <i class="fa fa-plus"> Add Employee</i></a>
          <?php } ?>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<table id="datatable-buttons" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Sl No</th>
							<th>ID No</th>
							<th>Name</th>
							<th>Designation</th>
							<!-- <th>Area</th> -->
							<th>Mobile</th>
							<th>Status</th>
							<th>Role</th>
							<th>Action</th>
              <th></th>
						</tr>
					</thead>


					<tbody  id="tbl_body">
						<?php 
						include_once("class/Database.php");
						$dbOb = new Database();
						$query = "SELECT * FROM employee_main_info ORDER BY serial_no DESC";
						$get_employee = $dbOb->select($query);
						if ($get_employee) {
							$i=0;
							while ($row = $get_employee->fetch_assoc()) {
								$i++;
								$user_serial_no = $row['serial_no'];
								$query = "SELECT * FROM user_has_role WHERE user_serial_no = '$user_serial_no' AND user_type = 'employee'";
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
								?>
								<tr>
									<td> <?php echo $i; ?> </td>
									<td> <?php echo $row['id_no'] ?> </td>
									<td> <?php echo $row['name'] ?> </td>
									<td> <?php echo $row['designation'] ?> </td>
									<!-- // <td>  </td> -->
									<td> <?php echo $row['mobile_no'] ?> </td>
                    <?php 
                      if ($row['active_status'] == "Active") {
                        $color = "green";
                      }
                      if($row['active_status'] == "Inactive"){
                        $color = "red";
                      }
                     ?>
					<td style="color: <?php echo $color; ?>"><b><?php echo $row['active_status']; ?></b></td>
					
                    <td><span class="badge <?php echo $role_badge_color?>"><?php echo $role_name; ?></span></td>
									<td align="center">
                    

                    <?php 
                    if (permission_check('employee_view_button')) {
                      ?>
										<a href="view_employee.php?serial_no=<?php echo urldecode($row['serial_no']);?>" type="button" class="badge bg-green view_data"> View</a>
                    <?php } ?>
                    
                    <?php 
                    if (permission_check('employee_edit_button')) {
                      ?>

                    <a href="edit_employee.php?serial_no=<?php echo urldecode($row['serial_no']);?>" type="button" class="badge bg-yellow view_data"> Edit</a>
                    <?php } ?>
                    <?php 
                    if (permission_check('employee_delete_button')) {
                      ?>
										<a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                    <?php } ?>
                      <?php 
                      if (permission_check('employeee_role_button')) {
                        ?>
										 <a class="badge bg-green assign_role_button" id="<?php echo $row['serial_no'] ?>" data-toggle="modal" data-target="#assign_role_modal"   title="Assign Role"> Role </a>
                     <?php } ?>
                 
									</td>
                  <td></td>
								</tr>

								<?php
							}
						}
						?>


					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>





    <!--  Modal For Adding and Updating role of an employee  -->
    <div class="modal fade" id="assign_role_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Provide information of employee role</h3>
            <div style="float:right;">

            </div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="background: #f2ffe6">

                  <div class="x_content" style="background: #f2ffe6">
                    <br />
                    <!-- Form starts From here  -->
                    <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                      

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Role  <span class="required" style="color: red">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="role_name" id="role_name" class="form-control col-md-7 col-xs-12" required="" >
                        	<option value="">Please select a role</option>
                        	<?php 
                        		include_once ('class/Database.php');
                        		$dbOb = new Database();
                        		$query = "SELECT * FROM role";

                        		$get_role = $dbOb->select($query);
                        		if ($get_role) {
                        			while ($row = $get_role->fetch_assoc()) {
                        				?>
											<option value="<?php echo $row['serial_no'] ?>"><?php echo $row['role_name'] ?></option>
                        				<?php
                        			}
                        		}

                        	 ?>
                        </select>
                      </div>
                    </div>

                    <div style="display: none;">
                    	<input type="text" name="employee_serial_no" id="employee_serial_no">
                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="reset" class="btn btn-primary" >Reset</button>
                        <button type="submit" class="btn btn-success"> Save</button>
                      </div>
                    </div>


                  </form>
                </div>
              </div>
            </div>
          </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> <!-- End of modal for  Adding role of the employee-->
	<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
	$(document).ready(function(){
		$(document).on('click','.assign_role_button',function(){
			var employee_serial_no = $(this).attr("id");
			$("#employee_serial_no").val(employee_serial_no);

			console.log(employee_serial_no);
			$.ajax({
					url:"ajax_employee_list.php",
					data:{employee_id_role:employee_serial_no},
					type:"POST",
					dataType:"json",
					success:function(data){
						// $('#role_name').val(data);
						console.log(data);
					}
				});

		});

		$(document).on('click','.delete_data',function(){
			var serial_no_delete = $(this).attr("id");
			swal({
				title: "Are you sure To Delete?",
				text: "It Will Delete All Related Information.",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url:"ajax_employee_list.php",
						data:{serial_no_delete:serial_no_delete},
						type:"POST",
						dataType:"json",
						success:function(data){
							swal({
								title: data.type,
								text: data.message,
								icon: data.type,
								button: "Done",
							});
							show_data_table();
						}
					});
				} 
			});
		});


	$(document).on('submit','#form_edit_data',function(e){
      e.preventDefault();
      var formData = new FormData($("#form_edit_data")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_employee_list.php',
        data:formData,
        type:'POST',
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        success:function(data){
          swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
          if (data.type == 'success') {
           $("#assign_role_modal").modal("hide"); 
           show_data_table();
         }
       }
     });
    });

	});	 // end of document ready function 

  // the following function is declared for showing table data after adding data and upadating and deleting data 
  function show_data_table()
  {
  	$.ajax({
  		url:"ajax_employee_list.php",
  		data:{sohag:"sohag"},
  		type:"POST",
  		dataType:"text",
  		success:function(data_tbl){
  			sohag.destroy();
  			$("#tbl_body").html(data_tbl);
  			init_DataTables();
  		}
  	});
  }
</script>

</body>
</html>
