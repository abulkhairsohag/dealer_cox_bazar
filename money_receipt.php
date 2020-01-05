<?php include_once('include/header.php'); ?>



<?php 
if(!permission_check('print_money_receipt')){
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
        <h2 class="panel-title" style="color: white"><h3>Print Money Receipt</h3></h2>
      </div>
      <div class="panel-body">




     <div class="row">
        <div class="row">
            <div class="col-md-4 col-sm-4"></div>
            <div class="col-md-4 col-sm-4">
                <div class="from-group"  id="date_from">
                    <label for="from_date">From Date</label>
                    <?php $today = date('d-m-Y');?>
                    <input type="text" class="form-control datepicker " id='from_date' name="from_date" value="<?php echo $today  ?>" required="" readonly="">
                </div>
            </div>
            <div class="col-md-4 col-sm-4"></div>
        </div>

         <div class="row">
            <div class="col-md-4 col-sm-4"></div>
            <div class="col-md-4 col-sm-4">
                <div class="from-group"  id="date_to">
                    <label for="to_date">To Date</label>
                    <input type="text" class="form-control date" id='to_date' name="to_date" value="<?php echo $today  ?>" required="" readonly="">
                </div>
            </div>
            <div class="col-md-4 col-sm-4"></div>
         </div>

         <div class="row">
            <div class="col-md-4 col-sm-4"></div>
            <div class="col-md-4 col-sm-4">
                <div class="from-group"  id="date_to">
                    <label for="employee_id">Select Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                    <option value="">Please Select One</option>
                    <?php 
                        $query = "SELECT * FROM `employee_main_info` WHERE active_status ='Active'";
                        $get_emp = $dbOb->select($query);
                        if ($get_emp) {
                            while ($row = $get_emp->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_no']?>"><?php echo $row['id_no'].', '.$row['name']?></option>
                                <?php
                            }
                        }
                    ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-4"></div>
         </div>

         <div class="row text-center" style="margin-top: 10px">
            <div class="col-md-4 col-sm-4"></div>
            <div class="col-md-4 col-sm-4">
                <div class="from-group" >
                <button class="btn btn-success" id="view_record">View Record</button>
                </div>
            </div>
            <div class="col-md-4 col-sm-4"></div>
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
  $(document).ready(function(){

    $(document).on('click','#view_record',function(){
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var employee_id = $("#employee_id").val();
      $("#show_table").html("");

        $.ajax({
          url: "ajax_money_receipt.php",
          method: "POST",
          data:{from_date:from_date,to_date:to_date,employee_id:employee_id},
          dataType: "json",
          success:function(data){
            $("#show_table").html(data);
            // console.log(data);
          }
        });
    });

    $(document).on('click','#print_receipt',function(){
      var receipt_no = $("#receipt_no").val();
      var from_date = $("#from_date_print").val();
      var to_date = $("#to_date_print").val();
      var employee_id = $("#employee_id_print").val();
      var employee_name = $("#employee_name_print").val();
      var printing_date = $("#printing_date").val();
      var printing_time = $("#printing_time").val();
      var in_word = $("#in_word").val();
      var total_pay = $("#total_pay").val();
      // alert(total_pay);
      $.ajax({
            url: "ajax_save_money_receipt.php",
            method: "POST",
            data:{receipt_no:receipt_no,from_date:from_date,to_date:to_date,employee_id:employee_id,employee_name:employee_name,printing_date:printing_date,printing_time:printing_time,in_word:in_word,total_pay:total_pay},
            dataType: "json",
            success:function(data){
              
            }
          });
      });
  });

  
  function printContent(el){
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