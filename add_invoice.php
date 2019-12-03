<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('add_invoice')){
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
            <?php } ?>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

    <!-- form starts form here -->
          <form class="form-horizontal form-bordered" data-parsley-validate id="add_data_form" action="" method="post">

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select Invoice Type</label>
              <div class="col-md-6">
               <select class="form-control" id="invoice_option" name="invoice_option" required="">
                <option value="">Select An Opiton</option>
                <option value="Buy Invoice">Buy Invoice</option>
                <option value="Sell Invoice">Sell Invoice</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Select Client</label>
            <div class="col-md-6">
              <select  class="form-control " id="client_option" name="client_option" required="">
                <option value="">Choose An Option</option>
                <option value="Office Account">Office Account</option>
                <option value="New Client">New Client</option>
              </select>
            </div>
          </div>

          <!-- THE FOLLOWING DIV IS FOR OFFICE ACCOUNT  -->
          <div class="form-group" id="office_account_details" style="display: none">

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select Account Number</label>
              <div class="col-md-6">
                <select class="form-control " id="office_account_no" name="office_account_no">
                  <option value=""></option>
                  
                  <?php
                    include_once("class/Database.php");
                    $dbOb = new Database();
                        $query = "SELECT * FROM account";
                        $get_account = $dbOb->select($query);
                        if ($get_account) {
                          while ($row = $get_account->fetch_assoc()) {
                            ?>
                              <option value="<?php echo($row['bank_account_no']) ?>"><?php echo $row['bank_account_no'].' , '.$row['organization_name'] ?></option>
                            <?php
                          }
                        }
                  ?>



                </select>
              </div>
            </div>

      

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Orgnization Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="office_organization_name" name="office_organization_name" readonly='' >
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Bank Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="office_bank_name" name="office_bank_name" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Branch Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" rows="3" id="office_branch_name" name="office_branch_name" readonly="">
              </div>
            </div>
          </div>


          <!-- END IF OFFICE ACCOUNT DIV -->



          <!-- THE FOLLOWING DIV IS FOR NEW CLIENT DETAILS -->
          <div class="form-group" id="new_client_detailas" style="display: none;">

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Client Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="new_client_name" name="new_client_name" >
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Organization Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="new_organization_name" name="new_organization_name" >
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Address</label>
              <div class="col-md-6">
                <textarea class="form-control" rows="3" id="new_address" name="new_address" ></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Mobile Number</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="new_phone_no" name="new_phone_no" >
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
                <th style="text-align: center;">Service</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Unit</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Price (৳)</th>
                <th style="text-align: center;">Subtotal (৳)</th>
                <th><button type="button" class="btn btn-success" id="add_more"><i class="fas fa-plus"></i></button></th>
              </tr>
            </thead>
            <tbody id="invoice_details">

              <tr>
                <td><input type="text" class="form-control main_service" id="service" name="service[]"></td>
                <td><input type="text" class="form-control main_description" id="description" name="description[]"></td>
                <td><input type="text" class="form-control main_unit" id="unit" name="unit[]"></td>
                <td><input type="number" min="0" step="1" class="form-control main_quantity" id="quantity" name="quantity[]" value="0"></td>
                <td><input type="number" min="0" step="0.01" class="form-control main_price" id="price" name="price[]" value="0"></td>
                <td><input type="number" class="form-control main_total total" id="total" name="total[]" readonly="" value="0"></td>
                <td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td>

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


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vat (%)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="vat" name="vat" value="0" placeholder="0">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Vat Amount (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" class="form-control" id="vat_amount" name="vat_amount" value="0" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Discount (%)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="discount" name="discount" value="0" placeholder="0">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Discount Amount (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" class="form-control" id="discount_amount" name="discount_amount" value="0" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Grand Total(৳)</label>
              <div class="col-md-6">
                <input type="number" class="form-control" id="grand_total" name="grand_total" readonly="" value="0">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Paid (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="pay" name="pay" value="0" placeholder="0">
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Due (৳)</label>
              <div class="col-md-6">
                <input type="number" min="0" step="0.01" class="form-control" id="due" name="due" readonly="" value="0">
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
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    $("#add_more").click(function(){
      $('#invoice_details').append('<tr class="added_row"><td><input type="text" class="form-control" id="service" name="service[]"></td><td><input type="text" class="form-control" id="description" name="description[]"></td><td><input type="text" class="form-control" id="unit" name="unit[]"></td><td><input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity[]" value="0"></td><td><input type="number" min="0" step="0.01" class="form-control" id="price" name="price[]" value="0"></td><td><input type="number" class="form-control total" id="total" name="total[]" readonly="" value="0"></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
    });
    $(document).on('click','.remove_button', function(e) {
      var remove_row = $(this).closest("tr");
      remove_row.remove();
      cal();
    });

    // the following section is for selecting client option

       $(document).on('change','#client_option',function(){
            var client_option = $(this).val();

            if (client_option == 'Office Account') {
              $("#office_account_details").show(500);
              $("#new_client_detailas").hide(500);

              $("#new_client_name").val('');
              $("#new_organization_name").val('');
              $("#new_address").val('');
              $("#new_phone_no").val('');

            }else if(client_option == 'New Client'){
              $("#new_client_detailas").show(500);
              $("#office_account_details").hide(500);

              $("#office_account_no").val('');
              $("#office_bank_name").val('');
              $("#office_organization_name").val('');
              $("#office_branch_name").val('');
            }else{
              $("#new_client_detailas").hide(500);
              $("#office_account_details").hide(500);

              $("#office_account_no").val('');
              $("#office_bank_name").val('');
              $("#office_organization_name").val('');
              $("#office_branch_name").val('');

              $("#new_client_name").val('');
              $("#new_organization_name").val('');
              $("#new_address").val('');
              $("#new_phone_no").val('');

            }
       });

      // in the following section we are going to fetch data while selecting an office account number

       $(document).on('change','#office_account_no',function(){
            var office_account_no = $(this).val();


            $.ajax({
              url: "ajax_invoice.php",
              method: "POST",
              data:{office_account_no_sohag:office_account_no},
              dataType: "json",
              success:function(data){
                $("#office_organization_name").val(data.organization_name);
               $("#office_bank_name").val(data.bank_name);
               $("#office_branch_name").val(data.branch_name);
              }
            });

       }); //fetching data of office account end

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
               $("#new_client_detailas").hide(500);
              $("#office_account_details").hide(500);

              $("#office_account_no").val('');
              $("#office_bank_name").val('');
              $("#office_organization_name").val('');
              $("#office_branch_name").val('');

              $("#new_client_name").val('');
              $("#new_organization_name").val('');
              $("#new_address").val('');
              $("#new_phone_no").val('');
              $(".added_row").remove();
              //removing values of invoice details main row
              $(".main_service").val("");
              $(".main_description").val("");
              $(".main_unit").val("");
              $(".main_quantity").val("");
              $(".main_price").val("");
              $(".main_total").val("");
              // now removing calculated values 
              $("#net_total").val("0");
              $("#vat").val("0");
              $("#vat_amount").val("0");
              $("#discount").val("0");
              $("#discount_amount").val("0");
              $("#grand_total").val("0");
              $("#pay").val("0");
              $("#due").val("0");

              $("#invoice_option").val("");
              $("#client_option").val("");

            }
          }
        });
    }); // end of insert 

