<?php include_once('include/header.php'); ?>

<?php 

if(!permission_check('product_category_setting')){
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
					<h2>Category List </h2>
					<div class="row float-right" align="right">

            <?php 
            if (permission_check('add_new_category_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Category</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

         <table id="datatable-buttons" class="table table-striped table-bordered">
          <thead>
           <tr>
            <th  style="text-align: center;">Serial Number</th>
            <th  style="text-align: center;">Category Name</th>
            <th style="text-align: center;">Action</th>
          </tr>
        </thead>


        <tbody id="data_table_body">

          <?php 
          include_once("class/Database.php");
          $dbOb = new Database();

          $query = "SELECT * FROM category ORDER BY serial_no DESC";
          $get_category = $dbOb->select($query);
          if ($get_category) {
            $i = 0;
            while ($row = $get_category->fetch_assoc()) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td align="center">

                  <?php 
                  if (permission_check('category_edit_button')) {
                    ?>
                    <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                  <?php } ?> 

                  <?php 
                  if (permission_check('category_delete_button')) {
                    ?>

                    <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a>  
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
            <div class="x_panel" style="background: #f1f5f2">
              <div class="x_content" style="background: #f1f5f2">
                <br />

                <!-- Form starts from here  -->
                <form id="form_add_edit_data" data-parsley-validate class="form-horizontal form-label-left" action="" method="post">

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="category_name" name="category_name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div style="display: none;">
                    <input type="number" id="edit_id" name="edit_id">
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <input type="submit" class="btn btn-success" id="submit_button" name="submit_button">
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

// the following section is for getting data from database for editing and put then into the form
$(document).on('click','.edit_data',function(){
  $("#ModalLabel").html("Update Category");
  $("#submit_button").val("Update");
  var serial_no_edit = $(this).attr('id');
      //console.log(serial_no_edit);
      $.ajax({
        url:'ajax_category.php',
        data:{serial_no_edit:serial_no_edit},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#category_name").val(data.category_name);
          $("#edit_id").val(data.serial_no);
        }
      });

    });

// here meking the form inputs empty for inserting new data
$(document).on('click','#add_data',function(){
  $("#ModalLabel").html("Add new Category");
  $("#submit_button").val("Save");
  $("#category_name").val('');
  $("#edit_id").val('');

});

// by submitting the form we are going to insert and update information 
$(document).on('submit','#form_add_edit_data',function(e){
  e.preventDefault();
  var formData = new FormData($("#form_add_edit_data")[0]);
  formData.append('submit','submit');
  $.ajax({
    url:'ajax_category.php',
    data:formData,
    type:'POST',
    dataType:'json',
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

    // now we are going to delete data 
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
            url:"ajax_category.php",
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
    url:"ajax_category.php",
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
</script>

</body>
</html>
