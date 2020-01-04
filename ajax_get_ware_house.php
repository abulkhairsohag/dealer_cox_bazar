<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');

include_once("class/Database.php");
$dbOb = new Database();

  if (isset($_POST['zone_serial_no'])) {
      $option = '';

    $zone_serial_no = $_POST['zone_serial_no'];
  $query = "SELECT * FROM zone WHERE serial_no = '$zone_serial_no'";
  $get_zone = $dbOb->find($query);
  $ware_house_serial_no = '';
  if ($get_zone) {
      $ware_house_serial_no = $get_zone['ware_house_serial_no'];
  }
  $query = "SELECT * FROM ware_house WHERE serial_no = '$ware_house_serial_no'";
  $get_ware_house = $dbOb->select($query);
  $ware_house_name = '';
  if ($get_ware_house) {
      $ware_house = $get_ware_house->fetch_assoc();
      $ware_house_name = $ware_house['ware_house_name'];
      $option = '<option value="'.$ware_house_serial_no.'">'.$ware_house_name.'</option>';
  }else{
     $option = '<option value="">Ware House Not Assigned</option>';
  }
  die(json_encode($option));
 } // end of  if (isset($_POST['submit']))
 ?>