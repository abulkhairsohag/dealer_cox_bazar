<?php include_once('include/header.php'); ?>
<?php 

$user_id = Session::get("user_id");
$user_type = Session::get("user_type");

if ($user_type == "employee") {
  $query = "SELECT * FROM employee_main_info WHERE serial_no = '$user_id' ";
  $get_emp_info =  $dbOb->find($query);
  $photo = $get_emp_info['photo'];
  $designation = $get_emp_info['designation'];
  $mobile_no = $get_emp_info['mobile_no'];
  $address = $get_emp_info['present_address'];
  $email = $get_emp_info['email'];
  $user_name = $get_emp_info['user_name'];
  $name = $get_emp_info['name'];

}elseif ($user_type == "user") {
  $query = "SELECT * FROM user WHERE serial_no = '$user_id' ";
  $get_user_info =  $dbOb->find($query);
  $photo = $get_user_info['photo'];
  $designation = $get_user_info['designation'];
  $mobile_no = $get_user_info['mobile_no'];
  $address = $get_user_info['address'];
  $email = $get_user_info['email'];
  $user_name = $get_user_info['user_name'];
  $name = $get_user_info['name'];

}elseif ($user_type == "admin") {
  $query = "SELECT * FROM login WHERE serial_no = '$user_id' ";
  $get_admin_info =  $dbOb->find($query);
  $photo = $get_admin_info['photo'];
  $designation = $get_admin_info['designation'];
  $mobile_no = $get_admin_info['mobile_no'];
  $address = $get_admin_info['address'];
  $email = $get_admin_info['email'];
  $user_name = $get_admin_info['user_name'];
  $name = $get_admin_info['name'];
  $display = "none";
}
 ?>

<div class="right_col" role="main">
 <div class="row">
  <!-- page content -->

<?php 
include_once("class/Database.php");
$dbOb = new Database();

$query = "SELECT * FROM profile";
$get_profile_info = $dbOb->find($query);
 ?>


  <!-- Profile Information starts from here  -->

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Profile Details</h2>
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

        <table class="table" style="box-shadow: 6px 7px 7px 4px #000;background: #f2ffe6">

          <tbody>

            <tr>
              <td></td>
              <td align="">Photo</td>
              <?php if ($photo) { ?>
              <td id='show_photo'><img src="<?php echo $photo; ?>" style="width: 150px; height: 180px; border-radius: 20%" alt=""></td>
             <?php }else{ ?>
             <td id='show_photo'><img src="images/dummy.png" style="width: 150px; height: 180px; border-radius: 20%" alt=""></td>
           <?php  } ?>
            </tr>
            <tr>
              <td></td>
              <td align="">Name</td>
              <td id='show_organization_name'><?php echo $name; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">User Name</td>
              <td id='show_organization_name'><?php echo $user_name; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Designation</td>
              <td id='show_organization_name'><?php echo $designation; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Address</td>
              <td id='show_mobile_no'><?php echo $address; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Phone Number</td>
              <td id='show_phone_no'><?php echo $mobile_no; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Email</td>
              <td id='show_email'><?php echo $email; ?></td>
            </tr>
            <tr>
              <td colspan="2" align="right">
                <button style="display: <?php echo $display ?>" class="btn btn-success edit_photo" id="<?php echo $user_id; ?>" data-toggle="modal" data-target="#update_logo_modal" >Update Profile Photo</button>
              </td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>  
<!-- profile Information ends here  -->


<!-- Modal For Updating Logo and Icon data  -->
<div class="modal fade" id="update_logo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Update Profile Photo</h3>
        <div style="float:right;">

        </div>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="background: #f2ffe6">

              <div class="x_content">
                <br />

  <!-- Form for updating logo and Favicon starts from here  -->
                <form id="profile_image_update" enctype="multipath/form-data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group">
                    <label for="profile_photo" class="control-label col-md-3 col-sm-3 col-xs-12">Photo <span style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="file" name="profile_photo" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="favicon" class="control-label col-md-3 col-sm-3 col-xs-12">User Type</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" name="user_type" class="form-control col-md-7 col-xs-12" value="<?php echo $user_type ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="favicon" class="control-label col-md-3 col-sm-3 col-xs-12">User ID</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" name="user_id" class="form-control col-md-7 col-xs-12" value="<?php echo $user_id ?>">
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <input type="submit" id="submit_profile_photo" name="submit_profile_photo" class="btn btn-success" value="Update">
                    </div>
                  </div>


                </form> <!--Form for upadating logo and favicon ends here-->
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
</div> <!-- End of modal for updating logo and favicon data-->



<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>
<script>
  
  $(document).ready(function(){

          // now we are going to update and insert data 
      $(document).on('submit','#profile_image_update',function(e){
        e.preventDefault();
        var formData = new FormData($("#profile_image_update")[0]);
        formData.append('submit','submit');

        $("#user_type").val("");
        $("#user_id").val("");

   // console.log(formData);


        $.ajax({
          url:'ajax_update_profile_photo.php',
          data:formData,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            console.log(data);
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
            if (data.type == 'success') {
              $("#update_logo_modal").modal("hide");
              var photo = '<img src="./'+data.uploaded_image+'" style="width: 150px; height: 180px; border-radius: 20%" alt="">';
              console.log(data.uploaded_image);
              $("#show_photo").html(photo);
              
            }
          },
          error:function(data){
              console.log(data)
          }
        });
    }); // end of insert and update 

  });
</script>
</body>
</html>
