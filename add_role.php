<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('add_role')){
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
          <h2>Role List </h2>
          <div class="row float-right" align="right">
            <?php 
            if (permission_check('add_role_button')) {
          ?>
            <a href="#" class="btn btn-primary" id="add_data" data-toggle="modal" data-target="#add_update_modal"> <span class="badge"><i class="fa fa-plus"> </i></span> Add New Role</a>
            <?php } ?> 
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th  style="text-align: center;">Sl No.</th>
                <th  style="text-align: center;">Role Name</th>
                <th  style="text-align: center;">Provided Permissions</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              include_once("class/Database.php");
              $dbOb = new Database();
              $query = "SELECT * FROM role ORDER BY serial_no DESC";
              $get_role = $dbOb->select($query);
              if ($get_role) {
                $i = 0;
                while ($row = $get_role->fetch_assoc()) {
                  $i++;
                  ?>

                  <tr id="table_row_<?php echo $row['serial_no'] ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['role_name'] ?></td>
                    <td>
                      <?php 
                      $role_id = $row['serial_no'];
                      $query = "SELECT * FROM role_has_permission where role_serial_no = '$role_id'";
                      $get_permission = $dbOb->select($query);
                      if ($get_permission) {

                        while ($permission = $get_permission->fetch_assoc()) {
                          $permission_serial_no = $permission['permission_serial_no'];
                          $query = "SELECT * FROM permission where serial_no = '$permission_serial_no'";
                          $permission_name = $dbOb->find($query);
                          $name1 = explode("_",$permission_name['permission_name']);
                              $final_name = ucwords(implode(" ",$name1));
                          ?>
                          <span class="badge badge-sm" style="margin-bottom: 2px;background: green">
                            <?php echo $final_name; ?>
                          </span>
                          <?php
                        }
                      }
                      ?>
                    </td>
                    <td align="center">
                     <?php 
                     if (permission_check('role_edit_button')) {
                      ?>
                      <a  class="badge bg-blue edit_data" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">Edit</a> 
                    <?php } ?>
                    <?php 
                    if (permission_check('role_delete_button')) {
                      ?>

                      <a  class="badge  bg-red delete_data" id="<?php echo($row['serial_no']) ?>"  style="margin:2px"> Delete</a> 
                    <?php } ?>  

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

                <div class="x_content" >
                  <br />

                  <!-- form starts from here  -->
                  <form id="form_edit_data" method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="role_name" name="role_name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Provie A Role Name">
                      </div>
                    </div>


                    <div class="form-group" style="margin-bottom: 30px" >
                      <h2 style="text-align: center;color: red">Select The Following Options To Give Permission </h2>

                      <label>
                        <input type="checkbox" id="all_checked"> <b style="margin-top: 0px; font-sixe:18px;color: red">SELECT ALL :</b>
                      </label>
                    </div>

<!-- Important Setting section -->

                    <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox"  id="important_setting"> <b style="margin-top: 0px; font-sixe:18px;color: red">Important Setting :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` limit 24";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);

                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="important_setting" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>


                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 169, 4";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);

                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="important_setting" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          $query = "SELECT * FROM `permission` LIMIT 180, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);

                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="important_setting" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div><hr>

<!-- Company section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="company"> <b style="margin-top: 0px; font-sixe:18px;color: red">Company :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 24, 6";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="company" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>


<!-- Employee section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="employee"> <b style="margin-top: 0px; font-sixe:18px;color: red">Employee :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 30, 16";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="employee" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          $query = "SELECT * FROM `permission` LIMIT 50, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="employee" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>

<!-- Customers section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="customer"> <b style="margin-top: 0px; font-sixe:18px;color: red">Customers :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 51, 6";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="customer" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>


<!-- Transport section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="transport"> <b style="margin-top: 0px; font-sixe:18px;color: red">Transports :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 64, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="transport" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }
                          $query = "SELECT * FROM `permission` LIMIT 69, 2";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="transport" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }
                          $query = "SELECT * FROM `permission` LIMIT 73, 2";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="transport" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          $query = "SELECT * FROM `permission` LIMIT 181, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="transport" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>


<!-- Product section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="product"> <b style="margin-top: 0px; font-sixe:18px;color: red">Products :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 75, 14";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="product" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>


<!-- Order & Delivery section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="order_and_delivery"> <b style="margin-top: 0px; font-sixe:18px;color: red">Order & Delivery :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 89, 21";
                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="order_and_delivery" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }
                          $query = "SELECT * FROM `permission` LIMIT 177, 2";
                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="order_and_delivery" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>



