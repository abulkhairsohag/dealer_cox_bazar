<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('view_invoice_list')){
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
          <h2>Invoice List</h2>
          <div class="row float-right" align="right">

            <?php 
            if (permission_check('add_invoice')) {
              ?>
              <a href="add_invoice.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Invoice</a>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Type</th>
                <th style="text-align: center;">Zone</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Designation</th>
                <th style="text-align: center;">Phone</th>
                <th style="text-align: center;">Amount(৳)</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once('class/Database.php');
              $dbOb = new Database();
               if (Session::get("zone_serial_no")){
                  if (Session::get("zone_serial_no") != '-1') {
                    $zone_serial = Session::get("zone_serial_no");
                    $query = "SELECT * FROM invoice_details WHERE zone_serial_no = '$zone_serial' ORDER BY serial_no DESC";
                    $get_invoice = $dbOb->select($query);
                  }
                }else{
                  $query = "SELECT * FROM invoice_details ORDER BY serial_no DESC";
                  $get_invoice = $dbOb->select($query);
                }
              if ($get_invoice) {
                $i=0;
                while ($row = $get_invoice->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php if ($row['invoice_option'] == 'Sell Invoice') {
                      echo '<span class="badge bg-green">Income</span>';
                    }else{
                      echo '<span class="badge bg-orange">Expense</span>';
                    } ?></td>
                    
                    <td><?php echo $row['zone_name']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['phone_no']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['invoice_date']; ?></td>
                    <td align="center">
                      <?php 
                      if (permission_check('invoice_view_button')) {
                        ?>

                        <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 

                      <?php } ?>

                      <?php 
                      if (permission_check('invoice_edit_button')) {
                        ?>

                        <a href="edit_invoice.php?serial_no=<?php echo urldecode($row['serial_no']);?>" class="badge bg-blue edit_data"  > Edit</a>
                      <?php } ?>

                      <?php 
                      if (permission_check('invoice_delete_button')) {
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



    <!-- Modal For Showing data  -->
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " style="width: 700px" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Convence Bill Information</h3>
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



                      <div class="row"><div class="col"> <h3 style="color:  #34495E">General Information</h3><hr></div></div>

                      <div class="row" style="margin-top:10px">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"><h4 style="color: #0181E4">Bill Type </h4></div>
                        <div class="col-md-3" style="color: #0181E4"><h4 id="invoice_option" ></h4></div>
                        <div class="col-md-3"></div>
                      </div>

                      <div id="office_account" >  <!--THIS DIV IS FOR SHOWING OFFICE ACCOUNT INFORMATION-->

                        <div class="row" style="margin-top:10px">
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4>Name</h4></div>
                          <div class="col-md-3" ><h4 id="name"></h4></div>
                          <div class="col-md-3"></div>
                        </div>

                        <div class="row" style="margin-top:10px">
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4>Designation</h4></div>
                          <div class="col-md-3"><h4 id="designation"></h4></div>
                          <div class="col-md-3"></div>
                        </div>


                        <div class="row" style="margin-top:10px">
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4>Phone No</h4></div>
                          <div class="col-md-3"><h4 id="phone_no"></h4></div>
                          <div class="col-md-3"></div>
                        </div>

                   

                        <div class="row" style="margin-top:10px">
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4>Date</h4></div>
                          <div class="col-md-3"><h4 id="invoice_date"> </h4></div>
                          <div class="col-md-3"></div>
                        </div>

                      </div> <!--End of div for showing office account information-->

                      <div class="row" style="margin-top:10px"><div class="col"> <h3 style="color:  #34495E">Bill Details</h3><hr></div></div>


                      <div class="table-responsive">
                        <table class="table table-striped mb-none">
                          <thead>
                            <tr>
                              <th>Sl No.</th>
                              <th>Description</th>
                              <th>Purpose</th>
                              <th>Amount (৳)</th>
                            </tr>
                          </thead>
                          <tbody id="expense_table">



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
            url:"ajax_view_invoice_list.php",
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

// in the following section, details of a client will be shown 
$(document).on('click','.view_data',function(){
  var serial_no = $(this).attr("id");
  // alert(serial_no_edit);
  $.ajax({
    url : "ajax_view_invoice_list.php",
    method: "POST",
    data : {serial_no_view:serial_no},
    dataType: "json",
    success:function(data){
      
      if (data.details.invoice_option == 'Buy Invoice') {
        var type = 'Expense';
      }else{
        var type = "Income"
      }
        
      $("#invoice_option").html(type);


       

        $("#office_account_no").html(data.details.office_account_no);
        $("#name").html(data.details.name);
        $("#designation").html(data.details.designation);
        $("#phone_no").html(data.details.phone_no);
        $("#invoice_date").html(data.details.invoice_date);

      $("#expense_table").html(data.expense);

    }
  });
});
  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  $.ajax({
    url:"ajax_view_invoice_list.php",
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
<?php 

if (Session::get("update_message")) {
  ?>
  <script>
    swal({
      title: "<?php echo(Session::get("update_type")); ?>",
      text: "<?php echo(Session::get("update_message")); ?>",
      icon: "<?php echo(Session::get("update_type")); ?>",
      buttons: "Done",

    })
  </script>

  <?php
  Session::set("update_message",Null);
  Session::set("update_type",Null);
}
?>
</body>
</html>
