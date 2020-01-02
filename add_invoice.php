<?php include_once 'include/header.php';?>


<?php
if (!permission_check('add_invoice')) {
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
          <h2>Add New Invoice</h2>
          <div class="row float-right" align="right">
            <?php
if (permission_check('view_invoice_list')) {
    ?>
            <a href="view_invoice_list.php" class="btn btn-primary" id="add_data"> <span class="badge"><i class="fas fa-list-ul"> </i></span> View Invoice List</a>
            <?php }?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

    <!-- form starts form here -->
          <form class="form-horizontal form-bordered" data-parsley-validate id="add_data_form" action="" method="post">



                
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
              <label class="col-md-3 control-label" for="inputDefault">Select Invoice Type <span style="color:red">*</span></label>
              <div class="col-md-6">
               <select class="form-control" id="invoice_option" name="invoice_option" required="">
                <option value="">Select An Opiton</option>
                <option value="Buy Invoice">Expense Invoice</option>
                <option value="Sell Invoice">Income Invoice</option>
              </select>
            </div>
          </div>






          <!-- THE FOLLOWING DIV IS FOR NEW CLIENT DETAILS -->
          <div class="form-group" id="new_client_detailas" >

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Name <span style="color:red">*</span></label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" required="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Designation</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="designation" name="designation" >
              </div>
            </div>



            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Mobile Number</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="phone_no" name="phone_no" >
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Invoice Date</label>
              <div class="col-md-6">
                <input type="text" class="form-control datepicker " id='invoice_date' name="invoice_date" value="<?php echo date('d-m-Y'); ?>" required="" readonly="">
              </div>
            </div>

          </div> <!-- END OF NEW CLIENT DETAILS DIV-->


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

              <tr>
                <td><input type="text" class="form-control description" id="description" name="description[]"></td>
                <td><input type="text" class="form-control purpose" id="purpose" name="purpose[]" required=""></td>
                <td><input type="number" min="0" step="1" class="form-control amount" id="amount" name="amount[]" required=""  ></td>

              </tr>

            </tbody>

          </table>


          <div class="form-group">
            <h3>
              <label class="col-md-3 control-label" for="inputDefault"  style="text-align: left; color: #34495E"></label></h3>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Net Total (৳)</label>
              <div class="col-md-6">
                <input type="number" class="form-control" id="net_total" name="net_total" value="0" readonly="">
              </div>
            </div>

            <div class="form-group" align="center">
              <input type="submit" name="submit" value="Save" class="btn btn-success" style="">
              <input type="reset" name="reset" value="Reset" class="btn btn-warning">
            </div>

          </form>


        </div>
      </div>
    </div>

    <!-- /page content -->

  </div>
</div>
<?php include_once 'include/footer.php';?>

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
    // now we are going to  insert data
      $(document).on('submit','#add_data_form',function(e){
        e.preventDefault();
        var formData = new FormData($("#add_data_form")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_invoice.php',
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

              $("#name").val('');
              $("#invoice_option").val('');
              $("#designation").val('');
              $("#phone_no").val('');
            
              var d = new Date();

              var month = d.getMonth()+1;
              var day = d.getDate();
 
              var output = (day<10 ? '0' : '') + day + '-' +
                  (month<10 ? '0' : '') + month + '-' +d.getFullYear();

              $("#invoice_date").val(output);


              $(".added_row").remove();
              //removing values of invoice details main row
              $(".description").val("");
              $(".purpose").val("");
              $(".amount").val("");
              $("#net_total").val("");

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