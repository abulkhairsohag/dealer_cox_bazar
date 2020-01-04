<?php 
error_reporting(1);
include_once('class/Session.php');
include_once('class/Database.php');
include_once('helper/helper.php');

Session::init();
Session::checkLogin();
$dbOb = new Database();

if (isset($_POST['submit'])) {
	$username = validation($_POST['username']);
	$password = validation($_POST['password']);

	if (empty($username) || empty($password)) {
		$error = 'Ops! Username Or Password Must Not Be Empty.';
	}elseif (strlen($password)<5) {
		$error = "Ops! Be Careful, Password Length Must Not Be Less Than 5.";
	}else{
		// $password=md5($password);
		$password=$password;
		$query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
		$get_user = $dbOb->find($query);
		if ($get_user) {
			if ($get_user['user_type']  == 'user') {
				$user_serial_no = $get_user['user_id'];
				$query = "SELECT * FROM user_zone_permission WHERE user_serial_no = '$user_serial_no' ORDER BY serial_no DESC LIMIT 1";
				$get_user_zone_access = $dbOb->select($query);
				if ($get_user_zone_access) {
					$zone = $get_user_zone_access->fetch_assoc();
					$zone_serial_no = $zone['zone_serial_no'];
					$query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
					$get_zone_inf = $dbOb->select($query);
					$zone_name = '';
					if ($get_zone_inf) {
						$zone_inf = $get_zone_inf->fetch_assoc();
						$zone_name = $zone_inf['zone_name'];
						
						$ware_house_serial = $zone_inf['ware_house_serial_no'];
						$query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial'";
						$ware_house= $dbOb->select($query);
						if ($ware_house) {
							$ware_house_info = $ware_house->fetch_assoc();
							Session::set("zone_serial_no",$zone_serial_no);
							Session::set("zone_name",$zone_name);
							Session::set("ware_house_serial_login",$ware_house_info['serial_no']);
							Session::set("ware_house_name_login",$ware_house_info['ware_house_name']);
						}else{
							Session::set("zone_serial_no",'-1');
							Session::set("zone_name",'Ware House Of The Zone Not Found.');
							Session::set("ware_house_serial_login",'-1');
							Session::set("ware_house_name_login",'Ware House Not Found');
						}
					}else{
						Session::set("zone_serial_no",'-1');
						Session::set("zone_name",'Zone Not Found.');
					}

				}
			}
			Session::set("login",true);
			Session::set("name",$get_user['name']);
			Session::set("role",$get_user['role']);
			Session::set("user_id",$get_user['user_id']);
			Session::set("username",$get_user['username']);
			Session::set("password",$get_user['password']);
			Session::set("user_type",$get_user['user_type']);

			Session::set("message"," You Have Successfully Logged In.");
			header("location: index.php");
		}else{
			$error = "Sorry Buddy! You Have Entered Invalid Username And Password.";
		}
	}


}

$company_profile = '';
$query = "SELECT * FROM profile";
$get_profile = $dbOb->select($query);
if ($get_profile) {
	$company_profile = $get_profile->fetch_assoc();

}



?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="<?php echo $company_profile['favicon'];?>" type="image/ico" />
	<title><?php echo $company_profile['organization_name']?></title>
	<!--Made with love by Mutiullah Samim -->

	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<!--Custom styles-->
	<style>
		/* Made with love by Mutiullah Samim*/

		@import url('https://fonts.googleapis.com/css?family=Numans');

		html,body{
			background-size: cover;
			background-repeat: no-repeat;
			height: 100%;
			font-family: 'Numans', sans-serif;
		}

		.container{
			height: 100%;
			align-content: center;
		}

		.card{
			height: 380px;
			margin-top: auto;
			margin-bottom: auto;
			width: 400px;
			background-color: rgba(255, 255, 255, 0.55) !important;
		}

		.social_icon span{
			font-size: 60px;
			margin-left: 10px;
			color: #FFC312;
		}

		.social_icon span:hover{
			color: white;
			cursor: pointer;
		}

		.card-header h3{
			color: white;
		}

		.social_icon{
			position: absolute;
			right: 20px;
			top: -45px;
		}

		.input-group-prepend span{
			width: 50px;
			background-color: #FFC312;
			color: black;
			border:0 !important;
		}

		input:focus{
			outline: 0 0 0 0  !important;
			box-shadow: 0 0 0 0 !important;

		}

		.remember{
			color: white;
		}

		.remember input
		{
			width: 20px;
			height: 20px;
			margin-left: 15px;
			margin-right: 5px;
		}

		.login_btn{
			color: black;
			background-color: #FFC312;
			width: 100px;
		}

		.login_btn:hover{
			color: black;
			background-color: white;
		}

		.links{
			color: white;
		}

		.links a{
			margin-left: 4px;
		}
	</style>
</head>
<body style='background: url("img/Leadership.jpg"); background-size: cover'>

	<div class="container">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
				<div class="card-header">
					<div class=" justify-content-between">
						<h3 class="text-light text-center"><img src="http://nurulabsar.com/img/MS-Hazi-and-Sons.png" alt="" style="width:300px;"></h3>
					</div>
					<h3 class="pt-2 text-center font-weight-bold text-dark">Login</h3>

				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<form action="" method="post">
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" name="username" class="form-control" placeholder="username" value="">

								</div>
								<div class="input-group form-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-key"></i></span>
									</div>
									<input type="password" name="password" class="form-control" placeholder="password" value="">
								</div>
								<div class="form-group pb-5">
									<input type="submit" name="submit" value="Login" class="btn float-right login_btn">
								</div>
							</form>
						</div>
					</div>

					<div class="row my-5">
						<?php 
						if (isset($error)) {
							?>
						<div class="col-md-12 alert alert-danger"><?php echo $error; ?></div>

							<?php
						}
						 ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>