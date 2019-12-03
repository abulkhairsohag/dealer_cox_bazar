<?php include_once('include/header.php'); 

include_once("class/Database.php");
$dbOb = new Database();

if(!permission_check('take_back_market_product_return')){
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


    <div class="col-md-12 col-sm-12 col-xs-12" style="color: black">
      <div class="x_panel">
        <div class="x_title">
          <div class="row float-right" align="right">



          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <!-- form starts form here -->
          <form class="form-horizontal form-bordered" id="add_data_form" action="" method="post">


            <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                Select Employee 
              </div>
            </div>





            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Employee ID </label>
              <div class="col-md-6">

                <select name="employee_id" id="employee_id"  class="form-control" required="">
                	<option value="">Select Employee</option>
                	<?php 
                		$query = "SELECT * FROM employee_duty WHERE  active_status = 'Active'";
                		$get_emp_duty = $dbOb->select($query);
                		if ($get_emp_duty) {
                			while ($row=$get_emp_duty->fetch_assoc()) {
                				?>
									<option value="<?php echo($row['id_no']) ?>"><?php echo $row['id_no']; ?>, <?php echo $row['name'] ?></option>
                				<?php
                			}
                		}
                	 ?>


                	 <?php 
                		$query = "SELECT * FROM delivery_employee WHERE  active_status = 'Active'";
                		$get_delivery_emp = $dbOb->select($query);
                		if ($get_delivery_emp) {
                			while ($res=$get_delivery_emp->fetch_assoc()) {
                				?>
									<option value="<?php echo($res['id_no']) ?>"><?php echo $res['id_no']; ?>, <?php echo $res['name'] ?></option>
                				<?php
                			}
                		}
                	 ?>
                </select>
                
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Employee Name </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="employee_name" name="employee_name" readonly="">
              </div>
            </div>

           
            

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Unloading Date </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="unloading_date" name="unloading_date" value='<?php echo date("d-m-Y") ?>' readonly="">
              </div>
            </div>


<!-- in the following div product info will be placed using ajax while changing the area  -->

                <div id="invoice_details">
                </div>

            <div class="form-group" align="center">
            <?php 
            if (permission_check('return_product_save_button')) {
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
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){



 $(document).on('change','#employee_id', function() {
      var id = $(this).val();
     
      $.ajax({
        url:"ajax_store_market_return_product.php",
        data:{id:id},
        type:"post",
        dataType:'json',
        success:function(data){
          $("#employee_name").val(data.get_emp_info.name);
          $("#invoice_details").html(data.product_info);
          //console.log(data.product_info);
        }
      });

    });



    // now we are going to  insert data 
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_store_market_return_product.php',
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


  }); // end of document ready function 


</script>

</body>
</html>