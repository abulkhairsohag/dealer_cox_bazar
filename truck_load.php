<?php include_once('include/header.php'); 

include_once("class/Database.php");
$dbOb = new Database();
 
if(!permission_check('truck_load_for_delivery')){
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
            
           
            <div class="row form-group bg-success" style="padding: 5px; margin-bottom: 30px">
              <div class="col-md-6 control-label" for="inputDefault"
                style="text-align: left; color: #34495E;font-size: 20px">
                First Select Employee Then Area
              </div>
              <div class="col-md-6 float-right" align="right">
                  <?php 
                  if (permission_check('delivery_pending')) {
                    ?> 
                    <a href="delivery_pending.php" class="btn btn-primary" > <span class="badge"></span> Pending Order List</a>
                  <?php } ?>
              </div>
            </div>
                
           

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Delivery Employee ID <span class="required"
                  style="color: red">*</span></label>
              <div class="col-md-6">
                <select name="employee_id" id="employee_id" class="form-control" required="">
                  <option value="">Select Employee</option>
                  <?php 
                      $query = "SELECT * FROM  delivery_employee WHERE  active_status  = 'Active'";
                      $get_emp = $dbOb->select($query);
                      if ($get_emp) {
                        while ($emp = $get_emp->fetch_assoc()) {
                          ?>
                  <option value="<?php echo $emp['id_no']?>"><?php echo $emp['id_no'].', '.$emp['name']?></option>
                  <?php
                        }
                      }
                    ?>
                </select>
              </div>
            </div>

            <div class="form-group" style="display:none">
              <label class="col-md-3 control-label" for="inputDefault">Employee Name </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="employee_name" name="employee_name" readonly="">
              </div>
            </div>

            <div class="form-group" style="display:none">
              <label class="col-md-3 control-label" for="inputDefault"> Phone No </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="employee_phone_no" name="employee_phone_no" readonly="">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select Vehicle <span class="required"
                  style="color: red">*</span></label>
              <div class="col-md-6">
                <select name="vehicle_reg_no" id="vehicle_reg_no" class="form-control" required="">
                  <option value="">Please Select A Vehicle</option>

                  <?php 
                  $query = "SELECT * FROM transport order by vehicle_name";
                  $get_vehicle = $dbOb->select($query);
                  if ($get_vehicle) {
                    while ($row = $get_vehicle->fetch_assoc()) {
                      // $vehicle_name = $row["vehicle_name"];
                      ?>
                      <option value="<?php echo $row['reg_no'] ?>"><?php echo $row['reg_no'].', '.$row['vehicle_name'] ; ?></option>
                  <?php
                    }
                  }
                  ?>

                </select>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Area <span class="required"
                  style="color: red">*</span></label>
              <div class="col-md-6">
                <select name="area_name" id="area_name" class="form-control" required="">
                  <option value="">Please Select Employee First</option>

                  <?php 
                  $query = "SELECT * FROM area order by area_name";
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


            <!-- in the following div product info will be placed using ajax while changing the area  -->

            <div id="invoice_details">

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
  $(document).ready(function () {

    $(document).on('change', '#employee_id', function () {
      var id = $(this).val();
      $.ajax({
        url: "ajax_truck_load.php",
        data: {
          id: id
        },
        type: "post",
        dataType: 'json',
        success: function (data) {
          $("#employee_name").val(data.name);
          $("#employee_phone_no").val(data.mobile_no);
        }
      });
    });



    $(document).on('change', '#area_name', function () {
      var area = $(this).val();
      var employee_id = $("#employee_id").val();
      var employee_name = $("#employee_name").val();
      var employee_phone_no= $("#employee_phone_no").val();
      var area = $(this).val();
      var vehicle_reg_no = $("#vehicle_reg_no").val();
      
      

      if(employee_id == "" || vehicle_reg_no ==""){
        swal({
              title: "warning",
              text: "Please Select Delivery Man And Vehicle First.",
              icon: "warning",
              button: "Done",
            });
        $(this).val("");
      }else{
            $.ajax({
            url: "summery_load.php",
            data: {
              area: area,
              employee_id: employee_id,
              employee_name: employee_name,
              employee_phone_no: employee_phone_no,
              vehicle_reg_no: vehicle_reg_no
            },
            type: "post",
            dataType: 'html',
            success: function (data) {
              // $("#employee_id").html(data.option);
              $("#invoice_details").html(data);
             
             
            }
          });
      }
    });


    // now we are going to  insert data 
   
  }); // end of document ready function 

  function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
  }

  function printContent(el){
    var a = document.body.innerHTML;
    var b = document.getElementById(el).innerHTML;
    document.body.innerHTML = b;
    window.print();
    document.body.innerHTML = a;
    return window.location.reload(true);
  }
</script>


    
</body>
</html>