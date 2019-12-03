<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');

              include_once('class/Database.php');
              $dbOb = new Database();

              $query = "SELECT * FROM profile";
              $GET =  $dbOb->find($query);
              $logo = $GET['logo'];
              $favicon = $GET['favicon'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo $favicon?>" type="image/ico" />
  <?php 
      
      $company_profile = '';
      $query = "SELECT * FROM profile";
      $get_profile = $dbOb->select($query);
      if ($get_profile) {
          $company_profile = $get_profile->fetch_assoc();
      }
  
  ?>
  <title><?php echo $company_profile['organization_name'] ?> </title>

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- select2 -->
  <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">


  <!-- month peacker -->
  <link href="src/month_peacker.css" rel="stylesheet">
  

  <!-- Custom Theme Style -->
  <link href="build/css/custom.min.css" rel="stylesheet">

  <!-- Datatables -->
  <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- bootstrap-datetimepicker -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
  
  <!-- the following section is for accordian -->
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->


  <!-- switchery -->
<link rel="stylesheet" href="src/switchery.css" />
 <link rel="stylesheet" href="style.css"> 




  <!-- style for printing a table  -->
  <style type="text/stylesheet" media="print">
  .noprint{display:none}
</style>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <script>
   $(function () {

     $("#accordion").accordion({
       heightStyle: "content",
       collapsible : true, 
       active : false,
        animate: {
        duration: 600
          }
  
     });
   });
 </script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <style>
  .sohag{padding: 20px;text-align: center;background: #2A3F54;color: white; font-size: 30px;margin-bottom: 10px}
  .accordian_sohag{background: #006666;color: white;}
  .accordian_field{background: #F1F5F2}

  #accordion .ui-accordion-header {
  color: white;
  line-height: 25px;
  display: block;
  font-size: 17px;
  width: 100%;
  text-indent: 10px; 
}

}
</style>

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title text-center" style="border: 0;">
           
            <a href="./" class="site_title"><img src="<?php echo($logo) ?>" alt="" width="170px"></a>
          </div>

          <div class="clearfix" ></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix" >
<?php 
$user_id = Session::get("user_id");
$user_type = Session::get("user_type");

if ($user_type == "employee") {
  $query = "SELECT * FROM employee_main_info WHERE serial_no = '$user_id' ";
  $GET =  $dbOb->find($query);
  $photo = $GET['photo'];
}elseif ($user_type == "user") {
  $query = "SELECT * FROM user WHERE serial_no = '$user_id' ";
  $GET =  $dbOb->find($query);
  $photo = $GET['photo'];
}

 ?>
            <div class="profile_pic">
              <img src="<?php if($photo){ echo $photo; }else{echo "images/dummy.png";} ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
      
              <h2><?php echo Session::get("name");?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />
          <?php include_once('include/left_sidebar.php'); ?>
        </div>
      </div>

      <!-- top navigation -->
      <?php include_once('include/top_navigation.php'); ?>
      <!-- /top navigation -->
