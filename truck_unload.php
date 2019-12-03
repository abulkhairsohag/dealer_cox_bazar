<?php include_once('include/header.php'); 

include_once("class/Database.php");
$dbOb = new Database();
?>

<?php 
if(!permission_check('unload_truck_after_delivery')){
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
          <form class="form-horizontal form-bordered" id="summery_form" action="" method="post">


            <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                Area, Employee & Transport Information 
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Area <span class="required" style="color: red">*</span></label>
              <div class="col-md-6">
                <select name="area_name" id="area_name" class="form-control" required="">
                  <option value="">Select Area</option>

                  <?php 

                

                  $query = "SELECT * FROM area ";
                  $get_area = $dbOb->select($query);
                  if ($get_area) {
                    while ($row = $get_area->fetch_assoc()) {
                      $area_name = $row["area_name"];
                      ?>
                      
                      <option value="<?php echo $area_name ?>"><?php echo $area_name ; ?></option>


                      <?php
                    }
                  }
                  ?>

                </select>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Employee ID </label>
              <div class="col-md-6">

                <input type="text" name="employee_id" id="employee_id" class="form-control"  readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Employee Name </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="employee_name" name="employee_name" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vehicle Registraton No </label>
              <div class="col-md-6">
                
                <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" class="form-control" readonly="">

              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vehicle Name </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" required="" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vehicle Type </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" readonly="">
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
            if (permission_check('unload_save_button')) {
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
        url:"ajax_truck_unload.php",
        data:{id:id},
        type:"post",
        dataType:'json',
        success:function(data){
          $("#employee_name").val(data.name);
        }
      });

    });

 $(document).on('change','#vehicle_reg_no', function() {
      var reg_no = $(this).val();
     
      $.ajax({
        url:"ajax_truck_unload.php",
        data:{reg_no:reg_no},
        type:"post",
        dataType:'json',
        success:function(data){
          $("#vehicle_name").val(data.vehicle_name);
          $("#vehicle_type").val(data.type);
        }
      });

    });

 $(document).on('change','#area_name', function() {
      var area = $(this).val();
     
      $.ajax({
        url:"ajax_truck_unload.php",
        data:{area:area},
        type:"post",
        dataType:'json',
        success:function(data){
          $("#employee_id").html(data.option);
          $("#invoice_details").html(data.product_info);
          console.log(data)
          $("#employee_id").val(data.load_info.employee_id);
          $("#employee_name").val(data.load_info.emplyee_name);
          $("#vehicle_reg_no").val(data.load_info.vehicle_reg_no);
          $("#vehicle_name").val(data.load_info.vehicle_name);
          $("#vehicle_type").val(data.load_info.vehicle_type);
         
        }
      });

    });




    // now we are going to  insert data 



  }); // end of document ready function 

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>

</body>
</html>