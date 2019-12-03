<?php include_once('include/header.php'); ?>

<?php 
if(!permission_check('printed_summery_list')){
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
          <h2>List Of Printed Summery</h2>
          <div class="row float-right" align="right">
           
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>

              <tr>
                <th style="text-align: center;">Sl No.</th>
                <th style="text-align: center;">Summery No.</th>
                <th style="text-align: center;">Delivery Man's<br> ID & Name</th>
                <th style="text-align: center;">Phone No Of<br>Delivery Man</th>
                <th style="text-align: center;">Area</th>
                <th style="text-align: center;">Printing Date & <br> Time</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>


            <tbody id="data_table_body">
              <?php 
              
              $query = "SELECT * FROM order_summery ORDER BY serial_no DESC";
              $summery_info = $dbOb->select($query);
              if ($summery_info) {
                $i=0;
                while ($row = $summery_info->fetch_assoc()) {
                  $i++;
                  ?>
                  <tr>
                    <td class="text-center"><?php echo $i; ?></td>
                    <td><?php echo $row['summery_id']; ?></td>
                    <td><?php echo $row['deliv_emp_id'].'<br>'.$row['deliv_emp_name']; ?></td>
                    <td><?php echo $row['deliv_emp_phone']; ?></td>
                    <td><?php echo $row['area']; ?></td>
                    <td><?php echo $row['printing_date'].'<br>'.$row['printing_time']; ?></td>
                    <td align="center">
                        <a  class="badge bg-blue view_date" id="<?php echo($row['serial_no']) ?>"   data-toggle="modal" data-target="#add_update_modal" style="margin:2px">View & Print</a> 
                         
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
            <h3 class="modal-title" id="ModalLabel" style="color: white">Order Summery Information</h3>
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
        url:"ajax_show_summery.php",
        data:{serial_no:serial_no},
        type:"POST",
        dataType:'html',
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