<!-- Account section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="account"> <b style="margin-top: 0px; font-sixe:18px;color: red">Account :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 110, 47";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="account" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>


<!-- Reports section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="reports"> <b style="margin-top: 0px; font-sixe:18px;color: red">Reports :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 157, 3";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="reports" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }
                          $query = "SELECT * FROM `permission` LIMIT 161, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="reports" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }
                          $query = "SELECT * FROM `permission` LIMIT 164, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="reports" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>

<!-- Role section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="role"> <b style="margin-top: 0px; font-sixe:18px;color: red">Role :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 165, 4";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="role" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>
    <!-- SMS section -->
                  <div class="row">
                      <div class="col-md-2">
                        <div class="checkbox">
                          <label class="text-uppercase">
                            <input type="checkbox" id="sms"> <b style="margin-top: 0px; font-sixe:18px;color: red">SMS :</b>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="row">

                          <?php 
                          include_once("class/Database.php");
                          $dbOb = new Database();

                          $query = "SELECT * FROM `permission` LIMIT 179, 1";

                          $get_permission = $dbOb->select($query);

                          if ($get_permission) {
                            while ($row = $get_permission->fetch_assoc()) {
                              $name = $row['permission_name'];
                              $name1 = explode("_",$name);
                              $final_name = implode(" ",$name1);
                              ?>

                              <div class="col-md-4">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="sms" value="<?php echo $row['serial_no'] ?>" id="checkbox_<?php echo $row['serial_no'] ?>" name="permission[]"> <?php echo ucwords($final_name); ?>
                                  </label>
                                </div>
                              </div>

                              <?php
                            }
                          }

                          ?>

                        </div>
                      </div>
                    </div>
                    <hr>


                    <div style="display: none;">
                      <input type="number" id="edit_id" name="edit_id">
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="reset" class="btn btn-primary" id="reset_btn">Reset</button>
                        <button type="submit" name="submit_button" class="btn btn-success" id="submit_button"></button>
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


  <!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){

// the following section is used to get data of the row where we click to edit and put them to the form 
$(document).on('click','.edit_data',function(){
  $('#role_name').val('');
  $('input[type="checkbox"]').prop('checked', false);
  $("#ModalLabel").html("Update Role And Permission Information.");
  $("#submit_button").html("Update");








  var serial_no = $(this).attr("id");
  $.ajax({
    url:'ajax_add_role.php',
    data:{serial_no_edit:serial_no},
    type: "POST",
    dataType: "json",
    success:function(data){
      $("#role_name").val(data.role.role_name);
      $("#edit_id").val(data.role.serial_no);
      $.each( data.permission, function( key, value ) {
        $('#checkbox_'+value).prop("checked", true);
      });
    }
  });
});

// the following section is used to change button name of modal and make the input fields empty every time
$(document).on('click','#add_data',function(){
  $("#ModalLabel").html("Provide Role And Permission Information.");
  $("#submit_button").html("Save");

  $("#role_name").val('');
  $('input[type="checkbox"]').prop('checked', false);
  $("#edit_id").val("");

});

// the following section is used to insert and update information 
$(document).on('submit','#form_edit_data',function(e){
  e.preventDefault();
  var formData = new FormData($("#form_edit_data")[0]);
  formData.append('submit','submit');







$('#submit_button').attr('disabled',true);
$('#submit_button').html('Saving Information <i class="fas fa-spinner fa-spin"></i>');
        $("#reset_btn").hide();





  $.ajax({
    url:'ajax_add_role.php',
    data:formData,
    type:'POST',
    dataType: 'json',
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
        $("#reset_btn").show();
        $('#submit_button').attr('disabled',false);
       $("#add_update_modal").modal("hide"); 
       get_data_table();
     }
   }
 });
});


// The following section is for deleting information
$(document).on('click','.delete_data',function(){
  var delete_id = $(this).attr("id");
  swal({
    title: "Are you sure To Delete?",
    text: "It Will Delete All Related Information",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {

      $.ajax({
        url:"ajax_add_role.php",
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
          get_data_table();
        }
      });

    } 
  });
});

// important_setting checkbox
$(document).on('change','#important_setting',function(){

  if (this.checked) {
    $('.important_setting').prop('checked', true);
  }else{
    $('.important_setting').prop('checked', false);
  }

});

// company checkbox
$(document).on('change','#company',function(){

  if (this.checked) {
    $('.company').prop('checked', true);
  }else{
    $('.company').prop('checked', false);
  }

});

