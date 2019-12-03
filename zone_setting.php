<?php include_once('include/header.php'); ?>

<?php 

if(!permission_check('sales_zone_setting')){
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
					<h2>Zone List <small>Users</small></h2>
					<div class="row float-right" align="right">
            <?php 
            if (permission_check('add_new_zone_button')) {
              ?> 
              <a href="#" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Zone</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

         <table id="datatable-buttons" class="table table-striped table-bordered">
          <thead>
           <tr>
            <th  style="text-align: center;">Sl No.</th>
            <th  style="text-align: center;">Zone Name</th>
            <th  style="text-align: center;">Areas Under The Zone</th>
            <th  style="text-align: center;">Action</th>
          </tr>
        </thead>


        <tbody id="data_table_body">
          <?php 
          include_once("class/Database.php");
          $dbOb = new Database();
          $query = "SELECT * FROM zone ORDER BY serial_no DESC";
          $get_zone = $dbOb->select($query);
          if ($get_zone) {
            $i = 0;
            while ($row = $get_zone->fetch_assoc()) {
              $i++;
              ?>

              <tr id="table_row_<?php echo $row['serial_no'] ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $row['zone_name'] ?></td>
                <td>
                  <?php 
                  $zone_serial_no = $row['serial_no'];
                  $query = "SELECT * FROM area_zone WHERE zone_serial_no = '$zone_serial_no' ";
                  $get_area = $dbOb->select($query);
                  if ($get_area) {
                    while ($area = $get_area->fetch_assoc()) {
                      $area_name = $area['area_name'];
                     
                      ?>
                      <span class="badge bg-green" style="margin:1px"><?php echo  $area_name ?></span>
                      <?php 
                    }
                  }
                  ?>
                </td>
                <td align="center">
                  
                  <?php 
                  if (permission_check('zone_edit_button')) {
                    ?> 
                    <a  class="badge bg-blue  edit_data" id="<?php echo $row['serial_no'] ?>"  data-toggle="modal" data-target="#add_update_modal"style="margin:2px">Edit</a> 
                  <?php } ?>
                  
                  <?php 
                  if (permission_check('zone_delete_button')) {
                    ?> 

                    <a  class="badge  bg-red delete_data" id="<?php echo $row['serial_no'] ?>" style="margin:2px"> Delete</a> 
                  <?php } ?> 

                </td>
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




<!-- Modal For Adding and Updating data  -->
<div class="modal fade" id="add_update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title" id="ModalLabel" style="color: white"></h3>
        <div style="float:right;">

        </div>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="background: #f2ffe6">

              <div class="x_content" >
                <br />

                <!-- form starts from here  -->
                <form id="form_edit_data" method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Zone Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="zone_name" name="zone_name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Select Areas</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <select class="select2 form-control col-md-7 col-xs-12"  multiple="multiple" name="area_name[]" id="area_name">
                       <?php
                       $query = "SELECT * FROM area";
                       $get_area = $dbOb->select($query);
                       if ($get_area) {
                        while ($area = $get_area->fetch_assoc()) {
                          ?>
                          <option value='<?php echo $area['serial_no']; ?>' ><?php echo $area['area_name']; ?></option>

                        <?php } }?>
                      </select>
                    </div>
                  </div>

               

                  <div style="display: none">
                    <input type="number" id="edit_id" name="edit_id">
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <button type="submit" name="submit_button" class="btn btn-success" id="submit_button"></button>
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
</div> <!-- End of modal for  Adding and Updating data-->


<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

// the following section is used to get data of the row where we click to edit and put them to the form 
$(document).on('click','.edit_data',function(){
  $("#ModalLabel").html("Update Area Information.");
  $("#submit_button").html("Update");

  var serial_no = $(this).attr("id");
  $.ajax({
    url:'ajax_zone_setting.php',
    data:{serial_no_edit:serial_no},
    type: "POST",
    dataType: "json",
    success:function(data){
      $("#zone_name").val(data.zone_info.zone_name);
      // console.log(data.zone_info.zone_name);
      $("#area_name").val(data.area_serial_no).trigger('change');
      $("#edit_id").val(data.zone_info.serial_no);
    }
  });
});

// the following section is used to change button name of modal and make the input fields empty every time
$(document).on('click','#add_data',function(){
  $("#ModalLabel").html("Provide New Zone Information.");
  $("#submit_button").html("Save");

  $("#zone_name").val('');
  $("#area_name").val('').trigger('change') ;
  $("#line_route").val('');
  $("#edit_id").val('');
});

// the following section is used to insert and update information 
$(document).on('submit','#form_edit_data',function(e){
  e.preventDefault();
  var formData = new FormData($("#form_edit_data")[0]);
  formData.append('submit','submit');

  $.ajax({
    url:'ajax_zone_setting.php',
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
       $("#add_update_modal").modal("hide"); 
       get_data_table();
     }
   }
 });
});


// The following section is for deleting information
$(document).on('click','.delete_data',function(){
  var delete_id = $(this).attr("id");
  swal({
    title: "Are you sure To Delete?",
    text: "It Will Delete All Related Information",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {

      $.ajax({
        url:"ajax_zone_setting.php",
        data:{delete_id:delete_id},
        type:"POST",
        dataType:'json',
        success:function(data){
          swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
          get_data_table();
        }
      });

    } 
  });
});
});

// this function is defined to get thable data after insert upadate and deleting data
function get_data_table(){
  $.ajax({
    url:"ajax_zone_setting.php",
    data:{sohag:"sohag"},
    type:"POST",
    dataType:"text",
    success:function(data_tbl){
      
      sohag.destroy();
      $("#data_table_body").html(data_tbl);
      init_DataTables();
    }
  });
}
$("#area_name").select2({ width: '100%' }); 
</script>

</body>
</html>