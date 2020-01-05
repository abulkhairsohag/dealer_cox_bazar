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
<div class="top_nav hidden-print">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav navbar-right">

        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="<?php if($photo){ echo $photo; }else{echo "images/dummy.png";} ?>" alt=""><?php echo Session::get("name");?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="profile.php"> Profile</a></li>
            <li>
              <a href="update-password.php">
                <span>Update Password</span>
              </a>
            </li>
            <li><a href="logout.php"><i class="fa fa-sign-out-alt pull-right"></i> Log Out</a></li>
          </ul>
        </li>
        <?php 
      
      $company_profile = '';
      $query = "SELECT * FROM profile";
      $get_profile = $dbOb->select($query);
      if ($get_profile) {
          $company_profile = $get_profile->fetch_assoc();
      }
  
  ?>
        <li ><h2 class="delar"><?php echo strtoupper($company_profile['organization_name']); ?></h2></li>
      </ul>
    </nav>
  </div>
</div>