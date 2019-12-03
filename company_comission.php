<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('company_comission')){
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
          <h2>Company Commission List</h2>
          <div class="row float-right" align="right">
            <?php 
            if (permission_check('add_company_comission_button')) {
              ?>
              <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Commission</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Company</th>
                <th style="text-align: center;">Month</th>
                <th style="text-align: center;">Target Product</th>
                <th style="text-align: center;">Target Sell amount</th>
                <th style="text-align: center;">Comission(%)</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
              $query = "SELECT * FROM company_commission ORDER BY serial_no DESC";
              $get_company_commission = $dbOb->select($query);
              if ($get_company_commission) {
                $i=0;
                while ($row = $get_company_commission->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['company']; ?></td>
                    <?php 
                    $month = $row['month'];
                    $exp = explode('-', $month);
                    $month = $exp[0];
                    $year = $exp[1];
                    $month_name = '';
                    switch ($month) {
                      case '01':
                      $month_name = "January".'-'.$year;
                      break;
                      case '02':
                      $month_name = "February".'-'.$year;
                      break;
                      case '03':
                      $month_name = "March".'-'.$year;
                      break;
                      case '04':
                      $month_name = "April".'-'.$year;
                      break;
                      case '05':
                      $month_name = "May".'-'.$year;
                      break;
                      case '06':
                      $month_name = "June".'-'.$year;
                      break;
                      case '07':
                      $month_name = "July".'-'.$year;
                      break;
                      case '08':
                      $month_name = "August".'-'.$year;
                      break;
                      case '09':
                      $month_name = "September".'-'.$year;
                      break;
                      case '10':
                      $month_name = "October".'-'.$year;
                      break;
                      case '11':
                      $month_name = "November".'-'.$year;
                      break;
                      case '12':
                      $month_name = "December".'-'.$year;
                      break;
                      
                      
                    }
                    ?>
                    <td><?php echo $month_name; ?></td>
                    <td><?php echo $row['target_product']; ?></td>
                    <td><?php echo $row['target_sell_amount']; ?></td>
                    <td><?php echo $row['comission_persent']; ?></td>

                    <td><?php echo $row['date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('company_comission_edit_button')) {
                        ?>
                        <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                      <?php } ?>
                      <?php 
                      if (permission_check('company_comission_delete_button')) {
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
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="company" name="company" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Month <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="month" id="month" class="form-control col-md-7 col-xs-12" required="" >
                            <option value="">Select Month</option>
                            <option value="01-<?php echo date("Y") ?>">January</option>
                            <option value="02-<?php echo date("Y") ?>">February</option>
                            <option value="03-<?php echo date("Y") ?>">March</option>
                            <option value="04-<?php echo date("Y") ?>">April</option>
                            <option value="05-<?php echo date("Y") ?>">May</option>
                            <option value="06-<?php echo date("Y") ?>">June</option>
                            <option value="07-<?php echo date("Y") ?>">July</option>
                            <option value="08-<?php echo date("Y") ?>">August</option>
                            <option value="09-<?php echo date("Y") ?>">September</option>
                            <option value="10-<?php echo date("Y") ?>">October</option>
                            <option value="11-<?php echo date("Y") ?>">November</option>
                            <option value="12-<?php echo date("Y") ?>">December</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Target Product<span class="required" style="color: red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required="" id="target_product" name="target_product"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Target Sell Amount  <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" id="target_sell_amount" name="target_sell_amount" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>



                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Commission(%)  <span class="required" style="color: red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" step="0.01" required="" id="comission_persent" name="comission_persent" class="form-control col-md-7 col-xs-12" >
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

      $("#ModalLabel").html("Update Company Commission Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_company_comission.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#company").val(data.company);
          $("#month").val(data.month);
          $("#target_product").val(data.target_product);
          $("#target_sell_amount").val(data.target_sell_amount);
          $("#edit_id").val(data.serial_no);

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add Company Commission Information.");
      $("#submit_button").html("Save");

      
      $("#company").val("");
      $("#month").val("");
      $("#target_product").val("");
      $("#target_sell_amount").val("");
      $("#edit_id").val("");

    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_company_comission.php',
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
            url:"ajax_company_comission.php",
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
    url:"ajax_company_comission.php",
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