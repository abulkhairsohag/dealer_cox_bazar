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
          <form class="form-horizontal form-bordered" id="add_data_form" action="" method="post">


            <div class="form-group bg-success" style="padding-bottom: 5px; margin-bottom: 30px">

              <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
                Area, Employee & Transport Information 
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select A Vehicle <span class="required" style="color: red">*</span></label>
              <div class="col-md-6">
                <select name="vehicle_reg_no" id="vehicle_reg_no" class="form-control" required="">

                  <?php 
                  $query = "SELECT * FROM truck_load WHERE unload_status = 0 ";
                  $get_loaded_trucks = $dbOb->select($query);
                  if ($get_loaded_trucks) {
                    ?>
                  <option value="">Please Select One</option>
                    <?php
                    while ($row = $get_loaded_trucks->fetch_assoc()) {
                      $area_name = $row["area_name"];
                      ?>
                      <option value="<?php echo $row['vehicle_reg_no'] ?>"><?php echo $row['vehicle_reg_no'].', '.$row['vehicle_name'] ; ?></option>

                      <?php
                    }
                  }else{
                    ?>
                      <option value="">No Truck Is Loaded...</option>
                    <?php
                  }
                  ?>

                </select>
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


    $(document).on('change','#vehicle_reg_no', function() {
          var reg_no = $(this).val();
          $.ajax({
            url:"ajax_truck_unload.php",
            data:{reg_no:reg_no},
            type:"post",
            dataType:'json',
            success:function(data){
           
              $("#invoice_details").html(data.product_info);
            }
          });
      });

  $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_truck_unload.php',
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

function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>

</body>
</html>