// invoice calculation 
    $("#invoice_details").delegate('#price, #quantity','keyup blur',function(){
      var tr=$(this).parent().parent();

      var quantity =tr.find("#quantity").val();
      var price=tr.find("#price").val();
      var amt =quantity*price;
      tr.find(".total").val(amt);
      cal();
    });

// the following function is for invoice claculation
    function cal()
    {
      var net_total =0;

      $(".total").each(function(){
        net_total=net_total+($(this).val()*1);

      });
      $("#net_total").val(net_total);
      
      var vat = $("#vat").val();
      var discount = $("#discount").val();

      if (vat>=0 && vat <= 100) {
        var vat_amount = net_total*$("#vat").val()/100;
        $("#vat_amount").val(vat_amount);
        var discount_amount = $("#discount_amount").val();

        if (discount_amount>0) {
          grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount) - parseFloat(discount_amount));
          
        }else{
         grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount)) ;
         
         }
         $("#grand_total").val(grand_total);

         var pay_amount = $("#pay").val();
         if (pay_amount>0) {
           due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
           
         }else{
          due_amount = roundToTwo (parseFloat(grand_total));
          }

        $("#due").val(due_amount);

      }else{ // if  vat   is not found then net total will be the grand total
        $("#grand_total").val(net_total);
      }

       if(discount>=0 && discount <= 100){

        var net_total = $("#net_total").val();
        var vat_amount = $("#vat_amount").val();

        var discount_amount = roundToTwo (net_total*$("#discount").val()/100);
        
        $("#discount_amount").val(discount_amount);

        var total = parseFloat(net_total) + parseFloat(vat_amount);
        var grand_total = roundToTwo (parseFloat(total)  - parseFloat(discount_amount)) ;
        
        $("#grand_total").val(grand_total);

        var pay_amount = $("#pay").val();
        if (pay_amount>0) {
         due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
         
        }else{
          due_amount =  roundToTwo (parseFloat(grand_total));
        }

        $("#due").val(due_amount);

      }else{ // if  discount  is not found then net total will be the grand total
        $("#grand_total").val(net_total);
      }
      
    }
