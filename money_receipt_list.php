<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('money_receipt_list')){
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
          <h2>List Of Printed Money Receipt</h2>
          <div class="row float-right" align="right">
           
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">RS No.</th>
                <th style="text-align: center;">Employee Id</th>
                <th style="text-align: center;">Employee Name</th>
                <th style="text-align: center;">Total Amount</th>
                <th style="text-align: center;">From</th>
                <th style="text-align: center;">To</th>
                <th style="text-align: center;">Print Date</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              
              $query = "SELECT * FROM money_receipt_main_tbl ORDER BY serial_no DESC";
              $receipt_info = $dbOb->select($query);
              if ($receipt_info) {
                $i=0;
                while ($row = $receipt_info->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['receipt_no']; ?></td>
                    <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><?php echo $row['total_amount']; ?></td>
                    <td><?php echo $row['from_date']; ?></td>
                    <td><?php echo $row['to_date']; ?></td>
                    <td><?php echo $row['printing_date'].' ('.$row['printing_time'].')'; ?></td>
                    
                    <td align="center">

                     
                        <a  class="badge bg-blue view_date" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">View Receipt</a> 
                     

                      
                        
                         
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
            <h3 class="modal-title" id="ModalLabel" style="color: white">Money Receipt</h3>
            <div style="float:right;">

            </div>
          </div>
          <div class="modal-body">

          
             
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

    $(document).on('click','.view_date',function(){

      var serial_no = $(this).attr("id");

      $.ajax({
        url:"ajax_show_money_receipt.php",
        data:{serial_no:serial_no},
        type:"POST",
        dataType:'json',
        success:function(data){
        
        $(".modal-body").html(data);

        }
      });

    });




  }); // end of document ready function 
  function printContent(el){
    var a = document.body.innerHTML;
    var b = document.getElementById(el).innerHTML;
    document.body.innerHTML = b;
    window.print();
    document.body.innerHTML = a;

    return window.location.reload(true);

  }

</script>

</body>
</html>