<?php include_once('include/header.php'); ?>

<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->
    <?php 
    include_once("class/Database.php");
    $dbOb = new Database();
    $serial_no = '';
    $get_invoice_details = "";
    $get_invoice_expense = "";

    if (isset($_GET['serial_no'])) {
      $serial_no = $_GET['serial_no'];
      $query_invoice_details = "SELECT * FROM invoice_details WHERE serial_no = '$serial_no'";
      $query_invoice_expense = "SELECT * FROM invoice_expense WHERE invoice_serial_no = '$serial_no'";

      $get_invoice_details = $dbOb->find($query_invoice_details);
      $get_invoice_expense = $dbOb->select($query_invoice_expense);
    }
    ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Update Invoice</h2>
          <div class="row float-right" align="right">
            <a href="view_invoice_list.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fas fa-list-ul"> </i></span> View Invoice List</a>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <!-- form starts form here -->
          <form class="form-horizontal form-bordered" id="add_data_form" action="" method="post">

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select Invoice Type</label>
              <div class="col-md-6">
               <select class="form-control" id="invoice_option" name="invoice_option" required="">
                <option value="">Select An Opiton</option>
                <option value="Buy Invoice"<?php if ($get_invoice_details['invoice_option']=='Buy Invoice'): ?>
                selected=""
                <?php endif ?>>Expense Invoice</option>
                <option value="Sell Invoice"<?php if ($get_invoice_details['invoice_option']=='Sell Invoice'): ?>
                selected=""
                <?php endif ?>>Income Invoice</option>
              </select>
            </div>
          </div>

         

     
          <div class="form-group" >

              <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Name <span style="color:red">*</span></label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" required="" value="<?php echo $get_invoice_details['name'] ?>">
              </div>
            </div>



             <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Designation</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="designation" name="designation" value="<?php echo $get_invoice_details['designation'] ?>" >
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Mobile Number</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="phone_no" name="phone_no" value="<?php echo $get_invoice_details['phone_no'] ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Invoice Date</label>
              <div class="col-md-6">
                <input type="text" class="form-control datepicker " id='invoice_date' name="invoice_date" value="<?php echo $get_invoice_details['invoice_date']; ?>" required="" readonly="">
              </div>
            </div>
          </div>

          <!-- END IF OFFICE ACCOUNT DIV -->



          <!-- THE FOLLOWING DIV IS FOR NEW CLIENT DETAILS -->
     


          <div class="form-group bg-success" style="padding-bottom: 5px">

            <div class="col-md-6 control-label" for="inputDefault"  style="text-align: left; color: #34495E;font-size: 20px">
              Add Invoice Details
            </div>
          </div>

          <table class="table" class="">

            <thead>
              <tr>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Purpose</th>
                <th style="text-align: center;">Amount (৳)</th>
                <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
              </tr>
            </thead>
            <tbody id="invoice_details">

              <?php if ($get_invoice_expense) {
                while ($row = $get_invoice_expense->fetch_assoc()) {
                  ?>
                  <tr>
                  <td><input type="text" class="form-control description" id="description" name="description[]" value="<?php echo $row['description']?>"></td>
                  <td><input type="text" class="form-control purpose" id="purpose" name="purpose[]" required="" value="<?php echo $row['purpose']?>"></td>
                  <td><input type="number" min="0" step="1" class="form-control amount" id="amount" name="amount[]" required=""   value="<?php echo $row['amount']?>"></td>

                </tr>

                  <?php
                }
              } 
              ?>

            </tbody>

          </table>


          <div class="form-group">
            <h3>
              <label class="col-md-3 control-label" for="inputDefault"  style="text-align: left; color: #34495E"></label></h3>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Net Total (৳)</label>
              <div class="col-md-6">
                <input type="number" class="form-control" id="net_total" name="net_total" value="<?php echo $get_invoice_details['pay'] ?>" readonly="">
              </div>
            </div>


     

     


            <div class="form-group" style="display: none;">
              <label class="col-md-3 control-label" for="inputDefault">Edit ID</label>
              <div class="col-md-6">



                <input type="number" class="form-control" id="edit_id" name="edit_id" value="<?php echo $serial_no; ?>" >
              </div>
            </div>

            <div class="form-group" align="center">
              <input type="submit" name="submit" value="Update Information" class="btn btn-success" style="">
              <a href="view_invoice_list.php"> <input type="button" name="reset" value="Back" class="btn btn-danger"></a>
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

    $("#add_more").click(function(){
      $('#invoice_details').append('<tr class="added_row"><td><input type="text" class="form-control" id="description" name="description[]"></td><td><input type="text" class="form-control" id="purpose" name="purpose[]" required=""></td><td><input type="number" min="0" step="1" class="form-control amount" id="amount" name="amount[]" required=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
    });
    $(document).on('click','.remove_button', function(e) {
      var remove_row = $(this).closest("tr");
      remove_row.remove();
      cal();
    });

    // the following section is for selecting client option

    


    // now we are going to  insert data 
    $(document).on('submit','#add_data_form',function(e){
      e.preventDefault();
      var formData = new FormData($("#add_data_form")[0]);
      formData.append('submit','submit');

      $.ajax({
        url:'ajax_edit_invoice.php',
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
             if (data.type == 'success') {
              window.location = 'view_invoice_list.php';
            }

          }
        }
      });
    }); // end of insert 

// invoice calculation 
 $("#invoice_details").delegate('.amount','keyup blur',function(){
      cal();
    });


// the following function is for invoice claculation
    function cal()
    {
      var net_total =0;
      $(".amount").each(function(){
        net_total=net_total+($(this).val()*1);
        $("#net_total").val(net_total);
      });

    }

  }); // end of document ready function


function roundToTwo (num){
  return +(Math.round(num + "e+2")+"e-2");
}
</script>

</body>
</html>