// employee checkbox
$(document).on('change','#employee',function(){

  if (this.checked) {
    $('.employee').prop('checked', true);
  }else{
    $('.employee').prop('checked', false);
  }

});

// customer checkbox
$(document).on('change','#customer',function(){

  if (this.checked) {
    $('.customer').prop('checked', true);
  }else{
    $('.customer').prop('checked', false);
  }

});

// own_shop checkbox
$(document).on('change','#own_shop',function(){

  if (this.checked) {
    $('.own_shop').prop('checked', true);
  }else{
    $('.own_shop').prop('checked', false);
  }

});

// transport checkbox
$(document).on('change','#transport',function(){

  if (this.checked) {
    $('.transport').prop('checked', true);
  }else{
    $('.transport').prop('checked', false);
  }

});

// product checkbox
$(document).on('change','#product',function(){

  if (this.checked) {
    $('.product').prop('checked', true);
  }else{
    $('.product').prop('checked', false);
  }

});

// order_and_delivery checkbox
$(document).on('change','#order_and_delivery',function(){

  if (this.checked) {
    $('.order_and_delivery').prop('checked', true);
  }else{
    $('.order_and_delivery').prop('checked', false);
  }

});

// account checkbox
$(document).on('change','#account',function(){

  if (this.checked) {
    $('.account').prop('checked', true);
  }else{
    $('.account').prop('checked', false);
  }

});

// reports checkbox
$(document).on('change','#reports',function(){

  if (this.checked) {
    $('.reports').prop('checked', true);
  }else{
    $('.reports').prop('checked', false);
  }

});

// role checkbox
$(document).on('change','#role',function(){

  if (this.checked) {
    $('.role').prop('checked', true);
  }else{
    $('.role').prop('checked', false);
  }

});
// sms checkbox
$(document).on('change','#sms',function(){

  if (this.checked) {
    $('.sms').prop('checked', true);
  }else{
    $('.sms').prop('checked', false);
  }

});

// all_checked checkbox
$(document).on('change','#all_checked',function(){

  if (this.checked) {
    $('.important_setting').prop('checked', true);
    $('#important_setting').prop('checked', true);
    $('.company').prop('checked', true);
    $('#company').prop('checked', true);
    $('.employee').prop('checked', true);
    $('#employee').prop('checked', true);
    $('.customer').prop('checked', true);
    $('#customer').prop('checked', true);
    $('.own_shop').prop('checked', true);
    $('#own_shop').prop('checked', true);
    $('.transport').prop('checked', true);
    $('#transport').prop('checked', true);
    $('.product').prop('checked', true);
    $('#product').prop('checked', true);
    $('.order_and_delivery').prop('checked', true);
    $('#order_and_delivery').prop('checked', true);
    $('.account').prop('checked', true);
    $('#account').prop('checked', true);
    $('.reports').prop('checked', true);
    $('#reports').prop('checked', true);
    $('.role').prop('checked', true);
    $('#role').prop('checked', true);
    $('.sms').prop('checked', true);
    $('#sms').prop('checked', true);
  }else{
    $('.important_setting').prop('checked', false);
    $('#important_setting').prop('checked', false);
    $('.company').prop('checked', false);
    $('#company').prop('checked', false);
    $('.employee').prop('checked', false);
    $('#employee').prop('checked', false);
    $('.customer').prop('checked', false);
    $('#customer').prop('checked', false);
    $('.own_shop').prop('checked', false);
    $('#own_shop').prop('checked', false);
    $('.transport').prop('checked', false);
    $('#transport').prop('checked', false);
    $('.product').prop('checked', false);
    $('#product').prop('checked', false);
    $('.order_and_delivery').prop('checked', false);
    $('#order_and_delivery').prop('checked', false);
    $('.account').prop('checked', false);
    $('#account').prop('checked', false);
    $('.reports').prop('checked', false);
    $('#reports').prop('checked', false);
    $('.role').prop('checked', false);
    $('#role').prop('checked', false);
    $('.sms').prop('checked', false);
    $('#sms').prop('checked', false);
  }

});



});

// this function is defined to get thable data after insert upadate and deleting data
function get_data_table(){
  $.ajax({
    url:"ajax_add_role.php",
    data:{sohag:"sohag"},
    type:"POST",
    dataType:"text",
    success:function(data_tbl){

      sohag.destroy();
      $("#data_table_body").html(data_tbl);
      init_DataTables();
    }
  });
}
</script>

</body>
</html>
