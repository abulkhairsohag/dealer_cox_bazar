<?php include_once('include/header.php'); ?>
<div class="right_col" role="main">
  <div class="row">
  </div>
  <!-- page content -->
  <?php 
  include_once("class/Database.php");
  $dbOb = new Database();
  $serial_no = "";
  if (isset($_GET['serial_no'])) {
    $serial_no = $_GET['serial_no'];
            //echo $serial_no;
  }
  $query = "SELECT * FROM employee_main_info WHERE serial_no ='$serial_no'";
  $get_basic_info = $dbOb->find($query);
  ?>
  <div class="sohag" >Information Of : <?php echo $get_basic_info['name']; ?></div>


  <div class="container" >

    <ul class="nav nav-tabs bg-success" style="width: 100%">
      <li class="active"><a data-toggle="tab" href="#basic_informaito">Basic Information</a></li>
      <li><a data-toggle="tab" href="#office_information">Office Information</a></li>
      <li><a data-toggle="tab" href="#academic_information">Academical Information</a></li>
      <li><a data-toggle="tab" href="#document_information">Document Information</a></li>
      <li><a data-toggle="tab" href="#account_information">Account Information</a></li>
      <li><a data-toggle="tab" href="#helth_information">Helth Information</a></li>
    </ul>

    <div class="tab-content">
      <!-- Basic Information -->
      <div id="basic_informaito" class="tab-pane fade in active" style="background: white;padding-top: 15px;">
        <h3 style="padding-left: 15px">Basic Information</h3>
        <div class="col-md-12" align="center" style="margin-bottom: 30px">
         <img src="<?php echo $get_basic_info['photo'] ?>" alt="image of <?php echo($get_basic_info['name']) ?>" width = '170px'>
       </div>
       <table class="table table-sm " >
        <tbody>
          <tr>
            <td style="font-size: 15px">Name : <span id="name"><?php echo $get_basic_info['name']; ?></span></td>
            <td style="font-size: 15px">Father's Name : <span id="fathers_name"><?php echo $get_basic_info['fathers_name']; ?></span></td>
            <td style="font-size: 15px">Mother's Name : <span id="mothers_name"><?php echo $get_basic_info['mothers_name']; ?></span></td>
            <td style="font-size: 15px">Spouse's Name : <span id="spouses_name"><?php echo $get_basic_info['spouses_name']; ?></span></td>
          </tr>

          <tr>
            <td style="font-size: 15px">Present Address : <span id="present_address"><?php echo $get_basic_info['present_address']; ?></span></td>
            <td style="font-size: 15px">Permanent Address : <span id="permanent_address"><?php echo $get_basic_info['permanent_address']; ?></span></td>
            <td style="font-size: 15px">Date Of Birth : <span id="birth_date"><?php echo $get_basic_info['birth_date']; ?></span></td>
            <td style="font-size: 15px">National ID No : <span id="nid_no"><?php echo $get_basic_info['nid_no']; ?></span></td>
          </tr>

          <tr>
            <td  style="font-size: 15px">Birth Certificate No : <span id="birth_certificate_no"><?php echo $get_basic_info['birth_certificate_no']; ?></span></td>

            <td style="font-size: 15px">Gender : <span id="gender"><?php echo $get_basic_info['gender']; ?></span></td>
            <td style="font-size: 15px">Nationality: <span id="nationality"><?php echo $get_basic_info['nationality']; ?></span></td>
            <td style="font-size: 15px">Religion : <span id="religion"><?php echo $get_basic_info['religion']; ?></span></td>
          </tr>
          <tr>
            <td  style="font-size: 15px">Mobile Number : <span id="mobile_no"><?php echo $get_basic_info['mobile_no']; ?></span></td>

            <td style="font-size: 15px">Phone Number : <span id="phone_no"><?php echo $get_basic_info['phone_no']; ?></span></td>
            <td colspan="2" style="font-size: 15px">Email: <span id="email"><?php echo $get_basic_info['email']; ?></span></td>

          </tr>
          <tr>
            <td colspan="4"></td>
          </tr>

        </tbody>
      </table>
    </div>
    <!-- Office Information -->
    <div id="office_information" class="tab-pane fade" style="background: white;padding-top: 15px;">
      <h3 style="padding-left: 15px">Office Information</h3>

      <table class="table table-sm " style="margin-top: 20px">
        <tbody>
          <tr>
            <td style="font-size: 15px">ID No : <span id="id_no"><?php echo $get_basic_info['id_no']; ?></span></td>
            <td style="font-size: 15px">Area Name : <span id="area_name"><?php echo $get_basic_info['area_name']; ?></span></td>
            <td style="font-size: 15px">Designation : <span id="mothers_name"><?php echo $get_basic_info['designation']; ?></span></td>
            <td style="font-size: 15px">Joining Date : <span id="spouses_name"><?php echo $get_basic_info['joining_date']; ?></span></td>
          </tr>
          <tr>
            <td style="font-size: 15px">User ID : <span id="birth_date"><?php echo $get_basic_info['user_name']; ?></span></td>
            <td style="font-size: 15px">Password : <span id="gender"><?php echo $get_basic_info['password']; ?></span></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2" class="bg-success" style="text-align: center;">SALARY INFORMATION</td>
            <td></td>

          </tr>
          <tr>
            <td style="font-size: 15px">Basic Salary : <span id="basic_salary"><?php echo $get_basic_info['basic_salary']; ?></span></td>
            <td style="font-size: 15px">House Rent : <span id="house_rent"><?php echo $get_basic_info['house_rent']; ?></span></td>
            <td style="font-size: 15px">Medical Allowance : <span id="medical_allowance"><?php echo $get_basic_info['medical_allowance']; ?></span></td>
            <td style="font-size: 15px">Transport Allowance : <span id="transport_allowance"><?php echo $get_basic_info['transport_allowance']; ?></span></td>
          </tr>
          <tr>
            <td style="font-size: 15px">Insurance : <span id="insurance"><?php echo $get_basic_info['insurance']; ?></span></td>
            <td style="font-size: 15px">Comission : <span id="commission"><?php echo $get_basic_info['commission']; ?></span></td>
            <td style="font-size: 15px">Extra Over Time : <span id="extra_over_time"><?php echo $get_basic_info['extra_over_time']; ?></span></td>
            <td style="font-size: 15px">Total Salary : <span style="color: red" id="total_salary"><?php echo $get_basic_info['total_salary']; ?></span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Academical Information -->
    <div id="academic_information" class="tab-pane fade" style="background: white;padding-top: 15px;">
      <h3 style="padding-left: 15px">Academical Information</h3>
      <table class="table table-sm" style="margin-top: 20px">
        <thead>
          <tr>
            <th style="font-size: 15px">Exam Name</th>
            <th style="font-size: 15px">Institute</th>
            <th style="font-size: 15px">Board/University</th>
            <th style="font-size: 15px">Group/Dept</th>
            <th style="font-size: 15px">Result</th>
            <th style="font-size: 15px">Year</th>
          </tr>
        </thead>
        <tbody>

          <?php 
          $query = "SELECT * FROM  employee_academic_info WHERE main_tbl_serial_no = '$serial_no'";
          $get_academic_info = $dbOb->select($query);
          if ($get_academic_info) {
            while ($row = $get_academic_info->fetch_assoc()) {
              ?>
              <tr>
                <td><span id="exam_name"><?php echo $row['exam_name']; ?></span></td>
                <td><span id="institute"><?php echo $row['institute']; ?></span></td>
                <td><span id="board_university"><?php echo $row['board_university']; ?></span></td>
                <td><span id="group_name"><?php echo $row['group_name']; ?></span></td>
                <td><span id="result"><?php echo $row['result']; ?></span></td>
                <td><span id="passing_year"><?php echo $row['passing_year']; ?></span></td>
              </tr>
              <?php
            }
          }
          ?>
          <tr>

          </tr>
        </tbody>
      </table>
    </div>
    <!-- Document Information -->
    <div id="document_information" class="tab-pane fade" style="background: white;padding-top: 15px;">
      <h3 style="padding-left: 15px">Document Information</h3>
      <?php 
        $query = "SELECT * FROM employee_document_info WHERE main_tbl_serial_no = '$serial_no'";
        $get_document = $dbOb->find($query);
       ?>

       <table class="table table-sm " style="margin-top: 20px" >
        <thead>
          <tr>
            <th style="font-size: 15px">Document Name</th>
            <th style="font-size: 15px">Document Type</th>
            <th style="font-size: 15px">Description</th>
            <th style="font-size: 15px">Uploaded Document</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td ><span id="account_name"><?php echo $get_document['document_name']; ?></span></td>
            <td ><span id="bank_name"><?php echo $get_document['document_type']; ?></span></td>
            <td ><span id="branch_name"><?php echo $get_document['description']; ?></span></td>
            <td ><span id="account_no"><a download="" href="<?php echo $get_document['upload_document']; ?>">Download Document</a></span></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Account Information -->
    <div id="account_information" class="tab-pane fade" style="background: white;padding-top: 15px;">
      <h3 style="padding-left: 15px">Account Information</h3>
       <table class="table table-sm " style="margin-top: 20px" >
        <thead>
          <tr>
            <th style="font-size: 15px">Accunt Name</th>
            <th style="font-size: 15px">Bank Name </th>
            <th style="font-size: 15px">Branch Name</th>
            <th style="font-size: 15px">Account Number</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td ><span id="account_name"><?php echo $get_basic_info['account_name']; ?></span></td>
            <td ><span id="bank_name"><?php echo $get_basic_info['bank_name']; ?></span></td>
            <td ><span id="branch_name"><?php echo $get_basic_info['branch_name']; ?></span></td>
            <td ><span id="account_no"><?php echo $get_basic_info['account_no']; ?></span></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Helth Information -->
    <div id="helth_information" class="tab-pane fade" style="background: white;padding-top: 15px;">
      <h3 style="padding-left: 15px">Helth Information</h3>
        <table class="table table-sm " style="margin-top: 20px">
        <thead>
          <tr>
            <th style="font-size: 15px">Height</th>
            <th style="font-size: 15px">Weight</th>
            <th style="font-size: 15px">Blood Gorup</th>
            <th style="font-size: 15px">Body Identify Mark</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td ><span id="height"><?php echo $get_basic_info['height']; ?></span></td>
            <td ><span id="wieght"><?php echo $get_basic_info['wieght']; ?></span></td>
            <td ><span id="blood_group"><?php echo $get_basic_info['blood_group']; ?></span></td>
            <td ><span id="body_identify_mark"><?php echo $get_basic_info['account_no']; ?></span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- /page content -->
