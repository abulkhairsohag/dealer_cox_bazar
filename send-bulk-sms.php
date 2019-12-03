<?php include_once('include/header.php'); 

if(!permission_check('send_sms')){
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
          <h2>Send Daily Report To Admins</h2>
          <div class="row float-right" align="right">
             
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
         
                <div class="form-group">
                    <label for="sms">Date</label>
                    <!-- <textarea class="form-control" name="from_date" id="from_date" cols="50" rows="7">   <?php echo nl2br("One line.\n Another line."); ?></textarea> -->
                    <input type="text" class="form-control datepicker" readonly value="<?php echo date('d-m-Y')?>" name="from_date" id="from_date" >
                </div>
                <div class="form-group">
                    <label for="sms">Your SMS</label>
                    <textarea class="form-control" name="sms" id="sms" cols="50" rows="7"></textarea>
                </div>
                <div class="form-group">
                    <label for="phone_numbers">Phone Numbers</label>
                    <input type="text" class="form-control" name="phone_numbers" id="phone_numbers" value="" placeholder="01xxxxxxxxx,01xxxxxxxxx.........">
                </div>
                <div class="form-group" align="center">
                  <span id="send_btn">

                    <button class="btn btn-success" id="send_sms_button">Send SMS</button>
                  </span>
                  <span id="generate_btn">

                    <button class="btn btn-primary" id="generate_sms">generate SMS</button>
                  </span>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
          
        </div>
      </div>
    </div>







    <!-- /page content -->

  </div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){
$(document).on('click','#generate_sms',function(){
  var from_date = $("#from_date").val();
//  var to_date = $("#from_date").val();
// alert(from_date);
    $.ajax({
        type : "post",
        url : "ajax_sms_generator.php",
        data : {
          from_date:from_date
        },
        dataType:'json',
        success:function(data){
          // var sohag = ('this\n has\n newlines').wrap('<pre />');

          $("#sms").val(data);

        }
  });
});


 $(document).on('click','#send_sms_button',function(){
  var message = $("#sms").val();
  var phone_numbers = $("#phone_numbers").val();

  if (message == "") {
    alert("Please Generate SMS First");
  }else{
      $.ajax({
          type : "post",
          url : "http://sms.amaruddog.com/smsapi",
          data : {
            "api_key" : "C20042305daeab63d5b1c6.50180947",
            "senderid" : "8804445629107",
            "type" : "text/unicode",
            "msg" : message,
            "contacts" : phone_numbers
          },
          dataType:'json',
          success:function(data){

            console.log(data);
            

          }
    });
  }

 });



  }); // end of document ready function 


</script>

</body>
</html>