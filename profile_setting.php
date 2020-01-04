<?php include_once('include/header.php'); ?>

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

              <td align="">Organization Name</td>
              <td id='show_organization_name'><?php echo $get_profile_info['organization_name']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Address</td>
              <td id='show_address'><?php echo $get_profile_info['address']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Mobile Number</td>
              <td id='show_mobile_no'><?php echo $get_profile_info['mobile_no']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Phone Number</td>
              <td id='show_phone_no'><?php echo $get_profile_info['phone_no']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Email</td>
              <td id='show_email'><?php echo $get_profile_info['email']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Website</td>
              <td id='show_website'><?php echo $get_profile_info['website']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">API URL</td>
              <td id='show_api_url'><?php echo $get_profile_info['api_url']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">License Code</td>
              <td id='show_license_code'><?php echo $get_profile_info['license_code']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td align="">Logo</td>
              <td id='show_logo'><img src="<?php echo $get_profile_info['logo']; ?>" width='50px' alt=""></td>
            </tr>
            <tr>
              <td></td>
              <td  align="">Favicon</td>
              <td id='show_favicon'><img src="<?php echo $get_profile_info['favicon']; ?>" width="50px" alt=""></td>
            </tr>
            <tr>
              <td colspan="2" align="right">
                <?php
if (permission_check('edit_info_button')) {
  ?>
                <button class="btn btn-primary edit_info" id="<?php echo($get_profile_info['serial_no']) ?>" data-toggle="modal" data-target="#edit_modal">Edit Info</button>
<?php
}
if (permission_check('update_logo_and_favicon_button')) {
  ?>
                <button class="btn btn-success edit_logo" id="<?php echo($get_profile_info['serial_no']) ?>" data-toggle="modal" data-target="#update_logo_modal" >Update Logo & Favicon</button>
<?php } ?>
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





<!-- Modal For editing data  -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Update Profile Details</h3>
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
                <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Organization Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="organization_name" name="organization_name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea type="text" id="address" name="address" required="required" class="form-control col-md-7 col-xs-12"></textarea> 
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Number<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="mobile_no" name="mobile_no" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="phone_no" name="phone_no" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Website</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="url" id="website" name="website" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">API URL<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" id="api_url" name="api_url" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">License Code<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" id="license_code" name="license_code" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>

                  <div class="form-group" style="display: none;">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Edit id number</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" id="edit_id" name="edit_id" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>



                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <input type="submit" id="submit_edit" name="submit_edit" class="btn btn-success" value="Update">
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











<!-- Modal For Updating Logo and Icon data  -->
<div class="modal fade" id="update_logo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Update Logo & Favicon</h3>
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
                <form id="from_logo_update" enctype="multipath/form-data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group">
                    <label for="favicon" class="control-label col-md-3 col-sm-3 col-xs-12">Favicon</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="file" id="favicon" name="favicon" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="logo" class="control-label col-md-3 col-sm-3 col-xs-12">Logo</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="file" id="logo" name="logo" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <input type="submit" id="submit_edit_logo" name="submit_edit_logo" class="btn btn-success" value="Update">
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
    
    $('#form_edit_data').on('submit',function(e){
      e.preventDefault();
      var form = $(this).serialize();
      //console.log(form);
      $.ajax({
        url : 'ajax_edit_profile.php?'+form+'&submit_edit=1',
        type : "Get",
        dataType : 'json',
        success : function(data){
          swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
          if (data.type == 'success') {
              $("#show_organization_name").html(data.organization_name);
              $("#show_address").html(data.address);
              $("#show_mobile_no").html(data.mobile_no);
              $("#show_phone_no").html(data.phone_no);
              $("#show_email").html(data.email);
              $("#show_website").html(data.website);
              $("#show_api_url").html(data.api_url);
              $("#show_license_code").html(data.license_code);

              $("#edit_modal").modal('hide');
          }
         // console.log(data);

        }
      });
    });

    $(document).on('click','.edit_info',function(){
      var serial_no_edit_info = $(this).attr("id");
      $.ajax({
        url : 'ajax_edit_profile.php',
        data : {serial_no_edit_info:serial_no_edit_info},
        type : 'POST',
        dataType : 'json',
        success : function(data){
          $("#organization_name").val(data.organization_name);
          $("#address").val(data.address);
          $("#mobile_no").val(data.mobile_no);
          $("#phone_no").val(data.phone_no);
          $("#email").val(data.email);
          $("#website").val(data.website);
          $("#api_url").val(data.api_url);
          $("#license_code").val(data.license_code);
          $("#edit_id").val(data.serial_no);
        }
      });
    });

    // the following section is for updating logo and favicon 

    $('#from_logo_update').on('submit',function(e){
      e.preventDefault();
      var serial_no_edit_logo = $(".edit_logo").attr("id");

      var formData = new FormData($("#from_logo_update")[0]);
      formData.append('submit_edit_logo', 'submit_edit_logo');
      formData.append('serial_no',serial_no_edit_logo);

      $.ajax({
        url : 'ajax_edit_profile.php',
        data : formData,
        type : "POST",
        dataType:'JSON',
        cache: false,
        processData: false,
        contentType: false,
        success : function(data){
        console.log(data);
          swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
          if (data.type = 'success') {
            setTimeout(function() {
              window.location.href= 'profile_setting.php';
            }, 1500);
          }
          
        }
      });
    });
  }); // end of document ready
</script>

</body>
</html>
