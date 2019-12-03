<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('transport_report')){
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

    <div>
      <div class="panel-heading" style="background: #34495E;color: white; padding-bottom: 10px" align="center">
        <h2 class="panel-title" style="color: white"><h3>Transport Report</h3></h2>
      </div>
      <div class="panel-body">


       <div class="form-group col-md-12" id="date_from">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From Date<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");  ?>
         <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today  ?>" required="" readonly="">
       </div>
     </div>



     <div class="form-group col-md-12" id="date_to">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To Date<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        
        <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="">
      </div>
    </div>



     <div class="form-group col-md-12" id="transport_info">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Vehicle <span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="vehicle_reg" id="vehicle_reg" class="form-control">
          
                <option value="">Please Select One </option>

                <?php 
                include_once('class/Database.php');
                $dbOb = new Database();
                $query = "SELECT *  FROM transport";
                $get_transport = $dbOb->select($query);

                if ($get_transport) {
                 while ($row = $get_transport->fetch_assoc()) {
                  
                   ?>
                   <option value="<?php echo $row['reg_no'] ?>"> <?php echo $row['reg_no'].', '.$row['vehicle_name']; ?> </option>
                   <?php
                 }
               }
               ?>
        </select>
      </div>
    </div>



     




     <div class="form-group col-md-12">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report Type<span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="report_type" id="report_type" class="form-control">
          <option value="">Please Select One</option>
          <option value="load">Truck Loading For Delivery</option>
          <option value="unload">Truck Unloading for Remaining Product</option>
          <option value="list">Transport list </option>
          <option value="self">Self Transport</option>
          <option value="rent">Rent Transport</option>
        </select>
      </div>
    </div>


    <div class="form-group col-md-12" id="Route" style="display: none">
      <div class="col-md-1"></div>
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Route <span class="required" style="color: red">*</span></label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        

        <select name="route" id="route" class="form-control">
          
                <option value="all"> All Route</option>

                <?php 
                include_once('class/Database.php');
                $dbOb = new Database();
                $query = "SELECT *  FROM area";
                $get_area = $dbOb->select($query);

                if ($get_area) {
                 while ($row = $get_area->fetch_assoc()) {
                  
                   ?>
                   <option value="<?php echo $row['area_name'] ?>"> <?php echo $row['area_name']; ?> </option>
                   <?php
                 }
               }
               ?>
        </select>
      </div>
    </div>





    <div class="form-group" style="margin-bottom: 20px;" align="center">

      <div class="col-md-12 col-sm-6 col-xs-8">
         <?php 
            if (permission_check('transport_report')) {
          ?>
        <button class="btn btn-success" id="view_record">View Record</button>
        <?php } ?>
      </div>
    </div>






  </div>
</div>
<div class="well" style="background: white;margin-top: 20px">
  <div class="row" id="show_table">




  </div>
</div>

<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

  	// showing records while pressing view record button
    $(document).on('click','#view_record',function(){
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var report_type = $("#report_type").val();
      var vehicle_reg = $("#vehicle_reg").val();
      var route = $("#route").val();

      $("#show_table").html("");


      $.ajax({
        url: "ajax_transport_report.php",
        method: "POST",
        data:{
        	from_date:from_date,
	        to_date:to_date,
	        report_type:report_type,
	        vehicle_reg:vehicle_reg,
	        route:route
	    },
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
          // console.log(data);

        }
      });

    });

// what will happen while changing the report type is defined here 
    $(document).on('change','#report_type',function(){
    	var report_type = $(this).val();

    	if (report_type == "list") {
    		$("#Route").show('1500');
    		$("#transport_info").hide('1500');
    		$("#date_to").show('1500');
    		$("#date_from").show('1500');
    	}else if(report_type == "self"){
    		$("#Route").hide('1500');
    		$("#transport_info").hide('1500');
    		$("#date_to").hide('1500');
    		$("#date_from").hide('1500');
    		
    	}else if(report_type == "rent"){
    		$("#Route").hide('1500');
    		$("#transport_info").hide('1500');
    		$("#date_to").hide('1500');
    		$("#date_from").hide('1500');
    		
    	}else{
    		$("#Route").hide('1500');
    		$("#transport_info").show('1500');
    		$("#date_to").show('1500');
    		$("#date_from").show('1500');

    	}
    });
  });
</script>

</body>
</html>