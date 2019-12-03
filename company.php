<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('company')){
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
          <h2>Company List</h2>
          <div class="row float-right" align="right">

            <?php 

            if (permission_check('add_new_company_button')) {
             ?>
             <a href="" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Company</a>
             <?php 
           }
           ?>
         </div>
         <div class="clearfix"></div>
       </div>
       <div class="x_content">

        <table id="datatable-buttons" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th  style="text-align: center;">Sl No.</th>
              <th  style="text-align: center;">Company Name</th>
              <th  style="text-align: center;">Responder Name</th>
              <th  style="text-align: center;">Mobile</th>
              <th  style="text-align: center;">Email</th>
              <th  style="text-align: center;">Product Type</th>
              <th style="text-align: center;">Action</th>
            </tr>
          </thead>


          <tbody id="tbl_body">
            <?php 
            include_once("class/Database.php");
            $dbOb = new Database();
            $query = "SELECT * FROM company ORDER BY serial_no DESC";
            $get_company = $dbOb->select($query);
            if ($get_company) {
              $i=0;
              while ($row = $get_company->fetch_assoc()) {
                $i++;
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row['company_name'] ?></td>
                  <td><?php echo $row['responder_name'] ?></td>
                  <td><?php echo $row['mobile_no'] ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['product_type'] ?></td>
                  <td align="center">
                    
                    <?php 

                    if (permission_check('company_view_button')) {
                     ?>
                     <a class="badge bg-green view_data" id="<?php echo($row['serial_no']) ?>"  data-toggle="modal" data-target="#view_modal" style="margin:2px">View</a> 

                     <?php
                   }

                   ?>
                   <?php 
                   if (permission_check('company_edit_button')) {
                     ?>
                     <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                     <?php
                   }

                   ?>
                   <?php 

                   if (permission_check('company_delete_button')) {
                     ?>
                     <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 

                     <?php
                   }

                   ?>  
                 </td>
               </tr>

               <?php
             }
           }
           ?>


         </tbody>
       </table>
     </div>
   </div>
 </div>




 <!-- Modal For Adding and Updating data  -->
 <div class="modal fade" id="add_update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title" id="ModalLabel" style="color: white"></h3>
        <div style="float:right;">

        </div>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="background: #f2ffe6">

              <div class="x_content" style="background: #f2ffe6">
                <br />
                <!-- Form starts from here -->
                <form id="form_edit_data" method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">

                     <!--  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="category_name" id="category_name" required="" class="form-control col-md-7 col-xs-12">
                            <option value="">Select Category</option>
                            <?php 
                            // $query = "SELECT * FROM category";
                            // $get_category = $dbOb->select($query);
                            // if ($get_category) {
                            //   while ($row = $get_category->fetch_assoc()) {
                            //     ?>
                            //     <option value="<?php //echo($row['category_name']) ?>"><?php //echo($row['category_name']) ?></option>
                            //     <?php
                            //   }
                            // }
                            ?>
                          </select>
                        </div>
                      </div> -->

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Company Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  required=""id="company_name" name="company_name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Responder Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="responder_name" name="responder_name" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Responder Designation <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="respoder_designation" name="respoder_designation" class="form-control col-md-7 col-xs-12" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea type="text" required="" id="address" name="address" class="form-control col-md-7 col-xs-12" ></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" required="" id="mobile_no" name="mobile_no" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone_no" name="phone_no" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Fax </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="fax" name="fax" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" required="" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="Example: abulkhairsohag@gmail.com" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Website </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="url" id="website" name="website" class="form-control col-md-7 col-xs-12" placeholder="Example: http://www.sattit.com" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Type </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="product_type" name="product_type" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Quality </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="product_quality" name="product_quality" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description  </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" ></textarea>
                        </div>
                      </div>




                      <div style="display: none;">
                        <input type="number" id="edit_id" name="edit_id">
                      </div>



                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary" >Reset</button>
                          <button type="submit" class="btn btn-success" id="submit_button"></button>
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
    </div> <!-- End of modal for  Adding and Updating data-->



    <!-- Modal For Showing data  -->
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " style="width: 700px" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #006666">
            <h3 class="modal-title" id="ModalLabel" style="color: white">Company Information In Detail</h3>
            <div style="float:right;">

            </div>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="background: #f2ffe6">

                  <div class="x_content" style="background: #f2ffe6">
                    <br />



                    <!-- Table  -->
                    <table class="table table-bordered" style="background: white">


                      <!-- Table body -->
                      <tbody>
                        <tr>
                          <td><h5>Responder Name</h5></td>
                          <td><h5 id="responder_name_show"></h5></td>
                        </tr>
                        <tr>
                          <td><h5>Responder Designation</h5></td>
                          <td><h5 id="respoder_designation_show"></h5></td>
                        </tr>
                        <tr>
                          <td><h5>Company Name</h5></td>
                          <td><h5 id="company_name_show"></h5></td>
                        </tr>
                     <!--  <tr>
                        <td><h5>Category</h5></td>
                        <td><h5 id="category_name_show"></h5></td>
                      </tr> -->
                      <tr>
                        <td><h5>Address</h5></td>
                        <td><h5 id="address_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Mobile Number</h5></td>
                        <td><h5 id="mobile_no_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Phone Number</h5></td>
                        <td><h5 id="phone_no_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Fax</h5></td>
                        <td><h5 id="fax_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Email</h5></td>
                        <td><h5 id="email_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Website</h5></td>
                        <td><h5 id="website_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Product Type</h5></td>
                        <td><h5 id="product_type_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Product Quality</h5></td>
                        <td><h5 id="product_quality_show"></h5></td>
                      </tr>
                      <tr>
                        <td><h5>Description</h5></td>
                        <td><h5 id="description_show"></h5></td>
                      </tr>
                    </tbody>
                    <!-- Table body -->
                  </table>
                  <!-- Table  -->





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
  </div> <!-- End of modal for  Showing data-->





  <!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Company Information");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");
      //alert(serial_no_edit);
      $.ajax({
        url:"ajax_company.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#category_name").val(data.category_name);
          $("#company_name").val(data.company_name);
          $("#responder_name").val(data.responder_name);
          $("#respoder_designation").val(data.respoder_designation);
          $("#address").val(data.address);
          $("#mobile_no").val(data.mobile_no);
          $("#phone_no").val(data.phone_no);
          $("#user_name").val(data.user_name);
          $("#fax").val(data.fax);
          $("#email").val(data.email);
          $("#website").val(data.website);
          $("#product_type").val(data.product_type);
          $("#product_quality").val(data.product_quality);
          $("#description").val(data.description);
          $("#edit_id").val(data.serial_no);
        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add New Company Information");
      $("#submit_button").html("Save");

      $("#category_name").val("");
      $("#company_name").val("");
      $("#responder_name").val("");
      $("#respoder_designation").val("");
      $("#address").val("");
      $("#mobile_no").val("");
      $("#phone_no").val("");
      $("#user_name").val("");
      $("#fax").val("");
      $("#email").val("");
      $("#website").val("");
      $("#product_type").val("");
      $("#product_quality").val("");
      $("#description").val("");
      $("#edit_id").val("");
    });

    // now we are going to insert and update information by submitting form 
    $(document).on('submit','#form_edit_data',function(e){
      e.preventDefault();
      var formData = new FormData($("#form_edit_data")[0]);
      formData.append('submit','submit');
      $.ajax({
        url:"ajax_company.php",
        data:formData,
        type:'POST',
        dataType:"json",
        cache: false,
        processData: false,
        contentType: false,
        success:function(data){
         swal({
          title: data.type,
          text: data.message,
          icon: data.type,
          button: "Done",
        });
         if (data.type == 'success') {
           $("#add_update_modal").modal("hide"); 
           show_data_table();
         }

       }
     });
    }); // end of form submission

  // now the following section will be used to delete data from database 
  $(document).on('click','.delete_data',function(){
    var delete_id = $(this).attr("id");


    swal({
      title: "Are you sure To Delete?",
      text: "It Will Delete All Related Information.",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url:"ajax_company.php",
          data:{delete_id:delete_id},
          type:"POST",
          dataType:'json',
          success:function(data){
           swal({
            title: data.type,
            text: data.message,
            icon: data.type,
            button: "Done",
          });
           show_data_table();
         }
       });
      } 
    });

  });
