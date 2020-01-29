<?php 
$user_id    = Session::get("user_id");
$user_type  = Session::get("user_type");
$user_name  = Session::get("username");
$password   = Session::get("password");

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

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      <li><a href="index.php"><i class="fa fa-home"></i> Home </a>
      </li>
      <?php 
      if (permission_check('important_setting')) {

        ?>
        <li><a><i class="fa fa-gear"></i> Important Settings <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php 
            if (permission_check('company_profile_setting')) {
              ?>
              <li><a href="profile_setting.php"><i class="fas fa-user-circle"></i> Company Profile Setting</a></li>
              <?php 
            }
            if (permission_check('sales_zone_setting')) {
              ?>
              <li><a href="zone_setting.php"><i class="fas fa-user-circle"></i>Sales Zone Setting</a></li>
              <?php 
            }
            if (permission_check('sales_area_setting')) {
              ?>
              <li><a href="area_setting.php"><i class="fas fa-map-marker-alt"></i> Sales Area Setting</a></li>
              <?php 
            }
            if (permission_check('product_category_setting')) {
              ?>
              <li><a href="category.php"><i class="fas fa-route"></i> Product Category Setting</a></li>
              <?php 
            }
            if (permission_check('customer_category_setting')) {
              ?>
              <li><a href="customer_category.php"><i class="fas fa-user"></i> Customer Category Setting</a></li>
              <?php 
            }
            if (permission_check('add_system_user')) {
              ?>
              <li><a href="add_user.php"><i class="fas fa-users-cog"></i> Add System User</a></li>
              <?php 
            }
            if (permission_check('expense_head')) {
            ?>
            <li><a href="expense_head.php"><i class="fas fa-users-cog"></i> Expense Head</a></li>
             <?php 
            }
            ?>
            
          </ul>
        </li>
      <?php } ?>

      <?php 
      if (permission_check('ware_house')) {
        ?>
        <li><a><i class="fa fa-home"></i> Ware House <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php 
            if (permission_check('ware_house_info')) {
              ?>
              <li><a href="ware_house.php"><i class="fas fa-list-ul"></i> Ware House Info</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } 
      if (permission_check('company')) {

        ?>

        <li><a><i class="fa fa-university"></i> Company <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <?php 
            if (permission_check('company_information')) {

              ?>
              <li><a href="company.php"><i class="fas fa-list-ul"></i> Company Info</a></li>
            <?php }

            ?>
          </ul>
        </li>
      <?php }
      
      if (permission_check('employee')) {

        ?>
        <li><a><i class="fa fa-user"></i>Employee <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
           <?php 
           if (permission_check('add_employee')) {
            ?>
            <li><a href="add_employee.php"><i class="fas fa-plus-circle"></i> Add Employee</a></li>
            <?php 
          }
          if (permission_check('employee_list')) {
            ?>
            <li><a href="employee_list.php"><i class="fas fa-list-ul"></i> Employee List</a></li>
            <?php 
          }
          if (permission_check('sales_man')) {
            ?>
            <li><a href="employee_duty.php"><i class="fas fa-location-arrow"></i> Sales Man </a></li>
          <?php } 

          if (permission_check('delivery_man')) {
            ?>
            <li><a href="delivery_employee.php"><i class="fas fa-location-arrow"></i> Delivery Man </a></li>
          <?php } 

          if (permission_check('own_shop_employee')) {
            ?>
            <li><a href="own_shop_employee.php"><i class="fas fa-location-arrow"></i> Own Shop Employee </a></li>
            <?php 
          }
          
          if (permission_check('attendance_info')) {
            ?>
            <li><a href="employee_attendance.php"><i class="fab fa-angellist"></i> Attendance</a></li>
            <?php 
          }
          if (permission_check('attendance_info')) {
            ?>

            <li><a href="employee_attendance_list.php"><i class="fab fa-angellist"></i> Attendance Info</a></li>
            <?php 
          }
          ?>
        </ul>
      </li>
    <?php } 
    

    if (permission_check('customer')) {
      ?>
      <li><a><i class="fa fa-users"></i> Customers  <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <?php 
          if (permission_check('customer_info')) {
            ?>
            <li><a href="client.php"><i class="fas fa-list-ul"></i> Customer Info</a></li>
          <?php }
          ?>
          <!-- <li><a href="best_worst_customer.php"><i class="fas fa-list-ul"></i> Best/Worst Customer</a></li> -->
        </ul>
      </li>
    <?php } 
    

    if (permission_check('transport')) {
      ?>
      <li><a><i class="fas fa-bus-alt"></i> Transport <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
        <?php
        if (permission_check('transport_info')) {
          ?>
          <li><a href="transport.php"><i class="fas fa-car"></i> Transport Info</a></li>
          <?php 
            }
          if (permission_check('truck_load_for_delivery')) {
            ?>
            <li><a href="truck_load.php"><i class="fas fa-arrow-right"></i> Truck Load For Delivery</a></li>
            <?php 
          }
          if (permission_check('unload_truck')) {
          ?>
          <li><a href="truck_unload.php"><i class="fas fa-arrow-left"></i> Unload Truck After Delivery</a></li>  
          <?php
          }
          if (permission_check('take_back_market_product_return')) {
            ?>
            <li><a href="store_market_return_product.php"><i class="fas fa-arrow-left"></i> Take Back Market Return Product</a></li>
            <?php 
          }
          ?>
        </ul>
      </li>
      <?php 
    }
    if (permission_check('offer_setup')) {
      ?>

      <li><a href="offer_setup.php"><i class="fas fa-map-marker-alt"></i> Offer Setup</a></li>

      <?php
    } 
    if (permission_check('product')) {
      ?>

      <li><a><i class="fa fa-folder-open"></i> Product <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <?php 
          if (permission_check('add_product')) {
            ?>
            <li><a href="add_product.php"><i class="fas fa-plus-circle"></i> Add Product</a></li>

            <?php 
          }
          if (permission_check('stock_list')) {
            ?>
            <li><a href="stock_list.php"><i class="fas fa-plus-circle"></i> Stock List</a></li>
            <?php
          }
          if (permission_check('company_wise_product_list')) {
            ?>
            <li><a href="companywise_prosuct_list.php"><i class="fas fa-list-ul"></i> Companywise Product List</a></li>
          <?php } 
          if (permission_check('company_product_return')) {
            ?>
            <li><a href="company_product_return.php"><i class="fas fa-stream"></i> Company Products Return</a></li>
          <?php } 

          if (permission_check('product_wise_stock_report')) {
            ?>
            <li><a href="productwise_stock_report.php"><i class="fas fa-scroll"></i> Productwise stock Report</a></li>
          <?php } 
          if (permission_check('add_offer_product')) {
            ?>
          <!-- <li><a href="add_offer_product.php"><i class="fas fa-plus-circle"></i> Add Offer Product</a></li> -->
           <?php } ?>
        </ul>
      </li>
    <?php } 
    

    if (permission_check('own_shop')) {
      ?>
      <li><a><i class="fa fa-users"></i> Own Shop  <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
        <?php
          if (permission_check('stock_product_to_shop')) {
        ?>
          <li><a href="stock_product_to_shop.php"><i class="fas fa-list-ul"></i> stock product to shop</a></li>
          <?php
          }
          if (permission_check('own_shop_products')) {
        ?>
          <li><a href="own_shop_products.php"><i class="fas fa-list-ul"></i> Shop Products</a></li>
          <?php 
          }
          if (permission_check('sale_product')) {
            ?>
            <li><a href="sale_product.php"><i class="fas fa-list-ul"></i> Sale Product</a></li>
            <?php 
          }
         
         
          if (permission_check('sales_list')) {
            ?>
            <li><a href="sales.php"><i class="fas fa-list-ul"></i> Sales List</a></li>
            <?php 
          }
          if (permission_check('own_shop_customer_list')) {
            ?>
            <li><a href="customer_list.php"><i class="fas fa-list-ul"></i> Customer List</a></li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>

    <!-- Market side bar oprions -->

    <?php 
    if (permission_check('order_and_delivery')) {
      ?>
      <li><a><i class="fa fa-thumb-tack"></i> Order & Delivery <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">


          <?php

          if (permission_check('new_order')) {
            ?>
            <li><a href="new_order.php"><i class="fas fa-list-ul"></i> New Order</a></li>
          <?php } 

          if (permission_check('paid_and_delivered')) {
            ?>
            <li><a href="delivery_complete.php"><i class="fas fa-arrow-right"></i> Paid & Delivered</a></li>
          <?php } 
          if (permission_check('unpaid_but_delivered')) { ?>
            <li><a href="unpaid_but_delivered.php"><i class="fas fa-arrow-right"></i> Unpaid But Delivered</a></li>

          <?php } 
          if (permission_check('return_sold_product_from_market')) {
            ?>
            <li><a href="market_return_product.php"><i class="fas fa-arrow-left"></i> Return Sold Products From Market </a></li>
          <?php } ?>
          <?php  if (permission_check('print_money_receipt')) { ?>
            <li><a href="money_receipt.php"><i class="fas fa-print"></i> Print Money Receipt </a></li>
          <?php }
          if (permission_check('money_receipt_list')) {
            ?>
            <li><a href="money_receipt_list.php"><i class="fas fa-list"></i> Money Receipt List</a></li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>


    <!-- account side bar oprions -->

    <?php 
    if (permission_check('account')) {
      ?>
      <li><a><i class="fa fa-dollar (alias)"></i> Account <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">

          <?php 
          if (permission_check('add_account')) {
            ?>
            <li><a href="add_account.php"><i class="fas fa-plus"></i> Add Account</a></li>
          <?php } 
          if (permission_check('add_bank_deposite')) {
            ?>
            <li><a href="add_bank_deposite.php"><i class="fas fa-plus-circle"></i> Add Bank Deposite</a></li>
          <?php } 
          if (permission_check('add_bank_withdraw')) {
            ?>
            <li><a href="add_bank_withdraw.php"><i class="fas fa-plus-square"></i> Add Bank Withdraw</a></li>
          <?php } 
          if (permission_check('add_bank_loan')) {
            ?>
            <li><a href="add_bank_loan.php"><i class="fas fa-plus-square"></i> Add Bank loan</a></li>
          <?php } 

          if (permission_check('add_invoice')) {
            ?>
            <li><a href="add_invoice.php"><i class="fas fa-plus"></i> Add Invoice</a></li>
          <?php } 
          if (permission_check('view_invoice_list')) {
            ?>

            <li><a href="view_invoice_list.php"><i class="fas fa-eye"></i> View Invoice List</a></li>
          <?php } 

          if (permission_check('company_comission')) {
            ?>
            <li><a href="company_comission.php"><i class="fas fa-arrow-circle-left"></i> Company Comission</a></li>
          <?php } 
          if (permission_check('employee_comission')) {
            ?>
            <li><a href="employee_comission.php"><i class="fas fa-arrow-circle-left"></i> Employee Comission</a></li>
          <?php } 

          if (permission_check('employee_payments')) {
            ?>
            <li><a href="employee_payments.php"><i class="fas fa-arrow-circle-right"></i> Employee Payments</a></li>
          <?php }

          if (permission_check('cash_balance')) {
            ?>
            <li><a href="cash_balance.php"><i class="fas fa-coins"></i> Cash Balance</a></li>
          <?php } 

          if (permission_check('expense')) {
            ?>
            <li><a href="expense.php"><i class="fas fa-coins"></i> Expense</a></li>
          <?php } 

          if (permission_check('receive')) {
            ?>
            <li><a href="receive.php"><i class="fas fa-coins"></i> Receive</a></li>
          <?php } ?>

        </ul>
      </li>

    <?php } ?>


    <!--  the following section is for report  -->


    <?php 
    if (permission_check('reports')) {
      ?>

      <li><a><i class="fa fa-gear"></i> Reports <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">

         <?php
         if (permission_check('account_report')) {
          ?>
          <li><a href="accounts_report.php"><i class="fas fa-dollar"></i> Accounts Report</a></li>
        <?php } 
        if (permission_check('ware_house_wise_report')) {
        ?>

        <li><a href="ware_house_wise_report.php"><i class="fas fa-user"></i> Ware House Wise Report</a></li>
          <?php } 
        if (permission_check('area_wise_report')) {
        ?>
        <li><a href="area_wise_report.php"><i class="fas fa-user"></i> Area Wise Report</a></li>
          <?php } 
        if (permission_check('employee_report')) {
        ?>
        <li><a href="employee_report.php"><i class="fas fa-user"></i> Employee Wise Report</a></li>
          <?php } 
          if (permission_check('customer_report')) {
            ?>
          <li><a href="customer_report.php"><i class="fas fa-users-cog"></i> Customers Report</a></li>
          <?php
        } 
          if (permission_check('transport_report')) {
            ?>
          <li><a href="Transport_report.php"><i class="fas fa-users-cog"></i> Transport Report</a></li>
          <?php
        }
        if (permission_check('own_shop_report')) {
        ?>
        <li><a href="own_shop_report.php"><i class="fas fa-user"></i> Own Shop Report</a></li>
          <?php } 
        ?>
      </ul>
    </li>




    <?php 
  }
  if (permission_check('add_role')) {
    ?>
    <li><a><i class="fas fa-scroll"></i> Role <span class="fa fa-chevron-down"></span></a>
      <ul class="nav child_menu">
        <?php 
        if (permission_check('add_role_button')) {
          ?>
          <li><a href="add_role.php"><i class="fas fa-plus"></i> Add Role</a></li>
          <?php 
        }
        ?>
      </ul>
    </li>
  <?php }  ?>




</ul>
</div>
</div>
<!-- /sidebar menu -->
<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
  <a data-toggle="tooltip" data-placement="top" title="Settings">
    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Lock">
    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
  </a>
</div>
  <!-- /menu footer buttons -->