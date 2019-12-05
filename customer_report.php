<?php include_once('include/header.php'); ?>

<div class="right_col" role="main">
    <div class="row">
        <!-- page content -->
        <div>
            <div class="panel-heading" style="background: #34495E;color: white; padding-bottom: 10px" align="center">
                <h2 class="panel-title" style="color: white">
                    <h3>Customer Report</h3>
                </h2>
            </div>
            <div class="panel-body">

                <div class="form-group col-md-12">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Report
                        Type<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <select name="report_type" id="report_type" class="form-control">
                            <option value="">Please Select One</option>
                            <option value="customer_wise_order">Customer Wise Orders</option>
                            <option value="area_wise_customer">Area Wise Customer</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12" id="customer_id_div"  style="display:none">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select Client<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <select name="customer_id" id="customer_id" class="form-control select2">
                            <option value="">Please Select A Customer</option>
                            <?php 
                                $query = "SELECT * FROM `client` ORDER BY organization_name";
                                $get_client = $dbOb->select($query);
                                if ($get_client) {
                                    while ($row = $get_client->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['cust_id']?>">
                                        <?php echo $row['organization_name'].', '.$row['client_name'].', '.$row['area_name']?>
                                    </option>
                                    <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12" id="area_div" style="display:none">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Select
                        Area<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <select name="area" id="area" class="form-control select2">
                            <option value="">Please Select An Area</option>
                            <?php 
                                $query = "SELECT * FROM `area` ORDER BY area_name";
                                $get_area = $dbOb->select($query);
                                if ($get_area) {
                                    while ($row = $get_area->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['area_name']?>">
                                        <?php echo $row['area_name'];?>
                                    </option>
                                    <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12" id="date_from" style="display:none">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">From
                        Date<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?php $today = date("d-m-Y");  ?>
                        <input type="text" class="form-control datepicker " id='from_date' name="from_date"
                            value="<?php echo $today  ?>" required="" readonly="">
                    </div>
                </div>

                <div class="form-group col-md-12" id="date_to" style="display:none">
                    <div class="col-md-1"></div>
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">To
                        Date<span class="required" style="color: red">*</span></label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" class="form-control date" id='to_date' name="to_date"
                            value="<?php echo $today  ?>" required="" readonly="">
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
            var report_type = $("#report_type").val();
            var customer_id = $("#customer_id").val();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var area = $("#area").val();
            $("#show_table").html('');

           if (report_type == '') {
                swal({
                    title: "warning",
                    text: "Please Select Report Type",
                    icon: "warning",
                    button: "Done",
                });
           }else {
            $.ajax({
                    url: "ajax_customer_report.php",
                    method: "POST",
                    data: {
                        report_type: report_type,
                        customer_id: customer_id,
                        from_date: from_date,
                        to_date: to_date,
                        area:area
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#show_table").html(data);
                        // console.log(data);
                    }
                });
           }
        });

    $(document).on('change','#report_type',function(){
        var report_type = $(this).val();
        if (report_type == 'customer_wise_order') {
            $("#customer_id_div").show(500);
            $("#date_from").show(500);
            $("#date_to").show(500);
            $("#area_div").hide(500);
            $("#area").val('');
        }else if (report_type == 'area_wise_customer') {
            $("#customer_id_div").hide(500);
            $("#date_from").hide(500);
            $("#date_to").hide(500);
            $("#area_div").show(500);
            $("#customer_id").val('');

        }
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
    $("#customer_id").select2({ width: '100%' }); 
    $("#area").select2({ width: '100%' }); 
</script>

</body>

</html>