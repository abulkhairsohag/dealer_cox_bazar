<?php include_once('include/header.php'); ?>
<?php 

$user_id = Session::get("user_id");
$user_type = Session::get("user_type");

include_once("class/Database.php");
$dbOb = new Database();


if (isset($_POST['pasword_update'])) {

  $old_pass = $_POST['old_pass'];
  $new_pass = $_POST['new_pass'];
  $con_pass = $_POST['con_pass'];

  $old_pass = mysqli_real_escape_string($dbOb->link, $old_pass);
  $new_pass = mysqli_real_escape_string($dbOb->link, $new_pass);
  $con_pass = mysqli_real_escape_string($dbOb->link, $con_pass);

  if ($old_pass == "" || $new_pass == "" || $con_pass == "") {
    echo "<span class='error'>Filed must not be empty</span>";
  }else{


if ($user_type == "employee") {
  $query = "SELECT * FROM employee_main_info WHERE serial_no = '$user_id' AND password = '$old_pass' ";
  $match_password =  $dbOb->find($query);
  if ($match_password) {
        $update = "UPDATE employee_main_info SET password = '$con_pass' WHERE serial_no = '$user_id' ";
        $update_password = $dbOb->update($update);
        if ($update_password) {
        $update_login = "UPDATE login SET password = '$con_pass' WHERE user_id = '$user_id' ";
        $update_login_pass = $dbOb->update($update_login);
        if ($update_login_pass) { 
                             ?>
                               <script>
                                   swal("Password Successfully updated!", "You clicked the button!", "success");
                               </script>
                            <?php 
                         } else{
                            ?>
                               <script>
                                   swal("error !!", "You clicked the button!", "error");
                               </script>
                            <?php 
                         }
  }
}else{ ?>
           <script>
               swal("Old Password Doesn't match !!", "You clicked the button!", "error");
           </script>
        <?php 
        }


}elseif ($user_type == "user") {
  $query = "SELECT * FROM user WHERE serial_no = '$user_id' AND password = '$old_pass' ";
  $match_password =  $dbOb->find($query);
  if ($match_password) {
        $update = "UPDATE user SET password = '$con_pass' WHERE serial_no = '$user_id' ";
        $update_password = $dbOb->update($update);
        if ($update_password) {
        $update_login = "UPDATE login SET password = '$con_pass' WHERE user_id = '$user_id' ";
        $update_login_pass = $dbOb->update($update_login);
        if ($update_login_pass) { 
                             ?>
                               <script>
                                   swal("Password Successfully updated!", "You clicked the button!", "success");
                               </script>
                            <?php 
                         } else{
                            ?>
                               <script>
                                   swal("error !!", "You clicked the button!", "error");
                               </script>
                            <?php 
                         }
  }
}else{ ?>
           <script>
               swal("Old Password Doesn't match !!", "You clicked the button!", "error");
           </script>
        <?php 
        }

}
}
}
?>

<div class="right_col" role="main">
 <div class="row">
  <!-- page content -->

  <!-- Profile Information starts from here  -->

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Password Update</h2>
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
          <form id="from_logo_update" enctype="multipath/form-data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="form-group">
                    <label for="favicon" class="control-label col-md-3 col-sm-3 col-xs-12">Old Password</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="password" id="old_pass" name="old_pass" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="favicon" class="control-label col-md-3 col-sm-3 col-xs-12">New Password</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="password" id="new_pass" name="new_pass" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="logo" class="control-label col-md-3 col-sm-3 col-xs-12">Re-Password</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="password" id="con_pass" name="con_pass" class="form-control col-md-7 col-xs-12" required="">
                      <div id="msg"></div>
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <input type="submit" id="submit_pass" name="pasword_update" class="btn btn-success" value="Update">
                    </div>
                  </div>
                </form> <!--Form for upadating logo and favicon ends here-->
      </div>
    </div>
  </div>
</div>  
<!-- profile Information ends here  -->

<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>
<script>
    $(document).ready(function(){
        $(document).on("blur","#con_pass",function(){
            var a = $("#con_pass").val();
            var b = $("#new_pass").val();
            if (a!=b) {
                $("#msg").html("<span style='color:red'>Re Password Doesn't match</span>");
                $("#submit_pass").hide();
            }else{
                $("#submit_pass").show();
                $("#msg").html("");
            }
            if (a == "") {
              $("#submit_pass").show();
            }
        });
    });
</script>
</body>
</html>