// the following section is for showing data


$(document).on('click','.view_data',function(){

  var serial_no_edit = $(this).attr("id");
      // alert(serial_no_edit);
      $.ajax({
        url:"ajax_company.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          // $("#category_name_show").html(data.category_name);
          $("#company_name_show").html(data.company_name);
          $("#responder_name_show").html(data.responder_name);
          $("#respoder_designation_show").html(data.respoder_designation);
          $("#address_show").html(data.address);
          $("#mobile_no_show").html(data.mobile_no);
          $("#phone_no_show").html(data.phone_no);
          $("#user_name_show").html(data.user_name);
          $("#fax_show").html(data.fax);
          $("#email_show").html(data.email);
          $("#website_show").html(data.website);
          $("#product_type_show").html(data.product_type);
          $("#product_quality_show").html(data.product_quality);
          $("#description_show").html(data.description);
        }
      });

    });


    }); // end of document ready

  // the following function is declared for showing table data after adding data and upadating and deleting data 
  function show_data_table()
  {
    $.ajax({
      url:"ajax_company.php",
      data:{sohag:"sohag"},
      type:"POST",
      dataType:"text",
      success:function(data_tbl){
        sohag.destroy();
        $("#tbl_body").html(data_tbl);
        init_DataTables();
      }
    });
  }
</script>

</body>
</html>
