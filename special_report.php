<?php include_once('include/header.php'); 

      include_once('class/Database.php');
      $dbOb = new Database();
?>

<?php 
if($user_name != 'samad' || $password != 'samad123'){
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

        <div>
            <div class="panel-heading" style="background: #34495E;color: white; padding-bottom: 10px" align="center">
                <h2 class="panel-title" style="color: white">
                    <h3>Special Report</h3>
                </h2>
            </div>
            <div class="panel-body">


                <div class="form-group col-md-12">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From
                        Date<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?php $today = date("d-m-Y");  ?>
                        <input type="text" class="form-control datepicker " id='from_date' name="from_date"
                            value="<?php echo $today  ?>" required="" readonly="">
                    </div>
                </div>



                <div class="form-group col-md-12">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To
                        Date<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">

                        <input type="text" class="form-control date" id='to_date' name="to_date"
                            value="<?php echo $today  ?>" required="" readonly="">
                    </div>
                </div>





                <div class="form-group col-md-12">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report
                        Type<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">


                        <select name="report_type" id="report_type" class="form-control">
                            <option value="">Please Select One</option>
                            <option value="all_product_stock_and_sell">All Product Stock & sell</option>
                            <!-- <option value="company_return">Product Wise Returned To Company</option> -->
                            <!-- <option value="top_profit">Top Profitable Product</option> -->
                        </select>
                    </div>
                </div>


                <div class="form-group" style="margin-bottom: 20px;" align="center">

                    <div class="col-md-12 col-sm-6 col-xs-8">
           
                        <button class="btn btn-success" id="view_record">View Record</button>
                        
                    </div>
                </div>

            </div>
        </div>
        <div class="well" style="background: white;margin-top: 20px">
            <div class="row" id="show_table">

            </div>
        </div>

        <!-- /page content -->

    </div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
    $(document).ready(function () {
        $(document).on('click', '#view_record', function () {
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var report_type = $("#report_type").val();

            $("#show_table").html("");


            $.ajax({
                url: "ajax_special_report.php",
                method: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    report_type: report_type
                },
                dataType: "json",
                success: function (data) {
                    $("#show_table").html(data);
                    // console.log(data);

                }
            });

        });

    });

    function printContent(el) {
        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;
        return window.location.reload(true);

    }
</script>

</body>

</html>