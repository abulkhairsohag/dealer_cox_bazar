<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('own_shop_customer_list')){
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
          <h2>Own Shop Customer List</h2>
          <div class="row float-right" align="right">
            <?php 
              if (permission_check('add_own_shop_customer_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_customer_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Customer</a>

              <?php
            }
            ?>

          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Customer Name</th>
                <th style="text-align: center;">Address</th>
                <th style="text-align: center;">Mobile No</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM own_shop_client ORDER BY serial_no DESC";
              $get_client = $dbOb->select($query);
              if ($get_client) {
                $i=0;
                while ($row = $get_client->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td align="center">


                      <?php 

                      if (permission_check('own_shop_customer_edit_button')) {
                        ?>

                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_customer_modal" style="margin:2px">Edit</a> 
                        <?php
                      }
                      ?>


                      <?php 

                      if (permission_check('own_shop_customer_delete_button')) {
                        ?> 

                         <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                        <?php
                      }
                      ?>

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
    <div class="modal fade" id="add_customer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                  <div class="x_content" style="background: #f2ffe6">
                    <br />
                    <!-- Form starts From here  -->
                    <form id="form_add_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                     <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Name<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text"  required="" id="add_customer_name" name="add_customer_name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address  <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea type="text" required="" id="add_customer_address" name="add_customer_address" class="form-control col-md-7 col-xs-12" ></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile  <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" required="" id="add_customer_mobile_no" name="add_customer_mobile_no" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" id="add_customer_email" name="add_customer_email" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>


                    <div style="display: none;">
                      <input type="number" id="edit_id" name="edit_id">
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="reset" class="btn btn-primary" >Reset</button>
                        <button type="submit" class="btn btn-success" id="submit_button"></button>
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

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Customer Information");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_customer_add.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#add_customer_name").val(data.client_name);
          $("#add_customer_address").val(data.address);
          $("#add_customer_mobile_no").val(data.mobile_no);
          $("#add_customer_email").val(data.email);
          $("#edit_id").val(data.serial_no);

        }
      });

    });



    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Provide New Customer Information");
      $("#submit_button").html("Save");
      $("#add_customer_name").val("");
      $("#add_customer_address").val("");
      $("#add_customer_mobile_no").val("");
      $("#add_customer_email").val("");
    });


    // now we are going to  insert data 
    $(document).on('submit','#form_add_data',function(e){
      e.preventDefault();
      var formData = new FormData($("#form_add_data")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_customer_add.php',
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
            $("#customer_id").html(data.client);
            $('#add_customer_modal').modal("hide");
get_data_table();
$("#form_add_data")[0].reset();


          }
        }
      });
    }); // end of insert 


    //delete data by id 
    $(document).on('click','.delete_data',function(){
      var serial_no_delete = $(this).attr("id");
      swal({
        title: "Are you sure to delete?",
        text: "Once deleted, all related information will be lost!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({
            url:"ajax_customer_add.php",
            data:{serial_no_delete:serial_no_delete},
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

  }); // end of delete 


  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_customer_add.php",
    data:{'sohag':'sohag'},
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

<script>
  

    $(document).on('click','#add_customer',function(){
      $("#ModalLabel").html("Provide New Customer Information");
      $("#submit_button").html("Save");
      $("#add_customer_name").val("");
      $("#add_customer_address").val("");
      $("#add_customer_mobile_no").val("");
      $("#add_customer_email").val("");
    });


    


</script>
