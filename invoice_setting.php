<?php 

include_once('include/header.php'); 
 
if(!permission_check('invoice_setting')){
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

        <?php 
include_once("class/Database.php");
$dbOb = new Database();

$query = "SELECT * FROM invoice_setting";
$get_invoice_setting = $dbOb->select($query);
if ($get_invoice_setting) {
    $get_invoice_setting = $get_invoice_setting->fetch_assoc();
}
 ?>


        <!-- Profile Information starts from here  -->

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Invoice Settings Information</h2>
                    <ul class="nav navbar-right panel_toolbox">

                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="">
                    <br />

                    <div class="row text-dark">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <table class="table" style="box-shadow: 6px 7px 7px 4px #000;background: #f2ffe6;color:black">

                                <tbody>
                                    <tr>
                                        <td></td>

                                        <td align="">Discount On MRP</td>
                                        <td id='show_discount_on_mrp'>
                                            <?php echo $get_invoice_setting['discount_on_mrp']; ?> (%)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="">Vat</td>
                                        <td id='show_vat'><?php echo $get_invoice_setting['vat']; ?> (%)</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td align="">Discount On Total TP</td>
                                        <td id='show_discount_on_tp'>
                                            <?php echo $get_invoice_setting['discount_on_tp']; ?> (%)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="">Special Discount</td>
                                        <td id='show_special_discount'>
                                            <?php echo $get_invoice_setting['special_discount']; ?> (%)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="">Show Previous Dues ?</td>
                                        <td id='show_show_dues'>
                                            <?php 
                                                if ($get_invoice_setting['show_dues'] == 1) {
                                                    $bg = "bg-green";
                                                    $message = "Yes";
                                                }else{
                                                    $bg = "bg-red";
                                                    $message = "No";
                                                }
                                             ?>
                                             <span class="badge <?php echo $bg?>"><?php echo $message ?></span>
                                         </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="right">
                                            <button class="btn btn-primary edit_info"
                                                id="<?php echo($get_invoice_setting['serial_no']) ?>"
                                                data-toggle="modal" data-target="#edit_modal">Edit Invoice
                                                Setting</button>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile Information ends here  -->





    <!-- Modal For editing data  -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Update Invoice Settings</h3>
                    <div style="float:right;">

                    </div>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="background: #f2ffe6">

                                <div class="x_content" style="">
                                    <br />

                                    <!-- Edit data  Form Starts here -->
                                    <form id="form_edit_data" action="" method="POST" data-parsley-validate
                                        class="form-horizontal form-label-left">

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                for="first-name">Discount On MRP (%)
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="discount_on_mrp" name="discount_on_mrp"
                                                    required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                for="last-name">Vat (%)
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="vat" name="vat"
                                                    class="form-control col-md-7 col-xs-12" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="middle-name"
                                                class="control-label col-md-3 col-sm-3 col-xs-12">Discount On Total TP (%)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="discount_on_tp" name="discount_on_tp"
                                                    class="form-control col-md-7 col-xs-12" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="middle-name"
                                                class="control-label col-md-3 col-sm-3 col-xs-12">Special Discount (%)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="special_discount" name="special_discount"
                                                    class="form-control col-md-7 col-xs-12" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="middle-name"
                                                class="control-label col-md-3 col-sm-3 col-xs-12">Show Previous Dues ?</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="checkbox" id="show_dues" name="show_dues" class="icheckbox_flat-green " data-parsley-multiple="show_dues">
                                            </div>
                                        </div>

                                       
                                        <div class="form-group" style="display: none;">
                                            <label for="middle-name"
                                                class="control-label col-md-3 col-sm-3 col-xs-12">Edit id number</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="edit_id" name="edit_id"
                                                    class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>



                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="reset" class="btn btn-primary">Reset</button>
                                                <input type="submit" id="submit_edit" name="submit_edit"
                                                    class="btn btn-success" value="Update">
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
    </div> <!-- End of modal for updating data-->

     <!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
    $(document).ready(function () {

        $(document).on('submit','#form_edit_data',function(e){
            e.preventDefault();
            var formData = new FormData($("#form_edit_data")[0]);
            formData.append('submit','submit');
            $.ajax({
                url: 'ajax_edit_invoice_setting.php',
                data: formData,
                type: "post",
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    swal({
                        title: data.type,
                        text: data.message,
                        icon: data.type,
                        button: "Done",
                    });
                    if (data.type == 'success') {
                        $("#show_discount_on_mrp").html(data.discount_on_mrp+' (%)');
                        $("#show_discount_on_tp").html(data.discount_on_tp+' (%)');
                        $("#show_special_discount").html(data.special_discount+' (%)');
                        $("#show_vat").html(data.vat+' (%)');
                        
                        if (data.show_dues == 1) {
                        $("#show_show_dues").html(' <span class="badge bg-green">Yes</span>');
                        
                        }else{
                             $("#show_show_dues").html(' <span class="badge bg-red">No<span>');
                        }
                                   
                                            
                        $("#edit_modal").modal('hide');
                    }
                    // console.log(data);

                }
            });
        });

        $(document).on('click', '.edit_info', function () {
            var serial_no_edit_info = $(this).attr("id");
            console.log(serial_no_edit_info);
            $.ajax({
                url: 'ajax_edit_invoice_setting.php',
                data: {
                    serial_no_edit_info: serial_no_edit_info
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $("#discount_on_mrp").val(data.discount_on_mrp);
                    $("#vat").val(data.vat);
                    $("#discount_on_tp").val(data.discount_on_tp);
                    $("#special_discount").val(data.special_discount);
                    $("#edit_id").val(data.serial_no);
                    if (data.show_dues == 1) {
                        $("#show_dues").attr("checked", true);
                    }else{
                        $("#show_dues").attr("checked", false);

                    }
                    
                }
            });
        });


    }); // end of document ready
</script>

</body>

</html>