// vat claculation 
    $(document).on('keyup blur','#vat',function(){
      var vat = $(this).val();
      if (vat>100) {
        alert("You Cannot Take Vat More Than 100%");
        $(this).val(0)
      }else{
        var net_total = $("#net_total").val();
        var vat_amount = net_total*$("#vat").val()/100;
        var grand_total = 0;
        var due_amount = 0 ;
        $("#vat_amount").val(vat_amount);
        var discount_amount = $("#discount_amount").val();

        if (discount_amount>0) {
          grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount) - parseFloat(discount_amount));
          
        }else{
         grand_total = roundToTwo (parseFloat(net_total)  + parseFloat(vat_amount)) ;
         
       }

       $("#grand_total").val(grand_total);

       var pay_amount = $("#pay").val();
       if (pay_amount>0) {
         due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
         
       }else{
        due_amount = roundToTwo (parseFloat(grand_total));


      }

      $("#due").val(due_amount);

    }

  });


    $(document).on('keyup blur','#discount',function(){
      var discount_amt = $(this).val();
      if (discount_amt>100) {
        alert("You Cannot Provide A Discount More Than 100%");
        $(this).val(0)
      }else{

        var net_total = $("#net_total").val();
        var vat_amount = $("#vat_amount").val();

        var discount_amount = roundToTwo (net_total*$("#discount").val()/100);
        
        $("#discount_amount").val(discount_amount);

        var total = parseFloat(net_total) + parseFloat(vat_amount);
        var grand_total = roundToTwo (parseFloat(total)  - parseFloat(discount_amount)) ;
        
        $("#grand_total").val(grand_total);

        var pay_amount = $("#pay").val();
        if (pay_amount>0) {
         due_amount = roundToTwo (parseFloat(grand_total) - parseFloat(pay_amount));
         
       }else{
        due_amount =  roundToTwo (parseFloat(grand_total));

      }

      $("#due").val(due_amount);




    }


  });

    $(document).on('keyup blur','#pay',function(){
      var pay_amount = $(this).val();
      var grand_total = $("#grand_total").val();
      
      if (isNaN(pay_amount) || pay_amount == "") {
        pay_amount =0;
      }
      var due_amount = parseFloat(grand_total) - parseFloat(pay_amount);
      due_amount = roundToTwo (due_amount);
      $("#due").val(due_amount);
    });

  }); // end of document ready function 

  function roundToTwo (num){
    return +(Math.round(num + "e+2")+"e-2");
  }
</script>

</body>
</html>