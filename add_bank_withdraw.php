<?php include_once 'include/header.php';?>

<?php
if (!permission_check('add_bank_withdraw')) {
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
          <h2>Bank Withdraw List</h2>
          <div class="row float-right" align="right">
            <?php
if (permission_check('add_bank_withdraw_button')) {
	?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Bank Withdraw</a>
            <?php }?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Zone Name</th>
                <th style="text-align: center;">Bank Name</th>
                <th style="text-align: center;">Bank Account No</th>
                <th style="text-align: center;">Cheque Number</th>
                <th style="text-align: center;">Branch Name</th>
                <th style="text-align: center;">Amount</th>
                <th style="text-align: center;">Receiver Name</th>
                <th style="text-align: center;">Cheque Active Date</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php
                  include_once 'class/Database.php';
                  $dbOb = new Database();
                  if (Session::get("zone_serial_no")){
                    if (Session::get("zone_serial_no") != '-1') {
                      $zone_serial = Session::get("zone_serial_no");
                      $query = "SELECT * FROM bank_withdraw WHERE zone_serial_no = '$zone_serial' ORDER BY serial_no DESC";
                      $get_bank_withdraw = $dbOb->select($query);
                    }
                  }else{
                    $query = "SELECT * FROM bank_withdraw ORDER BY serial_no DESC";
                    $get_bank_withdraw = $dbOb->select($query);
                  }
                  if ($get_bank_withdraw) {
                    $i = 0;
                    while ($row = $get_bank_withdraw->fetch_assoc()) {
                      $i++;
                      ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['bank_name']; ?></td>
                    <td><?php echo $row['bank_account_no']; ?></td>
                    <td><?php echo $row['cheque_no']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['receiver_name']; ?></td>
                    <td><?php echo $row['cheque_active_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td align="center">

                      <?php
if (permission_check('bank_withdraw_edit_button')) {
			?>
                         <a  class="badge bg-blue edit_data" id="<?php echo ($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a>
                      <?php }?>

                      <?php
if (permission_check('bank_withdraw_delete_button')) {
			?>
                        <a  class="badge  bg-red delete_data" id="<?php echo ($row['serial_no']) ?>"  style="margin:2px"> Delete</a>
                      <?php }?>
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
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Account Number  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="bank_account_no" name="bank_account_no" class="form-control col-md-7 col-xs-12">
                            <option value="">Please Select One..</option>
                            <?php
                              $query = "SELECT * FROM account";
                              $get_account = $dbOb->select($query);
                              if ($get_account) {
                                while ($row = $get_account->fetch_assoc()) {
                                  ?>
                                      <option value='<?php echo $row["bank_account_no"]?>'><?php echo $row["bank_account_no"].', '.$row['bank_name'].', '.$row['branch_name']?></option>
                                  <?php
                                }
                              }
                            ?>
                          </select>
                        </div>
                      </div>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cheque Number<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required=""id="cheque_no" name="cheque_no"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Amount <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" id="amount" name="amount" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Receiver Name  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="receiver_name" name="receiver_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cheque Active Date <span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="cheque_active_date" name="cheque_active_date" class="date-picker form-control col-md-7 col-xs-12 datepicker" required="required"  autocomplete="off" readonly="" >
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>


                           
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
<?php include_once 'include/footer.php';?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Bank Withdraw Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_add_bank_withdraw.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#bank_name").val(data.bank_name);
          $("#bank_account_no").val(data.bank_account_no);
          $("#cheque_no").val(data.cheque_no);
          $("#branch_name").val(data.branch_name);
          $("#amount").val(data.amount);
          $("#receiver_name").val(data.receiver_name);
          $("#cheque_active_date").val(data.cheque_active_date);
          $("#description").val(data.description);
          $("#edit_id").val(data.serial_no);

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add New Bank Withdraw Information.");
      $("#submit_button").html("Save");

      $("#bank_name").val("");
      $("#bank_account_no").val("");
      $("#cheque_no").val("");
      $("#branch_name").val("");
      $("#amount").val("");
      $("#receiver_name").val("");
      $("#cheque_active_date").val("<?php echo (date("d-m-Y")) ?>");
      $("#description").val("");
      $("#edit_id").val("");
    });

      // now we are going to update and insert data
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_add_bank_withdraw.php',
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
            url:"ajax_add_bank_withdraw.php",
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
   $(document).on('change','#zone_serial_no',function(){
     var zone_serial_no = $(this).val();
     $.ajax({
        url:'ajax_new_order.php',
        data:{zone_serial_no:zone_serial_no},
        type:'POST',
        dataType:'json',
        success:function(data){
          $("#area_employee").html(data.area_options);
          $("#zone_name").val(zone_name);
          // console.log(data.area_options);
        }
      });
  });

  }); // end of document ready function

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_add_bank_withdraw.php",
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