</div>
</div>
<?php include_once('include/footer.php'); ?>


<script>
  $(document).ready(function(){
//this section is for adding multiple fields for inserting data in education table
$("#add_more").click(function(){
  $('#edu_info_table').append('<tr><td><input type="text" class="form-control" id="exam_name" name="exam_name[]" required=""></td><td><input type="text" class="form-control" id="institute" name="institute[]" required=""></td><td><input type="text" class="form-control" id="board_university" name="board_university[]" required=""></td><td><input type="text" class="form-control" id="group_name" name="group_name[]" required=""></td><td><input type="number" min="0" step="0.01" class="form-control" id="result" name="result[]" required=""></td><td><input type="number" min="0" step="1" class="form-control" id="passing_year" name="passing_year[]" required=""></td><td><button type="button" class="btn btn-danger remove_button"><i class="fas fa-times"></i></button></td></tr>');
});
// this section is for removing row from education table
$(document).on('click','.remove_button', function(e) {
  var remove_row = $(this).closest("tr");
  remove_row.remove();
});

$(document).on('keyup blur',"#basic_salary",function(){
  calculate_salary();
});

$(document).on('keyup blur',"#house_rent",function(){
  calculate_salary();
});

$(document).on('keyup blur',"#medical_allowance",function(){
  calculate_salary();
});

$(document).on('keyup blur',"#transport_allowance",function(){
  calculate_salary();
});

$(document).on('keyup blur',"#insurance",function(){
  calculate_salary();
});

$(document).on('keyup blur',"#commission",function(){
  calculate_salary();
});

$(document).on('keyup blur',"#extra_over_time",function(){
  calculate_salary();
});

// now we are going to submit form ie. inserting data 

$(document).on('submit','#add_data_form',function(e){
  e.preventDefault();
  var formData = new FormData($("#add_data_form")[0]);
  formData.append("submit","submit");

  $.ajax({
    url:"ajax_add_employee.php",
    data:formData,
    type:"POST",
    dataType:"json",
    cache:false,
    processData:false,
    contentType:false,
    success:function(data){
     swal({
      title: data.type,
      text: data.message,
      icon: data.type,
      button: "Done",
    });

     if (data.type == 'success') {
      $("#id_no").val(""); 
      $("#area_name").val("");  
      $("#designation").val("");  
      $("#joining_date").val(""); 
      $("#basic_salary").val("");  
      $("#house_rent").val(""); 
      $("#medical_allowance").val(""); 
      $("#transport_allowance").val(""); 
      $("#insurance").val("");  
      $("#commission").val(""); 
      $("#extra_over_time").val(""); 
      $("#total_salary").val("");  

          //Basic Informaion
          $("#name").val("");  
          $("#fathers_name").val(""); 
          $("#mothers_name").val(""); 
          $("#spouses_name").val(""); 
          $("#birth_date").val(""); 
          $("#gender").val(""); 
          $("#nid_no").val("");
          $("#birth_certificate_no").val("");
          $("#nationality").val(""); 
          $("#religion").val(""); 

          $("#photo").val(""); 

          //Contact Information
          $("#present_address").val(""); 
          $("#permanent_address").val(""); 
          $("#mobile_no").val(""); 
          $("#phone_no").val(""); 
          $("#email").val(""); 

          // education details
          $("#exam_name").val(""); 
          $("#institute").val(""); 
          $("#board_university").val(""); 
          $("#group_name").val("");
          $("#result").val(""); 
          $("#passing_year").val(""); 

          //document Information
          $("#document_name").val("");  
          $("#document_type").val("");  
          $("#description").val("");  
          $("#upload_document").val("");  

          // Account Information 
          $("#account_name").val("");  
          $("#bank_name").val("");  
          $("#branch_name").val("");  
          $("#account_no").val("");  

          // Helth Information 
          $("#height").val("");  
          $("#wieght").val(""); 
          $("#blood_group").val(""); 
          $("#body_identify_mark").val("");  

        }
      }

    });
});

// the following section is for checking if any required fild is empty or not . if empty it will show warning
// $(document).on('click','#submit_employee',function(){

//   //Office Information
//   var id_no =  $('#id_no').val();
//   var area_name =  $('#area_name').val();
//   var designation =  $('#designation').val();
//   var joining_date =  $('#joining_date').val();
//   var basic_salary =  $('#basic_salary').val();
//   var  house_rent =  $('#house_rent').val();
//   var medical_allowance =  $('#medical_allowance').val();
//   var transport_allowance =  $('#transport_allowance').val();
//   var insurance =  $('#insurance').val();
//   var commission =  $('#commission').val();
//   var extra_over_time =  $('#extra_over_time').val();

//   //Basic Informaion
//   var name =  $('#name').val();
//   var fathers_name =  $('#fathers_name').val();
//   var mothers_name =  $('#mothers_name').val();
//   var birth_date =  $('#birth_date').val();
//   var gender =  $('#gender').val();
//   var nid_no =  $('#nid_no').val();
//   var nationality =  $('#nationality').val();
//   var religion =  $('#religion').val();
//   var photo =  $('#photo').val();

//   //Contact Information
//   var present_address =  $('#present_address').val();
//   var permanent_address =  $('#permanent_address').val();
//   var mobile_no =  $('#mobile_no').val();

//   // Account Information 
//   var account_name =  $('#account_name').val();
//   var bank_name =  $('#bank_name').val();
//   var branch_name =  $('#branch_name').val();
//   var account_no =  $('#account_no').val();

//   // Helth Information
//   var height =  $('#height').val();
//   var wieght =  $('#wieght').val();
//   var blood_group =  $('#blood_group').val();
// });
}); // end of document ready

// the following function is for auto calculating the total salary of the enployee 
function calculate_salary(){
  var basic_salary = $("#basic_salary").val();
  var house_rent = $("#house_rent").val();
  var medical_allowance = $("#medical_allowance").val();
  var transport_allowance = $("#transport_allowance").val();
  var insurance = $("#insurance").val();
  var commission = $("#commission").val();
  var extra_over_time = $("#extra_over_time").val();

  if (basic_salary == "") {
    basic_salary = 0;
  }

  if (house_rent == "") {
    house_rent = 0;
  }

  if (medical_allowance == "") {
    medical_allowance = 0;
  }

  if (transport_allowance == "") {
    transport_allowance = 0;
  }

  if (insurance == "") {
    insurance = 0;
  }

  if (commission == "") {
    commission = 0;
  }

  if (extra_over_time == "") {
    extra_over_time = 0;
  }

  var total_salary = parseFloat(basic_salary)+parseFloat(house_rent)+parseFloat(medical_allowance)+parseFloat(transport_allowance)+parseFloat(insurance)+parseFloat(commission)+parseFloat(extra_over_time);
    //console.log(total_salary);
    $("#total_salary").val(total_salary);
  }



</script>
</body>
</html>