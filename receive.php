<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('receive')){
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
          <h2>Received List</h2>
          <div class="row float-right" align="right">
            <?php 
            if (permission_check('add_receive_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Receive</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Zone Name</th>
                <th style="text-align: center;">Receive Type</th>
                <th style="text-align: center;">Client Name</th>
                <th style="text-align: center;">Organization</th>
                <th style="text-align: center;">Address</th>
                <th style="text-align: center;">Mobile No</th>
                <th style="text-align: center;">Invoice/Docs No</th>
                <th style="text-align: center;">Total</th>
                <th style="text-align: center;">Receive Date</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
               if (Session::get("zone_serial_no")){
                  if (Session::get("zone_serial_no") != '-1') {
                    $zone_serial_no = Session::get("zone_serial_no");
                    $query = "SELECT * FROM receive WHERE zone_serial_no = '$zone_serial_no' ORDER BY serial_no DESC";
                  }
               }else{
                 $query = "SELECT * FROM receive ORDER BY serial_no DESC";
               }
              $get_receive = $dbOb->select($query);
              if ($get_receive) {
                $i=0;
                while ($row = $get_receive->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['receive_type']; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['organization_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['invoice_docs_no']; ?></td>
                    <td><?php echo $row['total_amount']; ?></td>
                    <td><?php echo $row['receive_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td align="center">

                      <?php 
                      if (permission_check('receive_edit_button')) {
                        ?>
                         <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('receive_delete_button')) {
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
                <div class="x_panel" style="background: #f2ffe6">

                  <div class="x_content" style="background: #f2ffe6">
                    <br />
                    <!-- Form starts From here  -->
                    <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                      
                       <div class="form-group">
                      <label class="col-md-3 control-label" for="inputDefault">Zone </label>
                      <div class="col-md-6">
                            <select name="zone_serial_no" id="zone_serial_no"  required="" class="form-control zone_serial_no ">
                          
                              <?php

                              if (Session::get("zone_serial_no")){
                                if (Session::get("zone_serial_no") != '-1') {
                                
                                ?>
                                  <option value='<?php echo Session::get("zone_serial_no"); ?>'><?php echo Session::get("zone_name"); ?></option>
                                <?php
                                }else{
                                  ?>
                                    <option value=''><?php echo Session::get("zone_name"); ?></option>
                                  <?php
                                }
                              }else{
                                  $query = "SELECT * FROM zone ORDER BY zone_name";
                                  $get_zone = $dbOb->select($query);
                                  if ($get_zone) {
                                    ?>
                                    <option value="">Please Select One</option>
                                    <?php
                                          while ($row = $get_zone->fetch_assoc()) {

                                          ?>
                                          <option value="<?php echo $row['serial_no']; ?>"  ><?php echo $row['zone_name']; ?></option>
                                          <?php
                                        }
                                      }else{
                                        ?>
                                          <option value="">Please Add Zone First..</option>
                                        <?php

                                      }
                            }

                            ?>

                            </select>
                    
                      </div>
                    </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Receive Type <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="receive_type" name="receive_type" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Client Name <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="client_name" name="client_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Organization Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="organization_name" name="organization_name"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address  </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="address" name="address" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Number <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" required="" id="mobile_no" name="mobile_no" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Invoice/Docs No </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="invoice_docs_no" name="invoice_docs_no" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Amount <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" id="total_amount" name="total_amount" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                     

                      

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Receive Date<span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="receive_date" name="receive_date" class="date-picker form-control col-md-7 col-xs-12 datepicker" required="required"  autocomplete="off" readonly="" >
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" >
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
    
    $(document).on('keyup blur','#total_amount',function(){
      cal();
    });
    
    $(document).on('keyup blur','#paid_amount',function(){
      cal();
    });

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Receive Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_receive.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#receive_type").val(data.receive_type);
          $("#client_name").val(data.client_name);
          $("#organization_name").val(data.organization_name);
          $("#address").val(data.address);
          $("#mobile_no").val(data.mobile_no);
          $("#invoice_docs_no").val(data.invoice_docs_no);
          $("#total_amount").val(data.total_amount);
          $("#paid_amount").val(data.paid_amount);
          $("#due_amount").val(data.due_amount);
          $("#description").val(data.description);
          $("#receive_date").val(data.receive_date);
          $("#zone_serial_no").val(data.zone_serial_no);
          $("#edit_id").val(data.serial_no);

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add Receive Information.");
      $("#submit_button").html("Save");

      $("#receive_type").val("");
      $("#client_name").val("");
      $("#organization_name").val("");
      $("#address").val("");
      $("#mobile_no").val("");
      $("#invoice_docs_no").val("");
      $("#total_amount").val("");
      $("#paid_amount").val("");
      $("#due_amount").val("");
      $("#description").val("");
      $("#next_paid_date").val("<?php echo(date("d-m-y")) ?>");
      $("#edit_id").val("");
    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_receive.php',
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
    }); // end of insert and update 

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
            url:"ajax_receive.php",
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
    url:"ajax_receive.php",
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

function cal(){
  var total_amount = $("#total_amount").val();
  var paid_amount = $("#paid_amount").val();
  if (isNaN(total_amount)) {
    total_amount = 0;
  }
  if (isNaN(paid_amount)) {
    paid_amount = 0;
  }
  var due_amount = total_amount - paid_amount;

  $("#due_amount").val(due_amount);
}

</script>

</body>
</html>