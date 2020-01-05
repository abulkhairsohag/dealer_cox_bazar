       <!-- footer content -->
        <footer style="background-color: #2A3F54; color: white;" class="hidden-print">
          <div style="text-align: center;margin-top: -10px;margin-bottom: -16px">
            <a href="http://sattit.com/" style="color:white"><p style="">&copy; <?php echo date("Y"); ?> All Rights Reserved To SATT IT<p></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>

    <!-- select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="vendors/select2/dist/js/select2.min.js"></script>
     <!-- bootstrap-datetimepicker -->    
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
 <!-- Parsley -->
    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
   
    
  <!-- sweet alert -->
  <script src="src/js/sweet_alert.js"></script>
      <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- switchery -->
<script src="src/switchery.js"></script>

<!-- month peacker -->
<script src="src/monthpicker.js"></script>

<!-- switchery -->
<script>
    function switchery(){
      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html, { size: 'small' });
      });  
    }
    
</script>

<!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js" type="text/javascript"></script>
   <!-- Custom Theme Scripts -->
    <script src="build/js/custom.js"></script>

  <script>
  $( function() {
    $( ".datepicker" ).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth:true,
        changeYear:true,
        showAnim:'clip'

    });
    
    
  } );

  $( function() {
    $( ".datepicker2" ).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth:true,
        changeYear:true,
        showAnim:'clip'

    });
    
    
  } );

    $( function() {
    $( "#offer_end_date" ).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth:true,
        changeYear:true,
        showAnim:'clip'

    });
    
    
  } );


    $( function() {
    $( "#to_date" ).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth:true,
        changeYear:true,
        showAnim:'clip'

    });
    
    
  } );
    
    $(".select2").select2();
  </script>