<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('add_bank_loan')){
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
          <h2>Bank Loan List</h2>
          <div class="row float-right" align="right">
            <?php 
            if (permission_check('add_bank_loan_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Bank Loan</a>
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
                <th style="text-align: center;">Bank Name</th>
                <th style="text-align: center;">Branch Name</th>
                <th style="text-align: center;">Loan Amt</th>
                <th style="text-align: center;">Paid</th>
                <th style="text-align: center;">Due</th>
                <th style="text-align: center;">Pay Status</th>
                <th style="text-align: center;">Loan Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM bank_loan ORDER BY serial_no DESC";
              $get_bank_loan = $dbOb->select($query);
              if ($get_bank_loan) {
                $i=0;
                while ($row = $get_bank_loan->fetch_assoc()) {
                  $total_amount = $row['total_amount'];
                  $bank_loan_id = $row['serial_no'];
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['bank_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $total_amount; ?></td>
                    


                    <?php 

                    $pay_query = "SELECT * FROM bank_loan_pay WHERE bank_loan_id = '$bank_loan_id'";
                    $pay_data = $dbOb->select($pay_query);
                    if ($pay_data) {
                      $total_pay = 0;
                      while ($pay_row = $pay_data->fetch_assoc()) {
                        $total_pay += $pay_row['pay_amt'];
                      }
                      $due = $total_amount - $total_pay;
                    }else{
                      $total_pay = 0;
                      $due = $total_amount;
                    } ?>
                    <td><?php echo $total_pay; ?></td>
                    <td style="color: red"><?php echo $due; ?></td>


                    <?php
                    if ($total_pay < $total_amount) {
                      $display = "";
                      ?>
                      <td><?php echo '<span class="badge bg-red">UnPaid</span>'; ?></td>
                    <?php  }else{ 
                      $display = "none";
                      ?>
                      <td><?php echo '<span class="badge bg-green">Paid</span>'; ?></td>
                    <?php }
                    ?>
                    <td><?php echo $row['loan_taken_date']; ?></td>
                    <td align="center">
                      
                      <?php 
                      if (permission_check('bank_loan_view_button')) {
                        ?>
                      <a  class="badge  bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px"> View</a> 
                        <?php } ?>

                      <?php 
                      if (permission_check('bank_loan_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>

                      <?php 
                      if (permission_check('bank_loan_delete_button')) {
                        ?>

                        <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                      <?php } ?> 
                      

                      <?php 
                      if (permission_check('bank_loan_pay_button')) {
                        ?>
                      <a style="display: <?php echo $display; ?>; margin:2px "  class="badge pay_data bg-green" id="<?php echo($row['serial_no']) ?>" data-toggle="modal" data-target="#pay_modal"  > Pay</a> 
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
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="bank_name" name="bank_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="branch_name" name="branch_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Loan Amount <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" id="total_amount" name="total_amount" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Loan Taken Date <span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="loan_taken_date" name="loan_taken_date" class="date-picker form-control col-md-7 col-xs-12 datepicker" required="required"  autocomplete="off" readonly="">
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



    <!-- Modal For pay and Updating data  -->
    <div class="modal fade" id="pay_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Pay Bank Loan.</h3>
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
                    <form id="pay_data_insert" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="bank_name_pay" readonly name="bank_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="branch_name_pay" readonly name="branch_name" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Amount <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" readonly id="total_amount_pay" name="total_amount" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Paid <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" readonly="" id="total_paid" name="total_paid" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Monthly Installment Pay <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" id="installment_pay" name="installment_pay" class="form-control installment_pay col-md-7 col-xs-12" >
                        </div>
                      </div>

                     
                     
                      <input type="hidden" id="edit_id_pay" name="edit_id_pay">

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary" >Reset</button>
                          <button type="submit" class="btn btn-success" id="submit_pay"  name="submit_pay">Pay</button>
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
    </div> <!-- End of pay_modal for  Adding and Updating data-->


    <!-- Modal For Showing data  -->
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " style="width: 700px" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Bank Loan Infomation</h3>
            <div style="float:right;">

            </div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="background: #f2ffe6">

                  <div class="x_content" style="background: #f2ffe6">
                    <br />


                    <div style="margin : 20px" id="info_table">

                      <div class="row"><div class="col"> <h3 style="color:  #34495E">Genarel Information</h3><hr></div></div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Bank Name </h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="bank_name_view" ></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Branch Name</h5></div>
                        <div class="col-md-3" ><h5 style="color:black" id="branch_name_view"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Total Loan Amount</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="total_pay_amount_view"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Installment Amount</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="installment_amount_view"></h5></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div class="row" style="margin-top:10px" >
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h5 style="color:black">Installment Date</h5></div>
                        <div class="col-md-3"><h5 style="color:black" id="installment_date_view"></h5></div>
                        <div class="col-md-3"></div>
                      </div>


                      <div class="row" style="margin-top:10px"><div class="col"> <h3 style="color:  #34495E">Pay Information</h3><hr></div></div>


                      <div class="table-responsive">
                        <table class="table table-striped mb-none">
                          <thead style="background: green">
                            <tr style="color: white">
                              <th>#</th>
                              <th>Pay Amount</th>
                              <th>Pay Date</th>
                            </tr>
                          </thead>
                          <tbody id="order_table">



                          </tbody>
                        </table>
                      </div>



                    </div>   <!-- End of info table  -->

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
    </div> <!-- End of modal for  Showing data-->


    <!-- /page content -->

  </div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Bank Loan Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_add_bank_loan.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#bank_name").val(data.bank_name);
          $("#branch_name").val(data.branch_name);
          $("#total_amount").val(data.total_amount);
          $("#loan_taken_date").val(data.loan_taken_date);
          $("#zone_serial_no").val(data.zone_serial_no);
          $("#edit_id").val(data.serial_no);

        }
      });

    });


// pay query \\

$(document).on('click','.pay_data',function(){

  $("#submit_pay").html("Pay");
  var serial_no_pay = $(this).attr("id");

  $.ajax({
    url:"ajax_add_bank_loan.php",
    data:{serial_no_pay:serial_no_pay},
    type:"POST",
    dataType:'json',
    success:function(data){
      $("#bank_name_pay").val(data.bank_pay.bank_name);
      $("#branch_name_pay").val(data.bank_pay.branch_name);
      $("#total_amount_pay").val(data.bank_pay.total_amount);
      $("#installment_amount_pay").val(data.bank_pay.installment_amount);
      $("#installment_pay").val(data.bank_pay.installment_pay);
      $("#total_paid").val(data.total_pay);
      $("#edit_id_pay").val(data.bank_pay.serial_no);

    }
  });

});



$(document).on('keyup','.installment_pay',function(){
  var a = parseInt($(this).val());
  var b = parseInt($("#total_paid").val());
  var c = parseInt($("#total_amount_pay").val());
  var due = c - b;

  if ((a + b) > c) {
    alert("Your Due Is " + due + " Taka . And You Are Paying More Than The Amount.");
    $(".installment_pay").val("");

  }


});


// in the following section, details of a client will be shown 
$(document).on('click','.view_data',function(){
  var serial_no = $(this).attr("id");
  // alert(serial_no_edit);
  $.ajax({
    url : "ajax_view_bank_loan.php",
    method: "POST",
    data : {serial_no_view:serial_no},
    dataType: "json",
    success:function(data){

      $("#bank_name_view").html(data.query_loan['bank_name']);
      $("#branch_name_view").html(data.query_loan['branch_name']);
      $("#total_pay_amount_view").html(data.query_loan['total_amount']);
      $("#installment_amount_view").html(data.query_loan['installment_amount']);
      $("#installment_date_view").html(data.query_loan['installment_date']);

      
      $("#order_table").html(data.expense);

    }
  });
});




$(document).on('click','#add_data',function(){
  $("#ModalLabel").html("Add New Bank Loan Information.");
  $("#submit_button").html("Save");

  $("#bank_name").val("");
  $("#branch_name").val("");
  $("#total_amount").val("");
  $("#installment_amount").val("");
  $("#installment_date").val("<?php echo(date("d-m-Y")) ?>");
  $("#edit_id").val("");
});

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_add_bank_loan.php',
          data:formData,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            console.log(data);
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
            url:"ajax_add_bank_loan.php",
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



    $(document).on('submit','#pay_data_insert',function(e){
      e.preventDefault();
      var formData = new FormData($("#pay_data_insert")[0]);
      formData.append('submit_pay','submit_pay');
        // console.log(formData);

        $.ajax({
          url:'ajax_add_bank_loan.php',
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
              $("#pay_modal").modal("hide");
              $("#pay_data_insert")[0].reset();
              get_data_table();
            }
          }
        });
    }); // end of insert and update 



  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_add_bank_loan.php",
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