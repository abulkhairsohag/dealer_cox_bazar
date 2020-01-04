<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('attendance_info')){
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
        <h2 class="panel-title" style="color: white"><h3>Attendance</h3></h2>
      </div>
      <div class="panel-body">


       <div class="form-group col-md-12" id="date_of_attendance">
        <div class="col-md-1"></div>
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" align="right">Attendance Date<span class="required" style="color: red">*</span></label>
        <div class="col-md-4 col-sm-6 col-xs-12">
         <?php $today = date("d-m-Y");  ?>
         <input type="text" class="form-control datepicker " id='attendance_date' name="attendance_date" value="<?php echo $today  ?>" required="" readonly="">
       </div>
     </div>


     <div class="form-group" style="margin-bottom: 20px;" align="center">

      <div class="col-md-12 col-sm-6 col-xs-8">
                <?php
if (permission_check('attendance_view_record_button')) {
  ?>
        <button class="btn btn-success" id="view_record">View Record</button>
                    <?php } ?>
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
      var attendance_date = $("#attendance_date").val();
      $("#show_table").html("");

      $.ajax({
        url: "ajax_employee_attendance_info.php",
        method: "POST",
        data:{attendance_date:attendance_date},
        dataType: "json",
        success:function(data){
          $("#show_table").html(data);
        }
      });

    });

    

    $(document).on('change','.attendance_status',function(){
      var employee_id = $(this).attr("id");
      var attendance_date = $(this).attr("data-date");
      var attendance = '';
      if (this.checked) {
        attendance = '1';
      }else{
        attendance = '0';

      }
      $.ajax({
        url:"ajax_employee_attendance_info.php",
        data:{employee_id:employee_id,attendance:attendance,date:attendance_date},
        type:"POST",
        dataType:'json',
        success:function(data){
          swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
              // get_data_table();
            }
          });
    });
  });
</script>

</body>
</html>